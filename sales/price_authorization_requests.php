<?php
session_start();
require_once "../config/db.php";
require_once "../includes/auth_check.php";

if (($_SESSION['role'] ?? '') !== 'super_admin') {
    die("ACCESS DENIED.");
}

$user_id = (int)($_SESSION['user_id'] ?? 0);
$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $requestId = (int)($_POST['request_id'] ?? 0);
    $action = (string)($_POST['action'] ?? '');

    if ($requestId <= 0 || !in_array($action, ['approve','reject'], true)) {
        $error = 'Invalid authorization request.';
    } else {
        try {
            $conn->beginTransaction();

            $stmt = $conn->prepare("
                SELECT r.*, d.status AS device_status, s.sale_status
                FROM device_price_authorization_requests r
                LEFT JOIN devices d ON CONVERT(d.serial_number USING utf8mb4) COLLATE utf8mb4_general_ci = CONVERT(r.serial_number USING utf8mb4) COLLATE utf8mb4_general_ci
                LEFT JOIN sales s ON s.id = r.sale_id
                WHERE r.id = ?
                FOR UPDATE
            ");
            $stmt->execute([$requestId]);
            $request = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$request) {
                throw new Exception('Authorization request not found.');
            }

            if ($request['status'] !== 'pending') {
                throw new Exception('This authorization request has already been reviewed.');
            }

            if ($action === 'approve') {
                if (($request['device_status'] ?? '') !== 'In Stock') {
                    throw new Exception('This device is no longer In Stock, so the request cannot be approved.');
                }

                if (($request['sale_status'] ?? '') !== 'active') {
                    throw new Exception('This sale is no longer active, so the request cannot be approved.');
                }
            }

            $newStatus = $action === 'approve' ? 'approved' : 'rejected';

            $stmt = $conn->prepare("
                UPDATE device_price_authorization_requests
                SET status = ?,
                    reviewed_by = ?,
                    reviewed_at = NOW(),
                    updated_at = NOW()
                WHERE id = ?
                  AND status = 'pending'
            ");
            $stmt->execute([$newStatus, $user_id, $requestId]);

            if ($stmt->rowCount() !== 1) {
                throw new Exception('The request could not be updated.');
            }

            $log = $conn->prepare("
                INSERT INTO activity_logs (user_id, action, details)
                VALUES (?, ?, ?)
            ");
            $log->execute([
                $user_id,
                $action === 'approve' ? 'Approved lower selling price' : 'Rejected lower selling price',
                ucfirst($newStatus) . " request #{$requestId} for serial {$request['serial_number']} at KES " . number_format((float)$request['requested_price'], 2)
            ]);

            $conn->commit();

            $success = $action === 'approve'
                ? 'Lower selling price approved successfully.'
                : 'Lower selling price request rejected.';
        } catch (Throwable $e) {
            if ($conn->inTransaction()) {
                $conn->rollBack();
            }
            $error = $e->getMessage();
        }
    }
}

$statusFilter = $_GET['status'] ?? 'pending';
if (!in_array($statusFilter, ['pending','approved','rejected','used','all'], true)) {
    $statusFilter = 'pending';
}

$requestIdFilter = trim((string)($_GET['request_id'] ?? ''));
$saleIdFilter = trim((string)($_GET['sale_id'] ?? ''));
$serialFilter = trim((string)($_GET['serial_number'] ?? ''));
$modelFilter = trim((string)($_GET['model_name'] ?? ''));
$requesterFilter = trim((string)($_GET['requested_by'] ?? ''));
$reviewerFilter = trim((string)($_GET['reviewed_by'] ?? ''));
$setPriceFilter = trim((string)($_GET['set_price'] ?? ''));
$requestedPriceFilter = trim((string)($_GET['requested_price'] ?? ''));
$dateFromFilter = trim((string)($_GET['date_from'] ?? ''));
$dateToFilter = trim((string)($_GET['date_to'] ?? ''));

$sql = "
    SELECT
        r.*,
        requester.full_name AS requester_name,
        requester.email AS requester_email,
        reviewer.full_name AS reviewer_name,
        d.model_name,
        d.status AS device_status,
        s.sale_status
    FROM device_price_authorization_requests r
    LEFT JOIN users requester ON requester.id = r.requested_by
    LEFT JOIN users reviewer ON reviewer.id = r.reviewed_by
    LEFT JOIN devices d ON CONVERT(d.serial_number USING utf8mb4) COLLATE utf8mb4_general_ci = CONVERT(r.serial_number USING utf8mb4) COLLATE utf8mb4_general_ci
    LEFT JOIN sales s ON s.id = r.sale_id
";

$where = [];
$params = [];

if ($statusFilter !== 'all') {
    $where[] = "r.status = ?";
    $params[] = $statusFilter;
}

if ($requestIdFilter !== '' && ctype_digit($requestIdFilter)) {
    $where[] = "r.id = ?";
    $params[] = (int)$requestIdFilter;
}

if ($saleIdFilter !== '' && ctype_digit($saleIdFilter)) {
    $where[] = "r.sale_id = ?";
    $params[] = (int)$saleIdFilter;
}

if ($serialFilter !== '') {
    $where[] = "r.serial_number LIKE ?";
    $params[] = '%' . $serialFilter . '%';
}

if ($modelFilter !== '') {
    $where[] = "d.model_name LIKE ?";
    $params[] = '%' . $modelFilter . '%';
}

if ($requesterFilter !== '') {
    $where[] = "(requester.full_name LIKE ? OR requester.email LIKE ?)";
    $params[] = '%' . $requesterFilter . '%';
    $params[] = '%' . $requesterFilter . '%';
}

if ($reviewerFilter !== '') {
    $where[] = "reviewer.full_name LIKE ?";
    $params[] = '%' . $reviewerFilter . '%';
}

if ($setPriceFilter !== '' && is_numeric($setPriceFilter)) {
    $where[] = "r.set_price = ?";
    $params[] = (float)$setPriceFilter;
}

if ($requestedPriceFilter !== '' && is_numeric($requestedPriceFilter)) {
    $where[] = "r.requested_price = ?";
    $params[] = (float)$requestedPriceFilter;
}

if ($dateFromFilter !== '') {
    $where[] = "DATE(r.created_at) >= ?";
    $params[] = $dateFromFilter;
}

if ($dateToFilter !== '') {
    $where[] = "DATE(r.created_at) <= ?";
    $params[] = $dateToFilter;
}

if ($where) {
    $sql .= " WHERE " . implode(" AND ", $where);
}

$sql .= " ORDER BY CASE WHEN r.status = 'pending' THEN 0 ELSE 1 END, r.created_at DESC, r.id DESC";

$stmt = $conn->prepare($sql);
$stmt->execute($params);
$requests = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmt = $conn->prepare("
    SELECT COUNT(*)
    FROM device_price_authorization_requests
    WHERE status = 'pending'
");
$stmt->execute();
$pendingCount = (int)$stmt->fetchColumn();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1,viewport-fit=cover">
<title>Price Authorization Requests | Mombasa Computers</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<style>
:root{--p:#1a4b2a;--bg:#f3f4f6;--b:#e5e7eb;--t:#1f2937;--m:#6b7280}
*{box-sizing:border-box}
body{margin:0;font-family:Inter,system-ui,sans-serif;background:var(--bg);color:var(--t)}
.main{margin-left:260px;padding:2rem;min-height:100vh}
.card{background:#fff;border:1px solid var(--b);border-radius:14px;padding:1.2rem;margin-bottom:1rem}
.header{display:flex;justify-content:space-between;align-items:center;gap:1rem;flex-wrap:wrap}
.filters{display:flex;gap:.4rem;flex-wrap:wrap}
.filters a{padding:.5rem .7rem;border:1px solid var(--b);border-radius:8px;text-decoration:none;color:var(--t);font-size:.8rem}
.filters a.active{background:var(--p);color:#fff}
.alert{padding:.9rem 1rem;border-radius:8px;margin-bottom:1rem}
.ok{background:#ecfdf5;color:#065f46}
.err{background:#fef2f2;color:#991b1b}
.table-wrap{overflow:auto}
table{border-collapse:collapse;min-width:1200px;width:100%}
th,td{padding:.65rem;border-bottom:1px solid var(--b);text-align:left;font-size:.8rem;vertical-align:top}
th{background:#f9fafb}
.badge{display:inline-block;padding:.24rem .5rem;border-radius:999px;font-size:.7rem;font-weight:800}
.pending{background:#fef3c7;color:#92400e}
.approved{background:#dcfce7;color:#166534}
.rejected{background:#fee2e2;color:#991b1b}
.used{background:#e5e7eb;color:#374151}
.lower{color:#b91c1c;font-weight:800}
.small{font-size:.72rem;color:var(--m)}
.actions{display:flex;gap:.4rem}
.btn{border:0;border-radius:7px;padding:.5rem .65rem;font-weight:800;cursor:pointer}
.approve{background:#166534;color:#fff}
.reject{background:#b91c1c;color:#fff}
.breadcrumb{font-size:.82rem;color:var(--m);margin-top:.35rem}
.breadcrumb a{color:var(--p);text-decoration:none}
.search-grid{display:grid;grid-template-columns:repeat(5,minmax(150px,1fr));gap:.75rem}
.search-field label{display:block;font-size:.72rem;font-weight:700;color:var(--m);margin-bottom:.3rem}
.search-field input{width:100%;padding:.6rem .7rem;border:1px solid var(--b);border-radius:8px;background:#fff;color:var(--t)}
.search-actions{display:flex;gap:.5rem;margin-top:.85rem;flex-wrap:wrap}
.search-btn{background:var(--p);color:#fff;text-decoration:none}
.reset-btn{background:#6b7280;color:#fff;text-decoration:none}
@media(max-width:1200px){.main{margin-left:0;padding:5rem 1rem 1rem}.search-grid{grid-template-columns:repeat(2,minmax(150px,1fr))}}
@media(max-width:640px){.search-grid{grid-template-columns:1fr}}
</style>
</head>
<body>
<?php include "../includes/sidebar.php"; ?>

<main class="main">

<section class="card">
    <div class="header">
        <div>
            <h1><i class="fas fa-shield-halved"></i> Price Authorization Requests</h1>
            <div class="breadcrumb">
                <a href="../dashboard/superadmindashboard.php">Dashboard</a>
                <span> / </span>
                <span>Price Authorization Requests</span>
            </div>
            <div class="small"><?=number_format($pendingCount)?> pending request(s)</div>
        </div>

        <div class="filters">
            <?php foreach(['pending'=>'Pending','approved'=>'Approved','rejected'=>'Rejected','used'=>'Used','all'=>'All'] as $key=>$label):?>
                <?php
                    $statusParams = $_GET;
                    $statusParams['status'] = $key;
                ?>
                <a class="<?=$statusFilter===$key?'active':''?>" href="?<?=htmlspecialchars(http_build_query($statusParams))?>"><?=htmlspecialchars($label)?></a>
            <?php endforeach;?>
        </div>
    </div>
</section>

<section class="card">
    <form method="get">
        <input type="hidden" name="status" value="<?=htmlspecialchars($statusFilter)?>">

        <div class="search-grid">
            <div class="search-field">
                <label>Request ID</label>
                <input type="number" name="request_id" min="1" value="<?=htmlspecialchars($requestIdFilter)?>" placeholder="e.g. 24">
            </div>

            <div class="search-field">
                <label>Sale ID</label>
                <input type="number" name="sale_id" min="1" value="<?=htmlspecialchars($saleIdFilter)?>" placeholder="e.g. 105">
            </div>

            <div class="search-field">
                <label>Serial Number</label>
                <input type="text" name="serial_number" value="<?=htmlspecialchars($serialFilter)?>" placeholder="Search serial">
            </div>

            <div class="search-field">
                <label>Device Model</label>
                <input type="text" name="model_name" value="<?=htmlspecialchars($modelFilter)?>" placeholder="Search model">
            </div>

            <div class="search-field">
                <label>Requested By</label>
                <input type="text" name="requested_by" value="<?=htmlspecialchars($requesterFilter)?>" placeholder="Name or email">
            </div>

            <div class="search-field">
                <label>Reviewed By</label>
                <input type="text" name="reviewed_by" value="<?=htmlspecialchars($reviewerFilter)?>" placeholder="Reviewer name">
            </div>

            <div class="search-field">
                <label>Set Price (KES)</label>
                <input type="number" name="set_price" step="0.01" min="0" value="<?=htmlspecialchars($setPriceFilter)?>" placeholder="Exact set price">
            </div>

            <div class="search-field">
                <label>Requested Price (KES)</label>
                <input type="number" name="requested_price" step="0.01" min="0" value="<?=htmlspecialchars($requestedPriceFilter)?>" placeholder="Exact requested price">
            </div>

            <div class="search-field">
                <label>Requested From</label>
                <input type="date" name="date_from" value="<?=htmlspecialchars($dateFromFilter)?>">
            </div>

            <div class="search-field">
                <label>Requested To</label>
                <input type="date" name="date_to" value="<?=htmlspecialchars($dateToFilter)?>">
            </div>
        </div>

        <div class="search-actions">
            <button class="btn search-btn" type="submit"><i class="fas fa-search"></i> Search</button>
            <a class="btn reset-btn" href="?status=<?=urlencode($statusFilter)?>"><i class="fas fa-rotate-left"></i> Reset Search</a>
        </div>
    </form>
</section>

<?php if($success):?>
<div class="alert ok"><?=htmlspecialchars($success)?></div>
<?php endif;?>

<?php if($error):?>
<div class="alert err"><?=htmlspecialchars($error)?></div>
<?php endif;?>

<section class="card">
<div class="table-wrap">
<table>
<thead>
<tr>
    <th>#</th>
    <th>Requested</th>
    <th>Sale</th>
    <th>Serial</th>
    <th>Device</th>
    <th>Requested By</th>
    <th>Set Price</th>
    <th>Requested Price</th>
    <th>Difference</th>
    <th>Status</th>
    <th>Reviewed By</th>
    <th>Action</th>
</tr>
</thead>
<tbody>

<?php if(!$requests):?>
<tr><td colspan="12">No authorization requests found.</td></tr>
<?php else:?>

<?php foreach($requests as $r):
    $difference = (float)$r['set_price'] - (float)$r['requested_price'];
?>
<tr>
    <td>#<?=(int)$r['id']?></td>
    <td><?=htmlspecialchars($r['created_at'])?></td>
    <td>#<?=(int)$r['sale_id']?><div class="small"><?=htmlspecialchars($r['sale_status'] ?? '-')?></div></td>
    <td><code><?=htmlspecialchars($r['serial_number'])?></code></td>
    <td><?=htmlspecialchars($r['model_name'] ?? '-')?><div class="small"><?=htmlspecialchars($r['device_status'] ?? '-')?></div></td>
    <td><?=htmlspecialchars($r['requester_name'] ?? '-')?><div class="small"><?=htmlspecialchars($r['requester_email'] ?? '')?></div></td>
    <td>KES <?=number_format((float)$r['set_price'],2)?></td>
    <td class="lower">KES <?=number_format((float)$r['requested_price'],2)?></td>
    <td class="lower">- KES <?=number_format(max(0,$difference),2)?></td>
    <td><span class="badge <?=htmlspecialchars($r['status'])?>"><?=htmlspecialchars(ucfirst($r['status']))?></span></td>
    <td><?=htmlspecialchars($r['reviewer_name'] ?? '-')?><div class="small"><?=htmlspecialchars($r['reviewed_at'] ?? '')?></div></td>
    <td>
        <?php if($r['status']==='pending'):?>
        <div class="actions">
            <form method="post">
                <input type="hidden" name="request_id" value="<?=(int)$r['id']?>">
                <button class="btn approve" type="submit" name="action" value="approve">Approve</button>
            </form>

            <form method="post">
                <input type="hidden" name="request_id" value="<?=(int)$r['id']?>">
                <button class="btn reject" type="submit" name="action" value="reject">Reject</button>
            </form>
        </div>
        <?php else:?>
        —
        <?php endif;?>
    </td>
</tr>
<?php endforeach;?>

<?php endif;?>

</tbody>
</table>
</div>
</section>

</main>

<?php require_once "../includes/footer.php"; ?>
</body>
</html>
