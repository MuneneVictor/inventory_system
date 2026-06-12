<?php
session_start();
require_once "../config/db.php";
require_once "../includes/auth_check.php";
require_once "../includes/header.php";
require_once "../includes/sidebar.php";

$user_role = $_SESSION['role'];
$user_id = (int) $_SESSION['user_id'];

if (!in_array($user_role, ['sales', 'super_admin', 'inventory_admin', 'manager'])) {
    die("ACCESS DENIED.");
}

$search_sn = trim($_GET['sn'] ?? '');
$search_model = trim($_GET['model'] ?? '');
$searched = ($search_sn || $search_model);

$deviceResults = [];
$monitorResults = [];
$printerResults = [];

if ($searched) {
    // Devices
    $sql = "SELECT d.*, c.category_name, u.full_name AS added_by_name, d.branch
            FROM devices d
            JOIN categories c ON d.category_id = c.id
            LEFT JOIN users u ON d.added_by = u.id
            WHERE d.status = 'In Stock'";
    $params = [];
    if ($search_sn) {
        $sql .= " AND d.serial_number LIKE :sn";
        $params['sn'] = "%$search_sn%";
    }
    if ($search_model) {
        $sql .= " AND d.model_name LIKE :model";
        $params['model'] = "%$search_model%";
    }
    $stmt = $conn->prepare($sql);
    $stmt->execute($params);
    $deviceResults = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Monitors
    $sql = "SELECT m.*, u.full_name AS added_by_name
            FROM monitors m
            LEFT JOIN users u ON m.added_by = u.id
            WHERE m.status = 'In Stock'";
    $params = [];
    if ($search_sn) {
        $sql .= " AND m.serial_number LIKE :sn";
        $params['sn'] = "%$search_sn%";
    }
    if ($search_model) {
        $sql .= " AND m.model_name LIKE :model";
        $params['model'] = "%$search_model%";
    }
    $stmt = $conn->prepare($sql);
    $stmt->execute($params);
    $monitorResults = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Printers
    $sql = "SELECT p.*, u.full_name AS added_by_name
            FROM printers p
            LEFT JOIN users u ON p.added_by = u.id
            WHERE p.status = 'In Stock'";
    $params = [];
    if ($search_sn) {
        $sql .= " AND p.serial_number LIKE :sn";
        $params['sn'] = "%$search_sn%";
    }
    if ($search_model) {
        $sql .= " AND p.model_name LIKE :model";
        $params['model'] = "%$search_model%";
    }
    $stmt = $conn->prepare($sql);
    $stmt->execute($params);
    $printerResults = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
    <title>Search Inventory | Mombasa Computers</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Same base styles */
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
        .search-section { background: white; padding: 1.5rem; border-radius: var(--radius-xl); margin-bottom: 1.5rem; box-shadow: var(--shadow-sm); border: 1px solid var(--gray-200); }
        .search-form { display: flex; gap: 1rem; flex-wrap: wrap; align-items: flex-end; }
        .search-group { flex: 1; min-width: 200px; display: flex; flex-direction: column; gap: 0.5rem; }
        .search-group label { font-size: 0.85rem; font-weight: 500; color: var(--gray-600); }
        .search-group input { padding: 0.75rem 1rem; border: 1px solid var(--gray-300); border-radius: var(--radius-md); font-size: 0.9rem; background: white; }
        .btn { padding: 0.75rem 1.5rem; background: var(--primary); color: white; border: none; border-radius: var(--radius-md); cursor: pointer; display: inline-flex; align-items: center; gap: 0.5rem; }
        .section-title { background: var(--gray-50); padding: 0.75rem 1rem; border-radius: var(--radius-lg); margin-top: 1.5rem; margin-bottom: 1rem; border-left: 4px solid var(--primary); font-weight: 600; }
        .table-wrapper { background: white; border-radius: var(--radius-xl); border: 1px solid var(--gray-200); overflow-x: auto; margin-bottom: 1.5rem; }
        table { width: 100%; border-collapse: collapse; font-size: 0.85rem; min-width: 900px; }
        th { background: var(--gray-50); padding: 0.75rem; text-align: left; font-weight: 600; color: var(--gray-600); border-bottom: 1px solid var(--gray-200); }
        td { padding: 0.75rem; border-bottom: 1px solid var(--gray-100); vertical-align: middle; }
        .badge { display: inline-block; padding: 0.2rem 0.5rem; border-radius: 9999px; font-size: 0.7rem; font-weight: 500; background: var(--gray-100); }
        .view-btn { padding: 0.3rem 0.7rem; background: var(--primary); color: white; border-radius: 4px; text-decoration: none; font-size: 0.75rem; }
        .empty-state { text-align: center; padding: 2rem; color: var(--gray-500); }
        .footer { text-align: center; padding: 1.5rem 0 0.5rem; margin-top: 1.5rem; font-size: 0.85rem; color: var(--gray-400); border-top: 1px solid var(--gray-200); }
        @media (max-width: 1200px) { .main-content { margin-left: 0 !important; width: 100% !important; padding: 1.5rem 1rem 1rem !important; padding-top: 5rem !important; } }
        @media (max-width: 768px) { .search-form { flex-direction: column; } .btn { width: 100%; justify-content: center; } }
    </style>
</head>
<body>
<div class="main-content">
    <div class="page-header">
        <h1><i class="fas fa-search"></i> Search Inventory (In Stock)</h1>
        <div class="breadcrumb">
            <?php if ($user_role === 'sales'): ?>
                <a href="/inventory_system/dashboard/salesdashboard.php">Dashboard</a>
            <?php elseif ($user_role === 'super_admin'): ?>
                <a href="/inventory_system/dashboard/superadmindashboard.php">Dashboard</a>
            <?php else: ?>
                <a href="/inventory_system/dashboard/inventorydashboard.php">Dashboard</a>
            <?php endif; ?>
            <span> / </span>
            <span>Search Inventory</span>
        </div>
    </div>

    <div class="search-section">
        <form method="GET" class="search-form">
            <div class="search-group">
                <label><i class="fas fa-tag"></i> Model</label>
                <input type="text" name="model" placeholder="Search by model..." value="<?= htmlspecialchars($search_model) ?>">
            </div>
            <div class="search-group">
                <label><i class="fas fa-qrcode"></i> Serial Number</label>
                <input type="text" name="sn" placeholder="Scan or type serial..." value="<?= htmlspecialchars($search_sn) ?>" autofocus>
            </div>
            <div class="search-group">
                <button type="submit" class="btn"><i class="fas fa-search"></i> Search</button>
            </div>
        </form>
    </div>

    <?php if ($searched): ?>
        <?php
        $total = count($deviceResults) + count($monitorResults) + count($printerResults);
        echo '<div style="margin-bottom:1rem;"><strong>Found ' . $total . ' item(s)</strong>';
        if ($search_sn) echo ' • Serial: "' . htmlspecialchars($search_sn) . '"';
        if ($search_model) echo ' • Model: "' . htmlspecialchars($search_model) . '"';
        echo '</div>';
        ?>

        <?php if (!empty($deviceResults)): ?>
            <div class="section-title"><i class="fas fa-laptop"></i> Devices (<?= count($deviceResults) ?>)</div>
            <div class="table-wrapper">
                <table>
                    <thead><tr><th>#</th><th>Serial</th><th>Category</th><th>Model</th><th>Processor</th><th>RAM</th><th>Storage</th><th>Graphics</th><th>Touch?</th><th>Price</th><th>Branch</th><th>Action</th></tr></thead>
                    <tbody>
                        <?php $i=1; foreach ($deviceResults as $d): ?>
                        <tr>
                            <td><?= $i++ ?></td>
                            <td><code><?= htmlspecialchars($d['serial_number']) ?></code></td>
                            <td><span class="badge"><?= htmlspecialchars($d['category_name']) ?></span></td>
                            <td><?= htmlspecialchars($d['model_name']) ?></td>
                            <td><?= htmlspecialchars($d['processor']) ?></td>
                            <td><?= $d['ram'] ?> GB</span></td>
                            <td><?= htmlspecialchars($d['storage_type'] . ' ' . $d['storage_capacity'] . 'GB') ?></td>
                            <td><?= htmlspecialchars($d['graphics'] ?? 'N/A') ?></span></td>
                            <td><?= strtolower($d['category_name']) == 'desktop' ? 'N/A' : htmlspecialchars($d['touch'] ?? 'N/A') ?></td>
                            <td><?= $d['price'] ? 'KES ' . number_format($d['price'], 0) : '-' ?></td>
                            <td><span class="badge"><?= htmlspecialchars($d['branch']) ?></span></td>
                            <td><a href="../devices/view_device.php?sn=<?= urlencode($d['serial_number']) ?>" class="view-btn">View</a></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>

        <?php if (!empty($monitorResults)): ?>
            <div class="section-title"><i class="fas fa-desktop"></i> Monitors (<?= count($monitorResults) ?>)</div>
            <div class="table-wrapper">
                <table>
                    <thead><tr><th>#</th><th>Serial</th><th>Model</th><th>Size (")</th><th>Branch</th><th>Price</th><th>Action</th></tr></thead>
                    <tbody>
                        <?php $i=1; foreach ($monitorResults as $m): ?>
                        <tr>
                            <td><?= $i++ ?></td>
                            <td><code><?= htmlspecialchars($m['serial_number']) ?></code></td>
                            <td><?= htmlspecialchars($m['model_name']) ?></td>
                            <td><?= $m['size_inches'] ?>″</span></td>
                            <td><span class="badge"><?= htmlspecialchars($m['branch']) ?></span></td>
                            <td><?= $m['price'] ? 'KES ' . number_format($m['price'], 0) : '-' ?></td>
                            <td><a href="../monitors/view_monitor.php?sn=<?= urlencode($m['serial_number']) ?>" class="view-btn">View</a></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>

        <?php if (!empty($printerResults)): ?>
            <div class="section-title"><i class="fas fa-print"></i> Printers (<?= count($printerResults) ?>)</div>
            <div class="table-wrapper">
                <table>
                    <thead><tr><th>#</th><th>Serial</th><th>Model</th><th>Branch</th><th>Price</th><th>Action</th></tr></thead>
                    <tbody>
                        <?php $i=1; foreach ($printerResults as $p): ?>
                        <tr>
                            <td><?= $i++ ?></td>
                            <td><code><?= htmlspecialchars($p['serial_number']) ?></code></td>
                            <td><?= htmlspecialchars($p['model_name']) ?></td>
                            <td><span class="badge"><?= htmlspecialchars($p['branch']) ?></span></td>
                            <td><?= $p['price'] ? 'KES ' . number_format($p['price'], 0) : '-' ?></td>
                            <td><a href="../printers/view_printer.php?sn=<?= urlencode($p['serial_number']) ?>" class="view-btn">View</a></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>

        <?php if ($total === 0): ?>
            <div class="empty-state"><i class="fas fa-box-open"></i><p>No matching in‑stock items found.</p></div>
        <?php endif; ?>
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