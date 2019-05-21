-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 21, 2019 at 06:20 PM
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
(4, 1, 'Aluko Oluwasegun', NULL, 'segzy', '$2y$10$zgNnTOWEn1IZAow50dlpv.wb4zk3cHq64MW0w3qIWIeiXOq5wRaKe', 'Active', 'dc9b2199c72db5f191b1e7161da597b8', NULL, NULL, NULL, 'Cashier', 'editSales,editUser,addUser,delUser,editMenu,delMenu,addSupplier,delSupplier,addHall,editHall,editSeat,addSeat,editTable,delTable,addPurchases,delPurchases,addFinished,addToKitchen', '2019-05-05 17:04:41', '18-05-2019 08:51:57am'),
(6, 1, 'Akinniyi Boluwatife', NULL, 'sage', '$2y$10$QmO6J0iMLt4twRNGnwMzDeMPt2CpfXJ8qcNmo/o1NAfbTpDZwn1m2', 'Active', 'd4788b5fb40cf0e8d8cacc812aa99157', NULL, NULL, NULL, 'Admin', 'addSales,editSales,delSales,addUser,editUser,delUser,addMenu,editMenu,delMenu,editSupplier,addSupplier,delSupplier,addHall,editHall,delHall,addSeat,editSeat,delSeat,addTable,editTable,delTable,addPurchases,editPurchases,delPurchases,addFinished,editAllocation,addToKitchen', '2019-05-06 11:34:52', '2019-05-06 11:34:52'),
(9, 1, 'Odeyemi Tolulope', NULL, 'tolu', '$2y$10$Si1.yMdOuYYAdD/l01h5wuWox5VD2lxCuU//Z0KRxRbOXF8BLTXxa', 'Deleted', NULL, NULL, NULL, NULL, 'Admin', 'addSales,delSales,editSales,addUser,editUser,delUser,addMenu,delMenu,addSupplier,delSupplier,addHall,editHall,addSeat,delSeat,editTable,delTable,editPurchases,addPurchases,editAllocation,addFinished', '2019-05-06 12:06:06', '15-05-2019 14:46:56pm'),
(10, 2, 'Akinniyi Bolade', NULL, 'luckie', '$2y$10$Ezdl8W.Fzj7fQ7T4pao2KO0pmB7xv9f6MqmPoDUScIHk2vI/wVskq', 'Active', '2a740e86437ad99687d36bfe83a1d141', NULL, NULL, NULL, 'Super Admin', 'addSales,editSales,delSales,\naddUser,editUser,delUser,\naddMenu,editMenu,delMenu,\neditSupplier,addSupplier,delSupplier,\naddHall,editHall,delHall, addSeat,editSeat,delSeat,addTable,editTable,delTable,\naddPurchases,editPurchases,delPurchases,addFinished,editAllocation,addToKitchen', '2019-05-06 15:07:40', '2019-05-06 15:07:40'),
(11, 3, 'akinniyi bolade', NULL, 'abraham', '$2y$10$cvWBL4imuAGH.fnLtfw7QunD3VM6lskBkzXhsN1EDBJcO0Qt77R1K', 'Active', '595548330b22c5adff09533aba31b135', NULL, NULL, NULL, 'Super Admin', 'addSales,editSales,delSales, addUser,editUser,delUser,addMenu,editMenu,delMenu,editSupplier,addSupplier,delSupplier,addHall,editHall,delHall, addSeat,editSeat,delSeat,addTable,editTable,delTable,addPurchases,editPurchases,delPurchases,addFinished,editAllocation,addToKitchen', '2019-05-08 02:24:10', '2019-05-08 02:24:10'),
(13, 1, 'Tife', NULL, 'tife', '$2y$10$AgVt6v0xgsbv3ApZwvgSQuvpRmzc3RpPNcUt0og4Zzjr/iJ9O9Wdq', 'Active', '98dcf4fb771765f3597c2f30482a62e2', NULL, NULL, NULL, 'Waiter', 'editUser,editSupplier,addTable,editTable', '17-05-2019 21:56:15pm', '18-05-2019 22:00:06pm');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `applications`
--
ALTER TABLE `applications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `shopId` (`shopId`),
  ADD KEY `updated_by` (`updated_by`);

--
-- Indexes for table `shops`
--
ALTER TABLE `shops`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `shopId` (`shopId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `applications`
--
ALTER TABLE `applications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `shops`
--
ALTER TABLE `shops`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `applications`
--
ALTER TABLE `applications`
  ADD CONSTRAINT `applications_ibfk_1` FOREIGN KEY (`shopId`) REFERENCES `shops` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `applications_ibfk_2` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`shopId`) REFERENCES `shops` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
