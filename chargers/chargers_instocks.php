<?php
session_start();
require_once "../config/db.php";
require_once "../includes/auth_check.php";

// Only super_admin and inventory_admin
if (!in_array($_SESSION['role'], ['super_admin', 'inventory_admin', 'manager'])) {
    die("Access denied!");
}

$role = $_SESSION['role'];

// Get manager's branch from database
if ($role === 'manager') {
    $user_stmt = $conn->prepare("SELECT branch FROM users WHERE id = ?");
    $user_stmt->execute([$_SESSION['user_id']]);
    $user_data = $user_stmt->fetch(PDO::FETCH_ASSOC);
    $user_branch = $user_data['branch'] ?? '';
}

// Check what columns exist in the chargers table
$stmt = $conn->prepare("DESCRIBE chargers");
$stmt->execute();
$columns = $stmt->fetchAll(PDO::FETCH_COLUMN);

// Determine the SQL query based on available columns
if (in_array('branch', $columns)) {
    // If chargers has a branch column
    if ($role === 'manager' && !empty($user_branch)) {
        // Manager sees only their branch
        $stmt = $conn->prepare("
            SELECT c.*, u.full_name AS updated_by_name
            FROM chargers c
            LEFT JOIN users u ON c.updated_by = u.id
            WHERE c.branch = ?
            ORDER BY c.date_updated DESC
        ");
        $stmt->execute([$user_branch]);
    } else {
        // Admins see all
        $stmt = $conn->prepare("
            SELECT c.*, u.full_name AS updated_by_name
            FROM chargers c
            LEFT JOIN users u ON c.updated_by = u.id
            ORDER BY c.date_updated DESC
        ");
        $stmt->execute();
    }
} else {
    // No branch information in chargers table
    $stmt = $conn->prepare("
        SELECT c.*, u.full_name AS updated_by_name
        FROM chargers c
        LEFT JOIN users u ON c.updated_by = u.id
        ORDER BY c.date_updated DESC
    ");
    $stmt->execute();
}

$chargers = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Initialize counter for auto-increment
$i = 1;
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Chargers In Stock</title>
<style>
body{font-family:Arial;background:#f4f7f6;margin:0;padding:0}
.container{max-width:1000px;margin:30px auto;background:#fff;padding:25px;border-radius:8px;box-shadow:0 4px 15px rgba(0,0,0,0.1)}
h2{color:#2f7a3f;text-align:center;margin-bottom:15px}
table{width:100%;border-collapse:collapse;margin-top:15px}
th, td{border:1px solid #ccc;padding:10px;text-align:left}
th{background:#2f7a3f;color:#fff}
button, .dashboard-btn{padding:10px 14px;background:#007bff;border:none;color:#fff;border-radius:5px;cursor:pointer;text-decoration:none;display:inline-block;margin-bottom:10px}
button:hover, .dashboard-btn:hover{background:#007bff;}
</style>
</head>
<body>
<div class="container">
<a href="/inventory_system/dashboard/index.php" class="dashboard-btn">Dashboard</a>
<h2>Chargers In Stock</h2>

<table>
    <thead>
        <tr>
            <th>#</th>
            <th>Type</th>
            <th>Watts</th>
            <th>Quantity</th>
            <th>Condition</th>
            <?php if (in_array('branch', $columns)): ?>
                <th>Branch</th>
            <?php endif; ?>
            <th>Updated By</th>
            <th>Date Updated</th>
        </tr>
    </thead>
    <tbody>
        <?php if($chargers): ?>
            <?php foreach($chargers as $c): ?>
                <tr>
                    <td><?= $i++ ?></td>
                    <td><?=htmlspecialchars($c['charger_type'])?></td>
                    <td><?=htmlspecialchars($c['watts'])?> W</td>
                    <td><?=htmlspecialchars($c['quantity'])?></td>
                    <td><?=htmlspecialchars($c['condition_type'] ?? $c['charger_condition'] ?? 'N/A')?></td>
                    <?php if (in_array('branch', $columns)): ?>
                        <td><?=htmlspecialchars($c['branch'] ?? 'N/A')?></td>
                    <?php endif; ?>
                    <td><?=htmlspecialchars($c['updated_by_name'] ?? 'Unknown')?></td>
                    <td><?=htmlspecialchars($c['date_updated'])?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="<?php echo (in_array('branch', $columns) ? 8 : 7); ?>" style="text-align:center">
                    No chargers in stock
                </td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>
</div>
</body>
</html>