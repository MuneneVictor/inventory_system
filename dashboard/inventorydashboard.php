<?php
session_start();
require_once "../config/db.php";
require_once "../includes/auth_check.php";
require_once "../includes/header.php";
require_once "../includes/sidebar.php";

// STRICT ROLE CHECK - DIE IMMEDIATELY
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'inventory_admin') {
    die("ACCESS DENIED: You do not have permission to access this page.");
}

$user_id = (int)($_SESSION['user_id'] ?? 0);
$user_name = $_SESSION['name'] ?? ($_SESSION['full_name'] ?? 'User');

function safeQuery($conn, $sql, $params = []) {
    try {
        $stmt = $conn->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    } catch (PDOException $e) {
        error_log("Database Error: " . $e->getMessage());
        return false;
    }
}

// Inventory Admin Statistics
$totalInStock = 0;
$totalSoldDevices = 0;
$totalSalesCount = 0;
$todaysSalesCount = 0;
$totalDevices = 0;
$totalRepairs = 0;
$pendingRepairs = 0;
$completedRepairs = 0;
$totalRevenue = 0;
$todaysRevenue = 0;
$totalRamInStock = 0;
$totalSsdInStock = 0;
$totalChargersInStock = 0;
$avgDevicePrice = 0;
$totalAccessoriesGiven = 0;
$lowStockItems = [];

// Low stock items - RAM/SSD
$rStmt = safeQuery($conn, "SELECT id, category, type, storage, quantity, branch FROM rams_ssds WHERE quantity < :threshold", ['threshold' => 10]);
if ($rStmt) {
    $rows = $rStmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($rows as $r) {
        $r['source'] = 'ram_ssd';
        $lowStockItems[] = $r;
    }
}

// Low stock items - Chargers
$cStmt = safeQuery($conn, "SELECT id, charger_type, watts, quantity, branch FROM chargers WHERE quantity < :threshold", ['threshold' => 10]);
if ($cStmt) {
    $rows = $cStmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($rows as $c) {
        $item = [
            'id' => $c['id'] ?? null,
            'category' => 'Charger',
            'type' => $c['charger_type'] ?? 'Charger',
            'storage' => $c['watts'] ?? null,
            'quantity' => $c['quantity'] ?? 0,
            'branch' => $c['branch'] ?? null,
            'source' => 'charger'
        ];
        $lowStockItems[] = $item;
    }
}

// Total devices count
$s = safeQuery($conn, "SELECT COUNT(*) FROM devices");
$totalDevices = $s ? (int)$s->fetchColumn() : 0;

$s = safeQuery($conn, "SELECT COUNT(*) FROM devices WHERE status = :status", ['status' => 'In Stock']);
$totalInStock = $s ? (int)$s->fetchColumn() : 0;

$s = safeQuery($conn, "SELECT COUNT(*) FROM devices WHERE status = :status", ['status' => 'Sold']);
$totalSoldDevices = $s ? (int)$s->fetchColumn() : 0;

$s = safeQuery($conn, "SELECT COUNT(*) FROM sold_devices");
$totalSalesCount = $s ? (int)$s->fetchColumn() : 0;

$s = safeQuery($conn, "SELECT COUNT(*) FROM sold_devices WHERE DATE(sold_at) = CURDATE()");
$todaysSalesCount = $s ? (int)$s->fetchColumn() : 0;

// Revenue stats
$s = safeQuery($conn, "SELECT COALESCE(SUM(price), 0) FROM sold_devices");
$totalRevenue = $s ? (float)$s->fetchColumn() : 0;

$s = safeQuery($conn, "SELECT COALESCE(SUM(price), 0) FROM sold_devices WHERE DATE(sold_at) = CURDATE()");
$todaysRevenue = $s ? (float)$s->fetchColumn() : 0;

// Average price
$s = safeQuery($conn, "SELECT COALESCE(AVG(price), 0) FROM sold_devices");
$avgDevicePrice = $s ? (float)$s->fetchColumn() : 0;

// RAM total
$s = safeQuery($conn, "SELECT COALESCE(SUM(quantity), 0) FROM rams_ssds WHERE category = :category", ['category' => 'RAM']);
$totalRamInStock = $s ? (int)$s->fetchColumn() : 0;

