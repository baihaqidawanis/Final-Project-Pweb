-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 2024-12-11
-- Server version: 10.4.17-MariaDB
-- PHP Version: 7.3.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

-- Database: `sepakbola`

-- --------------------------------------------------------

-- Table structure for table `football_teams`
CREATE TABLE `football_teams` (
  `id` int(11) NOT NULL,
  `team_name` varchar(100) NOT NULL,
  `match_score` varchar(50) NOT NULL,
  `stadium` varchar(100) NOT NULL,
  `match_date` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Dumping data for table `football_teams`
INSERT INTO `football_teams` (`id`, `team_name`, `match_score`, `stadium`, `match_date`, `created_at`) VALUES
(1, 'Manchester United', '2-1', 'Old Trafford', '2024-12-01', '2024-12-01 10:00:00'),
(2, 'Barcelona', '3-0', 'Camp Nou', '2024-12-02', '2024-12-02 15:30:00'),
(3, 'Juventus', '1-1', 'Allianz Stadium', '2024-12-03', '2024-12-03 18:45:00'),
(4, 'Real Madrid', '2-0', 'Santiago Bernabeu', '2024-12-04', '2024-12-04 20:00:00');

-- Indexes for dumped tables

-- Indexes for table `football_teams`
ALTER TABLE `football_teams`
  ADD PRIMARY KEY (`id`);

-- AUTO_INCREMENT for dumped tables

-- AUTO_INCREMENT for table `football_teams`
ALTER TABLE `football_teams`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
