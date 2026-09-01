<?php
session_start();
require_once "../config/db.php";
require_once "../includes/auth_check.php";

// Fetch inventory items efficiently using SQL-side filtering and pagination.
function buildInventoryUnion($filters, &$params) {
    $sources = [
        [
            'category' => 'Device',
            'sql' => "SELECT d.model_name AS item_name, 'Device' AS category,
                           d.branch, d.date_added, d.serial_number AS ref_id,
                           'device' AS source, d.added_by, u.full_name AS added_by_name,
                           d.status,
                           CONCAT(
                               d.processor, ' | ',
                               d.ram, 'GB RAM | ',
                               d.storage_type, ' ', d.storage_capacity, 'GB',
                               IFNULL(CONCAT(' | ', d.graphics), ''),
                               IF(c.category_name IN ('Laptop', 'AIO', 'POS'), CONCAT(' | ', d.touch), '')
                           ) AS specs
                    FROM devices d
                    LEFT JOIN users u ON d.added_by = u.id
                    LEFT JOIN categories c ON d.category_id = c.id"
        ],
        [
            'category' => 'Monitor',
            'sql' => "SELECT m.model_name AS item_name, 'Monitor' AS category,
                           m.branch, m.date_added, m.serial_number AS ref_id,
                           'monitor' AS source, m.added_by, u.full_name AS added_by_name,
                           m.status,
                           CONCAT(m.size_inches, ' inch') AS specs
                    FROM monitors m
                    LEFT JOIN users u ON m.added_by = u.id"
        ],
        [
            'category' => 'Printer',
            'sql' => "SELECT p.model_name AS item_name, 'Printer' AS category,
                           p.branch, p.date_added, p.serial_number AS ref_id,
                           'printer' AS source, p.added_by, u.full_name AS added_by_name,
                           p.status,
                           'N/A' AS specs
                    FROM printers p
                    LEFT JOIN users u ON p.added_by = u.id"
        ],
        [
            'category' => 'Smartboard',
            'sql' => "SELECT s.model AS item_name, 'Smartboard' AS category,
                           s.branch, s.date_added, s.serial_number AS ref_id,
                           'smartboard' AS source, s.added_by, u.full_name AS added_by_name,
                           s.status,
                           CONCAT(s.model, ' | ', s.size_inches, ' inch') AS specs
                    FROM smartboards s
                    LEFT JOIN users u ON s.added_by = u.id"
        ],
        [
            'category' => 'Phone',
            'sql' => "SELECT CONCAT(COALESCE(p.brand,''), ' ', COALESCE(p.model,'')) AS item_name,
                           'Phone' AS category,
                           p.branch, p.date_added, p.serial_number AS ref_id,
                           'phone' AS source, p.added_by, u.full_name AS added_by_name,
                           p.status,
                           CONCAT(COALESCE(p.brand,''), ' ', COALESCE(p.model,''), ' | ',
                                  p.ram, 'GB RAM | ', p.storage_capacity, 'GB') AS specs
                    FROM phones p
                    LEFT JOIN users u ON p.added_by = u.id"
        ],
        [
            'category' => 'UPS',
            'sql' => "SELECT ups.model AS item_name, 'UPS' AS category,
                           ups.branch, ups.date_added, ups.serial_number AS ref_id,
                           'ups' AS source, ups.added_by, usr.full_name AS added_by_name,
                           ups.status,
                           CONCAT(ups.model, ' | ', ups.capacity, ' VA') AS specs
                    FROM ups ups
                    LEFT JOIN users usr ON ups.added_by = usr.id"
        ],
        [
            'category' => 'Accessory',
            'sql' => "SELECT a.name AS item_name, 'Accessory' AS category,
                           a.branch, a.date_added, CAST(a.id AS CHAR) AS ref_id,
                           'accessory' AS source, a.added_by, u.full_name AS added_by_name,
                           a.status,
                           CONCAT('Qty: ', a.quantity, ' | ', COALESCE(a.price, 'No price')) AS specs
                    FROM accessories a
                    LEFT JOIN users u ON a.added_by = u.id"
        ],
        [
            'category' => 'Charger',
            'sql' => "SELECT c.charger_type AS item_name, 'Charger' AS category,
                           c.branch, c.date_updated AS date_added, CAST(c.id AS CHAR) AS ref_id,
                           'charger' AS source, c.updated_by AS added_by, u.full_name AS added_by_name,
                           IF(c.quantity > 0, 'In Stock', 'Out of Stock') AS status,
                           CONCAT(c.charger_condition, ' | Qty: ', c.quantity) AS specs
                    FROM chargers c
                    LEFT JOIN users u ON c.updated_by = u.id"
        ],
        [
            'category' => 'HDD',
            'sql' => "SELECT CONCAT(h.type, ' ', h.storage) AS item_name, 'HDD' AS category,
                           h.branch, h.date_added, CAST(h.id AS CHAR) AS ref_id,
                           'hdd' AS source, h.added_by, u.full_name AS added_by_name,
                           IF(h.quantity > 0, 'In Stock', 'Out of Stock') AS status,
                           CONCAT('Qty: ', h.quantity, ' | ', COALESCE(h.price, 'No price')) AS specs
                    FROM hdds h
                    LEFT JOIN users u ON h.added_by = u.id"
        ],
        [
            'category' => 'RAM/SSD',
            'sql' => "SELECT CONCAT(r.category, ' ', r.type, ' ', r.storage, 'GB') AS item_name,
                           'RAM/SSD' AS category,
                           r.branch, r.date_added, CAST(r.id AS CHAR) AS ref_id,
                           'ram_ssd' AS source, r.added_by, u.full_name AS added_by_name,
                           IF(r.quantity > 0, 'In Stock', 'Out of Stock') AS status,
                           CONCAT('Qty: ', r.quantity, ' | ', COALESCE(r.price, 'No price')) AS specs
                    FROM rams_ssds r
                    LEFT JOIN users u ON r.added_by = u.id"
        ],
        [
            'category' => 'Graphics Card',
            'sql' => "SELECT CONCAT(g.type, ' ', g.storage_capacity, 'GB') AS item_name,
                           'Graphics Card' AS category,
                           g.branch, g.date_added, CAST(g.id AS CHAR) AS ref_id,
                           'graphic' AS source, g.added_by, u.full_name AS added_by_name,
                           g.status,
                           CONCAT('Qty: ', g.quantity, ' | ', COALESCE(g.price, 'No price')) AS specs
                    FROM graphic_cards g
                    LEFT JOIN users u ON g.added_by = u.id"
        ]
    ];

    $parts = [];
    $sourceIndex = 0;

    foreach ($sources as $source) {
        if (!empty($filters['category']) && strcasecmp($filters['category'], $source['category']) !== 0) {
            continue;
        }

        $sourceIndex++;
        $where = [];
        $localParams = [];

        if (!empty($filters['branch'])) {
            $key = "branch_{$sourceIndex}";
            $where[] = "src.branch = :{$key}";
            $localParams[$key] = $filters['branch'];
        }

        if (!empty($filters['added_by'])) {
            $key = "added_by_{$sourceIndex}";
            $where[] = "src.added_by = :{$key}";
            $localParams[$key] = (int)$filters['added_by'];
        }

        if (!empty($filters['start_date'])) {
            $key = "start_date_{$sourceIndex}";
            $where[] = "src.date_added >= :{$key}";
            $localParams[$key] = $filters['start_date'] . ' 00:00:00';
        }

        if (!empty($filters['end_date'])) {
            $key = "end_date_{$sourceIndex}";
            $where[] = "src.date_added <= :{$key}";
            $localParams[$key] = $filters['end_date'] . ' 23:59:59';
        }

        if (!empty($filters['status'])) {
            $key = "status_{$sourceIndex}";
            $where[] = "(
                CASE
                    WHEN LOWER(src.status) IN ('in stock','instock') THEN 'In Stock'
                    WHEN LOWER(src.status) = 'sold' THEN 'Sold'
                    WHEN LOWER(src.status) = 'out of stock' THEN 'Out of Stock'
                    ELSE src.status
                END
            ) = :{$key}";
            $localParams[$key] = $filters['status'];
        }

        if (!empty($filters['search'])) {
            $key = "search_{$sourceIndex}";
            $where[] = "(src.item_name LIKE :{$key} OR src.ref_id LIKE :{$key} OR src.specs LIKE :{$key})";
            $localParams[$key] = '%' . $filters['search'] . '%';
        }

        // Normalize all text columns to one widely supported utf8mb4 collation before UNION.
        // This prevents MySQL/MariaDB "Illegal mix of collations" errors when inventory
        // source tables were created with different collations.
        $part = "SELECT
                    CONVERT(src.item_name USING utf8mb4) COLLATE utf8mb4_general_ci AS item_name,
                    CONVERT(src.category USING utf8mb4) COLLATE utf8mb4_general_ci AS category,
                    CONVERT(src.branch USING utf8mb4) COLLATE utf8mb4_general_ci AS branch,
                    src.date_added,
                    CONVERT(src.ref_id USING utf8mb4) COLLATE utf8mb4_general_ci AS ref_id,
                    CONVERT(src.source USING utf8mb4) COLLATE utf8mb4_general_ci AS source,
                    src.added_by,
                    CONVERT(src.added_by_name USING utf8mb4) COLLATE utf8mb4_general_ci AS added_by_name,
                    CONVERT(src.status USING utf8mb4) COLLATE utf8mb4_general_ci AS status,
                    CONVERT(src.specs USING utf8mb4) COLLATE utf8mb4_general_ci AS specs
                 FROM (" . $source['sql'] . ") src";
        if ($where) {
            $part .= " WHERE " . implode(" AND ", $where);
        }

        $parts[] = $part;
        $params = array_merge($params, $localParams);
    }

    if (!$parts) {
        return "SELECT NULL AS item_name, NULL AS category, NULL AS branch, NULL AS date_added,
                       NULL AS ref_id, NULL AS source, NULL AS added_by, NULL AS added_by_name,
                       NULL AS status, NULL AS specs
                WHERE 1=0";
    }

    return implode(" UNION ALL ", $parts);
}

