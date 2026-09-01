<?php
session_start();
require_once "../config/db.php";
require_once "../includes/auth_check.php";

$user_role = $_SESSION['role'];
$user_id = (int) $_SESSION['user_id'];
$user_branch = $_SESSION['branch'] ?? 'KIMATHI';

if (!in_array($user_role, ['sales', 'super_admin', 'manager', 'technician'])) {
    die("ACCESS DENIED.");
}

// Get filter inputs
$start_date = isset($_GET['start_date']) ? $_GET['start_date'] : date('Y-m-d', strtotime('-30 days'));
$end_date = isset($_GET['end_date']) ? $_GET['end_date'] : date('Y-m-d');
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$status_filter = isset($_GET['status']) ? trim($_GET['status']) : '';
$allowed_per_page = [100, 200, 300, 400, 500];
$per_page = isset($_GET['per_page']) ? (int)$_GET['per_page'] : 100;
if (!in_array($per_page, $allowed_per_page, true)) {
    $per_page = 100;
}
$page = max(1, (int)($_GET['page'] ?? 1));

function invoiceListPageUrl($pageNumber) {
    $query = $_GET;
    $query['page'] = max(1, (int)$pageNumber);
    return '?' . http_build_query($query);
}


// Build query - ONLY show invoices belonging to the logged-in user
$sql = "SELECT i.*, u.full_name AS created_by_name 
        FROM invoices i
        LEFT JOIN users u ON i.user_id = u.id
        WHERE i.user_id = ?";
$params = [$user_id];

if (!empty($search)) {
    $sql .= " AND (i.client_name LIKE ? OR i.invoice_number LIKE ?)";
    $like = "%$search%";
    $params[] = $like;
    $params[] = $like;
}

if (!empty($start_date) && !empty($end_date)) {
    $sql .= " AND i.created_at >= ? AND i.created_at <= ?";
    $params[] = $start_date . ' 00:00:00';
    $params[] = $end_date . ' 23:59:59';
}

if (!empty($status_filter)) {
    $sql .= " AND i.status = ?";
    $params[] = $status_filter;
}

// Aggregate totals for the complete filtered result without loading every row.
$statsSql = "SELECT COUNT(*) AS total_count,
                    COALESCE(SUM(filtered.grand_total), 0) AS total_amount,
                    COALESCE(SUM(filtered.amount_paid), 0) AS total_paid
             FROM (" . $sql . ") filtered";
$statsStmt = $conn->prepare($statsSql);
$statsStmt->execute($params);
$stats = $statsStmt->fetch(PDO::FETCH_ASSOC) ?: [];

$total_count = (int)($stats['total_count'] ?? 0);
$total_amount = (float)($stats['total_amount'] ?? 0);
$total_paid = (float)($stats['total_paid'] ?? 0);
$total_balance = $total_amount - $total_paid;

$total_pages = max(1, (int)ceil($total_count / $per_page));
if ($page > $total_pages) $page = $total_pages;
$offset = ($page - 1) * $per_page;

