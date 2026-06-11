<?php
session_start();
require_once "../config/db.php";
require_once "../includes/auth_check.php";
require_once "../includes/header.php";
require_once "../includes/sidebar.php";

if (!in_array($_SESSION['role'], ['super_admin', 'inventory_admin', 'manager', 'maintenance'])) {
    die("ACCESS DENIED.");
}

$user_id = (int) $_SESSION['user_id'];
$user_role = $_SESSION['role'];

$user_branch = null;
if ($user_role !== 'super_admin') {
    $stmt = $conn->prepare("SELECT branch FROM users WHERE id = ?");
    $stmt->execute([$user_id]);
    $user_branch = $stmt->fetchColumn();
}

$filter_serial = trim($_GET['serial'] ?? '');
$filter_branch = trim($_GET['branch'] ?? '');
$filter_start_date = trim($_GET['start_date'] ?? '');
$filter_end_date = trim($_GET['end_date'] ?? '');

$sql = "SELECT cl.*, 
               c.charger_type, c.watts, c.charger_condition,
               u.full_name AS given_to_name, u.branch AS given_to_branch,
               ub.full_name AS given_by_name, ub.branch AS given_by_branch
        FROM charger_logs cl
        JOIN chargers c ON cl.charger_id = c.id
        JOIN users u ON cl.given_to = u.id
        JOIN users ub ON cl.given_by = ub.id
        WHERE 1";

$params = [];

if ($user_role === 'maintenance') {
    $sql .= " AND cl.given_by = ?";
    $params[] = $user_id;
}

if (in_array($user_role, ['manager', 'inventory_admin']) && !empty($user_branch)) {
    $sql .= " AND cl.branch = ?";
    $params[] = $user_branch;
}

if (!empty($filter_serial)) {
    // Search by charger type or given_to name
    $sql .= " AND (c.charger_type LIKE ? OR u.full_name LIKE ?)";
    $params[] = "%$filter_serial%";
    $params[] = "%$filter_serial%";
}

if ($user_role === 'super_admin' && !empty($filter_branch)) {
    $sql .= " AND cl.branch = ?";
    $params[] = $filter_branch;
}

if (!empty($filter_start_date) && !empty($filter_end_date)) {
    $sql .= " AND DATE(cl.date_given) BETWEEN ? AND ?";
    $params[] = $filter_start_date;
    $params[] = $filter_end_date;
} elseif (!empty($filter_start_date)) {
    $sql .= " AND DATE(cl.date_given) >= ?";
    $params[] = $filter_start_date;
} elseif (!empty($filter_end_date)) {
    $sql .= " AND DATE(cl.date_given) <= ?";
    $params[] = $filter_end_date;
}

$sql .= " ORDER BY cl.date_given DESC";

$stmt = $conn->prepare($sql);
$stmt->execute($params);
$logs = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Get branches for super_admin filter
$branches = [];
if ($user_role === 'super_admin') {
    $branchStmt = $conn->query("SELECT DISTINCT branch FROM charger_logs WHERE branch IS NOT NULL ORDER BY branch");
    $branches = $branchStmt->fetchAll(PDO::FETCH_COLUMN);
}

