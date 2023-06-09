-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 31-05-2023 a las 13:41:41
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `ikanaide`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `anime`
--

CREATE TABLE `anime` (
  `anime_id` int(10) UNSIGNED NOT NULL,
  `title` varchar(150) NOT NULL,
  `english_title` varchar(150) DEFAULT NULL,
  `japanese_title` varchar(150) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `type` varchar(25) NOT NULL,
  `episodes` smallint(5) UNSIGNED NOT NULL,
  `status` varchar(25) NOT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `description` varchar(3000) NOT NULL,
  `cover` varchar(200) NOT NULL DEFAULT 'storage/sys/default_cover.png',
  `header` varchar(200) DEFAULT NULL,
  `date` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `anime`
--

INSERT INTO `anime` (`anime_id`, `title`, `english_title`, `japanese_title`, `type`, `episodes`, `status`, `start_date`, `end_date`, `description`, `cover`, `header`, `date`) VALUES
(18, 'Gintama', NULL, NULL, 'tv', 49, 'announced', '2023-05-03', '2023-05-31', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', '/storage/public/anime/cover/anime_64771616e1b8a.png', '/storage/public/anime/header/anime_64771616e282e.jpg', '2023-05-31 11:40:38'),
(19, 'Monster', NULL, NULL, 'tv', 70, 'finished', '2023-05-01', '2023-05-31', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', '/storage/public/anime/cover/anime_6477180a0f4b2.jpg', NULL, '2023-05-31 11:48:58'),
(20, 'Clannad: After Story', NULL, NULL, 'tv', 22, 'finished', '2023-04-24', '2023-05-31', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', '/storage/public/anime/cover/anime_647718402569a.jpg', NULL, '2023-05-31 11:49:52'),
(21, 'Kara no Kyoukai Movie 5', NULL, NULL, 'movie', 1, 'finished', NULL, NULL, 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', '/storage/public/anime/cover/anime_64771850a35fb.jpg', NULL, '2023-05-31 11:50:08');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `animelist`
--

CREATE TABLE `animelist` (
  `user_id` int(10) UNSIGNED NOT NULL,
  `anime_id` int(10) UNSIGNED NOT NULL,
  `score` decimal(3,1) DEFAULT NULL,
  `status` enum('completed','watching','planned','stalled','dropped') NOT NULL DEFAULT 'watching',
  `progress` smallint(5) UNSIGNED NOT NULL DEFAULT 0,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `rewatches` tinyint(3) UNSIGNED NOT NULL DEFAULT 0,
  `favorite` bit(1) NOT NULL DEFAULT b'0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `animelist`
--

INSERT INTO `animelist` (`user_id`, `anime_id`, `score`, `status`, `progress`, `start_date`, `end_date`, `notes`, `rewatches`, `favorite`) VALUES
(16, 18, 7.0, 'watching', 1, NULL, NULL, '', 0, b'1'),
(16, 19, 8.0, 'completed', 70, NULL, NULL, '', 0, b'0'),
(16, 20, 10.0, 'completed', 22, NULL, NULL, '', 0, b'1'),
(16, 21, NULL, 'planned', 0, NULL, NULL, '', 0, b'0'),
(17, 20, 9.0, 'completed', 22, NULL, NULL, '', 0, b'1'),
(17, 21, 4.0, 'completed', 1, NULL, NULL, '', 0, b'0');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bookmark`
--

CREATE TABLE `bookmark` (
  `post_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `date` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `bookmark`
--

INSERT INTO `bookmark` (`post_id`, `user_id`, `date`) VALUES
(177, 17, '2023-05-31 13:40:18');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `character`
--

CREATE TABLE `character` (
  `character_id` int(10) UNSIGNED NOT NULL,
  `family_name` varchar(50) DEFAULT NULL,
  `given_name` varchar(50) DEFAULT NULL,
  `alias` varchar(50) DEFAULT NULL,
  `japanese_name` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `biography` text DEFAULT NULL,
  `picture` varchar(200) NOT NULL DEFAULT 'storage/sys/default_cover.png',
  `date` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `character_anime`
--

CREATE TABLE `character_anime` (
  `character_id` int(10) UNSIGNED NOT NULL,
  `anime_id` int(10) UNSIGNED NOT NULL,
  `role` enum('Main','Supporting') NOT NULL DEFAULT 'Supporting'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `character_manga`
--

CREATE TABLE `character_manga` (
  `character_id` int(10) UNSIGNED NOT NULL,
  `manga_id` int(10) UNSIGNED NOT NULL,
  `role` enum('Main','Supporting') NOT NULL DEFAULT 'Supporting'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `character_vn`
--

CREATE TABLE `character_vn` (
  `character_id` int(10) UNSIGNED NOT NULL,
  `vn_id` int(10) UNSIGNED NOT NULL,
  `role` enum('Main','Supporting') NOT NULL DEFAULT 'Supporting'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `edit_anime`
--

CREATE TABLE `edit_anime` (
  `edit_id` int(10) UNSIGNED NOT NULL,
  `anime_id` int(10) UNSIGNED NOT NULL,
  `title` varchar(150) DEFAULT NULL,
  `english_title` varchar(150) DEFAULT NULL,
  `japanese_title` varchar(150) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `type` varchar(25) DEFAULT NULL,
  `episodes` smallint(5) UNSIGNED DEFAULT NULL,
  `status` varchar(25) DEFAULT NULL,
  `start_date` varchar(50) DEFAULT NULL,
  `end_date` varchar(50) DEFAULT NULL,
  `description` varchar(3000) DEFAULT NULL,
  `cover` varchar(400) DEFAULT NULL,
  `header` varchar(400) DEFAULT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `date` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `edit_manga`
--

CREATE TABLE `edit_manga` (
  `smid` int(10) UNSIGNED NOT NULL,
  `manga_id` int(10) UNSIGNED NOT NULL,
  `title` varchar(150) DEFAULT NULL,
  `english_title` varchar(150) DEFAULT NULL,
  `japanese_title` varchar(150) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `format` varchar(25) DEFAULT NULL,
  `volumes` tinyint(3) UNSIGNED DEFAULT NULL,
  `chapters` smallint(5) UNSIGNED DEFAULT NULL,
  `status` varchar(25) DEFAULT NULL,
  `start_date` varchar(50) DEFAULT NULL,
  `end_date` varchar(50) DEFAULT NULL,
  `description` varchar(3000) DEFAULT NULL,
  `cover` varchar(400) DEFAULT NULL,
  `header` varchar(400) DEFAULT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `date` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `edit_vn`
--

CREATE TABLE `edit_vn` (
  `svid` int(10) UNSIGNED NOT NULL,
  `vn_id` int(10) UNSIGNED NOT NULL,
  `title` varchar(150) DEFAULT NULL,
  `english_title` varchar(150) DEFAULT NULL,
  `japanese_title` varchar(150) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `duration` varchar(30) DEFAULT NULL,
  `released` date DEFAULT NULL,
  `description` varchar(3000) DEFAULT NULL,
  `cover` varchar(300) DEFAULT NULL,
  `header` varchar(300) DEFAULT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `date` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `follow`
--

CREATE TABLE `follow` (
  `following_user` int(10) UNSIGNED NOT NULL,
  `followed_user` int(10) UNSIGNED NOT NULL,
  `date` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `follow`
--

INSERT INTO `follow` (`following_user`, `followed_user`, `date`) VALUES
(16, 17, '2023-05-31 13:35:49'),
(17, 16, '2023-05-31 13:36:22');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `manga`
--

CREATE TABLE `manga` (
  `manga_id` int(10) UNSIGNED NOT NULL,
  `title` varchar(150) NOT NULL,
  `english_title` varchar(150) DEFAULT NULL,
  `japanese_title` varchar(150) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `format` varchar(25) NOT NULL,
  `volumes` tinyint(3) UNSIGNED NOT NULL,
  `chapters` smallint(5) UNSIGNED NOT NULL,
  `status` varchar(25) NOT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `description` varchar(3000) NOT NULL,
  `cover` varchar(200) NOT NULL DEFAULT 'storage/sys/default_cover.png',
  `header` varchar(200) DEFAULT NULL,
  `date` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `manga`
--

INSERT INTO `manga` (`manga_id`, `title`, `english_title`, `japanese_title`, `format`, `volumes`, `chapters`, `status`, `start_date`, `end_date`, `description`, `cover`, `header`, `date`) VALUES
(3, 'Oyasumi Punpun', '', '', 'manga', 12, 144, 'finished', '2023-05-02', '2023-05-30', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', '/storage/public/manga/cover/manga_64772d3967306.jpg', '/storage/public/manga/header/manga_64772d3967b90.png', '2023-05-31 13:19:21'),
(5, 'MONSTER', NULL, NULL, 'manga', 10, 200, 'finished', '2023-05-03', '2023-05-31', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', '/storage/public/manga/cover/manga_64772fc8c2fb3.jpg', NULL, '2023-05-31 13:30:16'),
(6, 'Berserk', NULL, NULL, 'manga', 16, 345, 'finished', '2023-04-27', '2023-05-31', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', '/storage/public/manga/cover/manga_6477304423d2c.jpg', '/storage/public/manga/header/manga_6477304424883.jpg', '2023-05-31 13:32:20'),
(7, 'Vagabond', NULL, NULL, 'manga', 12, 1000, 'finished', '2023-05-25', '2023-05-31', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', '/storage/public/manga/cover/manga_64773066db461.png', '/storage/public/manga/header/manga_64773066dc353.jpg', '2023-05-31 13:32:54');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mangalist`
--

CREATE TABLE `mangalist` (
  `user_id` int(10) UNSIGNED NOT NULL,
  `manga_id` int(10) UNSIGNED NOT NULL,
  `score` decimal(3,1) DEFAULT NULL,
  `status` enum('completed','reading','planned','stalled','dropped') NOT NULL DEFAULT 'reading',
  `progress` smallint(5) UNSIGNED NOT NULL DEFAULT 0,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `rewatches` tinyint(3) UNSIGNED NOT NULL DEFAULT 0,
  `favorite` bit(1) NOT NULL DEFAULT b'0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `mangalist`
--

INSERT INTO `mangalist` (`user_id`, `manga_id`, `score`, `status`, `progress`, `start_date`, `end_date`, `notes`, `rewatches`, `favorite`) VALUES
(16, 3, 9.0, 'completed', 144, NULL, NULL, '', 0, b'1'),
(16, 7, NULL, 'reading', 2, NULL, NULL, NULL, 0, b'0'),
(17, 7, 5.0, 'completed', 1000, NULL, NULL, '', 0, b'0'),
(17, 6, 8.0, 'completed', 345, NULL, NULL, '', 0, b'0'),
(17, 5, 3.0, 'completed', 200, NULL, NULL, '', 0, b'0');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `post`
--

CREATE TABLE `post` (
  `post_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `content` varchar(350) NOT NULL,
  `date` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `post`
--

INSERT INTO `post` (`post_id`, `user_id`, `content`, `date`) VALUES
(176, 16, 'post de ejemplo', '2023-05-31 12:28:26'),
(177, 16, 'post de ejemplo', '2023-05-31 12:28:34'),
(178, 16, 'post de ejemplo', '2023-05-31 12:28:41'),
(179, 17, 'post de ejemplo', '2023-05-31 13:39:40'),
(180, 17, 'post de ejemplo', '2023-05-31 13:39:49'),
(181, 17, 'post de ejemplo', '2023-05-31 13:39:59');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `post_anime`
--

CREATE TABLE `post_anime` (
  `post_id` bigint(20) UNSIGNED NOT NULL,
  `anime_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `post_anime`
--

INSERT INTO `post_anime` (`post_id`, `anime_id`) VALUES
(177, 20),
(178, 20);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `post_like`
--

CREATE TABLE `post_like` (
  `post_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `date` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `post_like`
--

INSERT INTO `post_like` (`post_id`, `user_id`, `date`) VALUES
(176, 17, '2023-05-31 13:40:07'),
(180, 17, '2023-05-31 13:40:01');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `post_manga`
--

CREATE TABLE `post_manga` (
  `post_id` bigint(20) UNSIGNED NOT NULL,
  `manga_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `post_manga`
--

INSERT INTO `post_manga` (`post_id`, `manga_id`) VALUES
(180, 5),
(181, 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `post_reply`
--

CREATE TABLE `post_reply` (
  `post_id` bigint(20) UNSIGNED NOT NULL,
  `reply_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `post_reply`
--

INSERT INTO `post_reply` (`post_id`, `reply_id`) VALUES
(177, 178),
(180, 181);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `review`
--

CREATE TABLE `review` (
  `review_id` smallint(5) UNSIGNED NOT NULL,
  `title` varchar(50) DEFAULT NULL,
  `text` text NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `date` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `review`
--

INSERT INTO `review` (`review_id`, `title`, `text`, `user_id`, `date`) VALUES
(28, 'Review de ejemplo', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 16, '2023-05-31 13:34:32'),
(29, 'Review de ejemplo', 'Review de ejemplo', 16, '2023-05-31 13:34:53'),
(30, 'Review de ejemplo', 'Review de ejemplo', 16, '2023-05-31 13:35:14'),
(31, 'Review de ejemplo', 'Review de ejemplo', 16, '2023-05-31 13:35:39');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `review_anime`
--

CREATE TABLE `review_anime` (
  `review_id` smallint(5) UNSIGNED NOT NULL,
  `anime_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `review_anime`
--

INSERT INTO `review_anime` (`review_id`, `anime_id`) VALUES
(28, 20),
(30, 18);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `review_manga`
--

CREATE TABLE `review_manga` (
  `review_id` smallint(5) UNSIGNED NOT NULL,
  `manga_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `review_manga`
--

INSERT INTO `review_manga` (`review_id`, `manga_id`) VALUES
(29, 7),
(31, 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `review_vn`
--

CREATE TABLE `review_vn` (
  `review_id` smallint(5) UNSIGNED NOT NULL,
  `vn_id` int(10) UNSIGNED NOT NULL,
  `date` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `review_vote`
--

CREATE TABLE `review_vote` (
  `user_id` int(10) UNSIGNED NOT NULL,
  `review_id` smallint(5) UNSIGNED NOT NULL,
  `vote` bit(1) NOT NULL DEFAULT b'0',
  `date` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `staff`
--

CREATE TABLE `staff` (
  `staff_id` int(10) UNSIGNED NOT NULL,
  `family_name` varchar(50) DEFAULT NULL,
  `given_name` varchar(50) DEFAULT NULL,
  `alias` varchar(50) DEFAULT NULL,
  `japanese_name` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `biography` text DEFAULT NULL,
  `picture` varchar(200) NOT NULL DEFAULT 'storage/sys/default_cover.png',
  `date` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `staff_anime`
--

CREATE TABLE `staff_anime` (
  `staff_id` int(10) UNSIGNED NOT NULL,
  `anime_id` int(10) UNSIGNED NOT NULL,
  `role` varchar(50) NOT NULL DEFAULT 'Participant'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `staff_manga`
--

CREATE TABLE `staff_manga` (
  `staff_id` int(10) UNSIGNED NOT NULL,
  `manga_id` int(10) UNSIGNED NOT NULL,
  `role` varchar(50) NOT NULL DEFAULT 'Participant'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `staff_vn`
--

CREATE TABLE `staff_vn` (
  `staff_id` int(10) UNSIGNED NOT NULL,
  `vn_id` int(10) UNSIGNED NOT NULL,
  `role` varchar(50) NOT NULL DEFAULT 'Participant'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `submit_anime`
--

CREATE TABLE `submit_anime` (
  `said` int(10) UNSIGNED NOT NULL,
  `title` varchar(150) DEFAULT NULL,
  `english_title` varchar(150) DEFAULT NULL,
  `japanese_title` varchar(150) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `type` varchar(25) DEFAULT NULL,
  `episodes` smallint(5) UNSIGNED DEFAULT NULL,
  `status` varchar(25) DEFAULT NULL,
  `start_date` varchar(50) DEFAULT NULL,
  `end_date` varchar(50) DEFAULT NULL,
  `description` varchar(3000) DEFAULT NULL,
  `cover` varchar(400) DEFAULT NULL,
  `header` varchar(400) DEFAULT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `date` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `submit_character`
--

CREATE TABLE `submit_character` (
  `scid` int(10) UNSIGNED NOT NULL,
  `family_name` varchar(50) DEFAULT NULL,
  `given_name` varchar(50) DEFAULT NULL,
  `alias` varchar(200) DEFAULT NULL,
  `japanese_name` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `biography` text DEFAULT NULL,
  `picture` varchar(200) NOT NULL DEFAULT 'storage/sys/default_cover.png',
  `user_id` int(10) UNSIGNED NOT NULL,
  `date` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `submit_manga`
--

CREATE TABLE `submit_manga` (
  `smid` int(10) UNSIGNED NOT NULL,
  `title` varchar(150) DEFAULT NULL,
  `english_title` varchar(150) DEFAULT NULL,
  `japanese_title` varchar(150) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `format` varchar(25) DEFAULT NULL,
  `volumes` tinyint(3) UNSIGNED DEFAULT NULL,
  `chapters` smallint(5) UNSIGNED DEFAULT NULL,
  `status` varchar(25) DEFAULT NULL,
  `start_date` varchar(50) DEFAULT NULL,
  `end_date` varchar(50) DEFAULT NULL,
  `description` varchar(3000) DEFAULT NULL,
  `cover` varchar(400) DEFAULT NULL,
  `header` varchar(400) DEFAULT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `date` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `submit_manga`
--

INSERT INTO `submit_manga` (`smid`, `title`, `english_title`, `japanese_title`, `format`, `volumes`, `chapters`, `status`, `start_date`, `end_date`, `description`, `cover`, `header`, `user_id`, `date`) VALUES
(2, 'Oyasumi Punpun', '', '', 'manga', 12, 144, 'announced', '2023-05-02', '2023-05-31', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', '/storage/submissions/manga/cover/manga_6477231aabb62.jpg', '/storage/submissions/manga/header/manga_6477231aac382.png', 17, '2023-05-31 12:36:10'),
(3, 'df', '', '', 'manga', 0, 0, 'announced', '', '', '', '/storage/submissions/manga/cover/manga_64772cf4ed265.jpg', NULL, 17, '2023-05-31 13:18:12');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `submit_staff`
--

CREATE TABLE `submit_staff` (
  `ssid` int(10) UNSIGNED NOT NULL,
  `family_name` varchar(50) DEFAULT NULL,
  `given_name` varchar(50) DEFAULT NULL,
  `alias` varchar(200) DEFAULT NULL,
  `japanese_name` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `biography` text DEFAULT NULL,
  `picture` varchar(200) NOT NULL DEFAULT 'storage/sys/default_cover.png',
  `user_id` int(10) UNSIGNED NOT NULL,
  `date` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `submit_vn`
--

CREATE TABLE `submit_vn` (
  `svid` int(10) UNSIGNED NOT NULL,
  `title` varchar(150) DEFAULT NULL,
  `english_title` varchar(150) DEFAULT NULL,
  `japanese_title` varchar(150) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `duration` varchar(30) DEFAULT NULL,
  `released` date DEFAULT NULL,
  `description` varchar(3000) DEFAULT NULL,
  `cover` varchar(300) DEFAULT NULL,
  `header` varchar(300) DEFAULT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `date` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user`
--

CREATE TABLE `user` (
  `user_id` int(10) UNSIGNED NOT NULL,
  `username` varchar(16) NOT NULL,
  `password` varchar(60) NOT NULL,
  `email` varchar(319) NOT NULL,
  `joined_at` datetime DEFAULT current_timestamp(),
  `country` varchar(56) DEFAULT NULL,
  `biography` varchar(4000) DEFAULT NULL,
  `born` date DEFAULT NULL,
  `pfp` varchar(250) NOT NULL DEFAULT '/storage/sys/default.webp',
  `header` varchar(250) DEFAULT NULL,
  `twitter` varchar(15) DEFAULT NULL,
  `github` varchar(39) DEFAULT NULL,
  `discord` varchar(39) DEFAULT NULL,
  `website` varchar(200) DEFAULT NULL,
  `shares` bit(1) NOT NULL DEFAULT b'0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `user`
--

INSERT INTO `user` (`user_id`, `username`, `password`, `email`, `joined_at`, `country`, `biography`, `born`, `pfp`, `header`, `twitter`, `github`, `discord`, `website`, `shares`) VALUES
(16, 'adrian', '$2y$10$EgjUuhMWFQHcWUnOO0OR9e.VTQH.dy8M6j9z8D5sIwyMYaKUhftXy', 'adrian@adrian.adrian', '2023-05-31 11:38:15', 'sadas', 'afdadasd', '2023-05-10', '/storage/sys/default.webp', '/storage/sys/banner.jpg', 'asdasd', 'asdasd', 'asdasd#0001', NULL, b'0'),
(17, 'usuario', '$2y$10$I0xWfnCKA.qTutvOOIlLAemMCBx8ALyUczcmaFUX3cRX8pb9XblV6', 'usuario@usuario.usuario', '2023-05-31 12:29:21', NULL, NULL, NULL, '/storage/sys/default.png', '/storage/sys/banner.jpg', NULL, NULL, NULL, NULL, b'0');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vn`
--

CREATE TABLE `vn` (
  `vn_id` int(10) UNSIGNED NOT NULL,
  `title` varchar(150) NOT NULL,
  `english_title` varchar(150) DEFAULT NULL,
  `japanese_title` varchar(150) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `duration` int(10) UNSIGNED DEFAULT NULL,
  `released` date DEFAULT NULL,
  `description` varchar(3000) NOT NULL,
  `cover` varchar(200) NOT NULL DEFAULT 'storage/sys/default_cover.png',
  `header` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `anime`
--
ALTER TABLE `anime`
  ADD PRIMARY KEY (`anime_id`),
  ADD UNIQUE KEY `title` (`title`),
  ADD UNIQUE KEY `english_title` (`english_title`),
  ADD UNIQUE KEY `japanese_title` (`japanese_title`);

--
-- Indices de la tabla `animelist`
--
ALTER TABLE `animelist`
  ADD PRIMARY KEY (`user_id`,`anime_id`),
  ADD KEY `anime_id` (`anime_id`);

--
-- Indices de la tabla `bookmark`
--
ALTER TABLE `bookmark`
  ADD PRIMARY KEY (`post_id`,`user_id`),
  ADD UNIQUE KEY `bookmark_unique` (`post_id`,`user_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indices de la tabla `character`
--
ALTER TABLE `character`
  ADD PRIMARY KEY (`character_id`);

--
-- Indices de la tabla `character_anime`
--
ALTER TABLE `character_anime`
  ADD PRIMARY KEY (`character_id`,`anime_id`),
  ADD KEY `anime_id` (`anime_id`);

--
-- Indices de la tabla `character_manga`
--
ALTER TABLE `character_manga`
  ADD PRIMARY KEY (`character_id`,`manga_id`),
  ADD KEY `manga_id` (`manga_id`);

--
-- Indices de la tabla `character_vn`
--
ALTER TABLE `character_vn`
  ADD PRIMARY KEY (`character_id`,`vn_id`),
  ADD KEY `vn_id` (`vn_id`);

--
-- Indices de la tabla `edit_anime`
--
ALTER TABLE `edit_anime`
  ADD PRIMARY KEY (`edit_id`,`anime_id`,`user_id`),
  ADD KEY `anime_id` (`anime_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indices de la tabla `edit_manga`
--
ALTER TABLE `edit_manga`
  ADD PRIMARY KEY (`smid`),
  ADD KEY `manga_id` (`manga_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indices de la tabla `edit_vn`
--
ALTER TABLE `edit_vn`
  ADD PRIMARY KEY (`svid`),
  ADD KEY `vn_id` (`vn_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indices de la tabla `follow`
--
ALTER TABLE `follow`
  ADD KEY `following_user` (`following_user`),
  ADD KEY `followed_user` (`followed_user`);

--
-- Indices de la tabla `manga`
--
ALTER TABLE `manga`
  ADD PRIMARY KEY (`manga_id`),
  ADD UNIQUE KEY `title` (`title`),
  ADD UNIQUE KEY `english_title` (`english_title`),
  ADD UNIQUE KEY `japanese_title` (`japanese_title`);

--
-- Indices de la tabla `mangalist`
--
ALTER TABLE `mangalist`
  ADD KEY `user_id` (`user_id`),
  ADD KEY `manga_id` (`manga_id`);

--
-- Indices de la tabla `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`post_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indices de la tabla `post_anime`
--
ALTER TABLE `post_anime`
  ADD PRIMARY KEY (`post_id`,`anime_id`),
  ADD KEY `anime_id` (`anime_id`);

--
-- Indices de la tabla `post_like`
--
ALTER TABLE `post_like`
  ADD PRIMARY KEY (`post_id`,`user_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indices de la tabla `post_manga`
--
ALTER TABLE `post_manga`
  ADD PRIMARY KEY (`post_id`,`manga_id`),
  ADD KEY `manga_id` (`manga_id`);

--
-- Indices de la tabla `post_reply`
--
ALTER TABLE `post_reply`
  ADD PRIMARY KEY (`post_id`,`reply_id`),
  ADD KEY `reply_id` (`reply_id`);

--
-- Indices de la tabla `review`
--
ALTER TABLE `review`
  ADD PRIMARY KEY (`review_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indices de la tabla `review_anime`
--
ALTER TABLE `review_anime`
  ADD PRIMARY KEY (`review_id`,`anime_id`),
  ADD KEY `anime_id` (`anime_id`);

--
-- Indices de la tabla `review_manga`
--
ALTER TABLE `review_manga`
  ADD KEY `review_id` (`review_id`),
  ADD KEY `manga_id` (`manga_id`);

--
-- Indices de la tabla `review_vn`
--
ALTER TABLE `review_vn`
  ADD PRIMARY KEY (`review_id`,`vn_id`),
  ADD KEY `vn_id` (`vn_id`);

--
-- Indices de la tabla `review_vote`
--
ALTER TABLE `review_vote`
  ADD UNIQUE KEY `review_vote` (`user_id`,`review_id`);

--
-- Indices de la tabla `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`staff_id`);

--
-- Indices de la tabla `staff_anime`
--
ALTER TABLE `staff_anime`
  ADD PRIMARY KEY (`staff_id`,`anime_id`),
  ADD KEY `anime_id` (`anime_id`);

--
-- Indices de la tabla `staff_manga`
--
ALTER TABLE `staff_manga`
  ADD PRIMARY KEY (`staff_id`,`manga_id`),
  ADD KEY `manga_id` (`manga_id`);

--
-- Indices de la tabla `staff_vn`
--
ALTER TABLE `staff_vn`
  ADD PRIMARY KEY (`staff_id`,`vn_id`),
  ADD KEY `vn_id` (`vn_id`);

--
-- Indices de la tabla `submit_anime`
--
ALTER TABLE `submit_anime`
  ADD PRIMARY KEY (`said`),
  ADD KEY `user_id` (`user_id`);

--
-- Indices de la tabla `submit_character`
--
ALTER TABLE `submit_character`
  ADD PRIMARY KEY (`scid`),
  ADD KEY `user_id` (`user_id`);

--
-- Indices de la tabla `submit_manga`
--
ALTER TABLE `submit_manga`
  ADD PRIMARY KEY (`smid`),
  ADD KEY `user_id` (`user_id`);

--
-- Indices de la tabla `submit_staff`
--
ALTER TABLE `submit_staff`
  ADD PRIMARY KEY (`ssid`),
  ADD KEY `user_id` (`user_id`);

--
-- Indices de la tabla `submit_vn`
--
ALTER TABLE `submit_vn`
  ADD PRIMARY KEY (`svid`),
  ADD KEY `user_id` (`user_id`);

--
-- Indices de la tabla `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `twitter` (`twitter`),
  ADD UNIQUE KEY `discord` (`discord`);

--
-- Indices de la tabla `vn`
--
ALTER TABLE `vn`
  ADD PRIMARY KEY (`vn_id`),
  ADD UNIQUE KEY `title` (`title`),
  ADD UNIQUE KEY `english_title` (`english_title`),
  ADD UNIQUE KEY `japanese_title` (`japanese_title`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `anime`
--
ALTER TABLE `anime`
  MODIFY `anime_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `character`
--
ALTER TABLE `character`
  MODIFY `character_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `edit_anime`
--
ALTER TABLE `edit_anime`
  MODIFY `edit_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `edit_manga`
--
ALTER TABLE `edit_manga`
  MODIFY `smid` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `edit_vn`
--
ALTER TABLE `edit_vn`
  MODIFY `svid` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `manga`
--
ALTER TABLE `manga`
  MODIFY `manga_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `post`
--
ALTER TABLE `post`
  MODIFY `post_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=182;

--
-- AUTO_INCREMENT de la tabla `post_like`
--
ALTER TABLE `post_like`
  MODIFY `post_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=181;

--
-- AUTO_INCREMENT de la tabla `review`
--
ALTER TABLE `review`
  MODIFY `review_id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT de la tabla `staff`
--
ALTER TABLE `staff`
  MODIFY `staff_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `submit_anime`
--
ALTER TABLE `submit_anime`
  MODIFY `said` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `submit_character`
--
ALTER TABLE `submit_character`
  MODIFY `scid` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `submit_manga`
--
ALTER TABLE `submit_manga`
  MODIFY `smid` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `submit_staff`
--
ALTER TABLE `submit_staff`
  MODIFY `ssid` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `submit_vn`
--
ALTER TABLE `submit_vn`
  MODIFY `svid` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `vn`
--
ALTER TABLE `vn`
  MODIFY `vn_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `animelist`
--
ALTER TABLE `animelist`
  ADD CONSTRAINT `animelist_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `animelist_ibfk_2` FOREIGN KEY (`anime_id`) REFERENCES `anime` (`anime_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `bookmark`
--
ALTER TABLE `bookmark`
  ADD CONSTRAINT `bookmark_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `post` (`post_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `bookmark_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `character_anime`
--
ALTER TABLE `character_anime`
  ADD CONSTRAINT `character_anime_ibfk_1` FOREIGN KEY (`character_id`) REFERENCES `character` (`character_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `character_anime_ibfk_2` FOREIGN KEY (`anime_id`) REFERENCES `anime` (`anime_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `character_manga`
--
ALTER TABLE `character_manga`
  ADD CONSTRAINT `character_manga_ibfk_1` FOREIGN KEY (`character_id`) REFERENCES `character` (`character_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `character_manga_ibfk_2` FOREIGN KEY (`manga_id`) REFERENCES `manga` (`manga_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `character_vn`
--
ALTER TABLE `character_vn`
  ADD CONSTRAINT `character_vn_ibfk_1` FOREIGN KEY (`character_id`) REFERENCES `character` (`character_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `character_vn_ibfk_2` FOREIGN KEY (`vn_id`) REFERENCES `vn` (`vn_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `edit_anime`
--
ALTER TABLE `edit_anime`
  ADD CONSTRAINT `edit_anime_ibfk_1` FOREIGN KEY (`anime_id`) REFERENCES `anime` (`anime_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `edit_anime_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `edit_manga`
--
ALTER TABLE `edit_manga`
  ADD CONSTRAINT `edit_manga_ibfk_1` FOREIGN KEY (`manga_id`) REFERENCES `manga` (`manga_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `edit_manga_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `edit_vn`
--
ALTER TABLE `edit_vn`
  ADD CONSTRAINT `edit_vn_ibfk_1` FOREIGN KEY (`vn_id`) REFERENCES `vn` (`vn_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `edit_vn_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `follow`
--
ALTER TABLE `follow`
  ADD CONSTRAINT `follow_ibfk_1` FOREIGN KEY (`following_user`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `follow_ibfk_2` FOREIGN KEY (`followed_user`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `mangalist`
--
ALTER TABLE `mangalist`
  ADD CONSTRAINT `mangalist_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `mangalist_ibfk_2` FOREIGN KEY (`manga_id`) REFERENCES `manga` (`manga_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `post_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `post_anime`
--
ALTER TABLE `post_anime`
  ADD CONSTRAINT `post_anime_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `post` (`post_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `post_anime_ibfk_2` FOREIGN KEY (`anime_id`) REFERENCES `anime` (`anime_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `post_like`
--
ALTER TABLE `post_like`
  ADD CONSTRAINT `post_like_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `post_manga`
--
ALTER TABLE `post_manga`
  ADD CONSTRAINT `post_manga_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `post` (`post_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `post_manga_ibfk_2` FOREIGN KEY (`manga_id`) REFERENCES `manga` (`manga_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `post_reply`
--
ALTER TABLE `post_reply`
  ADD CONSTRAINT `post_reply_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `post` (`post_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `post_reply_ibfk_2` FOREIGN KEY (`reply_id`) REFERENCES `post` (`post_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `review`
--
ALTER TABLE `review`
  ADD CONSTRAINT `review_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `review_anime`
--
ALTER TABLE `review_anime`
  ADD CONSTRAINT `review_anime_ibfk_1` FOREIGN KEY (`review_id`) REFERENCES `review` (`review_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `review_anime_ibfk_2` FOREIGN KEY (`anime_id`) REFERENCES `anime` (`anime_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `review_manga`
--
ALTER TABLE `review_manga`
  ADD CONSTRAINT `review_manga_ibfk_1` FOREIGN KEY (`review_id`) REFERENCES `review` (`review_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `review_manga_ibfk_2` FOREIGN KEY (`manga_id`) REFERENCES `manga` (`manga_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `review_vn`
--
ALTER TABLE `review_vn`
  ADD CONSTRAINT `review_vn_ibfk_1` FOREIGN KEY (`review_id`) REFERENCES `review` (`review_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `review_vn_ibfk_2` FOREIGN KEY (`vn_id`) REFERENCES `vn` (`vn_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `staff_anime`
--
ALTER TABLE `staff_anime`
  ADD CONSTRAINT `staff_anime_ibfk_1` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`staff_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `staff_anime_ibfk_2` FOREIGN KEY (`anime_id`) REFERENCES `anime` (`anime_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `staff_manga`
--
ALTER TABLE `staff_manga`
  ADD CONSTRAINT `staff_manga_ibfk_1` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`staff_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `staff_manga_ibfk_2` FOREIGN KEY (`manga_id`) REFERENCES `manga` (`manga_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `staff_vn`
--
ALTER TABLE `staff_vn`
  ADD CONSTRAINT `staff_vn_ibfk_1` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`staff_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `staff_vn_ibfk_2` FOREIGN KEY (`vn_id`) REFERENCES `vn` (`vn_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `submit_anime`
--
ALTER TABLE `submit_anime`
  ADD CONSTRAINT `submit_anime_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `submit_character`
--
ALTER TABLE `submit_character`
  ADD CONSTRAINT `submit_character_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `submit_manga`
--
ALTER TABLE `submit_manga`
  ADD CONSTRAINT `submit_manga_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `submit_staff`
--
ALTER TABLE `submit_staff`
  ADD CONSTRAINT `submit_staff_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `submit_vn`
--
ALTER TABLE `submit_vn`
  ADD CONSTRAINT `submit_vn_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
