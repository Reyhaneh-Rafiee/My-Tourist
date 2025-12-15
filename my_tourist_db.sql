-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 15, 2025 at 05:21 AM
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
  `image_path` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jazebe`
--

INSERT INTO `jazebe` (`j_id`, `title`, `description`, `image_path`) VALUES
(1, 'قلعه فلک‌الافلاک', 'فَلَک‌الافلاک (که به نام‌های دژ سپهر سپهران و دژ شاپورخواست نیز شناخته می‌شود) قلعه‌ای تاریخی در مرکز شهر خرم‌آباد، استان لرستان است. این بنا به‌دلیل داشتن دوازده برج با عنوان قلعه دوازده‌بُرجی نیز معروف است.\r\nفلک‌الافلاک بر فراز تپه‌ای بلند مشرف به شهر خرم‌آباد و در کنار رودخانه قرار گرفته و به‌عنوان چشم‌گیرترین اثر تاریخی و گردشگری این شهر شناخته می‌شود. تاریخ ساخت قلعه به دوره ساسانیان بازمی‌گردد و در ۱۰ مهر ۱۳۴۸ با شماره ۸۸۳ در فهرست آثار ملی ایران به ثبت رسیده است.', 'uploads/jazebe/693e94c05621d_1765708992.jpg'),
(2, 'چغازنبیل', 'چغازنبیل از جاهای دیدنی ایران است که در جنوب غرب ایران، نزدیک شهر تاریخی شوش، در استان خوزستان قرار دارد. همانطور که همه ما می‌دانیم یکی از قدیمی‌ترین شهرهای دنیا شوش است.\r\nاین بنا نمونه‌ای فوق‌العاده از معماری و سکونتگاه باستانی انسان است و فرهنگ و سرگذشت ایلامیان (عیلامیان) را نشان می‌دهد، به همین دلیل یکی از مهم‌ترین آثار ایران باستان محسوب می‌شود. زیگورات چغازنبیل در سال ۱۳۵۸ خورشیدی به‌عنوان اولین آثار تاریخی برجسته ایران زمین، همراه با نقش جهان اصفهان و تخت جمشید در فهرست جهانی یونسکو به ثبت رسید.‌', 'uploads/jazebe/693e9ab6ed4b2_1765710518.jpg');

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
  `t_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tours`
--

CREATE TABLE `tours` (
  `t_id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `price` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tours`
--

INSERT INTO `tours` (`t_id`, `title`, `description`, `image_path`, `price`) VALUES
(1, 'تور نیم روزه ایران مال گردی', 'باغ دیدار ،بازار سنتی، شربت‌خانه برای پذیرایی، کتابخانه جندی‌شاپور، رستوران ملل، سینما باغ ماهان، مسجد جامع محمدرسول‌الله و آب‌نما . این مجموعه خدمات تورگردشگری با تورلیدر اختصاصی (۵۰۰,۰۰۰ تومان) و پذیرایی میان‌وعده (۵۰۰,۰۰۰ تومان) ارائه می‌دهد که پارکینگ آن رایگان بوده و ترانسفر به عهده گردشگر است. هزینه بازدید برای هر نفر در تورهای حداقل ۱۰ نفره ۱,۰۰۰,۰۰۰ تومان می‌باشد. بازدید روزانه از ساعت ۱۰ صبح تا ۱۳ از ورودی سینما انجام می‌شود .', 'uploads/tours/693eac42c5ccc_1765715010.jpg', '1000000');

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
  ADD PRIMARY KEY (`o_id`);

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
  MODIFY `o_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tours`
--
ALTER TABLE `tours`
  MODIFY `t_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
