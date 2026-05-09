<?php
session_start();
require_once "../config/db.php";
require_once "../includes/auth_check.php";

if ($_SESSION['role'] !== 'technician') {
    die("Access denied");
}

$user_id = $_SESSION['user_id'];
$user_name = $_SESSION['full_name'] ?? $_SESSION['name'] ?? 'Technician';

/* Get technician branch */
$stmt = $conn->prepare("SELECT branch FROM users WHERE id = :id");
$stmt->execute(['id' => $user_id]);
$userBranch = $stmt->fetchColumn();

$error = $success = "";
$device = null;

/* Load device by serial */
if (isset($_GET['sn']) && $_GET['sn'] !== '') {
    $stmt = $conn->prepare("
        SELECT d.*, c.category_name
        FROM devices d
        JOIN categories c ON d.category_id = c.id
        WHERE d.serial_number = :sn
          AND d.status = 'In Stock'
          AND d.branch = :branch
    ");
    $stmt->execute([
        'sn' => $_GET['sn'],
        'branch' => $userBranch
    ]);
    $device = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$device) {
        $error = "Device not found, not In Stock, or not in your branch.";
    }
}

/* Users who can give device */
$stmt = $conn->prepare("
    SELECT id, full_name 
    FROM users
    WHERE role IN ('inventory_admin','super_admin')
      AND (branch = :branch OR role = 'super_admin')
");
$stmt->execute(['branch' => $userBranch]);
$givenByUsers = $stmt->fetchAll(PDO::FETCH_ASSOC);

/* Save repair */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $serial = $_POST['serial'];
    $problem = trim($_POST['problem_description']);
    $given_by = (int)$_POST['given_by'];

    if ($problem === '') {
        $error = "Problem description is required.";
    } else {
        try {
            $conn->beginTransaction();

            // Insert repair record
            $conn->prepare("
                INSERT INTO repairs 
                (serial_number, problem_description, added_by, given_by, branch)
                VALUES (:sn, :problem, :tech, :given_by, :branch)
            ")->execute([
                'sn' => $serial,
                'problem' => $problem,
                'tech' => $user_id,
                'given_by' => $given_by,
                'branch' => $userBranch
            ]);

            // Update device status
            $conn->prepare("
                UPDATE devices SET status = 'Under Repair'
                WHERE serial_number = :sn
            ")->execute(['sn' => $serial]);

            // Get given_by user name for activity log
            $givenByName = "Unknown";
            foreach ($givenByUsers as $user) {
                if ($user['id'] == $given_by) {
                    $givenByName = $user['full_name'];
                    break;
                }
            }

            // Log activity
            $action = "Added Repair";
            $details = "Device: $serial | Problem: $problem | Given By: $givenByName | Branch: $userBranch | Technician: $user_name";
            
            $logStmt = $conn->prepare("
                INSERT INTO activity_logs (user_id, action, details, created_at)
                VALUES (:user_id, :action, :details, NOW())
            ");
            $logStmt->execute([
                'user_id' => $user_id,
                'action' => $action,
                'details' => $details
            ]);

            $conn->commit();
            $success = "Device successfully added to repairs.";
            $device = null;

        } catch (Exception $e) {
            $conn->rollBack();
            $error = "Error: " . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Add Repair - Inventory System</title>
<style>
body{font-family:Arial;background:#f4f7f6;margin:0;padding:0}
.container{max-width:900px;margin:30px auto;background:#fff;padding:25px;border-radius:8px;box-shadow:0 4px 15px rgba(0,0,0,0.1)}
h2{color:#2f7a3f;text-align:center;margin-bottom:15px}
form.search{display:flex;gap:10px;align-items:center;margin-bottom:20px}
input[type=text]{padding:10px;border:1px solid #ccc;border-radius:5px;width:30%}
textarea{padding:10px;border:1px solid #ccc;border-radius:5px;width:100%;box-sizing:border-box}
button{padding:10px 14px;background:#2f7a3f;border:none;color:#fff;border-radius:5px;cursor:pointer}
button:hover{background:#1f5a2d}
.table{width:100%;border-collapse:collapse;margin-top:15px}
.table th,.table td{padding:10px;border:1px solid #ddd;text-align:left}
.table th{background:#2f7a3f;color:#fff}
.success{color:#2f7a3f;margin-bottom:10px;padding:10px;background:#d4edda;border:1px solid #c3e6cb;border-radius:4px}
.error{color:#d32f2f;margin-bottom:10px;padding:10px;background:#f8d7da;border:1px solid #f5c6cb;border-radius:4px}
label{display:block;margin-top:15px;font-weight:bold;margin-bottom:5px}
select{padding:10px;border:1px solid #ccc;border-radius:5px;width:100%;box-sizing:border-box}
.small{font-size:0.9em;color:#555}
.dashboard-btn{float:left;margin-bottom:20px;padding:8px 12px;background:#007bff;color:#fff;border-radius:6px;text-decoration:none;font-weight:bold;display:inline-block}
.dashboard-btn:hover{background:#0056b3;text-decoration:none}
h4{color:#333;margin-top:20px;margin-bottom:10px;border-bottom:2px solid #2f7a3f;padding-bottom:5px}
</style>
</head>
<body>
<div class="container">
    <a href="/inventory_system/dashboard/index.php" class="dashboard-btn">
       Dashboard
    </a>

    <h2>Add Repair</h2>

    <?php if($error): ?><div class="error"><?= $error ?></div><?php endif; ?>
    <?php if($success): ?><div class="success"><?= $success ?></div><?php endif; ?>

    <form method="GET" class="search" action="">
        <input type="text" name="sn" placeholder="Scan or enter serial number" value="<?= isset($_GET['sn']) ? htmlspecialchars($_GET['sn']) : '' ?>" autofocus>
        <button type="submit">Load Device</button>
    </form>

    <?php if($device): ?>
        <div class="section">
            <h4>Device Details</h4>
            <table class="table">
                <tr><th>Serial</th><td><?= htmlspecialchars($device['serial_number']) ?></td></tr>
                <tr><th>Category</th><td><?= htmlspecialchars($device['category_name']) ?></td></tr>
                <tr><th>Model</th><td><?= htmlspecialchars($device['model_name']) ?></td></tr>
                <tr><th>Processor</th><td><?= htmlspecialchars($device['processor']) ?></td></tr>
                <tr><th>RAM</th><td><?= htmlspecialchars($device['ram']) ?> GB</td></tr>
                <tr><th>Storage</th><td><?= htmlspecialchars($device['storage_type'].' '.$device['storage_capacity'].'GB') ?></td></tr>
                <tr><th>Touch</th><td><?= htmlspecialchars($device['touch'] ?? 'N/A') ?></td></tr>
                <tr><th>Graphics</th><td><?= htmlspecialchars($device['graphics']) ?></td></tr>
                <tr><th>Branch</th><td><?= htmlspecialchars($userBranch) ?></td></tr>
            </table>
        </div>

        <form method="post" style="margin-top:20px;">
            <input type="hidden" name="serial" value="<?= htmlspecialchars($device['serial_number']) ?>">

            <label>Problem Description</label>
            <textarea name="problem_description" rows="4" required placeholder="Describe the issue..."></textarea>

            <label>Given By</label>
            <select name="given_by" required>
                <option value="">-- Select --</option>
                <?php foreach($givenByUsers as $u): ?>
                    <option value="<?= $u['id'] ?>"><?= htmlspecialchars($u['full_name']) ?></option>
                <?php endforeach; ?>
            </select>

            <div style="margin-top:20px">
                <button type="submit">Save Repair</button>
            </div>
        </form>
    <?php elseif(isset($_GET['sn']) && $_GET['sn'] !== ''): ?>
        <p class="small">Device not loaded. Make sure the serial exists and Device is In Stock.</p>
    <?php endif; ?>
</div>
</body>
</html>