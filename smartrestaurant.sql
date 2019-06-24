-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 24, 2019 at 10:35 AM
-- Server version: 5.7.26-0ubuntu0.18.04.1
-- PHP Version: 7.2.19-1+ubuntu18.04.1+deb.sury.org+1

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
(1, 1, 'â‚µ', 'Maintenance', 10, '18-05-2019 10:46:39am', 1);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `shopId` int(11) NOT NULL,
  `kitchenId` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` varchar(30) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `shopId`, `kitchenId`, `name`, `created_by`, `created_at`, `updated_by`, `updated_at`) VALUES
(3, 1, 3, 'Chicken Meal', 2, '28-05-2019 11:10:29am', NULL, NULL),
(4, 1, 3, 'Goat Meal', 2, '28-05-2019 11:10:47am', NULL, NULL),
(5, 1, 3, 'Fish Meal', 2, '28-05-2019 11:10:58am', NULL, NULL),
(6, 1, 3, 'Extra', 2, '28-05-2019 11:11:12am', NULL, NULL),
(7, 1, 4, 'Plate Serving', 2, '28-05-2019 11:49:50am', NULL, NULL),
(8, 1, 4, 'Extra', 2, '28-05-2019 11:53:48am', NULL, NULL),
(9, 1, 4, 'Side Orders', 2, '28-05-2019 11:57:38am', NULL, NULL),
(10, 1, 4, 'Meat', 2, '28-05-2019 12:04:08pm', NULL, NULL),
(11, 1, 4, 'Soup', 2, '28-05-2019 12:12:08pm', NULL, NULL),
(12, 1, 4, 'Fish', 2, '28-05-2019 12:14:01pm', NULL, NULL),
(13, 1, 5, 'Soft drinks', 2, '28-05-2019 12:51:04pm', NULL, NULL),
(14, 1, 5, 'Juice', 2, '28-05-2019 12:53:15pm', NULL, NULL),
(15, 1, 5, 'Alcohol', 2, '28-05-2019 12:55:27pm', NULL, NULL),
(16, 1, 5, 'tot', 2, '28-05-2019 13:02:24pm', NULL, NULL),
(17, 1, 5, 'Full Bottle', 2, '28-05-2019 13:13:54pm', NULL, NULL);

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

--
-- Dumping data for table `halls`
--

INSERT INTO `halls` (`id`, `shopId`, `name`, `created_at`, `updated_at`) VALUES
(7, 1, 'Yellow Zone A', '28-05-2019 12:25:07pm', '28-05-2019 12:25:07pm'),
(8, 1, 'Yellow Zone B', '28-05-2019 12:25:18pm', '28-05-2019 12:25:18pm'),
(9, 1, 'Yellow Zone C', '28-05-2019 12:25:26pm', '28-05-2019 12:25:26pm'),
(10, 1, 'Yellow Zone D', '28-05-2019 12:25:36pm', '28-05-2019 12:25:36pm'),
(11, 1, 'Yellow Zone E', '28-05-2019 12:25:46pm', '28-05-2019 12:25:46pm');

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
(22, 1, 11, 'Yel-Yel-table-1'),
(23, 1, 7, 'Yel-table-2'),
(24, 1, 7, 'Yel-table-3'),
(25, 1, 7, 'Yel-table-4'),
(26, 1, 8, 'Yel-table-1'),
(27, 1, 8, 'Yel-table-2'),
(28, 1, 8, 'Yel-table-3'),
(29, 1, 9, 'Yel-table-1'),
(30, 1, 9, 'Yel-table-2'),
(31, 1, 9, 'Yel-table-3'),
(32, 1, 10, 'Yel-table-1'),
(33, 1, 10, 'Yel-table-2'),
(34, 1, 11, 'Yel-table-1'),
(35, 1, 11, 'Yel-table-2'),
(36, 1, 11, 'Yel-table-3');

-- --------------------------------------------------------

--
-- Table structure for table `kitchens`
--

CREATE TABLE `kitchens` (
  `id` int(11) NOT NULL,
  `shopId` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `base` enum('Yes','No') DEFAULT 'No',
  `accept` varchar(50) DEFAULT 'KitchenAttendant',
  `created_by` int(11) NOT NULL,
  `created_at` varchar(30) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kitchens`
--

INSERT INTO `kitchens` (`id`, `shopId`, `name`, `base`, `accept`, `created_by`, `created_at`, `updated_by`, `updated_at`) VALUES
(3, 1, 'Continental', 'No', 'KitchenAttendant', 2, '28-05-2019 11:09:44am', NULL, NULL),
(4, 1, 'Local', 'Yes', 'KitchenAttendant', 2, '28-05-2019 11:09:54am', 1, '23-06-2019 12:02:09pm'),
(5, 1, 'Bar', 'No', 'Bartender', 2, '28-05-2019 11:10:13am', 1, '23-06-2019 12:02:18pm');

-- --------------------------------------------------------

