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
$foundComponents = [];
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
if(isset($_POST['search_components'])) {
    $_SESSION['delivered_by'] = trim($_POST['delivered_by'] ?? '');
}

// Process search for components in a branch
if(isset($_POST['search_components'])) {
    $from_branch = $_POST['from_branch'] ?? null;
    $to_branch = $_POST['to_branch'] ?? null;
    $delivered_by = trim($_POST['delivered_by'] ?? '');
    $category_filter = $_POST['category'] ?? ''; // RAM or SSD filter
    
    // If user is not super admin, force from_branch to be their current branch
    if(!$is_super_admin) {
        $from_branch = $current_branch;
    }
    
    if(empty($from_branch) || empty($to_branch)) {
        $error = "Please select both source and destination branches.";
    } elseif($from_branch === $to_branch) {
        $error = "Source and destination branches cannot be the same.";
    } elseif(empty($delivered_by)) {
        $error = "Please enter the name of the person delivering the components.";
    } else {
        // Check if user has permission to transfer from selected branch
        if(!$is_super_admin && $from_branch !== $current_branch) {
            $error = "You can only transfer components from your own branch.";
        } else {
            // Build query with optional category filter
            $sql = "
                SELECT * 
                FROM rams_ssds
                WHERE branch = ? 
                AND quantity > 0
            ";
            
            $params = [$from_branch];
            
            if(!empty($category_filter)) {
                $sql .= " AND category = ?";
                $params[] = $category_filter;
            }
            
            $sql .= " ORDER BY category, type, storage";
            
            $stmt = $conn->prepare($sql);
            $stmt->execute($params);
            $foundComponents = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            if(empty($foundComponents)) {
                $error = "No " . (!empty($category_filter) ? $category_filter . "s" : "components") . " found in selected branch.";
            }
            
            // Store branch selections and delivered_by in session for transfer
            $_SESSION['transfer_from_branch'] = $from_branch;
            $_SESSION['transfer_to_branch'] = $to_branch;
            $_SESSION['delivered_by'] = $delivered_by;
            $_SESSION['category_filter'] = $category_filter;
        }
    }
}

