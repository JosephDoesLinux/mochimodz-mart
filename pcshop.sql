-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 22, 2025 at 03:45 AM
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
-- Database: `pcshop`
--

-- --------------------------------------------------------

--
-- Table structure for table `carts`
--

CREATE TABLE `carts` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `carts`
--

INSERT INTO `carts` (`id`, `user_id`, `created_at`) VALUES
(1, 1, '2025-05-20 20:52:56');

-- --------------------------------------------------------

--
-- Table structure for table `cart_items`
--

CREATE TABLE `cart_items` (
  `id` int(11) NOT NULL,
  `cart_id` int(11) NOT NULL,
  `part_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart_items`
--

INSERT INTO `cart_items` (`id`, `cart_id`, `part_id`, `quantity`) VALUES
(6, 1, 4, 4),
(8, 1, 7, 1),
(9, 1, 8, 1),
(10, 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `parts`
--

CREATE TABLE `parts` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `category` varchar(50) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `parts`
--

INSERT INTO `parts` (`id`, `name`, `category`, `description`, `price`, `image`, `created_at`) VALUES
(1, 'Intel Core i5-13600K', 'CPU', '12-core 24-thread desktop processor', 319.99, 'i5-13600k.jpg', '2025-05-20 20:49:35'),
(2, 'NVIDIA RTX 4070', 'GPU', 'Graphics card with 12GB GDDR6X', 599.00, 'rtx4070.jpg', '2025-05-20 20:49:35'),
(3, 'Corsair Vengeance LPX 16GB', 'RAM', 'DDR4 3200MHz (2×8GB)', 74.99, 'vengeance16.jpg', '2025-05-20 20:49:35'),
(4, 'AMD Ryzen 9 7900X', 'CPU', '12-core / 24-thread processor, 4.7 GHz base, 5.6 GHz boost', 549.99, 'amd-7900x.jpg', '2025-05-20 20:57:55'),
(5, 'Intel Core i7-13700K', 'CPU', '16-core / 24-thread, up to 5.4 GHz boost', 419.99, 'i7-13700k.jpg', '2025-05-20 20:57:55'),
(6, 'NVIDIA GeForce RTX 4090', 'GPU', '24 GB GDDR6X, DLSS 3.0', 1599.00, 'rtx4090.jpg', '2025-05-20 20:57:55'),
(7, 'AMD Radeon RX 7900 XT', 'GPU', '20 GB GDDR6, RDNA 3', 999.00, 'rx7900xt.jpg', '2025-05-20 20:57:55'),
(8, 'Corsair Vengeance RGB Pro 32 GB', 'RAM', 'DDR4 3600 MHz (2×16 GB), RGB', 159.99, 'vengeance32.jpg', '2025-05-20 20:57:55'),
(9, 'G.Skill Trident Z5 RGB 16 GB', 'RAM', 'DDR5 6000 MHz (2×8 GB), RGB accents', 139.99, 'tridentz5.jpg', '2025-05-20 20:57:55'),
(10, 'ASUS ROG Strix X670E-E', 'Motherboard', 'AM5 ATX, Wi-Fi 6E, PCIe 5.0', 429.99, 'rog-strix-x670e.jpg', '2025-05-20 20:57:55'),
(11, 'MSI MPG Z790 Carbon WiFi', 'Motherboard', 'LGA 1700 ATX, DDR5, Thunderbolt 4', 389.99, 'mpg-z790.jpg', '2025-05-20 20:57:55'),
(12, 'Samsung 980 Pro 1 TB', 'Storage', 'NVMe M.2 SSD, up to 7 000 MB/s', 129.99, '980pro-1tb.jpg', '2025-05-20 20:57:55'),
(13, 'WD Black SN850X 2 TB', 'Storage', 'NVMe M.2 SSD, heatsink included', 249.99, 'sn850x-2tb.jpg', '2025-05-20 20:57:55'),
(14, 'Noctua NH-D15', 'Cooler', 'Dual-tower air cooler, 140 mm fans', 99.95, 'nhd15.jpg', '2025-05-20 20:57:55'),
(15, 'Corsair iCUE H150i Elite Capellix', 'Cooler', '360 mm AIO liquid cooler, ARGB', 199.99, 'h150i.jpg', '2025-05-20 20:57:55');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `created_at`) VALUES
(1, 'Joseph', '$2y$10$L0Se17jd/UhNRaGbcltXh.V5iYT10vDym2z6Wt652wIP3nCu9VIHy', '2025-05-20 20:52:36');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cart_id` (`cart_id`),
  ADD KEY `part_id` (`part_id`);

--
-- Indexes for table `parts`
--
ALTER TABLE `parts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `carts`
--
ALTER TABLE `carts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `cart_items`
--
ALTER TABLE `cart_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `parts`
--
ALTER TABLE `parts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `carts`
--
ALTER TABLE `carts`
  ADD CONSTRAINT `carts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD CONSTRAINT `cart_items_ibfk_1` FOREIGN KEY (`cart_id`) REFERENCES `carts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cart_items_ibfk_2` FOREIGN KEY (`part_id`) REFERENCES `parts` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
