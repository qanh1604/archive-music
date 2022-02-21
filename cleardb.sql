-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 03, 2022 at 01:53 PM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ecommerce_demo`
--

-- --------------------------------------------------------

--
-- Table structure for table `addons`
--

CREATE TABLE `addons` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf32_unicode_ci DEFAULT NULL,
  `unique_identifier` varchar(255) COLLATE utf32_unicode_ci DEFAULT NULL,
  `version` varchar(255) COLLATE utf32_unicode_ci DEFAULT NULL,
  `activated` int(1) NOT NULL DEFAULT '1',
  `image` varchar(1000) COLLATE utf32_unicode_ci DEFAULT NULL,
  `purchase_code` varchar(255) COLLATE utf32_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `addresses`
--

CREATE TABLE `addresses` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `country_id` int(11) DEFAULT NULL,
  `state_id` int(11) NOT NULL,
  `city_id` int(11) DEFAULT NULL,
  `longitude` float DEFAULT NULL,
  `latitude` float DEFAULT NULL,
  `postal_code` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `set_default` int(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `affiliate_configs`
--

CREATE TABLE `affiliate_configs` (
  `id` int(11) NOT NULL,
  `type` varchar(1000) COLLATE utf32_unicode_ci DEFAULT NULL,
  `value` text COLLATE utf32_unicode_ci,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_unicode_ci;

--
-- Table structure for table `affiliate_logs`
--

CREATE TABLE `affiliate_logs` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `guest_id` int(11) DEFAULT NULL,
  `referred_by_user` int(11) NOT NULL,
  `amount` double(20,2) NOT NULL,
  `order_id` bigint(20) DEFAULT NULL,
  `order_detail_id` bigint(20) DEFAULT NULL,
  `affiliate_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `affiliate_options`
--

