-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 16, 2024 at 05:27 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `facultyappointment`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_ID` int(11) NOT NULL,
  `fname` varchar(255) NOT NULL,
  `lname` varchar(255) NOT NULL,
  `adminusername` varchar(255) NOT NULL,
  `adminemail` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_ID`, `fname`, `lname`, `adminusername`, `adminemail`, `password`) VALUES
(1, 'Jersey', 'Franes', 'Admin', 'admin@gmail.com', 'Admin123');

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `id` int(11) NOT NULL,
  `appointment_name` varchar(255) NOT NULL,
  `appointment_date` date NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appointments`
--

INSERT INTO `appointments` (`id`, `appointment_name`, `appointment_date`, `start_time`, `end_time`, `created_at`, `status`) VALUES
(1, 'meeting', '2024-06-16', '10:00:00', '11:00:00', '2024-06-16 15:06:09', 0);

-- --------------------------------------------------------

--
-- Table structure for table `faculty`
--

CREATE TABLE `faculty` (
  `faculty_ID` int(11) NOT NULL,
  `fname` varchar(100) NOT NULL,
  `mname` varchar(100) NOT NULL,
  `lname` varchar(100) NOT NULL,
  `address` varchar(255) NOT NULL,
  `contact_number` varchar(50) NOT NULL,
  `gender` varchar(25) NOT NULL,
  `bday` varchar(25) NOT NULL,
  `profile` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `archive` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `faculty`
--

INSERT INTO `faculty` (`faculty_ID`, `fname`, `mname`, `lname`, `address`, `contact_number`, `gender`, `bday`, `profile`, `email`, `pass`, `archive`) VALUES
(1, 'John Bryan', 'Resuello', 'Tisado', 'Brgy. Balaya , SCCP.', '09456387648', 'Male', '2024-06-16', '666ef972c30fa2.16603897.png', 'johnbryantisado@gmail.com', '$2y$10$ujJnCjmw0UhDvnKXf66JGu9p/E1avaW1jhbUkBglamyp97TRMO4Ua', 0),
(2, 'John Henderson', 'Guleng', 'Gelido', 'Brgy.Calomboyan, SCCP.', '09456387648', 'Male', '2024-06-16', 'user.png', 'henderson@gmail.com', '$2y$10$phlZ0UnTzqCPoy7r7ES53ecC/WNJn/4f94L22pSgLR3VShxmAaqaS', 1);

-- --------------------------------------------------------

--
-- Table structure for table `schedule_list`
--

CREATE TABLE `schedule_list` (
  `id` int(30) NOT NULL,
  `title` text NOT NULL,
  `description` text NOT NULL,
  `start_datetime` datetime NOT NULL,
  `end_datetime` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `schedule_list`
--

INSERT INTO `schedule_list` (`id`, `title`, `description`, `start_datetime`, `end_datetime`) VALUES
(1, 'sdgsg', 'sdgsdg', '2024-06-06 22:49:00', '2024-06-11 10:49:00'),
(2, 'meeting', 'fdsfsdf', '2024-06-06 13:00:00', '2024-06-08 14:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `status`
--

CREATE TABLE `status` (
  `status_id` int(11) NOT NULL,
  `status_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `status`
--

INSERT INTO `status` (`status_id`, `status_name`) VALUES
(0, 'Unverified'),
(1, 'Verified'),
(2, 'Pending'),
(3, 'Approved'),
(4, 'Declined'),
(5, 'Ongoing'),
(6, 'Completed');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_ID` int(11) NOT NULL,
  `u_fname` varchar(255) NOT NULL,
  `u_mname` varchar(100) NOT NULL,
  `u_lname` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `contact_number` varchar(50) NOT NULL,
  `gender` varchar(25) NOT NULL,
  `u_username` varchar(255) NOT NULL,
  `u_email` varchar(255) NOT NULL,
  `u_pass` varchar(255) NOT NULL,
  `otp` int(11) NOT NULL,
  `status` int(11) NOT NULL COMMENT '0=unverified, 1=verified',
  `profile` varchar(255) NOT NULL,
  `bday` varchar(255) NOT NULL,
  `archive` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_ID`, `u_fname`, `u_mname`, `u_lname`, `address`, `contact_number`, `gender`, `u_username`, `u_email`, `u_pass`, `otp`, `status`, `profile`, `bday`, `archive`) VALUES
