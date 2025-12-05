-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 03, 2025 at 02:45 PM
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
-- Database: `fitscan_database`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `shoe_id` int(11) DEFAULT NULL,
  `shoe_name` varchar(255) DEFAULT NULL,
  `size` varchar(255) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `shoe_image` varchar(255) DEFAULT NULL,
  `shoe_type` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `user_id`, `shoe_id`, `shoe_name`, `size`, `quantity`, `price`, `shoe_image`, `shoe_type`) VALUES
(76, 66, 1, 'Jordan 1 All White', 's36', 1, 1500.00, 'uploads/1746075151_jordan 1 all whiwte.jpeg', 'Bulky'),
(82, 66, 2, 'Jordan 1 Reverse', 's39', 1, 1500.00, 'uploads/1746075192_jordan 1 reverse.jpeg', 'Bulky'),
(83, 66, 2, 'Jordan 1 Reverse', 's36', 2, 1500.00, 'uploads/1746075192_jordan 1 reverse.jpeg', 'Bulky'),
(84, 66, 4, 'New Balance OG', 's42', 1, 1700.00, 'uploads/1746075320_new balance OG.jpeg', 'Bulky'),
(87, 48, 1, 'Jordan 1 All White', 's40', 1, 1500.00, 'uploads/1746075151_jordan 1 all whiwte.jpeg', 'Bulky');

-- --------------------------------------------------------

--
-- Table structure for table `inquiries`
--

