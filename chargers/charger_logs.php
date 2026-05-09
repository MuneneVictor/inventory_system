<?php
session_start();
require_once "../config/db.php";
require_once "../includes/auth_check.php";

$role = $_SESSION['role'];
$user_id = $_SESSION['user_id'];

if (!in_array($role, ['inventory_admin','manager','super_admin','maintenance'])) {
    die("Access denied!");
}

// Fetch logs
if ($role === 'maintenance') {

    // Maintenance users only see logs they created
    $stmt = $conn->prepare("
        SELECT cl.*, 
               c.charger_type, c.watts, c.charger_condition,
               u.full_name AS given_to_name, u.branch AS given_to_branch,
               ub.full_name AS given_by_name, ub.branch AS given_by_branch
        FROM charger_logs cl
        JOIN chargers c ON cl.charger_id = c.id
        JOIN users u ON cl.given_to = u.id
        JOIN users ub ON cl.given_by = ub.id
        WHERE cl.given_by = :uid
        ORDER BY cl.date_given DESC
    ");
    $stmt->execute(['uid'=>$user_id]);

} else {

    // Admins see everything
    $stmt = $conn->prepare("
        SELECT cl.*, 
               c.charger_type, c.watts, c.charger_condition,
               u.full_name AS given_to_name, u.branch AS given_to_branch,
               ub.full_name AS given_by_name, ub.branch AS given_by_branch
        FROM charger_logs cl
        JOIN chargers c ON cl.charger_id = c.id
        JOIN users u ON cl.given_to = u.id
        JOIN users ub ON cl.given_by = ub.id
        ORDER BY cl.date_given DESC
    ");
    $stmt->execute();
}

$logs = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Charger Logs</title>
<style>
body{font-family:Arial;background:#f4f7f6;margin:0;padding:0}
.container{max-width:1000px;margin:30px auto;background:#fff;padding:25px;border-radius:8px;box-shadow:0 4px 15px rgba(0,0,0,0.1)}
h2{color:#2f7a3f;text-align:center;margin-bottom:15px}
table{width:100%;border-collapse:collapse;margin-top:15px}
th, td{border:1px solid #ccc;padding:10px;text-align:left}
th{background:#2f7a3f;color:#fff}
button, .dashboard-btn{
    padding:10px 14px;background:#007bff;border:none;
    color:#fff;border-radius:5px;cursor:pointer;text-decoration:none;
    display:inline-block;margin-bottom:10px
}
button:hover, .dashboard-btn:hover{background:#007bff;}
</style>
</head>
<body>
<div class="container">

<a href="/inventory_system/dashboard/index.php" class="dashboard-btn">Dashboard</a>
<h2>Charger Logs</h2>

<table>
<thead>
<tr>
    <th>#</th>
    <th>Type</th>
    <th>Watts</th>
    <th>Condition</th>
    <th>Quantity</th>
    <th>Given To</th>
    <th>Given By</th>
    <th>Date</th>
</tr>
</thead>

<tbody>
<?php if ($logs): ?>
    <?php $i=1; foreach ($logs as $l): ?>
        <tr>
            <td><?= $i++; ?></td>
            <td><?= htmlspecialchars($l['charger_type']) ?></td>
            <td><?= htmlspecialchars($l['watts']) ?> W</td>
            <td><?= htmlspecialchars($l['charger_condition']) ?></td>
            <td><?= htmlspecialchars($l['quantity']) ?></td>
            <td><?= htmlspecialchars($l['given_to_name']) ?> (<?= htmlspecialchars($l['given_to_branch']) ?>)</td>
            <td><?= htmlspecialchars($l['given_by_name']) ?> (<?= htmlspecialchars($l['given_by_branch']) ?>)</td>
            <td><?= htmlspecialchars($l['date_given']) ?></td>
        </tr>
    <?php endforeach; ?>
<?php else: ?>
    <tr><td colspan="8" style="text-align:center">No logs found</td></tr>
<?php endif; ?>
</tbody>
</table>

</div>
</body>
</html>
