-- MySQL dump 10.13  Distrib 5.5.41, for debian-linux-gnu (i686)
--
-- Host: localhost    Database: buildcake3_property
-- ------------------------------------------------------
-- Server version	5.5.41-0ubuntu0.14.04.1

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
-- Table structure for table `accounting`
--

DROP TABLE IF EXISTS `accounting`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `accounting` (
  `id` int(11) NOT NULL,
  `tenant_id` int(11) NOT NULL,
  `payment_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `accounting`
--

LOCK TABLES `accounting` WRITE;
/*!40000 ALTER TABLE `accounting` DISABLE KEYS */;
/*!40000 ALTER TABLE `accounting` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `acos`
--

DROP TABLE IF EXISTS `acos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `acos` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(10) DEFAULT NULL,
  `model` varchar(255) DEFAULT '',
  `foreign_key` int(10) unsigned DEFAULT NULL,
  `alias` varchar(255) DEFAULT '',
  `lft` int(10) DEFAULT NULL,
  `rght` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `acos`
--

LOCK TABLES `acos` WRITE;
/*!40000 ALTER TABLE `acos` DISABLE KEYS */;
/*!40000 ALTER TABLE `acos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `alternateemails`
--

DROP TABLE IF EXISTS `alternateemails`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `alternateemails` (
  `id` int(200) NOT NULL,
  `tenant_id` int(11) NOT NULL,
  `alternate_email` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `alternateemails`
--

LOCK TABLES `alternateemails` WRITE;
/*!40000 ALTER TABLE `alternateemails` DISABLE KEYS */;
/*!40000 ALTER TABLE `alternateemails` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `applications_leases`
--

DROP TABLE IF EXISTS `applications_leases`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `applications_leases` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tenant_id` int(10) unsigned DEFAULT NULL,
  `property_id` int(10) unsigned DEFAULT NULL,
  `unit_id` int(10) unsigned DEFAULT NULL,
  `leasestype_id` int(11) NOT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `automatically_end_the_lease` tinyint(1) NOT NULL,
  `recurringcharge_id` int(11) DEFAULT NULL,
  `next_due_date` date DEFAULT NULL,
  `rent_mount` varchar(40) DEFAULT NULL,
  `security_deposit` decimal(15,0) DEFAULT NULL,
  `security_deposit_date` date DEFAULT NULL,
  `status` varchar(40) NOT NULL DEFAULT 'Application',
  `notes` text,
  `agreement` varchar(40) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `applications_leases`
--

LOCK TABLES `applications_leases` WRITE;
/*!40000 ALTER TABLE `applications_leases` DISABLE KEYS */;
INSERT INTO `applications_leases` VALUES (1,1,1,1,0,'2014-04-01','2015-04-01',0,0,'2014-05-01','700',1400,'2014-03-03','Application','<br>','1'),(2,3,2,2,0,'2014-05-01','2016-04-30',0,0,'2014-06-01','800',1600,'2014-03-01','Lease','<br>','1'),(3,2,2,6,0,'2014-04-01','2016-03-31',0,0,'2014-05-01','900',1800,'2014-03-01','Lease','<br>','1');
/*!40000 ALTER TABLE `applications_leases` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `aros`
--

DROP TABLE IF EXISTS `aros`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `aros` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(10) DEFAULT NULL,
  `model` varchar(255) DEFAULT '',
  `foreign_key` int(10) unsigned DEFAULT NULL,
  `alias` varchar(255) DEFAULT '',
  `lft` int(10) DEFAULT NULL,
  `rght` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `aros`
--

LOCK TABLES `aros` WRITE;
/*!40000 ALTER TABLE `aros` DISABLE KEYS */;
/*!40000 ALTER TABLE `aros` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `aros_acos`
--

DROP TABLE IF EXISTS `aros_acos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `aros_acos` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `aro_id` int(10) unsigned NOT NULL,
  `aco_id` int(10) unsigned NOT NULL,
  `_create` char(2) NOT NULL DEFAULT '0',
  `_read` char(2) NOT NULL DEFAULT '0',
  `_update` char(2) NOT NULL DEFAULT '0',
  `_delete` char(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `aros_acos`
--

LOCK TABLES `aros_acos` WRITE;
/*!40000 ALTER TABLE `aros_acos` DISABLE KEYS */;
/*!40000 ALTER TABLE `aros_acos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cake_sessions`
--

DROP TABLE IF EXISTS `cake_sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cake_sessions` (
  `id` varchar(255) NOT NULL DEFAULT '',
  `data` text,
  `expires` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cake_sessions`
--

LOCK TABLES `cake_sessions` WRITE;
/*!40000 ALTER TABLE `cake_sessions` DISABLE KEYS */;
/*!40000 ALTER TABLE `cake_sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cities`
--

DROP TABLE IF EXISTS `cities`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cities` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `country_id` int(11) NOT NULL,
  `state_id` int(11) NOT NULL,
  `city` varchar(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cities`
--

LOCK TABLES `cities` WRITE;
/*!40000 ALTER TABLE `cities` DISABLE KEYS */;
INSERT INTO `cities` VALUES (1,93,3,'Delmas');
/*!40000 ALTER TABLE `cities` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `comptable`
--

DROP TABLE IF EXISTS `comptable`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `comptable` (
  `id` int(10) NOT NULL,
  `id_tenants` int(10) NOT NULL,
  `id_payments` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comptable`
--

LOCK TABLES `comptable` WRITE;
/*!40000 ALTER TABLE `comptable` DISABLE KEYS */;
/*!40000 ALTER TABLE `comptable` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `comptable1`
--

DROP TABLE IF EXISTS `comptable1`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `comptable1` (
  `ID` int(10) NOT NULL,
  `tenant_id` int(10) NOT NULL,
  `payment_id` int(10) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comptable1`
--

LOCK TABLES `comptable1` WRITE;
/*!40000 ALTER TABLE `comptable1` DISABLE KEYS */;
/*!40000 ALTER TABLE `comptable1` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `countries`
--

DROP TABLE IF EXISTS `countries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `countries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `country` varchar(2) NOT NULL,
  `name` varchar(44) DEFAULT NULL,
  `paypal` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=244 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `countries`
--

LOCK TABLES `countries` WRITE;
/*!40000 ALTER TABLE `countries` DISABLE KEYS */;
INSERT INTO `countries` VALUES (1,'AF','Afghanistan',0),(2,'AL','Albania',1),(3,'DZ','Algeria',1),(4,'AS','American Samoa',0),(5,'AD','Andorra',1),(6,'AO','Angola',1),(7,'AI','Anguilla',1),(8,'AQ','Antarctica',0),(9,'AG','Antigua and Barbuda',1),(10,'AR','Argentina',1),(11,'AM','Armenia',1),(12,'AW','Aruba',1),(13,'AU','Australia',1),(14,'AT','Austria',1),(15,'AZ','Azerbaijan',1),(16,'BS','Bahamas',1),(17,'BH','Bahrain',1),(18,'BD','Bangladesh',0),(19,'BB','Barbados',1),(20,'BY','Belarus',0),(21,'BE','Belgium',1),(22,'BZ','Belize',1),(23,'BJ','Benin',1),(24,'BM','Bermuda',1),(25,'BT','Bhutan',1),(26,'BO','Bolivia',1),(27,'BA','Bosnia and Herzegovina',1),(28,'BW','Botswana',1),(29,'BV','Bouvet Island',0),(30,'BR','Brazil',1),(31,'IO','British Indian Ocean Territory',0),(32,'BN','Brunei Darussalam',1),(33,'BG','Bulgaria',1),(34,'BF','Burkina Faso',0),(35,'BI','Burundi',1),(36,'KH','Cambodia',1),(37,'CM','Cameroon',0),(38,'CA','Canada',1),(39,'CV','Cape Verde',1),(40,'KY','Cayman Islands',1),(41,'CF','Central African Republic',0),(42,'TD','Chad',1),(43,'CL','Chile',1),(44,'CN','China',1),(45,'CX','Christmas Island',0),(46,'CC','Cocos (Keeling) Islands',0),(47,'CO','Colombia',1),(48,'KM','Comoros',1),(49,'CG','Congo',1),(50,'CD','Congo, The Democratic Republic of The',1),(51,'CK','Cook Islands',1),(52,'CR','Costa Rica',1),(53,'CI','Cote D\'ivoire',0),(54,'HR','Croatia',1),(55,'CU','Cuba',0),(56,'CY','Cyprus',1),(57,'CZ','Czech Republic',1),(58,'DK','Denmark',1),(59,'DJ','Djibouti',1),(60,'DM','Dominica',1),(61,'DO','Dominican Republic',1),(62,'EC','Ecuador',1),(63,'EG','Egypt',0),(64,'SV','El Salvador',1),(65,'GQ','Equatorial Guinea',0),(66,'ER','Eritrea',1),(67,'EE','Estonia',1),(68,'ET','Ethiopia',1),(69,'FK','Falkland Islands (Malvinas)',1),(70,'FO','Faroe Islands',1),(71,'FJ','Fiji',1),(72,'FI','Finland',1),(73,'FR','France',1),(74,'GF','French Guiana',1),(75,'PF','French Polynesia',1),(76,'TF','French Southern Territories',0),(77,'GA','Gabon',1),(78,'GM','Gambia',1),(79,'GE','Georgia',0),(80,'DE','Germany',1),(81,'GH','Ghana',0),(82,'GI','Gibraltar',1),(83,'GR','Greece',1),(84,'GL','Greenland',1),(85,'GD','Grenada',1),(86,'GP','Guadeloupe',1),(87,'GU','Guam',0),(88,'GT','Guatemala',1),(89,'GG','Guernsey',0),(90,'GN','Guinea',1),(91,'GW','Guinea-bissau',1),(92,'GY','Guyana',1),(93,'HT','Haiti',0),(94,'HM','Heard Island and Mcdonald Islands',0),(95,'VA','Holy See (Vatican City State)',1),(96,'HN','Honduras',1),(97,'HK','Hong Kong',1),(98,'HU','Hungary',1),(99,'IS','Iceland',1),(100,'IN','India',1),(101,'ID','Indonesia',1),(102,'IR','Iran, Islamic Republic of',0),(103,'IQ','Iraq',0),(104,'IE','Ireland',1),(105,'IM','Isle of Man',0),(106,'IL','Israel',1),(107,'IT','Italy',1),(108,'JM','Jamaica',1),(109,'JP','Japan',0),(110,'JE','Jersey',0),(111,'JO','Jordan',1),(112,'KZ','Kazakhstan',1),(113,'KE','Kenya',1),(114,'KI','Kiribati',1),(115,'KP','Korea, Democratic People\'s Republic of',0),(116,'KR','Korea, Republic of',1),(117,'KW','Kuwait',1),(118,'KG','Kyrgyzstan',1),(119,'LA','Lao People\'s Democratic Republic',1),(120,'LV','Latvia',1),(121,'LB','Lebanon',0),(122,'LS','Lesotho',1),(123,'LR','Liberia',0),(124,'LY','Libyan Arab Jamahiriya',0),(125,'LI','Liechtenstein',1),(126,'LT','Lithuania',1),(127,'LU','Luxembourg',1),(128,'MO','Macao',0),(129,'MK','Macedonia, The Former Yugoslav Republic of',0),(130,'MG','Madagascar',1),(131,'MW','Malawi',1),(132,'MY','Malaysia',1),(133,'MV','Maldives',1),(134,'ML','Mali',1),(135,'MT','Malta',1),(136,'MH','Marshall Islands',1),(137,'MQ','Martinique',1),(138,'MR','Mauritania',1),(139,'MU','Mauritius',1),(140,'YT','Mayotte',1),(141,'MX','Mexico',1),(142,'FM','Micronesia, Federated States of',1),(143,'MD','Moldova, Republic of',0),(144,'MC','Monaco',0),(145,'MN','Mongolia',1),(146,'ME','Montenegro',0),(147,'MS','Montserrat',1),(148,'MA','Morocco',1),(149,'MZ','Mozambique',1),(150,'MM','Myanmar',0),(151,'NA','Namibia',1),(152,'NR','Nauru',1),(153,'NP','Nepal',1),(154,'NL','Netherlands',1),(155,'AN','Netherlands Antilles',1),(156,'NC','New Caledonia',1),(157,'NZ','New Zealand',1),(158,'NI','Nicaragua',1),(159,'NE','Niger',1),(160,'NG','Nigeria',0),(161,'NU','Niue',1),(162,'NF','Norfolk Island',1),(163,'MP','Northern Mariana Islands',0),(164,'NO','Norway',1),(165,'OM','Oman',1),(166,'PK','Pakistan',0),(167,'PW','Palau',1),(168,'PS','Palestinian Territory, Occupied',0),(169,'PA','Panama',1),(170,'PG','Papua New Guinea',1),(171,'PY','Paraguay',0),(172,'PE','Peru',1),(173,'PH','Philippines',1),(174,'PN','Pitcairn',1),(175,'PL','Poland',1),(176,'PT','Portugal',1),(177,'PR','Puerto Rico',0),(178,'QA','Qatar',1),(179,'RE','Reunion',1),(180,'RO','Romania',1),(181,'RU','Russian Federation',1),(182,'RW','Rwanda',1),(183,'SH','Saint Helena',1),(184,'KN','Saint Kitts and Nevis',1),(185,'LC','Saint Lucia',1),(186,'PM','Saint Pierre and Miquelon',1),(187,'VC','Saint Vincent and The Grenadines',1),(188,'WS','Samoa',1),(189,'SM','San Marino',1),(190,'ST','Sao Tome and Principe',0),(191,'SA','Saudi Arabia',1),(192,'SN','Senegal',1),(193,'RS','Serbia',0),(194,'SC','Seychelles',1),(195,'SL','Sierra Leone',1),(196,'SG','Singapore',1),(197,'SK','Slovakia',1),(198,'SI','Slovenia',1),(199,'SB','Solomon Islands',1),(200,'SO','Somalia',1),(201,'ZA','South Africa',1),(202,'GS','South Georgia and The South Sandwich Islands',0),(203,'ES','Spain',1),(204,'LK','Sri Lanka',1),(205,'SD','Sudan',0),(206,'SR','Suriname',1),(207,'SJ','Svalbard and Jan Mayen',1),(208,'SZ','Swaziland',1),(209,'SE','Sweden',1),(210,'CH','Switzerland',1),(211,'SY','Syrian Arab Republic',0),(212,'TW','Taiwan, Province of China',1),(213,'TJ','Tajikistan',1),(214,'TZ','Tanzania, United Republic of',1),(215,'TH','Thailand',1),(216,'TL','Timor-leste',0),(217,'TG','Togo',1),(218,'TK','Tokelau',0),(219,'TO','Tonga',1),(220,'TT','Trinidad and Tobago',1),(221,'TN','Tunisia',1),(222,'TR','Turkey',1),(223,'TM','Turkmenistan',1),(224,'TC','Turks and Caicos Islands',1),(225,'TV','Tuvalu',1),(226,'UG','Uganda',1),(227,'UA','Ukraine',1),(228,'AE','United Arab Emirates',1),(229,'GB','United Kingdom',1),(230,'US','United States',1),(231,'UM','United States Minor Outlying Islands',0),(232,'UY','Uruguay',1),(233,'UZ','Uzbekistan',0),(234,'VU','Vanuatu',1),(235,'VE','Venezuela',1),(236,'VN','Viet Nam',1),(237,'VG','Virgin Islands, British',1),(238,'VI','Virgin Islands, U.S.',0),(239,'WF','Wallis and Futuna',1),(240,'EH','Western Sahara',0),(241,'YE','Yemen',1),(242,'ZM','Zambia',1),(243,'ZW','Zimbabwe',0);
/*!40000 ALTER TABLE `countries` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `deposits`
--

DROP TABLE IF EXISTS `deposits`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `deposits` (
  `id` int(200) NOT NULL,
  `security_deposit` decimal(65,0) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `deposits`
--

LOCK TABLES `deposits` WRITE;
/*!40000 ALTER TABLE `deposits` DISABLE KEYS */;
/*!40000 ALTER TABLE `deposits` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `employment_and_income_history`
--

DROP TABLE IF EXISTS `employment_and_income_history`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `employment_and_income_history` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_tenant` int(10) unsigned DEFAULT NULL,
  `employer_name` varchar(15) DEFAULT NULL,
  `city` varchar(15) DEFAULT NULL,
  `employer_phone` varchar(15) DEFAULT NULL,
  `employed_from` date DEFAULT NULL,
  `employed_till` date DEFAULT NULL,
  `monthly_gross_pay` decimal(6,2) DEFAULT NULL,
  `occupation` varchar(40) DEFAULT NULL,
  `additional_income_2nd_job` varchar(40) DEFAULT NULL,
  `assets` varchar(15) DEFAULT NULL,
  `notes` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `employment_and_income_history`
--

LOCK TABLES `employment_and_income_history` WRITE;
/*!40000 ALTER TABLE `employment_and_income_history` DISABLE KEYS */;
INSERT INTO `employment_and_income_history` VALUES (1,1,'Anderson Lopez','New Yourk','4989582423','2012-12-01','2014-01-31',5000.00,'database developer','None','None ','<br>');
/*!40000 ALTER TABLE `employment_and_income_history` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `groups`
--

DROP TABLE IF EXISTS `groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `groups`
--

LOCK TABLES `groups` WRITE;
/*!40000 ALTER TABLE `groups` DISABLE KEYS */;
INSERT INTO `groups` VALUES (1,'administrator','2015-04-23 03:23:27','2015-04-23 03:23:27'),(2,'tenant','2015-04-23 03:23:38','2015-04-23 03:23:38');
/*!40000 ALTER TABLE `groups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `i18n`
--

DROP TABLE IF EXISTS `i18n`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `i18n` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `locale` varchar(6) NOT NULL,
  `model` varchar(255) NOT NULL,
  `foreign_key` int(10) NOT NULL,
  `field` varchar(255) NOT NULL,
  `content` mediumtext,
  PRIMARY KEY (`id`),
  KEY `locale` (`locale`),
  KEY `model` (`model`),
  KEY `row_id` (`foreign_key`),
  KEY `field` (`field`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `i18n`
--

LOCK TABLES `i18n` WRITE;
/*!40000 ALTER TABLE `i18n` DISABLE KEYS */;
/*!40000 ALTER TABLE `i18n` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `leasestypes`
--

DROP TABLE IF EXISTS `leasestypes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `leasestypes` (
  `id` int(200) NOT NULL,
  `type_lease` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `leasestypes`
--

LOCK TABLES `leasestypes` WRITE;
/*!40000 ALTER TABLE `leasestypes` DISABLE KEYS */;
INSERT INTO `leasestypes` VALUES (1,'Fixed'),(2,'Fixed w/rollover'),(3,'At-will');
/*!40000 ALTER TABLE `leasestypes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `logs`
--

DROP TABLE IF EXISTS `logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uri` varchar(255) NOT NULL,
  `method` varchar(6) NOT NULL,
  `params` text NOT NULL,
  `api_key` varchar(40) NOT NULL,
  `ip_address` varchar(15) NOT NULL,
  `time` int(11) NOT NULL,
  `authorized` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `uri` (`uri`),
  KEY `ip_address` (`ip_address`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `logs`
--

LOCK TABLES `logs` WRITE;
/*!40000 ALTER TABLE `logs` DISABLE KEYS */;
/*!40000 ALTER TABLE `logs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `marital_status`
--

DROP TABLE IF EXISTS `marital_status`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `marital_status` (
  `id` int(10) NOT NULL,
  `marital_status` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `marital_status`
--

LOCK TABLES `marital_status` WRITE;
/*!40000 ALTER TABLE `marital_status` DISABLE KEYS */;
INSERT INTO `marital_status` VALUES (1,'Marie'),(2,'celibataire'),(3,'divorce');
/*!40000 ALTER TABLE `marital_status` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `membership_grouppermissions`
--

DROP TABLE IF EXISTS `membership_grouppermissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `membership_grouppermissions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_membership_group` int(11) DEFAULT NULL,
  `tableName` varchar(100) DEFAULT NULL,
  `allowInsert` tinyint(4) DEFAULT NULL,
  `allowView` tinyint(4) NOT NULL DEFAULT '0',
  `allowEdit` tinyint(4) NOT NULL DEFAULT '0',
  `allowDelete` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `membership_grouppermissions`
--

LOCK TABLES `membership_grouppermissions` WRITE;
/*!40000 ALTER TABLE `membership_grouppermissions` DISABLE KEYS */;
/*!40000 ALTER TABLE `membership_grouppermissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `membership_groups`
--

DROP TABLE IF EXISTS `membership_groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `membership_groups` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) DEFAULT NULL,
  `description` text,
  `allowSignup` tinyint(4) DEFAULT NULL,
  `needsApproval` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `membership_groups`
--

LOCK TABLES `membership_groups` WRITE;
/*!40000 ALTER TABLE `membership_groups` DISABLE KEYS */;
INSERT INTO `membership_groups` VALUES (1,'anonymous','Anonymous group created automatically on 2014-03-02',0,0),(2,'Admins','Admin group created automatically on 2014-03-02',0,1);
/*!40000 ALTER TABLE `membership_groups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `membership_userpermissions`
--

DROP TABLE IF EXISTS `membership_userpermissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `membership_userpermissions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_membership_user` varchar(20) NOT NULL,
  `tableName` varchar(100) DEFAULT NULL,
  `allowInsert` tinyint(4) DEFAULT NULL,
  `allowView` tinyint(4) NOT NULL DEFAULT '0',
  `allowEdit` tinyint(4) NOT NULL DEFAULT '0',
  `allowDelete` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `membership_userpermissions`
--

LOCK TABLES `membership_userpermissions` WRITE;
/*!40000 ALTER TABLE `membership_userpermissions` DISABLE KEYS */;
/*!40000 ALTER TABLE `membership_userpermissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `membership_userrecords`
--

DROP TABLE IF EXISTS `membership_userrecords`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `membership_userrecords` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tableName` varchar(100) DEFAULT NULL,
  `pkValue` varchar(255) DEFAULT NULL,
  `id_membership_user` varchar(20) DEFAULT NULL,
  `dateAdded` bigint(20) unsigned DEFAULT NULL,
  `dateUpdated` bigint(20) unsigned DEFAULT NULL,
  `id_membership_group` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tableName_pkValue` (`tableName`,`pkValue`),
  KEY `pkValue` (`pkValue`),
  KEY `tableName` (`tableName`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `membership_userrecords`
--

LOCK TABLES `membership_userrecords` WRITE;
/*!40000 ALTER TABLE `membership_userrecords` DISABLE KEYS */;
/*!40000 ALTER TABLE `membership_userrecords` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `membership_users`
--

DROP TABLE IF EXISTS `membership_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `membership_users` (
  `id` varchar(20) NOT NULL,
  `passMD5` varchar(40) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `signupDate` date DEFAULT NULL,
  `id_membership_group` int(10) unsigned DEFAULT NULL,
  `isBanned` tinyint(4) DEFAULT NULL,
  `isApproved` tinyint(4) DEFAULT NULL,
  `custom1` text,
  `custom2` text,
  `custom3` text,
  `custom4` text,
  `comments` text,
  `pass_reset_key` varchar(100) DEFAULT NULL,
  `pass_reset_expiry` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `membership_users`
--

LOCK TABLES `membership_users` WRITE;
/*!40000 ALTER TABLE `membership_users` DISABLE KEYS */;
/*!40000 ALTER TABLE `membership_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payments`
--

DROP TABLE IF EXISTS `payments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `payments` (
  `id` int(10) NOT NULL,
  `id_tenant` int(10) NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payments`
--

LOCK TABLES `payments` WRITE;
/*!40000 ALTER TABLE `payments` DISABLE KEYS */;
/*!40000 ALTER TABLE `payments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `posts`
--

DROP TABLE IF EXISTS `posts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `post_file` varchar(255) DEFAULT NULL,
  `publish_date` date DEFAULT NULL,
  `is_published` tinyint(1) DEFAULT '0',
  `parent_id` char(36) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `content` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `posts`
--

LOCK TABLES `posts` WRITE;
/*!40000 ALTER TABLE `posts` DISABLE KEYS */;
INSERT INTO `posts` VALUES (1,'LA FEMME DANS LA FOULE','femme','','2015-04-23',0,NULL,NULL,'2015-04-23 20:11:35','2015-04-23 20:14:42','La plus belle femme de la planete');
/*!40000 ALTER TABLE `posts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `profiles`
--

DROP TABLE IF EXISTS `profiles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `profiles` (
  `id` varchar(36) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `phone` varchar(30) DEFAULT NULL,
  `language` varchar(3) NOT NULL DEFAULT 'en',
  `image` varchar(36) DEFAULT NULL,
  `timezone` varchar(32) DEFAULT 'America/Montreal',
  `date_of_birth` date DEFAULT NULL,
  `gender` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `profiles`
--

LOCK TABLES `profiles` WRITE;
/*!40000 ALTER TABLE `profiles` DISABLE KEYS */;
/*!40000 ALTER TABLE `profiles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `properties`
--

DROP TABLE IF EXISTS `properties`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `properties` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `property_name` varchar(15) NOT NULL,
  `id_unit` varchar(40) DEFAULT NULL,
  `propertiestypes_specification_id` int(10) NOT NULL,
  `number_of_units` decimal(15,0) DEFAULT NULL,
  `id_rental_owner` int(10) unsigned DEFAULT NULL,
  `operating_account` varchar(40) NOT NULL,
  `property_reserve` decimal(15,0) DEFAULT NULL,
  `rental_amount` decimal(6,2) DEFAULT NULL,
  `deposit_amount` decimal(6,2) DEFAULT NULL,
  `lease_term` varchar(15) DEFAULT NULL,
  `country` varchar(40) DEFAULT NULL,
  `street` varchar(40) DEFAULT NULL,
  `City` varchar(40) DEFAULT NULL,
  `State` varchar(40) DEFAULT NULL,
  `ZIP` decimal(15,0) DEFAULT NULL,
  `photo` varchar(40) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `properties`
--

LOCK TABLES `properties` WRITE;
/*!40000 ALTER TABLE `properties` DISABLE KEYS */;
INSERT INTO `properties` VALUES (1,'Appartment','218 W',0,1,1,'Operating bank account',1000,700.00,1400.00,NULL,'United States','795 E DRAGRAM','TUCSON','AZ',85705,'57549900_1394029329.jpg'),(2,'House','592',0,1,4,'Operating bank account',2000,1000.00,2500.00,NULL,'United States','421 E DRACHMAN','TUCSON','AZ',7598,'51585300_1394030122.jpg'),(3,'House','123 ',0,4,3,'Security deposit bank account',16000,1000.00,2000.00,NULL,'United States','FLOYLSTONE AVE','SEATTLE ','WA',42525,'36299700_1394029775.jpg');
/*!40000 ALTER TABLE `properties` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `propertiestypes`
--

DROP TABLE IF EXISTS `propertiestypes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `propertiestypes` (
  `id` varchar(200) NOT NULL,
  `type` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `propertiestypes`
--

LOCK TABLES `propertiestypes` WRITE;
/*!40000 ALTER TABLE `propertiestypes` DISABLE KEYS */;
INSERT INTO `propertiestypes` VALUES ('','Aerospace'),('1','Industrial'),('2','Commercial'),('3','Residential');
/*!40000 ALTER TABLE `propertiestypes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `propertiestypes_specifications`
--

DROP TABLE IF EXISTS `propertiestypes_specifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `propertiestypes_specifications` (
  `id` int(10) NOT NULL,
  `propertiestype_id` int(10) NOT NULL,
  `propertiestypes_specification` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `propertiestypes_specifications`
--

LOCK TABLES `propertiestypes_specifications` WRITE;
/*!40000 ALTER TABLE `propertiestypes_specifications` DISABLE KEYS */;
INSERT INTO `propertiestypes_specifications` VALUES (1,3,'apartment'),(2,2,'Entrepot'),(3,1,'laboratoire'),(4,3,'bongalot');
/*!40000 ALTER TABLE `propertiestypes_specifications` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `recurringcharges`
--

DROP TABLE IF EXISTS `recurringcharges`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `recurringcharges` (
  `id` int(200) NOT NULL,
  `frequency` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `recurringcharges`
--

LOCK TABLES `recurringcharges` WRITE;
/*!40000 ALTER TABLE `recurringcharges` DISABLE KEYS */;
INSERT INTO `recurringcharges` VALUES (1,'Monthly'),(2,'Daily'),(3,'Weekly'),(4,'Every two weeks'),(5,'Every two months'),(6,'Quartely'),(7,'Every six months'),(8,'Yearly'),(9,'One time');
/*!40000 ALTER TABLE `recurringcharges` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `references`
--

DROP TABLE IF EXISTS `references`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `references` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_tenant` int(10) unsigned DEFAULT NULL,
  `reference_first_name_1` varchar(15) DEFAULT NULL,
  `reference_last_name_1` varchar(15) DEFAULT NULL,
  `phone_1` varchar(15) DEFAULT NULL,
  `first_name_2` varchar(15) DEFAULT NULL,
  `last_name_2` varchar(15) DEFAULT NULL,
  `phone_2` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `references`
--

LOCK TABLES `references` WRITE;
/*!40000 ALTER TABLE `references` DISABLE KEYS */;
/*!40000 ALTER TABLE `references` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rental_owners`
--

DROP TABLE IF EXISTS `rental_owners`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rental_owners` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `first_name` varchar(40) DEFAULT NULL,
  `last_name` varchar(40) DEFAULT NULL,
  `company_name` varchar(40) DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `primary_email` varchar(40) DEFAULT NULL,
  `alternate_email` varchar(40) DEFAULT NULL,
  `phone` varchar(40) DEFAULT NULL,
  `country` varchar(40) DEFAULT NULL,
  `street` varchar(40) DEFAULT NULL,
  `city` varchar(40) DEFAULT NULL,
  `state` varchar(40) DEFAULT NULL,
  `zip` decimal(15,0) DEFAULT NULL,
  `comments` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rental_owners`
--

LOCK TABLES `rental_owners` WRITE;
/*!40000 ALTER TABLE `rental_owners` DISABLE KEYS */;
INSERT INTO `rental_owners` VALUES (1,'Marry','Miller ','SMALLSYS INC','1969-03-12','marrymiller@she.com','mmiller@we.com','3456789012','United States','795 E DRAGRAM','TUCSON','AZ',85705,'<br>'),(2,'Anthony','White','JOHN GULLIBLE','1969-03-12','anthonywhite@he.com','antonwhite@he.com','7665342187','United States','200 E MAIN ST','PHOENIX','AZ',8512,'<br>'),(3,'Suzan','Edward','MARY ROE','1976-07-16','suzanedward@she.com','suzan89@she.com','3452877690','United States','799 E DRAGRAM SUITE 5A   ','TUCSON','AZ',8570,'<br>'),(4,'John','Smith','MEGASYSTEMS INC','1964-09-16','johnsmith@he.com','jsmith@megasystems.com','2345678912','United States','300 BOYLSTON AVE E','SEATTLE','WA',98102,'<br>');
/*!40000 ALTER TABLE `rental_owners` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `residence_and_rental_history`
--

DROP TABLE IF EXISTS `residence_and_rental_history`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `residence_and_rental_history` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_tenant` int(10) unsigned DEFAULT NULL,
  `address` varchar(40) DEFAULT NULL,
  `landlord_or_manager_name` varchar(15) DEFAULT NULL,
  `landlord_or_manager_phone` varchar(15) DEFAULT NULL,
  `monthly_rent` decimal(6,2) DEFAULT NULL,
  `date_of_residency_from` date DEFAULT NULL,
  `date_of_residency_to` date DEFAULT NULL,
  `reason_for_leaving` varchar(40) DEFAULT NULL,
  `notes` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `residence_and_rental_history`
--

LOCK TABLES `residence_and_rental_history` WRITE;
/*!40000 ALTER TABLE `residence_and_rental_history` DISABLE KEYS */;
/*!40000 ALTER TABLE `residence_and_rental_history` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `states`
--

DROP TABLE IF EXISTS `states`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `states` (
  `id` int(200) NOT NULL AUTO_INCREMENT,
  `country_id` int(11) NOT NULL,
  `state` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `states`
--

LOCK TABLES `states` WRITE;
/*!40000 ALTER TABLE `states` DISABLE KEYS */;
INSERT INTO `states` VALUES (1,38,'Quebec'),(2,38,'Toronto'),(3,93,'Port-au-Prince'),(4,93,'Cap-Haitien'),(5,30,'Brazilia'),(6,108,'kingston');
/*!40000 ALTER TABLE `states` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tenants`
--

DROP TABLE IF EXISTS `tenants`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tenants` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `first_name` varchar(15) DEFAULT NULL,
  `last_name` varchar(15) DEFAULT NULL,
  `email` varchar(80) DEFAULT NULL,
  `alternateemails_id` varchar(200) NOT NULL,
  `cell_phone` varchar(15) DEFAULT NULL,
  `home_phone` varchar(200) NOT NULL,
  `work_phone` varchar(200) DEFAULT NULL,
  `fax` varchar(200) DEFAULT NULL,
  `country_id` int(11) NOT NULL,
  `state_id` int(11) NOT NULL,
  `street` text NOT NULL,
  `city_id` int(11) NOT NULL,
  `zip` int(11) NOT NULL,
  `birth_date` date DEFAULT NULL,
  `driver_license_number` varchar(15) DEFAULT NULL,
  `driver_license_state` varchar(15) DEFAULT NULL,
  `total_number_of_occupants` varchar(15) DEFAULT NULL,
  `unit_or_address_applying_for` varchar(40) DEFAULT NULL,
  `requested_lease_term` varchar(15) DEFAULT NULL,
  `status` varchar(40) NOT NULL DEFAULT 'Applicant',
  `emergency_contact` varchar(100) DEFAULT NULL,
  `emergency_contact_email` varchar(200) NOT NULL,
  `emergency_contact_phone` varchar(200) NOT NULL,
  `relationship_to_tenant` varchar(200) NOT NULL,
  `co_signer_details` varchar(100) DEFAULT NULL,
  `notes` text,
  `photo` varchar(40) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `property_or_address_applying_for` (`unit_or_address_applying_for`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tenants`
--

LOCK TABLES `tenants` WRITE;
/*!40000 ALTER TABLE `tenants` DISABLE KEYS */;
INSERT INTO `tenants` VALUES (1,'Nancy','Walker','nancywalker@she.com','','9876543210','','0','0',0,0,'',0,0,'1973-03-01','34267789','CA','5','1',NULL,'Applicant','Name: Carola Paul\r\ne-mail: carolapaul@she.com\r\nPhone:1348973884\r\nAddress: POB 65502\r\nTUCSON AZ 85728','','','','Name: John Steve \r\ne-mail: johnsteve@he.com\r\nPhone:48245543\r\nAddress: 300 BOYLSTON AVE E\r\nSEATTLE WA','<br>','87076300_1394033914.jpg'),(2,'Olivia','Medison','oliviamedison@she.com','','8998435325','','0','0',0,0,'',0,0,'1980-01-23','76895432','GU','3','2',NULL,'Applicant','Name: Nim Jackson\r\nemail: nimjackson@she.com','','','','Name: Nim Jackson\r\nemail: nimjackson@she.com','<br>',NULL),(3,'Elisabeth','Ban','elisabethban@live.com','','2098435890','','0','0',0,0,'',0,0,'1985-07-20','76589965','GU','6','2',NULL,'Tenant',NULL,'','','',NULL,'<br>',NULL),(4,'Mona','Karim','karim@yahoo.com','','4387658987','5147894562','5145453689','4387894523',38,1,'225 plateau mont-royal',1,-1,'2015-04-23','12365456','Quebec','3','45','','application','Marie Andre Joseph','marieaj@gmail.com','5141237856','Wife','N/A','Application pour un nouveau',''),(5,'Jean','Joseph','jeanj@gmail.com','','5144569878','5147894546','4502589876','5124567823',1,1,'1234 outremont',1,-2,'2015-04-23','','','','','','application','Darlene','dada@yahoo.ca','4504567823','Wife','','','');
/*!40000 ALTER TABLE `tenants` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `units`
--

DROP TABLE IF EXISTS `units`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `units` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_property` int(10) unsigned DEFAULT NULL,
  `unit_number` varchar(40) DEFAULT NULL,
  `size` decimal(15,0) DEFAULT NULL,
  `market_rent` decimal(15,0) DEFAULT NULL,
  `country` varchar(40) DEFAULT NULL,
  `street` varchar(40) DEFAULT NULL,
  `city` varchar(40) DEFAULT NULL,
  `state` varchar(40) DEFAULT NULL,
  `postal_code` varchar(40) DEFAULT NULL,
  `bedrooms` varchar(40) DEFAULT NULL,
  `bath` decimal(15,0) DEFAULT NULL,
  `description` text,
  `features` text,
  `status` varchar(40) NOT NULL,
  `photo` varchar(40) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `unit_number` (`unit_number`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `units`
--

LOCK TABLES `units` WRITE;
/*!40000 ALTER TABLE `units` DISABLE KEYS */;
/*!40000 ALTER TABLE `units` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `salt` varchar(22) DEFAULT NULL,
  `group_id` int(11) NOT NULL,
  `role` varchar(20) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT '0',
  `last_login` datetime DEFAULT NULL,
  `last_ip` varchar(15) DEFAULT NULL,
  `old_salt` varchar(22) DEFAULT NULL,
  `old_hash` varchar(60) DEFAULT NULL,
  `force_reset` tinyint(1) DEFAULT '0',
  `fraudulent` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,NULL,'vba','vba',NULL,1,'admin','2015-04-23 03:31:48','2015-04-23 03:31:48',0,NULL,NULL,NULL,NULL,0,0);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-04-23 20:49:22
