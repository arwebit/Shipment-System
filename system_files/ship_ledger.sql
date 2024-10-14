-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 17, 2024 at 07:53 AM
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
-- Table structure for table `company_ledger`
--

CREATE TABLE `company_ledger` (
  `ledger_id` bigint(38) NOT NULL,
  `company_id` bigint(38) NOT NULL,
  `particulars` varchar(255) NOT NULL,
  `transaction_date` date NOT NULL,
  `debit` double DEFAULT NULL,
  `credit` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `company_list`
--

CREATE TABLE `company_list` (
  `company_id` bigint(20) NOT NULL,
  `company_name` varchar(255) NOT NULL,
  `company_mobile` varchar(10) DEFAULT NULL,
  `company_address` longtext NOT NULL,
  `opening_balance` double(15,2) DEFAULT NULL,
  `is_active` enum('active','inactive') NOT NULL,
  `created_by` varchar(10) NOT NULL,
  `created_date_time` datetime NOT NULL,
  `updated_by` varchar(10) DEFAULT NULL,
  `updated_date_time` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gatepass`
--

CREATE TABLE `gatepass` (
  `gatepass_id` bigint(20) NOT NULL,
  `party_id` int(11) NOT NULL,
  `booking_code` varchar(50) NOT NULL,
  `booking_date` date NOT NULL,
  `bilty_no` varchar(50) NOT NULL,
  `delivery_date` date NOT NULL,
  `package` varchar(50) NOT NULL,
  `weight` varchar(50) NOT NULL,
  `goods_name` varchar(255) NOT NULL,
  `to_pay_amount` double(15,2) NOT NULL,
  `discount_amount` double(15,2) DEFAULT NULL,
  `receive_amount` double(15,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `gatepass`
--

INSERT INTO `gatepass` (`gatepass_id`, `party_id`, `booking_code`, `booking_date`, `bilty_no`, `delivery_date`, `package`, `weight`, `goods_name`, `to_pay_amount`, `discount_amount`, `receive_amount`) VALUES
(1, 12, '10', '2024-08-14', '21897', '2024-08-30', '2', '', 'FOOTWEAR', 700.00, 200.00, 500.00),
(2, 12, '6', '2024-08-12', '50609', '2024-08-30', '2', '', 'FOOTWEAR', 700.00, 200.00, 500.00),
(3, 20, '12', '2024-08-13', '184796', '2024-08-28', '1', '50', 'MOTOR PARTS', 700.00, 0.00, 700.00),
(4, 20, '12', '2024-08-12', '184783', '2024-08-28', '3', '150', 'MOTOR PARTS', 1900.00, 0.00, 1900.00),
(5, 21, '16', '2024-08-22', '186236', '2024-08-29', '5', '350', 'AUTO PARTS', 2900.00, 0.00, 2900.00),
(6, 22, '14', '2024-08-16', '183652', '2024-08-28', '3', '150', 'TAPE', 1300.00, 0.00, 1300.00),
(7, 22, '14', '2024-08-16', '183639', '2024-08-28', '7', '410', 'PV WAIR', 3380.00, 0.00, 3380.00),
(8, 17, '25', '2024-08-24', '184224', '2024-08-28', '27', '600', 'CONSIL BOX', 4900.00, 0.00, 4900.00),
(9, 23, '11', '2024-08-21', '186499', '2024-08-29', '3', '200', 'MOTOR PARTS', 2100.00, 400.00, 1700.00),
(10, 24, '16', '2024-08-20', '186147', '2024-08-29', '4', '320', 'AUTO PARTS', 2660.00, 0.00, 2660.00),
(11, 24, '16', '2024-08-18', '186146', '2024-08-29', '2', '100', 'AUTO PARTS', 900.00, 0.00, 900.00),
(12, 24, '16', '2024-08-20', '186145', '2024-08-29', '1', '60', 'AUTO PARTS', 580.00, 0.00, 580.00),
(13, 16, '17', '2024-08-17', '180066', '2024-08-30', '5', '300', 'ELEKTRIC', 3400.00, 1150.00, 2250.00),
(14, 16, '17', '2024-08-17', '180085', '2024-08-30', '5', '300', 'ELEKTRIC', 3100.00, 850.00, 2250.00),
(15, 25, '25', '2024-08-16', '184123', '2024-08-30', '7', '280', 'PVC WIER', 2340.00, 0.00, 2340.00),
(16, 26, '9', '2024-08-18', '185127', '2024-08-29', '10', '500', 'P COOKAR', 5100.00, 0.00, 5100.00),
(17, 16, '25', '2024-08-23', '184206', '2024-09-03', '21', '710', 'PVC WIER', 5780.00, 455.00, 5325.00),
(18, 17, '25', '2024-08-16', '184135', '2024-09-04', '21', '770', 'PVC WIER', 5780.00, 0.00, 5780.00),
(19, 12, '10', '2024-08-27', '56531', '2024-09-06', '10', '', 'EVA FOOTWER', 3100.00, 600.00, 2500.00),
(20, 12, '17', '2024-08-28', '60825', '2024-09-06', '5', '', 'EVA FOOTWER', 1500.00, 250.00, 1250.00),
(21, 28, '45', '2024-08-28', '57684', '2024-09-06', '1', '', 'FOOTWEAR', 250.00, 0.00, 250.00),
(22, 29, '25', '2024-09-02', '56078', '2024-09-06', '9', '300', 'ELEKTRIC', 2200.00, 0.00, 2200.00),
(23, 30, '8', '2024-08-24', '57068', '2024-09-08', '15', '', 'FOOTWEAR', 4600.00, 1450.00, 3150.00),
(24, 31, '11', '2024-08-24', '60469', '2024-09-10', '5', '500', 'TENT GOODS', 4100.00, 0.00, 4100.00),
(25, 29, '7', '2024-09-09', '59601', '2024-09-16', '20', '600', 'ELEKTRIC', 3700.00, 0.00, 3700.00),
(26, 12, '6', '2024-09-04', '50649', '2024-09-16', '45', '1625', 'FOOTWEAR', 11300.00, 3200.00, 8100.00),
(27, 12, '10', '2024-09-07', '56689', '2024-09-16', '21', '630', 'FOOTWEAR', 4720.00, 940.00, 3780.00),
(28, 13, '24', '2024-09-03', '60096', '2024-09-16', '1', '100', 'RM', 1300.00, 300.00, 1000.00),
(29, 13, '24', '2024-09-03', '60105', '2024-09-16', '1', '100', 'RM', 1300.00, 300.00, 1000.00),
(30, 13, '24', '2024-09-04', '60111', '2024-09-16', '1', '100', 'RM', 1300.00, 300.00, 1000.00),
(31, 33, '25', '2024-09-07', '56109', '2024-09-16', '13', '400', 'ELEKTRIC', 2700.00, 0.00, 2700.00),
(32, 13, '24', '2024-09-03', '26625', '2024-09-17', '2', '200', 'RM', 2500.00, 500.00, 2000.00),
(33, 13, '24', '2024-09-04', '26652', '2024-09-17', '1', '100', 'RM', 1300.00, 300.00, 1000.00),
(34, 17, '17', '2024-08-29', '180106', '2024-09-08', '5', '300', 'ELEKTRIC', 3100.00, 600.00, 2500.00),
(35, 34, '11', '2024-08-29', '188218', '2024-09-06', '2', '100', 'BARBAR GOODS', 1500.00, 0.00, 1500.00),
(36, 35, '8', '2024-08-31', '174237', '2024-09-06', '13', '910', 'PAPER ROLL', 9200.00, 1820.00, 7380.00),
(37, 36, '13', '2024-08-31', '185837', '2024-09-10', '3', '120', 'P TOOLS', 1180.00, 0.00, 1180.00),
(38, 37, '7', '2024-08-30', '187013', '2024-09-07', '9', '720', 'AUTO PARTS', 7300.00, 100.00, 7200.00),
(39, 38, '16', '2024-08-29', '187873', '2024-09-07', '3', '200', 'AUTO', 1700.00, 0.00, 1700.00),
(40, 33, '25', '2024-08-29', '186604', '2024-09-13', '5', '320', 'ELEKTRIC', 2660.00, 0.00, 2660.00),
(41, 33, '17', '2024-08-12', '180047', '2024-09-13', '2', '120', 'ELEKTRIC', 1420.00, 360.00, 1060.00),
(42, 33, '25', '2024-08-10', '184053', '2024-09-13', '10', '350', 'PV WAIR', 2900.00, 0.00, 2900.00),
(43, 33, '25', '2024-08-14', '184108', '2024-09-13', '2', '90', 'PVC WIRE', 820.00, 0.00, 820.00),
(44, 39, '11', '2024-08-29', '188239', '2024-09-14', '3', '200', 'SS WARE', 2900.00, 1250.00, 1650.00),
(45, 39, '42', '2024-08-23', '180500', '2024-09-14', '1', '110', 'SS WARE', 1580.00, 430.00, 1150.00),
(46, 39, '42', '2024-08-14', '180466', '2024-09-14', '2', '200', 'SS WARE', 2800.00, 750.00, 2050.00),
(47, 39, '42', '2024-08-23', '18036', '2024-09-14', '3', '200', 'SS WARE', 3630.00, 1580.00, 2050.00),
(48, 40, '11', '2024-09-11', '190174', '2024-09-16', '1', '100', 'RUBAUR BAND', 2100.00, 0.00, 2100.00),
(49, 12, '10', '2024-09-04', '171046', '2024-09-16', '4', '200', 'EVA FOOTWER', 2100.00, 500.00, 1600.00),
(50, 39, '42', '2024-08-14', '180468', '2024-09-15', '1', '100', 'SS WARE', 1450.00, 400.00, 1050.00),
(51, 40, '11', '2024-09-10', '190138', '2024-09-16', '1', '100', 'SPORT GOODS', 1600.00, 0.00, 1600.00),
(52, 40, '11', '0000-00-00', '190149', '2024-09-16', '1', '100', 'THALI', 1700.00, 0.00, 1700.00),
(53, 40, '11', '2024-09-10', '190157', '2024-09-16', '1', '150', 'TOYS', 2600.00, 0.00, 2600.00),
(54, 40, '11', '2024-09-11', '190108', '2024-09-16', '1', '60', 'FABRIC', 700.00, 0.00, 700.00),
(55, 41, '11', '2024-09-06', '188986', '2024-09-16', '1', '50', 'DISPOSAL', 700.00, 0.00, 700.00),
(56, 40, '11', '2024-09-10', '190132', '2024-01-19', '1', '100', 'MANIHARI', 900.00, 0.00, 900.00),
(57, 29, '25', '2024-09-13', '56153', '2024-09-20', '5', '150', 'ELEKTRIC', 1000.00, 0.00, 1000.00),
(58, 29, '25', '2024-09-12', '56148', '2024-09-20', '3', '80', 'ELEKTRIC', 620.00, 0.00, 620.00),
(59, 13, '24', '2024-09-05', '26558', '2024-09-20', '1', '100', 'RM', 1300.00, 300.00, 1000.00),
(60, 13, '24', '2024-09-05', '26517', '2024-09-20', '1', '100', 'RM', 1300.00, 300.00, 1000.00),
(61, 12, '17', '2024-09-14', '63001', '2024-09-21', '5', '', 'EVA FOOTWER', 1600.00, 350.00, 1250.00),
(62, 12, '9', '2024-09-12', '62396', '2024-09-21', '5', '', 'CHENA FOOTWER', 4100.00, 0.00, 4100.00),
(63, 12, '6', '2024-09-12', '50669', '2024-09-21', '31', '', 'FOOTWEAR', 5580.00, 0.00, 5580.00),
(64, 12, '17', '2024-09-13', '62965', '2024-09-21', '', '', 'EVA FOOTWER', 2200.00, 450.00, 1750.00),
(65, 12, '17', '2024-09-14', '62996', '2024-09-21', '15', '', 'FOOTWEAR', 5100.00, 0.00, 5100.00),
(66, 15, '9', '2024-09-04', '175958', '2024-09-18', '5', '250', 'SS WARE', 2350.00, 0.00, 2350.00),
(67, 42, '8', '2024-09-18', '174263', '2024-09-18', '20', '600', 'PAKING METRIAL', 4900.00, 0.00, 4900.00),
(68, 17, '25', '2024-09-12', '186811', '2024-09-20', '22', '500', 'PVC WIER', 4100.00, 0.00, 4100.00),
(69, 17, '25', '2024-08-23', '184212', '2024-09-20', '12', '350', 'PVC WIER', 2900.00, 0.00, 2900.00),
(70, 17, '25', '2024-09-14', '186862', '2024-09-20', '10', '200', 'ELEKTRIC', 1700.00, 0.00, 1700.00),
(71, 17, '25', '2024-09-02', '186672', '2024-09-20', '26', '800', 'PVC WIER', 6500.00, 0.00, 6500.00),
(72, 16, '17', '2024-09-07', '180196', '2024-09-20', '7', '420', 'ELEKTRIC', 4300.00, 1050.00, 3250.00),
(73, 16, '17', '2024-09-06', '180178', '2024-09-20', '4', '240', 'ELEKTRIC', 2500.00, 700.00, 1800.00),
(74, 16, '25', '2024-09-14', '186833', '2024-09-20', '17', '600', 'PVC WIER', 4900.00, 400.00, 4500.00),
(75, 16, '25', '2024-09-13', '186827', '2024-09-20', '18', '740', 'PVC WIER', 6020.00, 470.00, 5550.00),
(76, 15, '11', '2024-09-12', '190013', '2024-09-20', '7', '250', 'DINER SET', 2600.00, 0.00, 2600.00),
(77, 16, '25', '2024-08-30', '186623', '2024-09-20', '23', '860', 'PVC WIER', 6980.00, 530.00, 6450.00),
(78, 16, '25', '2024-09-09', '186763', '2024-09-20', '11', '440', 'PVC WIER', 3620.00, 320.00, 3300.00),
(79, 16, '17', '2024-08-10', '159608', '2024-09-20', '23', '300', 'PVC WIER', 3100.00, 850.00, 2250.00),
(80, 15, '11', '2024-09-14', '190092', '2024-09-20', '3', '250', 'SS WARE', 2600.00, 550.00, 2050.00),
(81, 15, '11', '2024-09-14', '190089', '2024-09-20', '6', '500', 'SS WARE', 5100.00, 1050.00, 4050.00),
(82, 15, '11', '2024-09-13', '190075', '2024-09-20', '1', '60', 'SS WARE', 700.00, 170.00, 530.00),
(83, 15, '11', '2024-09-13', '190051', '2024-09-20', '2', '200', 'SS WARE', 2500.00, 850.00, 1650.00),
(84, 43, '13', '2024-09-14', '185943', '2024-09-21', '2', '80', 'HOOK', 820.00, 0.00, 820.00),
(85, 16, '11', '2024-08-30', '188276', '2024-09-21', '1', '60', 'PIN TOP', 940.00, 390.00, 550.00),
(86, 39, '42', '2024-09-11', '180345', '2024-09-21', '1', '70', 'SS WARE', 1060.00, 310.00, 750.00),
(87, 44, '11', '2024-09-13', '190077', '2024-09-21', '1', '', 'TOYS', 2600.00, 0.00, 2600.00),
(88, 45, '14', '2024-09-17', '190230', '2024-09-24', '1', '', 'ELEKTRIC', 1100.00, 0.00, 1100.00),
(89, 17, '25', '2024-09-16', '186884', '2024-09-24', '11', '260', 'ELEKTRIC', 2180.00, 0.00, 2180.00),
(90, 17, '17', '2024-09-19', '162694', '2024-09-24', '5', '300', 'ELEKTRIC', 3100.00, 600.00, 2500.00),
(91, 17, '11', '2024-09-19', '191429', '2024-09-24', '6', '360', 'ELEKTRIC', 2980.00, 0.00, 2980.00),
(92, 15, '11', '2024-09-20', '191467', '2024-09-25', '2', '180', 'SS WARE', 1900.00, 410.00, 1490.00),
(93, 15, '11', '2024-09-16', '191045', '2024-09-25', '1', '100', 'SS WARE', 1100.00, 150.00, 950.00),
(94, 15, '11', '2024-09-16', '191036', '2024-09-25', '2', '100', 'SS WARE', 900.00, 50.00, 850.00),
(95, 12, '13', '2024-09-17', '185963', '2024-09-25', '5', '300', 'HW', 2800.00, 300.00, 2500.00),
(96, 46, '41', '2024-09-17', '180880', '2024-09-26', '7', '300', 'LPG STOVE', 3100.00, 0.00, 3100.00),
(97, 15, '18', '2024-09-17', '183299', '2024-09-25', '2', '13800', 'SS WARE', 1380.00, 0.00, 1380.00),
(98, 15, '18', '2024-09-15', '183292', '2024-09-25', '6', '540', 'SS WARE', 4400.00, 30.00, 4370.00),
(99, 15, '18', '2024-09-14', '183291', '2024-09-25', '6', '540', 'SS WARE', 4420.00, 50.00, 4370.00),
(100, 15, '11', '2024-09-19', '63430', '2024-09-25', '6', '600', 'SS WARE', 4900.00, 1200.00, 3700.00),
(101, 15, '9', '2024-09-16', '62423', '2024-09-25', '2', '200', 'SS WARE', 1700.00, 400.00, 1300.00),
(102, 47, '18', '2024-09-02', '176701', '2024-09-29', '2', '140', 'SS WARE', 1220.00, 0.00, 1220.00),
(103, 47, '18', '2024-08-24', '176649', '2024-09-29', '3', '240', 'SS WARE', 2500.00, 0.00, 2500.00),
(104, 48, '10', '2024-09-19', '184488', '2024-09-30', '59', '1475', 'PAKING METRIAL', 11900.00, 0.00, 11900.00),
(105, 49, '14', '2024-09-19', '192271', '2024-09-30', '1', '60', 'ELEKTRIC', 700.00, 0.00, 700.00),
(106, 16, '25', '2024-09-16', '186881', '2024-10-01', '11', '360', 'PVC WIER', 2980.00, 180.00, 2800.00),
(107, 16, '25', '2024-09-19', '186934', '2024-10-01', '36', '1300', 'PVC WIER', 10500.00, 650.00, 9850.00),
(108, 29, '25', '2024-09-25', '191729', '2024-09-30', '1', '50', 'ELEKTRIC', 500.00, 0.00, 500.00),
(109, 16, '14', '2024-09-25', '62825', '2024-10-02', '1', '60', 'ELEKTRIC', 460.00, 0.00, 460.00),
(110, 16, '9', '2024-09-20', '62527', '2024-10-02', '1', '1950', 'ELEKTRIC', 11800.00, 0.00, 11800.00),
(111, 13, '24', '2024-09-20', '61009', '2024-10-01', '1', '100', 'RM', 1300.00, 300.00, 1000.00),
(112, 41, '11', '2024-09-23', '63718', '2024-10-01', '4', '240', 'DISPOSAL', 2020.00, 0.00, 2020.00),
(113, 41, '11', '2024-09-24', '64804', '2024-10-01', '2', '', 'DISPOSAL', 900.00, 0.00, 900.00),
(114, 50, '17', '2024-09-20', '64408', '2024-10-02', '5', '', 'EVA FOOTWER', 1600.00, 0.00, 1600.00),
(115, 33, '25', '2024-09-21', '180925', '2024-10-03', '6', '250', 'PVC WIER250', 2100.00, 0.00, 2100.00),
(116, 51, '9', '2024-09-14', '176085', '2024-10-03', '5', '', 'COOCKER', 2600.00, 0.00, 2600.00),
(117, 52, '25', '2024-09-28', '191764', '2024-10-05', '13', '455', 'PAKING METRIAL455', 3740.00, 0.00, 3740.00),
(118, 29, '25', '2024-09-27', '59575', '2024-10-05', '21', '550', 'ELEKTRIC', 3675.00, 0.00, 3675.00),
(119, 53, '17', '2024-09-24', '64535', '2024-10-05', '8', '', 'EVA FOOTWER', 2500.00, 500.00, 2000.00),
(120, 53, '17', '2024-09-20', '63134', '2024-10-05', '12', '', 'FOOTWEAR', 3100.00, 940.00, 2160.00),
(121, 53, '17', '2024-09-20', '63150', '2024-10-05', '15', '', 'FOOTWEAR', 3850.00, 1150.00, 2700.00),
(122, 41, '11', '2024-09-30', '192887', '2024-10-05', '1', '80', 'DISPOSAL', 900.00, 0.00, 900.00),
(123, 41, '11', '2024-09-26', '198050', '2024-10-05', '1', '100', 'DISPOSAL', 1300.00, 100.00, 1200.00),
(124, 41, '11', '2024-09-30', '102891', '2024-10-05', '13', '780', 'RANGOLI', 6340.00, 0.00, 6340.00),
(125, 27, '42', '2024-08-23', '180356', '2024-10-04', '3', '300', 'SS WARE', 3750.00, 650.00, 3100.00),
(126, 54, '13', '2024-09-27', '189508', '2024-10-05', '7', '210', 'ELEKTRIC', 1990.00, 210.00, 1780.00),
(127, 54, '14', '2024-09-29', '190388', '2024-10-05', '16', '410', 'ELEKTRIC', 3380.00, 0.00, 3380.00);

-- --------------------------------------------------------

--
-- Table structure for table `goods_list`
--

CREATE TABLE `goods_list` (
  `goods_id` bigint(38) NOT NULL,
  `party_id` int(11) NOT NULL,
  `goods_name` varchar(255) NOT NULL,
  `total_amount` double(15,2) NOT NULL,
  `sell_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `goods_list`
--

INSERT INTO `goods_list` (`goods_id`, `party_id`, `goods_name`, `total_amount`, `sell_date`) VALUES
(1, 5, 'RM', 10400.00, '2024-08-26'),
(2, 7, 'RM', 10400.00, '2024-08-26'),
(3, 27, 'DINEAR SET', 2020.00, '2024-09-01');

-- --------------------------------------------------------

--
-- Table structure for table `ledger`
--

CREATE TABLE `ledger` (
  `ledger_id` bigint(20) NOT NULL,
  `party_id` bigint(20) NOT NULL,
  `gatepass_id` bigint(20) DEFAULT NULL,
  `goods_id` bigint(38) DEFAULT NULL,
  `debit` double(15,2) DEFAULT NULL,
  `credit` double(15,2) DEFAULT NULL,
  `payment_type` varchar(20) DEFAULT NULL,
  `payment_ref_no` varchar(100) DEFAULT NULL,
  `transaction_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `ledger`
--

INSERT INTO `ledger` (`ledger_id`, `party_id`, `gatepass_id`, `goods_id`, `debit`, `credit`, `payment_type`, `payment_ref_no`, `transaction_date`) VALUES
(1, 15, NULL, NULL, 5050.00, NULL, 'Cash', '', '2024-08-26'),
(2, 5, NULL, 1, NULL, 10400.00, NULL, NULL, '2024-08-26'),
(3, 7, NULL, 2, NULL, 10400.00, NULL, NULL, '2024-08-26'),
(4, 12, 1, NULL, NULL, 500.00, NULL, NULL, '2024-08-30'),
(5, 12, 2, NULL, NULL, 500.00, NULL, NULL, '2024-08-30'),
(6, 20, 3, NULL, NULL, 700.00, NULL, NULL, '2024-08-28'),
(7, 20, 4, NULL, NULL, 1900.00, NULL, NULL, '2024-08-28'),
(8, 21, 5, NULL, NULL, 2900.00, NULL, NULL, '2024-08-29'),
(9, 22, 6, NULL, NULL, 1300.00, NULL, NULL, '2024-08-28'),
(10, 22, 7, NULL, NULL, 3380.00, NULL, NULL, '2024-08-28'),
(11, 17, 8, NULL, NULL, 4900.00, NULL, NULL, '2024-08-28'),
(12, 23, 9, NULL, NULL, 1700.00, NULL, NULL, '2024-08-29'),
(13, 24, 10, NULL, NULL, 2660.00, NULL, NULL, '2024-08-29'),
(14, 24, 11, NULL, NULL, 900.00, NULL, NULL, '2024-08-29'),
(15, 24, 12, NULL, NULL, 580.00, NULL, NULL, '2024-08-29'),
(16, 16, 13, NULL, NULL, 2250.00, NULL, NULL, '2024-08-30'),
(17, 16, 14, NULL, NULL, 2250.00, NULL, NULL, '2024-08-30'),
(18, 25, 15, NULL, NULL, 2340.00, NULL, NULL, '2024-08-30'),
(19, 26, 16, NULL, NULL, 5100.00, NULL, NULL, '2024-08-29'),
(20, 17, NULL, NULL, 5000.00, NULL, 'Cash', '', '2024-08-26'),
(21, 16, NULL, NULL, 6300.00, NULL, 'Cash', '', '2024-08-26'),
(22, 17, NULL, NULL, 3000.00, NULL, 'Cash', '', '2024-08-27'),
(23, 20, NULL, NULL, 2600.00, NULL, 'UPI', '', '2024-08-28'),
(24, 22, NULL, NULL, 4680.00, NULL, 'Cash', '', '2024-08-28'),
(25, 17, NULL, NULL, 3000.00, NULL, 'Cash', '', '2024-08-28'),
(26, 21, NULL, NULL, 2900.00, NULL, 'Cash', '', '2024-08-29'),
(27, 24, NULL, NULL, 4140.00, NULL, 'Cash', '', '2024-08-29'),
(28, 23, NULL, NULL, 1200.00, NULL, 'Cash', '', '2024-08-29'),
(29, 23, NULL, NULL, 500.00, NULL, 'UPI', '', '2024-08-29'),
(30, 26, NULL, NULL, 5100.00, NULL, 'Cash', '', '2024-08-29'),
(31, 17, NULL, NULL, 3000.00, NULL, 'Cash', '', '2024-08-29'),
(32, 8, NULL, NULL, 2000.00, NULL, 'Cash', '', '2024-08-29'),
(33, 12, NULL, NULL, 2500.00, NULL, 'Cash', '', '2024-08-30'),
(34, 17, NULL, NULL, 3000.00, NULL, 'Cash', '', '2024-08-30'),
(35, 27, NULL, 3, NULL, 2020.00, NULL, NULL, '2024-09-01'),
(36, 27, NULL, NULL, 2020.00, NULL, 'Cash', '', '2024-09-01'),
(37, 8, NULL, NULL, 5000.00, NULL, 'Cash', '', '2024-09-02'),
(38, 17, NULL, NULL, 5900.00, NULL, 'Cash', '', '2024-09-03'),
(39, 16, 17, NULL, NULL, 5325.00, NULL, NULL, '2024-09-03'),
(40, 17, 18, NULL, NULL, 5780.00, NULL, NULL, '2024-09-04'),
(41, 17, NULL, NULL, 3000.00, NULL, 'Cash', '', '2024-09-04'),
(42, 16, NULL, NULL, 10100.00, NULL, 'UPI', '9472525695', '2024-09-05'),
(43, 12, 19, NULL, NULL, 2500.00, NULL, NULL, '2024-09-06'),
(44, 12, 20, NULL, NULL, 1250.00, NULL, NULL, '2024-09-06'),
(45, 12, NULL, NULL, 4000.00, NULL, 'Cash', '', '2024-09-06'),
(46, 28, 21, NULL, NULL, 250.00, NULL, NULL, '2024-09-06'),
(47, 29, 22, NULL, NULL, 2200.00, NULL, NULL, '2024-09-06'),
(48, 30, 23, NULL, NULL, 3150.00, NULL, NULL, '2024-09-08'),
(49, 31, 24, NULL, NULL, 4100.00, NULL, NULL, '2024-09-10'),
(50, 29, 25, NULL, NULL, 3700.00, NULL, NULL, '2024-09-16'),
(51, 12, 26, NULL, NULL, 8100.00, NULL, NULL, '2024-09-16'),
(52, 12, 27, NULL, NULL, 3780.00, NULL, NULL, '2024-09-16'),
(53, 13, 28, NULL, NULL, 1000.00, NULL, NULL, '2024-09-16'),
(54, 13, 29, NULL, NULL, 1000.00, NULL, NULL, '2024-09-16'),
(55, 13, 30, NULL, NULL, 1000.00, NULL, NULL, '2024-09-16'),
(56, 33, 31, NULL, NULL, 2700.00, NULL, NULL, '2024-09-16'),
(57, 13, 32, NULL, NULL, 2000.00, NULL, NULL, '2024-09-17'),
(58, 13, 33, NULL, NULL, 1000.00, NULL, NULL, '2024-09-17'),
(59, 17, 34, NULL, NULL, 2500.00, NULL, NULL, '2024-09-08'),
(60, 34, 35, NULL, NULL, 1500.00, NULL, NULL, '2024-09-06'),
(61, 35, 36, NULL, NULL, 7380.00, NULL, NULL, '2024-09-06'),
(62, 36, 37, NULL, NULL, 1180.00, NULL, NULL, '2024-09-10'),
(63, 37, 38, NULL, NULL, 7200.00, NULL, NULL, '2024-09-07'),
(64, 38, 39, NULL, NULL, 1700.00, NULL, NULL, '2024-09-07'),
(65, 33, 40, NULL, NULL, 2660.00, NULL, NULL, '2024-09-13'),
(66, 33, 41, NULL, NULL, 1060.00, NULL, NULL, '2024-09-13'),
(67, 33, 42, NULL, NULL, 2900.00, NULL, NULL, '2024-09-13'),
(68, 33, 43, NULL, NULL, 820.00, NULL, NULL, '2024-09-13'),
(69, 39, 44, NULL, NULL, 1650.00, NULL, NULL, '2024-09-14'),
(70, 39, 45, NULL, NULL, 1150.00, NULL, NULL, '2024-09-14'),
(71, 39, 46, NULL, NULL, 2050.00, NULL, NULL, '2024-09-14'),
(72, 39, 47, NULL, NULL, 2050.00, NULL, NULL, '2024-09-14'),
(73, 40, 48, NULL, NULL, 2100.00, NULL, NULL, '2024-09-16'),
(74, 12, 49, NULL, NULL, 1600.00, NULL, NULL, '2024-09-16'),
(75, 39, 50, NULL, NULL, 1050.00, NULL, NULL, '2024-09-15'),
(76, 40, 51, NULL, NULL, 1600.00, NULL, NULL, '2024-09-16'),
(77, 40, 52, NULL, NULL, 1700.00, NULL, NULL, '2024-09-16'),
(78, 40, 53, NULL, NULL, 2600.00, NULL, NULL, '2024-09-16'),
(79, 40, 54, NULL, NULL, 700.00, NULL, NULL, '2024-09-16'),
(80, 41, 55, NULL, NULL, 700.00, NULL, NULL, '2024-09-16'),
(81, 40, 56, NULL, NULL, 900.00, NULL, NULL, '2024-01-19'),
(82, 29, 57, NULL, NULL, 1000.00, NULL, NULL, '2024-09-20'),
(83, 29, 58, NULL, NULL, 620.00, NULL, NULL, '2024-09-20'),
(84, 13, 59, NULL, NULL, 1000.00, NULL, NULL, '2024-09-20'),
(85, 13, 60, NULL, NULL, 1000.00, NULL, NULL, '2024-09-20'),
(86, 12, 61, NULL, NULL, 1250.00, NULL, NULL, '2024-09-21'),
(87, 12, 62, NULL, NULL, 4100.00, NULL, NULL, '2024-09-21'),
(88, 12, 63, NULL, NULL, 5580.00, NULL, NULL, '2024-09-21'),
(89, 12, 64, NULL, NULL, 1750.00, NULL, NULL, '2024-09-21'),
(90, 12, 65, NULL, NULL, 5100.00, NULL, NULL, '2024-09-21'),
(91, 15, 66, NULL, NULL, 2350.00, NULL, NULL, '2024-09-18'),
(92, 42, 67, NULL, NULL, 4900.00, NULL, NULL, '2024-09-18'),
(93, 17, 68, NULL, NULL, 4100.00, NULL, NULL, '2024-09-20'),
(94, 17, 69, NULL, NULL, 2900.00, NULL, NULL, '2024-09-20'),
(95, 17, 70, NULL, NULL, 1700.00, NULL, NULL, '2024-09-20'),
(96, 17, 71, NULL, NULL, 6500.00, NULL, NULL, '2024-09-20'),
(97, 16, 72, NULL, NULL, 3250.00, NULL, NULL, '2024-09-20'),
(98, 16, 73, NULL, NULL, 1800.00, NULL, NULL, '2024-09-20'),
(99, 16, 74, NULL, NULL, 4500.00, NULL, NULL, '2024-09-20'),
(100, 16, 75, NULL, NULL, 5550.00, NULL, NULL, '2024-09-20'),
(101, 15, 76, NULL, NULL, 2600.00, NULL, NULL, '2024-09-20'),
(102, 16, 77, NULL, NULL, 6450.00, NULL, NULL, '2024-09-20'),
(103, 16, 78, NULL, NULL, 3300.00, NULL, NULL, '2024-09-20'),
(104, 16, 79, NULL, NULL, 2250.00, NULL, NULL, '2024-09-20'),
(105, 29, NULL, NULL, 2200.00, NULL, 'UPI', '', '2024-09-06'),
(106, 34, NULL, NULL, 1500.00, NULL, 'Cash', '', '2024-09-06'),
(107, 35, NULL, NULL, 4800.00, NULL, 'Cash', '', '2024-09-06'),
(108, 35, NULL, NULL, 2580.00, NULL, 'UPI', '', '2024-09-06'),
(109, 17, NULL, NULL, 3000.00, NULL, 'Cash', '', '2024-09-07'),
(110, 37, NULL, NULL, 7200.00, NULL, 'Cash', '', '2024-09-08'),
(111, 31, NULL, NULL, 4100.00, NULL, 'Cash', '', '2024-09-10'),
(112, 36, NULL, NULL, 1180.00, NULL, 'Cash', '', '2024-09-10'),
(113, 17, NULL, NULL, 4000.00, NULL, 'Cash', '', '2024-09-11'),
(114, 39, NULL, NULL, 1300.00, NULL, 'Cash', '', '2024-09-13'),
(115, 17, NULL, NULL, 3650.00, NULL, 'Cash', '', '2024-09-13'),
(116, 38, NULL, NULL, 1700.00, NULL, 'Cash', '', '2024-09-07'),
(117, 29, NULL, NULL, 3000.00, NULL, 'UPI', '', '2024-09-16'),
(118, 29, NULL, NULL, 700.00, NULL, 'Cash', '', '2024-09-16'),
(119, 12, NULL, NULL, 8000.00, NULL, 'Cash', '', '2024-09-16'),
(120, 33, NULL, NULL, 3000.00, NULL, 'Cash', '', '2024-09-16'),
(121, 15, NULL, NULL, 2350.00, NULL, 'Cash', '', '2024-09-18'),
(122, 42, NULL, NULL, 4900.00, NULL, 'UPI', '', '2024-09-18'),
(123, 40, NULL, NULL, 7000.00, NULL, 'Cash', '', '2024-09-18'),
(124, 33, NULL, NULL, 3000.00, NULL, 'Cash', '', '2024-09-18'),
(125, 33, NULL, NULL, 3000.00, NULL, 'Cash', '', '2024-09-19'),
(126, 29, NULL, NULL, 1620.00, NULL, 'Cash', '', '2024-09-20'),
(127, 12, NULL, NULL, 10000.00, NULL, 'Cash', '', '2024-09-21'),
(128, 17, NULL, NULL, 3000.00, NULL, 'Cash', '', '2024-09-21'),
(129, 16, NULL, NULL, 20000.00, NULL, 'UPI', '', '2024-09-21'),
(130, 15, 80, NULL, NULL, 2050.00, NULL, NULL, '2024-09-20'),
(131, 15, 81, NULL, NULL, 4050.00, NULL, NULL, '2024-09-20'),
(132, 15, 82, NULL, NULL, 530.00, NULL, NULL, '2024-09-20'),
(133, 15, 83, NULL, NULL, 1650.00, NULL, NULL, '2024-09-20'),
(134, 43, 84, NULL, NULL, 820.00, NULL, NULL, '2024-09-21'),
(135, 16, 85, NULL, NULL, 550.00, NULL, NULL, '2024-09-21'),
(136, 39, 86, NULL, NULL, 750.00, NULL, NULL, '2024-09-21'),
(137, 44, 87, NULL, NULL, 2600.00, NULL, NULL, '2024-09-21'),
(138, 44, NULL, NULL, 2600.00, NULL, 'Cash', '', '2024-09-21'),
(139, 45, 88, NULL, NULL, 1100.00, NULL, NULL, '2024-09-24'),
(140, 17, 89, NULL, NULL, 2180.00, NULL, NULL, '2024-09-24'),
(141, 17, 90, NULL, NULL, 2500.00, NULL, NULL, '2024-09-24'),
(142, 17, 91, NULL, NULL, 2980.00, NULL, NULL, '2024-09-24'),
(143, 15, 92, NULL, NULL, 1490.00, NULL, NULL, '2024-09-25'),
(144, 15, 93, NULL, NULL, 950.00, NULL, NULL, '2024-09-25'),
(145, 15, 94, NULL, NULL, 850.00, NULL, NULL, '2024-09-25'),
(146, 12, 95, NULL, NULL, 2500.00, NULL, NULL, '2024-09-25'),
(147, 46, 96, NULL, NULL, 3100.00, NULL, NULL, '2024-09-26'),
(148, 15, 97, NULL, NULL, 1380.00, NULL, NULL, '2024-09-25'),
(149, 15, 98, NULL, NULL, 4370.00, NULL, NULL, '2024-09-25'),
(150, 15, 99, NULL, NULL, 4370.00, NULL, NULL, '2024-09-25'),
(151, 43, NULL, NULL, 800.00, NULL, 'Cash', '', '2024-09-22'),
(152, 17, NULL, NULL, 3000.00, NULL, 'Cash', '', '2024-09-22'),
(153, 13, NULL, NULL, 8000.00, NULL, 'Cash', '', '2024-09-23'),
(154, 16, NULL, NULL, 8250.00, NULL, 'UPI', '', '2024-09-23'),
(155, 41, NULL, NULL, 700.00, NULL, 'Cash', '', '2024-09-24'),
(156, 45, NULL, NULL, 1100.00, NULL, 'Cash', '', '2024-09-24'),
(157, 12, NULL, NULL, 2000.00, NULL, 'Cash', '', '2024-09-25'),
(158, 17, NULL, NULL, 5000.00, NULL, 'Cash', '', '2024-09-25'),
(159, 46, NULL, NULL, 3100.00, NULL, 'Cash', '', '2024-09-26'),
(160, 1, NULL, NULL, 21000.00, NULL, 'Cheque', '', '2024-09-26'),
(161, 30, NULL, NULL, 3150.00, NULL, 'UPI', '', '2024-09-16'),
(162, 33, NULL, NULL, 1140.00, NULL, 'Cash', '', '2024-09-20'),
(163, 17, NULL, NULL, 3000.00, NULL, 'Cash', '', '2024-09-28'),
(164, 8, NULL, NULL, 10000.00, NULL, 'Cash', '', '2024-09-29'),
(165, 15, 100, NULL, NULL, 3700.00, NULL, NULL, '2024-09-25'),
(166, 15, 101, NULL, NULL, 1300.00, NULL, NULL, '2024-09-25'),
(167, 47, 102, NULL, NULL, 1220.00, NULL, NULL, '2024-09-29'),
(168, 47, 103, NULL, NULL, 2500.00, NULL, NULL, '2024-09-29'),
(169, 48, 104, NULL, NULL, 11900.00, NULL, NULL, '2024-09-30'),
(170, 49, 105, NULL, NULL, 700.00, NULL, NULL, '2024-09-30'),
(171, 16, 106, NULL, NULL, 2800.00, NULL, NULL, '2024-10-01'),
(172, 16, 107, NULL, NULL, 9850.00, NULL, NULL, '2024-10-01'),
(173, 29, 108, NULL, NULL, 500.00, NULL, NULL, '2024-09-30'),
(174, 16, 109, NULL, NULL, 460.00, NULL, NULL, '2024-10-02'),
(175, 16, 110, NULL, NULL, 11800.00, NULL, NULL, '2024-10-02'),
(176, 13, 111, NULL, NULL, 1000.00, NULL, NULL, '2024-10-01'),
(177, 41, 112, NULL, NULL, 2020.00, NULL, NULL, '2024-10-01'),
(178, 41, 113, NULL, NULL, 900.00, NULL, NULL, '2024-10-01'),
(179, 50, 114, NULL, NULL, 1600.00, NULL, NULL, '2024-10-02'),
(180, 48, NULL, NULL, 11900.00, NULL, 'UPI', '', '2024-09-30'),
(181, 49, NULL, NULL, 700.00, NULL, 'Cash', '', '2024-09-30'),
(182, 17, NULL, NULL, 5000.00, NULL, 'Cash', '', '2024-10-01'),
(183, 50, NULL, NULL, 1600.00, NULL, 'UPI', '', '2024-10-02'),
(184, 33, 115, NULL, NULL, 2100.00, NULL, NULL, '2024-10-03'),
(185, 51, 116, NULL, NULL, 2600.00, NULL, NULL, '2024-10-03'),
(186, 51, NULL, NULL, 2600.00, NULL, 'UPI', '', '2024-10-03'),
(188, 16, NULL, NULL, 24910.00, NULL, 'UPI', 'PAPPU SAW', '2024-10-03'),
(189, 52, 117, NULL, NULL, 3740.00, NULL, NULL, '2024-10-05'),
(190, 29, 118, NULL, NULL, 3675.00, NULL, NULL, '2024-10-05'),
(191, 53, 119, NULL, NULL, 2000.00, NULL, NULL, '2024-10-05'),
(192, 53, 120, NULL, NULL, 2160.00, NULL, NULL, '2024-10-05'),
(193, 53, 121, NULL, NULL, 2700.00, NULL, NULL, '2024-10-05'),
(194, 41, 122, NULL, NULL, 900.00, NULL, NULL, '2024-10-05'),
(195, 41, 123, NULL, NULL, 1200.00, NULL, NULL, '2024-10-05'),
(196, 41, 124, NULL, NULL, 6340.00, NULL, NULL, '2024-10-05'),
(197, 27, 125, NULL, NULL, 3100.00, NULL, NULL, '2024-10-04'),
(198, 54, 126, NULL, NULL, 1780.00, NULL, NULL, '2024-10-05'),
(199, 54, 127, NULL, NULL, 3380.00, NULL, NULL, '2024-10-05'),
(200, 15, NULL, NULL, 10000.00, NULL, 'Cash', '', '2024-10-03'),
(201, 17, NULL, NULL, 3850.00, NULL, 'Cash', '', '2024-10-04'),
(202, 8, NULL, NULL, 10000.00, NULL, 'Cash', '', '2024-10-04'),
(203, 29, NULL, NULL, 2500.00, NULL, 'Cash', '', '2024-10-05'),
(204, 29, NULL, NULL, 1675.00, NULL, 'UPI', '', '2024-10-05');

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
  `party_mobile` varchar(10) DEFAULT NULL,
  `party_address` longtext NOT NULL,
  `opening_balance` double(15,2) DEFAULT NULL,
  `is_active` enum('active','inactive') NOT NULL,
  `created_by` varchar(10) NOT NULL,
  `created_date_time` datetime NOT NULL,
  `updated_by` varchar(10) DEFAULT NULL,
  `updated_date_time` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `party_list`
--

INSERT INTO `party_list` (`party_id`, `party_name`, `party_mobile`, `party_address`, `opening_balance`, `is_active`, `created_by`, `created_date_time`, `updated_by`, `updated_date_time`) VALUES
(1, 'SHREE HANDLOOM', '', 'SUPAUL', 21000.00, 'active', 'admin', '2024-08-24 19:31:35', 'drc', '2024-08-26 07:41:02'),
(3, 'SHARDA DREESS', '', 'SUPAUL', 0.00, 'active', 'drc', '2024-08-24 19:50:13', '', NULL),
(8, 'S P JAL', '9472128371', 'SUPAUL', 46740.00, 'active', 'drc', '2024-08-25 07:02:21', 'drc', '2024-08-26 09:25:40'),
(9, 'J P', '', 'SUPAUL', 0.00, 'active', 'drc', '2024-08-26 07:36:35', '', NULL),
(10, 'BUNTY', '', 'SUPAUL', 0.00, 'active', 'drc', '2024-08-26 07:36:53', '', NULL),
(12, 'FANCY', '', 'SUPAUL', 36775.00, 'active', 'drc', '2024-08-26 07:45:46', '', NULL),
(13, 'VATIKA', '7903402548', 'SUPAUL', 2800.00, 'active', 'drc', '2024-08-26 07:46:23', 'drc', '2024-08-26 09:27:48'),
(14, 'MITTAL SINGAR', '9430017956', 'SUPAUL', 2620.00, 'active', 'drc', '2024-08-26 08:58:31', '', NULL),
(15, 'DINESH BARTAN BHANDAR', '9431448572', 'SUPAUL', 5050.00, 'active', 'drc', '2024-08-26 08:59:30', '', NULL),
(16, 'SYAM ELEKTRIC', '9430662983', 'SUPAUL', 6300.00, 'active', 'drc', '2024-08-26 09:00:55', '', NULL),
(17, 'SHREE BALAJI ELEKTRIC', '9308599883', 'SUPAUL', 22900.00, 'active', 'drc', '2024-08-26 09:02:52', '', NULL),
(19, 'SONU GARMENT', '', 'SUPAUL', 0.00, 'active', 'drc', '2024-08-26 17:42:44', '', NULL),
(20, 'MUKESH', '', 'NIRMALI', 0.00, 'active', 'drc', '2024-08-30 14:40:36', 'drc', '2024-08-30 15:23:53'),
(21, 'SHIV SHAKTI AUTO', '', 'PATHRA NIRMALI', 0.00, 'active', 'drc', '2024-08-30 14:46:08', '', NULL),
(22, 'RAJESH', '', 'SARIGARGH', 0.00, 'active', 'drc', '2024-08-30 14:49:08', '', NULL),
(23, 'NAKKI', '', 'SUPAUL', 0.00, 'active', 'drc', '2024-08-30 15:03:51', '', NULL),
(24, 'BALRAM AUTO', '', 'PIPRA BAJAR', 0.00, 'active', 'drc', '2024-08-30 15:05:48', '', NULL),
(25, 'NARMADA ELEKTRIC', '', 'SUPAUL', 0.00, 'active', 'drc', '2024-08-30 15:14:53', '', NULL),
(26, 'RAJ LAXMI', '', 'SUPAUL', 0.00, 'active', 'drc', '2024-08-30 15:16:55', '', NULL),
(27, 'RAMESH BARTAN BHANDAR', '', 'SUPAUL', 0.00, 'active', 'drc', '2024-09-02 09:48:24', '', NULL),
(28, 'MAPASAND FOOTWER', '', 'SUPAUL', 0.00, 'active', 'drc', '2024-09-18 06:57:22', '', NULL),
(29, 'SATYa GURU ELECTRIC', '', 'PIPRA BAJAR', 0.00, 'active', 'drc', '2024-09-18 07:02:28', '', NULL),
(30, 'HINDUSTAN FOOTWER', '', 'SIMRAHI', 0.00, 'active', 'drc', '2024-09-18 07:07:01', '', NULL),
(31, 'BIBHUTI THAKUR', '', 'SUPAUL', 0.00, 'active', 'drc', '2024-09-18 07:12:39', '', NULL),
(33, 'SUDAMA ELEKTRIC', '', 'SUPAUL', 0.00, 'active', 'drc', '2024-09-18 07:30:40', '', NULL),
(34, 'BAM SHANKAR', '', 'SUPAUL', 0.00, 'active', 'drc', '2024-09-18 07:41:35', '', NULL),
(35, 'RANJEET SINGH', '', 'ANDOLI SUPAUL', 0.00, 'active', 'drc', '2024-09-18 07:46:14', '', NULL),
(36, 'K P T', '', 'TRIVENI GANJ', 0.00, 'active', 'drc', '2024-09-18 07:50:28', '', NULL),
(37, 'RAM AUTO', '', 'SUPAUL', 0.00, 'active', 'drc', '2024-09-18 07:53:37', '', NULL),
(38, 'SS AUTO', '', 'JOLANHIYAN', 0.00, 'active', 'drc', '2024-09-18 07:56:35', '', NULL),
(39, 'SONU GUPTA BKG', '', 'SUPAUL', 0.00, 'active', 'drc', '2024-09-18 08:59:49', '', NULL),
(40, 'RAJESH MANIHARA', '', 'SUPAUL', 0.00, 'active', 'drc', '2024-09-18 09:11:36', '', NULL),
(41, 'RAJEEV JENTOL STORE', '', 'SUPAUL', 0.00, 'active', 'drc', '2024-09-18 09:27:14', '', NULL),
(42, 'LALIT', '', 'JOLAHNIYAN', 0.00, 'active', 'drc', '2024-09-22 07:25:03', '', NULL),
(43, 'MISHRA POWAR TOOLS', '', 'SUPAUL', 0.00, 'active', 'drc', '2024-09-22 15:49:04', '', NULL),
(44, 'SHARUV TOYS', '', 'SUPAUL', 0.00, 'active', 'drc', '2024-09-22 15:54:08', '', NULL),
(45, 'K E', '', 'SUPAUL', 0.00, 'active', 'drc', '2024-09-27 09:07:40', '', NULL),
(46, 'AA', '', 'TRIVENIGANJ', 0.00, 'active', 'drc', '2024-09-27 09:20:24', '', NULL),
(47, 'ARUN SP', '', 'SUPAUL', 0.00, 'active', 'drc', '2024-10-02 15:12:37', '', NULL),
(48, 'MANISH', '', 'TRIVENIGANJ', 0.00, 'active', 'drc', '2024-10-02 15:17:25', '', NULL),
(49, 'GUDDU', '', 'SUPAUL', 0.00, 'active', 'drc', '2024-10-02 15:20:30', '', NULL),
(50, 'ABDUL', '', 'BALHA', 0.00, 'active', 'drc', '2024-10-02 15:38:58', '', NULL),
(51, 'C N BARTAN', '', 'KISHANPUR', 0.00, 'active', 'drc', '2024-10-03 13:28:38', '', NULL),
(52, 'DEEPAK CHODHARI', '', 'SUPAUL', 0.00, 'active', 'drc', '2024-10-05 09:50:30', '', NULL),
(53, 'SAMIM BOOT HAUSE', '', 'SUPAUL', 0.00, 'active', '', '2024-10-05 15:24:13', '', NULL),
(54, 'DILIP SHARMA', '', 'SUPAUL', 0.00, 'active', '', '2024-10-05 15:40:47', '', NULL);

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
(1, 'admins', '21232f297a57a5a743894a0e4a801fc3', 'Administrator', 1, 'active'),
(3, 'drc', 'a8f33deb6c41ca27be76f9c264951596', 'drc', 2, 'active');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `company_ledger`
--
ALTER TABLE `company_ledger`
  ADD PRIMARY KEY (`ledger_id`);

--
-- Indexes for table `company_list`
--
ALTER TABLE `company_list`
  ADD PRIMARY KEY (`company_id`);

--
-- Indexes for table `gatepass`
--
ALTER TABLE `gatepass`
  ADD PRIMARY KEY (`gatepass_id`);

--
-- Indexes for table `goods_list`
--
ALTER TABLE `goods_list`
  ADD PRIMARY KEY (`goods_id`);

--
-- Indexes for table `ledger`
--
ALTER TABLE `ledger`
  ADD PRIMARY KEY (`ledger_id`);

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
-- AUTO_INCREMENT for table `company_ledger`
--
ALTER TABLE `company_ledger`
  MODIFY `ledger_id` bigint(38) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `company_list`
--
ALTER TABLE `company_list`
  MODIFY `company_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gatepass`
--
ALTER TABLE `gatepass`
  MODIFY `gatepass_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=128;

--
-- AUTO_INCREMENT for table `goods_list`
--
ALTER TABLE `goods_list`
  MODIFY `goods_id` bigint(38) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `ledger`
--
ALTER TABLE `ledger`
  MODIFY `ledger_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=205;

--
-- AUTO_INCREMENT for table `master_role`
--
ALTER TABLE `master_role`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `party_list`
--
ALTER TABLE `party_list`
  MODIFY `party_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `user_details`
--
ALTER TABLE `user_details`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
