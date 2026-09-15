<?php
session_start();
require_once "../config/db.php";
require_once "../includes/auth_check.php";

$role = $_SESSION['role'];
$user_id = $_SESSION['user_id'];

if (!in_array($_SESSION['role'], ['super_admin', 'inventory_admin', 'manager'])) {
    die("Access denied!");
}

// Helper: build device specifications string (like sales_logs)
function buildDeviceSpecs($device) {

    $specs = "";

    if (!empty($device['model_name'])) {
        $specs .= $device['model_name'];
    }

    if (!empty($device['processor'])) {
        $specs .= " | " . $device['processor'];
    }

    if (!empty($device['ram'])) {
        $specs .= " | " . $device['ram'] . "GB RAM";
    }

    if (!empty($device['storage_type']) && !empty($device['storage_capacity'])) {

        if (!empty($device['secondary_storage_type']) && !empty($device['secondary_storage_capacity'])) {
            $specs .= " | " . $device['storage_type'] . " " . $device['storage_capacity'] . "GB"
                    . " + " . $device['secondary_storage_type'] . " " . $device['secondary_storage_capacity'] . "GB";
        } else {
            $specs .= " | " . $device['storage_type'] . " " . $device['storage_capacity'] . "GB";
        }

    }

    if (isset($device['graphics']) && $device['graphics'] !== '' && $device['graphics'] !== 'None') {
        $specs .= " | " . $device['graphics'];
    }

    if (isset($device['touch']) && $device['touch'] !== 'N/A' && $device['touch'] !== '') {
        $specs .= " | " . $device['touch'];
    }

    return trim($specs, " |");
}

// Get manager's branch from database
if ($role === 'manager') {
    $user_stmt = $conn->prepare("SELECT branch FROM users WHERE id = ?");
    $user_stmt->execute([$user_id]);
    $user_data = $user_stmt->fetch(PDO::FETCH_ASSOC);
    $user_branch = $user_data['branch'] ?? '';
}

$search_serial = trim($_GET['serial_number'] ?? '');
$search_category = trim($_GET['category'] ?? '');
$search_model = trim($_GET['model'] ?? '');
$search_branch = trim($_GET['branch'] ?? '');
$search_place = trim($_GET['place'] ?? '');

// Pagination: default 100, selectable up to 500.
$allowedPerPage = [100, 200, 300, 400, 500];
$perPage = (int)($_GET['per_page'] ?? 100);
if (!in_array($perPage, $allowedPerPage, true)) {
    $perPage = 100;
}
$page = max(1, (int)($_GET['page'] ?? 1));

// Fetch categories for dropdown
$cat_stmt = $conn->prepare("SELECT * FROM categories ORDER BY category_name ASC");
$cat_stmt->execute();
$all_categories = $cat_stmt->fetchAll(PDO::FETCH_ASSOC);

// Build filters once so the count/stats query and paginated list always match.
$where = ['1=1'];
$params = [];

// Manager restriction - see only their branch
if ($role === 'manager' && !empty($user_branch)) {
    $where[] = "d.branch = :user_branch";
    $params['user_branch'] = $user_branch;
}

if ($search_category !== '') {
    $where[] = "d.category_id = :cat";
    $params['cat'] = $search_category;
}

if ($search_branch !== '' && $role !== 'manager') {
    $where[] = "d.branch = :branch";
    $params['branch'] = $search_branch;
}

if ($search_place !== '') {
    $where[] = "d.place = :place";
    $params['place'] = $search_place;
}

if ($search_model !== '') {
    $where[] = "d.model_name LIKE :model";
    $params['model'] = "%$search_model%";
}

// Prefix search keeps serial lookup fast and searches the full devices table before pagination.
if ($search_serial !== '') {
    $where[] = "d.serial_number LIKE :sn";
    $params['sn'] = $search_serial . '%';
}

$whereSql = implode(' AND ', $where);

// Full-result stats without loading every matching device into PHP memory.
$statsSql = "SELECT
                COUNT(*) AS total_devices,
                COALESCE(SUM(CASE WHEN d.status = 'In Stock' THEN 1 ELSE 0 END), 0) AS in_stock,
                COALESCE(SUM(CASE WHEN d.status = 'Sold' THEN 1 ELSE 0 END), 0) AS sold
             FROM devices d
             WHERE $whereSql";
$statsStmt = $conn->prepare($statsSql);
$statsStmt->execute($params);
$stats = $statsStmt->fetch(PDO::FETCH_ASSOC) ?: [];
$total_devices = (int)($stats['total_devices'] ?? 0);
$in_stock = (int)($stats['in_stock'] ?? 0);
$sold = (int)($stats['sold'] ?? 0);

