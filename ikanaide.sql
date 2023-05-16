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
  `season` varchar(30) NOT NULL,
  `description` varchar(3000) NOT NULL,
  `cover` varchar(200) NOT NULL DEFAULT 'storage/sys/default_cover.png',
  `header` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`anime_id`),
  UNIQUE KEY `title` (`title`),
  UNIQUE KEY `english_title` (`english_title`),
  UNIQUE KEY `japanese_title` (`japanese_title`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `anime`
--

LOCK TABLES `anime` WRITE;
/*!40000 ALTER TABLE `anime` DISABLE KEYS */;
INSERT INTO `anime` VALUES (1,'Gintama',NULL,NULL,'TV',49,'finished','2011-04-04','2012-03-26','spring 2011','After a one-year hiatus, Shinpachi Shimura returns to Edo, only to stumble upon a shocking surprise: Gintoki and Kagura, his fellow Yorozuya members, have become completely different characters! Fleeing from the Yorozuya headquarters in confusion, Shinpachi finds that all the denizens of Edo have undergone impossibly extreme changes, in both appearance and personality. Most unbelievably, his sister Otae has married the Shinsengumi chief and shameless stalker Isao Kondou and is pregnant with their first child.','/storage/img/gintama.webp','/storage/img/gintama_header.jpg'),(2,'86',NULL,NULL,'TV',24,'finished',NULL,NULL,'sprint 2020','This is a description','/storage/img/gintama.webp',NULL),(3,'Hyouka',NULL,NULL,'TV',24,'finished',NULL,NULL,'sprint 2020','This is a description','/storage/img/gintama.webp',NULL),(4,'Kara no Kyoukai Movie 5: Mujun Rasen',NULL,NULL,'TV',24,'finished',NULL,NULL,'sprint 2020','This is a description','/storage/img/gintama.webp',NULL),(5,'Clannad: After Story',NULL,NULL,'TV',24,'finished',NULL,NULL,'sprint 2020','This is a description','/storage/img/gintama.webp',NULL),(6,'Bocchi the Rock!',NULL,NULL,'TV',24,'finished',NULL,NULL,'sprint 2020','This is a description','/storage/img/gintama.webp',NULL),(7,'Fate Zero 2nd Season',NULL,NULL,'TV',24,'finished',NULL,NULL,'sprint 2020','This is a description','/storage/img/gintama.webp',NULL),(8,'Violet Evergarden',NULL,NULL,'TV',24,'finished',NULL,NULL,'sprint 2020','This is a description','/storage/img/gintama.webp',NULL),(9,'Evangelion: 3.0+1.0 Thrice Upon a Time',NULL,NULL,'TV',24,'finished',NULL,NULL,'sprint 2020','This is a description','/storage/img/gintama.webp',NULL),(10,'Kimetsu no Yaiba Katanakaji no Sato hen',NULL,NULL,'TV',24,'finished',NULL,NULL,'sprint 2020','This is a description','/storage/img/gintama.webp',NULL);
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `animelist`
--

LOCK TABLES `animelist` WRITE;
/*!40000 ALTER TABLE `animelist` DISABLE KEYS */;
INSERT INTO `animelist` VALUES (2,3,NULL,'watching',9,NULL,NULL,NULL,0,_binary '\0'),(2,5,10.0,'completed',0,NULL,NULL,'',1,_binary '\0'),(3,1,4.0,'completed',49,NULL,NULL,'',0,_binary ''),(3,2,9.0,'completed',24,NULL,NULL,'',0,_binary ''),(3,3,7.0,'watching',24,NULL,NULL,'',0,_binary ''),(3,4,9.0,'planned',0,NULL,NULL,'',0,_binary '\0'),(3,5,1.0,'watching',2,NULL,NULL,'',0,_binary ''),(3,6,6.0,'watching',3,NULL,NULL,'',0,_binary ''),(3,7,2.0,'watching',4,NULL,NULL,'',0,_binary '\0'),(3,8,8.0,'watching',3,NULL,NULL,'',0,_binary '\0'),(3,9,2.0,'watching',4,NULL,NULL,'',0,_binary '\0'),(3,10,2.0,'watching',1,NULL,NULL,'',0,_binary '\0'),(9,1,5.0,'watching',0,NULL,NULL,'',0,_binary '\0'),(10,1,5.0,'completed',0,NULL,NULL,'',0,_binary '\0'),(10,10,NULL,'watching',0,NULL,NULL,NULL,0,_binary '\0'),(11,1,NULL,'watching',0,NULL,NULL,NULL,0,_binary '\0'),(14,1,NULL,'completed',49,NULL,NULL,'asdfadfas',0,_binary '\0');
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
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
  `data` json DEFAULT NULL,
  `picture` varchar(200) NOT NULL DEFAULT 'storage/sys/default_cover.png',
  PRIMARY KEY (`character_id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `character`
--

LOCK TABLES `character` WRITE;
/*!40000 ALTER TABLE `character` DISABLE KEYS */;
INSERT INTO `character` VALUES (1,'Sakata','Gintoki',NULL,NULL,NULL,'/storage/public/character/gintoki.jpg'),(2,'Sakataa','Gintoki',NULL,NULL,NULL,'/storage/public/character/gintoki.jpg'),(3,'Sakataaa','Gintoki',NULL,NULL,NULL,'/storage/public/character/gintoki.jpg'),(4,'Sakataaaa','Gintoki',NULL,NULL,NULL,'/storage/public/character/gintoki.jpg'),(5,'Sakataaaaa','Gintoki',NULL,NULL,NULL,'/storage/public/character/gintoki.jpg'),(6,'Sakataaaaaa','Gintoki',NULL,NULL,NULL,'/storage/public/character/gintoki.jpg'),(7,'Onodera','Punpun',NULL,NULL,NULL,'/storage/public/character/punpun.jpg'),(8,'Onodera','Punpun',NULL,NULL,NULL,'/storage/public/character/gintoki.jpg'),(9,'Furukawa','Nagisa',NULL,NULL,NULL,'/storage/animes/clannad/char/char.jpg'),(10,'Eru','Chitanda',NULL,NULL,NULL,'/storage/animes/hyouka/char/char.jpg'),(11,'Hitori','Gotou',NULL,NULL,NULL,'/storage/animes/btr/char/char.jpg'),(12,'Kiritsugu','Emiya',NULL,NULL,NULL,'/storage/animes/fate/char/char.jpg'),(13,'Violet','Evergarden',NULL,NULL,NULL,'/storage/animes/violet/char/char.jpg'),(14,'Shiki','Ryougi',NULL,NULL,NULL,'/storage/animes/kara/char/char.jpg'),(15,'Shinji','Ikari',NULL,NULL,NULL,'/storage/animes/eva/char/char.jpg'),(16,'Shinei','Nouzen',NULL,NULL,NULL,'/storage/animes/86/char/char.jpg');
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `character_anime`
--

LOCK TABLES `character_anime` WRITE;
/*!40000 ALTER TABLE `character_anime` DISABLE KEYS */;
INSERT INTO `character_anime` VALUES (1,1,'Main'),(2,1,'Supporting'),(3,1,'Supporting'),(4,1,'Supporting'),(5,1,'Supporting'),(6,1,'Supporting'),(9,5,'Main'),(10,3,'Main'),(11,6,'Main'),(12,7,'Main'),(13,8,'Main'),(14,4,'Main'),(15,9,'Main'),(16,2,'Main');
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `character_manga`
--

LOCK TABLES `character_manga` WRITE;
/*!40000 ALTER TABLE `character_manga` DISABLE KEYS */;
INSERT INTO `character_manga` VALUES (7,1,'Supporting');
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `follow`
--

LOCK TABLES `follow` WRITE;
/*!40000 ALTER TABLE `follow` DISABLE KEYS */;
INSERT INTO `follow` VALUES (3,2,'2023-05-04 22:06:16'),(3,1,'2023-05-06 19:17:57'),(3,11,'2023-05-06 22:22:41');
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
  PRIMARY KEY (`manga_id`),
  UNIQUE KEY `title` (`title`),
  UNIQUE KEY `english_title` (`english_title`),
  UNIQUE KEY `japanese_title` (`japanese_title`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `manga`
--

LOCK TABLES `manga` WRITE;
/*!40000 ALTER TABLE `manga` DISABLE KEYS */;
INSERT INTO `manga` VALUES (1,'Oyasumi Punpun',NULL,NULL,'manga',13,144,'finished','2007-03-15','2013-11-02','Punpun Onodera is a normal 11-year-old boy living in Japan. Hopelessly idealistic and romantic, Punpun begins to see his life take a subtle—though nonetheless startling—turn to the adult when he meets the new girl in his class, Aiko Tanaka. It is then that the quiet boy learns just how fickle maintaining a relationship can be, and the surmounting difficulties of transitioning from a naïve boyhood to a convoluted adulthood. When his father assaults his mother one night, Punpun realizes another thing: those whom he looked up to were not as impressive as he once thought.','/storage/img/punpun.jpg','/storage/img/punpun_header.png');
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mangalist`
--

LOCK TABLES `mangalist` WRITE;
/*!40000 ALTER TABLE `mangalist` DISABLE KEYS */;
INSERT INTO `mangalist` VALUES (10,1,NULL,'reading',0,NULL,NULL,NULL,0,_binary '\0'),(3,1,6.0,'reading',138,NULL,NULL,'',0,_binary '');
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
) ENGINE=InnoDB AUTO_INCREMENT=145 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `post`
--

LOCK TABLES `post` WRITE;
/*!40000 ALTER TABLE `post` DISABLE KEYS */;
INSERT INTO `post` VALUES (96,11,'my first post','2023-05-06 19:32:07'),(97,11,'responding to his first post','2023-05-06 19:32:15'),(98,2,'post','2023-05-06 19:48:09'),(99,2,'asdasd','2023-05-06 22:22:02'),(100,2,'safasf','2023-05-06 22:22:03'),(101,2,'dsaf','2023-05-06 22:22:04'),(102,2,'adsf','2023-05-06 22:22:06'),(103,2,'asdf','2023-05-06 22:22:08'),(104,2,'adsfadf','2023-05-06 22:22:09'),(105,2,'afdadsf','2023-05-06 22:22:11'),(106,11,'asdfsdf','2023-05-06 22:22:25'),(107,11,'asdfasdf','2023-05-06 22:22:27'),(108,11,'das','2023-05-06 22:22:28'),(109,3,'yeah','2023-05-06 22:45:16'),(110,3,'reref','2023-05-06 22:47:53'),(111,2,'sumthing','2023-05-07 10:43:25'),(112,2,'sumthign 2','2023-05-07 10:44:00'),(113,3,'I have watched episode 11 from 86.','2023-05-07 10:50:45'),(114,3,'nvm','2023-05-08 19:41:01'),(115,3,'I have watched episode 12 from 86.','2023-05-08 19:48:45'),(116,3,'I have watched episode 13 from 86.','2023-05-08 19:48:53'),(117,3,'I have watched episode 14 from 86.','2023-05-08 19:49:00'),(118,3,'I have watched episode 1 from Hyouka.','2023-05-08 19:49:01'),(119,3,'I have watched episode 1 from Clannad: After Story.','2023-05-08 19:49:02'),(120,3,'I have watched episode 2 from Hyouka.','2023-05-08 19:49:02'),(121,3,'I have watched episode 1 from Fate Zero 2nd Season.','2023-05-08 19:49:04'),(122,3,'I have watched episode 1 from Bocchi the Rock!.','2023-05-08 19:49:04'),(123,3,'I have watched episode 2 from Bocchi the Rock!.','2023-05-08 19:49:04'),(124,3,'I have watched episode 1 from Violet Evergarden.','2023-05-08 19:49:05'),(125,3,'I have watched episode 1 from Evangelion: 3.0+1.0 Thrice Upon a Time.','2023-05-08 19:49:05'),(126,3,'I have watched episode 2 from Violet Evergarden.','2023-05-08 19:49:06'),(127,3,'I have watched episode 2 from Fate Zero 2nd Season.','2023-05-08 19:49:06'),(128,3,'I have watched episode 3 from Violet Evergarden.','2023-05-08 19:49:06'),(129,3,'I have watched episode 2 from Evangelion: 3.0+1.0 Thrice Upon a Time.','2023-05-08 19:49:07'),(130,3,'I have watched episode 1 from Kimetsu no Yaiba Katanakaji no Sato hen.','2023-05-08 19:49:07'),(131,3,'asd','2023-05-08 20:58:53'),(132,3,'I have watched episode 3 from Evangelion: 3.0+1.0 Thrice Upon a Time.','2023-05-09 16:13:09'),(133,3,'I have watched episode 3 from Fate Zero 2nd Season.','2023-05-09 22:08:49'),(134,3,'I have watched episode 4 from Fate Zero 2nd Season.','2023-05-09 22:08:52'),(135,3,'me too','2023-05-09 22:08:59'),(136,3,'ejemplo','2023-05-10 19:44:40'),(137,3,'ejemplo 2','2023-05-10 19:44:49'),(138,3,'responder','2023-05-10 19:44:57'),(139,3,'I have watched episode 3 from Bocchi the Rock!.','2023-05-10 19:45:20'),(141,3,'sadfasdf','2023-05-11 19:33:52'),(142,3,'I have watched episode 4 from Evangelion: 3.0+1.0 Thrice Upon a Time.','2023-05-12 16:41:39'),(143,3,'dafasf','2023-05-14 11:38:19'),(144,3,'I have watched episode 2 from Clannad: After Story.','2023-05-14 11:49:19');
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `post_anime`
--

LOCK TABLES `post_anime` WRITE;
/*!40000 ALTER TABLE `post_anime` DISABLE KEYS */;
INSERT INTO `post_anime` VALUES (137,1),(138,1),(116,2),(117,2),(118,3),(120,3),(119,5),(144,5),(122,6),(123,6),(139,6),(141,6),(98,7),(121,7),(127,7),(133,7),(134,7),(135,7),(124,8),(126,8),(128,8),(96,9),(97,9),(110,9),(111,9),(125,9),(129,9),(131,9),(132,9),(142,9),(130,10);
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
) ENGINE=InnoDB AUTO_INCREMENT=145 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `post_like`
--

