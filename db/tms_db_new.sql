-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 17, 2024 at 07:19 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tms_db_new`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_archive`
--

CREATE TABLE `tbl_archive` (
  `id` int(11) NOT NULL,
  `fname` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `mname` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `lname` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `emp_id_no` int(11) DEFAULT NULL,
  `dept` varchar(255) DEFAULT NULL,
  `contact` int(11) DEFAULT NULL,
  `age` int(11) DEFAULT NULL,
  `gender` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `stat` varchar(255) DEFAULT NULL,
  `sports` varchar(255) DEFAULT NULL,
  `team` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_dept`
--

CREATE TABLE `tbl_dept` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `details` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_dept`
--

INSERT INTO `tbl_dept` (`id`, `name`, `details`) VALUES
(1, 'Office of Student and Welfare Services', 'Tikang Kanda Babon ngadto liwat kanda Babon'),
(2, 'College of Hospitality and Tourism Management', 'Amon ngadto ira'),
(3, 'Administration and Finance', 'afawewqeqweqweqw'),
(4, 'Academic Affairs', 'dsfdsf'),
(5, 'College of Business and Accountancy', 'rewrew'),
(6, 'Office of the College Administrator', 'rewrewr'),
(7, 'Research Development and Community Extension Office', 'rew'),
(8, 'Institute of Graduate Studies', 'rew'),
(9, 'College of Computer Studies', 'testtt'),
(10, 'College of Hospitality and Tourism Management', 'testtt'),
(11, 'Office of the College President', 'testtt'),
(12, 'College of Allied Health Studies', 'testtt');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_employee`
--

CREATE TABLE `tbl_employee` (
  `id` int(11) NOT NULL,
  `fname` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `mname` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `lname` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `emp_id_no` int(11) DEFAULT NULL,
  `dept` varchar(255) DEFAULT NULL,
  `contact` varchar(11) DEFAULT NULL,
  `age` int(11) DEFAULT NULL,
  `gender` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `stat` varchar(255) DEFAULT NULL,
  `sports` varchar(255) DEFAULT NULL,
  `team` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_sports`
--

CREATE TABLE `tbl_sports` (
  `id` int(11) NOT NULL,
  `type` int(11) DEFAULT NULL,
  `emp_id` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `status` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_sports`
--

INSERT INTO `tbl_sports` (`id`, `type`, `emp_id`, `name`, `status`) VALUES
(1, NULL, NULL, 'Basketball', NULL),
(2, NULL, NULL, 'Badminton', NULL),
(3, NULL, NULL, 'Bowling', NULL),
(4, NULL, NULL, 'Chess', NULL),
(5, NULL, NULL, 'Laro ng Lahi', NULL),
(6, NULL, NULL, 'Mobile Legends', NULL),
(7, NULL, NULL, 'Triathlon', NULL),
(8, NULL, NULL, 'Taekwondo', NULL),
(9, NULL, NULL, 'Volleyball', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_support`
--

CREATE TABLE `tbl_support` (
  `id` int(11) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `email` varchar(60) DEFAULT NULL,
  `number` varchar(20) DEFAULT NULL,
  `subject` varchar(100) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `date` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_teams`
--

CREATE TABLE `tbl_teams` (
  `id` int(11) NOT NULL,
  `team_name` varchar(255) DEFAULT NULL,
  `team_color` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_teams`
--

INSERT INTO `tbl_teams` (`id`, `team_name`, `team_color`) VALUES
(1, 'Team Test 1', ''),
(2, 'Team Test 2', ''),
(3, 'Team Test 3', ''),
(4, 'Team Test 4', '');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_users`
--

CREATE TABLE `tbl_users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `user_type` varchar(255) DEFAULT NULL,
  `acc_name` varchar(255) DEFAULT NULL,
  `team_assigned` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_users`
--

INSERT INTO `tbl_users` (`id`, `username`, `password`, `user_type`, `acc_name`, `team_assigned`, `created_at`) VALUES
(11, 'admin', 'd033e22ae348aeb5660fc2140aec35850c4da997', 'administrator', 'Administrator', 'N/A', '2021-05-03 02:33:03'),
(44, 'Louise', '21bd12dc183f740ee76f27b78eb39c8ad972a757', 'administrator', 'Louise John Soria', NULL, '2024-01-17 02:45:01');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_archive`
--
ALTER TABLE `tbl_archive`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_dept`
--
ALTER TABLE `tbl_dept`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_employee`
--
ALTER TABLE `tbl_employee`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_sports`
--
ALTER TABLE `tbl_sports`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_support`
--
ALTER TABLE `tbl_support`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_teams`
--
ALTER TABLE `tbl_teams`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_users`
--
ALTER TABLE `tbl_users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_archive`
--
ALTER TABLE `tbl_archive`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_dept`
--
ALTER TABLE `tbl_dept`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `tbl_employee`
--
ALTER TABLE `tbl_employee`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_sports`
--
ALTER TABLE `tbl_sports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tbl_support`
--
ALTER TABLE `tbl_support`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_teams`
--
ALTER TABLE `tbl_teams`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_users`
--
ALTER TABLE `tbl_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
