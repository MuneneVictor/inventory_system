<?php
session_start();
require_once "../config/db.php";
require_once "../includes/auth_check.php";

// Only sales users can access
if($_SESSION['role'] !== 'sales'){
    die("Access denied!");
}

$user_id = $_SESSION['user_id'];
$filter_time = $_GET['filter_time'] ?? '';
$search_sn = trim($_GET['sn'] ?? '');
$search_model = trim($_GET['model'] ?? ''); // Search by model

// Fetch sales done by the logged-in user and join with categories
$sql = "
    SELECT sd.*, c.category_name
    FROM sold_devices sd
    LEFT JOIN categories c ON sd.category_id = c.id
    WHERE sd.sold_by = :uid
";
$params = ['uid' => $user_id];

// TIME FILTERS
if ($filter_time === "today") {
    $sql .= " AND DATE(sd.sold_at) = CURDATE()";
} elseif ($filter_time === "week") {
    $sql .= " AND YEARWEEK(sd.sold_at, 1) = YEARWEEK(CURDATE(), 1)";
} elseif ($filter_time === "month") {
    $sql .= " AND YEAR(sd.sold_at) = YEAR(CURDATE()) 
              AND MONTH(sd.sold_at) = MONTH(CURDATE())";
} elseif ($filter_time === "year") {
    $sql .= " AND YEAR(sd.sold_at) = YEAR(CURDATE())";
}

// SERIAL NUMBER SEARCH
if ($search_sn) {
    $sql .= " AND sd.serial_number LIKE :sn";
    $params['sn'] = "%$search_sn%";
}

// MODEL SEARCH
if ($search_model) {
    $sql .= " AND sd.model_name LIKE :model";
    $params['model'] = "%$search_model%";
}

$sql .= " ORDER BY sd.sold_at DESC";

$stmt = $conn->prepare($sql);
$stmt->execute($params);
$sales = $stmt->fetchAll(PDO::FETCH_ASSOC);

$has_sales = count($sales) > 0;

