UPDATE `language_strings` SET `key` = 'hands_on', `value_english` = 'Hands-On', `value_efik` = 'Hands-On' WHERE (`id` = '63');

ALTER TABLE `hands_on_info` 
ADD COLUMN `featured_image` VARCHAR(80) NULL AFTER `content_efik`;

