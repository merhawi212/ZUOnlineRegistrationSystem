-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 28, 2022 at 09:04 PM
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
-- Database: `course_registration_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `adddropcourse`
--

CREATE TABLE `adddropcourse` (
  `student_id` varchar(12) NOT NULL,
  `CRN` int(6) NOT NULL,
  `RequestType` enum('Add','Drop') NOT NULL DEFAULT 'Add',
  `RequestedDateTime` datetime DEFAULT NULL,
  `status` enum('Pending','Requested','Inprogress','Approved','Rejected') NOT NULL DEFAULT 'Pending',
  `DateTime` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `username` varchar(32) NOT NULL,
  `password` varchar(256) NOT NULL,
  `salt` varchar(3) NOT NULL,
  `LastAccessingTime` datetime(6) DEFAULT NULL,
  `status` enum('Inactive','Active') NOT NULL DEFAULT 'Inactive'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`username`, `password`, `salt`, `LastAccessingTime`, `status`) VALUES
('admin', '22e5b4ac676565f8fb88ff6910a62c499e3ca2e92dc630f6ea1d5c53432161f7', '9eb', '2022-11-29 12:00:09.000000', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `student_id` varchar(12) NOT NULL,
  `course_id` varchar(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`student_id`, `course_id`) VALUES
('201900112', 'CIT460'),
('201900112', 'CIT466'),
('201900112', 'NET455	'),
('201900112', 'SEC430'),
('201911004', 'CIT460'),
('201911004', 'CIT466'),
('201911004', 'SEC430'),
('201911004', 'SEC435');

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
  `Major_ID` varchar(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`Course_ID`, `Course_Name`, `Course_subject`, `Course_Credit`, `Major_ID`) VALUES
('CIT460', 'Systems Analysis & Design', 'Information Technology', 3, 'IT'),
('CIT461', 'Systems Analysis & Design Lab', 'Information Technology', 1, 'IT'),
('CIT466', 'Data Analytics', 'Information Technology', 3, 'IT'),
('INS361', 'Enterprise Resource Planning Sys. ', 'Information Systems', 3, 'MIS'),
('INS369 ', 'Business Process Management', 'Information Systems ', 3, 'MIS'),
('INS410', 'IT Audit and Control ', 'Information Systems ', 3, 'MIS'),
('INS468', 'IT Strategy and Governance		', 'Information Systems ', 3, 'MIS'),
('NET455	', 'Wireless Sensor Networks', 'Networking Technology', 3, 'IT'),
('SEC430', 'Inform. Security Management	', 'Information Security', 3, 'IT'),
('SEC435', 'Digital Forensics Foundations', 'Information Security', 3, 'IT'),
('SWE346', 'Dynamic Web Development', 'Software Engineering', 3, 'IT');

-- --------------------------------------------------------

--
-- Table structure for table `course_enroll`
--

CREATE TABLE `course_enroll` (
  `student_id` varchar(12) NOT NULL,
  `CRN` int(6) NOT NULL,
  `dateTime` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `course_enroll`
--

INSERT INTO `course_enroll` (`student_id`, `CRN`, `dateTime`) VALUES
('201900112', 22111, '2022-11-28 11:47:19'),
('201900112', 22112, '2022-11-28 11:47:19'),
('201900112', 22114, '2022-11-28 11:47:19'),
('201911004', 22112, '2022-11-28 11:50:25'),
('201911004', 22113, '2022-11-28 11:50:25'),
('201911004', 22114, '2022-11-28 11:50:25'),
('201911004', 22118, '2022-11-28 11:50:25');

-- --------------------------------------------------------

--
-- Table structure for table `faculty`
--

CREATE TABLE `faculty` (
  `Fac_ID` varchar(12) NOT NULL,
  `Fac_FirstName` varchar(20) NOT NULL,
  `Fac_LastName` varchar(20) NOT NULL,
  `Fac_Email` varchar(18) NOT NULL,
  `College_ID` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `faculty`
--

INSERT INTO `faculty` (`Fac_ID`, `Fac_FirstName`, `Fac_LastName`, `Fac_Email`, `College_ID`) VALUES
('z2341', 'Erick', 'Tomas', 'Erick@zu.ac.ae', 'CIT'),
('z2343', 'Ahmed', 'mohamed', 'Ahmed@zu.ac.ae', 'CIT'),
('z2344', 'Mohamed', 'saoud', 'Mohamed@zu.ac.ae', 'CIT'),
('z2345', 'Tamika', 'johnson', 'Tamika@zu.ac.ae', 'CIT'),
('z2346', 'Thina', 'james', 'Thina@zu.ac.ae', 'CIT'),
('z2347', 'Albert', 'alan', 'Albert@zu.ac.ae', 'CIT'),
('z2348', 'Abdullah', 'salem', 'Abdullah@zu.ac.ae', 'CIT'),
('z2349', 'Saleh', 'ahmed', 'saleh@zu.ac.ae', 'CIT'),
('z2350', 'Salma', 'abdela', 'Salma@zu.ac.ae', 'CIT'),
('z4342', 'John', 'Tomson', 'John@zu.ac.ae', 'CIT');

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
-- Table structure for table `projectiontable`
--

CREATE TABLE `projectiontable` (
  `std_ID` varchar(32) NOT NULL,
  `course_ID` varchar(8) NOT NULL,
  `Term` int(8) DEFAULT NULL,
  `status` enum('Unenroll','Pending','Enrolled') NOT NULL DEFAULT 'Unenroll'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `projectiontable`
--

INSERT INTO `projectiontable` (`std_ID`, `course_ID`, `Term`, `status`) VALUES
('201900112', 'CIT460', NULL, 'Unenroll'),
('201900112', 'CIT466', NULL, 'Enrolled'),
('201900112', 'NET455	', NULL, 'Enrolled'),
('201900112', 'SEC430', NULL, 'Enrolled'),
('201900112', 'SEC435', NULL, 'Unenroll'),
('201901142', 'CIT460', 202321, 'Unenroll'),
('201901142', 'CIT466', NULL, 'Unenroll'),
('201901142', 'INS361', NULL, 'Unenroll'),
('201901142', 'INS369 ', NULL, 'Unenroll'),
('201901142', 'INS410', NULL, 'Unenroll'),
('201901142', 'INS468', NULL, 'Unenroll'),
('201911004', 'CIT460', NULL, 'Enrolled'),
('201911004', 'CIT466', NULL, 'Enrolled'),
('201911004', 'SEC430', NULL, 'Enrolled'),
('201911004', 'SEC435', NULL, 'Enrolled'),
('201911004', 'SWE346', NULL, 'Unenroll');

-- --------------------------------------------------------

--
-- Table structure for table `room`
--

CREATE TABLE `room` (
  `Room_ID` varchar(10) NOT NULL,
  `Room_Location` varchar(20) NOT NULL,
  `capacity` int(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `room`
--

INSERT INTO `room` (`Room_ID`, `Room_Location`, `capacity`) VALUES
('21', 'M1-0-01', 25),
('22', 'M1-0-02', 30),
('23', 'M1-0-03', 24),
('24', 'M1-0-04', 22),
('25', 'M1-0-05', 30),
('26', 'M1-0-06', 30),
('27', 'M1-0-07', 30),
('28', 'M1-1-01', 30),
('29', 'M1-1-02', 30),
('30', 'M1-1-03', 30),
('31', 'M1-1-04', 30),
('32', 'M1-1-05', 30);

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
  `EnrolledStudents` int(32) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `section`
--

INSERT INTO `section` (`CRN`, `Section_NO`, `Meeting_Day`, `StartTime`, `EndTime`, `Course_ID`, `Room_ID`, `Fac_ID`, `EnrolledStudents`) VALUES
(22110, 901, '5', '08:00:00', '09:20:00', 'CIT460', '21', 'z2341', 20),
(22111, 901, '10', '15:00:00', '16:20:00', 'NET455	', '22', 'z2347', 4),
(22112, 901, '5', '15:00:00', '16:20:00', 'CIT466', '23', 'z2344', 16),
(22113, 901, '5', '11:00:00', '12:20:00', 'SEC435', '25', 'z2347', 27),
(22114, 901, '10', '13:30:00', '14:50:00', 'SEC430', '26', 'z2345', 4),
(22115, 901, '5', '09:30:00', '10:50:00', 'INS410', '28', 'z2349', 2),
(22116, 902, '10', '08:00:00', '09:20:00', 'INS410', '24', 'z2350', 3),
(22117, 902, '5', '11:00:00', '12:20:00', 'SEC430', '24', 'z2345', 0),
(22118, 902, '10', '11:00:00', '12:20:00', 'CIT460', '27', 'z2346', 10),
(22119, 901, '10', '13:30:00', '14:50:00', 'INS468', '29', 'z2350', 3),
(22120, 902, '10', '11:00:00', '12:20:00', 'INS369 ', '29', 'z2350', 1),
(22121, 901, '5', '09:30:00', '10:50:00', 'INS369 ', '21', 'z2350', 3),
(22122, 901, '5', '13:30:00', '14:50:00', 'INS361', '29', 'z2348', 2),
(22123, 901, '10', '09:30:00', '10:50:00', 'SWE346', '24', 'z2343', 1),
(22124, 902, '10', '15:00:00', '16:20:00', 'CIT466', '26', 'z2344', 1),
(22125, 902, '5', '11:00:00', '12:20:00', 'INS361', '30', 'z2349', 1),
(22126, 902, '10', '15:00:00', '16:20:00', 'INS468', '30', 'z2348', 0),
(22127, 902, '5', '15:00:00', '16:20:00', 'SEC435', '21', 'z2347', 0),
(22128, 902, '10', '08:00:00', '09:20:00', 'SWE346', '22', 'z2343', 0);

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `Std_ID` varchar(12) NOT NULL,
  `Std_FirstName` varchar(20) NOT NULL,
  `Std_LastName` varchar(20) NOT NULL,
  `Std_Email` varchar(18) NOT NULL,
  `CGPA` float DEFAULT NULL,
  `Major_ID` varchar(6) NOT NULL,
  `Gender` enum('F','M') DEFAULT 'F',
  `campus` enum('DXB','ADM','ADF') NOT NULL DEFAULT 'DXB',
  `std_status` enum('Active','Inactive') NOT NULL DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`Std_ID`, `Std_FirstName`, `Std_LastName`, `Std_Email`, `CGPA`, `Major_ID`, `Gender`, `campus`, `std_status`) VALUES
('201900112', 'Aradom', 'Yhdego', '201900112@zu.ac.ae', 1.8, 'IT', 'M', 'ADM', 'Active'),
('201901142', 'Abrha', 'Yeebyo', '201901142@zu.ac.ae', 3, 'MIS', 'M', 'ADM', 'Active'),
('201911004', 'Saif', 'Ibrahim', '201911004@zu.ac.ae', 2.4, 'IT', 'M', 'ADM', 'Active'),
('201911112', 'Sara', 'Mohammed', '201911112@zu.ac.ae', 2.6, 'IT', 'F', 'DXB', 'Active'),
('201911122', 'Fatima', 'Omer', '201911122@zu.ac.ae', 1.88, 'IT', 'F', 'DXB', 'Active'),
('201911132', 'Trhas', 'Ali', '201911132@zu.ac.ae', 2.2, 'MIS', 'F', 'ADF', 'Active'),
('201911280', 'Reem', 'Abdelkader', '201911280@zu.ac.ae', 3.4, 'MIS', 'F', 'ADF', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `student_logincredential`
--

CREATE TABLE `student_logincredential` (
  `Std_ID` varchar(12) NOT NULL,
  `std_password` varchar(256) NOT NULL,
  `salt` varchar(3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `student_logincredential`
--

INSERT INTO `student_logincredential` (`Std_ID`, `std_password`, `salt`) VALUES
('201900112', '8c2b17627934a6e47b7ebfb92196febc5fcef49606536cbb7ec365fab89fc90e', '3a2'),
('201901142', '8a82ea00d80250de0529b7afe6b64b5b9652642700444519cbfb28c2d5cf8f2f', '90b'),
('201911004', '797bdc3ad7657cf87c1690efd6cbdae46c42e1693e84c677bdda5d5410dbed85', 'b46'),
('201911112', 'berhiu$Eri22', NULL),
('201911122', 'Berie@#barie', NULL),
('201911132', 'Be@#eri', NULL),
('201911280', 'Aymen@asm', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `track_student`
--

CREATE TABLE `track_student` (
  `student_id` varchar(12) NOT NULL,
  `IsRegistered` tinyint(1) NOT NULL DEFAULT 0,
  `IsAddDropCourse` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `track_student`
--

INSERT INTO `track_student` (`student_id`, `IsRegistered`, `IsAddDropCourse`) VALUES
('201900112', 1, 0),
('201901142', 0, 0),
('201911004', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `user_log`
--

CREATE TABLE `user_log` (
  `username` varchar(32) NOT NULL,
  `LastAccessingTime` datetime NOT NULL,
  `user_status` enum('Inactive','Active') NOT NULL DEFAULT 'Inactive'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_log`
