<?php
session_start();
ini_set('display_errors', '0');
header('Content-Type: application/json; charset=utf-8');

require_once "../config/db.php";
require_once "return_helpers.php";

function apiFail(string $message, int $status = 400): void {
    http_response_code($status);
    echo json_encode([
        'ok' => false,
        'message' => $message
    ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    exit;
}

if (!isset($_SESSION['user_id']) || !in_array($_SESSION['role'] ?? '', returnsAllowedRoles(), true)) {
    apiFail('Your session has expired or you do not have access to returns.', 403);
}

$category = trim((string)($_GET['category'] ?? ''));
$q = trim((string)($_GET['q'] ?? ''));
$cfg = getReturnCategory($category);

if (!$cfg) {
    apiFail('Select a valid return category.', 422);
}

try {
    $rows = [];

    if (!empty($cfg['serialized'])) {
        /*
         * SERIALIZED CATEGORIES
         * ---------------------
         * Devices, monitors, printers, smartboards, phones and UPS are searched
         * DIRECTLY in their own inventory table, and only rows whose inventory
         * status is Sold/sold are eligible.
         *
         * We deliberately do NOT join the returns table to the inventory table.
         * The current DB dump has different collations on those text columns, and
         * a direct text-to-text comparison can raise a MySQL collation exception.
         */
        $table = $cfg['table'];
        $idCol = $cfg['id_col'];
        $statusCol = $cfg['status_col'];
        $descExpr = serializedDescriptionExpression($category);
        $priceExpr = serializedSalePriceExpression($category);

        $sql = "SELECT
                    t.`{$idCol}` AS item_identifier,
                    {$descExpr} AS inventory_description,
                    {$priceExpr} AS inventory_selling_price,
                    t.branch AS source_branch
                FROM `{$table}` t
                WHERE t.`{$statusCol}` = :sold_status";

        $params = ['sold_status' => $cfg['sold_value']];

        if ($q !== '') {
            $sql .= " AND t.`{$idCol}` LIKE :serial_search";
            $params['serial_search'] = '%' . $q . '%';
        }

        $sql .= " ORDER BY t.`{$idCol}` ASC LIMIT 30";

        $stmt = $conn->prepare($sql);
        $stmt->execute($params);
        $inventoryRows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Sale details are resolved separately using the serial number stored in sale_items.item_id.
        $saleStmt = $conn->prepare(
            "SELECT
                si.id AS sale_item_id,
                si.sale_id,
                si.description,
                si.quantity AS sold_quantity,
                si.unit_price,
                si.created_at AS sale_item_created_at,
                s.client_name,
                s.client_phone,
                s.sale_status,
                s.completed_at,
                s.payment_method,
                s.payment_status,
                s.sold_by
             FROM sale_items si
             INNER JOIN sales s ON s.id = si.sale_id
             WHERE si.item_type = :sale_type
               AND si.item_id = :serial_number
               AND s.sale_status = 'completed'
             ORDER BY si.id DESC
             LIMIT 1"
        );

        // Check an already-completed return separately using parameters only.
        // This avoids cross-table collation comparisons.
        $returnedStmt = $conn->prepare(
            "SELECT id
             FROM `returns`
             WHERE category = :category
               AND item_identifier = :item_identifier
               AND return_status = 'Completed'
             LIMIT 1"
        );

        foreach ($inventoryRows as $inventory) {
            $serial = (string)$inventory['item_identifier'];

            $returnedStmt->execute([
                'category' => $category,
                'item_identifier' => $serial
            ]);
            if ($returnedStmt->fetchColumn()) {
                continue;
            }

            $saleStmt->execute([
                'sale_type' => $cfg['sale_type'],
                'serial_number' => $serial
            ]);
            $sale = $saleStmt->fetch(PDO::FETCH_ASSOC) ?: [];

            $rows[] = [
                'item_identifier' => $serial,
                'description' => !empty($sale['description'])
                    ? $sale['description']
                    : $inventory['inventory_description'],
                'source_branch' => $inventory['source_branch'],
                'sale_item_id' => $sale['sale_item_id'] ?? null,
                'sale_id' => $sale['sale_id'] ?? null,
                'unit_price' => $sale['unit_price'] ?? $inventory['inventory_selling_price'],
                'client_name' => $sale['client_name'] ?? null,
                'client_phone' => $sale['client_phone'] ?? null,
                'completed_at' => $sale['completed_at'] ?? null,
                'payment_method' => $sale['payment_method'] ?? null,
                'payment_status' => $sale['payment_status'] ?? null,
                'serialized' => true,
                'sold_quantity' => 1,
                'remaining_quantity' => 1
            ];
        }
    } else {
        /*
         * QUANTITY / NON-SERIALIZED CATEGORIES
         * ------------------------------------
         * RAM, SSD, charger, accessory, graphics and HDD are identified by the
         * exact sale_items.id. This is the safest identifier because the same
         * inventory master row can be sold multiple times and has no unique serial.
         */
        if ($q === '') {
            apiFail('Enter the Sale Item ID for this return.', 422);
        }
        if (!ctype_digit($q) || (int)$q <= 0) {
            apiFail('For this category, enter a valid numeric Sale Item ID.', 422);
        }

        $saleItemId = (int)$q;

        $saleStmt = $conn->prepare(
            "SELECT
                si.id AS sale_item_id,
                si.sale_id,
                si.item_type,
                si.item_id AS item_identifier,
                si.description,
                si.quantity AS sold_quantity,
                si.unit_price,
                si.created_at AS sale_item_created_at,
                s.client_name,
                s.client_phone,
                s.completed_at,
                s.payment_method,
                s.payment_status
             FROM sale_items si
             INNER JOIN sales s ON s.id = si.sale_id
             WHERE si.id = :sale_item_id
               AND si.item_type = :sale_type
               AND s.sale_status = 'completed'
             LIMIT 1"
        );
        $saleStmt->execute([
            'sale_item_id' => $saleItemId,
            'sale_type' => $cfg['sale_type']
        ]);
        $sale = $saleStmt->fetch(PDO::FETCH_ASSOC);

        if (!$sale) {
            echo json_encode(['ok' => true, 'items' => []], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
            exit;
        }

        // Verify the referenced master inventory record still exists and get its branch.
        $masterId = (int)$sale['item_identifier'];
        if ($category === 'ram' || $category === 'ssd') {
            $expectedCategory = $category === 'ram' ? 'RAM' : 'SSD';
            $masterStmt = $conn->prepare(
                "SELECT id, branch
                 FROM rams_ssds
                 WHERE id = :id AND category = :category
                 LIMIT 1"
            );
            $masterStmt->execute([
                'id' => $masterId,
                'category' => $expectedCategory
            ]);
        } else {
            // Table name comes only from the fixed internal category whitelist.
            $table = $cfg['table'];
            $masterStmt = $conn->prepare(
                "SELECT id, branch FROM `{$table}` WHERE id = :id LIMIT 1"
            );
            $masterStmt->execute(['id' => $masterId]);
        }

        $master = $masterStmt->fetch(PDO::FETCH_ASSOC);
        if (!$master) {
            echo json_encode(['ok' => true, 'items' => []], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
            exit;
        }

        $returnedStmt = $conn->prepare(
            "SELECT COALESCE(SUM(quantity), 0)
             FROM `returns`
             WHERE sale_item_id = :sale_item_id
               AND return_status = 'Completed'"
        );
        $returnedStmt->execute(['sale_item_id' => $saleItemId]);
        $alreadyReturned = (int)$returnedStmt->fetchColumn();
        $soldQty = (int)$sale['sold_quantity'];
        $remaining = max(0, $soldQty - $alreadyReturned);

        if ($remaining > 0) {
            $rows[] = [
                'sale_item_id' => (int)$sale['sale_item_id'],
                'sale_id' => (int)$sale['sale_id'],
                'item_identifier' => (string)$sale['item_identifier'],
                'description' => $sale['description'],
                'sold_quantity' => $soldQty,
                'remaining_quantity' => $remaining,
                'unit_price' => $sale['unit_price'],
                'client_name' => $sale['client_name'],
                'client_phone' => $sale['client_phone'],
                'completed_at' => $sale['completed_at'],
                'payment_method' => $sale['payment_method'],
                'payment_status' => $sale['payment_status'],
                'source_branch' => $master['branch'] ?? null,
                'serialized' => false
            ];
        }
    }

    echo json_encode([
        'ok' => true,
        'items' => $rows
    ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
} catch (Throwable $e) {
    error_log('Returns search failed [' . $category . ']: ' . $e->getMessage());
    apiFail('Could not search returnable items. The search query was rejected by the database.', 500);
}
