<?php
session_start();
require_once "../config/db.php";
require_once "../includes/auth_check.php";
require_once "../includes/header.php";
require_once "../includes/sidebar.php";

if (!in_array($_SESSION['role'], ['inventory_admin', 'super_admin', 'manager', 'maintenance'])) {
    die("ACCESS DENIED. Only Inventory Admin, Manager, and Maintenance can give out chargers.");
}

$user_id = (int) $_SESSION['user_id'];
$user_role = $_SESSION['role'];

// Get user's branch
$user_branch = null;
$stmt = $conn->prepare("SELECT branch FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user_branch = $stmt->fetchColumn();
if (!$user_branch && $user_role !== 'super_admin') {
    die("Your account has no branch assigned. Contact administrator.");
}

// For super_admin, they can select any branch; otherwise use their branch
$selected_branch = $user_branch;
if ($user_role === 'super_admin' && isset($_GET['branch']) && $_GET['branch']) {
    $selected_branch = $_GET['branch'];
}

// Get available chargers (with quantity > 0) for selected branch
$chargers = [];
if ($selected_branch) {
    $stmt = $conn->prepare("SELECT * FROM chargers WHERE quantity > 0 AND branch = ? ORDER BY charger_type, watts");
    $stmt->execute([$selected_branch]);
    $chargers = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Get sales users in the same branch (to give to)
$sales_users = [];
if ($selected_branch) {
    $stmt = $conn->prepare("SELECT id, full_name FROM users WHERE role = 'sales' AND branch = ? ORDER BY full_name");
    $stmt->execute([$selected_branch]);
    $sales_users = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Get all branches for super_admin dropdown
$all_branches = [];
if ($user_role === 'super_admin') {
    $branchStmt = $conn->query("SELECT DISTINCT branch FROM chargers WHERE branch IS NOT NULL ORDER BY branch");
    $all_branches = $branchStmt->fetchAll(PDO::FETCH_COLUMN);
}

$error = "";
$success = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $charger_id = (int) ($_POST['charger_id'] ?? 0);
    $quantity = (int) ($_POST['quantity'] ?? 0);
    $recipient_id = (int) ($_POST['recipient_id'] ?? 0);
    $branch = trim($_POST['branch'] ?? $selected_branch);

    if (!$charger_id || $quantity <= 0 || !$recipient_id) {
        $error = "All fields are required.";
    } else {
        try {
            $conn->beginTransaction();

            // Lock and fetch charger
            $stmt = $conn->prepare("SELECT * FROM chargers WHERE id = ? AND branch = ? FOR UPDATE");
            $stmt->execute([$charger_id, $branch]);
            $charger = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$charger) {
                throw new Exception("Charger not found.");
            }
            if ($charger['quantity'] < $quantity) {
                throw new Exception("Insufficient stock. Available: {$charger['quantity']}");
            }

            // Deduct stock
            $new_qty = $charger['quantity'] - $quantity;
            $update = $conn->prepare("UPDATE chargers SET quantity = ?, updated_by = ?, date_updated = NOW() WHERE id = ?");
            $update->execute([$new_qty, $user_id, $charger_id]);

            // Insert log
            $log = $conn->prepare("INSERT INTO charger_logs (charger_id, quantity, given_to, given_by, branch, date_given) VALUES (?, ?, ?, ?, ?, NOW())");
            $log->execute([$charger_id, $quantity, $recipient_id, $user_id, $branch]);

            // Activity log
            $recipient_name = "User ID $recipient_id";
            $recStmt = $conn->prepare("SELECT full_name FROM users WHERE id = ?");
            $recStmt->execute([$recipient_id]);
            if ($recStmt->rowCount()) $recipient_name = $recStmt->fetchColumn();

            $activity = $conn->prepare("INSERT INTO activity_logs (user_id, action, details) VALUES (?, 'Give Out Charger', ?)");
            $activity->execute([$user_id, "Gave {$quantity} x {$charger['charger_type']} ({$charger['watts']}W, {$charger['charger_condition']}) to {$recipient_name} in {$branch} branch"]);

            $conn->commit();
            $success = "Successfully gave out {$quantity} unit(s).";

            // Refresh charger list
            $stmt = $conn->prepare("SELECT * FROM chargers WHERE quantity > 0 AND branch = ? ORDER BY charger_type, watts");
            $stmt->execute([$branch]);
            $chargers = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            $conn->rollBack();
            $error = "Error: " . $e->getMessage();
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
    <title>Give Out Charger | Mombasa Computers</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Same base styles as add_charger.php */
        :root {
            --primary: #1a4b2a;
            --primary-light: #2a6b3a;
            --gray-50: #f9fafb;
            --gray-100: #f3f4f6;
            --gray-200: #e5e7eb;
            --gray-300: #d1d5db;
            --gray-500: #6b7280;
            --gray-600: #4b5563;
            --gray-700: #374151;
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
        .info-box { background: var(--gray-50); border-radius: var(--radius-lg); padding: 1rem 1.25rem; margin-bottom: 1.5rem; border-left: 4px solid var(--primary); }
        .form-group { margin-bottom: 1.5rem; }
        .form-group label { display: block; font-size: 0.875rem; font-weight: 500; margin-bottom: 0.5rem; color: var(--gray-700); }
        .form-group select, .form-group input { width: 100%; padding: 0.75rem 1rem; border: 1px solid var(--gray-300); border-radius: var(--radius-md); font-size: 0.9rem; background: white; }
        .btn { padding: 0.75rem 1.5rem; border: none; border-radius: var(--radius-md); font-size: 0.9rem; font-weight: 500; cursor: pointer; display: inline-flex; align-items: center; gap: 0.5rem; }
        .btn-primary { background: var(--primary); color: white; width: 100%; justify-content: center; }
        .alert { padding: 1rem; border-radius: var(--radius-md); margin-bottom: 1rem; }
        .alert-success { background: #ecfdf5; border: 1px solid #a7f3d0; color: #065f46; }
        .alert-error { background: #fef2f2; border: 1px solid #fecaca; color: #991b1b; }
        .footer { text-align: center; padding: 1.5rem 0 0.5rem; margin-top: 1.5rem; font-size: 0.85rem; color: var(--gray-400); border-top: 1px solid var(--gray-200); }
        @media (max-width: 1200px) { .main-content { margin-left: 0 !important; width: 100% !important; padding: 1.5rem 1rem 1rem !important; padding-top: 5rem !important; } }
        @media (max-width: 768px) { .btn { width: 100%; justify-content: center; } .card-body { padding: 1rem; } }
    </style>
</head>
<body>
<div class="main-content">
    <div class="page-header">
        <h1><i class="fas fa-gift"></i> Give Out Charger</h1>
        <div class="breadcrumb">
            <?php if ($user_role === 'super_admin'): ?>
                <a href="/inventory_system/dashboard/superadmindashboard.php">Dashboard</a>
            <?php elseif ($user_role === 'manager'): ?>
                <a href="/inventory_system/dashboard/managerdashboard.php">Dashboard</a>
            <?php else: ?>
                <a href="/inventory_system/dashboard/inventorydashboard.php">Dashboard</a>
            <?php endif; ?>
            <span> / </span>
            <a href="chargers_instocks.php">Chargers Stock</a>
            <span> / </span>
            <span>Give Out</span>
        </div>
    </div>

    <div class="card">
        <div class="card-header"><i class="fas fa-exchange-alt"></i> Select Branch & Charger</div>
        <div class="card-body">
            <?php if ($error): ?>
                <div class="alert alert-error"><i class="fas fa-exclamation-circle"></i> <?= htmlspecialchars($error) ?></div>
            <?php endif; ?>
            <?php if ($success): ?>
                <div class="alert alert-success"><i class="fas fa-check-circle"></i> <?= htmlspecialchars($success) ?></div>
            <?php endif; ?>

            <?php if ($user_role === 'super_admin'): ?>
                <div class="info-box">
                    <form method="GET" style="margin:0; display:flex; gap:1rem; flex-wrap:wrap; align-items:flex-end;">
                        <div style="flex:1;">
                            <label>Select Branch</label>
                            <select name="branch" onchange="this.form.submit()" style="width:100%; padding:0.6rem;">
                                <?php foreach ($all_branches as $b): ?>
                                    <option value="<?= htmlspecialchars($b) ?>" <?= $selected_branch == $b ? 'selected' : '' ?>><?= htmlspecialchars($b) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </form>
                </div>
            <?php endif; ?>

            <?php if (!$selected_branch): ?>
                <div class="alert alert-error">No branch selected or available.</div>
            <?php elseif (empty($chargers)): ?>
                <div class="alert alert-error">No chargers available in stock for <?= htmlspecialchars($selected_branch) ?> branch.</div>
            <?php elseif (empty($sales_users)): ?>
                <div class="alert alert-error">No sales users found in <?= htmlspecialchars($selected_branch) ?> branch.</div>
            <?php else: ?>
                <form method="POST">
                    <input type="hidden" name="branch" value="<?= htmlspecialchars($selected_branch) ?>">
                    <div class="form-group">
                        <label>Select Charger</label>
                        <select name="charger_id" required>
                            <option value="">-- Choose Charger --</option>
                            <?php foreach ($chargers as $c): ?>
                                <option value="<?= $c['id'] ?>">
                                    <?= htmlspecialchars($c['charger_type']) ?> - <?= $c['watts'] ?>W (<?= htmlspecialchars($c['charger_condition']) ?>) - Available: <?= $c['quantity'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Quantity to Give</label>
                        <input type="number" name="quantity" min="1" required placeholder="Number of units">
                    </div>
                    <div class="form-group">
                        <label>Give To (Salesperson)</label>
                        <select name="recipient_id" required>
                            <option value="">-- Select Salesperson --</option>
                            <?php foreach ($sales_users as $u): ?>
                                <option value="<?= $u['id'] ?>"><?= htmlspecialchars($u['full_name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-check-circle"></i> Give Out</button>
                </form>
            <?php endif; ?>
        </div>
    </div>
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