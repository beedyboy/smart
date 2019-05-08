ALTER TABLE `sales` CHANGE `waiter` `waiter` INT(11) NULL;

ALTER TABLE `shops` ADD `status` ENUM("Child","Parent") NULL DEFAULT 'Child' AFTER `shopPhoneNum`;

ALTER TABLE `applications` ADD `shopId` INT NOT NULL AFTER `id`, ADD `currency` VARCHAR(10) NULL AFTER `shopId`, ADD INDEX (`shopId`);
ALTER TABLE `applications` ADD INDEX(`updated_by`);
ALTER TABLE `applications` ADD FOREIGN KEY (`shopId`) REFERENCES `shops`(`id`) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE `applications` ADD FOREIGN KEY (`updated_by`) REFERENCES `shops`(`id`) ON DELETE CASCADE ON UPDATE CASCADE;


ALTER TABLE `sales` ADD `period` VARCHAR(20) NULL AFTER `ord_type`;

ALTER TABLE `applications` ADD PRIMARY KEY(`id`);
ALTER TABLE `applications` CHANGE `id` `id` INT(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `applications` CHANGE `updated_at` `updated_at` TIMESTAMP NULL, CHANGE `updated_by` `updated_by` INT(11) NULL;

ALTER TABLE `applications` DROP FOREIGN KEY `applications_ibfk_2`;
ALTER TABLE `applications` ADD CONSTRAINT `applications_ibfk_2` FOREIGN KEY (`updated_by`) REFERENCES `users`(`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `purchases` ADD `note` VARCHAR(255) NULL AFTER `purchased_date`;
