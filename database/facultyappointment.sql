-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 15, 2024 at 07:24 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

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
(1, 'sdgsg', 'sdgsdg', '2024-06-06 22:49:00', '2024-06-11 10:49:00');

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
(1, 'Verified');

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
  `bday` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_ID`, `u_fname`, `u_mname`, `u_lname`, `address`, `contact_number`, `gender`, `u_username`, `u_email`, `u_pass`, `otp`, `status`, `profile`, `bday`) VALUES
(1, 'Henderson', '', '', '', '', '', 'sadasd', 'gelidohenderson@gmail.com', '$2y$10$2eJINKemHwfVtTvlbPSh5e5xRltbaeIl2WzQOIISAyY8jOo3.h6Cy', 532763, 0, '', ''),
(2, '', '', '', '', '', '', 'sad', 'zap@gmail.com', '$2y$10$sLQUd2AN.bRXirXKFkO/RO2S7VmIcRaR7yXCSquNHOWWBdotyNWZO', 0, 1, '', ''),
(3, '', '', '', '', '', '', 'ews', 'gelidohenderson@gmail.com', '$2y$10$oUkVk/qpnOyORHMnbaZl7OU56fcnSJsKfn7E5MvPd/SQkNp5fdrLy', 0, 1, '', ''),
(4, '', '', '', '', '', '', 'sda', 'gelidohenderson@gmail.com', '$2y$10$nQKuZMyVFpCa28EKeSrLY.17bPBgjuPWcLQOFqKgfc68AFHUTlsIm', 0, 1, '', ''),
(6, '', '', '', '', '', '', 'admin', 'johnbryantisado@gmail.com', '$2y$10$l9a3HkP9JQSDJQiLK6OsDu8JRHWS81STCALIZs.3z8RGJcDAP6/B.', 715886, 0, '', ''),
(10, '', '', '', '', '', '', 'aaron', 'invogaming715@gmail.com', '$2y$10$yfBbNmN8TLNeDCgi5KWhgumLCn4HIsbnDxS2yMoAb0WYiu6W5Ip.K', 0, 1, '', ''),
(11, '', '', '', '', '', '', 'bryan', 'johnbryantisado@gmail.com', '$2y$10$8LyUiEVZoE4zUy.t/GOBKe70QLUY6S6.w8AwaqEGYzahRIDNWmG2C', 0, 1, '', ''),
(12, 'sfas', 'asfa', 'sfaf', 'asf', '09508876543', 'Male', 'john', 'asf@gmail.com', '$2y$10$v8.QjnCEXJw7/ReShV6EpOKOMT1.qQ7zv/Wo72vFjTg/xy1.8KM5S', 0, 1, 'user.png', '2024-06-04');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_ID`);

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
-- AUTO_INCREMENT for table `schedule_list`
--
ALTER TABLE `schedule_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

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
