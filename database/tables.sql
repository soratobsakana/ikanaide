CREATE TABLE user (
    `user_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `username` VARCHAR(16) NOT NULL UNIQUE,
    `password` VARCHAR(60) NOT NULL,
    `email` VARCHAR(319) NOT NULL UNIQUE,
    `joined_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `country` varchar(56),
    `biography` VARCHAR(4000),
    `pfp` VARCHAR(250) NOT NULL DEFAULT 'storage/img/default/default.png',
    `website` VARCHAR(200),
    PRIMARY KEY('user_id')
) AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;

-- `members` and `favorited` will both be added 1 each time anyone clicks their respective buttons -
CREATE TABLE anime (
    `anime_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `title` VARCHAR(150) NOT NULL UNIQUE,
    `english_title` VARCHAR(150) UNIQUE,
    `japanese_title` NVARCHAR(150) COLLATE Japanese_CI_AS_KS_WS UNIQUE,
    `type` VARCHAR(25) NOT NULL,
    `episodes` SMALLINT UNSIGNED NOT NULL,
    `status` VARCHAR(25) NOT NULL,
    `start_date` DATE NOT NULL DEFAULT 'N/A',
    `end_date` DATE NOT NULL DEFAULT 'N/A',
    `season` VARCHAR(30) NOT NULL,
    `description` VARCHAR(3000) NOT NULL,
    `members` INT UNSIGNED NOT NULL DEFAULT 0,
    `favorited` INT UNSIGNED NOT NULL DEFAULT 0,
    PRIMARY KEY(`anime_id`)
) AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;

CREATE TABLE manga (
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

CREATE TABLE image (
    `image_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `path` VARCHAR(200) NOT NULL UNIQUE,
    PRIMARY KEY (`image_id`)
) AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;

CREATE TABLE studio (
    `studio_id` SMALLINT UNSIGNED
) AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;

CREATE TABLE producer (
    `producer_id` SMALLINT UNSIGNED
) AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;

CREATE TABLE score (
    `anime_id` INT UNSIGNED NOT NULL,
    `user_id` INT UNSIGNED NOT NULL,
    `score` FLOAT(4,3),
    PRIMARY KEY ('anime_id', 'user_id'),
    FOREIGN KEY ('anime_id') REFERENCES anime('anime_id') ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY ('user_id') REFERENCES user('user_id') ON DELETE CASCADE ON UPDATE CASCADE
);

alter table animes add `description` VARCHAR(3000) after producers;

alter table animes drop column description;

alter table animes add column `description` varchar(3000) not null after `producers`;

show columns from animes;

insert into animes_test(id, title) values
    (null, 'Gintama');

select * from animes_test;

update animes_test set img_path = 'storage/img/gintama.webp' where id=2;
