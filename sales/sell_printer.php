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
$printer = null;
if(isset($_POST['search_serial'])){
    $serial = trim($_POST['serial_number']);

    // Check printer exists in salesperson's branch and is in stock
    $stmt = $conn->prepare("
        SELECT * 
        FROM printers 
        WHERE serial_number = :sn 
        AND status='In Stock'
        AND branch = :branch
    ");
    $stmt->execute([
        'sn' => $serial,
        'branch' => $salesperson_branch
    ]);
    $printer = $stmt->fetch(PDO::FETCH_ASSOC);

    if(!$printer){
        $error = "Printer not found in your branch or not in stock.";
    }
}

// Handle selling the printer
if(isset($_POST['sell_printer'])){
    $serial = $_POST['serial_number'];

    $stmt = $conn->prepare("
        SELECT * 
        FROM printers 
        WHERE serial_number = :sn 
        AND status='In Stock'
        AND branch = :branch
    ");
    $stmt->execute([
        'sn' => $serial,
        'branch' => $salesperson_branch
    ]);
    $printer = $stmt->fetch(PDO::FETCH_ASSOC);

    if($printer){
        // Update printer status to Sold
        $update = $conn->prepare("
            UPDATE printers 
            SET status = 'Sold', 
                sold_by = :sold_by, 
                date_sold = NOW() 
            WHERE serial_number = :sn
        ");
        $update->execute([
            'sold_by' => $_SESSION['user_id'],
            'sn' => $serial
        ]);

        // Log activity
        $log = $conn->prepare("INSERT INTO activity_logs (user_id, action, details) VALUES (:uid, 'Sold printer', :details)");
        $log->execute([
            'uid'=>$_SESSION['user_id'], 
            'details'=>"Sold printer SN: {$printer['serial_number']} ({$printer['model_name']})"
        ]);

        $success = "Printer sold successfully!";
        $printer = null;
    } else {
        $error = "Printer not found in your branch or already sold.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Sell Printer</title>
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

<h2>Sell Printer</h2>

<?php if($error): ?><div class="error"><?= $error ?></div><?php endif; ?>
<?php if($success): ?><div class="success"><?= $success ?></div><?php endif; ?>

<!-- Search Form -->
<form method="POST">
    <input type="text" name="serial_number" placeholder="Scan or enter serial number" required autofocus>
    <button type="submit" name="search_serial">Search Printer</button>
</form>

<?php if($printer): ?>
<form method="POST">
    <h3>Printer Details</h3>
    <table>
        <tr><th>Serial Number</th><td><?= $printer['serial_number'] ?></td></tr>
        <tr><th>Model</th><td><?= $printer['model_name'] ?></td></tr>
        <tr><th>Branch</th><td><?= $printer['branch'] ?></td></tr>
        <tr><th>Date Added</th><td><?= $printer['date_added'] ?></td></tr>
    </table>

    <input type="hidden" name="serial_number" value="<?= $printer['serial_number'] ?>">
    <button type="submit" name="sell_printer">Confirm Sale</button>
</form>
<?php endif; ?>

</div>
</body>
</html>