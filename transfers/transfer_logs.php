<?php
session_start();
require_once "../config/db.php";
require_once "../includes/auth_check.php";

// Check if user has permission
$allowed_roles = ['super_admin', 'manager', 'inventory_admin'];
if(!in_array($_SESSION['role'], $allowed_roles)) {
    die("Access denied!");
}

// Check for export request FIRST
if(isset($_GET['export']) && $_GET['export'] == 'excel') {
    // Get all filter parameters
    $start_date = isset($_GET['start_date']) ? $_GET['start_date'] : date('Y-m-d', strtotime('-30 days'));
    $end_date = isset($_GET['end_date']) ? $_GET['end_date'] : date('Y-m-d');
    $filter_category = isset($_GET['category']) ? $_GET['category'] : 'all';
    $filter_branch = isset($_GET['branch']) ? $_GET['branch'] : 'all';
    $search_query = isset($_GET['search']) ? trim($_GET['search']) : '';
    
    $end_date_with_time = $end_date . ' 23:59:59';
    
    // Build query with filters
    $sql = "
        SELECT al.*, u.full_name, u.branch as user_branch
        FROM activity_logs al
        LEFT JOIN users u ON al.user_id = u.id
        WHERE al.action LIKE '%transfer%'
        AND al.created_at BETWEEN :start_date AND :end_date
    ";
    
    $params = [
        'start_date' => $start_date . ' 00:00:00',
        'end_date' => $end_date_with_time
    ];
    
    // Add category filter
    if($filter_category !== 'all') {
        if($filter_category === 'device') {
            $sql .= " AND (al.action LIKE '%Transfer device%' OR al.action LIKE '%Bulk transfer summary%' AND al.details LIKE '%device%')";
        } elseif($filter_category === 'monitor') {
            $sql .= " AND (al.action LIKE '%Transfer monitor%' OR al.action LIKE '%Bulk transfer summary%' AND al.details LIKE '%monitor%')";
        } elseif($filter_category === 'printer') {
            $sql .= " AND (al.action LIKE '%Transfer printer%' OR al.action LIKE '%Bulk transfer summary%' AND al.details LIKE '%printer%')";
        } elseif($filter_category === 'charger') {
            $sql .= " AND (al.action LIKE '%Transfer charger%' OR al.action LIKE '%Bulk transfer summary%' AND al.details LIKE '%charger%')";
        } elseif($filter_category === 'ram_ssd') {
            $sql .= " AND (al.action LIKE '%Transfer RAM/SSD%' OR al.action LIKE '%Transfer component%' OR al.action LIKE '%Bulk transfer summary%' AND (al.details LIKE '%ram%' OR al.details LIKE '%ssd%' OR al.details LIKE '%component%'))";
        }
    }
    
    // Add branch filter
    if($filter_branch !== 'all') {
        $sql .= " AND al.details LIKE :branch";
        $params['branch'] = "%$filter_branch%";
    }
    
    // Add search query
    if(!empty($search_query)) {
        $sql .= " AND (al.details LIKE :search_details OR u.full_name LIKE :search_name)";
        $params['search_details'] = "%$search_query%";
        $params['search_name'] = "%$search_query%";
    }
    
    $sql .= " ORDER BY al.created_at DESC";
    
    $stmt = $conn->prepare($sql);
    $stmt->execute($params);
    $logs = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Set headers for Excel download
    header("Content-Type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=transfer_logs_" . date('Y-m-d') . ".xls");
    header("Pragma: no-cache");
    header("Expires: 0");
    
    // Output column headers
    echo "Date & Time\tCategory\tAction\tDetails\tUser\tUser Branch\n";
    
    foreach($logs as $log) {
        // Determine category
        $category = 'Other';
        if(strpos($log['action'], 'device') !== false || stripos($log['details'], 'device') !== false) {
            $category = 'Device';
        } elseif(strpos($log['action'], 'monitor') !== false || stripos($log['details'], 'monitor') !== false) {
            $category = 'Monitor';
        } elseif(strpos($log['action'], 'printer') !== false || stripos($log['details'], 'printer') !== false) {
            $category = 'Printer';
        } elseif(strpos($log['action'], 'charger') !== false || stripos($log['details'], 'charger') !== false) {
            $category = 'Charger';
        } elseif(strpos($log['action'], 'ram') !== false || strpos($log['action'], 'ssd') !== false || 
                strpos($log['action'], 'component') !== false || 
                stripos($log['details'], 'ram') !== false || stripos($log['details'], 'ssd') !== false ||
                stripos($log['details'], 'component') !== false) {
            $category = 'RAM/SSD';
        }
        
        // Format date
        $dateTime = date('Y-m-d h:i A', strtotime($log['created_at']));
        
        // Clean up details - remove HTML tags and line breaks, use tabs for separation
        $details = strip_tags($log['details']);
        $details = str_replace(["\r\n", "\r", "\n", "\t"], "  ", $details); // Replace newlines with double spaces
        $details = str_replace(['from ', 'to ', '(Delivered by:'], [" | From ", " | To ", " | Delivered by: "], $details);
        
        $user = $log['full_name'] ?? 'Unknown';
        $user_branch = $log['user_branch'] ?? 'N/A';
        $action = $log['action'];
        
        // Output row with tab separation
        echo $dateTime . "\t";
        echo $category . "\t";
        echo $action . "\t";
        echo $details . "\t";
        echo $user . "\t";
        echo $user_branch . "\n";
    }
    
    exit;
}

