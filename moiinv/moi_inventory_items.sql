-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 14, 2026 at 12:05 PM
-- Server version: 8.4.3
-- PHP Version: 8.3.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `inventory_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `moi_inventory_items`
--

CREATE TABLE `moi_inventory_items` (
  `id` bigint UNSIGNED NOT NULL,
  `item_type` enum('Device','Monitor') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT 'Device',
  `asset_id` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `buying_usd` decimal(12,2) DEFAULT NULL,
  `selling_usd` decimal(12,2) DEFAULT NULL,
  `buying_price` decimal(12,2) DEFAULT NULL,
  `planned_selling_price` decimal(12,2) DEFAULT NULL,
  `manufacturer` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `model_name` varchar(190) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `processor` varchar(190) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `ram` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `storage` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `serial_number` varchar(190) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `grade` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `touch_screen` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `webcam` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `notes` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `location` enum('KIMATHI','MOI','WAREHOUSE') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status` enum('In Stock','Sold') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'In Stock',
  `sales_person` varchar(190) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `selling_price` decimal(12,2) DEFAULT NULL,
  `payment_status` enum('paid','unpaid') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `sold_at` datetime DEFAULT NULL,
  `added_by` int DEFAULT NULL,
  `date_added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `moi_inventory_items`
--
ALTER TABLE `moi_inventory_items`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_moi_inventory_serial` (`serial_number`),
  ADD KEY `idx_moi_inventory_status` (`status`),
  ADD KEY `idx_moi_inventory_location` (`location`),
  ADD KEY `idx_moi_inventory_date_added` (`date_added`),
  ADD KEY `idx_ii_status_date_id` (`status`,`date_added`,`id`),
  ADD KEY `idx_ii_sold_date_id` (`sold_at`,`id`),
  ADD KEY `idx_ii_model` (`model_name`),
  ADD KEY `idx_ii_location` (`location`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `moi_inventory_items`
--
ALTER TABLE `moi_inventory_items`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