LOCK TABLES `post_like` WRITE;
/*!40000 ALTER TABLE `post_like` DISABLE KEYS */;
INSERT INTO `post_like` VALUES (90,3,'2023-05-06 19:18:50'),(96,11,'2023-05-06 19:32:16'),(97,3,'2023-05-06 22:47:59'),(105,3,'2023-05-06 22:45:25'),(137,3,'2023-05-10 19:45:00'),(139,3,'2023-05-11 21:31:15'),(144,3,'2023-05-15 14:28:00');
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `post_manga`
--

LOCK TABLES `post_manga` WRITE;
/*!40000 ALTER TABLE `post_manga` DISABLE KEYS */;
INSERT INTO `post_manga` VALUES (143,1);
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `post_reply`
--

LOCK TABLES `post_reply` WRITE;
/*!40000 ALTER TABLE `post_reply` DISABLE KEYS */;
INSERT INTO `post_reply` VALUES (96,97),(105,109),(97,110),(113,114),(129,131),(134,135),(137,138);
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
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `review`
--

LOCK TABLES `review` WRITE;
/*!40000 ALTER TABLE `review` DISABLE KEYS */;
INSERT INTO `review` VALUES (17,'review 1','review 1',3,'2023-04-18 11:16:34'),(18,'review 2','review 2',3,'2023-04-18 11:16:46'),(19,'review 3','review 3',3,'2023-04-18 11:16:58'),(20,'review 4','review 4',3,'2023-04-18 11:17:11'),(21,'Watch Oyasumi Punpun','This show was amazing. It caught me in for its entirety, and left me with many thoughts that have lived up inside me since then.',3,'2023-05-03 21:45:44');
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `review_anime`
--