date_default_timezone_set('Africa/Nairobi');
$hour = date('G');
if ($hour < 12) $greeting = 'Good morning';
elseif ($hour < 17) $greeting = 'Good afternoon';
else $greeting = 'Good evening';
$user_name = $_SESSION['name'] ?? ($_SESSION['full_name'] ?? 'User');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Charger Logs | Mombasa Computers</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Same base styles as chargers_instocks.php */
        :root {
            --primary: #1a4b2a;
            --gray-50: #f9fafb;
            --gray-100: #f3f4f6;
            --gray-200: #e5e7eb;
            --gray-300: #d1d5db;
            --gray-500: #6b7280;
            --gray-600: #4b5563;
            --gray-800: #1f2937;
            --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
            --radius-md: 0.5rem;
            --radius-xl: 1rem;
            --font-sans: 'Inter', system-ui, sans-serif;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: var(--font-sans); background: var(--gray-100); color: var(--gray-800); line-height: 1.5; overflow-x: hidden; }
        .main-content { padding: 2rem 2rem 1rem; margin-left: 260px; width: calc(100% - 260px); min-height: 100vh; background: var(--gray-100); transition: all 0.3s ease; }
        .page-header { background: white; padding: 1.5rem 2rem; border-radius: var(--radius-xl); margin-bottom: 1.5rem; box-shadow: var(--shadow-sm); border: 1px solid var(--gray-200); }
        .page-header h1 { font-size: 1.75rem; color: var(--gray-800); font-weight: 600; margin-bottom: 0.5rem; display: flex; align-items: center; gap: 0.75rem; }
        .page-header h1 i { color: var(--primary); font-size: 1.75rem; }
        .breadcrumb { color: var(--gray-500); font-size: 0.9rem; }
        .stats-row { display: flex; gap: 1rem; margin-bottom: 1.5rem; flex-wrap: wrap; }
        .stat-card { background: white; padding: 1rem 1.5rem; border-radius: var(--radius-xl); border: 1px solid var(--gray-200); box-shadow: var(--shadow-sm); flex: 1; min-width: 150px; }
        .stat-card .stat-value { font-size: 1.75rem; font-weight: 700; color: var(--primary); }
        .stat-card .stat-label { font-size: 0.8rem; color: var(--gray-500); }
        .filter-section { background: white; padding: 1.5rem; border-radius: var(--radius-xl); margin-bottom: 1.5rem; box-shadow: var(--shadow-sm); border: 1px solid var(--gray-200); }
        .filter-title { font-size: 1rem; font-weight: 500; margin-bottom: 1rem; display: flex; align-items: center; gap: 0.5rem; }
        .filter-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; align-items: flex-end; }
        .filter-group { display: flex; flex-direction: column; gap: 0.5rem; }
        .filter-group label { font-size: 0.85rem; font-weight: 500; color: var(--gray-600); }
        .filter-group input, .filter-group select { padding: 0.625rem 0.875rem; border: 1px solid var(--gray-300); border-radius: var(--radius-md); font-size: 0.9rem; background: white; }
        .btn { padding: 0.625rem 1.25rem; background: var(--primary); color: white; border: none; border-radius: var(--radius-md); cursor: pointer; display: inline-flex; align-items: center; gap: 0.5rem; text-decoration: none; }
        .btn-secondary { background: var(--gray-500); }
        .table-wrapper { background: white; border-radius: var(--radius-xl); border: 1px solid var(--gray-200); overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; min-width: 900px; }
        th { background: var(--gray-50); padding: 1rem; text-align: left; font-weight: 600; color: var(--gray-600); border-bottom: 1px solid var(--gray-200); }
        td { padding: 0.9rem 1rem; border-bottom: 1px solid var(--gray-100); vertical-align: middle; }
        .badge { display: inline-block; padding: 0.25rem 0.625rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 500; background: var(--gray-100); }
        .empty-state { text-align: center; padding: 3rem; color: var(--gray-500); }
        .footer { text-align: center; padding: 1.5rem 0 0.5rem; margin-top: 1.5rem; font-size: 0.85rem; color: var(--gray-400); border-top: 1px solid var(--gray-200); }
        @media (max-width: 1200px) { .main-content { margin-left: 0 !important; width: 100% !important; padding: 1.5rem 1rem 1rem !important; padding-top: 5rem !important; } }
        @media (max-width: 768px) { .filter-grid { grid-template-columns: 1fr; } .btn { width: 100%; justify-content: center; } .stats-row { flex-direction: column; } }
    </style>
