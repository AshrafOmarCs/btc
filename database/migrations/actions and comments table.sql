-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jun 26, 2024 at 09:05 AM
-- Server version: 8.3.0
-- PHP Version: 8.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `btc`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_actions`
--

DROP TABLE IF EXISTS `tbl_actions`;
CREATE TABLE IF NOT EXISTS `tbl_actions` (
  `id` int NOT NULL AUTO_INCREMENT,
  `table_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ids` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jahiz_ids` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `period` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `module` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `prof_file` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'Active',
  `created_at` datetime DEFAULT NULL,
  `created_by` int DEFAULT NULL,
  `priority` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'High',
  `assign_ids` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_by` int DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_actions`
--

INSERT INTO `tbl_actions` (`id`, `table_name`, `ids`, `jahiz_ids`, `period`, `module`, `description`, `prof_file`, `status`, `created_at`, `created_by`, `priority`, `assign_ids`, `updated_by`, `updated_at`) VALUES
(2, 'drivers_saned_settlement', '89256,89096,89099', '25744,25548,25539', '01/04/2024 - 01/05/2024', 'Drivers Saned Settlement', NULL, '1714650794.png', 'Closed', '2024-05-02 14:53:14', 73, 'Medium', NULL, 73, '2024-06-24 16:49:37'),
(3, 'drivers_saned_settlement', '89256,89096,89099', '25744,25548,25539', '01/04/2024 - 01/05/2024', 'Drivers Saned Settlement', NULL, '1714650794.png', 'Active', '2024-05-02 14:53:14', 73, 'Medium', NULL, 73, '2024-06-24 16:48:14'),
(4, NULL, NULL, NULL, NULL, 'test2', '123', NULL, 'Active', '2024-06-24 12:30:36', 73, 'Medium', '73,110,', 73, '2024-06-24 16:50:02'),
(5, NULL, NULL, NULL, NULL, 'test1', 'test description', NULL, 'Active', '2024-06-24 15:39:24', 73, 'Medium', '69,100,51,', 73, '2024-06-24 16:58:03'),
(6, NULL, NULL, NULL, NULL, 'test', '123', NULL, 'Closed', '2024-06-24 16:32:34', 73, 'Low', '69,100,51,', 73, '2024-06-24 16:36:30'),
(7, NULL, NULL, NULL, NULL, 'Final Testing', 'Final Ticket', NULL, 'Closed', '2024-06-24 17:27:56', 73, 'High', '73,', 73, '2024-06-26 11:46:00'),
(8, 'drivers_saned_settlement', '89445,84488', '25914,21322', '01/10/2023 - 31/05/2024', 'Drivers Saned Settlement', NULL, '1719299551.png', 'Active', '2024-06-25 10:12:31', 73, 'High', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_actions_comments`
--

DROP TABLE IF EXISTS `tbl_actions_comments`;
CREATE TABLE IF NOT EXISTS `tbl_actions_comments` (
  `id` int NOT NULL AUTO_INCREMENT,
  `action_id` int NOT NULL,
  `comment` text COLLATE utf8mb4_unicode_ci,
  `created_at` datetime DEFAULT NULL,
  `created_by` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_actions_comments`
--

INSERT INTO `tbl_actions_comments` (`id`, `action_id`, `comment`, `created_at`, `created_by`) VALUES
(1, 7, 'What\'s going on', '2024-06-25 15:56:59', 73),
(2, 7, 'Nothing Special', '2024-06-25 16:10:33', 73),
(3, 7, 'Oh! Okay', '2024-06-25 16:24:49', 2),
(5, 7, 'Final comment before closing the ticket.', '2024-06-25 16:33:40', 73),
(6, 6, 'aaddss', '2024-06-26 10:14:22', 73);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
