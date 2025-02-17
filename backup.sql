-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: uniquest
-- ------------------------------------------------------
-- Server version	10.4.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin` (
  `AdminID` int(10) NOT NULL,
  `FirstName` varchar(45) NOT NULL,
  `LastName` varchar(45) NOT NULL,
  `ProfilePic` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`AdminID`),
  KEY `fk_Administration_User1_idx` (`AdminID`),
  CONSTRAINT `fk_Administration_User1` FOREIGN KEY (`AdminID`) REFERENCES `user` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin`
--

LOCK TABLES `admin` WRITE;
/*!40000 ALTER TABLE `admin` DISABLE KEYS */;
INSERT INTO `admin` VALUES (10063,'Sakith','Thewmika','67948b3362a924.10217486.png');
/*!40000 ALTER TABLE `admin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bookmarkjobs`
--

DROP TABLE IF EXISTS `bookmarkjobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bookmarkjobs` (
  `StudentID` int(11) NOT NULL,
  `JobID` int(11) NOT NULL,
  `bookmark_create_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`StudentID`,`JobID`),
  KEY `fk_Student_has_Jobs_Jobs1_idx` (`JobID`),
  KEY `fk_Student_has_Jobs_Student1_idx` (`StudentID`),
  CONSTRAINT `fk_Student_has_Jobs_Jobs1` FOREIGN KEY (`JobID`) REFERENCES `jobs` (`JobID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_Student_has_Jobs_Student1` FOREIGN KEY (`StudentID`) REFERENCES `student` (`StudentID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bookmarkjobs`
--

LOCK TABLES `bookmarkjobs` WRITE;
/*!40000 ALTER TABLE `bookmarkjobs` DISABLE KEYS */;
INSERT INTO `bookmarkjobs` VALUES (10039,15,'2024-11-28 19:09:35'),(10039,18,'2024-11-30 19:38:55'),(10039,20,'2024-12-01 04:24:29');
/*!40000 ALTER TABLE `bookmarkjobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `company`
--

DROP TABLE IF EXISTS `company`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `company` (
  `CompanyID` int(10) NOT NULL,
  `CompanyName` varchar(255) NOT NULL,
  `Description` varchar(3000) DEFAULT NULL,
  `CompanyLogo` varchar(255) DEFAULT NULL,
  `StreetNo` varchar(45) NOT NULL,
  `AddressLine1` varchar(45) NOT NULL,
  `AddressLine2` varchar(45) DEFAULT NULL,
  `City` varchar(45) NOT NULL,
  `Industry` varchar(255) NOT NULL,
  `Website` varchar(255) NOT NULL,
  `create_at` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`CompanyID`),
  KEY `fk_ServiceProvider_User1_idx` (`CompanyID`),
  CONSTRAINT `fk_ServiceProvider_User1` FOREIGN KEY (`CompanyID`) REFERENCES `user` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `company`
--

LOCK TABLES `company` WRITE;
/*!40000 ALTER TABLE `company` DISABLE KEYS */;
INSERT INTO `company` VALUES (10037,'Saku company','',NULL,'Sakuna','Godaduwa road','Kapuhempola, Akmeemana','Galle','','','2024-11-15 23:26:28'),(10040,'Aaa','',NULL,'Sakuna','Godaduwa road','Kapuhempola, Akmeemana','Galle','','','2024-11-16 15:59:40'),(10045,'Saku Company','',NULL,'\"Sakuna\", Godaduwa road','Kapuhempola','Akmeemana','Galle','','','2024-11-20 08:55:26'),(10046,'Saku Company','Sfvs',NULL,'\"Sakuna\", Godaduwa road','Kapuhempola','Akmeemana','Galle','Software','sfsv','2024-11-20 23:09:58'),(10052,'Ewrfs','',NULL,'edfeds','Esdfdfs','','Dsfdsf','dafdfa','','2024-11-28 23:30:00'),(10055,'SwiftPack Assist','Hgvgh','6748b0ed9b3251.02477612.png','No. 135','Galle Road','Colombo 03','Colombo','Manufacturing','www.swiftpackassist.lk','2024-11-28 23:35:33'),(10056,'TaskForce Solutions','TaskForce Solutions is a dynamic and reliable service provider dedicated to meeting the diverse needs of our clients through skilled, professional staffing. We specialize in providing flexible and effective workforce solutions tailored to various industries, ensuring that our clients receive the highest level of service.','6748c1c5ba0425.95723407.jpg','No. 12','Galle Road','','Colombo','Manufacturing','www.taskforce.com','2024-11-29 00:47:25'),(10057,'Udayagiri','','6748d151a83670.37028183.jpg','No. 40','Galle Road','','Colombo','Manufacturing','www.udayagiriholdings.com','2024-11-29 01:53:45'),(10058,'MechaPro events','We are hiring for an upcoming event focused on motor mechanics and engineering. Suitable candidates with relevant experience or training are encouraged to apply.','6748d3706898d5.71073733.jpg','No. 48','Galle Road','','Colombo','Mechanical','www.mechaproevents.lk','2024-11-29 02:02:48'),(10059,'Deepthi Store','Promotion',NULL,'No. 23','Nugegoda','','Colombo','Manufacturing','www.deepthistore.lk','2024-11-29 07:43:58'),(10060,'Upeka Super','','6749249bcdcff3.66522942.jpg','No. 98','Galle Road','','Colombo','Manufacturing','www.upekasuper.com','2024-11-29 07:49:07');
/*!40000 ALTER TABLE `company` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary table structure for view `companyreviews`
--

DROP TABLE IF EXISTS `companyreviews`;
/*!50001 DROP VIEW IF EXISTS `companyreviews`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `companyreviews` AS SELECT
 1 AS `CompanyID`,
  1 AS `CompanyName`,
  1 AS `CompanyDescription`,
  1 AS `CompanyLogo`,
  1 AS `ReviewID`,
  1 AS `Rating`,
  1 AS `Comment`,
  1 AS `StudentID`,
  1 AS `created_at`,
  1 AS `StudentName` */;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `complaint_jobs`
--

DROP TABLE IF EXISTS `complaint_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `complaint_jobs` (
  `ComplaintID` int(11) NOT NULL AUTO_INCREMENT,
  `Description` varchar(45) DEFAULT NULL,
  `Status` enum('Pending','Resolved','Rejected') NOT NULL DEFAULT 'Pending',
  `StudentID` int(11) NOT NULL,
  `JobID` int(11) NOT NULL,
  `ComplainedDate` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`ComplaintID`),
  KEY `fk_Complaint_Student1_idx` (`StudentID`),
  KEY `fk_Complaint_ServiceProvider1_idx` (`JobID`),
  CONSTRAINT `fk_Complaint_ServiceProvider1` FOREIGN KEY (`JobID`) REFERENCES `jobs` (`JobID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_Complaint_Student1` FOREIGN KEY (`StudentID`) REFERENCES `student` (`StudentID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `complaint_jobs`
