-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 29, 2021 at 06:18 PM
-- Server version: 10.4.19-MariaDB
-- PHP Version: 8.0.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gscs`
--

-- --------------------------------------------------------

--
-- Table structure for table `grades`
--

CREATE TABLE `grades` (
  `id` int(11) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `grade` decimal(5,0) NOT NULL,
  `quarter` int(1) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `time_stamp` varchar(255) NOT NULL,
  `adviser` varchar(255) NOT NULL,
  `year_level` int(1) NOT NULL,
  `school_year` int(25) NOT NULL,
  `grade_q2` int(2) NOT NULL,
  `grade_q3` int(2) NOT NULL,
  `grade_q4` int(2) NOT NULL,
  `final_rating` varchar(10) NOT NULL,
  `school` varchar(255) NOT NULL,
  `school_id` int(50) NOT NULL,
  `district` varchar(255) NOT NULL,
  `division` varchar(255) NOT NULL,
  `region` varchar(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `grades`
--

INSERT INTO `grades` (`id`, `firstname`, `lastname`, `grade`, `quarter`, `subject`, `time_stamp`, `adviser`, `year_level`, `school_year`, `grade_q2`, `grade_q3`, `grade_q4`, `final_rating`, `school`, `school_id`, `district`, `division`, `region`) VALUES
(51, 'Charlot', 'Maramag', '75', 1, 'Mathematics', '07 29 21 09:51:52', 'fe', 5, 2021, 87, 85, 85, '83', '', 0, '', '', ''),
(52, 'Charlot', 'Maramag', '85', 1, 'English', '07 29 21 10:03:02', 'fe', 5, 2021, 87, 85, 85, '85.5', '', 0, '', '', ''),
(53, 'Charlot', 'Maramag', '89', 1, 'Values Education', '07 29 21 10:27:47', 'fe', 5, 2021, 87, 85, 85, '86.5', '', 0, '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `systemdependencies`
--

CREATE TABLE `systemdependencies` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `remarks` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `systemdependencies`
--

INSERT INTO `systemdependencies` (`id`, `title`, `description`, `remarks`) VALUES
(32, 'Mathematics', 'Mathematics', 'subject'),
(34, 'English', 'English', 'subject'),
(36, 'Mother Tongue', 'Mother Tongue', 'subject'),
(37, 'Filipino', 'Filipino', 'subject'),
(45, 'EPP', 'EPP', 'subject'),
(46, 'Values Education', 'Values Education', 'subject'),
(47, 'MAPEH', 'MAPEH', 'subject'),
(48, 'EsP', 'EsP', 'subject');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `LRN` int(50) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `mname` varchar(255) NOT NULL,
  `name_extn` varchar(255) NOT NULL,
  `grade_level` int(1) NOT NULL,
  `user_level` int(1) NOT NULL,
  `password` varchar(255) NOT NULL,
  `sex` varchar(1) NOT NULL,
  `bday` int(2) NOT NULL,
  `bmonth` varchar(50) NOT NULL,
  `byear` int(4) NOT NULL,
  `credentials_submitted` varchar(255) NOT NULL,
  `testing_center_name` varchar(255) NOT NULL,
  `testing_center_addr` varchar(255) NOT NULL,
  `date_of_exam` varchar(50) NOT NULL,
  `other_creds_1` varchar(255) NOT NULL,
  `other_creds_2` varchar(255) NOT NULL,
  `name_of_school` varchar(255) NOT NULL,
  `school_id` varchar(50) NOT NULL,
  `address_of_school` varchar(255) NOT NULL,
  `pept_passer_rating` int(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `LRN`, `lastname`, `firstname`, `mname`, `name_extn`, `grade_level`, `user_level`, `password`, `sex`, `bday`, `bmonth`, `byear`, `credentials_submitted`, `testing_center_name`, `testing_center_addr`, `date_of_exam`, `other_creds_1`, `other_creds_2`, `name_of_school`, `school_id`, `address_of_school`, `pept_passer_rating`) VALUES
(22, 0, '', 'admin', '', '', 0, 0, '123', '', 0, '', 0, '', '', '', '', '', '', '', '', '', 0),
(23, 0, 'Irorita', 'fe', '', '', 5, 2, 'fe_irorita', '', 0, '', 0, '', '', '', '', '', '', '', '', '', 0),
(29, 0, 'Maramag', 'Charlot', '', '', 5, 1, '', '', 0, '', 0, '', '', '', '', '', '', '', '', '', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `grades`
--
ALTER TABLE `grades`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `systemdependencies`
--
ALTER TABLE `systemdependencies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `grades`
--
ALTER TABLE `grades`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `systemdependencies`
--
ALTER TABLE `systemdependencies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
