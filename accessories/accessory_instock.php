<?php
session_start();
require_once "../config/db.php";
require_once "../includes/auth_check.php";



$role = $_SESSION['role'];
$user_id = $_SESSION['user_id'];

// Allow super_admin, inventory_admin, manager, and sales
if (!in_array($role, ['super_admin', 'inventory_admin', 'manager', 'sales'])) {
    die("Access denied!");
}

// For managers, restrict to their branch if they have one
$user_branch = '';
if ($role === 'manager') {
    $user_stmt = $conn->prepare("SELECT branch FROM users WHERE id = ?");
    $user_stmt->execute([$user_id]);
    $user_data = $user_stmt->fetch(PDO::FETCH_ASSOC);
    $user_branch = $user_data['branch'] ?? '';
}

// One-time security token for Update Sale Details.
if (empty($_SESSION['accessory_sale_csrf'])) {
    $_SESSION['accessory_sale_csrf'] = bin2hex(random_bytes(32));
}

// Active salespeople used in the Update Sale Details dialog.
$salesStmt = $conn->prepare("SELECT id, full_name FROM users WHERE role = 'sales' AND is_active = 1 ORDER BY full_name ASC");
$salesStmt->execute();
$salesPeople = $salesStmt->fetchAll(PDO::FETCH_ASSOC);

// Update accessory sale details directly from In-Stock Accessories.
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_sale_details'])) {
    $csrf = (string)($_POST['csrf_token'] ?? '');
    $accessoryId = (int)($_POST['accessory_id'] ?? 0);
    $salesPerson = (int)($_POST['sales_person'] ?? 0);
    $quantitySold = (int)($_POST['quantity_sold'] ?? 0);
    $sellingPrice = (float)($_POST['selling_price'] ?? 0); // per unit
    $soldAtInput = trim((string)($_POST['sold_at'] ?? ''));
    $paymentStatus = trim((string)($_POST['payment_status'] ?? ''));
    $paymentMethod = trim((string)($_POST['payment_method'] ?? ''));

    try {
        if (!hash_equals($_SESSION['accessory_sale_csrf'], $csrf)) throw new Exception('Security validation failed. Please try again.');
        if ($accessoryId <= 0) throw new Exception('Accessory is required.');
        if ($salesPerson <= 0) throw new Exception('Please select a salesperson.');
        if ($quantitySold <= 0) throw new Exception('Please enter a valid quantity.');
        if ($sellingPrice <= 0) throw new Exception('Please enter a valid selling price.');
        if (!in_array($paymentStatus, ['paid', 'unpaid'], true)) throw new Exception('Please select Paid or Unpaid.');

        $allowedPaymentMethods = ['cash', 'mpesa-till', 'mpesa-pochi', 'bank-transfer'];
        if ($paymentMethod !== '' && !in_array($paymentMethod, $allowedPaymentMethods, true)) throw new Exception('Invalid payment method selected.');
        $paymentMethodDb = $paymentMethod !== '' ? $paymentMethod : null;

        $soldAt = null;
        if ($soldAtInput !== '') {
            $dt = DateTime::createFromFormat('Y-m-d\\TH:i', $soldAtInput, new DateTimeZone('Africa/Nairobi'));
            if (!$dt || $dt->format('Y-m-d\\TH:i') !== $soldAtInput) throw new Exception('Invalid date sold.');
            $soldAt = $dt->format('Y-m-d H:i:s');
        }

        $salesUserStmt = $conn->prepare("SELECT id, full_name FROM users WHERE id = ? AND role = 'sales' AND is_active = 1 LIMIT 1");
        $salesUserStmt->execute([$salesPerson]);
        $salesUser = $salesUserStmt->fetch(PDO::FETCH_ASSOC);
        if (!$salesUser) throw new Exception('Selected salesperson is not available.');

        $conn->beginTransaction();

        $accessoryStmt = $conn->prepare("SELECT * FROM accessories WHERE id = ? AND status = 'instock' FOR UPDATE");
        $accessoryStmt->execute([$accessoryId]);
        $accessory = $accessoryStmt->fetch(PDO::FETCH_ASSOC);
        if (!$accessory) throw new Exception('Accessory was not found in stock.');
        if ($role === 'manager' && $user_branch !== '' && $accessory['branch'] !== $user_branch) throw new Exception('You cannot sell an accessory from another branch.');
        if ($quantitySold > (int)$accessory['quantity']) throw new Exception('Quantity sold cannot exceed available stock of ' . (int)$accessory['quantity'] . '.');

        $remainingQty = (int)$accessory['quantity'] - $quantitySold;
        $newStatus = $remainingQty === 0 ? 'sold' : 'instock';
        $totalAmount = $quantitySold * $sellingPrice;

        $updateAccessory = $conn->prepare("UPDATE accessories SET quantity = ?, status = ?, updated_by = ?, updated_at = NOW() WHERE id = ?");
        $updateAccessory->execute([$remainingQty, $newStatus, $user_id, $accessoryId]);

        $saleStmt = $conn->prepare("INSERT INTO sales (total_amount, sale_status, completed_at, sold_by, payment_method, payment_status, completion_status) VALUES (?, 'completed', COALESCE(?, NOW()), ?, ?, ?, 'Completed')");
        $saleStmt->execute([$totalAmount, $soldAt, $salesPerson, $paymentMethodDb, $paymentStatus]);
        $saleId = (int)$conn->lastInsertId();

        $description = trim(($accessory['name'] ?? '') . (!empty($accessory['type']) ? ' | ' . $accessory['type'] : '') . ' | ' . ($accessory['branch'] ?? '') . ' | ' . ($accessory['place'] ?? ''));
        $saleItemStmt = $conn->prepare("INSERT INTO sale_items (sale_id, item_type, item_id, description, quantity, unit_price, sales_person) VALUES (?, 'accessory', ?, ?, ?, ?, ?)");
        $saleItemStmt->execute([$saleId, $accessoryId, $description, $quantitySold, $sellingPrice, $salesPerson]);
        $saleItemId = (int)$conn->lastInsertId();

        $soldAccessoryStmt = $conn->prepare("INSERT INTO sold_accessories (accessory_id, accessory_name, quantity, selling_price, branch, sold_by, date_sold, sale_item_id) VALUES (?, ?, ?, ?, ?, ?, COALESCE(?, NOW()), ?)");
        $soldAccessoryStmt->execute([$accessoryId, $accessory['name'], $quantitySold, $sellingPrice, $accessory['branch'], $salesPerson, $soldAt, $saleItemId]);

        $methodLabel = $paymentMethodDb ?? 'Not specified';
        $logStmt = $conn->prepare("INSERT INTO activity_logs (user_id, action, details) VALUES (?, 'Updated Accessory Sale Details', ?)");
        $logStmt->execute([$user_id, "Sold {$quantitySold} x {$accessory['name']}; salesperson: {$salesUser['full_name']}; unit price: KES " . number_format($sellingPrice, 2) . "; total: KES " . number_format($totalAmount, 2) . "; payment status: {$paymentStatus}; payment method: {$methodLabel}; sale #{$saleId}"]);

        $conn->commit();
        $_SESSION['accessory_sale_success'] = "Sale details updated successfully for {$accessory['name']}. Sale #{$saleId} created.";
    } catch (Throwable $e) {
        if ($conn->inTransaction()) $conn->rollBack();
        $_SESSION['accessory_sale_error'] = $e->getMessage();
    }

    $query = $_GET;
    unset($query['update_sale_details']);
    header('Location: accessory_instock.php' . ($query ? '?' . http_build_query($query) : ''));
    exit;
}

