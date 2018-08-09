-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 07, 2018 at 03:26 AM
-- Server version: 5.6.38
-- PHP Version: 7.2.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `robusta_t1`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_detail_tbl`
--

CREATE TABLE `activity_detail_tbl` (
  `id` int(255) UNSIGNED NOT NULL,
  `activity_id` int(255) UNSIGNED NOT NULL,
  `month` int(2) NOT NULL,
  `day` int(2) NOT NULL,
  `year` int(4) NOT NULL,
  `hour` int(2) NOT NULL,
  `minute` int(2) NOT NULL,
  `timestamp` int(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `activity_detail_tbl`
--

INSERT INTO `activity_detail_tbl` (`id`, `activity_id`, `month`, `day`, `year`, `hour`, `minute`, `timestamp`, `created_at`, `updated_at`, `deleted_at`) VALUES
(7, 2, 5, 30, 18, 14, 13, 1527689624, '2018-05-30 07:13:44', '2018-05-30 17:54:34', NULL),
(8, 2, 5, 29, 18, 0, 0, 1527552000, '2018-05-30 07:13:44', '2018-05-30 16:42:32', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `activity_tbl`
--

CREATE TABLE `activity_tbl` (
  `id` int(255) UNSIGNED NOT NULL,
  `user_id` int(200) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `activity_tbl`
--

INSERT INTO `activity_tbl` (`id`, `user_id`, `name`, `created_at`, `updated_at`, `deleted_at`) VALUES
(2, 2, 'quit smoking now test', '2018-05-30 03:57:13', '2018-05-30 17:36:18', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `login_tbl`
--

CREATE TABLE `login_tbl` (
  `id` int(255) UNSIGNED NOT NULL,
  `user_id` int(200) UNSIGNED NOT NULL,
  `user_key` varchar(255) NOT NULL,
  `sign_id` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `login_tbl`
--

INSERT INTO `login_tbl` (`id`, `user_id`, `user_key`, `sign_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(13, 4, '4.41f04f855278f7da0975139f471fbf5f', 'signid1', '2018-05-30 03:41:30', '2018-05-30 03:41:30', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_role_tbl`
--

CREATE TABLE `user_role_tbl` (
  `id` int(200) UNSIGNED NOT NULL,
  `code` varchar(10) NOT NULL,
  `name` varchar(50) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_role_tbl`
--

INSERT INTO `user_role_tbl` (`id`, `code`, `name`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'ADM', 'Admin', '2018-05-29 17:00:00', '2018-05-29 17:00:00', '0000-00-00 00:00:00'),
(2, 'USR', 'User', '2018-05-29 17:00:00', '2018-05-29 17:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `user_tbl`
--

CREATE TABLE `user_tbl` (
  `id` int(200) UNSIGNED NOT NULL,
  `role_id` int(200) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(50) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_tbl`
--

INSERT INTO `user_tbl` (`id`, `role_id`, `name`, `email`, `token`, `created_at`, `updated_at`, `deleted_at`) VALUES
(2, 1, 'Super Admin', 'superadmin@gmail.com', '', '2018-05-29 17:00:00', '2018-05-29 17:00:00', '2018-05-30 07:44:12'),
(4, 1, 'Super Admin1', 'superadmin1@gmail.com', 'token1', '2018-05-30 02:17:57', '2018-05-30 02:17:57', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_detail_tbl`
--
ALTER TABLE `activity_detail_tbl`
  ADD PRIMARY KEY (`id`),
  ADD KEY `activity_id` (`activity_id`);

--
-- Indexes for table `activity_tbl`
--
ALTER TABLE `activity_tbl`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `id` (`id`),
  ADD KEY `created_at` (`created_at`);

--
-- Indexes for table `login_tbl`
--
ALTER TABLE `login_tbl`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `id` (`id`),
  ADD KEY `created_at` (`created_at`),
  ADD KEY `user_key` (`user_key`),
  ADD KEY `sign_id` (`sign_id`);

--
-- Indexes for table `user_role_tbl`
--
ALTER TABLE `user_role_tbl`
  ADD PRIMARY KEY (`id`),
  ADD KEY `code` (`code`),
  ADD KEY `name` (`name`);

--
-- Indexes for table `user_tbl`
--
ALTER TABLE `user_tbl`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `idx_token` (`token`),
  ADD KEY `id` (`id`),
  ADD KEY `created_at` (`created_at`),
  ADD KEY `user_role_id` (`role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity_detail_tbl`
--
ALTER TABLE `activity_detail_tbl`
  MODIFY `id` int(255) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `activity_tbl`
--
ALTER TABLE `activity_tbl`
  MODIFY `id` int(255) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `login_tbl`
--
ALTER TABLE `login_tbl`
  MODIFY `id` int(255) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `user_role_tbl`
--
ALTER TABLE `user_role_tbl`
  MODIFY `id` int(200) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user_tbl`
--
ALTER TABLE `user_tbl`
  MODIFY `id` int(200) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `activity_detail_tbl`
--
ALTER TABLE `activity_detail_tbl`
  ADD CONSTRAINT `activityid_activity_detail` FOREIGN KEY (`activity_id`) REFERENCES `activity_tbl` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `activity_tbl`
--
ALTER TABLE `activity_tbl`
  ADD CONSTRAINT `userid_useractivity` FOREIGN KEY (`user_id`) REFERENCES `user_tbl` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `login_tbl`
--
ALTER TABLE `login_tbl`
  ADD CONSTRAINT `userid_userlogin` FOREIGN KEY (`user_id`) REFERENCES `user_tbl` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_tbl`
--
ALTER TABLE `user_tbl`
  ADD CONSTRAINT `user_role_id` FOREIGN KEY (`role_id`) REFERENCES `user_role_tbl` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
