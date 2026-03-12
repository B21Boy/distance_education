-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 29, 2018 at 02:53 AM
-- Server version: 5.6.12-log
-- PHP Version: 5.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `cde`
--
CREATE DATABASE IF NOT EXISTS `cde` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `cde`;

-- --------------------------------------------------------

--
-- Table structure for table `acadamic_calender`
--

CREATE TABLE IF NOT EXISTS `acadamic_calender` (
  `no` int(11) NOT NULL AUTO_INCREMENT,
  `semister` varchar(500) NOT NULL,
  `dates` varchar(1000) NOT NULL,
  `activities` varchar(1000) NOT NULL,
  PRIMARY KEY (`no`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19 ;

--
-- Dumping data for table `acadamic_calender`
--

INSERT IGNORE INTO `acadamic_calender` (`no`, `semister`, `dates`, `activities`) VALUES
(1, 'Semister one', 'Nehasie 22/2009 E.C-Meskerem 27/2010 E.C', '-Registration for Senior Distance Students
-Application Dates for New Distance Students'),
(2, 'Semister one', 'Meskerem 29/2010 E.C - Tikimt 04/2010 E.C', '-Late Registration with Penalty for Distance Students'),
(3, 'Semister one', 'Tikimt 05/2010 E.C', '-Entrance Exam for New Applicant Students'),
(4, 'Semister one', 'Tikimt 13-16/2010 E.C', '-Registration for New Applicant Students who Passed Entrance Examination'),
(5, 'Semister one', 'Hidar 15-17/2010 E.C', '-First Round Tutorial Class for all Distance Students'),
(6, 'Semister one', 'Tahissas 13-15/2010 E.C', '-Second Round Tutorial Class for all Distance Students
-Last Date for Make-up and Re sit Application'),
(7, 'Semister one', 'Tirr 23-27/2010 E.C', '-Exam Program for all Distance Students
-Last Date for Submission of Seminar, Project and Senior Essay'),
(8, 'Semister one', 'Yekatit 17/2010 E.C', '-Last Date of Submitting First Semester Grades on SIMS'),
(9, 'Semister Two', 'Yekatit 15 - 30/2010 E.C', '-Registration for Senior Distance Students
-2ND Round Makeup Registration'),
(10, 'Semister Two', 'Megabit 01 - 04/2010 E.C', '-Late Registration with Penalty for Distance Students'),
(11, 'Semister Two', 'Megabit 10-14/2010 E.C', '-Registration slip submission period (Including makeup registration) to the Registrar'),
(12, 'Semister Two', 'Megabit 21 - 23/2010 E.C', '-First Round Tutorial Class for all Distance Students'),
(13, 'Semister Two', 'Megabit 24 & 25/2010 E.C', '-Make up examination Period for all distance students'),
(14, 'Semister Two', 'Miazia 19-21/2010 E.C', '-Second Round Tutorial Class for all Distance Students'),
(15, 'Semister Two', 'Sene 30-Hamlie 04/2010 E.C', '-Exam Program for all Distance Students
-Last Date for Submission of Seminar, Project and Senior Essay'),
(16, 'Semister Two', 'Hamlie 30/2010 E.C', '-Last Date of Submitting second Semester Grades on SIMS');

-- --------------------------------------------------------

--
-- Table structure for table `account`
--

CREATE TABLE IF NOT EXISTS `account` (
  `UID` varchar(20) NOT NULL,
  `UserName` varchar(50) DEFAULT NULL,
  `Password` varchar(2000) DEFAULT NULL,
  `Role` varchar(20) DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`UID`),
  UNIQUE KEY `UID` (`UID`),
  FULLTEXT KEY `UserName` (`UserName`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `account`
--

INSERT IGNORE INTO `account` (`UID`, `UserName`, `Password`, `Role`, `status`) VALUES
('admn001', 'admin', 'r40tXLqSv9m/peVnAhDM+o7JSqE0qbz7S04PNk3qTi4=', 'administrator', 'yes'),
('CDEO', 'cde', 'r40tXLqSv9m/peVnAhDM+o7JSqE0qbz7S04PNk3qTi4=', 'cdeofficer', 'yes'),
('CDFB', 'cdfb', 'r40tXLqSv9m/peVnAhDM+o7JSqE0qbz7S04PNk3qTi4=', 'collage_dean', 'yes'),
('DHA', 'dha', 'r40tXLqSv9m/peVnAhDM+o7JSqE0qbz7S04PNk3qTi4=', 'department_head', 'yes'),
('DHL', 'dhl', 'r40tXLqSv9m/peVnAhDM+o7JSqE0qbz7S04PNk3qTi4=', 'department_head', 'yes'),
('FIN', 'fin', 'r40tXLqSv9m/peVnAhDM+o7JSqE0qbz7S04PNk3qTi4=', 'financestaff', 'yes'),
('INSTA', 'insta', 'r40tXLqSv9m/peVnAhDM+o7JSqE0qbz7S04PNk3qTi4=', 'instructor', 'yes'),
('INSTL', 'instl', 'r40tXLqSv9m/peVnAhDM+o7JSqE0qbz7S04PNk3qTi4=', 'instructor', 'yes'),
('R1', 'reg', 'r40tXLqSv9m/peVnAhDM+o7JSqE0qbz7S04PNk3qTi4=', 'registrar', 'yes'),
('VIC', 'vic', 'r40tXLqSv9m/peVnAhDM+o7JSqE0qbz7S04PNk3qTi4=', 'acadamic_vice_presid', 'yes');


-- --------------------------------------------------------

--
-- Table structure for table `assignment`
--

CREATE TABLE IF NOT EXISTS `assignment` (
  `no` int(11) NOT NULL AUTO_INCREMENT,
  `U_ID` varchar(20) NOT NULL,
  `asno` varchar(50) NOT NULL,
  `assignment_value` varchar(20) NOT NULL,
  `ccode` varchar(50) NOT NULL,
  `cname` varchar(50) NOT NULL,
  `department` varchar(100) NOT NULL,
  `Student_class_year` varchar(50) NOT NULL,
  `semister` varchar(50) NOT NULL,
  `Submission_date` date NOT NULL,
  `fileName` varchar(5000) NOT NULL,
  `tmpName` varchar(5000) NOT NULL,
  `fileSize` varchar(5000) NOT NULL,
  `fileType` varchar(5000) NOT NULL,
  `status` varchar(20) NOT NULL,
  `unread` varchar(10) NOT NULL,
  PRIMARY KEY (`no`),
  KEY `U_ID` (`U_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=27;


inancestafpage
INSERT IGNORE INTO `assignment` 
(`no`, `U_ID`, `asno`, `assignment_value`, `ccode`, `cname`, `department`, `Student_class_year`, `semister`, `Submission_date`, `fileName`, `tmpName`, `fileSize`, `fileType`, `status`, `unread`) 
VALUES
(26, 'INSTA', '1', '20', 'a11', 'php', 'Accounting', '1st', 'I', '2018-05-31', 'Assignment one.docx', 'C:wamp\tmpphp2BE6.tmp', '25133', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'inst', 'no');

-- --------------------------------------------------------

--
-- Table structure for table `assign_instructor`
--

CREATE TABLE IF NOT EXISTS `assign_instructor` (
  `no` int(11) NOT NULL AUTO_INCREMENT,
  `corse_code` varchar(50) NOT NULL,
  `cname` varchar(100) NOT NULL,
  `chour` int(11) NOT NULL,
  `uid` varchar(23) NOT NULL,
  `Iname` varchar(50) NOT NULL,
  `department` varchar(100) NOT NULL,
  `section` varchar(10) NOT NULL,
  `Student_class_year` varchar(50) NOT NULL,
  `semister` varchar(50) NOT NULL,
  `ayear` int(11) NOT NULL,
  PRIMARY KEY (`no`),
  KEY `uid` (`uid`),
  KEY `uid_2` (`uid`),
  FULLTEXT KEY `corse_code` (`corse_code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=45;

--
-- Dumping data for table `assign_instructor`
--

INSERT IGNORE INTO `assign_instructor` 
(`no`, `corse_code`, `cname`, `chour`, `uid`, `Iname`, `department`, `section`, `Student_class_year`, `semister`, `ayear`) 
VALUES
(43, 'a11', 'php', 3, 'INSTA', 'abebe aschalew', 'Accounting', 'A', '1st', 'I', 2010),
(44, 'a12', 'java', 3, 'INSTA', 'abebe aschalew', 'Accounting', 'A', '1st', 'I', 2010);


-- --------------------------------------------------------

--
-- Table structure for table `attempt`
--

CREATE TABLE IF NOT EXISTS `attempt` (
  `no` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`no`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=51;

--
-- Dumping data for table `attempt`
--
INSERT IGNORE INTO `attempt` (`no`) VALUES
(49),
(50);
inancestafpage

-- --------------------------------------------------------

--
-- Table structure for table `collage`
--

CREATE TABLE IF NOT EXISTS `collage` (
  `Ccode` varchar(20) NOT NULL,
  `CName` varchar(50) DEFAULT NULL,
  `Location` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`Ccode`),
  UNIQUE KEY `CName` (`CName`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `collage`
--

INSERT IGNORE INTO `collage` (`Ccode`, `CName`, `Location`) VALUES
('fbcollage001', 'fbcollage', 'B22'),
('lawcollage001', 'lawcollage', 'B23');

-- --------------------------------------------------------

--
-- Table structure for table `course`
--
CREATE TABLE IF NOT EXISTS `course` (
  `Sender_name` varchar(20) NOT NULL,
  `course_code` varchar(50) NOT NULL,
  `cname` varchar(50) NOT NULL,
  `chour` int(11) NOT NULL,
  `s_c_year` varchar(10) NOT NULL,
  `semister` varchar(10) NOT NULL,
  `ayear` int(11) NOT NULL,
  `department` varchar(50) NOT NULL,
  `other_department_takes` varchar(50) NOT NULL,
  `FileName` varchar(500) NOT NULL,
  `status` varchar(50) NOT NULL,
  `unread` varchar(10) NOT NULL,
  PRIMARY KEY (`course_code`),
  UNIQUE KEY `cname` (`cname`),
  KEY `department` (`department`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `course`
--

INSERT IGNORE INTO `course` 
(`Sender_name`, `course_code`, `cname`, `chour`, `s_c_year`, `semister`, `ayear`, `department`, `other_department_takes`, `FileName`, `status`, `unread`) 
VALUES
('INSTA', 'a11', 'php', 3, '', '', 2010, 'Accounting', '', 'Chapter 7.docx', 'yes', ''),
('INSTA', 'a12', 'java', 3, '', '', 2010, 'Accounting', '', 'Chapter-1.pptx', 'yes', '');


-- --------------------------------------------------------

--
-- Table structure for table `course_result`
--

CREATE TABLE IF NOT EXISTS `course_result` (
  `no` int(200) NOT NULL AUTO_INCREMENT,
  `S_ID` varchar(50) NOT NULL,
  `uid` varchar(20) NOT NULL,
  `C_Code` varchar(50) NOT NULL,
  `Department` varchar(50) NOT NULL,
  `year` varchar(50) NOT NULL,
  `semister` varchar(50) NOT NULL,
  `section` varchar(50) NOT NULL,
  `Assignment` int(11) NOT NULL,
  `Final` int(11) NOT NULL,
  `Total` int(11) NOT NULL,
  `Grade` varchar(20) NOT NULL,
  `status` varchar(20) NOT NULL,
  `reject` varchar(50) NOT NULL,
  `send_to` varchar(20) NOT NULL,
  `status2` varchar(20) NOT NULL,
  PRIMARY KEY (`no`),
  KEY `C_Code` (`C_Code`),
  KEY `uid` (`uid`),
  KEY `S_ID` (`S_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=59;

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE IF NOT EXISTS `department` (
  `Dcode` varchar(20) NOT NULL DEFAULT '',
  `DName` varchar(50) NOT NULL,
  `Location` varchar(20) DEFAULT NULL,
  `Ccode` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`Dcode`),
  UNIQUE KEY `DName` (`DName`),
  KEY `Ccode` (`Ccode`),
  KEY `Ccode_2` (`Ccode`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


--
-- Dumping data for table `department`
--

INSERT IGNORE INTO `department` (`Dcode`, `DName`, `Location`, `Ccode`) VALUES
('accounting001', 'Accounting', 'B23', 'fbcollage001'),
('economics001', 'Economics', 'B23', 'fbcollage001'),
('law001', 'law', 'B22', 'lawcollage001'),
('mngt001', 'Managament', 'B22', 'fbcollage001');


-- --------------------------------------------------------

--
-- Table structure for table `entrance_exam`
--

CREATE TABLE IF NOT EXISTS `entrance_exam` (
  `no` int(11) NOT NULL AUTO_INCREMENT,
  `S_ID` varchar(50) NOT NULL,
  `result` int(11) NOT NULL,
  `year` varchar(20) NOT NULL,
  `status` varchar(50) NOT NULL,
  `account` varchar(50) NOT NULL,
  PRIMARY KEY (`no`),
  KEY `S_ID` (`S_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=63;

-- Table structure for table `feed_back`
--

CREATE TABLE IF NOT EXISTS `feed_back` (
  `fbid` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) DEFAULT NULL,
  `email` varchar(20) NOT NULL,
  `role` varchar(30) DEFAULT NULL,
  `Comment` varchar(10000) NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`fbid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=13;

--
-- Dumping data for table `feed_back`
--

INSERT IGNORE INTO `feed_back` (`fbid`, `name`, `email`, `role`, `Comment`, `date`) VALUES
(12, 'ujy', 'yyt@tty.hh', NULL, 'rtrtrtrte', '2018-05-22 21:01:41');

-- --------------------------------------------------------

--
-- Table structure for table `grade`
--

CREATE TABLE IF NOT EXISTS `grade` (
  `no` int(11) NOT NULL AUTO_INCREMENT,
  `sid` varchar(20) NOT NULL,
  `department` varchar(20) NOT NULL,
  `year` varchar(20) NOT NULL,
  `semister` varchar(20) NOT NULL,
  `section` varchar(20) NOT NULL,
  `stcrh` double NOT NULL,e.php
  `stgpoint` double NOT NULL,
  `sgpa` double NOT NULL,
  `ptcrh` double NOT NULL,
  `ptgpoint` int(11) NOT NULL,
  `pgpa` double NOT NULL,
  `ncgpa` double NOT NULL,
  `status` varchar(30) NOT NULL,
  `checking` varchar(20) NOT NULL,
  PRIMARY KEY (`no`),
  KEY `sid` (`sid`),
  KEY `sid_2` (`sid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=7;

-- --------------------------------------------------------

--
-- Table structure for table `logfile`
--

CREATE TABLE IF NOT EXISTS `logfile` (
  `logid` int(100) NOT NULL AUTO_INCREMENT,
  `username` varchar(40) NOT NULL,
  `role` varchar(40) NOT NULL,
  `status` varchar(40) NOT NULL,
  `start_time` varchar(40) NOT NULL,
  `activity_type` varchar(100) NOT NULL,
  `activity_performed` varchar(10000) NOT NULL,
  `date` date NOT NULL,
  `ip_address` varchar(100) NOT NULL,
  `end` varchar(40) NOT NULL,
  PRIMARY KEY (`logid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=218;


-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE IF NOT EXISTS `message` (
  `M_ID` int(20) NOT NULL AUTO_INCREMENT,
  `M_sender` varchar(30) NOT NULL,
  `M_reciever` varchar(40) NOT NULL,
  `message` varchar(200) NOT NULL,
  `date_sended` datetime NOT NULL,
  `status` varchar(20) NOT NULL,
  PRIMARY KEY (`M_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=59;

--
-- Dumping data for table `message`
--

INSERT IGNORE INTO `message` (`M_ID`, `M_sender`, `M_reciever`, `message`, `date_sended`, `status`) VALUES
(57, 'FIN', 'abebe    aschalew', 'Well come To finance and take payement for Preparing Module worked time', '2018-05-28 14:12:36', 'no'),
(58, 'FIN', 'INSTA', 'Well come To finance and take payement for Preparing Module worked time', '2018-05-28 14:21:44', 'no');

-- --------------------------------------------------------

--
-- Table structure for table `module_schedule`
--

CREATE TABLE IF NOT EXISTS `module_schedule` (
  `no` int(11) NOT NULL AUTO_INCREMENT,
  `information` mediumtext NOT NULL,
  `postedby` varchar(50) NOT NULL,
  PRIMARY KEY (`no`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=5;

--
-- Dumping data for table `module_schedule`
--

INSERT IGNORE INTO `module_schedule` (`no`, `information`, `postedby`) VALUES
(4, 'Bahir Dar University
Continuing & Distance Education Coordinating Directorate
Employment contract For Module Preparation
(Be filled in four copies)
Department of the Instructors (s): _______________________________
Course Title which the module is prepared for: ___________________
Course code: __________________________________
Credit Hour of the Course: ______________________________________
Here by the contract agreement is made between the Office of the Continuing & Distance Education coordinating directorate hereafter (the employer) and _________________________
Here after (the employee(s) to properly write, edit and submit course module according to the following contract agreement. 
The Employee’s Agreement 
- To prepare the course module
- To write the course module
- To edit the module
- To finally submit the module up to          /2010 E.C.
The Employer’s Agreement
- The office makes the payments for Module Preparation __________________________ (________________________________________________________________________) birr; Module editing ___________ (___________________________________________________) birr and Writing/typing ____________ (____________________________________________________) birr, and of total _______ (____________________________________________________) birr in one installment upon the successful completion of your task, as per the standard of module set by the university, per page with the rate of 120.00 (seventy) birr for module preparation; 15.00 (seven) birr for module editing and 5.00 (three) birr for typing, when approval and acceptance of your work is assured by the concerned College dean. The total page number of the module is _______ pages. 
(see below the pages limit)
It should be noted that the office shall not make any payment for reasons the module preparation is interrupted or is not completed, and the University takes actions on the employee as per its rules and regulations.
Employee                                                                Department Head 
Signature: _______________________                        _________________________
Name: __________________________                         _________________________
Date: ___________________________                         _________________________
College Dean                                                         CDEP Director   
Signature: ______________________                        _________________________
Name: __________________________                        _________________________
Date: ___________________________                        ________________________ 
Note:- Number of pages
For 1 credit hour minimum 50 and maximum 60 
For 2 credit hour minimum 80 and maximum 90 
For 3 credit hour minimum 110 and maximum 120 
For 4 credit hour minimum 140 and maximum 150', '&#4720;&#4776;&#4723;&#4723;&#4845;&#4755; &#4653;');

--
-- Table structure for table `payment_table`
--

CREATE TABLE IF NOT EXISTS `payment_table` (
  `no` int(11) NOT NULL AUTO_INCREMENT,
  `UID` varchar(20) NOT NULL,
  `c_code` varchar(20) NOT NULL,
  `Instructors_Name` varchar(50) NOT NULL,
  `Course_Code` varchar(50) NOT NULL,
  `No_of_Sections` int(11) NOT NULL,
  `No_of_Assignment_Marked` int(11) NOT NULL,
  `No_of_Exams_Marked` int(11) NOT NULL,
  `Rank` varchar(50) NOT NULL,
  `CrHr` int(11) NOT NULL,
  `Department` varchar(50) NOT NULL,
  `Year` varchar(50) NOT NULL,
  `Section` varchar(50) NOT NULL,
  `No_of_hours_she_he_gave_tutorial` int(11) NOT NULL,
  `No_of_Exams_prepared` int(11) NOT NULL,
  `No_of_pages_prepared` int(50) NOT NULL,
  `Payment_per` int(11) NOT NULL,
  `Payment_Per_Assignment` int(11) NOT NULL,
  `Total_Payment_for_Exams` int(11) NOT NULL,
  `Total_Payment_for_Assignments` int(11) NOT NULL,
  `Total_Payment` int(11) NOT NULL,
  `unread` varchar(20) NOT NULL,
  `status` varchar(20) NOT NULL,
  `payment` varchar(20) NOT NULL,
  `type` varchar(20) NOT NULL,
  PRIMARY KEY (`no`),
  KEY `UID` (`UID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=48;

--
-- Dumping data for table `payment_table`
--

INSERT INTO `payment_table` (`no`, `UID`, `c_code`, `Instructors_Name`, `Course_Code`, `No_of_Sections`, `No_of_Assignment_Marked`, `No_of_Exams_Marked`, `Rank`, `CrHr`, `Department`, `Year`, `Section`, `No_of_hours_she_he_gave_tutorial`, `No_of_Exams_prepared`, `No_of_pages_prepared`, `Payment_per`, `Payment_Per_Assignment`, `Total_Payment_for_Exams`, `Total_Payment_for_Assignments`, `Total_Payment`, `unread`, `status`, `payment`, `type`) VALUES
(40, 'CDEO', '', 'abebe    aschalew', 'A111    php', 0, 0, 0, '', 3, '', '', '', 0, 0, 50, 5, 0, 0, 0, 250, 'yes', 'yes', 'check', 'module'),
(41, 'DHA', 'fbcollage001', 'dffd', 'php', 0, 0, 30, 'dgree', 3, 'Accounting', 'I', '', 0, 0, 0, 23, 0, 0, 0, 690, 'yes', 'yes', 'check', 'mexam'),
(42, 'DHA', 'fbcollage001', 'dffd', 'php', 0, 30, 0, 'dgree', 3, 'Accounting', 'I', '', 0, 0, 0, 0, 0, 0, 0, 0, 'yes', 'no', '', 'massignment'),
(43, 'DHA', 'fbcollage001', 'INSTA', 'php', 0, 0, 0, 'degree', 3, 'Accounting', 'I', 'A', 20, 0, 0, 0, 0, 0, 0, 0, 'yes', 'no', '', 'tutorial'),
(44, 'DHA', 'fbcollage001', 'INSTA', 'php', 0, 0, 50, 'degree', 3, 'Accounting', 'I', '', 0, 0, 0, 0, 0, 0, 0, 0, 'no', '', '', 'mexam'),
(45, 'DHA', 'fbcollage001', 'INSTA', 'java', 0, 0, 0, 'degree', 3, '', '', '', 0, 100, 0, 10, 0, 0, 0, 1000, 'yes', 'yes', 'check', 'pexam'),
(46, 'CDEO', '', 'abebe    aschalew', 'a12    java', 0, 0, 0, '', 3, '', '', '', 0, 0, 100, 2, 0, 0, 0, 200, 'yes', 'yes', 'checked', 'module'),
(47, 'CDEO', '', 'INSTA', 'a11    php', 0, 0, 0, '', 3, '', '', '', 0, 0, 100, 4, 0, 0, 0, 400, 'yes', 'yes', 'checked', 'module');

-- --------------------------------------------------------

--
-- Table structure for table `postss`
--

CREATE TABLE IF NOT EXISTS `postss` (
  `no` int(11) NOT NULL AUTO_INCREMENT,
  `Title` varchar(100) NOT NULL,
  `types` varchar(5000) NOT NULL,
  `dates` date NOT NULL,
  `Ex_date` date NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `info` mediumtext NOT NULL,
  `posted_by` varchar(500) NOT NULL,
  `status` varchar(20) NOT NULL,
  PRIMARY KEY (`no`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `postss`
--

INSERT INTO `postss` (`no`, `Title`, `types`, `dates`, `Ex_date`, `start_date`, `end_date`, `info`, `posted_by`, `status`) VALUES
(1, '&#4635;&#4661;&#4723;&#4808;&#4674;&#4843;', '&#4616;&#4653;&#4672;&#4725; &#4725;&#4637;&#4613;&#4653;&#4725; &#4632;&#4653;&#4611;-&#4877;&#4709;&#4653; &#4720;&#4635;&#4650;&#4814;&#4733; &#4704;&#4633;&#4617;', '2018-03-07', '2018-05-30', '0000-00-00', '0000-00-00', '&#4704;&#4848;&#4709;&#4648; &#4635;&#4653;&#4678;&#4661; &#4841;&#4754;&#4712;&#4653;&#4661;&#4722; &#4704;&#4653;&#4672;&#4725; &#4725;&#4637;&#4613;&#4653;&#4725; &#4632;&#4653;&#4611; &#4877;&#4709;&#4653; &#4704;&#4632;&#4635;&#4653; &#4619;&#4845; &#4843;&#4621;&#4733;&#4609; &#4720;&#4635;&#4650;&#4814;&#4733; &#4840;&#4634;&#4776;&#4720;&#4617;&#4725;&#4757; &#4873;&#4851;&#4846;&#4733; &#4725;&#4777;&#4648;&#4725; &#4656;&#4901;&#4723;&#4733;&#4609; &#4720;&#4877;&#4707;&#4651;&#4810; &#4773;&#4757;&#4853;&#4723;&#4848;&#4653;&#4873; &#4773;&#4755;&#4659;&#4661;&#4707;&#4616;&#4757;&#4961;&#4961; -&#4840;&#4782;&#4653;&#4661; &#4768;&#4659;&#4845;&#4632;&#4757;&#4726;&#4733;&#4757; &#4704;&#4840;&#4782;&#4653;&#4662;&#4733; &#4722;&#4726;&#4650;&#4843;&#4621; &#4616;&#4634;&#4656;&#4903;&#4733;&#4609; &#4632;&#4637;&#4613;&#4651;&#4757; &#4635;&#4661;&#4648;&#4776;&#4709; -&#4629;&#4757;&#4931; &#4673;&#4901;&#4653; 042 &#4706;&#4654; &#4673;&#4901;&#4653; 02 &#4808;&#4845;&#4637; 04 &#4704;&#4632;&#4612;&#4853; &#4776;&#4652;&#4869;&#4661;&#4725;&#4651;&#4653; &#4632;&#4723;&#4808;&#4674;&#4843; &#4632;&#4809;&#4656;&#4853; -&#4635;&#4896;&#4675;&#4616;&#4843; &#4936;&#4720;&#4755; &#4840;&#4634;&#4656;&#4896;&#4809; &#4776;&#4840;&#4779;&#4722;&#4725; 16-18/2010 &#4819;.&#4637; &#4661;&#4616;&#4614;&#4752; &#4840;&#4779;&#4722;&#4725; 16/2010 &#4819;.&#4637; &#4776;&#4896;&#4811;&#4721;2:00 &#4704;&#4840;&#4637;&#4725;&#4632;&#4848;&#4705;&#4707;&#4728;&#4809; &#4840;&#4632;&#4936;&#4720;&#4763; &#4781;&#4941;&#4622;&#4733; &#4704;&#4632;&#4872;&#4760;&#4725; &#4632;&#4936;&#4720;&#4757; &#4635;&#4659;&#4656;&#4709;&#4843;&#4961; &#4632;&#4723;&#4814;&#4674;&#4843; &#4843;&#4621;&#4843;&#4824; &#4635;&#4752;&#4763;&#4809;&#4637; &#4720;&#4635;&#4650; &#4635;&#4896;&#4675;&#4616;&#4843; &#4936;&#4720;&#4755; &#4632;&#4936;&#4720;&#4757; &#4768;&#4845;&#4733;&#4621;&#4637;', '&#4720;&#4776;&#4723;&#4723;&#4845;&#4755; &#4653;&#4672;&#4725; &#4725;&#4637;&#4613;&#4653;&#4725; &#4635;&#4661;&#4720;&#4707;&#4704;&#4650;&#4843; &#4851;&#4845;&#4652;&#4781;&#4726;&#4652;&#4725; &#4848;&#4709;&#4648; &#4635;&#4653;&#4678;&#4661; &#4841;&#4754;&#4712;&#4653;&#4661;&#4722;', ''),
(2, '&#4635;&#4661;&#4723;&#4808;&#4674;&#4843;', '&#4616;&#4653;&#4672;&#4725; &#4725;&#4637;&#4613;&#4653;&#4725; &#4632;&#4653;&#4611;-&#4877;&#4709;&#4653; &#4720;&#4635;&#4650;&#4814;&#4733; &#4704;&#4633;&#4617;', '2018-03-07', '2018-05-31', '0000-00-00', '0000-00-00', '&#4704;2010 &#4819;/&#4637; &#4704;&#4875; &#4616;&#4634;&#4656;&#4897; &#4782;&#4653;&#4662;&#4733; (&#4850;&#4661;&#4723;&#4757;&#4661; &#4782;&#4653;&#4662;&#4733;) &#4840;&#4609;&#4616;&#4720;&#4763; &#4825;&#4653; &#4637;&#4829;&#4872;&#4707; &#4776;&#4613;&#4851;&#4653; 24 &#4773;&#4661;&#4776; &#4723;&#4613;&#4659;&#4661; 27 &#4672;&#4757; 2010 &#4819;/&#4637; &#4707;&#4617;&#4725; &#4840;&#4661;&#4651; &#4672;&#4755;&#4725; &#4845;&#4779;&#4612;&#4851;&#4621;&#4961;&#4961; &#4661;&#4616;&#4614;&#4752;&#4637; &#4704;&#4632;&#4864;&#4632;&#4650;&#4843;&#4813; &#4825;&#4653; &#4637;&#4829;&#4872;&#4707; &#4843;&#4619;&#4779;&#4612;&#4851;&#4733;&#4609; &#4720;&#4635;&#4650;&#4814;&#4733; &#4704;&#4720;&#4896;&#4672;&#4657;&#4725; &#4672;&#4755;&#4725; &#4773;&#4757;&#4853;&#4725;&#4632;&#4824;&#4872;&#4705; &#4773;&#4843;&#4659;&#4656;&#4709;&#4757;', '&#4720;&#4776;&#4723;&#4723;&#4845;&#4755; &#4653;&#4672;&#4725; &#4725;&#4637;&#4613;&#4653;&#4725; &#4635;&#4661;&#4720;&#4707;&#4704;&#4650;&#4843; &#4851;&#4845;&#4652;&#4781;&#4726;&#4652;&#4725; &#4848;&#4709;&#4648; &#4635;&#4653;&#4678;&#4661; &#4841;&#4754;&#4712;&#4653;&#4661;&#4722;', ''),
(3, '&#4635;&#4661;&#4723;&#4808;&#4674;&#4843;', '&#4616;&#4653;&#4672;&#4725; &#4725;&#4637;&#4613;&#4653;&#4725; &#4632;&#4653;&#4611;-&#4877;&#4709;&#4653; &#4720;&#4635;&#4650;&#4814;&#4733; &#4704;&#4633;&#4617;', '2018-05-13', '2018-04-30', '2018-05-13', '2018-05-15', '\r\n\r\n&#4840; 2010 &#4819;/&#4637; &#4840;&#4725;&#4637;&#4725; &#4824;&#4632;&#4757; &#4609;&#4616;&#4720;&#4763;&#4809; &#4808;&#4656;&#4752; &#4725;&#4637;/&#4725; &#4637;&#4829;&#4872;&#4707; &#4840;&#4634;&#4779;&#4612;&#4848;&#4809; &#4704; 26/06/2010 &#4819;/&#4637; &#4773;&#4755; &#4704;27/06/2010 &#4819;/&#4637; &#4632;&#4614;&#4753;&#4757; &#4773;&#4843;&#4659;&#4808;&#4677;&#4757; &#4704;&#4720;&#4896;&#4672;&#4657;&#4725; &#4672;&#4755;&#4725; &#4773;&#4757;&#4853;&#4725;&#4632;&#4824;&#4872;&#4705; &#4704;&#4901;&#4709;&#4677; &#4773;&#4755;&#4659;&#4661;&#4707;&#4616;&#4757;&#4961;&#4961;\r\n	\r\n			\r\n	\r\n', '&#4720;&#4776;&#4723;&#4723;&#4845;&#4755; &#4653;&#4672;&#4725; &#4725;&#4637;&#4613;&#4653;&#4725; &#4635;&#4661;&#4720;&#4707;&#4704;&#4650;&#4843; &#4851;&#4845;&#4652;&#4781;&#4726;&#4652;&#4725; &#4848;&#4709;&#4648; &#4635;&#4653;&#4678;&#4661; &#4841;&#4754;&#4712;&#4653;&#4661;&#4722;', 'register'),
(4, '&#4635;&#4661;&#4723;&#4808;&#4674;&#4843;', '&#4616;&#4653;&#4672;&#4725; &#4725;&#4637;&#4613;&#4653;&#4725; &#4632;&#4653;&#4611;-&#4877;&#4709;&#4653; &#4720;&#4635;&#4650;&#4814;&#4733; &#4704;&#4633;&#4617;', '2018-05-13', '2018-04-30', '2018-05-01', '2018-05-05', '	\r\n	\r\n&#4704;&#4848;&#4709;&#4648; &#4635;&#4653;&#4678;&#4661; &#4841;&#4754;&#4712;&#4653;&#4661;&#4722; &#4704;&#4653;&#4672;&#4725; &#4725;&#4637;&#4613;&#4653;&#4725; &#4632;&#4653;&#4611; &#4877;&#4709;&#4653; &#4704;&#4632;&#4635;&#4653; &#4619;&#4845; &#4843;&#4621;&#4733;&#4609; &#4720;&#4635;&#4650;&#4814;&#4733; &#4840;&#4634;&#4776;&#4720;&#4617;&#4725;&#4757; &#4873;&#4851;&#4846;&#4733; &#4725;&#4777;&#4648;&#4725; &#4656;&#4901;&#4723;&#4733;&#4609; &#4720;&#4877;&#4707;&#4651;&#4810; &#4773;&#4757;&#4853;&#4723;&#4848;&#4653;&#4873; &#4773;&#4755;&#4659;&#4661;&#4707;&#4616;&#4757;&#4961;&#4961; -&#4840;&#4782;&#4653;&#4661; &#4768;&#4659;&#4845;&#4632;&#4757;&#4726;&#4733;&#4757; &#4704;&#4840;&#4782;&#4653;&#4662;&#4733; &#4722;&#4726;&#4650;&#4843;&#4621; &#4616;&#4634;&#4656;&#4903;&#4733;&#4609; &#4632;&#4637;&#4613;&#4651;&#4757; &#4635;&#4661;&#4648;&#4776;&#4709; -&#4629;&#4757;&#4931; &#4673;&#4901;&#4653; 042 &#4706;&#4654; &#4673;&#4901;&#4653; 02 &#4808;&#4845;&#4637; 04 &#4704;&#4632;&#4612;&#4853; &#4776;&#4652;&#4869;&#4661;&#4725;&#4651;&#4653; &#4632;&#4723;&#4808;&#4674;&#4843; &#4632;&#4809;&#4656;&#4853; -&#4635;&#4896;&#4675;&#4616;&#4843; &#4936;&#4720;&#4755; &#4840;&#4634;&#4656;&#4896;&#4809; &#4776;&#4840;&#4779;&#4722;&#4725; 16-18/2010 &#4819;.&#4637; &#4661;&#4616;&#4614;&#4752; &#4840;&#4779;&#4722;&#4725; 16/2010 &#4819;.&#4637; &#4776;&#4896;&#4811;&#4721;2:00 &#4704;&#4840;&#4637;&#4725;&#4632;&#4848;&#4705;&#4707;&#4728;&#4809; &#4840;&#4632;&#4936;&#4720;&#4763; &#4781;&#4941;&#4622;&#4733; &#4704;&#4632;&#4872;&#4760;&#4725; &#4632;&#4936;&#4720;&#4757; &#4635;&#4659;&#4656;&#4709;&#4843;&#4961; &#4632;&#4723;&#4814;&#4674;&#4843; &#4843;&#4621;&#4843;&#4824; &#4635;&#4752;&#4763;&#4809;&#4637; &#4720;&#4635;&#4650; &#4635;&#4896;&#4675;&#4616;&#4843; &#4936;&#4720;&#4755; &#4632;&#4936;&#4720;&#4757; &#4768;&#4845;&#4733;&#4621;&#4637;	\r\n		\r\n	\r\n', '&#4720;&#4776;&#4723;&#4723;&#4845;&#4755; &#4653;&#4672;&#4725; &#4725;&#4637;&#4613;&#4653;&#4725; &#4635;&#4661;&#4720;&#4707;&#4704;&#4650;&#4843; &#4851;&#4845;&#4652;&#4781;&#4726;&#4652;&#4725; &#4848;&#4709;&#4648; &#4635;&#4653;&#4678;&#4661; &#4841;&#4754;&#4712;&#4653;&#4661;&#4722;', 'apply'),
(12, '&#4635;&#4661;&#4723;&#4808;&#4674;&#4843;', '&#4616;&#4653;&#4672;&#4725; &#4725;&#4637;&#4613;&#4653;&#4725; &#4632;&#4653;&#4611;-&#4877;&#4709;&#4653; &#4720;&#4635;&#4650;&#4814;&#4733; &#4704;&#4633;&#4617;', '2018-05-29', '2018-05-27', '0000-00-00', '0000-00-00', '	\r\n\r\nhhghgfhghhggghhg&#4704;&#4848;&#4709;&#4648; &#4635;&#4653;&#4678;&#4661; &#4841;&#4754;&#4712;&#4653;&#4661;&#4722; &#4704;&#4653;&#4672;&#4725; &#4725;&#4637;&#4613;&#4653;&#4725; &#4632;&#4653;&#4611; &#4877;&#4709;&#4653; &#4704;&#4632;&#4635;&#4653; &#4619;&#4845; &#4843;&#4621;&#4733;&#4609; &#4720;&#4635;&#4650;&#4814;&#4733; &#4840;&#4634;&#4776;&#4720;&#4617;&#4725;&#4757; &#4873;&#4851;&#4846;&#4733; &#4725;&#4777;&#4648;&#4725; &#4656;&#4901;&#4723;&#4733;&#4609; &#4720;&#4877;&#4707;&#4651;&#4810; &#4773;&#4757;&#4853;&#4723;&#4848;&#4653;&#4873; &#4773;&#4755;&#4659;&#4661;&#4707;&#4616;&#4757;&#4961;&#4961; -&#4840;&#4782;&#4653;&#4661; &#4768;&#4659;&#4845;&#4632;&#4757;&#4726;&#4733;&#4757; &#4704;&#4840;&#4782;&#4653;&#4662;&#4733; &#4722;&#4726;&#4650;&#4843;&#4621; &#4616;&#4634;&#4656;&#4903;&#4733;&#4609; &#4632;&#4637;&#4613;&#4651;&#4757; &#4635;&#4661;&#4648;&#4776;&#4709; -&#4629;&#4757;&#4931; &#4673;&#4901;&#4653; 042 &#4706;&#4654; &#4673;&#4901;&#4653; 02 &#4808;&#4845;&#4637; 04 &#4704;&#4632;&#4612;&#4853; &#4776;&#4652;&#4869;&#4661;&#4725;&#4651;&#4653; &#4632;&#4723;&#4808;&#4674;&#4843; &#4632;&#4809;&#4656;&#4853; -&#4635;&#4896;&#4675;&#4616;&#4843; &#4936;&#4720;&#4755; &#4840;&#4634;&#4656;&#4896;&#4809; &#4776;&#4840;&#4779;&#4722;&#4725; 16-18/2010 &#4819;.&#4637; &#4661;&#4616;&#4614;&#4752; &#4840;&#4779;&#4722;&#4725; 16/2010 &#4819;.&#4637; &#4776;&#4896;&#4811;&#4721;2:00 &#4704;&#4840;&#4637;&#4725;&#4632;&#4848;&#4705;&#4707;&#4728;&#4809; &#4840;&#4632;&#4936;&#4720;&#4763; &#4781;&#4941;&#4622;&#4733; &#4704;&#4632;&#4872;&#4760;&#4725; &#4632;&#4936;&#4720;&#4757; &#4635;&#4659;&#4656;&#4709;&#4843;&#4961; &#4632;&#4723;&#4814;&#4674;&#4843; &#4843;&#4621;&#4843;&#4824; &#4635;&#4752;&#4763;&#4809;&#4637; &#4720;&#4635;&#4650; &#4635;&#4896;&#4675;&#4616;&#4843; &#4936;&#4720;&#4755; &#4632;&#4936;&#4720;&#4757; &#4768;&#4845;&#4733;&#4621;&#4637;&#4961;&#4961;\r\n	\r\n	\r\n', '&#4720;&#4776;&#4723;&#4723;&#4845;&#4755; &#4653;&#4672;&#4725; &#4725;&#4637;&#4613;&#4653;&#4725; &#4635;&#4661;&#4720;&#4707;&#4704;&#4650;&#4843; &#4851;&#4845;&#4652;&#4781;&#4726;&#4652;&#4725; &#4848;&#4709;&#4648; &#4635;&#4653;&#4678;&#4661; &#4841;&#4754;&#4712;&#4653;&#4661;&#4722;', ''),
(13, '&#4635;&#4661;&#4723;&#4808;&#4674;&#4843;', '&#4616;&#4653;&#4672;&#4725; &#4725;&#4637;&#4613;&#4653;&#4725; &#4632;&#4653;&#4611;-&#4877;&#4709;&#4653; &#4720;&#4635;&#4650;&#4814;&#4733; &#4704;&#4633;&#4617;', '2018-05-29', '2018-05-31', '0000-00-00', '0000-00-00', '	\r\n\r\nhhghgfhghhggghhg&#4704;&#4848;&#4709;&#4648; &#4635;&#4653;&#4678;&#4661; &#4841;&#4754;&#4712;&#4653;&#4661;&#4722; &#4704;&#4653;&#4672;&#4725; &#4725;&#4637;&#4613;&#4653;&#4725; &#4632;&#4653;&#4611; &#4877;&#4709;&#4653; &#4704;&#4632;&#4635;&#4653; &#4619;&#4845; &#4843;&#4621;&#4733;&#4609; &#4720;&#4635;&#4650;&#4814;&#4733; &#4840;&#4634;&#4776;&#4720;&#4617;&#4725;&#4757; &#4873;&#4851;&#4846;&#4733; &#4725;&#4777;&#4648;&#4725; &#4656;&#4901;&#4723;&#4733;&#4609; &#4720;&#4877;&#4707;&#4651;&#4810; &#4773;&#4757;&#4853;&#4723;&#4848;&#4653;&#4873; &#4773;&#4755;&#4659;&#4661;&#4707;&#4616;&#4757;&#4961;&#4961; -&#4840;&#4782;&#4653;&#4661; &#4768;&#4659;&#4845;&#4632;&#4757;&#4726;&#4733;&#4757; &#4704;&#4840;&#4782;&#4653;&#4662;&#4733; &#4722;&#4726;&#4650;&#4843;&#4621; &#4616;&#4634;&#4656;&#4903;&#4733;&#4609; &#4632;&#4637;&#4613;&#4651;&#4757; &#4635;&#4661;&#4648;&#4776;&#4709; -&#4629;&#4757;&#4931; &#4673;&#4901;&#4653; 042 &#4706;&#4654; &#4673;&#4901;&#4653; 02 &#4808;&#4845;&#4637; 04 &#4704;&#4632;&#4612;&#4853; &#4776;&#4652;&#4869;&#4661;&#4725;&#4651;&#4653; &#4632;&#4723;&#4808;&#4674;&#4843; &#4632;&#4809;&#4656;&#4853; -&#4635;&#4896;&#4675;&#4616;&#4843; &#4936;&#4720;&#4755; &#4840;&#4634;&#4656;&#4896;&#4809; &#4776;&#4840;&#4779;&#4722;&#4725; 16-18/2010 &#4819;.&#4637; &#4661;&#4616;&#4614;&#4752; &#4840;&#4779;&#4722;&#4725; 16/2010 &#4819;.&#4637; &#4776;&#4896;&#4811;&#4721;2:00 &#4704;&#4840;&#4637;&#4725;&#4632;&#4848;&#4705;&#4707;&#4728;&#4809; &#4840;&#4632;&#4936;&#4720;&#4763; &#4781;&#4941;&#4622;&#4733; &#4704;&#4632;&#4872;&#4760;&#4725; &#4632;&#4936;&#4720;&#4757; &#4635;&#4659;&#4656;&#4709;&#4843;&#4961; &#4632;&#4723;&#4814;&#4674;&#4843; &#4843;&#4621;&#4843;&#4824; &#4635;&#4752;&#4763;&#4809;&#4637; &#4720;&#4635;&#4650; &#4635;&#4896;&#4675;&#4616;&#4843; &#4936;&#4720;&#4755; &#4632;&#4936;&#4720;&#4757; &#4768;&#4845;&#4733;&#4621;&#4637;&#4961;&#4961;\r\n	\r\n	\r\n', '&#4720;&#4776;&#4723;&#4723;&#4845;&#4755; &#4653;&#4672;&#4725; &#4725;&#4637;&#4613;&#4653;&#4725; &#4635;&#4661;&#4720;&#4707;&#4704;&#4650;&#4843; &#4851;&#4845;&#4652;&#4781;&#4726;&#4652;&#4725; &#4848;&#4709;&#4648; &#4635;&#4653;&#4678;&#4661; &#4841;&#4754;&#4712;&#4653;&#4661;&#4722;', '');

-- --------------------------------------------------------

--
-- Table structure for table `rejected_stud`
--

CREATE TABLE IF NOT EXISTS `rejected_stud` (
  `no` int(11) NOT NULL AUTO_INCREMENT,
  `S_ID` varchar(50) NOT NULL,
  `FName` varchar(50) NOT NULL DEFAULT 'no',
  `mname` varchar(20) NOT NULL,
  `LName` varchar(50) NOT NULL,
  `Sex` varchar(20) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Phone_No` varchar(20) NOT NULL,inancestafpage
  `College` varchar(100) NOT NULL,
  `Department` varchar(100) NOT NULL,
  `year` varchar(11) NOT NULL,
  `section` varchar(20) NOT NULL,
  `semister` varchar(20) NOT NULL,
  `program` varchar(100) NOT NULL,
  `Location` varchar(50) NOT NULL,
  `Education_level` varchar(50) NOT NULL,
  `Date` DATE NOT NULL,
  `unread` varchar(20) NOT NULL DEFAULT 'yes',
  `status` varchar(20) NOT NULL DEFAULT 'rejected',
  PRIMARY KEY (`no`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=5;

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE IF NOT EXISTS `student` (
  `S_ID` varchar(50) NOT NULL,
  `FName` varchar(50) NOT NULL DEFAULT 'no',
  `mname` varchar(20) NOT NULL,
  `LName` varchar(50) NOT NULL,
  `Sex` varchar(20) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Phone_No` varchar(20) NOT NULL,
  `College` varchar(100) NOT NULL,
  `Department` varchar(100) NOT NULL,
  `year` varchar(11) NOT NULL,
  `section` varchar(20) NOT NULL,
  `semister` varchar(20) NOT NULL,
  `program` varchar(100) NOT NULL,
  `Location` varchar(50) NOT NULL,
  `Education_level` varchar(50) NOT NULL,
  `Date` DATE NOT NULL,
  `unread` varchar(20) NOT NULL DEFAULT 'yes',
  `status` varchar(20) NOT NULL DEFAULT 'active',
  PRIMARY KEY (`S_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `UID` varchar(20) NOT NULL,
  `fname` varchar(30) DEFAULT NULL,
  `lname` varchar(30) DEFAULT NULL,
  `sex` varchar(20) DEFAULT NULL,
  `Email` varchar(50) DEFAULT NULL,
  `phone_No` varchar(20) DEFAULT NULL,
  `location` varchar(20) DEFAULT NULL,
  `photo` varchar(3000) NOT NULL,
  `d_code` varchar(20) DEFAULT NULL,
  `c_code` varchar(20) NOT NULL,
  PRIMARY KEY (`UID`),
  KEY `d_code` (`d_code`),
  KEY `c_code` (`c_code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`UID`, `fname`, `lname`, `sex`, `Email`, `phone_No`, `location`, `photo`, `d_code`, `c_code`) VALUES
('admn001', 'abebe', 'alemu', 'male', 'abebe@gmail.com', '0912345678', 'B29', 'userphoto/a.jpg', NULL, NULL),
('CDEO', 'worku', 'alemu', 'male', 'cde@gmail.com', '0912345678', 'B709', 'userphoto/w.jpg', NULL, NULL),
('CDFB', 'abebe', 'alemu', 'male', 'coll@gmail.com', '0912345678', 'B709', 'userphoto/a.jpg', NULL, 'fbcollage001'),
('DHA', 'worku', 'aschalew', 'male', 'w@gmail.com', '0912345678', 'B709', 'userphoto/w.jpg', 'accounting001', 'fbcollage001'),
('DHL', 'worku', 'alemu', 'male', 'gh@gmail.com', '0912345678', 'B709', 'userphoto/ab.jpg', 'law001', 'lawcollage001'),
('FIN', 'worku', 'alemu', 'male', 'fin@gmail.com', '0912345678', 'B709', 'userphoto/w.jpg', NULL, NULL),
('INSTA', 'abebe', 'aschalew', 'male', 'abb@gmail.com', '0912345678', 'B709', 'userphoto/ab.jpg', 'accounting001', 'fbcollage001'),
('INSTL', 'abebe', 'alemu', 'male', 'inst@gmail.com', '0912345678', 'B709', 'userphoto/a.jpg', 'law001', 'lawcollage001'),
('R1', 'abebe', 'alemu', 'male', 'ab@gmail.com', '0912345678', 'B709', 'userphoto/a.jpg', NULL, NULL),
('VIC', 'worku', 'aschalew', 'male', 'vice@gmail.com', '0912345678', 'B709', 'userphoto/ab.jpg', NULL, NULL);


--
-- Constraints for dumped tables
--

--
-- Constraints for table `account`
--
-- account table: link UID to user
ALTER TABLE `account`
  ADD CONSTRAINT `account_ibfk_1` 
  FOREIGN KEY (`UID`) REFERENCES `user` (`UID`) 
  ON DELETE CASCADE 
  ON UPDATE CASCADE;

-- assignment table: link U_ID to user
ALTER TABLE `assignment`
  ADD CONSTRAINT `assignment_user_fk` 
  FOREIGN KEY (`U_ID`) REFERENCES `user` (`UID`) 
  ON DELETE CASCADE 
  ON UPDATE CASCADE;

-- assign_instructor table: link uid to user
ALTER TABLE `assign_instructor`
  ADD CONSTRAINT `assign_instructor_user_fk` 
  FOREIGN KEY (`uid`) REFERENCES `user` (`UID`) 
  ON DELETE CASCADE 
  ON UPDATE CASCADE;

-- course_result table: link S_ID to student, uid to user, C_Code to course
ALTER TABLE `course_result`
  ADD CONSTRAINT `course_result_student_fk` 
  FOREIGN KEY (`S_ID`) REFERENCES `student` (`S_ID`) 
  ON DELETE CASCADE 
  ON UPDATE CASCADE,
  ADD CONSTRAINT `course_result_user_fk` 
  FOREIGN KEY (`uid`) REFERENCES `user` (`UID`) 
  ON DELETE CASCADE 
  ON UPDATE CASCADE,
  ADD CONSTRAINT `course_result_course_fk` 
  FOREIGN KEY (`C_Code`) REFERENCES `course` (`course_code`) 
  ON DELETE CASCADE 
  ON UPDATE CASCADE;

-- department table: link Ccode to collage
ALTER TABLE `department`
  ADD CONSTRAINT `department_collage_fk` 
  FOREIGN KEY (`Ccode`) REFERENCES `collage` (`Ccode`) 
  ON DELETE CASCADE 
  ON UPDATE CASCADE;

-- entrance_exam table: link S_ID to student
ALTER TABLE `entrance_exam`
  ADD CONSTRAINT `entrance_exam_student_fk` 
  FOREIGN KEY (`S_ID`) REFERENCES `student` (`S_ID`) 
  ON DELETE CASCADE 
  ON UPDATE CASCADE;

-- grade table: link sid to student
ALTER TABLE `grade`
  ADD CONSTRAINT `grade_student_fk` 
  FOREIGN KEY (`sid`) REFERENCES `student` (`S_ID`) 
  ON DELETE CASCADE 
  ON UPDATE CASCADE;

-- payment_table: link UID to user
ALTER TABLE `payment_table`
  ADD CONSTRAINT `payment_user_fk` 
  FOREIGN KEY (`UID`) REFERENCES `user` (`UID`) 
  ON DELETE CASCADE 
  ON UPDATE CASCADE;

-- user table: link d_code to department
ALTER TABLE `user`
  ADD CONSTRAINT `user_department_fk` 
  FOREIGN KEY (`d_code`) REFERENCES `department` (`Dcode`) 
  ON DELETE SET NULL 
  ON UPDATE SET NULL;
