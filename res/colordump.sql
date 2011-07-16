-- MySQL dump 10.13  Distrib 5.1.41, for debian-linux-gnu (i486)
--
-- Host: localhost    Database: color
-- ------------------------------------------------------
-- Server version	5.1.41-3ubuntu12.10

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Current Database: `color`
--

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `color` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `color`;

--
-- Table structure for table `threads`
--

DROP TABLE IF EXISTS `threads`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `threads` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `num_turns` int(2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `threads`
--

LOCK TABLES `threads` WRITE;
/*!40000 ALTER TABLE `threads` DISABLE KEYS */;
INSERT INTO `threads` VALUES (1,1),(2,10),(3,6),(4,1),(5,1),(6,1),(7,10),(8,1);
/*!40000 ALTER TABLE `threads` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `turns`
--

DROP TABLE IF EXISTS `turns`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `turns` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(255) NOT NULL,
  `thread_id` int(11) NOT NULL,
  `turn_number` int(2) NOT NULL,
  `content` varchar(255) NOT NULL,
  `type` enum('sentence','url') NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `thread_id` (`thread_id`),
  CONSTRAINT `turns_ibfk_1` FOREIGN KEY (`thread_id`) REFERENCES `threads` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `turns`
--

LOCK TABLES `turns` WRITE;
/*!40000 ALTER TABLE `turns` DISABLE KEYS */;
INSERT INTO `turns` VALUES (2,'0',2,1,'this is a sentence','sentence','2011-07-16 06:28:47'),(14,'0',2,2,'userimages/2_2.png','url','2011-07-16 10:36:33'),(15,'0',2,2,'A picture','url','2011-07-16 10:37:28'),(16,'0',2,3,'A picture','sentence','2011-07-16 10:43:03'),(17,'0',2,4,'userimages/2_16.png','url','2011-07-16 10:43:13'),(18,'0',2,5,'Nothing','sentence','2011-07-16 10:43:19'),(19,'0',2,6,'userimages/2_18.png','url','2011-07-16 10:43:26'),(20,'0',2,7,'Scribble','sentence','2011-07-16 10:43:33'),(21,'0',2,8,'userimages/2_20.png','url','2011-07-16 10:43:52'),(22,'0',2,9,'This might actually be working!','sentence','2011-07-16 10:44:03'),(23,'0',3,1,'your eyes are redder than a tomato!','sentence','2011-07-16 10:48:17'),(24,'0',4,1,'your eyes are redder than a tomato!','sentence','2011-07-16 10:48:27'),(25,'0',5,1,'When Golf plays with himself its a hole in one!','sentence','2011-07-16 10:50:17'),(26,'0',6,1,'This is a test thread','sentence','2011-07-16 10:50:57'),(27,'0',7,1,'Leslie is a beyond black belt code ninja warrior.','sentence','2011-07-16 10:51:47'),(28,'0',7,2,'userimages/7_27.png','url','2011-07-16 10:54:19'),(29,'0',7,3,'Girl on laptop is man on cactus fire','sentence','2011-07-16 10:55:11'),(30,'0',7,4,'userimages/7_29.png','url','2011-07-16 11:11:05'),(31,'0',7,5,'Scribble','sentence','2011-07-16 11:11:10'),(32,'0',7,6,'userimages/7_31.png','url','2011-07-16 11:11:15'),(33,'0',7,7,'Another scribble','sentence','2011-07-16 11:11:21'),(34,'0',7,8,'userimages/7_33.png','url','2011-07-16 11:11:52'),(35,'0',7,9,'sdfhadjfnf','sentence','2011-07-16 11:11:57'),(36,'0',7,10,'userimages/7_35.png','url','2011-07-16 11:12:03'),(37,'0',8,1,'','sentence','2011-07-16 13:09:02'),(38,'0',3,2,'userimages/3_23.png','url','2011-07-16 13:43:35'),(39,'0',3,3,'userimages/3_23.png','sentence','2011-07-16 13:44:07'),(40,'0',3,4,'userimages/3_23.png','url','2011-07-16 13:44:44'),(41,'0',3,5,'An abstract work of art.','sentence','2011-07-16 14:26:36'),(42,'0',3,6,'userimages/3_41.png','url','2011-07-16 16:20:24');
/*!40000 ALTER TABLE `turns` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2011-07-16  9:55:42