$sql .= " ORDER BY i.created_at DESC LIMIT " . (int)$per_page . " OFFSET " . (int)$offset;
$stmt = $conn->prepare($sql);
$stmt->execute($params);
$invoices = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Invoices | Mombasa Computers</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', sans-serif; background: #f3f4f6; color: #1f2937; line-height: 1.5; }
        .main-content { padding: 2rem; margin-left: 260px; min-height: 100vh; background: #f3f4f6; }
        .page-header { background: white; padding: 1.5rem 2rem; border-radius: 0.75rem; margin-bottom: 1.5rem; border: 1px solid #e5e7eb; }
        .page-header h1 { font-size: 1.75rem; font-weight: 600; display: flex; align-items: center; gap: 0.75rem; }
        .page-header h1 i { color: #1a4b2a; }
        .breadcrumb { color: #6b7280; font-size: 0.9rem; }
        .breadcrumb a { color: #1a4b2a; text-decoration: none; }
        .stats-row { display: flex; gap: 1rem; margin-bottom: 1.5rem; flex-wrap: wrap; }
        .stat-card { background: white; padding: 1rem 1.5rem; border-radius: 0.75rem; border: 1px solid #e5e7eb; box-shadow: 0 1px 2px 0 rgb(0 0 0 / 0.05); flex: 1; min-width: 150px; }
        .stat-card .stat-value { font-size: 1.75rem; font-weight: 700; color: #1a4b2a; }
        .stat-card .stat-label { font-size: 0.8rem; color: #6b7280; }
        .filter-section { background: white; padding: 1.5rem; border-radius: 0.75rem; margin-bottom: 1.5rem; border: 1px solid #e5e7eb; }
        .filter-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; align-items: flex-end; }
        .filter-group { display: flex; flex-direction: column; gap: 0.5rem; }
        .filter-group label { font-size: 0.85rem; font-weight: 500; color: #374151; }
        .filter-group input, .filter-group select { padding: 0.6rem 0.75rem; border: 1px solid #d1d5db; border-radius: 0.5rem; font-size: 0.9rem; width: 100%; }
        .filter-group input:focus, .filter-group select:focus { outline: none; border-color: #1a4b2a; box-shadow: 0 0 0 3px rgba(26,75,42,0.1); }
        .filter-actions { display: flex; gap: 0.75rem; flex-wrap: wrap; }
        .btn { padding: 0.6rem 1.2rem; background: #1a4b2a; color: white; border: none; border-radius: 0.5rem; cursor: pointer; display: inline-flex; align-items: center; gap: 0.5rem; text-decoration: none; font-size: 0.9rem; transition: all 0.2s; }
        .btn:hover { opacity: 0.9; transform: translateY(-1px); }
        .btn-secondary { background: #6b7280; }
        .btn-success { background: #16a34a; }
        .btn-sm { padding: 0.25rem 0.75rem; font-size: 0.8rem; }
        .table-wrapper { background: white; border-radius: 0.75rem; border: 1px solid #e5e7eb; overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; min-width: 850px; font-size: 0.9rem; }
        th { background: #f9fafb; padding: 0.75rem 0.5rem; text-align: left; font-weight: 600; border-bottom: 2px solid #e5e7eb; }
        td { padding: 0.75rem 0.5rem; border-bottom: 1px solid #f3f4f6; vertical-align: middle; }
        .badge { display: inline-block; padding: 0.25rem 0.75rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 500; }
        .badge-draft { background: #e5e7eb; color: #374151; }
        .badge-sent { background: #dbeafe; color: #1e40af; }
        .badge-paid { background: #dcfce7; color: #16a34a; }
        .badge-cancelled { background: #fee2e2; color: #dc2626; }
        .badge-unpaid { background: #fee2e2; color: #dc2626; }
        .badge-partial { background: #fed7aa; color: #c2410c; }
        .empty-state { text-align: center; padding: 3rem; color: #6b7280; }
        .footer { text-align: center; padding: 1.5rem 0 0.5rem; margin-top: 1.5rem; font-size: 0.85rem; color: #9ca3af; border-top: 1px solid #e5e7eb; }
        @media (max-width: 1200px) { .main-content { margin-left: 0 !important; padding: 1rem !important; padding-top: 5rem !important; } }
        @media (max-width: 768px) { 
            .filter-grid { grid-template-columns: 1fr; } 
            .btn { width: 100%; justify-content: center; } 
            .stats-row { flex-direction: column; } 
            .filter-actions { flex-direction: column; align-items: stretch; }
            table { font-size: 0.75rem; min-width: 650px; }
        }
    
        .pagination-bar { display:flex; justify-content:space-between; align-items:center; gap:1rem; flex-wrap:wrap; margin-top:1rem; }
        .pagination-info { color: var(--gray-500, #6b7280); font-size:0.85rem; }
        .pagination-controls { display:flex; align-items:center; gap:0.4rem; flex-wrap:wrap; }
        .pagination-controls a, .pagination-controls span { padding:0.45rem 0.7rem; border:1px solid var(--gray-300, #d1d5db); border-radius:var(--radius-md, 0.5rem); background:white; color:var(--gray-600, #4b5563); text-decoration:none; font-size:0.85rem; }
        .pagination-controls .active { background:var(--primary, #1a4b2a); border-color:var(--primary, #1a4b2a); color:white; }
        .pagination-controls .disabled { opacity:0.45; pointer-events:none; }
        .per-page-form { display:flex; align-items:center; gap:0.5rem; color:var(--gray-600, #4b5563); font-size:0.85rem; }
        .per-page-form select { padding:0.45rem 0.65rem; border:1px solid var(--gray-300, #d1d5db); border-radius:var(--radius-md, 0.5rem); background:white; }
    </style>
</head>
<body>
<?php include "../includes/sidebar.php"; ?>
<div class="main-content">
    <div class="page-header">
        <h1><i class="fas fa-file-invoice"></i> My Invoices</h1>
        <div class="breadcrumb">
            <?php if($user_role === 'sales'): ?>
                <a href="../dashboard/salesdashboard"">Dashboard</a>
            <?php elseif($user_role === 'super_admin'): ?>
                <a href="../dashboard/superadmindashboard"">Dashboard</a>
            <?php elseif($user_role === 'manager'): ?>
                <a href="../dashboard/managerdashboard"">Dashboard</a>
            <?php elseif($user_role === 'cashier'): ?>
                <a href="../dashboard/cashierdashboard"">Dashboard</a>
            <?php else: ?>
                <a href="../dashboard"">Dashboard</a>
            <?php endif; ?>
            <span> / </span>
            <span>Invoices</span>
        </div>
    </div>

    <div class="stats-row">
        <div class="stat-card">
            <div class="stat-value"><?= number_format($total_count) ?></div>
            <div class="stat-label">Total Invoices</div>
        </div>
        <div class="stat-card">
            <div class="stat-value">KES <?= number_format($total_amount, 0) ?></div>
            <div class="stat-label">Total Amount</div>
        </div>
        <div class="stat-card">
            <div class="stat-value">KES <?= number_format($total_paid, 0) ?></div>
            <div class="stat-label">Total Paid</div>
        </div>
        <div class="stat-card">
            <div class="stat-value">KES <?= number_format($total_balance, 0) ?></div>
            <div class="stat-label">Total Balance</div>
        </div>
    </div>

    <div class="filter-section">
        <form method="GET" class="filter-grid">
            <input type="hidden" name="per_page" value="<?= (int)$per_page ?>">
            <div class="filter-group">
                <label>Search</label>
                <input type="text" name="search" placeholder="Invoice # or client..." value="<?= htmlspecialchars($search) ?>">
            </div>
            <div class="filter-group">
                <label>Start Date</label>
                <input type="date" name="start_date" value="<?= htmlspecialchars($start_date) ?>" max="<?= date('Y-m-d') ?>">
            </div>
            <div class="filter-group">
                <label>End Date</label>
                <input type="date" name="end_date" value="<?= htmlspecialchars($end_date) ?>" max="<?= date('Y-m-d') ?>">
            </div>
            <div class="filter-group">
                <label>Status</label>
                <select name="status">
                    <option value="">All</option>
                    <option value="draft" <?= $status_filter === 'draft' ? 'selected' : '' ?>>Draft</option>
                    <option value="sent" <?= $status_filter === 'sent' ? 'selected' : '' ?>>Sent</option>
                    <option value="paid" <?= $status_filter === 'paid' ? 'selected' : '' ?>>Paid</option>
                    <option value="cancelled" <?= $status_filter === 'cancelled' ? 'selected' : '' ?>>Cancelled</option>
                </select>
            </div>
            <div class="filter-actions">
                <button type="submit" class="btn"><i class="fas fa-search"></i> Filter</button>
                <a href="invoices_list"" class="btn btn-secondary"><i class="fas fa-undo"></i> Reset</a>
                <a href="write_invoice"" class="btn btn-success"><i class="fas fa-plus"></i> New Invoice</a>
            </div>
        </form>
    </div>

    <div class="table-wrapper">
        <?php if (empty($invoices)): ?>
            <div class="empty-state">
                <i class="fas fa-file-invoice" style="font-size:2rem; display:block; margin-bottom:1rem; color:#d1d5db;"></i>
                <p>No invoices found.</p>
                <a href="write_invoice"" class="btn btn-success" style="margin-top:1rem;">Create First Invoice</a>
            </div>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>Invoice #</th>
                        <th>Client</th>
                        <th>Amount</th>
                        <th>Paid</th>
                        <th>Balance</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th style="text-align:right;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($invoices as $inv): ?>
                        <tr>
                            <td><strong><?= htmlspecialchars($inv['invoice_number']) ?></strong></td>
                            <td><?= htmlspecialchars($inv['client_name'] ?? '—') ?></td>
                            <td>KES <?= number_format($inv['grand_total'], 2) ?></td>
                            <td>KES <?= number_format($inv['amount_paid'], 2) ?></td>
                            <td>KES <?= number_format($inv['balance_due'], 2) ?></td>
                            <td>
                                <span class="badge badge-<?= $inv['payment_status'] ?>">
                                    <?= ucfirst($inv['payment_status']) ?>
                                </span>
                            </td>
                            <td><?= date('M j, Y', strtotime($inv['created_at'])) ?></td>
                            <td style="text-align:right;">
                                <a href="review_invoice??id=<?= (int)$inv['id'] ?>" class="btn btn-sm">
                                    <i class="fas fa-eye"></i> View
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>


    <?php if ($total_count > 0): ?>
    <div class="pagination-bar">
        <div class="pagination-info">
            Showing <?= number_format($offset + 1) ?>–<?= number_format(min($offset + $per_page, $total_count)) ?> of <?= number_format($total_count) ?> invoices
        </div>

        <form method="GET" class="per-page-form">
            <?php foreach ($_GET as $key => $value): ?>
                <?php if ($key !== 'page' && $key !== 'per_page' && !is_array($value)): ?>
                    <input type="hidden" name="<?= htmlspecialchars($key, ENT_QUOTES, 'UTF-8') ?>" value="<?= htmlspecialchars($value, ENT_QUOTES, 'UTF-8') ?>">
                <?php endif; ?>
            <?php endforeach; ?>
            <label>Show</label>
            <select name="per_page" onchange="this.form.submit()">
                <?php foreach ($allowed_per_page as $size): ?>
                    <option value="<?= $size ?>" <?= $per_page === $size ? 'selected' : '' ?>><?= $size ?></option>
                <?php endforeach; ?>
            </select>
        </form>

        <div class="pagination-controls">
            <?php if ($page > 1): ?>
                <a href="<?= htmlspecialchars(invoiceListPageUrl($page - 1), ENT_QUOTES, 'UTF-8') ?>">Previous</a>
            <?php else: ?>
                <span class="disabled">Previous</span>
            <?php endif; ?>

            <?php
            $paginationStart = max(1, $page - 2);
            $paginationEnd = min($total_pages, $page + 2);
            for ($p = $paginationStart; $p <= $paginationEnd; $p++):
            ?>
                <?php if ($p === $page): ?>
                    <span class="active"><?= $p ?></span>
                <?php else: ?>
                    <a href="<?= htmlspecialchars(invoiceListPageUrl($p), ENT_QUOTES, 'UTF-8') ?>"><?= $p ?></a>
                <?php endif; ?>
            <?php endfor; ?>

            <?php if ($page < $total_pages): ?>
                <a href="<?= htmlspecialchars(invoiceListPageUrl($page + 1), ENT_QUOTES, 'UTF-8') ?>">Next</a>
            <?php else: ?>
                <span class="disabled">Next</span>
            <?php endif; ?>
        </div>
    </div>
    <?php endif; ?>

    <div class="footer"><i class="fas fa-copyright"></i> <?= date('Y'); ?> Mombasa Computers</div>
</div>
</body>
</html>