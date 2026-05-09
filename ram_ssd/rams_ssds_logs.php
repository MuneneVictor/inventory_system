<?php
session_start();
require_once "../config/db.php";
require_once "../includes/auth_check.php";

// Check if user is logged in
if(!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

$role = $_SESSION['role'];
$user_id = $_SESSION['user_id'];

if(!in_array($role, ['inventory_admin','super_admin', 'manager'])){
    header("Location: ../dashboard/index.php");
    exit();
}

// Fetch user's branch for inventory_admin
$user_branch = null;
if($role === 'inventory_admin') {
    $user_stmt = $conn->prepare("SELECT branch FROM users WHERE id = :user_id");
    $user_stmt->execute(['user_id' => $user_id]);
    $user_data = $user_stmt->fetch(PDO::FETCH_ASSOC);
    $user_branch = $user_data['branch'] ?? null;
}

// Fetch logs with storage column
$sql = "SELECT l.*, u1.full_name AS given_to_name, u2.full_name AS given_by_name 
        FROM rams_ssds_logs l
        LEFT JOIN users u1 ON l.given_to = u1.id
        LEFT JOIN users u2 ON l.given_by = u2.id
        WHERE 1";

$params = [];

// Apply branch filter based on role
if($role === 'inventory_admin') {
    if($user_branch) {
        $sql .= " AND l.branch = :branch";
        $params['branch'] = $user_branch;
    } else {
        // If inventory_admin has no branch assigned, show nothing
        $sql .= " AND 1=0";
    }
}

$sql .= " ORDER BY l.date_given DESC";

$stmt = $conn->prepare($sql);
$stmt->execute($params);
$logs = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>RAM & SSD Logs</title>
<style>
body{font-family:Arial; background:#f4f7f6; margin:0; padding:0;}
.container{max-width:1300px;margin:30px auto;background:#fff;padding:25px;border-radius:8px;box-shadow:0 4px 15px rgba(0,0,0,0.1);}
h2{text-align:center;color:#2f7a3f;margin-bottom:20px;}
a.dashboard-btn{display:inline-block;margin-bottom:20px;background:#007bff;color:#fff;padding:10px 15px;border-radius:6px;text-decoration:none;font-weight:bold;}
a.dashboard-btn:hover{background:#005fa3;}
table{width:100%;border-collapse:collapse;margin-top:20px;}
th,td{border:1px solid #ccc;padding:10px;text-align:left;}
th{background:#2f7a3f;color:#fff;}
.error-message {color:#d32f2f; text-align:center; padding:15px; background:#ffeaea; border-radius:5px; margin-bottom:20px;}
</style>
</head>
<body>
<div class="container">
<a href="/inventory_system/dashboard/index.php" class="dashboard-btn">Dashboard</a>
<h2>RAM & SSD Logs</h2>

<?php if($role === 'inventory_admin' && !$user_branch): ?>
    <div class="error-message">Your account is not assigned to any branch. Please contact administrator.</div>
<?php endif; ?>

<table>
<tr>
    <th>#</th>
    <th>Category</th>
    <th>Type</th>
    <th>Storage</th>
    <th>Quantity Given</th>
    <th>Given To</th>
    <th>Given By</th>
    <th>Branch</th>
    <th>Date Given</th>
</tr>
<?php if($logs): $i=1; foreach($logs as $l): ?>
<tr>
    <td><?= $i++ ?></td>
    <td><?= htmlspecialchars($l['category']) ?></td>
    <td><?= htmlspecialchars($l['type']) ?></td>
    <td><?= $l['storage'] ?> GB</td>
    <td><?= $l['quantity_given'] ?></td>
    <td><?= htmlspecialchars($l['given_to_name'] ?? 'Unknown') ?></td>
    <td><?= htmlspecialchars($l['given_by_name'] ?? 'Unknown') ?></td>
    <td><?= htmlspecialchars($l['branch']) ?></td>
    <td><?= htmlspecialchars(date('Y-m-d H:i:s', strtotime($l['date_given']))) ?></td>
</tr>
<?php endforeach; else: ?>
<tr><td colspan="9" style="text-align:center;">No logs found</td></tr>
<?php endif; ?>
</table>

<?php if($logs): ?>
<div style="margin-top: 20px; padding: 15px; background: #f4f7f6; border-radius: 5px;">
    <strong>Summary:</strong> Total <?= count($logs) ?> log entries
    <?php 
    // Calculate total quantity given
    $total_quantity = 0;
    foreach($logs as $l) {
        $total_quantity += $l['quantity_given'];
    }
    ?>
    | Total Quantity Given: <?= $total_quantity ?>
</div>
<?php endif; ?>

</div>
</body>
</html>