CREATE TABLE `affiliate_options` (
  `id` int(11) NOT NULL,
  `type` varchar(255) COLLATE utf32_unicode_ci DEFAULT NULL,
  `details` longtext COLLATE utf32_unicode_ci,
  `percentage` double NOT NULL DEFAULT '0',
  `status` int(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `affiliate_payments`
--

CREATE TABLE `affiliate_payments` (
  `id` int(11) NOT NULL,
  `affiliate_user_id` int(11) NOT NULL,
  `amount` double(8,2) NOT NULL,
  `payment_method` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `payment_details` longtext COLLATE utf8_unicode_ci,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `affiliate_stats`
--

CREATE TABLE `affiliate_stats` (
  `id` int(11) NOT NULL,
  `affiliate_user_id` int(11) NOT NULL,
  `no_of_click` int(11) NOT NULL DEFAULT '0',
  `no_of_order_item` int(11) NOT NULL DEFAULT '0',
  `no_of_delivered` int(11) NOT NULL DEFAULT '0',
  `no_of_cancel` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `affiliate_users`
--

CREATE TABLE `affiliate_users` (
  `id` int(11) NOT NULL,
  `paypal_email` varchar(255) COLLATE utf32_unicode_ci DEFAULT NULL,
  `bank_information` text COLLATE utf32_unicode_ci,
  `user_id` int(11) NOT NULL,
  `informations` text COLLATE utf32_unicode_ci,
  `balance` double(10,2) NOT NULL DEFAULT '0.00',
  `status` int(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_unicode_ci;

--
-- Table structure for table `affiliate_withdraw_requests`
--

CREATE TABLE `affiliate_withdraw_requests` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `amount` double(10,2) NOT NULL,
  `status` int(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Table structure for table `app_translations`
--

CREATE TABLE `app_translations` (
  `id` int(11) NOT NULL,
  `lang` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `lang_key` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `lang_value` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `attributes`
--

CREATE TABLE `attributes` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf32_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `attribute_category`
--

CREATE TABLE `attribute_category` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `attribute_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `attribute_translations`
--

CREATE TABLE `attribute_translations` (
  `id` bigint(20) NOT NULL,
  `attribute_id` bigint(20) NOT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `lang` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `attribute_values`
--

CREATE TABLE `attribute_values` (
  `id` int(11) NOT NULL,
  `attribute_id` int(11) NOT NULL,
  `value` varchar(255) NOT NULL,
  `color_code` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `auction_product_bids`
--

CREATE TABLE `auction_product_bids` (
  `id` int(11) NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `amount` double(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Table structure for table `blogs`
--

CREATE TABLE `blogs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `short_description` text COLLATE utf8mb4_unicode_ci,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `banner` int(11) DEFAULT NULL,
  `meta_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_img` int(11) DEFAULT NULL,
  `meta_description` text COLLATE utf8mb4_unicode_ci,
  `meta_keywords` text COLLATE utf8mb4_unicode_ci,
  `status` int(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Table structure for table `blog_categories`
--

CREATE TABLE `blog_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `logo` varchar(100) DEFAULT NULL,
  `top` int(1) NOT NULL DEFAULT '0',
  `slug` varchar(255) DEFAULT NULL,
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_description` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Table structure for table `brand_translations`
--

CREATE TABLE `brand_translations` (
  `id` bigint(20) NOT NULL,
  `brand_id` bigint(20) NOT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `lang` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Table structure for table `business_settings`
--

CREATE TABLE `business_settings` (
  `id` int(11) NOT NULL,
  `type` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `value` longtext COLLATE utf8_unicode_ci,
  `lang` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `business_settings`
--

INSERT INTO `business_settings` (`id`, `type`, `value`, `lang`, `created_at`, `updated_at`) VALUES
(1, 'home_default_currency', '1', NULL, '2018-10-16 01:35:52', '2019-01-28 01:26:53'),
(2, 'system_default_currency', '1', NULL, '2018-10-16 01:36:58', '2020-01-26 04:22:13'),
(3, 'currency_format', '1', NULL, '2018-10-17 03:01:59', '2018-10-17 03:01:59'),
(4, 'symbol_format', '1', NULL, '2018-10-17 03:01:59', '2019-01-20 02:10:55'),
(5, 'no_of_decimals', '3', NULL, '2018-10-17 03:01:59', '2020-03-04 00:57:16'),
(6, 'product_activation', '1', NULL, '2018-10-28 01:38:37', '2019-02-04 01:11:41'),
(7, 'vendor_system_activation', '1', NULL, '2018-10-28 07:44:16', '2019-02-04 01:11:38'),
(8, 'show_vendors', '1', NULL, '2018-10-28 07:44:47', '2019-02-04 01:11:13'),
(9, 'paypal_payment', '1', NULL, '2018-10-28 07:45:16', '2021-02-11 06:53:14'),
(10, 'stripe_payment', '1', NULL, '2018-10-28 07:45:47', '2021-02-11 06:53:15'),
(11, 'cash_payment', '1', NULL, '2018-10-28 07:46:05', '2019-01-24 03:40:18'),
(12, 'payumoney_payment', '0', NULL, '2018-10-28 07:46:27', '2019-03-05 05:41:36'),
(13, 'best_selling', '1', NULL, '2018-12-24 08:13:44', '2019-02-14 05:29:13'),
(14, 'paypal_sandbox', '1', NULL, '2019-01-16 12:44:18', '2021-02-11 06:51:01'),
(15, 'sslcommerz_sandbox', '1', NULL, '2019-01-16 12:44:18', '2019-03-14 00:07:26'),
(16, 'sslcommerz_payment', '1', NULL, '2019-01-24 09:39:07', '2021-02-11 06:53:16'),
(17, 'vendor_commission', '10', NULL, '2019-01-31 06:18:04', '2021-09-19 05:28:31'),
(18, 'verification_form', '[{\"type\":\"text\",\"label\":\"Your name\"},{\"type\":\"text\",\"label\":\"Shop name\"},{\"type\":\"text\",\"label\":\"Email\"},{\"type\":\"text\",\"label\":\"License No\"},{\"type\":\"text\",\"label\":\"Full Address\"},{\"type\":\"text\",\"label\":\"Phone Number\"},{\"type\":\"file\",\"label\":\"Tax Papers\"}]', NULL, '2019-02-03 11:36:58', '2019-02-16 06:14:42'),
(19, 'google_analytics', '0', NULL, '2019-02-06 12:22:35', '2019-02-06 12:22:35'),
(20, 'facebook_login', '0', NULL, '2019-02-07 12:51:59', '2019-02-08 19:41:15'),
(21, 'google_login', '0', NULL, '2019-02-07 12:52:10', '2019-02-08 19:41:14'),
(22, 'twitter_login', '0', NULL, '2019-02-07 12:52:20', '2019-02-08 02:32:56'),
(23, 'payumoney_payment', '1', NULL, '2019-03-05 11:38:17', '2019-03-05 11:38:17'),
(24, 'payumoney_sandbox', '1', NULL, '2019-03-05 11:38:17', '2019-03-05 05:39:18'),
(36, 'facebook_chat', '1', NULL, '2019-04-15 11:45:04', '2021-02-23 02:26:05'),
(37, 'email_verification', '1', NULL, '2019-04-30 07:30:07', '2021-02-14 07:00:35'),
(38, 'wallet_system', '1', NULL, '2019-05-19 08:05:44', '2021-02-14 07:00:29'),
(39, 'coupon_system', '1', NULL, '2019-06-11 09:46:18', '2021-02-15 05:01:54'),
(40, 'current_version', '5.5.5', NULL, '2019-06-11 09:46:18', '2019-06-11 09:46:18'),
(41, 'instamojo_payment', '1', NULL, '2019-07-06 09:58:03', '2021-02-11 06:53:17'),
(42, 'instamojo_sandbox', '1', NULL, '2019-07-06 09:58:43', '2019-07-06 09:58:43'),
(43, 'razorpay', '1', NULL, '2019-07-06 09:58:43', '2021-02-11 06:53:18'),
(44, 'paystack', '1', NULL, '2019-07-21 13:00:38', '2021-02-11 06:53:19'),
(45, 'pickup_point', '1', NULL, '2019-10-17 11:50:39', '2021-02-25 22:34:52'),
(46, 'maintenance_mode', '0', NULL, '2019-10-17 11:51:04', '2019-10-17 11:51:04'),
(47, 'voguepay', '1', NULL, '2019-10-17 11:51:24', '2021-02-11 06:53:20'),
(48, 'voguepay_sandbox', '1', NULL, '2019-10-17 11:51:38', '2021-02-11 06:51:19'),
(50, 'category_wise_commission', '0', NULL, '2020-01-21 07:22:47', '2021-09-19 05:28:40'),
(51, 'conversation_system', '1', NULL, '2020-01-21 07:23:21', '2020-01-21 07:23:21'),
(52, 'guest_checkout_active', '1', NULL, '2020-01-22 07:36:38', '2020-01-22 07:36:38'),
(53, 'facebook_pixel', '0', NULL, '2020-01-22 11:43:58', '2020-01-22 11:43:58'),
(55, 'classified_product', '1', NULL, '2020-05-13 13:01:05', '2021-02-15 05:01:46'),
(56, 'pos_activation_for_seller', '1', NULL, '2020-06-11 09:45:02', '2020-06-11 09:45:02'),
(57, 'shipping_type', 'product_wise_shipping', NULL, '2020-07-01 13:49:56', '2020-07-01 13:49:56'),
(58, 'flat_rate_shipping_cost', '0', NULL, '2020-07-01 13:49:56', '2020-07-01 13:49:56'),
(59, 'shipping_cost_admin', '0', NULL, '2020-07-01 13:49:56', '2020-07-01 13:49:56'),
(60, 'payhere_sandbox', '1', NULL, '2020-07-30 18:23:53', '2021-02-11 06:51:12'),
(61, 'payhere', '1', NULL, '2020-07-30 18:23:53', '2021-02-11 06:53:21'),
(62, 'google_recaptcha', '1', NULL, '2020-08-17 07:13:37', '2021-02-23 02:27:44'),
(63, 'ngenius', '1', NULL, '2020-09-22 10:58:21', '2021-02-11 06:53:22'),
(64, 'header_logo', '1000', NULL, '2020-11-16 07:26:36', '2021-03-09 03:00:19'),
(65, 'show_language_switcher', 'on', NULL, '2020-11-16 07:26:36', '2020-11-16 07:26:36'),
(66, 'show_currency_switcher', 'on', NULL, '2020-11-16 07:26:36', '2020-11-16 07:26:36'),
(67, 'header_stikcy', 'on', NULL, '2020-11-16 07:26:36', '2020-11-16 07:26:36'),
(68, 'footer_logo', '1000', NULL, '2020-11-16 07:26:36', '2021-03-09 03:00:08'),
(69, 'about_us_description', '<span style=\"color: rgb(242, 243, 248); font-family: \"Open Sans\", sans-serif; background-color: rgb(17, 23, 35);\">Complete system for your eCommerce business</span>', NULL, '2020-11-16 07:26:36', '2021-03-09 03:00:08'),
(70, 'contact_address', 'Demo', NULL, '2020-11-16 07:26:36', '2021-02-23 04:31:55'),
(71, 'contact_phone', '123456789', NULL, '2020-11-16 07:26:36', '2021-02-23 04:31:55'),
(72, 'contact_email', 'demo.example@gmail.com', NULL, '2020-11-16 07:26:36', '2021-02-23 04:31:55'),
(73, 'widget_one_labels', '[\"Help\",\"Support\",\"About Us\",\"Join Us\"]', NULL, '2020-11-16 07:26:36', '2021-03-09 01:06:24'),
(74, 'widget_one_links', '[\"#\",\"#\",\"#\",\"#\"]', NULL, '2020-11-16 07:26:36', '2021-03-09 01:06:12'),
(75, 'widget_one', 'Quick Links', NULL, '2020-11-16 07:26:36', '2021-03-09 01:06:12'),
(76, 'frontend_copyright_text', '© Active eCommerce CMS 2021', NULL, '2020-11-16 07:26:36', '2021-03-09 01:09:24'),
(77, 'show_social_links', 'on', NULL, '2020-11-16 07:26:36', '2021-03-09 01:08:51'),
(78, 'facebook_link', '#', NULL, '2020-11-16 07:26:36', '2021-03-09 01:08:51'),
(79, 'twitter_link', '#', NULL, '2020-11-16 07:26:36', '2021-03-09 01:08:51'),
(80, 'instagram_link', '#', NULL, '2020-11-16 07:26:36', '2021-03-09 01:08:51'),
(81, 'youtube_link', '#', NULL, '2020-11-16 07:26:36', '2021-03-09 01:08:51'),
(82, 'linkedin_link', '#', NULL, '2020-11-16 07:26:36', '2021-03-09 01:08:51'),
(83, 'payment_method_images', '999', NULL, '2020-11-16 07:26:36', '2021-03-09 01:08:51'),
(84, 'home_slider_images', '[\"1004\",\"1003\",\"1002\",\"1005\"]', NULL, '2020-11-16 07:26:36', '2021-03-09 03:15:22'),
(85, 'home_slider_links', '[\"https:\\/\\/codecanyon.net\\/item\\/active-ecommerce-cms\\/23471405?s_rank=14\",\"https:\\/\\/codecanyon.net\\/item\\/active-ecommerce-cms\\/23471405?s_rank=14\",\"https:\\/\\/codecanyon.net\\/item\\/active-ecommerce-cms\\/23471405?s_rank=14\",\"https:\\/\\/codecanyon.net\\/item\\/active-ecommerce-cms\\/23471405?s_rank=14\"]', NULL, '2020-11-16 07:26:36', '2021-03-09 03:15:22'),
(86, 'home_banner1_images', '[\"814\",\"813\",\"841\"]', NULL, '2020-11-16 07:26:36', '2021-03-09 03:08:37'),
(87, 'home_banner1_links', '[\"https:\\/\\/activeitzone.com\\/\",\"https:\\/\\/activeitzone.com\\/\",\"https:\\/\\/activeitzone.com\\/\"]', NULL, '2020-11-16 07:26:36', '2021-02-09 05:34:12'),
(88, 'home_banner2_images', '[\"845\",\"844\",\"842\"]', NULL, '2020-11-16 07:26:36', '2021-03-09 03:10:34'),
(89, 'home_banner2_links', '[\"https:\\/\\/activeitzone.com\\/\",\"https:\\/\\/activeitzone.com\\/\",\"https:\\/\\/activeitzone.com\\/\"]', NULL, '2020-11-16 07:26:36', '2021-02-09 05:34:24'),
(90, 'home_categories', '[\"1\",\"2\",\"3\",\"5\",\"8\"]', NULL, '2020-11-16 07:26:36', '2021-02-04 06:11:18'),
(91, 'top10_categories', '[\"1\",\"2\",\"3\",\"4\",\"5\",\"6\",\"7\",\"9\",\"10\",\"11\"]', NULL, '2020-11-16 07:26:36', '2021-02-09 05:35:30'),
(92, 'top10_brands', '[\"1\",\"2\",\"3\",\"4\",\"5\",\"6\",\"7\",\"8\",\"19\",\"20\"]', NULL, '2020-11-16 07:26:36', '2021-02-09 05:35:30'),
(93, 'website_name', 'Active eCommerce', NULL, '2020-11-16 07:26:36', '2021-03-09 03:01:24'),
(94, 'site_motto', 'Demo of Active eCommerce CMS', NULL, '2020-11-16 07:26:36', '2021-03-09 03:01:24'),
(95, 'site_icon', '1001', NULL, '2020-11-16 07:26:36', '2021-03-09 03:01:24'),
(96, 'base_color', '#e62e04', NULL, '2020-11-16 07:26:36', '2020-11-16 07:26:36'),
(97, 'base_hov_color', '#e62e04', NULL, '2020-11-16 07:26:36', '2020-11-16 07:26:36'),
(98, 'meta_title', 'Active eCommerce CMS', NULL, '2020-11-16 07:26:36', '2021-03-09 03:02:10'),
(99, 'meta_description', 'Demo of Active eCommerce CMS', NULL, '2020-11-16 07:26:36', '2021-03-09 03:02:10'),
(100, 'meta_keywords', NULL, NULL, '2020-11-16 07:26:36', '2020-11-16 07:26:36'),
(101, 'meta_image', NULL, NULL, '2020-11-16 07:26:36', '2020-11-16 07:26:36'),
(102, 'site_name', NULL, NULL, '2020-11-16 07:26:36', '2020-11-16 07:26:36'),
(103, 'system_logo_white', NULL, NULL, '2020-11-16 07:26:36', '2020-11-16 07:26:36'),
(104, 'system_logo_black', NULL, NULL, '2020-11-16 07:26:36', '2020-11-16 07:26:36'),
(105, 'timezone', NULL, NULL, '2020-11-16 07:26:36', '2020-11-16 07:26:36'),
(106, 'admin_login_background', '968', NULL, '2020-11-16 07:26:36', '2021-02-24 07:01:12'),
(107, 'iyzico_sandbox', '1', NULL, '2020-12-30 16:45:56', '2020-12-30 16:45:56'),
(108, 'iyzico', '1', NULL, '2020-12-30 16:45:56', '2020-12-30 16:45:56'),
(109, 'decimal_separator', '1', NULL, '2020-12-30 16:45:56', '2020-12-30 16:45:56'),
(110, 'nagad', '1', NULL, '2021-01-22 10:30:03', '2021-02-11 06:53:25'),
(111, 'bkash', '1', NULL, '2021-01-22 10:30:03', '2021-02-11 06:53:24'),
(112, 'bkash_sandbox', '1', NULL, '2021-01-22 10:30:03', '2021-01-22 10:30:03'),
(113, 'header_menu_labels', '[\"Home\",\"Flash Sale\",\"Blogs\",\"All Brands\",\"All Categories\",\"All Sellers\",\"Coupons\"]', NULL, '2021-02-16 02:43:11', '2021-10-04 06:01:32'),
(114, 'header_menu_links', '[\"https:\\/\\/demo.activeitzone.com\\/ecommerce\\/\",\"https:\\/\\/demo.activeitzone.com\\/ecommerce\\/flash-deals\",\"https:\\/\\/demo.activeitzone.com\\/ecommerce\\/blog\",\"https:\\/\\/demo.activeitzone.com\\/ecommerce\\/brands\",\"https:\\/\\/demo.activeitzone.com\\/ecommerce\\/categories\",\"https:\\/\\/demo.activeitzone.com\\/ecommerce\\/sellers\",\"https:\\/\\/demo.activeitzone.com\\/ecommerce\\/coupons\"]', NULL, '2021-02-16 02:43:11', '2021-10-04 06:01:32'),
(115, 'club_point_convert_rate', '5', NULL, '2019-03-12 05:58:23', '2021-02-23 02:30:21'),
(116, 'refund_request_time', '3', NULL, '2019-03-11 23:58:23', '2019-03-11 23:58:23'),
(117, 'mpesa', '1', NULL, '2021-02-23 08:24:20', '2021-02-23 02:26:53'),
(118, 'flutterwave', '1', NULL, '2021-02-23 08:24:20', '2021-02-23 02:26:54'),
(119, 'payfast_sandbox', '1', NULL, '2021-02-23 08:24:20', '2021-02-23 08:24:20'),
(120, 'payfast', '1', NULL, '2021-02-23 08:24:20', '2021-02-23 08:24:20'),
(121, 'home_banner3_images', '[\"965\",\"966\",\"967\"]', NULL, '2021-02-24 03:36:47', '2021-02-24 04:39:12'),
(122, 'home_banner3_links', '[\"https:\\/\\/codecanyon.net\\/item\\/active-ecommerce-cms\\/23471405?s_rank=14\",\"https:\\/\\/codecanyon.net\\/item\\/active-ecommerce-cms\\/23471405?s_rank=14\",null]', NULL, '2021-02-24 03:36:47', '2021-02-24 03:57:38'),
(123, 'cookies_agreement_text', '<p>We use cookie for better user experience, check our policy <a href=\"https://demo.activeitzone.com/ecommerce/privacypolicy\">here</a>&nbsp;</p>', NULL, '2021-02-27 16:56:21', '2021-03-09 03:03:23'),
(124, 'show_cookies_agreement', 'on', NULL, '2021-02-27 16:56:21', '2021-02-27 16:56:21'),
(125, 'product_manage_by_admin', '1', NULL, '2021-03-08 06:49:22', '2021-03-08 06:49:22'),
(126, 'topbar_banner', '1007', NULL, '2021-06-02 03:18:03', '2021-06-02 03:19:23'),
(127, 'topbar_banner_link', '#', NULL, '2021-06-02 03:18:03', '2021-06-02 03:18:03'),
(128, 'disable_image_optimization', '0', NULL, '2021-06-02 03:18:57', '2021-06-02 03:19:29'),
(129, 'show_website_popup', 'on', NULL, '2021-06-02 03:44:11', '2021-06-02 03:44:11'),
(130, 'website_popup_content', '<p><img src=\"http://demo.activeitzone.com/ecommerce/public/uploads/all/dwaK3um8tkVgEsgmZN1peQb844tFRAIQ1wAS8e3z.png\" style=\"width: 100%;\"></p><p style=\"text-align: center; \"><br></p><h2 style=\"text-align: center; \"><b>Subscribe to Our Newsletter</b></h2><p style=\"text-align: center;\">Subscribe our newsletter for coupon, offer and exciting promotional discount..</p>', NULL, '2021-06-02 03:44:11', '2021-06-23 05:12:02'),
(131, 'show_subscribe_form', 'on', NULL, '2021-06-02 03:44:11', '2021-06-02 03:44:11'),
(132, 'play_store_link', '#', NULL, '2021-06-02 03:49:28', '2021-06-02 03:49:28'),
(133, 'app_store_link', '#', NULL, '2021-06-02 03:49:28', '2021-06-02 03:49:28'),
(134, 'proxypay', '1', NULL, '2021-06-21 12:01:28', '2021-06-21 12:01:28'),
(135, 'proxypay_sandbox', '1', NULL, '2021-06-21 12:01:28', '2021-06-21 12:01:28'),
(136, 'google_map', '0', NULL, '2021-07-28 06:33:57', '2021-07-28 06:33:57'),
(137, 'google_firebase', '0', NULL, '2021-07-28 06:33:57', '2021-07-28 06:33:57'),
(138, 'mpesa', '0', NULL, '2021-09-15 09:56:34', '2021-09-15 09:56:34'),
(139, 'flutterwave', '0', NULL, '2021-09-15 09:56:34', '2021-09-15 09:56:34'),
(140, 'vendor_commission_activation', '1', NULL, '2021-09-19 04:48:30', '2021-09-19 05:28:27'),
(141, 'mpesa', '0', NULL, '2021-09-20 10:19:08', '2021-09-20 10:19:08'),
(142, 'flutterwave', '0', NULL, '2021-09-20 10:19:08', '2021-09-20 10:19:08'),
(143, 'color_filter_activation', '1', NULL, '2021-09-26 05:25:04', '2021-09-26 05:26:30'),
(144, 'authorizenet_sandbox', '1', NULL, '2021-02-16 02:43:11', '2021-06-14 05:00:23'),
(145, 'helpline_number', '+01 112 352 566', NULL, '2021-11-21 04:26:32', '2021-11-21 04:26:32'),
(146, 'payku', '1', NULL, '2021-11-21 04:43:58', '2021-11-21 04:43:58');

-- --------------------------------------------------------

--
-- Table structure for table `carts`
--

CREATE TABLE `carts` (
  `id` int(11) NOT NULL,
  `owner_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `temp_user_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address_id` int(11) NOT NULL DEFAULT '0',
  `product_id` int(11) DEFAULT NULL,
  `variation` text COLLATE utf8_unicode_ci,
  `price` double(20,2) DEFAULT '0.00',
  `tax` double(20,2) DEFAULT '0.00',
  `shipping_cost` double(20,2) DEFAULT '0.00',
  `shipping_type` varchar(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `pickup_point` int(11) DEFAULT NULL,
  `discount` double(10,2) NOT NULL DEFAULT '0.00',
  `product_referral_code` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `coupon_code` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `coupon_applied` tinyint(4) NOT NULL DEFAULT '0',
  `quantity` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `parent_id` int(11) DEFAULT '0',
  `level` int(11) NOT NULL DEFAULT '0',
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `order_level` int(11) NOT NULL DEFAULT '0',
  `commision_rate` float(8,2) NOT NULL DEFAULT '0.00',
  `banner` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `icon` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `featured` int(1) NOT NULL DEFAULT '0',
  `top` int(1) NOT NULL DEFAULT '0',
  `digital` int(1) NOT NULL DEFAULT '0',
  `slug` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `meta_title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `meta_description` mediumtext COLLATE utf8_unicode_ci,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Table structure for table `category_translations`
--

CREATE TABLE `category_translations` (
  `id` bigint(20) NOT NULL,
  `category_id` bigint(20) NOT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `lang` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Table structure for table `cities`
--

CREATE TABLE `cities` (
  `id` bigint(20) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `state_id` int(11) NOT NULL,
  `cost` double(20,2) NOT NULL DEFAULT '0.00',
  `status` int(11) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Table structure for table `city_translations`
--

CREATE TABLE `city_translations` (
  `id` int(11) NOT NULL,
  `city_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `lang` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Table structure for table `club_points`
--

CREATE TABLE `club_points` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `points` double(18,2) NOT NULL,
  `order_id` int(11) NOT NULL,
  `convert_status` int(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Table structure for table `club_point_details`
--

CREATE TABLE `club_point_details` (
  `id` int(11) NOT NULL,
  `club_point_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_qty` int(11) NOT NULL,
  `point` double(8,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Table structure for table `colors`
--

CREATE TABLE `colors` (
  `id` int(11) NOT NULL,
  `name` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `code` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `colors`
--

INSERT INTO `colors` (`id`, `name`, `code`, `created_at`, `updated_at`) VALUES
(1, 'IndianRed', '#CD5C5C', '2018-11-05 02:12:26', '2018-11-05 02:12:26'),
(2, 'LightCoral', '#F08080', '2018-11-05 02:12:26', '2018-11-05 02:12:26'),
(3, 'Salmon', '#FA8072', '2018-11-05 02:12:26', '2018-11-05 02:12:26'),
(4, 'DarkSalmon', '#E9967A', '2018-11-05 02:12:26', '2018-11-05 02:12:26'),
(5, 'LightSalmon', '#FFA07A', '2018-11-05 02:12:26', '2018-11-05 02:12:26'),
(6, 'Crimson', '#DC143C', '2018-11-05 02:12:26', '2018-11-05 02:12:26'),
(7, 'Red', '#FF0000', '2018-11-05 02:12:26', '2018-11-05 02:12:26'),
(8, 'FireBrick', '#B22222', '2018-11-05 02:12:26', '2018-11-05 02:12:26'),
(9, 'DarkRed', '#8B0000', '2018-11-05 02:12:26', '2018-11-05 02:12:26'),
(10, 'Pink', '#FFC0CB', '2018-11-05 02:12:26', '2018-11-05 02:12:26'),
(11, 'LightPink', '#FFB6C1', '2018-11-05 02:12:26', '2018-11-05 02:12:26'),
(12, 'HotPink', '#FF69B4', '2018-11-05 02:12:26', '2018-11-05 02:12:26'),
(13, 'DeepPink', '#FF1493', '2018-11-05 02:12:26', '2018-11-05 02:12:26'),
(14, 'MediumVioletRed', '#C71585', '2018-11-05 02:12:26', '2018-11-05 02:12:26'),
(15, 'PaleVioletRed', '#DB7093', '2018-11-05 02:12:26', '2018-11-05 02:12:26'),
(16, 'LightSalmon', '#FFA07A', '2018-11-05 02:12:26', '2018-11-05 02:12:26'),
(17, 'Coral', '#FF7F50', '2018-11-05 02:12:26', '2018-11-05 02:12:26'),
(18, 'Tomato', '#FF6347', '2018-11-05 02:12:26', '2018-11-05 02:12:26'),
(19, 'OrangeRed', '#FF4500', '2018-11-05 02:12:26', '2018-11-05 02:12:26'),
(20, 'DarkOrange', '#FF8C00', '2018-11-05 02:12:26', '2018-11-05 02:12:26'),
(21, 'Orange', '#FFA500', '2018-11-05 02:12:26', '2018-11-05 02:12:26'),
(22, 'Gold', '#FFD700', '2018-11-05 02:12:26', '2018-11-05 02:12:26'),
(23, 'Yellow', '#FFFF00', '2018-11-05 02:12:26', '2018-11-05 02:12:26'),
(24, 'LightYellow', '#FFFFE0', '2018-11-05 02:12:26', '2018-11-05 02:12:26'),
(25, 'LemonChiffon', '#FFFACD', '2018-11-05 02:12:26', '2018-11-05 02:12:26'),
(26, 'LightGoldenrodYellow', '#FAFAD2', '2018-11-05 02:12:27', '2018-11-05 02:12:27'),
(27, 'PapayaWhip', '#FFEFD5', '2018-11-05 02:12:27', '2018-11-05 02:12:27'),
(28, 'Moccasin', '#FFE4B5', '2018-11-05 02:12:27', '2018-11-05 02:12:27'),
(29, 'PeachPuff', '#FFDAB9', '2018-11-05 02:12:27', '2018-11-05 02:12:27'),
(30, 'PaleGoldenrod', '#EEE8AA', '2018-11-05 02:12:27', '2018-11-05 02:12:27'),
(31, 'Khaki', '#F0E68C', '2018-11-05 02:12:27', '2018-11-05 02:12:27'),
(32, 'DarkKhaki', '#BDB76B', '2018-11-05 02:12:27', '2018-11-05 02:12:27'),
(33, 'Lavender', '#E6E6FA', '2018-11-05 02:12:27', '2018-11-05 02:12:27'),
(34, 'Thistle', '#D8BFD8', '2018-11-05 02:12:27', '2018-11-05 02:12:27'),
(35, 'Plum', '#DDA0DD', '2018-11-05 02:12:27', '2018-11-05 02:12:27'),
(36, 'Violet', '#EE82EE', '2018-11-05 02:12:27', '2018-11-05 02:12:27'),
(37, 'Orchid', '#DA70D6', '2018-11-05 02:12:27', '2018-11-05 02:12:27'),
(38, 'Fuchsia', '#FF00FF', '2018-11-05 02:12:27', '2018-11-05 02:12:27'),
(39, 'Magenta', '#FF00FF', '2018-11-05 02:12:27', '2018-11-05 02:12:27'),
(40, 'MediumOrchid', '#BA55D3', '2018-11-05 02:12:27', '2018-11-05 02:12:27'),
(41, 'MediumPurple', '#9370DB', '2018-11-05 02:12:27', '2018-11-05 02:12:27'),
(42, 'Amethyst', '#9966CC', '2018-11-05 02:12:27', '2018-11-05 02:12:27'),
(43, 'BlueViolet', '#8A2BE2', '2018-11-05 02:12:27', '2018-11-05 02:12:27'),
(44, 'DarkViolet', '#9400D3', '2018-11-05 02:12:27', '2018-11-05 02:12:27'),
(45, 'DarkOrchid', '#9932CC', '2018-11-05 02:12:27', '2018-11-05 02:12:27'),
(46, 'DarkMagenta', '#8B008B', '2018-11-05 02:12:27', '2018-11-05 02:12:27'),
(47, 'Purple', '#800080', '2018-11-05 02:12:27', '2018-11-05 02:12:27'),
(48, 'Indigo', '#4B0082', '2018-11-05 02:12:27', '2018-11-05 02:12:27'),
(49, 'SlateBlue', '#6A5ACD', '2018-11-05 02:12:27', '2018-11-05 02:12:27'),
(50, 'DarkSlateBlue', '#483D8B', '2018-11-05 02:12:27', '2018-11-05 02:12:27'),
(51, 'MediumSlateBlue', '#7B68EE', '2018-11-05 02:12:27', '2018-11-05 02:12:27'),
(52, 'GreenYellow', '#ADFF2F', '2018-11-05 02:12:27', '2018-11-05 02:12:27'),
(53, 'Chartreuse', '#7FFF00', '2018-11-05 02:12:27', '2018-11-05 02:12:27'),
(54, 'LawnGreen', '#7CFC00', '2018-11-05 02:12:27', '2018-11-05 02:12:27'),
(55, 'Lime', '#00FF00', '2018-11-05 02:12:27', '2018-11-05 02:12:27'),
(56, 'LimeGreen', '#32CD32', '2018-11-05 02:12:27', '2018-11-05 02:12:27'),
(57, 'PaleGreen', '#98FB98', '2018-11-05 02:12:27', '2018-11-05 02:12:27'),
(58, 'LightGreen', '#90EE90', '2018-11-05 02:12:27', '2018-11-05 02:12:27'),
(59, 'MediumSpringGreen', '#00FA9A', '2018-11-05 02:12:27', '2018-11-05 02:12:27'),
(60, 'SpringGreen', '#00FF7F', '2018-11-05 02:12:27', '2018-11-05 02:12:27'),
(61, 'MediumSeaGreen', '#3CB371', '2018-11-05 02:12:27', '2018-11-05 02:12:27'),
(62, 'SeaGreen', '#2E8B57', '2018-11-05 02:12:27', '2018-11-05 02:12:27'),
(63, 'ForestGreen', '#228B22', '2018-11-05 02:12:28', '2018-11-05 02:12:28'),
(64, 'Green', '#008000', '2018-11-05 02:12:28', '2018-11-05 02:12:28'),
(65, 'DarkGreen', '#006400', '2018-11-05 02:12:28', '2018-11-05 02:12:28'),
(66, 'YellowGreen', '#9ACD32', '2018-11-05 02:12:28', '2018-11-05 02:12:28'),
(67, 'OliveDrab', '#6B8E23', '2018-11-05 02:12:28', '2018-11-05 02:12:28'),
(68, 'Olive', '#808000', '2018-11-05 02:12:28', '2018-11-05 02:12:28'),
(69, 'DarkOliveGreen', '#556B2F', '2018-11-05 02:12:28', '2018-11-05 02:12:28'),
(70, 'MediumAquamarine', '#66CDAA', '2018-11-05 02:12:28', '2018-11-05 02:12:28'),
(71, 'DarkSeaGreen', '#8FBC8F', '2018-11-05 02:12:28', '2018-11-05 02:12:28'),
(72, 'LightSeaGreen', '#20B2AA', '2018-11-05 02:12:28', '2018-11-05 02:12:28'),
(73, 'DarkCyan', '#008B8B', '2018-11-05 02:12:28', '2018-11-05 02:12:28'),
(74, 'Teal', '#008080', '2018-11-05 02:12:28', '2018-11-05 02:12:28'),
(75, 'Aqua', '#00FFFF', '2018-11-05 02:12:28', '2018-11-05 02:12:28'),
(76, 'Cyan', '#00FFFF', '2018-11-05 02:12:28', '2018-11-05 02:12:28'),
(77, 'LightCyan', '#E0FFFF', '2018-11-05 02:12:28', '2018-11-05 02:12:28'),
(78, 'PaleTurquoise', '#AFEEEE', '2018-11-05 02:12:28', '2018-11-05 02:12:28'),
(79, 'Aquamarine', '#7FFFD4', '2018-11-05 02:12:28', '2018-11-05 02:12:28'),
(80, 'Turquoise', '#40E0D0', '2018-11-05 02:12:28', '2018-11-05 02:12:28'),
(81, 'MediumTurquoise', '#48D1CC', '2018-11-05 02:12:28', '2018-11-05 02:12:28'),
(82, 'DarkTurquoise', '#00CED1', '2018-11-05 02:12:28', '2018-11-05 02:12:28'),
(83, 'CadetBlue', '#5F9EA0', '2018-11-05 02:12:28', '2018-11-05 02:12:28'),
(84, 'SteelBlue', '#4682B4', '2018-11-05 02:12:28', '2018-11-05 02:12:28'),
(85, 'LightSteelBlue', '#B0C4DE', '2018-11-05 02:12:28', '2018-11-05 02:12:28'),
(86, 'PowderBlue', '#B0E0E6', '2018-11-05 02:12:28', '2018-11-05 02:12:28'),
(87, 'LightBlue', '#ADD8E6', '2018-11-05 02:12:28', '2018-11-05 02:12:28'),
(88, 'SkyBlue', '#87CEEB', '2018-11-05 02:12:28', '2018-11-05 02:12:28'),
(89, 'LightSkyBlue', '#87CEFA', '2018-11-05 02:12:28', '2018-11-05 02:12:28'),
(90, 'DeepSkyBlue', '#00BFFF', '2018-11-05 02:12:28', '2018-11-05 02:12:28'),
(91, 'DodgerBlue', '#1E90FF', '2018-11-05 02:12:28', '2018-11-05 02:12:28'),
(92, 'CornflowerBlue', '#6495ED', '2018-11-05 02:12:28', '2018-11-05 02:12:28'),
(93, 'MediumSlateBlue', '#7B68EE', '2018-11-05 02:12:28', '2018-11-05 02:12:28'),
(94, 'RoyalBlue', '#4169E1', '2018-11-05 02:12:28', '2018-11-05 02:12:28'),
(95, 'Blue', '#0000FF', '2018-11-05 02:12:28', '2018-11-05 02:12:28'),
(96, 'MediumBlue', '#0000CD', '2018-11-05 02:12:28', '2018-11-05 02:12:28'),
(97, 'DarkBlue', '#00008B', '2018-11-05 02:12:28', '2018-11-05 02:12:28'),
(98, 'Navy', '#000080', '2018-11-05 02:12:28', '2018-11-05 02:12:28'),
(99, 'MidnightBlue', '#191970', '2018-11-05 02:12:29', '2018-11-05 02:12:29'),
(100, 'Cornsilk', '#FFF8DC', '2018-11-05 02:12:29', '2018-11-05 02:12:29'),
(101, 'BlanchedAlmond', '#FFEBCD', '2018-11-05 02:12:29', '2018-11-05 02:12:29'),
(102, 'Bisque', '#FFE4C4', '2018-11-05 02:12:29', '2018-11-05 02:12:29'),
(103, 'NavajoWhite', '#FFDEAD', '2018-11-05 02:12:29', '2018-11-05 02:12:29'),
(104, 'Wheat', '#F5DEB3', '2018-11-05 02:12:29', '2018-11-05 02:12:29'),
(105, 'BurlyWood', '#DEB887', '2018-11-05 02:12:29', '2018-11-05 02:12:29'),
(106, 'Tan', '#D2B48C', '2018-11-05 02:12:29', '2018-11-05 02:12:29'),
(107, 'RosyBrown', '#BC8F8F', '2018-11-05 02:12:29', '2018-11-05 02:12:29'),
(108, 'SandyBrown', '#F4A460', '2018-11-05 02:12:29', '2018-11-05 02:12:29'),
(109, 'Goldenrod', '#DAA520', '2018-11-05 02:12:29', '2018-11-05 02:12:29'),
(110, 'DarkGoldenrod', '#B8860B', '2018-11-05 02:12:29', '2018-11-05 02:12:29'),
(111, 'Peru', '#CD853F', '2018-11-05 02:12:29', '2018-11-05 02:12:29'),
(112, 'Chocolate', '#D2691E', '2018-11-05 02:12:29', '2018-11-05 02:12:29'),
(113, 'SaddleBrown', '#8B4513', '2018-11-05 02:12:29', '2018-11-05 02:12:29'),
(114, 'Sienna', '#A0522D', '2018-11-05 02:12:29', '2018-11-05 02:12:29'),
(115, 'Brown', '#A52A2A', '2018-11-05 02:12:29', '2018-11-05 02:12:29'),
(116, 'Maroon', '#800000', '2018-11-05 02:12:29', '2018-11-05 02:12:29'),
(117, 'White', '#FFFFFF', '2018-11-05 02:12:29', '2018-11-05 02:12:29'),
(118, 'Snow', '#FFFAFA', '2018-11-05 02:12:29', '2018-11-05 02:12:29'),
(119, 'Honeydew', '#F0FFF0', '2018-11-05 02:12:29', '2018-11-05 02:12:29'),
(120, 'MintCream', '#F5FFFA', '2018-11-05 02:12:29', '2018-11-05 02:12:29'),
(121, 'Azure', '#F0FFFF', '2018-11-05 02:12:29', '2018-11-05 02:12:29'),
(122, 'AliceBlue', '#F0F8FF', '2018-11-05 02:12:29', '2018-11-05 02:12:29'),
(123, 'GhostWhite', '#F8F8FF', '2018-11-05 02:12:29', '2018-11-05 02:12:29'),
(124, 'WhiteSmoke', '#F5F5F5', '2018-11-05 02:12:29', '2018-11-05 02:12:29'),
(125, 'Seashell', '#FFF5EE', '2018-11-05 02:12:29', '2018-11-05 02:12:29'),
(126, 'Beige', '#F5F5DC', '2018-11-05 02:12:29', '2018-11-05 02:12:29'),
(127, 'OldLace', '#FDF5E6', '2018-11-05 02:12:29', '2018-11-05 02:12:29'),
(128, 'FloralWhite', '#FFFAF0', '2018-11-05 02:12:29', '2018-11-05 02:12:29'),
(129, 'Ivory', '#FFFFF0', '2018-11-05 02:12:30', '2018-11-05 02:12:30'),
(130, 'AntiqueWhite', '#FAEBD7', '2018-11-05 02:12:30', '2018-11-05 02:12:30'),
(131, 'Linen', '#FAF0E6', '2018-11-05 02:12:30', '2018-11-05 02:12:30'),
(132, 'LavenderBlush', '#FFF0F5', '2018-11-05 02:12:30', '2018-11-05 02:12:30'),
(133, 'MistyRose', '#FFE4E1', '2018-11-05 02:12:30', '2018-11-05 02:12:30'),
(134, 'Gainsboro', '#DCDCDC', '2018-11-05 02:12:30', '2018-11-05 02:12:30'),
(135, 'LightGrey', '#D3D3D3', '2018-11-05 02:12:30', '2018-11-05 02:12:30'),
(136, 'Silver', '#C0C0C0', '2018-11-05 02:12:30', '2018-11-05 02:12:30'),
(137, 'DarkGray', '#A9A9A9', '2018-11-05 02:12:30', '2018-11-05 02:12:30'),
(138, 'Gray', '#808080', '2018-11-05 02:12:30', '2018-11-05 02:12:30'),
(139, 'DimGray', '#696969', '2018-11-05 02:12:30', '2018-11-05 02:12:30'),
(140, 'LightSlateGray', '#778899', '2018-11-05 02:12:30', '2018-11-05 02:12:30'),
(141, 'SlateGray', '#708090', '2018-11-05 02:12:30', '2018-11-05 02:12:30'),
(142, 'DarkSlateGray', '#2F4F4F', '2018-11-05 02:12:30', '2018-11-05 02:12:30'),
(143, 'Black', '#000000', '2018-11-05 02:12:30', '2018-11-05 02:12:30');

-- --------------------------------------------------------

--
-- Table structure for table `combined_orders`
--

CREATE TABLE `combined_orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `shipping_address` text COLLATE utf8_unicode_ci,
  `grand_total` double(20,2) NOT NULL DEFAULT '0.00',
  `request` varchar(190) COLLATE utf8_unicode_ci DEFAULT NULL,
  `receipt` varchar(190) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Table structure for table `commission_histories`
--

CREATE TABLE `commission_histories` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `order_detail_id` int(11) NOT NULL,
  `seller_id` int(11) NOT NULL,
  `admin_commission` double(25,2) NOT NULL,
  `seller_earning` double(25,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `conversations`
--

CREATE TABLE `conversations` (
  `id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `title` varchar(1000) COLLATE utf32_unicode_ci DEFAULT NULL,
  `sender_viewed` int(1) NOT NULL DEFAULT '1',
  `receiver_viewed` int(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE `countries` (
  `id` int(11) NOT NULL,
  `code` varchar(2) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `status` int(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Table structure for table `coupons`
--

CREATE TABLE `coupons` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `details` longtext COLLATE utf8_unicode_ci NOT NULL,
  `discount` double(20,2) NOT NULL,
  `discount_type` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `start_date` int(15) NOT NULL,
  `end_date` int(15) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Table structure for table `coupon_usages`
--

CREATE TABLE `coupon_usages` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `coupon_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `currencies`
--

CREATE TABLE `currencies` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `symbol` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `exchange_rate` double(10,5) NOT NULL,
  `status` int(10) NOT NULL DEFAULT '0',
  `code` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `currencies`
--

INSERT INTO `currencies` (`id`, `name`, `symbol`, `exchange_rate`, `status`, `code`, `created_at`, `updated_at`) VALUES
(1, 'U.S. Dollar', '$', 1.00000, 1, 'USD', '2018-10-09 11:35:08', '2018-10-17 05:50:52'),
(2, 'Australian Dollar', '$', 1.28000, 1, 'AUD', '2018-10-09 11:35:08', '2019-02-04 05:51:55'),
(5, 'Brazilian Real', 'R$', 3.25000, 1, 'BRL', '2018-10-09 11:35:08', '2018-10-17 05:51:00'),
(6, 'Canadian Dollar', '$', 1.27000, 1, 'CAD', '2018-10-09 11:35:08', '2018-10-09 11:35:08'),
(7, 'Czech Koruna', 'Kč', 20.65000, 1, 'CZK', '2018-10-09 11:35:08', '2018-10-09 11:35:08'),
(8, 'Danish Krone', 'kr', 6.05000, 1, 'DKK', '2018-10-09 11:35:08', '2018-10-09 11:35:08'),
(9, 'Euro', '€', 0.85000, 1, 'EUR', '2018-10-09 11:35:08', '2018-10-09 11:35:08'),
(10, 'Hong Kong Dollar', '$', 7.83000, 1, 'HKD', '2018-10-09 11:35:08', '2018-10-09 11:35:08'),
(11, 'Hungarian Forint', 'Ft', 255.24000, 1, 'HUF', '2018-10-09 11:35:08', '2018-10-09 11:35:08'),
(12, 'Israeli New Sheqel', '₪', 3.48000, 1, 'ILS', '2018-10-09 11:35:08', '2018-10-09 11:35:08'),
(13, 'Japanese Yen', '¥', 107.12000, 1, 'JPY', '2018-10-09 11:35:08', '2018-10-09 11:35:08'),
(14, 'Malaysian Ringgit', 'RM', 3.91000, 1, 'MYR', '2018-10-09 11:35:08', '2018-10-09 11:35:08'),
(15, 'Mexican Peso', '$', 18.72000, 1, 'MXN', '2018-10-09 11:35:08', '2018-10-09 11:35:08'),
(16, 'Norwegian Krone', 'kr', 7.83000, 1, 'NOK', '2018-10-09 11:35:08', '2018-10-09 11:35:08'),
(17, 'New Zealand Dollar', '$', 1.38000, 1, 'NZD', '2018-10-09 11:35:08', '2018-10-09 11:35:08'),
(18, 'Philippine Peso', '₱', 52.26000, 1, 'PHP', '2018-10-09 11:35:08', '2018-10-09 11:35:08'),
(19, 'Polish Zloty', 'zł', 3.39000, 1, 'PLN', '2018-10-09 11:35:08', '2018-10-09 11:35:08'),
(20, 'Pound Sterling', '£', 0.72000, 1, 'GBP', '2018-10-09 11:35:08', '2018-10-09 11:35:08'),
(21, 'Russian Ruble', 'руб', 55.93000, 1, 'RUB', '2018-10-09 11:35:08', '2018-10-09 11:35:08'),
(22, 'Singapore Dollar', '$', 1.32000, 1, 'SGD', '2018-10-09 11:35:08', '2018-10-09 11:35:08'),
(23, 'Swedish Krona', 'kr', 8.19000, 1, 'SEK', '2018-10-09 11:35:08', '2018-10-09 11:35:08'),
(24, 'Swiss Franc', 'CHF', 0.94000, 1, 'CHF', '2018-10-09 11:35:08', '2018-10-09 11:35:08'),
(26, 'Thai Baht', '฿', 31.39000, 1, 'THB', '2018-10-09 11:35:08', '2018-10-09 11:35:08'),
(27, 'Taka', '৳', 84.00000, 1, 'BDT', '2018-10-09 11:35:08', '2018-12-02 05:16:13'),
(28, 'Indian Rupee', 'Rs', 68.45000, 1, 'Rupee', '2019-07-07 10:33:46', '2019-07-07 10:33:46');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customer_packages`
--

CREATE TABLE `customer_packages` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `amount` double(20,2) DEFAULT NULL,
  `product_upload` int(11) DEFAULT NULL,
  `logo` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Table structure for table `customer_package_payments`
--

CREATE TABLE `customer_package_payments` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `customer_package_id` int(11) NOT NULL,
  `payment_method` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `payment_details` longtext COLLATE utf8_unicode_ci NOT NULL,
  `approval` int(1) NOT NULL,
  `offline_payment` int(1) NOT NULL COMMENT '1=offline payment\r\n2=online paymnet',
  `reciept` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customer_package_translations`
--

CREATE TABLE `customer_package_translations` (
  `id` bigint(20) NOT NULL,
  `customer_package_id` bigint(20) NOT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `lang` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Table structure for table `customer_products`
--

CREATE TABLE `customer_products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `published` int(1) NOT NULL DEFAULT '0',
  `status` int(1) NOT NULL DEFAULT '0',
  `added_by` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `subcategory_id` int(11) DEFAULT NULL,
  `subsubcategory_id` int(11) DEFAULT NULL,
  `brand_id` int(11) DEFAULT NULL,
  `photos` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `thumbnail_img` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `conditon` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `location` text COLLATE utf8_unicode_ci,
  `video_provider` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `video_link` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `unit` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tags` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` mediumtext COLLATE utf8_unicode_ci,
  `unit_price` double(20,2) DEFAULT '0.00',
  `meta_title` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `meta_description` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `meta_img` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `pdf` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `slug` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Table structure for table `customer_product_translations`
--

CREATE TABLE `customer_product_translations` (
  `id` bigint(20) NOT NULL,
  `customer_product_id` bigint(20) NOT NULL,
  `name` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `unit` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` longtext COLLATE utf8_unicode_ci,
  `lang` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Table structure for table `delivery_boys`
--

CREATE TABLE `delivery_boys` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `total_collection` double(25,2) NOT NULL DEFAULT '0.00',
  `total_earning` double(25,2) NOT NULL DEFAULT '0.00',
  `monthly_salary` double(25,2) DEFAULT NULL,
  `order_commission` double(25,2) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Table structure for table `delivery_boy_collections`
--

CREATE TABLE `delivery_boy_collections` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `collection_amount` double(25,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Table structure for table `delivery_histories`
--

CREATE TABLE `delivery_histories` (
  `id` int(11) NOT NULL,
  `delivery_boy_id` int(11) DEFAULT NULL,
  `order_id` int(11) NOT NULL,
  `delivery_status` varchar(255) NOT NULL,
  `payment_type` varchar(20) NOT NULL,
  `earning` double(25,2) NOT NULL DEFAULT '0.00',
  `collection` double(25,2) NOT NULL DEFAULT '0.00',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Table structure for table `firebase_notifications`
--

CREATE TABLE `firebase_notifications` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `text` text,
  `item_type` varchar(255) NOT NULL,
  `item_type_id` int(11) NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `flash_deals`
--

CREATE TABLE `flash_deals` (
  `id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `start_date` int(20) DEFAULT NULL,
  `end_date` int(20) DEFAULT NULL,
  `status` int(1) NOT NULL DEFAULT '0',
  `featured` int(1) NOT NULL DEFAULT '0',
  `background_color` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `text_color` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `banner` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Table structure for table `flash_deal_products`
--

CREATE TABLE `flash_deal_products` (
  `id` int(11) NOT NULL,
  `flash_deal_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `discount` double(20,2) DEFAULT '0.00',
  `discount_type` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Table structure for table `flash_deal_translations`
--

CREATE TABLE `flash_deal_translations` (
  `id` bigint(20) NOT NULL,
  `flash_deal_id` bigint(20) NOT NULL,
  `title` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `lang` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Table structure for table `home_categories`
--

CREATE TABLE `home_categories` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `subsubcategories` varchar(1000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` int(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Table structure for table `languages`
--

CREATE TABLE `languages` (
  `id` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `code` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `app_lang_code` varchar(255) COLLATE utf8_unicode_ci DEFAULT 'en',
  `rtl` int(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `languages`
--

INSERT INTO `languages` (`id`, `name`, `code`, `app_lang_code`, `rtl`, `created_at`, `updated_at`) VALUES
(1, 'English', 'en', 'en', 0, '2019-01-20 12:13:20', '2019-01-20 12:13:20'),

-- --------------------------------------------------------

--
-- Table structure for table `manual_payment_methods`
--

CREATE TABLE `manual_payment_methods` (
  `id` int(11) NOT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `heading` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `bank_info` text COLLATE utf8_unicode_ci,
  `photo` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `conversation_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `message` text COLLATE utf32_unicode_ci,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_unicode_ci;

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_id` bigint(20) UNSIGNED NOT NULL,
  `data` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `combined_order_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `guest_id` int(11) DEFAULT NULL,
  `seller_id` int(11) DEFAULT NULL,
  `assign_delivery_boy` int(11) DEFAULT NULL,
  `shipping_address` longtext COLLATE utf8_unicode_ci,
  `shipping_type` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `pickup_point_id` int(11) NOT NULL DEFAULT '0',
  `delivery_status` varchar(20) COLLATE utf8_unicode_ci DEFAULT 'pending',
  `payment_type` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `manual_payment` int(1) NOT NULL DEFAULT '0',
  `manual_payment_data` text COLLATE utf8_unicode_ci,
  `payment_status` varchar(20) COLLATE utf8_unicode_ci DEFAULT 'unpaid',
  `payment_details` longtext COLLATE utf8_unicode_ci,
  `grand_total` double(20,2) DEFAULT NULL,
  `request` varchar(190) COLLATE utf8_unicode_ci DEFAULT NULL,
  `receipt` varchar(190) COLLATE utf8_unicode_ci DEFAULT NULL,
  `coupon_discount` double(20,2) NOT NULL DEFAULT '0.00',
  `code` mediumtext COLLATE utf8_unicode_ci,
  `tracking_code` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `date` int(20) NOT NULL,
  `viewed` int(1) NOT NULL DEFAULT '0',
  `delivery_viewed` int(1) NOT NULL DEFAULT '1',
  `cancel_request` tinyint(1) NOT NULL DEFAULT '0',
  `cancel_request_at` datetime DEFAULT NULL,
  `payment_status_viewed` int(1) DEFAULT '1',
  `commission_calculated` int(11) NOT NULL DEFAULT '0',
  `delivery_history_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Table structure for table `order_details`
--

CREATE TABLE `order_details` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `seller_id` int(11) DEFAULT NULL,
  `product_id` int(11) NOT NULL,
  `variation` longtext COLLATE utf8_unicode_ci,
  `price` double(20,2) DEFAULT NULL,
  `tax` double(20,2) NOT NULL DEFAULT '0.00',
  `shipping_cost` double(20,2) NOT NULL DEFAULT '0.00',
  `quantity` int(11) DEFAULT NULL,
  `payment_status` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'unpaid',
  `delivery_status` varchar(20) COLLATE utf8_unicode_ci DEFAULT 'pending',
  `shipping_type` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `pickup_point_id` int(11) DEFAULT NULL,
  `product_referral_code` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Table structure for table `otp_configurations`
--

CREATE TABLE `otp_configurations` (
  `id` int(11) NOT NULL,
  `type` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `value` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `id` int(11) NOT NULL,
  `type` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `content` longtext COLLATE utf8_unicode_ci,
  `meta_title` text COLLATE utf8_unicode_ci,
  `meta_description` varchar(1000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `keywords` varchar(1000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `meta_image` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `type`, `title`, `slug`, `content`, `meta_title`, `meta_description`, `keywords`, `meta_image`, `created_at`, `updated_at`) VALUES
(1, 'home_page', 'Home Page', 'home', NULL, NULL, NULL, NULL, NULL, '2020-11-04 10:13:20', '2020-11-04 10:13:20'),
(2, 'seller_policy_page', 'Seller Policy Pages', 'sellerpolicy', NULL, NULL, NULL, NULL, NULL, '2020-11-04 10:14:41', '2020-11-04 12:19:30'),
(3, 'return_policy_page', 'Return Policy Page', 'returnpolicy', NULL, NULL, NULL, NULL, NULL, '2020-11-04 10:14:41', '2020-11-04 10:14:41'),
(4, 'support_policy_page', 'Support Policy Page', 'supportpolicy', NULL, NULL, NULL, NULL, NULL, '2020-11-04 10:14:59', '2020-11-04 10:14:59'),
(5, 'terms_conditions_page', 'Term Conditions Page', 'terms', NULL, NULL, NULL, NULL, NULL, '2020-11-04 10:15:29', '2020-11-04 10:15:29'),
(6, 'privacy_policy_page', 'Privacy Policy Page', 'privacypolicy', NULL, NULL, NULL, NULL, NULL, '2020-11-04 10:15:55', '2020-11-04 10:15:55');

-- --------------------------------------------------------

--
-- Table structure for table `page_translations`
--

CREATE TABLE `page_translations` (
  `id` bigint(20) NOT NULL,
  `page_id` bigint(20) NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `content` longtext COLLATE utf8_unicode_ci NOT NULL,
  `lang` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payku_payments`
--

CREATE TABLE `payku_payments` (
  `transaction_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `start` date NOT NULL,
  `end` date NOT NULL,
  `media` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `transaction_key` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_key` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `verification_key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `authorization_code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_4_digits` int(10) UNSIGNED DEFAULT NULL,
  `installments` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `card_type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `additional_parameters` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `currency` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payku_transactions`
--

CREATE TABLE `payku_transactions` (
  `id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subject` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `url` text COLLATE utf8mb4_unicode_ci,
  `amount` int(10) UNSIGNED DEFAULT NULL,
  `notified_at` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `seller_id` int(11) NOT NULL,
  `amount` double(20,2) NOT NULL DEFAULT '0.00',
  `payment_details` longtext COLLATE utf8_unicode_ci,
  `payment_method` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `txn_code` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pickup_points`
--

CREATE TABLE `pickup_points` (
  `id` int(11) NOT NULL,
  `staff_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `phone` varchar(15) NOT NULL,
  `pick_up_status` int(1) DEFAULT NULL,
  `cash_on_pickup_status` int(1) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Table structure for table `pickup_point_translations`
--

CREATE TABLE `pickup_point_translations` (
  `id` bigint(20) NOT NULL,
  `pickup_point_id` bigint(20) NOT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `address` text COLLATE utf8_unicode_ci NOT NULL,
  `lang` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `added_by` varchar(6) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'admin',
  `user_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `brand_id` int(11) DEFAULT NULL,
  `photos` varchar(2000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `thumbnail_img` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `video_provider` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `video_link` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tags` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` longtext COLLATE utf8_unicode_ci,
  `unit_price` double(20,2) NOT NULL,
  `purchase_price` double(20,2) DEFAULT NULL,
  `variant_product` int(1) NOT NULL DEFAULT '0',
  `attributes` varchar(1000) COLLATE utf8_unicode_ci NOT NULL DEFAULT '[]',
  `choice_options` mediumtext COLLATE utf8_unicode_ci,
  `colors` mediumtext COLLATE utf8_unicode_ci,
  `variations` text COLLATE utf8_unicode_ci,
  `todays_deal` int(11) NOT NULL DEFAULT '0',
  `published` int(11) NOT NULL DEFAULT '1',
  `approved` tinyint(1) NOT NULL DEFAULT '1',
  `stock_visibility_state` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'quantity',
  `cash_on_delivery` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1 = On, 0 = Off',
  `featured` int(11) NOT NULL DEFAULT '0',
  `seller_featured` int(11) NOT NULL DEFAULT '0',
  `current_stock` int(10) NOT NULL DEFAULT '0',
  `unit` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `min_qty` int(11) NOT NULL DEFAULT '1',
  `low_stock_quantity` int(11) DEFAULT NULL,
  `discount` double(20,2) DEFAULT NULL,
  `discount_type` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `discount_start_date` int(11) DEFAULT NULL,
  `discount_end_date` int(11) DEFAULT NULL,
  `starting_bid` double(20,2) DEFAULT '0.00',
  `auction_start_date` int(11) DEFAULT NULL,
  `auction_end_date` int(11) DEFAULT NULL,
  `tax` double(20,2) DEFAULT NULL,
  `tax_type` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `shipping_type` varchar(20) CHARACTER SET latin1 DEFAULT 'flat_rate',
  `shipping_cost` text COLLATE utf8_unicode_ci,
  `is_quantity_multiplied` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1 = Mutiplied with shipping cost',
  `est_shipping_days` int(11) DEFAULT NULL,
  `num_of_sale` int(11) NOT NULL DEFAULT '0',
  `meta_title` mediumtext COLLATE utf8_unicode_ci,
  `meta_description` longtext COLLATE utf8_unicode_ci,
  `meta_img` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `pdf` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `slug` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `refundable` int(1) NOT NULL DEFAULT '0',
  `earn_point` double(8,2) NOT NULL DEFAULT '0.00',
  `rating` double(8,2) NOT NULL DEFAULT '0.00',
  `barcode` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `digital` int(1) NOT NULL DEFAULT '0',
  `auction_product` int(11) NOT NULL DEFAULT '0',
  `file_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `file_path` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `external_link` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `external_link_btn` varchar(255) COLLATE utf8_unicode_ci DEFAULT 'Buy Now',
  `wholesale_product` int(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Table structure for table `product_stocks`
--

CREATE TABLE `product_stocks` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `variant` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `sku` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `price` double(20,2) NOT NULL DEFAULT '0.00',
  `qty` int(11) NOT NULL DEFAULT '0',
  `image` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Table structure for table `product_taxes`
--

CREATE TABLE `product_taxes` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `tax_id` int(11) NOT NULL,
  `tax` double(20,2) NOT NULL,
  `tax_type` varchar(10) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Table structure for table `product_translations`
--

CREATE TABLE `product_translations` (
  `id` bigint(20) NOT NULL,
  `product_id` bigint(20) NOT NULL,
  `name` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `unit` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` longtext COLLATE utf8_unicode_ci,
  `lang` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Table structure for table `proxypay_payments`
--

CREATE TABLE `proxypay_payments` (
  `id` int(11) NOT NULL,
  `payment_type` varchar(20) NOT NULL,
  `reference_id` varchar(20) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `package_id` int(11) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `amount` double(25,2) NOT NULL DEFAULT '0.00',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `refund_requests`
--

CREATE TABLE `refund_requests` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `order_detail_id` int(11) NOT NULL,
  `seller_id` int(11) NOT NULL,
  `seller_approval` int(1) NOT NULL DEFAULT '0',
  `admin_approval` int(1) NOT NULL DEFAULT '0',
  `refund_amount` double(8,2) NOT NULL DEFAULT '0.00',
  `reason` longtext COLLATE utf8_unicode_ci,
  `admin_seen` int(11) NOT NULL,
  `refund_status` int(1) NOT NULL DEFAULT '0',
  `reject_reason` longtext COLLATE utf8_unicode_ci,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `rating` int(11) NOT NULL DEFAULT '0',
  `comment` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1',
  `viewed` int(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `name` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `permissions` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Table structure for table `role_translations`
--

CREATE TABLE `role_translations` (
  `id` bigint(20) NOT NULL,
  `role_id` bigint(20) NOT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `lang` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Table structure for table `searches`
--

CREATE TABLE `searches` (
  `id` int(11) NOT NULL,
  `query` varchar(1000) COLLATE utf8_unicode_ci NOT NULL,
  `count` int(11) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Table structure for table `sellers`
--

CREATE TABLE `sellers` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `rating` double(3,2) NOT NULL DEFAULT '0.00',
  `num_of_reviews` int(11) NOT NULL DEFAULT '0',
  `num_of_sale` int(11) NOT NULL DEFAULT '0',
  `seller_package_id` int(11) DEFAULT NULL,
  `invalid_at` date DEFAULT NULL,
  `verification_status` int(1) NOT NULL DEFAULT '0',
  `verification_info` longtext COLLATE utf8_unicode_ci,
  `cash_on_delivery_status` int(1) NOT NULL DEFAULT '0',
  `admin_to_pay` double(20,2) NOT NULL DEFAULT '0.00',
  `bank_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `bank_acc_name` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `bank_acc_no` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `bank_routing_no` int(50) DEFAULT NULL,
  `bank_payment_status` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Table structure for table `seller_packages`
--

CREATE TABLE `seller_packages` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `amount` double(11,2) NOT NULL DEFAULT '0.00',
  `product_upload_limit` int(11) NOT NULL DEFAULT '0',
  `logo` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `duration` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Table structure for table `seller_package_payments`
--

CREATE TABLE `seller_package_payments` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `seller_package_id` int(11) NOT NULL,
  `payment_method` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `payment_details` longtext COLLATE utf8_unicode_ci,
  `approval` int(1) NOT NULL,
  `offline_payment` int(1) NOT NULL COMMENT '1=offline payment\r\n2=online paymnet',
  `reciept` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `seller_package_translations`
--

CREATE TABLE `seller_package_translations` (
  `id` bigint(20) NOT NULL,
  `seller_package_id` bigint(20) NOT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `lang` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Table structure for table `seller_withdraw_requests`
--

CREATE TABLE `seller_withdraw_requests` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `amount` double(20,2) DEFAULT NULL,
  `message` longtext CHARACTER SET utf8,
  `status` int(1) DEFAULT NULL,
  `viewed` int(1) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `shops`
--

CREATE TABLE `shops` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `logo` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sliders` longtext COLLATE utf8_unicode_ci,
  `phone` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `facebook` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `google` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `twitter` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `youtube` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `meta_title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `meta_description` text COLLATE utf8_unicode_ci,
  `pick_up_point_id` text COLLATE utf8_unicode_ci,
  `shipping_cost` double(20,2) NOT NULL DEFAULT '0.00',
  `delivery_pickup_latitude` float DEFAULT NULL,
  `delivery_pickup_longitude` float DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Table structure for table `sms_templates`
--

CREATE TABLE `sms_templates` (
  `id` int(11) NOT NULL,
  `identifier` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `sms_body` longtext COLLATE utf8_unicode_ci NOT NULL,
  `template_id` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Table structure for table `states`
--

CREATE TABLE `states` (
  `id` bigint(20) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `country_id` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Table structure for table `subscribers`
--

CREATE TABLE `subscribers` (
  `id` int(11) NOT NULL,
  `email` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `taxes`
--

CREATE TABLE `taxes` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `tax_status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '0 = Inactive, 1 = Active',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Table structure for table `tickets`
--

CREATE TABLE `tickets` (
  `id` int(11) NOT NULL,
  `code` int(6) NOT NULL,
  `user_id` int(11) NOT NULL,
  `subject` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `details` longtext COLLATE utf8_unicode_ci,
  `files` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `status` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'pending',
  `viewed` int(1) NOT NULL DEFAULT '0',
  `client_viewed` int(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Table structure for table `ticket_replies`
--

CREATE TABLE `ticket_replies` (
  `id` int(11) NOT NULL,
  `ticket_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `reply` longtext COLLATE utf8_unicode_ci NOT NULL,
  `files` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `gateway` varchar(255) DEFAULT NULL,
  `payment_type` varchar(255) DEFAULT NULL,
  `additional_content` text,
  `mpesa_request` varchar(255) DEFAULT NULL,
  `mpesa_receipt` varchar(255) DEFAULT NULL,
  `status` int(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `translations`
--

CREATE TABLE `translations` (
  `id` int(11) NOT NULL,
  `lang` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `lang_key` text COLLATE utf8_unicode_ci,
  `lang_value` text COLLATE utf8_unicode_ci,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `translations`
--

INSERT INTO `translations` (`id`, `lang`, `lang_key`, `lang_value`, `created_at`, `updated_at`) VALUES
(1, 'en', 'inhouse_auction_products', 'Inhouse Auction Products', '2021-10-06 04:26:39', '2021-10-06 04:26:39'),
(2, 'en', 'seller_auction_products', 'Seller Auction Products', '2021-10-06 04:26:39', '2021-10-06 04:26:39'),
(3, 'en', 'auction_products_orders', 'Auction Products Orders', '2021-10-06 04:26:39', '2021-10-06 04:26:39'),
(4, 'en', 'sales', 'Sales', '2021-10-06 04:26:39', '2021-10-06 04:26:39'),
(5, 'en', 'all_orders', 'All Orders', '2021-10-06 04:26:39', '2021-10-06 04:26:39'),
(6, 'en', 'inhouse_orders', 'Inhouse orders', '2021-10-06 04:26:39', '2021-10-06 04:26:39'),
(7, 'en', 'seller_orders', 'Seller Orders', '2021-10-06 04:26:39', '2021-10-06 04:26:39'),
(8, 'en', 'pickup_point_order', 'Pick-up Point Order', '2021-10-06 04:26:39', '2021-10-06 04:26:39'),
(9, 'en', 'delivery_boy', 'Delivery Boy', '2021-10-06 04:26:39', '2021-10-06 04:26:39'),
(10, 'en', 'all_delivery_boy', 'All Delivery Boy', '2021-10-06 04:26:39', '2021-10-06 04:26:39'),
(11, 'en', 'add_delivery_boy', 'Add Delivery Boy', '2021-10-06 04:26:39', '2021-10-06 04:26:39'),
(12, 'en', 'cancel_request', 'Cancel Request', '2021-10-06 04:26:39', '2021-10-06 04:26:39'),
(13, 'en', 'configuration', 'Configuration', '2021-10-06 04:26:39', '2021-10-06 04:26:39'),
(14, 'en', 'refunds', 'Refunds', '2021-10-06 04:26:39', '2021-10-06 04:26:39'),
(15, 'en', 'refund_requests', 'Refund Requests', '2021-10-06 04:26:39', '2021-10-06 04:26:39'),
(16, 'en', 'approved_refunds', 'Approved Refunds', '2021-10-06 04:26:39', '2021-10-06 04:26:39'),
(17, 'en', 'rejected_refunds', 'rejected Refunds', '2021-10-06 04:26:39', '2021-10-06 04:26:39'),
(18, 'en', 'refund_configuration', 'Refund Configuration', '2021-10-06 04:26:39', '2021-10-06 04:26:39'),
(19, 'en', 'customers', 'Customers', '2021-10-06 04:26:39', '2021-10-06 04:26:39'),
(20, 'en', 'customer_list', 'Customer list', '2021-10-06 04:26:39', '2021-10-06 04:26:39'),
(21, 'en', 'classified_products', 'Classified Products', '2021-10-06 04:26:39', '2021-10-06 04:26:39'),
(22, 'en', 'classified_packages', 'Classified Packages', '2021-10-06 04:26:39', '2021-10-06 04:26:39'),
(23, 'en', 'sellers', 'Sellers', '2021-10-06 04:26:39', '2021-10-06 04:26:39'),
(24, 'en', 'all_seller', 'All Seller', '2021-10-06 04:26:40', '2021-10-06 04:26:40'),
(25, 'en', 'payouts', 'Payouts', '2021-10-06 04:26:40', '2021-10-06 04:26:40'),
(26, 'en', 'payout_requests', 'Payout Requests', '2021-10-06 04:26:40', '2021-10-06 04:26:40'),
(27, 'en', 'seller_commission', 'Seller Commission', '2021-10-06 04:26:40', '2021-10-06 04:26:40'),
(28, 'en', 'seller_packages', 'Seller Packages', '2021-10-06 04:26:40', '2021-10-06 04:26:40'),
(29, 'en', 'seller_verification_form', 'Seller Verification Form', '2021-10-06 04:26:40', '2021-10-06 04:26:40'),
(30, 'en', 'uploaded_files', 'Uploaded Files', '2021-10-06 04:26:40', '2021-10-06 04:26:40'),
(31, 'en', 'reports', 'Reports', '2021-10-06 04:26:40', '2021-10-06 04:26:40'),
(32, 'en', 'in_house_product_sale', 'In House Product Sale', '2021-10-06 04:26:40', '2021-10-06 04:26:40'),
(33, 'en', 'seller_products_sale', 'Seller Products Sale', '2021-10-06 04:26:40', '2021-10-06 04:26:40'),
(34, 'en', 'products_stock', 'Products Stock', '2021-10-06 04:26:40', '2021-10-06 04:26:40'),
(35, 'en', 'products_wishlist', 'Products wishlist', '2021-10-06 04:26:40', '2021-10-06 04:26:40'),
(36, 'en', 'user_searches', 'User Searches', '2021-10-06 04:26:40', '2021-10-06 04:26:40'),
(37, 'en', 'commission_history', 'Commission History', '2021-10-06 04:26:40', '2021-10-06 04:26:40'),
(38, 'en', 'wallet_recharge_history', 'Wallet Recharge History', '2021-10-06 04:26:40', '2021-10-06 04:26:40'),
(39, 'en', 'blog_system', 'Blog System', '2021-10-06 04:26:40', '2021-10-06 04:26:40'),
(40, 'en', 'all_posts', 'All Posts', '2021-10-06 04:26:40', '2021-10-06 04:26:40'),
(41, 'en', 'categories', 'Categories', '2021-10-06 04:26:40', '2021-10-06 04:26:40'),
(42, 'en', 'marketing', 'Marketing', '2021-10-06 04:26:40', '2021-10-06 04:26:40'),
(43, 'en', 'flash_deals', 'Flash deals', '2021-10-06 04:26:40', '2021-10-06 04:26:40'),
(44, 'en', 'newsletters', 'Newsletters', '2021-10-06 04:26:40', '2021-10-06 04:26:40'),
(45, 'en', 'bulk_sms', 'Bulk SMS', '2021-10-06 04:26:40', '2021-10-06 04:26:40'),
(46, 'en', 'subscribers', 'Subscribers', '2021-10-06 04:26:40', '2021-10-06 04:26:40'),
(47, 'en', 'coupon', 'Coupon', '2021-10-06 04:26:40', '2021-10-06 04:26:40'),
(48, 'en', 'support', 'Support', '2021-10-06 04:26:40', '2021-10-06 04:26:40'),
(49, 'en', 'ticket', 'Ticket', '2021-10-06 04:26:40', '2021-10-06 04:26:40'),
(50, 'en', 'product_queries', 'Product Queries', '2021-10-06 04:26:40', '2021-10-06 04:26:40'),
(51, 'en', 'affiliate_system', 'Affiliate System', '2021-10-06 04:26:40', '2021-10-06 04:26:40'),
(52, 'en', 'affiliate_registration_form', 'Affiliate Registration Form', '2021-10-06 04:26:40', '2021-10-06 04:26:40'),
(53, 'en', 'affiliate_configurations', 'Affiliate Configurations', '2021-10-06 04:26:40', '2021-10-06 04:26:40'),
(54, 'en', 'affiliate_users', 'Affiliate Users', '2021-10-06 04:26:40', '2021-10-06 04:26:40'),
(55, 'en', 'referral_users', 'Referral Users', '2021-10-06 04:26:40', '2021-10-06 04:26:40'),
(56, 'en', 'affiliate_withdraw_requests', 'Affiliate Withdraw Requests', '2021-10-06 04:26:40', '2021-10-06 04:26:40'),
(57, 'en', 'affiliate_logs', 'Affiliate Logs', '2021-10-06 04:26:40', '2021-10-06 04:26:40'),
(58, 'en', 'offline_payment_system', 'Offline Payment System', '2021-10-06 04:26:40', '2021-10-06 04:26:40'),
(59, 'en', 'manual_payment_methods', 'Manual Payment Methods', '2021-10-06 04:26:40', '2021-10-06 04:26:40'),
(60, 'en', 'offline_wallet_recharge', 'Offline Wallet Recharge', '2021-10-06 04:26:40', '2021-10-06 04:26:40'),
(61, 'en', 'offline_customer_package_payments', 'Offline Customer Package Payments', '2021-10-06 04:26:40', '2021-10-06 04:26:40'),
(62, 'en', 'offline_seller_package_payments', 'Offline Seller Package Payments', '2021-10-06 04:26:40', '2021-10-06 04:26:40'),
(63, 'en', 'paytm_payment_gateway', 'Paytm Payment Gateway', '2021-10-06 04:26:40', '2021-10-06 04:26:40'),
(64, 'en', 'set_paytm_credentials', 'Set Paytm Credentials', '2021-10-06 04:26:40', '2021-10-06 04:26:40'),
(65, 'en', 'club_point_system', 'Club Point System', '2021-10-06 04:26:40', '2021-10-06 04:26:40'),
(66, 'en', 'club_point_configurations', 'Club Point Configurations', '2021-10-06 04:26:40', '2021-10-06 04:26:40'),
(67, 'en', 'set_product_point', 'Set Product Point', '2021-10-06 04:26:40', '2021-10-06 04:26:40'),
(68, 'en', 'user_points', 'User Points', '2021-10-06 04:26:40', '2021-10-06 04:26:40'),
(69, 'en', 'otp_system', 'OTP System', '2021-10-06 04:26:40', '2021-10-06 04:26:40'),
(70, 'en', 'otp_configurations', 'OTP Configurations', '2021-10-06 04:26:40', '2021-10-06 04:26:40'),
(71, 'en', 'sms_templates', 'SMS Templates', '2021-10-06 04:26:40', '2021-10-06 04:26:40'),
(72, 'en', 'set_otp_credentials', 'Set OTP Credentials', '2021-10-06 04:26:40', '2021-10-06 04:26:40'),
(73, 'en', 'african_payment_gateway_addon', 'African Payment Gateway Addon', '2021-10-06 04:26:40', '2021-10-06 04:26:40'),
(74, 'en', 'african_pg_configurations', 'African PG Configurations', '2021-10-06 04:26:40', '2021-10-06 04:26:40'),
(75, 'en', 'set_african_pg_credentials', 'Set African PG Credentials', '2021-10-06 04:26:40', '2021-10-06 04:26:40'),
(76, 'en', 'website_setup', 'Website Setup', '2021-10-06 04:26:40', '2021-10-06 04:26:40'),
(77, 'en', 'header', 'Header', '2021-10-06 04:26:40', '2021-10-06 04:26:40'),
(78, 'en', 'footer', 'Footer', '2021-10-06 04:26:40', '2021-10-06 04:26:40'),
(79, 'en', 'pages', 'Pages', '2021-10-06 04:26:40', '2021-10-06 04:26:40'),
(80, 'en', 'appearance', 'Appearance', '2021-10-06 04:26:40', '2021-10-06 04:26:40'),
(81, 'en', 'setup__configurations', 'Setup & Configurations', '2021-10-06 04:26:40', '2021-10-06 04:26:40'),
(82, 'en', 'general_settings', 'General Settings', '2021-10-06 04:26:40', '2021-10-06 04:26:40'),
(83, 'en', 'features_activation', 'Features activation', '2021-10-06 04:26:40', '2021-10-06 04:26:40'),
(84, 'en', 'languages', 'Languages', '2021-10-06 04:26:40', '2021-10-06 04:26:40'),
(85, 'en', 'currency', 'Currency', '2021-10-06 04:26:40', '2021-10-06 04:26:40'),
(86, 'en', 'vat__tax', 'Vat & TAX', '2021-10-06 04:26:40', '2021-10-06 04:26:40'),
(87, 'en', 'pickup_point', 'Pickup point', '2021-10-06 04:26:40', '2021-10-06 04:26:40'),
(88, 'en', 'smtp_settings', 'SMTP Settings', '2021-10-06 04:26:40', '2021-10-06 04:26:40'),
(89, 'en', 'payment_methods', 'Payment Methods', '2021-10-06 04:26:40', '2021-10-06 04:26:40'),
(90, 'en', 'file_system__cache_configuration', 'File System & Cache Configuration', '2021-10-06 04:26:40', '2021-10-06 04:26:40'),
(91, 'en', 'social_media_logins', 'Social media Logins', '2021-10-06 04:26:40', '2021-10-06 04:26:40'),
(92, 'en', 'facebook', 'Facebook', '2021-10-06 04:26:40', '2021-10-06 04:26:40'),
(93, 'en', 'facebook_chat', 'Facebook Chat', '2021-10-06 04:26:40', '2021-10-06 04:26:40'),
(94, 'en', 'facebook_comment', 'Facebook Comment', '2021-10-06 04:26:40', '2021-10-06 04:26:40'),
(95, 'en', 'google', 'Google', '2021-10-06 04:26:40', '2021-10-06 04:26:40'),
(96, 'en', 'analytics_tools', 'Analytics Tools', '2021-10-06 04:26:40', '2021-10-06 04:26:40'),
(97, 'en', 'google_recaptcha', 'Google reCAPTCHA', '2021-10-06 04:26:40', '2021-10-06 04:26:40'),
(98, 'en', 'google_map', 'Google Map', '2021-10-06 04:26:40', '2021-10-06 04:26:40'),
(99, 'en', 'google_firebase', 'Google Firebase', '2021-10-06 04:26:40', '2021-10-06 04:26:40'),
(100, 'en', 'shipping', 'Shipping', '2021-10-06 04:26:40', '2021-10-06 04:26:40'),
(101, 'en', 'shipping_configuration', 'Shipping Configuration', '2021-10-06 04:26:40', '2021-10-06 04:26:40'),
(102, 'en', 'shipping_countries', 'Shipping Countries', '2021-10-06 04:26:40', '2021-10-06 04:26:40'),
(103, 'en', 'shipping_cities', 'Shipping Cities', '2021-10-06 04:26:40', '2021-10-06 04:26:40'),
(104, 'en', 'staffs', 'Staffs', '2021-10-06 04:26:40', '2021-10-06 04:26:40'),
(105, 'en', 'all_staffs', 'All staffs', '2021-10-06 04:26:40', '2021-10-06 04:26:40'),
(106, 'en', 'staff_permissions', 'Staff permissions', '2021-10-06 04:26:40', '2021-10-06 04:26:40'),
(107, 'en', 'system', 'System', '2021-10-06 04:26:40', '2021-10-06 04:26:40'),
(108, 'en', 'update', 'Update', '2021-10-06 04:26:40', '2021-10-06 04:26:40'),
(109, 'en', 'server_status', 'Server status', '2021-10-06 04:26:40', '2021-10-06 04:26:40'),
(110, 'en', 'addon_manager', 'Addon Manager', '2021-10-06 04:26:40', '2021-10-06 04:26:40'),
(111, 'en', 'browse_website', 'Browse Website', '2021-10-06 04:26:40', '2021-10-06 04:26:40'),
(112, 'en', 'pos', 'POS', '2021-10-06 04:26:40', '2021-10-06 04:26:40'),
(113, 'en', 'notifications', 'Notifications', '2021-10-06 04:26:40', '2021-10-06 04:26:40'),
(114, 'en', 'order_code_', 'Order code: ', '2021-10-06 04:26:40', '2021-10-06 04:26:40'),
(115, 'en', 'has_been_placed', 'has been Placed', '2021-10-06 04:26:40', '2021-10-06 04:26:40'),
(116, 'en', 'view_all_notifications', 'View All Notifications', '2021-10-06 04:26:40', '2021-10-06 04:26:40'),
(117, 'en', 'profile', 'Profile', '2021-10-06 04:26:40', '2021-10-06 04:26:40'),
(118, 'en', 'logout', 'Logout', '2021-10-06 04:26:40', '2021-10-06 04:26:40'),
(119, 'en', 'nothing_found', 'Nothing Found', '2021-10-06 04:26:40', '2021-10-06 04:26:40'),
(120, 'en', 'home', 'Home', '2021-10-06 04:26:43', '2021-10-06 04:26:43'),
(121, 'en', 'nothing_selected', 'Nothing selected', '2021-10-06 04:26:43', '2021-10-06 04:26:43'),
(122, 'en', 'choose_file', 'Choose file', '2021-10-06 04:26:43', '2021-10-06 04:26:43'),
(123, 'en', 'file_selected', 'File selected', '2021-10-06 04:26:43', '2021-10-06 04:26:43'),
(124, 'en', 'files_selected', 'Files selected', '2021-10-06 04:26:43', '2021-10-06 04:26:43'),
(125, 'en', 'add_more_files', 'Add more files', '2021-10-06 04:26:43', '2021-10-06 04:26:43'),
(126, 'en', 'adding_more_files', 'Adding more files', '2021-10-06 04:26:43', '2021-10-06 04:26:43'),
(127, 'en', 'drop_files_here_paste_or', 'Drop files here, paste or', '2021-10-06 04:26:43', '2021-10-06 04:26:43'),
(128, 'en', 'browse', 'Browse', '2021-10-06 04:26:44', '2021-10-06 04:26:44'),
(129, 'en', 'upload_complete', 'Upload complete', '2021-10-06 04:26:44', '2021-10-06 04:26:44'),
(130, 'en', 'upload_paused', 'Upload paused', '2021-10-06 04:26:44', '2021-10-06 04:26:44'),
(131, 'en', 'resume_upload', 'Resume upload', '2021-10-06 04:26:44', '2021-10-06 04:26:44'),
(132, 'en', 'pause_upload', 'Pause upload', '2021-10-06 04:26:44', '2021-10-06 04:26:44'),
(133, 'en', 'retry_upload', 'Retry upload', '2021-10-06 04:26:44', '2021-10-06 04:26:44'),
(134, 'en', 'cancel_upload', 'Cancel upload', '2021-10-06 04:26:44', '2021-10-06 04:26:44'),
(135, 'en', 'uploading', 'Uploading', '2021-10-06 04:26:44', '2021-10-06 04:26:44'),
(136, 'en', 'processing', 'Processing', '2021-10-06 04:26:44', '2021-10-06 04:26:44'),
(137, 'en', 'complete', 'Complete', '2021-10-06 04:26:44', '2021-10-06 04:26:44'),
(138, 'en', 'file', 'File', '2021-10-06 04:26:44', '2021-10-06 04:26:44'),
(139, 'en', 'files', 'Files', '2021-10-06 04:26:44', '2021-10-06 04:26:44'),
(140, 'en', 'my_panel', 'My Panel', '2021-10-06 04:26:44', '2021-10-06 04:26:44'),
(141, 'en', 'i_am_shopping_for', 'I am shopping for...', '2021-10-06 04:26:44', '2021-10-06 04:26:44'),
(142, 'en', 'compare', 'Compare', '2021-10-06 04:26:44', '2021-10-06 04:26:44'),
(143, 'en', 'wishlist', 'Wishlist', '2021-10-06 04:26:44', '2021-10-06 04:26:44'),
(144, 'en', 'cart', 'Cart', '2021-10-06 04:26:44', '2021-10-06 04:26:44'),
(145, 'en', 'cart_items', 'Cart Items', '2021-10-06 04:26:44', '2021-10-06 04:26:44'),
(146, 'en', 'subtotal', 'Subtotal', '2021-10-06 04:26:44', '2021-10-06 04:26:44'),
(147, 'en', 'view_cart', 'View cart', '2021-10-06 04:26:44', '2021-10-06 04:26:44'),
(148, 'en', 'checkout', 'Checkout', '2021-10-06 04:26:44', '2021-10-06 04:26:44'),
(149, 'en', 'see_all', 'See All', '2021-10-06 04:26:44', '2021-10-06 04:26:44'),
(150, 'en', 'flash_sale', 'Flash Sale', '2021-10-06 04:26:44', '2021-10-06 04:26:44'),
(151, 'en', 'blogs', 'Blogs', '2021-10-06 04:26:44', '2021-10-06 04:26:44'),
(152, 'en', 'all_brands', 'All Brands', '2021-10-06 04:26:44', '2021-10-06 04:26:44'),
(153, 'en', 'all_categories', 'All Categories', '2021-10-06 04:26:44', '2021-10-06 04:26:44'),
(154, 'en', 'all_sellers', 'All Sellers', '2021-10-06 04:26:44', '2021-10-06 04:26:44'),
(155, 'en', 'coupons', 'Coupons', '2021-10-06 04:26:44', '2021-10-06 04:26:44'),
(156, 'en', 'terms__conditions', 'Terms & conditions', '2021-10-06 04:26:44', '2021-10-06 04:26:44'),
(157, 'en', 'return_policy', 'Return Policy', '2021-10-06 04:26:44', '2021-10-06 04:26:44'),
(158, 'en', 'support_policy', 'Support Policy', '2021-10-06 04:26:44', '2021-10-06 04:26:44'),
(159, 'en', 'privacy_policy', 'Privacy Policy', '2021-10-06 04:26:44', '2021-10-06 04:26:44'),
(160, 'en', 'your_email_address', 'Your Email Address', '2021-10-06 04:26:44', '2021-10-06 04:26:44'),
(161, 'en', 'subscribe', 'Subscribe', '2021-10-06 04:26:44', '2021-10-06 04:26:44'),
(162, 'en', 'contact_info', 'Contact Info', '2021-10-06 04:26:44', '2021-10-06 04:26:44'),
(163, 'en', 'address', 'Address', '2021-10-06 04:26:44', '2021-10-06 04:26:44'),
(164, 'en', 'phone', 'Phone', '2021-10-06 04:26:44', '2021-10-06 04:26:44'),
(165, 'en', 'email', 'Email', '2021-10-06 04:26:44', '2021-10-06 04:26:44'),
(166, 'en', 'my_account', 'My Account', '2021-10-06 04:26:44', '2021-10-06 04:26:44'),
(167, 'en', 'order_history', 'Order History', '2021-10-06 04:26:44', '2021-10-06 04:26:44'),
(168, 'en', 'my_wishlist', 'My Wishlist', '2021-10-06 04:26:44', '2021-10-06 04:26:44'),
(169, 'en', 'track_order', 'Track Order', '2021-10-06 04:26:44', '2021-10-06 04:26:44'),
(170, 'en', 'be_an_affiliate_partner', 'Be an affiliate partner', '2021-10-06 04:26:44', '2021-10-06 04:26:44'),
(171, 'en', 'be_a_seller', 'Be a Seller', '2021-10-06 04:26:44', '2021-10-06 04:26:44'),
(172, 'en', 'apply_now', 'Apply Now', '2021-10-06 04:26:44', '2021-10-06 04:26:44'),
(173, 'en', 'account', 'Account', '2021-10-06 04:26:44', '2021-10-06 04:26:44'),
(174, 'en', 'ok_i_understood', 'Ok. I Understood', '2021-10-06 04:26:44', '2021-10-06 04:26:44'),
(175, 'en', 'subscribe_now', 'Subscribe Now', '2021-10-06 04:26:44', '2021-10-06 04:26:44'),
(176, 'en', 'confirmation', 'Confirmation', '2021-10-06 04:26:44', '2021-10-06 04:26:44'),
(177, 'en', 'delete_confirmation_message', 'Delete confirmation message', '2021-10-06 04:26:44', '2021-10-06 04:26:44'),
(178, 'en', 'cancel', 'Cancel', '2021-10-06 04:26:44', '2021-10-06 04:26:44'),
(179, 'en', 'delete', 'Delete', '2021-10-06 04:26:44', '2021-10-06 04:26:44'),
(180, 'en', 'item_has_been_removed_from_cart', 'Item has been removed from cart', '2021-10-06 04:26:44', '2021-10-06 04:26:44'),
(181, 'en', 'item_has_been_added_to_compare_list', 'Item has been added to compare list', '2021-10-06 04:26:44', '2021-10-06 04:26:44'),
(182, 'en', 'please_login_first', 'Please login first', '2021-10-06 04:26:44', '2021-10-06 04:26:44'),
(183, 'en', 'please_choose_all_the_options', 'Please choose all the options', '2021-10-06 04:26:44', '2021-10-06 04:26:44'),
(184, 'en', 'page_not_found', 'Page Not Found!', '2021-10-06 04:26:44', '2021-10-06 04:26:44'),
(185, 'en', 'the_page_you_are_looking_for_has_not_been_found_on_our_server', 'The page you are looking for has not been found on our server.', '2021-10-06 04:26:44', '2021-10-06 04:26:44'),
(186, 'en', 'login', 'Login', '2021-10-06 04:26:44', '2021-10-06 04:26:44'),
(187, 'en', 'registration', 'Registration', '2021-10-06 04:26:44', '2021-10-06 04:26:44'),
(188, 'en', 'your_cart_is_empty', 'Your Cart is empty', '2021-10-06 04:26:44', '2021-10-06 04:26:44'),
(189, 'en', 'please_configure_smtp_setting_to_work_all_email_sending_functionality', 'Please Configure SMTP Setting to work all email sending functionality', '2021-10-06 04:26:46', '2021-10-06 04:26:46'),
(190, 'en', 'configure_now', 'Configure Now', '2021-10-06 04:26:46', '2021-10-06 04:26:46'),
(191, 'en', 'total', 'Total', '2021-10-06 04:26:46', '2021-10-06 04:26:46'),
(192, 'en', 'customer', 'Customer', '2021-10-06 04:26:46', '2021-10-06 04:26:46'),
(193, 'en', 'order', 'Order', '2021-10-06 04:26:46', '2021-10-06 04:26:46'),
(194, 'en', 'product_category', 'Product category', '2021-10-06 04:26:46', '2021-10-06 04:26:46'),
(195, 'en', 'product_brand', 'Product brand', '2021-10-06 04:26:46', '2021-10-06 04:26:46'),
(196, 'en', 'products', 'Products', '2021-10-06 04:26:46', '2021-10-06 04:26:46'),
(197, 'en', 'category_wise_product_sale', 'Category wise product sale', '2021-10-06 04:26:46', '2021-10-06 04:26:46'),
(198, 'en', 'category_wise_product_stock', 'Category wise product stock', '2021-10-06 04:26:46', '2021-10-06 04:26:46'),
(199, 'en', 'top_12_products', 'Top 12 Products', '2021-10-06 04:26:46', '2021-10-06 04:26:46'),
(200, 'en', 'total_published_products', 'Total published products', '2021-10-06 04:26:46', '2021-10-06 04:26:46'),
(201, 'en', 'total_sellers_products', 'Total sellers products', '2021-10-06 04:26:46', '2021-10-06 04:26:46'),
(202, 'en', 'total_admin_products', 'Total admin products', '2021-10-06 04:26:46', '2021-10-06 04:26:46'),
(203, 'en', 'total_sellers', 'Total sellers', '2021-10-06 04:26:46', '2021-10-06 04:26:46'),
(204, 'en', 'total_approved_sellers', 'Total approved sellers', '2021-10-06 04:26:46', '2021-10-06 04:26:46'),
(205, 'en', 'total_pending_sellers', 'Total pending sellers', '2021-10-06 04:26:46', '2021-10-06 04:26:46'),
(206, 'en', 'number_of_sale', 'Number of sale', '2021-10-06 04:26:46', '2021-10-06 04:26:46'),
(207, 'en', 'number_of_stock', 'Number of Stock', '2021-10-06 04:26:46', '2021-10-06 04:26:46'),
(208, 'en', 'search_in_menu', 'Search in menu', '2021-10-06 04:26:46', '2021-10-06 04:26:46'),
(209, 'en', 'dashboard', 'Dashboard', '2021-10-06 04:26:46', '2021-10-06 04:26:46'),
(210, 'en', 'pos_system', 'POS System', '2021-10-06 04:26:46', '2021-10-06 04:26:46'),
(211, 'en', 'pos_manager', 'POS Manager', '2021-10-06 04:26:46', '2021-10-06 04:26:46'),
(212, 'en', 'pos_configuration', 'POS Configuration', '2021-10-06 04:26:46', '2021-10-06 04:26:46'),
(213, 'en', 'add_new_product', 'Add New product', '2021-10-06 04:26:46', '2021-10-06 04:26:46'),
(214, 'en', 'all_products', 'All Products', '2021-10-06 04:26:46', '2021-10-06 04:26:46'),
(215, 'en', 'in_house_products', 'In House Products', '2021-10-06 04:26:46', '2021-10-06 04:26:46'),
(216, 'en', 'seller_products', 'Seller Products', '2021-10-06 04:26:46', '2021-10-06 04:26:46'),
(217, 'en', 'digital_products', 'Digital Products', '2021-10-06 04:26:46', '2021-10-06 04:26:46'),
(218, 'en', 'bulk_import', 'Bulk Import', '2021-10-06 04:26:46', '2021-10-06 04:26:46'),
(219, 'en', 'bulk_export', 'Bulk Export', '2021-10-06 04:26:46', '2021-10-06 04:26:46'),
(220, 'en', 'category', 'Category', '2021-10-06 04:26:46', '2021-10-06 04:26:46'),
(221, 'en', 'brand', 'Brand', '2021-10-06 04:26:46', '2021-10-06 04:26:46'),
(222, 'en', 'attribute', 'Attribute', '2021-10-06 04:26:46', '2021-10-06 04:26:46'),
(223, 'en', 'colors', 'Colors', '2021-10-06 04:26:46', '2021-10-06 04:26:46'),
(224, 'en', 'product_reviews', 'Product Reviews', '2021-10-06 04:26:46', '2021-10-06 04:26:46'),
(225, 'en', 'auction_products', 'Auction Products', '2021-10-06 04:26:46', '2021-10-06 04:26:46'),
(226, 'en', 'add_new_auction_product', 'Add New auction product', '2021-10-06 04:26:46', '2021-10-06 04:26:46'),
(227, 'en', 'all_auction_products', 'All Auction Products', '2021-10-06 04:26:46', '2021-10-06 04:26:46'),
(228, 'en', 'all_product', 'All Product', '2021-10-06 04:26:49', '2021-10-06 04:26:49'),
(229, 'en', 'bulk_action', 'Bulk Action', '2021-10-06 04:26:49', '2021-10-06 04:26:49'),
(230, 'en', 'delete_selection', 'Delete selection', '2021-10-06 04:26:49', '2021-10-06 04:26:49'),
(231, 'en', 'sort_by', 'Sort By', '2021-10-06 04:26:49', '2021-10-06 04:26:49'),
(232, 'en', 'rating_high__low', 'Rating (High > Low)', '2021-10-06 04:26:49', '2021-10-06 04:26:49'),
(233, 'en', 'rating_low__high', 'Rating (Low > High)', '2021-10-06 04:26:49', '2021-10-06 04:26:49'),
(234, 'en', 'num_of_sale_high__low', 'Num of Sale (High > Low)', '2021-10-06 04:26:49', '2021-10-06 04:26:49'),
(235, 'en', 'num_of_sale_low__high', 'Num of Sale (Low > High)', '2021-10-06 04:26:49', '2021-10-06 04:26:49'),
(236, 'en', 'base_price_high__low', 'Base Price (High > Low)', '2021-10-06 04:26:49', '2021-10-06 04:26:49'),
(237, 'en', 'base_price_low__high', 'Base Price (Low > High)', '2021-10-06 04:26:49', '2021-10-06 04:26:49'),
(238, 'en', 'type__enter', 'Type & Enter', '2021-10-06 04:26:49', '2021-10-06 04:26:49'),
(239, 'en', 'name', 'Name', '2021-10-06 04:26:49', '2021-10-06 04:26:49'),
(240, 'en', 'added_by', 'Added By', '2021-10-06 04:26:49', '2021-10-06 04:26:49'),
(241, 'en', 'info', 'Info', '2021-10-06 04:26:49', '2021-10-06 04:26:49'),
(242, 'en', 'total_stock', 'Total Stock', '2021-10-06 04:26:49', '2021-10-06 04:26:49'),
(243, 'en', 'todays_deal', 'Todays Deal', '2021-10-06 04:26:49', '2021-10-06 04:26:49'),
(244, 'en', 'published', 'Published', '2021-10-06 04:26:49', '2021-10-06 04:26:49'),
(245, 'en', 'featured', 'Featured', '2021-10-06 04:26:49', '2021-10-06 04:26:49'),
(246, 'en', 'options', 'Options', '2021-10-06 04:26:49', '2021-10-06 04:26:49'),
(247, 'en', 'num_of_sale', 'Num of Sale', '2021-10-06 04:26:49', '2021-10-06 04:26:49'),
(248, 'en', 'times', 'times', '2021-10-06 04:26:49', '2021-10-06 04:26:49'),
(249, 'en', 'base_price', 'Base Price', '2021-10-06 04:26:49', '2021-10-06 04:26:49'),
(250, 'en', 'rating', 'Rating', '2021-10-06 04:26:49', '2021-10-06 04:26:49'),
(251, 'en', 'view', 'View', '2021-10-06 04:26:49', '2021-10-06 04:26:49'),
(252, 'en', 'edit', 'Edit', '2021-10-06 04:26:49', '2021-10-06 04:26:49'),
(253, 'en', 'duplicate', 'Duplicate', '2021-10-06 04:26:49', '2021-10-06 04:26:49'),
(254, 'en', 'delete_confirmation', 'Delete Confirmation', '2021-10-06 04:26:49', '2021-10-06 04:26:49'),
(255, 'en', 'are_you_sure_to_delete_this', 'Are you sure to delete this?', '2021-10-06 04:26:49', '2021-10-06 04:26:49'),
(256, 'en', 'todays_deal_updated_successfully', 'Todays Deal updated successfully', '2021-10-06 04:26:49', '2021-10-06 04:26:49'),
(257, 'en', 'something_went_wrong', 'Something went wrong', '2021-10-06 04:26:49', '2021-10-06 04:26:49'),
(258, 'en', 'published_products_updated_successfully', 'Published products updated successfully', '2021-10-06 04:26:49', '2021-10-06 04:26:49'),
(259, 'en', 'product_approval_update_successfully', 'Product approval update successfully', '2021-10-06 04:26:49', '2021-10-06 04:26:49'),
(260, 'en', 'featured_products_updated_successfully', 'Featured products updated successfully', '2021-10-06 04:26:49', '2021-10-06 04:26:49'),
(261, 'en', 'edit_product', 'Edit Product', '2021-10-06 04:26:53', '2021-10-06 04:26:53'),
(262, 'en', 'product_name', 'Product Name', '2021-10-06 04:26:53', '2021-10-06 04:26:53'),
(263, 'en', 'translatable', 'Translatable', '2021-10-06 04:26:53', '2021-10-06 04:26:53'),
(264, 'en', 'select_brand', 'Select Brand', '2021-10-06 04:26:53', '2021-10-06 04:26:53'),
(265, 'en', 'unit', 'Unit', '2021-10-06 04:26:53', '2021-10-06 04:26:53'),
(266, 'en', 'unit_eg_kg_pc_etc', 'Unit (e.g. KG, Pc etc)', '2021-10-06 04:26:53', '2021-10-06 04:26:53'),
(267, 'en', 'minimum_purchase_qty', 'Minimum Purchase Qty', '2021-10-06 04:26:53', '2021-10-06 04:26:53'),
(268, 'en', 'tags', 'Tags', '2021-10-06 04:26:53', '2021-10-06 04:26:53'),
(269, 'en', 'type_to_add_a_tag', 'Type to add a tag', '2021-10-06 04:26:53', '2021-10-06 04:26:53'),
(270, 'en', 'barcode', 'Barcode', '2021-10-06 04:26:53', '2021-10-06 04:26:53'),
(271, 'en', 'refundable', 'Refundable', '2021-10-06 04:26:53', '2021-10-06 04:26:53'),
(272, 'en', 'product_images', 'Product Images', '2021-10-06 04:26:53', '2021-10-06 04:26:53'),
(273, 'en', 'gallery_images', 'Gallery Images', '2021-10-06 04:26:53', '2021-10-06 04:26:53'),
(274, 'en', 'thumbnail_image', 'Thumbnail Image', '2021-10-06 04:26:53', '2021-10-06 04:26:53'),
(275, 'en', 'product_videos', 'Product Videos', '2021-10-06 04:26:53', '2021-10-06 04:26:53'),
(276, 'en', 'video_provider', 'Video Provider', '2021-10-06 04:26:53', '2021-10-06 04:26:53'),
(277, 'en', 'youtube', 'Youtube', '2021-10-06 04:26:53', '2021-10-06 04:26:53'),
(278, 'en', 'dailymotion', 'Dailymotion', '2021-10-06 04:26:53', '2021-10-06 04:26:53'),
(279, 'en', 'vimeo', 'Vimeo', '2021-10-06 04:26:53', '2021-10-06 04:26:53'),
(280, 'en', 'video_link', 'Video Link', '2021-10-06 04:26:53', '2021-10-06 04:26:53'),
(281, 'en', 'product_variation', 'Product Variation', '2021-10-06 04:26:53', '2021-10-06 04:26:53'),
(282, 'en', 'attributes', 'Attributes', '2021-10-06 04:26:53', '2021-10-06 04:26:53'),
(283, 'en', 'choose_attributes', 'Choose Attributes', '2021-10-06 04:26:53', '2021-10-06 04:26:53'),
(284, 'en', 'choose_the_attributes_of_this_product_and_then_input_values_of_each_attribute', 'Choose the attributes of this product and then input values of each attribute', '2021-10-06 04:26:53', '2021-10-06 04:26:53'),
(285, 'en', 'product_price__stock', 'Product price + stock', '2021-10-06 04:26:53', '2021-10-06 04:26:53'),
(286, 'en', 'unit_price', 'Unit price', '2021-10-06 04:26:53', '2021-10-06 04:26:53'),
(287, 'en', 'discount_date_range', 'Discount Date Range', '2021-10-06 04:26:53', '2021-10-06 04:26:53'),
(288, 'en', 'select_date', 'Select Date', '2021-10-06 04:26:53', '2021-10-06 04:26:53'),
(289, 'en', 'discount', 'Discount', '2021-10-06 04:26:53', '2021-10-06 04:26:53'),
(290, 'en', 'flat', 'Flat', '2021-10-06 04:26:53', '2021-10-06 04:26:53'),
(291, 'en', 'percent', 'Percent', '2021-10-06 04:26:53', '2021-10-06 04:26:53'),
(292, 'en', 'set_point', 'Set Point', '2021-10-06 04:26:53', '2021-10-06 04:26:53'),
(293, 'en', '1', '1', '2021-10-06 04:26:53', '2021-10-06 04:26:53'),
(294, 'en', 'quantity', 'Quantity', '2021-10-06 04:26:53', '2021-10-06 04:26:53'),
(295, 'en', 'sku', 'SKU', '2021-10-06 04:26:54', '2021-10-06 04:26:54'),
(296, 'en', 'external_link', 'External link', '2021-10-06 04:26:54', '2021-10-06 04:26:54'),
(297, 'en', 'leave_it_blank_if_you_do_not_use_external_site_link', 'Leave it blank if you do not use external site link', '2021-10-06 04:26:54', '2021-10-06 04:26:54'),
(298, 'en', 'product_description', 'Product Description', '2021-10-06 04:26:54', '2021-10-06 04:26:54'),
(299, 'en', 'description', 'Description', '2021-10-06 04:26:54', '2021-10-06 04:26:54'),
(300, 'en', 'product_shipping_cost', 'Product Shipping Cost', '2021-10-06 04:26:54', '2021-10-06 04:26:54'),
(301, 'en', 'pdf_specification', 'PDF Specification', '2021-10-06 04:26:54', '2021-10-06 04:26:54'),
(302, 'en', 'seo_meta_tags', 'SEO Meta Tags', '2021-10-06 04:26:54', '2021-10-06 04:26:54'),
(303, 'en', 'meta_title', 'Meta Title', '2021-10-06 04:26:54', '2021-10-06 04:26:54'),
(304, 'en', 'meta_images', 'Meta Images', '2021-10-06 04:26:54', '2021-10-06 04:26:54'),
(305, 'en', 'slug', 'Slug', '2021-10-06 04:26:54', '2021-10-06 04:26:54'),
(306, 'en', 'free_shipping', 'Free Shipping', '2021-10-06 04:26:54', '2021-10-06 04:26:54'),
(307, 'en', 'flat_rate', 'Flat Rate', '2021-10-06 04:26:54', '2021-10-06 04:26:54'),
(308, 'en', 'shipping_cost', 'Shipping cost', '2021-10-06 04:26:54', '2021-10-06 04:26:54'),
(309, 'en', 'is_product_quantity_mulitiply', 'Is Product Quantity Mulitiply', '2021-10-06 04:26:54', '2021-10-06 04:26:54'),
(310, 'en', 'low_stock_quantity_warning', 'Low Stock Quantity Warning', '2021-10-06 04:26:54', '2021-10-06 04:26:54'),
(311, 'en', 'stock_visibility_state', 'Stock Visibility State', '2021-10-06 04:26:54', '2021-10-06 04:26:54'),
(312, 'en', 'show_stock_quantity', 'Show Stock Quantity', '2021-10-06 04:26:54', '2021-10-06 04:26:54'),
(313, 'en', 'show_stock_with_text_only', 'Show Stock With Text Only', '2021-10-06 04:26:54', '2021-10-06 04:26:54'),
(314, 'en', 'hide_stock', 'Hide Stock', '2021-10-06 04:26:54', '2021-10-06 04:26:54'),
(315, 'en', 'cash_on_delivery', 'Cash On Delivery', '2021-10-06 04:26:54', '2021-10-06 04:26:54'),
(316, 'en', 'status', 'Status', '2021-10-06 04:26:54', '2021-10-06 04:26:54'),
(317, 'en', 'flash_deal', 'Flash Deal', '2021-10-06 04:26:54', '2021-10-06 04:26:54'),
(318, 'en', 'add_to_flash', 'Add To Flash', '2021-10-06 04:26:54', '2021-10-06 04:26:54'),
(319, 'en', 'discount_type', 'Discount Type', '2021-10-06 04:26:54', '2021-10-06 04:26:54'),
(320, 'en', 'estimate_shipping_time', 'Estimate Shipping Time', '2021-10-06 04:26:54', '2021-10-06 04:26:54'),
(321, 'en', 'shipping_days', 'Shipping Days', '2021-10-06 04:26:54', '2021-10-06 04:26:54'),
(322, 'en', 'days', 'Days', '2021-10-06 04:26:54', '2021-10-06 04:26:54'),
(323, 'en', 'tax', 'Tax', '2021-10-06 04:26:54', '2021-10-06 04:26:54'),
(324, 'en', 'update_product', 'Update Product', '2021-10-06 04:26:54', '2021-10-06 04:26:54'),
(325, 'en', 'choice_title', 'Choice Title', '2021-10-06 04:26:54', '2021-10-06 04:26:54'),
(326, 'en', 'variant', 'Variant', '2021-10-06 04:26:55', '2021-10-06 04:26:55'),
(327, 'en', 'variant_price', 'Variant Price', '2021-10-06 04:26:55', '2021-10-06 04:26:55'),
(328, 'en', 'photo', 'Photo', '2021-10-06 04:26:55', '2021-10-06 04:26:55'),
(329, 'en', 'product_has_been_updated_successfully', 'Product has been updated successfully', '2021-10-06 04:27:41', '2021-10-06 04:27:41'),
(330, 'en', 'language_changed_to_', 'Language changed to ', '2021-10-06 04:27:50', '2021-10-06 04:27:50'),
(331, 'en', 'filters', 'Filters', '2021-10-06 04:27:51', '2021-10-06 04:27:51'),
(332, 'en', 'price_range', 'Price range', '2021-10-06 04:27:51', '2021-10-06 04:27:51'),
(333, 'en', 'filter_by', 'Filter by', '2021-10-06 04:27:51', '2021-10-06 04:27:51'),
(334, 'en', 'filter_by_color', 'Filter by color', '2021-10-06 04:27:51', '2021-10-06 04:27:51'),
(335, 'en', 'brands', 'Brands', '2021-10-06 04:27:51', '2021-10-06 04:27:51'),
(336, 'en', 'newest', 'Newest', '2021-10-06 04:27:51', '2021-10-06 04:27:51'),
(337, 'en', 'oldest', 'Oldest', '2021-10-06 04:27:51', '2021-10-06 04:27:51'),
(338, 'en', 'price_low_to_high', 'Price low to high', '2021-10-06 04:27:51', '2021-10-06 04:27:51'),
(339, 'en', 'price_high_to_low', 'Price high to low', '2021-10-06 04:27:51', '2021-10-06 04:27:51'),
(340, 'en', 'add_to_wishlist', 'Add to wishlist', '2021-10-06 04:27:51', '2021-10-06 04:27:51'),
(341, 'en', 'add_to_compare', 'Add to compare', '2021-10-06 04:27:51', '2021-10-06 04:27:51'),
(342, 'en', 'add_to_cart', 'Add to cart', '2021-10-06 04:27:51', '2021-10-06 04:27:51'),
(343, 'en', 'club_point', 'Club Point', '2021-10-06 04:27:51', '2021-10-06 04:27:51'),
(344, 'en', 'search_result_for_', 'Search result for ', '2021-10-06 04:28:12', '2021-10-06 04:28:12'),
(345, 'en', 'popular_suggestions', 'Popular Suggestions', '2021-10-06 04:32:39', '2021-10-06 04:32:39'),
(346, 'en', 'category_suggestions', 'Category Suggestions', '2021-10-06 04:32:39', '2021-10-06 04:32:39'),
(347, 'en', 'shops', 'Shops', '2021-10-06 04:32:40', '2021-10-06 04:32:40'),
(348, 'en', 'reviews', 'reviews', '2021-10-06 04:41:49', '2021-10-06 04:41:49'),
(349, 'en', 'reviews', 'reviews', '2021-10-06 04:41:49', '2021-10-06 04:41:49'),
(350, 'en', 'sold_by', 'Sold by', '2021-10-06 04:41:49', '2021-10-06 04:41:49'),
(351, 'en', 'inhouse_product', 'Inhouse product', '2021-10-06 04:41:49', '2021-10-06 04:41:49'),
(352, 'en', 'message_seller', 'Message Seller', '2021-10-06 04:41:49', '2021-10-06 04:41:49'),
(353, 'en', 'price', 'Price', '2021-10-06 04:41:49', '2021-10-06 04:41:49'),
(354, 'en', 'price', 'Price', '2021-10-06 04:41:49', '2021-10-06 04:41:49'),
(355, 'en', 'color', 'Color', '2021-10-06 04:41:50', '2021-10-06 04:41:50'),
(356, 'en', 'available', 'available', '2021-10-06 04:41:50', '2021-10-06 04:41:50'),
(357, 'en', 'total_price', 'Total Price', '2021-10-06 04:41:50', '2021-10-06 04:41:50'),
(358, 'en', 'buy_now', 'Buy Now', '2021-10-06 04:41:50', '2021-10-06 04:41:50'),
(359, 'en', 'out_of_stock', 'Out of Stock', '2021-10-06 04:41:50', '2021-10-06 04:41:50'),
(360, 'en', 'sorry_for_the_inconvenience_but_were_working_on_it', 'Sorry for the inconvenience, but we\'re working on it.', '2021-10-06 04:41:50', '2021-10-06 04:41:50'),
(361, 'en', 'sorry_for_the_inconvenience_but_were_working_on_it', 'Sorry for the inconvenience, but we\'re working on it.', '2021-10-06 04:41:50', '2021-10-06 04:41:50'),
(362, 'en', 'error_code', 'Error code', '2021-10-06 04:41:50', '2021-10-06 04:41:50'),
(363, 'en', 'hot', 'Hot', '2021-10-06 05:08:42', '2021-10-06 05:08:42'),
(364, 'en', 'view_more', 'View More', '2021-10-06 05:08:42', '2021-10-06 05:08:42'),
(365, 'en', 'classified_ads', 'Classified Ads', '2021-10-06 05:08:43', '2021-10-06 05:08:43'),
(366, 'en', 'new', 'new', '2021-10-06 05:08:43', '2021-10-06 05:08:43'),
(367, 'en', 'used', 'Used', '2021-10-06 05:08:43', '2021-10-06 05:08:43'),
(368, 'en', 'top_10_categories', 'Top 10 Categories', '2021-10-06 05:08:43', '2021-10-06 05:08:43'),
(369, 'en', 'view_all_categories', 'View All Categories', '2021-10-06 05:08:43', '2021-10-06 05:08:43'),
(370, 'en', 'top_10_brands', 'Top 10 Brands', '2021-10-06 05:08:43', '2021-10-06 05:08:43'),
(371, 'en', 'view_all_brands', 'View All Brands', '2021-10-06 05:08:43', '2021-10-06 05:08:43'),
(372, 'en', 'best_selling', 'Best Selling', '2021-10-06 05:08:44', '2021-10-06 05:08:44'),
(373, 'en', 'featured_products', 'Featured Products', '2021-10-06 05:08:44', '2021-10-06 05:08:44'),
(374, 'en', 'best_sellers', 'Best Sellers', '2021-10-06 05:08:44', '2021-10-06 05:08:44'),
(375, 'en', 'view_all_sellers', 'View All Sellers', '2021-10-06 05:08:44', '2021-10-06 05:08:44'),
(376, 'en', 'visit_store', 'Visit Store', '2021-10-06 05:08:44', '2021-10-06 05:08:44'),
(377, 'en', 'top_20', 'Top 20', '2021-10-07 04:29:09', '2021-10-07 04:29:09'),
(378, 'en', 'welcome_to', 'Welcome to', '2021-10-07 04:29:24', '2021-10-07 04:29:24'),
(379, 'en', 'login_to_your_account', 'Login to your account.', '2021-10-07 04:29:24', '2021-10-07 04:29:24'),
(380, 'en', 'password', 'Password', '2021-10-07 04:29:24', '2021-10-07 04:29:24'),
(381, 'en', 'remember_me', 'Remember Me', '2021-10-07 04:29:24', '2021-10-07 04:29:24'),
(382, 'en', 'installed_addon', 'Installed Addon', '2021-10-07 04:29:33', '2021-10-07 04:29:33'),
(383, 'en', 'available_addon', 'Available Addon', '2021-10-07 04:29:33', '2021-10-07 04:29:33'),
(384, 'en', 'installupdate_addon', 'Install/Update Addon', '2021-10-07 04:29:33', '2021-10-07 04:29:33'),
(385, 'en', 'version', 'Version', '2021-10-07 04:29:33', '2021-10-07 04:29:33'),
(386, 'en', 'purchase_code', 'Purchase code', '2021-10-07 04:29:33', '2021-10-07 04:29:33'),
(387, 'en', 'status_updated_successfully', 'Status updated successfully', '2021-10-07 04:29:33', '2021-10-07 04:29:33'),
(388, 'en', 'zip_file', 'Zip File', '2021-10-07 04:29:39', '2021-10-07 04:29:39'),
(389, 'en', 'installupdate', 'Install/Update', '2021-10-07 04:29:39', '2021-10-07 04:29:39'),
(390, 'en', 'this_addon_is_updated_successfully', 'This addon is updated successfully', '2021-10-07 04:29:49', '2021-10-07 04:29:49'),
(391, 'en', 'total_sale', 'Total sale', '2021-10-07 04:30:08', '2021-10-07 04:30:08'),
(392, 'en', 'total_earnings', 'Total earnings', '2021-10-07 04:30:08', '2021-10-07 04:30:08'),
(393, 'en', 'successful_orders', 'Successful orders', '2021-10-07 04:30:08', '2021-10-07 04:30:08'),
(394, 'en', 'orders', 'Orders', '2021-10-07 04:30:08', '2021-10-07 04:30:08'),
(395, 'en', 'total_orders', 'Total orders', '2021-10-07 04:30:08', '2021-10-07 04:30:08'),
(396, 'en', 'pending_orders', 'Pending orders', '2021-10-07 04:30:08', '2021-10-07 04:30:08'),
(397, 'en', 'cancelled_orders', 'Cancelled orders', '2021-10-07 04:30:08', '2021-10-07 04:30:08'),
(398, 'en', 'product', 'Product', '2021-10-07 04:30:08', '2021-10-07 04:30:08'),
(399, 'en', 'purchased_package', 'Purchased Package', '2021-10-07 04:30:08', '2021-10-07 04:30:08'),
(400, 'en', 'product_upload_remaining', 'Product Upload Remaining', '2021-10-07 04:30:08', '2021-10-07 04:30:08'),
(401, 'en', 'digital_product_upload_remaining', 'Digital Product Upload Remaining', '2021-10-07 04:30:08', '2021-10-07 04:30:08'),
(402, 'en', 'auction_product_upload_remaining', 'Auction Product Upload Remaining', '2021-10-07 04:30:08', '2021-10-07 04:30:08'),
(403, 'en', 'package_expires_at', 'Package Expires at', '2021-10-07 04:30:08', '2021-10-07 04:30:08'),
(404, 'en', 'current_package', 'Current Package', '2021-10-07 04:30:08', '2021-10-07 04:30:08'),
(405, 'en', 'upgrade_package', 'Upgrade Package', '2021-10-07 04:30:08', '2021-10-07 04:30:08'),
(406, 'en', 'shop', 'Shop', '2021-10-07 04:30:09', '2021-10-07 04:30:09'),
(407, 'en', 'manage__organize_your_shop', 'Manage & organize your shop', '2021-10-07 04:30:09', '2021-10-07 04:30:09'),
(408, 'en', 'go_to_setting', 'Go to setting', '2021-10-07 04:30:09', '2021-10-07 04:30:09'),
(409, 'en', 'payment', 'Payment', '2021-10-07 04:30:09', '2021-10-07 04:30:09'),
(410, 'en', 'configure_your_payment_method', 'Configure your payment method', '2021-10-07 04:30:09', '2021-10-07 04:30:09'),
(411, 'en', 'purchase_history', 'Purchase History', '2021-10-07 04:30:09', '2021-10-07 04:30:09'),
(412, 'en', 'downloads', 'Downloads', '2021-10-07 04:30:09', '2021-10-07 04:30:09'),
(413, 'en', 'sent_refund_request', 'Sent Refund Request', '2021-10-07 04:30:09', '2021-10-07 04:30:09'),
(414, 'en', 'product_bulk_upload', 'Product Bulk Upload', '2021-10-07 04:30:09', '2021-10-07 04:30:09'),
(415, 'en', 'auction_product_orders', 'Auction Product Orders', '2021-10-07 04:30:09', '2021-10-07 04:30:09'),
(416, 'en', 'auction', 'Auction', '2021-10-07 04:30:09', '2021-10-07 04:30:09'),
(417, 'en', 'bidded_products', 'Bidded Products', '2021-10-07 04:30:09', '2021-10-07 04:30:09'),
(418, 'en', 'received_refund_request', 'Received Refund Request', '2021-10-07 04:30:09', '2021-10-07 04:30:09'),
(419, 'en', 'shop_setting', 'Shop Setting', '2021-10-07 04:30:09', '2021-10-07 04:30:09'),
(420, 'en', 'payment_history', 'Payment History', '2021-10-07 04:30:09', '2021-10-07 04:30:09'),
(421, 'en', 'money_withdraw', 'Money Withdraw', '2021-10-07 04:30:09', '2021-10-07 04:30:09'),
(422, 'en', 'conversations', 'Conversations', '2021-10-07 04:30:09', '2021-10-07 04:30:09'),
(423, 'en', 'my_wallet', 'My Wallet', '2021-10-07 04:30:09', '2021-10-07 04:30:09'),
(424, 'en', 'earning_points', 'Earning Points', '2021-10-07 04:30:09', '2021-10-07 04:30:09'),
(425, 'en', 'no_notification_found', 'No notification found', '2021-10-07 04:30:09', '2021-10-07 04:30:09'),
(426, 'en', 'support_ticket', 'Support Ticket', '2021-10-07 04:43:40', '2021-10-07 04:43:40'),
(427, 'en', 'manage_profile', 'Manage Profile', '2021-10-07 04:43:40', '2021-10-07 04:43:40'),
(428, 'en', 'sold_amount', 'Sold Amount', '2021-10-07 04:43:40', '2021-10-07 04:43:40'),
(429, 'en', 'your_sold_amount_current_month', 'Your sold amount (current month)', '2021-10-07 04:43:40', '2021-10-07 04:43:40'),
(430, 'en', 'total_sold', 'Total Sold', '2021-10-07 04:43:40', '2021-10-07 04:43:40'),
(431, 'en', 'last_month_sold', 'Last Month Sold', '2021-10-07 04:43:40', '2021-10-07 04:43:40'),
(432, 'en', 'item_has_been_added_to_wishlist', 'Item has been added to wishlist', '2021-10-07 04:43:40', '2021-10-07 04:43:40'),
(433, 'en', 'forgot_password', 'Forgot password?', '2021-10-07 04:43:46', '2021-10-07 04:43:46'),
(434, 'en', 'dont_have_an_account', 'Dont have an account?', '2021-10-07 04:43:46', '2021-10-07 04:43:46'),
(435, 'en', 'register_now', 'Register Now', '2021-10-07 04:43:46', '2021-10-07 04:43:46'),
(436, 'en', 'remaining_uploads', 'Remaining Uploads', '2021-10-07 04:43:52', '2021-10-07 04:43:52'),
(437, 'en', 'no_package_found', 'No Package Found', '2021-10-07 04:43:52', '2021-10-07 04:43:52'),
(438, 'en', 'available_status', 'Available Status', '2021-10-07 04:43:52', '2021-10-07 04:43:52'),
(439, 'en', 'admin_status', 'Admin Status', '2021-10-07 04:43:52', '2021-10-07 04:43:52'),
(440, 'en', 'status_has_been_updated_successfully', 'Status has been updated successfully', '2021-10-07 04:43:52', '2021-10-07 04:43:52'),
(441, 'en', 'email_or_phone', 'Email Or Phone', '2021-10-07 04:57:20', '2021-10-07 04:57:20'),
(442, 'en', 'use_country_code_before_number', 'Use country code before number', '2021-10-07 04:57:20', '2021-10-07 04:57:20'),
(443, 'en', 'create_an_account', 'Create an account.', '2021-10-07 04:57:25', '2021-10-07 04:57:25'),
(444, 'en', 'full_name', 'Full Name', '2021-10-07 04:57:25', '2021-10-07 04:57:25'),
(445, 'en', 'use_email_instead', 'Use Email Instead', '2021-10-07 04:57:25', '2021-10-07 04:57:25'),
(446, 'en', 'confirm_password', 'Confirm Password', '2021-10-07 04:57:25', '2021-10-07 04:57:25'),
(447, 'en', 'by_signing_up_you_agree_to_our_terms_and_conditions', 'By signing up you agree to our terms and conditions.', '2021-10-07 04:57:25', '2021-10-07 04:57:25'),
(448, 'en', 'create_account', 'Create Account', '2021-10-07 04:57:25', '2021-10-07 04:57:25'),
(449, 'en', 'already_have_an_account', 'Already have an account?', '2021-10-07 04:57:25', '2021-10-07 04:57:25'),
(450, 'en', 'log_in', 'Log In', '2021-10-07 04:57:25', '2021-10-07 04:57:25'),
(451, 'en', 'use_phone_instead', 'Use Phone Instead', '2021-10-07 04:57:25', '2021-10-07 04:57:25'),
(452, 'en', 'invalid_email_or_password', 'Invalid email or password', '2021-10-07 04:58:37', '2021-10-07 04:58:37'),
(453, 'en', 'in_your_cart', 'in your cart', '2021-10-07 05:09:56', '2021-10-07 05:09:56'),
(454, 'en', 'in_your_wishlist', 'in your wishlist', '2021-10-07 05:09:56', '2021-10-07 05:09:56'),
(455, 'en', 'you_ordered', 'you ordered', '2021-10-07 05:09:56', '2021-10-07 05:09:56'),
(456, 'en', 'default_shipping_address', 'Default Shipping Address', '2021-10-07 05:09:56', '2021-10-07 05:09:56'),
(457, 'en', 'country', 'Country', '2021-10-07 05:09:56', '2021-10-07 05:09:56'),
(458, 'en', 'city', 'City', '2021-10-07 05:09:56', '2021-10-07 05:09:56'),
(459, 'en', 'postal_code', 'Postal Code', '2021-10-07 05:09:56', '2021-10-07 05:09:56'),
(460, 'en', 'product_upload', 'Product Upload', '2021-10-07 05:09:56', '2021-10-07 05:09:56'),
(461, 'en', 'purchase_code', 'Purchase code', '2021-10-13 02:49:10', '2021-10-13 02:49:10'),
(462, 'en', 'share', 'Share', '2021-10-13 02:50:20', '2021-10-13 02:50:20'),
(463, 'en', 'customer_reviews', 'customer reviews', '2021-10-13 02:50:20', '2021-10-13 02:50:20'),
(464, 'en', 'top_selling_products', 'Top Selling Products', '2021-10-13 02:50:20', '2021-10-13 02:50:20'),
(465, 'en', 'video', 'Video', '2021-10-13 02:50:20', '2021-10-13 02:50:20'),
(466, 'en', 'download', 'Download', '2021-10-13 02:50:20', '2021-10-13 02:50:20'),
(467, 'en', 'there_have_been_no_reviews_for_this_product_yet', 'There have been no reviews for this product yet.', '2021-10-13 02:50:20', '2021-10-13 02:50:20'),
(468, 'en', 'related_products', 'Related products', '2021-10-13 02:50:20', '2021-10-13 02:50:20'),
(469, 'en', 'any_query_about_this_product', 'Any query about this product', '2021-10-13 02:50:20', '2021-10-13 02:50:20'),
(470, 'en', 'your_question', 'Your Question', '2021-10-13 02:50:20', '2021-10-13 02:50:20'),
(471, 'en', 'send', 'Send', '2021-10-13 02:50:20', '2021-10-13 02:50:20'),
(472, 'en', 'link_copied_to_clipboard', 'Link copied to clipboard', '2021-10-13 02:50:20', '2021-10-13 02:50:20'),
(473, 'en', 'oops_unable_to_copy', 'Oops, unable to copy', '2021-10-13 02:50:20', '2021-10-13 02:50:20'),
(474, 'en', 'item_added_to_your_cart', 'Item added to your cart!', '2021-10-13 02:51:05', '2021-10-13 02:51:05'),
(475, 'en', 'back_to_shopping', 'Back to shopping', '2021-10-13 02:51:06', '2021-10-13 02:51:06'),
(476, 'en', 'proceed_to_checkout', 'Proceed to Checkout', '2021-10-13 02:51:06', '2021-10-13 02:51:06'),
(477, 'en', '1_my_cart', '1. My Cart', '2021-10-13 02:51:06', '2021-10-13 02:51:06'),
(478, 'en', '2_shipping_info', '2. Shipping info', '2021-10-13 02:51:06', '2021-10-13 02:51:06'),
(479, 'en', '3_delivery_info', '3. Delivery info', '2021-10-13 02:51:06', '2021-10-13 02:51:06'),
(480, 'en', '4_payment', '4. Payment', '2021-10-13 02:51:06', '2021-10-13 02:51:06'),
(481, 'en', '5_confirmation', '5. Confirmation', '2021-10-13 02:51:06', '2021-10-13 02:51:06'),
(482, 'en', 'remove', 'Remove', '2021-10-13 02:51:06', '2021-10-13 02:51:06'),
(483, 'en', 'return_to_shop', 'Return to shop', '2021-10-13 02:51:06', '2021-10-13 02:51:06'),
(484, 'en', 'continue_to_shipping', 'Continue to Shipping', '2021-10-13 02:51:06', '2021-10-13 02:51:06'),
(485, 'en', 'add_new_address', 'Add New Address', '2021-10-13 02:51:49', '2021-10-13 02:51:49'),
(486, 'en', 'continue_to_delivery_info', 'Continue to Delivery Info', '2021-10-13 02:51:49', '2021-10-13 02:51:49'),
(487, 'en', 'new_address', 'New Address', '2021-10-13 02:51:49', '2021-10-13 02:51:49'),
(488, 'en', 'your_address', 'Your Address', '2021-10-13 02:51:49', '2021-10-13 02:51:49'),
(489, 'en', 'your_postal_code', 'Your Postal Code', '2021-10-13 02:51:49', '2021-10-13 02:51:49'),
(490, 'en', '880', '+880', '2021-10-13 02:51:49', '2021-10-13 02:51:49'),
(491, 'en', 'save', 'Save', '2021-10-13 02:51:49', '2021-10-13 02:51:49'),
(492, 'en', 'address_edit', 'Address Edit', '2021-10-13 02:51:49', '2021-10-13 02:51:49'),
(493, 'en', 'choose_delivery_type', 'Choose Delivery Type', '2021-10-13 02:51:52', '2021-10-13 02:51:52'),
(494, 'en', 'home_delivery', 'Home Delivery', '2021-10-13 02:51:52', '2021-10-13 02:51:52'),
(495, 'en', 'local_pickup', 'Local Pickup', '2021-10-13 02:51:52', '2021-10-13 02:51:52'),
(496, 'en', 'select_your_nearest_pickup_point', 'Select your nearest pickup point', '2021-10-13 02:51:52', '2021-10-13 02:51:52'),
(497, 'en', 'continue_to_payment', 'Continue to Payment', '2021-10-13 02:51:52', '2021-10-13 02:51:52'),
(498, 'en', 'select_a_payment_option', 'Select a payment option', '2021-10-13 02:51:54', '2021-10-13 02:51:54'),
(499, 'en', 'paypal', 'Paypal', '2021-10-13 02:51:54', '2021-10-13 02:51:54'),
(500, 'en', 'stripe', 'Stripe', '2021-10-13 02:51:54', '2021-10-13 02:51:54'),
(501, 'en', 'sslcommerz', 'sslcommerz', '2021-10-13 02:51:54', '2021-10-13 02:51:54'),
(502, 'en', 'instamojo', 'Instamojo', '2021-10-13 02:51:54', '2021-10-13 02:51:54'),
(503, 'en', 'razorpay', 'Razorpay', '2021-10-13 02:51:54', '2021-10-13 02:51:54'),
(504, 'en', 'paystack', 'Paystack', '2021-10-13 02:51:54', '2021-10-13 02:51:54'),
(505, 'en', 'voguepay', 'VoguePay', '2021-10-13 02:51:54', '2021-10-13 02:51:54'),
(506, 'en', 'payhere', 'payhere', '2021-10-13 02:51:54', '2021-10-13 02:51:54'),
(507, 'en', 'ngenius', 'ngenius', '2021-10-13 02:51:54', '2021-10-13 02:51:54'),
(508, 'en', 'iyzico', 'Iyzico', '2021-10-13 02:51:54', '2021-10-13 02:51:54'),
(509, 'en', 'nagad', 'Nagad', '2021-10-13 02:51:54', '2021-10-13 02:51:54'),
(510, 'en', 'bkash', 'Bkash', '2021-10-13 02:51:54', '2021-10-13 02:51:54'),
(511, 'en', 'proxypay', 'ProxyPay', '2021-10-13 02:51:54', '2021-10-13 02:51:54'),
(512, 'en', 'or', 'Or', '2021-10-13 02:51:54', '2021-10-13 02:51:54'),
(513, 'en', 'your_wallet_balance_', 'Your wallet balance :', '2021-10-13 02:51:54', '2021-10-13 02:51:54'),
(514, 'en', 'pay_with_wallet', 'Pay with wallet', '2021-10-13 02:51:54', '2021-10-13 02:51:54'),
(515, 'en', 'i_agree_to_the', 'I agree to the', '2021-10-13 02:51:54', '2021-10-13 02:51:54'),
(516, 'en', 'terms_and_conditions', 'terms and conditions', '2021-10-13 02:51:54', '2021-10-13 02:51:54'),
(517, 'en', 'complete_order', 'Complete Order', '2021-10-13 02:51:54', '2021-10-13 02:51:54'),
(518, 'en', 'summary', 'Summary', '2021-10-13 02:51:54', '2021-10-13 02:51:54'),
(519, 'en', 'items', 'Items', '2021-10-13 02:51:54', '2021-10-13 02:51:54'),
(520, 'en', 'total_shipping', 'Total Shipping', '2021-10-13 02:51:54', '2021-10-13 02:51:54'),
(521, 'en', 'have_coupon_code_enter_here', 'Have coupon code? Enter here', '2021-10-13 02:51:54', '2021-10-13 02:51:54'),
(522, 'en', 'apply', 'Apply', '2021-10-13 02:51:54', '2021-10-13 02:51:54'),
(523, 'en', 'you_need_to_agree_with_our_policies', 'You need to agree with our policies', '2021-10-13 02:51:54', '2021-10-13 02:51:54'),
(524, 'en', 'your_order_has_been_placed_successfully', 'Your order has been placed successfully', '2021-10-13 02:51:58', '2021-10-13 02:51:58'),
(525, 'en', 'thank_you_for_your_order', 'Thank You for Your Order!', '2021-10-13 02:52:55', '2021-10-13 02:52:55'),
(526, 'en', 'a_copy_or_your_order_summary_has_been_sent_to', 'A copy or your order summary has been sent to', '2021-10-13 02:52:55', '2021-10-13 02:52:55'),
(527, 'en', 'order_summary', 'Order Summary', '2021-10-13 02:52:55', '2021-10-13 02:52:55'),
(528, 'en', 'order_date', 'Order date', '2021-10-13 02:52:55', '2021-10-13 02:52:55'),
(529, 'en', 'shipping_address', 'Shipping address', '2021-10-13 02:52:55', '2021-10-13 02:52:55'),
(530, 'en', 'order_status', 'Order status', '2021-10-13 02:52:55', '2021-10-13 02:52:55');
INSERT INTO `translations` (`id`, `lang`, `lang_key`, `lang_value`, `created_at`, `updated_at`) VALUES
(531, 'en', 'pending', 'Pending', '2021-10-13 02:52:55', '2021-10-13 02:52:55'),
(532, 'en', 'total_order_amount', 'Total order amount', '2021-10-13 02:52:55', '2021-10-13 02:52:55'),
(533, 'en', 'flat_shipping_rate', 'Flat shipping rate', '2021-10-13 02:52:55', '2021-10-13 02:52:55'),
(534, 'en', 'payment_method', 'Payment method', '2021-10-13 02:52:55', '2021-10-13 02:52:55'),
(535, 'en', 'order_code', 'Order Code:', '2021-10-13 02:52:55', '2021-10-13 02:52:55'),
(536, 'en', 'order_details', 'Order Details', '2021-10-13 02:52:55', '2021-10-13 02:52:55'),
(537, 'en', 'variation', 'Variation', '2021-10-13 02:52:55', '2021-10-13 02:52:55'),
(538, 'en', 'delivery_type', 'Delivery Type', '2021-10-13 02:52:55', '2021-10-13 02:52:55'),
(539, 'en', 'coupon_discount', 'Coupon Discount', '2021-10-13 02:52:55', '2021-10-13 02:52:55'),
(540, 'en', 'another_product_exists_with_same_slug_please_change_the_slug', 'Another product exists with same slug. Please change the slug!', '2021-10-13 02:54:58', '2021-10-13 02:54:58'),
(541, 'en', 'default_language', 'Default Language', '2021-10-13 03:09:31', '2021-10-13 03:09:31'),
(542, 'en', 'add_new_language', 'Add New Language', '2021-10-13 03:09:31', '2021-10-13 03:09:31'),
(543, 'en', 'language', 'Language', '2021-10-13 03:09:31', '2021-10-13 03:09:31'),
(544, 'en', 'code', 'Code', '2021-10-13 03:09:31', '2021-10-13 03:09:31'),
(545, 'en', 'rtl', 'RTL', '2021-10-13 03:09:31', '2021-10-13 03:09:31'),
(546, 'en', 'translation', 'Translation', '2021-10-13 03:09:31', '2021-10-13 03:09:31'),
(547, 'en', 'type_key__enter', 'Type key & Enter', '2021-10-13 03:09:42', '2021-10-13 03:09:42'),
(548, 'en', 'key', 'Key', '2021-10-13 03:09:42', '2021-10-13 03:09:42'),
(549, 'en', 'value', 'Value', '2021-10-13 03:09:42', '2021-10-13 03:09:42'),
(550, 'en', 'copy_translations', 'Copy Translations', '2021-10-13 03:09:42', '2021-10-13 03:09:42'),
(551, 'en', 'wholesale_prices', 'Wholesale Prices', '2021-10-19 06:24:46', '2021-10-19 06:24:46'),
(552, 'en', 'min_qty', 'Min QTY', '2021-10-19 06:24:46', '2021-10-19 06:24:46'),
(553, 'en', 'max_qty', 'Max QTY', '2021-10-19 06:24:46', '2021-10-19 06:24:46'),
(554, 'en', 'price_per_piece', 'Price per piece', '2021-10-19 06:24:46', '2021-10-19 06:24:46'),
(555, 'en', 'add_more', 'Add More', '2021-10-19 06:24:46', '2021-10-19 06:24:46'),
(556, 'en', 'wholesale_products', 'Wholesale Products', '2021-10-19 06:24:47', '2021-10-19 06:24:47'),
(557, 'en', 'add_new_wholesale_product', 'Add new wholesale product', '2021-10-19 06:24:47', '2021-10-19 06:24:47'),
(558, 'en', 'all_wholesale_products', 'All wholesale products', '2021-10-19 06:24:47', '2021-10-19 06:24:47'),
(559, 'en', 'wholesale', 'Wholesale', '2021-10-19 06:24:50', '2021-10-19 06:24:50'),
(560, 'en', 'affiliate', 'Affiliate', '2021-10-19 06:32:59', '2021-10-19 06:32:59'),
(561, 'en', 'withdraw_request_history', 'Withdraw request history', '2021-10-19 06:32:59', '2021-10-19 06:32:59'),
(562, 'en', 'refund', 'Refund', '2021-10-19 06:35:51', '2021-10-19 06:35:51'),
(563, 'en', 'view_policy', 'View Policy', '2021-10-19 06:35:51', '2021-10-19 06:35:51'),
(564, 'en', 'congratulations', 'Congratulations', '2021-10-31 05:29:14', '2021-10-31 05:29:14'),
(565, 'en', 'you_have_successfully_completed_the_updating_process_please_login_to_continue', 'You have successfully completed the updating process. Please Login to continue', '2021-10-31 05:29:14', '2021-10-31 05:29:14'),
(566, 'en', 'go_to_home', 'Go to Home', '2021-10-31 05:29:14', '2021-10-31 05:29:14'),
(567, 'en', 'login_to_admin_panel', 'Login to Admin panel', '2021-10-31 05:29:14', '2021-10-31 05:29:14'),
(568, 'en', 'payment_histories', 'Payment Histories', '2021-10-31 05:31:24', '2021-10-31 05:31:24'),
(568, 'en', 'collected_histories', 'Collected Histories', '2021-10-31 05:31:24', '2021-10-31 05:31:24'),
(569, 'en', 'shipping_states', 'Shipping States', '2021-10-31 05:31:24', '2021-10-31 05:31:24'),
(570, 'en', 'clear_cache', 'Clear Cache', '2021-10-31 05:31:24', '2021-10-31 05:31:24'),
(571, 'en', 'all_states', 'All States', '2021-10-31 05:31:31', '2021-10-31 05:31:31'),
(572, 'en', 'states', 'States', '2021-10-31 05:31:31', '2021-10-31 05:31:31'),
(573, 'en', 'type_state_name', 'Type state name', '2021-10-31 05:31:31', '2021-10-31 05:31:31'),
(574, 'en', 'select_country', 'Select Country', '2021-10-31 05:31:31', '2021-10-31 05:31:31'),
(575, 'en', 'filter', 'Filter', '2021-10-31 05:31:31', '2021-10-31 05:31:31'),
(576, 'en', 'showhide', 'Show/Hide', '2021-10-31 05:31:31', '2021-10-31 05:31:31'),
(577, 'en', 'action', 'Action', '2021-10-31 05:31:31', '2021-10-31 05:31:31'),
(578, 'en', 'add_new_state', 'Add New State', '2021-10-31 05:31:31', '2021-10-31 05:31:31'),
(579, 'en', 'country_status_updated_successfully', 'Country status updated successfully', '2021-10-31 05:31:31', '2021-10-31 05:31:31'),
(580, 'en', 'package_not_found', 'Package Not Found', '2021-10-31 06:15:14', '2021-10-31 06:15:14'),
(581, 'en', 'all_payment_list', 'All Payment List', '2021-10-31 07:15:02', '2021-10-31 07:15:02'),
(582, 'en', 'payment_list', 'Payment List', '2021-10-31 07:15:02', '2021-10-31 07:15:02'),
(583, 'en', 'type_email_or_name__enter', 'Type email or name & Enter', '2021-10-31 07:15:02', '2021-10-31 07:15:02'),
(584, 'en', 'payment_amount', 'Payment Amount', '2021-10-31 07:15:02', '2021-10-31 07:15:02'),
(585, 'en', 'created_at', 'Created At', '2021-10-31 07:15:02', '2021-10-31 07:15:02'),
(586, 'en', 'all_collection_list', 'All Collection List', '2021-10-31 07:15:03', '2021-10-31 07:15:03'),
(587, 'en', 'collection_list', 'Collection List', '2021-10-31 07:15:03', '2021-10-31 07:15:03'),
(588, 'en', 'collected_amount', 'Collected Amount', '2021-10-31 07:15:03', '2021-10-31 07:15:03'),
(589, 'en', 'delivery_boy_information', 'Delivery Boy Information', '2021-10-31 07:15:07', '2021-10-31 07:15:07'),
(590, 'en', 'state', 'State', '2021-10-31 07:15:07', '2021-10-31 07:15:07'),
(591, 'en', 'image', 'Image', '2021-10-31 07:15:07', '2021-10-31 07:15:07'),
(592, 'en', 'all_delivery_boys', 'All Delivery Boys', '2021-11-02 06:39:12', '2021-11-02 06:39:12'),
(593, 'en', 'add_new_delivery_boy', 'Add New Delivery Boy', '2021-11-02 06:39:12', '2021-11-02 06:39:12'),
(594, 'en', 'delivery_boys', 'Delivery Boys', '2021-11-02 06:39:12', '2021-11-02 06:39:12'),
(595, 'en', 'email_address', 'Email Address', '2021-11-02 06:39:12', '2021-11-02 06:39:12'),
(596, 'en', 'earning', 'Earning', '2021-11-02 06:39:12', '2021-11-02 06:39:12'),
(597, 'en', 'collection', 'Collection', '2021-11-02 06:39:12', '2021-11-02 06:39:12'),
(598, 'en', 'ban_this_delivery_boy', 'Ban this delivery boy', '2021-11-02 06:39:13', '2021-11-02 06:39:13'),
(599, 'en', 'go_to_collection', 'Go to Collection', '2021-11-02 06:39:13', '2021-11-02 06:39:13'),
(600, 'en', 'go_to_payment', 'Go to Payment', '2021-11-02 06:39:13', '2021-11-02 06:39:13'),
(601, 'en', 'do_you_really_want_to_ban_this_delivery_boy', 'Do you really want to ban this delivery_boy?', '2021-11-02 06:39:13', '2021-11-02 06:39:13'),
(602, 'en', 'proceed', 'Proceed!', '2021-11-02 06:39:13', '2021-11-02 06:39:13'),
(603, 'en', 'do_you_really_want_to_unban_this_delivery_boy', 'Do you really want to unban this delivery_boy?', '2021-11-02 06:39:13', '2021-11-02 06:39:13'),
(604, 'en', 'delivery_boy_has_been_created_successfully', 'Delivery Boy has been created successfully', '2021-11-02 06:39:25', '2021-11-02 06:39:25'),
(605, 'en', 'delivery_boy_has_been_updated_successfully', 'Delivery Boy has been updated successfully', '2021-11-02 06:40:00', '2021-11-02 06:40:00'),
(606, 'en', 'new_password', 'New Password', '2021-11-02 06:42:29', '2021-11-02 06:42:29'),
(607, 'en', 'avatar', 'Avatar', '2021-11-02 06:42:29', '2021-11-02 06:42:29'),
(608, 'en', 'off', 'OFF', '2021-11-09 17:20:10', '2021-11-09 17:20:10'),
(609, 'en', 'invalid_login_credentials', 'Invalid login credentials', '2021-11-09 17:20:44', '2021-11-09 17:20:44'),
(610, 'en', 'help_line', 'Help line', '2021-11-15 06:12:12', '2021-11-15 06:12:12'),
(611, 'en', 'all_seller_packages', 'All Seller Packages', '2021-11-15 06:13:40', '2021-11-15 06:13:40'),
(612, 'en', 'add_new_package', 'Add New Package', '2021-11-15 06:13:40', '2021-11-15 06:13:40'),
(613, 'en', 'package_logo', 'Package Logo', '2021-11-15 06:13:40', '2021-11-15 06:13:40'),
(614, 'en', 'digital_product_upload', 'Digital Product Upload', '2021-11-15 06:13:40', '2021-11-15 06:13:40'),
(615, 'en', 'auction_product_upload', 'Auction Product Upload', '2021-11-15 06:13:40', '2021-11-15 06:13:40'),
(616, 'en', 'package_duration', 'Package Duration', '2021-11-15 06:13:40', '2021-11-15 06:13:40'),
(617, 'en', 'product_upload_limit', 'Product Upload Limit', '2021-11-15 06:17:18', '2021-11-15 06:17:18'),
(618, 'en', 'update_package_information', 'Update Package Information', '2021-11-15 06:17:26', '2021-11-15 06:17:26'),
(619, 'en', 'package_name', 'Package Name', '2021-11-15 06:17:26', '2021-11-15 06:17:26'),
(620, 'en', 'amount', 'Amount', '2021-11-15 06:17:26', '2021-11-15 06:17:26'),
(621, 'en', 'duration', 'Duration', '2021-11-15 06:17:26', '2021-11-15 06:17:26'),
(622, 'en', 'validity_in_number_of_days', 'Validity in number of days', '2021-11-15 06:17:26', '2021-11-15 06:17:26'),
(623, 'en', 'package_has_been_inserted_successfully', 'Package has been inserted successfully', '2021-11-15 06:17:32', '2021-11-15 06:17:32'),
(624, 'en', 'cache_cleared_successfully', 'Cache cleared successfully', '2021-11-15 06:18:34', '2021-11-15 06:18:34'),
(625, 'en', 'premium_packages_for_sellers', 'Premium Packages for Sellers', '2021-11-15 06:19:06', '2021-11-15 06:19:06'),
(626, 'en', 'purchase_package', 'Purchase Package', '2021-11-15 06:19:06', '2021-11-15 06:19:06'),
(627, 'en', 'select_payment_type', 'Select Payment Type', '2021-11-15 06:19:06', '2021-11-15 06:19:06'),
(628, 'en', 'payment_type', 'Payment Type', '2021-11-15 06:19:06', '2021-11-15 06:19:06'),
(629, 'en', 'select_one', 'Select One', '2021-11-15 06:19:06', '2021-11-15 06:19:06'),
(630, 'en', 'online_payment', 'Online payment', '2021-11-15 06:19:06', '2021-11-15 06:19:06'),
(631, 'en', 'offline_payment', 'Offline payment', '2021-11-15 06:19:06', '2021-11-15 06:19:06'),
(632, 'en', 'purchase_your_package', 'Purchase Your Package', '2021-11-15 06:19:06', '2021-11-15 06:19:06'),
(633, 'en', 'mpesa', 'mpesa', '2021-11-15 06:19:06', '2021-11-15 06:19:06'),
(634, 'en', 'flutterwave', 'flutterwave', '2021-11-15 06:19:06', '2021-11-15 06:19:06'),
(635, 'en', 'payfast', 'payfast', '2021-11-15 06:19:06', '2021-11-15 06:19:06'),
(636, 'en', 'confirm', 'Confirm', '2021-11-15 06:19:06', '2021-11-15 06:19:06'),
(637, 'en', 'offline_package_payment', 'Offline Package Payment', '2021-11-15 06:19:06', '2021-11-15 06:19:06'),
(638, 'en', 'transaction_id', 'Transaction ID', '2021-11-15 06:30:53', '2021-11-15 06:30:53'),
(639, 'en', 'choose_image', 'Choose image', '2021-11-15 06:30:53', '2021-11-15 06:30:53'),
(640, 'en', 'select_file', 'Select File', '2021-11-15 06:32:05', '2021-11-15 06:32:05'),
(641, 'en', 'upload_new', 'Upload New', '2021-11-15 06:32:05', '2021-11-15 06:32:05'),
(642, 'en', 'sort_by_newest', 'Sort by newest', '2021-11-15 06:32:05', '2021-11-15 06:32:05'),
(643, 'en', 'sort_by_oldest', 'Sort by oldest', '2021-11-15 06:32:05', '2021-11-15 06:32:05'),
(644, 'en', 'sort_by_smallest', 'Sort by smallest', '2021-11-15 06:32:05', '2021-11-15 06:32:05'),
(645, 'en', 'sort_by_largest', 'Sort by largest', '2021-11-15 06:32:05', '2021-11-15 06:32:05'),
(646, 'en', 'selected_only', 'Selected Only', '2021-11-15 06:32:05', '2021-11-15 06:32:05'),
(647, 'en', 'search_your_files', 'Search your files', '2021-11-15 06:32:05', '2021-11-15 06:32:05'),
(648, 'en', 'no_files_found', 'No files found', '2021-11-15 06:32:05', '2021-11-15 06:32:05'),
(649, 'en', '0_file_selected', '0 File selected', '2021-11-15 06:32:05', '2021-11-15 06:32:05'),
(650, 'en', 'clear', 'Clear', '2021-11-15 06:32:05', '2021-11-15 06:32:05'),
(651, 'en', 'prev', 'Prev', '2021-11-15 06:32:05', '2021-11-15 06:32:05'),
(652, 'en', 'next', 'Next', '2021-11-15 06:32:05', '2021-11-15 06:32:05'),
(653, 'en', 'add_files', 'Add Files', '2021-11-15 06:32:05', '2021-11-15 06:32:05'),
(654, 'en', 'you_have_more_uploaded_products_than_this_package_limit_you_need_to_remove_excessive_products_to_downgrade', 'You have more uploaded products than this package limit. You need to remove excessive products to downgrade.', '2021-11-15 06:36:55', '2021-11-15 06:36:55'),
(655, 'en', 'external_link_button_text', 'External link button text', '2021-11-21 04:25:30', '2021-11-21 04:25:30'),
(656, 'en', 'website_header', 'Website Header', '2021-11-21 04:26:27', '2021-11-21 04:26:27'),
(657, 'en', 'header_setting', 'Header Setting', '2021-11-21 04:26:27', '2021-11-21 04:26:27'),
(658, 'en', 'header_logo', 'Header Logo', '2021-11-21 04:26:27', '2021-11-21 04:26:27'),
(659, 'en', 'show_language_switcher', 'Show Language Switcher?', '2021-11-21 04:26:27', '2021-11-21 04:26:27'),
(660, 'en', 'show_currency_switcher', 'Show Currency Switcher?', '2021-11-21 04:26:27', '2021-11-21 04:26:27'),
(661, 'en', 'enable_stikcy_header', 'Enable stikcy header?', '2021-11-21 04:26:27', '2021-11-21 04:26:27'),
(662, 'en', 'topbar_banner', 'Topbar Banner', '2021-11-21 04:26:27', '2021-11-21 04:26:27'),
(662, 'en', 'topbar_banner_link', 'Topbar Banner Link', '2021-11-21 04:26:27', '2021-11-21 04:26:27'),
(663, 'en', 'link_with', 'Link with', '2021-11-21 04:26:27', '2021-11-21 04:26:27'),
(664, 'en', 'help_line_number', 'Help line number', '2021-11-21 04:26:27', '2021-11-21 04:26:27'),
(665, 'en', 'header_nav_menu', 'Header Nav Menu', '2021-11-21 04:26:27', '2021-11-21 04:26:27'),
(666, 'en', 'label', 'Label', '2021-11-21 04:26:27', '2021-11-21 04:26:27'),
(667, 'en', 'add_new', 'Add New', '2021-11-21 04:26:27', '2021-11-21 04:26:27'),
(668, 'en', 'settings_updated_successfully', 'Settings updated successfully', '2021-11-21 04:26:32', '2021-11-21 04:26:32'),
(669, 'en', 'system_name', 'System Name', '2021-11-21 04:43:48', '2021-11-21 04:43:48'),
(670, 'en', 'system_logo__white', 'System Logo - White', '2021-11-21 04:43:48', '2021-11-21 04:43:48'),
(671, 'en', 'choose_files', 'Choose Files', '2021-11-21 04:43:48', '2021-11-21 04:43:48'),
(672, 'en', 'will_be_used_in_admin_panel_side_menu', 'Will be used in admin panel side menu', '2021-11-21 04:43:48', '2021-11-21 04:43:48'),
(673, 'en', 'system_logo__black', 'System Logo - Black', '2021-11-21 04:43:48', '2021-11-21 04:43:48'),
(674, 'en', 'will_be_used_in_admin_panel_topbar_in_mobile__admin_login_page', 'Will be used in admin panel topbar in mobile + Admin login page', '2021-11-21 04:43:48', '2021-11-21 04:43:48'),
(675, 'en', 'system_timezone', 'System Timezone', '2021-11-21 04:43:48', '2021-11-21 04:43:48'),
(676, 'en', 'admin_login_page_background', 'Admin login page background', '2021-11-21 04:43:48', '2021-11-21 04:43:48'),
(677, 'en', 'https_activation', 'HTTPS Activation', '2021-11-21 04:43:52', '2021-11-21 04:43:52'),
(678, 'en', 'maintenance_mode_activation', 'Maintenance Mode Activation', '2021-11-21 04:43:52', '2021-11-21 04:43:52'),
(679, 'en', 'disable_image_encoding', 'Disable image encoding?', '2021-11-21 04:43:52', '2021-11-21 04:43:52'),
(680, 'en', 'business_related', 'Business Related', '2021-11-21 04:43:52', '2021-11-21 04:43:52'),
(681, 'en', 'vendor_system_activation', 'Vendor System Activation', '2021-11-21 04:43:52', '2021-11-21 04:43:52'),
(682, 'en', 'classified_product', 'Classified Product', '2021-11-21 04:43:52', '2021-11-21 04:43:52'),
(683, 'en', 'wallet_system_activation', 'Wallet System Activation', '2021-11-21 04:43:53', '2021-11-21 04:43:53'),
(684, 'en', 'coupon_system_activation', 'Coupon System Activation', '2021-11-21 04:43:53', '2021-11-21 04:43:53'),
(685, 'en', 'pickup_point_activation', 'Pickup Point Activation', '2021-11-21 04:43:53', '2021-11-21 04:43:53'),
(686, 'en', 'conversation_activation', 'Conversation Activation', '2021-11-21 04:43:53', '2021-11-21 04:43:53'),
(687, 'en', 'seller_product_manage_by_admin', 'Seller Product Manage By Admin', '2021-11-21 04:43:53', '2021-11-21 04:43:53'),
(688, 'en', 'after_activate_this_option_cash_on_delivery_of_seller_product_will_be_managed_by_admin', 'After activate this option Cash On Delivery of Seller product will be managed by Admin', '2021-11-21 04:43:53', '2021-11-21 04:43:53'),
(689, 'en', 'admin_approval_on_seller_product', 'Admin Approval On Seller Product', '2021-11-21 04:43:53', '2021-11-21 04:43:53'),
(670, 'en', 'after_activate_this_option_admin_approval_need_to_seller_product', 'After activate this option, Admin approval need to seller product', '2021-11-21 04:43:53', '2021-11-21 04:43:53'),
(672, 'en', 'email_verification', 'Email Verification', '2021-11-21 04:43:53', '2021-11-21 04:43:53'),
(672, 'en', 'payment_related', 'Payment Related', '2021-11-21 04:43:53', '2021-11-21 04:43:53'),
(673, 'en', 'paypal_payment_activation', 'Paypal Payment Activation', '2021-11-21 04:43:53', '2021-11-21 04:43:53'),
(674, 'en', 'you_need_to_configure_paypal_correctly_to_enable_this_feature', 'You need to configure Paypal correctly to enable this feature', '2021-11-21 04:43:53', '2021-11-21 04:43:53'),
(675, 'en', 'stripe_payment_activation', 'Stripe Payment Activation', '2021-11-21 04:43:53', '2021-11-21 04:43:53'),
(676, 'en', 'sslcommerz_activation', 'SSlCommerz Activation', '2021-11-21 04:43:53', '2021-11-21 04:43:53'),
(676, 'en', 'instamojo_payment_activation', 'Instamojo Payment Activation', '2021-11-21 04:43:53', '2021-11-21 04:43:53'),
(678, 'en', 'you_need_to_configure_instamojo_payment_correctly_to_enable_this_feature', 'You need to configure Instamojo Payment correctly to enable this feature', '2021-11-21 04:43:53', '2021-11-21 04:43:53'),
(679, 'en', 'razor_pay_activation', 'Razor Pay Activation', '2021-11-21 04:43:53', '2021-11-21 04:43:53'),
(680, 'en', 'you_need_to_configure_razor_correctly_to_enable_this_feature', 'You need to configure Razor correctly to enable this feature', '2021-11-21 04:43:53', '2021-11-21 04:43:53'),
(681, 'en', 'paystack_activation', 'PayStack Activation', '2021-11-21 04:43:53', '2021-11-21 04:43:53'),
(682, 'en', 'you_need_to_configure_paystack_correctly_to_enable_this_feature', 'You need to configure PayStack correctly to enable this feature', '2021-11-21 04:43:53', '2021-11-21 04:43:53'),
(683, 'en', 'voguepay_activation', 'VoguePay Activation', '2021-11-21 04:43:53', '2021-11-21 04:43:53'),
(684, 'en', 'you_need_to_configure_voguepay_correctly_to_enable_this_feature', 'You need to configure VoguePay correctly to enable this feature', '2021-11-21 04:43:53', '2021-11-21 04:43:53'),
(685, 'en', 'payhere_activation', 'Payhere Activation', '2021-11-21 04:43:53', '2021-11-21 04:43:53'),
(686, 'en', 'ngenius_activation', 'Ngenius Activation', '2021-11-21 04:43:53', '2021-11-21 04:43:53'),
(687, 'en', 'you_need_to_configure_ngenius_correctly_to_enable_this_feature', 'You need to configure Ngenius correctly to enable this feature', '2021-11-21 04:43:53', '2021-11-21 04:43:53'),
(688, 'en', 'iyzico_activation', 'Iyzico Activation', '2021-11-21 04:43:53', '2021-11-21 04:43:53'),
(689, 'en', 'you_need_to_configure_iyzico_correctly_to_enable_this_feature', 'You need to configure iyzico correctly to enable this feature', '2021-11-21 04:43:53', '2021-11-21 04:43:53'),
(690, 'en', 'bkash_activation', 'Bkash Activation', '2021-11-21 04:43:53', '2021-11-21 04:43:53'),
(691, 'en', 'you_need_to_configure_bkash_correctly_to_enable_this_feature', 'You need to configure bkash correctly to enable this feature', '2021-11-21 04:43:53', '2021-11-21 04:43:53'),
(692, 'en', 'nagad_activation', 'Nagad Activation', '2021-11-21 04:43:53', '2021-11-21 04:43:53'),
(693, 'en', 'you_need_to_configure_nagad_correctly_to_enable_this_feature', 'You need to configure nagad correctly to enable this feature', '2021-11-21 04:43:53', '2021-11-21 04:43:53'),
(694, 'en', 'proxy_pay_activation', 'Proxy Pay Activation', '2021-11-21 04:43:53', '2021-11-21 04:43:53'),
(695, 'en', 'you_need_to_configure_proxypay_correctly_to_enable_this_feature', 'You need to configure proxypay correctly to enable this feature', '2021-11-21 04:43:53', '2021-11-21 04:43:53'),
(696, 'en', 'amarpay_activation', 'Amarpay Activation', '2021-11-21 04:43:53', '2021-11-21 04:43:53'),
(697, 'en', 'you_need_to_configure_amarpay_correctly_to_enable_this_feature', 'You need to configure amarpay correctly to enable this feature', '2021-11-21 04:43:53', '2021-11-21 04:43:53'),
(698, 'en', 'authorize_net_activation', 'Authorize Net Activation', '2021-11-21 04:43:53', '2021-11-21 04:43:53'),
(699, 'en', 'you_need_to_configure_authorize_net_correctly_to_enable_this_feature', 'You need to configure authorize net correctly to enable this feature', '2021-11-21 04:43:53', '2021-11-21 04:43:53'),
(700, 'en', 'payku_net_activation', 'Payku Net Activation', '2021-11-21 04:43:53', '2021-11-21 04:43:53'),
(701, 'en', 'you_need_to_configure_payku_net_correctly_to_enable_this_feature', 'You need to configure payku net correctly to enable this feature', '2021-11-21 04:43:53', '2021-11-21 04:43:53'),
(702, 'en', 'cash_payment_activation', 'Cash Payment Activation', '2021-11-21 04:43:53', '2021-11-21 04:43:53'),
(703, 'en', 'social_media_login', 'Social Media Login', '2021-11-21 04:43:53', '2021-11-21 04:43:53'),
(704, 'en', 'facebook_login', 'Facebook login', '2021-11-21 04:43:53', '2021-11-21 04:43:53'),
(705, 'en', 'you_need_to_configure_facebook_client_correctly_to_enable_this_feature', 'You need to configure Facebook Client correctly to enable this feature', '2021-11-21 04:43:53', '2021-11-21 04:43:53'),
(706, 'en', 'google_login', 'Google login', '2021-11-21 04:43:53', '2021-11-21 04:43:53'),
(707, 'en', 'you_need_to_configure_google_client_correctly_to_enable_this_feature', 'You need to configure Google Client correctly to enable this feature', '2021-11-21 04:43:53', '2021-11-21 04:43:53'),
(708, 'en', 'twitter_login', 'Twitter login', '2021-11-21 04:43:53', '2021-11-21 04:43:53'),
(709, 'en', 'you_need_to_configure_twitter_client_correctly_to_enable_this_feature', 'You need to configure Twitter Client correctly to enable this feature', '2021-11-21 04:43:53', '2021-11-21 04:43:53'),
(710, 'en', 'step_1', 'Step 1', '2021-11-24 01:59:13', '2021-11-24 01:59:13'),
(711, 'en', 'download_the_skeleton_file_and_fill_it_with_proper_data', 'Download the skeleton file and fill it with proper data', '2021-11-24 01:59:13', '2021-11-24 01:59:13'),
(712, 'en', 'you_can_download_the_example_file_to_understand_how_the_data_must_be_filled', 'You can download the example file to understand how the data must be filled', '2021-11-24 01:59:13', '2021-11-24 01:59:13'),
(713, 'en', 'once_you_have_downloaded_and_filled_the_skeleton_file_upload_it_in_the_form_below_and_submit', 'Once you have downloaded and filled the skeleton file, upload it in the form below and submit', '2021-11-24 01:59:13', '2021-11-24 01:59:13');
INSERT INTO `translations` (`id`, `lang`, `lang_key`, `lang_value`, `created_at`, `updated_at`) VALUES
(714, 'en', 'after_uploading_products_you_need_to_edit_them_and_set_products_images_and_choices', 'After uploading products you need to edit them and set product\'s images and choices', '2021-11-24 01:59:13', '2021-11-24 01:59:13'),
(715, 'en', 'download_csv', 'Download CSV', '2021-11-24 01:59:13', '2021-11-24 01:59:13'),
(716, 'en', 'step_2', 'Step 2', '2021-11-24 01:59:13', '2021-11-24 01:59:13'),
(717, 'en', 'category_and_brand_should_be_in_numerical_id', 'Category and Brand should be in numerical id', '2021-11-24 01:59:13', '2021-11-24 01:59:13'),
(718, 'en', 'you_can_download_the_pdf_to_get_category_and_brand_id', 'You can download the pdf to get Category and Brand id', '2021-11-24 01:59:13', '2021-11-24 01:59:13'),
(719, 'en', 'download_category', 'Download Category', '2021-11-24 01:59:13', '2021-11-24 01:59:13'),
(720, 'en', 'download_brand', 'Download Brand', '2021-11-24 01:59:13', '2021-11-24 01:59:13'),
(721, 'en', 'upload_product_file', 'Upload Product File', '2021-11-24 01:59:13', '2021-11-24 01:59:13'),
(722, 'en', 'upload_csv', 'Upload CSV', '2021-11-24 01:59:13', '2021-11-24 01:59:13'),
(723, 'en', 'condition', 'Condition', '2021-11-24 03:46:58', '2021-11-24 03:46:58'),
(724, 'en', 'all_type', 'All Type', '2021-11-24 03:46:58', '2021-11-24 03:46:58'),
(725, 'en', 'change_order_status', 'Change Order Status', '2021-11-28 07:45:31', '2021-11-28 07:45:31'),
(726, 'en', 'choose_an_order_status', 'Choose an order status', '2021-11-28 07:45:31', '2021-11-28 07:45:31'),
(727, 'en', 'confirmed', 'Confirmed', '2021-11-28 07:45:31', '2021-11-28 07:45:31'),
(728, 'en', 'picked_up', 'Picked Up', '2021-11-28 07:45:31', '2021-11-28 07:45:31'),
(729, 'en', 'on_the_way', 'On The Way', '2021-11-28 07:45:32', '2021-11-28 07:45:32'),
(730, 'en', 'delivered', 'Delivered', '2021-11-28 07:45:32', '2021-11-28 07:45:32'),
(731, 'en', 'filter_by_delivery_status', 'Filter by Delivery Status', '2021-11-28 07:45:32', '2021-11-28 07:45:32'),
(732, 'en', 'filter_by_date', 'Filter by date', '2021-11-28 07:45:32', '2021-11-28 07:45:32'),
(733, 'en', 'type_order_code__hit_enter', 'Type Order code & hit Enter', '2021-11-28 07:45:32', '2021-11-28 07:45:32'),
(734, 'en', 'num_of_products', 'Num. of Products', '2021-11-28 07:45:32', '2021-11-28 07:45:32'),
(735, 'en', 'delivery_status', 'Delivery Status', '2021-11-28 07:45:32', '2021-11-28 07:45:32'),
(736, 'en', 'payment_status', 'Payment Status', '2021-11-28 07:45:32', '2021-11-28 07:45:32'),
(737, 'en', 'unpaid', 'Unpaid', '2021-11-28 07:45:32', '2021-11-28 07:45:32'),
(738, 'en', 'no_refund', 'No Refund', '2021-11-28 07:45:32', '2021-11-28 07:45:32'),
(739, 'en', 'download_invoice', 'Download Invoice', '2021-11-28 07:45:32', '2021-11-28 07:45:32'),
(740, 'en', 'paid', 'Paid', '2021-11-28 07:45:32', '2021-11-28 07:45:32'),
(741, 'en', 'assign_deliver_boy', 'Assign Deliver Boy', '2021-11-28 07:45:34', '2021-11-28 07:45:34'),
(742, 'en', 'select_delivery_boy', 'Select Delivery Boy', '2021-11-28 07:45:34', '2021-11-28 07:45:34'),
(743, 'en', 'tracking_code_optional', 'Tracking Code (optional)', '2021-11-28 07:45:34', '2021-11-28 07:45:34'),
(744, 'en', 'order_', 'Order #', '2021-11-29 01:19:24', '2021-11-29 01:19:24'),
(745, 'en', 'total_amount', 'Total amount', '2021-11-29 01:19:24', '2021-11-29 01:19:24'),
(746, 'en', 'qty', 'Qty', '2021-11-29 01:19:24', '2021-11-29 01:19:24'),
(747, 'en', 'sub_total', 'Sub Total', '2021-11-29 01:19:24', '2021-11-29 01:19:24'),
(748, 'en', 'delivery_boy_has_been_assigned', 'Delivery boy has been assigned', '2021-11-29 01:19:24', '2021-11-29 01:19:24'),
(749, 'en', 'delivery_status_has_been_updated', 'Delivery status has been updated', '2021-11-29 01:19:24', '2021-11-29 01:19:24'),
(750, 'en', 'payment_status_has_been_updated', 'Payment status has been updated', '2021-11-29 01:19:24', '2021-11-29 01:19:24'),
(751, 'en', 'order_tracking_code_has_been_updated', 'Order tracking code has been updated', '2021-11-29 01:19:24', '2021-11-29 01:19:24');

-- --------------------------------------------------------

--
-- Table structure for table `uploads`
--

CREATE TABLE `uploads` (
  `id` int(11) NOT NULL,
  `file_original_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `file_size` int(11) DEFAULT NULL,
  `extension` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `referred_by` int(11) DEFAULT NULL,
  `provider_id` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_type` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'customer',
  `name` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `verification_code` text COLLATE utf8_unicode_ci,
  `new_email_verificiation_code` text COLLATE utf8_unicode_ci,
  `password` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `device_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `avatar` varchar(256) COLLATE utf8_unicode_ci DEFAULT NULL,
  `avatar_original` varchar(256) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address` varchar(300) COLLATE utf8_unicode_ci DEFAULT NULL,
  `country` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `state` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `city` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `postal_code` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `balance` double(20,2) NOT NULL DEFAULT '0.00',
  `banned` tinyint(4) NOT NULL DEFAULT '0',
  `referral_code` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `customer_package_id` int(11) DEFAULT NULL,
  `remaining_uploads` int(11) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `referred_by`, `provider_id`, `user_type`, `name`, `email`, `email_verified_at`, `verification_code`, `new_email_verificiation_code`, `password`, `remember_token`, `device_token`, `avatar`, `avatar_original`, `address`, `country`, `state`, `city`, `postal_code`, `phone`, `balance`, `banned`, `referral_code`, `customer_package_id`, `remaining_uploads`, `created_at`, `updated_at`) VALUES
(10, NULL, NULL, 'seller', 'Mark And Spenser', 'seller@example.com', '2021-02-04 07:35:31', 'eyJpdiI6Im9GSDJcLzQwMGszVGFZQW4yOWFLRWhnPT0iLCJ2YWx1ZSI6Ilo1dGxcL21IRHpRTVZFV3I5UGxJb1ZBPT0iLCJtYWMiOiI5NTcxZTkyNWYxYjJjYzk3MmNkNjMyMTdlOGNjY2Y2ODVmMmRiYmU3N2NmNGYzN2U1OTZlOGNhYzdjMTM1MGQ5In0=', NULL, '$2y$10$vuvwEQTd9W0LOSwKqMfKw.J6CpvSrmOXe3SPamaYAbVIwe.nqI2JW', '9q8TsVruc6lrcXhs6D7njFpqBaRtQgVUhENRSvDVNAqF7vjmEi6Bxi75riW6', NULL, NULL, '988', NULL, NULL, NULL, NULL, NULL, NULL, 0.00, 0, NULL, NULL, 0, '2021-02-04 07:35:31', '2021-02-25 23:14:14'),

-- --------------------------------------------------------

--
-- Table structure for table `wallets`
--

CREATE TABLE `wallets` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `amount` double(20,2) NOT NULL,
  `payment_method` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `payment_details` longtext COLLATE utf8_unicode_ci,
  `approval` int(1) NOT NULL DEFAULT '0',
  `offline_payment` int(1) NOT NULL DEFAULT '0',
  `reciept` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Table structure for table `wholesale_prices`
--

CREATE TABLE `wholesale_prices` (
  `id` int(11) NOT NULL,
  `product_stock_id` int(11) NOT NULL,
  `min_qty` int(11) NOT NULL DEFAULT '0',
  `max_qty` int(11) NOT NULL DEFAULT '0',
  `price` double(20,2) NOT NULL DEFAULT '0.00',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Table structure for table `wishlists`
--

CREATE TABLE `wishlists` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `addons`
--
ALTER TABLE `addons`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `addresses`
--
ALTER TABLE `addresses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `affiliate_configs`
--
ALTER TABLE `affiliate_configs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `affiliate_logs`
--
ALTER TABLE `affiliate_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `affiliate_options`
--
ALTER TABLE `affiliate_options`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `affiliate_payments`
--
ALTER TABLE `affiliate_payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `affiliate_stats`
--
ALTER TABLE `affiliate_stats`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `affiliate_users`
--
ALTER TABLE `affiliate_users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `affiliate_withdraw_requests`
--
ALTER TABLE `affiliate_withdraw_requests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `app_translations`
--
ALTER TABLE `app_translations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `attributes`
--
ALTER TABLE `attributes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `attribute_category`
--
ALTER TABLE `attribute_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `attribute_translations`
--
ALTER TABLE `attribute_translations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `attribute_values`
--
ALTER TABLE `attribute_values`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `auction_product_bids`
--
ALTER TABLE `auction_product_bids`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `blogs`
--
ALTER TABLE `blogs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `blog_categories`
--
ALTER TABLE `blog_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `brand_translations`
--
ALTER TABLE `brand_translations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `business_settings`
--
ALTER TABLE `business_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `slug` (`slug`);

--
-- Indexes for table `category_translations`
--
ALTER TABLE `category_translations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cities`
--
ALTER TABLE `cities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `city_translations`
--
ALTER TABLE `city_translations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `club_points`
--
ALTER TABLE `club_points`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `club_point_details`
--
ALTER TABLE `club_point_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `colors`
--
ALTER TABLE `colors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `combined_orders`
--
ALTER TABLE `combined_orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `commission_histories`
--
ALTER TABLE `commission_histories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `conversations`
--
ALTER TABLE `conversations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `coupons`
--
ALTER TABLE `coupons`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `coupon_usages`
--
ALTER TABLE `coupon_usages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `currencies`
--
ALTER TABLE `currencies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer_packages`
--
ALTER TABLE `customer_packages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer_package_payments`
--
ALTER TABLE `customer_package_payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer_package_translations`
--
ALTER TABLE `customer_package_translations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer_products`
--
ALTER TABLE `customer_products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer_product_translations`
--
ALTER TABLE `customer_product_translations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `delivery_boys`
--
ALTER TABLE `delivery_boys`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `delivery_boy_collections`
--
ALTER TABLE `delivery_boy_collections`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `delivery_boy_payments`
--
ALTER TABLE `delivery_boy_payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `delivery_histories`
--
ALTER TABLE `delivery_histories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `firebase_notifications`
--
ALTER TABLE `firebase_notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `flash_deals`
--
ALTER TABLE `flash_deals`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `flash_deal_products`
--
ALTER TABLE `flash_deal_products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `flash_deal_translations`
--
ALTER TABLE `flash_deal_translations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `home_categories`
--
ALTER TABLE `home_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `languages`
--
ALTER TABLE `languages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `manual_payment_methods`
--
ALTER TABLE `manual_payment_methods`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `otp_configurations`
--
ALTER TABLE `otp_configurations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `page_translations`
--
ALTER TABLE `page_translations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `payku_payments`
--
ALTER TABLE `payku_payments`
  ADD UNIQUE KEY `payku_payments_transaction_id_unique` (`transaction_id`);

--
-- Indexes for table `payku_transactions`
--
ALTER TABLE `payku_transactions`
  ADD UNIQUE KEY `payku_transactions_id_unique` (`id`),
  ADD UNIQUE KEY `payku_transactions_order_unique` (`order`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `pickup_points`
--
ALTER TABLE `pickup_points`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pickup_point_translations`
--
ALTER TABLE `pickup_point_translations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `name` (`name`),
  ADD KEY `tags` (`tags`(255)),
  ADD KEY `unit_price` (`unit_price`),
  ADD KEY `created_at` (`created_at`);

--
-- Indexes for table `product_stocks`
--
ALTER TABLE `product_stocks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_taxes`
--
ALTER TABLE `product_taxes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_translations`
--
ALTER TABLE `product_translations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `proxypay_payments`
--
ALTER TABLE `proxypay_payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `refund_requests`
--
ALTER TABLE `refund_requests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role_translations`
--
ALTER TABLE `role_translations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `searches`
--
ALTER TABLE `searches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sellers`
--
ALTER TABLE `sellers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`);

--
-- Indexes for table `seller_packages`
--
ALTER TABLE `seller_packages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `seller_package_payments`
--
ALTER TABLE `seller_package_payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `seller_package_translations`
--
ALTER TABLE `seller_package_translations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `seller_withdraw_requests`
--
ALTER TABLE `seller_withdraw_requests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shops`
--
ALTER TABLE `shops`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sms_templates`
--
ALTER TABLE `sms_templates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `states`
--
ALTER TABLE `states`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subscribers`
--
ALTER TABLE `subscribers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `taxes`
--
ALTER TABLE `taxes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ticket_replies`
--
ALTER TABLE `ticket_replies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `translations`
--
ALTER TABLE `translations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `uploads`
--
ALTER TABLE `uploads`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `wallets`
--
ALTER TABLE `wallets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wholesale_prices`
--
ALTER TABLE `wholesale_prices`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wishlists`
--
ALTER TABLE `wishlists`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `addons`
--
ALTER TABLE `addons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `addresses`
--
ALTER TABLE `addresses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `affiliate_configs`
--
ALTER TABLE `affiliate_configs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `affiliate_logs`
--
ALTER TABLE `affiliate_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `affiliate_options`
--
ALTER TABLE `affiliate_options`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `affiliate_payments`
--
ALTER TABLE `affiliate_payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `affiliate_stats`
--
ALTER TABLE `affiliate_stats`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `affiliate_users`
--
ALTER TABLE `affiliate_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `affiliate_withdraw_requests`
--
ALTER TABLE `affiliate_withdraw_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `app_translations`
--
ALTER TABLE `app_translations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `attributes`
--
ALTER TABLE `attributes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `attribute_category`
--
ALTER TABLE `attribute_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `attribute_translations`
--
ALTER TABLE `attribute_translations`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `attribute_values`
--
ALTER TABLE `attribute_values`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `auction_product_bids`
--
ALTER TABLE `auction_product_bids`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `blogs`
--
ALTER TABLE `blogs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `blog_categories`
--
ALTER TABLE `blog_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=102;

--
-- AUTO_INCREMENT for table `brand_translations`
--
ALTER TABLE `brand_translations`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- AUTO_INCREMENT for table `business_settings`
--
ALTER TABLE `business_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=147;

--
-- AUTO_INCREMENT for table `carts`
--
ALTER TABLE `carts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=251;

--
-- AUTO_INCREMENT for table `category_translations`
--
ALTER TABLE `category_translations`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `cities`
--
ALTER TABLE `cities`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48357;

--
-- AUTO_INCREMENT for table `city_translations`
--
ALTER TABLE `city_translations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `club_points`
--
ALTER TABLE `club_points`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `club_point_details`
--
ALTER TABLE `club_point_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `colors`
--
ALTER TABLE `colors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=144;

--
-- AUTO_INCREMENT for table `combined_orders`
--
ALTER TABLE `combined_orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `commission_histories`
--
ALTER TABLE `commission_histories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `conversations`
--
ALTER TABLE `conversations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=297;

--
-- AUTO_INCREMENT for table `coupons`
--
ALTER TABLE `coupons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `coupon_usages`
--
ALTER TABLE `coupon_usages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `currencies`
--
ALTER TABLE `currencies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `customer_packages`
--
ALTER TABLE `customer_packages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `customer_package_payments`
--
ALTER TABLE `customer_package_payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customer_package_translations`
--
ALTER TABLE `customer_package_translations`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `customer_products`
--
ALTER TABLE `customer_products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `customer_product_translations`
--
ALTER TABLE `customer_product_translations`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `delivery_boys`
--
ALTER TABLE `delivery_boys`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `delivery_boy_collections`
--
ALTER TABLE `delivery_boy_collections`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `delivery_boy_payments`
--
ALTER TABLE `delivery_boy_payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `delivery_histories`
--
ALTER TABLE `delivery_histories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `firebase_notifications`
--
ALTER TABLE `firebase_notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `flash_deals`
--
ALTER TABLE `flash_deals`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `flash_deal_products`
--
ALTER TABLE `flash_deal_products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=228;

--
-- AUTO_INCREMENT for table `flash_deal_translations`
--
ALTER TABLE `flash_deal_translations`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `home_categories`
--
ALTER TABLE `home_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `languages`
--
ALTER TABLE `languages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `manual_payment_methods`
--
ALTER TABLE `manual_payment_methods`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `order_details`
--
ALTER TABLE `order_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `otp_configurations`
--
ALTER TABLE `otp_configurations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `page_translations`
--
ALTER TABLE `page_translations`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pickup_points`
--
ALTER TABLE `pickup_points`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `pickup_point_translations`
--
ALTER TABLE `pickup_point_translations`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=151;

--
-- AUTO_INCREMENT for table `product_stocks`
--
ALTER TABLE `product_stocks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=357;

--
-- AUTO_INCREMENT for table `product_taxes`
--
ALTER TABLE `product_taxes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=189;

--
-- AUTO_INCREMENT for table `product_translations`
--
ALTER TABLE `product_translations`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=146;

--
-- AUTO_INCREMENT for table `proxypay_payments`
--
ALTER TABLE `proxypay_payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `refund_requests`
--
ALTER TABLE `refund_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `role_translations`
--
ALTER TABLE `role_translations`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `searches`
--
ALTER TABLE `searches`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `sellers`
--
ALTER TABLE `sellers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `seller_packages`
--
ALTER TABLE `seller_packages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `seller_package_payments`
--
ALTER TABLE `seller_package_payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `seller_package_translations`
--
ALTER TABLE `seller_package_translations`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `seller_withdraw_requests`
--
ALTER TABLE `seller_withdraw_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `shops`
--
ALTER TABLE `shops`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `sms_templates`
--
ALTER TABLE `sms_templates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `states`
--
ALTER TABLE `states`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4122;

--
-- AUTO_INCREMENT for table `subscribers`
--
ALTER TABLE `subscribers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `taxes`
--
ALTER TABLE `taxes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `ticket_replies`
--
ALTER TABLE `ticket_replies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `translations`
--
ALTER TABLE `translations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1898;

--
-- AUTO_INCREMENT for table `uploads`
--
ALTER TABLE `uploads`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1010;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `wallets`
--
ALTER TABLE `wallets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `wholesale_prices`
--
ALTER TABLE `wholesale_prices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `wishlists`
--
ALTER TABLE `wishlists`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `payku_payments`
--
ALTER TABLE `payku_payments`
  ADD CONSTRAINT `payku_payments_transaction_id_foreign` FOREIGN KEY (`transaction_id`) REFERENCES `payku_transactions` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
