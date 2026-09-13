<?php
session_start();
require_once "../config/db.php";
require_once "../includes/auth_check.php";
require_once "return_helpers.php";

$role = $_SESSION['role'] ?? '';
$userId = (int)($_SESSION['user_id'] ?? 0);
if (!in_array($role, returnsAllowedRoles(), true)) die("Access denied!");
$categories = returnCategories();
if (empty($_SESSION['returns_csrf'])) $_SESSION['returns_csrf'] = bin2hex(random_bytes(32));
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!hash_equals($_SESSION['returns_csrf'], (string)($_POST['csrf_token'] ?? ''))) {
        $error = 'Your session token is invalid. Refresh the page and try again.';
    } else {
        $category = trim((string)($_POST['category'] ?? ''));
        $identifier = trim((string)($_POST['item_identifier'] ?? ''));
        $saleItemId = (int)($_POST['sale_item_id'] ?? 0);
        $quantity = max(1,(int)($_POST['quantity'] ?? 1));
        $reason = trim((string)($_POST['return_reason'] ?? ''));
        $returnCondition = trim((string)($_POST['return_condition'] ?? 'Unknown'));
        $stockAction = trim((string)($_POST['stock_action'] ?? 'restock'));
        $refundRaw = trim((string)($_POST['refund_amount'] ?? ''));
        $notes = trim((string)($_POST['notes'] ?? ''));
        $replacementIdentifier = trim((string)($_POST['replacement_identifier'] ?? ''));
        $cfg = getReturnCategory($category);
        if ($cfg && !empty($cfg['serialized'])) $stockAction = 'restock';

        if (!$cfg || $identifier==='' || $reason==='') {
            $error = 'Category, item and return reason are required.';
        } elseif (!in_array($returnCondition,['Good','Faulty','Damaged','Unknown'],true)) {
            $error = 'Invalid return condition.';
        } elseif (!in_array($stockAction,['restock','hold'],true)) {
            $error = 'Invalid inventory action.';
        } elseif ($refundRaw!=='' && (!is_numeric($refundRaw) || (float)$refundRaw<0)) {
            $error = 'Refund amount must be zero or a positive number.';
        } else {
            try {
                $conn->beginTransaction();
                $saleId=null; $clientName=null; $clientPhone=null; $description=null; $unitPrice=null; $branch=null;
                $originalSellingPrice=null; $replacementDescription=null; $replacementPrice=null;

                if ($cfg['serialized']) {
                    $table=$cfg['table']; $idCol=$cfg['id_col']; $statusCol=$cfg['status_col']; $soldValue=$cfg['sold_value'];
                    $descExpr=serializedDescriptionExpression($category); $priceExpr=serializedSalePriceExpression($category);
                    $itemStmt=$conn->prepare("SELECT t.`{$idCol}` item_identifier, {$descExpr} description, {$priceExpr} fallback_price, t.branch source_branch FROM `{$table}` t WHERE t.`{$idCol}`=:id AND t.`{$statusCol}`=:sold_status LIMIT 1 FOR UPDATE");
                    $itemStmt->execute(['id'=>$identifier,'sold_status'=>$soldValue]);
                    $item=$itemStmt->fetch(PDO::FETCH_ASSOC);
                    if (!$item) throw new RuntimeException('This item is no longer marked as sold and cannot be returned from this screen.');
                    $originalSellingPrice = $item['fallback_price'] !== null ? (float)$item['fallback_price'] : null;

                    $dup=$conn->prepare("SELECT 1 FROM `returns` WHERE category=:category AND item_identifier=:identifier AND return_status='Completed' LIMIT 1");
                    $dup->execute(['category'=>$category,'identifier'=>$identifier]);
                    if ($dup->fetchColumn()) throw new RuntimeException('This serial number has already been returned.');

                    $saleStmt=$conn->prepare("SELECT si.id,si.sale_id,si.unit_price,si.description,s.client_name,s.client_phone FROM sale_items si INNER JOIN sales s ON s.id=si.sale_id WHERE si.item_type=:sale_type AND si.item_id=:item_id AND s.sale_status='completed' ORDER BY si.id DESC LIMIT 1");
                    $saleStmt->execute(['sale_type'=>$cfg['sale_type'],'item_id'=>$identifier]);
                    $saleRow=$saleStmt->fetch(PDO::FETCH_ASSOC);
                    if ($saleRow) {
                        $saleItemId=(int)$saleRow['id']; $saleId=(int)$saleRow['sale_id']; $unitPrice=$saleRow['unit_price'];
                        $clientName=$saleRow['client_name']; $clientPhone=$saleRow['client_phone'];
                        $description=$saleRow['description'] ?: $item['description'];
                    } else {
                        $saleItemId=0; $unitPrice=$item['fallback_price']; $description=$item['description'];
                    }
                    $branch=$item['source_branch'] ?: userBranch($conn,$userId);
                    $quantity=1;
                } else {
                    if ($saleItemId<=0) throw new RuntimeException('Select the actual sold item from the search results.');
                    $saleStmt=$conn->prepare("SELECT si.id,si.sale_id,si.item_type,si.item_id,si.description,si.quantity,si.unit_price,s.client_name,s.client_phone FROM sale_items si INNER JOIN sales s ON s.id=si.sale_id WHERE si.id=:sale_item_id AND si.item_type=:sale_type AND s.sale_status='completed' LIMIT 1 FOR UPDATE");
                    $saleStmt->execute(['sale_item_id'=>$saleItemId,'sale_type'=>$cfg['sale_type']]);
                    $saleRow=$saleStmt->fetch(PDO::FETCH_ASSOC);
                    if (!$saleRow || (string)$saleRow['item_id']!==$identifier) throw new RuntimeException('The selected sold item could not be verified.');

                    if ($category==='ram' || $category==='ssd') {
                        $expected=$category==='ram'?'RAM':'SSD';
                        $masterCheck=$conn->prepare("SELECT branch FROM rams_ssds WHERE id=:id AND category=:category LIMIT 1");
                        $masterCheck->execute(['id'=>(int)$identifier,'category'=>$expected]);
                    } else {
                        $masterTable=$cfg['table'];
                        $masterCheck=$conn->prepare("SELECT branch FROM `{$masterTable}` WHERE id=:id LIMIT 1");
                        $masterCheck->execute(['id'=>(int)$identifier]);
                    }
                    $master=$masterCheck->fetch(PDO::FETCH_ASSOC);
                    if (!$master) throw new RuntimeException('The original inventory item no longer exists.');

                    $returnedStmt=$conn->prepare("SELECT COALESCE(SUM(quantity),0) FROM `returns` WHERE sale_item_id=:sale_item_id AND return_status='Completed'");
                    $returnedStmt->execute(['sale_item_id'=>$saleItemId]);
                    $remaining=(int)$saleRow['quantity']-(int)$returnedStmt->fetchColumn();
                    if ($remaining<=0) throw new RuntimeException('The full quantity from this sale has already been returned.');
                    if ($quantity>$remaining) throw new RuntimeException("Only {$remaining} unit(s) remain returnable from this sale.");

                    $saleId=(int)$saleRow['sale_id']; $clientName=$saleRow['client_name']; $clientPhone=$saleRow['client_phone'];
                    $description=$saleRow['description']; $unitPrice=$saleRow['unit_price']; $branch=$master['branch'] ?: userBranch($conn,$userId);
                }

                // Replacement is optional and only applies to serialized categories.
                // The returned item always goes back to stock. The replacement must currently be in stock
                // and inherits the returned item's actual selling price.
                if ($replacementIdentifier !== '') {
                    if (empty($cfg['serialized'])) throw new RuntimeException('Replacement is only available for serialized items.');
                    if ($replacementIdentifier === $identifier) throw new RuntimeException('The replacement serial number must be different from the returned serial number.');
                    $replacementPrice = $originalSellingPrice ?? ($unitPrice !== null ? (float)$unitPrice : null);
                    if ($replacementPrice === null) throw new RuntimeException('The returned item has no selling price, so a replacement price cannot be assigned automatically.');
                }

                $returnNo=returnNumber($conn);
                // Serialized returns always restore the returned serial to available stock and clear its selling price.
                // Quantity-based items retain the existing Restock/Hold choice.
                if ($cfg['serialized']) {
                    restockSerialized($conn,$category,$identifier);
                } elseif ($stockAction==='restock') {
                    restockQuantityItem($conn,$category,(int)$identifier,$quantity);
                }

                if ($replacementIdentifier !== '') {
                    $replacement = sellReplacementSerialized($conn,$category,$replacementIdentifier,(float)$replacementPrice,$userId);
                    $replacementDescription = $replacement['description'] ?? $replacementIdentifier;

                    // Keep the completed sale line aligned with the item the client leaves with.
                    if ($saleItemId > 0) {
                        $replaceSaleItem=$conn->prepare("UPDATE sale_items SET item_id=:replacement_id, description=:replacement_description WHERE id=:sale_item_id");
                        $replaceSaleItem->execute([
                            'replacement_id'=>$replacementIdentifier,
                            'replacement_description'=>$replacementDescription,
                            'sale_item_id'=>$saleItemId
                        ]);
                    }
                }

                $insert=$conn->prepare("INSERT INTO `returns` (return_number,category,item_identifier,sale_id,sale_item_id,client_name,client_phone,description,quantity,unit_price,refund_amount,return_reason,return_condition,stock_action,return_status,branch,returned_by,notes,replacement_identifier,replacement_description,replacement_price) VALUES (:return_number,:category,:item_identifier,:sale_id,:sale_item_id,:client_name,:client_phone,:description,:quantity,:unit_price,:refund_amount,:return_reason,:return_condition,:stock_action,'Completed',:branch,:returned_by,:notes,:replacement_identifier,:replacement_description,:replacement_price)");
                $insert->execute([
                    'return_number'=>$returnNo,'category'=>$category,'item_identifier'=>$identifier,'sale_id'=>$saleId,'sale_item_id'=>$saleItemId>0?$saleItemId:null,
                    'client_name'=>$clientName,'client_phone'=>$clientPhone,'description'=>$description,'quantity'=>$quantity,'unit_price'=>$unitPrice,
                    'refund_amount'=>$refundRaw===''?null:(float)$refundRaw,'return_reason'=>$reason,'return_condition'=>$returnCondition,'stock_action'=>$stockAction,
                    'branch'=>$branch,'returned_by'=>$userId,'notes'=>$notes!==''?$notes:null,
                    'replacement_identifier'=>$replacementIdentifier!==''?$replacementIdentifier:null,
                    'replacement_description'=>$replacementDescription,
                    'replacement_price'=>$replacementPrice
                ]);
                $returnId=(int)$conn->lastInsertId();

                $log=$conn->prepare("INSERT INTO activity_logs (user_id,action,details) VALUES (:uid,'Client Return',:details)");
                $log->execute(['uid'=>$userId,'details'=>"Recorded {$returnNo}: ".returnCategoryLabel($category)." returned {$identifier}, qty {$quantity}".($replacementIdentifier!==''?"; replaced with {$replacementIdentifier} at KES ".number_format((float)$replacementPrice,2):'').", action {$stockAction}"]);
                $conn->commit();
                header("Location: view?id={$returnId}&created=1"); exit;
            } catch (Throwable $e) {
                if ($conn->inTransaction()) $conn->rollBack();
                $error=$e->getMessage();
            }
        }
    }
}

