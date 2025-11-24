-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 25, 2025 at 08:40 AM
-- Server version: 10.4.19-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_kakamaa`
--

-- --------------------------------------------------------

--
-- Table structure for table `kb_areas`
--

CREATE TABLE `kb_areas` (
  `id` int(11) NOT NULL,
  `state_id` int(11) NOT NULL,
  `district_id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `added_on` datetime NOT NULL,
  `updated_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `kb_banks`
--

CREATE TABLE `kb_banks` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `kb_banks`
--

INSERT INTO `kb_banks` (`id`, `name`) VALUES
(47, 'airtel payment bank'),
(1, 'Allahabad Bank'),
(2, 'Andhra Bank'),
(3, 'Axis Bank'),
(4, 'Bandhan Bank'),
(5, 'Bank of Baroda'),
(6, 'Bank of India'),
(7, 'Bank of Maharashtra'),
(8, 'Canara Bank'),
(9, 'Catholic Syrian Bank'),
(10, 'Central Bank of India'),
(43, 'Chhattisgarh Rajya Gramin Bank'),
(11, 'City Union Bank'),
(12, 'Corporation Bank'),
(13, 'DCB Bank'),
(14, 'Dena Bank'),
(15, 'Dhanlaxmi Bank'),
(16, 'Federal Bank'),
(46, 'Fino payment Bank'),
(17, 'HDFC Bank'),
(18, 'ICICI Bank'),
(19, 'IDBI Bank'),
(20, 'IDFC Bank'),
(45, 'india post payment bank'),
(21, 'Indian Bank'),
(22, 'Indian Overseas Bank'),
(23, 'IndusInd Bank'),
(24, 'Jammu and Kashmir Bank'),
(25, 'Karnataka Bank'),
(26, 'Karur Vysya Bank'),
(44, 'Kerala Gramin Bank'),
(27, 'Kotak Mahindra Bank'),
(28, 'Lakshmi Vilas Bank'),
(29, 'Nainital Bank'),
(30, 'Oriental Bank of Commerce'),
(31, 'Punjab & Sindh Bank'),
(32, 'Punjab National Bank'),
(33, 'RBL Bank'),
(34, 'South Indian Bank'),
(35, 'State Bank of India'),
(36, 'Syndicate Bank'),
(37, 'Tamilnad Mercantile Bank'),
(38, 'UCO Bank'),
(39, 'Union Bank of India'),
(40, 'United Bank of India'),
(41, 'Vijaya Bank'),
(42, 'YES Bank');

-- --------------------------------------------------------

--
-- Table structure for table `kb_brands`
--

CREATE TABLE `kb_brands` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `kb_db_operations`
--

CREATE TABLE `kb_db_operations` (
  `id` int(11) NOT NULL,
  `operation` varchar(50) NOT NULL,
  `table_name` varchar(100) NOT NULL,
  `primary_key` varchar(255) NOT NULL,
  `data` text NOT NULL,
  `ref` varchar(100) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `added_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `kb_districts`
--

CREATE TABLE `kb_districts` (
  `id` int(11) NOT NULL,
  `state_id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `added_on` datetime NOT NULL,
  `updated_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `kb_finance_companies`
--

CREATE TABLE `kb_finance_companies` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `kb_states`
--

CREATE TABLE `kb_states` (
  `id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `added_on` datetime NOT NULL,
  `updated_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `kb_users`
--

CREATE TABLE `kb_users` (
  `id` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `mobile` varchar(10) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `vp` varchar(50) NOT NULL,
  `role` varchar(20) NOT NULL,
  `salt` varchar(20) NOT NULL,
  `otp` varchar(100) NOT NULL,
  `token` varchar(50) NOT NULL,
  `photo` varchar(100) NOT NULL,
  `language_id` int(11) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `created_on` datetime NOT NULL,
  `updated_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `kb_users`
--

INSERT INTO `kb_users` (`id`, `username`, `mobile`, `name`, `email`, `password`, `vp`, `role`, `salt`, `otp`, `token`, `photo`, `language_id`, `status`, `created_on`, `updated_on`) VALUES
(1, 'admin', '0987654321', 'Admin', 'admin@gmail.com', '$2y$10$GmLo6Af3sbvS1D/TbUw7xeS.0n.znB81bmO4InABMAOhr98mOVnqy', '12345', 'admin', '6nMwd04UhZ3YvsJx', '', '', '', NULL, 1, '2024-09-19 12:52:30', '2025-09-25 12:09:42');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `kb_areas`
--
ALTER TABLE `kb_areas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kb_banks`
--
ALTER TABLE `kb_banks`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `kb_brands`
--
ALTER TABLE `kb_brands`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `kb_db_operations`
--
ALTER TABLE `kb_db_operations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kb_districts`
--
ALTER TABLE `kb_districts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kb_finance_companies`
--
ALTER TABLE `kb_finance_companies`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `kb_states`
--
ALTER TABLE `kb_states`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kb_users`
--
ALTER TABLE `kb_users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `kb_areas`
--
ALTER TABLE `kb_areas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kb_banks`
--
ALTER TABLE `kb_banks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `kb_brands`
--
ALTER TABLE `kb_brands`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kb_db_operations`
--
ALTER TABLE `kb_db_operations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kb_districts`
--
ALTER TABLE `kb_districts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kb_finance_companies`
--
ALTER TABLE `kb_finance_companies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kb_states`
--
ALTER TABLE `kb_states`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kb_users`
--
ALTER TABLE `kb_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
