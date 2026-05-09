<?php
session_start();
require_once "../config/db.php";
require_once "../includes/auth_check.php";

$role = $_SESSION['role'];
$user_id = $_SESSION['user_id'];
$branch = $_SESSION['branch'] ?? '';

// Fetch branch for inventory_admin or manager if not in session
if (empty($branch) && in_array($role, ['inventory_admin', 'manager'])) {
    $stmt = $conn->prepare("SELECT branch FROM users WHERE id = :id");
    $stmt->execute(['id' => $user_id]);
    $branch = $stmt->fetchColumn();
    $_SESSION['branch'] = $branch;
}

// Get filter values from GET request
$serial_search = $_GET['serial'] ?? '';
$branch_filter = $_GET['branch_filter'] ?? '';
$date_from = $_GET['date_from'] ?? '';
$date_to = $_GET['date_to'] ?? '';

// Build WHERE clause
$where = "r.fix_status = 'Fixed'";
$params = [];

if ($role === 'technician') {
    $where .= " AND r.added_by = :uid";
    $params['uid'] = $user_id;
} elseif (in_array($role, ['inventory_admin', 'manager'])) {
    if (!empty($branch)) {
        $where .= " AND r.branch = :branch";
        $params['branch'] = $branch;
    }
}
// Super admin sees all branches

// Apply search filters
if (!empty($serial_search)) {
    $where .= " AND r.serial_number LIKE :serial";
    $params['serial'] = '%' . $serial_search . '%';
}

if ($role === 'super_admin' && !empty($branch_filter)) {
    $where .= " AND r.branch = :branch_filter";
    $params['branch_filter'] = $branch_filter;
}

if (!empty($date_from) && !empty($date_to)) {
    $where .= " AND DATE(r.date_fixed) BETWEEN :date_from AND :date_to";
    $params['date_from'] = $date_from;
    $params['date_to'] = $date_to;
} elseif (!empty($date_from)) {
    $where .= " AND DATE(r.date_fixed) >= :date_from";
    $params['date_from'] = $date_from;
} elseif (!empty($date_to)) {
    $where .= " AND DATE(r.date_fixed) <= :date_to";
    $params['date_to'] = $date_to;
}

// Get all branches for super admin filter
$all_branches = [];
if ($role === 'super_admin') {
    $stmt = $conn->query("SELECT DISTINCT branch FROM repairs WHERE branch IS NOT NULL ORDER BY branch");
    $all_branches = $stmt->fetchAll(PDO::FETCH_COLUMN);
}

// Fetch repairs
$sql = "
SELECT 
    r.id,
    r.serial_number,
    r.problem_description,
    r.fix_status,
    r.date_fixed,
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
    u1.full_name as fixed_by_name,
    u2.full_name as given_by_name
FROM repairs r
JOIN devices d ON r.serial_number = d.serial_number
JOIN categories c ON d.category_id = c.id
LEFT JOIN users u1 ON r.added_by = u1.id
LEFT JOIN users u2 ON r.given_by = u2.id
WHERE $where
ORDER BY r.date_fixed DESC
";

