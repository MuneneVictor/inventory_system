<?php
session_start();
require_once "../config/db.php";
require_once "../includes/auth_check.php";

$period = $_GET['period'] ?? '';
$start_date = $_GET['start_date'] ?? '';
$end_date = $_GET['end_date'] ?? '';

$sql = "SELECT a.*, u.full_name 
        FROM activity_logs a
        LEFT JOIN users u ON a.user_id = u.id
        WHERE 1";

$params = [];

// PERIOD FILTER LOGIC
switch ($period) {
    case "today":
        $sql .= " AND DATE(a.created_at) = CURDATE()";
        break;

    case "this_week":
        $sql .= " AND YEARWEEK(a.created_at, 1) = YEARWEEK(CURDATE(), 1)";
        break;

    case "this_month":
        $sql .= " AND YEAR(a.created_at) = YEAR(CURDATE())
                  AND MONTH(a.created_at) = MONTH(CURDATE())";
        break;

    case "last_month":
        $sql .= " AND YEAR(a.created_at) = YEAR(CURDATE() - INTERVAL 1 MONTH)
                  AND MONTH(a.created_at) = MONTH(CURDATE() - INTERVAL 1 MONTH)";
        break;

    case "this_year":
        $sql .= " AND YEAR(a.created_at) = YEAR(CURDATE())";
        break;

    case "custom":
        if (!empty($start_date) && !empty($end_date)) {
            $sql .= " AND DATE(a.created_at) BETWEEN :start AND :end";
            $params['start'] = $start_date;
            $params['end'] = $end_date;
        }
        break;

    default:
        // All time — no date filter
        break;
}

$sql .= " ORDER BY a.created_at DESC";

$stmt = $conn->prepare($sql);
$stmt->execute($params);
$logs = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Activity Logs</title>
<style>
body { font-family: Arial, sans-serif; background:#f4f7f6; margin:0; padding:0; }
.container { max-width: 1200px; margin:30px auto; background:#fff; padding:25px; border-radius:8px; box-shadow:0 4px 15px rgba(0,0,0,0.1); }
h2 { text-align:center; color:#2f7a3f; margin-bottom:20px; }
table { width:100%; border-collapse: collapse; margin-top:20px; }
th, td { border:1px solid #ccc; padding:10px; text-align:left; font-size:1em; }
th { background:#2f7a3f; color:#fff; }
button { padding:8px 15px; border:none; background:#2f7a3f; color:#fff; border-radius:5px; cursor:pointer; }
button:hover { background:#1f5a2d; }
select, input[type=date] {
    padding:8px; border:1px solid #ccc; border-radius:5px; margin-right:5px;
}
a { color:#007bff; text-decoration:none; }
a:hover { text-decoration:underline; }
.filter-box { margin-bottom:20px; display:flex; gap:10px; align-items:center; flex-wrap:wrap; }
</style>
</head>
<body>

<div class="container">

<h2>Activity Logs</h2>

<a href="/inventory_system/dashboard/index.php"
   style="padding:10px 15px;background:#007bff;color:white;border-radius:6px;text-decoration:none;font-weight:bold;">
    Dashboard
</a>
<br><br>

<form method="GET" class="filter-box" id="filterForm">

    <select name="period" id="periodSelect" onchange="toggleCustomRange(this.value); autoApplyFilter();">
        <option value="">All Time</option>
        <option value="today" <?= $period=="today"?"selected":"" ?>>Today</option>
        <option value="this_week" <?= $period=="this_week"?"selected":"" ?>>This Week</option>
        <option value="this_month" <?= $period=="this_month"?"selected":"" ?>>This Month</option>
        <option value="last_month" <?= $period=="last_month"?"selected":"" ?>>Last Month</option>
        <option value="this_year" <?= $period=="this_year"?"selected":"" ?>>This Year</option>
        <option value="custom" <?= $period=="custom"?"selected":"" ?>>Custom Range</option>
    </select>

    <!-- Custom date range fields -->
    <div id="customRange" style="display:<?= $period=='custom'?'flex':'none' ?>; gap:5px; align-items:center;">
        <input type="date" name="start_date" id="startDate" value="<?= htmlspecialchars($start_date) ?>" onchange="autoApplyFilter()">
        <span>to</span>
        <input type="date" name="end_date" id="endDate" value="<?= htmlspecialchars($end_date) ?>" onchange="autoApplyFilter()">
    </div>

    <button type="button" onclick="clearFilters()" style="background:#dc3545;">Clear Filters</button>
</form>

<script>
function toggleCustomRange(val){
    const customRange = document.getElementById('customRange');
    if (val === 'custom') {
        customRange.style.display = 'flex';
    } else {
        customRange.style.display = 'none';
        // Auto-apply filter when switching away from custom
        setTimeout(() => {
            document.getElementById('filterForm').submit();
        }, 100);
    }
}

function autoApplyFilter() {
    document.getElementById('filterForm').submit();
}

function clearFilters() {
    // Reset dropdowns to default
    document.getElementById('periodSelect').value = '';
    document.getElementById('startDate').value = '';
    document.getElementById('endDate').value = '';
    
    // Hide custom date range
    document.getElementById('customRange').style.display = 'none';
    
    // Submit the form
    document.getElementById('filterForm').submit();
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    // Make sure custom date range is shown if custom is selected
    const periodSelect = document.getElementById('periodSelect');
    if (periodSelect.value === 'custom') {
        document.getElementById('customRange').style.display = 'flex';
    }
});
</script>

<table>
    <tr>
        <th>#</th>
        <th>Action</th>
        <th>Details</th>
        <th>Done By</th>
        <th>Date</th>
    </tr>

    <?php if($logs): ?>
        <?php $i=1; foreach($logs as $log): ?>
        <tr>
            <td><?= $i++ ?></td>
            <td><?= htmlspecialchars($log['action']) ?></td>
            <td><?= nl2br(htmlspecialchars($log['details'] ?? '—')) ?></td>
            <td><?= htmlspecialchars($log['full_name'] ?? 'Unknown User') ?></td>
            <td><?= htmlspecialchars($log['created_at']) ?></td>
        </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr><td colspan="5" style="text-align:center;">No logs found.</td></tr>
    <?php endif; ?>

</table>

</div>

</body>
</html>