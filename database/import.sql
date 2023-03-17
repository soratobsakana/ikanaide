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
    `pfp` VARCHAR(250) NOT NULL DEFAULT 'storage/img/default/default.png',
    data JSON,
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
);

CREATE TABLE `character_manga` (
   `character_id` INT UNSIGNED NOT NULL,
   `manga_id` INT UNSIGNED NOT NULL,
   `role` ENUM('Main', 'Supporting') NOT NULL DEFAULT 'Supporting',
   PRIMARY KEY(`character_id`, `manga_id`),
   FOREIGN KEY (`character_id`) REFERENCES `character`(`character_id`) ON DELETE CASCADE ON UPDATE CASCADE,
   FOREIGN KEY (`manga_id`) REFERENCES `manga`(`manga_id`) ON DELETE CASCADE ON UPDATE CASCADE
);

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
);

CREATE TABLE `staff_manga` (
   `staff_id` INT UNSIGNED NOT NULL,
   `manga_id` INT UNSIGNED NOT NULL,
   `role` VARCHAR(50) NOT NULL DEFAULT 'Participant',
   PRIMARY KEY(`staff_id`, `manga_id`),
   FOREIGN KEY (`staff_id`) REFERENCES `staff`(`staff_id`) ON DELETE CASCADE ON UPDATE CASCADE,
   FOREIGN KEY (`manga_id`) REFERENCES `manga`(`manga_id`) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE `review` (
    `review_id` SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `title` VARCHAR(50),
    `text` TEXT NOT NULL,
    `user_id` INT UNSIGNED NOT NULL,
    PRIMARY KEY(`review_id`),
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
    PRIMARY KEY (`edit_id`),
    FOREIGN KEY (`anime_id`) REFERENCES `anime`(`anime_id`) ON UPDATE CASCADE
) AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;

-- data -

insert into `user` values (null, 'nagisa', 'pw', 'pw@pw.pw', null, 'spain', 'This is my biography', default, null);
insert into anime values(null, 'Gintama', null, null, 'TV', 49, 'finished', '2011-04-04', '2012-03-26', 'spring 2011', 'After a one-year hiatus, Shinpachi Shimura returns to Edo, only to stumble upon a shocking surprise: Gintoki and Kagura, his fellow Yorozuya members, have become completely different characters! Fleeing from the Yorozuya headquarters in confusion, Shinpachi finds that all the denizens of Edo have undergone impossibly extreme changes, in both appearance and personality. Most unbelievably, his sister Otae has married the Shinsengumi chief and shameless stalker Isao Kondou and is pregnant with their first child.', 0, 0, 'storage/img/gintama.webp', 'storage/img/gintama_header.webp');
insert into `character` values(null, 'Sakata', 'Gintoki', null,  null,  null, 'storage/public/character/gintoki.jpg');
insert into `character_anime` values(1,1, 'Main');
insert into `staff` values(null, 'Sorachi', 'Hideaki', null, null, null, 'storage/public/staff/Sorachi-Hideaki.jpg');
insert into `staff_anime` VALUES (1,1, 'director');
insert into `review` values (null, 'title', 'This is my review', 1);
insert into `review_anime` VALUES (1,1);

COMMIT;