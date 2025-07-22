-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Feb 27, 2025 at 12:26 PM
-- Server version: 8.0.30
-- PHP Version: 8.2.4

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
  `employee_name` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `phone` varchar(13) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
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
('A1', '1', 'Kuburan Panjang DT Tantejo', 'Pariangan, Kec. Pariangan, Kabupaten Tanah Datar, Sumatera Barat ', '06:00:00', '18:00:00', 10000, 'Pokdarwis Pariangan', '082284978004', 'The length of this grave is around 24-25 m, based on the experience of the community and visitors who have measured the length of this grave, the results always change, sometimes it is 24, sometimes 25 m. The body that rests in this grave is Tantejo Gurhano, he was the one who first came up with the idea of ​​building a bagonjoang house inspired by a boat that had sharp corners at both ends. Tantejo Gurhano is thought to have lived during the Hindu-Buddhist era, when she died her body was burned according to Hindu-Buddhist religious rituals and her ashes were scattered throughout this cemetery area.', '', -0.45885615, 100.49400967, 0xe610000001030000000100000005000000e1972b6d9b1f594040e518fdad5cddbfe2974b0d9f1f594018a8e9df565bddbfe2974b48a01f5940fa37d5372f5fddbfe2974bf19c1f5940603527757560ddbfe1972b6d9b1f594040e518fdad5cddbf, '2025-01-08 21:21:14', '2025-01-31 06:03:14'),
('A10', '2', 'Surau Suri Maharajo', 'Pariangan, Kec. Pariangan, Kabupaten Tanah Datar, Sumatera Barat ', '03:00:00', '21:00:00', 0, 'Nagari Tuo Pariangan', '', '', '', -0.45823353, 100.49225133, 0xe610000001030000000100000005000000e53b0ccb801f594019adf667b852ddbfe43b8cef811f59408791e7c63953ddbfe33bec62811f5940ea66dd03ad54ddbfe43bec27801f5940579deca42b54ddbfe53b0ccb801f594019adf667b852ddbf, '2025-01-11 03:02:46', '2025-01-11 03:02:46'),
('A11', '2', 'Surau Melayu', 'Pariangan, Kec. Pariangan, Kabupaten Tanah Datar, Sumatera Barat ', '03:00:00', '21:00:00', 0, 'Nagari Tuo Pariangan', '', '', '', -0.45847879, 100.49211505, 0xe610000001030000000100000005000000bf13a15f7e1f5940207691f2ec56ddbfbf1381ab7f1f5940900d82516e57ddbfbf1381247f1f59408fb43fef8158ddbfbf13c1f47d1f594028c92b701158ddbfbf13a15f7e1f5940207691f2ec56ddbf, '2025-01-11 03:04:21', '2025-01-11 03:04:21'),
('A12', '2', 'Surau Inyiak Janna', 'Pariangan, Kec. Pariangan, Kabupaten Tanah Datar, Sumatera Barat ', '03:00:00', '21:00:00', 0, 'Nagari Tuo Pariangan', '', '', '', -0.45875639, 100.49186641, 0xe610000001030000000100000005000000602acbd3791f594030ad58096e5bddbf602aabd37b1f5940487e6469685bddbf602a8bb77b1f594008ceca251f5dddbf602acba6791f59404b5b2926f25cddbf602acbd3791f594030ad58096e5bddbf, '2025-01-11 03:06:04', '2025-01-11 03:06:04'),
('A2', '1', 'Batu Agam', 'Pariangan, Kec. Pariangan, Kabupaten Tanah Datar, Sumatera Barat ', '12:00:00', '23:59:00', 0, 'Pokdarwis Pariangan', '082284978004', 'Agam stone is one of the relics in Pariangan which is included in the 3 sajarangan stones, where the agam stone is directed towards the agam area', '', -0.45815154, 100.49220609, 0xe610000001030000000100000008000000aa48e4c6801f59404d422f59ea51ddbfab48a407801f5940e5be81f9c251ddbfab48a4ad7f1f5940e510f1378252ddbfaa48443a801f5940d05505b7f252ddbfab4844ee801f5940d18f9e97a952ddbfab4844ee801f594019fe2b186652ddbfac4804e3801f5940d88de8180c52ddbfaa48e4c6801f59404d422f59ea51ddbf, '2025-01-09 02:41:54', '2025-01-11 03:29:13'),
('A3', '1', 'Batu 50 Kota', 'Pariangan, Kec. Pariangan, Kabupaten Tanah Datar, Sumatera Barat ', '12:00:00', '23:59:00', 0, 'Pokdarwis Pariangan', '082284978004', 'The 50 Kota Stone is one of the relics in Pariangan which is included in the 3 Saurangan Stones, where the 50 Kota stones point towards the 50 Kota area.', '', -0.45884599, 100.49264716, 0xe6100000010300000001000000060000001a9ce479871f5940de5f5dc3315dddbf1a9c041d881f5940d65adba26f5dddbf1b9ca4f5871f594077231a61455eddbf199ca414871f59405af625c13f5eddbf1a9ce4f2861f5940032665e2a75dddbf1a9ce479871f5940de5f5dc3315dddbf, '2025-01-09 02:49:05', '2025-01-11 03:29:46'),
('A4', '1', 'Batu Tanah Datar', 'Pariangan, Kec. Pariangan, Kabupaten Tanah Datar, Sumatera Barat ', '12:00:00', '23:59:00', 0, 'Pokdarwis Pariangan', '082284978004', 'The Tanah Datar Stone is one of the relics in Pariangan which is included in the 3 Sajarangan Stones, where the Tanah Datar stones point towards the Tanah Datar area.', '', -0.45891036, 100.49210310, 0xe610000001030000000100000006000000864b3c227e1f594081194fcc4d5eddbf854b3c307f1f59400b09960c2c5eddbf874b5c4c7f1f5940972c2f8a505fddbf864b1c607e1f59405adeff09675fddbf854b9cef7d1f5940bd07044beb5eddbf864b3c227e1f594081194fcc4d5eddbf, '2025-01-09 04:56:23', '2025-01-11 02:07:50'),
('A5', '1', 'Masjid Ishlah', 'Pariangan, Kec. Pariangan, Kabupaten Tanah Datar, Sumatera Barat ', '03:00:00', '21:00:00', 0, 'Nagari Tuo Pariangan', '', 'Masjid Islah Nagari Tuo Pariangan is a historic mosque located in Nagari Pariangan, Tanah Datar Regency, West Sumatra. This mosque is known as one of the oldest religious buildings in Minangkabau, with traditional architecture that reflects strong cultural and religious values. Built with a dominant Minangkabau architectural style, this mosque has a gonjong-shaped roof, similar to the Minangkabau traditional house (rumah gadang), which gives a magnificent and distinctive impression. This building uses natural materials such as wood and stone, which makes it in line with the surrounding natural environment which is beautiful and beautiful.', '', -0.45851320, 100.49233294, 0xe610000001030000000100000008000000a4aac794801f59402ba5d79a7354ddbfa4aa272f861f59403ae582568456ddbfa3aae742851f594016d864b1f458ddbfa3aa474e831f5940f3f4c5da1b5cddbfa4aa2735801f59400153a84dbc5addbfa5aae7947e1f5940afb72f010e59ddbfa5aac7b37f1f594035b7a235ef56ddbfa4aac794801f59402ba5d79a7354ddbf, '2025-01-09 04:59:58', '2025-01-09 04:59:58'),
('A6', '2', 'Tabuah Larangan', 'Pariangan, Kec. Pariangan, Kabupaten Tanah Datar, Sumatera Barat ', '12:00:00', '23:59:00', 0, 'Nagari Tuo Pariangan', '', 'Tabuah Larangan Nagari Tuo Pariangan is a traditional cultural heritage from Nagari Tuo Pariangan, located in Tanah Datar, West Sumatra. It holds profound cultural and spiritual significance. This \"tabuah\" refers to a traditional communication tool, often a drum or gong, used by the local community to convey important messages. The beating of the tabuah follows specific rhythms to announce significant events such as adat (customary) meetings, warnings of danger, or religious ceremonies.\r\n\r\nIn Minangkabau tradition, the tabuah larangan holds sacred meaning and is governed by strict customary norms. Only specific individuals, such as adat leaders or elders (ninik mamak), are authorized to beat the tabuah, and it cannot be sounded carelessly. Its sound is believed to serve as a call for the community to gather and engage in discussions, ensuring harmony and the continuity of customary values in the village.\r\n\r\nThe existence of the tabuah larangan also reflects the local wisdom of the Minangkabau people in preserving tradition and fostering collective communication. To this day, the tabuah larangan of Nagari Tuo Pariangan remains a symbol of cultural identity, passed down through generations.', '', -0.45865213, 100.49220402, 0xe61000000103000000010000000700000014805cad801f59405a7f00b6125addbf15803ceb801f594034d4ad153a5addbf15803c91801f59409ecef8330a5bddbf13803cb07f1f5940543e1c54f95addbf13805c9f7f1f5940e46ccdf4a45addbf1480fc2b801f594096359655455addbf14805cad801f59405a7f00b6125addbf, '2025-01-09 05:05:28', '2025-01-11 02:11:32'),
('A7', '2', 'Panorama Pariangan', 'Pariangan, Kec. Pariangan, Kabupaten Tanah Datar, Sumatera Barat ', '06:00:00', '22:00:00', 0, 'Nagari Tuo Pariangan', '', '', '', -0.44612581, 100.48522601, 0xe610000001030000000100000005000000e65a6114fa1e59404ead4d51c485dcbfe65ae1bb0e1f594096aae066de7adcbfe65a61ce211f59404077b82e2b97dcbfe65ae13d051f594027f78a1dc89fdcbfe65a6114fa1e59404ead4d51c485dcbf, '2025-01-11 02:30:24', '2025-01-11 02:30:36'),
('A8', '2', 'Surau Bandaro Kayo', 'Pariangan, Kec. Pariangan, Kabupaten Tanah Datar, Sumatera Barat ', '03:00:00', '21:00:00', 0, 'Nagari Tuo Pariangan', '', '', '', -0.45832160, 100.49214289, 0xe610000001030000000100000005000000e5c7e2bd7e1f5940d09c2e2eca53ddbfe5c742047e1f5940badae549d555ddbfe5c742c67f1f594033f083087e56ddbfe4c78285801f5940f20dfc6c5c54ddbfe5c7e2bd7e1f5940d09c2e2eca53ddbf, '2025-01-11 02:39:47', '2025-01-11 02:58:45'),
('A9', '2', 'Surau Sampono Kayo', 'Pariangan, Kec. Pariangan, Kabupaten Tanah Datar, Sumatera Barat ', '03:00:00', '21:00:00', 0, 'Nagari Tuo Pariangan', '', '', '', -0.45810202, 100.49207359, 0xe610000001030000000100000005000000c4065fb77d1f5940542c52419950ddbfc306bf467f1f594066ff4e001551ddbfc2061f607e1f594074d95cfd7c52ddbfc306bffd7c1f5940bdaf77fef551ddbfc4065fb77d1f5940542c52419950ddbf, '2025-01-11 02:47:22', '2025-01-11 02:47:22');

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

--
-- Dumping data for table `attraction_facility_detail`
--

INSERT INTO `attraction_facility_detail` (`attraction_id`, `attraction_facility_id`, `created_at`, `updated_at`) VALUES
('A1', '01', '2025-01-31 06:03:14', '2025-01-31 06:03:14'),
('A10', '01', '2025-01-11 03:02:46', '2025-01-11 03:02:46'),
('A11', '01', '2025-01-11 03:04:21', '2025-01-11 03:04:21'),
('A12', '01', '2025-01-11 03:06:04', '2025-01-11 03:06:04'),
('A2', '01', '2025-01-11 03:29:13', '2025-01-11 03:29:13'),
('A3', '01', '2025-01-11 03:29:46', '2025-01-11 03:29:46'),
('A4', '01', '2025-01-11 02:07:50', '2025-01-11 02:07:50'),
('A5', '01', '2025-01-09 04:59:58', '2025-01-09 04:59:58'),
('A6', '01', '2025-01-11 02:11:32', '2025-01-11 02:11:32'),
('A6', '02', '2025-01-11 02:11:32', '2025-01-11 02:11:32'),
('A7', '01', '2025-01-11 02:30:36', '2025-01-11 02:30:36'),
('A7', '02', '2025-01-11 02:30:36', '2025-01-11 02:30:36'),
('A8', '01', '2025-01-11 02:58:45', '2025-01-11 02:58:45'),
('A9', '01', '2025-01-11 02:47:22', '2025-01-11 02:47:22');

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

--
-- Dumping data for table `attraction_gallery`
--

