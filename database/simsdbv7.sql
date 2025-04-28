-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 28, 2025 at 09:07 AM
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
-- Database: `simsdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `brand`
--

CREATE TABLE `brand` (
  `brand_id` int(255) NOT NULL,
  `brand_name` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `deleted` varchar(6) NOT NULL,
  `date_created` datetime(6) NOT NULL DEFAULT current_timestamp(6)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `brand`
--

INSERT INTO `brand` (`brand_id`, `brand_name`, `status`, `deleted`, `date_created`) VALUES
(1, 'nikee', 'active', 'no', '0000-00-00 00:00:00.000000'),
(2, 'pumaaa', 'active', 'no', '2024-12-24 22:03:55.647797'),
(10, 'rrj', 'active', 'no', '2025-04-28 14:50:40.631632');

-- --------------------------------------------------------

--
-- Table structure for table `business_details`
--

CREATE TABLE `business_details` (
  `id` int(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `logo` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `contact_number` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `daily_rate` varchar(255) NOT NULL,
  `weekly_rate` varchar(255) NOT NULL,
  `monthly-rate` varchar(255) NOT NULL,
  `low_strock_alert` varchar(255) NOT NULL,
  `overdue_rental_alert` varchar(255) NOT NULL,
  `date_create` datetime(6) NOT NULL DEFAULT current_timestamp(6)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `business_details`
--

INSERT INTO `business_details` (`id`, `name`, `logo`, `address`, `contact_number`, `email`, `daily_rate`, `weekly_rate`, `monthly-rate`, `low_strock_alert`, `overdue_rental_alert`, `date_create`) VALUES
(1, 'floyderingingsdfds', '../../assets/images/uploads/680f020a85e08_logo.png', 'fatima', '09757579376', 'benjarbulacon09@gamil.com', '12', '12', '12', '1', '1', '2025-04-28 11:39:37.878529');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `category_id` int(255) NOT NULL,
  `category_name` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `deleted` varchar(6) NOT NULL,
  `date_created` datetime(6) NOT NULL DEFAULT current_timestamp(6)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`category_id`, `category_name`, `status`, `deleted`, `date_created`) VALUES
(3, 'airphones', 'active', 'no', '2024-12-23 21:32:18.386046'),
(4, 't-shirt', 'active', 'yes', '2024-12-23 21:32:38.151004'),
(5, 'Bag', 'active', 'no', '2024-12-23 21:32:48.309912'),
(6, 'table', 'active', 'no', '2024-12-23 21:45:46.988363'),
(7, 'Speaker', 'active', 'no', '2024-12-23 21:46:06.247762'),
(8, 'electric fan', 'active', 'no', '2024-12-23 21:48:29.918740'),
(9, 'electric fan', 'active', 'no', '2024-12-23 21:48:29.998351'),
(13, 'opop', 'active', 'no', '2024-12-28 15:36:28.432639');

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `payment_id` int(255) NOT NULL,
  `payment_type` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `date_created` datetime(6) NOT NULL DEFAULT current_timestamp(6)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`payment_id`, `payment_type`, `status`, `date_created`) VALUES
(1, 'Cash', 'available', '0000-00-00 00:00:00.000000'),
(2, 'Gcash', 'available', '0000-00-00 00:00:00.000000');

-- --------------------------------------------------------

--
-- Table structure for table `product-sales`
--

CREATE TABLE `product-sales` (
  `transact_ID` int(255) NOT NULL,
  `product_id` int(255) NOT NULL,
  `quantity_sold` int(255) NOT NULL,
  `total_sale` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(255) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `barcode` varchar(255) NOT NULL,
  `brand_id` int(255) NOT NULL,
  `category_id` int(255) NOT NULL,
  `subcategory_id` int(255) NOT NULL,
  `original_price` int(255) NOT NULL,
  `selling_price` int(255) NOT NULL,
  `quantity` int(255) NOT NULL,
  `reorder_point` int(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `supplier_id` int(255) NOT NULL,
  `date_created` datetime(6) NOT NULL DEFAULT current_timestamp(6),
  `deleted` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `product_name`, `barcode`, `brand_id`, `category_id`, `subcategory_id`, `original_price`, `selling_price`, `quantity`, `reorder_point`, `status`, `supplier_id`, `date_created`, `deleted`) VALUES
(4, 'ahhhhhhhhhhhhhhhhhhh', '546', 1, 6, 6, 546, 456, 5459, 546, 'active', 5, '2024-12-28 19:16:36.056754', 'yes'),
(5, 'dada', '123', 1, 3, 1, 567, 65756, 122, 567567, 'active', 1, '2024-12-29 21:51:25.921417', 'no'),
(6, 'dada', '123', 0, 0, 0, 567, 65756, 122, 567567, 'active', 0, '2024-12-29 21:51:30.785917', 'no'),
(7, 'dada', '123', 2, 4, 6, 345345, 34534, 43533, 435345, 'active', 1, '2024-12-29 21:55:26.782692', 'no'),
(8, 'ioio', '56757', 2, 4, 6, 56756, 75675, 71412, 567567, 'active', 1, '2024-12-29 21:58:06.094188', 'no'),
(9, 'ppppppppppp', '657', 2, 5, 6, 56756, 7567, 566, 567, 'active', 1, '2024-12-29 21:58:31.994962', 'no'),
(10, 'speaker123', '345', 1, 7, 9, 900, 1000, 1234, 10, 'active', 1, '2025-03-15 10:15:18.093950', 'no'),
(12, 'product112', '1111111111', 2, 5, 9, 1000, 2000, 10, 10, 'active', 2, '2025-04-16 11:15:03.876368', 'no'),
(13, 'product2', '2222222222222', 1, 4, 3, 1000, 2000, 2, 10, 'active', 2, '2025-04-16 11:16:04.243106', 'no'),
(14, 'product2', '2222222222222', 1, 4, 3, 1000, 2000, 2, 10, 'active', 2, '2025-04-16 11:16:04.254941', 'no'),
(15, 'product3', '3333333333333', 1, 3, 3, 1000, 2000, 10, 20, 'active', 2, '2025-04-16 11:17:16.275062', 'no'),
(16, 'product4', '444444444444', 2, 5, 9, 1000, 2000, 3, 10, 'active', 2, '2025-04-16 11:17:45.469092', 'no'),
(17, 'product5', '5555555555', 1, 4, 6, 1000, 2000, 11, 10, 'active', 1, '2025-04-16 13:19:04.663954', 'no'),
(18, 'product7', '777777777777', 2, 4, 6, 1000, 2000, 10, 10, 'active', 4, '0000-00-00 00:00:00.000000', 'no'),
(19, 'product8', '7777777777777', 1, 4, 6, 1, 1, 9, 10, 'active', 5, '0000-00-00 00:00:00.000000', 'no'),
(20, '[value-2]', '[value-3]', 0, 0, 0, 0, 0, 0, 0, '[value-11]', 0, '0000-00-00 00:00:00.000000', 'no'),
(21, 'new', '89898989', 2, 3, 1, 1000, 2000, 100, 10, 'active', 5, '2025-04-24 08:41:14.533819', 'no'),
(22, 'new', '89898989', 2, 3, 1, 1000, 2000, 100, 10, 'active', 5, '2025-04-24 08:41:14.533793', 'no'),
(23, 'new', '89898989', 2, 3, 1, 1000, 2000, 100, 10, 'active', 5, '2025-04-24 08:41:14.533798', 'no'),
(24, 'new3', '324324290909', 1, 3, 6, 1000, 2000, 100, 10, 'active', 5, '2025-04-24 08:43:59.835259', 'no'),
(25, 'floyd', '0101010101', 1, 3, 3, 213213, 122, 12321320, 12, 'active', 5, '2025-04-24 09:20:21.922191', 'no'),
(26, 'floyd2', '0101010101', 2, 4, 6, 213213, 122, 12321320, 12, 'active', 5, '2025-04-24 09:20:21.922192', 'no'),
(28, 'ginooo', '45454545', 2, 6, 3, 1000, 1222, 10, 10, 'active', 5, '2025-04-24 09:30:36.332288', 'no'),
(29, 'aliboy', '676767676', 2, 4, 1, 455, 677, 100, 12, 'active', 5, '2025-04-24 11:16:52.445002', 'no'),
(30, 'try product for pos', '123456789999', 1, 4, 1, 50, 100, 70, 5, 'active', 5, '2025-04-24 16:52:45.231059', 'yes'),
(31, 'barcode hehehe', '4045573957063', 1, 6, 3, 1000, 2000, 100, 10, 'active', 1, '2025-04-24 18:38:21.478636', 'no'),
(32, 'ait', '4488293810243', 1, 5, 1, 1000, 2000, 0, 12, 'active', 5, '2025-04-24 18:41:16.011160', 'no'),
(33, 'product1', '5431117258579', 1, 4, 3, 1000, 2000, 100, 10, 'active', 2, '2025-04-24 18:44:48.908509', 'no'),
(34, 'records', '3646258005491', 2, 3, 1, 50, 100, 10, 10, 'active', 2, '2025-04-24 18:53:03.165376', 'no'),
(35, 'creamsilk', '4806515161511', 1, 3, 1, 1000, 2000, -11, 12, 'active', 1, '2025-04-24 19:08:39.234479', 'no'),
(36, 'DOWNY', '4803746370248', 1, 5, 1, 1000, 2000, -20, 10, 'active', 5, '2025-04-24 19:48:31.116865', 'no');

-- --------------------------------------------------------

--
-- Table structure for table `purchase-order`
--

CREATE TABLE `purchase-order` (
  `order_id` int(255) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `barcode` varchar(255) NOT NULL,
  `brand_id` int(255) NOT NULL,
  `category_id` int(255) NOT NULL,
  `subcategory_id` int(255) NOT NULL,
  `original_price` int(255) NOT NULL,
  `selling_price` int(255) NOT NULL,
  `quantity` int(255) NOT NULL,
  `reorder_point` int(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `date_ordered` datetime(6) NOT NULL DEFAULT current_timestamp(6),
  `deleted` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `purchase-order`
--

INSERT INTO `purchase-order` (`order_id`, `product_name`, `barcode`, `brand_id`, `category_id`, `subcategory_id`, `original_price`, `selling_price`, `quantity`, `reorder_point`, `status`, `supplier_id`, `date_ordered`, `deleted`) VALUES
(1, 'almond vanilla', '8065334553641', 2, 3, 3, 99, 150, 500, 10, 'completed', 5, '2025-04-27 10:54:49.159866', 'yes'),
(2, 'almond vanilla 2', '9339465377944', 2, 3, 3, 120, 190, 500, 10, 'completed', 5, '2025-04-27 10:56:42.560884', 'no'),
(3, 'almond vanilla 3', '4906390796032', 1, 6, 1, 49, 99, 100, 5, 'completed', 1, '2025-04-27 12:16:34.576362', 'no'),
(4, 'order1', '1449733322028', 1, 3, 3, 120, 190, 500, 10, 'completed', 5, '2025-04-28 13:54:11.812238', 'no');

-- --------------------------------------------------------

--
-- Table structure for table `rental-box`
--

CREATE TABLE `rental-box` (
  `box_id` int(255) NOT NULL,
  `box_number` int(255) NOT NULL,
  `box_size` varchar(20) NOT NULL,
  `width` int(11) NOT NULL,
  `length` int(11) NOT NULL,
  `rental_fee` int(255) NOT NULL,
  `quantity` int(255) NOT NULL,
  `status` varchar(20) NOT NULL,
  `date_created` datetime(6) NOT NULL DEFAULT current_timestamp(6)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rental-transaction`
