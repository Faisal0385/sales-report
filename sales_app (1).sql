-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 22, 2025 at 08:08 PM
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
-- Database: `sales_app`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('laravel-cache-admin@gmail.com|127.0.0.1', 'i:2;', 1763218484),
('laravel-cache-admin@gmail.com|127.0.0.1:timer', 'i:1763218484;', 1763218484);

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(41, '0001_01_01_000000_create_users_table', 1),
(42, '0001_01_01_000001_create_cache_table', 1),
(43, '0001_01_01_000002_create_jobs_table', 1),
(44, '2025_09_17_061343_create_sales_table', 1),
(45, '2025_09_18_043855_create_purchases_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `purchases`
--

CREATE TABLE `purchases` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_name` varchar(255) NOT NULL,
  `phone_number` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `customer_address` text DEFAULT NULL,
  `purchase_date` date NOT NULL,
  `product_details` text NOT NULL,
  `imei_number` varchar(255) NOT NULL,
  `customer_id_proof` varchar(255) DEFAULT NULL,
  `captured_photo` varchar(255) DEFAULT NULL,
  `payment_method` enum('cash','card','bank_transfer','other') NOT NULL,
  `purchase_amount` decimal(10,2) NOT NULL,
  `category` varchar(255) NOT NULL,
  `sub_category` varchar(255) NOT NULL,
  `bank_transfer_name` varchar(255) DEFAULT NULL,
  `bank_transfer_account` varchar(255) DEFAULT NULL,
  `bank_transfer_sort_code` varchar(255) DEFAULT NULL,
  `day` varchar(255) DEFAULT NULL,
  `month` varchar(255) DEFAULT NULL,
  `year` varchar(255) DEFAULT NULL,
  `company` varchar(255) DEFAULT NULL,
  `branch` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `purchases`
--

INSERT INTO `purchases` (`id`, `customer_name`, `phone_number`, `email`, `customer_address`, `purchase_date`, `product_details`, `imei_number`, `customer_id_proof`, `captured_photo`, `payment_method`, `purchase_amount`, `category`, `sub_category`, `bank_transfer_name`, `bank_transfer_account`, `bank_transfer_sort_code`, `day`, `month`, `year`, `company`, `branch`, `created_at`, `updated_at`) VALUES
(1, 'Jasmine Akther', '01516173275', 'faisaltez@gmail.com', 'qwe', '2025-11-02', 'qwe', 'eqwe', NULL, NULL, 'cash', 100.00, 'Mobile Phones', 'iPhone', NULL, NULL, NULL, '02', '11', '2025', 'techpoint', NULL, '2025-11-01 23:39:20', '2025-11-01 23:39:20'),
(2, 'Jasmine Akther', '01516173275', 'faisaltez@gmail.com', 'sfd', '2025-10-02', 'qwe', 'eree', NULL, NULL, 'cash', 1000.00, 'Mobile Phones', 'iPhone', NULL, NULL, NULL, '02', '10', '2025', 'techpoint', NULL, '2025-11-01 23:39:39', '2025-11-01 23:39:39'),
(3, 'Jasmine Akther', '01516173275', 'faisaltez@gmail.com', '33', '2025-11-02', '3we', '33', NULL, NULL, 'cash', 330.00, 'Mobile Phones', 'iPhone', NULL, NULL, NULL, '02', '11', '2025', 'techpoint', NULL, '2025-11-01 23:46:48', '2025-11-01 23:46:48'),
(4, 'Jasmine Akther', '01516173275', 'faisaltez@gmail.com', '22', '2024-11-02', '22', '22', NULL, NULL, 'cash', 202020.00, 'Mobile Phones', 'iPhone', NULL, NULL, NULL, '02', '11', '2024', 'techpoint', NULL, '2025-11-01 23:52:50', '2025-11-01 23:52:50'),
(5, 'Jasmine Akther', '01516173275', 'faisaltez@gmail.com', 'chawkbazar', '2025-11-15', 'product', '355680650843162', NULL, NULL, 'cash', 200.00, 'Mobile Phones', 'iPhone', NULL, NULL, NULL, '15', '11', '2025', 'restaurant', NULL, '2025-11-15 09:03:08', '2025-11-15 09:03:08'),
(6, 'Faisal Salam', '0172765653', 'faisaltez@gmail.com', 'er', '2025-11-15', 're', 'IMEI No. 06', NULL, NULL, 'cash', 100.00, 'Tablets', 'iPad', NULL, NULL, NULL, '15', '11', '2025', 'restaurant', NULL, '2025-11-15 09:03:26', '2025-11-15 09:03:26');

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sales_date` varchar(255) NOT NULL,
  `day` varchar(255) DEFAULT NULL,
  `month` varchar(255) DEFAULT NULL,
  `year` varchar(255) DEFAULT NULL,
  `cash_sales` decimal(10,2) NOT NULL DEFAULT 0.00,
  `techpoint_sales` decimal(10,2) NOT NULL DEFAULT 0.00,
  `tiktech_sales` decimal(10,2) NOT NULL DEFAULT 0.00,
  `card_sales` decimal(10,2) NOT NULL DEFAULT 0.00,
  `print_express_sales` decimal(10,2) NOT NULL DEFAULT 0.00,
  `daily_total` decimal(10,2) NOT NULL DEFAULT 0.00,
  `company` varchar(255) DEFAULT NULL,
  `branch` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`id`, `sales_date`, `day`, `month`, `year`, `cash_sales`, `techpoint_sales`, `tiktech_sales`, `card_sales`, `print_express_sales`, `daily_total`, `company`, `branch`, `created_at`, `updated_at`) VALUES