$flashSuccess = $_SESSION['accessory_sale_success'] ?? '';
$flashError = $_SESSION['accessory_sale_error'] ?? '';
unset($_SESSION['accessory_sale_success'], $_SESSION['accessory_sale_error']);

// Handle search inputs
$search_name = trim($_GET['name'] ?? '');
$search_type = trim($_GET['type'] ?? '');
$search_branch = trim($_GET['branch'] ?? '');
$search_place = trim($_GET['place'] ?? '');

// Pagination: default 50, selectable up to 200.
$allowed_per_page = [50, 100, 150, 200];
$per_page = isset($_GET['per_page']) ? (int)$_GET['per_page'] : 50;
if (!in_array($per_page, $allowed_per_page, true)) {
    $per_page = 50;
}
$page = max(1, (int)($_GET['page'] ?? 1));

// Shared filters
$where = ["a.status = 'instock'"];
$params = [];

if ($role === 'manager' && !empty($user_branch)) {
    $where[] = "a.branch = :user_branch";
    $params['user_branch'] = $user_branch;
}
if ($search_name !== '') {
    $where[] = "a.name LIKE :name";
    $params['name'] = "%{$search_name}%";
}
if ($search_type !== '') {
    $where[] = "a.type = :type";
    $params['type'] = $search_type;
}
if ($search_branch !== '' && $role !== 'manager') {
    $where[] = "a.branch = :branch";
    $params['branch'] = $search_branch;
}
if ($search_place !== '') {
    $where[] = "a.place = :place";
    $params['place'] = $search_place;
}
$whereSql = implode(" AND ", $where);