// Calculate total sales amount for the filtered results
$total_sales_amount = 0;
foreach($sales as $sale) {
    $total_sales_amount += $sale['price'] ? (float)$sale['price'] : 0;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>My Sales</title>
<style>
body{font-family:Arial; background:#f4f7f6; padding:20px;}
.container{max-width:1100px;margin:50px auto;background:#fff;padding:30px;border-radius:8px; 
          box-shadow:0 4px 15px rgba(0,0,0,0.1);}
h2{text-align:center;color:#2f7a3f;margin-bottom:20px;}
table{width:100%;border-collapse:collapse;}
th, td{padding:10px;border:1px solid #ccc;text-align:left;}
th{background:#2f7a3f;color:#fff;}
tr:nth-child(even){background:#f4f7f6;}
.filter-box{display:flex; gap:10px; align-items:center; margin-bottom:15px; flex-wrap:nowrap;}
select, input[type=text], button{padding:8px; border-radius:5px; border:1px solid #ccc; font-size:14px;}
button{background:#2f7a3f;color:white;border:none; cursor:pointer; white-space:nowrap;}
button:hover{background:#1f5a2d;}
a.download-btn{padding:8px 12px; background:#2f7a3f; color:white; border-radius:5px; text-decoration:none; white-space:nowrap;}
a.download-btn:hover{background:#1f5a2d;}
.hidden{display:none;}
.search-input{min-width:120px;}
.select-filter{min-width:130px;}
.total-summary {
    margin: 15px 0;
    padding: 15px;
    background: #e8f5e8;
    border-radius: 5px;
    border-left: 4px solid #2f7a3f;
    font-size: 16px;
    font-weight: bold;
}
.total-amount {
    color: #2f7a3f;
    font-size: 18px;
}
</style>

<script>
// Auto-submit when time filter changes
function autoApplyFilter() {
    document.getElementById('salesFilterForm').submit();
}

// Press Enter to filter
function handleEnterKey(event) {
    if (event.key === 'Enter') {
        event.preventDefault();
        autoApplyFilter();
    }
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

<h2>My Sales</h2>

<form method="GET" id="salesFilterForm">
<div class="filter-box">

    <input type="text" 
           name="sn" 
           placeholder="Search by serial No." 
           value="<?= htmlspecialchars($search_sn) ?>" 
           onkeydown="handleEnterKey(event)"
           class="search-input">

    <input type="text" 
           name="model" 
           placeholder="Search by model" 
           value="<?= htmlspecialchars($search_model) ?>" 
           onkeydown="handleEnterKey(event)"
           class="search-input">

    <select name="filter_time" onchange="autoApplyFilter()" class="select-filter">
        <option value="">All Time</option>
        <option value="today" <?= $filter_time=="today"?"selected":"" ?>>Today</option>
        <option value="week" <?= $filter_time=="week"?"selected":"" ?>>This Week</option>
        <option value="month" <?= $filter_time=="month"?"selected":"" ?>>This Month</option>
        <option value="year" <?= $filter_time=="year"?"selected":"" ?>>This Year</option>
    </select>

    <button type="submit">Apply</button>

    <?php if($has_sales): ?>
    <a class="download-btn" href="download_sales_pdf.php?filter_time=<?= $filter_time ?>&sn=<?= urlencode($search_sn) ?>&model=<?= urlencode($search_model) ?>">Download PDF</a>
    <?php endif; ?>

</div>
</form>

<?php if($has_sales): ?>

<!-- Total Sales Summary -->
<div class="total-summary">
    Total Sales: <span class="total-amount">KES <?= number_format($total_sales_amount, 2) ?></span>
    • Showing: <?= count($sales) ?> device(s)
    <?php if($search_sn): ?> • Serial: "<?= htmlspecialchars($search_sn) ?>"<?php endif; ?>
    <?php if($search_model): ?> • Model: "<?= htmlspecialchars($search_model) ?>"<?php endif; ?>
    <?php if($filter_time): ?> • Period: <?= ucfirst($filter_time) ?><?php endif; ?>
</div>

<table>
    <tr>
        <th>#</th>
        <th>Serial Number</th>
        <th>Model</th>
        <th>Category</th>
        <th>RAM</th>
        <th>Storage</th>
        <th>Graphics</th>
        <th>Touch</th>
        <th>Price (KES)</th>
        <th>Sold on</th>
    </tr>

    <?php $i=1; foreach($sales as $row): ?>
    <tr>
        <td><?= $i++ ?></td>
        <td><?= htmlspecialchars($row['serial_number']) ?></td>
        <td><?= htmlspecialchars($row['model_name']) ?></td>
        <td><?= htmlspecialchars($row['category_name'] ?? '-') ?></td>
        <td><?= htmlspecialchars($row['ram']) ?> GB</td>
        <td><?= htmlspecialchars($row['storage_type'].' '.$row['storage_capacity'].'GB') ?></td>
        <td><?= htmlspecialchars($row['graphics'] ?? 'N/A') ?></td>
        <td>
            <?= strtolower($row['category_name'] ?? '')==="desktop"
                ? "N/A"
                : htmlspecialchars($row['touch'] ?? 'N/A') ?>
        </td>
        <td><?= $row['price'] ? 'KES ' . number_format($row['price'], 2) : 'Not priced' ?></td>
        <td><?= htmlspecialchars($row['sold_at']) ?></td>
    </tr>
    <?php endforeach; ?>

</table>

<?php else: ?>
<p style="text-align:center; padding:20px; background:#f8f9fa; border-radius:5px;">
    <?php if($search_sn || $search_model || $filter_time): ?>
    No sales found matching your search criteria.
    <?php else: ?>
    You haven't sold any devices yet.
    <?php endif; ?>
</p>
<?php endif; ?>

</div>
</body>
</html>