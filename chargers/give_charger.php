<?php
session_start();
require_once "../config/db.php";
require_once "../includes/auth_check.php";

// Always get branch directly from database, not from session
$user_id = $_SESSION['user_id'];
$role = $_SESSION['role'];

// Get user's branch directly from database
$stmt = $conn->prepare("SELECT branch FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user_data = $stmt->fetch(PDO::FETCH_ASSOC);
$user_branch = $user_data['branch'] ?? null;

// Update session for consistency
if ($user_branch) {
    $_SESSION['branch'] = $user_branch;
}

$user_name  = $_SESSION['name'] ?? 'Unknown';

// Debug: Log actual database values
error_log("User ID: " . $user_id);
error_log("Role: " . $role);
error_log("Branch from DATABASE: " . $user_branch);

// Only inventory_admin and maintenance
if (!in_array($role, ['inventory_admin','maintenance'])) {
    die("Access denied!");
}

$error = "";
$success = "";

// Get chargers in stock - FILTER BY USER'S BRANCH FROM DATABASE
if (!empty($user_branch)) {
    // User has a branch, only show chargers from that branch
    $stmt = $conn->prepare("SELECT * FROM chargers WHERE quantity > 0 AND branch = ? ORDER BY charger_type, watts");
    $stmt->execute([$user_branch]);
    error_log("Charger query for branch: " . $user_branch);
} else {
    // User has no branch assigned, show no chargers
    $stmt = $conn->prepare("SELECT * FROM chargers WHERE quantity > 0 AND 1 = 0");
    $stmt->execute();
    error_log("No branch assigned for user");
}
$chargers = $stmt->fetchAll(PDO::FETCH_ASSOC);
error_log("Chargers found: " . count($chargers));

// Fetch users to give charger to - FILTER BY USER'S BRANCH FROM DATABASE
if (!empty($user_branch)) {
    // Only show sales users from the same branch
    $users_stmt = $conn->prepare("
        SELECT id, full_name, role, branch 
        FROM users 
        WHERE role IN ('sales') AND branch = ?
        ORDER BY full_name
    ");
    $users_stmt->execute([$user_branch]);
    $users = $users_stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // If no users found, show helpful message
    if (count($users) === 0) {
        $error .= " No sales users found in your branch (" . htmlspecialchars($user_branch) . ").";
    }
    error_log("Sales users found in branch " . $user_branch . ": " . count($users));
} else {
    $error = "Your branch information is not set in the database. Please contact admin.";
    $users = [];
    error_log("No branch, no users to show");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $charger_id   = (int)($_POST['charger_id'] ?? 0);
    $quantity     = (int)($_POST['quantity'] ?? 0);
    $recipient_id = (int)($_POST['recipient_id'] ?? 0);

    if (!$charger_id || !$quantity || !$recipient_id) {
        $error = "Please fill all fields.";
    } else {

        // Fetch selected charger
        $stmt = $conn->prepare("SELECT * FROM chargers WHERE id=:id");
        $stmt->execute(['id' => $charger_id]);
        $charger = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$charger) {
            $error = "Charger not found!";
        } elseif ($quantity > $charger['quantity']) {
            $error = "Not enough quantity in stock!";
        } else {
            // Check if charger is from user's branch
            if (!empty($user_branch) && $charger['branch'] !== $user_branch) {
                $error = "You cannot give a charger that is not from your branch! Charger is from " . htmlspecialchars($charger['branch']) . " but you are from " . htmlspecialchars($user_branch);
            } else {

                // Fetch recipient user
                $stmt = $conn->prepare("SELECT * FROM users WHERE id=:id");
                $stmt->execute(['id' => $recipient_id]);
                $recipient = $stmt->fetch(PDO::FETCH_ASSOC);

                if (!$recipient) {
                    $error = "Recipient not found!";
                }
                // Check if recipient is in same branch
                elseif ($recipient['branch'] != $user_branch) {
                    $error = "You cannot give a charger to a user in another branch! Recipient is in " . htmlspecialchars($recipient['branch']) . " but you are in " . htmlspecialchars($user_branch);
                } 
                else {

                    // Deduct stock
                    $new_quantity = $charger['quantity'] - $quantity;

                    $upd = $conn->prepare("
                        UPDATE chargers 
                        SET quantity=:q, updated_by=:uid, date_updated=NOW() 
                        WHERE id=:id
                    ");
                    $upd->execute([
                        'q'  => $new_quantity,
                        'uid'=> $user_id,
                        'id' => $charger_id
                    ]);

                    // Insert into logs
                    $ins = $conn->prepare("
                        INSERT INTO charger_logs 
                        (charger_id, quantity, given_to, given_by, branch, date_given)
                        VALUES (:cid, :qty, :to, :by, :branch, NOW())
                    ");
                    $ins->execute([
                        'cid'   => $charger_id,
                        'qty'   => $quantity,
                        'to'    => $recipient_id,
                        'by'    => $user_id,
                        'branch'=> $charger['branch'] // comes from charger stock data
                    ]);

                    $success = "Successfully gave $quantity x {$charger['charger_type']} ({$charger['watts']}W, {$charger['charger_condition']}) to {$recipient['full_name']}.";
                }
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Give Charger</title>
<style>
body{font-family:Arial;background:#f4f7f6;margin:0;padding:0}
.container{max-width:800px;margin:30px auto;background:#fff;padding:25px;border-radius:8px;box-shadow:0 4px 15px rgba(0,0,0,0.1)}
h2{color:#2f7a3f;text-align:center;margin-bottom:15px}
input, select, textarea{padding:10px;border:1px solid #ccc;border-radius:5px;width:100%;margin-bottom:15px}
button, .dashboard-btn{padding:10px 14px;background:#007bff;border:none;color:#fff;border-radius:5px;cursor:pointer;text-decoration:none;display:inline-block;margin-bottom:10px}
button:hover, .dashboard-btn:hover{background: #007bff;}
.success{color:#2f7a3f;margin-bottom:10px}
.error{color:#d32f2f;margin-bottom:10px}
label{font-weight:bold}
.debug-info{background:#f0f0f0; padding:10px; margin:10px 0; border-radius:5px; border-left:4px solid #2f7a3f;}
.debug-info h4{margin-top:0; color:#2f7a3f;}
</style>
</head>
<body>
<div class="container">
<a href="/inventory_system/dashboard/index.php" class="dashboard-btn">Dashboard</a>
<h2>Give Charger</h2>

<?php if($error): ?><div class="error"><?=htmlspecialchars($error)?></div><?php endif;?>
<?php if($success): ?><div class="success"><?=htmlspecialchars($success)?></div><?php endif;?>

<!-- Debug Info (remove after fixing) -->


<form method="POST">
    <label>Charger Type (Watts)</label>
    <select name="charger_id">
        <option value="">--Select Charger--</option>
        <?php foreach($chargers as $c): ?>
            <option value="<?=$c['id']?>">
                <?=htmlspecialchars($c['charger_type'])?> 
                (<?=$c['watts']?>W, <?=$c['charger_condition']?>, Stock: <?=$c['quantity']?>)
                <?php if(isset($c['branch'])): ?> - Branch: <?=htmlspecialchars($c['branch'])?><?php endif; ?>
            </option>
        <?php endforeach; ?>
    </select>

    <label>Quantity to Give</label>
    <input type="number" name="quantity" min="1" placeholder="Quantity">

    <label>Give To</label>
    <select name="recipient_id">
        <option value="">--Select User--</option>
        <?php foreach($users as $u): ?>
            <option value="<?=$u['id']?>">
                <?=htmlspecialchars($u['full_name'])?> (<?=htmlspecialchars($u['role'])?>)
                <?php if(isset($u['branch'])): ?> - Branch: <?=htmlspecialchars($u['branch'])?><?php endif; ?>
            </option>
        <?php endforeach; ?>
    </select>

    <button type="submit">Give Charger</button>
</form>
</div>
</body>
</html>