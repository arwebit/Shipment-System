-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 05, 2024 at 07:17 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ship_ledger`
--

-- --------------------------------------------------------

--
-- Table structure for table `master_role`
--

CREATE TABLE `master_role` (
  `role_id` int(11) NOT NULL,
  `role_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `master_role`
--

INSERT INTO `master_role` (`role_id`, `role_name`) VALUES
(1, 'Administrator'),
(2, 'Manager');

-- --------------------------------------------------------

--
-- Table structure for table `party_list`
--

CREATE TABLE `party_list` (
  `party_id` bigint(20) NOT NULL,
  `party_name` varchar(255) NOT NULL,
  `party_mobile` bigint(10) NOT NULL,
  `party_address` longtext NOT NULL,
  `is_active` enum('active','inactive') NOT NULL,
  `created_by` varchar(10) NOT NULL,
  `created_date_time` datetime NOT NULL,
  `updated_by` varchar(10) DEFAULT NULL,
  `updated_date_time` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_details`
--

CREATE TABLE `user_details` (
  `user_id` int(11) NOT NULL,
  `username` varchar(10) NOT NULL,
  `password` varchar(35) NOT NULL,
  `full_name` varchar(250) NOT NULL,
  `user_role` int(11) NOT NULL,
  `is_active` enum('active','inactive') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `user_details`
--

INSERT INTO `user_details` (`user_id`, `username`, `password`, `full_name`, `user_role`, `is_active`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'Administrator', 1, 'active'),
(2, 'demo', 'fe01ce2a7fbac8fafaed7c982a04e229', 'Demo manager', 2, 'active');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `master_role`
--
ALTER TABLE `master_role`
  ADD PRIMARY KEY (`role_id`);

--
-- Indexes for table `party_list`
--
ALTER TABLE `party_list`
  ADD PRIMARY KEY (`party_id`);

--
-- Indexes for table `user_details`
--
ALTER TABLE `user_details`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `master_role`
--
ALTER TABLE `master_role`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `party_list`
--
ALTER TABLE `party_list`
  MODIFY `party_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_details`
--
ALTER TABLE `user_details`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
