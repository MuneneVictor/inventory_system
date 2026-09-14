<?php
session_start();
require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../config/db.php';
require __DIR__ . '/../includes/auth_check.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

$success = '';
$error = '';
$skippedSerials = [];
$invalidCategories = [];
$invalidDataErrors = [];

// Logged-in user's ID
$added_by = $_SESSION['user_id'];
$user_id = $_SESSION['user_id'];
$role = $_SESSION['role'];

// Only super_admin, inventory_admin, and manager can upload
if (!in_array($role, ['super_admin', 'inventory_admin', 'manager'])) {
    die("Access denied! Only administrators can upload devices.");
}

// Fetch user's branch from database
$stmt = $conn->prepare("SELECT branch FROM users WHERE id = :user_id");
$stmt->execute(['user_id' => $user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
$user_branch = $user['branch'] ?? 'KIMATHI';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['excel_file'])) {
    $fileTmpPath = $_FILES['excel_file']['tmp_name'];
    $fileName = $_FILES['excel_file']['name'];
    $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
    $allowedExtensions = ['xlsx', 'xls', 'csv'];

    if (!in_array($fileExtension, $allowedExtensions, true)) {
        $error = "Invalid file type. Please upload Excel file (.xlsx, .xls, .csv).";
    } else {
        try {
            $spreadsheet = IOFactory::load($fileTmpPath);
            $sheet = $spreadsheet->getActiveSheet();
            $rows = $sheet->toArray();
            if (empty($rows)) throw new Exception('The uploaded file is empty.');

            $header = array_map(static fn($h) => strtolower(trim((string)($h ?? ''))), $rows[0]);
            unset($rows[0]);

            // Exact final bulk-upload layout. Only the first three columns are mandatory per row.
            $requiredColumns = ['serial_number', 'category', 'specs', 'cargo_number', 'location', 'branch', 'place'];
            $missingColumns = array_diff($requiredColumns, $header);
            if (!empty($missingColumns)) {
                $error = "Missing columns: " . implode(', ', $missingColumns) .
                         ". Required layout: serial_number, category, specs, cargo_number, location, branch, place.";
            } else {
                $addedCount = $duplicateCount = $invalidDataCount = 0;

                $catStmt = $conn->query("SELECT id, category_name FROM categories");
                $categoriesRaw = $catStmt->fetchAll(PDO::FETCH_ASSOC);
                $catMap = [];
                foreach ($categoriesRaw as $cat) {
                    $catMap[strtolower(trim($cat['category_name']))] = ['id'=>$cat['id'], 'name'=>trim($cat['category_name'])];
                }

                // Read the actual DB default instead of duplicating it in PHP.
                $defaultStmt = $conn->query("SELECT COLUMN_DEFAULT FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'devices' AND COLUMN_NAME = 'cargo_number' LIMIT 1");
                $cargoDefault = $defaultStmt->fetchColumn();
                if ($cargoDefault === false || $cargoDefault === null) $cargoDefault = 'NO CARGO';

                // Additive migration check: old storage columns remain untouched for compatibility with existing pages.
                $colStmt = $conn->query("SHOW COLUMNS FROM devices LIKE 'secondary_storage_type'");
                $hasSecondaryStorage = (bool)$colStmt->fetch(PDO::FETCH_ASSOC);

                /*
                 * Build storage-type history once for this upload.
                 * This ONLY affects rows where Excel gives a single capacity but no SSD/HDD/NVMe type.
                 *
                 * Inference priority:
                 * 1. Same model + same capacity, but only when historical records agree on one type.
                 * 2. Same model across all capacities, but only when historical records agree on one type.
                 * 3. If history is missing or conflicting, leave storage_type unset so the DATABASE DEFAULT applies.
                 *
                 * Explicit SSD/HDD/NVMe in Excel always wins.
                 */
                $storageHistoryByModelCapacity = [];
                $storageHistoryByModel = [];

                $historyStmt = $conn->query("
                    SELECT
                        LOWER(TRIM(model_name)) AS model_key,
                        storage_capacity,
                        storage_type,
                        COUNT(*) AS type_count
                    FROM devices
                    WHERE model_name IS NOT NULL
                      AND TRIM(model_name) <> ''
                      AND storage_capacity IS NOT NULL
                      AND storage_type IN ('SSD','HDD')
                    GROUP BY LOWER(TRIM(model_name)), storage_capacity, storage_type
                ");

                foreach ($historyStmt->fetchAll(PDO::FETCH_ASSOC) as $historyRow) {
                    $modelKey = trim((string)$historyRow['model_key']);
                    $capacityKey = (int)$historyRow['storage_capacity'];
                    $typeKey = strtoupper((string)$historyRow['storage_type']);
                    $typeCount = (int)$historyRow['type_count'];

                    if ($modelKey === '' || !in_array($typeKey, ['SSD','HDD'], true)) {
                        continue;
                    }

                    if (!isset($storageHistoryByModelCapacity[$modelKey])) {
                        $storageHistoryByModelCapacity[$modelKey] = [];
                    }
                    if (!isset($storageHistoryByModelCapacity[$modelKey][$capacityKey])) {
                        $storageHistoryByModelCapacity[$modelKey][$capacityKey] = [];
                    }
                    $storageHistoryByModelCapacity[$modelKey][$capacityKey][$typeKey] =
                        ($storageHistoryByModelCapacity[$modelKey][$capacityKey][$typeKey] ?? 0) + $typeCount;

                    if (!isset($storageHistoryByModel[$modelKey])) {
                        $storageHistoryByModel[$modelKey] = [];
                    }
                    $storageHistoryByModel[$modelKey][$typeKey] =
                        ($storageHistoryByModel[$modelKey][$typeKey] ?? 0) + $typeCount;
                }

                $getUnambiguousStorageType = static function(array $typeCounts): ?string {
                    $knownTypes = [];
                    foreach (['SSD','HDD'] as $candidateType) {
                        if (($typeCounts[$candidateType] ?? 0) > 0) {
                            $knownTypes[] = $candidateType;
                        }
                    }

                    return count($knownTypes) === 1 ? $knownTypes[0] : null;
                };

                $parseCapacity = static function(string $value): ?int {
                    if (preg_match('/(\d+(?:\.\d+)?)\s*TB\b/i', $value, $m)) return (int)round(((float)$m[1]) * 1000);
                    if (preg_match('/(\d+(?:\.\d+)?)\s*GB\b/i', $value, $m)) return (int)round((float)$m[1]);
                    return null;
                };

                foreach ($rows as $rowIndex => $row) {
                    $rowPadded = array_pad($row, count($header), '');
                    $data = array_combine($header, $rowPadded);
                    $rowNumber = $rowIndex + 2;

                    $serial_number = trim((string)($data['serial_number'] ?? ''));
                    $categoryRaw = trim((string)($data['category'] ?? ''));
                    $specsRaw = trim((string)($data['specs'] ?? ''));
                    $cargoRaw = trim((string)($data['cargo_number'] ?? ''));
                    $locationRaw = trim((string)($data['location'] ?? ''));
                    $branchRaw = trim((string)($data['branch'] ?? ''));
                    $placeRaw = trim((string)($data['place'] ?? ''));
                    $priceRaw = trim((string)($data['price'] ?? ''));

                    if ($serial_number==='' && $categoryRaw==='' && $specsRaw==='' && $cargoRaw==='' && $locationRaw==='' && $branchRaw==='' && $placeRaw==='') continue;

                    $rowErrors = [];
                    if ($serial_number === '') $rowErrors[] = 'Serial number is empty';
                    if ($categoryRaw === '') $rowErrors[] = 'Category is empty';
                    if ($specsRaw === '') $rowErrors[] = 'Specs are empty';

                    $categoryKey = strtolower($categoryRaw);
                    $category_id = $catMap[$categoryKey]['id'] ?? null;
                    if ($categoryRaw !== '' && !$category_id) $rowErrors[] = "Category '$categoryRaw' not found";

                    $model_name = $processor = '';
                    $ram = null;               // null means: omit column and let DB default apply
                    $touch = 'N/A';
                    $graphics = null;          // null means: omit column and let DB default apply
                    $device_condition = null; // null means: omit column and let DB default apply
                    $storage_type = null;      // null means: omit column and let DB default apply
                    $storage_capacity = null;  // null means: omit column and let DB default apply
                    $secondary_storage_type = null;
                    $secondary_storage_capacity = null;

                    // Preferred structured specs:
                    // MODEL | PROCESSOR | RAM | STORAGE | TOUCH | GRAPHICS | DEVICE CONDITION
                    //
                    // Graphics and Device Condition are optional:
                    // blank / "-" => uploader omits those INSERT columns so the DATABASE DEFAULT is used.
                    // The older screenshot-style single text value is still accepted; in that form
                    // Graphics and Device Condition also fall back to their database defaults.
                    if (str_contains($specsRaw, '|')) {
                        $parts = array_map('trim', explode('|', $specsRaw));
                        $model_name = $parts[0] ?? '';
                        $processor = $parts[1] ?? '';
                        $ramRaw = $parts[2] ?? '';
                        $storageRaw = $parts[3] ?? '';
                        $touchRaw = $parts[4] ?? '';
                        $graphicsRaw = $parts[5] ?? '';
                        $conditionRaw = $parts[6] ?? '';

                        if ($graphicsRaw !== '' && $graphicsRaw !== '-') {
                            $graphics = $graphicsRaw;
                        }

                        if ($conditionRaw !== '' && $conditionRaw !== '-') {
                            $conditionKey = strtolower(trim($conditionRaw));
                            if (in_array($conditionKey, ['ex-uk', 'ex uk', 'exuk'], true)) {
                                $device_condition = 'Ex-Uk';
                            } elseif (in_array($conditionKey, ['refurbished', 'refurb', 'ref'], true)) {
                                $device_condition = 'Refurbished';
                            } elseif ($conditionKey === 'new') {
                                $device_condition = 'New';
                            } else {
                                $rowErrors[] = "Invalid device condition '$conditionRaw'. Use Ex-Uk, Refurbished, New, blank or -";
                            }
                        }
                    } else {
                        $working = preg_replace('/\s+/', ' ', trim($specsRaw));
                        $touchRaw = '';
                        if (preg_match('/\b(NON[- ]?TOUCH|TOUCH(?:SCREEN)?)\b\s*$/i', $working, $m)) {
                            $touchRaw = $m[1];
                            $working = trim(substr($working, 0, -strlen($m[0])));
                        }

                        // RAM is the GB value immediately before the storage portion.
                        if (preg_match('/\b(\d{1,3})\s*GB\b(?=\s+(?:\d+(?:\.\d+)?\s*(?:GB|TB)))/i', $working, $m, PREG_OFFSET_CAPTURE)) {
                            $ramRaw = $m[1][0] . 'GB';
                            $ramStart = $m[0][1];
                            $afterRam = trim(substr($working, $ramStart + strlen($m[0][0])));
                            $beforeRam = trim(substr($working, 0, $ramStart));
                            $storageRaw = $afterRam;

                            // Processor begins at the last recognizable Intel/AMD CPU marker.
                            if (preg_match('/\b((?:INTEL\s+)?CORE\s+I[3579][^|]*|(?:AMD\s+)?RYZEN\s+[3579][^|]*)$/i', $beforeRam, $pm, PREG_OFFSET_CAPTURE)) {
                                $processor = trim($pm[0][0]);
                                $model_name = trim(substr($beforeRam, 0, $pm[0][1]));
                            } else {
                                $rowErrors[] = 'Could not separate Model and Processor from specs. Use MODEL | PROCESSOR | RAM | STORAGE | TOUCH | GRAPHICS | DEVICE CONDITION for this row.';
                            }
                        } else {
                            $ramRaw = $storageRaw = '';
                            $rowErrors[] = 'Could not identify RAM and Storage from specs';
                        }
                    }

                    if ($model_name === '' || $model_name === '-') $rowErrors[] = 'Model is missing from specs';

                    // Processor is optional. Blank / "-" means omit the processor column and use the database default / NULL.
                    $processor = trim((string)($processor ?? ''));
                    if ($processor === '-') {
                        $processor = '';
                    }

                    // RAM is optional. Blank / "-" means omit the RAM column and use the database default.
                    $ramRaw = trim((string)($ramRaw ?? ''));
                    if ($ramRaw !== '' && $ramRaw !== '-') {
                        if (preg_match('/(\d{1,3})/', $ramRaw, $rm)) {
                            $parsedRam = (int)$rm[1];
                            if ($parsedRam < 1 || $parsedRam > 256) {
                                $rowErrors[] = "RAM '$ramRaw' is invalid";
                            } else {
                                $ram = $parsedRam;
                            }
                        } else {
                            $rowErrors[] = "RAM '$ramRaw' is invalid";
                        }
                    }

                    $touchKey = strtolower(str_replace([' ', '_'], '-', trim($touchRaw)));
                    if ($touchRaw === '' || $touchRaw === '-' || in_array($touchKey, ['n/a','na'], true)) $touch = 'N/A';
                    elseif (in_array($touchKey, ['touch','touchscreen','touch-screen'], true)) $touch = 'Touch';
                    elseif (in_array($touchKey, ['non-touch','nontouch'], true)) $touch = 'Non-touch';
                    else $rowErrors[] = "Invalid touch value '$touchRaw'";

                    /*
                     * Storage rules:
                     * - Blank / "-" => omit storage_type and storage_capacity; database defaults apply.
                     * - "256GB SSD" => explicit SSD.
                     * - "1TB HDD" => explicit HDD.
                     * - "256GB" => capacity is stored and the uploader first checks existing inventory:
                     *   same model + same capacity, then same model. It uses history only when one storage type is unambiguous.
                     *   If history is missing/conflicting, storage_type is omitted and the DATABASE DEFAULT decides the type.
                     * - Dual storage must state the type for EACH drive, e.g. "256GB SSD + 1TB HDD".
                     *   We do not guess drive types when two capacities are present.
                     */
                    $storageRaw = trim((string)($storageRaw ?? ''));
                    if ($storageRaw !== '' && $storageRaw !== '-') {
                        preg_match_all('/(\d+(?:\.\d+)?)\s*(GB|TB)(?:\s*(SSD|NVME|HDD))?/i', $storageRaw, $sm, PREG_SET_ORDER);

                        if (!$sm) {
                            $rowErrors[] = "Storage '$storageRaw' is invalid";
                        } else {
                            $drives = [];

                            foreach ($sm as $drive) {
                                $cap = strtoupper($drive[2]) === 'TB'
                                    ? (int)round(((float)$drive[1]) * 1000)
                                    : (int)round((float)$drive[1]);

                                if ($cap < 1 || $cap > 8000) {
                                    $rowErrors[] = "Storage capacity '{$drive[0]}' is invalid";
                                    continue;
                                }

                                $explicitType = isset($drive[3]) && trim((string)$drive[3]) !== ''
                                    ? strtoupper(trim((string)$drive[3]))
                                    : null;

                                if ($explicitType === 'NVME') {
                                    $explicitType = 'SSD';
                                }

                                $drives[] = [
                                    'type' => $explicitType,
                                    'capacity' => $cap
                                ];
                            }

                            if (count($drives) > 2) {
                                $rowErrors[] = 'A maximum of two storage drives is supported';
                            } elseif (count($drives) === 1) {
                                // Always store the provided capacity.
                                $storage_capacity = $drives[0]['capacity'];

                                if ($drives[0]['type'] !== null) {
                                    // Excel explicitly stated SSD/HDD/NVMe: always trust the file.
                                    $storage_type = $drives[0]['type'];
                                } else {
                                    /*
                                     * No type was supplied in Excel.
                                     * Infer only from UNAMBIGUOUS existing inventory history.
                                     * If history conflicts or does not exist, leave storage_type NULL so
                                     * the current devices.storage_type DATABASE DEFAULT is used.
                                     */
                                    $modelKey = strtolower(trim((string)$model_name));
                                    $capacityKey = (int)$storage_capacity;

                                    $sameModelCapacityHistory =
                                        $storageHistoryByModelCapacity[$modelKey][$capacityKey] ?? [];
                                    $storage_type = $getUnambiguousStorageType($sameModelCapacityHistory);

                                    if ($storage_type === null) {
                                        $sameModelHistory = $storageHistoryByModel[$modelKey] ?? [];
                                        $storage_type = $getUnambiguousStorageType($sameModelHistory);
                                    }
                                }
                            } elseif (count($drives) === 2) {
                                // With two drives, the uploader must know which is SSD/HDD.
                                if ($drives[0]['type'] === null || $drives[1]['type'] === null) {
                                    $rowErrors[] = "Dual storage '$storageRaw' must include SSD/HDD/NVMe for both drives (example: 256GB SSD + 1TB HDD)";
                                } else {
                                    if (!$hasSecondaryStorage) {
                                        $rowErrors[] = 'Dual storage detected, but the secondary-storage database migration has not been run';
                                    } else {
                                        // Compatibility rule: SSD remains the primary drive when present.
                                        usort(
                                            $drives,
                                            static fn($a, $b) =>
                                                ($a['type'] === 'SSD' ? 0 : 1) <=> ($b['type'] === 'SSD' ? 0 : 1)
                                        );

                                        $storage_type = $drives[0]['type'];
                                        $storage_capacity = $drives[0]['capacity'];
                                        $secondary_storage_type = $drives[1]['type'];
                                        $secondary_storage_capacity = $drives[1]['capacity'];
                                    }
                                }
                            }
                        }
                    }

                    // Optional price: if the Excel header/cell is missing or blank, leave devices.price unchanged/NULL.
                    $price = null;
                    if ($priceRaw !== '' && $priceRaw !== '-') {
                        $normalizedPrice = str_replace(',', '', $priceRaw);
                        if (!is_numeric($normalizedPrice) || (float)$normalizedPrice < 0) {
                            $rowErrors[] = "Invalid price '$priceRaw'. Use a number, blank or -";
                        } else {
                            $price = round((float)$normalizedPrice, 2);
                        }
                    }

                    $cargo_number = ($cargoRaw === '' || $cargoRaw === '-') ? $cargoDefault : $cargoRaw;
                    $location = ($locationRaw === '' || $locationRaw === '-') ? null : $locationRaw;

                    if ($branchRaw === '' || $branchRaw === '-') $branch = strtoupper((string)$user_branch);
                    else $branch = strtoupper($branchRaw);
                    if (!in_array($branch, ['KIMATHI','MOI','WAREHOUSE'], true)) $rowErrors[] = "Invalid branch '$branchRaw'. Use KIMATHI, MOI, WAREHOUSE or leave blank";

                    $place = null;
                    if ($placeRaw !== '' && $placeRaw !== '-') {
                        $placeKey = strtolower(str_replace([' ', '-'], '_', $placeRaw));
                        $placeMap = ['store'=>'store','display'=>'display','warehouse'=>'warehouse','under_repair'=>'under_repair','sold'=>'sold'];
                        if (!isset($placeMap[$placeKey])) $rowErrors[] = "Invalid place '$placeRaw'. Use store, display, warehouse, under_repair, sold or leave blank";
                        else $place = $placeMap[$placeKey];
                    }

                    if ($rowErrors) {
                        $invalidDataCount++;
                        $invalidDataErrors[] = "Row $rowNumber (SN: " . ($serial_number ?: 'N/A') . '): ' . implode('; ', $rowErrors);
                        continue;
                    }

                    $dup = $conn->prepare("SELECT 1 FROM devices WHERE serial_number=:serial LIMIT 1");
                    $dup->execute(['serial'=>$serial_number]);
                    if ($dup->fetchColumn()) { $duplicateCount++; $skippedSerials[]=$serial_number; continue; }

                    $columns = ['serial_number','category_id','model_name','touch','added_by','branch','cargo_number','location','place'];
                    $values = [':serial_number',':category_id',':model_name',':touch',':added_by',':branch',':cargo_number',':location',':place'];
                    $params = [
                        'serial_number'=>$serial_number,
                        'category_id'=>$category_id,
                        'model_name'=>$model_name,
                        'touch'=>$touch,
                        'added_by'=>$added_by,
                        'branch'=>$branch,
                        'cargo_number'=>$cargo_number,
                        'location'=>$location,
                        'place'=>$place
                    ];

                    // Optional price: only insert when supplied; otherwise omit the column entirely.
                    if ($price !== null) {
                        $columns[] = 'price';
                        $values[] = ':price';
                        $params['price'] = $price;
                    }

                    // Optional processor: omit completely when blank/"-" so the database default / NULL is used.
                    if ($processor !== '') {
                        $columns[] = 'processor';
                        $values[] = ':processor';
                        $params['processor'] = $processor;
                    }

                    // Optional RAM: omit completely when blank/"-" so the database default is used.
                    if ($ram !== null) {
                        $columns[] = 'ram';
                        $values[] = ':ram';
                        $params['ram'] = $ram;
                    }

                    // Optional storage:
                    // Capacity may be supplied without a type. In that case storage_type is omitted
                    // and MySQL uses the devices.storage_type database default.
                    if ($storage_capacity !== null) {
                        $columns[] = 'storage_capacity';
                        $values[] = ':storage_capacity';
                        $params['storage_capacity'] = $storage_capacity;
                    }
                    if ($storage_type !== null) {
                        $columns[] = 'storage_type';
                        $values[] = ':storage_type';
                        $params['storage_type'] = $storage_type;
                    }

                    // IMPORTANT: leave these columns out completely when blank/"-".
                    // This makes MySQL apply the actual defaults defined on devices.graphics
                    // and devices.device_condition instead of hard-coding a PHP fallback.
                    if ($graphics !== null) {
                        $columns[] = 'graphics';
                        $values[] = ':graphics';
                        $params['graphics'] = $graphics;
                    }
                    if ($device_condition !== null) {
                        $columns[] = 'device_condition';
                        $values[] = ':device_condition';
                        $params['device_condition'] = $device_condition;
                    }

                    if ($hasSecondaryStorage && $secondary_storage_capacity !== null) {
                        $columns[]='secondary_storage_type';
                        $columns[]='secondary_storage_capacity';
                        $values[]=':secondary_storage_type';
                        $values[]=':secondary_storage_capacity';
                        $params['secondary_storage_type']=$secondary_storage_type;
                        $params['secondary_storage_capacity']=$secondary_storage_capacity;
                    }
                    $insert = $conn->prepare("INSERT INTO devices (".implode(',', $columns).") VALUES (".implode(',', $values).")");
                    $insert->execute($params);

                    $log = $conn->prepare("INSERT INTO activity_logs (user_id, action, details) VALUES (:user_id,'Bulk upload',:details)");
                    $log->execute(['user_id'=>$added_by, 'details'=>"Added device $serial_number ($model_name) via Excel upload to branch: $branch"]);
                    $addedCount++;
                }

                $success = "$addedCount device(s) added successfully.";
                if ($duplicateCount) $success .= " $duplicateCount duplicate serial(s) were skipped.";
                if ($invalidDataCount) $success .= " $invalidDataCount row(s) were skipped due to invalid data.";
            }
        } catch (Throwable $e) {
            $error = "Error reading Excel file: " . $e->getMessage();
        }
    }
}

// Get all categories for the template example
$catStmt = $conn->prepare("SELECT category_name FROM categories ORDER BY category_name");
$catStmt->execute();
$allCategories = $catStmt->fetchAll(PDO::FETCH_COLUMN);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Bulk Upload Devices | Mombasa Computers</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        /* Your existing CSS (unchanged) */
        :root {
            --primary: #1a4b2a;
            --primary-light: #2a6b3a;
            --primary-dark: #0f3a1e;
            --gray-50: #f9fafb;
            --gray-100: #f3f4f6;
            --gray-200: #e5e7eb;
            --gray-300: #d1d5db;
            --gray-400: #9ca3af;
            --gray-500: #6b7280;
            --gray-600: #4b5563;
            --gray-700: #374151;
            --gray-800: #1f2937;
            --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
            --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1);
            --radius-sm: 0.375rem;
            --radius-md: 0.5rem;
            --radius-lg: 0.75rem;
            --radius-xl: 1rem;
            --font-sans: 'Inter', system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }

        @import url('https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,400;14..32,500;14..32,600;14..32,700&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: var(--font-sans);
            background: var(--gray-100);
            color: var(--gray-800);
            line-height: 1.5;
            overflow-x: hidden;
        }

        .main-content {
            padding: 2rem 2rem 1rem;
            margin-left: 260px;
            width: calc(100% - 260px);
            min-height: 100vh;
            background: var(--gray-100);
            transition: margin-left 0.3s ease, width 0.3s ease, padding 0.3s ease;
            overflow-x: hidden;
            max-width: 100%;
        }

        .page-header {
            background: white;
            padding: 1.5rem 2rem;
            border-radius: var(--radius-xl);
            margin-bottom: 1.5rem;
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--gray-200);
        }

        .page-header h1 {
            font-size: 1.75rem;
            color: var(--gray-800);
            font-weight: 600;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .page-header h1 i {
            color: var(--primary);
            font-size: 1.75rem;
        }

        .breadcrumb {
            color: var(--gray-500);
            font-size: 0.9rem;
        }

        .breadcrumb a {
            color: var(--primary);
            text-decoration: none;
        }

        .alert {
            padding: 1rem 1.25rem;
            border-radius: var(--radius-md);
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .alert-success {
            background: #ecfdf5;
            border: 1px solid #a7f3d0;
            color: #065f46;
        }

        .alert-error {
            background: #fef2f2;
            border: 1px solid #fecaca;
            color: #991b1b;
        }

        .alert i {
            font-size: 1.25rem;
        }

        .skipped-box {
            background: #fffbeb;
            border: 1px solid #fde68a;
            border-radius: var(--radius-lg);
            padding: 1rem 1.25rem;
            margin-bottom: 1.5rem;
            font-size: 0.85rem;
        }

        .skipped-box strong {
            color: #d97706;
            display: block;
            margin-bottom: 0.5rem;
        }

        .form-container {
            background: white;
            border-radius: var(--radius-xl);
            border: 1px solid var(--gray-200);
            overflow: hidden;
            box-shadow: var(--shadow-sm);
        }

        .card-header {
            background: var(--gray-50);
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid var(--gray-200);
        }

        .card-header h2 {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--gray-800);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .card-header h2 i {
            color: var(--primary);
        }

        .card-body {
            padding: 1.5rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            font-size: 0.875rem;
            font-weight: 500;
            color: var(--gray-700);
            margin-bottom: 0.5rem;
        }

        .form-group input[type="file"] {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid var(--gray-300);
            border-radius: var(--radius-md);
            font-size: 0.9rem;
            background: white;
        }

        .btn {
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: var(--radius-md);
            font-size: 0.9rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            font-family: var(--font-sans);
        }

        .btn-primary {
            background: var(--primary);
            color: white;
            width: 100%;
            justify-content: center;
        }

        .btn-primary:hover {
            background: var(--primary-light);
        }

        .btn-secondary {
            background: var(--gray-100);
            color: var(--gray-700);
            border: 1px solid var(--gray-300);
        }

        .info-box {
            background: var(--gray-50);
            border-radius: var(--radius-lg);
            padding: 1.25rem;
            margin-bottom: 1.5rem;
            border: 1px solid var(--gray-200);
        }

        .info-box h3 {
            font-size: 1rem;
            font-weight: 600;
            color: var(--gray-800);
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .info-box h3 i {
            color: var(--primary);
        }

        .info-box table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.85rem;
        }

        .info-box th,
        .info-box td {
            padding: 0.5rem;
            text-align: left;
            border-bottom: 1px solid var(--gray-200);
        }

        .info-box th {
            background: var(--gray-100);
            font-weight: 600;
            color: var(--gray-600);
        }

        .info-box .required {
            color: #dc2626;
        }

        .info-box .optional {
            color: var(--gray-400);
            font-weight: normal;
        }

        .template-example {
            background: #1e293b;
            color: #e2e8f0;
            padding: 1rem;
            border-radius: var(--radius-md);
            font-family: monospace;
            font-size: 0.8rem;
            overflow-x: auto;
            margin-top: 1rem;
        }

        .footer {
            text-align: center;
            padding: 1.5rem 0 0.5rem;
            margin-top: 1.5rem;
            font-size: 0.85rem;
            color: var(--gray-400);
            border-top: 1px solid var(--gray-200);
        }

        @media (max-width: 1200px) {
            .main-content {
                margin-left: 0 !important;
                width: 100% !important;
                padding: 1.5rem 1rem 1rem !important;
                padding-top: 5rem !important;
            }
        }

        @media (max-width: 768px) {
            .main-content {
                padding: 1rem 0.75rem 0.75rem !important;
                padding-top: 4.5rem !important;
            }

            .page-header h1 {
                font-size: 1.25rem;
            }

            .page-header {
                padding: 1rem 1.25rem;
            }

            .card-header {
                padding: 1rem 1.25rem;
            }

            .card-body {
                padding: 1.25rem;
            }

            .info-box {
                padding: 1rem;
            }

            .info-box table {
                font-size: 0.75rem;
            }
        }

        @media (max-width: 480px) {
            .main-content {
                padding: 0.75rem 0.5rem 0.5rem !important;
                padding-top: 4rem !important;
            }

            .page-header h1 {
                font-size: 1.1rem;
            }
        }
    </style>
</head>
<body>
<?php include "../includes/sidebar.php"; ?>
<div class="main-content">
    <div class="page-header">
        <h1>
            <i class="fas fa-file-upload"></i>
            Bulk Upload Devices
        </h1>
        <div class="breadcrumb">
              <?php if($_SESSION['role'] === 'super_admin'): ?>
                <a href="../dashboard/superadmindashboard"><i class="fas fa-home"></i> Dashboard</a>       
            <?php endif; ?>
            <?php if($_SESSION['role'] === 'manager'): ?>
                <a href="../dashboard/managerdashboard"><i class="fas fa-home"></i> Dashboard</a>
            <?php endif; ?>
            <?php if($_SESSION['role'] === 'inventory_admin'): ?>
                <a href="../dashboard/inventorydashboard"><i class="fas fa-home"></i> Dashboard</a>
            <?php endif; ?>
            <span> / </span>
            <a href="device_list">Devices</a>
            <span> / </span>
            <span>Bulk Upload</span>
        </div>
    </div>

    <?php if ($success): ?>
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i>
            <span><?= htmlspecialchars($success) ?></span>
        </div>
    <?php endif; ?>
    
    <?php if ($error): ?>
        <div class="alert alert-error">
            <i class="fas fa-exclamation-circle"></i>
            <span><?= htmlspecialchars($error) ?></span>
        </div>
    <?php endif; ?>
    
    <?php if (!empty($skippedSerials)): ?>
        <div class="skipped-box">
            <strong><i class="fas fa-ban"></i> Skipped Serial Numbers:</strong>
            <?= implode(', ', array_unique($skippedSerials)) ?>
        </div>
    <?php endif; ?>
    
    <?php if (!empty($invalidDataErrors)): ?>
        <div class="skipped-box">
            <strong><i class="fas fa-exclamation-triangle"></i> Data Validation Errors:</strong>
            <ul style="margin-top: 0.5rem; margin-left: 1.5rem;">
                <?php foreach ($invalidDataErrors as $err): ?>
                    <li><?= htmlspecialchars($err) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <div class="form-container">
        <div class="card-header">
            <h2>
                <i class="fas fa-table"></i>
                Upload Excel File
            </h2>
        </div>
        <div class="card-body">
            <!-- Simplified Upload Instructions -->
            <div class="info-box">
                <h3><i class="fas fa-info-circle"></i> Simplified Excel Format</h3>
                <p style="font-size:0.9rem; color:var(--gray-600); margin-bottom:1rem;">
                    Your Excel file uses the same <strong>7 required columns</strong> in this order: <strong>serial_number, category, specs, cargo_number, location, branch, place</strong>. You may also add an eighth <strong>price</strong> column. Price is optional, so existing 7-column files are still accepted. This uploader is for normal inventory only.
                </p>
                <table>
                    <thead>
                        <tr><th>Column</th><th>Required</th><th>What to enter</th></tr>
                    </thead>
                    <tbody>
                        <tr><td><strong>serial_number</strong></td><td class="required">Required</td><td>Unique device serial number</td></tr>
                        <tr><td><strong>category</strong></td><td class="required">Required</td><td><?= htmlspecialchars(implode(', ', $allCategories)) ?></td></tr>
                        <tr><td><strong>specs</strong></td><td class="required">Required</td><td>Model required; Processor, RAM, Storage, Touch, Graphics and Device Condition may be blank where unknown</td></tr>
                        <tr><td><strong>cargo_number</strong></td><td class="optional">Optional value</td><td>Blank uses the devices table default</td></tr>
                        <tr><td><strong>location</strong></td><td class="optional">Optional value</td><td>Blank is stored as NULL</td></tr>
                        <tr><td><strong>branch</strong></td><td class="optional">Optional value</td><td>Blank uses your logged-in branch</td></tr>
                        <tr><td><strong>place</strong></td><td class="optional">Optional value</td><td>Blank is stored as NULL</td></tr>
                        <tr><td><strong>price</strong></td><td class="optional">Optional column/value</td><td>Device price. The whole column may be omitted; blank or - leaves price as NULL</td></tr>
                    </tbody>
                </table>

                <div style="margin-top:1.25rem; padding:1rem; border:1px solid var(--gray-200); border-radius:var(--radius-md); background:white;">
                    <strong style="display:block; margin-bottom:.5rem;">Specs must follow this order:</strong>
                    <div class="template-example" style="margin-top:0;">
                        MODEL | PROCESSOR | RAM | STORAGE | TOUCH | GRAPHICS | DEVICE CONDITION
                    </div>
                    <p style="font-size:.82rem; color:var(--gray-600); margin-top:.8rem;">
                        Inside <strong>specs</strong>, use <strong>MODEL | PROCESSOR | RAM | STORAGE | TOUCH | GRAPHICS | DEVICE CONDITION</strong> for maximum reliability. Screenshot-style text is also accepted. For dual storage use, for example, <strong>256GB SSD + 1TB HDD</strong>.
                    </p>
                </div>
            </div>

            <div class="info-box">
                <h3><i class="fas fa-magic"></i> Automatic Defaults and Storage Detection</h3>
                <table>
                    <tbody>
                        <tr><td><strong>Cargo Number</strong></td><td>If blank or <strong>-</strong></td><td>Uses the database default</td></tr>
                        <tr><td><strong>Processor (inside specs)</strong></td><td>If blank or <strong>-</strong></td><td>Database default / NULL</td></tr>
                        <tr><td><strong>RAM (inside specs)</strong></td><td>If blank or <strong>-</strong></td><td>Database default / NULL</td></tr>
                        <tr><td><strong>Storage (inside specs)</strong></td><td>If blank or <strong>-</strong></td><td>Database defaults; unknown capacity remains NULL</td></tr>
                        <tr><td><strong>Storage type</strong></td><td>If capacity is given without SSD/HDD/NVMe</td><td>Checks existing inventory: same Model + Capacity, then same Model. Uses the result only when history agrees on one type; otherwise database default (currently SSD)</td></tr>
                        <tr><td><strong>Graphics (inside specs)</strong></td><td>If blank or <strong>-</strong></td><td>Database default</td></tr>
                        <tr><td><strong>Device Condition (inside specs)</strong></td><td>If blank or <strong>-</strong></td><td>Database default</td></tr>
                        <tr><td><strong>Location</strong></td><td>If blank or <strong>-</strong></td><td>NULL</td></tr>
                        <tr><td><strong>Branch</strong></td><td>If blank or <strong>-</strong></td><td>Your logged-in branch</td></tr>
                        <tr><td><strong>Place</strong></td><td>If blank or <strong>-</strong></td><td>NULL</td></tr>
                        <tr><td><strong>Price</strong></td><td>If column is omitted, blank or <strong>-</strong></td><td>Not inserted; device price remains NULL/database value</td></tr>
                    </tbody>
                </table>
                <p style="font-size:.82rem; color:var(--gray-600); margin-top:1rem;">
                    Inside <strong>specs</strong>, Graphics and Device Condition are optional. Use <strong>-</strong> or leave their position blank to use the actual database default. For example:
                    <strong>MODEL | PROCESSOR | RAM | STORAGE | TOUCH | - | -</strong>.
                </p>
                <p style="font-size:.82rem; color:var(--gray-600); margin-top:1rem;">
                    For one drive, use <strong>256GB SSD</strong> or <strong>1TB HDD</strong> when the type is known. If Excel contains only <strong>256GB</strong>, the uploader automatically checks existing inventory for the same <strong>Model + Capacity</strong>, then the same <strong>Model</strong>. It uses a detected type only when the historical records agree on one type. If there is no reliable history, the database default is used (currently SSD). If Storage is blank or <strong>-</strong>, both storage fields use their database defaults. For two drives, always state both types, for example <strong>256GB SSD + 1TB HDD</strong>. The primary drive continues to populate the existing <strong>storage_type</strong> and <strong>storage_capacity</strong> fields so your existing pages keep working; the second drive is stored in the secondary-storage fields.
                </p>
            </div>

            <!-- Template Example -->
            <div class="info-box">
                <h3><i class="fas fa-file-alt"></i> Sample Excel Template</h3>
                <div class="template-example">
                    serial_number | category | specs | cargo_number | location | branch | place | price <span class="optional">(optional)</span><br>
                    2158514153 | Laptop | MICROSOFT SURFACE PRO 7+ | INTEL CORE i5-11TH GEN | 8GB | 128GB SSD | TOUCH | - | - | CX37 | KIM.DIS.1 | KIMATHI | display<br><br>
                    HX1PZD3 | Laptop | DELL LATITUDE 7210 2-IN-1 | INTEL CORE i7-10TH GEN | 16GB | 256GB SSD + 1TB HDD | TOUCH | INTEL UHD GRAPHICS | REFURBISHED | C8 | KIM.DIS.1 | KIMATHI | display | 85000
                </div>
                <p style="margin-top: 0.75rem; font-size: 0.8rem; color: var(--gray-500);">
                    <i class="fas fa-download"></i>
                    <a href="#" id="downloadTemplate" style="color: var(--primary); text-decoration: none;">Download CSV Template (Price Optional)</a>
                </p>
                <p style="margin-top:.65rem; font-size:.78rem; color:var(--gray-500);">
                    The original seven Excel columns must exist in the header. The price column is optional and may be omitted completely. Cargo Number, Location, Branch, Place and Price may have blank cells. Blank Branch uses your logged-in branch; blank Location and Place are stored as NULL; blank Price is not inserted.
                </p>
            </div>

            <form method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label><i class="fas fa-file-excel"></i> Select Excel File (.xlsx, .xls, .csv)</label>
                    <input type="file" name="excel_file" accept=".xlsx,.xls,.csv" required>
                    <p style="font-size: 0.75rem; color: var(--gray-500); margin-top: 0.5rem;">
                        Maximum file size: 10MB
                    </p>
                </div>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-upload"></i> Upload & Process
                </button>
            </form>
        </div>
    </div>

    <div class="footer">
        <i class="fas fa-copyright"></i> <?= date('Y'); ?> Mombasa Computers
    </div>
</div>

<script>
// Mobile responsive adjustments
document.addEventListener('DOMContentLoaded', function() {
    function adjustMainContent() {
        const mainContent = document.querySelector('.main-content');
        const sidebar = document.querySelector('.sidebar');
        
        if (window.innerWidth <= 1200) {
            if (mainContent) {
                mainContent.style.marginLeft = '0';
                mainContent.style.width = '100%';
                mainContent.style.paddingTop = '5rem';
            }
        } else {
            if (mainContent && sidebar) {
                mainContent.style.marginLeft = '260px';
                mainContent.style.width = 'calc(100% - 260px)';
                mainContent.style.paddingTop = '';
            }
        }
    }
    
    adjustMainContent();
    window.addEventListener('resize', adjustMainContent);
    window.addEventListener('orientationchange', adjustMainContent);
    
    // Download template functionality
    document.getElementById('downloadTemplate').addEventListener('click', function(e) {
        e.preventDefault();

        const csvContent =
            'serial_number,category,specs,cargo_number,location,branch,place,price\n' +
            '2158514153,Laptop,"MICROSOFT SURFACE PRO 7+ | INTEL CORE i5-11TH GEN | 8GB | 128GB SSD | TOUCH | - | -",CX37,KIM.DIS.1,KIMATHI,display,85000\n' +
            'HX1PZD3,Laptop,"DELL LATITUDE 7210 2-IN-1 | INTEL CORE i7-10TH GEN | 16GB | 256GB SSD + 1TB HDD | TOUCH | INTEL UHD GRAPHICS | REFURBISHED",C8,KIM.DIS.1,KIMATHI,display,\n' +
            'ABC9012DEF,Laptop,"Dell Latitude 5420 | Core i5 11th Gen | 8GB | 256GB SSD | Non-touch | - | -",,,,store,';

        const blob = new Blob([csvContent], { type: 'text/csv' });
        const url = URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = 'device_upload_template.csv';
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
        URL.revokeObjectURL(url);
    });
});
</script>

</body>
</html>