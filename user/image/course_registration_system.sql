-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3308
-- Generation Time: Oct 13, 2022 at 11:28 AM
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
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `username` varchar(32) NOT NULL,
  `password` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
  `Term` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`Course_ID`, `Course_Name`, `Course_subject`, `Course_Credit`, `Major_ID`, `Term`) VALUES
('CIT460', 'Systems Analysis & Design', 'Information Technology', 3, 'IT', '202021'),
('CIT461', 'Systems Analysis & Design', 'Information Technology', 1, 'IT', '202021'),
('CIT466', 'Data Analytics', 'Information Technology', 3, 'IT', '202021'),
('SEC435', 'Digital Forensics Foundations', 'Information Security', 3, 'IT', '202022');

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
('z2343', 'Ahmed', 'mohamed', 'Ahmed@zu.ac.ae', 'COB'),
('z2344', 'Mohamed', 'saoud', 'Mohamed@zu.ac.ae', 'CCM'),
('z2345', 'Tamika', 'johnson', 'Tamika@zu.ac.ae', 'CIT'),
('z2346', 'Thina', 'james', 'Thina@zu.ac.ae', 'COB'),
('z2347', 'Albert', 'alan', 'Albert@zu.ac.ae', 'CIT'),
('z2348', 'Abdullah', 'salem', 'Abdullah@zu.ac.ae', 'CIT'),
('z2349', 'Saleh', 'ahmed', 'saleh@zu.ac.ae', 'COB'),
('z2350', 'Salma', 'abdela', 'Salma@zu.ac.ae', 'CCM'),
('z4342', 'John', 'Tomson', 'John@zu.ac.ae', 'CCM');

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
  `Term` int(8) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `projectiontable`
--

INSERT INTO `projectiontable` (`std_ID`, `course_ID`, `Term`) VALUES
('201900112', 'CIT460', 202321),
('201900112', 'CIT461', 202321),
('201900112', 'SEC435', 202321),
('201901142', 'CIT460', 202321),
('201911112', 'SEC435', 202321);

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
('21', 'M1-0-01', 30),
('22', 'M1-0-02', 30),
('23', 'M1-0-03', 30),
('24', 'M1-0-04', 30),
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
  `Fac_ID` varchar(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `section`
--

INSERT INTO `section` (`CRN`, `Section_NO`, `Meeting_Day`, `StartTime`, `EndTime`, `Course_ID`, `Room_ID`, `Fac_ID`) VALUES
(22110, 901, '1010000', '08:00:00', '09:20:00', 'CIT460', '21', 'z2341'),
(22111, 902, '1010000', '09:30:00', '10:50:00', 'CIT461', '22', 'z2343'),
(22112, 903, '010100', '11:00:00', '12:20:00', 'CIT466', '23', 'z2344'),
(22113, 904, '010100', '03:00:00', '04:20:00', 'SEC435', '25', 'z2345'),
(221114, 901, '0101000', '01:30:00', '03:00:00', 'CIT461', '26', 'z2344');

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `Std_ID` varchar(12) NOT NULL,
  `Std_FirstName` varchar(20) NOT NULL,
  `Std_LastName` varchar(20) NOT NULL,
  `Std_Email` varchar(18) NOT NULL,
  `Major_ID` varchar(6) NOT NULL,
  `Term` varchar(20) NOT NULL,
  `CRN` int(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`Std_ID`, `Std_FirstName`, `Std_LastName`, `Std_Email`, `Major_ID`, `Term`, `CRN`) VALUES
('201900112', 'Aradom', 'Yhdego', '201900112@zu.ac.ae', 'IT', '202221', 22110),
('201901142', 'Abrha', 'Yeebyo', '201901142@zu.ac.ae', 'MIS', '202222', 22112),
('201911004', 'Aradom', 'Merhawi', '201911004@zu.ac.ae', 'ACC', '202222', NULL),
('201911112', 'Berihu', 'Yhdego', '201911112@zu.ac.ae', 'IT', '202222', 22110),
('201911122', 'Berie', 'Abrham', '201911122@zu.ac.ae', 'IT', '202222', 22113),
('201911132', 'Bekit', 'Ahmed', '201911132@zu.ac.ae', 'BUS', '202222', NULL),
('201911280', 'Ayme', 'Ayham', '201911280@zu.ac.ae', 'MIS', '202221', 22110);

-- --------------------------------------------------------

--
-- Table structure for table `student_logincredential`
--

CREATE TABLE `student_logincredential` (
  `Std_ID` varchar(12) NOT NULL,
  `std_password` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `student_logincredential`
--

INSERT INTO `student_logincredential` (`Std_ID`, `std_password`) VALUES
('201900112', 'Arado@22'),
('201901142', 'abr@#UAE'),
('201911004', 'Ara!zu'),
('201911112', 'berhiu$Eri22'),
('201911122', 'Berie@#barie'),
('201911132', 'Be@#eri'),
('201911280', 'Aymen@asm');

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
('201900112', '2022-10-13 11:46:55', 'Inactive'),
('201901142', '2022-10-13 11:52:14', 'Inactive');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`username`);

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
  ADD KEY `Course_ID` (`Course_ID`),
  ADD KEY `Room_ID` (`Room_ID`),
  ADD KEY `Fac_ID` (`Fac_ID`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`Std_ID`),
  ADD KEY `Major_ID` (`Major_ID`),
  ADD KEY `Term` (`Term`),
  ADD KEY `CRN` (`CRN`);

--
-- Indexes for table `student_logincredential`
--
ALTER TABLE `student_logincredential`
  ADD PRIMARY KEY (`Std_ID`);

--
-- Indexes for table `user_log`
--
ALTER TABLE `user_log`
  ADD PRIMARY KEY (`username`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `course`
--
ALTER TABLE `course`
  ADD CONSTRAINT `course_ibfk_1` FOREIGN KEY (`Major_ID`) REFERENCES `major` (`Major_ID`),
  ADD CONSTRAINT `course_ibfk_2` FOREIGN KEY (`Term`) REFERENCES `projection` (`Term`);

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
  ADD CONSTRAINT `section_ibfk_1` FOREIGN KEY (`Course_ID`) REFERENCES `course` (`Course_ID`),
  ADD CONSTRAINT `section_ibfk_2` FOREIGN KEY (`Room_ID`) REFERENCES `room` (`Room_ID`),
  ADD CONSTRAINT `section_ibfk_3` FOREIGN KEY (`Fac_ID`) REFERENCES `faculty` (`Fac_ID`);

--
-- Constraints for table `student`
--
ALTER TABLE `student`
  ADD CONSTRAINT `student_ibfk_1` FOREIGN KEY (`Major_ID`) REFERENCES `major` (`Major_ID`),
  ADD CONSTRAINT `student_ibfk_2` FOREIGN KEY (`Term`) REFERENCES `projection` (`Term`),
  ADD CONSTRAINT `student_ibfk_3` FOREIGN KEY (`CRN`) REFERENCES `section` (`CRN`);

--
-- Constraints for table `student_logincredential`
--
ALTER TABLE `student_logincredential`
  ADD CONSTRAINT `student_logincredential_ibfk_1` FOREIGN KEY (`Std_ID`) REFERENCES `student` (`Std_ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
