<?php
session_start();
require_once "../config/db.php";
require_once "../includes/auth_check.php";

$role = $_SESSION['role'] ?? '';
if (!in_array($role, ['super_admin','inventory_admin','manager','technician'], true)) {
    die("Access denied.");
}

$filter_model = trim($_GET['model'] ?? '');
$filter_serial = trim($_GET['serial'] ?? '');
$filter_cargo = trim($_GET['cargo'] ?? '');
$filter_issue = trim($_GET['issue'] ?? '');
$filter_place = trim($_GET['place'] ?? '');
$filter_shop = trim($_GET['shop'] ?? '');
$filter_status = trim($_GET['status'] ?? 'Faulty');

// Pagination: default 50, selectable up to 200 devices per page.
$allowedPerPage = [50, 100, 150, 200];
$perPage = (int)($_GET['per_page'] ?? 50);
if (!in_array($perPage, $allowedPerPage, true)) {
    $perPage = 50;
}
$page = max(1, (int)($_GET['page'] ?? 1));

$where = " WHERE 1=1";
$params = [];
if ($filter_model !== '') { $where .= " AND f.model LIKE :model"; $params['model'] = "%{$filter_model}%"; }
if ($filter_serial !== '') { $where .= " AND f.serial_number LIKE :serial"; $params['serial'] = "%{$filter_serial}%"; }
if ($filter_cargo !== '') { $where .= " AND f.cargo_number LIKE :cargo"; $params['cargo'] = "%{$filter_cargo}%"; }
if ($filter_issue !== '') { $where .= " AND f.issue LIKE :issue"; $params['issue'] = "%{$filter_issue}%"; }
if ($filter_place !== '') { $where .= " AND f.place LIKE :place"; $params['place'] = "%{$filter_place}%"; }
if ($filter_shop !== '') { $where .= " AND f.shop LIKE :shop"; $params['shop'] = "%{$filter_shop}%"; }
if ($filter_status !== '' && in_array($filter_status, ['Faulty','Repaired','Disposed'], true)) { $where .= " AND f.status = :status"; $params['status'] = $filter_status; }

// Count only matching rows; do not load every device just to calculate pagination.
$countStmt = $conn->prepare("SELECT COUNT(*) FROM faulty_devices f" . $where);
$countStmt->execute($params);
$totalRecords = (int)$countStmt->fetchColumn();
$totalPages = max(1, (int)ceil($totalRecords / $perPage));
if ($page > $totalPages) { $page = $totalPages; }
$offset = ($page - 1) * $perPage;