function fetchInventoryPage($conn, $filters, $limit, $offset) {
    $params = [];
    $unionSql = buildInventoryUnion($filters, $params);

    $countStmt = $conn->prepare("SELECT COUNT(*) FROM ({$unionSql}) inventory_count");
    foreach ($params as $key => $value) {
        $countStmt->bindValue(':' . $key, $value);
    }
    $countStmt->execute();
    $total = (int)$countStmt->fetchColumn();

    $listSql = "SELECT *
                FROM ({$unionSql}) inventory_list
                ORDER BY date_added DESC
                LIMIT :limit OFFSET :offset";

    $listStmt = $conn->prepare($listSql);
    foreach ($params as $key => $value) {
        $listStmt->bindValue(':' . $key, $value);
    }
    $listStmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $listStmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $listStmt->execute();

    return [
        'items' => $listStmt->fetchAll(PDO::FETCH_ASSOC),
        'total' => $total
    ];
}

// Get distinct categories from all tables
function getCategories($conn) {
    $cats = [];
    $tables = ['devices' => 'Device', 'monitors' => 'Monitor', 'printers' => 'Printer',
               'smartboards' => 'Smartboard', 'phones' => 'Phone', 'ups' => 'UPS',
               'accessories' => 'Accessory', 'chargers' => 'Charger',
               'hdds' => 'HDD', 'rams_ssds' => 'RAM/SSD', 'graphic_cards' => 'Graphics Card'];
    foreach ($tables as $table => $cat) {
        $sql = "SELECT DISTINCT '$cat' AS category FROM $table";
        $rows = $conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
        foreach ($rows as $row) {
            if (!in_array($row['category'], $cats)) $cats[] = $row['category'];
        }
    }
    sort($cats);
    return $cats;
}

