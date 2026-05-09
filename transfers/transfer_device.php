<?php
session_start();
require_once "../config/db.php";
require_once "../includes/auth_check.php";

// Check if user has permission
$allowed_roles = ['super_admin', 'manager', 'inventory_admin'];
if(!in_array($_SESSION['role'], $allowed_roles)) {
    die("Access denied!");
}

$error = $success = "";
$foundDevices = [];
$notFoundSerials = [];
$singleDevice = null;
$availableBranches = ['KIMATHI', 'MOI'];
$current_branch = null;

// Get current user's branch
$user_id = $_SESSION['user_id'];
$user_stmt = $conn->prepare("SELECT branch FROM users WHERE id = :id");
$user_stmt->execute(['id' => $user_id]);
$user = $user_stmt->fetch(PDO::FETCH_ASSOC);
$current_branch = $user['branch'] ?? null;
// Get user's permissions
$is_super_admin = ($_SESSION['role'] === 'super_admin');

// Store delivered_by in session
if(isset($_POST['search_serial'])) {
    $_SESSION['delivered_by'] = trim($_POST['delivered_by'] ?? '');
}

// Process transfer device search
if(isset($_POST['search_serial'])) {
    $input = trim($_POST['serial_number']);
    $from_branch = $_POST['from_branch'] ?? null;
    $to_branch = $_POST['to_branch'] ?? null;
    $delivered_by = trim($_POST['delivered_by'] ?? '');
    
    // If user is not super admin, force from_branch to be their current branch
    if(!$is_super_admin) {
        $from_branch = $current_branch;
    }
    
    if(empty($input)) {
        $error = "Please enter serial number(s).";
    } elseif(empty($from_branch) || empty($to_branch)) {
        $error = "Please select both source and destination branches.";
    } elseif($from_branch === $to_branch) {
        $error = "Source and destination branches cannot be the same.";
    } elseif(empty($delivered_by)) {
        $error = "Please enter the name of the person delivering the devices.";
    } else {
        // Check if user has permission to transfer from selected branch
        if(!$is_super_admin && $from_branch !== $current_branch) {
            $error = "You can only transfer devices from your own branch.";
        } else {
            $serials = preg_split('/[\s,]+/', $input);
            $serials = array_filter(array_map('trim', $serials));
            
            if(empty($serials)) {
                $error = "No valid serial numbers found.";
            } else {
                $placeholders = str_repeat('?,', count($serials) - 1) . '?';
                
                // Build query
                $stmt = $conn->prepare("
                    SELECT d.*, c.category_name
                    FROM devices d
                    JOIN categories c ON d.category_id = c.id
                    WHERE d.serial_number IN ($placeholders)
                    AND d.status = 'In Stock'
                    AND d.branch = ?
                ");
                
                // Combine serials and branch for query parameters
                $params = $serials;
                $params[] = $from_branch;
                
                $stmt->execute($params);
                $foundDevices = $stmt->fetchAll(PDO::FETCH_ASSOC);
                
                $foundSerials = array_column($foundDevices, 'serial_number');
                $notFoundSerials = array_diff($serials, $foundSerials);
                
                if(empty($foundDevices)) {
                    $error = "Devices not found in selected branch or not in stock.";
                } elseif(count($serials) === 1 && !empty($foundDevices)) {
                    $singleDevice = $foundDevices[0];
                    $foundDevices = [];
                }
                
                // Store branch selections and delivered_by in session for transfer
                $_SESSION['transfer_from_branch'] = $from_branch;
                $_SESSION['transfer_to_branch'] = $to_branch;
                $_SESSION['delivered_by'] = $delivered_by;
                $_SESSION['transfer_serials'] = $serials; // Store all serials for logging
            }
        }
    }
}

// Process single device transfer
if(isset($_POST['transfer_device'])) {
    $serial = $_POST['serial_number'];
    $from_branch = $_SESSION['transfer_from_branch'] ?? null;
    $to_branch = $_SESSION['transfer_to_branch'] ?? null;
    $delivered_by = $_SESSION['delivered_by'] ?? '';
    
    if(!$from_branch || !$to_branch) {
        $error = "Branch information missing. Please search again.";
    } elseif(empty($delivered_by)) {
        $error = "Delivery information missing. Please search again.";
    } else {
        // Check permissions again
        if(!$is_super_admin && $from_branch !== $current_branch) {
            $error = "You can only transfer devices from your own branch.";
        } else {
            // Verify device exists and is in the correct branch
            $stmt = $conn->prepare("
                SELECT d.*, c.category_name 
                FROM devices d
                JOIN categories c ON d.category_id = c.id
                WHERE d.serial_number = :sn 
                AND d.status = 'In Stock'
                AND d.branch = :branch
            ");
            $stmt->execute(['sn' => $serial, 'branch' => $from_branch]);
            $device = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if($device) {
                // Transfer the device
                $update = $conn->prepare("UPDATE devices SET branch = :to_branch WHERE serial_number = :sn");
                $update->execute(['to_branch' => $to_branch, 'sn' => $serial]);
                
                // Log the transfer with delivered_by information and serial number
                $log = $conn->prepare("
                    INSERT INTO activity_logs (user_id, action, details) 
                    VALUES (:uid, 'Transfer device', :details)
                ");
                $log->execute([
                    'uid' => $_SESSION['user_id'], 
                    'details' => "Transferred device SN: {$device['serial_number']} from $from_branch to $to_branch (Delivered by: $delivered_by)"
                ]);
                
                $success = "Device transferred successfully from $from_branch to $to_branch! (Delivered by: $delivered_by)";
                $singleDevice = null;
                $foundDevices = [];
                
                // Clear session data
                unset($_SESSION['transfer_from_branch'], $_SESSION['transfer_to_branch'], $_SESSION['delivered_by'], $_SESSION['transfer_serials']);
            } else {
                $error = "Device not found in selected branch or already sold.";
            }
        }
    }
}

// Process bulk device transfer
if(isset($_POST['transfer_bulk_devices'])) {
    $selectedSerials = $_POST['selected_serials'] ?? [];
    $from_branch = $_SESSION['transfer_from_branch'] ?? null;
    $to_branch = $_SESSION['transfer_to_branch'] ?? null;
    $delivered_by = $_SESSION['delivered_by'] ?? '';
    
    if(empty($selectedSerials)) {
        $error = "No devices selected for transfer.";
    } elseif(!$from_branch || !$to_branch) {
        $error = "Branch information missing. Please search again.";
    } elseif(empty($delivered_by)) {
        $error = "Delivery information missing. Please search again.";
    } else {
        // Check permissions again
        if(!$is_super_admin && $from_branch !== $current_branch) {
            $error = "You can only transfer devices from your own branch.";
        } else {
            $transferredCount = 0;
            $failedCount = 0;
            $transferredSerials = [];
            
            foreach($selectedSerials as $serial) {
                // Verify device exists and is in the correct branch
                $stmt = $conn->prepare("
                    SELECT d.* 
                    FROM devices d
                    WHERE d.serial_number = :sn 
                    AND d.status = 'In Stock'
                    AND d.branch = :branch
                ");
                $stmt->execute(['sn' => $serial, 'branch' => $from_branch]);
                $device = $stmt->fetch(PDO::FETCH_ASSOC);
                
                if($device) {
                    // Transfer the device
                    $update = $conn->prepare("UPDATE devices SET branch = :to_branch WHERE serial_number = :sn");
                    $update->execute(['to_branch' => $to_branch, 'sn' => $serial]);
                    $transferredCount++;
                    $transferredSerials[] = $serial;
                    
                    // Log each individual transfer with serial number
                    $log = $conn->prepare("
                        INSERT INTO activity_logs (user_id, action, details) 
                        VALUES (:uid, 'Transfer device', :details)
                    ");
                    $log->execute([
                        'uid' => $_SESSION['user_id'], 
                        'details' => "Transferred device SN: $serial from $from_branch to $to_branch (Delivered by: $delivered_by)"
                    ]);
                } else {
                    $failedCount++;
                }
            }
            
            if($transferredCount > 0) {
                // Also log a summary entry for the bulk transfer
                $log = $conn->prepare("
                    INSERT INTO activity_logs (user_id, action, details) 
                    VALUES (:uid, 'Bulk transfer summary', :details)
                ");
                $serialList = implode(', ', $transferredSerials);
                $log->execute([
                    'uid' => $_SESSION['user_id'], 
                    'details' => "Bulk transfer: $transferredCount device(s) [SN: $serialList] from $from_branch to $to_branch (Delivered by: $delivered_by)"
                ]);
                
                $success = "$transferredCount device(s) transferred successfully from $from_branch to $to_branch! (Delivered by: $delivered_by)";
                if($failedCount > 0) {
                    $success .= " $failedCount device(s) could not be transferred.";
                }
                $foundDevices = [];
                $notFoundSerials = [];
                
                // Clear session data
                unset($_SESSION['transfer_from_branch'], $_SESSION['transfer_to_branch'], $_SESSION['delivered_by'], $_SESSION['transfer_serials']);
            } else {
                $error = "No devices could be transferred.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Transfer Device</title>
<style>
body{font-family:Arial; background:#f4f7f6; padding:20px;}
.container{width:75%;margin:50px auto;background:#fff;padding:30px;border-radius:8px;box-shadow:0 4px 15px rgba(0,0,0,0.1);}
h2{text-align:center;color:#2f7a3f;margin-bottom:20px;}
input, select, button, textarea{width:100%; padding:10px; margin-bottom:15px; border-radius:5px; border:1px solid #ccc;}
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
.branch-selector{display:flex; gap:15px; margin-bottom:20px;}
.branch-selector div{flex:1;}
.branch-selector label{display:block; margin-bottom:5px; font-weight:bold; color:color;}
.branch-note{margin-top:-10px; margin-bottom:15px; color:#666; font-size:0.9em;}
.delivery-info{margin-bottom:20px;}
.delivery-info label{display:block; margin-bottom:5px; font-weight:bold; color:black;}
.details-table th {width: 20%;}
.details-table td {width: 30%;}
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

// Update branch dropdowns based on user role
document.addEventListener('DOMContentLoaded', function() {
    const fromBranchSelect = document.querySelector('select[name="from_branch"]');
    const toBranchSelect = document.querySelector('select[name="to_branch"]');
    const deliveredByInput = document.querySelector('input[name="delivered_by"]');
    const isSuperAdmin = <?= $is_super_admin ? 'true' : 'false' ?>;
    const currentBranch = '<?= addslashes($current_branch) ?>';
    
    // Focus on delivered_by field if it exists
    if(deliveredByInput) {
        deliveredByInput.focus();
    }
    
    if(!isSuperAdmin && currentBranch) {
        // Set from_branch to current branch and disable it
        if(fromBranchSelect) {
            fromBranchSelect.value = currentBranch;
            fromBranchSelect.disabled = true;
            
            // Also set a hidden input with the same value to ensure it gets posted
            const hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = 'from_branch';
            hiddenInput.value = currentBranch;
            fromBranchSelect.parentNode.appendChild(hiddenInput);
        }
        
        // Filter destination branches to exclude current branch
        if(toBranchSelect) {
            const options = toBranchSelect.options;
            for(let i = options.length - 1; i >= 0; i--) {
                if(options[i].value === currentBranch) {
                    toBranchSelect.remove(i);
                }
            }
            
            // Auto-select first option if only one remains
            if(toBranchSelect.options.length === 2) { // 1 option + "Select Destination Branch"
                toBranchSelect.selectedIndex = 1;
            }
        }
    }
});
</script>
</head>
<body>
<div class="container">

<a href="/inventory_system/dashboard/index.php" style="background:#007bff;color:white;padding:8px 12px;border-radius:5px;text-decoration:none;">Dashboard</a>

<h2>Transfer Device</h2>

<?php if($error): ?><div class="error"><?= $error ?></div><?php endif; ?>
<?php if($success): ?><div class="success"><?= $success ?></div><?php endif; ?>

<form method="POST" id="transferForm">
    <div class="branch-selector">
        <div>
            <label for="from_branch">Transfer From:</label>
            <select name="from_branch" id="from_branch" required <?= !$is_super_admin ? 'disabled' : '' ?>>
                <option value="">Select Source Branch</option>
                <?php foreach($availableBranches as $branch): ?>
                    <?php if($is_super_admin || $branch == $current_branch): ?>
                        <option value="<?= htmlspecialchars($branch) ?>" <?= (!$is_super_admin && $branch == $current_branch) ? 'selected' : (isset($_POST['from_branch']) && $_POST['from_branch'] == $branch ? 'selected' : '') ?>>
                            <?= htmlspecialchars($branch) ?>
                        </option>
                    <?php endif; ?>
                <?php endforeach; ?>
            </select>
            <?php if(!$is_super_admin): ?>
                <div class="branch-note">You can only transfer devices from: <strong><?= htmlspecialchars($current_branch) ?></strong></div>
                <!-- Hidden input to ensure branch value is posted even when select is disabled -->
                <input type="hidden" name="from_branch" value="<?= htmlspecialchars($current_branch) ?>">
            <?php endif; ?>
        </div>
        
        <div>
            <label for="to_branch">Transfer To:</label>
            <select name="to_branch" id="to_branch" required>
                <option value="">Select Destination Branch</option>
                <?php foreach($availableBranches as $branch): ?>
                    <?php if($is_super_admin || $branch != $current_branch): ?>
                        <option value="<?= htmlspecialchars($branch) ?>" <?= isset($_POST['to_branch']) && $_POST['to_branch'] == $branch ? 'selected' : '' ?>>
                            <?= htmlspecialchars($branch) ?>
                        </option>
                    <?php endif; ?>
                <?php endforeach; ?>
            </select>
            <?php if(!$is_super_admin): ?>
            <?php endif; ?>
        </div>
    </div>

    <div class="delivery-info">
        <label for="delivered_by">Delivered By (Person's Name):</label>
        <input type="text" name="delivered_by" id="delivered_by" placeholder="Enter the name of person delivering devices" value="<?= isset($_POST['delivered_by']) ? htmlspecialchars($_POST['delivered_by']) : (isset($_SESSION['delivered_by']) ? htmlspecialchars($_SESSION['delivered_by']) : '') ?>" required>
    </div>

    <textarea name="serial_number" placeholder="Type or scan serial numbers (one per line or comma separated)" rows="5" onkeydown="handleScannerInput(event)" required><?= isset($_POST['serial_number']) ? htmlspecialchars($_POST['serial_number']) : '' ?></textarea>
    <button type="submit" name="search_serial">Search Device(s)</button>
</form>

<?php if(!empty($notFoundSerials)): ?>
<div class="warning-box">
    <strong>Not Found:</strong> <?= implode(', ', $notFoundSerials) ?>
</div>
<?php endif; ?>

<?php if($singleDevice): ?>
<form method="POST">
    <h3>Device Details - Ready to Transfer</h3>
    <table class="details-table">
        <tr><th>Serial Number</th><td><?= htmlspecialchars($singleDevice['serial_number']) ?></td></tr>
        <tr><th>Model</th><td><?= htmlspecialchars($singleDevice['model_name']) ?></td></tr>
        <tr><th>Category</th><td><?= htmlspecialchars($singleDevice['category_name']) ?></td></tr>
        <tr><th>Processor</th><td><?= htmlspecialchars($singleDevice['processor']) ?></td></tr>
        <tr><th>Graphics</th><td><?= htmlspecialchars($singleDevice['graphics']) ?></td></tr>
        <tr><th>RAM</th><td><?= htmlspecialchars($singleDevice['ram']) ?> GB</td></tr>
        <tr><th>Storage</th><td><?= htmlspecialchars($singleDevice['storage_type']) ?> <?= htmlspecialchars($singleDevice['storage_capacity']) ?>GB</td></tr>
        <tr><th>Condition</th><td><?= htmlspecialchars($singleDevice['device_condition']) ?></td></tr>
        <tr><th>Touch</th><td><?= $singleDevice['touch'] ? 'Yes' : 'No' ?></td></tr>
        <tr><th>Current Branch</th><td><?= htmlspecialchars($singleDevice['branch']) ?></td></tr>
        <?php if(isset($_SESSION['transfer_to_branch'])): ?>
            <tr><th>Transfer To</th><td><?= htmlspecialchars($_SESSION['transfer_to_branch']) ?></td></tr>
        <?php endif; ?>
        <?php if(isset($_SESSION['delivered_by'])): ?>
            <tr><th>Delivered By</th><td><?= htmlspecialchars($_SESSION['delivered_by']) ?></td></tr>
        <?php endif; ?>
    </table>
    <input type="hidden" name="serial_number" value="<?= htmlspecialchars($singleDevice['serial_number']) ?>">
    <button type="submit" name="transfer_device">Confirm Transfer</button>
</form>
<?php endif; ?>

<?php if(!empty($foundDevices)): ?>
<form method="POST">
    <h3>Found Devices (<?= count($foundDevices) ?>) - Ready to Transfer</h3>
    <?php if(isset($_SESSION['transfer_to_branch'])): ?>
        <p><strong>Transferring to:</strong> <?= htmlspecialchars($_SESSION['transfer_to_branch']) ?></p>
    <?php endif; ?>
    <?php if(isset($_SESSION['delivered_by'])): ?>
        <p><strong>Delivered by:</strong> <?= htmlspecialchars($_SESSION['delivered_by']) ?></p>
    <?php endif; ?>
    
    <p><input type="checkbox" id="selectAll" onchange="selectAllCheckboxes(this)"> <label for="selectAll">Select All</label></p>
    <table>
        <tr>
            <th class="checkbox-cell">#</th>
            <th class="checkbox-cell">Transfer</th>
            <th>Serial Number</th>
            <th>Model</th>
            <th>Category</th>
            <th>Processor</th>
            <th>Graphics</th>
            <th>RAM</th>
            <th>Storage</th>
            <th>Condition</th>
            <th>Touch</th>
            <th>Current Branch</th>
        </tr>
        <?php foreach($foundDevices as $index => $device): ?>
        <tr>
            <td class="checkbox-cell"><?= $index + 1 ?></td>
            <td class="checkbox-cell"><input type="checkbox" name="selected_serials[]" value="<?= htmlspecialchars($device['serial_number']) ?>" checked></td>
            <td><?= htmlspecialchars($device['serial_number']) ?></td>
            <td><?= htmlspecialchars($device['model_name']) ?></td>
            <td><?= htmlspecialchars($device['category_name']) ?></td>
            <td><?= htmlspecialchars($device['processor']) ?></td>
            <td><?= htmlspecialchars($device['graphics']) ?></td>
            <td><?= htmlspecialchars($device['ram']) ?> GB</td>
            <td><?= htmlspecialchars($device['storage_type']) ?> <?= htmlspecialchars($device['storage_capacity']) ?>GB</td>
            <td><?= htmlspecialchars($device['device_condition']) ?></td>
            <td><?= $device['touch'] ? 'Yes' : 'No' ?></td>
            <td><?= htmlspecialchars($device['branch']) ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
    <button type="submit" name="transfer_bulk_devices">Transfer Selected Devices (<?= count($foundDevices) ?>)</button>
</form>
<?php endif; ?>

</div>
</body>
</html>