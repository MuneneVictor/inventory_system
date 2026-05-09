<?php
session_start();
require_once "../config/db.php";
require_once "../includes/auth_check.php";

$role = $_SESSION['role'];
$user_id = $_SESSION['user_id'];

$search_sn = trim($_GET['sn'] ?? '');
$search_model = trim($_GET['model'] ?? '');
$searched = ($search_sn || $search_model);

$deviceResults = [];
$monitorResults = [];
$printerResults = [];

if ($searched) {
    // Search in devices table
    $deviceSql = "SELECT d.*, c.category_name, u.full_name AS added_by_name, d.branch
            FROM devices d
            JOIN categories c ON d.category_id = c.id
            LEFT JOIN users u ON d.added_by = u.id
            WHERE d.status = 'In Stock'";

    $deviceParams = [];

    if ($search_sn) {
        $deviceSql .= " AND d.serial_number LIKE :sn";
        $deviceParams['sn'] = "%$search_sn%";
    }

    if ($search_model) {
        $deviceSql .= " AND d.model_name LIKE :model";
        $deviceParams['model'] = "%$search_model%";
    }

    $stmt = $conn->prepare($deviceSql);
    $stmt->execute($deviceParams);
    $deviceResults = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Search in monitors table
    $monitorSql = "SELECT m.*, u.full_name AS added_by_name
            FROM monitors m
            LEFT JOIN users u ON m.added_by = u.id
            WHERE m.status = 'In Stock'";

    $monitorParams = [];

    if ($search_sn) {
        $monitorSql .= " AND m.serial_number LIKE :sn";
        $monitorParams['sn'] = "%$search_sn%";
    }

    if ($search_model) {
        $monitorSql .= " AND m.model_name LIKE :model";
        $monitorParams['model'] = "%$search_model%";
    }

    $stmt = $conn->prepare($monitorSql);
    $stmt->execute($monitorParams);
    $monitorResults = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Search in printers table
    $printerSql = "SELECT p.*, u.full_name AS added_by_name
            FROM printers p
            LEFT JOIN users u ON p.added_by = u.id
            WHERE p.status = 'In Stock'";

    $printerParams = [];

    if ($search_sn) {
        $printerSql .= " AND p.serial_number LIKE :sn";
        $printerParams['sn'] = "%$search_sn%";
    }

    if ($search_model) {
        $printerSql .= " AND p.model_name LIKE :model";
        $printerParams['model'] = "%$search_model%";
    }

    $stmt = $conn->prepare($printerSql);
    $stmt->execute($printerParams);
    $printerResults = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Search Inventory</title>

<style>
body { font-family: Arial; background:#f4f7f6; padding:20px; }
.container {
    width:90%; margin:40px auto; padding:25px;
    background:#fff; border-radius:8px; overflow-x: auto;
    box-shadow:0 4px 15px rgba(0,0,0,0.1);
}
h2 { text-align:center; color:#2f7a3f; margin-bottom:20px; }
input[type=text] {
    padding:10px; width:260px; border:1px solid #ccc;
    border-radius:5px; margin-right:10px;
}
button {
    padding:10px 20px; background:#2f7a3f; color:#fff;
    border:none; border-radius:5px; cursor:pointer;
}
button:hover { background:#1f5a2d; }
table { width:100%; border-collapse: collapse; margin-top:20px; min-width: 1100px; }
th, td { border:1px solid #ccc; padding:8px; font-size:0.9em; }
th { background:#2f7a3f; color:#fff; white-space: nowrap; }
a.btn-back {
    padding:10px 15px; background:#007bff; color:white;
    border-radius:6px; text-decoration:none; font-weight:bold;
}
a.btn-back:hover { background:#0056b3; }
.view-btn {
    padding: 6px 12px;
    background: #007bff;
    color: white;
    text-decoration: none;
    border-radius: 4px;
    font-weight: bold;
    display: inline-block;
    text-align: center;
    transition: background 0.3s;
}
.view-btn:hover {
    background: #1f5a2d;
}
.wrap-model { max-width: 150px; word-wrap: break-word; white-space: normal; }
.wrap-processor { max-width: 140px; word-wrap: break-word; white-space: normal; }
.wrap-graphics { max-width: 140px; word-wrap: break-word; white-space: normal; }
.section-title {
    background: #e8f5e8;
    padding: 10px;
    border-radius: 5px;
    margin-top: 20px;
    border-left: 4px solid #2f7a3f;
    font-weight: bold;
}
</style>

</head>
<body>

<div class="container">

<a href="/inventory_system/dashboard/index.php" class="btn-back">Dashboard</a>

<h2>Search Inventory (In Stock)</h2>

<form method="GET">
    <input type="text" name="model"
           placeholder="Search by model (e.g. HP EliteBook)"
           value="<?= htmlspecialchars($search_model) ?>">

    <input type="text" name="sn"
           placeholder="Scan or type Serial Number"
           value="<?= htmlspecialchars($search_sn) ?>">

    <button type="submit">Search</button>
</form>

<?php if($searched): ?>
    <?php 
        $totalResults = count($deviceResults) + count($monitorResults) + count($printerResults);
    ?>
    
    <p style="margin-top:15px; padding:10px; background:#f8f9fa; border-radius:5px;">
        <strong>Search Results:</strong> Found <?= $totalResults ?> item(s)
        <?php if($search_sn): ?> • Serial: "<?= htmlspecialchars($search_sn) ?>"<?php endif; ?>
        <?php if($search_model): ?> • Model: "<?= htmlspecialchars($search_model) ?>"<?php endif; ?>
    </p>

    <!-- Devices Results -->
    <?php if(!empty($deviceResults)): ?>
    <div class="section-title">Devices (<?= count($deviceResults) ?>)</div>
    <table>
        <tr>
            <th>#</th>
            <th>Serial Number</th>
            <th>Category</th>
            <th>Model</th>
            <th>Branch</th>
            <th>Processor</th>
            <th>RAM</th>
            <th>Storage</th>
            <th>Graphics</th>
            <th>Touch?</th>
            <th>Price (KES)</th>
            <th>Added By</th>
            <th>Date Added</th>
            <th>Actions</th>
        </tr>

        <?php $i=1; foreach($deviceResults as $d): ?>
        <tr>
            <td><?= $i++ ?></td>
            <td><?= htmlspecialchars($d['serial_number']) ?></td>
            <td><?= htmlspecialchars($d['category_name']) ?></td>
            <td class="wrap-model"><?= htmlspecialchars($d['model_name']) ?></td>
            <td style=" color:<?= $d['branch'] == 'KIMATHI' ? '#2f7a3f' : '#007bff' ?>;">
                <?= htmlspecialchars($d['branch']) ?>
            </td>
            <td class="wrap-processor"><?= htmlspecialchars($d['processor']) ?></td>
            <td><?= htmlspecialchars($d['ram']) ?> GB</td>
            <td><?= htmlspecialchars($d['storage_type']." ".$d['storage_capacity']."GB") ?></td>
            <td class="wrap-graphics"><?= htmlspecialchars($d['graphics'] ?? 'N/A') ?></td>
            <td>
                <?php 
                    if (strtolower($d['category_name']) === 'desktop') echo "N/A";
                    else echo htmlspecialchars($d['touch'] ?? 'N/A');
                ?>
            </td>
            <td><?= $d['price'] ? 'KES ' . number_format($d['price'], 2) : '-' ?></td>
            <td><?= htmlspecialchars($d['added_by_name'] ?? 'Unknown') ?></td>
            <td><?= htmlspecialchars(date('Y-m-d H:i:s', strtotime($d['date_added']))) ?></td>
            <td>
                <a href="../devices/view_device.php?sn=<?= $d['serial_number'] ?>" class="view-btn">View</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
    <?php endif; ?>

    <!-- Monitors Results -->
    <?php if(!empty($monitorResults)): ?>
    <div class="section-title">Monitors (<?= count($monitorResults) ?>)</div>
    <table>
        <tr>
            <th>#</th>
            <th>Serial Number</th>
            <th>Model</th>
            <th>Size (Inches)</th>
            <th>Branch</th>
            <th>Price (KES)</th>
            <th>Added By</th>
            <th>Date Added</th>
            <th>Actions</th>
        </tr>

        <?php $i=1; foreach($monitorResults as $m): ?>
        <tr>
            <td><?= $i++ ?></td>
            <td><?= htmlspecialchars($m['serial_number']) ?></td>
            <td><?= htmlspecialchars($m['model_name']) ?></td>
            <td><?= htmlspecialchars($m['size_inches']) ?>"</td>
            <td style=" color:<?= $m['branch'] == 'KIMATHI' ? '#2f7a3f' : '#007bff' ?>;">
                <?= htmlspecialchars($m['branch']) ?>
            </td>
            <td><?= $m['price'] ? 'KES ' . number_format($m['price'], 2) : '-' ?></td>
            <td><?= htmlspecialchars($m['added_by_name'] ?? 'Unknown') ?></td>
            <td><?= htmlspecialchars(date('Y-m-d H:i:s', strtotime($m['date_added']))) ?></td>
            <td>
                <a href="../monitors/view_monitor.php?sn=<?= $m['serial_number'] ?>" class="view-btn">View</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
    <?php endif; ?>

    <!-- Printers Results -->
    <?php if(!empty($printerResults)): ?>
    <div class="section-title">Printers (<?= count($printerResults) ?>)</div>
    <table>
        <tr>
            <th>#</th>
            <th>Serial Number</th>
            <th>Model</th>
            <th>Branch</th>
            <th>Price (KES)</th>
            <th>Added By</th>
            <th>Date Added</th>
            <th>Actions</th>
        </tr>

        <?php $i=1; foreach($printerResults as $p): ?>
        <tr>
            <td><?= $i++ ?></td>
            <td><?= htmlspecialchars($p['serial_number']) ?></td>
            <td><?= htmlspecialchars($p['model_name']) ?></td>
            <td style=" color:<?= $p['branch'] == 'KIMATHI' ? '#2f7a3f' : '#007bff' ?>;">
                <?= htmlspecialchars($p['branch']) ?>
            </td>
            <td><?= $p['price'] ? 'KES ' . number_format($p['price'], 2) : '-' ?></td>
            <td><?= htmlspecialchars($p['added_by_name'] ?? 'Unknown') ?></td>
            <td><?= htmlspecialchars(date('Y-m-d H:i:s', strtotime($p['date_added']))) ?></td>
            <td>
                <a href="../printers/view_printer.php?sn=<?= $p['serial_number'] ?>" class="view-btn">View</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
    <?php endif; ?>

    <?php if($totalResults === 0): ?>
    <p style="text-align:center; padding:20px; background:#f8f9fa; border-radius:5px;">
        No matching in-stock items found.
    </p>
    <?php endif; ?>

<?php endif; ?>

</div>

</body>
</html>