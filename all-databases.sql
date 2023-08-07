-- MySQL dump 10.13  Distrib 8.0.33, for Linux (x86_64)
--
-- Host: 127.0.0.1    Database: mecab
-- ------------------------------------------------------
-- Server version	8.0.33-0ubuntu0.22.04.4

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

DROP DATABASE IF EXISTS `mecab`;
CREATE DATABASE `mecab`;
USE `mecab`;

--
-- Table structure for table `car_brand`
--

DROP TABLE IF EXISTS `car_brand`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `car_brand` (
  `car_brand_id` int NOT NULL AUTO_INCREMENT,
  `brand_name` varchar(100) NOT NULL,
  PRIMARY KEY (`car_brand_id`),
  UNIQUE KEY `brand_name` (`brand_name`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `car_brand`
--

LOCK TABLES `car_brand` WRITE;
/*!40000 ALTER TABLE `car_brand` DISABLE KEYS */;
INSERT INTO `car_brand` VALUES (1,'BMW'),(7,'Chevrolet'),(4,'Honda'),(8,'Hundai'),(2,'Jeep'),(5,'Mercedes-Benz'),(9,'Opel'),(6,'Tesla'),(3,'Toyota');
/*!40000 ALTER TABLE `car_brand` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `car_model`
--

DROP TABLE IF EXISTS `car_model`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `car_model` (
  `car_model_id` int NOT NULL AUTO_INCREMENT,
  `model_name` varchar(100) NOT NULL,
  `car_brand_id` int NOT NULL,
  PRIMARY KEY (`car_model_id`),
  UNIQUE KEY `model_name` (`model_name`),
  KEY `car_model_ibfk_1` (`car_brand_id`),
  CONSTRAINT `car_model_ibfk_1` FOREIGN KEY (`car_brand_id`) REFERENCES `car_brand` (`car_brand_id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `car_model`
--

LOCK TABLES `car_model` WRITE;
/*!40000 ALTER TABLE `car_model` DISABLE KEYS */;
INSERT INTO `car_model` VALUES (1,'C-Class',5),(2,'E-Class',5),(3,'S-Class',5),(4,'GLE',5),(5,'GLC',5),(6,'3 Series',1),(7,'5 Series',1),(8,'7 Series',1),(9,'X3',1),(10,'X5',1),(11,'Camry',3),(12,'Corolla',3),(13,'RAV4',3),(14,'Highlander',3),(15,'Tacoma',3),(16,'Accord',4),(17,'Civic',4),(18,'CR-V',4),(19,'Pilot',4),(20,'Odyssey',4),(21,'Wrangler',2),(22,'Grand Cherokee',2),(23,'Cherokee',2),(24,'Renegade',2),(25,'Compass',2),(26,'Model S',6),(27,'Model 3',6),(28,'Model X',6),(29,'Model Y',6),(30,'Cybertruck',6);
/*!40000 ALTER TABLE `car_model` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `categories` (
  `category_id` int NOT NULL AUTO_INCREMENT,
  `category_name` varchar(200) NOT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (1,'Engine Components'),(2,'Suspension and Steering Parts'),(3,'Brake System Parts'),(4,'Electrical Components'),(5,'Exhaust System Parts'),(6,'Transmission and Drivetrain Parts'),(7,'Cooling System Parts'),(8,'Fuel System Parts'),(9,'Ignition System Parts'),(10,'Body and Exterior Parts'),(11,'Interior Parts and Accessories'),(12,'HVAC (Heating, Ventilation, and Air Conditioning) Parts'),(13,'Lighting Components'),(14,'Wiper and Washer System Parts'),(15,'Filters (Air, Oil, Fuel, etc.)'),(16,'Belts and Hoses'),(17,'Gaskets and Seals'),(18,'Bearings and Bushings'),(19,'Fluids and Lubricants'),(20,'Performance Parts and Accessories');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mech_specialisation`
--

DROP TABLE IF EXISTS `mech_specialisation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `mech_specialisation` (
  `ms_id` int NOT NULL AUTO_INCREMENT,
  `users_id` int NOT NULL,
  `specialisation` char(50) NOT NULL,
  PRIMARY KEY (`ms_id`),
  KEY `users_id` (`users_id`),
  CONSTRAINT `mech_specialisation_ibfk_1` FOREIGN KEY (`users_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mech_specialisation`
--

LOCK TABLES `mech_specialisation` WRITE;
/*!40000 ALTER TABLE `mech_specialisation` DISABLE KEYS */;
INSERT INTO `mech_specialisation` VALUES (1,13,'Auto Electrician'),(2,13,'Auto Electrician'),(3,13,'Auto Electrician'),(4,13,'Auto Electrician'),(5,13,'Auto Electrician');
/*!40000 ALTER TABLE `mech_specialisation` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `spare_part_car_model`
--

DROP TABLE IF EXISTS `spare_part_car_model`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `spare_part_car_model` (
  `spare_part_car_model_id` int NOT NULL AUTO_INCREMENT,
  `spare_part_id` int NOT NULL,
  `car_model_id` int NOT NULL,
  PRIMARY KEY (`spare_part_car_model_id`),
  KEY `spare_part_car_model_ibfk_2` (`car_model_id`),
  CONSTRAINT `spare_part_car_model_ibfk_2` FOREIGN KEY (`car_model_id`) REFERENCES `car_model` (`car_model_id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `spare_part_car_model`
--

LOCK TABLES `spare_part_car_model` WRITE;
/*!40000 ALTER TABLE `spare_part_car_model` DISABLE KEYS */;
/*!40000 ALTER TABLE `spare_part_car_model` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `spare_parts`
--

DROP TABLE IF EXISTS `spare_parts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `spare_parts` (
  `sparepart_id` varchar(36) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text,
  `price` decimal(10,2) NOT NULL,
  `image` varchar(255) NOT NULL,
  `category_id` int NOT NULL,
  `store_id` int NOT NULL,
  `car_brand_id` int DEFAULT NULL,
  `car_model_id` int DEFAULT NULL,
  PRIMARY KEY (`sparepart_id`),
  KEY `store_id` (`store_id`),
  KEY `car_brand_id` (`car_brand_id`),
  KEY `car_model_id` (`car_model_id`),
  KEY `spare_parts` (`category_id`),
  CONSTRAINT `spare_parts_ibfk_1` FOREIGN KEY (`store_id`) REFERENCES `stores` (`store_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `spare_parts_ibfk_2` FOREIGN KEY (`car_brand_id`) REFERENCES `car_brand` (`car_brand_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `spare_parts_ibfk_3` FOREIGN KEY (`car_model_id`) REFERENCES `car_model` (`car_model_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `spare_parts_ibfk_4` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `spare_parts`
--

LOCK TABLES `spare_parts` WRITE;
/*!40000 ALTER TABLE `spare_parts` DISABLE KEYS */;
INSERT INTO `spare_parts` VALUES ('1d330bbf-30f8-11ee-ad25-00e93a64cecb','Brake Part','For brake system',650.00,'64c9ee054ef0c_brakes-and-brakepads.jpg',3,18,5,3),('95949a37-308e-11ee-ad25-00e93a64cecb','Fan Blade','A fan blade for all car engine',56.00,'64c93cf87fb7a_ray-passport.jpg',7,18,6,29);
/*!40000 ALTER TABLE `spare_parts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `stores`
--

DROP TABLE IF EXISTS `stores`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `stores` (
  `store_id` int NOT NULL AUTO_INCREMENT,
  `store_name` varchar(100) NOT NULL,
  `store_type` char(60) NOT NULL,
  `store_email` varchar(70) DEFAULT NULL,
  `store_town` varchar(50) NOT NULL,
  `store_location` varchar(50) NOT NULL,
  `gps_address` varchar(15) DEFAULT NULL,
  `street_name` varchar(30) DEFAULT NULL,
  `store_contact` varchar(10) NOT NULL,
  PRIMARY KEY (`store_id`)
) ENGINE=InnoDB AUTO_INCREMENT=63 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `stores`
--

LOCK TABLES `stores` WRITE;
/*!40000 ALTER TABLE `stores` DISABLE KEYS */;
INSERT INTO `stores` VALUES (17,'wicks','Transport','wicks@email.com','','','ce-0009-3129','spartan street','0205823707'),(18,'irbba','Spare parts','irbba@email.com','Takoradi','West Tanokrom','ce-0009-3129','spartan street','0247692388'),(19,'coastal','Transport','coastal@email.com','','','ce-787-2323','cosmos street','0209876543'),(20,'savannah','Spare parts','savannah@email.com','','','ce-787-2312','cosmos street','0549876321'),(21,'Savanna','Mechanic','savanna@email.com','','','CE-787-2312','Commercial Road','0549876320'),(22,'Matri','Spare parts','matri@email.com','','','CE-055-285','Cultate','0541524682'),(23,'Itel','Spare parts','itel@email.com','','','GT-0999-233','Money','0564321789'),(24,'Nightpart','Spare parts','nightpart@email.com','','','VO-8882-909','Cider','0259134678'),(25,'Enzyme Mechanical Shop','Mechanic','gabenzyme@live.com','','','CC-234-345','Sankor','0248165601'),(26,'Covid','Spare parts','covid@email.com','','','GE-0898-009','Techhub','0908876511'),(27,'Skydash','Transport','skydash@email.com','','','SK-321-9908','Sky','0241356787'),(28,'Meccah','Mechanic','meccah@email.com','','','GK-8900-8832','Gake','0241356769'),(31,'Meyah','Spare parts','meyah@email.com','','','GK-8900-8833','Gake','0241356786'),(32,'Mediah','Spare parts','mediah@email.com','','','GK-8200-8833','Bake','0251356786'),(33,'Mepah','Transport','mepah@email.com','','','GK-8200-8233','Pack','0251356986'),(34,'S-cars','Transport','scars@email.com','','','GK-8600-8233','Sdays','0271356986'),(35,'Club','Spare parts','club@email.com','','','GK-8610-8233','Sdays','0261356986'),(36,'Bear','Spare parts','bear@email.com','','','GK-8619-8233','Jckk','0271354988'),(37,'Star','Spare parts','star@email.com','','','GK-9619-8233','Jckc','0201354988'),(38,'Bearstar','Spare parts','bearstar@email.com','','','GK-9619-8233','Jckc','0501354988'),(39,'Clubbear','Spare parts','clubbear@email.com','','','GK-619-823','Jcka','0551354988'),(40,'Manzy','Spare parts','manzy@email.com','','','GK-619-803','Jcka','0551350983'),(41,'Banzy','Spare parts','banzy@email.com','','','GK-609-803','Jcka','0251350983'),(42,'Starbear','Mechanic','starbear@email.com','','','GK-900-8832','Olympic','0241356707'),(43,'Photo','Mechanic','photo@email.com','','','GK-908-8832','Olympic','0241356797'),(44,'Glare','Spare parts','glare@email.com','','','GK-998-8832','Olympic','0242356797'),(45,'Windows','Car rentals','windows@email.com','','','GK-8910-832','Olympic','0571356986'),(46,'Exude','Car rentals','exudetimes@gmail.com','','','CE-345-0001','Graves','0241215756'),(47,'Bel-Aqua','Car rentals','belaqua@email.com','','','BY-890-765','Aauii','0245556789'),(48,'Doc Eben ','Car rentals','eden@yahoo.com','','','WS-345-765','Supomom','0245988676'),(50,'Movavi','Car rentals','movavi@email.com','','','DE-625-5112','Kotobabi','0246851236'),(51,'Infoctess','Car rentals','noreply@infoctess.org','','','CE-783-0993','South Campus','0240317985'),(52,'Lucky','Car rentals','lucky@email.com','','','CE-7843-3214','Funko','0241006789'),(53,'Main','Car rentals','main@email.com','','','BA-987-1234','Main Campus','0331234567'),(54,'Xanji','Car rentals','xanji@gmai.com','','','GA-234-442','Kaneshie ','0556435681'),(55,'D Arts','Car rentals','mendeley@email.com','','','JK-008-635','Desktop','0200751420'),(56,'Mandeley','Car rentals','mandeley@email.com','','','JK-0108-635','Desktop-on','0243800236'),(57,'Mondeley','Car rentals','mondeley@email.com','','','JK-1108-635','Desktop-top','0243100236'),(58,'iQcoTECH','Car rentals','mundeley@email.com','','','JK-1108-6359','Desktop-Off','0248165601'),(59,'Mindeley','Car rentals','mindeley@email.com','','','JK-118-6359','Desktop-Over','0243150233'),(60,'Myndeley','Car rentals','myndeley@email.com','','','JK-1168-6359','Desktop-Cover','0243150253'),(61,'JobPartGh','Car rentals','jobpart@email.com','','','YE-980-213','Next','0240317980'),(62,'Pence','Car rentals','pence@email.com','','','BA-3711-098','Akoma Pa','0552857597');
/*!40000 ALTER TABLE `stores` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_store_otp`
--

DROP TABLE IF EXISTS `user_store_otp`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_store_otp` (
  `otp_id` int NOT NULL AUTO_INCREMENT,
  `store_id` int DEFAULT NULL,
  `users_id` int DEFAULT NULL,
  `otp_code` varchar(6) DEFAULT NULL,
  `otp_expiration` datetime DEFAULT NULL,
  `otp_verified` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`otp_id`),
  UNIQUE KEY `otp_code` (`otp_code`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_store_otp`
--

LOCK TABLES `user_store_otp` WRITE;
/*!40000 ALTER TABLE `user_store_otp` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_store_otp` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `user_id` int NOT NULL AUTO_INCREMENT,
  `first_name` varchar(25) NOT NULL,
  `last_name` varchar(25) NOT NULL,
  `other_names` varchar(25) DEFAULT NULL,
  `users_email` varchar(70) NOT NULL,
  `users_password` varchar(255) NOT NULL,
  `users_role` char(20) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (2,'Kofi','','Ababio','ababiokofi@email.com','$2y$10$qAyM2OpJhzEJm0k3lkunJujhlYkoDeyrKwwp3ao4cRMWZ.iouD0ce','Customer'),(7,'Info','Tech','Com','infocomtech@email.com','$2y$10$9UiQ4TYYsHsep7XzV48E7esJwOkGWIRWYMNwZ9n38XH3LoH5ze9D6','Customer'),(8,'Hayford','Agyei','Adu','hayfordaduagyei@email.com','$2y$10$92Uts16x0Lv8BFOLycYyMu4bwNYRkmT/lHCVoFqcaTwz5KvfOQ5Tq','Transport'),(9,'Bernard','Opoku','','bernardopoku@email.com','$2y$10$uk/mtGlevCPnjHroEvoqn.Uix6UzqenbPmykaHYXpNTCkFxaHRaw6','Transport'),(10,'Christopher','Abisa','Yaw','christopheryawabisa@email.com','$2y$10$yNAQiXovbO/ktr5Xo8eSF.Sn8.ptW1cNltOXXA57A865FDRLZrgPC','Customer'),(11,'Jose','Nketsia',NULL,'josephnketsia@email.com','$2y$10$vR6U9dmILvrDZWPo.McyAe/yqsdPZjtsyHX1OILnD0GhdDFnERGw6','Spare parts'),(12,'Aziiba','Raymond','','aziibaraymond@email.com','$2y$10$GLhg.3ObiuBqe9FNEbDYI.L2pzMkmx2obEnb.9bq.z/JQqFYPXhgi','Customer'),(13,'Jack','Ryan',NULL,'jackryan@email.com','$2y$10$ERfFJOfk/y/MO2ld8edWaeD2fuXAyw2b9P9E8CZ4RDUMMXPekORRO','Mechanic'),(14,'James','Greer',NULL,'jamesgreer@email.com','$2y$10$rl5C/lu/e7VouMquuoq2l.vzCNiOhxPlfh19R4.wJIkb3bF3th1xu','Admin'),(15,'Brandon','Oliver','Mike','bmoliver@email.com','$2y$10$VWmPQgYd5KgQDW9FbMLsy.0P31lZIlzXerDDdzqYgOU4oUdl/WA66','Mechanic'),(16,'Esther','Kwarteng','afram','estherak@email.com','$2y$10$ebHp9CkMeFTJdNtBdy4cYeRp2xvN/.siVM81Zsi33CR8qwwa4zQ/S','Customer'),(17,'Marcel','Obiba','JK','mjkobiba@email.com','$2y$10$0PbbHvk162FkzNvphHWlkOg3QPpOXh/xPBcQljlIYqnToPuxPTry6','Mechanic'),(18,'eugene','bamfo','','eugenebamfo@email.com','$2y$10$5XRebYt7/8diCxH3HmCgBOXdTVhBRLkZY1J.qTGD89XxfXIsKfDoG','Mechanic'),(19,'Sabina','Atta','Ekua','seatta@email.com','$2y$10$mwVum4nxS9FHUExsoxQcXeyE4N/ORYxZTPJCZ/uizzTjU6mqjmrX.','Spare parts'),(20,'Ekow','Menu','','ekowmenu@emai.com','$2y$10$MXgILIj/O0ODZeOhf6sr2u7wGiJU5l3Zndn3E3zp0chJGsHqj0wAG','Spare parts'),(21,'Kojo','Bosom','','kojobosom@email.com','$2y$10$wQ0c/QVCPapVAuzOIqAU.egS5uqzdgq6bLfS1uw0j4alxIJnlcpaq','Customer'),(22,'Koo','Mensah','','koomensah@email.com','$2y$10$vQY2qG1PqSsBGKyQyL.JcOn4gNFYZ1szN4y2GfM51mpkje1/CZFNO','Customer'),(23,'Daniel','Affum','','danielaffum@email.com','$2y$10$t/Dr7WbuUW6yWbLlXhpQtewUfI5Wo5cJnISORFCyrRJFG4pWESB46','Mechanic'),(24,'Patrick','McDan','','mcdanpatrick@email.com','$2y$10$VSpl8JFID5E836K49F88MuPXc1U6K/CvVxnXjgOJXBpdDr28z92h.','Spare parts'),(25,'Justice','Dadzie','','justicedadzie@email.com','$2y$10$3OUUL66djC8HEp44i4Mm5Og/B2PvBeywMtLMU4AglUHLxX1mMb8A2','Mechanic'),(26,'Samson','Adu','','samsonadu@email.com','$2y$10$qr1L4NYAHV7vhCf7IjNjoeo/M0CAY0P5i5UGnwdgdpLho/6kzzB8O','Customer'),(27,'Jacob','James','','jj@email.com','$2y$10$Ve2brK1HE3W6jdKTW5J/MuPDPctN3JWg5SCEW2QSH1taBBGzvqh46','Spare parts'),(28,'Isaac','Kwofie','','isaackwofie@email.com','$2y$10$bHUVPJXa6Wg3cIY7WlX8F.zcp9mTpDd.Zzr5T.JYrf15ApsVICRK2','Mechanic'),(29,'Bright','Arthur','','brightarthur@email.com','$2y$10$PmA2AxAUfcYWrOiUbltjCOWgK3Wgt3ST4hOLBZ4oOCkepjB1dP1bW','Spare parts'),(30,'Papa','Yaw','','papayaw@email.com','$2y$10$QZoQXkRnCHcqFI1o6aJmkOjR5Ug4PTqR5eitXmUmZn2GmWPXkdZGS','Transport'),(31,'Sam','Baba','','sambaba@email.com','$2y$10$q.iWB0I/O7gSJrt/533G/OKl6aTdNWokrKIVe5jZalL65xUNYkrxK','Mechanic'),(32,'Kwame','Atta','','kwameatta@email.com','$2y$10$VPkNAp9EahxKeYiAkEqOHeTpyILUUAJKKbh8r08RZ.knRV6jXvpSC','Spare parts'),(33,'Jason','Sancho','','jasonsancho@email.com','$2y$10$WB.9iLRrfT59w2yDTlQkCeb5J8IfzOk7g.Kl3cQasP0/FzGayTNqC','Transport'),(34,'Peter','Pan','','peterpan@email.com','$2y$10$PAgfuQqjf9UofIYha76b1esbLaqe/X1DIwW6XsAyNfoki5ezyokKq','Mechanic'),(35,'Adwoa','Mansa','','adwoamansa@email.com','$2y$10$VJdRc418QIq4Kg/eTlS3XOjHCWdLYKLnysXg9kUHmqa3FwGvBnI4C','Spare parts'),(36,'Paa','Kwesi','','paakwesi@email.com','$2y$10$fW49AxrOmCyOJ3lRZmESp.6aWJdx4nckWC6qDJxboEkqw2TxATwk.','Car rentals'),(37,'Egya','Andoh','','egyaandoh@email.com','$2y$10$cupIm/6Lcewl/qiQ3bAxBeuUdl5V99Wm6HbLkd6s8wriw2HbKPNBC','Car rentals'),(38,'Paa','Kobina','','paakobina@email.com','$2y$10$6yFZfzRrDDXrYpdAg5eaTuUG70PG58ieWfYIcqqlplLfsw9xxGDZu','Car rentals'),(39,'Gabriel','Quartson','','gabrielquartson@email.com','$2y$10$y9eprk6.wLneJ5ECggvy4uBvuZnvN.AElsXxm1L1iLCk95L7DGzBe','Car rentals'),(40,'Moses','Mensah','','mosesmensah@email.com','$2y$10$Aoz4mVyICUbJRlGP3/eoYeL2sqz2YrHHMV9zDJ9k1Ol167icMCTRy','Car rentals');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users_contact`
--

DROP TABLE IF EXISTS `users_contact`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users_contact` (
  `contact_id` int NOT NULL AUTO_INCREMENT,
  `users_id` int NOT NULL,
  `users_contact` varchar(10) NOT NULL,
  PRIMARY KEY (`contact_id`),
  UNIQUE KEY `users_contact` (`users_contact`),
  UNIQUE KEY `users_id` (`users_id`),
  CONSTRAINT `users_contact_ibfk_1` FOREIGN KEY (`users_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users_contact`
--

LOCK TABLES `users_contact` WRITE;
/*!40000 ALTER TABLE `users_contact` DISABLE KEYS */;
INSERT INTO `users_contact` VALUES (1,13,'0247692388'),(5,27,'0242325963'),(6,26,'0555132987'),(7,22,'0244952234'),(8,19,'0244952000'),(9,11,'0552857112'),(10,32,'0552857134'),(11,2,'0248165601'),(14,14,'0205823707');
/*!40000 ALTER TABLE `users_contact` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users_store`
--

DROP TABLE IF EXISTS `users_store`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users_store` (
  `ss_id` int NOT NULL AUTO_INCREMENT,
  `users_id` int NOT NULL,
  `store_id` int NOT NULL,
  `verification_status` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`ss_id`),
  KEY `store_id` (`store_id`),
  KEY `users_id` (`users_id`),
  CONSTRAINT `users_store_ibfk_1` FOREIGN KEY (`store_id`) REFERENCES `stores` (`store_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `users_store_ibfk_2` FOREIGN KEY (`users_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users_store`
--

LOCK TABLES `users_store` WRITE;
/*!40000 ALTER TABLE `users_store` DISABLE KEYS */;
INSERT INTO `users_store` VALUES (1,13,18,1),(2,14,17,1),(3,27,18,1),(4,19,18,1),(5,11,18,1),(6,32,18,1);
/*!40000 ALTER TABLE `users_store` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping events for database 'mecab'
--

--
-- Dumping routines for database 'mecab'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-08-03 14:50:18
-- MySQL dump 10.13  Distrib 8.0.33, for Linux (x86_64)
--
-- Host: 127.0.0.1    Database: sap_axim
-- ------------------------------------------------------
-- Server version	8.0.33-0ubuntu0.22.04.4

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

DROP DATABASE IF EXISTS `sap_axim`;
CREATE DATABASE `sap_axim`;
USE `sap_axim`;
--
-- Table structure for table `address`
--

DROP TABLE IF EXISTS `address`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `address` (
  `Id` int NOT NULL AUTO_INCREMENT,
  `MiD` int NOT NULL,
  `Street_name` varchar(30) DEFAULT NULL,
  `House_number` varchar(10) DEFAULT NULL,
  `GPS_address` varchar(15) NOT NULL,
  `Postal_address` varchar(30) DEFAULT NULL,
  `Phone_number` varchar(18) NOT NULL,
  `Email` varchar(60) DEFAULT NULL,
  PRIMARY KEY (`Id`),
  UNIQUE KEY `MiD` (`MiD`),
  CONSTRAINT `address_ibfk_1` FOREIGN KEY (`MiD`) REFERENCES `members` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `address`
--

LOCK TABLES `address` WRITE;
/*!40000 ALTER TABLE `address` DISABLE KEYS */;
INSERT INTO `address` VALUES (1,1,'Beach Road','BR909','WS-505-6547','P.O.BOX 16, AXIM','024762388','raymondaffedzie@email.com');
/*!40000 ALTER TABLE `address` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `church`
--

DROP TABLE IF EXISTS `church`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `church` (
  `Id` int NOT NULL AUTO_INCREMENT,
  `MiD` int NOT NULL,
  `Baptism_card_number` varchar(10) DEFAULT NULL,
  `Baptism_date` date DEFAULT NULL,
  `Confirmation_number` varchar(10) DEFAULT NULL,
  `Confirmation_datE` date DEFAULT NULL,
  PRIMARY KEY (`Id`),
  UNIQUE KEY `MiD` (`MiD`),
  CONSTRAINT `church_ibfk_1` FOREIGN KEY (`MiD`) REFERENCES `members` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `church`
--

LOCK TABLES `church` WRITE;
/*!40000 ALTER TABLE `church` DISABLE KEYS */;
/*!40000 ALTER TABLE `church` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `family`
--

DROP TABLE IF EXISTS `family`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `family` (
  `Id` int NOT NULL AUTO_INCREMENT,
  `MiD` int NOT NULL,
  `Mother_name` varchar(50) NOT NULL,
  `M_decease` char(1) NOT NULL,
  `Father_name` varchar(50) NOT NULL,
  `F_decease` char(1) NOT NULL,
  `Next_of_kin` varchar(50) DEFAULT NULL,
  `NoK_contact` varchar(18) DEFAULT NULL,
  `NoK_GPS_address` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`Id`),
  UNIQUE KEY `MiD` (`MiD`),
  CONSTRAINT `family_ibfk_1` FOREIGN KEY (`MiD`) REFERENCES `members` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `family`
--

LOCK TABLES `family` WRITE;
/*!40000 ALTER TABLE `family` DISABLE KEYS */;
INSERT INTO `family` VALUES (1,1,'Selina Sagoe','A','John Affedzie','A','Nicholas Sagoe','0242325963','WN-0006-9090');
/*!40000 ALTER TABLE `family` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `members`
--

DROP TABLE IF EXISTS `members`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `members` (
  `Id` int NOT NULL AUTO_INCREMENT,
  `Init` char(3) NOT NULL DEFAULT 'SAP',
  `Reg_year` year NOT NULL,
  `Firstname` varchar(25) NOT NULL,
  `Sur_name` varchar(25) NOT NULL,
  `Other_name` varchar(25) NOT NULL,
  `Sex` char(1) NOT NULL,
  `Birth_Date` date NOT NULL,
  `Birth_Place` varchar(20) NOT NULL,
  `Birth_Region` varchar(30) DEFAULT NULL,
  `Birth_District` varchar(60) DEFAULT NULL,
  PRIMARY KEY (`Id`,`Init`,`Reg_year`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `members`
--

LOCK TABLES `members` WRITE;
/*!40000 ALTER TABLE `members` DISABLE KEYS */;
INSERT INTO `members` VALUES (1,'SAP',2023,'Raymond','Affedzie','Kojo','M','1999-11-01','Shama','WR','Shama');
/*!40000 ALTER TABLE `members` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `other_info`
--

DROP TABLE IF EXISTS `other_info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `other_info` (
  `Id` int NOT NULL AUTO_INCREMENT,
  `MiD` int NOT NULL,
  `Marital_status` char(10) NOT NULL,
  `Number_of_children` int NOT NULL,
  `Education_level` char(15) NOT NULL,
  `Occupation` char(20) NOT NULL,
  PRIMARY KEY (`Id`),
  UNIQUE KEY `MiD` (`MiD`),
  CONSTRAINT `other_info_ibfk_1` FOREIGN KEY (`MiD`) REFERENCES `members` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `other_info`
--

LOCK TABLES `other_info` WRITE;
/*!40000 ALTER TABLE `other_info` DISABLE KEYS */;
INSERT INTO `other_info` VALUES (1,1,'Single',0,'Tertiary','Software Developer');
/*!40000 ALTER TABLE `other_info` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset`
--

DROP TABLE IF EXISTS `password_reset`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset` (
  `Pwd_reset_id` int NOT NULL AUTO_INCREMENT,
  `Pwd_reset_email` varchar(60) NOT NULL,
  `Pwd_reset_token` int NOT NULL,
  PRIMARY KEY (`Pwd_reset_id`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset`
--

LOCK TABLES `password_reset` WRITE;
/*!40000 ALTER TABLE `password_reset` DISABLE KEYS */;
INSERT INTO `password_reset` VALUES (41,'raymondaffedzie@gmail.com',582524);
/*!40000 ALTER TABLE `password_reset` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `society`
--

DROP TABLE IF EXISTS `society`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `society` (
  `Id` int NOT NULL AUTO_INCREMENT,
  `MiD` int NOT NULL,
  `Society_name` varchar(30) DEFAULT NULL,
  `Position_held` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`Id`),
  UNIQUE KEY `MiD` (`MiD`),
  CONSTRAINT `society_ibfk_1` FOREIGN KEY (`MiD`) REFERENCES `members` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `society`
--

LOCK TABLES `society` WRITE;
/*!40000 ALTER TABLE `society` DISABLE KEYS */;
/*!40000 ALTER TABLE `society` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `Id` int NOT NULL AUTO_INCREMENT,
  `Firstname` varchar(25) NOT NULL,
  `Surname` varchar(25) NOT NULL,
  `Username` varchar(18) NOT NULL,
  `Phone_number` varchar(18) NOT NULL,
  `Email` varchar(60) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Pwd_reset_token` int NOT NULL,
  `Role` char(1) NOT NULL DEFAULT 'M',
  `Status` char(1) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Ray','Berth','berth_ray','0247692388','raymondaffedzie@gmail.com','$2y$10$lmKh11itlDVySVIa2UootOUSDS3liJWnVD6G0aIPu4rADyPgnWxum',463812,'A','A'),(2,'John','Doe','johndoe','7231045687','johndoe@email.com','$2y$10$vF4KjDPVUiQFVNKU3sYgZu84d8qhG87OXL7fUbjn3.PEltmnF1qpu',0,'M','A');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping events for database 'sap_axim'
--

--
-- Dumping routines for database 'sap_axim'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-08-03 14:50:18
-- MySQL dump 10.13  Distrib 8.0.33, for Linux (x86_64)
--
-- Host: 127.0.0.1    Database: ptln
-- ------------------------------------------------------
-- Server version	8.0.33-0ubuntu0.22.04.4

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

DROP DATABASE IF EXISTS `ptln`;
CREATE DATABASE `ptln`;
USE `ptln`;
--
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `admin` (
  `Id` int NOT NULL AUTO_INCREMENT,
  `Firstname` varchar(25) NOT NULL,
  `Surname` varchar(25) NOT NULL,
  `Username` varchar(18) NOT NULL,
  `Phone_number` varchar(18) NOT NULL,
  `Email` varchar(60) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Pwd_reset_token` int NOT NULL,
  `Role` char(1) NOT NULL DEFAULT 'M',
  `Status` char(1) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin`
--

LOCK TABLES `admin` WRITE;
/*!40000 ALTER TABLE `admin` DISABLE KEYS */;
INSERT INTO `admin` VALUES (1,'Ray','Berth','berth_ray','0247692388','raymondaffedzie@gmail.com','$2y$10$lmKh11itlDVySVIa2UootOUSDS3liJWnVD6G0aIPu4rADyPgnWxum',463812,'A','A'),(2,'John','Doe','johndoe','7231045687','johndoe@email.com','$2y$10$vF4KjDPVUiQFVNKU3sYgZu84d8qhG87OXL7fUbjn3.PEltmnF1qpu',0,'M','A');
/*!40000 ALTER TABLE `admin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `carousel`
--

DROP TABLE IF EXISTS `carousel`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `carousel` (
  `carousel_id` varchar(15) NOT NULL,
  `image_name` varchar(255) NOT NULL,
  `date` int NOT NULL,
  `admin_id` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`carousel_id`),
  KEY `admin_id` (`admin_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `carousel`
--

LOCK TABLES `carousel` WRITE;
/*!40000 ALTER TABLE `carousel` DISABLE KEYS */;
/*!40000 ALTER TABLE `carousel` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `events`
--

DROP TABLE IF EXISTS `events`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `events` (
  `event_id` int NOT NULL AUTO_INCREMENT,
  `tittle` varchar(200) NOT NULL,
  `content` varchar(1000) NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `venue` varchar(200) NOT NULL,
  `town` varchar(200) NOT NULL,
  `country` varchar(200) NOT NULL,
  `info_email` varchar(60) DEFAULT NULL,
  `info_contact` varchar(20) DEFAULT NULL,
  `admin_id` int NOT NULL,
  PRIMARY KEY (`event_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `events`
--

LOCK TABLES `events` WRITE;
/*!40000 ALTER TABLE `events` DISABLE KEYS */;
INSERT INTO `events` VALUES (1,'Girls In Information Technology Training','1. Web Development 2. Multimedia authoring (Adobe photoshop, Adobe premiere) 3. Microsoft Office Suite','2022-07-25','07:30:00','Irrba Training Center','Takoradi','Ghana','irrbawebsdev@gmail.com','0205823707',2),(3,'Musical Concert','A musical event organized by musical groups in University of Education, Winneba. This program is meant to bring joy to the university community.','2022-08-05','18:30:00','Jophous Anamoah Conference Center','Winneba','Ghana','irbbawebsdev@gmail.com','0205823707',2);
/*!40000 ALTER TABLE `events` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `events_likes`
--

DROP TABLE IF EXISTS `events_likes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `events_likes` (
  `evntlike_id` varchar(15) NOT NULL,
  `event_id` varchar(15) NOT NULL,
  `member_id` varchar(15) NOT NULL,
  PRIMARY KEY (`evntlike_id`),
  UNIQUE KEY `member_id` (`member_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `events_likes`
--

LOCK TABLES `events_likes` WRITE;
/*!40000 ALTER TABLE `events_likes` DISABLE KEYS */;
/*!40000 ALTER TABLE `events_likes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `members`
--

DROP TABLE IF EXISTS `members`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `members` (
  `member_id` int NOT NULL AUTO_INCREMENT,
  `firstname` varchar(25) NOT NULL,
  `surname` varchar(35) NOT NULL,
  `email` varchar(65) NOT NULL,
  `phone_number` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `means_of_contact` varchar(15) NOT NULL,
  `status` varchar(15) NOT NULL,
  PRIMARY KEY (`member_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `members`
--

LOCK TABLES `members` WRITE;
/*!40000 ALTER TABLE `members` DISABLE KEYS */;
INSERT INTO `members` VALUES (1,'Raymond','Affedzie','raymondaffedzie@gmail.com','0205823707','$2y$10$yGovB.AbEBAKD8etU3AJv.qagepsjP1S2sVfVlTHR6WPEknxSZSTW','email','Active');
/*!40000 ALTER TABLE `members` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `motivation`
--

DROP TABLE IF EXISTS `motivation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `motivation` (
  `motiv_id` varchar(15) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_extension` varchar(5) NOT NULL,
  `admin_id` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`motiv_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `motivation`
--

LOCK TABLES `motivation` WRITE;
/*!40000 ALTER TABLE `motivation` DISABLE KEYS */;
/*!40000 ALTER TABLE `motivation` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `news`
--

DROP TABLE IF EXISTS `news`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `news` (
  `new_id` int NOT NULL AUTO_INCREMENT,
  `tittle` text NOT NULL,
  `content` longtext NOT NULL,
  `image` varchar(250) DEFAULT NULL,
  `publisher_name` text NOT NULL,
  `admin_id` int NOT NULL,
  `date` date NOT NULL,
  `source` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`new_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `news`
--

LOCK TABLES `news` WRITE;
/*!40000 ALTER TABLE `news` DISABLE KEYS */;
INSERT INTO `news` VALUES (1,'Contrary to popular belief','Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. \r\n\r\nLorem Ipsum comes from sections 1.10.32 and 1.10.33 of \"de Finibus Bonorum et Malorum\" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, \"Lorem ipsum dolor sit amet..\", comes from a line in section 1.10.32','news62d5751fc2fcd9.34375530.jpg','Jog Joe',2,'2022-07-12','Lorem Ipsum'),(2,'Lorem Ipsum is simply dummy text of the printing and typesetting industry','It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).\r\n','news62d571d1069620.66713739.jpg','Dummy Text',2,'2022-07-13','Lorem Ipsum'),(5,'Why do we use it?','It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).','news62d5755fa367c0.53931035.jpg','Lorem Ipsum',2,'2022-07-18','https://www.lipsum.com/');
/*!40000 ALTER TABLE `news` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `news_comments`
--

DROP TABLE IF EXISTS `news_comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `news_comments` (
  `nwscmnt_id` varchar(15) NOT NULL,
  `news_id` varchar(15) NOT NULL,
  `member_id` varchar(15) NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`nwscmnt_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `news_comments`
--

LOCK TABLES `news_comments` WRITE;
/*!40000 ALTER TABLE `news_comments` DISABLE KEYS */;
/*!40000 ALTER TABLE `news_comments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `news_like`
--

DROP TABLE IF EXISTS `news_like`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `news_like` (
  `nwslike_id` varchar(15) NOT NULL,
  `news_id` varchar(15) NOT NULL,
  `member_id` varchar(15) NOT NULL,
  PRIMARY KEY (`nwslike_id`),
  KEY `member_id` (`member_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `news_like`
--

LOCK TABLES `news_like` WRITE;
/*!40000 ALTER TABLE `news_like` DISABLE KEYS */;
/*!40000 ALTER TABLE `news_like` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset`
--

DROP TABLE IF EXISTS `password_reset`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset` (
  `pwd_reset_id` int NOT NULL AUTO_INCREMENT,
  `pwd_reset_email` varchar(60) NOT NULL,
  `pwd_reset_token` int NOT NULL,
  PRIMARY KEY (`pwd_reset_id`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset`
--

LOCK TABLES `password_reset` WRITE;
/*!40000 ALTER TABLE `password_reset` DISABLE KEYS */;
INSERT INTO `password_reset` VALUES (31,'raymondaffedzie@gmail.com',467999),(32,'stephenymensah@gmail.com',769504);
/*!40000 ALTER TABLE `password_reset` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `story`
--

DROP TABLE IF EXISTS `story`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `story` (
  `story_id` varchar(250) NOT NULL,
  `tittle` text NOT NULL,
  `content` longtext NOT NULL,
  `image` varchar(250) DEFAULT NULL,
  `date` date NOT NULL,
  `country` varchar(30) NOT NULL,
  `state` varchar(40) NOT NULL,
  `member_id` varchar(10) NOT NULL,
  `status` char(20) NOT NULL,
  PRIMARY KEY (`story_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `story`
--

LOCK TABLES `story` WRITE;
/*!40000 ALTER TABLE `story` DISABLE KEYS */;
/*!40000 ALTER TABLE `story` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `story_approval`
--

DROP TABLE IF EXISTS `story_approval`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `story_approval` (
  `stapproval_id` int NOT NULL AUTO_INCREMENT,
  `story_id` varchar(250) NOT NULL,
  `admin_id` varchar(15) NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`stapproval_id`),
  KEY `story_id` (`story_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `story_approval`
--

LOCK TABLES `story_approval` WRITE;
/*!40000 ALTER TABLE `story_approval` DISABLE KEYS */;
/*!40000 ALTER TABLE `story_approval` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `story_comments`
--

DROP TABLE IF EXISTS `story_comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `story_comments` (
  `stcomnt_id` int NOT NULL AUTO_INCREMENT,
  `story_id` varchar(250) NOT NULL,
  `member_id` varchar(15) NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`stcomnt_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `story_comments`
--

LOCK TABLES `story_comments` WRITE;
/*!40000 ALTER TABLE `story_comments` DISABLE KEYS */;
/*!40000 ALTER TABLE `story_comments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `story_likes`
--

DROP TABLE IF EXISTS `story_likes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `story_likes` (
  `stlike_id` int NOT NULL AUTO_INCREMENT,
  `story_id` varchar(250) NOT NULL,
  `member_id` varchar(15) NOT NULL,
  PRIMARY KEY (`stlike_id`),
  UNIQUE KEY `member_id` (`member_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `story_likes`
--

LOCK TABLES `story_likes` WRITE;
/*!40000 ALTER TABLE `story_likes` DISABLE KEYS */;
/*!40000 ALTER TABLE `story_likes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `subcriptions`
--

DROP TABLE IF EXISTS `subcriptions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `subcriptions` (
  `sub_id` varchar(15) NOT NULL,
  `product` varchar(20) NOT NULL,
  `member_id` varchar(15) NOT NULL,
  PRIMARY KEY (`sub_id`),
  KEY `member_id` (`member_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `subcriptions`
--

LOCK TABLES `subcriptions` WRITE;
/*!40000 ALTER TABLE `subcriptions` DISABLE KEYS */;
/*!40000 ALTER TABLE `subcriptions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `video_library`
--

DROP TABLE IF EXISTS `video_library`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `video_library` (
  `file_id` varchar(15) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_extension` varchar(5) DEFAULT NULL,
  `tittle` varchar(255) NOT NULL,
  `admin_id` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`file_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `video_library`
--

LOCK TABLES `video_library` WRITE;
/*!40000 ALTER TABLE `video_library` DISABLE KEYS */;
/*!40000 ALTER TABLE `video_library` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping events for database 'ptln'
--

--
-- Dumping routines for database 'ptln'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-08-03 14:50:18
-- MySQL dump 10.13  Distrib 8.0.33, for Linux (x86_64)
--
-- Host: 127.0.0.1    Database: evoting
-- ------------------------------------------------------
-- Server version	8.0.33-0ubuntu0.22.04.4

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

DROP DATABASE IF EXISTS `evoting`;
CREATE DATABASE `evoting`;
USE `evoting`;

--
-- Table structure for table `admins`
--

DROP TABLE IF EXISTS `admins`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `admins` (
  `adminID` int NOT NULL AUTO_INCREMENT,
  `email` varchar(30) NOT NULL,
  `firstName` char(30) NOT NULL,
  `Surname` char(30) NOT NULL,
  `password` varchar(50) NOT NULL DEFAULT 'password',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`adminID`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admins`
--

LOCK TABLES `admins` WRITE;
/*!40000 ALTER TABLE `admins` DISABLE KEYS */;
INSERT INTO `admins` VALUES (2,'admin@afterworld.com','tti','takoradi','21232f297a57a5a743894a0e4a801fc3','2023-02-25 15:05:17'),(4,'new@tti.com','new','admin','21232f297a57a5a743894a0e4a801fc3','2023-03-03 23:02:51'),(5,'second@gmail.com','sec','ond','password','2023-03-03 23:55:25');
/*!40000 ALTER TABLE `admins` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `candidates`
--

DROP TABLE IF EXISTS `candidates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `candidates` (
  `candidateID` int NOT NULL AUTO_INCREMENT,
  `studentID` int NOT NULL,
  `image` varchar(40) NOT NULL,
  `positionID` int NOT NULL,
  `added_by` int NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`candidateID`),
  KEY `studentID` (`studentID`),
  KEY `positionID` (`positionID`),
  CONSTRAINT `candidates_ibfk_1` FOREIGN KEY (`studentID`) REFERENCES `students` (`studentID`),
  CONSTRAINT `candidates_ibfk_2` FOREIGN KEY (`positionID`) REFERENCES `positions` (`positionID`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `candidates`
--

LOCK TABLES `candidates` WRITE;
/*!40000 ALTER TABLE `candidates` DISABLE KEYS */;
/*!40000 ALTER TABLE `candidates` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `department`
--

DROP TABLE IF EXISTS `department`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `department` (
  `dept_id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(60) NOT NULL,
  PRIMARY KEY (`dept_id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `department`
--

LOCK TABLES `department` WRITE;
/*!40000 ALTER TABLE `department` DISABLE KEYS */;
INSERT INTO `department` VALUES (1,'SOFTWARE DEVELOPMENT (E-SKILLS)'),(2,'INFORMATION TECHNOLOGY'),(3,'COMPUTER TECHNOLOGY'),(4,'DIGITAL DESIGN AND TECHNOLOGY'),(5,'BUSINESS'),(6,'WELDING AND FABRICATION TECHNOLOGY'),(7,'ELECTRONICS ENGINEERING'),(8,'ELECTRICALS ENGINEERING'),(9,'AUTOMOTIVE ENGINEERING'),(10,'MECHANICAL ENGINEERING TECHNOLOGY'),(11,'BUILDING CONSTRUCTION TECHNOLOGY'),(12,'FASHION DESIGN TECHNOLOGY'),(13,'HOSPITALITY AND CATERING MANAGEMENT'),(14,'REFRIGERATION AND AIR CONDITIONING'),(15,'PLUMBING AND GAS FITTING TECHNOLOGY'),(16,'ARCHITECTURAL DRAFTING TECHNOLOGY');
/*!40000 ALTER TABLE `department` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `positions`
--

DROP TABLE IF EXISTS `positions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `positions` (
  `positionID` int NOT NULL AUTO_INCREMENT,
  `name` char(20) NOT NULL,
  `added_by` int NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`positionID`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `positions`
--

LOCK TABLES `positions` WRITE;
/*!40000 ALTER TABLE `positions` DISABLE KEYS */;
INSERT INTO `positions` VALUES (1,'Main',2,'2023-03-03 03:14:06'),(4,'Compound',2,'2023-04-17 13:47:44'),(5,'Entertainment',2,'2023-04-17 13:52:23'),(6,'Sanitation',2,'2023-04-17 13:52:23'),(7,'Chaplain',2,'2023-04-17 13:52:23'),(8,'Canteen',2,'2023-04-17 13:52:23'),(9,'Health',2,'2023-04-17 13:52:23'),(10,'Bans',2,'2023-04-17 13:52:23'),(11,'Co-ordinator',2,'2023-04-17 13:52:23'),(12,'Organizer',2,'2023-04-17 13:52:23'),(13,'Secretary',2,'2023-04-17 13:52:23'),(14,'Sports',2,'2023-04-17 13:52:23');
/*!40000 ALTER TABLE `positions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `students`
--

DROP TABLE IF EXISTS `students`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `students` (
  `studentID` int NOT NULL AUTO_INCREMENT,
  `firstname` char(30) NOT NULL,
  `othername` varchar(50) DEFAULT NULL,
  `surname` char(30) NOT NULL,
  `house` int NOT NULL,
  `department_id` int NOT NULL,
  `class` int NOT NULL,
  `sex` char(1) NOT NULL,
  `uniqueCode` varchar(30) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`studentID`),
  KEY `department_id` (`department_id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `students`
--

LOCK TABLES `students` WRITE;
/*!40000 ALTER TABLE `students` DISABLE KEYS */;
INSERT INTO `students` VALUES (1,'michael','kofi','boffie',5,1,1,'M','BmEzkkFoKb','2023-02-27 10:45:21'),(4,'Emmanul','','Aglago',3,2,3,'M','Jx5zNQQWsa','2023-03-03 19:27:38'),(5,'Kelvin','','Ackom',4,3,2,'M','Wdfn9HW6mk','2023-03-03 19:30:02'),(16,'Angela','Ekua','aidoo',4,4,2,'F','BZ8WPaLmjG','2023-03-22 19:11:06'),(18,'Josephine','Baaba','Boaffo',2,6,1,'F','Ce8ewa4Xdv','2023-04-19 09:00:05');
/*!40000 ALTER TABLE `students` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `votecount`
--

DROP TABLE IF EXISTS `votecount`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `votecount` (
  `voteID` int NOT NULL AUTO_INCREMENT,
  `studentID` int NOT NULL,
  `candidateID` int NOT NULL,
  `voted_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`voteID`),
  KEY `studentID` (`studentID`),
  KEY `candidateID` (`candidateID`),
  CONSTRAINT `votecount_ibfk_1` FOREIGN KEY (`studentID`) REFERENCES `students` (`studentID`),
  CONSTRAINT `votecount_ibfk_2` FOREIGN KEY (`candidateID`) REFERENCES `candidates` (`candidateID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `votecount`
--

LOCK TABLES `votecount` WRITE;
/*!40000 ALTER TABLE `votecount` DISABLE KEYS */;
/*!40000 ALTER TABLE `votecount` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping events for database 'evoting'
--

--
-- Dumping routines for database 'evoting'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-08-03 14:50:18
