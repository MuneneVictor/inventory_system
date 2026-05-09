<?php
session_start();
require_once "../config/db.php";
require_once "../includes/auth_check.php";

// Allowed roles: maintenance, super_admin, inventory_admin
if (!in_array($_SESSION['role'], ['maintenance', 'super_admin', 'inventory_admin', 'manager'])) {
    die("Access denied!");
}

$role = $_SESSION['role'];
$user_id = $_SESSION['user_id'];
$params = [];

// Get manager's/inventory_admin's branch from database
if (in_array($role, ['manager', 'inventory_admin'])) {
    $user_stmt = $conn->prepare("SELECT branch FROM users WHERE id = ?");
    $user_stmt->execute([$user_id]);
    $user_data = $user_stmt->fetch(PDO::FETCH_ASSOC);
    $user_branch = $user_data['branch'] ?? '';
}

$sql = "SELECT m.*, d.model_name, d.storage_type, d.storage_capacity, c.category_name, u.full_name AS performed_by_name, d.branch
        FROM maintenance m
        LEFT JOIN devices d ON m.device_serial = d.serial_number
        LEFT JOIN categories c ON d.category_id = c.id
        LEFT JOIN users u ON m.performed_by = u.id
        WHERE 1";

if ($role === 'maintenance') {
    // show only logs performed by that maintenance person
    $sql .= " AND m.performed_by = :performed_by";
    $params['performed_by'] = $user_id;
}

// Manager and inventory_admin restriction - see only logs from their branch
if (in_array($role, ['manager', 'inventory_admin']) && !empty($user_branch)) {
    $sql .= " AND d.branch = :user_branch";
    $params['user_branch'] = $user_branch;
}

$sql .= " ORDER BY m.date_performed DESC";

$stmt = $conn->prepare($sql);
$stmt->execute($params);
$logs = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Maintenance Logs</title>
<style>
body { font-family:Arial, sans-serif; background:#f4f7f6; margin:0; padding:0; }
.container { max-width:1100px; margin:30px auto; background:#fff; padding:25px; border-radius:8px; box-shadow:0 4px 15px rgba(0,0,0,0.1); }
h2 { color:#2f7a3f; text-align:center; margin-bottom:15px; }
.table { width:100%; border-collapse:collapse; margin-top:15px; }
.table th, .table td { padding:10px; border:1px solid #ddd; text-align:left; font-size:0.95em; }
.table th { background:#2f7a3f; color:#fff; }
.table tr:nth-child(even) { background:#f9f9f9; }
.small { font-size:0.9em; color:#555; }
</style>
</head>
<body>
<div class="container">
    <a href="/inventory_system/dashboard/index.php" style="float:left;margin-bottom:10px;padding:8px 12px;background:#007bff;color:#fff;border-radius:6px;text-decoration:none;font-weight:bold">Dashboard</a>
    <h2>Maintenance Logs</h2>

    <?php if(empty($logs)): ?>
        <p style="text-align:center">No maintenance records found.</p>
    <?php else: ?>
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Serial</th>
                    <th>Category</th>
                    <th>Model</th>
                    <th>Old RAM</th>
                    <th>New RAM</th>
                    <th>Old Storage</th>
                    <th>New Storage</th>
                    <th>Old Graphics</th>
                    <th>New Graphics</th>
                    <th>Performed By</th>
                    <th>Notes</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 1; foreach($logs as $l): ?>
                <tr>
                    <td><?= $i++ ?></td>
                    <td><?= htmlspecialchars($l['device_serial']) ?></td>
                    <td><?= htmlspecialchars($l['category_name'] ?? '-') ?></td>
                    <td><?= htmlspecialchars($l['model_name'] ?? '-') ?></td>
                    <td><?= htmlspecialchars($l['old_ram'] ?? '-') ?>GB</td>
                    <td><?= htmlspecialchars($l['new_ram'] ?? '-') ?>GB</td>
                    <td><?= htmlspecialchars($l['old_storage'] ?? '-') ?>GB</td>
                    <td><?= htmlspecialchars($l['new_storage'] ?? '-') ?>GB</td>
                    <td><?= htmlspecialchars($l['old_graphics'] ?? '-') ?></td>
                    <td><?= htmlspecialchars($l['new_graphics'] ?? '-') ?></td>
                    <td><?= htmlspecialchars($l['performed_by_name'] ?? '-') ?></td>
                    <td><?= htmlspecialchars($l['notes'] ?? '-') ?></td>
                    <td><?= htmlspecialchars(date('Y-m-d H:i:s', strtotime($l['date_performed']))) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>
</body>
</html>