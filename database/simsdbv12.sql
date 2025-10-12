-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 12, 2025 at 02:49 PM
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
(1, 'b1', 'active', 'no', '2025-10-04 21:17:46.497647');

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
  `monthly_rate` varchar(255) NOT NULL,
  `low_strock_alert` varchar(255) NOT NULL,
  `overdue_rental_alert` varchar(255) NOT NULL,
  `date_create` datetime(6) NOT NULL DEFAULT current_timestamp(6)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(1, 'c1', 'active', 'yes', '2025-09-30 22:06:13.960385'),
(2, 'c2', 'active', 'no', '2025-09-30 22:25:07.051629'),
(3, 'c1', 'active', 'no', '2025-10-01 14:31:56.556179'),
(4, 'c3', 'active', 'no', '2025-10-01 17:52:31.930944'),
(5, 'c4', 'active', 'no', '2025-10-01 17:59:39.751468');

-- --------------------------------------------------------

--
-- Table structure for table `ordered_products`
--

CREATE TABLE `ordered_products` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ordered_products`
--

INSERT INTO `ordered_products` (`id`, `order_id`, `product_id`, `quantity`) VALUES
(1, 3, 5, 13),
(2, 4, 6, 100),
(3, 5, 7, 1),
(4, 5, 8, 1),
(5, 5, 9, 1),
(6, 6, 10, 100),
(7, 7, 11, 1100);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `barcode` varchar(255) NOT NULL,
  `brand_id` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `subcategory_id` int(11) DEFAULT NULL,
  `original_price` int(11) NOT NULL,
  `selling_price` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `reorder_point` int(11) NOT NULL,
  `status` varchar(255) NOT NULL,
  `supplier_id` int(11) DEFAULT NULL,
  `description` varchar(255) NOT NULL,
  `date_created` datetime(6) NOT NULL DEFAULT current_timestamp(6),
  `deleted` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `product_name`, `barcode`, `brand_id`, `category_id`, `subcategory_id`, `original_price`, `selling_price`, `quantity`, `reorder_point`, `status`, `supplier_id`, `description`, `date_created`, `deleted`) VALUES
(1, '1', '6723425706646', NULL, NULL, NULL, 1, 1, 1, 1, '0', NULL, '1', '2025-09-29 10:32:50.659636', 'no'),
(2, 'p1', '2166977819029', 1, 4, 2, 1, 1, 1, 1, 'active', 2, '1', '2025-10-05 21:59:16.045395', 'no'),
(3, 'test1', '5080910610410', 1, NULL, 2, 90, 90, 90, 90, '0', NULL, 'test1', '2025-10-10 20:57:25.614180', 'no'),
(4, 'add', '2033148108193', 1, NULL, NULL, 45, 45, 45, 45, 'active', NULL, 'add', '2025-10-10 21:04:20.503842', 'no'),
(5, 'hey', '0911844330014', NULL, NULL, NULL, 13, 13, 0, 13, 'pending', NULL, 'hey', '2025-10-12 00:28:07.517079', 'no'),
(6, 'hey', '0866903807667', 1, 2, 1, 50, 70, 0, 10, 'active', 2, 'hey', '2025-10-12 15:46:27.303811', 'no'),
(7, 'hey1', '5105082522353', NULL, NULL, NULL, 1, 1, 0, 1, 'active', NULL, 'hey1', '2025-10-12 15:53:16.565797', 'no'),
(8, 'hey2', '3603034235026', 1, NULL, NULL, 1, 1, 0, 1, 'active', NULL, 'hey2', '2025-10-12 15:53:16.630892', 'no'),
(9, 'hey3', '2712706994608', 1, 3, NULL, 1, 1, 0, 1, 'active', NULL, 'hey3', '2025-10-12 15:53:16.746839', 'no'),
(10, 'ty', '9733062317645', 1, 5, 2, 299, 399, 0, 10, 'active', 2, 'ty', '2025-10-12 20:17:40.583526', 'no'),
(11, 'ty2', '7037916570263', 1, 3, 2, 1000, 2000, 1150, 5, 'active', NULL, 'ty2', '2025-10-12 20:21:04.255508', 'no');

-- --------------------------------------------------------

--
-- Table structure for table `product_sales`
--

CREATE TABLE `product_sales` (
  `transact_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity_sold` int(11) NOT NULL,
  `total_sale` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `purchase_order_transaction`
--

CREATE TABLE `purchase_order_transaction` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `total_product` int(11) NOT NULL,
  `total_cost` decimal(10,2) NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `status` varchar(50) NOT NULL,
  `date` datetime(6) NOT NULL DEFAULT current_timestamp(6),
  `deleted` varchar(10) NOT NULL DEFAULT 'no'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `purchase_order_transaction`
--

INSERT INTO `purchase_order_transaction` (`id`, `user_id`, `total_product`, `total_cost`, `supplier_id`, `status`, `date`, `deleted`) VALUES
(1, 1, 1, 144.00, 0, 'completed', '2025-10-10 09:53:37.962154', 'no'),
(2, 1, 4, 576.00, 0, 'pending', '2025-10-10 09:54:41.569972', 'no'),
(3, 1, 1, 169.00, 0, 'pending', '2025-10-12 00:28:07.436114', 'no'),
(4, 1, 1, 5000.00, 2, 'completed', '2025-10-12 15:46:27.052319', 'no'),
(5, 1, 3, 3.00, 0, 'completed', '2025-10-12 15:53:16.506708', 'no'),
(6, 1, 1, 29900.00, 2, 'completed', '2025-10-12 20:17:40.484055', 'no'),
(7, 1, 1, 1100000.00, 0, 'completed', '2025-10-12 20:21:04.158792', 'no');

-- --------------------------------------------------------

--
-- Table structure for table `rental_box`
--

CREATE TABLE `rental_box` (
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
-- Table structure for table `rental_transaction`
--

CREATE TABLE `rental_transaction` (
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
-- Table structure for table `rented_box_transaction`
--

CREATE TABLE `rented_box_transaction` (
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
-- Table structure for table `sales_transaction`
--

CREATE TABLE `sales_transaction` (
  `transact_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `total_items` int(11) NOT NULL,
  `total_payment` int(11) NOT NULL,
  `cash` int(11) NOT NULL,
  `change_amt` int(11) NOT NULL,
  `payment_method` varchar(20) NOT NULL,
  `customer_name` varchar(100) NOT NULL,
  `contact_number` varchar(255) NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(1, 'sb1', 3, 'active', 'no', '2025-10-01 21:55:20.104332'),
