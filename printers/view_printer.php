<?php
session_start();
require_once "../config/db.php";
require_once "../includes/auth_check.php";

if (!isset($_GET['sn'])) die("Serial number not provided!");

$serial_number = trim($_GET['sn']);

$stmt = $conn->prepare("SELECT p.*, u.full_name AS added_by_name FROM printers p 
                        LEFT JOIN users u ON p.added_by = u.id 
                        WHERE p.serial_number = :sn");
$stmt->execute(['sn' => $serial_number]);
$printer = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$printer) die("Printer not found!");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>View Printer - <?= htmlspecialchars($printer['serial_number']) ?></title>
<style>
    body { font-family: Arial, sans-serif; background: #f4f7f6; margin:0; padding:0; }
    .container { max-width: 700px; margin: 30px auto; background:#fff; padding:20px; border-radius:8px; box-shadow:0 4px 15px rgba(0,0,0,0.1);}
    h2 { text-align:center; color:#2f7a3f; margin-bottom:20px; }
    .details { margin-bottom:20px; }
    .details p { margin:5px 0; font-size:16px; }
</style>
</head>
<body>
<div class="container">
     <a href="/inventory_system/dashboard/index.php"
   style="position: top:10px; right:10px; padding:10px 15px; 
          background:#007bff; color:white; border-radius:6px; 
          text-decoration:none; font-weight:bold; z-index:999;">
    Dashboard
</a> <br><br>
    <h2>Printer Details</h2>

    <div class="details">
        <p><strong>Serial Number:</strong> <?= $printer['serial_number'] ?></p>
        <p><strong>Model Name:</strong> <?= $printer['model_name'] ?></p>
        <p><strong>Branch:</strong> <?= $printer['branch'] ?></p>
        <p><strong>Status:</strong> <?= $printer['status'] ?></p>
        <p><strong>Added By:</strong> <?= $printer['added_by_name'] ?? 'Unknown' ?></p>
        <p><strong>Date Added:</strong> <?= $printer['date_added'] ?></p>
        <?php if($printer['status'] == 'Sold'): ?>
            <p><strong>Date Sold:</strong> <?= $printer['date_sold'] ?? '-' ?></p>
        <?php endif; ?>
    </div>
</div>
</body>
</html>