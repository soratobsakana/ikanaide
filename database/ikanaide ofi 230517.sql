-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:5555
-- Tiempo de generación: 17-05-2023 a las 10:30:12
-- Versión del servidor: 10.4.27-MariaDB
-- Versión de PHP: 8.2.0

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
  `season` varchar(30) NOT NULL,
  `description` varchar(3000) NOT NULL,
  `members` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `favorited` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `cover` varchar(200) NOT NULL DEFAULT 'storage/sys/default_cover.png',
  `header` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `anime`
--

INSERT INTO `anime` (`anime_id`, `title`, `english_title`, `japanese_title`, `type`, `episodes`, `status`, `start_date`, `end_date`, `season`, `description`, `members`, `favorited`, `cover`, `header`) VALUES
(1, 'Gintama', NULL, NULL, 'TV', 49, 'finished', '2011-04-04', '2012-03-26', 'spring 2011', 'After a one-year hiatus, Shinpachi Shimura returns to Edo, only to stumble upon a shocking surprise: Gintoki and Kagura, his fellow Yorozuya members, have become completely different characters! Fleeing from the Yorozuya headquarters in confusion, Shinpachi finds that all the denizens of Edo have undergone impossibly extreme changes, in both appearance and personality. Most unbelievably, his sister Otae has married the Shinsengumi chief and shameless stalker Isao Kondou and is pregnant with their first child.', 0, 1, '/storage/img/gintama.webp', '/storage/img/gintama_header.jpg');

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
(2, 1, '3.0', 'watching', 8, '2023-05-12', '2023-05-18', '', 0, b'0'),
(6, 1, NULL, 'watching', 3, NULL, NULL, NULL, 0, b'1');

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
(103, 2, '2023-05-11 10:28:07'),
(112, 7, '2023-05-11 13:17:33'),
(113, 7, '2023-05-11 13:15:59'),
(126, 2, '2023-05-12 10:23:12'),
(126, 7, '2023-05-12 10:25:29'),
(127, 2, '2023-05-12 10:44:14');

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
  `data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`data`)),
  `picture` varchar(200) NOT NULL DEFAULT 'storage/sys/default_cover.png'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `character`
--

INSERT INTO `character` (`character_id`, `family_name`, `given_name`, `alias`, `japanese_name`, `data`, `picture`) VALUES
(1, 'Sakata', 'Gintoki', NULL, NULL, NULL, '/storage/public/character/gintoki.jpg'),
(2, 'Onodera', 'Punpun', NULL, NULL, NULL, '/storage/public/character/punpun.jpg'),
(3, 'Sakataa', 'Gintoki', NULL, NULL, NULL, 'storage/public/character/gintoki.jpg'),
(4, 'Sakataaa', 'Gintoki', NULL, NULL, NULL, 'storage/public/character/gintoki.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `character_anime`
--

CREATE TABLE `character_anime` (
  `character_id` int(10) UNSIGNED NOT NULL,
  `anime_id` int(10) UNSIGNED NOT NULL,
  `role` enum('Main','Supporting') NOT NULL DEFAULT 'Supporting'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `character_anime`
--

INSERT INTO `character_anime` (`character_id`, `anime_id`, `role`) VALUES
(1, 1, 'Main');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `character_manga`
--

CREATE TABLE `character_manga` (
  `character_id` int(10) UNSIGNED NOT NULL,
  `manga_id` int(10) UNSIGNED NOT NULL,
  `role` enum('Main','Supporting') NOT NULL DEFAULT 'Supporting'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `character_manga`
--

INSERT INTO `character_manga` (`character_id`, `manga_id`, `role`) VALUES
(2, 1, 'Supporting');

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
(2, 7, '2023-05-08 11:21:28'),
(7, 2, '2023-05-11 13:14:37');

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
  `members` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `favorited` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `cover` varchar(200) NOT NULL DEFAULT 'storage/sys/default_cover.png',
  `header` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `manga`
--

INSERT INTO `manga` (`manga_id`, `title`, `english_title`, `japanese_title`, `format`, `volumes`, `chapters`, `status`, `start_date`, `end_date`, `description`, `members`, `favorited`, `cover`, `header`) VALUES
(1, 'Oyasumi Punpun', NULL, NULL, 'manga', 13, 144, 'finished', '2007-03-15', '2013-11-02', 'Punpun Onodera is a normal 11-year-old boy living in Japan. Hopelessly idealistic and romantic, Punpun begins to see his life take a subtle—though nonetheless startling—turn to the adult when he meets the new girl in his class, Aiko Tanaka. It is then that the quiet boy learns just how fickle maintaining a relationship can be, and the surmounting difficulties of transitioning from a naïve boyhood to a convoluted adulthood. When his father assaults his mother one night, Punpun realizes another thing: those whom he looked up to were not as impressive as he once thought.', 0, 1, '/storage/img/punpun.jpg', '/storage/img/punpun_header.png'),
(2, 'Oyasumi Punpunn', NULL, NULL, 'manga', 13, 144, 'finished', '2007-03-15', '2013-11-02', 'Punpun Onodera is a normal 11-year-old boy living in Japan. Hopelessly idealistic and romantic, Punpun begins to see his life take a subtle—though nonetheless startling—turn to the adult when he meets the new girl in his class, Aiko Tanaka. It is then that the quiet boy learns just how fickle maintaining a relationship can be, and the surmounting difficulties of transitioning from a naïve boyhood to a convoluted adulthood. When his father assaults his mother one night, Punpun realizes another thing: those whom he looked up to were not as impressive as he once thought.', 0, 1, '/storage/img/punpun.jpg', 'storage/img/punpun_header.png'),
(3, 'Oyasumi Punpunnn', NULL, NULL, 'manga', 13, 144, 'finished', '2007-03-15', '2013-11-02', 'Punpun Onodera is a normal 11-year-old boy living in Japan. Hopelessly idealistic and romantic, Punpun begins to see his life take a subtle—though nonetheless startling—turn to the adult when he meets the new girl in his class, Aiko Tanaka. It is then that the quiet boy learns just how fickle maintaining a relationship can be, and the surmounting difficulties of transitioning from a naïve boyhood to a convoluted adulthood. When his father assaults his mother one night, Punpun realizes another thing: those whom he looked up to were not as impressive as he once thought.', 0, 1, '/storage/img/punpun.jpg', 'storage/img/punpun_header.png');

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
(6, 1, NULL, 'reading', 7, NULL, NULL, NULL, 0, b'0'),
(2, 1, '3.0', 'reading', 2, NULL, NULL, '', 0, b'0'),
(2, 2, '3.0', 'reading', 3, NULL, NULL, '', 0, b'0'),
(2, 3, '3.0', 'reading', 0, NULL, NULL, '', 0, b'0');

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
(101, 2, '1', '2023-05-11 10:23:06'),
(102, 2, '2', '2023-05-11 10:23:08'),
(103, 2, '3', '2023-05-11 10:23:09'),
(104, 2, 'afddasf', '2023-05-11 10:27:17'),
(105, 2, 'adfdf', '2023-05-11 10:30:12'),
(106, 2, 'sdafdasf', '2023-05-11 10:33:02'),
(107, 2, 'first', '2023-05-11 10:44:10'),
(108, 2, 'second', '2023-05-11 10:44:14'),
(109, 2, 'third', '2023-05-11 11:03:33'),
(110, 2, 'asdasdasd', '2023-05-11 11:04:50'),
(111, 2, 'adsfadsf', '2023-05-11 11:04:52'),
(112, 2, 'asdasd', '2023-05-11 12:00:54'),
(113, 2, 'dasfasf', '2023-05-11 12:00:56'),
(121, 2, 'I have watched episode 1 from Gintama.', '2023-05-12 09:43:57'),
(122, 2, 'I have watched episode 2 from Gintama.', '2023-05-12 09:43:59'),
(123, 2, 'I have watched episode 3 from Gintama.', '2023-05-12 09:53:37'),
(124, 2, 'I have watched episode 4 from Gintama.', '2023-05-12 09:57:17'),
(125, 2, 'I have watched episode 5 from Gintama.', '2023-05-12 09:58:07'),
(126, 2, 'I have watched episode 6 from Gintama.', '2023-05-12 10:02:08'),
(127, 7, 'post', '2023-05-12 10:25:22'),
(128, 2, 'I have watched episode 7 from Gintama.', '2023-05-12 10:44:02'),
(129, 2, 'oyapunpun 1', '2023-05-12 10:59:19'),
(130, 2, 'oyapunpun 2', '2023-05-12 10:59:25'),
(131, 2, 'oyapunpun 3', '2023-05-12 10:59:30'),
(132, 2, 'oyapunpun 2', '2023-05-12 10:59:44'),
(133, 2, 'I have read chapter 1 from Oyasumi Punpunn.', '2023-05-12 12:57:18'),
(134, 2, 'I have read chapter 2 from Oyasumi Punpunn.', '2023-05-12 12:57:20'),
(135, 2, 'I have read chapter 3 from Oyasumi Punpunn.', '2023-05-12 12:57:20'),
(136, 2, 'I have read chapter 2 from Oyasumi Punpun.', '2023-05-12 12:58:51'),
(137, 2, 'asdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasd dasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasddasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasddasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasddasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasd', '2023-05-17 09:56:40'),
(138, 2, 'dfadsfasdfasf', '2023-05-17 10:26:59'),
(139, 2, 'I have watched episode 8 from Gintama.', '2023-05-17 10:28:25');

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
(121, 1),
(122, 1),
(123, 1),
(124, 1),
(125, 1),
(126, 1),
(128, 1),
(139, 1);

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
(28, 2, '2023-05-04 12:34:16'),
(29, 2, '2023-05-04 12:30:55'),
(30, 2, '2023-05-04 11:59:08'),
(32, 2, '2023-05-04 12:30:50'),
(33, 7, '2023-05-04 11:56:45'),
(38, 2, '2023-05-08 09:19:55'),
(86, 2, '2023-05-11 09:26:24'),
(94, 2, '2023-05-11 10:02:31'),
(99, 2, '2023-05-11 10:15:50'),
(100, 2, '2023-05-11 10:21:44'),
(103, 2, '2023-05-11 10:26:08'),
(104, 2, '2023-05-11 10:29:06'),
(112, 7, '2023-05-11 13:48:20'),
(113, 7, '2023-05-11 13:15:57'),
(115, 7, '2023-05-11 13:22:48'),
(126, 2, '2023-05-12 10:23:08'),
(126, 7, '2023-05-12 10:25:28'),
(127, 2, '2023-05-12 10:44:14'),
(133, 2, '2023-05-12 13:57:09');

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
(129, 1),
(130, 2),
(131, 3),
(132, 2),
(133, 2),
(134, 2),
(135, 2),
(136, 1);

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
(103, 104),
(103, 105),
(105, 106),
(105, 110),
(105, 111),
(107, 108),
(108, 109),
(111, 112),
(111, 113);

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
(14, 'dsfasdf', 'adsfasfasf', 2, '2023-05-09 13:46:07'),
(15, 'afdasdf', 'adsfadsf', 2, '2023-05-09 13:46:13'),
(16, 'asdf', 'afsdf', 2, '2023-05-09 13:46:22'),
(17, 'asfd', 'asfsaf', 2, '2023-05-09 13:46:26'),
(18, 'Title for a review of Gintama', 'Content for a review of Gintama', 2, '2023-05-12 09:44:23'),
(19, 'Lorem ipsum', 'Lorem Ipsum es simplemente el texto de relleno de las imprentas y archivos de texto. Lorem Ipsum ha sido el texto de relleno estándar de las industrias desde el año 1500, cuando un impresor (N. del T. persona que se dedica a la imprenta) desconocido usó una galería de textos y los mezcló de tal manera que logró hacer un libro de textos especimen. No sólo sobrevivió 500 años, sino que tambien ingresó como texto de relleno en documentos electrónicos, quedando esencialmente igual al original. Fue popularizado en los 60s con la creación de las hojas \"Letraset\", las cuales contenian pasajes de Lorem Ipsum, y más recientemente con software de autoedición, como por ejemplo Aldus PageMaker, el cual incluye versiones de Lorem Ipsum.', 2, '2023-05-12 10:05:22'),
(20, 'sdfa', 'dff', 2, '2023-05-12 12:59:46');

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
(15, 1),
(17, 1),
(18, 1),
(19, 1);

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
(14, 3),
(16, 2),
(20, 2);

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
-- Estructura de tabla para la tabla `staff`
--

CREATE TABLE `staff` (
  `staff_id` int(10) UNSIGNED NOT NULL,
  `family_name` varchar(50) DEFAULT NULL,
  `given_name` varchar(50) DEFAULT NULL,
  `alias` varchar(50) DEFAULT NULL,
  `japanese_name` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`data`)),
  `picture` varchar(200) NOT NULL DEFAULT 'storage/sys/default_cover.png'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `staff`
--

INSERT INTO `staff` (`staff_id`, `family_name`, `given_name`, `alias`, `japanese_name`, `data`, `picture`) VALUES
(1, 'Sorachi', 'Hideaki', NULL, NULL, NULL, '/storage/public/staff/Sorachi-Hideaki.jpg'),
(2, 'Inio', 'Asano', NULL, NULL, NULL, '/storage/public/staff/asano.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `staff_anime`
--

CREATE TABLE `staff_anime` (
  `staff_id` int(10) UNSIGNED NOT NULL,
  `anime_id` int(10) UNSIGNED NOT NULL,
  `role` varchar(50) NOT NULL DEFAULT 'Participant'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `staff_anime`
--

INSERT INTO `staff_anime` (`staff_id`, `anime_id`, `role`) VALUES
(1, 1, 'director');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `staff_manga`
--

CREATE TABLE `staff_manga` (
  `staff_id` int(10) UNSIGNED NOT NULL,
  `manga_id` int(10) UNSIGNED NOT NULL,
  `role` varchar(50) NOT NULL DEFAULT 'Participant'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `staff_manga`
--

INSERT INTO `staff_manga` (`staff_id`, `manga_id`, `role`) VALUES
(2, 1, 'creator');

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

--
-- Volcado de datos para la tabla `submit_anime`
--

INSERT INTO `submit_anime` (`said`, `title`, `english_title`, `japanese_title`, `type`, `episodes`, `status`, `start_date`, `end_date`, `description`, `cover`, `header`, `user_id`, `date`) VALUES
(1, 'asd', 'asd', 'asd', 'asd', 0, 'asd', 'asd', 'asd', '', '', '', 1, '2023-03-23 10:26:05');

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
  `pfp` varchar(250) NOT NULL DEFAULT 'storage/img/default/default.png',
  `header` varchar(250) DEFAULT NULL,
  `twitter` varchar(15) DEFAULT NULL,
  `github` varchar(39) DEFAULT NULL,
  `discord` varchar(39) DEFAULT NULL,
  `website` varchar(200) DEFAULT NULL,
  `shares` bit(1) NOT NULL DEFAULT b'0',
  `data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`data`))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `user`
