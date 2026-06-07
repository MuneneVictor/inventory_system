<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if dark mode preference exists in cookie
$dark_mode = false;
if (isset($_COOKIE['dark_mode'])) {
    $dark_mode = $_COOKIE['dark_mode'] === 'enabled';
}

// Get user info if logged in
$user_name = $_SESSION['name'] ?? ($_SESSION['full_name'] ?? 'User');
$user_role = $_SESSION['role'] ?? 'guest';

// Get current time greeting
date_default_timezone_set('Africa/Nairobi');
$hour = date('G');
if ($hour < 12) $greeting = 'Good morning';
elseif ($hour < 17) $greeting = 'Good afternoon';
else $greeting = 'Good evening';
?>
<!DOCTYPE html>
<html lang="en" data-theme="<?= $dark_mode ? 'dark' : 'light' ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover, maximum-scale=1.0, user-scalable=yes">
    <title><?= $page_title ?? 'Mombasa Computers - Inventory Management System' ?></title>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,400;14..32,500;14..32,600;14..32,700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
    <!-- Dark Mode CSS (MUST be loaded after your main CSS) -->
    <link rel="stylesheet" href="/inventory_system/assets/css/dark-mode.css">
    
    <style>
        /* Dark Mode Toggle Button */
        .theme-toggle {
            background: none;
            border: 1px solid var(--gray-300, #ddd);
            cursor: pointer;
            font-size: 1.2rem;
            padding: 0.5rem;
            border-radius: 50%;
            transition: all 0.3s ease;
            width: 40px;
            height: 40px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: var(--gray-600, #666);
        }
        .theme-toggle:hover {
            background: var(--gray-100, #f0f0f0);
            transform: scale(1.05);
        }
        
        /* Sidebar Toggle Button */
        .sidebar-toggle {
            display: none;
            position: fixed;
            top: 1rem;
            left: 1rem;
            z-index: 1001;
            background: var(--primary, #1a4b2a);
            color: white;
            border: none;
            border-radius: 0.5rem;
            padding: 0.5rem 0.75rem;
            cursor: pointer;
            font-size: 1rem;
        }
        
        @media (max-width: 1200px) {
            .sidebar-toggle {
                display: block;
            }
        }
    </style>
    
    <script>
        function toggleDarkMode() {
            const html = document.documentElement;
            const currentTheme = html.getAttribute('data-theme');
            const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
            
            // Update HTML attribute
            html.setAttribute('data-theme', newTheme);
            
            // Save to cookie (expires in 365 days)
            const expiryDate = new Date();
            expiryDate.setFullYear(expiryDate.getFullYear() + 1);
            document.cookie = "dark_mode=" + newTheme + "; path=/; expires=" + expiryDate.toUTCString();
            
            // Update toggle button icon
            updateToggleIcon(newTheme);
        }
        
        function updateToggleIcon(theme) {
            const toggleBtn = document.getElementById('darkModeToggle');
            if (toggleBtn) {
                if (theme === 'dark') {
                    toggleBtn.innerHTML = '<i class="fas fa-sun"></i>';
                    toggleBtn.title = 'Switch to Light Mode';
                } else {
                    toggleBtn.innerHTML = '<i class="fas fa-moon"></i>';
                    toggleBtn.title = 'Switch to Dark Mode';
                }
            }
        }
        
        // Apply saved theme on page load
        document.addEventListener('DOMContentLoaded', function() {
            // Check cookie first
            let savedTheme = null;
            const cookies = document.cookie.split(';');
            for (let cookie of cookies) {
                const [name, value] = cookie.trim().split('=');
                if (name === 'dark_mode') {
                    savedTheme = value;
                    break;
                }
            }
            
            // Apply saved theme
            if (savedTheme === 'dark' || savedTheme === 'light') {
                document.documentElement.setAttribute('data-theme', savedTheme);
                updateToggleIcon(savedTheme);
            } else {
                updateToggleIcon('light');
            }
            
            // Sidebar toggle functionality
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebar = document.getElementById('sidebar');
            
            if (sidebarToggle && sidebar) {
                sidebarToggle.addEventListener('click', function() {
                    sidebar.classList.toggle('active');
                    window.dispatchEvent(new Event('sidebarToggled'));
                });
            }
        });
        
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            if (sidebar) {
                sidebar.classList.toggle('active');
                window.dispatchEvent(new Event('sidebarToggled'));
            }
        }
    </script>
</head>
<body>

<!-- Sidebar Toggle Button for Mobile -->
<button id="sidebarToggle" class="sidebar-toggle" onclick="toggleSidebar()">
    <i class="fas fa-bars"></i>
</button>

<!-- Include Sidebar -->
<?php 
if (file_exists(__DIR__ . '/sidebar.php') && basename($_SERVER['PHP_SELF']) !== 'login.php') {
    require_once __DIR__ . '/sidebar.php';
}
?>