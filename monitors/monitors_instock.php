<?php
session_start();
require_once "../config/db.php";
require_once "../includes/auth_check.php";

if (!in_array($_SESSION['role'], ['super_admin', 'inventory_admin', 'manager'])) {
    die("ACCESS DENIED.");
}

$user_id = (int) $_SESSION['user_id'];
$user_role = $_SESSION['role'];

$user_branch = null;
if ($user_role !== 'super_admin') {
    $stmt = $conn->prepare("SELECT branch FROM users WHERE id = ?");
    $stmt->execute([$user_id]);
    $user_branch = $stmt->fetchColumn();
    if (!$user_branch) die("Your account has no branch assigned.");
}

if (empty($_SESSION['monitor_sale_csrf'])) {
    $_SESSION['monitor_sale_csrf'] = bin2hex(random_bytes(32));
}

$salesStmt = $conn->prepare("
    SELECT id, full_name
    FROM users
    WHERE role = 'sales' AND is_active = 1
    ORDER BY full_name ASC
");
$salesStmt->execute();
$salesPeople = $salesStmt->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_sale_details'])) {
    $csrf = (string)($_POST['csrf_token'] ?? '');
    $serialPost = trim((string)($_POST['serial_number'] ?? ''));
    $salesPerson = (int)($_POST['sales_person'] ?? 0);
    $sellingPrice = (float)($_POST['selling_price'] ?? 0);
    $soldAtInput = trim((string)($_POST['sold_at'] ?? ''));
    $paymentStatus = trim((string)($_POST['payment_status'] ?? ''));
    $paymentMethod = trim((string)($_POST['payment_method'] ?? ''));

    try {
        if (!hash_equals($_SESSION['monitor_sale_csrf'], $csrf)) {
            throw new Exception('Security validation failed. Please try again.');
        }
        if ($serialPost === '') throw new Exception('Monitor serial number is required.');
        if ($salesPerson <= 0) throw new Exception('Please select a salesperson.');
        if ($sellingPrice <= 0) throw new Exception('Please enter a valid selling price.');
        if (!in_array($paymentStatus, ['paid', 'unpaid'], true)) {
            throw new Exception('Please select Paid or Unpaid.');
        }

        $allowedPaymentMethods = ['cash', 'mpesa-till', 'mpesa-pochi', 'bank-transfer'];
        if ($paymentMethod !== '' && !in_array($paymentMethod, $allowedPaymentMethods, true)) {
            throw new Exception('Invalid payment method selected.');
        }
        $paymentMethodDb = $paymentMethod !== '' ? $paymentMethod : null;

        $soldAt = null;
        if ($soldAtInput !== '') {
            $soldAtDate = DateTime::createFromFormat('Y-m-d\TH:i', $soldAtInput);
            $dateErrors = DateTime::getLastErrors();
            if (!$soldAtDate || ($dateErrors !== false && ($dateErrors['warning_count'] > 0 || $dateErrors['error_count'] > 0))) {
                throw new Exception('Please select a valid date sold.');
            }
            $soldAt = $soldAtDate->format('Y-m-d H:i:s');
        }

        $salesUserStmt = $conn->prepare("
            SELECT id, full_name FROM users
            WHERE id = ? AND role = 'sales' AND is_active = 1
            LIMIT 1
        ");
        $salesUserStmt->execute([$salesPerson]);
        $salesUser = $salesUserStmt->fetch(PDO::FETCH_ASSOC);
        if (!$salesUser) throw new Exception('Selected salesperson is not available.');

        $conn->beginTransaction();

        $monitorStmt = $conn->prepare("
            SELECT * FROM monitors
            WHERE serial_number = ? AND status = 'In Stock'
            FOR UPDATE
        ");
        $monitorStmt->execute([$serialPost]);
        $monitor = $monitorStmt->fetch(PDO::FETCH_ASSOC);
        if (!$monitor) throw new Exception('Monitor was not found in stock.');

        if ($user_role !== 'super_admin' && $user_branch !== '' && $monitor['branch'] !== $user_branch) {
            throw new Exception('You cannot sell a monitor from another branch.');
        }

        $description = trim(($monitor['model_name'] ?? 'Monitor') .
            (!empty($monitor['size_inches']) ? ' | ' . $monitor['size_inches'] . '"' : ''));

        $updateMonitor = $conn->prepare("
            UPDATE monitors
            SET status = 'Sold',
                selling_price = ?,
                sold_at = COALESCE(?, NOW()),
                sold_by = ?
            WHERE serial_number = ?
        ");
        $updateMonitor->execute([$sellingPrice, $soldAt, $salesPerson, $serialPost]);

        $saleStmt = $conn->prepare("
            INSERT INTO sales (
                total_amount, sale_status, completed_at, sold_by,
                payment_method, payment_status, completion_status
            )
            VALUES (?, 'completed', COALESCE(?, NOW()), ?, ?, ?, 'Completed')
        ");
        $saleStmt->execute([$sellingPrice, $soldAt, $salesPerson, $paymentMethodDb, $paymentStatus]);
        $saleId = (int)$conn->lastInsertId();

        $saleItemStmt = $conn->prepare("
            INSERT INTO sale_items (
                sale_id, item_type, item_id, description,
                quantity, unit_price, sales_person
            )
            VALUES (?, 'monitors', ?, ?, 1, ?, ?)
        ");
        $saleItemStmt->execute([
            $saleId, $serialPost, $description, $sellingPrice, $salesPerson
        ]);

        $methodLabel = $paymentMethodDb ?? 'Not specified';
        $logStmt = $conn->prepare("
            INSERT INTO activity_logs (user_id, action, details)
            VALUES (?, 'Updated monitor sale details', ?)
        ");
        $logStmt->execute([
            $user_id,
            "Marked monitor SN: {$serialPost} as sold; salesperson: {$salesUser['full_name']}; " .
            "price: KES " . number_format($sellingPrice, 2) .
            "; payment status: {$paymentStatus}; payment method: {$methodLabel}; sale #{$saleId}"
        ]);

        $conn->commit();
        $_SESSION['monitor_sale_success'] = "Sale details updated successfully for monitor {$serialPost}. Sale #{$saleId} created.";
    } catch (Throwable $e) {
        if ($conn->inTransaction()) $conn->rollBack();
        $_SESSION['monitor_sale_error'] = $e->getMessage();
    }

    $queryString = $_SERVER['QUERY_STRING'] ?? '';
    header('Location: monitors_instock' . ($queryString !== '' ? '?' . $queryString : ''));
    exit;
}

$flashSuccess = $_SESSION['monitor_sale_success'] ?? '';
$flashError = $_SESSION['monitor_sale_error'] ?? '';
unset($_SESSION['monitor_sale_success'], $_SESSION['monitor_sale_error']);

$filter_serial = trim($_GET['serial'] ?? '');
$filter_model = trim($_GET['model'] ?? '');
$filter_branch = $_GET['branch'] ?? '';

// Pagination only: default 50, selectable up to 200.
$allowed_per_page = [50, 100, 150, 200];
$per_page = isset($_GET['per_page']) ? (int)$_GET['per_page'] : 50;
if (!in_array($per_page, $allowed_per_page, true)) {
    $per_page = 50;
}
$page = max(1, (int)($_GET['page'] ?? 1));

$where = ["m.status = 'In Stock'"];
$params = [];

if ($user_role !== 'super_admin') {
    $where[] = "m.branch = :user_branch";
    $params['user_branch'] = $user_branch;
}
if (!empty($filter_serial)) {
    $where[] = "m.serial_number LIKE :serial";
    $params['serial'] = $filter_serial . '%';
}

if (!empty($filter_model)) {
    $where[] = "m.model_name LIKE :model";
    $params['model'] = "%{$filter_model}%";
}
if ($user_role === 'super_admin' && !empty($filter_branch)) {
    $where[] = "m.branch = :branch";
    $params['branch'] = $filter_branch;
}

$whereSql = implode(" AND ", $where);

// Lightweight count first so we do not load all monitor rows.
$countStmt = $conn->prepare("SELECT COUNT(*) FROM monitors m WHERE {$whereSql}");
$countStmt->execute($params);
$total_monitors = (int)$countStmt->fetchColumn();

$valueStmt = $conn->prepare("SELECT COALESCE(SUM(m.price), 0) FROM monitors m WHERE {$whereSql}");
$valueStmt->execute($params);
$total_stock_value = (float)$valueStmt->fetchColumn();

$total_pages = max(1, (int)ceil($total_monitors / $per_page));
if ($page > $total_pages) {
    $page = $total_pages;
}
$offset = ($page - 1) * $per_page;

// Load only the rows needed for the current page.
$sql = "SELECT m.serial_number, m.model_name, m.size_inches, m.price, m.branch, m.date_added, u.full_name AS added_by
        FROM monitors m
        JOIN users u ON m.added_by = u.id
        WHERE {$whereSql}
        ORDER BY m.date_added DESC
        LIMIT :limit OFFSET :offset";

$stmt = $conn->prepare($sql);
foreach ($params as $key => $value) {
    $stmt->bindValue(':' . $key, $value);
}
$stmt->bindValue(':limit', $per_page, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$monitors = $stmt->fetchAll(PDO::FETCH_ASSOC);

function monitorPageUrl(int $pageNumber): string {
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
    <title>In‑Stock Monitors | Mombasa Computers</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        :root {
            --primary: #1a4b2a;
            --primary-light: #2a6b3a;
            --primary-dark: #0f3a1e;
            --info: #2563eb;
            --gray-50: #f9fafb;
            --gray-100: #f3f4f6;
            --gray-200: #e5e7eb;
            --gray-300: #d1d5db;
            --gray-400: #9ca3af;
            --gray-500: #6b7280;
            --gray-600: #4b5563;
            --gray-700: #374151;
            --gray-800: #1f2937;
            --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
            --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1);
            --radius-sm: 0.375rem;
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
        .filter-form { background: white; padding: 1.25rem; border-radius: var(--radius-xl); margin-bottom: 1.5rem; border: 1px solid var(--gray-200); display: flex; flex-wrap: wrap; gap: 1rem; align-items: flex-end; }
        .filter-group { flex: 1; min-width: 180px; }
        .filter-group label { display: block; font-size: 0.75rem; font-weight: 500; color: var(--gray-600); margin-bottom: 0.25rem; }
        .filter-group input, .filter-group select { width: 100%; padding: 0.6rem 0.75rem; border: 1px solid var(--gray-300); border-radius: var(--radius-md); font-size: 0.85rem; }
        .btn { padding: 0.6rem 1.2rem; background: var(--primary); color: white; border: none; border-radius: var(--radius-md); cursor: pointer; display: inline-flex; align-items: center; gap: 0.5rem; font-weight: 500; text-decoration: none; }
        .btn-secondary { background: var(--gray-500); }
        .btn-view { background: var(--info); color: white; padding: 0.4rem 1rem; border-radius: var(--radius-md); font-size: 0.8rem; text-decoration: none; display: inline-flex; align-items: center; gap: 0.4rem; transition: background 0.2s; }
        .btn-view:hover { background: #1d4ed8; }
        .table-wrapper { background: white; border-radius: var(--radius-xl); border: 1px solid var(--gray-200); overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; min-width: 700px; }
        th { background: var(--gray-50); padding: 1rem; text-align: left; font-weight: 600; color: var(--gray-600); border-bottom: 1px solid var(--gray-200); white-space: nowrap; }
        td { padding: 0.9rem 1rem; border-bottom: 1px solid var(--gray-100); vertical-align: middle; }
        .badge { display: inline-block; padding: 0.2rem 0.6rem; border-radius: 9999px; font-size: 0.7rem; font-weight: 500; background: var(--gray-100); }
        .branch-kimathi { color: #059669; font-weight: 500; }
        .branch-moi { color: #3b82f6; font-weight: 500; }
        .empty-state { text-align: center; padding: 3rem; color: var(--gray-500); }
        .footer { text-align: center; padding: 1.5rem 0 0.5rem; margin-top: 1.5rem; font-size: 0.85rem; color: var(--gray-400); border-top: 1px solid var(--gray-200); }
        .pagination-bar { display:flex; justify-content:space-between; align-items:center; gap:1rem; flex-wrap:wrap; padding:1rem 1.25rem; border-top:1px solid var(--gray-200); background:white; }
        .pagination-controls { display:flex; align-items:center; gap:.4rem; flex-wrap:wrap; }
        .pagination-controls a, .pagination-controls span { padding:.45rem .7rem; border:1px solid var(--gray-300); border-radius:var(--radius-md); text-decoration:none; color:var(--gray-600); background:white; font-size:.85rem; }
        .pagination-controls .active { background:var(--primary); color:white; border-color:var(--primary); }
        .pagination-controls .disabled { opacity:.45; pointer-events:none; }
        .per-page-form { display:flex; align-items:center; gap:.5rem; font-size:.85rem; color:var(--gray-600); }
        .per-page-form select { padding:.45rem .65rem; border:1px solid var(--gray-300); border-radius:var(--radius-md); background:white; }


        .action-links { display:flex; gap:.5rem; flex-wrap:wrap; }
        .btn-sale { background:#166534; color:white; border:0; border-radius:var(--radius-md); padding:.4rem .7rem; font-size:.8rem; cursor:pointer; display:inline-flex; align-items:center; gap:.35rem; }
        .btn-sale:hover { background:#14532d; }
        .alert { padding:1rem 1.25rem; border-radius:var(--radius-md); margin-bottom:1rem; display:flex; align-items:center; gap:.65rem; }
        .alert-success { background:#ecfdf5; border:1px solid #a7f3d0; color:#065f46; }
        .alert-error { background:#fef2f2; border:1px solid #fecaca; color:#991b1b; }
        .sale-modal { position:fixed; inset:0; background:rgba(15,23,42,.58); display:none; align-items:center; justify-content:center; z-index:9999; padding:1rem; }
        .sale-modal.open { display:flex; }
        .sale-modal-dialog { width:min(520px,100%); max-height:92vh; overflow-y:auto; background:white; border-radius:14px; box-shadow:0 24px 60px rgba(0,0,0,.22); }
        .sale-modal-header { padding:1.15rem 1.25rem; display:flex; justify-content:space-between; align-items:center; border-bottom:1px solid var(--gray-200); }
        .sale-modal-header h3 { margin:0; font-size:1.05rem; }
        .modal-close { border:0; background:transparent; color:var(--gray-500); cursor:pointer; font-size:1.1rem; }
        .sale-modal-body { padding:1.25rem; }
        .sale-monitor-label { margin-bottom:1rem; padding:.8rem .9rem; border-radius:8px; background:var(--gray-50); border:1px solid var(--gray-200); font-size:.85rem; }
        .sale-form-group { margin-bottom:1rem; }
        .sale-form-group label { display:block; margin-bottom:.4rem; font-size:.82rem; font-weight:600; color:var(--gray-600); }
        .sale-form-group input, .sale-form-group select { width:100%; padding:.7rem .8rem; border:1px solid var(--gray-300); border-radius:8px; background:white; font:inherit; }
        .modal-actions { display:flex; gap:.75rem; justify-content:flex-end; padding-top:.4rem; }

                @media (max-width: 1200px) { .main-content { margin-left: 0 !important; width: 100% !important; padding: 1.5rem 1rem 1rem !important; padding-top: 5rem !important; } }
        @media (max-width: 768px) { .filter-form { flex-direction: column; } .filter-group { min-width: auto; } .btn, .btn-view { width: 100%; justify-content: center; } }
    </style>
</head>
<body>
<?php include "../includes/sidebar.php"; ?>
<div class="main-content">
    <div class="page-header">
        <h1><i class="fas fa-box"></i> In‑Stock Monitors</h1>
        <div class="breadcrumb">
            <?php if ($user_role === 'super_admin'): ?>
                <a href="../dashboard/superadmindashboard">Dashboard</a>
            <?php elseif ($user_role === 'manager'): ?>
                <a href="../dashboard/managerdashboard">Dashboard</a>
            <?php else: ?>
                <a href="../dashboard/inventorydashboard">Dashboard</a>
            <?php endif; ?>
            <span> / </span>
            <span>Monitors In Stock</span>
        </div>
    </div>

    <?php if ($flashSuccess): ?>
        <div class="alert alert-success"><i class="fas fa-check-circle"></i><?= htmlspecialchars($flashSuccess) ?></div>
    <?php endif; ?>
    <?php if ($flashError): ?>
        <div class="alert alert-error"><i class="fas fa-exclamation-circle"></i><?= htmlspecialchars($flashError) ?></div>
    <?php endif; ?>

    <div class="stats-row">
        <div class="stat-card"><div class="stat-value"><?= number_format($total_monitors) ?></div><div class="stat-label">Total In Stock</div></div>
        <div class="stat-card"><div class="stat-value">KES <?= number_format($total_stock_value, 2) ?></div><div class="stat-label">Total Stock Value</div></div>
        <div class="stat-card"><div class="stat-value"><?= ($user_role === 'super_admin' ? '2' : '1') ?></div><div class="stat-label">Branch(es)</div></div>
    </div>

    <form method="GET" class="filter-form" id="filterForm">
        <input type="hidden" name="per_page" value="<?= (int)$per_page ?>">
        <div class="filter-group">
            <label>Serial Number</label>
            <input type="text" id="serialSearch" name="serial" placeholder="Scan or type..." value="<?= htmlspecialchars($filter_serial) ?>" autocomplete="off" autofocus>
        </div>
        <div class="filter-group">
            <label>Model Name</label>
            <input type="text" name="model" placeholder="e.g. Dell P2422H..." value="<?= htmlspecialchars($filter_model) ?>">
        </div>
        <?php if ($user_role === 'super_admin'): ?>
            <div class="filter-group">
                <label>Branch</label>
                <select name="branch">
                    <option value="">All Branches</option>
                    <option value="KIMATHI" <?= $filter_branch === 'KIMATHI' ? 'selected' : '' ?>>KIMATHI</option>
                    <option value="MOI" <?= $filter_branch === 'MOI' ? 'selected' : '' ?>>MOI</option>
                </select>
            </div>
        <?php endif; ?>
        <div class="filter-group">
            <button type="submit" class="btn"><i class="fas fa-search"></i> Search</button>
            <a href="monitors_instock" class="btn btn-secondary" style="background:var(--gray-500); margin-left:0.5rem;">Reset</a>
        </div>
    </form>

    <div class="table-wrapper">
        <div class="table-responsive">
            <?php if ($monitors): ?>
                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Serial</th>
                            <th>Model</th>
                            <th>Size</th>
                            <th>Price (KES)</th>
                            <th>Branch</th>
                            <th>Added By</th>
                            <th>Date Added</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php $i=$offset + 1; foreach ($monitors as $m): ?>
                        <tr>
                            <td><?= $i++ ?></td>
                            <td><code><?= htmlspecialchars($m['serial_number']) ?></code></td>
                            <td><?= htmlspecialchars($m['model_name']) ?></td>
                            <td><?= $m['size_inches'] ?? '-' ?></td>
                            <td><?= $m['price'] !== null ? number_format((float)$m['price'], 2) : '—' ?></td>
                            <td class="<?= $m['branch'] === 'KIMATHI' ? 'branch-kimathi' : 'branch-moi' ?>"><?= htmlspecialchars($m['branch']) ?></td>
                            <td><?= htmlspecialchars($m['added_by']) ?></td>
                            <td><?= date('M j, Y', strtotime($m['date_added'])) ?></td>
                            <td>
                                <div class="action-links">
                                    <a href="view_monitor?sn=<?= urlencode($m['serial_number']) ?>" class="btn-view"><i class="fas fa-eye"></i> View</a>
                                    <button type="button" class="btn-sale"
                                            data-serial="<?= htmlspecialchars($m['serial_number'], ENT_QUOTES) ?>"
                                            data-model="<?= htmlspecialchars($m['model_name'], ENT_QUOTES) ?>"
                                            data-size="<?= htmlspecialchars((string)($m['size_inches'] ?? ''), ENT_QUOTES) ?>"
                                            onclick="openSaleModal(this)">
                                        <i class="fas fa-cash-register"></i> Update Sale Details
                                    </button>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <div class="empty-state"><i class="fas fa-box-open"></i><p>No monitors in stock.</p></div>
            <?php endif; ?>
        </div>

        <?php if ($total_monitors > 0): ?>
        <div class="pagination-bar">
            <form method="GET" class="per-page-form">
                <?php foreach ($_GET as $key => $value): ?>
                    <?php if ($key !== 'per_page' && $key !== 'page' && !is_array($value)): ?>
                        <input type="hidden" name="<?= htmlspecialchars((string)$key) ?>" value="<?= htmlspecialchars((string)$value) ?>">
                    <?php endif; ?>
                <?php endforeach; ?>

                <label for="monitorPerPage">Show</label>
                <select id="monitorPerPage" name="per_page" onchange="this.form.submit()">
                    <?php foreach ($allowed_per_page as $size): ?>
                        <option value="<?= $size ?>" <?= $per_page === $size ? 'selected' : '' ?>><?= $size ?></option>
                    <?php endforeach; ?>
                </select>
                <span>per page</span>
            </form>

            <div class="pagination-controls">
                <?php if ($page > 1): ?>
                    <a href="<?= htmlspecialchars(monitorPageUrl($page - 1)) ?>">Previous</a>
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
                        <a href="<?= htmlspecialchars(monitorPageUrl($p)) ?>"><?= $p ?></a>
                    <?php endif; ?>
                <?php endfor; ?>

                <?php if ($page < $total_pages): ?>
                    <a href="<?= htmlspecialchars(monitorPageUrl($page + 1)) ?>">Next</a>
                <?php else: ?>
                    <span class="disabled">Next</span>
                <?php endif; ?>
            </div>
        </div>
        <?php endif; ?>
    </div>
    <div class="footer"><i class="fas fa-copyright"></i> <?= date('Y'); ?> Mombasa Computers</div>
</div>

<div class="sale-modal" id="saleModal" aria-hidden="true">
    <div class="sale-modal-dialog">
        <div class="sale-modal-header">
            <h3><i class="fas fa-cash-register"></i> Update Monitor Sale Details</h3>
            <button type="button" class="modal-close" onclick="closeSaleModal()"><i class="fas fa-times"></i></button>
        </div>
        <form method="POST" class="sale-modal-body">
            <input type="hidden" name="update_sale_details" value="1">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['monitor_sale_csrf']) ?>">
            <input type="hidden" name="serial_number" id="saleSerial">

            <div class="sale-monitor-label" id="saleMonitorLabel"></div>

            <div class="sale-form-group">
                <label for="sales_person">Sales Person</label>
                <select name="sales_person" id="sales_person" required>
                    <option value="">-- Select Sales Person --</option>
                    <?php foreach ($salesPeople as $salesPerson): ?>
                        <option value="<?= (int)$salesPerson['id'] ?>"><?= htmlspecialchars($salesPerson['full_name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="sale-form-group">
                <label for="selling_price">Selling Price (KES)</label>
                <input type="number" name="selling_price" id="selling_price" min="0.01" step="0.01" required>
            </div>

            <div class="sale-form-group">
                <label for="sold_at">Date Sold <span style="font-weight:400;color:var(--gray-500);">(Optional — current time if blank)</span></label>
                <input type="datetime-local" name="sold_at" id="sold_at">
            </div>

            <div class="sale-form-group">
                <label for="payment_status">Payment Status</label>
                <select name="payment_status" id="payment_status" required>
                    <option value="">-- Select --</option>
                    <option value="paid">Paid</option>
                    <option value="unpaid">Unpaid</option>
                </select>
            </div>

            <div class="sale-form-group">
                <label for="payment_method">Payment Method <span style="font-weight:400;color:var(--gray-500);">(Optional)</span></label>
                <select name="payment_method" id="payment_method">
                    <option value="">Not specified</option>
                    <option value="cash">Cash</option>
                    <option value="mpesa-till">M-Pesa Till</option>
                    <option value="mpesa-pochi">M-Pesa Pochi</option>
                    <option value="bank-transfer">Bank Transfer</option>
                </select>
            </div>

            <div class="modal-actions">
                <button type="button" class="btn btn-secondary" onclick="closeSaleModal()">Cancel</button>
                <button type="submit" class="btn"><i class="fas fa-check"></i> Save Sale Details</button>
            </div>
        </form>
    </div>
</div>

<script>
(function(){
    const form = document.getElementById('filterForm');
    const serialInput = document.getElementById('serialSearch');
    if (!form || !serialInput) return;

    let timer = null;
    let controller = null;

    async function ajaxFilter() {
        if (controller) controller.abort();
        controller = new AbortController();

        const params = new URLSearchParams(new FormData(form));
        params.set('page', '1');
        const url = form.action || window.location.pathname;

        try {
            const response = await fetch(url + '?' + params.toString(), {
                headers: {'X-Requested-With': 'XMLHttpRequest'},
                signal: controller.signal
            });

            if (!response.ok) throw new Error('Search request failed');

            const html = await response.text();
            const doc = new DOMParser().parseFromString(html, 'text/html');

            const newStats = doc.querySelector('.stats-row');
            const newTable = doc.querySelector('.table-wrapper');
            const stats = document.querySelector('.stats-row');
            const table = document.querySelector('.table-wrapper');

            if (newStats && stats) stats.innerHTML = newStats.innerHTML;
            if (newTable && table) table.innerHTML = newTable.innerHTML;

            history.replaceState(
                null,
                '',
                url + (params.toString() ? '?' + params.toString() : '')
            );

            serialInput.focus();
        } catch (e) {
            if (e.name !== 'AbortError') console.error(e);
        }
    }

    serialInput.addEventListener('input', function(){
        clearTimeout(timer);
        const value = this.value.trim();

        // Same behavior as In-Stock Devices.
        if (value.length === 1) return;

        timer = setTimeout(ajaxFilter, 250);
    });
})();

function openSaleModal(button) {
    const modal = document.getElementById('saleModal');
    document.getElementById('saleSerial').value = button.dataset.serial || '';
    const size = button.dataset.size ? ' | ' + button.dataset.size + '"' : '';
    document.getElementById('saleMonitorLabel').textContent =
        (button.dataset.model || 'Monitor') + size + ' | SN: ' + (button.dataset.serial || '');
    modal.classList.add('open');
    modal.setAttribute('aria-hidden', 'false');
}
function closeSaleModal() {
    const modal = document.getElementById('saleModal');
    modal.classList.remove('open');
    modal.setAttribute('aria-hidden', 'true');
}
document.getElementById('saleModal')?.addEventListener('click', function(e) {
    if (e.target === this) closeSaleModal();
});
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') closeSaleModal();
});
</script>
<?php require_once "../includes/footer.php"; ?>
</body>
</html>