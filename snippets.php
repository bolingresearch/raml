<?php
    // Create the mls_users table
	$sql = 'CREATE TABLE `djboling_raml`.`mls_users` (`id` BIGINT NOT NULL, `mls_id` BIGINT NOT NULL, `first_name` VARCHAR(30) NOT NULL, `last_name` VARCHAR(30) NOT NULL, `address` VARCHAR(60) NOT NULL, `address2` VARCHAR(60) NULL, `city` VARCHAR(30) NOT NULL, `state` VARCHAR(2) NOT NULL, `zipcode` INT(5) NOT NULL, `phone` VARCHAR(30) NULL, PRIMARY KEY (`id`), UNIQUE (`mls_id`)) ENGINE = MyISAM';
?>