-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 10 Agu 2018 pada 18.25
-- Versi server: 10.1.34-MariaDB
-- Versi PHP: 7.1.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bamms_api`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `account_tbl`
--

CREATE TABLE `account_tbl` (
  `id` int(200) UNSIGNED NOT NULL,
  `user_id` int(200) UNSIGNED NOT NULL,
  `type` int(200) UNSIGNED NOT NULL,
  `account_number` varchar(100) NOT NULL,
  `balance` int(100) NOT NULL,
  `description` varchar(200) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `account_tbl`
--

INSERT INTO `account_tbl` (`id`, `user_id`, `type`, `account_number`, `balance`, `description`, `created_at`, `updated_at`, `deleted_at`) VALUES
(5, 17, 3, '121212', 0, '', '2018-08-09 11:27:33', '2018-08-10 15:17:41', NULL),
(7, 19, 2, '10000019', 13000, '', '2018-08-10 09:56:25', '2018-08-10 11:12:12', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `login_tbl`
--

CREATE TABLE `login_tbl` (
  `id` int(255) UNSIGNED NOT NULL,
  `user_id` int(200) UNSIGNED NOT NULL,
  `user_key` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `login_tbl`
--

INSERT INTO `login_tbl` (`id`, `user_id`, `user_key`, `token`, `created_at`, `updated_at`, `deleted_at`) VALUES
(61, 17, '17.23c5b8d1e5f8741c4cdc32bdc99419fb', '', '2018-08-09 11:28:31', '2018-08-09 11:28:31', NULL),
(67, 17, '17.1b19f63c10bde0f43d39443d693de9e8', '', '2018-08-09 21:20:10', '2018-08-09 21:20:10', NULL),
(68, 17, '17.7c62d41e7cc8c1141ee804cb0b8b0120', '', '2018-08-09 21:21:10', '2018-08-09 21:21:10', NULL),
(69, 17, '17.4e9d6fa485d6de1a96f9cf27dcccecab', '', '2018-08-09 21:25:41', '2018-08-09 21:25:41', NULL),
(70, 17, '17.c935c6ea94ea701e97188d6ddcb3d145', '', '2018-08-09 21:26:16', '2018-08-09 21:26:16', NULL),
(71, 17, '17.52d7cc6415fd516635a37a8dca928e8a', '', '2018-08-09 22:51:13', '2018-08-09 22:51:13', NULL),
(72, 17, '17.36c26cef8447587602a7665922d43a88', '', '2018-08-09 22:52:04', '2018-08-09 22:52:04', NULL),
(73, 17, '17.e75b1b1ce76d115185437239fbb3a1b2', '', '2018-08-09 22:54:42', '2018-08-09 22:54:42', NULL),
(74, 17, '17.6cc5f5c1ed8e76a2e110be42102a359d', '', '2018-08-09 23:06:56', '2018-08-09 23:06:56', NULL),
(75, 17, '17.d218aa8b861b9be0b39c1394b8591579', '', '2018-08-10 02:29:29', '2018-08-10 02:29:29', NULL),
(76, 17, '17.1285e5de06717109f1e023b65a8f2525', '', '2018-08-10 08:01:57', '2018-08-10 08:01:57', NULL),
(77, 17, '17.97ef8420f591b8b50bf1c0f149d343b5', '', '2018-08-10 08:19:03', '2018-08-10 08:19:03', NULL),
(78, 19, '19.b1a66537feebf9906fbf8bf2b4cd9d59', '', '2018-08-10 09:56:33', '2018-08-10 09:56:33', NULL),
(79, 17, '17.b69923ff5e2fe5720424820d53f8c007', '', '2018-08-10 09:57:31', '2018-08-10 09:57:31', NULL),
(80, 19, '19.95a3d410668f3e34fd90426e81b341cf', '', '2018-08-10 10:30:15', '2018-08-10 10:30:15', NULL),
(81, 19, '19.96e64262a754b6a53b41e9f91c65a1c7', '', '2018-08-10 10:56:01', '2018-08-10 10:56:01', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `parameter_tbl`
--

CREATE TABLE `parameter_tbl` (
  `parameter_id` int(200) UNSIGNED NOT NULL,
  `category_id` int(200) UNSIGNED NOT NULL DEFAULT '0',
  `parent_id` int(200) UNSIGNED NOT NULL DEFAULT '0',
  `code` varchar(20) NOT NULL,
  `name` varchar(20) NOT NULL,
  `description` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `parameter_tbl`
--

INSERT INTO `parameter_tbl` (`parameter_id`, `category_id`, `parent_id`, `code`, `name`, `description`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 0, 0, 'ACCOUNT_TYPE', 'Account Type', '', '2018-06-10 17:00:00', '2018-08-09 06:22:49', NULL),
(2, 1, 0, 'MASTERCARD', 'Mastercard', '', '2018-06-10 17:00:00', '2018-08-09 06:27:29', NULL),
(3, 1, 0, 'VISA', 'Visa', '', '2018-06-10 17:00:00', '2018-08-09 06:27:33', NULL),
(4, 0, 0, 'TRANSACTION_TYPE', 'Transaction Type', '', '2018-06-10 17:00:00', '2018-08-09 06:23:58', NULL),
(5, 4, 0, 'CREDIT', 'Credit', NULL, '2018-06-10 17:00:00', '2018-08-09 06:24:08', NULL),
(6, 4, 0, 'DEBIT', 'Debit', NULL, '2018-06-10 17:00:00', '2018-08-09 06:24:25', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `transaction_tbl`
--

CREATE TABLE `transaction_tbl` (
  `id` int(200) NOT NULL,
  `account_id` int(200) UNSIGNED NOT NULL,
  `type` int(200) UNSIGNED NOT NULL,
  `date` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `amount` int(200) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `transaction_tbl`
--

INSERT INTO `transaction_tbl` (`id`, `account_id`, `type`, `date`, `name`, `amount`, `created_at`, `updated_at`, `deleted_at`) VALUES
(18, 7, 5, '2018-08-10T22:33:40', 'gaji', 10000, '2018-08-10 10:33:41', '2018-08-10 10:33:41', NULL),
(19, 7, 6, '2018-08-10T22:34:34', 'Transfer to 121212', 2000, '2018-08-10 10:34:35', '2018-08-10 10:34:35', NULL),
(20, 5, 5, '2018-08-10T22:34:34', 'Received from 121212', 2000, '2018-08-10 10:34:35', '2018-08-10 10:34:35', NULL),
(21, 7, 5, '2018-08-10T23:07:38', 'uang project', 3000, '2018-08-10 11:07:38', '2018-08-10 11:07:38', NULL),
(22, 7, 5, '2018-08-10T23:12:11', 'teas', 2000, '2018-08-10 11:12:11', '2018-08-10 11:12:11', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `transfer_tbl`
--

CREATE TABLE `transfer_tbl` (
  `id` int(200) NOT NULL,
  `from_account` varchar(100) NOT NULL,
  `to_account` varchar(100) NOT NULL,
  `amount` int(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `user_role_tbl`
--

CREATE TABLE `user_role_tbl` (
  `id` int(200) UNSIGNED NOT NULL,
  `code` varchar(10) NOT NULL,
  `name` varchar(50) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `user_role_tbl`
--

INSERT INTO `user_role_tbl` (`id`, `code`, `name`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'MANAGER', 'Bank Manager', NULL, NULL, NULL),
(2, 'CUSTOMER', 'Customer', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `user_tbl`
--

CREATE TABLE `user_tbl` (
  `id` int(200) UNSIGNED NOT NULL,
  `role_id` int(200) UNSIGNED NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `address` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `user_tbl`
--

INSERT INTO `user_tbl` (`id`, `role_id`, `username`, `password`, `name`, `email`, `phone`, `address`, `created_at`, `updated_at`, `deleted_at`) VALUES
(17, 2, 'test', '1234', 'test', 'test@gmail.com', '121212', 'add', '2018-08-09 11:27:33', '2018-08-09 11:27:33', NULL),
(19, 2, 'rezky', '1234', 'rezky', 'rezky@gmail.com', '12123', '1212', '2018-08-10 09:56:24', '2018-08-10 09:56:24', NULL);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `account_tbl`
--
ALTER TABLE `account_tbl`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `type` (`type`);

--
-- Indeks untuk tabel `login_tbl`
--
ALTER TABLE `login_tbl`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `id` (`id`),
  ADD KEY `created_at` (`created_at`),
  ADD KEY `user_key` (`user_key`),
  ADD KEY `sign_id` (`token`);

--
-- Indeks untuk tabel `parameter_tbl`
--
ALTER TABLE `parameter_tbl`
  ADD PRIMARY KEY (`parameter_id`),
  ADD UNIQUE KEY `code` (`code`),
  ADD KEY `catergory_id` (`category_id`),
  ADD KEY `parent_id` (`parent_id`),
  ADD KEY `created_at` (`created_at`);

--
-- Indeks untuk tabel `transaction_tbl`
--
ALTER TABLE `transaction_tbl`
  ADD PRIMARY KEY (`id`),
  ADD KEY `account_id` (`account_id`),
  ADD KEY `type` (`type`);

--
-- Indeks untuk tabel `transfer_tbl`
--
ALTER TABLE `transfer_tbl`
  ADD PRIMARY KEY (`id`),
  ADD KEY `from_account` (`from_account`),
  ADD KEY `to_account` (`to_account`);

--
-- Indeks untuk tabel `user_role_tbl`
--
ALTER TABLE `user_role_tbl`
  ADD PRIMARY KEY (`id`),
  ADD KEY `code` (`code`);

--
-- Indeks untuk tabel `user_tbl`
--
ALTER TABLE `user_tbl`
  ADD PRIMARY KEY (`id`),
  ADD KEY `role_id` (`role_id`),
  ADD KEY `username` (`username`),
  ADD KEY `password` (`password`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `account_tbl`
--
ALTER TABLE `account_tbl`
  MODIFY `id` int(200) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `login_tbl`
--
ALTER TABLE `login_tbl`
  MODIFY `id` int(255) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

--
-- AUTO_INCREMENT untuk tabel `transaction_tbl`
--
ALTER TABLE `transaction_tbl`
  MODIFY `id` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT untuk tabel `transfer_tbl`
--
ALTER TABLE `transfer_tbl`
  MODIFY `id` int(200) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `user_role_tbl`
--
ALTER TABLE `user_role_tbl`
  MODIFY `id` int(200) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `user_tbl`
--
ALTER TABLE `user_tbl`
  MODIFY `id` int(200) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `account_tbl`
--
ALTER TABLE `account_tbl`
  ADD CONSTRAINT `user_account` FOREIGN KEY (`user_id`) REFERENCES `user_tbl` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `login_tbl`
--
ALTER TABLE `login_tbl`
  ADD CONSTRAINT `user_login` FOREIGN KEY (`user_id`) REFERENCES `user_tbl` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `transaction_tbl`
--
ALTER TABLE `transaction_tbl`
  ADD CONSTRAINT `account_transaction` FOREIGN KEY (`account_id`) REFERENCES `account_tbl` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `user_tbl`
--
ALTER TABLE `user_tbl`
  ADD CONSTRAINT `user_userrole` FOREIGN KEY (`role_id`) REFERENCES `user_role_tbl` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
