<?php
session_start();
require_once "../config/db.php";
require_once "../includes/auth_check.php";
require_once "../includes/header.php";
require_once "../includes/sidebar.php";

if ($_SESSION['role'] !== 'sales') {
    die("ACCESS DENIED. Only sales personnel can sell devices.");
}

$user_id = (int) $_SESSION['user_id'];
$user_role = $_SESSION['role'];

$stmt = $conn->prepare("SELECT branch FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user_branch = $stmt->fetchColumn();
if (!$user_branch) die("Your account has no branch assigned.");

$error = "";
$success = "";
$foundDevices = [];
$notFoundSerials = [];
$singleDevice = null;

if (isset($_POST['search_serial'])) {
    $input = trim($_POST['serial_number']);
    if (empty($input)) {
        $error = "Please enter serial number(s).";
    } else {
        $serials = preg_split('/[\s,]+/', $input);
        $serials = array_filter(array_map('trim', $serials));
        if (empty($serials)) {
            $error = "No valid serial numbers found.";
        } else {
            $placeholders = implode(',', array_fill(0, count($serials), '?'));
            $sql = "SELECT d.*, c.category_name 
                    FROM devices d
                    JOIN categories c ON d.category_id = c.id
                    WHERE d.serial_number IN ($placeholders)
                      AND d.status = 'In Stock'
                      AND d.branch = ?";
            $params = array_merge($serials, [$user_branch]);
            $stmt = $conn->prepare($sql);
            $stmt->execute($params);
            $foundDevices = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $foundSerials = array_column($foundDevices, 'serial_number');
            $notFoundSerials = array_diff($serials, $foundSerials);

            if (empty($foundDevices)) {
                $error = "Devices not found, not in stock, or not in your branch.";
            } elseif (count($serials) === 1 && !empty($foundDevices)) {
                $singleDevice = $foundDevices[0];
                $foundDevices = [];
            }
        }
    }
}

if (isset($_POST['sell_device'])) {
    $serial = trim($_POST['serial_number']);
    $stmt = $conn->prepare("SELECT * FROM devices WHERE serial_number = ? AND status = 'In Stock' AND branch = ?");
    $stmt->execute([$serial, $user_branch]);
    $device = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($device) {
        try {
            $conn->beginTransaction();
            $insert = $conn->prepare("INSERT INTO sold_devices 
                (serial_number, category_id, model_name, processor, graphics, ram, storage_type, storage_capacity, touch, device_condition, sold_by, price, sold_at)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())");
            $insert->execute([
                $device['serial_number'], $device['category_id'], $device['model_name'],
                $device['processor'], $device['graphics'], $device['ram'],
                $device['storage_type'], $device['storage_capacity'], $device['touch'] ?? null,
                $device['device_condition'], $user_id, $device['price']
            ]);
            $update = $conn->prepare("UPDATE devices SET status = 'Sold' WHERE serial_number = ?");
            $update->execute([$serial]);
            $log = $conn->prepare("INSERT INTO activity_logs (user_id, action, details) VALUES (?, 'Sold device', ?)");
            $log->execute([$user_id, "Sold device SN: $serial for KES " . number_format($device['price'], 2)]);
            $conn->commit();
            $success = "Device sold successfully!";
            $singleDevice = null;
        } catch (Exception $e) {
            $conn->rollBack();
            $error = "Error: " . $e->getMessage();
        }
    } else {
        $error = "Device not found in your branch or already sold.";
    }
}

if (isset($_POST['sell_bulk_devices'])) {
    $selectedSerials = $_POST['selected_serials'] ?? [];
    if (empty($selectedSerials)) {
        $error = "No devices selected.";
    } else {
        $soldCount = 0;
        foreach ($selectedSerials as $serial) {
            $stmt = $conn->prepare("SELECT * FROM devices WHERE serial_number = ? AND status = 'In Stock' AND branch = ?");
            $stmt->execute([$serial, $user_branch]);
            $device = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($device) {
                $conn->beginTransaction();
                $insert = $conn->prepare("INSERT INTO sold_devices 
                    (serial_number, category_id, model_name, processor, graphics, ram, storage_type, storage_capacity, touch, device_condition, sold_by, price, sold_at)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())");
                $insert->execute([
                    $device['serial_number'], $device['category_id'], $device['model_name'],
                    $device['processor'], $device['graphics'], $device['ram'],
                    $device['storage_type'], $device['storage_capacity'], $device['touch'] ?? null,
                    $device['device_condition'], $user_id, $device['price']
                ]);
                $update = $conn->prepare("UPDATE devices SET status = 'Sold' WHERE serial_number = ?");
                $update->execute([$serial]);
                $log = $conn->prepare("INSERT INTO activity_logs (user_id, action, details) VALUES (?, 'Sold device', ?)");
                $log->execute([$user_id, "Sold device SN: $serial for KES " . number_format($device['price'], 2)]);
                $conn->commit();
                $soldCount++;
            }
        }
        if ($soldCount > 0) {
            $success = "$soldCount device(s) sold successfully.";
            $foundDevices = [];
            $notFoundSerials = [];
        } else {
            $error = "No devices could be sold.";
        }
    }
}

date_default_timezone_set('Africa/Nairobi');
$hour = date('G');
if ($hour < 12) $greeting = 'Good morning';
elseif ($hour < 17) $greeting = 'Good afternoon';
else $greeting = 'Good evening';
$user_name = $_SESSION['name'] ?? ($_SESSION['full_name'] ?? 'User');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Sell Device | Mombasa Computers</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Same base styles */
        :root {
            --primary: #1a4b2a;
            --gray-50: #f9fafb;
            --gray-100: #f3f4f6;
            --gray-200: #e5e7eb;
            --gray-300: #d1d5db;
            --gray-500: #6b7280;
            --gray-600: #4b5563;
            --gray-800: #1f2937;
            --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
            --radius-md: 0.5rem;
            --radius-lg: 0.75rem;
            --radius-xl: 1rem;
            --font-sans: 'Inter', system-ui, sans-serif;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: var(--font-sans); background: var(--gray-100); color: var(--gray-800); line-height: 1.5; overflow-x: hidden; }
        .main-content { padding: 2rem 2rem 1rem; margin-left: 260px; width: calc(100% - 260px); min-height: 100vh; background: var(--gray-100); transition: all 0.3s ease; }
        .page-header { background: white; padding: 1.5rem 2rem; border-radius: var(--radius-xl); margin-bottom: 1.5rem; box-shadow: var(--shadow-sm); border: 1px solid var(--gray-200); }
        .page-header h1 { font-size: 1.75rem; color: var(--gray-800); font-weight: 600; margin-bottom: 0.5rem; display: flex; align-items: center; gap: 0.75rem; }
        .page-header h1 i { color: var(--primary); font-size: 1.75rem; }
        .breadcrumb { color: var(--gray-500); font-size: 0.9rem; }
        .breadcrumb a { color: var(--primary); text-decoration: none; }
        .card { background: white; border-radius: var(--radius-xl); border: 1px solid var(--gray-200); overflow: hidden; box-shadow: var(--shadow-sm); margin-bottom: 1.5rem; }
        .card-header { background: var(--gray-50); padding: 1rem 1.5rem; border-bottom: 1px solid var(--gray-200); font-weight: 600; }
        .card-body { padding: 1.5rem; }
        .info-box { background: var(--gray-50); border-radius: var(--radius-lg); padding: 1rem 1.25rem; margin-bottom: 1.5rem; border-left: 4px solid var(--primary); }
        .form-group { margin-bottom: 1.5rem; }
        .form-group label { display: block; font-size: 0.875rem; font-weight: 500; margin-bottom: 0.5rem; color: var(--gray-700); }
        .form-group textarea, .form-group select { width: 100%; padding: 0.75rem; border: 1px solid var(--gray-300); border-radius: var(--radius-md); background: white; }
        .btn { padding: 0.75rem 1.5rem; background: var(--primary); color: white; border: none; border-radius: var(--radius-md); cursor: pointer; display: inline-flex; align-items: center; gap: 0.5rem; width: 100%; justify-content: center; }
        .btn-secondary { background: var(--gray-500); }
        .alert { padding: 1rem; border-radius: var(--radius-md); margin-bottom: 1rem; }
        .alert-error { background: #fef2f2; border: 1px solid #fecaca; color: #991b1b; }
        .alert-success { background: #ecfdf5; border: 1px solid #a7f3d0; color: #065f46; }
        table { width: 100%; border-collapse: collapse; margin-top: 1rem; }
        th, td { padding: 0.75rem; text-align: left; border-bottom: 1px solid var(--gray-200); }
        th { background: var(--gray-50); }
        .checkbox-cell { text-align: center; }
        .footer { text-align: center; padding: 1.5rem 0 0.5rem; margin-top: 1.5rem; font-size: 0.85rem; color: var(--gray-400); border-top: 1px solid var(--gray-200); }
        @media (max-width: 1200px) { .main-content { margin-left: 0 !important; width: 100% !important; padding: 1.5rem 1rem 1rem !important; padding-top: 5rem !important; } }
        @media (max-width: 768px) { .card-body { padding: 1rem; } }
    </style>
</head>
<body>
<div class="main-content">
    <div class="page-header">
        <h1><i class="fas fa-money-bill-wave"></i> Sell Device</h1>
        <div class="breadcrumb">
            <a href="/inventory_system/dashboard/salesdashboard.php">Dashboard</a>
            <span> / </span>
            <span>Sell Device</span>
        </div>
    </div>

    <?php if ($error): ?>
        <div class="alert alert-error"><i class="fas fa-exclamation-circle"></i> <?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <?php if ($success): ?>
        <div class="alert alert-success"><i class="fas fa-check-circle"></i> <?= htmlspecialchars($success) ?></div>
    <?php endif; ?>

    <div class="card">
        <div class="card-header"><i class="fas fa-search"></i> Search Devices</div>
        <div class="card-body">
            <form method="POST">
                <div class="form-group">
                    <label>Serial Numbers (one per line or comma separated)</label>
                    <textarea name="serial_number" rows="4" placeholder="Type or scan serial numbers..." required autofocus><?= isset($_POST['serial_number']) ? htmlspecialchars($_POST['serial_number']) : '' ?></textarea>
                </div>
                <button type="submit" name="search_serial" class="btn"><i class="fas fa-search"></i> Search Device(s)</button>
            </form>
            <?php if (!empty($notFoundSerials)): ?>
                <div class="alert alert-error" style="margin-top:1rem;"><strong>Not Found:</strong> <?= implode(', ', $notFoundSerials) ?></div>
            <?php endif; ?>
        </div>
    </div>

    <?php if ($singleDevice): ?>
        <div class="card">
            <div class="card-header"><i class="fas fa-laptop"></i> Device Details</div>
            <div class="card-body">
                <table>
                    <tr><th>Serial</th><td><?= htmlspecialchars($singleDevice['serial_number']) ?></td></tr>
                    <tr><th>Model</th><td><?= htmlspecialchars($singleDevice['model_name']) ?></td></tr>
                    <tr><th>Category</th><td><?= htmlspecialchars($singleDevice['category_name']) ?></td></tr>
                    <tr><th>Processor</th><td><?= htmlspecialchars($singleDevice['processor']) ?></td></tr>
                    <tr><th>RAM</th><td><?= $singleDevice['ram'] ?> GB</td></tr>
                    <tr><th>Storage</th><td><?= htmlspecialchars($singleDevice['storage_type'] . ' ' . $singleDevice['storage_capacity'] . 'GB') ?></td></tr>
                    <tr><th>Price</th><td><?= $singleDevice['price'] ? 'KES ' . number_format($singleDevice['price'], 2) : 'Not priced' ?></td></tr>
                </table>
                <form method="POST">
                    <input type="hidden" name="serial_number" value="<?= htmlspecialchars($singleDevice['serial_number']) ?>">
                    <button type="submit" name="sell_device" class="btn">Confirm Sale</button>
                </form>
            </div>
        </div>
    <?php endif; ?>

    <?php if (!empty($foundDevices)): ?>
        <div class="card">
            <div class="card-header"><i class="fas fa-list"></i> Found Devices (<?= count($foundDevices) ?>)</div>
            <div class="card-body">
                <form method="POST">
                    <p><input type="checkbox" id="selectAll" onchange="selectAllCheckboxes(this)"> <label for="selectAll">Select All</label></p>
                    <table>
                        <thead><tr><th class="checkbox-cell">Sell</th><th>Serial</th><th>Model</th><th>Category</th><th>Processor</th><th>RAM</th><th>Price</th></tr></thead>
                        <tbody>
                            <?php foreach ($foundDevices as $d): ?>
                            <tr>
                                <td class="checkbox-cell"><input type="checkbox" name="selected_serials[]" value="<?= htmlspecialchars($d['serial_number']) ?>" checked></td>
                                <td><code><?= htmlspecialchars($d['serial_number']) ?></code></td>
                                <td><?= htmlspecialchars($d['model_name']) ?></td>
                                <td><?= htmlspecialchars($d['category_name']) ?></td>
                                <td><?= htmlspecialchars($d['processor']) ?></td>
                                <td><?= $d['ram'] ?> GB</td>
                                <td><?= $d['price'] ? 'KES ' . number_format($d['price'], 2) : '-' ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <button type="submit" name="sell_bulk_devices" class="btn" style="margin-top:1rem;">Sell Selected (<?= count($foundDevices) ?>)</button>
                </form>
            </div>
        </div>
    <?php endif; ?>
    <div class="footer"><i class="fas fa-copyright"></i> <?= date('Y'); ?> Mombasa Computers</div>
</div>

<script>
function selectAllCheckboxes(source) {
    document.querySelectorAll('input[name="selected_serials[]"]').forEach(cb => cb.checked = source.checked);
}
function adjustMainContent() {
    const main = document.querySelector('.main-content');
    if (window.innerWidth <= 1200) main.style.marginLeft = '0';
    else main.style.marginLeft = '260px';
}
window.addEventListener('resize', adjustMainContent);
adjustMainContent();
</script>
<?php require_once "../includes/footer.php"; ?>
</body>
</html>