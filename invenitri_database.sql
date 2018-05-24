/*
SQLyog Ultimate v11.11 (64 bit)
MySQL - 5.5.5-10.1.30-MariaDB : Database - invenitri_database
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`invenitri_database` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `invenitri_database`;

/*Table structure for table `groups` */

DROP TABLE IF EXISTS `groups`;

CREATE TABLE `groups` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `description` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `groups` */

insert  into `groups`(`id`,`name`,`description`) values (1,'admin','Administrator'),(2,'members','General User');

/*Table structure for table `inv_categories` */

DROP TABLE IF EXISTS `inv_categories`;

CREATE TABLE `inv_categories` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(30) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text,
  `deleted` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1 = deleted',
  `created_by` varchar(255) NOT NULL,
  `created_on` datetime NOT NULL,
  `updated_by` varchar(255) NOT NULL,
  `updated_on` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `inv_datas` */

DROP TABLE IF EXISTS `inv_datas`;

CREATE TABLE `inv_datas` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(255) NOT NULL,
  `category_id` int(12) NOT NULL COMMENT 'FK inv_category',
  `location_id` int(12) DEFAULT NULL COMMENT 'FK inv_location',
  `brand` varchar(255) DEFAULT NULL,
  `model` varchar(255) DEFAULT NULL,
  `serial_number` varchar(255) DEFAULT NULL,
  `status` int(12) DEFAULT NULL COMMENT 'FK master_status',
  `length` int(12) DEFAULT NULL COMMENT 'Panjang',
  `width` int(12) DEFAULT NULL COMMENT 'Lebar',
  `height` int(12) DEFAULT NULL COMMENT 'Tinggi',
  `weight` int(12) DEFAULT NULL COMMENT 'Berat',
  `color` varchar(20) DEFAULT NULL COMMENT 'Warna',
  `price` int(12) DEFAULT NULL COMMENT 'Harga Beli',
  `date_of_purchase` date DEFAULT NULL COMMENT 'Tgl Beli',
  `photo` text COMMENT 'Foto',
  `thumbnail` text COMMENT 'Thumb',
  `description` text COMMENT 'Keterangan',
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  `created_by` varchar(255) NOT NULL,
  `created_on` datetime NOT NULL,
  `updated_by` varchar(255) NOT NULL,
  `updated_on` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `inv_locations` */

DROP TABLE IF EXISTS `inv_locations`;

CREATE TABLE `inv_locations` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `detail` text,
  `photo` text,
  `thumbnail` text,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  `created_by` varchar(255) NOT NULL,
  `created_on` datetime NOT NULL,
  `updated_by` varchar(255) NOT NULL,
  `updated_on` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `inv_log_data_location` */

DROP TABLE IF EXISTS `inv_log_data_location`;

CREATE TABLE `inv_log_data_location` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(255) NOT NULL COMMENT 'FK inv_datas',
  `location_id` int(12) NOT NULL COMMENT 'FK inv_locations',
  `created_by` varchar(255) NOT NULL,
  `created_on` datetime NOT NULL,
  `updated_by` varchar(255) NOT NULL,
  `updated_on` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `inv_log_data_status` */

DROP TABLE IF EXISTS `inv_log_data_status`;

CREATE TABLE `inv_log_data_status` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(255) NOT NULL COMMENT 'FK inv_datas',
  `status_id` int(12) NOT NULL COMMENT 'FK inv_status',
  `created_by` varchar(255) NOT NULL,
  `created_on` datetime NOT NULL,
  `updated_by` varchar(255) NOT NULL,
  `updated_on` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `inv_status` */

DROP TABLE IF EXISTS `inv_status`;

CREATE TABLE `inv_status` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `description` text,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  `created_by` varchar(255) NOT NULL,
  `created_on` datetime DEFAULT NULL,
  `updated_by` varchar(255) NOT NULL,
  `updated_on` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Data for the table `inv_status` */

insert  into `inv_status`(`id`,`name`,`description`,`deleted`,`created_by`,`created_on`,`updated_by`,`updated_on`) values (1,'In Use','<p>Aktif digunakan</p>',0,'administrator','2018-04-13 11:16:07','administrator','2018-04-13 11:16:07'),(2,'Not Used','<p>Tidak digunakan</p>',0,'administrator','2018-04-13 11:17:25','administrator','2018-04-13 11:17:25'),(3,'In Repair','<p>Status barang masih dalam perbaikan</p>',0,'administrator','2018-04-18 16:34:43','administrator','2018-04-18 16:35:05');

/*Table structure for table `invenitri_session` */

DROP TABLE IF EXISTS `invenitri_session`;

