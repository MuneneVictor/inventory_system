<?php
session_start();
require_once "../config/db.php";
require_once "../includes/auth_check.php";

// Only super_admin can view activity logs
if ($_SESSION['role'] !== 'super_admin') {
    die("ACCESS DENIED. Only Super Administrators can view activity logs.");
}

// --- Get filter values ---
$start_date = $_GET['start_date'] ?? '';
$end_date = $_GET['end_date'] ?? '';
$search = trim($_GET['search'] ?? '');
$user_filter = $_GET['user_filter'] ?? '';

$allowed_per_page = [100, 200, 300, 400, 500];
$per_page = isset($_GET['per_page']) ? (int)$_GET['per_page'] : 100;
if (!in_array($per_page, $allowed_per_page, true)) {
    $per_page = 100;
}
$page = max(1, (int)($_GET['page'] ?? 1));

// --- Build WHERE clause once for count + paginated list ---
$where = ["1"];
$params = [];

// Use range comparisons on created_at so the date index can be used.
if (!empty($start_date)) {
    $where[] = "a.created_at >= :start";
    $params['start'] = $start_date . ' 00:00:00';
}
if (!empty($end_date)) {
    $where[] = "a.created_at <= :end";
    $params['end'] = $end_date . ' 23:59:59';
}

// Search by details. Keep existing search behavior.
if (!empty($search)) {
    $where[] = "a.details LIKE :search";
    $params['search'] = "%$search%";
}

// User filter
if (!empty($user_filter)) {
    $where[] = "a.user_id = :user_id";
    $params['user_id'] = (int)$user_filter;
}

$whereSql = implode(" AND ", $where);

// Lightweight count query for pagination and the Total Logs card.
$countSql = "SELECT COUNT(*)
             FROM activity_logs a
             WHERE {$whereSql}";
$countStmt = $conn->prepare($countSql);
$countStmt->execute($params);
$total_logs = (int)$countStmt->fetchColumn();

$total_pages = max(1, (int)ceil($total_logs / $per_page));
if ($page > $total_pages) {
    $page = $total_pages;
}
$offset = ($page - 1) * $per_page;

// Load only the rows needed for the current page.
$sql = "SELECT a.*, u.full_name
        FROM activity_logs a
        LEFT JOIN users u ON a.user_id = u.id
        WHERE {$whereSql}
        ORDER BY a.created_at DESC, a.id DESC
        LIMIT :limit OFFSET :offset";

