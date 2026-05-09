<?php
session_start();
require_once "../config/db.php";
require_once "../includes/auth_check.php";

// Check if user is logged in
if(!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

$role = $_SESSION['role'];
$user_id = $_SESSION['user_id'];

// Only inventory admin or super admin can add
if(!in_array($role, ['super_admin','inventory_admin', 'manager'])) {
    header("Location: ../dashboard/index.php");
    exit();
}

// Fetch user's branch for inventory_admin
$user_stmt = $conn->prepare("SELECT branch FROM users WHERE id = :user_id");
$user_stmt->execute(['user_id' => $user_id]);
$user_data = $user_stmt->fetch(PDO::FETCH_ASSOC);
$user_branch = $user_data['branch'] ?? null;

// For super_admin: fetch all branches
$all_branches = [];
if ($role === 'super_admin') {
    try {
        $branch_stmt = $conn->prepare("SELECT DISTINCT branch FROM users WHERE branch IS NOT NULL ORDER BY branch");
        $branch_stmt->execute();
        $all_branches = $branch_stmt->fetchAll(PDO::FETCH_COLUMN);
    } catch (PDOException $e) {
        die("Database error: " . $e->getMessage());
    }
}

$error = "";
$success = "";

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $category = $_POST['category'] ?? '';
    $type = trim($_POST['type'] ?? '');
    $storage = intval($_POST['storage'] ?? 0);
    $quantity = intval($_POST['quantity'] ?? 0);
    
    // Branch logic: super_admin can select any branch, inventory_admin uses their branch
    if ($role === 'super_admin') {
        $branch = $_POST['branch'] ?? '';
    } else {
        $branch = $user_branch;
    }

    // Validate inputs
    if(!$category || !$type || !$storage || !$quantity || !$branch){
        $error = "All fields are required.";
    } elseif($storage <= 0) {
        $error = "Storage must be greater than 0 GB.";
    } elseif($quantity <= 0) {
        $error = "Quantity must be greater than 0.";
    } elseif($role === 'inventory_admin' && !$user_branch) {
        $error = "Your account is not assigned to any branch. Please contact administrator.";
    } elseif($role === 'inventory_admin' && $branch !== $user_branch) {
        $error = "You can only add items to your assigned branch ($user_branch).";
    } else {
        try {
            // Check if item already exists in this branch with same category, type, and storage
            $check_stmt = $conn->prepare("SELECT id, quantity FROM rams_ssds WHERE category=:category AND type=:type AND storage=:storage AND branch=:branch");
            $check_stmt->execute([
                'category' => $category,
                'type' => $type,
                'storage' => $storage,
                'branch' => $branch
            ]);
            $existing_item = $check_stmt->fetch(PDO::FETCH_ASSOC);

            if($existing_item) {
                // Update existing item quantity (increase by the new quantity)
                $new_quantity = $existing_item['quantity'] + $quantity;
                $update_stmt = $conn->prepare("UPDATE rams_ssds SET quantity=:quantity, updated_by=:updated_by, date_updated=NOW() WHERE id=:id");
                $update_stmt->execute([
                    'quantity' => $new_quantity,
                    'updated_by' => $user_id,
                    'id' => $existing_item['id']
                ]);
                
                $action_type = "Updated";
                $message_action = "increased";
            } else {
                // Insert new item
                $insert_stmt = $conn->prepare("INSERT INTO rams_ssds (category, type, storage, quantity, branch, updated_by) 
                                VALUES (:category, :type, :storage, :quantity, :branch, :updated_by)");
                $insert_stmt->execute([
                    'category' => $category,
                    'type' => $type,
                    'storage' => $storage,
                    'quantity' => $quantity,
                    'branch' => $branch,
                    'updated_by' => $user_id
                ]);
                
                $action_type = "Added";
                $message_action = "added";
            }

            // Log activity
            $activity_stmt = $conn->prepare("INSERT INTO activity_logs (user_id, action, details) 
                            VALUES (:uid, :action, :details)");
            $activity_stmt->execute([
                'uid' => $user_id,
                'action' => $action_type . ' RAM/SSD',
                'details' => $quantity . ' ' . $category . '(s) of type ' . $type . ' (' . $storage . 'GB) ' . $message_action . ' in ' . $branch
            ]);

            $success = "RAM/SSD " . strtolower($message_action) . " successfully!";
            
        } catch (PDOException $e) {
            $error = "Database error: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Add RAM/SSD</title>
<style>
body{font-family:Arial; background:#f4f7f6; margin:0; padding:0;}
.container{max-width:600px;margin:30px auto;background:#fff;padding:25px;border-radius:8px;box-shadow:0 4px 15px rgba(0,0,0,0.1);}
h2{text-align:center;color:#2f7a3f;margin-bottom:20px;}
.user-role { text-align:center; color:#555; margin-bottom:15px; font-weight:bold; }
label{display:block; margin-bottom:5px; font-weight:bold; margin-top:10px;}
input, select{width:100%;padding:12px;margin-bottom:15px;border-radius:5px;border:1px solid #ccc; box-sizing:border-box;}
button{width:100%;padding:12px;background:#2f7a3f;color:#fff;border:none;border-radius:5px;font-weight:bold;cursor:pointer;}
button:hover{background:#1f5a2d;}
.error{color:#d32f2f;text-align:center;margin-bottom:15px; padding:10px; background:#ffeaea; border-radius:5px;}
.success{color:#2f7a3f;text-align:center;margin-bottom:15px; padding:10px; background:#e8f5e8; border-radius:5px;}
a.dashboard-btn{display:inline-block;margin-bottom:20px;background:#007bff;color:#fff;padding:10px 15px;border-radius:6px;text-decoration:none;font-weight:bold;}
a.dashboard-btn:hover{background:#005fa3;}
.info-note {color:#666; font-size:12px; margin-top:-10px; margin-bottom:15px;}
.super-admin-note {color:#1a73e8; background:#e8f5e8; padding:10px; border-radius:5px; margin-bottom:15px; text-align:center;}
</style>
</head>
<body>
<div class="container">
<a href="/inventory_system/dashboard/index.php" class="dashboard-btn">Dashboard</a>
<h2>Add RAM / SSD</h2>

<div class="user-role">
    Logged in as: <?= htmlspecialchars(strtoupper($role)) ?>
</div>

<?php if($role === 'super_admin'): ?>
    <div class="super-admin-note">
        <strong>Super Admin Mode:</strong> You can add RAM/SSD to any branch
    </div>
<?php endif; ?>

<?php if($error): ?>
    <div class="error"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<?php if($success): ?>
    <div class="success"><?= htmlspecialchars($success) ?></div>
<?php endif; ?>

<?php if($role === 'inventory_admin' && !$user_branch): ?>
    <div class="error">Your account is not assigned to any branch. Please contact administrator.</div>
<?php else: ?>
    <form method="POST">
        <label>Category</label>
        <select name="category" required>
            <option value="">-- Select Category --</option>
            <option value="RAM">RAM</option>
            <option value="SSD">SSD</option>
        </select>

        <label>Type</label>
        <input type="text" name="type" placeholder="e.g. DDR3, SATA" required>
        <p class="info-note">For RAM: DDR3, DDR4, DDR5. For SSD: SATA or NVMe</p>

        <label>Storage Capacity (GB)</label>
        <input type="number" name="storage" min="1" placeholder="e.g. 8 for RAM, 256 for SSD" required>
        <p class="info-note">Enter storage capacity in GB (e.g., 8GB RAM, 256GB SSD)</p>

        <label>Quantity</label>
        <input type="number" name="quantity" min="1" placeholder="Number of units" required>

        <label>Branch</label>
        <?php if($role === 'super_admin'): ?>
            <select name="branch" required>
                <option value="">-- Select Branch --</option>
                <?php foreach($all_branches as $branch_name): ?>
                    <option value="<?= htmlspecialchars($branch_name) ?>" 
                        <?= isset($_POST['branch']) && $_POST['branch'] === $branch_name ? 'selected' : '' ?>>
                        <?= htmlspecialchars($branch_name) ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <p class="info-note">You can select any branch</p>
        <?php else: ?>
            <!-- For inventory_admin: show disabled select with hidden input -->
            <select name="branch_display" disabled>
                <option value="<?= htmlspecialchars($user_branch) ?>" selected>
                    <?= htmlspecialchars($user_branch) ?>
                </option>
            </select>
            <input type="hidden" name="branch" value="<?= htmlspecialchars($user_branch) ?>">
            <p class="info-note">You can only add items to your assigned branch: <strong><?= htmlspecialchars($user_branch) ?></strong></p>
        <?php endif; ?>

        <button type="submit">Add RAM/SSD</button>
    </form>
<?php endif; ?>
</div>
</body>
</html>