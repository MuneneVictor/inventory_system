<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
require_once "../config/db.php";
require_once "../includes/auth_check.php";

// Check if user is logged in and has inventory_admin OR super_admin role
if(!isset($_SESSION['user_id']) || !in_array($_SESSION['role'], ['inventory_admin', 'super_admin'])){
    header("Location: ../dashboard/index.php");
    exit();
}

$role = $_SESSION['role'];
$user_id = $_SESSION['user_id'];

// Initialize variables
$branch = null;
$error = "";
$success = "";
$stocks = [];
$sales_users = [];
$all_branches = [];

// For super_admin: fetch all branches
if ($role === 'super_admin') {
    try {
        $branch_stmt = $conn->prepare("SELECT DISTINCT branch FROM users WHERE branch IS NOT NULL ORDER BY branch");
        $branch_stmt->execute();
        $all_branches = $branch_stmt->fetchAll(PDO::FETCH_COLUMN);
    } catch (PDOException $e) {
        die("Database error: " . $e->getMessage());
    }
}

// Fetch user's branch from database (only for non-super_admin)
if ($role !== 'super_admin') {
    try {
        $user_stmt = $conn->prepare("SELECT branch FROM users WHERE id = :user_id");
        $user_stmt->execute(['user_id' => $user_id]);
        $user = $user_stmt->fetch(PDO::FETCH_ASSOC);
        
        if($user && isset($user['branch'])) {
            $branch = $user['branch'];
        } else {
            $branch = null;
            $error = "Your account is not assigned to any branch. Please contact administrator.";
        }
    } catch (PDOException $e) {
        die("Database error: " . $e->getMessage());
    }
}

// Handle branch selection for super_admin
if ($role === 'super_admin' && isset($_GET['selected_branch']) && $_GET['selected_branch']) {
    $branch = $_GET['selected_branch'];
} elseif ($role === 'super_admin' && empty($branch) && !empty($all_branches)) {
    // Auto-select first branch if none selected
    $branch = $all_branches[0];
}

// Only fetch data if branch is set
if ($branch) {
    try {
        // Fetch available RAMs & SSDs
        $stocks_stmt = $conn->prepare("SELECT * FROM rams_ssds WHERE branch=:branch AND quantity>0 ORDER BY category,type,storage");
        $stocks_stmt->execute(['branch'=>$branch]);
        $stocks = $stocks_stmt->fetchAll(PDO::FETCH_ASSOC);

        // Fetch sales users in selected branch
        $sales_stmt = $conn->prepare("SELECT id, full_name FROM users WHERE role='sales' AND branch=:branch");
        $sales_stmt->execute(['branch'=>$branch]);
        $sales_users = $sales_stmt->fetchAll(PDO::FETCH_ASSOC);
        
    } catch (PDOException $e) {
        $error = "Database error: " . $e->getMessage();
    }
}

