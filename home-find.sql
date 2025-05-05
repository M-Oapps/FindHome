-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 05, 2025 at 03:21 PM
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
-- Database: `home-find`
--

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

CREATE TABLE `cities` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `cities`
--

INSERT INTO `cities` (`id`, `name`, `image`, `created_at`) VALUES
(1, 'Delhi', 'images/uploads/1745926854_blog-image-1.png', '2025-04-29 17:10:54'),
(2, 'Mumbai', 'images/uploads/1745928579_body-img-3.jpg', '2025-04-29 17:35:51'),
(3, 'Tamilnadu', 'images/uploads/1746089035_image.png', '2025-05-01 14:13:55');

-- --------------------------------------------------------

--
-- Table structure for table `properties`
--

CREATE TABLE `properties` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `type` varchar(100) DEFAULT NULL,
  `status` varchar(100) DEFAULT NULL,
  `rooms` int(11) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `area` varchar(100) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `state` varchar(100) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `neighborhood` varchar(100) DEFAULT NULL,
  `zip_code` varchar(20) DEFAULT NULL,
  `latitude` varchar(50) DEFAULT NULL,
  `longitude` varchar(50) DEFAULT NULL,
  `area_size` varchar(100) DEFAULT NULL,
  `size_prefix` varchar(50) DEFAULT NULL,
  `land_area` varchar(100) DEFAULT NULL,
  `land_area_postfix` varchar(50) DEFAULT NULL,
  `bedrooms` int(11) DEFAULT NULL,
  `bathrooms` int(11) DEFAULT NULL,
  `garages` varchar(255) DEFAULT 'Yes',
  `garage_size` varchar(50) DEFAULT NULL,
  `year_built` year(4) DEFAULT NULL,
  `video_url` varchar(255) DEFAULT NULL,
  `virtual_tour_url` varchar(255) DEFAULT NULL,
  `is_featured` tinyint(1) DEFAULT 0,
  `attachment_url` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `approval_status` enum('pending','approved','rejected') DEFAULT 'pending',
  `sale_status` enum('available','sold_out') DEFAULT 'available'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `properties`
--

INSERT INTO `properties` (`id`, `user_id`, `title`, `description`, `type`, `status`, `rooms`, `price`, `area`, `address`, `state`, `city`, `neighborhood`, `zip_code`, `latitude`, `longitude`, `area_size`, `size_prefix`, `land_area`, `land_area_postfix`, `bedrooms`, `bathrooms`, `garages`, `garage_size`, `year_built`, `video_url`, `virtual_tour_url`, `is_featured`, `attachment_url`, `created_at`, `approval_status`, `sale_status`) VALUES
(1, 1, 'Happy Family House', 'This is a Property Happy Family House', 'Apartment', 'Rent', 3, 95000.00, '2800', '1421 San Pedro St, Los Angeles, CA 90015', 'Los angelesClick to view los-angeles', 'Mumbai', 'Puna', '789325', '256938', '89654236', '8569', '356', '965', '36542', 2, 3, '', '5968', '2025', 'http://commondatastorage.googleapis.com/gtv-videos-bucket/sample/BigBuckBunny.mp4', 'http://commondatastorage.googleapis.com/gtv-videos-bucket/sample/BigBuckBunny.mp4', 1, 'images/uploads/attachments/1746016846_51572531_2024-11-6 09_26_25.pdf', '2025-04-30 12:40:46', 'approved', 'sold_out'),
(2, 1, 'Beach View Villa', 'Beach View Villa', 'Villa', 'Sale', 4, 69000.00, '95236', '115 Cliff St. , Burlington , VT 05401 , USA', 'India', 'Delhi', 'Punjab', '385620', '987563214', '89654236', '8652', '2589', '4528', '36542', 4, 4, '2', '2987', '2020', 'http://commondatastorage.googleapis.com/gtv-videos-bucket/sample/BigBuckBunny.mp4', 'http://commondatastorage.googleapis.com/gtv-videos-bucket/sample/BigBuckBunny.mp4', 0, 'images/uploads/attachments/1746017672_Sale Brochure.pdf', '2025-04-30 12:54:32', 'pending', 'available'),
(4, 3, 'Sample Property ', 'Sample Property ', 'Warehouse', 'Rent', 2, 42365.00, '2800', '115 Cliff St. , Burlington , VT 05401 , USA', 'India', 'Delhi', 'Punjab', '789325', '987563214', '89654236', '8652', '526', '4528', '36542', 2, 2, '1', '2598', '2020', 'http://commondatastorage.googleapis.com/gtv-videos-bucket/sample/BigBuckBunny.mp4', 'http://commondatastorage.googleapis.com/gtv-videos-bucket/sample/BigBuckBunny.mp4', 1, 'images/uploads/attachments/1746084446_cladmag-issue-2-2018.pdf', '2025-05-01 07:27:26', 'pending', 'available'),
(5, 1, 'Nature Attached Apartment', 'Nature Attached Apartment', 'Farm House', 'Rent', 2, 9654236.00, '9876', '68 Manfield Ave, Stowe, VT 05662', 'India', 'Mumbai', 'Puna', '789325', '256938', '', '8569', '356', '698', '', 0, 0, '0', '', '0000', '', '', 1, '', '2025-05-05 12:45:56', NULL, NULL),
(6, 1, '1263 N Mariposa Ave Building', '', 'Townhouse', 'Rent', 4, 95000.00, '2563', '1263 N Mariposa Ave, Los Angeles, CA 90029, USA', 'India', 'Delhi', 'Punjab', '', '', '', '', '', '', '', 0, 0, '', '', '0000', '', '', 0, 'images/uploads/attachments/1746450240_cladmag-issue-2-2018.pdf', '2025-05-05 12:54:37', 'approved', 'available');

