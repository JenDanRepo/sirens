-- MySQL dump 10.13  Distrib 5.7.16, for Linux (x86_64)
--
-- Host: localhost    Database: growlerscenedb
-- ------------------------------------------------------
-- Server version	5.7.16-0ubuntu0.16.04.1

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
-- Table structure for table `Beers`
--

DROP TABLE IF EXISTS `Beers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Beers` (
  `id` int(16) unsigned NOT NULL AUTO_INCREMENT,
  `brewery` int(6) NOT NULL,
  `name` text,
  `style` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Beers`
--

LOCK TABLES `Beers` WRITE;
/*!40000 ALTER TABLE `Beers` DISABLE KEYS */;
INSERT INTO `Beers` VALUES (1,1,'Pork Store','Scotch Ale'),(2,2,'Bork Store','American Ale'),(3,3,'Gork Store','Lager');
/*!40000 ALTER TABLE `Beers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Checkins`
--

DROP TABLE IF EXISTS `Checkins`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Checkins` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` varchar(100) NOT NULL,
  `entry_time` datetime NOT NULL,
  `siren` int(11) DEFAULT NULL,
  `callsign` varchar(11) DEFAULT NULL,
  `location` text,
  `tonequality` varchar(100) DEFAULT NULL,
  `voicequality` varchar(100) DEFAULT NULL,
  `insideout` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Checkins`
--

LOCK TABLES `Checkins` WRITE;
/*!40000 ALTER TABLE `Checkins` DISABLE KEYS */;
INSERT INTO `Checkins` VALUES (1,'desl','2016-12-22 11:57:12',36,'KK6VNY','Caesar Chavez and S Van Ness','Loud & Clear','Loud & Clear',NULL),(2,'Ham Radio Op','2016-12-22 20:52:55',12,'KF6IHL','Going banans','Awesome','Sweet',NULL),(3,'Homo Erectus','2016-12-22 23:52:40',12,'KF6IHL','Going banans','Awesome','Sweet',NULL),(4,'Homo Erectus','2016-12-22 23:56:15',1,'KF6IHL','the park','Awesome','Sweet',NULL),(5,'Shaggy','2016-12-22 23:56:34',2,'KK6vny','your mom','Awesome','Sweet',NULL),(6,'Bob','2016-12-23 14:55:09',2,'KKBOB','1st & Market','Good','Lousy',NULL),(7,'Dana','2016-12-23 14:57:45',1,'KFD123','Union Square','Lousy','Even Lousier',NULL),(8,'','2017-01-03 21:00:16',52,'KK6JJZ','17th  & Lawton','Loud & Clear','Loud & Clear',NULL),(9,'Diane','2017-01-03 21:00:55',114,'KI6B2P','Alta Plaza Park','Loud & Clear','Couldn\'t hear',NULL),(10,'Jonathan','2017-01-03 21:01:25',22,'KM6AED','Bush & Taylor','Loud & Clear','Loud & Clear',NULL),(11,'Bill','2017-01-03 21:03:09',72,'KG6RQS','37th Ave & Cabrillo','Loud & Clear','Loud & Clear',NULL),(12,'Rick','2017-01-03 21:03:24',47,'WD8SAB','35th Ave & Geary','Loud & Clear','Loud & Clear',NULL),(13,'Dan','2017-01-03 21:03:35',10,'KK6VNY','Fort Funston Parking Lot','Loud & Clear','Loud & Clear',NULL),(14,'Ryan','2017-01-03 21:03:44',32,'KA RRR','20th & Shotwell','Loud & Clear','Loud & Clear',NULL),(15,'Diana','2017-01-03 21:03:52',56,'KG6IOH','Gateview & Mendoza','Loud & Clear','Loud & Clear',NULL),(16,'Jeff','2017-01-03 21:04:16',0,'N2TIQ','2nd St & Howard','Loud & Clear','No voice..',NULL),(17,'Nancy','2017-01-03 21:04:34',0,'KF6WEE','7th & Clement','muffled, clear but not loud','muffled, clear but not loud',NULL),(18,'','2017-01-04 21:36:37',0,'','','','',NULL),(19,'fakeuser','2017-01-04 21:37:02',0,'K6FAKE','ballpark','Loud & Clear','Loud & Clear',NULL),(20,'Diana','2017-01-10 22:30:03',0,'KI6BQR','Jackson & Steiner','Loud & Clear','Couldn\'t hear','indoor'),(21,'','2017-01-10 22:30:37',52,'WA6UHA','Belim & Mira','Muffled','Muffled','outdoor'),(22,'Larry','2017-01-10 22:31:20',52,'KG6VOM','','Loud & Clear','Loud & Clear','unknown'),(23,'Bill','2017-01-10 22:31:41',72,'KG6RQS','? & Cabrillo','Loud & Clear','Loud & Clear','outdoor'),(24,'Bill','2017-01-10 22:31:58',47,'KG6QQS','? & Cabrillo','Loud & Clear','Loud & Clear','outdoor'),(25,'Jeff','2017-01-10 22:33:29',52,'KK6JJZ','17th Ave & Lawton','Loud & Clear','Loud & Clear','outdoor'),(26,'Jeff','2017-01-10 22:33:36',106,'KK6JJZ','17th Ave & Lawton','Loud & Clear','Loud & Clear','outdoor'),(27,'Jim','2017-01-10 22:34:01',89,'KI6RYE','6th & Irving','Loud & Clear','Muffled','indoor'),(28,'Richard','2017-01-10 22:34:23',13,'KJ6PTX','mencia & collenwood','Loud & Clear','Loud & Clear','indoor'),(29,'Richard','2017-01-10 22:34:36',27,'KJ6PTX','mencia & collenwood','Loud & Clear','Loud & Clear','indoor'),(30,'Tom','2017-01-10 22:36:27',83,'KJ6??S','Bosworth & Diamond','Loud & Clear','Loud & Clear','outdoor'),(31,'Rick','2017-01-10 22:37:07',47,'WD8SAB','35th Ave & Geary','Loud & Clear','Loud & Clear','unknown'),(32,'Dan','2017-01-10 22:37:34',10,'KK6VNY','John Muir & Skyline','Loud & Clear','Loud & Clear','outdoor'),(33,'Owen','2017-01-19 19:11:10',0,'KJ6HMV','Arlington & Fairmont','Loud & Clear','??','indoor'),(34,'John','2017-01-19 19:11:27',51,'','47th & Pacheco','Loud & Clear','Loud & Clear','outdoor'),(35,'Mike','2017-01-19 19:12:00',89,'I6RYE','9th & Irving','Loud & Clear','Loud & Clear','indoor'),(36,'Jeff','2017-01-19 19:12:19',53,'KK6JJZ','90 Medical Center Way','Loud & Clear','Loud & Clear','outdoor'),(37,'KI6BQP','2017-01-19 19:12:35',114,'Diana','Jackson & Steiner','Loud & Clear','muffled','indoor'),(38,'Bill','2017-01-19 19:12:48',47,'KG6RQS','46th & Cabrilla','Loud & Clear','Loud & Clear','outdoor'),(39,'Bill','2017-01-19 19:12:53',72,'KG6RQS','46th & Cabrillo','Loud & Clear','Loud & Clear','outdoor'),(40,'Dan','2017-01-19 19:13:02',24,'KK6VNY','Webster & Turk','No sound','No sound','outdoor'),(41,'Cathy','2017-01-19 19:13:52',86,'KG6QDJ','Industrial & Palou','Loud & Clear','Loud & Clear','outdoor'),(42,'Cathy','2017-01-19 19:13:56',67,'KG6QDJ','Industrial & Palou','Loud & Clear','Loud & Clear','outdoor'),(43,'Ryan','2017-01-19 19:14:08',29,'KA6RRR','14th & Folsom','Loud & Clear','Faint','outdoor'),(44,'Tom','2017-01-19 19:14:20',83,'KJ6TGS','Bosworth & Diamond','Loud & Clear','Loud & Clear','outdoor'),(45,'Simon','2017-01-19 19:14:50',22,'KK6RVE','Sutter & Leavenworth','Echo','unclear','indoor');
/*!40000 ALTER TABLE `Checkins` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `MonorailVisits`
--

DROP TABLE IF EXISTS `MonorailVisits`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `MonorailVisits` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `Monorail` int(11) DEFAULT NULL COMMENT 'Refers to ID in Monorails table.',
  `Date` date DEFAULT NULL,
  `Image` text,
  `Comment` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `MonorailVisits`
--

LOCK TABLES `MonorailVisits` WRITE;
/*!40000 ALTER TABLE `MonorailVisits` DISABLE KEYS */;
INSERT INTO `MonorailVisits` VALUES (1,18,'2015-05-15',NULL,'Rode the monorail to the ferris wheel. Highly recommend this as a night time activity.');
/*!40000 ALTER TABLE `MonorailVisits` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Monorails`
--

DROP TABLE IF EXISTS `Monorails`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Monorails` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` text,
  `address` text,
  `city` text,
  `state` text,
  `country` text,
  `lat` decimal(10,7) DEFAULT NULL,
  `long` decimal(10,7) DEFAULT NULL,
  `category` text,
  `url` text,
  `wikipedia` text,
  `image` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Monorails`
--

LOCK TABLES `Monorails` WRITE;
/*!40000 ALTER TABLE `Monorails` DISABLE KEYS */;
INSERT INTO `Monorails` VALUES (16,'Disneyland Monorail System',NULL,'Anaheim','CA',NULL,33.1821000,-117.9190000,NULL,NULL,NULL,NULL),(17,'Jacksonville Skyway',NULL,'Jacksonville','FL',NULL,30.3333000,-81.6589000,NULL,NULL,NULL,NULL),(18,'Las Vegas Monorail',NULL,'Las Vegas','NV',NULL,36.1699410,-11.1398390,NULL,NULL,NULL,NULL),(19,'Seattle Monorail Center',NULL,'Seattle','WA',NULL,47.6170040,-122.3435060,NULL,NULL,NULL,NULL),(20,'Walt Disney World Monorail System',NULL,'Bay Lake','FL',NULL,28.4191850,-81.5821180,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `Monorails` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `MyBreweries`
--

DROP TABLE IF EXISTS `MyBreweries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `MyBreweries` (
  `id` int(6) unsigned NOT NULL AUTO_INCREMENT,
  `brewery` varchar(100) NOT NULL,
  `address` varchar(100) NOT NULL,
  `city` varchar(30) DEFAULT NULL,
  `state` varchar(30) DEFAULT NULL,
  `zipcode` varchar(12) DEFAULT NULL,
  `website` varchar(100) DEFAULT NULL,
  `phone` varchar(12) DEFAULT NULL,
  `growlers` varchar(10) DEFAULT NULL,
  `bringown` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `MyBreweries`
--

LOCK TABLES `MyBreweries` WRITE;
/*!40000 ALTER TABLE `MyBreweries` DISABLE KEYS */;
INSERT INTO `MyBreweries` VALUES (1,'Alameda Island Brewing','1716 Park St','Alameda','CA','94501','http://alamedaislandbrewingcompany.com/','510-217-8885','yes','yes'),(2,'Bear Republic','345 Healdsburg Ave','Healdsburg','CA','95448','http://bearrepublic.com','707-433-2337','yes','yes'),(3,'Carneros Brewing Co.','22985 Burndale Rd','Sonoma','CA','95476','http://carnerosbrewing.com','707-938-1880','unknown','unknown'),(4,'Devils Canyon Brewering Company','935 Washington St','San Carlos','CA','94070','http://devilscanyon.com/distribution/','650-592-2739','yes','yes'),(5,'Fieldwork Brewing','1160 6th St','Berkeley','CA','94710','http://fieldworkbrewing.com/','','yes','yes'),(6,'Freewheel Brewing Company','3736 Florence Street','Redwood City','CA','94063','http://freewheelbrewing.com/','650-365-2337','yes','yes'),(7,'Hoi Polloi','1763 Alcatraz Ave','Berkeley','CA','94703','http://www.yelp.com/biz/hoi-polloi-brewpub-and-beat-lounge-berkeley-2','510-858-7334','yes','yes'),(8,'Alameda Island Brewing','1716 Park St','Alameda','CA','94501','http://alamedaislandbrewingcompany.com/','510-217-8885','yes','yes'),(9,'Bear Republic','345 Healdsburg Ave','Healdsburg','CA','95448','http://bearrepublic.com','707-433-2337','yes','yes'),(10,'Carneros Brewing Co.','22985 Burndale Rd','Sonoma','CA','95476','http://carnerosbrewing.com','707-938-1880','unknown','unknown'),(11,'Devils Canyon Brewering Company','935 Washington St','San Carlos','CA','94070','http://devilscanyon.com/distribution/','650-592-2739','yes','yes'),(12,'Fieldwork Brewing','1160 6th St','Berkeley','CA','94710','http://fieldworkbrewing.com/','','yes','yes'),(13,'Freewheel Brewing Company','3736 Florence Street','Redwood City','CA','94063','http://freewheelbrewing.com/','650-365-2337','yes','yes'),(14,'Hoi Polloi','1763 Alcatraz Ave','Berkeley','CA','94703','http://www.yelp.com/biz/hoi-polloi-brewpub-and-beat-lounge-berkeley-2','510-858-7334','yes','yes');
/*!40000 ALTER TABLE `MyBreweries` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Sirens`
--

DROP TABLE IF EXISTS `Sirens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Sirens` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `number` int(11) DEFAULT NULL,
  `name` text,
  `language` text,
  `address` text,
  `city` text,
  `state` text,
  `zip` text,
  `lat` float(10,6) DEFAULT NULL,
  `lng` float(10,6) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=115 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Sirens`
--

LOCK TABLES `Sirens` WRITE;
/*!40000 ALTER TABLE `Sirens` DISABLE KEYS */;
INSERT INTO `Sirens` VALUES (3,1,'22nd & Carolina','English','22nd & Carolina','San Francisco','CA','',37.757240,-122.400002),(4,2,'Presidio West','English','Presidio West','San Francisco','CA','',37.793571,-122.475342),(5,3,'Presidio East','English','Presidio East','San Francisco','CA','',37.798870,-122.466187),(6,4,'940 Filbert','English','940 Filbert','San Francisco','CA','',37.802052,-122.404510),(7,5,'UCSF Mission Bay','English / Cantonese','UCSF Mission Bay','San Francisco','CA','',37.768791,-122.395737),(8,6,'Pier 96','English','Pier 96','San Francisco','CA','',37.741859,-122.372383),(9,7,'Hunters Point PD','English','Hunters Point PD','San Francisco','CA','',37.729820,-122.397713),(10,8,'Fitch & Egbert','English','Fitch & Egbert','San Francisco','CA','',37.718418,-122.385139),(11,9,'610 Tompkins','English','610 Tompkins','San Francisco','CA','',37.736641,-122.412720),(12,10,'700 John Muir','English','700 John Muir','San Francisco','CA','',37.720081,-122.499641),(13,11,'Treasure Island','English','Treasure Island','San Francisco','CA','',37.823551,-122.370644),(14,12,'Yerba Buena Island','English','Yerba Buena Island','San Francisco','CA','',37.810871,-122.366829),(15,13,'17th & Castro','English','17th & Castro','San Francisco','CA','',37.762428,-122.435188),(16,14,'Bay & Kearny','English','Bay & Kearny','San Francisco','CA','',37.806431,-122.407158),(17,15,'Marina Middle School','English','Marina Middle School','San Francisco','CA','',37.801731,-122.436119),(18,16,'630 Sansome','English / Cantonese','630 Sansome','San Francisco','CA','',37.796230,-122.401421),(19,17,'Ferry Building','English','Ferry Building','San Francisco','CA','',37.795540,-122.393410),(20,18,'Lafayette Park','English','Lafayette Park','San Francisco','CA','',37.791611,-122.427612),(21,19,'California & Quincy','English / Cantonese','California & Quincy','San Francisco','CA','',37.792500,-122.405670),(22,20,'UN Plaza (Civic Center),','English','UN Plaza (Civic Center),','San Francisco','CA','',37.779949,-122.414062),(23,21,'Union Square','English / Cantonese','Union Square','San Francisco','CA','',37.787991,-122.407433),(24,22,'Post & Leavenworth','English','Post & Leavenworth','San Francisco','CA','',37.787460,-122.415024),(25,23,'Bryant & Rincon','English','Bryant & Rincon','San Francisco','CA','',37.784199,-122.392097),(26,24,'Turk & Webster','English','Turk & Webster','San Francisco','CA','',37.780708,-122.430527),(27,25,'135 Sanchez','English','135 Sanchez','San Francisco','CA','',37.767078,-122.430748),(28,26,'1000 Brannan','English','1000 Brannan','San Francisco','CA','',37.769981,-122.407539),(29,27,'Clayton & Carmel','English','Clayton & Carmel','San Francisco','CA','',37.760849,-122.448982),(30,28,'Haight & Masonic','English','Haight & Masonic','San Francisco','CA','',37.770210,-122.445358),(31,29,'Mission & Plum','English / Spanish','Mission & Plum','San Francisco','CA','',37.771000,-122.419662),(32,30,'Fremont & Folsom','English','Fremont & Folsom','San Francisco','CA','',37.788029,-122.393631),(33,31,'Alvarado School','English','Alvarado School','San Francisco','CA','',37.753719,-122.438522),(34,32,'22nd & Bartlett','English / Spanish','22nd & Bartlett','San Francisco','CA','',37.755371,-122.419868),(35,33,'Foot of Van Ness','English','Foot of Van Ness','San Francisco','CA','',37.800850,-122.437813),(36,34,'Portola & Woodside','English','Portola & Woodside','San Francisco','CA','',37.745499,-122.451622),(37,35,'30th & Noe','English','30th & Noe','San Francisco','CA','',37.741829,-122.430901),(38,36,'S. Van Ness & Cesar Chavez','English','S. Van Ness & Cesar Chavez','San Francisco','CA','',37.748268,-122.415894),(39,37,'Quint & Jerrold','English','Quint & Jerrold','San Francisco','CA','',37.740929,-122.392990),(40,38,'Foerster & Flood','English','Foerster & Flood','San Francisco','CA','',37.729889,-122.448868),(41,39,'Excelsior School','English','Excelsior School','San Francisco','CA','',37.726002,-122.432190),(42,40,'Wayland & University','English / Cantonese','Wayland & University','San Francisco','CA','',37.723881,-122.412979),(43,41,'McLaren Park','English / Cantonese','McLaren Park','San Francisco','CA','',37.719299,-122.419373),(44,42,'Visitation & Schwerin','English / Cantonese','Visitation & Schwerin','San Francisco','CA','',37.706329,-122.413261),(45,43,'Jamestown & Ingalls','English','Jamestown & Ingalls','San Francisco','CA','',37.718498,-122.393547),(46,44,'1295 Shafter','English','1295 Shafter','San Francisco','CA','',37.727661,-122.385063),(47,45,'22nd & 3rd','English','22nd & 3rd','San Francisco','CA','',37.757950,-122.388237),(48,46,'Merrie & Point Lobos','English','Merrie & Point Lobos','San Francisco','CA','',37.779350,-122.511597),(49,47,'32nd & Anza','English','32nd & Anza','San Francisco','CA','',37.777821,-122.492111),(50,48,'100 El Camino Del Mar','English','100 El Camino Del Mar','San Francisco','CA','',37.787861,-122.484230),(51,49,'California & Funston','English','California & Funston','San Francisco','CA','',37.716301,-122.502533),(52,50,'Euclid & Manzanita','English','Euclid & Manzanita','San Francisco','CA','',37.784279,-122.451012),(53,51,'43rd & Kirkham','English / Cantonese','43rd & Kirkham','San Francisco','CA','',37.758701,-122.502602),(54,52,'18th & Judah','English','18th & Judah','San Francisco','CA','',37.761688,-122.475937),(55,53,'Kezar Stadium','English','Kezar Stadium','San Francisco','CA','',37.766788,-122.456039),(56,54,'47th & Pacheco','English / Cantonese','47th & Pacheco','San Francisco','CA','',37.749191,-122.506241),(57,55,'24th & Rivera','English','24th & Rivera','San Francisco','CA','',37.746540,-122.481331),(58,56,'8th & Ortega','English','8th & Ortega','San Francisco','CA','',37.752899,-122.464478),(59,57,'41st & Vicente','English / Cantonese','41st & Vicente','San Francisco','CA','',37.738289,-122.499023),(60,58,'Taraval & Claremont','English','Taraval & Claremont','San Francisco','CA','',37.741581,-122.464371),(61,59,'SF State North (SF State),','English','SF State North (SF State),','San Francisco','CA','',37.721889,-122.478203),(62,60,'Aptos School','English','Aptos School','San Francisco','CA','',37.729721,-122.465652),(63,61,'100 Font','English','100 Font','San Francisco','CA','',37.715321,-122.472679),(64,62,'City College West (City College),','English','City College West (City College),','San Francisco','CA','',37.725651,-122.451050),(65,63,'Alemany & Naglee','English','Alemany & Naglee','San Francisco','CA','',37.713928,-122.448990),(66,64,'Beach Chalet','English','Beach Chalet','San Francisco','CA','',37.769451,-122.510201),(67,65,'Golden Gate Bridge','English','Golden Gate Bridge','San Francisco','CA','',37.805012,-122.476189),(68,67,'Bernal Heights Tower ','English','Bernal Heights Tower ','San Francisco','CA','',37.743141,-122.415314),(69,68,'1551 Newcomb','English','1551 Newcomb','San Francisco','CA','',37.734718,-122.388878),(70,69,'Twin Peaks','English','Twin Peaks','San Francisco','CA','',37.752499,-122.447563),(71,70,'ATT Park South','English / Cantonese','ATT Park South','San Francisco','CA','',37.778591,-122.389259),(72,71,'Fulton & 11th','English','Fulton & 11th','San Francisco','CA','',37.773258,-122.469116),(73,72,'Fulton & 39th','English','Fulton & 39th','San Francisco','CA','',37.771889,-122.499207),(74,73,'USF North (University of SF),','English','USF North (University of SF),','San Francisco','CA','',37.776642,-122.450684),(75,74,'USF South (University of SF),','English','USF South (University of SF),','San Francisco','CA','',37.776642,-122.450684),(76,75,'SF Zoo','English','SF Zoo','San Francisco','CA','',37.732960,-122.502937),(77,76,'Balboa & Great Hwy','English','Balboa & Great Hwy','San Francisco','CA','',37.775101,-122.511253),(78,77,'Kirkham & Great Hwy','English / Cantonese','Kirkham & Great Hwy','San Francisco','CA','',37.758400,-122.509171),(79,78,'Taraval & Great Hwy','English / Cantonese','Taraval & Great Hwy','San Francisco','CA','',37.741680,-122.506958),(80,79,'SF State East (SF State),','English','SF State East (SF State),','San Francisco','CA','',37.721889,-122.478203),(81,80,'SF State West (SF State),','English','SF State West (SF State),','San Francisco','CA','',37.721889,-122.478203),(82,81,'Civic Auditorium (Civic Center),','English','Civic Auditorium (Civic Center),','San Francisco','CA','',37.777988,-122.417267),(83,82,'1651 Union','English / Cantonese','1651 Union','San Francisco','CA','',37.797989,-122.426132),(84,83,'151 Lippard','English','151 Lippard','San Francisco','CA','',37.733139,-122.435631),(85,84,'2290 14th','English','2290 14th','San Francisco','CA','',37.745392,-122.469650),(86,85,'380 Webster','English','380 Webster','San Francisco','CA','',37.773769,-122.428741),(87,86,'45 Conkling','English / Cantonese','45 Conkling','San Francisco','CA','',37.735901,-122.401787),(88,87,'Kearny & Washington','English / Cantonese','Kearny & Washington','San Francisco','CA','',37.795330,-122.404968),(89,88,'Bayshore & Hester','English','Bayshore & Hester','San Francisco','CA','',37.715271,-122.398941),(90,89,'9th & Lincoln ','English','9th & Lincoln ','San Francisco','CA','',37.765980,-122.466461),(91,90,'25th & Lincoln','English / Cantonese','25th & Lincoln','San Francisco','CA','',37.765209,-122.483704),(92,91,'25th & Fulton','English','25th & Fulton','San Francisco','CA','',37.772560,-122.484291),(93,92,'3rd & Harrison','English','3rd & Harrison','San Francisco','CA','',37.782558,-122.397408),(94,93,'7th & Bryant','English','7th & Bryant','San Francisco','CA','',37.774281,-122.404762),(95,94,'Capitol & Farallones','English','Capitol & Farallones','San Francisco','CA','',37.714050,-122.459061),(96,95,'Geary & Scott ','English','Geary & Scott ','San Francisco','CA','',37.783630,-122.437828),(97,96,'Innes & Hunters Point','English','Innes & Hunters Point','San Francisco','CA','',37.732731,-122.376907),(98,97,'SFPD Academy','English','SFPD Academy','San Francisco','CA','',37.744419,-122.441383),(99,98,'Noe & Market','English','Noe & Market','San Francisco','CA','',37.751400,-122.428993),(100,100,'City College North (City College),','English','City College North (City College),','San Francisco','CA','',37.725651,-122.451050),(101,101,'City College South (City College),','English','City College South (City College),','San Francisco','CA','',37.725651,-122.451050),(102,102,'9th & Geary','English','9th & Geary','San Francisco','CA','',37.780941,-122.467506),(103,103,'21st & Geary','English','21st & Geary','San Francisco','CA','',37.780220,-122.480461),(104,104,'400 Mansell, Burton HS','English','400 Mansell, Burton HS','San Francisco','CA','',37.721588,-122.406448),(105,105,'City College 4th & Mission','English','City College 4th & Mission','San Francisco','CA','',37.784500,-122.404808),(106,106,'31st & Lawton, Lawton ES','English','31st & Lawton, Lawton ES','San Francisco','CA','',37.757660,-122.489258),(107,107,'37th & Pacheco','English','37th & Pacheco','San Francisco','CA','',37.749668,-122.495529),(108,108,'Sunset & Ocean','English','Sunset & Ocean','San Francisco','CA','',37.731918,-122.493660),(109,109,'22nd & Sloat','English','22nd & Sloat','San Francisco','CA','',37.734531,-122.477997),(110,110,'Dublin & Brazil, June Jordan HS','English','Dublin & Brazil, June Jordan HS','San Francisco','CA','',37.719372,-122.424873),(111,111,'Silver & Cambridge, Hillcrest ES1','English','Silver & Cambridge','San Francisco','CA','',37.729130,-122.419388),(112,112,'TI West','English','1234 Northpoint Dr','San Francisco','CA','',37.830181,-122.374634),(113,113,'TI east','English','Avenue F','San Francisco','CA','',37.820599,-122.368294),(114,114,'Alta Plaza Park ','English','Alta Plaza Park ','San Francisco','CA','',37.791142,-122.437622);
/*!40000 ALTER TABLE `Sirens` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-01-19 19:51:52
