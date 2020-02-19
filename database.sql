-- phpMyAdmin SQL Dump
-- version 5.0.0-alpha1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 19, 2020 at 04:08 PM
-- Server version: 8.0.18
-- PHP Version: 7.4.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rolpta`
--

-- --------------------------------------------------------

--
-- Table structure for table `dispatchers`
--

CREATE TABLE `dispatchers` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `envelope` int(11) NOT NULL DEFAULT '1',
  `bag` int(11) NOT NULL DEFAULT '1',
  `sack` int(11) NOT NULL DEFAULT '1',
  `state` int(11) NOT NULL DEFAULT '1',
  `intrastate` int(11) NOT NULL DEFAULT '1',
  `abroad` int(11) NOT NULL DEFAULT '1',
  `vehicle` varchar(200) DEFAULT 'Car',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `dispatchers`
--

INSERT INTO `dispatchers` (`id`, `user_id`, `envelope`, `bag`, `sack`, `state`, `intrastate`, `abroad`, `vehicle`, `created_at`, `updated_at`) VALUES
(1, 3, 1, 1, 1, 1, 0, 1, '', NULL, '2020-01-26 21:33:06'),
(2, 12, 1, 1, 0, 1, 1, 0, 'Toyota Camry ', NULL, NULL),
(3, 13, 1, 1, 1, 1, 1, 1, 'Corolla', NULL, NULL),
(5, 18, 1, 1, 1, 1, 1, 1, 'Car', NULL, NULL),
(6, 19, 1, 1, 1, 1, 1, 1, 'Car', NULL, NULL),
(7, 21, 1, 1, 1, 1, 1, 1, 'Car', NULL, NULL),
(8, 28, 1, 1, 1, 1, 0, 1, 'Corolla', '2020-01-22 07:07:52', '2020-01-22 11:55:14'),
(9, 5, 1, 1, 1, 1, 1, 1, 'Car', '2020-01-22 09:14:01', '2020-01-22 09:14:01'),
(12, 32, 1, 1, 1, 1, 1, 1, 'Car', '2020-01-27 07:49:40', '2020-01-27 07:49:40');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2020_01_08_205637_create_users_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `hash` varchar(191) DEFAULT NULL,
  `package` enum('envelope','bag','sack','') NOT NULL DEFAULT 'envelope',
  `description` varchar(191) NOT NULL,
  `items` int(11) NOT NULL,
  `paywith` enum('card','cash','','') NOT NULL DEFAULT 'card',
  `p_lat` varchar(50) NOT NULL DEFAULT '',
  `p_lng` varchar(50) NOT NULL DEFAULT '',
  `p_lat2` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `p_lng2` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `p_gaddress` text NOT NULL,
  `p_address` text NOT NULL,
  `p_city` varchar(255) NOT NULL DEFAULT '',
  `p_state` varchar(255) NOT NULL DEFAULT '',
  `p_country` varchar(255) NOT NULL DEFAULT '',
  `p_place` varchar(191) NOT NULL DEFAULT '',
  `d_lat` varchar(50) NOT NULL DEFAULT '',
  `d_lng` varchar(50) NOT NULL DEFAULT '',
  `d_lat2` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `d_lng2` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `d_gaddress` text NOT NULL,
  `d_address` text NOT NULL,
  `d_city` varchar(255) NOT NULL DEFAULT '',
  `d_state` varchar(255) DEFAULT '',
  `d_country` varchar(255) NOT NULL DEFAULT '',
  `d_place` varchar(191) NOT NULL DEFAULT '',
  `miles` decimal(11,2) DEFAULT NULL,
  `kilo` decimal(11,2) DEFAULT NULL,
  `price` decimal(11,2) DEFAULT NULL,
  `base_price` decimal(11,2) DEFAULT NULL,
  `pkg_price` decimal(11,2) DEFAULT NULL,
  `category` varchar(50) NOT NULL DEFAULT '',
  `r_name` varchar(100) NOT NULL DEFAULT '',
  `r_phone` varchar(100) NOT NULL DEFAULT '',
  `r_dispatch` enum('eod','sod','','') NOT NULL DEFAULT 'eod',
  `r_avatar` varchar(191) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'no_user.png',
  `r_avatar2` varchar(191) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'no_user.png',
  `disp_req` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `message` varchar(255) DEFAULT 'Fetching message...',
  `reference` varchar(255) DEFAULT 'Fetching message...',
  `disp_id` int(11) DEFAULT '0',
  `tstate` int(11) NOT NULL DEFAULT '0',
  `ostate` int(11) NOT NULL DEFAULT '0',
  `status` int(11) NOT NULL DEFAULT '0',
  `rate_r` int(11) NOT NULL DEFAULT '0',
  `rate_d` int(11) NOT NULL DEFAULT '0',
  `comment_r` varchar(255) DEFAULT '',
  `comment_d` varchar(255) DEFAULT '',
  `scan` varchar(191) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'no_product.png',
  `accepted_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `scan_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `paid_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `hash`, `package`, `description`, `items`, `paywith`, `p_lat`, `p_lng`, `p_lat2`, `p_lng2`, `p_gaddress`, `p_address`, `p_city`, `p_state`, `p_country`, `p_place`, `d_lat`, `d_lng`, `d_lat2`, `d_lng2`, `d_gaddress`, `d_address`, `d_city`, `d_state`, `d_country`, `d_place`, `miles`, `kilo`, `price`, `base_price`, `pkg_price`, `category`, `r_name`, `r_phone`, `r_dispatch`, `r_avatar`, `r_avatar2`, `disp_req`, `message`, `reference`, `disp_id`, `tstate`, `ostate`, `status`, `rate_r`, `rate_d`, `comment_r`, `comment_d`, `scan`, `accepted_at`, `scan_at`, `created_at`, `updated_at`, `paid_at`) VALUES
