<?php
require_once "../includes/auth_check.php";
// sidebar.php - Sidebar component for inventory system
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
</head>
<body>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<div class="sidebar-wrapper">
    <div class="sidebar-toggle" onclick="toggleSidebar()">
        <span>☰</span> Menu
    </div>
    <div class="sidebar-overlay" onclick="toggleSidebar()"></div> 

    <div class="sidebar">
        <div class="sidebar-header">
            <br><br>
            <h2>MOMBASA</h2>
            <h2 style="font-size:0.9rem; font-weight:normal; letter-spacing:4px;">COMPUTERS</h2>
        </div>

        <div class="sidebar-menu">
            <?php $role = $_SESSION['role']; ?>

            <!-- Dashboard -->
            <a href="/inventory_system/auth/myaccount.php" class="menu-item">
                <i class="fas fa-user"></i> My profile
            </a>

            <!-- Devices Section -->
            <?php if(in_array($role, ['super_admin','manager','inventory_admin'])): ?>
                <div class="menu-section">Devices</div>
                <a href="/inventory_system/devices/add_device.php" class="menu-item">
                    <i class="fas fa-plus"></i> Add Device
                </a>
                <a href="/inventory_system/devices/upload_excel.php" class="menu-item">
                    <i class="fas fa-file-upload"></i> Bulk Upload
                </a>
                <a href="/inventory_system/devices/device_list.php" class="menu-item">
                    <i class="fas fa-list"></i> Device List
                </a>
                <a href="/inventory_system/devices/instock.php" class="menu-item">
                    <i class="fas fa-box"></i> In Stock
                </a>
                <a href="/inventory_system/devices/sold.php" class="menu-item">
                    <i class="fas fa-money-bill-wave"></i> Sold
                </a>
                <a href="/inventory_system/devices/search.php" class="menu-item">
                    <i class="fas fa-search"></i> Search Device
                </a>
                <?php if($role === 'super_admin'): ?>
                <a href="/inventory_system/devices/price_list.php" class="menu-item">
                    <i class="fas fa-dollar-sign"></i> Price list
                </a>
                <?php endif; ?>
            <?php endif; ?>
            
            <!-- Monitors section -->
            <?php if(in_array($role, ['super_admin','manager','inventory_admin'])): ?>
                <div class="menu-section">MONITORS</div>
                <a href="/inventory_system/monitors/add_monitor.php" class="menu-item">
                    <i class="fas fa-plus"></i> Add Monitor
                </a>
                <a href="/inventory_system/monitors/bulkupload.php" class="menu-item">
                    <i class="fas fa-file-upload"></i> Bulk upload
                </a>
                <a href="/inventory_system/monitors/monitors_instock.php" class="menu-item">
                    <i class="fas fa-box"></i> View stock
                </a>
                <a href="/inventory_system/monitors/sold_monitors.php" class="menu-item">
                    <i class="fas fa-money-bill-wave"></i> Sold
                </a> 
            <?php endif; ?>
            
            <!-- Printers Section -->
            <?php if(in_array($role, ['super_admin','manager','inventory_admin'])): ?>
                <div class="menu-section">PRINTERS</div>
                <a href="/inventory_system/printers/add_printer.php" class="menu-item">
                    <i class="fas fa-plus"></i> Add Printer
                </a>
                <a href="/inventory_system/printers/bulkupload.php" class="menu-item">
                    <i class="fas fa-file-upload"></i> Bulk upload
                </a>
                <a href="/inventory_system/printers/printers_instock.php" class="menu-item">
                    <i class="fas fa-box"></i> View stock
                </a>
                <a href="/inventory_system/printers/soldprinters.php" class="menu-item">
                    <i class="fas fa-money-bill-wave"></i> Sold
                </a>
            <?php endif; ?>
            
            <!-- RAMs & SSDs Section -->
            <?php if(in_array($role, ['super_admin','manager','inventory_admin'])): ?>
                <div class="menu-section">RAMs & SSDs</div>
                <a href="/inventory_system/ram_ssd/add_ram.php" class="menu-item">
                    <i class="fas fa-plus"></i> Add RAM/SSD
                </a>
                <a href="/inventory_system/ram_ssd/rams_instocks.php" class="menu-item">
                    <i class="fas fa-box"></i> View Stock
                </a>
                <a href="/inventory_system/ram_ssd/give_ram.php" class="menu-item">
                    <i class="fas fa-gift"></i> Give RAM/SSD
                </a>
                <a href="/inventory_system/ram_ssd/rams_ssds_logs.php" class="menu-item">
                    <i class="fas fa-clipboard-list"></i> RAM/SSD Logs
                </a>
            <?php endif; ?>
            
            <!-- HDDs Section -->
            <?php if(in_array($role,['super_admin','inventory_admin','manager'])): ?>
                <div class="menu-section">HDDs</div>
                <a href="/inventory_system/hdds/add_hdd.php" class="menu-item">
                    <i class="fas fa-plus"></i> Add HDD
                </a>
                <a href="/inventory_system/hdds/hdds_stock.php" class="menu-item">
                    <i class="fas fa-box"></i> View Stock
                </a>
                <a href="/inventory_system/hdds/givehdd.php" class="menu-item">
                    <i class="fas fa-gift"></i> Give Out HDD
                </a>
                <a href="/inventory_system/hdds/hdds_logs.php" class="menu-item">
                    <i class="fas fa-clipboard-list"></i> HDDs Logs
                </a>
            <?php endif; ?>
            
            <!-- Chargers Section -->
            <?php if(in_array($role, ['super_admin','manager','inventory_admin','software'])): ?>
                <div class="menu-section">Chargers</div>
              
                <?php if(in_array($role, ['super_admin','manager','inventory_admin'])): ?>
                <a href="/inventory_system/chargers/add_charger.php" class="menu-item">
                    <i class="fas fa-plus"></i> Add Charger
                </a>
                    <a href="/inventory_system/chargers/chargers_instocks.php" class="menu-item">
                        <i class="fas fa-box"></i> Chargers In Stock
                    </a>
                <?php endif; ?>
                <?php if(in_array($role, ['inventory_admin','software'])): ?>
                    <a href="/inventory_system/chargers/give_charger.php" class="menu-item">
                        <i class="fas fa-gift"></i> Give Out Charger
                    </a>
                <?php endif; ?>
                <a href="/inventory_system/chargers/charger_logs.php" class="menu-item">
                    <i class="fas fa-clipboard-list"></i> Charger Logs
                </a>
            <?php endif; ?>
            
            <!-- Software Admin Section -->
            <?php if(in_array($role, ['super_admin','manager','inventory_admin','software'])): ?>
                <div class="menu-section">Software Dep</div>
                <?php if($role === 'software'): ?>
                    <a href="/inventory_system/software/search_device.php" class="menu-item">
                        <i class="fas fa-search"></i> Search Device
                    </a>
                <?php endif; ?>
                <?php if(in_array($role, ['software','inventory_admin'])): ?>
                    <a href="/inventory_system/software/update_specs.php" class="menu-item">
                        <i class="fas fa-cog"></i> Upgrade/Downgrade
                    </a>
                <?php endif; ?>
                <?php if(in_array($role, ['super_admin','manager','inventory_admin','software'])): ?>
                    <a href="/inventory_system/software/software_logs.php" class="menu-item">
                        <i class="fas fa-clipboard-list"></i> Software Logs
                    </a>
                <?php endif; ?>
            <?php endif; ?>
            
            <!-- Repairs Section -->
            <?php if(in_array($role, ['super_admin','manager','technician','inventory_admin'])): ?>
                <div class="menu-section">Repairs</div>
                <?php if($role === 'technician'): ?>
                    <a href="/inventory_system/repairs/search_device.php" class="menu-item">
                        <i class="fas fa-search"></i> Search Device
                    </a>
                    <a href="/inventory_system/repairs/add_repair.php" class="menu-item">
                        <i class="fas fa-plus"></i> Add Repair
                    </a>
                <?php endif; ?>
                <a href="/inventory_system/repairs/under_repair.php" class="menu-item">
                    <i class="fas fa-tools"></i> Under Repair
                </a>
                <a href="/inventory_system/repairs/repair_logs.php" class="menu-item">
                    <i class="fas fa-clipboard-list"></i> Repair Logs
                </a>
            <?php endif; ?>

            <!-- Sales Section -->
            <?php if($role === 'sales'): ?>
                <div class="menu-section">Sales</div>
                <a href="/inventory_system/sales/sell_device.php" class="menu-item">
                    <i class="fas fa-money-bill-wave"></i> Sell Device
                </a>
                <a href="/inventory_system/sales/sell_monitor.php" class="menu-item">
                    <i class="fas fa-desktop"></i> Sell monitor
                </a>
                <a href="/inventory_system/sales/sell_printer.php" class="menu-item">
                    <i class="fas fa-print"></i> Sell Printer
                </a>
                <a href="/inventory_system/sales/my_sales.php" class="menu-item">
                    <i class="fas fa-chart-bar"></i> My Sales
                </a>
                <a href="/inventory_system/sales/search_device.php" class="menu-item">
                    <i class="fas fa-search"></i> Search Device
                </a>
            <?php endif; ?>
            
            <!-- Transfers Section -->
            <?php if(in_array($role, ['super_admin','manager','inventory_admin'])): ?>
                <div class="menu-section">TRANSFERS</div>
                <a href="/inventory_system/transfers/index.php" class="menu-item">
                    <i class="fas fa-exchange-alt"></i> Make Transfer
                </a>
                <a href="/inventory_system/transfers/transfer_logs.php" class="menu-item">
                    <i class="fas fa-clipboard-list"></i> Transfer Logs
                </a>
            <?php endif; ?>

            <!-- Logs Section -->
            <?php if(in_array($role, ['super_admin','manager','inventory_admin'])): ?>
                <div class="menu-section">Logs</div>
                <?php if(in_array($role, ['super_admin','inventory_admin','manager'])): ?>
                    <a href="/inventory_system/sales/sales_logs.php" class="menu-item">
                        <i class="fas fa-chart-line"></i> Sales Logs
                    </a>
                <?php endif; ?>
                <?php if($role === 'super_admin'): ?>
                    <a href="/inventory_system/logs/activity.php" class="menu-item">
                        <i class="fas fa-chart-bar"></i> Activity Logs
                    </a>
                <?php endif; ?>
            <?php endif; ?>

            <!-- Super Admin Only -->
            <?php if($role === 'super_admin'): ?>
                <div class="menu-section">Admin</div>
                <a href="/inventory_system/auth/generate_code.php" class="menu-item">
                    <i class="fas fa-key"></i> Generate Code
                </a>
                <a href="/inventory_system/auth/view_users.php" class="menu-item">
                    <i class="fas fa-users"></i> View Users
                </a>
            <?php endif; ?>

            <!-- Logout -->
            <a href="/inventory_system/auth/logout.php" class="menu-item logout-btn">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
        </div>
    </div>