--
-- Table structure for table `menus`
--

CREATE TABLE `menus` (
  `id` int(11) NOT NULL,
  `shopId` int(11) NOT NULL,
  `catId` int(11) NOT NULL,
  `item` varchar(255) DEFAULT NULL,
  `price` varchar(20) NOT NULL,
  `created_at` varchar(30) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_at` varchar(30) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `menus`
--

INSERT INTO `menus` (`id`, `shopId`, `catId`, `item`, `price`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(3, 1, 3, 'Grilled Chicken with Plain Rice', '30', '28-05-2019 11:12:39am', 2, NULL, NULL),
(4, 1, 3, 'Grilled Chicken with Jollof Rice', '30', '28-05-2019 11:13:05am', 2, NULL, NULL),
(5, 1, 3, 'Grilled Chicken with Fried Rice', '30', '28-05-2019 11:13:44am', 2, NULL, NULL),
(6, 1, 3, 'Chicken with Yam', '30', '28-05-2019 11:14:23am', 2, '28-05-2019 11:14:59am', 2),
(7, 1, 3, 'Chicken with French Fries', '30', '28-05-2019 11:14:50am', 2, NULL, NULL),
(8, 1, 6, 'Plain Rice', '10', '28-05-2019 11:15:23am', 2, NULL, NULL),
(9, 1, 6, 'Jollof Rice', '15', '28-05-2019 11:15:43am', 2, NULL, NULL),
(10, 1, 6, 'Fried Rice', '15', '28-05-2019 11:15:57am', 2, NULL, NULL),
(11, 1, 6, 'Yam Chips', '10', '28-05-2019 11:16:15am', 2, NULL, NULL),
(12, 1, 6, 'French Fries', '10', '28-05-2019 11:16:36am', 2, NULL, NULL),
(13, 1, 6, 'Steam Vegetables', '10', '28-05-2019 11:17:21am', 2, NULL, NULL),
(14, 1, 6, 'Grilled Chicken only', '18', '28-05-2019 11:17:46am', 2, NULL, NULL),
(15, 1, 6, 'Fried Chicken only', '18', '28-05-2019 11:18:12am', 2, NULL, NULL),
(16, 1, 4, 'Fried Spicy Goat', '25', '28-05-2019 11:19:51am', 2, NULL, NULL),
(17, 1, 4, 'Goat with Jollof', '40', '28-05-2019 11:20:09am', 2, NULL, NULL),
(18, 1, 4, 'Goat with Fried Rice', '40', '28-05-2019 11:20:44am', 2, NULL, NULL),
(19, 1, 4, 'Assorted Fried Rice', '45', '28-05-2019 11:21:13am', 2, NULL, NULL),
(20, 1, 4, 'Assorted Jollof', '45', '28-05-2019 11:21:41am', 2, NULL, NULL),
(21, 1, 4, 'Goat with Plain Rice', '40', '28-05-2019 11:22:11am', 2, NULL, NULL),
(22, 1, 4, 'Goat with Yam', '40', '28-05-2019 11:22:40am', 2, NULL, NULL),
(23, 1, 4, 'Goat with French Fries', '40', '28-05-2019 11:23:10am', 2, NULL, NULL),
(24, 1, 5, 'Fried Fish (small) with Jollof', '35', '28-05-2019 11:25:48am', 2, NULL, NULL),
(25, 1, 5, 'Fried Fish (medium) with Jollof', '40', '28-05-2019 11:27:29am', 2, NULL, NULL),
(26, 1, 5, 'Fried Fish (large) with Jollof', '45', '28-05-2019 11:27:50am', 2, NULL, NULL),
(27, 1, 5, 'Fried Fish (small) with Plain Rice', '35', '28-05-2019 11:28:26am', 2, '28-05-2019 11:28:33am', 2),
(28, 1, 5, 'Fried Fish (medium) with Plain Ricea', '40', '28-05-2019 11:28:59am', 2, NULL, NULL),
(29, 1, 5, 'Fried Fish (large) with Plain Ricea', '45', '28-05-2019 11:29:28am', 2, NULL, NULL),
(30, 1, 5, 'Fried Fish (small) with Fried Rice', '35', '28-05-2019 11:30:00am', 2, NULL, NULL),
(31, 1, 5, 'Fried Fish (medium) with Fried Rice', '40', '28-05-2019 11:30:31am', 2, NULL, NULL),
(32, 1, 5, 'Fried Fish (large) with Fried Rice', '45', '28-05-2019 11:31:01am', 2, NULL, NULL),
(33, 1, 5, 'Fried Fish (small) with Yam', '35', '28-05-2019 11:31:43am', 2, NULL, NULL),
(34, 1, 5, 'Fried Fish (medium) with Yam', '40', '28-05-2019 11:32:03am', 2, NULL, NULL),
(35, 1, 5, 'Fried Fish (large) with Yam', '45', '28-05-2019 11:32:23am', 2, NULL, NULL),
(36, 1, 5, 'Fried Fish (small) with French Fries', '35', '28-05-2019 11:33:01am', 2, NULL, NULL),
(37, 1, 5, 'Fried Fish (medium) with French Fries', '40', '28-05-2019 11:33:25am', 2, NULL, NULL),
(38, 1, 5, 'Fried Fish (large) with French Fries', '45', '28-05-2019 11:34:02am', 2, NULL, NULL),
(39, 1, 5, 'Tilapia only Medium', '45', '28-05-2019 11:35:39am', 2, NULL, NULL),
(40, 1, 5, 'Tilapia only Large', '50', '28-05-2019 11:36:11am', 2, NULL, NULL),
(41, 1, 5, 'Tilapia(small) with Banku', '45', '28-05-2019 11:36:54am', 2, NULL, NULL),
(42, 1, 5, 'Tilapia(medium) with Banku', '50', '28-05-2019 11:37:23am', 2, NULL, NULL),
(43, 1, 5, 'Tilapia(large) with Banku', '55', '28-05-2019 11:37:46am', 2, NULL, NULL),
(44, 1, 5, 'Tilapia(small) with Fried Yam', '50', '28-05-2019 11:38:29am', 2, '28-05-2019 11:40:10am', 2),
(45, 1, 5, 'Tilapia(medium) with Fried Yam', '55', '28-05-2019 11:39:09am', 2, '28-05-2019 11:40:21am', 2),
(46, 1, 5, 'Tilapia(large) with Fried Yam', '60', '28-05-2019 11:39:55am', 2, '28-05-2019 11:40:29am', 2),
(47, 1, 5, 'Fried Fish only Small', '20', '28-05-2019 11:41:13am', 2, '28-05-2019 11:41:56am', 2),
(48, 1, 5, 'Fried Fish only Medium', '30', '28-05-2019 11:41:49am', 2, NULL, NULL),
(49, 1, 5, 'Fried Fish only Large', '35', '28-05-2019 11:42:28am', 2, NULL, NULL),
(50, 1, 5, 'Tilapia(small) with Fried Rice', '50', '28-05-2019 11:45:03am', 2, NULL, NULL),
(51, 1, 5, 'Tilapia(medium) with Fried Rice', '55', '28-05-2019 11:45:20am', 2, NULL, NULL),
(52, 1, 5, 'Tilapia(large) with Fried Rice', '60', '28-05-2019 11:45:37am', 2, NULL, NULL),
(53, 1, 7, 'MIxed Ampesi with Palava with Egg', '20', '28-05-2019 11:50:35am', 2, NULL, NULL),
(54, 1, 7, 'MIxed Ampesi with Palava with Egg with Tuna', '25', '28-05-2019 11:51:05am', 2, NULL, NULL),
(55, 1, 7, 'Red Red Egg', '20', '28-05-2019 11:51:38am', 2, NULL, NULL),
(56, 1, 7, 'Palava with Rice with Egg', '20', '28-05-2019 11:52:24am', 2, NULL, NULL),
(57, 1, 7, 'Palava with Rice with Egg with Tuna', '25', '28-05-2019 11:52:49am', 2, NULL, NULL),
(58, 1, 8, 'Palava Sauce only', '7', '28-05-2019 11:54:19am', 2, NULL, NULL),
(59, 1, 8, 'Apem Extra', '5', '28-05-2019 11:54:37am', 2, NULL, NULL),
(60, 1, 8, 'Fried Plantain only', '5', '28-05-2019 11:55:49am', 2, NULL, NULL),
(61, 1, 8, 'Yam only', '5', '28-05-2019 11:56:12am', 2, NULL, NULL),
(62, 1, 8, 'Extra Red Red', '7', '28-05-2019 11:56:38am', 2, NULL, NULL),
(63, 1, 9, 'Fufu Small', '5', '28-05-2019 11:58:48am', 2, NULL, NULL),
(64, 1, 9, 'Fufu Medium', '6', '28-05-2019 11:59:15am', 2, NULL, NULL),
(65, 1, 9, 'Fufu Large', '7', '28-05-2019 12:00:26pm', 2, NULL, NULL),
(66, 1, 9, 'Fufu XL', '8', '28-05-2019 12:00:41pm', 2, NULL, NULL),
(67, 1, 9, 'Fufu Epic', '9', '28-05-2019 12:01:21pm', 2, NULL, NULL),
(68, 1, 9, 'Fufu Supreme', '10', '28-05-2019 12:01:42pm', 2, NULL, NULL),
(69, 1, 10, 'Cow beef', '16', '28-05-2019 12:04:37pm', 2, NULL, NULL),
(70, 1, 10, 'Goat', '16', '28-05-2019 12:04:53pm', 2, NULL, NULL),
(71, 1, 10, 'Salted Beef', '7', '28-05-2019 12:05:41pm', 2, NULL, NULL),
(72, 1, 10, 'Grasscutter', '15', '28-05-2019 12:06:03pm', 2, NULL, NULL),
(73, 1, 10, 'Live Chicken', '15', '28-05-2019 12:06:23pm', 2, NULL, NULL),
(74, 1, 10, 'Smoked Cow', '16', '28-05-2019 12:07:48pm', 2, NULL, NULL),
(75, 1, 10, 'Smoked Goat', '16', '28-05-2019 12:08:21pm', 2, '28-05-2019 12:08:50pm', 2),
(76, 1, 10, 'Smoked Chicken', '15', '28-05-2019 12:08:43pm', 2, NULL, NULL),
(77, 1, 10, 'Chicken Wings', '7', '28-05-2019 12:09:15pm', 2, NULL, NULL),
(78, 1, 10, 'Pork Feet', '7', '28-05-2019 12:09:34pm', 2, NULL, NULL),
(79, 1, 10, 'Wele', '7', '28-05-2019 12:09:48pm', 2, NULL, NULL),
(80, 1, 10, 'Towel', '7', '28-05-2019 12:10:00pm', 2, NULL, NULL),
(81, 1, 10, 'Liver', '7', '28-05-2019 12:10:16pm', 2, NULL, NULL),
(82, 1, 10, 'Intestine', '7', '28-05-2019 12:10:29pm', 2, NULL, NULL),
(83, 1, 10, 'Boiled Egg', '1', '28-05-2019 12:10:48pm', 2, NULL, NULL),
(84, 1, 10, 'Snail Small', '12', '28-05-2019 12:11:08pm', 2, NULL, NULL),
(85, 1, 10, 'Snail Medium', '16', '28-05-2019 12:11:25pm', 2, NULL, NULL),
(86, 1, 10, 'Snail Large', '23', '28-05-2019 12:11:46pm', 2, NULL, NULL),
(87, 1, 11, 'Groundnut ', '0', '28-05-2019 12:12:39pm', 2, NULL, NULL),
(88, 1, 11, 'Palmnut', '0', '28-05-2019 12:13:17pm', 2, NULL, NULL),
(89, 1, 11, 'Light soup', '0', '28-05-2019 12:13:37pm', 2, NULL, NULL),
(90, 1, 12, 'Tilapia full ', '30', '28-05-2019 12:14:21pm', 2, NULL, NULL),
(91, 1, 12, 'Tilapia Half', '20', '28-05-2019 12:14:45pm', 2, NULL, NULL),
(92, 1, 12, 'Dry Fish', '30', '28-05-2019 12:15:14pm', 2, NULL, NULL),
(93, 1, 12, 'Fresh Salmon', '15', '28-05-2019 12:15:42pm', 2, NULL, NULL),
(94, 1, 12, 'Smoked Salmon', '15', '28-05-2019 12:16:00pm', 2, NULL, NULL),
(95, 1, 12, 'Tuna', '7', '28-05-2019 12:16:14pm', 2, NULL, NULL),
(96, 1, 12, 'Amani', '7', '28-05-2019 12:16:32pm', 2, NULL, NULL),
(97, 1, 12, 'Mushrooms', '5', '28-05-2019 12:16:57pm', 2, NULL, NULL),
(98, 1, 12, 'Crab', '7', '28-05-2019 12:17:12pm', 2, NULL, NULL),
(99, 1, 12, 'Point and Kill', '80', '28-05-2019 12:17:26pm', 2, NULL, NULL),
(100, 1, 13, 'Fanta', '7', '28-05-2019 12:51:21pm', 2, NULL, NULL),
(101, 1, 13, 'Coke', '7', '28-05-2019 12:51:32pm', 2, NULL, NULL),
(102, 1, 13, 'Sprite', '7', '28-05-2019 12:51:45pm', 2, NULL, NULL),
(103, 1, 13, 'Malta', '7', '28-05-2019 12:51:56pm', 2, NULL, NULL),
(104, 1, 13, 'Alvaro', '7', '28-05-2019 12:52:12pm', 2, NULL, NULL),
(105, 1, 14, 'Prepi Small', '7', '28-05-2019 12:53:41pm', 2, NULL, NULL),
(106, 1, 14, 'Prepi Large', '12', '28-05-2019 12:54:08pm', 2, NULL, NULL),
(107, 1, 14, 'Pre Ice small', '7', '28-05-2019 12:54:30pm', 2, NULL, NULL),
(108, 1, 14, 'Pre Ice Large', '12', '28-05-2019 12:54:49pm', 2, NULL, NULL),
(109, 1, 15, 'Guiness', '12', '28-05-2019 12:55:39pm', 2, NULL, NULL),
(110, 1, 15, 'Golda', '12', '28-05-2019 12:55:50pm', 2, NULL, NULL),
(111, 1, 15, 'Smirnoff', '12', '28-05-2019 12:56:06pm', 2, NULL, NULL),
(112, 1, 15, 'Star Large', '12', '28-05-2019 12:56:23pm', 2, NULL, NULL),
(113, 1, 15, 'Star small', '7', '28-05-2019 12:57:06pm', 2, NULL, NULL),
(114, 1, 15, 'Club large', '12', '28-05-2019 12:57:26pm', 2, NULL, NULL),
(115, 1, 15, 'Club small', '7', '28-05-2019 12:57:54pm', 2, NULL, NULL),
(116, 1, 15, 'Origin large', '12', '28-05-2019 12:58:13pm', 2, '28-05-2019 12:58:25pm', 2),
(117, 1, 15, 'Origin small', '7', '28-05-2019 12:58:52pm', 2, NULL, NULL),
(118, 1, 15, 'ABC large', '12', '28-05-2019 12:59:13pm', 2, NULL, NULL),
(119, 1, 15, 'ABC small', '7', '28-05-2019 12:59:28pm', 2, NULL, NULL),
(120, 1, 15, 'Shandy ', '12', '28-05-2019 13:00:09pm', 2, NULL, NULL),
(121, 1, 15, 'Hunters', '12', '28-05-2019 13:00:51pm', 2, NULL, NULL),
(122, 1, 15, 'Savannah', '12', '28-05-2019 13:01:03pm', 2, NULL, NULL),
(123, 1, 15, 'Red Bull', '12', '28-05-2019 13:01:17pm', 2, NULL, NULL),
(124, 1, 15, 'Kpoo Keke Bottle', '20', '28-05-2019 13:02:48pm', 2, NULL, NULL),
(125, 1, 16, 'Alomo Silver', '2', '28-05-2019 13:03:48pm', 2, '28-05-2019 13:07:25pm', 2),
(126, 1, 16, 'Madingo', '2', '28-05-2019 13:04:28pm', 2, NULL, NULL),
(127, 1, 16, 'Herb Afric', '2', '28-05-2019 13:04:41pm', 2, NULL, NULL),
(128, 1, 16, 'Castle Bridge', '2', '28-05-2019 13:04:55pm', 2, NULL, NULL),
(129, 1, 16, 'Kasapereko Dry Gin', '2', '28-05-2019 13:05:13pm', 2, '28-05-2019 13:08:11pm', 2),
(130, 1, 16, 'Strawberry', '2', '28-05-2019 13:06:00pm', 2, NULL, NULL),
(131, 1, 16, 'Alomo Gold', '2', '28-05-2019 13:07:40pm', 2, NULL, NULL),
(132, 1, 16, 'Alomo Black', '2', '28-05-2019 13:07:52pm', 2, NULL, NULL),
(133, 1, 16, 'Kasapereko Brandy', '2', '28-05-2019 13:08:33pm', 2, NULL, NULL),
(134, 1, 16, 'campari', '2', '28-05-2019 13:08:49pm', 2, NULL, NULL),
(135, 1, 16, 'Adonko', '2', '28-05-2019 13:09:06pm', 2, NULL, NULL),
(136, 1, 16, 'Adonko 123', '2', '28-05-2019 13:09:30pm', 2, NULL, NULL),
(137, 1, 16, 'Joy twedee', '2', '28-05-2019 13:09:55pm', 2, NULL, NULL),
(138, 1, 16, 'Origin Bitters', '2', '28-05-2019 13:10:19pm', 2, NULL, NULL),
(139, 1, 16, 'Agya Appiah', '2', '28-05-2019 13:10:37pm', 2, NULL, NULL),
(140, 1, 16, 'Tonic Wine', '2', '28-05-2019 13:10:53pm', 2, NULL, NULL),
(141, 1, 16, 'Wobeti', '2', '28-05-2019 13:11:30pm', 2, NULL, NULL),
(142, 1, 16, 'Lime', '1', '28-05-2019 13:11:45pm', 2, NULL, NULL),
(143, 1, 16, 'Smirnoff Vodka', '8', '28-05-2019 13:12:40pm', 2, NULL, NULL),
(144, 1, 16, 'Red Label', '10', '28-05-2019 13:13:00pm', 2, NULL, NULL),
(145, 1, 17, 'Red Label small', '30', '28-05-2019 13:14:20pm', 2, '28-05-2019 13:15:08pm', 2),
(146, 1, 17, 'JB small', '30', '28-05-2019 13:14:33pm', 2, NULL, NULL),
(147, 1, 17, 'Smirnoff Vodka small', '30', '28-05-2019 13:15:00pm', 2, NULL, NULL),
(148, 1, 16, 'Bailey\'s', '5', '28-05-2019 13:16:15pm', 2, NULL, NULL),
(149, 1, 17, 'Wine small', '30', '28-05-2019 13:16:35pm', 2, NULL, NULL),
(150, 1, 17, 'Wine Large', '80', '28-05-2019 13:17:00pm', 2, NULL, NULL),
(151, 1, 17, 'Wine medium', '40', '28-05-2019 13:17:38pm', 2, NULL, NULL),
(152, 1, 16, 'Label 5', '5', '28-05-2019 13:18:14pm', 2, NULL, NULL),
(153, 1, 16, 'Jameson', '5', '28-05-2019 13:18:30pm', 2, NULL, NULL),
(154, 1, 16, 'Joy Daddy', '2', '28-05-2019 13:20:20pm', 2, NULL, NULL),
(155, 1, 17, 'water', '3', '29-05-2019 10:24:51am', 19, NULL, NULL),
(156, 1, 8, 'Banku', '2', '30-05-2019 19:23:03pm', 2, NULL, NULL),
(157, 1, 8, 'Riceball', '2', '30-05-2019 19:23:48pm', 2, NULL, NULL),
(158, 1, 11, 'Green Soup', '0', '30-05-2019 19:24:34pm', 2, NULL, NULL),
(159, 1, 8, 'Konkonte', '5', '30-05-2019 19:28:43pm', 2, NULL, NULL),
(160, 1, 9, 'Aprepresan', '5', '30-05-2019 19:29:30pm', 2, NULL, NULL),
(161, 1, 7, 'Red Red with Tuna,Egg', '25', '31-05-2019 09:51:20am', 21, NULL, NULL),
(162, 1, 5, 'Grilled Tilapia(small) with Plain Rice', '50', '31-05-2019 10:48:58am', 21, NULL, NULL),
(163, 1, 5, 'Grilled Tilapia(medium) with Plain Rice', '60', '31-05-2019 10:49:44am', 21, NULL, NULL),
(164, 1, 5, 'Grilled Tilapia(Large) with Plain Rice', '70', '31-05-2019 10:50:04am', 21, NULL, NULL),
(165, 1, 11, 'Okro soup', '0', '31-05-2019 11:22:31am', 2, NULL, NULL),
(166, 1, 11, 'Goat Light soup', '0', '31-05-2019 11:26:52am', 2, NULL, NULL),
(167, 1, 11, 'ChickenLight soup', '0', '31-05-2019 11:29:09am', 2, NULL, NULL),
(168, 1, 11, 'Dry Fish Soup', '0', '31-05-2019 11:29:53am', 2, NULL, NULL),
(169, 1, 11, 'Tilapia soup', '0', '31-05-2019 11:30:29am', 2, NULL, NULL),
(170, 1, 6, 'plain rice ', '5', '31-05-2019 12:10:30pm', 21, NULL, NULL);

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
  `plate` tinyint(4) DEFAULT '1',
  `accept` varchar(50) DEFAULT 'KitchenAttendant',
  `accepted` enum('Yes','No') DEFAULT 'No',
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
  `hall` int(11) DEFAULT NULL,
  `ord_type` varchar(30) DEFAULT NULL,
  `period` varchar(20) DEFAULT NULL,
  `nhil` varchar(30) DEFAULT NULL,
  `fund` varchar(30) DEFAULT NULL,
  `vat` varchar(30) DEFAULT NULL,
  `kitchen_status` enum('Approved','Pending') DEFAULT 'Pending',
  `approved_by` int(11) DEFAULT NULL,
  `created_at` varchar(30) DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `updated_at` varchar(30) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `accept` text,
  `accepted` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Triggers `sales`
--
DELIMITER $$
CREATE TRIGGER `salesTrigger` BEFORE UPDATE ON `sales` FOR EACH ROW BEGIN
    INSERT INTO salesTrails (id, shopId, invoice_number, cashier, waiter, amount, discount, balance, ord_type, period, nhil, fund, vat, status, tid,  hall,  kitchen_status,approved_by, created_by, created_at, updated_by, updated_at, accept, accepted)
    VALUES (OLD.id, OLD.shopId, OLD.invoice_number,  OLD.cashier, OLD.waiter, OLD.amount,  OLD.discount, OLD.balance, OLD.ord_type, OLD.period, OLD. nhil, OLD.fund, OLD.vat, OLD.status, OLD.tid, OLD.hall, OLD.kitchen_status, OLD.approved_by, OLD.created_by,  OLD.created_at,  OLD.updated_by,  OLD.updated_at, OLD.accept, OLD.accepted );
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
  `hall` int(11) DEFAULT NULL,
  `ord_type` varchar(30) DEFAULT NULL,
  `nhil` varchar(30) DEFAULT NULL,
  `fund` varchar(30) DEFAULT NULL,
  `vat` varchar(30) DEFAULT NULL,
  `kitchen_status` enum('Approved','Pending') DEFAULT 'Pending',
  `approved_by` int(11) DEFAULT NULL,
  `created_at` varchar(30) DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `updated_at` varchar(30) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `accept` text,
  `accepted` text
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
(1, 'Mango\'s Restaurant', 'No 14 Street, East Legon', '', 'mangos@gmail.com', '0553135336 | 0543977486', 'Parent', 'Vs-W2.0.0.');

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
  `date_joined` varchar(20) DEFAULT NULL,
  `created_at` varchar(30) DEFAULT NULL,
  `updated_at` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `shopId`, `fullname`, `acc_email`, `username`, `acc_password`, `acc_status`, `token`, `acc_question`, `acc_answer`, `acc_phone`, `position`, `date_joined`, `created_at`, `updated_at`) VALUES
(1, 1, 'Akinniyi Bolade', NULL, 'beedyboy', '$2y$10$uxr1QgkRid6i5Ka2d7rXY.nW.FMj0W2/touepym/nXj9vfG4cMrqe', 'Active', '', NULL, NULL, NULL, 'SuperAdmin', NULL, '2019-04-05 12:15:11', '2019-04-05 12:15:11'),
(2, 1, 'Sydney Ankrah', NULL, 'sydney', '$2y$10$DQIfPoq12HUp3ItVb.UcFOzxXVxrw5IBDxryPBhuAZjlbJlt9/5vG', 'Active', '', NULL, NULL, NULL, 'SuperAdmin', NULL, '2019-04-05 13:06:28', '2019-05-08 02:15:48'),
(15, 1, 'Millicent', NULL, 'Milli', '$2y$10$FOEawncSJxYjEkE3xKqAVemdL4cZ9kQagpVK5fjwnoU/TrSPZcbhu', 'Active', '', NULL, NULL, NULL, 'Waiter', '2019-05-28', '28-05-2019 12:32:46pm', '28-05-2019 12:32:46pm'),
(16, 1, 'Stanley A', NULL, 'Stanley A', '$2y$10$EcKMHHq4jeFKtekV.6xZ.Ox4YmoOvNdDyKOjZtrnMtf9Q5oEgiGYK', 'Active', '', NULL, NULL, NULL, 'MobileAttendant', '2019-05-28', '28-05-2019 12:33:44pm', '24-06-2019 09:25:48am'),
(17, 1, 'ekua', NULL, 'ekua', '$2y$10$ae5aWmye7XbdPRCiXtuWwOiGwdVQybz78fiKNT1PuoIP/FfUUmANW', 'Active', '', NULL, NULL, NULL, 'KitchenAttendant', '2019-05-28', '28-05-2019 12:34:01pm', '24-06-2019 09:26:07am'),
(18, 1, 'Jessica', NULL, 'Jessica', '$2y$10$P3wYBSvcijciBNt1HWtdBuhuZ09sDPgHKeoNb2niMYRqzCYAc5UKq', 'Active', '', NULL, NULL, NULL, 'Cashier', '2019-05-28', '28-05-2019 12:34:50pm', '28-05-2019 12:34:50pm'),
(19, 1, 'Mauricette Maroga', NULL, 'Mauricette', '$2y$10$S0YRc4vO9dONvSdeS8ike.IJrpF3/DkYfPxRtj1YOO6tcXMSHiNuW', 'Active', '', NULL, NULL, NULL, 'Supervisor', '2019-05-28', '28-05-2019 13:54:06pm', '28-05-2019 13:54:06pm'),
(20, 1, 'Ernest Ansah', NULL, 'Ernest', '$2y$10$ru7BvuR/CzhQYkq/yCRsteworsT040w2QnZLbU898/zn.tEfCDhny', 'Active', '', NULL, NULL, NULL, 'MobileAttendant', '2019-05-28', '28-05-2019 14:13:40pm', '24-06-2019 09:26:26am'),
(21, 1, 'administrator', NULL, 'admin', '$2y$10$ajxhQXE4QSvKe96/P3trHOT64St8W.X4461OLYdQhBpUEJfq4oZ6y', 'Active', '', NULL, NULL, NULL, 'Admin', '2019-05-29', '29-05-2019 10:23:38am', '29-05-2019 10:23:38am'),
(22, 1, 'Perfect', NULL, 'Perfect', '$2y$10$9q6lyWBMOs95p8BLrmMrDuZZQxe82t6kE6CXJOHBB/QPF0YCE/78O', 'Active', '', NULL, NULL, NULL, 'Waiter', '2019-05-30', '30-05-2019 19:33:35pm', '30-05-2019 19:33:35pm'),
(23, 1, 'Bright', NULL, 'Bryte', '$2y$10$hZbEBbbICV5hHNPVTpGPCOps5SVLqg4s3L3xqVeff8VkayVB/D5jy', 'Active', '', NULL, NULL, NULL, 'Waiter', '2019-05-30', '30-05-2019 19:34:08pm', '30-05-2019 19:34:08pm'),
(24, 1, 'Seth', NULL, 'Seth', '$2y$10$2jUCMy.QObtSpzyiIew/X.M0dMXuTIly67K/HyqgD8QuqVZnLpeyS', 'Active', '', NULL, NULL, NULL, 'Waiter', '2019-05-30', '30-05-2019 19:35:10pm', '30-05-2019 19:35:10pm'),
(25, 1, 'George', NULL, 'George', '$2y$10$SEZpTvODG44uvlY/MfC7/.n94r8XcVHo5XyzmDrGaKtvgRvb4Rz6O', 'Active', '', NULL, NULL, NULL, 'Waiter', '2019-05-30', '30-05-2019 19:35:55pm', '30-05-2019 19:35:55pm'),
(26, 1, 'Kobby', NULL, 'Kobby', '$2y$10$aVVU2o1.waxGtipv8UPvNOjDXx5K488aLojyJY5yOUMGhTQU1muDi', 'Active', '', NULL, NULL, NULL, 'Waiter', '2019-05-30', '30-05-2019 19:36:30pm', '30-05-2019 19:36:30pm'),
(27, 1, 'Grace', NULL, 'take away', '$2y$10$WxgrZVGJamVCtkJ1q4ZS6e6GTUpQdEMnU5t8v8gT3TZbWaz75Nf/q', 'Active', '', NULL, NULL, NULL, 'MobileAttendant', '2019-05-30', '30-05-2019 19:37:26pm', '24-06-2019 09:27:22am'),
(28, 1, 'Beatrice', NULL, 'Bea', '$2y$10$pBAq9OwJ2pOniwJhLFuWneGDui7PiACDWAqzSY5195AcTFqHeFleu', 'Active', '', NULL, NULL, NULL, 'Waiter', '2019-05-30', '30-05-2019 19:38:27pm', '30-05-2019 19:38:27pm'),
(29, 1, 'Nicholas', NULL, 'Nicholas', '$2y$10$JVH7H4kVNBcozevVI3Q9y./N7y0SUnuVt1IcM5Vz2DIegzuACDYQq', 'Active', '', NULL, NULL, NULL, 'Waiter', '2019-05-30', '30-05-2019 19:39:11pm', '30-05-2019 19:39:11pm'),
(30, 1, 'Lizzy', NULL, 'Lizzy', '$2y$10$lKgPrQXRB23me09ZNO4mkubbPURBPgYrWyReoeLsab5qU7Y0z3CrS', 'Active', '', NULL, NULL, NULL, 'Waiter', '2019-05-30', '30-05-2019 19:39:49pm', '30-05-2019 19:39:49pm');

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
-- Indexes for table `applications`
--
ALTER TABLE `applications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `shopId` (`shopId`),
  ADD KEY `updated_by` (`updated_by`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `shopId` (`shopId`),
  ADD KEY `kitchenId` (`kitchenId`),
  ADD KEY `updated_by` (`updated_by`),
  ADD KEY `created_by` (`created_by`);

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
-- Indexes for table `kitchens`
--
ALTER TABLE `kitchens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `shopId` (`shopId`),
  ADD KEY `updated_by` (`updated_by`),
  ADD KEY `created_by` (`created_by`);

--
-- Indexes for table `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`id`),
  ADD KEY `shopId` (`shopId`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `updated_by` (`updated_by`),
  ADD KEY `catId` (`catId`);

--
-- Indexes for table `orderdetails`
--
ALTER TABLE `orderdetails`
  ADD PRIMARY KEY (`id`),
  ADD KEY `shopId` (`shopId`),
  ADD KEY `menu_id` (`menu_id`) USING BTREE;

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
-- AUTO_INCREMENT for table `applications`
--
ALTER TABLE `applications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT for table `halls`
--
ALTER TABLE `halls`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `htables`
--
ALTER TABLE `htables`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;
--
-- AUTO_INCREMENT for table `kitchens`
--
ALTER TABLE `kitchens`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `menus`
--
ALTER TABLE `menus`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=171;
--
-- AUTO_INCREMENT for table `orderdetails`
--
ALTER TABLE `orderdetails`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
--
-- AUTO_INCREMENT for table `purchases`
--
ALTER TABLE `purchases`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;
--
-- AUTO_INCREMENT for table `usersessions`
--
ALTER TABLE `usersessions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
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
-- Constraints for table `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `categories_ibfk_1` FOREIGN KEY (`shopId`) REFERENCES `shops` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `categories_ibfk_2` FOREIGN KEY (`kitchenId`) REFERENCES `kitchens` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `categories_ibfk_3` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `categories_ibfk_4` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

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
-- Constraints for table `kitchens`
--
ALTER TABLE `kitchens`
  ADD CONSTRAINT `kitchens_ibfk_1` FOREIGN KEY (`shopId`) REFERENCES `shops` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `kitchens_ibfk_2` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `kitchens_ibfk_3` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `menus`
--
ALTER TABLE `menus`
  ADD CONSTRAINT `menus_ibfk_1` FOREIGN KEY (`shopId`) REFERENCES `shops` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `menus_ibfk_2` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `menus_ibfk_3` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `menus_ibfk_4` FOREIGN KEY (`catId`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `orderdetails`
--
ALTER TABLE `orderdetails`
  ADD CONSTRAINT `orderdetails_ibfk_1` FOREIGN KEY (`shopId`) REFERENCES `shops` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `orderdetails_ibfk_2` FOREIGN KEY (`menu_id`) REFERENCES `menus` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

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