LOCK TABLES `review_anime` WRITE;
/*!40000 ALTER TABLE `review_anime` DISABLE KEYS */;
INSERT INTO `review_anime` VALUES (17,1),(19,2);
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `review_manga`
--

LOCK TABLES `review_manga` WRITE;
/*!40000 ALTER TABLE `review_manga` DISABLE KEYS */;
INSERT INTO `review_manga` VALUES (18,1),(20,1),(21,1);
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `review_vn`
--

LOCK TABLES `review_vn` WRITE;
/*!40000 ALTER TABLE `review_vn` DISABLE KEYS */;
/*!40000 ALTER TABLE `review_vn` ENABLE KEYS */;
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
  `data` json DEFAULT NULL,
  `picture` varchar(200) NOT NULL DEFAULT 'storage/sys/default_cover.png',
  PRIMARY KEY (`staff_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `staff`
--

LOCK TABLES `staff` WRITE;
/*!40000 ALTER TABLE `staff` DISABLE KEYS */;
INSERT INTO `staff` VALUES (1,'Sorachi','Hideaki',NULL,NULL,NULL,'/storage/public/staff/Sorachi-Hideaki.jpg'),(2,'Sorachii','Hideaki',NULL,NULL,NULL,'/storage/public/staff/Sorachi-Hideaki.jpg'),(3,'Sorachiii','Hideaki',NULL,NULL,NULL,'/storage/public/staff/Sorachi-Hideaki.jpg'),(4,'Inio','Asano',NULL,NULL,NULL,'/storage/public/staff/asano.jpg');
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `staff_anime`
--

LOCK TABLES `staff_anime` WRITE;
/*!40000 ALTER TABLE `staff_anime` DISABLE KEYS */;
INSERT INTO `staff_anime` VALUES (1,1,'director'),(2,1,'director'),(3,1,'director');
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `staff_manga`
--

LOCK TABLES `staff_manga` WRITE;
/*!40000 ALTER TABLE `staff_manga` DISABLE KEYS */;
INSERT INTO `staff_manga` VALUES (4,1,'creator');
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `submit_anime`
--

LOCK TABLES `submit_anime` WRITE;
/*!40000 ALTER TABLE `submit_anime` DISABLE KEYS */;
INSERT INTO `submit_anime` VALUES (1,'anime','anime','qanime','',5,'anime','animea','anime','aaa','a','a.com',1,'2023-03-19 00:06:27'),(2,'','','','',0,'','','','','','',1,'2023-03-26 18:59:51'),(3,'','','','',0,'','','','','','',3,'2023-03-26 19:01:00');
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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `submit_character`
--

LOCK TABLES `submit_character` WRITE;
/*!40000 ALTER TABLE `submit_character` DISABLE KEYS */;
INSERT INTO `submit_character` VALUES (1,'a','b','c','d','e','fg',1,'2023-03-19 00:20:02');
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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `submit_manga`
--

LOCK TABLES `submit_manga` WRITE;
/*!40000 ALTER TABLE `submit_manga` DISABLE KEYS */;
INSERT INTO `submit_manga` VALUES (1,'manga','manga','manga','no',20,45,'23','22','23','A','2','3',1,'2023-03-19 00:12:38');
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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `submit_staff`
--

LOCK TABLES `submit_staff` WRITE;
/*!40000 ALTER TABLE `submit_staff` DISABLE KEYS */;
INSERT INTO `submit_staff` VALUES (1,'asd','asd','asd','asd','asd','asd',1,'2023-03-19 00:20:51'),(2,'asd','asd','asd','asd','asd','asd',1,'2023-03-19 00:20:55'),(3,'asd','asd','sad','asd','sad','asd',1,'2023-03-19 00:21:13'),(4,'asd','asd','asd','asd','asd','asd',1,'2023-03-19 00:21:22'),(5,'asd','asd','asd','asd','asd','asd',1,'2023-03-19 00:21:43'),(6,'asd','asd','asd','asd','asd','asd',1,'2023-03-19 00:21:49');
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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `submit_vn`
--

LOCK TABLES `submit_vn` WRITE;
/*!40000 ALTER TABLE `submit_vn` DISABLE KEYS */;
INSERT INTO `submit_vn` VALUES (1,'asd','asd','asd',NULL,NULL,NULL,'asd','asd',1,'2023-03-19 00:19:09');
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
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'nagisa','pw','pw@pw.pw',NULL,'spain','This is my biography',NULL,'/storage/sys/default.webp',NULL,NULL,NULL,NULL,NULL,_binary ''),(2,'adrian','$2y$10$Pniup4nd5x8zTyBra24KK.F74rtN.mZYUjI8XOuBw1..JH4QhgqRa','adrian@adrian.com','2023-03-24 00:02:56',NULL,NULL,NULL,'/storage/sys/default.webp',NULL,NULL,NULL,NULL,NULL,_binary ''),(3,'nabuna','$2y$10$OyqjtE7YqLop57qmtOu4b.QYpMl6ssf9NfQXoa1Tefco1x8oG/r7e','nabuna@proton.me','2023-03-24 00:05:44','Spain','Spring. After the death of his father - a world-famous artist - left him without any living relatives, protagonist Kusanagi Naoya is put under the care of his friend Natsume Keis family. There, his homeroom teacher Natsume Ai, and Keis younger sister - the actress Natsume Shizuku - await him in turn. And with the arrival of the new school term, Misakura Rin - Naoyas childhood friend who transferred long ago - reappears right bfore him.','2000-07-30','/storage/img/pfp.jpg','/storage/img/sakuta_header.jpg','nabuna','nabuna','nabuna#9841',NULL,_binary ''),(4,'naoya','$2y$10$ppSeq3KKM2FP1G2CZocpy.jAszGJ98zJvZrjjJkfTtomMFN5NFBV2','naoya@naoya.com','2023-03-24 00:37:32',NULL,NULL,NULL,'storage/sys/default.webp',NULL,NULL,NULL,NULL,NULL,_binary ''),(5,'watch','$2y$10$7yXU4nbXIhOQTEfLictPCuEqKjtDSv1GfAKC9Hzc5zHV9oZskALxW','seiko@seiko.com','2023-03-26 20:00:06',NULL,NULL,NULL,'storage/sys/default.webp',NULL,NULL,NULL,NULL,NULL,_binary ''),(6,'five','$2y$10$DD9/HQOIEykf3cI0OPtfZeAjvvaI87iX5/il8CYn4hHSilJB/o6QW','d@d.com','2023-03-28 19:45:44',NULL,NULL,NULL,'storage/img/default.webp',NULL,NULL,NULL,NULL,NULL,_binary ''),(7,'six','$2y$10$9D2qAlII9YnhiTVVuvinDuPZkTpiXeDSZVDiTBVwsP0oImPTla4Dy','six@six.six','2023-03-28 19:48:41',NULL,NULL,NULL,'storage/sys/default.webp',NULL,NULL,NULL,NULL,NULL,_binary ''),(8,'seven','$2y$10$4QvgXO.fOAYnYHOpHQsG9u9v82QawBVFc2CVojdHXXBZ0z86yqpna','s@d.c','2023-03-28 21:03:39',NULL,NULL,NULL,'storage/sys/default.webp',NULL,NULL,NULL,NULL,NULL,_binary ''),(9,'nabuna2','$2y$10$KpzrpYvVlI/DlzrybaHlaufqPCX6gbbCqnXZogafXB1alNTqkpSIe','s@s.c','2023-03-30 22:53:20',NULL,NULL,NULL,'/storage/sys/default.png',NULL,NULL,NULL,NULL,NULL,_binary ''),(10,'nabuna3','$2y$10$PhdhgO9yd69zUM22D6vyE./0QkIQ1jxg45SiyEURIB8GL2sdBdWW.','nabuna3@nabuna.es','2023-03-30 22:55:42',NULL,NULL,NULL,'/storage/sys/default.webp',NULL,NULL,NULL,NULL,NULL,_binary ''),(11,'usuario','$2y$10$6KuUg1uzUNPDMbYT9.p0V.sBPng4LPP8nmuLYgFjIupYzHIMhi1SS','usuario@usuario.usuario','2023-04-04 21:26:52',NULL,NULL,NULL,'/storage/sys/default.webp',NULL,NULL,NULL,NULL,NULL,_binary ''),(12,'usuario2','$2y$10$8xea2jhEWVAFZTDF3EgoGOEKKkC74LqoRIRqkeA7CA.oERJlh2HcG','usuario2@usuario2.usuario2','2023-04-04 21:29:43',NULL,NULL,NULL,'/storage/sys/default.webp',NULL,NULL,NULL,NULL,NULL,_binary ''),(13,'teSto','$2y$10$qQ.GJ/aWHenAJImPLJcS8.ATZlIDYOQQIuIi9w3Bj/Dgx.XfCMYv6','a@a.c','2023-04-06 03:35:06',NULL,NULL,NULL,'/storage/sys/default.webp',NULL,NULL,NULL,NULL,NULL,_binary ''),(14,'test4','$2y$10$pDwWgeTMG0REyD.qdziO..0oMqBP8WrCaBM/UL.qxnqRMXYkMu6lO','test@test.c','2023-04-18 12:07:48',NULL,NULL,NULL,'/storage/sys/default.webp',NULL,NULL,NULL,NULL,NULL,_binary '');
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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vn`
--

LOCK TABLES `vn` WRITE;
/*!40000 ALTER TABLE `vn` DISABLE KEYS */;
INSERT INTO `vn` VALUES (1,'Sakura no Uta',NULL,NULL,3000,'2015-10-23','Naoya Kusanagi lost his mother when he was a child. Naoyas father who is a famous artist is the only person that can help him cope with the loss of his friend, Rin Misakura who move while they were in elementary school. Later, Naoyas father died. After the funeral ends, Naoya is taken into the custody of Keis family in exchange for cooking meals at their home. 6 years later, Rin is transferred to Naoyas class.','storage/img/sakuta.jpeg','storage/img/sakuta_header.jpg');
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

-- Dump completed on 2023-05-16 23:50:33