// Set default date range (last 30 days)
$start_date = date('Y-m-d', strtotime('-30 days'));
$end_date = date('Y-m-d');
$filter_category = 'all';
$filter_branch = 'all';
$search_query = '';

// Get user's current branch for filtering
$user_id = $_SESSION['user_id'];
$user_stmt = $conn->prepare("SELECT branch FROM users WHERE id = :id");
$user_stmt->execute(['id' => $user_id]);
$user = $user_stmt->fetch(PDO::FETCH_ASSOC);
$current_branch = $user['branch'] ?? null;

// Get all unique branches for filter
$branch_stmt = $conn->query("SELECT DISTINCT branch FROM users WHERE branch IS NOT NULL AND branch != '' ORDER BY branch");
$availableBranches = $branch_stmt->fetchAll(PDO::FETCH_COLUMN, 0);

// Process filters
if(isset($_GET['filter'])) {
    $start_date = $_GET['start_date'] ?? $start_date;
    $end_date = $_GET['end_date'] ?? $end_date;
    $filter_category = $_GET['category'] ?? 'all';
    $filter_branch = $_GET['branch'] ?? 'all';
    $search_query = trim($_GET['search'] ?? '');
    
    // Adjust end date to include the entire day
    $end_date_with_time = $end_date . ' 23:59:59';
} else {
    $end_date_with_time = $end_date . ' 23:59:59';
}

// Build query with filters
$sql = "
    SELECT al.*, u.full_name, u.branch as user_branch
    FROM activity_logs al
    LEFT JOIN users u ON al.user_id = u.id
    WHERE al.action LIKE '%transfer%'
    AND al.created_at BETWEEN :start_date AND :end_date
";

$params = [
    'start_date' => $start_date . ' 00:00:00',
    'end_date' => $end_date_with_time
];

// Add category filter
if($filter_category !== 'all') {
    if($filter_category === 'device') {
        $sql .= " AND (al.action LIKE '%Transfer device%' OR al.action LIKE '%Bulk transfer summary%' AND al.details LIKE '%device%')";
    } elseif($filter_category === 'monitor') {
        $sql .= " AND (al.action LIKE '%Transfer monitor%' OR al.action LIKE '%Bulk transfer summary%' AND al.details LIKE '%monitor%')";
    } elseif($filter_category === 'printer') {
        $sql .= " AND (al.action LIKE '%Transfer printer%' OR al.action LIKE '%Bulk transfer summary%' AND al.details LIKE '%printer%')";
    } elseif($filter_category === 'charger') {
        $sql .= " AND (al.action LIKE '%Transfer charger%' OR al.action LIKE '%Bulk transfer summary%' AND al.details LIKE '%charger%')";
    } elseif($filter_category === 'ram_ssd') {
        $sql .= " AND (al.action LIKE '%Transfer RAM/SSD%' OR al.action LIKE '%Transfer component%' OR al.action LIKE '%Bulk transfer summary%' AND (al.details LIKE '%ram%' OR al.details LIKE '%ssd%' OR al.details LIKE '%component%'))";
    }
}