// SSD total
$s = safeQuery($conn, "SELECT COALESCE(SUM(quantity), 0) FROM rams_ssds WHERE category = :category", ['category' => 'SSD']);
$totalSsdInStock = $s ? (int)$s->fetchColumn() : 0;

// Chargers inventory
$s = safeQuery($conn, "SELECT COALESCE(SUM(quantity), 0) FROM chargers");
$totalChargersInStock = $s ? (int)$s->fetchColumn() : 0;

// Total accessories given
$s = safeQuery($conn, "SELECT COALESCE(SUM(quantity), 0) FROM rams_ssds_logs");
$totalAccessoriesGiven = $s ? (int)$s->fetchColumn() : 0;
$s = safeQuery($conn, "SELECT COALESCE(SUM(quantity), 0) FROM charger_logs");
$totalAccessoriesGiven += $s ? (int)$s->fetchColumn() : 0;

// Repairs stats
$s = safeQuery($conn, "SELECT COUNT(*) FROM repairs");
$totalRepairs = $s ? (int)$s->fetchColumn() : 0;

$s = safeQuery($conn, "SELECT COUNT(*) FROM repairs WHERE fix_status = :status", ['status' => 'Not Fixed']);
$pendingRepairs = $s ? (int)$s->fetchColumn() : 0;

$s = safeQuery($conn, "SELECT COUNT(*) FROM repairs WHERE fix_status = :status", ['status' => 'Fixed']);
$completedRepairs = $s ? (int)$s->fetchColumn() : 0;

// RAM/SSD logs given by current user
$inventoryAdminRamSsdGiven = [];
$ramSsdLogQuery = "
    SELECT 
        l.*,
        r.type,
        r.category,
        r.storage,
        u.full_name AS given_to_name,
        ub.full_name AS given_by_name
    FROM rams_ssds_logs l 
    LEFT JOIN rams_ssds r ON l.ram_ssd_id = r.id 
    LEFT JOIN users u ON l.given_to = u.id 
    LEFT JOIN users ub ON l.given_by = ub.id 
    WHERE l.given_by = :uid 
    ORDER BY l.date_given DESC 
    LIMIT 10
";

$ramSsdStmt = safeQuery($conn, $ramSsdLogQuery, ['uid' => $user_id]);
if ($ramSsdStmt !== false) {
    $ramSsdRows = $ramSsdStmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($ramSsdRows as $row) {
        $inventoryAdminRamSsdGiven[] = [
            'id' => $row['id'] ?? null,
            'type' => $row['type'] ?? '-',
            'category' => $row['category'] ?? '-',
            'storage' => $row['storage'] ?? null,
            'quantity_given' => (int)($row['quantity_given'] ?? $row['quantity'] ?? 0),
            'given_to_name' => $row['given_to_name'] ?? '-',
            'given_by_name' => $row['given_by_name'] ?? '-',
            'branch' => $row['branch'] ?? null,
            'date_given' => $row['date_given'] ?? null,
            'raw' => $row
        ];
    }
}

// Charger logs given by current user
$inventoryAdminChargersGiven = [];
$chargerLogQuery = "
    SELECT 
        cl.*,
        c.charger_type,
        c.watts,
        c.charger_condition,
        u.full_name AS given_to_name,
        ub.full_name AS given_by_name
    FROM charger_logs cl 
    LEFT JOIN chargers c ON cl.charger_id = c.id 
    LEFT JOIN users u ON cl.given_to = u.id 
    LEFT JOIN users ub ON cl.given_by = ub.id 
    WHERE cl.given_by = :uid
    ORDER BY cl.date_given DESC 
    LIMIT 12
";

$chargerStmt = safeQuery($conn, $chargerLogQuery, ['uid' => $user_id]);
if ($chargerStmt !== false) {
    $chargerRows = $chargerStmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($chargerRows as $row) {
        $inventoryAdminChargersGiven[] = [
            'id' => $row['id'] ?? null,
            'charger_label' => trim(($row['charger_type'] ?? 'Charger') . ($row['watts'] ? " {$row['watts']}W" : '')),
            'quantity_given' => (int)($row['quantity'] ?? 0),
            'given_to_name' => $row['given_to_name'] ?? '-',
            'given_by_name' => $row['given_by_name'] ?? '-',
            'branch' => $row['branch'] ?? null,
            'date_given' => $row['date_given'] ?? null,
            'charger_condition' => $row['charger_condition'] ?? '-',
            'watts' => $row['watts'] ?? '-',
            'raw' => $row
        ];
    }
}

