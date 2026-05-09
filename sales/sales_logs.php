<?php
session_start();
require_once "../config/db.php";
require_once "../includes/auth_check.php";

if(!in_array($_SESSION['role'], ['super_admin', 'sales', 'manager'])) {
    die("Access denied!");
}

$role = $_SESSION['role'];
$user_id = $_SESSION['user_id'];

// --- Fetch Sales Team for Dropdown (super_admin only) ---
$salesUsers = [];
if ($role === 'super_admin') {
    $uStmt = $conn->query("SELECT id, full_name, branch FROM users WHERE role = 'sales'");
    $salesUsers = $uStmt->fetchAll(PDO::FETCH_ASSOC);
}

// --- Handle Filters ---
$filter_time = $_GET['filter_time'] ?? '';
$filter_user = $_GET['filter_user'] ?? '';
$filter_branch = $_GET['filter_branch'] ?? '';

// Get unique branches from sales users for branch filter
$branches = [];
if ($role === 'super_admin') {
    foreach($salesUsers as $su) {
        if($su['branch'] && !in_array($su['branch'], $branches)) {
            $branches[] = $su['branch'];
        }
    }
    sort($branches);
}

// Base Query - Added branch column
$sql = "SELECT sd.*, c.category_name, u.full_name AS sold_by_name, u.branch
        FROM sold_devices sd
        JOIN categories c ON sd.category_id = c.id
        JOIN users u ON sd.sold_by = u.id
        WHERE 1";

$params = [];

// If sales role → restrict to their sales only
if ($role === 'sales') {
    $sql .= " AND sd.sold_by = :uid";
    $params['uid'] = $user_id;
}

// Filter by salesperson (super_admin only)
if ($role === 'super_admin' && $filter_user !== '') {
    $sql .= " AND sd.sold_by = :salesid";
    $params['salesid'] = $filter_user;
}

// Filter by branch (super_admin only)
if ($role === 'super_admin' && $filter_branch !== '') {
    $sql .= " AND u.branch = :branch";
    $params['branch'] = $filter_branch;
}

// TIME FILTERS
if ($filter_time === "today") {
    $sql .= " AND DATE(sd.sold_at) = CURDATE()";
}
elseif ($filter_time === "week") {
    $sql .= " AND YEARWEEK(sd.sold_at, 1) = YEARWEEK(CURDATE(), 1)";
}
elseif ($filter_time === "month") {
    $sql .= " AND YEAR(sd.sold_at) = YEAR(CURDATE()) 
              AND MONTH(sd.sold_at) = MONTH(CURDATE())";
}
elseif ($filter_time === "year") {
    $sql .= " AND YEAR(sd.sold_at) = YEAR(CURDATE())";
}

$sql .= " ORDER BY sd.sold_at DESC";