--

CREATE TABLE `rental-transaction` (
  `id` int(255) NOT NULL,
  `renter_id` int(50) NOT NULL,
  `rented_quantity` int(255) NOT NULL,
  `payment` int(255) NOT NULL,
  `rental_start_date` date NOT NULL,
  `rental_end_date` date NOT NULL,
  `status` varchar(20) NOT NULL,
  `date_created` datetime(6) NOT NULL DEFAULT current_timestamp(6)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rental-transaction`
--

INSERT INTO `rental-transaction` (`id`, `renter_id`, `rented_quantity`, `payment`, `rental_start_date`, `rental_end_date`, `status`, `date_created`) VALUES
(11, 11, 5, 500, '2025-04-26', '2025-05-26', 'completed', '2025-04-26 16:24:26.212509'),
(12, 12, 3, 1500, '2025-04-26', '2025-06-26', 'active', '2025-04-26 16:28:12.432166'),
(13, 13, 1, 500, '2025-04-26', '2025-05-26', 'completed', '2025-04-26 16:29:53.320241'),
(14, 14, 5, 900, '2025-04-26', '2025-05-26', 'completed', '2025-04-26 16:39:33.853906'),
(15, 15, 1, 100, '2025-04-25', '2025-04-25', 'active', '2025-04-26 16:48:47.068264'),
(16, 16, 3, 300, '2025-04-26', '2025-05-26', 'active', '2025-04-26 16:57:12.073723'),
(17, 17, 2, 200, '2025-04-25', '2025-04-28', 'completed', '2025-04-26 16:58:19.149881'),
(18, 18, 2, 200, '2025-04-26', '2025-04-28', 'active', '2025-04-26 17:00:49.816996'),
(19, 19, 3, 700, '2025-04-26', '2025-04-30', 'active', '2025-04-26 17:01:46.919387'),
(20, 20, 1, 100, '2025-04-26', '2025-04-29', 'active', '2025-04-26 17:03:48.905056'),
(21, 21, 1, 100, '2025-04-25', '2025-04-30', 'active', '2025-04-26 17:06:55.082805'),
(22, 22, 11, 1100, '2025-04-11', '2025-04-22', 'active', '2025-04-26 17:15:20.247742'),
(23, 23, 6, 600, '2025-04-24', '2025-04-28', 'active', '2025-04-26 17:18:22.229198'),
(24, 24, 5, 500, '2025-04-23', '2025-04-29', 'active', '2025-04-26 17:20:24.814920'),
(25, 25, 1, 100, '2025-04-05', '2025-04-25', 'active', '2025-04-26 17:20:57.466828');

-- --------------------------------------------------------

--
-- Table structure for table `rentalbox`
--

CREATE TABLE `rentalbox` (
  `box_id` int(255) NOT NULL,
  `box_number` int(255) NOT NULL,
  `box_size` varchar(20) NOT NULL,
  `width` int(255) NOT NULL,
  `length` int(255) NOT NULL,
  `rental_fee` int(255) NOT NULL,
  `quantity` int(255) NOT NULL,
  `status` varchar(20) NOT NULL,
  `deleted` varchar(6) NOT NULL,
  `date_create` datetime(6) NOT NULL DEFAULT current_timestamp(6)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rentalbox`
--

INSERT INTO `rentalbox` (`box_id`, `box_number`, `box_size`, `width`, `length`, `rental_fee`, `quantity`, `status`, `deleted`, `date_create`) VALUES
(1, 1, 'Small', 10, 10, 100, 10, 'active', 'no', '2025-04-25 21:19:45.394081'),
(2, 2, 'Large', 10, 10, 100, 10, 'active', 'no', '2025-04-25 21:22:59.347172'),
(3, 3, 'Medium', 11, 11, 100, 10, 'active', 'no', '2025-04-25 21:26:35.763146'),
(5, 4, 'Large', 10, 10, 100, 10, 'active', 'no', '2025-04-26 01:31:10.969607'),
(6, 5, 'Medium', 10, 10, 100, 10, 'active', 'no', '2025-04-26 01:31:30.102287'),
(7, 6, 'Medium', 11, 11, 100, 10, 'active', 'no', '2025-04-26 01:31:53.700323'),
(8, 7, 'Large', 10, 11, 100, 10, 'active', 'no', '2025-04-26 01:32:07.860242'),
(9, 8, 'Medium', 10, 10, 100, 10, 'active', 'no', '2025-04-26 01:32:22.044823'),
(10, 9, 'Large', 10, 10, 100, 10, 'active', 'no', '2025-04-26 01:32:45.362242'),
(11, 10, 'Medium', 10, 11, 100, 10, 'active', 'no', '2025-04-26 01:33:05.530113'),
(12, 11, 'Small', 23, 11, 100, 10, 'active', 'no', '2025-04-26 01:33:18.458649'),
(13, 12, 'Medium', 11, 11, 100, 10, 'active', 'no', '2025-04-26 01:33:34.905173'),
(14, 13, 'Small', 23, 30, 100, 10, 'active', 'no', '2025-04-26 01:33:50.666255'),
(15, 14, 'Large', 10, 11, 100, 10, 'active', 'no', '2025-04-26 01:34:08.943475'),
(16, 14, 'Large', 11, 11, 100, 10, 'active', 'no', '2025-04-26 01:45:26.367022'),
(17, 9090, 'Large', 30, 30, 500, 100, 'active', 'yes', '2025-04-26 16:27:25.364682');

-- --------------------------------------------------------

--
-- Table structure for table `rented-box-transaction`
--

CREATE TABLE `rented-box-transaction` (
  `id` int(255) NOT NULL,
  `renter_id` int(255) NOT NULL,
  `rental_transaction_id` int(255) NOT NULL,
  `box_id` int(255) NOT NULL,
  `quantity` int(255) NOT NULL,
  `date_created` datetime(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rented-box-transaction`
--

INSERT INTO `rented-box-transaction` (`id`, `renter_id`, `rental_transaction_id`, `box_id`, `quantity`, `date_created`) VALUES
(1, 11, 11, 5, 2, '2025-04-26 16:24:26.000000'),
(2, 11, 11, 3, 1, '2025-04-26 16:24:26.000000'),
(3, 11, 11, 2, 1, '2025-04-26 16:24:26.000000'),
(4, 11, 11, 1, 1, '2025-04-26 16:24:26.000000'),
(5, 12, 12, 17, 3, '2025-04-26 16:28:12.000000'),
(6, 13, 13, 17, 1, '2025-04-26 16:29:53.000000'),
(7, 14, 14, 17, 1, '2025-04-26 16:39:33.000000'),
(8, 14, 14, 16, 2, '2025-04-26 16:39:33.000000'),
(9, 14, 14, 14, 1, '2025-04-26 16:39:33.000000'),
(10, 14, 14, 13, 1, '2025-04-26 16:39:33.000000'),
(11, 15, 15, 1, 1, '2025-04-26 16:48:47.000000'),
(12, 16, 16, 7, 1, '2025-04-26 16:57:12.000000'),
(13, 16, 16, 8, 1, '2025-04-26 16:57:12.000000'),
(14, 16, 16, 9, 1, '2025-04-26 16:57:12.000000'),
(15, 17, 17, 1, 1, '2025-04-26 16:58:19.000000'),
(16, 17, 17, 2, 1, '2025-04-26 16:58:19.000000'),
(17, 18, 18, 1, 1, '2025-04-26 17:00:49.000000'),
(18, 18, 18, 2, 1, '2025-04-26 17:00:49.000000'),
(19, 19, 19, 17, 1, '2025-04-26 17:01:46.000000'),
(20, 19, 19, 16, 2, '2025-04-26 17:01:46.000000'),
(21, 20, 20, 1, 1, '2025-04-26 17:03:48.000000'),
(22, 21, 21, 11, 1, '2025-04-26 17:06:55.000000'),
(23, 22, 22, 10, 1, '2025-04-26 17:15:20.000000'),
(24, 22, 22, 9, 1, '2025-04-26 17:15:20.000000'),
(25, 22, 22, 8, 1, '2025-04-26 17:15:20.000000'),
(26, 22, 22, 7, 1, '2025-04-26 17:15:20.000000'),
(27, 22, 22, 6, 1, '2025-04-26 17:15:20.000000'),
(28, 22, 22, 5, 1, '2025-04-26 17:15:20.000000'),
(29, 22, 22, 2, 5, '2025-04-26 17:15:20.000000'),
(30, 23, 23, 2, 6, '2025-04-26 17:18:22.000000'),
(31, 24, 24, 3, 5, '2025-04-26 17:20:24.000000'),
(32, 25, 25, 3, 1, '2025-04-26 17:20:57.000000');

-- --------------------------------------------------------

--
-- Table structure for table `renter`
--

CREATE TABLE `renter` (
  `renter_id` int(11) NOT NULL,
  `renter_name` varchar(50) NOT NULL,
  `contact_number` varchar(20) NOT NULL,
  `date_create` datetime(6) NOT NULL DEFAULT current_timestamp(6)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `renter`
--

INSERT INTO `renter` (`renter_id`, `renter_name`, `contact_number`, `date_create`) VALUES
(11, 'floyder', '9757579376', '2025-04-26 16:24:26.195351'),
(12, 'gino', '2147483647', '2025-04-26 16:28:12.417523'),
(13, 'aliboy', '2147483647', '2025-04-26 16:29:53.300706'),
(14, 'jana', '2147483647', '2025-04-26 16:39:33.834926'),
(15, 'aliboy', '2147483647', '2025-04-26 16:48:47.047249'),
(16, 'floyd', '2147483647', '2025-04-26 16:57:12.055353'),
(17, 'gino', '2147483647', '2025-04-26 16:58:19.131601'),
(18, 'jana', '2147483647', '2025-04-26 17:00:49.797598'),
(19, 'jana', '2147483647', '2025-04-26 17:01:46.907823'),
(20, 'gino', '2147483647', '2025-04-26 17:03:48.895130'),
(21, 'gino', '2147483647', '2025-04-26 17:06:55.071174'),
(22, 'wahahahha', '2147483647', '2025-04-26 17:15:20.220510'),
(23, 'heheehe', '2147483647', '2025-04-26 17:18:22.225671'),
(24, 'trtrtrtrtr', '2147483647', '2025-04-26 17:20:24.812314'),
(25, 'heheehe', '2147483647', '2025-04-26 17:20:57.458774');

-- --------------------------------------------------------

--
-- Table structure for table `sales-transaction`
--

CREATE TABLE `sales-transaction` (
  `transact_ID` int(255) NOT NULL,
  `total_items` int(255) NOT NULL,
  `total_payment` int(255) NOT NULL,
  `cash` int(255) NOT NULL,
  `change` int(255) NOT NULL,
  `payment_method` varchar(20) NOT NULL,
  `customer_name` varchar(100) NOT NULL,
  `contact_number` int(11) NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sales-transaction`
--

INSERT INTO `sales-transaction` (`transact_ID`, `total_items`, `total_payment`, `cash`, `change`, `payment_method`, `customer_name`, `contact_number`, `date`) VALUES
(1, 1, 122, 500, 378, 'Cash', 'Guest', 0, '2025-04-24'),
(2, 3, 300, 500, 200, 'Cash', 'Guest', 0, '2025-04-24'),
(3, 3, 300, 1000, 700, 'Cash', 'Guest', 0, '2025-04-24'),
(4, 3, 300, 1000, 700, 'Cash', 'Guest', 0, '2025-04-24'),
(5, 3, 300, 1000, 700, 'Cash', 'Guest', 0, '2025-04-24'),
(6, 1, 100, 100, 0, 'Cash', 'Guest', 0, '2025-04-24'),
(7, 1, 100, 500, 400, 'Cash', 'Guest', 0, '2025-04-24'),
(8, 1, 100, 1000, 900, 'Cash', 'Guest', 0, '2025-04-24'),
(9, 1, 100, 1000, 900, 'Cash', 'Guest', 0, '2025-04-24'),
(10, 1, 100, 100, 0, 'Cash', 'Guest', 0, '2025-04-24'),
(16, 1, 100, 100, 0, 'Cash', 'Guest', 0, '2025-04-24'),
(17, 1, 100, 1000, 900, 'Cash', 'Guest', 0, '2025-04-24'),
(18, 1, 100, 100, 0, 'Cash', 'Guest', 0, '2025-04-24'),
(19, 10, 1000, 1000, 0, 'Cash', 'Guest', 0, '2025-04-24'),
(20, 1, 100, 1000, 900, 'Cash', 'benjar', 2147483647, '2025-04-24'),
(21, 1, 100, 1000, 900, 'Cash', 'floyd', 2147483647, '2025-04-24'),
(22, 1, 100, 1000, 900, 'Cash', 'gino', 8, '2025-04-24'),
(23, 1, 100, 1000, 900, 'Cash', 'aliboy', 0, '2025-04-24'),
(24, 1, 100, 1000, 900, 'Cash', 'jana', 6767, '2025-04-24'),
(25, 5, 500, 1000, 500, 'Cash', 'arann', 2147483647, '2025-04-24'),
(26, 1, 7567, 10000, 2433, 'Cash', 'Guest', 0, '2025-04-24'),
(27, 4, 6001, 10000, 3999, 'Cash', 'Guest', 0, '2025-04-24'),
(28, 35, 70000, 70000, 0, 'Cash', 'ABERIN', 899999, '2025-04-24'),
(29, 4, 8000, 8000, 0, 'Cash', 'ABORONG', 2147483647, '2025-04-24'),
(30, 5, 10000, 11111, 1111, 'Cash', 'Guest', 0, '2025-04-24'),
(31, 1, 456, 1000, 544, 'Cash', 'reno', 2147483647, '2025-04-25'),
(32, 3, 6000, 6000, 0, 'Cash', 'electricfan', 2147483647, '2025-04-27'),
(33, 3, 6000, 10000, 4000, 'Cash', 'floydss', 2147483647, '2025-04-27'),
(34, 10, 20000, 20000, 0, 'Cash', 'abiri', 2147483647, '2025-04-27'),
(35, 1, 65756, 80000, 14244, 'Cash', 'gtri', 89898989, '2025-04-28'),
(36, 1, 2000, 70000, 68000, 'Cash', 'nagpalit si gino', 898989, '2025-04-28');

-- --------------------------------------------------------

--
-- Table structure for table `subcategory`
--

CREATE TABLE `subcategory` (
  `subcategory_id` int(255) NOT NULL,
  `subcategory_name` varchar(255) NOT NULL,
  `category_id` int(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `deleted` varchar(6) NOT NULL,
  `date_created` datetime(6) NOT NULL DEFAULT current_timestamp(6)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subcategory`
--

INSERT INTO `subcategory` (`subcategory_id`, `subcategory_name`, `category_id`, `status`, `deleted`, `date_created`) VALUES
(1, 'dass', 3, 'inactive', 'no', '2024-12-24 13:52:36.908955'),
(2, 'das', 2, 'active', 'no', '2024-12-24 13:52:55.130138'),
(3, 'hahaha', 3, 'active', 'yes', '2024-12-24 14:14:02.537664'),
(6, 'shoulder bag', 4, 'active', 'yes', '2024-12-24 20:40:31.955839'),
(8, 'dada', 11, 'active', 'no', '2024-12-24 21:36:00.898561'),
(9, 'true', 3, 'active', 'yes', '2024-12-27 10:11:02.482473');

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE `supplier` (
  `supplier_id` int(255) NOT NULL,
  `supplier_name` varchar(255) NOT NULL,
  `contact_person` varchar(255) NOT NULL,
  `contact_number` int(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `supplier_type` varchar(255) NOT NULL,
  `product_category_id` int(255) NOT NULL,
  `payment_terms` varchar(255) NOT NULL,
  `note` varchar(255) NOT NULL,
  `deleted` varchar(6) NOT NULL,
  `date_added` datetime(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`supplier_id`, `supplier_name`, `contact_person`, `contact_number`, `address`, `supplier_type`, `product_category_id`, `payment_terms`, `note`, `deleted`, `date_added`) VALUES
(1, 'truy', 'try', 2147483647, 'purok 20 fatima', 'Product Supplier', 2, '1', 'hahahha', 'no', '0000-00-00 00:00:00.000000'),
(2, 'rtrt', 'yuyu', 234234234, 'purok 20 fatima', 'Rental Box Supplier', 4, '2', 'adasdsad', 'no', '0000-00-00 00:00:00.000000'),
(5, 'supplier 1', 'spplier 1 contact erson', 2147483647, 'supplier 1 address', 'Product Supplier', 4, '1', 'example note, example note,example note,example note,example note,example note,example note,example note,example note,example note,example note,example note,example note,', 'yes', '0000-00-00 00:00:00.000000');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(255) NOT NULL,
  `name` varchar(100) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL,
  `profile_pic` varchar(255) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`, `username`, `password`, `role`, `profile_pic`, `date_created`) VALUES
(11, 'floyd taasan malindatorr', 'floyd', 'floyd', 'admin', '../../assets/images/uploads/680f023555592_profile.png', '2025-04-28 02:13:26'),
(16, 'ginooo', 'gino', 'gino', 'cashier', 'default.png', '2025-04-28 04:27:27'),
(17, 'loyd', 'loyd', 'loyd', 'admin', 'default.png', '2025-04-28 04:39:24');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `brand`
--
ALTER TABLE `brand`
  ADD PRIMARY KEY (`brand_id`);

--
-- Indexes for table `business_details`
--
ALTER TABLE `business_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`payment_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchase-order`
--
ALTER TABLE `purchase-order`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `rental-box`
--
ALTER TABLE `rental-box`
  ADD PRIMARY KEY (`box_id`);

--
-- Indexes for table `rental-transaction`
--
ALTER TABLE `rental-transaction`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rentalbox`
--
ALTER TABLE `rentalbox`
  ADD PRIMARY KEY (`box_id`);

--
-- Indexes for table `rented-box-transaction`
--
ALTER TABLE `rented-box-transaction`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `renter`
--
ALTER TABLE `renter`
  ADD PRIMARY KEY (`renter_id`);

--
-- Indexes for table `sales-transaction`
--
ALTER TABLE `sales-transaction`
  ADD PRIMARY KEY (`transact_ID`);

--
-- Indexes for table `subcategory`
--
ALTER TABLE `subcategory`
  ADD PRIMARY KEY (`subcategory_id`);

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`supplier_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `brand`
--
ALTER TABLE `brand`
  MODIFY `brand_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `business_details`
--
ALTER TABLE `business_details`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `category_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `payment_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `purchase-order`
--
ALTER TABLE `purchase-order`
  MODIFY `order_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `rental-box`
--
ALTER TABLE `rental-box`
  MODIFY `box_id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rental-transaction`
--
ALTER TABLE `rental-transaction`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `rentalbox`
--
ALTER TABLE `rentalbox`
  MODIFY `box_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `rented-box-transaction`
--
ALTER TABLE `rented-box-transaction`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `renter`
--
ALTER TABLE `renter`
  MODIFY `renter_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `sales-transaction`
--
ALTER TABLE `sales-transaction`
  MODIFY `transact_ID` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `subcategory`
--
ALTER TABLE `subcategory`
  MODIFY `subcategory_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `supplier`
--
ALTER TABLE `supplier`
  MODIFY `supplier_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
