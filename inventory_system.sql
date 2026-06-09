-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 09, 2026 at 01:23 PM
-- Server version: 8.4.3
-- PHP Version: 8.3.30

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
-- Table structure for table `activity_logs`
--

CREATE TABLE `activity_logs` (
  `id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `action` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `details` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `activity_logs`
--

INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `details`, `created_at`) VALUES
(1, 1, 'Added device', 'Added device SN: 5CG7766H', '2025-12-03 12:28:36'),
(2, NULL, 'Sold device', 'Sold device SN: 5CG7766H', '2025-12-03 12:29:35'),
(3, NULL, 'Sold device', 'Sold device SN: GH677HG72', '2025-12-03 12:50:02'),
(4, NULL, 'Sold device', 'Sold device SN: THG67J100', '2025-12-03 12:51:04'),
(5, 4, 'Maintenance - Update Specs', 'Updated specs for GH677HG7U by Munene vicky. RAM: 16 -> 16, Storage: 512 -> 256, Graphics: none -> none', '2025-12-03 15:20:41'),
(6, 1, 'Added device', 'Added device SN: 5CG77XH4', '2025-12-03 15:29:32'),
(7, 1, 'Added device', 'Added device SN: THG567JKDF', '2025-12-03 15:56:59'),
(8, NULL, 'Added device', 'Added device SN: 5CG890KL9', '2025-12-03 15:59:21'),
(9, NULL, 'Sold device', 'Sold device SN: GH677HG70', '2025-12-03 18:59:48'),
(10, NULL, 'Sold device', 'Sold device SN: 5CG890KL9', '2025-12-03 19:01:10'),
(11, NULL, 'Sold device', 'Sold device SN: THG67J99', '2025-12-04 04:18:46'),
(12, 7, 'Sold device', 'Sold device SN: 5CGHJJ67', '2025-12-04 19:29:24'),
(13, 7, 'Sold device', 'Sold device SN: THG567JKDF', '2025-12-04 19:40:53'),
(14, 1, 'Added device', 'Device 5CGHJJ68 (HP ELITEBOOK 840 G6) added via Excel upload', '2025-12-05 20:28:12'),
(15, 1, 'Added device', 'Device 5CGHJJ69 (HP ELITEBOOK 840 G8) added via Excel upload', '2025-12-05 20:28:12'),
(16, 1, 'Added device', 'Device 5CGHJJ70 (HP ELITEBOOK 840 G8) added via Excel upload', '2025-12-05 20:28:12'),
(17, 1, 'Added device', 'Device 5CGHJJ71 (HP ELITEBOOK 840 G6) added via Excel upload', '2025-12-05 20:28:12'),
(18, 1, 'Added device', 'Device 5CGHJJ72 (HP ELITEBOOK 840 G6) added via Excel upload', '2025-12-05 20:28:12'),
(19, 1, 'Added device', 'Device 5CGHJJ73 (HP ELITEBOOK 840 G6) added via Excel upload', '2025-12-05 20:28:12'),
(20, 1, 'Added device', 'Device 5CGHJJ74 (HP ELITEBOOK 840 G8) added via Excel upload', '2025-12-05 20:28:12'),
(21, 1, 'Added device', 'Device 5CGHJJ75 (DELL OPTILEX 5530) added via Excel upload', '2025-12-05 20:28:12'),
(22, 1, 'Added device', 'Device 5CGHJJ78 (HP ELITEDESK 705 G5) added via Excel upload', '2025-12-05 20:28:12'),
(23, 1, 'Added device', 'Device 5CGHJJ79 (HP ELITEDESK 800 G3) added via Excel upload', '2025-12-05 20:28:12'),
(24, 1, 'Added device', 'Device 5CGHJJ80 (HP ELITEDESK 800 G3) added via Excel upload', '2025-12-05 20:28:12'),
(25, 1, 'Added device', 'Device 5CGHJJ81 (HP PRO ONE 24) added via Excel upload', '2025-12-05 20:28:12'),
(26, 1, 'Added device', 'Device 5CGHJJ82 (HP PRO ONE 24) added via Excel upload', '2025-12-05 20:28:12'),
(27, 1, 'Added device', 'Device 5CGHJJ83 (HP PRO ONE 24) added via Excel upload', '2025-12-05 20:28:12'),
(28, 1, 'Added device', 'Device 5CGHJJ84 (HP ALL IN ONE 25) added via Excel upload', '2025-12-05 20:28:12'),
(29, 1, 'Added device', 'Device 5CGHJJ85 (HP ALL IN ONE 25) added via Excel upload', '2025-12-05 20:28:12'),
(30, 1, 'Added device', 'Device 5CGHJJB33 (HP ELITEBOOK 840 G6) added via Excel upload', '2025-12-05 20:50:03'),
(31, 1, 'Added device', 'Device 5CGHJJB34 (HP ELITEBOOK 840 G6) added via Excel upload', '2025-12-05 20:50:03'),
(32, 1, 'Added device', 'Device 5CGHJJB35 (HP ELITEBOOK 840 G8) added via Excel upload', '2025-12-05 20:50:03'),
(33, 1, 'Added device', 'Device 5CGHJJB36 (HP ELITEBOOK 840 G8) added via Excel upload', '2025-12-05 20:50:03'),
(34, 1, 'Added device', 'Device 5CGHJJB37 (HP ELITEBOOK 840 G6) added via Excel upload', '2025-12-05 20:50:03'),
(35, 1, 'Added device', 'Device 5CGHJJB38 (HP ELITEBOOK 840 G6) added via Excel upload', '2025-12-05 20:50:03'),
(36, 1, 'Added device', 'Device 5CGHJJB39 (HP ELITEBOOK 840 G6) added via Excel upload', '2025-12-05 20:50:03'),
(37, 1, 'Added device', 'Device 5CGHJJB40 (HP ELITEBOOK 840 G8) added via Excel upload', '2025-12-05 20:50:03'),
(38, 1, 'Added device', 'Device 5CGHJJB41 (DELL OPTILEX 5530) added via Excel upload', '2025-12-05 20:50:03'),
(39, 8, 'Added RAM/SSD', 'Added 20 RAM of type NVMe in KIMATHI', '2025-12-05 22:39:06'),
(40, 8, 'Added RAM/SSD', '10 SSD of type SATA (256GB) added in KIMATHI', '2025-12-05 23:34:14'),
(41, 8, 'Updated RAM/SSD', '4 SSD of type SATA (256GB) increased in KIMATHI', '2025-12-05 23:34:49'),
(42, 8, 'Given RAM/SSD', 'Given 1 SSD (256GB) to Peninah Kalundi in KIMATHI', '2025-12-05 23:39:27'),
(43, 7, 'Sold device', 'Sold device SN: 5CGHJJB33', '2025-12-05 23:45:48'),
(44, 8, 'Added RAM/SSD', '5 RAM of type DDR3 (16GB) added in KIMATHI', '2025-12-06 04:01:43'),
(45, 7, 'Sold device', 'Sold device SN: 5CGHJJB36', '2025-12-06 12:50:17'),
(46, 1, 'Added RAM/SSD', '15 SSD(s) of type NVMe (512GB) added in KIMATHI', '2025-12-06 18:05:45'),
(47, 1, 'Added RAM/SSD', '20 SSD(s) of type SATA (256GB) added in MOI', '2025-12-06 18:08:29'),
(48, 1, 'Given RAM/SSD', 'Given 10 SSD (256GB) to Bruce dee in KIMATHI', '2025-12-06 18:29:53'),
(49, 8, 'Added RAM/SSD', '5 SSD(s) of type SATA (512GB) added in KIMATHI', '2025-12-06 21:39:21'),
(50, 8, 'Added RAM/SSD', '7 RAM(s) of type DDR3 (16GB) added in KIMATHI', '2025-12-06 21:39:34'),
(51, 7, 'Sold device', 'Sold device SN: 5CGHJJB34', '2025-12-06 21:41:27'),
(52, 8, 'Edited device', 'Edited device SN: 5CGHJJB36 (Status: Sold → Sold, Branch: MOI)', '2025-12-06 21:51:27'),
(53, 8, 'Given RAM/SSD', 'Given 5 SSD (512GB) to Peninah Kalundi in KIMATHI', '2025-12-06 22:00:25'),
(54, 1, 'Added RAM/SSD', '9 SSD(s) of type SATA (512GB) added in MOI', '2025-12-07 03:56:00'),
(55, 1, 'Edited device', 'Edited device SN: THG567JKDF (Status: Sold → Sold, Branch: KIMATHI)', '2025-12-07 08:11:14'),
(56, 1, 'Edited device', 'Edited device SN: THG567JKDF (Status: Sold → Sold, Branch: KIMATHI)', '2025-12-07 08:23:25'),
(57, NULL, 'device_loaded_for_repair', 'Serial: 5CGHJJB40, Model: HP ELITEBOOK 840 G8', '2025-12-07 11:19:22'),
(58, NULL, 'repair_added', 'Serial: 5CGHJJB40, Problem: broken screen', '2025-12-07 11:20:04'),
(59, NULL, 'device_loaded_for_repair', 'Serial: 5CGHJJB38, Model: HP ELITEBOOK 840 G6', '2025-12-07 11:22:41'),
(60, NULL, 'repair_added', 'Serial: 5CGHJJB38, Problem: camera issue', '2025-12-07 11:30:32'),
(61, NULL, 'Added Repair Record', 'Device: 5CGHJJ81 | Problem: NOT POWERING | Fix: FIXED | Given By ID: 8', '2025-12-07 13:41:20'),
(62, 4, 'Maintenance - Update Specs', 'Updated specs for 5CGHJJ80 by Munene vicky. RAM: From 8 GB to 16 GB, Storage: from 1000 GB to from 256 GB, Graphics: none to none', '2025-12-07 13:59:28'),
(63, 4, 'Maintenance - Update Specs', 'Updated specs for 5CGHJJB41 by Munene vicky. RAM: From 16 GB to 8 GB, Storage: From HDD 2000 GB to SSD 256 GB, Graphics: 4GB NVIDIA QUADRO P2000 to 4GB NVIDIA QUADRO P2000', '2025-12-07 14:23:16'),
(64, 4, 'Maintenance - Update Specs', 'Updated specs for THG67J101 by Munene vicky. RAM: From 16 GB to 8 GB, Storage: From HDD 500 GB to SSD 256 GB, Graphics: 2GB AMD RADEON R7 200 to 2GB AMD RADEON R7 200', '2025-12-07 14:35:10'),
(65, 1, 'Added device', 'Device 5CGHJJR45 (HP ELITEBOOK 840 G6) added via Excel upload to branch: MOI', '2025-12-07 15:33:03'),
(66, 1, 'Added device', 'Device 5CGHJJR46 (HP ELITEBOOK 840 G7) added via Excel upload to branch: MOI', '2025-12-07 15:33:03'),
(67, 1, 'Added device', 'Device 5CGHJJR47 (HP ELITEBOOK 840 G8) added via Excel upload to branch: MOI', '2025-12-07 15:33:03'),
(68, 1, 'Added device', 'Device 5CGHJJR48 (HP ELITEBOOK 840 G9) added via Excel upload to branch: KIMATHI', '2025-12-07 15:33:03'),
(69, 4, 'Maintenance - Update Specs', 'Updated specs for THG67J102 by Munene vicky. RAM: From 16GB to 8GB. Storage: From SSD 256GB to HDD 500GB.', '2025-12-07 15:44:16'),
(70, 1, 'Updated RAM/SSD', '15 SSD(s) of type SATA (512GB) increased in KIMATHI', '2025-12-07 15:49:26'),
(71, 1, 'Given RAM/SSD', 'Given 1 SSD (512GB) to Peninah Kalundi in KIMATHI', '2025-12-07 15:54:41'),
(72, 1, 'Edited device', 'Edited device SN: 5CGHJJR47 (Status: In Stock → In Stock, Branch: MOI)', '2025-12-07 16:30:24'),
(73, 1, 'Given RAM/SSD', 'Given 2 SSD (512GB) to Peninah Kalundi in KIMATHI', '2025-12-09 05:28:43'),
(74, 7, 'Sold device', 'Sold device SN: 5CGHJJ31', '2025-12-09 05:31:18'),
(75, 1, 'Added RAM/SSD', '9 RAM(s) of type PC4 (16GB) added in KIMATHI', '2025-12-09 05:47:19'),
(76, 1, 'Added device', 'Added device SN: 5CGU78X9, Cargo: CX37', '2025-12-13 13:57:43'),
(77, 1, 'Added device', 'Added device SN: 5CGHH67Y8, Cargo: CX37', '2025-12-13 14:53:06'),
(78, 1, 'Added device', 'Added device SN: 5CG11RT3H, Cargo: CX37', '2025-12-13 15:03:14'),
(79, 1, 'Added device', 'Added device SN: 8CC67YHU5, Cargo: CX35', '2025-12-13 18:42:16'),
(80, 1, 'Added device', 'Device 5CGHJJRQW1 (HP ELITEBOOK 840 G5) added via Excel upload to branch: MOI', '2025-12-13 19:20:14'),
(81, 1, 'Added device', 'Device 5CGHJJRQW2 (HP ELITEBOOK 840 G5) added via Excel upload to branch: MOI', '2025-12-13 19:20:14'),
(82, 1, 'Added device', 'Device 5CGHJJRQW3 (HP ELITEBOOK 840 G5) added via Excel upload to branch: MOI', '2025-12-13 19:20:14'),
(83, 1, 'Added device', 'Device 5CGHJJRQW4 (HP ELITEBOOK 840 G5) added via Excel upload to branch: KIMATHI', '2025-12-13 19:20:14'),
(84, 1, 'Added device', 'Device 5CGHJJRQW5 (HP ELITEBOOK 840 G5) added via Excel upload to branch: KIMATHI', '2025-12-13 19:20:14'),
(85, 1, 'Added device', 'Device 5CGHJJRQW6 (HP ELITEBOOK 840 G5) added via Excel upload to branch: MOI', '2025-12-13 19:20:14'),
(86, 1, 'Added device', 'Device TGBHJJRQW1 (HP ELITEDESK 705 G5) added via Excel upload to branch: MOI', '2025-12-13 22:43:46'),
(87, 1, 'Added device', 'Device TGBHJJRQW2 (HP ELITEDESK 705 G5) added via Excel upload to branch: MOI', '2025-12-13 22:43:46'),
(88, 1, 'Added device', 'Device TGBHJJRQW3 (HP ELITEDESK 705 G5) added via Excel upload to branch: MOI', '2025-12-13 22:43:46'),
(89, 1, 'Added device', 'Device TGBHJJRQW4 (HP ELITEDESK 705 G5) added via Excel upload to branch: KIMATHI', '2025-12-13 22:43:46'),
(90, 1, 'Added device', 'Added device SN: 8CCYYX54E, Cargo: CX37', '2025-12-14 07:23:22'),
(91, 1, 'Added device', 'Added device SN: TGH66KK8, Cargo: CX50', '2025-12-14 07:42:22'),
(92, 1, 'Added device', 'Added device SN: 8CCEE56TY, Cargo: CX37', '2025-12-14 07:54:27'),
(93, 7, 'Sold device', 'Sold device SN: 5CGHJJ84 for KES 42,500.00', '2025-12-14 08:38:04'),
(94, 1, 'Added device', 'Added device SN: 5CGKLMN0P', '2025-12-14 11:09:29'),
(95, 7, 'Sold monitor', 'Sold monitor SN: MNJGGDHH8 (DELL MONITOR)', '2025-12-14 20:21:45'),
(96, 7, 'Sold device', 'Sold device SN: 5CGHJJ68 for KES 26,000.00', '2025-12-14 20:58:03'),
(97, 7, 'Sold device', 'Sold device SN: 5CGHJJ81 for KES 0', '2025-12-14 20:58:03'),
(98, 1, 'Added device', 'Added device SN: 8CC56RRZ3, Cargo: NO CARGO', '2025-12-14 21:39:07'),
(99, 7, 'Sold printer', 'Sold printer SN: PTNJGGDHH10 (EPSON PRINTER)', '2025-12-15 05:38:17'),
(100, 1, 'Added device', 'Added device SN: MJ09BKTS, Cargo: NO CARGO', '2025-12-15 11:07:05'),
(101, 1, 'Added device', 'Added device SN: 8CCHJF56R, Cargo: NO CARGO', '2025-12-15 11:21:53'),
(102, 7, 'Sold device', 'Sold device SN: MJ09BKTS for KES 15,000.00', '2025-12-15 11:24:32'),
(103, NULL, 'Added device', 'Added device SN: 1234, Cargo: CX37', '2025-12-15 13:43:30'),
(104, NULL, 'Edited device', 'Edited device SN: 1234 (Status: In Stock → In Stock, Branch: KIMATHI)', '2025-12-15 13:48:55'),
(105, 1, 'Added device', 'Device TGBHJJRQW1 (HP ELITEDESK 705 G5) added via Excel upload to branch: MOI', '2025-12-15 18:26:54'),
(106, 1, 'Added device', 'Device TGBHJJRQW2 (HP ELITEDESK 705 G5) added via Excel upload to branch: MOI', '2025-12-15 18:26:54'),
(107, 1, 'Added device', 'Device TGBHJJRQW3 (HP ELITEDESK 705 G5) added via Excel upload to branch: MOI', '2025-12-15 18:26:54'),
(108, 1, 'Added device', 'Device TGBHJJRQW4 (HP ELITEDESK 705 G5) added via Excel upload to branch: KIMATHI', '2025-12-15 18:26:54'),
(109, 1, 'Added device', 'Device 5CG09OPL34 (HP ELITEDESK 840 G6) added via Excel upload to branch: KIMATHI', '2025-12-15 18:26:54'),
(110, 1, 'Added device', 'Device 5CG09OPL35 (HP ELITEDESK 840 G6) added via Excel upload to branch: KIMATHI', '2025-12-15 18:26:54'),
(111, 1, 'Added device', 'Device 5CG09OPL36 (HP ELITEDESK 840 G6) added via Excel upload to branch: KIMATHI', '2025-12-15 18:26:54'),
(112, 1, 'Added device', 'Device 5CG09OPL37 (HP ELITEDESK 840 G6) added via Excel upload to branch: KIMATHI', '2025-12-15 18:26:54'),
(113, 1, 'Added device', 'Device 5CG09OPL38 (HP ELITEDESK 840 G6) added via Excel upload to branch: MOI', '2025-12-15 18:26:54'),
(114, 1, 'Added device', 'Device 5CG09OPL39 (HP ELITEDESK 840 G6) added via Excel upload to branch: MOI', '2025-12-15 18:26:55'),
(115, 1, 'Added device', 'Device 5CG09OPL40 (HP ELITEDESK 840 G8) added via Excel upload to branch: MOI', '2025-12-15 18:26:55'),
(116, 1, 'Added device', 'Device 5CG09OPL41 (HP ELITEDESK 840 G8) added via Excel upload to branch: MOI', '2025-12-15 18:26:55'),
(117, 1, 'Added device', 'Device 5CG09OPL42 (HP ELITEDESK 840 G8) added via Excel upload to branch: MOI', '2025-12-15 18:26:55'),
(118, 1, 'Added device', 'Device MXHT89YU3 (HP ELITEDESK 705 G4) added via Excel upload to branch: KIMATHI', '2025-12-15 18:26:55'),
(119, 1, 'Added device', 'Device MXHT89YU4 (HP ELITEDESK 705 G4) added via Excel upload to branch: KIMATHI', '2025-12-15 18:26:55'),
(120, 1, 'Added device', 'Device MXHT89YU5 (HP ELITEDESK 705 G4) added via Excel upload to branch: KIMATHI', '2025-12-15 18:26:55'),
(121, 1, 'Added device', 'Device MXHT89YU6 (HP ELITEDESK 705 G4) added via Excel upload to branch: MOI', '2025-12-15 18:26:55'),
(122, 1, 'Added device', 'Device MXHT89YU7 (HP ELITEDESK 705 G4) added via Excel upload to branch: MOI', '2025-12-15 18:26:55'),
(123, 1, 'Given RAM/SSD', 'Given 1 RAM (16GB) to Peninah Kalundi in KIMATHI', '2025-12-15 18:41:23'),
(124, 1, 'Updated RAM/SSD', '10 RAM(s) of type DDR3 (16GB) increased in KIMATHI', '2025-12-15 18:43:02'),
(125, 7, 'Sold device', 'Sold device SN: 5CG09OPL37 for KES 25,000.00', '2025-12-16 12:45:12'),
(126, 4, 'Added Repair', 'Device: TGBHJJRQW4 | Problem: Faulty keyboard | Given By: Victor Munene | Branch: KIMATHI | Technician: Munene vicky', '2025-12-16 21:34:43'),
(127, 1, 'Edited device', 'Device: 5CG09OPL37 | Updated by: Victor Munene | Changes: Model: HP ELITEDESK 840 G6 → HP ELITEDESK 840 G8', '2025-12-17 03:33:45'),
(128, 1, 'Added device', 'Device 5CG09OZL35 (HP ELITEDESK 840 G6) added via Excel upload to branch: Unknown', '2025-12-17 04:31:02'),
(129, 1, 'Added device', 'Device 5CG09OZL36 (HP ELITEDESK 840 G6) added via Excel upload to branch: Unknown', '2025-12-17 04:31:02'),
(130, 1, 'Added device', 'Device 5CG09OZL37 (HP ELITEDESK 840 G6) added via Excel upload to branch: Unknown', '2025-12-17 04:31:02'),
(131, 1, 'Added device', 'Device 5CG09OZL38 (HP ELITEDESK 840 G6) added via Excel upload to branch: Unknown', '2025-12-17 04:31:02'),
(132, 1, 'Added device', 'Device 5CG09OZL39 (HP ELITEDESK 840 G6) added via Excel upload to branch: Unknown', '2025-12-17 04:31:02'),
(133, 1, 'Added device', 'Device 5CG09OZL35 (HP ELITEDESK 840 G6) added via Excel upload to branch: KIMATHI', '2025-12-17 04:42:33'),
(134, 1, 'Added device', 'Device 5CG09OZL36 (HP ELITEDESK 840 G6) added via Excel upload to branch: KIMATHI', '2025-12-17 04:42:33'),
(135, 1, 'Added device', 'Device 5CG09OZL37 (HP ELITEDESK 840 G6) added via Excel upload to branch: KIMATHI', '2025-12-17 04:42:33'),
(136, 1, 'Added device', 'Device 5CG09OZL38 (HP ELITEDESK 840 G6) added via Excel upload to branch: KIMATHI', '2025-12-17 04:42:33'),
(137, 1, 'Added device', 'Device 5CG09OZL39 (HP ELITEDESK 840 G6) added via Excel upload to branch: KIMATHI', '2025-12-17 04:42:33'),
(138, 1, 'Updated RAM/SSD', '5 SSD(s) of type SATA (512GB) increased in KIMATHI', '2025-12-17 16:39:07'),
(139, NULL, 'Added Repair', 'Device: 5CG09OPL34 | Problem: faulty keyboard | Given By: Victor Munene | Branch: KIMATHI | Technician: denis', '2025-12-18 05:16:11'),
(140, 7, 'Sold device', 'Sold device SN: 5CG09OPL34 for KES 25,000.00', '2025-12-18 05:17:46'),
(141, 4, 'Maintenance - Update Specs', 'Updated specs for TGBHJJRQW4 by Munene vicky. RAM: From 16GB to 8GB. Storage: From SSD 256GB to HDD 500GB. Graphics: From none to 2GB AMD RADEON R7 200.', '2025-12-20 18:32:33'),
(142, 1, 'Transfer device', 'Transferred device SN: MXHT89YU3 from KIMATHI to MOI (Delivered by: munene)', '2025-12-28 14:06:33'),
(143, 8, 'Updated RAM/SSD', '5 RAM(s) of type PC4 (16GB) increased in KIMATHI', '2025-12-28 14:12:15'),
(144, 8, 'Added RAM/SSD', '5 RAM(s) of type PC4 (8GB) added in KIMATHI', '2025-12-28 14:12:54'),
(145, 8, 'Given RAM/SSD', 'Given 2 SSD (512GB) to Peninah Kalundi in KIMATHI', '2025-12-28 14:17:01'),
(146, 1, 'Transfer device', 'Transferred device SN: TGBHJJRQW1 from MOI to KIMATHI (Delivered by: Vic)', '2025-12-29 02:36:59'),
(147, 1, 'Transfer RAMs/SSDs', 'Transferred 3 component type(s) (18 total items) from KIMATHI to MOI: DDR3 16GB RAM x7, PC4 16GB RAM x6, SATA 512GB SSD x5 (Delivered by: munene)', '2025-12-29 20:46:01'),
(148, 8, 'Transfer RAMs/SSDs', 'Transferred 1 component type(s) (1 total items) from KIMATHI to MOI: DDR3 16GB RAM x1 (Delivered by: Vic)', '2025-12-30 04:13:03'),
(149, 8, 'Transfer chargers', 'Transferred 1 charger type(s) (1 total items) from KIMATHI to MOI: HP Blue Pin 65W (new) x1 (Delivered by: Vic)', '2025-12-30 04:14:38'),
(150, 1, 'Added device', 'Added device SN: 5TG89JJKV9, Cargo: NO CARGO', '2025-12-30 08:34:15'),
(151, 7, 'Sold device', 'Sold device SN: MXHT89YU5 for KES 20,000.00', '2026-01-02 15:37:57'),
(152, NULL, 'Added Repair', 'Device: MXHT89YU7 | Problem: Faulty keyboard | Given By: Victor Syovata | Branch: MOI | Technician: Vic vdeb', '2026-01-02 16:00:33'),
(153, NULL, 'Added Repair', 'Device: MXHT89YU7 | Problem: Speaker issue | Given By: Victor Syovata | Branch: MOI | Technician: Vic vdeb', '2026-01-02 16:30:36'),
(154, 1, 'Edited device', 'Device: TGBHJJRQW4 | Updated by: Victor Munene | Changes: RAM: 8GB → 16GB, Touch: N/A → ', '2026-01-22 11:28:03'),
(155, 1, 'Transfer RAMs/SSDs', 'Transferred 1 component type(s) (8 total items) from KIMATHI to MOI: DDR3 16GB RAM x8 (Delivered by: Vic)', '2026-01-22 11:32:46'),
(156, 1, 'Transfer chargers', 'Transferred 1 charger type(s) (1 total items) from KIMATHI to MOI: HP Blue Pin 65W (new) x1 (Delivered by: Victor)', '2026-02-02 07:08:12'),
(157, 1, 'Added device', 'Added device SN: MXY77HJKAL, Cargo: AC3', '2026-02-21 18:46:43'),
(158, 1, 'Added device', 'Added device SN: MXD90IOOKLW, Cargo: AC3', '2026-02-21 18:48:48'),
(159, 1, 'Transfer chargers', 'Transferred 1 charger type(s) (5 total items) from MOI to KIMATHI: HP Blue Pin 45W (new) x5 (Delivered by: Victor)', '2026-03-01 06:18:23'),
(160, 1, 'Added device', 'Added device SN: MXFGHGFH, Cargo: CXC30', '2026-03-03 18:09:46'),
(161, 1, 'Edited device', 'Device: MXFGHGFH | Updated by: Victor Munene | Changes: Storage: SSD 16GB → SSD 512GB', '2026-03-03 18:11:38'),
(162, 7, 'Sold device', 'Sold device SN: MXD90IOOKLW for KES 15,000.00', '2026-03-03 18:24:35'),
(163, 1, 'Transfer monitor', 'Transferred monitor SN: MNJGGDHH10 from MOI to KIMATHI (Delivered by: Victor)', '2026-03-03 18:29:32'),
(164, 7, 'Sold monitor', 'Sold monitor SN: MNJGGDHH9 (DELL MONITOR)', '2026-03-03 18:30:17'),
(165, 4, 'Maintenance - Update Specs', 'Updated specs for MXHT89YU7 by Munene vicky. RAM: From 8GB to 16GB. Storage: From SSD 256GB to SSD 512GB.', '2026-03-03 18:36:38'),
(166, 4, 'Added Repair', 'Device: MXFGHGFH | Problem: FAULTY KEYBOARD | Given By: Victor Munene | Branch: KIMATHI | Technician: Munene vicky', '2026-03-03 18:44:11'),
(167, 7, 'Sold device', 'Sold device SN: TGBHJJRQW1 for KES 40,000.00', '2026-03-08 10:01:45'),
(168, NULL, 'Updated RAM/SSD', '2 RAM(s) of type DDR3 (16GB) increased in MOI', '2026-03-17 11:28:24'),
(169, 1, 'Added device', 'Added device SN: 5CG0302X7Y, Cargo: AC26', '2026-03-27 08:32:20'),
(170, 1, 'Transfer RAMs/SSDs', 'Transferred 1 component type(s) (1 total items) from KIMATHI to MOI: PC4 8GB RAM x1 (Delivered by: victor)', '2026-03-28 06:34:30'),
(171, 1, 'Edited device', 'Device: TGBHJJRQW4 | Updated by: Victor Munene | Changes: Storage: HDD 500GB → SSD 256GB', '2026-03-29 17:10:59'),
(172, 1, 'Edited device', 'Device: TGBHJJRQW4 | Updated by: Victor Munene | Changes: Graphics: 2GB AMD RADEON R7 200 → None', '2026-03-29 17:12:09'),
(173, 1, 'Added device', 'Device 5CG09OZXE32 (HP ELITEBOOK 840 G6) added via Excel upload to branch: MOI', '2026-04-02 12:50:27'),
(174, 1, 'Added device', 'Device 5CG09OZXE33 (HP ELITEBOOK 840 G6) added via Excel upload to branch: MOI', '2026-04-02 12:50:27'),
(175, 1, 'Added device', 'Device 5CG09OZXE34 (HP ELITEBOOK 840 G6) added via Excel upload to branch: MOI', '2026-04-02 12:50:27'),
(176, 1, 'Added device', 'Device 5CG09OZXE35 (HP ELITEBOOK 840 G6) added via Excel upload to branch: MOI', '2026-04-02 12:50:27'),
(177, 1, 'Added device', 'Device 5CG09OZXE36 (HP ELITEBOOK 840 G6) added via Excel upload to branch: KIMATHI', '2026-04-02 12:50:27'),
(178, 1, 'Added device', 'Device 5CG09OZXE37 (HP ELITEBOOK 840 G8) added via Excel upload to branch: KIMATHI', '2026-04-02 12:50:27'),
(179, 1, 'Added device', 'Device 5CG09OZXE38 (HP ELITEBOOK 840 G8) added via Excel upload to branch: KIMATHI', '2026-04-02 12:50:27'),
(180, 1, 'Added device', 'Device 5CG09OZXE39 (HP ELITEBOOK 840 G8) added via Excel upload to branch: KIMATHI', '2026-04-02 12:50:27'),
(181, 1, 'Added device', 'Device 5CG09OZXE40 (HP ELITEBOOK 840 G8) added via Excel upload to branch: KIMATHI', '2026-04-02 12:50:27'),
(182, 1, 'Added device', 'Device 5CG09OZXE41 (HP ELITEBOOK 840 G8) added via Excel upload to branch: KIMATHI', '2026-04-02 12:50:27'),
(183, 1, 'Added device', 'Device 5CG09OZXE42 (HP ELITEBOOK 840 G8) added via Excel upload to branch: MOI', '2026-04-02 12:50:27'),
(184, 1, 'Added device', 'Device THK897YYRS4 (HP Z6 WORKSTATION) added via Excel upload to branch: MOI', '2026-04-02 12:50:27'),
(185, 1, 'Added device', 'Device THK897YYRS5 (HP Z6 WORKSTATION) added via Excel upload to branch: MOI', '2026-04-02 12:50:27'),
(186, 1, 'Added device', 'Device THK897YYRS6 (HP Z6 WORKSTATION) added via Excel upload to branch: MOI', '2026-04-02 12:50:27'),
(187, 1, 'Added device', 'Device THK897YYRS7 (HP Z6 WORKSTATION) added via Excel upload to branch: MOI', '2026-04-02 12:50:27'),
(188, 1, 'Added device', 'Device THK897YYRS8 (HP Z6 WORKSTATION) added via Excel upload to branch: KIMATHI', '2026-04-02 12:50:27'),
(189, 1, 'Added device', 'Device THK897YYRS9 (HP Z6 WORKSTATION) added via Excel upload to branch: KIMATHI', '2026-04-02 12:50:27'),
(190, 1, 'Added device', 'Device 8CC6YHMS54 (HP ELITEDESK 705 G4) added via Excel upload to branch: KIMATHI', '2026-04-02 12:50:27'),
(191, 1, 'Added device', 'Device 8CC6YHMS55 (HP ELITEDESK 705 G4) added via Excel upload to branch: KIMATHI', '2026-04-02 12:50:27'),
(192, 1, 'Added device', 'Device 8CC6YHMS56 (HP ELITEDESK 705 G4) added via Excel upload to branch: MOI', '2026-04-02 12:50:27'),
(193, 1, 'Added device', 'Device 8CC6YHMS57 (HP ELITEDESK 705 G5) added via Excel upload to branch: MOI', '2026-04-02 12:50:27'),
(194, 1, 'Added device', 'Device 8CC6YHMS58 (HP ELITEDESK 705 G5) added via Excel upload to branch: MOI', '2026-04-02 12:50:27'),
(195, 1, 'Added device', 'Added device SN: 5CGUYUIJVIUG, Cargo: AC526', '2026-04-22 20:28:16'),
(196, 1, 'Added device', 'Added device SN: 5CGBAJJJUU88, Cargo: AC265', '2026-06-07 10:45:29'),
(197, 7, 'Sold device', 'Sold device SN: 5CG09OZXE40 for KES 60,000.00', '2026-06-07 13:55:36'),
(198, 7, 'Sold monitor', 'Sold monitor SN: ER556TGHM (HP COMPAQ)', '2026-06-07 15:18:22'),
(199, 1, 'Bulk upload', 'Added device 5CG1234XYZ (HP EliteBook 840 G6) via Excel upload to branch: KIMATHI', '2026-06-08 07:02:20'),
(200, 1, 'Bulk upload', 'Added device 8CC5678ABC (HP EliteDesk 705 G4) via Excel upload to branch: MOI', '2026-06-08 07:02:20'),
(201, 1, 'Bulk upload', 'Added device ABC9012DEF (HP ProOne 400 G5) via Excel upload to branch: KIMATHI', '2026-06-08 07:02:20'),
(202, 1, 'Bulk upload', 'Added device 5CG7TYTUGJ9 (HP EliteBook 840 G6) via Excel upload to branch: KIMATHI', '2026-06-08 07:02:20'),
(203, 1, 'Bulk upload', 'Added device 5CG7TYTUGJ10 (HP EliteBook 840 G6) via Excel upload to branch: KIMATHI', '2026-06-08 07:02:20'),
(204, 1, 'Bulk upload', 'Added device 5CG7TYTUGJ11 (HP EliteBook 840 G6) via Excel upload to branch: KIMATHI', '2026-06-08 07:02:20'),
(205, 1, 'Bulk upload', 'Added device 5CG7TYTUGJ12 (HP EliteBook 840 G6) via Excel upload to branch: KIMATHI', '2026-06-08 07:02:20'),
(206, 1, 'Bulk upload', 'Added device 5CG7TYTUGJ13 (HP EliteBook 840 G6) via Excel upload to branch: KIMATHI', '2026-06-08 07:02:20'),
(207, 1, 'Bulk upload', 'Added device 5CG7TYTUGJ14 (HP EliteBook 840 G6) via Excel upload to branch: KIMATHI', '2026-06-08 07:02:20'),
(208, 1, 'Bulk upload', 'Added device 5CG7TYTUGJ15 (HP EliteBook 840 G6) via Excel upload to branch: MOI', '2026-06-08 07:02:20'),
(209, 1, 'Bulk upload', 'Added device 5CG7TYTUGJ16 (HP EliteBook 840 G6) via Excel upload to branch: MOI', '2026-06-08 07:02:20'),
(210, 1, 'Bulk upload', 'Added device 5CG7TYTUGJ17 (HP EliteBook 840 G6) via Excel upload to branch: MOI', '2026-06-08 07:02:20'),
(211, 1, 'Bulk upload', 'Added device 5CG7TYTUGJ18 (HP EliteBook 840 G6) via Excel upload to branch: MOI', '2026-06-08 07:02:20'),
(212, 1, 'Bulk upload', 'Added device 5CG7TYTUGJ19 (HP EliteBook 840 G6) via Excel upload to branch: MOI', '2026-06-08 07:02:20'),
(213, 1, 'Bulk upload', 'Added device 5CG7TYTUGJ20 (HP EliteBook 840 G8) via Excel upload to branch: MOI', '2026-06-08 07:02:20'),
(214, 1, 'Bulk upload', 'Added device 5CG7TYTUGJ21 (HP EliteBook 840 G8) via Excel upload to branch: MOI', '2026-06-08 07:02:20'),
(215, 1, 'Bulk upload', 'Added device 5CG7TYTUGJ22 (HP EliteBook 840 G8) via Excel upload to branch: KIMATHI', '2026-06-08 07:02:20'),
(216, 1, 'Bulk upload', 'Added device 5CG7TYTUGJ23 (HP EliteBook 840 G8) via Excel upload to branch: KIMATHI', '2026-06-08 07:02:20'),
(217, 1, 'Bulk upload', 'Added device 5CG7TYTUGJ24 (HP EliteBook 840 G8) via Excel upload to branch: KIMATHI', '2026-06-08 07:02:20'),
(218, 1, 'Bulk upload', 'Added device 5CG7TYTUGJ25 (HP EliteBook 840 G8) via Excel upload to branch: KIMATHI', '2026-06-08 07:02:20'),
(219, 1, 'Bulk upload', 'Added device 5CG7TYTUGJ26 (HP EliteBook 840 G8) via Excel upload to branch: MOI', '2026-06-08 07:02:20'),
(220, 1, 'Bulk upload', 'Added device 5CG7TYTUGJ27 (HP EliteBook 840 G8) via Excel upload to branch: MOI', '2026-06-08 07:02:20'),
(221, 1, 'Bulk upload', 'Added device 5CG7TYTUGJ28 (HP EliteBook 840 G8) via Excel upload to branch: MOI', '2026-06-08 07:02:20'),
(222, 1, 'Bulk upload', 'Added device 5CG7TYTUGJ29 (HP EliteBook 840 G8) via Excel upload to branch: MOI', '2026-06-08 07:02:20'),
(223, 1, 'Bulk upload', 'Added device 5CG7TYTUGJ30 (LENOVO THINKPAD T480s) via Excel upload to branch: MOI', '2026-06-08 07:02:20'),
(224, 1, 'Bulk upload', 'Added device 5CG7TYTUGJ31 (LENOVO THINKPAD T480s) via Excel upload to branch: KIMATHI', '2026-06-08 07:02:20'),
(225, 1, 'Bulk upload', 'Added device 5CG7TYTUGJ32 (LENOVO THINKPAD T480s) via Excel upload to branch: KIMATHI', '2026-06-08 07:02:20'),
(226, 1, 'Bulk upload', 'Added device 5CG7TYTUGJ33 (LENOVO THINKPAD T480s) via Excel upload to branch: KIMATHI', '2026-06-08 07:02:20'),
(227, 1, 'Bulk upload', 'Added device 5CG7TYTUGl6 (HP EliteBook 840 G6) via Excel upload to branch: KIMATHI', '2026-06-08 07:07:34'),
(228, 1, 'Bulk upload', 'Added device 5CG7TYTUGl7 (HP EliteBook 840 G6) via Excel upload to branch: KIMATHI', '2026-06-08 07:07:34'),
(229, 1, 'Bulk upload', 'Added device 5CG7TYTUGl8 (HP EliteBook 840 G6) via Excel upload to branch: KIMATHI', '2026-06-08 07:07:34'),
(230, 1, 'Bulk upload', 'Added device 5CG7TYTUGl9 (HP EliteBook 840 G6) via Excel upload to branch: KIMATHI', '2026-06-08 07:07:34'),
(231, 1, 'Bulk upload', 'Added device 5CG7TYTUGl10 (HP EliteBook 840 G6) via Excel upload to branch: KIMATHI', '2026-06-08 07:07:34'),
(232, 1, 'Bulk upload', 'Added device 5CG7TYTUGl11 (HP EliteBook 840 G6) via Excel upload to branch: KIMATHI', '2026-06-08 07:07:34'),
(233, 1, 'Bulk upload', 'Added device 5CG7TYTUGl12 (HP EliteBook 840 G6) via Excel upload to branch: MOI', '2026-06-08 07:07:34'),
(234, 1, 'Bulk upload', 'Added device 5CG7TYTUGl13 (HP EliteBook 840 G6) via Excel upload to branch: MOI', '2026-06-08 07:07:34'),
(235, 1, 'Bulk upload', 'Added device 5CG7TYTUGl14 (HP EliteBook 840 G6) via Excel upload to branch: MOI', '2026-06-08 07:07:34'),
(236, 1, 'Bulk upload', 'Added device 5CG7TYTUGl15 (HP EliteBook 840 G6) via Excel upload to branch: MOI', '2026-06-08 07:07:34'),
(237, 1, 'Bulk upload', 'Added device 5CG7TYTUGl16 (HP EliteBook 840 G6) via Excel upload to branch: MOI', '2026-06-08 07:07:34'),
(238, 1, 'Bulk upload', 'Added device 5CG7TYTUGl17 (HP EliteBook 840 G8) via Excel upload to branch: MOI', '2026-06-08 07:07:34'),
(239, 1, 'Bulk upload', 'Added device 5CG7TYTUGl18 (HP EliteBook 840 G8) via Excel upload to branch: MOI', '2026-06-08 07:07:34'),
(240, 1, 'Bulk upload', 'Added device 5CG7TYTUGl19 (HP EliteBook 840 G8) via Excel upload to branch: KIMATHI', '2026-06-08 07:07:34'),
(241, 1, 'Bulk upload', 'Added device 5CG7TYTUGl20 (HP EliteBook 840 G8) via Excel upload to branch: KIMATHI', '2026-06-08 07:07:34'),
(242, 1, 'Bulk upload', 'Added device 5CG7TYTUGl21 (HP EliteBook 840 G8) via Excel upload to branch: KIMATHI', '2026-06-08 07:07:34'),
(243, 1, 'Bulk upload', 'Added device 5CG7TYTUGl22 (HP EliteBook 840 G8) via Excel upload to branch: KIMATHI', '2026-06-08 07:07:34'),
(244, 1, 'Bulk upload', 'Added device 5CG7TYTUGl23 (HP EliteBook 840 G8) via Excel upload to branch: MOI', '2026-06-08 07:07:34'),
(245, 1, 'Bulk upload', 'Added device 5CG7TYTUGl24 (HP EliteBook 840 G8) via Excel upload to branch: MOI', '2026-06-08 07:07:35'),
(246, 1, 'Bulk upload', 'Added device 5CG7TYTUGl25 (HP EliteBook 840 G8) via Excel upload to branch: MOI', '2026-06-08 07:07:35'),
(247, 1, 'Bulk upload', 'Added device 5CG7TYTUGl26 (HP EliteBook 840 G8) via Excel upload to branch: MOI', '2026-06-08 07:07:35'),
(248, 1, 'Bulk upload', 'Added device 5CG7TYTUGl27 (LENOVO THINKPAD T480s) via Excel upload to branch: MOI', '2026-06-08 07:07:35'),
(249, 1, 'Bulk upload', 'Added device 5CG7TYTUGl28 (LENOVO THINKPAD T480s) via Excel upload to branch: KIMATHI', '2026-06-08 07:07:35'),
(250, 1, 'Bulk upload', 'Added device 5CG7TYTUGl29 (LENOVO THINKPAD T480s) via Excel upload to branch: KIMATHI', '2026-06-08 07:07:35'),
(251, 1, 'Bulk upload', 'Added device 5CG7TYTUGl30 (LENOVO THINKPAD T480s) via Excel upload to branch: KIMATHI', '2026-06-08 07:07:35'),
(252, 1, 'User Status Change', 'User ID 4 has been activated by Victor Munene', '2026-06-08 09:36:38'),
(253, 1, 'User Status Change', 'User ID 4 has been activated by Victor Munene', '2026-06-08 09:37:20'),
(254, 1, 'User Status Change', 'User ID 4 has been activated by Victor Munene', '2026-06-08 09:40:19'),
(255, 1, 'User Status Change', 'User ID 4 has been restricted by Victor Munene', '2026-06-08 09:46:56'),
(256, 1, 'User Status Change', 'User ID 4 has been activated by Victor Munene', '2026-06-08 09:47:16'),
(257, 7, 'Sold device', 'Sold device SN: 5CG09OZXE37 for KES 0', '2026-06-08 13:13:30'),
(258, 1, 'Bulk upload monitors', 'Uploaded 28 monitors to MOI branch', '2026-06-08 14:52:36'),
(259, 1, 'Transfer device', 'Transferred device SN: 5CG7TYTUGl28 from KIMATHI to MOI (Delivered by: victor)', '2026-06-08 15:32:30'),
(260, 1, 'Transfer chargers', 'Transferred 1 charger type(s) (1 total items) from KIMATHI to MOI: HP Blue Pin 45W (new) x1 (Delivered by: victor)', '2026-06-08 15:34:24'),
(261, 1, 'User Status Change', 'User ID 4 has been restricted by Victor Munene', '2026-06-09 07:58:14'),
(262, 1, 'User Status Change', 'User ID 4 has been activated by Victor Munene', '2026-06-09 08:19:53');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int NOT NULL,
  `category_name` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `category_name`) VALUES
(3, 'AIO'),
(2, 'Desktop'),
(1, 'Laptop'),
(5, 'Mini Pc'),
(4, 'Workstation');

-- --------------------------------------------------------

--
-- Table structure for table `chargers`
--

CREATE TABLE `chargers` (
  `id` int NOT NULL,
  `charger_type` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `watts` int NOT NULL,
  `charger_condition` enum('new','ex_uk') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `quantity` int NOT NULL,
  `branch` enum('KIMATHI','MOI') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `updated_by` int NOT NULL,
  `date_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `chargers`
--

INSERT INTO `chargers` (`id`, `charger_type`, `watts`, `charger_condition`, `quantity`, `branch`, `updated_by`, `date_updated`) VALUES
(9, 'HP Blue Pin', 45, 'new', 6, 'MOI', 1, '2026-06-08 15:34:24'),
(10, 'HP Blue Pin', 65, 'new', 0, 'KIMATHI', 4, '2026-02-21 10:05:22'),
(11, 'HP Blue Pin', 65, 'new', 2, 'MOI', 1, '2026-02-02 07:08:12'),
(12, 'HP Blue Pin', 45, 'new', 3, 'KIMATHI', 1, '2026-06-08 15:34:24');

-- --------------------------------------------------------

--
-- Table structure for table `charger_logs`
--

CREATE TABLE `charger_logs` (
  `id` int NOT NULL,
  `charger_id` int NOT NULL,
  `charger_type` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `watts` int NOT NULL,
  `charger_condition` enum('new','ex_uk') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `quantity` int NOT NULL,
  `given_by` int NOT NULL,
  `given_to` int NOT NULL,
  `action_type` enum('give_out','transfer') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `branch` enum('KIMATHI','MOI') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `date_given` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `charger_logs`
--

INSERT INTO `charger_logs` (`id`, `charger_id`, `charger_type`, `watts`, `charger_condition`, `quantity`, `given_by`, `given_to`, `action_type`, `branch`, `date_given`) VALUES
(11, 10, '', 0, 'new', 3, 8, 7, 'give_out', 'KIMATHI', '2025-12-19 19:35:30'),
(12, 10, '', 0, 'new', 1, 4, 7, 'give_out', 'KIMATHI', '2025-12-20 18:28:20'),
(13, 10, '', 0, 'new', 1, 4, 7, 'give_out', 'KIMATHI', '2026-02-21 10:05:22'),
(14, 12, '', 0, 'new', 1, 4, 7, 'give_out', 'KIMATHI', '2026-03-03 18:32:40');

-- --------------------------------------------------------

--
-- Table structure for table `devices`
--

CREATE TABLE `devices` (
  `serial_number` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `category_id` int NOT NULL,
  `model_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `processor` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `graphics` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT 'None',
  `ram` int DEFAULT NULL,
  `storage_type` enum('SSD','HDD') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT 'SSD',
  `storage_capacity` int DEFAULT NULL,
  `touch` enum('Touch','Non-touch','N/A') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'N/A',
  `status` enum('In Stock','Faulty','Under Repair','Disposed','Sold') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT 'In Stock',
  `device_condition` enum('New','Refurbished') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT 'Refurbished',
  `date_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `added_by` int DEFAULT NULL,
  `branch` enum('KIMATHI','MOI') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `cargo_number` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'NO CARGO',
  `price` decimal(10,2) DEFAULT NULL,
  `price_updated_at` timestamp NULL DEFAULT NULL,
  `category` enum('AIO','Desktop','Laptop','Mini Pc','Workstation') COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `devices`
--

INSERT INTO `devices` (`serial_number`, `category_id`, `model_name`, `processor`, `graphics`, `ram`, `storage_type`, `storage_capacity`, `touch`, `status`, `device_condition`, `date_added`, `added_by`, `branch`, `cargo_number`, `price`, `price_updated_at`, `category`) VALUES
('5CG0302X7Y', 1, 'HP ELITEBOOK 745 G6', 'AMD RYZEN 7 PRO 3700u', '2GB AMD RADEON VEGA 11', 8, 'SSD', 256, 'Non-touch', 'In Stock', 'Refurbished', '2026-03-27 08:32:20', 1, 'MOI', 'AC26', NULL, NULL, NULL),
('5CG09OZXE32', 1, 'HP ELITEBOOK 840 G6', 'INTEL CORE I5-8TH GEN', 'None', 8, 'SSD', 256, 'Touch', 'In Stock', 'Refurbished', '2026-04-02 12:50:27', 1, 'MOI', 'AC16', NULL, NULL, NULL),
('5CG09OZXE33', 1, 'HP ELITEBOOK 840 G6', 'INTEL CORE I5-8TH GEN', 'None', 8, 'SSD', 256, 'Touch', 'In Stock', 'Refurbished', '2026-04-02 12:50:27', 1, 'MOI', 'AC16', NULL, NULL, NULL),
('5CG09OZXE34', 1, 'HP ELITEBOOK 840 G6', 'INTEL CORE I5-8TH GEN', 'None', 8, 'SSD', 256, 'Touch', 'In Stock', 'Refurbished', '2026-04-02 12:50:27', 1, 'MOI', 'AC16', NULL, NULL, NULL),
('5CG09OZXE35', 1, 'HP ELITEBOOK 840 G6', 'INTEL CORE I5-8TH GEN', 'None', 16, 'SSD', 512, 'Non-touch', 'In Stock', 'Refurbished', '2026-04-02 12:50:27', 1, 'MOI', 'AC16', NULL, NULL, NULL),
('5CG09OZXE36', 1, 'HP ELITEBOOK 840 G6', 'INTEL CORE I5-8TH GEN', 'None', 16, 'SSD', 512, 'Non-touch', 'In Stock', 'Refurbished', '2026-04-02 12:50:27', 1, 'KIMATHI', 'AC16', NULL, NULL, NULL),
('5CG09OZXE37', 1, 'HP ELITEBOOK 840 G8', 'INTEL CORE I7-11TH GEN', 'None', 16, 'SSD', 256, 'Touch', 'Sold', 'Refurbished', '2026-04-02 12:50:27', 1, 'KIMATHI', 'AC16', NULL, NULL, NULL),
('5CG09OZXE38', 1, 'HP ELITEBOOK 840 G8', 'INTEL CORE I7-11TH GEN', 'None', 16, 'SSD', 256, 'Touch', 'In Stock', 'Refurbished', '2026-04-02 12:50:27', 1, 'KIMATHI', 'AC16', NULL, NULL, NULL),
('5CG09OZXE39', 1, 'HP ELITEBOOK 840 G8', 'INTEL CORE I7-11TH GEN', 'None', 16, 'SSD', 256, 'Touch', 'In Stock', 'Refurbished', '2026-04-02 12:50:27', 1, 'KIMATHI', 'AC16', NULL, NULL, NULL),
('5CG09OZXE40', 1, 'HP ELITEBOOK 840 G8', 'INTEL CORE I7-11TH GEN', 'None', 8, 'SSD', 512, 'Non-touch', 'Sold', 'Refurbished', '2026-04-02 12:50:27', 1, 'KIMATHI', 'AC16', 60000.00, '2026-04-24 11:26:11', NULL),
('5CG09OZXE41', 1, 'HP ELITEBOOK 840 G8', 'INTEL CORE I7-11TH GEN', 'None', 8, 'SSD', 512, 'Non-touch', 'In Stock', 'Refurbished', '2026-04-02 12:50:27', 1, 'KIMATHI', 'AC16', 60000.00, '2026-04-24 11:26:11', NULL),
('5CG09OZXE42', 1, 'HP ELITEBOOK 840 G8', 'INTEL CORE I7-11TH GEN', 'None', 8, 'SSD', 512, 'Non-touch', 'In Stock', 'Refurbished', '2026-04-02 12:50:27', 1, 'MOI', 'AC16', 60000.00, '2026-04-24 11:26:11', NULL),
('5CG1234XYZ', 1, 'HP EliteBook 840 G6', 'Intel Core i5-8250U', 'Intel UHD Graphics', 8, 'SSD', 256, 'Non-touch', 'In Stock', 'Refurbished', '2026-06-08 07:02:20', 1, 'KIMATHI', 'AC16', NULL, NULL, NULL),
('5CG7TYTUGJ10', 1, 'HP EliteBook 840 G6', 'INTEL CORE I5-8TH GEN', 'None', 8, 'SSD', 256, 'Touch', 'In Stock', 'Refurbished', '2026-06-08 07:02:20', 1, 'KIMATHI', 'AC266', NULL, NULL, NULL),
('5CG7TYTUGJ11', 1, 'HP EliteBook 840 G6', 'INTEL CORE I5-8TH GEN', 'None', 8, 'SSD', 256, 'Touch', 'In Stock', 'Refurbished', '2026-06-08 07:02:20', 1, 'KIMATHI', 'AC266', NULL, NULL, NULL),
('5CG7TYTUGJ12', 1, 'HP EliteBook 840 G6', 'INTEL CORE I5-8TH GEN', 'None', 8, 'SSD', 256, 'Touch', 'In Stock', 'Refurbished', '2026-06-08 07:02:20', 1, 'KIMATHI', 'AC266', NULL, NULL, NULL),
('5CG7TYTUGJ13', 1, 'HP EliteBook 840 G6', 'INTEL CORE I5-8TH GEN', 'None', 8, 'SSD', 256, 'Non-touch', 'In Stock', 'Refurbished', '2026-06-08 07:02:20', 1, 'KIMATHI', 'AC266', NULL, NULL, NULL),
('5CG7TYTUGJ14', 1, 'HP EliteBook 840 G6', 'INTEL CORE I5-8TH GEN', 'None', 16, 'SSD', 256, 'Non-touch', 'In Stock', 'Refurbished', '2026-06-08 07:02:20', 1, 'KIMATHI', 'AC266', NULL, NULL, NULL),
('5CG7TYTUGJ15', 1, 'HP EliteBook 840 G6', 'INTEL CORE I5-8TH GEN', 'None', 16, 'SSD', 512, 'Non-touch', 'In Stock', 'Refurbished', '2026-06-08 07:02:20', 1, 'MOI', 'AC266', 40000.00, '2026-06-08 11:22:30', NULL),
('5CG7TYTUGJ16', 1, 'HP EliteBook 840 G6', 'INTEL CORE I5-8TH GEN', 'None', 16, 'SSD', 512, 'Non-touch', 'In Stock', 'Refurbished', '2026-06-08 07:02:20', 1, 'MOI', 'AC266', 40000.00, '2026-06-08 11:22:30', NULL),
('5CG7TYTUGJ17', 1, 'HP EliteBook 840 G6', 'INTEL CORE I5-8TH GEN', 'None', 16, 'SSD', 512, 'Non-touch', 'In Stock', 'Refurbished', '2026-06-08 07:02:20', 1, 'MOI', 'AC266', 40000.00, '2026-06-08 11:22:30', NULL),
('5CG7TYTUGJ18', 1, 'HP EliteBook 840 G6', 'INTEL CORE I5-8TH GEN', 'None', 16, 'SSD', 512, 'Non-touch', 'In Stock', 'Refurbished', '2026-06-08 07:02:20', 1, 'MOI', 'AC266', 40000.00, '2026-06-08 11:22:30', NULL),
('5CG7TYTUGJ19', 1, 'HP EliteBook 840 G6', 'INTEL CORE I5-8TH GEN', 'None', 16, 'SSD', 512, 'Non-touch', 'In Stock', 'Refurbished', '2026-06-08 07:02:20', 1, 'MOI', 'AC266', 40000.00, '2026-06-08 11:22:30', NULL),
('5CG7TYTUGJ20', 1, 'HP EliteBook 840 G8', 'INTEL CORE I7-11TH GEN', 'None', 16, 'SSD', 512, 'Non-touch', 'In Stock', 'Refurbished', '2026-06-08 07:02:20', 1, 'MOI', 'AC266', NULL, NULL, NULL),
('5CG7TYTUGJ21', 1, 'HP EliteBook 840 G8', 'INTEL CORE I7-11TH GEN', 'None', 16, 'SSD', 512, 'Non-touch', 'In Stock', 'Refurbished', '2026-06-08 07:02:20', 1, 'MOI', 'AC266', NULL, NULL, NULL),
('5CG7TYTUGJ22', 1, 'HP EliteBook 840 G8', 'INTEL CORE I7-11TH GEN', 'None', 16, 'SSD', 512, 'Non-touch', 'In Stock', 'Refurbished', '2026-06-08 07:02:20', 1, 'KIMATHI', 'AC266', NULL, NULL, NULL),
('5CG7TYTUGJ23', 1, 'HP EliteBook 840 G8', 'INTEL CORE I7-11TH GEN', 'None', 16, 'SSD', 256, 'Non-touch', 'In Stock', 'Refurbished', '2026-06-08 07:02:20', 1, 'KIMATHI', 'AC266', NULL, NULL, NULL),
('5CG7TYTUGJ24', 1, 'HP EliteBook 840 G8', 'INTEL CORE I7-11TH GEN', 'None', 16, 'SSD', 256, 'Non-touch', 'In Stock', 'Refurbished', '2026-06-08 07:02:20', 1, 'KIMATHI', 'AC266', NULL, NULL, NULL),
('5CG7TYTUGJ25', 1, 'HP EliteBook 840 G8', 'INTEL CORE I7-11TH GEN', 'None', 8, 'SSD', 256, 'Non-touch', 'In Stock', 'Refurbished', '2026-06-08 07:02:20', 1, 'KIMATHI', 'AC266', NULL, NULL, NULL),
('5CG7TYTUGJ26', 1, 'HP EliteBook 840 G8', 'INTEL CORE I7-11TH GEN', 'None', 8, 'SSD', 256, 'Non-touch', 'In Stock', 'Refurbished', '2026-06-08 07:02:20', 1, 'MOI', 'AC266', NULL, NULL, NULL),
('5CG7TYTUGJ27', 1, 'HP EliteBook 840 G8', 'INTEL CORE I7-11TH GEN', 'None', 8, 'SSD', 256, 'Non-touch', 'In Stock', 'Refurbished', '2026-06-08 07:02:20', 1, 'MOI', 'AC266', NULL, NULL, NULL),
('5CG7TYTUGJ28', 1, 'HP EliteBook 840 G8', 'INTEL CORE I7-11TH GEN', 'None', 8, 'SSD', 256, 'Non-touch', 'In Stock', 'Refurbished', '2026-06-08 07:02:20', 1, 'MOI', 'AC266', NULL, NULL, NULL),
('5CG7TYTUGJ29', 1, 'HP EliteBook 840 G8', 'INTEL CORE I7-8TH GEN', 'None', 8, 'SSD', 256, 'Non-touch', 'In Stock', 'Refurbished', '2026-06-08 07:02:20', 1, 'MOI', 'AC266', NULL, NULL, NULL),
('5CG7TYTUGJ30', 1, 'LENOVO THINKPAD T480s', 'INTEL CORE I7-8TH GEN', 'None', 8, 'SSD', 256, 'Touch', 'In Stock', 'Refurbished', '2026-06-08 07:02:20', 1, 'MOI', 'AC266', NULL, NULL, NULL),
('5CG7TYTUGJ31', 1, 'LENOVO THINKPAD T480s', 'INTEL CORE I7-8TH GEN', 'None', 8, 'SSD', 256, 'Touch', 'In Stock', 'Refurbished', '2026-06-08 07:02:20', 1, 'KIMATHI', 'AC266', NULL, NULL, NULL),
('5CG7TYTUGJ32', 1, 'LENOVO THINKPAD T480s', 'INTEL CORE I7-8TH GEN', 'None', 8, 'SSD', 256, 'Touch', 'In Stock', 'Refurbished', '2026-06-08 07:02:20', 1, 'KIMATHI', 'AC266', NULL, NULL, NULL),
('5CG7TYTUGJ33', 1, 'LENOVO THINKPAD T480s', 'INTEL CORE I7-8TH GEN', 'None', 8, 'SSD', 256, 'Touch', 'In Stock', 'Refurbished', '2026-06-08 07:02:20', 1, 'KIMATHI', 'AC266', NULL, NULL, NULL),
('5CG7TYTUGJ9', 1, 'HP EliteBook 840 G6', 'INTEL CORE I5-8TH GEN', 'None', 8, 'SSD', 256, 'Touch', 'In Stock', 'Refurbished', '2026-06-08 07:02:20', 1, 'KIMATHI', 'AC266', NULL, NULL, NULL),
('5CG7TYTUGl10', 1, 'HP EliteBook 840 G6', 'INTEL CORE I5-8TH GEN', 'None', 8, 'SSD', 256, 'Non-touch', 'In Stock', 'Refurbished', '2026-06-08 07:07:34', 1, 'KIMATHI', 'AC266', NULL, NULL, NULL),
('5CG7TYTUGl11', 1, 'HP EliteBook 840 G6', 'INTEL CORE I5-8TH GEN', 'None', 16, 'SSD', 256, 'Non-touch', 'In Stock', 'Refurbished', '2026-06-08 07:07:34', 1, 'KIMATHI', 'AC266', NULL, NULL, NULL),
('5CG7TYTUGl12', 1, 'HP EliteBook 840 G6', 'INTEL CORE I5-8TH GEN', 'None', 16, 'SSD', 512, 'Non-touch', 'In Stock', 'Refurbished', '2026-06-08 07:07:34', 1, 'MOI', 'AC266', 40000.00, '2026-06-08 11:22:30', NULL),
('5CG7TYTUGl13', 1, 'HP EliteBook 840 G6', 'INTEL CORE I5-8TH GEN', 'None', 16, 'SSD', 512, 'Non-touch', 'In Stock', 'Refurbished', '2026-06-08 07:07:34', 1, 'MOI', 'AC266', 40000.00, '2026-06-08 11:22:30', NULL),
('5CG7TYTUGl14', 1, 'HP EliteBook 840 G6', 'INTEL CORE I5-8TH GEN', 'None', 16, 'SSD', 512, 'Non-touch', 'In Stock', 'Refurbished', '2026-06-08 07:07:34', 1, 'MOI', 'AC266', 40000.00, '2026-06-08 11:22:30', NULL),
('5CG7TYTUGl15', 1, 'HP EliteBook 840 G6', 'INTEL CORE I5-8TH GEN', 'None', 16, 'SSD', 512, 'Non-touch', 'In Stock', 'Refurbished', '2026-06-08 07:07:34', 1, 'MOI', 'AC266', 40000.00, '2026-06-08 11:22:30', NULL),
('5CG7TYTUGl16', 1, 'HP EliteBook 840 G6', 'INTEL CORE I5-8TH GEN', 'None', 16, 'SSD', 512, 'Non-touch', 'In Stock', 'Refurbished', '2026-06-08 07:07:34', 1, 'MOI', 'AC266', 40000.00, '2026-06-08 11:22:30', NULL),
('5CG7TYTUGl17', 1, 'HP EliteBook 840 G8', 'INTEL CORE I7-11TH GEN', 'None', 16, 'SSD', 512, 'Non-touch', 'In Stock', 'Refurbished', '2026-06-08 07:07:34', 1, 'MOI', 'AC266', NULL, NULL, NULL),
('5CG7TYTUGl18', 1, 'HP EliteBook 840 G8', 'INTEL CORE I7-11TH GEN', 'None', 16, 'SSD', 512, 'Non-touch', 'In Stock', 'Refurbished', '2026-06-08 07:07:34', 1, 'MOI', 'AC266', NULL, NULL, NULL),
('5CG7TYTUGl19', 1, 'HP EliteBook 840 G8', 'INTEL CORE I7-11TH GEN', 'None', 16, 'SSD', 512, 'Non-touch', 'In Stock', 'Refurbished', '2026-06-08 07:07:34', 1, 'KIMATHI', 'AC266', NULL, NULL, NULL),
('5CG7TYTUGl20', 1, 'HP EliteBook 840 G8', 'INTEL CORE I7-11TH GEN', 'None', 16, 'SSD', 256, 'Non-touch', 'In Stock', 'Refurbished', '2026-06-08 07:07:34', 1, 'KIMATHI', 'AC266', NULL, NULL, NULL),
('5CG7TYTUGl21', 1, 'HP EliteBook 840 G8', 'INTEL CORE I7-11TH GEN', 'None', 16, 'SSD', 256, 'Non-touch', 'In Stock', 'Refurbished', '2026-06-08 07:07:34', 1, 'KIMATHI', 'AC266', NULL, NULL, NULL),
('5CG7TYTUGl22', 1, 'HP EliteBook 840 G8', 'INTEL CORE I7-11TH GEN', 'None', 8, 'SSD', 256, 'Non-touch', 'In Stock', 'Refurbished', '2026-06-08 07:07:34', 1, 'KIMATHI', 'AC266', NULL, NULL, NULL),
('5CG7TYTUGl23', 1, 'HP EliteBook 840 G8', 'INTEL CORE I7-11TH GEN', 'None', 8, 'SSD', 256, 'Non-touch', 'In Stock', 'Refurbished', '2026-06-08 07:07:34', 1, 'MOI', 'AC266', NULL, NULL, NULL),
('5CG7TYTUGl24', 1, 'HP EliteBook 840 G8', 'INTEL CORE I7-11TH GEN', 'None', 8, 'SSD', 256, 'Non-touch', 'In Stock', 'Refurbished', '2026-06-08 07:07:35', 1, 'MOI', 'AC266', NULL, NULL, NULL),
('5CG7TYTUGl25', 1, 'HP EliteBook 840 G8', 'INTEL CORE I7-11TH GEN', 'None', 8, 'SSD', 256, 'Non-touch', 'In Stock', 'Refurbished', '2026-06-08 07:07:35', 1, 'MOI', 'AC266', NULL, NULL, NULL),
('5CG7TYTUGl26', 1, 'HP EliteBook 840 G8', 'INTEL CORE I7-8TH GEN', 'None', 8, 'SSD', 256, 'Non-touch', 'In Stock', 'Refurbished', '2026-06-08 07:07:35', 1, 'MOI', 'AC266', NULL, NULL, NULL),
('5CG7TYTUGl27', 1, 'LENOVO THINKPAD T480s', 'INTEL CORE I7-8TH GEN', 'None', 8, 'SSD', 256, 'Touch', 'In Stock', 'Refurbished', '2026-06-08 07:07:35', 1, 'MOI', 'AC266', NULL, NULL, NULL),
('5CG7TYTUGl28', 1, 'LENOVO THINKPAD T480s', 'INTEL CORE I7-8TH GEN', 'None', 8, 'SSD', 256, 'Touch', 'In Stock', 'Refurbished', '2026-06-08 07:07:35', 1, 'MOI', 'AC266', NULL, NULL, NULL),
('5CG7TYTUGl29', 1, 'LENOVO THINKPAD T480s', 'INTEL CORE I7-8TH GEN', 'None', 8, 'SSD', 256, 'Touch', 'In Stock', 'Refurbished', '2026-06-08 07:07:35', 1, 'KIMATHI', 'AC266', NULL, NULL, NULL),
('5CG7TYTUGl30', 1, 'LENOVO THINKPAD T480s', 'INTEL CORE I7-8TH GEN', 'None', 8, 'SSD', 256, 'Touch', 'In Stock', 'Refurbished', '2026-06-08 07:07:35', 1, 'KIMATHI', 'AC266', NULL, NULL, NULL),
('5CG7TYTUGl6', 1, 'HP EliteBook 840 G6', 'INTEL CORE I5-8TH GEN', 'None', 8, 'SSD', 256, 'Touch', 'In Stock', 'Refurbished', '2026-06-08 07:07:34', 1, 'KIMATHI', 'AC266', NULL, NULL, NULL),
('5CG7TYTUGl7', 1, 'HP EliteBook 840 G6', 'INTEL CORE I5-8TH GEN', 'None', 8, 'SSD', 256, 'Touch', 'In Stock', 'Refurbished', '2026-06-08 07:07:34', 1, 'KIMATHI', 'AC266', NULL, NULL, NULL),
('5CG7TYTUGl8', 1, 'HP EliteBook 840 G6', 'INTEL CORE I5-8TH GEN', 'None', 8, 'SSD', 256, 'Touch', 'In Stock', 'Refurbished', '2026-06-08 07:07:34', 1, 'KIMATHI', 'AC266', NULL, NULL, NULL),
('5CG7TYTUGl9', 1, 'HP EliteBook 840 G6', 'INTEL CORE I5-8TH GEN', 'None', 8, 'SSD', 256, 'Touch', 'In Stock', 'Refurbished', '2026-06-08 07:07:34', 1, 'KIMATHI', 'AC266', NULL, NULL, NULL),
('5CGBAJJJUU88', 1, 'HP ELITEBOOK 840 G9', 'INTEL CORE I7-12TH GEN', 'None', 16, 'SSD', 509, 'Non-touch', 'In Stock', 'Refurbished', '2026-06-07 10:45:29', 1, 'KIMATHI', 'AC265', NULL, NULL, NULL),
('5CGUYUIJVIUG', 1, 'HP ELITEBOOK 840 G6', 'INTEL CORE I5-8TH GEN', 'None', 16, 'SSD', 256, 'Non-touch', 'In Stock', 'Refurbished', '2026-04-22 20:28:16', 1, 'MOI', 'AC526', 30000.00, '2026-04-22 20:30:56', NULL),
('8CC5678ABC', 2, 'HP EliteDesk 705 G4', 'AMD Ryzen 5 PRO 2600', 'AMD Radeon', 16, 'SSD', 512, 'N/A', 'In Stock', 'New', '2026-06-08 07:02:20', 1, 'MOI', 'CX37', NULL, NULL, NULL),
('8CC6YHMS54', 5, 'HP ELITEDESK 705 G4', 'INTEL CORE I5-8TH GEN', '1GB AMD RADEON R7 200', 8, 'SSD', 256, 'N/A', 'In Stock', 'Refurbished', '2026-04-02 12:50:27', 1, 'KIMATHI', 'AC16', NULL, NULL, NULL),
('8CC6YHMS55', 5, 'HP ELITEDESK 705 G4', 'INTEL CORE I5-8TH GEN', '1GB AMD RADEON R7 200', 8, 'SSD', 256, 'N/A', 'In Stock', 'Refurbished', '2026-04-02 12:50:27', 1, 'KIMATHI', 'AC16', NULL, NULL, NULL),
('8CC6YHMS56', 5, 'HP ELITEDESK 705 G4', 'INTEL CORE I5-8TH GEN', '2GB AMD RADEON R7 200', 8, 'SSD', 256, 'N/A', 'In Stock', 'Refurbished', '2026-04-02 12:50:27', 1, 'MOI', 'AC16', NULL, NULL, NULL),
('8CC6YHMS57', 5, 'HP ELITEDESK 705 G5', 'INTEL CORE I5-8TH GEN', '2GB AMD RADEON R7 200', 16, 'SSD', 128, 'N/A', 'In Stock', 'Refurbished', '2026-04-02 12:50:27', 1, 'MOI', 'AC16', NULL, NULL, NULL),
('8CC6YHMS58', 5, 'HP ELITEDESK 705 G5', 'INTEL CORE I5-8TH GEN', '2GB AMD RADEON R7 200', 16, 'SSD', 128, 'N/A', 'In Stock', 'Refurbished', '2026-04-02 12:50:27', 1, 'MOI', 'AC16', NULL, NULL, NULL),
('ABC9012DEF', 3, 'HP ProOne 400 G5', 'Intel Core i7-8700T', 'Intel UHD', 32, 'SSD', 1000, 'Touch', 'In Stock', 'Refurbished', '2026-06-08 07:02:20', 1, 'KIMATHI', 'AC20', NULL, NULL, NULL),
('MXD90IOOKLW', 2, 'HP ELITEDESK 705 G4', 'AMD RYZEN 5 PRO 2600', '2GB AMD RADEON R7 430', 8, 'HDD', 500, 'N/A', 'Sold', 'Refurbished', '2026-02-21 18:48:48', 1, 'KIMATHI', 'AC3', 15000.00, '2026-03-03 18:24:20', NULL),
('MXHT89YU3', 5, 'HP ELITEDESK 705 G4', 'INTEL CORE I5-7TH GEN', '1GB AMD RADEON VEGA 11', 8, 'SSD', 128, 'N/A', 'In Stock', 'Refurbished', '2025-12-15 18:26:55', 1, 'MOI', 'CX37', 20000.00, '2026-01-02 15:33:05', NULL),
('MXHT89YU4', 5, 'HP ELITEDESK 705 G4', 'INTEL CORE I5-7TH GEN', '1GB AMD RADEON VEGA 11', 8, 'SSD', 128, 'N/A', 'In Stock', 'Refurbished', '2025-12-15 18:26:55', 1, 'KIMATHI', 'CX37', 20000.00, '2026-01-02 15:33:05', NULL),
('MXHT89YU5', 5, 'HP ELITEDESK 705 G4', 'INTEL CORE I5-7TH GEN', '1GB AMD RADEON VEGA 11', 8, 'SSD', 128, 'N/A', 'Sold', 'Refurbished', '2025-12-15 18:26:55', 1, 'KIMATHI', 'CX37', 20000.00, '2026-01-02 15:33:05', NULL),
('MXHT89YU6', 5, 'HP ELITEDESK 705 G4', 'INTEL CORE I5-7TH GEN', '1GB AMD RADEON VEGA 11', 8, 'SSD', 256, 'N/A', 'In Stock', 'Refurbished', '2025-12-15 18:26:55', 1, 'MOI', 'CX37', 20000.00, '2026-01-06 12:21:00', NULL),
('MXHT89YU7', 5, 'HP ELITEDESK 705 G4', 'INTEL CORE I5-7TH GEN', '1GB AMD RADEON VEGA 11', 16, 'SSD', 512, 'N/A', 'In Stock', 'Refurbished', '2025-12-15 18:26:55', 1, 'MOI', 'CX37', 20000.00, '2026-01-06 12:21:00', NULL),
('MXY77HJKAL', 2, 'HP ELITEDESK 705 G4', 'AMD RYZEN 5 PRO 2600', '2GB AMD RADEON R7 430', 8, 'HDD', 500, 'N/A', 'In Stock', 'Refurbished', '2026-02-21 18:46:43', 1, 'KIMATHI', 'AC3', 15000.00, '2026-03-03 18:24:20', NULL),
('TGBHJJRQW1', 2, 'HP ELITEDESK 705 G5', 'INTEL CORE I5-9TH GEN', 'none', 16, 'SSD', 256, 'N/A', 'Sold', 'Refurbished', '2025-12-15 18:26:54', 1, 'KIMATHI', 'CX50', 55000.00, '2026-03-25 21:32:17', NULL),
('TGBHJJRQW2', 2, 'HP ELITEDESK 705 G5', 'INTEL CORE I5-9TH GEN', 'none', 16, 'SSD', 256, 'N/A', 'In Stock', 'Refurbished', '2025-12-15 18:26:54', 1, 'MOI', 'CX50', 55000.00, '2026-03-25 21:32:17', NULL),
('TGBHJJRQW3', 2, 'HP ELITEDESK 705 G5', 'INTEL CORE I5-9TH GEN', 'none', 16, 'SSD', 256, 'N/A', 'In Stock', 'Refurbished', '2025-12-15 18:26:54', 1, 'MOI', 'CX50', 55000.00, '2026-03-25 21:32:17', NULL),
('TGBHJJRQW4', 2, 'HP ELITEDESK 705 G5', 'INTEL CORE I5-9TH GEN', 'None', 16, 'SSD', 256, '', 'In Stock', 'Refurbished', '2025-12-15 18:26:54', 1, 'KIMATHI', 'CX50', 20000.00, '2026-04-22 19:17:24', NULL),
('THK897YYRS4', 4, 'HP Z6 WORKSTATION', 'INTEL XEON E-CPU12 V6', '5GB NVIDIA QUADRO P2000', 32, 'HDD', 2000, 'N/A', 'In Stock', 'Refurbished', '2026-04-02 12:50:27', 1, 'MOI', 'AC16', NULL, NULL, NULL),
('THK897YYRS5', 4, 'HP Z6 WORKSTATION', 'INTEL XEON E-CPU12 V6', '5GB NVIDIA QUADRO P2000', 32, 'HDD', 2000, 'N/A', 'In Stock', 'Refurbished', '2026-04-02 12:50:27', 1, 'MOI', 'AC16', NULL, NULL, NULL),
('THK897YYRS6', 4, 'HP Z6 WORKSTATION', 'INTEL XEON E-CPU12 V6', '5GB NVIDIA QUADRO P2000', 16, 'HDD', 2000, 'N/A', 'In Stock', 'Refurbished', '2026-04-02 12:50:27', 1, 'MOI', 'AC16', NULL, NULL, NULL),
('THK897YYRS7', 4, 'HP Z6 WORKSTATION', 'INTEL XEON E-CPU12 V2', '2GB NVIDIA QUADRO P1000', 32, 'HDD', 2000, 'N/A', 'In Stock', 'Refurbished', '2026-04-02 12:50:27', 1, 'MOI', 'AC16', NULL, NULL, NULL),
('THK897YYRS8', 4, 'HP Z6 WORKSTATION', 'INTEL XEON E-CPU12 V2', '2GB NVIDIA QUADRO P1000', 32, 'HDD', 1000, 'N/A', 'In Stock', 'Refurbished', '2026-04-02 12:50:27', 1, 'KIMATHI', 'AC16', NULL, NULL, NULL),
('THK897YYRS9', 4, 'HP Z6 WORKSTATION', 'INTEL XEON E-CPU12 V2', '2GB NVIDIA QUADRO P1000', 16, 'HDD', 1000, 'N/A', 'In Stock', 'Refurbished', '2026-04-02 12:50:27', 1, 'KIMATHI', 'AC16', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `device_updates`
--

CREATE TABLE `device_updates` (
  `id` int NOT NULL,
  `serial_number` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `updated_by` int DEFAULT NULL,
  `action` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `old_value` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `new_value` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `device_updates`
--

INSERT INTO `device_updates` (`id`, `serial_number`, `updated_by`, `action`, `old_value`, `new_value`, `updated_at`) VALUES
(1, '5CGHJJB36', 8, 'edit', 'Sold', 'Sold', '2025-12-06 21:51:27'),
(4, '5CGHJJR47', 1, 'edit', 'In Stock', 'In Stock', '2025-12-07 16:30:24'),
(5, '1234', NULL, 'edit', 'In Stock', 'In Stock', '2025-12-15 13:48:55');

-- --------------------------------------------------------

--
-- Table structure for table `maintenance`
--

CREATE TABLE `maintenance` (
  `id` int NOT NULL,
  `device_serial` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `old_ram` int DEFAULT NULL,
  `new_ram` int DEFAULT NULL,
  `old_storage` int DEFAULT NULL,
  `new_storage` int DEFAULT NULL,
  `performed_by` int DEFAULT NULL,
  `notes` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `date_performed` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `old_graphics` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `new_graphics` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `maintenance`
--

INSERT INTO `maintenance` (`id`, `device_serial`, `old_ram`, `new_ram`, `old_storage`, `new_storage`, `performed_by`, `notes`, `date_performed`, `old_graphics`, `new_graphics`) VALUES
(1, 'GH677HG7U', 16, 16, 512, 256, 4, NULL, '2025-12-03 15:20:41', 'none', 'none'),
(2, '5CGHJJ80', 8, 16, 1000, 256, 4, NULL, '2025-12-07 13:59:28', 'none', 'none'),
(5, 'THG67J102', 16, 8, 256, 500, 4, NULL, '2025-12-07 15:44:16', '2GB AMD RADEON R7 200', '2GB AMD RADEON R7 200'),
(6, 'TGBHJJRQW4', 16, 8, 256, 500, 4, NULL, '2025-12-20 18:32:33', 'none', '2GB AMD RADEON R7 200'),
(7, 'MXHT89YU7', 8, 16, 256, 512, 4, 'UPGRADED RAM AND SSD FOR SHUNZA', '2026-03-03 18:36:38', '1GB AMD RADEON VEGA 11', '1GB AMD RADEON VEGA 11');

-- --------------------------------------------------------

--
-- Table structure for table `monitors`
--

CREATE TABLE `monitors` (
  `serial_number` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `model_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `size_inches` int NOT NULL,
  `status` enum('In Stock','Sold') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT 'In Stock',
  `branch` enum('KIMATHI','MOI') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `added_by` int DEFAULT NULL,
  `date_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `sold_by` int DEFAULT NULL,
  `sold_at` timestamp NULL DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `printers`
--

CREATE TABLE `printers` (
  `serial_number` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `model_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `branch` enum('KIMATHI','MOI') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `status` enum('In Stock','Sold') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT 'In Stock',
  `added_by` int DEFAULT NULL,
  `sold_by` int DEFAULT NULL,
  `date_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_sold` timestamp NULL DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `printers`
--

INSERT INTO `printers` (`serial_number`, `model_name`, `branch`, `status`, `added_by`, `sold_by`, `date_added`, `date_sold`, `price`) VALUES
('PH78IIOG', 'EPSON', 'KIMATHI', 'In Stock', 1, NULL, '2025-12-14 14:05:41', NULL, NULL),
('PTNJGGDHH10', 'EPSON PRINTER', 'KIMATHI', 'Sold', 1, 7, '2025-12-14 18:46:38', '2025-12-15 05:38:17', NULL),
('PTNJGGDHH11', 'EPSON PRINTER', 'KIMATHI', 'In Stock', 1, NULL, '2025-12-14 18:46:38', NULL, NULL),
('PTNJGGDHH8', 'EPSON PRINTER', 'KIMATHI', 'In Stock', 1, NULL, '2025-12-14 18:46:38', NULL, NULL),
('PTNJGGDHH9', 'EPSON PRINTER', 'KIMATHI', 'In Stock', 1, NULL, '2025-12-14 18:46:38', NULL, NULL),
('TH5JJ897D', 'MECER PRINTER', 'KIMATHI', 'In Stock', 1, NULL, '2025-12-16 13:39:53', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `rams_ssds`
--

CREATE TABLE `rams_ssds` (
  `id` int NOT NULL,
  `category` enum('RAM','SSD') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `type` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `quantity` int NOT NULL,
  `branch` enum('KIMATHI','MOI') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `updated_by` int NOT NULL,
  `date_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `storage` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rams_ssds`
--

INSERT INTO `rams_ssds` (`id`, `category`, `type`, `quantity`, `branch`, `updated_by`, `date_updated`, `storage`) VALUES
(6, 'SSD', 'SATA', 7, 'KIMATHI', 1, '2025-12-29 20:46:01', 512),
(7, 'RAM', 'DDR3', 0, 'KIMATHI', 1, '2026-01-22 11:32:46', 16),
(8, 'SSD', 'SATA', 14, 'MOI', 1, '2025-12-29 20:46:01', 512),
(9, 'RAM', 'PC4', 8, 'KIMATHI', 1, '2025-12-29 20:46:01', 16),
(10, 'RAM', 'PC4', 4, 'KIMATHI', 1, '2026-03-28 06:34:30', 8),
(11, 'RAM', 'DDR3', 18, 'MOI', 14, '2026-03-17 11:28:24', 16),
(12, 'RAM', 'PC4', 6, 'MOI', 1, '2025-12-29 20:46:01', 16),
(13, 'RAM', 'PC4', 1, 'MOI', 1, '2026-03-28 06:34:30', 8);

-- --------------------------------------------------------

--
-- Table structure for table `rams_ssds_logs`
--

CREATE TABLE `rams_ssds_logs` (
  `id` int NOT NULL,
  `ram_ssd_id` int NOT NULL,
  `category` enum('RAM','SSD') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `type` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `quantity_given` int NOT NULL,
  `given_to` int NOT NULL,
  `given_by` int NOT NULL,
  `branch` enum('KIMATHI','MOI') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `date_given` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `storage` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rams_ssds_logs`
--

INSERT INTO `rams_ssds_logs` (`id`, `ram_ssd_id`, `category`, `type`, `quantity_given`, `given_to`, `given_by`, `branch`, `date_given`, `storage`) VALUES
(1, 6, 'SSD', 'SATA', 5, 7, 8, 'KIMATHI', '2025-12-06 22:00:25', 512),
(2, 6, 'SSD', 'SATA', 1, 7, 1, 'KIMATHI', '2025-12-07 15:54:41', 512),
(3, 6, 'SSD', 'SATA', 2, 7, 1, 'KIMATHI', '2025-12-09 05:28:43', 512),
(4, 7, 'RAM', 'DDR3', 1, 7, 1, 'KIMATHI', '2025-12-15 18:41:23', 16),
(5, 6, 'SSD', 'SATA', 2, 7, 8, 'KIMATHI', '2025-12-28 14:17:01', 512);

-- --------------------------------------------------------

--
-- Table structure for table `registration_codes`
--

CREATE TABLE `registration_codes` (
  `id` int NOT NULL,
  `code` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `role` enum('super_admin','inventory_admin','technician','software','sales','manager') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_by` int DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `is_used` tinyint(1) DEFAULT '0',
  `used_by` int DEFAULT NULL,
  `used_at` timestamp NULL DEFAULT NULL,
  `expiry` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `registration_codes`
--

INSERT INTO `registration_codes` (`id`, `code`, `email`, `role`, `created_by`, `created_at`, `is_used`, `used_by`, `used_at`, `expiry`) VALUES
(1, '167835', 'victormunene207@gmail.com', 'manager', 1, '2026-04-14 20:06:17', 0, NULL, NULL, NULL),
(4, '297144', 'vdebmunene207@gmail.com', 'manager', 1, '2026-04-22 19:52:46', 1, NULL, NULL, '2026-04-22 23:11:43'),
(5, '922516', 'vdebmunene207@gmail.com', 'manager', 1, '2026-06-08 10:17:40', 0, NULL, NULL, '2026-06-08 13:37:36');

-- --------------------------------------------------------

--
-- Table structure for table `repairs`
--

CREATE TABLE `repairs` (
  `id` int NOT NULL,
  `serial_number` varchar(255) NOT NULL,
  `problem_description` text NOT NULL,
  `added_by` int NOT NULL,
  `given_by` int NOT NULL,
  `branch` enum('KIMATHI','MOI') NOT NULL,
  `fix_status` enum('Not Fixed','Fixed') DEFAULT 'Not Fixed',
  `date_added` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `date_fixed` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `repairs`
--

INSERT INTO `repairs` (`id`, `serial_number`, `problem_description`, `added_by`, `given_by`, `branch`, `fix_status`, `date_added`, `date_fixed`) VALUES
(1, 'TGBHJJRQW4', 'Faulty keyboard', 4, 1, 'KIMATHI', 'Fixed', '2025-12-16 21:34:43', '2025-12-16 21:35:25'),
(2, '5CG09OPL34', 'faulty keyboard', 16, 1, 'KIMATHI', 'Fixed', '2025-12-18 05:16:11', '2025-12-18 05:16:32'),
(3, 'MXHT89YU7', 'Faulty keyboard', 14, 8, 'MOI', 'Fixed', '2026-01-02 16:00:33', '2026-01-02 16:00:54'),
(4, 'MXHT89YU7', 'Speaker issue', 14, 8, 'MOI', 'Fixed', '2026-01-02 16:30:36', '2026-01-02 16:31:10'),
(5, 'MXFGHGFH', 'FAULTY KEYBOARD', 4, 1, 'KIMATHI', 'Fixed', '2026-03-03 18:44:11', '2026-03-03 18:45:10');

-- --------------------------------------------------------

--
-- Table structure for table `sold_devices`
--

CREATE TABLE `sold_devices` (
  `id` int NOT NULL,
  `serial_number` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `category_id` int NOT NULL,
  `model_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `processor` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `graphics` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `ram` int DEFAULT NULL,
  `storage_type` enum('SSD','HDD') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `storage_capacity` int DEFAULT NULL,
  `touch` enum('Touch','Non-touch') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `device_condition` enum('New','Refurbished') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `sold_by` int NOT NULL,
  `sold_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `price` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sold_devices`
--

INSERT INTO `sold_devices` (`id`, `serial_number`, `category_id`, `model_name`, `processor`, `graphics`, `ram`, `storage_type`, `storage_capacity`, `touch`, `device_condition`, `sold_by`, `sold_at`, `price`) VALUES
(1, '5CG09OPL37', 1, 'HP ELITEDESK 840 G6', 'INTEL CORE I5-8TH GEN', 'none', 8, 'SSD', 256, 'Non-touch', 'Refurbished', 7, '2025-12-16 12:45:12', 25000.00),
(2, '5CG09OPL34', 1, 'HP ELITEDESK 840 G6', 'INTEL CORE I5-8TH GEN', 'none', 8, 'SSD', 256, 'Non-touch', 'Refurbished', 7, '2025-12-18 05:17:46', 25000.00),
(3, 'MXHT89YU5', 5, 'HP ELITEDESK 705 G4', 'INTEL CORE I5-7TH GEN', '1GB AMD RADEON VEGA 11', 8, 'SSD', 128, '', 'Refurbished', 7, '2026-01-02 15:37:57', 20000.00),
(4, 'MXD90IOOKLW', 2, 'HP ELITEDESK 705 G4', 'AMD RYZEN 5 PRO 2600', '2GB AMD RADEON R7 430', 8, 'HDD', 500, '', 'Refurbished', 7, '2026-03-03 18:24:35', 15000.00),
(5, 'TGBHJJRQW1', 2, 'HP ELITEDESK 705 G5', 'INTEL CORE I5-9TH GEN', 'none', 16, 'SSD', 256, '', 'Refurbished', 7, '2026-03-08 10:01:45', 40000.00),
(6, '5CG09OZXE40', 1, 'HP ELITEBOOK 840 G8', 'INTEL CORE I7-11TH GEN', 'None', 8, 'SSD', 512, 'Non-touch', 'Refurbished', 7, '2026-06-07 13:55:36', 60000.00),
(7, '5CG09OZXE37', 1, 'HP ELITEBOOK 840 G8', 'INTEL CORE I7-11TH GEN', 'None', 16, 'SSD', 256, 'Touch', 'Refurbished', 7, '2026-06-08 13:13:30', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `username` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `role` enum('super_admin','inventory_admin','technician','maintenance','sales','manager','cashier','software') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `is_active` tinyint(1) DEFAULT '1',
  `full_name` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_login` timestamp NULL DEFAULT NULL,
  `branch` enum('KIMATHI','MOI') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `failed_attempts` int DEFAULT '0',
  `account_locked_until` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `username`, `password`, `role`, `is_active`, `full_name`, `created_at`, `last_login`, `branch`, `failed_attempts`, `account_locked_until`) VALUES
(1, 'victormunene207@gmail.com', 'vic', '$2a$12$q5sPMKAfYhS0AMXRm6BpI.W7flz8n0wmcUbBJ45BAnOa8BsxgYKSK', 'super_admin', 1, 'Victor Munene', '2025-12-03 11:42:31', '2026-06-09 13:04:20', 'KIMATHI', 0, NULL),
(4, 'munene@gmail.com', 'Vdeb', '$2y$10$m9PnQbD9v1ZY50s14T45MOV2n4bdaty74/2Y8rBlOuRY56.4OdlGi', 'inventory_admin', 1, 'Munene vicky', '2025-12-03 12:39:40', '2026-06-08 15:44:28', 'KIMATHI', 0, NULL),
(7, 'peninahkalundi@gmail.com', 'pesh', '$2y$10$cS2ZivexM3srJGrkihxPnumRp0RNDgdHDTX8bkGuUXphAbd9ZJSc.', 'sales', 1, 'Peninah Kalundi', '2025-12-04 18:01:17', '2026-06-08 13:12:30', 'KIMATHI', 0, NULL),
(8, 'munene23.v@student.cuk.ac.ke', 'syovata', '$2a$12$/oCyXfWfYl2BAGQNnIGd3O9ZKnXmtYHWhJEggocVdP9X/4bC.CsMK', 'inventory_admin', 1, 'Victor Syovata', '2025-12-05 22:19:21', '2026-03-17 12:08:41', 'KIMATHI', 2, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `category_name` (`category_name`);

--
-- Indexes for table `chargers`
--
ALTER TABLE `chargers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `updated_by` (`updated_by`);

--
-- Indexes for table `charger_logs`
--
ALTER TABLE `charger_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `given_by` (`given_by`),
  ADD KEY `given_to` (`given_to`);

--
-- Indexes for table `devices`
--
ALTER TABLE `devices`
  ADD PRIMARY KEY (`serial_number`),
  ADD UNIQUE KEY `serial_number` (`serial_number`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `added_by` (`added_by`);

--
-- Indexes for table `device_updates`
--
ALTER TABLE `device_updates`
  ADD PRIMARY KEY (`id`),
  ADD KEY `serial_number` (`serial_number`),
  ADD KEY `updated_by` (`updated_by`);

--
-- Indexes for table `maintenance`
--
ALTER TABLE `maintenance`
  ADD PRIMARY KEY (`id`),
  ADD KEY `device_serial` (`device_serial`),
  ADD KEY `performed_by` (`performed_by`);

--
-- Indexes for table `monitors`
--
ALTER TABLE `monitors`
  ADD PRIMARY KEY (`serial_number`),
  ADD KEY `added_by` (`added_by`),
  ADD KEY `sold_by` (`sold_by`);

--
-- Indexes for table `printers`
--
ALTER TABLE `printers`
  ADD PRIMARY KEY (`serial_number`),
  ADD KEY `added_by` (`added_by`),
  ADD KEY `sold_by` (`sold_by`);

--
-- Indexes for table `rams_ssds`
--
ALTER TABLE `rams_ssds`
  ADD PRIMARY KEY (`id`),
  ADD KEY `updated_by` (`updated_by`);

--
-- Indexes for table `rams_ssds_logs`
--
ALTER TABLE `rams_ssds_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ram_ssd_id` (`ram_ssd_id`),
  ADD KEY `given_to` (`given_to`),
  ADD KEY `given_by` (`given_by`);

--
-- Indexes for table `registration_codes`
--
ALTER TABLE `registration_codes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `used_by` (`used_by`);

--
-- Indexes for table `repairs`
--
ALTER TABLE `repairs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `serial_number` (`serial_number`),
  ADD KEY `added_by` (`added_by`),
  ADD KEY `given_by` (`given_by`);

--
-- Indexes for table `sold_devices`
--
ALTER TABLE `sold_devices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sold_by` (`sold_by`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity_logs`
--
ALTER TABLE `activity_logs`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=263;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `chargers`
--
ALTER TABLE `chargers`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `charger_logs`
--
ALTER TABLE `charger_logs`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `device_updates`
--
ALTER TABLE `device_updates`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `maintenance`
--
ALTER TABLE `maintenance`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `rams_ssds`
--
ALTER TABLE `rams_ssds`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `rams_ssds_logs`
--
ALTER TABLE `rams_ssds_logs`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `registration_codes`
--
ALTER TABLE `registration_codes`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `repairs`
--
ALTER TABLE `repairs`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `sold_devices`
--
ALTER TABLE `sold_devices`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD CONSTRAINT `activity_logs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `chargers`
--
ALTER TABLE `chargers`
  ADD CONSTRAINT `chargers_ibfk_1` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `charger_logs`
--
ALTER TABLE `charger_logs`
  ADD CONSTRAINT `charger_logs_ibfk_1` FOREIGN KEY (`given_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `charger_logs_ibfk_2` FOREIGN KEY (`given_to`) REFERENCES `users` (`id`);

--
-- Constraints for table `devices`
--
ALTER TABLE `devices`
  ADD CONSTRAINT `devices_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`),
  ADD CONSTRAINT `devices_ibfk_2` FOREIGN KEY (`added_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