CREATE TABLE `inquiries` (
  `id` int(11) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `province` varchar(255) DEFAULT NULL,
  `municipality` varchar(255) DEFAULT NULL,
  `barangay` varchar(255) DEFAULT NULL,
  `street` varchar(255) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `size` varchar(50) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `shoe_id` int(11) DEFAULT NULL,
  `shoe_type` varchar(100) DEFAULT NULL,
  `shoe_name` varchar(255) DEFAULT NULL,
  `status` enum('pending','accepted','declined','Cancelled Order','Cancelled pending') DEFAULT 'pending',
  `order_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inquiries`
--

INSERT INTO `inquiries` (`id`, `username`, `email`, `phone`, `province`, `municipality`, `barangay`, `street`, `message`, `size`, `quantity`, `price`, `shoe_id`, `shoe_type`, `shoe_name`, `status`, `order_date`) VALUES
(116, 'willien', 'williencarlossazon029@gmail.com', '09616366968', 'Pampanga', 'Porac', 'Babo Sacan', 'Gunazon St', 'Cart checkout for Jordan 1 All White.', 's42', 4, 1500.00, 1, 'From Cart', 'Jordan 1 All White', 'pending', '2025-09-11 12:19:22'),
(117, 'willien', 'williencarlossazon029@gmail.com', '09616366968', 'Pampanga', 'Porac', 'Babo Sacan', 'Gunazon St', 'Cart checkout for Jordan 1 All White.', 's41', 1, 1500.00, 1, 'From Cart', 'Jordan 1 All White', 'pending', '2025-09-11 12:19:54'),
(118, 'willien', 'williencarlossazon029@gmail.com', '09616366968', 'Pampanga', 'Porac', 'Babo Sacan', 'Gunazon St', 'Cart checkout for Jordan 1 All White.', 's41', 3, 1500.00, 1, 'From Cart', 'Jordan 1 All White', 'accepted', '2025-09-11 12:25:21'),
(119, 'willien', 'williencarlossazon029@gmail.com', '09616366968', 'Pampanga', 'Porac', 'Babo Sacan', 'Gunazon St', 'Cart checkout for Jordan 1 All White.', 's38', 6, 1500.00, 1, 'From Cart', 'Jordan 1 All White', 'accepted', '2025-09-11 15:06:54'),
(120, 'willien', 'williencarlossazon029@gmail.com', '09616366968', 'Pampanga', 'Porac', 'Babo Sacan', 'Gunazon St', 'Cart checkout for Jordan 1 All White.', 's38', 4, 1500.00, 1, 'From Cart', 'Jordan 1 All White', 'accepted', '2025-09-11 15:15:37'),
(121, 'willien', 'williencarlossazon029@gmail.com', '09616366968', 'Pampanga', 'Porac', 'Babo Sacan', 'Gunazon St', 'Cart checkout for Jordan 1 All White.', 's38', 4, 1500.00, 1, 'From Cart', 'Jordan 1 All White', 'accepted', '2025-09-11 15:22:19'),
(122, 'willien', 'williencarlossazon029@gmail.com', '09616366968', 'Pampanga', 'Porac', 'Babo Sacan', 'Gunazon St', 'Cart checkout for Jordan 1 All White.', 's38', 5, 1500.00, 1, 'From Cart', 'Jordan 1 All White', 'accepted', '2025-09-11 15:32:40'),
(123, 'willien', 'williencarlossazon029@gmail.com', '09616366968', 'Pampanga', 'Porac', 'Babo Sacan', 'Gunazon St', 'Cart checkout for Jordan 1 All White.', 's38', 5, 1500.00, 1, 'From Cart', 'Jordan 1 All White', 'accepted', '2025-09-11 15:46:37'),
(125, 'willien', 'williencarlossazon029@gmail.com', '09616366968', 'Pampanga', 'Porac', 'Babo Sacan', 'Gunazon St', 'Cart checkout for Jordan 1 All White.', 's38', 4, 1500.00, 1, 'From Cart', 'Jordan 1 All White', 'accepted', '2025-09-11 15:56:26'),
(126, 'willien', 'williencarlossazon029@gmail.com', '09616366968', 'Pampanga', 'Porac', 'Babo Sacan', 'Gunazon St', 'Cart checkout for Jordan 1 All White.', 's38', 4, 1500.00, 1, 'From Cart', 'Jordan 1 All White', 'accepted', '2025-09-11 16:15:28'),
(127, 'willien', 'williencarlossazon029@gmail.com', '09616366968', 'Pampanga', 'Porac', 'Babo Sacan', 'Gunazon St', 'Cart checkout for Jordan 1 All White.', 's36', 1, 1500.00, 1, 'From Cart', 'Jordan 1 All White', 'accepted', '2025-09-16 06:02:52'),
(128, 'willien', 'williencarlossazon029@gmail.com', '09616366968', 'Pampanga', 'Porac', 'Babo Sacan', 'Gunazon St', 'Cart checkout for Jordan 1 All White.', 's38', 3, 1500.00, 1, 'From Cart', 'Jordan 1 All White', 'accepted', '2025-09-16 06:10:38'),
(129, 'willien', 'williencarlossazon029@gmail.com', '09616366968', 'Pampanga', 'Porac', 'Babo Sacan', 'Gunazon St', 'Cart checkout for Jordan 1 All White.', 's38', 4, 1500.00, 1, 'From Cart', 'Jordan 1 All White', 'accepted', '2025-09-16 06:14:22'),
(130, 'willien', 'williencarlossazon029@gmail.com', '09616366968', 'Pampanga', 'Porac', 'Babo Sacan', 'Gunazon St', 'Cart checkout for Jordan 1 All White.', 's38', 3, 1500.00, 1, 'From Cart', 'Jordan 1 All White', 'accepted', '2025-09-16 06:18:46'),
(139, 'willien', 'williencarlossazon029@gmail.com', '09616366968', 'Pampanga', 'Porac', 'Babo Sacan', 'Gunazon St', 'Cart checkout for Jordan 1 All White.', 's38', 3, 1500.00, 1, 'Bulky', 'Jordan 1 All White', 'accepted', '2025-09-18 03:56:08'),
(140, 'willien', 'williencarlossazon029@gmail.com', '09616366968', 'Pampanga', 'Porac', 'Babo Sacan', 'Gunazon St', 'Cart checkout for New Balance 530.', 's37', 1, 1700.00, 3, 'Bulky', 'New Balance 530', 'accepted', '2025-09-18 04:03:16'),
(143, 'willien', 'williencarlossazon029@gmail.com', '09616366968', 'Pampanga', 'Porac', 'Babo Sacan', 'Gunazon St', '', 's38', 2, 1500.00, 1, 'Bulky', 'Jordan 1 All White', 'pending', '2025-09-18 08:51:53'),
(144, 'willien', 'williencarlossazon029@gmail.com', '09616366968', 'Pampanga', 'Porac', 'Babo Sacan', 'Gunazon St', '', 's38', 5, 1500.00, 1, 'Bulky', 'Jordan 1 All White', 'accepted', '2025-09-18 09:08:55'),
(145, 'Evangelion Bueno', 'evanbueno1283@gmail.com', '09502402776', 'Pampanga', 'Porac', 'porac', 'Bonifacio St', 'evanpogi', 's36', 1, 1500.00, 1, 'Bulky', 'Jordan 1 All White', 'accepted', '2025-09-26 18:25:53'),
(146, 'Evangelion Bueno', 'evanbueno1283@gmail.com', '09502402776', 'Pampanga', 'Porac', 'porac', 'Bonifacio St', 'Cart checkout for Jordan 1 All White.', 's38', 1, 1500.00, 1, 'Bulky', 'Jordan 1 All White', 'pending', '2025-09-30 17:56:47'),
(147, 'Evangelion Bueno', 'evanbueno1283@gmail.com', '09502402776', 'Pampanga', 'Porac', 'porac', 'Bonifacio St', 'Cart checkout for Jordan 1 Reverse.', 's39', 1, 1500.00, 2, 'Bulky', 'Jordan 1 Reverse', 'pending', '2025-09-30 17:56:48'),
(148, 'Evangelion Bueno', 'evanbueno1283@gmail.com', '09502402776', 'Pampanga', 'Porac', 'porac', 'Bonifacio St', 'Cart checkout for New Balance 530.', 's39', 1, 1700.00, 3, 'Bulky', 'New Balance 530', 'pending', '2025-09-30 17:56:48'),
(149, 'Christian Sicat', 'cmercadosicat@yahoo.com', '09123456789', 'Manila', 'Valenzuela', 'Karwatan', 'st peter', 'Cart checkout for Jordan 1 Reverse.', 's39', 1, 1500.00, 2, 'Bulky', 'Jordan 1 Reverse', 'pending', '2025-10-11 15:53:07'),
(150, 'Christian Sicat', 'cmercadosicat@yahoo.com', '09123456789', 'Manila', 'Valenzuela', 'Karwatan', 'st peter', 'Cart checkout for New Balance 530.', 's36', 2, 1700.00, 3, 'Bulky', 'New Balance 530', 'pending', '2025-10-11 15:53:07');

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE `inventory` (
  `id` int(11) NOT NULL,
  `shoe_type` varchar(255) DEFAULT NULL,
  `shoe_name` varchar(255) NOT NULL,
  `shoe_image` varchar(255) NOT NULL,
  `s36` int(11) DEFAULT 0,
  `s37` int(11) DEFAULT 0,
  `s38` int(11) DEFAULT 0,
  `s39` int(11) DEFAULT 0,
  `s40` int(11) DEFAULT 0,
  `s41` int(11) DEFAULT 0,
  `s42` int(11) DEFAULT 0,
  `s43` int(11) DEFAULT 0,
  `s44` int(11) DEFAULT 0,
  `s45` int(11) DEFAULT 0,
  `price` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`id`, `shoe_type`, `shoe_name`, `shoe_image`, `s36`, `s37`, `s38`, `s39`, `s40`, `s41`, `s42`, `s43`, `s44`, `s45`, `price`) VALUES
(1, 'Bulky', 'Jordan 1 All White', 'uploads/1746075151_jordan 1 all whiwte.jpeg', -3, 0, 29, 1, 1, 1, 1, 0, 0, 2, 1500),
(2, 'Bulky', 'Jordan 1 Reverse', 'uploads/1746075192_jordan 1 reverse.jpeg', 5, 0, 0, 5, 0, 0, 0, 0, 0, 0, 1500),
(3, 'Bulky', 'New Balance 530 ', 'uploads/1746075290_new balance 530.jpeg', 2, -1, 0, 1, 1, 0, 1, 0, 0, 0, 1700),
(4, 'Bulky', 'New Balance OG', 'uploads/1746075320_new balance OG.jpeg', 1, 0, 0, 2, 1, 0, 1, 0, 0, 0, 1700),
(5, 'Bulky', 'Puma Xl Black', 'uploads/1746075352_puma Xl black.jpeg', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1700),
(6, 'Bulky', 'Puma Xl Red', 'uploads/1746075383_puma Xl red.jpeg', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1700),
(7, 'Slim', 'Speed Cat Brown', 'uploads/1746075435_speed cat brown.jpeg', 2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1800),
(8, 'Slim', 'Onitsuka Black', 'uploads/1746077792_onitsuka black.jpeg', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1500),
(9, 'Slim', 'Onitsuka White', 'uploads/1746077820_onitsuka white.jpeg', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1500),
(10, 'Slim', 'Speed Cat Ferari', 'uploads/1746077869_speec cat ferari.jpeg', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1700),
(11, 'Basketball', 'Lebron Purple', 'uploads/1746077938_Lebron Purple.jpeg', 2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1800),
(12, 'Basketball', 'Gt Cut', 'uploads/1746077977_Gt Cut.jpeg', 2, 0, 0, 2, 0, 0, 0, 0, 0, 0, 1800),
(13, 'Basketball', 'Lamelo Blue', 'uploads/1746078005_lamelo blue.jpeg', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1800),
(14, 'Running', 'Aesic Neon', 'uploads/1746078045_Aesic Neon.jpeg', 1, 1, 0, 1, 0, 0, 0, 0, 0, 1, 1800),
(15, 'Running', 'Pegasus Black', 'uploads/1746078066_pegasus black.jpeg', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1800),
(16, 'Running', 'Pegasus Gray', 'uploads/1746078087_Pegasus gray.jpeg', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1800),
(17, 'Running', 'Pegasus Ghite', 'uploads/1746078111_pegasus white.jpeg', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1800),
(18, 'Running', 'Cloudtek Red White', 'uploads/1746078140_Cloudtek red white.jpeg', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1800),
(19, 'Classic', 'Vanz Potato', 'uploads/1746078202_Vanz potato.jpeg', 1, 0, 0, 3, 0, 0, 0, 0, 0, 0, 1800),
(20, 'Classic', 'Vanz Creamwhite', 'uploads/1746078227_Vanz Creamwhite.jpeg', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1800),
(21, 'Classic', 'Vanz Chekerd', 'uploads/1746078251_Vanz chekerd.jpeg', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1800),
(22, 'Classic', 'Campus Corn', 'uploads/1746078284_Campus corn.jpeg', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1800),
(23, 'Classic', 'Bapesta Black', 'uploads/1746078333_bapesta black.jpeg', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1800),
(25, 'Slide', 'air jordan tempo slide', 'uploads/1746762764_bgdd33.png', 1, 1, 0, 0, 0, 0, 1, 1, 0, 1, 1700),
(26, 'Bulky', 'wsdf', 'uploads/shoe_68de535fb0a564.61201697.png', 5, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1200),
(27, 'Bulky', 'cloudtek', 'uploads/shoe_68de54bea87624.95744123.jpg', 50, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1350),
(28, 'Bulky', 'cloudB/w', 'uploads/shoe_68de55aa7f6915.87498616.jpg', 2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1250),
(29, 'Slim', 'cloudtekkkkkkk', 'uploads/shoe_68de55cc9a4660.96767564.jpg', 20, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1800);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `province` varchar(50) DEFAULT NULL,
  `municipality` varchar(50) DEFAULT NULL,
  `barangay` varchar(50) DEFAULT NULL,
  `street` varchar(100) DEFAULT NULL,
  `phone` varchar(20) NOT NULL,
  `code` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `username`, `password`, `gender`, `province`, `municipality`, `barangay`, `street`, `phone`, `code`) VALUES
