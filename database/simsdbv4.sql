-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 04, 2025 at 03:13 AM
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
  `date_created` datetime(6) NOT NULL DEFAULT current_timestamp(6)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `brand`
--

INSERT INTO `brand` (`brand_id`, `brand_name`, `status`, `date_created`) VALUES
(1, 'nikee', 'active', '0000-00-00 00:00:00.000000'),
(2, 'pumaaa', 'active', '2024-12-24 22:03:55.647797');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `category_id` int(255) NOT NULL,
  `category_name` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `date_created` datetime(6) NOT NULL DEFAULT current_timestamp(6)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`category_id`, `category_name`, `status`, `date_created`) VALUES
(3, 'airphones', 'active', '2024-12-23 21:32:18.386046'),
(4, 't-shirt', 'active', '2024-12-23 21:32:38.151004'),
(5, 'Bag', 'active', '2024-12-23 21:32:48.309912'),
(6, 'table', 'active', '2024-12-23 21:45:46.988363'),
(7, 'Speaker', 'active', '2024-12-23 21:46:06.247762'),
(8, 'electric fan', 'active', '2024-12-23 21:48:29.918740'),
(9, 'electric fan', 'active', '2024-12-23 21:48:29.998351'),
(13, 'opop', 'active', '2024-12-28 15:36:28.432639');

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
  `date_created` datetime(6) NOT NULL DEFAULT current_timestamp(6)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `product_name`, `barcode`, `brand_id`, `category_id`, `subcategory_id`, `original_price`, `selling_price`, `quantity`, `reorder_point`, `status`, `supplier_id`, `date_created`) VALUES
(1, 'ooooooooooo', 'klkl', 0, 0, 0, 123, 123, 123, 12, 'active', 0, '2024-12-27 21:30:45.242892'),
(3, 'bnm', '56756', 1, 5, 6, 567, 567, 56765, 6657, 'active', 4, '2024-12-28 19:16:19.794970'),
(4, 'gdfg', '546', 1, 3, 3, 546, 456, 546, 546, 'active', 1, '2024-12-28 19:16:36.056754'),
(5, 'dada', '123', 1, 3, 1, 567, 65756, 123, 567567, 'active', 1, '2024-12-29 21:51:25.921417'),
(6, 'dada', '123', 1, 3, 1, 567, 65756, 123, 567567, 'active', 1, '2024-12-29 21:51:30.785917'),
(7, 'dada', '123', 2, 4, 6, 345345, 34534, 43534, 435345, 'active', 1, '2024-12-29 21:55:26.782692'),
(8, 'ioio', '56757', 2, 4, 6, 56756, 75675, 65756, 567567, 'active', 1, '2024-12-29 21:58:06.094188'),
(9, 'ppppppppppp', '657', 2, 5, 6, 56756, 7567, 567, 567, 'active', 1, '2024-12-29 21:58:31.994962');

-- --------------------------------------------------------

--
-- Table structure for table `subcategory`
--

CREATE TABLE `subcategory` (
  `subcategory_id` int(255) NOT NULL,
  `subcategory_name` varchar(255) NOT NULL,
  `category_id` int(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `date_created` datetime(6) NOT NULL DEFAULT current_timestamp(6)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subcategory`
--

INSERT INTO `subcategory` (`subcategory_id`, `subcategory_name`, `category_id`, `status`, `date_created`) VALUES
(1, 'dass', 3, 'inactive', '2024-12-24 13:52:36.908955'),
(2, 'das', 2, 'active', '2024-12-24 13:52:55.130138'),
(3, 'hahaha', 3, 'active', '2024-12-24 14:14:02.537664'),
(6, 'shoulder bag', 4, 'active', '2024-12-24 20:40:31.955839'),
(8, 'dada', 11, 'active', '2024-12-24 21:36:00.898561'),
(9, 'true', 3, 'active', '2024-12-27 10:11:02.482473');

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
  `date_added` datetime(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`supplier_id`, `supplier_name`, `contact_person`, `contact_number`, `address`, `supplier_type`, `product_category_id`, `payment_terms`, `note`, `date_added`) VALUES
(1, 'truy', 'try', 2147483647, 'purok 20 fatima', 'Product Supplier', 2, '1', 'hahahha', '0000-00-00 00:00:00.000000'),
(2, 'rtrt', 'yuyu', 234234234, 'purok 20 fatima', 'Rental Box Supplier', 4, '2', 'adasdsad', '0000-00-00 00:00:00.000000'),
(4, 'jkjk', 'jkjk', 879789, 'kj;ljkl', 'Service Provider', 9, '2', 'oppopop', '0000-00-00 00:00:00.000000');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `role`, `date_created`) VALUES
(5, 'admin', 'admin', 'admin', '2025-01-03 11:35:45');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `brand`
--
ALTER TABLE `brand`
  ADD PRIMARY KEY (`brand_id`);

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
  MODIFY `brand_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

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
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `subcategory`
--
ALTER TABLE `subcategory`
  MODIFY `subcategory_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `supplier`
--
ALTER TABLE `supplier`
  MODIFY `supplier_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