CREATE TABLE `invenitri_session` (
  `id` varchar(40) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int(10) unsigned NOT NULL DEFAULT '0',
  `data` blob NOT NULL,
  KEY `ci_sessions_timestamp` (`timestamp`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Table structure for table `login_attempts` */

DROP TABLE IF EXISTS `login_attempts`;

CREATE TABLE `login_attempts` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(45) NOT NULL,
  `login` varchar(100) NOT NULL,
  `time` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `master_color` */

DROP TABLE IF EXISTS `master_color`;

CREATE TABLE `master_color` (
  `id` tinyint(2) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  `created_by` varchar(255) NOT NULL,
  `created_on` datetime NOT NULL,
  `updated_by` varchar(255) NOT NULL,
  `updated_on` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

/*Data for the table `master_color` */

insert  into `master_color`(`id`,`name`,`deleted`,`created_by`,`created_on`,`updated_by`,`updated_on`) values (1,'Black',0,'administrator','2018-04-03 16:30:13','administrator','2018-04-03 16:30:13'),(2,'White',0,'administrator','2018-04-13 10:48:13','administrator','2018-04-13 10:48:13'),(3,'Grey',0,'administrator','2018-04-13 11:32:37','administrator','2018-04-18 15:38:32'),(4,'Blue',0,'administrator','2018-04-13 11:32:44','administrator','2018-04-18 15:38:24'),(5,'Red',0,'administrator','2018-04-18 15:37:57','administrator','2018-04-18 15:37:57'),(6,'Brown',0,'administrator','2018-05-09 10:56:40','administrator','2018-05-09 10:56:40'),(7,'Yellow',0,'administrator','2018-05-09 11:02:17','administrator','2018-05-09 11:02:17'),(8,'Black White',0,'administrator','2018-05-11 09:43:40','administrator','2018-05-11 09:43:40'),(9,'Green',0,'administrator','2018-05-18 15:13:17','administrator','2018-05-18 15:13:17');

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(45) NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `salt` varchar(255) DEFAULT NULL,
  `email` varchar(254) NOT NULL,
  `activation_code` varchar(40) DEFAULT NULL,
  `forgotten_password_code` varchar(40) DEFAULT NULL,
  `forgotten_password_time` int(11) unsigned DEFAULT NULL,
  `remember_code` varchar(40) DEFAULT NULL,
  `created_on` int(11) unsigned NOT NULL,
  `last_login` int(11) unsigned DEFAULT NULL,
  `active` tinyint(1) unsigned DEFAULT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `users` */

insert  into `users`(`id`,`ip_address`,`username`,`password`,`salt`,`email`,`activation_code`,`forgotten_password_code`,`forgotten_password_time`,`remember_code`,`created_on`,`last_login`,`active`,`first_name`,`last_name`,`phone`) values (1,'127.0.0.1','administrator','$2a$07$SeBknntpZror9uyftVopmu61qg0ms8Qv1yV6FG.kQOSM.9QhmTo36','','admin@admin.com','',NULL,NULL,'gGSTNbCuCI/8jRvE.dfQZ.',1268889823,1527123844,1,'System','Administrator','01234567');

/*Table structure for table `users_groups` */

DROP TABLE IF EXISTS `users_groups`;

CREATE TABLE `users_groups` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `group_id` mediumint(8) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uc_users_groups` (`user_id`,`group_id`),
  KEY `fk_users_groups_users1_idx` (`user_id`),
  KEY `fk_users_groups_groups1_idx` (`group_id`),
  CONSTRAINT `fk_users_groups_groups1` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `fk_users_groups_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

/*Data for the table `users_groups` */

insert  into `users_groups`(`id`,`user_id`,`group_id`) values (5,1,1),(6,1,2);

/*Table structure for table `users_photo` */

DROP TABLE IF EXISTS `users_photo`;

CREATE TABLE `users_photo` (
  `username` varchar(100) NOT NULL,
  `photo` text,
  `thumbnail` text,
  `updated_on` datetime NOT NULL,
  PRIMARY KEY (`username`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Data for the table `users_photo` */

insert  into `users_photo`(`username`,`photo`,`thumbnail`,`updated_on`) values ('administrator','ADMINISTRATOR.jpg','ADMINISTRATOR_thumb.jpg','2017-12-08 14:02:41');

/* Trigger structure for table `users` */

DELIMITER $$

/*!50003 DROP TRIGGER*//*!50032 IF EXISTS */ /*!50003 `after_users_insert` */$$

/*!50003 CREATE */ /*!50017 DEFINER = 'root'@'localhost' */ /*!50003 TRIGGER `after_users_insert` AFTER INSERT ON `users` FOR EACH ROW BEGIN
	INSERT INTO `arc_database`.users_photo VALUES( NEW.username, "no_picture.png", "no_picture.png", now());
    END */$$


DELIMITER ;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
