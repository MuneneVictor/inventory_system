<?php
session_start();
require_once "../config/db.php";
require_once "../includes/auth_check.php";

$role = $_SESSION['role'] ?? '';
$user_id = (int)($_SESSION['user_id'] ?? 0);

if (!in_array($role, ['super_admin','inventory_admin','manager','technician'], true)) {
    die("Access denied.");
}

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id || $id < 1) {
    die("Invalid faulty device ID.");
}

// Only allow return navigation back to this module.
$returnTo = trim((string)($_GET['return_to'] ?? 'faulty_devices.php'));
if ($returnTo === '' || preg_match('/^(?:https?:)?\/\//i', $returnTo) || str_contains($returnTo, "\r") || str_contains($returnTo, "\n")) {
    $returnTo = 'faulty_devices.php';
}
if (!str_contains($returnTo, 'faulty_devices')) {
    $returnTo = 'faulty_devices.php';
}

if (empty($_SESSION['faulty_device_edit_csrf'])) {
    $_SESSION['faulty_device_edit_csrf'] = bin2hex(random_bytes(32));
}
$csrfToken = $_SESSION['faulty_device_edit_csrf'];

$fetch = $conn->prepare("SELECT * FROM faulty_devices WHERE id = :id LIMIT 1");
$fetch->execute(['id' => $id]);
$device = $fetch->fetch(PDO::FETCH_ASSOC);