-- --------------------------------------------------------

--
-- Table structure for table `property_amenities`
--

CREATE TABLE `property_amenities` (
  `id` int(11) NOT NULL,
  `property_id` int(11) DEFAULT NULL,
  `amenity_name` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `property_amenities`
--

INSERT INTO `property_amenities` (`id`, `property_id`, `amenity_name`, `created_at`) VALUES
(10, 2, 'Swimming Pool', '2025-04-30 12:54:32'),
(11, 2, 'Gym', '2025-04-30 12:54:32'),
(12, 2, 'Laundry', '2025-04-30 12:54:32'),
(13, 4, 'Lawn', '2025-05-01 07:27:26'),
(14, 4, 'Window Coverings', '2025-05-01 07:27:26'),
(15, 1, 'Barbeque', '2025-05-05 13:02:31'),
(16, 1, 'Dryer', '2025-05-05 13:02:31'),
(17, 1, 'Sauna', '2025-05-05 13:02:31');

-- --------------------------------------------------------

--
-- Table structure for table `property_floorplans`
--

CREATE TABLE `property_floorplans` (
  `id` int(11) NOT NULL,
  `property_id` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `bedrooms` int(11) DEFAULT NULL,
  `bathrooms` int(11) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `price_postfix` varchar(50) DEFAULT NULL,
  `size` varchar(100) DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `property_floorplans`
--

INSERT INTO `property_floorplans` (`id`, `property_id`, `title`, `bedrooms`, `bathrooms`, `price`, `price_postfix`, `size`, `image_path`, `description`, `created_at`) VALUES
(5, 2, 'Not a Floor', 0, 0, 0.00, '0', '0', '', 'Not a floor', '2025-04-30 12:54:32'),
(7, 4, 'Floor First', 1, 1, 25639.00, '65329', '986', 'images/uploads/floorplans/1746084446_featured-post-list-2.jpg', 'Floor First', '2025-05-01 07:27:26'),
(8, 4, 'Floor Second', 1, 1, 25639.00, '65329', '986', 'images/uploads/floorplans/1746084446_top-stories-1.jpg', 'Floor Second', '2025-05-01 07:27:26'),
(9, 5, '', 0, 0, 0.00, '', '', '', '', '2025-05-05 12:45:56'),
(11, 1, 'Floor 1', 1, 0, 25639.00, '65329', '986', '', 'Floor', '2025-05-05 13:02:31'),
(12, 6, '', 0, 0, 0.00, '', '', '', '', '2025-05-05 13:04:00');

-- --------------------------------------------------------

--
-- Table structure for table `property_images`
--

CREATE TABLE `property_images` (
  `id` int(11) NOT NULL,
  `property_id` int(11) DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `property_images`
--

INSERT INTO `property_images` (`id`, `property_id`, `image_path`, `created_at`) VALUES
(18, 1, 'images/uploads/images/1746016846_re-6.jpg', '2025-04-30 12:40:46'),
(19, 1, 'images/uploads/images/1746016846_re-5.jpg', '2025-04-30 12:40:46'),
(20, 1, 'images/uploads/images/1746016846_re-4.jpg', '2025-04-30 12:40:46'),
(21, 1, 'images/uploads/images/1746016846_re-3.jpg', '2025-04-30 12:40:46'),
(22, 1, 'images/uploads/images/1746016846_re-2.jpg', '2025-04-30 12:40:46'),
(23, 1, 'images/uploads/images/1746016846_re-1.jpg', '2025-04-30 12:40:46'),
(24, 2, 'images/uploads/images/1746017672_featured-post-list-4.jpg', '2025-04-30 12:54:32'),
(25, 2, 'images/uploads/images/1746017672_featured-post-list-1.jpg', '2025-04-30 12:54:32'),
(26, 2, 'images/uploads/images/1746017672_featured-post-list-3.jpg', '2025-04-30 12:54:32'),
(27, 2, 'images/uploads/images/1746017672_featured-post-list-2.jpg', '2025-04-30 12:54:32'),
(28, 2, 'images/uploads/images/1746017672_featured-post-list-5.jpg', '2025-04-30 12:54:32'),
(29, 4, 'images/uploads/images/1746084446_Blog Feature Banner Slider Module.jpg', '2025-05-01 07:27:26'),
(30, 4, 'images/uploads/images/1746084446_Blog-Latest-Post-Module-Thumbnail.jpg', '2025-05-01 07:27:26'),
(31, 4, 'images/uploads/images/1746084446_Case-Study-Module-Thumbnail.jpg', '2025-05-01 07:27:26'),
(32, 4, 'images/uploads/images/1746084446_Countdown-timer-Thumbnail.jpg', '2025-05-01 07:27:26'),
(33, 4, 'images/uploads/images/1746084446_Full-Width-Header-Modules-Featured-1.jpg', '2025-05-01 07:27:26'),
(34, 4, 'images/uploads/images/1746084446_Hero-Slider-Module-Thumbnail.jpg', '2025-05-01 07:27:26'),
(35, 5, 'images/uploads/images/1746449156_Blog Listing 03.jpg', '2025-05-05 12:45:56'),
(36, 5, 'images/uploads/images/1746449156_Blog Listing 02.jpg', '2025-05-05 12:45:56'),
(37, 5, 'images/uploads/images/1746449156_Blog Listing 01.jpg', '2025-05-05 12:45:56'),
(38, 5, 'images/uploads/images/1746449156_Latest news 02.jpg', '2025-05-05 12:45:56'),
(39, 5, 'images/uploads/images/1746449156_latest news 01.jpg', '2025-05-05 12:45:56'),
(40, 6, 'images/uploads/images/1746450240_izegem-105619-400x400.jpg', '2025-05-05 13:04:00'),
(41, 6, 'images/uploads/images/1746450240_ieper-211701-400x400.jpeg', '2025-05-05 13:04:00'),
(42, 6, 'images/uploads/images/1746450240_geluwe-143027-400x400.jpg', '2025-05-05 13:04:00'),
(43, 6, 'images/uploads/images/1746450240_diksmuide-153842-400x400.jpg', '2025-05-05 13:04:00'),
(44, 6, 'images/uploads/images/1746450240_grt-removebg-preview.png', '2025-05-05 13:04:00');

-- --------------------------------------------------------

--
-- Table structure for table `property_type`
--

CREATE TABLE `property_type` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `property_type`
--

INSERT INTO `property_type` (`id`, `name`, `created_at`) VALUES
(1, 'Apartment', '2025-04-29 18:04:42'),
(2, 'Villa', '2025-04-29 18:04:42'),
(3, 'Townhouse', '2025-04-29 18:04:42'),
(4, 'Studio Apartment', '2025-04-29 18:04:42'),
(5, 'Penthouse', '2025-04-29 18:04:42'),
(6, 'Farm House', '2025-04-29 18:04:42'),
(7, 'Plot / Land', '2025-04-29 18:04:42'),
(8, 'Office Space', '2025-04-29 18:04:42'),
(9, 'Retail Shop', '2025-04-29 18:04:42'),
(10, 'Warehouse', '2025-04-29 18:04:42'),
(11, 'Industrial Building', '2025-04-29 18:04:42'),
(12, 'Co-living', '2025-04-29 18:04:42'),
(13, 'Paying Guest', '2025-04-29 18:04:42');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `role` varchar(20) DEFAULT 'agent',
  `password` varchar(255) NOT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `first_name` varchar(100) DEFAULT NULL,
  `last_name` varchar(100) DEFAULT NULL,
  `position` varchar(100) DEFAULT NULL,
  `license` varchar(100) DEFAULT NULL,
  `tax_number` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `fax_number` varchar(20) DEFAULT NULL,
  `mobile` varchar(20) DEFAULT NULL,
  `language` varchar(50) DEFAULT NULL,
  `company_name` varchar(100) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `about_me` text DEFAULT NULL,
  `skype` varchar(100) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `facebook` varchar(255) DEFAULT NULL,
  `twitter` varchar(255) DEFAULT NULL,
  `linkedin` varchar(255) DEFAULT NULL,
  `instagram` varchar(255) DEFAULT NULL,
  `google_plus` varchar(255) DEFAULT NULL,
  `youtube` varchar(255) DEFAULT NULL,
  `pinterest` varchar(255) DEFAULT NULL,
  `vimeo` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `role`, `password`, `photo`, `first_name`, `last_name`, `position`, `license`, `tax_number`, `phone`, `fax_number`, `mobile`, `language`, `company_name`, `address`, `about_me`, `skype`, `website`, `facebook`, `twitter`, `linkedin`, `instagram`, `google_plus`, `youtube`, `pinterest`, `vimeo`, `created_at`) VALUES
(1, 'Homefind', 'homefind@gmail.com', 'admin', '$2y$10$nFTUhXD0N7q.rbSFTfqmHei2jUIS4Nbioo9HVtgn8EgYvRWxDhkLS', 'images/uploads/1745833125_banner.jpg', 'Home', 'Find', 'Real', 'Xyz123456', '986532526', '2546987391', '65938569', '9563285665', 'English', 'HomeFind', 'Test Address', 'About me', 'https://skype.com', 'https://example.com', 'https://facebook.com', 'https://twitter.com', 'https://linkedin.com', 'https://instagram.com', 'https://plus.google.com', 'https://youtube.com', 'https://pinterest.com', 'https://vimeo.com', '2025-04-28 06:20:04'),
(2, 'admin', 'admin@gmail.com', 'agent', '$2y$10$qIvdAzUlCodPu8zMj1Fwpu1/OWjsIwkcQipdUn6GHHg/vxscJ3BBK', NULL, 'Admin', 'Admin', 'Real', '2563hbg', '', '2546987391', '6593', '9874563256', 'English', '', '', '', '', '', 'https://facebook.com', 'https://twitter.com', 'https://linkedin.com', 'https://instagram.com', 'https://plus.google.com', '', 'https://pinterest.com', '', '2025-04-28 09:44:37'),
(3, 'sonam', 'sonam@gmail.com', 'agent', '$2y$10$qIvdAzUlCodPu8zMj1Fwpu1/OWjsIwkcQipdUn6GHHg/vxscJ3BBK', 'images/uploads/1746419374_latest news 01.jpg', 'sonam', 'sonam', 'rent', '2563hbg', '986532', '2546987391', '6593', '9874563256', 'English', 'HomeFind', 'Test Address', '', 'https://skype.com', 'https://example.com', 'https://facebook.com', 'https://twitter.com', 'https://linkedin.com', 'https://instagram.com', 'https://plus.google.com', 'https://youtube.com', 'https://pinterest.com', 'https://vimeo.com', '2025-04-29 06:04:48'),
(5, 'demo', 'demo@gmail.com', 'agent', '$2y$10$qIvdAzUlCodPu8zMj1Fwpu1/OWjsIwkcQipdUn6GHHg...', 'images/uploads/1745907267_body-img-4.jpg', 'demo', 'demo', 'Real', '2563hbg', '986532', '2546987391', '65938569', '9874563256', 'en', '', '1421 San Pedro St, Los Angeles, CA 90015', '', 'https://skype.com', '', 'https://facebook.com', 'https://twitter.com', 'https://linkedin.com', 'https://instagram.com', 'https://plus.google.com', '', '', '', '2025-04-29 06:14:27'),
(6, 'Test', 'test@gmail.com', 'agent', '$2y$10$qIvdAzUlCodPu8zMj1Fwpu1/OWjsIwkcQipdUn6GHHg...', NULL, 'Test', 'Test', 'rent', '2563hbg', '986532', '2546987391', '6593', '9874563256', 'English', 'HomeFind', '115 Cliff St. , Burlington , VT 05401 , USA', '', 'https://skype.com', '', 'https://facebook.com', 'https://twitter.com', 'https://linkedin.com', 'https://instagram.com', '', '', '', '', '2025-04-29 06:27:11'),
(7, 'sample', 'sample@gmail.com', 'agent', '$2y$10$qIvdAzUlCodPu8zMj1Fwpu1/OWjsIwkcQipdUn6GHHg...', 'images/uploads/1746419524_Background.png', 'sample', 'sample', 'Real', '2563hbg', '986532', '2546987391', '65938569', '9874563256', 'fr', 'HomeFind', '115 Cliff St. , Burlington , VT 05401 , USA', '', '', '', 'https://facebook.com', 'https://twitter.com', 'https://linkedin.com', 'https://instagram.com', 'https://plus.google.com', '', '', '', '2025-04-29 06:28:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cities`
--
ALTER TABLE `cities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `properties`
--
ALTER TABLE `properties`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user` (`user_id`);

--
-- Indexes for table `property_amenities`
--
ALTER TABLE `property_amenities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `property_id` (`property_id`);

--
-- Indexes for table `property_floorplans`
--
ALTER TABLE `property_floorplans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `property_id` (`property_id`);

--
-- Indexes for table `property_images`
--
ALTER TABLE `property_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `property_id` (`property_id`);

--
-- Indexes for table `property_type`
--
ALTER TABLE `property_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cities`
--
ALTER TABLE `cities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `properties`
--
ALTER TABLE `properties`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `property_amenities`
--
ALTER TABLE `property_amenities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `property_floorplans`
--
ALTER TABLE `property_floorplans`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `property_images`
--
ALTER TABLE `property_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `property_type`
--
ALTER TABLE `property_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `properties`
--
ALTER TABLE `properties`
  ADD CONSTRAINT `fk_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `property_amenities`
--
ALTER TABLE `property_amenities`
  ADD CONSTRAINT `property_amenities_ibfk_1` FOREIGN KEY (`property_id`) REFERENCES `properties` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `property_floorplans`
--
ALTER TABLE `property_floorplans`
  ADD CONSTRAINT `property_floorplans_ibfk_1` FOREIGN KEY (`property_id`) REFERENCES `properties` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `property_images`
--
ALTER TABLE `property_images`
  ADD CONSTRAINT `property_images_ibfk_1` FOREIGN KEY (`property_id`) REFERENCES `properties` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
