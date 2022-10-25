-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 25, 2022 at 07:31 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sv_hieudm_vcsprog05`
--

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE `message` (
  `id` int(11) NOT NULL,
  `id_sender` int(11) NOT NULL,
  `id_reciever` int(11) NOT NULL,
  `content` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `message`
--

INSERT INTO `message` (`id`, `id_sender`, `id_reciever`, `content`) VALUES
(1, 1, 3, 'Hello'),
(2, 1, 3, 'How are you?'),
(3, 3, 1, 'I&#039;m fine, thank you. And you?');

-- --------------------------------------------------------

--
-- Table structure for table `tblassignment`
--

CREATE TABLE `tblassignment` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `idteacher` int(11) NOT NULL,
  `filename` varchar(255) NOT NULL,
  `updateon` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tblassignment`
--

INSERT INTO `tblassignment` (`id`, `title`, `idteacher`, `filename`, `updateon`) VALUES
(1, 'Malware Analysis Lab', 1, 'Lab 10_Data Encoding (1).docx', '2022-10-25 11:23:38');

-- --------------------------------------------------------

--
-- Table structure for table `tblchallenge`
--

CREATE TABLE `tblchallenge` (
  `id` int(11) NOT NULL,
  `id_teacher` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `hint` varchar(20000) NOT NULL,
  `updateon` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tblchallenge`
--

INSERT INTO `tblchallenge` (`id`, `id_teacher`, `title`, `description`, `hint`, `updateon`) VALUES
(1, 1, 'English', 'Điền từ thích hợp vào ... : \r\nYou ... a student.', 'Tobe Verb', '2022-10-25 11:16:18'),
(2, 1, 'Thi', 'Tên môn thi KTHP đầu tiên', 'KMA', '2022-10-25 11:17:14'),
(3, 1, 'Math', '5*5 bằng mấy???', 'Bảng cửu chương', '2022-10-25 11:18:04'),
(4, 1, 'History', 'Ai lãnh đạo trận đánh trên sông Bạch Đằng 938?', 'Thủy chiến 938', '2022-10-25 11:21:33');

-- --------------------------------------------------------

--
-- Table structure for table `tblsubmit`
--

CREATE TABLE `tblsubmit` (
  `id` int(11) NOT NULL,
  `id_assign` int(11) NOT NULL,
  `id_stu` int(11) NOT NULL,
  `filename` varchar(255) NOT NULL,
  `updateon` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tblsubmit`
--

INSERT INTO `tblsubmit` (`id`, `id_assign`, `id_stu`, `filename`, `updateon`) VALUES
(1, 1, 3, 'Lab6-7_Question.txt', '2022-10-25 11:27:01');

-- --------------------------------------------------------

--
-- Table structure for table `tbluser`
--

CREATE TABLE `tbluser` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `pos` int(11) NOT NULL,
  `name` varchar(128) NOT NULL,
  `pnumber` varchar(16) NOT NULL,
  `email` varchar(128) NOT NULL,
  `avatar` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbluser`
--

INSERT INTO `tbluser` (`id`, `username`, `password`, `pos`, `name`, `pnumber`, `email`, `avatar`) VALUES
(1, 'teacher1', 'f83e69e4170a786e44e3d32a2479cce9', 1, 'Đinh Viết Hải', '0123456789', 'haidv@viettel.com', 'DinhVietHai.jpg'),
(2, 'teacher2', 'f83e69e4170a786e44e3d32a2479cce9', 1, 'Phạm Văn Khánh', '0987654321', 'teacher2@viettel.com', ''),
(3, 'student1', 'f83e69e4170a786e44e3d32a2479cce9', 2, 'Đỗ Minh Hiếu', '0135792468', 'minhhieua3t@gmail.com', ''),
(4, 'student2', 'f83e69e4170a786e44e3d32a2479cce9', 2, 'NoName', '0122333444', 'noname@gmail.com', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblassignment`
--
ALTER TABLE `tblassignment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblchallenge`
--
ALTER TABLE `tblchallenge`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblsubmit`
--
ALTER TABLE `tblsubmit`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbluser`
--
ALTER TABLE `tbluser`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `message`
--
ALTER TABLE `message`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tblassignment`
--
ALTER TABLE `tblassignment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tblchallenge`
--
ALTER TABLE `tblchallenge`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tblsubmit`
--
ALTER TABLE `tblsubmit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbluser`
--
ALTER TABLE `tbluser`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
