<?php
session_start();
require_once "../config/db.php";
require_once "../includes/auth_check.php";
require_once "../includes/header.php";
require_once "../includes/sidebar.php";

$role = $_SESSION['role'] ?? '';
$user_id = $_SESSION['user_id'] ?? 0;
$user_name = $_SESSION['name'] ?? ($_SESSION['full_name'] ?? 'User');

// get user's branch (used for manager scoping)
$userBranch = null;
try {
    $bstmt = $conn->prepare("SELECT branch FROM users WHERE id = :id LIMIT 1");
    $bstmt->execute(['id' => $user_id]);
    $userBranch = $bstmt->fetchColumn();
} catch (Exception $e) {
    $userBranch = null;
}

function safeQuery($conn, $sql, $params = []) {
    try {
        $stmt = $conn->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    } catch (Exception $e) {
        return false;
    }
}

function tryQueries($conn, $queries, $params = []) {
    foreach ($queries as $q) {
        $stmt = safeQuery($conn, $q, $params);
        if ($stmt !== false) return $stmt;
    }
    return false;
}

// low stock items (rams_ssds + chargers)
$lowStockItems = [];
$isLowStockVisible = in_array($role, ['super_admin', 'inventory_admin', 'manager']);

// rams/ssds low stock (try a few column name patterns)
if ($isLowStockVisible) {
    $rQueries = [
        "SELECT id, category, type, storage, quantity, branch FROM rams_ssds WHERE quantity < 10",
        "SELECT id, category, type, storage, quantity, branch FROM rams_ssds WHERE quantity < 10",
        "SELECT id, category, type, NULL AS storage, quantity, branch FROM rams_ssds WHERE quantity < 10"
    ];
    $rStmt = tryQueries($conn, $rQueries);
    if ($rStmt) {
        $rows = $rStmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($rows as $r) {
            if ($role === 'manager' && $userBranch && !empty($r['branch']) && $r['branch'] !== $userBranch) {
                continue;
            }
            $r['source'] = 'ram_ssd';
            $lowStockItems[] = $r;
        }
    }

    // chargers low stock
    $cQueries = [
        "SELECT id, charger_type AS type, watts, quantity, branch FROM chargers WHERE quantity < 10",
        "SELECT id, type, watts, quantity, branch FROM chargers WHERE quantity < 10",
        "SELECT id, type, watts, quantity, NULL AS branch FROM chargers WHERE quantity < 10"
    ];
    $cStmt = tryQueries($conn, $cQueries);
    if ($cStmt) {
        $rows = $cStmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($rows as $c) {
            if ($role === 'manager' && $userBranch && !empty($c['branch']) && $c['branch'] !== $userBranch) {
                continue;
            }
            $item = [
                'id' => $c['id'] ?? null,
                'category' => 'Charger',
                'type' => $c['type'] ?? ($c['charger_type'] ?? 'Charger'),
                'storage' => $c['watts'] ?? null,
                'quantity' => $c['quantity'] ?? 0,
                'branch' => $c['branch'] ?? null,
                'source' => 'charger'
            ];
            $lowStockItems[] = $item;
        }
    }
}

// admin/inventory summary (for super_admin & inventory_admin & manager)
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
$topCategories = [];
$monthlyRevenue = 0;
$monthlySales = 0;
$totalAccessoriesGiven = 0;

