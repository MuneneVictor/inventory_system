<?php
session_start();
require_once "../config/db.php";
require_once "../includes/auth_check.php";

// Only sales users
if($_SESSION['role'] !== 'sales'){
    die("Access denied!");
}

$error = "";
$success = "";

// Get salesperson's branch from users table
$user_id = $_SESSION['user_id'];
$user_stmt = $conn->prepare("SELECT branch FROM users WHERE id = :id");
$user_stmt->execute(['id' => $user_id]);
$salesperson = $user_stmt->fetch(PDO::FETCH_ASSOC);
$salesperson_branch = $salesperson['branch'] ?? null;

// Handle search by serial number
$monitor = null;
if(isset($_POST['search_serial'])){
    $serial = trim($_POST['serial_number']);

    // Check monitor exists in salesperson's branch and is in stock
    $stmt = $conn->prepare("
        SELECT * 
        FROM monitors 
        WHERE serial_number = :sn 
        AND status='In Stock'
        AND branch = :branch
    ");
    $stmt->execute([
        'sn' => $serial,
        'branch' => $salesperson_branch
    ]);
    $monitor = $stmt->fetch(PDO::FETCH_ASSOC);

    if(!$monitor){
        $error = "Monitor not found in your branch or not in stock.";
    }
}

// Handle selling the monitor
if(isset($_POST['sell_monitor'])){
    $serial = $_POST['serial_number'];

    $stmt = $conn->prepare("
        SELECT * 
        FROM monitors 
        WHERE serial_number = :sn 
        AND status='In Stock'
        AND branch = :branch
    ");
    $stmt->execute([
        'sn' => $serial,
        'branch' => $salesperson_branch
    ]);
    $monitor = $stmt->fetch(PDO::FETCH_ASSOC);

    if($monitor){
        // Update monitor status to Sold
        $update = $conn->prepare("
            UPDATE monitors 
            SET status = 'Sold', 
                sold_by = :sold_by, 
                sold_at = NOW() 
            WHERE serial_number = :sn
        ");
        $update->execute([
            'sold_by' => $_SESSION['user_id'],
            'sn' => $serial
        ]);

        // Log activity
        $log = $conn->prepare("INSERT INTO activity_logs (user_id, action, details) VALUES (:uid, 'Sold monitor', :details)");
        $log->execute([
            'uid'=>$_SESSION['user_id'], 
            'details'=>"Sold monitor SN: {$monitor['serial_number']} ({$monitor['model_name']})"
        ]);

        $success = "Monitor sold successfully!";
        $monitor = null;
    } else {
        $error = "Monitor not found in your branch or already sold.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Sell Monitor</title>
<style>
body{font-family:Arial; background:#f4f7f6; padding:20px;}
.container{max-width:600px;margin:50px auto;background:#fff;padding:30px;border-radius:8px;box-shadow:0 4px 15px rgba(0,0,0,0.1);}
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

<h2>Sell Monitor</h2>

<?php if($error): ?><div class="error"><?= $error ?></div><?php endif; ?>
<?php if($success): ?><div class="success"><?= $success ?></div><?php endif; ?>

<!-- Search Form -->
<form method="POST">
    <input type="text" name="serial_number" placeholder="Scan or enter serial number" required autofocus>
    <button type="submit" name="search_serial">Search Monitor</button>
</form>

<?php if($monitor): ?>
<form method="POST">
    <h3>Monitor Details</h3>
    <table>
        <tr><th>Serial Number</th><td><?= $monitor['serial_number'] ?></td></tr>
        <tr><th>Model</th><td><?= $monitor['model_name'] ?></td></tr>
        <tr><th>Size</th><td><?= $monitor['size_inches'] ?> inches</td></tr>
        <tr><th>Branch</th><td><?= $monitor['branch'] ?></td></tr>
        <tr><th>Date Added</th><td><?= $monitor['date_added'] ?></td></tr>
    </table>

    <input type="hidden" name="serial_number" value="<?= $monitor['serial_number'] ?>">
    <button type="submit" name="sell_monitor">Confirm Sale</button>
</form>
<?php endif; ?>

</div>
</body>
</html>