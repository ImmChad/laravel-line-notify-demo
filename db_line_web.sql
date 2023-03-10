-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th3 10, 2023 lúc 08:08 PM
-- Phiên bản máy phục vụ: 10.4.22-MariaDB
-- Phiên bản PHP: 8.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `db_line_web`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2023_03_10_185919_create_jobs_table', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tb_announce`
--

CREATE TABLE `tb_announce` (
  `id` int(11) NOT NULL,
  `announce_title` varchar(255) DEFAULT NULL,
  `announce_content` text DEFAULT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `tb_announce`
--

INSERT INTO `tb_announce` (`id`, `announce_title`, `announce_content`, `created_at`) VALUES
(2, 'Announce 1', 'We are pleased to announce that from today, our website will undergo periodic maintenance. This is for the purpose of improving service quality and improving customer experience when using the website.', '2023-03-10 04:22:50'),
(3, 'Announce 2', 'During the maintenance period, the website may be interrupted or inaccessible. We apologize for this inconvenience and look forward to receiving your understanding and support.', '2023-03-10 04:24:03'),
(4, 'Introduct Tung Truong', 'Tung Truong is a young man full of energy and charm. With a handsome face and muscular body, Tung Truong always attracts all eyes when appearing. However, behind that perfect appearance is a soul full of love and full of intelligence.', '2023-03-10 21:38:47'),
(7, 'Introduct Tung Truong 2', 'With talent and relentless efforts, Tung Truong has achieved many amazing achievements in life. He is a business enthusiast and has founded several successful companies in his field. However, Tung Truong is also very interested in helping others, and regularly participates in charitable activities.', '2023-03-10 21:51:36'),
(8, 'Introduct Tung Truong', 'With talent and relentless efforts, Tung Truong has achieved many amazing achievements in life. He is a business enthusiast and has founded several successful companies in his field. However, Tung Truong is also very interested in helping others, and regularly participates in charity activities.', '2023-03-11 02:03:06');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tb_announce_read`
--

CREATE TABLE `tb_announce_read` (
  `id` int(11) NOT NULL,
  `notification_id` int(11) DEFAULT NULL,
  `userId` varchar(255) DEFAULT NULL,
  `read_at` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `tb_announce_read`
--

INSERT INTO `tb_announce_read` (`id`, `notification_id`, `userId`, `read_at`) VALUES
(2, 2, 'U516989e3d6d5cb9d47033b629c304fc2', '2023/03/10 21:13:06'),
(3, 3, 'U516989e3d6d5cb9d47033b629c304fc2', '2023/03/10 21:13:22');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tb_connect_line`
--

CREATE TABLE `tb_connect_line` (
  `id` int(11) NOT NULL,
  `userId` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `tb_connect_line`
--

INSERT INTO `tb_connect_line` (`id`, `userId`, `status`, `date`) VALUES
(1, 'U516989e3d6d5cb9d47033b629c304fc2', 'connect to line', '2023-03-09 11:24:29'),
(2, 'U229fdb4faaabefb4c8e1fa50c84a5754', 'connect to line', '2023-03-09 11:24:31'),
(5, '105509632734195098029', 'connect to gmail', '2023-03-10 03:02:27');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tb_user_info`
--

CREATE TABLE `tb_user_info` (
  `id` int(11) NOT NULL,
  `userId` varchar(255) NOT NULL,
  `displayName` varchar(255) DEFAULT NULL,
  `pictureUrl` text DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `tb_user_info`
--

INSERT INTO `tb_user_info` (`id`, `userId`, `displayName`, `pictureUrl`, `email`) VALUES
(1, 'U516989e3d6d5cb9d47033b629c304fc2', 'Truong Thanh Tung', 'https://profile.line-scdn.net/0hycsFixWFJkxePzQjgP9YMy5vJSZ9Tn9edlw7fzxtcH5mWzYSIglqfW5qKyg0WzITIgltKmhrcX5SLFEqQGnaeFkPeHtkDmcad11pqg', 'a9tttungdz@gmail.com'),
(2, 'U229fdb4faaabefb4c8e1fa50c84a5754', 'Luong Minh Dung', 'https://profile.line-scdn.net/0hVf_9LUAqCUlyQBsm2gd3NgIQCiNRMVBbCyASeEQUX31IcRlPWyZCJxUXB3AfI0YaVnVOfRNJU39-U34vbBb1fXVwV35IcUgfWyJGrw', 'ilovethubumbi@gmail.com'),
(4, '105509632734195098029', 'TRƯƠNG THANH TÙNG', 'https://lh3.googleusercontent.com/a/AGNmyxamS7phSFCl2m3Bu2STsF4Auto4q3iu9AS75N5L=s96-c', 'tungtt2.21it@vku.udn.vn');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Chỉ mục cho bảng `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Chỉ mục cho bảng `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Chỉ mục cho bảng `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Chỉ mục cho bảng `tb_announce`
--
ALTER TABLE `tb_announce`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `tb_announce_read`
--
ALTER TABLE `tb_announce_read`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `tb_connect_line`
--
ALTER TABLE `tb_connect_line`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `tb_user_info`
--
ALTER TABLE `tb_user_info`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `tb_announce`
--
ALTER TABLE `tb_announce`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT cho bảng `tb_announce_read`
--
ALTER TABLE `tb_announce_read`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `tb_connect_line`
--
ALTER TABLE `tb_connect_line`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `tb_user_info`
--
ALTER TABLE `tb_user_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
