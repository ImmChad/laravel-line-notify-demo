-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1:3307
-- Thời gian đã tạo: Th3 15, 2023 lúc 07:26 PM
-- Phiên bản máy phục vụ: 10.4.27-MariaDB
-- Phiên bản PHP: 8.2.0

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
-- Cấu trúc bảng cho bảng `admin`
--

CREATE TABLE `admin` (
  `id` char(36) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`) VALUES
('7603652c-5d94-45ea-ae4a-de2e6f3dea3a', 'TungAdmin', 'soaika1810'),
('b94c419c-00d9-4aed-a53c-64c99008eb41', 'DungAdmin', 'Dung060103');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `failed_jobs`
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
-- Cấu trúc bảng cho bảng `jobs`
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
-- Cấu trúc bảng cho bảng `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
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
-- Cấu trúc bảng cho bảng `notification`
--

CREATE TABLE `notification` (
  `id` int(11) NOT NULL,
  `type` int(11) DEFAULT NULL,
  `announce_title` varchar(255) DEFAULT NULL,
  `announce_content` text DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `is_sent` bit(1) DEFAULT NULL,
  `is_scheduled` bit(1) DEFAULT NULL,
  `scheduled_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `notification`
--

INSERT INTO `notification` (`id`, `type`, `announce_title`, `announce_content`, `created_at`, `is_sent`, `is_scheduled`, `scheduled_at`) VALUES
(58, 1, 'Notification', 'Hello TRƯƠNG THANH TÙNG, click on this link to see notifications about new users.', '2023-03-14 08:28:29', b'1', b'0', NULL),
(59, 2, 'hi', 'hhaahaha', '2023-03-14 09:12:56', b'1', b'1', NULL),
(60, 3, 'cay', '<p><strong>ahhaha</strong></p>', '2023-03-14 09:13:16', b'1', b'0', NULL),
(61, 3, 'Hí lô test', '<p>Tuyệt vời&nbsp;</p>\r\n\r\n<p>Sau 4 p&nbsp;<select name=\"Test\" size=\"4\"><option value=\"TUNG\">TUNG</option><option value=\"DUNG\">DUNG</option><option value=\"NHAT\">NHAT</option><option value=\"VIEN\">VIEN</option></select>&nbsp;sẽ được nhận tin nhắn</p>', '2023-03-14 20:40:17', b'1', b'1', NULL),
(62, 2, 'hiihi', 'Test trước 4 p', '2023-03-14 20:40:44', b'1', b'0', NULL),
(63, 3, 'Cay', '<p><select name=\"hả \"><option value=\"tt\">tt</option><option value=\"dd\">dd</option><option value=\"nn\">nn</option><option value=\"vv\">vv</option></select></p>', '2023-03-14 20:48:09', b'1', b'0', NULL),
(64, 3, 'hahah', '<p><select name=\"hhhhhh\"><option value=\"tt\">tt</option><option value=\"dd\">dd</option></select></p>', '2023-03-14 20:49:42', b'1', b'0', NULL),
(65, 2, 'thuvi', 'gheeee', '2023-03-14 20:50:35', b'1', b'0', NULL),
(66, 3, 'hii Every one', '<h3><img alt=\"\" src=\" https://media.istockphoto.com/id/1415844380/photo/water-leaf-splash-wave-isolated-on-the-white-background.jpg?b=1&amp;s=170667a&amp;w=0&amp;k=20&amp;c=8zQWSsssMT-xrkj8MNcUPGLs1suOlMXi8YgyZorUpjg=\" style=\"float:left; height:100px; margin-right:10px; width:100px\" /></h3>\r\n\r\n<div id=\"dataArea\">Xin ch&agrave;o [TP Đ&agrave; Nẵng], cảm ơn.</div>\r\n\r\n<div id=\"dataIndustry\">Ng&agrave;nh [Điện tử] của ch&uacute;ng t&ocirc;i rất cảm ơn bạn.</div>', '2023-03-15 00:58:28', b'1', b'0', NULL),
(67, 3, 'hihi', '<p>?????</p>', '2023-03-15 23:26:10', b'1', b'0', NULL),
(68, 3, 'ggg', '<p>ggg</p>', '2023-03-15 23:28:02', b'1', b'0', NULL),
(69, 3, 'gg3', '<p>gg3</p>', '2023-03-15 23:28:23', b'1', b'0', NULL),
(70, 3, 'gg4', '<p>gg4</p>', '2023-03-15 23:30:19', b'1', b'0', NULL),
(71, 3, '[Tây Nguyên] notify plan', '<p>cayy5</p>', '2023-03-15 23:39:30', b'1', b'0', NULL),
(72, 3, '[Tây Nguyên] notify plan', '<div class=\"container\"><img alt=\"Logo\" class=\"logo\" src=\"https://thumbs.dreamstime.com/b/3d-small-people-send-mail-27768007.jpg\" style=\"width:400px\" />\r\n<h1>Thank you [TP Đ&agrave; Nẵng] for subscribing!</h1>\r\n\r\n<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed feugiat sapien vel nisl feugiat euismod. Nam sit amet augue vitae orci bibendum consequat. Aenean lobortis felis vel nunc mollis, ac congue enim consectetur.</p>\r\n\r\n<div id=\"dataIndustry\">[Bất động sản]</div>\r\n\r\n<div id=\"dataStore\">[Dũng B&ocirc; Độ]</div>\r\n\r\n<table>\r\n	<tbody>\r\n		<tr>\r\n			<th>Item</th>\r\n			<th>Price</th>\r\n		</tr>\r\n		<tr>\r\n			<td>Item 1</td>\r\n			<td>$10.00</td>\r\n		</tr>\r\n		<tr>\r\n			<td>Item 2</td>\r\n			<td>$20.00</td>\r\n		</tr>\r\n		<tr>\r\n			<td>Item 3</td>\r\n			<td>$30.00</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n</div>', '2023-03-15 23:55:46', b'1', b'1', NULL),
(73, 2, '[Tây Nguyên] notify plan', 'ALO', '2023-03-15 23:56:16', b'1', b'0', NULL),
(74, 3, 'Welcome to [Miền trung duyên hải]', '<p>&nbsp;</p>\r\n\r\n<div style=\"background-color:#f4f5fb\"><!--[if mso | IE]>\r\n          </td>\r\n        </tr>\r\n      </table>\r\n      \r\n      <table\r\n         align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" class=\"\" style=\"width:600px;\" width=\"600\"\r\n      >\r\n        <tr>\r\n          <td style=\"line-height:0px;font-size:0px;mso-line-height-rule:exactly;\">\r\n      \r\n        <v:rect  style=\"width:600px;\" xmlns:v=\"urn:schemas-microsoft-com:vml\" fill=\"true\" stroke=\"false\">\r\n        <v:fill  origin=\"0.5, 0\" position=\"0.5, 0\" src=\"https://images.unsplash.com/photo-1494253109108-2e30c049369b?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=600&q=80\" type=\"tile\" />\r\n        <v:textbox style=\"mso-fit-shape-to-text:true\" inset=\"0,0,0,0\">\r\n      <![endif]-->\r\n<div style=\"background:url(https://images.unsplash.com/photo-1494253109108-2e30c049369b?ixlib=rb-1.2.1&amp;ixid=eyJhcHBfaWQiOjEyMDd9&amp;auto=format&amp;fit=crop&amp;w=600&amp;q=80) top center / auto no-repeat; border-radius:20px; margin-bottom:0px; margin-left:0px; margin-right:0px; margin-top:0px; max-width:600px\">\r\n<div style=\"font-size:0; line-height:0\">\r\n<table align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"background:url(https://images.unsplash.com/photo-1494253109108-2e30c049369b?ixlib=rb-1.2.1&amp;ixid=eyJhcHBfaWQiOjEyMDd9&amp;auto=format&amp;fit=crop&amp;w=600&amp;q=80) top center / auto no-repeat; border-radius:20px; width:100%\">\r\n	<tbody>\r\n		<tr>\r\n			<td style=\"text-align:center\"><!--[if mso | IE]>\r\n                  <table role=\"presentation\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">\r\n                \r\n        <tr>\r\n      \r\n            <td\r\n               class=\"\" style=\"vertical-align:top;width:600px;\"\r\n            >\r\n          <![endif]-->\r\n			<div class=\"mj-column-per-100 mj-outlook-group-fix\" style=\"direction:ltr; display:inline-block; font-size:0px; text-align:left; vertical-align:top; width:100%\">\r\n			<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"vertical-align:top; width:100%\">\r\n				<tbody>\r\n					<tr>\r\n						<td>&nbsp;</td>\r\n					</tr>\r\n					<tr>\r\n						<td><!--[if mso | IE]>\r\n    \r\n        <table role=\"presentation\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\"><tr><td height=\"250\" style=\"vertical-align:top;height:250px;\">\r\n      \r\n    <![endif]-->\r\n						<div style=\"height:250px\">&nbsp;</div>\r\n						<!--[if mso | IE]>\r\n    \r\n        </td></tr></table>\r\n      \r\n    <![endif]--></td>\r\n					</tr>\r\n				</tbody>\r\n			</table>\r\n			</div>\r\n			<!--[if mso | IE]>\r\n            </td>\r\n          \r\n        </tr>\r\n      \r\n                  </table>\r\n                <![endif]--></td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n</div>\r\n</div>\r\n<!--[if mso | IE]>\r\n        </v:textbox>\r\n      </v:rect>\r\n    \r\n          </td>\r\n        </tr>\r\n      </table>\r\n      \r\n      <table\r\n         align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" class=\"\" style=\"width:600px;\" width=\"600\"\r\n      >\r\n        <tr>\r\n          <td style=\"line-height:0px;font-size:0px;mso-line-height-rule:exactly;\">\r\n      <![endif]-->\r\n\r\n<div style=\"background-color:#f4f5fb; background:#f4f5fb; margin-bottom:0px; margin-left:0px; margin-right:0px; margin-top:0px; max-width:600px\">\r\n<table align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"background-color:#f4f5fb; background:#f4f5fb; width:100%\">\r\n	<tbody>\r\n		<tr>\r\n			<td style=\"text-align:center\"><!--[if mso | IE]>\r\n                  <table role=\"presentation\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">\r\n                \r\n        <tr>\r\n      \r\n            <td\r\n               class=\"\" style=\"vertical-align:top;width:570px;\"\r\n            >\r\n          <![endif]-->\r\n			<div class=\"mj-column-per-100 mj-outlook-group-fix\" style=\"direction:ltr; display:inline-block; font-size:0px; text-align:left; vertical-align:top; width:100%\">\r\n			<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"vertical-align:top; width:100%\">\r\n			</table>\r\n			</div>\r\n			<!--[if mso | IE]>\r\n            </td>\r\n          \r\n        </tr>\r\n      \r\n                  </table>\r\n                <![endif]--></td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n</div>\r\n<!--[if mso | IE]>\r\n          </td>\r\n        </tr>\r\n      </table>\r\n      \r\n      <table\r\n         align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" class=\"\" style=\"width:600px;\" width=\"600\"\r\n      >\r\n        <tr>\r\n          <td style=\"line-height:0px;font-size:0px;mso-line-height-rule:exactly;\">\r\n      <![endif]-->\r\n\r\n<div style=\"background-color:#ffffff; background:#ffffff; border-radius:20px; margin-bottom:0px; margin-left:0px; margin-right:0px; margin-top:0px; max-width:600px\">\r\n<table align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"background-color:#ffffff; background:#ffffff; border-radius:20px; width:100%\">\r\n	<tbody>\r\n		<tr>\r\n			<td style=\"text-align:center\"><!--[if mso | IE]>\r\n                  <table role=\"presentation\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">\r\n                \r\n        <tr>\r\n      \r\n            <td\r\n               class=\"\" style=\"vertical-align:top;width:600px;\"\r\n            >\r\n          <![endif]-->\r\n			<div class=\"mj-column-per-100 mj-outlook-group-fix\" style=\"direction:ltr; display:inline-block; font-size:0px; text-align:left; vertical-align:top; width:100%\">\r\n			<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"vertical-align:top; width:100%\">\r\n				<tbody>\r\n					<tr>\r\n						<td>\r\n						<div style=\"color:#8189a9; font-family:Montserrat,Helvetica,Arial,sans-serif; font-size:20px; font-weight:500; line-height:30px; text-align:left\">Welcome to [TP Đ&agrave; Nẵng]</div>\r\n						</td>\r\n					</tr>\r\n					<tr>\r\n						<td>\r\n						<div style=\"color:#8189a9; font-family:Montserrat,Helvetica,Arial,sans-serif; font-size:16px; font-weight:400; line-height:20px; text-align:left\">Please click the button below to <a href=\"#\" style=\"color: #0078be; text-decoration: none; font-weight: 500;\">complete your registration</a>. Once you have completed the process, you can start using our service.</div>\r\n						</td>\r\n					</tr>\r\n					<tr>\r\n						<td>\r\n						<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse:separate; line-height:100%\">\r\n							<tbody>\r\n								<tr>\r\n									<td style=\"background-color:#0078be; text-align:center\"><a href=\"https://google.com\" style=\"display: inline-block; background: #0078be; color: #ffffff; font-family: Montserrat, Helvetica, Arial, sans-serif; font-size: 15px; font-weight: 500; line-height: 24px; margin: 0; text-decoration: none; text-transform: none; padding: 10px 25px; mso-padding-alt: 0px; border-radius: 3px;\" target=\"_blank\">Complete your registration </a></td>\r\n								</tr>\r\n							</tbody>\r\n						</table>\r\n						</td>\r\n					</tr>\r\n					<tr>\r\n						<td>\r\n						<div style=\"color:#8189a9; font-family:Montserrat,Helvetica,Arial,sans-serif; font-size:16px; font-weight:400; line-height:20px; text-align:left\">&nbsp;</div>\r\n						</td>\r\n					</tr>\r\n				</tbody>\r\n			</table>\r\n			</div>\r\n			<!--[if mso | IE]>\r\n            </td>\r\n          \r\n        </tr>\r\n      \r\n                  </table>\r\n                <![endif]--></td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n</div>\r\n<!--[if mso | IE]>\r\n          </td>\r\n        </tr>\r\n      </table>\r\n      \r\n      <table\r\n         align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" class=\"\" style=\"width:600px;\" width=\"600\"\r\n      >\r\n        <tr>\r\n          <td style=\"line-height:0px;font-size:0px;mso-line-height-rule:exactly;\">\r\n      <![endif]-->\r\n\r\n<div style=\"background-color:#f4f5fb; background:#f4f5fb; margin-bottom:0px; margin-left:0px; margin-right:0px; margin-top:0px; max-width:600px\">\r\n<table align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"background-color:#f4f5fb; background:#f4f5fb; width:100%\">\r\n	<tbody>\r\n		<tr>\r\n			<td style=\"text-align:center\"><!--[if mso | IE]>\r\n                  <table role=\"presentation\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">\r\n                \r\n        <tr>\r\n      \r\n            <td\r\n               class=\"\" style=\"vertical-align:top;width:570px;\"\r\n            >\r\n          <![endif]-->\r\n			<div class=\"mj-column-per-100 mj-outlook-group-fix\" style=\"direction:ltr; display:inline-block; font-size:0px; text-align:left; vertical-align:top; width:100%\">\r\n			<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"vertical-align:top; width:100%\">\r\n			</table>\r\n			</div>\r\n			<!--[if mso | IE]>\r\n            </td>\r\n          \r\n        </tr>\r\n      \r\n                  </table>\r\n                <![endif]--></td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n</div>\r\n<!--[if mso | IE]>\r\n          </td>\r\n        </tr>\r\n      </table>\r\n      \r\n      <table\r\n         align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" class=\"\" style=\"width:600px;\" width=\"600\"\r\n      >\r\n        <tr>\r\n          <td style=\"line-height:0px;font-size:0px;mso-line-height-rule:exactly;\">\r\n      <![endif]-->\r\n\r\n<div style=\"background-color:#edeef6; background:#edeef6; border-radius:20px; margin-bottom:0px; margin-left:0px; margin-right:0px; margin-top:0px; max-width:600px\">\r\n<table align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"background-color:#edeef6; background:#edeef6; border-radius:20px; width:100%\">\r\n	<tbody>\r\n		<tr>\r\n			<td style=\"text-align:center\"><!--[if mso | IE]>\r\n                  <table role=\"presentation\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">\r\n                \r\n        <tr>\r\n      \r\n            <td\r\n               class=\"\" style=\"vertical-align:top;width:600px;\"\r\n            >\r\n          <![endif]-->\r\n			<div class=\"mj-column-per-100 mj-outlook-group-fix\" style=\"direction:ltr; display:inline-block; font-size:0px; text-align:left; vertical-align:top; width:100%\">\r\n			<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"vertical-align:top; width:100%\">\r\n				<tbody>\r\n					<tr>\r\n						<td><!--[if mso | IE]>\r\n      <table\r\n         align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" role=\"presentation\"\r\n      >\r\n        <tr>\r\n      \r\n              <td>\r\n            <![endif]-->\r\n						<table align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"display:inline-table; float:none\">\r\n							<tbody>\r\n								<tr>\r\n									<td>&nbsp;</td>\r\n								</tr>\r\n							</tbody>\r\n						</table>\r\n						<!--[if mso | IE]>\r\n              </td>\r\n            \r\n          </tr>\r\n        </table>\r\n      <![endif]--></td>\r\n					</tr>\r\n				</tbody>\r\n			</table>\r\n			</div>\r\n			<!--[if mso | IE]>\r\n            </td>\r\n          \r\n        </tr>\r\n      \r\n                  </table>\r\n                <![endif]--></td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n</div>\r\n<!--[if mso | IE]>\r\n          </td>\r\n        </tr>\r\n      </table>\r\n      \r\n      <table\r\n         align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" class=\"\" style=\"width:600px;\" width=\"600\"\r\n      >\r\n        <tr>\r\n          <td style=\"line-height:0px;font-size:0px;mso-line-height-rule:exactly;\">\r\n      <![endif]-->\r\n\r\n<div style=\"margin-bottom:0px; margin-left:0px; margin-right:0px; margin-top:0px; max-width:600px\">\r\n<table align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"width:100%\">\r\n	<tbody>\r\n		<tr>\r\n			<td style=\"text-align:center\"><!--[if mso | IE]>\r\n                  <table role=\"presentation\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">\r\n                \r\n        <tr>\r\n      \r\n            <td\r\n               class=\"\" style=\"vertical-align:top;width:600px;\"\r\n            >\r\n          <![endif]-->\r\n			<div class=\"mj-column-per-100 mj-outlook-group-fix\" style=\"direction:ltr; display:inline-block; font-size:0px; text-align:left; vertical-align:top; width:100%\">\r\n			<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"vertical-align:top; width:100%\">\r\n				<tbody>\r\n					<tr>\r\n						<td><!--[if mso | IE]>\r\n    \r\n        <table role=\"presentation\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\"><tr><td height=\"1\" style=\"vertical-align:top;height:1px;\">\r\n      \r\n    <![endif]-->\r\n						<div style=\"height:1px\">&nbsp;</div>\r\n						<!--[if mso | IE]>\r\n    \r\n        </td></tr></table>\r\n      \r\n    <![endif]--></td>\r\n					</tr>\r\n				</tbody>\r\n			</table>\r\n			</div>\r\n			<!--[if mso | IE]>\r\n            </td>\r\n          \r\n        </tr>\r\n      \r\n                  </table>\r\n                <![endif]--></td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n</div>\r\n<!--[if mso | IE]>\r\n          </td>\r\n        </tr>\r\n      </table>\r\n      <![endif]--></div>', '2023-03-16 00:12:32', b'1', b'0', NULL),
(75, 2, '[Tây Nguyên] notify plan', 'ALO', '2023-03-16 00:22:23', b'1', b'0', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `notification_channel`
--

CREATE TABLE `notification_channel` (
  `id` int(11) NOT NULL,
  `channel` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `notification_channel`
--

INSERT INTO `notification_channel` (`id`, `channel`) VALUES
(1, 'Line'),
(2, 'Email'),
(3, 'SMS');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `notification_read`
--

CREATE TABLE `notification_read` (
  `id` int(11) NOT NULL,
  `notification_id` varchar(36) DEFAULT NULL,
  `user_id` varchar(255) DEFAULT NULL,
  `read_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `notification_read`
--

INSERT INTO `notification_read` (`id`, `notification_id`, `user_id`, `read_at`) VALUES
(8, '75', 'd329391c-9053-47d7-9bcc-d50acce14729', '2023-03-15 10:22:37');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `notification_type`
--

CREATE TABLE `notification_type` (
  `id` int(11) NOT NULL,
  `type` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `notification_type`
--

INSERT INTO `notification_type` (`id`, `type`) VALUES
(1, 'New Store Registration'),
(2, 'New Notification From Admin'),
(3, 'Email Magazine');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `notification_user_info`
--

CREATE TABLE `notification_user_info` (
  `phone_number` varchar(12) DEFAULT NULL,
  `id` varchar(36) NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `displayName` varchar(255) DEFAULT NULL,
  `pictureUrl` text DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `notification_user_info`
--

INSERT INTO `notification_user_info` (`phone_number`, `id`, `user_id`, `displayName`, `pictureUrl`, `email`) VALUES
('+84339601517', '093a4965-b638-49c9-8c42-c9fd180ab7fa', '+84339601517', 'LMD', NULL, NULL),
(NULL, '7af35efe-fed0-45d2-95ce-6fbc6c0f3e9e', '105509632734195098029', 'TRƯƠNG THANH TÙNG', 'https://lh3.googleusercontent.com/a/AGNmyxamS7phSFCl2m3Bu2STsF4Auto4q3iu9AS75N5L=s96-c', 'tungtt2.21it@vku.udn.vn'),
(NULL, 'b15db3e2-e9a3-457b-9066-ba6abd33a1d6', 'U516989e3d6d5cb9d47033b629c304fc2', 'Truong Thanh Tung', 'https://profile.line-scdn.net/0hycsFixWFJkxePzQjgP9YMy5vJSZ9Tn9edlw7fzxtcH5mWzYSIglqfW5qKyg0WzITIgltKmhrcX5SLFEqQGnaeFkPeHtkDmcad11pqg', 'a9tttungdz@gmail.com'),
(NULL, 'd329391c-9053-47d7-9bcc-d50acce14729', 'U229fdb4faaabefb4c8e1fa50c84a5754', 'Luong Minh Dung', 'https://profile.line-scdn.net/0hVf_9LUAqCUlyQBsm2gd3NgIQCiNRMVBbCyASeEQUX31IcRlPWyZCJxUXB3AfI0YaVnVOfRNJU39-U34vbBb1fXVwV35IcUgfWyJGrw', 'ilovethubumbi@gmail.com');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `notification_user_line`
--

CREATE TABLE `notification_user_line` (
  `id` int(11) NOT NULL,
  `user_id` varchar(36) DEFAULT NULL,
  `user_id_line` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `notification_user_line`
--

INSERT INTO `notification_user_line` (`id`, `user_id`, `user_id_line`) VALUES
(2, 'd329391c-9053-47d7-9bcc-d50acce14729', 'U229fdb4faaabefb4c8e1fa50c84a5754');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `notification_user_settings`
--

CREATE TABLE `notification_user_settings` (
  `id` varchar(36) NOT NULL,
  `user_id` varchar(255) DEFAULT NULL,
  `notification_channel_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `notification_user_settings`
--

INSERT INTO `notification_user_settings` (`id`, `user_id`, `notification_channel_id`, `created_at`, `updated_at`) VALUES
('093a4965-b638-49c9-8c42-c9fd180ab7fa', '+84339601517', 3, '2023-03-15 18:03:30', NULL),
('7af35efe-fed0-45d2-95ce-6fbc6c0f3e9e', '105509632734195098029', 2, '2023-03-14 01:28:26', NULL),
('b15db3e2-e9a3-457b-9066-ba6abd33a1d6', 'U516989e3d6d5cb9d47033b629c304fc2', 1, '2023-03-14 01:27:45', NULL),
('d329391c-9053-47d7-9bcc-d50acce14729', 'U229fdb4faaabefb4c8e1fa50c84a5754', 1, '2023-03-15 17:15:49', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `static_area`
--

CREATE TABLE `static_area` (
  `id` int(11) NOT NULL,
  `area_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `static_area`
--

INSERT INTO `static_area` (`id`, `area_name`) VALUES
(1, 'TP Đà Nẵng'),
(2, 'TP Hà Nội'),
(3, 'Tỉnh Khánh Hòa'),
(4, 'TP Hồ Chí Minh'),
(5, 'Tỉnh Quảng Nam');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `static_industry`
--

CREATE TABLE `static_industry` (
  `id` int(11) NOT NULL,
  `industry_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `static_industry`
--

INSERT INTO `static_industry` (`id`, `industry_name`) VALUES
(1, 'Bất động sản'),
(2, 'Xe'),
(3, 'Điện tử'),
(4, 'Thực phẩm'),
(5, 'Tạp hóa');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `static_region`
--

CREATE TABLE `static_region` (
  `id` int(11) NOT NULL,
  `region_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `static_region`
--

INSERT INTO `static_region` (`id`, `region_name`) VALUES
(1, 'Miền đồng bằng sông Hồng'),
(2, 'Miền núi phía Bắc'),
(3, 'Miền trung duyên hải'),
(4, 'Tây Nguyên'),
(5, 'Đồng bằng sông Cửu Long'),
(6, 'Đông Nam Bộ'),
(7, 'Bắc Trung Bộ'),
(8, 'Nam Trung Bộ');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `static_store`
--

CREATE TABLE `static_store` (
  `id` int(11) NOT NULL,
  `store_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `static_store`
--

INSERT INTO `static_store` (`id`, `store_name`) VALUES
(1, 'Dũng Bô Độ'),
(2, 'Tùng Tatto'),
(3, 'Nhật Sửa Xe'),
(4, 'Viên Bán Hoa');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `template`
--

CREATE TABLE `template` (
  `created_at` timestamp NULL DEFAULT NULL,
  `id` char(36) NOT NULL,
  `template_name` varchar(255) DEFAULT NULL,
  `template_title` varchar(255) DEFAULT NULL,
  `template_content` text DEFAULT NULL,
  `region_id` int(11) DEFAULT NULL,
  `area_id` int(11) DEFAULT NULL,
  `industry_id` int(11) DEFAULT NULL,
  `store_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `template`
--

INSERT INTO `template` (`created_at`, `id`, `template_name`, `template_title`, `template_content`, `region_id`, `area_id`, `industry_id`, `store_id`) VALUES
('2023-03-15 09:09:59', '43f4bb4c-8615-4f80-873d-f6b804ee4d6a', 'New Member', '[Tây Nguyên] notify plan', '<div class=\"container\"><img alt=\"Logo\" class=\"logo\" src=\"https://thumbs.dreamstime.com/b/3d-small-people-send-mail-27768007.jpg\" style=\"width:400px\" />\r\n<h1>Thank you [TP Đ&agrave; Nẵng] for subscribing!</h1>\r\n\r\n<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed feugiat sapien vel nisl feugiat euismod. Nam sit amet augue vitae orci bibendum consequat. Aenean lobortis felis vel nunc mollis, ac congue enim consectetur.</p>\r\n\r\n<div id=\"dataIndustry\">[Bất động sản]</div>\r\n\r\n<div id=\"dataStore\">[Dũng B&ocirc; Độ]</div>\r\n\r\n<table>\r\n	<tbody>\r\n		<tr>\r\n			<th>Item</th>\r\n			<th>Price</th>\r\n		</tr>\r\n		<tr>\r\n			<td>Item 1</td>\r\n			<td>$10.00</td>\r\n		</tr>\r\n		<tr>\r\n			<td>Item 2</td>\r\n			<td>$20.00</td>\r\n		</tr>\r\n		<tr>\r\n			<td>Item 3</td>\r\n			<td>$30.00</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n</div>', 4, 1, 1, 1),
('2023-03-15 10:47:25', '540e6afd-33a5-4106-ba61-5000033e9f9f', 'Welcome Template', 'Welcome to [Miền trung duyên hải]', '<p>&nbsp;</p>\r\n\r\n<div style=\"background-color:#f4f5fb\"><!--[if mso | IE]>\r\n          </td>\r\n        </tr>\r\n      </table>\r\n      \r\n      <table\r\n         align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" class=\"\" style=\"width:600px;\" width=\"600\"\r\n      >\r\n        <tr>\r\n          <td style=\"line-height:0px;font-size:0px;mso-line-height-rule:exactly;\">\r\n      \r\n        <v:rect  style=\"width:600px;\" xmlns:v=\"urn:schemas-microsoft-com:vml\" fill=\"true\" stroke=\"false\">\r\n        <v:fill  origin=\"0.5, 0\" position=\"0.5, 0\" src=\"https://images.unsplash.com/photo-1494253109108-2e30c049369b?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=600&q=80\" type=\"tile\" />\r\n        <v:textbox style=\"mso-fit-shape-to-text:true\" inset=\"0,0,0,0\">\r\n      <![endif]-->\r\n<div style=\"background:url(https://images.unsplash.com/photo-1494253109108-2e30c049369b?ixlib=rb-1.2.1&amp;ixid=eyJhcHBfaWQiOjEyMDd9&amp;auto=format&amp;fit=crop&amp;w=600&amp;q=80) top center / auto no-repeat; border-radius:20px; margin-bottom:0px; margin-left:0px; margin-right:0px; margin-top:0px; max-width:600px\">\r\n<div style=\"font-size:0; line-height:0\">\r\n<table align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"background:url(https://images.unsplash.com/photo-1494253109108-2e30c049369b?ixlib=rb-1.2.1&amp;ixid=eyJhcHBfaWQiOjEyMDd9&amp;auto=format&amp;fit=crop&amp;w=600&amp;q=80) top center / auto no-repeat; border-radius:20px; width:100%\">\r\n	<tbody>\r\n		<tr>\r\n			<td style=\"text-align:center\"><!--[if mso | IE]>\r\n                  <table role=\"presentation\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">\r\n                \r\n        <tr>\r\n      \r\n            <td\r\n               class=\"\" style=\"vertical-align:top;width:600px;\"\r\n            >\r\n          <![endif]-->\r\n			<div class=\"mj-column-per-100 mj-outlook-group-fix\" style=\"direction:ltr; display:inline-block; font-size:0px; text-align:left; vertical-align:top; width:100%\">\r\n			<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"vertical-align:top; width:100%\">\r\n				<tbody>\r\n					<tr>\r\n						<td>&nbsp;</td>\r\n					</tr>\r\n					<tr>\r\n						<td><!--[if mso | IE]>\r\n    \r\n        <table role=\"presentation\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\"><tr><td height=\"250\" style=\"vertical-align:top;height:250px;\">\r\n      \r\n    <![endif]-->\r\n						<div style=\"height:250px\">&nbsp;</div>\r\n						<!--[if mso | IE]>\r\n    \r\n        </td></tr></table>\r\n      \r\n    <![endif]--></td>\r\n					</tr>\r\n				</tbody>\r\n			</table>\r\n			</div>\r\n			<!--[if mso | IE]>\r\n            </td>\r\n          \r\n        </tr>\r\n      \r\n                  </table>\r\n                <![endif]--></td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n</div>\r\n</div>\r\n<!--[if mso | IE]>\r\n        </v:textbox>\r\n      </v:rect>\r\n    \r\n          </td>\r\n        </tr>\r\n      </table>\r\n      \r\n      <table\r\n         align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" class=\"\" style=\"width:600px;\" width=\"600\"\r\n      >\r\n        <tr>\r\n          <td style=\"line-height:0px;font-size:0px;mso-line-height-rule:exactly;\">\r\n      <![endif]-->\r\n\r\n<div style=\"background-color:#f4f5fb; background:#f4f5fb; margin-bottom:0px; margin-left:0px; margin-right:0px; margin-top:0px; max-width:600px\">\r\n<table align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"background-color:#f4f5fb; background:#f4f5fb; width:100%\">\r\n	<tbody>\r\n		<tr>\r\n			<td style=\"text-align:center\"><!--[if mso | IE]>\r\n                  <table role=\"presentation\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">\r\n                \r\n        <tr>\r\n      \r\n            <td\r\n               class=\"\" style=\"vertical-align:top;width:570px;\"\r\n            >\r\n          <![endif]-->\r\n			<div class=\"mj-column-per-100 mj-outlook-group-fix\" style=\"direction:ltr; display:inline-block; font-size:0px; text-align:left; vertical-align:top; width:100%\">\r\n			<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"vertical-align:top; width:100%\">\r\n			</table>\r\n			</div>\r\n			<!--[if mso | IE]>\r\n            </td>\r\n          \r\n        </tr>\r\n      \r\n                  </table>\r\n                <![endif]--></td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n</div>\r\n<!--[if mso | IE]>\r\n          </td>\r\n        </tr>\r\n      </table>\r\n      \r\n      <table\r\n         align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" class=\"\" style=\"width:600px;\" width=\"600\"\r\n      >\r\n        <tr>\r\n          <td style=\"line-height:0px;font-size:0px;mso-line-height-rule:exactly;\">\r\n      <![endif]-->\r\n\r\n<div style=\"background-color:#ffffff; background:#ffffff; border-radius:20px; margin-bottom:0px; margin-left:0px; margin-right:0px; margin-top:0px; max-width:600px\">\r\n<table align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"background-color:#ffffff; background:#ffffff; border-radius:20px; width:100%\">\r\n	<tbody>\r\n		<tr>\r\n			<td style=\"text-align:center\"><!--[if mso | IE]>\r\n                  <table role=\"presentation\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">\r\n                \r\n        <tr>\r\n      \r\n            <td\r\n               class=\"\" style=\"vertical-align:top;width:600px;\"\r\n            >\r\n          <![endif]-->\r\n			<div class=\"mj-column-per-100 mj-outlook-group-fix\" style=\"direction:ltr; display:inline-block; font-size:0px; text-align:left; vertical-align:top; width:100%\">\r\n			<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"vertical-align:top; width:100%\">\r\n				<tbody>\r\n					<tr>\r\n						<td>\r\n						<div style=\"color:#8189a9; font-family:Montserrat,Helvetica,Arial,sans-serif; font-size:20px; font-weight:500; line-height:30px; text-align:left\">Welcome to [TP Đ&agrave; Nẵng]</div>\r\n						</td>\r\n					</tr>\r\n					<tr>\r\n						<td>\r\n						<div style=\"color:#8189a9; font-family:Montserrat,Helvetica,Arial,sans-serif; font-size:16px; font-weight:400; line-height:20px; text-align:left\">Please click the button below to <a href=\"#\" style=\"color: #0078be; text-decoration: none; font-weight: 500;\">complete your registration</a>. Once you have completed the process, you can start using our service.</div>\r\n						</td>\r\n					</tr>\r\n					<tr>\r\n						<td>\r\n						<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse:separate; line-height:100%\">\r\n							<tbody>\r\n								<tr>\r\n									<td style=\"background-color:#0078be; text-align:center\"><a href=\"https://google.com\" style=\"display: inline-block; background: #0078be; color: #ffffff; font-family: Montserrat, Helvetica, Arial, sans-serif; font-size: 15px; font-weight: 500; line-height: 24px; margin: 0; text-decoration: none; text-transform: none; padding: 10px 25px; mso-padding-alt: 0px; border-radius: 3px;\" target=\"_blank\">Complete your registration </a></td>\r\n								</tr>\r\n							</tbody>\r\n						</table>\r\n						</td>\r\n					</tr>\r\n					<tr>\r\n						<td>\r\n						<div style=\"color:#8189a9; font-family:Montserrat,Helvetica,Arial,sans-serif; font-size:16px; font-weight:400; line-height:20px; text-align:left\">&nbsp;</div>\r\n						</td>\r\n					</tr>\r\n				</tbody>\r\n			</table>\r\n			</div>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n</div>\r\n<!--[if mso | IE]>\r\n          </td>\r\n        </tr>\r\n      </table>\r\n      \r\n      <table\r\n         align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" class=\"\" style=\"width:600px;\" width=\"600\"\r\n      >\r\n        <tr>\r\n          <td style=\"line-height:0px;font-size:0px;mso-line-height-rule:exactly;\">\r\n      <![endif]-->\r\n\r\n<div style=\"margin-bottom:0px; margin-left:0px; margin-right:0px; margin-top:0px; max-width:600px\">[Bất động sản]</div>\r\n<!--[if mso | IE]>\r\n          </td>\r\n        </tr>\r\n      </table>\r\n      <![endif]-->\r\n\r\n<div id=\"dataStore\">[T&ugrave;ng Tatto]</div>\r\n\r\n<div id=\"dataArea\">[TP H&agrave; Nội]</div>\r\n\r\n<p>&nbsp;</p>\r\n</div>', 3, 2, 1, 2);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

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
-- Chỉ mục cho bảng `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `notification_channel`
--
ALTER TABLE `notification_channel`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `notification_read`
--
ALTER TABLE `notification_read`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `notification_type`
--
ALTER TABLE `notification_type`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `notification_user_info`
--
ALTER TABLE `notification_user_info`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `notification_user_line`
--
ALTER TABLE `notification_user_line`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `notification_user_settings`
--
ALTER TABLE `notification_user_settings`
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
-- Chỉ mục cho bảng `static_area`
--
ALTER TABLE `static_area`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `static_industry`
--
ALTER TABLE `static_industry`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `static_region`
--
ALTER TABLE `static_region`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `static_store`
--
ALTER TABLE `static_store`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `template`
--
ALTER TABLE `template`
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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=160;

--
-- AUTO_INCREMENT cho bảng `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1277;

--
-- AUTO_INCREMENT cho bảng `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `notification`
--
ALTER TABLE `notification`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT cho bảng `notification_read`
--
ALTER TABLE `notification_read`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT cho bảng `notification_user_line`
--
ALTER TABLE `notification_user_line`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `static_area`
--
ALTER TABLE `static_area`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `static_industry`
--
ALTER TABLE `static_industry`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `static_region`
--
ALTER TABLE `static_region`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT cho bảng `static_store`
--
ALTER TABLE `static_store`
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