(2, 'cb2', 2, 'active', 'no', '2025-10-01 22:26:06.762582');

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
(1, 'sup1', 'sup1', '1111111111', 'sup1', 'Product Supplier', 5, 'cash', 'sup1', 'no', '2025-10-09 09:30:52.136069'),
(2, 'sup2', 'sup2', '22222222222', 'sup2', 'Service Provider', 3, 'cash', 'sup2', 'no', '2025-10-09 09:32:32.925381'),
(3, 'sup4', 'sup4', '22222222222', 'sup2', 'Service Provider', 3, 'cash', 'sup2', 'yes', '2025-10-09 09:32:32.936010'),
(4, 'sup3', 'sup3', '3333333333', 'sup3', 'Raw Material Supplier', 2, 'cash', 'sup3', 'yes', '2025-10-09 09:33:29.602538');

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
(1, 'admin', 'admin', 'admin', 'admin', '../../assets/images/uploads/68d895b3e6a98_default-profile.png', '2025-09-28 01:55:24');

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
-- Indexes for table `ordered_products`
--
ALTER TABLE `ordered_products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `brand_id` (`brand_id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `subcategory_id` (`subcategory_id`),
  ADD KEY `supplier_id` (`supplier_id`);

--
-- Indexes for table `product_sales`
--
ALTER TABLE `product_sales`
  ADD PRIMARY KEY (`transact_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `purchase_order_transaction`
--
ALTER TABLE `purchase_order_transaction`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rental_box`
--
ALTER TABLE `rental_box`
  ADD PRIMARY KEY (`box_id`);

--
-- Indexes for table `rental_transaction`
--
ALTER TABLE `rental_transaction`
  ADD PRIMARY KEY (`id`),
  ADD KEY `renter_id` (`renter_id`);

--
-- Indexes for table `rented_box_transaction`
--
ALTER TABLE `rented_box_transaction`
  ADD PRIMARY KEY (`id`),
  ADD KEY `renter_id` (`renter_id`),
  ADD KEY `rental_transaction_id` (`rental_transaction_id`),
  ADD KEY `box_id` (`box_id`);

--
-- Indexes for table `renter`
--
ALTER TABLE `renter`
  ADD PRIMARY KEY (`renter_id`);

--
-- Indexes for table `sales_transaction`
--
ALTER TABLE `sales_transaction`
  ADD PRIMARY KEY (`transact_id`);

--
-- Indexes for table `subcategory`
--
ALTER TABLE `subcategory`
  ADD PRIMARY KEY (`subcategory_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`supplier_id`),
  ADD KEY `product_category_id` (`product_category_id`);

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
  MODIFY `brand_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `business_details`
--
ALTER TABLE `business_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `ordered_products`
--
ALTER TABLE `ordered_products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `product_sales`
--
ALTER TABLE `product_sales`
  MODIFY `transact_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `purchase_order_transaction`
--
ALTER TABLE `purchase_order_transaction`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `rental_box`
--
ALTER TABLE `rental_box`
  MODIFY `box_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rental_transaction`
--
ALTER TABLE `rental_transaction`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rented_box_transaction`
--
ALTER TABLE `rented_box_transaction`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `renter`
--
ALTER TABLE `renter`
  MODIFY `renter_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sales_transaction`
--
ALTER TABLE `sales_transaction`
  MODIFY `transact_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `subcategory`
--
ALTER TABLE `subcategory`
  MODIFY `subcategory_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `supplier`
--
ALTER TABLE `supplier`
  MODIFY `supplier_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`brand_id`) REFERENCES `brand` (`brand_id`),
  ADD CONSTRAINT `products_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `category` (`category_id`),
  ADD CONSTRAINT `products_ibfk_3` FOREIGN KEY (`subcategory_id`) REFERENCES `subcategory` (`subcategory_id`),
  ADD CONSTRAINT `products_ibfk_4` FOREIGN KEY (`supplier_id`) REFERENCES `supplier` (`supplier_id`);

--
-- Constraints for table `product_sales`
--
ALTER TABLE `product_sales`
  ADD CONSTRAINT `product_sales_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `rental_transaction`
--
ALTER TABLE `rental_transaction`
  ADD CONSTRAINT `rental_transaction_ibfk_1` FOREIGN KEY (`renter_id`) REFERENCES `renter` (`renter_id`);

--
-- Constraints for table `rented_box_transaction`
--
ALTER TABLE `rented_box_transaction`
  ADD CONSTRAINT `rented_box_transaction_ibfk_1` FOREIGN KEY (`renter_id`) REFERENCES `renter` (`renter_id`),
  ADD CONSTRAINT `rented_box_transaction_ibfk_2` FOREIGN KEY (`rental_transaction_id`) REFERENCES `rental_transaction` (`id`),
  ADD CONSTRAINT `rented_box_transaction_ibfk_3` FOREIGN KEY (`box_id`) REFERENCES `rental_box` (`box_id`);

--
-- Constraints for table `subcategory`
--
ALTER TABLE `subcategory`
  ADD CONSTRAINT `subcategory_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `category` (`category_id`);

--
-- Constraints for table `supplier`
--
ALTER TABLE `supplier`
  ADD CONSTRAINT `supplier_ibfk_1` FOREIGN KEY (`product_category_id`) REFERENCES `category` (`category_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