// Handle form submission
if($_SERVER['REQUEST_METHOD'] === 'POST' && $branch){
    $category = $_POST['category'] ?? '';
    $type = $_POST['type'] ?? '';
    $storage = intval($_POST['storage'] ?? 0);
    $quantity_given = intval($_POST['quantity'] ?? 0);
    $given_to = $_POST['given_to'] ?? '';

    if(!$category || !$type || !$storage || !$quantity_given || !$given_to){
        $error = "All fields are required.";
    } else {
        try {
            // Check if the stock exists in this branch
            $stock_stmt = $conn->prepare("SELECT * FROM rams_ssds WHERE category=:category AND type=:type AND storage=:storage AND branch=:branch");
            $stock_stmt->execute([
                'category'=>$category,
                'type'=>$type,
                'storage'=>$storage,
                'branch'=>$branch
            ]);
            $stock = $stock_stmt->fetch(PDO::FETCH_ASSOC);

            if(!$stock){
                $error = "This RAM/SSD configuration is not available in stock for " . ($role === 'super_admin' ? "selected branch" : "your branch") . ".";
            } elseif($stock['quantity'] < $quantity_given){
                $error = "Not enough quantity in stock.";
            } else {
                // Start transaction
                $conn->beginTransaction();
                
                // Deduct stock
                $new_qty = $stock['quantity'] - $quantity_given;
                $update_stmt = $conn->prepare("UPDATE rams_ssds SET quantity=:qty, updated_by=:updated_by, date_updated=NOW() WHERE id=:id");
                $update_stmt->execute([
                    'qty'=>$new_qty,
                    'updated_by'=>$user_id,
                    'id'=>$stock['id']
                ]);

                // Insert log
                $log_stmt = $conn->prepare("INSERT INTO rams_ssds_logs 
                    (ram_ssd_id, category, type, storage, quantity_given, given_to, given_by, branch)
                    VALUES (:ram_ssd_id,:category,:type,:storage,:quantity_given,:given_to,:given_by,:branch)");
                $log_stmt->execute([
                    'ram_ssd_id'=>$stock['id'],
                    'category'=>$category,
                    'type'=>$type,
                    'storage'=>$storage,
                    'quantity_given'=>$quantity_given,
                    'given_to'=>$given_to,
                    'given_by'=>$user_id,
                    'branch'=>$branch
                ]);

                // Activity log
                $given_to_name = getFullName($conn, $given_to);
                $branch_name = $branch;
                $activity_stmt = $conn->prepare("INSERT INTO activity_logs (user_id, action, details) 
                    VALUES (:uid,'Given RAM/SSD', :details)");
                $activity_stmt->execute([
                    'uid'=>$user_id,
                    'details'=>"Given {$quantity_given} {$category} ({$storage}GB) to {$given_to_name} in {$branch_name}"
                ]);

                $conn->commit();
                $success = "RAM/SSD given successfully!";
                
                // Refresh stock list after successful transaction
                $stocks_stmt = $conn->prepare("SELECT * FROM rams_ssds WHERE branch=:branch AND quantity>0 ORDER BY category,type,storage");
                $stocks_stmt->execute(['branch'=>$branch]);
                $stocks = $stocks_stmt->fetchAll(PDO::FETCH_ASSOC);
                
                // Refresh sales users list
                $sales_stmt = $conn->prepare("SELECT id, full_name FROM users WHERE role='sales' AND branch=:branch");
                $sales_stmt->execute(['branch'=>$branch]);
                $sales_users = $sales_stmt->fetchAll(PDO::FETCH_ASSOC);
            }
        } catch (Exception $e) {
            $conn->rollBack();
            $error = "Error processing request: " . $e->getMessage();
        }
    }
}

function getFullName($conn, $user_id){
    try {
        $stmt = $conn->prepare("SELECT full_name FROM users WHERE id=:id");
        $stmt->execute(['id'=>$user_id]);
        return $stmt->fetchColumn() ?? 'Unknown';
    } catch (PDOException $e) {
        return 'Unknown';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Give RAM/SSD</title>
<style>
body { font-family: Arial; background:#f4f7f6; margin:0; padding:0; }
.container { max-width:800px; margin:30px auto; background:#fff; padding:30px; border-radius:8px; box-shadow:0 4px 15px rgba(0,0,0,0.1); }
h2 { text-align:center; color:#2f7a3f; margin-bottom:20px; }
label { font-weight:bold; display:block; margin-top:15px; margin-bottom:5px; }
input, select { width:100%; padding:10px; margin-bottom:15px; border-radius:5px; border:1px solid #ccc; }
button { width:100%; padding:12px; background:#2f7a3f; color:#fff; border:none; border-radius:5px; font-weight:bold; cursor:pointer; }
button:hover { background:#1f5a2d; }
.error { color:#d32f2f; text-align:center; margin-bottom:15px; }
.success { color:#2f7a3f; text-align:center; margin-bottom:15px; }
.branch-selector { background:#e8f5e9; padding:15px; border-radius:5px; margin-bottom:20px; }
.branch-selector label { margin-top:0; }
.user-role { text-align:center; color:#555; margin-bottom:15px; font-weight:bold; }
</style>
</head>
<body>
<div class="container">
    <a href="/inventory_system/dashboard/index.php"
       style="position: top:10px; right:10px; padding:10px 15px; 
              background:#007bff; color:white; border-radius:6px; 
              text-decoration:none; font-weight:bold; z-index:999;">
        Dashboard
    </a>
    
    <h2>Give RAM/SSD</h2>
    
    <div class="user-role">
        Logged in as: <?= htmlspecialchars(strtoupper($role)) ?>
    </div>
    
    <?php if($role === 'super_admin'): ?>
    <div class="branch-selector">
        <form method="GET" action="">
            <label>Select Branch:</label>
            <select name="selected_branch" onchange="this.form.submit()">
                <option value="">-- Select Branch --</option>
                <?php foreach($all_branches as $b): ?>
                    <option value="<?= htmlspecialchars($b) ?>" <?= ($branch === $b) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($b) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </form>
    </div>
    <?php endif; ?>
    
    <?php if($error): ?>
        <div class="error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <?php if($success): ?>
        <div class="success"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>

    <?php if($branch): ?>
        <?php if($role === 'super_admin'): ?>
            <div style="text-align:center; margin-bottom:15px; color:#1a73e8;">
                Currently viewing: <strong><?= htmlspecialchars($branch) ?></strong> branch
            </div>
        <?php endif; ?>
        
        <?php if(empty($sales_users)): ?>
            <div class="error">No sales users found in <?= htmlspecialchars($branch) ?> branch.</div>
        <?php else: ?>
        <form method="POST">
            <label>Category</label>
            <select name="category" required>
                <option value="">Select Category</option>
                <option value="RAM">RAM</option>
                <option value="SSD">SSD</option>
            </select>

            <label>Type</label>
            <select name="type" required>
                <option value="">Select Type</option>
                <option value="DDR3">DDR3</option>
                <option value="DDR4">DDR4</option>
                <option value="DDR5">DDR5</option>
                <option value="SATA">SATA (SSD)</option>
                <option value="NVMe">NVMe (SSD)</option>
            </select>

            <label>Storage (GB)</label>
            <input type="number" name="storage" min="1" required>

            <label>Quantity</label>
            <input type="number" name="quantity" min="1" required>

            <label>Give To (Salesperson)</label>
            <select name="given_to" required>
                <option value="">Select Salesperson</option>
                <?php foreach($sales_users as $sales): ?>
                    <option value="<?= $sales['id'] ?>"><?= htmlspecialchars($sales['full_name']) ?></option>
                <?php endforeach; ?>
            </select>

            <button type="submit">Give out RAM/SSD</button>
        </form>
        <?php endif; ?>
        
    <?php elseif($role !== 'super_admin'): ?>
        <p>Your account is not assigned to any branch. Please contact administrator.</p>
    <?php endif; ?>

</div>
</body>
</html>