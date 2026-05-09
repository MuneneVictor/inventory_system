<?php
session_start();
require_once "../config/db.php";
require_once "../includes/auth_check.php";

// Only allowed roles
if (!in_array($_SESSION['role'], ['super_admin', 'inventory_admin', 'manager'])) {
    header("Location: /inventory_system/dashboard/index.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$user_role = $_SESSION['role'];

// Get user's branch
$stmt = $conn->prepare("SELECT branch FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
$user_branch = $user['branch'] ?? '';

$error = $success = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $serial = trim($_POST['serial_number']);
    $model  = trim($_POST['model_name']);
    $size   = (int) $_POST['size_inches'];
    
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

    if ($error) {
        // Error already set for branch
    } elseif ($serial === '' || $model === '' || $size <= 0) {
        $error = "All fields are required.";
    } else {

        // Check duplicate serial
        $check = $conn->prepare("SELECT serial_number FROM monitors WHERE serial_number = ?");
        $check->execute([$serial]);

        if ($check->rowCount() > 0) {
            $error = "Monitor with this serial number already exists.";
        } else {
            // Insert monitor
            $insert = $conn->prepare("
                INSERT INTO monitors 
                (serial_number, model_name, size_inches, status, branch, added_by)
                VALUES 
                (:serial, :model, :size, 'In Stock', :branch, :added_by)
            ");

            $insert->execute([
                'serial'   => $serial,
                'model'    => $model,
                'size'     => $size,
                'branch'   => $branch,
                'added_by' => $user_id
            ]);

            $success = "Monitor added to $branch branch successfully!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Add Monitor</title>

<style>
body {
    font-family: Arial, sans-serif;
    background:#f4f7f6;
    margin:0;
    padding:0;
}

.container {
    max-width: 600px;
    margin:40px auto;
    background:#fff;
    padding:25px;
    border-radius:8px;
    box-shadow:0 4px 15px rgba(0,0,0,0.1);
}

h2 {
    text-align:center;
    color:#2f7a3f;
    margin-bottom:20px;
}

label {
    font-weight:bold;
    margin-top:10px;
    display:block;
}

input, select {
    width:100%;
    padding:10px;
    margin-top:5px;
    border-radius:5px;
    border:1px solid #ccc;
}

button {
    width:100%;
    padding:12px;
    background:#2f7a3f;
    color:#fff;
    border:none;
    border-radius:5px;
    font-size:1em;
    cursor:pointer;
    margin-top:20px;
}

button:hover {
    background:#1f5a2d;
}

.error {
    color:#d32f2f;
    text-align:center;
    margin-bottom:15px;
}

.success {
    color:#2f7a3f;
    text-align:center;
    margin-bottom:15px;
}
.branch-info {
    padding:10px;
    background:#e7f3ff;
    border-left:4px solid #007bff;
    margin-bottom:15px;
    border-radius:4px;
}
</style>
</head>

<body>

<div class="container">

<a href="/inventory_system/dashboard/index.php"
   style="display:inline-block;margin-bottom:15px;background:#007bff;color:#fff;padding:8px 12px;border-radius:5px;text-decoration:none;">
   Dashboard
</a>

<h2>Add Monitor</h2>

<div class="branch-info">
    <strong>Branch Information:</strong><br>
    <?php if($user_role === 'super_admin'): ?>
        You can add monitors to any branch.
    <?php else: ?>
        You can only add monitors to your branch: <strong><?= htmlspecialchars($user_branch) ?></strong>
    <?php endif; ?>
</div>

<?php if ($error): ?>
    <div class="error"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<?php if ($success): ?>
    <div class="success"><?= htmlspecialchars($success) ?></div>
<?php endif; ?>

<form method="POST">

    <label>Monitor Serial Number</label>
    <input type="text"
           name="serial_number"
           placeholder="Scan or type serial number"
           autofocus
           required>

    <label>Model Name</label>
    <input type="text"
           name="model_name"
           placeholder="e.g. Dell P2419H"
           required>

    <label>Size (Inches)</label>
    <input type="number"
           name="size_inches"
           placeholder="e.g. 24"
           min="10"
           required>
           
    <?php if($user_role === 'super_admin'): ?>
        <label>Branch</label>
        <select name="branch" required>
            <option value="">-- Select Branch --</option>
            <option value="KIMATHI">KIMATHI</option>
            <option value="MOI">MOI</option>
        </select>
    <?php else: ?>
        <input type="hidden" name="branch" value="<?= htmlspecialchars($user_branch) ?>">
    <?php endif; ?>

    <button type="submit">Add Monitor</button>
</form>

</div>

</body>
</html>