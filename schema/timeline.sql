CREATE TABLE `timeline_groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title_english` varchar(80) CHARACTER SET utf8 NOT NULL,
  `title_efik` varchar(80) CHARACTER SET utf8 NOT NULL,
  `order` smallint(6) DEFAULT NULL,
  `published` tinyint(1) DEFAULT '1',
  `trashed` tinyint(1) DEFAULT '0',
  `date_created` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `date_updated` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`),
  KEY `title` (`title_english`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `timelines` 
ADD COLUMN `group_id` INT(10) NULL AFTER `id`;

ALTER TABLE `isobassey`.`timelines` 
ADD INDEX `bfk_timeline_groups_idx` (`group_id` ASC);

ALTER TABLE `isobassey`.`timelines` 
ADD CONSTRAINT `bfk_timeline_groups`
  FOREIGN KEY (`group_id`)
  REFERENCES `isobassey`.`timeline_groups` (`id`)
  ON DELETE SET NULL
  ON UPDATE SET NULL;

