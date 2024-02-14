-- MySQL dump 10.13  Distrib 8.0.19, for Win64 (x86_64)
--
-- Host: localhost    Database: trailanalytics
-- ------------------------------------------------------
-- Server version	5.5.5-10.4.27-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `attachments`
--

DROP TABLE IF EXISTS `attachments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `attachments` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `feature_id` varchar(255) NOT NULL,
  `subject_id` int(100) DEFAULT NULL,
  `feature_type` varchar(100) NOT NULL,
  `filename` varchar(100) NOT NULL,
  `caption` varchar(100) DEFAULT NULL,
  `file_link` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL,
  `flag` tinyint(1) NOT NULL DEFAULT 1,
  `creator_id` int(100) NOT NULL DEFAULT 10101,
  `branch_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `attachments`
--

LOCK TABLES `attachments` WRITE;
/*!40000 ALTER TABLE `attachments` DISABLE KEYS */;
INSERT INTO `attachments` VALUES (7,'8',2,'png','ATTACHED-231206124040-1.png','Caption Edit',NULL,'2023-12-06 09:40:40','2023-12-11 16:20:55',NULL,1,1,NULL),(33,'7',1,'png','ATTACHED-231206142733-1.png','','','2023-12-06 11:27:33','2023-12-11 16:20:55',NULL,1,1,NULL),(34,'7',3,'link','ATTACHED-231206142833','Added Video','<iframe width=\"560\" height=\"315\" src=\"https://www.youtube.com/embed/HmT1Rkb57rs?si=gg9YlOtDHuHaqSt2\" title=\"YouTube video player\" frameborder=\"0\" allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share\" allowfullscreen></iframe>','2023-12-06 11:28:33','2023-12-11 16:20:55',NULL,1,1,NULL),(36,'9',1,'link','ATTACHED-231211100202','English Video','<iframe width=\"560\" height=\"315\" src=\"https://www.youtube.com/embed/NQmuywW-qTc?si=dOubGW6lrZtnWelY\" title=\"YouTube video player\" frameborder=\"0\" allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share\" allowfullscreen></iframe>','2023-12-11 07:02:02','2023-12-11 13:16:42',NULL,1,1,NULL),(37,'9',1,'pdf','ATTACHED-231211113323-1.pdf','English Video',NULL,'2023-12-11 08:33:23','2023-12-11 14:34:48',NULL,1,1,NULL),(38,'9',1,'jpeg','ATTACHED-231211113323-2.jpeg','English Video',NULL,'2023-12-11 08:33:23','2023-12-11 14:34:48',NULL,1,1,NULL),(39,'9',1,'png','ATTACHED-231211113323-3.png','English Video',NULL,'2023-12-11 08:33:23','2023-12-11 14:34:48',NULL,1,1,NULL),(40,'10',3,'link','ATTACHED-231211131325','Higher planning','<iframe width=\"560\" height=\"315\" src=\"https://www.youtube.com/embed/HXv_Gx_U18s?si=CtF6TKWiYKEIHCxj\" title=\"YouTube video player\" frameborder=\"0\" allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share\" allowfullscreen></iframe>\n<iframe width=\"560\" height=\"315\" src=\"https://www.youtube.com/embed/-OP1AIpIIAQ?si=iXRgY8X2ZuaIp81f\" title=\"YouTube video player\" frameborder=\"0\" allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share\" allowfullscreen></iframe>','2023-12-11 10:13:25','2023-12-11 17:06:24',NULL,1,1,NULL),(41,'11',5,'link','ATTACHED-231218094752','Early Childhood care Beginners\' Level1','<iframe width=\"560\" height=\"315\" src=\"https://www.youtube.com/embed/yJtRitVKsaY?si=E1qLwX20PJLuRPeZ\" title=\"YouTube video player\" frameborder=\"0\" allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share\" allowfullscreen></iframe>','2023-12-18 06:47:52',NULL,NULL,1,1,NULL);
/*!40000 ALTER TABLE `attachments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `clocking`
--

DROP TABLE IF EXISTS `clocking`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `clocking` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `time_in` timestamp NOT NULL DEFAULT current_timestamp(),
  `time_out` timestamp NULL DEFAULT NULL,
  `user_id` int(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL,
  `flag` tinyint(1) NOT NULL DEFAULT 1,
  `creator_id` int(100) NOT NULL DEFAULT 10101,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `clocking`
--

LOCK TABLES `clocking` WRITE;
/*!40000 ALTER TABLE `clocking` DISABLE KEYS */;
INSERT INTO `clocking` VALUES (2,'2024-02-09 16:52:17','2024-02-09 17:13:05',1,'2024-02-09 16:52:17','2024-02-09 20:13:05',NULL,1,10101),(3,'2024-02-09 17:01:38','2024-02-09 17:13:05',1,'2024-02-09 17:01:38','2024-02-09 20:13:05',NULL,1,10101),(4,'2024-02-09 17:23:56','2024-02-09 17:25:10',1,'2024-02-09 17:23:56','2024-02-09 20:25:10',NULL,1,10101),(5,'2024-02-09 17:26:14','2024-02-12 10:45:47',1,'2024-02-09 17:26:14','2024-02-12 13:45:47',NULL,1,10101),(6,'2024-02-12 09:40:17','2024-02-12 10:45:47',1,'2024-02-12 09:40:17','2024-02-12 13:45:47',NULL,1,10101),(7,'2024-02-12 10:22:07','2024-02-12 10:42:57',3,'2024-02-12 10:22:07','2024-02-12 13:42:57',NULL,1,10101),(8,'2024-02-12 10:43:27','2024-02-12 10:44:23',3,'2024-02-12 10:43:27','2024-02-12 13:44:23',NULL,1,10101),(9,'2024-02-12 10:44:55',NULL,3,'2024-02-12 10:44:55','2024-02-12 13:44:55',NULL,1,10101),(10,'2024-02-12 14:29:29','2024-02-12 16:15:55',4,'2024-02-12 14:29:29','2024-02-12 19:15:55',NULL,1,10101),(11,'2024-02-12 16:14:18','2024-02-12 16:14:46',5,'2024-02-12 16:14:18','2024-02-12 19:14:46',NULL,1,10101),(12,'2024-02-13 16:39:51',NULL,14,'2024-02-13 16:39:51','2024-02-13 19:39:51',NULL,1,10101);
/*!40000 ALTER TABLE `clocking` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `familymembers`
--

DROP TABLE IF EXISTS `familymembers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `familymembers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `FirstName` varchar(100) DEFAULT NULL,
  `LastName` varchar(100) DEFAULT NULL,
  `Gender` varchar(100) DEFAULT NULL,
  `DateOfBirth` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `familymembers`
--

LOCK TABLES `familymembers` WRITE;
/*!40000 ALTER TABLE `familymembers` DISABLE KEYS */;
INSERT INTO `familymembers` VALUES (1,'Martin','Muwanguzi','Male','1975-08-10'),(2,'Sandra','Muwanguzi','Female','1981-02-11'),(3,'Samantha','Muwanguzi','Female','2004-01-12'),(4,'Tony','Muwanguzi','Male','2006-03-17'),(5,'Timothy','Muwanguzi','Male','2008-03-19'),(6,'Catherine','Muwanguzi','Female','2010-05-21'),(7,'Cynthia','Muwanguzi','Female','2014-09-10');
/*!40000 ALTER TABLE `familymembers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2014_10_12_000000_create_users_table',1),(2,'2014_10_12_100000_create_password_resets_table',1),(3,'2019_08_19_000000_create_failed_jobs_table',1),(4,'2019_12_14_000001_create_personal_access_tokens_table',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_resets`
--

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personal_access_tokens`
--

LOCK TABLES `personal_access_tokens` WRITE;
/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `preferredmovies`
--

DROP TABLE IF EXISTS `preferredmovies`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `preferredmovies` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userID` int(11) DEFAULT NULL,
  `PreferredMovie` varchar(100) DEFAULT NULL,
  `TypeOfMovie` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `preferredmovies`
--

LOCK TABLES `preferredmovies` WRITE;
/*!40000 ALTER TABLE `preferredmovies` DISABLE KEYS */;
INSERT INTO `preferredmovies` VALUES (1,1,'Kingsman','Action'),(2,1,'The Lego Movie','Animation'),(3,1,'Batman vs Superman','Action'),(4,2,'Flatliners','Thriller'),(5,2,'Battle of the Sexes','Drama'),(6,2,'Mother','Drama'),(7,2,'American Made','Drama'),(8,2,'Wonder Woman','Action'),(9,3,'The Lego Movie','Animation'),(10,3,'Beauty and the Beast','Animation'),(11,4,'Kingsman','Action'),(12,5,'The Lego Movie','Animation'),(13,5,'Batman vs Superman','Action'),(14,5,'Guardians of the Galaxy','Action'),(15,6,'Mother','Drama');
/*!40000 ALTER TABLE `preferredmovies` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `setup_menu_main`
--

DROP TABLE IF EXISTS `setup_menu_main`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `setup_menu_main` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `url` varchar(100) DEFAULT NULL,
  `orders` int(11) DEFAULT 1,
  `icon` varchar(255) NOT NULL DEFAULT 'menu-icon text-dark-50 flaticon-dashboard',
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `updatedAt` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `deletedAt` datetime DEFAULT NULL,
  `flag` tinyint(1) NOT NULL DEFAULT 1,
  `creatorId` int(100) NOT NULL DEFAULT 10101,
  `branch_id` int(11) DEFAULT NULL,
  `route` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `setup_menu_main`
--

LOCK TABLES `setup_menu_main` WRITE;
/*!40000 ALTER TABLE `setup_menu_main` DISABLE KEYS */;
INSERT INTO `setup_menu_main` VALUES (2,'Report',NULL,2,'fa fa-chalkboard','2022-11-11 15:15:55','2024-02-09 17:14:11',NULL,1,10101,1,NULL),(3,'Users',NULL,3,'fas fa-users','2022-11-11 15:18:01','2024-02-09 17:14:12',NULL,1,10101,1,NULL);
/*!40000 ALTER TABLE `setup_menu_main` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `setup_menu_submenu`
--

DROP TABLE IF EXISTS `setup_menu_submenu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `setup_menu_submenu` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `menu_id` int(100) NOT NULL,
  `url` varchar(100) NOT NULL,
  `route` varchar(100) DEFAULT NULL,
  `orders` int(11) DEFAULT 1,
  `icon` varchar(255) NOT NULL DEFAULT 'menu-icon text-dark-50 flaticon-dashboard',
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `updatedAt` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `deletedAt` datetime DEFAULT NULL,
  `flag` tinyint(1) NOT NULL DEFAULT 1,
  `creatorId` int(100) NOT NULL DEFAULT 10101,
  `branch_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `setup_menu_submenu`
--

LOCK TABLES `setup_menu_submenu` WRITE;
/*!40000 ALTER TABLE `setup_menu_submenu` DISABLE KEYS */;
INSERT INTO `setup_menu_submenu` VALUES (1,'Generate Report',2,'Report/index','report',1,'fas fa-people-carry','2022-11-11 16:06:47','2024-02-09 17:11:28',NULL,1,10101,1),(2,'Manage Users',3,'Users/index','manage-users',2,'fa fa-plus-square','2022-11-11 16:06:47','2024-02-12 14:07:39',NULL,1,10101,1),(32,'Dashboard',1,'Dashaboard/Index','',1,'fa fa-gears','2022-11-11 16:06:47','2024-02-10 14:15:18',NULL,1,10101,1);
/*!40000 ALTER TABLE `setup_menu_submenu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `setup_system_settings`
--

DROP TABLE IF EXISTS `setup_system_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `setup_system_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `variable_name` varchar(100) NOT NULL,
  `variable_value` varchar(100) DEFAULT NULL,
  `variable_text` varchar(100) DEFAULT NULL,
  `variable_type` int(11) DEFAULT NULL,
  `creator_id` int(11) NOT NULL DEFAULT 1,
  `branch_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `setup_system_settings`
--

LOCK TABLES `setup_system_settings` WRITE;
/*!40000 ALTER TABLE `setup_system_settings` DISABLE KEYS */;
INSERT INTO `setup_system_settings` VALUES (13,'application name','APP_NAME','CMIS',NULL,NULL,1,NULL,'2023-01-23 06:49:15',NULL),(14,'app full name','APP_NAME_FULL','Curriculum Management Information System',NULL,NULL,1,NULL,'2023-01-23 07:04:06',NULL),(15,'company name','COMPANY_NAME','DBC SERVICES (U) LTD',NULL,NULL,1,NULL,'2023-01-23 07:04:39',NULL),(16,'company address','COMPANY_ADDRESS','Amka Mutungo',NULL,NULL,1,NULL,'2023-01-23 07:05:08',NULL),(17,'company contacts','COMPANY_CONTACTS','+256 20782925005 <br> + 256702881399 <br> info@dbcservicesug.com <br> marketing@dbcservicesug.com',NULL,NULL,1,NULL,'2023-01-23 07:05:39',NULL),(18,'company email','COMPANY_EMAIL','info@dbcservicesug.com',NULL,NULL,1,NULL,'2023-01-23 07:22:59',NULL),(19,'company website','COMPANY_WEBSITE','dbcservicesug.com',NULL,NULL,1,NULL,'2023-01-23 07:24:06',NULL),(20,'company telephone1','COMPANY_PHONE1','+256 702 881 399',NULL,NULL,1,NULL,'2023-01-23 07:24:59',NULL),(21,'company telephone2','COMPANY_PHONE2','+256 782 925 005',NULL,NULL,1,NULL,'2023-01-23 07:24:59',NULL),(22,'company logo','COMPANY_LOGO','/public/assets/media/logos/curriculum.jpg',NULL,NULL,1,NULL,'2023-01-23 07:27:46',NULL),(23,'admin email','ADMIN_EMAIL','mathiaswamucani.mw@gmail.com',NULL,NULL,1,NULL,'2023-02-07 06:09:24',NULL),(24,'application caption','APP_CAPTION','Enhancing Quality Education Through Better Curriculum Development',NULL,NULL,1,NULL,'2023-08-07 09:46:01',NULL);
/*!40000 ALTER TABLE `setup_system_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `setup_user_roles`
--

DROP TABLE IF EXISTS `setup_user_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `setup_user_roles` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `updatedAt` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `deletedAt` datetime DEFAULT NULL,
  `flag` tinyint(1) NOT NULL DEFAULT 1,
  `creatorId` int(100) NOT NULL DEFAULT 10101,
  `branch_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `setup_user_roles`
--

LOCK TABLES `setup_user_roles` WRITE;
/*!40000 ALTER TABLE `setup_user_roles` DISABLE KEYS */;
INSERT INTO `setup_user_roles` VALUES (1,'Admin','2022-11-11 16:15:03','2024-02-09 20:15:34',NULL,1,10101,1),(2,'User','2022-11-11 18:00:31','2024-02-09 20:15:34',NULL,1,10101,1);
/*!40000 ALTER TABLE `setup_user_roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(100) DEFAULT NULL,
  `photo_profile` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL,
  `uniid` varchar(100) NOT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'pending',
  `role_id` int(11) NOT NULL DEFAULT 0,
  `payment_status` tinyint(1) DEFAULT 0,
  `updated` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `company_name` varchar(100) DEFAULT 'dbcservices',
  `branch_id` int(11) DEFAULT 1,
  `last_login` datetime DEFAULT NULL,
  `last_logout` datetime DEFAULT NULL,
  `session_id` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'Mathias Mucani','mathiaswamucani.mw@gmail.com','0782825005','','$2y$10$LJtJTgY7h3mTP5D4hakCD.aSG1sJzEGO4cgtXRGXH3RdeDe35sKZW','2023-11-03 23:26:12','U1699043172','approved',1,0,NULL,NULL,'dbcservices',2,NULL,NULL,NULL),(7,'Mathias Mulumba','mathias@gmail.com','0702881399','','$2y$10$fX/le2vySF7PDjvL2gH3QeSL6UGaNBFdeDvERapRjZY//3MAEU53.','2023-11-29 16:18:51','U1701274731','approved',2,0,NULL,NULL,'dbcservices',2,NULL,NULL,NULL);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary view structure for view `user_details`
--

DROP TABLE IF EXISTS `user_details`;
/*!50001 DROP VIEW IF EXISTS `user_details`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `user_details` AS SELECT 
 1 AS `id`,
 1 AS `name`,
 1 AS `email`,
 1 AS `password`,
 1 AS `role_id`,
 1 AS `created_at`,
 1 AS `updated_at`,
 1 AS `role_name`*/;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `user_roles_permissions`
