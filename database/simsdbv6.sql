-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 26, 2025 at 07:27 AM
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
(4, 'ahhhhhhhhhhhhhhhhhhh', '546', 1, 6, 6, 546, 456, 5459, 546, 'active', 5, '2024-12-28 19:16:36.056754'),
(5, 'dada', '123', 1, 3, 1, 567, 65756, 123, 567567, 'active', 1, '2024-12-29 21:51:25.921417'),
(6, 'dada', '123', 0, 0, 0, 567, 65756, 123, 567567, 'active', 0, '2024-12-29 21:51:30.785917'),
(7, 'dada', '123', 2, 4, 6, 345345, 34534, 43534, 435345, 'active', 1, '2024-12-29 21:55:26.782692'),
(8, 'ioio', '56757', 2, 4, 6, 56756, 75675, 71412, 567567, 'active', 1, '2024-12-29 21:58:06.094188'),
(9, 'ppppppppppp', '657', 2, 5, 6, 56756, 7567, 566, 567, 'active', 1, '2024-12-29 21:58:31.994962'),
(10, 'speaker123', '345', 1, 7, 9, 900, 1000, 1234, 10, 'active', 1, '2025-03-15 10:15:18.093950'),
(12, 'product112', '1111111111', 2, 5, 9, 1000, 2000, 10, 10, 'active', 2, '2025-04-16 11:15:03.876368'),
(13, 'product2', '2222222222222', 1, 4, 3, 1000, 2000, 2, 10, 'active', 2, '2025-04-16 11:16:04.243106'),
(14, 'product2', '2222222222222', 1, 4, 3, 1000, 2000, 2, 10, 'active', 2, '2025-04-16 11:16:04.254941'),
(15, 'product3', '3333333333333', 1, 3, 3, 1000, 2000, 10, 20, 'active', 2, '2025-04-16 11:17:16.275062'),
(16, 'product4', '444444444444', 2, 5, 9, 1000, 2000, 3, 10, 'active', 2, '2025-04-16 11:17:45.469092'),
(17, 'product5', '5555555555', 1, 4, 6, 1000, 2000, 11, 10, 'active', 1, '2025-04-16 13:19:04.663954'),
(18, 'product7', '777777777777', 2, 4, 6, 1000, 2000, 10, 10, 'active', 4, '0000-00-00 00:00:00.000000'),
(19, 'product8', '7777777777777', 1, 4, 6, 1, 1, 9, 10, 'active', 5, '0000-00-00 00:00:00.000000'),
(20, '[value-2]', '[value-3]', 0, 0, 0, 0, 0, 0, 0, '[value-11]', 0, '0000-00-00 00:00:00.000000'),
(21, 'new', '89898989', 2, 3, 1, 1000, 2000, 100, 10, 'active', 5, '2025-04-24 08:41:14.533819'),
(22, 'new', '89898989', 2, 3, 1, 1000, 2000, 100, 10, 'active', 5, '2025-04-24 08:41:14.533793'),
(23, 'new', '89898989', 2, 3, 1, 1000, 2000, 100, 10, 'active', 5, '2025-04-24 08:41:14.533798'),
(24, 'new3', '324324290909', 1, 3, 6, 1000, 2000, 100, 10, 'active', 5, '2025-04-24 08:43:59.835259'),
(25, 'floyd', '0101010101', 1, 3, 3, 213213, 122, 12321320, 12, 'active', 5, '2025-04-24 09:20:21.922191'),
(26, 'floyd2', '0101010101', 2, 4, 6, 213213, 122, 12321320, 12, 'active', 5, '2025-04-24 09:20:21.922192'),
(28, 'ginooo', '45454545', 2, 6, 3, 1000, 1222, 10, 10, 'active', 5, '2025-04-24 09:30:36.332288'),
(29, 'aliboy', '676767676', 2, 4, 1, 455, 677, 100, 12, 'active', 5, '2025-04-24 11:16:52.445002'),
(30, 'try product for pos', '123456789999', 1, 4, 1, 50, 100, 70, 5, 'active', 5, '2025-04-24 16:52:45.231059'),
(31, 'barcode hehehe', '4045573957063', 1, 6, 3, 1000, 2000, 100, 10, 'active', 1, '2025-04-24 18:38:21.478636'),
(32, 'ait', '4488293810243', 1, 5, 1, 1000, 2000, 10, 12, 'active', 5, '2025-04-24 18:41:16.011160'),
(33, 'product1', '5431117258579', 1, 4, 3, 1000, 2000, 100, 10, 'active', 2, '2025-04-24 18:44:48.908509'),
(34, 'records', '3646258005491', 2, 3, 1, 50, 100, 10, 10, 'active', 2, '2025-04-24 18:53:03.165376'),
(35, 'creamsilk', '4806515161511', 1, 3, 1, 1000, 2000, -8, 12, 'active', 1, '2025-04-24 19:08:39.234479'),
(36, 'DOWNY', '4803746370248', 1, 5, 1, 1000, 2000, -16, 10, 'active', 5, '2025-04-24 19:48:31.116865');

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
  `date_create` datetime(6) NOT NULL DEFAULT current_timestamp(6)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rentalbox`
--

INSERT INTO `rentalbox` (`box_id`, `box_number`, `box_size`, `width`, `length`, `rental_fee`, `quantity`, `status`, `date_create`) VALUES
(1, 1, 'Small', 10, 10, 100, 10, 'active', '2025-04-25 21:19:45.394081'),
(2, 2, 'Large', 10, 10, 100, 10, 'active', '2025-04-25 21:22:59.347172'),
(3, 3, 'Medium', 11, 11, 100, 10, 'active', '2025-04-25 21:26:35.763146'),
(5, 4, 'Large', 10, 10, 100, 10, 'active', '2025-04-26 01:31:10.969607'),
(6, 5, 'Medium', 10, 10, 100, 10, 'active', '2025-04-26 01:31:30.102287'),
(7, 6, 'Medium', 11, 11, 100, 10, 'active', '2025-04-26 01:31:53.700323'),
(8, 7, 'Large', 10, 11, 100, 10, 'active', '2025-04-26 01:32:07.860242'),
(9, 8, 'Medium', 10, 10, 100, 10, 'active', '2025-04-26 01:32:22.044823'),
(10, 9, 'Large', 10, 10, 100, 10, 'active', '2025-04-26 01:32:45.362242'),
(11, 10, 'Medium', 10, 11, 100, 10, 'active', '2025-04-26 01:33:05.530113'),
(12, 11, 'Small', 23, 11, 100, 10, 'active', '2025-04-26 01:33:18.458649'),
(13, 12, 'Medium', 11, 11, 100, 10, 'active', '2025-04-26 01:33:34.905173'),
(14, 13, 'Small', 23, 30, 100, 10, 'active', '2025-04-26 01:33:50.666255'),
(15, 14, 'Large', 10, 11, 100, 10, 'active', '2025-04-26 01:34:08.943475'),
(16, 14, 'Large', 11, 11, 100, 10, 'active', '2025-04-26 01:45:26.367022');

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

-- --------------------------------------------------------

--
-- Table structure for table `renter`
--

CREATE TABLE `renter` (
  `renter_id` int(11) NOT NULL,
  `renter_name` varchar(50) NOT NULL,
  `contact_number` int(11) NOT NULL,
  `date_create` datetime(6) NOT NULL DEFAULT current_timestamp(6)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(31, 1, 456, 1000, 544, 'Cash', 'reno', 2147483647, '2025-04-25');

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
(5, 'supplier 1', 'spplier 1 contact erson', 2147483647, 'supplier 1 address', 'Product Supplier', 4, '1', 'example note, example note,example note,example note,example note,example note,example note,example note,example note,example note,example note,example note,example note,', '0000-00-00 00:00:00.000000');

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
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `rental-box`
--
ALTER TABLE `rental-box`
  MODIFY `box_id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rental-transaction`
--
ALTER TABLE `rental-transaction`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rentalbox`
--
ALTER TABLE `rentalbox`
  MODIFY `box_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `rented-box-transaction`
--
ALTER TABLE `rented-box-transaction`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `renter`
--
ALTER TABLE `renter`
  MODIFY `renter_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sales-transaction`
--
ALTER TABLE `sales-transaction`
  MODIFY `transact_ID` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

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
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
