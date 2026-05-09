<?php
session_start();
require_once "../config/db.php";
require_once "../includes/auth_check.php";

$role = $_SESSION['role'];
$user_id = $_SESSION['user_id'];

if (!in_array($role, ['super_admin', 'inventory_admin', 'manager'])) {
    header("Location: /inventory_system/dashboard/index.php");
    exit();
}

// Get user's branch if not super_admin
$user_branch = null;
if ($role !== 'super_admin') {
    $stmt = $conn->prepare("SELECT branch FROM users WHERE id = ?");
    $stmt->execute([$user_id]);
    $user_data = $stmt->fetch(PDO::FETCH_ASSOC);
    $user_branch = $user_data['branch'] ?? null;
}

// Get filter values
$filter_serial = $_GET['serial'] ?? '';
$filter_branch = $_GET['branch'] ?? '';

$sql = "
SELECT 
    p.serial_number,
    p.model_name,
    p.branch,
    p.date_sold,
    u1.full_name AS added_by,
    u2.full_name AS sold_by
FROM printers p
JOIN users u1 ON p.added_by = u1.id
LEFT JOIN users u2 ON p.sold_by = u2.id
WHERE p.status = 'Sold'
";

$params = [];

// Super admin sees all branches, others see only their branch
if ($role !== 'super_admin') {
    $sql .= " AND p.branch = ?";
    $params[] = $user_branch;
}

// Apply filters
if ($filter_serial) {
    $sql .= " AND p.serial_number LIKE ?";
    $params[] = "%$filter_serial%";
}

if ($role === 'super_admin' && $filter_branch) {
    $sql .= " AND p.branch = ?";
    $params[] = $filter_branch;
}

$sql .= " ORDER BY p.date_sold DESC";

$stmt = $conn->prepare($sql);
$stmt->execute($params);
$printers = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Sold Printers</title>

<style>
body {
    font-family: Arial, sans-serif;
    background:#f4f7f6;
    margin:0;
}

.container {
    max-width:1200px;
    margin:30px auto;
    background:#fff;
    padding:25px;
    border-radius:8px;
    box-shadow:0 4px 15px rgba(0,0,0,0.1);
}

h2 {
    text-align:center;
    color:#2f7a3f;
}

table {
    width:100%;
    border-collapse:collapse;
    margin-top:20px;
}

th, td {
    border:1px solid #ccc;
    padding:8px;
}

th {
    background:#2f7a3f;
    color:white;
}
.branch-info {
    padding:10px;
    background:#e7f3ff;
    border-left:4px solid #007bff;
    margin-bottom:15px;
    border-radius:4px;
}
.filter-form {
    margin:20px 0;
    display:flex;
    gap:10px;
    align-items:center;
}
.filter-form input, .filter-form select {
    padding:8px;
    border:1px solid #ccc;
    border-radius:4px;
}
.search-btn {
    padding:8px 15px;
    background:#2f7a3f;
    color:#fff;
    border:none;
    border-radius:4px;
    cursor:pointer;
}
</style>

<script>
function autoApplyFilter() {
    document.getElementById('filterForm').submit();
}

function handleEnterKey(event) {
    if (event.key === 'Enter') {
        autoApplyFilter();
    }
}
</script>
</head>

<body>

<div class="container">

<a href="/inventory_system/dashboard/index.php"
   style="background:#007bff;color:white;padding:8px 12px;border-radius:5px;text-decoration:none;">
Dashboard
</a>

<h2>Sold Printers</h2>

<div class="branch-info">
    <strong>Showing sold printers from:</strong> 
    <?php if($role === 'super_admin'): ?>
        All branches
    <?php else: ?>
        Your branch: <strong><?= htmlspecialchars($user_branch) ?></strong>
    <?php endif; ?>
    • Total: <?= count($printers) ?> printer(s)
</div>

<form method="GET" id="filterForm" class="filter-form">
    <input type="text" 
           name="serial" 
           placeholder="Search by serial number..."
           value="<?= htmlspecialchars($filter_serial) ?>"
           onkeydown="handleEnterKey(event)"
           autofocus>
    
    <?php if($role === 'super_admin'): ?>
        <select name="branch" onchange="autoApplyFilter()">
            <option value="">-- All Branches --</option>
            <option value="KIMATHI" <?= $filter_branch == 'KIMATHI' ? 'selected' : '' ?>>KIMATHI</option>
            <option value="MOI" <?= $filter_branch == 'MOI' ? 'selected' : '' ?>>MOI</option>
        </select>
    <?php endif; ?>
    
    <button type="submit" class="search-btn">Search</button>
</form>

<table>
<tr>
    <th>#</th>
    <th>Serial Number</th>
    <th>Model</th>
    <th>Branch</th>
    <th>Added By</th>
    <th>Sold By</th>
    <th>Date Sold</th>
</tr>

<?php if ($printers): ?>
<?php $i=1; foreach ($printers as $p): ?>
<tr>
    <td><?= $i++ ?></td>
    <td><?= htmlspecialchars($p['serial_number']) ?></td>
    <td><?= htmlspecialchars($p['model_name']) ?></td>
    <td><?= htmlspecialchars($p['branch']) ?></td>
    <td><?= htmlspecialchars($p['added_by']) ?></td>
    <td><?= htmlspecialchars($p['sold_by'] ?? 'N/A') ?></td>
    <td><?= $p['date_sold'] ? date('Y-m-d H:i', strtotime($p['date_sold'])) : '-' ?></td>
</tr>
<?php endforeach; ?>
<?php else: ?>
<tr>
    <td colspan="7" style="text-align:center;">
        No sold printers found.<?php if($filter_serial): ?> Try adjusting your filters.<?php endif; ?>
</tr>
<?php endif; ?>

</table>
</div>
</body>
</html>