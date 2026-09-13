<?php
function returnsAllowedRoles(): array {
    return ['super_admin', 'inventory_admin', 'manager'];
}

function returnCategories(): array {
    return [
        'device'     => ['label'=>'Devices','serialized'=>true,'sale_type'=>'device','table'=>'devices','id_col'=>'serial_number','status_col'=>'status','sold_value'=>'Sold','instock_value'=>'In Stock'],
        'monitor'    => ['label'=>'Monitors','serialized'=>true,'sale_type'=>'monitors','table'=>'monitors','id_col'=>'serial_number','status_col'=>'status','sold_value'=>'Sold','instock_value'=>'In Stock'],
        'printer'    => ['label'=>'Printers','serialized'=>true,'sale_type'=>'printers','table'=>'printers','id_col'=>'serial_number','status_col'=>'status','sold_value'=>'Sold','instock_value'=>'In Stock'],
        'ram'        => ['label'=>'RAM','serialized'=>false,'sale_type'=>'ram','table'=>'rams_ssds','id_col'=>'id'],
        'ssd'        => ['label'=>'SSDs','serialized'=>false,'sale_type'=>'ssd','table'=>'rams_ssds','id_col'=>'id'],
        'charger'    => ['label'=>'Chargers','serialized'=>false,'sale_type'=>'charger','table'=>'chargers','id_col'=>'id'],
        'accessory'  => ['label'=>'Accessories','serialized'=>false,'sale_type'=>'accessory','table'=>'accessories','id_col'=>'id'],
        'smartboard' => ['label'=>'Smartboards','serialized'=>true,'sale_type'=>'smartboards','table'=>'smartboards','id_col'=>'serial_number','status_col'=>'status','sold_value'=>'sold','instock_value'=>'instock'],
        'phone'      => ['label'=>'Phones','serialized'=>true,'sale_type'=>'phones','table'=>'phones','id_col'=>'serial_number','status_col'=>'status','sold_value'=>'sold','instock_value'=>'instock'],
        'ups'        => ['label'=>'UPS','serialized'=>true,'sale_type'=>'ups','table'=>'ups','id_col'=>'serial_number','status_col'=>'status','sold_value'=>'sold','instock_value'=>'instock'],
        'graphic'    => ['label'=>'Graphics','serialized'=>false,'sale_type'=>'graphic','table'=>'graphic_cards','id_col'=>'id'],
        'hdd'        => ['label'=>'HDDs','serialized'=>false,'sale_type'=>'hdd','table'=>'hdds','id_col'=>'id'],
    ];
}

function getReturnCategory(string $key): ?array {
    $all = returnCategories();
    return $all[$key] ?? null;
}

function returnCategoryLabel(string $key): string {
    $cfg = getReturnCategory($key);
    return $cfg['label'] ?? ucfirst($key);
}

function serializedDescriptionExpression(string $category): string {
    switch ($category) {
        case 'device': return "CONCAT_WS(' | ', t.model_name, t.processor, IF(t.ram IS NULL,NULL,CONCAT(t.ram,'GB RAM')), IF(t.storage_capacity IS NULL,NULL,CONCAT(t.storage_capacity,'GB ',t.storage_type)), t.graphics, t.touch)";
        case 'monitor': return "CONCAT_WS(' | ', t.model_name, IF(t.size_inches IS NULL,NULL,CONCAT(t.size_inches,' inch')), t.monitor_condition)";
        case 'printer': return "CONCAT_WS(' | ', t.model_name, t.printer_condition)";
        case 'smartboard': return "CONCAT_WS(' | ', t.model, CONCAT(t.size_inches,' inch'))";
        case 'phone': return "CONCAT_WS(' | ', t.brand, t.model, IF(t.ram IS NULL,NULL,CONCAT(t.ram,'GB RAM')), IF(t.storage_capacity IS NULL,NULL,CONCAT(t.storage_capacity,'GB')), t.phone_condition)";
        case 'ups': return "CONCAT_WS(' | ', t.model, CONCAT(t.capacity,'VA'), t.ups_condition)";
        default: return "CAST(t.serial_number AS CHAR)";
    }
}

function serializedSalePriceExpression(string $category): string {
    return in_array($category, ['device','monitor','printer','smartboard','phone','ups'], true) ? 't.selling_price' : 'NULL';
}

function returnNumber(PDO $conn): string {
    for ($i=0; $i<10; $i++) {
        $candidate = 'RET-' . date('Ymd') . '-' . strtoupper(bin2hex(random_bytes(3)));
        $stmt = $conn->prepare("SELECT 1 FROM `returns` WHERE return_number=? LIMIT 1");
        $stmt->execute([$candidate]);
        if (!$stmt->fetchColumn()) return $candidate;
    }
    throw new RuntimeException('Could not generate a unique return number.');
}

function userBranch(PDO $conn, int $userId): ?string {
    $stmt = $conn->prepare("SELECT branch FROM users WHERE id=?");
    $stmt->execute([$userId]);
    $branch = $stmt->fetchColumn();
    return $branch ?: null;
}

