SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

CREATE DATABASE ikanaide;
USE ikanaide;

-- tables -

CREATE TABLE `user` (
    `user_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `username` VARCHAR(16) NOT NULL UNIQUE,
    `password` VARCHAR(60) NOT NULL,
    `email` VARCHAR(319) NOT NULL UNIQUE,
    `joined_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `country` varchar(56),
    `biography` VARCHAR(4000),
    `born` DATE,
    `pfp` VARCHAR(250) NOT NULL DEFAULT '/storage/sys/default.webp',
    `header` VARCHAR(250),
    `twitter` varchar(15),
    `github` varchar(39),
    `discord` varchar(39),
    `website` varchar(200),
    PRIMARY KEY (`user_id`)
) AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;

CREATE TABLE `anime` (
    `anime_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `title` VARCHAR(150) NOT NULL UNIQUE,
    `english_title` VARCHAR(150) UNIQUE,
    `japanese_title` NVARCHAR(150) UNIQUE,
    `type` VARCHAR(25) NOT NULL,
    `episodes` SMALLINT UNSIGNED NOT NULL,
    `status` VARCHAR(25) NOT NULL,
    `start_date` DATE,
    `end_date` DATE,
    `season` VARCHAR(30) NOT NULL,
    `description` VARCHAR(3000) NOT NULL,
    `cover` VARCHAR(200) NOT NULL DEFAULT '/storage/sys/default_cover.png',
    `header` VARCHAR(200) NULL DEFAULT NULL,
    PRIMARY KEY (`anime_id`)
) AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;

CREATE TABLE `manga` (
     `manga_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
     `title` VARCHAR(150) NOT NULL UNIQUE,
     `english_title` VARCHAR(150) UNIQUE,
     `japanese_title` NVARCHAR(150) UNIQUE,
     `format` VARCHAR(25) NOT NULL,
     `volumes` TINYINT UNSIGNED NOT NULL,
     `chapters` SMALLINT UNSIGNED NOT NULL,
     `status` VARCHAR(25) NOT NULL,
     `start_date` DATE,
     `end_date` DATE,
     `description` VARCHAR(3000) NOT NULL,
     `cover` VARCHAR(200) NOT NULL DEFAULT '/storage/sys/default_cover.png',
     `header` VARCHAR(200) NULL DEFAULT NULL,
     PRIMARY KEY (`manga_id`)
) AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;

CREATE TABLE `vn` (
    `vn_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `title` VARCHAR(150) NOT NULL UNIQUE,
    `english_title` VARCHAR(150) UNIQUE,
    `japanese_title` NVARCHAR(150) UNIQUE,
    `duration` INT UNSIGNED, -- This stores minutes -
    `released` DATE,
    `description` VARCHAR(3000) NOT NULL,
    `cover` VARCHAR(200) NOT NULL DEFAULT 'storage/sys/default_cover.png',
    `header` VARCHAR(200) NULL DEFAULT NULL,
    PRIMARY KEY (`vn_id`)
) AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;

CREATE TABLE `character` (
    `character_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `family_name` VARCHAR(50),
    `given_name` VARCHAR(50),
    `alias` VARCHAR(50),
    `japanese_name` NVARCHAR(50),
    `data` JSON,
    `picture` VARCHAR(200) NOT NULL DEFAULT '/storage/sys/default_cover.png',
    PRIMARY KEY (`character_id`)
) AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;

CREATE TABLE `character_anime` (
    `character_id` INT UNSIGNED NOT NULL,
    `anime_id` INT UNSIGNED NOT NULL,
    `role` ENUM('Main', 'Supporting') NOT NULL DEFAULT 'Supporting',
    PRIMARY KEY (`character_id`, `anime_id`),
    FOREIGN KEY (`character_id`) REFERENCES `character`(`character_id`) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (`anime_id`) REFERENCES `anime`(`anime_id`) ON DELETE CASCADE ON UPDATE CASCADE
) AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;

CREATE TABLE `character_manga` (
    `character_id` INT UNSIGNED NOT NULL,
    `manga_id` INT UNSIGNED NOT NULL,
    `role` ENUM('Main', 'Supporting') NOT NULL DEFAULT 'Supporting',
    PRIMARY KEY (`character_id`, `manga_id`),
    FOREIGN KEY (`character_id`) REFERENCES `character`(`character_id`) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (`manga_id`) REFERENCES `manga`(`manga_id`) ON DELETE CASCADE ON UPDATE CASCADE
) AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;