$totalPages = max(1, (int)ceil($total_devices / $perPage));
if ($page > $totalPages) {
    $page = $totalPages;
}
$offset = ($page - 1) * $perPage;

// Fetch only the current page, preserving the existing order.
$sql = "SELECT d.*, c.category_name, u.full_name AS added_by_name
        FROM devices d
        JOIN categories c ON d.category_id = c.id
        LEFT JOIN users u ON d.added_by = u.id
        WHERE $whereSql
        ORDER BY d.date_added DESC
        LIMIT :limit OFFSET :offset";

$stmt = $conn->prepare($sql);
foreach ($params as $key => $value) {
    $stmt->bindValue(':' . $key, $value);
}
$stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$devices = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Device List | Mombasa Computers</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
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
            --gray-900: #111827;
            --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
            --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1);
            --radius-sm: 0.375rem;
            --radius-md: 0.5rem;
            --radius-lg: 0.75rem;
            --radius-xl: 1rem;
            --font-sans: 'Inter', system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }

        @import url('https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,400;14..32,500;14..32,600;14..32,700&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: var(--font-sans);
            background: var(--gray-100);
            color: var(--gray-800);
            line-height: 1.5;
            overflow-x: hidden;
        }

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

        .page-header h1 i {
            color: var(--primary);
            font-size: 1.75rem;
        }

        .breadcrumb {
            color: var(--gray-500);
            font-size: 0.9rem;
        }

        .breadcrumb a {
            color: var(--primary);
            text-decoration: none;
        }

        .breadcrumb a:hover {
            text-decoration: underline;
        }

        .stats-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
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

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        .stat-card .stat-icon {
            font-size: 1.75rem;
            color: var(--primary);
            margin-bottom: 0.5rem;
        }

        .stat-card .stat-value {
            font-size: 1.75rem;
            font-weight: 600;
            color: var(--gray-800);
        }

        .stat-card .stat-label {
            font-size: 0.85rem;
            color: var(--gray-500);
            margin-top: 0.25rem;
        }

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

        .search-group label {
            font-size: 0.85rem;
            font-weight: 500;
            color: var(--gray-600);
        }

        .search-group input,
        .search-group select {
            padding: 0.625rem 0.875rem;
            border: 1px solid var(--gray-300);
            border-radius: var(--radius-md);
            font-size: 0.9rem;
            transition: all 0.2s ease;
            font-family: var(--font-sans);
            background: white;
        }

        .search-group input:focus,
        .search-group select:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(26, 75, 42, 0.1);
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

        .btn-primary {
            background: var(--primary);
            color: white;
        }

        .btn-primary:hover {
            background: var(--primary-light);
        }

        .btn-secondary {
            background: var(--gray-100);
            color: var(--gray-700);
            border: 1px solid var(--gray-300);
        }

        .btn-secondary:hover {
            background: var(--gray-200);
        }

        .table-wrapper {
            background: white;
            border-radius: var(--radius-xl);
            border: 1px solid var(--gray-200);
            overflow: hidden;
            box-shadow: var(--shadow-sm);
        }

        .table-responsive {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.9rem;
            min-width: 900px;
        }

        th {
            background: var(--gray-50);
            padding: 1rem 1rem;
            text-align: left;
            font-weight: 600;
            color: var(--gray-600);
            font-size: 0.85rem;
            border-bottom: 1px solid var(--gray-200);
        }

        td {
            padding: 0.875rem 1rem;
            border-bottom: 1px solid var(--gray-100);
            color: var(--gray-700);
            vertical-align: middle;
        }

        tr:hover {
            background: var(--gray-50);
        }

        tr:last-child td {
            border-bottom: none;
        }

        .badge {
            display: inline-block;
            padding: 0.25rem 0.625rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 500;
            background: var(--gray-100);
            color: var(--gray-600);
        }

        .badge-place-display { background: #dbeafe; color: #1e40af; }
        .badge-place-store { background: #d1fae5; color: #065f46; }
        .badge-place-warehouse { background: #fed7aa; color: #92400e; }

        .status-instock {
            color: #059669;
        }

        .status-sold {
            color: var(--gray-500);
        }

        .serial-code {
            font-family: 'Courier New', monospace;
            font-size: 0.85rem;
            background: var(--gray-50);
            padding: 0.25rem 0.5rem;
            border-radius: var(--radius-sm);
            display: inline-block;
        }

        .branch-kimathi {
            color: #059669;
        }

        .branch-moi {
            color: #3b82f6;
        }

        .specs-text {
            font-size: 0.8rem;
            color: var(--gray-600);
            word-wrap: break-word;
            max-width: 350px;
            display: inline-block;
        }

        .action-btns {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
        }

        .btn-view {
            padding: 0.375rem 0.875rem;
            font-size: 0.8rem;
            background: white;
            color: var(--gray-700);
            border: 1px solid var(--gray-300);
            border-radius: var(--radius-sm);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.375rem;
            transition: all 0.2s ease;
        }

        .btn-view:hover {
            background: var(--gray-50);
            border-color: var(--gray-400);
        }

        .empty-state {
            text-align: center;
            padding: 3rem;
            color: var(--gray-500);
        }

        .empty-state i {
            font-size: 3rem;
            margin-bottom: 1rem;
            opacity: 0.5;
        }

        .pagination-controls {
            margin-top: 1rem;
            background: white;
            border: 1px solid var(--gray-200);
            border-radius: var(--radius-lg);
            padding: 0.85rem 1rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            flex-wrap: wrap;
            box-shadow: var(--shadow-sm);
        }
        .pagination-info { color: var(--gray-500); font-size: 0.85rem; }
        .per-page-control { display: flex; align-items: center; gap: 0.5rem; color: var(--gray-600); font-size: 0.85rem; }
        .per-page-control select { padding: 0.45rem 0.65rem; border: 1px solid var(--gray-300); border-radius: var(--radius-md); background: white; }
        .pagination-links { display: flex; align-items: center; gap: 0.35rem; flex-wrap: wrap; }
        .pagination-links a, .pagination-links span { min-width: 36px; padding: 0.45rem 0.65rem; border: 1px solid var(--gray-300); border-radius: var(--radius-md); text-align: center; text-decoration: none; color: var(--gray-700); background: white; font-size: 0.82rem; }
        .pagination-links a.active { background: var(--primary); color: white; border-color: var(--primary); }
        .pagination-links span.disabled { color: var(--gray-400); background: var(--gray-50); }

        .footer {
            text-align: center;
            padding: 1.5rem 0 0.5rem;
            margin-top: 1.5rem;
            font-size: 0.85rem;
            color: var(--gray-400);
            border-top: 1px solid var(--gray-200);
        }

        @media (max-width: 1200px) {
            .main-content {
                margin-left: 0 !important;
                width: 100% !important;
                padding: 1.5rem 1rem 1rem !important;
                padding-top: 5rem !important;
            }
        }

        @media (max-width: 768px) {
            .main-content {
                padding: 1rem 0.75rem 0.75rem !important;
                padding-top: 4.5rem !important;
            }

            .page-header h1 {
                font-size: 1.25rem;
            }

            .stats-row {
                grid-template-columns: repeat(2, 1fr);
                gap: 0.75rem;
            }

            .stat-card {
                padding: 1rem;
            }

            .stat-card .stat-value {
                font-size: 1.5rem;
            }

            .search-section {
                padding: 1rem;
            }

            .search-grid {
                grid-template-columns: 1fr;
            }

            .btn {
                width: 100%;
                justify-content: center;
            }

            .action-btns {
                flex-direction: column;
            }

            .btn-view {
                width: 100%;
                justify-content: center;
            }

            .specs-text {
                max-width: 150px;
            }
        }

        @media (max-width: 480px) {
            .main-content {
                padding: 0.75rem 0.5rem 0.5rem !important;
                padding-top: 4rem !important;
            }

            .stats-row {
                grid-template-columns: 1fr;
            }

            .page-header h1 {
                font-size: 1.1rem;
            }
        }
    </style>
</head>
<body>
<?php include "../includes/sidebar.php"; ?>
<div class="main-content">
    <!-- Page Header -->
    <div class="page-header">
        <h1>
            <i class="fas fa-list"></i>
            Device List
        </h1>
        <div class="breadcrumb">
            <?php if($_SESSION['role'] === 'super_admin'): ?>
                <a href="../dashboard/superadmindashboard"><i class="fas fa-home"></i> Dashboard</a>       
            <?php endif; ?>
            <?php if($_SESSION['role'] === 'manager'): ?>
                <a href="../dashboard/managerdashboard"><i class="fas fa-home"></i> Dashboard</a>
            <?php endif; ?>
            <?php if($_SESSION['role'] === 'inventory_admin'): ?>
                <a href="../dashboard/inventorydashboard"><i class="fas fa-home"></i> Dashboard</a>
            <?php endif; ?>
            <?php if($_SESSION['role'] === 'sales'): ?>
                <a href="../dashboard/salesdashboard"><i class="fas fa-home"></i> Dashboard</a>
            <?php endif; ?>
            <span> / </span>
            <span>Device List</span>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="stats-row">
        <div class="stat-card">
            <div class="stat-icon"><i class="fas fa-laptop"></i></div>
            <div class="stat-value"><?= number_format($total_devices) ?></div>
            <div class="stat-label">Total Devices</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon"><i class="fas fa-box"></i></div>
            <div class="stat-value"><?= number_format($in_stock) ?></div>
            <div class="stat-label">In Stock</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon"><i class="fas fa-tag"></i></div>
            <div class="stat-value"><?= number_format($sold) ?></div>
            <div class="stat-label">Sold</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon"><i class="fas fa-qrcode"></i></div>
            <div class="stat-value"><?= number_format(count($all_categories)) ?></div>
            <div class="stat-label">Categories</div>
        </div>
    </div>

    <!-- Search Section -->
    <div class="search-section">
        <div class="search-title">
            <i class="fas fa-filter"></i> Filter Devices
        </div>
        <form method="GET" class="search-grid" id="deviceListFilterForm">
            <input type="hidden" name="per_page" value="<?= $perPage ?>">
            <div class="search-group">
                <label>Category</label>
                <select name="category">
                    <option value="">-- All Categories --</option>
                    <?php foreach($all_categories as $cat): ?>
                        <option value="<?= $cat['id'] ?>" <?= $search_category == $cat['id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($cat['category_name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <?php if ($role !== 'manager'): ?>
            <div class="search-group">
                <label>Branch</label>
                <select name="branch">
                    <option value="">-- All Branches --</option>
                    <option value="KIMATHI" <?= $search_branch == 'KIMATHI' ? 'selected' : '' ?>>KIMATHI</option>
                    <option value="MOI" <?= $search_branch == 'MOI' ? 'selected' : '' ?>>MOI</option>
                </select>
            </div>
            <?php endif; ?>

            <div class="search-group">
                <label>Place</label>
                <select name="place">
                    <option value="">-- All Places --</option>
                    <option value="display" <?= $search_place == 'display' ? 'selected' : '' ?>>Display</option>
                    <option value="store" <?= $search_place == 'store' ? 'selected' : '' ?>>Store</option>
                    <option value="warehouse" <?= $search_place == 'warehouse' ? 'selected' : '' ?>>Warehouse</option>
                </select>
            </div>

            <div class="search-group">
                <label>Model</label>
                <input type="text" name="model" placeholder="Search by model..." value="<?= htmlspecialchars($search_model) ?>">
            </div>

            <div class="search-group">
                <label>Serial Number</label>
                <input type="text" name="serial_number" id="deviceListSerialSearch" placeholder="Scan or type serial number" value="<?= htmlspecialchars($search_serial) ?>" autocomplete="off" autofocus>
            </div>

            <div class="search-actions">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-search"></i> Search
                </button>
                <a href="device_list" class="btn btn-secondary">
                    <i class="fas fa-undo"></i> Reset
                </a>
            </div>
        </form>
    </div>

    <!-- Devices Table -->
    <div class="table-wrapper">
        <div class="table-responsive">
            <?php if(empty($devices)): ?>
                <div class="empty-state">
                    <i class="fas fa-search"></i>
                    <p>No devices found matching your criteria.</p>
                    <a href="device_list" class="btn btn-primary" style="margin-top: 1rem;">
                        <i class="fas fa-undo"></i> Clear Filters
                    </a>
                </div>
            <?php else: ?>
                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Serial Number</th>
                            <th>Category</th>
                            <th>Model</th>
                            <th>Specifications</th>
                            <th>Place</th>
                            <th>Added By</th>
                            <th>Price (KES)</th>
                            <th>Branch</th>
                            <th>Status</th>
                            <th>Date Added</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php $i = $offset + 1; foreach ($devices as $d): 
                        $specs = buildDeviceSpecs($d);
                        $placeClass = '';
                        if ($d['place'] == 'display') $placeClass = 'badge-place-display';
                        elseif ($d['place'] == 'store') $placeClass = 'badge-place-store';
                        elseif ($d['place'] == 'warehouse') $placeClass = 'badge-place-warehouse';
                    ?>
                        <tr>
                            <td><?= $i++ ?></td>
                            <td><span class="serial-code"><?= htmlspecialchars($d['serial_number']) ?></span></td>
                            <td><span class="badge"><?= htmlspecialchars($d['category_name']) ?></span></td>
                            <td><strong><?= htmlspecialchars($d['model_name']) ?></strong></td>
                            <td>
                                <span class="specs-text" title="<?= htmlspecialchars($specs) ?>">
                                    <?= htmlspecialchars($specs ?: '-') ?>
                                </span>
                            </td>
                            <td>
                                <span class="badge <?= $placeClass ?>">
                                    <?= ucfirst($d['place'] ?? 'N/A') ?>
                                </span>
                            </td>
                            <td><?= htmlspecialchars($d['added_by_name'] ?? 'System') ?></td>
                            <td><?= $d['price'] !== null ? number_format($d['price'], 2) : '—' ?></td>
                            <td>
                                <span class="<?= $d['branch'] == 'KIMATHI' ? 'branch-kimathi' : 'branch-moi' ?>">
                                    <?= htmlspecialchars($d['branch']) ?>
                                </span>
                            </td>
                            <td>
                                <span class="<?= $d['status'] == 'In Stock' ? 'status-instock' : 'status-sold' ?>">
                                    <?= htmlspecialchars($d['status']) ?>
                                </span>
                            </td>
                            <td><small><?= date('M j, Y', strtotime($d['date_added'])) ?></small></td>
                            <td>
                                <div class="action-btns">
                                    <a class="btn-view" href="view_device?sn=<?= urlencode($d['serial_number']) ?>">
                                        <i class="fas fa-eye"></i> View
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>

    <div class="pagination-controls">
        <div class="pagination-info">
            <?php if ($total_devices > 0): ?>
                Showing <?= number_format($offset + 1) ?>-<?= number_format(min($offset + $perPage, $total_devices)) ?> of <?= number_format($total_devices) ?>
            <?php else: ?>
                Showing 0 devices
            <?php endif; ?>
        </div>
        <div class="per-page-control">
            <label for="deviceListPerPage">Rows</label>
            <select id="deviceListPerPage" onchange="changeDeviceListPerPage(this.value)">
                <?php foreach ($allowedPerPage as $size): ?>
                    <option value="<?= $size ?>" <?= $perPage === $size ? 'selected' : '' ?>><?= $size ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="pagination-links">
            <?php
            $baseQuery = $_GET;
            $baseQuery['per_page'] = $perPage;
            $startPage = max(1, $page - 2);
            $endPage = min($totalPages, $page + 2);
            ?>
            <?php if ($page > 1): $baseQuery['page'] = $page - 1; ?>
                <a href="?<?= htmlspecialchars(http_build_query($baseQuery)) ?>">Previous</a>
            <?php else: ?>
                <span class="disabled">Previous</span>
            <?php endif; ?>

            <?php for ($p = $startPage; $p <= $endPage; $p++): $baseQuery['page'] = $p; ?>
                <a class="<?= $p === $page ? 'active' : '' ?>" href="?<?= htmlspecialchars(http_build_query($baseQuery)) ?>"><?= $p ?></a>
            <?php endfor; ?>

            <?php if ($page < $totalPages): $baseQuery['page'] = $page + 1; ?>
                <a href="?<?= htmlspecialchars(http_build_query($baseQuery)) ?>">Next</a>
            <?php else: ?>
                <span class="disabled">Next</span>
            <?php endif; ?>
        </div>
    </div>

    <div class="footer">
        <i class="fas fa-copyright"></i> <?= date('Y'); ?> Mombasa Computers
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
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


<script>
function changeDeviceListPerPage(value) {
    const url = new URL(window.location.href);
    url.searchParams.set('per_page', value);
    url.searchParams.set('page', '1');
    window.location.href = url.toString();
}

(function(){
    const form = document.getElementById('deviceListFilterForm');
    const serialInput = document.getElementById('deviceListSerialSearch');
    if (!form || !serialInput) return;

    let timer = null;
    let controller = null;

    async function ajaxSerialSearch() {
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
            const newPagination = doc.querySelector('.pagination-controls');
            const stats = document.querySelector('.stats-row');
            const table = document.querySelector('.table-wrapper');
            const pagination = document.querySelector('.pagination-controls');
            if (newStats && stats) stats.innerHTML = newStats.innerHTML;
            if (newTable && table) table.innerHTML = newTable.innerHTML;
            if (newPagination && pagination) pagination.innerHTML = newPagination.innerHTML;
            history.replaceState(null, '', url + '?' + params.toString());
        } catch (e) {
            if (e.name !== 'AbortError') console.error(e);
        }
    }

    serialInput.addEventListener('input', function(){
        clearTimeout(timer);
        const value = this.value.trim();
        if (value.length === 1) return;
        timer = setTimeout(ajaxSerialSearch, 250);
    });
})();
</script>

</body>
</html>