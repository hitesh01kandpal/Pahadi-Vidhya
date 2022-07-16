-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 14, 2022 at 05:51 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 7.1.32

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `moodle`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` varchar(10) NOT NULL,
  `name` varchar(60) NOT NULL,
  `dept_id` varchar(20) NOT NULL,
  `phone` varchar(10) DEFAULT NULL,
  `DOB` varchar(10) DEFAULT NULL,
  `email` varchar(50) NOT NULL,
  `address` varchar(100) DEFAULT NULL,
  `isAdmin` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `name`, `dept_id`, `phone`, `DOB`, `email`, `address`, `isAdmin`) VALUES
('111', 'Aman', 'Administrative', '', '', 'abc@gmail.com', '', 1),
('222', 'Sharma Ji', 'Administrative', '', '', 'sharma@gmail.com', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `admind`
--

CREATE TABLE `admind` (
  `id` int(11) NOT NULL,
  `parent_comment` varchar(500) NOT NULL,
  `student` varchar(1000) NOT NULL,
  `user_id` varchar(10) NOT NULL,
  `role` varchar(100) NOT NULL,
  `post` varchar(1000) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admind`
--

INSERT INTO `admind` (`id`, `parent_comment`, `student`, `user_id`, `role`, `post`, `date`) VALUES
(20, '0', 'Sharma Ji', '222', 'admin', 'hello there', '2022-05-14 03:47:19');

-- --------------------------------------------------------

--
-- Table structure for table `assign`
--

CREATE TABLE `assign` (
  `course_id` varchar(10) NOT NULL,
  `student_id` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `assign`
--

INSERT INTO `assign` (`course_id`, `student_id`) VALUES
('tcs800', '201'),
('tcs800', '301');

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `course_id` varchar(10) NOT NULL,
  `course_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`course_id`, `course_name`) VALUES
('tcs800', 'MOBILE COMPUTING');

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `dept_id` varchar(10) NOT NULL,
  `dept_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`dept_id`, `dept_name`) VALUES
('Btech-1', 'CS');

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `reg_id` varchar(10) NOT NULL,
  `password` varchar(100) NOT NULL,
  `role` varchar(10) NOT NULL,
  `email` varchar(50) NOT NULL,
  `islogin` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`reg_id`, `password`, `role`, `email`, `islogin`) VALUES
('111', '202cb962ac59075b964b07152d234b70', 'admin', '463aman7j@gmail.com', 0),
('201', '202cb962ac59075b964b07152d234b70', 'student', 'chamoli@gmail.com', 1652506830),
('222', '202cb962ac59075b964b07152d234b70', 'admin', 'sharma@gmail.com', 0),
('301', '202cb962ac59075b964b07152d234b70', 'student', 'chetanNegi@gmail.com', 0),
('f012', '202cb962ac59075b964b07152d234b70', 'teacher', 'projectcms05@gmail.com', 0);

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `id` varchar(10) NOT NULL,
  `name` varchar(70) NOT NULL,
  `dept_id` varchar(10) DEFAULT NULL,
  `phone` varchar(10) DEFAULT NULL,
  `DOB` varchar(10) DEFAULT NULL,
  `email` varchar(50) NOT NULL,
  `address` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`id`, `name`, `dept_id`, `phone`, `DOB`, `email`, `address`) VALUES
