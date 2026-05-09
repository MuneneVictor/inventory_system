<?php
session_start();
require_once "../config/db.php";
require_once "../includes/auth_check.php";

if (!isset($_GET['sn'])) die("Serial number not provided!");

$serial_number = trim($_GET['sn']);

$stmt = $conn->prepare("SELECT m.*, u.full_name AS added_by_name FROM monitors m 
                        LEFT JOIN users u ON m.added_by = u.id 
                        WHERE m.serial_number = :sn");
$stmt->execute(['sn' => $serial_number]);
$monitor = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$monitor) die("Monitor not found!");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>View Monitor - <?= htmlspecialchars($monitor['serial_number']) ?></title>
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
    <h2>Monitor Details</h2>

    <div class="details">
        <p><strong>Serial Number:</strong> <?= $monitor['serial_number'] ?></p>
        <p><strong>Model Name:</strong> <?= $monitor['model_name'] ?></p>
        <p><strong>Size:</strong> <?= $monitor['size_inches'] ?> inches</p>
        <p><strong>Branch:</strong> <?= $monitor['branch'] ?></p>
        <p><strong>Status:</strong> <?= $monitor['status'] ?></p>
        <p><strong>Price:</strong> <?= $monitor['price'] ? 'KES ' . number_format($monitor['price'], 2) : 'Not priced' ?></p>
        <p><strong>Added By:</strong> <?= $monitor['added_by_name'] ?? 'Unknown' ?></p>
        <p><strong>Date Added:</strong> <?= $monitor['date_added'] ?></p>
        <?php if($monitor['status'] == 'Sold'): ?>
            <p><strong>Date Sold:</strong> <?= $monitor['sold_at'] ?? '-' ?></p>
        <?php endif; ?>
    </div>
</div>
</body>
</html>