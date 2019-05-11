-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 11, 2019 at 09:01 AM
-- Server version: 5.7.26-0ubuntu0.18.04.1
-- PHP Version: 7.2.17-1+ubuntu18.04.1+deb.sury.org+3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `smartrestaurant`
--

-- --------------------------------------------------------

--
-- Table structure for table `acquisitions`
--

CREATE TABLE `acquisitions` (
  `id` int(11) NOT NULL,
  `shopId` int(11) NOT NULL,
  `itemId` int(11) NOT NULL,
  `qty` varchar(20) NOT NULL,
  `unit` varchar(30) DEFAULT NULL,
  `kitchen` varchar(30) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `acquisitions`
--

INSERT INTO `acquisitions` (`id`, `shopId`, `itemId`, `qty`, `unit`, `kitchen`, `created_by`, `created_at`, `updated_by`, `updated_at`) VALUES
(4, 1, 7, '15', 'Litre', 'Bar', 2, '2019-04-27 15:13:23', 1, '2019-05-11 07:01:16'),
(5, 1, 7, '2', NULL, 'Continental', 1, '2019-05-08 18:59:13', NULL, NULL),
(6, 1, 12, '3', 'Kg', 'Local', 1, '2019-05-11 06:52:18', 1, '2019-05-11 07:01:03');

--
-- Triggers `acquisitions`
--
DELIMITER $$
CREATE TRIGGER `spyTrigger` BEFORE UPDATE ON `acquisitions` FOR EACH ROW BEGIN
   INSERT INTO acquisitionsTrails (id, shopId, itemId, qty, unit, kitchen, created_by, created_at, updated_by, updated_at)
    VALUES (OLD.id, OLD.shopId, OLD.itemId,  OLD.qty, OLD.unit,   OLD.kitchen,  OLD.created_by,  OLD.created_at,  OLD.updated_by,  OLD.updated_at )
;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `acquisitionsTrails`
--

CREATE TABLE `acquisitionsTrails` (
  `id` int(11) NOT NULL,
  `shopId` int(11) NOT NULL,
  `itemId` int(11) NOT NULL,
  `qty` varchar(20) NOT NULL,
  `unit` varchar(30) DEFAULT NULL,
  `kitchen` varchar(30) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `acquisitionsTrails`
--

INSERT INTO `acquisitionsTrails` (`id`, `shopId`, `itemId`, `qty`, `unit`, `kitchen`, `created_by`, `created_at`, `updated_by`, `updated_at`) VALUES
(4, 1, 7, '10', NULL, 'Bar', 2, '2019-04-27 15:13:23', NULL, NULL),
(6, 1, 12, '2', 'Kg', 'Local', 1, '2019-05-11 06:52:18', NULL, NULL),
(6, 1, 12, '3', 'Kg', 'Local', 1, '2019-05-11 06:52:18', NULL, NULL),
(6, 1, 12, '3', 'Crate', 'Local', 1, '2019-05-11 06:52:18', 1, '2019-05-11 07:00:41'),
(4, 1, 7, '15', NULL, 'Bar', 2, '2019-04-27 15:13:23', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `applications`
--

CREATE TABLE `applications` (
  `id` int(11) NOT NULL,
  `shopId` int(11) NOT NULL,
  `currency` varchar(10) DEFAULT NULL,
  `usermode` enum('Maintenance','Active') DEFAULT 'Maintenance',
  `pageLimit` int(11) DEFAULT '10',
  `updated_at` timestamp NULL DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `applications`
--

INSERT INTO `applications` (`id`, `shopId`, `currency`, `usermode`, `pageLimit`, `updated_at`, `updated_by`) VALUES
(1, 1, 'â‚¬', 'Maintenance', 10, '2019-05-07 08:30:37', 1),
(2, 3, 'â‚¦', 'Maintenance', 10, '2019-05-08 08:01:52', 11);

-- --------------------------------------------------------

--
-- Table structure for table `halls`
--

CREATE TABLE `halls` (
  `id` int(11) NOT NULL,
  `shopId` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `halls`
--

INSERT INTO `halls` (`id`, `shopId`, `name`, `created_at`, `updated_at`) VALUES
(1, 1, 'Yellow', '2019-04-30 09:37:20', '2019-04-30 09:37:20'),
(2, 1, 'Green', '2019-04-30 09:37:30', '2019-04-30 09:37:30'),
(3, 1, 'Burgundy', '2019-04-30 09:37:44', '2019-04-30 09:37:44');

-- --------------------------------------------------------

--
-- Table structure for table `htables`
--

CREATE TABLE `htables` (
  `id` int(11) NOT NULL,
  `shopId` int(11) NOT NULL,
  `hid` int(11) NOT NULL,
  `name` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `htables`
--

INSERT INTO `htables` (`id`, `shopId`, `hid`, `name`) VALUES
(1, 1, 2, 'Gre-A'),
(2, 1, 1, 'Yel-A'),
(3, 1, 3, 'Bur-A'),
(4, 1, 3, 'Bur-B');

-- --------------------------------------------------------

--
-- Table structure for table `orderdetails`
--

CREATE TABLE `orderdetails` (
  `id` int(11) NOT NULL,
  `shopId` int(11) NOT NULL,
  `invoice` varchar(100) NOT NULL,
  `qty` varchar(100) DEFAULT NULL,
  `price` varchar(100) DEFAULT NULL,
  `total` varchar(30) DEFAULT NULL,
  `product_id` int(11) NOT NULL,
  `vat` varchar(50) DEFAULT NULL,
  `discount` varchar(20) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `orderdetails`
--

INSERT INTO `orderdetails` (`id`, `shopId`, `invoice`, `qty`, `price`, `total`, `product_id`, `vat`, `discount`, `created_at`, `updated_at`) VALUES
(1, 1, '2565961109', '2', '3', '6', 7, NULL, NULL, '2019-05-02 08:56:58', '2019-05-02 08:11:23'),
(7, 1, '2565961109', '1', '5', '5', 8, NULL, NULL, '2019-05-02 08:25:53', NULL),
(13, 1, '1165565812', '1', '12', '12', 11, NULL, NULL, '2019-05-04 18:43:06', NULL),
(14, 1, '1165565812', '1', '12', '12', 12, NULL, NULL, '2019-05-04 18:43:08', NULL),
(15, 1, '1165565812', '1', '60', '60', 15, NULL, NULL, '2019-05-04 18:43:12', NULL),
(16, 1, '1336646211', '1', '25', '25', 9, NULL, NULL, '2019-05-05 10:18:57', NULL),
(17, 1, '1336646211', '1', '2.5', '2.5', 14, NULL, NULL, '2019-05-05 10:19:05', NULL),
(18, 1, '1336646211', '1', '12', '12', 11, NULL, NULL, '2019-05-05 10:19:12', NULL),
(19, 1, '1336646211', '1', '15', '15', 10, NULL, NULL, '2019-05-05 10:19:19', NULL),
(20, 1, '3280200531', '1', '60', '60', 15, NULL, NULL, '2019-05-05 11:09:48', NULL),
(21, 1, '3280200531', '1', '12', '12', 13, NULL, NULL, '2019-05-05 11:09:55', NULL),
(22, 1, '3269317779', '1', '5', '5', 8, NULL, NULL, '2019-05-08 08:25:42', NULL),
(23, 1, '2565961109', '1', '12', '12', 13, NULL, NULL, '2019-05-09 09:40:58', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `shopId` int(11) NOT NULL,
  `product_name` varchar(200) NOT NULL,
  `kitchen` varchar(30) DEFAULT NULL,
  `price` varchar(30) DEFAULT '0',
  `added_qty` varchar(30) DEFAULT '0',
  `qty` varchar(30) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `shopId`, `product_name`, `kitchen`, `price`, `added_qty`, `qty`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(7, 1, 'Coke', 'Bar', '3', '6', '22', '2019-04-27 13:51:57', 2, '2019-05-02 16:23:37', 1),
(8, 1, 'Banku', 'Local', '5', '5', '24', '2019-04-27 13:54:23', 2, '2019-05-02 16:24:44', 1),
(9, 1, 'Fried Rice', 'Continental', '25', '40', '38', '2019-05-02 15:44:31', 1, '2019-05-02 16:24:02', 1),
(10, 1, 'Smoke Chiken', 'Local', '15', '5', '4', '2019-05-02 15:51:44', 1, '2019-05-02 16:25:17', 1),
(11, 1, 'Estrella', 'Bar', '12', '7', '8', '2019-05-02 15:52:11', 1, '2019-05-08 19:00:48', 1),
(12, 1, 'Lager LP', 'Bar', '12', '4', '3', '2019-05-02 15:52:31', 1, '2019-05-02 16:23:44', 1),
(13, 1, 'Export', 'Bar', '12', '4', '1', '2019-05-02 15:52:47', 1, '2019-05-02 16:23:47', 1),
(14, 1, 'Rush', 'Bar', '2.5', '4', '3', '2019-05-02 15:53:00', 1, '2019-05-02 16:23:50', 1),
(15, 1, 'Kelewele/ Tilapia LP', 'Local', '60', '5', '2', '2019-05-02 15:53:48', 1, '2019-05-02 16:25:15', 1);

--
-- Triggers `products`
--
DELIMITER $$
CREATE TRIGGER `spyProdTrigger` BEFORE UPDATE ON `products` FOR EACH ROW BEGIN
   INSERT INTO productsTrails (id, shopId, product_name,  kitchen, price, added_qty, qty, created_by, created_at, updated_by, updated_at)
    VALUES (OLD.id, OLD.shopId, OLD.product_name,   OLD.kitchen, OLD.price, OLD.added_qty,  OLD.qty,  OLD.created_by,  OLD.created_at,  OLD.updated_by,  OLD.updated_at )
;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `productsTrails`
--

CREATE TABLE `productsTrails` (
  `id` int(11) NOT NULL,
  `shopId` int(11) NOT NULL,
  `product_name` varchar(200) NOT NULL,
  `kitchen` varchar(30) DEFAULT NULL,
  `price` varchar(30) DEFAULT '0',
  `added_qty` varchar(30) DEFAULT '0',
  `qty` varchar(30) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `productsTrails`
--

INSERT INTO `productsTrails` (`id`, `shopId`, `product_name`, `kitchen`, `price`, `added_qty`, `qty`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(7, 1, 'Coke', 'Bar', '3', '4', '18', '2019-04-27 13:51:57', 2, '2019-05-02 16:23:37', 1),
(7, 1, 'Coke', 'Bar', '3', '6', '18', '2019-04-27 13:51:57', 2, '2019-05-02 16:23:37', 1),
(11, 1, 'Estrella', 'Bar', '12', '4', '1', '2019-05-02 15:52:11', 1, '2019-05-02 16:23:42', 1),
(13, 1, 'Export', 'Bar', '12', '4', '2', '2019-05-02 15:52:47', 1, '2019-05-02 16:23:47', 1);

-- --------------------------------------------------------

--
-- Table structure for table `purchases`
--

CREATE TABLE `purchases` (
  `id` int(11) NOT NULL,
  `shopId` int(11) NOT NULL,
  `item_name` varchar(70) NOT NULL,
  `cost_price` varchar(20) NOT NULL,
  `qty` varchar(10) NOT NULL,
  `unit` varchar(30) DEFAULT NULL,
  `added_qty` varchar(30) DEFAULT NULL,
  `transaction_type` varchar(10) NOT NULL,
  `supplierId` int(11) NOT NULL,
  `purchased_date` varchar(10) DEFAULT NULL,
  `note` varchar(255) DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `purchases`
--

INSERT INTO `purchases` (`id`, `shopId`, `item_name`, `cost_price`, `qty`, `unit`, `added_qty`, `transaction_type`, `supplierId`, `purchased_date`, `note`, `created_by`, `created_at`, `updated_by`, `updated_at`) VALUES
(7, 1, 'Chicken', '12200', '2', 'Kg', NULL, 'Cash', 1, '05/04/2019', 'Chicken feeds', 2, '2019-04-27 15:13:04', 1, '2019-05-11 06:22:01'),
(8, 1, 'Rice', '240', '4', NULL, NULL, 'Credit', 1, '05/03/2019', NULL, 1, '2019-05-02 16:19:33', NULL, NULL),
(9, 1, 'Coke', '240', '7', NULL, NULL, 'Cash', 2, '04/09/2019', NULL, 1, '2019-05-02 16:23:00', NULL, NULL),
(10, 3, 'Rice', '240', '7', NULL, NULL, 'Cash', 4, '05/02/2019', NULL, 11, '2019-05-08 08:18:53', NULL, NULL),
(12, 1, 'Kelewele', '350', '2', 'Kg', NULL, 'Cash', 1, '05/02/2019', 'food item', 1, '2019-05-11 06:05:24', NULL, NULL);

--
-- Triggers `purchases`
--
DELIMITER $$
CREATE TRIGGER `spyPurchasesTrigger` BEFORE UPDATE ON `purchases` FOR EACH ROW BEGIN
   INSERT INTO purchasesTrails (id, shopId, item_name, cost_price, qty, added_qty, unit, transaction_type, supplierId, purchased_date,  created_by, created_at, updated_by, updated_at)
    VALUES (OLD.id, OLD.shopId, OLD.item_name, OLD.cost_price, OLD.qty, OLD.added_qty,OLD.unit, OLD.transaction_type, OLD.supplierId, OLD.purchased_date, OLD.created_by,  OLD.created_at,  OLD.updated_by,  OLD.updated_at );
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `purchasesTrails`
--

CREATE TABLE `purchasesTrails` (
  `id` int(11) NOT NULL,
  `shopId` int(11) NOT NULL,
  `item_name` varchar(70) NOT NULL,
  `cost_price` varchar(20) NOT NULL,
  `qty` varchar(10) NOT NULL,
  `added_qty` varchar(30) DEFAULT NULL,
  `unit` varchar(30) DEFAULT NULL,
  `transaction_type` varchar(10) NOT NULL,
  `supplierId` int(11) NOT NULL,
  `purchased_date` varchar(10) DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `note` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `purchasesTrails`
--

INSERT INTO `purchasesTrails` (`id`, `shopId`, `item_name`, `cost_price`, `qty`, `added_qty`, `unit`, `transaction_type`, `supplierId`, `purchased_date`, `created_by`, `created_at`, `updated_by`, `updated_at`, `note`) VALUES
(7, 1, 'Chicken', '12200', '3', NULL, NULL, 'Cash', 1, '05/08/2019', 2, '2019-04-27 15:13:04', 1, '2019-05-02 16:21:37', NULL),
(12, 1, 'Kelewele', '300', '4', NULL, NULL, 'Cash', 1, '05/02/2019', 1, '2019-05-11 06:05:24', NULL, NULL, NULL),
(7, 1, 'Chicken', '12200', '1', NULL, NULL, 'Cash', 1, '05/08/2019', 2, '2019-04-27 15:13:04', 1, '2019-05-02 16:21:37', NULL),
(12, 1, 'Kelewele', '350', '4', NULL, 'Kg', 'Cash', 1, '05/02/2019', 1, '2019-05-11 06:05:24', NULL, NULL, NULL),
(12, 1, 'Kelewele', '350', '2', NULL, 'Kg', 'Cash', 1, '05/02/2019', 1, '2019-05-11 06:05:24', NULL, NULL, NULL),
(12, 1, 'Kelewele', '350', '2', NULL, 'Kg', 'Cash', 1, '05/02/2019', 1, '2019-05-11 06:05:24', NULL, NULL, NULL),
(7, 1, 'Chicken', '12200', '2', NULL, 'Kg', 'Cash', 1, '05/04/2019', 2, '2019-04-27 15:13:04', 1, '2019-05-11 06:22:01', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `id` int(11) NOT NULL,
  `shopId` int(11) NOT NULL,
  `invoice_number` varchar(100) NOT NULL,
  `waiter` int(11) DEFAULT NULL,
  `cashier` int(11) DEFAULT NULL,
  `amount` varchar(100) NOT NULL,
  `discount` varchar(100) DEFAULT NULL,
  `balance` varchar(20) DEFAULT NULL,
  `status` enum('PAID','PENDING') DEFAULT 'PENDING',
  `tid` int(11) DEFAULT NULL,
  `sid` int(11) DEFAULT NULL,
  `hall` int(11) DEFAULT NULL,
  `ord_type` varchar(30) DEFAULT NULL,
  `period` varchar(20) DEFAULT NULL,
  `nhil` varchar(30) DEFAULT NULL,
  `fund` varchar(30) DEFAULT NULL,
  `vat` varchar(30) DEFAULT NULL,
  `kitchen` varchar(20) NOT NULL DEFAULT 'Bar',
  `created_at` timestamp NULL DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`id`, `shopId`, `invoice_number`, `waiter`, `cashier`, `amount`, `discount`, `balance`, `status`, `tid`, `sid`, `hall`, `ord_type`, `period`, `nhil`, `fund`, `vat`, `kitchen`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(2, 1, '2565961109', NULL, NULL, '23', '0', '23', 'PENDING', NULL, NULL, NULL, 'Take Out', '2019-05-09', NULL, NULL, NULL, '', '2019-05-02 14:45:00', 1, '2019-05-09 21:09:45', 1),
(3, 1, '1165565812', 3, 1, '84', '0', '84', 'PENDING', 1, 2, NULL, 'Dine-In', '2018-05-04', NULL, NULL, NULL, 'Bar', '2019-05-04 18:43:28', 1, NULL, NULL),
(4, 1, '1336646211', NULL, 1, '54.5', '0', '54.5', 'PENDING', NULL, NULL, NULL, 'Take Out', '2019-02-10', NULL, NULL, NULL, '', '2019-05-05 10:19:43', 1, NULL, NULL),
(5, 1, '3280200531', NULL, NULL, '72', '0', '72', 'PENDING', NULL, NULL, NULL, 'Take Out', '2019-05-05', NULL, NULL, NULL, '', '2019-05-05 11:09:59', 1, NULL, NULL),
(6, 1, '3269317779', 3, 1, '5', '0', '5', 'PENDING', 1, 2, NULL, 'Dine-In', '2019-05-08', NULL, NULL, NULL, 'Bar', '2019-05-08 08:26:56', 1, NULL, NULL);

--
-- Triggers `sales`
--
DELIMITER $$
CREATE TRIGGER `salesTrigger` BEFORE UPDATE ON `sales` FOR EACH ROW BEGIN
    INSERT INTO salesTrails (id, shopId, invoice_number, cashier, waiter, amount, discount, balance, ord_type, period, status, tid, sid, hall, kitchen, created_by, created_at, updated_by, updated_at)
    VALUES (OLD.id, OLD.shopId, OLD.invoice_number,  OLD.cashier, OLD.waiter, OLD.amount,  OLD.discount, OLD.balance, OLD.ord_type, OLD.period, OLD.status, OLD.tid, OLD.sid, OLD.hall,   OLD.kitchen,  OLD.created_by,  OLD.created_at,  OLD.updated_by,  OLD.updated_at );
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `salesTrails`
--

CREATE TABLE `salesTrails` (
  `id` int(11) NOT NULL,
  `shopId` int(11) DEFAULT NULL,
  `invoice_number` varchar(100) DEFAULT NULL,
  `waiter` int(11) DEFAULT NULL,
  `cashier` int(11) DEFAULT NULL,
  `amount` varchar(100) NOT NULL,
  `period` varchar(22) DEFAULT NULL,
  `discount` varchar(100) DEFAULT NULL,
  `balance` varchar(20) DEFAULT NULL,
  `status` enum('PAID','PENDING') DEFAULT 'PENDING',
  `tid` int(11) DEFAULT NULL,
  `sid` int(11) DEFAULT NULL,
  `hall` int(11) DEFAULT NULL,
  `ord_type` varchar(30) DEFAULT NULL,
  `nhil` varchar(30) DEFAULT NULL,
  `fund` varchar(30) DEFAULT NULL,
  `vat` varchar(30) DEFAULT NULL,
  `kitchen` varchar(20) DEFAULT 'Bar',
  `created_at` timestamp NULL DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `salesTrails`
--

INSERT INTO `salesTrails` (`id`, `shopId`, `invoice_number`, `waiter`, `cashier`, `amount`, `period`, `discount`, `balance`, `status`, `tid`, `sid`, `hall`, `ord_type`, `nhil`, `fund`, `vat`, `kitchen`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(6, 1, '3269317779', 3, 2, '5', '2019-05-08', '0', '5', 'PENDING', 1, 2, NULL, 'Dine-In', NULL, NULL, NULL, 'Bar', '2019-05-08 08:26:56', 1, NULL, NULL),
(3, 1, '1165565812', 3, 1, '84', '2018-05-04', '0', '84', 'PAID', 1, 2, NULL, 'Dine-In', NULL, NULL, NULL, 'Bar', '2019-05-04 18:43:28', 1, NULL, NULL),
(6, 1, '3269317779', 3, 2, '5', '2019-05-08', '0', '5', 'PENDING', 1, 2, NULL, 'Dine-In', NULL, NULL, NULL, 'Bar', '2019-05-08 08:26:56', 1, NULL, NULL),
(3, 1, '1165565812', 3, NULL, '84', '2018-05-04', '0', '84', 'PAID', 1, 2, NULL, 'Dine-In', NULL, NULL, NULL, 'Bar', '2019-05-04 18:43:28', 1, NULL, NULL),
(4, 1, '1336646211', NULL, 1, '54.5', '2019-02-10', '0', '54.5', 'PAID', NULL, NULL, NULL, 'Take Out', NULL, NULL, NULL, '', '2019-05-05 10:19:43', 1, NULL, NULL),
(6, 1, '3269317779', 3, NULL, '5', '2019-05-08', '0', '5', 'PAID', 1, 2, NULL, 'Dine-In', NULL, NULL, NULL, 'Bar', '2019-05-08 08:26:56', 1, NULL, NULL),
(3, 1, '1165565812', 3, NULL, '84', '2018-05-04', '0', '84', 'PENDING', 1, 2, NULL, 'Dine-In', NULL, NULL, NULL, 'Bar', '2019-05-04 18:43:28', 1, NULL, NULL),
(6, 1, '3269317779', 3, NULL, '5', '2019-05-08', '0', '5', 'PENDING', 1, 2, NULL, 'Dine-In', NULL, NULL, NULL, 'Bar', '2019-05-08 08:26:56', 1, NULL, NULL),
(3, 1, '1165565812', 3, 1, '84', '2018-05-04', '0', '84', 'PAID', 1, 2, NULL, 'Dine-In', NULL, NULL, NULL, 'Bar', '2019-05-04 18:43:28', 1, NULL, NULL),
(6, 1, '3269317779', 3, 1, '5', '2019-05-08', '0', '5', 'PAID', 1, 2, NULL, 'Dine-In', NULL, NULL, NULL, 'Bar', '2019-05-08 08:26:56', 1, NULL, NULL),
(2, 1, '2565961109', NULL, NULL, '11', '2017-04-30', '0', '11', 'PENDING', NULL, NULL, NULL, 'Take Out', NULL, NULL, NULL, '', '2019-05-02 14:45:00', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `seats`
--

CREATE TABLE `seats` (
  `id` int(11) NOT NULL,
  `tid` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `shopId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `seats`
--

INSERT INTO `seats` (`id`, `tid`, `name`, `shopId`) VALUES
(1, 3, '1', 1),
(2, 1, '2', 1);

-- --------------------------------------------------------

--
-- Table structure for table `shops`
--

CREATE TABLE `shops` (
  `id` int(11) NOT NULL,
  `shopName` varchar(200) NOT NULL,
  `address` varchar(200) NOT NULL,
  `logo` varchar(100) DEFAULT NULL,
  `shopEmail` varchar(100) DEFAULT NULL,
  `shopPhoneNum` varchar(100) DEFAULT NULL,
  `status` enum('Child','Parent') DEFAULT 'Child',
  `version` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `shops`
--

INSERT INTO `shops` (`id`, `shopName`, `address`, `logo`, `shopEmail`, `shopPhoneNum`, `status`, `version`) VALUES
(1, 'Mango\'s Place', 'No 14 Street, East Legon', '', 'mangos@gmail.com', '0553135336 | 0543977486', 'Parent', 'Vs-W2.0.0.'),
(2, 'Luckie\'s Place', '5, omoniyi street', NULL, 'luckie@gmail.com', '07037351836', 'Child', NULL),
(3, 'Luckie\'s Place', '5, omoniyi street', NULL, 'luckie@gmail.com', '07037351836', 'Child', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `id` int(11) NOT NULL,
  `shopId` int(11) NOT NULL,
  `supplier_name` varchar(100) DEFAULT NULL,
  `supplier_address` varchar(100) DEFAULT NULL,
  `supplier_contact` varchar(100) DEFAULT NULL,
  `contact_person` varchar(100) NOT NULL,
  `note` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`id`, `shopId`, `supplier_name`, `supplier_address`, `supplier_contact`, `contact_person`, `note`) VALUES
(1, 1, 'Mercy Gold store', 'iyaganku GRA, Ibadan', '04840474940', 'Aunty Anu', 'hello'),
(2, 1, 'Mike  Juice guy', 'iyaganku GRA, Ibadan', '95050594', 'Mike', 'Gallon sales'),
(3, 1, 'Mike  Juice guy', 'iyaganku GRA, Ibadan', '95050594', 'Mike', 'bulk sales'),
(4, 3, 'Dankuma store', 'dankuma bustop', '0244199015', 'Wisdom', '');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `shopId` int(11) DEFAULT NULL,
  `fullname` varchar(30) NOT NULL,
  `acc_email` varchar(50) DEFAULT NULL,
  `username` varchar(30) NOT NULL,
  `acc_password` text,
  `acc_status` enum('Active','Banned','Pending') DEFAULT 'Pending',
  `token` varchar(100) DEFAULT NULL,
  `acc_question` varchar(30) DEFAULT NULL,
  `acc_answer` varchar(255) DEFAULT NULL,
  `acc_phone` varchar(20) DEFAULT NULL,
  `position` varchar(30) NOT NULL,
  `role` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `shopId`, `fullname`, `acc_email`, `username`, `acc_password`, `acc_status`, `token`, `acc_question`, `acc_answer`, `acc_phone`, `position`, `role`, `created_at`, `updated_at`) VALUES
(1, 1, 'Akinniyi Bolade', NULL, 'beedyboy', '$2y$10$uxr1QgkRid6i5Ka2d7rXY.nW.FMj0W2/touepym/nXj9vfG4cMrqe', 'Pending', '17fd1899fd32ab84d13ba620424403fc', NULL, NULL, NULL, 'Super Admin', 'addSales,editSales,delSales,addUser,editUser,delUser,addMenu,editMenu,delMenu,\r\neditSupplier,addSupplier,delSupplier,\r\naddHall,editHall,delHall,addSeat,editSeat,delSeat,addTable,editTable,delTable,\r\naddPurchases,editPurchases,delPurchases,addFinished,editAllocation,addToKitchen', '2019-04-05 11:15:11', '2019-04-05 11:15:11'),
(2, 1, 'Sydney Ankrah', NULL, 'sydney', '$2y$10$DQIfPoq12HUp3ItVb.UcFOzxXVxrw5IBDxryPBhuAZjlbJlt9/5vG', 'Pending', '93fc508840b74e312a5d45084c0aa950', NULL, NULL, NULL, 'Supervisor', 'addSales,editSales,delSales,addUser,editUser,delUser,addMenu,editMenu,editSupplier,delSupplier,editHall,delHall,editSeat,delSeat,addTable,editTable,addPurchases,delPurchases,editAllocation,addFinished', '2019-04-05 12:06:28', '2019-05-08 01:15:48'),
(3, 1, 'Joseph Kayode', NULL, 'kayode', '$2y$10$G4N84yfBkYByY5LNAzWPZO2tGr8V8p8JBCjX4m06LtkwQwQcXIDz.', 'Pending', '6246dd3fbbb7d8857e06559c4f2d2320', NULL, NULL, NULL, 'Waiter', 'editSales,delSales,addUser,editUser,editMenu,delMenu,addSupplier,delSupplier,addHall,delHall,editSeat', '2019-04-30 09:22:51', '2019-04-30 09:22:51'),
(4, 1, 'Aluko Oluwasegun', NULL, 'segzy', '$2y$10$zgNnTOWEn1IZAow50dlpv.wb4zk3cHq64MW0w3qIWIeiXOq5wRaKe', 'Pending', '57b318ffaca6c8be577df59c34b953b0', NULL, NULL, NULL, 'Cashier', 'editSales,editUser,editMenu,delMenu,addSupplier,delSupplier,editHall,editSeat,editTable,delTable,addPurchases,delPurchases,addToKitchen,addFinished', '2019-05-05 16:04:41', '2019-05-08 01:13:22'),
(6, 1, 'Akinniyi Boluwatife', NULL, 'sage', '$2y$10$QmO6J0iMLt4twRNGnwMzDeMPt2CpfXJ8qcNmo/o1NAfbTpDZwn1m2', 'Pending', 'a0678ee21658ab9d83efa9879a51e493', NULL, NULL, NULL, 'Admin', 'addSales,editSales,delSales,addUser,editUser,delUser,addMenu,editMenu,delMenu,editSupplier,addSupplier,delSupplier,addHall,editHall,delHall,addSeat,editSeat,delSeat,addTable,editTable,delTable,addPurchases,editPurchases,delPurchases,addFinished,editAllocation,addToKitchen', '2019-05-06 10:34:52', '2019-05-06 10:34:52'),
(9, 1, 'Odeyemi Tolulope', NULL, 'tolu', '$2y$10$Si1.yMdOuYYAdD/l01h5wuWox5VD2lxCuU//Z0KRxRbOXF8BLTXxa', 'Pending', NULL, NULL, NULL, NULL, 'Admin', 'addSales,delSales,editSales,addUser,editUser,delUser,addMenu,delMenu,addSupplier,delSupplier,addHall,editHall,addSeat,delSeat,editTable,delTable,editPurchases,addPurchases,editAllocation,addFinished', '2019-05-06 11:06:06', '2019-05-06 11:06:06'),
(10, 2, 'Akinniyi Bolade', NULL, 'luckie', '$2y$10$Ezdl8W.Fzj7fQ7T4pao2KO0pmB7xv9f6MqmPoDUScIHk2vI/wVskq', 'Pending', '2a740e86437ad99687d36bfe83a1d141', NULL, NULL, NULL, 'Super Admin', 'addSales,editSales,delSales,\naddUser,editUser,delUser,\naddMenu,editMenu,delMenu,\neditSupplier,addSupplier,delSupplier,\naddHall,editHall,delHall, addSeat,editSeat,delSeat,addTable,editTable,delTable,\naddPurchases,editPurchases,delPurchases,addFinished,editAllocation,addToKitchen', '2019-05-06 14:07:40', '2019-05-06 14:07:40'),
(11, 3, 'akinniyi bolade', NULL, 'abraham', '$2y$10$cvWBL4imuAGH.fnLtfw7QunD3VM6lskBkzXhsN1EDBJcO0Qt77R1K', 'Pending', '595548330b22c5adff09533aba31b135', NULL, NULL, NULL, 'Super Admin', 'addSales,editSales,delSales, addUser,editUser,delUser,addMenu,editMenu,delMenu,editSupplier,addSupplier,delSupplier,addHall,editHall,delHall, addSeat,editSeat,delSeat,addTable,editTable,delTable,addPurchases,editPurchases,delPurchases,addFinished,editAllocation,addToKitchen', '2019-05-08 01:24:10', '2019-05-08 01:24:10');

-- --------------------------------------------------------

--
-- Table structure for table `usersessions`
--

CREATE TABLE `usersessions` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `session` varchar(255) NOT NULL,
  `user_agent` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `acquisitions`
--
ALTER TABLE `acquisitions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `shopId` (`shopId`),
  ADD KEY `itemId` (`itemId`),
  ADD KEY `updated_by` (`updated_by`),
  ADD KEY `created_by` (`created_by`);

--
-- Indexes for table `acquisitionsTrails`
--
ALTER TABLE `acquisitionsTrails`
  ADD KEY `shopId` (`shopId`),
  ADD KEY `itemId` (`itemId`),
  ADD KEY `updated_by` (`updated_by`),
  ADD KEY `created_by` (`created_by`);

--
-- Indexes for table `applications`
--
ALTER TABLE `applications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `shopId` (`shopId`),
  ADD KEY `updated_by` (`updated_by`);

--
-- Indexes for table `halls`
--
ALTER TABLE `halls`
  ADD PRIMARY KEY (`id`),
  ADD KEY `shopId` (`shopId`);

--
-- Indexes for table `htables`
--
ALTER TABLE `htables`
  ADD PRIMARY KEY (`id`),
  ADD KEY `shopId` (`shopId`),
  ADD KEY `hid` (`hid`);

--
-- Indexes for table `orderdetails`
--
ALTER TABLE `orderdetails`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `id` (`id`),
  ADD KEY `shopId` (`shopId`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `updated_by` (`updated_by`),
  ADD KEY `shopId` (`shopId`);

--
-- Indexes for table `productsTrails`
--
ALTER TABLE `productsTrails`
  ADD KEY `created_by` (`created_by`),
  ADD KEY `updated_by` (`updated_by`),
  ADD KEY `shopId` (`shopId`);

--
-- Indexes for table `purchases`
--
ALTER TABLE `purchases`
  ADD PRIMARY KEY (`id`),
  ADD KEY `shopId` (`shopId`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `updated_by` (`updated_by`),
  ADD KEY `supplierId` (`supplierId`),
  ADD KEY `supplierId_2` (`supplierId`);

--
-- Indexes for table `purchasesTrails`
--
ALTER TABLE `purchasesTrails`
  ADD KEY `shopId` (`shopId`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `updated_by` (`updated_by`),
  ADD KEY `supplierId` (`supplierId`),
  ADD KEY `supplierId_2` (`supplierId`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tid` (`tid`),
  ADD KEY `hall` (`hall`),
  ADD KEY `hall_2` (`hall`),
  ADD KEY `sid` (`sid`),
  ADD KEY `waiter` (`waiter`),
  ADD KEY `cashier` (`cashier`),
  ADD KEY `shopId` (`shopId`),
  ADD KEY `updated_by` (`updated_by`),
  ADD KEY `created_by` (`created_by`);

--
-- Indexes for table `salesTrails`
--
ALTER TABLE `salesTrails`
  ADD KEY `shopId` (`shopId`),
  ADD KEY `waiter` (`waiter`),
  ADD KEY `cashier` (`cashier`),
  ADD KEY `tid` (`tid`),
  ADD KEY `sid` (`sid`),
  ADD KEY `hall` (`hall`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `updated_by` (`updated_by`);

--
-- Indexes for table `seats`
--
ALTER TABLE `seats`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tid` (`tid`),
  ADD KEY `shopId` (`shopId`);

--
-- Indexes for table `shops`
--
ALTER TABLE `shops`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `shopId` (`shopId`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `shopId` (`shopId`);

--
-- Indexes for table `usersessions`
--
ALTER TABLE `usersessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `acquisitions`
--
ALTER TABLE `acquisitions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `applications`
--
ALTER TABLE `applications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `halls`
--
ALTER TABLE `halls`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `htables`
--
ALTER TABLE `htables`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `orderdetails`
--
ALTER TABLE `orderdetails`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `purchases`
--
ALTER TABLE `purchases`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `seats`
--
ALTER TABLE `seats`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `shops`
--
ALTER TABLE `shops`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `usersessions`
--
ALTER TABLE `usersessions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `acquisitions`
--
ALTER TABLE `acquisitions`
  ADD CONSTRAINT `acquisitions_ibfk_1` FOREIGN KEY (`shopId`) REFERENCES `shops` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `acquisitions_ibfk_2` FOREIGN KEY (`itemId`) REFERENCES `purchases` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `acquisitions_ibfk_3` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `acquisitions_ibfk_4` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `acquisitionsTrails`
--
ALTER TABLE `acquisitionsTrails`
  ADD CONSTRAINT `acquisitionsTrails_ibfk_1` FOREIGN KEY (`shopId`) REFERENCES `shops` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `acquisitionsTrails_ibfk_2` FOREIGN KEY (`itemId`) REFERENCES `purchases` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `acquisitionsTrails_ibfk_3` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `acquisitionsTrails_ibfk_4` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `applications`
--
ALTER TABLE `applications`
  ADD CONSTRAINT `applications_ibfk_1` FOREIGN KEY (`shopId`) REFERENCES `shops` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `applications_ibfk_2` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `halls`
--
ALTER TABLE `halls`
  ADD CONSTRAINT `halls_ibfk_1` FOREIGN KEY (`shopId`) REFERENCES `shops` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `htables`
--
ALTER TABLE `htables`
  ADD CONSTRAINT `htables_ibfk_1` FOREIGN KEY (`shopId`) REFERENCES `shops` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `htables_ibfk_2` FOREIGN KEY (`hid`) REFERENCES `halls` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `orderdetails`
--
ALTER TABLE `orderdetails`
  ADD CONSTRAINT `orderdetails_ibfk_1` FOREIGN KEY (`shopId`) REFERENCES `shops` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `orderdetails_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`shopId`) REFERENCES `shops` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `products_ibfk_2` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `products_ibfk_3` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `productsTrails`
--
ALTER TABLE `productsTrails`
  ADD CONSTRAINT `productsTrails_ibfk_1` FOREIGN KEY (`shopId`) REFERENCES `shops` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `productsTrails_ibfk_2` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `productsTrails_ibfk_3` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `purchases`
--
ALTER TABLE `purchases`
  ADD CONSTRAINT `purchases_ibfk_1` FOREIGN KEY (`shopId`) REFERENCES `shops` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `purchases_ibfk_2` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `purchases_ibfk_3` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `purchases_ibfk_4` FOREIGN KEY (`supplierId`) REFERENCES `suppliers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `purchasesTrails`
--
ALTER TABLE `purchasesTrails`
  ADD CONSTRAINT `purchasesTrails_ibfk_1` FOREIGN KEY (`shopId`) REFERENCES `shops` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `purchasesTrails_ibfk_2` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `purchasesTrails_ibfk_3` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `purchasesTrails_ibfk_4` FOREIGN KEY (`supplierId`) REFERENCES `suppliers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `sales`
--
ALTER TABLE `sales`
  ADD CONSTRAINT `sales_ibfk_1` FOREIGN KEY (`waiter`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `sales_ibfk_2` FOREIGN KEY (`cashier`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `sales_ibfk_3` FOREIGN KEY (`shopId`) REFERENCES `shops` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `sales_ibfk_4` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `sales_ibfk_5` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `salesTrails`
--
ALTER TABLE `salesTrails`
  ADD CONSTRAINT `salesTrails_ibfk_1` FOREIGN KEY (`shopId`) REFERENCES `shops` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `salesTrails_ibfk_2` FOREIGN KEY (`waiter`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `salesTrails_ibfk_3` FOREIGN KEY (`cashier`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `salesTrails_ibfk_4` FOREIGN KEY (`tid`) REFERENCES `htables` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `salesTrails_ibfk_5` FOREIGN KEY (`sid`) REFERENCES `seats` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `salesTrails_ibfk_6` FOREIGN KEY (`hall`) REFERENCES `halls` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `salesTrails_ibfk_7` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `salesTrails_ibfk_8` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `seats`
--
ALTER TABLE `seats`
  ADD CONSTRAINT `seats_ibfk_1` FOREIGN KEY (`shopId`) REFERENCES `shops` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `seats_ibfk_2` FOREIGN KEY (`tid`) REFERENCES `htables` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD CONSTRAINT `suppliers_ibfk_1` FOREIGN KEY (`shopId`) REFERENCES `shops` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`shopId`) REFERENCES `shops` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