CREATE TABLE `character_vn` (
    `character_id` INT UNSIGNED NOT NULL,
    `vn_id` INT UNSIGNED NOT NULL,
    `role` ENUM('Main', 'Supporting') NOT NULL DEFAULT 'Supporting',
    PRIMARY KEY (`character_id`, `vn_id`),
    FOREIGN KEY (`character_id`) REFERENCES `character`(`character_id`) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (`vn_id`) REFERENCES `vn`(`vn_id`) ON DELETE CASCADE ON UPDATE CASCADE
) AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;

CREATE TABLE `staff` (
     `staff_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
     `family_name` VARCHAR(50) NULL DEFAULT NULL,
     `given_name` VARCHAR(50) NULL DEFAULT NULL,
     `alias` VARCHAR(50) NULL DEFAULT NULL,
     `japanese_name` NVARCHAR(50),
     `data` JSON,
     `picture` VARCHAR(200) NOT NULL DEFAULT '/storage/sys/default_cover.png',
     PRIMARY KEY (`staff_id`)
) AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;

CREATE TABLE `staff_anime` (
    `staff_id` INT UNSIGNED NOT NULL,
    `anime_id` INT UNSIGNED NOT NULL,
    `role` VARCHAR(50) NOT NULL DEFAULT 'Participant',
    PRIMARY KEY (`staff_id`, `anime_id`),
    FOREIGN KEY (`staff_id`) REFERENCES `staff`(`staff_id`) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (`anime_id`) REFERENCES `anime`(`anime_id`) ON DELETE CASCADE ON UPDATE CASCADE
) AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;

CREATE TABLE `staff_manga` (
    `staff_id` INT UNSIGNED NOT NULL,
    `manga_id` INT UNSIGNED NOT NULL,
    `role` VARCHAR(50) NOT NULL DEFAULT 'Participant',
    PRIMARY KEY (`staff_id`, `manga_id`),
    FOREIGN KEY (`staff_id`) REFERENCES `staff`(`staff_id`) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (`manga_id`) REFERENCES `manga`(`manga_id`) ON DELETE CASCADE ON UPDATE CASCADE
) AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;

CREATE TABLE `staff_vn` (
    `staff_id` INT UNSIGNED NOT NULL,
    `vn_id` INT UNSIGNED NOT NULL,
    `role` VARCHAR(50) NOT NULL DEFAULT 'Participant',
    PRIMARY KEY (`staff_id`, `vn_id`),
    FOREIGN KEY (`staff_id`) REFERENCES `staff`(`staff_id`) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (`vn_id`) REFERENCES `vn`(`vn_id`) ON DELETE CASCADE ON UPDATE CASCADE
) AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;

CREATE TABLE `review` (
    `review_id` SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `title` VARCHAR(50),
    `text` TEXT NOT NULL,
    `user_id` INT UNSIGNED NOT NULL,
    `date` DATETIME DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`review_id`),
    FOREIGN KEY (`user_id`) REFERENCES `user`(`user_id`) ON UPDATE CASCADE
) AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;

CREATE TABLE `review_anime` (
    `review_id` SMALLINT UNSIGNED NOT NULL,
    `anime_id` INT UNSIGNED NOT NULL,
    PRIMARY KEY (`review_id`, `anime_id`),
    FOREIGN KEY (`review_id`) REFERENCES `review`(`review_id`) ON UPDATE CASCADE ON DELETE CASCADE,
    FOREIGN KEY (`anime_id`) REFERENCES `anime`(`anime_id`) ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE `review_manga` (
    `review_id` SMALLINT UNSIGNED NOT NULL,
    `manga_id` INT UNSIGNED NOT NULL,
    PRIMARY KEY (`review_id`, `manga_id`),
    FOREIGN KEY (`review_id`) REFERENCES `review`(`review_id`) ON UPDATE CASCADE ON DELETE CASCADE,
    FOREIGN KEY (`manga_id`) REFERENCES `manga`(`manga_id`) ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE `review_vn` (
    `review_id` SMALLINT UNSIGNED NOT NULL,
    `vn_id` INT UNSIGNED NOT NULL,
    `date` DATETIME DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`review_id`, `vn_id`),
    FOREIGN KEY (`review_id`) REFERENCES `review`(`review_id`) ON UPDATE CASCADE ON DELETE CASCADE,
    FOREIGN KEY (`vn_id`) REFERENCES `vn`(`vn_id`) ON UPDATE CASCADE ON DELETE CASCADE
) AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;

CREATE TABLE `edit_anime` (
    `edit_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `anime_id` INT UNSIGNED NOT NULL,
    `title` VARCHAR(150),
    `english_title` VARCHAR(150),
    `japanese_title` NVARCHAR(150),
    `type` VARCHAR(25),
    `episodes` SMALLINT UNSIGNED,
    `status` VARCHAR(25),
    `start_date` VARCHAR(50),
    `end_date` VARCHAR(50),
    `description` VARCHAR(3000),
    `cover` VARCHAR(400),
    `header` VARCHAR(400),
    `user_id` INT UNSIGNED NOT NULL,
    `date` DATETIME DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`edit_id`, `anime_id`, `user_id`),
    FOREIGN KEY (`anime_id`) REFERENCES `anime`(`anime_id`) ON UPDATE CASCADE ON DELETE CASCADE,
    FOREIGN KEY (`user_id`) REFERENCES `user`(`user_id`) ON UPDATE CASCADE ON DELETE CASCADE
) AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;

