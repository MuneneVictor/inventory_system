<?php
session_start();
require_once "../config/db.php";
require_once "../includes/auth_check.php";

$error = $success = "";
$user_id = $_SESSION['user_id'];
$user_role = $_SESSION['role'];

// Get user's branch if not super_admin
$user_branch = null;
if ($user_role !== 'super_admin') {
    $stmt = $conn->prepare("SELECT branch FROM users WHERE id = ?");
    $stmt->execute([$user_id]);
    $user_data = $stmt->fetch(PDO::FETCH_ASSOC);
    $user_branch = $user_data['branch'] ?? null;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $serial = trim($_POST['serial_number']);
    $model  = trim($_POST['model_name']);
    $user   = $user_id;
    
    // Determine branch based on user role
    if ($user_role === 'super_admin') {
        $branch = $_POST['branch'] ?? '';
        if (!$branch) {
            $error = "Please select a branch.";
        }
    } else {
        $branch = $user_branch; // Non-super_admins can only add to their branch
        if (!$branch) {
            $error = "Branch not found for your account.";
        }
    }

    if (!$error && $serial && $model && $branch) {
        // Check for duplicate serial number
        $check = $conn->prepare("SELECT serial_number FROM printers WHERE serial_number = ?");
        $check->execute([$serial]);
        if ($check->rowCount() > 0) {
            $error = "This serial number already exists!";
        } else {
            try {
                $stmt = $conn->prepare("
                    INSERT INTO printers (serial_number, model_name, branch, added_by)
                    VALUES (?, ?, ?, ?)
                ");
                $stmt->execute([$serial, $model, $branch, $user]);
                $success = "Printer added to $branch branch successfully";
            } catch (PDOException $e) {
                $error = "Error adding printer: " . $e->getMessage();
            }
        }
    } elseif (!$error) {
        $error = "All fields are required";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Add Printer</title>
<style>
body { font-family: Arial; background:#f4f7f6; }
.container { max-width:450px; margin:40px auto; background:#fff; padding:25px; border-radius:8px; box-shadow:0 4px 15px rgba(0,0,0,.1); }
h2 { text-align:center; color:#2f7a3f; }
input, select { width:100%; padding:10px; margin-bottom:15px; border-radius:5px; border:1px solid #ccc; }
button { width:100%; padding:12px; background:#2f7a3f; color:#fff; border:none; border-radius:5px; font-weight:bold; }
.error { color:red; text-align:center; }
.success { color:green; text-align:center; }
.branch-info {
    padding:10px;
    background:#e7f3ff;
    border-left:4px solid #007bff;
    margin-bottom:15px;
    border-radius:4px;
    font-size:14px;
}
</style>
</head>
<body>

<div class="container">
<h2>Add Printer</h2>
<a href="/inventory_system/dashboard/index.php"
   style="position: top:10px; right:10px; padding:10px 15px; 
          background:#007bff; color:white; border-radius:6px; 
          text-decoration:none; font-weight:bold; z-index:999;">
    Dashboard
</a> <br><br>

<div class="branch-info">
    <strong>Branch Information:</strong><br>
    <?php if($user_role === 'super_admin'): ?>
        You can add printers to any branch.
    <?php else: ?>
        You can only add printers to your branch: <strong><?= htmlspecialchars($user_branch) ?></strong>
    <?php endif; ?>
</div>

<?php if($error): ?><div class="error"><?= $error ?></div><?php endif; ?>
<?php if($success): ?><div class="success"><?= $success ?></div><?php endif; ?>

<form method="POST">
    <input type="text" name="serial_number" placeholder="Scan / Enter Serial Number" autofocus required>
    <input type="text" name="model_name" placeholder="Printer Model" required>

    <?php if($user_role === 'super_admin'): ?>
        <select name="branch" required>
            <option value="">-- Select Branch --</option>
            <option value="KIMATHI">KIMATHI</option>
            <option value="MOI">MOI</option>
        </select>
    <?php else: ?>
        <input type="hidden" name="branch" value="<?= htmlspecialchars($user_branch) ?>">
        <div style="padding:10px; background:#f8f9fa; border-radius:5px; margin-bottom:15px;">
            <strong>Branch:</strong> <?= htmlspecialchars($user_branch) ?>
        </div>
    <?php endif; ?>

    <button type="submit">Add Printer</button>
</form>
</div>

</body>
</html>