// Process components transfer
if(isset($_POST['transfer_components'])) {
    $components_to_transfer = $_POST['components'] ?? [];
    $from_branch = $_SESSION['transfer_from_branch'] ?? null;
    $to_branch = $_SESSION['transfer_to_branch'] ?? null;
    $delivered_by = $_SESSION['delivered_by'] ?? '';
    
    // Filter only checked components with quantity > 0
    $selectedComponents = [];
    foreach($components_to_transfer as $component_id => $transfer_data) {
        // Check if checkbox is checked (selected key exists and equals 1) AND quantity is set and > 0
        if(isset($transfer_data['selected']) && $transfer_data['selected'] == '1' && isset($transfer_data['quantity'])) {
            $transfer_quantity = (int)$transfer_data['quantity'];
            if($transfer_quantity > 0) {
                $selectedComponents[$component_id] = $transfer_quantity;
            }
        }
    }
    
    if(empty($selectedComponents)) {
        $error = "No components selected for transfer or quantity is 0.";
    } elseif(!$from_branch || !$to_branch) {
        $error = "Branch information missing. Please search again.";
    } elseif(empty($delivered_by)) {
        $error = "Delivery information missing. Please search again.";
    } else {
        // Check permissions again
        if(!$is_super_admin && $from_branch !== $current_branch) {
            $error = "You can only transfer components from your own branch.";
        } else {
            $transferredItems = 0;
            $failedItems = 0;
            $transferDetails = [];
            
            // Begin transaction
            $conn->beginTransaction();
            
            try {
                foreach($selectedComponents as $component_id => $transfer_quantity) {
                    // Get component details from source branch
                    $stmt = $conn->prepare("
                        SELECT * 
                        FROM rams_ssds 
                        WHERE id = ? 
                        AND branch = ? 
                        AND quantity >= ?
                    ");
                    $stmt->execute([$component_id, $from_branch, $transfer_quantity]);
                    $component = $stmt->fetch(PDO::FETCH_ASSOC);
                    
                    if($component) {
                        // Reduce quantity in source branch
                        $update_source = $conn->prepare("
                            UPDATE rams_ssds 
                            SET quantity = quantity - ?, 
                                updated_by = ?,
                                date_updated = CURRENT_TIMESTAMP
                            WHERE id = ? 
                            AND branch = ?
                        ");
                        $update_source->execute([
                            $transfer_quantity, 
                            $_SESSION['user_id'],
                            $component_id, 
                            $from_branch
                        ]);
                        
                        // Check if same component exists in destination branch
                        $stmt_dest = $conn->prepare("
                            SELECT * 
                            FROM rams_ssds 
                            WHERE category = ? 
                            AND type = ? 
                            AND storage = ? 
                            AND branch = ?
                        ");
                        $stmt_dest->execute([
                            $component['category'],
                            $component['type'],
                            $component['storage'],
                            $to_branch
                        ]);
                        $existing_component = $stmt_dest->fetch(PDO::FETCH_ASSOC);
                        
                        if($existing_component) {
                            // Update quantity in destination branch
                            $update_dest = $conn->prepare("
                                UPDATE rams_ssds 
                                SET quantity = quantity + ?, 
                                    updated_by = ?,
                                    date_updated = CURRENT_TIMESTAMP
                                WHERE id = ?
                            ");
                            $update_dest->execute([
                                $transfer_quantity, 
                                $_SESSION['user_id'],
                                $existing_component['id']
                            ]);
                        } else {
                            // Insert new component in destination branch
                            $insert_dest = $conn->prepare("
                                INSERT INTO rams_ssds 
                                (category, type, storage, quantity, branch, updated_by, date_updated) 
                                VALUES (?, ?, ?, ?, ?, ?, CURRENT_TIMESTAMP)
                            ");
                            $insert_dest->execute([
                                $component['category'],
                                $component['type'],
                                $component['storage'],
                                $transfer_quantity,
                                $to_branch,
                                $_SESSION['user_id']
                            ]);
                        }
                        
                        $transferredItems++;
                        // Format display based on category
                        if($component['category'] === 'RAM') {
                            $transferDetails[] = "{$component['type']} {$component['storage']}GB RAM x{$transfer_quantity}";
                        } else {
                            $transferDetails[] = "{$component['type']} {$component['storage']}GB SSD x{$transfer_quantity}";
                        }
                    } else {
                        $failedItems++;
                    }
                }
                
                // Commit transaction
                $conn->commit();
                
                if($transferredItems > 0) {
                    // Create ONE log entry for all transferred components
                    $log = $conn->prepare("
                        INSERT INTO activity_logs (user_id, action, details) 
                        VALUES (:uid, 'Transfer RAMs/SSDs', :details)
                    ");
                    
                    // Prepare the log details
                    $detailsList = implode(', ', $transferDetails);
                    $totalQuantity = array_sum($selectedComponents);
                    
                    $logDetails = "Transferred $transferredItems component type(s) ($totalQuantity total items) from $from_branch to $to_branch: $detailsList (Delivered by: $delivered_by)";
                    
                    $log->execute([
                        'uid' => $_SESSION['user_id'], 
                        'details' => $logDetails
                    ]);
                    
                    $success = "$transferredItems component type(s) ($totalQuantity total items) transferred successfully from $from_branch to $to_branch! (Delivered by: $delivered_by)";
                    if($failedItems > 0) {
                        $success .= " $failedItems item(s) could not be transferred.";
                    }
                    $foundComponents = [];
                    
                    // Clear session data
                    unset($_SESSION['transfer_from_branch'], $_SESSION['transfer_to_branch'], $_SESSION['delivered_by'], $_SESSION['category_filter']);
                } else {
                    $error = "No components could be transferred.";
                }
            } catch (Exception $e) {
                // Rollback transaction on error
                $conn->rollBack();
                $error = "Transfer failed: " . $e->getMessage();
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Transfer RAMs & SSDs</title>
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
.branch-selector label{display:block; margin-bottom:5px; font-weight:bold; color:black;}
.branch-note{margin-top:-10px; margin-bottom:15px; color:#666; font-size:0.9em;}
.delivery-info{margin-bottom:20px;}
.delivery-info label{display:block; margin-bottom:5px; font-weight:bold; color:black;}
.filter-info{margin-bottom:20px;}
.filter-info label{display:block; margin-bottom:5px; font-weight:bold; color:black;}
.details-table th {width: 20%;}
.details-table td {width: 30%;}
.quantity-input {width: 80px; text-align: center;}
.component-details {font-size: 0.9em; color: #666;}
</style>
<script>
// Select all checkboxes
function selectAllCheckboxes(source) {
    document.querySelectorAll('input[name^="components["]').forEach(cb => {
        if(cb.type === 'checkbox') {
            cb.checked = source.checked;
            // Enable quantity input if checkbox is checked
            const row = cb.closest('tr');
            const quantityInput = row.querySelector('.quantity-input');
            if(quantityInput) {
                quantityInput.disabled = !cb.checked;
                if(cb.checked && quantityInput.value === '0') {
                    quantityInput.value = '1';
                }
            }
        }
    });
}

// Enable/disable quantity input when checkbox is toggled
function toggleQuantityInput(checkbox) {
    const row = checkbox.closest('tr');
    const quantityInput = row.querySelector('.quantity-input');
    if(quantityInput) {
        quantityInput.disabled = !checkbox.checked;
        if(checkbox.checked && quantityInput.value === '0') {
            quantityInput.value = '1';
        } else if(!checkbox.checked) {
            quantityInput.value = '0';
        }
    }
}

// Validate quantity input
function validateQuantity(input) {
    const row = input.closest('tr');
    const maxQuantity = parseInt(row.querySelector('.max-quantity').value);
    const value = parseInt(input.value);
    
    if(isNaN(value) || value < 1) {
        input.value = '1';
        alert('Quantity must be at least 1');
    } else if(value > maxQuantity) {
        input.value = maxQuantity;
        alert(`Maximum available quantity is ${maxQuantity}`);
    }
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

<h2>Transfer RAMs & SSDs</h2>

<?php if($error): ?><div class="error"><?= $error ?></div><?php endif; ?>
<?php if($success): ?><div class="success"><?= $success ?></div><?php endif; ?>

<form method="POST" id="searchForm">
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
                <div class="branch-note">You can only transfer components from: <strong><?= htmlspecialchars($current_branch) ?></strong></div>
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
                <div class="branch-note">Select a different branch</div>
            <?php endif; ?>
        </div>
    </div>

    <div class="filter-info">
        <label for="category">Filter by Category (Optional):</label>
        <select name="category" id="category">
            <option value="">All Components</option>
            <option value="RAM" <?= isset($_POST['category']) && $_POST['category'] == 'RAM' ? 'selected' : '' ?>>RAM Only</option>
            <option value="SSD" <?= isset($_POST['category']) && $_POST['category'] == 'SSD' ? 'selected' : '' ?>>SSD Only</option>
        </select>
    </div>

    <div class="delivery-info">
        <label for="delivered_by">Delivered By (Person's Name):</label>
        <input type="text" name="delivered_by" id="delivered_by" placeholder="Enter the name of person delivering components" value="<?= isset($_POST['delivered_by']) ? htmlspecialchars($_POST['delivered_by']) : (isset($_SESSION['delivered_by']) ? htmlspecialchars($_SESSION['delivered_by']) : '') ?>" required>
    </div>

    <button type="submit" name="search_components">Search Available Components</button>
</form>

<?php if(!empty($foundComponents)): ?>
<form method="POST" id="transferForm">
    <h3>Available Components in <?= htmlspecialchars($_SESSION['transfer_from_branch'] ?? '') ?> - Ready to Transfer to <?= htmlspecialchars($_SESSION['transfer_to_branch'] ?? '') ?></h3>
    <?php if(isset($_SESSION['category_filter']) && !empty($_SESSION['category_filter'])): ?>
        <p><strong>Showing:</strong> <?= htmlspecialchars($_SESSION['category_filter']) ?> only</p>
    <?php endif; ?>
    <?php if(isset($_SESSION['delivered_by'])): ?>
        <p><strong>Delivered by:</strong> <?= htmlspecialchars($_SESSION['delivered_by']) ?></p>
    <?php endif; ?>
    
    <p><input type="checkbox" id="selectAll" onchange="selectAllCheckboxes(this)"> <label for="selectAll">Select All</label></p>
    <table>
        <tr>
            <th class="checkbox-cell">Select</th>
            <th>Category</th>
            <th>Type</th>
            <th>Storage</th>
            <th>Available Quantity</th>
            <th>Quantity to Transfer</th>
        </tr>
        <?php foreach($foundComponents as $component): ?>
        <tr>
            <td class="checkbox-cell">
                <input type="checkbox" 
                       name="components[<?= $component['id'] ?>][selected]" 
                       value="1" 
                       onchange="toggleQuantityInput(this)"
                       id="component_<?= $component['id'] ?>">
            </td>
            <td><label for="component_<?= $component['id'] ?>"><?= htmlspecialchars($component['category']) ?></label></td>
            <td><?= htmlspecialchars($component['type']) ?></td>
            <td><?= htmlspecialchars($component['storage']) ?>GB</td>
            <td><?= htmlspecialchars($component['quantity']) ?></td>
            <td>
                <input type="hidden" name="components[<?= $component['id'] ?>][max]" class="max-quantity" value="<?= $component['quantity'] ?>">
                <input type="number" 
                       name="components[<?= $component['id'] ?>][quantity]" 
                       class="quantity-input" 
                       min="1" 
                       max="<?= $component['quantity'] ?>" 
                       value="0" 
                       disabled
                       onchange="validateQuantity(this)">
                <div class="component-details">Max: <?= $component['quantity'] ?></div>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
    <button type="submit" name="transfer_components">Transfer Selected Components</button>
</form>
<?php endif; ?>

</div>
</body>
</html>