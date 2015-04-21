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
  `id_tenant` int(11) NOT NULL,
  `id_payment` int(11) NOT NULL
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
-- Table structure for table `applications_leases`
--

DROP TABLE IF EXISTS `applications_leases`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `applications_leases` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_tenant` int(10) unsigned DEFAULT NULL,
  `id_property` int(10) unsigned DEFAULT NULL,
  `id_unit` int(10) unsigned DEFAULT NULL,
  `type` varchar(40) NOT NULL DEFAULT 'Fixed',
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `recurring_charges_frequency` varchar(40) DEFAULT NULL,
  `next_due_date` date DEFAULT NULL,
  `rent` varchar(40) DEFAULT NULL,
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
/*!40000 ALTER TABLE `applications_leases` ENABLE KEYS */;
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
/*!40000 ALTER TABLE `employment_and_income_history` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
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
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8;
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
-- Table structure for table `properties`
--

DROP TABLE IF EXISTS `properties`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `properties` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `property_name` varchar(15) NOT NULL,
  `id_unit` varchar(40) DEFAULT NULL,
  `type` varchar(40) NOT NULL,
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
/*!40000 ALTER TABLE `properties` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `residence_and_rental_history`
--

LOCK TABLES `residence_and_rental_history` WRITE;
/*!40000 ALTER TABLE `residence_and_rental_history` DISABLE KEYS */;
/*!40000 ALTER TABLE `residence_and_rental_history` ENABLE KEYS */;
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
  `phone` varchar(15) DEFAULT NULL,
  `birth_date` date DEFAULT NULL,
  `driver_license_number` varchar(15) DEFAULT NULL,
  `driver_license_state` varchar(15) DEFAULT NULL,
  `total_number_of_occupants` varchar(15) DEFAULT NULL,
  `unit_or_address_applying_for` varchar(40) DEFAULT NULL,
  `requested_lease_term` varchar(15) DEFAULT NULL,
  `status` varchar(40) NOT NULL DEFAULT 'Applicant',
  `emergency_contact` varchar(100) DEFAULT NULL,
  `co_signer_details` varchar(100) DEFAULT NULL,
  `notes` text,
  `photo` varchar(40) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `property_or_address_applying_for` (`unit_or_address_applying_for`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tenants`
--

LOCK TABLES `tenants` WRITE;
/*!40000 ALTER TABLE `tenants` DISABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `units`
--

LOCK TABLES `units` WRITE;
/*!40000 ALTER TABLE `units` DISABLE KEYS */;
/*!40000 ALTER TABLE `units` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-04-21 15:07:04