(1, '2024-11-02', '02', '11', '2024', 10.00, 10.00, 0.00, 0.00, 0.00, 20.00, 'techpoint', NULL, '2025-11-01 22:46:13', '2025-11-01 22:46:13'),
(2, '2024-11-02', '02', '11', '2024', 10.00, 0.00, 0.00, 0.00, 0.00, 10.00, 'restaurant', NULL, '2025-11-01 22:51:50', '2025-11-01 22:51:50'),
(3, '2025-11-02', '02', '11', '2025', 0.00, 0.00, 0.00, 30.00, 0.00, 30.00, 'restaurant', NULL, '2025-11-01 22:54:00', '2025-11-01 22:54:00'),
(4, '2025-11-02', '02', '11', '2025', 130.00, 0.00, 0.00, 130.00, 0.00, 260.00, 'restaurant', NULL, '2025-11-01 22:54:10', '2025-11-01 22:54:10'),
(5, '2025-11-02', '02', '11', '2025', 10.00, 20.00, 0.00, 0.00, 0.00, 30.00, 'techpoint', NULL, '2025-11-01 23:12:50', '2025-11-01 23:12:50'),
(6, '2024-10-02', '02', '10', '2024', 10.00, 20.00, 0.00, 0.00, 0.00, 30.00, 'techpoint', NULL, '2025-11-01 23:12:50', '2025-11-01 23:12:50'),
(7, '2025-01-02', '02', '01', '2025', 0.00, 100.00, 0.00, 0.00, 0.00, 100.00, 'techpoint', NULL, '2025-11-01 23:27:11', '2025-11-01 23:27:11'),
(8, '2025-11-15', '15', '11', '2025', 100.00, 0.00, 0.00, 0.00, 0.00, 100.00, 'restaurant', NULL, '2025-11-15 09:00:10', '2025-11-15 09:00:10'),
(9, '2025-11-15', '15', '11', '2025', 10.00, 0.00, 0.00, 0.00, 0.00, 10.00, 'restaurant', NULL, '2025-11-15 09:00:14', '2025-11-15 09:00:14'),
(10, '2025-11-15', '15', '11', '2025', 10.00, 0.00, 0.00, 0.00, 0.00, 10.00, 'restaurant', NULL, '2025-11-15 09:00:18', '2025-11-15 09:00:18'),
(11, '2025-11-15', '15', '11', '2025', 10.00, 0.00, 0.00, 0.00, 0.00, 10.00, 'restaurant', NULL, '2025-11-15 09:00:21', '2025-11-15 09:00:21'),
(12, '2025-11-15', '15', '11', '2025', 0.00, 0.00, 0.00, 10.00, 0.00, 10.00, 'restaurant', NULL, '2025-11-15 09:00:23', '2025-11-15 09:00:23'),
(13, '2025-11-15', '15', '11', '2025', 10.00, 0.00, 0.00, 0.00, 0.00, 10.00, 'restaurant', NULL, '2025-11-15 09:00:26', '2025-11-15 09:00:26'),
(14, '2025-11-15', '15', '11', '2025', 0.00, 0.00, 0.00, 10.00, 0.00, 10.00, 'restaurant', NULL, '2025-11-15 09:00:29', '2025-11-15 09:00:29'),
(15, '2025-11-15', '15', '11', '2025', 0.00, 0.00, 0.00, 10.00, 0.00, 10.00, 'restaurant', NULL, '2025-11-15 09:00:33', '2025-11-15 09:00:33'),
(16, '2025-11-15', '15', '11', '2025', 0.00, 0.00, 0.00, 10.00, 0.00, 10.00, 'restaurant', NULL, '2025-11-15 09:00:37', '2025-11-15 09:00:37'),
(17, '2025-11-15', '15', '11', '2025', 10.00, 0.00, 0.00, 0.00, 0.00, 10.00, 'restaurant', NULL, '2025-11-15 09:00:42', '2025-11-15 09:00:42'),
(18, '2025-11-15', '15', '11', '2025', 10.00, 0.00, 0.00, 0.00, 0.00, 10.00, 'restaurant', NULL, '2025-11-15 09:00:45', '2025-11-15 09:00:45');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('VZEWJrmO4OJA7PYVwXcnMT4Womv6datRjvokkP5N', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiakl4dVJLRTd5bEVzRk5MTTVKVnBwbWZhWmtKa2FTR1VaTk9aZVlWRiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fX0=', 1763223824);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `role` varchar(255) DEFAULT NULL,
  `company` varchar(255) DEFAULT NULL,
  `branch` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `phone`, `address`, `role`, `company`, `branch`, `status`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Techpoint User', 'admin@techpoint.com', '2025-10-31 04:12:27', '$2y$12$OZVeoXiUsWuL5kwil2HBl.VWDigd7rPXK8rgNESTKIhetiXrQ4TVK', NULL, 'UK', 'branch manger', 'techpoint', NULL, 1, NULL, '2025-10-31 04:12:27', '2025-10-31 04:40:30'),
(2, 'Restaurant User', 'admin@restaurant.com', '2025-10-31 04:12:27', '$2y$12$wNqYlg48DmVnS5VUQcXbyOp7sGmgLGejq6QGod67LDDRbPjbFQqYW', NULL, 'UK', 'branch manger', 'restaurant', NULL, 1, NULL, '2025-10-31 04:12:27', '2025-10-31 04:39:58'),
(3, 'Hornchurch User', 'hc@tiktech.com', '2025-10-31 04:12:28', '$2y$12$QcMZjg5L4URjvVETWEvp7uJxC5umaB612innVMvho7SlooK1KGvqW', NULL, 'UK', NULL, 'tiktech', 'hornchurch', 1, NULL, '2025-10-31 04:12:28', '2025-10-31 04:12:28'),
(4, 'Upminister User', 'up@tiktech.com', '2025-10-31 04:12:28', '$2y$12$SyuXAVxXq0WnKDxoI42RuOIbYuBBmhEPwlw8pYJh./FVAIAwlLqpu', NULL, 'UK', NULL, 'tiktech', 'upminister', 1, NULL, '2025-10-31 04:12:28', '2025-10-31 04:12:28'),
(5, 'Billericay User', 'br@tiktech.com', '2025-10-31 04:12:28', '$2y$12$DUe5GhUNeVlMqkwE/lda3eolAzXe85iG7KfCaQxsMsI9wajyS.5Oi', NULL, 'UK', NULL, 'tiktech', 'billericay', 1, NULL, '2025-10-31 04:12:28', '2025-10-31 04:12:28'),
(6, 'Admin User', 'super@gmail.com', '2025-10-31 04:12:28', '$2y$12$oLyHSp943XsPiQcdc8IcR.mp1wIRNkSrQfW7cPJ2AalA2PO7V3qL.', NULL, 'UK', 'superadmin', 'techPoint', NULL, 1, NULL, '2025-10-31 04:12:28', '2025-10-31 04:12:28');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `purchases`
--
ALTER TABLE `purchases`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `purchases_imei_number_unique` (`imei_number`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `purchases`
--
ALTER TABLE `purchases`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
