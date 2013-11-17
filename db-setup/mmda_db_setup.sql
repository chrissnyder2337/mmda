-- MySQL dump 10.14  Distrib 5.5.33a-MariaDB, for Linux (x86_64)
--
-- Host: localhost    Database: dagrdb
-- ------------------------------------------------------
-- Server version	5.5.33a-MariaDB

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
-- Table structure for table `AudioMetadata`
--

DROP TABLE IF EXISTS `AudioMetadata`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `AudioMetadata` (
  `uuid` varchar(64) NOT NULL,
  `audio_bitrate` float DEFAULT NULL,
  `audio_sample_rate` int(11) DEFAULT NULL,
  `channels` int(11) DEFAULT NULL COMMENT 'french, english',
  `channel_type` varchar(32) DEFAULT NULL COMMENT 'stereo, mono, etc',
  `audio_format` varchar(32) DEFAULT NULL,
  `track_number` varchar(32) DEFAULT NULL,
  `title` varchar(32) DEFAULT NULL,
  `genre` varchar(32) DEFAULT NULL,
  `duration` varchar(32) DEFAULT NULL,
  `artist` varchar(32) DEFAULT NULL,
  `album` varchar(32) DEFAULT NULL,
  `audio_compression` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `AudioMetadata`
--

LOCK TABLES `AudioMetadata` WRITE;
/*!40000 ALTER TABLE `AudioMetadata` DISABLE KEYS */;
/*!40000 ALTER TABLE `AudioMetadata` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `AuthoringMetadata`
--

DROP TABLE IF EXISTS `AuthoringMetadata`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `AuthoringMetadata` (
  `uuid` varchar(64) NOT NULL,
  `created_date` timestamp NULL DEFAULT NULL,
  `last_modified_date` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `AuthoringMetadata`
--

LOCK TABLES `AuthoringMetadata` WRITE;
/*!40000 ALTER TABLE `AuthoringMetadata` DISABLE KEYS */;
/*!40000 ALTER TABLE `AuthoringMetadata` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `DocumentCountsMetadata`
--

DROP TABLE IF EXISTS `DocumentCountsMetadata`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `DocumentCountsMetadata` (
  `uuid` varchar(64) NOT NULL,
  `image_count` int(11) DEFAULT NULL,
  `page_count` int(11) DEFAULT NULL,
  `table_count` int(11) DEFAULT NULL,
  `paragraph_count` int(11) DEFAULT NULL,
  `character_count` int(11) DEFAULT NULL,
  `word_count` int(11) DEFAULT NULL,
  `character_count_with_space` int(11) DEFAULT NULL,
  `slide_count` int(11) DEFAULT NULL,
  PRIMARY KEY (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `DocumentCountsMetadata`
--

LOCK TABLES `DocumentCountsMetadata` WRITE;
/*!40000 ALTER TABLE `DocumentCountsMetadata` DISABLE KEYS */;
/*!40000 ALTER TABLE `DocumentCountsMetadata` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ExecutableMetadata`
--

DROP TABLE IF EXISTS `ExecutableMetadata`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ExecutableMetadata` (
  `uuid` varchar(64) NOT NULL,
  `architecture_bits` int(11) DEFAULT NULL,
  `machine_type` varchar(32) NOT NULL COMMENT 'ex: x86-32',
  `machine_platform` varchar(32) NOT NULL COMMENT 'linux, windows, etc',
  PRIMARY KEY (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ExecutableMetadata`
--

LOCK TABLES `ExecutableMetadata` WRITE;
/*!40000 ALTER TABLE `ExecutableMetadata` DISABLE KEYS */;
/*!40000 ALTER TABLE `ExecutableMetadata` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `File`
--

DROP TABLE IF EXISTS `File`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `File` (
  `uuid` varchar(64) NOT NULL,
  `anotated_name` varchar(32) DEFAULT NULL COMMENT 'User defined',
  `resource_name` varchar(32) NOT NULL COMMENT 'File Name',
  `content_type` varchar(32) NOT NULL,
  `content_length` int(11) NOT NULL,
  `md5_hash` varchar(32) CHARACTER SET ascii COLLATE ascii_bin NOT NULL,
  `local_path` varchar(256) NOT NULL,
  `external_path` varchar(256) NOT NULL,
  `file_added_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `File`
--

LOCK TABLES `File` WRITE;
/*!40000 ALTER TABLE `File` DISABLE KEYS */;
/*!40000 ALTER TABLE `File` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `FileReferences`
--

DROP TABLE IF EXISTS `FileReferences`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `FileReferences` (
  `parent_uuid` varchar(64) NOT NULL,
  `child_uuid` varchar(64) NOT NULL,
  PRIMARY KEY (`parent_uuid`,`child_uuid`),
  KEY `parent_uuid` (`parent_uuid`,`child_uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `FileReferences`
--

LOCK TABLES `FileReferences` WRITE;
/*!40000 ALTER TABLE `FileReferences` DISABLE KEYS */;
/*!40000 ALTER TABLE `FileReferences` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ImageResolutionMetadata`
--

DROP TABLE IF EXISTS `ImageResolutionMetadata`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ImageResolutionMetadata` (
  `uuid` varchar(64) NOT NULL,
  `x_resolution` int(11) NOT NULL,
  `y_resolution` int(11) NOT NULL,
  `resolution_units` varchar(32) NOT NULL,
  PRIMARY KEY (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ImageResolutionMetadata`
--

LOCK TABLES `ImageResolutionMetadata` WRITE;
/*!40000 ALTER TABLE `ImageResolutionMetadata` DISABLE KEYS */;
/*!40000 ALTER TABLE `ImageResolutionMetadata` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Keywords`
--

DROP TABLE IF EXISTS `Keywords`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Keywords` (
  `uuid` varchar(64) NOT NULL,
  `keyword` varchar(256) NOT NULL,
  KEY `keyword` (`keyword`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Keywords`
--

LOCK TABLES `Keywords` WRITE;
/*!40000 ALTER TABLE `Keywords` DISABLE KEYS */;
/*!40000 ALTER TABLE `Keywords` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `VideoMetadata`
--

DROP TABLE IF EXISTS `VideoMetadata`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `VideoMetadata` (
  `uuid` varchar(64) NOT NULL,
  `video_datarate` int(11) DEFAULT NULL,
  `video_formate` varchar(32) DEFAULT NULL,
  `video_duration` int(11) DEFAULT NULL,
  `audio_duration` int(11) DEFAULT NULL,
  PRIMARY KEY (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `VideoMetadata`
--

LOCK TABLES `VideoMetadata` WRITE;
/*!40000 ALTER TABLE `VideoMetadata` DISABLE KEYS */;
/*!40000 ALTER TABLE `VideoMetadata` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `WebpageMetadata`
--

DROP TABLE IF EXISTS `WebpageMetadata`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `WebpageMetadata` (
  `uuid` varchar(64) NOT NULL,
  `webpage_title` varchar(256) DEFAULT NULL,
  PRIMARY KEY (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `WebpageMetadata`
--

LOCK TABLES `WebpageMetadata` WRITE;
/*!40000 ALTER TABLE `WebpageMetadata` DISABLE KEYS */;
/*!40000 ALTER TABLE `WebpageMetadata` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2013-11-17 11:48:58
