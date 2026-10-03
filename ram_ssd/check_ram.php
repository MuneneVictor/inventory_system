<?php
ob_start();
session_start();
require_once "../config/db.php";
require_once "../includes/auth_check.php";

if (ob_get_length()) {
    ob_clean();
}
header('Content-Type: application/json; charset=utf-8');

// Only allow the same roles as add_ram.php
if (!in_array($_SESSION['role'], ['super_admin', 'inventory_admin', 'manager'])) {
    http_response_code(403);
    echo json_encode(['error' => 'Access denied']);
    exit;
}

$category = trim($_POST['category'] ?? '');
$type = trim($_POST['type'] ?? '');
$storage = trim((string)($_POST['storage'] ?? ''));
$branch = trim($_POST['branch'] ?? '');

if ($category === '' || $type === '' || $storage === '') {
    echo json_encode(['exists' => false, 'error' => 'Missing parameters']);
    exit;
}

try {
    $sql = "
        SELECT id, quantity, branch
        FROM rams_ssds
        WHERE category = :category
          AND LOWER(TRIM(type)) = LOWER(TRIM(:type))
          AND LOWER(TRIM(storage)) = LOWER(TRIM(:storage))
    ";

    $params = [
        'category' => $category,
        'type' => $type,
        'storage' => $storage
    ];

    if ($branch === '') {
        $sql .= " AND branch IS NULL";
    } else {
        $sql .= " AND branch = :branch";
        $params['branch'] = $branch;
    }

    $sql .= " LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->execute($params);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        echo json_encode([
            'exists' => true,
            'id' => (int)$result['id'],
            'quantity' => (int)$result['quantity']
        ]);
    } else {
        echo json_encode(['exists' => false]);
    }
} catch (Throwable $e) {
    echo json_encode(['exists' => false, 'error' => $e->getMessage()]);
}