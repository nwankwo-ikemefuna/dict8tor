CREATE TABLE IF NOT EXISTS `modules` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `parent_id` int(10) NOT NULL,
  `name` varchar(30) NOT NULL,
  `title` varchar(30) NOT NULL,
  `icon` varchar(30) NOT NULL DEFAULT 'cube',
  `rights` varchar(255) NOT NULL,
  `private` tinyint(1) DEFAULT '0',
  `active` tinyint(1) NOT NULL,
  `pix_dir` varchar(45) DEFAULT NULL,
  `doc_dir` varchar(45) DEFAULT NULL,
  `order` tinyint(2) NOT NULL,
  `max` int(6) DEFAULT '-1',
  `trashed` tinyint(1) DEFAULT '0',
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_updated` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `parent_id` (`parent_id`),
  KEY `id` (`id`),
  KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `usergroups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  `title` varchar(45) DEFAULT NULL,
  `trashed` tinyint(1) DEFAULT '0',
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_updated` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `id` (`id`),
  KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

INSERT INTO `usergroups` (`id`, `name`, `title`, `trashed`, `date_created`, `date_updated`) VALUES
(1, 's_admin', 'Super Admin', 0, '2020-01-04 06:48:47', '2020-01-04 08:05:26'),
(2, 'admin', 'Admin', 0, '2020-01-04 06:48:47', NULL),
(3, 'staff', 'Staff', 0, '2020-02-22 15:25:21', '2020-06-07 17:02:03'),
(4, 'student', 'Student', 0, '2020-02-22 15:25:21', '2020-06-07 17:02:03')
ON DUPLICATE KEY UPDATE 
  `id`=VALUES(`id`),
  `name`=VALUES(`name`),
  `title`=VALUES(`title`),
  `trashed`=VALUES(`trashed`),
  `date_created`=VALUES(`date_created`),
  `date_updated`=VALUES(`date_updated`);

ALTER TABLE `usergroups` AUTO_INCREMENT = 4;

ALTER TABLE `usergroups` CHANGE COLUMN `name` `name` VARCHAR(45) NULL DEFAULT NULL;