// Get current time greeting
date_default_timezone_set('Africa/Nairobi'); 
$hour = date('G');
if ($hour < 12) $greeting = 'Good morning';
elseif ($hour < 17) $greeting = 'Good afternoon';
else $greeting = 'Good evening';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover, maximum-scale=1.0, user-scalable=yes">
    <title>Inventory Admin Dashboard | Mombasa Computers</title>
    <style>
    :root {
        --primary: #1a4b2a;
        --primary-light: #2a6b3a;
        --primary-dark: #0f3a1e;
        --secondary: #1a4f6e;
        --secondary-light: #2a6f94;
        --secondary-dark: #0f3a4e;
        --accent: #f59e0b;
        --accent-light: #fbbf24;
        --accent-dark: #d97706;
        --success: #059669;
        --warning: #d97706;
        --danger: #dc2626;
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
        --gray-900: #111827;
        
        --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
        --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
        --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
        --shadow-xl: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1);
        
        --radius-sm: 0.375rem;
        --radius-md: 0.5rem;
        --radius-lg: 0.75rem;
        --radius-xl: 1rem;
        
        --font-sans: 'Inter', system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', sans-serif;
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
        position: relative;
    }

    .header-row { 
        display: flex; 
        justify-content: space-between; 
        align-items: center; 
        gap: 1.5rem; 
        margin-bottom: 2rem; 
        background: white;
        padding: 1.25rem 2rem;
        border-radius: var(--radius-xl);
        box-shadow: var(--shadow-sm);
        border: 1px solid var(--gray-200);
        flex-wrap: wrap;
    }

    .page-title { 
        font-size: 2rem; 
        color: var(--primary-dark); 
        font-weight: 700;
        letter-spacing: -0.02em;
        line-height: 1.2;
    }

    .welcome-text {
        font-size: 0.95rem;
        color: var(--gray-500);
        margin-top: 0.25rem;
    }

    .logo img {
        height: 48px;
        width: auto;
        filter: brightness(0.95);
        max-width: 100%;
    }

    .card-row { 
        display: grid; 
        grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
        gap: 1.5rem; 
        margin-bottom: 2rem; 
    }

    .card { 
        padding: 1.5rem; 
        border-radius: var(--radius-xl); 
        color: white; 
        box-shadow: var(--shadow-md);
        transition: all 0.2s ease;
        position: relative;
        overflow: hidden;
        border: none;
        backdrop-filter: blur(10px);
        min-width: 0;
    }

    .card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(135deg, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0) 100%);
        pointer-events: none;
    }

    .card:hover { 
        transform: translateY(-4px);
        box-shadow: var(--shadow-lg);
    }

    .card h3 { 
        margin: 0 0 0.75rem 0; 
        font-size: 0.9rem; 
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        opacity: 0.9;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        flex-wrap: wrap;
    }

    .card .big { 
        font-size: 2.25rem; 
        font-weight: 700;
        line-height: 1.2;
        margin-bottom: 0.5rem;
        word-break: break-word;
    }

    .card .small { 
        font-size: 0.85rem; 
        opacity: 0.9;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        flex-wrap: wrap;
    }

    .card.primary { 
        background: linear-gradient(145deg, var(--primary), var(--primary-dark));
    }

    .card.secondary { 
        background: linear-gradient(145deg, var(--secondary), var(--secondary-dark));
    }

    .card.success { 
        background: linear-gradient(145deg, var(--success), #047857);
    }

    .card.warning { 
        background: linear-gradient(145deg, var(--accent), var(--accent-dark));
    }

    .card.info { 
        background: linear-gradient(145deg, var(--info), #1e40af);
    }

    .card.light { 
        background: white; 
        color: var(--gray-700); 
        border: 1px solid var(--gray-200);
        box-shadow: var(--shadow-sm);
    }

    .card.light .big {
        color: var(--primary-dark);
    }

    .card.light h3 {
        color: var(--gray-500);
    }

    .banner { 
        background: #fffbeb; 
        border-left: 4px solid var(--warning); 
        padding: 1.5rem 2rem; 
        border-radius: var(--radius-lg); 
        margin-bottom: 2rem; 
        display: flex; 
        gap: 1.5rem; 
        align-items: flex-start;
        box-shadow: var(--shadow-sm);
        border: 1px solid #fef3c7;
        flex-wrap: wrap;
    }

    .banner .title { 
        font-weight: 600; 
        color: var(--warning);
        font-size: 1.1rem;
        margin-bottom: 0.75rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        flex-wrap: wrap;
    }

    .banner .title i {
        font-size: 1.25rem;
    }

    .banner .small {
        color: var(--gray-600);
        line-height: 1.6;
    }

    .banner ol {
        margin: 0.75rem 0 0 1.5rem;
        color: var(--gray-700);
        word-break: break-word;
    }

    .banner ol li {
        margin-bottom: 0.5rem;
    }

    .banner .link-btn {
        background: var(--primary) !important;
        color: white !important;
        border: none;
        padding: 0.625rem 1.25rem;
        border-radius: var(--radius-md);
        font-size: 0.95rem;
        font-weight: 500;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.2s ease;
    }

    .banner .link-btn:hover {
        background: var(--primary-light) !important;
        transform: translateY(-2px);
    }

    .section { 
        margin-bottom: 2rem; 
        background: white; 
        padding: 1.75rem; 
        border-radius: var(--radius-xl); 
        box-shadow: var(--shadow-sm);
        border: 1px solid var(--gray-200);
        transition: all 0.2s ease;
        overflow-x: auto;
    }

    .section:hover {
        box-shadow: var(--shadow-md);
        border-color: var(--gray-300);
    }

    .section h4 { 
        margin: 0 0 1.5rem 0; 
        color: var(--gray-800); 
        font-size: 1.25rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        letter-spacing: -0.01em;
        flex-wrap: wrap;
    }

    .section h4 i {
        color: var(--primary);
        font-size: 1.5rem;
    }

    .section h4::after {
        content: '';
        flex: 1;
        height: 2px;
        background: linear-gradient(90deg, var(--primary-light) 0%, var(--gray-200) 100%);
        margin-left: 1rem;
        min-width: 50px;
    }

    .table-responsive {
        overflow-x: auto;
        border-radius: var(--radius-lg);
        -webkit-overflow-scrolling: touch;
        width: 100%;
    }

    .table { 
        width: 100%; 
        border-collapse: collapse; 
        font-size: 0.95rem;
        min-width: 600px;
    }

    .table th { 
        padding: 1rem 1rem; 
        background: var(--gray-50); 
        color: var(--gray-600); 
        font-weight: 600;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        border-bottom: 2px solid var(--gray-300);
        text-align: left;
        white-space: nowrap;
    }

    .table td { 
        padding: 1rem; 
        border-bottom: 1px solid var(--gray-200); 
        color: var(--gray-700);
        vertical-align: middle;
        word-break: break-word;
    }

    .table tbody tr:hover {
        background-color: var(--gray-50);
    }

    .table code {
        background: var(--gray-100);
        padding: 0.2rem 0.4rem;
        border-radius: var(--radius-sm);
        font-family: monospace;
        font-size: 0.9rem;
        color: var(--primary-dark);
        word-break: break-all;
    }

    .status-indicator {
        display: inline-block;
        width: 8px;
        height: 8px;
        border-radius: 50%;
        margin-right: 0.5rem;
    }

    .status-instock { 
        background: var(--success);
        box-shadow: 0 0 0 2px rgba(5, 150, 105, 0.2);
    }

    .badge {
        display: inline-block;
        padding: 0.25rem 0.75rem;
        border-radius: 9999px;
        font-size: 0.85rem;
        font-weight: 500;
        background: var(--gray-100);
        color: var(--gray-700);
        white-space: nowrap;
    }

    .badge-primary {
        background: var(--primary);
        color: white;
    }

    .badge-secondary {
        background: var(--secondary);
        color: white;
    }

    .badge-warning {
        background: var(--warning);
        color: white;
    }

    .link-btn { 
        padding: 0.625rem 1.25rem; 
        background: var(--primary); 
        color: white !important; 
        border-radius: var(--radius-md); 
        text-decoration: none; 
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        font-weight: 500;
        font-size: 0.95rem;
        border: none;
        cursor: pointer;
        transition: all 0.2s ease;
        box-shadow: var(--shadow-sm);
    }

    .link-btn:hover {
        background: var(--primary-light);
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }

    footer {
        text-align: center;
        padding: 2rem 0 0.5rem;
        margin-top: 2rem;
        font-size: 0.9rem;
        color: var(--gray-500);
        border-top: 1px solid var(--gray-200);
    }

    @keyframes fadeIn {
        from { 
            opacity: 0; 
            transform: translateY(10px); 
        }
        to { 
            opacity: 1; 
            transform: translateY(0); 
        }
    }

    .card, .section, .banner, .header-row {
        animation: fadeIn 0.4s ease-out forwards;
    }

    @media (max-width: 1200px) {
        .main-content {
            margin-left: 0 !important;
            width: 100% !important;
            padding: 1.5rem 1rem 1rem !important;
            padding-top: 5rem !important;
        }
        
        .header-row {
            flex-direction: column !important;
            align-items: flex-start !important;
            gap: 1rem !important;
            padding: 1.25rem !important;
            position: relative;
            padding-right: 70px;
        }
        
        .header-row .logo {
            position: absolute;
            top: 1.25rem;
            right: 1.25rem;
        }
        
        .page-title {
            font-size: 1.75rem !important;
            width: calc(100% - 60px);
        }
        
        .welcome-text {
            width: calc(100% - 60px);
            font-size: 0.85rem !important;
        }
        
        .card-row {
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)) !important;
            gap: 1rem !important;
        }
        
        .section {
            padding: 1.5rem !important;
        }
        
        .banner {
            flex-direction: column !important;
            padding: 1.25rem !important;
            gap: 1rem !important;
        }
        
        .banner .link-btn {
            width: 100%;
            justify-content: center;
        }
    }

    @media (max-width: 768px) {
        .main-content {
            padding: 1rem 0.75rem 0.75rem !important;
            padding-top: 4.5rem !important;
        }
        
        .page-title {
            font-size: 1.5rem !important;
        }
        
        .logo img {
            height: 40px !important;
        }
        
        .card .big {
            font-size: 1.75rem !important;
        }
        
        .table td,
        .table th {
            padding: 0.75rem !important;
        }
        
        .table {
            min-width: 550px;
        }
    }

    @media (max-width: 480px) {
        .main-content {
            padding: 0.75rem 0.5rem 0.5rem !important;
            padding-top: 4rem !important;
        }
        
        .page-title {
            font-size: 1.25rem !important;
        }
        
        .card-row {
            grid-template-columns: 1fr !important;
            gap: 0.75rem !important;
        }
        
        .table {
            min-width: 500px !important;
        }
        
        .badge {
            font-size: 0.75rem !important;
            padding: 0.2rem 0.5rem !important;
        }
        
        .header-row {
            padding-right: 60px !important;
        }
        
        .header-row .logo img {
            height: 35px !important;
        }
    }

    .text-success { color: var(--success); }
    .text-warning { color: var(--warning); }
    .text-muted { color: var(--gray-400); }
    </style>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>

