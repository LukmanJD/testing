-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: sql211.infinityfree.com
-- Generation Time: Jul 15, 2026 at 11:54 AM
-- Server version: 11.4.12-MariaDB
-- PHP Version: 7.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `if0_42068249_harau`
--

-- --------------------------------------------------------

--
-- Table structure for table `announcement`
--

CREATE TABLE `announcement` (
  `id` varchar(5) NOT NULL,
  `admin_id` int(10) UNSIGNED DEFAULT NULL,
  `announcement` text DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL
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
  `id` varchar(3) NOT NULL,
  `attraction_category` varchar(2) NOT NULL DEFAULT '2',
  `name` varchar(40) NOT NULL,
  `address` text NOT NULL,
  `open` time NOT NULL,
  `close` time NOT NULL,
  `price` int(11) NOT NULL DEFAULT 0,
  `employee_name` varchar(25) DEFAULT NULL,
  `phone` varchar(13) DEFAULT NULL,
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
('A14', '2', 'Air Terjun Sarasah Bunta', 'Tarantang village, Harau Subdistrict, Lima Puluh Kota Regency, West Sumatra Province, Indonesia,', '00:00:00', '23:59:00', 0, NULL, NULL, 'Air terjun Sarasah Bunta merupakan air terjun alami yang terbentuk akibat patahan ', 'A4-V.mp4', '-0.10859590', '100.67764144', 0xe610000001030000000100000006000000b8cd337a5e2b5940baccfadef0ccbbbf3be9d89c5e2b5940d0dbaf6d17bbbbbf470ac09a5e2b5940a82bc864abaabbbf27c286a7572b5940f4d7af645cabbbbf5a8184d5562b5940b1d018f730c5bbbfb8cd337a5e2b5940baccfadef0ccbbbf, '2023-11-26 09:19:36', '2023-12-22 04:38:25'),
('A15', '2', 'Panorama Aka Barayun', 'Tarantang village, Harau Subdistrict, Lima Puluh Kota Regency, West Sumatra Province, Indonesia,', '00:00:00', '23:59:00', 0, NULL, NULL, 'Panorama Aka Barayun merupakan objek wisata dengan daya tarik air terjun dan tebing lembah harau yang ditumbuhi oleh tumbuhan merambat.', '', '-0.10107162', '100.66675139', 0xe61000000103000000010000000600000034a7050eac2a594046287466d4dfb9bf6790cc34ab2a59403bce44438cf8b9bf0e67026eab2a5940e0ca23c9bd0ababf66c71da1ac2a594015634ff16e1bbabf9c9d561bad2a59403c56dfafb8eeb9bf34a7050eac2a594046287466d4dfb9bf, '2023-11-26 09:26:07', '2023-12-22 04:31:35'),
('A16', '2', 'Harau Dream Park', 'Tarantang village, Harau Subdistrict, Lima Puluh Kota Regency, West Sumatra Province, Indonesia,', '09:00:00', '17:00:00', 30000, 'Kampuang Sarosah', '081360813344', 'Harau Dream Park merupakan tempat wisata hits di Sumatera Barat yang dilengkapi dengan replika ikon sejumlah negara di dunia. Objek-objek wisata yang terdapat pada Kampuang Sarosah yaitu Kampung Eropa,  Kampuang Korea, Kampung Jepang dan Kampung Sarosah', '', '-0.11329513', '100.66964846', 0xe61000000103000000010000002a00000013e13685db2a5940be6425dee800bdbf4c99e5fcde2a5940a4efc1adb308bdbf5d4cf931e22a5940a594a510a717bdbfa2e9b2b9e62a59401372103a0921bdbfa1fa202eed2a5940b569cfd9c025bdbfafae4cf0f42a59402b61960bcf2abdbf7beea941fd2a5940474cbb5ebb30bdbf72de62f2042b5940b0206a2e7934bdbfb57691f80b2b5940c62a4aae0738bdbf20d79f27122b5940cf294c08eb39bdbf05fcf93a192b5940dd342a2e963bbdbf0a915f81202b5940773340f5513ebdbfce18492f282b594044c0847e6442bdbf5339b37e2f2b59406eb2fcaf2946bdbfe761d310362b59401b6f6568c049bdbfba17f3ce3c2b5940f131f546ef4cbdbffe8c3d41432b59401102d1176b4dbdbf4c112a82492b5940c26e758c6d4abdbf42226de34f2b5940f21850359b43bdbfbc5983f7552b594083f30c8e503bbdbf01ffced55a2b5940cff197370333bdbfd63a71395e2b594024f1f274ae28bdbfc350e2ce602b59403e97461f351ebdbf92674de2622b5940fc7a74d99e0fbdbf67cb5e5b642b59406db30ccc65febcbf6d5a84bd642b594024c44b265de9bcbf974ffb52642b594087a5a22dbed3bcbf927e56f4622b5940de731e1d70c0bcbf8dc756e1602b5940cae6a20846b1bcbffffe39715e2b594002be3676e4a3bcbf6c4bd3565b2b5940b66fa422049abcbf8626e4de572b59408884ade13b94bcbfb7a283e4532b5940ea96fcd33693bcbfcb7b41b04f2b594004a1061dbe96bcbfbc7e1c284b2b5940ecc6b3b21a9ebcbf416fe0c4462b59404c38b2fa3ca9bcbf97f2107c422b5940b42506dc4eb6bcbf2d93e1783e2b5940f19b679192c3bcbfdcba9ba73a2b59400cace3f8a1d2bcbf3d450e11372b5940f08b4b55dae2bcbfecc8ec87332b5940fca65599cef3bcbf13e13685db2a5940be6425dee800bdbf, '2023-11-26 09:27:54', '2023-12-22 04:23:38'),
('A17', '1', 'Geopark Lembah Harau', 'Tarantang village, Harau Subdistrict, Lima Puluh Kota Regency, West Sumatra Province, Indonesia,', '00:00:00', '23:59:00', 0, 'Edo', '081261499095', 'Geopark Lembah Harau dikenal karena beragam formasi batuan yang unik. Situs geologi di kawasan ini memberikan pandangan yang menarik tentang sejarah geologi dan proses alam yang terjadi selama jutaan tahun.<br><br> Kawasan geopark ini ditandai oleh tebing-tebing curam yang mengelilingi lembah, menciptakan pemandangan spektakuler. Keberadaan tebing yang tinggi dan terjal memberikan sentuhan dramatis pada lanskap alam.<br><br> Ketinggian tebing batu pada Geopark Lembah Harau berkisar antara 30m - 100m. Batuan pada tebing merupakan perselingan konglomerat dan batupasir dengan ketinggian ± 100 meter termasuk ke dalam formasi <i>Brani</i> berumur <i>Oligosen (34-23 juta tahun lalu)</i> serta mencirikan endapan fluvial dari sungai purba.<br><br> Terbentuknya lembah harau dikarenakan adanya patahan turun atau block yang turun membentuk lembah yang cukup luas dan datar. Salah satu tanda-tanda atau untuk melihat dimana lokasi patahannya adalah dengan adanya air terjun. Dengan begitu, dapat disimpulkan bahwa dahulu ada sungai yang kemudian terpotong akibat adanya patahan turun, sehingga membentuk air terjun. ', 'geopark_lembah_harau.mp4', '-0.10422544', '100.67413855', 0xe61000000103000000010000002f000000434e0416252b5940e01136b884aebabf1bb73de6282b59404f3dd2e0b6b6babfa22f18b72c2b5940e26def6481c0babf8294336f302b5940ceb0074955c9babf8ceb2983342b5940869f49acd6d3babf07fb65e6382b59409a1c88765fdfbabfd54d18833d2b5940ce1ced139beababf26dea6e4412b594090c4268d2cf4babf4d6551d8452b594043fc68ddabfbbabfbd564277492b594075e789e76c01bbbf5ce3d81f4d2b5940c8f610436106bbbfcb619c64502b5940739b15f6590abbbffff5c07d532b5940a02ef76e980dbbbf6f18607a562b5940b598e9a8b40fbbbf79d1b249592b59402c0fd253e410bbbf4e5d9e735c2b59400e68e90ab611bbbf52e3ef285f2b5940dbb5ce09eb10bbbf21e0b5f0612b5940b1fe2a1b310ebbbf02a72d64642b59409e95b4e21b0abbbf905841c2662b5940b06e6182bf04bbbffad74d84682b5940c1e84da0e3febabf59f157126a2b59407d6f78e68af7babfbd5708066b2b5940c061fdfa7cefbabfed65db696b2b59402b306475abe7babf5245f12a6b2b59406e22e9899ddfbabfedde40376a2b5940ed20c033ebd6babfc54ec296682b594084a7469edacfbabf96010c70662b5940f0f1ae1f07cababfa3b899c0632b59406e6b0bcf4bc5babfabe001af602b59408819750877c2babf53bb15785d2b59409e67a2be1bc1babfd2d160095a2b5940d7f6764b72c0babf57bf886c562b59404e0e9f7422c1babfa0c211a4522b594030c676ad73c2babf8aa658da4e2b59402e24bb2decc4babfb0743e3c4b2b594065cf543ebac7babf58c51b99472b59400f15996f33cbbabf4e0f6503442b59404ed76e168acfbabf80153b75402b5940ff756eda8cd3babfff428f183d2b59404214820b68d8babfa1bc8fa3392b5940aded3724ffddbabf61ab5f44362b594018096d3997e2babfb6700ff8322b5940eb47d455cbe7babf2f9974a52f2b5940f7b64f7dd6ebbabf2511d0332c2b59400426cba4e1efbabf80db6edd282b594053fa53f4d1f3babf434e0416252b5940e01136b884aebabf, '2023-12-21 20:40:13', '2023-12-21 20:40:13'),
('A18', '2', 'Air Terjun Sarasah Aie Luluih', 'Tarantang village, Harau Subdistrict, Lima Puluh Kota Regency, West Sumatra Province, Indonesia,', '00:00:00', '23:59:00', 0, NULL, NULL, 'Air terjun Sarasah Bunta merupakan air terjun alami yang terbentuk akibat patahan ', '', '-0.10811163', '100.67513731', 0xe6100000010300000001000000050000009ab01e73352b59400fd12a2b34adbbbf4f3a36a7372b59400fd12a2b34adbbbf4f3a36a7372b5940e67d56781bc4bbbf9ab01e73352b5940e67d56781bc4bbbf9ab01e73352b59400fd12a2b34adbbbf, '2023-12-22 04:41:50', '2023-12-22 04:41:50'),
('A19', '2', 'Harau Sky Dream World', 'Tarantang village, Harau Subdistrict, Lima Puluh Kota Regency, West Sumatra Province, Indonesia,', '09:00:00', '17:00:00', 30000, 'Harau Sky', '081212229832', 'Wisata Harau Sky Dream World menyuguhkan wahana waterpark, kemudian spot foto dream land, spot mini world di negeri air Venezia dan Swiss. Selain itu,  juga ada Lounge Sunset Wonderland Harau atau ruang santai untuk melihat keindahan sunset dengan view Lembah Harau.', '', '-0.10369996', '100.66563991', 0xe610000001030000000100000011000000311723d8992a5940f5e7cba0148cbabf8743c2399b2a594074939c3cfa99babf2008f3cb9e2a5940e7340bb43ba4babf41182e61a32a5940e6a617c627aebabf9eaffe74a82a5940ea549ee51eb7babf48b6042aad2a59404f519a722abebabf1637c9eab12a59409d83674293c4babf3771cd78b62a5940e797778b76cbbabf2fe708cfba2a59406f34db70b3d3babf872062debe2a594069caa9f81addbabf2668dd50c22a594086a11f5734e7babf065acbaec52a59400a20c6b5ebefbabfd5e0c7e2c82a594084c8337914f8babf38e27fe1cb2a59403e59315c1d00bbbf4fa5b09cce2a5940311a434afd06bbbf2af16f86d12a59409af27c618d0ebbbf311723d8992a5940f5e7cba0148cbabf, '2023-12-22 04:49:58', '2023-12-22 04:49:58');

-- --------------------------------------------------------

--
-- Table structure for table `attraction_category`
--

CREATE TABLE `attraction_category` (
  `id` varchar(2) NOT NULL,
  `name` varchar(20) NOT NULL
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
  `id` varchar(3) NOT NULL,
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
  `attraction_id` varchar(3) NOT NULL,
  `attraction_facility_id` varchar(3) NOT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `attraction_facility_detail`
--

INSERT INTO `attraction_facility_detail` (`attraction_id`, `attraction_facility_id`, `created_at`, `updated_at`) VALUES
('A14', '01', '2023-12-22 04:38:25', '2023-12-22 04:38:25'),
('A14', '02', '2023-12-22 04:38:25', '2023-12-22 04:38:25'),
('A15', '01', '2023-12-22 04:31:35', '2023-12-22 04:31:35'),
('A15', '02', '2023-12-22 04:31:35', '2023-12-22 04:31:35'),
('A16', '01', '2023-12-22 04:23:38', '2023-12-22 04:23:38'),
('A18', '01', '2023-12-22 04:41:50', '2023-12-22 04:41:50'),
('A18', '02', '2023-12-22 04:41:50', '2023-12-22 04:41:50'),
('A19', '01', '2023-12-22 04:49:58', '2023-12-22 04:49:58'),
('A19', '02', '2023-12-22 04:49:58', '2023-12-22 04:49:58');

-- --------------------------------------------------------

--
-- Table structure for table `attraction_gallery`
--

CREATE TABLE `attraction_gallery` (
  `id` varchar(3) NOT NULL,
  `attraction_id` varchar(3) NOT NULL,
  `url` text NOT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `attraction_gallery`
--

INSERT INTO `attraction_gallery` (`id`, `attraction_id`, `url`, `created_at`, `updated_at`) VALUES
('001', 'A16', 'A6-1.jpg', '2023-12-22 04:23:38', '2023-12-22 04:23:38'),
('002', 'A16', 'A6-2.jpg', '2023-12-22 04:23:38', '2023-12-22 04:23:38'),
('003', 'A16', 'A6-3.jpg', '2023-12-22 04:23:38', '2023-12-22 04:23:38'),
('006', 'A15', 'A5-1.jpg', '2023-12-22 04:31:35', '2023-12-22 04:31:35'),
('007', 'A15', 'A5-2.jpg', '2023-12-22 04:31:35', '2023-12-22 04:31:35'),
('008', 'A15', 'A5-3.jpg', '2023-12-22 04:31:35', '2023-12-22 04:31:35'),
('009', 'A14', 'A4-1.jpg', '2023-12-22 04:38:25', '2023-12-22 04:38:25'),
('010', 'A14', 'A4-2.jpg', '2023-12-22 04:38:25', '2023-12-22 04:38:25'),
('011', 'A18', 'A8-1.jpg', '2023-12-22 04:41:50', '2023-12-22 04:41:50'),
('012', 'A18', 'A8-2.jpg', '2023-12-22 04:41:50', '2023-12-22 04:41:50'),
('013', 'A18', 'A8-3.jpg', '2023-12-22 04:41:50', '2023-12-22 04:41:50'),
('014', 'A19', 'A9-1.jpg', '2023-12-22 04:49:58', '2023-12-22 04:49:58'),
('015', 'A19', 'A9-2.jpg', '2023-12-22 04:49:58', '2023-12-22 04:49:58'),
('016', 'A17', 'A7-1.jpg', '2023-12-22 04:49:58', '2023-12-22 04:49:58'),
('017', 'A17', 'A7-2.jpg', '2023-12-22 04:49:58', '2023-12-22 04:49:58'),
('018', 'A17', 'A7-3.jpg', '2023-12-22 04:49:58', '2023-12-22 04:49:58'),
('019', 'A17', 'A7-4.jpg', '2023-12-22 04:49:58', '2023-12-22 04:49:58'),
('020', 'A17', 'A7-5.jpg', '2023-12-22 04:49:58', '2023-12-22 04:49:58'),
('021', 'A14', 'A4-3.jpg', '2023-12-22 04:49:58', '2023-12-22 04:49:58'),
('022', 'A19', 'A9-3.jpg', '2023-12-22 04:49:58', '2023-12-22 04:49:58');

-- --------------------------------------------------------

--
-- Table structure for table `attraction_ticket_price`
--

CREATE TABLE `attraction_ticket_price` (
  `id` varchar(2) NOT NULL,
  `attraction_id` varchar(2) NOT NULL,
  `name` varchar(50) NOT NULL,
  `price` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `attraction_ticket_price`
--

INSERT INTO `attraction_ticket_price` (`id`, `attraction_id`, `name`, `price`, `created_at`, `updated_at`) VALUES
('01', 'A6', 'Kampuang Sarosah', 5000, '2023-11-30 19:00:34', '2023-11-30 19:00:34'),
('02', 'A6', 'Asian Heritage', 20000, '2023-11-30 19:01:02', '2023-11-30 19:01:02'),
('03', 'A6', 'Kampung Eropa', 20000, '2023-11-30 19:01:24', '2023-11-30 19:01:24'),
('04', 'A6', 'Secret Garden', 15000, '2023-11-30 19:01:41', '2023-11-30 19:01:41'),
('05', 'A6', 'Paket Terusan', 40000, '2023-11-30 19:02:37', '2023-11-30 19:02:37'),
('06', 'A9', 'Tiket Masuk Pengunjung ', 35000, '2024-01-11 14:15:23', '2024-01-11 14:15:23'),
('07', 'A9', 'Tiket Masuk Anak Usia 2 Tahun ke Bawah', 0, '2024-01-11 14:17:11', '2024-01-11 14:17:11');

-- --------------------------------------------------------

--
-- Table structure for table `auth_activation_attempts`
--

CREATE TABLE `auth_activation_attempts` (
  `id` int(10) UNSIGNED NOT NULL,
  `ip_address` varchar(255) NOT NULL,
  `user_agent` varchar(255) NOT NULL,
  `token` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `auth_groups`
--

CREATE TABLE `auth_groups` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

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
  `group_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `permission_id` int(10) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `auth_groups_users`
--

CREATE TABLE `auth_groups_users` (
  `group_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `user_id` int(10) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

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
(1, 50),
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
(3, 7),
(3, 8),
(3, 8);

-- --------------------------------------------------------

--
-- Table structure for table `auth_logins`
--

CREATE TABLE `auth_logins` (
  `id` int(10) UNSIGNED NOT NULL,
  `ip_address` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `date` datetime NOT NULL,
  `success` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

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
(824, '::1', 'nightbaron.369@gmail.com', 48, '2025-11-23 00:09:33', 1),
(825, '::1', 'nightbaron.369@gmail.com', 48, '2025-12-04 06:23:32', 1),
(826, '::1', 'nightbaron.369@gmail.com', 48, '2025-12-04 22:13:04', 1),
(827, '::1', 'nightbaron.369@gmail.com', 48, '2025-12-05 04:53:12', 1),
(828, '::1', 'homestayharausyafiq', NULL, '2025-12-05 04:57:47', 0),
(829, '::1', 'homestayharausyafiq', NULL, '2025-12-05 04:58:09', 0),
(830, '::1', 'homestayharausyafiq@gmail.com', 9, '2025-12-05 04:59:23', 1),
(831, '::1', 'homestayharausyafiq@gmail.com', 9, '2025-12-15 01:01:57', 1),
(832, '::1', 'nightbaron.369@gmail.com', 48, '2025-12-15 01:03:03', 1),
(833, '::1', 'homestayharausyafiq@gmail.com', 9, '2025-12-15 01:04:06', 1),
(834, '::1', 'nightbaron.369@gmail.com', 48, '2025-12-15 02:23:41', 1),
(835, '::1', 'nightbaron.369@gmail.com', 48, '2025-12-16 05:29:03', 1),
(836, '::1', 'homestayharausyafiq@gmail.com', 9, '2025-12-16 05:30:08', 1),
(837, '::1', 'nightbaron.369@gmail.com', 48, '2025-12-16 05:30:40', 1),
(838, '::1', 'nightbaron.369@gmail.com', 48, '2025-12-30 04:29:11', 1),
(839, '::1', 'homestayharausyafiq@gmail.com', 9, '2025-12-30 04:31:29', 1),
(840, '::1', 'nightbaron.369@gmail.com', 48, '2025-12-30 04:32:05', 1),
(841, '::1', 'nightbaron.369@gmail.com', 48, '2026-01-04 20:44:11', 1),
(842, '::1', 'nightbaron.369@gmail.com', 48, '2026-01-08 04:25:39', 1),
(843, '::1', 'homestayharausyafiq@gmail.com', 9, '2026-01-08 04:28:08', 1),
(844, '::1', 'nightbaron.369@gmail.com', 48, '2026-01-08 04:28:56', 1),
(845, '::1', 'homestayharausyafiq@gmail.com', 9, '2026-01-08 05:51:44', 1),
(846, '::1', 'nightbaron.369@gmail.com', 48, '2026-01-08 05:52:16', 1),
(847, '::1', 'homestayharausyafiq@gmail.com', 9, '2026-01-08 06:53:07', 1),
(848, '::1', 'nightbaron.369@gmail.com', 48, '2026-01-08 06:53:27', 1),
(849, '::1', 'homestayharausyafiq@gmail.com', 9, '2026-01-08 08:07:14', 1),
(850, '::1', 'nightbaron.369@gmail.com', 48, '2026-01-08 08:08:05', 1),
(851, '::1', 'homestayharausyafiq@gmail.com', 9, '2026-01-08 08:08:40', 1),
(852, '::1', 'nightbaron.369@gmail.com', 48, '2026-01-08 08:09:54', 1),
(853, '::1', 'homestayharausyafiq@gmail.com', 9, '2026-01-08 08:12:00', 1),
(854, '::1', 'nightbaron.369@gmail.com', 48, '2026-01-08 08:14:25', 1),
(855, '::1', 'nightbaron.369@gmail.com', 48, '2026-01-08 08:36:03', 1),
(856, '::1', 'nightbaron.369@gmail.com', 48, '2026-01-08 08:45:14', 1),
(857, '::1', 'dragon4feast@gmail.com', 50, '2026-01-11 23:06:15', 0),
(858, '::1', 'dragon4feast@gmail.com', NULL, '2026-01-11 23:15:25', 0),
(859, '::1', 'dragon4feast@gmail.com', NULL, '2026-01-11 23:15:30', 0),
(860, '::1', 'dragon4feast@gmail.com', 50, '2026-01-11 23:15:33', 1),
(861, '::1', 'dragon4feast@gmail.com', 50, '2026-01-11 23:37:21', 1),
(862, '::1', 'dragon4feast@gmail.com', 50, '2026-01-12 00:07:37', 1),
(863, '::1', 'homestayharausyafiq@gmail.com', 9, '2026-01-12 00:08:18', 1),
(864, '::1', 'dragon4feast@gmail.com', 50, '2026-01-12 00:08:26', 1),
(865, '::1', 'dragon4feast@gmail.com', 50, '2026-01-12 23:44:20', 1),
(866, '::1', 'homestayharausyafiq@gmail.com', 9, '2026-01-14 04:28:45', 1),
(867, '::1', 'dragon4feast@gmail.com', 50, '2026-01-14 04:31:21', 1),
(868, '::1', 'homestayharausyafiq@gmail.com', 9, '2026-01-14 04:31:52', 1),
(869, '::1', 'dragon4feast@gmail.com', 50, '2026-01-14 04:32:06', 1),
(870, '::1', 'dragon4feast@gmail.com', 50, '2026-01-20 23:44:41', 1),
(871, '::1', 'dragon4feast@gmail.com', 50, '2026-01-26 00:28:24', 1),
(872, '::1', 'dragon4feast@gmail.com', 50, '2026-01-26 22:57:15', 1),
(873, '::1', 'dragon4feast@gmail.com', 50, '2026-01-27 06:47:58', 1),
(874, '::1', 'dragon4feast@gmail.com', NULL, '2026-02-12 04:54:16', 0),
(875, '::1', 'dragon4feast@gmail.com', 50, '2026-02-12 04:54:21', 1),
(876, '::1', 'dragon4feast@gmail.com', NULL, '2026-02-13 03:25:17', 0),
(877, '::1', 'dragon4feast@gmail.com', 50, '2026-02-13 03:25:22', 1),
(878, '::1', 'nightbaron.369@gmail.com', 48, '2026-05-27 01:43:18', 1),
(879, '::1', 'homestayharausyafiq@gmail.com', 9, '2026-05-27 01:47:38', 1),
(880, '::1', 'dragon4feast@gmail.com', NULL, '2026-05-27 01:48:04', 0),
(881, '::1', 'dragon4feast@gmail.com', 50, '2026-05-27 01:48:09', 1),
(882, '::1', 'dragon4feast@gmail.com', 50, '2026-05-27 01:48:24', 1),
(883, '114.10.95.40', 'nightbaron.369@gmail.com', 48, '2026-06-14 09:17:30', 1),
(884, '114.10.95.40', 'accadmin1', NULL, '2026-06-14 09:43:14', 0),
(885, '114.10.95.40', 'accadmin1', NULL, '2026-06-14 09:43:23', 0),
(886, '114.10.95.40', 'nightbaron.369@gmail.com', 48, '2026-06-14 09:58:54', 1),
(887, '114.10.95.14', 'nightbaron.369@gmail.com', 48, '2026-06-17 23:31:21', 1),
(888, '114.10.94.175', 'dragon4feast@gmail.com', NULL, '2026-07-13 03:52:09', 0),
(889, '114.10.94.175', 'dragon4feast@gmail.com', NULL, '2026-07-13 03:54:35', 0),
(890, '114.10.94.175', 'dragon4feast@gmail.com', NULL, '2026-07-13 03:55:04', 0),
(891, '114.10.94.175', 'dragon4feast@gmail.com', NULL, '2026-07-13 03:55:15', 0),
(892, '114.10.94.175', 'dragon4feast@gmail.com', 50, '2026-07-13 03:55:26', 1),
(893, '114.10.94.175', 'homestayharausyafiqaccount', NULL, '2026-07-13 03:59:36', 0),
(894, '114.10.94.175', 'homestayharausyafiq@gmail.com', 9, '2026-07-13 03:59:52', 1),
(895, '114.10.94.175', 'pokdarwispariangan1@gmail.com', NULL, '2026-07-13 04:10:24', 0),
(896, '114.10.94.175', 'accadmin1@email.com', NULL, '2026-07-13 04:11:04', 0),
(897, '114.10.94.175', 'accadmin1@email.com', 8, '2026-07-13 04:13:06', 1),
(898, '114.10.94.175', 'accadmin1@email.com', 8, '2026-07-13 04:18:39', 1),
(899, '114.10.94.175', 'dragon4feast@gmail.com', 50, '2026-07-13 22:30:07', 1),
(900, '114.10.94.175', 'homestayharausyafiq@gmail.com', 9, '2026-07-13 22:30:47', 1),
(901, '114.10.94.175', 'homestayharausyafiq@gmail.com', 9, '2026-07-14 02:42:50', 1),
(902, '114.10.94.238', 'homestayharausyafiq@gmail.com', 9, '2026-07-14 21:18:07', 1),
(903, '114.10.94.238', 'dragon4feast@gmail.com', 50, '2026-07-14 21:35:59', 1),
(904, '114.10.94.175', 'nightbaron.369@gmail.com', 48, '2026-07-15 03:18:54', 1),
(905, '114.10.94.175', 'dragon4feast@gmail.com', 50, '2026-07-15 03:21:24', 1);

-- --------------------------------------------------------

--
-- Table structure for table `auth_permissions`
--

CREATE TABLE `auth_permissions` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `auth_reset_attempts`
--

CREATE TABLE `auth_reset_attempts` (
  `id` int(10) UNSIGNED NOT NULL,
  `email` varchar(255) NOT NULL,
  `ip_address` varchar(255) NOT NULL,
  `user_agent` varchar(255) NOT NULL,
  `token` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `auth_tokens`
--

CREATE TABLE `auth_tokens` (
  `id` int(10) UNSIGNED NOT NULL,
  `selector` varchar(255) NOT NULL,
  `hashedValidator` varchar(255) NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `expires` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `auth_users_permissions`
--

CREATE TABLE `auth_users_permissions` (
  `user_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `permission_id` int(10) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `city`
--

CREATE TABLE `city` (
  `id` varchar(3) NOT NULL,
  `name` varchar(35) NOT NULL,
  `geom` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

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
  `id` varchar(3) NOT NULL,
  `village_id` varchar(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `name` varchar(50) NOT NULL,
  `address` varchar(100) DEFAULT NULL,
  `employee_name` varchar(25) DEFAULT NULL,
  `phone` varchar(13) DEFAULT NULL,
  `open` time DEFAULT NULL,
  `close` time DEFAULT NULL,
  `geom` geometry DEFAULT NULL,
  `lat` decimal(10,8) NOT NULL,
  `lng` decimal(11,8) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `culinary_place`
--

INSERT INTO `culinary_place` (`id`, `village_id`, `name`, `address`, `employee_name`, `phone`, `open`, `close`, `geom`, `lat`, `lng`, `description`, `created_at`, `updated_at`) VALUES
('C11', '1', 'Bintang Fajar', 'Tarantang Village, Harau Subdistrict, Lima Puluh Kota Regency, West Sumatra Province', 'Dewi', '081261884909', '12:00:00', '18:00:00', 0xe6100000010300000001000000050000007db664a6a52a5940be47b3767bc2babf7cb6446ba62a5940440584962cc4babf7cb604e7a62a59400446e196d5c0babf7cb64411a62a5940bc680d9740bfbabf7db664a6a52a5940be47b3767bc2babf, '-0.10451833', '100.66639869', 'Bintang Fajar adalah tempat kuliner yang menghadirkan keajaiban rasa melalui kreasinya, yaitu Rakik Kacang. Ini bukan sekadar camilan, melainkan sebuah seni kuliner yang meramu kacang pilihan menjadi gurih dan renyah dengan sentuhan rahasia yang memikat lidah.', '2023-12-01 18:13:25', '2023-12-03 09:13:39'),
('C12', '1', 'Warung Yuniar', 'Tarantang Village, Harau Subdistrict, Lima Puluh Kota Regency, West Sumatra Province', 'Yuniar', '082267248766', '10:00:00', '18:00:00', 0xe610000001030000000100000005000000b161818ea12a59404a3a82f9e2e9b9bfb161410aa22a5940320dbef999e7b9bfb16141fca02a5940d568fef923e5b9bfb261c18ba02a5940f6d7b4f9f3e7b9bfb161818ea12a59404a3a82f9e2e9b9bf, '-0.10118887', '100.66609454', NULL, '2023-12-01 18:29:02', '2023-12-01 18:29:02'),
('C13', '1', 'Bhumi Harau Cafe & Resto', 'Tarantang Village, Harau Subdistrict, Lima Puluh Kota Regency, West Sumatra Province', NULL, NULL, '19:00:00', '23:00:00', 0xe610000001030000000100000005000000b5d63fc46b2a5940c989df167062bebfb6d67f916d2a5940de7f05176261bebfb6d69fda6d2a594016eb3a160267bebfb6d67ffc6b2a5940ce131896f967bebfb5d63fc46b2a5940c989df167062bebf, '-0.11872374', '100.66289125', NULL, '2023-12-02 05:33:23', '2023-12-02 06:14:54'),
('C14', '1', 'Nasi Kapau Josi', 'Tarantang Village, Harau Subdistrict, Lima Puluh Kota Regency, West Sumatra Province', NULL, NULL, '10:00:00', '21:00:00', 0xe61000000103000000010000000500000015f95d376b2a594030b78ee9ac46bebf15f91d676c2a59408bd8a7e9f845bebf15f93db06c2a5940e922e868554bbebf15f91d866b2a5940351abc68904cbebf15f95d376b2a594030b78ee9ac46bebf, '-0.11830548', '100.66283889', NULL, '2023-12-02 06:18:41', '2023-12-02 06:18:41'),
('C15', '1', 'Leven Coffe & Eatery', 'Tarantang Village, Harau Subdistrict, Lima Puluh Kota Regency, West Sumatra Province', NULL, NULL, '14:00:00', '22:00:00', 0xe6100000010300000001000000050000003759b3a5a12a594009b92ecdc5d2babf3759f364a22a5940f2d8aecd33cebabf37593335a12a5940f29dfdcd63cbbabf3659738ca02a594020aa78cd22d0babf3759b3a5a12a594009b92ecdc5d2babf, '-0.10472231', '100.66610544', NULL, '2023-12-02 06:22:18', '2023-12-02 06:22:18'),
('C16', '1', 'Kedai 4s', 'Tarantang Village, Harau Subdistrict, Lima Puluh Kota Regency, West Sumatra Province', NULL, NULL, '10:00:00', '18:00:00', 0xe610000001030000000100000005000000c4ace737382b5940da31c6ae33e5bbbfc4aca767392b5940458acbae06e5bbbfc4aca767392b5940d62826af09e2bbbfc3ac6721382b5940d62826af09e2bbbfc4ace737382b5940da31c6ae33e5bbbf, '-0.10894195', '100.67533983', NULL, '2023-12-02 06:25:11', '2023-12-02 06:25:11'),
('C17', '1', 'Kedai Nasi Keyla', 'Tarantang Village, Harau Subdistrict, Lima Puluh Kota Regency, West Sumatra Province', NULL, NULL, '10:00:00', '18:00:00', 0xe6100000010300000001000000050000007b3079a33d2b5940315af9817cedbbbf7c30f9213f2b59406f630982f5ecbbbf7b30b9e93e2b594072f4ae8282e7bbbf7b30b9813d2b59405df29e8209e8bbbf7b3079a33d2b5940315af9817cedbbbf, '-0.10904691', '100.67567869', NULL, '2023-12-02 06:27:05', '2023-12-02 06:27:05'),
('C18', '1', 'Warung Kawa Daun Sarasah Aie Luluih', 'Tarantang Village, Harau Subdistrict, Lima Puluh Kota Regency, West Sumatra Province', NULL, NULL, '10:00:00', '18:00:00', 0xe610000001030000000100000005000000af50f425382b594056f4ed7a2dc0bbbfaf50b428392b59401ab9c37a95c1bbbfaf5034e5382b59403cea697a92c4bbbfaf50f4cb372b59401de68e7a57c3bbbfaf50f425382b594056f4ed7a2dc0bbbf, '-0.10843468', '100.67532213', NULL, '2023-12-02 06:30:53', '2023-12-02 06:30:53'),
('C19', '1', 'Warung Iyef', 'Tarantang Village, Harau Subdistrict, Lima Puluh Kota Regency, West Sumatra Province', NULL, NULL, '10:00:00', '18:00:00', 0xe610000001030000000100000006000000e14399013a2b59402e0da94318c6bbbfe14399013a2b5940984d644361c8bbbfe043d9ed3a2b5940af97694334c8bbbfe043d9ed3a2b594050fcb0c3d4c5bbbfe14399013a2b59402e0da94318c6bbbfe14399013a2b59402e0da94318c6bbbf, '-0.10850686', '100.67544358', NULL, '2023-12-02 07:32:48', '2023-12-02 07:33:08'),
('C20', '1', 'Nasi Ampera & Sate Zal', 'Tarantang Village, Harau Subdistrict, Lima Puluh Kota Regency, West Sumatra Province', NULL, NULL, '10:00:00', '18:00:00', 0xe610000001030000000100000006000000848dd8cb402b5940ae0049b0abdfbbbf848dd8cb402b59409a1be9afd5e2bbbf858d58c3412b59406e70eeafa8e2bbbf848d18b8412b5940985a3eb005e0bbbf848dd8cb402b594063ae3b301ce0bbbf848dd8cb402b5940ae0049b0abdfbbbf, '-0.10890583', '100.67585935', NULL, '2023-12-02 07:36:44', '2023-12-03 09:15:09'),
('C21', '1', 'Sarapan Pagi M.Upik', 'Tarantang Village, Harau Subdistrict, Lima Puluh Kota Regency, West Sumatra Province', NULL, NULL, '07:00:00', '18:00:00', 0xe61000000103000000010000000500000098ad45d8412b594047997c5ff4debbbf98ad45d8412b59405ebefc5e2ce3bbbf97adc5a2422b59403413025fffe2bbbf97ad8597422b594047997c5ff4debbbf98ad45d8412b594047997c5ff4debbbf, '-0.10890295', '100.67591799', NULL, '2023-12-02 08:04:36', '2023-12-03 09:15:48'),
('C22', '1', 'Warung Uni Nita', 'Tarantang Village, Harau Subdistrict, Lima Puluh Kota Regency, West Sumatra Province', NULL, NULL, '10:00:00', '18:00:00', 0xe610000001030000000100000005000000d934ff0b442b5940a5d7d09a4fe8bbbfda347f30452b5940b8d9e09ac8e7bbbfda34bf68452b59402cc4f59984efbbbfd9343f44442b5940c26bf099b1efbbbfd934ff0b442b5940a5d7d09a4fe8bbbf, '-0.10906584', '100.67606983', NULL, '2023-12-02 08:06:30', '2023-12-03 09:16:40'),
('C23', '1', 'Kini Cheese Tea Sarbun', 'Tarantang Village, Harau Subdistrict, Lima Puluh Kota Regency, West Sumatra Province', NULL, NULL, '14:00:00', '20:00:00', 0xe61000000103000000010000000500000069e2adbb472b5940084496d790dfbbbf68e22dd2472b5940f25e36d7bae2bbbf68e22de0482b59409d0841d760e2bbbf67e26dbe482b59404936b6d782debbbf69e2adbb472b5940084496d790dfbbbf, '-0.10889619', '100.67628811', NULL, '2023-12-02 08:08:34', '2023-12-03 09:17:36'),
('C24', '1', 'Yorafa Food & Drink', 'Tarantang Village, Harau Subdistrict, Lima Puluh Kota Regency, West Sumatra Province', NULL, NULL, '10:00:00', '18:00:00', 0xe61000000103000000010000000500000067c15490442b5940274639d3a8f5bbbf66c1d4e1452b59408e5649d321f5bbbf67c114ed452b594069c89dd2c1fabbbf67c114df442b5940d60c93d21bfbbbbf67c15490442b5940274639d3a8f5bbbf, '-0.10925477', '100.67610138', NULL, '2023-12-02 08:10:00', '2023-12-02 08:10:00');

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
  `culinary_place_id` varchar(3) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `culinary_place_facility_id` varchar(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `culinary_place_facility_detail`
--

INSERT INTO `culinary_place_facility_detail` (`culinary_place_id`, `culinary_place_facility_id`) VALUES
('C11', '01'),
('C12', '01'),
('C13', '01'),
('C14', '01'),
('C15', '01'),
('C16', '01'),
('C17', '01'),
('C18', '01'),
('C19', '01'),
('C20', '01'),
('C21', '01'),
('C22', '01'),
('C23', '01'),
('C24', '01'),
('C11', '02'),
('C12', '02'),
('C13', '02'),
('C14', '02'),
('C15', '02'),
('C16', '02'),
('C17', '02'),
('C18', '02'),
('C19', '02'),
('C20', '02'),
('C21', '02'),
('C22', '02'),
('C23', '02'),
('C24', '02'),
('C11', '03'),
('C12', '03'),
('C13', '03'),
('C14', '03'),
('C15', '03'),
('C16', '03'),
('C17', '03'),
('C18', '03'),
('C19', '03'),
('C20', '03'),
('C21', '03'),
('C22', '03'),
('C23', '03'),
('C24', '03');

-- --------------------------------------------------------

--
-- Table structure for table `culinary_place_gallery`
--

CREATE TABLE `culinary_place_gallery` (
  `id` varchar(3) NOT NULL,
  `culinary_place_id` varchar(3) NOT NULL,
  `url` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `culinary_place_gallery`
--

INSERT INTO `culinary_place_gallery` (`id`, `culinary_place_id`, `url`, `created_at`, `updated_at`) VALUES
('004', 'C12', 'C2-1.jpg', '2023-12-01 18:29:02', '2023-12-01 18:29:02'),
('005', 'C13', 'C3-1.jpg', '2023-12-02 06:14:54', '2023-12-02 06:14:54'),
('006', 'C14', 'C4-1.jpg', '2023-12-02 06:18:41', '2023-12-02 06:18:41'),
('007', 'C15', 'C5-1.jpg', '2023-12-02 06:22:18', '2023-12-02 06:22:18'),
('008', 'C16', 'C6-1.jpg', '2023-12-02 06:25:11', '2023-12-02 06:25:11'),
('009', 'C17', 'C7-1.jpg', '2023-12-02 06:27:05', '2023-12-02 06:27:05'),
('010', 'C18', 'C8-1.jpg', '2023-12-02 06:30:53', '2023-12-02 06:30:53'),
('011', 'C19', 'C9-1.jpg', '2023-12-02 07:33:08', '2023-12-02 07:33:08'),
('012', 'C11', 'C1-1.jpg', '2023-12-03 09:13:40', '2023-12-03 09:13:40'),
('013', 'C11', 'C1-2.jpg', '2023-12-03 09:13:40', '2023-12-03 09:13:40'),
('015', 'C20', 'C10-1.jpg', '2023-12-03 09:15:09', '2023-12-03 09:15:09'),
('016', 'C21', 'C11-1.jpg', '2023-12-03 09:15:48', '2023-12-03 09:15:48'),
('017', 'C22', 'C12-1.jpg', '2023-12-03 09:16:40', '2023-12-03 09:16:40'),
('018', 'C23', 'C13-1.jpg', '2023-12-03 09:17:36', '2023-12-03 09:17:36'),
('019', 'C23', 'C13-2.jpg', '2023-12-03 09:17:36', '2023-12-03 09:17:36');

-- --------------------------------------------------------

--
-- Table structure for table `culinary_product`
--

CREATE TABLE `culinary_product` (
  `id` varchar(2) NOT NULL,
  `name` varchar(50) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `culinary_product`
--

INSERT INTO `culinary_product` (`id`, `name`, `created_at`, `updated_at`) VALUES
('01', 'Nasi Goreng', '2023-11-09 17:51:16', '2023-12-02 08:10:30'),
('02', 'Rakik Kacang', '2023-11-10 12:00:55', '2023-11-10 12:00:55'),
('03', 'Roti Bakar', '2023-11-11 12:01:31', '2023-11-11 12:01:31'),
('04', 'Cheese Tea', '2023-12-02 08:12:39', '2023-12-02 08:12:39'),
('05', 'Mie Goreng', '2024-10-25 20:24:41', '2024-10-25 20:24:41'),
('06', 'Mie Rebus', '2024-10-25 20:24:47', '2024-10-25 20:25:46'),
('07', 'Mienas', '2024-10-25 20:24:53', '2024-10-25 20:24:53'),
('08', 'Jus', '2024-10-25 20:25:12', '2024-10-25 20:25:12'),
('09', 'Teh Es', '2024-10-25 20:25:39', '2024-10-25 20:25:39'),
('10', 'Teh Hangat', '2024-10-25 20:25:53', '2024-10-25 20:25:58'),
('11', 'Cappucino', '2024-10-25 20:26:04', '2024-10-25 20:26:04'),
('12', 'Pop Mie', '2024-10-25 20:26:18', '2024-10-25 20:26:18'),
('13', 'Kopi Susu', '2025-01-11 04:16:10', '2025-01-11 04:16:10'),
('14', 'Kawa Daun', '2024-10-25 20:24:26', '2024-10-25 20:24:26'),
('15', 'Kawa Daun Susu', '2025-01-11 04:16:20', '2025-01-11 04:16:20'),
('16', 'Kopi Hitam', '2024-10-25 20:25:00', '2024-10-25 20:25:00'),
('17', 'Gorengan', '2024-10-25 20:25:07', '2024-10-25 20:25:07');

-- --------------------------------------------------------

--
-- Table structure for table `culinary_product_detail`
--

CREATE TABLE `culinary_product_detail` (
  `culinary_place_id` varchar(3) NOT NULL,
  `culinary_product_id` varchar(2) NOT NULL,
  `price` int(10) UNSIGNED NOT NULL,
  `image_url` text DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `culinary_product_detail`
--

INSERT INTO `culinary_product_detail` (`culinary_place_id`, `culinary_product_id`, `price`, `image_url`, `description`, `created_at`, `updated_at`) VALUES
('C11', '02', 5000, 'C1P-1.jpg', NULL, '2023-12-01 18:23:06', '2023-12-01 18:23:06'),
('C11', '05', 15000, '1729931608_f9d768cb5a469b73f149.jpeg', 'Mie goreng dengan sayuran dan telur\r\n', '2024-10-25 13:33:38', '2024-10-25 13:33:38'),
('C11', '06', 15000, '1729931718_9ecabc7ce38cdd9fdd76.webp', 'Mie rebus dengan sayuran dan telur', '2024-10-25 13:35:20', '2024-10-25 13:35:20'),
('C11', '07', 15000, '1729931735_d70317cae68d45ca4294.jpg', 'Percampuran antara nasi goreng dan mie goreng dan diberikan telur\r\n', '2024-10-25 13:35:52', '2024-10-25 13:35:52'),
('C11', '08', 12000, '1729931813_1b38704500d350baa03e.jpg', 'Aneka macam jus buah', '2024-10-25 13:36:59', '2024-10-25 13:36:59'),
('C11', '09', 7000, '1729931831_1254a68a5065b3f61722.jpg', 'Kesegaran teh dipadukan dengan es batu\r\n', '2024-10-25 13:37:27', '2024-10-25 13:37:27'),
('C11', '10', 5000, '1729931857_0bc0788503a16a54c1e0.jpeg', 'Teh hangat memerikan kehangatan di cuaca yang sejuk seperti di pariangan', '2024-10-25 13:38:05', '2024-10-25 13:38:05'),
('C11', '11', 10000, '1729931900_504b51f5398bd9643b40.jpg', 'Cappucino ', '2024-10-25 13:38:37', '2024-10-25 13:38:37'),
('C11', '12', 10000, '1729931929_83dec133a260492bbc09.jpg', 'Pop Mie dan Mie Sedap Cup\r\n', '2024-10-25 13:39:08', '2024-10-25 13:39:08'),
('C11', '14', 7000, '1729931538_13fb5a9f880781ca59e9.webp', 'Minuman khas minang yang terbuat dari daun kopi', '2024-10-25 13:32:34', '2024-10-25 13:32:34'),
('C11', '16', 5000, '1729931766_94d896c52956db5aaad3.jpg', 'Kopi hitam asli pariangan\r\n', '2024-10-25 13:36:17', '2024-10-25 13:36:17'),
('C11', '17', 1500, '1729931791_697674f518b52a2163e8.jpg', 'Berbagai macam gorengan\r\n', '2024-10-25 13:36:39', '2024-10-25 13:36:39'),
('C12', '14', 5000, '1736615992_deac373ba9cdae5c723d.webp', 'Kawa Daun', '2025-01-10 21:19:59', '2025-01-10 21:19:59'),
('C13', '14', 5000, '1736616052_d0579a4b0b6e58db4da8.webp', 'Kawa Daun', '2025-01-10 21:21:01', '2025-01-10 21:21:01'),
('C14', '14', 5000, '1736616077_2093d9ab503a056850c1.webp', 'Kawa Daun\r\n', '2025-01-10 21:21:21', '2025-01-10 21:21:21'),
('C15', '14', 5000, '1736616100_f85e7158c5f5862dbf64.webp', 'Kawa Daun', '2025-01-10 21:21:43', '2025-01-10 21:21:43'),
('C16', '14', 5000, '1736616118_b64dcc8f3aebf90b48e2.webp', 'Kawa Daun', '2025-01-10 21:22:05', '2025-01-10 21:22:05'),
('C23', '04', 20000, 'C13P-1.jpg', NULL, '2023-12-02 08:17:05', '2023-12-02 08:17:05');

-- --------------------------------------------------------

--
-- Table structure for table `event`
--

CREATE TABLE `event` (
  `id` varchar(3) NOT NULL,
  `name` varchar(40) NOT NULL,
  `description` text DEFAULT NULL,
  `ticket_price` int(11) DEFAULT 0,
  `event_organizer` varchar(50) DEFAULT NULL,
  `phone` varchar(13) DEFAULT NULL,
  `geom` geometry DEFAULT NULL,
  `lat` decimal(10,8) NOT NULL,
  `lng` decimal(11,8) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `event`
--

INSERT INTO `event` (`id`, `name`, `description`, `ticket_price`, `event_organizer`, `phone`, `geom`, `lat`, `lng`, `created_at`, `updated_at`) VALUES
('E01', 'Panjat Tebing', 'Event ini menyediakan ruang untuk edukasi dan promosi keamanan dalam beraktivitas panjat tebing. Terdapat workshop dan sesi diskusi yang melibatkan para ahli panjat tebing, bertujuan untuk meningkatkan pemahaman peserta tentang keselamatan dan teknik panjat tebing yang benar.', 100000, 'Komunitas Merah Putih', '082268090256', 0xe6100000010300000001000000050000002a5cb4b1b62a59403a5c92c6a615bdbf295cb4b7b02a5940bd73c0c22e33bdbf2a5cb40bb72a5940cce149c16e3ebdbf2a5cb49dbb2a594078fda9c3262cbdbf2a5cb4b1b62a59403a5c92c6a615bdbf, '-0.10116888', '100.66670607', '2023-12-12 18:35:07', '2024-01-20 12:36:29'),
('E02', 'Art and Culture Festival', 'Art and Culture Festival di Lembah Harau adalah sebuah perayaan yang memukau, merayakan kekayaan warisan seni dan budaya yang khas dari daerah ini. Terletak di tengah-tengah keindahan alam Lembah Harau, acara ini menggabungkan keunikan seni, musik, tarian, dan warisan budaya untuk menciptakan pengalaman yang tak terlupakan.', 0, 'Nagari Lembah Harau', '081261499095', 0xe610000001030000000100000005000000c3df818e672a5940979c44a4d5d9bebfc4df815e6a2a5940f00c31a45cdabebfc4df815e6a2a594001844ca383e0bebfc3df81bb672a594001844ca383e0bebfc3df818e672a5940979c44a4d5d9bebf, '-0.12056235', '100.66265643', '2024-01-19 19:22:26', '2024-01-19 19:22:26');

-- --------------------------------------------------------

--
-- Table structure for table `event_date`
--

CREATE TABLE `event_date` (
  `event_id` varchar(3) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `event_date`
--

INSERT INTO `event_date` (`event_id`, `date`) VALUES
('E01', '2023-12-14'),
('E01', '2023-12-20'),
('E01', '2024-01-16'),
('E01', '2024-01-18'),
('E02', '2024-01-16');

-- --------------------------------------------------------

--
-- Table structure for table `event_gallery`
--

CREATE TABLE `event_gallery` (
  `id` varchar(3) NOT NULL,
  `event_id` varchar(3) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `url` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `event_gallery`
--

INSERT INTO `event_gallery` (`id`, `event_id`, `url`, `created_at`, `updated_at`) VALUES
('003', 'E02', 'E2-1.jpg', '2024-01-19 19:22:26', '2024-01-19 19:22:26'),
('004', 'E02', 'E2-2.jpg', '2024-01-19 19:22:26', '2024-01-19 19:22:26'),
('005', 'E02', 'E2-3.jpg', '2024-01-19 19:22:26', '2024-01-19 19:22:26'),
('006', 'E01', 'E1-1.jpg', '2024-01-20 12:36:29', '2024-01-20 12:36:29');

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
  `owner` int(10) UNSIGNED NOT NULL,
  `open` time DEFAULT NULL,
  `close` time DEFAULT NULL,
  `max_people_for_event` int(11) NOT NULL,
  `description` text DEFAULT NULL,
  `video_url` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `profil_link` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `homestay`
--

INSERT INTO `homestay` (`id`, `village_id`, `name`, `category`, `address`, `geom`, `lat`, `lng`, `owner`, `open`, `close`, `max_people_for_event`, `description`, `video_url`, `created_at`, `updated_at`, `profil_link`) VALUES
('H01', '1', 'Homestay Harau Syafiq', '2', 'Tarantang Village, Harau Subdistrict, Lima Puluh Kota Regency, West Sumatra Province', 0xe6100000010300000001000000090000005a4b0163b62a5940655a3f7f85dbbcbf594b4149bd2a59403e620c7ca8f4bcbf594bc11ec22a5940d697c6796906bdbf594b4173c02a59405a28cbf80e0ebdbf584b81cabf2a594040dd65782211bdbf594ba146ba2a594085b2737a2301bdbf4a390f21b32a594040c41cc5abe5bcbf4b398f48b12a5940b949544617dcbcbf5a4b0163b62a5940655a3f7f85dbbcbf, '-0.11313367', '100.66758434', 9, '10:00:00', '18:00:00', 50, 'Homestay Harau Syafiq adalah sebuah penginapan yang nyaman dan bersahaja yang terletak di Lembah Harau, sebuah destinasi alam yang indah di Sumatera Barat, Indonesia. Penginapan ini menawarkan pengalaman menginap yang autentik dan dekat dengan alam, dengan pemandangan yang memukau dari tebing batu yang mengelilingi lembah.', NULL, '2024-02-26 05:22:25', '2024-02-26 05:22:25', ''),
('H02', '1', 'Homestay Aura', '2', 'Tarantang Village, Harau Subdistrict, Lima Puluh Kota Regency, West Sumatra Province', 0xe610000001030000000100000005000000a11a276c9c2a59402e8eeb5bbdf5babf1f8afa0b9a2a59405ae8b59fadffbabf74515f5c8b2a594000fb2af16715bbbf74515f5c8b2a5940b1fb2bb7f636bbbfa11a276c9c2a59402e8eeb5bbdf5babf, '-0.10531219', '100.66579727', 13, '10:00:00', '18:00:00', 50, 'Homestay Aura adalah sebuah penginapan yang nyaman dan bersahaja yang terletak di Lembah Harau, sebuah destinasi alam yang indah di Sumatera Barat, Indonesia. Penginapan ini menawarkan pengalaman menginap yang autentik dan dekat dengan alam, dengan pemandangan yang memukau dari tebing batu yang mengelilingi lembah.', NULL, '2024-02-26 05:59:05', '2024-02-26 07:05:06', ''),
('H03', '1', 'Meliya Homestay', '2', 'Tarantang Village, Harau Subdistrict, Lima Puluh Kota Regency, West Sumatra Province', 0xe610000001030000000100000007000000e68ee5fa8a2a594095ac92e1db68bbbff74920eb8a2a594040ca5f8c0e69bbbf428922e68a2a5940e83f1836d26bbbbfd13fc1c58a2a594030383932456fbbbf131f2b3a8a2a59400b9e0092026ebbbf3c42b4f3892a5940e8e6b0353a6bbbbfe68ee5fa8a2a594095ac92e1db68bbbf, '-0.10706877', '100.66473267', 14, '10:00:00', '18:00:00', 50, 'Meliya Homestay adalah sebuah penginapan yang nyaman dan bersahaja yang terletak di Lembah Harau, sebuah destinasi alam yang indah di Sumatera Barat, Indonesia. Penginapan ini menawarkan pengalaman menginap yang autentik dan dekat dengan alam, dengan pemandangan yang memukau dari tebing batu yang mengelilingi lembah.', NULL, '2024-02-26 08:58:36', '2024-02-26 08:58:36', ''),
('H04', '1', 'Abyan Homestay', '2', 'Tarantang Village, Harau Subdistrict, Lima Puluh Kota Regency, West Sumatra Province', 0xe610000001030000000100000007000000e2101e2b802a5940ffe1b6cf8d5dbcbfcf394fa7822a5940fe4bad52d55fbcbf34d5f623832a59401c4552e2a561bcbf81545072832a5940bf1e7ec4d066bcbf82889a09822a59403cb7d806516bbcbf417d0db9802a5940e542277c9d71bcbfe2101e2b802a5940ffe1b6cf8d5dbcbf, '-0.11080252', '100.66407278', 15, '10:00:00', '18:00:00', 50, 'Abyan Homestay adalah sebuah penginapan yang nyaman dan bersahaja yang terletak di Lembah Harau, sebuah destinasi alam yang indah di Sumatera Barat, Indonesia. Penginapan ini menawarkan pengalaman menginap yang autentik dan dekat dengan alam, dengan pemandangan yang memukau dari tebing batu yang mengelilingi lembah.', NULL, '2024-02-26 09:04:25', '2024-02-26 09:06:12', ''),
('H05', '1', 'Homestay Bilza', '2', 'Tarantang Village, Harau Subdistrict, Lima Puluh Kota Regency, West Sumatra Province', 0xe61000000103000000010000000c0000009eeca862912a59405ad3ddf1fd3fbdbfea584a3b9a2a594012aacc7b393fbdbf2d36f7a19c2a59402d8c5f3e7a3fbdbf4aac73a99d2a59409a842416a542bdbf2008f3cb9e2a59404d4233993b44bdbf251eb360a02a59405e82b6490347bdbf771f1539a32a5940e01ed7c8a643bdbf5d40bb85a62a59404b08b18e3e41bdbfa2889854a52a594032c92b84933cbdbfe87ed279a22a5940e8d5e707013bbdbfa075095e9f2a5940774044302f3cbdbf9eeca862912a59405ad3ddf1fd3fbdbf, '-0.11425769', '100.66512362', 16, '10:00:00', '18:00:00', 50, 'Homestay Bilza adalah sebuah penginapan yang nyaman dan bersahaja yang terletak di Lembah Harau, sebuah destinasi alam yang indah di Sumatera Barat, Indonesia. Penginapan ini menawarkan pengalaman menginap yang autentik dan dekat dengan alam, dengan pemandangan yang memukau dari tebing batu yang mengelilingi lembah.', NULL, '2024-02-26 09:12:45', '2024-02-26 09:12:45', ''),
('H06', '1', 'Homestay IBU', '2', 'Tarantang Village, Harau Subdistrict, Lima Puluh Kota Regency, West Sumatra Province', 0xe61000000103000000010000000500000052a9a7c96b2a594094d385f5d256bebf633c73a46d2a59401619fc819b5abebf351191f56f2a5940e5e1904fc05dbebfab5d55ee6c2a594078f3af404f5ebebf52a9a7c96b2a594094d385f5d256bebf, '-0.11851233', '100.66282884', 17, '10:00:00', '18:00:00', 50, 'Homestay IBU adalah sebuah penginapan yang nyaman dan bersahaja yang terletak di Lembah Harau, sebuah destinasi alam yang indah di Sumatera Barat, Indonesia. Penginapan ini menawarkan pengalaman menginap yang autentik dan dekat dengan alam, dengan pemandangan yang memukau dari tebing batu yang mengelilingi lembah.', NULL, '2024-02-26 09:24:11', '2024-02-26 09:24:11', ''),
('H07', '1', 'Dangau Pitossa', '2', 'Tarantang Village, Harau Subdistrict, Lima Puluh Kota Regency, West Sumatra Province', 0xe61000000103000000010000000700000051e58b28f32a59401e579f822ea7bcbfb32a8031f42a59400b1d6427f6afbcbf6ec6a333f42a5940069c4aabc6b7bcbf8f709c0cf52a59402f19852c24c3bcbf8d86c6f2f22a5940681f6d1440cebcbf0856d5cbef2a5940f09183c8d8bfbcbf51e58b28f32a59401e579f822ea7bcbf, '-0.11192599', '100.67109121', 18, '10:00:00', '18:00:00', 50, 'Dangau pitossa adalah sebuah penginapan yang nyaman dan bersahaja yang terletak di Lembah Harau, sebuah destinasi alam yang indah di Sumatera Barat, Indonesia. Penginapan ini menawarkan pengalaman menginap yang autentik dan dekat dengan alam, dengan pemandangan yang memukau dari tebing batu yang mengelilingi lembah.', NULL, '2024-02-26 09:36:27', '2024-02-26 09:36:27', ''),
('H08', '1', 'Oston Homestay', '2', 'Tarantang Village, Harau Subdistrict, Lima Puluh Kota Regency, West Sumatra Province', 0xe6100000010300000001000000050000003ff6404cfe2a5940fdab9efe793bbcbf3973f66bfe2a594051df1199e23fbcbfbd92818f032b5940f7eac293064cbcbf89349ec6052b5940dfe29f213550bcbf3ff6404cfe2a5940fdab9efe793bbcbf, '-0.11028254', '100.67177111', 19, '10:00:00', '18:00:00', 50, 'Oston Homestay adalah sebuah penginapan yang nyaman dan bersahaja yang terletak di Lembah Harau, sebuah destinasi alam yang indah di Sumatera Barat, Indonesia. Penginapan ini menawarkan pengalaman menginap yang autentik dan dekat dengan alam, dengan pemandangan yang memukau dari tebing batu yang mengelilingi lembah.', NULL, '2024-02-26 09:43:34', '2024-02-26 09:43:34', ''),
('H09', '1', 'Megahomestay', '2', 'Tarantang Village, Harau Subdistrict, Lima Puluh Kota Regency, West Sumatra Province', 0xe610000001030000000100000005000000fdba57d60b2b59402760016d2721bcbfe7fea8550d2b594043f969797124bcbf2efc64b50e2b5940085231e77c25bcbff6b7c2c30d2b59402a5b3d8ae72abcbffdba57d60b2b59402760016d2721bcbf, '-0.10988089', '100.67259749', 20, '10:00:00', '18:00:00', 50, 'Oston Homestay adalah sebuah penginapan yang nyaman dan bersahaja yang terletak di Lembah Harau, sebuah destinasi alam yang indah di Sumatera Barat, Indonesia. Penginapan ini menawarkan pengalaman menginap yang autentik dan dekat dengan alam, dengan pemandangan yang memukau dari tebing batu yang mengelilingi lembah.', NULL, '2024-02-26 09:47:02', '2024-02-26 09:47:02', ''),
('H10', '1', 'Dangau Abah Homestay', '2', 'Tarantang Village, Harau Subdistrict, Lima Puluh Kota Regency, West Sumatra Province', 0xe61000000103000000010000000b000000221741082d2b5940bb2e368c0619bcbfceb7d310342b5940da5e24171018bcbf65acd3d4342b59401f9b6880a016bcbf82d9eb7a352b594002b859bc5818bcbf3b23a534362b59403fbd0098be19bcbf43b14fdf362b5940017bb73f381bbcbf5edfe23c372b594017c38b74f519bcbf05eb0fff362b5940f7065f984c15bcbf680e62ca342b59409d9771f0d811bcbf54c2d9ce332b5940ba25a4fb5a13bcbf221741082d2b5940bb2e368c0619bcbf, '-0.10975686', '100.67462355', 21, '10:00:00', '18:00:00', 50, 'Oston Homestay adalah sebuah penginapan yang nyaman dan bersahaja yang terletak di Lembah Harau, sebuah destinasi alam yang indah di Sumatera Barat, Indonesia. Penginapan ini menawarkan pengalaman menginap yang autentik dan dekat dengan alam, dengan pemandangan yang memukau dari tebing batu yang mengelilingi lembah.', NULL, '2024-02-26 09:55:41', '2024-02-26 09:55:41', ''),
('H11', '1', 'Limpato Homestay', '2', 'Tarantang Village, Harau Subdistrict, Lima Puluh Kota Regency, West Sumatra Province', 0xe6100000010300000001000000050000002b229aab6c2a594084443df15a11bebf0363f9ca6e2a5940256793897c13bebf1eaecdad6d2a59408a394a562c1bbebf63c5fc1e6d2a59405ae8d6ad9622bebf2b229aab6c2a594084443df15a11bebf, '-0.11745232', '100.66288271', 22, '10:00:00', '18:00:00', 50, 'Limpato Homestay adalah sebuah penginapan yang nyaman dan bersahaja yang terletak di Lembah Harau, sebuah destinasi alam yang indah di Sumatera Barat, Indonesia. Penginapan ini menawarkan pengalaman menginap yang autentik dan dekat dengan alam, dengan pemandangan yang memukau dari tebing batu yang mengelilingi lembah.', NULL, '2024-02-26 12:17:47', '2024-02-26 12:20:24', '');

-- --------------------------------------------------------

--
-- Table structure for table `homestay_additional_amenities`
--

CREATE TABLE `homestay_additional_amenities` (
  `homestay_id` varchar(3) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `additional_amenities_id` varchar(3) NOT NULL,
  `additional_amenities_type` varchar(1) NOT NULL DEFAULT '1',
  `name` varchar(50) NOT NULL,
  `category` varchar(1) NOT NULL,
  `price` int(11) NOT NULL,
  `is_order_count_per_day` varchar(1) NOT NULL DEFAULT '0',
  `is_order_count_per_person` varchar(1) NOT NULL DEFAULT '0',
  `is_order_count_per_room` varchar(1) NOT NULL DEFAULT '0',
  `stock` int(11) NOT NULL,
  `description` text NOT NULL,
  `image_url` text NOT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `homestay_additional_amenities`
--

INSERT INTO `homestay_additional_amenities` (`homestay_id`, `additional_amenities_id`, `additional_amenities_type`, `name`, `category`, `price`, `is_order_count_per_day`, `is_order_count_per_person`, `is_order_count_per_room`, `stock`, `description`, `image_url`, `created_at`, `updated_at`) VALUES
('H01', '01', '1', 'Breakfast', '2', 15000, '1', '1', '', 0, 'Sarapan dengan menu yang dapat dipilih ketika menginap', '1709108441_15e566c51441ddbb6f12.jpg', '2024-02-27 12:20:43', '2024-02-27 12:20:43'),
('H01', '02', '1', 'Lunch', '2', 25000, '1', '1', '', 0, 'Makan siang dengan menu yang dapat dipilih ketika menginap', '1709108493_8acb29efb0b2f28978f1.jpg', '2024-02-27 12:21:42', '2024-02-27 12:21:42'),
('H01', '03', '1', 'Dinner', '2', 25000, '1', '1', '', 0, 'Makan malam dengan menu yang dapat dipilih ketika menginap', '1709108535_ef01c134ee1e28296108.jpg', '2024-02-27 12:22:17', '2024-02-27 12:22:17'),
('H01', '04', '1', 'Mattress', '1', 50000, '', '', '1', 5, 'Kasur tambahan', '1709108595_9cb67fef27d471f093ce.jpg', '2024-02-27 12:23:18', '2024-02-27 12:23:18'),
('H01', '05', '1', 'Bathroom amenities', '1', 20000, '', '1', '', 0, 'Perlengkapan mandi', '1709108729_0c2892841396fba08924.jpeg', '2024-02-27 12:25:32', '2024-02-27 12:25:32'),
('H01', '06', '1', 'Equipment for grilling', '1', 30000, '', '', '', 5, 'Perlengkapan untuk bakar-bakar', '1709108832_5a375e35ec18bb648e8f.jpg', '2024-02-27 12:27:20', '2024-02-27 12:27:20');

-- --------------------------------------------------------

--
-- Table structure for table `homestay_certification`
--

CREATE TABLE `homestay_certification` (
  `homestay_id` varchar(3) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `certification_id` varchar(3) NOT NULL,
  `certificate_name` varchar(200) NOT NULL,
  `certificate_num` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `certifying_agency` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `date` date NOT NULL,
  `description` text DEFAULT NULL,
  `image_url` text NOT NULL
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

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
  `url` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

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
  `unit_number` varchar(2) NOT NULL,
  `name` varchar(25) NOT NULL,
  `price` int(11) NOT NULL,
  `capacity` int(11) DEFAULT NULL,
  `description` text DEFAULT NULL,
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
  `unit_number` varchar(2) NOT NULL,
  `facility_id` varchar(2) NOT NULL,
  `description` text DEFAULT NULL,
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
  `id` bigint(20) UNSIGNED NOT NULL,
  `version` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `group` varchar(255) NOT NULL,
  `namespace` varchar(255) NOT NULL,
  `time` int(11) NOT NULL,
  `batch` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

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
-- Table structure for table `package`
--

CREATE TABLE `package` (
  `homestay_id` varchar(3) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `package_id` varchar(4) NOT NULL,
  `name` varchar(100) NOT NULL,
  `min_capacity` int(11) DEFAULT NULL,
  `brochure_url` text DEFAULT NULL,
  `description` text DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `is_custom` char(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `package`
--

INSERT INTO `package` (`homestay_id`, `package_id`, `name`, `min_capacity`, `brochure_url`, `description`, `price`, `is_custom`, `created_at`, `updated_at`) VALUES
('H01', 'P001', 'Explore Lembah Harau', 5, '1709092962_e08836f6f13adffb5d1d.jpg', 'Paket ini menawarkan perjalanan ke objek-objek wisata populer di lembah harau', 250000, '0', '2024-02-27 14:45:03', '2024-02-27 14:45:03'),
('H01', 'P002', 'Explore Geopark Lembah Harau', 5, '1709107084_e539c652fa40cac62347.jpg', 'Menjelajahi semua objek yang berkaitan dengan geopark lembah harau', 100000, '0', '2024-02-27 18:23:54', '2024-02-27 18:23:54'),
('H01', 'P003', 'Explore Geopark Lembah Harau extend by Dragon at 2026-07-15 19:50', 5, NULL, NULL, 100000, '1', '2026-07-16 02:50:45', '2026-07-16 02:50:45');

-- --------------------------------------------------------

--
-- Table structure for table `package_day`
--

CREATE TABLE `package_day` (
  `homestay_id` varchar(3) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `package_id` varchar(4) NOT NULL,
  `day` char(1) NOT NULL,
  `description` text DEFAULT NULL,
  `is_base_for_extend` varchar(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `package_day`
--

INSERT INTO `package_day` (`homestay_id`, `package_id`, `day`, `description`, `is_base_for_extend`) VALUES
('H01', 'P001', '1', 'Menikmati keindahan alam lembah harau', '0'),
('H01', 'P001', '2', 'Menikmati keindahan alam dan budaya', '0'),
('H01', 'P002', '1', 'Melihat tabing batu lembah harau', '0'),
('H01', 'P003', '1', 'Melihat tabing batu lembah harau', '1');

-- --------------------------------------------------------

--
-- Table structure for table `package_detail`
--

CREATE TABLE `package_detail` (
  `homestay_id` varchar(3) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `package_id` varchar(4) NOT NULL,
  `day` char(1) NOT NULL,
  `activity` char(1) NOT NULL,
  `activity_type` char(2) NOT NULL,
  `id_object` varchar(5) NOT NULL,
  `description` text NOT NULL,
  `is_base_for_extend` varchar(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `package_detail`
--

INSERT INTO `package_detail` (`homestay_id`, `package_id`, `day`, `activity`, `activity_type`, `id_object`, `description`, `is_base_for_extend`) VALUES
('H01', 'P001', '1', '1', 'A', 'A5', 'Melihat keindahan air tejun aka barayun', '0'),
('H01', 'P001', '1', '2', 'A', 'A7', 'Melihat keidahaan tebing batu khas lembah harau', '0'),
('H01', 'P001', '1', '3', 'A', 'A9', 'Bermain air dan berenang di waterpark', '0'),
('H01', 'P001', '2', '1', 'A', 'A4', 'Melihat keindahan air terjun', '0'),
('H01', 'P001', '2', '2', 'A', 'A6', 'Belajar  budaya dan melihat bangunan khas budaya minang, eropa, jepang, dan korea', '0'),
('H01', 'P001', '2', '3', 'S', 'S2', 'Membeli oleh-oleh', '0'),
('H01', 'P002', '1', '1', 'A', 'A5', 'Melihat air terjun aka barayun dan bermain air ', '0'),
('H01', 'P002', '1', '2', 'A', 'A7', 'melihat keindahan tebing batu lembah harau ', '0'),
('H01', 'P002', '1', '3', 'A', 'A4', 'Melihat air terjun dan tanaman-tanaman endemik lembah harau', '0'),
('H01', 'P003', '1', '1', 'A', 'A5', 'Melihat air terjun aka barayun dan bermain air ', '1'),
('H01', 'P003', '1', '2', 'A', 'A7', 'melihat keindahan tebing batu lembah harau ', '1'),
('H01', 'P003', '1', '3', 'A', 'A4', 'Melihat air terjun dan tanaman-tanaman endemik lembah harau', '1');

-- --------------------------------------------------------

--
-- Table structure for table `package_service`
--

CREATE TABLE `package_service` (
  `id` varchar(2) NOT NULL,
  `name` varchar(25) NOT NULL,
  `price` int(11) NOT NULL,
  `category` varchar(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `package_service`
--

INSERT INTO `package_service` (`id`, `name`, `price`, `category`) VALUES
('1', 'Guide', 100000, '0'),
('2', 'Welcome Drink', 10000, '1'),
('3', 'Documentation', 10000, '1'),
('4', 'Snack', 10000, '1'),
('5', 'Transportation Mini MPV', 300000, '0'),
('6', 'Sound System', 200000, '0');

-- --------------------------------------------------------

--
-- Table structure for table `package_service_detail`
--

CREATE TABLE `package_service_detail` (
  `homestay_id` varchar(3) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `package_id` varchar(4) NOT NULL,
  `package_service_id` varchar(2) NOT NULL,
  `status` char(1) NOT NULL,
  `is_base_for_extend` varchar(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `package_service_detail`
--

INSERT INTO `package_service_detail` (`homestay_id`, `package_id`, `package_service_id`, `status`, `is_base_for_extend`) VALUES
('H01', 'P001', '1', '1', '0'),
('H01', 'P001', '3', '0', '0'),
('H01', 'P001', '4', '1', '0'),
('H01', 'P002', '1', '1', '0'),
('H01', 'P002', '3', '0', '0'),
('H01', 'P003', '1', '1', '1');

-- --------------------------------------------------------

--
-- Table structure for table `province`
--

CREATE TABLE `province` (
  `id` varchar(3) NOT NULL,
  `name` varchar(25) NOT NULL,
  `geom` varchar(50) NOT NULL
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
-- Table structure for table `recommendation`
--

CREATE TABLE `recommendation` (
  `id` varchar(1) NOT NULL,
  `name` varchar(30) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `recommendation`
--

INSERT INTO `recommendation` (`id`, `name`, `created_at`, `updated_at`) VALUES
('1', 'Highly Recommended', '2023-10-28 15:51:29', '2023-10-28 15:51:29'),
('2', 'Recommended', '2023-10-28 15:51:29', '2023-10-28 15:51:29'),
('3', 'Less Recommended', '2023-10-28 15:51:29', '2023-10-28 15:51:29'),
('4', 'Not Recommended', '2023-10-28 15:51:29', '2023-10-28 15:51:29'),
('5', 'Maintenance', '2023-10-28 15:51:29', '2023-10-28 15:51:29');

-- --------------------------------------------------------

--
-- Table structure for table `reservation`
--

CREATE TABLE `reservation` (
  `id` varchar(4) NOT NULL,
  `customer_id` int(10) UNSIGNED DEFAULT NULL,
  `reservation_type` varchar(1) NOT NULL DEFAULT '1',
  `request_date` datetime NOT NULL,
  `check_in` datetime NOT NULL,
  `total_people` int(11) DEFAULT NULL,
  `review` text DEFAULT NULL,
  `rating` int(11) DEFAULT NULL,
  `bonus_coin` int(11) DEFAULT NULL,
  `coin_use` int(11) DEFAULT NULL,
  `total_price` int(11) DEFAULT NULL,
  `deposit` int(11) DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL,
  `deposit_snap_token` text DEFAULT NULL,
  `pay_full_snap_token` text DEFAULT NULL,
  `reservation_finish_at` timestamp NULL DEFAULT NULL,
  `is_rejected` varchar(1) DEFAULT NULL,
  `confirmed_at` timestamp NULL DEFAULT NULL,
  `feedback` text DEFAULT NULL,
  `canceled_at` timestamp NULL DEFAULT NULL,
  `cancelation_reason` varchar(1) DEFAULT NULL,
  `is_refund` char(1) DEFAULT NULL,
  `refund_paid_at` timestamp NULL DEFAULT NULL,
  `account_refund` text DEFAULT NULL,
  `refund_proof` text DEFAULT NULL,
  `is_refund_proof_correct` varchar(1) DEFAULT NULL,
  `refund_paid_confirmed_at` timestamp NULL DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `reservation`
--

INSERT INTO `reservation` (`id`, `customer_id`, `reservation_type`, `request_date`, `check_in`, `total_people`, `review`, `rating`, `bonus_coin`, `coin_use`, `total_price`, `deposit`, `status`, `deposit_snap_token`, `pay_full_snap_token`, `reservation_finish_at`, `is_rejected`, `confirmed_at`, `feedback`, `canceled_at`, `cancelation_reason`, `is_refund`, `refund_paid_at`, `account_refund`, `refund_proof`, `is_refund_proof_correct`, `refund_paid_confirmed_at`, `created_at`, `updated_at`) VALUES
('R010', 48, '1', '2025-12-05 17:56:11', '2025-12-08 14:00:00', 1, NULL, NULL, NULL, 0, 350000, 70000, '0', NULL, NULL, '2025-12-05 10:56:26', NULL, NULL, NULL, '2025-12-15 07:02:00', '2', '0', NULL, NULL, NULL, NULL, NULL, '2026-07-15 03:41:08', '2026-07-15 03:41:08'),
('R011', 48, '1', '2025-12-15 14:03:31', '2025-12-18 14:00:00', 1, NULL, NULL, NULL, 0, 700000, 140000, '1', NULL, NULL, '2025-12-15 07:03:42', '0', '2025-12-15 08:21:24', NULL, '2025-12-16 11:29:00', '2', '0', NULL, NULL, NULL, NULL, NULL, '2026-07-15 03:41:08', '2026-07-15 03:41:08'),
('R012', 48, '1', '2025-12-16 18:29:42', '2025-12-24 14:00:00', 1, NULL, NULL, NULL, 0, 700000, 140000, '1', NULL, NULL, '2025-12-16 11:29:53', '0', '2025-12-16 11:30:24', NULL, '2025-12-30 10:31:00', '2', '0', NULL, NULL, NULL, NULL, NULL, '2026-07-15 03:41:08', '2026-07-15 03:41:08'),
('R013', 48, '1', '2025-12-30 17:31:04', '2026-01-07 14:00:00', 1, NULL, NULL, NULL, 0, 1050000, 210000, '1', NULL, NULL, '2025-12-30 10:31:13', '0', '2025-12-30 10:31:50', NULL, '2026-01-05 07:10:00', '2', '0', NULL, NULL, NULL, NULL, NULL, '2026-07-15 03:41:08', '2026-07-15 03:41:08'),
('R014', 48, '1', '2026-01-08 17:26:16', '2026-01-13 14:00:00', 1, NULL, NULL, NULL, 0, 350000, 70000, '1', NULL, NULL, '2026-01-08 10:26:33', '0', '2026-01-08 10:28:27', NULL, '2026-01-12 06:09:00', '2', '0', NULL, NULL, NULL, NULL, NULL, '2026-07-15 03:41:08', '2026-07-15 03:41:08'),
('R015', 48, '1', '2026-01-08 18:51:23', '2026-01-12 14:00:00', 1, NULL, NULL, NULL, 0, 350000, 70000, '1', NULL, NULL, '2026-01-08 11:51:30', '0', '2026-01-08 11:51:59', NULL, '2026-01-12 06:09:00', '2', '0', NULL, NULL, NULL, NULL, NULL, '2026-07-15 03:41:08', '2026-07-15 03:41:08'),
('R016', 48, '1', '2026-01-08 19:54:57', '2026-01-12 14:00:00', 2, NULL, NULL, NULL, 0, 350000, 70000, '1', NULL, NULL, '2026-01-08 12:55:02', '0', '2026-01-08 12:55:22', NULL, '2026-01-12 06:09:00', '2', '0', NULL, NULL, NULL, NULL, NULL, '2026-07-15 03:41:08', '2026-07-15 03:41:08'),
('R017', 48, '1', '2026-01-08 20:01:00', '2026-01-14 14:00:00', 1, NULL, NULL, NULL, 0, 350000, 70000, '1', NULL, NULL, '2026-01-08 13:01:04', '0', '2026-01-08 13:01:15', NULL, '2026-01-12 08:08:00', '2', '0', NULL, NULL, NULL, NULL, NULL, '2026-07-15 03:41:08', '2026-07-15 03:41:08'),
('R018', 48, '1', '2026-01-08 20:12:42', '2026-01-13 14:00:00', 1, NULL, NULL, NULL, 0, 350000, 70000, '1', NULL, NULL, '2026-01-08 13:12:47', '0', '2026-01-08 13:13:02', NULL, '2026-01-12 06:09:00', '2', '0', NULL, NULL, NULL, NULL, NULL, '2026-07-15 03:41:08', '2026-07-15 03:41:08'),
('R019', 48, '1', '2026-01-08 20:21:32', '2026-01-14 14:00:00', 1, NULL, NULL, NULL, 0, 350000, 70000, '1', NULL, NULL, '2026-01-08 13:21:37', '0', '2026-01-08 13:21:46', NULL, '2026-01-12 08:08:00', '2', '0', NULL, NULL, NULL, NULL, NULL, '2026-07-15 03:41:08', '2026-07-15 03:41:08'),
('R020', 48, '1', '2026-01-08 20:25:40', '2026-01-12 14:00:00', 1, NULL, NULL, NULL, 0, 350000, 70000, 'Done', NULL, NULL, '2026-01-08 13:25:44', '0', '2026-01-08 13:25:51', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-15 03:41:08', '2026-07-15 03:41:08'),
('R022', 48, '1', '2026-01-08 21:08:27', '2026-01-17 14:00:00', 1, NULL, NULL, NULL, 0, 350000, 70000, 'Deposit Successful', NULL, NULL, '2026-01-08 14:08:32', '0', '2026-01-08 14:08:53', NULL, '2026-06-15 05:29:00', '3', '0', NULL, NULL, NULL, NULL, NULL, '2026-07-15 03:41:08', '2026-07-15 03:41:08'),
('R023', 50, '1', '2026-01-12 13:09:06', '2026-01-23 14:00:00', 1, NULL, NULL, NULL, 0, 350000, 70000, 'Done', NULL, NULL, '2026-01-12 06:09:11', '0', '2026-01-12 06:09:28', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-15 03:41:08', '2026-07-15 03:41:08'),
('R024', 50, '1', '2026-01-12 13:22:07', '2026-01-24 14:00:00', 1, NULL, NULL, NULL, 0, 350000, 70000, 'Done', NULL, NULL, '2026-01-12 06:22:15', '0', '2026-01-12 06:22:51', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-15 03:41:08', '2026-07-15 03:41:08'),
('R025', 50, '1', '2026-01-12 14:27:11', '2026-01-27 14:00:00', 1, NULL, NULL, NULL, 0, 400000, 80000, 'Done', NULL, NULL, '2026-01-12 08:08:33', '0', '2026-01-12 08:08:44', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-15 03:41:08', '2026-07-15 03:41:08'),
('R026', 50, '1', '2026-01-12 15:32:02', '2026-01-26 14:00:00', 1, NULL, NULL, NULL, 0, 350000, 70000, 'Done', NULL, NULL, '2026-01-12 08:34:39', '0', '2026-01-12 08:34:51', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-15 03:41:08', '2026-07-15 03:41:08'),
('R027', 50, '1', '2026-01-14 17:33:21', '2026-01-30 14:00:00', 1, NULL, NULL, NULL, 0, 350000, 70000, 'Done', NULL, NULL, '2026-01-14 10:33:32', '0', '2026-01-14 10:33:47', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-15 03:41:08', '2026-07-15 03:41:08'),
('R028', 50, '1', '2026-01-14 17:35:13', '2026-01-30 14:00:00', 1, NULL, NULL, NULL, 0, 350000, 70000, 'Done', NULL, NULL, '2026-01-14 10:35:20', '0', '2026-01-14 10:35:31', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-15 03:41:08', '2026-07-15 03:41:08'),
('R029', 50, '1', '2026-01-14 17:45:51', '2026-01-28 14:00:00', 1, NULL, NULL, NULL, 0, 350000, 70000, 'Done', NULL, NULL, '2026-01-14 10:45:58', '0', '2026-01-14 10:46:14', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-15 03:41:08', '2026-07-15 03:41:08'),
('R030', 50, '1', '2026-01-14 17:48:53', '2026-01-29 14:00:00', 1, NULL, NULL, NULL, 0, 350000, 70000, 'Done', NULL, NULL, '2026-01-14 10:49:02', '0', '2026-01-14 10:49:11', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-15 03:41:08', '2026-07-15 03:41:08'),
('R031', 50, '1', '2026-01-14 17:56:27', '2026-01-28 14:00:00', 1, NULL, NULL, NULL, 0, 350000, 70000, 'Done', NULL, NULL, '2026-01-14 10:56:33', '0', '2026-01-14 10:56:44', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-15 03:41:08', '2026-07-15 03:41:08'),
('R032', 50, '2', '2026-01-21 12:45:32', '2026-01-25 14:00:00', 10, NULL, NULL, NULL, 0, 4635000, 927000, '0', NULL, NULL, '2026-01-21 05:45:54', NULL, NULL, NULL, '2026-07-13 22:57:00', '2', '0', NULL, NULL, NULL, NULL, NULL, '2026-07-15 03:41:08', '2026-07-15 03:41:08'),
('R033', 48, '1', '2026-06-14 22:29:14', '2026-06-18 14:00:00', 1, NULL, NULL, NULL, 0, 700000, 140000, '0', NULL, NULL, '2026-06-15 05:29:28', NULL, NULL, NULL, '2026-07-13 22:55:00', '2', '0', NULL, NULL, NULL, NULL, NULL, '2026-07-15 03:41:08', '2026-07-15 03:41:08'),
('R034', 50, '1', '2026-07-14 10:31:27', '2026-07-18 14:00:00', 1, NULL, NULL, NULL, 0, 700000, 140000, 'Full Pay Successful', NULL, NULL, '2026-07-14 17:31:37', '0', '2026-07-14 17:32:01', NULL, '2026-07-15 00:29:00', '1', '1', '2026-07-15 16:33:42', 'qweqrr - qwe - 1235456', '1784082820_7a6f510760257d7e8a07.png', NULL, NULL, '2026-07-15 03:41:08', '2026-07-15 03:41:08'),
('R035', 50, '1', '2026-07-14 14:15:20', '2026-07-18 14:00:00', 2, NULL, NULL, NULL, 0, 740000, 148000, '1', NULL, NULL, '2026-07-14 23:37:29', '0', '2026-07-14 23:37:44', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-15 03:41:08', '2026-07-15 03:41:08'),
('R036', 50, '1', '2026-07-14 16:28:40', '2026-07-22 14:00:00', 2, NULL, NULL, NULL, 0, 700000, 140000, '1', NULL, NULL, '2026-07-14 23:31:34', '0', '2026-07-14 23:31:50', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-15 03:41:08', '2026-07-15 03:41:08'),
('R037', 50, '1', '2026-07-14 16:34:32', '2026-07-25 14:00:00', 1, NULL, NULL, NULL, 0, 1420000, 140000, '1', NULL, NULL, '2026-07-14 23:34:38', '0', '2026-07-14 23:34:57', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-15 03:41:08', '2026-07-15 03:41:08'),
('R038', 50, '1', '2026-07-14 17:18:14', '2026-07-18 14:00:00', 1, NULL, NULL, NULL, 0, 350000, 70000, '0', NULL, NULL, '2026-07-15 00:18:22', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-15 03:41:08', '2026-07-15 03:41:08'),
('R039', 50, '1', '2026-07-15 09:54:48', '2026-07-31 14:00:00', 1, NULL, NULL, NULL, NULL, 700000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-15 03:41:08', '2026-07-15 03:41:08'),
('R040', 50, '1', '2026-07-15 10:16:27', '2026-07-31 14:00:00', 1, NULL, NULL, NULL, NULL, 700000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-15 03:41:08', '2026-07-15 03:41:08'),
('R041', 50, '1', '2026-07-15 10:21:37', '2026-07-31 14:00:00', 1, NULL, NULL, NULL, NULL, 700000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-15 03:41:08', '2026-07-15 07:51:47');

-- --------------------------------------------------------

--
-- Table structure for table `reservation_homestay_additional_amenities_detail`
--

CREATE TABLE `reservation_homestay_additional_amenities_detail` (
  `homestay_id` varchar(3) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `additional_amenities_id` varchar(3) NOT NULL,
  `reservation_id` varchar(4) NOT NULL,
  `day_order` int(11) NOT NULL,
  `person_order` int(11) NOT NULL,
  `room_order` int(11) NOT NULL,
  `total_order` int(11) NOT NULL,
  `total_price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `reservation_homestay_additional_amenities_detail`
--

INSERT INTO `reservation_homestay_additional_amenities_detail` (`homestay_id`, `additional_amenities_id`, `reservation_id`, `day_order`, `person_order`, `room_order`, `total_order`, `total_price`) VALUES
('H01', '04', 'R025', 0, 0, 1, 1, 50000),
('H01', '05', 'R035', 0, 2, 0, 1, 40000),
('H01', '05', 'R037', 0, 1, 0, 1, 20000);

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

--
-- Dumping data for table `reservation_homestay_unit_detail`
--

INSERT INTO `reservation_homestay_unit_detail` (`homestay_id`, `unit_type`, `unit_number`, `date`, `reservation_id`) VALUES
('H01', '1', '1', '2026-01-12', 'R020'),
('H01', '1', '1', '2026-01-23', 'R023'),
('H01', '1', '1', '2026-01-24', 'R024'),
('H01', '1', '1', '2026-01-27', 'R025'),
('H01', '1', '1', '2026-01-26', 'R026'),
('H01', '1', '1', '2026-01-30', 'R027'),
('H01', '1', '2', '2026-01-30', 'R028'),
('H01', '1', '1', '2026-01-28', 'R029'),
('H01', '1', '1', '2026-01-29', 'R030'),
('H01', '1', '2', '2026-01-28', 'R031'),
('H01', '1', '2', '2026-07-18', 'R035'),
('H01', '1', '2', '2026-07-19', 'R035'),
('H01', '1', '1', '2026-07-22', 'R036'),
('H01', '1', '1', '2026-07-23', 'R036'),
('H01', '1', '1', '2026-07-25', 'R037'),
('H01', '1', '1', '2026-07-26', 'R037'),
('H01', '1', '1', '2026-07-27', 'R037'),
('H01', '1', '1', '2026-07-28', 'R037'),
('H01', '1', '3', '2026-07-18', 'R038'),
('H01', '1', '1', '2026-07-31', 'R039'),
('H01', '1', '1', '2026-08-01', 'R039'),
('H01', '1', '2', '2026-07-31', 'R040'),
('H01', '1', '2', '2026-08-01', 'R040'),
('H01', '1', '3', '2026-07-31', 'R041'),
('H01', '1', '3', '2026-08-01', 'R041');

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

--
-- Dumping data for table `reservation_homestay_unit_detail_backup`
--

INSERT INTO `reservation_homestay_unit_detail_backup` (`homestay_id`, `unit_type`, `unit_number`, `reservation_id`, `date`) VALUES
('H01', '1', '1', 'R010', '2025-12-08'),
('H01', '1', '1', 'R011', '2025-12-18'),
('H01', '1', '1', 'R011', '2025-12-19'),
('H01', '1', '1', 'R012', '2025-12-24'),
('H01', '1', '1', 'R012', '2025-12-25'),
('H01', '1', '1', 'R013', '2026-01-07'),
('H01', '1', '1', 'R013', '2026-01-08'),
('H01', '1', '1', 'R013', '2026-01-09'),
('H01', '1', '1', 'R014', '2026-01-13'),
('H01', '1', '2', 'R015', '2026-01-12'),
('H01', '1', '4', 'R016', '2026-01-12'),
('H01', '1', '1', 'R017', '2026-01-14'),
('H01', '1', '2', 'R018', '2026-01-13'),
('H01', '1', '2', 'R019', '2026-01-14'),
('H01', '1', '1', 'R022', '2026-01-17'),
('H01', '1', '1', 'R032', '2026-01-25'),
('H01', '1', '10', 'R032', '2026-01-25'),
('H01', '1', '11', 'R032', '2026-01-25'),
('H01', '1', '12', 'R032', '2026-01-25'),
('H01', '1', '13', 'R032', '2026-01-25'),
('H01', '1', '14', 'R032', '2026-01-25'),
('H01', '1', '2', 'R032', '2026-01-25'),
('H01', '1', '3', 'R032', '2026-01-25'),
('H01', '1', '4', 'R032', '2026-01-25'),
('H01', '1', '5', 'R032', '2026-01-25'),
('H01', '1', '6', 'R032', '2026-01-25'),
('H01', '1', '7', 'R032', '2026-01-25'),
('H01', '1', '8', 'R032', '2026-01-25'),
('H01', '1', '9', 'R032', '2026-01-25'),
('H01', '1', '1', 'R033', '2026-06-18'),
('H01', '1', '1', 'R033', '2026-06-19'),
('H01', '1', '1', 'R034', '2026-07-18'),
('H01', '1', '1', 'R034', '2026-07-19');

-- --------------------------------------------------------

--
-- Table structure for table `reservation_package_detail`
--

CREATE TABLE `reservation_package_detail` (
  `id` int(11) NOT NULL,
  `reservation_id` varchar(255) NOT NULL,
  `package_id` varchar(255) NOT NULL,
  `package_order` float DEFAULT 1,
  `package_total_price` int(11) DEFAULT 0,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `service`
--

CREATE TABLE `service` (
  `id` varchar(2) NOT NULL,
  `service_provider_id` varchar(2) NOT NULL,
  `name` varchar(50) NOT NULL,
  `price` int(10) UNSIGNED NOT NULL,
  `unit_price` varchar(25) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `service`
--

INSERT INTO `service` (`id`, `service_provider_id`, `name`, `price`, `unit_price`, `created_at`, `updated_at`) VALUES
('01', 'V1', 'Sewa Sepeda', 15000, 'jam', '2023-12-02 18:48:31', '2023-12-02 18:48:31'),
('02', 'V2', 'Sewa Kuda', 10000, 'orang', '2023-12-02 18:52:28', '2023-12-02 18:52:28'),
('03', 'V3', 'Sewa Tenda 200cm x 200cm', 40000, 'hari', '2023-12-02 18:59:28', '2023-12-02 19:01:28'),
('04', 'V3', 'Sewa Tenda 300cm x 400cm', 60000, 'hari', '2023-12-02 19:00:08', '2023-12-02 19:01:16'),
('05', 'V3', 'Sewa Lahan Camping 5m x 5m', 25000, 'hari', '2023-12-02 19:01:04', '2023-12-02 19:01:04');

-- --------------------------------------------------------

--
-- Table structure for table `service_provider`
--

CREATE TABLE `service_provider` (
  `id` varchar(2) NOT NULL,
  `name` varchar(50) NOT NULL,
  `address` varchar(100) NOT NULL,
  `employee_name` varchar(25) DEFAULT NULL,
  `phone` varchar(13) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `open` time DEFAULT NULL,
  `close` time DEFAULT NULL,
  `geom` geometry DEFAULT NULL,
  `lat` decimal(10,8) NOT NULL,
  `lng` decimal(11,8) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `service_provider`
--

INSERT INTO `service_provider` (`id`, `name`, `address`, `employee_name`, `phone`, `description`, `open`, `close`, `geom`, `lat`, `lng`, `created_at`, `updated_at`) VALUES
('V1', 'Sewa Sepeda KTH Aka Barayun', 'Tarantang Village, Harau Subdistrict, Lima Puluh Kota Regency, West Sumatra Province', NULL, NULL, NULL, '09:00:00', '17:00:00', 0xe610000001030000000100000005000000b5134df8912a594079dd338736a8b9bfb413c58e922a594065c0f9e679aab9bfb41375c1912a5940afaeb7060cadb9bfb513f523912a5940d7ebf60696aab9bfb5134df8912a594079dd338736a8b9bf, '-0.10025986', '100.66515192', '2023-12-02 18:45:51', '2023-12-02 18:45:51'),
('V2', 'Bintang Stable Sewa Kuda', 'Tarantang Village, Harau Subdistrict, Lima Puluh Kota Regency, West Sumatra Province', NULL, NULL, NULL, '10:00:00', '17:00:00', 0xe610000001030000000100000009000000c42f1dfba42a59404e36d21ba4f3bcbfc32ffd54a72a59408efa611ae4febcbfc32fdd19a82a5940749eb21a6efcbcbfc32fdd54a92a5940dff7081bcbf9bcbfc22f7d00a92a5940b2007c1b47f6bcbfc32f7defaa2a5940880eec9bd9f2bcbfc42f5df2a92a5940c3b9ce1ce8ebbcbfc32f1d36a62a5940b1162e1cd4f0bcbfc42f1dfba42a59404e36d21ba4f3bcbf, '-0.11311949', '100.66650136', '2023-12-02 18:51:39', '2023-12-02 18:51:39'),
('V3', 'Camping Ground Sarasah Bunta', 'Tarantang Village, Harau Subdistrict, Lima Puluh Kota Regency, West Sumatra Province', 'Ujang', '082383456008', NULL, '00:00:00', '23:59:00', 0xe610000001030000000100000005000000ef5b8355562b5940171ae3c16601bcbff05b437a532b594079bf7fc0000dbcbfee5b8336572b594047a1c4be6a1bbcbfef5bc3e4592b5940af2b6ac0b40dbcbfef5b8355562b5940171ae3c16601bcbf, '-0.10959487', '100.67716587', '2023-12-02 18:55:32', '2023-12-02 18:55:32');

-- --------------------------------------------------------

--
-- Table structure for table `service_provider_gallery`
--

CREATE TABLE `service_provider_gallery` (
  `id` varchar(3) NOT NULL,
  `service_provider_id` varchar(2) NOT NULL,
  `url` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `service_provider_gallery`
--

INSERT INTO `service_provider_gallery` (`id`, `service_provider_id`, `url`, `created_at`, `updated_at`) VALUES
('001', 'V1', 'V1-1.jpg', '2023-12-02 18:45:51', '2023-12-02 18:45:51'),
('002', 'V2', 'V2-1.jpg', '2023-12-02 18:51:39', '2023-12-02 18:51:39'),
('003', 'V2', 'V2-2.jpg', '2023-12-02 18:51:39', '2023-12-02 18:51:39'),
('004', 'V2', 'V2-3.jpg', '2023-12-02 18:51:39', '2023-12-02 18:51:39'),
('005', 'V2', 'V2-4.jpg', '2023-12-02 18:51:39', '2023-12-02 18:51:39'),
('006', 'V3', 'V3-1.jpg', '2023-12-02 18:55:32', '2023-12-02 18:55:32'),
('007', 'V3', 'V3-2.jpg', '2023-12-02 18:55:32', '2023-12-02 18:55:32');

-- --------------------------------------------------------

--
-- Table structure for table `souvenir_place`
--

CREATE TABLE `souvenir_place` (
  `id` varchar(2) NOT NULL,
  `village_id` varchar(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `name` varchar(50) NOT NULL,
  `address` varchar(100) DEFAULT NULL,
  `employee_name` varchar(25) DEFAULT NULL,
  `phone` varchar(13) DEFAULT NULL,
  `open` time DEFAULT NULL,
  `close` time DEFAULT NULL,
  `geom` geometry DEFAULT NULL,
  `lat` decimal(10,8) NOT NULL,
  `lng` decimal(11,8) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `souvenir_place`
--

INSERT INTO `souvenir_place` (`id`, `village_id`, `name`, `address`, `employee_name`, `phone`, `open`, `close`, `geom`, `lat`, `lng`, `description`, `created_at`, `updated_at`) VALUES
('S1', '1', 'Wida Gallery 99 Sarasah Bunta', 'Tarantang village, Harau Subdistrict, Lima Puluh Kota Regency, West Sumatra Province', 'Wida', '082344125645', '10:00:00', '18:00:00', 0xe61000000103000000010000000500000086127dfd3a2b59400c2bed4b08e9bbbf8512fdf43b2b5940e17ff24bdbe8bbbf86127d0b3c2b5940517b374b02efbbbf8612bd083b2b5940232c424ba8eebbbf86127dfd3a2b59400c2bed4b08e9bbbf, '-0.10906880', '100.67550766', 'Selamat datang di Wida Gallery 99, destinasi yang memukau untuk menemukan cinderamata istimewa, yang terletak di dekat Sarasah Bunta! Wida Gallery 99 merupakan surga bagi para pencinta souvenir, menawarkan pengalaman berbelanja yang tak terlupakan di tengah-tengah keindahan lokal yang khas.', '2023-12-01 14:13:53', '2023-12-01 16:15:15'),
('S2', '1', 'Harau Collection & Souvenir', 'Tarantang Village, Harau Subdistrict, Lima Puluh Kota Regency, West Sumatra Province', 'Iwan', '082267348821', '10:00:00', '18:00:00', 0xe610000001030000000100000006000000fa7e921d732a5940edfd04e0c8febcbffa7e0215752a59402e0a0a80a1febcbffa7e1223752a594030bc775f1703bdbffb7ed228732a59407f346c5f7103bdbffa7e921d732a5940edfd04e0c8febcbffa7e921d732a5940edfd04e0c8febcbf, '-0.11329707', '100.66333778', 'Selamat datang di Harau Collection & Souvenir, destinasi yang memukau untuk menemukan cinderamata istimewa, yang terletak di Lembah Harau. Harau Collection & Souvenir merupakan surga bagi para pencinta souvenir, menawarkan pengalaman berbelanja yang tak terlupakan di tengah-tengah keindahan lokal yang khas.', '2023-12-01 16:44:52', '2023-12-01 16:45:32'),
('S3', '1', 'Harau Cell & Fashion', 'Tarantang Village, Harau Subdistrict, Lima Puluh Kota Regency, West Sumatra Province', 'Andi', '082211213349', '10:00:00', '18:00:00', 0xe610000001030000000100000006000000df514b7e4b2b5940b3e53046e1e0bbbfdd51b3524b2b594083f9ae252ae5bbbfdd5173554c2b5940c44d94250be6bbbfdd51f36b4c2b594095961926a6e1bbbfdf51b3ac4b2b5940dd902b460ee1bbbfdf514b7e4b2b5940b3e53046e1e0bbbf, '-0.10893954', '100.67650588', 'Harau Cell & Fashion bukan hanya sekadar toko, melainkan pusat inspirasi yang memadukan kecantikan budaya dan fesyen terkini. Dengan atmosfer yang ramah dan penuh semangat, setiap pengunjung diundang untuk menjelajahi koleksi souvenir yang dipilih dengan cermat dan penuh cinta.', '2023-12-01 17:16:18', '2023-12-01 17:17:47'),
('S4', '1', 'Sarasah Bunta Garden', 'Tarantang Village, Harau Subdistrict, Lima Puluh Kota Regency, West Sumatra Province', 'Wan', '081287723412', '09:00:00', '18:00:00', 0xe61000000103000000010000000500000038c2b2224d2b5940e301fbf550e7bbbf37c2f2684e2b59407c50d0f5b8e8bbbf37c2f20e4e2b5940757455f5c3ecbbbf38c272ea4c2b5940d83990f5d4eabbbf38c2b2224d2b5940e301fbf550e7bbbf, '-0.10903993', '100.67661517', 'Sarasah Bunta Garden bagaikan oase yang memelihara tanaman-tanaman endemik yang tumbuh subur di kawasan ini. Setiap sudut taman dipenuhi dengan keindahan alami dan aroma harum dari berbagai jenis tanaman yang khas. Dari flora yang langka hingga tanaman hias yang menawan, setiap pot dan wadah dipilih dengan hati untuk memamerkan keunikan dan keindahan masing-masing.', '2023-12-01 17:44:34', '2023-12-01 17:44:34');

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
  `souvenir_place_facility_id` varchar(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `souvenir_place_facility_detail`
--

INSERT INTO `souvenir_place_facility_detail` (`souvenir_place_id`, `souvenir_place_facility_id`) VALUES
('S1', '01'),
('S2', '01'),
('S3', '01'),
('S4', '01'),
('S1', '02'),
('S2', '02'),
('S3', '02'),
('S4', '02');

-- --------------------------------------------------------

--
-- Table structure for table `souvenir_place_gallery`
--

CREATE TABLE `souvenir_place_gallery` (
  `id` varchar(3) NOT NULL,
  `souvenir_place_id` varchar(2) NOT NULL,
  `url` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `souvenir_place_gallery`
--

INSERT INTO `souvenir_place_gallery` (`id`, `souvenir_place_id`, `url`, `created_at`, `updated_at`) VALUES
('001', 'S1', 'S1-1.jpg', '2023-12-01 16:15:16', '2023-12-01 16:15:16'),
('002', 'S1', 'S1-2.jpg', '2023-12-01 16:15:16', '2023-12-01 16:15:16'),
('003', 'S2', 'S2-1.jpg', '2023-12-01 16:45:32', '2023-12-01 16:45:32'),
('004', 'S2', 'S2-2.jpg', '2023-12-01 16:45:32', '2023-12-01 16:45:32'),
('005', 'S2', 'S2-3.jpg', '2023-12-01 16:45:32', '2023-12-01 16:45:32'),
('006', 'S3', 'S3-1.jpg', '2023-12-01 17:17:47', '2023-12-01 17:17:47'),
('007', 'S3', 'S3-2.jpg', '2023-12-01 17:17:47', '2023-12-01 17:17:47'),
('008', 'S4', 'S4-1.jpg', '2023-12-01 17:44:34', '2023-12-01 17:44:34'),
('009', 'S4', 'S4-2.jpg', '2023-12-01 17:44:34', '2023-12-01 17:44:34'),
('010', 'S4', 'S4-3.jpg', '2023-12-01 17:44:34', '2023-12-01 17:44:34');

-- --------------------------------------------------------

--
-- Table structure for table `souvenir_product`
--

CREATE TABLE `souvenir_product` (
  `id` varchar(2) NOT NULL,
  `name` varchar(50) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `souvenir_product`
--

INSERT INTO `souvenir_product` (`id`, `name`, `created_at`, `updated_at`) VALUES
('02', 'Baju Piyama Wisata', '2023-11-06 18:19:46', '2023-12-01 16:25:14'),
('03', 'Gantungan Kunci', '2023-11-06 18:22:31', '2023-12-01 16:25:41'),
('04', 'Miniatur Rumah Gadang', '2023-11-07 12:03:04', '2023-12-01 16:25:57'),
('05', 'Baju Kaos Wisata', '2023-11-07 16:45:41', '2023-12-01 16:26:13'),
('06', 'Tas Rajutan', '2023-12-01 16:26:28', '2023-12-01 16:26:28'),
('07', 'Gelang Tangan', '2023-12-01 16:26:40', '2023-12-01 16:26:40'),
('08', 'Pakis Monyet', '2023-12-01 16:27:00', '2023-12-01 16:27:00'),
('09', 'Topi Pantai', '2023-12-01 17:28:44', '2023-12-01 17:28:44'),
('10', 'Kacamata Sunglasses', '2023-12-01 17:37:44', '2023-12-01 17:37:44');

-- --------------------------------------------------------

--
-- Table structure for table `souvenir_product_detail`
--

CREATE TABLE `souvenir_product_detail` (
  `souvenir_place_id` varchar(2) NOT NULL,
  `souvenir_product_id` varchar(2) NOT NULL,
  `price` int(10) UNSIGNED NOT NULL,
  `image_url` text DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `souvenir_product_detail`
--

INSERT INTO `souvenir_product_detail` (`souvenir_place_id`, `souvenir_product_id`, `price`, `image_url`, `description`, `created_at`, `updated_at`) VALUES
('S1', '03', 2000, 'S1P-1.jpg', NULL, '2023-12-01 16:38:30', '2023-12-01 16:38:30'),
('S1', '05', 30000, 'S1P-2.jpg', 'Setiap baju kaos ini adalah potongan fesyen yang menceritakan cerita destinasi yang memikat. Dibuat dengan perhatian terhadap detail, kaos ini menjadi pilihan sempurna untuk mereka yang ingin merayakan dan mengenang setiap perjalanan mereka. Desainnya yang cerdas dan nyaman memastikan bahwa Anda tidak hanya terlihat modis, tetapi juga merasa nyaman sepanjang hari.', '2023-12-01 16:37:01', '2023-12-01 16:37:01'),
('S1', '06', 35000, 'S1P-3.jpg', 'Tas rajutan ini bukan sekadar aksesori, melainkan cerminan seni dan dedikasi pengrajinnya. Terbuat dari serat alami yang lembut dan tahan lama, setiap tas menjadi sebuah karya seni yang menggabungkan keanggunan fungsionalitas dengan daya tarik estetika.', '2023-12-01 16:29:17', '2023-12-01 16:29:17'),
('S1', '07', 4000, 'S1P-4.jpg', 'Gelang ini adalah perwujudan sempurna dari seni kerajinan tangan yang menggabungkan kehalusan dan keindahan. Dibuat dengan hati-hati oleh tangan ahli pengrajin, gelang ini bukan hanya sebuah aksesori, melainkan simbol dari keterampilan tinggi dan dedikasi terhadap seni.', '2023-12-01 16:34:31', '2023-12-01 16:39:09'),
('S2', '02', 35000, 'S2P-1.jpg', 'Setiap baju piyama ini adalah penggabungan harmonis antara kenyamanan dan inspirasi perjalanan. Terbuat dari bahan lembut yang memeluk tubuh dengan lembut, setiap sentuhan kain seperti memeluk kehangatan kasih sayang. Desainnya yang cerdas dan ergonomis memastikan tidur Anda menjadi pengalaman yang mewah, seolah-olah Anda berada dalam perjalanan indah di malam hari.', '2023-12-01 16:47:41', '2023-12-01 16:47:41'),
('S2', '03', 2000, 'S2P-2.jpg', NULL, '2023-12-01 16:49:25', '2023-12-01 16:49:25'),
('S2', '04', 120000, 'S2P-3.jpg', 'Setiap miniatur rumah gadang adalah pameran keahlian tinggi pengrajin yang mengabadikan kecantikan dan keunikannya. Dengan cermat dan teliti, setiap goresan menggambarkan keindahan arsitektur khas, dari atap bergonjong hingga hiasan-hiasan artistik yang menghiasi dindingnya. Setiap detail mengandung pesan sejarah dan nilai-nilai kultural yang diwariskan dari generasi ke generasi.', '2023-12-01 16:50:55', '2023-12-01 16:50:55'),
('S3', '02', 35000, 'S3P-1.jpg', NULL, '2023-12-01 17:26:19', '2023-12-01 17:26:19'),
('S3', '05', 30000, 'S3P-2.jpg', NULL, '2023-12-01 17:26:57', '2023-12-01 17:26:57'),
('S3', '09', 40000, 'S3P-3.jpg', NULL, '2023-12-01 17:30:59', '2023-12-01 17:30:59'),
('S3', '10', 35000, 'S3P-4.jpg', NULL, '2023-12-01 17:38:27', '2023-12-01 17:38:27'),
('S4', '08', 25000, 'S4P-1.jpg', NULL, '2023-12-01 17:46:48', '2023-12-01 17:46:48');

-- --------------------------------------------------------

--
-- Table structure for table `subdistrict`
--

CREATE TABLE `subdistrict` (
  `id` varchar(3) NOT NULL,
  `name` varchar(25) NOT NULL,
  `geom` varchar(50) NOT NULL
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
-- Table structure for table `tourist_area`
--

CREATE TABLE `tourist_area` (
  `id` varchar(2) NOT NULL,
  `name` varchar(30) NOT NULL,
  `address` text NOT NULL,
  `open` time NOT NULL,
  `close` time NOT NULL,
  `ticket_price` int(11) NOT NULL,
  `contact_person` varchar(13) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `video_url` text DEFAULT NULL,
  `geom` geometry DEFAULT NULL,
  `lat` decimal(10,8) DEFAULT NULL,
  `lng` decimal(11,8) DEFAULT NULL,
  `facebook` varchar(50) DEFAULT NULL,
  `instagram` varchar(50) DEFAULT NULL,
  `youtube` varchar(50) DEFAULT NULL,
  `tiktok` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tourist_area`
--

INSERT INTO `tourist_area` (`id`, `name`, `address`, `open`, `close`, `ticket_price`, `contact_person`, `description`, `video_url`, `geom`, `lat`, `lng`, `facebook`, `instagram`, `youtube`, `tiktok`) VALUES
('1', 'Lembah Harau', 'Lembah Harau Street, Tarantang village, Harau Subdistrict, Lima Puluh Kota Regency, West Sumatra Province, Indonesia, 25156', '08:00:00', '05:00:00', 5000, '081261499095', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ex lectus, malesuada ut feugiat id, scelerisque ac dui. Phasellus egestas posuere vestibulum. Proin ac elementum erat. Nunc gravida sollicitudin gravida. Sed quis diam non nisl imperdiet porttitor. Vivamus molestie arcu non mauris finibus gravida non eu erat. In eget enim a nisi dapibus elementum vitae id leo. Nunc sit amet neque non lacus molestie varius. Cras gravida ornare nisl, sed imperdiet augue efficitur id. Sed ac felis blandit, blandit nisl ac, mollis nisl. Nam nibh dolor, laoreet vel justo sed, aliquet maximus massa. Lorem ipsum dolor sit amet, consectetur adipiscing elit.', NULL, 0xe610000001030000000100000035000000c33bc741202a5940476a4554f3c7bebf4681caf2242a594087d1d3ee53d0bebfacc1814e322a5940d55c11a635e1bebfabc1814a452a5940dc9b9ca315f2bebfadc1818c5d2a5940c32725a1f502bfbfacc1812e702a594048431da0fd09bfbfacc1817e892a5940a3e8149f0511bfbfacc18190a42a5940ae07ab9ed513bfbfabc1819ab82a59407d0cd79d7519bfbfacc1817ac92a5940d7a99797a543bfbfacc18152d32a5940f8876e907573bfbfacc1812add2a5940e3c38a887da7bfbfabc181b6e72a59406cdce57fbddfbfbf6576822df52a59400a25a73ccd02c0bf6376828ffc2a594066468f3a2910c0bf647682171a2b594072fe478892a4bfbf64768295232b594088620b8e9a7ebfbf647682b3322b594087d5dd9ad228bfbf64768257522b5940ef9f4ac04223bebf637682975d2b594004eb06cc7acdbdbf6476823f6a2b5940a823fde31218bdbf6576828d762b5940eba688fc9a54bcbf647682b38c2b5940f85ac3203b1fbbbf637682479e2b59400ab08f34d369babf6476827dc22b59401d5a7e4d8b76b9bf647682cbce2b59400246155bebe9b8bf64768217ce2b5940f897ac5c0bd9b8bf6476825fb32b59402c3473675364b8bf64768231962b594069191f6b8b3bb8bf64768229622b5940ec9e7f6b5337b8bfac001d8a0c2b5940e40735321e66b8bfab001d76e42a59400c010830067eb8bfab001dc4c32a594056505e2ba6b0b8bf45d34089b02a59403bf82e9681efb8bf45d3408d9d2a5940f1bb2a8c9157b9bf45d3404b852a59405580f88011c8b9bf45d340fb6b2a5940700abc771122babf46d340e1492a5940a1321a69e1abbabf45d34045312a5940818be36569c9babf45d340ad052a5940d84ecf66f9c0babf45d34033e92959409ea5cb6d4980babf45d340abcb2959403aed4b6f3972babf44d340d9bb2959400d33ff6e0975babf45d340ef96295940456c706cf18cbabf45d3403dd0295940b67c5a41a108bcbf46d3408ff62959401ceb1a2669e5bcbf45d3408b092a5940e21265175157bdbf45d340d9152a5940c5bb810a59b8bdbf45d340791b2a5940f79e890171fabdbf44d340b11f2a594057a725fbd828bebf45d34043242a59406d1b20f09877bebf45d340e9232a5940b77e86e900a6bebfc33bc741202a5940476a4554f3c7bebf, '-0.11004370', '100.66716704', NULL, NULL, NULL, NULL),
('L1', 'Lembah Harau', 'Lembah Harau Street, Tarantang village, Harau Subdistrict, Lima Puluh Kota Regency, West Sumatra Province, Indonesia, 25156', '08:00:00', '17:00:00', 5000, '081261499095', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ex lectus, malesuada ut feugiat id, scelerisque ac dui. Phasellus egestas posuere vestibulum. Proin ac elementum erat. Nunc gravida sollicitudin gravida. Sed quis diam non nisl imperdiet porttitor. Vivamus molestie arcu non mauris finibus gravida non eu erat. In eget enim a nisi dapibus elementum vitae id leo. Nunc sit amet neque non lacus molestie varius. Cras gravida ornare nisl, sed imperdiet augue efficitur id. Sed ac felis blandit, blandit nisl ac, mollis nisl. Nam nibh dolor, laoreet vel justo sed, aliquet maximus massa. Lorem ipsum dolor sit amet, consectetur adipiscing elit.', NULL, 0xe610000001030000000100000040000000639fc0741f2a5940645edea446cebebf639fc06b282a59408ad093a218debebf639f40bf362a5940f3ed749f8af3bebf639f4080482a5940dd0bfa9a2012bfbf649f40ec632a5940327eda988a20bfbf649fc0aa702a5940ffebbf983e21bfbf639fc068852a5940255148986824bfbf909b1e3ca22a5940dc94a1406d2bbfbf909b1e8cbb2a59406157cc3f0d31bfbf919b1ed4cd2a5940f247ef396d58bfbf909b1e14d92a594098914f320d8bbfbfb4cd0881e72a594093fb5f2a15bfbfbfb4cd0807f82a59404f1ec6224df0bfbfb4cd0877002b59407dd0318f3606c0bfb4cd0837222b5940fbfdcc333581bfbfb3cd089e332b594024f881a07523bfbfb4cd084e472b5940d656c489557abebf912010cd5c2b59407a32b3a15dcdbdbf912010186c2b5940659b5b543bfbbcbf90201085772b594082ec3faff936bcbf902010a3862b5940e9a4f5c6e16dbbbf2dcace028c2b5940b2ce39e5a11fbbbf2ccace42972b59401957b6f091b7babf2dcacefe9e2b59403273ba26356dbabf8205c07bb02b5940bc3f2251fdf1b9bff253197dc32b5940963e245e9d70b9bfde8dee69cf2b5940b96ef66bdfeeb8bfdf8deed4cd2b5940a71ae36d7bdab8bfbf26ec6bb32b5940952c745ceb5eb8bfbe26ec10962b59402c897d5f2b3db8bfc026ecb9652b5940011dde5ff338b8bfc026ec783d2b59401bad985d4352b8bfc026ec09252b5940f203a55ccf5cb8bfc026ec67122b59409d1a025cd763b8bfc026ec4be32a59407e596259ab80b8bf8a6705edc32a594053f31b5513afb8bf8ad46348b02a594068ca7dd52deeb8bf8ad4631ca02a59401f4fc8cce148b9bf89d463ed922a59408b668fc62988b9bf8953cd08822a5940092302ec6ed3b9bf8953cd74702a594049e5a9e54e11babfd8fd95d9682a5940cd3e0fc09f2dbabfd7fd9537562a5940f78131b82778babf24e727e9482a594054590d6b45abbabf24e727a7302a594003d6d667cdc8babf24e727b2072a594083cbe968f5bebabf25e7273be8295940e34ff86f917dbabf24e727cfcc295940ff708b71cd6ebabf89e8dd45bb29594092410571b973babf89e8dd0f97295940956b636e558cbabf89e8dd2da62959409669e061f1febabf88e8dd0fc429594005708f4b69c2bbbf89e8dd5dd0295940b2cf0b429112bcbf89e8ddade929594064a3d530319fbcbfa9d73197f4295940ff17677932d8bcbfaad731dc092a59405c232e690e56bdbf1f1056df0f2a59406723df435286bdbf1f10562a1f2a5940df0b022f4e20bebf2e8e046d222a5940b00c143dbd57bebf308e0402242a594069939f386177bebf2e8e04d5232a5940edc16e34e994bebf2e8e0421232a5940ad3f85314da9bebf2f8e0432212a59407cdd972eb1bdbebf639fc0741f2a5940645edea446cebebf, '-0.10990430', '100.66718981', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tourist_area_gallery`
--

CREATE TABLE `tourist_area_gallery` (
  `id` varchar(2) NOT NULL,
  `tourist_area_id` varchar(1) NOT NULL,
  `url` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tourist_area_gallery`
--

INSERT INTO `tourist_area_gallery` (`id`, `tourist_area_id`, `url`) VALUES
('1', '1', 'L01.jpg'),
('2', '1', 'L02.jpg'),
('3', '1', 'L03.png'),
('4', '1', 'L04.jpg'),
('5', '1', 'L05.JPG');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `email` varchar(50) NOT NULL,
  `username` varchar(30) DEFAULT NULL,
  `first_name` varchar(30) DEFAULT NULL,
  `last_name` varchar(30) DEFAULT NULL,
  `address` varchar(100) DEFAULT NULL,
  `phone` varchar(13) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT 'default.jpg',
  `total_coin` int(11) DEFAULT NULL,
  `password_hash` varchar(255) NOT NULL,
  `reset_hash` varchar(255) DEFAULT NULL,
  `reset_at` datetime DEFAULT NULL,
  `reset_expires` datetime DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `status_message` varchar(255) DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 0,
  `activate_hash` varchar(255) DEFAULT NULL,
  `activate_expires` datetime DEFAULT NULL,
  `force_pass_reset` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

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
(48, 'nightbaron.369@gmail.com', 'nightbaron.369', NULL, NULL, NULL, NULL, 'f68254bf1e3971a8db7372a8cf572916663bbfe2.jpg', NULL, '$2y$10$VccF2VDE3ro/QDOYsokVyuS2Hh7JcS5WPZc6RiOsFCVZndI7qaREq', NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, 0, '2025-07-26 01:33:27', '2026-07-15 03:18:54', NULL),
(49, 'lukmanjunedd@gmail.com', 'lukmanjunedd', NULL, NULL, NULL, NULL, '26bdb3a2f303ebe71c80139b76a44dc5925d9636.jpg', NULL, '$2y$10$NhweBKCH8GNTLZelxB5qD.Z3QF1V0jA3OD9NutKcavX2quRplUfFu', NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, 0, '2025-07-26 01:48:41', '2025-07-29 00:40:16', NULL),
(50, 'dragon4feast@gmail.com', 'Dragon', NULL, NULL, NULL, NULL, 'default.jpg', NULL, '$2y$10$BUxPur3AaShsuS9e.HehjO5DLZSslyY3va/NPu0NyN/W06maZVwBi', NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, 0, '2026-01-11 23:05:45', '2026-01-11 23:15:09', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `village`
--

CREATE TABLE `village` (
  `id` varchar(3) NOT NULL,
  `name` varchar(100) NOT NULL,
  `geom_file` varchar(100) NOT NULL,
  `selected` char(1) NOT NULL DEFAULT '0',
  `description` text DEFAULT NULL,
  `ticket_price` int(11) DEFAULT NULL,
  `open` time DEFAULT NULL,
  `close` time DEFAULT NULL,
  `address` text DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `facebook` varchar(50) DEFAULT NULL,
  `instagram` varchar(50) DEFAULT NULL,
  `youtube` varchar(50) DEFAULT NULL,
  `tiktok` varchar(50) DEFAULT NULL,
  `video_url` text DEFAULT NULL,
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
('9', 'Sarilamak', 'V09.geojson', '0', NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `village_gallery`
--

CREATE TABLE `village_gallery` (
  `id` varchar(3) NOT NULL,
  `village_id` varchar(3) NOT NULL,
  `url` text NOT NULL,
  `description` varchar(5000) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `village_gallery`
--

INSERT INTO `village_gallery` (`id`, `village_id`, `url`, `description`) VALUES
('001', '1', '1.jpg', 'Discover the breathtaking beauty of Lembah Harau, a stunning natural canyon located in the Lima Puluh Kota district of West Sumatra. This fertile valley is famous for being flanked by colossal, sheer rock cliffs that create a dramatic and unforgettable landscape. The spectacular scenery, with its towering vertical walls, has earned Lembah Harau the nickname the \"Indonesian Yosemite,\" drawing comparisons to the famous national park in the United States.\r\n\r\nWhat makes Lembah Harau truly unique is its immense geological scale and history. You will find yourself surrounded by massive reddish-brown sandstone and granite cliffs that soar between 100 to 500 meters into the sky. Incredibly, geologists believe this entire area was once an ancient sea floor, a theory supported by the types of 40-million-year-old rocks found here. The valley is also adorned with numerous enchanting waterfalls that cascade down the cliff faces, including the beautiful falls found right here in Desa Wisata Tarantang.\r\n\r\nBecause of its exceptional geological significance, tectonic origins, and spectacular natural beauty, Lembah Harau is currently being proposed to become a UNESCO Global Geopark. A visit to Desa Wisata Tarantang is the perfect way to experience this aspiring world-class destination. Whether you are trekking along the base of the cliffs, cooling off in a fresh waterfall pool, or capturing photos of the magnificent rock walls, you are exploring one of Indonesia\'s most awe-inspiring natural wonders.'),
('002', '1', 'Air Terjun Sarasah Aie Luluih.png', 'Immerse yourself in the natural beauty of Sarasah Aie Luluh Waterfall, a stunning natural treasure tucked away in Desa Wisata Lembah Harau, Tarantang.\n\nThis captivating image captures the magnificent cascade of the waterfall as it tumbles down a rugged, jungle-draped cliff face. The refreshing water forms a large, inviting pool below, perfect for a cool swim or a relaxing float. As seen here, visitors can enjoy the refreshing water, even floating on a tire for added fun!\n\nSurrounded by lush green trees and the dramatic rock formations of the Harau Valley, Sarasah Aie Luluh offers a peaceful escape and a true connection with nature. It\'s a must-visit destination for adventure seekers and nature lovers alike.\n\nPlan your visit to Desa Wisata Lembah Harau and experience the magic of Sarasah Aie Luluh for yourself!'),
('003', '1', 'Air Terjun Sarasah Bunta.png', 'Experience the refreshing energy of Air Terjun Sarasah Bunta, one of the most beloved icons of Lembah Harau. Known for its wide, tiered cascade (\'Bunta\' implies tiered or multi-stream), this waterfall pours fresh, clear mountain water straight into a spacious natural pool, making it the perfect natural waterpark for visitors of all ages.\r\n\r\nSurrounded by the towering canyon walls of Tarantang, Sarasah Bunta is steeped in history and natural beauty. The pool is shallow enough for children to play safely and wide enough for adults to float on tubes and soak up the jungle atmosphere. Whether you are looking for a fun family picnic spot or a revitalizing swim in pure mountain water, Sarasah Bunta is an unmissable stop in our tourism village.'),
('004', '1', 'Harau Dream Park.png', 'Step into a world of color and culture at Harau Dream Park, a unique and vibrant attraction located right in the heart of Desa Wisata Lembah Harau. This park offers a delightful contrast to the natural ruggedness of the surrounding cliffs, featuring beautifully designed areas inspired by Japanese and Korean culture. You\'ll find iconic structures like a long row of bright orange torii gates, a charming red arched bridge over a peaceful pond, and traditional-style buildings with colorful green and blue roofs.\r\n\r\nHarau Dream Park is a photographer\'s paradise and a fantastic destination for families and friends. The meticulously landscaped gardens and themed architecture provide countless opportunities for fun. It’s a cheerful and relaxing spot where you can stroll through the manicured grounds, enjoy the cultural ambiance, and create lasting memories. The park\'s playful atmosphere makes it a hit with visitors of all ages, offering a different kind of adventure alongside the valley\'s natural wonders.\r\n\r\nLocated conveniently within Desa Wisata Tarantang, Harau Dream Park is an easily accessible stop on your Lembah Harau journey. It perfectly complements the area\'s stunning waterfalls and cliffs, offering a diverse and enjoyable experience for your entire group. Whether you\'re looking for a fun photo session or a leisurely walk in a beautiful setting, Harau Dream Park adds a touch of whimsy and wonder to your visit.'),
('005', '1', 'Harau Sky Dream World.png', 'Get ready for a day of excitement and refreshing fun at Harau Sky Dream World, a vibrant waterpark located in the beautiful Desa Wisata Tarantang, Lembah Harau. This colorful attraction is a perfect escape for families and friends, offering a cheerful contrast to the majestic natural surroundings. The waterpark features a large pool with a variety of thrilling water slides, playful fountains, and splash areas designed for children and adults alike. The bright, castle-themed architecture adds a touch of whimsy, making it a fantastic backdrop for your holiday photos.\r\n\r\nWhy is it a must-visit? Harau Sky Dream World provides a unique opportunity to enjoy modern water park fun while being completely immersed in the breathtaking scenery of Lembah Harau. Imagine sliding down a water slide with the colossal, reddish-brown cliffs towering right behind you! It’s an unforgettable experience that combines the thrill of a waterpark with the awe-inspiring beauty of nature.\r\n\r\nWhether you\'re looking to cool off on a hot day, keep the kids entertained for hours, or simply relax by the pool with a stunning view, Harau Sky Dream World has something for everyone. It’s an easily accessible and enjoyable addition to your Lembah Harau itinerary, ensuring a day filled with laughter, splashes, and incredible memories in the heart of West Sumatra\'s most spectacular valley.'),
('006', '1', 'Panorama Aka Barayun.png', 'Experience the awe-inspiring scale of Lembah Harau at Panorama aka Barayun, one of the most iconic viewpoints in Desa Wisata Lembah Harau. This site offers a front-row seat to the valley\'s legendary landscape, where massive, 500-meter-tall granite cliffs stand like ancient guardians over a sea of tropical greenery. It is the perfect place to witness the sheer verticality of the \"Indonesian Yosemite\" and understand why this area is an aspiring UNESCO Global Geopark.\n\nThe uniqueness of Barayun lies in the stunning combination of nature and local life. Right at the base of these colossal reddish-brown walls, you’ll find a thin, graceful waterfall cascading down the rock face, providing a refreshing mist to the air. Below the cliffs, a row of charming local stalls offers traditional Minangkabau snacks and refreshments, allowing you to enjoy a meal or a coffee while soaking in one of the most dramatic views in West Sumatra.\n\nA visit to Panorama aka Barayun is essential for any traveler seeking the perfect photo or a moment of quiet reflection. Whether you are marvelling at the geological history of the 40-million-year-old sandstone or simply watching the clouds roll over the cliff tops, Barayun captures the true soul of Lembah Harau. It is easily accessible and serves as the perfect starting point for your adventure through the hidden gems of Desa Wisata Lembah Harau.');

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
  `capacity` int(11) DEFAULT NULL,
  `geom` geometry DEFAULT NULL,
  `lat` decimal(10,8) NOT NULL,
  `lng` decimal(11,8) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `worship_place`
--

INSERT INTO `worship_place` (`id`, `village_id`, `name`, `worship_place_category`, `address`, `capacity`, `geom`, `lat`, `lng`, `description`, `created_at`, `updated_at`) VALUES
('W1', NULL, 'Masjid Raya Al-Muttaqin', '01', 'Tarantang Village, Harau Subdistrict, Lima Puluh Kota Regency, West Sumatra Province', 100, 0xe610000001030000000100000005000000f5a554ee772a5940ba53f3e79f3abcbff5a59437762a594043365666e547bcbff5a514ff792a59408f7588e57c4ebcbff4a554727b2a5940ad453167dd40bcbff5a554ee772a5940ba53f3e79f3abcbf, '-0.11042109', '100.66362499', 'Masjid Raya Al-Muttaqin adalah sebuah tempat ibadah Islam yang menakjubkan dan penuh makna, terletak di tengah Nagari Tarantang. Dibangun dengan arsitektur yang megah dan indah, masjid ini menjadi ikon keagamaan di Nagari Tarantang.', '2023-12-02 10:11:28', '2023-12-02 10:11:28'),
('W2', NULL, 'Mushalla Nurul Ikhlas', '02', 'Tarantang Village, Harau Subdistrict, Lima Puluh Kota Regency, West Sumatra Province', 50, 0xe61000000103000000010000000900000061c9dd3b7d2a594028bbc2bcab9ebcbf60c91d557e2a5940d015e93d7195bcbf62c95df87c2a5940b7dc313e2893bcbf61c9fda37c2a59407049cabd6896bcbf62c93d557c2a5940334bd83df895bcbf61c9dd2d7c2a5940b9779dbdd097bcbf60c95d717c2a5940a440843d9b98bcbf61c99df57b2a59409db00bbd629cbcbf61c9dd3b7d2a594028bbc2bcab9ebcbf, '-0.11170828', '100.66388830', NULL, '2023-12-02 10:16:46', '2023-12-02 10:17:48');

-- --------------------------------------------------------

--
-- Table structure for table `worship_place_category`
--

CREATE TABLE `worship_place_category` (
  `id` varchar(2) NOT NULL,
  `name` varchar(25) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

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
  `worship_place_facility_id` varchar(2) NOT NULL
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
  `url` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `worship_place_gallery`
--

INSERT INTO `worship_place_gallery` (`id`, `worship_place_id`, `url`, `created_at`, `updated_at`) VALUES
('001', 'W1', 'W1-1.jpg', '2023-12-02 10:11:28', '2023-12-02 10:11:28'),
('002', 'W2', 'W2-1.jpg', '2023-12-02 10:17:48', '2023-12-02 10:17:48');

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
-- Indexes for table `attraction_ticket_price`
--
ALTER TABLE `attraction_ticket_price`
  ADD PRIMARY KEY (`id`),
  ADD KEY `attraction_ticket_price_attraction_id_foreign` (`attraction_id`);

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
-- Indexes for table `event`
--
ALTER TABLE `event`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `event_date`
--
ALTER TABLE `event_date`
  ADD PRIMARY KEY (`event_id`,`date`),
  ADD KEY `event_date_ibfk_1` (`event_id`);

--
-- Indexes for table `event_gallery`
--
ALTER TABLE `event_gallery`
  ADD PRIMARY KEY (`id`),
  ADD KEY `event_gallery_ibfk_1` (`event_id`);

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
-- Indexes for table `package`
--
ALTER TABLE `package`
  ADD PRIMARY KEY (`homestay_id`,`package_id`),
  ADD KEY `package_ibfk_1` (`homestay_id`);

--
-- Indexes for table `package_day`
--
ALTER TABLE `package_day`
  ADD PRIMARY KEY (`homestay_id`,`package_id`,`day`),
  ADD KEY `package_day_ibfk_1` (`homestay_id`,`package_id`);

--
-- Indexes for table `package_detail`
--
ALTER TABLE `package_detail`
  ADD PRIMARY KEY (`homestay_id`,`package_id`,`day`,`activity`),
  ADD KEY `package_detail_ibfk_1` (`homestay_id`,`package_id`,`day`);

--
-- Indexes for table `package_service`
--
ALTER TABLE `package_service`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `package_service_detail`
--
ALTER TABLE `package_service_detail`
  ADD PRIMARY KEY (`homestay_id`,`package_id`,`package_service_id`),
  ADD KEY `package_service_detail_ibfk_2` (`package_service_id`),
  ADD KEY `package_service_detail_ibfk_1` (`homestay_id`,`package_id`);

--
-- Indexes for table `province`
--
ALTER TABLE `province`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `recommendation`
--
ALTER TABLE `recommendation`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

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
-- Indexes for table `reservation_package_detail`
--
ALTER TABLE `reservation_package_detail`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reservation_id` (`reservation_id`),
  ADD KEY `package_id` (`package_id`);

--
-- Indexes for table `service`
--
ALTER TABLE `service`
  ADD PRIMARY KEY (`id`),
  ADD KEY `service_service_provider_id_foreign` (`service_provider_id`);

--
-- Indexes for table `service_provider`
--
ALTER TABLE `service_provider`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `service_provider_gallery`
--
ALTER TABLE `service_provider_gallery`
  ADD PRIMARY KEY (`id`),
  ADD KEY `service_provider_gallery_service_provider_id_foreign` (`service_provider_id`);

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
-- Indexes for table `tourist_area`
--
ALTER TABLE `tourist_area`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tourist_area_gallery`
--
ALTER TABLE `tourist_area_gallery`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tourist_area_id` (`tourist_area_id`);

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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `auth_groups`
--
ALTER TABLE `auth_groups`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `auth_logins`
--
ALTER TABLE `auth_logins`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=906;

--
-- AUTO_INCREMENT for table `auth_permissions`
--
ALTER TABLE `auth_permissions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `auth_reset_attempts`
--
ALTER TABLE `auth_reset_attempts`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `auth_tokens`
--
ALTER TABLE `auth_tokens`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `reservation_package_detail`
--
ALTER TABLE `reservation_package_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

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
-- Constraints for table `event_date`
--
ALTER TABLE `event_date`
  ADD CONSTRAINT `event_date_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `event_gallery`
--
ALTER TABLE `event_gallery`
  ADD CONSTRAINT `event_gallery_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

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
  ADD CONSTRAINT `homestay_unit_unit_type_foreign` FOREIGN KEY (`unit_type`) REFERENCES `homestay_unit_type` (`id`);

--
-- Constraints for table `homestay_unit_facility_detail`
--
ALTER TABLE `homestay_unit_facility_detail`
  ADD CONSTRAINT `homestay_unit_facility_detail_ibfk_1` FOREIGN KEY (`homestay_id`,`unit_type`,`unit_number`) REFERENCES `homestay_unit` (`homestay_id`, `unit_type`, `unit_number`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `homestay_unit_facility_detail_ibfk_2` FOREIGN KEY (`facility_id`) REFERENCES `homestay_unit_facility` (`id`);

--
-- Constraints for table `homestay_unit_gallery`
--
ALTER TABLE `homestay_unit_gallery`
  ADD CONSTRAINT `homestay_unit_gallery_ibfk_1` FOREIGN KEY (`homestay_id`,`unit_type`,`unit_number`) REFERENCES `homestay_unit` (`homestay_id`, `unit_type`, `unit_number`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `package`
--
ALTER TABLE `package`
  ADD CONSTRAINT `package_ibfk_1` FOREIGN KEY (`homestay_id`) REFERENCES `homestay` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `package_day`
--
ALTER TABLE `package_day`
  ADD CONSTRAINT `package_day_ibfk_1` FOREIGN KEY (`homestay_id`,`package_id`) REFERENCES `package` (`homestay_id`, `package_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `package_detail`
--
ALTER TABLE `package_detail`
  ADD CONSTRAINT `package_detail_ibfk_1` FOREIGN KEY (`homestay_id`,`package_id`,`day`) REFERENCES `package_day` (`homestay_id`, `package_id`, `day`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `package_service_detail`
--
ALTER TABLE `package_service_detail`
  ADD CONSTRAINT `package_service_detail_ibfk_1` FOREIGN KEY (`homestay_id`,`package_id`) REFERENCES `package` (`homestay_id`, `package_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `package_service_detail_ibfk_2` FOREIGN KEY (`package_service_id`) REFERENCES `package_service` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

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
-- Constraints for table `service_provider_gallery`
--
ALTER TABLE `service_provider_gallery`
  ADD CONSTRAINT `service_provider_gallery_service_provider_id_foreign` FOREIGN KEY (`service_provider_id`) REFERENCES `service_provider` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

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
-- Constraints for table `tourist_area_gallery`
--
ALTER TABLE `tourist_area_gallery`
  ADD CONSTRAINT `tourist_area_gallery_ibfk_1` FOREIGN KEY (`tourist_area_id`) REFERENCES `tourist_area` (`id`);

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
