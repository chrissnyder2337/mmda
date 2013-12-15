-- phpMyAdmin SQL Dump
-- version 3.5.8.1deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 09, 2013 at 10:04 PM
-- Server version: 5.5.34-0ubuntu0.13.04.1
-- PHP Version: 5.4.9-4ubuntu2.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `dagrdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `AudioMetadata`
--

CREATE TABLE IF NOT EXISTS `AudioMetadata` (
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

-- --------------------------------------------------------

--
-- Table structure for table `AuthoringMetadata`
--

CREATE TABLE IF NOT EXISTS `AuthoringMetadata` (
  `uuid` varchar(64) NOT NULL,
  `created_date` timestamp NULL DEFAULT NULL,
  `last_modified_date` timestamp NULL DEFAULT NULL,
  `author` varchar(32) DEFAULT NULL,
  `title` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `DocumentCountsMetadata`
--

CREATE TABLE IF NOT EXISTS `DocumentCountsMetadata` (
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

-- --------------------------------------------------------

--
-- Table structure for table `ExecutableMetadata`
--

CREATE TABLE IF NOT EXISTS `ExecutableMetadata` (
  `uuid` varchar(64) NOT NULL,
  `architecture_bits` int(11) DEFAULT NULL,
  `machine_type` varchar(32) DEFAULT NULL COMMENT 'ex: x86-32',
  `machine_platform` varchar(32) DEFAULT NULL COMMENT 'linux, windows, etc',
  PRIMARY KEY (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `File`
--

CREATE TABLE IF NOT EXISTS `File` (
  `uuid` varchar(64) NOT NULL,
  `anotated_name` varchar(32) DEFAULT NULL COMMENT 'User defined',
  `resource_name` varchar(32) DEFAULT NULL COMMENT 'File Name',
  `content_type` varchar(32) DEFAULT NULL,
  `content_length` int(11) DEFAULT NULL,
  `md5_hash` varchar(32) CHARACTER SET ascii COLLATE ascii_bin DEFAULT NULL,
  `local_path` varchar(256) DEFAULT NULL,
  `external_path` varchar(256) DEFAULT NULL,
  `file_added_timestamp` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `FileReferences`
--

CREATE TABLE IF NOT EXISTS `FileReferences` (
  `parent_uuid` varchar(64) NOT NULL,
  `child_uuid` varchar(64) NOT NULL,
  PRIMARY KEY (`parent_uuid`,`child_uuid`),
  KEY `parent_uuid` (`parent_uuid`,`child_uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ImageResolutionMetadata`
--

CREATE TABLE IF NOT EXISTS `ImageResolutionMetadata` (
  `uuid` varchar(64) NOT NULL,
  `x_resolution` int(11) DEFAULT NULL,
  `y_resolution` int(11) DEFAULT NULL,
  `resolution_units` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `Keywords`
--

CREATE TABLE IF NOT EXISTS `Keywords` (
  `uuid` varchar(64) NOT NULL,
  `keyword` varchar(256) NOT NULL,
  KEY `keyword` (`keyword`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `VideoMetadata`
--

CREATE TABLE IF NOT EXISTS `VideoMetadata` (
  `uuid` varchar(64) NOT NULL,
  `video_datarate` int(11) DEFAULT NULL,
  `video_format` varchar(32) DEFAULT NULL,
  `video_duration` int(11) DEFAULT NULL,
  `audio_duration` int(11) DEFAULT NULL,
  PRIMARY KEY (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `WebpageMetadata`
--

CREATE TABLE IF NOT EXISTS `WebpageMetadata` (
  `uuid` varchar(64) NOT NULL,
  `webpage_title` varchar(256) DEFAULT NULL,
  PRIMARY KEY (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