<div class="main-content">
    <div class="header-row">
        <div>
            <div class="page-title">Inventory Admin Dashboard</div>
            <div class="welcome-text">
                <i class="fas fa-hand-wave" style="color: var(--accent); margin-right: 0.5rem;"></i>
                <?= $greeting ?>, <?= htmlspecialchars(explode(' ', $user_name)[0]) ?> • <?= date('l, F j, Y') ?>
            </div>
        </div>
        <div class="logo">
            <img src="/inventory_system/assets/MC-LOGO.png" alt="Mombasa Computers" onerror="this.style.display='none'">
        </div>
        <div>
            <a href="/inventory_system/dashboard/inventorydashboard.php" class="link-btn">
                <i class="fas fa-sync-alt"></i> Refresh
            </a>
        </div>
    </div>

    <?php if (!empty($lowStockItems)): ?>
        <div class="banner" role="alert">
            <div style="flex:1">
                <div class="title">
                    <i class="fas fa-exclamation-triangle"></i>
                    Low Stock Alert
                </div>
                <div class="small">
                    The following items are running low (below 10 units). Please restock soon:
                    <ol>
                        <?php foreach($lowStockItems as $item): ?>
                            <li>
                                <?php if($item['source'] === 'charger'): ?>
                                    <strong><?= htmlspecialchars(($item['type'] ?? 'Charger') . ($item['storage'] ? " {$item['storage']}W" : '')) ?></strong>
                                <?php else: ?>
                                    <strong><?= htmlspecialchars(($item['category'] ?? '') . ' • ' . ($item['type'] ?? '-')) ?>
                                    <?= !empty($item['storage']) ? htmlspecialchars(" {$item['storage']}GB") : '' ?></strong>
                                <?php endif; ?>
                                <span class="badge badge-warning"><?= (int)$item['quantity'] ?> left</span>
                                <?php if(!empty($item['branch'])): ?> • <?= htmlspecialchars($item['branch']) ?><?php endif; ?>
                            </li>
                        <?php endforeach; ?>
                    </ol>
                </div>
                <div style="margin-top:1.5rem; display: flex; gap: 1rem; flex-wrap: wrap;">
                    <a href="/inventory_system/ram_ssd/add_ram.php" class="link-btn">
                        <i class="fas fa-memory"></i> Restock RAM/SSD
                    </a>
                    <a href="/inventory_system/chargers/add_charger.php" class="link-btn">
                        <i class="fas fa-bolt"></i> Restock Chargers
                    </a>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- Inventory Admin Stats -->
    <div class="card-row">
        <div class="card primary">
            <h3><i class="fas fa-box"></i> Total Devices</h3>
            <div class="big"><?= number_format($totalDevices) ?></div>
            <div class="small">
                <span class="status-indicator status-instock"></span>
                <?= number_format($totalInStock) ?> In Stock
            </div>
        </div>
        
        <div class="card success">
            <h3><i class="fas fa-shopping-cart"></i> Sold Devices</h3>
            <div class="big"><?= number_format($totalSoldDevices) ?></div>
            <div class="small">Total sold devices</div>
        </div>
        
        <div class="card info">
            <h3><i class="fas fa-chart-line"></i> Total Revenue</h3>
            <div class="big">Ksh <?= number_format($totalRevenue, 0) ?></div>
            <div class="small">Avg: Ksh <?= number_format($avgDevicePrice, 0) ?></div>
        </div>
        
        <div class="card warning">
            <h3><i class="fas fa-tools"></i> Total Repairs</h3>
            <div class="big"><?= number_format($totalRepairs) ?></div>
            <div class="small">
                <span class="text-success"><?= number_format($completedRepairs) ?> fixed</span>
            </div>
        </div>
    </div>

    <!-- Accessories Overview -->
    <div class="card-row">
        <div class="card light">
            <h3><i class="fas fa-memory" style="color: var(--primary);"></i> RAM Stock</h3>
            <div class="big"><?= number_format($totalRamInStock) ?></div>
            <div class="small">Total units available</div>
        </div>
        
        <div class="card light">
            <h3><i class="fas fa-database" style="color: var(--info);"></i> SSD Stock</h3>
            <div class="big"><?= number_format($totalSsdInStock) ?></div>
            <div class="small">Total units available</div>
        </div>
        
        <div class="card light">
            <h3><i class="fas fa-bolt" style="color: var(--warning);"></i> Chargers Stock</h3>
            <div class="big"><?= number_format($totalChargersInStock) ?></div>
            <div class="small">Total units available</div>
        </div>
        
        <div class="card light">
            <h3><i class="fas fa-hand-holding-heart" style="color: var(--success);"></i> Total Given</h3>
            <div class="big"><?= number_format($totalAccessoriesGiven) ?></div>
            <div class="small">Accessories distributed</div>
        </div>
    </div>

    <!-- Inventory Admin: RAM/SSD Given by You -->
    <div class="section">
        <h4>
            <i class="fas fa-memory"></i>
            Recently Given RAM/SSD
        </h4>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Item</th>
                        <th>Category</th>
                        <th>Storage</th>
                        <th>Qty</th>
                        <th>Given To</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(!empty($inventoryAdminRamSsdGiven)): ?>
                        <?php foreach($inventoryAdminRamSsdGiven as $ram): ?>
                            <tr>
                                <td><strong><?= htmlspecialchars($ram['type'] ?? '-') ?></strong></td>
                                <td><span class="badge"><?= htmlspecialchars($ram['category'] ?? '-') ?></span></td>
                                <td><?= !empty($ram['storage']) ? htmlspecialchars($ram['storage'] . 'GB') : '-' ?></td>
                                <td><span class="badge badge-primary"><?= (int)$ram['quantity_given'] ?></span></td>
                                <td><i class="fas fa-user" style="margin-right: 0.25rem;"></i><?= htmlspecialchars($ram['given_to_name'] ?? '-') ?></td>
                                <td><?= htmlspecialchars(date('M j, Y', strtotime($ram['date_given'] ?? ''))) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-muted" style="text-align:center; padding: 2.5rem;">No RAM/SSD given by you recently.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Inventory Admin: Chargers Given by You -->
    <div class="section">
        <h4>
            <i class="fas fa-bolt"></i>
            Recently Given Chargers
        </h4>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Charger</th>
                        <th>Condition</th>
                        <th>Watts</th>
                        <th>Qty</th>
                        <th>Given To</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(!empty($inventoryAdminChargersGiven)): ?>
                        <?php foreach($inventoryAdminChargersGiven as $c): ?>
                            <tr>
                                <td><strong><?= htmlspecialchars($c['charger_label']) ?></strong></td>
                                <td><span class="badge"><?= htmlspecialchars($c['charger_condition'] ?? '-') ?></span></td>
                                <td><?= htmlspecialchars($c['watts'] ?? '-') ?>W</td>
                                <td><span class="badge badge-secondary"><?= (int)$c['quantity_given'] ?></span></td>
                                <td><i class="fas fa-user" style="margin-right: 0.25rem;"></i><?= htmlspecialchars($c['given_to_name']) ?></td>
                                <td><?= htmlspecialchars(date('M j, Y', strtotime($c['date_given'] ?? ''))) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-muted" style="text-align:center; padding: 2.5rem;">No chargers given by you recently.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <footer>
        <i class="fas fa-copyright"></i> <?= date('Y'); ?> Mombasa Computers. All rights reserved. 
        <span style="margin: 0 0.5rem;">•</span> 
        <span>v2.0.0</span>
    </footer>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    function adjustDashboardForMobile() {
        const mainContent = document.querySelector('.main-content');
        const sidebar = document.getElementById('sidebar');
        
        if (window.innerWidth <= 1200) {
            if (mainContent) {
                mainContent.style.marginLeft = '0';
                mainContent.style.width = '100%';
                mainContent.style.paddingTop = '5rem';
                mainContent.style.overflowX = 'hidden';
            }
            if (sidebar && !sidebar.classList.contains('active')) {
                document.body.style.overflow = 'auto';
            }
        } else {
            if (mainContent && sidebar) {
                mainContent.style.marginLeft = '260px';
                mainContent.style.width = 'calc(100% - 260px)';
                mainContent.style.paddingTop = '';
                mainContent.style.overflowX = '';
            }
        }
    }
    
    adjustDashboardForMobile();
    window.addEventListener('resize', adjustDashboardForMobile);
    window.addEventListener('orientationchange', function() {
        setTimeout(adjustDashboardForMobile, 100);
    });
    
    window.addEventListener('sidebarToggled', adjustDashboardForMobile);
    
    const originalToggle = window.toggleSidebar;
    if (originalToggle) {
        window.toggleSidebar = function() {
            originalToggle();
            setTimeout(() => {
                window.dispatchEvent(new Event('sidebarToggled'));
            }, 300);
        };
    }
});
</script>

<?php require_once "../includes/footer.php"; ?>
</body>
</html>