<?php
session_start();
require_once "../config/db.php";
require_once "../includes/auth_check.php";

$role = $_SESSION['role'];
$user_id = $_SESSION['user_id'];

$search = trim($_GET['serial'] ?? '');
$device = null;
$repairs = [];

if ($search) {
    // Only search devices that are In Stock (as requested)
    $stmt = $conn->prepare("SELECT d.*, c.category_name, u.full_name AS added_by_name
                            FROM devices d
                            LEFT JOIN categories c ON d.category_id = c.id
                            LEFT JOIN users u ON d.added_by = u.id
                            WHERE d.serial_number = :sn AND d.status = 'In Stock' LIMIT 1");
    $stmt->execute(['sn' => $search]);
    $device = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($device) {
        // fetch all repairs for this serial (historical)
        $rstmt = $conn->prepare("SELECT r.*, u1.full_name as technician_name, u2.full_name as given_by_name
                                 FROM repairs r
                                 LEFT JOIN users u1 ON r.added_by = u1.id
                                 LEFT JOIN users u2 ON r.given_by = u2.id
                                 WHERE r.serial_number = :sn ORDER BY r.date_fixed DESC");
        $rstmt->execute(['sn' => $search]);
        $repairs = $rstmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Search Device (Repairs)</title>
<style>
body{font-family:Arial;background:#f4f7f6;margin:0;padding:0}
.container{max-width:900px;margin:30px auto;background:#fff;padding:25px;border-radius:8px;box-shadow:0 4px 15px rgba(0,0,0,0.1)}
h2{color:#2f7a3f;text-align:center;margin-bottom:15px}
input[type=text]{padding:10px;border:1px solid #ccc;border-radius:5px;width:60%}
button{padding:10px 14px;background:#2f7a3f;border:none;color:#fff;border-radius:5px;cursor:pointer}
.table{width:100%;border-collapse:collapse;margin-top:15px}
.table th,.table td{padding:10px;border:1px solid #ddd;text-align:left}
.table th{background:#2f7a3f;color:#fff}
.small{font-size:0.9em;color:#666}
</style>
</head>
<body>
<div class="container">
    <a href="/inventory_system/dashboard/index.php" style="float:left;margin-bottom:10px;padding:8px 12px;background:#007bff;color:#fff;border-radius:6px;text-decoration:none;">Dashboard</a>
    <h2>Search Device (Repairs)</h2>

    <form method="GET" style="margin-bottom:15px;">
        <input type="text" name="serial" placeholder="Scan or enter serial number" value="<?= htmlspecialchars($search) ?>" autofocus>
        <button type="submit">Search</button>
    </form>

    <?php if($search && !$device): ?>
        <p class="small">No matching In Stock device found with that serial number.</p>
    <?php endif; ?>

    <?php if($device): ?>
        <div>
            <h4>Device Details</h4>
            <table class="table">
                <tr><th>Serial</th><td><?= htmlspecialchars($device['serial_number']) ?></td></tr>
                <tr><th>Model</th><td><?= htmlspecialchars($device['model_name'] ?? '-') ?></td></tr>
                <tr><th>Category</th><td><?= htmlspecialchars($device['category_name'] ?? '-') ?></td></tr>
                <tr><th>RAM</th><td><?= htmlspecialchars($device['ram'] ?? '-') ?> GB</td></tr>
                <tr><th>Storage</th><td><?= htmlspecialchars(($device['storage_type'] ?? '') . ' ' . ($device['storage_capacity'] ?? '') . 'GB') ?></td></tr>
                <tr><th>Processor</th><td><?= htmlspecialchars($device['processor'] ?? '-') ?></td></tr>
                <tr><th>Graphics</th><td><?= htmlspecialchars($device['graphics'] ?? '-') ?></td></tr>
                <tr><th>Branch</th><td><?= htmlspecialchars($device['branch'] ?? '-') ?></td></tr>
            </table>
        </div>

        <div style="margin-top:16px;">
            <h4>Repair History</h4>
            <?php if(empty($repairs)): ?>
                <p class="small">No repairs recorded for this device.</p>
            <?php else: ?>
                <table class="table">
                    <thead><tr><th>#</th><th>Problem</th><th>Fix</th><th>Technician</th><th>Given By</th><th>Date</th></tr></thead>
                    <tbody>
                    <?php $k=1; foreach($repairs as $r): ?>
                        <tr>
                            <td><?= $k++ ?></td>
                            <td><?= htmlspecialchars($r['problem_description'] ?? '-') ?></td>
                            <td><?= htmlspecialchars($r['fix_status'] ?? '-') ?></td>
                            <td><?= htmlspecialchars($r['technician_name'] ?? '-') ?></td>
                            <td><?= htmlspecialchars($r['given_by_name'] ?? '-') ?></td>
                            <td><?= htmlspecialchars(date('Y-m-d H:i:s', strtotime($r['date_fixed'] ?? '')) ) ?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</div>
</body>
</html>