</head>
<body>
<div class="main-content">
    <div class="page-header">
        <h1><i class="fas fa-history"></i> Charger Transaction Logs</h1>
        <div class="breadcrumb">
            <?php if ($user_role === 'super_admin'): ?>
                <a href="/inventory_system/dashboard/superadmindashboard.php">Dashboard</a>
            <?php elseif ($user_role === 'manager'): ?>
                <a href="/inventory_system/dashboard/managerdashboard.php">Dashboard</a>
            <?php elseif ($user_role === 'inventory_admin'): ?>
                <a href="/inventory_system/dashboard/inventorydashboard.php">Dashboard</a>
            <?php else: ?>
                <a href="/inventory_system/dashboard/index.php">Dashboard</a>
            <?php endif; ?>
            <span> / </span>
            <span>Charger Logs</span>
        </div>
    </div>

    <div class="stats-row">
        <div class="stat-card"><div class="stat-value"><?= count($logs) ?></div><div class="stat-label">Total Transactions</div></div>
        <div class="stat-card"><div class="stat-value"><?= array_sum(array_column($logs, 'quantity')) ?></div><div class="stat-label">Total Units Given</div></div>
    </div>

    <div class="filter-section">
        <div class="filter-title"><i class="fas fa-filter"></i> Filter Logs</div>
        <form method="GET" class="filter-grid">
            <div class="filter-group">
                <label>Search (Type / Recipient)</label>
                <input type="text" name="serial" placeholder="Charger type or recipient name" value="<?= htmlspecialchars($filter_serial) ?>">
            </div>
            <div class="filter-group">
                <label>Start Date</label>
                <input type="date" name="start_date" value="<?= htmlspecialchars($filter_start_date) ?>">
            </div>
            <div class="filter-group">
                <label>End Date</label>
                <input type="date" name="end_date" value="<?= htmlspecialchars($filter_end_date) ?>">
            </div>
            <?php if ($user_role === 'super_admin'): ?>
                <div class="filter-group">
                    <label>Branch</label>
                    <select name="branch">
                        <option value="">All Branches</option>
                        <?php foreach ($branches as $b): ?>
                            <option value="<?= htmlspecialchars($b) ?>" <?= $filter_branch == $b ? 'selected' : '' ?>><?= htmlspecialchars($b) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            <?php endif; ?>
            <div class="filter-group">
                <button type="submit" class="btn"><i class="fas fa-search"></i> Filter</button>
                <a href="charger_logs.php" class="btn btn-secondary" style="margin-left:0.5rem;">Reset</a>
            </div>
        </form>
    </div>

    <div class="table-wrapper">
        <?php if (empty($logs)): ?>
            <div class="empty-state"><i class="fas fa-clipboard-list"></i><p>No charger transaction logs found.</p></div>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Type</th>
                        <th>Watts</th>
                        <th>Condition</th>
                        <th>Quantity</th>
                        <th>Given To</th>
                        <th>Given By</th>
                        <th>Branch</th>
                        <th>Date Given</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i=1; foreach ($logs as $log): ?>
                    <tr>
                        <td><?= $i++ ?></td>
                        <td><?= htmlspecialchars($log['charger_type']) ?></td>
                        <td><?= $log['watts'] ?> W</td>
                        <td><span class="badge"><?= htmlspecialchars($log['charger_condition']) ?></span></td>
                        <td><strong><?= $log['quantity'] ?></strong></td>
                        <td><?= htmlspecialchars($log['given_to_name']) ?> (<?= htmlspecialchars($log['given_to_branch']) ?>)</td>
                        <td><?= htmlspecialchars($log['given_by_name']) ?> (<?= htmlspecialchars($log['given_by_branch']) ?>)</td>
                        <td><span class="badge"><?= htmlspecialchars($log['branch']) ?></span></td>
                        <td><?= date('M j, Y H:i', strtotime($log['date_given'])) ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
    <div class="footer"><i class="fas fa-copyright"></i> <?= date('Y'); ?> Mombasa Computers</div>
</div>

<script>
function adjustMainContent() {
    const main = document.querySelector('.main-content');
    if (window.innerWidth <= 1200) main.style.marginLeft = '0';
    else main.style.marginLeft = '260px';
}
window.addEventListener('resize', adjustMainContent);
adjustMainContent();
</script>
<?php require_once "../includes/footer.php"; ?>
</body>
</html>