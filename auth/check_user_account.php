<?php
session_start();
date_default_timezone_set('Africa/Nairobi');

require_once "../config/db.php";
require_once "../includes/auth_check.php";

if (($_SESSION['role'] ?? '') !== 'super_admin') {
    http_response_code(403);
    exit('Access denied. Only Super Administrators can check user accounts.');
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit('Method not allowed.');
}

$csrf = (string)($_POST['csrf_token'] ?? '');
if (empty($_SESSION['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $csrf)) {
    http_response_code(403);
    exit('Security validation failed. Please return to User Management and try again.');
}

$targetId = filter_input(INPUT_POST, 'user_id', FILTER_VALIDATE_INT);
if (!$targetId || $targetId <= 0 || $targetId === (int)$_SESSION['user_id']) {
    http_response_code(400);
    exit('Invalid user account.');
}

$stmt = $conn->prepare("SELECT id, email, role, full_name, branch, is_active FROM users WHERE id = :id LIMIT 1");
$stmt->execute(['id' => $targetId]);
$target = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$target) {
    http_response_code(404);
    exit('User account not found.');
}

$adminId = (int)$_SESSION['user_id'];
$adminName = (string)($_SESSION['name'] ?? $_SESSION['full_name'] ?? 'Super Admin');

// Keep only the minimum information required to securely restore the Super Admin session.
$_SESSION['impersonator'] = [
    'user_id' => $adminId,
    'role' => 'super_admin',
    'name' => $adminName,
    'email' => (string)($_SESSION['email'] ?? ''),
    'branch' => (string)($_SESSION['branch'] ?? ''),
    'started_at' => time(),
    'target_user_id' => (int)$target['id'],
];

session_regenerate_id(true);
$_SESSION['user_id'] = (int)$target['id'];
$_SESSION['role'] = (string)$target['role'];
$_SESSION['name'] = (string)($target['full_name'] ?? 'User');
$_SESSION['full_name'] = (string)($target['full_name'] ?? 'User');
$_SESSION['email'] = (string)$target['email'];
$_SESSION['branch'] = (string)$target['branch'];
$_SESSION['last_activity'] = time();
$_SESSION['session_regenerated'] = time();

try {
    $logStmt = $conn->prepare("INSERT INTO activity_logs (user_id, action, details) VALUES (:uid, :action, :details)");
    $logStmt->execute([
        'uid' => $adminId,
        'action' => 'Check User Account',
        'details' => 'Super Admin ' . $adminName . ' opened user account ID ' . (int)$target['id'] . ' (' . (string)$target['email'] . ') as role ' . (string)$target['role']
    ]);
} catch (Throwable $e) {
    error_log('Could not log account check: ' . $e->getMessage());
}

$dashboards = [
    'super_admin' => '../dashboard/superadmindashboard',
    'manager' => '../dashboard/managerdashboard',
    'inventory_admin' => '../dashboard/inventorydashboard',
    'sales' => '../dashboard/salesdashboard',
    'cashier' => '../dashboard/cashierdashboard',
    'software' => '../dashboard/softwaredashboard',
    'technician' => '../dashboard/techniciandashboard',
];

header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
header('Pragma: no-cache');
header('Location: ' . ($dashboards[$target['role']] ?? '../auth/myaccount'));
exit();
