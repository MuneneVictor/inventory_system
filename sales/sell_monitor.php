<?php
session_start();
require_once "../config/db.php";
require_once "../includes/auth_check.php";
require_once "../includes/header.php";
require_once "../includes/sidebar.php";

if ($_SESSION['role'] !== 'sales') {
    die("ACCESS DENIED.");
}

$user_id = (int) $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT branch FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user_branch = $stmt->fetchColumn();
if (!$user_branch) die("Your account has no branch assigned.");

$error = "";
$success = "";
$monitor = null;

if (isset($_POST['search_serial'])) {
    $serial = trim($_POST['serial_number']);
    $stmt = $conn->prepare("SELECT * FROM monitors WHERE serial_number = ? AND status = 'In Stock' AND branch = ?");
    $stmt->execute([$serial, $user_branch]);
    $monitor = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$monitor) {
        $error = "Monitor not found in your branch or not in stock.";
    }
}

if (isset($_POST['sell_monitor'])) {
    $serial = trim($_POST['serial_number']);
    $stmt = $conn->prepare("SELECT * FROM monitors WHERE serial_number = ? AND status = 'In Stock' AND branch = ?");
    $stmt->execute([$serial, $user_branch]);
    $monitor = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($monitor) {
        $update = $conn->prepare("UPDATE monitors SET status = 'Sold', sold_by = ?, sold_at = NOW() WHERE serial_number = ?");
        $update->execute([$user_id, $serial]);
        $log = $conn->prepare("INSERT INTO activity_logs (user_id, action, details) VALUES (?, 'Sold monitor', ?)");
        $log->execute([$user_id, "Sold monitor SN: $serial ({$monitor['model_name']})"]);
        $success = "Monitor sold successfully!";
        $monitor = null;
    } else {
        $error = "Monitor not found or already sold.";
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
    <title>Sell Monitor | Mombasa Computers</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        :root {
            --primary: #1a4b2a;
            --gray-100: #f3f4f6;
            --gray-200: #e5e7eb;
            --gray-300: #d1d5db;
            --gray-500: #6b7280;
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
        .breadcrumb { color: var(--gray-500); font-size: 0.9rem; }
        .card { background: white; border-radius: var(--radius-xl); border: 1px solid var(--gray-200); overflow: hidden; box-shadow: var(--shadow-sm); margin-bottom: 1.5rem; }
        .card-header { background: var(--gray-50); padding: 1rem 1.5rem; border-bottom: 1px solid var(--gray-200); font-weight: 600; }
        .card-body { padding: 1.5rem; }
        .form-group { margin-bottom: 1.5rem; }
        .form-group label { display: block; font-size: 0.875rem; font-weight: 500; margin-bottom: 0.5rem; }
        .form-group input { width: 100%; padding: 0.75rem; border: 1px solid var(--gray-300); border-radius: var(--radius-md); }
        .btn { padding: 0.75rem 1.5rem; background: var(--primary); color: white; border: none; border-radius: var(--radius-md); cursor: pointer; display: inline-flex; align-items: center; gap: 0.5rem; width: 100%; justify-content: center; }
        .alert { padding: 1rem; border-radius: var(--radius-md); margin-bottom: 1rem; }
        .alert-error { background: #fef2f2; border: 1px solid #fecaca; color: #991b1b; }
        .alert-success { background: #ecfdf5; border: 1px solid #a7f3d0; color: #065f46; }
        table { width: 100%; border-collapse: collapse; margin-top: 1rem; }
        th, td { padding: 0.75rem; text-align: left; border-bottom: 1px solid var(--gray-200); }
        .footer { text-align: center; padding: 1.5rem 0 0.5rem; margin-top: 1.5rem; font-size: 0.85rem; color: var(--gray-500); border-top: 1px solid var(--gray-200); }
        @media (max-width: 1200px) { .main-content { margin-left: 0 !important; width: 100% !important; padding: 1.5rem 1rem 1rem !important; padding-top: 5rem !important; } }
        @media (max-width: 768px) { .card-body { padding: 1rem; } }
    </style>
</head>
<body>
<div class="main-content">
    <div class="page-header">
        <h1><i class="fas fa-desktop"></i> Sell Monitor</h1>
        <div class="breadcrumb">
            <a href="/inventory_system/dashboard/salesdashboard.php">Dashboard</a>
            <span> / </span>
            <span>Sell Monitor</span>
        </div>
    </div>

    <?php if ($error): ?>
        <div class="alert alert-error"><i class="fas fa-exclamation-circle"></i> <?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <?php if ($success): ?>
        <div class="alert alert-success"><i class="fas fa-check-circle"></i> <?= htmlspecialchars($success) ?></div>
    <?php endif; ?>

    <div class="card">
        <div class="card-header"><i class="fas fa-search"></i> Search Monitor</div>
        <div class="card-body">
            <form method="POST">
                <div class="form-group">
                    <label>Serial Number</label>
                    <input type="text" name="serial_number" placeholder="Scan or enter serial number" required autofocus>
                </div>
                <button type="submit" name="search_serial" class="btn"><i class="fas fa-search"></i> Search Monitor</button>
            </form>
        </div>
    </div>

    <?php if ($monitor): ?>
        <div class="card">
            <div class="card-header"><i class="fas fa-info-circle"></i> Monitor Details</div>
            <div class="card-body">
                <table>
                    <tr><th>Serial Number</th><td><?= htmlspecialchars($monitor['serial_number']) ?></td></tr>
                    <tr><th>Model</th><td><?= htmlspecialchars($monitor['model_name']) ?></td></tr>
                    <tr><th>Size</th><td><?= $monitor['size_inches'] ?> inches</td></tr>
                    <tr><th>Branch</th><td><?= htmlspecialchars($monitor['branch']) ?></td></tr>
                </table>
                <form method="POST" style="margin-top:1rem;">
                    <input type="hidden" name="serial_number" value="<?= htmlspecialchars($monitor['serial_number']) ?>">
                    <button type="submit" name="sell_monitor" class="btn">Confirm Sale</button>
                </form>
            </div>
        </div>
    <?php endif; ?>
    <div class="footer"><i class="fas fa-copyright"></i> <?= date('Y'); ?> Mombasa Computers</div>
</div>

<script>
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