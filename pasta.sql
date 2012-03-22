-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 22, 2012 at 06:59 PM
-- Server version: 5.5.16
-- PHP Version: 5.3.8

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
-- Table structure for table `completed_course`
--

CREATE TABLE IF NOT EXISTS `completed_course` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

CREATE TABLE IF NOT EXISTS `course` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(6) NOT NULL,
  `number` int(11) NOT NULL,
  `credit` float NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`id`, `code`, `number`, `credit`) VALUES
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
-- Table structure for table `lab`
--

CREATE TABLE IF NOT EXISTS `lab` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `section` varchar(4) NOT NULL,
  `tutorial_id` int(11) NOT NULL,
  `time_location_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `lab`
--

INSERT INTO `lab` (`id`, `section`, `tutorial_id`, `time_location_id`) VALUES
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
-- Table structure for table `lecture`
--

CREATE TABLE IF NOT EXISTS `lecture` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `section` varchar(4) NOT NULL,
  `professor` varchar(255) NOT NULL,
  `season` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `time_location_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `lecture`
--

INSERT INTO `lecture` (`id`, `section`, `professor`, `season`, `course_id`, `time_location_id`) VALUES
(3, 'AA', 'AIMAN HANNA', 2, 2, 1),
(4, 'JJ', 'JOHN SMITH', 2, 3, 2),
(5, 'WW', 'JOHN LEE', 2, 4, 5),
(6, 'LL', 'JACKIE CHAN', 2, 5, 6),
(7, 'MM', 'LIONEL MESSI', 2, 6, 7),
(8, 'II', 'JOHN PEACH', 2, 7, 8);

-- --------------------------------------------------------

--
-- Table structure for table `prerequisite`
--

CREATE TABLE IF NOT EXISTS `prerequisite` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `course_id` int(11) NOT NULL,
  `required_course_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `schedule`
--

CREATE TABLE IF NOT EXISTS `schedule` (
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
-- Table structure for table `time_location`
--

CREATE TABLE IF NOT EXISTS `time_location` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `time` varchar(255) NOT NULL,
  `campus` varchar(6) NOT NULL,
  `room` varchar(10) NOT NULL,
  `day` varchar(5) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `time_location`
--

INSERT INTO `time_location` (`id`, `time`, `campus`, `room`, `day`) VALUES
(1, '1345-1430', 'SGW', 'H-400', 'M-W--'),
(2, '0845-1015', 'sgw', 'H-626', '-T-T-'),
(3, '0845-1015', 'sgw', 'H-626', '-T-T-'),
(4, '0915-1145', 'SGW', 'MB-11.55', '-T-T-'),
(5, '1215-1330', 'sgw', 'H-110', 'MT---'),
(6, '1745-2015', 'SGW', 'H-820', '-T-J-'),
(7, '1545-1700', 'SGW', 'EV-15.100', '--W-J');

-- --------------------------------------------------------

--
-- Table structure for table `tutorial`
--

CREATE TABLE IF NOT EXISTS `tutorial` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `section` varchar(4) NOT NULL,
  `lecture_id` int(11) NOT NULL,
  `time_location_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `tutorial`
--

INSERT INTO `tutorial` (`id`, `section`, `lecture_id`, `time_location_id`) VALUES
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