--

INSERT INTO `user` (`user_id`, `username`, `password`, `email`, `joined_at`, `country`, `biography`, `born`, `pfp`, `header`, `twitter`, `github`, `discord`, `website`, `shares`, `data`) VALUES
(1, 'user', 'pw', 'pw@pw.pw', NULL, 'spain', 'This is my biography', NULL, '/storage/sys/default.webp', '/storage/sys/banner.jpg', NULL, NULL, NULL, NULL, b'0', NULL),
(2, 'adrian', '$2y$10$fvHVwcGLnsLCIB1Il1PYL.5veRsW8QMnWAQaL/vqg2FaP5ZvCnixO', 'a@a.com', '2023-03-24 09:17:47', 'Spain', 'test biography', '2023-05-26', '/storage/sys/default.webp', '/storage/sys/banner.jpg', 'nabuna', 'nabuna', 'nabuna#1775', 'https://ikanaide.com', b'1', NULL),
(3, 'bifrutas', '$2y$10$8L40t1hYHgZMAPTg638s/ejgLTccOtH0uiGlk.OUGKfVtkwF.802S', 'a@a.es', '2023-03-24 10:16:49', NULL, NULL, NULL, '/storage/sys/default.webp', '/storage/sys/banner.jpg', NULL, NULL, NULL, NULL, b'0', NULL),
(4, 'test', '$2y$10$6bN/72/0s7iSLX9N6s/ZFurIPmFB2pRnesl0NVVg.lPVwOQBIOCKq', 'test@test.com', '2023-03-24 11:43:39', NULL, NULL, NULL, '/storage/sys/default.webp', '/storage/sys/banner.jpg', NULL, NULL, NULL, NULL, b'0', NULL),
(5, 'test2', '$2y$10$E0pM1ofEIdug/C56lz3DxO3RryZ8JdJivSY/NkwzP4KAD6/.3xaVe', 'test2@test2.com', '2023-03-24 11:46:02', NULL, NULL, NULL, '/storage/sys/default.webp', '/storage/sys/banner.jpg', NULL, NULL, NULL, NULL, b'0', NULL),
(6, 'test3', '$2y$10$2iSvFHLmNz35p2TZqz9woOqUeiVgFwOlpWbP1.7GnWAeFdvHbvUYa', 'test3@test3.com', '2023-03-24 11:46:31', NULL, NULL, NULL, '/storage/sys/default.webp', '/storage/sys/banner.jpg', NULL, NULL, NULL, NULL, b'1', NULL),
(7, 'usuario', '$2y$10$ZSQB.eBOPK68V4u83R130eHftrIecRqTuq89adndstZGX/1Nh4mru', 'no@no.com', '2023-03-24 12:49:24', NULL, NULL, NULL, '/storage/sys/default.webp', '/storage/sys/banner.jpg', NULL, NULL, NULL, NULL, b'0', NULL),
(8, '15charusertest1', '$2y$10$WoCK/fxyHZwGL6zs1Jd0su0S5/ofuCRr3eI.q8Ks9IVc7JP3EeuY6', 'a@a.css', '2023-03-24 13:43:37', NULL, NULL, NULL, '/storage/sys/default.webp', '/storage/sys/banner.jpg', NULL, NULL, NULL, NULL, b'0', NULL);

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
  `members` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `favorited` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `cover` varchar(200) NOT NULL DEFAULT 'storage/sys/default_cover.png',
  `header` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `vn`