CREATE TABLE `edit_manga` (
    `smid` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `manga_id` INT UNSIGNED NOT NULL,
    `title` VARCHAR(150),
    `english_title` VARCHAR(150),
    `japanese_title` NVARCHAR(150),
    `format` VARCHAR(25),
    `volumes` TINYINT UNSIGNED,
    `chapters` SMALLINT UNSIGNED,
    `status` VARCHAR(25),
    `start_date` VARCHAR(50),
    `end_date` VARCHAR(50),
    `description` VARCHAR(3000),
    `cover` VARCHAR(400),
    `header` VARCHAR(400),
    `user_id` INT UNSIGNED NOT NULL,
    `date` DATETIME DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`smid`),
    FOREIGN KEY (`manga_id`) REFERENCES `manga`(`manga_id`) ON UPDATE CASCADE ON DELETE CASCADE,
    FOREIGN KEY (`user_id`) REFERENCES `user`(`user_id`) ON UPDATE CASCADE ON DELETE CASCADE
) AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;

CREATE TABLE `edit_vn` (
    `svid` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `vn_id` INT UNSIGNED NOT NULL,
    `title` VARCHAR(150),
    `english_title` VARCHAR(150),
    `japanese_title` NVARCHAR(150),
    `duration` VARCHAR(30),
    `released` DATE,
    `description` VARCHAR(3000),
    `cover` VARCHAR(300),
    `header` VARCHAR(300),
    `user_id` INT UNSIGNED NOT NULL,
    `date` DATETIME DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`svid`),
    FOREIGN KEY (`vn_id`) REFERENCES `vn`(`vn_id`) ON UPDATE CASCADE ON DELETE CASCADE,
    FOREIGN KEY (`user_id`) REFERENCES `user`(`user_id`) ON UPDATE CASCADE ON DELETE CASCADE
) AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;

CREATE TABLE `submit_anime` (
    `said` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `title` VARCHAR(150),
    `english_title` VARCHAR(150),
    `japanese_title` NVARCHAR(150),
    `type` VARCHAR(25),
    `episodes` SMALLINT UNSIGNED,
    `status` VARCHAR(25),
    `start_date` VARCHAR(50),
    `end_date` VARCHAR(50),
    `description` VARCHAR(3000),
    `cover` VARCHAR(400),
    `header` VARCHAR(400),
    `user_id` INT UNSIGNED NOT NULL,
    `date` DATETIME DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`said`),
    FOREIGN KEY (`user_id`) REFERENCES `user`(`user_id`) ON UPDATE CASCADE ON DELETE CASCADE
) AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;

CREATE TABLE `submit_manga` (
    `smid` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `title` VARCHAR(150),
    `english_title` VARCHAR(150),
    `japanese_title` NVARCHAR(150),
    `format` VARCHAR(25),
    `volumes` TINYINT UNSIGNED,
    `chapters` SMALLINT UNSIGNED,
    `status` VARCHAR(25),
    `start_date` VARCHAR(50),
    `end_date` VARCHAR(50),
    `description` VARCHAR(3000),
    `cover` VARCHAR(400),
    `header` VARCHAR(400),
    `user_id` INT UNSIGNED NOT NULL,
    `date` DATETIME DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`smid`),
    FOREIGN KEY (`user_id`) REFERENCES `user`(`user_id`) ON UPDATE CASCADE ON DELETE CASCADE
) AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;

