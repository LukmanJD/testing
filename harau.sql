-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 29, 2025 at 03:25 PM
-- Server version: 8.0.40
-- PHP Version: 8.1.32

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `harau`
--

-- --------------------------------------------------------

--
-- Table structure for table `announcement`
--

CREATE TABLE `announcement` (
  `id` varchar(5) NOT NULL,
  `admin_id` int UNSIGNED DEFAULT NULL,
  `announcement` text,
  `status` tinyint DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `announcement`
--

INSERT INTO `announcement` (`id`, `admin_id`, `announcement`, `status`) VALUES
('L0001', 7, 'Lembah Anai road is currently implementing a one-way system due to road subsidence. Travelers are advised to proceed with caution and follow safety instructions.', 1);

-- --------------------------------------------------------

--
-- Table structure for table `attraction`
--

CREATE TABLE `attraction` (
  `id` varchar(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `attraction_category` varchar(2) NOT NULL DEFAULT '2',
  `name` varchar(40) NOT NULL,
  `address` text NOT NULL,
  `open` time NOT NULL,
  `close` time NOT NULL,
  `price` int NOT NULL DEFAULT '0',
  `employee_name` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `phone` varchar(13) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `description` text NOT NULL,
  `video_url` varchar(30) NOT NULL,
  `lat` decimal(10,8) NOT NULL,
  `lng` decimal(11,8) NOT NULL,
  `geom` geometry DEFAULT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `attraction`
--

INSERT INTO `attraction` (`id`, `attraction_category`, `name`, `address`, `open`, `close`, `price`, `employee_name`, `phone`, `description`, `video_url`, `lat`, `lng`, `geom`, `created_at`, `updated_at`) VALUES
('A14', '2', 'Air Terjun Sarasah Bunta', 'Tarantang village, Harau Subdistrict, Lima Puluh Kota Regency, West Sumatra Province, Indonesia,', '00:00:00', '23:59:00', 0, NULL, NULL, 'Air terjun Sarasah Bunta merupakan air terjun alami yang terbentuk akibat patahan ', 'A4-V.mp4', -0.10859590, 100.67764144, 0xe610000001030000000100000006000000b8cd337a5e2b5940baccfadef0ccbbbf3be9d89c5e2b5940d0dbaf6d17bbbbbf470ac09a5e2b5940a82bc864abaabbbf27c286a7572b5940f4d7af645cabbbbf5a8184d5562b5940b1d018f730c5bbbfb8cd337a5e2b5940baccfadef0ccbbbf, '2023-11-26 09:19:36', '2023-12-22 04:38:25'),
('A15', '2', 'Panorama Aka Barayun', 'Tarantang village, Harau Subdistrict, Lima Puluh Kota Regency, West Sumatra Province, Indonesia,', '00:00:00', '23:59:00', 0, NULL, NULL, 'Panorama Aka Barayun merupakan objek wisata dengan daya tarik air terjun dan tebing lembah harau yang ditumbuhi oleh tumbuhan merambat.', '', -0.10107162, 100.66675139, 0xe61000000103000000010000000600000034a7050eac2a594046287466d4dfb9bf6790cc34ab2a59403bce44438cf8b9bf0e67026eab2a5940e0ca23c9bd0ababf66c71da1ac2a594015634ff16e1bbabf9c9d561bad2a59403c56dfafb8eeb9bf34a7050eac2a594046287466d4dfb9bf, '2023-11-26 09:26:07', '2023-12-22 04:31:35'),
('A16', '2', 'Harau Dream Park', 'Tarantang village, Harau Subdistrict, Lima Puluh Kota Regency, West Sumatra Province, Indonesia,', '09:00:00', '17:00:00', 30000, 'Kampuang Sarosah', '081360813344', 'Harau Dream Park merupakan tempat wisata hits di Sumatera Barat yang dilengkapi dengan replika ikon sejumlah negara di dunia. Objek-objek wisata yang terdapat pada Kampuang Sarosah yaitu Kampung Eropa,  Kampuang Korea, Kampung Jepang dan Kampung Sarosah', '', -0.11329513, 100.66964846, 0xe61000000103000000010000002a00000013e13685db2a5940be6425dee800bdbf4c99e5fcde2a5940a4efc1adb308bdbf5d4cf931e22a5940a594a510a717bdbfa2e9b2b9e62a59401372103a0921bdbfa1fa202eed2a5940b569cfd9c025bdbfafae4cf0f42a59402b61960bcf2abdbf7beea941fd2a5940474cbb5ebb30bdbf72de62f2042b5940b0206a2e7934bdbfb57691f80b2b5940c62a4aae0738bdbf20d79f27122b5940cf294c08eb39bdbf05fcf93a192b5940dd342a2e963bbdbf0a915f81202b5940773340f5513ebdbfce18492f282b594044c0847e6442bdbf5339b37e2f2b59406eb2fcaf2946bdbfe761d310362b59401b6f6568c049bdbfba17f3ce3c2b5940f131f546ef4cbdbffe8c3d41432b59401102d1176b4dbdbf4c112a82492b5940c26e758c6d4abdbf42226de34f2b5940f21850359b43bdbfbc5983f7552b594083f30c8e503bbdbf01ffced55a2b5940cff197370333bdbfd63a71395e2b594024f1f274ae28bdbfc350e2ce602b59403e97461f351ebdbf92674de2622b5940fc7a74d99e0fbdbf67cb5e5b642b59406db30ccc65febcbf6d5a84bd642b594024c44b265de9bcbf974ffb52642b594087a5a22dbed3bcbf927e56f4622b5940de731e1d70c0bcbf8dc756e1602b5940cae6a20846b1bcbffffe39715e2b594002be3676e4a3bcbf6c4bd3565b2b5940b66fa422049abcbf8626e4de572b59408884ade13b94bcbfb7a283e4532b5940ea96fcd33693bcbfcb7b41b04f2b594004a1061dbe96bcbfbc7e1c284b2b5940ecc6b3b21a9ebcbf416fe0c4462b59404c38b2fa3ca9bcbf97f2107c422b5940b42506dc4eb6bcbf2d93e1783e2b5940f19b679192c3bcbfdcba9ba73a2b59400cace3f8a1d2bcbf3d450e11372b5940f08b4b55dae2bcbfecc8ec87332b5940fca65599cef3bcbf13e13685db2a5940be6425dee800bdbf, '2023-11-26 09:27:54', '2023-12-22 04:23:38'),
('A17', '1', 'Geopark Lembah Harau', 'Tarantang village, Harau Subdistrict, Lima Puluh Kota Regency, West Sumatra Province, Indonesia,', '00:00:00', '23:59:00', 0, 'Edo', '081261499095', 'Geopark Lembah Harau dikenal karena beragam formasi batuan yang unik. Situs geologi di kawasan ini memberikan pandangan yang menarik tentang sejarah geologi dan proses alam yang terjadi selama jutaan tahun.<br><br> Kawasan geopark ini ditandai oleh tebing-tebing curam yang mengelilingi lembah, menciptakan pemandangan spektakuler. Keberadaan tebing yang tinggi dan terjal memberikan sentuhan dramatis pada lanskap alam.<br><br> Ketinggian tebing batu pada Geopark Lembah Harau berkisar antara 30m - 100m. Batuan pada tebing merupakan perselingan konglomerat dan batupasir dengan ketinggian ± 100 meter termasuk ke dalam formasi <i>Brani</i> berumur <i>Oligosen (34-23 juta tahun lalu)</i> serta mencirikan endapan fluvial dari sungai purba.<br><br> Terbentuknya lembah harau dikarenakan adanya patahan turun atau block yang turun membentuk lembah yang cukup luas dan datar. Salah satu tanda-tanda atau untuk melihat dimana lokasi patahannya adalah dengan adanya air terjun. Dengan begitu, dapat disimpulkan bahwa dahulu ada sungai yang kemudian terpotong akibat adanya patahan turun, sehingga membentuk air terjun. ', 'geopark_lembah_harau.mp4', -0.10422544, 100.67413855, 0xe61000000103000000010000002f000000434e0416252b5940e01136b884aebabf1bb73de6282b59404f3dd2e0b6b6babfa22f18b72c2b5940e26def6481c0babf8294336f302b5940ceb0074955c9babf8ceb2983342b5940869f49acd6d3babf07fb65e6382b59409a1c88765fdfbabfd54d18833d2b5940ce1ced139beababf26dea6e4412b594090c4268d2cf4babf4d6551d8452b594043fc68ddabfbbabfbd564277492b594075e789e76c01bbbf5ce3d81f4d2b5940c8f610436106bbbfcb619c64502b5940739b15f6590abbbffff5c07d532b5940a02ef76e980dbbbf6f18607a562b5940b598e9a8b40fbbbf79d1b249592b59402c0fd253e410bbbf4e5d9e735c2b59400e68e90ab611bbbf52e3ef285f2b5940dbb5ce09eb10bbbf21e0b5f0612b5940b1fe2a1b310ebbbf02a72d64642b59409e95b4e21b0abbbf905841c2662b5940b06e6182bf04bbbffad74d84682b5940c1e84da0e3febabf59f157126a2b59407d6f78e68af7babfbd5708066b2b5940c061fdfa7cefbabfed65db696b2b59402b306475abe7babf5245f12a6b2b59406e22e9899ddfbabfedde40376a2b5940ed20c033ebd6babfc54ec296682b594084a7469edacfbabf96010c70662b5940f0f1ae1f07cababfa3b899c0632b59406e6b0bcf4bc5babfabe001af602b59408819750877c2babf53bb15785d2b59409e67a2be1bc1babfd2d160095a2b5940d7f6764b72c0babf57bf886c562b59404e0e9f7422c1babfa0c211a4522b594030c676ad73c2babf8aa658da4e2b59402e24bb2decc4babfb0743e3c4b2b594065cf543ebac7babf58c51b99472b59400f15996f33cbbabf4e0f6503442b59404ed76e168acfbabf80153b75402b5940ff756eda8cd3babfff428f183d2b59404214820b68d8babfa1bc8fa3392b5940aded3724ffddbabf61ab5f44362b594018096d3997e2babfb6700ff8322b5940eb47d455cbe7babf2f9974a52f2b5940f7b64f7dd6ebbabf2511d0332c2b59400426cba4e1efbabf80db6edd282b594053fa53f4d1f3babf434e0416252b5940e01136b884aebabf, '2023-12-21 20:40:13', '2023-12-21 20:40:13'),
('A18', '2', 'Air Terjun Sarasah Aie Luluih', 'Tarantang village, Harau Subdistrict, Lima Puluh Kota Regency, West Sumatra Province, Indonesia,', '00:00:00', '23:59:00', 0, NULL, NULL, 'Air terjun Sarasah Bunta merupakan air terjun alami yang terbentuk akibat patahan ', '', -0.10811163, 100.67513731, 0xe6100000010300000001000000050000009ab01e73352b59400fd12a2b34adbbbf4f3a36a7372b59400fd12a2b34adbbbf4f3a36a7372b5940e67d56781bc4bbbf9ab01e73352b5940e67d56781bc4bbbf9ab01e73352b59400fd12a2b34adbbbf, '2023-12-22 04:41:50', '2023-12-22 04:41:50'),
('A19', '2', 'Harau Sky Dream World', 'Tarantang village, Harau Subdistrict, Lima Puluh Kota Regency, West Sumatra Province, Indonesia,', '09:00:00', '17:00:00', 30000, 'Harau Sky', '081212229832', 'Wisata Harau Sky Dream World menyuguhkan wahana waterpark, kemudian spot foto dream land, spot mini world di negeri air Venezia dan Swiss. Selain itu,  juga ada Lounge Sunset Wonderland Harau atau ruang santai untuk melihat keindahan sunset dengan view Lembah Harau.', '', -0.10369996, 100.66563991, 0xe610000001030000000100000011000000311723d8992a5940f5e7cba0148cbabf8743c2399b2a594074939c3cfa99babf2008f3cb9e2a5940e7340bb43ba4babf41182e61a32a5940e6a617c627aebabf9eaffe74a82a5940ea549ee51eb7babf48b6042aad2a59404f519a722abebabf1637c9eab12a59409d83674293c4babf3771cd78b62a5940e797778b76cbbabf2fe708cfba2a59406f34db70b3d3babf872062debe2a594069caa9f81addbabf2668dd50c22a594086a11f5734e7babf065acbaec52a59400a20c6b5ebefbabfd5e0c7e2c82a594084c8337914f8babf38e27fe1cb2a59403e59315c1d00bbbf4fa5b09cce2a5940311a434afd06bbbf2af16f86d12a59409af27c618d0ebbbf311723d8992a5940f5e7cba0148cbabf, '2023-12-22 04:49:58', '2023-12-22 04:49:58');

-- --------------------------------------------------------

--
-- Table structure for table `attraction_category`
--

CREATE TABLE `attraction_category` (
  `id` varchar(2) NOT NULL,
  `name` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `attraction_category`
--

INSERT INTO `attraction_category` (`id`, `name`) VALUES
('1', 'Unique'),
('2', 'Ordinary');

-- --------------------------------------------------------

--
-- Table structure for table `attraction_facility`
--

CREATE TABLE `attraction_facility` (
  `id` varchar(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `name` varchar(25) NOT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `attraction_facility`
--

INSERT INTO `attraction_facility` (`id`, `name`, `created_at`, `updated_at`) VALUES
('01', 'Parking Area', '2025-01-06 03:02:23', '2025-01-06 03:02:23'),
('02', 'Toilet', '2025-01-10 01:14:04', '2025-01-10 01:14:04');

-- --------------------------------------------------------

--
-- Table structure for table `attraction_facility_detail`
--

CREATE TABLE `attraction_facility_detail` (
  `attraction_id` varchar(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `attraction_facility_id` varchar(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `attraction_gallery`
--

CREATE TABLE `attraction_gallery` (
  `id` varchar(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `attraction_id` varchar(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `url` text NOT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `auth_activation_attempts`
--

CREATE TABLE `auth_activation_attempts` (
  `id` int UNSIGNED NOT NULL,
  `ip_address` varchar(255) NOT NULL,
  `user_agent` varchar(255) NOT NULL,
  `token` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `auth_groups`
--

CREATE TABLE `auth_groups` (
  `id` int UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `auth_groups`
--

INSERT INTO `auth_groups` (`id`, `name`, `description`) VALUES
(1, 'user', 'Registered Visitor'),
(2, 'owner', 'Object Owner'),
(3, 'admin', 'Site Administrator');

-- --------------------------------------------------------

--
-- Table structure for table `auth_groups_permissions`
--

CREATE TABLE `auth_groups_permissions` (
  `group_id` int UNSIGNED NOT NULL DEFAULT '0',
  `permission_id` int UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `auth_groups_users`
--

CREATE TABLE `auth_groups_users` (
  `group_id` int UNSIGNED NOT NULL DEFAULT '0',
  `user_id` int UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `auth_groups_users`
--

INSERT INTO `auth_groups_users` (`group_id`, `user_id`) VALUES
(1, 1),
(1, 2),
(1, 3),
(1, 4),
(1, 10),
(1, 11),
(1, 11),
(1, 32),
(1, 48),
(1, 49),
(2, 9),
(2, 13),
(2, 14),
(2, 15),
(2, 16),
(2, 17),
(2, 18),
(2, 19),
(2, 20),
(2, 21),
(2, 22),
(2, 23),
(2, 24),
(2, 25),
(2, 29),
(3, 7),
(3, 7);

-- --------------------------------------------------------

--
-- Table structure for table `auth_logins`
--

CREATE TABLE `auth_logins` (
  `id` int UNSIGNED NOT NULL,
  `ip_address` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `user_id` int UNSIGNED DEFAULT NULL,
  `date` datetime NOT NULL,
  `success` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `auth_logins`
--

INSERT INTO `auth_logins` (`id`, `ip_address`, `email`, `user_id`, `date`, `success`) VALUES
(1, '::1', 'accowner1@email.com', 5, '2023-10-28 23:21:02', 1),
(2, '::1', 'accadmin1@email.com', 7, '2023-10-30 02:11:02', 1),
(3, '::1', 'accadmin1@email.com', 7, '2023-10-30 07:48:29', 1),
(4, '::1', 'accadmin1@email.com', 7, '2023-10-30 22:18:45', 1),
(5, '::1', 'accadmin1@email.com', 7, '2023-10-31 03:09:19', 1),
(6, '::1', 'accadmin1@email.com', 7, '2023-10-31 21:56:40', 1),
(7, '::1', 'accadmin1@email.com', 7, '2023-11-01 09:32:34', 1),
(8, '::1', 'accadmin1@email.com', 7, '2023-11-01 22:07:00', 1),
(9, '::1', 'accadmin1@email.com', 7, '2023-11-02 01:17:50', 1),
(10, '::1', 'accadmin1@email.com', 7, '2023-11-02 07:25:57', 1),
(11, '::1', 'accadmin1@email.com', 7, '2023-11-03 21:38:58', 1),
(12, '::1', 'accadmin1@email.com', 7, '2023-11-06 02:05:10', 1),
(13, '::1', 'accadmin1@email.com', 7, '2023-11-06 07:47:44', 1),
(14, '::1', 'accadmin1@email.com', 7, '2023-11-07 05:38:01', 1),
(15, '::1', 'accadmin1@email.com', 7, '2023-11-07 07:39:13', 1),
(16, '::1', 'accadmin1@email.com', 7, '2023-11-07 19:02:46', 1),
(17, '::1', 'accadmin1@email.com', 7, '2023-11-08 00:27:50', 1),
(18, '::1', 'accadmin1@email.com', 7, '2023-11-08 18:59:27', 1),
(19, '::1', 'accadmin1@email.com', 7, '2023-11-09 03:33:24', 1),
(20, '::1', 'accadmin1@email.com', 7, '2023-11-10 02:30:12', 1),
(21, '::1', 'accadmin1@email.com', 7, '2023-11-10 06:20:49', 1),
(22, '::1', 'accadmin1@email.com', 7, '2023-11-10 21:10:36', 1),
(23, '::1', 'accadmin1@email.com', 7, '2023-11-11 01:52:42', 1),
(24, '::1', 'accadmin1@email.com', 7, '2023-11-11 08:50:47', 1),
(25, '::1', 'accadmin1@email.com', 7, '2023-11-11 21:28:10', 1),
(26, '::1', 'accadmin1@email.com', 7, '2023-11-12 01:26:20', 1),
(27, '::1', 'accadmin1@email.com', 7, '2023-11-12 07:25:43', 1),
(28, '::1', 'accadmin1@email.com', 7, '2023-11-12 23:35:22', 1),
(29, '::1', 'accowner1@email.com', 5, '2023-11-13 00:05:58', 1),
(30, '::1', 'accadmin1@email.com', 7, '2023-11-13 00:11:59', 1),
(31, '::1', 'accadmin1@email.com', 7, '2023-11-14 02:33:23', 1),
(32, '::1', 'accadmin1@email.com', 7, '2023-11-14 07:40:24', 1),
(33, '::1', 'accadmin1@email.com', 7, '2023-11-14 22:00:47', 1),
(34, '::1', 'accadmin1@email.com', 7, '2023-11-15 02:16:40', 1),
(35, '::1', 'accadmin1@email.com', 7, '2023-11-15 21:36:33', 1),
(36, '::1', 'accadmin1@email.com', 7, '2023-11-16 02:10:23', 1),
(37, '::1', 'accowner1@email.com', 5, '2023-11-16 02:11:23', 1),
(38, '::1', 'accadmin1@email.com', 7, '2023-11-16 02:19:44', 1),
(39, '::1', 'accadmin1@email.com', 7, '2023-11-16 06:11:22', 1),
(40, '::1', 'accowner1@email.com', 5, '2023-11-16 07:29:18', 1),
(41, '::1', 'accadmin1@email.com', 7, '2023-11-16 07:37:45', 1),
(42, '::1', 'accowner1@email.com', 5, '2023-11-16 07:47:21', 1),
(43, '::1', 'accadmin1@email.com', 7, '2023-11-16 07:49:02', 1),
(44, '::1', 'accowner1@email.com', 5, '2023-11-16 08:03:44', 1),
(45, '::1', 'accadmin1@email.com', 7, '2023-11-16 08:09:38', 1),
(46, '::1', 'accadmin1@email.com', 7, '2023-11-16 08:48:55', 1),
(47, '::1', 'accadmin1@email.com', 7, '2023-11-16 21:18:52', 1),
(48, '::1', 'accadmin1@email.com', 7, '2023-11-17 02:05:09', 1),
(49, '::1', 'accadmin1@email.com', 7, '2023-11-19 18:42:49', 1),
(50, '::1', 'accadmin1@email.com', 7, '2023-11-20 06:09:42', 1),
(51, '::1', 'accadmin1@email.com', 7, '2023-11-26 02:31:49', 1),
(52, '::1', 'accadmin1', NULL, '2023-11-26 23:17:37', 0),
(53, '::1', 'accadmin1@email.com', 7, '2023-11-26 23:17:57', 1),
(54, '::1', 'accadmin1@email.com', 7, '2023-11-28 21:41:18', 1),
(55, '::1', 'accowner1@email.com', 5, '2023-11-28 21:47:07', 1),
(56, '::1', 'accadmin1@email.com', 7, '2023-12-01 01:56:48', 1),
(57, '::1', 'accadmin1@email.com', 7, '2023-12-02 03:36:44', 1),
(58, '::1', 'accadmin1@email.com', 7, '2023-12-02 19:17:36', 1),
(59, '::1', 'accadmin1', NULL, '2023-12-03 23:12:12', 0),
(60, '::1', 'accadmin1@email.com', 7, '2023-12-03 23:12:23', 1),
(61, '::1', 'accadmin1@email.com', 7, '2023-12-04 09:30:57', 1),
(62, '::1', 'accowner1@email.com', 5, '2023-12-04 09:33:01', 1),
(63, '::1', 'accowner1@email.com', 5, '2023-12-04 20:54:07', 1),
(64, '::1', 'untunggjamari@gmail.com', 8, '2023-12-04 22:35:45', 1),
(65, '::1', 'accowner1@email.com', 5, '2023-12-04 23:00:01', 1),
(66, '::1', 'accowner1@email.com', 5, '2023-12-05 01:23:06', 1),
(67, '::1', 'accadmin1@email.com', 7, '2023-12-05 01:32:07', 1),
(68, '::1', 'accowner1@email.com', 5, '2023-12-05 01:45:51', 1),
(69, '::1', 'accadmin1@email.com', 7, '2023-12-05 01:58:42', 1),
(70, '::1', 'accowner1@email.com', 5, '2023-12-05 02:13:42', 1),
(71, '::1', 'accowner1@email.com', 5, '2023-12-05 06:37:04', 1),
(72, '::1', 'accadmin1@email.com', 7, '2023-12-05 09:58:38', 1),
(73, '::1', 'accowner1@email.com', 5, '2023-12-05 10:00:21', 1),
(74, '::1', 'accowner1@email.com', 5, '2023-12-05 20:04:31', 1),
(75, '::1', 'accowner1@email.com', 5, '2023-12-06 02:52:09', 1),
(76, '::1', 'accadmin1@email.com', 7, '2023-12-06 07:37:50', 1),
(77, '::1', 'accowner1', NULL, '2023-12-06 21:29:22', 0),
(78, '::1', 'accadmin1@email.com', 7, '2023-12-06 21:29:32', 1),
(79, '::1', 'accadmin1@email.com', 7, '2023-12-07 00:22:23', 1),
(80, '::1', 'accowner1@email.com', 5, '2023-12-07 00:23:08', 1),
(81, '::1', 'accowner1@email.com', 5, '2023-12-07 05:15:33', 1),
(82, '::1', 'accowner1@email.com', 5, '2023-12-07 20:23:10', 1),
(83, '::1', 'accadmin1@email.com', 7, '2023-12-07 21:59:08', 1),
(84, '::1', 'accowner1@email.com', 5, '2023-12-07 22:00:40', 1),
(85, '::1', 'accowner1@email.com', 5, '2023-12-08 01:54:42', 1),
(86, '::1', 'accowner1@email.com', 5, '2023-12-08 06:29:12', 1),
(87, '::1', 'accowner1@email.com', 5, '2023-12-08 10:26:11', 1),
(88, '::1', 'andi@gmail.com', 9, '2023-12-08 10:29:33', 1),
(89, '::1', 'accadmin1@email.com', 7, '2023-12-08 10:43:28', 1),
(90, '::1', 'andi@gmail.com', 9, '2023-12-08 10:45:56', 1),
(91, '::1', 'andi@gmail.com', 9, '2023-12-08 18:17:49', 1),
(92, '::1', 'accadmin1@email.com', 7, '2023-12-08 18:36:15', 1),
(93, '::1', 'accowner1@email.com', 5, '2023-12-09 21:09:05', 1),
(94, '::1', 'andi@gmail.com', 9, '2023-12-09 21:09:58', 1),
(95, '::1', 'accowner1@email.com', 5, '2023-12-10 07:28:14', 1),
(96, '::1', 'andi@gmail.com', 9, '2023-12-10 07:29:24', 1),
(97, '::1', 'andi@gmail.com', 9, '2023-12-10 19:11:52', 1),
(98, '::1', 'accadmin1@email.com', 7, '2023-12-10 20:24:47', 1),
(99, '::1', 'andi@gmail.com', 9, '2023-12-10 20:27:49', 1),
(100, '::1', 'accadmin1@email.com', 7, '2023-12-10 20:53:15', 1),
(101, '::1', 'andi@gmail.com', 9, '2023-12-10 20:54:45', 1),
(102, '::1', 'andi@gmail.com', 9, '2023-12-11 01:31:35', 1),
(103, '::1', 'andi@gmail.com', 9, '2023-12-11 07:22:27', 1),
(104, '::1', 'andi@gmail.com', 9, '2023-12-11 20:25:21', 1),
(105, '::1', 'andi@gmail.com', 9, '2023-12-12 02:23:51', 1),
(106, '::1', 'andi@gmail.com', 9, '2023-12-12 10:39:12', 1),
(107, '::1', 'andi@gmail.com', 9, '2023-12-12 19:25:12', 1),
(108, '::1', 'accadmin1@email.com', 7, '2023-12-13 00:43:16', 1),
(109, '::1', 'andi@gmail.com', 9, '2023-12-13 02:56:54', 1),
(110, '::1', 'andi@gmail.com', 9, '2023-12-13 20:12:08', 1),
(111, '::1', 'untunggjamari@gmail.com', 8, '2023-12-14 01:18:56', 1),
(112, '::1', 'ari@gmail.com', 10, '2023-12-14 01:20:37', 1),
(113, '::1', 'andi@gmail.com', 9, '2023-12-14 06:36:05', 1),
(114, '::1', 'daffa@gmail.com', 11, '2023-12-14 20:28:47', 1),
(115, '::1', 'daffa@gmail.com', 11, '2023-12-15 00:40:44', 1),
(116, '::1', 'daffa@gmail.com', 11, '2023-12-15 20:32:42', 1),
(117, '::1', 'daffa@gmail.com', 11, '2023-12-16 06:56:43', 1),
(118, '::1', 'daffa@gmail.com', 11, '2023-12-16 20:41:47', 1),
(119, '::1', 'andi@gmail.com', 9, '2023-12-16 21:16:45', 1),
(120, '::1', 'daffa@gmail.com', 11, '2023-12-16 21:49:29', 1),
(121, '::1', 'accowner1@email.com', 5, '2023-12-16 22:51:25', 1),
(122, '::1', 'daffa@gmail.com', 11, '2023-12-16 22:53:17', 1),
(123, '::1', 'daffa@gmail.com', 11, '2023-12-17 06:32:15', 1),
(124, '::1', 'daffa@gmail.com', 11, '2023-12-17 19:14:31', 1),
(125, '::1', 'daffa@gmail.com', 11, '2023-12-18 00:09:18', 1),
(126, '::1', 'andi@gmail.com', 9, '2023-12-18 05:22:36', 1),
(127, '::1', 'daffa@gmail.com', 11, '2023-12-18 09:00:18', 1),
(128, '::1', 'andi@gmail.com', 9, '2023-12-18 10:24:30', 1),
(129, '::1', 'daffa@gmail.com', 11, '2023-12-18 10:30:40', 1),
(130, '::1', 'daffa@gmail.com', 11, '2023-12-18 21:22:47', 1),
(131, '::1', 'andi@gmail.com', 9, '2023-12-18 22:13:33', 1),
(132, '::1', 'daffa@gmail.com', 11, '2023-12-18 22:14:13', 1),
(133, '::1', 'andi@gmail.com', 9, '2023-12-18 22:17:17', 1),
(134, '::1', 'daffa@gmail.com', 11, '2023-12-18 23:58:12', 1),
(135, '::1', 'andi@gmail.com', 9, '2023-12-19 01:08:42', 1),
(136, '::1', 'daffa@gmail.com', 11, '2023-12-19 01:18:33', 1),
(137, '::1', 'andi@gmail.com', 9, '2023-12-19 01:22:31', 1),
(138, '::1', 'daffa@gmail.com', 11, '2023-12-19 02:06:02', 1),
(139, '::1', 'andi@gmail.com', 9, '2023-12-19 03:41:37', 1),
(140, '::1', 'daffa@gmail.com', 11, '2023-12-19 03:43:02', 1),
(141, '::1', 'daffa@gmail.com', 11, '2023-12-19 08:34:20', 1),
(142, '::1', 'daffa@gmail.com', 11, '2023-12-19 19:47:19', 1),
(143, '::1', 'andi@gmail.com', 9, '2023-12-19 21:34:48', 1),
(144, '::1', 'daffa@gmail.com', 11, '2023-12-19 21:38:45', 1),
(145, '::1', 'andi@gmail.com', 9, '2023-12-19 21:39:34', 1),
(146, '::1', 'daffa@gmail.com', 11, '2023-12-19 21:45:20', 1),
(147, '::1', 'andi@gmail.com', 9, '2023-12-19 21:54:23', 1),
(148, '::1', 'daffa@gmail.com', 11, '2023-12-19 22:22:06', 1),
(149, '::1', 'andi@gmail.com', 9, '2023-12-19 22:33:55', 1),
(150, '::1', 'daffa@gmail.com', 11, '2023-12-19 23:33:22', 1),
(151, '::1', 'andi@gmail.com', 9, '2023-12-20 00:04:16', 1),
(152, '::1', 'daffa@gmail.com', 11, '2023-12-20 00:53:34', 1),
(153, '::1', 'andi@gmail.com', 9, '2023-12-20 01:49:23', 1),
(154, '::1', 'daffa@gmail.com', 11, '2023-12-20 20:22:56', 1),
(155, '::1', 'daffa@gmail.com', 11, '2023-12-20 21:43:50', 1),
(156, '::1', 'andi@gmail.com', 9, '2023-12-21 01:48:03', 1),
(157, '::1', 'daffa@gmail.com', 11, '2023-12-21 02:02:28', 1),
(158, '::1', 'andi@gmail.com', 9, '2023-12-21 03:49:53', 1),
(159, '::1', 'daffa@gmail.com', 11, '2023-12-21 18:53:04', 1),
(160, '::1', 'andi@gmail.com', 9, '2023-12-21 21:32:56', 1),
(161, '::1', 'accadmin1@email.com', 7, '2023-12-22 10:31:28', 1),
(162, '::1', 'accadmin1', NULL, '2023-12-22 17:55:44', 0),
(163, '::1', 'accadmin1@email.com', 7, '2023-12-22 17:55:53', 1),
(164, '::1', 'andi@gmail.com', 9, '2023-12-22 19:05:21', 1),
(165, '::1', 'daffa@gmail.com', 11, '2023-12-22 19:10:57', 1),
(166, '::1', 'ade@gmail.com', 12, '2023-12-22 19:40:55', 1),
(167, '::1', 'ade@gmail.com', 12, '2023-12-22 19:42:41', 1),
(168, '::1', 'ade@gmail.com', 12, '2023-12-22 19:43:44', 1),
(169, '::1', 'andi@gmail.com', 9, '2023-12-22 19:44:16', 1),
(170, '::1', 'daffa@gmail.com', 11, '2023-12-22 21:12:53', 1),
(171, '::1', 'andi@gmail.com', 9, '2023-12-23 23:06:50', 1),
(172, '::1', 'daffa@gmail.com', 11, '2023-12-24 21:55:41', 1),
(173, '::1', 'daffa@gmail.com', 11, '2023-12-25 02:30:39', 1),
(174, '::1', 'daffa@gmail.com', 11, '2023-12-25 06:16:40', 1),
(175, '::1', 'daffa@gmail.com', 11, '2023-12-25 20:53:33', 1),
(176, '::1', 'daffa@gmail.com', 11, '2023-12-26 20:21:44', 1),
(177, '::1', 'andi@gmail.com', 9, '2023-12-26 22:19:27', 1),
(178, '::1', 'daffa@gmail.com', 11, '2023-12-27 07:45:26', 1),
(179, '::1', 'daffa@gmail.com', 11, '2023-12-27 19:31:02', 1),
(180, '::1', 'daffa@gmail.com', 11, '2023-12-28 03:57:52', 1),
(181, '::1', 'daffa@gmail.com', 11, '2023-12-28 06:43:41', 1),
(182, '::1', 'daffa@gmail.com', 11, '2023-12-28 19:13:24', 1),
(183, '::1', 'andi@gmail.com', 9, '2023-12-28 21:00:35', 1),
(184, '::1', 'daffa@gmail.com', 11, '2023-12-29 00:38:36', 1),
(185, '::1', 'andi@gmail.com', 9, '2023-12-29 18:28:32', 1),
(186, '::1', 'daffa@gmail.com', 11, '2023-12-29 18:29:14', 1),
(187, '::1', 'andi@gmail.com', 9, '2023-12-29 21:12:46', 1),
(188, '::1', 'andi@gmail.com', 9, '2023-12-30 21:08:15', 1),
(189, '::1', 'daffa', NULL, '2023-12-30 21:08:23', 0),
(190, '::1', 'daffa@gmail.com', 11, '2023-12-30 21:08:42', 1),
(191, '::1', 'daffa@gmail.com', 11, '2023-12-31 02:20:51', 1),
(192, '::1', 'daffa@gmail.com', 11, '2023-12-31 05:27:26', 1),
(193, '::1', 'daffa@gmail.com', 11, '2023-12-31 07:58:09', 1),
(194, '::1', 'andi@gmail.com', 9, '2023-12-31 08:20:53', 1),
(195, '::1', 'daffa@gmail.com', 11, '2023-12-31 18:52:02', 1),
(196, '::1', 'andi@gmail.com', 9, '2023-12-31 19:44:52', 1),
(197, '::1', 'daffa@gmail.com', 11, '2024-01-01 01:48:51', 1),
(198, '::1', 'andi@gmail.com', 9, '2024-01-01 02:41:16', 1),
(199, '::1', 'andi@gmail.com', 9, '2024-01-01 05:42:30', 1),
(200, '::1', 'daffa@gmail.com', 11, '2024-01-01 05:42:54', 1),
(201, '::1', 'daffa@gmail.com', 11, '2024-01-01 19:59:47', 1),
(202, '::1', 'andi@gmail.com', 9, '2024-01-01 22:45:28', 1),
(203, '::1', 'daffa@gmail.com', 11, '2024-01-02 02:36:39', 1),
(204, '::1', 'andi@gmail.com', 9, '2024-01-02 02:36:51', 1),
(205, '::1', 'andi@gmail.com', 9, '2024-01-02 06:06:48', 1),
(206, '::1', 'daffa@gmail.com', 11, '2024-01-02 06:07:01', 1),
(207, '::1', 'andi@gmail.com', 9, '2024-01-02 19:56:08', 1),
(208, '::1', 'daffa@gmail.com', 11, '2024-01-02 19:56:11', 1),
(209, '::1', 'daffa@gmail.com', 11, '2024-01-03 20:28:35', 1),
(210, '::1', 'andi@gmail.com', 9, '2024-01-03 20:28:51', 1),
(211, '::1', 'daffa@gmail.com', 11, '2024-01-03 23:58:50', 1),
(212, '::1', 'daffa@gmail.com', 11, '2024-01-04 20:44:13', 1),
(213, '::1', 'andi@gmail.com', 9, '2024-01-04 21:26:21', 1),
(214, '::1', 'andi@gmail.com', 9, '2024-01-05 01:45:59', 1),
(215, '::1', 'daffa@gmail.com', 11, '2024-01-05 01:46:25', 1),
(216, '::1', 'daffa@gmail.com', 11, '2024-01-05 07:24:44', 1),
(217, '::1', 'andi@gmail.com', 9, '2024-01-05 07:25:04', 1),
(218, '::1', 'andi@gmail.com', 9, '2024-01-05 20:17:59', 1),
(219, '::1', 'daffa@gmail.com', 11, '2024-01-05 20:18:27', 1),
(220, '::1', 'andi@gmail.com', 9, '2024-01-06 01:55:36', 1),
(221, '::1', 'andi@gmail.com', 9, '2024-01-06 21:03:07', 1),
(222, '::1', 'andi@gmail.com', 9, '2024-01-07 19:10:58', 1),
(223, '::1', 'daffa@gmail.com', 11, '2024-01-07 20:04:02', 1),
(224, '::1', 'daffa@gmail.com', 11, '2024-01-07 23:21:44', 1),
(225, '::1', 'andi@gmail.com', 9, '2024-01-07 23:21:50', 1),
(226, '::1', 'daffa@gmail.com', 11, '2024-01-08 01:43:46', 1),
(227, '::1', 'andi@gmail.com', 9, '2024-01-08 23:11:47', 1),
(228, '::1', 'daffa@gmail.com', 11, '2024-01-08 23:11:55', 1),
(229, '::1', 'andi@gmail.com', 9, '2024-01-09 02:10:52', 1),
(230, '::1', 'daffa@gmail.com', 11, '2024-01-09 21:31:27', 1),
(231, '::1', 'andi', NULL, '2024-01-09 21:32:07', 0),
(232, '::1', 'andi@gmail.com', 9, '2024-01-09 21:32:24', 1),
(233, '::1', 'andi@gmail.com', 9, '2024-01-10 02:56:25', 1),
(234, '::1', 'andi@gmail.com', 9, '2024-01-10 20:23:37', 1),
(235, '::1', 'daffa@gmail.com', 11, '2024-01-10 20:23:56', 1),
(236, '::1', 'andi@gmail.com', 9, '2024-01-10 22:55:55', 1),
(237, '::1', 'andi@gmail.com', 9, '2024-01-11 01:05:32', 1),
(238, '::1', 'daffa@gmail.com', 11, '2024-01-11 06:52:58', 1),
(239, '::1', 'andi@gmail.com', 9, '2024-01-11 06:53:04', 1),
(240, '::1', 'daffa@gmail.com', 11, '2024-01-11 21:10:29', 1),
(241, '::1', 'accadmin1@email.com', 7, '2024-01-11 21:10:48', 1),
(242, '::1', 'accadmin1', NULL, '2024-01-12 02:55:20', 0),
(243, '::1', 'accadmin1@email.com', 7, '2024-01-12 02:55:31', 1),
(244, '::1', 'daffa@gmail.com', 11, '2024-01-12 02:55:38', 1),
(245, '::1', 'daffa@gmail.com', 11, '2024-01-12 07:37:59', 1),
(246, '::1', 'andi', NULL, '2024-01-12 07:38:54', 0),
(247, '::1', 'daffa@gmail.com', 11, '2024-01-12 22:57:35', 1),
(248, '::1', 'daffa@gmail.com', 11, '2024-01-13 02:57:32', 1),
(249, '::1', 'accadmin1@email.com', 7, '2024-01-13 03:40:27', 1),
(250, '::1', 'daffa@gmail.com', 11, '2024-01-13 19:09:13', 1),
(251, '::1', 'andi', NULL, '2024-01-13 19:09:25', 0),
(252, '::1', 'andi@gmail.com', 9, '2024-01-13 19:09:32', 1),
(253, '::1', 'daffa@gmail.com', 11, '2024-01-14 21:32:50', 1),
(254, '::1', 'accadmin1@email.com', 7, '2024-01-14 22:09:50', 1),
(255, '::1', 'andi@gmail.com', 9, '2024-01-15 01:31:00', 1),
(256, '::1', 'daffa@gmail.com', 11, '2024-01-15 01:31:06', 1),
(257, '::1', 'daffa@gmail.com', 11, '2024-01-15 06:07:24', 1),
(258, '::1', 'andi@gmail.com', 9, '2024-01-15 06:57:13', 1),
(259, '::1', 'andi@gmail.com', 9, '2024-01-15 09:20:45', 1),
(260, '::1', 'daffa@gmail.com', 11, '2024-01-16 21:12:37', 1),
(261, '::1', 'andi@gmail.com', 9, '2024-01-16 21:12:44', 1),
(262, '::1', 'daffa@gmail.com', 11, '2024-01-16 23:22:36', 1),
(263, '::1', 'daffa@gmail.com', 11, '2024-01-17 01:43:37', 1),
(264, '::1', 'accadmin1@email.com', 7, '2024-01-17 02:32:20', 1),
(265, '::1', 'andi@gmail.com', 9, '2024-01-17 02:41:00', 1),
(266, '::1', 'andi@gmail.com', 9, '2024-01-17 07:30:10', 1),
(267, '::1', 'daffa@gmail.com', 11, '2024-01-17 07:30:30', 1),
(268, '::1', 'daffa@gmail.com', 11, '2024-01-17 19:58:14', 1),
(269, '::1', 'andi@gmail.com', 9, '2024-01-17 20:41:03', 1),
(270, '::1', 'daffa@gmail.com', 11, '2024-01-18 02:31:34', 1),
(271, '::1', 'andi@gmail.com', 9, '2024-01-18 02:31:41', 1),
(272, '::1', 'accadmin1@email.com', 7, '2024-01-18 02:46:18', 1),
(273, '::1', 'accadmin1@email.com', 7, '2024-01-18 20:45:42', 1),
(274, '::1', 'accadmin1@email.com', 7, '2024-01-19 21:39:30', 1),
(275, '::1', 'accadmin1@email.com', 7, '2024-01-20 01:57:21', 1),
(276, '::1', 'accadmin1@email.com', 7, '2024-01-20 05:55:15', 1),
(277, '::1', 'accadmin1@email.com', 7, '2024-01-20 08:35:27', 1),
(278, '::1', 'ade@gmail.com', 12, '2024-01-20 08:48:19', 1),
(279, '::1', 'daffa@gmail.com', 11, '2024-01-20 10:27:30', 1),
(280, '::1', 'ade@gmail.com', 12, '2024-01-20 10:29:48', 1),
(281, '::1', 'accadmin1@email.com', 7, '2024-01-20 19:32:40', 1),
(282, '::1', 'daffa@gmail.com', 11, '2024-01-20 19:40:47', 1),
(283, '::1', 'ade@gmail.com', 12, '2024-01-20 19:41:27', 1),
(284, '::1', 'ade@gmail.com', 12, '2024-01-22 02:57:29', 1),
(285, '::1', 'daffa@gmail.com', 11, '2024-01-22 02:57:34', 1),
(286, '::1', 'daffa@gmail.com', 11, '2024-01-22 21:00:26', 1),
(287, '::1', 'ade@gmail.com', 12, '2024-01-22 21:01:09', 1),
(288, '::1', 'ade@gmail.com', 12, '2024-01-23 02:42:04', 1),
(289, '::1', 'daffa@gmail.com', 11, '2024-01-23 02:42:09', 1),
(290, '::1', 'ade@gmail.com', 12, '2024-01-23 19:53:50', 1),
(291, '::1', 'daffa@gmail.com', 11, '2024-01-23 19:53:57', 1),
(292, '::1', 'daffa@gmail.com', 11, '2024-01-23 23:24:06', 1),
(293, '::1', 'ade@gmail.com', 12, '2024-01-23 23:24:19', 1),
(294, '::1', 'daffa@gmail.com', 11, '2024-01-24 06:44:10', 1),
(295, '::1', 'andi@gmail.com', 9, '2024-01-24 06:54:19', 1),
(296, '::1', 'daffa@gmail.com', 11, '2024-01-24 19:31:44', 1),
(297, '::1', 'andi@gmail.com', 9, '2024-01-24 19:31:53', 1),
(298, '::1', 'andi@gmail.com', 9, '2024-01-24 22:41:10', 1),
(299, '::1', 'daffa@gmail.com', 11, '2024-01-24 22:41:21', 1),
(300, '::1', 'daffa@gmail.com', 11, '2024-01-25 06:01:20', 1),
(301, '::1', 'andi@gmail.com', 9, '2024-01-25 07:04:00', 1),
(302, '::1', 'ade@gmail.com', 12, '2024-01-25 08:21:30', 1),
(303, '::1', 'daffa@gmail.com', 11, '2024-01-25 19:39:17', 1),
(304, '::1', 'andi@gmail.com', 9, '2024-01-25 19:39:23', 1),
(305, '::1', 'andi', NULL, '2024-01-26 02:20:14', 0),
(306, '::1', 'daffa@gmail.com', 11, '2024-01-26 02:20:21', 1),
(307, '::1', 'andi@gmail.com', 9, '2024-01-26 02:20:26', 1),
(308, '::1', 'daffa@gmail.com', 11, '2024-01-26 07:00:39', 1),
(309, '::1', 'daffa@gmail.com', 11, '2024-01-26 18:15:27', 1),
(310, '::1', 'andi@gmail.com', 9, '2024-01-26 18:33:36', 1),
(311, '::1', 'ade@gmail.com', 12, '2024-01-26 19:42:10', 1),
(312, '::1', 'andi@gmail.com', 9, '2024-01-26 20:16:11', 1),
(313, '::1', 'andi@gmail.com', 9, '2024-01-27 01:01:35', 1),
(314, '::1', 'accadmin1@email.com', 7, '2024-02-25 20:25:15', 1),
(315, '::1', 'accadmin1@email.com', 7, '2024-02-26 19:03:06', 1),
(316, '::1', 'aurahomesta@gmail.com', 13, '2024-02-26 19:27:40', 1),
(317, '::1', 'accadmin1@email.com', 7, '2024-02-27 02:08:36', 1),
(318, '::1', 'accadmin1@email.com', 7, '2024-02-27 02:56:55', 1),
(319, '::1', 'accadmin1@email.com', 7, '2024-02-27 06:23:56', 1),
(320, '::1', 'andi@gmail.com', 9, '2024-02-27 08:38:46', 1),
(321, '::1', 'accadmin1@email.com', 7, '2024-02-27 08:58:10', 1),
(322, '::1', 'andi@gmail.com', 9, '2024-02-27 20:28:47', 1),
(323, '::1', 'homestayharausyafiq@gmail.com', 9, '2024-02-28 01:45:13', 1),
(324, '::1', 'homestayharausyafiq@gmail.com', 9, '2024-02-28 01:46:22', 1),
(325, '::1', 'homestayauraaccount', NULL, '2024-02-28 03:47:09', 0),
(326, '::1', 'aurahomesta@gmail.com', 13, '2024-02-28 03:47:26', 1),
(327, '::1', 'accadmin1@email.com', 7, '2024-02-28 03:58:49', 1),
(328, '::1', 'accadmin1@email.com', 7, '2024-05-30 02:38:57', 1),
(329, '::1', 'homestayharausyafiq@gmail.com', 9, '2024-05-30 02:39:34', 1),
(330, '::1', 'accadmin1@email.com', 7, '2024-05-30 02:41:00', 1),
(331, '::1', 'homestayharausyafiq@gmail.com', 9, '2024-05-30 02:50:43', 1),
(332, '::1', 'daffa@gmail.com', 11, '2024-05-30 02:54:32', 1),
(333, '::1', 'accadmin1@email.com', 7, '2024-05-30 02:55:36', 1),
(334, '::1', 'homestayharausyafiq@gmail.com', 9, '2024-05-30 02:56:31', 1),
(335, '::1', 'daffa@gmail.com', 11, '2024-05-30 03:04:29', 1),
(336, '::1', 'daffa@gmail.com', 11, '2024-06-03 05:25:43', 1),
(337, '::1', 'daffa@gmail.com', 11, '2024-06-03 05:27:06', 1),
(338, '::1', 'accadmin1', NULL, '2024-06-03 05:35:31', 0),
(339, '::1', 'accadmin1', NULL, '2024-06-03 05:35:34', 0),
(340, '::1', 'accadmin1@email.com', 7, '2024-06-03 05:35:38', 1),
(341, '::1', 'accadmin1', NULL, '2024-08-27 09:41:46', 0),
(342, '::1', 'accadmin1', NULL, '2024-08-27 09:41:54', 0),
(343, '::1', 'accadmin1@email.com', 7, '2024-08-27 09:42:04', 1),
(344, '::1', 'accadmin1@email.com', 7, '2024-08-27 10:29:44', 1),
(345, '::1', 'accadmin1@email.com', 7, '2024-09-11 02:09:30', 1),
(346, '::1', 'aa', NULL, '2024-09-14 03:50:57', 0),
(347, '::1', 'accadmin1@email.com', 7, '2024-09-14 03:51:29', 1),
(348, '::1', 'accadmin1@email.com', 7, '2024-09-14 03:52:07', 1),
(349, '::1', 'accadmin1@email.com', 7, '2024-09-14 03:53:55', 1),
(350, '::1', 'accadmin1@email.com', 7, '2024-09-14 03:54:07', 1),
(351, '::1', 'accadmin1@email.com', 7, '2024-09-14 03:56:58', 1),
(352, '::1', 'accadmin1@email.com', 7, '2024-09-14 04:01:15', 1),
(353, '::1', 'accadmin1@email.com', 7, '2024-09-14 04:01:27', 1),
(354, '::1', 'accadmin1@email.com', 7, '2024-09-15 01:35:20', 1),
(355, '::1', 'homestayharausyafiq@gmail.com', 9, '2024-09-15 01:35:39', 1),
(356, '::1', 'homestayharausyafiq@gmail.com', 9, '2024-09-15 01:39:48', 1),
(357, '::1', 'homestayharausyafiq@gmail.com', 9, '2024-09-15 01:40:17', 1),
(358, '::1', 'daffa@gmail.com', 11, '2024-09-15 01:43:07', 1),
(359, '::1', 'homestayharausyafiq@gmail.com', 9, '2024-09-15 01:44:11', 1),
(360, '::1', 'accadmin1', NULL, '2024-09-15 01:45:13', 0),
(361, '::1', 'accadmin1@email.com', 7, '2024-09-15 01:45:22', 1),
(362, '::1', 'daffa@gmail.com', 11, '2024-09-15 01:47:33', 1),
(363, '::1', 'daffa@gmail.com', 11, '2024-09-15 01:48:56', 1),
(364, '::1', 'accadmin1', NULL, '2024-09-15 08:52:13', 0),
(365, '::1', 'accadmin1@email.com', 7, '2024-09-15 08:52:22', 1),
(366, '::1', 'accadmin1@email.com', 7, '2024-09-15 08:53:18', 1),
(367, '::1', 'daffamuyassar', NULL, '2024-09-15 09:58:31', 0),
(368, '::1', 'daffamuyassar', NULL, '2024-09-15 09:58:44', 0),
(369, '::1', 'daffamuyassar', NULL, '2024-09-15 09:59:02', 0),
(370, '::1', 'homestayharausyafiq@gmail.com', 9, '2024-09-15 09:59:25', 1),
(371, '::1', 'accadmin1@email.com', 7, '2024-09-15 10:00:08', 1),
(372, '::1', 'accadmin1@email.com', 7, '2024-09-15 10:01:29', 1),
(373, '::1', 'accadmin1@email.com', 7, '2024-09-15 10:05:56', 1),
(374, '::1', 'homestayharausyafiq@gmail.com', 9, '2024-09-15 22:32:15', 1),
(375, '::1', 'accadmin1@email.com', 7, '2024-09-15 22:32:28', 1),
(376, '::1', 'accadmin1@email.com', 7, '2024-09-16 02:35:08', 1),
(377, '::1', 'accadmin1@email.com', 7, '2024-09-16 07:49:56', 1),
(378, '::1', 'accadmin1@email.com', 7, '2024-09-17 06:41:15', 1),
(379, '::1', 'accadmin1@email.com', 7, '2024-09-18 08:22:45', 1),
(380, '::1', 'accadmin1@email.com', 7, '2024-09-19 03:14:49', 1),
(381, '::1', 'accadmin1@email.com', 7, '2024-09-21 07:51:10', 1),
(382, '::1', 'accadmin1@email.com', 7, '2024-09-23 08:42:08', 1),
(383, '::1', 'accadmin1', NULL, '2024-09-23 08:42:44', 0),
(384, '::1', 'accadmin1@email.com', 7, '2024-09-23 08:57:57', 1),
(385, '::1', 'accadmin1@email.com', 7, '2024-09-26 05:32:57', 1),
(386, '::1', 'accadmin1@email.com', 7, '2024-09-26 11:36:49', 1),
(387, '::1', 'accadmin1@email.com', 7, '2024-09-28 05:02:46', 1),
(388, '::1', 'accadmin1@email.com', 7, '2024-09-28 10:09:28', 1),
(389, '::1', 'accadmin1', NULL, '2024-09-28 22:16:46', 0),
(390, '::1', 'accadmin1@email.com', 7, '2024-09-28 22:16:56', 1),
(391, '::1', 'accadmin1@email.com', 7, '2024-09-29 07:38:31', 1),
(392, '::1', 'homestayaaa@gmail.com', 23, '2024-09-29 07:56:52', 1),
(393, '::1', 'daffamuyassar', NULL, '2024-09-29 08:01:59', 0),
(394, '::1', 'daffamuyassar', NULL, '2024-09-29 08:02:06', 0),
(395, '::1', 'daffa', NULL, '2024-09-29 08:02:41', 0),
(396, '::1', 'daffa@gmail.com', 11, '2024-09-29 08:02:48', 1),
(397, '::1', 'homestayaaa@gmail.com', 23, '2024-09-29 08:04:37', 1),
(398, '::1', 'daffa@gmail.com', 11, '2024-09-29 08:08:38', 1),
(399, '::1', 'accadmin1@email.com', 7, '2024-09-30 07:14:55', 1),
(400, '::1', 'daffa@gmail.com', 11, '2024-09-30 07:15:39', 1),
(401, '::1', 'homestayaaa', NULL, '2024-09-30 07:44:33', 0),
(402, '::1', 'homestayaaa@gmail.com', 23, '2024-09-30 07:44:42', 1),
(403, '::1', 'daffa@gmail.com', 11, '2024-09-30 10:29:55', 1),
(404, '::1', 'daffa@gmail.com', 11, '2024-10-02 02:10:37', 1),
(405, '::1', 'homestayaaa@gmail.com', 23, '2024-10-02 02:21:16', 1),
(406, '::1', 'daffa@gmail.com', 11, '2024-10-02 09:05:43', 1),
(407, '::1', 'daffa', NULL, '2024-10-03 08:08:34', 0),
(408, '::1', 'daffa@gmail.com', 11, '2024-10-03 08:08:46', 1),
(409, '::1', 'homestayaaa@gmail.com', 23, '2024-10-03 08:16:34', 1),
(410, '::1', 'daffa', NULL, '2024-10-03 10:42:14', 0),
(411, '::1', 'daffa@gmail.com', 11, '2024-10-03 10:42:23', 1),
(412, '::1', 'homestayaaa@gmail.com', 23, '2024-10-03 10:43:34', 1),
(413, '::1', 'daffa', NULL, '2024-10-04 06:40:23', 0),
(414, '::1', 'daffa@gmail.com', 11, '2024-10-04 06:40:31', 1),
(415, '::1', 'homestayaaa@gmail.com', 23, '2024-10-04 06:51:33', 1),
(416, '::1', 'homestayaaa@gmail.com', 23, '2024-10-04 10:07:56', 1),
(417, '::1', 'daffa@gmail.com', 11, '2024-10-04 21:54:32', 1),
(418, '::1', 'homestayaaa@gmail.com', 23, '2024-10-04 22:03:12', 1),
(419, '::1', 'daffa', NULL, '2024-10-05 01:46:37', 0),
(420, '::1', 'daffa@gmail.com', 11, '2024-10-05 01:46:47', 1),
(421, '::1', 'homestayaaa@gmail.com', 23, '2024-10-05 01:48:01', 1),
(422, '::1', 'daffa@gmail.com', 11, '2024-10-05 03:27:01', 1),
(423, '::1', 'homestayaaa@gmail.com', 23, '2024-10-05 05:51:00', 1),
(424, '::1', 'accadmin1@email.com', 7, '2024-10-10 02:41:38', 1),
(425, '::1', 'homestayddd@gmail.com', 26, '2024-10-10 04:13:27', 1),
(426, '::1', 'accadmin1@email.com', 7, '2024-10-10 04:17:22', 1),
(427, '::1', 'daffa@gmail.com', 11, '2024-10-10 05:42:51', 1),
(428, '::1', 'homestayaaa@gmail.com', 23, '2024-10-10 05:44:21', 1),
(429, '::1', 'daffa@gmail.com', 11, '2024-10-11 04:36:22', 1),
(430, '::1', 'homestayaaa@gmail.com', 23, '2024-10-11 04:41:46', 1),
(431, '::1', 'accadmin1', NULL, '2024-10-13 23:55:25', 0),
(432, '::1', 'accadmin1@email.com', 7, '2024-10-13 23:55:32', 1),
(433, '::1', 'daffa@gmail.com', 11, '2024-10-14 00:10:55', 1),
(434, '::1', 'homestayaaa', NULL, '2024-10-14 00:14:29', 0),
(435, '::1', 'homestayaaa@gmail.com', 23, '2024-10-14 00:14:36', 1),
(436, '::1', 'daffa@gmail.com', 11, '2024-10-14 01:25:56', 1),
(437, '::1', 'daffa@gmail.com', 11, '2024-10-14 06:21:34', 1),
(438, '::1', 'homestayaaa@gmail.com', 23, '2024-10-14 06:25:53', 1),
(439, '::1', 'homestayaaa@gmail.com', 23, '2024-10-14 08:47:30', 1),
(440, '::1', 'daffa@gmail.com', 11, '2024-10-14 11:14:20', 1),
(441, '::1', 'accadmin1@email.com', 7, '2024-10-14 11:17:44', 1),
(442, '::1', 'homestayaaa@gmail.com', 23, '2024-10-14 11:37:45', 1),
(443, '::1', 'accadmin1@email.com', 7, '2024-10-21 08:23:35', 1),
(444, '::1', 'homestayaaa@gmail.com', 23, '2024-10-21 09:21:10', 1),
(445, '::1', 'daffa@gmail.com', 11, '2024-10-21 09:21:21', 1),
(446, '::1', 'accadmin1@email.com', 7, '2024-10-24 09:52:36', 1),
(447, '::1', 'pokdarwispariangan1@gmail.com', 7, '2024-10-24 10:19:21', 1),
(448, '::1', 'pokdarwispariangan1@gmail.com', 7, '2024-10-24 12:29:59', 1),
(449, '::1', 'pokdarwispariangan1@gmail.com', 7, '2024-10-25 10:34:59', 1),
(450, '::1', 'homestayaaa@gmail.com', 23, '2024-10-25 13:39:39', 1),
(451, '::1', 'pokdarwispariangan1@gmail.com', 7, '2024-10-26 02:31:27', 1),
(452, '::1', 'umegahomestay@gmail.com', 23, '2024-10-26 02:37:01', 1),
(453, '::1', 'shandyka2403@gmail.com', 11, '2024-10-26 02:55:40', 1),
(454, '::1', 'gudesterhomestay@gmail.com', 24, '2024-10-26 02:56:27', 1),
(455, '::1', 'nabilahomestay@gmail.com', 25, '2024-10-26 03:05:31', 1),
(456, '::1', 'shandyka2403@gmail.com', 11, '2024-10-26 03:41:29', 1),
(457, '::1', 'gudesterhomestay@gmail.com', 24, '2024-10-26 03:41:46', 1),
(458, '::1', 'pokdarwispariangan1@gmail.com', 7, '2024-10-26 04:41:07', 1),
(459, '::1', 'shandyka2403@gmail.com', 11, '2024-10-26 04:42:13', 1),
(460, '::1', 'shandyka2403@gmail.com', 11, '2024-10-26 05:07:21', 1),
(461, '::1', 'umegahomestay@gmail.com', 23, '2024-10-26 05:08:30', 1),
(462, '::1', 'pokdarwispariangan1@gmail.com', 7, '2024-10-26 05:21:26', 1),
(463, '::1', 'pokdarwispariangan1@gmail.com', 7, '2024-10-30 04:15:30', 1),
(464, '::1', 'shandyka2403@gmail.com', 11, '2024-10-30 04:26:54', 1),
(465, '::1', 'pokdarwispariangan1@gmail.com', 7, '2024-10-30 05:12:17', 1),
(466, '::1', 'dykdyk', NULL, '2024-11-17 03:00:02', 0),
(467, '::1', 'shandyka2403@gmail.com', 11, '2024-11-17 03:00:13', 1),
(468, '::1', 'umegahomestay@gmail.com', 23, '2024-11-17 03:01:52', 1),
(469, '::1', 'shandyka2403@gmail.com', 11, '2024-11-17 09:11:50', 1),
(470, '::1', 'shandyka2403@gmail.com', 11, '2024-11-24 01:44:54', 1),
(471, '::1', 'umegahomestay@gmail.com', 23, '2024-11-24 02:16:23', 1),
(472, '::1', 'shandyka2403@gmail.com', 11, '2024-11-24 08:37:16', 1),
(473, '::1', 'umegahomestay@gmail.com', 23, '2024-11-24 08:38:15', 1),
(474, '::1', 'dykdyk', NULL, '2024-11-26 08:19:40', 0),
(475, '::1', 'dykdyk', NULL, '2024-11-26 08:19:50', 0),
(476, '::1', 'dykdyk', NULL, '2024-11-26 08:19:59', 0),
(477, '::1', 'shandyka2403@gmail.com', 11, '2024-11-26 08:20:16', 1),
(478, '::1', 'dyk', NULL, '2024-11-30 01:48:23', 0),
(479, '::1', 'dyk', NULL, '2024-11-30 01:48:32', 0),
(480, '::1', 'dykdyk', NULL, '2024-11-30 01:48:45', 0),
(481, '::1', 'shandyka2403@gmail.com', 11, '2024-11-30 01:48:56', 1),
(482, '::1', 'dykdyk', NULL, '2024-12-14 10:48:22', 0),
(483, '::1', 'shandyka2403@gmail.com', 11, '2024-12-14 10:48:30', 1),
(484, '::1', 'umegahomestay@gmail.com', 23, '2024-12-14 11:07:32', 1),
(485, '::1', 'umegahomestay@gmail.com', 23, '2024-12-15 09:31:05', 1),
(486, '::1', 'shandyka2403@gmail.com', 11, '2024-12-15 09:50:41', 1),
(487, '::1', 'umegahomestay@gmail.com', 23, '2024-12-15 09:51:31', 1),
(488, '::1', 'shandyka2403@gmail.com', 11, '2024-12-15 21:02:08', 1),
(489, '::1', 'umegahomestay@gmail.com', 23, '2024-12-15 21:18:30', 1),
(490, '::1', 'shandyka2403@gmail.com', 11, '2024-12-16 00:44:11', 1),
(491, '::1', 'shandyka2403@gmail.com', 11, '2024-12-16 04:23:08', 1),
(492, '::1', 'pokdarwispariangan1@gmail.com', 7, '2024-12-16 04:45:01', 1),
(493, '::1', 'shandyka2403@gmail.com', 11, '2024-12-16 04:47:53', 1),
(494, '::1', 'shandyka2403@gmail.com', 11, '2024-12-16 08:58:44', 1),
(495, '::1', 'umegahomestay@gmail.com', 23, '2024-12-16 09:08:21', 1),
(496, '::1', 'pokdarwispariangan1@gmail.com', 7, '2024-12-16 11:03:15', 1),
(497, '::1', 'umegahomestay@gmail.com', 23, '2024-12-16 11:17:49', 1),
(498, '::1', 'shandyka2403@gmail.com', 11, '2024-12-17 01:18:31', 1),
(499, '::1', 'shandyka2403@gmail.com', 11, '2024-12-17 07:51:06', 1),
(500, '::1', 'shandyka2403@gmail.com', 11, '2024-12-17 22:19:59', 1),
(501, '::1', 'gudesterhomestay@gmail.com', 24, '2024-12-18 00:39:05', 1),
(502, '::1', 'umegahomestay@gmail.com', 23, '2024-12-18 03:03:23', 1),
(503, '::1', 'shandyka2403@gmail.com', 11, '2024-12-22 09:23:10', 1),
(504, '::1', 'shandyka2403@gmail.com', 11, '2024-12-23 09:20:30', 1),
(505, '::1', 'shandyka2403@gmail.com', 11, '2024-12-24 08:46:07', 1),
(506, '::1', 'gudesterhomestay@gmail.com', 24, '2024-12-24 09:35:34', 1),
(507, '::1', 'shandyka2403@gmail.com', 11, '2024-12-26 06:34:30', 1),
(508, '::1', 'umegahomestay@gmail.com', 23, '2024-12-26 07:28:05', 1),
(509, '::1', 'umegahomestay@gmail.com', 23, '2024-12-26 12:44:45', 1),
(510, '::1', 'shandyka2403@gmail.com', 11, '2024-12-26 13:22:51', 1),
(511, '::1', 'shandyka2403@gmail.com', 11, '2024-12-27 01:01:53', 1),
(512, '::1', 'umegahomestay@gmail.com', 23, '2024-12-27 01:26:47', 1),
(513, '::1', 'shandyka2403@gmail.com', 11, '2024-12-27 08:27:38', 1),
(514, '::1', 'umegahomestay@gmail.com', 23, '2024-12-27 08:43:42', 1),
(515, '::1', 'umegahomestay@gmail.com', 23, '2024-12-28 02:09:34', 1),
(516, '::1', 'pokdarwispariangan1@gmail.com', 7, '2024-12-28 02:10:13', 1),
(517, '::1', 'shandyka2403@gmail.com', 11, '2024-12-28 02:11:41', 1),
(518, '::1', 'pokdarwispariangan1@gmail.com', 7, '2024-12-29 08:56:31', 1),
(519, '::1', 'pokdarwispariangan1@gmail.com', 7, '2024-12-30 02:58:26', 1),
(520, '::1', 'shandyka2403@gmail.com', 11, '2024-12-30 03:34:24', 1),
(521, '::1', 'pokdarwispariangan1@gmail.com', 7, '2024-12-30 18:32:56', 1),
(522, '::1', 'pokdarwispariangan1@gmail.com', 7, '2025-01-04 03:37:02', 1),
(523, '::1', 'shandyka2403@gmail.com', 11, '2025-01-04 06:35:31', 1),
(524, '::1', 'shandyka2403@gmail.com', 11, '2025-01-06 01:19:56', 1),
(525, '::1', 'pokdarwispariangan1@gmail.com', 7, '2025-01-06 02:03:29', 1),
(526, '::1', 'shandyka2403@gmail.com', 11, '2025-01-06 02:29:29', 1),
(527, '::1', 'shandyka2403@gmail.com', 11, '2025-01-06 08:07:56', 1),
(528, '::1', 'pokdarwispariangan1@gmail.com', 7, '2025-01-06 09:05:55', 1),
(529, '::1', 'shandyka2403@gmail.com', 11, '2025-01-06 10:17:17', 1),
(530, '::1', 'shandyka2403@gmail.com', 11, '2025-01-07 01:19:38', 1),
(531, '::1', 'pokdarwis.pariangan', NULL, '2025-01-07 01:30:39', 0),
(532, '::1', 'pokdarwispariangan1@gmail.com', 7, '2025-01-07 01:30:42', 1),
(533, '::1', 'shandyka2403@gmail.com', 11, '2025-01-07 01:31:35', 1),
(534, '::1', 'pokdarwispariangan1@gmail.com', 7, '2025-01-07 02:33:52', 1),
(535, '::1', 'umegahomestay', NULL, '2025-01-07 02:34:54', 0),
(536, '::1', 'umegahomestay@gmail.com', 23, '2025-01-07 02:34:57', 1),
(537, '::1', 'shandyka2403@gmail.com', 11, '2025-01-07 02:35:24', 1),
(538, '::1', 'pokdarwispariangan1@gmail.com', 7, '2025-01-09 04:12:12', 1),
(539, '::1', 'pokdarwis.pariangan', NULL, '2025-01-09 09:00:42', 0),
(540, '::1', 'pokdarwispariangan1@gmail.com', 7, '2025-01-09 09:00:46', 1),
(541, '::1', 'pokdarwispariangan1@gmail.com', 7, '2025-01-10 08:12:40', 1),
(542, '::1', 'pokdarwispariangan1@gmail.com', 7, '2025-01-10 08:12:46', 1),
(543, '::1', 'shandyka2403@gmail.com', 11, '2025-01-10 09:06:39', 1),
(544, '::1', 'pokdarwispariangan1@gmail.com', 7, '2025-01-10 10:43:34', 1),
(545, '::1', 'pokdarwispariangan1@gmail.com', 7, '2025-01-11 09:01:54', 1),
(546, '::1', 'shandyka2403@gmail.com', 11, '2025-01-11 11:22:27', 1),
(547, '::1', 'pokdarwispariangan1@gmail.com', 7, '2025-01-14 12:53:17', 1),
(548, '::1', 'umegahomestay@gmail.com', 23, '2025-01-14 12:53:43', 1),
(549, '::1', 'pokdarwispariangan1@gmail.com', 7, '2025-01-14 12:54:48', 1),
(550, '::1', 'umegahomestay@gmail.com', 23, '2025-01-16 09:55:36', 1),
(551, '::1', 'pokdarwispariangan1@gmail.com', 7, '2025-01-16 10:08:35', 1),
(552, '::1', 'pokdarwispariangan1@gmail.com', 7, '2025-01-16 10:43:52', 1),
(553, '::1', 'umegahomestay@gmail.com', 23, '2025-01-16 11:22:06', 1),
(554, '::1', 'dykdyk', NULL, '2025-01-16 11:45:11', 0),
(555, '::1', 'shandyka2403@gmail.com', 11, '2025-01-16 11:45:14', 1),
(556, '::1', 'shandyka2403@gmail.com', 11, '2025-01-16 14:46:25', 1),
(557, '::1', 'shandyka2403@gmail.com', 11, '2025-01-16 15:22:24', 1),
(558, '::1', 'pokdarwispariangan1@gmail.com', 7, '2025-01-16 16:58:04', 1),
(559, '::1', 'shandyka2403@gmail.com', 11, '2025-01-17 10:53:00', 1),
(560, '::1', 'umegahomestay@gmail.com', 23, '2025-01-17 10:55:00', 1),
(561, '::1', 'umegahomestay', NULL, '2025-01-17 12:00:28', 0),
(562, '::1', 'umegahomestay@gmail.com', 23, '2025-01-17 12:00:31', 1),
(563, '::1', 'shandyka2403@gmail.com', 11, '2025-01-17 12:23:55', 1),
(564, '::1', 'pokdarwispariangan1@gmail.com', 7, '2025-01-18 06:49:52', 1),
(565, '::1', 'umegahomestay@gmail.com', 23, '2025-01-18 11:59:44', 1),
(566, '::1', 'pokdarwispariangan1@gmail.com', 7, '2025-01-21 09:39:56', 1),
(567, '::1', 'shandyka2403@gmail.com', 11, '2025-01-21 10:22:19', 1),
(568, '::1', 'pokdarwis.pariangan', NULL, '2025-01-21 10:22:36', 0),
(569, '::1', 'pokdarwispariangan1@gmail.com', 7, '2025-01-21 10:22:40', 1),
(570, '::1', 'pokdarwispariangan1@gmail.com', 7, '2025-01-21 10:36:44', 1),
(571, '::1', 'umegahomestay@gmail.com', 23, '2025-01-21 11:33:57', 1),
(572, '::1', 'pokdarwispariangan1@gmail.com', 7, '2025-01-21 11:35:45', 1),
(573, '::1', 'homestayowner@gmail.com', 27, '2025-01-21 11:36:38', 1),
(574, '::1', 'pokdarwispariangan1@gmail.com', 7, '2025-01-21 11:37:27', 1),
(575, '::1', 'umegahomestay@gmail.com', 23, '2025-01-21 11:37:50', 1),
(576, '::1', 'shandyka2403@gmail.com', 11, '2025-01-21 12:23:27', 1),
(577, '::1', 'shandyka2403@gmail.com', 11, '2025-01-21 12:58:34', 1),
(578, '::1', 'gudesterhomestay@gmail.com', 24, '2025-01-21 13:29:25', 1),
(579, '::1', 'nabilahomestay@gmail.com', 25, '2025-01-21 13:33:27', 1),
(580, '::1', 'gudesterhomestay@gmail.com', 24, '2025-01-21 13:37:09', 1),
(581, '::1', 'umegahomestay@gmail.com', 23, '2025-01-21 13:40:27', 1),
(582, '::1', 'shandyka2403@gmail.com', 11, '2025-01-22 02:52:32', 1),
(583, '::1', 'pokdarwispariangan1@gmail.com', 7, '2025-01-22 03:04:34', 1),
(584, '::1', 'shandyka2403@gmail.com', 11, '2025-01-22 09:26:52', 1),
(585, '::1', 'shandyka2403@gmail.com', 11, '2025-01-23 09:22:58', 1),
(586, '::1', 'gudesterhomestay@gmail.com', 24, '2025-01-23 09:44:00', 1),
(587, '::1', 'shandyka2403@gmail.com', 11, '2025-01-23 12:16:01', 1),
(588, '::1', 'pokdarwispariangan1@gmail.com', 7, '2025-01-23 12:36:59', 1),
(589, '::1', 'pokdarwispariangan1@gmail.com', 7, '2025-01-23 12:45:04', 1),
(590, '::1', 'pokdarwis.pariangan', NULL, '2025-01-23 12:46:09', 0),
(591, '::1', 'pokdarwispariangan1@gmail.com', 7, '2025-01-23 12:46:12', 1),
(592, '::1', 'pokdarwispariangan1@gmail.com', 7, '2025-01-23 12:47:26', 1),
(593, '::1', 'abcd@gmail.com', 28, '2025-01-23 12:47:51', 1),
(594, '::1', 'pokdarwispariangan1@gmail.com', 7, '2025-01-23 12:49:57', 1),
(595, '::1', 'umegahomestay@gmail.com', 23, '2025-01-23 12:59:52', 1),
(596, '::1', 'umegahomestay@gmail.com', 23, '2025-01-23 13:20:45', 1),
(597, '::1', 'pokdarwispariangan1@gmail.com', 7, '2025-01-24 03:05:06', 1),
(598, '::1', 'umegahomestay@gmail.com', 23, '2025-01-24 03:05:57', 1),
(599, '::1', 'dykdyk', NULL, '2025-01-24 03:09:49', 0),
(600, '::1', 'shandyka2403@gmail.com', 11, '2025-01-24 03:09:53', 1),
(601, '::1', 'umegahomestay@gmail.com', 23, '2025-01-24 03:10:30', 1),
(602, '::1', 'shandyka2403@gmail.com', 11, '2025-01-24 03:16:12', 1),
(603, '::1', 'pokdarwispariangan1@gmail.com', 7, '2025-01-24 03:16:50', 1),
(604, '::1', 'pokdarwispariangan1@gmail.com', 7, '2025-01-24 03:25:36', 1),
(605, '::1', 'umegahomestay@gmail.com', 23, '2025-01-25 04:42:12', 1),
(606, '::1', 'dykdyk', NULL, '2025-01-25 04:55:06', 0),
(607, '::1', 'shandyka2403@gmail.com', 11, '2025-01-25 04:55:11', 1),
(608, '::1', 'pokdarwispariangan1@gmail.com', 7, '2025-01-25 06:11:10', 1),
(609, '::1', 'pokdarwispariangan1@gmail.com', 7, '2025-01-25 06:23:01', 1),
(610, '::1', 'pokdarwispariangan1@gmail.com', 7, '2025-01-25 06:41:50', 1),
(611, '::1', 'pokdarwispariangan1@gmail.com', 7, '2025-01-25 07:14:40', 1),
(612, '::1', 'homestayowner@gmail.com', 29, '2025-01-25 07:15:12', 1),
(613, '::1', 'umegahomestay@gmail.com', 23, '2025-01-25 07:20:26', 1),
(614, '::1', 'homestayowner@gmail.com', 29, '2025-01-25 07:21:37', 1),
(615, '::1', 'umegahomestay@gmail.com', 23, '2025-01-25 10:28:54', 1),
(616, '::1', 'homestayowner@gmail.com', 29, '2025-01-25 10:32:18', 1),
(617, '::1', 'pokdarwispariangan1@gmail.com', 7, '2025-01-25 11:03:21', 1),
(618, '::1', 'homestayowner@gmail.com', 29, '2025-01-25 11:10:56', 1),
(619, '::1', 'umegahomestay@gmail.com', 23, '2025-01-25 11:25:16', 1),
(620, '::1', 'shandyka2403@gmail.com', 11, '2025-01-25 12:34:49', 1),
(621, '::1', 'shandyka2403@gmail.com', 11, '2025-01-25 12:35:22', 1),
(622, '::1', 'umegahomestay@gmail.com', 23, '2025-01-25 12:48:21', 1),
(623, '::1', 'shandyka2403@gmail.com', 11, '2025-01-25 13:20:59', 1),
(624, '::1', 'umegahomestay@gmail.com', 23, '2025-01-25 14:41:04', 1),
(625, '::1', 'dykdyk', NULL, '2025-01-26 07:50:37', 0),
(626, '::1', 'shandyka2403@gmail.com', 11, '2025-01-26 07:50:41', 1),
(627, '::1', 'umegahomestay@gmail.com', 23, '2025-01-26 07:50:53', 1),
(628, '::1', 'umegahomestay@gmail.com', 23, '2025-01-26 11:36:17', 1),
(629, '::1', 'shandyka2403@gmail.com', 11, '2025-01-26 12:09:28', 1),
(630, '::1', 'umegahomestay@gmail.com', 23, '2025-01-26 18:59:53', 1),
(631, '::1', 'shandyka2403@gmail.com', 11, '2025-01-26 22:40:26', 1),
(632, '::1', 'umegahomestay@gmail.com', 23, '2025-01-26 23:37:46', 1),
(633, '::1', 'pokdarwispariangan1@gmail.com', 7, '2025-01-28 04:46:10', 1),
(634, '::1', 'pokdarwispariangan1@gmail.com', 7, '2025-01-28 05:53:38', 1),
(635, '::1', 'umegahomestay@gmail.com', 23, '2025-01-28 06:45:37', 1),
(636, '::1', 'pokdarwispariangan1@gmail.com', 7, '2025-01-28 10:19:04', 1),
(637, '::1', 'umegahomestay@gmail.com', 23, '2025-01-28 10:37:12', 1),
(638, '::1', 'shandyka2403@gmail.com', 11, '2025-01-28 11:03:19', 1),
(639, '::1', 'umegahomestay@gmail.com', 23, '2025-01-28 12:21:02', 1),
(640, '::1', 'shandyka2403@gmail.com', 11, '2025-01-28 14:23:50', 1),
(641, '::1', 'umegahomestay@gmail.com', 23, '2025-01-28 18:54:17', 1),
(642, '::1', 'pokdarwispariangan1@gmail.com', 7, '2025-01-31 13:01:14', 1),
(643, '::1', 'pokdarwispariangan1@gmail.com', 7, '2025-02-01 12:24:08', 1),
(644, '::1', 'umegahomestay@gmail.com', 23, '2025-02-01 21:57:28', 1),
(645, '::1', 'shandyka2403@gmail.com', 11, '2025-02-01 22:01:43', 1),
(646, '::1', 'umegahomestay@gmail.com', 23, '2025-02-01 22:22:17', 1),
(647, '::1', 'shandyka2403@gmail.com', 11, '2025-02-02 22:20:30', 1),
(648, '::1', 'umegahomestay@gmail.com', 23, '2025-02-02 22:24:30', 1),
(649, '::1', 'shandyka2403@gmail.com', 11, '2025-02-02 22:30:51', 1),
(650, '::1', 'shandyka2403@gmail.com', 11, '2025-02-04 11:01:06', 1),
(651, '::1', 'umegahomestay@gmail.com', 23, '2025-02-04 11:04:24', 1),
(652, '::1', 'pokdarwispariangan1@gmail.com', 7, '2025-02-05 02:22:23', 1),
(653, '::1', 'pokdarwispariangan1@gmail.com', 7, '2025-02-05 10:36:51', 1),
(654, '::1', 'pokdarwispariangan1@gmail.com', 7, '2025-02-06 12:01:08', 1),
(655, '::1', 'pokdarwispariangan1@gmail.com', 7, '2025-02-07 21:36:13', 1),
(656, '::1', 'shandyka2403@gmail.com', 11, '2025-02-09 19:14:58', 1),
(657, '::1', 'pokdarwispariangan1@gmail.com', 7, '2025-02-09 21:49:44', 1),
(658, '::1', 'pokdarwispariangan1@gmail.com', 7, '2025-02-10 01:31:11', 1),
(659, '::1', 'umegahomestay@gmail.com', 23, '2025-02-10 01:34:49', 1),
(660, '::1', 'shandyka2403@gmail.com', 11, '2025-02-10 10:21:31', 1),
(661, '::1', 'shandyka2403@gmail.com', 11, '2025-02-11 01:55:10', 1),
(662, '::1', 'shandyka2403@gmail.com', 11, '2025-02-11 02:16:29', 1),
(663, '::1', 'pokdarwispariangan1@gmail.com', 7, '2025-02-11 02:49:37', 1),
(664, '::1', 'shandyka2403@gmail.com', 11, '2025-02-11 02:57:05', 1),
(665, '::1', 'shandyka2403@gmail.com', 11, '2025-02-15 06:38:07', 1),
(666, '::1', 'dykdyk', NULL, '2025-02-19 01:15:31', 0),
(667, '::1', 'shandyka2403@gmail.com', 11, '2025-02-19 01:15:35', 1),
(668, '::1', 'pokdarwispariangan1@gmail.com', 7, '2025-02-24 10:55:26', 1),
(669, '::1', 'umegahomestay@gmail.com', 23, '2025-02-24 11:10:45', 1),
(670, '::1', 'shandyka2403@gmail.com', 11, '2025-02-24 11:25:48', 1),
(671, '::1', 'umegahomestay@gmail.com', 23, '2025-02-24 12:55:22', 1),
(672, '::1', 'shandyka2403@gmail.com', 11, '2025-02-24 12:55:43', 1),
(673, '::1', 'pokdarwispariangan1@gmail.com', 7, '2025-02-26 03:40:27', 1),
(674, '::1', 'homestayowner', NULL, '2025-02-26 04:01:27', 0),
(675, '::1', 'pokdarwis.pariangan', NULL, '2025-02-26 04:01:40', 0),
(676, '::1', 'pokdarwispariangan1@gmail.com', 7, '2025-02-26 04:01:43', 1),
(677, '::1', 'homestayowner', NULL, '2025-02-26 04:02:10', 0),
(678, '::1', 'homestayowner', NULL, '2025-02-26 04:02:14', 0),
(679, '::1', 'homestayowner', NULL, '2025-02-26 04:02:18', 0),
(680, '::1', 'homestayowner@gmail.com', 29, '2025-02-26 04:02:24', 1),
(681, '::1', 'umegahomestay@gmail.com', 23, '2025-02-26 04:03:11', 1),
(682, '::1', 'umegahomestay@gmail.com', 23, '2025-02-26 04:08:20', 1),
(683, '::1', 'umegahomestay@gmail.com', 23, '2025-02-26 04:10:40', 1),
(684, '::1', 'shandyka2403@gmail.com', 11, '2025-02-26 04:17:19', 1),
(685, '::1', 'umegahomestay@gmail.com', 23, '2025-02-26 08:24:31', 1),
(686, '::1', 'umegahomestay@gmail.com', 23, '2025-02-26 08:24:38', 1),
(687, '::1', 'shandyka2403@gmail.com', 11, '2025-02-26 08:25:03', 1),
(688, '::1', 'shandyka2403@gmail.com', 11, '2025-02-26 08:33:44', 1),
(689, '::1', 'shandyka2403@gmail.com', 11, '2025-02-26 08:34:06', 1),
(690, '::1', 'shandyka2403@gmail.com', 11, '2025-02-26 08:37:13', 1),
(691, '::1', 'umegahomestay@gmail.com', 23, '2025-02-26 09:06:41', 1),
(692, '::1', 'shandyka2403@gmail.com', 11, '2025-02-26 09:07:20', 1),
(693, '::1', 'umegahomestay@gmail.com', 23, '2025-02-26 09:30:46', 1),
(694, '::1', 'pokdarwispariangan1@gmail.com', 7, '2025-02-26 11:31:46', 1),
(695, '::1', 'umegahomestay@gmail.com', 23, '2025-02-26 11:33:15', 1),
(696, '::1', 'shandyka2403@gmail.com', 11, '2025-02-26 11:34:18', 1),
(697, '::1', 'shandyka2403@gmail.com', 11, '2025-02-26 12:07:46', 1),
(698, '::1', 'asdasd@gmail.com', 30, '2025-02-26 12:15:11', 1),
(699, '::1', 'pokdarwispariangan1@gmail.com', 7, '2025-02-26 12:29:23', 1),
(700, '::1', 'homestayowner@gmail.com', 29, '2025-02-26 12:38:30', 1),
(701, '::1', 'pokdarwispariangan1@gmail.com', 7, '2025-02-26 12:39:36', 1),
(702, '::1', 'homestayowner@gmail.com', 29, '2025-02-26 12:40:11', 1),
(703, '::1', 'homestayowner@gmail.com', 29, '2025-02-26 12:40:36', 1),
(704, '::1', 'pokdarwis.pariangan', NULL, '2025-02-26 12:40:45', 0),
(705, '::1', 'pokdarwispariangan1@gmail.com', 7, '2025-02-26 12:40:48', 1),
(706, '::1', 'gudesterhomestay@gmail.com', 24, '2025-02-26 12:42:54', 1),
(707, '::1', 'nabilahomestay@gmail.com', 25, '2025-02-26 12:43:08', 1),
(708, '::1', 'homestayowner@gmail.com', 29, '2025-02-26 12:43:22', 1),
(709, '::1', 'shandyka2403@gmail.com', 11, '2025-02-26 12:47:47', 1),
(710, '::1', 'asdasd@gmail.com', 31, '2025-02-26 12:48:56', 1),
(711, '::1', 'shandyka2403@gmail.com', 11, '2025-02-26 12:49:46', 1),
(712, '::1', 'homestayowner@gmail.com', 29, '2025-02-26 12:49:59', 1),
(713, '::1', 'umegahomestay@gmail.com', 23, '2025-02-26 12:50:49', 1),
(714, '::1', 'umegahomestay@gmail.com', 23, '2025-02-26 13:01:56', 1),
(715, '::1', 'shandyka2403@gmail.com', 11, '2025-02-26 13:14:11', 1),
(716, '::1', 'dykdyk', NULL, '2025-02-26 16:09:27', 0),
(717, '::1', 'shandyka2403@gmail.com', 11, '2025-02-26 16:09:32', 1),
(718, '::1', 'pokdarwispariangan1@gmail.com', 7, '2025-02-26 16:40:32', 1),
(719, '::1', 'pokdarwispariangan1@gmail.com', 7, '2025-02-26 16:42:32', 1),
(720, '::1', 'umegahomestay@gmail.com', 23, '2025-02-27 00:50:22', 1),
(721, '::1', 'pokdarwispariangan1@gmail.com', 7, '2025-02-27 00:52:10', 1),
(722, '::1', 'umegahomestay@gmail.com', 23, '2025-02-27 01:00:01', 1),
(723, '::1', 'shandyka2403@gmail.com', 11, '2025-02-27 01:45:26', 1),
(724, '::1', 'shandyka2403@gmail.com', 11, '2025-02-27 02:00:49', 1),
(725, '::1', 'umegahomestay@gmail.com', 23, '2025-02-27 05:21:59', 1),
(726, '::1', 'dykdyk', NULL, '2025-02-27 06:01:46', 0),
(727, '::1', 'shandyka2403@gmail.com', 11, '2025-02-27 06:01:51', 1),
(728, '::1', 'shandyka2403@gmail.com', 11, '2025-02-27 06:13:47', 1),
(729, '::1', 'asdasd', NULL, '2025-02-27 06:15:37', 0),
(730, '::1', 'asdasd@gmail.com', 32, '2025-02-27 06:16:00', 1),
(731, '::1', 'pokdarwispariangan1@gmail.com', 7, '2025-02-27 06:20:22', 1),
(732, '::1', 'umegahomestay@gmail.com', 23, '2025-02-27 06:20:45', 1),
(733, '::1', 'accadmin1@email.com', 8, '2025-06-03 01:53:00', 1),
(734, '::1', 'nightbaron.369@gmail.com', NULL, '2025-06-12 02:26:25', 0),
(735, '::1', 'nightbaron.369@gmail.com', NULL, '2025-06-12 04:42:08', 0),
(736, '::1', 'nightbaron.369@gmail.com', NULL, '2025-06-17 01:20:26', 0),
(737, '::1', 'nightbaron.369@gmail.com', NULL, '2025-06-17 01:21:08', 0),
(738, '::1', 'nightbaron.369@gmail.com', NULL, '2025-06-17 01:40:00', 0),
(739, '::1', 'nightbaron.369@gmail.com', NULL, '2025-06-17 01:44:33', 0),
(740, '::1', 'nightbaron.369@gmail.com', NULL, '2025-06-17 01:46:14', 0),
(741, '::1', 'nightbaron.369@gmail.com', NULL, '2025-06-17 02:09:46', 0),
(742, '::1', 'nightbaron.369@gmail.com', NULL, '2025-06-17 02:10:10', 0),
(743, '::1', 'nightbaron.369@gmail.com', NULL, '2025-06-17 02:31:06', 0),
(744, '::1', 'nightbaron.369@gmail.com', NULL, '2025-06-17 02:32:05', 0),
(745, '::1', 'nightbaron.369@gmail.com', NULL, '2025-06-17 02:32:17', 0),
(746, '::1', 'nightbaron.369@gmail.com', NULL, '2025-06-17 02:42:34', 0),
(747, '::1', 'nightbaron.369@gmail.com', NULL, '2025-06-17 02:44:59', 0),
(748, '::1', 'nightbaron.369@gmail.com', NULL, '2025-06-17 02:45:31', 0),
(749, '::1', 'nightbaron.369@gmail.com', NULL, '2025-06-17 02:59:53', 0),
(750, '::1', 'nightbaron.369@gmail.com', NULL, '2025-06-17 03:33:38', 0),
(751, '::1', 'lukmanjunedd@gmail.com', NULL, '2025-07-03 01:00:00', 0),
(752, '::1', 'lukmanjunedd@gmail.com', NULL, '2025-07-03 01:02:30', 0),
(753, '::1', 'nightbaron.369@gmail.com', NULL, '2025-07-03 01:05:19', 0),
(754, '::1', 'nightbaron.369@gmail.com', NULL, '2025-07-03 01:33:30', 0),
(755, '::1', 'lukmanjunedd@gmail.com', NULL, '2025-07-07 01:09:17', 0),
(756, '::1', 'nightbaron.369@gmail.com', NULL, '2025-07-07 01:11:08', 0),
(757, '::1', 'nightbaron.369@gmail.com', 33, '2025-07-07 01:15:10', 1),
(758, '::1', 'nightbaron.369@gmail.com', 33, '2025-07-07 01:17:10', 1),
(759, '::1', 'lukmanjunedd@gmail.com', 34, '2025-07-07 01:18:26', 1),
(760, '::1', 'nightbaron.369@gmail.com', 33, '2025-07-07 01:20:21', 1),
(761, '::1', 'lukmanjunedd@gmail.com', 34, '2025-07-08 00:30:40', 1),
(762, '::1', 'nightbaron.369@gmail.com', 33, '2025-07-08 00:33:26', 1),
(763, '::1', 'nightbaron.369@gmail.com', 33, '2025-07-08 00:35:03', 1),
(764, '::1', 'nightbaron.369@gmail.com', 33, '2025-07-08 00:37:48', 1),
(765, '::1', 'nightbaron.369@gmail.com', 33, '2025-07-08 00:39:39', 1),
(766, '::1', 'nightbaron.369@gmail.com', 33, '2025-07-08 00:41:40', 1),
(767, '::1', 'nightbaron.369@gmail.com', 33, '2025-07-08 00:43:50', 1),
(768, '::1', 'nightbaron.369@gmail.com', 33, '2025-07-08 00:46:17', 1),
(769, '::1', 'nightbaron.369@gmail.com', 33, '2025-07-08 00:48:04', 1),
(770, '::1', 'nightbaron.369@gmail.com', 33, '2025-07-08 00:49:34', 1);
INSERT INTO `auth_logins` (`id`, `ip_address`, `email`, `user_id`, `date`, `success`) VALUES
(771, '::1', 'nightbaron.369@gmail.com', 33, '2025-07-08 00:53:11', 1),
(772, '::1', 'lukmanjunedd@gmail.com', 34, '2025-07-08 03:19:27', 1),
(773, '::1', 'nightbaron.369@gmail.com', 33, '2025-07-08 03:19:49', 1),
(774, '::1', 'daffamuyasar', NULL, '2025-07-08 03:56:41', 0),
(775, '::1', 'daffa@gmail.com', 12, '2025-07-08 03:59:46', 1),
(776, '::1', 'daffa@gmail.com', 12, '2025-07-08 04:05:43', 1),
(777, '::1', 'daffa@gmail.com', 12, '2025-07-10 10:48:11', 1),
(778, '::1', 'daffa@gmail.com', 12, '2025-07-10 10:51:25', 1),
(779, '::1', 'daffa@gmail.com', 12, '2025-07-10 10:56:44', 1),
(780, '::1', 'daffa@gmail.com', 12, '2025-07-10 10:58:39', 1),
(781, '::1', 'daffa@gmail.com', 12, '2025-07-10 11:03:28', 1),
(782, '::1', 'daffa@gmail.com', 12, '2025-07-10 11:06:45', 1),
(783, '::1', 'daffa@gmail.com', 12, '2025-07-10 11:07:16', 1),
(784, '::1', 'daffa@gmail.com', 12, '2025-07-10 11:12:27', 1),
(785, '::1', 'daffa@gmail.com', 12, '2025-07-10 14:30:42', 1),
(786, '::1', 'daffa@gmail.com', 12, '2025-07-10 14:31:39', 1),
(787, '::1', 'daffa@gmail.com', 12, '2025-07-10 14:36:31', 1),
(788, '::1', 'nightbaron.369@gmail.com', 33, '2025-07-10 14:45:29', 1),
(789, '::1', 'nightbaron.369@gmail.com', 33, '2025-07-10 14:50:38', 1),
(790, '::1', 'nightbaron.369@gmail.com', 33, '2025-07-10 15:15:32', 1),
(791, '::1', 'nightbaron.369@gmail.com', 33, '2025-07-10 15:22:54', 1),
(792, '::1', 'nightbaron.369@gmail.com', 33, '2025-07-10 15:54:17', 1),
(793, '::1', 'vonex59740@hosintoy.com', 37, '2025-07-13 01:15:27', 1),
(794, '::1', 'lukmanjunedd@gmail.com', 34, '2025-07-22 02:08:08', 1),
(795, '::1', 'lukmanjunedd@gmail.com', 34, '2025-07-22 02:08:29', 1),
(796, '::1', 'daffa@gmail.com', 12, '2025-07-22 02:09:55', 1),
(797, '::1', 'adadada', NULL, '2025-07-22 02:10:40', 0),
(798, '::1', 'adadada', NULL, '2025-07-22 02:10:45', 0),
(799, '::1', 'adadada', 37, '2025-07-22 02:10:51', 0),
(800, '::1', 'vonex59740@hosintoy.com', 37, '2025-07-22 02:11:09', 1),
(801, '::1', 'vonex59740@hosintoy.com', 37, '2025-07-22 02:11:13', 1),
(802, '::1', 'lukmanjunedd@gmail.com', 34, '2025-07-22 02:15:59', 1),
(803, '::1', 'nightbaron.369@gmail.com', 39, '2025-07-22 02:18:53', 1),
(804, '::1', 'nightbaron.369@gmail.com', 39, '2025-07-22 02:19:58', 1),
(805, '::1', 'nightbaron.369@gmail.com', 41, '2025-07-22 02:30:23', 1),
(806, '::1', 'nightbaron.369@gmail.com', 41, '2025-07-22 02:32:10', 1),
(807, '::1', 'lukmanjunedd@gmail.com', 42, '2025-07-22 02:35:20', 1),
(808, '::1', 'djlukman39@gmail.com', 43, '2025-07-22 02:37:10', 1),
(809, '::1', 'nightbaron.369@gmail.com', 41, '2025-07-22 02:37:26', 1),
(810, '::1', 'nightbaron.369@gmail.com', 44, '2025-07-22 05:08:14', 1),
(811, '::1', 'lukmanjunedd@gmail.com', 45, '2025-07-22 05:13:14', 1),
(812, '::1', 'nightbaron.369@gmail.com', 46, '2025-07-26 01:02:44', 1),
(813, '::1', 'lukmanjunedd@gmail.com', 47, '2025-07-26 01:03:12', 1),
(814, '::1', 'nightbaron.369@gmail.com', 48, '2025-07-26 01:33:27', 1),
(815, '::1', 'nightbaron.369@gmail.com', 48, '2025-07-26 01:48:13', 1),
(816, '::1', 'lukmanjunedd@gmail.com', 49, '2025-07-26 01:48:41', 1),
(817, '::1', 'nightbaron.369@gmail.com', 48, '2025-07-26 01:57:36', 1),
(818, '::1', 'lukmanjunedd@gmail.com', 49, '2025-07-26 01:57:51', 1),
(819, '::1', 'nightbaron.369@gmail.com', 48, '2025-07-26 01:58:37', 1),
(820, '::1', 'lukmanjunedd@gmail.com', 49, '2025-07-26 01:59:33', 1),
(821, '::1', 'nightbaron.369@gmail.com', 48, '2025-07-26 02:24:56', 1),
(822, '::1', 'lukmanjunedd@gmail.com', 49, '2025-07-26 02:25:36', 1),
(823, '::1', 'lukmanjunedd@gmail.com', 49, '2025-07-29 00:40:16', 1),
(824, '::1', 'nightbaron.369@gmail.com', 48, '2025-11-23 00:09:33', 1);

-- --------------------------------------------------------

--
-- Table structure for table `auth_permissions`
--

CREATE TABLE `auth_permissions` (
  `id` int UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `auth_reset_attempts`
--

CREATE TABLE `auth_reset_attempts` (
  `id` int UNSIGNED NOT NULL,
  `email` varchar(255) NOT NULL,
  `ip_address` varchar(255) NOT NULL,
  `user_agent` varchar(255) NOT NULL,
  `token` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `auth_tokens`
--

CREATE TABLE `auth_tokens` (
  `id` int UNSIGNED NOT NULL,
  `selector` varchar(255) NOT NULL,
  `hashedValidator` varchar(255) NOT NULL,
  `user_id` int UNSIGNED NOT NULL,
  `expires` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `auth_users_permissions`
--

CREATE TABLE `auth_users_permissions` (
  `user_id` int UNSIGNED NOT NULL DEFAULT '0',
  `permission_id` int UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `city`
--

CREATE TABLE `city` (
  `id` varchar(3) NOT NULL,
  `name` varchar(35) NOT NULL,
  `geom` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `city`
--

INSERT INTO `city` (`id`, `name`, `geom`) VALUES
('C01', 'Agam Regency', 'C01.geojson'),
('C02', 'Dharmasraya Regency', 'C02.geojson'),
('C03', 'Kepulauan Mentawai Regency', 'C03.geojson'),
('C04', 'Lima Puluh Kota Regency', 'C04.geojson'),
('C05', 'Padang Pariaman Regency', 'C05.geojson'),
('C06', 'Pasaman Regency', 'C06.geojson'),
('C07', 'Pasaman Barat Regency', 'C07.geojson'),
('C08', 'Pesisir Selatan Regency', 'C08.geojson'),
('C09', 'Sijunjung Regency', 'C09.geojson'),
('C10', 'Solok Regency', 'C10.geojson'),
('C11', 'Solok Selatan Regency', 'C11.geojson'),
('C12', 'Tanah Datar Regency', 'C12.geojson'),
('C13', 'Bukittinggi City', 'C13.geojson'),
('C14', 'Padang City', 'C14.geojson'),
('C15', 'Padang Panjang City', 'C15.geojson'),
('C16', 'Pariaman City', 'C16.geojson'),
('C17', 'Payakumbuh City', 'C17.geojson'),
('C18', 'Sawahlunto City', 'C18.geojson'),
('C19', 'Solok City', 'C19.geojson');

-- --------------------------------------------------------

--
-- Table structure for table `country`
--

CREATE TABLE `country` (
  `id` varchar(3) NOT NULL,
  `name` varchar(25) NOT NULL,
  `geom` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `country`
--

INSERT INTO `country` (`id`, `name`, `geom`) VALUES
('N01', 'Singapura', 'N01.geojson'),
('N02', 'Malaysia', 'N02.geojson'),
('N03', 'Indonesia', 'N03.geojson'),
('N04', 'Brunei Darussalam', 'N04.geojson');

-- --------------------------------------------------------

--
-- Table structure for table `culinary_place`
--

CREATE TABLE `culinary_place` (
  `id` varchar(3) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `village_id` varchar(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `name` varchar(50) NOT NULL,
  `address` varchar(100) DEFAULT NULL,
  `employee_name` varchar(25) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `phone` varchar(13) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `open` time DEFAULT NULL,
  `close` time DEFAULT NULL,
  `geom` geometry DEFAULT NULL,
  `lat` decimal(10,8) NOT NULL,
  `lng` decimal(11,8) NOT NULL,
  `description` text,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `culinary_place`
--

INSERT INTO `culinary_place` (`id`, `village_id`, `name`, `address`, `employee_name`, `phone`, `open`, `close`, `geom`, `lat`, `lng`, `description`, `created_at`, `updated_at`) VALUES
('C1', '1', 'Kawa Daun Tanjuang Indah', 'Pariangan, Kec. Pariangan, Kabupaten Tanah Datar, Sumatera Barat ', 'Putra', '082284978004', '09:00:00', '22:00:00', 0xe61000000103000000010000000600000042504c54fe1e5940c34e13d80286dcbf4350ac7bfe1e5940300ea234bf87dcbf44504c35ff1e59409e3268715f89dcbf43506ce6001f59408f995252e988dcbf42500c38001f5940fc6eaf18b485dcbf42504c54fe1e5940c34e13d80286dcbf, -0.44577259, 100.48435148, 'Kawa Daun Tanjung Indah is a charming traditional café offering a wide variety of food and beverages. Strategically located, this café provides breathtaking views, making it an ideal spot to relax and enjoy the scenery.', '2024-10-25 04:34:18', '2025-01-10 01:15:57'),
('C11', NULL, 'Bintang Fajar', 'Tarantang Village, Harau Subdistrict, Lima Puluh Kota Regency, West Sumatra Province', 'Dewi', '081261884909', '12:00:00', '18:00:00', 0xe6100000010300000001000000050000007db664a6a52a5940be47b3767bc2babf7cb6446ba62a5940440584962cc4babf7cb604e7a62a59400446e196d5c0babf7cb64411a62a5940bc680d9740bfbabf7db664a6a52a5940be47b3767bc2babf, -0.10451833, 100.66639869, 'Bintang Fajar adalah tempat kuliner yang menghadirkan keajaiban rasa melalui kreasinya, yaitu Rakik Kacang. Ini bukan sekadar camilan, melainkan sebuah seni kuliner yang meramu kacang pilihan menjadi gurih dan renyah dengan sentuhan rahasia yang memikat lidah.', '2023-12-01 18:13:25', '2023-12-03 09:13:39'),
('C12', NULL, 'Warung Yuniar', 'Tarantang Village, Harau Subdistrict, Lima Puluh Kota Regency, West Sumatra Province', 'Yuniar', '082267248766', '10:00:00', '18:00:00', 0xe610000001030000000100000005000000b161818ea12a59404a3a82f9e2e9b9bfb161410aa22a5940320dbef999e7b9bfb16141fca02a5940d568fef923e5b9bfb261c18ba02a5940f6d7b4f9f3e7b9bfb161818ea12a59404a3a82f9e2e9b9bf, -0.10118887, 100.66609454, NULL, '2023-12-01 18:29:02', '2023-12-01 18:29:02'),
('C13', NULL, 'Bhumi Harau Cafe & Resto', 'Tarantang Village, Harau Subdistrict, Lima Puluh Kota Regency, West Sumatra Province', NULL, NULL, '19:00:00', '23:00:00', 0xe610000001030000000100000005000000b5d63fc46b2a5940c989df167062bebfb6d67f916d2a5940de7f05176261bebfb6d69fda6d2a594016eb3a160267bebfb6d67ffc6b2a5940ce131896f967bebfb5d63fc46b2a5940c989df167062bebf, -0.11872374, 100.66289125, NULL, '2023-12-02 05:33:23', '2023-12-02 06:14:54'),
('C14', NULL, 'Nasi Kapau Josi', 'Tarantang Village, Harau Subdistrict, Lima Puluh Kota Regency, West Sumatra Province', NULL, NULL, '10:00:00', '21:00:00', 0xe61000000103000000010000000500000015f95d376b2a594030b78ee9ac46bebf15f91d676c2a59408bd8a7e9f845bebf15f93db06c2a5940e922e868554bbebf15f91d866b2a5940351abc68904cbebf15f95d376b2a594030b78ee9ac46bebf, -0.11830548, 100.66283889, NULL, '2023-12-02 06:18:41', '2023-12-02 06:18:41'),
('C15', NULL, 'Leven Coffe & Eatery', 'Tarantang Village, Harau Subdistrict, Lima Puluh Kota Regency, West Sumatra Province', NULL, NULL, '14:00:00', '22:00:00', 0xe6100000010300000001000000050000003759b3a5a12a594009b92ecdc5d2babf3759f364a22a5940f2d8aecd33cebabf37593335a12a5940f29dfdcd63cbbabf3659738ca02a594020aa78cd22d0babf3759b3a5a12a594009b92ecdc5d2babf, -0.10472231, 100.66610544, NULL, '2023-12-02 06:22:18', '2023-12-02 06:22:18'),
('C16', NULL, 'Kedai 4s', 'Tarantang Village, Harau Subdistrict, Lima Puluh Kota Regency, West Sumatra Province', NULL, NULL, '10:00:00', '18:00:00', 0xe610000001030000000100000005000000c4ace737382b5940da31c6ae33e5bbbfc4aca767392b5940458acbae06e5bbbfc4aca767392b5940d62826af09e2bbbfc3ac6721382b5940d62826af09e2bbbfc4ace737382b5940da31c6ae33e5bbbf, -0.10894195, 100.67533983, NULL, '2023-12-02 06:25:11', '2023-12-02 06:25:11'),
('C17', NULL, 'Kedai Nasi Keyla', 'Tarantang Village, Harau Subdistrict, Lima Puluh Kota Regency, West Sumatra Province', NULL, NULL, '10:00:00', '18:00:00', 0xe6100000010300000001000000050000007b3079a33d2b5940315af9817cedbbbf7c30f9213f2b59406f630982f5ecbbbf7b30b9e93e2b594072f4ae8282e7bbbf7b30b9813d2b59405df29e8209e8bbbf7b3079a33d2b5940315af9817cedbbbf, -0.10904691, 100.67567869, NULL, '2023-12-02 06:27:05', '2023-12-02 06:27:05'),
('C18', NULL, 'Warung Kawa Daun Sarasah Aie Luluih', 'Tarantang Village, Harau Subdistrict, Lima Puluh Kota Regency, West Sumatra Province', NULL, NULL, '10:00:00', '18:00:00', 0xe610000001030000000100000005000000af50f425382b594056f4ed7a2dc0bbbfaf50b428392b59401ab9c37a95c1bbbfaf5034e5382b59403cea697a92c4bbbfaf50f4cb372b59401de68e7a57c3bbbfaf50f425382b594056f4ed7a2dc0bbbf, -0.10843468, 100.67532213, NULL, '2023-12-02 06:30:53', '2023-12-02 06:30:53'),
('C19', NULL, 'Warung Iyef', 'Tarantang Village, Harau Subdistrict, Lima Puluh Kota Regency, West Sumatra Province', NULL, NULL, '10:00:00', '18:00:00', 0xe610000001030000000100000006000000e14399013a2b59402e0da94318c6bbbfe14399013a2b5940984d644361c8bbbfe043d9ed3a2b5940af97694334c8bbbfe043d9ed3a2b594050fcb0c3d4c5bbbfe14399013a2b59402e0da94318c6bbbfe14399013a2b59402e0da94318c6bbbf, -0.10850686, 100.67544358, NULL, '2023-12-02 07:32:48', '2023-12-02 07:33:08'),
('C2', '1', 'Kawa Daun  Tanjuang Putuih', 'Pariangan, Kec. Pariangan, Kabupaten Tanah Datar, Sumatera Barat ', 'Nasrudin', '081272053141', '09:00:00', '20:00:00', 0xe610000001030000000100000005000000e326fb26001f59402b10e9e49f85dcbfe2267bf1001f5940bd9e5f9eeb88dcbfe2261b32021f5940fb07073f9788dcbfe2263bd5021f5940d1c39026ca84dcbfe326fb26001f59402b10e9e49f85dcbf, -0.44573090, 100.48446610, 'Kawa Daun Tanjuang Putuih is a traditional café that offers a wide selection of food and beverages. Conveniently located, this café boasts stunning views, making it a perfect destination for relaxation and enjoyment.', '2024-10-25 04:38:34', '2025-01-10 01:16:29'),
('C20', NULL, 'Nasi Ampera & Sate Zal', 'Tarantang Village, Harau Subdistrict, Lima Puluh Kota Regency, West Sumatra Province', NULL, NULL, '10:00:00', '18:00:00', 0xe610000001030000000100000006000000848dd8cb402b5940ae0049b0abdfbbbf848dd8cb402b59409a1be9afd5e2bbbf858d58c3412b59406e70eeafa8e2bbbf848d18b8412b5940985a3eb005e0bbbf848dd8cb402b594063ae3b301ce0bbbf848dd8cb402b5940ae0049b0abdfbbbf, -0.10890583, 100.67585935, NULL, '2023-12-02 07:36:44', '2023-12-03 09:15:09'),
('C21', NULL, 'Sarapan Pagi M.Upik', 'Tarantang Village, Harau Subdistrict, Lima Puluh Kota Regency, West Sumatra Province', NULL, NULL, '07:00:00', '18:00:00', 0xe61000000103000000010000000500000098ad45d8412b594047997c5ff4debbbf98ad45d8412b59405ebefc5e2ce3bbbf97adc5a2422b59403413025fffe2bbbf97ad8597422b594047997c5ff4debbbf98ad45d8412b594047997c5ff4debbbf, -0.10890295, 100.67591799, NULL, '2023-12-02 08:04:36', '2023-12-03 09:15:48'),
('C22', NULL, 'Warung Uni Nita', 'Tarantang Village, Harau Subdistrict, Lima Puluh Kota Regency, West Sumatra Province', NULL, NULL, '10:00:00', '18:00:00', 0xe610000001030000000100000005000000d934ff0b442b5940a5d7d09a4fe8bbbfda347f30452b5940b8d9e09ac8e7bbbfda34bf68452b59402cc4f59984efbbbfd9343f44442b5940c26bf099b1efbbbfd934ff0b442b5940a5d7d09a4fe8bbbf, -0.10906584, 100.67606983, NULL, '2023-12-02 08:06:30', '2023-12-03 09:16:40'),
('C23', NULL, 'Kini Cheese Tea Sarbun', 'Tarantang Village, Harau Subdistrict, Lima Puluh Kota Regency, West Sumatra Province', NULL, NULL, '14:00:00', '20:00:00', 0xe61000000103000000010000000500000069e2adbb472b5940084496d790dfbbbf68e22dd2472b5940f25e36d7bae2bbbf68e22de0482b59409d0841d760e2bbbf67e26dbe482b59404936b6d782debbbf69e2adbb472b5940084496d790dfbbbf, -0.10889619, 100.67628811, NULL, '2023-12-02 08:08:34', '2023-12-03 09:17:36'),
('C24', NULL, 'Yorafa Food & Drink', 'Tarantang Village, Harau Subdistrict, Lima Puluh Kota Regency, West Sumatra Province', NULL, NULL, '10:00:00', '18:00:00', 0xe61000000103000000010000000500000067c15490442b5940274639d3a8f5bbbf66c1d4e1452b59408e5649d321f5bbbf67c114ed452b594069c89dd2c1fabbbf67c114df442b5940d60c93d21bfbbbbf67c15490442b5940274639d3a8f5bbbf, -0.10925477, 100.67610138, NULL, '2023-12-02 08:10:00', '2023-12-02 08:10:00'),
('C3', '1', 'Kawa Daun A & F', 'Pariangan, Kec. Pariangan, Kabupaten Tanah Datar, Sumatera Barat ', 'Masril', NULL, '10:00:00', '18:00:00', 0xe61000000103000000010000000900000022318b27041f59401db8000c1f85dcbf20318b46031f5940f1b5218b8f85dcbf21316bd0021f5940cf88a6c94e86dcbf21316bd0021f5940a4f083676287dcbf2131eb6d031f594033f98184e688dcbf2131eb2f051f59406d19d024bf88dcbf21312b0e051f59406c3aff28a386dcbf21312b87041f59402877596b7385dcbf22318b27041f59401db8000c1f85dcbf, -0.44574041, 100.48461918, 'Kawa Daun A & F is a traditional café offering a variety of food and beverages. The café also features an ampera dining area and showcases breathtaking views, making it an inviting spot for guests.', '2024-10-25 05:39:16', '2025-01-10 01:17:14'),
('C4', '1', 'Kawa Daun Puncak Mortir', 'Pariangan, Kec. Pariangan, Kabupaten Tanah Datar, Sumatera Barat ', 'Hesti', NULL, '10:00:00', '20:00:00', 0xe610000001030000000100000006000000824285b9011f5940346f4dad1081dcbf8142c52c031f594014ae4def0d80dcbf81426540041f5940a14221b1217fdcbf81424505051f5940db9e9b8fe67fdcbf8142a5e3021f5940b23a204aab82dcbf824285b9011f5940346f4dad1081dcbf, -0.44536745, 100.48458085, 'Kawa Daun Puncak Mortir is a traditional café that offers stunning views. The café serves a variety of food and beverages, making it a delightful place to unwind and enjoy the scenery.', '2024-10-25 05:51:32', '2025-01-10 01:17:45'),
('C5', '1', 'Puncak Kawa Gudester', 'Pariangan, Kec. Pariangan, Kabupaten Tanah Datar, Sumatera Barat ', 'Hana', '082283529664', '09:00:00', '20:00:00', 0xe6100000010300000001000000070000005d90c88b101f5940181d2855f496dcbf5e9068830f1f59405754f2af9199dcbf5e902867111f5940ca16d60c219bdcbf5d90886f121f594057ec3eafeb99dcbf5d90c8a7121f5940abc6bfb22998dcbf5d90e83c121f59407e5fdb559a96dcbf5d90c88b101f5940181d2855f496dcbf, -0.44683020, 100.48541775, 'Puncak Kawa Gudester is a traditional café offering a wide range of food and beverages. It also features breathtaking views, making it a perfect spot to relax and enjoy nature\'s beauty.', '2024-10-25 06:11:07', '2025-01-10 01:18:12'),
('C6', '1', 'Sako Minang Cafe', 'Pariangan, Kec. Pariangan, Kabupaten Tanah Datar, Sumatera Barat ', 'Zainul', '082122886454', '09:00:00', '18:00:00', 0xe61000000103000000010000000700000062582f14001f594036000374836cdcbf0086115f011f5940be25be27da6bdcbf008611e6011f5940417cad4bda69dcbfff85714b001f5940fefbb38e5068dcbfff859178fe1e594083abcbadc668dcbf0086119dff1e59402738c987d46bdcbf62582f14001f594036000374836cdcbf, -0.44399500, 100.48438628, 'Cafe ini menyediakan berbagai macam makanan dan minuman. Lokasi dari cafe ini diapit oleh pepohonan yang rimbun dan menyuguhi pemandangan yang indah.', '2024-10-25 06:16:41', '2024-10-25 06:16:41');

-- --------------------------------------------------------

--
-- Table structure for table `culinary_place_facility`
--

CREATE TABLE `culinary_place_facility` (
  `id` varchar(2) NOT NULL,
  `name` varchar(25) NOT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `culinary_place_facility`
--

INSERT INTO `culinary_place_facility` (`id`, `name`, `created_at`, `updated_at`) VALUES
('01', 'Parking Area', '2025-01-03 21:03:46', '2025-01-03 21:03:46'),
('02', 'Toilet', '2025-01-03 22:04:02', '2025-01-03 22:04:02'),
('03', 'Mushalla', '2025-01-03 22:28:39', '2025-01-03 22:28:39');

-- --------------------------------------------------------

--
-- Table structure for table `culinary_place_facility_detail`
--

CREATE TABLE `culinary_place_facility_detail` (
  `culinary_place_id` varchar(2) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `culinary_place_facility_id` varchar(2) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `culinary_place_facility_detail`
--

INSERT INTO `culinary_place_facility_detail` (`culinary_place_id`, `culinary_place_facility_id`) VALUES
('C1', '01'),
('C2', '01'),
('C3', '01'),
('C4', '01'),
('C5', '01'),
('C1', '02'),
('C2', '02'),
('C3', '02'),
('C4', '02'),
('C5', '02'),
('C1', '03'),
('C2', '03'),
('C3', '03'),
('C4', '03'),
('C5', '03');

-- --------------------------------------------------------

--
-- Table structure for table `culinary_place_gallery`
--

CREATE TABLE `culinary_place_gallery` (
  `id` varchar(3) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `culinary_place_id` varchar(3) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `url` text,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `culinary_place_gallery`
--

INSERT INTO `culinary_place_gallery` (`id`, `culinary_place_id`, `url`, `created_at`, `updated_at`) VALUES
('013', 'C6', '1729880115_bcebc18c9c5b742cc42f.jpg', '2024-10-25 06:16:41', '2024-10-25 06:16:41'),
('014', 'C6', '1729880107_871a7281a4a1d176bf16.jpg', '2024-10-25 06:16:41', '2024-10-25 06:16:41'),
('029', 'C1', '1736518521_118d7bd6d8dd99e3590d.jpg', '2025-01-10 01:15:57', '2025-01-10 01:15:57'),
('030', 'C1', '1736518521_166e697f9b3d239b18ea.jpg', '2025-01-10 01:15:57', '2025-01-10 01:15:57'),
('031', 'C2', '1736518572_a3a0ad100204e1b33cfa.jpg', '2025-01-10 01:16:29', '2025-01-10 01:16:29'),
('032', 'C2', '1736518572_ff2a7420181606d07117.jpg', '2025-01-10 01:16:29', '2025-01-10 01:16:29'),
('033', 'C3', '1736518598_53297d5f59c7948ad905.jpg', '2025-01-10 01:17:14', '2025-01-10 01:17:14'),
('034', 'C3', '1736518598_8bcb7efbfb17e7ad4196.jpg', '2025-01-10 01:17:14', '2025-01-10 01:17:14'),
('035', 'C4', '1736518648_c9884e8e4f259ee67876.jpg', '2025-01-10 01:17:45', '2025-01-10 01:17:45'),
('036', 'C4', '1736518648_fd4f369595d3ecb29cdc.jpg', '2025-01-10 01:17:45', '2025-01-10 01:17:45'),
('037', 'C5', '1736518675_4588aa1167012bee595d.jpg', '2025-01-10 01:18:12', '2025-01-10 01:18:12'),
('038', 'C5', '1736518675_4827bdca2875e31a172a.jpg', '2025-01-10 01:18:12', '2025-01-10 01:18:12');

-- --------------------------------------------------------

--
-- Table structure for table `culinary_product`
--

CREATE TABLE `culinary_product` (
  `id` varchar(2) NOT NULL,
  `name` varchar(50) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `culinary_product`
--

INSERT INTO `culinary_product` (`id`, `name`, `created_at`, `updated_at`) VALUES
('01', 'Kawa Daun', '2024-10-25 20:24:26', '2024-10-25 20:24:26'),
('02', 'Nasi Goreng', '2024-10-25 20:24:34', '2024-10-25 20:24:34'),
('03', 'Mie Goreng', '2024-10-25 20:24:41', '2024-10-25 20:24:41'),
('04', 'Mie Rebus', '2024-10-25 20:24:47', '2024-10-25 20:25:46'),
('05', 'Mienas', '2024-10-25 20:24:53', '2024-10-25 20:24:53'),
('06', 'Kopi Hitam', '2024-10-25 20:25:00', '2024-10-25 20:25:00'),
('07', 'Gorengan', '2024-10-25 20:25:07', '2024-10-25 20:25:07'),
('08', 'Jus', '2024-10-25 20:25:12', '2024-10-25 20:25:12'),
('09', 'Teh Es', '2024-10-25 20:25:39', '2024-10-25 20:25:39'),
('10', 'Teh Hangat', '2024-10-25 20:25:53', '2024-10-25 20:25:58'),
('11', 'Cappucino', '2024-10-25 20:26:04', '2024-10-25 20:26:04'),
('12', 'Pop Mie', '2024-10-25 20:26:18', '2024-10-25 20:26:18'),
('13', 'Kopi Susu', '2025-01-11 04:16:10', '2025-01-11 04:16:10'),
('14', 'Kawa Daun Susu', '2025-01-11 04:16:20', '2025-01-11 04:16:20');

-- --------------------------------------------------------

--
-- Table structure for table `culinary_product_detail`
--

CREATE TABLE `culinary_product_detail` (
  `culinary_place_id` varchar(3) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `culinary_product_id` varchar(2) NOT NULL,
  `price` int UNSIGNED NOT NULL,
  `image_url` text,
  `description` text,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `culinary_product_detail`
--

INSERT INTO `culinary_product_detail` (`culinary_place_id`, `culinary_product_id`, `price`, `image_url`, `description`, `created_at`, `updated_at`) VALUES
('C1', '01', 7000, '1729931538_13fb5a9f880781ca59e9.webp', 'Minuman khas minang yang terbuat dari daun kopi', '2024-10-25 20:32:34', '2024-10-25 20:32:34'),
('C1', '02', 15000, '1729931626_9d941b2a491f24c460b3.jpg', 'Nasi goreng dengan telur\r\n', '2024-10-25 20:33:13', '2024-10-25 20:33:49'),
('C1', '03', 15000, '1729931608_f9d768cb5a469b73f149.jpeg', 'Mie goreng dengan sayuran dan telur\r\n', '2024-10-25 20:33:38', '2024-10-25 20:33:38'),
('C1', '04', 15000, '1729931718_9ecabc7ce38cdd9fdd76.webp', 'Mie rebus dengan sayuran dan telur', '2024-10-25 20:35:20', '2024-10-25 20:35:20'),
('C1', '05', 15000, '1729931735_d70317cae68d45ca4294.jpg', 'Percampuran antara nasi goreng dan mie goreng dan diberikan telur\r\n', '2024-10-25 20:35:52', '2024-10-25 20:35:52'),
('C1', '06', 5000, '1729931766_94d896c52956db5aaad3.jpg', 'Kopi hitam asli pariangan\r\n', '2024-10-25 20:36:17', '2024-10-25 20:36:17'),
('C1', '07', 1500, '1729931791_697674f518b52a2163e8.jpg', 'Berbagai macam gorengan\r\n', '2024-10-25 20:36:39', '2024-10-25 20:36:39'),
('C1', '08', 12000, '1729931813_1b38704500d350baa03e.jpg', 'Aneka macam jus buah', '2024-10-25 20:36:59', '2024-10-25 20:36:59'),
('C1', '09', 7000, '1729931831_1254a68a5065b3f61722.jpg', 'Kesegaran teh dipadukan dengan es batu\r\n', '2024-10-25 20:37:27', '2024-10-25 20:37:27'),
('C1', '10', 5000, '1729931857_0bc0788503a16a54c1e0.jpeg', 'Teh hangat memerikan kehangatan di cuaca yang sejuk seperti di pariangan', '2024-10-25 20:38:05', '2024-10-25 20:38:05'),
('C1', '11', 10000, '1729931900_504b51f5398bd9643b40.jpg', 'Cappucino ', '2024-10-25 20:38:37', '2024-10-25 20:38:37'),
('C1', '12', 10000, '1729931929_83dec133a260492bbc09.jpg', 'Pop Mie dan Mie Sedap Cup\r\n', '2024-10-25 20:39:08', '2024-10-25 20:39:08'),
('C2', '01', 5000, '1736615992_deac373ba9cdae5c723d.webp', 'Kawa Daun', '2025-01-11 04:19:59', '2025-01-11 04:19:59'),
('C3', '01', 5000, '1736616052_d0579a4b0b6e58db4da8.webp', 'Kawa Daun', '2025-01-11 04:21:01', '2025-01-11 04:21:01'),
('C4', '01', 5000, '1736616077_2093d9ab503a056850c1.webp', 'Kawa Daun\r\n', '2025-01-11 04:21:21', '2025-01-11 04:21:21'),
('C5', '01', 5000, '1736616100_f85e7158c5f5862dbf64.webp', 'Kawa Daun', '2025-01-11 04:21:43', '2025-01-11 04:21:43'),
('C6', '01', 5000, '1736616118_b64dcc8f3aebf90b48e2.webp', 'Kawa Daun', '2025-01-11 04:22:05', '2025-01-11 04:22:05');

-- --------------------------------------------------------

--
-- Table structure for table `homestay`
--

CREATE TABLE `homestay` (
  `id` varchar(3) NOT NULL,
  `village_id` varchar(3) DEFAULT NULL,
  `name` varchar(100) NOT NULL,
  `category` varchar(1) NOT NULL DEFAULT '1',
  `address` varchar(100) NOT NULL,
  `geom` geometry DEFAULT NULL,
  `lat` decimal(10,8) NOT NULL,
  `lng` decimal(11,8) NOT NULL,
  `owner` int UNSIGNED NOT NULL,
  `open` time DEFAULT NULL,
  `close` time DEFAULT NULL,
  `max_people_for_event` int NOT NULL,
  `description` text,
  `video_url` text,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `profil_link` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `homestay`
--

INSERT INTO `homestay` (`id`, `village_id`, `name`, `category`, `address`, `geom`, `lat`, `lng`, `owner`, `open`, `close`, `max_people_for_event`, `description`, `video_url`, `created_at`, `updated_at`, `profil_link`) VALUES
('H01', '1', 'Homestay Harau Syafiq', '2', 'Tarantang Village, Harau Subdistrict, Lima Puluh Kota Regency, West Sumatra Province', 0xe6100000010300000001000000090000005a4b0163b62a5940655a3f7f85dbbcbf594b4149bd2a59403e620c7ca8f4bcbf594bc11ec22a5940d697c6796906bdbf594b4173c02a59405a28cbf80e0ebdbf584b81cabf2a594040dd65782211bdbf594ba146ba2a594085b2737a2301bdbf4a390f21b32a594040c41cc5abe5bcbf4b398f48b12a5940b949544617dcbcbf5a4b0163b62a5940655a3f7f85dbbcbf, -0.11313367, 100.66758434, 9, '10:00:00', '18:00:00', 50, 'Homestay Harau Syafiq adalah sebuah penginapan yang nyaman dan bersahaja yang terletak di Lembah Harau, sebuah destinasi alam yang indah di Sumatera Barat, Indonesia. Penginapan ini menawarkan pengalaman menginap yang autentik dan dekat dengan alam, dengan pemandangan yang memukau dari tebing batu yang mengelilingi lembah.', NULL, '2024-02-26 05:22:25', '2024-02-26 05:22:25', ''),
('H02', '1', 'Homestay Aura', '2', 'Tarantang Village, Harau Subdistrict, Lima Puluh Kota Regency, West Sumatra Province', 0xe610000001030000000100000005000000a11a276c9c2a59402e8eeb5bbdf5babf1f8afa0b9a2a59405ae8b59fadffbabf74515f5c8b2a594000fb2af16715bbbf74515f5c8b2a5940b1fb2bb7f636bbbfa11a276c9c2a59402e8eeb5bbdf5babf, -0.10531219, 100.66579727, 13, '10:00:00', '18:00:00', 50, 'Homestay Aura adalah sebuah penginapan yang nyaman dan bersahaja yang terletak di Lembah Harau, sebuah destinasi alam yang indah di Sumatera Barat, Indonesia. Penginapan ini menawarkan pengalaman menginap yang autentik dan dekat dengan alam, dengan pemandangan yang memukau dari tebing batu yang mengelilingi lembah.', NULL, '2024-02-26 05:59:05', '2024-02-26 07:05:06', ''),
('H03', '1', 'Meliya Homestay', '2', 'Tarantang Village, Harau Subdistrict, Lima Puluh Kota Regency, West Sumatra Province', 0xe610000001030000000100000007000000e68ee5fa8a2a594095ac92e1db68bbbff74920eb8a2a594040ca5f8c0e69bbbf428922e68a2a5940e83f1836d26bbbbfd13fc1c58a2a594030383932456fbbbf131f2b3a8a2a59400b9e0092026ebbbf3c42b4f3892a5940e8e6b0353a6bbbbfe68ee5fa8a2a594095ac92e1db68bbbf, -0.10706877, 100.66473267, 14, '10:00:00', '18:00:00', 50, 'Meliya Homestay adalah sebuah penginapan yang nyaman dan bersahaja yang terletak di Lembah Harau, sebuah destinasi alam yang indah di Sumatera Barat, Indonesia. Penginapan ini menawarkan pengalaman menginap yang autentik dan dekat dengan alam, dengan pemandangan yang memukau dari tebing batu yang mengelilingi lembah.', NULL, '2024-02-26 08:58:36', '2024-02-26 08:58:36', ''),
('H04', '1', 'Abyan Homestay', '2', 'Tarantang Village, Harau Subdistrict, Lima Puluh Kota Regency, West Sumatra Province', 0xe610000001030000000100000007000000e2101e2b802a5940ffe1b6cf8d5dbcbfcf394fa7822a5940fe4bad52d55fbcbf34d5f623832a59401c4552e2a561bcbf81545072832a5940bf1e7ec4d066bcbf82889a09822a59403cb7d806516bbcbf417d0db9802a5940e542277c9d71bcbfe2101e2b802a5940ffe1b6cf8d5dbcbf, -0.11080252, 100.66407278, 15, '10:00:00', '18:00:00', 50, 'Abyan Homestay adalah sebuah penginapan yang nyaman dan bersahaja yang terletak di Lembah Harau, sebuah destinasi alam yang indah di Sumatera Barat, Indonesia. Penginapan ini menawarkan pengalaman menginap yang autentik dan dekat dengan alam, dengan pemandangan yang memukau dari tebing batu yang mengelilingi lembah.', NULL, '2024-02-26 09:04:25', '2024-02-26 09:06:12', ''),
('H05', '1', 'Homestay Bilza', '2', 'Tarantang Village, Harau Subdistrict, Lima Puluh Kota Regency, West Sumatra Province', 0xe61000000103000000010000000c0000009eeca862912a59405ad3ddf1fd3fbdbfea584a3b9a2a594012aacc7b393fbdbf2d36f7a19c2a59402d8c5f3e7a3fbdbf4aac73a99d2a59409a842416a542bdbf2008f3cb9e2a59404d4233993b44bdbf251eb360a02a59405e82b6490347bdbf771f1539a32a5940e01ed7c8a643bdbf5d40bb85a62a59404b08b18e3e41bdbfa2889854a52a594032c92b84933cbdbfe87ed279a22a5940e8d5e707013bbdbfa075095e9f2a5940774044302f3cbdbf9eeca862912a59405ad3ddf1fd3fbdbf, -0.11425769, 100.66512362, 16, '10:00:00', '18:00:00', 50, 'Homestay Bilza adalah sebuah penginapan yang nyaman dan bersahaja yang terletak di Lembah Harau, sebuah destinasi alam yang indah di Sumatera Barat, Indonesia. Penginapan ini menawarkan pengalaman menginap yang autentik dan dekat dengan alam, dengan pemandangan yang memukau dari tebing batu yang mengelilingi lembah.', NULL, '2024-02-26 09:12:45', '2024-02-26 09:12:45', ''),
('H06', '1', 'Homestay IBU', '2', 'Tarantang Village, Harau Subdistrict, Lima Puluh Kota Regency, West Sumatra Province', 0xe61000000103000000010000000500000052a9a7c96b2a594094d385f5d256bebf633c73a46d2a59401619fc819b5abebf351191f56f2a5940e5e1904fc05dbebfab5d55ee6c2a594078f3af404f5ebebf52a9a7c96b2a594094d385f5d256bebf, -0.11851233, 100.66282884, 17, '10:00:00', '18:00:00', 50, 'Homestay IBU adalah sebuah penginapan yang nyaman dan bersahaja yang terletak di Lembah Harau, sebuah destinasi alam yang indah di Sumatera Barat, Indonesia. Penginapan ini menawarkan pengalaman menginap yang autentik dan dekat dengan alam, dengan pemandangan yang memukau dari tebing batu yang mengelilingi lembah.', NULL, '2024-02-26 09:24:11', '2024-02-26 09:24:11', ''),
('H07', '1', 'Dangau Pitossa', '2', 'Tarantang Village, Harau Subdistrict, Lima Puluh Kota Regency, West Sumatra Province', 0xe61000000103000000010000000700000051e58b28f32a59401e579f822ea7bcbfb32a8031f42a59400b1d6427f6afbcbf6ec6a333f42a5940069c4aabc6b7bcbf8f709c0cf52a59402f19852c24c3bcbf8d86c6f2f22a5940681f6d1440cebcbf0856d5cbef2a5940f09183c8d8bfbcbf51e58b28f32a59401e579f822ea7bcbf, -0.11192599, 100.67109121, 18, '10:00:00', '18:00:00', 50, 'Dangau pitossa adalah sebuah penginapan yang nyaman dan bersahaja yang terletak di Lembah Harau, sebuah destinasi alam yang indah di Sumatera Barat, Indonesia. Penginapan ini menawarkan pengalaman menginap yang autentik dan dekat dengan alam, dengan pemandangan yang memukau dari tebing batu yang mengelilingi lembah.', NULL, '2024-02-26 09:36:27', '2024-02-26 09:36:27', ''),
('H08', '1', 'Oston Homestay', '2', 'Tarantang Village, Harau Subdistrict, Lima Puluh Kota Regency, West Sumatra Province', 0xe6100000010300000001000000050000003ff6404cfe2a5940fdab9efe793bbcbf3973f66bfe2a594051df1199e23fbcbfbd92818f032b5940f7eac293064cbcbf89349ec6052b5940dfe29f213550bcbf3ff6404cfe2a5940fdab9efe793bbcbf, -0.11028254, 100.67177111, 19, '10:00:00', '18:00:00', 50, 'Oston Homestay adalah sebuah penginapan yang nyaman dan bersahaja yang terletak di Lembah Harau, sebuah destinasi alam yang indah di Sumatera Barat, Indonesia. Penginapan ini menawarkan pengalaman menginap yang autentik dan dekat dengan alam, dengan pemandangan yang memukau dari tebing batu yang mengelilingi lembah.', NULL, '2024-02-26 09:43:34', '2024-02-26 09:43:34', ''),
('H09', '1', 'Megahomestay', '2', 'Tarantang Village, Harau Subdistrict, Lima Puluh Kota Regency, West Sumatra Province', 0xe610000001030000000100000005000000fdba57d60b2b59402760016d2721bcbfe7fea8550d2b594043f969797124bcbf2efc64b50e2b5940085231e77c25bcbff6b7c2c30d2b59402a5b3d8ae72abcbffdba57d60b2b59402760016d2721bcbf, -0.10988089, 100.67259749, 20, '10:00:00', '18:00:00', 50, 'Oston Homestay adalah sebuah penginapan yang nyaman dan bersahaja yang terletak di Lembah Harau, sebuah destinasi alam yang indah di Sumatera Barat, Indonesia. Penginapan ini menawarkan pengalaman menginap yang autentik dan dekat dengan alam, dengan pemandangan yang memukau dari tebing batu yang mengelilingi lembah.', NULL, '2024-02-26 09:47:02', '2024-02-26 09:47:02', ''),
('H10', '1', 'Dangau Abah Homestay', '2', 'Tarantang Village, Harau Subdistrict, Lima Puluh Kota Regency, West Sumatra Province', 0xe61000000103000000010000000b000000221741082d2b5940bb2e368c0619bcbfceb7d310342b5940da5e24171018bcbf65acd3d4342b59401f9b6880a016bcbf82d9eb7a352b594002b859bc5818bcbf3b23a534362b59403fbd0098be19bcbf43b14fdf362b5940017bb73f381bbcbf5edfe23c372b594017c38b74f519bcbf05eb0fff362b5940f7065f984c15bcbf680e62ca342b59409d9771f0d811bcbf54c2d9ce332b5940ba25a4fb5a13bcbf221741082d2b5940bb2e368c0619bcbf, -0.10975686, 100.67462355, 21, '10:00:00', '18:00:00', 50, 'Oston Homestay adalah sebuah penginapan yang nyaman dan bersahaja yang terletak di Lembah Harau, sebuah destinasi alam yang indah di Sumatera Barat, Indonesia. Penginapan ini menawarkan pengalaman menginap yang autentik dan dekat dengan alam, dengan pemandangan yang memukau dari tebing batu yang mengelilingi lembah.', NULL, '2024-02-26 09:55:41', '2024-02-26 09:55:41', ''),
('H11', '1', 'Limpato Homestay', '2', 'Tarantang Village, Harau Subdistrict, Lima Puluh Kota Regency, West Sumatra Province', 0xe6100000010300000001000000050000002b229aab6c2a594084443df15a11bebf0363f9ca6e2a5940256793897c13bebf1eaecdad6d2a59408a394a562c1bbebf63c5fc1e6d2a59405ae8d6ad9622bebf2b229aab6c2a594084443df15a11bebf, -0.11745232, 100.66288271, 22, '10:00:00', '18:00:00', 50, 'Limpato Homestay adalah sebuah penginapan yang nyaman dan bersahaja yang terletak di Lembah Harau, sebuah destinasi alam yang indah di Sumatera Barat, Indonesia. Penginapan ini menawarkan pengalaman menginap yang autentik dan dekat dengan alam, dengan pemandangan yang memukau dari tebing batu yang mengelilingi lembah.', NULL, '2024-02-26 12:17:47', '2024-02-26 12:20:24', '');

-- --------------------------------------------------------

--
-- Table structure for table `homestay_additional_amenities`
--

CREATE TABLE `homestay_additional_amenities` (
  `homestay_id` varchar(3) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `additional_amenities_id` varchar(3) NOT NULL,
  `additional_amenities_type` varchar(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT '1',
  `name` varchar(50) NOT NULL,
  `category` varchar(1) NOT NULL,
  `price` int NOT NULL,
  `is_order_count_per_day` varchar(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT '0',
  `is_order_count_per_person` varchar(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT '0',
  `is_order_count_per_room` varchar(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT '0',
  `stock` int NOT NULL,
  `description` text NOT NULL,
  `image_url` text NOT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `homestay_certification`
--

CREATE TABLE `homestay_certification` (
  `homestay_id` varchar(3) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `certification_id` varchar(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `certificate_name` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `certificate_num` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `certifying_agency` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `date` date NOT NULL,
  `description` text,
  `image_url` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `homestay_facility`
--

CREATE TABLE `homestay_facility` (
  `id` varchar(2) NOT NULL,
  `name` varchar(50) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `homestay_facility`
--

INSERT INTO `homestay_facility` (`id`, `name`, `created_at`, `updated_at`) VALUES
('01', 'Parking Area', '2023-10-28 15:51:29', '2024-12-16 04:16:35'),
('02', 'Park', '2023-10-28 15:51:29', '2024-12-16 04:17:04'),
('03', 'Photo Spot', '2023-10-28 15:51:29', '2024-12-16 04:16:52'),
('04', 'Mushalla', '2023-10-28 15:51:29', '2023-10-28 15:51:29'),
('05', 'Canteen', '2023-10-28 15:51:29', '2024-12-16 04:16:42'),
('06', 'Gazebo', '2023-10-28 15:51:29', '2023-10-28 15:51:29');

-- --------------------------------------------------------

--
-- Table structure for table `homestay_facility_detail`
--

CREATE TABLE `homestay_facility_detail` (
  `homestay_id` varchar(3) NOT NULL,
  `facility_id` varchar(2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `homestay_facility_detail`
--

INSERT INTO `homestay_facility_detail` (`homestay_id`, `facility_id`, `created_at`, `updated_at`) VALUES
('H01', '01', '2024-02-26 05:22:25', '2024-02-26 05:22:25'),
('H01', '02', '2024-02-26 05:22:25', '2024-02-26 05:22:25'),
('H01', '03', '2024-02-26 05:22:25', '2024-02-26 05:22:25'),
('H01', '04', '2024-02-26 05:22:25', '2024-02-26 05:22:25'),
('H01', '05', '2024-02-26 05:22:25', '2024-02-26 05:22:25'),
('H01', '06', '2024-02-26 05:22:25', '2024-02-26 05:22:25'),
('H02', '01', '2024-02-26 07:05:06', '2024-02-26 07:05:06'),
('H02', '02', '2024-02-26 07:05:06', '2024-02-26 07:05:06'),
('H02', '03', '2024-02-26 07:05:06', '2024-02-26 07:05:06'),
('H02', '06', '2024-02-26 07:05:06', '2024-02-26 07:05:06'),
('H03', '01', '2024-02-26 08:58:36', '2024-02-26 08:58:36'),
('H03', '03', '2024-02-26 08:58:36', '2024-02-26 08:58:36'),
('H03', '05', '2024-02-26 08:58:36', '2024-02-26 08:58:36'),
('H03', '06', '2024-02-26 08:58:36', '2024-02-26 08:58:36'),
('H04', '01', '2024-02-26 09:06:12', '2024-02-26 09:06:12'),
('H04', '02', '2024-02-26 09:06:12', '2024-02-26 09:06:12'),
('H04', '03', '2024-02-26 09:06:12', '2024-02-26 09:06:12'),
('H05', '01', '2024-02-26 09:12:46', '2024-02-26 09:12:46'),
('H05', '02', '2024-02-26 09:12:46', '2024-02-26 09:12:46'),
('H05', '03', '2024-02-26 09:12:46', '2024-02-26 09:12:46'),
('H05', '05', '2024-02-26 09:12:46', '2024-02-26 09:12:46'),
('H05', '06', '2024-02-26 09:12:46', '2024-02-26 09:12:46'),
('H06', '01', '2024-02-26 09:24:11', '2024-02-26 09:24:11'),
('H07', '01', '2024-02-26 09:36:27', '2024-02-26 09:36:27'),
('H07', '02', '2024-02-26 09:36:27', '2024-02-26 09:36:27');

-- --------------------------------------------------------

--
-- Table structure for table `homestay_gallery`
--

CREATE TABLE `homestay_gallery` (
  `id` varchar(3) NOT NULL,
  `homestay_id` varchar(3) NOT NULL,
  `url` text,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `homestay_gallery`
--

INSERT INTO `homestay_gallery` (`id`, `homestay_id`, `url`, `created_at`, `updated_at`) VALUES
('001', 'H01', '1708996942_a0187ce30534a5d19779.jpg', '2024-02-26 05:22:25', '2024-02-26 05:22:25'),
('002', 'H01', '1708996756_23818827877eb8777f4f.jpg', '2024-02-26 05:22:25', '2024-02-26 05:22:25'),
('003', 'H01', '1708996733_0459e7788d8cd3204108.jpg', '2024-02-26 05:22:25', '2024-02-26 05:22:25'),
('004', 'H01', '1708996735_ad723e3380fffc979c22.jpg', '2024-02-26 05:22:26', '2024-02-26 05:22:26'),
('005', 'H01', '1708996733_669be0e9573b4cc7bd81.jpg', '2024-02-26 05:22:26', '2024-02-26 05:22:26'),
('006', 'H01', '1708996704_30f2c3d0080c208f327f.jpg', '2024-02-26 05:22:26', '2024-02-26 05:22:26'),
('007', 'H02', '1709003046_136681fff32821764426.jpg', '2024-02-26 07:05:06', '2024-02-26 07:05:06'),
('008', 'H02', '1709003048_526e1184880a0be1b510.jpg', '2024-02-26 07:05:06', '2024-02-26 07:05:06'),
('009', 'H02', '1709003048_cea56da3bcd3e294d4ca.jpg', '2024-02-26 07:05:06', '2024-02-26 07:05:06'),
('010', 'H02', '1709003046_fa1fd3796cf0e0a6524f.jpg', '2024-02-26 07:05:06', '2024-02-26 07:05:06'),
('011', 'H03', '1709009913_38ec234c6c8410d8f024.jpg', '2024-02-26 08:58:36', '2024-02-26 08:58:36'),
('012', 'H03', '1709009901_64202b8e394cc2aad90f.jpg', '2024-02-26 08:58:36', '2024-02-26 08:58:36'),
('013', 'H03', '1709009902_7aa91ee4c6b4b7664b38.jpg', '2024-02-26 08:58:36', '2024-02-26 08:58:36'),
('014', 'H04', '1709010307_2ab7305c50f7691a1a3c.jpg', '2024-02-26 09:06:12', '2024-02-26 09:06:12'),
('015', 'H04', '1709010307_e958d35b54973534718a.jpg', '2024-02-26 09:06:12', '2024-02-26 09:06:12'),
('016', 'H04', '1709010311_59592c3b76ed99cdbc40.jpg', '2024-02-26 09:06:12', '2024-02-26 09:06:12'),
('017', 'H04', '1709010311_9a0dca992e1bdcc61496.jpg', '2024-02-26 09:06:12', '2024-02-26 09:06:12'),
('018', 'H05', '1709010753_123aa13d80dceeebc438.jpg', '2024-02-26 09:12:46', '2024-02-26 09:12:46'),
('019', 'H05', '1709010753_fb8b97fef7c9b5726fd6.jpg', '2024-02-26 09:12:46', '2024-02-26 09:12:46'),
('020', 'H05', '1709010756_20509d45f03a50ec2795.jpg', '2024-02-26 09:12:46', '2024-02-26 09:12:46'),
('021', 'H05', '1709010756_37ea35ccf9b09dd17bc2.jpg', '2024-02-26 09:12:46', '2024-02-26 09:12:46'),
('022', 'H05', '1709010751_05d184d986687335ea72.jpg', '2024-02-26 09:12:46', '2024-02-26 09:12:46'),
('023', 'H05', '1709010750_b848d619d4223be3749a.jpg', '2024-02-26 09:12:46', '2024-02-26 09:12:46'),
('024', 'H06', '1709011448_819d97a6d86d3dc6294f.jpg', '2024-02-26 09:24:11', '2024-02-26 09:24:11'),
('025', 'H07', '1709012184_96150c0d81232727ad9d.jpg', '2024-02-26 09:36:27', '2024-02-26 09:36:27'),
('026', 'H07', '1709012157_192c3c457d626e89d983.jpg', '2024-02-26 09:36:27', '2024-02-26 09:36:27'),
('027', 'H07', '1709012136_a35f9801b8f5f331eff8.jpg', '2024-02-26 09:36:27', '2024-02-26 09:36:27'),
('028', 'H07', '1709012113_5c38dcf83657d231773c.jpg', '2024-02-26 09:36:27', '2024-02-26 09:36:27'),
('029', 'H07', '1709012112_83b76692148ec9b1b9d3.jpg', '2024-02-26 09:36:27', '2024-02-26 09:36:27'),
('030', 'H07', '1709012115_6b82af8c4149003fdf52.jpg', '2024-02-26 09:36:27', '2024-02-26 09:36:27'),
('031', 'H08', '1709012606_c7b17b2ec7e4c265d284.jpg', '2024-02-26 09:43:34', '2024-02-26 09:43:34'),
('032', 'H08', '1709012604_c399f4fadbeb4e943625.jpg', '2024-02-26 09:43:34', '2024-02-26 09:43:34'),
('033', 'H08', '1709012603_8256e6540187320d4a74.jpg', '2024-02-26 09:43:34', '2024-02-26 09:43:34'),
('034', 'H08', '1709012606_4a8028d98071cdc4dafc.jpg', '2024-02-26 09:43:34', '2024-02-26 09:43:34'),
('035', 'H09', '1709012814_d99a10ab32c005a0c3d7.jpg', '2024-02-26 09:47:02', '2024-02-26 09:47:02'),
('036', 'H09', '1709012811_80bd16e0bfb315386cb2.jpg', '2024-02-26 09:47:02', '2024-02-26 09:47:02'),
('037', 'H09', '1709012811_8a5597f02c03e659b2ae.jpg', '2024-02-26 09:47:02', '2024-02-26 09:47:02'),
('038', 'H09', '1709012813_6633d657e10d01382dcb.jpg', '2024-02-26 09:47:02', '2024-02-26 09:47:02'),
('039', 'H10', '1709013336_9cf3df566c684739671d.jpg', '2024-02-26 09:55:41', '2024-02-26 09:55:41'),
('040', 'H10', '1709013328_235f274ef77dad5b9707.jpg', '2024-02-26 09:55:41', '2024-02-26 09:55:41'),
('041', 'H10', '1709013308_880ffbabd9297a05a02a.jpg', '2024-02-26 09:55:41', '2024-02-26 09:55:41'),
('042', 'H10', '1709013312_eab8d2fd7f414955cbb7.jpg', '2024-02-26 09:55:41', '2024-02-26 09:55:41'),
('043', 'H10', '1709013308_bba2e566121a4fd432b7.jpg', '2024-02-26 09:55:41', '2024-02-26 09:55:41'),
('044', 'H10', '1709013311_f6a981f624467a133917.jpg', '2024-02-26 09:55:41', '2024-02-26 09:55:41'),
('045', 'H11', '1709022020_203ac63eadbc7865792b.jpg', '2024-02-26 12:20:24', '2024-02-26 12:20:24'),
('046', 'H11', '1709022021_0c0449818d7637b39352.jpg', '2024-02-26 12:20:24', '2024-02-26 12:20:24'),
('047', 'H11', '1709022022_ea237737fe250c819431.jpg', '2024-02-26 12:20:24', '2024-02-26 12:20:24');

-- --------------------------------------------------------

--
-- Table structure for table `homestay_unit`
--

CREATE TABLE `homestay_unit` (
  `homestay_id` varchar(3) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `unit_type` varchar(2) NOT NULL,
  `unit_number` varchar(2) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `name` varchar(25) NOT NULL,
  `price` int NOT NULL,
  `capacity` int DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `homestay_unit`
--

INSERT INTO `homestay_unit` (`homestay_id`, `unit_type`, `unit_number`, `name`, `price`, `capacity`, `description`, `created_at`, `updated_at`) VALUES
('H01', '1', '1', 'Kamar 1', 350000, 3, 'This homestay room is a comfortable place to rest during your holiday. With simple but attractive decoration, this room is equipped with a comfortable bed and is clean', '2024-02-26 18:56:15', '2024-02-26 19:36:04'),
('H01', '1', '10', 'Kamar 10', 350000, 3, 'This homestay room is a comfortable place to rest during your holiday. With simple but attractive decoration, this room is equipped with a comfortable bed and is clean', '2024-02-27 06:39:10', '2024-02-27 06:39:10'),
('H01', '1', '11', 'Kamar 11', 350000, 3, 'This homestay room is a comfortable place to rest during your holiday. With simple but attractive decoration, this room is equipped with a comfortable bed and is clean', '2024-02-27 06:42:10', '2024-02-27 06:42:10'),
('H01', '1', '12', 'Kamar 12', 350000, 3, 'This homestay room is a comfortable place to rest during your holiday. With simple but attractive decoration, this room is equipped with a comfortable bed and is clean', '2024-02-27 06:43:37', '2024-02-27 06:43:37'),
('H01', '1', '13', 'Kamar 13', 350000, 3, 'This homestay room is a comfortable place to rest during your holiday. With simple but attractive decoration, this room is equipped with a comfortable bed and is clean', '2024-02-27 06:44:48', '2024-02-27 06:44:48'),
('H01', '1', '14', 'Rumah Barbie', 600000, 8, 'This villa is a comfortable place to rest during your holiday. With simple but attractive decoration, this room is equipped with a comfortable bed and is clean', '2024-02-27 07:28:13', '2024-02-27 07:28:13'),
('H01', '1', '2', 'Kamar 2', 350000, 3, 'This homestay room is a comfortable place to rest during your holiday. With simple but attractive decoration, this room is equipped with a comfortable bed and is clean', '2024-02-26 19:49:40', '2024-02-26 19:49:40'),
('H01', '1', '3', 'Kamar 3', 350000, 3, 'This homestay room is a comfortable place to rest during your holiday. With simple but attractive decoration, this room is equipped with a comfortable bed and is clean', '2024-02-26 19:51:43', '2024-02-26 19:51:43'),
('H01', '1', '4', 'Kamar 4', 350000, 3, 'This homestay room is a comfortable place to rest during your holiday. With simple but attractive decoration, this room is equipped with a comfortable bed and is clean', '2024-02-26 19:54:11', '2024-02-26 19:54:11'),
('H01', '1', '5', 'Kamar 5', 350000, 3, 'This homestay room is a comfortable place to rest during your holiday. With simple but attractive decoration, this room is equipped with a comfortable bed and is clean', '2024-02-26 19:56:21', '2024-02-26 19:56:21'),
('H01', '1', '6', 'Kamar 6', 350000, 3, 'This homestay room is a comfortable place to rest during your holiday. With simple but attractive decoration, this room is equipped with a comfortable bed and is clean', '2024-02-26 19:58:49', '2024-02-26 19:58:49'),
('H01', '1', '7', 'Kamar 7', 350000, 3, 'This homestay room is a comfortable place to rest during your holiday. With simple but attractive decoration, this room is equipped with a comfortable bed and is clean', '2024-02-26 20:01:02', '2024-02-26 20:01:02'),
('H01', '1', '8', 'Kamar 8', 350000, 3, 'This homestay room is a comfortable place to rest during your holiday. With simple but attractive decoration, this room is equipped with a comfortable bed and is clean', '2024-02-27 06:36:04', '2024-02-27 06:36:04'),
('H01', '1', '9', 'Kamar 9', 350000, 3, 'This homestay room is a comfortable place to rest during your holiday. With simple but attractive decoration, this room is equipped with a comfortable bed and is clean', '2024-02-27 06:37:49', '2024-02-27 06:37:49'),
('H02', '1', '1', 'Kamar 1', 350000, 2, 'This homestay room is a comfortable place to rest during your holiday. With simple but attractive decoration, this room is equipped with a comfortable bed and is clean', '2024-02-27 13:58:10', '2024-02-27 13:58:10'),
('H02', '1', '2', 'Kamar 2', 350000, 2, 'This homestay room is a comfortable place to rest during your holiday. With simple but attractive decoration, this room is equipped with a comfortable bed and is clean', '2024-02-27 14:00:43', '2024-02-27 14:00:43'),
('H02', '1', '3', 'Kamar 3', 350000, 2, 'This homestay room is a comfortable place to rest during your holiday. With simple but attractive decoration, this room is equipped with a comfortable bed and is clean', '2024-02-27 14:01:09', '2024-02-27 14:01:09'),
('H02', '1', '4', 'Kamar 4', 350000, 2, 'This homestay room is a comfortable place to rest during your holiday. With simple but attractive decoration, this room is equipped with a comfortable bed and is clean', '2024-02-27 14:02:08', '2024-02-27 14:02:08'),
('H02', '1', '5', 'Kamar 5', 350000, 2, 'This homestay room is a comfortable place to rest during your holiday. With simple but attractive decoration, this room is equipped with a comfortable bed and is clean', '2024-02-27 14:02:52', '2024-02-27 14:02:52'),
('H02', '1', '6', 'Kamar 6', 350000, 2, 'This homestay room is a comfortable place to rest during your holiday. With simple but attractive decoration, this room is equipped with a comfortable bed and is clean', '2024-02-27 14:11:35', '2024-02-27 14:11:35'),
('H02', '1', '7', 'Kamar 7', 350000, 2, 'This homestay room is a comfortable place to rest during your holiday. With simple but attractive decoration, this room is equipped with a comfortable bed and is clean', '2024-02-27 14:12:31', '2024-02-27 14:12:31'),
('H02', '1', '8', 'Kamar 8', 350000, 2, 'This homestay room is a comfortable place to rest during your holiday. With simple but attractive decoration, this room is equipped with a comfortable bed and is clean', '2024-02-27 14:13:30', '2024-02-27 14:13:30'),
('H02', '1', '9', 'Kamar 9 ', 350000, 2, 'This homestay room is a comfortable place to rest during your holiday. With simple but attractive decoration, this room is equipped with a comfortable bed and is clean', '2024-02-27 14:14:30', '2024-02-27 14:14:30');

-- --------------------------------------------------------

--
-- Table structure for table `homestay_unit_facility`
--

CREATE TABLE `homestay_unit_facility` (
  `id` varchar(2) NOT NULL,
  `name` varchar(25) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `homestay_unit_facility`
--

INSERT INTO `homestay_unit_facility` (`id`, `name`, `created_at`, `updated_at`) VALUES
('02', 'AC', '2023-12-06 14:34:36', '2023-12-06 14:34:36'),
('03', 'Stove', '2023-12-06 14:34:47', '2024-02-27 02:40:22'),
('04', 'TV', '2023-12-06 14:47:37', '2023-12-06 14:47:37'),
('05', 'Refridgerator', '2023-12-07 15:00:07', '2024-02-27 02:40:01'),
('06', 'Toilet', '2024-02-27 01:58:47', '2024-02-27 01:58:47'),
('07', 'Bed', '2024-02-27 02:00:17', '2024-02-27 02:00:17'),
('08', 'Fan', '2024-02-27 20:59:04', '2024-02-27 20:59:04'),
('09', 'Wardrobe', '2024-10-25 07:20:38', '2024-10-25 07:27:37'),
('10', 'Chair', '2025-01-23 20:17:06', '2025-01-23 20:17:06'),
('11', 'Table', '2025-01-23 20:17:12', '2025-01-23 20:17:12');

-- --------------------------------------------------------

--
-- Table structure for table `homestay_unit_facility_detail`
--

CREATE TABLE `homestay_unit_facility_detail` (
  `homestay_id` varchar(3) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `unit_type` varchar(2) NOT NULL,
  `unit_number` varchar(2) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `facility_id` varchar(2) NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `homestay_unit_facility_detail`
--

INSERT INTO `homestay_unit_facility_detail` (`homestay_id`, `unit_type`, `unit_number`, `facility_id`, `description`, `created_at`, `updated_at`) VALUES
('H01', '1', '1', '06', 'toilet in room', '2024-02-26 19:39:15', '2024-02-26 19:39:15'),
('H01', '1', '1', '07', '1 single bed, 1 double bed', '2024-02-26 19:37:17', '2024-02-26 19:37:17'),
('H01', '1', '10', '06', 'toilet in room', '2024-02-27 06:39:49', '2024-02-27 06:39:49'),
('H01', '1', '10', '07', '1 single bed, 1 double bed', '2024-02-27 06:39:31', '2024-02-27 06:39:31'),
('H01', '1', '11', '06', 'toilet in room', '2024-02-27 06:42:57', '2024-02-27 06:42:57'),
('H01', '1', '11', '07', '1 single bed, 1 double bed', '2024-02-27 06:42:41', '2024-02-27 06:42:41'),
('H01', '1', '12', '06', 'toilet in room', '2024-02-27 06:43:55', '2024-02-27 06:43:55'),
('H01', '1', '12', '07', '1 single bed, 1 double bed', '2024-02-27 06:44:08', '2024-02-27 06:44:08'),
('H01', '1', '2', '06', 'toilet in room', '2024-02-26 19:50:11', '2024-02-26 19:50:11'),
('H01', '1', '2', '07', '1 single bed, 1 double bed', '2024-02-26 19:50:37', '2024-02-26 19:50:37'),
('H01', '1', '3', '06', 'toilet in room', '2024-02-26 19:52:57', '2024-02-26 19:52:57'),
('H01', '1', '3', '07', '1 single bed, 1 double bed', '2024-02-26 19:52:39', '2024-02-26 19:52:39'),
('H01', '1', '4', '06', 'toilet in room', '2024-02-26 19:55:18', '2024-02-26 19:55:18'),
('H01', '1', '4', '07', '1 single bed, 1 double bed', '2024-02-26 19:55:34', '2024-02-26 19:55:34'),
('H01', '1', '5', '06', 'toilet in room', '2024-02-26 19:56:41', '2024-02-26 19:56:41'),
('H01', '1', '5', '07', '1 single bed, 1 double bed', '2024-02-26 19:56:58', '2024-02-26 19:56:58'),
('H01', '1', '6', '06', 'toilet in room', '2024-02-26 19:59:46', '2024-02-26 19:59:46'),
('H01', '1', '6', '07', '1 single bed, 1 double bed', '2024-02-26 19:59:19', '2024-02-26 19:59:19'),
('H01', '1', '7', '06', 'toilet in room', '2024-02-26 20:01:35', '2024-02-26 20:01:35'),
('H01', '1', '7', '07', '1 single bed, 1 double bed', '2024-02-26 20:01:22', '2024-02-26 20:01:22'),
('H01', '1', '8', '06', 'toilet in room', '2024-02-27 06:36:24', '2024-02-27 06:36:24'),
('H01', '1', '8', '07', '1 single bed, 1 double bed', '2024-02-27 06:36:46', '2024-02-27 06:36:46'),
('H01', '1', '9', '06', 'toilet in room', '2024-02-27 06:40:04', '2024-02-27 06:40:04'),
('H01', '1', '9', '07', '1 single bed, 1 double bed', '2024-02-27 06:40:19', '2024-02-27 06:40:19'),
('H02', '1', '1', '07', 'Double bed', '2024-02-27 13:59:32', '2024-02-27 13:59:32');

-- --------------------------------------------------------

--
-- Table structure for table `homestay_unit_gallery`
--

CREATE TABLE `homestay_unit_gallery` (
  `id` varchar(3) NOT NULL,
  `homestay_id` varchar(3) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `unit_type` varchar(2) NOT NULL,
  `unit_number` varchar(2) NOT NULL,
  `url` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `homestay_unit_gallery`
--

INSERT INTO `homestay_unit_gallery` (`id`, `homestay_id`, `unit_type`, `unit_number`, `url`, `created_at`, `updated_at`) VALUES
('001', 'H01', '1', '1', '1709048137_33da4cd2457d45d6753f.jpg', '2024-02-26 19:36:04', '2024-02-26 19:36:04'),
('002', 'H01', '1', '1', '1709048136_f4828cd6163e17399e0a.jpg', '2024-02-26 19:36:04', '2024-02-26 19:36:04'),
('003', 'H01', '1', '2', '1709048959_a639287ae4825fa670c1.jpg', '2024-02-26 19:49:41', '2024-02-26 19:49:41'),
('004', 'H01', '1', '2', '1709048941_7ab7c9172b40439ad887.jpg', '2024-02-26 19:49:41', '2024-02-26 19:49:41'),
('005', 'H01', '1', '3', '1709049101_4e58552968da3d2aacb4.jpg', '2024-02-26 19:51:43', '2024-02-26 19:51:43'),
('006', 'H01', '1', '3', '1709049092_c731f125bfd623c1bb31.jpg', '2024-02-26 19:51:43', '2024-02-26 19:51:43'),
('007', 'H01', '1', '4', '1709049246_2eb0c8f50bbe8ed7fe07.jpg', '2024-02-26 19:54:11', '2024-02-26 19:54:11'),
('008', 'H01', '1', '4', '1709049236_3d72adadc95e451e0aa5.jpg', '2024-02-26 19:54:11', '2024-02-26 19:54:11'),
('009', 'H01', '1', '5', '1709049379_a0ab403704768fe12008.jpg', '2024-02-26 19:56:21', '2024-02-26 19:56:21'),
('010', 'H01', '1', '6', '1709049526_05e84963f460200fb9ed.jpg', '2024-02-26 19:58:49', '2024-02-26 19:58:49'),
('011', 'H01', '1', '6', '1709049517_7cf01fd8a1b057ec0d67.jpg', '2024-02-26 19:58:49', '2024-02-26 19:58:49'),
('012', 'H01', '1', '7', '1709049658_2dd9b63de577f65f2be7.jpg', '2024-02-26 20:01:02', '2024-02-26 20:01:02'),
('013', 'H01', '1', '7', '1709049650_9763ebc12c88a6d0a6be.jpg', '2024-02-26 20:01:02', '2024-02-26 20:01:02'),
('014', 'H01', '1', '8', '1709087762_8c322c07fbb8715a6c16.jpg', '2024-02-27 06:36:05', '2024-02-27 06:36:05'),
('015', 'H01', '1', '9', '1709087866_d45d26763fc16c4b5221.jpg', '2024-02-27 06:37:49', '2024-02-27 06:37:49'),
('016', 'H01', '1', '9', '1709087857_eb25ebd9258f1a26e023.jpg', '2024-02-27 06:37:49', '2024-02-27 06:37:49'),
('017', 'H01', '1', '10', '1709087947_b581c478dd5447dcc977.jpg', '2024-02-27 06:39:10', '2024-02-27 06:39:10'),
('018', 'H01', '1', '10', '1709087935_58eaa6d4557ca3b2efd7.jpg', '2024-02-27 06:39:10', '2024-02-27 06:39:10'),
('019', 'H01', '1', '11', '1709088128_3cce2f9c10e18c639b46.jpg', '2024-02-27 06:42:10', '2024-02-27 06:42:10'),
('020', 'H01', '1', '11', '1709088121_060e6b763bb9c2103c78.jpg', '2024-02-27 06:42:10', '2024-02-27 06:42:10'),
('021', 'H01', '1', '12', '1709088215_2e2f53467cca2fa7913f.jpg', '2024-02-27 06:43:37', '2024-02-27 06:43:37'),
('022', 'H01', '1', '12', '1709088210_e929bf3e5f0a9de6002f.jpg', '2024-02-27 06:43:37', '2024-02-27 06:43:37'),
('023', 'H01', '1', '13', '1709088285_18320006cf92743d41a5.jpg', '2024-02-27 06:44:48', '2024-02-27 06:44:48'),
('024', 'H01', '1', '14', '1709090887_7bcaf37569300e0ea0d3.jpg', '2024-02-27 07:28:13', '2024-02-27 07:28:13'),
('025', 'H01', '1', '14', '1709090818_eb933525341cffa99209.jpg', '2024-02-27 07:28:13', '2024-02-27 07:28:13');

-- --------------------------------------------------------

--
-- Table structure for table `homestay_unit_type`
--

CREATE TABLE `homestay_unit_type` (
  `id` varchar(1) NOT NULL,
  `name` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `homestay_unit_type`
--

INSERT INTO `homestay_unit_type` (`id`, `name`) VALUES
('1', 'Room'),
('2', 'Villa'),
('3', 'Hall');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` bigint UNSIGNED NOT NULL,
  `version` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `group` varchar(255) NOT NULL,
  `namespace` varchar(255) NOT NULL,
  `time` int NOT NULL,
  `batch` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `version`, `class`, `group`, `namespace`, `time`, `batch`) VALUES
(1, '2017-11-20-223112', 'Myth\\Auth\\Database\\Migrations\\CreateAuthTables', 'default', 'Myth\\Auth', 1698551483, 1),
(2, '2022-06-19-055207', 'App\\Database\\Migrations\\RumahGadang', 'default', 'App', 1698551483, 1),
(3, '2022-06-19-064224', 'App\\Database\\Migrations\\GalleryRumahGadang', 'default', 'App', 1698551483, 1),
(4, '2022-06-19-064314', 'App\\Database\\Migrations\\FacilityRumahGadang', 'default', 'App', 1698551483, 1),
(5, '2022-06-19-064319', 'App\\Database\\Migrations\\DetailFacilityRumahGadang', 'default', 'App', 1698551483, 1),
(6, '2022-06-19-064330', 'App\\Database\\Migrations\\Recommendation', 'default', 'App', 1698551483, 1),
(7, '2022-06-19-083121', 'App\\Database\\Migrations\\CulinaryPlace', 'default', 'App', 1698551483, 1),
(8, '2022-06-19-083221', 'App\\Database\\Migrations\\GalleryCulinaryPlace', 'default', 'App', 1698551483, 1),
(9, '2022-06-19-085845', 'App\\Database\\Migrations\\WorshipPlace', 'default', 'App', 1698551483, 1),
(10, '2022-06-19-085946', 'App\\Database\\Migrations\\GalleryWorshipPlace', 'default', 'App', 1698551483, 1),
(11, '2022-06-19-095014', 'App\\Database\\Migrations\\SouvenirPlace', 'default', 'App', 1698551483, 1),
(12, '2022-06-19-095107', 'App\\Database\\Migrations\\GallerySouvenirPlace', 'default', 'App', 1698551483, 1),
(13, '2022-06-19-100610', 'App\\Database\\Migrations\\Event', 'default', 'App', 1698551484, 1),
(14, '2022-06-19-100615', 'App\\Database\\Migrations\\CategoryEvent', 'default', 'App', 1698551484, 1),
(15, '2022-06-19-100620', 'App\\Database\\Migrations\\GalleryEvent', 'default', 'App', 1698551484, 1),
(16, '2022-06-19-101652', 'App\\Database\\Migrations\\Account', 'default', 'App', 1698551484, 1),
(17, '2022-06-19-102032', 'App\\Database\\Migrations\\Role', 'default', 'App', 1698551484, 1),
(18, '2022-06-19-102318', 'App\\Database\\Migrations\\VisitHistory', 'default', 'App', 1698551484, 1),
(19, '2022-06-19-102724', 'App\\Database\\Migrations\\Review', 'default', 'App', 1698551484, 1),
(20, '2022-06-19-103254', 'App\\Database\\Migrations\\Village', 'default', 'App', 1698551484, 1),
(21, '2023-10-20-082233', 'App\\Database\\Migrations\\Homestay', 'default', 'App', 1698551484, 1),
(22, '2023-10-21-091801', 'App\\Database\\Migrations\\HomestayFacility', 'default', 'App', 1698551484, 1),
(23, '2023-10-21-092038', 'App\\Database\\Migrations\\HomestayFacilityDetail', 'default', 'App', 1698551484, 1),
(24, '2023-10-21-162317', 'App\\Database\\Migrations\\HomestayGallery', 'default', 'App', 1698551484, 1),
(25, '2023-10-23-115736', 'App\\Database\\Migrations\\AttractionGallery', 'default', 'App', 1698551484, 1),
(26, '2023-10-23-115747', 'App\\Database\\Migrations\\AttractionFacility', 'default', 'App', 1698551484, 1),
(27, '2023-10-23-115757', 'App\\Database\\Migrations\\Attraction', 'default', 'App', 1698551484, 1),
(28, '2023-10-23-115805', 'App\\Database\\Migrations\\AttractionFacilityDetail', 'default', 'App', 1698551484, 1),
(29, '2023-10-23-122242', 'App\\Database\\Migrations\\ServiceProvider', 'default', 'App', 1698551484, 1),
(30, '2023-10-23-122247', 'App\\Database\\Migrations\\ServiceProviderGallery', 'default', 'App', 1698551484, 1),
(31, '2023-10-23-131657', 'App\\Database\\Migrations\\Service', 'default', 'App', 1698551484, 1),
(32, '2023-10-23-150249', 'App\\Database\\Migrations\\AttractionTicketPrice', 'default', 'App', 1698551485, 1),
(33, '2023-10-24-005102', 'App\\Database\\Migrations\\SouvenirPlaceGallery', 'default', 'App', 1698551485, 1),
(34, '2023-10-24-005130', 'App\\Database\\Migrations\\SouvenirProduct', 'default', 'App', 1698551485, 1),
(35, '2023-10-24-005139', 'App\\Database\\Migrations\\SouvenirProductDetail', 'default', 'App', 1698551485, 1),
(36, '2023-10-24-012740', 'App\\Database\\Migrations\\CulinaryPlaceGallery', 'default', 'App', 1698551485, 1),
(37, '2023-10-24-012757', 'App\\Database\\Migrations\\CulinaryProduct', 'default', 'App', 1698551485, 1),
(38, '2023-10-24-012810', 'App\\Database\\Migrations\\CulinaryProductDetail', 'default', 'App', 1698551485, 1),
(39, '2023-10-24-013452', 'App\\Database\\Migrations\\WorshipPlaceGallery', 'default', 'App', 1698551485, 1),
(40, '2023-10-24-013508', 'App\\Database\\Migrations\\WorshipPlaceCategory', 'default', 'App', 1698551485, 1);

-- --------------------------------------------------------

--
-- Table structure for table `province`
--

CREATE TABLE `province` (
  `id` varchar(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `name` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `geom` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `province`
--

INSERT INTO `province` (`id`, `name`, `geom`) VALUES
('P01', 'Aceh', 'P01.geojson'),
('P02', 'Sumatera Utara', 'P02.geojson'),
('P03', 'Sumatera Barat', 'P03.geojson'),
('P04', 'Riau', 'P04.geojson'),
('P05', 'Jambi', 'P05.geojson'),
('P06', 'Sumatera Selatan', 'P06.geojson'),
('P07', 'Bengkulu', 'P07.geojson'),
('P08', 'Lampung', 'P08.geojson'),
('P09', 'Kepulauan Riau', 'P10.geojson'),
('P10', 'Bangka Belitung', 'P09.geojson');

-- --------------------------------------------------------

--
-- Table structure for table `reservation`
--

CREATE TABLE `reservation` (
  `id` varchar(4) NOT NULL,
  `customer_id` int UNSIGNED DEFAULT NULL,
  `reservation_type` varchar(1) NOT NULL DEFAULT '1',
  `request_date` datetime NOT NULL,
  `check_in` datetime NOT NULL,
  `total_people` int DEFAULT NULL,
  `review` text,
  `rating` int DEFAULT NULL,
  `bonus_coin` int DEFAULT NULL,
  `coin_use` int DEFAULT NULL,
  `total_price` int DEFAULT NULL,
  `deposit` int DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL,
  `deposit_snap_token` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `pay_full_snap_token` text,
  `reservation_finish_at` timestamp NULL DEFAULT NULL,
  `is_rejected` varchar(1) DEFAULT NULL,
  `confirmed_at` timestamp NULL DEFAULT NULL,
  `feedback` text,
  `canceled_at` timestamp NULL DEFAULT NULL,
  `cancelation_reason` varchar(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `is_refund` char(1) DEFAULT NULL,
  `refund_paid_at` timestamp NULL DEFAULT NULL,
  `account_refund` text,
  `refund_proof` text,
  `is_refund_proof_correct` varchar(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `refund_paid_confirmed_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reservation_homestay_additional_amenities_detail`
--

CREATE TABLE `reservation_homestay_additional_amenities_detail` (
  `homestay_id` varchar(3) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `additional_amenities_id` varchar(3) NOT NULL,
  `reservation_id` varchar(4) NOT NULL,
  `day_order` int NOT NULL,
  `person_order` int NOT NULL,
  `room_order` int NOT NULL,
  `total_order` int NOT NULL,
  `total_price` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reservation_homestay_unit_detail`
--

CREATE TABLE `reservation_homestay_unit_detail` (
  `homestay_id` varchar(3) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `unit_type` varchar(2) NOT NULL,
  `unit_number` varchar(2) NOT NULL,
  `date` date NOT NULL,
  `reservation_id` varchar(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reservation_homestay_unit_detail_backup`
--

CREATE TABLE `reservation_homestay_unit_detail_backup` (
  `homestay_id` varchar(3) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `unit_type` varchar(2) NOT NULL,
  `unit_number` varchar(2) NOT NULL,
  `reservation_id` varchar(4) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `souvenir_place`
--

CREATE TABLE `souvenir_place` (
  `id` varchar(2) NOT NULL,
  `village_id` varchar(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `name` varchar(50) NOT NULL,
  `address` varchar(100) DEFAULT NULL,
  `employee_name` varchar(25) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `phone` varchar(13) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `open` time DEFAULT NULL,
  `close` time DEFAULT NULL,
  `geom` geometry DEFAULT NULL,
  `lat` decimal(10,8) NOT NULL,
  `lng` decimal(11,8) NOT NULL,
  `description` text,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `souvenir_place`
--

INSERT INTO `souvenir_place` (`id`, `village_id`, `name`, `address`, `employee_name`, `phone`, `open`, `close`, `geom`, `lat`, `lng`, `description`, `created_at`, `updated_at`) VALUES
('S1', '1', 'Galeri Seni', 'Pariangan, Kec. Pariangan, Kabupaten Tanah Datar, Sumatera Barat ', 'Putri', '085267256677', '09:00:00', '18:00:00', 0xe610000001030000000100000005000000f91c9feb981f5940b693dd870756ddbff91c9f539a1f594090ba82c8b855ddbff91c5f759a1f59400d3d9306a556ddbffa1cff3f991f594098a50586e856ddbff91c9feb981f5940b693dd870756ddbf, -0.45839325, 100.49375546, 'Galeri Seni is a souvenir shop located in Nagari Tuo Pariangan. It offers a wide range of unique souvenirs that reflect the rich heritage of Nagari Tuo Pariangan.', '2024-10-25 03:51:07', '2025-01-10 01:18:45'),
('S2', '1', 'Rumah UKM Batik Nagari Tuo Pariangan', 'Pariangan, Kec. Pariangan, Kabupaten Tanah Datar, Sumatera Barat ', 'Martini', '081266124955', '21:00:00', '06:00:00', 0xe610000001030000000100000006000000bb04dbc2681f59403dbd097af00addbfbc043bf8691f59402b655f7ed408ddbfbc04fb276b1f59409c9d259ef008ddbfba04fb086c1f5940c77b3e1d6109ddbfbc041bbd6a1f5940961124b8dc0bddbfbb04dbc2681f59403dbd097af00addbf, -0.45375648, 100.49086903, 'Rumah UKM Batik Nagari Tuo Pariangan is a small business specializing in creating traditional batik unique to Nagari Tuo Pariangan. It offers a variety of distinctive batik patterns that showcase the cultural richness of Pariangan.', '2024-10-25 04:04:07', '2025-01-10 01:19:39'),
('S5', NULL, 'Wida Gallery 99 Sarasah Bunta', 'Tarantang village, Harau Subdistrict, Lima Puluh Kota Regency, West Sumatra Province', 'Wida', '082344125645', '10:00:00', '18:00:00', 0xe61000000103000000010000000500000086127dfd3a2b59400c2bed4b08e9bbbf8512fdf43b2b5940e17ff24bdbe8bbbf86127d0b3c2b5940517b374b02efbbbf8612bd083b2b5940232c424ba8eebbbf86127dfd3a2b59400c2bed4b08e9bbbf, -0.10906880, 100.67550766, 'Selamat datang di Wida Gallery 99, destinasi yang memukau untuk menemukan cinderamata istimewa, yang terletak di dekat Sarasah Bunta! Wida Gallery 99 merupakan surga bagi para pencinta souvenir, menawarkan pengalaman berbelanja yang tak terlupakan di tengah-tengah keindahan lokal yang khas.', '2023-12-01 14:13:53', '2023-12-01 16:15:15'),
('S6', NULL, 'Harau Collection & Souvenir', 'Tarantang Village, Harau Subdistrict, Lima Puluh Kota Regency, West Sumatra Province', 'Iwan', '082267348821', '10:00:00', '18:00:00', 0xe610000001030000000100000006000000fa7e921d732a5940edfd04e0c8febcbffa7e0215752a59402e0a0a80a1febcbffa7e1223752a594030bc775f1703bdbffb7ed228732a59407f346c5f7103bdbffa7e921d732a5940edfd04e0c8febcbffa7e921d732a5940edfd04e0c8febcbf, -0.11329707, 100.66333778, 'Selamat datang di Harau Collection & Souvenir, destinasi yang memukau untuk menemukan cinderamata istimewa, yang terletak di Lembah Harau. Harau Collection & Souvenir merupakan surga bagi para pencinta souvenir, menawarkan pengalaman berbelanja yang tak terlupakan di tengah-tengah keindahan lokal yang khas.', '2023-12-01 16:44:52', '2023-12-01 16:45:32'),
('S7', NULL, 'Harau Cell & Fashion', 'Tarantang Village, Harau Subdistrict, Lima Puluh Kota Regency, West Sumatra Province', 'Andi', '082211213349', '10:00:00', '18:00:00', 0xe610000001030000000100000006000000df514b7e4b2b5940b3e53046e1e0bbbfdd51b3524b2b594083f9ae252ae5bbbfdd5173554c2b5940c44d94250be6bbbfdd51f36b4c2b594095961926a6e1bbbfdf51b3ac4b2b5940dd902b460ee1bbbfdf514b7e4b2b5940b3e53046e1e0bbbf, -0.10893954, 100.67650588, 'Harau Cell & Fashion bukan hanya sekadar toko, melainkan pusat inspirasi yang memadukan kecantikan budaya dan fesyen terkini. Dengan atmosfer yang ramah dan penuh semangat, setiap pengunjung diundang untuk menjelajahi koleksi souvenir yang dipilih dengan cermat dan penuh cinta.', '2023-12-01 17:16:18', '2023-12-01 17:17:47'),
('S8', NULL, 'Sarasah Bunta Garden', 'Tarantang Village, Harau Subdistrict, Lima Puluh Kota Regency, West Sumatra Province', 'Wan', '081287723412', '09:00:00', '18:00:00', 0xe61000000103000000010000000500000038c2b2224d2b5940e301fbf550e7bbbf37c2f2684e2b59407c50d0f5b8e8bbbf37c2f20e4e2b5940757455f5c3ecbbbf38c272ea4c2b5940d83990f5d4eabbbf38c2b2224d2b5940e301fbf550e7bbbf, -0.10903993, 100.67661517, 'Sarasah Bunta Garden bagaikan oase yang memelihara tanaman-tanaman endemik yang tumbuh subur di kawasan ini. Setiap sudut taman dipenuhi dengan keindahan alami dan aroma harum dari berbagai jenis tanaman yang khas. Dari flora yang langka hingga tanaman hias yang menawan, setiap pot dan wadah dipilih dengan hati untuk memamerkan keunikan dan keindahan masing-masing.', '2023-12-01 17:44:34', '2023-12-01 17:44:34');

-- --------------------------------------------------------

--
-- Table structure for table `souvenir_place_facility`
--

CREATE TABLE `souvenir_place_facility` (
  `id` varchar(2) NOT NULL,
  `name` varchar(25) NOT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `souvenir_place_facility`
--

INSERT INTO `souvenir_place_facility` (`id`, `name`, `created_at`, `updated_at`) VALUES
('01', 'Parking Area', '2025-01-03 21:03:37', '2025-01-03 21:03:37'),
('02', 'Toilet', '2025-01-03 23:02:35', '2025-01-03 23:02:35');

-- --------------------------------------------------------

--
-- Table structure for table `souvenir_place_facility_detail`
--

CREATE TABLE `souvenir_place_facility_detail` (
  `souvenir_place_id` varchar(2) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `souvenir_place_facility_id` varchar(2) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `souvenir_place_facility_detail`
--

INSERT INTO `souvenir_place_facility_detail` (`souvenir_place_id`, `souvenir_place_facility_id`) VALUES
('S1', '01'),
('S2', '01'),
('S1', '02'),
('S2', '02');

-- --------------------------------------------------------

--
-- Table structure for table `souvenir_place_gallery`
--

CREATE TABLE `souvenir_place_gallery` (
  `id` varchar(3) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `souvenir_place_id` varchar(2) NOT NULL,
  `url` text,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `souvenir_place_gallery`
--

INSERT INTO `souvenir_place_gallery` (`id`, `souvenir_place_id`, `url`, `created_at`, `updated_at`) VALUES
('017', 'S1', '1736518713_0bb94d0165d062bff32d.jpg', '2025-01-10 01:18:45', '2025-01-10 01:18:45'),
('018', 'S1', '1736518713_151743965a84e2270944.jpg', '2025-01-10 01:18:45', '2025-01-10 01:18:45'),
('019', 'S1', '1736518713_a085e26c748369920488.jpg', '2025-01-10 01:18:45', '2025-01-10 01:18:45'),
('020', 'S1', '1736518714_9d9d8f744c82d938754c.jpg', '2025-01-10 01:18:45', '2025-01-10 01:18:45'),
('021', 'S1', '1736518713_0d1db409ef0555862542.jpg', '2025-01-10 01:18:45', '2025-01-10 01:18:45'),
('022', 'S2', '1736518738_bd7481d7ede26aa9890b.jpg', '2025-01-10 01:19:39', '2025-01-10 01:19:39'),
('023', 'S2', '1736518738_df399012aabff9994fd1.jpg', '2025-01-10 01:19:39', '2025-01-10 01:19:39'),
('024', 'S2', '1736518738_baaf5e80ae69c2a0e729.jpg', '2025-01-10 01:19:39', '2025-01-10 01:19:39');

-- --------------------------------------------------------

--
-- Table structure for table `souvenir_product`
--

CREATE TABLE `souvenir_product` (
  `id` varchar(2) NOT NULL,
  `name` varchar(50) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `souvenir_product`
--

INSERT INTO `souvenir_product` (`id`, `name`, `created_at`, `updated_at`) VALUES
('01', 'Batik Nagari Tuo Pariangan', '2024-10-25 03:54:38', '2024-10-25 03:54:42'),
('02', 'Gantungan Kunci Sendal', '2024-10-25 03:55:22', '2024-10-25 03:55:22'),
('03', 'Songket Nagari Tuo Pariangan', '2024-10-25 03:55:35', '2024-10-25 03:55:35'),
('04', 'Topi Batik Khas Pariangan', '2024-10-25 03:56:13', '2024-10-25 03:56:13'),
('05', 'Kerajinan Tangan Limbah Plastik Tas Tangan', '2024-10-25 03:57:27', '2024-10-25 03:57:27'),
('06', 'Kerajinan Tangan Tas Kain', '2024-10-25 04:19:39', '2024-10-25 04:19:39');

-- --------------------------------------------------------

--
-- Table structure for table `souvenir_product_detail`
--

CREATE TABLE `souvenir_product_detail` (
  `souvenir_place_id` varchar(2) NOT NULL,
  `souvenir_product_id` varchar(2) NOT NULL,
  `price` int UNSIGNED NOT NULL,
  `image_url` text,
  `description` text,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `souvenir_product_detail`
--

INSERT INTO `souvenir_product_detail` (`souvenir_place_id`, `souvenir_product_id`, `price`, `image_url`, `description`, `created_at`, `updated_at`) VALUES
('S1', '01', 200000, '1729872735_9afa37f516ad8beac01e.jpg', 'Batik Khas Nagari Tuo Pariangan\r\n', '2024-10-25 04:12:25', '2024-10-25 04:12:25'),
('S1', '02', 10000, '1729872762_ec76a4cd974506678e13.jpg', 'Kerajinan Tangan Gantungan Kunci Sendal terbuat dari   karet khusus dan kulit sintetis', '2024-10-25 04:14:16', '2024-10-25 04:14:16'),
('S1', '03', 350000, '1729872873_f10454f30383ec9bc3f6.jpg', 'Songket khas Nagari Tuo Pariangan dengan motif khas Pariangan', '2024-10-25 04:15:01', '2024-10-25 04:15:01'),
('S1', '04', 100000, '1729872974_44d689115c64690a6fa3.jpg', 'Bermotif batik khas Pariangan', '2024-10-25 04:16:40', '2024-10-25 04:16:40'),
('S1', '05', 35000, '1729873140_00df20a5ba32c35f7537.jpg', 'Terbuat dari limbah plastik', '2024-10-25 04:19:20', '2024-10-25 04:19:20'),
('S1', '06', 50000, '1729873199_826f4040b7787956ef47.jpg', 'Kerajinan tangan tas berbahan dasar kain bermotif\r\n', '2024-10-25 04:20:27', '2024-10-25 04:20:27'),
('S2', '01', 150000, '1729872687_689a5dc9724284bee54e.jpg', 'Batik Khas Nagari Tuo Pariangan', '2024-10-25 04:11:40', '2024-10-25 04:11:40');

-- --------------------------------------------------------

--
-- Table structure for table `subdistrict`
--

CREATE TABLE `subdistrict` (
  `id` varchar(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `name` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `geom` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subdistrict`
--

INSERT INTO `subdistrict` (`id`, `name`, `geom`) VALUES
('S01', 'Akabiluru', 'S01.geojson'),
('S02', 'Bukik Barisan', 'S02.geojson'),
('S03', 'Guguak', 'S03.geojson'),
('S04', 'Gunuang Omeh', 'S04.geojson'),
('S05', 'Harau', 'S05.geojson'),
('S06', 'Kapur IX', 'S06.geojson'),
('S07', 'Lareh Sago Halaban', 'S07.geojson'),
('S08', 'Luak', 'S08.geojson'),
('S09', 'Mungka', 'S09.geojson'),
('S10', 'Pangkalan Koto Baru', 'S10.geojson'),
('S11', 'Payakumbuh', 'S11.geojson'),
('S12', 'Situjuah Limo Nagari', 'S12.geojson'),
('S13', 'Suliki', 'S13.geojson');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int UNSIGNED NOT NULL,
  `email` varchar(50) NOT NULL,
  `username` varchar(30) DEFAULT NULL,
  `first_name` varchar(30) DEFAULT NULL,
  `last_name` varchar(30) DEFAULT NULL,
  `address` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `phone` varchar(13) DEFAULT NULL,
  `avatar` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT 'default.jpg',
  `total_coin` int DEFAULT NULL,
  `password_hash` varchar(255) NOT NULL,
  `reset_hash` varchar(255) DEFAULT NULL,
  `reset_at` datetime DEFAULT NULL,
  `reset_expires` datetime DEFAULT NULL,
  `status` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `status_message` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '0',
  `activate_hash` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `activate_expires` datetime DEFAULT NULL,
  `force_pass_reset` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `username`, `first_name`, `last_name`, `address`, `phone`, `avatar`, `total_coin`, `password_hash`, `reset_hash`, `reset_at`, `reset_expires`, `status`, `status_message`, `active`, `activate_hash`, `activate_expires`, `force_pass_reset`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'accuser1@email.com', 'accuser1', 'User 1', 'Account', 'Desa Wisata Kampuang Minang Nagari Sumpu', '081966159032', 'default.jpg', NULL, '$2y$10$W2TphwPWSmS9S/XIIWOU7eiCg7SxapyAuGRwXZ/7oPmSngs8vZJuO', NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, 0, '2023-10-28 22:51:28', '2023-10-28 22:51:28', NULL),
(2, 'accuser2@email.com', 'accuser2', 'User 2', 'Account', 'Desa Wisata Kampuang Minang Nagari Sumpu', '081211536051', 'default.jpg', NULL, '$2y$10$PyeB88Z/oU0ZpS7EqejH5unNVhWqwXGmRk0f5f1TeRgXdZ37s.g6e', NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, 0, '2023-10-28 22:51:28', '2023-10-28 22:51:28', NULL),
(3, 'accuser3@email.com', 'accuser3', 'User 3', 'Account', 'Desa Wisata Kampuang Minang Nagari Sumpu', '081673777122', 'default.jpg', NULL, '$2y$10$7YbcXjv8uL2bsYbdX1EJPucZr7v.F1lDXOmNiHalcUVo2.BeA0oY6', NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, 0, '2023-10-28 22:51:29', '2023-10-28 22:51:29', NULL),
(4, 'accuser4@email.com', 'accuser4', 'User 4', 'Account', 'Desa Wisata Kampuang Minang Nagari Sumpu', '081375337211', 'default.jpg', NULL, '$2y$10$2AmltcPtgE0h0FyHBvzjB.96QAvoZ1JPgTc5qmpzt5NOYRo//TNZW', NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, 0, '2023-10-28 22:51:29', '2023-10-28 22:51:29', NULL),
(7, 'pokdarwispariangan1@gmail.com', 'pokdarwis.pariangan', 'Fakhrudoni Putra', 'Account', 'Desa Wisata Nagari Tuo Pariangan', '081261499095', 'default.jpg', NULL, '$2y$10$KKs/QMWOtQgv6eN0wOiCQO5SDa14h2o387oiOCPyn9nGDKFs0usAu', NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, 0, '2023-10-28 22:51:29', '2023-10-28 22:51:29', NULL),
(8, 'accadmin1@email.com', 'accadmin1', 'Zuherman', 'Account', 'Desa Wisata Kampuang Minang Nagari Sumpu', '08111678345', 'default.jpg', NULL, '$2y$10$Qj.hWZHW4uLNI2G8TMxSH.iY3A.B6auTcHB3lVPwPWkNsDyC5esRi', NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, 0, '2023-10-28 22:51:29', '2023-10-28 22:51:29', NULL),
(9, 'homestayharausyafiq@gmail.com', 'homestayharausyafiqaccount', 'Andi', NULL, 'Tarantang Village, Harau Subdistrict, Lima Puluh Kota Regency, West Sumatra Province', '085213100756', 'default.jpg', NULL, '$2y$10$VumDbbWe08c0kNuMKeSpJuvhpgPcdYM9NEQ2t/qjYZzIfK5Fg4U5e', NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, 0, '2023-12-08 10:27:24', '2023-12-08 10:27:24', NULL),
(10, 'ari@gmail.com', 'arie', NULL, NULL, NULL, NULL, 'default.jpg', NULL, '$2y$10$I76ASpG4aFnFakR212BTm.MkremdoUllq7dJkJRa1aDK2OC.4IPpa', NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, 0, '2023-12-14 01:20:26', '2023-12-14 01:20:26', NULL),
(11, 'shandyka2403@gmail.com', 'dykdyk', 'Dyka', 'Dyka', 'Padang', '085171597007', 'default.jpg', 0, '$2y$10$fVxJTbgT/Ja7xSc56553suT/tYJA8XzUL9zkl61yBYR/qtNQ35OoG', NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, 0, '2023-12-14 20:28:36', '2023-12-14 20:28:36', NULL),
(12, 'daffa@gmail.com', 'daffa', 'Daffa', 'Muyassar', 'Bukittinggi', '082223556788', 'default.jpg', NULL, '$2y$10$6dlvr8vNqXtFACvXFTAhx.g4DQXUt9ED9zuIkljB3jTHuRgzyqiMO', NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, 0, '2023-12-14 20:28:36', '2023-12-14 20:28:36', NULL),
(13, 'aurahomesta@gmail.com', 'aurahomestayaccount', NULL, NULL, 'Tarantang Village, Harau Subdistrict, Lima Puluh Kota Regency, West Sumatra Province', '081270263970', 'default.jpg', NULL, '$2y$10$tXgnmtgKzebhj7t6.EBqR.IkxWMLp1biVfgle2HKx1EJgapvRQIFO', NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, 0, '2024-02-26 19:27:21', '2024-02-26 19:27:21', NULL),
(14, 'meliyahomestay@gmail.com', 'meliyahomestayaccount', NULL, NULL, 'Tarantang Village, Harau Subdistrict, Lima Puluh Kota Regency, West Sumatra Province', '085274265850', 'default.jpg', NULL, '$2y$10$LeHmdAe2g.22UfdwkHquLeZl1nK7.AtIu2HuYgtpBLWoW02lfQ6zi', NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, 0, '2024-02-26 22:54:14', '2024-02-26 22:54:14', NULL),
(15, 'abyanhomestay@gmail.com', 'abyanhomestayaccount', NULL, NULL, 'Tarantang Village, Harau Subdistrict, Lima Puluh Kota Regency, West Sumatra Province', '081270377333', 'default.jpg', NULL, '$2y$10$DHia3.HzTpmHJANPOJM4ReyM7EJ8pyWbhOcZqOh8RDcR.AvPV/rb6', NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, 0, '2024-02-26 22:59:42', '2024-02-26 22:59:42', NULL),
(16, 'homestaybilza@gmail.com', 'homestaybilzaaccount', NULL, NULL, 'Tarantang Village, Harau Subdistrict, Lima Puluh Kota Regency, West Sumatra Province', '081363876893', 'default.jpg', NULL, '$2y$10$5sod.IT34FbcaKDwIRgD9.NB.6sjciZcb5clPjW0uXlYAP99No5wK', NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, 0, '2024-02-26 23:08:20', '2024-02-26 23:08:20', NULL),
(17, 'homestayibu@gmail.com', 'homestayibuaccount', NULL, NULL, 'Tarantang Village, Harau Subdistrict, Lima Puluh Kota Regency, West Sumatra Province', '082381976256', 'default.jpg', NULL, '$2y$10$Sm3bMZsbox0B7PCXekXiw.WMMf7KusogYbD1T7oh0NkgHvQuNilwm', NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, 0, '2024-02-26 23:14:20', '2024-02-26 23:14:20', NULL),
(18, 'dangaupitossa@gmail.com', 'dangaupitossaaccount', NULL, NULL, 'Tarantang Village, Harau Subdistrict, Lima Puluh Kota Regency, West Sumatra Province', '085285333018', 'default.jpg', NULL, '$2y$10$oaMkGwJ6P2dtvfNacFm2tOWkAKBVYED1nj/C3cLyfCq85M0y5HMRC', NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, 0, '2024-02-26 23:28:12', '2024-02-26 23:28:12', NULL),
(19, 'ostonhomestay@gmail.com', 'ostonhomestayaccount', NULL, NULL, 'Tarantang Village, Harau Subdistrict, Lima Puluh Kota Regency, West Sumatra Province', '082174854400', 'default.jpg', NULL, '$2y$10$Av7FOrEUF5/M33bIJiQwIueHlpae.2WgIKquWCqf9OQZMijp4bjhW', NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, 0, '2024-02-26 23:37:28', '2024-02-26 23:37:28', NULL),
(20, 'megahomestay@gmail.com', 'megahomestayaccount', NULL, NULL, 'Tarantang Village, Harau Subdistrict, Lima Puluh Kota Regency, West Sumatra Province', '081266724140', 'default.jpg', NULL, '$2y$10$hLY4EbUhD29vSBcTu7Q3P.FL9mWl..QzYgaXy/6hsh6nY/nFMCkJS', NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, 0, '2024-02-26 23:44:25', '2024-02-26 23:44:25', NULL),
(21, 'dangauabahhomestay@gmail.com', 'dangauabahhomestayaccount', NULL, NULL, 'Tarantang Village, Harau Subdistrict, Lima Puluh Kota Regency, West Sumatra Province', '082391158500', 'default.jpg', NULL, '$2y$10$AJA4Um/doSqcEvhi1FJGaeRIYt9noTCycT6OMdg9rmYpILkUhmqWW', NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, 0, '2024-02-26 23:47:49', '2024-02-26 23:47:49', NULL),
(22, 'limpatohomesaty@gmail.com', 'limpatohomestayaccount', NULL, NULL, 'Tarantang Village, Harau Subdistrict, Lima Puluh Kota Regency, West Sumatra Province', '081364348921', 'default.jpg', NULL, '$2y$10$388h3htWTvMWy19Yk4uhY.2wto/Y.Fx5ASRHkuwWJ3k4JG1o.FuNC', NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, 0, '2024-02-26 23:56:58', '2024-02-26 23:56:58', NULL),
(23, 'umegahomestay@gmail.com', 'umegahomestay', 'Owner Umega', 'Homestay', 'Pariangan, Kec. Pariangan, Kabupaten Tanah Datar, Sumatera Barat ', '0895329272378', 'default.jpg', NULL, '$2y$10$t/tLnMQiHV.4x9rez4BozenBzYWYsax3IZy5apnWa729tS1p944xq', NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, 0, '2024-09-26 11:40:48', '2024-09-26 11:40:48', NULL),
(24, 'gudesterhomestay@gmail.com', 'gudesterhomestay', 'Owner Gudester', 'Homestay', 'Pariangan, Kec. Pariangan, Kabupaten Tanah Datar, Sumatera Barat ', '0895329272378', 'default.jpg', NULL, '$2y$10$e4cqmQwqIh8drtCvobmCuOodW.zIHGRwqIn9RKfG6u6MapDSJ2dva', NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, 0, '2024-09-28 05:04:12', '2024-09-28 05:04:12', NULL),
(25, 'nabilahomestay@gmail.com', 'nabilahomestay', 'Owner Nabila', 'Homestay', 'Pariangan, Kec. Pariangan, Kabupaten Tanah Datar, Sumatera Barat ', '082249063128', 'default.jpg', NULL, '$2y$10$hb.4auiFDNFb8uPEePqiauI2jyTKKm47b.4WXfMdB5hxSc6iWmTgq', NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, 0, '2024-10-10 03:16:39', '2024-10-10 03:16:39', NULL),
(29, 'homestayowner@gmail.com', 'homestayowner', NULL, NULL, NULL, NULL, 'default.jpg', NULL, '$2y$10$pQSYrqO.4NziX/HbFzn3peJJ77P2UBUQos4Bag7W/v/kUXrIzpjDS', NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, 0, '2025-01-25 07:14:31', '2025-01-25 07:14:31', NULL),
(32, 'asdasd@gmail.com', 'asdasd', NULL, NULL, NULL, NULL, 'default.jpg', NULL, '$2y$10$Z1GR4njHo2Kue0T7vLgJ7.QQyJVKBqyW6OplFpLzTkoumdpkniTC6', NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, 0, '2025-02-27 06:15:53', '2025-02-27 06:15:53', NULL),
(48, 'nightbaron.369@gmail.com', 'nightbaron.369', NULL, NULL, NULL, NULL, '8be33a9bba6bc612cbb3b0f90b880ef3c397a8a6.jpg', NULL, '$2y$10$VccF2VDE3ro/QDOYsokVyuS2Hh7JcS5WPZc6RiOsFCVZndI7qaREq', NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, 0, '2025-07-26 01:33:27', '2025-11-23 00:09:33', NULL),
(49, 'lukmanjunedd@gmail.com', 'lukmanjunedd', NULL, NULL, NULL, NULL, '26bdb3a2f303ebe71c80139b76a44dc5925d9636.jpg', NULL, '$2y$10$NhweBKCH8GNTLZelxB5qD.Z3QF1V0jA3OD9NutKcavX2quRplUfFu', NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, 0, '2025-07-26 01:48:41', '2025-07-29 00:40:16', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `village`
--

CREATE TABLE `village` (
  `id` varchar(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `geom_file` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `selected` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT '0',
  `description` text,
  `ticket_price` int DEFAULT NULL,
  `open` time DEFAULT NULL,
  `close` time DEFAULT NULL,
  `address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `email` varchar(50) DEFAULT NULL,
  `facebook` varchar(50) DEFAULT NULL,
  `instagram` varchar(50) DEFAULT NULL,
  `youtube` varchar(50) DEFAULT NULL,
  `tiktok` varchar(50) DEFAULT NULL,
  `video_url` text,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `village`
--

INSERT INTO `village` (`id`, `name`, `geom_file`, `selected`, `description`, `ticket_price`, `open`, `close`, `address`, `email`, `facebook`, `instagram`, `youtube`, `tiktok`, `video_url`, `created_at`, `updated_at`) VALUES
('1', 'Lembah Harau', 'V01.geojson', '1', 'Harau Valley Tourism Area is located in Nagari Tarantang, Harau District, Lima Puluh Kota Regency, West Sumatra. Harau Valley is known for its stunning natural beauty. You will find steep cliffs, beautiful waterfalls, and expanses of rice fields and refreshing green forests. This unique natural beauty makes it the perfect place to enjoy nature and capture beautiful moments. The uniqueness of the Harau Valley Tourism Area is the presence of a geopark. Harau Valley Geopark has various unique and interesting rock formations. Several geological sites provide insight into the geological history of the area and the natural processes that formed it.', 5000, '08:00:00', '17:00:00', 'Lembah Harau Street, Tarantang village, Harau Subdistrict, Lima Puluh Kota Regency, West Sumatra Province, Indonesia, 25156', 'harauvalley@gmail.com', 'lembaharau', 'explore_harau', NULL, NULL, 'landing_page.mp4', NULL, NULL),
('10', 'Solok Bio-Bio', 'V10.geojson', '0', NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('11', 'Taram', 'V11.geojson', '0', NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('2', 'Batu Balang', 'V02.geojson', '0', NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('3', 'Bukik Limbuku', 'V03.geojson', '0', NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('4', 'Gurun', 'V04.geojson', '0', NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('5', 'Harau', 'V05.geojson\r\n', '0', NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('6', 'Koto Tuo', 'V06.geojson', '0', NULL, NULL, '00:00:00', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('7', 'Lubuak Batingkok\r\n', 'V07.geojson', '0', NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('8', 'Pilubang', 'V08.geojson', '0', NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('9', 'Tabek Talang Babungo', 'V09.geojson', '0', NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `village_gallery`
--

CREATE TABLE `village_gallery` (
  `id` varchar(3) NOT NULL,
  `village_id` varchar(3) NOT NULL,
  `url` text NOT NULL,
  `description` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `village_gallery`
--

INSERT INTO `village_gallery` (`id`, `village_id`, `url`, `description`) VALUES
('001', '1', '1.jpg', 'q'),
('002', '1', '111.jpg', 'w'),
('003', '1', '1111.jpg', 'r'),
('004', '1', '11111.jpg', 't');

-- --------------------------------------------------------

--
-- Table structure for table `worship_place`
--

CREATE TABLE `worship_place` (
  `id` varchar(2) NOT NULL,
  `village_id` varchar(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `name` varchar(50) NOT NULL,
  `worship_place_category` varchar(2) NOT NULL,
  `address` varchar(100) DEFAULT NULL,
  `capacity` int DEFAULT NULL,
  `geom` geometry DEFAULT NULL,
  `lat` decimal(10,8) NOT NULL,
  `lng` decimal(11,8) NOT NULL,
  `description` text,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `worship_place`
--

INSERT INTO `worship_place` (`id`, `village_id`, `name`, `worship_place_category`, `address`, `capacity`, `geom`, `lat`, `lng`, `description`, `created_at`, `updated_at`) VALUES
('W1', '1', 'Masjid Ishlah', '01', 'Pariangan, Kec. Pariangan, Kabupaten Tanah Datar, Sumatera Barat ', 300, 0xe610000001030000000100000008000000aa28c5e6801f59402eac9f117654ddbfaa28c505801f59408abbe06cb956ddbfa928451c801f59406dbc2fcc0d57ddbfaa284535851f59400dbaae48b958ddbfaa28a510861f59400e89b1eccf56ddbfaa284535851f594043481f8e2156ddbfaa284519831f5940707855901355ddbfaa28c5e6801f59402eac9f117654ddbf, -0.45841019, 100.49237328, 'Masjid Islah Nagari Tuo Pariangan is a historic mosque located in Nagari Pariangan, Tanah Datar Regency, West Sumatra. This mosque is known as one of the oldest religious buildings in Minangkabau, with traditional architecture that reflects strong cultural and religious values. Built with a dominant Minangkabau architectural style, this mosque has a gonjong-shaped roof, similar to the Minangkabau traditional house (rumah gadang), which gives a magnificent and distinctive impression. This building uses natural materials such as wood and stone, which makes it in line with the surrounding natural environment which is beautiful and beautiful.', '2024-10-25 03:42:41', '2025-01-09 05:05:57'),
('W2', '1', 'Mesjid AT TAQWA Pariangan', '01', 'Pariangan, Kec. Pariangan, Kabupaten Tanah Datar, Sumatera Barat ', 250, 0xe6100000010300000001000000080000004f5e6bf6051f594064b19c518078dcbf505e4bcc041f594030bbb3cf7779dcbf505e4b45041f5940519666eda17adcbf4f5e6be8041f59406c4e670a267cdcbf505e0b18081f59409e13f8495e7cdcbf505ecb39081f59400d9f508c2e7bdcbf515e4b9c071f594069200111cf78dcbf4f5e6bf6051f594064b19c518078dcbf, -0.44497283, 100.48475636, 'At-Taqwa Pariangan Mosque is an iconic mosque located in Nagari Pariangan, Tanah Datar Regency, West Sumatra. The mosque is located in an area known as one of the oldest villages in Minangkabau, making it a spiritual and social center for the local community. Although not as old as the Islah Mosque, the At-Taqwa Mosque still has an important value in the history of the development of Islam in Pariangan. The architecture of this mosque is a blend of modern and traditional Minangkabau designs. The pyramid-shaped roof of the mosque is combined with local ornaments, providing a balance between contemporary aesthetics and local cultural values. The structure of this building was built using strong and durable materials, and was designed to accommodate a large number of worshipers, especially during the celebration of Islamic holidays.', '2024-10-25 03:44:16', '2025-01-09 05:06:32'),
('W3', NULL, 'Masjid Raya Al-Muttaqin', '01', 'Tarantang Village, Harau Subdistrict, Lima Puluh Kota Regency, West Sumatra Province', 100, 0xe610000001030000000100000005000000f5a554ee772a5940ba53f3e79f3abcbff5a59437762a594043365666e547bcbff5a514ff792a59408f7588e57c4ebcbff4a554727b2a5940ad453167dd40bcbff5a554ee772a5940ba53f3e79f3abcbf, -0.11042109, 100.66362499, 'Masjid Raya Al-Muttaqin adalah sebuah tempat ibadah Islam yang menakjubkan dan penuh makna, terletak di tengah Nagari Tarantang. Dibangun dengan arsitektur yang megah dan indah, masjid ini menjadi ikon keagamaan di Nagari Tarantang.', '2023-12-02 10:11:28', '2023-12-02 10:11:28'),
('W4', NULL, 'Mushalla Nurul Ikhlas', '02', 'Tarantang Village, Harau Subdistrict, Lima Puluh Kota Regency, West Sumatra Province', 50, 0xe61000000103000000010000000900000061c9dd3b7d2a594028bbc2bcab9ebcbf60c91d557e2a5940d015e93d7195bcbf62c95df87c2a5940b7dc313e2893bcbf61c9fda37c2a59407049cabd6896bcbf62c93d557c2a5940334bd83df895bcbf61c9dd2d7c2a5940b9779dbdd097bcbf60c95d717c2a5940a440843d9b98bcbf61c99df57b2a59409db00bbd629cbcbf61c9dd3b7d2a594028bbc2bcab9ebcbf, -0.11170828, 100.66388830, NULL, '2023-12-02 10:16:46', '2023-12-02 10:17:48');

-- --------------------------------------------------------

--
-- Table structure for table `worship_place_category`
--

CREATE TABLE `worship_place_category` (
  `id` varchar(2) NOT NULL,
  `name` varchar(25) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `worship_place_category`
--

INSERT INTO `worship_place_category` (`id`, `name`, `created_at`, `updated_at`) VALUES
('01', 'Masjid', NULL, NULL),
('02', 'Mushalla', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `worship_place_facility`
--

CREATE TABLE `worship_place_facility` (
  `id` varchar(2) NOT NULL,
  `name` varchar(25) NOT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `worship_place_facility`
--

INSERT INTO `worship_place_facility` (`id`, `name`, `created_at`, `updated_at`) VALUES
('01', 'Parking Area', '2025-01-03 21:21:28', '2025-01-03 21:21:28'),
('02', 'Toilet', '2025-01-03 21:31:32', '2025-01-03 21:31:32');

-- --------------------------------------------------------

--
-- Table structure for table `worship_place_facility_detail`
--

CREATE TABLE `worship_place_facility_detail` (
  `worship_place_id` varchar(2) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `worship_place_facility_id` varchar(2) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `worship_place_facility_detail`
--

INSERT INTO `worship_place_facility_detail` (`worship_place_id`, `worship_place_facility_id`) VALUES
('W1', '01'),
('W2', '01'),
('W1', '02'),
('W2', '02');

-- --------------------------------------------------------

--
-- Table structure for table `worship_place_gallery`
--

CREATE TABLE `worship_place_gallery` (
  `id` varchar(3) NOT NULL,
  `worship_place_id` varchar(2) NOT NULL,
  `url` text,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `worship_place_gallery`
--

INSERT INTO `worship_place_gallery` (`id`, `worship_place_id`, `url`, `created_at`, `updated_at`) VALUES
('011', 'W1', '1736445951_679bee11bc1fd3cbee48.jpg', '2025-01-09 05:05:57', '2025-01-09 05:05:57'),
('012', 'W1', '1736445951_dd38efdf3c742e1eaecc.jpeg', '2025-01-09 05:05:57', '2025-01-09 05:05:57'),
('013', 'W1', '1736445953_f6bb3edfbab20a02ade9.webp', '2025-01-09 05:05:57', '2025-01-09 05:05:57'),
('014', 'W2', '1736445968_22c16b663b1a218fdb9f.jpg', '2025-01-09 05:06:32', '2025-01-09 05:06:32'),
('015', 'W2', '1736445968_252999ada11aa831c1bb.jpg', '2025-01-09 05:06:32', '2025-01-09 05:06:32');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `announcement`
--
ALTER TABLE `announcement`
  ADD PRIMARY KEY (`id`),
  ADD KEY `admin_id` (`admin_id`);

--
-- Indexes for table `attraction`
--
ALTER TABLE `attraction`
  ADD PRIMARY KEY (`id`),
  ADD KEY `attraction_category` (`attraction_category`);

--
-- Indexes for table `attraction_category`
--
ALTER TABLE `attraction_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `attraction_facility`
--
ALTER TABLE `attraction_facility`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `attraction_facility_detail`
--
ALTER TABLE `attraction_facility_detail`
  ADD PRIMARY KEY (`attraction_id`,`attraction_facility_id`),
  ADD KEY `facility_id` (`attraction_facility_id`);

--
-- Indexes for table `attraction_gallery`
--
ALTER TABLE `attraction_gallery`
  ADD PRIMARY KEY (`id`),
  ADD KEY `attraction_id` (`attraction_id`);

--
-- Indexes for table `auth_activation_attempts`
--
ALTER TABLE `auth_activation_attempts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `auth_groups`
--
ALTER TABLE `auth_groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `auth_groups_permissions`
--
ALTER TABLE `auth_groups_permissions`
  ADD KEY `auth_groups_permissions_permission_id_foreign` (`permission_id`),
  ADD KEY `group_id_permission_id` (`group_id`,`permission_id`);

--
-- Indexes for table `auth_groups_users`
--
ALTER TABLE `auth_groups_users`
  ADD KEY `auth_groups_users_user_id_foreign` (`user_id`),
  ADD KEY `group_id_user_id` (`group_id`,`user_id`);

--
-- Indexes for table `auth_logins`
--
ALTER TABLE `auth_logins`
  ADD PRIMARY KEY (`id`),
  ADD KEY `email` (`email`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `auth_permissions`
--
ALTER TABLE `auth_permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `auth_reset_attempts`
--
ALTER TABLE `auth_reset_attempts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `auth_tokens`
--
ALTER TABLE `auth_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `auth_tokens_user_id_foreign` (`user_id`),
  ADD KEY `selector` (`selector`);

--
-- Indexes for table `auth_users_permissions`
--
ALTER TABLE `auth_users_permissions`
  ADD KEY `auth_users_permissions_permission_id_foreign` (`permission_id`),
  ADD KEY `user_id_permission_id` (`user_id`,`permission_id`);

--
-- Indexes for table `city`
--
ALTER TABLE `city`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `country`
--
ALTER TABLE `country`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `culinary_place`
--
ALTER TABLE `culinary_place`
  ADD PRIMARY KEY (`id`),
  ADD KEY `village_id` (`village_id`);

--
-- Indexes for table `culinary_place_facility`
--
ALTER TABLE `culinary_place_facility`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `culinary_place_facility_detail`
--
ALTER TABLE `culinary_place_facility_detail`
  ADD PRIMARY KEY (`culinary_place_id`,`culinary_place_facility_id`),
  ADD KEY `culinary_facility_id` (`culinary_place_facility_id`);

--
-- Indexes for table `culinary_place_gallery`
--
ALTER TABLE `culinary_place_gallery`
  ADD PRIMARY KEY (`id`),
  ADD KEY `culinary_place_gallery_culinary_place_id_foreign` (`culinary_place_id`);

--
-- Indexes for table `culinary_product`
--
ALTER TABLE `culinary_product`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `culinary_product_detail`
--
ALTER TABLE `culinary_product_detail`
  ADD PRIMARY KEY (`culinary_place_id`,`culinary_product_id`),
  ADD KEY `culinary_product_detail_culinary_product_id_foreign` (`culinary_product_id`),
  ADD KEY `culinary_product_detail_culinary_place_id_foreign` (`culinary_place_id`);

--
-- Indexes for table `homestay`
--
ALTER TABLE `homestay`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`),
  ADD KEY `homestay_owner_foreign` (`owner`);

--
-- Indexes for table `homestay_additional_amenities`
--
ALTER TABLE `homestay_additional_amenities`
  ADD PRIMARY KEY (`homestay_id`,`additional_amenities_id`),
  ADD KEY `homestay_additional_amenities_ibfk_1` (`homestay_id`);

--
-- Indexes for table `homestay_certification`
--
ALTER TABLE `homestay_certification`
  ADD PRIMARY KEY (`homestay_id`,`certification_id`),
  ADD KEY `homestay_id` (`homestay_id`);

--
-- Indexes for table `homestay_facility`
--
ALTER TABLE `homestay_facility`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `homestay_facility_detail`
--
ALTER TABLE `homestay_facility_detail`
  ADD PRIMARY KEY (`homestay_id`,`facility_id`),
  ADD KEY `homestay_facility_detail_facility_id_foreign` (`facility_id`),
  ADD KEY `homestay_facility_detail_homestay_id_foreign` (`homestay_id`);

--
-- Indexes for table `homestay_gallery`
--
ALTER TABLE `homestay_gallery`
  ADD PRIMARY KEY (`id`),
  ADD KEY `homestay_gallery_homestay_id_foreign` (`homestay_id`);

--
-- Indexes for table `homestay_unit`
--
ALTER TABLE `homestay_unit`
  ADD PRIMARY KEY (`homestay_id`,`unit_type`,`unit_number`),
  ADD KEY `homestay_unit_unit_type_foreign` (`unit_type`),
  ADD KEY `homestay_unit_homestay_id_foreign` (`homestay_id`);

--
-- Indexes for table `homestay_unit_facility`
--
ALTER TABLE `homestay_unit_facility`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `homestay_unit_facility_detail`
--
ALTER TABLE `homestay_unit_facility_detail`
  ADD PRIMARY KEY (`homestay_id`,`unit_type`,`unit_number`,`facility_id`),
  ADD KEY `facility_id` (`facility_id`);

--
-- Indexes for table `homestay_unit_gallery`
--
ALTER TABLE `homestay_unit_gallery`
  ADD PRIMARY KEY (`id`),
  ADD KEY `homestay_id` (`homestay_id`,`unit_type`,`unit_number`);

--
-- Indexes for table `homestay_unit_type`
--
ALTER TABLE `homestay_unit_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `province`
--
ALTER TABLE `province`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reservation`
--
ALTER TABLE `reservation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reservation_ibfk_1` (`customer_id`);

--
-- Indexes for table `reservation_homestay_additional_amenities_detail`
--
ALTER TABLE `reservation_homestay_additional_amenities_detail`
  ADD PRIMARY KEY (`homestay_id`,`additional_amenities_id`,`reservation_id`),
  ADD KEY `reservation_homestay_additional_amenities_detail_ibfk_2` (`reservation_id`),
  ADD KEY `reservation_homestay_additional_amenities_detail_ibfk_1` (`homestay_id`,`additional_amenities_id`);

--
-- Indexes for table `reservation_homestay_unit_detail`
--
ALTER TABLE `reservation_homestay_unit_detail`
  ADD PRIMARY KEY (`homestay_id`,`unit_type`,`unit_number`,`date`),
  ADD KEY `reservation_homestay_unit_detail_ibfk_2` (`reservation_id`),
  ADD KEY `reservation_homestay_unit_detail_ibfk_1` (`homestay_id`,`unit_type`,`unit_number`);

--
-- Indexes for table `reservation_homestay_unit_detail_backup`
--
ALTER TABLE `reservation_homestay_unit_detail_backup`
  ADD PRIMARY KEY (`homestay_id`,`unit_type`,`unit_number`,`date`,`reservation_id`),
  ADD KEY `reservation_homestay_unit_detail_backup_ibfk_2` (`reservation_id`),
  ADD KEY `reservation_homestay_unit_detail_backup_ibfk_1` (`homestay_id`,`unit_type`,`unit_number`);

--
-- Indexes for table `souvenir_place`
--
ALTER TABLE `souvenir_place`
  ADD PRIMARY KEY (`id`),
  ADD KEY `village_id` (`village_id`);

--
-- Indexes for table `souvenir_place_facility`
--
ALTER TABLE `souvenir_place_facility`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `souvenir_place_facility_detail`
--
ALTER TABLE `souvenir_place_facility_detail`
  ADD PRIMARY KEY (`souvenir_place_id`,`souvenir_place_facility_id`),
  ADD KEY `souvenir_facility_id` (`souvenir_place_facility_id`);

--
-- Indexes for table `souvenir_place_gallery`
--
ALTER TABLE `souvenir_place_gallery`
  ADD PRIMARY KEY (`id`),
  ADD KEY `souvenir_place_gallery_souvenir_place_id_foreign` (`souvenir_place_id`);

--
-- Indexes for table `souvenir_product`
--
ALTER TABLE `souvenir_product`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `souvenir_product_detail`
--
ALTER TABLE `souvenir_product_detail`
  ADD PRIMARY KEY (`souvenir_place_id`,`souvenir_product_id`),
  ADD KEY `souvenir_product_detail_souvenir_product_id_foreign` (`souvenir_product_id`),
  ADD KEY `souvenir_product_detail_souvenir_place_id_foreign` (`souvenir_place_id`);

--
-- Indexes for table `subdistrict`
--
ALTER TABLE `subdistrict`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `village`
--
ALTER TABLE `village`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `village_gallery`
--
ALTER TABLE `village_gallery`
  ADD PRIMARY KEY (`id`),
  ADD KEY `village_id` (`village_id`);

--
-- Indexes for table `worship_place`
--
ALTER TABLE `worship_place`
  ADD PRIMARY KEY (`id`),
  ADD KEY `worship_place_worship_place_category_foreign` (`worship_place_category`),
  ADD KEY `village_id` (`village_id`);

--
-- Indexes for table `worship_place_category`
--
ALTER TABLE `worship_place_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `worship_place_facility`
--
ALTER TABLE `worship_place_facility`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `worship_place_facility_detail`
--
ALTER TABLE `worship_place_facility_detail`
  ADD PRIMARY KEY (`worship_place_id`,`worship_place_facility_id`),
  ADD KEY `worship_facility_id` (`worship_place_facility_id`);

--
-- Indexes for table `worship_place_gallery`
--
ALTER TABLE `worship_place_gallery`
  ADD PRIMARY KEY (`id`),
  ADD KEY `worship_place_gallery_worship_place_id_foreign` (`worship_place_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `auth_activation_attempts`
--
ALTER TABLE `auth_activation_attempts`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `auth_groups`
--
ALTER TABLE `auth_groups`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `auth_logins`
--
ALTER TABLE `auth_logins`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=825;

--
-- AUTO_INCREMENT for table `auth_permissions`
--
ALTER TABLE `auth_permissions`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `auth_reset_attempts`
--
ALTER TABLE `auth_reset_attempts`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `auth_tokens`
--
ALTER TABLE `auth_tokens`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `announcement`
--
ALTER TABLE `announcement`
  ADD CONSTRAINT `announcement_ibfk_1` FOREIGN KEY (`admin_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `attraction`
--
ALTER TABLE `attraction`
  ADD CONSTRAINT `attraction_ibfk_1` FOREIGN KEY (`attraction_category`) REFERENCES `attraction_category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `attraction_facility_detail`
--
ALTER TABLE `attraction_facility_detail`
  ADD CONSTRAINT `attraction_facility_detail_ibfk_2` FOREIGN KEY (`attraction_facility_id`) REFERENCES `attraction_facility` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `attraction_facility_detail_ibfk_3` FOREIGN KEY (`attraction_id`) REFERENCES `attraction` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `attraction_gallery`
--
ALTER TABLE `attraction_gallery`
  ADD CONSTRAINT `attraction_gallery_ibfk_1` FOREIGN KEY (`attraction_id`) REFERENCES `attraction` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `auth_groups_permissions`
--
ALTER TABLE `auth_groups_permissions`
  ADD CONSTRAINT `auth_groups_permissions_group_id_foreign` FOREIGN KEY (`group_id`) REFERENCES `auth_groups` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `auth_groups_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `auth_permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `auth_groups_users`
--
ALTER TABLE `auth_groups_users`
  ADD CONSTRAINT `auth_groups_users_group_id_foreign` FOREIGN KEY (`group_id`) REFERENCES `auth_groups` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `auth_groups_users_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `auth_tokens`
--
ALTER TABLE `auth_tokens`
  ADD CONSTRAINT `auth_tokens_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `auth_users_permissions`
--
ALTER TABLE `auth_users_permissions`
  ADD CONSTRAINT `auth_users_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `auth_permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `auth_users_permissions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `culinary_place`
--
ALTER TABLE `culinary_place`
  ADD CONSTRAINT `culinary_place_ibfk_1` FOREIGN KEY (`village_id`) REFERENCES `village` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `culinary_place_facility_detail`
--
ALTER TABLE `culinary_place_facility_detail`
  ADD CONSTRAINT `culinary_place_facility_detail_ibfk_1` FOREIGN KEY (`culinary_place_facility_id`) REFERENCES `culinary_place_facility` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `culinary_place_facility_detail_ibfk_2` FOREIGN KEY (`culinary_place_id`) REFERENCES `culinary_place` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `culinary_place_gallery`
--
ALTER TABLE `culinary_place_gallery`
  ADD CONSTRAINT `culinary_place_gallery_culinary_place_id_foreign` FOREIGN KEY (`culinary_place_id`) REFERENCES `culinary_place` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `culinary_product_detail`
--
ALTER TABLE `culinary_product_detail`
  ADD CONSTRAINT `culinary_product_detail_culinary_place_id_foreign` FOREIGN KEY (`culinary_place_id`) REFERENCES `culinary_place` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `culinary_product_detail_culinary_product_id_foreign` FOREIGN KEY (`culinary_product_id`) REFERENCES `culinary_product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `homestay`
--
ALTER TABLE `homestay`
  ADD CONSTRAINT `homestay_owner_foreign` FOREIGN KEY (`owner`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `homestay_additional_amenities`
--
ALTER TABLE `homestay_additional_amenities`
  ADD CONSTRAINT `homestay_additional_amenities_ibfk_1` FOREIGN KEY (`homestay_id`) REFERENCES `homestay` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `homestay_certification`
--
ALTER TABLE `homestay_certification`
  ADD CONSTRAINT `homestay_certification_ibfk_1` FOREIGN KEY (`homestay_id`) REFERENCES `homestay` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `homestay_facility_detail`
--
ALTER TABLE `homestay_facility_detail`
  ADD CONSTRAINT `homestay_facility_detail_facility_id_foreign` FOREIGN KEY (`facility_id`) REFERENCES `homestay_facility` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `homestay_facility_detail_homestay_id_foreign` FOREIGN KEY (`homestay_id`) REFERENCES `homestay` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `homestay_gallery`
--
ALTER TABLE `homestay_gallery`
  ADD CONSTRAINT `homestay_gallery_homestay_id_foreign` FOREIGN KEY (`homestay_id`) REFERENCES `homestay` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `homestay_unit`
--
ALTER TABLE `homestay_unit`
  ADD CONSTRAINT `homestay_unit_homestay_id_foreign` FOREIGN KEY (`homestay_id`) REFERENCES `homestay` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `homestay_unit_unit_type_foreign` FOREIGN KEY (`unit_type`) REFERENCES `homestay_unit_type` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `homestay_unit_facility_detail`
--
ALTER TABLE `homestay_unit_facility_detail`
  ADD CONSTRAINT `homestay_unit_facility_detail_ibfk_1` FOREIGN KEY (`homestay_id`,`unit_type`,`unit_number`) REFERENCES `homestay_unit` (`homestay_id`, `unit_type`, `unit_number`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `homestay_unit_facility_detail_ibfk_2` FOREIGN KEY (`facility_id`) REFERENCES `homestay_unit_facility` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `homestay_unit_gallery`
--
ALTER TABLE `homestay_unit_gallery`
  ADD CONSTRAINT `homestay_unit_gallery_ibfk_1` FOREIGN KEY (`homestay_id`,`unit_type`,`unit_number`) REFERENCES `homestay_unit` (`homestay_id`, `unit_type`, `unit_number`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `reservation_homestay_additional_amenities_detail`
--
ALTER TABLE `reservation_homestay_additional_amenities_detail`
  ADD CONSTRAINT `reservation_homestay_additional_amenities_detail_ibfk_1` FOREIGN KEY (`homestay_id`,`additional_amenities_id`) REFERENCES `homestay_additional_amenities` (`homestay_id`, `additional_amenities_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `reservation_homestay_additional_amenities_detail_ibfk_2` FOREIGN KEY (`reservation_id`) REFERENCES `reservation` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `reservation_homestay_unit_detail`
--
ALTER TABLE `reservation_homestay_unit_detail`
  ADD CONSTRAINT `reservation_homestay_unit_detail_ibfk_1` FOREIGN KEY (`homestay_id`,`unit_type`,`unit_number`) REFERENCES `homestay_unit` (`homestay_id`, `unit_type`, `unit_number`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `reservation_homestay_unit_detail_ibfk_2` FOREIGN KEY (`reservation_id`) REFERENCES `reservation` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `reservation_homestay_unit_detail_backup`
--
ALTER TABLE `reservation_homestay_unit_detail_backup`
  ADD CONSTRAINT `reservation_homestay_unit_detail_backup_ibfk_1` FOREIGN KEY (`homestay_id`,`unit_type`,`unit_number`) REFERENCES `homestay_unit` (`homestay_id`, `unit_type`, `unit_number`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `reservation_homestay_unit_detail_backup_ibfk_2` FOREIGN KEY (`reservation_id`) REFERENCES `reservation` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `souvenir_place`
--
ALTER TABLE `souvenir_place`
  ADD CONSTRAINT `souvenir_place_ibfk_1` FOREIGN KEY (`village_id`) REFERENCES `village` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `souvenir_place_facility_detail`
--
ALTER TABLE `souvenir_place_facility_detail`
  ADD CONSTRAINT `souvenir_place_facility_detail_ibfk_1` FOREIGN KEY (`souvenir_place_id`) REFERENCES `souvenir_place` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `souvenir_place_facility_detail_ibfk_2` FOREIGN KEY (`souvenir_place_facility_id`) REFERENCES `souvenir_place_facility` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `souvenir_place_gallery`
--
ALTER TABLE `souvenir_place_gallery`
  ADD CONSTRAINT `souvenir_place_gallery_souvenir_place_id_foreign` FOREIGN KEY (`souvenir_place_id`) REFERENCES `souvenir_place` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `souvenir_product_detail`
--
ALTER TABLE `souvenir_product_detail`
  ADD CONSTRAINT `souvenir_product_detail_souvenir_place_id_foreign` FOREIGN KEY (`souvenir_place_id`) REFERENCES `souvenir_place` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `souvenir_product_detail_souvenir_product_id_foreign` FOREIGN KEY (`souvenir_product_id`) REFERENCES `souvenir_product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `village_gallery`
--
ALTER TABLE `village_gallery`
  ADD CONSTRAINT `village_gallery_ibfk_1` FOREIGN KEY (`village_id`) REFERENCES `village` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `worship_place`
--
ALTER TABLE `worship_place`
  ADD CONSTRAINT `worship_place_ibfk_1` FOREIGN KEY (`village_id`) REFERENCES `village` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `worship_place_worship_place_category_foreign` FOREIGN KEY (`worship_place_category`) REFERENCES `worship_place_category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `worship_place_facility_detail`
--
ALTER TABLE `worship_place_facility_detail`
  ADD CONSTRAINT `worship_place_facility_detail_ibfk_1` FOREIGN KEY (`worship_place_facility_id`) REFERENCES `worship_place_facility` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `worship_place_facility_detail_ibfk_2` FOREIGN KEY (`worship_place_id`) REFERENCES `worship_place` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `worship_place_gallery`
--
ALTER TABLE `worship_place_gallery`
  ADD CONSTRAINT `worship_place_gallery_worship_place_id_foreign` FOREIGN KEY (`worship_place_id`) REFERENCES `worship_place` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
