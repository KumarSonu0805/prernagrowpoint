-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 28, 2025 at 11:26 AM
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
-- Database: `db_prerna`
--

-- --------------------------------------------------------

--
-- Table structure for table `pg_acc_details`
--

CREATE TABLE `pg_acc_details` (
  `id` int(11) NOT NULL,
  `regid` int(11) NOT NULL,
  `bank` varchar(50) NOT NULL,
  `branch` varchar(50) NOT NULL,
  `city` varchar(50) NOT NULL,
  `account_no` varchar(50) NOT NULL,
  `account_name` varchar(100) NOT NULL,
  `ifsc` varchar(11) NOT NULL,
  `micr` varchar(30) NOT NULL,
  `aadhar1` varchar(100) NOT NULL,
  `aadhar2` varchar(100) NOT NULL,
  `pan` varchar(100) NOT NULL,
  `cheque` varchar(100) NOT NULL,
  `kyc` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pg_acc_details`
--


-- --------------------------------------------------------

--
-- Table structure for table `pg_banks`
--

CREATE TABLE `pg_banks` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pg_banks`
--

INSERT INTO `pg_banks` (`id`, `name`) VALUES
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
(11, 'City Union Bank'),
(12, 'Corporation Bank'),
(13, 'DCB Bank'),
(14, 'Dena Bank'),
(15, 'Dhanlaxmi Bank'),
(16, 'Federal Bank'),
(17, 'HDFC Bank'),
(18, 'ICICI Bank'),
(19, 'IDBI Bank'),
(20, 'IDFC Bank'),
(21, 'Indian Bank'),
(22, 'Indian Overseas Bank'),
(23, 'IndusInd Bank'),
(24, 'Jammu and Kashmir Bank'),
(25, 'Karnataka Bank'),
(26, 'Karur Vysya Bank'),
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
-- Table structure for table `pg_deposits`
--

CREATE TABLE `pg_deposits` (
  `id` int(11) NOT NULL,
  `date` date NOT NULL,
  `type` varchar(10) NOT NULL,
  `ref_id` int(11) NOT NULL,
  `trans_type` varchar(20) NOT NULL,
  `regid` int(11) NOT NULL,
  `to_regid` int(11) NOT NULL DEFAULT 1,
  `amount` float NOT NULL,
  `details` varchar(200) NOT NULL,
  `image` varchar(200) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `complete` tinyint(1) NOT NULL DEFAULT 0,
  `approved_on` datetime DEFAULT NULL,
  `added_on` datetime NOT NULL,
  `updated_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `pg_level_members`
--

CREATE TABLE `pg_level_members` (
  `id` int(11) NOT NULL,
  `regid` int(11) NOT NULL,
  `level_id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL,
  `added_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pg_members`
--

CREATE TABLE `pg_members` (
  `id` int(11) NOT NULL,
  `epin` varchar(20) NOT NULL,
  `name` varchar(100) NOT NULL,
  `dob` date NOT NULL,
  `father` varchar(100) NOT NULL,
  `occupation` varchar(100) NOT NULL,
  `gender` varchar(6) NOT NULL,
  `mstatus` varchar(10) NOT NULL,
  `mobile` varchar(10) NOT NULL,
  `email` varchar(50) NOT NULL,
  `aadhar` varchar(12) NOT NULL,
  `pan` varchar(10) NOT NULL,
  `address` varchar(255) NOT NULL,
  `district` varchar(30) NOT NULL,
  `state` varchar(30) NOT NULL,
  `country` varchar(50) NOT NULL,
  `pincode` varchar(6) NOT NULL,
  `photo` varchar(200) NOT NULL,
  `regid` int(11) NOT NULL,
  `refid` int(11) NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `package_id` int(11) NOT NULL,
  `activation_date` date NOT NULL,
  `status` int(11) NOT NULL,
  `franchise` tinyint(1) NOT NULL DEFAULT 0,
  `added_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pg_members`
--

-- --------------------------------------------------------

--
-- Table structure for table `pg_packages`
--

CREATE TABLE `pg_packages` (
  `id` int(11) NOT NULL,
  `package` varchar(50) NOT NULL,
  `amount` float(14,2) NOT NULL,
  `bv` float NOT NULL,
  `direct` float NOT NULL,
  `capping` float NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pg_users`
--

CREATE TABLE `pg_users` (
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
-- Dumping data for table `pg_users`
--

INSERT INTO `pg_users` (`id`, `username`, `mobile`, `name`, `email`, `password`, `vp`, `role`, `salt`, `otp`, `token`, `photo`, `language_id`, `status`, `created_on`, `updated_on`) VALUES
(1, 'admin', '0987654321', 'Admin', 'admin@gmail.com', '$2y$10$bwuDNGTQxYhQrY5Hm7ho8uBcWN47dVMOQpiJ9wNRN1Z77RlExrI7e', '12345', 'admin', '6nMwd04UhZ3YvsJx', '', '', '', NULL, 1, '2024-09-19 12:52:30', '2025-11-28 15:17:37');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `pg_acc_details`
--
ALTER TABLE `pg_acc_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_accreg` (`regid`);

--
-- Indexes for table `pg_banks`
--
ALTER TABLE `pg_banks`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `pg_deposits`
--
ALTER TABLE `pg_deposits`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pg_level_members`
--
ALTER TABLE `pg_level_members`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_lmregid` (`regid`),
  ADD KEY `fk_lmmid` (`member_id`);

--
-- Indexes for table `pg_members`
--
ALTER TABLE `pg_members`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `regid` (`regid`),
  ADD KEY `FK_ref` (`refid`);

--
-- Indexes for table `pg_packages`
--
ALTER TABLE `pg_packages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `package` (`package`);

--
-- Indexes for table `pg_users`
--
ALTER TABLE `pg_users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `pg_acc_details`
--
ALTER TABLE `pg_acc_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT for table `pg_banks`
--
ALTER TABLE `pg_banks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `pg_deposits`
--
ALTER TABLE `pg_deposits`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pg_level_members`
--
ALTER TABLE `pg_level_members`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pg_members`
--
ALTER TABLE `pg_members`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT for table `pg_packages`
--
ALTER TABLE `pg_packages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pg_users`
--
ALTER TABLE `pg_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `pg_acc_details`
--
ALTER TABLE `pg_acc_details`
  ADD CONSTRAINT `FK_accreg` FOREIGN KEY (`regid`) REFERENCES `pg_users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pg_level_members`
--
ALTER TABLE `pg_level_members`
  ADD CONSTRAINT `fk_lmmid` FOREIGN KEY (`member_id`) REFERENCES `pg_users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_lmregid` FOREIGN KEY (`regid`) REFERENCES `pg_users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pg_members`
--
ALTER TABLE `pg_members`
  ADD CONSTRAINT `FK_ref` FOREIGN KEY (`refid`) REFERENCES `pg_users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_reg` FOREIGN KEY (`regid`) REFERENCES `pg_users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