--

DROP TABLE IF EXISTS `user_roles_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_roles_permissions` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `submenu_id` int(100) NOT NULL,
  `user_role_id` int(100) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `updatedAt` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `deletedAt` datetime DEFAULT NULL,
  `flag` tinyint(1) NOT NULL DEFAULT 1,
  `creatorId` int(100) NOT NULL DEFAULT 10101,
  `branch_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=278 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_roles_permissions`
--

LOCK TABLES `user_roles_permissions` WRITE;
/*!40000 ALTER TABLE `user_roles_permissions` DISABLE KEYS */;
INSERT INTO `user_roles_permissions` VALUES (30,1,1,NULL,'2023-09-19 09:06:23','2024-02-09 20:18:11',NULL,1,10101,NULL),(31,2,1,NULL,'2023-09-19 09:06:23','2024-02-09 20:18:11',NULL,1,10101,NULL),(32,3,1,NULL,'2023-09-19 09:06:23','2024-02-09 20:18:11',NULL,1,10101,NULL),(33,1,2,NULL,'2023-09-19 09:06:23','2024-02-09 20:18:11',NULL,1,10101,NULL);
/*!40000 ALTER TABLE `user_roles_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `role_id` int(11) NOT NULL DEFAULT 2,
  `avatar` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Mathias Mulumba','mathiaswamucani.mw1@gmail.com',NULL,'$2y$10$BEakgDojppfpzFTj2d/cl.SgQnOOE.2IeUlOCldRreYZvW6j1VVXu','VIOAHOxNFaFOuXIjGQDVgOkkNMMKPBXhfbVWq7TX7M9eqbtDbkft7tC9YMMw',1,NULL,'2023-11-03 20:26:12','2024-02-13 07:31:40'),(3,'Mucani','mathiaswamucani@gmail.com',NULL,'$2y$10$9xwCtZrln2TQtiveODeZZe8N7El4GDehgQwvFpcA/U38SC0cPyTze','ZJqPq3Cpu0lWauMU84n7P4cXhyTJUKVQZEa8J07dHsZHxPlGVtwWZHTsDcMe',2,NULL,'2023-11-03 20:26:12','2024-02-12 15:48:13'),(4,'Admin','info@trailanalytics.com',NULL,'$2y$10$abFadIv/XKSZDtYYt/sgHOm9UL9f0k41cyD/8SuP19gmXmSGn5dOm','muh26667O8BtX7pG08YEK0wZrdUiINpEDRCws9IxOROPRZWL8jxt3njWxank',1,NULL,'2024-02-12 14:25:09','2024-02-12 15:48:44'),(14,'Mathias Wa Mucani','mathiaswamucani.mw@gmail.com',NULL,'$2y$10$jTzLlzeqB2Lpnjblb1xWCe.n/AGAiBLKqt4dTtWCjEkIh0X2BVrEa',NULL,2,'https://lh3.googleusercontent.com/a/ACg8ocLb-H6MGieMtrIRVFuB7vkH4oPvKtSc3xO4EToafOpORqw9=s96-c','2024-02-13 11:46:39','2024-02-14 09:08:42');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary view structure for view `view_user_roles_details`
--

DROP TABLE IF EXISTS `view_user_roles_details`;
/*!50001 DROP VIEW IF EXISTS `view_user_roles_details`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `view_user_roles_details` AS SELECT 
 1 AS `submenu`,
 1 AS `submenuUrl`,
 1 AS `route`,
 1 AS `user_role_id`,
 1 AS `submenu_id`,
 1 AS `menu_id`,
 1 AS `id`,
 1 AS `name`*/;