CREATE TABLE `submit_vn` (
     `svid` INT UNSIGNED NOT NULL AUTO_INCREMENT,
     `title` VARCHAR(150),
     `english_title` VARCHAR(150),
     `japanese_title` NVARCHAR(150),
     `duration` VARCHAR(30),
     `released` DATE,
     `description` VARCHAR(3000),
     `cover` VARCHAR(300),
     `header` VARCHAR(300),
     `user_id` INT UNSIGNED NOT NULL,
     `date` DATETIME DEFAULT CURRENT_TIMESTAMP,
     PRIMARY KEY (`svid`),
     FOREIGN KEY (`user_id`) REFERENCES `user`(`user_id`) ON UPDATE CASCADE ON DELETE CASCADE
) AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;

CREATE TABLE `submit_character` (
    `scid` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `family_name` VARCHAR(50),
    `given_name` VARCHAR(50),
    `alias` VARCHAR(200),
    `japanese_name` NVARCHAR(50),
    `biography` text,
    `picture` VARCHAR(200) NOT NULL DEFAULT '/storage/sys/default_cover.png',
    `user_id` INT UNSIGNED NOT NULL,
    `date` DATETIME DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`scid`),
    FOREIGN KEY (`user_id`) REFERENCES `user`(`user_id`) ON UPDATE CASCADE ON DELETE CASCADE
) AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;

CREATE TABLE `submit_staff` (
    `ssid` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `family_name` VARCHAR(50) NULL DEFAULT NULL,
    `given_name` VARCHAR(50) NULL DEFAULT NULL,
    `alias` VARCHAR(200) NULL DEFAULT NULL,
    `japanese_name` NVARCHAR(50),
    `biography` text,
    `picture` VARCHAR(200) NOT NULL DEFAULT '/storage/sys/default_cover.png',
    `user_id` INT UNSIGNED NOT NULL,
    `date` DATETIME DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`ssid`),
    FOREIGN KEY (`user_id`) REFERENCES `user`(`user_id`) ON UPDATE CASCADE ON DELETE CASCADE
) AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;

CREATE TABLE animelist (
    `user_id` INT UNSIGNED NOT NULL,
    `anime_id` INT UNSIGNED NOT NULL,
    `score` DECIMAL(3,1),
    `status` ENUM('completed', 'watching', 'planned', 'stalled', 'dropped') NOT NULL DEFAULT 'watching',
    `progress` SMALLINT UNSIGNED NOT NULL DEFAULT 0,
    `start_date` DATE,
    `end_date` DATE,
    `notes` text,
    `rewatches` TINYINT UNSIGNED NOT NULL DEFAULT 0,
    `favorite` BIT(1) NOT NULL DEFAULT 0,
    PRIMARY KEY (`user_id`, `anime_id`),
    FOREIGN KEY (`user_id`) REFERENCES `user`(`user_id`) ON UPDATE CASCADE ON DELETE CASCADE,
    FOREIGN KEY (`anime_id`) REFERENCES `anime`(`anime_id`) ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;

CREATE TABLE mangalist (
    `user_id` INT UNSIGNED NOT NULL,
    `manga_id` INT UNSIGNED NOT NULL,
    `score` DECIMAL(3,1),
    `status` ENUM('completed', 'reading', 'planned', 'stalled', 'dropped') NOT NULL DEFAULT 'reading',
    `progress` SMALLINT UNSIGNED NOT NULL DEFAULT 0,
    `start_date` DATE,
    `end_date` DATE,
    `notes` text,
    `rewatches` TINYINT UNSIGNED NOT NULL DEFAULT 0,
    `favorite` BIT(1) NOT NULL DEFAULT 0,
    FOREIGN KEY (`user_id`) REFERENCES `user`(`user_id`) ON UPDATE CASCADE ON DELETE CASCADE,
    FOREIGN KEY (`manga_id`) REFERENCES `manga`(`manga_id`) ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;

CREATE TABLE post (
    `post_id` BIGINT UNSIGNED NOT NULL,
    `user_id` INT UNSIGNED NOT NULL,
    `content` VARCHAR(350) NOT NULL,
    `date` DATETIME DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`post_id`),
    FOREIGN KEY (`user_id`) REFERENCES `user`(`user_id`) ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;

CREATE TABLE post_reply (
    `post_id` BIGINT UNSIGNED NOT NULL,
    `user_id` INT UNSIGNED NOT NULL,
    `content` VARCHAR(350) NOT NULL,
    PRIMARY KEY (`post_id`, `user_id`),
    FOREIGN KEY (`user_id`) REFERENCES `user`(`user_id`) ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;

CREATE TABLE post_like (
    `post_id` BIGINT UNSIGNED NOT NULL,
    `user_id` INT UNSIGNED NOT NULL,
    `date` DATETIME DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`post_id`, `user_id`),
    FOREIGN KEY (`user_id`) REFERENCES `user`(`user_id`) ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;

COMMIT;