--

INSERT INTO `user_log` (`username`, `LastAccessingTime`, `user_status`) VALUES
('201900112', '2022-11-28 11:45:27', 'Inactive'),
('201901142', '2022-11-28 11:33:34', 'Inactive'),
('201911004', '2022-11-28 11:48:15', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `user_pin`
--

CREATE TABLE `user_pin` (
  `pin` int(4) NOT NULL,
  `student_id` varchar(11) NOT NULL,
  `StartValidityDateTime` datetime NOT NULL,
  `EndValidityDateTime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_pin`
--

INSERT INTO `user_pin` (`pin`, `student_id`, `StartValidityDateTime`, `EndValidityDateTime`) VALUES
(4321, '201900112', '2022-11-08 12:00:00', '2022-11-12 23:59:00'),
(7321, '201901142', '2022-11-08 12:00:00', '2022-11-12 23:59:00'),
(6321, '201911004', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `adddropcourse`
--
ALTER TABLE `adddropcourse`
  ADD PRIMARY KEY (`student_id`,`CRN`),
  ADD KEY `CRN` (`CRN`);

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`student_id`,`course_id`);

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
-- Indexes for table `course_enroll`
--
ALTER TABLE `course_enroll`
  ADD PRIMARY KEY (`student_id`,`CRN`),
  ADD KEY `CRN` (`CRN`);

--
-- Indexes for table `faculty`
--
ALTER TABLE `faculty`
  ADD PRIMARY KEY (`Fac_ID`),
  ADD KEY `College_ID` (`College_ID`);

--
-- Indexes for table `major`
--
ALTER TABLE `major`
  ADD PRIMARY KEY (`Major_ID`),
  ADD KEY `College_ID` (`College_ID`);

--
-- Indexes for table `projectiontable`
--
ALTER TABLE `projectiontable`
  ADD PRIMARY KEY (`std_ID`,`course_ID`),
  ADD KEY `course_ID` (`course_ID`);

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
  ADD KEY `Room_ID` (`Room_ID`),
  ADD KEY `Fac_ID` (`Fac_ID`),
  ADD KEY `Course_ID` (`Course_ID`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`Std_ID`),
  ADD KEY `Major_ID` (`Major_ID`);

--
-- Indexes for table `student_logincredential`
--
ALTER TABLE `student_logincredential`
  ADD PRIMARY KEY (`Std_ID`);

--
-- Indexes for table `track_student`
--
ALTER TABLE `track_student`
  ADD PRIMARY KEY (`student_id`);

--
-- Indexes for table `user_log`
--
ALTER TABLE `user_log`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `user_pin`
--
ALTER TABLE `user_pin`
  ADD PRIMARY KEY (`student_id`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `course`
--
ALTER TABLE `course`
  ADD CONSTRAINT `course_ibfk_1` FOREIGN KEY (`Major_ID`) REFERENCES `major` (`Major_ID`);

--
-- Constraints for table `faculty`
--
ALTER TABLE `faculty`
  ADD CONSTRAINT `faculty_ibfk_1` FOREIGN KEY (`College_ID`) REFERENCES `college` (`College_ID`);

--
-- Constraints for table `major`
--
ALTER TABLE `major`
  ADD CONSTRAINT `major_ibfk_1` FOREIGN KEY (`College_ID`) REFERENCES `college` (`College_ID`);

--
-- Constraints for table `projectiontable`
--
ALTER TABLE `projectiontable`
  ADD CONSTRAINT `projectiontable_ibfk_1` FOREIGN KEY (`std_ID`) REFERENCES `student` (`Std_ID`),
  ADD CONSTRAINT `projectiontable_ibfk_2` FOREIGN KEY (`course_ID`) REFERENCES `course` (`Course_ID`);

--
-- Constraints for table `section`
--
ALTER TABLE `section`
  ADD CONSTRAINT `section_ibfk_2` FOREIGN KEY (`Room_ID`) REFERENCES `room` (`Room_ID`),
  ADD CONSTRAINT `section_ibfk_3` FOREIGN KEY (`Fac_ID`) REFERENCES `faculty` (`Fac_ID`),
  ADD CONSTRAINT `section_ibfk_4` FOREIGN KEY (`Course_ID`) REFERENCES `course` (`Course_ID`);

--
-- Constraints for table `student`
--
ALTER TABLE `student`
  ADD CONSTRAINT `student_ibfk_1` FOREIGN KEY (`Major_ID`) REFERENCES `major` (`Major_ID`);

--
-- Constraints for table `student_logincredential`
--
ALTER TABLE `student_logincredential`
  ADD CONSTRAINT `student_logincredential_ibfk_1` FOREIGN KEY (`Std_ID`) REFERENCES `student` (`Std_ID`);

--
-- Constraints for table `track_student`
--
ALTER TABLE `track_student`
  ADD CONSTRAINT `track_student_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `student` (`Std_ID`);

--
-- Constraints for table `user_pin`
--
ALTER TABLE `user_pin`
  ADD CONSTRAINT `user_pin_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `student` (`Std_ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
