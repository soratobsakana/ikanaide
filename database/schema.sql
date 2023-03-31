DROP TABLE `anime`;
DROP TABLE `character`;
DROP TABLE `character_anime`;
DROP TABLE `review`;
DROP TABLE `review_anime`;
DROP TABLE `staff`;
DROP TABLE `user`;

-- Lots of rows in these tables will be stored in a single JSON row in the future.

CREATE TABLE `user` (
    `user_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `username` VARCHAR(16) NOT NULL UNIQUE,
    `password` VARCHAR(60) NOT NULL,
    `email` VARCHAR(319) NOT NULL UNIQUE,
    `joined_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `country` varchar(56),
    `biography` VARCHAR(4000),
    `pfp` VARCHAR(250) NOT NULL DEFAULT 'storage/sys/default.webp',
    data JSON,
    PRIMARY KEY(`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;

update `user` set `pfp` ='storage/img/rin.jpg' where username='nabuna';
alter table `user` modify column `pfp` VARCHAR(250) NOT NULL DEFAULT 'storage/sys/default.webp';
insert into `user` values (null, 'nagisa', 'pw', 'pw@pw.pw', default, 'spain', 'This is my biography', default, null);

-- Session verifier, currently not being used. Validation is currently running through User::validateSession()
CREATE TABLE sessions (
    `user_id` INT UNSIGNED  NOT NULL,
    `added` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `expires` DATETIME DEFAULT CURRENT_TIMESTAMP, -- 'api2' tokens don't expire, this column is used for last-use tracking
    `token` varchar(60) NOT NULL,
    PRIMARY KEY (user_id, token)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;



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
    `cover` VARCHAR(200) NOT NULL DEFAULT 'storage/sys/default_cover.png',
    `header` VARCHAR(200) NULL DEFAULT NULL,
    PRIMARY KEY(`anime_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;

select * from anime;
update anime set title ='Kimetsu no Yaiba Katanakaji no Sato hen' where anime_id=10;
insert into anime(title, type, episodes, status, season, description, cover) values
('Kimetsu no Yaiba: Katanakaji no Sato-hen', 'TV', 24, 'finished', 'sprint 2020', 'This is a description', '/storage/animes/kny/cover.jpg');

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
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;

update manga set `cover`='storage/img/punpun.jpg';
select * from manga;
insert into manga values (null, 'Oyasumi Punpun', null, null, 'manga', '13', '144', 'finished', '2007-03-15', '2013-11-02', 'Punpun Onodera is a normal 11-year-old boy living in Japan. Hopelessly idealistic and romantic, Punpun begins to see his life take a subtle—though nonetheless startling—turn to the adult when he meets the new girl in his class, Aiko Tanaka. It is then that the quiet boy learns just how fickle maintaining a relationship can be, and the surmounting difficulties of transitioning from a naïve boyhood to a convoluted adulthood. When his father assaults his mother one night, Punpun realizes another thing: those whom he looked up to were not as impressive as he once thought.', 0, 0, 'storage/img/punpun.jpeg', 'storage/img/punpun_header.png');

CREATE TABLE `vn` (
      `vn_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
      `title` VARCHAR(150) NOT NULL UNIQUE,
      `english_title` VARCHAR(150) UNIQUE,
      `japanese_title` NVARCHAR(150) UNIQUE,
      `duration` INT UNSIGNED, -- Minutes -
      `released` DATE,
      `description` VARCHAR(3000) NOT NULL,
      `members` INT UNSIGNED NOT NULL DEFAULT 0,
      `favorited` INT UNSIGNED NOT NULL DEFAULT 0,
      `cover` VARCHAR(200) NOT NULL DEFAULT 'storage/sys/default_cover.png',
      `header` VARCHAR(200) NULL DEFAULT NULL,
      PRIMARY KEY(`vn_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;

insert into `vn` values (null, 'Sakura no Uta', null, null, 3000, '2015-10-23', 'Naoya Kusanagi lost his mother when he was a child. Naoyas father who is a famous artist is the only person that can help him cope with the loss of his friend, Rin Misakura who move while they were in elementary school. Later, Naoyas father died. After the funeral ends, Naoya is taken into the custody of Keis family in exchange for cooking meals at their home. 6 years later, Rin is transferred to Naoyas class.', 0, 0, 'storage/img/sakuta.jpeg', 'storage/img/sakuta_header.jpg');
select * from vn;
show columns from `anime`;

insert into anime values(
null, 'Gintama', null, null, 'TV', 49, 'finished', '2011-04-04', '2012-03-26', 'spring 2011', 'After a one-year hiatus, Shinpachi Shimura returns to Edo, only to stumble upon a shocking surprise: Gintoki and Kagura, his fellow Yorozuya members, have become completely different characters! Fleeing from the Yorozuya headquarters in confusion, Shinpachi finds that all the denizens of Edo have undergone impossibly extreme changes, in both appearance and personality. Most unbelievably, his sister Otae has married the Shinsengumi chief and shameless stalker Isao Kondou and is pregnant with their first child.', 0, 0, 'storage/img/gintama.webp', 'storage/img/gintama_header.webp');
select * from anime;

update anime set `header` = 'storage/img/gintama_header.jpg' where anime_id=1;

CREATE TABLE `character` (
    `character_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `family_name` VARCHAR(50),
    `given_name` VARCHAR(50),
    `alias` VARCHAR(50),
    `japanese_name` NVARCHAR(50),
    `data` JSON,
    `picture` VARCHAR(200) NOT NULL DEFAULT 'storage/sys/default_cover.png',
    PRIMARY KEY (`character_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;

insert into `character`(family_name, given_name, picture) values
('Shinei', 'Nouzen', '/storage/animes/86/char/char.jpg');

insert into `character_anime` values(16,2, 'Main');

select * from anime;

show columns from `character`;
alter table `character` auto_increment = 2;
select * from `character`;

insert into `character` values
    (null, 'Sakata', 'Gintoki', null,  null,  null, 'storage/public/character/gintoki.jpg');
insert into `character` values
    (null, 'Sakataa', 'Gintoki', null,  null,  null, 'storage/public/character/gintoki.jpg');
insert into `character` values
    (null, 'Sakataaa', 'Gintoki', null,  null,  null, 'storage/public/character/gintoki.jpg');

insert into `character` values
    (null, 'Sakataaaa', 'Gintoki', null,  null,  null, 'storage/public/character/gintoki.jpg');
insert into `character` values
    (null, 'Sakataaaaa', 'Gintoki', null,  null,  null, 'storage/public/character/gintoki.jpg');
insert into `character` values
    (null, 'Sakataaaaaa', 'Gintoki', null,  null,  null, 'storage/public/character/gintoki.jpg');
insert into `character` values
    (null, 'Onodera', 'Punpun', null,  null,  null, 'storage/public/character/punpun.jpg');
select * from `character`;

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

insert into `character_anime` values(1,1, 'Main');

insert into `character_anime` values(3,1, 'Supporting');
insert into `character_anime` values(4,1, 'Supporting');
insert into `character_anime` values(5,1, 'Supporting');
insert into `character_anime` values(6,1, 'Supporting');
insert into `character_manga` values(7,1, 'Supporting');
select * from character_manga;

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
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;

insert into staff values
(null, 'Sorachi', 'Hideaki', null, null, null, 'storage/public/staff/Sorachi-Hideaki.jpg');
insert into staff values
    (null, 'Sorachii', 'Hideaki', null, null, null, 'storage/public/staff/Sorachi-Hideaki.jpg');
insert into staff values
    (null, 'Sorachiii', 'Hideaki', null, null, null, 'storage/public/staff/Sorachi-Hideaki.jpg');
insert into staff values
    (null, 'Inio', 'Asano', null, null, null, 'storage/public/staff/asano.jpg');

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

CREATE TABLE `staff_manga` (
   `staff_id` INT UNSIGNED NOT NULL,
   `manga_id` INT UNSIGNED NOT NULL,
   `role` VARCHAR(50) NOT NULL DEFAULT 'Participant',
   PRIMARY KEY(`staff_id`, `manga_id`),
   FOREIGN KEY (`staff_id`) REFERENCES `staff`(`staff_id`) ON DELETE CASCADE ON UPDATE CASCADE,
   FOREIGN KEY (`manga_id`) REFERENCES `manga`(`manga_id`) ON DELETE CASCADE ON UPDATE CASCADE
);

alter table `staff_anime` auto_increment=1;
insert into `staff_anime` VALUES (1,1, 'director');
insert into `staff_anime` VALUES (2,1, 'director');
insert into `staff_anime` VALUES (3,1, 'director');
insert into `staff_manga` VALUES (4,1, 'creator');
select * from staff_anime;
select * from staff_manga;
select * from staff;

CREATE TABLE `review` (
    `review_id` SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `title` VARCHAR(50),
    `text` TEXT NOT NULL,
    `user_id` INT UNSIGNED NOT NULL,
    `date` DATETIME DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY(`review_id`),
    FOREIGN KEY (`user_id`) REFERENCES `user`(`user_id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;

alter table `review` drop column `joined_at`;
alter table `review` add column `date` DATETIME DEFAULT CURRENT_TIMESTAMP after `user_id`;

alter table

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

CREATE TABLE `review_manga` (
    `review_id` SMALLINT UNSIGNED NOT NULL,
    `manga_id` INT UNSIGNED NOT NULL,
    PRIMARY KEY (`review_id`, `manga_id`),
    FOREIGN KEY (`review_id`) REFERENCES `review`(`review_id`) ON UPDATE CASCADE ON DELETE CASCADE,
    FOREIGN KEY (`manga_id`) REFERENCES `manga`(`manga_id`) ON UPDATE CASCADE ON DELETE CASCADE
);

insert into `review_anime` VALUES (1,1);
show tables;

CREATE TABLE `studio` (
    `studio_id` SMALLINT UNSIGNED
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;

CREATE TABLE `producer` (
    `producer_id` SMALLINT UNSIGNED
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;

CREATE TABLE `score` (
    `anime_id` INT UNSIGNED NOT NULL,
    `user_id` INT UNSIGNED NOT NULL,
    `score` FLOAT(4,3),
    PRIMARY KEY ('anime_id', 'user_id'),
    FOREIGN KEY ('anime_id') REFERENCES anime('anime_id') ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY ('user_id') REFERENCES user('user_id') ON DELETE CASCADE ON UPDATE CASCADE
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
      `user_id` INT UNSIGNED NOT NULL,
      `date` DATETIME DEFAULT CURRENT_TIMESTAMP,
      PRIMARY KEY (`edit_id`, `anime_id`, `user_id`),
      FOREIGN KEY (`anime_id`) REFERENCES `anime`(`anime_id`) ON UPDATE CASCADE ON DELETE CASCADE,
      FOREIGN KEY (`user_id`) REFERENCES `user`(`user_id`) ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;

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
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;

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
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;

CREATE TABLE `submit_vn` (
         `vid` INT UNSIGNED NOT NULL AUTO_INCREMENT,
         `title` VARCHAR(150),
         `english_title` VARCHAR(150),
         `japanese_title` NVARCHAR(150),
         `duration` INT UNSIGNED,
         `released` VARCHAR(200),
         `description` VARCHAR(3000),
         `cover` VARCHAR(200),
         `header` VARCHAR(200),
         `user_id` INT UNSIGNED NOT NULL,
         `date` DATETIME DEFAULT CURRENT_TIMESTAMP,
         PRIMARY KEY(`vid`),
         FOREIGN KEY (`user_id`) REFERENCES `user`(`user_id`) ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;

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
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;

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
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;

select * from `edit_anime`;

drop table `edit_anime`;
drop table `submit_anime`;
drop table `submit_manga`;
drop table `submit_character`;
drop table `submit_staff`;
drop table `edit_anime`;
drop table `edit_anime`;
SELECT count(*) FROM INFORMATION_SCHEMA.COLUMNS WHERE table_name = 'submit_manga';
select * from submit_manga;
select * from submit_anime;
select * from submit_staff;
select * from submit_character;
select * from submit_vn;

-- Relations of the user with the database:
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

select * from mangalist;
show columns from animelist;
select * from user;
insert into animelist values (3, 4, 8.5, 'Example comment', 10,  TRUE);
select * from anime;
update animelist set `progress`=10;
alter table animelist modify column `favorite` BIT(1) NOT NULL DEFAULT 0;
select * from animelist;
update animelist set `favorite` = 1 where anime_id = 1;

show columns from anime;

delete from animelist;

-- This will be the one to go in production
CREATE TABLE animelist (
   `user_id` INT UNSIGNED NOT NULL,
   data JSON NOT NULL,
   PRIMARY KEY(`user_id`),
   FOREIGN KEY (`user_id`) REFERENCES `user`(`user_id`) ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;