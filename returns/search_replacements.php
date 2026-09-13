<?php
session_start();
ini_set('display_errors', '0');
header('Content-Type: application/json; charset=utf-8');
require_once "../config/db.php";
require_once "return_helpers.php";

function apiFailReplacement(string $message, int $status = 400): void {
    http_response_code($status);
    echo json_encode(['ok'=>false,'message'=>$message], JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);
    exit;
}
if (!isset($_SESSION['user_id']) || !in_array($_SESSION['role'] ?? '', returnsAllowedRoles(), true)) {
    apiFailReplacement('Your session has expired or you do not have access to returns.', 403);
}
$category = trim((string)($_GET['category'] ?? ''));
$q = trim((string)($_GET['q'] ?? ''));
$exclude = trim((string)($_GET['exclude'] ?? ''));
$cfg = getReturnCategory($category);
if (!$cfg || !$cfg['serialized']) apiFailReplacement('Replacement is available only for serialized categories.', 422);
if ($q === '') apiFailReplacement('Enter the replacement serial number.', 422);

try {
    $table=$cfg['table']; $idCol=$cfg['id_col']; $statusCol=$cfg['status_col'];
    $descExpr=serializedDescriptionExpression($category);
    $sql="SELECT t.`{$idCol}` AS item_identifier, {$descExpr} AS description,
                 t.branch AS source_branch, t.price AS listed_price
          FROM `{$table}` t
          WHERE t.`{$statusCol}`=:instock_status
            AND t.`{$idCol}` LIKE :serial_search";
    $params=['instock_status'=>$cfg['instock_value'],'serial_search'=>'%'.$q.'%'];
    if ($exclude !== '') { $sql .= " AND t.`{$idCol}` <> :exclude_serial"; $params['exclude_serial']=$exclude; }
    $sql .= " ORDER BY CASE WHEN t.`{$idCol}`=:exact_serial THEN 0 ELSE 1 END, t.`{$idCol}` ASC LIMIT 20";
    $params['exact_serial']=$q;
    $stmt=$conn->prepare($sql); $stmt->execute($params);
    echo json_encode(['ok'=>true,'items'=>$stmt->fetchAll(PDO::FETCH_ASSOC)], JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);
} catch(Throwable $e) {
    error_log('Replacement search failed: '.$e->getMessage());
    apiFailReplacement('Could not search in-stock replacement items.',500);
}