// Lightweight count for pagination.
$countStmt = $conn->prepare("SELECT COUNT(*) FROM accessories a WHERE {$whereSql}");
$countStmt->execute($params);
$total_items = (int)$countStmt->fetchColumn();

$total_pages = max(1, (int)ceil($total_items / $per_page));
if ($page > $total_pages) {
    $page = $total_pages;
}
$offset = ($page - 1) * $per_page;

// Stats in SQL, without loading all rows.
$statsStmt = $conn->prepare("
    SELECT
        COALESCE(SUM(a.quantity), 0) AS total_quantity,
        COALESCE(SUM(CASE WHEN a.price IS NOT NULL THEN a.quantity * a.price ELSE 0 END), 0) AS total_value
    FROM accessories a
    WHERE {$whereSql}
");
$statsStmt->execute($params);
$stats = $statsStmt->fetch(PDO::FETCH_ASSOC) ?: [];
$total_quantity = (int)($stats['total_quantity'] ?? 0);
$total_value = (float)($stats['total_value'] ?? 0);

// Load only current page rows.
$sql = "SELECT a.*,
               u1.full_name AS added_by_name,
               u2.full_name AS updated_by_name
        FROM accessories a
        LEFT JOIN users u1 ON a.added_by = u1.id
        LEFT JOIN users u2 ON a.updated_by = u2.id
        WHERE {$whereSql}
        ORDER BY a.date_added DESC, a.id DESC
        LIMIT :limit OFFSET :offset";

$stmt = $conn->prepare($sql);
foreach ($params as $key => $value) {
    $stmt->bindValue(':' . $key, $value);
}
$stmt->bindValue(':limit', $per_page, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$accessories = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Available filter options, independent of the current page.
$optionWhere = ["status = 'instock'"];
$optionParams = [];
if ($role === 'manager' && !empty($user_branch)) {
    $optionWhere[] = "branch = :option_user_branch";
    $optionParams['option_user_branch'] = $user_branch;
}
$optionWhereSql = implode(" AND ", $optionWhere);

$typeStmt = $conn->prepare("
    SELECT DISTINCT type
    FROM accessories
    WHERE {$optionWhereSql}
      AND type IS NOT NULL
      AND TRIM(type) <> ''
    ORDER BY type
");
$typeStmt->execute($optionParams);
$types = $typeStmt->fetchAll(PDO::FETCH_COLUMN);

$branchStmt = $conn->prepare("
    SELECT DISTINCT branch
    FROM accessories
    WHERE {$optionWhereSql}
      AND branch IS NOT NULL
      AND TRIM(branch) <> ''
    ORDER BY branch
");
$branchStmt->execute($optionParams);
$branches = $branchStmt->fetchAll(PDO::FETCH_COLUMN);

$placeStmt = $conn->prepare("
    SELECT DISTINCT place
    FROM accessories
    WHERE {$optionWhereSql}
      AND place IS NOT NULL
      AND TRIM(place) <> ''
    ORDER BY place
");
$placeStmt->execute($optionParams);
$places = $placeStmt->fetchAll(PDO::FETCH_COLUMN);

function accessoryPageUrl(int $pageNumber): string {
    $query = $_GET;
    $query['page'] = $pageNumber;
    return '?' . http_build_query($query);
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>In‑Stock Accessories | Mombasa Computers</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        /* ===== EXACT SAME CSS AS instock.php (devices) ===== */
        :root {
            --primary: #1a4b2a;
            --primary-light: #2a6b3a;
            --primary-dark: #0f3a1e;
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
            --font-sans: 'Inter', system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }

        @import url('https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,400;14..32,500;14..32,600;14..32,700&display=swap');

        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: var(--font-sans); background: var(--gray-100); color: var(--gray-800); line-height: 1.5; overflow-x: hidden; }

        .main-content {
            padding: 2rem 2rem 1rem;
            margin-left: 260px;
            width: calc(100% - 260px);
            min-height: 100vh;
            background: var(--gray-100);
            transition: margin-left 0.3s ease, width 0.3s ease, padding 0.3s ease;
            overflow-x: hidden;
            max-width: 100%;
        }

        .page-header {
            background: white;
            padding: 1.5rem 2rem;
            border-radius: var(--radius-xl);
            margin-bottom: 1.5rem;
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--gray-200);
        }

        .page-header h1 {
            font-size: 1.75rem;
            color: var(--gray-800);
            font-weight: 600;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .page-header h1 i { color: var(--primary); font-size: 1.75rem; }

        .breadcrumb {
            color: var(--gray-500);
            font-size: 0.9rem;
        }
        .breadcrumb a { color: var(--primary); text-decoration: none; }
        .breadcrumb a:hover { text-decoration: underline; }

        .stats-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .stat-card {
            background: white;
            padding: 1.25rem;
            border-radius: var(--radius-lg);
            border: 1px solid var(--gray-200);
            box-shadow: var(--shadow-sm);
            transition: all 0.2s ease;
        }
        .stat-card:hover { transform: translateY(-2px); box-shadow: var(--shadow-md); }
        .stat-card .stat-icon { font-size: 1.5rem; color: var(--primary); margin-bottom: 0.5rem; }
        .stat-card .stat-value { font-size: 1.75rem; font-weight: 600; color: var(--gray-800); }
        .stat-card .stat-label { font-size: 0.85rem; color: var(--gray-500); margin-top: 0.25rem; }

        .search-section {
            background: white;
            padding: 1.5rem;
            border-radius: var(--radius-xl);
            margin-bottom: 1.5rem;
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--gray-200);
        }

        .search-title {
            font-size: 1rem;
            font-weight: 500;
            color: var(--gray-700);
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .search-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
        }

        .search-group {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }
        .search-group label { font-size: 0.85rem; font-weight: 500; color: var(--gray-600); }
        .search-group input, .search-group select {
            padding: 0.625rem 0.875rem;
            border: 1px solid var(--gray-300);
            border-radius: var(--radius-md);
            font-size: 0.9rem;
            transition: all 0.2s ease;
            font-family: var(--font-sans);
            background: white;
        }
        .search-group input:focus, .search-group select:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(26,75,42,0.1);
        }

        .search-actions {
            display: flex;
            gap: 0.75rem;
            align-items: flex-end;
        }

        .btn {
            padding: 0.625rem 1.25rem;
            border: none;
            border-radius: var(--radius-md);
            font-size: 0.9rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            font-family: var(--font-sans);
        }

        .btn-primary { background: var(--primary); color: white; }
        .btn-primary:hover { background: var(--primary-light); }
        .btn-secondary { background: var(--gray-100); color: var(--gray-700); border: 1px solid var(--gray-300); }
        .btn-secondary:hover { background: var(--gray-200); }

        .table-wrapper {
            background: white;
            border-radius: var(--radius-xl);
            border: 1px solid var(--gray-200);
            overflow: hidden;
            box-shadow: var(--shadow-sm);
        }

        .table-responsive { overflow-x: auto; -webkit-overflow-scrolling: touch; }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.9rem;
            min-width: 700px;
        }

        th {
            background: var(--gray-50);
            padding: 1rem 1rem;
            text-align: left;
            font-weight: 600;
            color: var(--gray-600);
            font-size: 0.85rem;
            border-bottom: 1px solid var(--gray-200);
            white-space: nowrap;
        }

        td {
            padding: 0.875rem 1rem;
            border-bottom: 1px solid var(--gray-100);
            color: var(--gray-700);
            vertical-align: middle;
        }

        tr:hover { background: var(--gray-50); }
        tr:last-child td { border-bottom: none; }

        .badge {
            display: inline-block;
            padding: 0.25rem 0.625rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 500;
            background: var(--gray-100);
            color: var(--gray-600);
        }

        .serial-code {
            font-family: 'Courier New', monospace;
            font-size: 0.85rem;
            background: var(--gray-50);
            padding: 0.25rem 0.5rem;
            border-radius: var(--radius-sm);
            display: inline-block;
        }

        .branch-kimathi { color: #059669; font-weight: 500; }
        .branch-moi { color: #3b82f6; font-weight: 500; }

        .price {
            font-weight: 600;
            color: #059669;
        }

        .action-links {
            display: flex;
            gap: 0.75rem;
            flex-wrap: wrap;
        }

        .action-link {
            color: var(--primary);
            text-decoration: none;
            font-size: 0.85rem;
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
        }
        .action-link:hover { text-decoration: underline; }

        .empty-state {
            text-align: center;
            padding: 3rem;
            color: var(--gray-500);
        }
        .empty-state i { font-size: 3rem; margin-bottom: 1rem; opacity: 0.5; }

        .footer {
            text-align: center;
            padding: 1.5rem 0 0.5rem;
            margin-top: 1.5rem;
            font-size: 0.85rem;
            color: var(--gray-400);
            border-top: 1px solid var(--gray-200);
        }

        .pagination-bar{display:flex;justify-content:space-between;align-items:center;gap:1rem;flex-wrap:wrap;padding:1rem 1.25rem;border-top:1px solid var(--gray-200);background:#fff}
        .pagination-controls{display:flex;align-items:center;gap:.4rem;flex-wrap:wrap}
        .pagination-controls a,.pagination-controls span{padding:.45rem .7rem;border:1px solid var(--gray-300);border-radius:var(--radius-md);text-decoration:none;color:var(--gray-600);background:#fff;font-size:.85rem}
        .pagination-controls .active{background:var(--primary);color:#fff;border-color:var(--primary)}
        .pagination-controls .disabled{opacity:.45;pointer-events:none}
        .per-page-form{display:flex;align-items:center;gap:.5rem;font-size:.85rem;color:var(--gray-600)}
        .per-page-form select{padding:.45rem .65rem;border:1px solid var(--gray-300);border-radius:var(--radius-md);background:#fff}


        .btn-sale { background:#166534; color:#fff; border:0; border-radius:var(--radius-sm); padding:.4rem .65rem; font-size:.75rem; font-weight:600; cursor:pointer; display:inline-flex; align-items:center; gap:.35rem; white-space:nowrap; }
        .btn-sale:hover { background:#14532d; }
        .alert { padding:1rem 1.25rem; border-radius:var(--radius-md); margin-bottom:1rem; display:flex; align-items:center; gap:.65rem; }
        .alert-success { background:#ecfdf5; border:1px solid #a7f3d0; color:#065f46; }
        .alert-error { background:#fef2f2; border:1px solid #fecaca; color:#991b1b; }
        .sale-modal { position:fixed; inset:0; background:rgba(15,23,42,.58); display:none; align-items:center; justify-content:center; z-index:9999; padding:1rem; }
        .sale-modal.open { display:flex; }
        .sale-modal-dialog { width:min(520px,100%); max-height:92vh; overflow-y:auto; background:#fff; border-radius:14px; box-shadow:0 24px 60px rgba(0,0,0,.22); }
        .sale-modal-header { padding:1.15rem 1.25rem; display:flex; justify-content:space-between; align-items:center; border-bottom:1px solid var(--gray-200); }
        .sale-modal-header h3 { margin:0; font-size:1.05rem; }
        .modal-close { border:0; background:transparent; color:var(--gray-500); cursor:pointer; font-size:1.1rem; }
        .sale-modal-body { padding:1.25rem; }
        .sale-accessory-label { margin-bottom:1rem; padding:.8rem .9rem; border-radius:8px; background:var(--gray-50); border:1px solid var(--gray-200); font-size:.85rem; }
        .sale-form-group { margin-bottom:1rem; }
        .sale-form-group label { display:block; margin-bottom:.4rem; font-size:.82rem; font-weight:600; color:var(--gray-600); }
        .sale-form-group input,.sale-form-group select { width:100%; padding:.7rem .8rem; border:1px solid var(--gray-300); border-radius:8px; background:#fff; font:inherit; }
        .modal-actions { display:flex; gap:.75rem; justify-content:flex-end; padding-top:.4rem; }
        .modal-actions .btn { width:auto; }

        @media (max-width: 1200px) {
            .main-content { margin-left: 0 !important; width: 100% !important; padding: 1.5rem 1rem 1rem !important; padding-top: 5rem !important; }
        }

        @media (max-width: 768px) {
            .main-content { padding: 1rem 0.75rem 0.75rem !important; padding-top: 4.5rem !important; }
            .page-header h1 { font-size: 1.25rem; }
            .page-header { padding: 1rem 1.25rem; }
            .stats-row { grid-template-columns: repeat(2, 1fr); gap: 0.75rem; }
            .stat-card { padding: 1rem; }
            .stat-card .stat-value { font-size: 1.5rem; }
            .search-section { padding: 1rem; }
            .search-grid { grid-template-columns: 1fr; }
            .btn { width: 100%; justify-content: center; }
            .action-links { flex-direction: column; }
            .table { min-width: 600px; }
        }

        @media (max-width: 480px) {
            .main-content { padding: 0.75rem 0.5rem 0.5rem !important; padding-top: 4rem !important; }
            .stats-row { grid-template-columns: 1fr; }
            .page-header h1 { font-size: 1.1rem; }
            .table { min-width: 500px; }
        }
    </style>
</head>
<body>
 <?php include "../includes/sidebar.php"; ?>
<div class="main-content">
    <div class="page-header">
        <h1><i class="fas fa-plug"></i> In‑Stock Accessories</h1>
        <div class="breadcrumb">
            <?php if ($_SESSION['role'] === 'super_admin'): ?>
                <a href="../dashboard/superadmindashboard"><i class="fas fa-home"></i> Dashboard</a>
            <?php elseif ($_SESSION['role'] === 'manager'): ?>
                <a href="../dashboard/managerdashboard"><i class="fas fa-home"></i> Dashboard</a>
            <?php elseif ($_SESSION['role'] === 'inventory_admin'): ?>
                <a href="../dashboard/inventorydashboard"><i class="fas fa-home"></i> Dashboard</a>
            <?php elseif ($_SESSION['role'] === 'sales'): ?>
                <a href="../dashboard/salesdashboard"><i class="fas fa-home"></i> Dashboard</a>
            <?php endif; ?>
            <span> / </span>
            <span>In‑Stock Accessories</span>
        </div>
    </div>

    <?php if ($flashSuccess): ?><div class="alert alert-success"><i class="fas fa-check-circle"></i><?= htmlspecialchars($flashSuccess) ?></div><?php endif; ?>
    <?php if ($flashError): ?><div class="alert alert-error"><i class="fas fa-exclamation-circle"></i><?= htmlspecialchars($flashError) ?></div><?php endif; ?>

    <!-- Stats Cards -->
    <div class="stats-row">
        <div class="stat-card">
            <div class="stat-icon"><i class="fas fa-boxes"></i></div>
            <div class="stat-value"><?= number_format($total_items) ?></div>
            <div class="stat-label">Total Items</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon"><i class="fas fa-cubes"></i></div>
            <div class="stat-value"><?= number_format($total_quantity) ?></div>
            <div class="stat-label">Total Units</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon"><i class="fas fa-store"></i></div>
            <div class="stat-value"><?= number_format(count($branches)) ?></div>
            <div class="stat-label">Branches</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon"><i class="fas fa-coins"></i></div>
            <div class="stat-value">KES <?= number_format($total_value, 0) ?></div>
            <div class="stat-label">Total Value</div>
        </div>
    </div>

    <!-- Search Section -->
    <div class="search-section">
        <div class="search-title"><i class="fas fa-filter"></i> Filter Accessories</div>
        <form method="GET" class="search-grid">
            <input type="hidden" name="per_page" value="<?= (int)$per_page ?>">

            <div class="search-group">
                <label>Accessory Type</label>
                <select name="type">
                    <option value="">-- All Types --</option>
                    <?php foreach ($types as $type): ?>
                        <option value="<?= htmlspecialchars((string)$type) ?>" <?= $search_type === (string)$type ? 'selected' : '' ?>>
                            <?= htmlspecialchars((string)$type) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="search-group">
                <label>Accessory Name</label>
                <input type="text" name="name" placeholder="Search by name..." value="<?= htmlspecialchars($search_name) ?>" autofocus>
            </div>

            <?php if ($role !== 'manager'): ?>
            <div class="search-group">
                <label>Branch</label>
                <select name="branch">
                    <option value="">-- All Branches --</option>
                    <?php foreach ($branches as $branchOption): ?>
                        <option value="<?= htmlspecialchars((string)$branchOption) ?>" <?= $search_branch === (string)$branchOption ? 'selected' : '' ?>>
                            <?= htmlspecialchars((string)$branchOption) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <?php endif; ?>

            <div class="search-group">
                <label>Place</label>
                <select name="place">
                    <option value="">-- All Places --</option>
                    <?php foreach ($places as $placeOption): ?>
                        <option value="<?= htmlspecialchars((string)$placeOption) ?>" <?= $search_place === (string)$placeOption ? 'selected' : '' ?>>
                            <?= htmlspecialchars(ucfirst((string)$placeOption)) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="search-actions">
                <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Search</button>
                <a href="accessory_instock.php" class="btn btn-secondary"><i class="fas fa-undo"></i> Reset</a>
            </div>
        </form>
    </div>

    <!-- Accessories Table -->
    <div class="table-wrapper">
        <div class="table-responsive">
            <?php if (empty($accessories)): ?>
                <div class="empty-state">
                    <i class="fas fa-box-open"></i>
                    <p>No in‑stock accessories found matching your criteria.</p>
                    <a href="accessory_instock.php" class="btn btn-primary" style="margin-top: 1rem;">
                        <i class="fas fa-undo"></i> Clear Filters
                    </a>
                </div>
            <?php else: ?>
                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Accessory Type</th>
                            <th>Name</th>
                            <th>Quantity</th>
                            <th>Branch</th>
                            <th>Place</th>
                    
                            <th>Price (KES)</th>
                            <th>Total Value (KES)</th>
                    
                            <th>Date Added</th>
                            <th>Added By</th>
                            <th>Updated By</th> 
                            <th>Date Updated</th> 
                        <?php if (in_array($role, ['super_admin', 'manager', 'inventory_admin'])): ?>
                            <th>Actions</th>
                        <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = $offset + 1; foreach ($accessories as $a): ?>
                            <tr>
                                <td><?= $i++ ?></td>
                                <td><strong><?= htmlspecialchars($a['type'] ?? 'N/A') ?></strong></td>
                                <td><strong><?= htmlspecialchars($a['name']) ?></strong></td>
                                <td><span class="badge"><?= (int)$a['quantity'] ?></span></td>
                                <td>
                                    <span class="<?= $a['branch'] == 'KIMATHI' ? 'branch-kimathi' : 'branch-moi' ?>">
                                        <?= htmlspecialchars($a['branch']) ?>
                                    </span>
                                </td>
                                <td><span class="badge"><?= htmlspecialchars(ucfirst($a['place'])) ?></span></td>
                                <td class="price"><?= $a['price'] !== null ? 'KES '.number_format($a['price'], 2) : '-' ?></td>
                                <td class="price"><?= $a['price'] !== null && $a['quantity'] > 0 ? 'KES '.number_format($a['quantity'] * $a['price'], 2) : '-' ?></td>
                                <td><small><?= date('M j, Y g:i A', strtotime($a['date_added'])) ?></small></td>
                                <td><?= htmlspecialchars($a['added_by_name'] ?? 'N/A') ?></td>
                                <td><?= htmlspecialchars($a['updated_by_name'] ?? '-') ?></td>   <!-- NEW CELL -->
                                <td><small><?= $a['updated_at'] ? date('M j, Y g:i A', strtotime($a['updated_at'])) : 'Not updated yet' ?></small></td>
                                <td>
                                    <?php if (in_array($role, ['super_admin', 'manager', 'inventory_admin'])): ?>
                                                
                                        <div class="action-links">
                                            <?php if ($a['price'] === null): ?>
                                                <a href="add_price_accessory?id=<?= urlencode($a['id']) ?>" class="action-link">
                                                    <i class="fas fa-tag"></i> Add Price
                                                </a>
                                            <?php else: ?>
                                                <a href="update_price_accessory?id=<?= urlencode($a['id']) ?>" class="action-link">
                                                    <i class="fas fa-edit"></i> Update Price
                                                </a>
                                            <?php endif; ?>
                                            <button type="button" class="btn-sale open-sale-modal"
                                                    data-id="<?= (int)$a['id'] ?>"
                                                    data-name="<?= htmlspecialchars($a['name'], ENT_QUOTES, 'UTF-8') ?>"
                                                    data-quantity="<?= (int)$a['quantity'] ?>"
                                                    data-price="<?= $a['price'] !== null ? htmlspecialchars((string)$a['price'], ENT_QUOTES, 'UTF-8') : '' ?>">
                                                <i class="fas fa-cash-register"></i> Update Sale Details
                                            </button>
                                        </div>
                                    
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>

        <?php if ($total_items > 0): ?>
        <div class="pagination-bar">
            <form method="GET" class="per-page-form">
                <?php foreach ($_GET as $key => $value): ?>
                    <?php if ($key !== 'per_page' && $key !== 'page' && !is_array($value)): ?>
                        <input type="hidden" name="<?= htmlspecialchars((string)$key) ?>" value="<?= htmlspecialchars((string)$value) ?>">
                    <?php endif; ?>
                <?php endforeach; ?>
                <label for="accessoryPerPage">Show</label>
                <select id="accessoryPerPage" name="per_page" onchange="this.form.submit()">
                    <?php foreach ($allowed_per_page as $size): ?>
                        <option value="<?= $size ?>" <?= $per_page === $size ? 'selected' : '' ?>><?= $size ?></option>
                    <?php endforeach; ?>
                </select>
                <span>per page</span>
            </form>

            <div class="pagination-controls">
                <?php if ($page > 1): ?>
                    <a href="<?= htmlspecialchars(accessoryPageUrl($page - 1)) ?>">Previous</a>
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
                        <a href="<?= htmlspecialchars(accessoryPageUrl($p)) ?>"><?= $p ?></a>
                    <?php endif; ?>
                <?php endfor; ?>

                <?php if ($page < $total_pages): ?>
                    <a href="<?= htmlspecialchars(accessoryPageUrl($page + 1)) ?>">Next</a>
                <?php else: ?>
                    <span class="disabled">Next</span>
                <?php endif; ?>
            </div>
        </div>
        <?php endif; ?>
    </div>


    <div class="sale-modal" id="saleDetailsModal" aria-hidden="true">
        <div class="sale-modal-dialog">
            <div class="sale-modal-header">
                <h3><i class="fas fa-cash-register"></i> Update Accessory Sale Details</h3>
                <button type="button" class="modal-close" id="closeSaleModal"><i class="fas fa-times"></i></button>
            </div>
            <div class="sale-modal-body">
                <div class="sale-accessory-label"><strong id="saleAccessoryName">-</strong><br>Available Quantity: <strong id="saleAvailableQty">0</strong></div>
                <form method="POST" id="saleDetailsForm">
                    <input type="hidden" name="update_sale_details" value="1">
                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['accessory_sale_csrf']) ?>">
                    <input type="hidden" name="accessory_id" id="saleAccessoryId">
                    <div class="sale-form-group"><label>Sales Person</label><select name="sales_person" required><option value="">-- Select Sales Person --</option><?php foreach ($salesPeople as $sp): ?><option value="<?= (int)$sp['id'] ?>"><?= htmlspecialchars($sp['full_name']) ?></option><?php endforeach; ?></select></div>
                    <div class="sale-form-group"><label for="quantity_sold">Quantity Sold</label><input type="number" name="quantity_sold" id="quantity_sold" min="1" step="1" required></div>
                    <div class="sale-form-group"><label for="selling_price">Selling Price per Unit (KES)</label><input type="number" name="selling_price" id="selling_price" min="0.01" step="0.01" required placeholder="Enter actual unit selling price"></div>
                    <div class="sale-form-group"><label for="sold_at">Date Sold <span style="font-weight:400;color:var(--gray-500)">(Optional — current time if blank)</span></label><input type="datetime-local" name="sold_at" id="sold_at"></div>
                    <div class="sale-form-group"><label for="payment_status">Payment Status</label><select name="payment_status" id="payment_status" required><option value="">-- Select --</option><option value="paid">Paid</option><option value="unpaid">Unpaid</option></select></div>
                    <div class="sale-form-group"><label for="payment_method">Payment Method <span style="font-weight:400;color:var(--gray-500)">(Optional)</span></label><select name="payment_method" id="payment_method"><option value="">-- Not specified --</option><option value="cash">Cash</option><option value="mpesa-till">M-Pesa Till</option><option value="mpesa-pochi">M-Pesa Pochi</option><option value="bank-transfer">Bank Transfer</option></select></div>
                    <div class="modal-actions"><button type="button" class="btn btn-secondary" id="cancelSaleModal">Cancel</button><button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Save Sale Details</button></div>
                </form>
            </div>
        </div>
    </div>

    <div class="footer">
        <i class="fas fa-copyright"></i> <?= date('Y'); ?> Mombasa Computers
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {

    const saleModal = document.getElementById('saleDetailsModal');
    const saleForm = document.getElementById('saleDetailsForm');
    const accessoryIdInput = document.getElementById('saleAccessoryId');
    const accessoryName = document.getElementById('saleAccessoryName');
    const availableQty = document.getElementById('saleAvailableQty');
    const quantityInput = document.getElementById('quantity_sold');
    const sellingPriceInput = document.getElementById('selling_price');

    function openAccessorySaleModal(button) {
        const qty = parseInt(button.dataset.quantity || '0', 10);
        accessoryIdInput.value = button.dataset.id || '';
        accessoryName.textContent = button.dataset.name || '-';
        availableQty.textContent = qty;
        quantityInput.max = qty;
        quantityInput.value = qty > 0 ? 1 : '';
        sellingPriceInput.value = button.dataset.price || '';
        saleModal.classList.add('open');
        saleModal.setAttribute('aria-hidden', 'false');
        document.body.style.overflow = 'hidden';
    }
    function closeAccessorySaleModal() {
        saleModal.classList.remove('open');
        saleModal.setAttribute('aria-hidden', 'true');
        document.body.style.overflow = '';
        saleForm.reset();
        accessoryIdInput.value = '';
    }
    document.querySelectorAll('.open-sale-modal').forEach(btn => btn.addEventListener('click', () => openAccessorySaleModal(btn)));
    document.getElementById('closeSaleModal')?.addEventListener('click', closeAccessorySaleModal);
    document.getElementById('cancelSaleModal')?.addEventListener('click', closeAccessorySaleModal);
    saleModal?.addEventListener('click', e => { if (e.target === saleModal) closeAccessorySaleModal(); });
    document.addEventListener('keydown', e => { if (e.key === 'Escape' && saleModal?.classList.contains('open')) closeAccessorySaleModal(); });

    function adjustMainContent() {
        const mainContent = document.querySelector('.main-content');
        const sidebar = document.querySelector('.sidebar');
        if (window.innerWidth <= 1200) {
            if (mainContent) {
                mainContent.style.marginLeft = '0';
                mainContent.style.width = '100%';
                mainContent.style.paddingTop = '5rem';
            }
        } else {
            if (mainContent && sidebar) {
                mainContent.style.marginLeft = '260px';
                mainContent.style.width = 'calc(100% - 260px)';
                mainContent.style.paddingTop = '';
            }
        }
    }
    adjustMainContent();
    window.addEventListener('resize', adjustMainContent);
    window.addEventListener('orientationchange', adjustMainContent);
});
</script>

</body>
</html>