--

LOCK TABLES `complaint_jobs` WRITE;
/*!40000 ALTER TABLE `complaint_jobs` DISABLE KEYS */;
INSERT INTO `complaint_jobs` VALUES (9,'Not recommended!','Resolved',10039,18,'2024-11-30 20:39:36'),(10,'test test','Rejected',10038,18,'2025-02-01 13:12:07'),(11,'test','Pending',10041,15,'2025-02-01 13:12:34'),(13,'test','Pending',10041,16,'2025-02-12 22:59:13'),(14,'test','Rejected',10038,16,'2025-02-12 22:59:39'),(15,'test','Pending',10047,18,'2025-02-12 23:00:00');
/*!40000 ALTER TABLE `complaint_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contact_messages`
--

DROP TABLE IF EXISTS `contact_messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contact_messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `topic` varchar(50) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `read_status` enum('Read','Unread') NOT NULL DEFAULT 'Unread',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contact_messages`
--

LOCK TABLES `contact_messages` WRITE;
/*!40000 ALTER TABLE `contact_messages` DISABLE KEYS */;
INSERT INTO `contact_messages` VALUES (1,'Sakuna','sakunasanka@gmail.com','job','dxfvx','2024-12-26 08:16:59','Unread'),(2,'Sakuna','sakunasanka@gmail.com','job','dfssdf','2024-12-27 15:51:55','Unread'),(3,'dzczd','sakustu@gmail.com','job','dxcxvc','2024-12-27 16:27:52','Unread');
/*!40000 ALTER TABLE `contact_messages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `email_verification`
--

DROP TABLE IF EXISTS `email_verification`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `email_verification` (
  `Email` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `VerifiedDate` datetime NOT NULL,
  `IsVerified` enum('Y','N') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`Email`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `email_verification`
--

LOCK TABLES `email_verification` WRITE;
/*!40000 ALTER TABLE `email_verification` DISABLE KEYS */;
INSERT INTO `email_verification` VALUES ('2022cs202@stu.ucsc.cmb.ac.lk','2025-02-13 13:04:28','Y'),('sakiththewmika@gmail.com','2025-02-12 11:43:48','Y');
/*!40000 ALTER TABLE `email_verification` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jobs` (
  `JobID` int(11) NOT NULL AUTO_INCREMENT,
  `Title` varchar(100) DEFAULT NULL,
  `Description` text DEFAULT NULL,
  `Location` varchar(100) DEFAULT NULL,
  `Category` enum('Full-time','Part-time','Internship') DEFAULT NULL,
  `JobBenefits` text DEFAULT NULL,
  `RequiredQualifications` text DEFAULT NULL,
  `SalaryRange` varchar(45) DEFAULT NULL,
  `CompanyID` int(11) NOT NULL,
  `create_at` datetime NOT NULL DEFAULT current_timestamp(),
  `Status` enum('Active','Deactive','Pending','Not Approved') NOT NULL DEFAULT 'Pending',
  `VerifiedBy` int(10) NOT NULL,
  `VerifiedDate` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`JobID`,`CompanyID`),
  KEY `fk_Jobs_ServiceProvider1_idx` (`CompanyID`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
INSERT INTO `jobs` VALUES (15,'Filling and Packing Assistant',NULL,'Wattala, Nawala','Part-time','Competitive daily pay.\r\nComplimentary lunch provided.\r\nOvertime opportunities for extra earnings.\r\nIdeal for gaining quick experience in a dynamic workplace.','Pass O levels','Rs. 1700 per day',10055,'2024-11-28 23:47:44','Active',0,'2025-01-25 12:09:32'),(16,'Packing Assistant','Positions Available: 3 at Galle Face, 2 at Havelock City\r\nWork Time: 10:00 AM to 10:00 PM\r\nCompensation: Rs. 2000 + Rs. 250 for food + Rs. 250 attendance bonus\r\nDress Code: Black pants, white shirt, and black shoes','Colombo, Sri Lanka','Part-time','Competitive daily pay\r\n\r\nComplimentary lunch provided\r\n\r\nOvertime opportunities for extra earnings\r\n\r\nIdeal for gaining quick experience in a dynamic workplace.','Must be able to complete 3 days of work','Rs. 2000 per day',10056,'2024-11-29 00:51:34','Active',10063,'2025-02-01 13:16:15'),(17,'Promotion','Dates: Starting from January 30th, weekends only\r\nWorking Hours: 9:30 AM to 6:30 PM\r\nCompensation: Rs. 2500 per day','Maradana','Part-time','Opportunity to gain experience in event promotion.\r\nWork only on weekends, allowing flexibility.','Female candidates only\r\nReliable and punctual\r\nPositive attitude and good communication skills','Rs. 2500 per day',10057,'2024-11-29 01:57:18','Active',0,'2025-01-25 12:09:32'),(18,'Mechanical engineer','We are hiring for an upcoming event focused on motor mechanics and engineering. Suitable candidates with relevant experience or training are encouraged to apply.\r\n\r\nBoys (4 positions): Rs. 3000/day\r\nGirls (3 positions): Rs. 4000/day\r\nSupervisor (1 position): Rs. 3500/day','Colombo, Sri Lanka','Part-time','Attractive daily pay for all positions.\r\nPayment during training sessions.\r\nHands-on experience in an engaging and professional event environment.\r\nOpportunity to network with professionals in motor mechanics and engineering.','Fluent in English.\r\nAt least two individuals fluent in Tamil.\r\nCandidates with prior experience or knowledge in motor mechanics and engineering are preferred.','Rs. 3000 per day',10058,'2024-11-29 02:06:15','Active',10063,'2025-02-12 20:13:22'),(19,'Promotion','We are looking for enthusiastic and outgoing individuals to work as Promotion Assistants for an 18-day event in Negombo.','Nugegoda','Part-time','Attractive daily pay of Rs. 2500.\r\nOpportunity to gain hands-on experience in promotions.\r\nWork in a lively and customer-facing role.\r\nBuild communication and interpersonal skills.','Female candidates only.\r\nFriendly, energetic, and professional demeanor.\r\nGood communication skills.','Rs. 2500 per day',10059,'2024-11-29 07:46:29','Deactive',0,'2025-01-25 12:09:32'),(20,'Female Promotion Assistant','We are looking for a confident and friendly individual to join as a Promotion Assistant for a 6-week campaign at Upeka Super, Piliyandala (Arrawwala).\r\nFor more information, please call or WhatsApp 0775097093.','Piliyandala','Part-time','Competitive daily pay of Rs. 2500.\r\nOpportunity for long-term work over 6 weeks.\r\nEnhance your customer service and promotional skills.\r\nWork in a vibrant and engaging retail environment.','Female candidates only.\r\nEnergetic and approachable personality.\r\nStrong communication skills and professionalism.','Rs. 2500 per day',10060,'2024-11-29 07:51:21','Active',0,'2025-01-25 12:09:32'),(23,'xfv','cfg','dfxb','Part-time','fcb','xf','xf',10060,'2025-01-08 17:47:23','Active',0,'2025-01-25 12:09:32');
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `after_job_verified` AFTER UPDATE ON `jobs` FOR EACH ROW BEGIN
    -- Handle status change to 'Active' (Approval)
    IF NEW.Status = 'Active' AND (OLD.Status = 'Pending' OR OLD.Status = 'Not Approved') THEN
        INSERT INTO verificationlogs 
        (
            EntityID, 
            EntityType, 
            Action, 
            ActionBy, 
            ActionDate, 
            Comment
        ) 
        VALUES 
        (
            NEW.JobID, 
            'Job', 
            'Approve', 
            NEW.VerifiedBy, 
            NOW(), 
            'Job status changed to Active'
        );
    END IF;

    -- Handle status change to 'Not Approved' (Rejection)
    IF NEW.Status = 'Not Approved' AND OLD.Status = 'Pending' THEN
        INSERT INTO verificationlogs 
        (
            EntityID, 
            EntityType, 
            Action, 
            ActionBy, 
            ActionDate, 
            Comment
        ) 
        VALUES 
        (
            NEW.JobID, 
            'Job', 
            'Reject', 
            NEW.VerifiedBy, 
            NOW(), 
            'Job status changed to Not Approved'
        );
    END IF;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `messages`
--

DROP TABLE IF EXISTS `messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_email` varchar(255) DEFAULT NULL,
  `sender_id` int(11) NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `topic` enum('Job','Internship','General Information') NOT NULL,
  `message` text NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `read_status` enum('Unread','Read') DEFAULT 'Unread',
  PRIMARY KEY (`id`),
  KEY `sender_id` (`sender_id`),
  KEY `receiver_id` (`receiver_id`),
  CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`sender_id`) REFERENCES `user` (`UserID`) ON DELETE CASCADE,
  CONSTRAINT `messages_ibfk_2` FOREIGN KEY (`receiver_id`) REFERENCES `user` (`UserID`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `messages`
--

LOCK TABLES `messages` WRITE;
/*!40000 ALTER TABLE `messages` DISABLE KEYS */;
INSERT INTO `messages` VALUES (1,'2022cs202@ucsc.cmb.ac.lk',10038,10063,'','test message','2025-02-15 23:43:52','Unread');
/*!40000 ALTER TABLE `messages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary table structure for view `messages_with_roles`
--

DROP TABLE IF EXISTS `messages_with_roles`;
/*!50001 DROP VIEW IF EXISTS `messages_with_roles`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `messages_with_roles` AS SELECT
 1 AS `id`,
  1 AS `user_email`,
  1 AS `sender_id`,
  1 AS `sender_role`,
  1 AS `sender_email`,
  1 AS `receiver_id`,
  1 AS `receiver_role`,
  1 AS `receiver_email`,
  1 AS `topic`,
  1 AS `message`,
  1 AS `created_at`,
  1 AS `read_status` */;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `password_reset`
