-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 26, 2025 at 07:52 PM
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
-- Database: `my_tourist_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `name`, `password`) VALUES
(1, 'admin', '202cb962ac59075b964b07152d234b70');

-- --------------------------------------------------------

--
-- Table structure for table `jazebe`
--

CREATE TABLE `jazebe` (
  `j_id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jazebe`
--

INSERT INTO `jazebe` (`j_id`, `title`, `description`, `image_path`, `updated_at`) VALUES
(2, 'چغازنبیل', 'چغازنبیل از جاهای دیدنی ایران است که در جنوب غرب ایران، نزدیک شهر تاریخی شوش، در استان خوزستان قرار دارد. همانطور که همه ما می‌دانیم یکی از قدیمی‌ترین شهرهای دنیا شوش است.\r\nاین بنا نمونه‌ای فوق‌العاده از معماری و سکونتگاه باستانی انسان است و فرهنگ و سرگذشت ایلامیان را نشان می‌دهد، به همین دلیل یکی از مهم‌ترین آثار ایران باستان محسوب می‌شود. زیگورات چغازنبیل در سال ۱۳۵۸ خورشیدی به‌عنوان اولین آثار تاریخی برجسته ایران زمین، همراه با نقش جهان اصفهان و تخت جمشید در فهرست جهانی یونسکو به ثبت رسید.‌', 'uploads/jazebe/693e9ab6ed4b2_1765710518.jpg', '2025-12-26 20:36:24');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `o_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(11) NOT NULL,
  `address` text NOT NULL,
  `code` varchar(20) NOT NULL,
  `t_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `travelers` int(11) DEFAULT 1,
  `notes` text DEFAULT NULL,
  `total_price` int(11) DEFAULT NULL,
  `tracking_code` varchar(50) DEFAULT NULL,
  `status` enum('pending','paid','cancelled') DEFAULT 'pending',
  `payment_date` timestamp NULL DEFAULT NULL,
  `payment_method` varchar(50) DEFAULT NULL,
  `card_number_last4` varchar(4) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`o_id`, `name`, `email`, `phone`, `address`, `code`, `t_id`, `user_id`, `travelers`, `notes`, `total_price`, `tracking_code`, `status`, `payment_date`, `payment_method`, `card_number_last4`, `created_at`) VALUES
(1, 'ریحانه رفیعی', 'reyhanerafee@gmail.com', '09056821241', 'تهران-مینی‌سیتی', '0123456789', 6, 1, 2, '0', 2000, 'TOUR-1766750828-1035', 'paid', '2025-12-26 12:09:19', 'card', '7890', '2025-12-26 12:07:08'),
(2, 'هانیه موسی زاده', 'hmz@gmail.com', '09126541870', 'تهران-اقدسیه', '1596324870', 6, 4, 5, '0', 750000, 'TOUR-1766774192-2368', 'paid', '2025-12-26 18:38:01', 'online', '7890', '2025-12-26 18:36:32');

-- --------------------------------------------------------

--
-- Table structure for table `tours`
--

CREATE TABLE `tours` (
  `t_id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `price` varchar(100) NOT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tours`
--

INSERT INTO `tours` (`t_id`, `title`, `description`, `image_path`, `price`, `updated_at`) VALUES
(6, 'تور 4 روزه مشهد', 'اقامت در هتلی ۳ یا ۴ ستاره در فاصله‌ای مناسب از حرم مطهر (معمولاً کمتر از ۱۵ دقیقه پیاده‌روی) صورت می‌گیرد که اتاق‌هایی استاندارد با امکانات رفاهی پایه دارد. رفت‌وآمد شامل ترانسفر فرودگاهی یا ایستگاه‌ریلی در بدو ورود و عزیمت، همچنین حمل‌ونقل رایگان به حرم در طول روز است. برنامه زیارتی متمرکز بر حرم امام رضا(ع) و صحن‌ها و روضه منوره است و زمان کافی برای زیارت، دعا و خرید از بازارهای اطراف حرم فراهم می‌شود. تغذیه شامل صبحانه در هتل و یک وعده ناهار یا شام در رستوران‌های محلی (غالباً با غذاهای ایرانی) است. در طول تور، امکان بازدید از جاذبه‌هایی مانند پارک‌ملت، بازار رضا یا آرامگاه فردوسی (بنا به برنامه) نیز وجود دارد.', 'uploads/tours/694e7867c6aaf_1766750311.jpg', '150000', '2025-12-26 19:29:28');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `repeat-password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `fullname`, `email`, `password`, `repeat-password`) VALUES
(1, 'Reyhaneh Rafiee', 'reyhanerafee@gmail.com', '7cf6f611b5dab6e8a34f6a3b6ef0d29e', '7cf6f611b5dab6e8a34f6a3b6ef0d29e'),
(2, 'Hanieh Vafaee', 'honey81@gmail.com', 'be2fc6855075311d91764a4713259f3f', 'be2fc6855075311d91764a4713259f3f'),
(3, 'Melika Mehrabian', 'melika.m@gmail.com', '725e84485b58783414112ea8935c45ad', '725e84485b58783414112ea8935c45ad'),
(4, 'Hanieh Musa', 'hmz@gmail.com', '0b6bdf1aee42ae723aea9ce3ac824e1a', '0b6bdf1aee42ae723aea9ce3ac824e1a');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jazebe`
--
ALTER TABLE `jazebe`
  ADD PRIMARY KEY (`j_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`o_id`),
  ADD UNIQUE KEY `tracking_code` (`tracking_code`);

--
-- Indexes for table `tours`
--
ALTER TABLE `tours`
  ADD PRIMARY KEY (`t_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `jazebe`
--
ALTER TABLE `jazebe`
  MODIFY `j_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `o_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tours`
--
ALTER TABLE `tours`
  MODIFY `t_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