if (!$device) {
    die("Faulty device not found.");
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $submittedToken = (string)($_POST['csrf_token'] ?? '');

    if (!hash_equals($csrfToken, $submittedToken)) {
        $error = 'Invalid request token. Refresh the page and try again.';
    } else {
        $model = trim((string)($_POST['model'] ?? ''));
        $serial = trim((string)($_POST['serial_number'] ?? ''));
        $cargo = trim((string)($_POST['cargo_number'] ?? ''));
        $issue = trim((string)($_POST['issue'] ?? ''));
        $place = trim((string)($_POST['place'] ?? ''));
        $shop = trim((string)($_POST['shop'] ?? ''));
        $status = trim((string)($_POST['status'] ?? 'Faulty'));
        $notes = trim((string)($_POST['notes'] ?? ''));

        if ($model === '') {
            $error = 'Model is required.';
        } elseif ($serial === '') {
            $error = 'Serial number is required.';
        } elseif ($shop === '') {
            $error = 'Shop is required.';
        } elseif (!in_array($status, ['Faulty','Repaired','Disposed'], true)) {
            $error = 'Invalid status.';
        } else {
            // Prevent two active Faulty rows from ending up with the same serial number.
            if ($status === 'Faulty') {
                $dup = $conn->prepare("
                    SELECT 1
                    FROM faulty_devices
                    WHERE serial_number = :serial
                      AND status = 'Faulty'
                      AND id <> :id
                    LIMIT 1
                ");
                $dup->execute([
                    'serial' => $serial,
                    'id' => $id
                ]);

                if ($dup->fetchColumn()) {
                    $error = 'Another Faulty record already uses this serial number.';
                }
            }
        }

        if ($error === '') {
            $old = $device;

            $newValues = [
                'model' => $model,
                'serial_number' => $serial,
                'cargo_number' => $cargo !== '' ? $cargo : null,
                'issue' => $issue !== '' ? $issue : null,
                'place' => $place !== '' ? $place : null,
                'shop' => $shop,
                'status' => $status,
                'notes' => $notes !== '' ? $notes : null
            ];

            $changes = [];
            $labels = [
                'model' => 'MODEL',
                'serial_number' => 'SN',
                'cargo_number' => 'CN',
                'issue' => 'ISSUE',
                'place' => 'PLACE',
                'shop' => 'SHOP',
                'status' => 'STATUS',
                'notes' => 'NOTES'
            ];

            foreach ($labels as $field => $label) {
                $before = $old[$field] ?? null;
                $after = $newValues[$field] ?? null;

                if ((string)($before ?? '') !== (string)($after ?? '')) {
                    $beforeText = ($before === null || $before === '') ? '-' : (string)$before;
                    $afterText = ($after === null || $after === '') ? '-' : (string)$after;
                    $changes[] = "{$label}: {$beforeText} -> {$afterText}";
                }
            }

            if (!$changes) {
                $error = 'No changes were made.';
            } else {
                try {
                    $conn->beginTransaction();

                    $update = $conn->prepare("
                        UPDATE faulty_devices
                        SET model = :model,
                            serial_number = :serial_number,
                            cargo_number = :cargo_number,
                            issue = :issue,
                            place = :place,
                            shop = :shop,
                            status = :status,
                            notes = :notes
                        WHERE id = :id
                    ");

                    $update->execute([
                        'model' => $newValues['model'],
                        'serial_number' => $newValues['serial_number'],
                        'cargo_number' => $newValues['cargo_number'],
                        'issue' => $newValues['issue'],
                        'place' => $newValues['place'],
                        'shop' => $newValues['shop'],
                        'status' => $newValues['status'],
                        'notes' => $newValues['notes'],
                        'id' => $id
                    ]);

                    // Logging is part of the same transaction so a successful edit always has an audit log.
                    $details = "Edited faulty device ID {$id}. " . implode('; ', $changes);
                    $log = $conn->prepare("
                        INSERT INTO activity_logs (user_id, action, details)
                        VALUES (:user_id, 'Faulty Device - Edit', :details)
                    ");
                    $log->execute([
                        'user_id' => $user_id,
                        'details' => $details
                    ]);

                    $conn->commit();

                    // Refresh the displayed record with the saved values.
                    $fetch->execute(['id' => $id]);
                    $device = $fetch->fetch(PDO::FETCH_ASSOC);
                    $success = 'Faulty device updated successfully. The changes were recorded in the activity log.';
                } catch (Throwable $e) {
                    if ($conn->inTransaction()) {
                        $conn->rollBack();
                    }
                    $error = 'Unable to update this device. No changes were saved.';
                }
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Edit Faulty Device | Mombasa Computers</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<style>
:root{
    --primary:#1a4b2a;--primary-light:#2a6b3a;--gray-50:#f9fafb;--gray-100:#f3f4f6;
    --gray-200:#e5e7eb;--gray-300:#d1d5db;--gray-500:#6b7280;--gray-600:#4b5563;
    --gray-700:#374151;--gray-800:#1f2937;--red:#991b1b;--green:#065f46;
}
*{box-sizing:border-box}
body{margin:0;font-family:Inter,system-ui,-apple-system,"Segoe UI",sans-serif;background:var(--gray-100);color:var(--gray-800)}
.main-content{margin-left:260px;width:calc(100% - 260px);padding:2rem;min-height:100vh}
.page-header,.card{background:#fff;border:1px solid var(--gray-200);border-radius:1rem;box-shadow:0 1px 2px rgba(0,0,0,.05)}
.page-header{padding:1.35rem 1.5rem;margin-bottom:1.25rem}
.page-header h1{margin:0;font-size:1.5rem}
.breadcrumb{margin-top:.5rem;font-size:.85rem;color:var(--gray-500)}
.breadcrumb a{color:var(--primary);text-decoration:none}
.card{max-width:900px;margin:0 auto;padding:1.5rem}
.grid{display:grid;grid-template-columns:1fr 1fr;gap:1rem}
.field{margin-bottom:.2rem}.full{grid-column:1/-1}
label{display:block;font-size:.85rem;font-weight:600;color:var(--gray-700);margin-bottom:.4rem}
input,select,textarea{width:100%;padding:.75rem .85rem;border:1px solid var(--gray-300);border-radius:.55rem;font:inherit;background:#fff}
textarea{resize:vertical}
.actions{display:flex;gap:.7rem;flex-wrap:wrap;margin-top:1.25rem}
.btn{display:inline-flex;align-items:center;justify-content:center;gap:.45rem;padding:.75rem 1rem;border:0;border-radius:.55rem;text-decoration:none;font-weight:600;cursor:pointer}
.btn-primary{background:var(--primary);color:#fff}.btn-primary:hover{background:var(--primary-light)}
.btn-light{background:var(--gray-200);color:var(--gray-700)}
.alert{padding:.85rem 1rem;border-radius:.55rem;margin-bottom:1rem}
.alert-error{background:#fef2f2;color:var(--red);border:1px solid #fecaca}
.alert-success{background:#ecfdf5;color:var(--green);border:1px solid #a7f3d0}
.audit-note{margin-top:1rem;padding:.8rem 1rem;background:var(--gray-50);border-radius:.55rem;color:var(--gray-600);font-size:.84rem}
@media(max-width:1200px){.main-content{margin-left:0;width:100%;padding:5rem 1rem 1rem}}
@media(max-width:700px){.grid{grid-template-columns:1fr}.full{grid-column:auto}.actions,.btn{width:100%}}
</style>
</head>
<body>
<?php include "../includes/sidebar.php"; ?>
<div class="main-content">
    <div class="page-header">
        <h1><i class="fas fa-pen-to-square"></i> Edit Faulty Device</h1>
        <div class="breadcrumb">
            <a href="<?= htmlspecialchars($returnTo) ?>">Faulty Devices</a> / Edit
        </div>
    </div>

    <div class="card">
        <?php if ($error): ?>
            <div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <?php if ($success): ?>
            <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
        <?php endif; ?>

        <form method="POST">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken) ?>">

            <div class="grid">
                <div class="field full">
                    <label>MODEL</label>
                    <textarea name="model" rows="3" required><?= htmlspecialchars((string)$device['model']) ?></textarea>
                </div>

                <div class="field">
                    <label>SN</label>
                    <input type="text" name="serial_number" required value="<?= htmlspecialchars((string)$device['serial_number']) ?>">
                </div>

                <div class="field">
                    <label>CN</label>
                    <input type="text" name="cargo_number" value="<?= htmlspecialchars((string)($device['cargo_number'] ?? '')) ?>">
                </div>

                <div class="field">
                    <label>ISSUE</label>
                    <input type="text" name="issue" value="<?= htmlspecialchars((string)($device['issue'] ?? '')) ?>">
                </div>

                <div class="field">
                    <label>PLACE</label>
                    <input type="text" name="place" value="<?= htmlspecialchars((string)($device['place'] ?? '')) ?>">
                </div>

                <div class="field">
                    <label>SHOP</label>
                    <input type="text" name="shop" required value="<?= htmlspecialchars((string)$device['shop']) ?>">
                </div>

                <div class="field">
                    <label>STATUS</label>
                    <select name="status" required>
                        <?php foreach (['Faulty','Repaired','Disposed'] as $statusOption): ?>
                            <option value="<?= $statusOption ?>" <?= $device['status'] === $statusOption ? 'selected' : '' ?>>
                                <?= $statusOption ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="field full">
                    <label>NOTES</label>
                    <textarea name="notes" rows="4" placeholder="Optional notes"><?= htmlspecialchars((string)($device['notes'] ?? '')) ?></textarea>
                </div>
            </div>

            <div class="actions">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Save Changes
                </button>
                <a href="<?= htmlspecialchars($returnTo) ?>" class="btn btn-light">
                    <i class="fas fa-arrow-left"></i> Back
                </a>
            </div>

            <div class="audit-note">
                <i class="fas fa-shield-halved"></i>
                Every successful edit is written to the activity log with the fields changed and their previous/new values.
            </div>
        </form>
    </div>
</div>
</body>
</html>
