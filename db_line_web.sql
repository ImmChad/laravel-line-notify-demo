-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th3 09, 2023 lúc 10:27 PM
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
(2, 'Annouce 1', 'We are pleased to announce that from today, our website will undergo periodic maintenance. This is for the purpose of improving service quality and improving customer experience when using the website.', '2023-03-10 04:22:50'),
(3, 'Announce 2', 'During the maintenance period, the website may be interrupted or inaccessible. We apologize for this inconvenience and look forward to receiving your understanding and support.', '2023-03-10 04:24:03');

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

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `tb_announce`
--
ALTER TABLE `tb_announce`
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
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `tb_announce`
--
ALTER TABLE `tb_announce`
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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