INSERT INTO `attraction_gallery` (`id`, `attraction_id`, `url`, `created_at`, `updated_at`) VALUES
('008', 'A5', '1736445552_7c3b409524517b78303a.webp', '2025-01-09 04:59:58', '2025-01-09 04:59:58'),
('009', 'A5', '1736445552_02f44c589d2a5c22cdfd.jpg', '2025-01-09 04:59:58', '2025-01-09 04:59:58'),
('015', 'A4', '1736608067_95024e2035d0dc61390b.jpg', '2025-01-11 02:07:50', '2025-01-11 02:07:50'),
('016', 'A4', '1736608067_9987847ba3804f1f8c12.jpg', '2025-01-11 02:07:50', '2025-01-11 02:07:50'),
('017', 'A6', '1736608128_33d475ad3f68c5f14b71.jpg', '2025-01-11 02:11:32', '2025-01-11 02:11:32'),
('018', 'A7', '1736609433_a8bd732068fccd31a7a0.jpeg', '2025-01-11 02:30:36', '2025-01-11 02:30:36'),
('019', 'A7', '1736609433_1503750170aa64a89878.jpeg', '2025-01-11 02:30:36', '2025-01-11 02:30:36'),
('026', 'A9', '1736610392_3cd5df0efc6257a2f0c7.jpg', '2025-01-11 02:47:22', '2025-01-11 02:47:22'),
('030', 'A8', '1736611122_1a063a2b8664a3d00524.jpg', '2025-01-11 02:58:45', '2025-01-11 02:58:45'),
('031', 'A8', '1736611122_0ed75d985d8bd8faf331.jpg', '2025-01-11 02:58:45', '2025-01-11 02:58:45'),
('032', 'A10', '1736611343_349d85fe810256868e2e.jpg', '2025-01-11 03:02:46', '2025-01-11 03:02:46'),
('033', 'A11', '1736611423_6a5682a865390be6216e.jpg', '2025-01-11 03:04:21', '2025-01-11 03:04:21'),
('034', 'A11', '1736611435_fc54ba576b470445cc1f.jpg', '2025-01-11 03:04:21', '2025-01-11 03:04:21'),
('035', 'A12', '1736611523_1822c249ec28f27fb0c8.jpg', '2025-01-11 03:06:04', '2025-01-11 03:06:04'),
('036', 'A12', '1736611533_6305eec4d15fb41c4eee.jpg', '2025-01-11 03:06:04', '2025-01-11 03:06:04'),
('037', 'A2', '1736612951_1943c6fbc97eac919929.jpg', '2025-01-11 03:29:13', '2025-01-11 03:29:13'),
('038', 'A2', '1736612951_bcce4b8835dc666d568d.jpg', '2025-01-11 03:29:13', '2025-01-11 03:29:13'),
('039', 'A3', '1736612983_ac49b19da9fc839f9386.jpg', '2025-01-11 03:29:46', '2025-01-11 03:29:46'),
('040', 'A3', '1736612983_af9cd5837eee73881127.jpg', '2025-01-11 03:29:46', '2025-01-11 03:29:46'),
('041', 'A1', '1738350178_a9b4f1d71ec1f60e24e4.jpg', '2025-01-31 06:03:14', '2025-01-31 06:03:14');

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
(1, 11),
(1, 32),
(2, 23),
(2, 24),
(2, 25),
(2, 29),
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
(732, '::1', 'umegahomestay@gmail.com', 23, '2025-02-27 06:20:45', 1);

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
('C2', '1', 'Kawa Daun  Tanjuang Putuih', 'Pariangan, Kec. Pariangan, Kabupaten Tanah Datar, Sumatera Barat ', 'Nasrudin', '081272053141', '09:00:00', '20:00:00', 0xe610000001030000000100000005000000e326fb26001f59402b10e9e49f85dcbfe2267bf1001f5940bd9e5f9eeb88dcbfe2261b32021f5940fb07073f9788dcbfe2263bd5021f5940d1c39026ca84dcbfe326fb26001f59402b10e9e49f85dcbf, -0.44573090, 100.48446610, 'Kawa Daun Tanjuang Putuih is a traditional café that offers a wide selection of food and beverages. Conveniently located, this café boasts stunning views, making it a perfect destination for relaxation and enjoyment.', '2024-10-25 04:38:34', '2025-01-10 01:16:29'),
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
  `profil_link` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `homestay`
--

INSERT INTO `homestay` (`id`, `village_id`, `name`, `category`, `address`, `geom`, `lat`, `lng`, `owner`, `open`, `close`, `max_people_for_event`, `description`, `video_url`, `created_at`, `updated_at`, `profil_link`) VALUES
('H12', '1', 'Homestay Umega', '2', 'Pariangan, Kec. Pariangan, Kabupaten Tanah Datar, Sumatera Barat ', 0xe6100000010300000001000000080000000713a515141f594075a82bd316a5dcbf0413e50f161f594056fa301514a4dcbf0613e5e2151f5940668b498887a2dcbf05134556151f5940477bc4ba49a1dcbf0613b534121f5940d6377fc7eca2dcbf0513c534111f5940e5707455f2a3dcbf0713e531121f594023f47431f2a5dcbf0713a515141f594075a82bd316a5dcbf, -0.44748639, 100.48557337, 23, '10:00:00', '23:59:00', 50, 'Homestay Umega MD in Nagari Tuo Pariangan is an accommodation that offers a stay experience with a strong local Minangkabau feel. Located in a village rich in history and culture, this homestay provides an opportunity for visitors to experience firsthand the atmosphere of traditional Minangkabau community life while enjoying beautiful natural scenery, with a backdrop of mountains and lush rice fields.', NULL, '2024-09-26 05:27:13', '2025-02-26 17:56:52', ''),
('H13', '1', 'Homestay Gudester', '2', 'Pariangan, Kec. Pariangan, Kabupaten Tanah Datar, Sumatera Barat ', 0xe6100000010300000001000000050000001dc09e63081f59407ec8ede3dfa0dcbf1cc01e0f0a1f5940c98d5f80a7a2dcbf1ec0feb40b1f5940924004a4d4a0dcbf1dc0be140a1f5940e50692070d9fdcbf1dc09e63081f59407ec8ede3dfa0dcbf, -0.44731766, 100.48498829, 24, '10:00:00', '23:59:00', 50, 'Gudester Pariangan Homestay is a modern homestay that exclusively offers rooms. Each room features a breathtaking view of the rice fields.', NULL, '2024-10-25 19:48:36', '2025-01-21 06:40:00', ''),
('H14', '1', 'Homestay Nabila', '2', 'Pariangan, Kec. Pariangan, Kabupaten Tanah Datar, Sumatera Barat ', 0xe6100000010300000001000000070000006c9b975dc61e5940c422477d5b8edcbf6d9b779bc61e5940a53cea990c90dcbf6c9b973ec71e5940aac034576991dcbf6c9b97b4c91e5940385ed1971a91dcbf6c9b574fc91e5940ceae26feea8ddcbf6c9b97b7c61e5940ee5052dd558edcbf6c9b975dc61e5940c422477d5b8edcbf, -0.44626860, 100.48095920, 25, '10:00:00', '23:59:00', 50, 'Nabila Homestay in Pariangan is a comfortable accommodation that offers a blend of traditional Minangkabau architecture and modern comfort. Located in Pariangan Village, Tanah Datar, this homestay presents expansive views of green rice paddies and surrounding hills, making it the perfect place for guests who want to enjoy the tranquility and natural beauty of West Sumatra. ', NULL, '2024-10-25 19:55:23', '2025-01-21 06:36:53', '');

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

--
-- Dumping data for table `homestay_additional_amenities`
--

INSERT INTO `homestay_additional_amenities` (`homestay_id`, `additional_amenities_id`, `additional_amenities_type`, `name`, `category`, `price`, `is_order_count_per_day`, `is_order_count_per_person`, `is_order_count_per_room`, `stock`, `description`, `image_url`, `created_at`, `updated_at`) VALUES
('H12', '01', '1', 'Bed', '1', 100000, '0', '0', '1', 5, 'Extra Bed\r\n', '1734369782_7c2e5e33b62cf15eab04.jpg', '2024-09-29 01:07:22', '2024-12-16 04:23:16'),
('H12', '02', '1', 'Breakfast', '2', 15000, '1', '1', '0', 0, 'Breakfast', '1734369797_c86ef3b4dcca248b4279.jpeg', '2024-10-25 19:40:28', '2024-12-16 04:23:28'),
('H12', '03', '1', 'Lunch', '2', 15000, '1', '1', '0', 0, 'Request menu for lunch\r\n', '1740564370_6f6774055689d2e08ba2.jpeg', '2024-10-25 19:40:51', '2025-02-25 21:06:19'),
('H12', '04', '1', 'Dinner', '2', 15000, '1', '1', '0', 0, 'Request menu for dinner', '1734369859_e19d2a6a517c511e29c6.jpg', '2024-10-25 19:41:33', '2024-12-16 04:24:34'),
('H12', '05', '2', 'Sound System', '1', 1000000, '0', '0', '0', 5, 'Sound system', '1734369946_5c4ca5a23b5212dbbb05.webp', '2024-12-15 02:43:14', '2024-12-16 04:25:49'),
('H12', '06', '2', 'Extra Bed for Event', '1', 300000, '0', '0', '0', 5, 'Extra Bed', '1735373719_0b68c2f67a577d0cdd61.jpg', '2024-12-27 19:14:57', '2024-12-27 19:16:22'),
('H13', '01', '1', 'Extra Bed', '1', 250000, '0', '1', '1', 3, 'Kasur Tambahan', '1729929786_7a8905841bc12e975475.jpg', '2024-10-25 20:03:17', '2024-10-25 20:03:17'),
('H13', '02', '1', 'Makan siang', '2', 20000, '1', '1', '0', 0, 'Bisa Request', '1729929833_36273e691e8717a109a1.jpeg', '2024-10-25 20:03:55', '2024-10-25 20:03:55'),
('H13', '03', '1', 'Makan Malam', '2', 20000, '1', '1', '0', 0, 'Bisa Request', '1729929895_3acd79ef24efa42d0ad4.jpg', '2024-10-25 20:04:58', '2024-10-25 20:04:58'),
('H14', '01', '1', 'Breakfast', '2', 15000, '1', '1', '0', 0, 'Request breakfast', '1737488030_1e7bb499298d3687c3cc.jpeg', '2024-10-25 20:14:44', '2025-01-21 06:34:18'),
('H14', '02', '1', 'Extra Bed', '1', 250000, '1', '0', '0', 5, 'Kasur Tambahan', '1729930540_c556b1165d86231b345a.jpg', '2024-10-25 20:15:42', '2024-10-25 20:15:42'),
('H14', '03', '1', 'Lunch', '2', 20000, '1', '1', '0', 0, 'Request lunch', '1737488059_b64c1dd57c4784505fd6.jpeg', '2024-10-25 20:16:21', '2025-01-21 06:34:51'),
('H14', '04', '1', 'Dinner', '2', 20000, '1', '1', '0', 0, 'Request dinner', '1737488092_abf26f0aa190b5c3f2e3.jpg', '2024-10-25 20:17:00', '2025-01-21 06:35:10'),
('H14', '05', '1', 'Bajamba', '2', 30000, '0', '1', '0', 0, 'Makan Bajamba', '1729930848_b080699b1d12b4a89bcf.jpeg', '2024-10-25 20:20:51', '2024-10-25 20:20:51');

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

--
-- Dumping data for table `homestay_certification`
--

