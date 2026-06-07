<?php
session_start();
require_once "../config/db.php";
require_once "../includes/auth_check.php";
require_once "../includes/header.php";
require_once "../includes/sidebar.php";

// STRICT ROLE CHECK - DIE IMMEDIATELY
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'sales') {
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

// Sales-specific statistics
$myTotalSales = 0;
$myTodaysSales = 0;
$myTotalRevenue = 0;
$myTodaysRevenue = 0;
$myMonthlyRevenue = 0;
$myMonthlySales = 0;
$myAvgSalePrice = 0;
$myRecentSales = [];
$myPerformanceRank = 0;
$totalSalesTeam = 0;
$recentRamGiven = [];
$recentChargersGivenToMe = [];

$s = safeQuery($conn, "SELECT COUNT(*) FROM sold_devices WHERE sold_by = :uid", ['uid' => $user_id]);
$myTotalSales = $s ? (int)$s->fetchColumn() : 0;

$s = safeQuery($conn, "SELECT COUNT(*) FROM sold_devices WHERE sold_by = :uid AND DATE(sold_at) = CURDATE()", ['uid' => $user_id]);
$myTodaysSales = $s ? (int)$s->fetchColumn() : 0;

$s = safeQuery($conn, "SELECT COALESCE(SUM(price), 0) FROM sold_devices WHERE sold_by = :uid", ['uid' => $user_id]);
$myTotalRevenue = $s ? (float)$s->fetchColumn() : 0;

$s = safeQuery($conn, "SELECT COALESCE(SUM(price), 0) FROM sold_devices WHERE sold_by = :uid AND DATE(sold_at) = CURDATE()", ['uid' => $user_id]);
$myTodaysRevenue = $s ? (float)$s->fetchColumn() : 0;

$s = safeQuery($conn, "SELECT COALESCE(SUM(price), 0) FROM sold_devices WHERE sold_by = :uid AND MONTH(sold_at) = MONTH(CURDATE()) AND YEAR(sold_at) = YEAR(CURDATE())", ['uid' => $user_id]);
$myMonthlyRevenue = $s ? (float)$s->fetchColumn() : 0;

$s = safeQuery($conn, "SELECT COUNT(*) FROM sold_devices WHERE sold_by = :uid AND MONTH(sold_at) = MONTH(CURDATE()) AND YEAR(sold_at) = YEAR(CURDATE())", ['uid' => $user_id]);
$myMonthlySales = $s ? (int)$s->fetchColumn() : 0;

$s = safeQuery($conn, "SELECT COALESCE(AVG(price), 0) FROM sold_devices WHERE sold_by = :uid", ['uid' => $user_id]);
$myAvgSalePrice = $s ? (float)$s->fetchColumn() : 0;

// Sales rank
$s = safeQuery($conn, "SELECT COUNT(*) + 1 as rank FROM (SELECT sold_by, COUNT(*) as count FROM sold_devices GROUP BY sold_by HAVING count > (SELECT COUNT(*) FROM sold_devices WHERE sold_by = :uid)) as t", ['uid' => $user_id]);
if ($s) {
    $myPerformanceRank = (int)$s->fetchColumn();
}

$s = safeQuery($conn, "SELECT COUNT(DISTINCT sold_by) FROM sold_devices");
$totalSalesTeam = $s ? (int)$s->fetchColumn() : 1;

$s = safeQuery($conn, "SELECT sd.*, c.category_name FROM sold_devices sd LEFT JOIN categories c ON sd.category_id = c.id WHERE sd.sold_by = :uid ORDER BY sd.sold_at DESC LIMIT 6", ['uid' => $user_id]);
$myRecentSales = $s ? $s->fetchAll(PDO::FETCH_ASSOC) : [];

// Recent RAM/SSD given to sales
$s = safeQuery($conn, "
    SELECT 
        l.*,
        r.type,
        r.category,
        r.storage,
        u.full_name AS given_by_name 
    FROM rams_ssds_logs l 
    LEFT JOIN rams_ssds r ON l.ram_ssd_id = r.id 
    LEFT JOIN users u ON l.given_by = u.id 
    WHERE l.given_to = :uid 
    ORDER BY l.date_given DESC 
    LIMIT 6
", ['uid' => $user_id]);

if ($s) {
    $recentRamGiven = $s->fetchAll(PDO::FETCH_ASSOC);
}

// Recent chargers given to sales
$chargerLogQuery = "
    SELECT 
        cl.*,
        c.charger_type,
        c.watts,
        c.charger_condition,
        u.full_name AS given_by_name
    FROM charger_logs cl 
    LEFT JOIN chargers c ON cl.charger_id = c.id 
    LEFT JOIN users u ON cl.given_by = u.id 
    WHERE cl.given_to = :uid
    ORDER BY cl.date_given DESC 
    LIMIT 6
";

$chargerStmt = safeQuery($conn, $chargerLogQuery, ['uid' => $user_id]);
if ($chargerStmt !== false) {
    $chargerRows = $chargerStmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($chargerRows as $row) {
        $recentChargersGivenToMe[] = [
            'id' => $row['id'] ?? null,
            'charger_label' => trim(($row['charger_type'] ?? 'Charger') . ($row['watts'] ? " {$row['watts']}W" : '')),
            'quantity_given' => (int)($row['quantity'] ?? 0),
            'given_by_name' => $row['given_by_name'] ?? '-',
            'branch' => $row['branch'] ?? null,
            'date_given' => $row['date_given'] ?? null,
            'charger_condition' => $row['charger_condition'] ?? '-',
            'raw' => $row
        ];
    }
}

// Get best selling model for this sales person
$bestModel = safeQuery($conn, "SELECT model_name, COUNT(*) AS cnt FROM sold_devices WHERE sold_by = :uid GROUP BY model_name ORDER BY cnt DESC LIMIT 1", ['uid' => $user_id]);
$bestModelData = ($bestModel && $bm = $bestModel->fetch(PDO::FETCH_ASSOC)) ? $bm : null;

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
    <title>Sales Dashboard | Mombasa Computers</title>
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

    .trend-up { 
        color: var(--success);
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
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

    .card, .section, .header-row {
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
            <div class="page-title">Sales Dashboard</div>
            <div class="welcome-text">
                <i class="fas fa-hand-wave" style="color: var(--accent); margin-right: 0.5rem;"></i>
                <?= $greeting ?>, <?= htmlspecialchars(explode(' ', $user_name)[0]) ?> • <?= date('l, F j, Y') ?>
            </div>
        </div>
        <div class="logo">
            <img src="/inventory_system/assets/MC-LOGO.png" alt="Mombasa Computers" onerror="this.style.display='none'">
        </div>
        <div>
            <a href="/inventory_system/dashboard/salesdashboard.php" class="link-btn">
                <i class="fas fa-sync-alt"></i> Refresh
            </a>
        </div>
    </div>

    <!-- Sales Metrics -->
    <div class="card-row">
        <div class="card primary">
            <h3><i class="fas fa-star"></i> Your Total Sales</h3>
            <div class="big"><?= number_format($myTotalSales) ?></div>
            <div class="small">All-time sales</div>
        </div>
        <div class="card success">
            <h3><i class="fas fa-calendar-check"></i> Today's Sales</h3>
            <div class="big"><?= number_format($myTodaysSales) ?></div>
            <div class="small">
                <span class="trend-up">
                    <i class="fas fa-arrow-up"></i> +<?= number_format($myTodaysSales) ?> today
                </span>
            </div>
        </div>
        <div class="card info">
            <h3><i class="fas fa-money-bill-wave"></i> Your Revenue</h3>
            <div class="big">Ksh <?= number_format($myTotalRevenue, 0) ?></div>
            <div class="small">Today: Ksh <?= number_format($myTodaysRevenue, 0) ?></div>
        </div>
        <div class="card warning">
            <h3><i class="fas fa-medal"></i> Your Rank</h3>
            <div class="big">#<?= number_format($myPerformanceRank) ?></div>
            <div class="small">of <?= number_format($totalSalesTeam) ?> sales staff</div>
        </div>
    </div>
    
    <div class="card-row">
        <div class="card light">
            <h3><i class="fas fa-calculator" style="color: var(--primary);"></i> Average Sale</h3>
            <div class="big">Ksh <?= number_format($myAvgSalePrice, 0) ?></div>
            <div class="small">Per transaction</div>
        </div>
        <div class="card secondary">
            <h3><i class="fas fa-calendar-alt"></i> Monthly Stats</h3>
            <div class="big">Ksh <?= number_format($myMonthlyRevenue, 0) ?></div>
            <div class="small"><?= number_format($myMonthlySales) ?> sales this month</div>
        </div>
        <div class="card primary">
            <h3><i class="fas fa-chart-pie"></i> Top Model</h3>
            <div class="big" style="font-size: 1.4rem;">
                <?php if ($bestModelData): ?>
                    <?= htmlspecialchars($bestModelData['model_name']) ?> (<?= (int)$bestModelData['cnt'] ?>)
                <?php else: ?>
                    -
                <?php endif; ?>
            </div>
            <div class="small">Most sold by you</div>
        </div>
    </div>

    <!-- Recent Sales -->
    <div class="section">
        <h4>
            <i class="fas fa-clock"></i>
            Your Recent Sales
        </h4>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Serial</th>
                        <th>Model</th>
                        <th>Category</th>
                        <th>Specs</th>
                        <th>Price</th>
                        <th>Date Sold</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(!empty($myRecentSales)): ?>
                        <?php foreach($myRecentSales as $r): ?>
                            <tr>
                                <td><code><?= htmlspecialchars($r['serial_number']) ?></code></td>
                                <td><strong><?= htmlspecialchars($r['model_name']) ?></strong></td>
                                <td><span class="badge"><?= htmlspecialchars($r['category_name'] ?? '-') ?></span></td>
                                <td><?= htmlspecialchars($r['ram']) ?>GB RAM, <?= htmlspecialchars(($r['storage_type'] ?? '') . ' ' . ($r['storage_capacity'] ?? '') . 'GB') ?></td>
                                <td><strong class="text-success">Ksh <?= number_format($r['price'] ?? 0, 0) ?></strong></td>
                                <td><?= htmlspecialchars(date('M j, Y H:i', strtotime($r['sold_at'] ?? ''))) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-muted" style="text-align:center; padding: 2.5rem;">No sales yet.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Received Items Grid -->
    <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 1.5rem; margin-bottom: 2rem;">
        <!-- RAM/SSD Received -->
        <div class="section" style="margin-bottom: 0;">
            <h4>
                <i class="fas fa-memory"></i>
                Recently Received RAM/SSD
            </h4>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr><th>Item</th><th>Storage</th><th>Qty</th><th>From</th><th>Date</th></tr>
                    </thead>
                    <tbody>
                        <?php if(!empty($recentRamGiven)): ?>
                            <?php foreach(array_slice($recentRamGiven, 0, 5) as $rg): ?>
                                <tr>
                                    <td><strong><?= htmlspecialchars($rg['type'] ?? '-') ?></strong></td>
                                    <td><?= !empty($rg['storage']) ? htmlspecialchars($rg['storage'] . 'GB') : '-' ?></td>
                                    <td><span class="badge badge-primary"><?= (int)($rg['quantity_given'] ?? $rg['quantity'] ?? 0) ?></span></td>
                                    <td><i class="fas fa-user" style="margin-right: 0.25rem;"></i><?= htmlspecialchars($rg['given_by_name'] ?? '-') ?></td>
                                    <td><?= htmlspecialchars(date('M j, Y', strtotime($rg['date_given'] ?? ''))) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="5" class="text-muted" style="text-align:center; padding: 2rem;">No recent RAM/SSD</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Chargers Received -->
        <div class="section" style="margin-bottom: 0;">
            <h4>
                <i class="fas fa-bolt"></i>
                Recently Received Chargers
            </h4>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr><th>Charger</th><th>Condition</th><th>Qty</th><th>From</th><th>Date</th></tr>
                    </thead>
                    <tbody>
                        <?php if(!empty($recentChargersGivenToMe)): ?>
                            <?php foreach(array_slice($recentChargersGivenToMe, 0, 5) as $c): ?>
                                <tr>
                                    <td><strong><?= htmlspecialchars($c['charger_label']) ?></strong></td>
                                    <td><span class="badge"><?= htmlspecialchars($c['charger_condition'] ?? '-') ?></span></td>
                                    <td><span class="badge badge-secondary"><?= (int)$c['quantity_given'] ?></span></td>
                                    <td><i class="fas fa-user" style="margin-right: 0.25rem;"></i><?= htmlspecialchars($c['given_by_name']) ?></td>
                                    <td><?= htmlspecialchars(date('M j, Y', strtotime($c['date_given'] ?? ''))) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="text-muted" style="text-align:center; padding: 2rem;">No recent chargers</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
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