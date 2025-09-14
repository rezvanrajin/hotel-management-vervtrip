-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 14, 2025 at 10:27 AM
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
-- Database: `hotel_management_vervtrip`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `room_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `guest_first_name` varchar(191) DEFAULT NULL,
  `guest_last_name` varchar(191) DEFAULT NULL,
  `guest_email` varchar(191) DEFAULT NULL,
  `guest_phone` varchar(191) DEFAULT NULL,
  `guest_address` text DEFAULT NULL,
  `guest_country` varchar(191) DEFAULT NULL,
  `guest_city` varchar(191) DEFAULT NULL,
  `guest_zip_code` varchar(191) DEFAULT NULL,
  `check_in_date` date NOT NULL,
  `check_out_date` date NOT NULL,
  `number_of_nights` int(11) NOT NULL,
  `number_of_guests` int(11) NOT NULL,
  `number_of_rooms` int(11) NOT NULL DEFAULT 1,
  `room_price_per_night` decimal(10,2) NOT NULL,
  `sub_total` decimal(10,2) NOT NULL,
  `tax_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `discount_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `total_amount` decimal(10,2) NOT NULL,
  `currency` varchar(3) NOT NULL DEFAULT 'USD',
  `special_requests` text DEFAULT NULL,
  `status` enum('pending','confirmed','checked_in','checked_out','cancelled','no_show','refunded') NOT NULL DEFAULT 'pending',
  `payment_status` enum('pending','paid','failed','refunded') NOT NULL DEFAULT 'pending',
  `payment_method` varchar(191) DEFAULT NULL,
  `transaction_id` varchar(191) DEFAULT NULL,
  `payment_date` timestamp NULL DEFAULT NULL,
  `cancelled_at` timestamp NULL DEFAULT NULL,
  `cancellation_reason` text DEFAULT NULL,
  `checked_in_at` timestamp NULL DEFAULT NULL,
  `checked_out_at` timestamp NULL DEFAULT NULL,
  `admin_notes` text DEFAULT NULL,
  `booking_source` enum('website','walk_in','phone','email','travel_agent','booking_platform') NOT NULL DEFAULT 'website',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `room_id`, `user_id`, `guest_first_name`, `guest_last_name`, `guest_email`, `guest_phone`, `guest_address`, `guest_country`, `guest_city`, `guest_zip_code`, `check_in_date`, `check_out_date`, `number_of_nights`, `number_of_guests`, `number_of_rooms`, `room_price_per_night`, `sub_total`, `tax_amount`, `discount_amount`, `total_amount`, `currency`, `special_requests`, `status`, `payment_status`, `payment_method`, `transaction_id`, `payment_date`, `cancelled_at`, `cancellation_reason`, `checked_in_at`, `checked_out_at`, `admin_notes`, `booking_source`, `created_at`, `updated_at`) VALUES
(1, 4, 5417, 'dsad', 'dsa', 'admin@gmail.com', '232', NULL, NULL, NULL, NULL, '2025-09-15', '2025-09-17', 2, 1, 2, 323.00, 1292.00, 129.20, 0.00, 1421.20, 'USD', 'ddad', 'confirmed', 'paid', 'credit_card', 'SIM17577980942898', '2025-09-13 15:14:54', NULL, NULL, NULL, NULL, NULL, 'website', '2025-09-13 15:14:38', '2025-09-13 15:14:54'),
(2, 5, 5417, 'fsd', 'fdsfd', 'admin@gmail.com', '32322', NULL, NULL, NULL, NULL, '2025-09-16', '2025-09-20', 4, 1, 1, 33.00, 132.00, 13.20, 0.00, 145.20, 'USD', 'sdsa', 'confirmed', 'paid', 'paypal', 'SIM17577982945885', '2025-09-13 15:18:14', NULL, NULL, NULL, NULL, NULL, 'website', '2025-09-13 15:18:12', '2025-09-13 15:18:14'),
(3, 3, 5417, 'dsad ds', 'dsa dsa', 'admin@gmail.com', '32132', NULL, NULL, NULL, NULL, '2025-09-14', '2025-09-16', 2, 1, 1, 34.00, 68.00, 6.80, 0.00, 74.80, 'USD', 'dsad', 'confirmed', 'paid', 'bank_transfer', 'SIM17577984668324', '2025-09-13 15:21:06', NULL, NULL, NULL, NULL, NULL, 'website', '2025-09-13 15:21:05', '2025-09-13 15:21:06'),
(4, 3, 5417, 'sad', 'dsad11', 'admin@gmail.com', NULL, NULL, NULL, NULL, NULL, '2025-09-16', '2025-09-27', 11, 3, 2, 34.00, 748.00, 74.80, 0.00, 822.80, 'USD', 'dsaddas', 'confirmed', 'paid', 'paypal', 'SIM17578253316105', '2025-09-13 22:48:51', NULL, NULL, NULL, NULL, NULL, 'website', '2025-09-13 22:48:12', '2025-09-14 00:58:09');

-- --------------------------------------------------------

--
-- Table structure for table `booking_payments`
--

CREATE TABLE `booking_payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `booking_id` bigint(20) UNSIGNED NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `payment_method` varchar(191) NOT NULL,
  `transaction_id` varchar(191) DEFAULT NULL,
  `status` enum('pending','completed','failed','refunded') NOT NULL,
  `payment_details` text DEFAULT NULL,
  `payment_date` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_09_12_144314_create_rooms_table', 2),
(5, '2025_09_12_173735_create_bookings_table', 3),
(6, '2025_09_12_174634_create_booking_payments_table', 3);

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
-- Table structure for table `right`
--