// Get distinct branches from all tables
function getBranches($conn) {
    $branches = [];
    $tables = ['devices', 'monitors', 'printers', 'smartboards', 'phones', 'ups',
               'accessories', 'chargers', 'hdds', 'rams_ssds', 'graphic_cards'];
    foreach ($tables as $table) {
        $sql = "SELECT DISTINCT branch FROM $table WHERE branch IS NOT NULL AND branch != ''";
        $rows = $conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
        foreach ($rows as $row) {
            if (!in_array($row['branch'], $branches)) $branches[] = $row['branch'];
        }
    }
    sort($branches);
    return $branches;
}

// Get distinct users who added items
function getAddedByUsers($conn) {
    $users = [];
    $sql = "SELECT id, full_name FROM users WHERE id IN (
                SELECT DISTINCT added_by FROM devices WHERE added_by IS NOT NULL
                UNION
                SELECT DISTINCT added_by FROM monitors WHERE added_by IS NOT NULL
                UNION
                SELECT DISTINCT added_by FROM printers WHERE added_by IS NOT NULL
                UNION
                SELECT DISTINCT added_by FROM smartboards WHERE added_by IS NOT NULL
                UNION
                SELECT DISTINCT added_by FROM phones WHERE added_by IS NOT NULL
                UNION
                SELECT DISTINCT added_by FROM ups WHERE added_by IS NOT NULL
                UNION
                SELECT DISTINCT added_by FROM accessories WHERE added_by IS NOT NULL
                UNION
                SELECT DISTINCT updated_by FROM chargers WHERE updated_by IS NOT NULL
                UNION
                SELECT DISTINCT added_by FROM hdds WHERE added_by IS NOT NULL
                UNION
                SELECT DISTINCT added_by FROM rams_ssds WHERE added_by IS NOT NULL
                UNION
                SELECT DISTINCT added_by FROM graphic_cards WHERE added_by IS NOT NULL
            )
            ORDER BY full_name";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Get filters from GET
