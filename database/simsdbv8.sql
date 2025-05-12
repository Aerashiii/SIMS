-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 12, 2025 at 08:40 AM
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
  `brand_id` int(11) NOT NULL,
  `brand_name` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `deleted` varchar(6) NOT NULL,
  `date_created` datetime(6) NOT NULL DEFAULT current_timestamp(6)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `brand`
--

INSERT INTO `brand` (`brand_id`, `brand_name`, `status`, `deleted`, `date_created`) VALUES
(1, 'Puma', 'active', 'no', '2025-05-12 10:02:17.106663'),
(2, 'Nike', 'active', 'no', '2025-05-12 10:02:23.476194');

-- --------------------------------------------------------

--
-- Table structure for table `business_details`
--

CREATE TABLE `business_details` (
  `id` int(11) NOT NULL,
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
(1, 'Generals Space Rent', '../../assets/images/uploads/68218db6a46e8_logo.png', 'General santos city', '09090909090', 'generalspacerent@gmail.com', '100', '100', '100', '0', '0', '2025-05-12 13:56:44.282700');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `deleted` varchar(6) NOT NULL,
  `date_created` datetime(6) NOT NULL DEFAULT current_timestamp(6)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`category_id`, `category_name`, `status`, `deleted`, `date_created`) VALUES
(1, 'Electronic', 'active', 'no', '2025-05-12 10:01:29.865459'),
(2, 'clothing', 'active', 'yes', '2025-05-12 10:01:36.436518'),
(3, 'accessories', 'active', 'no', '2025-05-12 12:03:24.116414'),
(4, 'beauty products', 'active', 'no', '2025-05-12 12:03:38.084912');

-- --------------------------------------------------------

--
-- Table structure for table `product-sales`
--

