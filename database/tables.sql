-- score here looks bad. lacks themes or genre system -

CREATE TABLE animes (
    `anime_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `title` VARCHAR(150) NOT NULL UNIQUE,
    `type` VARCHAR(25) NOT NULL,
    `episodes` INT NOT NULL,
    `status` VARCHAR(25) NOT NULL,
    `start_date` DATE NOT NULL,
    `end_date` DATE NOT NULL,
    `season` VARCHAR(30) NOT NULL,
    `studios` VARCHAR(300) NOT NULL,
    `producers` VARCHAR(300) NOT NULL,
    `description` VARCHAR(3000) NOT NULL,
    `score` float(4,3) NOT NULL,
    PRIMARY KEY(`anime_id`)
) AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

CREATE TABLE manga (
    `manga_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `title` VARCHAR(150) NOT NULL UNIQUE,
    `type` VARCHAR(25) NOT NULL,
    `episodes` INT NOT NULL,
    `status` VARCHAR(25) NOT NULL,
    `start_date` DATE NOT NULL,
    `end_date` DATE NOT NULL,
    `season` VARCHAR(30) NOT NULL,
    `studios` VARCHAR(300) NOT NULL,
    `producers` VARCHAR(300) NOT NULL,
    `description` VARCHAR(3000) NOT NULL,
    `score` float(4,3) NOT NULL,
    PRIMARY KEY(`anime_id`)
) AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

CREATE TABLE images (
    `image_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `path` VARCHAR(200) NOT NULL UNIQUE,
    PRIMARY KEY (`image_id`)
) AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

alter table animes add `description` VARCHAR(3000) after producers;

alter table animes drop column description;

alter table animes add column `description` varchar(3000) not null after `producers`;

show columns from animes;