SET character_set_client = @saved_cs_client;

--
-- Dumping routines for database 'trailanalytics'
--

--
-- Final view structure for view `user_details`
--

/*!50001 DROP VIEW IF EXISTS `user_details`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013  SQL SECURITY DEFINER */
/*!50001 VIEW `user_details` AS select `a`.`id` AS `id`,`a`.`name` AS `name`,`a`.`email` AS `email`,`a`.`password` AS `password`,`a`.`role_id` AS `role_id`,`a`.`created_at` AS `created_at`,`a`.`updated_at` AS `updated_at`,`c`.`name` AS `role_name` from (`users` `a` left join `setup_user_roles` `c` on(`c`.`id` = `a`.`role_id`)) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `view_user_roles_details`
--

/*!50001 DROP VIEW IF EXISTS `view_user_roles_details`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013  SQL SECURITY DEFINER */
/*!50001 VIEW `view_user_roles_details` AS select `submenu`.`name` AS `submenu`,`submenu`.`url` AS `submenuUrl`,`submenu`.`route` AS `route`,`permissions`.`user_role_id` AS `user_role_id`,`permissions`.`submenu_id` AS `submenu_id`,`main`.`id` AS `menu_id`,`userrole`.`id` AS `id`,`userrole`.`name` AS `name` from (((`setup_menu_submenu` `submenu` join `user_roles_permissions` `permissions` on(`permissions`.`submenu_id` = `submenu`.`id`)) join `setup_menu_main` `main` on(`main`.`id` = `submenu`.`menu_id`)) join `setup_user_roles` `userrole` on(`userrole`.`id` = `permissions`.`user_role_id`)) where `userrole`.`flag` = 1 and `permissions`.`flag` = 1 and `submenu`.`flag` = 1 order by `userrole`.`id` desc */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-02-14 13:24:54
