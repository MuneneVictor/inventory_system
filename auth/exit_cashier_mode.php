<?php
session_start();
require_once "../config/db.php";
require_once "../includes/auth_check.php";

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit('Method not allowed.');
}

$token = (string)($_POST['csrf_token'] ?? '');
if (empty($_SESSION['cashier_mode_csrf']) || !hash_equals((string)$_SESSION['cashier_mode_csrf'], $token)) {
    http_response_code(403);
    exit('Security validation failed.');
}

if (empty($_SESSION['cashier_mode_active'])) {
    header('Location: myaccount');
    exit;
}

$userId = (int)($_SESSION['user_id'] ?? 0);
$stmt = $conn->prepare("SELECT id, email, role, branch, full_name, is_active FROM users WHERE id = ? LIMIT 1");
$stmt->execute([$userId]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user || (int)$user['is_active'] !== 1) {
    $_SESSION = [];
    session_destroy();
    header('Location: login');
    exit;
}

$cashierBranch = strtoupper(trim((string)($_SESSION['cashier_mode_branch'] ?? '')));

// Restore from the database, not from client input or a trusted-looking POST value.
$_SESSION['role'] = (string)$user['role'];
$_SESSION['branch'] = (string)($user['branch'] ?? '');
$_SESSION['name'] = (string)$user['full_name'];
$_SESSION['email'] = (string)$user['email'];

unset(
    $_SESSION['cashier_mode_active'],
    $_SESSION['cashier_mode_user_id'],
    $_SESSION['cashier_mode_original_role'],
    $_SESSION['cashier_mode_original_branch'],
    $_SESSION['cashier_mode_branch']
);
$_SESSION['cashier_mode_csrf'] = bin2hex(random_bytes(32));
$_SESSION['last_activity'] = time();
session_regenerate_id(true);

try {
    $log = $conn->prepare("INSERT INTO activity_logs (user_id, action, details) VALUES (?, ?, ?)");
    $log->execute([$userId, 'Cashier Mode Ended', 'Returned from Cashier Mode' . ($cashierBranch !== '' ? ' for branch ' . $cashierBranch : '')]);
} catch (Throwable $e) {
    // Logging must not prevent restoration.
}

$dashboardByRole = [
    'super_admin' => '../dashboard/superadmindashboard',
    'manager' => '../dashboard/managerdashboard',
    'inventory_admin' => '../dashboard/inventorydashboard',
    'sales' => '../dashboard/salesdashboard',
    'software' => '../dashboard/softwaredashboard',
    'technician' => '../dashboard/techniciandashboard',
    'cashier' => '../dashboard/cashierdashboard',
];
header('Location: ' . ($dashboardByRole[(string)$user['role']] ?? 'myaccount'));
exit;
