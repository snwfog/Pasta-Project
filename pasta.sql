-- phpMyAdmin SQL Dump
-- version 3.4.10.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 22, 2012 at 06:39 PM
-- Server version: 5.5.9
-- PHP Version: 5.3.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `pasta`
--

-- --------------------------------------------------------

--
-- Table structure for table `completed_courses`
--

CREATE TABLE IF NOT EXISTS `completed_courses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `completed_courses`
--

INSERT INTO `completed_courses` (`id`, `student_id`, `course_id`) VALUES
(1, 3, 2),
(2, 3, 4),
(3, 3, 5),
(4, 3, 7),
(5, 3, 9),
(6, 3, 10),
(7, 3, 11),
(8, 4, 3);

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE IF NOT EXISTS `courses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(6) NOT NULL,
  `number` int(11) NOT NULL,
  `credit` float NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `code`, `number`, `credit`) VALUES
(1, 'COMP', 348, 4),
(2, 'COMP', 249, 3),
(3, 'ENGR', 234, 4),
(4, 'ENGR', 201, 2),
(5, 'SOEN', 228, 4),
(6, 'ELEC', 275, 4),
(7, 'ENGR', 202, 1.5),
(8, 'SOEN', 490, 4),
(9, 'COMP', 248, 3),
(10, 'ENGR', 213, 3),
(11, 'ENGR', 232, 3),
(12, 'ENGR', 233, 3),
(13, 'SOEN', 341, 3),
(14, 'COMP', 352, 3);

-- --------------------------------------------------------

--
-- Table structure for table `labs`
--

CREATE TABLE IF NOT EXISTS `labs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `section` varchar(4) NOT NULL,
  `tutorial_id` int(11) NOT NULL,
  `time_location_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `labs`
--

INSERT INTO `labs` (`id`, `section`, `tutorial_id`, `time_location_id`) VALUES
(1, 'AC', 1, 1),
(2, 'AC', 1, 1),
(3, 'JC', 2, 2),
(4, 'JC', 3, 3),
(5, 'WC', 4, 4),
(6, 'LC', 5, 5),
(7, 'MC', 6, 6),
(8, 'IC', 7, 7);

-- --------------------------------------------------------

--
-- Table structure for table `lectures`
--

CREATE TABLE IF NOT EXISTS `lectures` (
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

INSERT INTO `lectures` (`id`, `section`, `professor`, `season`, `course_id`, `time_location_id`) VALUES
(3, 'AA', 'AIMAN HANNA', 2, 2, 1),
(4, 'JJ', 'JOHN SMITH', 2, 3, 2),
(5, 'WW', 'JOHN LEE', 2, 4, 5),
(6, 'LL', 'JACKIE CHAN', 2, 5, 6),
(7, 'MM', 'LIONEL MESSI', 2, 6, 7),
(8, 'II', 'JOHN PEACH', 2, 7, 8);

-- --------------------------------------------------------

--
-- Table structure for table `logins`
--

CREATE TABLE IF NOT EXISTS `logins` (
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

INSERT INTO `logins` (`id`, `student_id`, `password`, `first_name`, `last_name`, `program`) VALUES
(2, 5682061, '12345678', 'Charles', 'Yang', 'soft_eng'),
(3, 5682062, '7c222fb2927d828af22f592134e8932480637c0d', 'John', 'Doe', 'soft_eng'),
(4, 5682063, '7c222fb2927d828af22f592134e8932480637c0d', 'Charles', 'JuniorI', 'soft_eng'),
(5, 5682067, '7c222fb2927d828af22f592134e8932480637c0d', 'Charles Cho', 'Hello World', 'soft_eng'),
(6, 5682070, '7c222fb2927d828af22f592134e8932480637c0d', 'Charles Cho 54', 'Hello World', 'soft_eng'),
(7, 5682073, '7c222fb2927d828af22f592134e8932480637c0d', 'Jeremy', 'Lin', 'soft_eng'),
(8, 4758383, '7c222fb2927d828af22f592134e8932480637c0d', 'Eric', 'Chan', 'soft_eng');

-- --------------------------------------------------------

--
-- Table structure for table `prerequisites`
--

CREATE TABLE IF NOT EXISTS `prerequisites` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `course_id` int(11) NOT NULL,
  `required_course_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `prerequisites`
--

INSERT INTO `prerequisites` (`id`, `course_id`, `required_course_id`) VALUES
(1, 2, 9),
(2, 10, 12),
(3, 13, 8),
(4, 13, 1);

-- --------------------------------------------------------

--
-- Table structure for table `schedules`
--

CREATE TABLE IF NOT EXISTS `schedules` (
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

-- --------------------------------------------------------

--
-- Table structure for table `time_locations`
--

CREATE TABLE IF NOT EXISTS `time_locations` (
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

INSERT INTO `time_locations` (`id`, `start_time`, `end_time`, `campus`, `room`, `day`) VALUES
(1, 1345, 1430, 'SGW', 'H-400', 'M,W'),
(2, 845, 1015, 'sgw', 'H-626', 'T,J'),
(3, 845, 1015, 'sgw', 'H-626', 'T,J'),
(4, 915, 1145, 'SGW', 'MB-11.55', 'T,J'),
(5, 1215, 1330, 'sgw', 'H-110', 'M,T'),
(6, 1745, 2015, 'SGW', 'H-820', 'T,J'),
(7, 1545, 1700, 'SGW', 'EV-15.100', 'W,J');

-- --------------------------------------------------------

--
-- Table structure for table `tutorials`
--

CREATE TABLE IF NOT EXISTS `tutorials` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `section` varchar(4) NOT NULL,
  `lecture_id` int(11) NOT NULL,
  `time_location_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `tutorials`
--

INSERT INTO `tutorials` (`id`, `section`, `lecture_id`, `time_location_id`) VALUES
(1, 'AB', 3, 1),
(2, 'AB', 3, 1),
(3, 'JB', 4, 7),
(4, 'WB', 5, 6),
(5, 'LB', 6, 5),
(6, 'MB', 7, 4),
(7, 'IB', 8, 3);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