(48, 'cmercadosicat@yahoo.com', 'Christian Sicat', '$2y$10$8y4bi.CorG0pS8uXu/y47.SpDa3HmMFgTgFA8SsEgJSYgnVyWGhx.', 'Female', 'Manila', 'Valenzuela', 'Karwatan', 'st peter', '09123456789', NULL),
(51, 'reyna14res@gmail.com', 'chanchan', '$2y$10$B9eLyiW9YRppqmQV8SxN2.3riN9rLjhM1lhBUxAMWRKcC19WTPchm', 'Female', 'Manila', 'Makati', 'Bangkal', 'Kuya Moto', '09273847261', NULL),
(52, 'ululgagu123@gmail.com', 'gagu123', '$2y$10$B4.Vho59RvvDakq7j4QOSeh/f63Ouar3VRr376mwQU5PyqIBxTtle', 'Other', 'Manila', 'Makati', 'Bangkal', 'St Jojo Moto', '09123123123', '974583'),
(53, 'pogiku@gmail.com', 'pogiku', '$2y$10$uIi7saz5alQLBaIsapS8VOC24FYEYKjQqBs3lWBA9e3rDX0.EsceC', 'Female', 'Pampanga', 'Porac', 'Babo Sacan', 'Bonifacio St', '009123456789', NULL),
(54, 'asdfasdf@gmail.com', 'evanpogi', '$2y$10$F0Sbrq6xz4VPRnJN0gG5xe9e8RtCfvtAnWQ/BXKeP8VHV3SFPk3sG', 'Male', 'Pampanga', 'Porac', 'Babo Sacan', 'Bonifacio St', '09542789654', NULL),
(55, 'zxcvbn@gmail.com', 'hsdhfahsdf', '$2y$10$PZ0lBZBzFJ19i0NSPKBGmOcs9G/LfiCF0hgZLTt2MRA8Bo0bwaRLi', 'Male', 'Pampanga', 'Porac', 'Babo Sacan', 'Bonifacio St', '09524718563', NULL),
(56, 'qwerty@gmail.com', 'dsafsdfasdf', '$2y$10$UQYZYdpcyFAqqUgl4WVdt.ppzBW4EBwh1Aorim7CCIzuhpQfUi5EG', 'Male', 'Pampanga', 'Porac', 'Babo Sacan', 'Bonifacio St', '09541247856', NULL),
(57, 'asdfasdfasdfasdf@gmail.com', 'evanpoginumber1', '$2y$10$E/xL7lZGlBsdd7Fd5IoAz.WawATEgCwEfsyhvYeIO69JXe8lf/N4y', 'Male', 'Pampanga', 'Porac', 'Babo Sacan', 'Bonifacio St', '02145785415', NULL),
(58, 'iveedelacruz402@gmail.com', 'Delacruz Ivee', '$2y$10$2MNGXLZXIGMh4CHi6CcTfuLMTMSoc08wBOSOAaVQfzMvGs0ZuWenW', 'Female', 'Pampanga', 'Porac', 'Babo Sacan', 'Bonifacio St', '09851402091', NULL),
(59, 'gunshinbueno@gmail.com', 'Raymar Bueno', '$2y$10$WSO/SpTyIh3B9eUVhnX4bOy/AtY8pIyG/M.J44Qys./gK8wnulSOe', 'Male', 'Pampanga', 'Porac', 'Babo Sacan', 'Bonifacio St', '09993995534', NULL),
(61, 'evanbueno1283@gmail.com', 'Evangelion Bueno', '$2y$10$I16OpDEN3ddx6q/e7wBrPOFvhcVwNsn0GjvJbrv98OwboKT/T/mvm', 'Male', 'Pampanga', 'Porac', 'porac', 'Bonifacio St', '09502402776', NULL),
(62, 'esguerralorence08@gmail.com', 'lorence Esguerra', '$2y$10$KdIhZEu9XNt6D7.3tXzin.V5AolgHwil22uEeF2qNRYqNPmlsemji', 'Male', 'Pampanga', 'Porac', 'Babo Sacan', 'Bonifacio St', '09502402776', NULL),
(63, 'jwee8802@gmail.com', 'chakalalala', '$2y$10$DBqTQN9449u3JKrGcGFYD.IYfKqDOQU3XAhn8WeQXczlzeZ7GkQuS', 'Female', 'Pampanga', 'Porac', 'Babo Sacan', 'Gunazon St', '09193177823', NULL),
(66, 'williencarlossazon029@gmail.com', 'willien', '$2y$10$chQ5FwDZW1o3njh3RCKTdegNSYWjdBdNfRoYD6muvIMx/MPrW8X/e', 'Male', 'Pampanga', 'Porac', 'Babo Sacan', 'Gunazon St', '09616366968', '490572'),
(67, 'qwertyyy@gmail.com', 'chanchan', '$2y$10$lo1VbvXTwgRhQHOWJERswereWzeypGApRptJkOVAFnoCtV0A0jjzC', 'Female', 'Pampanga', 'Porac', 'Babo Sacan', 'Bonifacio St', '0912457826', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_reviews`
--

CREATE TABLE `user_reviews` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `rating` int(11) NOT NULL,
  `comment` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_reviews`
--

INSERT INTO `user_reviews` (`id`, `email`, `rating`, `comment`, `created_at`) VALUES
(37, 'cmercadosicat@yahoo.com', 3, 'asdsadsa', '2025-08-10 12:33:37'),
(38, 'jwee8802@gmail.com', 5, 'hahahaha\n', '2025-08-10 13:07:59'),
(51, 'evanbueno1283@gmail.com', 5, 'evanpogi', '2025-09-20 17:34:31'),
(52, 'williencarlossazon029@gmail.com', 4, '', '2025-10-07 05:02:10'),
(53, 'qwertyyy@gmail.com', 3, 'ayoss', '2025-10-13 04:24:47');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inquiries`
--
ALTER TABLE `inquiries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_reviews`
--
ALTER TABLE `user_reviews`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=88;

--
-- AUTO_INCREMENT for table `inquiries`
--
ALTER TABLE `inquiries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=151;

--
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT for table `user_reviews`
--
ALTER TABLE `user_reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