// Add branch filter
if($filter_branch !== 'all') {
    $sql .= " AND al.details LIKE :branch";
    $params['branch'] = "%$filter_branch%";
}

// Add search query - FIXED: Use different parameter names for different conditions
if(!empty($search_query)) {
    $sql .= " AND (al.details LIKE :search_details OR u.full_name LIKE :search_name)";
    $params['search_details'] = "%$search_query%";
    $params['search_name'] = "%$search_query%";
}

// Order by most recent first
$sql .= " ORDER BY al.created_at DESC";

// Prepare and execute query
$stmt = $conn->prepare($sql);
$stmt->execute($params);
$transferLogs = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Get statistics - UPDATED: Changed 'component' to 'ram_ssd'
$stats_sql = "
    SELECT 
        COUNT(*) as total_transfers,
        SUM(CASE WHEN action LIKE '%device%' THEN 1 ELSE 0 END) as device_transfers,
        SUM(CASE WHEN action LIKE '%monitor%' THEN 1 ELSE 0 END) as monitor_transfers,
        SUM(CASE WHEN action LIKE '%printer%' THEN 1 ELSE 0 END) as printer_transfers,
        SUM(CASE WHEN action LIKE '%charger%' THEN 1 ELSE 0 END) as charger_transfers,
        SUM(CASE WHEN action LIKE '%ram%' OR action LIKE '%ssd%' OR action LIKE '%component%' THEN 1 ELSE 0 END) as ram_ssd_transfers
    FROM activity_logs 
    WHERE action LIKE '%transfer%'
    AND created_at BETWEEN :start_date AND :end_date
";