$filter_category = $_GET['filter_category'] ?? '';
$filter_search = trim($_GET['filter_search'] ?? '');
$filter_start_date = $_GET['filter_start_date'] ?? '';
$filter_end_date = $_GET['filter_end_date'] ?? '';
$filter_branch = $_GET['filter_branch'] ?? '';
$filter_added_by = $_GET['filter_added_by'] ?? '';
$filter_status = $_GET['filter_status'] ?? '';

$allowed_per_page = [100, 200, 300, 400, 500];
$per_page = isset($_GET['per_page']) ? (int)$_GET['per_page'] : 100;
if (!in_array($per_page, $allowed_per_page, true)) {
    $per_page = 100;
}

$page = max(1, (int)($_GET['page'] ?? 1));

$filters = [
    'category'   => $filter_category,
    'search'     => $filter_search,
    'start_date' => $filter_start_date,
    'end_date'   => $filter_end_date,
    'branch'     => $filter_branch,
    'added_by'   => $filter_added_by,
    'status'     => $filter_status
];

$categories = getCategories($conn);
$branches = getBranches($conn);
$users = getAddedByUsers($conn);

// First lightweight count so we can clamp the requested page.
$countParams = [];
$countUnion = buildInventoryUnion($filters, $countParams);
$countStmt = $conn->prepare("SELECT COUNT(*) FROM ({$countUnion}) inventory_count");
foreach ($countParams as $key => $value) {
    $countStmt->bindValue(':' . $key, $value);
}
$countStmt->execute();
$total_count = (int)$countStmt->fetchColumn();

$total_pages = max(1, (int)ceil($total_count / $per_page));
if ($page > $total_pages) {
    $page = $total_pages;
}

$offset = ($page - 1) * $per_page;

// Load only the rows needed for the current page.
$listParams = [];
$listUnion = buildInventoryUnion($filters, $listParams);
$listSql = "SELECT *
            FROM ({$listUnion}) inventory_list
            ORDER BY date_added DESC
            LIMIT :limit OFFSET :offset";

$listStmt = $conn->prepare($listSql);
foreach ($listParams as $key => $value) {
    $listStmt->bindValue(':' . $key, $value);
}
$listStmt->bindValue(':limit', $per_page, PDO::PARAM_INT);
$listStmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$listStmt->execute();
$inventoryItems = $listStmt->fetchAll(PDO::FETCH_ASSOC);

