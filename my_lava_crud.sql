-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Nov 25, 2024 at 11:35 AM
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
-- Database: `my_lava_crud`
--

-- --------------------------------------------------------

--
-- Table structure for table `jmc_users`
--

DROP TABLE IF EXISTS `jmc_users`;
CREATE TABLE IF NOT EXISTS `jmc_users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `jmc_last_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `jmc_first_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `jmc_email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `jmc_gender` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `jmc_address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jmc_users`
--

INSERT INTO `jmc_users` (`id`, `jmc_last_name`, `jmc_first_name`, `jmc_email`, `jmc_gender`, `jmc_address`) VALUES
(1, 'Carpio', 'John Ray', 'johnraycarpio1404@gmail.com', 'Male', 'Malvar'),
(4, 'Rudavia ', 'Benedict', 'bene@gmail.com', 'Male', 'Barcenaga'),
(5, 'Ulip', 'Carl', 'carl@gmail.com', 'Male', 'Bucayao'),
(6, 'Festin', 'Jeremy', 'jeremy@gmail.com', 'Male', 'Pachoka'),
(7, 'Pandapatan', 'Yasser', 'yasser@gmail.com', 'Male', 'Aroma'),
(8, 'Pacia', 'Rio Renz', 'pacia@gmail.com', 'Male', 'Pinamalayan');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