INSERT INTO `homestay_certification` (`homestay_id`, `certification_id`, `certificate_name`, `certificate_num`, `certifying_agency`, `date`, `description`, `image_url`) VALUES
('H14', '001', 'CHSE STANDART', 'CH5E03399/2021', 'Mentri Pariwisata dan Ekonomi Kreatif', '2021-09-19', 'Sertifikat yang diberikan oleh Kementrian Pariwisata dan Ekonomi Kreatif / Kepala Badan Pariwisata dan Ekonomi Kreatif Republik Indonesia', '1729930091_716199ff1f02f963f6f7.jpg');

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
('H12', '01', '2025-02-26 17:56:52', '2025-02-26 17:56:52'),
('H12', '02', '2025-02-26 17:56:52', '2025-02-26 17:56:52'),
('H12', '03', '2025-02-26 17:56:52', '2025-02-26 17:56:52'),
('H13', '01', '2025-01-21 06:40:00', '2025-01-21 06:40:00'),
('H13', '03', '2025-01-21 06:40:00', '2025-01-21 06:40:00'),
('H13', '04', '2025-01-21 06:40:00', '2025-01-21 06:40:00'),
('H13', '05', '2025-01-21 06:40:00', '2025-01-21 06:40:00'),
('H14', '01', '2025-01-21 06:36:53', '2025-01-21 06:36:53'),
('H14', '02', '2025-01-21 06:36:53', '2025-01-21 06:36:53'),
('H14', '04', '2025-01-21 06:36:53', '2025-01-21 06:36:53');

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
('016', 'H14', '1737488198_93f9d038097c821a29e4.jpg', '2025-01-21 06:36:53', '2025-01-21 06:36:53'),
('017', 'H13', '1737488391_d5e61d4aee21d8bc60e0.jpg', '2025-01-21 06:40:00', '2025-01-21 06:40:00'),
('018', 'H12', '1740639409_2cba50d79a7409d7a178.jpg', '2025-02-26 17:56:52', '2025-02-26 17:56:52'),
('019', 'H12', '1740639395_727db221d9d09c53ee79.jpg', '2025-02-26 17:56:52', '2025-02-26 17:56:52'),
('020', 'H12', '1740639395_006e1098cfb226f54a50.jpg', '2025-02-26 17:56:52', '2025-02-26 17:56:52');

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
('H12', '1', '1', 'Room 1', 350000, 2, 'Room 1\r\n', '2024-09-29 01:05:21', '2024-12-16 04:22:23'),
('H12', '1', '2', 'Room 2', 350000, 2, 'Room 2', '2024-09-29 01:05:52', '2025-01-23 20:13:30'),
('H12', '1', '3', 'Room 3', 350000, 2, 'Room 3', '2024-09-29 01:06:32', '2025-01-23 20:15:24'),
('H12', '1', '4', 'Room 4', 350000, 2, 'Room 4', '2024-10-25 07:29:25', '2025-01-23 20:15:41'),
('H12', '1', '5', 'Room 5', 350000, 2, 'Room 5', '2024-10-25 07:29:37', '2025-01-23 20:15:55'),
('H13', '1', '1', 'Kamar 1', 400000, 2, 'Free breakfast', '2024-10-25 20:00:05', '2024-10-25 20:00:05'),
('H13', '1', '2', 'Kamar 2', 400000, 2, 'Free breakfast', '2024-10-25 20:01:19', '2024-10-25 20:01:19'),
('H13', '1', '3', 'Kamar 3', 400000, 2, 'Free breakfast', '2024-10-25 20:02:05', '2025-01-21 06:29:43'),
('H14', '1', '1', 'Room 1', 300000, 2, 'Room 1', '2024-10-25 20:11:07', '2025-01-21 06:35:32'),
('H14', '1', '2', 'Room 2', 300000, 2, 'Room 2', '2024-10-25 20:14:01', '2025-01-21 06:35:52');

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
('H12', '1', '1', '07', 'King Size', '2024-10-25 07:10:23', '2025-01-25 05:05:23'),
('H12', '1', '1', '08', NULL, '2024-10-25 07:11:28', '2024-10-25 07:11:28'),
('H12', '1', '1', '09', NULL, '2024-10-25 07:26:10', '2024-10-25 07:26:10'),
('H12', '1', '2', '07', NULL, '2024-10-25 07:25:47', '2024-10-25 07:25:47'),
('H12', '1', '2', '08', NULL, '2024-10-25 07:25:59', '2024-10-25 07:25:59'),
('H12', '1', '2', '09', NULL, '2024-10-25 07:25:54', '2024-10-25 07:25:54'),
('H12', '1', '3', '07', NULL, '2024-10-25 07:28:04', '2024-10-25 07:28:04'),
('H12', '1', '3', '08', NULL, '2024-10-25 07:28:07', '2024-10-25 07:28:07'),
('H12', '1', '3', '09', NULL, '2024-10-25 07:28:12', '2024-10-25 07:28:12'),
('H12', '1', '4', '07', NULL, '2024-10-25 07:31:49', '2024-10-25 07:31:49'),
('H12', '1', '4', '08', NULL, '2024-10-25 07:31:45', '2024-10-25 07:31:45'),
('H12', '1', '4', '09', NULL, '2024-10-25 07:31:54', '2024-10-25 07:31:54'),
('H12', '1', '5', '07', NULL, '2024-10-25 07:29:42', '2024-10-25 07:29:42'),
('H12', '1', '5', '08', NULL, '2024-10-25 07:29:49', '2024-10-25 07:29:49'),
('H12', '1', '5', '09', NULL, '2024-10-25 07:29:53', '2024-10-25 07:29:53'),
('H13', '1', '1', '06', 'Shower', '2024-10-25 20:00:41', '2024-10-25 20:00:41'),
('H13', '1', '1', '07', 'King Size\r\n', '2024-10-25 20:00:25', '2024-10-25 20:00:25'),
('H13', '1', '1', '09', NULL, '2024-10-25 20:00:29', '2024-10-25 20:00:29'),
('H13', '1', '2', '06', 'Shower', '2024-10-25 20:01:29', '2024-10-25 20:01:29'),
('H13', '1', '2', '07', 'King Size', '2024-10-25 20:01:38', '2024-10-25 20:01:38'),
('H13', '1', '2', '09', NULL, '2024-10-25 20:01:42', '2024-10-25 20:01:42'),
('H13', '1', '3', '06', 'Shower', '2024-10-25 20:02:25', '2024-10-25 20:02:25'),
('H13', '1', '3', '07', 'King Size', '2024-10-25 20:02:13', '2024-10-25 20:02:13'),
('H13', '1', '3', '09', NULL, '2024-10-25 20:02:19', '2024-10-25 20:02:19'),
('H14', '1', '1', '06', NULL, '2024-10-25 20:12:43', '2024-10-25 20:12:43'),
('H14', '1', '1', '07', NULL, '2024-10-25 20:11:20', '2024-10-25 20:11:20'),
('H14', '1', '1', '09', NULL, '2024-10-25 20:11:16', '2024-10-25 20:11:16'),
('H14', '1', '2', '06', NULL, '2024-10-25 20:14:07', '2024-10-25 20:14:07'),
('H14', '1', '2', '07', NULL, '2024-10-25 20:14:17', '2024-10-25 20:14:17'),
('H14', '1', '2', '09', NULL, '2024-10-25 20:14:13', '2024-10-25 20:14:13');

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
('051', 'H13', '1', '1', '1729929602_f121029ca16bd5e91ef4.jpg', '2024-10-25 20:00:05', '2024-10-25 20:00:05'),
('052', 'H13', '1', '2', '1729929677_e8fcf9c699dc2f2d9c40.jpeg', '2024-10-25 20:01:19', '2024-10-25 20:01:19'),
('061', 'H12', '1', '1', '1734369732_5f977ccc009972cec611.jpg', '2024-12-16 04:22:23', '2024-12-16 04:22:23'),
('066', 'H13', '1', '3', '1737487779_2f03dce596a9b9bc8ec4.jpeg', '2025-01-21 06:29:43', '2025-01-21 06:29:43'),
('067', 'H14', '1', '1', '1737488122_bb0d3bc9b68ac4b75106.jpg', '2025-01-21 06:35:32', '2025-01-21 06:35:32'),
('068', 'H14', '1', '2', '1737488146_ab53262428641452fe91.jpeg', '2025-01-21 06:35:52', '2025-01-21 06:35:52'),
('069', 'H12', '1', '2', '1737710007_fd6398aea1dfc6cb3d8c.jpg', '2025-01-23 20:13:30', '2025-01-23 20:13:30'),
('070', 'H12', '1', '3', '1737710122_bb046bcff71b0ea6dd66.jpg', '2025-01-23 20:15:24', '2025-01-23 20:15:24'),
('071', 'H12', '1', '4', '1737710139_fb5e9ea1e2072b10b7e2.jpg', '2025-01-23 20:15:42', '2025-01-23 20:15:42'),
('072', 'H12', '1', '5', '1737710152_94c8efe7e4c1a44d94f3.jpg', '2025-01-23 20:15:55', '2025-01-23 20:15:55');

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

--
-- Dumping data for table `reservation`
--