('201', 'Ayush Chamoli', 'Btech-1', NULL, NULL, 'chamoli@gmail.com', NULL),
('301', 'Chetan Negi', 'Btech-1', NULL, NULL, 'chetanNegi@gmail.com', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tcs800`
--

CREATE TABLE `tcs800` (
  `no` int(11) NOT NULL,
  `header` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `link` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `notes` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ref` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `assigment` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `upload` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `isMeeting` tinyint(1) NOT NULL,
  `attendanceTime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tcs800`
--

INSERT INTO `tcs800` (`no`, `header`, `link`, `notes`, `ref`, `assigment`, `upload`, `isMeeting`, `attendanceTime`) VALUES
(3, 'FDFFGDGF', '', '', '', '', '', 0, '2022-05-13 10:24:00'),
(4, 'SDFDSFSD', 'dsfdsfds', '', 'sdfsdfds', 'dwqdasfd', 'sdfsdfsdfsd', 0, '2022-05-15 10:37:00');

-- --------------------------------------------------------

--
-- Table structure for table `tcs800d`
--

CREATE TABLE `tcs800d` (
  `id` int(11) NOT NULL,
  `parent_comment` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `student` varchar(1000) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `role` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `post` varchar(1000) COLLATE utf8_unicode_ci NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tcs800d`
--

INSERT INTO `tcs800d` (`id`, `parent_comment`, `student`, `user_id`, `role`, `post`, `date`) VALUES
(1, '0', 'Ayush Chamoli', '201', 'student', 'Hello ', '2022-05-14 04:03:27'),
(2, '1', 'Sanjeev Kukreti', 'f012', 'teacher', 'hello  chamoli', '2022-05-14 04:03:49');

-- --------------------------------------------------------

--
-- Table structure for table `tcs800p`
--

CREATE TABLE `tcs800p` (
  `header` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `201S` datetime DEFAULT NULL,
  `301S` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tcs800p`
--

INSERT INTO `tcs800p` (`header`, `201S`, `301S`) VALUES
('FDFFGDGF', '2022-05-14 10:24:39', '2022-05-14 10:37:34'),
('SDFDSFSD', '2022-05-14 10:36:16', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `teacher`
--

CREATE TABLE `teacher` (
  `id` varchar(10) NOT NULL,
  `name` varchar(60) NOT NULL,
  `dept_id` varchar(10) DEFAULT NULL,
  `phone` varchar(10) DEFAULT NULL,
  `DOB` varchar(10) DEFAULT NULL,
  `email` varchar(50) NOT NULL,
  `address` varchar(100) DEFAULT NULL,
  `api_key` varchar(300) DEFAULT NULL,
  `api_secret` varchar(300) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `teacher`
--

INSERT INTO `teacher` (`id`, `name`, `dept_id`, `phone`, `DOB`, `email`, `address`, `api_key`, `api_secret`) VALUES
('f012', 'Sanjeev Kukreti', 'Btech-1', '', '', 'projectcms05@gmail.com', '###', '13zmeBQoS-W4o_ciBQPa7w', 'inqrBRq4irCo9Ki2o2uwpKTXTsRUz7Nr1wu7');

-- --------------------------------------------------------

--
-- Table structure for table `teaches`
--

CREATE TABLE `teaches` (
  `course_id` varchar(10) NOT NULL,
  `teacher_id` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `teaches`
--

INSERT INTO `teaches` (`course_id`, `teacher_id`) VALUES
('tcs800', 'f012');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admind`
--
ALTER TABLE `admind`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `assign`
--
ALTER TABLE `assign`
  ADD PRIMARY KEY (`course_id`,`student_id`),
  ADD KEY `assign_student` (`student_id`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`course_id`);

--
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`dept_id`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`reg_id`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`id`),
  ADD KEY `dept_fk` (`dept_id`);

--
-- Indexes for table `tcs800`
--
ALTER TABLE `tcs800`
  ADD PRIMARY KEY (`no`);

--
-- Indexes for table `tcs800d`
--
ALTER TABLE `tcs800d`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tcs800p`
--
ALTER TABLE `tcs800p`
  ADD PRIMARY KEY (`header`);

--
-- Indexes for table `teacher`
--
ALTER TABLE `teacher`
  ADD PRIMARY KEY (`id`),
  ADD KEY `dept_fk_f` (`dept_id`);

--
-- Indexes for table `teaches`
--
ALTER TABLE `teaches`
  ADD PRIMARY KEY (`course_id`,`teacher_id`),
  ADD KEY `teaches_faculty` (`teacher_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admind`
--
ALTER TABLE `admind`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `tcs800`
--
ALTER TABLE `tcs800`
  MODIFY `no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tcs800d`
--
ALTER TABLE `tcs800d`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `assign`
--
ALTER TABLE `assign`
  ADD CONSTRAINT `assign_course` FOREIGN KEY (`course_id`) REFERENCES `courses` (`course_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `assign_student` FOREIGN KEY (`student_id`) REFERENCES `student` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `student`
--
ALTER TABLE `student`
  ADD CONSTRAINT `dept_fk` FOREIGN KEY (`dept_id`) REFERENCES `department` (`dept_id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints for table `teacher`
--
ALTER TABLE `teacher`
  ADD CONSTRAINT `dept_fk_f` FOREIGN KEY (`dept_id`) REFERENCES `department` (`dept_id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints for table `teaches`
--
ALTER TABLE `teaches`
  ADD CONSTRAINT `teaches_course` FOREIGN KEY (`course_id`) REFERENCES `courses` (`course_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `teaches_faculty` FOREIGN KEY (`teacher_id`) REFERENCES `teacher` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