--

DROP TABLE IF EXISTS `password_reset`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_reset` (
  `UserID` int(10) NOT NULL,
  `Token` varchar(255) NOT NULL,
  `Expiration` datetime NOT NULL,
  PRIMARY KEY (`UserID`,`Token`) USING BTREE,
  CONSTRAINT `password_reset` FOREIGN KEY (`UserID`) REFERENCES `user` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset`
--

LOCK TABLES `password_reset` WRITE;
/*!40000 ALTER TABLE `password_reset` DISABLE KEYS */;
INSERT INTO `password_reset` VALUES (10061,'00a3f8e55e7a95a4987a173e441857881c1205ea6f7ddc23bed20cb387d8e0709adc4e7e8434c8dc5a5a2bcc700132fba98e','2025-02-07 18:27:20'),(10061,'8047a5731d2ea925c6a9477e9b5f3cca2ad17b6eb074af744daac4bc9e7b99d646253d6544b9758d8439555c66e315f8b96d','2025-02-07 18:25:45'),(10061,'c2e93b8c49f0a21687d581a24d9ac04c36cb7ee5eeb5f90f08ffcc172234e91bf7924ed10d1bdab95aed196546b146081474','2025-02-07 18:28:01'),(10063,'151cc668907a9bed80a508b2ef1f1ab24d24517423758240383124404f5c1d7ccda50f71c3de763f152635f3857855024c2b','2025-02-07 14:24:28'),(10063,'2313e92ff7e2221cad491b65c03241ba0656cd9bb3b4be886bca5fc8b7f94077790f0d3b6d7059c9df8c29706c6c89bab773','2025-02-07 17:52:36'),(10063,'3234a53e65d112fa1500cc4fb1345a38f34cb390d02cb3000e171fb4f4448225d8d085b1838a92763cf33dd255ce2d2d86fe','2025-02-07 17:37:56'),(10063,'3608fbc216caf191a0e1639094c71fd452d23dcc2389e37212f47c6afd0d1b5a3cefa18b34277ba0f7de752033a501f73a05','2025-02-12 00:39:11'),(10063,'3b59c5bbf8afc89585850b0d576577b78d40f590069643ae4615e12ad2aee64a78079aa1f6a857acbc508bcc20d61148c21e','2025-02-07 17:30:02'),(10063,'5a4ed8041ca2e8cf097829d360587681708a5bcd2e71abbdf0fae3a8c16bdf688417d9ddcfd60a6031677cb67b2b7402fd8f','2025-02-07 17:28:38'),(10063,'5b7360bfc3a6e59a43ba6fa33d3bf5a15faae9df2eff5b1e7cc1f378e119f6ad844f81346312df7ebf51126abb52883158dd','2025-02-07 17:27:48'),(10063,'652a83d205741e26919de98a6d54772246e807703179abdd9e4a15e5ef0933d6a95fca7215c47a83b97c4796a6babd65c46b','2025-02-07 17:31:35'),(10063,'65cdff7d816c42a0f8577ce973f43cec02fedfa4432154cae9e84b9cd1c8c0249e7c59ca72531b8ba3ba2e0fd29da13d1d66','2025-02-07 18:43:36'),(10063,'76604c114321ba04d3ac6962f3537439a68ffc1cca5506cf86950150dc761cb3acca5266651bc2a1d8d4527d2cfdc6a3915b','2025-02-07 17:26:05'),(10063,'7c95275a59f12d26723ebfba5e010e14f89500dc61aeaafc0b02af30a96b76d0112f0490d2ecaa32bf6eb00bdbe4acd9c9ac','2025-02-07 17:37:07'),(10063,'88aac19808000a1051801957cc966632ff80fa35ee66e522763b1f5d61589d596bd486e708e865a0e35d33c8f0d700756157','2025-02-07 17:21:29'),(10063,'9d8b10b50b03d823a832d728fdd9eb3736b4b66132b7d91d0681912040c41ffca36950faa3d20394f930b55617a4139ec626','2025-02-11 10:45:04'),(10063,'af61e9dfa21479805a02750e6d0be824a68cfde9504f965864092b5d41db9f7af4d1a855ad5a99d654e48b69f31fa1da10e6','2025-02-07 17:25:27'),(10063,'af6615724b1423b6eaee2114c6f9e7a090b4465ffa9af15cbd21b02c56f0fd9e7c697dc6610fc3b5dcffa954d390171384e4','2025-02-11 12:52:28'),(10063,'bd2bde9b63ee1b20bf124a39008578614998b8baefadc98371865280ca39de224beeb0521f5b17b4712cdf85c65457a51fb6','2025-02-11 15:57:30'),(10063,'c7f3c5c1e552eec44a1df0ee09ba9d7847ba55184964844b05f70f7b58b1d01ef738dbb6144b8ca5e540b7c57825522613e8','2025-02-11 11:58:30'),(10063,'d4db5861edab4471b9b9c9e4eee63619b48f386ee4ec3ecd346520ff5b7a37e4a40a8f79442b9c0dc72008344344f75279e8','2025-02-07 17:48:57'),(10063,'dea8a057e3a3dfd02903b757288cb9b065ae3681aadb6097bb51745ea6dc06f718a49c8bd1eb5bb24c18abf7d943b290a162','2025-02-13 00:49:59'),(10063,'e32b0f54dbc654b1b4f30dde83579d0e3398d182447746b548a9cfef5a5477993f4b926ada68ba7919479b3b9adc6db2cb6c','2025-02-11 15:41:46'),(10063,'f21d50288f3aa238c583638efc3b6c605aaaea8d7f227a59f35bd6c2a415738bb896ed062cf7bcd19f12734c684ccb075f1c','2025-02-11 10:59:54'),(10063,'f9d068deaaf6916dbe5ef77255ea863a373eef58d3e435700ce817cb90cca9c0e7619235a802bf37c8026e06c146e092441a','2025-02-11 10:57:43');
/*!40000 ALTER TABLE `password_reset` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `review`
--

DROP TABLE IF EXISTS `review`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `review` (
  `ReviewID` int(11) NOT NULL AUTO_INCREMENT,
  `Rating` int(11) DEFAULT NULL,
  `Comment` varchar(45) DEFAULT NULL,
  `StudentID` int(11) NOT NULL,
  `CompanyID` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`ReviewID`),
  KEY `fk_Review_Student1_idx` (`StudentID`),
  KEY `fk_Review_ServiceProvider1_idx` (`CompanyID`)
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `review`
--

LOCK TABLES `review` WRITE;
/*!40000 ALTER TABLE `review` DISABLE KEYS */;
INSERT INTO `review` VALUES (17,4,'ghvcgh',10039,10040,'2024-11-20 18:55:39'),(19,4,'ffv',10039,10040,'2024-11-20 18:55:39'),(20,5,'xfvvxc',10039,10040,'2024-11-20 18:55:39'),(21,4,'fxvxf',10039,10037,'2024-11-20 18:55:39'),(22,4,'fgfg',10041,10037,'2024-11-20 18:55:39'),(24,5,'dfhddhg',10039,10040,'2024-11-20 18:55:39'),(25,4,'vhvhv',10039,10040,'2024-11-20 18:55:39'),(26,4,'xfvdfg',10039,10040,'2024-11-20 18:55:58'),(27,4,'dsffv',10039,10045,'2024-11-22 02:10:19'),(28,4,'nmbdfjdsf',10039,10045,'2024-11-26 07:31:29'),(29,3,'nmbdfjdsfadc',10039,10045,'2024-11-26 07:31:37'),(44,1,'Hi',10039,10058,'2024-11-29 02:05:51');
/*!40000 ALTER TABLE `review` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `student`
--

DROP TABLE IF EXISTS `student`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `student` (
  `StudentID` int(10) NOT NULL,
  `FirstName` varchar(45) NOT NULL,
  `LastName` varchar(45) NOT NULL,
  `ProfilePic` varchar(255) DEFAULT NULL,
  `Gender` enum('Male','Female') NOT NULL,
  `DOB` date NOT NULL,
  `NIC_No` varchar(12) NOT NULL,
  `NIC_Copy` varchar(255) NOT NULL,
  `CV` varchar(255) DEFAULT NULL,
  `StreetNo` varchar(45) NOT NULL,
  `AddressLine1` varchar(45) NOT NULL,
  `AddressLine2` varchar(45) DEFAULT NULL,
  `City` varchar(45) NOT NULL,
  `University` varchar(255) NOT NULL,
  `UniversityID` varchar(45) NOT NULL,
  `UniversityID_Copy` varchar(255) NOT NULL,
  PRIMARY KEY (`StudentID`),
  KEY `fk_Student_User_idx` (`StudentID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `student`
--

LOCK TABLES `student` WRITE;
/*!40000 ALTER TABLE `student` DISABLE KEYS */;
INSERT INTO `student` VALUES (10038,'Sakuna','Manamperi','','Male','2003-01-16','200300301410','6737c1cb3ebfe3.47444826.pdf','6737c1cb3f2dd1.72272486.pdf','Sakuna','Godaduwa road','Kapuhempola, Akmeemana','Galle','UCSC','Sakuna Sanka','6737c1cb3f3275.58640255.pdf'),(10039,'Sakuna','Manamperi','','Male','2002-02-16','200300301410','6737c237088e25.71022225.pdf','67485286ea23a7.64207507.pdf','Sakuna','Godaduwa road','Kapuhempola, Akmeemana','Galle','UCSC','Sakuna Sanka','6737c237090e66.33853733.pdf'),(10041,'Sakuna','Manamperi',NULL,'Male','2003-01-02','200300301410','673c7b3b9c4cf8.31415761.pdf',NULL,'Sakuna','Godaduwa road','Kapuhempola, Akmeemana','Galle','UCSC','2022/CS/118','673c7b3b9c6a47.27344404.pdf'),(10047,'Sakuna','Manamperi',NULL,'Male','2003-01-02','200300301410','673e225bae7004.44386678.pdf',NULL,'\"Sakuna\", Godaduwa road','Kapuhempola','Akmeemana','Galle','UCSC','2022/CS/118','673e225baeabe7.93033132.pdf'),(10048,'Admin','Sakuna',NULL,'Male','2003-01-02','200300301410','673e234ae97683.23511252.pdf',NULL,'\"Sakuna\", Godaduwa road','Kapuhempola','Akmeemana','Galle','UCSC','2022/CS/118','673e234ae9aab0.07845515.pdf');
/*!40000 ALTER TABLE `student` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary table structure for view `studentjobcomplaints`
--

DROP TABLE IF EXISTS `studentjobcomplaints`;
/*!50001 DROP VIEW IF EXISTS `studentjobcomplaints`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `studentjobcomplaints` AS SELECT
 1 AS `JobTitle`,
  1 AS `CompanyID`,
  1 AS `CompanyEmail`,
  1 AS `CompanyName`,
  1 AS `ComplaintID`,
  1 AS `Complaint`,
  1 AS `StudentName`,
  1 AS `ComplainedDate`,
  1 AS `Status` */;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `token`
