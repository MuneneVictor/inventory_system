<?php
session_start();
require_once "../config/db.php";
require_once "../includes/auth_check.php";
require_once "../vendor/autoload.php";

use PhpOffice\PhpSpreadsheet\IOFactory;

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
    // Determine branch based on user role
    if ($user_role === 'super_admin') {
        $branch = $_POST['branch'] ?? '';
        if (!$branch) {
            $error = "Please select a branch.";
        }
    } else {
        $branch = $user_branch; // Non-super_admins can only upload to their branch
        if (!$branch) {
            $error = "Branch not found for your account.";
        }
    }

    if (!$error && !empty($_FILES['file']['tmp_name'])) {
        $fileTmp = $_FILES['file']['tmp_name'];
        $fileName = $_FILES['file']['name'];
        $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
        
        $allowedExtensions = ['csv', 'xlsx', 'xls'];
        
        if (!in_array($fileExtension, $allowedExtensions)) {
            $error = "Please upload a CSV or Excel file (.csv, .xlsx, .xls)";
        } else {
            try {
                $spreadsheet = IOFactory::load($fileTmp);
                $sheet = $spreadsheet->getActiveSheet();
                $rows = $sheet->toArray();
                
                $count = 0;
                $duplicateCount = 0;
                
                foreach ($rows as $index => $row) {
                    // Skip header row
                    if ($index === 0) continue;
                    
                    $serial = trim($row[0] ?? '');
                    $model  = trim($row[1] ?? '');
                    
                    if (!$serial || !$model) continue;
                    
                    // Check for duplicate serial
                    $check = $conn->prepare("SELECT serial_number FROM printers WHERE serial_number = ?");
                    $check->execute([$serial]);
                    if ($check->rowCount() > 0) {
                        $duplicateCount++;
                        $skippedSerials[] = $serial;
                        continue;
                    }
                    
                    $stmt = $conn->prepare("
                        INSERT INTO printers (serial_number, model_name, branch, added_by)
                        VALUES (?, ?, ?, ?)
                    ");
                    $stmt->execute([$serial, $model, $branch, $user_id]);
                    $count++;
                }
                
                $success = "$count printers uploaded to $branch branch successfully";
                if ($duplicateCount > 0) {
                    $success .= ". $duplicateCount duplicate(s) skipped.";
                }
                
            } catch (Exception $e) {
                $error = "Error reading file: " . $e->getMessage();
            }
        }
    } elseif (!$error) {
        $error = "Please upload a file";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Bulk Upload Printers</title>
<style>
body { font-family: Arial; background:#f4f7f6; }
.container { max-width:450px; margin:40px auto; background:#fff; padding:25px; border-radius:8px; box-shadow:0 4px 15px rgba(0,0,0,.1); }
h2 { text-align:center; color:#2f7a3f; }
input, select { width:100%; padding:10px; margin-bottom:15px; border:1px solid #ccc; border-radius:5px; }
button { width:100%; padding:12px; background:#2f7a3f; color:#fff; border:none; border-radius:5px; }
.error { color:red; text-align:center; }
.success { color:green; text-align:center; }
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
<h2>Bulk Upload Printers</h2>
<a href="/inventory_system/dashboard/index.php"
   style="position: top:10px; right:10px; padding:10px 15px; 
          background:#007bff; color:white; border-radius:6px; 
          text-decoration:none; font-weight:bold; z-index:999;">
    Dashboard
</a> <br><br>

<div class="branch-info">
    <strong>Branch Information:</strong><br>
    <?php if($user_role === 'super_admin'): ?>
        You can upload printers to any branch.
    <?php else: ?>
        You can only upload printers to your branch: <strong><?= htmlspecialchars($user_branch) ?></strong>
    <?php endif; ?>
</div>

<?php if($error): ?><div class="error"><?= $error ?></div><?php endif; ?>
<?php if($success): ?><div class="success"><?= $success ?></div><?php endif; ?>

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
<strong>Skipped Serials (duplicates):</strong><br>
<?= implode(', ', $skippedSerials) ?>
</div>
<?php endif; ?>

<p style="font-size:13px;margin-top:10px;">
<b>Excel/CSV format (2 columns):</b><br>
Serial Number | Model Name
</p>

</div>
</body>
</html>