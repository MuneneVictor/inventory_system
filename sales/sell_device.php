<?php
session_start();
require_once "../config/db.php";
require_once "../includes/auth_check.php";

if($_SESSION['role'] !== 'sales') die("Access denied!");

$error = $success = "";
$foundDevices = [];
$notFoundSerials = [];
$singleDevice = null;

$user_id = $_SESSION['user_id'];
$user_stmt = $conn->prepare("SELECT branch FROM users WHERE id = :id");
$user_stmt->execute(['id' => $user_id]);
$salesperson = $user_stmt->fetch(PDO::FETCH_ASSOC);
$salesperson_branch = $salesperson['branch'] ?? null;

if(isset($_POST['search_serial'])){
    $input = trim($_POST['serial_number']);
    
    if(empty($input)){
        $error = "Please enter serial number(s).";
    } else {
        $serials = preg_split('/[\s,]+/', $input);
        $serials = array_filter(array_map('trim', $serials));
        
        if(empty($serials)){
            $error = "No valid serial numbers found.";
        } else {
            $placeholders = str_repeat('?,', count($serials) - 1) . '?';
            
            $stmt = $conn->prepare("
                SELECT d.*, c.category_name 
                FROM devices d
                JOIN categories c ON d.category_id = c.id
                WHERE d.serial_number IN ($placeholders)
                AND d.status='In Stock'
                AND d.branch = ?
            ");
            
            $params = array_merge($serials, [$salesperson_branch]);
            $stmt->execute($params);
            $foundDevices = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            $foundSerials = array_column($foundDevices, 'serial_number');
            $notFoundSerials = array_diff($serials, $foundSerials);
            
            if(empty($foundDevices)){
                $error = "Devices not found in your branch or Not instock.";
            } elseif(count($serials) === 1 && !empty($foundDevices)) {
                $singleDevice = $foundDevices[0];
                $foundDevices = [];
            }
        }
    }
}

if(isset($_POST['sell_device'])){
    $serial = $_POST['serial_number'];

    $stmt = $conn->prepare("
        SELECT d.*, c.category_name 
        FROM devices d
        JOIN categories c ON d.category_id = c.id
        WHERE d.serial_number = :sn 
        AND d.status='In Stock'
        AND d.branch = :branch
    ");
    $stmt->execute(['sn' => $serial, 'branch' => $salesperson_branch]);
    $device = $stmt->fetch(PDO::FETCH_ASSOC);

    if($device){
        $insert = $conn->prepare("
            INSERT INTO sold_devices 
            (serial_number, category_id, model_name, processor, graphics, ram, 
             storage_type, storage_capacity, touch, device_condition, sold_by, price) 
            VALUES (:sn, :cat, :model, :proc, :gfx, :ram, :stype, :scap, :touch, :cond, :sold_by, :price)
        ");
        $insert->execute([
            'sn' => $device['serial_number'],
            'cat' => $device['category_id'],
            'model' => $device['model_name'],
            'proc' => $device['processor'],
            'gfx' => $device['graphics'],
            'ram' => $device['ram'],
            'stype' => $device['storage_type'],
            'scap' => $device['storage_capacity'],
            'touch' => $device['touch'],
            'cond' => $device['device_condition'],
            'sold_by' => $_SESSION['user_id'],
            'price' => $device['price']
        ]);

        $update = $conn->prepare("UPDATE devices SET status='Sold' WHERE serial_number=:sn");
        $update->execute(['sn' => $serial]);

        $log = $conn->prepare("INSERT INTO activity_logs (user_id, action, details) VALUES (:uid, 'Sold device', :details)");
        $log->execute(['uid'=>$_SESSION['user_id'], 'details'=>"Sold device SN: {$device['serial_number']} for KES " . ($device['price'] ? number_format($device['price'], 2) : '0')]);

        $success = "Device sold successfully!";
        $singleDevice = null;
        $foundDevices = [];
    } else {
        $error = "Device not found in your branch or already sold.";
    }
}

if(isset($_POST['sell_bulk_devices'])){
    $selectedSerials = $_POST['selected_serials'] ?? [];
    
    if(empty($selectedSerials)){
        $error = "No devices selected for sale.";
    } else {
        $soldCount = 0;
        $failedCount = 0;
        
        foreach($selectedSerials as $serial){
            $stmt = $conn->prepare("
                SELECT d.*, c.category_name 
                FROM devices d
                JOIN categories c ON d.category_id = c.id
                WHERE d.serial_number = :sn 
                AND d.status='In Stock'
                AND d.branch = :branch
            ");
            $stmt->execute(['sn' => $serial, 'branch' => $salesperson_branch]);
            $device = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if($device){
                $insert = $conn->prepare("
                    INSERT INTO sold_devices 
                    (serial_number, category_id, model_name, processor, graphics, ram, 
                     storage_type, storage_capacity, touch, device_condition, sold_by, price) 
                    VALUES (:sn, :cat, :model, :proc, :gfx, :ram, :stype, :scap, :touch, :cond, :sold_by, :price)
                ");
                $insert->execute([
                    'sn' => $device['serial_number'],
                    'cat' => $device['category_id'],
                    'model' => $device['model_name'],
                    'proc' => $device['processor'],
                    'gfx' => $device['graphics'],
                    'ram' => $device['ram'],
                    'stype' => $device['storage_type'],
                    'scap' => $device['storage_capacity'],
                    'touch' => $device['touch'],
                    'cond' => $device['device_condition'],
                    'sold_by' => $_SESSION['user_id'],
                    'price' => $device['price']
                ]);

                $update = $conn->prepare("UPDATE devices SET status='Sold' WHERE serial_number=:sn");
                $update->execute(['sn' => $serial]);
                
                $log = $conn->prepare("INSERT INTO activity_logs (user_id, action, details) VALUES (:uid, 'Sold device', :details)");
                $log->execute(['uid'=>$_SESSION['user_id'], 'details'=>"Sold device SN: {$device['serial_number']} for KES " . ($device['price'] ? number_format($device['price'], 2) : '0')]);
                
                $soldCount++;
            } else {
                $failedCount++;
            }
        }
        
        if($soldCount > 0){
            $success = "$soldCount device(s) sold successfully!";
            if($failedCount > 0){
                $success .= " $failedCount device(s) could not be sold.";
            }
            $foundDevices = [];
            $notFoundSerials = [];
        } else {
            $error = "No devices could be sold.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Sell Device</title>
<style>
body{font-family:Arial; background:#f4f7f6; padding:20px;}
.container{max-width:800px;margin:50px auto;background:#fff;padding:30px;border-radius:8px;box-shadow:0 4px 15px rgba(0,0,0,0.1);}
h2{text-align:center;color:#2f7a3f;margin-bottom:20px;}
input, button{width:100%; padding:10px; margin-bottom:15px; border-radius:5px; border:1px solid #ccc;}
button{background:#2f7a3f; color:#fff; border:none; font-weight:bold; cursor:pointer;}
button:hover{background:#1f5a2d;}
.error{color:#d32f2f;text-align:center;margin-bottom:15px;}
.success{color:#2f7a3f;text-align:center;margin-bottom:15px;}
table{width:100%;border-collapse:collapse;margin-top:20px;}
th,td{border:1px solid #ccc;padding:8px;text-align:left;}
th{background:#2f7a3f;color:#fff;}
tr:nth-child(even){background:#f4f7f6;}
textarea{width:100%; padding:10px; margin-bottom:15px; border-radius:5px; border:1px solid #ccc; font-family: Arial; resize: vertical;}
.warning-box{background:#fff3cd; padding:10px; border-left:4px solid #ffc107; margin-bottom:15px; border-radius:4px;}
.checkbox-cell{text-align:center;}
</style>
<script>
// Handle Enter key for scanner - adds new line
function handleScannerInput(event) {
    if (event.key === 'Enter' && !event.ctrlKey && !event.shiftKey) {
        event.preventDefault();
        const textarea = event.target;
        const cursorPos = textarea.selectionStart;
        textarea.value = textarea.value.substring(0, cursorPos) + '\n' + textarea.value.substring(cursorPos);
        setTimeout(() => textarea.selectionStart = textarea.selectionEnd = cursorPos + 1, 0);
    }
}

function selectAllCheckboxes(source) {
    document.querySelectorAll('input[name="selected_serials[]"]').forEach(cb => cb.checked = source.checked);
}
</script>
</head>
<body>
<div class="container">

<a href="/inventory_system/dashboard/index.php" style="background:#007bff;color:white;padding:8px 12px;border-radius:5px;text-decoration:none;">Dashboard</a>

<h2>Sell Device</h2>

<?php if($error): ?><div class="error"><?= $error ?></div><?php endif; ?>
<?php if($success): ?><div class="success"><?= $success ?></div><?php endif; ?>

<form method="POST">
    <textarea name="serial_number" placeholder="Type or scan serial numbers (one per line or comma separated)" rows="5" onkeydown="handleScannerInput(event)" required autofocus><?= isset($_POST['serial_number']) ? htmlspecialchars($_POST['serial_number']) : '' ?></textarea>
    <button type="submit" name="search_serial">Search Device(s)</button>
</form>

<?php if(!empty($notFoundSerials)): ?>
<div class="warning-box">
    <strong>Not Found:</strong> <?= implode(', ', $notFoundSerials) ?>
</div>
<?php endif; ?>

<?php if($singleDevice): ?>
<form method="POST">
    <h3>Device Details</h3>
    <table>
        <tr><th>Serial Number</th><td><?= $singleDevice['serial_number'] ?></td></tr>
        <tr><th>Model</th><td><?= $singleDevice['model_name'] ?></td></tr>
        <tr><th>Category</th><td><?= $singleDevice['category_name'] ?></td></tr>
        <tr><th>Processor</th><td><?= $singleDevice['processor'] ?></td></tr>
        <tr><th>Graphics</th><td><?= $singleDevice['graphics'] ?></td></tr>
        <tr><th>RAM</th><td><?= $singleDevice['ram'] ?> GB</td></tr>
        <tr><th>Storage</th><td><?= $singleDevice['storage_type'] ?> <?= $singleDevice['storage_capacity'] ?>GB</td></tr>
        <tr><th>Price</th><td><?= $singleDevice['price'] ? 'KES ' . number_format($singleDevice['price'], 2) : 'Not priced' ?></td></tr>
        <tr><th>Touch</th><td><?= strtolower($singleDevice['category_name']) === 'desktop' ? 'N/A' : ($singleDevice['touch'] ?? 'N/A') ?></td></tr>
    </table>
    <input type="hidden" name="serial_number" value="<?= $singleDevice['serial_number'] ?>">
    <button type="submit" name="sell_device">Confirm Sale</button>
</form>
<?php endif; ?>

<?php if(!empty($foundDevices)): ?>
<form method="POST">
    <h3>Found Devices (<?= count($foundDevices) ?>)</h3>
    <p><input type="checkbox" id="selectAll" onchange="selectAllCheckboxes(this)"> <label for="selectAll">Select All</label></p>
    <table>
        <tr><th class="checkbox-cell">Sell</th><th>Serial Number</th><th>Model</th><th>Category</th><th>Processor</th><th>RAM</th><th>Price</th></tr>
        <?php foreach($foundDevices as $device): ?>
        <tr>
            <td class="checkbox-cell"><input type="checkbox" name="selected_serials[]" value="<?= $device['serial_number'] ?>" checked></td>
            <td><?= htmlspecialchars($device['serial_number']) ?></td>
            <td><?= htmlspecialchars($device['model_name']) ?></td>
            <td><?= htmlspecialchars($device['category_name']) ?></td>
            <td><?= htmlspecialchars($device['processor']) ?></td>
            <td><?= htmlspecialchars($device['ram']) ?> GB</td>
            <td><?= $device['price'] ? 'KES ' . number_format($device['price'], 2) : '-' ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
    <button type="submit" name="sell_bulk_devices">Sell Selected Devices (<?= count($foundDevices) ?>)</button>
</form>
<?php endif; ?>

</div>
</body>
</html>