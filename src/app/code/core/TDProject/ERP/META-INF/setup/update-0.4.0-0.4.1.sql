ALTER TABLE `person` ADD `title` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL AFTER `lastname`;

ALTER TABLE `company` ADD `additional_name` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL AFTER `name`;
ALTER TABLE `company` ADD `website` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL AFTER `telefax`;

ALTER TABLE `company` CHANGE `phone` `phone` VARCHAR(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL;
ALTER TABLE `company` CHANGE `email` `email` VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL;

ALTER TABLE `address` CHANGE `street` `street` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL;
ALTER TABLE `address` CHANGE `number` `number` VARCHAR(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL;
ALTER TABLE `address` ADD `post_office_box` VARCHAR(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL; 