(1, 1, '0000001', 'envelope', 'woq', 5, 'card', '6.5903429', '3.3422758', '6.5243793', '3.3792057', 'Ikeja General Hospital Road, Ikeja GRA, Lagos, Nigeria', 'Ikeja General Hospital Road, Ikeja GRA, Lagos, Nigeria', 'Lagos', 'Lagos', 'Nigeria', 'ChIJZ1WzviGSOxARREmS-UqU9MA', '6.597303699999999', '3.3904469', '6.5243793', '3.3792057', '41 Demurin St, Mile 12, Lagos, Nigeria', '41 Demurin St, Mile 12, Lagos, Nigeria', 'Lagos', 'Lagos', 'Nigeria', 'EiY0MSBEZW11cmluIFN0LCBNaWxlIDEyLCBMYWdvcywgTmlnZXJpYSIaEhgKFAoSCUfWXcHvkjsQEdgVIQxNJZrhECk', '3.34', '5.38', '250.50', '250.50', '0.00', 'intrastate', 'Tunji', '+234566345345', 'sod', 'no_user.png', 'no_user.png', '2020-01-28 20:48:51', 'Ojo Fadipe needs to be rated', 'Fetching message...', 3, 15, 15, 1, 5, 5, '', '', 'package_1_1580244581_3.png', '2020-01-28 20:49:09', '2020-01-28 20:48:11', '2020-01-28 20:48:11', '2020-01-28 20:54:06', '2020-01-28 20:48:11'),
(2, 1, '0000002', 'envelope', 'lol', 4, 'card', '6.5568767999999995', '3.3693695999999997', '', '', 'Anthony OKE, Obanikoro, Lagos, Nigeria', 'Anthony OKE, Obanikoro, Lagos, Nigeria', 'Lagos', 'Lagos', 'Nigeria', 'ChIJzfDXXYWNOxAR3LCh8mQ-wow', '6.5568767999999995', '3.3693695999999997', '', '', 'Anthony OKE, Obanikoro, Lagos, Nigeria', 'Anthony OKE, Obanikoro, Lagos, Nigeria', 'Lagos', 'Lagos', 'Nigeria', 'ChIJzfDXXYWNOxAR3LCh8mQ-wow', '0.00', '0.00', '200.00', '200.00', '0.00', 'intrastate', 'Tony', '07030290746', 'sod', 'no_user.png', 'no_user.png', '2020-01-28 20:54:09', 'Fetching message...', 'Fetching message...', 0, 0, 5, 0, 0, 0, '', '', 'no_product.png', '2020-01-28 20:54:09', '2020-01-28 20:54:09', '2020-01-28 20:54:09', '2020-02-16 15:02:35', '2020-01-28 20:54:09');

-- --------------------------------------------------------

--
-- Table structure for table `positions`
--

CREATE TABLE `positions` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `lat` varchar(50) NOT NULL DEFAULT '7.4039293',
  `lng` varchar(50) NOT NULL DEFAULT '3.9247403',
  `city` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `state` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `country` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `locked` int(11) DEFAULT '0',
  `status` int(11) NOT NULL DEFAULT '0',
  `active` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `positions`
