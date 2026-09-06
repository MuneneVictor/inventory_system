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

if (!empty($_SESSION['cashier_mode_active'])) {
    header('Location: ../dashboard/cashierdashboard');
    exit;
}

$userId = (int)($_SESSION['user_id'] ?? 0);
$stmt = $conn->prepare("SELECT id, email, role, branch, full_name, is_active FROM users WHERE id = ? LIMIT 1");
$stmt->execute([$userId]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user || (int)$user['is_active'] !== 1) {
    http_response_code(403);
    exit('Access denied.');
}

$branch = strtoupper(trim((string)($_POST['branch'] ?? '')));
$allowedBranches = ['KIMATHI', 'MOI'];
if (!in_array($branch, $allowedBranches, true)) {
    http_response_code(422);
    exit('Invalid branch selected.');
}

// Authorization is checked server-side every time. Super Admin always qualifies.
$authorized = ((string)$user['role'] === 'super_admin');
if (!$authorized) {
    try {
        $q = $conn->query("SELECT owner_inventory_allowed_emails FROM login_access_settings WHERE id = 1 LIMIT 1");
        $raw = (string)($q->fetchColumn() ?: '');
        $allowedEmails = [];
        foreach (preg_split('/[\s,;]+/', strtolower($raw)) ?: [] as $candidate) {
            $candidate = trim($candidate);
            if ($candidate !== '' && filter_var($candidate, FILTER_VALIDATE_EMAIL)) {
                $allowedEmails[] = $candidate;
            }
        }
        $authorized = in_array(strtolower(trim((string)$user['email'])), array_unique($allowedEmails), true);
    } catch (Throwable $e) {
        $authorized = false;
    }
}

if (!$authorized) {
    http_response_code(403);
    exit('Access denied.');
}

// Keep the real user_id/name/email. Only the effective role and branch change.
$_SESSION['cashier_mode_active'] = true;
$_SESSION['cashier_mode_user_id'] = $userId;
$_SESSION['cashier_mode_original_role'] = (string)$user['role'];
$_SESSION['cashier_mode_original_branch'] = (string)($user['branch'] ?? '');
$_SESSION['cashier_mode_branch'] = $branch;
$_SESSION['role'] = 'cashier';
$_SESSION['branch'] = $branch;
$_SESSION['name'] = (string)$user['full_name'];
$_SESSION['email'] = (string)$user['email'];
$_SESSION['last_activity'] = time();
session_regenerate_id(true);

try {
    $log = $conn->prepare("INSERT INTO activity_logs (user_id, action, details) VALUES (?, ?, ?)");
    $log->execute([$userId, 'Cashier Mode Started', 'Switched to Cashier Mode for branch ' . $branch]);
} catch (Throwable $e) {
    // Logging must not break the mode switch.
}

header('Location: ../dashboard/cashierdashboard');
exit;
