-- MySQL dump 10.13  Distrib 5.5.31, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: apttrackdb
-- ------------------------------------------------------
-- Server version	5.5.31-0ubuntu0.12.10.1

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
-- Table structure for table `account_status`
--

DROP TABLE IF EXISTS `account_status`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `account_status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(10) NOT NULL,
  `description` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `account_status`
--

LOCK TABLES `account_status` WRITE;
/*!40000 ALTER TABLE `account_status` DISABLE KEYS */;
INSERT INTO `account_status` VALUES (1,'ACTIVE','Current user able to login and use all system features.');
/*!40000 ALTER TABLE `account_status` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `account_type`
--

DROP TABLE IF EXISTS `account_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `account_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(10) NOT NULL,
  `description` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `account_type`
--

LOCK TABLES `account_type` WRITE;
/*!40000 ALTER TABLE `account_type` DISABLE KEYS */;
INSERT INTO `account_type` VALUES (1,'ADMIN','Administrative user with top-level privileges.'),(2,'NORMAL','Normal user with read/write privileges.');
/*!40000 ALTER TABLE `account_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `field`
--

DROP TABLE IF EXISTS `field`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `field` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `object` int(11) NOT NULL,
  `type` int(11) NOT NULL,
  `reference` varchar(50) NOT NULL,
  `query` text NOT NULL,
  `link_pre` varchar(30) DEFAULT NULL,
  `link_query` text,
  PRIMARY KEY (`id`),
  KEY `object` (`object`),
  KEY `type` (`type`),
  CONSTRAINT `field_ibfk_1` FOREIGN KEY (`object`) REFERENCES `object` (`id`),
  CONSTRAINT `field_ibfk_2` FOREIGN KEY (`type`) REFERENCES `field_type` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=58 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `field`
--

