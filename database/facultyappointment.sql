-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 20, 2024 at 05:34 AM
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
  `mname` varchar(100) NOT NULL,
  `lname` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_ID`, `fname`, `mname`, `lname`, `username`, `email`, `password`) VALUES
(1, 'Jersey', '', 'Franes', 'Admin', 'admin@gmail.com', 'Admin123');

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `id` int(11) NOT NULL,
  `user_ID` int(11) NOT NULL,
  `faculty_ID` int(11) NOT NULL,
  `appointment_name` varchar(255) NOT NULL,
  `notes` text NOT NULL,
  `appointment_date` date NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appointments`
--

INSERT INTO `appointments` (`id`, `user_ID`, `faculty_ID`, `appointment_name`, `notes`, `appointment_date`, `start_time`, `end_time`, `created_at`, `status`) VALUES
(5, 22, 4, 'asda', 'sdadas', '2024-06-20', '11:31:00', '12:32:00', '2024-06-20 03:31:21', 0);

-- --------------------------------------------------------

--
-- Table structure for table `declined_appointments`
--

CREATE TABLE `declined_appointments` (
  `d_ID` int(11) NOT NULL,
  `id` int(11) NOT NULL,
  `user_ID` int(11) NOT NULL,
  `faculty_ID` int(11) NOT NULL,
  `notes` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `archive` int(11) NOT NULL,
  `reset_otp` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `faculty`
--

INSERT INTO `faculty` (`faculty_ID`, `fname`, `mname`, `lname`, `address`, `contact_number`, `gender`, `bday`, `profile`, `email`, `pass`, `archive`, `reset_otp`) VALUES
(4, 'bry', 'bry', 'bry', 'bry', '09878654567', 'Male', '07/03/2002', 'user.png', 'sadasdd@gmail.com', 'asd123', 0, 11111);

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
  `archive` int(11) NOT NULL,
  `reset_otp` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_ID`, `u_fname`, `u_mname`, `u_lname`, `address`, `contact_number`, `gender`, `u_username`, `u_email`, `u_pass`, `otp`, `status`, `profile`, `bday`, `archive`, `reset_otp`) VALUES
(22, 'jake', 'asfa', 'asdad', 'fsdfsf', '09876789098', 'Male', 'asd123', 'admin@gmail.com', '$2y$10$xcdBODSoHyPiSREJq2MMUuAzH3GxpaVE6DyKtZuFqRN7bQZKWf.qO', 0, 1, 'user.png', '2024-06-06', 0, 0);

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
  ADD PRIMARY KEY (`id`),
  ADD KEY `faculty_ID` (`faculty_ID`),
  ADD KEY `user_ID` (`user_ID`);

--
-- Indexes for table `declined_appointments`
--
ALTER TABLE `declined_appointments`
  ADD KEY `id` (`id`),
  ADD KEY `faculty_ID` (`faculty_ID`),
  ADD KEY `user_ID` (`user_ID`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `faculty`
--
ALTER TABLE `faculty`
  MODIFY `faculty_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `schedule_list`
--
ALTER TABLE `schedule_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `appointments`
--
ALTER TABLE `appointments`
  ADD CONSTRAINT `appointments_ibfk_1` FOREIGN KEY (`faculty_ID`) REFERENCES `faculty` (`faculty_ID`),
  ADD CONSTRAINT `appointments_ibfk_2` FOREIGN KEY (`user_ID`) REFERENCES `users` (`user_ID`);

--
-- Constraints for table `declined_appointments`
--
ALTER TABLE `declined_appointments`
  ADD CONSTRAINT `declined_appointments_ibfk_1` FOREIGN KEY (`id`) REFERENCES `appointments` (`id`),
  ADD CONSTRAINT `declined_appointments_ibfk_2` FOREIGN KEY (`faculty_ID`) REFERENCES `faculty` (`faculty_ID`),
  ADD CONSTRAINT `declined_appointments_ibfk_3` FOREIGN KEY (`user_ID`) REFERENCES `users` (`user_ID`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`status`) REFERENCES `status` (`status_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