$stats_stmt = $conn->prepare($stats_sql);
$stats_stmt->execute([
    'start_date' => $start_date . ' 00:00:00',
    'end_date' => $end_date_with_time
]);
$stats = $stats_stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Transfer Logs</title>
<style>
body{font-family:Arial; background:#f4f7f6; padding:20px;}
.container{width:90%;margin:30px auto;background:#fff;padding:30px;border-radius:8px;box-shadow:0 4px 15px rgba(0,0,0,0.1);}
h2{text-align:center;color:#2f7a3f;margin-bottom:20px;}
h3{color:#2f7a3f;margin-top:30px;margin-bottom:15px;border-bottom:2px solid #2f7a3f;padding-bottom:5px;}
input, select, button, textarea{width:100%; padding:10px; margin-bottom:15px; border-radius:5px; border:1px solid #ccc;}
button{background:#2f7a3f; color:#fff; border:none; font-weight:bold; cursor:pointer;}
button:hover{background:#1f5a2d;}
.btn-secondary{background:#007bff; margin-right:10px;}
.btn-secondary:hover{background:#0056b3;}
.filter-container{background:#f8f9fa; padding:20px; border-radius:5px; margin-bottom:30px;}
.filter-row{display:flex; gap:15px; margin-bottom:15px;}
.filter-row div{flex:1;}
.filter-row label{display:block; margin-bottom:5px; font-weight:bold; color:black;}
.stats-container{display:flex; gap:15px; margin-bottom:30px; flex-wrap:wrap;}
.stat-card{flex:1; min-width:150px; background:#e8f5e9; padding:15px; border-radius:5px; text-align:center; border-left:4px solid #2f7a3f;}
.stat-card h4{margin:0 0 10px 0; color:#2f7a3f; font-size:0.9em;}
.stat-card .stat-number{font-size:1.8em; font-weight:bold; color:#1b5e20;}
table{width:100%;border-collapse:collapse;margin-top:20px;}
th,td{border:1px solid #ccc;padding:10px;text-align:left;}
th{background:#2f7a3f;color:#fff; position:sticky; top:0;}
tr:nth-child(even){background:#f4f7f6;}
tr:hover{background:#e8f5e9;}
.log-details{max-width:400px; word-wrap:break-word;}
.log-time{white-space:nowrap;}
.badge{display:inline-block; padding:3px 8px; border-radius:12px; font-size:0.8em; font-weight:bold; margin-right:5px;}
.badge-device{background:#4caf50; color:white;}
.badge-monitor{background:#2196f3; color:white;}
.badge-printer{background:#ff9800; color:white;}
.badge-charger{background:#9c27b0; color:white;}
.badge-ram-ssd{background:#f44336; color:white;}
.badge-bulk{background:#607d8b; color:white;}
.empty-state{text-align:center; padding:40px; color:#666; font-size:1.1em;}
.action-buttons{margin-bottom:20px; display:flex; justify-content:space-between;}
.export-btn{background:#28a745;}
.export-btn:hover{background:#218838;}
.auto-submit-btn{background:#17a2b8; margin-top:5px;}
.auto-submit-btn:hover{background:#138496;}
</style>
</head>
<body>
<div class="container">

<a href="/inventory_system/dashboard/index.php" style="background:#007bff;color:white;padding:8px 12px;border-radius:5px;text-decoration:none;margin-bottom:20px;display:inline-block;">Dashboard</a>

<h2>Transfer Logs</h2>

<div class="filter-container">
    <form method="GET" action="" id="filterForm">
        <input type="hidden" name="filter" value="1">
        
        <div class="filter-row">
            <div>
                <label for="start_date">Start Date:</label>
                <input type="date" name="start_date" id="start_date" value="<?= htmlspecialchars($start_date) ?>" required>
            </div>
            <div>
                <label for="end_date">End Date:</label>
                <input type="date" name="end_date" id="end_date" value="<?= htmlspecialchars($end_date) ?>" required>
            </div>
            <div>
                <label for="category">Category:</label>
                <select name="category" id="category">
                    <option value="all" <?= $filter_category == 'all' ? 'selected' : '' ?>>All Categories</option>
                    <option value="device" <?= $filter_category == 'device' ? 'selected' : '' ?>>Devices Only</option>
                    <option value="monitor" <?= $filter_category == 'monitor' ? 'selected' : '' ?>>Monitors Only</option>
                    <option value="printer" <?= $filter_category == 'printer' ? 'selected' : '' ?>>Printers Only</option>
                    <option value="charger" <?= $filter_category == 'charger' ? 'selected' : '' ?>>Chargers Only</option>
                    <option value="ram_ssd" <?= $filter_category == 'ram_ssd' ? 'selected' : '' ?>>RAMs/SSDs Only</option>
                </select>
            </div>
        </div>
        
        <div class="filter-row">
            <div>
                <label for="branch">Branch Filter:</label>
                <select name="branch" id="branch">
                    <option value="all" <?= $filter_branch == 'all' ? 'selected' : '' ?>>All Branches</option>
                    <?php foreach($availableBranches as $branch): ?>
                        <option value="<?= htmlspecialchars($branch) ?>" <?= $filter_branch == $branch ? 'selected' : '' ?>>
                            <?= htmlspecialchars($branch) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <label for="search">Search (Serial/Details/Name):</label>
                <input type="text" name="search" id="search" placeholder="Search by serial number, details, or user name..." value="<?= htmlspecialchars($search_query) ?>">
            </div>
            <div style="display:flex; align-items:flex-end; gap:10px;">
                <button type="submit" style="margin-bottom:15px; flex:2;">Apply Filters</button>
                <button type="button" id="autoSubmitBtn" class="auto-submit-btn" style="margin-bottom:15px; flex:1;">Auto Filter</button>
            </div>
        </div>
    </form>
</div>

<div class="stats-container">
    <div class="stat-card">
        <h4>Total Transfers</h4>
        <div class="stat-number"><?= $stats['total_transfers'] ?? 0 ?></div>
    </div>
    <div class="stat-card">
        <h4>Device Transfers</h4>
        <div class="stat-number"><?= $stats['device_transfers'] ?? 0 ?></div>
    </div>
    <div class="stat-card">
        <h4>Monitor Transfers</h4>
        <div class="stat-number"><?= $stats['monitor_transfers'] ?? 0 ?></div>
    </div>
    <div class="stat-card">
        <h4>Printer Transfers</h4>
        <div class="stat-number"><?= $stats['printer_transfers'] ?? 0 ?></div>
    </div>
    <div class="stat-card">
        <h4>Charger Transfers</h4>
        <div class="stat-number"><?= $stats['charger_transfers'] ?? 0 ?></div>
    </div>
    <div class="stat-card">
        <h4>RAM/SSD Transfers</h4>
        <div class="stat-number"><?= $stats['ram_ssd_transfers'] ?? 0 ?></div>
    </div>
</div>

<div class="action-buttons">
    <div>
        <span style="color:#666; font-size:0.9em;">
            Showing transfers from <?= date('M d, Y', strtotime($start_date)) ?> to <?= date('M d, Y', strtotime($end_date)) ?>
            <?php if($filter_category !== 'all'): ?>
                <?php 
                $category_display = ($filter_category === 'ram_ssd') ? 'RAM/SSD' : ucfirst($filter_category);
                ?>
                | Filtered by: <?= $category_display ?>
            <?php endif; ?>
            <?php if($filter_branch !== 'all'): ?>
                | Branch: <?= htmlspecialchars($filter_branch) ?>
            <?php endif; ?>
        </span>
    </div>
    <a href="?<?= http_build_query(array_merge($_GET, ['export' => 'excel'])) ?>" class="export-btn" style="background:#28a745;color:white;padding:10px 20px;border-radius:5px;text-decoration:none;display:inline-block;font-weight:bold;border:none;cursor:pointer;">
        Export to Excel
    </a>
</div>

<?php if(empty($transferLogs)): ?>
    <div class="empty-state">
        <p>No transfer logs found for the selected period and filters.</p>
        <p>Try adjusting your date range or filters.</p>
    </div>
<?php else: ?>
    <table id="transferLogsTable">
        <thead>
            <tr>
                <th>Date & Time</th>
                <th>Category</th>
                <th>Action</th>
                <th>Details</th>
                <th>User</th>
                <th>User Branch</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($transferLogs as $log): ?>
            <tr>
                <td class="log-time">
                    <?= date('M d, Y', strtotime($log['created_at'])) ?><br>
                    <small><?= date('h:i A', strtotime($log['created_at'])) ?></small>
                </td>
                <td>
                    <?php 
                    // Determine badge class and text in PHP - UPDATED: Changed 'Component' to 'RAM/SSD'
                    $badgeClass = '';
                    $categoryText = '';
                    
                    if(strpos($log['action'], 'device') !== false || stripos($log['details'], 'device') !== false) {
                        $badgeClass = 'badge-device';
                        $categoryText = 'Device';
                    } elseif(strpos($log['action'], 'monitor') !== false || stripos($log['details'], 'monitor') !== false) {
                        $badgeClass = 'badge-monitor';
                        $categoryText = 'Monitor';
                    } elseif(strpos($log['action'], 'printer') !== false || stripos($log['details'], 'printer') !== false) {
                        $badgeClass = 'badge-printer';
                        $categoryText = 'Printer';
                    } elseif(strpos($log['action'], 'charger') !== false || stripos($log['details'], 'charger') !== false) {
                        $badgeClass = 'badge-charger';
                        $categoryText = 'Charger';
                    } elseif(strpos($log['action'], 'ram') !== false || strpos($log['action'], 'ssd') !== false || 
                            strpos($log['action'], 'component') !== false || 
                            stripos($log['details'], 'ram') !== false || stripos($log['details'], 'ssd') !== false ||
                            stripos($log['details'], 'component') !== false) {
                        $badgeClass = 'badge-ram-ssd';
                        $categoryText = 'RAM/SSD';
                    } else {
                        $badgeClass = 'badge-bulk';
                        $categoryText = 'Bulk';
                    }
                    ?>
                    <span class="badge <?= $badgeClass ?>"><?= $categoryText ?></span>
                </td>
                <td><?= htmlspecialchars($log['action']) ?></td>
                <td class="log-details">
                    <?php 
                    // Parse and format the details for better readability
                    $details = htmlspecialchars($log['details']);
                    // Add line breaks for better readability
                    $details = str_replace(['from ', 'to ', '(Delivered by:'], ["\n• From ", "\n• To ", "\n• Delivered by: "], $details);
                    echo nl2br($details);
                    ?>
                </td>
                <td><?= htmlspecialchars($log['full_name'] ?? 'Unknown') ?></td>
                <td><?= htmlspecialchars($log['user_branch'] ?? 'N/A') ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    
    <div style="margin-top:20px; text-align:center; color:#666;">
        Showing <?= count($transferLogs) ?> transfer log(s)
    </div>
<?php endif; ?>

</div>

<script>
// Auto-filter functionality
let autoFilterTimeout;
let autoFilterEnabled = false;

function enableAutoFilter() {
    autoFilterEnabled = true;
    document.getElementById('autoSubmitBtn').textContent = 'Auto Filter: ON';
    document.getElementById('autoSubmitBtn').style.background = '#28a745';
    document.getElementById('autoSubmitBtn').style.color = 'white';
    
    // Add change listeners to form elements
    const formElements = document.querySelectorAll('#filterForm select, #filterForm input');
    formElements.forEach(element => {
        element.addEventListener('change', handleAutoFilter);
        if(element.type === 'text') {
            element.addEventListener('input', handleAutoFilter);
        }
    });
}

function disableAutoFilter() {
    autoFilterEnabled = false;
    document.getElementById('autoSubmitBtn').textContent = 'Auto Filter';
    document.getElementById('autoSubmitBtn').style.background = '';
    document.getElementById('autoSubmitBtn').style.color = '';
    
    // Remove change listeners
    const formElements = document.querySelectorAll('#filterForm select, #filterForm input');
    formElements.forEach(element => {
        element.removeEventListener('change', handleAutoFilter);
        if(element.type === 'text') {
            element.removeEventListener('input', handleAutoFilter);
        }
    });
}

function handleAutoFilter() {
    if (!autoFilterEnabled) return;
    
    // Clear previous timeout
    clearTimeout(autoFilterTimeout);
    
    // Set new timeout (500ms delay to avoid too many requests)
    autoFilterTimeout = setTimeout(() => {
        // Show loading indicator
        const button = document.getElementById('autoSubmitBtn');
        const originalText = button.textContent;
        button.textContent = 'Filtering...';
        button.disabled = true;
        
        // Submit form
        document.getElementById('filterForm').submit();
    }, 500);
}

// Toggle auto-filter
document.getElementById('autoSubmitBtn').addEventListener('click', function() {
    if (autoFilterEnabled) {
        disableAutoFilter();
    } else {
        enableAutoFilter();
    }
});

// Set max date for end_date to today
document.getElementById('end_date').max = new Date().toISOString().split('T')[0];
document.getElementById('start_date').max = new Date().toISOString().split('T')[0];

// Validate date range on manual submit
document.getElementById('filterForm').addEventListener('submit', function(e) {
    const startDate = new Date(document.getElementById('start_date').value);
    const endDate = new Date(document.getElementById('end_date').value);
    
    if(startDate > endDate) {
        alert('Start date cannot be after end date!');
        e.preventDefault();
    }
    
    // Limit to maximum 365 days
    const diffTime = Math.abs(endDate - startDate);
    const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
    
    if(diffDays > 365) {
        alert('Date range cannot exceed 365 days!');
        e.preventDefault();
    }
});

// Initialize with auto-filter off
disableAutoFilter();
</script>

</body>
</html>