function overviewPageUrl($pageNumber) {
    $query = $_GET;
    $query['page'] = $pageNumber;
    return '?' . http_build_query($query);
}

$user_name = $_SESSION['name'] ?? ($_SESSION['full_name'] ?? 'User');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Inventory Overview | Mombasa Computers</title>
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
        .filter-group select, .filter-group input { padding: 0.625rem 0.875rem; border: 1px solid var(--gray-300); border-radius: var(--radius-md); font-size: 0.9rem; background: white; width: 100%; }
        .filter-actions { display: flex; gap: 0.75rem; align-items: flex-end; flex-wrap: wrap; }
        .btn { padding: 0.625rem 1.25rem; background: var(--primary); color: white; border: none; border-radius: var(--radius-md); cursor: pointer; display: inline-flex; align-items: center; gap: 0.5rem; text-decoration: none; font-size: 0.9rem; }
        .btn-secondary { background: var(--gray-500); }
        .btn-excel { background: #217346; }
        .btn:hover { opacity: 0.9; }
        .table-wrapper { background: white; border-radius: var(--radius-xl); border: 1px solid var(--gray-200); overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; min-width: 1200px; font-size: 0.85rem; }
        th { background: var(--gray-50); padding: 1rem; text-align: left; font-weight: 600; color: var(--gray-600); border-bottom: 1px solid var(--gray-200); white-space: nowrap; }
        td { padding: 0.8rem 1rem; border-bottom: 1px solid var(--gray-100); vertical-align: middle; }
        .badge { display: inline-block; padding: 0.25rem 0.625rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 500; background: var(--gray-100); }
        .status-badge { display: inline-block; padding: 0.25rem 0.75rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 600; }
        .status-instock { background: #d1fae5; color: #065f46; }
        .status-sold { background: #fee2e2; color: #991b1b; }
        .status-outofstock { background: #fef3c7; color: #92400e; }
        .specs-text { font-size: 0.8rem; color: var(--gray-600); word-wrap: break-word; max-width: 350px; display: inline-block; }
        .serial-code { font-family: 'Courier New', monospace; font-size: 0.85rem; background: var(--gray-50); padding: 0.25rem 0.5rem; border-radius: var(--radius-sm); display: inline-block; }
        .empty-state { text-align: center; padding: 3rem; color: var(--gray-500); }
        .footer { text-align: center; padding: 1.5rem 0 0.5rem; margin-top: 1.5rem; font-size: 0.85rem; color: var(--gray-400); border-top: 1px solid var(--gray-200); }
        @media (max-width: 1200px) { .main-content { margin-left: 0 !important; width: 100% !important; padding: 1.5rem 1rem 1rem !important; padding-top: 5rem !important; } }
        @media (max-width: 768px) { .filter-grid { grid-template-columns: 1fr; } .btn { width: 100%; justify-content: center; } .stats-row { flex-direction: column; } .filter-actions { flex-direction: column; align-items: stretch; } table { font-size: 0.75rem; } .specs-text { max-width: 200px; } }
        .pagination-bar { display:flex; justify-content:space-between; align-items:center; gap:1rem; flex-wrap:wrap; padding:1rem 0; }
        .pagination-controls { display:flex; align-items:center; gap:.4rem; flex-wrap:wrap; }
        .pagination-controls a, .pagination-controls span { padding:.45rem .7rem; border:1px solid var(--gray-300); border-radius:var(--radius-md); text-decoration:none; color:var(--gray-600); background:white; font-size:.85rem; }
        .pagination-controls .active { background:var(--primary); color:white; border-color:var(--primary); }
        .pagination-controls .disabled { opacity:.45; pointer-events:none; }
        .per-page-form { display:flex; align-items:center; gap:.5rem; font-size:.85rem; color:var(--gray-600); }
        .per-page-form select { padding:.45rem .65rem; border:1px solid var(--gray-300); border-radius:var(--radius-md); background:white; }
    </style>
</head>
<body>
    <?php require_once "../includes/sidebar.php"; ?>
<div class="main-content">
    <div class="page-header">
        <h1><i class="fas fa-list-ul"></i> Inventory Overview</h1>
        <div class="breadcrumb">
            <?php if ($_SESSION['role'] === 'super_admin'): ?>
                <a href="../dashboard/superadmindashboard.php">Dashboard</a>
            <?php elseif ($_SESSION['role'] === 'manager'): ?>
                <a href="../dashboard/managerdashboard.php">Dashboard</a>
            <?php elseif ($_SESSION['role'] === 'inventory_admin'): ?>
                <a href="../dashboard/inventorydashboard.php">Dashboard</a>
            <?php elseif ($_SESSION['role'] === 'sales'): ?>
                <a href="../dashboard/salesdashboard.php">Dashboard</a>
            <?php else: ?>
                <a href="../index.php">Home</a>
            <?php endif; ?>
            <span> / </span>
            <span>Overview</span>
        </div>
    </div>

    <div class="stats-row">
        <div class="stat-card"><div class="stat-value"><?= number_format($total_count) ?></div><div class="stat-label">Total Items</div></div>
        <div class="stat-card"><div class="stat-value"><?= number_format(count($categories)) ?></div><div class="stat-label">Categories</div></div>
        <div class="stat-card"><div class="stat-value"><?= number_format(count($branches)) ?></div><div class="stat-label">Branches</div></div>
        <?php if (!empty($inventoryItems)): ?>
            <div class="stat-card"><div class="stat-value"><?= date('Y-m-d', strtotime($inventoryItems[0]['date_added'])) ?></div><div class="stat-label">Newest Added</div></div>
        <?php endif; ?>
    </div>

    <div class="filter-section">
        <div class="filter-title"><i class="fas fa-filter"></i> Filter Inventory</div>
        <form method="GET" class="filter-grid">
            <input type="hidden" name="per_page" value="<?= (int)$per_page ?>">
            <div class="filter-group">
                <label>Category</label>
                <select name="filter_category">
                    <option value="">All Categories</option>
                    <?php foreach ($categories as $cat): ?>
                        <option value="<?= htmlspecialchars($cat) ?>" <?= $filter_category == $cat ? 'selected' : '' ?>><?= htmlspecialchars($cat) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="filter-group">
                <label>Search (name, ref, specs)</label>
                <input type="text" name="filter_search" placeholder="Search..." value="<?= htmlspecialchars($filter_search) ?>">
            </div>
            <div class="filter-group">
                <label>Start Date</label>
                <input type="date" name="filter_start_date" value="<?= htmlspecialchars($filter_start_date) ?>" max="<?= date('Y-m-d') ?>">
            </div>
            <div class="filter-group">
                <label>End Date</label>
                <input type="date" name="filter_end_date" value="<?= htmlspecialchars($filter_end_date) ?>" max="<?= date('Y-m-d') ?>">
            </div>
            <div class="filter-group">
                <label>Branch</label>
                <select name="filter_branch">
                    <option value="">All Branches</option>
                    <?php foreach ($branches as $br): ?>
                        <option value="<?= htmlspecialchars($br) ?>" <?= $filter_branch == $br ? 'selected' : '' ?>><?= htmlspecialchars($br) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="filter-group">
                <label>Added By</label>
                <select name="filter_added_by">
                    <option value="">All Users</option>
                    <?php foreach ($users as $u): ?>
                        <option value="<?= $u['id'] ?>" <?= $filter_added_by == $u['id'] ? 'selected' : '' ?>><?= htmlspecialchars($u['full_name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="filter-group">
                <label>Status</label>
                <select name="filter_status">
                    <option value="">All Statuses</option>
                    <option value="In Stock" <?= $filter_status == 'In Stock' ? 'selected' : '' ?>>In Stock</option>
                    <option value="Sold" <?= $filter_status == 'Sold' ? 'selected' : '' ?>>Sold</option>
                    <option value="Out of Stock" <?= $filter_status == 'Out of Stock' ? 'selected' : '' ?>>Out of Stock</option>
                </select>
            </div>
            <div class="filter-actions">
                <button type="submit" class="btn"><i class="fas fa-search"></i> Filter</button>
                <a href="overview.php" class="btn btn-secondary"><i class="fas fa-undo"></i> Reset</a>
                <?php if (!empty($inventoryItems)): ?>
                    <a href="export_inventory_excel.php?<?= http_build_query(array_merge(array_diff_key($_GET, ['page' => true, 'per_page' => true]), ['export' => '1'])) ?>" class="btn btn-excel"><i class="fas fa-file-excel"></i> Export to Excel</a>
                <?php endif; ?>
            </div>
        </form>
    </div>

    <div class="table-wrapper">
        <?php if (empty($inventoryItems)): ?>
            <div class="empty-state"><i class="fas fa-box-open" style="font-size:2rem; display:block; margin-bottom:1rem;"></i><p>No items found matching your criteria.</p></div>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Item Name</th>
                        <th>Category</th>
                        <th>Branch</th>
                        <th>Added By</th>
                        <th>Status</th>
                        <th>Date Added</th>
                        <th>Reference</th>
                        <th>Specifications</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = $offset + 1; foreach ($inventoryItems as $item): ?>
                    <tr>
                        <td><?= $i++ ?></td>
                        <td><strong><?= htmlspecialchars($item['item_name']) ?></strong></td>
                        <td><span class="badge"><?= htmlspecialchars($item['category']) ?></span></td>
                        <td><?= htmlspecialchars($item['branch'] ?? '-') ?></td>
                        <td><?= htmlspecialchars($item['added_by_name'] ?? '-') ?></td>
                        <td>
                            <?php
                            $status = $item['status'] ?? 'Unknown';
                            $statusClass = '';
                            if (strtolower($status) === 'in stock' || strtolower($status) === 'instock') {
                                $statusClass = 'status-instock';
                                $displayStatus = 'In Stock';
                            } elseif (strtolower($status) === 'sold') {
                                $statusClass = 'status-sold';
                                $displayStatus = 'Sold';
                            } elseif (strtolower($status) === 'out of stock') {
                                $statusClass = 'status-outofstock';
                                $displayStatus = 'Out of Stock';
                            } else {
                                $displayStatus = $status;
                            }
                            ?>
                            <span class="status-badge <?= $statusClass ?>"><?= htmlspecialchars($displayStatus) ?></span>
                        </td>
                        <td><?= $item['date_added'] ? date('Y-m-d H:i', strtotime($item['date_added'])) : '-' ?></td>
                        <td><span class="serial-code"><?= htmlspecialchars($item['ref_id'] ?? '-') ?></span></td>
                        <td><span class="specs-text" title="<?= htmlspecialchars($item['specs'] ?? '') ?>"><?= htmlspecialchars($item['specs'] ?? '-') ?></span></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>

    <?php if ($total_count > 0): ?>
    <div class="pagination-bar">
        <form method="GET" class="per-page-form">
            <?php foreach ($_GET as $key => $value): ?>
                <?php if ($key !== 'per_page' && $key !== 'page' && !is_array($value)): ?>
                    <input type="hidden" name="<?= htmlspecialchars($key) ?>" value="<?= htmlspecialchars($value) ?>">
                <?php endif; ?>
            <?php endforeach; ?>
            <label for="overviewPerPage">Show</label>
            <select id="overviewPerPage" name="per_page" onchange="this.form.submit()">
                <?php foreach ($allowed_per_page as $size): ?>
                    <option value="<?= $size ?>" <?= $per_page === $size ? 'selected' : '' ?>><?= $size ?></option>
                <?php endforeach; ?>
            </select>
            <span>per page</span>
        </form>

        <div class="pagination-controls">
            <?php if ($page > 1): ?>
                <a href="<?= htmlspecialchars(overviewPageUrl($page - 1)) ?>">Previous</a>
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
                    <a href="<?= htmlspecialchars(overviewPageUrl($p)) ?>"><?= $p ?></a>
                <?php endif; ?>
            <?php endfor; ?>

            <?php if ($page < $total_pages): ?>
                <a href="<?= htmlspecialchars(overviewPageUrl($page + 1)) ?>">Next</a>
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