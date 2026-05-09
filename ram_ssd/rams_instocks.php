<?php
session_start();
require_once "../config/db.php";
require_once "../includes/auth_check.php";

// Check if user is logged in
if(!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

$role = $_SESSION['role'];
$user_id = $_SESSION['user_id'];

if(!in_array($role, ['inventory_admin','super_admin', 'manager'])){
    header("Location: ../dashboard/index.php");
    exit();
}

// Fetch user's branch for inventory_admin
$user_branch = null;
if($role === 'inventory_admin') {
    $user_stmt = $conn->prepare("SELECT branch FROM users WHERE id = :user_id");
    $user_stmt->execute(['user_id' => $user_id]);
    $user_data = $user_stmt->fetch(PDO::FETCH_ASSOC);
    $user_branch = $user_data['branch'] ?? null;
}

// Get filter values
$branch_filter = $_GET['branch'] ?? '';
$category_filter = $_GET['category'] ?? '';

// Build SQL query
$sql = "SELECT r.*, u.full_name AS updated_by_name 
        FROM rams_ssds r 
        LEFT JOIN users u ON r.updated_by = u.id 
        WHERE 1 ";

$params = [];

// Apply branch filter based on role
if($role === 'inventory_admin') {
    if($user_branch) {
        $sql .= " AND r.branch = :branch";
        $params['branch'] = $user_branch;
    } else {
        // If inventory_admin has no branch assigned, show nothing
        $sql .= " AND 1=0";
    }
} elseif($role === 'super_admin' && $branch_filter) {
    // Super admin can filter by branch
    $sql .= " AND r.branch = :branch";
    $params['branch'] = $branch_filter;
}

// Apply category filter
if($category_filter) {
    $sql .= " AND r.category = :category";
    $params['category'] = $category_filter;
}

$sql .= " ORDER BY r.category, r.type, r.storage, r.branch";

$stmt = $conn->prepare($sql);
$stmt->execute($params);
$stocks = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Get available branches and categories for filters
$available_branches = [];
$available_categories = [];

if($role === 'super_admin') {
    $branch_stmt = $conn->query("SELECT DISTINCT branch FROM rams_ssds WHERE branch IS NOT NULL ORDER BY branch");
    $available_branches = $branch_stmt->fetchAll(PDO::FETCH_COLUMN);
}

// Get categories for both roles
$category_stmt = $conn->query("SELECT DISTINCT category FROM rams_ssds WHERE category IS NOT NULL ORDER BY category");
$available_categories = $category_stmt->fetchAll(PDO::FETCH_COLUMN);

// JavaScript for autofilter
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>RAM & SSDs In Stock</title>
<style>
body{font-family:Arial; background:#f4f7f6; margin:0; padding:0;}
.container{max-width:1300px;margin:30px auto;background:#fff;padding:25px;border-radius:8px;box-shadow:0 4px 15px rgba(0,0,0,0.1);}
h2{text-align:center;color:#2f7a3f;margin-bottom:20px;}
a.dashboard-btn{display:inline-block;margin-bottom:20px;background:#007bff;color:#fff;padding:10px 15px;border-radius:6px;text-decoration:none;font-weight:bold;}
a.dashboard-btn:hover{background:#005fa3;}
table{width:100%;border-collapse:collapse;margin-top:20px;}
th,td{border:1px solid #ccc;padding:10px;text-align:left;}
th{background:#2f7a3f;color:#fff;}
.filter-box { margin-bottom: 20px; padding: 15px; background: #f8f9fa; border-radius: 5px; }
.filter-box select, .filter-box button { padding: 8px 12px; border-radius: 5px; border: 1px solid #ccc; margin-right: 10px; }
.filter-box button { background: #2f7a3f; color: white; border: none; cursor: pointer; }
.filter-box button:hover { background: #1f5a2d; }
.filter-box a { margin-left: 10px; color: #dc3545; text-decoration: none; }
.filter-row { display: flex; flex-wrap: wrap; gap: 15px; margin-bottom: 15px; }
.filter-group { display: flex; flex-direction: column; }
.filter-group label { margin-bottom: 5px; font-weight: bold; color: #555; }
</style>
<script>
function autoSubmitForm() {
    // Auto-submit the filter form when any filter changes
    document.getElementById('filterForm').submit();
}

// Optional: Function to clear all filters
function clearFilters() {
    // Redirect to same page without any filter parameters
    window.location.href = window.location.pathname;
}
</script>
</head>
<body>
<div class="container">
<a href="/inventory_system/dashboard/index.php" class="dashboard-btn">Dashboard</a>
<h2>RAM & SSDs In Stock</h2>

<div class="filter-box">
    <form method="GET" id="filterForm">
        <div class="filter-row">
            <?php if($role === 'super_admin'): ?>
            <div class="filter-group">
                <label for="branch">Branch:</label>
                <select name="branch" id="branch" onchange="autoSubmitForm()">
                    <option value="">-- All Branches --</option>
                    <?php foreach($available_branches as $branch): ?>
                        <option value="<?= htmlspecialchars($branch) ?>" <?= $branch_filter==$branch?'selected':'' ?>>
                            <?= htmlspecialchars($branch) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <?php endif; ?>
            
            <div class="filter-group">
                <label for="category">Category:</label>
                <select name="category" id="category" onchange="autoSubmitForm()">
                    <option value="">-- All Categories --</option>
                    <?php foreach($available_categories as $category): ?>
                        <option value="<?= htmlspecialchars($category) ?>" <?= $category_filter==$category?'selected':'' ?>>
                            <?= htmlspecialchars($category) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div class="filter-group" style="align-self: flex-end;">
                <button type="button" onclick="clearFilters()" style="background: #dc3545;">Clear All</button>
            </div>
        </div>
        
        <!-- Hidden submit button for accessibility (optional) -->
        <button type="submit" style="display: none;">Apply Filters</button>
    </form>
    
    <?php if($branch_filter || $category_filter): ?>
        <div style="margin-top: 15px; padding: 10px; background: #e9ecef; border-radius: 5px;">
            <strong>Active Filters:</strong>
            <?php if($branch_filter): ?>
                <span style="background: #2f7a3f; color: white; padding: 3px 8px; border-radius: 3px; margin: 0 5px;">
                    Branch: <?= htmlspecialchars($branch_filter) ?>
                </span>
            <?php endif; ?>
            <?php if($category_filter): ?>
                <span style="background: #17a2b8; color: white; padding: 3px 8px; border-radius: 3px; margin: 0 5px;">
                    Category: <?= htmlspecialchars($category_filter) ?>
                </span>
            <?php endif; ?>
            <a href="?" style="margin-left: 10px; color: #dc3545;">Clear All</a>
        </div>
    <?php endif; ?>
</div>

<?php if($role === 'inventory_admin' && !$user_branch): ?>
    <p style="color:#dc3545; text-align:center;">Your account is not assigned to any branch. Please contact administrator.</p>
<?php endif; ?>

<table>
<tr>
    <th>#</th>
    <th>Category</th>
    <th>Type</th>
    <th>Storage</th>
    <th>Quantity</th>
    <th>Branch</th>
    <th>Updated By</th>
    <th>Date Updated</th>
</tr>
<?php if($stocks): $i=1; foreach($stocks as $r): ?>
<tr>
    <td><?= $i++ ?></td>
    <td><?= htmlspecialchars($r['category']) ?></td>
    <td><?= htmlspecialchars($r['type']) ?></td>
    <td><?= $r['storage'] ?> GB</td>
    <td><?= $r['quantity'] ?></td>
    <td><?= htmlspecialchars($r['branch']) ?></td>
    <td><?= htmlspecialchars($r['updated_by_name'] ?? 'N/A') ?></td>
    <td><?= htmlspecialchars(date('Y-m-d H:i:s', strtotime($r['date_updated'] ?? $r['date_added']))) ?></td>
</tr>
<?php endforeach; else: ?>
<tr><td colspan="8" style="text-align:center;">No RAM/SSD found</td></tr>
<?php endif; ?>
</table>

<?php if($stocks): ?>
<div style="margin-top: 20px; padding: 15px; background: #f4f7f6; border-radius: 5px;">
    <strong>Summary:</strong> Total <?= count($stocks) ?> item(s) in stock
    <?php 
    // Calculate total quantity
    $total_quantity = 0;
    $category_summary = [];
    foreach($stocks as $r) {
        $total_quantity += $r['quantity'];
        $category = $r['category'];
        $category_summary[$category] = ($category_summary[$category] ?? 0) + $r['quantity'];
    }
    ?>
    | Total Quantity: <?= $total_quantity ?>
    
    <?php if($category_filter === '' && count($category_summary) > 0): ?>
        | 
        <?php foreach($category_summary as $cat => $qty): ?>
            <span style="margin: 0 10px;">
                <?= htmlspecialchars($cat) ?>: <?= $qty ?>
            </span>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
<?php endif; ?>

</div>
</body>
</html>