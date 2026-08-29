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

if ($user_role !== 'super_admin' && !$user_branch) {
    die("Your account has no branch assigned.");
}

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

    $headers = ['serial_number', 'model_name', 'size_inches', 'status'];
    $sample = ['SN001', 'Dell P2419H', 24, 'In Stock'];

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

    $batchBranch = $user_branch;

    if (!$error && in_array($user_role, ['super_admin', 'inventory_admin'], true)) {
        $batchBranch = strtoupper(trim((string)($_POST['branch'] ?? '')));

        if (!in_array($batchBranch, ['KIMATHI', 'MOI'], true)) {
            $error = 'Please select a valid branch.';
        }
    }

    if (!$error) {
        try {
            $book = IOFactory::load($_FILES['file']['tmp_name']);
            $rows = $book->getActiveSheet()->toArray(null, true, true, false);

            if (!$rows) {
                throw new Exception('The uploaded spreadsheet is empty.');
            }

            $headers = array_map('monCleanHeader', array_shift($rows));

            $expectedHeaders = ['serial_number', 'model_name', 'size_inches', 'status'];

            if ($headers !== $expectedHeaders) {
                throw new Exception(
                    'Monitor header must be exactly: serial_number, model_name, size_inches, status'
                );
            }

            $insert = $conn->prepare("
                INSERT INTO monitors (
                    serial_number,
                    model_name,
                    size_inches,
                    status,
                    branch,
                    added_by,
                    date_added
                )
                VALUES (?, ?, ?, ?, ?, ?, NOW())
            ");

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
                $statusRaw = trim((string)($row[3] ?? ''));

                $errors = [];

                $status = monStatus($statusRaw);

                if ($status === null) {
                    $errors[] = 'Status must be Sold or In Stock.';
                }

                if ($serial === '') {
                    $errors[] = 'Serial number is required.';
                }

                if ($model === '') {
                    $errors[] = 'Model name is required.';
                }

                if ($size === '' || !is_numeric($size) || (float)$size <= 0 || (float)$size > 100) {
                    $errors[] = 'Size must be numeric between 1 and 100.';
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

                $insert->execute([
                    $serial,
                    $model,
                    (float)$size,
                    $status,
                    $batchBranch,
                    $user_id
                ]);

                $count++;
            }

            if ($count > 0) {
                $log = $conn->prepare("
                    INSERT INTO activity_logs (user_id, action, details)
                    VALUES (?, 'Bulk upload monitors', ?)
                ");

                $log->execute([
                    $user_id,
                    "Uploaded {$count} monitors via normal monitor bulk upload to branch {$batchBranch}"
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
    min-width:700px;
    width:100%
}
.format th,.format td{
    padding:.58rem;
    border-bottom:1px solid var(--b);
    white-space:nowrap;
    font-size:.78rem
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
        Upload monitors into the normal monitor inventory only.
        Iman Inventory and Iman's Hustle monitors are managed separately in their own inventory tables.
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

        <?php if(in_array($user_role,['super_admin','inventory_admin'],true)):?>
        <select name="branch" required>
            <option value="">-- Select Branch --</option>
            <option value="KIMATHI">KIMATHI</option>
            <option value="MOI">MOI</option>
        </select>
        <?php else:?>
        <input value="<?=htmlspecialchars((string)$user_branch)?>" disabled>
        <?php endif;?>
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
                <th>status</th>
            </tr>

            <tr>
                <td>SN001</td>
                <td>Dell P2419H</td>
                <td>24</td>
                <td>In Stock</td>
            </tr>
        </table>
    </div>

    <p class="help">
        Status may be <strong>In Stock</strong> or <strong>Sold</strong>.
        If Status is blank or "-", it automatically becomes <strong>In Stock</strong>.
    </p>

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