--

DROP TABLE IF EXISTS `token`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `token` (
  `Email` varchar(50) NOT NULL,
  `Token` varchar(255) NOT NULL,
  `Expiration` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `token`
--

LOCK TABLES `token` WRITE;
/*!40000 ALTER TABLE `token` DISABLE KEYS */;
INSERT INTO `token` VALUES ('sakiththewmika@gmail.com','b20d872672a5691ed31ab9ea541d8207955fc5f280b5072f4fc2c35d8480c73e','2025-02-13 00:57:47'),('sakiththewmika@gmail.com','f15a6244c19367fab2615a771ab89b55608c9bbf941993ff0c52f6b952d65735','2025-02-13 01:01:09'),('sakiththewmika@gmail.com','8f54eb8e7ec327eec5efa8f28b40aae7cfee8aa9f071f38e631a706b3263bcc7','2025-02-13 01:03:10'),('sakiththewmika@gmail.com','5ec66270eed51e3670d4304f6565e88fa0702284c21db7e77bd26dbef9ac7cb2','2025-02-13 01:27:39'),('2022cs202@stu.ucsc.cmb.ac.lk','2690c3cb884f55592964ddf7f8b39c399e6dd7086716eed7dde49267aa5f82ca','2025-02-13 14:02:45'),('pamaliweerasinghe@gmail.com','87c9dbcbf36960ed4191efc1f7193e516a7164bc716a86401c83f00317308d40','2025-02-13 14:11:54'),('sakiththewmika@gmail.com','325981ca547bdf0db6564fb8b5b6bbaf89b1c3f2d8013a3041ffe2a4f7b03e7a','2025-02-13 14:14:24'),('sakiththewmika@gmail.com','467ac0834af5f765e69b2d9759f6782d4d7c2f36cb2cf77946fe5675896a8439','2025-02-13 14:18:32'),('sakiththewmika@gmail.com','8113cc11cbf66be5a0438ff83ee3cf5924134bcdc19b20895815a0011947597a','2025-02-13 14:21:05'),('2022cs202@stu.cmb.ac.lk','891c36214598de9769f97fe4231a033ab0bd6de3c2abb0bfc3644fcf8834bdfa','2025-02-14 00:02:56'),('2022cs202@stu.cmb.ac.lk','1de0966919faee08b3feb888e8269cd3849b3012eb25a53d688345e85df8002c','2025-02-14 00:03:01'),('2022cs202@stu.cmb.ac.lk','05b4e4a066d9ebae39402f65c638665d86f5d945f657a03c3c0494c9a30114ae','2025-02-14 00:03:06'),('2022cs202@stu.cmb.ac.lk','f87bb4502705d14897b28c751d7c318395fddd2df4d68b3c5dbb9971f3d5288f','2025-02-14 00:04:07'),('2022cs202@stu.pdn.ac.lk','5cc70fa7014eaa5d95cb7ee61d55b6ab2356a3f9b5f89a6df5aaa8b7272ece1a','2025-02-14 00:11:38');
/*!40000 ALTER TABLE `token` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `UserID` int(10) NOT NULL AUTO_INCREMENT,
  `Password` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Role` enum('Admin','VT-Member','Student','Company') NOT NULL,
  `RegisterDate` datetime NOT NULL,
  `ContactNo` varchar(10) NOT NULL DEFAULT '',
  `Status` enum('Active','Deactive','Pending','Not Approved') NOT NULL,
  `VerifiedBy` int(10) DEFAULT NULL,
  `VerifiedDate` datetime DEFAULT NULL,
  PRIMARY KEY (`UserID`),
  UNIQUE KEY `UserID_UNIQUE` (`UserID`),
  UNIQUE KEY `Email_UNIQUE` (`Email`)
) ENGINE=InnoDB AUTO_INCREMENT=10064 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (10037,'$2y$10$gK/b/mfxzcG6zW6.UIVfReREMsGBFpYJsqmuDsuALIbZ7jcip8YKa','sakuna_c@gmail.com','Admin','2024-11-15 18:56:28','0768277954','Active',0,'2025-01-25 12:03:51'),(10038,'$2y$10$sZXQgqeWFxeI/T/dU9bKqOSfQFx/I5ar7D8HpmkIZwDxrDkgb0iVa','2022cs202@ucsc.cmb.ac.lk','Student','2024-11-16 03:18:59','0768277954','Active',10063,'2025-02-13 15:18:44'),(10039,'$2y$10$zNV7Tg98S5.Evf6ULMDYBu.Su.X5nKX0Bgx921T/UmdpTZ5dZ6F0C','sakustu@gmail.com','Student','2024-11-16 03:20:46','0768277954','Active',0,'2025-01-25 12:03:51'),(10040,'$2y$10$oyTCVurGBRXC9Lwj.mbwr.0bJZaupofPpoE2WDzgONcDuUGOOQfWm','sakutest@gmail.com','Company','2024-11-16 15:59:40','0768277954','Active',0,'2025-01-25 12:03:51'),(10041,'$2y$10$Igr3OfBeWqQZtrrIYRQVpeGc0SLVNmY0/gERn.VW.3i2zvrnGyTc2','sakustu1@gmail.com','Student','2024-11-19 17:19:15','0768277954','Active',0,'2025-01-25 12:03:51'),(10045,'$2y$10$LQEYDxUzn0BdW4NdgKfJKeYernBDLWDNautXBDgVJTiRKte.Gn6e2','sakucompany@gmail.com','Company','2024-11-20 08:55:26','0768277954','Active',0,'2025-01-25 12:03:51'),(10046,'$2y$10$Qj8jX.iiGUzdX6RSWGdzC.hWltjfMaUYPk9LnafwoMkMUAaqxyqXy','sakunewcom@gmail.com','Company','2024-11-20 23:09:58','0768277954','Active',10063,'2025-02-13 14:20:13'),(10047,'$2y$10$64WsWOlZNLWt8X.G7aNifOlwvZC8vow1jx22.uB2iKB8xlBSzLWwC','sakunasanka22@gmail.com','Student','2024-11-20 23:24:35','0768277954','Pending',0,'2025-01-25 12:03:51'),(10048,'$2y$10$eCYiLBhd0/DXN968Lxai1.vTn0TDKQHcF7F9uezdfsXpwhd/FdYYW','sakunasanka227@gmail.com','VT-Member','2024-11-20 23:28:34','0768277954','Active',0,'2025-01-25 12:03:51'),(10052,'$2y$10$qEsv/vt9mDKQJlvDkuJAbOFR42w.RBPwVp.ZBDhT7aPalr5QNLZZa','sakus@gmail.com','Company','2024-11-28 23:30:00','0768277954','Not Approved',10048,'2025-01-25 12:16:48'),(10055,'$2y$10$8mvkjJ4H6/nCK17sVc5wXeAeLKir4LlPgjsbONOkRRQ3PIVUNg6iy','swiftpack@gmail.com','Company','2024-11-28 23:35:33','0712755366','Active',0,'2025-01-25 12:03:51'),(10056,'$2y$10$eaLPmKwzj34SJNVrtyIwIefHkVYCm/77AcAB/xi2yxHHF4IsPdZhS','taskforce@gmail.com','Company','2024-11-29 00:47:25','0722952618','Active',0,'2025-01-25 12:03:51'),(10057,'$2y$10$u/0hieYQIxSOCikmuZjjvexccczji.BzH1uulBZPFXiqIvM6lH7si','udayagiri@gmail.com','Company','2024-11-29 01:53:45','0768277954','Active',0,'2025-01-25 12:03:51'),(10058,'$2y$10$19zAiAWB83JuvF7EVv6fR.TaAXsgjuI7Ot/HaE8S7yLCcvjmxLzvG','mechapro@gmail.com','Company','2024-11-29 02:02:48','0116547389','Pending',0,'2025-01-25 12:03:51'),(10059,'$2y$10$jcQHa2mMF2Vak7PKp1I2Recdy8VetFAaZ13ILCq0jdZpO0Lmuo7.e','2022cs202@stu.cmb.ac.lk','Company','2024-11-29 07:43:58','0778965416','Active',10061,'2025-02-13 15:29:51'),(10060,'$2y$10$bjDKoykOVu0Ewzu6vn6Av.DVVjHQWmOLwPhvg3uZVQ1OKsnP15e4W','upeka@gmail.com','Company','2024-11-29 07:49:07','0113422657','Active',0,'2025-01-25 12:03:51'),(10061,'$2y$10$HwYYEXNa7bLrTqCwn3cSPOsepJagIzKGspUGv9RhuPRt3t3IMgGkK','pamali@gmail.com','VT-Member','2025-01-25 12:23:43','0764834398','Active',NULL,NULL),(10063,'$2y$10$sRTapkG2bEtVKiECBH3JeeoV9CVzqX/Q4GVRwt4tUCUtPqoCFmc7m','sakiththewmika@gmail.com','Admin','2025-01-25 12:26:51','0711702961','Active',NULL,NULL);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `after_user_verified` AFTER UPDATE ON `user` FOR EACH ROW BEGIN
    -- Handle status change to 'Active' (Approval)
    IF NEW.Status = 'Active' AND (OLD.Status = 'Pending' OR OLD.Status = 'Not Approved') THEN
        INSERT INTO verificationlogs 
        (
            EntityID, 
            EntityType, 
            Action, 
            ActionBy, 
            ActionDate, 
            Comment
        ) 
        VALUES 
        (
            NEW.UserID, 
            'User', 
            'Approve', 
            NEW.VerifiedBy, 
            NOW(), 
            'User status changed to Active'
        );
    END IF;

    -- Handle status change to 'Not Approved' (Rejection)
    IF NEW.Status = 'Not Approved' AND OLD.Status = 'Pending' THEN
        INSERT INTO verificationlogs 
        (
            EntityID, 
            EntityType, 
            Action, 
            ActionBy, 
            ActionDate, 
            Comment
        ) 
        VALUES 
        (
            NEW.UserID, 
            'User', 
            'Reject', 
            NEW.VerifiedBy, 
            NOW(), 
            'User status changed to Not Approved'
        );
    END IF;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Temporary table structure for view `v_bookmarkedjobs`
--

DROP TABLE IF EXISTS `v_bookmarkedjobs`;
/*!50001 DROP VIEW IF EXISTS `v_bookmarkedjobs`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `v_bookmarkedjobs` AS SELECT
 1 AS `StudentID`,
  1 AS `JobID`,
  1 AS `CompanyID`,
  1 AS `Title`,
  1 AS `CompanyLogo`,
  1 AS `CompanyName`,
  1 AS `Description`,
  1 AS `Location`,
  1 AS `Category`,
  1 AS `JobBenefits`,
  1 AS `Status`,
  1 AS `RequiredQualifications`,
  1 AS `SalaryRange`,
  1 AS `Email`,
  1 AS `ContactNo`,
  1 AS `jobs_create_at`,
  1 AS `company_create_at`,
  1 AS `bookmark_create_at` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `v_comlaintsforcompany`
--

DROP TABLE IF EXISTS `v_comlaintsforcompany`;
/*!50001 DROP VIEW IF EXISTS `v_comlaintsforcompany`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `v_comlaintsforcompany` AS SELECT
 1 AS `CompanyID`,
  1 AS `CompanyEmail`,
  1 AS `CompanyName`,
  1 AS `ComplaintCount`,
  1 AS `LastComplainedDate` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `v_jobs`
--

DROP TABLE IF EXISTS `v_jobs`;
/*!50001 DROP VIEW IF EXISTS `v_jobs`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `v_jobs` AS SELECT
 1 AS `JobID`,
  1 AS `CompanyID`,
  1 AS `Title`,
  1 AS `CompanyLogo`,
  1 AS `CompanyName`,
  1 AS `Industry`,
  1 AS `Website`,
  1 AS `Description`,
  1 AS `Location`,
  1 AS `Address`,
  1 AS `Category`,
  1 AS `Status`,
  1 AS `JobBenefits`,
  1 AS `RequiredQualifications`,
  1 AS `SalaryRange`,
  1 AS `Email`,
  1 AS `ContactNo`,
  1 AS `jobs_create_at`,
  1 AS `company_create_at` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `v_verifiedjobs`
--

DROP TABLE IF EXISTS `v_verifiedjobs`;
/*!50001 DROP VIEW IF EXISTS `v_verifiedjobs`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `v_verifiedjobs` AS SELECT
 1 AS `JobID`,
  1 AS `Title`,
  1 AS `Email`,
  1 AS `Category`,
  1 AS `Status`,
  1 AS `ActionBy`,
  1 AS `ActionDate` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `v_verifiedusers`
--

DROP TABLE IF EXISTS `v_verifiedusers`;
/*!50001 DROP VIEW IF EXISTS `v_verifiedusers`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `v_verifiedusers` AS SELECT
 1 AS `UserID`,
  1 AS `Email`,
  1 AS `Role`,
  1 AS `Status`,
  1 AS `ActionBy`,
  1 AS `ActionDate` */;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `verificationlogs`
--

DROP TABLE IF EXISTS `verificationlogs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `verificationlogs` (
  `LogID` int(11) NOT NULL AUTO_INCREMENT,
  `EntityType` enum('User','Job') NOT NULL,
  `EntityID` int(11) NOT NULL,
  `ActionBy` int(11) NOT NULL,
  `Action` enum('Reject','Approve') NOT NULL,
  `Comment` varchar(255) DEFAULT NULL,
  `ActionDate` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`LogID`),
  KEY `ActionBy` (`ActionBy`),
  CONSTRAINT `verificationlogs_ibfk_1` FOREIGN KEY (`ActionBy`) REFERENCES `user` (`UserID`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `verificationlogs`
--

LOCK TABLES `verificationlogs` WRITE;
/*!40000 ALTER TABLE `verificationlogs` DISABLE KEYS */;
INSERT INTO `verificationlogs` VALUES (1,'User',10052,10048,'Reject','User status changed to Not Approved','2025-01-25 12:16:48'),(2,'User',10038,10048,'Approve','User status changed to Active','2025-01-25 12:17:05'),(3,'Job',16,10063,'Reject','Job status changed to Not Approved','2025-02-01 13:16:09'),(4,'Job',16,10063,'Approve','Job status changed to Active','2025-02-01 13:16:15'),(5,'User',10046,10061,'Approve','User status changed to Active','2025-02-01 13:32:51'),(6,'Job',18,10063,'Approve','Job status changed to Active','2025-02-12 20:13:22'),(7,'User',10046,10063,'Approve','User status changed to Active','2025-02-13 14:20:13'),(8,'User',10038,10063,'Approve','User status changed to Active','2025-02-13 14:55:09'),(9,'User',10038,10063,'Approve','User status changed to Active','2025-02-13 15:08:49'),(10,'User',10038,10063,'Approve','User status changed to Active','2025-02-13 15:10:48'),(11,'User',10038,10063,'Approve','User status changed to Active','2025-02-13 15:18:44'),(12,'User',10059,10063,'Approve','User status changed to Active','2025-02-13 15:19:46'),(13,'User',10059,10063,'Approve','User status changed to Active','2025-02-13 15:21:37'),(14,'User',10059,10063,'Approve','User status changed to Active','2025-02-13 15:24:53'),(15,'User',10059,10061,'Approve','User status changed to Active','2025-02-13 15:29:51');
/*!40000 ALTER TABLE `verificationlogs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `verificationteam`
--

DROP TABLE IF EXISTS `verificationteam`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `verificationteam` (
  `VT_MemberID` int(10) NOT NULL,
  `FirstName` varchar(45) NOT NULL,
  `LastName` varchar(45) NOT NULL,
  `ProfilePic` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`VT_MemberID`),
  KEY `fk_VerficationTeam_User1_idx` (`VT_MemberID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `verificationteam`
--

LOCK TABLES `verificationteam` WRITE;
/*!40000 ALTER TABLE `verificationteam` DISABLE KEYS */;
INSERT INTO `verificationteam` VALUES (10061,'Pamali','Weerasinghe','67948a7792c892.49388635.png');
/*!40000 ALTER TABLE `verificationteam` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Final view structure for view `companyreviews`
--

/*!50001 DROP VIEW IF EXISTS `companyreviews`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `companyreviews` AS select `c`.`CompanyID` AS `CompanyID`,`c`.`CompanyName` AS `CompanyName`,`c`.`Description` AS `CompanyDescription`,`c`.`CompanyLogo` AS `CompanyLogo`,`r`.`ReviewID` AS `ReviewID`,`r`.`Rating` AS `Rating`,`r`.`Comment` AS `Comment`,`r`.`StudentID` AS `StudentID`,`r`.`created_at` AS `created_at`,concat(`s`.`FirstName`,' ',`s`.`LastName`) AS `StudentName` from ((`company` `c` join `review` `r` on(`c`.`CompanyID` = `r`.`CompanyID`)) join `student` `s` on(`r`.`StudentID` = `s`.`StudentID`)) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `messages_with_roles`
--

/*!50001 DROP VIEW IF EXISTS `messages_with_roles`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `messages_with_roles` AS select `m`.`id` AS `id`,`m`.`user_email` AS `user_email`,`m`.`sender_id` AS `sender_id`,`u1`.`Role` AS `sender_role`,`u1`.`Email` AS `sender_email`,`m`.`receiver_id` AS `receiver_id`,`u2`.`Role` AS `receiver_role`,`u2`.`Email` AS `receiver_email`,`m`.`topic` AS `topic`,`m`.`message` AS `message`,`m`.`created_at` AS `created_at`,`m`.`read_status` AS `read_status` from ((`messages` `m` join `user` `u1` on(`m`.`sender_id` = `u1`.`UserID`)) join `user` `u2` on(`m`.`receiver_id` = `u2`.`UserID`)) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `studentjobcomplaints`
--

/*!50001 DROP VIEW IF EXISTS `studentjobcomplaints`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `studentjobcomplaints` AS select `jobs`.`Title` AS `JobTitle`,`user`.`UserID` AS `CompanyID`,`user`.`Email` AS `CompanyEmail`,`company`.`CompanyName` AS `CompanyName`,`complaint_jobs`.`ComplaintID` AS `ComplaintID`,`complaint_jobs`.`Description` AS `Complaint`,concat(`student`.`FirstName`,' ',`student`.`LastName`) AS `StudentName`,`complaint_jobs`.`ComplainedDate` AS `ComplainedDate`,`complaint_jobs`.`Status` AS `Status` from ((((`complaint_jobs` join `jobs` on(`complaint_jobs`.`JobID` = `jobs`.`JobID`)) join `company` on(`jobs`.`CompanyID` = `company`.`CompanyID`)) join `user` on(`company`.`CompanyID` = `user`.`UserID`)) join `student` on(`complaint_jobs`.`StudentID` = `student`.`StudentID`)) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_bookmarkedjobs`
--

/*!50001 DROP VIEW IF EXISTS `v_bookmarkedjobs`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `v_bookmarkedjobs` AS select `bj`.`StudentID` AS `StudentID`,`j`.`JobID` AS `JobID`,`c`.`CompanyID` AS `CompanyID`,`j`.`Title` AS `Title`,`c`.`CompanyLogo` AS `CompanyLogo`,`c`.`CompanyName` AS `CompanyName`,`j`.`Description` AS `Description`,`j`.`Location` AS `Location`,`j`.`Category` AS `Category`,`j`.`JobBenefits` AS `JobBenefits`,`j`.`Status` AS `Status`,`j`.`RequiredQualifications` AS `RequiredQualifications`,`j`.`SalaryRange` AS `SalaryRange`,`u`.`Email` AS `Email`,`u`.`ContactNo` AS `ContactNo`,`j`.`create_at` AS `jobs_create_at`,`c`.`create_at` AS `company_create_at`,`bj`.`bookmark_create_at` AS `bookmark_create_at` from (((`bookmarkjobs` `bj` join `jobs` `j` on(`bj`.`JobID` = `j`.`JobID`)) join `company` `c` on(`j`.`CompanyID` = `c`.`CompanyID`)) join `user` `u` on(`c`.`CompanyID` = `u`.`UserID`)) order by `bj`.`bookmark_create_at` desc */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_comlaintsforcompany`
--

/*!50001 DROP VIEW IF EXISTS `v_comlaintsforcompany`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `v_comlaintsforcompany` AS select `u`.`UserID` AS `CompanyID`,`u`.`Email` AS `CompanyEmail`,`c`.`CompanyName` AS `CompanyName`,count(`cj`.`ComplaintID`) AS `ComplaintCount`,max(`cj`.`ComplainedDate`) AS `LastComplainedDate` from ((((`complaint_jobs` `cj` join `jobs` `j` on(`cj`.`JobID` = `j`.`JobID`)) join `company` `c` on(`j`.`CompanyID` = `c`.`CompanyID`)) join `user` `u` on(`c`.`CompanyID` = `u`.`UserID`)) join `student` `s` on(`cj`.`StudentID` = `s`.`StudentID`)) group by `u`.`UserID`,`u`.`Email`,`c`.`CompanyName` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_jobs`
--

/*!50001 DROP VIEW IF EXISTS `v_jobs`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `v_jobs` AS select `jobs`.`JobID` AS `JobID`,`company`.`CompanyID` AS `CompanyID`,`jobs`.`Title` AS `Title`,`company`.`CompanyLogo` AS `CompanyLogo`,`company`.`CompanyName` AS `CompanyName`,`company`.`Industry` AS `Industry`,`company`.`Website` AS `Website`,`jobs`.`Description` AS `Description`,`jobs`.`Location` AS `Location`,trim(regexp_replace(concat_ws(', ',`company`.`StreetNo`,`company`.`AddressLine1`,`company`.`AddressLine2`,`company`.`City`),', ,+',',')) AS `Address`,`jobs`.`Category` AS `Category`,`jobs`.`Status` AS `Status`,`jobs`.`JobBenefits` AS `JobBenefits`,`jobs`.`RequiredQualifications` AS `RequiredQualifications`,`jobs`.`SalaryRange` AS `SalaryRange`,`user`.`Email` AS `Email`,`user`.`ContactNo` AS `ContactNo`,`jobs`.`create_at` AS `jobs_create_at`,`company`.`create_at` AS `company_create_at` from ((`jobs` join `company` on(`jobs`.`CompanyID` = `company`.`CompanyID`)) join `user` on(`company`.`CompanyID` = `user`.`UserID`)) order by `jobs`.`create_at` desc */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_verifiedjobs`
--

/*!50001 DROP VIEW IF EXISTS `v_verifiedjobs`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `v_verifiedjobs` AS select `j`.`JobID` AS `JobID`,`j`.`Title` AS `Title`,`j`.`Email` AS `Email`,`j`.`Category` AS `Category`,`j`.`Status` AS `Status`,`v`.`ActionBy` AS `ActionBy`,`v`.`ActionDate` AS `ActionDate` from (`v_jobs` `j` join `verificationlogs` `v` on(`j`.`JobID` = `v`.`EntityID`)) where `v`.`EntityType` = 'Job' and `v`.`Action` = 'Approve' */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_verifiedusers`
--

/*!50001 DROP VIEW IF EXISTS `v_verifiedusers`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `v_verifiedusers` AS select `u`.`UserID` AS `UserID`,`u`.`Email` AS `Email`,`u`.`Role` AS `Role`,`u`.`Status` AS `Status`,`v`.`ActionBy` AS `ActionBy`,`v`.`ActionDate` AS `ActionDate` from (`user` `u` join `verificationlogs` `v` on(`u`.`UserID` = `v`.`EntityID`)) where `v`.`EntityType` = 'User' and `v`.`Action` = 'Approve' */;
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

-- Dump completed on 2025-02-16 21:34:57
