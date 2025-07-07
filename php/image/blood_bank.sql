-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 22, 2025 at 07:19 AM
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
-- Database: `blood_bank`
--

-- --------------------------------------------------------

--
-- Table structure for table `connect_requests`
--

CREATE TABLE `connect_requests` (
  `id` int(11) NOT NULL,
  `requester_id` int(11) NOT NULL,
  `recipient_id` int(11) NOT NULL,
  `status` enum('pending','accepted','rejected') DEFAULT 'pending',
  `request_time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `connect_requests`
--

INSERT INTO `connect_requests` (`id`, `requester_id`, `recipient_id`, `status`, `request_time`) VALUES
(1, 1, 1, 'accepted', '2025-04-22 05:10:53'),
(2, 1, 1, 'accepted', '2025-04-22 05:12:42'),
(3, 1, 1, 'accepted', '2025-04-22 05:15:48'),
(4, 1, 2, 'pending', '2025-04-22 05:16:18');

-- --------------------------------------------------------

--
-- Table structure for table `donor`
--

CREATE TABLE `donor` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `blood_group` varchar(10) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `city` varchar(50) NOT NULL,
  `dob` date NOT NULL,
  `last_donation_date` date NOT NULL,
  `registration_time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `donor`
--

INSERT INTO `donor` (`id`, `name`, `email`, `password`, `blood_group`, `phone`, `city`, `dob`, `last_donation_date`, `registration_time`) VALUES
(1, 'Piyush', 'piyush@gmail.com', '$2y$10$HiJz1gcKL6tkEjNxD.IQ9uSUSJncpUBTLFs5rTIIVqKeQpgy.vGbe', 'B+', '8421862562', 'nashik', '2005-11-05', '2025-04-17', '2025-04-22 05:09:44'),
(2, 'Nikita', 'nmore8147@gmail.com', '$2y$10$fwyn3oC8TAQa6Iz3IRuoi.k6Ilb.pov9iR8omdB6mInv3eN8AT6FS', 'B+', '2564265862', 'nashik', '2005-11-17', '2025-04-17', '2025-04-22 05:12:13');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `connect_requests`
--
ALTER TABLE `connect_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `requester_id` (`requester_id`),
  ADD KEY `recipient_id` (`recipient_id`);

--
-- Indexes for table `donor`
--
ALTER TABLE `donor`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `connect_requests`
--
ALTER TABLE `connect_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `donor`
--
ALTER TABLE `donor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `connect_requests`
--
ALTER TABLE `connect_requests`
  ADD CONSTRAINT `connect_requests_ibfk_1` FOREIGN KEY (`requester_id`) REFERENCES `donor` (`id`),
  ADD CONSTRAINT `connect_requests_ibfk_2` FOREIGN KEY (`recipient_id`) REFERENCES `donor` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
