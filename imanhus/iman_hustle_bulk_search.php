<?php
session_start();
require_once "../config/db.php";
require_once "../includes/auth_check.php";
require_once "../includes/owner_inventory_access.php";

$access = requireOwnerInventoryAccess($conn);
$user_id = (int)$access['user_id'];

$error = '';
$foundItems = [];
$notFoundSerials = [];
$input = '';

function hustleDash($value): string {
    $value = trim((string)($value ?? ''));
    return $value === '' ? '-' : $value;
}

function hustleSpecs(array $item): string {
    $parts = [];
    if (!empty($item['manufacturer'])) $parts[] = $item['manufacturer'];
    if (!empty($item['model_name'])) $parts[] = $item['model_name'];
    if (!empty($item['form_factor'])) $parts[] = $item['form_factor'];
    if (!empty($item['processor'])) $parts[] = $item['processor'];
    if (!empty($item['ram'])) $parts[] = $item['ram'] . (stripos((string)$item['ram'], 'GB') === false && is_numeric($item['ram']) ? 'GB' : '');
    if (!empty($item['storage'])) $parts[] = $item['storage'];
    return implode(' | ', $parts);
}

function hustleMoney($value): string {
    return ($value === null || $value === '') ? '-' : 'KES ' . number_format((float)$value, 2);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['search_serial'])) {
    $input = trim((string)($_POST['serial_number'] ?? ''));
    if ($input === '') {
        $error = 'Please enter serial number(s).';
    } else {
        $serials = preg_split('/[\s,]+/', $input, -1, PREG_SPLIT_NO_EMPTY);
        $serials = array_values(array_unique(array_filter(array_map('trim', $serials))));

        if (!$serials) {
            $error = 'No valid serial numbers found.';
        } elseif (count($serials) > 500) {
            $error = 'Please search a maximum of 500 serial numbers at a time.';
        } else {
            $placeholders = implode(',', array_fill(0, count($serials), '?'));
            $sql = "SELECT h.*, u.full_name AS added_by_name
                    FROM iman_hustle_items h
                    LEFT JOIN users u ON h.added_by = u.id
                    WHERE h.serial_number IN ($placeholders)";
            $stmt = $conn->prepare($sql);
            $stmt->execute($serials);
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $bySerial = [];
            foreach ($rows as $row) {
                $bySerial[(string)$row['serial_number']] = $row;
            }
            foreach ($serials as $serial) {
                if (isset($bySerial[$serial])) $foundItems[] = $bySerial[$serial];
                else $notFoundSerials[] = $serial;
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
<title>Bulk Search Iman's Hustle | Mombasa Computers</title>
<link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>
<style>
:root{--primary:#1a4b2a;--primary-light:#2a6b3a;--gray-50:#f9fafb;--gray-100:#f3f4f6;--gray-200:#e5e7eb;--gray-300:#d1d5db;--gray-400:#9ca3af;--gray-500:#6b7280;--gray-600:#4b5563;--gray-700:#374151;--gray-800:#1f2937;--gold:#d7b729;--shadow-sm:0 1px 2px 0 rgb(0 0 0/.05);--radius-md:.5rem;--radius-xl:1rem;--font-sans:'Inter',system-ui,sans-serif}
*{margin:0;padding:0;box-sizing:border-box}body{font-family:var(--font-sans);background:var(--gray-100);color:var(--gray-800);line-height:1.5;overflow-x:hidden}.main-content{padding:2rem 2rem 1rem;margin-left:260px;width:calc(100% - 260px);min-height:100vh}.page-header{background:#fff;padding:1.5rem 2rem;border-radius:var(--radius-xl);margin-bottom:1.5rem;box-shadow:var(--shadow-sm);border:1px solid var(--gray-200)}.page-header h1{font-size:1.75rem;font-weight:600;margin-bottom:.5rem;display:flex;align-items:center;gap:.75rem}.page-header h1 i{color:var(--primary)}.breadcrumb{color:var(--gray-500);font-size:.9rem}.breadcrumb a{color:var(--primary);text-decoration:none}.card{background:#fff;border-radius:var(--radius-xl);border:1px solid var(--gray-200);overflow:hidden;box-shadow:var(--shadow-sm);margin-bottom:1.5rem}.card-header{background:var(--gray-50);padding:1rem 1.5rem;border-bottom:1px solid var(--gray-200);font-weight:600}.card-body{padding:1.5rem}.form-group{margin-bottom:1.5rem}.form-group label{display:block;font-size:.875rem;font-weight:500;margin-bottom:.5rem;color:var(--gray-700)}textarea{width:100%;padding:.75rem;border:1px solid var(--gray-300);border-radius:var(--radius-md);background:#fff;font-family:inherit;resize:vertical}.btn{padding:.75rem 1.5rem;background:var(--primary);color:#fff;border:0;border-radius:var(--radius-md);cursor:pointer;display:inline-flex;align-items:center;gap:.5rem;width:100%;justify-content:center;font-family:inherit}.btn:hover{background:var(--primary-light)}.scan-btn-wrapper{display:flex;gap:.75rem;align-items:center;flex-wrap:wrap;margin-bottom:1rem}.scan-btn{background:#2563eb;color:#fff;border:0;padding:.5rem 1rem;border-radius:var(--radius-md);cursor:pointer;display:inline-flex;align-items:center;gap:.5rem}.alert{padding:1rem;border-radius:var(--radius-md);margin-bottom:1rem}.alert-error{background:#fef2f2;border:1px solid #fecaca;color:#991b1b}.table-responsive{overflow-x:auto;-webkit-overflow-scrolling:touch}.table-responsive table{min-width:1900px}table{width:100%;border-collapse:collapse}th,td{padding:.72rem;text-align:left;border-bottom:1px solid var(--gray-200);vertical-align:top;font-size:.82rem;white-space:nowrap}th{background:var(--gold);color:#171717;font-weight:700}.specs-text{font-size:.8rem;color:var(--gray-600);white-space:normal;word-break:break-word;min-width:380px;display:block}.notes{white-space:pre-line;min-width:220px;max-width:320px}.status{display:inline-block;padding:.25rem .65rem;border-radius:999px;font-size:.72rem;font-weight:600}.status-in{background:#d1fae5;color:#065f46}.status-sold{background:#fee2e2;color:#991b1b}.summary{display:flex;gap:1rem;flex-wrap:wrap;margin-bottom:1rem}.summary span{background:var(--gray-50);border:1px solid var(--gray-200);padding:.55rem .8rem;border-radius:var(--radius-md);font-size:.82rem}.footer{text-align:center;padding:1.5rem 0 .5rem;margin-top:1.5rem;font-size:.85rem;color:var(--gray-400);border-top:1px solid var(--gray-200)}.scanner-overlay{display:none;position:fixed;inset:0;background:rgba(0,0,0,.85);z-index:9999;justify-content:center;align-items:center}.scanner-overlay.active{display:flex}.scanner-box{background:#fff;border-radius:var(--radius-xl);padding:1.5rem;max-width:500px;width:95%;text-align:center;position:relative}.close-btn{position:absolute;top:10px;right:15px;font-size:1.8rem;cursor:pointer;background:none;border:0;color:var(--gray-500)}#reader{width:100%;min-height:300px;margin:1rem 0}
@media(min-width:1025px){.scan-btn{display:none}}@media(max-width:1200px){.main-content{margin-left:0!important;width:100%!important;padding:5rem 1rem 1rem!important}}@media(max-width:768px){.card-body{padding:1rem}.page-header{padding:1rem 1.25rem}.page-header h1{font-size:1.25rem}}
</style>
</head>
<body>
<?php include "../includes/sidebar.php"; ?>
<div class="main-content">
<div class="page-header">
<h1><i class="fas fa-magnifying-glass"></i> Iman's Hustle — Bulk Search</h1>
<div class="breadcrumb"><a href="overview.php"><i class="fas fa-boxes-stacked"></i> Iman's Hustle</a><span> / </span><span>Bulk Search</span></div>
</div>

<?php if ($error): ?><div class="alert alert-error"><i class="fas fa-exclamation-circle"></i> <?= htmlspecialchars($error) ?></div><?php endif; ?>

<div class="card"><div class="card-header"><i class="fas fa-search"></i> Search Multiple Iman's Hustle Items</div><div class="card-body">
<form method="POST">
<div class="form-group"><label>Serial Numbers (one per line, space separated, or comma separated)</label>
<div class="scan-btn-wrapper"><button type="button" class="scan-btn" onclick="openScanner()"><i class="fas fa-camera"></i> Scan Serial Number</button><span style="font-size:.8rem;color:var(--gray-500)">(scan multiple items one after another)</span></div>
<textarea name="serial_number" id="serialInput" rows="6" placeholder="Example:&#10;SN001&#10;SN002&#10;SN003" required autofocus><?= htmlspecialchars($input) ?></textarea></div>
<button type="submit" name="search_serial" class="btn"><i class="fas fa-search"></i> Search Item(s)</button>
</form></div></div>

<?php if (!empty($notFoundSerials)): ?><div class="alert alert-error"><strong>Not Found (<?= count($notFoundSerials) ?>):</strong> <?= htmlspecialchars(implode(', ', $notFoundSerials)) ?></div><?php endif; ?>

<?php if (!empty($foundItems)): ?>
<div class="card"><div class="card-header"><i class="fas fa-list"></i> Search Results</div><div class="card-body">
<div class="summary"><span><strong>Found:</strong> <?= count($foundItems) ?></span><span><strong>Not Found:</strong> <?= count($notFoundSerials) ?></span><span><strong>Total Searched:</strong> <?= count($foundItems)+count($notFoundSerials) ?></span></div>
<div class="table-responsive"><table><thead><tr>
<th>#</th><th>Serial</th><th>Asset ID</th><th>Item Type</th><th>Specifications</th><th>Grade</th><th>Location</th><th>Status</th><th>Buying Price</th><th>Planned S.P</th><th>Planned Profit</th><th>Notes</th><th>Added By</th><th>Date Added</th><th>Sale Info</th>
</tr></thead><tbody>
<?php foreach ($foundItems as $i => $d):
    $plannedProfit = ($d['planned_selling_price'] !== null && $d['planned_selling_price'] !== '' && $d['buying_price'] !== null && $d['buying_price'] !== '') ? (float)$d['planned_selling_price'] - (float)$d['buying_price'] : null;
?>
<tr>
<td><?= $i+1 ?></td>
<td><code><?= htmlspecialchars(hustleDash($d['serial_number'])) ?></code></td>
<td><?= htmlspecialchars(hustleDash($d['asset_id'])) ?></td>
<td><?= htmlspecialchars(hustleDash($d['item_type'])) ?></td>
<td><span class="specs-text"><?= htmlspecialchars(hustleSpecs($d)) ?></span></td>
<td><?= htmlspecialchars(hustleDash($d['grade'])) ?></td>
<td><?= htmlspecialchars(hustleDash($d['location'])) ?></td>
<td><span class="status <?= ($d['status'] ?? '') === 'In Stock' ? 'status-in' : 'status-sold' ?>"><?= htmlspecialchars(hustleDash($d['status'])) ?></span></td>
<td><?= hustleMoney($d['buying_price']) ?></td>
<td><?= hustleMoney($d['planned_selling_price']) ?></td>
<td><?= $plannedProfit === null ? '-' : 'KES '.number_format($plannedProfit,2) ?></td>
<td class="notes"><?= htmlspecialchars(hustleDash($d['notes'])) ?></td>
<td><?= htmlspecialchars(hustleDash($d['added_by_name'])) ?></td>
<td><?= !empty($d['date_added']) ? date('M j, Y H:i', strtotime($d['date_added'])) : '-' ?></td>
<td><?php if (($d['status'] ?? '') === 'Sold'): ?>
<strong>Sales Person:</strong> <?= htmlspecialchars(hustleDash($d['sales_person'])) ?><br>
<strong>Sold At:</strong> <?= !empty($d['sold_at']) ? date('M j, Y H:i', strtotime($d['sold_at'])) : '-' ?><br>
<strong>Selling Price:</strong> <?= hustleMoney($d['selling_price']) ?><br>
<strong>Payment:</strong> <?= htmlspecialchars(hustleDash($d['payment_status'])) ?>
<?php if ($d['selling_price'] !== null && $d['selling_price'] !== '' && $d['buying_price'] !== null && $d['buying_price'] !== ''): ?><br><strong>Actual Profit:</strong> KES <?= number_format((float)$d['selling_price']-(float)$d['buying_price'],2) ?><?php endif; ?>
<?php else: ?>-<?php endif; ?></td>
</tr>
<?php endforeach; ?>
</tbody></table></div></div></div>
<?php elseif ($_SERVER['REQUEST_METHOD']==='POST' && !$error && empty($notFoundSerials)): ?><div class="alert alert-error">No Iman's Hustle items found.</div><?php endif; ?>

<div class="footer"><i class="fas fa-copyright"></i> <?= date('Y') ?> Mombasa Computers</div>
</div>
<div class="scanner-overlay" id="scannerOverlay"><div class="scanner-box"><button class="close-btn" onclick="closeScanner()">&times;</button><h3><i class="fas fa-camera"></i> Scan Serial Number</h3><p>Scan items one after another. Each serial will be added to the list.</p><div id="reader"></div><button type="button" class="btn" onclick="closeScanner()">Done Scanning</button></div></div>
<script>
let html5QrCode=null,scannerActive=false;
function playBeep(){try{const a=new(window.AudioContext||window.webkitAudioContext)(),o=a.createOscillator(),g=a.createGain();o.connect(g);g.connect(a.destination);o.frequency.value=1200;g.gain.value=.08;o.start();o.stop(a.currentTime+.08)}catch(e){}}
function openScanner(){document.getElementById('scannerOverlay').classList.add('active');if(!html5QrCode)html5QrCode=new Html5Qrcode('reader');if(scannerActive)return;Html5Qrcode.getCameras().then(cameras=>{if(!cameras.length)return;const camera=cameras.find(c=>/back|rear|environment/i.test(c.label))||cameras[cameras.length-1];return html5QrCode.start(camera.id,{fps:10,qrbox:{width:250,height:150}},onScanSuccess,()=>{});}).then(()=>scannerActive=true).catch(err=>alert('Unable to start camera: '+err));}
function closeScanner(){document.getElementById('scannerOverlay').classList.remove('active');if(html5QrCode&&scannerActive){html5QrCode.stop().then(()=>scannerActive=false).catch(()=>scannerActive=false);}}
function onScanSuccess(decodedText){decodedText=decodedText.trim();if(!decodedText)return;const textarea=document.getElementById('serialInput');const existing=textarea.value.split(/[\s,]+/).map(v=>v.trim()).filter(Boolean);if(!existing.includes(decodedText)){textarea.value+=(textarea.value.trim()?'\n':'')+decodedText;playBeep();}}
window.addEventListener('beforeunload',()=>{if(html5QrCode&&scannerActive)html5QrCode.stop().catch(()=>{});});
</script>
</body></html>