if (in_array($role, ['super_admin', 'inventory_admin', 'manager'])) {
    if ($role === 'manager' && $userBranch) {
        // Total devices count
        $s = safeQuery($conn, "SELECT COUNT(*) FROM devices WHERE branch = :branch", ['branch' => $userBranch]);
        $totalDevices = $s ? (int)$s->fetchColumn() : 0;
        
        $s = safeQuery($conn, "SELECT COUNT(*) FROM devices WHERE status = 'In Stock' AND branch = :branch", ['branch' => $userBranch]);
        $totalInStock = $s ? (int)$s->fetchColumn() : 0;

        $s = safeQuery($conn, "SELECT COUNT(*) FROM devices WHERE status = 'Sold' AND branch = :branch", ['branch' => $userBranch]);
        $totalSoldDevices = $s ? (int)$s->fetchColumn() : 0;

        $s = safeQuery($conn, "SELECT COUNT(*) FROM sold_devices sd JOIN users u ON sd.sold_by = u.id WHERE u.branch = :branch", ['branch' => $userBranch]);
        $totalSalesCount = $s ? (int)$s->fetchColumn() : 0;

        $s = safeQuery($conn, "SELECT COUNT(*) FROM sold_devices sd JOIN users u ON sd.sold_by = u.id WHERE u.branch = :branch AND DATE(sd.sold_at)=CURDATE()", ['branch' => $userBranch]);
        $todaysSalesCount = $s ? (int)$s->fetchColumn() : 0;
        
        // Revenue stats
        $s = safeQuery($conn, "SELECT COALESCE(SUM(price), 0) FROM sold_devices sd JOIN users u ON sd.sold_by = u.id WHERE u.branch = :branch", ['branch' => $userBranch]);
        $totalRevenue = $s ? (float)$s->fetchColumn() : 0;
        
        $s = safeQuery($conn, "SELECT COALESCE(SUM(price), 0) FROM sold_devices sd JOIN users u ON sd.sold_by = u.id WHERE u.branch = :branch AND DATE(sd.sold_at)=CURDATE()", ['branch' => $userBranch]);
        $todaysRevenue = $s ? (float)$s->fetchColumn() : 0;
        
        // Monthly stats
        $s = safeQuery($conn, "SELECT COALESCE(SUM(price), 0) FROM sold_devices sd JOIN users u ON sd.sold_by = u.id WHERE u.branch = :branch AND MONTH(sd.sold_at)=MONTH(CURDATE()) AND YEAR(sd.sold_at)=YEAR(CURDATE())", ['branch' => $userBranch]);
        $monthlyRevenue = $s ? (float)$s->fetchColumn() : 0;
        
        $s = safeQuery($conn, "SELECT COUNT(*) FROM sold_devices sd JOIN users u ON sd.sold_by = u.id WHERE u.branch = :branch AND MONTH(sd.sold_at)=MONTH(CURDATE()) AND YEAR(sd.sold_at)=YEAR(CURDATE())", ['branch' => $userBranch]);
        $monthlySales = $s ? (int)$s->fetchColumn() : 0;
        
        // Average price
        $s = safeQuery($conn, "SELECT COALESCE(AVG(price), 0) FROM sold_devices sd JOIN users u ON sd.sold_by = u.id WHERE u.branch = :branch", ['branch' => $userBranch]);
        $avgDevicePrice = $s ? (float)$s->fetchColumn() : 0;
        
        // Top categories by sales
        $s = safeQuery($conn, "SELECT c.category_name, COUNT(*) as count FROM sold_devices sd JOIN categories c ON sd.category_id = c.id JOIN users u ON sd.sold_by = u.id WHERE u.branch = :branch GROUP BY c.category_name ORDER BY count DESC LIMIT 3", ['branch' => $userBranch]);
        if ($s) {
            $topCategories = $s->fetchAll(PDO::FETCH_ASSOC);
        }
    } else {
        // Total devices count
        $s = safeQuery($conn, "SELECT COUNT(*) FROM devices");
        $totalDevices = $s ? (int)$s->fetchColumn() : 0;
        
        $s = safeQuery($conn, "SELECT COUNT(*) FROM devices WHERE status = 'In Stock'");
        $totalInStock = $s ? (int)$s->fetchColumn() : 0;

        $s = safeQuery($conn, "SELECT COUNT(*) FROM devices WHERE status = 'Sold'");
        $totalSoldDevices = $s ? (int)$s->fetchColumn() : 0;

        $s = safeQuery($conn, "SELECT COUNT(*) FROM sold_devices");
        $totalSalesCount = $s ? (int)$s->fetchColumn() : 0;

        $s = safeQuery($conn, "SELECT COUNT(*) FROM sold_devices WHERE DATE(sold_at) = CURDATE()");
        $todaysSalesCount = $s ? (int)$s->fetchColumn() : 0;
        
        // Revenue stats
        $s = safeQuery($conn, "SELECT COALESCE(SUM(price), 0) FROM sold_devices");
        $totalRevenue = $s ? (float)$s->fetchColumn() : 0;
        
        $s = safeQuery($conn, "SELECT COALESCE(SUM(price), 0) FROM sold_devices WHERE DATE(sold_at)=CURDATE()");
        $todaysRevenue = $s ? (float)$s->fetchColumn() : 0;
        
        // Monthly stats
        $s = safeQuery($conn, "SELECT COALESCE(SUM(price), 0) FROM sold_devices WHERE MONTH(sold_at)=MONTH(CURDATE()) AND YEAR(sold_at)=YEAR(CURDATE())");
        $monthlyRevenue = $s ? (float)$s->fetchColumn() : 0;
        
        $s = safeQuery($conn, "SELECT COUNT(*) FROM sold_devices WHERE MONTH(sold_at)=MONTH(CURDATE()) AND YEAR(sold_at)=YEAR(CURDATE())");
        $monthlySales = $s ? (int)$s->fetchColumn() : 0;
        
        // Average price
        $s = safeQuery($conn, "SELECT COALESCE(AVG(price), 0) FROM sold_devices");
        $avgDevicePrice = $s ? (float)$s->fetchColumn() : 0;
        
        // Top categories by sales
        $s = safeQuery($conn, "SELECT c.category_name, COUNT(*) as count FROM sold_devices sd JOIN categories c ON sd.category_id = c.id GROUP BY c.category_name ORDER BY count DESC LIMIT 3");
        if ($s) {
            $topCategories = $s->fetchAll(PDO::FETCH_ASSOC);
        }
    }
    
    // Global stats (not branch dependent)
    // RAM/SSD inventory
    $s = safeQuery($conn, "SELECT category, SUM(quantity) as total FROM rams_ssds GROUP BY category");
    if ($s) {
        $ramSsdTotals = $s->fetchAll(PDO::FETCH_ASSOC);
        foreach ($ramSsdTotals as $item) {
            if (stripos($item['category'], 'ram') !== false) {
                $totalRamInStock += (int)$item['total'];
            } elseif (stripos($item['category'], 'ssd') !== false) {
                $totalSsdInStock += (int)$item['total'];
            }
        }
    }
    
    // Chargers inventory
    $s = safeQuery($conn, "SELECT SUM(quantity) as total FROM chargers");
    $totalChargersInStock = $s ? (int)$s->fetchColumn() : 0;
    
    // Total accessories given
    $s = safeQuery($conn, "SELECT SUM(quantity) FROM rams_ssds_logs");
    $totalAccessoriesGiven = $s ? (int)$s->fetchColumn() : 0;
    $s = safeQuery($conn, "SELECT SUM(quantity) FROM charger_logs");
    $totalAccessoriesGiven += $s ? (int)$s->fetchColumn() : 0;
    
    // Repairs stats
    $s = safeQuery($conn, "SELECT COUNT(*) FROM repairs");
    $totalRepairs = $s ? (int)$s->fetchColumn() : 0;
    
    $s = safeQuery($conn, "SELECT COUNT(*) FROM repairs WHERE fix_status = 'Not Fixed'");
    $pendingRepairs = $s ? (int)$s->fetchColumn() : 0;
    
    $s = safeQuery($conn, "SELECT COUNT(*) FROM repairs WHERE fix_status = 'Fixed'");
    $completedRepairs = $s ? (int)$s->fetchColumn() : 0;
}

// sales-specific stats (sales user)
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

if ($role === 'sales') {
    $s = safeQuery($conn, "SELECT COUNT(*) FROM sold_devices WHERE sold_by = :uid", ['uid' => $user_id]);
    $myTotalSales = $s ? (int)$s->fetchColumn() : 0;

    $s = safeQuery($conn, "SELECT COUNT(*) FROM sold_devices WHERE sold_by = :uid AND DATE(sold_at)=CURDATE()", ['uid' => $user_id]);
    $myTodaysSales = $s ? (int)$s->fetchColumn() : 0;
    
    $s = safeQuery($conn, "SELECT COALESCE(SUM(price), 0) FROM sold_devices WHERE sold_by = :uid", ['uid' => $user_id]);
    $myTotalRevenue = $s ? (float)$s->fetchColumn() : 0;
    
    $s = safeQuery($conn, "SELECT COALESCE(SUM(price), 0) FROM sold_devices WHERE sold_by = :uid AND DATE(sold_at)=CURDATE()", ['uid' => $user_id]);
    $myTodaysRevenue = $s ? (float)$s->fetchColumn() : 0;
    
    $s = safeQuery($conn, "SELECT COALESCE(SUM(price), 0) FROM sold_devices WHERE sold_by = :uid AND MONTH(sold_at)=MONTH(CURDATE()) AND YEAR(sold_at)=YEAR(CURDATE())", ['uid' => $user_id]);
    $myMonthlyRevenue = $s ? (float)$s->fetchColumn() : 0;
    
    $s = safeQuery($conn, "SELECT COUNT(*) FROM sold_devices WHERE sold_by = :uid AND MONTH(sold_at)=MONTH(CURDATE()) AND YEAR(sold_at)=YEAR(CURDATE())", ['uid' => $user_id]);
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

    $s = safeQuery($conn, "SELECT sd.*, c.category_name FROM sold_devices sd LEFT JOIN categories c ON sd.category_id=c.id WHERE sd.sold_by = :uid ORDER BY sd.sold_at DESC LIMIT 6", ['uid' => $user_id]);
    $myRecentSales = $s ? $s->fetchAll(PDO::FETCH_ASSOC) : [];
}

// software_admin / maintenance stats
$myUpdatedTotal = 0;
$myUpdatedToday = 0;
$myRecentUpdates = [];
$totalMaintenanceTasks = 0;
$mostCommonUpdate = '';