CREATE TABLE `right` (
  `id` int(11) NOT NULL,
  `name` varchar(256) NOT NULL,
  `module` varchar(256) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `right`
--

INSERT INTO `right` (`id`, `name`, `module`, `created_at`, `updated_at`) VALUES
(1, 'role.view', 'role', '2023-05-09 16:11:19', '2023-05-09 16:17:58'),
(2, 'role.create', 'role', '2023-05-09 16:11:44', '2023-05-09 16:17:58'),
(3, 'role.edit', 'role', '2023-05-09 16:11:44', '2023-05-09 16:17:58'),
(4, 'role.delete', 'role', '2023-05-09 16:11:44', '2023-05-09 16:17:58'),
(5, 'user.view', 'user', '2023-05-09 16:12:49', '2023-05-09 16:18:12'),
(6, 'user.create', 'user', '2023-05-09 16:12:49', '2023-05-09 16:18:12'),
(7, 'user.edit', 'user', '2023-05-09 16:12:49', '2023-05-09 16:18:12'),
(8, 'user.delete', 'user', '2023-05-09 16:12:49', '2023-05-09 16:18:12'),
(9, 'dashboard.view', 'dashboard', '2023-05-09 16:13:06', '2023-05-09 16:18:25'),
(10, 'dashboard.create', 'dashboard', '2023-05-09 16:13:06', '2023-05-09 16:18:25'),
(11, 'dashboard.edit', 'dashboard', '2023-05-09 16:13:06', '2023-05-09 16:18:25'),
(12, 'dashboard.delete', 'dashboard', '2023-05-09 16:13:06', '2023-05-09 16:18:25'),
(23, 'right.view', 'right', '2023-05-16 00:21:07', '2023-05-16 00:21:07'),
(24, 'right.create', 'right', '2023-05-16 00:21:20', '2023-05-16 00:21:20'),
(25, 'right.edit', 'right', '2023-05-16 00:21:28', '2023-05-16 00:21:28'),
(26, 'right.delete', 'right', '2023-05-16 00:21:36', '2023-05-16 00:21:36'),
(35, 'setting.view', 'setting', '2023-05-21 17:31:21', '2023-05-21 17:31:21'),
(37, 'setting.edit', 'setting', '2023-05-21 17:32:15', '2023-05-21 17:32:15'),
(38, 'setting.general', 'setting', '2023-05-21 17:32:50', '2023-05-21 17:32:50'),
(39, 'setting.static-content', 'setting', '2023-05-21 17:51:51', '2023-05-21 17:51:51'),
(76, 'setting.legal-content', 'setting', '2023-07-02 19:10:19', '2023-07-02 19:10:19'),
(93, 'hotel.view', 'hotel', '2025-09-12 01:10:27', '2025-09-12 01:14:16'),
(94, 'management & hotel.view', 'management & hotel', '2025-09-14 01:02:53', '2025-09-14 01:02:53'),
(95, 'admin.view', 'admin', '2025-09-14 01:12:30', '2025-09-14 01:12:30'),
(96, 'booking.view', 'booking', '2025-09-14 01:13:57', '2025-09-14 01:13:57');

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `id` int(11) NOT NULL,
  `name` varchar(256) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Admin', '2025-09-14 01:04:19', '2025-09-14 01:04:19'),
(2, 'User', '2025-09-12 01:22:27', '2025-09-12 01:22:27'),
(3, 'Gust', '2025-09-12 01:22:46', '2025-09-12 01:22:46');

-- --------------------------------------------------------

--
-- Table structure for table `role_right`
--

CREATE TABLE `role_right` (
  `id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `right_id` int(11) NOT NULL,
  `permission` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `role_right`
--

INSERT INTO `role_right` (`id`, `role_id`, `right_id`, `permission`, `created_at`, `updated_at`) VALUES
(90, 2, 1, 0, '2025-09-12 01:22:27', '2025-09-12 01:22:27'),
(91, 2, 2, 0, '2025-09-12 01:22:27', '2025-09-12 01:22:27'),
(92, 2, 3, 0, '2025-09-12 01:22:27', '2025-09-12 01:22:27'),
(93, 2, 4, 0, '2025-09-12 01:22:27', '2025-09-12 01:22:27'),
(94, 2, 5, 0, '2025-09-12 01:22:27', '2025-09-12 01:22:27'),
(95, 2, 6, 0, '2025-09-12 01:22:27', '2025-09-12 01:22:27'),
(96, 2, 7, 0, '2025-09-12 01:22:27', '2025-09-12 01:22:27'),
(97, 2, 8, 0, '2025-09-12 01:22:27', '2025-09-12 01:22:27'),
(98, 2, 9, 1, '2025-09-12 01:22:27', '2025-09-14 01:20:12'),
(99, 2, 10, 0, '2025-09-12 01:22:27', '2025-09-12 01:22:27'),
(100, 2, 11, 0, '2025-09-12 01:22:27', '2025-09-12 01:22:27'),
(101, 2, 12, 0, '2025-09-12 01:22:27', '2025-09-12 01:22:27'),
(102, 2, 13, 0, '2025-09-12 01:22:27', '2025-09-12 01:22:27'),
(103, 2, 14, 0, '2025-09-12 01:22:27', '2025-09-12 01:22:27'),
(104, 2, 15, 0, '2025-09-12 01:22:27', '2025-09-12 01:22:27'),
(105, 2, 16, 0, '2025-09-12 01:22:27', '2025-09-12 01:22:27'),
(106, 2, 17, 0, '2025-09-12 01:22:27', '2025-09-12 01:22:27'),
(107, 2, 18, 0, '2025-09-12 01:22:27', '2025-09-12 01:22:27'),
(108, 2, 19, 0, '2025-09-12 01:22:27', '2025-09-12 01:22:27'),
(109, 2, 20, 0, '2025-09-12 01:22:27', '2025-09-12 01:22:27'),
(110, 2, 23, 0, '2025-09-12 01:22:27', '2025-09-12 01:22:27'),
(111, 2, 24, 0, '2025-09-12 01:22:27', '2025-09-12 01:22:27'),
(112, 2, 25, 0, '2025-09-12 01:22:27', '2025-09-12 01:22:27'),
(113, 2, 26, 0, '2025-09-12 01:22:27', '2025-09-12 01:22:27'),
(114, 2, 27, 0, '2025-09-12 01:22:27', '2025-09-12 01:22:27'),
(115, 2, 28, 0, '2025-09-12 01:22:27', '2025-09-12 01:22:27'),
(116, 2, 29, 0, '2025-09-12 01:22:27', '2025-09-12 01:22:27'),
(117, 2, 30, 0, '2025-09-12 01:22:27', '2025-09-12 01:22:27'),
(118, 2, 31, 0, '2025-09-12 01:22:27', '2025-09-12 01:22:27'),
(119, 2, 32, 0, '2025-09-12 01:22:27', '2025-09-12 01:22:27'),
(120, 2, 33, 0, '2025-09-12 01:22:27', '2025-09-12 01:22:27'),
(121, 2, 34, 0, '2025-09-12 01:22:27', '2025-09-12 01:22:27'),
(122, 2, 35, 0, '2025-09-12 01:22:27', '2025-09-12 01:22:27'),
(123, 2, 37, 0, '2025-09-12 01:22:27', '2025-09-12 01:22:27'),
(124, 2, 38, 0, '2025-09-12 01:22:27', '2025-09-12 01:22:27'),
(125, 2, 39, 0, '2025-09-12 01:22:27', '2025-09-12 01:22:27'),
(126, 2, 40, 0, '2025-09-12 01:22:27', '2025-09-12 01:22:27'),
(127, 2, 41, 0, '2025-09-12 01:22:27', '2025-09-12 01:22:27'),
(128, 2, 42, 0, '2025-09-12 01:22:27', '2025-09-12 01:22:27'),
(129, 2, 43, 0, '2025-09-12 01:22:27', '2025-09-12 01:22:27'),
(130, 2, 44, 0, '2025-09-12 01:22:27', '2025-09-12 01:22:27'),
(131, 2, 45, 0, '2025-09-12 01:22:27', '2025-09-12 01:22:27'),
(132, 2, 46, 0, '2025-09-12 01:22:27', '2025-09-12 01:22:27'),
(133, 2, 47, 0, '2025-09-12 01:22:27', '2025-09-12 01:22:27'),
(134, 2, 48, 0, '2025-09-12 01:22:27', '2025-09-12 01:22:27'),
(135, 2, 49, 0, '2025-09-12 01:22:27', '2025-09-12 01:22:27'),
(136, 2, 50, 0, '2025-09-12 01:22:27', '2025-09-12 01:22:27'),
(137, 2, 51, 0, '2025-09-12 01:22:27', '2025-09-12 01:22:27'),
(138, 2, 52, 0, '2025-09-12 01:22:27', '2025-09-12 01:22:27'),
(139, 2, 53, 0, '2025-09-12 01:22:27', '2025-09-12 01:22:27'),
(140, 2, 54, 0, '2025-09-12 01:22:27', '2025-09-12 01:22:27'),
(141, 2, 55, 0, '2025-09-12 01:22:27', '2025-09-12 01:22:27'),
(142, 2, 56, 0, '2025-09-12 01:22:27', '2025-09-12 01:22:27'),
(143, 2, 57, 0, '2025-09-12 01:22:27', '2025-09-12 01:22:27'),
(144, 2, 58, 0, '2025-09-12 01:22:27', '2025-09-12 01:22:27'),
(145, 2, 59, 0, '2025-09-12 01:22:27', '2025-09-12 01:22:27'),
(146, 2, 60, 0, '2025-09-12 01:22:27', '2025-09-12 01:22:27'),
(147, 2, 61, 0, '2025-09-12 01:22:27', '2025-09-12 01:22:27'),
(148, 2, 62, 0, '2025-09-12 01:22:27', '2025-09-12 01:22:27'),
(149, 2, 63, 0, '2025-09-12 01:22:27', '2025-09-12 01:22:27'),
(150, 2, 64, 0, '2025-09-12 01:22:27', '2025-09-12 01:22:27'),
(151, 2, 65, 0, '2025-09-12 01:22:27', '2025-09-12 01:22:27'),
(152, 2, 66, 0, '2025-09-12 01:22:27', '2025-09-12 01:22:27'),
(153, 2, 67, 0, '2025-09-12 01:22:27', '2025-09-12 01:22:27'),
(154, 2, 68, 0, '2025-09-12 01:22:27', '2025-09-12 01:22:27'),
(155, 2, 69, 0, '2025-09-12 01:22:27', '2025-09-12 01:22:27'),
(156, 2, 70, 0, '2025-09-12 01:22:27', '2025-09-12 01:22:27'),
(157, 2, 71, 0, '2025-09-12 01:22:27', '2025-09-12 01:22:27'),
(158, 2, 72, 0, '2025-09-12 01:22:27', '2025-09-12 01:22:27'),
(159, 2, 73, 0, '2025-09-12 01:22:27', '2025-09-12 01:22:27'),
(160, 2, 74, 0, '2025-09-12 01:22:27', '2025-09-12 01:22:27'),
(161, 2, 75, 0, '2025-09-12 01:22:27', '2025-09-12 01:22:27'),
(162, 2, 76, 0, '2025-09-12 01:22:27', '2025-09-12 01:22:27'),
(163, 2, 78, 0, '2025-09-12 01:22:27', '2025-09-12 01:22:27'),
(164, 2, 79, 0, '2025-09-12 01:22:27', '2025-09-12 01:22:27'),
(165, 2, 80, 0, '2025-09-12 01:22:27', '2025-09-12 01:22:27'),
(166, 2, 81, 0, '2025-09-12 01:22:27', '2025-09-12 01:22:27'),
(167, 2, 82, 0, '2025-09-12 01:22:27', '2025-09-12 01:22:27'),
(168, 2, 83, 0, '2025-09-12 01:22:27', '2025-09-12 01:22:27'),
(169, 2, 84, 0, '2025-09-12 01:22:27', '2025-09-12 01:22:27'),
(170, 2, 85, 0, '2025-09-12 01:22:27', '2025-09-12 01:22:27'),
(171, 2, 86, 0, '2025-09-12 01:22:27', '2025-09-12 01:22:27'),
(172, 2, 87, 0, '2025-09-12 01:22:27', '2025-09-12 01:22:27'),
(173, 2, 88, 0, '2025-09-12 01:22:27', '2025-09-12 01:22:27'),
(174, 2, 89, 0, '2025-09-12 01:22:27', '2025-09-12 01:22:27'),
(175, 2, 90, 0, '2025-09-12 01:22:27', '2025-09-12 01:22:27'),
(176, 2, 91, 0, '2025-09-12 01:22:27', '2025-09-12 01:22:27'),
(177, 2, 92, 0, '2025-09-12 01:22:27', '2025-09-12 01:22:27'),
(178, 2, 93, 0, '2025-09-12 01:22:27', '2025-09-14 01:14:05'),
(179, 3, 1, 0, '2025-09-12 01:22:46', '2025-09-12 01:22:46'),
(180, 3, 2, 0, '2025-09-12 01:22:46', '2025-09-12 01:22:46'),
(181, 3, 3, 0, '2025-09-12 01:22:46', '2025-09-12 01:22:46'),
(182, 3, 4, 0, '2025-09-12 01:22:46', '2025-09-12 01:22:46'),
(183, 3, 5, 0, '2025-09-12 01:22:46', '2025-09-12 01:22:46'),
(184, 3, 6, 0, '2025-09-12 01:22:46', '2025-09-12 01:22:46'),
(185, 3, 7, 0, '2025-09-12 01:22:46', '2025-09-12 01:22:46'),
(186, 3, 8, 0, '2025-09-12 01:22:46', '2025-09-12 01:22:46'),
(187, 3, 9, 0, '2025-09-12 01:22:46', '2025-09-12 01:22:46'),
(188, 3, 10, 0, '2025-09-12 01:22:46', '2025-09-12 01:22:46'),
(189, 3, 11, 0, '2025-09-12 01:22:46', '2025-09-12 01:22:46'),
(190, 3, 12, 0, '2025-09-12 01:22:46', '2025-09-12 01:22:46'),
(191, 3, 13, 0, '2025-09-12 01:22:46', '2025-09-12 01:22:46'),
(192, 3, 14, 0, '2025-09-12 01:22:46', '2025-09-12 01:22:46'),
(193, 3, 15, 0, '2025-09-12 01:22:46', '2025-09-12 01:22:46'),
(194, 3, 16, 0, '2025-09-12 01:22:46', '2025-09-12 01:22:46'),
(195, 3, 17, 0, '2025-09-12 01:22:46', '2025-09-12 01:22:46'),
(196, 3, 18, 0, '2025-09-12 01:22:46', '2025-09-12 01:22:46'),
(197, 3, 19, 0, '2025-09-12 01:22:46', '2025-09-12 01:22:46'),
(198, 3, 20, 0, '2025-09-12 01:22:46', '2025-09-12 01:22:46'),
(199, 3, 23, 0, '2025-09-12 01:22:46', '2025-09-12 01:22:46'),
(200, 3, 24, 0, '2025-09-12 01:22:46', '2025-09-12 01:22:46'),
(201, 3, 25, 0, '2025-09-12 01:22:46', '2025-09-12 01:22:46'),
(202, 3, 26, 0, '2025-09-12 01:22:46', '2025-09-12 01:22:46'),
(203, 3, 27, 0, '2025-09-12 01:22:46', '2025-09-12 01:22:46'),
(204, 3, 28, 0, '2025-09-12 01:22:46', '2025-09-12 01:22:46'),
(205, 3, 29, 0, '2025-09-12 01:22:46', '2025-09-12 01:22:46'),
(206, 3, 30, 0, '2025-09-12 01:22:46', '2025-09-12 01:22:46'),
(207, 3, 31, 0, '2025-09-12 01:22:46', '2025-09-12 01:22:46'),
(208, 3, 32, 0, '2025-09-12 01:22:46', '2025-09-12 01:22:46'),
(209, 3, 33, 0, '2025-09-12 01:22:46', '2025-09-12 01:22:46'),
(210, 3, 34, 0, '2025-09-12 01:22:46', '2025-09-12 01:22:46'),
(211, 3, 35, 0, '2025-09-12 01:22:46', '2025-09-12 01:22:46'),
(212, 3, 37, 0, '2025-09-12 01:22:46', '2025-09-12 01:22:46'),
(213, 3, 38, 0, '2025-09-12 01:22:46', '2025-09-12 01:22:46'),
(214, 3, 39, 0, '2025-09-12 01:22:46', '2025-09-12 01:22:46'),
(215, 3, 40, 0, '2025-09-12 01:22:46', '2025-09-12 01:22:46'),
(216, 3, 41, 0, '2025-09-12 01:22:46', '2025-09-12 01:22:46'),
(217, 3, 42, 0, '2025-09-12 01:22:46', '2025-09-12 01:22:46'),
(218, 3, 43, 0, '2025-09-12 01:22:46', '2025-09-12 01:22:46'),
(219, 3, 44, 0, '2025-09-12 01:22:46', '2025-09-12 01:22:46'),
(220, 3, 45, 0, '2025-09-12 01:22:46', '2025-09-12 01:22:46'),
(221, 3, 46, 0, '2025-09-12 01:22:46', '2025-09-12 01:22:46'),
(222, 3, 47, 0, '2025-09-12 01:22:46', '2025-09-12 01:22:46'),
(223, 3, 48, 0, '2025-09-12 01:22:46', '2025-09-12 01:22:46'),
(224, 3, 49, 0, '2025-09-12 01:22:46', '2025-09-12 01:22:46'),
(225, 3, 50, 0, '2025-09-12 01:22:46', '2025-09-12 01:22:46'),
(226, 3, 51, 0, '2025-09-12 01:22:46', '2025-09-12 01:22:46'),
(227, 3, 52, 0, '2025-09-12 01:22:46', '2025-09-12 01:22:46'),
(228, 3, 53, 0, '2025-09-12 01:22:46', '2025-09-12 01:22:46'),
(229, 3, 54, 0, '2025-09-12 01:22:46', '2025-09-12 01:22:46'),
(230, 3, 55, 0, '2025-09-12 01:22:46', '2025-09-12 01:22:46'),
(231, 3, 56, 0, '2025-09-12 01:22:46', '2025-09-12 01:22:46'),
(232, 3, 57, 0, '2025-09-12 01:22:46', '2025-09-12 01:22:46'),
(233, 3, 58, 0, '2025-09-12 01:22:46', '2025-09-12 01:22:46'),
(234, 3, 59, 0, '2025-09-12 01:22:46', '2025-09-12 01:22:46'),
(235, 3, 60, 0, '2025-09-12 01:22:46', '2025-09-12 01:22:46'),
(236, 3, 61, 0, '2025-09-12 01:22:46', '2025-09-12 01:22:46'),
(237, 3, 62, 0, '2025-09-12 01:22:46', '2025-09-12 01:22:46'),
(238, 3, 63, 0, '2025-09-12 01:22:46', '2025-09-12 01:22:46'),
(239, 3, 64, 0, '2025-09-12 01:22:46', '2025-09-12 01:22:46'),
(240, 3, 65, 0, '2025-09-12 01:22:46', '2025-09-12 01:22:46'),
(241, 3, 66, 0, '2025-09-12 01:22:46', '2025-09-12 01:22:46'),
(242, 3, 67, 0, '2025-09-12 01:22:46', '2025-09-12 01:22:46'),
(243, 3, 68, 0, '2025-09-12 01:22:46', '2025-09-12 01:22:46'),
(244, 3, 69, 0, '2025-09-12 01:22:46', '2025-09-12 01:22:46'),
(245, 3, 70, 0, '2025-09-12 01:22:46', '2025-09-12 01:22:46'),
(246, 3, 71, 0, '2025-09-12 01:22:46', '2025-09-12 01:22:46'),
(247, 3, 72, 0, '2025-09-12 01:22:46', '2025-09-12 01:22:46'),
(248, 3, 73, 0, '2025-09-12 01:22:46', '2025-09-12 01:22:46'),
(249, 3, 74, 0, '2025-09-12 01:22:46', '2025-09-12 01:22:46'),
(250, 3, 75, 0, '2025-09-12 01:22:46', '2025-09-12 01:22:46'),
(251, 3, 76, 0, '2025-09-12 01:22:46', '2025-09-12 01:22:46'),
(252, 3, 78, 0, '2025-09-12 01:22:46', '2025-09-12 01:22:46'),
(253, 3, 79, 0, '2025-09-12 01:22:46', '2025-09-12 01:22:46'),
(254, 3, 80, 0, '2025-09-12 01:22:46', '2025-09-12 01:22:46'),
(255, 3, 81, 0, '2025-09-12 01:22:46', '2025-09-12 01:22:46'),
(256, 3, 82, 0, '2025-09-12 01:22:46', '2025-09-12 01:22:46'),
(257, 3, 83, 0, '2025-09-12 01:22:46', '2025-09-12 01:22:46'),
(258, 3, 84, 0, '2025-09-12 01:22:46', '2025-09-12 01:22:46'),
(259, 3, 85, 0, '2025-09-12 01:22:46', '2025-09-12 01:22:46'),
(260, 3, 86, 0, '2025-09-12 01:22:46', '2025-09-12 01:22:46'),
(261, 3, 87, 0, '2025-09-12 01:22:46', '2025-09-12 01:22:46'),
(262, 3, 88, 0, '2025-09-12 01:22:46', '2025-09-12 01:22:46'),
(263, 3, 89, 0, '2025-09-12 01:22:46', '2025-09-12 01:22:46'),
(264, 3, 90, 0, '2025-09-12 01:22:46', '2025-09-12 01:22:46'),
(265, 3, 91, 0, '2025-09-12 01:22:46', '2025-09-12 01:22:46'),
(266, 3, 92, 0, '2025-09-12 01:22:46', '2025-09-12 01:22:46'),
(267, 3, 93, 0, '2025-09-12 01:22:46', '2025-09-12 01:22:46'),
(268, 2, 94, 1, '2025-09-14 01:03:13', '2025-09-14 01:03:13'),
(269, 4, 1, 1, '2025-09-14 01:04:19', '2025-09-14 01:04:19'),
(270, 4, 2, 1, '2025-09-14 01:04:19', '2025-09-14 01:04:19'),
(271, 4, 3, 1, '2025-09-14 01:04:19', '2025-09-14 01:04:19'),
(272, 4, 4, 1, '2025-09-14 01:04:19', '2025-09-14 01:04:19'),
(273, 4, 5, 1, '2025-09-14 01:04:19', '2025-09-14 01:04:19'),
(274, 4, 6, 1, '2025-09-14 01:04:19', '2025-09-14 01:04:19'),
(275, 4, 7, 1, '2025-09-14 01:04:19', '2025-09-14 01:04:19'),
(276, 4, 8, 1, '2025-09-14 01:04:19', '2025-09-14 01:04:19'),
(277, 4, 9, 1, '2025-09-14 01:04:19', '2025-09-14 01:04:19'),
(278, 4, 10, 1, '2025-09-14 01:04:19', '2025-09-14 01:04:19'),
(279, 4, 11, 1, '2025-09-14 01:04:19', '2025-09-14 01:04:19'),
(280, 4, 12, 1, '2025-09-14 01:04:19', '2025-09-14 01:04:19'),
(281, 4, 23, 1, '2025-09-14 01:04:19', '2025-09-14 01:04:19'),
(282, 4, 24, 1, '2025-09-14 01:04:19', '2025-09-14 01:04:19'),
(283, 4, 25, 1, '2025-09-14 01:04:19', '2025-09-14 01:04:19'),
(284, 4, 26, 1, '2025-09-14 01:04:19', '2025-09-14 01:04:19'),
(285, 4, 35, 1, '2025-09-14 01:04:19', '2025-09-14 01:04:19'),
(286, 4, 37, 1, '2025-09-14 01:04:19', '2025-09-14 01:04:19'),
(287, 4, 38, 1, '2025-09-14 01:04:19', '2025-09-14 01:04:19'),
(288, 4, 39, 1, '2025-09-14 01:04:19', '2025-09-14 01:04:19'),
(289, 4, 76, 1, '2025-09-14 01:04:19', '2025-09-14 01:04:19'),
(290, 4, 93, 1, '2025-09-14 01:04:19', '2025-09-14 01:04:19'),
(291, 4, 94, 1, '2025-09-14 01:04:19', '2025-09-14 01:04:19'),
(292, 1, 1, 1, '2025-09-14 01:12:55', '2025-09-14 01:12:55'),
(293, 1, 2, 1, '2025-09-14 01:12:55', '2025-09-14 01:12:55'),
(294, 1, 3, 1, '2025-09-14 01:12:55', '2025-09-14 01:12:55'),
(295, 1, 4, 1, '2025-09-14 01:12:55', '2025-09-14 01:12:55'),
(296, 1, 5, 1, '2025-09-14 01:12:55', '2025-09-14 01:12:55'),
(297, 1, 6, 1, '2025-09-14 01:12:55', '2025-09-14 01:12:55'),
(298, 1, 7, 1, '2025-09-14 01:12:55', '2025-09-14 01:12:55'),
(299, 1, 8, 1, '2025-09-14 01:12:55', '2025-09-14 01:12:55'),
(300, 1, 9, 1, '2025-09-14 01:12:55', '2025-09-14 01:12:55'),
(301, 1, 10, 1, '2025-09-14 01:12:55', '2025-09-14 01:12:55'),
(302, 1, 11, 1, '2025-09-14 01:12:55', '2025-09-14 01:12:55'),
(303, 1, 12, 1, '2025-09-14 01:12:55', '2025-09-14 01:12:55'),
(304, 1, 23, 1, '2025-09-14 01:12:55', '2025-09-14 01:12:55'),
(305, 1, 24, 1, '2025-09-14 01:12:55', '2025-09-14 01:12:55'),
(306, 1, 25, 1, '2025-09-14 01:12:55', '2025-09-14 01:12:55'),
(307, 1, 26, 1, '2025-09-14 01:12:55', '2025-09-14 01:12:55'),
(308, 1, 35, 1, '2025-09-14 01:12:55', '2025-09-14 01:12:55'),
(309, 1, 37, 1, '2025-09-14 01:12:55', '2025-09-14 01:12:55'),
(310, 1, 38, 1, '2025-09-14 01:12:55', '2025-09-14 01:12:55'),
(311, 1, 39, 1, '2025-09-14 01:12:55', '2025-09-14 01:12:55'),
(312, 1, 76, 1, '2025-09-14 01:12:55', '2025-09-14 01:12:55'),
(313, 1, 93, 1, '2025-09-14 01:12:55', '2025-09-14 01:12:55'),
(314, 1, 94, 1, '2025-09-14 01:12:55', '2025-09-14 01:12:55'),
(315, 1, 95, 1, '2025-09-14 01:12:55', '2025-09-14 01:12:55'),
(316, 2, 95, 0, '2025-09-14 01:14:05', '2025-09-14 01:14:05'),
(317, 2, 96, 1, '2025-09-14 01:14:05', '2025-09-14 01:14:05'),
(318, 1, 96, 1, '2025-09-14 01:14:13', '2025-09-14 01:14:13');

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `room_number` varchar(191) NOT NULL,
  `room_type` enum('single','double','twin','suite','deluxe','presidential') NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `capacity` int(11) NOT NULL,
  `size` decimal(8,2) DEFAULT NULL,
  `bed_type` enum('king','queen','double','twin','single') NOT NULL,
  `status` enum('available','occupied','maintenance','cleaning') NOT NULL,
  `amenities` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`amenities`)),
  `description` text DEFAULT NULL,
  `images` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`images`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`id`, `room_number`, `room_type`, `price`, `capacity`, `size`, `bed_type`, `status`, `amenities`, `description`, `images`, `created_at`, `updated_at`) VALUES
(3, 'fdsrf343', 'single', 34.00, 2, 343.00, 'queen', 'available', '\"[\\\"wifi\\\",\\\"tv\\\",\\\"ac\\\",\\\"minibar\\\",\\\"safe\\\",\\\"balcony\\\"]\"', '<p>fdsff</p>', '\"[\\\"uploads\\\\\\/hotel_room\\\\\\/1757835038_68c66f1e4deef.jpg\\\",\\\"uploads\\\\\\/hotel_room\\\\\\/1757835038_68c66f1e4e4f9.jpg\\\",\\\"uploads\\\\\\/hotel_room\\\\\\/1757835038_68c66f1e4e95f.jpg\\\",\\\"uploads\\\\\\/hotel_room\\\\\\/1757835038_68c66f1e4edf1.jpg\\\",\\\"uploads\\\\\\/hotel_room\\\\\\/1757835038_68c66f1e4f2da.jpg\\\",\\\"uploads\\\\\\/hotel_room\\\\\\/1757835038_68c66f1e4f776.jpg\\\",\\\"uploads\\\\\\/hotel_room\\\\\\/1757835038_68c66f1e4fc3e.jpg\\\",\\\"uploads\\\\\\/hotel_room\\\\\\/1757835038_68c66f1e5025f.jpg\\\"]\"', '2025-09-12 10:00:16', '2025-09-14 01:30:38'),
(4, '34dsfs', 'double', 323.00, 2, 232.00, 'queen', 'available', '\"[\\\"tv\\\",\\\"minibar\\\",\\\"safe\\\",\\\"balcony\\\",\\\"view\\\"]\"', '<p>fdsfsdff fdfds</p>', '\"[\\\"uploads\\\\\\/hotel_room\\\\\\/1757835026_68c66f128694d.jpg\\\",\\\"uploads\\\\\\/hotel_room\\\\\\/1757835026_68c66f1286f92.jpg\\\",\\\"uploads\\\\\\/hotel_room\\\\\\/1757835026_68c66f1287408.jpg\\\",\\\"uploads\\\\\\/hotel_room\\\\\\/1757835026_68c66f12877b3.jpg\\\"]\"', '2025-09-12 10:50:55', '2025-09-14 01:30:26'),
(5, 'gf321', 'double', 33.00, 3, 33.00, 'double', 'available', '\"[\\\"wifi\\\",\\\"tv\\\",\\\"ac\\\",\\\"heating\\\",\\\"minibar\\\",\\\"safe\\\",\\\"balcony\\\",\\\"view\\\"]\"', '<p>fsdfsfdsf fsdfds</p>', '\"[\\\"uploads\\\\\\/hotel_room\\\\\\/1757835014_68c66f0692eff.jpg\\\",\\\"uploads\\\\\\/hotel_room\\\\\\/1757835014_68c66f06934f7.jpg\\\",\\\"uploads\\\\\\/hotel_room\\\\\\/1757835014_68c66f0693a55.jpg\\\",\\\"uploads\\\\\\/hotel_room\\\\\\/1757835014_68c66f0693e99.jpg\\\"]\"', '2025-09-12 10:56:03', '2025-09-14 01:30:14'),
(6, 'fd3434', 'double', 34.00, 3, 343.00, 'king', 'available', '\"[\\\"wifi\\\",\\\"tv\\\",\\\"ac\\\",\\\"minibar\\\",\\\"safe\\\"]\"', '<p>fdsf fsd ff dfsdf</p>', '\"[\\\"uploads\\\\\\/hotel_room\\\\\\/1757834996_68c66ef4e63e8.jpg\\\",\\\"uploads\\\\\\/hotel_room\\\\\\/1757834996_68c66ef4e683c.jpg\\\",\\\"uploads\\\\\\/hotel_room\\\\\\/1757834996_68c66ef4e6ea8.jpg\\\",\\\"uploads\\\\\\/hotel_room\\\\\\/1757834996_68c66ef4e7288.jpg\\\",\\\"uploads\\\\\\/hotel_room\\\\\\/1757834996_68c66ef4e765b.jpg\\\",\\\"uploads\\\\\\/hotel_room\\\\\\/1757834996_68c66ef4e7b35.jpg\\\"]\"', '2025-09-12 11:10:01', '2025-09-14 01:29:56'),
(7, 'dsa22', 'single', 22.00, 2, 23.00, 'king', 'available', '\"[\\\"wifi\\\",\\\"minibar\\\",\\\"safe\\\",\\\"balcony\\\"]\"', '<p>dsad das&nbsp;</p>', '\"[\\\"uploads\\\\\\/hotel_room\\\\\\/1757834975_68c66edf79833.jpg\\\",\\\"uploads\\\\\\/hotel_room\\\\\\/1757834975_68c66edf79cf8.jpg\\\",\\\"uploads\\\\\\/hotel_room\\\\\\/1757834975_68c66edf7a265.jpg\\\",\\\"uploads\\\\\\/hotel_room\\\\\\/1757834975_68c66edf7a717.jpg\\\",\\\"uploads\\\\\\/hotel_room\\\\\\/1757834975_68c66edf7ab39.jpg\\\",\\\"uploads\\\\\\/hotel_room\\\\\\/1757834975_68c66edf7b083.jpg\\\"]\"', '2025-09-12 11:14:31', '2025-09-14 01:29:35'),
(8, 'da25t4 b', 'double', 22.00, 3, 23.00, 'queen', 'available', '\"[\\\"wifi\\\",\\\"minibar\\\",\\\"balcony\\\"]\"', '<p>das d dsa&nbsp; dsa</p>', '\"[\\\"uploads\\\\\\/hotel_room\\\\\\/1757834954_68c66eca8b3c5.jpg\\\",\\\"uploads\\\\\\/hotel_room\\\\\\/1757834954_68c66eca8b89f.jpg\\\",\\\"uploads\\\\\\/hotel_room\\\\\\/1757834954_68c66eca8bdf9.jpg\\\",\\\"uploads\\\\\\/hotel_room\\\\\\/1757834954_68c66eca8c244.jpg\\\"]\"', '2025-09-12 11:15:31', '2025-09-14 01:29:14'),
(9, 'das23', 'double', 4.00, 2, 3.00, 'queen', 'available', '\"[\\\"wifi\\\",\\\"tv\\\",\\\"ac\\\",\\\"minibar\\\",\\\"safe\\\"]\"', '<p>dsa dsad&nbsp;</p>', '\"[\\\"uploads\\\\\\/hotel_room\\\\\\/1757834930_68c66eb26704e.jpg\\\",\\\"uploads\\\\\\/hotel_room\\\\\\/1757834930_68c66eb2675b5.jpg\\\",\\\"uploads\\\\\\/hotel_room\\\\\\/1757834930_68c66eb267935.jpg\\\",\\\"uploads\\\\\\/hotel_room\\\\\\/1757834930_68c66eb267c88.jpg\\\",\\\"uploads\\\\\\/hotel_room\\\\\\/1757834930_68c66eb2681d9.jpg\\\",\\\"uploads\\\\\\/hotel_room\\\\\\/1757834930_68c66eb2685a9.jpg\\\"]\"', '2025-09-12 11:18:58', '2025-09-14 01:28:50'),
(10, 'da22', 'double', 2.00, 2, 22.00, 'queen', 'available', '\"[\\\"tv\\\",\\\"ac\\\",\\\"minibar\\\",\\\"safe\\\"]\"', '<p>dsa ddsa</p>', '\"[\\\"uploads\\\\\\/hotel_room\\\\\\/1757834917_68c66ea59ce6d.jpg\\\",\\\"uploads\\\\\\/hotel_room\\\\\\/1757834917_68c66ea59d786.jpg\\\",\\\"uploads\\\\\\/hotel_room\\\\\\/1757834917_68c66ea59db4c.jpg\\\",\\\"uploads\\\\\\/hotel_room\\\\\\/1757834917_68c66ea59df0c.jpg\\\",\\\"uploads\\\\\\/hotel_room\\\\\\/1757834917_68c66ea59e36b.jpg\\\",\\\"uploads\\\\\\/hotel_room\\\\\\/1757834917_68c66ea59e75d.jpg\\\"]\"', '2025-09-12 11:21:04', '2025-09-14 01:28:37');

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
('1DZeGKGxXoVGBJHmg17iqNcmKF1sYzqVb2uK8RtN', 2191, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoidVZtVmhLMmE0NFFJSEREVXdYMXFpWldoeWE0dU1ZZzFOUkNvQU9RbCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9yZWdpc3RlciI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjIxOTE7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czo0MDoiaHR0cDovLzEyNy4wLjAuMTo4MDAwL2FkbWluL2Jvb2tpbmctcm9vbSI7fX0=', 1757837977),
('NUJJokD8JR6iFwXuZqgCatkke0PsVq7KWp92LxPI', 5417, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', 'YTo0OntzOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czoyOToiaHR0cDovLzEyNy4wLjAuMTo4MDAwL3Jvb21zLzMiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjY6Il90b2tlbiI7czo0MDoiQTJiQmhpR25zSmtPNHNHWDc0OWNPeHlhR0RKazNvRUt6aUpVdzA4RSI7czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6NTQxNzt9', 1757837942);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(10) NOT NULL,
  `key` varchar(191) NOT NULL,
  `value` longtext DEFAULT NULL,
  `is_active` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `key`, `value`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'application_name', 'Clean Application', 1, '2023-05-21 16:34:50', '2025-03-11 21:07:45'),
(2, 'site_logo', '16992796176548f301b7feeMachintools-Logo-2.png', 1, '2023-05-21 16:59:19', '2023-11-06 15:06:57'),
(3, 'site_favicon', '1684732176646af910b4065favicon.png', 1, '2023-05-21 17:09:36', '2023-05-21 17:09:36'),
(4, 'application_phone', '+1 (905) 790-8640', 1, '2023-05-21 17:11:44', '2023-05-21 17:12:29'),
(5, 'application_email', 'info@machinetoolsolutions.ca', 1, '2023-05-21 17:12:29', '2023-05-21 17:12:29'),
(6, 'application_toll_free', '+1 (877) 687-7253', 1, '2023-05-21 17:20:49', '2023-05-21 17:20:49'),
(7, 'application_fax', '+1 (905) 790-3740', 1, '2023-05-21 17:20:49', '2023-05-21 17:20:49'),
(8, 'application_address', '8 Automatic Rd. Building C, Unit #6 Brampton, Ontario L6S 5N4, Canada', 1, '2023-05-21 17:20:49', '2023-10-27 17:16:08'),
(9, 'about_us', '<p style=\"margin: 0.2em 0px 0.5em; padding: 0px; direction: ltr; text-rendering: optimizelegibility; line-height: 1.4;\"></p><h3 style=\"font-family: Jost, sans-serif;\"><span style=\"line-height: inherit;\"><span style=\"font-weight: bolder;\">Machine Tool Solutions –</span></span></h3><h3><span style=\"font-family: Jost, sans-serif; font-size: 16px; line-height: inherit;\"><span style=\"background-color: var(--bs-card-bg); font-size: var(--bs-body-font-size); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align); line-height: inherit;\">Global distributor of reliable and competitively priced&nbsp;products such as AutoGrip Manual / Power Chucks, Lang Technik Clean Tec and AR Filtrazioni, Compact Fixtures, 5-axis Clamping Systems, Stamping Technology, Vises for CNC Machining, Makro-Grip Applications, Precision Index Tables, and more machine tool solutions and services.&nbsp;</span><span style=\"background-color: var(--bs-card-bg); font-size: var(--bs-body-font-size); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align); background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial; line-height: inherit;\">Contact</span><span style=\"background-color: var(--bs-card-bg); font-size: var(--bs-body-font-size); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align); line-height: inherit;\">&nbsp;Machine Tools Solutions today to learn more about what products we have in stock.</span></span><p style=\"font-family: Jost, sans-serif; font-size: 16px;\"></p><p style=\"margin-right: 0px; margin-bottom: 1.25em; margin-left: 0px; font-size: 16px; padding: 0px; direction: ltr; font-family: Lato, helvetica, arial, sans-serif; line-height: 1.6; text-rendering: optimizelegibility;\"><strong style=\"font-weight: bold; line-height: inherit;\">Machine Tool Solutions Ltd.&nbsp;</strong>was established in 1989. For over 35 years, our mission at MTS has been to provide “intelligent workholding for improving productivity” to our customers by delivering high quality, value-minded tools in workholding and material handling through magnetic systems. Additionally, we provide solutions for non-ferrous materials through innovative fixture and zero-point clamping systems, permanent lifting magnets and Makro-grip profile clamping vices.</p><p style=\"margin-right: 0px; margin-bottom: 1.25em; margin-left: 0px; font-size: 16px; padding: 0px; direction: ltr; font-family: Lato, helvetica, arial, sans-serif; line-height: 1.6; text-rendering: optimizelegibility;\">With powerful and well-crafted components, Machine Tool Solutions Ltd. offers a wide product line to satisfy the needs of various industries including defense, medical, automotive, aerospace and more. Our mission further developed the company into gathering the finest products from world-class manufacturers and producers of effective mechanical and industrial components. We are a distributor of equipment from stamping technology, LANG Technik GmbH, SPD, AR Filtrazioni, Ok-Vise low profile clamps, 5-axis vises and stamping devices from LANG as well as many more.</p><p style=\"margin-right: 0px; margin-bottom: 1.25em; margin-left: 0px; font-size: 16px; padding: 0px; direction: ltr; font-family: Lato, helvetica, arial, sans-serif; line-height: 1.6; text-rendering: optimizelegibility;\">Machine Tool Solutions also provide expert repair, refurbishing and re-certification services, ensuring work safety through proper and thorough consultation of your workholding equipment. Our technical services certify your tools work best for you, offering consultations on product efficiency and component manufacturing optimization.</p><p style=\"margin-right: 0px; margin-bottom: 1.25em; margin-left: 0px; font-size: 16px; padding: 0px; direction: ltr; font-family: Lato, helvetica, arial, sans-serif; line-height: 1.6; text-rendering: optimizelegibility;\">We welcome you to be our partner towards continuous success and expanding growth in manufacturing, workholding, automation, and material handling technology.&nbsp;<a rel=\"nofollow\" href=\"https://www.machinetoolsolutions.ca/lang-technovation-technik-gmbh-automation-quick-point-zero-clamping-tower-tombstone-plates-eco-compact-20-canada/\" style=\"color: rgb(10, 77, 104); text-decoration: none; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial; line-height: inherit;\">Contact</a>&nbsp;Machine Tools Solutions today to learn more about what products we have in stock.</p><p class=\"h-large\" style=\"margin-right: 0px; margin-bottom: 1.25em; margin-left: 0px; padding: 0px; direction: ltr; font-family: Lato, helvetica, arial, sans-serif; font-size: 32px; line-height: 32px; text-rendering: optimizelegibility;\">Social Responsibility</p><p style=\"margin-right: 0px; margin-bottom: 1.25em; margin-left: 0px; font-size: 16px; padding: 0px; direction: ltr; font-family: Lato, helvetica, arial, sans-serif; line-height: 1.6; text-rendering: optimizelegibility;\"></p><p style=\"margin-right: 0px; margin-bottom: 1.25em; margin-left: 0px; font-size: 16px; padding: 0px; direction: ltr; font-family: Lato, helvetica, arial, sans-serif; line-height: 1.6; text-rendering: optimizelegibility;\">Machine Tool Solutions Ltd. cares about the environment and its employees are encouraged to:</p><ul style=\"padding: 0px; margin-right: 0px; margin-bottom: 1.25em; margin-left: 20px; font-size: 16px; direction: ltr; line-height: 1.6; list-style-position: outside; font-family: Lato, helvetica, arial, sans-serif;\"><li style=\"margin: 0px; padding: 0px; direction: ltr;\">Keep the work environment clean and safe.</li><li style=\"margin: 0px; padding: 0px; direction: ltr;\">Reduce the company’s waste generation by recycling paper and packaging supplies.</li><li style=\"margin: 0px; padding: 0px; direction: ltr;\">Decrease energy and water consumption.</li></ul></h3>', 1, '2023-05-21 19:14:20', '2024-03-07 20:19:51'),
(10, 'about_image_1', '1684754453646b501513684about-1.jpg', 1, '2023-05-21 23:20:53', '2023-05-21 23:20:53'),
(11, 'about_image_2', '1684754453646b501513bc3about-3.jpg', 1, '2023-05-21 23:20:53', '2023-05-21 23:20:53'),
(12, 'about_image_3', '1684754453646b501513e3dabout-2.jpg', 1, '2023-05-21 23:20:53', '2023-05-21 23:20:53'),
(13, 'terms_and_conditions', '<p class=\"MsoNormal\"><b><span lang=\"EN-CA\" style=\"font-size:12.0pt;line-height:107%\">Effective Date:</span></b><span lang=\"EN-CA\" style=\"font-size:12.0pt;line-height:107%\"> [Insert Date]<o:p></o:p></span></p><p class=\"MsoNormal\"><span lang=\"EN-CA\" style=\"font-size:12.0pt;line-height:107%\">&nbsp;</span></p><p class=\"MsoNormal\"><span lang=\"EN-CA\" style=\"font-size:12.0pt;line-height:107%\">Please\r\nread these Terms and Conditions (\"Terms\") carefully before using the\r\nwebsite https://machinetoolsolutions.ca/ (\"Website\") operated by\r\nMachine Tool Solutions (\"Company,\" \"we,\" \"us,\" or\r\n\"our\"). These Terms set forth the legally binding agreement between\r\nyou (\"User,\" \"you,\" or \"your\") and Machine Tool\r\nSolutions regarding your use of the Website.<o:p></o:p></span></p><p class=\"MsoNormal\"><span lang=\"EN-CA\" style=\"font-size:12.0pt;line-height:107%\">&nbsp;</span></p><p class=\"MsoNormal\"><b><span lang=\"EN-CA\" style=\"font-size:12.0pt;line-height:107%\">Acceptance of Terms<o:p></o:p></span></b></p><p class=\"MsoNormal\"><span lang=\"EN-CA\" style=\"font-size:12.0pt;line-height:107%\">By\r\naccessing or using the Website, you acknowledge that you have read, understood,\r\nand agree to be bound by these Terms and any additional terms and conditions\r\nprovided within the Website. If you do not agree to these Terms, you may not\r\nuse the Website.<o:p></o:p></span></p><p class=\"MsoNormal\"><span lang=\"EN-CA\" style=\"font-size:12.0pt;line-height:107%\">&nbsp;</span></p><p class=\"MsoNormal\"><b><span lang=\"EN-CA\" style=\"font-size:12.0pt;line-height:107%\">Modifications to the Terms<o:p></o:p></span></b></p><p class=\"MsoNormal\"><span lang=\"EN-CA\" style=\"font-size:12.0pt;line-height:107%\">We\r\nreserve the right to modify, update, or replace these Terms at any time,\r\nwithout prior notice. It is your responsibility to review the Terms\r\nperiodically for any changes. Your continued use of the Website after any\r\nmodifications to the Terms constitutes your acceptance of the revised Terms.<o:p></o:p></span></p><p class=\"MsoNormal\"><span lang=\"EN-CA\" style=\"font-size:12.0pt;line-height:107%\">&nbsp;</span></p><p class=\"MsoNormal\"><b><span lang=\"EN-CA\" style=\"font-size:12.0pt;line-height:107%\">Website Use<o:p></o:p></span></b></p><p class=\"MsoNormal\"><span lang=\"EN-CA\" style=\"font-size:12.0pt;line-height:107%\">a.\r\nEligibility: You must be at least 18 years old to use the Website.<o:p></o:p></span></p><p class=\"MsoNormal\"><span lang=\"EN-CA\" style=\"font-size:12.0pt;line-height:107%\">b.\r\nUser Accounts: Some features of the Website may require you to create a user\r\naccount. You are responsible for maintaining the confidentiality of your\r\naccount credentials and for all activities that occur under your account.<o:p></o:p></span></p><p class=\"MsoNormal\"><span lang=\"EN-CA\" style=\"font-size:12.0pt;line-height:107%\">c.\r\nProhibited Activities: You agree not to engage in any activity that violates\r\nthese Terms, including but not limited to:<o:p></o:p></span></p><p class=\"MsoNormal\"><span lang=\"EN-CA\" style=\"font-size:12.0pt;line-height:107%\">&nbsp;</span></p><p class=\"MsoNormal\"><span lang=\"EN-CA\" style=\"font-size:12.0pt;line-height:107%\">Transmitting\r\nany harmful, unlawful, or fraudulent content.<o:p></o:p></span></p><p class=\"MsoNormal\"><span lang=\"EN-CA\" style=\"font-size:12.0pt;line-height:107%\">Interfering\r\nwith the Website\'s functionality, security, or integrity.<o:p></o:p></span></p><p class=\"MsoNormal\"><span lang=\"EN-CA\" style=\"font-size:12.0pt;line-height:107%\">Attempting\r\nto gain unauthorized access to the Website or other users\' accounts.<o:p></o:p></span></p><p class=\"MsoNormal\"><span lang=\"EN-CA\" style=\"font-size:12.0pt;line-height:107%\">Violating\r\nany applicable laws or regulations.<o:p></o:p></span></p><p class=\"MsoNormal\"><b><span lang=\"EN-CA\" style=\"font-size:12.0pt;line-height:107%\">Intellectual Property<o:p></o:p></span></b></p><p class=\"MsoNormal\"><span lang=\"EN-CA\" style=\"font-size:12.0pt;line-height:107%\">a.\r\nOwnership: All content, trademarks, logos, and intellectual property rights\r\ndisplayed on the Website are owned by Machine Tool Solutions or its licensors.\r\nYou may not use, reproduce, distribute, or modify any of the content without\r\nour prior written consent.<o:p></o:p></span></p><p class=\"MsoNormal\"><span lang=\"EN-CA\" style=\"font-size:12.0pt;line-height:107%\">b.\r\nUser Content: By submitting or uploading any content to the Website, you grant\r\nus a non-exclusive, worldwide, royalty-free license to use, display, reproduce,\r\nand distribute that content for the purpose of operating and improving the\r\nWebsite.<o:p></o:p></span></p><p class=\"MsoNormal\"><span lang=\"EN-CA\" style=\"font-size:12.0pt;line-height:107%\">&nbsp;</span></p><p class=\"MsoNormal\"><b><span lang=\"EN-CA\" style=\"font-size:12.0pt;line-height:107%\">Third-Party Websites and Services<o:p></o:p></span></b></p><p class=\"MsoNormal\"><span lang=\"EN-CA\" style=\"font-size:12.0pt;line-height:107%\">The\r\nWebsite may contain links to third-party websites or services that are not\r\nowned or controlled by Machine Tool Solutions. We are not responsible for the\r\ncontent or practices of any third-party websites or services. Your use of such\r\nwebsites or services is subject to their respective terms and conditions and\r\nprivacy policies.<o:p></o:p></span></p><p class=\"MsoNormal\"><span lang=\"EN-CA\" style=\"font-size:12.0pt;line-height:107%\">&nbsp;</span></p><p class=\"MsoNormal\"><b><span lang=\"EN-CA\" style=\"font-size:12.0pt;line-height:107%\">Limitation of Liability<o:p></o:p></span></b></p><p class=\"MsoNormal\"><span lang=\"EN-CA\" style=\"font-size:12.0pt;line-height:107%\">a.\r\nDisclaimer of Warranties: The Website is provided on an \"as is\" and\r\n\"as available\" basis, without any warranties or representations of\r\nany kind, whether express or implied. We do not guarantee the accuracy,\r\ncompleteness, or reliability of any content on the Website.<o:p></o:p></span></p><p class=\"MsoNormal\"><span lang=\"EN-CA\" style=\"font-size:12.0pt;line-height:107%\">b.\r\nLimitation of Liability: To the fullest extent permitted by applicable law,\r\nMachine Tool Solutions and its directors, officers, employees, or agents shall\r\nnot be liable for any direct, indirect, incidental, special, consequential, or\r\npunitive damages arising out of or in any way connected with your use of the\r\nWebsite or any content on the Website.<o:p></o:p></span></p><p class=\"MsoNormal\"><span lang=\"EN-CA\" style=\"font-size:12.0pt;line-height:107%\">&nbsp;</span></p><p class=\"MsoNormal\"><b><span lang=\"EN-CA\" style=\"font-size:12.0pt;line-height:107%\">Indemnification<o:p></o:p></span></b></p><p class=\"MsoNormal\"><span lang=\"EN-CA\" style=\"font-size:12.0pt;line-height:107%\">You\r\nagree to indemnify and hold Machine Tool Solutions, its affiliates, officers,\r\ndirectors, employees, and agents harmless from any claim or demand, including\r\nreasonable attorney\'s fees, made by any third party due to or arising out of\r\nyour use of the Website, your violation of these Terms, or your violation of\r\nany rights of another party.<o:p></o:p></span></p><p class=\"MsoNormal\"><span lang=\"EN-CA\" style=\"font-size:12.0pt;line-height:107%\">&nbsp;</span></p><p class=\"MsoNormal\"><b><span lang=\"EN-CA\" style=\"font-size:12.0pt;line-height:107%\">Governing Law and Jurisdiction<o:p></o:p></span></b></p><p class=\"MsoNormal\"><span lang=\"EN-CA\" style=\"font-size:12.0pt;line-height:107%\">These\r\nTerms shall be governed by and construed in accordance with the laws of [Insert\r\ngoverning law]. Any disputes arising under or in connection with these Terms\r\nshall be subject to the exclusive jurisdiction of the courts located in [Insert\r\njurisdiction].<o:p></o:p></span></p><p class=\"MsoNormal\"><span lang=\"EN-CA\" style=\"font-size:12.0pt;line-height:107%\">&nbsp;</span></p><p class=\"MsoNormal\"><b><span lang=\"EN-CA\" style=\"font-size:12.0pt;line-height:107%\">Severability<o:p></o:p></span></b></p><p class=\"MsoNormal\"><span lang=\"EN-CA\" style=\"font-size:12.0pt;line-height:107%\">If\r\nany provision of these Terms is found to be invalid or unenforceable, the\r\nremaining provisions shall continue to be valid and enforceable to the fullest\r\nextent permitted by law.<o:p></o:p></span></p><p class=\"MsoNormal\"><b><span lang=\"EN-CA\" style=\"font-size:12.0pt;line-height:107%\">Entire Agreement<o:p></o:p></span></b></p><p class=\"MsoNormal\"><span lang=\"EN-CA\" style=\"font-size:12.0pt;line-height:107%\">These\r\nTerms constitute the entire agreement between you and Machine Tool Solutions\r\nregarding your use of the Website and supersede any prior agreements or\r\nunderstandings, whether oral or written.<o:p></o:p></span></p><p class=\"MsoNormal\"><span lang=\"EN-CA\" style=\"font-size:12.0pt;line-height:107%\">&nbsp;</span></p><p class=\"MsoNormal\"><span lang=\"EN-CA\" style=\"font-size:12.0pt;line-height:107%\">If\r\nyou have any questions or concerns regarding these Terms, please contact us at\r\n[Insert contact information].<o:p></o:p></span></p><p class=\"MsoNormal\"><span lang=\"EN-CA\" style=\"font-size:12.0pt;line-height:107%\">&nbsp;</span></p><p class=\"MsoNormal\">\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n</p><p class=\"MsoNormal\"><span lang=\"EN-CA\" style=\"font-size:12.0pt;line-height:107%\">By\r\nusing the Website, you acknowledge that you have read, understood, and agree to\r\nbe bound by these Terms and Conditions.</span></p><p class=\"MsoNormal\"><span lang=\"EN-CA\" style=\"font-size: 12pt; line-height: 107%; background-color: rgb(255, 0, 0);\"><o:p style=\"\"><br></o:p></span></p><p class=\"MsoNormal\"><span lang=\"EN-CA\" style=\"font-size: 12pt; line-height: 107%; background-color: rgb(255, 0, 0);\"><o:p><br></o:p></span></p><p class=\"MsoNormal\"><span lang=\"EN-CA\" style=\"font-size: 12pt; line-height: 107%; background-color: rgb(255, 0, 0);\"><o:p style=\"\">xsfdsdsfsdfsdfsdfsdfsdfsfsdf</o:p></span></p>', 1, '2023-07-02 19:25:51', '2024-01-22 11:18:44'),
(14, 'privacy_policy', '<p class=\"MsoNormal\"><b><span lang=\"EN-CA\" style=\"font-size:12.0pt;line-height:107%\">Effective Date:</span></b><span lang=\"EN-CA\" style=\"font-size:12.0pt;line-height:107%\"> [Insert Date]<o:p></o:p></span></p>\r\n\r\n<p class=\"MsoNormal\"><span lang=\"EN-CA\" style=\"font-size:12.0pt;line-height:107%\"> </span></p>\r\n\r\n<p class=\"MsoNormal\"><span lang=\"EN-CA\" style=\"font-size:12.0pt;line-height:107%\">At\r\nMachine Tool Solutions (\"Company,\" \"we,\" \"us,\" or\r\n\"our\"), we are committed to protecting your privacy. This Privacy\r\nPolicy describes how we collect, use, disclose, and store your personal\r\ninformation when you visit or use the website https://machinetoolsolutions.ca/\r\n(\"Website\").<o:p></o:p></span></p>\r\n\r\n<p class=\"MsoNormal\"><span lang=\"EN-CA\" style=\"font-size:12.0pt;line-height:107%\"> </span></p>\r\n\r\n<p class=\"MsoNormal\"><b><span lang=\"EN-CA\" style=\"font-size:12.0pt;line-height:107%\">Information We Collect<o:p></o:p></span></b></p>\r\n\r\n<p class=\"MsoNormal\"><span lang=\"EN-CA\" style=\"font-size:12.0pt;line-height:107%\">a.\r\nPersonal Information: We may collect personal information that you voluntarily\r\nprovide to us, such as your name, email address, phone number, and any other\r\ninformation you choose to provide.<o:p></o:p></span></p>\r\n\r\n<p class=\"MsoNormal\"><span lang=\"EN-CA\" style=\"font-size:12.0pt;line-height:107%\">b.\r\nAutomatically Collected Information: When you visit our Website, we may\r\nautomatically collect certain information, including your IP address, browser\r\ntype, device information, and browsing activity.<o:p></o:p></span></p>\r\n\r\n<p class=\"MsoNormal\"><span lang=\"EN-CA\" style=\"font-size:12.0pt;line-height:107%\"> </span></p>\r\n\r\n<p class=\"MsoNormal\"><b><span lang=\"EN-CA\" style=\"font-size:12.0pt;line-height:107%\">Use of Information<o:p></o:p></span></b></p>\r\n\r\n<p class=\"MsoNormal\"><span lang=\"EN-CA\" style=\"font-size:12.0pt;line-height:107%\">a.\r\nWe may use the information we collect for the following purposes:<o:p></o:p></span></p>\r\n\r\n<p class=\"MsoNormal\"><span lang=\"EN-CA\" style=\"font-size:12.0pt;line-height:107%\"> </span></p>\r\n\r\n<p class=\"MsoNormal\"><span lang=\"EN-CA\" style=\"font-size:12.0pt;line-height:107%\">To\r\nprovide and maintain the Website and its features.<o:p></o:p></span></p>\r\n\r\n<p class=\"MsoNormal\"><span lang=\"EN-CA\" style=\"font-size:12.0pt;line-height:107%\">To\r\ncommunicate with you, respond to your inquiries, and provide customer support.<o:p></o:p></span></p>\r\n\r\n<p class=\"MsoNormal\"><span lang=\"EN-CA\" style=\"font-size:12.0pt;line-height:107%\">To\r\npersonalize your experience on the Website and deliver relevant content.<o:p></o:p></span></p>\r\n\r\n<p class=\"MsoNormal\"><span lang=\"EN-CA\" style=\"font-size:12.0pt;line-height:107%\">To\r\nanalyze and improve the Website\'s performance and functionality.<o:p></o:p></span></p>\r\n\r\n<p class=\"MsoNormal\"><span lang=\"EN-CA\" style=\"font-size:12.0pt;line-height:107%\">To\r\ndetect, prevent, and address technical issues or fraudulent activities.<o:p></o:p></span></p>\r\n\r\n<p class=\"MsoNormal\"><span lang=\"EN-CA\" style=\"font-size:12.0pt;line-height:107%\">b.\r\nWe will only use your personal information for the purposes stated in this\r\nPrivacy Policy or as otherwise disclosed to you at the time of collection. We\r\nwill not sell, rent, or lease your personal information to any third parties\r\nwithout your consent.<o:p></o:p></span></p>\r\n\r\n<p class=\"MsoNormal\"><span lang=\"EN-CA\" style=\"font-size:12.0pt;line-height:107%\">Cookies\r\nand Tracking Technologies<o:p></o:p></span></p>\r\n\r\n<p class=\"MsoNormal\"><span lang=\"EN-CA\" style=\"font-size:12.0pt;line-height:107%\">a.\r\nWe may use cookies and similar tracking technologies to collect and store\r\ninformation about your interactions with the Website. Cookies are small text\r\nfiles that are stored on your device.<o:p></o:p></span></p>\r\n\r\n<p class=\"MsoNormal\"><span lang=\"EN-CA\" style=\"font-size:12.0pt;line-height:107%\">b.\r\nYou have the option to refuse or disable cookies through your browser settings.\r\nHowever, please note that disabling cookies may affect the functionality of the\r\nWebsite.<o:p></o:p></span></p>\r\n\r\n<p class=\"MsoNormal\"><span lang=\"EN-CA\" style=\"font-size:12.0pt;line-height:107%\"> </span></p>\r\n\r\n<p class=\"MsoNormal\"><b><span lang=\"EN-CA\" style=\"font-size:12.0pt;line-height:107%\">Third-Party Disclosure<o:p></o:p></span></b></p>\r\n\r\n<p class=\"MsoNormal\"><span lang=\"EN-CA\" style=\"font-size:12.0pt;line-height:107%\">a.\r\nWe may share your personal information with trusted third-party service\r\nproviders who assist us in operating our Website, conducting our business, or\r\nproviding services to you. These third parties are obligated to keep your\r\ninformation confidential and are prohibited from using your personal\r\ninformation for any other purposes.<o:p></o:p></span></p>\r\n\r\n<p class=\"MsoNormal\"><span lang=\"EN-CA\" style=\"font-size:12.0pt;line-height:107%\">b.\r\nWe may also disclose your personal information if required by law or if we\r\nbelieve that such disclosure is necessary to protect our rights, comply with a\r\njudicial proceeding, court order, or legal process, or to prevent imminent harm\r\nor financial loss.<o:p></o:p></span></p>\r\n\r\n<p class=\"MsoNormal\"><span lang=\"EN-CA\" style=\"font-size:12.0pt;line-height:107%\"> </span></p>\r\n\r\n<p class=\"MsoNormal\"><b><span lang=\"EN-CA\" style=\"font-size:12.0pt;line-height:107%\">Data Security<o:p></o:p></span></b></p>\r\n\r\n<p class=\"MsoNormal\"><span lang=\"EN-CA\" style=\"font-size:12.0pt;line-height:107%\">a.\r\nWe implement appropriate technical and organizational measures to protect your\r\npersonal information from unauthorized access, disclosure, alteration, or\r\ndestruction.<o:p></o:p></span></p>\r\n\r\n<p class=\"MsoNormal\"><span lang=\"EN-CA\" style=\"font-size:12.0pt;line-height:107%\">b.\r\nWhile we strive to protect your personal information, no method of transmission\r\nover the Internet or electronic storage is completely secure. Therefore, we\r\ncannot guarantee its absolute security.<o:p></o:p></span></p>\r\n\r\n<p class=\"MsoNormal\"><span lang=\"EN-CA\" style=\"font-size:12.0pt;line-height:107%\"> </span></p>\r\n\r\n<p class=\"MsoNormal\"><b><span lang=\"EN-CA\" style=\"font-size:12.0pt;line-height:107%\">Children\'s Privacy<o:p></o:p></span></b></p>\r\n\r\n<p class=\"MsoNormal\"><span lang=\"EN-CA\" style=\"font-size:12.0pt;line-height:107%\">Our\r\nWebsite is not directed to individuals under the age of 18. We do not knowingly\r\ncollect personal information from children. If you are a parent or guardian and\r\nbelieve that your child has provided personal information on our Website,\r\nplease contact us, and we will promptly delete the information.<o:p></o:p></span></p>\r\n\r\n<p class=\"MsoNormal\"><span lang=\"EN-CA\" style=\"font-size:12.0pt;line-height:107%\"> </span></p>\r\n\r\n<p class=\"MsoNormal\"><b><span lang=\"EN-CA\" style=\"font-size:12.0pt;line-height:107%\">Links to Third-Party Websites<o:p></o:p></span></b></p>\r\n\r\n<p class=\"MsoNormal\"><span lang=\"EN-CA\" style=\"font-size:12.0pt;line-height:107%\">The\r\nWebsite may contain links to third-party websites. We are not responsible for\r\nthe privacy practices or the content of those websites. We encourage you to\r\nreview the privacy policies of those third-party websites before providing any\r\npersonal information.<o:p></o:p></span></p>\r\n\r\n<p class=\"MsoNormal\"><span lang=\"EN-CA\" style=\"font-size:12.0pt;line-height:107%\"> </span></p>\r\n\r\n<p class=\"MsoNormal\"><b><span lang=\"EN-CA\" style=\"font-size:12.0pt;line-height:107%\">Your Rights<o:p></o:p></span></b></p>\r\n\r\n<p class=\"MsoNormal\"><span lang=\"EN-CA\" style=\"font-size:12.0pt;line-height:107%\">a.\r\nYou have the right to access, correct, update, or delete your personal\r\ninformation that we hold. If you would like to exercise any of these rights,\r\nplease contact us using the information provided at the end of this Privacy\r\nPolicy.<o:p></o:p></span></p>\r\n\r\n<p class=\"MsoNormal\"><span lang=\"EN-CA\" style=\"font-size:12.0pt;line-height:107%\">b.\r\nWe will respond to your request within a reasonable timeframe and in accordance\r\nwith applicable laws.<o:p></o:p></span></p>\r\n\r\n<p class=\"MsoNormal\"><span lang=\"EN-CA\" style=\"font-size:12.0pt;line-height:107%\"> </span></p>\r\n\r\n<p class=\"MsoNormal\"><b><span lang=\"EN-CA\" style=\"font-size:12.0pt;line-height:107%\">Changes to this Privacy Policy<o:p></o:p></span></b></p>\r\n\r\n<p class=\"MsoNormal\"><span lang=\"EN-CA\" style=\"font-size:12.0pt;line-height:107%\">We\r\nmay update this Privacy Policy from time to time. Any changes will be posted on\r\nthis page, and the \"Effective Date\" at the top of this policy will be\r\nupdated. We encourage you to review this Privacy Policy periodically to stay\r\ninformed about how we collect, use, and protect your personal information.<o:p></o:p></span></p>\r\n\r\n<p class=\"MsoNormal\"><span lang=\"EN-CA\" style=\"font-size:12.0pt;line-height:107%\"> </span></p>\r\n\r\n<p class=\"MsoNormal\"><b><span lang=\"EN-CA\" style=\"font-size:12.0pt;line-height:107%\">Contact Us<o:p></o:p></span></b></p>\r\n\r\n<p class=\"MsoNormal\"><span lang=\"EN-CA\" style=\"font-size:12.0pt;line-height:107%\">If\r\nyou have any questions, concerns, or requests regarding this Privacy Policy,\r\nplease contact us at [Insert contact information].<o:p></o:p></span></p>\r\n\r\n<p class=\"MsoNormal\"><span lang=\"EN-CA\" style=\"font-size:12.0pt;line-height:107%\"> </span></p>\r\n\r\n<p class=\"MsoNormal\"><span lang=\"EN-CA\" style=\"font-size:12.0pt;line-height:107%\">By\r\nusing the Website, you acknowledge that you have read, understood, and agree to\r\nbe bound by this Privacy Policy.<o:p></o:p></span></p>', 1, '2023-07-02 19:25:51', '2023-07-28 00:18:15'),
(15, 'return_policy', '<p class=\"MsoNormal\"><span lang=\"EN-CA\" style=\"font-size:12.0pt;line-height:107%\"><span style=\"font-weight: bolder; font-family: Jost, sans-serif;\"><span lang=\"EN-CA\" style=\"font-size: 12pt; line-height: 17.12px;\">Effective Date:</span></span><span lang=\"EN-CA\" style=\"font-family: Jost, sans-serif; font-size: 12pt; line-height: 17.12px;\"> [Insert Date]</span><br></span></p><p class=\"MsoNormal\"><span lang=\"EN-CA\" style=\"font-size:12.0pt;line-height:107%\">Thank\r\nyou for shopping at Machine Tool Solutions (\"Company,\"\r\n\"we,\" \"us,\" or \"our\"). We want you to be\r\ncompletely satisfied with your purchase. This Return Policy describes the\r\nguidelines and procedures for returning products purchased from the website https://machinetoolsolutions.ca/\r\n(\"Website\").<o:p></o:p></span></p>\r\n\r\n<p class=\"MsoNormal\"><span lang=\"EN-CA\" style=\"font-size:12.0pt;line-height:107%\"> </span></p>\r\n\r\n<p class=\"MsoNormal\"><b><span lang=\"EN-CA\" style=\"font-size:12.0pt;line-height:107%\">Eligibility<o:p></o:p></span></b></p>\r\n\r\n<p class=\"MsoNormal\"><span lang=\"EN-CA\" style=\"font-size:12.0pt;line-height:107%\">a.\r\nTo be eligible for a return, the product must be unused, in its original\r\ncondition, and in the original packaging.<o:p></o:p></span></p>\r\n\r\n<p class=\"MsoNormal\"><span lang=\"EN-CA\" style=\"font-size:12.0pt;line-height:107%\">b.\r\nCertain products, such as personalized or customized items, may not be eligible\r\nfor return unless they are defective or damaged upon arrival.<o:p></o:p></span></p>\r\n\r\n<p class=\"MsoNormal\"><span lang=\"EN-CA\" style=\"font-size:12.0pt;line-height:107%\"> </span></p>\r\n\r\n<p class=\"MsoNormal\"><b><span lang=\"EN-CA\" style=\"font-size:12.0pt;line-height:107%\">Return Process<o:p></o:p></span></b></p>\r\n\r\n<p class=\"MsoNormal\"><span lang=\"EN-CA\" style=\"font-size:12.0pt;line-height:107%\">a.\r\nInitiation: To initiate a return, please contact our customer service team\r\nwithin [number of days] days of receiving the product. You can reach us by\r\n[provide contact information].<o:p></o:p></span></p>\r\n\r\n<p class=\"MsoNormal\"><span lang=\"EN-CA\" style=\"font-size:12.0pt;line-height:107%\">b.\r\nReturn Authorization: Our customer service team will provide you with a Return\r\nAuthorization (RA) number and instructions for returning the product.<o:p></o:p></span></p>\r\n\r\n<p class=\"MsoNormal\"><span lang=\"EN-CA\" style=\"font-size:12.0pt;line-height:107%\">c.\r\nPackaging: Ensure that the product is securely packaged in its original\r\npackaging or a suitable alternative to prevent damage during transit.<o:p></o:p></span></p>\r\n\r\n<p class=\"MsoNormal\"><span lang=\"EN-CA\" style=\"font-size:12.0pt;line-height:107%\">d.\r\nShipping: You are responsible for the shipping costs associated with the\r\nreturn, unless the product is defective or damaged.<o:p></o:p></span></p>\r\n\r\n<p class=\"MsoNormal\"><span lang=\"EN-CA\" style=\"font-size:12.0pt;line-height:107%\">e.\r\nTracking: We recommend using a trackable shipping method and keeping the tracking\r\nnumber for reference.<o:p></o:p></span></p>\r\n\r\n<p class=\"MsoNormal\"><span lang=\"EN-CA\" style=\"font-size:12.0pt;line-height:107%\">f.\r\nInspection and Refund: Once we receive the returned product, our team will\r\ninspect it for eligibility and condition. If the return is approved, we will\r\ninitiate a refund to your original payment method within [number of days] days.<o:p></o:p></span></p>\r\n\r\n<p class=\"MsoNormal\"><span lang=\"EN-CA\" style=\"font-size:12.0pt;line-height:107%\"> </span></p>\r\n\r\n<p class=\"MsoNormal\"><b><span lang=\"EN-CA\" style=\"font-size:12.0pt;line-height:107%\">Non-Returnable Items<o:p></o:p></span></b></p>\r\n\r\n<p class=\"MsoNormal\"><span lang=\"EN-CA\" style=\"font-size:12.0pt;line-height:107%\">The\r\nfollowing items are not eligible for return:<o:p></o:p></span></p>\r\n\r\n<p class=\"MsoNormal\"><span lang=\"EN-CA\" style=\"font-size:12.0pt;line-height:107%\"> </span></p>\r\n\r\n<p class=\"MsoNormal\"><span lang=\"EN-CA\" style=\"font-size:12.0pt;line-height:107%\">Consumable\r\nproducts or items that cannot be resold due to health and hygiene reasons.<o:p></o:p></span></p>\r\n\r\n<p class=\"MsoNormal\"><span lang=\"EN-CA\" style=\"font-size:12.0pt;line-height:107%\">Products\r\nthat have been used, altered, or damaged after delivery.<o:p></o:p></span></p>\r\n\r\n<p class=\"MsoNormal\"><span lang=\"EN-CA\" style=\"font-size:12.0pt;line-height:107%\">Customized\r\nor personalized items, unless they are defective or damaged upon arrival.<o:p></o:p></span></p>\r\n\r\n<p class=\"MsoNormal\"><b><span lang=\"EN-CA\" style=\"font-size:12.0pt;line-height:107%\">Damaged or Defective Products<o:p></o:p></span></b></p>\r\n\r\n<p class=\"MsoNormal\"><span lang=\"EN-CA\" style=\"font-size:12.0pt;line-height:107%\">a.\r\nIf the product you received is damaged or defective, please contact our\r\ncustomer service team within [number of days] days of receiving the product.<o:p></o:p></span></p>\r\n\r\n<p class=\"MsoNormal\"><span lang=\"EN-CA\" style=\"font-size:12.0pt;line-height:107%\">b.\r\nWe may request evidence, such as photographs or a detailed description, to\r\nassess the damage or defect.<o:p></o:p></span></p>\r\n\r\n<p class=\"MsoNormal\"><span lang=\"EN-CA\" style=\"font-size:12.0pt;line-height:107%\">c.\r\nOnce the damage or defect is verified, we will provide instructions for\r\nreturning the product, and a replacement or refund will be issued, including\r\nany applicable shipping costs.<o:p></o:p></span></p>\r\n\r\n<p class=\"MsoNormal\"><span lang=\"EN-CA\" style=\"font-size:12.0pt;line-height:107%\"> </span></p>\r\n\r\n<p class=\"MsoNormal\"><b><span lang=\"EN-CA\" style=\"font-size:12.0pt;line-height:107%\">Refunds<o:p></o:p></span></b></p>\r\n\r\n<p class=\"MsoNormal\"><span lang=\"EN-CA\" style=\"font-size:12.0pt;line-height:107%\">a.\r\nRefunds will be issued in the same form of payment used for the original\r\npurchase.<o:p></o:p></span></p>\r\n\r\n<p class=\"MsoNormal\"><span lang=\"EN-CA\" style=\"font-size:12.0pt;line-height:107%\">b.\r\nDepending on your payment provider, it may take additional time for the refund\r\nto be processed and reflected in your account.<o:p></o:p></span></p>\r\n\r\n<p class=\"MsoNormal\"><span lang=\"EN-CA\" style=\"font-size:12.0pt;line-height:107%\">c.\r\nShipping costs, if applicable, are non-refundable unless the return is due to a\r\ndefect or damage.<o:p></o:p></span></p>\r\n\r\n<p class=\"MsoNormal\"><span lang=\"EN-CA\" style=\"font-size:12.0pt;line-height:107%\"> </span></p>\r\n\r\n<p class=\"MsoNormal\"><b><span lang=\"EN-CA\" style=\"font-size:12.0pt;line-height:107%\">Exchanges<o:p></o:p></span></b></p>\r\n\r\n<p class=\"MsoNormal\"><span lang=\"EN-CA\" style=\"font-size:12.0pt;line-height:107%\">We\r\ncurrently do not offer direct exchanges. If you wish to exchange a product,\r\nplease follow the return process and place a new order for the desired item on\r\nour Website.<o:p></o:p></span></p>\r\n\r\n<p class=\"MsoNormal\"><span lang=\"EN-CA\" style=\"font-size:12.0pt;line-height:107%\"> </span></p>\r\n\r\n<p class=\"MsoNormal\"><b><span lang=\"EN-CA\" style=\"font-size:12.0pt;line-height:107%\">Changes to the Return Policy<o:p></o:p></span></b></p>\r\n\r\n<p class=\"MsoNormal\"><span lang=\"EN-CA\" style=\"font-size:12.0pt;line-height:107%\">We\r\nreserve the right to modify, update, or replace this Return Policy at any time,\r\nwithout prior notice. The revised policy will be posted on our Website.<o:p></o:p></span></p>\r\n\r\n<p class=\"MsoNormal\"><span lang=\"EN-CA\" style=\"font-size:12.0pt;line-height:107%\"> </span></p>\r\n\r\n<p class=\"MsoNormal\"><b><span lang=\"EN-CA\" style=\"font-size:12.0pt;line-height:107%\">Contact Us<o:p></o:p></span></b></p>\r\n\r\n<p class=\"MsoNormal\"><span lang=\"EN-CA\" style=\"font-size:12.0pt;line-height:107%\">If\r\nyou have any questions or concerns regarding this Return Policy, please contact\r\nour customer service team using the information provided on our Website.<o:p></o:p></span></p>\r\n\r\n<p class=\"MsoNormal\"><span lang=\"EN-CA\" style=\"font-size:12.0pt;line-height:107%\"> </span></p>\r\n\r\n<p class=\"MsoNormal\"><span lang=\"EN-CA\" style=\"font-size:12.0pt;line-height:107%\">By\r\nmaking a purchase on our Website, you acknowledge that you have read,\r\nunderstood, and agree to be bound by this Return Policy.<o:p></o:p></span></p>', 1, '2023-07-02 19:25:51', '2024-01-22 10:30:08'),
(16, 'facebook_link', 'https://www.facebook.com/machinetoolsolutionsltd', 1, '2023-07-02 23:45:16', '2023-07-02 23:45:16'),
(17, 'twitter_link', 'https://twitter.com/mtssale', 1, '2023-07-02 23:45:16', '2023-07-02 23:45:16'),
(18, 'instagram_link', 'https://www.instagram.com/machinetoolsolutions/', 1, '2023-07-02 23:45:16', '2023-07-02 23:45:16'),
(19, 'linkedin_link', 'https://www.linkedin.com/in/mtssale/?originalSubdomain=ca', 1, '2023-07-02 23:45:16', '2023-07-02 23:45:16'),
(20, 'youtube_link', 'https://www.youtube.com/channel/UCMjRnr6oGr4HESlnWxAtqyg', 1, '2023-07-02 23:45:16', '2023-07-02 23:45:16');

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
  `role` varchar(255) DEFAULT NULL COMMENT '1=admin,2=user,3=guest',
  `status` varchar(255) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `deleted_at` varchar(255) DEFAULT NULL,
  `gender` varchar(50) DEFAULT NULL,
  `visible_password` varchar(255) DEFAULT NULL,
  `profile_image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `status`, `remember_token`, `created_at`, `updated_at`, `phone`, `address`, `deleted_at`, `gender`, `visible_password`, `profile_image`) VALUES
(1172, 'User 6', 'user6@example.com', NULL, '$2y$12$.GSEzseqLKsuP4ygAnGi8uX0YeVTKLn7bJopYgvyaV41fS0aZJNuG', '2', NULL, 'mYNRVZYI6V', '2025-09-14 02:11:54', '2025-09-14 02:11:54', '01820000002', '56 Beach St, Barishal', NULL, 'male', NULL, NULL),
(1400, 'User 19', 'user19@example.com', NULL, '$2y$12$gw7Vx9MJENj/0d9MJwJC/.Y5m8Dxq/RKWjI5bKIqzFeWlq09Z37Sq', '2', NULL, 'OJueq8TYI5', '2025-09-14 02:11:56', '2025-09-14 02:11:56', '01710000001', '789 Lake Rd, Sylhet', NULL, 'male', NULL, NULL),
(1523, 'User 20', 'user20@example.com', NULL, '$2y$12$2UKYL1lKLR6g.62aAIQd5OZAShdAWMPDhJKkAUtC0U0lMHM5M39py', '2', '1', 'nkW2YCB1oD', '2025-09-14 02:11:57', '2025-09-14 02:13:02', '01710000001', '34 Hill Rd, Rajshahi', NULL, 'female', NULL, NULL),
(1725, 'User 2', 'user2@example.com', NULL, '$2y$12$tFrIAXpmBXBlo0oW9hDeROQgcGydEMs6s.zQpnl.rn76s.RVJh2IO', '2', NULL, 'FSWXnJibYh', '2025-09-14 02:11:53', '2025-09-14 02:11:53', '01980000008', '789 Lake Rd, Sylhet', NULL, 'male', NULL, NULL),
(1976, 'User 14', 'user14@example.com', NULL, '$2y$12$0.GxEAx7SAzqGz8HTVgcAu733u5qdLJMPz1R5zPFyGvwFBiudmLgi', '2', NULL, 'Dkg7hoRc3h', '2025-09-14 02:11:55', '2025-09-14 02:11:55', '01640000004', '56 Beach St, Barishal', NULL, 'female', NULL, NULL),
(2201, 'User 11', 'user11@example.com', NULL, '$2y$12$tycc8CNsWktnlYVPBVzDm.3GBWwZD.pIOCpJ0zqvGSdo7ZO5eGQei', '2', NULL, '3RA36NDe42', '2025-09-14 02:11:55', '2025-09-14 02:11:55', '01980000008', '456 Park Ave, Chittagong', NULL, 'male', NULL, NULL),
(2727, 'User 13', 'user13@example.com', NULL, '$2y$12$gHI3XSv9Xh3JhW.HTzkNw.InIejOyG3vFuSXY0cDiXWD2tSa0s96K', '2', NULL, 'ygVOZqXPWr', '2025-09-14 02:11:55', '2025-09-14 02:11:55', '01550000005', '456 Park Ave, Chittagong', NULL, 'male', NULL, NULL),
(3090, 'User 12', 'user12@example.com', NULL, '$2y$12$5jpORttsoYe66DRH4LE2XeWJC1jUQG2g8nU0x1u6cyOJC/G5oi4tK', '2', NULL, 'QbiZ4aYhvM', '2025-09-14 02:11:55', '2025-09-14 02:11:55', '01710000001', '456 Park Ave, Chittagong', NULL, 'female', NULL, NULL),
(3403, 'User 4', 'user4@example.com', NULL, '$2y$12$x9fYbAHySLw1zSYtxLRudeMEQo85AmYgYr16inmmeHA7xEtsWcmCq', '2', NULL, 'FafNvYm81d', '2025-09-14 02:11:53', '2025-09-14 02:11:53', '01640000004', '789 Lake Rd, Sylhet', NULL, 'male', NULL, NULL),
(3579, 'User 18', 'user18@example.com', NULL, '$2y$12$u41JzH/uJuhu3YjTEdvuieYj/zETtdPUFViu23fdQ3GiuKV/w3nSi', '2', NULL, 'm8amW99dxl', '2025-09-14 02:11:56', '2025-09-14 02:11:56', '01980000008', '34 Hill Rd, Rajshahi', NULL, 'male', NULL, NULL),
(4555, 'User 9', 'user9@example.com', NULL, '$2y$12$R.yf150RJxX5QofgoPG9xObAuB0ugu0u73XDQkWq/WH1OAkepos5O', '2', NULL, 'If8QoUsiHs', '2025-09-14 02:11:54', '2025-09-14 02:11:54', '01550000005', '34 Hill Rd, Rajshahi', NULL, 'male', NULL, NULL),
(5191, 'User 16', 'user16@example.com', NULL, '$2y$12$nbDXtngyKw44W9LHoDM8l.NcvCkVyFT6jQaeVL.tYAAPff4S5q8d2', '2', NULL, 'VLqVArmMid', '2025-09-14 02:11:56', '2025-09-14 02:11:56', '01500000010', '456 Park Ave, Chittagong', NULL, 'male', NULL, NULL),
(5205, 'User 17', 'user17@example.com', NULL, '$2y$12$idu2gQ5OJkFYID.axF4M1.HaklrCzIPA35Md0pC/YOdHTIYo98DGq', '2', '1', 'moc90RUhii', '2025-09-14 02:11:56', '2025-09-14 02:13:08', '01820000002', '12 River St, Khulna', NULL, 'male', NULL, NULL),
(5417, 'Admin', 'admin@gmail.com', NULL, '$2y$12$SC.bIKpnAS2qFxKgpce9/.KU6Rtttc5eoJW03A/Y7tkcTyxQ8n1c.', '1', '1', NULL, '2025-09-11 13:45:14', '2025-09-14 02:13:27', NULL, NULL, NULL, 'male', NULL, NULL),
(6362, 'User 7', 'user7@example.com', NULL, '$2y$12$m2G5FPyOXGwLCWyI6FXPM.I0LGARTBYd4hvw7enCDL2imt283habC', '2', NULL, 'rWbgjGKRTB', '2025-09-14 02:11:54', '2025-09-14 02:11:54', '01930000003', '34 Hill Rd, Rajshahi', NULL, 'male', NULL, NULL),
(6500, 'User 5', 'user5@example.com', NULL, '$2y$12$ZczA/KMT450n/9Wz76ESZO0ZlCSQtZGH3j.xjVhVMmteriwivXySy', '2', NULL, 'H8pwwEIXx8', '2025-09-14 02:11:54', '2025-09-14 02:11:54', '01500000010', '34 Hill Rd, Rajshahi', NULL, 'male', NULL, NULL),
(7395, 'User 15', 'user15@example.com', NULL, '$2y$12$9ggkXGxC4SUW7Ymy2ZPWmup8gpZu4SVgyZY2PtPmsbx1pvjzW5Raa', '2', NULL, 'FuOgR5LJux', '2025-09-14 02:11:56', '2025-09-14 02:11:56', '01760000006', '56 Beach St, Barishal', NULL, 'male', NULL, NULL),
(7649, 'User 8', 'user8@example.com', NULL, '$2y$12$QVyedEiSpV6DohCphNPhwulb.oJY9IdZcm3SexuxABzVItuSWDRQ6', '2', NULL, 'HYJMCPuQdj', '2025-09-14 02:11:54', '2025-09-14 02:11:54', '01820000002', '56 Beach St, Barishal', NULL, 'male', NULL, NULL),
(8094, 'test User', 'test@gmail.com', NULL, '$2y$12$iWvDTuDajVVFbPLEksKSveyODlTr4OFAYGh1sBOaOqTLGKCR3/azu', '2', '0', NULL, '2025-09-14 02:19:37', '2025-09-14 02:19:37', NULL, NULL, NULL, NULL, NULL, NULL),
(8452, 'User 10', 'user10@example.com', NULL, '$2y$12$ymR7uZ4p.l/yoXGuwcFB4eX2sLokJaG/AUKA8ojz/2viDstdN92TS', '2', NULL, '2CCgqprNBj', '2025-09-14 02:11:55', '2025-09-14 02:11:55', '01550000005', '12 River St, Khulna', NULL, 'female', NULL, NULL),
(8489, 'User 3', 'user3@example.com', NULL, '$2y$12$82x49FC53uit0yuMY8GJ8.fvMZPxOICFye6EUvMwaweqskD2uPPcG', '2', NULL, 'YY672fFb42', '2025-09-14 02:11:53', '2025-09-14 02:11:53', '01820000002', '34 Hill Rd, Rajshahi', NULL, 'male', NULL, NULL),
(8663, 'User 1', 'user1@example.com', NULL, '$2y$12$Jokj8C5od.tz4bm/fi1uaOIOEUb/iUHPywAyq2Fv5bGMH1VbU0G1G', '2', NULL, '7b4UYxU6W0', '2025-09-14 02:11:53', '2025-09-14 02:11:53', '01500000010', '56 Beach St, Barishal', NULL, 'female', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bookings_room_id_foreign` (`room_id`),
  ADD KEY `bookings_status_check_in_date_index` (`status`,`check_in_date`),
  ADD KEY `bookings_user_id_status_index` (`user_id`,`status`),
  ADD KEY `bookings_guest_email_status_index` (`guest_email`,`status`),
  ADD KEY `bookings_payment_status_index` (`payment_status`),
  ADD KEY `bookings_created_at_index` (`created_at`);

--
-- Indexes for table `booking_payments`
--
ALTER TABLE `booking_payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `booking_payments_booking_id_foreign` (`booking_id`);

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
-- Indexes for table `right`
--
ALTER TABLE `right`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role_right`
--
ALTER TABLE `role_right`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `rooms_room_number_unique` (`room_number`);

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
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `booking_payments`
--
ALTER TABLE `booking_payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `right`
--
ALTER TABLE `right`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=97;

--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `role_right`
--
ALTER TABLE `role_right`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=319;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9902;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_room_id_foreign` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `bookings_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `booking_payments`
--
ALTER TABLE `booking_payments`
  ADD CONSTRAINT `booking_payments_booking_id_foreign` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
