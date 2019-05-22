-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 21, 2019 at 08:49 PM
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
  `created_at` varchar(30) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
  `created_at` varchar(30) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
  `updated_at` varchar(30) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `applications`
--

INSERT INTO `applications` (`id`, `shopId`, `currency`, `usermode`, `pageLimit`, `updated_at`, `updated_by`) VALUES
(1, 1, 'â‚µ', 'Maintenance', 10, '18-05-2019 10:46:39am', 1),
(2, 3, 'â‚¦', 'Maintenance', 10, '2019-05-08 09:01:52', 11);

-- --------------------------------------------------------

--
-- Table structure for table `halls`
--

CREATE TABLE `halls` (
  `id` int(11) NOT NULL,
  `shopId` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `created_at` varchar(30) NOT NULL,
  `updated_at` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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

-- --------------------------------------------------------

--
-- Table structure for table `menus`
--

CREATE TABLE `menus` (
  `id` int(11) NOT NULL,
  `shopId` int(11) NOT NULL,
  `food` varchar(100) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `created_at` varchar(30) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_at` varchar(30) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
  `menu_id` int(11) NOT NULL,
  `nhil` varchar(30) DEFAULT NULL,
  `fund` varchar(30) DEFAULT NULL,
  `vat` varchar(30) DEFAULT NULL,
  `discount` varchar(20) DEFAULT NULL,
  `created_at` varchar(30) NOT NULL,
  `updated_at` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
  `created_at` varchar(30) DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `updated_at` varchar(30) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
  `created_at` varchar(30) DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `updated_at` varchar(30) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
  `created_at` varchar(30) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
  `created_at` varchar(30) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` varchar(30) DEFAULT NULL,
  `note` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
  `kitchen` enum('Continental','Local','Bar') DEFAULT 'Local',
  `kitchen_status` enum('Approved','Pending') DEFAULT 'Pending',
  `approved_by` int(11) DEFAULT NULL,
  `created_at` varchar(30) DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `updated_at` varchar(30) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Triggers `sales`
--
DELIMITER $$
CREATE TRIGGER `salesTrigger` BEFORE UPDATE ON `sales` FOR EACH ROW BEGIN
    INSERT INTO salesTrails (id, shopId, invoice_number, cashier, waiter, amount, discount, balance, ord_type, period, nhil, fund, vat, status, tid, sid, hall, kitchen, kitchen_status,approved_by, created_by, created_at, updated_by, updated_at)
    VALUES (OLD.id, OLD.shopId, OLD.invoice_number,  OLD.cashier, OLD.waiter, OLD.amount,  OLD.discount, OLD.balance, OLD.ord_type, OLD.period, OLD. nhil, OLD.fund, OLD.vat, OLD.status, OLD.tid, OLD.sid, OLD.hall,   OLD.kitchen, OLD.kitchen_status, OLD.approved_by, OLD.created_by,  OLD.created_at,  OLD.updated_by,  OLD.updated_at );
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
  `kitchen` enum('Continental','Local','Bar') DEFAULT 'Local',
  `kitchen_status` enum('Approved','Pending') DEFAULT 'Pending',
  `approved_by` int(11) DEFAULT NULL,
  `created_at` varchar(30) DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `updated_at` varchar(30) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
(1, 'Mango\'s Restaurant', 'No 14 Street, East Legon', '', 'mangos@gmail.com', '0553135336 | 0543977486', 'Parent', 'Vs-W2.0.0.'),
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
  `acc_status` enum('Active','Banned','Deleted') DEFAULT 'Active',
  `token` varchar(100) DEFAULT NULL,
  `acc_question` varchar(30) DEFAULT NULL,
  `acc_answer` varchar(255) DEFAULT NULL,
  `acc_phone` varchar(20) DEFAULT NULL,
  `position` varchar(30) NOT NULL,
  `role` text NOT NULL,
  `created_at` varchar(30) DEFAULT NULL,
  `updated_at` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `shopId`, `fullname`, `acc_email`, `username`, `acc_password`, `acc_status`, `token`, `acc_question`, `acc_answer`, `acc_phone`, `position`, `role`, `created_at`, `updated_at`) VALUES
(1, 1, 'Akinniyi Bolade', NULL, 'beedyboy', '$2y$10$uxr1QgkRid6i5Ka2d7rXY.nW.FMj0W2/touepym/nXj9vfG4cMrqe', 'Active', '11da1fe89fbdc50393fe456923393f41', NULL, NULL, NULL, 'Super Admin', 'addSales,editSales,delSales,addUser,editUser,delUser,addMenu,editMenu,delMenu,\r\neditSupplier,addSupplier,delSupplier,\r\naddHall,editHall,delHall,addSeat,editSeat,delSeat,addTable,editTable,delTable,\r\naddPurchases,editPurchases,delPurchases,addFinished,editAllocation,addToKitchen', '2019-04-05 12:15:11', '2019-04-05 12:15:11'),
(2, 1, 'Sydney Ankrah', NULL, 'sydney', '$2y$10$DQIfPoq12HUp3ItVb.UcFOzxXVxrw5IBDxryPBhuAZjlbJlt9/5vG', 'Active', 'bd01bac39ac5cb95bdd50e0b05ec27c0', NULL, NULL, NULL, 'Supervisor', 'addSales,editSales,delSales,addUser,editUser,delUser,addMenu,editMenu,editSupplier,delSupplier,editHall,delHall,editSeat,delSeat,addTable,editTable,addPurchases,delPurchases,editAllocation,addFinished', '2019-04-05 13:06:28', '2019-05-08 02:15:48'),
(3, 1, 'Joseph Kayode', NULL, 'kayode', '$2y$10$G4N84yfBkYByY5LNAzWPZO2tGr8V8p8JBCjX4m06LtkwQwQcXIDz.', 'Deleted', '6246dd3fbbb7d8857e06559c4f2d2320', NULL, NULL, NULL, 'Waiter', 'editSales,delSales,addUser,editUser,editMenu,delMenu,addSupplier,delSupplier,addHall,delHall,editSeat', '2019-04-30 10:22:51', '15-05-2019 14:46:41pm'),
(4, 1, 'Aluko Oluwasegun', NULL, 'segzy', '$2y$10$zgNnTOWEn1IZAow50dlpv.wb4zk3cHq64MW0w3qIWIeiXOq5wRaKe', 'Active', 'cace19c018fbbe61d16d34a0465b536d', NULL, NULL, NULL, 'Cashier', 'editSales,editUser,addUser,delUser,editMenu,delMenu,addSupplier,delSupplier,addHall,editHall,editSeat,addSeat,editTable,delTable,addPurchases,delPurchases,addFinished,addToKitchen', '2019-05-05 17:04:41', '18-05-2019 08:51:57am'),
(6, 1, 'Akinniyi Boluwatife', NULL, 'sage', '$2y$10$QmO6J0iMLt4twRNGnwMzDeMPt2CpfXJ8qcNmo/o1NAfbTpDZwn1m2', 'Active', 'd4788b5fb40cf0e8d8cacc812aa99157', NULL, NULL, NULL, 'Admin', 'addSales,editSales,delSales,addUser,editUser,delUser,addMenu,editMenu,delMenu,editSupplier,addSupplier,delSupplier,addHall,editHall,delHall,addSeat,editSeat,delSeat,addTable,editTable,delTable,addPurchases,editPurchases,delPurchases,addFinished,editAllocation,addToKitchen', '2019-05-06 11:34:52', '2019-05-06 11:34:52'),
(9, 1, 'Odeyemi Tolulope', NULL, 'tolu', '$2y$10$Si1.yMdOuYYAdD/l01h5wuWox5VD2lxCuU//Z0KRxRbOXF8BLTXxa', 'Deleted', NULL, NULL, NULL, NULL, 'Admin', 'addSales,delSales,editSales,addUser,editUser,delUser,addMenu,delMenu,addSupplier,delSupplier,addHall,editHall,addSeat,delSeat,editTable,delTable,editPurchases,addPurchases,editAllocation,addFinished', '2019-05-06 12:06:06', '15-05-2019 14:46:56pm'),
(10, 2, 'Akinniyi Bolade', NULL, 'luckie', '$2y$10$Ezdl8W.Fzj7fQ7T4pao2KO0pmB7xv9f6MqmPoDUScIHk2vI/wVskq', 'Active', '2a740e86437ad99687d36bfe83a1d141', NULL, NULL, NULL, 'Super Admin', 'addSales,editSales,delSales,\naddUser,editUser,delUser,\naddMenu,editMenu,delMenu,\neditSupplier,addSupplier,delSupplier,\naddHall,editHall,delHall, addSeat,editSeat,delSeat,addTable,editTable,delTable,\naddPurchases,editPurchases,delPurchases,addFinished,editAllocation,addToKitchen', '2019-05-06 15:07:40', '2019-05-06 15:07:40'),
(11, 3, 'akinniyi bolade', NULL, 'abraham', '$2y$10$cvWBL4imuAGH.fnLtfw7QunD3VM6lskBkzXhsN1EDBJcO0Qt77R1K', 'Active', '595548330b22c5adff09533aba31b135', NULL, NULL, NULL, 'Super Admin', 'addSales,editSales,delSales, addUser,editUser,delUser,addMenu,editMenu,delMenu,editSupplier,addSupplier,delSupplier,addHall,editHall,delHall, addSeat,editSeat,delSeat,addTable,editTable,delTable,addPurchases,editPurchases,delPurchases,addFinished,editAllocation,addToKitchen', '2019-05-08 02:24:10', '2019-05-08 02:24:10'),
(13, 1, 'Tife', NULL, 'tife', '$2y$10$AgVt6v0xgsbv3ApZwvgSQuvpRmzc3RpPNcUt0og4Zzjr/iJ9O9Wdq', 'Active', '98dcf4fb771765f3597c2f30482a62e2', NULL, NULL, NULL, 'Waiter', 'editUser,editSupplier,addTable,editTable', '17-05-2019 21:56:15pm', '18-05-2019 22:00:06pm');

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
-- Indexes for table `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`id`),
  ADD KEY `shopId` (`shopId`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `updated_by` (`updated_by`);

--
-- Indexes for table `orderdetails`
--
ALTER TABLE `orderdetails`
  ADD PRIMARY KEY (`id`),
  ADD KEY `shopId` (`shopId`),
  ADD KEY `menu_id` (`menu_id`) USING BTREE;

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
  ADD KEY `created_by` (`created_by`),
  ADD KEY `approved_by` (`approved_by`);

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
  ADD KEY `updated_by` (`updated_by`),
  ADD KEY `approved_by` (`approved_by`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `htables`
--
ALTER TABLE `htables`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
--
-- AUTO_INCREMENT for table `menus`
--
ALTER TABLE `menus`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `orderdetails`
--
ALTER TABLE `orderdetails`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;
--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;
--
-- AUTO_INCREMENT for table `purchases`
--
ALTER TABLE `purchases`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `seats`
--
ALTER TABLE `seats`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT for table `shops`
--
ALTER TABLE `shops`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
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
-- Constraints for table `menus`
--
ALTER TABLE `menus`
  ADD CONSTRAINT `menus_ibfk_1` FOREIGN KEY (`shopId`) REFERENCES `shops` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `menus_ibfk_2` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `menus_ibfk_3` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `orderdetails`
--
ALTER TABLE `orderdetails`
  ADD CONSTRAINT `orderdetails_ibfk_1` FOREIGN KEY (`shopId`) REFERENCES `shops` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `orderdetails_ibfk_2` FOREIGN KEY (`menu_id`) REFERENCES `menus` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

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
  ADD CONSTRAINT `sales_ibfk_5` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `sales_ibfk_6` FOREIGN KEY (`approved_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

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
  ADD CONSTRAINT `salesTrails_ibfk_8` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `salesTrails_ibfk_9` FOREIGN KEY (`approved_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

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
