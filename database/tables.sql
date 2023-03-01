DROP TABLE `anime`;
DROP TABLE `character`;
DROP TABLE `character_anime`;
DROP TABLE `review`;
DROP TABLE `review_anime`;
DROP TABLE `staff`;
DROP TABLE `user`;

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

insert into `user` values (null, 'nagisa', 'pw', 'pw@pw.pw', null, 'spain', 'This is my biography', default, null);

-- `members` and `favorited` will both be added 1 each time anyone clicks their respective buttons -
-- them both will be stored here just as a way to quickly display the number on it's anime page. user property will be treated in JSON -
-- start and end dates can be null, though it's needed for the PHP to show N/A to the user if that happens-
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

insert into anime values(
null, 'Gintama', null, null, 'TV', 49, 'finished', '2011-04-04', '2012-03-26', 'spring 2011', 'After a one-year hiatus, Shinpachi Shimura returns to Edo, only to stumble upon a shocking surprise: Gintoki and Kagura, his fellow Yorozuya members, have become completely different characters! Fleeing from the Yorozuya headquarters in confusion, Shinpachi finds that all the denizens of Edo have undergone impossibly extreme changes, in both appearance and personality. Most unbelievably, his sister Otae has married the Shinsengumi chief and shameless stalker Isao Kondou and is pregnant with their first child.', 0, 0, 'storage/img/gintama.webp', 'storage/img/gintama_header.webp');
insert into anime values(
null, 'Gintadma', null, null, 'TV', 49, 'finished', '2011-04-04', '2012-03-26', 'spring 2011', 'After a one-year hiatus, Shinpachi Shimura returns to Edo, only to stumble upon a shocking surprise: Gintoki and Kagura, his fellow Yorozuya members, have become completely different characters! Fleeing from the Yorozuya headquarters in confusion, Shinpachi finds that all the denizens of Edo have undergone impossibly extreme changes, in both appearance and personality. Most unbelievably, his sister Otae has married the Shinsengumi chief and shameless stalker Isao Kondou and is pregnant with their first child.', 0, 0, 'storage/img/gintamda.webp', 'storage/idmg/gintama_header.webp');
select * from anime;

update anime set `header` = 'storage/img/gintama_header.jpg' where anime_id=1;


CREATE TABLE `manga` (
    `manga_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `title` VARCHAR(150) NOT NULL UNIQUE,
    `english_title` VARCHAR(150) UNIQUE,
    `japanese_title` NVARCHAR(150) COLLATE Japanese_CI_AS_KS_WS UNIQUE,
    `type` VARCHAR(25) NOT NULL,
    `episodes` INT NOT NULL,
    `status` VARCHAR(25) NOT NULL,
    `start_date` DATE NOT NULL DEFAULT 'N/A',
    `end_date` DATE NOT NULL DEFAULT 'N/A',
    `season` VARCHAR(30) NOT NULL,
    `description` VARCHAR(3000) NOT NULL,
    `members` INT UNSIGNED NOT NULL DEFAULT 0,
    `favorited` INT UNSIGNED NOT NULL DEFAULT 0,
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

show columns from `character`;
alter table `character` auto_increment = 2;
select * from `character`;

insert into `character` values
(null, 'Sakata', 'Gintoki', null,  null,  null, 'storage/public/character/gintoki.jpg');



select * from `character`;

CREATE TABLE `character_anime` (
    `character_id` INT UNSIGNED NOT NULL,
    `anime_id` INT UNSIGNED NOT NULL,
    `role` ENUM('Main', 'Supporting') NOT NULL DEFAULT 'Supporting',
    PRIMARY KEY(`character_id`, `anime_id`),
    FOREIGN KEY (`character_id`) REFERENCES `character`(`character_id`) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (`anime_id`) REFERENCES `anime`(`anime_id`) ON DELETE CASCADE ON UPDATE CASCADE
);

insert into `character_anime` values(1,1, 'Main');

select `character`.* from `character`, `character_anime` where `character_anime`.`anime_id` = 1 AND `character`.`character_id`=`character_anime`.character_id;

select * from character_anime;

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

insert into staff values
(null, 'Sorachi', 'Hideaki', null, null, null, 'storage/public/staff/Sorachi-Hideaki.jpg');

select * from staff;

-- Roles should be ENUM() but I'm not too sure about which ones yet, so I'll leave it at varchar -
-- Will take most of them from here https://www.kanzenshuu.com/animation-production/positions-and-roles/ -
CREATE TABLE `staff_anime` (
    `staff_id` INT UNSIGNED NOT NULL,
    `anime_id` INT UNSIGNED NOT NULL,
    `role` VARCHAR(50) NOT NULL DEFAULT 'Participant',
    PRIMARY KEY(`staff_id`, `anime_id`),
    FOREIGN KEY (`staff_id`) REFERENCES `staff`(`staff_id`) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (`anime_id`) REFERENCES `anime`(`anime_id`) ON DELETE CASCADE ON UPDATE CASCADE
);

alter table `staff_anime` auto_increment=1;
insert into `staff_anime` VALUES (1,1, 'director');
select * from staff_anime;

CREATE TABLE `review` (
    `review_id` SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `title` VARCHAR(50),
    `text` TEXT NOT NULL,
    `user_id` INT UNSIGNED NOT NULL,
    PRIMARY KEY(`review_id`),
    FOREIGN KEY (`user_id`) REFERENCES `user`(`user_id`) ON UPDATE CASCADE
) AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;

insert into `review` values (null, 'This is my review', 1);
update review set title ='This is my title';
select * from review
alter table `review` add column `title` VARCHAR(50) after `review_id`;
CREATE TABLE `review_anime` (
    `review_id` SMALLINT UNSIGNED NOT NULL,
    `anime_id` INT UNSIGNED NOT NULL,
    PRIMARY KEY (`review_id`, `anime_id`),
    FOREIGN KEY (`review_id`) REFERENCES `review`(`review_id`) ON UPDATE CASCADE ON DELETE CASCADE,
    FOREIGN KEY (`anime_id`) REFERENCES `anime`(`anime_id`) ON UPDATE CASCADE ON DELETE CASCADE
);

insert into `review_anime` VALUES (1,1);
show tables;

CREATE TABLE `studio` (
    `studio_id` SMALLINT UNSIGNED
) AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;

CREATE TABLE `producer` (
    `producer_id` SMALLINT UNSIGNED
) AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;

CREATE TABLE `score` (
    `anime_id` INT UNSIGNED NOT NULL,
    `user_id` INT UNSIGNED NOT NULL,
    `score` FLOAT(4,3),
    PRIMARY KEY ('anime_id', 'user_id'),
    FOREIGN KEY ('anime_id') REFERENCES anime('anime_id') ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY ('user_id') REFERENCES user('user_id') ON DELETE CASCADE ON UPDATE CASCADE
);