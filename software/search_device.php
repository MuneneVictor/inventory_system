<?php
session_start();
require_once "../config/db.php";
require_once "../includes/auth_check.php";

// Only software role can access
if ($_SESSION['role'] !== 'software') {
    die("Access denied!");
}

$search_sn = trim($_GET['sn'] ?? '');
$device = null;
$maintenance_history = [];

if ($search_sn) {
    // fetch device
    $stmt = $conn->prepare("SELECT d.*, c.category_name, u.full_name AS added_by_name
                            FROM devices d
                            JOIN categories c ON d.category_id = c.id
                            LEFT JOIN users u ON d.added_by = u.id
                            WHERE d.serial_number = :sn");
    $stmt->execute(['sn' => $search_sn]);
    $device = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($device) {
        // fetch maintenance history for device
        $mstmt = $conn->prepare("SELECT * FROM maintenance WHERE device_serial = :sn ORDER BY date_performed DESC");
        $mstmt->execute(['sn' => $search_sn]);
        $maintenance_history = $mstmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Search Device - Maintenance</title>
<style>
body{font-family:Arial;background:#f4f7f6;margin:0;padding:0}
.container{max-width:1000px;margin:30px auto;background:#fff;padding:25px;border-radius:8px;box-shadow:0 4px 15px rgba(0,0,0,0.1)}
h2{color:#2f7a3f;text-align:center;margin-bottom:15px}
form.search{display:flex;gap:10px;align-items:center;margin-bottom:20px}
input[type=text]{padding:10px;border:1px solid #ccc;border-radius:5px}
button{padding:10px 14px;background:#2f7a3f;border:none;color:#fff;border-radius:5px;cursor:pointer}
.button-blue{background:#007bff}
.table{width:100%;border-collapse:collapse;margin-top:15px}
.table th,.table td{padding:10px;border:1px solid #ddd;text-align:left}
.table th{background:#2f7a3f;color:#fff}
.small{font-size:0.9em;color:#555}
</style>
</head>
<body>
<div class="container">
    <a href="/inventory_system/dashboard/index.php" style="float:left;margin-bottom:10px;padding:8px 12px;background:#007bff;color:#fff;border-radius:6px;text-decoration:none;font-weight:bold">Dashboard</a>
    <h2>Search Device (Maintenance)</h2>

    <form method="GET" class="search" action="">
        <input type="text" name="sn" placeholder="Scan or enter Serial Number" value="<?= htmlspecialchars($search_sn) ?>" autofocus>
        <button type="submit">Search</button>
    </form>

    <?php if($search_sn && !$device): ?>
        <div class="small" style="color:#d32f2f">Device not found.</div>
    <?php endif; ?>

    <?php if($device): ?>
        <h3>Device Details</h3>
        <table class="table">
            <tr><th>Serial</th><td><?= htmlspecialchars($device['serial_number']) ?></td></tr>
            <tr><th>Category</th><td><?= htmlspecialchars($device['category_name']) ?></td></tr>
            <tr><th>Model</th><td><?= htmlspecialchars($device['model_name']) ?></td></tr>
            <tr><th>Processor</th><td><?= htmlspecialchars($device['processor']) ?></td></tr>
            <tr><th>Graphics</th><td><?= htmlspecialchars($device['graphics'] ?? 'None') ?></td></tr>
            <tr><th>RAM (GB)</th><td><?= htmlspecialchars($device['ram']) ?></td></tr>
            <tr><th>Storage</th><td><?= htmlspecialchars($device['storage_type'].' '.$device['storage_capacity'].' GB') ?></td></tr>
            <tr><th>Touch</th><td><?= htmlspecialchars($device['touch'] ?? '-') ?></td></tr>
            <tr><th>Status</th><td><?= htmlspecialchars($device['status']) ?></td></tr>
            <tr><th>Added By</th><td><?= htmlspecialchars($device['added_by_name'] ?? 'Unknown') ?></td></tr>
            <tr><th>Date Added</th><td><?= htmlspecialchars(date('Y-m-d H:i:s', strtotime($device['date_added'] ?? 'now'))) ?></td></tr>
        </table>

        <h3 style="margin-top:20px">Maintenance History</h3>
        <?php if(empty($maintenance_history)): ?>
            <div class="small">No maintenance records for this device.</div>
        <?php else: ?>
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
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
                <?php $i=1; foreach($maintenance_history as $m): ?>
                    <tr>
                        <td><?= $i++ ?></td>
                        <td><?= htmlspecialchars($m['old_ram']) ?></td>
                        <td><?= htmlspecialchars($m['new_ram']) ?></td>
                        <td><?= htmlspecialchars($m['old_storage']) ?></td>
                        <td><?= htmlspecialchars($m['new_storage']) ?></td>
                        <td><?= htmlspecialchars($m['old_graphics'] ?? '-') ?></td>
                        <td><?= htmlspecialchars($m['new_graphics'] ?? '-') ?></td>
                        <td><?= htmlspecialchars($m['performed_by_name']) ?></td>
                        <td><?= htmlspecialchars($m['notes'] ?? '-') ?></td>
                        <td><?= htmlspecialchars(date('Y-m-d H:i:s', strtotime($m['date_performed']))) ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    <?php endif; ?>
</div>
</body>
</html>
