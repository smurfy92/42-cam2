<?php
$sql="CREATE TABLE IF NOT EXISTS `camagru`.`users` ( `id` INT NOT NULL AUTO_INCREMENT , `login` TEXT NOT NULL , `email` TEXT NOT NULL , `password` TEXT NOT NULL, `registered` INT , `hash` TEXT NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;";
$db->exec($sql);
$sql="CREATE TABLE IF NOT EXISTS `camagru`.`images` ( `id` INT NOT NULL AUTO_INCREMENT , `user_id` INT NOT NULL , `b64` LONGBLOB NOT NULL, `likes` TEXT, PRIMARY KEY (`id`)) ENGINE = InnoDB;";
$db->exec($sql);
$sql="CREATE TABLE IF NOT EXISTS `camagru`.`comments` ( `id` INT NOT NULL AUTO_INCREMENT , `image_id` INT NOT NULL , `user_id` INT NOT NULL, `text` TEXT NOT NULL, PRIMARY KEY (`id`)) ENGINE = InnoDB;";
$db->exec($sql);