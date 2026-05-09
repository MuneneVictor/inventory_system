<?php
session_start();
require_once "../config/db.php";
require_once "../includes/auth_check.php";

// Only inventory admin
if (!in_array($_SESSION['role'], ['inventory_admin','manager', 'super_admin'])) {
    die("OOPS! ACCESS DENIED!");
}

$role = $_SESSION['role'];
$user_id = $_SESSION['user_id'];
$user_name = $_SESSION['name'] ?? 'Unknown';

$error = "";
$success = "";

// Charger type options - fixed array
$charger_types = ['HP Blue Pin', 'HP Big pin', 'HP Type C', 'Lenovo Type C', 'Lenovo USB', 'Dell Small Pin', 'Dell Big Pin', 'Dell Type C'];
$watts_options = [45, 65, 90, 120, 130, 150, 180, 240];
$condition_options = ['new', 'ex-uk',];

// Get the current user's branch from users table
$stmt = $conn->prepare("SELECT branch FROM users WHERE id = :id");
$stmt->execute(['id' => $user_id]);
$user_branch = $stmt->fetchColumn() ?? 'Main Branch'; // Default if null

// Define the two branches
$available_branches = ['KIMATHI', 'MOI']; // Your two branches

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $type = trim($_POST['type'] ?? '');
    $watts = (int)($_POST['watts'] ?? 0);
    $condition = trim($_POST['condition'] ?? '');
    $quantity = (int)($_POST['quantity'] ?? 0);
    $branch = trim($_POST['branch'] ?? $user_branch);
    
    // Validation
    if (empty($type) || !in_array($type, $charger_types)) {
        $error = "Please select a valid charger type.";
    } elseif ($watts <= 0 || !in_array($watts, $watts_options)) {
        $error = "Please select a valid wattage.";
    } elseif (empty($condition) || !in_array($condition, $condition_options)) {
        $error = "Please select a valid condition.";
    } elseif ($quantity <= 0) {
        $error = "Quantity must be at least 1.";
    } elseif (empty($branch) || !in_array($branch, $available_branches)) {
        $error = "Please select a valid branch.";
    } else {
        try {
            // Check if charger already exists for this branch, type, watts, and condition
            $checkStmt = $conn->prepare("SELECT id, quantity FROM chargers WHERE charger_type = :type AND watts = :watts AND charger_condition = :condition AND branch = :branch");
            $checkStmt->execute([
                'type' => $type,
                'watts' => $watts,
                'condition' => $condition,
                'branch' => $branch
            ]);
            $existing = $checkStmt->fetch(PDO::FETCH_ASSOC);
            
            if ($existing) {
                // Update existing charger quantity
                $newQuantity = $existing['quantity'] + $quantity;
                $updateStmt = $conn->prepare("UPDATE chargers SET quantity = :quantity, updated_by = :updated_by, date_updated = NOW() WHERE id = :id");
                $updateStmt->execute([
                    'quantity' => $newQuantity,
                    'updated_by' => $user_id,
                    'id' => $existing['id']
                ]);
                $success = "Updated existing charger: $quantity added. Total now $newQuantity x $type ($watts W, $condition) at $branch.";
            } else {
                // Insert new charger
                $stmt = $conn->prepare("INSERT INTO chargers (charger_type, watts, quantity, charger_condition, branch, updated_by, date_updated) VALUES (:type, :watts, :quantity, :condition, :branch, :updated_by, NOW())");
                $stmt->execute([
                    'type' => $type,
                    'watts' => $watts,
                    'quantity' => $quantity,
                    'condition' => $condition,
                    'branch' => $branch,
                    'updated_by' => $user_id
                ]);
                $success = "$quantity x $type ($watts W, $condition) added to $branch.";
            }
            
            // Clear form after successful submission (optional)
            $_POST = [];
            
        } catch (Exception $e) {
            $error = "Error adding charger: " . $e->getMessage();
            // Log error for debugging
            error_log("Charger Add Error: " . $e->getMessage());
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Add Charger</title>
<style>
body{font-family:Arial,sans-serif;background:#f4f7f6;margin:0;padding:0}
.container{max-width:800px;margin:30px auto;background:#fff;padding:25px;border-radius:8px;box-shadow:0 4px 15px rgba(0,0,0,0.1)}
h2{color:#2f7a3f;text-align:center;margin-bottom:20px}
.form-group{margin-bottom:15px}
label{display:block;font-weight:bold;margin-bottom:5px;color:#333}
input, select, textarea{padding:10px;border:1px solid #ddd;border-radius:5px;width:100%;box-sizing:border-box;font-size:14px}
input:focus, select:focus{border-color:#2f7a3f;outline:none;box-shadow:0 0 5px rgba(47,122,63,0.3)}
button{padding:12px 20px;background:#2f7a3f;border:none;color:#fff;border-radius:5px;cursor:pointer;font-size:16px;font-weight:bold;width:100%;margin-top:10px}
button:hover{background:#1f5a2d}
.success{color:#2f7a3f;margin-bottom:15px;padding:10px;background:#e7f7e7;border-radius:5px;border-left:4px solid #2f7a3f}
.error{color:#d32f2f;margin-bottom:15px;padding:10px;background:#ffe7e7;border-radius:5px;border-left:4px solid #d32f2f}
.info-box{background:#e7f3ff;border-left:4px solid #007bff;padding:12px 15px;margin-bottom:20px;border-radius:4px}
.info-box strong{color:#007bff}
.dashboard-btn{display:inline-block;padding:8px 16px;background:#007bff;color:#fff;border-radius:6px;text-decoration:none;font-weight:bold;margin-bottom:15px}
.dashboard-btn:hover{background:#0056b3;text-decoration:none}
.required{color:#d32f2f}
</style>
</head>
<body>
<div class="container">
<a href="/inventory_system/dashboard/index.php" class="dashboard-btn">← Dashboard</a>

<h2>Add Charger</h2>

<div class="info-box">
    <strong>Your Branch:</strong> <?= htmlspecialchars($user_branch) ?><br>
    <small>Chargers will be added to your branch by default. You can select the other branch if needed.</small>
</div>

<?php if($error): ?>
    <div class="error"><?=htmlspecialchars($error)?></div>
<?php endif;?>

<?php if($success): ?>
    <div class="success"><?=htmlspecialchars($success)?></div>
<?php endif;?>

<form method="POST" id="chargerForm">
    <div class="form-group">
        <label for="type">Charger Type <span class="required">*</span></label>
        <select name="type" id="type" required>
            <option value="">--Select Type--</option>
            <?php foreach($charger_types as $t): ?>
                <option value="<?=htmlspecialchars($t)?>" <?= isset($_POST['type']) && $_POST['type'] == $t ? 'selected' : '' ?>>
                    <?=htmlspecialchars($t)?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="form-group">
        <label for="watts">Watts <span class="required">*</span></label>
        <select name="watts" id="watts" required>
            <option value="">--Select Watts--</option>
            <?php foreach($watts_options as $w): ?>
                <option value="<?=$w?>" <?= isset($_POST['watts']) && $_POST['watts'] == $w ? 'selected' : '' ?>>
                    <?=$w?> W
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="form-group">
        <label for="condition">Condition <span class="required">*</span></label>
        <select name="condition" id="condition" required>
            <option value="">--Select Condition--</option>
            <?php foreach($condition_options as $c): ?>
                <option value="<?=htmlspecialchars($c)?>" <?= isset($_POST['condition']) && $_POST['condition'] == $c ? 'selected' : '' ?>>
                    <?=htmlspecialchars($c)?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="form-group">
        <label for="quantity">Quantity <span class="required">*</span></label>
        <input type="number" name="quantity" id="quantity" min="1" value="<?= isset($_POST['quantity']) ? htmlspecialchars($_POST['quantity']) : '1' ?>" placeholder="Enter quantity" required>
    </div>

    <div class="form-group">
        <label for="branch">Branch <span class="required">*</span></label>
        <select name="branch" id="branch" required>
            <?php foreach($available_branches as $branch_name): ?>
                <option value="<?= htmlspecialchars($branch_name) ?>" 
                    <?= (isset($_POST['branch']) && $_POST['branch'] == $branch_name) || 
                        (!isset($_POST['branch']) && $branch_name == $user_branch) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($branch_name) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <button type="submit">Add Charger</button>
</form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Form validation
    document.getElementById('chargerForm').addEventListener('submit', function(e) {
        // Validate quantity
        const quantityInput = document.getElementById('quantity');
        if (parseInt(quantityInput.value) < 1) {
            e.preventDefault();
            quantityInput.setCustomValidity('Quantity must be at least 1');
            quantityInput.reportValidity();
            quantityInput.focus();
            return false;
        }
        
        return true;
    });
});
</script>
</body>
</html>