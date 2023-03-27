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
    `pfp` VARCHAR(250) NOT NULL DEFAULT 'storage/sys/default.png',
    `header` VARCHAR(250),
    `twitter` varchar(15),
    `github` varchar(39),
    `discord` varchar(39),
    `website` varchar(200),
    PRIMARY KEY(`user_id`)
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
    `members` INT UNSIGNED NOT NULL DEFAULT 0,
    `favorited` INT UNSIGNED NOT NULL DEFAULT 0,
    `cover` VARCHAR(200) NOT NULL DEFAULT 'storage/sys/default_cover.png',
    `header` VARCHAR(200) NULL DEFAULT NULL,
    PRIMARY KEY(`anime_id`)
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
     `members` INT UNSIGNED NOT NULL DEFAULT 0,
     `favorited` INT UNSIGNED NOT NULL DEFAULT 0,
     `cover` VARCHAR(200) NOT NULL DEFAULT 'storage/sys/default_cover.png',
     `header` VARCHAR(200) NULL DEFAULT NULL,
     PRIMARY KEY(`manga_id`)
) AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;

CREATE TABLE `vn` (
    `vn_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `title` VARCHAR(150) NOT NULL UNIQUE,
    `english_title` VARCHAR(150) UNIQUE,
    `japanese_title` NVARCHAR(150) UNIQUE,
    `duration` INT UNSIGNED, -- This stores minutes -
    `released` DATE,
    `description` VARCHAR(3000) NOT NULL,
    `members` INT UNSIGNED NOT NULL DEFAULT 0,
    `favorited` INT UNSIGNED NOT NULL DEFAULT 0,
    `cover` VARCHAR(200) NOT NULL DEFAULT 'storage/sys/default_cover.png',
    `header` VARCHAR(200) NULL DEFAULT NULL,
    PRIMARY KEY(`vn_id`)
) AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;

CREATE TABLE `character` (
    `character_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `family_name` VARCHAR(50),
    `given_name` VARCHAR(50),
    `alias` VARCHAR(50),
    `japanese_name` NVARCHAR(50),
    `data` JSON,
    `picture` VARCHAR(200) NOT NULL DEFAULT 'storage/sys/default_cover.png',
    PRIMARY KEY (`character_id`)
) AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;

CREATE TABLE `character_anime` (
    `character_id` INT UNSIGNED NOT NULL,
    `anime_id` INT UNSIGNED NOT NULL,
    `role` ENUM('Main', 'Supporting') NOT NULL DEFAULT 'Supporting',
    PRIMARY KEY(`character_id`, `anime_id`),
    FOREIGN KEY (`character_id`) REFERENCES `character`(`character_id`) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (`anime_id`) REFERENCES `anime`(`anime_id`) ON DELETE CASCADE ON UPDATE CASCADE
) AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;

CREATE TABLE `character_manga` (
    `character_id` INT UNSIGNED NOT NULL,
    `manga_id` INT UNSIGNED NOT NULL,
    `role` ENUM('Main', 'Supporting') NOT NULL DEFAULT 'Supporting',
    PRIMARY KEY(`character_id`, `manga_id`),
    FOREIGN KEY (`character_id`) REFERENCES `character`(`character_id`) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (`manga_id`) REFERENCES `manga`(`manga_id`) ON DELETE CASCADE ON UPDATE CASCADE
) AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;

CREATE TABLE `character_vn` (
    `character_id` INT UNSIGNED NOT NULL,
    `vn_id` INT UNSIGNED NOT NULL,
    `role` ENUM('Main', 'Supporting') NOT NULL DEFAULT 'Supporting',
    PRIMARY KEY(`character_id`, `vn_id`),
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
     `picture` VARCHAR(200) NOT NULL DEFAULT 'storage/sys/default_cover.png',
     PRIMARY KEY (`staff_id`)
) AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;

CREATE TABLE `staff_anime` (
    `staff_id` INT UNSIGNED NOT NULL,
    `anime_id` INT UNSIGNED NOT NULL,
    `role` VARCHAR(50) NOT NULL DEFAULT 'Participant',
    PRIMARY KEY(`staff_id`, `anime_id`),
    FOREIGN KEY (`staff_id`) REFERENCES `staff`(`staff_id`) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (`anime_id`) REFERENCES `anime`(`anime_id`) ON DELETE CASCADE ON UPDATE CASCADE
) AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;

CREATE TABLE `staff_manga` (
    `staff_id` INT UNSIGNED NOT NULL,
    `manga_id` INT UNSIGNED NOT NULL,
    `role` VARCHAR(50) NOT NULL DEFAULT 'Participant',
    PRIMARY KEY(`staff_id`, `manga_id`),
    FOREIGN KEY (`staff_id`) REFERENCES `staff`(`staff_id`) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (`manga_id`) REFERENCES `manga`(`manga_id`) ON DELETE CASCADE ON UPDATE CASCADE
) AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;

CREATE TABLE `staff_vn` (
    `staff_id` INT UNSIGNED NOT NULL,
    `vn_id` INT UNSIGNED NOT NULL,
    `role` VARCHAR(50) NOT NULL DEFAULT 'Participant',
    PRIMARY KEY(`staff_id`, `vn_id`),
    FOREIGN KEY (`staff_id`) REFERENCES `staff`(`staff_id`) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (`vn_id`) REFERENCES `vn`(`vn_id`) ON DELETE CASCADE ON UPDATE CASCADE
) AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;

CREATE TABLE `review` (
    `review_id` SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `title` VARCHAR(50),
    `text` TEXT NOT NULL,
    `user_id` INT UNSIGNED NOT NULL,
    `date` DATETIME DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY(`review_id`),
    FOREIGN KEY (`user_id`) REFERENCES `user`(`user_id`) ON UPDATE CASCADE
) AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;