LOCK TABLES `field` WRITE;
/*!40000 ALTER TABLE `field` DISABLE KEYS */;
INSERT INTO `field` VALUES (1,3,1,'jobName','SELECT name as jobName FROM job WHERE id=','job.php?id=','SELECT id FROM job WHERE id='),(2,3,1,'jobOwner','SELECT CONCAT(user.forename, \' \', user.surname) as jobOwner FROM user, job WHERE job.owner=user.id AND job.id=','mailto:','SELECT email FROM user, job WHERE user.id=job.owner AND job.id='),(3,3,1,'jobStatus','SELECT status.name as jobStatus FROM status, job WHERE status.id=job.status AND job.id=','',''),(4,3,1,'jobStartDate','SELECT DATE_FORMAT(date_start, \'%d-%b-%y\') as jobStartDate FROM job WHERE id=','',''),(5,3,1,'jobEndDate','SELECT DATE_FORMAT(date_end, \'%d-%b-%y\') as jobEndDate FROM job WHERE id=','',''),(6,2,1,'projName','SELECT name as projName FROM project WHERE id=','project.php?id=','SELECT id FROM project WHERE id='),(7,2,1,'projDesc','SELECT description as projDesc FROM project WHERE id=','',''),(8,2,1,'projUpdated','SELECT DATE_FORMAT(updated, \'%d-%b-%y %H:%i\') as projUpdated FROM project WHERE id=','',''),(9,2,1,'projOwnerID','SELECT owner as projOwnerID FROM project WHERE id=','',''),(10,3,1,'jobDesc','SELECT description as jobDesc FROM job WHERE id=','',''),(11,3,1,'jobTypeID','SELECT type as jobTypeID FROM job WHERE id=','',''),(12,3,1,'jobUpdated','SELECT DATE_FORMAT(updated, \'%d-%b-%y %H:%i\') as jobUpdated FROM job WHERE id=','',''),(13,3,1,'jobOwnerID','SELECT owner as jobOwnerID FROM job WHERE id=','',''),(14,3,1,'jobStartDateNum','SELECT UNIX_TIMESTAMP(date_start) as jobStartDateNum FROM job WHERE id=','',''),(15,3,1,'jobEndDateNum','SELECT UNIX_TIMESTAMP(date_end) as jobEndDateNum FROM job WHERE id=','',''),(16,3,1,'jobCreatedNum','SELECT UNIX_TIMESTAMP(created) as jobCreatedNum FROM job WHERE id=','',''),(17,3,1,'jobUpdatedNum','SELECT UNIX_TIMESTAMP(updated) as jobUpdatedNum FROM job WHERE id=','',''),(18,3,1,'jobRecentComment','SELECT comment as jobRecentComment FROM (SELECT * FROM job_comment ORDER BY time DESC) as temp WHERE job=','',''),(19,2,1,'projRecentComment','SELECT comment as projRecentComment FROM (SELECT * FROM project_comment ORDER BY time DESC) as temp WHERE project=','',''),(20,2,1,'projStartDate','SELECT DATE_FORMAT(date_start, \'%d-%b-%y\') as projStartDate FROM project WHERE id=','',''),(21,2,1,'projEndDate','SELECT DATE_FORMAT(date_end, \'%d-%b-%y\') as projEndDate FROM project WHERE id=','',''),(22,2,1,'projStartDateNum','SELECT UNIX_TIMESTAMP(date_start) as projStartDateNum FROM project WHERE id=','',''),(23,2,1,'projEndDateNum','SELECT UNIX_TIMESTAMP(date_end) as projEndDateNum FROM project WHERE id=','',''),(24,2,1,'projUpdatedNum','SELECT UNIX_TIMESTAMP(updated) as projUpdatedNum FROM project WHERE id=','',''),(25,2,1,'projCreatedNum','SELECT UNIX_TIMESTAMP(created) as projCreatedNum FROM project WHERE id=','',''),(26,3,2,'jobTags','SELECT GROUP_CONCAT(tags.tag SEPARATOR \', \') as jobTags FROM tags, tag_job WHERE tag_job.tag=tags.id AND tag_job.job=','',''),(27,2,2,'projTags','SELECT GROUP_CONCAT(tags.tag SEPARATOR \', \') as projTags FROM tags, tag_project WHERE tag_project.tag=tags.id AND tag_project.project=','',''),(28,2,1,'projOwner','SELECT CONCAT(user.forename, \' \', user.surname) as projOwner FROM user, project WHERE project.owner=user.id AND project.id=','mailto:','SELECT email FROM user, project WHERE user.id=project.owner AND project.id='),(29,2,1,'projUpdaterID','SELECT updater as projUpdaterID FROM project WHERE id=','',''),(30,2,1,'projUpdater','SELECT CONCAT(user.forename, \' \', user.surname) as projUpdater FROM user, project WHERE project.updater=user.id AND project.id=','mailto:','SELECT email FROM user, project WHERE user.id=project.updater AND project.id='),(31,2,1,'projCreatorID','SELECT creator as projCreator FROM project WHERE id=','',''),(32,2,1,'projCreator','SELECT CONCAT(user.forename, \' \', user.surname) as projCreator FROM user, project WHERE project.creator=user.id AND project.id=','mailto:','SELECT email FROM user, project WHERE user.id=project.creator AND project.id='),(33,3,1,'jobUpdaterID','SELECT updater as jobUpdaterID FROM job WHERE id=','',''),(34,3,1,'jobCreatorID','SELECT creator as jobCreatorID FROM job WHERE id=','',''),(35,3,1,'jobUpdater','SELECT CONCAT(user.forename, \' \', user.surname) as jobUpdater FROM user, job WHERE job.updater=user.id AND job.id=','mailto:','SELECT email FROM user, job WHERE user.id=job.updater AND job.id='),(36,3,1,'jobCreator','SELECT CONCAT(user.forename, \' \', user.surname) as jobCreator FROM user, job WHERE job.creator=user.id AND job.id=','mailto:','SELECT email FROM user, job WHERE user.id=job.creator AND job.id='),(37,1,1,'userID','SELECT id as userID FROM user WHERE id=','',''),(38,1,1,'userTitle','SELECT titles.title as userTitle FROM titles, user WHERE titles.id=user.title AND user.id=','',''),(39,1,1,'userForename','SELECT forename as userForename FROM user WHERE id=','',''),(40,1,1,'userSurname','SELECT surname as userSurname FROM user WHERE id=','',''),(41,1,1,'userEmail','SELECT email as userEmail FROM user WHERE id=','mailto:','SELECT email FROM user WHERE id='),(42,1,1,'userCreated','SELECT DATE_FORMAT(created, \'%d-%b-%y %H:%i\') as userCreated FROM user WHERE id=','',''),(43,1,1,'userCreatedNum','SELECT UNIX_TIMESTAMP(created) as userCreatedNum FROM user WHERE id=','',''),(44,1,1,'userNumOwnedProj','SELECT count(*) as userNumOwnedProj FROM project WHERE owner=','',''),(45,1,1,'userNumOwnedTask','SELECT count(*) as userNumOwnedTask FROM job WHERE type=1 AND owner=','',''),(46,1,1,'userNumOwnedDeliv','SELECT count(*) as userNumOwnedDeliv FROM job WHERE type=2 AND owner=','',''),(47,1,1,'userFullName','SELECT CONCAT(forename, \' \', surname) as userFullName FROM user WHERE id=','mailto:','SELECT email FROM user WHERE id='),(48,1,1,'userFormalName','SELECT CONCAT(titles.title, \'. \', forename, \' \', surname) FROM titles, user WHERE titles.id=user.title AND user.id=','mailto:','SELECT email FROM user WHERE id='),(49,2,1,'projCreated','SELECT DATE_FORMAT(created, \'%d-%b-%y %H:%i\') as projCreated FROM project WHERE id=','',''),(50,2,1,'projStatus','SELECT status.name as projStatus FROM status, project WHERE status.id=project.status AND project.id=','',''),(51,2,1,'projVisib','SELECT visibility.name as projVisib FROM visibility, project WHERE visibility.id=project.visibility AND project.id=','',''),(52,2,1,'projHealth','SELECT health.name as projHealth FROM health, project WHERE health.id=project.health AND project.id=','',''),(53,2,1,'projPrior','SELECT priority.name as projPrior FROM priority, project WHERE priority.id=project.priority AND project.id=','',''),(54,3,1,'jobType','SELECT job_type.name as jobType FROM job_type, job WHERE job_type.id=job.type AND job.id=','',''),(55,3,1,'jobProject','SELECT project.name as jobProject FROM project, job WHERE project.id=job.project AND job.id=','',''),(56,3,1,'jobHealth','SELECT health.name as jobHealth FROM health, job WHERE health.id=job.health AND job.id=','',''),(57,3,1,'jobPrior','SELECT priorirty.name as jobPrior FROM priority, job WHERE priority.id=job.priority AND job.id=','','');
/*!40000 ALTER TABLE `field` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `field_type`
--

DROP TABLE IF EXISTS `field_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `field_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(6) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `field_type`
--

LOCK TABLES `field_type` WRITE;
/*!40000 ALTER TABLE `field_type` DISABLE KEYS */;
INSERT INTO `field_type` VALUES (1,'SINGLE'),(2,'LIST');
/*!40000 ALTER TABLE `field_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `health`
--

DROP TABLE IF EXISTS `health`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `health` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(5) NOT NULL,
  `description` text,
  `sort` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `health`
--

LOCK TABLES `health` WRITE;
/*!40000 ALTER TABLE `health` DISABLE KEYS */;
INSERT INTO `health` VALUES (1,'GREEN','Proceeding as intended.',1),(2,'AMBER','Minor setbacks experienced.',2),(3,'RED','Progress has been significantly delayed.',3);
/*!40000 ALTER TABLE `health` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job`
--

DROP TABLE IF EXISTS `job`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `job` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `description` text,
  `owner` int(11) DEFAULT NULL,
  `creator` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `date_start` date DEFAULT NULL,
  `date_end` date DEFAULT NULL,
  `updater` int(11) DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `project` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `type` int(11) DEFAULT NULL,
  `health` int(11) DEFAULT NULL,
  `priority` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `owner` (`owner`),
  KEY `creator` (`creator`),
  KEY `updater` (`updater`),
  KEY `project` (`project`),
  KEY `status` (`status`),
  KEY `type` (`type`),
  KEY `health` (`health`),
  KEY `priority` (`priority`),
  CONSTRAINT `job_ibfk_1` FOREIGN KEY (`owner`) REFERENCES `user` (`id`),
  CONSTRAINT `job_ibfk_2` FOREIGN KEY (`creator`) REFERENCES `user` (`id`),
  CONSTRAINT `job_ibfk_3` FOREIGN KEY (`updater`) REFERENCES `user` (`id`),
  CONSTRAINT `job_ibfk_4` FOREIGN KEY (`project`) REFERENCES `project` (`id`),
  CONSTRAINT `job_ibfk_5` FOREIGN KEY (`status`) REFERENCES `status` (`id`),
  CONSTRAINT `job_ibfk_6` FOREIGN KEY (`type`) REFERENCES `job_type` (`id`),
  CONSTRAINT `job_ibfk_7` FOREIGN KEY (`health`) REFERENCES `health` (`id`),
  CONSTRAINT `job_ibfk_8` FOREIGN KEY (`priority`) REFERENCES `priority` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job`
--

LOCK TABLES `job` WRITE;
/*!40000 ALTER TABLE `job` DISABLE KEYS */;
INSERT INTO `job` VALUES (1,'asd','',2,2,'2013-04-25 13:48:20','2013-04-25','0000-00-00',2,'2013-04-25 13:52:53',1,1,1,1,1),(2,NULL,NULL,3,3,'2013-04-28 16:35:17','2013-04-28',NULL,3,'2013-04-28 16:35:17',2,NULL,1,NULL,NULL),(3,NULL,NULL,3,3,'2013-04-28 16:38:04','2013-04-28',NULL,3,'2013-04-28 16:38:04',2,NULL,1,NULL,NULL),(4,NULL,NULL,3,3,'2013-04-28 16:38:09','2013-04-28',NULL,3,'2013-04-28 16:38:09',2,NULL,2,NULL,NULL),(5,'Tablet for Ellie','identify and buy new 7\" tablet for Ellie\'s birthday',4,4,'2013-04-29 18:12:11','2013-04-29','2013-06-25',4,'2013-04-29 18:12:58',4,2,1,1,1),(6,'Fix Garage Roof','',4,4,'2013-04-29 18:14:23','2013-04-29','2013-09-10',4,'2013-04-29 18:14:56',4,1,1,3,1),(7,'Fix fencing','Speak with Dan Burrows re garden fencing',4,4,'2013-04-29 18:15:54','2013-04-29','2103-05-02',4,'2013-04-29 18:16:41',4,1,1,1,2),(8,'Consolidated customer list ','Create single source of all BRM customers',4,4,'2013-04-29 18:20:12','2013-04-29','2103-05-02',4,'2013-04-29 18:20:53',5,2,1,2,1),(9,'Identify top 20 BRM reference customers ','Find who the top 20 referencable BRM customers are',4,4,'2013-04-29 18:21:38','2013-04-29','2013-05-02',4,'2013-04-29 18:25:22',5,2,1,1,1),(10,'Identify co-presenting company for m2m webinar','Hughes telematics, Aspider Solutions',4,4,'2013-04-29 18:25:50','2013-04-29','2013-05-02',4,'2013-04-29 18:26:38',6,2,1,3,1),(11,'Speak with Cheng Kiam Khor','Speak with Cheng - main IBU contact',4,4,'2013-04-29 18:27:43','2013-04-29','2013-05-02',4,'2013-04-29 18:28:22',6,2,1,1,1),(12,NULL,NULL,5,5,'2013-04-29 23:03:12','2013-04-29',NULL,5,'2013-04-29 23:03:12',7,NULL,2,NULL,NULL),(13,'Set up Meeting with Jerry','',4,4,'2013-04-30 15:07:58','2013-04-30','2013-05-03',4,'2013-04-30 15:08:55',5,2,1,1,1),(14,'Who owns ECE?','',4,4,'2013-04-30 15:16:56','2013-04-30','0000-00-00',4,'2013-04-30 15:17:16',8,1,1,3,1),(15,'Who owns Digital Commerce?','',4,4,'2013-04-30 15:17:26','2013-04-30','0000-00-00',4,'2013-04-30 15:19:55',8,1,1,3,1),(16,'What is my involvment with IPC?','',4,4,'2013-04-30 15:20:47','2013-04-30','0000-00-00',4,'2013-04-30 15:31:32',8,1,1,3,1),(17,'Send email to Venkat re sales training','',4,4,'2013-04-30 15:55:48','2013-04-30','2013-05-31',4,'2013-04-30 15:56:55',9,1,1,3,1);
/*!40000 ALTER TABLE `job` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_comment`
--

DROP TABLE IF EXISTS `job_comment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `job_comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `comment` text NOT NULL,
  `user` int(11) NOT NULL,
  `time` datetime NOT NULL,
  `job` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user` (`user`),
  KEY `job` (`job`),
  CONSTRAINT `job_comment_ibfk_1` FOREIGN KEY (`user`) REFERENCES `user` (`id`),
  CONSTRAINT `job_comment_ibfk_2` FOREIGN KEY (`job`) REFERENCES `job` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_comment`
--

LOCK TABLES `job_comment` WRITE;
/*!40000 ALTER TABLE `job_comment` DISABLE KEYS */;
INSERT INTO `job_comment` VALUES (1,'provisional time of 9am Wednesday ',4,'2013-04-30 15:07:26',11),(2,'wait until half term - tablet not currently available \'in store\' so we cant see it',4,'2013-04-30 15:09:38',5),(3,'Maybe ask Dan Burrows to do thsi as well',4,'2013-04-30 15:10:26',6),(4,'spoke to Dan this evening',4,'2013-04-30 20:35:15',6),(5,'spoke to Dan this evening',4,'2013-04-30 20:35:22',6);
/*!40000 ALTER TABLE `job_comment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_link`
--

DROP TABLE IF EXISTS `job_link`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `job_link` (
  `aid` int(11) NOT NULL,
  `bid` int(11) NOT NULL,
  `linker` int(11) NOT NULL,
  `linked` datetime NOT NULL,
  PRIMARY KEY (`aid`,`bid`),
  KEY `bid` (`bid`),
  KEY `linker` (`linker`),
  CONSTRAINT `job_link_ibfk_1` FOREIGN KEY (`aid`) REFERENCES `job` (`id`),
  CONSTRAINT `job_link_ibfk_2` FOREIGN KEY (`bid`) REFERENCES `job` (`id`),
  CONSTRAINT `job_link_ibfk_3` FOREIGN KEY (`linker`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_link`
--

LOCK TABLES `job_link` WRITE;
/*!40000 ALTER TABLE `job_link` DISABLE KEYS */;
INSERT INTO `job_link` VALUES (6,7,4,'2013-04-30 20:40:10');
/*!40000 ALTER TABLE `job_link` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_type`
--

DROP TABLE IF EXISTS `job_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `job_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_type`
--

LOCK TABLES `job_type` WRITE;
/*!40000 ALTER TABLE `job_type` DISABLE KEYS */;
INSERT INTO `job_type` VALUES (1,'task'),(2,'deliverable');
/*!40000 ALTER TABLE `job_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `object`
--

DROP TABLE IF EXISTS `object`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `object` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(15) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `object`
--

LOCK TABLES `object` WRITE;
/*!40000 ALTER TABLE `object` DISABLE KEYS */;
INSERT INTO `object` VALUES (1,'USER'),(2,'PROJECT'),(3,'JOB');
/*!40000 ALTER TABLE `object` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `priority`
--

DROP TABLE IF EXISTS `priority`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `priority` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(7) NOT NULL,
  `sort` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `priority`
--

LOCK TABLES `priority` WRITE;
/*!40000 ALTER TABLE `priority` DISABLE KEYS */;
INSERT INTO `priority` VALUES (1,'HIGH',NULL),(2,'MEDIUM',NULL),(3,'LOW',NULL);
/*!40000 ALTER TABLE `priority` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `project`
--

DROP TABLE IF EXISTS `project`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `project` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `description` text,
  `owner` int(11) DEFAULT NULL,
  `creator` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `date_start` date DEFAULT NULL,
  `date_end` date DEFAULT NULL,
  `updater` int(11) DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `visibility` int(11) DEFAULT NULL,
  `health` int(11) DEFAULT NULL,
  `priority` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `owner` (`owner`),
  KEY `creator` (`creator`),
  KEY `updater` (`updater`),
  KEY `status` (`status`),
  KEY `visibility` (`visibility`),
  KEY `health` (`health`),
  KEY `priority` (`priority`),
  CONSTRAINT `project_ibfk_1` FOREIGN KEY (`owner`) REFERENCES `user` (`id`),
  CONSTRAINT `project_ibfk_2` FOREIGN KEY (`creator`) REFERENCES `user` (`id`),
  CONSTRAINT `project_ibfk_3` FOREIGN KEY (`updater`) REFERENCES `user` (`id`),
  CONSTRAINT `project_ibfk_4` FOREIGN KEY (`status`) REFERENCES `status` (`id`),
  CONSTRAINT `project_ibfk_5` FOREIGN KEY (`visibility`) REFERENCES `visibility` (`id`),
  CONSTRAINT `project_ibfk_6` FOREIGN KEY (`health`) REFERENCES `health` (`id`),
  CONSTRAINT `project_ibfk_7` FOREIGN KEY (`priority`) REFERENCES `priority` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `project`
--

LOCK TABLES `project` WRITE;
/*!40000 ALTER TABLE `project` DISABLE KEYS */;
INSERT INTO `project` VALUES (1,'new project','new project',2,2,'2013-04-25 13:48:12','2013-04-25','0000-00-00',2,'2013-04-25 13:48:18',1,1,1,1),(2,'Test 1','A description',3,3,'2013-04-28 16:34:45','2013-04-28','2013-04-29',3,'2013-04-28 16:35:04',1,1,1,1),(3,'Skype Bot','More soon.',2,2,'2013-04-28 16:42:29','2013-05-04','0000-00-00',2,'2013-04-28 16:43:01',1,2,2,3),(4,'Home \'to-dos\'','Managing and Keeping track of all those home things',4,4,'2013-04-29 18:10:01','2013-04-29','2013-05-30',4,'2013-04-30 20:37:07',2,2,1,1),(5,'Manage BRM collateral','Ensure BRM collateral is maintained for different projects and HUB reflects all changes',4,4,'2013-04-29 18:17:20','2013-04-29','0000-00-00',4,'2013-04-30 12:48:54',2,3,2,1),(6,'M2M webinar','prepare for m2m webinar at end of month',4,4,'2013-04-29 18:24:04','2013-04-29','2013-05-29',4,'2013-04-29 18:24:42',2,3,2,1),(7,'Sample','A description of my project',5,5,'2013-04-29 23:02:22','2013-04-29','0000-00-00',5,'2013-04-29 23:02:49',1,1,1,3),(8,'Clarify work tasks/ deliverables with new Manager','',4,4,'2013-04-30 15:16:09','2013-04-30','0000-00-00',4,'2013-04-30 15:20:36',1,1,3,1),(9,'Sales Training - June ','What is my involvement in these sessions?',4,4,'2013-04-30 15:49:31','2013-04-30','2013-05-31',4,'2013-04-30 15:51:15',1,3,1,1);
/*!40000 ALTER TABLE `project` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `project_comment`
--

DROP TABLE IF EXISTS `project_comment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `project_comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `comment` text NOT NULL,
  `user` int(11) NOT NULL,
  `time` datetime NOT NULL,
  `project` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user` (`user`),
  KEY `project` (`project`),
  CONSTRAINT `project_comment_ibfk_1` FOREIGN KEY (`user`) REFERENCES `user` (`id`),
  CONSTRAINT `project_comment_ibfk_2` FOREIGN KEY (`project`) REFERENCES `project` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `project_comment`
--

LOCK TABLES `project_comment` WRITE;
/*!40000 ALTER TABLE `project_comment` DISABLE KEYS */;
INSERT INTO `project_comment` VALUES (1,'receibved email from Venkat suggesting i should no longer do this - await further instruction ',4,'2013-04-30 15:06:55',6);
/*!40000 ALTER TABLE `project_comment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `project_user`
--

DROP TABLE IF EXISTS `project_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `project_user` (
  `project` int(11) NOT NULL,
  `user` int(11) NOT NULL,
  `since` datetime NOT NULL,
  `can_edit` int(11) NOT NULL,
  PRIMARY KEY (`project`,`user`),
  KEY `user` (`user`),
  CONSTRAINT `project_user_ibfk_1` FOREIGN KEY (`project`) REFERENCES `project` (`id`),
  CONSTRAINT `project_user_ibfk_2` FOREIGN KEY (`user`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `project_user`
--

LOCK TABLES `project_user` WRITE;
/*!40000 ALTER TABLE `project_user` DISABLE KEYS */;
INSERT INTO `project_user` VALUES (4,2,'2013-04-30 20:37:37',1);
/*!40000 ALTER TABLE `project_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `report`
--

DROP TABLE IF EXISTS `report`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `report` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) DEFAULT NULL,
  `instructions` text,
  `creator` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `object` int(11) NOT NULL,
  `gen_count` int(11) NOT NULL,
  `title` varchar(20) DEFAULT NULL,
  `description` text,
  PRIMARY KEY (`id`),
  KEY `creator` (`creator`),
  KEY `object` (`object`),
  CONSTRAINT `report_ibfk_1` FOREIGN KEY (`creator`) REFERENCES `user` (`id`),
  CONSTRAINT `report_ibfk_2` FOREIGN KEY (`object`) REFERENCES `object` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `report`
--

LOCK TABLES `report` WRITE;
/*!40000 ALTER TABLE `report` DISABLE KEYS */;
INSERT INTO `report` VALUES (1,'Overdue Tasks','test report',1,'2013-04-24 16:45:45',3,1,'Overdue Tasks','Incomplete tasks that are past their due date.'),(2,'My Projects','test report',1,'2013-04-24 16:45:45',2,112,'My Projects','Projects owned by the currently logged in user.'),(3,'Project Tasks','Report to show tasks belonging to project.',1,'2013-04-24 16:45:45',3,73,'Tasks','Tasks belonging to the current project.'),(4,'Project Deliverables','Report to show deliverables belonging to project.',1,'2013-04-24 16:45:45',3,73,'Deliverables','Deliverables belonging to the current project.'),(5,'My Tasks','test report',1,'2013-04-24 16:45:45',3,54,'My Tasks','Tasks owned by the currently logged in user.'),(6,'My Deliverables','test report',1,'2013-04-24 16:45:45',3,53,'My Deliverables','Deliverables owned by the currently logged in user.'),(7,'fg','dfg',2,'2013-04-25 15:24:07',3,10,'dfg','dfg'),(8,'Graham\'s Task Report','List of tasks with projects and tags',4,'2013-04-30 15:25:00',3,26,'GCC Task report','');
/*!40000 ALTER TABLE `report` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `report_field`
--

DROP TABLE IF EXISTS `report_field`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `report_field` (
  `report` int(11) NOT NULL,
  `field` int(11) NOT NULL,
  `label` varchar(20) NOT NULL,
  `visible` int(11) NOT NULL DEFAULT '0',
  `sort` int(11) NOT NULL DEFAULT '0',
  `criteria` varchar(20) DEFAULT NULL,
  `position` int(11) NOT NULL,
  PRIMARY KEY (`report`,`field`),
  KEY `field` (`field`),
  CONSTRAINT `report_field_ibfk_1` FOREIGN KEY (`report`) REFERENCES `report` (`id`),
  CONSTRAINT `report_field_ibfk_2` FOREIGN KEY (`field`) REFERENCES `field` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `report_field`
--

LOCK TABLES `report_field` WRITE;
/*!40000 ALTER TABLE `report_field` DISABLE KEYS */;
INSERT INTO `report_field` VALUES (1,1,'Name',1,1,'',1),(1,2,'Owner',1,0,'',4),(1,3,'Status',1,0,'EQ::CURRENT',3),(1,4,'Start Date',1,0,'',5),(1,5,'End Date',1,0,'LT::||now||',6),(1,10,'Description',1,0,'',2),(1,11,'Type',0,0,'EQ::1',0),(2,6,'Name',1,0,'',1),(2,7,'Description',1,0,'',2),(2,8,'Last updated',1,-1,'',3),(2,9,'OwnerID',0,0,'EQ::||me.id||',0),(3,1,'Name',1,0,'',1),(3,2,'Owner',1,0,'',4),(3,10,'Description',1,0,'',2),(3,11,'Type',0,0,'EQ::1',0),(3,12,'Updated',1,0,'',3),(4,1,'Name',1,0,'',1),(4,2,'Owner',1,0,'',4),(4,10,'Description',1,0,'',2),(4,11,'Type',0,0,'EQ::2',0),(4,12,'Updated',1,0,'',3),(5,1,'Name',1,0,'',1),(5,10,'Description',1,0,'',2),(5,11,'Type',0,0,'EQ::1',0),(5,12,'Updated',1,0,'',3),(5,13,'OwnerID',0,0,'EQ::||me.id||',0),(6,1,'Name',1,0,'',1),(6,10,'Description',1,0,'',2),(6,11,'Type',0,0,'EQ::2',0),(6,12,'Updated',1,0,'',3),(6,13,'OwnerID',0,0,'EQ::||me.id||',0),(7,1,'name',1,0,'',1),(7,2,'owner',1,0,'--',3),(7,11,'Type',0,0,'EQ::1',0),(7,55,'project',1,0,'--',2),(8,1,'Description',1,0,'',3),(8,2,'',0,0,'',0),(8,3,'Status',1,0,'',5),(8,11,'Type',0,0,'EQ::1',0),(8,13,'',0,0,'EQ::||me.id||',0),(8,26,'TAG',1,0,'',4),(8,36,'Creator',1,0,'',1),(8,55,'Project',1,0,'',2),(8,56,'Health',1,-1,'',6);
/*!40000 ALTER TABLE `report_field` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `status`
--

DROP TABLE IF EXISTS `status`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(10) NOT NULL,
  `description` text,
  `sort` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `status`
--

LOCK TABLES `status` WRITE;
/*!40000 ALTER TABLE `status` DISABLE KEYS */;
INSERT INTO `status` VALUES (1,'PENDING','Will begin in the future.',1),(2,'CURRENT','Currently in progress.',2),(3,'COMPLETE','100% complete.',3),(4,'CLOSED','Closed before completion.',4);
/*!40000 ALTER TABLE `status` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tag_job`
--

DROP TABLE IF EXISTS `tag_job`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tag_job` (
  `job` int(11) NOT NULL,
  `tag` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `user` int(11) NOT NULL,
  PRIMARY KEY (`job`,`tag`),
  KEY `tag` (`tag`),
  KEY `user` (`user`),
  CONSTRAINT `tag_job_ibfk_1` FOREIGN KEY (`job`) REFERENCES `job` (`id`),
  CONSTRAINT `tag_job_ibfk_2` FOREIGN KEY (`tag`) REFERENCES `tags` (`id`),
  CONSTRAINT `tag_job_ibfk_3` FOREIGN KEY (`user`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tag_job`
--

LOCK TABLES `tag_job` WRITE;
/*!40000 ALTER TABLE `tag_job` DISABLE KEYS */;
INSERT INTO `tag_job` VALUES (1,1,'2013-04-25 21:13:48',2),(6,2,'2013-04-29 18:15:20',4),(6,3,'2013-04-29 18:15:32',4),(7,3,'2013-04-29 18:17:08',4),(8,4,'2013-04-29 18:21:18',4),(9,4,'2013-04-29 18:23:37',4),(14,5,'2013-04-30 15:18:38',4),(15,5,'2013-04-30 15:19:07',4),(16,5,'2013-04-30 15:22:43',4),(17,5,'2013-04-30 15:57:15',4);
/*!40000 ALTER TABLE `tag_job` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tag_project`
--

DROP TABLE IF EXISTS `tag_project`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tag_project` (
  `project` int(11) NOT NULL,
  `tag` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `user` int(11) NOT NULL,
  PRIMARY KEY (`project`,`tag`),
  KEY `tag` (`tag`),
  KEY `user` (`user`),
  CONSTRAINT `tag_project_ibfk_1` FOREIGN KEY (`project`) REFERENCES `project` (`id`),
  CONSTRAINT `tag_project_ibfk_2` FOREIGN KEY (`tag`) REFERENCES `tags` (`id`),
  CONSTRAINT `tag_project_ibfk_3` FOREIGN KEY (`user`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tag_project`
--

LOCK TABLES `tag_project` WRITE;
/*!40000 ALTER TABLE `tag_project` DISABLE KEYS */;
INSERT INTO `tag_project` VALUES (4,2,'2013-04-29 18:14:01',4),(5,4,'2013-04-29 18:20:06',4),(9,5,'2013-04-30 15:51:46',4);
/*!40000 ALTER TABLE `tag_project` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tags`
--

DROP TABLE IF EXISTS `tags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tags` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tag` varchar(20) NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tags`
--

LOCK TABLES `tags` WRITE;
/*!40000 ALTER TABLE `tags` DISABLE KEYS */;
INSERT INTO `tags` VALUES (1,'test-tag','2013-04-25 21:13:48'),(2,'personal','2013-04-29 18:14:01'),(3,'garden','2013-04-29 18:15:32'),(4,'BRM','2013-04-29 18:20:05'),(5,'Venkat','2013-04-30 15:18:38');
/*!40000 ALTER TABLE `tags` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `titles`
--

DROP TABLE IF EXISTS `titles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `titles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `titles`
--

LOCK TABLES `titles` WRITE;
/*!40000 ALTER TABLE `titles` DISABLE KEYS */;
INSERT INTO `titles` VALUES (1,'Mr'),(2,'Miss'),(3,'Mrs'),(4,'Ms'),(5,'Dr');
/*!40000 ALTER TABLE `titles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` int(11) NOT NULL,
  `forename` varchar(20) NOT NULL,
  `surname` varchar(30) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(32) NOT NULL,
  `identifier` varchar(32) DEFAULT NULL,
  `login_token` varchar(32) DEFAULT NULL,
  `login_timeout` int(11) DEFAULT NULL,
  `account_status` int(11) NOT NULL,
  `account_type` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `last_login` datetime NOT NULL,
  `prev_login` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `title` (`title`),
  KEY `account_status` (`account_status`),
  KEY `account_type` (`account_type`),
  CONSTRAINT `user_ibfk_1` FOREIGN KEY (`title`) REFERENCES `titles` (`id`),
  CONSTRAINT `user_ibfk_2` FOREIGN KEY (`account_status`) REFERENCES `account_status` (`id`),
  CONSTRAINT `user_ibfk_3` FOREIGN KEY (`account_type`) REFERENCES `account_type` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,1,'Administrative','User','k0909651@kingston.ac.uk','5f4dcc3b5aa765d61d8327deb882cf99',NULL,'logged out',0,1,1,'0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00'),(2,1,'Robert','Carey','robert.carey@mail.com','5f4dcc3b5aa765d61d8327deb882cf99','f9c065d76b24fc6b4a94e5eae941fb65','75bf4e70204da9d7a8ab1a8bfbda5c76',1367498886,1,2,'2013-04-25 13:47:58','2013-04-30 20:23:12','2013-04-30 12:46:52'),(3,5,'Paul','L','test1@example.com','202cb962ac59075b964b07152d234b70','34c9b32542c084e28ee9e56d903f29c6','9c9105c659886d3f762528a0abd9ee97',1367768077,1,2,'2013-04-28 16:34:28','2013-04-28 16:34:37','0000-00-00 00:00:00'),(4,5,'Graham','Carey','graham.carey@btinternet.com','82bea07ea455e774bf1e93ad75df9ac1','90f775fa2e2cd0fd2866551804158461','logged out',0,1,2,'2013-04-29 18:09:27','2013-04-30 20:24:55','2013-04-30 15:06:14'),(5,1,'Patrick','Magee','patrick.magee@live.co.uk','c822c1b63853ed273b89687ac505f9fa','222d837d9cbabb4ac42f91e474f6e215','4b56f90d91dfdef55ee67152570fcb90',1367877733,1,2,'2013-04-29 23:01:52','2013-04-29 23:02:13','0000-00-00 00:00:00');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `visibility`
--

DROP TABLE IF EXISTS `visibility`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `visibility` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(10) NOT NULL,
  `description` text,
  `sort` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `visibility`
--

LOCK TABLES `visibility` WRITE;
/*!40000 ALTER TABLE `visibility` DISABLE KEYS */;
INSERT INTO `visibility` VALUES (1,'PRIVATE','Project is only visible only to owner.',1),(2,'CLOSED','Project is only visible to specified users.',2),(3,'OPEN','Project is visible to all users.',3);
/*!40000 ALTER TABLE `visibility` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2013-04-30 21:12:40
