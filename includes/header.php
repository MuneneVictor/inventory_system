<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= isset($page_title) ? $page_title : "Inventory System" ?></title>

    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f4f7f6;
            display: flex;
        }

        /* Sidebar */
        .sidebar {
            width: 250px;
            background: #1f5a2d;
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            color: #fff;
            padding-top: 20px;
        }

        .sidebar h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #fff;
            letter-spacing: 1px;
        }

        .sidebar a {
            display: block;
            padding: 12px 20px;
            color: #fff;
            text-decoration: none;
            font-size: 15px;
            border-left: 4px solid transparent;
        }

        .sidebar a:hover {
            background: #2f7a3f;
            border-left: 4px solid #2c6fbb;
        }

        /* Main content */
        .main-content {
            margin-left: 250px;
            padding: 20px;
            width: calc(100% - 250px);
        }

        /* Top header */
        .top-header {
            background: #2f7a3f;
            color: #fff;
            padding: 12px 20px;
            border-radius: 0 0 8px 8px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .btn-logout {
            background: #2c6fbb;
            color: #fff;
            padding: 8px 15px;
            border-radius: 5px;
            text-decoration: none;
        }

        .btn-logout:hover {
            background: #1a4d8f;
        }
    </style>
</head>

<body>
