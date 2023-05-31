-- MySQL dump 10.13  Distrib 8.0.32, for macos13.0 (arm64)
--
-- Host: localhost    Database: ikanaide
-- ------------------------------------------------------
-- Server version	8.0.32

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
--
-- Table structure for table `anime`
--

DROP TABLE IF EXISTS `anime`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `anime` (
  `anime_id` int unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(150) NOT NULL,
  `english_title` varchar(150) DEFAULT NULL,
  `japanese_title` varchar(150) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `type` varchar(25) NOT NULL,
  `episodes` smallint unsigned NOT NULL,
  `status` varchar(25) NOT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `description` varchar(3000) NOT NULL,
  `cover` varchar(200) NOT NULL DEFAULT 'storage/sys/default_cover.png',
  `header` varchar(200) DEFAULT NULL,
  `date` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`anime_id`),
  UNIQUE KEY `title` (`title`),
  UNIQUE KEY `english_title` (`english_title`),
  UNIQUE KEY `japanese_title` (`japanese_title`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 ;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `anime`
--

LOCK TABLES `anime` WRITE;
/*!40000 ALTER TABLE `anime` DISABLE KEYS */;
/*!40000 ALTER TABLE `anime` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `animelist`
--

DROP TABLE IF EXISTS `animelist`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `animelist` (
  `user_id` int unsigned NOT NULL,
  `anime_id` int unsigned NOT NULL,
  `score` decimal(3,1) DEFAULT NULL,
  `status` enum('completed','watching','planned','stalled','dropped') NOT NULL DEFAULT 'watching',
  `progress` smallint unsigned NOT NULL DEFAULT '0',
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `notes` text,
  `rewatches` tinyint unsigned NOT NULL DEFAULT '0',
  `favorite` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`user_id`,`anime_id`),
  KEY `anime_id` (`anime_id`),
  CONSTRAINT `animelist_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `animelist_ibfk_2` FOREIGN KEY (`anime_id`) REFERENCES `anime` (`anime_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `animelist`
--

LOCK TABLES `animelist` WRITE;
/*!40000 ALTER TABLE `animelist` DISABLE KEYS */;
/*!40000 ALTER TABLE `animelist` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bookmark`
--

DROP TABLE IF EXISTS `bookmark`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `bookmark` (
  `post_id` bigint unsigned NOT NULL,
  `user_id` int unsigned NOT NULL,
  `date` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`post_id`,`user_id`),
  UNIQUE KEY `bookmark_unique` (`post_id`,`user_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `bookmark_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `post` (`post_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `bookmark_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bookmark`
--

LOCK TABLES `bookmark` WRITE;
/*!40000 ALTER TABLE `bookmark` DISABLE KEYS */;
/*!40000 ALTER TABLE `bookmark` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `character`
--

DROP TABLE IF EXISTS `character`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `character` (
  `character_id` int unsigned NOT NULL AUTO_INCREMENT,
  `family_name` varchar(50) DEFAULT NULL,
  `given_name` varchar(50) DEFAULT NULL,
  `alias` varchar(50) DEFAULT NULL,
  `japanese_name` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `biography` text,
  `picture` varchar(200) NOT NULL DEFAULT 'storage/sys/default_cover.png',
  `date` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`character_id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 ;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `character`
--

LOCK TABLES `character` WRITE;
/*!40000 ALTER TABLE `character` DISABLE KEYS */;
/*!40000 ALTER TABLE `character` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `character_anime`
--

DROP TABLE IF EXISTS `character_anime`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `character_anime` (
  `character_id` int unsigned NOT NULL,
  `anime_id` int unsigned NOT NULL,
  `role` enum('Main','Supporting') NOT NULL DEFAULT 'Supporting',
  PRIMARY KEY (`character_id`,`anime_id`),
  KEY `anime_id` (`anime_id`),
  CONSTRAINT `character_anime_ibfk_1` FOREIGN KEY (`character_id`) REFERENCES `character` (`character_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `character_anime_ibfk_2` FOREIGN KEY (`anime_id`) REFERENCES `anime` (`anime_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `character_anime`
--

LOCK TABLES `character_anime` WRITE;
/*!40000 ALTER TABLE `character_anime` DISABLE KEYS */;
/*!40000 ALTER TABLE `character_anime` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `character_manga`
--

DROP TABLE IF EXISTS `character_manga`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `character_manga` (
  `character_id` int unsigned NOT NULL,
  `manga_id` int unsigned NOT NULL,
  `role` enum('Main','Supporting') NOT NULL DEFAULT 'Supporting',
  PRIMARY KEY (`character_id`,`manga_id`),
  KEY `manga_id` (`manga_id`),
  CONSTRAINT `character_manga_ibfk_1` FOREIGN KEY (`character_id`) REFERENCES `character` (`character_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `character_manga_ibfk_2` FOREIGN KEY (`manga_id`) REFERENCES `manga` (`manga_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `character_manga`
--

LOCK TABLES `character_manga` WRITE;
/*!40000 ALTER TABLE `character_manga` DISABLE KEYS */;
/*!40000 ALTER TABLE `character_manga` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `character_vn`
--

DROP TABLE IF EXISTS `character_vn`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `character_vn` (
  `character_id` int unsigned NOT NULL,
  `vn_id` int unsigned NOT NULL,
  `role` enum('Main','Supporting') NOT NULL DEFAULT 'Supporting',
  PRIMARY KEY (`character_id`,`vn_id`),
  KEY `vn_id` (`vn_id`),
  CONSTRAINT `character_vn_ibfk_1` FOREIGN KEY (`character_id`) REFERENCES `character` (`character_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `character_vn_ibfk_2` FOREIGN KEY (`vn_id`) REFERENCES `vn` (`vn_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `character_vn`
--

LOCK TABLES `character_vn` WRITE;
/*!40000 ALTER TABLE `character_vn` DISABLE KEYS */;
/*!40000 ALTER TABLE `character_vn` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `edit_anime`
--

DROP TABLE IF EXISTS `edit_anime`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `edit_anime` (
  `edit_id` int unsigned NOT NULL AUTO_INCREMENT,
  `anime_id` int unsigned NOT NULL,
  `title` varchar(150) DEFAULT NULL,
  `english_title` varchar(150) DEFAULT NULL,
  `japanese_title` varchar(150) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `type` varchar(25) DEFAULT NULL,
  `episodes` smallint unsigned DEFAULT NULL,
  `status` varchar(25) DEFAULT NULL,
  `start_date` varchar(50) DEFAULT NULL,
  `end_date` varchar(50) DEFAULT NULL,
  `description` varchar(3000) DEFAULT NULL,
  `cover` varchar(400) DEFAULT NULL,
  `header` varchar(400) DEFAULT NULL,
  `user_id` int unsigned NOT NULL,
  `date` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`edit_id`,`anime_id`,`user_id`),
  KEY `anime_id` (`anime_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `edit_anime_ibfk_1` FOREIGN KEY (`anime_id`) REFERENCES `anime` (`anime_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `edit_anime_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `edit_anime`
--

LOCK TABLES `edit_anime` WRITE;
/*!40000 ALTER TABLE `edit_anime` DISABLE KEYS */;
/*!40000 ALTER TABLE `edit_anime` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `edit_manga`
--

DROP TABLE IF EXISTS `edit_manga`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `edit_manga` (
  `smid` int unsigned NOT NULL AUTO_INCREMENT,
  `manga_id` int unsigned NOT NULL,
  `title` varchar(150) DEFAULT NULL,
  `english_title` varchar(150) DEFAULT NULL,
  `japanese_title` varchar(150) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `format` varchar(25) DEFAULT NULL,
  `volumes` tinyint unsigned DEFAULT NULL,
  `chapters` smallint unsigned DEFAULT NULL,
  `status` varchar(25) DEFAULT NULL,
  `start_date` varchar(50) DEFAULT NULL,
  `end_date` varchar(50) DEFAULT NULL,
  `description` varchar(3000) DEFAULT NULL,
  `cover` varchar(400) DEFAULT NULL,
  `header` varchar(400) DEFAULT NULL,
  `user_id` int unsigned NOT NULL,
  `date` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`smid`),
  KEY `manga_id` (`manga_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `edit_manga_ibfk_1` FOREIGN KEY (`manga_id`) REFERENCES `manga` (`manga_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `edit_manga_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `edit_manga`
--

LOCK TABLES `edit_manga` WRITE;
/*!40000 ALTER TABLE `edit_manga` DISABLE KEYS */;
/*!40000 ALTER TABLE `edit_manga` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `edit_vn`
--

DROP TABLE IF EXISTS `edit_vn`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `edit_vn` (
  `svid` int unsigned NOT NULL AUTO_INCREMENT,
  `vn_id` int unsigned NOT NULL,
  `title` varchar(150) DEFAULT NULL,
  `english_title` varchar(150) DEFAULT NULL,
  `japanese_title` varchar(150) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `duration` varchar(30) DEFAULT NULL,
  `released` date DEFAULT NULL,
  `description` varchar(3000) DEFAULT NULL,
  `cover` varchar(300) DEFAULT NULL,
  `header` varchar(300) DEFAULT NULL,
  `user_id` int unsigned NOT NULL,
  `date` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`svid`),
  KEY `vn_id` (`vn_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `edit_vn_ibfk_1` FOREIGN KEY (`vn_id`) REFERENCES `vn` (`vn_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `edit_vn_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `edit_vn`
--

LOCK TABLES `edit_vn` WRITE;
/*!40000 ALTER TABLE `edit_vn` DISABLE KEYS */;
/*!40000 ALTER TABLE `edit_vn` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `follow`
--

DROP TABLE IF EXISTS `follow`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `follow` (
  `following_user` int unsigned NOT NULL,
  `followed_user` int unsigned NOT NULL,
  `date` datetime DEFAULT CURRENT_TIMESTAMP,
  KEY `following_user` (`following_user`),
  KEY `followed_user` (`followed_user`),
  CONSTRAINT `follow_ibfk_1` FOREIGN KEY (`following_user`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `follow_ibfk_2` FOREIGN KEY (`followed_user`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `follow`
--

LOCK TABLES `follow` WRITE;
/*!40000 ALTER TABLE `follow` DISABLE KEYS */;
/*!40000 ALTER TABLE `follow` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `manga`
--

DROP TABLE IF EXISTS `manga`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `manga` (
  `manga_id` int unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(150) NOT NULL,
  `english_title` varchar(150) DEFAULT NULL,
  `japanese_title` varchar(150) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `format` varchar(25) NOT NULL,
  `volumes` tinyint unsigned NOT NULL,
  `chapters` smallint unsigned NOT NULL,
  `status` varchar(25) NOT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `description` varchar(3000) NOT NULL,
  `cover` varchar(200) NOT NULL DEFAULT 'storage/sys/default_cover.png',
  `header` varchar(200) DEFAULT NULL,
  `date` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`manga_id`),
  UNIQUE KEY `title` (`title`),
  UNIQUE KEY `english_title` (`english_title`),
  UNIQUE KEY `japanese_title` (`japanese_title`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 ;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `manga`
--

LOCK TABLES `manga` WRITE;
/*!40000 ALTER TABLE `manga` DISABLE KEYS */;
/*!40000 ALTER TABLE `manga` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mangalist`
--

DROP TABLE IF EXISTS `mangalist`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `mangalist` (
  `user_id` int unsigned NOT NULL,
  `manga_id` int unsigned NOT NULL,
  `score` decimal(3,1) DEFAULT NULL,
  `status` enum('completed','reading','planned','stalled','dropped') NOT NULL DEFAULT 'reading',
  `progress` smallint unsigned NOT NULL DEFAULT '0',
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `notes` text,
  `rewatches` tinyint unsigned NOT NULL DEFAULT '0',
  `favorite` bit(1) NOT NULL DEFAULT b'0',
  KEY `user_id` (`user_id`),
  KEY `manga_id` (`manga_id`),
  CONSTRAINT `mangalist_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `mangalist_ibfk_2` FOREIGN KEY (`manga_id`) REFERENCES `manga` (`manga_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mangalist`
--

LOCK TABLES `mangalist` WRITE;
/*!40000 ALTER TABLE `mangalist` DISABLE KEYS */;
/*!40000 ALTER TABLE `mangalist` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `post`
--

DROP TABLE IF EXISTS `post`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `post` (
  `post_id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int unsigned NOT NULL,
  `content` varchar(350) NOT NULL,
  `date` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`post_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `post_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=176 DEFAULT CHARSET=utf8mb4 ;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `post`
--

LOCK TABLES `post` WRITE;
/*!40000 ALTER TABLE `post` DISABLE KEYS */;
/*!40000 ALTER TABLE `post` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `post_anime`
--

DROP TABLE IF EXISTS `post_anime`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `post_anime` (
  `post_id` bigint unsigned NOT NULL,
  `anime_id` int unsigned NOT NULL,
  PRIMARY KEY (`post_id`,`anime_id`),
  KEY `anime_id` (`anime_id`),
  CONSTRAINT `post_anime_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `post` (`post_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `post_anime_ibfk_2` FOREIGN KEY (`anime_id`) REFERENCES `anime` (`anime_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `post_anime`
--

LOCK TABLES `post_anime` WRITE;
/*!40000 ALTER TABLE `post_anime` DISABLE KEYS */;
/*!40000 ALTER TABLE `post_anime` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `post_like`
--

DROP TABLE IF EXISTS `post_like`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `post_like` (
  `post_id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int unsigned NOT NULL,
  `date` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`post_id`,`user_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `post_like_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=169 DEFAULT CHARSET=utf8mb4 ;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `post_like`
--

LOCK TABLES `post_like` WRITE;
/*!40000 ALTER TABLE `post_like` DISABLE KEYS */;
/*!40000 ALTER TABLE `post_like` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `post_manga`
--

DROP TABLE IF EXISTS `post_manga`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `post_manga` (
  `post_id` bigint unsigned NOT NULL,
  `manga_id` int unsigned NOT NULL,
  PRIMARY KEY (`post_id`,`manga_id`),
  KEY `manga_id` (`manga_id`),
  CONSTRAINT `post_manga_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `post` (`post_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `post_manga_ibfk_2` FOREIGN KEY (`manga_id`) REFERENCES `manga` (`manga_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `post_manga`
--

LOCK TABLES `post_manga` WRITE;
/*!40000 ALTER TABLE `post_manga` DISABLE KEYS */;
/*!40000 ALTER TABLE `post_manga` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `post_reply`
--

DROP TABLE IF EXISTS `post_reply`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `post_reply` (
  `post_id` bigint unsigned NOT NULL,
  `reply_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`post_id`,`reply_id`),
  KEY `reply_id` (`reply_id`),
  CONSTRAINT `post_reply_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `post` (`post_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `post_reply_ibfk_2` FOREIGN KEY (`reply_id`) REFERENCES `post` (`post_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `post_reply`
--

LOCK TABLES `post_reply` WRITE;
/*!40000 ALTER TABLE `post_reply` DISABLE KEYS */;
/*!40000 ALTER TABLE `post_reply` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `review`
--

DROP TABLE IF EXISTS `review`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `review` (
  `review_id` smallint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(50) DEFAULT NULL,
  `text` text NOT NULL,
  `user_id` int unsigned NOT NULL,
  `date` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`review_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `review_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 ;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `review`
--

LOCK TABLES `review` WRITE;
/*!40000 ALTER TABLE `review` DISABLE KEYS */;
/*!40000 ALTER TABLE `review` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `review_anime`
--

DROP TABLE IF EXISTS `review_anime`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `review_anime` (
  `review_id` smallint unsigned NOT NULL,
  `anime_id` int unsigned NOT NULL,
  PRIMARY KEY (`review_id`,`anime_id`),
  KEY `anime_id` (`anime_id`),
  CONSTRAINT `review_anime_ibfk_1` FOREIGN KEY (`review_id`) REFERENCES `review` (`review_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `review_anime_ibfk_2` FOREIGN KEY (`anime_id`) REFERENCES `anime` (`anime_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `review_anime`
--

LOCK TABLES `review_anime` WRITE;
/*!40000 ALTER TABLE `review_anime` DISABLE KEYS */;
/*!40000 ALTER TABLE `review_anime` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `review_manga`
--

DROP TABLE IF EXISTS `review_manga`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `review_manga` (
  `review_id` smallint unsigned NOT NULL,
  `manga_id` int unsigned NOT NULL,
  KEY `review_id` (`review_id`),
  KEY `manga_id` (`manga_id`),
  CONSTRAINT `review_manga_ibfk_1` FOREIGN KEY (`review_id`) REFERENCES `review` (`review_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `review_manga_ibfk_2` FOREIGN KEY (`manga_id`) REFERENCES `manga` (`manga_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `review_manga`
--

LOCK TABLES `review_manga` WRITE;
/*!40000 ALTER TABLE `review_manga` DISABLE KEYS */;
/*!40000 ALTER TABLE `review_manga` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `review_vn`
--

DROP TABLE IF EXISTS `review_vn`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `review_vn` (
  `review_id` smallint unsigned NOT NULL,
  `vn_id` int unsigned NOT NULL,
  `date` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`review_id`,`vn_id`),
  KEY `vn_id` (`vn_id`),
  CONSTRAINT `review_vn_ibfk_1` FOREIGN KEY (`review_id`) REFERENCES `review` (`review_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `review_vn_ibfk_2` FOREIGN KEY (`vn_id`) REFERENCES `vn` (`vn_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `review_vn`
--

LOCK TABLES `review_vn` WRITE;
/*!40000 ALTER TABLE `review_vn` DISABLE KEYS */;
/*!40000 ALTER TABLE `review_vn` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `review_vote`
--

DROP TABLE IF EXISTS `review_vote`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `review_vote` (
  `user_id` int unsigned NOT NULL,
  `review_id` smallint unsigned NOT NULL,
  `vote` bit(1) NOT NULL DEFAULT b'0',
  `date` datetime DEFAULT CURRENT_TIMESTAMP,
  UNIQUE KEY `review_vote` (`user_id`,`review_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `review_vote`
--

LOCK TABLES `review_vote` WRITE;
/*!40000 ALTER TABLE `review_vote` DISABLE KEYS */;
/*!40000 ALTER TABLE `review_vote` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `staff`
--

DROP TABLE IF EXISTS `staff`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `staff` (
  `staff_id` int unsigned NOT NULL AUTO_INCREMENT,
  `family_name` varchar(50) DEFAULT NULL,
  `given_name` varchar(50) DEFAULT NULL,
  `alias` varchar(50) DEFAULT NULL,
  `japanese_name` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `biography` text,
  `picture` varchar(200) NOT NULL DEFAULT 'storage/sys/default_cover.png',
  `date` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`staff_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 ;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `staff`
--

LOCK TABLES `staff` WRITE;
/*!40000 ALTER TABLE `staff` DISABLE KEYS */;
/*!40000 ALTER TABLE `staff` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `staff_anime`
--

DROP TABLE IF EXISTS `staff_anime`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `staff_anime` (
  `staff_id` int unsigned NOT NULL,
  `anime_id` int unsigned NOT NULL,
  `role` varchar(50) NOT NULL DEFAULT 'Participant',
  PRIMARY KEY (`staff_id`,`anime_id`),
  KEY `anime_id` (`anime_id`),
  CONSTRAINT `staff_anime_ibfk_1` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`staff_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `staff_anime_ibfk_2` FOREIGN KEY (`anime_id`) REFERENCES `anime` (`anime_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `staff_anime`
--

LOCK TABLES `staff_anime` WRITE;
/*!40000 ALTER TABLE `staff_anime` DISABLE KEYS */;
/*!40000 ALTER TABLE `staff_anime` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `staff_manga`
--

DROP TABLE IF EXISTS `staff_manga`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `staff_manga` (
  `staff_id` int unsigned NOT NULL,
  `manga_id` int unsigned NOT NULL,
  `role` varchar(50) NOT NULL DEFAULT 'Participant',
  PRIMARY KEY (`staff_id`,`manga_id`),
  KEY `manga_id` (`manga_id`),
  CONSTRAINT `staff_manga_ibfk_1` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`staff_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `staff_manga_ibfk_2` FOREIGN KEY (`manga_id`) REFERENCES `manga` (`manga_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `staff_manga`
--

LOCK TABLES `staff_manga` WRITE;
/*!40000 ALTER TABLE `staff_manga` DISABLE KEYS */;
/*!40000 ALTER TABLE `staff_manga` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `staff_vn`
--

DROP TABLE IF EXISTS `staff_vn`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `staff_vn` (
  `staff_id` int unsigned NOT NULL,
  `vn_id` int unsigned NOT NULL,
  `role` varchar(50) NOT NULL DEFAULT 'Participant',
  PRIMARY KEY (`staff_id`,`vn_id`),
  KEY `vn_id` (`vn_id`),
  CONSTRAINT `staff_vn_ibfk_1` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`staff_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `staff_vn_ibfk_2` FOREIGN KEY (`vn_id`) REFERENCES `vn` (`vn_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `staff_vn`
--

LOCK TABLES `staff_vn` WRITE;
/*!40000 ALTER TABLE `staff_vn` DISABLE KEYS */;
/*!40000 ALTER TABLE `staff_vn` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `submit_anime`
--

DROP TABLE IF EXISTS `submit_anime`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `submit_anime` (
  `said` int unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(150) DEFAULT NULL,
  `english_title` varchar(150) DEFAULT NULL,
  `japanese_title` varchar(150) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `type` varchar(25) DEFAULT NULL,
  `episodes` smallint unsigned DEFAULT NULL,
  `status` varchar(25) DEFAULT NULL,
  `start_date` varchar(50) DEFAULT NULL,
  `end_date` varchar(50) DEFAULT NULL,
  `description` varchar(3000) DEFAULT NULL,
  `cover` varchar(400) DEFAULT NULL,
  `header` varchar(400) DEFAULT NULL,
  `user_id` int unsigned NOT NULL,
  `date` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`said`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `submit_anime_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 ;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `submit_anime`
--

LOCK TABLES `submit_anime` WRITE;
/*!40000 ALTER TABLE `submit_anime` DISABLE KEYS */;
/*!40000 ALTER TABLE `submit_anime` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `submit_character`
--

DROP TABLE IF EXISTS `submit_character`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `submit_character` (
  `scid` int unsigned NOT NULL AUTO_INCREMENT,
  `family_name` varchar(50) DEFAULT NULL,
  `given_name` varchar(50) DEFAULT NULL,
  `alias` varchar(200) DEFAULT NULL,
  `japanese_name` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `biography` text,
  `picture` varchar(200) NOT NULL DEFAULT 'storage/sys/default_cover.png',
  `user_id` int unsigned NOT NULL,
  `date` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`scid`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `submit_character_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 ;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `submit_character`
--

LOCK TABLES `submit_character` WRITE;
/*!40000 ALTER TABLE `submit_character` DISABLE KEYS */;
/*!40000 ALTER TABLE `submit_character` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `submit_manga`
--

DROP TABLE IF EXISTS `submit_manga`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `submit_manga` (
  `smid` int unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(150) DEFAULT NULL,
  `english_title` varchar(150) DEFAULT NULL,
  `japanese_title` varchar(150) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `format` varchar(25) DEFAULT NULL,
  `volumes` tinyint unsigned DEFAULT NULL,
  `chapters` smallint unsigned DEFAULT NULL,
  `status` varchar(25) DEFAULT NULL,
  `start_date` varchar(50) DEFAULT NULL,
  `end_date` varchar(50) DEFAULT NULL,
  `description` varchar(3000) DEFAULT NULL,
  `cover` varchar(400) DEFAULT NULL,
  `header` varchar(400) DEFAULT NULL,
  `user_id` int unsigned NOT NULL,
  `date` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`smid`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `submit_manga_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 ;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `submit_manga`
--

LOCK TABLES `submit_manga` WRITE;
/*!40000 ALTER TABLE `submit_manga` DISABLE KEYS */;
/*!40000 ALTER TABLE `submit_manga` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `submit_staff`
--

DROP TABLE IF EXISTS `submit_staff`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `submit_staff` (
  `ssid` int unsigned NOT NULL AUTO_INCREMENT,
  `family_name` varchar(50) DEFAULT NULL,
  `given_name` varchar(50) DEFAULT NULL,
  `alias` varchar(200) DEFAULT NULL,
  `japanese_name` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `biography` text,
  `picture` varchar(200) NOT NULL DEFAULT 'storage/sys/default_cover.png',
  `user_id` int unsigned NOT NULL,
  `date` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ssid`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `submit_staff_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 ;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `submit_staff`
--

LOCK TABLES `submit_staff` WRITE;
/*!40000 ALTER TABLE `submit_staff` DISABLE KEYS */;
/*!40000 ALTER TABLE `submit_staff` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `submit_vn`
--

DROP TABLE IF EXISTS `submit_vn`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `submit_vn` (
  `svid` int unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(150) DEFAULT NULL,
  `english_title` varchar(150) DEFAULT NULL,
  `japanese_title` varchar(150) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `duration` varchar(30) DEFAULT NULL,
  `released` date DEFAULT NULL,
  `description` varchar(3000) DEFAULT NULL,
  `cover` varchar(300) DEFAULT NULL,
  `header` varchar(300) DEFAULT NULL,
  `user_id` int unsigned NOT NULL,
  `date` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`svid`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `submit_vn_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 ;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `submit_vn`
--

LOCK TABLES `submit_vn` WRITE;
/*!40000 ALTER TABLE `submit_vn` DISABLE KEYS */;
/*!40000 ALTER TABLE `submit_vn` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user` (
  `user_id` int unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(16) NOT NULL,
  `password` varchar(60) NOT NULL,
  `email` varchar(319) NOT NULL,
  `joined_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `country` varchar(56) DEFAULT NULL,
  `biography` varchar(4000) DEFAULT NULL,
  `born` date DEFAULT NULL,
  `pfp` varchar(250) NOT NULL DEFAULT '/storage/sys/default.webp',
  `header` varchar(250) DEFAULT NULL,
  `twitter` varchar(15) DEFAULT NULL,
  `github` varchar(39) DEFAULT NULL,
  `discord` varchar(39) DEFAULT NULL,
  `website` varchar(200) DEFAULT NULL,
  `shares` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `twitter` (`twitter`),
  UNIQUE KEY `discord` (`discord`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 ;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vn`
--

DROP TABLE IF EXISTS `vn`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `vn` (
  `vn_id` int unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(150) NOT NULL,
  `english_title` varchar(150) DEFAULT NULL,
  `japanese_title` varchar(150) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `duration` int unsigned DEFAULT NULL,
  `released` date DEFAULT NULL,
  `description` varchar(3000) NOT NULL,
  `cover` varchar(200) NOT NULL DEFAULT 'storage/sys/default_cover.png',
  `header` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`vn_id`),
  UNIQUE KEY `title` (`title`),
  UNIQUE KEY `english_title` (`english_title`),
  UNIQUE KEY `japanese_title` (`japanese_title`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 ;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vn`
--

LOCK TABLES `vn` WRITE;
/*!40000 ALTER TABLE `vn` DISABLE KEYS */;
/*!40000 ALTER TABLE `vn` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-05-31 11:27:19