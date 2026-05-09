<?php
session_start();
require_once "../config/db.php";
require_once "../includes/auth_check.php";

$role = $_SESSION['role'];
$user_id = $_SESSION['user_id'];

// Get user's branch if not super_admin
$user_branch = null;
if ($role !== 'super_admin') {
    $stmt = $conn->prepare("SELECT branch FROM users WHERE id=?");
    $stmt->execute([$user_id]);
    $user_branch = $stmt->fetchColumn();
}

$sql = "
SELECT p.*, u.full_name 
FROM printers p
LEFT JOIN users u ON p.added_by = u.id
WHERE p.status = 'In Stock'
";

$params = [];

// Super admin sees all branches, others see only their branch
if ($role !== 'super_admin') {
    $sql .= " AND p.branch = ?";
    $params[] = $user_branch;
}

$sql .= " ORDER BY p.date_added DESC";

$stmt = $conn->prepare($sql);
$stmt->execute($params);
$printers = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
<title>Printer Stock</title>
<style>
body { font-family: Arial; background:#f4f7f6; }
.container { max-width:1100px; margin:30px auto; background:#fff; padding:25px; border-radius:8px; box-shadow:0 4px 15px rgba(0,0,0,.1); }
h2 { text-align:center; color:#2f7a3f; }
table { width:100%; border-collapse: collapse; margin-top:20px; }
th, td { border:1px solid #ccc; padding:10px; }
th { background:#2f7a3f; color:#fff; }
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
<h2>Printer Stock</h2>
<a href="/inventory_system/dashboard/index.php"
   style="position: top:10px; right:10px; padding:10px 15px; 
          background:#007bff; color:white; border-radius:6px; 
          text-decoration:none; font-weight:bold; z-index:999;">
    Dashboard
</a> <br><br>

<div class="branch-info">
    <strong>Showing printers from:</strong> 
    <?php if($role === 'super_admin'): ?>
        All branches
    <?php else: ?>
        Your branch: <strong><?= htmlspecialchars($user_branch) ?></strong>
    <?php endif; ?>
    • Total: <?= count($printers) ?> printer(s)
</div>

<table>
<tr>
    <th>#</th>
    <th>Serial Number</th>
    <th>Model</th>
    <th>Branch</th>
    <th>Added By</th>
    <th>Date Added</th>
</tr>

<?php if(count($printers) > 0): ?>
<?php $i=1; foreach($printers as $p): ?>
<tr>
    <td><?= $i++ ?></td>
    <td><?= htmlspecialchars($p['serial_number']) ?></td>
    <td><?= htmlspecialchars($p['model_name']) ?></td>
    <td><?= htmlspecialchars($p['branch']) ?></td>
    <td><?= htmlspecialchars($p['full_name'] ?? 'Unknown') ?></td>
    <td><?= $p['date_added'] ?></td>
</tr>
<?php endforeach; ?>
<?php else: ?>
<tr>
    <td colspan="6" style="text-align:center;">No printers found in stock.</td>
</tr>
<?php endif; ?>
</table>
</div>

</body>
</html>