(1, 'Henderson', '', '', '', '', '', 'sadasd', 'gelidohenderson@gmail.com', '$2y$10$2eJINKemHwfVtTvlbPSh5e5xRltbaeIl2WzQOIISAyY8jOo3.h6Cy', 532763, 0, '', '', 1),
(2, '', '', '', '', '', '', 'sad', 'zap@gmail.com', '$2y$10$sLQUd2AN.bRXirXKFkO/RO2S7VmIcRaR7yXCSquNHOWWBdotyNWZO', 0, 1, '', '', 1),
(3, 'John Henderson', 'Guleng', 'Gelido', 'Brgy. Balaya , SCCP.', '09456387648', 'Male', 'ews', 'gelidohenderson@gmail.com', 'undefined', 0, 1, '666ea662ad88e1.15820532.png', '', 0),
(4, '', '', '', '', '', '', 'sda', 'gelidohenderson@gmail.com', '$2y$10$nQKuZMyVFpCa28EKeSrLY.17bPBgjuPWcLQOFqKgfc68AFHUTlsIm', 0, 1, '', '', 1),
(6, '', '', '', '', '', '', 'admin', 'johnbryantisado@gmail.com', '$2y$10$l9a3HkP9JQSDJQiLK6OsDu8JRHWS81STCALIZs.3z8RGJcDAP6/B.', 0, 1, '', '', 1),
(10, '', '', '', '', '', 'Male', 'aaron', 'invogaming715@gmail.com', 'undefined', 0, 1, '666ea0e16c8208.11165238.jpg', '', 0),
(11, '', '', '', 'Brgy. Balaya , SCCP.', '09456387648', 'Male', 'bryan', 'johnbryantisado@gmail.com', 'undefined', 0, 1, '666ea0746899e7.18972920.jpg', '2024-06-16', 0),
(14, 'John Bryan', 'Resuello', 'Tisado', 'Brgy. Balaya , SCCP.', '09463147667', 'Male', 'Bry', 'johnbryantisado@gmail.com', '$2y$10$jeSM07sQvm6jdxBHbtZZ7uwIviOCNFiWOTrj1gy7VLXKBq6smeOAK', 0, 1, 'user.png', '2024-06-15', 0),
(15, 'John Bryan', 'Resuello', 'Tisado', 'Brgy. Balaya , SCCP.', '09423674832', 'Male', 'Bryan123', 'johnbryantisado@gmail.com', '$2y$10$W/DouPjumBFcBvZFr0yLB.xDlvaub1vHgmof84VshVfSa.PfzZopO', 0, 1, 'user.png', '2024-06-15', 0),
(16, 'John Bryan', 'Resuello', 'Tisado', 'Brgy. Balaya , SCCP.', '09456387648', 'Male', 'root', '0', '$2y$10$gBc6Zzv5ER2NYZ3lnCq0ge/Cx/SJ7v1Dn.XZa5wUadurto48jpNHa', 0, 1, 'user.png', '2024-06-15', 1),
(17, 'John Bryan', 'Resuello', 'Tisado', 'Brgy. Balaya , SCCP.', '09456387648', 'Male', 'root', 'akashiseijuro0411@yahoo.com', '$2y$10$qJ0gl1HsZgFhtz0sSLeYHejtXYqgm6oeNv/9IsSM8XdMTV3yF50w.', 0, 1, 'user.png', '2024-06-15', 0),
(18, 'John Bryan', 'Resuello', 'Tisado', 'Brgy. Balaya , SCCP.', '09456387648', 'Female', 'Bry12', 'johnbryantisado@gmail.com', 'undefined', 0, 1, '666e9f0920e662.70329149.webp', '2024-06-15', 0),
(19, 'John Bryan', 'Resuello', 'Tisado', 'Brgy. Balaya , SCCP.', '09456387648', 'Male', 'Bry23', 'akashiseijuro0411@yahoo.com', '$2y$10$QBXDCMNDHnW5bdp1yMutqO3evR8Uz39UQdds3UwrkHRsYLMcxprB2', 0, 1, 'user.png', '2024-06-15', 0),
(20, 'John Bryan', 'Resuello', 'Tisado', 'Brgy. Balaya , SCCP.', '09456387648', 'Male', 'Brykjbkj', 'johnbryantisado@gmail.com', '$2y$10$ZoQ3647zT5ZF5EmtMFILbOLeLV16haNhcVevxrUqhR2Uf0NlxTgZ6', 0, 1, 'user.png', '2024-06-16', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_ID`);

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `faculty`
--
ALTER TABLE `faculty`
  ADD PRIMARY KEY (`faculty_ID`);

--
-- Indexes for table `schedule_list`
--
ALTER TABLE `schedule_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`status_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_ID`),
  ADD KEY `status` (`status`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `faculty`
--
ALTER TABLE `faculty`
  MODIFY `faculty_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `schedule_list`
--
ALTER TABLE `schedule_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`status`) REFERENCES `status` (`status_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
