/*
SQLyog Ultimate v10.00 Beta1
MySQL - 5.5.5-10.1.31-MariaDB : Database - newvista_db
*********************************************************************
*/



USE `newvistaacademy_dbadm`;

/*Table structure for table `vendor_master` */

DROP TABLE IF EXISTS `vendor_master`;

CREATE TABLE `vendor_master` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `address` varchar(225) DEFAULT NULL,
  `gst_no` varchar(50) DEFAULT NULL,
  `contact_no` varchar(10) DEFAULT NULL,
  `contact_persone` varchar(50) DEFAULT NULL,
  `state_id` int(10) DEFAULT NULL,
  `account_master_id` int(10) DEFAULT NULL,
  `is_active` enum('Y','N') DEFAULT NULL,
  `create_dt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
