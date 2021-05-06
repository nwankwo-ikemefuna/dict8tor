INSERT INTO `modules` (`id`, `parent_id`, `name`, `title`, `icon`, `rights`, `private`, `active`, `order`, `max`, `trashed`, `date_created`) VALUES (NULL, '0', 'videos', 'Videos', 'video-camera', '1,2,3,4', '0', '1', '10', '-1', '0', '2021-04-11 16:36:10');
INSERT INTO `language_strings` (`key`, `value_english`, `value_efik`) VALUES ('videos', 'Videos', 'Vidioz');
INSERT INTO `language_strings` (`key`, `value_english`, `value_efik`) VALUES ('recent_videos', 'Recent Videos', 'Vidioz Adịbeghị Anya');
INSERT INTO `language_strings` (`key`, `value_english`, `value_efik`) VALUES ('more_videos', 'More Videos', 'Vidioz Ndị Ozọ');

ALTER TABLE `posts` 
DROP COLUMN `featured_item_type`,
CHANGE COLUMN `featured_item` `featured_image` VARCHAR(80) NULL DEFAULT NULL,
ADD COLUMN `featured_video` VARCHAR(80) NULL DEFAULT NULL AFTER `featured_image`;


CREATE TABLE `videos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `playlist_id` int(11) DEFAULT NULL,
  `title_english` varchar(255) CHARACTER SET utf8 NOT NULL,
  `title_efik` varchar(255) CHARACTER SET utf8 NOT NULL,
  `content_english` text CHARACTER SET utf8,
  `content_efik` text CHARACTER SET utf8,
  `published` tinyint(1) DEFAULT '1',
  `trashed` tinyint(1) DEFAULT '0',
  `date_created` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `date_updated` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`),
  KEY `title` (`title_english`),
  KEY `ibk_video_playlists_idx` (`playlist_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `videos` (`id`, `playlist_id`, `title_english`, `title_efik`, `content_english`, `content_efik`, `published`, `trashed`, `date_created`, `date_updated`) VALUES
(1, NULL, 'How To Update Term Settings', 'How To Update Term Settings', 'https://www.youtube.com/embed/XuF5MNumRqg', 'https://www.youtube.com/embed/XuF5MNumRqg', 1, 0, '2021-05-06 07:44:12', NULL),
(2, NULL, 'How To Add A Student', 'How To Add A Student', 'https://www.youtube.com/embed/FR52FsTJo-E', 'https://www.youtube.com/embed/FR52FsTJo-E', 1, 0, '2021-05-06 07:44:12', NULL),
(3, NULL, 'How To Add A Class', 'How To Add A Class', 'https://www.youtube.com/embed/ioukgsLhkM8', 'https://www.youtube.com/embed/ioukgsLhkM8', 1, 0, '2021-05-06 07:44:12', NULL),
(4, NULL, 'How To Add Sections', 'How To Add Sections', 'https://www.youtube.com/embed/tLXc5tdw8l8', 'https://www.youtube.com/embed/tLXc5tdw8l8', 1, 0, '2021-05-06 07:44:12', NULL),
(5, NULL, 'How To Produce Results', 'How To Produce Results', 'https://www.youtube.com/embed/-ty6zphMt-g', 'https://www.youtube.com/embed/-ty6zphMt-g', 1, 0, '2021-05-06 07:44:12', NULL),
(6, NULL, 'How To Assign Subject To A Subject Teacher', 'How To Assign Subject To A Subject Teacher', 'https://www.youtube.com/embed/9SB22zeKa18', 'https://www.youtube.com/embed/9SB22zeKa18', 1, 0, '2021-05-06 07:44:12', NULL);