--

INSERT INTO `positions` (`id`, `user_id`, `lat`, `lng`, `city`, `state`, `country`, `locked`, `status`, `active`, `created_at`, `updated_at`) VALUES
(1, 1, '6.5779976', '3.3288193', 'Ikeja', 'Lagos', 'Nigeria', 0, 0, '2020-02-17 16:04:16', '2019-12-18 16:33:52', '2020-02-17 16:04:16'),
(3, 3, '6.3419926', '7.184414', 'Agba Umana', 'Enugu', 'Nigeria', 0, 0, '2020-02-19 04:54:39', '2019-12-16 06:39:46', '2020-02-19 04:54:39'),
(4, 4, '6.5406908', '3.2787928', 'Lagos', 'Lagos', 'Nigeria', 0, 0, '2020-01-16 06:35:01', '2019-12-16 12:52:30', '2019-12-16 12:52:30'),
(5, 5, '6.5492772', '3.2375404', 'London', 'London', 'United Kingdom', 0, 0, '2019-12-25 19:52:10', '2019-12-25 19:41:49', '2019-12-25 19:41:49'),
(7, 7, '6.5492772', '3.2375404', 'London', 'London', 'United Kingdom', 0, 0, '2019-12-25 19:52:10', '2019-12-25 19:41:49', '2019-12-25 19:41:49'),
(8, 8, '6.5406908', '3.2787928', 'Lagos', 'Lagos', 'Nigeria', 0, 0, '2020-01-13 15:08:13', '2019-12-16 12:01:09', '2019-12-16 12:01:09'),
(9, 9, '6.5492772', '3.2375404', 'London', 'London', 'United Kingdom', 0, 0, '2019-12-25 19:52:10', '2019-12-25 19:41:49', '2019-12-25 19:41:49'),
(10, 10, '6.5492772', '3.2375404', 'London', 'London', 'United Kingdom', 0, 0, '2019-12-25 19:52:10', '2019-12-25 19:41:49', '2019-12-25 19:41:49'),
(11, 11, '6.5492772', '3.2375404', 'London', 'London', 'United Kingdom', 0, 0, '2019-12-25 19:52:10', '2019-12-25 19:41:49', '2019-12-25 19:41:49'),
(12, 12, '6.5855042', '3.3724704', 'Lagos', 'Lagos', 'Nigeria', 0, 0, '2020-01-19 00:15:04', '2019-12-16 12:52:30', '2019-12-16 12:52:30'),
(13, 13, '6.5492772', '3.2375404', 'London', 'London', 'United Kingdom', 0, 0, '2019-12-25 11:38:49', '2019-12-17 19:39:15', '2019-12-17 19:39:15'),
(14, 14, '6.5406908', '3.2787928', 'Lagos', 'Lagos', 'Nigeria', 0, 0, '2020-01-15 03:38:24', '2019-12-20 01:56:04', '2019-12-20 01:56:04'),
(17, 17, '6.5406908', '3.2787928', 'Lagos', 'Lagos', 'Nigeria', 0, 0, '2020-01-18 23:52:42', '2020-01-01 13:31:52', '2020-01-01 13:31:52'),
(18, 18, '6.355869673181331', '7.185237411843445', 'Agba Umana', 'Enugu', 'Nigeria', 0, 0, '2020-01-06 05:00:10', '2020-01-05 21:55:05', '2020-01-05 21:55:05'),
(19, 19, '6.5855042', '3.3724704', 'Lagos', 'Lagos', 'Nigeria', 0, 0, '2020-01-15 03:38:24', '2020-01-12 01:56:43', '2020-01-12 01:56:43'),
(20, 20, '6.5406908', '3.2787928', 'Lagos', 'Lagos', 'Nigeria', 0, 0, '2020-01-14 03:29:31', '2020-01-13 14:30:11', '2020-01-13 14:30:11'),
(21, 21, '6.5855042', '3.3724704', 'Lagos', 'Lagos', 'Nigeria', 0, 0, '2020-01-13 15:27:05', '2020-01-13 14:37:19', '2020-01-13 14:37:19'),
(22, 22, '6.5406908', '3.2787928', 'Lagos', 'Lagos', 'Nigeria', 0, 0, '2020-01-14 06:42:50', '2020-01-13 14:39:45', '2020-01-13 14:39:45'),
(23, 26, '6.5243793', '3.3792057', 'Lagos', 'Lagos', 'Nigeria', 0, 0, '2020-01-26 19:55:34', '2020-01-21 19:17:42', '2020-01-26 19:55:34'),
(24, 28, '6.5779976', '3.3288193', 'Lagos', 'Lagos', 'Nigeria', 1, 0, '2020-02-19 02:47:13', '2020-01-22 06:53:39', '2020-02-19 02:47:13'),
(27, 32, '6.5243793', '3.3792057', 'Lagos', 'Lagos', 'Nigeria', 0, 0, '2020-01-27 12:03:15', '2020-01-27 07:49:40', '2020-01-27 12:03:15');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `actype` enum('requester','dispatcher','','') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'requester',
  `first` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `phone` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `phone_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `token` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `code` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `address` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `online` int(11) DEFAULT '1',
  `status` int(11) DEFAULT '0',
  `order_id` int(11) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `avatar` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'no_user.png'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `actype`, `first`, `last`, `email`, `email_verified_at`, `phone`, `phone_verified_at`, `password`, `token`, `code`, `address`, `online`, `status`, `order_id`, `created_at`, `updated_at`, `avatar`) VALUES
(1, 'requester', 'Adewale', 'Ogundipe', 'wale@africoders.com', '2019-12-27 06:52:33', '+2347030290746', NULL, '$2y$10$0TVy24fUm88GnMpBoZryouflJS/xyKOCHeByfKC/6KiYxoz5g9pNS', 'mB9t24pbMHBIWPTHVFCJjptYPL5W78iQgZVZukXI', '', 'Alimosho', 1, 1, 2, '2019-12-13 00:02:31', '2020-01-28 20:54:09', 'avatar_1_1579782211_3.png'),
(3, 'dispatcher', 'Ojo', 'Fadipe', 'ojo@africoders.com', '2019-12-13 00:10:35', '+2348120755515', NULL, '$2y$10$Df9D9Muydv03F/GeJEwVIuU.2xFC00oK5eRLMqT5TkmNlnKXzta1O', 'opvxuevdtSmnlYtI5jUXpjiTlahsatCFdtKWICHF', '', 'Ilepo Street', 1, 1, 0, '2019-12-13 00:10:21', '2020-02-03 04:57:17', 'avatar_3_1580705835_3.png'),
(4, 'requester', 'Ilyas', 'Isiaka', 'linarconsult@gmail.com', '2020-01-01 11:55:45', '08182420675', NULL, '$2y$10$kQGraKRnF.4.Bdek2XNsN.TkMDnfBXrU9jd4JM/swwuT/sfGFz0WS', 'tbugpx12z0E5UE6pPUCIUmYECGeYVoC6fIBUN1aM', '', '13 bamidele street', 1, 1, 0, '2019-12-13 09:37:44', '2020-01-21 16:18:54', 'no_user.png'),
(5, 'dispatcher', 'Semiu ', 'Daramola ', 'semightdemy@gmail.com', NULL, '07032423200', NULL, '$2y$10$vH36YMx2l5tnnoB4pEpeOeb0V7sAJg1OIn6caAv4rSzHSHE0wRrkm', '0KKcTO7vveh0a3nFWnuZnhjEOk3v8CmIyng6tdSv', '', NULL, 1, 0, 0, '2019-12-13 09:40:52', '2020-01-21 16:18:54', 'no_user.png'),
(7, 'requester', 'Emmanual', 'Adenuga', 'ema@africoders.com', NULL, '+2347030290746', NULL, '$2y$10$d8t6EhMrJLFsBP5FsC6MGe8uAoN8R6KAHf9gsYb9aGiecQB0zNzLW', 'K9CC1dY44ydQPkM3FWWtywh2GkBfWdlgNzvJhxC1', '', NULL, 1, 0, 0, '2019-12-13 10:05:37', '2020-01-21 16:18:54', 'no_user.png'),
(8, 'requester', 'Yusuf', 'Kolapo', 'ayindenani@gmail.com', '2020-01-13 14:59:40', '08063619930', NULL, '$2y$10$wYzYAB9yz87uMCw1IiU8HeEoRL8dhfuGVuezqF7fSh3SGAL/lpEVu', 'NhQ0e2k5PnX3XepEFNR4XltLk238w6I6hF0mbnvw', '', 'Plot 12 Amsat street \r\nIbadan \r\nNigeria ', 1, 1, 0, '2019-12-14 04:20:51', '2020-01-21 16:18:54', 'no_user.png'),
(9, 'requester', 'Semiu ', 'Daramola ', 'semiudaramola@gmail.com', '2019-12-14 04:36:53', '08030789283', NULL, '$2y$10$DjbVP6qoAIaKyEA5km6jA.BcgCyjsHQVH/KoT4xnSiueSKVTzvqZe', 'VAbLBNrchExz6W1yA5G2JjQpRkzc06ol1pj2zoQg', '', NULL, 1, 1, 0, '2019-12-14 04:36:41', '2020-01-21 16:18:54', 'no_user.png'),
(10, 'requester', 'Ade', 'Lola', 'adeiyiakala91@gmail.com', NULL, '08180098967', NULL, '$2y$10$fkNx65wt1U/7S.Togs0nTuLqyG2khTKYnuwgZ.DXZ37cMbtcBVCqW', 'RNPSsuglPovUyPtsOvuWThGisq16eunx6gcYHBsa', '', NULL, 1, 0, 0, '2019-12-15 17:39:25', '2020-01-21 16:18:54', 'no_user.png'),
(11, 'requester', 'Tola', 'Velo', 'adeniyi.a@ibakatv.com', NULL, '08180009938', NULL, '$2y$10$oNosNBKAlvJ9FOQB5On.ve3yqphvEqs1faoIBspYCgLd/HxV9FP/S', 'H2dMFiSfayGZnnOErrZ68vFbAKmq8lwpELpvXsEs', '', NULL, 1, 0, 0, '2019-12-15 17:50:08', '2020-01-21 16:18:54', 'no_user.png'),
(12, 'dispatcher', 'Baba', 'Alakin', 'ibdara2@gmail.com', '2019-12-16 12:52:24', '08030789283', NULL, '$2y$10$woCnPLh8t8nyndwWs64ZqecM8/fRYUYq/oJrptkyX8qxOEkfIkLh.', 'dEaAWMloxzcfjwOxqHQleCbyHncaRfoXUeJ6Vcmx', '', '20 Adebisi street \r\nIbadan \r\nNigeria ', 1, 1, 0, '2019-12-16 12:52:09', '2020-01-21 16:18:54', 'no_user.png'),
(13, 'dispatcher', 'Sam', 'Ily', 'shittusamiat@gmail.com', NULL, '08136871295', NULL, '$2y$10$nTN71N6fq.sbS7ZvsGaj.ejynQVCg9uyyhv4OS8Rfd6WxrcxLFJty', 'IMFYhlzdxrCsNkuNxIzGQrekN2PMmpU4zmJzjBUm', '', NULL, 1, 0, 0, '2019-12-17 19:39:10', '2020-01-21 16:18:54', 'no_user.png'),
(14, 'requester', 'Deji', 'Azeez', 'taofeeqnaija@gmail.com', '2019-12-20 02:01:07', '08052941785', NULL, '$2y$10$DhmZKSd1GT6hncra.KP/MemDJaxLKWxdvvbqWLc2iFHG/zKyxMJfm', 'f7bppbScwSShET1Szmrz8Dy6RlWncAQ1lQVIeSTD', '', 'No. 4, Ifelodun-Ayetoro Street, Dalemo-Ayekale, via Oremeji-Agugu, Ibadan, Oyo State, Nigeria', 1, 1, 0, '2019-12-20 01:55:54', '2020-01-21 16:18:54', 'no_user.png'),
(17, 'requester', 'Adijatu', 'Daramola ', 'adijatudaramola@gmail.com', '2020-01-01 13:36:51', '07032423200', NULL, '$2y$10$PJMKVf/sM.Gs7YqXJzmPUuNfCmvJNqzjIUi1hjjuUXIZ03aDhBxmu', 'oSGUF9gGr8I8SE9bSKVRxMv0k3y5fc7xxIaKbuli', '', NULL, 1, 1, 0, '2020-01-01 13:31:52', '2020-01-21 16:18:54', 'no_user.png'),
(18, 'dispatcher', 'Ilyas', 'Isiaka', 'ilyasisiaka@gmail.com', '2020-01-05 21:56:43', '080865436nv', NULL, '$2y$10$LqAN4Y23A01JsfajTcirM.z.0.WpYdbjFJopnAVuvQWer6/9F0ney', 'HzJ0c5Rchynt234EzWTUn7SO5wp0KN9niOwmPX1l', '', NULL, 1, 1, 0, '2020-01-05 21:55:05', '2020-01-21 16:18:54', 'no_user.png'),
(19, 'dispatcher', 'Deji', 'Azeez', 'mrtaofeeqazeez@gmail.com', '2020-01-12 01:57:38', '07065533549', NULL, '$2y$10$K/7THNsqMFJOAan.imryJuSeawgE5r..ZsK2OPsO8KyLn6zAT908u', 'GnFa5lq8bvSosxHNDxUZCr5yxP5k6fOD5QTDvZnb', '', NULL, 1, 1, 0, '2020-01-12 01:56:43', '2020-01-21 16:18:54', 'no_user.png'),
(20, 'requester', 'Asorona', 'Sekinat', 'sekmight@gmail.com', '2020-01-13 14:40:16', '07083802652', NULL, '$2y$10$Kxl1/7YbMOWWGbxtFVFufe.QWDYDC/Ii0cb0GUEowGGCILPJACxP2', 'fA9tFMrsu1KTzithlK9YCUM3wtxyCspDZDoX0AUn', '', NULL, 1, 1, 0, '2020-01-13 14:30:11', '2020-01-21 16:18:54', 'no_user.png'),
(21, 'dispatcher', 'Daramola', 'Alli', 'daramolaalliolagoke05@gmail.com', '2020-01-13 15:19:54', '08086272392', NULL, '$2y$10$4rrgpgzwt05gou4ZKnAy6u9uxeLnFZzJg39tjykOmBTIH6HLMM/Fe', 'as5wZUtys7DxrtSxS0qRgZwN8qbSeoUqaSemsvwb', '', NULL, 1, 1, 0, '2020-01-13 14:37:19', '2020-01-21 16:18:54', 'no_user.png'),
(22, 'requester', 'Daramola', 'Alli', 'daramolaalli55@gmail.com', '2020-01-13 15:24:17', '08086272392', NULL, '$2y$10$SDkOXyCr40Q58jr6An149OxEBLdiIhooOX4iTNFJVpWPhZdqbqOwe', '9wNP38LH6ZlKlh5GNfZ8yZdt0p9JLVcWHKjOYlvo', '', NULL, 1, 1, 0, '2020-01-13 14:39:45', '2020-01-21 16:18:54', 'no_user.png'),
(26, 'requester', 'Tito', 'Oladeji', 'diltony@yahoo.com', NULL, '+2347030290744', NULL, '$2y$10$byVjrPA1eB8iGW2EkqYWBeYf1XCvDN1LyMm0JTljAJXk0/IcHCRue', '9wNP38LH6ZlKlh5GNfZ8yZdt0p9JLVcWHKjO1356', '', NULL, 1, 1, 0, '2020-01-21 16:39:59', '2020-01-26 18:36:58', 'no_user.png'),
(28, 'dispatcher', 'Ifeanyi', 'Ibe Chukwu', 'ifeanyi@africoders.com', NULL, '083453452345', NULL, '$2y$10$lR8X9fpoxc3rH.bFPt.1AOxDDJyx0qwAhauOUupv7Cjag5SHu5/ce', 'cFkckN2oA3NsdUeEpXk8tCoxWk0HdM8Ir5aJXE7h', '', NULL, 1, 1, 0, '2020-01-22 06:53:14', '2020-01-23 21:55:56', 'avatar_28_1579781399_3.png'),
(32, 'dispatcher', 'Waliu', 'Ogundipe', 'wale@africoders.com', NULL, '07030290746', NULL, '$2y$10$oB/GIdejzp5FZ84ubLi6hOd/Z84bZYAOXxQpVb6gjO6yL7.g0Nh0S', 'htcgOBeFE91RLtJa1MrcNBKV49ptKaSmynD26VVd', '', NULL, 1, 1, 0, '2020-01-27 07:49:40', '2020-01-27 08:25:58', 'no_user.png');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `dispatchers`
--
ALTER TABLE `dispatchers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `dkid` (`user_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `odkid` (`user_id`);

--
-- Indexes for table `positions`
--
ALTER TABLE `positions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pkid` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `dispatchers`
--
ALTER TABLE `dispatchers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `positions`
--
ALTER TABLE `positions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `dispatchers`
--
ALTER TABLE `dispatchers`
  ADD CONSTRAINT `dkid` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `odkid` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `positions`
--
ALTER TABLE `positions`
  ADD CONSTRAINT `pkid` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

