-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 28, 2022 at 03:59 PM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.2.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `university_class_scheduler`
--

-- --------------------------------------------------------

--
-- Table structure for table `college`
--

CREATE TABLE `college` (
  `College_ID` varchar(5) NOT NULL,
  `College_Name` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `college`
--

INSERT INTO `college` (`College_ID`, `College_Name`) VALUES
('CCM', 'College of Communication and M'),
('CIT', 'College Of Inovation Technolog'),
('CoB', 'College Of Business'),
('UC', 'University College');

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

CREATE TABLE `course` (
  `Course_ID` varchar(8) NOT NULL,
  `Course_Name` varchar(45) NOT NULL,
  `Course_subject` varchar(50) NOT NULL,
  `Course_Credit` int(1) NOT NULL,
  `Major_ID` varchar(6) NOT NULL,
  `numberofclasses` int(2) DEFAULT NULL,
  `maxnumofStudents` int(2) DEFAULT NULL,
  `numofclassesInDXB` int(2) DEFAULT NULL,
  `numofclassesInADM` int(2) DEFAULT NULL,
  `numofclassesInADF` int(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`Course_ID`, `Course_Name`, `Course_subject`, `Course_Credit`, `Major_ID`, `numberofclasses`, `maxnumofStudents`, `numofclassesInDXB`, `numofclassesInADM`, `numofclassesInADF`) VALUES
('CIT460', 'Systems Analysis & Design', 'Information Technology', 3, 'IT', 4, 24, 2, 1, 1),
('CIT461', 'Systems Analysis & Design Lab', 'Information Technology', 1, 'IT', 4, 16, 2, 1, 1),
('CIT466', 'Data Analytics', 'Information Technology', 3, 'IT', 3, 28, 1, 1, 1),
('INS410 ', 'IT Audit and Control ', 'Information Systems ', 3, 'MIS', 3, 30, 1, 1, 1),
('INS468', 'IT Strategy and Governance		', 'Information Systems ', 3, 'MIS', 2, 28, 1, 1, 0),
('SEC435', 'Digital Forensics Foundations', 'Information Security', 3, 'IT', 3, 24, 1, 0, 2);

-- --------------------------------------------------------

--
-- Table structure for table `course_instructor`
--

CREATE TABLE `course_instructor` (
  `Course_ID` varchar(8) NOT NULL,
  `Faculty_ID` varchar(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `course_instructor`
--

INSERT INTO `course_instructor` (`Course_ID`, `Faculty_ID`) VALUES
('CIT460', 'z2341'),
('CIT460', 'z2351'),
('CIT461', 'z2341'),
('CIT461', 'z2343'),
('CIT461', 'z4342'),
('CIT466', 'z2346'),
('CIT466', 'z2347'),
('INS410 ', 'z2348'),
('INS410 ', 'z2350'),
('INS468', 'z2349'),
('INS468', 'z2350'),
('SEC435', 'z2344'),
('SEC435', 'z2345');

-- --------------------------------------------------------

--
-- Table structure for table `faculty`
--

CREATE TABLE `faculty` (
  `Fac_ID` varchar(12) NOT NULL,
  `Fac_FirstName` varchar(20) NOT NULL,
  `Fac_LastName` varchar(20) NOT NULL,
  `Fac_Email` varchar(18) NOT NULL,
  `college_id` varchar(5) DEFAULT NULL,
  `branch` varchar(3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `faculty`
--

INSERT INTO `faculty` (`Fac_ID`, `Fac_FirstName`, `Fac_LastName`, `Fac_Email`, `college_id`, `branch`) VALUES
('z2341', 'Erick', 'Tomas', 'Erick@zu.ac.ae', 'CIT', 'AUH'),
('z2343', 'Ahmed', 'mohamed', 'Ahmed@zu.ac.ae', 'CIT', 'AUH'),
('z2344', 'Mohamed', 'saoud', 'Mohamed@zu.ac.ae', 'CIT', 'DXB'),
('z2345', 'Tamika', 'johnson', 'Tamika@zu.ac.ae', 'CIT', 'AUH'),
('z2346', 'Thina', 'james', 'Thina@zu.ac.ae', 'CIT', 'DXB'),
('z2347', 'Albert', 'alan', 'Albert@zu.ac.ae', 'CIT', 'AUH'),
('z2348', 'Abdullah', 'salem', 'Abdullah@zu.ac.ae', 'CIT', 'DXB'),
('z2349', 'Saleh', 'ahmed', 'saleh@zu.ac.ae', 'CIT', 'DXB'),
('z2350', 'Salma', 'abdela', 'Salma@zu.ac.ae', 'CIT', 'AUH'),
('z2351', 'Sara', 'Ahmed', 'z2341@zu.ac.ae', 'CIT', 'DXB'),
('z4342', 'John', 'Tomson', 'John@zu.ac.ae', 'CIT', 'DXB');

-- --------------------------------------------------------

--
-- Table structure for table `instructor_availablity`
--

CREATE TABLE `instructor_availablity` (
  `faculty_id` varchar(12) NOT NULL,
  `meetingTime_id` varchar(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `instructor_availablity`
--

INSERT INTO `instructor_availablity` (`faculty_id`, `meetingTime_id`) VALUES
('z2341', 'MT1'),
('z2341', 'MT3'),
('z2341', 'MT4'),
('z2341', 'MT5'),
('z2341', 'MT7'),
('z2341', 'MT8'),
('z2343', 'MT2'),
('z2343', 'MT3'),
('z2343', 'MT4'),
('z2343', 'MT6'),
('z2343', 'MT8'),
('z2343', 'MT9'),
('z2344', 'MT1'),
('z2344', 'MT10'),
('z2344', 'MT4'),
('z2344', 'MT7'),
('z2344', 'MT8'),
('z2344', 'MT9'),
('z2345', 'MT2'),
('z2345', 'MT3'),
('z2345', 'MT5'),
('z2345', 'MT6'),
('z2345', 'MT7'),
('z2345', 'MT8'),
('z2345', 'MT9'),
('z2346', 'MT10'),
('z2346', 'MT2'),
('z2346', 'MT4'),
('z2346', 'MT7'),
('z2346', 'MT8'),
('z2346', 'MT9'),
('z2347', 'MT1'),
('z2347', 'MT10'),
('z2347', 'MT3'),
('z2347', 'MT5'),
('z2347', 'MT6'),
('z2347', 'MT8'),
('z2347', 'MT9'),
('z2348', 'MT10'),
('z2348', 'MT2'),
('z2348', 'MT3'),
('z2348', 'MT5'),
('z2348', 'MT6'),
('z2348', 'MT9'),
('z2349', 'MT1'),
('z2349', 'MT2'),
('z2349', 'MT3'),
('z2349', 'MT4'),
('z2349', 'MT7'),
('z2349', 'MT9'),
('z2350', 'MT1'),
('z2350', 'MT3'),
('z2350', 'MT4'),
('z2350', 'MT6'),
('z2350', 'MT7'),
('z2350', 'MT8'),
('z2350', 'MT9'),
('z2351', 'MT2'),
('z2351', 'MT4'),
('z2351', 'MT5'),
('z2351', 'MT7'),
('z2351', 'MT8'),
('z4342', 'MT10'),
('z4342', 'MT6'),
('z4342', 'MT9');

-- --------------------------------------------------------

--
-- Table structure for table `major`
--

CREATE TABLE `major` (
  `Major_ID` varchar(6) NOT NULL,
  `Major_Name` varchar(30) NOT NULL,
  `College_ID` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `major`
--

INSERT INTO `major` (`Major_ID`, `Major_Name`, `College_ID`) VALUES
('ACC', 'Accounting', 'COB'),
('BUS', 'Business', 'COB'),
('CMS', 'Communication and Media Scienc', 'CCM'),
('IT', 'Information Technology', 'CIT'),
('MIS', 'Management of Information Syst', 'CIT');

-- --------------------------------------------------------

--
-- Table structure for table `meeting_times`
--

CREATE TABLE `meeting_times` (
  `MT_ID` varchar(4) NOT NULL,
  `days` int(2) NOT NULL,
  `StartTime` time NOT NULL,
  `EndTime` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `meeting_times`
--

INSERT INTO `meeting_times` (`MT_ID`, `days`, `StartTime`, `EndTime`) VALUES
('MT1', 5, '08:00:00', '09:00:00'),
('MT10', 10, '11:00:00', '12:20:00'),
('MT2', 5, '09:30:00', '10:50:00'),
('MT3', 5, '11:00:00', '12:20:00'),
('MT4', 5, '13:30:00', '14:50:00'),
('MT5', 5, '15:00:00', '16:20:00'),
('MT6', 10, '13:30:00', '15:50:00'),
('MT7', 10, '08:00:00', '09:20:00'),
('MT8', 10, '15:00:00', '16:20:00'),
('MT9', 10, '09:30:00', '10:50:00');

-- --------------------------------------------------------

--
-- Table structure for table `room`
--

CREATE TABLE `room` (
  `Room_ID` varchar(10) NOT NULL,
  `Room_Location` varchar(20) NOT NULL,
  `capacity` int(2) DEFAULT NULL,
  `Campus` varchar(3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `room`
--

INSERT INTO `room` (`Room_ID`, `Room_Location`, `capacity`, `Campus`) VALUES
('21', 'M1-0-01', 30, 'ADM'),
('22', 'M1-0-02', 28, 'ADM'),
('23', 'M1-0-03', 24, 'ADM'),
('24', 'M1-0-04', 28, 'ADM'),
('25', 'F1-0-01', 30, 'ADF'),
('26', 'F1-0-01', 28, 'ADF'),
('27', 'F1-0-03', 30, 'ADF'),
('28', 'F1-1-04', 30, 'ADF'),
('29', 'GF-001', 22, 'DXB'),
('30', 'GF-002', 30, 'DXB'),
('31', 'GF-003', 22, 'DXB'),
('32', 'GF-004', 30, 'DXB');

-- --------------------------------------------------------

--
-- Table structure for table `section`
--

CREATE TABLE `section` (
  `CRN` int(6) NOT NULL,
  `Section_NO` int(3) NOT NULL,
  `Meeting_Day` varchar(10) NOT NULL,
  `StartTime` time NOT NULL,
  `EndTime` time NOT NULL,
  `Course_ID` varchar(8) NOT NULL,
  `Room_ID` varchar(30) NOT NULL,
  `Fac_ID` varchar(12) NOT NULL,
  `campus` varchar(3) DEFAULT NULL,
  `EnrolledStudents` int(32) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `section`
--

INSERT INTO `section` (`CRN`, `Section_NO`, `Meeting_Day`, `StartTime`, `EndTime`, `Course_ID`, `Room_ID`, `Fac_ID`, `campus`, `EnrolledStudents`) VALUES
(20001, 501, '10', '09:30:00', '10:50:00', 'CIT460', '30', 'z2351', 'DXB', 0),
(20002, 502, '5', '11:00:00', '12:20:00', 'CIT460', '32', 'z2351', 'DXB', 0),
(20003, 901, '10', '09:30:00', '10:50:00', 'CIT460', '24', 'z2341', 'ADM', 0),
(20004, 1, '5', '11:00:00', '12:20:00', 'CIT460', '25', 'z2341', 'ADF', 0),
(20005, 501, '5', '13:30:00', '14:50:00', 'CIT461', '29', 'z4342', 'DXB', 0),
(20006, 502, '5', '11:00:00', '12:20:00', 'CIT461', '30', 'z4342', 'DXB', 0),
(20007, 901, '10', '15:00:00', '16:20:00', 'CIT461', '22', 'z2341', 'ADM', 0),
(20008, 1, '10', '13:30:00', '15:50:00', 'CIT461', '25', 'z2343', 'ADF', 0),
(20009, 501, '10', '08:00:00', '09:20:00', 'CIT466', '32', 'z2346', 'DXB', 0),
(20010, 901, '5', '08:00:00', '09:00:00', 'CIT466', '21', 'z2347', 'ADM', 0),
(20011, 1, '5', '13:30:00', '14:50:00', 'CIT466', '28', 'z2347', 'ADF', 0),
(20012, 501, '5', '13:30:00', '14:50:00', 'INS410', '30', 'z2348', 'DXB', 0),
(20013, 901, '5', '15:00:00', '16:20:00', 'INS410', '21', 'z2350', 'ADM', 0),
(20014, 1, '10', '13:30:00', '15:50:00', 'INS410', '27', 'z2350', 'ADF', 0),
(20015, 501, '5', '08:00:00', '09:00:00', 'INS468', '32', 'z2349', 'DXB', 0),
(20016, 901, '5', '09:30:00', '10:50:00', 'INS468', '24', 'z2350', 'ADM', 0),
(20017, 501, '5', '15:00:00', '16:20:00', 'SEC435', '30', 'z2344', 'DXB', 0),
(20018, 1, '10', '11:00:00', '12:20:00', 'SEC435', '26', 'z2345', 'ADF', 0),
(20019, 2, '10', '08:00:00', '09:20:00', 'SEC435', '25', 'z2345', 'ADF', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `college`
--
ALTER TABLE `college`
  ADD PRIMARY KEY (`College_ID`);

--
-- Indexes for table `course`
--
ALTER TABLE `course`
  ADD PRIMARY KEY (`Course_ID`),
  ADD KEY `Major_ID` (`Major_ID`);

--
-- Indexes for table `course_instructor`
--
ALTER TABLE `course_instructor`
  ADD PRIMARY KEY (`Course_ID`,`Faculty_ID`),
  ADD KEY `Faculty_ID` (`Faculty_ID`);

--
-- Indexes for table `faculty`
--
ALTER TABLE `faculty`
  ADD PRIMARY KEY (`Fac_ID`),
  ADD KEY `college_id` (`college_id`);

--
-- Indexes for table `instructor_availablity`
--
ALTER TABLE `instructor_availablity`
  ADD PRIMARY KEY (`faculty_id`,`meetingTime_id`),
  ADD KEY `meetingTime_id` (`meetingTime_id`);

--
-- Indexes for table `major`
--
ALTER TABLE `major`
  ADD PRIMARY KEY (`Major_ID`),
  ADD KEY `College_ID` (`College_ID`);

--
-- Indexes for table `meeting_times`
--
ALTER TABLE `meeting_times`
  ADD PRIMARY KEY (`MT_ID`);

--
-- Indexes for table `room`
--
ALTER TABLE `room`
  ADD PRIMARY KEY (`Room_ID`);

--
-- Indexes for table `section`
--
ALTER TABLE `section`
  ADD PRIMARY KEY (`CRN`),
  ADD KEY `Course_ID` (`Course_ID`),
  ADD KEY `Room_ID` (`Room_ID`),
  ADD KEY `Fac_ID` (`Fac_ID`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `course`
--
ALTER TABLE `course`
  ADD CONSTRAINT `course_ibfk_1` FOREIGN KEY (`Major_ID`) REFERENCES `major` (`Major_ID`);

--
-- Constraints for table `course_instructor`
--
ALTER TABLE `course_instructor`
  ADD CONSTRAINT `course_instructor_ibfk_1` FOREIGN KEY (`Faculty_ID`) REFERENCES `faculty` (`Fac_ID`);

--
-- Constraints for table `faculty`
--
ALTER TABLE `faculty`
  ADD CONSTRAINT `faculty_ibfk_1` FOREIGN KEY (`college_id`) REFERENCES `college` (`College_ID`),
  ADD CONSTRAINT `faculty_ibfk_2` FOREIGN KEY (`college_id`) REFERENCES `college` (`College_ID`);

--
-- Constraints for table `instructor_availablity`
--
ALTER TABLE `instructor_availablity`
  ADD CONSTRAINT `instructor_availablity_ibfk_1` FOREIGN KEY (`faculty_id`) REFERENCES `faculty` (`Fac_ID`),
  ADD CONSTRAINT `instructor_availablity_ibfk_2` FOREIGN KEY (`faculty_id`) REFERENCES `faculty` (`Fac_ID`),
  ADD CONSTRAINT `instructor_availablity_ibfk_3` FOREIGN KEY (`faculty_id`) REFERENCES `faculty` (`Fac_ID`),
  ADD CONSTRAINT `instructor_availablity_ibfk_4` FOREIGN KEY (`meetingTime_id`) REFERENCES `meeting_times` (`MT_ID`),
  ADD CONSTRAINT `instructor_availablity_ibfk_5` FOREIGN KEY (`faculty_id`) REFERENCES `faculty` (`Fac_ID`);

--
-- Constraints for table `major`
--
ALTER TABLE `major`
  ADD CONSTRAINT `major_ibfk_1` FOREIGN KEY (`College_ID`) REFERENCES `college` (`College_ID`);

--
-- Constraints for table `section`
--
ALTER TABLE `section`
  ADD CONSTRAINT `section_ibfk_1` FOREIGN KEY (`Course_ID`) REFERENCES `course` (`Course_ID`),
  ADD CONSTRAINT `section_ibfk_2` FOREIGN KEY (`Room_ID`) REFERENCES `room` (`Room_ID`),
  ADD CONSTRAINT `section_ibfk_3` FOREIGN KEY (`Fac_ID`) REFERENCES `faculty` (`Fac_ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