if (in_array($role, ['maintenance', 'software_admin'])) {
    $s = safeQuery($conn, "SELECT COUNT(*) FROM maintenance WHERE performed_by = :uid", ['uid' => $user_id]);
    $myUpdatedTotal = $s ? (int)$s->fetchColumn() : 0;

    $s = safeQuery($conn, "SELECT COUNT(*) FROM maintenance WHERE performed_by = :uid AND DATE(date_performed)=CURDATE()", ['uid' => $user_id]);
    $myUpdatedToday = $s ? (int)$s->fetchColumn() : 0;
    
    $s = safeQuery($conn, "SELECT COUNT(*) FROM maintenance");
    $totalMaintenanceTasks = $s ? (int)$s->fetchColumn() : 0;
    
    // Most common update type
    $s = safeQuery($conn, "SELECT 
        CASE 
            WHEN new_ram > old_ram AND new_storage > old_storage THEN 'RAM + Storage'
            WHEN new_ram > old_ram THEN 'RAM Upgrade'
            WHEN new_storage > old_storage THEN 'Storage Upgrade'
            ELSE 'Other'
        END as update_type, 
        COUNT(*) as count 
        FROM maintenance 
        GROUP BY update_type 
        ORDER BY count DESC LIMIT 1");
    if ($s && $row = $s->fetch(PDO::FETCH_ASSOC)) {
        $mostCommonUpdate = $row['update_type'] . ' (' . $row['count'] . ')';
    }

    $s = safeQuery($conn, "SELECT m.*, d.model_name FROM maintenance m LEFT JOIN devices d ON m.device_serial = d.serial_number WHERE m.performed_by = :uid ORDER BY m.date_performed DESC LIMIT 6", ['uid' => $user_id]);
    $myRecentUpdates = $s ? $s->fetchAll(PDO::FETCH_ASSOC) : [];
}

// technician stats - UPDATED for repairs table
$techTotalRepairs = 0;
$techTodayRepairs = 0;
$techPendingRepairs = 0;
$techRecentRepairs = [];
$myRepairSuccessRate = 0;
$avgRepairTime = 0;
$mostCommonIssue = '';

if ($role === 'technician') {
    // Total repairs (Fixed status and by you)
    $s = safeQuery($conn, "SELECT COUNT(*) FROM repairs WHERE added_by = :uid AND fix_status = 'Fixed'", ['uid' => $user_id]);
    $techTotalRepairs = $s ? (int)$s->fetchColumn() : 0;

    // Today's repairs (Fixed status and by you)
    $s = safeQuery($conn, "SELECT COUNT(*) FROM repairs WHERE added_by = :uid AND fix_status = 'Fixed' AND DATE(date_fixed)=CURDATE()", ['uid' => $user_id]);
    $techTodayRepairs = $s ? (int)$s->fetchColumn() : 0;

    // Pending repairs (Not Fixed status and by you)
    $s = safeQuery($conn, "SELECT COUNT(*) FROM repairs WHERE added_by = :uid AND fix_status = 'Not Fixed'", ['uid' => $user_id]);
    $techPendingRepairs = $s ? (int)$s->fetchColumn() : 0;
    
    // Success rate
    $s = safeQuery($conn, "SELECT 
        COUNT(CASE WHEN fix_status = 'Fixed' THEN 1 END) * 100.0 / COUNT(*) as success_rate 
        FROM repairs WHERE added_by = :uid", ['uid' => $user_id]);
    if ($s && $row = $s->fetch(PDO::FETCH_ASSOC)) {
        $myRepairSuccessRate = round($row['success_rate'] ?? 0, 1);
    }
    
    // Most common issue
    $s = safeQuery($conn, "SELECT problem_description, COUNT(*) as count FROM repairs WHERE added_by = :uid GROUP BY problem_description ORDER BY count DESC LIMIT 1", ['uid' => $user_id]);
    if ($s && $row = $s->fetch(PDO::FETCH_ASSOC)) {
        $mostCommonIssue = substr($row['problem_description'], 0, 30) . '...';
    }

    // Recent repairs (Fixed status and by you)
    $s = safeQuery($conn, "SELECT r.*, d.model_name FROM repairs r LEFT JOIN devices d ON r.serial_number = d.serial_number WHERE r.added_by = :uid AND r.fix_status = 'Fixed' ORDER BY r.date_fixed DESC LIMIT 6", ['uid' => $user_id]);
    $techRecentRepairs = $s ? $s->fetchAll(PDO::FETCH_ASSOC) : [];
}

// recent devices (admins or manager scoped)
$recentDevices = [];
if (in_array($role, ['super_admin', 'inventory_admin', 'manager'])) {
    if ($role === 'manager' && $userBranch) {
        $s = safeQuery($conn, "SELECT d.serial_number, d.model_name, c.category_name, d.status, d.date_added FROM devices d JOIN categories c ON d.category_id=c.id WHERE d.branch = :branch ORDER BY d.date_added DESC LIMIT 8", ['branch' => $userBranch]);
    } else {
        $s = safeQuery($conn, "SELECT d.serial_number, d.model_name, c.category_name, d.status, d.date_added FROM devices d JOIN categories c ON d.category_id=c.id ORDER BY d.date_added DESC LIMIT 8");
    }
    $recentDevices = $s ? $s->fetchAll(PDO::FETCH_ASSOC) : [];
}

// recent sold devices for super admin and manager - UPDATED
$recentSoldDevices = [];
if (in_array($role, ['super_admin', 'manager'])) {
    if ($role === 'manager' && $userBranch) {
        // For manager: need to join with devices table to get branch info
        $s = safeQuery($conn, "
            SELECT sd.*, d.model_name, c.category_name, u.full_name as sold_by_name, d.branch
            FROM sold_devices sd 
            JOIN devices d ON sd.serial_number = d.serial_number
            LEFT JOIN categories c ON sd.category_id = c.id
            LEFT JOIN users u ON sd.sold_by = u.id
            WHERE d.branch = :branch 
            ORDER BY sd.sold_at DESC LIMIT 8
        ", ['branch' => $userBranch]);
    } else {
        // For super_admin: can select directly from sold_devices
        $s = safeQuery($conn, "
            SELECT sd.*, c.category_name, u.full_name as sold_by_name
            FROM sold_devices sd 
            LEFT JOIN categories c ON sd.category_id = c.id
            LEFT JOIN users u ON sd.sold_by = u.id
            ORDER BY sd.sold_at DESC LIMIT 8
        ");
    }
    $recentSoldDevices = $s ? $s->fetchAll(PDO::FETCH_ASSOC) : [];
}

// recent activity logs (super_admin)
$recentActivities = [];
if ($role === 'super_admin') {
    $s = safeQuery($conn, "SELECT a.*, u.full_name AS done_by_name FROM activity_logs a LEFT JOIN users u ON a.user_id = u.id ORDER BY a.created_at DESC LIMIT 8");
    $recentActivities = $s ? $s->fetchAll(PDO::FETCH_ASSOC) : [];
}

// recent RAM/SSD given to sales (sales sees what was given to them) - CORRECTED
$recentRamGiven = [];
if ($role === 'sales') {
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
}

// recent chargers lists (scoped by role & manager branch) - CORRECTED
$recentChargersGivenToMe = [];
$recentChargersGivenByMe = [];
$recentChargersAll = [];

// For inventory admin: Get all charger logs given by current user
$inventoryAdminChargersGiven = [];
// For inventory admin: Get all RAM/SSD logs given by current user
$inventoryAdminRamSsdGiven = [];

$chargerLogQuery = "
    SELECT 
        cl.*,
        c.charger_type,
        c.watts,
        u.full_name AS given_to_name,
        ub.full_name AS given_by_name
    FROM charger_logs cl 
    LEFT JOIN chargers c ON cl.charger_id = c.id 
    LEFT JOIN users u ON cl.given_to = u.id 
    LEFT JOIN users ub ON cl.given_by = ub.id 
    ORDER BY cl.date_given DESC 
    LIMIT 12
";

$allLogsStmt = safeQuery($conn, $chargerLogQuery);
if ($allLogsStmt !== false) {
    $allRows = $allLogsStmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($allRows as $row) {
        $qty = $row['quantity'] ?? 0;
        $ctype = $row['charger_type'] ?? null;
        $cwatts = $row['watts'] ?? null;
        $ccond = $row['charger_condition'] ?? null;
        $branchVal = $row['branch'] ?? null;

        // manager sees only branch items
        if ($role === 'manager' && $userBranch && !empty($branchVal) && $branchVal !== $userBranch) {
            continue;
        }

        $item = [
            'id' => $row['id'] ?? null,
            'charger_label' => trim(($ctype ? $ctype : 'Charger') . ($cwatts ? " {$cwatts}W" : '')),
            'quantity_given' => (int)$qty,
            'given_to_name' => $row['given_to_name'] ?? '-',
            'given_by_name' => $row['given_by_name'] ?? '-',
            'branch' => $branchVal,
            'date_given' => $row['date_given'] ?? null,
            'raw' => $row
        ];

        if ($role === 'sales' && isset($row['given_to']) && (int)$row['given_to'] === (int)$user_id) {
            $recentChargersGivenToMe[] = $item;
        }
        if (in_array($role, ['maintenance']) && isset($row['given_by']) && (int)$row['given_by'] === (int)$user_id) {
            $recentChargersGivenByMe[] = $item;
        }
        if (in_array($role, ['inventory_admin','super_admin','manager'])) {
            $recentChargersAll[] = $item;
        }
        
        // For inventory admin: store chargers given by current user
        if ($role === 'inventory_admin' && isset($row['given_by']) && (int)$row['given_by'] === (int)$user_id) {
            $inventoryAdminChargersGiven[] = $item;
        }
    }
}

// Get RAM/SSD logs given by inventory admin
if ($role === 'inventory_admin') {
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
}

function fmtDate($d) {
    if (!$d) return '-';
    $ts = strtotime($d);
    if ($ts === false) return htmlspecialchars($d);
    return date('Y-m-d H:i:s', $ts);
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
    <title>Dashboard | Mombasa Computers</title>
    <style>
    /* ===== PROFESSIONAL DASHBOARD STYLING ===== */
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

    /* Import Inter font */
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

    /* Main Content Area - FIXED for mobile */
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

    /* Header Row */
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

    /* Metric Cards Grid - RESPONSIVE */
    .card-row { 
        display: grid; 
        grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
        gap: 1.5rem; 
        margin-bottom: 2rem; 
    }

    /* Card Styles */
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
        min-width: 0; /* Prevent overflow */
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

    /* Card Color Variants */
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

    /* Low Stock Banner - RESPONSIVE */
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

    .banner .link-btn:last-child {
        background: var(--secondary) !important;
    }

    .banner .link-btn:last-child:hover {
        background: var(--secondary-light) !important;
    }

    /* Section Cards */
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

    /* Table Styles - RESPONSIVE */
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

    .table tbody tr {
        transition: background-color 0.15s ease;
    }

    .table tbody tr:hover {
        background-color: var(--gray-50);
    }

    .table tbody tr:last-child td {
        border-bottom: none;
    }

    /* Code/Styled Text */
    .table code {
        background: var(--gray-100);
        padding: 0.2rem 0.4rem;
        border-radius: var(--radius-sm);
        font-family: monospace;
        font-size: 0.9rem;
        color: var(--primary-dark);
        word-break: break-all;
    }

    /* Status Indicators */
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
    .status-sold { 
        background: var(--gray-400);
        box-shadow: 0 0 0 2px rgba(156, 163, 175, 0.2);
    }
    .status-pending { 
        background: var(--warning);
        box-shadow: 0 0 0 2px rgba(245, 158, 11, 0.2);
    }
    .status-fixed { 
        background: var(--success);
        box-shadow: 0 0 0 2px rgba(5, 150, 105, 0.2);
    }

    /* Badges */
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

    .badge-success {
        background: var(--success);
        color: white;
    }

    .badge-warning {
        background: var(--warning);
        color: white;
    }

    /* Top Categories Grid - RESPONSIVE */
    .top-categories {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 1.5rem;
        margin-top: 1rem;
    }

    .category-badge {
        padding: 1.5rem;
        background: var(--gray-50);
        border-radius: var(--radius-lg);
        text-align: center;
        border: 1px solid var(--gray-200);
        transition: all 0.2s ease;
    }

    .category-badge:hover {
        background: white;
        border-color: var(--primary-light);
        transform: translateY(-4px);
        box-shadow: var(--shadow-md);
    }

    .category-badge .count {
        font-size: 2rem;
        font-weight: 700;
        color: var(--primary);
        line-height: 1.2;
        margin-bottom: 0.5rem;
    }

    .category-badge .name {
        font-size: 1rem;
        color: var(--gray-600);
        font-weight: 500;
        word-break: break-word;
    }

    /* Trend Indicators */
    .trend-up { 
        color: var(--success);
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
    }
    .trend-down { 
        color: var(--danger);
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
    }

    /* Link Button */
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

    .link-btn:active {
        transform: translateY(0);
        box-shadow: var(--shadow-sm);
    }

    .link-btn i {
        font-size: 1rem;
    }

    /* Footer */
    footer {
        text-align: center;
        padding: 2rem 0 0.5rem;
        margin-top: 2rem;
        font-size: 0.9rem;
        color: var(--gray-500);
        border-top: 1px solid var(--gray-200);
    }

    /* Animation */
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

    /* RESPONSIVE DESIGN - CRITICAL FIXES */
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
        padding-right: 70px; /* ADD THIS - creates space for logo */
    }
    
    .header-row .logo {
        position: absolute;
        top: 1.25rem;
        right: 1.25rem;
    }
    
    .page-title {
        font-size: 1.75rem !important;
        padding-right: 0; /* CHANGE THIS from 60px to 0 */
        width: calc(100% - 60px); /* ADD THIS - ensures text doesn't go under logo */
    }
    
    .welcome-text {
        width: calc(100% - 60px); /* ADD THIS - keeps welcome text away from logo */
        font-size: 0.85rem !important;
    }
        
        .card-row {
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)) !important;
            gap: 1rem !important;
        }
        
        .card {
            padding: 1.25rem !important;
        }
        
        .card .big {
            font-size: 2rem !important;
        }
        
        .section {
            padding: 1.5rem !important;
        }
        
        .section h4 {
            font-size: 1.1rem !important;
            margin-bottom: 1.25rem !important;
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
        
        .top-categories {
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)) !important;
            gap: 1rem !important;
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
        
        .welcome-text {
            font-size: 0.9rem !important;
        }
        
        .logo img {
            height: 40px !important;
        }
        
        .card .big {
            font-size: 1.75rem !important;
        }
        
        .card h3 {
            font-size: 0.85rem !important;
        }
        
        .section {
            padding: 1.25rem !important;
        }
        
        .table td,
        .table th {
            padding: 0.75rem !important;
            font-size: 0.9rem !important;
        }
        
        .table {
            min-width: 550px;
        }
        
        .top-categories {
            grid-template-columns: repeat(2, 1fr) !important;
            gap: 0.75rem !important;
        }
        
        .category-badge {
            padding: 1rem !important;
        }
        
        .category-badge .count {
            font-size: 1.5rem !important;
        }
        
        .category-badge .name {
            font-size: 0.9rem !important;
        }
    }

    @media (max-width: 480px) {
        .main-content {
            padding: 0.75rem 0.5rem 0.5rem !important;
            padding-top: 4rem !important;
        }
        
        .header-row {
            padding: 1rem !important;
        }
        
        .page-title {
            font-size: 1.25rem !important;
        }
        
        .card .big {
            font-size: 1.5rem !important;
        }
        
        .card .small {
            font-size: 0.8rem !important;
        }
        
        .card-row {
            grid-template-columns: 1fr !important;
            gap: 0.75rem !important;
        }
        
        .table {
            min-width: 500px !important;
        }
        
        .table td,
        .table th {
            padding: 0.625rem !important;
            font-size: 0.85rem !important;
        }
        
        .top-categories {
            grid-template-columns: 1fr !important;
        }
        
        .banner .title {
            font-size: 1rem !important;
        }
        
        .banner .small {
            font-size: 0.85rem !important;
        }
        
        footer {
            font-size: 0.75rem !important;
            padding: 1.5rem 0 0.5rem !important;
        }
        
        .badge {
            font-size: 0.75rem !important;
            padding: 0.2rem 0.5rem !important;
        }
        .header-row {
        padding-right: 60px !important;
    }
    
    .page-title {
        font-size: 1.25rem !important;
        width: calc(100% - 50px) !important;
    }
    
    .welcome-text {
        width: calc(100% - 50px) !important;
        font-size: 0.75rem !important;
    }
    
    .header-row .logo img {
        height: 35px !important;
    }

    }

    /* Desktop Sidebar Active */
    @media (min-width: 1201px) and (max-width: 1400px) {
        .card-row {
            grid-template-columns: repeat(2, 1fr) !important;
        }
    }

    /* Print Styles */
    @media print {
        .main-content {
            margin: 0;
            padding: 1rem;
            background: white;
        }
        
        .header-row,
        .banner,
        .link-btn,
        footer,
        .sidebar-toggle {
            display: none;
        }
        
        .card {
            break-inside: avoid;
            border: 1px solid var(--gray-300);
            background: white !important;
            color: black !important;
            box-shadow: none;
        }
        
        .card .big {
            color: black !important;
        }
        
        .table th {
            background: var(--gray-200) !important;
            color: black !important;
        }
        
        .sidebar {
            display: none !important;
        }
    }

    /* Utility Classes */
    .text-success { color: var(--success); }
    .text-warning { color: var(--warning); }
    .text-danger { color: var(--danger); }
    .text-primary { color: var(--primary); }
    .text-secondary { color: var(--secondary); }
    .text-muted { color: var(--gray-400); }

    .bg-light { background: var(--gray-50); }
    .bg-white { background: white; }

    .font-bold { font-weight: 700; }
    .font-semibold { font-weight: 600; }
    .font-medium { font-weight: 500; }

    .mb-0 { margin-bottom: 0; }
    .mt-2 { margin-top: 0.5rem; }
    .mt-4 { margin-top: 1rem; }
    .mb-4 { margin-bottom: 1rem; }

    .d-flex { display: flex; }
    .align-center { align-items: center; }
    .justify-between { justify-content: space-between; }
    .gap-2 { gap: 0.5rem; }
    .gap-4 { gap: 1rem; }
    .gap-6 { gap: 1.5rem; }

    .flex-wrap { flex-wrap: wrap; }
    .flex-nowrap { flex-wrap: nowrap; }

    .w-100 { width: 100%; }
    .h-100 { height: 100%; }

    .rounded { border-radius: var(--radius-md); }
    .rounded-lg { border-radius: var(--radius-lg); }
    .rounded-xl { border-radius: var(--radius-xl); }

    .shadow-sm { box-shadow: var(--shadow-sm); }
    .shadow-md { box-shadow: var(--shadow-md); }
    .shadow-lg { box-shadow: var(--shadow-lg); }
    </style>

    <!-- Font Awesome 6 (Free) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>

<div class="main-content">
    <div class="header-row">
        <div>
            <div class="page-title">Dashboard</div>
            <div class="welcome-text">
                <i class="fas fa-hand-wave" style="color: var(--accent); margin-right: 0.5rem;"></i>
                <?= $greeting ?>, <?= htmlspecialchars(explode(' ', $user_name)[0]) ?> • <?= date('l, F j, Y') ?>
            </div>
        </div><br>
        <div class="logo">
            <img src="/inventory_system/assets/MC-LOGO.png" alt="Mombasa Computers" onerror="this.style.display='none'">
        </div>
        <div>
            <a href="/inventory_system/dashboard/index.php" class="link-btn">
                <i class="fas fa-sync-alt"></i> Refresh
            </a>
        </div>
    </div>

    <?php if ($isLowStockVisible && !empty($lowStockItems)): ?>
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

    <?php if (in_array($role, ['super_admin','inventory_admin','manager'])): ?>
        <!-- First Row - Core Metrics -->
        <div class="card-row">
            <div class="card success">
                <h3><i class="fas fa-box"></i> In Stock</h3>
                <div class="big"><?= number_format($totalInStock) ?></div>
                <div class="small">
                    <span class="status-indicator status-instock"></span>
                    of <?= number_format($totalDevices) ?> total devices
                </div>
            </div>

            <div class="card primary">
                <h3><i class="fas fa-shopping-cart"></i> Sold Devices</h3>
                <div class="big"><?= number_format($totalSoldDevices) ?></div>
                <div class="small">
                    <i class="fas fa-chart-line"></i>
                    <?= $totalDevices > 0 ? round(($totalSoldDevices/$totalDevices)*100, 1) : 0 ?>% of inventory
                </div>
            </div>

            <div class="card info">
                <h3><i class="fas fa-chart-bar"></i> Total Sales</h3>
                <div class="big"><?= number_format($totalSalesCount) ?></div>
                <div class="small">All-time transactions</div>
            </div>

            <div class="card warning">
                <h3><i class="fas fa-calendar-day"></i> Today's Sales</h3>
                <div class="big"><?= number_format($todaysSalesCount) ?></div>
                <div class="small">
                    <span class="trend-up">
                        <i class="fas fa-arrow-up"></i> <?= number_format($todaysSalesCount) ?> today
                    </span>
                </div>
            </div>
        </div>
        
        <!-- Second Row - Financial & Inventory Metrics -->
        <div class="card-row">
            <div class="card light">
                <h3><i class="fas fa-coins" style="color: var(--accent);"></i> Total Revenue</h3>
                <div class="big">Ksh <?= number_format($totalRevenue, 0) ?></div>
                <div class="small">Avg: Ksh <?= number_format($avgDevicePrice, 0) ?>/device</div>
            </div>
            
            <div class="card secondary">
                <h3><i class="fas fa-wallet"></i> Today's Revenue</h3>
                <div class="big">Ksh <?= number_format($todaysRevenue, 0) ?></div>
                <div class="small">
                    <?= $todaysSalesCount > 0 ? 'Ksh '.number_format($todaysRevenue/$todaysSalesCount, 0) : 0 ?>/sale avg
                </div>
            </div>
            
            <div class="card light">
                <h3><i class="fas fa-microchip" style="color: var(--secondary);"></i> Monthly Stats</h3>
                <div class="big">Ksh <?= number_format($monthlyRevenue, 0) ?></div>
                <div class="small"><?= number_format($monthlySales) ?> sales this month</div>
            </div>
            
            <div class="card primary">
                <h3><i class="fas fa-tools"></i> Repairs</h3>
                <div class="big"><?= number_format($totalRepairs) ?></div>
                <div class="small">
                    <span class="text-success"><?= number_format($completedRepairs) ?> fixed</span> • 
                    <span class="text-warning"><?= number_format($pendingRepairs) ?> pending</span>
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
                <h3><i class="fas fa-hand-holding-heart" style="color: var(--success);"></i> Accessories Given</h3>
                <div class="big"><?= number_format($totalAccessoriesGiven) ?></div>
                <div class="small">Total distributed</div>
            </div>
        </div>
        
        <!-- Top Categories Section -->
        <?php if (!empty($topCategories)): ?>
        <div class="section">
            <h4>
                <i class="fas fa-trophy" style="color: var(--accent);"></i>
                Top Selling Categories
            </h4>
            <div class="top-categories">
                <?php foreach($topCategories as $cat): ?>
                <div class="category-badge">
                    <div class="count"><?= number_format($cat['count']) ?></div>
                    <div class="name"><?= htmlspecialchars($cat['category_name']) ?></div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>

        <!-- Recently Added Devices -->
        <div class="section">
            <h4>
                <i class="fas fa-plus-circle" style="color: var(--success);"></i>
                Recently Added Devices
            </h4>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Serial Number</th>
                            <th>Model</th>
                            <th>Category</th>
                            <th>Status</th>
                            <th>Date Added</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if(!empty($recentDevices)): ?>
                        <?php foreach($recentDevices as $d): ?>
                            <tr>
                                <td><code><?= htmlspecialchars($d['serial_number']) ?></code></td>
                                <td><strong><?= htmlspecialchars($d['model_name']) ?></strong></td>
                                <td><span class="badge"><?= htmlspecialchars($d['category_name']) ?></span></td>
                                <td>
                                    <?php if($d['status'] == 'In Stock'): ?>
                                        <span class="status-indicator status-instock"></span>
                                        <span class="text-success">In Stock</span>
                                    <?php else: ?>
                                        <span class="status-indicator status-sold"></span>
                                        <span class="text-muted">Sold</span>
                                    <?php endif; ?>
                                </td>
                                <td><?= htmlspecialchars(date('M j, Y H:i', strtotime($d['date_added'] ?? '')) ) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="5" class="text-muted" style="text-align:center; padding: 2.5rem;">No recent devices found.</td></tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <?php if (in_array($role, ['super_admin', 'manager'])): ?>
        <!-- Recently Sold Devices -->
        <div class="section">
            <h4>
                <i class="fas fa-tags" style="color: var(--primary);"></i>
                Recently Sold Devices
            </h4>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Serial</th>
                            <th>Model</th>
                            <th>Category</th>
                            <th>Specs</th>
                            <th>Sold By</th>
                            <th>Price</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if(!empty($recentSoldDevices)): ?>
                        <?php foreach($recentSoldDevices as $sold): ?>
                            <tr>
                                <td><code><?= htmlspecialchars($sold['serial_number']) ?></code></td>
                                <td><strong><?= htmlspecialchars($sold['model_name'] ?? '-') ?></strong></td>
                                <td><span class="badge"><?= htmlspecialchars($sold['category_name'] ?? '-') ?></span></td>
                                <td>
                                    <?= htmlspecialchars($sold['processor'] ?? '-') ?>, 
                                    <?= htmlspecialchars($sold['ram'] ?? '') ?>GB, 
                                    <?php if(!empty($sold['storage_type']) && !empty($sold['storage_capacity'])): ?>
                                        <?= htmlspecialchars($sold['storage_type']) ?> <?= htmlspecialchars($sold['storage_capacity']) ?>GB
                                    <?php else: ?>
                                        -
                                    <?php endif; ?>
                                </td>
                                <td><i class="fas fa-user" style="margin-right: 0.25rem; color: var(--gray-400);"></i><?= htmlspecialchars($sold['sold_by_name'] ?? '-') ?></td>
                                <td><strong class="text-success">Ksh <?= number_format($sold['price'] ?? 0, 0) ?></strong></td>
                                <td><?= htmlspecialchars(date('M j, Y H:i', strtotime($sold['sold_at'] ?? ''))) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="7" class="text-muted" style="text-align:center; padding: 2.5rem;">No recent sold devices found.</td></tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php endif; ?>

        <?php if ($role === 'super_admin'): ?>
            <!-- Activity Logs -->
            <div class="section">
                <h4>
                    <i class="fas fa-history" style="color: var(--gray-600);"></i>
                    Recent Activity Logs
                </h4>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>User</th>
                                <th>Action</th>
                                <th>Details</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php if(!empty($recentActivities)): ?>
                            <?php $k=1; foreach($recentActivities as $a): ?>
                                <tr>
                                    <td><span class="badge"><?= $k++ ?></span></td>
                                    <td><strong><?= htmlspecialchars($a['done_by_name'] ?? '-') ?></strong></td>
                                    <td><span class="badge badge-primary"><?= htmlspecialchars($a['action'] ?? '-') ?></span></td>
                                    <td><?= htmlspecialchars(substr($a['details'] ?? '-',0,100)) ?></td>
                                    <td><?= htmlspecialchars(date('M j, Y H:i', strtotime($a['created_at'] ?? ''))) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="5" class="text-muted" style="text-align:center; padding: 2.5rem;">No recent activity.</td></tr>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php endif; ?>
        
    <?php endif; ?>

    <?php if ($role === 'sales'): ?>
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
                <?php
                    $bestModel = safeQuery($conn, "SELECT model_name, COUNT(*) AS cnt FROM sold_devices WHERE sold_by=:uid GROUP BY model_name ORDER BY cnt DESC LIMIT 1", ['uid'=>$user_id]);
                    if ($bestModel && $bm = $bestModel->fetch(PDO::FETCH_ASSOC)) {
                        echo htmlspecialchars($bm['model_name']) . " (" . (int)$bm['cnt'] . ")";
                    } else {
                        echo "-";
                    }
                ?>
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
                    <thead><tr><th>Serial</th><th>Model</th><th>Category</th><th>Specs</th><th>Date Sold</th></tr></thead>
                    <tbody>
                        <?php if(!empty($myRecentSales)): foreach($myRecentSales as $r): ?>
                            <tr>
                                <td><code><?= htmlspecialchars($r['serial_number']) ?></code></td>
                                <td><strong><?= htmlspecialchars($r['model_name']) ?></strong></td>
                                <td><span class="badge"><?= htmlspecialchars($r['category_name'] ?? '-') ?></span></td>
                                <td><?= htmlspecialchars($r['ram']) ?>GB RAM, <?= htmlspecialchars(($r['storage_type'] ?? '') . ' ' . ($r['storage_capacity'] ?? '') . 'GB') ?></td>
                                <td><?= htmlspecialchars(date('M j, Y H:i', strtotime($r['sold_at'] ?? ''))) ?></td>
                            </tr>
                        <?php endforeach; else: ?>
                            <tr><td colspan="5" class="text-muted" style="text-align:center; padding: 2.5rem;">No sales yet.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Received Items Grid -->
        <div class="card-row" style="grid-template-columns: repeat(2, 1fr);">
            <!-- RAM/SSD Received -->
            <div class="section" style="margin-bottom: 0;">
                <h4>
                    <i class="fas fa-memory"></i>
                    Recently Received RAM/SSD
                </h4>
                <div class="table-responsive">
                    <table class="table">
                        <thead><tr><th>Item</th><th>Storage</th><th>Qty</th><th>From</th><th>Date</th></tr></thead>
                        <tbody>
                        <?php if(!empty($recentRamGiven)): foreach(array_slice($recentRamGiven, 0, 5) as $rg): ?>
                            <tr>
                                <td><strong><?= htmlspecialchars($rg['type'] ?? '-') ?></strong></td>
                                <td><?= !empty($rg['storage']) ? htmlspecialchars($rg['storage'] . 'GB') : '-' ?></td>
                                <td><span class="badge badge-primary"><?= (int)($rg['quantity_given'] ?? $rg['quantity'] ?? 0) ?></span></td>
                                <td><i class="fas fa-user" style="margin-right: 0.25rem;"></i><?= htmlspecialchars($rg['given_by_name'] ?? '-') ?></td>
                                <td><?= htmlspecialchars(date('M j, Y', strtotime($rg['date_given'] ?? ''))) ?></td>
                            </tr>
                        <?php endforeach; else: ?>
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
                        <thead><tr><th>Charger</th><th>Condition</th><th>Qty</th><th>From</th><th>Date</th></tr></thead>
                        <tbody>
                            <?php if(!empty($recentChargersGivenToMe)): foreach(array_slice($recentChargersGivenToMe, 0, 5) as $c): ?>
                                <tr>
                                    <td><strong><?= htmlspecialchars($c['charger_label']) ?></strong></td>
                                    <td><span class="badge"><?= htmlspecialchars($c['raw']['charger_condition'] ?? '-') ?></span></td>
                                    <td><span class="badge badge-secondary"><?= (int)$c['quantity_given'] ?></span></td>
                                    <td><i class="fas fa-user" style="margin-right: 0.25rem;"></i><?= htmlspecialchars($c['given_by_name']) ?></td>
                                    <td><?= htmlspecialchars(date('M j, Y', strtotime($c['date_given'] ?? ''))) ?></td>
                                </tr>
                            <?php endforeach; else: ?>
                                <tr><td colspan="5" class="text-muted" style="text-align:center; padding: 2rem;">No recent chargers</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <?php if (in_array($role, ['maintenance','software_admin'])): ?>
        <div class="card-row">
            <div class="card primary">
                <h3><i class="fas fa-tasks"></i> Your Updates</h3>
                <div class="big"><?= number_format($myUpdatedTotal) ?></div>
                <div class="small">All-time updates</div>
            </div>
            <div class="card success">
                <h3><i class="fas fa-calendar-day"></i> Today's Updates</h3>
                <div class="big"><?= number_format($myUpdatedToday) ?></div>
                <div class="small">
                    <span class="trend-up">
                        <i class="fas fa-arrow-up"></i> +<?= number_format($myUpdatedToday) ?> today
                    </span>
                </div>
            </div>
            <div class="card info">
                <h3><i class="fas fa-database"></i> System Total</h3>
                <div class="big"><?= number_format($totalMaintenanceTasks) ?></div>
                <div class="small">Total maintenance tasks</div>
            </div>
            <div class="card warning">
                <h3><i class="fas fa-chart-bar"></i> Common Update</h3>
                <div class="big" style="font-size: 1.2rem;"><?= htmlspecialchars($mostCommonUpdate) ?></div>
                <div class="small">Most frequent type</div>
            </div>
        </div>

        <div class="section">
            <h4>
                <i class="fas fa-history"></i>
                Your Recent Updates
            </h4>
            <div class="table-responsive">
                <table class="table">
                    <thead><tr><th>Serial</th><th>Model</th><th>Change</th><th>Date</th></tr></thead>
                    <tbody>
                        <?php if(!empty($myRecentUpdates)): foreach($myRecentUpdates as $u): ?>
                            <tr>
                                <td><code><?= htmlspecialchars($u['device_serial']) ?></code></td>
                                <td><strong><?= htmlspecialchars($u['model_name'] ?? '-') ?></strong></td>
                                <td>
                                    <span class="badge badge-success">RAM: <?= htmlspecialchars($u['old_ram'] ?? 'N/A') ?>GB → <?= htmlspecialchars($u['new_ram'] ?? 'N/A') ?>GB</span><br>
                                    <span class="badge badge-info" style="margin-top: 0.25rem;">Storage: <?= htmlspecialchars($u['old_storage'] ?? 'N/A') ?>GB → <?= htmlspecialchars($u['new_storage'] ?? 'N/A') ?>GB</span>
                                 </td>
                                <td><?= htmlspecialchars(date('M j, Y H:i', strtotime($u['date_performed'] ?? $u['created_at'] ?? ''))) ?></td>
                            </tr>
                        <?php endforeach; else: ?>
                            <tr><td colspan="4" class="text-muted" style="text-align:center; padding: 2.5rem;">No recent updates.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="section">
            <h4>
                <i class="fas fa-bolt"></i>
                Recently Given Chargers
            </h4>
            <div class="table-responsive">
                <table class="table">
                    <thead><tr><th>Charger</th><th>Condition</th><th>Qty</th><th>Given To</th><th>Date</th></tr></thead>
                    <tbody>
                        <?php if(!empty($recentChargersGivenByMe)): foreach(array_slice($recentChargersGivenByMe, 0, 6) as $c): ?>
                            <tr>
                                <td><strong><?= htmlspecialchars($c['charger_label']) ?></strong></td>
                                <td><span class="badge"><?= htmlspecialchars($c['raw']['charger_condition'] ?? '-') ?></span></td>
                                <td><span class="badge badge-primary"><?= (int)$c['quantity_given'] ?></span></td>
                                <td><i class="fas fa-user" style="margin-right: 0.25rem;"></i><?= htmlspecialchars($c['given_to_name']) ?></td>
                                <td><?= htmlspecialchars(date('M j, Y', strtotime($c['date_given'] ?? ''))) ?></td>
                            </tr>
                        <?php endforeach; else: ?>
                            <tr><td colspan="5" class="text-muted" style="text-align:center; padding: 2.5rem;">No chargers given by you recently.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php endif; ?>

    <?php if ($role === 'technician'): ?>
        <div class="card-row">
            <div class="card success">
                <h3><i class="fas fa-wrench"></i> Completed Repairs</h3>
                <div class="big"><?= number_format($techTotalRepairs) ?></div>
                <div class="small">Repairs completed by you</div>
            </div>
            <div class="card primary">
                <h3><i class="fas fa-calendar-day"></i> Today's Repairs</h3>
                <div class="big"><?= number_format($techTodayRepairs) ?></div>
                <div class="small">
                    <span class="trend-up">
                        <i class="fas fa-arrow-up"></i> +<?= number_format($techTodayRepairs) ?> today
                    </span>
                </div>
            </div>
            <div class="card warning">
                <h3><i class="fas fa-hourglass-half"></i> Pending Repairs</h3>
                <div class="big"><?= number_format($techPendingRepairs) ?></div>
                <div class="small">Awaiting completion</div>
            </div>
            <div class="card info">
                <h3><i class="fas fa-percent"></i> Success Rate</h3>
                <div class="big"><?= number_format($myRepairSuccessRate) ?>%</div>
                <div class="small">Your repair success rate</div>
            </div>
        </div>
        
        <div class="card-row">
            <div class="card light">
                <h3><i class="fas fa-exclamation-circle" style="color: var(--warning);"></i> Most Common Issue</h3>
                <div class="big" style="font-size: 1.2rem;"><?= htmlspecialchars($mostCommonIssue) ?></div>
                <div class="small">Frequently reported problem</div>
            </div>
        </div>

        <div class="section">
            <h4>
                <i class="fas fa-clipboard-check"></i>
                Recently Repaired Devices
            </h4>
            <div class="table-responsive">
                <table class="table">
                    <thead><tr><th>Serial</th><th>Model</th><th>Issue</th><th>Date Fixed</th></tr></thead>
                    <tbody>
                        <?php if(!empty($techRecentRepairs)): foreach($techRecentRepairs as $r): ?>
                            <tr>
                                <td><code><?= htmlspecialchars($r['serial_number']) ?></code></td>
                                <td><strong><?= htmlspecialchars($r['model_name'] ?? '-') ?></strong></td>
                                <td><?= htmlspecialchars(substr($r['problem_description'] ?? '-', 0, 80)) ?></td>
                                <td><?= htmlspecialchars(date('M j, Y H:i', strtotime($r['date_fixed'] ?? ''))) ?></td>
                            </tr>
                        <?php endforeach; else: ?>
                            <tr><td colspan="4" class="text-muted" style="text-align:center; padding: 2.5rem;">No recent repairs.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php endif; ?>

    <?php if ($role === 'inventory_admin'): ?>
        <!-- Inventory Admin Stats -->
        <div class="card-row">
            <div class="card primary">
                <h3><i class="fas fa-memory"></i> RAM In Stock</h3>
                <div class="big"><?= number_format($totalRamInStock) ?></div>
                <div class="small">Total units available</div>
            </div>
            <div class="card success">
                <h3><i class="fas fa-database"></i> SSD In Stock</h3>
                <div class="big"><?= number_format($totalSsdInStock) ?></div>
                <div class="small">Total units available</div>
            </div>
            <div class="card info">
                <h3><i class="fas fa-bolt"></i> Chargers In Stock</h3>
                <div class="big"><?= number_format($totalChargersInStock) ?></div>
                <div class="small">Total units available</div>
            </div>
            <div class="card warning">
                <h3><i class="fas fa-hand-holding-heart"></i> Total Given</h3>
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
                    <thead><tr><th>Item</th><th>Category</th><th>Storage</th><th>Qty</th><th>Given To</th><th>Date</th></tr></thead>
                    <tbody>
                        <?php if(!empty($inventoryAdminRamSsdGiven)): foreach($inventoryAdminRamSsdGiven as $ram): ?>
                            <tr>
                                <td><strong><?= htmlspecialchars($ram['type'] ?? '-') ?></strong></td>
                                <td><span class="badge"><?= htmlspecialchars($ram['category'] ?? '-') ?></span></td>
                                <td><?= !empty($ram['storage']) ? htmlspecialchars($ram['storage'] . 'GB') : '-' ?></td>
                                <td><span class="badge badge-primary"><?= (int)$ram['quantity_given'] ?></span></td>
                                <td><i class="fas fa-user" style="margin-right: 0.25rem;"></i><?= htmlspecialchars($ram['given_to_name'] ?? '-') ?></td>
                                <td><?= htmlspecialchars(date('M j, Y', strtotime($ram['date_given'] ?? ''))) ?></td>
                            </tr>
                        <?php endforeach; else: ?>
                            <tr><td colspan="6" class="text-muted" style="text-align:center; padding: 2.5rem;">No RAM/SSD given by you recently.</td></tr>
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
                    <thead><tr><th>Charger</th><th>Condition</th><th>Watts</th><th>Qty</th><th>Given To</th><th>Date</th></tr></thead>
                    <tbody>
                        <?php if(!empty($inventoryAdminChargersGiven)): foreach($inventoryAdminChargersGiven as $c): ?>
                            <tr>
                                <td><strong><?= htmlspecialchars($c['charger_label']) ?></strong></td>
                                <td><span class="badge"><?= htmlspecialchars($c['raw']['charger_condition'] ?? '-') ?></span></td>
                                <td><?= htmlspecialchars($c['raw']['watts'] ?? '-') ?>W</td>
                                <td><span class="badge badge-secondary"><?= (int)$c['quantity_given'] ?></span></td>
                                <td><i class="fas fa-user" style="margin-right: 0.25rem;"></i><?= htmlspecialchars($c['given_to_name']) ?></td>
                                <td><?= htmlspecialchars(date('M j, Y', strtotime($c['date_given'] ?? ''))) ?></td>
                            </tr>
                        <?php endforeach; else: ?>
                            <tr><td colspan="6" class="text-muted" style="text-align:center; padding: 2.5rem;">No chargers given by you recently.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php endif; ?>

    <footer>
        <i class="fas fa-copyright"></i> <?= date('Y'); ?> Mombasa Computers. All rights reserved. 
        <span style="margin: 0 0.5rem;">•</span> 
        <span>v2.0.0</span>
    </footer>
</div>

<script>
// Dashboard Mobile Responsive Adjustment - FIXED
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
    
    // Sidebar toggle event
    window.addEventListener('sidebarToggled', adjustDashboardForMobile);
    
    // Override toggle function
    const originalToggle = window.toggleSidebar;
    if (originalToggle) {
        window.toggleSidebar = function() {
            originalToggle();
            setTimeout(() => {
                window.dispatchEvent(new Event('sidebarToggled'));
            }, 300);
        };
    }
    
    // Fix table scrolling on mobile
    const tables = document.querySelectorAll('.table-responsive');
    tables.forEach(table => {
        if (table.scrollWidth > table.clientWidth) {
            table.style.overflowX = 'auto';
        }
    });
});
</script>

<?php require_once "../includes/footer.php"; ?>
</body>
</html>