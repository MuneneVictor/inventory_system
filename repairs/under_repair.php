<?php
session_start();
require_once "../config/db.php";
require_once "../includes/auth_check.php";

$role = $_SESSION['role'];
$user_id = $_SESSION['user_id'];
$branch = $_SESSION['branch'] ?? '';

// Ensure branch is set for inventory_admin and manager
if (in_array($role, ['inventory_admin', 'manager']) && empty($branch)) {
    $stmt = $conn->prepare("SELECT branch FROM users WHERE id = :id");
    $stmt->execute(['id' => $user_id]);
    $branch = $stmt->fetchColumn();
    $_SESSION['branch'] = $branch;
}

// Base WHERE
$where = "r.fix_status = 'Not Fixed'";
$params = [];

// Role-based filters
if ($role === 'technician') {
    $where .= " AND r.added_by = :uid";
    $params['uid'] = $user_id;
} elseif (in_array($role, ['inventory_admin', 'manager'])) {
    if (!empty($branch)) {
        $where .= " AND r.branch = :branch";
        $params['branch'] = $branch;
    } else {
        // Prevent showing repairs if branch is unknown
        $where .= " AND 1=0";
    }
}
// Super admin sees all branches: no extra filter needed

// Fetch repairs with given_by user name
$sql = "
SELECT 
    r.id,
    r.serial_number,
    r.problem_description,
    r.date_added,
    r.branch,
    r.given_by,
    d.model_name,
    d.processor,
    d.ram,
    d.storage_type,
    d.storage_capacity,
    d.touch,
    d.graphics,
    c.category_name,
    u1.full_name AS added_by_name,
    u2.full_name AS given_by_name
FROM repairs r
JOIN devices d ON r.serial_number = d.serial_number
JOIN categories c ON d.category_id = c.id
LEFT JOIN users u1 ON r.added_by = u1.id
LEFT JOIN users u2 ON r.given_by = u2.id
WHERE $where
ORDER BY r.date_added DESC
";

try {
    $stmt = $conn->prepare($sql);
    $stmt->execute($params);
    $repairs = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    $error = "Database error: " . $e->getMessage();
    $repairs = [];
}

// Mark repair as fixed (Technician only)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['fix_id']) && $role === 'technician') {
    $id = (int)$_POST['fix_id'];
    try {
        $conn->beginTransaction();
        // Get serial number
        $stmt = $conn->prepare("SELECT serial_number FROM repairs WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $sn = $stmt->fetchColumn();

        // Update repair
        $stmt = $conn->prepare("UPDATE repairs SET fix_status = 'Fixed', date_fixed = NOW() WHERE id = :id");
        $stmt->execute(['id' => $id]);

        // Update device status
        $stmt = $conn->prepare("UPDATE devices SET status = 'In Stock' WHERE serial_number = :sn");
        $stmt->execute(['sn' => $sn]);

        $conn->commit();
        header("Location: under_repair.php");
        exit;
    } catch (Exception $e) {
        $conn->rollBack();
        $error = "Error updating repair: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Under Repair - Inventory System</title>
<style>
body{font-family:Arial;background:#f4f6f8;margin:0;padding:0;}
.container{max-width:1400px;margin:30px auto;background:#fff;padding:20px;border-radius:8px;box-shadow:0 2px 10px rgba(0,0,0,0.1);}
table{width:100%;border-collapse:collapse;margin-top:15px;}
th,td{border:1px solid #ccc;padding:8px;text-align:left;font-size:1rem}
th{background:#2f7a3f;color:#fff}
button{padding:6px 10px;background:#2f7a3f;color:#fff;border:none;border-radius:4px;cursor:pointer;font-size:14px}
button:hover{background:#1f5a2d}
.dashboard-btn{display:inline-block;margin-bottom:15px;padding:8px 12px;background:#007bff;color:#fff;border-radius:6px;text-decoration:none;font-weight:bold;font-size:14px}
.dashboard-btn:hover{background:#0056b3;text-decoration:none}
</style>
</head>
<body>
<div class="container">
    <a href="/inventory_system/dashboard/index.php" class="dashboard-btn">Dashboard</a>
    <h2 style="text-align:center; color:#2f7a3f">Devices Under Repair</h2>
    
    <?php if(isset($error)): ?>
        <div style="color:red;padding:10px;background:#ffe6e6;border-radius:4px;margin-bottom:15px;">
            <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>
    
    <?php if(empty($repairs)): ?>
        <p>No devices currently under repair.</p>
    <?php else: ?>
        <table>
            <tr>
                <th>#</th>
                <th>Serial</th>
                <th>Category</th>
                <th>Model</th>
                <th>Processor</th>
                <th>RAM</th>
                <th>Storage</th>
                <th>Touch</th>
                <th>Graphics</th>
                <th>Problem</th>
                <th>Given By</th>
                <?php if(in_array($role, ['super_admin','inventory_admin','manager'])): ?>
                    <th>Added By</th>
                    <th>Branch</th>
                    <th>Date Added</th>
                <?php endif; ?>
                <?php if($role==='technician'): ?>
                    <th>Action</th>
                <?php endif; ?>
            </tr>
            <?php foreach($repairs as $i=>$r): ?>
            <tr>
                <td><?= $i+1 ?></td>
                <td><?= htmlspecialchars($r['serial_number']) ?></td>
                <td><?= htmlspecialchars($r['category_name']) ?></td>
                <td><?= htmlspecialchars($r['model_name']) ?></td>
                <td><?= htmlspecialchars($r['processor']) ?></td>
                <td><?= htmlspecialchars($r['ram']) ?>GB</td>
                <td><?= htmlspecialchars($r['storage_type'].' '.$r['storage_capacity'].'GB') ?></td>
                <td><?= htmlspecialchars($r['touch'] ?? 'N/A') ?></td>
                <td><?= htmlspecialchars($r['graphics']) ?></td>
                <td><?= htmlspecialchars($r['problem_description']) ?></td>
                <td><?= htmlspecialchars($r['given_by_name'] ?? 'Unknown') ?></td>
                <?php if(in_array($role, ['super_admin','inventory_admin','manager'])): ?>
                    <td><?= htmlspecialchars($r['added_by_name'] ?? 'Unknown') ?></td>
                    <td><?= htmlspecialchars($r['branch'] ?? 'N/A') ?></td>
                    <td><?= date('Y-m-d H:i', strtotime($r['date_added'])) ?></td>
                <?php endif; ?>
                <?php if($role==='technician'): ?>
                    <td>
                        <form method="post" onsubmit="return confirm('Mark this device as fixed?');">
                            <input type="hidden" name="fix_id" value="<?= $r['id'] ?>">
                            <button type="submit">Mark as Fixed</button>
                        </form>
                    </td>
                <?php endif; ?>
            </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
</div>
</body>
</html>