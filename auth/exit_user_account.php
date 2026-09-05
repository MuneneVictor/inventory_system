<?php
session_start();
date_default_timezone_set('Africa/Nairobi');
require_once "../config/db.php";

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit('Method not allowed.');
}

$csrf = (string)($_POST['csrf_token'] ?? '');
if (empty($_SESSION['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $csrf)) {
    http_response_code(403);
    exit('Security validation failed.');
}

$impersonator = $_SESSION['impersonator'] ?? null;
if (!is_array($impersonator) || empty($impersonator['user_id'])) {
    header('Location: login');
    exit();
}

$adminId = (int)$impersonator['user_id'];
$stmt = $conn->prepare("SELECT id, email, role, full_name, branch, is_active FROM users WHERE id = :id LIMIT 1");
$stmt->execute(['id' => $adminId]);
$admin = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$admin || $admin['role'] !== 'super_admin' || (int)$admin['is_active'] !== 1) {
    $_SESSION = [];
    session_destroy();
    header('Location: login');
    exit();
}

$targetId = (int)($_SESSION['user_id'] ?? 0);

session_regenerate_id(true);
$_SESSION['user_id'] = (int)$admin['id'];
$_SESSION['role'] = 'super_admin';
$_SESSION['name'] = (string)($admin['full_name'] ?? 'Super Admin');
$_SESSION['full_name'] = (string)($admin['full_name'] ?? 'Super Admin');
$_SESSION['email'] = (string)$admin['email'];
$_SESSION['branch'] = (string)$admin['branch'];
$_SESSION['last_activity'] = time();
$_SESSION['session_regenerated'] = time();
unset($_SESSION['impersonator']);

try {
    $logStmt = $conn->prepare("INSERT INTO activity_logs (user_id, action, details) VALUES (:uid, :action, :details)");
    $logStmt->execute([
        'uid' => (int)$admin['id'],
        'action' => 'Exit Checked User Account',
        'details' => 'Super Admin returned from checked user account ID ' . $targetId
    ]);
} catch (Throwable $e) {
    error_log('Could not log exit from checked account: ' . $e->getMessage());
}

header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
header('Pragma: no-cache');
header('Location: ../auth/view_users');
exit();