</div>

<style>
/* EXACT MATCH OF VIMARK TECH SIDEBAR - only colors changed */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    margin: 0;
    padding: 0;
}

.sidebar-wrapper {
    position: relative;
}

.sidebar { 
    position: fixed; 
    top: 0; 
    left: 0; 
    width: 240px; 
    height: 100vh; 
    background: linear-gradient(to bottom, #2f7a3f, #1f5a2d); 
    color: #fff; 
    padding: 20px 0; 
    overflow-y: auto; 
    transition: transform 0.3s ease; 
    z-index: 1000; 
    box-shadow: 2px 0 10px rgba(0,0,0,0.1);
}

.sidebar-header { 
    padding: 0 20px 20px; 
    border-bottom: 1px solid rgba(255,255,255,0.1); 
    margin-bottom: 15px; 
}

.sidebar h2 { 
    color: #fff; 
    margin: 0; 
    line-height: 1.2;
}

.sidebar h2:first-child {
    font-family: 'Times New Roman', serif;
    font-weight: bold;
    font-size: 1.4rem;
    margin-bottom: 5px;
}

.sidebar-menu { 
    padding: 0 15px; 
}

.menu-section { 
    color: rgba(255,255,255,0.7); 
    font-size: 0.8rem; 
    text-transform: uppercase; 
    letter-spacing: 1px; 
    margin: 20px 0 10px; 
    padding-left: 5px; 
    font-weight: 500;
}

.menu-item { 
    display: flex; 
    align-items: center; 
    gap: 12px; 
    color: #fff; 
    padding: 12px 15px; 
    margin: 5px 0; 
    text-decoration: none; 
    border-radius: 6px; 
    transition: all 0.3s ease; 
    font-size: 0.95rem; 
    background: transparent;
}

.menu-item:hover { 
    background: rgba(255,255,255,0.1); 
    transform: translateX(5px); 
}

.menu-item i { 
    font-size: 1.1rem; 
    opacity: 0.9; 
    width: 20px;
    text-align: center;
}

.logout-btn { 
    background: rgba(220,53,69,0.8); 
    margin-top: 20px; 
}

.logout-btn:hover { 
    background: rgba(220,53,69,1); 
}

.sidebar-toggle { 
    position: fixed; 
    top: 15px; 
    left: 15px; 
    background: #2f7a3f; 
    color: white; 
    padding: 10px 15px; 
    border-radius: 6px; 
    cursor: pointer; 
    z-index: 1001; 
    display: none; 
    align-items: center; 
    gap: 8px; 
    font-weight: 500; 
    box-shadow: 0 2px 5px rgba(0,0,0,0.2);
}

.sidebar-overlay { 
    position: fixed; 
    top: 0; 
    left: 0; 
    width: 100%; 
    height: 100%; 
    background: rgba(0,0,0,0.5); 
    z-index: 999; 
    display: none; 
}

@media (max-width: 768px) { 
    .sidebar { 
        transform: translateX(-100%);
        width: 240px;
    } 
    .sidebar.active { 
        transform: translateX(0); 
    } 
    .sidebar-toggle { 
        display: flex; 
    } 
    .sidebar-overlay.active { 
        display: block; 
    }
}

.sidebar::-webkit-scrollbar { 
    width: 4px; 
}

.sidebar::-webkit-scrollbar-track { 
    background: rgba(255,255,255,0.1); 
}

.sidebar::-webkit-scrollbar-thumb { 
    background: rgba(255,255,255,0.3); 
    border-radius: 2px; 
}
</style>

<script>
function toggleSidebar() {
    const sidebar = document.querySelector('.sidebar');
    const overlay = document.querySelector('.sidebar-overlay');
    sidebar.classList.toggle('active');
    overlay.classList.toggle('active');
    
    // Prevent body scroll when sidebar is open on mobile
    if (sidebar.classList.contains('active') && window.innerWidth <= 768) {
        document.body.style.overflow = 'hidden';
    } else {
        document.body.style.overflow = '';
    }
}

// Close sidebar when clicking a link on mobile
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.menu-item').forEach(link => {
        link.addEventListener('click', function() {
            if (window.innerWidth <= 768) {
                setTimeout(function() {
                    document.querySelector('.sidebar').classList.remove('active');
                    document.querySelector('.sidebar-overlay').classList.remove('active');
                    document.body.style.overflow = '';
                }, 100);
            }
        });
    });
    
    // Close sidebar when pressing Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && window.innerWidth <= 768) {
            const sidebar = document.querySelector('.sidebar');
            if (sidebar.classList.contains('active')) {
                toggleSidebar();
            }
        }
    });
});
</script>

</body>
</html>