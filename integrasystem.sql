CREATE TABLE `app_tasks` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `deadline` date DEFAULT NULL,
  `name` varchar(40) NOT NULL DEFAULT '',
  `details` text,
  `image` varchar(255) DEFAULT NULL,
  `image_small` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `slug` varchar(40) NOT NULL,
  `creator_id` int(10) NOT NULL,
  `editor_id` int(10) NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `app_team_tasks` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `team_id` int(10) NOT NULL DEFAULT '0',
  `task_id` int(10) NOT NULL DEFAULT '0',
  `points` int(6) NOT NULL DEFAULT '0',
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `app_teams` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(40) NOT NULL DEFAULT '',
  `acronym` char(10) NOT NULL DEFAULT '',
  `color` char(7) NOT NULL DEFAULT '',
  `points` int(10) DEFAULT '0',
  `is_active` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `slug` varchar(40) NOT NULL,
  `creator_id` int(10) NOT NULL,
  `editor_id` int(10) NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `app_users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL DEFAULT '',
  `lastname` varchar(45) NOT NULL DEFAULT '',
  `email` varchar(45) NOT NULL,
  `username` varchar(25) NOT NULL,
  `password` char(60) NOT NULL,
  `new_password_requested` datetime DEFAULT NULL,
  `is_active` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;