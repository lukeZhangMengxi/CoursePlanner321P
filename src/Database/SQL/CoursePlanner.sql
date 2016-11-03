-- phpMyAdmin SQL Dump
-- version 4.0.10.17
-- https://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 03, 2016 at 06:51 AM
-- Server version: 5.5.52
-- PHP Version: 5.6.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `CoursePlanner`
--

-- --------------------------------------------------------

--
-- Table structure for table `Course Feature`
--

CREATE TABLE IF NOT EXISTS `Course Feature` (
  `Feature Name` char(255) DEFAULT NULL,
  `Rating` int(5) unsigned DEFAULT NULL COMMENT 'Difficulty Rating',
  `Type` varchar(255) DEFAULT NULL COMMENT 'Category of feature',
  `Due Date` date DEFAULT NULL,
  `Course` char(7) DEFAULT NULL,
  `ID` int(255) NOT NULL AUTO_INCREMENT,
  `Course ID` int(255) unsigned NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `Rating` (`Rating`),
  KEY `Course ID` (`Course ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `Courses`
--

CREATE TABLE IF NOT EXISTS `Courses` (
  `Course Code` char(8) DEFAULT NULL COMMENT 'Course codes assigned by instituiton offering the course.',
  `Day(s) of Week` bit(7) DEFAULT NULL COMMENT 'Day(s) of the week the course meets',
  `Description` text,
  `Instructor` varchar(60) DEFAULT NULL,
  `Textbook` tinytext,
  `Start Time` time DEFAULT NULL COMMENT 'Time of the day the course starts',
  `End Time` time DEFAULT NULL COMMENT 'Time of the day the course ends',
  `Course_ID` int(255) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Unique ID for each course',
  PRIMARY KEY (`Course_ID`),
  UNIQUE KEY `Course Code` (`Course Code`),
  KEY `Day(s) of Week` (`Day(s) of Week`,`Instructor`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `Courses`
--

INSERT INTO `Courses` (`Course Code`, `Day(s) of Week`, `Description`, `Instructor`, `Textbook`, `Start Time`, `End Time`, `Course_ID`) VALUES
('CPEN 321', b'0000000', 'Software Engineering\r\n\r\nEngineering practices for the development of non-trivial software-intensive systems including requirements specification, software architecture, implementation, verification, and maintenance. Iterative development. Recognized standards, guidelines, and models. ', 'AGHAREBPARAST, FARSHID; GOPALAKRISHNAN, SATHISH', NULL, '12:30:00', '14:00:00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `User Courses`
--

CREATE TABLE IF NOT EXISTS `User Courses` (
  `Course ID` int(255) NOT NULL,
  `User_ID` int(255) NOT NULL,
  KEY `Course ID` (`Course ID`),
  KEY `User ID` (`User_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `User Profile`
--

CREATE TABLE IF NOT EXISTS `User Profile` (
  `Name` varchar(40) DEFAULT NULL,
  `Registration Date` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `ID` int(255) unsigned NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Course Feature`
--
ALTER TABLE `Course Feature`
  ADD CONSTRAINT `Course Feature_ibfk_1` FOREIGN KEY (`Course ID`) REFERENCES `Courses` (`Course_ID`) ON UPDATE CASCADE;

--
-- Constraints for table `User Courses`
--
ALTER TABLE `User Courses`
  ADD CONSTRAINT `User Courses_ibfk_1` FOREIGN KEY (`Course ID`) REFERENCES `Course Feature` (`ID`) ON UPDATE CASCADE;

<<<<<<< HEAD
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ;

CREATE TABLE IF NOT EXISTS `USER FEATURES`(
	
    `User id` tinyint(255) unsigned,
	`feature id` int(255) unsigned

) ENGINE=InnoDB DEFAULT CHARSET=latin1 ;

=======
>>>>>>> c6af89016c56314e4324abe557b730eecb0be2c3
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;