function dashboardHref(string $role): string {
    if ($role==='super_admin') return '../dashboard/superadmindashboard';
    if ($role==='manager') return '../dashboard/managerdashboard';
    return '../dashboard/inventorydashboard';
}
?>
<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1.0,viewport-fit=cover"><title>Record Return | Mombasa Computers</title><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"><style>
@import url('https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,400;14..32,500;14..32,600;14..32,700&display=swap');
:root{--primary:#1a4b2a;--primary-light:#2a6b3a;--gray-50:#f9fafb;--gray-100:#f3f4f6;--gray-200:#e5e7eb;--gray-300:#d1d5db;--gray-500:#6b7280;--gray-600:#4b5563;--gray-700:#374151;--gray-800:#1f2937;--radius-md:.5rem;--radius-lg:.75rem;--radius-xl:1rem;--shadow-sm:0 1px 2px rgb(0 0 0/.05);--font:'Inter',system-ui,sans-serif}*{box-sizing:border-box;margin:0;padding:0}body{font-family:var(--font);background:var(--gray-100);color:var(--gray-800)}.main-content{margin-left:260px;width:calc(100% - 260px);min-height:100vh;padding:2rem}.page-header,.card{background:#fff;border:1px solid var(--gray-200);border-radius:var(--radius-xl);box-shadow:var(--shadow-sm)}.page-header{padding:1.5rem 2rem;margin-bottom:1.5rem}.page-header h1{font-size:1.75rem;margin-bottom:.5rem;display:flex;gap:.75rem;align-items:center}.page-header h1 i{color:var(--primary)}.breadcrumb{font-size:.9rem;color:var(--gray-500)}.breadcrumb a{color:var(--primary);text-decoration:none}.card{padding:1.5rem;margin-bottom:1.5rem}.section-title{font-size:1rem;font-weight:600;margin-bottom:1rem;color:var(--gray-700);display:flex;gap:.5rem}.grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(210px,1fr));gap:1rem}.field{display:flex;flex-direction:column;gap:.4rem}.field label{font-size:.82rem;font-weight:600;color:var(--gray-600)}input,select,textarea{width:100%;padding:.7rem .85rem;border:1px solid var(--gray-300);border-radius:var(--radius-md);font-family:var(--font);background:#fff}textarea{min-height:95px}.btn{border:0;border-radius:var(--radius-md);padding:.7rem 1.1rem;font-weight:600;cursor:pointer;text-decoration:none;display:inline-flex;gap:.5rem;align-items:center;justify-content:center}.btn-primary{background:var(--primary);color:#fff}.btn-secondary{background:var(--gray-100);color:var(--gray-700);border:1px solid var(--gray-300)}.alert{padding:.9rem 1rem;border-radius:var(--radius-md);margin-bottom:1rem}.alert-error{background:#fef2f2;color:#991b1b;border:1px solid #fecaca}.search-row{display:flex;gap:.75rem;align-items:end}.search-row .field{flex:1}.results{margin-top:1rem;border:1px solid var(--gray-200);border-radius:var(--radius-lg);overflow:hidden}.result{display:grid;grid-template-columns:42px 1.5fr 1fr 1fr;gap:.75rem;padding:.9rem 1rem;border-bottom:1px solid var(--gray-200);align-items:center}.result:last-child{border-bottom:0}.result:hover{background:var(--gray-50)}.result-main{font-weight:600}.muted{font-size:.8rem;color:var(--gray-500);margin-top:.2rem}.pill{display:inline-block;padding:.2rem .55rem;border-radius:999px;background:var(--gray-100);font-size:.75rem}#returnDetails{display:none}.actions{display:flex;gap:.75rem;justify-content:flex-end;margin-top:1.25rem}.empty{padding:1.25rem;text-align:center;color:var(--gray-500)}.note{font-size:.82rem;color:var(--gray-500);margin-top:.35rem}@media(max-width:1200px){.main-content{margin-left:0!important;width:100%!important;padding:5rem 1rem 1rem!important}}@media(max-width:700px){.result{grid-template-columns:35px 1fr}.result>*:nth-child(n+3){grid-column:2}.search-row{flex-direction:column;align-items:stretch}.actions{flex-direction:column}.btn{width:100%}}
</style></head><body><?php include "../includes/sidebar.php"; ?><div class="main-content"><div class="page-header"><h1><i class="fas fa-rotate-left"></i> Client Returns</h1><div class="breadcrumb"><a href="<?= htmlspecialchars(dashboardHref($role)) ?>"><i class="fas fa-home"></i> Dashboard</a> / <a href="./">Returns</a> / Record Return</div></div>
<?php if($error): ?><div class="alert alert-error"><i class="fas fa-circle-exclamation"></i> <?= htmlspecialchars($error) ?></div><?php endif; ?>
<div class="card"><div class="section-title"><i class="fas fa-layer-group"></i> 1. Select Category and Sold Item</div><div class="grid"><div class="field"><label>Category</label><select id="category"><option value="">-- Select Category --</option><?php foreach($categories as $key=>$c): ?><option value="<?= htmlspecialchars($key) ?>"><?= htmlspecialchars($c['label']) ?></option><?php endforeach; ?></select></div></div><div class="search-row" style="margin-top:1rem"><div class="field"><label id="searchLabel">Search Sold Item</label><input id="searchQuery" type="text" placeholder="Select a category first..." disabled><div class="note" id="searchHint">Serialized categories search sold serial numbers. Quantity categories use the completed Sale Item ID.</div></div><button type="button" class="btn btn-primary" id="searchBtn" disabled><i class="fas fa-search"></i> Search</button></div><div id="searchResults" class="results" style="display:none"></div></div>
<form method="POST"><input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['returns_csrf']) ?>"><input type="hidden" name="category" id="formCategory"><input type="hidden" name="item_identifier" id="itemIdentifier"><input type="hidden" name="sale_item_id" id="saleItemId"><input type="hidden" name="replacement_identifier" id="replacementIdentifier"><div class="card" id="returnDetails"><div class="section-title"><i class="fas fa-clipboard-check"></i> 2. Return Details</div><div id="selectedSummary" style="margin-bottom:1rem"></div><div class="grid"><div class="field"><label>Quantity Returned</label><input type="number" name="quantity" id="quantity" min="1" value="1" required><div class="note" id="quantityHint"></div></div><div class="field"><label>Condition on Return</label><select name="return_condition"><option>Unknown</option><option>Good</option><option>Faulty</option><option>Damaged</option></select></div><div class="field"><label>Inventory Action</label><select name="stock_action" id="stockAction"><option value="restock">Return to inventory stock</option><option value="hold">Hold for inspection - do not change stock</option></select><div class="note">Use Hold if the item should not immediately become sellable.</div></div><div class="field"><label>Refund Amount (KES) - optional</label><input type="number" name="refund_amount" min="0" step="0.01"></div><div class="field"><label>Return Reason</label><input type="text" name="return_reason" maxlength="255" required></div></div><div id="replacementBox" style="display:none;margin-top:1.25rem;padding-top:1.25rem;border-top:1px solid var(--gray-200)"><div class="section-title"><i class="fas fa-right-left"></i> Optional Replacement</div><div class="note" style="margin-bottom:.75rem">If the client is taking another unit, enter an in-stock serial number from the same category. The replacement will be marked sold using the returned item's selling price.</div><div class="search-row"><div class="field"><label>Replacement Serial Number</label><input type="text" id="replacementQuery" placeholder="Enter or scan an in-stock serial number..."></div><button type="button" class="btn btn-secondary" id="replacementSearchBtn"><i class="fas fa-search"></i> Search Replacement</button></div><div id="replacementResults" class="results" style="display:none"></div><div id="replacementSelected" style="display:none;margin-top:.75rem"></div></div><div class="field" style="margin-top:1rem"><label>Notes - optional</label><textarea name="notes"></textarea></div><div class="actions"><a href="./" class="btn btn-secondary">Cancel</a><button class="btn btn-primary"><i class="fas fa-check"></i> Complete Return</button></div></div></form></div>
<script>
const categories=<?= json_encode($categories,JSON_UNESCAPED_SLASHES) ?>,cat=document.getElementById('category'),q=document.getElementById('searchQuery'),btn=document.getElementById('searchBtn'),results=document.getElementById('searchResults'),details=document.getElementById('returnDetails');
const esc=v=>String(v??'').replace(/[&<>"']/g,c=>({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#039;'}[c]));
cat.addEventListener('change',()=>{const c=categories[cat.value];details.style.display='none';results.style.display='none';resetReplacement();q.value='';q.disabled=!c;btn.disabled=!c;if(!c)return;document.getElementById('searchLabel').textContent=c.serialized?'Sold Serial Number':'Sale Item ID';q.placeholder=c.serialized?'Enter or scan serial number...':'Enter the Sale Item ID...';document.getElementById('searchHint').textContent=c.serialized?'Searches the selected inventory table and only accepts items currently marked Sold.':'Use the Sale Item ID from the completed sale. The system checks the category, sale and remaining returnable quantity.';});
btn.addEventListener('click',search);q.addEventListener('keydown',e=>{if(e.key==='Enter'){e.preventDefault();search();}});
async function search(){if(!cat.value)return;btn.disabled=true;results.style.display='block';results.innerHTML='<div class="empty"><i class="fas fa-spinner fa-spin"></i> Searching...</div>';try{const r=await fetch('search_items?category='+encodeURIComponent(cat.value)+'&q='+encodeURIComponent(q.value.trim()));const text=await r.text();let d;try{d=JSON.parse(text);}catch(_){throw new Error('Search endpoint returned an invalid response.');}if(!d.ok)throw new Error(d.message||'Search failed');if(!d.items.length){results.innerHTML='<div class="empty">No returnable sold items found.</div>';return;}results.innerHTML=d.items.map((x,i)=>`<label class="result"><input type="radio" name="choice" data-item='${esc(JSON.stringify(x))}'><div><div class="result-main">${esc(x.description||x.item_identifier)}</div><div class="muted">ID / Serial: ${esc(x.item_identifier)}</div></div><div><span class="pill">${x.serialized?'Qty: 1':'Returnable: '+esc(x.remaining_quantity)+' of '+esc(x.sold_quantity)}</span><div class="muted">${x.unit_price!==null&&x.unit_price!==''?'KES '+Number(x.unit_price).toLocaleString():'Price N/A'}</div></div><div><strong>${esc(x.client_name||'Sale/client not linked')}</strong><div class="muted">${esc(x.client_phone||'')}</div></div></label>`).join('');results.querySelectorAll('input[name="choice"]').forEach(r=>r.addEventListener('change',()=>selectItem(JSON.parse(r.dataset.item))));}catch(e){results.innerHTML='<div class="empty">'+esc(e.message)+'</div>';}finally{btn.disabled=false;}}
function selectItem(x){document.getElementById('formCategory').value=cat.value;document.getElementById('itemIdentifier').value=x.item_identifier;document.getElementById('saleItemId').value=x.sale_item_id||'';const qe=document.getElementById('quantity');if(x.serialized){qe.value=1;qe.min=1;qe.max=1;qe.readOnly=true;document.getElementById('quantityHint').textContent='Serialized items are returned one serial number at a time.';}else{qe.value=1;qe.min=1;qe.max=x.remaining_quantity;qe.readOnly=false;document.getElementById('quantityHint').textContent='Maximum returnable from this sale: '+x.remaining_quantity;}document.getElementById('selectedSummary').innerHTML='<strong>'+esc(x.description||x.item_identifier)+'</strong><div class="muted">ID / Serial: '+esc(x.item_identifier)+(x.client_name?' · Client: '+esc(x.client_name):'')+(x.source_branch?' · Branch: '+esc(x.source_branch):'')+'</div>';const stock=document.getElementById('stockAction'),box=document.getElementById('replacementBox');if(x.serialized){stock.value='restock';stock.disabled=true;box.style.display='block';}else{stock.disabled=false;box.style.display='none';}details.style.display='block';details.scrollIntoView({behavior:'smooth'});}

const replacementQuery=document.getElementById('replacementQuery'),replacementBtn=document.getElementById('replacementSearchBtn'),replacementResults=document.getElementById('replacementResults'),replacementSelected=document.getElementById('replacementSelected');
function resetReplacement(){document.getElementById('replacementIdentifier').value='';if(replacementQuery)replacementQuery.value='';if(replacementResults){replacementResults.style.display='none';replacementResults.innerHTML='';}if(replacementSelected){replacementSelected.style.display='none';replacementSelected.innerHTML='';}}
replacementBtn.addEventListener('click',searchReplacement);replacementQuery.addEventListener('keydown',e=>{if(e.key==='Enter'){e.preventDefault();searchReplacement();}});
async function searchReplacement(){const term=replacementQuery.value.trim();if(!term)return;replacementBtn.disabled=true;replacementResults.style.display='block';replacementResults.innerHTML='<div class="empty"><i class="fas fa-spinner fa-spin"></i> Searching in-stock items...</div>';try{const r=await fetch('search_replacements?category='+encodeURIComponent(cat.value)+'&q='+encodeURIComponent(term)+'&exclude='+encodeURIComponent(document.getElementById('itemIdentifier').value));const text=await r.text();let d;try{d=JSON.parse(text);}catch(_){throw new Error('The replacement search endpoint returned an invalid response.');}if(!d.ok)throw new Error(d.message||'Replacement search failed');if(!d.items.length){replacementResults.innerHTML='<div class="empty">No matching in-stock replacement found.</div>';return;}replacementResults.innerHTML=d.items.map((x,i)=>`<label class="result"><input type="radio" name="replacement_choice" data-item='${esc(JSON.stringify(x))}'><div><div class="result-main">${esc(x.description||x.item_identifier)}</div><div class="muted">Serial: ${esc(x.item_identifier)}</div></div><div><span class="pill">In Stock</span></div><div>${esc(x.source_branch||'')}</div></label>`).join('');replacementResults.querySelectorAll('input[name="replacement_choice"]').forEach(r=>r.addEventListener('change',()=>selectReplacement(JSON.parse(r.dataset.item))));}catch(e){replacementResults.innerHTML='<div class="empty">'+esc(e.message)+'</div>';}finally{replacementBtn.disabled=false;}}
function selectReplacement(x){document.getElementById('replacementIdentifier').value=x.item_identifier;replacementSelected.style.display='block';replacementSelected.innerHTML='<strong><i class="fas fa-check-circle" style="color:var(--primary)"></i> Replacement selected: '+esc(x.item_identifier)+'</strong><div class="muted">'+esc(x.description||'')+(x.source_branch?' · '+esc(x.source_branch):'')+'</div>';}
</script></body></html>