$stmt = $conn->prepare($sql);
foreach ($params as $key => $value) {
    $stmt->bindValue(':' . $key, $value);
}
$stmt->bindValue(':limit', $per_page, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$logs = $stmt->fetchAll(PDO::FETCH_ASSOC);

// --- Get list of users for filter dropdown ---
$user_stmt = $conn->query("SELECT id, full_name FROM users ORDER BY full_name");
$users = $user_stmt->fetchAll(PDO::FETCH_ASSOC);

function activityPageUrl($pageNumber) {
    $query = $_GET;
    $query['page'] = $pageNumber;
    return '?' . http_build_query($query);
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
    <title>Activity Logs | Mombasa Computers</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
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
            --radius-lg: 0.75rem;
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
        .breadcrumb a { color: var(--primary); text-decoration: none; }
        .stats-row { display: flex; gap: 1rem; margin-bottom: 1.5rem; flex-wrap: wrap; }
        .stat-card { background: white; padding: 1rem 1.5rem; border-radius: var(--radius-lg); border: 1px solid var(--gray-200); box-shadow: var(--shadow-sm); flex: 1; min-width: 150px; }
        .stat-card .stat-value { font-size: 1.75rem; font-weight: 700; color: var(--primary); }
        .stat-card .stat-label { font-size: 0.8rem; color: var(--gray-500); }
        .filter-section { background: white; padding: 1.5rem; border-radius: var(--radius-xl); margin-bottom: 1.5rem; box-shadow: var(--shadow-sm); border: 1px solid var(--gray-200); }
        .filter-title { font-size: 1rem; font-weight: 500; margin-bottom: 1rem; display: flex; align-items: center; gap: 0.5rem; }
        .filter-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; align-items: flex-end; }
        .filter-group { display: flex; flex-direction: column; gap: 0.5rem; }
        .filter-group label { font-size: 0.85rem; font-weight: 500; color: var(--gray-600); }
        .filter-group input, .filter-group select { padding: 0.625rem 0.875rem; border: 1px solid var(--gray-300); border-radius: var(--radius-md); font-size: 0.9rem; background: white; }
        .filter-actions { display: flex; gap: 0.75rem; align-items: flex-end; flex-wrap: wrap; }
        .btn { padding: 0.625rem 1.25rem; background: var(--primary); color: white; border: none; border-radius: var(--radius-md); cursor: pointer; display: inline-flex; align-items: center; gap: 0.5rem; text-decoration: none; }
        .btn-secondary { background: var(--gray-500); }
        .table-wrapper { background: white; border-radius: var(--radius-xl); border: 1px solid var(--gray-200); overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; min-width: 700px; }
        th { background: var(--gray-50); padding: 1rem; text-align: left; font-weight: 600; color: var(--gray-600); border-bottom: 1px solid var(--gray-200); }
        td { padding: 0.9rem 1rem; border-bottom: 1px solid var(--gray-100); vertical-align: middle; }
        .badge { display: inline-block; padding: 0.25rem 0.625rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 500; background: var(--gray-100); }
        .empty-state { text-align: center; padding: 3rem; color: var(--gray-500); }
        .footer { text-align: center; padding: 1.5rem 0 0.5rem; margin-top: 1.5rem; font-size: 0.85rem; color: var(--gray-400); border-top: 1px solid var(--gray-200); }
        .activity-details a {
                    color: #1a4b2a;
                    text-decoration: underline;
                    font-weight: 500;
                }
        .pagination-bar { display:flex; justify-content:space-between; align-items:center; gap:1rem; flex-wrap:wrap; padding:1rem 0; }
        .pagination-controls { display:flex; align-items:center; gap:.4rem; flex-wrap:wrap; }
        .pagination-controls a, .pagination-controls span { padding:.45rem .7rem; border:1px solid var(--gray-300); border-radius:var(--radius-md); text-decoration:none; color:var(--gray-600); background:white; font-size:.85rem; }
        .pagination-controls .active { background:var(--primary); color:white; border-color:var(--primary); }
        .pagination-controls .disabled { opacity:.45; pointer-events:none; }
        .per-page-form { display:flex; align-items:center; gap:.5rem; font-size:.85rem; color:var(--gray-600); }
        .per-page-form select { padding:.45rem .65rem; border:1px solid var(--gray-300); border-radius:var(--radius-md); background:white; }
        @media (max-width: 1200px) {
            .main-content { margin-left: 0 !important; width: 100% !important; padding: 1.5rem 1rem 1rem !important; padding-top: 5rem !important; }
        }
        @media (max-width: 768px) {
            .main-content { padding: 1rem 0.75rem 0.75rem !important; padding-top: 4.5rem !important; }
            .page-header h1 { font-size: 1.25rem; }
            .filter-grid { grid-template-columns: 1fr !important; align-items: stretch !important; }
            .filter-group { align-items: flex-start !important; text-align: left !important; }
            .filter-group input, .filter-group select { width: 100% !important; text-align: left !important; }
            .filter-actions { flex-direction: column !important; align-items: stretch !important; gap: 0.75rem !important; }
            .filter-actions .btn { width: 100% !important; justify-content: center !important; margin-left: 0 !important; }
            .stats-row { flex-direction: column; gap: 0.75rem; }
            .stat-card { padding: 1rem; }
            .stat-card .stat-value { font-size: 1.5rem; }
        }
    </style>
</head>
<body>
<?php include "../includes/sidebar.php"; ?>
<div class="main-content">
    <div class="page-header">
        <h1><i class="fas fa-history"></i> Activity Logs</h1>
        <div class="breadcrumb">
            <a href="../dashboard/superadmindashboard.php">Dashboard</a>
            <span> / </span>
            <span>Activity Logs</span>
        </div>
    </div>

    <div class="stats-row">
        <div class="stat-card"><div class="stat-value"><?= number_format($total_logs) ?></div><div class="stat-label">Total Logs</div></div>
    </div>

    <div class="filter-section">
        <div class="filter-title"><i class="fas fa-filter"></i> Filter Logs</div>
        <form method="GET" class="filter-grid">
            <input type="hidden" name="per_page" value="<?= (int)$per_page ?>">
            <div class="filter-group">
                <label>Search in Details</label>
                <input type="text" name="search" placeholder="Search by action or details..." value="<?= htmlspecialchars($search) ?>">
            </div>
            <div class="filter-group">
                <label>User</label>
                <select name="user_filter">
                    <option value="">All Users</option>
                    <?php foreach ($users as $u): ?>
                        <option value="<?= $u['id'] ?>" <?= $user_filter == $u['id'] ? 'selected' : '' ?>><?= htmlspecialchars($u['full_name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="filter-group">
                <label>Start Date</label>
                <input type="date" name="start_date" value="<?= htmlspecialchars($start_date) ?>">
            </div>
            <div class="filter-group">
                <label>End Date</label>
                <input type="date" name="end_date" value="<?= htmlspecialchars($end_date) ?>">
            </div>
            <div class="filter-actions">
                <button type="submit" class="btn"><i class="fas fa-search"></i> Filter</button>
                <a href="activity.php" class="btn btn-secondary">Reset</a>
            </div>
        </form>
    </div>

    <div class="table-wrapper">
        <?php if (empty($logs)): ?>
            <div class="empty-state"><i class="fas fa-clipboard-list"></i><p>No activity logs found.</p></div>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Action</th>
                        <th>Details</th>
                        <th>Done By</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i=$offset + 1; foreach ($logs as $log): ?>
                    <tr>
                        <td><?= $i++ ?></td>
                        <td><span class="badge"><?= htmlspecialchars($log['action']) ?></span></td>
                        <td><?= nl2br(strip_tags($log['details'], '<a>')) ?></td>
                        <td><?= htmlspecialchars($log['full_name'] ?? 'Unknown User') ?></td>
                        <td><?= date('M j, Y H:i:s', strtotime($log['created_at'])) ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>

    <?php if ($total_logs > 0): ?>
    <div class="pagination-bar">
        <form method="GET" class="per-page-form">
            <?php foreach ($_GET as $key => $value): ?>
                <?php if ($key !== 'per_page' && $key !== 'page' && !is_array($value)): ?>
                    <input type="hidden" name="<?= htmlspecialchars($key) ?>" value="<?= htmlspecialchars($value) ?>">
                <?php endif; ?>
            <?php endforeach; ?>
            <label for="activityPerPage">Show</label>
            <select id="activityPerPage" name="per_page" onchange="this.form.submit()">
                <?php foreach ($allowed_per_page as $size): ?>
                    <option value="<?= $size ?>" <?= $per_page === $size ? 'selected' : '' ?>><?= $size ?></option>
                <?php endforeach; ?>
            </select>
            <span>per page</span>
        </form>

        <div class="pagination-controls">
            <?php if ($page > 1): ?>
                <a href="<?= htmlspecialchars(activityPageUrl($page - 1)) ?>">Previous</a>
            <?php else: ?>
                <span class="disabled">Previous</span>
            <?php endif; ?>

            <?php
            $startPage = max(1, $page - 2);
            $endPage = min($total_pages, $page + 2);
            for ($p = $startPage; $p <= $endPage; $p++):
            ?>
                <?php if ($p === $page): ?>
                    <span class="active"><?= $p ?></span>
                <?php else: ?>
                    <a href="<?= htmlspecialchars(activityPageUrl($p)) ?>"><?= $p ?></a>
                <?php endif; ?>
            <?php endfor; ?>

            <?php if ($page < $total_pages): ?>
                <a href="<?= htmlspecialchars(activityPageUrl($page + 1)) ?>">Next</a>
            <?php else: ?>
                <span class="disabled">Next</span>
            <?php endif; ?>
        </div>
    </div>
    <?php endif; ?>

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