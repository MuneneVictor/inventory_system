<?php
session_start();
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../includes/auth_check.php';
require_once __DIR__ . '/../includes/owner_inventory_access.php';

$access = requireOwnerInventoryAccess($conn);
$user_id = (int)$access['user_id'];

$error = '';
$foundItems = [];
$notFoundSerials = [];
$input = '';

function imanDash($value): string {
    $value = trim((string)($value ?? ''));
    return $value === '' ? '-' : $value;
}

function imanMoney($value): string {
    return ($value === null || $value === '') ? '-' : 'KES ' . number_format((float)$value, 2);
}

function imanUsd($value): string {
    return ($value === null || $value === '') ? '-' : '$' . number_format((float)$value, 2);
}

function imanProfit(array $item) {
    if (($item['selling_price'] ?? null) !== null && ($item['buying_price'] ?? null) !== null) {
        return (float)$item['selling_price'] - (float)$item['buying_price'];
    }
    if (($item['planned_selling_price'] ?? null) !== null && ($item['buying_price'] ?? null) !== null) {
        return (float)$item['planned_selling_price'] - (float)$item['buying_price'];
    }
    return null;
}

function imanSpecs(array $item): string {
    $parts = [];
    foreach (['manufacturer','model_name','processor','ram','storage'] as $key) {
        $v = trim((string)($item[$key] ?? ''));
        if ($v !== '') $parts[] = $v;
    }
    $touch = trim((string)($item['touch_screen'] ?? ''));
    if ($touch !== '' && strtoupper($touch) !== 'N/A') $parts[] = $touch;
    $webcam = trim((string)($item['webcam'] ?? ''));
    if ($webcam !== '') $parts[] = 'Webcam: ' . $webcam;
    return $parts ? implode(' | ', $parts) : '-';
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
            $sql = "SELECT i.*, u.full_name AS added_by_name
                    FROM iman_inventory_items i
                    LEFT JOIN users u ON i.added_by = u.id
                    WHERE i.serial_number IN ($placeholders)";
            $stmt = $conn->prepare($sql);
            $stmt->execute($serials);
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $bySerial = [];
            foreach ($rows as $row) $bySerial[(string)$row['serial_number']] = $row;
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
<title>Bulk Search | Iman Inventory</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>
<style>
:root{--primary:#1a4b2a;--primary-light:#2a6b3a;--gold:#d7b729;--gray-50:#f9fafb;--gray-100:#f3f4f6;--gray-200:#e5e7eb;--gray-300:#d1d5db;--gray-400:#9ca3af;--gray-500:#6b7280;--gray-600:#4b5563;--gray-700:#374151;--gray-800:#1f2937;--shadow-sm:0 1px 2px 0 rgb(0 0 0/.05);--radius-md:.5rem;--radius-xl:1rem}
*{margin:0;padding:0;box-sizing:border-box}body{font-family:Inter,system-ui,-apple-system,"Segoe UI",sans-serif;background:var(--gray-100);color:var(--gray-800);line-height:1.5;overflow-x:hidden}.main-content{padding:2rem;margin-left:260px;width:calc(100% - 260px);min-height:100vh}.page-header,.card{background:#fff;border:1px solid var(--gray-200);border-radius:var(--radius-xl);box-shadow:var(--shadow-sm)}.page-header{padding:1.5rem 2rem;margin-bottom:1.5rem}.page-header h1{font-size:1.65rem;margin-bottom:.45rem}.page-header h1 i{color:var(--primary)}.breadcrumb{color:var(--gray-500);font-size:.86rem}.breadcrumb a{color:var(--primary);text-decoration:none}.card{overflow:hidden;margin-bottom:1.5rem}.card-header{background:var(--gray-50);padding:1rem 1.5rem;border-bottom:1px solid var(--gray-200);font-weight:700}.card-body{padding:1.5rem}.form-group{margin-bottom:1.25rem}.form-group label{display:block;font-size:.875rem;font-weight:650;margin-bottom:.5rem}textarea{width:100%;padding:.75rem;border:1px solid var(--gray-300);border-radius:var(--radius-md);font:inherit;resize:vertical}.btn{padding:.75rem 1rem;background:var(--primary);color:#fff;border:0;border-radius:var(--radius-md);cursor:pointer;display:inline-flex;align-items:center;justify-content:center;gap:.5rem;text-decoration:none;font-weight:650}.search-btn{width:100%}.btn:hover{background:var(--primary-light)}.scan-row{display:flex;gap:.75rem;align-items:center;flex-wrap:wrap;margin-bottom:1rem}.scan-btn{background:#2563eb}.alert{padding:1rem;border-radius:var(--radius-md);margin-bottom:1rem}.alert-error{background:#fef2f2;border:1px solid #fecaca;color:#991b1b}.summary{display:flex;gap:.75rem;flex-wrap:wrap;margin-bottom:1rem}.summary span{background:var(--gray-50);border:1px solid var(--gray-200);padding:.5rem .75rem;border-radius:8px;font-size:.82rem}.table-responsive{overflow:auto}table{width:100%;min-width:1900px;border-collapse:collapse;font-size:.78rem}th,td{padding:.7rem .75rem;text-align:left;border-bottom:1px solid var(--gray-200);vertical-align:top;white-space:nowrap}th{background:var(--gold);color:#171717;font-weight:800;position:sticky;top:0}.specs{white-space:normal;min-width:340px;max-width:440px;color:var(--gray-600)}.notes{white-space:pre-line;min-width:180px;max-width:280px}.status{display:inline-block;padding:.22rem .55rem;border-radius:999px;font-size:.7rem;font-weight:750}.status-in{background:#d1fae5;color:#065f46}.status-sold{background:#fee2e2;color:#991b1b}.money{font-family:ui-monospace,SFMono-Regular,Menlo,monospace}.scanner-overlay{display:none;position:fixed;inset:0;background:#000d;z-index:9999;justify-content:center;align-items:center}.scanner-overlay.active{display:flex}.scanner-box{background:#fff;border-radius:14px;padding:1.5rem;max-width:500px;width:95%;text-align:center;position:relative}.close-btn{position:absolute;right:15px;top:10px;border:0;background:none;font-size:1.8rem;cursor:pointer}#reader{width:100%;min-height:300px;margin:1rem 0}.footer{text-align:center;color:var(--gray-400);font-size:.84rem;padding:1rem}
@media(min-width:1025px){.scan-btn{display:none}}@media(max-width:1200px){.main-content{margin-left:0;width:100%;padding:5rem 1rem 1rem}}@media(max-width:700px){.page-header,.card-body{padding:1rem}.page-header h1{font-size:1.25rem}}
</style>
</head>
<body>
<?php include __DIR__ . '/../includes/sidebar.php'; ?>
<div class="main-content">
<div class="page-header">
<h1><i class="fas fa-magnifying-glass"></i> Iman Inventory — Bulk Search</h1>
<div class="breadcrumb"><a href="../dashboard/superadmindashboard.php"><i class="fas fa-home"></i> Dashboard</a> / <a href="overview.php">Iman Inventory</a> / Bulk Search</div>
</div>

<?php if ($error): ?><div class="alert alert-error"><i class="fas fa-exclamation-circle"></i> <?=htmlspecialchars($error)?></div><?php endif; ?>

<div class="card"><div class="card-header"><i class="fas fa-search"></i> Search Multiple Iman Inventory Items</div><div class="card-body">
<form method="POST">
<div class="form-group"><label>Serial Numbers (one per line, space separated, or comma separated)</label>
<div class="scan-row"><button type="button" class="btn scan-btn" onclick="openScanner()"><i class="fas fa-camera"></i> Scan Serial Number</button><span style="font-size:.8rem;color:var(--gray-500)">Scan multiple items one after another</span></div>
<textarea name="serial_number" id="serialInput" rows="6" placeholder="Example:&#10;5CG0302X7Y&#10;5CG09OZXE33&#10;5CG7TYTUGJ10" required autofocus><?=htmlspecialchars($input)?></textarea></div>
<button type="submit" name="search_serial" class="btn search-btn"><i class="fas fa-search"></i> Search Item(s)</button>
</form></div></div>

<?php if ($notFoundSerials): ?><div class="alert alert-error"><strong>Not Found (<?=count($notFoundSerials)?>):</strong> <?=htmlspecialchars(implode(', ', $notFoundSerials))?></div><?php endif; ?>

<?php if ($foundItems): ?>
<div class="card"><div class="card-header"><i class="fas fa-list"></i> Search Results</div><div class="card-body">
<div class="summary"><span><strong>Found:</strong> <?=count($foundItems)?></span><span><strong>Not Found:</strong> <?=count($notFoundSerials)?></span><span><strong>Total Searched:</strong> <?=count($foundItems)+count($notFoundSerials)?></span></div>
<div class="table-responsive"><table><thead><tr>
<th>#</th><th>Serial #</th><th>Asset ID</th><th>Type</th><th>Specifications</th><th>Grade</th><th>Location</th><th>Status</th><th>Buying $</th><th>Selling $</th><th>BP</th><th>Planned SP</th><th>Profit</th><th>Notes</th><th>Added By</th><th>Date Added</th><th>Sale Details</th>
</tr></thead><tbody>
<?php foreach ($foundItems as $i=>$d): $profit=imanProfit($d); ?>
<tr>
<td><?=$i+1?></td>
<td><code><?=htmlspecialchars(imanDash($d['serial_number']??''))?></code></td>
<td><?=htmlspecialchars(imanDash($d['asset_id']??''))?></td>
<td><?=htmlspecialchars(imanDash($d['item_type']??''))?></td>
<td class="specs"><?=htmlspecialchars(imanSpecs($d))?></td>
<td><?=htmlspecialchars(imanDash($d['grade']??''))?></td>
<td><?=htmlspecialchars(imanDash($d['location']??''))?></td>
<td><span class="status <?=($d['status']??'')==='In Stock'?'status-in':'status-sold'?>"><?=htmlspecialchars(imanDash($d['status']??''))?></span></td>
<td class="money"><?=htmlspecialchars(imanUsd($d['buying_usd']??null))?></td>
<td class="money"><?=htmlspecialchars(imanUsd($d['selling_usd']??null))?></td>
<td class="money"><?=htmlspecialchars(imanMoney($d['buying_price']??null))?></td>
<td class="money"><?=htmlspecialchars(imanMoney($d['planned_selling_price']??null))?></td>
<td class="money"><?=$profit===null?'-':'KES '.number_format($profit,2)?></td>
<td class="notes"><?=htmlspecialchars(imanDash($d['notes']??''))?></td>
<td><?=htmlspecialchars(imanDash($d['added_by_name']??''))?></td>
<td><?=!empty($d['date_added'])?date('M j, Y H:i',strtotime($d['date_added'])):'-'?></td>
<td><?php if (($d['status']??'')==='Sold'): ?>
<strong><?=htmlspecialchars(imanDash($d['sales_person']??''))?></strong><br>
<?=!empty($d['sold_at'])?date('M j, Y H:i',strtotime($d['sold_at'])):'-'?><br>
Actual SP: <strong><?=htmlspecialchars(imanMoney($d['selling_price']??null))?></strong><br>
Payment: <?=htmlspecialchars(ucfirst(imanDash($d['payment_status']??'')))?>
<?php else: ?>-<?php endif; ?></td>
</tr>
<?php endforeach; ?>
</tbody></table></div></div></div>
<?php elseif ($_SERVER['REQUEST_METHOD']==='POST' && !$error && !$notFoundSerials): ?><div class="alert alert-error">No Iman Inventory items found.</div><?php endif; ?>

<div class="footer"><i class="fas fa-copyright"></i> <?=date('Y')?> Mombasa Computers</div>
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
