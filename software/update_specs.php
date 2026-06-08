<?php
session_start();
require_once "../config/db.php";
require_once "../includes/auth_check.php";

// Access: software and inventory_admin
if (!in_array($_SESSION['role'], ['software', 'inventory_admin'])) {
    die("Access denied!");
}

$role = $_SESSION['role'];
$user_id = $_SESSION['user_id'];
$user_name = $_SESSION['name'] ?? 'Unknown';

$error = "";
$success = "";
$device = null;
$serial_search = trim($_GET['sn'] ?? '');

// Fetch device for GET request
if ($_SERVER['REQUEST_METHOD'] === 'GET' && $serial_search) {
    $stmt = $conn->prepare("
        SELECT d.*, c.category_name, u.full_name AS added_by_name
        FROM devices d
        JOIN categories c ON d.category_id = c.id
        LEFT JOIN users u ON d.added_by = u.id
        WHERE d.serial_number = :sn AND d.status = 'In Stock'
    ");
    $stmt->execute(['sn' => $serial_search]);
    $device = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$device) {
        $error = "Device not found or not In Stock.";
    }
}

// Handle POST update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $serial = trim($_POST['serial_number']);

    // Fetch device
    $stmt = $conn->prepare("SELECT * FROM devices WHERE serial_number = :sn AND status = 'In Stock'");
    $stmt->execute(['sn' => $serial]);
    $deviceRow = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$deviceRow) {
        $error = "Device not found or not In Stock.";
    } else {

        // Old values
        $old_ram = (int)$deviceRow['ram'];
        $old_storage_capacity = (int)$deviceRow['storage_capacity'];
        $old_storage_type = $deviceRow['storage_type'] ?? '';
        $old_graphics = $deviceRow['graphics'] ?? null;

        // Incoming values
        $new_ram_raw = trim($_POST['new_ram'] ?? '');
        $new_storage_capacity_raw = trim($_POST['new_storage_capacity'] ?? '');
        $new_storage_type = trim($_POST['new_storage_type'] ?? '');
        $new_graphics_raw = trim($_POST['new_graphics'] ?? '');
        $notes = trim($_POST['notes'] ?? '');

        // Determine new values
        $new_ram = ($new_ram_raw === "" ? $old_ram : (int)$new_ram_raw);
        $new_storage_capacity = ($new_storage_capacity_raw === "" ? $old_storage_capacity : (int)$new_storage_capacity_raw);

        // Determine storage type
        if ($new_storage_type === "same" || $new_storage_type === "") {
            $new_storage_type = $old_storage_type;
        }

        // Determine graphics
        $graphics_changed = false;
        if ($new_graphics_raw !== "") {
            if ($new_graphics_raw !== $old_graphics) {
                $graphics_changed = true;
            }
            $new_graphics = $new_graphics_raw;
        } else {
            $new_graphics = $old_graphics;
        }

        try {
            $conn->beginTransaction();

            // Insert maintenance record (pure INT values stored)
            $ins = $conn->prepare("
                INSERT INTO maintenance
                (device_serial, old_ram, new_ram, old_storage, new_storage, old_graphics, new_graphics, performed_by, notes)
                VALUES (:device_serial, :old_ram, :new_ram, :old_storage, :new_storage, :old_graphics, :new_graphics, :performed_by, :notes)
            ");

            $ins->execute([
                'device_serial' => $serial,
                'old_ram' => $old_ram,
                'new_ram' => $new_ram,
                'old_storage' => $old_storage_capacity,
                'new_storage' => $new_storage_capacity,
                'old_graphics' => $old_graphics ?: null,
                'new_graphics' => $new_graphics ?: null,
                'performed_by' => $user_id,
                'notes' => $notes ?: null
            ]);

            // Build dynamic update query
            $updateFields = [];
            $updateParams = ['sn' => $serial];

            if ($new_ram !== $old_ram) {
                $updateFields[] = "ram = :ram";
                $updateParams['ram'] = $new_ram;
            }

            if ($new_storage_capacity !== $old_storage_capacity || $new_storage_type !== $old_storage_type) {
                $updateFields[] = "storage_capacity = :storage_capacity";
                $updateFields[] = "storage_type = :storage_type";
                $updateParams['storage_capacity'] = $new_storage_capacity;
                $updateParams['storage_type'] = $new_storage_type;
            }

            if ($graphics_changed) {
                $updateFields[] = "graphics = :graphics";
                $updateParams['graphics'] = $new_graphics;
            }

            // Perform device update
            if (!empty($updateFields)) {
                $sql = "UPDATE devices SET " . implode(", ", $updateFields) . " WHERE serial_number = :sn";
                $upd = $conn->prepare($sql);
                $upd->execute($updateParams);
            }

            // Build activity log message
            $log_details = "Updated specs for $serial by $user_name.";

            if ($new_ram !== $old_ram) {
                $log_details .= " RAM: From {$old_ram}GB to {$new_ram}GB.";
            }

            if ($new_storage_capacity !== $old_storage_capacity || $new_storage_type !== $old_storage_type) {
                $log_details .= " Storage: From {$old_storage_type} {$old_storage_capacity}GB to {$new_storage_type} {$new_storage_capacity}GB.";
            }

            if ($graphics_changed) {
                $log_details .= " Graphics: From " . ($old_graphics ?: 'None') . " to " . ($new_graphics ?: 'None') . ".";
            }

            // Activity log insert
            $alog = $conn->prepare("
                INSERT INTO activity_logs (user_id, action, details)
                VALUES (:uid, 'Maintenance - Update Specs', :details)
            ");
            $alog->execute([
                'uid' => $user_id,
                'details' => $log_details
            ]);

            $conn->commit();
            $success = "Maintenance recorded successfully.";

            // Reload device
            $stmt = $conn->prepare("
                SELECT d.*, c.category_name, u.full_name AS added_by_name
                FROM devices d
                JOIN categories c ON d.category_id = c.id
                LEFT JOIN users u ON d.added_by = u.id
                WHERE d.serial_number = :sn
            ");
            $stmt->execute(['sn' => $serial]);
            $device = $stmt->fetch(PDO::FETCH_ASSOC);

        } catch (Exception $e) {
            $conn->rollBack();
            $error = "Error processing update: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Update Device Specs</title>
<style>
body{font-family:Arial;background:#f4f7f6;margin:0;padding:0}
.container{max-width:900px;margin:30px auto;background:#fff;padding:25px;border-radius:8px;box-shadow:0 4px 15px rgba(0,0,0,0.1)}
h2{color:#2f7a3f;text-align:center;margin-bottom:15px}
form.search{display:flex;gap:10px;align-items:center;margin-bottom:20px}
input[type=text], input[type=number], textarea, select{padding:10px;border:1px solid #ccc;border-radius:5px}
button{padding:10px 14px;background:#2f7a3f;border:none;color:#fff;border-radius:5px;cursor:pointer}
button:hover{background:#1f5a2d}
.success{color:#2f7a3f;margin-bottom:10px}
.error{color:#d32f2f;margin-bottom:10px}
label{display:block;margin-top:10px;font-weight:bold}
.readonly{background:#f6f6f6;padding:8px;border-radius:4px;border:1px solid #e0e0e0}
</style>
</head>
<body>
<div class="container">
<a href="/inventory_system/dashboard/index.php" style="float:left;margin-bottom:10px;padding:8px 12px;background:#007bff;color:#fff;border-radius:6px;text-decoration:none;font-weight:bold">Dashboard</a>

<h2>Update Device Specs</h2>

<?php if($error): ?><div class="error"><?= htmlspecialchars($error) ?></div><?php endif; ?>
<?php if($success): ?><div class="success"><?= htmlspecialchars($success) ?></div><?php endif; ?>

<form method="GET" class="search">
    <input type="text" name="sn" placeholder="Scan or enter Serial Number" value="<?= htmlspecialchars($serial_search) ?>" autofocus>
    <button type="submit">Load Device</button>
</form>

<?php if($device): ?>
<form method="POST">
    <input type="hidden" name="serial_number" value="<?= htmlspecialchars($device['serial_number']) ?>">

    <div style="display:grid;grid-template-columns:1fr 1fr;gap:15px">
        <div>
            <label>Serial Number</label>
            <div class="readonly"><?= htmlspecialchars($device['serial_number']) ?></div>

            <label>Category</label>
            <div class="readonly"><?= htmlspecialchars($device['category_name']) ?></div>

            <label>Model</label>
            <div class="readonly"><?= htmlspecialchars($device['model_name']) ?></div>

            <label>Processor</label>
            <div class="readonly"><?= htmlspecialchars($device['processor']) ?></div>

            <label>Graphics (current)</label>
            <div class="readonly"><?= htmlspecialchars($device['graphics'] ?? 'None') ?></div>
        </div>

        <div>
            <label>RAM (GB) - Current</label>
            <div class="readonly"><?= htmlspecialchars($device['ram']) ?></div>

            <label>Storage (current)</label>
            <div class="readonly">
                <?= htmlspecialchars(($device['storage_type'] ? $device['storage_type'] . ' ' : '') . $device['storage_capacity'] . ' GB') ?>
            </div>

            <label>Touch</label>
            <div class="readonly"><?= htmlspecialchars($device['touch'] ?? '-') ?></div>

            <label>Added By</label>
            <div class="readonly"><?= htmlspecialchars($device['added_by_name'] ?? 'Unknown') ?></div>

            <label>Date Added</label>
            <div class="readonly"><?= htmlspecialchars(date('Y-m-d H:i:s', strtotime($device['date_added'] ?? 'now'))) ?></div>
        </div>
    </div>

    <hr style="margin:20px 0">

    <div style="display:grid;grid-template-columns:1fr 1fr;gap:15px">
        <div>
            <label>New RAM (leave blank if unchanged)</label>
            <input type="number" name="new_ram" min="1" placeholder="e.g. 16">

            <label>New Storage Capacity (GB) (leave blank if unchanged)</label>
            <input type="number" name="new_storage_capacity" min="1" placeholder="e.g. 512">

            <label>New Storage Type</label>
            <select name="new_storage_type" style="width:100%">
                <option value="same">Keep current type (<?= htmlspecialchars($device['storage_type'] ?? 'Not specified') ?>)</option>
                <option value="SSD">SSD</option>
                <option value="HDD">HDD</option>
            </select>
        </div>

        <div>
            <label>New Graphics (leave blank if unchanged)</label>
            <input type="text" name="new_graphics" placeholder="e.g. NVIDIA GeForce MX130">

            <label>Notes</label>
            <textarea name="notes" rows="4" style="width:100%;padding:8px;border-radius:5px;border:1px solid #ccc" placeholder="Optional notes..."></textarea>
        </div>
    </div>

    <div style="margin-top:18px">
        <button type="submit">Save Maintenance Record</button>
    </div>
</form>
<?php endif; ?>
</div>
</body>
</html>