CREATE TABLE `review_anime` (
    `review_id` SMALLINT UNSIGNED NOT NULL,
    `anime_id` INT UNSIGNED NOT NULL,
    `date` DATETIME DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`review_id`, `anime_id`),
    FOREIGN KEY (`review_id`) REFERENCES `review`(`review_id`) ON UPDATE CASCADE ON DELETE CASCADE,
    FOREIGN KEY (`anime_id`) REFERENCES `anime`(`anime_id`) ON UPDATE CASCADE ON DELETE CASCADE
) AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;

CREATE TABLE `review_manga` (
    `review_id` SMALLINT UNSIGNED NOT NULL,
    `manga_id` INT UNSIGNED NOT NULL,
    `date` DATETIME DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`review_id`, `manga_id`),
    FOREIGN KEY (`review_id`) REFERENCES `review`(`review_id`) ON UPDATE CASCADE ON DELETE CASCADE,
    FOREIGN KEY (`manga_id`) REFERENCES `manga`(`manga_id`) ON UPDATE CASCADE ON DELETE CASCADE
) AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;

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
    PRIMARY KEY(`svid`),
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
    PRIMARY KEY(`said`),
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
     PRIMARY KEY(`svid`),
     FOREIGN KEY (`user_id`) REFERENCES `user`(`user_id`) ON UPDATE CASCADE ON DELETE CASCADE
) AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;

CREATE TABLE `submit_character` (
    `scid` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `family_name` VARCHAR(50),
    `given_name` VARCHAR(50),
    `alias` VARCHAR(200),
    `japanese_name` NVARCHAR(50),
    `biography` text,
    `picture` VARCHAR(200) NOT NULL DEFAULT 'storage/sys/default_cover.png',
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
    `picture` VARCHAR(200) NOT NULL DEFAULT 'storage/sys/default_cover.png',
    `user_id` INT UNSIGNED NOT NULL,
    `date` DATETIME DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`ssid`),
    FOREIGN KEY (`user_id`) REFERENCES `user`(`user_id`) ON UPDATE CASCADE ON DELETE CASCADE
) AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;

CREATE TABLE animelist (
    `user_id` INT UNSIGNED NOT NULL,
    `anime_id` INT UNSIGNED NOT NULL,
    `score` DECIMAL(3,1),
    `comment` VARCHAR(200),
    `progress` SMALLINT UNSIGNED DEFAULT 0,
    `favorite` BIT(1) NOT NULL DEFAULT 0,
    PRIMARY KEY(`user_id`, `anime_id`),
    FOREIGN KEY (`user_id`) REFERENCES `user`(`user_id`) ON UPDATE CASCADE ON DELETE CASCADE,
    FOREIGN KEY (`anime_id`) REFERENCES `anime`(`anime_id`) ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;

CREATE TABLE mangalist (
    `user_id` INT UNSIGNED NOT NULL,
    `manga_id` INT UNSIGNED NOT NULL,
    `score` DECIMAL(3,1),
    `comment` VARCHAR(200),
    `progress` SMALLINT UNSIGNED DEFAULT 0,
    `favorite` BIT(1) NOT NULL DEFAULT 0,
    PRIMARY KEY(`user_id`, `manga_id`),
    FOREIGN KEY (`user_id`) REFERENCES `user`(`user_id`) ON UPDATE CASCADE ON DELETE CASCADE,
    FOREIGN KEY (`manga_id`) REFERENCES `manga`(`manga_id`) ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;

-- data -

insert into `anime` values(null, 'Gintama', null, null, 'TV', 49, 'finished', '2011-04-04', '2012-03-26', 'spring 2011', 'After a one-year hiatus, Shinpachi Shimura returns to Edo, only to stumble upon a shocking surprise: Gintoki and Kagura, his fellow Yorozuya members, have become completely different characters! Fleeing from the Yorozuya headquarters in confusion, Shinpachi finds that all the denizens of Edo have undergone impossibly extreme changes, in both appearance and personality. Most unbelievably, his sister Otae has married the Shinsengumi chief and shameless stalker Isao Kondou and is pregnant with their first child.', 0, 0, 'storage/img/gintama.webp', 'storage/img/gintama_header.jpg');
insert into `manga` values (null, 'Oyasumi Punpun', null, null, 'manga', '13', '144', 'finished', '2007-03-15', '2013-11-02', 'Punpun Onodera is a normal 11-year-old boy living in Japan. Hopelessly idealistic and romantic, Punpun begins to see his life take a subtle—though nonetheless startling—turn to the adult when he meets the new girl in his class, Aiko Tanaka. It is then that the quiet boy learns just how fickle maintaining a relationship can be, and the surmounting difficulties of transitioning from a naïve boyhood to a convoluted adulthood. When his father assaults his mother one night, Punpun realizes another thing: those whom he looked up to were not as impressive as he once thought.', 0, 0, 'storage/img/punpun.jpg', 'storage/img/punpun_header.png');
insert into `character` values(null, 'Sakata', 'Gintoki', null,  null,  null, 'storage/public/character/gintoki.jpg');
insert into `character_anime` values(1,1, 'Main');
insert into `staff` values(null, 'Sorachi', 'Hideaki', null, null, null, 'storage/public/staff/Sorachi-Hideaki.jpg');
insert into `staff_anime` VALUES (1,1, 'director');
insert into `review` values (null, 'title', 'This is my review', 1, default);
insert into `review_anime` VALUES (1,1, default);
insert into animelist values (3, 4, 8.5, 'Example comment', 10,  TRUE);

COMMIT;