INSERT INTO `reservation` (`id`, `customer_id`, `reservation_type`, `request_date`, `check_in`, `total_people`, `review`, `rating`, `bonus_coin`, `coin_use`, `total_price`, `deposit`, `status`, `deposit_snap_token`, `pay_full_snap_token`, `reservation_finish_at`, `is_rejected`, `confirmed_at`, `feedback`, `canceled_at`, `cancelation_reason`, `is_refund`, `refund_paid_at`, `account_refund`, `refund_proof`, `is_refund_proof_correct`, `refund_paid_confirmed_at`) VALUES
('R016', 11, '1', '2024-10-11 17:27:25', '2024-10-17 14:00:00', 5, NULL, NULL, NULL, NULL, 600000, 120000, 'Done', '4833097b-9063-41f3-a17f-b69da590496d', 'e3ebbcd1-c32f-4463-90b2-e4e8881974b1', '2024-10-11 10:28:14', '0', '2024-10-11 10:28:36', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('R017', 11, '1', '2024-10-11 18:01:35', '2024-10-16 14:00:00', 3, NULL, NULL, NULL, NULL, 300000, 60000, 'Done', '102496c1-340b-46a6-8dc0-5d448bbfa432', 'dd38c12b-3253-48f4-8ab9-094672edd3fc', '2024-10-11 11:01:55', '0', '2024-10-11 11:02:05', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('R018', 11, '1', '2024-10-11 19:43:53', '2024-10-18 14:00:00', 3, NULL, NULL, NULL, NULL, 300000, 60000, 'Deposit Successful', '6adcf2de-e03a-4d34-8e0a-8386a3fd6122', NULL, '2024-10-11 12:44:00', '0', '2024-10-11 12:44:11', '', '2024-10-11 12:44:00', '1', '1', '2024-10-11 12:45:51', 'Dika - Bank ABC - 12345678', '1728650749_b4956a3c25ffc50fdb89.jpg', '1', '2024-10-11 12:46:09'),
('R019', 11, '1', '2024-10-11 19:55:11', '2024-10-11 14:00:00', 5, NULL, NULL, NULL, NULL, 600000, 120000, '1', 'c99df471-3896-4fe0-86b2-ea1f7dbe3937', NULL, '2024-10-11 12:55:18', '0', '2024-10-11 12:55:34', '', '2024-10-11 12:57:00', '2', '0', NULL, NULL, NULL, NULL, NULL),
('R020', 11, '1', '2024-10-11 19:57:46', '2024-10-11 14:00:00', 5, NULL, NULL, NULL, NULL, 600000, 120000, 'Deposit Successful', 'cd0ee0ad-a683-4789-8482-64b968721e80', '47366abc-d256-432d-9b9e-a4027ee6fbe7', '2024-10-11 12:57:53', '0', '2024-10-11 12:58:14', '', '2024-10-11 12:59:00', '3', '0', NULL, NULL, NULL, NULL, NULL),
('R021', 11, '1', '2024-10-14 12:13:35', '2024-10-18 14:00:00', 2, NULL, NULL, NULL, NULL, 150000, 30000, 'Deposit Successful', NULL, NULL, '2024-10-14 05:13:43', '0', '2024-10-14 05:14:49', '', '2024-10-21 14:21:00', '3', '0', NULL, NULL, NULL, NULL, NULL),
('R022', 11, '1', '2024-10-14 12:15:48', '2024-10-19 14:00:00', 2, NULL, NULL, NULL, NULL, 100000, 20000, 'Done', NULL, NULL, '2024-10-14 05:15:53', '0', '2024-10-14 05:16:05', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('R023', 11, '1', '2024-10-14 12:16:38', '2024-10-19 14:00:00', 2, NULL, NULL, NULL, NULL, 200000, 40000, 'Done', NULL, NULL, '2024-10-14 05:16:43', '0', '2024-10-14 05:16:58', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('R024', 11, '1', '2024-10-14 18:24:24', '2024-10-12 14:00:00', 3, '', 4, NULL, NULL, 250000, 50000, 'Done', '7aa3b21e-431e-4dba-9d61-306902c1781a', '1a47ed95-4544-464d-bc00-90d71d1c4b97', '2024-10-14 11:25:31', '0', '2024-10-14 11:26:01', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('R025', 11, '1', '2024-10-14 18:42:36', '2024-10-20 14:00:00', 3, NULL, NULL, NULL, NULL, 400000, 80000, 'Deposit Successful', '36d6cb5a-8370-4db5-b724-7af3c77c2322', NULL, '2024-10-14 11:42:55', '0', '2024-10-14 11:43:14', '', '2024-10-14 11:45:00', '1', '1', '2024-10-14 11:47:45', 'Wawan - Bank CAB - 69696969', '1728906462_81e712e85c31e9c4bacd.jpg', '1', '2024-10-14 11:48:15'),
('R026', 11, '1', '2024-10-14 18:49:16', '2024-10-12 14:00:00', 3, NULL, NULL, NULL, NULL, 100000, 20000, '1', '985d0337-858c-43e1-b76d-a5c617746694', NULL, '2024-10-14 11:49:21', '0', '2024-10-14 11:49:36', '', '2024-10-14 11:50:00', '2', '0', NULL, NULL, NULL, NULL, NULL),
('R027', 11, '1', '2024-10-14 20:47:57', '2024-10-20 14:00:00', 2, NULL, NULL, NULL, NULL, 300000, 60000, 'Done', '7bf4ba9e-58ee-4923-8b9a-f2c1dcd04077', '818786ed-9c35-4397-883b-6d3c511ceefc', '2024-10-14 13:48:40', '0', '2024-10-14 13:48:48', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('R028', 11, '1', '2024-10-21 21:21:53', '2024-10-20 14:00:00', 2, 'mantap', 5, NULL, NULL, 300000, 60000, 'Done', '649e8678-240a-4860-839c-8a185389ab5c', '285a8c3e-fb15-4f52-9734-a97cf83d69d6', '2024-10-21 14:22:10', '0', '2024-10-21 14:22:29', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('R029', 11, '1', '2024-10-26 15:43:29', '2024-10-23 14:00:00', 2, 'bagus', 5, NULL, NULL, 840000, 168000, 'Done', '785c69af-5675-4a5c-8b7c-5adcdf4bd0ce', '8bc0f8f6-4246-4262-9712-baf745cf99fb', '2024-10-26 08:43:52', '0', '2024-10-26 08:44:07', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('R030', 11, '1', '2024-10-26 17:07:52', '2024-10-31 14:00:00', 4, NULL, NULL, NULL, NULL, 350000, 70000, '1', NULL, NULL, '2024-10-26 10:08:15', '1', '2024-10-26 10:08:39', '', '2024-10-30 09:45:00', '2', '0', NULL, NULL, NULL, NULL, NULL),
('R031', 11, '1', '2024-11-17 17:45:13', '2024-11-20 14:00:00', 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-11-24 07:45:00', '2', '0', NULL, NULL, NULL, NULL, NULL),
('R032', 11, '1', '2024-11-24 14:57:58', '2024-11-27 14:00:00', 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-11-26 14:20:00', '2', '0', NULL, NULL, NULL, NULL, NULL),
('R033', 11, '1', '2024-11-30 14:51:08', '2024-12-03 14:00:00', 5, NULL, NULL, NULL, NULL, 1399998, 280000, '0', NULL, NULL, '2024-11-30 08:55:03', NULL, NULL, NULL, '2024-12-14 17:07:00', '2', '0', NULL, NULL, NULL, NULL, NULL),
('R034', 11, '2', '2024-11-30 16:08:54', '2024-12-05 14:00:00', 50, NULL, NULL, NULL, NULL, 3500000, 700000, '0', NULL, NULL, '2024-11-29 20:08:54', NULL, NULL, NULL, '2024-12-14 17:07:00', '2', '0', NULL, NULL, NULL, NULL, NULL),
('R035', 11, '2', '2024-12-14 23:59:01', '2024-12-17 14:00:00', 50, NULL, NULL, NULL, NULL, 4725000, 945000, '0', NULL, NULL, '2024-12-14 03:59:01', NULL, NULL, NULL, '2024-12-15 15:50:00', '2', '0', NULL, NULL, NULL, NULL, NULL),
('R036', 11, '2', '2024-12-15 23:05:24', '2024-12-18 14:00:00', 20, NULL, NULL, NULL, NULL, 4725000, 945000, '0', NULL, NULL, '2024-12-15 03:05:24', NULL, NULL, NULL, '2024-12-16 15:08:00', '2', '0', NULL, NULL, NULL, NULL, NULL),
('R037', 11, '2', '2024-12-15 23:06:36', '2024-12-21 14:00:00', 20, NULL, NULL, NULL, NULL, 3150000, 630000, '0', NULL, NULL, '2024-12-15 03:06:36', NULL, NULL, NULL, '2024-12-24 14:46:00', '2', '0', NULL, NULL, NULL, NULL, NULL),
('R038', 11, '1', '2024-12-16 10:09:28', '2024-12-26 14:00:00', 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-12-24 14:46:00', '2', '0', NULL, NULL, NULL, NULL, NULL),
('R039', 11, '2', '2024-12-16 10:10:19', '2024-12-27 14:00:00', 4, NULL, NULL, NULL, NULL, 3150000, 630000, '1', NULL, NULL, '2024-12-15 14:10:19', '1', '2024-12-16 04:10:13', '', '2024-12-26 12:34:00', '2', '0', NULL, NULL, NULL, NULL, NULL),
('R040', 11, '1', '2024-12-16 10:17:10', '2024-12-23 14:00:00', 1, NULL, NULL, NULL, NULL, 350000, 70000, '1', NULL, NULL, '2024-12-16 03:17:39', '1', '2024-12-16 04:09:58', '', '2024-12-24 14:46:00', '2', '0', NULL, NULL, NULL, NULL, NULL),
('R041', 11, '2', '2024-12-16 11:06:50', '2024-12-31 14:00:00', 1, NULL, NULL, NULL, NULL, 1575000, 315000, '1', NULL, NULL, '2024-12-15 15:06:50', '1', '2024-12-16 04:09:49', '', '2025-01-04 16:00:00', '2', '0', NULL, NULL, NULL, NULL, NULL),
('R042', 11, '1', '2024-12-16 11:08:59', '2024-12-31 14:00:00', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-01-04 16:00:00', '2', '0', NULL, NULL, NULL, NULL, NULL),
('R043', 11, '1', '2024-12-16 11:09:08', '2024-12-25 14:00:00', 1, NULL, NULL, NULL, NULL, 350000, 70000, 'Deposit Successful', '60442d37-f437-4260-9187-93296cbe8e0c', 'eff6a69c-2e16-415f-ac0d-e6b8c9648721', '2024-12-16 04:11:00', '0', '2024-12-16 04:11:08', '', '2024-12-26 12:34:00', '3', '0', NULL, NULL, NULL, NULL, NULL),
('R044', 11, '1', '2024-12-16 11:16:38', '2024-12-27 14:00:00', 2, NULL, NULL, NULL, NULL, 350000, 70000, '1', NULL, NULL, '2024-12-16 15:09:30', '1', '2024-12-16 15:10:03', '', '2024-12-26 12:34:00', '2', '0', NULL, NULL, NULL, NULL, NULL),
('R045', 11, '1', '2024-12-16 13:47:02', '2024-12-26 14:00:00', 1, NULL, NULL, NULL, NULL, 350000, 70000, '1', NULL, NULL, '2024-12-16 15:09:19', '1', '2024-12-16 15:09:55', '', '2024-12-24 14:46:00', '2', '0', NULL, NULL, NULL, NULL, NULL),
('R046', 11, '2', '2024-12-16 13:49:04', '2024-12-23 14:00:00', 1, NULL, NULL, NULL, NULL, 1575000, 315000, '1', NULL, NULL, '2024-12-15 17:49:04', '1', '2024-12-16 15:08:38', '', '2024-12-24 14:46:00', '2', '0', NULL, NULL, NULL, NULL, NULL),
('R047', 11, '1', '2024-12-16 14:47:37', '2024-12-26 14:00:00', 1, NULL, NULL, NULL, NULL, 350000, 70000, '1', NULL, NULL, '2024-12-16 15:09:13', '1', '2024-12-16 15:09:46', '', '2024-12-24 14:46:00', '2', '0', NULL, NULL, NULL, NULL, NULL),
('R048', 11, '1', '2024-12-16 22:10:52', '2024-12-25 14:00:00', 1, NULL, NULL, NULL, NULL, 350000, 70000, '1', NULL, NULL, '2024-12-16 15:26:34', '1', '2024-12-16 15:27:28', '', '2024-12-24 14:46:00', '2', '0', NULL, NULL, NULL, NULL, NULL),
('R049', 11, '2', '2024-12-16 22:17:42', '2024-12-23 14:00:00', 1, NULL, NULL, NULL, NULL, 1575000, 315000, '1', NULL, NULL, '2024-12-16 02:17:42', '1', '2024-12-16 15:18:44', '', '2024-12-24 14:46:00', '2', '0', NULL, NULL, NULL, NULL, NULL),
('R050', 11, '2', '2024-12-16 22:19:05', '2024-12-23 14:00:00', 1, NULL, NULL, NULL, NULL, 1575000, 315000, '1', NULL, NULL, NULL, '1', '2024-12-16 15:27:18', '', '2024-12-24 14:46:00', '2', '0', NULL, NULL, NULL, NULL, NULL),
('R051', 11, '2', '2024-12-16 22:21:56', '2024-12-24 14:00:00', 1, NULL, NULL, NULL, NULL, 1575000, 315000, '1', NULL, NULL, NULL, '1', '2024-12-16 15:27:10', '', '2024-12-24 14:46:00', '2', '0', NULL, NULL, NULL, NULL, NULL),
('R052', 11, '2', '2024-12-16 22:23:48', '2024-12-27 14:00:00', 1, NULL, NULL, NULL, NULL, 1750000, 350000, '1', NULL, NULL, '2024-12-16 15:26:24', '1', '2024-12-16 15:27:02', '', '2024-12-26 12:34:00', '2', '0', NULL, NULL, NULL, NULL, NULL),
('R053', 11, '1', '2024-12-16 22:54:54', '2024-12-19 14:00:00', 1, NULL, NULL, NULL, NULL, 350000, 70000, '1', NULL, NULL, '2024-12-16 15:55:08', '1', '2024-12-16 16:05:38', '', '2024-12-17 07:18:00', '2', '0', NULL, NULL, NULL, NULL, NULL),
('R054', 11, '1', '2024-12-16 22:55:38', '2024-12-19 14:00:00', 1, NULL, NULL, NULL, NULL, 350000, 70000, '1', NULL, NULL, '2024-12-16 15:55:44', '1', '2024-12-16 16:05:30', '', '2024-12-17 07:18:00', '2', '0', NULL, NULL, NULL, NULL, NULL),
('R055', 11, '1', '2024-12-16 23:00:54', '2024-12-19 14:00:00', 1, NULL, NULL, NULL, NULL, 350000, 70000, '1', NULL, NULL, '2024-12-16 16:01:00', '1', '2024-12-16 16:05:22', '', '2024-12-17 07:18:00', '2', '0', NULL, NULL, NULL, NULL, NULL),
('R056', 11, '1', '2024-12-16 23:04:55', '2024-12-19 14:00:00', 1, NULL, NULL, NULL, NULL, 350000, 70000, '1', NULL, NULL, '2024-12-16 16:05:03', '1', '2024-12-16 16:05:12', '', '2024-12-17 07:18:00', '2', '0', NULL, NULL, NULL, NULL, NULL),
('R057', 11, '1', '2024-12-16 23:06:29', '2024-12-19 14:00:00', 1, NULL, NULL, NULL, NULL, 350000, 70000, '1', NULL, NULL, '2024-12-16 16:06:42', '1', '2024-12-16 16:06:54', '', '2024-12-17 07:18:00', '2', '0', NULL, NULL, NULL, NULL, NULL),
('R058', 11, '1', '2024-12-16 23:07:55', '2024-12-19 14:00:00', 1, NULL, NULL, NULL, NULL, 350000, 70000, '1', NULL, NULL, '2024-12-16 16:09:48', '1', '2024-12-16 16:45:22', '', '2024-12-17 07:18:00', '2', '0', NULL, NULL, NULL, NULL, NULL),
('R059', 11, '1', '2024-12-16 23:44:55', '2024-12-19 14:00:00', 1, NULL, NULL, NULL, NULL, 700000, 140000, '1', NULL, NULL, '2024-12-16 16:45:04', '1', '2024-12-16 16:45:15', '', '2024-12-17 07:18:00', '2', '0', NULL, NULL, NULL, NULL, NULL),
('R060', 11, '1', '2024-12-17 14:54:21', '2024-12-25 14:00:00', 1, NULL, NULL, NULL, NULL, 400000, 80000, '0', NULL, NULL, '2024-12-17 14:50:08', NULL, NULL, NULL, '2024-12-24 14:46:00', '2', '0', NULL, NULL, NULL, NULL, NULL),
('R061', 11, '1', '2024-12-17 21:54:25', '2024-12-20 14:00:00', 1, NULL, NULL, NULL, 30000, 400000, 80000, '0', NULL, NULL, '2024-12-17 14:55:09', NULL, NULL, NULL, '2024-12-18 07:01:00', '2', '0', NULL, NULL, NULL, NULL, NULL),
('R062', 11, '1', '2024-12-17 22:15:16', '2024-12-20 14:00:00', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-12-18 07:01:00', '2', '0', NULL, NULL, NULL, NULL, NULL),
('R063', 11, '2', '2024-12-17 22:33:39', '2024-12-23 14:00:00', 1, NULL, NULL, NULL, NULL, 1080000, 216000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-12-24 14:46:00', '2', '0', NULL, NULL, NULL, NULL, NULL),
('R064', 11, '2', '2024-12-17 22:35:18', '2024-12-24 14:00:00', 1, NULL, NULL, NULL, NULL, 1080000, 216000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-12-24 14:46:00', '2', '0', NULL, NULL, NULL, NULL, NULL),
('R065', 11, '1', '2024-12-18 11:37:39', '2024-12-21 14:00:00', 1, NULL, NULL, NULL, 30000, 400000, 80000, '0', NULL, NULL, '2024-12-18 04:41:00', NULL, NULL, NULL, '2024-12-24 14:46:00', '2', '0', NULL, NULL, NULL, NULL, NULL),
('R066', 11, '1', '2024-12-18 12:02:42', '2024-12-21 14:00:00', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-12-24 14:46:00', '2', '0', NULL, NULL, NULL, NULL, NULL),
('R067', 11, '2', '2024-12-18 12:03:35', '2024-12-27 14:00:00', 1, NULL, NULL, NULL, NULL, 1080000, 216000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-12-26 12:34:00', '2', '0', NULL, NULL, NULL, NULL, NULL),
('R068', 11, '2', '2024-12-18 12:22:07', '2024-12-28 14:00:00', 1, NULL, NULL, NULL, 0, 1080000, 216000, 'Done', '5b9d81d0-cbff-487e-b651-1e35c5026cd7', '9b0e197f-6966-4d6f-b393-b769bd46e0c4', '2024-12-18 06:16:03', '0', '2024-12-18 06:41:41', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('R069', 11, '1', '2024-12-18 12:50:00', '2024-12-15 14:00:00', 1, 'mantap', 5, NULL, 0, 400000, 80000, 'Done', 'fb5daa4e-3cb6-471a-a1fc-28697a4fb52f', '0a79adec-4349-47d5-838d-27e94af58e41', '2024-12-18 06:15:04', '0', '2024-12-18 06:39:22', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('R070', 11, '1', '2024-12-18 13:43:38', '2024-12-16 14:00:00', 1, 'asgdsfg', 5, 20000, 25000, 400000, 80000, 'Done', '589a40c7-55a2-41d0-894e-94e2bedfb922', '3a43067a-dc68-478d-851f-3d05bd94d869', '2024-12-18 06:43:49', '0', '2024-12-18 06:45:46', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('R071', 11, '2', '2024-12-18 13:55:55', '2024-12-29 14:00:00', 1, NULL, NULL, NULL, 40000, 1080000, 216000, 'Done', 'aa46f1f4-c2d7-43d7-a4c4-6074507b882d', '93b8a914-faca-4799-983f-d083856791cb', '2024-12-18 06:56:35', '0', '2024-12-18 06:56:57', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('R072', 11, '1', '2024-12-18 15:12:21', '2024-12-27 14:00:00', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-12-26 12:34:00', '2', '0', NULL, NULL, NULL, NULL, NULL),
('R073', 11, '1', '2024-12-18 15:56:17', '2024-12-27 14:00:00', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-12-26 12:34:00', '2', '0', NULL, NULL, NULL, NULL, NULL),
('R074', 11, '1', '2024-12-22 22:23:45', '2024-12-27 14:00:00', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-12-26 12:34:00', '2', '0', NULL, NULL, NULL, NULL, NULL),
('R075', 11, '1', '2024-12-22 22:41:36', '2024-12-26 14:00:00', 1, NULL, NULL, NULL, 25000, 350000, 70000, '0', NULL, NULL, '2024-12-22 16:28:49', NULL, NULL, NULL, '2024-12-24 14:46:00', '2', '0', NULL, NULL, NULL, NULL, NULL),
('R076', 11, '1', '2024-12-22 23:26:49', '2024-12-26 14:00:00', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-12-24 14:46:00', '2', '0', NULL, NULL, NULL, NULL, NULL),
('R077', 11, '2', '2024-12-22 23:56:17', '2024-12-30 14:00:00', 1, NULL, NULL, NULL, NULL, 1575000, 315000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-12-28 08:34:00', '2', '0', NULL, NULL, NULL, NULL, NULL),
('R078', 11, '1', '2024-12-23 22:21:08', '2024-12-27 14:00:00', 1, NULL, NULL, NULL, 52500, 350000, 70000, '0', NULL, NULL, '2024-12-24 15:14:44', NULL, NULL, NULL, '2024-12-26 12:34:00', '2', '0', NULL, NULL, NULL, NULL, NULL),
('R079', 11, '2', '2024-12-24 22:19:14', '2024-12-31 14:00:00', 1, NULL, NULL, NULL, 162000, 1080000, 216000, 'Deposit Successful', 'f72b4970-4adb-4918-aaa1-1fdcf7b82440', '7ab10c29-7947-4ee4-9166-c6ec786a00a1', '2024-12-24 15:34:02', '0', '2024-12-24 15:35:46', '', '2025-01-04 16:00:00', '3', '0', NULL, NULL, NULL, NULL, NULL),
('R080', 11, '1', '2024-12-24 22:41:00', '2024-12-30 14:00:00', 1, NULL, NULL, NULL, 60000, 400000, 80000, 'Done', '86794626-20d2-4309-be14-175542a432e0', '48744e13-7b50-4734-a264-09a9fa539473', '2024-12-24 15:51:31', '0', '2024-12-24 15:52:49', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('R081', 11, '1', '2024-12-26 20:50:56', '2024-12-31 14:00:00', 1, NULL, NULL, NULL, 0, 350000, 70000, 'Deposit Successful', '809d78aa-f7b0-421a-8b78-1149047cae12', 'a466426a-77c0-4979-9331-d3243045c1dc', '2024-12-26 14:36:03', '0', '2024-12-26 15:04:13', '', '2024-12-26 16:00:00', '1', '1', '2024-12-26 19:20:53', 'ari - bank bjb - 123123123', '1735240850_25b585b1aae8c7600b9f.webp', '1', '2024-12-27 07:53:36'),
('R082', 11, '1', '2024-12-26 21:47:15', '2024-12-31 14:00:00', 1, NULL, NULL, NULL, 52500, 350000, 70000, '1', NULL, NULL, '2024-12-26 14:49:37', '1', '2024-12-26 15:05:30', '', '2025-01-04 16:00:00', '2', '0', NULL, NULL, NULL, NULL, NULL),
('R083', 11, '1', '2024-12-26 22:13:56', '2024-12-31 14:00:00', 1, NULL, NULL, NULL, 0, 350000, 70000, 'Done', 'a65ee144-d779-4f6f-9ed1-2a6bc64c7783', '0139e4a7-43af-4fbb-8f42-c1d839efcc06', '2024-12-26 15:14:01', '0', '2024-12-26 15:14:19', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('R084', 11, '1', '2024-12-26 22:35:56', '2024-12-31 14:00:00', 1, NULL, NULL, NULL, 0, 350000, 70000, 'Done', '9c0446f3-7279-4f4e-966f-75fa06d817b2', '5ca234da-539d-40f6-80dd-ba69ec97649c', '2024-12-26 15:36:00', '0', '2024-12-26 15:36:12', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('R085', 11, '1', '2024-12-27 14:27:07', '2024-12-20 14:00:00', 1, 'mantap', 5, 17500, 0, 350000, 70000, 'Done', '2f9e2832-e09e-4bbf-8363-299160fd2d4e', 'ae2e1098-a8b6-4271-847c-32e55290e675', '2024-12-27 07:27:13', '0', '2024-12-27 07:27:28', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('R086', 11, '1', '2024-12-27 14:30:39', '2024-12-25 14:00:00', 1, '123123', 5, 17500, 0, 350000, 70000, 'Done', '1bca1e0a-932a-43a5-a6d4-1e85bcd0181b', 'cb1cecba-600f-414f-8fd9-557f42ab48fd', '2024-12-27 07:31:10', '0', '2024-12-27 07:31:21', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('R087', 11, '1', '2024-12-27 22:12:26', '2024-12-31 14:00:00', 1, NULL, NULL, 52500, 52500, 350000, 70000, '1', NULL, NULL, '2024-12-27 15:16:05', '1', '2024-12-27 15:16:40', '', '2025-01-04 16:00:00', '2', '0', NULL, NULL, NULL, NULL, NULL),
('R088', 11, '2', '2024-12-28 15:15:38', '2024-12-26 14:00:00', 1, NULL, NULL, NULL, 236250, 1575000, 315000, 'Done', '0ae9d5a9-7bd9-43df-9851-568c83e986ce', 'd627a993-7c1b-47bf-b485-1f8520c52255', '2024-12-28 08:17:53', '0', '2024-12-28 08:34:38', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('R089', 11, '1', '2024-12-28 15:21:05', '2024-12-27 14:00:00', 1, NULL, NULL, NULL, 41750, 350000, 70000, 'Done', '5b7d8665-ac9f-4315-ab9f-7e4977b662ff', '8d46e432-1dd2-41ab-b7c2-17d8a6df80df', '2024-12-28 08:21:14', '0', '2024-12-28 08:34:46', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('R090', 11, '2', '2024-12-28 15:48:12', '2025-01-03 14:00:00', 30, NULL, NULL, NULL, 0, 1575000, 315000, '0', NULL, NULL, '2024-12-28 08:50:15', NULL, NULL, NULL, '2025-01-04 16:00:00', '2', '0', NULL, NULL, NULL, NULL, NULL),
('R091', 11, '1', '2024-12-28 15:50:40', '2025-01-04 14:00:00', 1, NULL, NULL, NULL, 25000, 700000, 140000, '0', NULL, NULL, '2024-12-28 08:51:05', NULL, NULL, NULL, '2025-01-04 16:00:00', '2', '0', NULL, NULL, NULL, NULL, NULL),
('R092', 11, '1', '2024-12-28 15:51:27', '2025-01-04 14:00:00', 1, NULL, NULL, NULL, 0, 350000, 70000, '0', NULL, NULL, '2024-12-28 08:51:32', NULL, NULL, NULL, '2025-01-04 16:00:00', '2', '0', NULL, NULL, NULL, NULL, NULL),
('R093', NULL, '1', '2024-12-28 15:55:41', '2024-12-29 14:00:00', 1, NULL, NULL, NULL, NULL, 350000, NULL, 'Done', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('R094', 11, '1', '2024-12-28 16:16:26', '2025-01-10 14:00:00', 2, NULL, NULL, NULL, 52500, 350000, 70000, '0', NULL, NULL, '2024-12-28 09:16:32', NULL, NULL, NULL, '2025-01-11 17:23:00', '2', '0', NULL, NULL, NULL, NULL, NULL),
('R095', 11, '1', '2025-01-18 01:24:20', '2025-01-22 14:00:00', 1, NULL, NULL, NULL, 0, 350000, 70000, 'Done', '0455aded-d48c-4198-9296-1aebd9d5de16', '83210831-987b-4d8d-aa52-ef8144fbe680', '2025-01-17 18:24:27', '0', '2025-01-17 18:24:46', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('R096', NULL, '1', '2025-01-19 01:03:25', '2025-01-19 14:00:00', 1, NULL, NULL, NULL, NULL, 350000, NULL, 'Done', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('R097', 11, '1', '2025-01-22 01:24:00', '2025-01-25 14:00:00', 1, NULL, NULL, NULL, 0, 350000, 70000, 'Deposit Successful', '326de1c2-1809-4af6-8156-ddb757d03edd', NULL, '2025-01-21 18:24:07', '0', '2025-01-21 18:27:16', '', '2025-01-21 18:28:00', '1', '1', NULL, 'dyka - bca - 1234567890', NULL, NULL, NULL),
('R098', 11, '1', '2025-01-22 01:32:43', '2025-01-25 14:00:00', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-01-23 15:22:00', '2', '0', NULL, NULL, NULL, NULL, NULL),
('R099', 11, '1', '2025-01-23 22:30:56', '2025-01-22 14:00:00', 1, 'Good ', 5, 20000, 60000, 400000, 80000, 'Done', '99b928ca-a4c0-447e-9b50-73145ae4ef24', 'd11d3ed8-6f66-4293-b639-bf8198a740ad', '2025-01-23 15:43:46', '0', '2025-01-23 15:46:20', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('R100', 11, '1', '2025-01-23 22:52:34', '2025-01-26 14:00:00', 1, NULL, NULL, NULL, 0, 400000, 80000, 'Deposit Successful', '87426077-298d-441b-b3a5-2a50ac1e2bd6', '6512810b-c46c-4a38-b57a-006438dc9e54', '2025-01-23 15:52:50', '0', '2025-01-23 15:53:07', '', '2025-01-23 15:54:00', '1', '1', '2025-01-23 16:00:33', 'Dyka - BCA - 1233214567', '1737648030_a88bc32aaf556143fdfe.png', '1', '2025-01-23 16:02:19'),
('R101', 11, '1', '2025-01-26 03:40:15', '2025-01-29 14:00:00', 2, NULL, NULL, NULL, 0, 380000, 76000, 'Deposit Successful', '827bd126-0fb0-4608-a254-b999f791a295', '5a26613e-9156-4ba4-aed6-106fa31a66d6', '2025-01-25 21:10:33', '0', '2025-01-25 21:39:57', 'Pay Deposit', '2025-01-25 22:57:00', '1', '1', '2025-01-25 23:15:40', 'dyka - Bank BCA - 1231231234', '1737846938_87f94886749e70dedd1d.png', '1', '2025-01-25 23:21:26'),
('R102', 11, '1', '2025-01-27 02:10:28', '2025-01-31 14:00:00', 2, NULL, NULL, NULL, 0, 350000, 70000, 'Done', 'dea5da2a-8531-4d1b-83c2-6fb3c6230a63', 'b8820eb1-303b-435c-a1b4-42e4cea230c7', '2025-01-26 19:10:33', '0', '2025-01-26 19:10:44', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('R103', 11, '2', '2025-01-27 02:44:02', '2025-01-30 14:00:00', 20, NULL, NULL, NULL, 0, 1575000, 315000, 'Deposit Successful', '1b6f1bca-e280-4fe8-9d44-f56303b87e16', '49dd82b4-4ebc-4140-8923-d1d98a20b01d', '2025-01-26 19:59:10', '0', '2025-01-26 21:06:38', 'Accepted', '2025-01-26 21:48:00', '1', '1', '2025-01-26 22:02:18', 'dyka - Bank BCA - 1231231234', '1737928935_3cdcfb47a95da6299cd6.png', '1', '2025-01-26 22:03:22'),
('R104', 11, '1', '2025-01-27 07:54:35', '2025-01-25 14:00:00', 2, 'Good', 5, 17500, 52500, 350000, 70000, 'Done', '66ad5a5d-17c4-47f3-8a96-b09543819f47', 'f16a42ae-93a5-4853-9346-4f6a43d8d49d', '2025-01-27 01:38:54', '0', '2025-01-27 01:59:46', 'Accepted', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('R105', 11, '1', '2025-01-27 13:12:43', '2025-01-31 14:00:00', 2, NULL, NULL, NULL, 0, 700000, 140000, 'Done', 'c470d634-e21d-48bb-959f-363692eed95e', '911cc765-ccc9-49d5-b0af-c1f69da4e75a', '2025-01-27 06:13:40', '0', '2025-01-27 06:14:41', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('R106', 11, '1', '2025-01-27 14:12:27', '2025-01-31 14:00:00', 1, NULL, NULL, NULL, 0, 350000, 70000, 'Deposit Successful', '298e50c6-639b-4f84-b92f-53a5fa2aa684', '1c7907d6-0cf6-492c-8bf7-5e9f29dcadee', '2025-01-29 00:54:04', '0', '2025-01-29 00:54:26', '', '2025-01-29 00:55:00', '1', '1', '2025-01-29 00:59:44', 'dyka - bank bca - 1231231230', '1738112379_f911a861afdd2bcf9a36.png', '1', '2025-01-29 01:06:45'),
('R107', 11, '1', '2025-01-29 03:29:37', '2025-02-01 14:00:00', 2, NULL, NULL, NULL, 0, 450000, 90000, 'Done', '9281fc5c-4b92-4de9-ac47-93e93059f46e', 'c84dd404-0913-4950-856a-e2855db763a4', '2025-01-28 20:33:37', '0', '2025-01-28 20:43:26', 'Accepted, pay deposit', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('R108', 11, '2', '2025-01-29 06:35:54', '2025-02-02 14:00:00', 20, NULL, NULL, NULL, NULL, 1575000, 315000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-02-02 03:58:00', '2', '0', NULL, NULL, NULL, NULL, NULL),
('R109', 11, '1', '2025-02-10 23:21:55', '2025-02-13 14:00:00', 1, NULL, NULL, NULL, 0, 350000, 70000, '0', NULL, NULL, '2025-02-10 16:41:19', NULL, NULL, NULL, '2025-02-15 14:04:00', '2', '0', NULL, NULL, NULL, NULL, NULL),
('R110', 11, '1', '2025-02-15 20:22:24', '2025-02-18 14:00:00', 1, NULL, NULL, NULL, 54750, 365000, 73000, '0', NULL, NULL, '2025-02-15 14:04:07', NULL, NULL, NULL, '2025-02-24 17:16:00', '2', '0', NULL, NULL, NULL, NULL, NULL),
('R111', 11, '1', '2025-02-25 00:26:33', '2025-02-28 14:00:00', 1, NULL, NULL, NULL, 0, 350000, 70000, 'Deposit Successful', '6b98070b-543a-4d73-9de4-95824ba25046', 'b0b4ff52-3804-4ee7-bbba-d7bc2a76c669', '2025-02-24 18:55:06', '0', '2025-02-24 18:55:34', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('R112', 11, '1', '2025-02-26 17:17:43', '2025-03-01 14:00:00', 1, NULL, NULL, NULL, 0, 350000, 70000, 'Deposit Successful', '6a4577b9-09b2-4d9a-932c-c4c24cdedaca', 'e1f50937-e121-43f6-b9b0-92f836a90fdf', '2025-02-26 10:20:23', '0', '2025-02-26 14:24:52', '', '2025-02-26 14:26:00', '1', '1', '2025-02-26 15:40:47', 'dyka - Bank BCA - 123456789', '1740584444_7f9854427829a93d6450.jpg', NULL, NULL),
('R113', 11, '1', '2025-02-26 21:44:38', '2025-02-23 14:00:00', 1, 'Mantap', 5, 17500, 0, 350000, 70000, 'Done', '85d93be1-54b6-4f64-a1e5-795107e6110c', '628b2463-afd1-4c5e-b476-c8065ae83a1f', '2025-02-26 15:30:14', '0', '2025-02-26 15:33:32', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('R114', 11, '1', '2025-02-26 22:37:42', '2025-03-01 14:00:00', 1, NULL, NULL, NULL, 0, 350000, 70000, 'Deposit Successful', '3f7b2d41-ac8a-43e7-b9f8-e4bc23d971de', '181c8e9e-6730-4402-837f-f1d6a92b7ece', '2025-02-26 15:37:49', '0', '2025-02-26 15:37:57', '', '2025-02-26 15:38:00', '1', '1', NULL, NULL, NULL, NULL, NULL),
('R115', 11, '1', '2025-02-27 01:12:10', '2025-03-02 14:00:00', 1, NULL, NULL, NULL, 42500, 450000, 90000, '0', NULL, NULL, '2025-02-26 18:24:13', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('R116', 11, '1', '2025-02-27 02:22:48', '2025-03-02 14:00:00', 1, NULL, NULL, NULL, 0, 365000, 73000, 'Deposit Successful', '18a84992-ef68-4fc2-909e-9c1bf536cabf', NULL, '2025-02-26 19:33:44', '0', '2025-02-26 19:46:09', '', '2025-02-26 20:04:00', '1', '1', '2025-02-26 20:12:50', 'Dyka - BCA - 1234567890', '1740600688_b1e4df790ff71b760b38.png', '1', '2025-02-26 20:14:46'),
('R117', 11, '2', '2025-02-27 03:34:36', '2025-03-03 14:00:00', 25, NULL, NULL, NULL, 0, 1575000, 315000, 'Deposit Successful', '9f5349c0-3b71-49be-b3e2-e68e3e803907', '7bfa40cd-a8c3-47c8-93b3-f8e226a98d51', '2025-02-26 20:39:13', '0', '2025-02-26 20:50:07', '', '2025-02-26 21:04:00', '1', '1', '2025-02-26 21:09:35', 'Dyka - BCA - 1234567890', '1740604093_7ec00577c2ccf73ea39b.png', '1', '2025-02-26 21:12:04'),
('R118', 11, '1', '2025-02-27 04:29:10', '2025-02-24 14:00:00', 1, 'Good', 5, 17500, 40000, 350000, 70000, 'Done', 'd0fc4b53-183b-40f2-9234-470e907526cf', 'df9ae99c-c125-4c02-b3e5-f91acde7be6f', '2025-02-26 21:32:55', '0', '2025-02-26 21:53:29', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('R119', 11, '1', '2025-02-27 05:16:21', '2025-03-03 14:00:00', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('R120', 11, '1', '2025-02-27 14:45:47', '2025-03-02 14:00:00', 1, NULL, NULL, NULL, 0, 350000, 70000, 'Deposit Successful', 'cd26cc1b-b19c-4826-945e-1ce12af78b06', '932db86a-504e-4cab-ae91-1a22c7f3536b', '2025-02-27 07:45:55', '0', '2025-02-27 07:48:13', '', '2025-02-27 11:20:00', '1', '1', '2025-02-27 11:22:55', 'Dyka - BCA -1234567890\r\n', '1740655372_88536de96d48f59665b8.png', '1', '2025-02-27 11:23:53'),
('R121', 11, '1', '2025-02-27 14:46:16', '2025-03-03 14:00:00', 1, NULL, NULL, NULL, 0, 700000, 140000, '1', NULL, NULL, '2025-02-27 07:46:20', '1', '2025-02-27 07:49:57', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('R122', 11, '1', '2025-02-27 15:23:51', '2025-03-03 14:00:00', 2, NULL, NULL, NULL, 30000, 380000, 76000, 'Full Pay Successful', 'd9dca05c-ac68-45bd-8b8d-aca4d96a3ab2', '485b614b-70bd-43f0-a884-ee5c65e7ff9d', '2025-02-27 12:08:41', '0', '2025-02-27 12:09:07', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('R123', 11, '2', '2025-02-27 17:25:55', '2025-03-04 14:00:00', 25, NULL, NULL, NULL, NULL, 1575000, 315000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

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

--
-- Dumping data for table `reservation_homestay_additional_amenities_detail`
--

INSERT INTO `reservation_homestay_additional_amenities_detail` (`homestay_id`, `additional_amenities_id`, `reservation_id`, `day_order`, `person_order`, `room_order`, `total_order`, `total_price`) VALUES
('H12', '01', 'R024', 0, 0, 0, 1, 100000),
('H12', '01', 'R107', 0, 0, 1, 1, 100000),
('H12', '01', 'R115', 0, 0, 1, 1, 100000),
('H12', '02', 'R101', 1, 2, 0, 2, 30000),
('H12', '02', 'R110', 1, 1, 0, 1, 15000),
('H12', '02', 'R116', 1, 1, 0, 1, 15000),
('H12', '02', 'R122', 1, 2, 0, 2, 30000),
('H12', '05', 'R036', 0, 0, 0, 1, 0),
('H12', '05', 'R037', 0, 0, 0, 1, 0),
('H12', '05', 'R039', 0, 0, 0, 1, 0),
('H12', '05', 'R041', 0, 0, 0, 1, 0),
('H12', '05', 'R046', 0, 0, 0, 1, 0),
('H12', '05', 'R049', 0, 0, 0, 1, 0),
('H12', '05', 'R050', 0, 0, 0, 1, 0),
('H12', '05', 'R051', 0, 0, 0, 1, 0),
('H12', '05', 'R052', 0, 0, 0, 1, 0),
('H12', '05', 'R077', 0, 0, 0, 1, 0),
('H12', '05', 'R088', 0, 0, 0, 1, 0),
('H12', '05', 'R090', 0, 0, 0, 1, 0),
('H12', '05', 'R103', 0, 0, 0, 1, 0),
('H12', '05', 'R108', 0, 0, 0, 1, 0),
('H12', '05', 'R117', 0, 0, 0, 1, 0),
('H12', '05', 'R123', 0, 0, 0, 1, 0),
('H12', '06', 'R088', 0, 0, 0, 1, 0),
('H12', '06', 'R090', 0, 0, 0, 1, 0),
('H12', '06', 'R103', 0, 0, 0, 1, 0),
('H12', '06', 'R108', 0, 0, 0, 1, 0),
('H12', '06', 'R117', 0, 0, 0, 1, 0),
('H12', '06', 'R123', 0, 0, 0, 1, 0),
('H13', '02', 'R029', 1, 2, 0, 2, 40000);

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
('H12', '1', '1', '2024-10-17', 'R016'),
('H12', '1', '1', '2024-10-18', 'R016'),
('H12', '1', '2', '2024-10-17', 'R016'),
('H12', '1', '2', '2024-10-18', 'R016'),
('H12', '1', '3', '2024-10-16', 'R017'),
('H12', '1', '3', '2024-10-17', 'R017'),
('H12', '1', '1', '2024-10-19', 'R022'),
('H12', '1', '2', '2024-10-19', 'R023'),
('H12', '1', '3', '2024-10-19', 'R024'),
('H12', '1', '1', '2024-10-20', 'R027'),
('H12', '1', '1', '2024-10-25', 'R028'),
('H13', '1', '1', '2024-10-29', 'R029'),
('H13', '1', '1', '2024-10-30', 'R029'),
('H13', '1', '1', '2024-12-28', 'R068'),
('H13', '1', '2', '2024-12-28', 'R068'),
('H13', '1', '3', '2024-12-28', 'R068'),
('H13', '1', '2', '2024-12-25', 'R069'),
('H13', '1', '3', '2024-12-21', 'R070'),
('H13', '1', '1', '2024-12-29', 'R071'),
('H13', '1', '2', '2024-12-29', 'R071'),
('H13', '1', '3', '2024-12-29', 'R071'),
('H13', '1', '1', '2024-12-30', 'R080'),
('H12', '1', '2', '2024-12-31', 'R083'),
('H12', '1', '3', '2024-12-31', 'R084'),
('H12', '1', '1', '2024-12-31', 'R085'),
('H12', '1', '4', '2024-12-31', 'R086'),
('H12', '1', '1', '2025-01-01', 'R088'),
('H12', '1', '2', '2025-01-01', 'R088'),
('H12', '1', '3', '2025-01-01', 'R088'),
('H12', '1', '4', '2025-01-01', 'R088'),
('H12', '1', '5', '2025-01-01', 'R088'),
('H12', '1', '1', '2025-01-02', 'R089'),
('H12', '1', '1', '2024-12-29', 'R093'),
('H12', '1', '1', '2025-01-22', 'R095'),
('H12', '1', '1', '2025-01-19', 'R096'),
('H13', '1', '1', '2025-01-26', 'R099'),
('H12', '1', '1', '2025-01-31', 'R102'),
('H12', '1', '1', '2025-01-30', 'R104'),
('H12', '1', '2', '2025-01-31', 'R105'),
('H12', '1', '2', '2025-02-01', 'R105'),
('H12', '1', '1', '2025-02-01', 'R107'),
('H12', '1', '1', '2025-02-28', 'R111'),
('H12', '1', '1', '2025-03-02', 'R113'),
('H12', '1', '2', '2025-03-02', 'R115'),
('H12', '1', '3', '2025-03-02', 'R118'),
('H12', '1', '1', '2025-03-03', 'R119'),
('H12', '1', '2', '2025-03-03', 'R122'),
('H12', '1', '1', '2025-03-04', 'R123'),
('H12', '1', '2', '2025-03-04', 'R123'),
('H12', '1', '3', '2025-03-04', 'R123'),
('H12', '1', '4', '2025-03-04', 'R123'),
('H12', '1', '5', '2025-03-04', 'R123');

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
('H12', '1', '3', 'R018', '2024-10-18'),
('H12', '1', '3', 'R018', '2024-10-19'),
('H12', '1', '1', 'R019', '2024-10-14'),
('H12', '1', '1', 'R019', '2024-10-15'),
('H12', '1', '2', 'R019', '2024-10-14'),
('H12', '1', '2', 'R019', '2024-10-15'),
('H12', '1', '1', 'R020', '2024-10-14'),
('H12', '1', '1', 'R020', '2024-10-15'),
('H12', '1', '2', 'R020', '2024-10-14'),
('H12', '1', '2', 'R020', '2024-10-15'),
('H12', '1', '3', 'R021', '2024-10-18'),
('H12', '1', '1', 'R025', '2024-10-20'),
('H12', '1', '1', 'R026', '2024-10-20'),
('H12', '1', '1', 'R030', '2024-10-31'),
('H12', '1', '1', 'R031', '2024-11-20'),
('H12', '1', '1', 'R031', '2024-11-21'),
('H12', '1', '2', 'R031', '2024-11-20'),
('H12', '1', '2', 'R031', '2024-11-21'),
('H12', '1', '1', 'R032', '2024-11-27'),
('H12', '1', '1', 'R032', '2024-11-28'),
('H12', '1', '2', 'R032', '2024-11-27'),
('H12', '1', '2', 'R032', '2024-11-28'),
('H12', '1', '1', 'R033', '2024-12-03'),
('H12', '1', '1', 'R033', '2024-12-04'),
('H12', '1', '2', 'R033', '2024-12-03'),
('H12', '1', '2', 'R033', '2024-12-04'),
('H12', '1', '1', 'R034', '2024-12-05'),
('H12', '1', '1', 'R034', '2024-12-06'),
('H12', '1', '2', 'R034', '2024-12-05'),
('H12', '1', '2', 'R034', '2024-12-06'),
('H12', '1', '3', 'R034', '2024-12-05'),
('H12', '1', '3', 'R034', '2024-12-06'),
('H12', '1', '4', 'R034', '2024-12-05'),
('H12', '1', '4', 'R034', '2024-12-06'),
('H12', '1', '5', 'R034', '2024-12-05'),
('H12', '1', '5', 'R034', '2024-12-06'),
('H12', '1', '1', 'R035', '2024-12-17'),
('H12', '1', '1', 'R035', '2024-12-18'),
('H12', '1', '1', 'R035', '2024-12-19'),
('H12', '1', '2', 'R035', '2024-12-17'),
('H12', '1', '2', 'R035', '2024-12-18'),
('H12', '1', '2', 'R035', '2024-12-19'),
('H12', '1', '3', 'R035', '2024-12-17'),
('H12', '1', '3', 'R035', '2024-12-18'),
('H12', '1', '3', 'R035', '2024-12-19'),
('H12', '1', '4', 'R035', '2024-12-17'),
('H12', '1', '4', 'R035', '2024-12-18'),
('H12', '1', '4', 'R035', '2024-12-19'),
('H12', '1', '5', 'R035', '2024-12-17'),
('H12', '1', '5', 'R035', '2024-12-18'),
('H12', '1', '5', 'R035', '2024-12-19'),
('H12', '1', '1', 'R036', '2024-12-18'),
('H12', '1', '1', 'R036', '2024-12-19'),
('H12', '1', '1', 'R036', '2024-12-20'),
('H12', '1', '2', 'R036', '2024-12-18'),
('H12', '1', '2', 'R036', '2024-12-19'),
('H12', '1', '2', 'R036', '2024-12-20'),
('H12', '1', '3', 'R036', '2024-12-18'),
('H12', '1', '3', 'R036', '2024-12-19'),
('H12', '1', '3', 'R036', '2024-12-20'),
('H12', '1', '4', 'R036', '2024-12-18'),
('H12', '1', '4', 'R036', '2024-12-19'),
('H12', '1', '4', 'R036', '2024-12-20'),
('H12', '1', '5', 'R036', '2024-12-18'),
('H12', '1', '5', 'R036', '2024-12-19'),
('H12', '1', '5', 'R036', '2024-12-20'),
('H12', '1', '1', 'R037', '2024-12-21'),
('H12', '1', '1', 'R037', '2024-12-22'),
('H12', '1', '2', 'R037', '2024-12-21'),
('H12', '1', '2', 'R037', '2024-12-22'),
('H12', '1', '3', 'R037', '2024-12-21'),
('H12', '1', '3', 'R037', '2024-12-22'),
('H12', '1', '4', 'R037', '2024-12-21'),
('H12', '1', '4', 'R037', '2024-12-22'),
('H12', '1', '5', 'R037', '2024-12-21'),
('H12', '1', '5', 'R037', '2024-12-22'),
('H12', '1', '1', 'R038', '2024-12-26'),
('H12', '1', '1', 'R039', '2024-12-27'),
('H12', '1', '1', 'R039', '2024-12-28'),
('H12', '1', '2', 'R039', '2024-12-27'),
('H12', '1', '2', 'R039', '2024-12-28'),
('H12', '1', '3', 'R039', '2024-12-27'),
('H12', '1', '3', 'R039', '2024-12-28'),
('H12', '1', '4', 'R039', '2024-12-27'),
('H12', '1', '4', 'R039', '2024-12-28'),
('H12', '1', '5', 'R039', '2024-12-27'),
('H12', '1', '5', 'R039', '2024-12-28'),
('H12', '1', '1', 'R040', '2024-12-23'),
('H12', '1', '1', 'R041', '2024-12-31'),
('H12', '1', '2', 'R041', '2024-12-31'),
('H12', '1', '3', 'R041', '2024-12-31'),
('H12', '1', '4', 'R041', '2024-12-31'),
('H12', '1', '5', 'R041', '2024-12-31'),
('H12', '1', '1', 'R043', '2024-12-25'),
('H12', '1', '1', 'R044', '2024-12-27'),
('H12', '1', '2', 'R045', '2024-12-26'),
('H12', '1', '1', 'R046', '2024-12-23'),
('H12', '1', '2', 'R046', '2024-12-23'),
('H12', '1', '3', 'R046', '2024-12-23'),
('H12', '1', '4', 'R046', '2024-12-23'),
('H12', '1', '5', 'R046', '2024-12-23'),
('H12', '1', '3', 'R047', '2024-12-26'),
('H12', '1', '2', 'R048', '2024-12-25'),
('H12', '1', '1', 'R049', '2024-12-23'),
('H12', '1', '2', 'R049', '2024-12-23'),
('H12', '1', '3', 'R049', '2024-12-23'),
('H12', '1', '4', 'R049', '2024-12-23'),
('H12', '1', '5', 'R049', '2024-12-23'),
('H12', '1', '1', 'R050', '2024-12-23'),
('H12', '1', '2', 'R050', '2024-12-23'),
('H12', '1', '3', 'R050', '2024-12-23'),
('H12', '1', '4', 'R050', '2024-12-23'),
('H12', '1', '5', 'R050', '2024-12-23'),
('H12', '1', '1', 'R051', '2024-12-24'),
('H12', '1', '2', 'R051', '2024-12-24'),
('H12', '1', '3', 'R051', '2024-12-24'),
('H12', '1', '4', 'R051', '2024-12-24'),
('H12', '1', '5', 'R051', '2024-12-24'),
('H12', '1', '1', 'R052', '2024-12-27'),
('H12', '1', '2', 'R052', '2024-12-27'),
('H12', '1', '3', 'R052', '2024-12-27'),
('H12', '1', '4', 'R052', '2024-12-27'),
('H12', '1', '5', 'R052', '2024-12-27'),
('H12', '1', '1', 'R053', '2024-12-19'),
('H12', '1', '2', 'R054', '2024-12-19'),
('H12', '1', '3', 'R055', '2024-12-19'),
('H12', '1', '4', 'R056', '2024-12-19'),
('H12', '1', '1', 'R057', '2024-12-19'),
('H12', '1', '1', 'R058', '2024-12-19'),
('H12', '1', '2', 'R059', '2024-12-19'),
('H12', '1', '2', 'R059', '2024-12-20'),
('H13', '1', '1', 'R060', '2024-12-25'),
('H13', '1', '1', 'R061', '2024-12-20'),
('H13', '1', '2', 'R062', '2024-12-20'),
('H13', '1', '1', 'R063', '2024-12-23'),
('H13', '1', '2', 'R063', '2024-12-23'),
('H13', '1', '3', 'R063', '2024-12-23'),
('H13', '1', '1', 'R064', '2024-12-24'),
('H13', '1', '2', 'R064', '2024-12-24'),
('H13', '1', '3', 'R064', '2024-12-24'),
('H13', '1', '1', 'R065', '2024-12-21'),
('H13', '1', '2', 'R066', '2024-12-21'),
('H13', '1', '1', 'R067', '2024-12-27'),
('H13', '1', '2', 'R067', '2024-12-27'),
('H13', '1', '3', 'R067', '2024-12-27'),
('H12', '1', '1', 'R072', '2024-12-27'),
('H12', '1', '2', 'R073', '2024-12-27'),
('H12', '1', '3', 'R074', '2024-12-27'),
('H12', '1', '2', 'R075', '2024-12-26'),
('H12', '1', '3', 'R076', '2024-12-26'),
('H12', '1', '1', 'R077', '2024-12-30'),
('H12', '1', '2', 'R077', '2024-12-30'),
('H12', '1', '3', 'R077', '2024-12-30'),
('H12', '1', '4', 'R077', '2024-12-30'),
('H12', '1', '5', 'R077', '2024-12-30'),
('H12', '1', '4', 'R078', '2024-12-27'),
('H13', '1', '1', 'R079', '2024-12-31'),
('H13', '1', '2', 'R079', '2024-12-31'),
('H13', '1', '3', 'R079', '2024-12-31'),
('H12', '1', '1', 'R081', '2024-12-31'),
('H12', '1', '2', 'R082', '2024-12-31'),
('H12', '1', '5', 'R087', '2024-12-31'),
('H12', '1', '1', 'R090', '2025-01-03'),
('H12', '1', '2', 'R090', '2025-01-03'),
('H12', '1', '3', 'R090', '2025-01-03'),
('H12', '1', '4', 'R090', '2025-01-03'),
('H12', '1', '5', 'R090', '2025-01-03'),
('H12', '1', '1', 'R091', '2025-01-04'),
('H12', '1', '2', 'R091', '2025-01-04'),
('H12', '1', '3', 'R092', '2025-01-04'),
('H12', '1', '2', 'R094', '2025-01-10'),
('H12', '1', '1', 'R097', '2025-01-25'),
('H12', '1', '1', 'R098', '2025-01-25'),
('H13', '1', '2', 'R100', '2025-01-26'),
('H12', '1', '1', 'R101', '2025-01-29'),
('H12', '1', '1', 'R103', '2025-01-30'),
('H12', '1', '2', 'R103', '2025-01-30'),
('H12', '1', '3', 'R103', '2025-01-30'),
('H12', '1', '4', 'R103', '2025-01-30'),
('H12', '1', '5', 'R103', '2025-01-30'),
('H12', '1', '3', 'R106', '2025-01-31'),
('H12', '1', '1', 'R108', '2025-02-02'),
('H12', '1', '2', 'R108', '2025-02-02'),
('H12', '1', '3', 'R108', '2025-02-02'),
('H12', '1', '4', 'R108', '2025-02-02'),
('H12', '1', '5', 'R108', '2025-02-02'),
('H12', '1', '1', 'R109', '2025-02-13'),
('H12', '1', '1', 'R110', '2025-02-18'),
('H12', '1', '1', 'R112', '2025-03-01'),
('H12', '1', '1', 'R114', '2025-03-01'),
('H12', '1', '3', 'R116', '2025-03-02'),
('H12', '1', '1', 'R117', '2025-03-03'),
('H12', '1', '2', 'R117', '2025-03-03'),
('H12', '1', '3', 'R117', '2025-03-03'),
('H12', '1', '4', 'R117', '2025-03-03'),
('H12', '1', '5', 'R117', '2025-03-03'),
('H12', '1', '4', 'R120', '2025-03-02'),
('H12', '1', '2', 'R121', '2025-03-03'),
('H12', '1', '2', 'R121', '2025-03-04');

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
('S2', '1', 'Rumah UKM Batik Nagari Tuo Pariangan', 'Pariangan, Kec. Pariangan, Kabupaten Tanah Datar, Sumatera Barat ', 'Martini', '081266124955', '21:00:00', '06:00:00', 0xe610000001030000000100000006000000bb04dbc2681f59403dbd097af00addbfbc043bf8691f59402b655f7ed408ddbfbc04fb276b1f59409c9d259ef008ddbfba04fb086c1f5940c77b3e1d6109ddbfbc041bbd6a1f5940961124b8dc0bddbfbb04dbc2681f59403dbd097af00addbf, -0.45375648, 100.49086903, 'Rumah UKM Batik Nagari Tuo Pariangan is a small business specializing in creating traditional batik unique to Nagari Tuo Pariangan. It offers a variety of distinctive batik patterns that showcase the cultural richness of Pariangan.', '2024-10-25 04:04:07', '2025-01-10 01:19:39');

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
  `address` varchar(100) DEFAULT NULL,
  `phone` varchar(13) DEFAULT NULL,
  `avatar` varchar(100) DEFAULT 'default.jpg',
  `total_coin` int DEFAULT NULL,
  `password_hash` varchar(255) NOT NULL,
  `reset_hash` varchar(255) DEFAULT NULL,
  `reset_at` datetime DEFAULT NULL,
  `reset_expires` datetime DEFAULT NULL,
  `activate_hash` varchar(255) DEFAULT NULL,
  `activate_expires` datetime DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `status_message` varchar(255) DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '0',
  `force_pass_reset` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `username`, `first_name`, `last_name`, `address`, `phone`, `avatar`, `total_coin`, `password_hash`, `reset_hash`, `reset_at`, `reset_expires`, `activate_hash`, `status`, `status_message`, `active`, `force_pass_reset`, `created_at`, `updated_at`, `deleted_at`) VALUES
(7, 'pokdarwispariangan1@gmail.com', 'pokdarwis.pariangan', 'Fakhrudoni Putra', 'Account', 'Desa Wisata Nagari Tuo Pariangan', '082218141289', 'default.jpg', NULL, '$2y$10$KKs/QMWOtQgv6eN0wOiCQO5SDa14h2o387oiOCPyn9nGDKFs0usAu', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2023-10-28 22:51:29', '2023-10-28 22:51:29', NULL),
(11, 'shandyka2403@gmail.com', 'dykdyk', 'Dyka', 'Dyka', 'Padang', '085171597007', 'default.jpg', 0, '$2y$10$fVxJTbgT/Ja7xSc56553suT/tYJA8XzUL9zkl61yBYR/qtNQ35OoG', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2023-12-14 20:28:36', '2023-12-14 20:28:36', NULL),
(23, 'umegahomestay@gmail.com', 'umegahomestay', 'Owner Umega', 'Homestay', 'Pariangan, Kec. Pariangan, Kabupaten Tanah Datar, Sumatera Barat ', '0895329272378', 'default.jpg', NULL, '$2y$10$t/tLnMQiHV.4x9rez4BozenBzYWYsax3IZy5apnWa729tS1p944xq', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2024-09-26 11:40:48', '2024-09-26 11:40:48', NULL),
(24, 'gudesterhomestay@gmail.com', 'gudesterhomestay', 'Owner Gudester', 'Homestay', 'Pariangan, Kec. Pariangan, Kabupaten Tanah Datar, Sumatera Barat ', '0895329272378', 'default.jpg', NULL, '$2y$10$e4cqmQwqIh8drtCvobmCuOodW.zIHGRwqIn9RKfG6u6MapDSJ2dva', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2024-09-28 05:04:12', '2024-09-28 05:04:12', NULL),
(25, 'nabilahomestay@gmail.com', 'nabilahomestay', 'Owner Nabila', 'Homestay', 'Pariangan, Kec. Pariangan, Kabupaten Tanah Datar, Sumatera Barat ', '082249063128', 'default.jpg', NULL, '$2y$10$hb.4auiFDNFb8uPEePqiauI2jyTKKm47b.4WXfMdB5hxSc6iWmTgq', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2024-10-10 03:16:39', '2024-10-10 03:16:39', NULL),
(29, 'homestayowner@gmail.com', 'homestayowner', NULL, NULL, NULL, NULL, 'default.jpg', NULL, '$2y$10$pQSYrqO.4NziX/HbFzn3peJJ77P2UBUQos4Bag7W/v/kUXrIzpjDS', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2025-01-25 07:14:31', '2025-01-25 07:14:31', NULL),
(32, 'asdasd@gmail.com', 'asdasd', NULL, NULL, NULL, NULL, 'default.jpg', NULL, '$2y$10$Z1GR4njHo2Kue0T7vLgJ7.QQyJVKBqyW6OplFpLzTkoumdpkniTC6', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2025-02-27 06:15:53', '2025-02-27 06:15:53', NULL);

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
('1', 'Nagari Tuo Pariangan', 'Pariangan.geojson', '1', 'Nagari Tuo Pariangan is a traditional village situated in the Tanah Datar Regency of West Sumatra province, Indonesia. It is renowned for being one of the oldest and most well-preserved Minangkabau traditional villages, often considered the original homeland of the Minangkabau people.\r\nLocated in the Pariangan sub-district, this village is nestled at the foot of Mount Merapi, offering a picturesque setting that combines natural beauty with rich cultural heritage. The village is particularly famous for its authentic traditional architecture, traditional customs, and historical significance in Minangkabau culture.', 0, '06:00:00', '23:59:00', 'Pariangan, Kecamatan Pariangan, Kabupaten Tanah Datar, Sumatera Barat', 'pokdarwispariangan1@gmail.com', 'pokdarwis.pariangan', 'pokdarwis.pariangan', NULL, 'pokdarwis.pariangan', '1736615066_2a9ebea46881527624fa.mp4', NULL, NULL),
('10', 'Danau Ateh Alahan Panjang', 'Alahan_Panjang.geojson', '0', NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('11', 'Kumanis', 'Kumanis.geojson', '0', NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('12', 'Sisawah', 'Sisawah.geojson', '0', NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('13', 'Marapalam Batu Bulek', 'Marapalam_Batu_Bulek.geojson', '0', NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('14', 'Guranjhil', 'Kuranji_Hilir.geojson', '0', NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('15', 'Sintuak', 'Sintuak.geojson', '0', NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('16', 'Panampuang', 'Panampuang.geojson', '0', NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('17', 'Dalko', 'Dalko_Tanjung_Sani.geojson', '0', NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('18', 'Kamang Mudiak', 'Kamang_Mudiak.geojson', '0', NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('19', 'Koto Gadang', 'Koto_Gadang.geojson', '0', NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('2', 'Silabu', 'Silabu.geojson', '0', NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('20', 'Simarasok', 'Simarasok.geojson', '0', NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('21', 'Koto Kaciak', 'Koto_Kaciak.geojson', '0', NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('22', 'Pesona Pagadih', 'Pagadih.geojson', '0', NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('23', 'Nagata', 'Nagata_Talang_Anau.geojson', '0', NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('24', 'Kampung Bung Hatta Batuhampar', 'Kampung_Bung_Hatta_Batuhampar.geojson', '0', NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('25', 'Kapalo Banda Taram', 'Kapalo_Banda_Taram.geojson', '0', NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('26', 'Ganggo Mudiak', 'Ganggo_Mudiak.geojson', '0', NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('27', 'Ganggo Hilia', 'Ganggo_Hilia.geojson', '0', NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('28', 'Teluk Buo', 'Teluk_Buo_Teluk_Kabung_Tengah.geojson', '0', NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('29', 'Parit Antang \"The Heart of Kurai\"', 'Parit_Rantang.geojson', '0', NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('3', 'Salido', 'Salido.geojson', '0', NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('30', 'Parik Natuang', 'Pulai_Anak_Aia.geojson', '0', NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('31', 'Desa Wisata Sanjai', 'Manggis_Ganting.geojson', '0', NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('32', 'Pendakian Gunung Marapi Koto Baru', 'Koto_Baru_X_Koto.geojson', '0', NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('4', 'Pesona Palmurah', 'Palmurah_Pasar_Lama.geojson', '0', NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('5', 'Carocok Pantai Painan', 'Carocok_Painan.geojson\r\n', '0', NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('6', 'Nyalo', 'Nyalo_Mudiak_Aia.geojson', '0', NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('7', 'Ekowisata Nagari Amping Parak', 'Amping_Parak.geojson', '0', NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('8', 'Kampung Batu Dalam', 'Kampung_Batu_Dalam.geojson', '0', NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('9', 'Tabek Talang Babungo', 'Talang_Babungo.geojson', '0', NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `village_gallery`
--

CREATE TABLE `village_gallery` (
  `id` varchar(3) NOT NULL,
  `village_id` varchar(3) NOT NULL,
  `url` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `village_gallery`
--

INSERT INTO `village_gallery` (`id`, `village_id`, `url`) VALUES
('001', '1', '1736615063_fa112af7c7c2a00cd75c.webp'),
('002', '1', '1736615063_96524ac2c98bdeb2fb1b.jpg'),
('003', '1', '1736615065_234ff7adf9a0213d1eab.jpg'),
('004', '1', '1736615065_5b2f0e34e3d33a1fdb11.jpg');

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
('W2', '1', 'Mesjid AT TAQWA Pariangan', '01', 'Pariangan, Kec. Pariangan, Kabupaten Tanah Datar, Sumatera Barat ', 250, 0xe6100000010300000001000000080000004f5e6bf6051f594064b19c518078dcbf505e4bcc041f594030bbb3cf7779dcbf505e4b45041f5940519666eda17adcbf4f5e6be8041f59406c4e670a267cdcbf505e0b18081f59409e13f8495e7cdcbf505ecb39081f59400d9f508c2e7bdcbf515e4b9c071f594069200111cf78dcbf4f5e6bf6051f594064b19c518078dcbf, -0.44497283, 100.48475636, 'At-Taqwa Pariangan Mosque is an iconic mosque located in Nagari Pariangan, Tanah Datar Regency, West Sumatra. The mosque is located in an area known as one of the oldest villages in Minangkabau, making it a spiritual and social center for the local community. Although not as old as the Islah Mosque, the At-Taqwa Mosque still has an important value in the history of the development of Islam in Pariangan. The architecture of this mosque is a blend of modern and traditional Minangkabau designs. The pyramid-shaped roof of the mosque is combined with local ornaments, providing a balance between contemporary aesthetics and local cultural values. The structure of this building was built using strong and durable materials, and was designed to accommodate a large number of worshipers, especially during the celebration of Islamic holidays.', '2024-10-25 03:44:16', '2025-01-09 05:06:32');

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
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=733;

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
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

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
