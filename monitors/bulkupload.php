<?php
session_start();

require_once "../config/db.php";
require_once "../includes/auth_check.php";
require_once "../vendor/autoload.php";

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;

if (!in_array($_SESSION['role'] ?? '', ['super_admin', 'inventory_admin', 'manager'], true)) {
    die("ACCESS DENIED.");
}

$user_id = (int)($_SESSION['user_id'] ?? 0);
$user_role = (string)($_SESSION['role'] ?? '');

$stmt = $conn->prepare("SELECT branch FROM users WHERE id = ? LIMIT 1");
$stmt->execute([$user_id]);
$current_user = $stmt->fetch(PDO::FETCH_ASSOC) ?: [];
$user_branch = $current_user['branch'] ?? null;

if (!$user_branch) {
    die("Your account has no branch assigned.");
}

// Read the real database definition for size_inches.
// Blank Excel sizes can only be omitted safely when the column allows NULL
// or has a database default.
$sizeColStmt = $conn->query("
    SELECT IS_NULLABLE, COLUMN_DEFAULT
    FROM INFORMATION_SCHEMA.COLUMNS
    WHERE TABLE_SCHEMA = DATABASE()
      AND TABLE_NAME = 'monitors'
      AND COLUMN_NAME = 'size_inches'
    LIMIT 1
");
$sizeColumn = $sizeColStmt->fetch(PDO::FETCH_ASSOC) ?: [];
$sizeAllowsNull = strtoupper((string)($sizeColumn['IS_NULLABLE'] ?? 'NO')) === 'YES';
$sizeHasDefault = array_key_exists('COLUMN_DEFAULT', $sizeColumn) && $sizeColumn['COLUMN_DEFAULT'] !== null;

$error = '';
$success = '';
$skippedSerials = [];
$rowErrors = [];

function monCleanHeader($value): string {
    return strtolower(trim(preg_replace('/\s+/', ' ', (string)$value)));
}

function monStatus($value): ?string {
    $raw = strtolower(trim((string)$value));

    if ($raw === '' || $raw === '-') {
        return 'In Stock';
    }

    $key = preg_replace('/[^a-z]/', '', $raw);

    if ($key === 'sold') {
        return 'Sold';
    }

    if (in_array($key, ['instock', 'stock', 'available'], true)) {
        return 'In Stock';
    }

    return null;
}

/*
 * Normal monitor template only.
 */
if (($_GET['download_template'] ?? '') === 'normal') {
    $book = new Spreadsheet();
    $sheet = $book->getActiveSheet();
    $sheet->setTitle('Normal Monitors');

    $headers = ['serial_number', 'model_name', 'size_inches'];
    $sample = ['SN001', 'Dell P2419H', 24];

    foreach ($headers as $i => $header) {
        $col = Coordinate::stringFromColumnIndex($i + 1);
        $sheet->setCellValue($col . '1', $header);
        $sheet->setCellValue($col . '2', $sample[$i]);
        $sheet->getColumnDimension($col)->setAutoSize(true);
    }

    $last = Coordinate::stringFromColumnIndex(count($headers));

    $sheet->getStyle('A1:' . $last . '1')->applyFromArray([
        'font' => [
            'bold' => true,
            'color' => ['rgb' => '111827']
        ],
        'fill' => [
            'fillType' => Fill::FILL_SOLID,
            'startColor' => ['rgb' => 'EABF30']
        ],
        'alignment' => [
            'horizontal' => Alignment::HORIZONTAL_CENTER
        ],
        'borders' => [
            'allBorders' => [
                'borderStyle' => Border::BORDER_THIN
            ]
        ],
    ]);

    $sheet->freezePane('A2');
    $sheet->setAutoFilter('A1:' . $last . '1');

    while (ob_get_level()) {
        ob_end_clean();
    }

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename="monitor_normal_upload_template.xlsx"');
    header('Cache-Control: max-age=0, no-store, no-cache, must-revalidate');

    (new Xlsx($book))->save('php://output');
    exit;
}

if (isset($_GET['download_template']) && $_GET['download_template'] !== 'normal') {
    http_response_code(400);
    exit('Invalid monitor template.');
}

/*
 * Normal monitor upload only.
 */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['file'])) {
    if ($_FILES['file']['error'] !== UPLOAD_ERR_OK) {
        $error = 'Please upload a valid file.';
    } else {
        $extension = strtolower(pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION));

        if (!in_array($extension, ['xlsx', 'xls', 'csv'], true)) {
            $error = 'Invalid file type. Please upload .xlsx, .xls or .csv.';
        }
    }

    $batchBranch = strtoupper((string)$user_branch);

    if (!$error) {
        try {
            $book = IOFactory::load($_FILES['file']['tmp_name']);
            $rows = $book->getActiveSheet()->toArray(null, true, true, false);

            if (!$rows) {
                throw new Exception('The uploaded spreadsheet is empty.');
            }

            $headers = array_map('monCleanHeader', array_shift($rows));

            $expectedHeaders = ['serial_number', 'model_name', 'size_inches'];

            if ($headers !== $expectedHeaders) {
                throw new Exception(
                    'Monitor header must be exactly: serial_number, model_name, size_inches'
                );
            }

            $check = $conn->prepare("
                SELECT serial_number
                FROM monitors
                WHERE serial_number = ?
                LIMIT 1
            ");

            $count = 0;
            $duplicates = 0;
            $invalid = 0;

            foreach ($rows as $index => $row) {
                $rowNumber = $index + 2;

                if (!array_filter($row, fn($value) => trim((string)$value) !== '')) {
                    continue;
                }

                $serial = trim((string)($row[0] ?? ''));
                $model = trim((string)($row[1] ?? ''));
                $size = trim((string)($row[2] ?? ''));

                $errors = [];

                if ($serial === '') {
                    $errors[] = 'Serial number is required.';
                }

                if ($model === '') {
                    $errors[] = 'Model name is required.';
                }

                if ($size !== '' && (!is_numeric($size) || (float)$size <= 0 || (float)$size > 100)) {
                    $errors[] = 'Size must be numeric between 1 and 100 when provided.';
                }

                if ($serial !== '') {
                    $check->execute([$serial]);

                    if ($check->fetchColumn()) {
                        $duplicates++;
                        $skippedSerials[] = $serial;
                        continue;
                    }
                }

                if ($errors) {
                    $invalid++;
                    $rowErrors[] =
                        "Row {$rowNumber} (SN: " . ($serial ?: 'N/A') . '): ' .
                        implode(' ', $errors);
                    continue;
                }

                $columns = ['serial_number', 'model_name', 'branch', 'added_by'];
                $values = [':serial_number', ':model_name', ':branch', ':added_by'];
                $params = [
                    'serial_number' => $serial,
                    'model_name' => $model,
                    'branch' => $batchBranch,
                    'added_by' => $user_id
                ];

                // size_inches is optional in Excel.
                // If provided, save it. If blank, omit it so MySQL uses NULL/default.
                if ($size !== '') {
                    $columns[] = 'size_inches';
                    $values[] = ':size_inches';
                    $params['size_inches'] = (float)$size;
                } elseif (!$sizeAllowsNull && !$sizeHasDefault) {
                    $invalid++;
                    $rowErrors[] =
                        "Row {$rowNumber} (SN: " . ($serial ?: 'N/A') . "): " .
                        "size_inches is blank, but monitors.size_inches is still NOT NULL with no default. " .
                        "Change that database column to allow NULL before uploading blank sizes.";
                    continue;
                }

                // Other fields not supplied by this Excel format use their database defaults.
                $insert = $conn->prepare(
                    "INSERT INTO monitors (" . implode(', ', $columns) . ")
                     VALUES (" . implode(', ', $values) . ")"
                );
                $insert->execute($params);

                $count++;
            }

            if ($count > 0) {
                $log = $conn->prepare("
                    INSERT INTO activity_logs (user_id, action, details)
                    VALUES (?, 'Bulk upload monitors', ?)
                ");

                $log->execute([
                    $user_id,
                    "Uploaded {$count} monitors via normal monitor bulk upload. Branch used from logged-in account: {$batchBranch}"
                ]);
            }

            $success = "{$count} monitor(s) uploaded successfully.";

            if ($duplicates > 0) {
                $success .= " {$duplicates} duplicate serial(s) skipped.";
            }

            if ($invalid > 0) {
                $success .= " {$invalid} invalid row(s) skipped.";
            }
        } catch (Throwable $e) {
            $error = 'File processing error: ' . $e->getMessage();
        }
    }
}
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1,viewport-fit=cover">
<title>Bulk Upload Monitors | Mombasa Computers</title>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<style>
:root{
    --p:#1a4b2a;
    --bg:#f3f4f6;
    --b:#e5e7eb;
    --t:#1f2937;
    --m:#6b7280;
}
*{box-sizing:border-box}
body{
    margin:0;
    font-family:Inter,system-ui,sans-serif;
    background:var(--bg);
    color:var(--t)
}
.main{
    margin-left:260px;
    padding:2rem;
    min-height:100vh
}
.box{
    background:#fff;
    border:1px solid var(--b);
    border-radius:14px;
    padding:1.4rem;
    margin-bottom:1rem
}
.alert{
    padding:1rem;
    border-radius:9px;
    margin-bottom:1rem
}
.ok{background:#ecfdf5;color:#065f46}
.err{background:#fef2f2;color:#991b1b}
.warn{background:#fffbeb;color:#92400e}
.grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(210px,1fr));
    gap:1rem
}
.g{
    display:flex;
    flex-direction:column;
    gap:.35rem
}
.g label{
    font-weight:650;
    font-size:.85rem
}
.g select,.g input{
    padding:.7rem;
    border:1px solid #d1d5db;
    border-radius:8px
}
.btn{
    display:inline-flex;
    align-items:center;
    gap:.4rem;
    padding:.7rem .9rem;
    border:0;
    border-radius:8px;
    background:var(--p);
    color:#fff;
    font-weight:700;
    cursor:pointer;
    text-decoration:none
}
.full{
    width:100%;
    justify-content:center
}
.panel{
    margin-top:1.2rem;
    padding:1rem;
    border:1px solid var(--b);
    border-radius:10px
}
.format{
    overflow:auto;
    border:1px solid var(--b);
    border-radius:8px;
    margin:.8rem 0
}
.format table{
    border-collapse:collapse;
    table-layout:fixed;
    min-width:700px;
    width:100%
}
.format th:nth-child(1),.format td:nth-child(1){width:33.33%}
.format th:nth-child(2),.format td:nth-child(2){width:33.33%}
.format th:nth-child(3),.format td:nth-child(3){width:33.34%}
.format th,.format td{
    padding:.72rem .8rem;
    border-bottom:1px solid var(--b);
    white-space:nowrap;
    font-size:.78rem;
    text-align:center;
    vertical-align:middle
}
.format th{
    background:#eabf30;
    color:#111827
}
.help{
    font-size:.83rem;
    line-height:1.55;
    color:var(--m)
}
@media(max-width:1200px){
    .main{
        margin-left:0;
        padding:5rem 1rem 1rem
    }
}
</style>
</head>

<body>

<?php include "../includes/sidebar.php"; ?>

<main class="main">

<section class="box">
    <h1><i class="fas fa-desktop"></i> Bulk Upload Monitors</h1>
    <div class="help">
       
    </div>
</section>

<?php if($success):?>
<div class="alert ok">
    <i class="fas fa-check-circle"></i>
    <?=htmlspecialchars($success)?>
</div>
<?php endif;?>

<?php if($error):?>
<div class="alert err">
    <i class="fas fa-exclamation-circle"></i>
    <?=htmlspecialchars($error)?>
</div>
<?php endif;?>

<?php if($skippedSerials):?>
<div class="alert warn">
    <strong>Duplicate serials:</strong>
    <?=htmlspecialchars(implode(', ',array_unique($skippedSerials)))?>
</div>
<?php endif;?>

<?php if($rowErrors):?>
<div class="alert warn">
    <strong>Rows not uploaded:</strong>
    <ul>
        <?php foreach($rowErrors as $rowError):?>
        <li><?=htmlspecialchars($rowError)?></li>
        <?php endforeach;?>
    </ul>
</div>
<?php endif;?>

<section class="box">

<form method="post" enctype="multipart/form-data">

<div class="grid">

    <div class="g">
        <label>Branch</label>
        <input value="<?=htmlspecialchars((string)$user_branch)?>" disabled>
        <small class="help">Automatically uses your logged-in account branch.</small>
    </div>

    <div class="g">
        <label>Excel File</label>
        <input type="file" name="file" accept=".xlsx,.xls,.csv" required>
    </div>

</div>

<div class="panel">

    <div style="display:flex;justify-content:space-between;gap:1rem;flex-wrap:wrap">
        <strong>Normal Monitor Format</strong>

        <a class="btn" href="?download_template=normal">
            <i class="fas fa-download"></i>
            Download .xlsx
        </a>
    </div>

    <div class="format">
        <table>
            <tr>
                <th>serial_number</th>
                <th>model_name</th>
                <th>size_inches</th>
            </tr>

            <tr>
                <td>SN001</td>
                <td>Dell P2419H</td>
                <td>24</td>
            </tr>
        </table>
    </div>

    <p class="help">
        <strong>serial_number</strong> and <strong>model_name</strong> are required.
        <strong>size_inches</strong> is optional; leave it blank when unknown.
        Branch is taken automatically from the logged-in user's account.
        Fields not included in this Excel format, such as Status and Location, use the defaults defined in the monitors table.
    </p>

    <?php if (!$sizeAllowsNull && !$sizeHasDefault): ?>
        <div class="alert err" style="margin-top:.8rem;margin-bottom:0;">
            <i class="fas fa-database"></i>
            <span>
                Database check: <strong>monitors.size_inches is still NOT NULL and has no default.</strong>
                Blank size values cannot be uploaded until that column is changed to allow NULL.
            </span>
        </div>
    <?php else: ?>
      
    <?php endif; ?>

</div>

<button class="btn full" type="submit" style="margin-top:1rem">
    <i class="fas fa-upload"></i>
    Upload and Process
</button>

</form>

</section>

</main>

<?php require_once "../includes/footer.php"; ?>

</body>
</html>