--

INSERT INTO `vn` (`vn_id`, `title`, `english_title`, `japanese_title`, `duration`, `released`, `description`, `members`, `favorited`, `cover`, `header`) VALUES
(1, 'Sakura no Uta', NULL, NULL, 3000, '2015-10-23', 'Naoya Kusanagi lost his mother when he was a child. Naoyas father who is a famous artist is the only person that can help him cope with the loss of his friend, Rin Misakura who move while they were in elementary school. Later, Naoyas father died. After the funeral ends, Naoya is taken into the custody of Keis family in exchange for cooking meals at their home. 6 years later, Rin is transferred to Naoyas class.', 0, 0, 'storage/img/sakuta.jpeg', 'storage/img/sakuta_header.jpg');

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
  ADD PRIMARY KEY (`review_id`,`manga_id`),
  ADD KEY `manga_id` (`manga_id`);

--
-- Indices de la tabla `review_vn`
--
ALTER TABLE `review_vn`
  ADD PRIMARY KEY (`review_id`,`vn_id`),
  ADD KEY `vn_id` (`vn_id`);

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
  ADD UNIQUE KEY `email` (`email`);

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
  MODIFY `anime_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `character`
--
ALTER TABLE `character`
  MODIFY `character_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

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
  MODIFY `manga_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `post`
--
ALTER TABLE `post`
  MODIFY `post_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=140;

--
-- AUTO_INCREMENT de la tabla `post_like`
--
ALTER TABLE `post_like`
  MODIFY `post_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=134;

--
-- AUTO_INCREMENT de la tabla `review`
--
ALTER TABLE `review`
  MODIFY `review_id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `staff`
--
ALTER TABLE `staff`
  MODIFY `staff_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `submit_anime`
--
ALTER TABLE `submit_anime`
  MODIFY `said` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `submit_character`
--
ALTER TABLE `submit_character`
  MODIFY `scid` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `submit_manga`
--
ALTER TABLE `submit_manga`
  MODIFY `smid` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `submit_staff`
--
ALTER TABLE `submit_staff`
  MODIFY `ssid` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `submit_vn`
--
ALTER TABLE `submit_vn`
  MODIFY `svid` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

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
