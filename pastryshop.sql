-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Dec 05, 2024 at 10:56 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pastryshop`
--
CREATE DATABASE IF NOT EXISTS `pastryshop` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `pastryshop`;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `category_id` int(11) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(50) NOT NULL,
  PRIMARY KEY (`category_id`),
  UNIQUE KEY `category_name` (`category_name`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `category_name`) VALUES
(5, 'Brownies'),
(1, 'Cakes'),
(2, 'Cookies'),
(9, 'Croissants'),
(6, 'Cupcakes'),
(10, 'Donuts'),
(3, 'Muffins'),
(4, 'Pastries'),
(7, 'Pies'),
(8, 'Tarts');

-- --------------------------------------------------------

--
-- Table structure for table `inventory_log`
--

DROP TABLE IF EXISTS `inventory_log`;
CREATE TABLE IF NOT EXISTS `inventory_log` (
  `log_id` int(11) NOT NULL AUTO_INCREMENT,
  `pastry_id` int(11) NOT NULL,
  `change_quantity` int(11) NOT NULL,
  `reason` varchar(50) NOT NULL,
  `time_updated` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`log_id`),
  KEY `pastry_id` (`pastry_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inventory_log`
--

INSERT INTO `inventory_log` (`log_id`, `pastry_id`, `change_quantity`, `reason`, `time_updated`) VALUES
(1, 1, -5, 'Sold', '2024-11-07 05:10:16'),
(2, 2, -3, 'Sold', '2024-11-07 05:10:16'),
(3, 3, -2, 'Sold', '2024-11-07 05:10:16'),
(4, 4, -1, 'Sold', '2024-11-07 05:10:16'),
(5, 5, -1, 'Sold', '2024-11-07 05:10:16'),
(6, 6, 10, 'New stock', '2024-11-07 05:10:16'),
(7, 7, 15, 'New stock', '2024-11-07 05:10:16'),
(8, 8, -5, 'Sold', '2024-11-07 05:10:16'),
(9, 9, -10, 'Sold', '2024-11-07 05:10:16'),
(10, 10, 20, 'New stock', '2024-11-07 05:10:16');

-- --------------------------------------------------------

--
-- Table structure for table `pastries`
--

DROP TABLE IF EXISTS `pastries`;
CREATE TABLE IF NOT EXISTS `pastries` (
  `pastry_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `in_menu` tinyint(1) DEFAULT 1,
  `image_path` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`pastry_id`),
  KEY `category_id` (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pastries`
--

INSERT INTO `pastries` (`pastry_id`, `name`, `description`, `price`, `category_id`, `in_menu`, `image_path`) VALUES
(1, 'Chocolate Cake', 'A rich and moist chocolate cake.', 15.00, 1, 1, 'chocolate_cake.jpg'),
(2, 'Sugar Cookies', 'Sweet vanilla cookies with sugar sprinkles.', 5.00, 2, 1, 'sugar_cookies.jpg'),
(3, 'Blueberry Muffin', 'Soft and fluffy muffins with fresh blueberries.', 4.50, 3, 1, 'blueberry_muffin.jpg'),
(4, 'Cheese Danish', 'Flaky pastry filled with cream cheese.', 3.50, 4, 1, 'cheese_danish.jpg'),
(5, 'Brownie', 'Chocolate brownie with a fudge center.', 6.00, 5, 1, 'brownie.jpg'),
(6, 'Chocolate Cupcake', 'Fluffy chocolate cupcake with buttercream frosting.', 3.50, 6, 1, 'chocolate_cupcake.jpg'),
(7, 'Apple Pie', 'Classic apple pie with a flaky crust.', 8.00, 7, 1, 'apple_pie.jpg'),
(8, 'Lemon Tart', 'Tart with a smooth lemon filling.', 3.50, 8, 1, 'lemon_tart.jpg'),
(9, 'Butter Croissant', 'Golden-brown croissant.', 2.50, 9, 1, 'butter_croissant.jpg'),
(10, 'Glazed Donut', 'Classic donut with a sweet glaze.', 1.50, 10, 1, 'glazed_donut.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `role` enum('admin','employee','customer') DEFAULT 'customer',
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password_hash`, `email`, `role`, `first_name`, `last_name`, `date_created`) VALUES
(1, 'admin_user', 'info211', 'admin@example.com', 'admin', 'Admin', 'User', '2024-11-07 05:10:16'),
(2, 'customer1', 'hashedpassword2', 'customer1@example.com', 'customer', 'John', 'Doe', '2024-11-07 05:10:16'),
(3, 'customer2', 'hashedpassword3', 'customer2@example.com', 'customer', 'Jane', 'Doe', '2024-11-07 05:10:16');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `inventory_log`
--
ALTER TABLE `inventory_log`
  ADD CONSTRAINT `inventory_log_ibfk_1` FOREIGN KEY (`pastry_id`) REFERENCES `pastries` (`pastry_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pastries`
--
ALTER TABLE `pastries`
  ADD CONSTRAINT `pastries_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
