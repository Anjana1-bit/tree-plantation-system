-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 01, 2026 at 11:02 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tree_plantation_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `growth_records`
--

CREATE TABLE `growth_records` (
  `growth_id` int(11) NOT NULL,
  `tree_id` int(11) NOT NULL,
  `measurement_date` date NOT NULL,
  `height_cm` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `locations`
--

CREATE TABLE `locations` (
  `location_id` int(11) NOT NULL,
  `location_name` varchar(150) NOT NULL,
  `city` varchar(100) DEFAULT NULL,
  `area_type` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `locations`
--

INSERT INTO `locations` (`location_id`, `location_name`, `city`, `area_type`) VALUES
(1, 'Marine Drive', 'Kochi', 'Urban'),
(2, 'City Park', 'Kochi', 'Urban'),
(4, 'Hilltop Forest Area', 'Wayanad', 'Rural'),
(5, 'School Campus', 'Ernakulam', 'Institution'),
(6, 'River Side Area', 'Aluva', 'Semi-Urban');

-- --------------------------------------------------------

--
-- Table structure for table `maintenance_records`
--

CREATE TABLE `maintenance_records` (
  `maintenance_id` int(11) NOT NULL,
  `tree_id` int(11) DEFAULT NULL,
  `volunteer_id` int(11) DEFAULT NULL,
  `maintenance_date` date DEFAULT NULL,
  `activity_type` varchar(150) DEFAULT NULL,
  `remarks` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `plantation_events`
--

CREATE TABLE `plantation_events` (
  `event_id` int(11) NOT NULL,
  `event_name` varchar(150) NOT NULL,
  `event_date` date NOT NULL,
  `location_id` int(11) DEFAULT NULL,
  `organized_by` varchar(150) DEFAULT NULL,
  `total_trees_planted` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `trees`
--

CREATE TABLE `trees` (
  `tree_id` int(11) NOT NULL,
  `species` varchar(100) NOT NULL,
  `plantation_date` date NOT NULL,
  `event_id` int(11) DEFAULT NULL,
  `volunteer_id` int(11) DEFAULT NULL,
  `survival_status` enum('Alive','Dead') DEFAULT 'Alive',
  `height_cm` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tree_status_log`
--

CREATE TABLE `tree_status_log` (
  `log_id` int(11) NOT NULL,
  `tree_id` int(11) DEFAULT NULL,
  `old_status` enum('Alive','Dead') DEFAULT NULL,
  `new_status` enum('Alive','Dead') DEFAULT NULL,
  `change_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','coordinator') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `name`, `email`, `password`, `role`, `created_at`) VALUES
(1, 'Admin', 'admin@gmail.com', 'admin123', 'admin', '2026-03-01 07:53:56');

-- --------------------------------------------------------

--
-- Table structure for table `volunteers`
--

CREATE TABLE `volunteers` (
  `volunteer_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `join_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `volunteers`
--

INSERT INTO `volunteers` (`volunteer_id`, `name`, `email`, `phone`, `join_date`) VALUES
(1, 'Anu', 'anu@gmail.com', '5376327897', '2026-03-13');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `growth_records`
--
ALTER TABLE `growth_records`
  ADD PRIMARY KEY (`growth_id`),
  ADD KEY `fk_growth_tree` (`tree_id`);

--
-- Indexes for table `locations`
--
ALTER TABLE `locations`
  ADD PRIMARY KEY (`location_id`);

--
-- Indexes for table `maintenance_records`
--
ALTER TABLE `maintenance_records`
  ADD PRIMARY KEY (`maintenance_id`),
  ADD KEY `volunteer_id` (`volunteer_id`),
  ADD KEY `fk_maintenance_tree` (`tree_id`);

--
-- Indexes for table `plantation_events`
--
ALTER TABLE `plantation_events`
  ADD PRIMARY KEY (`event_id`),
  ADD KEY `fk_event_location` (`location_id`);

--
-- Indexes for table `trees`
--
ALTER TABLE `trees`
  ADD PRIMARY KEY (`tree_id`),
  ADD KEY `fk_tree_event` (`event_id`),
  ADD KEY `fk_tree_volunteer` (`volunteer_id`);

--
-- Indexes for table `tree_status_log`
--
ALTER TABLE `tree_status_log`
  ADD PRIMARY KEY (`log_id`),
  ADD KEY `fk_status_tree` (`tree_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `volunteers`
--
ALTER TABLE `volunteers`
  ADD PRIMARY KEY (`volunteer_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `growth_records`
--
ALTER TABLE `growth_records`
  MODIFY `growth_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `locations`
--
ALTER TABLE `locations`
  MODIFY `location_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `maintenance_records`
--
ALTER TABLE `maintenance_records`
  MODIFY `maintenance_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `plantation_events`
--
ALTER TABLE `plantation_events`
  MODIFY `event_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `trees`
--
ALTER TABLE `trees`
  MODIFY `tree_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tree_status_log`
--
ALTER TABLE `tree_status_log`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `volunteers`
--
ALTER TABLE `volunteers`
  MODIFY `volunteer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `growth_records`
--
ALTER TABLE `growth_records`
  ADD CONSTRAINT `fk_growth_tree` FOREIGN KEY (`tree_id`) REFERENCES `trees` (`tree_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `growth_records_ibfk_1` FOREIGN KEY (`tree_id`) REFERENCES `trees` (`tree_id`) ON DELETE CASCADE;

--
-- Constraints for table `maintenance_records`
--
ALTER TABLE `maintenance_records`
  ADD CONSTRAINT `fk_maintenance_tree` FOREIGN KEY (`tree_id`) REFERENCES `trees` (`tree_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `maintenance_records_ibfk_1` FOREIGN KEY (`tree_id`) REFERENCES `trees` (`tree_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `maintenance_records_ibfk_2` FOREIGN KEY (`volunteer_id`) REFERENCES `volunteers` (`volunteer_id`) ON DELETE SET NULL;

--
-- Constraints for table `plantation_events`
--
ALTER TABLE `plantation_events`
  ADD CONSTRAINT `fk_event_location` FOREIGN KEY (`location_id`) REFERENCES `locations` (`location_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `plantation_events_ibfk_1` FOREIGN KEY (`location_id`) REFERENCES `locations` (`location_id`) ON DELETE SET NULL;

--
-- Constraints for table `trees`
--
ALTER TABLE `trees`
  ADD CONSTRAINT `fk_tree_event` FOREIGN KEY (`event_id`) REFERENCES `plantation_events` (`event_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_tree_volunteer` FOREIGN KEY (`volunteer_id`) REFERENCES `volunteers` (`volunteer_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `trees_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `plantation_events` (`event_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `trees_ibfk_2` FOREIGN KEY (`volunteer_id`) REFERENCES `volunteers` (`volunteer_id`) ON DELETE SET NULL;

--
-- Constraints for table `tree_status_log`
--
ALTER TABLE `tree_status_log`
  ADD CONSTRAINT `fk_status_tree` FOREIGN KEY (`tree_id`) REFERENCES `trees` (`tree_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tree_status_log_ibfk_1` FOREIGN KEY (`tree_id`) REFERENCES `trees` (`tree_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
