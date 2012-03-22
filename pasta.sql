-- phpMyAdmin SQL Dump
-- version 3.3.9.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 22, 2012 at 04:37 PM
-- Server version: 5.5.9
-- PHP Version: 5.3.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `pasta`
--
CREATE DATABASE `pasta` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `pasta`;

-- --------------------------------------------------------

--
-- Table structure for table `completed_courses`
--

CREATE TABLE `completed_courses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `completed_courses`
--


-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(6) NOT NULL,
  `number` int(11) NOT NULL,
  `credit` float NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` VALUES(1, 'COMP', 348, 4);
INSERT INTO `courses` VALUES(2, 'COMP', 249, 3);
INSERT INTO `courses` VALUES(3, 'ENGR', 234, 4);
INSERT INTO `courses` VALUES(4, 'ENGR', 201, 2);
INSERT INTO `courses` VALUES(5, 'SOEN', 228, 4);
INSERT INTO `courses` VALUES(6, 'ELEC', 275, 4);
INSERT INTO `courses` VALUES(7, 'ENGR', 202, 1.5);
INSERT INTO `courses` VALUES(8, 'SOEN', 490, 4);
INSERT INTO `courses` VALUES(9, 'COMP', 248, 3);
INSERT INTO `courses` VALUES(10, 'ENGR', 213, 3);
INSERT INTO `courses` VALUES(11, 'ENGR', 232, 3);
INSERT INTO `courses` VALUES(12, 'ENGR', 233, 3);
INSERT INTO `courses` VALUES(13, 'SOEN', 341, 3);
INSERT INTO `courses` VALUES(14, 'COMP', 352, 3);

-- --------------------------------------------------------

--
-- Table structure for table `labs`
--

CREATE TABLE `labs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `section` varchar(4) NOT NULL,
  `tutorial_id` int(11) NOT NULL,
  `time_location_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `labs`
--

INSERT INTO `labs` VALUES(1, 'AC', 1, 1);
INSERT INTO `labs` VALUES(2, 'AC', 1, 1);
INSERT INTO `labs` VALUES(3, 'JC', 2, 2);
INSERT INTO `labs` VALUES(4, 'JC', 3, 3);
INSERT INTO `labs` VALUES(5, 'WC', 4, 4);
INSERT INTO `labs` VALUES(6, 'LC', 5, 5);
INSERT INTO `labs` VALUES(7, 'MC', 6, 6);
INSERT INTO `labs` VALUES(8, 'IC', 7, 7);

-- --------------------------------------------------------

--
-- Table structure for table `lectures`
--

CREATE TABLE `lectures` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `section` varchar(4) NOT NULL,
  `professor` varchar(255) NOT NULL,
  `season` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `time_location_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `lectures`
--

INSERT INTO `lectures` VALUES(3, 'AA', 'AIMAN HANNA', 2, 2, 1);
INSERT INTO `lectures` VALUES(4, 'JJ', 'JOHN SMITH', 2, 3, 2);
INSERT INTO `lectures` VALUES(5, 'WW', 'JOHN LEE', 2, 4, 5);
INSERT INTO `lectures` VALUES(6, 'LL', 'JACKIE CHAN', 2, 5, 6);
INSERT INTO `lectures` VALUES(7, 'MM', 'LIONEL MESSI', 2, 6, 7);
INSERT INTO `lectures` VALUES(8, 'II', 'JOHN PEACH', 2, 7, 8);

-- --------------------------------------------------------

--
-- Table structure for table `logins`
--

CREATE TABLE `logins` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `student_id` int(7) unsigned DEFAULT NULL,
  `password` char(40) DEFAULT NULL,
  `first_name` varchar(20) DEFAULT NULL,
  `last_name` varchar(20) DEFAULT NULL,
  `program` enum('soft_eng','mech_eng') DEFAULT 'soft_eng',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `logins`
--

INSERT INTO `logins` VALUES(2, 5682061, '12345678', 'Charles', 'Yang', 'soft_eng');
INSERT INTO `logins` VALUES(3, 5682062, '7c222fb2927d828af22f592134e8932480637c0d', 'John', 'Doe', 'soft_eng');
INSERT INTO `logins` VALUES(4, 5682063, '7c222fb2927d828af22f592134e8932480637c0d', 'Charles', 'JuniorI', 'soft_eng');
INSERT INTO `logins` VALUES(5, 5682067, '7c222fb2927d828af22f592134e8932480637c0d', 'Charles Cho', 'Hello World', 'soft_eng');
INSERT INTO `logins` VALUES(6, 5682070, '7c222fb2927d828af22f592134e8932480637c0d', 'Charles Cho 54', 'Hello World', 'soft_eng');
INSERT INTO `logins` VALUES(7, 5682073, '7c222fb2927d828af22f592134e8932480637c0d', 'Jeremy', 'Lin', 'soft_eng');
INSERT INTO `logins` VALUES(8, 4758383, '7c222fb2927d828af22f592134e8932480637c0d', 'Eric', 'Chan', 'soft_eng');

-- --------------------------------------------------------

--
-- Table structure for table `prerequisites`
--

CREATE TABLE `prerequisites` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `course_id` int(11) NOT NULL,
  `required_course_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `prerequisites`
--


-- --------------------------------------------------------

--
-- Table structure for table `schedules`
--

CREATE TABLE `schedules` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student_id` int(11) NOT NULL,
  `season` int(11) NOT NULL,
  `year` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `lecture_id` int(11) NOT NULL,
  `tutorial_id` int(11) NOT NULL,
  `lab_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `schedules`
--


-- --------------------------------------------------------

--
-- Table structure for table `time_locations`
--

CREATE TABLE `time_locations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `start_time` int(11) NOT NULL,
  `end_time` int(11) NOT NULL,
  `campus` varchar(6) NOT NULL,
  `room` varchar(10) NOT NULL,
  `day` set('M','T','W','J','F') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `time_locations`
--

INSERT INTO `time_locations` VALUES(1, 1345, 1430, 'SGW', 'H-400', 'M,W');
INSERT INTO `time_locations` VALUES(2, 845, 1015, 'sgw', 'H-626', 'T,J');
INSERT INTO `time_locations` VALUES(3, 845, 1015, 'sgw', 'H-626', 'T,J');
INSERT INTO `time_locations` VALUES(4, 915, 1145, 'SGW', 'MB-11.55', 'T,J');
INSERT INTO `time_locations` VALUES(5, 1215, 1330, 'sgw', 'H-110', 'M,T');
INSERT INTO `time_locations` VALUES(6, 1745, 2015, 'SGW', 'H-820', 'T,J');
INSERT INTO `time_locations` VALUES(7, 1545, 1700, 'SGW', 'EV-15.100', 'W,J');

-- --------------------------------------------------------

--
-- Table structure for table `tutorials`
--

CREATE TABLE `tutorials` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `section` varchar(4) NOT NULL,
  `lecture_id` int(11) NOT NULL,
  `time_location_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `tutorials`
--

INSERT INTO `tutorials` VALUES(1, 'AB', 3, 1);
INSERT INTO `tutorials` VALUES(2, 'AB', 3, 1);
INSERT INTO `tutorials` VALUES(3, 'JB', 4, 7);
INSERT INTO `tutorials` VALUES(4, 'WB', 5, 6);
INSERT INTO `tutorials` VALUES(5, 'LB', 6, 5);
INSERT INTO `tutorials` VALUES(6, 'MB', 7, 4);
INSERT INTO `tutorials` VALUES(7, 'IB', 8, 3);