$sql = "SELECT f.* FROM faulty_devices f" . $where . " ORDER BY f.date_added DESC, f.id DESC LIMIT :limit OFFSET :offset";
$stmt = $conn->prepare($sql);
foreach ($params as $key => $value) {
    $stmt->bindValue(':' . $key, $value, PDO::PARAM_STR);
}
$stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$devices = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Preserve all active filters and the selected page size in pagination links.
$paginationParams = $_GET;
unset($paginationParams['page']);
$paginationParams['per_page'] = $perPage;
$paginationUrl = static function(int $targetPage) use ($paginationParams): string {
    $query = $paginationParams;
    $query['page'] = $targetPage;
    return 'faulty_devices.php?' . http_build_query($query);
};
?>
<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Faulty Devices | Mombasa Computers</title><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"><style>
:root{--primary:#1a4b2a;--primary-light:#2a6b3a;--gray-50:#f9fafb;--gray-100:#f3f4f6;--gray-200:#e5e7eb;--gray-300:#d1d5db;--gray-500:#6b7280;--gray-600:#4b5563;--gray-700:#374151;--gray-800:#1f2937;--blue:#2563eb;--radius:.6rem}*{box-sizing:border-box}body{margin:0;font-family:Inter,system-ui,-apple-system,"Segoe UI",sans-serif;background:var(--gray-100);color:var(--gray-800)}.main-content{margin-left:260px;width:calc(100% - 260px);padding:2rem;min-height:100vh}.header,.filters,.table-card{background:#fff;border:1px solid var(--gray-200);border-radius:1rem;box-shadow:0 1px 2px rgba(0,0,0,.05)}.header{padding:1.5rem;margin-bottom:1.25rem}.header-top{display:flex;justify-content:space-between;gap:1rem;align-items:center;flex-wrap:wrap}h1{margin:0;font-size:1.65rem}.actions{display:flex;gap:.65rem;flex-wrap:wrap}.btn{display:inline-flex;align-items:center;gap:.45rem;padding:.7rem 1rem;border:0;border-radius:var(--radius);font-weight:600;text-decoration:none;cursor:pointer}.btn-primary{background:var(--primary);color:#fff}.btn-primary:hover{background:var(--primary-light)}.btn-blue{background:var(--blue);color:#fff}.btn-light{background:var(--gray-200);color:var(--gray-700)}.btn-edit{background:#f59e0b;color:#fff;padding:.48rem .7rem;font-size:.8rem}.btn-edit:hover{background:#d97706}.filters{padding:1.25rem;margin-bottom:1.25rem}.filter-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(160px,1fr));gap:.8rem;align-items:end}.field label{display:block;font-size:.8rem;font-weight:600;color:var(--gray-600);margin-bottom:.35rem}.field input,.field select{width:100%;padding:.65rem .75rem;border:1px solid var(--gray-300);border-radius:var(--radius);background:#fff}.table-card{overflow:hidden}.table-responsive{overflow-x:auto}table{width:100%;border-collapse:collapse;min-width:1100px}th,td{padding:.85rem .9rem;border-bottom:1px solid var(--gray-200);text-align:left;font-size:.88rem;vertical-align:top}th{background:var(--gray-50);color:var(--gray-600);white-space:nowrap}.model{max-width:350px;white-space:normal}.badge{display:inline-block;background:var(--gray-100);padding:.25rem .55rem;border-radius:999px;font-size:.78rem}.empty{padding:3rem;text-align:center;color:var(--gray-500)}.count{color:var(--gray-500);font-size:.9rem;margin-top:.35rem}.pagination-wrap{display:flex;justify-content:space-between;align-items:center;gap:1rem;flex-wrap:wrap;background:#fff;border:1px solid var(--gray-200);border-radius:1rem;margin-top:1rem;padding:1rem 1.25rem}.pagination-info{font-size:.85rem;color:var(--gray-500)}.pagination{display:flex;gap:.4rem;align-items:center;flex-wrap:wrap}.page-link{display:inline-flex;align-items:center;justify-content:center;min-width:38px;height:38px;padding:0 .7rem;border:1px solid var(--gray-300);border-radius:var(--radius);text-decoration:none;color:var(--gray-700);background:#fff;font-size:.85rem;font-weight:600}.page-link:hover{background:var(--gray-100)}.page-link.active{background:var(--primary);border-color:var(--primary);color:#fff}.page-link.disabled{pointer-events:none;opacity:.45}@media(max-width:1200px){.main-content{margin-left:0;width:100%;padding:5rem 1rem 1rem}}@media(max-width:700px){.main-content{padding:4.5rem .65rem .65rem}.actions,.btn{width:100%}.btn{justify-content:center}}
</style></head><body><?php include "../includes/sidebar.php"; ?><div class="main-content"><div class="header"><div class="header-top"><div><h1><i class="fas fa-triangle-exclamation"></i> Faulty Devices</h1><div class="count"><?= number_format(count($devices)) ?> shown of <?= number_format($totalRecords) ?> record(s)</div></div><div class="actions"><a class="btn btn-blue" href="bulk_upload_faulty.php"><i class="fas fa-file-excel"></i> Bulk Upload</a><a class="btn btn-primary" href="add_faulty_device.php"><i class="fas fa-plus"></i> Add Single Device</a></div></div></div><div class="filters"><form method="GET" class="filter-grid"><div class="field"><label>Model</label><input name="model" value="<?= htmlspecialchars($filter_model) ?>" placeholder="Search model"></div><div class="field"><label>Serial Number</label><input name="serial" value="<?= htmlspecialchars($filter_serial) ?>" placeholder="Search SN"></div><div class="field"><label>CN</label><input name="cargo" value="<?= htmlspecialchars($filter_cargo) ?>" placeholder="e.g. CX37"></div><div class="field"><label>Issue</label><input name="issue" value="<?= htmlspecialchars($filter_issue) ?>" placeholder="Search issue"></div><div class="field"><label>Place</label><input name="place" value="<?= htmlspecialchars($filter_place) ?>" placeholder="e.g. CAB.25"></div><div class="field"><label>Shop</label><input name="shop" value="<?= htmlspecialchars($filter_shop) ?>" placeholder="Search shop"></div><div class="field"><label>Status</label><select name="status"><option value="">All Statuses</option><?php foreach(['Faulty','Repaired','Disposed'] as $s): ?><option value="<?= $s ?>" <?= $filter_status===$s?'selected':'' ?>><?= $s ?></option><?php endforeach; ?></select></div><div class="field"><label>Devices Per Page</label><select name="per_page"><?php foreach($allowedPerPage as $size): ?><option value="<?= $size ?>" <?= $perPage===$size?'selected':'' ?>><?= $size ?></option><?php endforeach; ?></select></div><button class="btn btn-primary" type="submit"><i class="fas fa-search"></i> Search</button><a class="btn btn-light" href="faulty_devices.php"><i class="fas fa-rotate-left"></i> Reset</a></form></div><div class="table-card"><div class="table-responsive"><?php if($devices): ?><table><thead><tr><th>#</th><th>MODEL</th><th>SN</th><th>CN</th><th>ISSUE</th><th>PLACE</th><th>SHOP</th><th>STATUS</th><th>DATE ADDED</th><th>ACTIONS</th></tr></thead><tbody><?php foreach($devices as $i=>$d): ?><tr><td><?= $offset + $i + 1 ?></td><td class="model"><?= htmlspecialchars((string)$d['model']) ?></td><td><strong><?= htmlspecialchars((string)$d['serial_number']) ?></strong></td><td><?= htmlspecialchars((string)($d['cargo_number']??'')) ?></td><td><?= htmlspecialchars((string)($d['issue']??'')) ?></td><td><?= htmlspecialchars((string)($d['place']??'')) ?></td><td><span class="badge"><?= htmlspecialchars((string)$d['shop']) ?></span></td><td><span class="badge"><?= htmlspecialchars((string)$d['status']) ?></span></td><td><?= date('Y-m-d H:i',strtotime($d['date_added'])) ?></td><td><a class="btn btn-edit" href="edit_faulty_device.php?id=<?= (int)$d['id'] ?>&return_to=<?= urlencode($_SERVER['REQUEST_URI'] ?? 'faulty_devices.php') ?>"><i class="fas fa-pen"></i> Edit</a></td></tr><?php endforeach; ?></tbody></table><?php else: ?><div class="empty"><i class="fas fa-box-open fa-2x"></i><p>No faulty devices found.</p></div><?php endif; ?></div></div><?php if ($totalRecords > 0): ?><div class="pagination-wrap"><div class="pagination-info">Page <?= number_format($page) ?> of <?= number_format($totalPages) ?> &bull; <?= number_format($totalRecords) ?> total device(s)</div><div class="pagination"><a class="page-link <?= $page <= 1 ? 'disabled' : '' ?>" href="<?= $page > 1 ? htmlspecialchars($paginationUrl($page - 1)) : '#' ?>"><i class="fas fa-chevron-left"></i> Previous</a><?php $startPage = max(1, $page - 2); $endPage = min($totalPages, $page + 2); if ($startPage > 1): ?><a class="page-link" href="<?= htmlspecialchars($paginationUrl(1)) ?>">1</a><?php if ($startPage > 2): ?><span>...</span><?php endif; ?><?php endif; ?><?php for($p=$startPage;$p<=$endPage;$p++): ?><a class="page-link <?= $p===$page?'active':'' ?>" href="<?= htmlspecialchars($paginationUrl($p)) ?>"><?= $p ?></a><?php endfor; ?><?php if ($endPage < $totalPages): ?><?php if ($endPage < $totalPages - 1): ?><span>...</span><?php endif; ?><a class="page-link" href="<?= htmlspecialchars($paginationUrl($totalPages)) ?>"><?= $totalPages ?></a><?php endif; ?><a class="page-link <?= $page >= $totalPages ? 'disabled' : '' ?>" href="<?= $page < $totalPages ? htmlspecialchars($paginationUrl($page + 1)) : '#' ?>">Next <i class="fas fa-chevron-right"></i></a></div></div><?php endif; ?></div></body></html>