$stmt = $conn->prepare($sql);
$stmt->execute($params);
$sales = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Sales Logs</title>
<style>
body { font-family: Arial, sans-serif; background:#f4f7f6; margin:0; padding:0; }
.container { max-width:1200px; margin:50px auto; background:#fff; padding:30px; border-radius:8px; box-shadow:0 4px 15px rgba(0,0,0,0.1); }
h2 { text-align:center; color:#2f7a3f; margin-bottom:20px; }
table { width:100%; border-collapse: collapse; margin-top:20px; }
th, td { border:1px solid #ccc; padding:10px; text-align:left; font-size:0.9em; }
th { background:#2f7a3f; color:#fff; }
tr:nth-child(even) { background:#f9f9f9; }
.filter-box { display:flex; gap:15px; align-items:center; margin-bottom:15px; }
select, button { padding:8px; border-radius:5px; border:1px solid #ccc; }
button { background:#2f7a3f; color:white; border:none; cursor:pointer; }
button:hover { background:#1f5a2d; }
</style>
<script>
// Auto-submit form when dropdown selection changes
function autoApplyFilters() {
    document.getElementById('filterForm').submit();
}

// Function to clear all filters
function clearFilters() {
    // Reset dropdowns to default
    document.querySelector('select[name="filter_time"]').value = '';
    <?php if ($role === 'super_admin'): ?>
    document.querySelector('select[name="filter_user"]').value = '';
    document.querySelector('select[name="filter_branch"]').value = '';
    <?php endif; ?>
    // Submit the form
    document.getElementById('filterForm').submit();
}
</script>
</head>
<body>
<div class="container">

<a href="/inventory_system/dashboard/index.php"
   style="padding:10px 15px; background:#007bff; color:white; border-radius:6px;
          text-decoration:none; font-weight:bold;">
    Dashboard
</a>

<h2>Sales Logs</h2>

<form method="GET" id="filterForm">

<div class="filter-box">

    <!-- TIME FILTER with onchange event -->
    <select name="filter_time" onchange="autoApplyFilters()">
        <option value="">--All Time--</option>
        <option value="today" <?= $filter_time=="today"?"selected":"" ?>>Today</option>
        <option value="week" <?= $filter_time=="week"?"selected":"" ?>>This Week</option>
        <option value="month" <?= $filter_time=="month"?"selected":"" ?>>This Month</option>
        <option value="year" <?= $filter_time=="year"?"selected":"" ?>>This Year</option>
    </select>

    <!-- SALES PERSON FILTER (SUPER ADMIN ONLY) with onchange event -->
    <?php if ($role === 'super_admin'): ?>
    <select name="filter_user" onchange="autoApplyFilters()">
        <option value="">--All Salespersons--</option>
        <?php foreach ($salesUsers as $su): ?>
            <option value="<?= $su['id'] ?>" 
                <?= $filter_user==$su['id'] ? "selected" : "" ?>>
                <?= htmlspecialchars($su['full_name']) ?>
            </option>
        <?php endforeach; ?>
    </select>
    
    <!-- BRANCH FILTER (SUPER ADMIN ONLY) with onchange event -->
    <select name="filter_branch" onchange="autoApplyFilters()">
        <option value="">--All Branches--</option>
        <?php foreach ($branches as $branch): ?>
            <option value="<?= htmlspecialchars($branch) ?>" 
                <?= $filter_branch==$branch ? "selected" : "" ?>>
                <?= htmlspecialchars($branch) ?>
            </option>
        <?php endforeach; ?>
    </select>
    <?php endif; ?> 
    <!-- Optional: Add a Clear Filters button -->
    <button type="button" onclick="clearFilters()" style="background:#dc3545;">Clear Filters</button>

</div>

</form>

<?php if(count($sales) === 0): ?>
    <p style="text-align:center;">No sales found.</p>
<?php else: ?>
    <table>
        <tr>
            <th>#</th>
            <th>Serial Number</th>
            <th>Category</th>
            <th>Model</th>
            <th>Branch</th>
            <th>Processor</th>
            <th>Graphics</th>
            <th>RAM</th>
            <th>Storage</th>
            <th>Touch</th>
            <th>Sold By</th>
            <th>Date Sold</th>
        </tr>

        <?php $i = 1; foreach($sales as $s): ?>
        <tr>
            <td><?= $i++ ?></td>
            <td><?= htmlspecialchars($s['serial_number']) ?></td>
            <td><?= htmlspecialchars($s['category_name']) ?></td>
            <td><?= htmlspecialchars($s['model_name']) ?></td>
            <td style=" color:<?= $s['branch'] == 'KIMATHI' ? '#2f7a3f' : '#007bff' ?>;">
                <?= htmlspecialchars($s['branch']) ?>
            </td>
            <td><?= htmlspecialchars($s['processor']) ?></td>
            <td><?= htmlspecialchars($s['graphics']) ?></td>
            <td><?= htmlspecialchars($s['ram']) ?> GB</td>
            <td><?= htmlspecialchars($s['storage_type'].' '.$s['storage_capacity'].'GB') ?></td>
            <td><?= strtolower($s['category_name'])==="desktop" ? "N/A" : htmlspecialchars($s['touch']??'N/A') ?></td>
            <td><?= htmlspecialchars($s['sold_by_name']) ?></td>
            <td><?= htmlspecialchars($s['sold_at']) ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
<?php endif; ?>

</div>
</body>
</html>