function restockSerialized(PDO $conn, string $category, string $identifier): void {
    switch ($category) {
        case 'device':
            $stmt=$conn->prepare("UPDATE devices SET status='In Stock',selling_price=NULL,sold_at=NULL,sold_by=NULL,place=CASE WHEN place='sold' THEN 'store' ELSE place END WHERE serial_number=:id AND status='Sold'"); break;
        case 'monitor':
            $stmt=$conn->prepare("UPDATE monitors SET status='In Stock',selling_price=NULL,sold_at=NULL,sold_by=NULL WHERE serial_number=:id AND status='Sold'"); break;
        case 'printer':
            $stmt=$conn->prepare("UPDATE printers SET status='In Stock',selling_price=NULL,date_sold=NULL,sold_by=NULL WHERE serial_number=:id AND status='Sold'"); break;
        case 'smartboard':
            $stmt=$conn->prepare("UPDATE smartboards SET status='instock',selling_price=NULL,sold_at=NULL,sold_by=NULL,place=CASE WHEN place='sold' THEN 'store' ELSE place END WHERE serial_number=:id AND status='sold'"); break;
        case 'phone':
            $stmt=$conn->prepare("UPDATE phones SET status='instock',selling_price=NULL,date_sold=NULL,sold_by=NULL WHERE serial_number=:id AND status='sold'"); break;
        case 'ups':
            $stmt=$conn->prepare("UPDATE ups SET status='instock',selling_price=NULL,date_sold=NULL,sold_by=NULL WHERE serial_number=:id AND status='sold'"); break;
        default: throw new InvalidArgumentException('Unsupported serialized category.');
    }
    $stmt->execute(['id'=>$identifier]);
    if ($stmt->rowCount() !== 1) throw new RuntimeException('The sold item could not be moved back into stock.');
}

function restockQuantityItem(PDO $conn, string $category, int $itemId, int $quantity): void {
    if ($quantity <= 0) throw new InvalidArgumentException('Invalid return quantity.');
    switch ($category) {
        case 'ram': $stmt=$conn->prepare("UPDATE rams_ssds SET quantity=quantity+:qty WHERE id=:id AND category='RAM'"); break;
        case 'ssd': $stmt=$conn->prepare("UPDATE rams_ssds SET quantity=quantity+:qty WHERE id=:id AND category='SSD'"); break;
        case 'charger': $stmt=$conn->prepare("UPDATE chargers SET quantity=quantity+:qty WHERE id=:id"); break;
        case 'accessory': $stmt=$conn->prepare("UPDATE accessories SET quantity=quantity+:qty,status='instock',updated_at=NOW() WHERE id=:id"); break;
        case 'graphic': $stmt=$conn->prepare("UPDATE graphic_cards SET quantity=quantity+:qty,status='instock' WHERE id=:id"); break;
        case 'hdd': $stmt=$conn->prepare("UPDATE hdds SET quantity=quantity+:qty WHERE id=:id"); break;
        default: throw new InvalidArgumentException('Unsupported quantity category.');
    }
    $stmt->bindValue(':qty',$quantity,PDO::PARAM_INT);
    $stmt->bindValue(':id',$itemId,PDO::PARAM_INT);
    $stmt->execute();
    if ($stmt->rowCount() !== 1) throw new RuntimeException('The returned quantity could not be added back to inventory.');
}

function sellReplacementSerialized(PDO $conn, string $category, string $identifier, float $sellingPrice, int $soldBy): array {
    $cfg = getReturnCategory($category);
    if (!$cfg || empty($cfg['serialized'])) throw new InvalidArgumentException('Invalid replacement category.');

    $descExpr = serializedDescriptionExpression($category);
    $table = $cfg['table'];
    $idCol = $cfg['id_col'];
    $statusCol = $cfg['status_col'];

    // Lock and re-check the replacement before changing it.
    $check = $conn->prepare("SELECT t.`{$idCol}` AS item_identifier, {$descExpr} AS description, t.branch AS source_branch
                             FROM `{$table}` t
                             WHERE t.`{$idCol}`=:id AND t.`{$statusCol}`=:status
                             LIMIT 1 FOR UPDATE");
    $check->execute(['id'=>$identifier,'status'=>$cfg['instock_value']]);
    $item = $check->fetch(PDO::FETCH_ASSOC);
    if (!$item) throw new RuntimeException('The replacement item is no longer in stock. Search and select another item.');

    switch ($category) {
        case 'device':
            $stmt=$conn->prepare("UPDATE devices SET status='Sold',selling_price=:price,sold_at=NOW(),sold_by=:sold_by,place='sold' WHERE serial_number=:id AND status='In Stock'"); break;
        case 'monitor':
            $stmt=$conn->prepare("UPDATE monitors SET status='Sold',selling_price=:price,sold_at=NOW(),sold_by=:sold_by WHERE serial_number=:id AND status='In Stock'"); break;
        case 'printer':
            $stmt=$conn->prepare("UPDATE printers SET status='Sold',selling_price=:price,date_sold=NOW(),sold_by=:sold_by WHERE serial_number=:id AND status='In Stock'"); break;
        case 'smartboard':
            $stmt=$conn->prepare("UPDATE smartboards SET status='sold',selling_price=:price,sold_at=NOW(),sold_by=:sold_by,place='sold' WHERE serial_number=:id AND status='instock'"); break;
        case 'phone':
            $stmt=$conn->prepare("UPDATE phones SET status='sold',selling_price=:price,date_sold=NOW(),sold_by=:sold_by WHERE serial_number=:id AND status='instock'"); break;
        case 'ups':
            $stmt=$conn->prepare("UPDATE ups SET status='sold',selling_price=:price,date_sold=NOW(),sold_by=:sold_by WHERE serial_number=:id AND status='instock'"); break;
        default: throw new InvalidArgumentException('Unsupported replacement category.');
    }
    $stmt->execute(['price'=>$sellingPrice,'sold_by'=>$soldBy,'id'=>$identifier]);
    if ($stmt->rowCount() !== 1) throw new RuntimeException('The replacement item could not be marked sold.');
    return $item;
}
