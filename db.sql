CREATE TABLE IF NOT EXISTS `airports` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `icao` varchar(6) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `lat` double DEFAULT NULL,
  `lon` double DEFAULT NULL,
  `alt` int(10) DEFAULT NULL,
  `iata` varchar(4) DEFAULT NULL,
  `city` varchar(50) DEFAULT NULL,
  `iso` varchar(2) DEFAULT NULL,
  `FIR` varchar(4) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `icao` (`icao`),
  KEY `iso` (`iso`),
  KEY `FIR` (`FIR`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `content` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name_ru` varchar(50) NOT NULL,
  `name_en` varchar(50) NOT NULL,
  `text_ru` text NOT NULL,
  `text_en` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `isocodes` (
  `code` varchar(2) NOT NULL,
  `country` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`code`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `ranks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name_ru` varchar(200) DEFAULT NULL,
  `name_en` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `users` (
  `vid` int(11) NOT NULL,
  `full_name` varchar(200) DEFAULT NULL,
  `email` varchar(200) DEFAULT NULL,
  `country` varchar(2) DEFAULT NULL,
  `authKey` text,
  `language` varchar(2) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `last_visited` datetime DEFAULT NULL,
  PRIMARY KEY (`vid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `user_pilot` (
  `user_id` int(11) NOT NULL,
  `location` varchar(4) DEFAULT NULL,
  `active` int(11) DEFAULT NULL,
  `rank_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;