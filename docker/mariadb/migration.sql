-- phpMyAdmin SQL Dump
-- version 4.6.6
-- https://www.phpmyadmin.net/
--
-- Host: db
-- Generation Time: Oct 21, 2019 at 04:49 PM
-- Server version: 10.3.12-MariaDB-1:10.3.12+maria~bionic
-- PHP Version: 7.0.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `lempdb`
--
CREATE DATABASE IF NOT EXISTS `lempdb` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `lempdb`;

-- --------------------------------------------------------

--
-- Table structure for table `esp8266`
--

CREATE TABLE `esp8266` (
  `uniqid` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `sensorTemp` float NOT NULL,
  `fanSpeedPercent` float NOT NULL,
  `stamp` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `esp8266`
--

INSERT INTO `esp8266` (`uniqid`, `sensorTemp`, `fanSpeedPercent`, `stamp`) VALUES
('5dade112a7c09', 18, 100, '2019-10-21 23:47:14'),
('5dade115e9667', 17.8, 100, '2019-10-21 23:47:17'),
('5dade119a4113', 18.2, 100, '2019-10-21 23:47:21'),
('5dade11d94ad3', 17.6, 100, '2019-10-21 23:47:25'),
('5dade1249470f', 18, 100, '2019-10-21 23:47:32'),
('5dade1296d289', 17.4, 100, '2019-10-21 23:47:37'),
('5dade12cc80a7', 17.8, 100, '2019-10-21 23:47:40'),
('5dade12f20eef', 17.2, 100, '2019-10-21 23:47:43'),
('5dade1321d225', 17.6, 100, '2019-10-21 23:47:46'),
('5dade1350a133', 17, 100, '2019-10-21 23:47:49'),
('5dade137ce233', 17.4, 100, '2019-10-21 23:47:51'),
('5dade13c3d485', 16.8, 100, '2019-10-21 23:47:56'),
('5dade140e3ecd', 17.2, 100, '2019-10-21 23:48:00'),
('5dade144c96e3', 16.6, 100, '2019-10-21 23:48:04'),
('5dade149a8abb', 17, 100, '2019-10-21 23:48:09'),
('5dade14d378c5', 16.4, 100, '2019-10-21 23:48:13'),
('5dade1510b098', 16.8, 100, '2019-10-21 23:48:17'),
('5dade154c005c', 16.2, 100, '2019-10-21 23:48:20'),
('5dade1580a19f', 16.6, 100, '2019-10-21 23:48:24'),
('5dade15b39693', 16, 100, '2019-10-21 23:48:27');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_username` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `user_password` varchar(50) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_username`, `user_password`) VALUES
('root', 'rootpassword');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