CREATE TABLE `product-sales` (
  `transact_ID` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity_sold` int(11) NOT NULL,
  `total_sale` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product-sales`
--

INSERT INTO `product-sales` (`transact_ID`, `product_id`, `quantity_sold`, `total_sale`) VALUES
(1, 4, 13, 1950),
(2, 4, 15, 2250);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `barcode` varchar(255) NOT NULL,
  `brand_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `subcategory_id` int(11) NOT NULL,
  `original_price` int(11) NOT NULL,
  `selling_price` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `reorder_point` int(11) NOT NULL,
  `status` varchar(255) NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `date_created` datetime(6) NOT NULL DEFAULT current_timestamp(6),
  `deleted` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `product_name`, `barcode`, `brand_id`, `category_id`, `subcategory_id`, `original_price`, `selling_price`, `quantity`, `reorder_point`, `status`, `supplier_id`, `date_created`, `deleted`) VALUES
(1, 'product 1', '4892797748458', 2, 1, 3, 100, 300, 110, 10, 'active', 2, '2025-05-12 10:12:49.548384', 'no'),
(2, 'ALMOND 7 VANILLA', '1017297561275', 2, 4, 5, 50, 100, 110, 10, 'active', 2, '2025-05-12 12:14:19.919725', 'yes'),
(3, 'almon & vanilla', '5729032641376', 2, 4, 5, 100, 200, 110, 10, 'active', 2, '2025-05-12 12:38:09.871013', 'no'),
(4, 'Downy', '4803746370248', 2, 4, 5, 100, 150, 72, 10, 'active', 2, '2025-05-12 14:01:04.867126', 'no');

-- --------------------------------------------------------

--
-- Table structure for table `purchase-order`
--

CREATE TABLE `purchase-order` (
  `order_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `barcode` varchar(255) NOT NULL,
  `brand_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `subcategory_id` int(11) NOT NULL,
  `original_price` int(11) NOT NULL,
  `selling_price` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `reorder_point` int(11) NOT NULL,
  `status` varchar(255) NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `date_ordered` datetime(6) NOT NULL DEFAULT current_timestamp(6),
  `deleted` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rental-box`
--

CREATE TABLE `rental-box` (
  `box_id` int(11) NOT NULL,
  `box_number` int(11) NOT NULL,
  `box_size` varchar(20) NOT NULL,
  `width` int(11) NOT NULL,
  `length` int(11) NOT NULL,
  `rental_fee` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `status` varchar(20) NOT NULL,
  `date_created` datetime(6) NOT NULL DEFAULT current_timestamp(6)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rental-transaction`
--

CREATE TABLE `rental-transaction` (
  `id` int(11) NOT NULL,
  `renter_id` int(11) NOT NULL,
  `rented_quantity` int(11) NOT NULL,
  `payment` int(11) NOT NULL,
  `rental_start_date` date NOT NULL,
  `rental_end_date` date NOT NULL,
  `status` varchar(20) NOT NULL,
  `deleted` varchar(6) NOT NULL,
  `date_created` datetime(6) NOT NULL DEFAULT current_timestamp(6)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rentalbox`
--

CREATE TABLE `rentalbox` (
  `box_id` int(11) NOT NULL,
  `box_number` int(11) NOT NULL,
  `box_size` varchar(20) NOT NULL,
  `width` int(11) NOT NULL,
  `length` int(11) NOT NULL,
  `rental_fee` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `status` varchar(20) NOT NULL,
  `deleted` varchar(6) NOT NULL,
  `date_create` datetime(6) NOT NULL DEFAULT current_timestamp(6)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rented-box-transaction`
--

CREATE TABLE `rented-box-transaction` (
  `id` int(11) NOT NULL,
  `renter_id` int(11) NOT NULL,
  `rental_transaction_id` int(11) NOT NULL,
  `box_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `date_created` datetime(6) NOT NULL DEFAULT current_timestamp(6)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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

-- --------------------------------------------------------

--
-- Table structure for table `sales-transaction`
--

CREATE TABLE `sales-transaction` (
  `transact_ID` int(11) NOT NULL,
  `total_items` int(11) NOT NULL,
  `total_payment` int(11) NOT NULL,
  `cash` int(11) NOT NULL,
  `change` int(11) NOT NULL,
  `payment_method` varchar(20) NOT NULL,
  `customer_name` varchar(100) NOT NULL,
  `contact_number` varchar(255) NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sales-transaction`
--

INSERT INTO `sales-transaction` (`transact_ID`, `total_items`, `total_payment`, `cash`, `change`, `payment_method`, `customer_name`, `contact_number`, `date`) VALUES
(1, 13, 1950, 2000, 50, 'Cash', 'Guest', 'null', '2025-05-12'),
(2, 15, 2250, 20000, 17750, 'Cash', 'Guest', 'null', '2025-05-12');

-- --------------------------------------------------------

--
-- Table structure for table `subcategory`
--

CREATE TABLE `subcategory` (
  `subcategory_id` int(11) NOT NULL,
  `subcategory_name` varchar(255) NOT NULL,
  `category_id` int(11) NOT NULL,
  `status` varchar(255) NOT NULL,
  `deleted` varchar(6) NOT NULL,
  `date_created` datetime(6) NOT NULL DEFAULT current_timestamp(6)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subcategory`
--

INSERT INTO `subcategory` (`subcategory_id`, `subcategory_name`, `category_id`, `status`, `deleted`, `date_created`) VALUES
(1, 'laptop', 1, 'active', 'no', '2025-05-12 10:01:48.728394'),
(2, 'foot wear', 1, 'active', 'no', '2025-05-12 10:02:00.466758'),
(3, 'charger', 1, 'active', 'no', '2025-05-12 12:02:41.670620'),
(4, 'headphones', 1, 'active', 'no', '2025-05-12 12:02:53.606525'),
(5, 'perfume', 4, 'active', 'no', '2025-05-12 12:03:47.869022');

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE `supplier` (
  `supplier_id` int(11) NOT NULL,
  `supplier_name` varchar(255) DEFAULT NULL,
  `contact_person` varchar(255) DEFAULT NULL,
  `contact_number` varchar(20) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `supplier_type` varchar(255) DEFAULT NULL,
  `product_category_id` int(11) DEFAULT NULL,
  `payment_terms` varchar(255) DEFAULT NULL,
  `note` varchar(255) DEFAULT NULL,
  `deleted` varchar(6) DEFAULT NULL,
  `date_added` datetime(6) DEFAULT current_timestamp(6)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`supplier_id`, `supplier_name`, `contact_person`, `contact_number`, `address`, `supplier_type`, `product_category_id`, `payment_terms`, `note`, `deleted`, `date_added`) VALUES
(1, 'supplier 1', 'spplier 1 contact erson', '11111111111', 'supplier 1 address', 'Product Supplier', 2, 'cash', '', 'no', '2025-05-12 10:02:50.749546'),
(2, 'supplier 2', 'spplier 2 contact erson', '22222222222', 'supplier 2 address', 'Rental Box Supplier', 1, 'cash', '', 'no', '2025-05-12 10:56:09.201059');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
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
(1, 'adminer', 'admin', 'admin', 'admin', '../../assets/images/uploads/68219387ea2e5_6810e3d0b8ff9_wall.jpg', '2025-05-12 01:36:13'),
(3, 'cashier', 'cashier', 'cashier', 'cashier', 'default.png', '2025-05-12 06:18:23');

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
-- Indexes for table `product-sales`
--
ALTER TABLE `product-sales`
  ADD PRIMARY KEY (`transact_ID`);

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
  MODIFY `brand_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `business_details`
--
ALTER TABLE `business_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `product-sales`
--
ALTER TABLE `product-sales`
  MODIFY `transact_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `purchase-order`
--
ALTER TABLE `purchase-order`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rental-box`
--
ALTER TABLE `rental-box`
  MODIFY `box_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rental-transaction`
--
ALTER TABLE `rental-transaction`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rentalbox`
--
ALTER TABLE `rentalbox`
  MODIFY `box_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rented-box-transaction`
--
ALTER TABLE `rented-box-transaction`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `renter`
--
ALTER TABLE `renter`
  MODIFY `renter_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sales-transaction`
--
ALTER TABLE `sales-transaction`
  MODIFY `transact_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `subcategory`
--
ALTER TABLE `subcategory`
  MODIFY `subcategory_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `supplier`
--
ALTER TABLE `supplier`
  MODIFY `supplier_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