try {
    $stmt = $conn->prepare($sql);
    $stmt->execute($params);
    $repairs = $stmt->fetchAll();
} catch (Exception $e) {
    $error = "Database error: " . $e->getMessage();
    $repairs = [];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Repair Logs - Inventory System</title>
<style>
body{font-family:Arial;background:#f4f6f8;margin:0;padding:0;}
.container{max-width:1400px;margin:30px auto;background:#fff;padding:20px;border-radius:8px;box-shadow:0 2px 10px rgba(0,0,0,0.1);}
table{width:100%;border-collapse:collapse;margin-top:15px;}
th,td{border:1px solid #ccc;padding:8px;text-align:left;font-size:1rem}
th{background:#2f7a3f;color:#fff}
.dashboard-btn{display:inline-block;margin-bottom:15px;padding:8px 12px;background:#007bff;color:#fff;border-radius:6px;text-decoration:none;font-weight:bold;font-size:14px}
.dashboard-btn:hover{background:#0056b3;text-decoration:none}
.filter-container{background:#f9f9f9;padding:15px;border-radius:5px;margin-bottom:20px;border:1px solid #ddd}
.filter-row{display:flex;flex-wrap:wrap;gap:15px;align-items:center;margin-bottom:10px}
.filter-group{display:flex;flex-direction:column;min-width:200px}
.filter-group label{font-size:0.9rem;font-weight:bold;margin-bottom:5px;color:#333}
.filter-group input, .filter-group select{padding:8px;border:1px solid #ccc;border-radius:4px;font-size:0.9rem}
.filter-actions{display:flex;gap:10px;margin-top:10px}
.reset-btn{background:#6c757d;color:#fff;padding:8px 12px;border:none;border-radius:4px;cursor:pointer;font-size:0.9rem;text-decoration:none;display:inline-block}
.reset-btn:hover{background:#5a6268}
.search-btn{background:#2f7a3f;color:#fff;padding:8px 12px;border:none;border-radius:4px;cursor:pointer;font-size:0.9rem}
.search-btn:hover{background:#1f5a2d}
.results-info{background:#e9f7ef;padding:10px;border-radius:4px;margin-bottom:15px;border:1px solid #c3e6cb}
</style>
</head>
<body>
<div class="container">
    <a href="/inventory_system/dashboard/index.php" class="dashboard-btn">Dashboard</a>
    <h2 style="text-align:center; color:#2f7a3f">Repair Logs</h2>

    <?php if(isset($error)): ?>
        <div style="color:red;padding:10px;background:#ffe6e6;border-radius:4px;margin-bottom:15px;">
            <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>

    <!-- Filter Form -->
    <div class="filter-container">
        <form method="GET" action="" id="filterForm">
            <div class="filter-row">
                <!-- Serial Number Search -->
                <div class="filter-group">
                    <label for="serial">Search by Serial Number:</label>
                    <input type="text" id="serial" name="serial" 
                           value="<?= htmlspecialchars($serial_search) ?>" 
                           placeholder="Scan or type serial number"
                           autofocus>
                </div>
                
                <!-- Branch Filter (Super Admin only) -->
                <?php if($role === 'super_admin'): ?>
                <div class="filter-group">
                    <label for="branch_filter">Filter by Branch:</label>
                    <select id="branch_filter" name="branch_filter" onchange="this.form.submit()">
                        <option value="">All Branches</option>
                        <?php foreach($all_branches as $br): ?>
                            <option value="<?= htmlspecialchars($br) ?>" 
                                <?= $branch_filter === $br ? 'selected' : '' ?>>
                                <?= htmlspecialchars($br) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <?php endif; ?>
                
                <!-- Date Range Filters -->
                <div class="filter-group">
                    <label for="date_from">Date Fixed From:</label>
                    <input type="date" id="date_from" name="date_from" 
                           value="<?= htmlspecialchars($date_from) ?>" 
                           onchange="document.getElementById('date_to').min=this.value">
                </div>
                
                <div class="filter-group">
                    <label for="date_to">Date Fixed To:</label>
                    <input type="date" id="date_to" name="date_to" 
                           value="<?= htmlspecialchars($date_to) ?>"
                           onchange="this.form.submit()">
                </div>
            </div>
            
            <div class="filter-actions">
                <button type="submit" class="search-btn">Search</button>
                <a href="repair_logs.php" class="reset-btn">Reset Filters</a>
            </div>
        </form>
    </div>
    
    <?php if(!empty($serial_search) || !empty($branch_filter) || !empty($date_from) || !empty($date_to)): ?>
        <div class="results-info">
            <strong>Active Filters:</strong>
            <?php 
            $filters = [];
            if (!empty($serial_search)) $filters[] = "Serial contains: '$serial_search'";
            if ($role === 'super_admin' && !empty($branch_filter)) $filters[] = "Branch: $branch_filter";
            if (!empty($date_from)) $filters[] = "From: $date_from";
            if (!empty($date_to)) $filters[] = "To: $date_to";
            echo implode(' | ', $filters);
            ?>
            | <strong>Results:</strong> <?= count($repairs) ?> device(s)
        </div>
    <?php endif; ?>

    <?php if(empty($repairs)): ?>
        <p>No repaired devices found.</p>
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
                <th>Fixed By</th>
                <th>Given By</th>
                <th>Fix Status</th>
                <th>Branch</th>
                <th>Date Fixed</th>
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
                <td><?= htmlspecialchars($r['fixed_by_name'] ?? 'Unknown') ?></td>
                <td><?= htmlspecialchars($r['given_by_name'] ?? 'Unknown') ?></td>
                <td><?= htmlspecialchars($r['fix_status']) ?></td>
                <td><?= htmlspecialchars($r['branch']) ?></td>
                <td><?= $r['date_fixed'] ? date('Y-m-d H:i', strtotime($r['date_fixed'])) : '-' ?></td>
            </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
</div>

<script>
// Auto-focus on serial input and allow scanning
document.addEventListener('DOMContentLoaded', function() {
    const serialInput = document.getElementById('serial');
    if (serialInput) {
        serialInput.focus();
        
        // Allow scanning by listening for Enter key
        serialInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                this.form.submit();
            }
        });
    }
    
    // Set date_to to today if not set
    const dateToInput = document.getElementById('date_to');
    const dateFromInput = document.getElementById('date_from');
    
    if (dateToInput && !dateToInput.value) {
        const today = new Date().toISOString().split('T')[0];
        dateToInput.value = today;
        dateToInput.min = dateFromInput ? dateFromInput.value : '';
    }
    
    // Set min date for date_to based on date_from
    if (dateFromInput && dateToInput) {
        dateToInput.min = dateFromInput.value;
    }
    
    // Auto-submit when date_from changes (only if date_to is set)
    if (dateFromInput) {
        dateFromInput.addEventListener('change', function() {
            if (this.value && document.getElementById('date_to').value) {
                setTimeout(() => document.getElementById('filterForm').submit(), 300);
            }
        });
    }
});
</script>
</body>
</html>