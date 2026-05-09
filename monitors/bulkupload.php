<?php
session_start();
require_once "../config/db.php";
require_once "../includes/auth_check.php";
require_once "../vendor/autoload.php";

use PhpOffice\PhpSpreadsheet\IOFactory;

if (!in_array($_SESSION['role'], ['super_admin','inventory_admin','manager'])) {
    header("Location: /inventory_system/dashboard/index.php");
    exit();
}

$error = $success = "";
$skippedSerials = [];
$user_id = $_SESSION['user_id'];
$user_role = $_SESSION['role'];

// Get user's branch if not super_admin
$user_branch = null;
if ($user_role !== 'super_admin') {
    $stmt = $conn->prepare("SELECT branch FROM users WHERE id = ?");
    $stmt->execute([$user_id]);
    $user_data = $stmt->fetch(PDO::FETCH_ASSOC);
    $user_branch = $user_data['branch'] ?? null;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (!isset($_FILES['file']) || $_FILES['file']['error'] !== 0) {
        $error = "Please upload a valid file.";
    } else {
        // Determine branch based on user role
        if ($user_role === 'super_admin') {
            $branch = $_POST['branch'] ?? '';
            if (!$branch) {
                $error = "Please select a branch.";
            }
        } else {
            $branch = $user_branch; // Managers and inventory_admins can only add to their branch
        }
        
        if (!$branch) {
            $error = "Branch not found for your account.";
        } else {
            $fileTmp = $_FILES['file']['tmp_name'];

            try {
                $spreadsheet = IOFactory::load($fileTmp);
                $sheet = $spreadsheet->getActiveSheet();
                $rows = $sheet->toArray();

                $added_by = $user_id;
                $count = 0;
                $duplicates = 0;

                foreach ($rows as $index => $row) {
                    if ($index === 0) continue;

                    $serial = trim($row[0] ?? '');
                    $model  = trim($row[1] ?? '');
                    $size   = trim($row[2] ?? '');

                    if (!$serial || !$model || !$size) continue;

                    $check = $conn->prepare("SELECT serial_number FROM monitors WHERE serial_number = ?");
                    $check->execute([$serial]);
                    if ($check->rowCount() > 0) {
                        $duplicates++;
                        $skippedSerials[] = $serial;
                        continue;
                    }

                    $stmt = $conn->prepare("
                        INSERT INTO monitors
                        (serial_number, model_name, size_inches, branch, added_by, date_added)
                        VALUES (?, ?, ?, ?, ?, NOW())
                    ");
                    $stmt->execute([$serial, $model, $size, $branch, $added_by]);
                    $count++;
                }

                $success = "$count monitors uploaded to $branch branch successfully.";
                if ($duplicates > 0) {
                    $success .= " $duplicates duplicate serial(s) were skipped.";
                }

            } catch (Exception $e) {
                $error = "File error: " . $e->getMessage();
            }
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Bulk Upload Monitors</title>
<style>
body { font-family: Arial; background:#f4f7f6; }
.container {
    max-width:600px;
    margin:40px auto;
    background:#fff;
    padding:25px;
    border-radius:8px;
    box-shadow:0 4px 15px rgba(0,0,0,.1);
}
h2 { text-align:center; color:#2f7a3f; }
select, input[type=file] {
    width:100%;
    padding:10px;
    margin-top:5px;
    margin-bottom:15px;
    border:1px solid #ccc;
    border-radius:5px;
}
button {
    width:100%;
    padding:12px;
    background:#2f7a3f;
    color:#fff;
    border:none;
    border-radius:5px;
    margin-top:15px;
    cursor:pointer;
}
.success { color:green; text-align:center; }
.error { color:red; text-align:center; }
.skipped {
    margin-top:10px;
    padding:10px;
    background:#fff3cd;
    border:1px solid #ffeaa7;
    border-radius:5px;
    font-size:13px;
}
.branch-info {
    padding:10px;
    background:#e7f3ff;
    border-left:4px solid #007bff;
    margin-bottom:15px;
    border-radius:4px;
}
</style>
</head>
<body>

<div class="container">
<h2>Bulk Upload Monitors</h2>

<a href="/inventory_system/dashboard/index.php"
   style="background:#007bff;color:#fff;padding:8px 12px;border-radius:5px;text-decoration:none;">
   Dashboard
</a> <br> <br>

<?php if($error): ?><p class="error"><?= $error ?></p><?php endif; ?>
<?php if($success): ?><p class="success"><?= $success ?></p><?php endif; ?>

<div class="branch-info">
    <strong>Branch Information:</strong><br>
    <?php if($user_role === 'super_admin'): ?>
        You can upload monitors to any branch.
    <?php else: ?>
        You can only upload monitors to your branch: <strong><?= htmlspecialchars($user_branch) ?></strong>
    <?php endif; ?>
</div>

<form method="POST" enctype="multipart/form-data">
    <?php if($user_role === 'super_admin'): ?>
        <select name="branch" required>
            <option value="">-- Select Branch --</option>
            <option value="KIMATHI">KIMATHI</option>
            <option value="MOI">MOI</option>
        </select>
    <?php else: ?>
        <input type="hidden" name="branch" value="<?= htmlspecialchars($user_branch) ?>">
        <div style="padding:10px; background:#f8f9fa; border-radius:5px; margin-bottom:15px;">
            <strong>Branch:</strong> <?= htmlspecialchars($user_branch) ?>
        </div>
    <?php endif; ?>
    
    <input type="file" name="file" accept=".csv,.xlsx,.xls" required>
    <button type="submit">Upload</button>
</form>

<?php if(!empty($skippedSerials)): ?>
<div class="skipped">
<strong>Skipped Serials:</strong><br>
<?= implode(', ', $skippedSerials) ?>
</div>
<?php endif; ?>

<p style="font-size:13px;margin-top:10px;">
<b>Excel/CSV format (3 columns):</b><br>
Serial Number | Model Name | Size
</p>

</div>
</body>
</html>