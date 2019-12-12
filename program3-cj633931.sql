-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 11, 2019 at 10:53 PM
-- Server version: 10.4.8-MariaDB
-- PHP Version: 7.3.10

CREATE DATABASE IF NOT EXISTS program3cj633931;
USE program3cj633931;

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `program3-cj633931`
--

-- --------------------------------------------------------

--
-- Table structure for table `hands`
--

CREATE TABLE `hands` (
  `handID` int(11) NOT NULL,
  `profileID` int(11) NOT NULL,
  `bet` int(11) NOT NULL,
  `hits` int(11) NOT NULL,
  `bust` tinyint(1) NOT NULL DEFAULT 0,
  `win` tinyint(1) DEFAULT NULL COMMENT 'NULL could mean a tie.',
  `winnings` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `hands`
--

INSERT INTO `hands` (`handID`, `profileID`, `bet`, `hits`, `bust`, `win`, `winnings`) VALUES
(12, 2, 5, 0, 0, 1, 5),
(13, 2, 5, 0, 0, 0, -5),
(14, 2, 5, 0, 0, 0, -5),
(15, 2, 5, 0, 0, 0, -5),
(16, 2, 5, 0, 0, 0, -5),
(17, 2, 5, 1, 0, 1, 5),
(18, 2, 5, 1, 0, 0, -5),
(19, 2, 5, 4, 0, 0, -5),
(20, 2, 5, 4, 0, 0, -5),
(21, 2, 5, 1, 0, 0, -5),
(22, 2, 5, 1, 1, 0, -5),
(23, 2, 5, 0, 0, 1, 8),
(24, 2, 5, 0, 0, 1, 5),
(25, 2, 5, 1, 0, 0, -5),
(26, 3, 3, 1, 0, 1, 3),
(27, 3, 14, 1, 0, 1, 14),
(28, 3, 8, 0, 0, 0, -8),
(29, 3, 4, 2, 0, 0, -4),
(30, 2, 7, 0, 0, 0, -7),
(31, 4, 7, 0, 0, 0, -7),
(32, 4, 3, 0, 0, 1, 3);

-- --------------------------------------------------------

--
-- Table structure for table `profiles`
--

CREATE TABLE `profiles` (
  `ID` int(11) NOT NULL,
  `fName` varchar(20) NOT NULL,
  `lName` varchar(20) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(200) NOT NULL,
  `money` int(11) NOT NULL,
  `session` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `profiles`
--

INSERT INTO `profiles` (`ID`, `fName`, `lName`, `username`, `password`, `money`, `session`) VALUES
(2, 'Katie', 'Kat', 'KatieKat', '$2y$10$U3suyaCJoZChkXvG2srRhu27jTQCNCz6rH02ePZxnmNqc65qgsxym', 976, NULL),
(3, 'Chase', 'Jenkins', 'cjenkins2018', '$2y$10$RckTVyqbbVkNTwjI7EPQtO.q1QUNQPyJKk7Buc/7vorNg4dWLVjkO', 1005, NULL),
(4, 'Timmy', 'Tim', 'TimmyTim', '$2y$10$n/X4JBBdo2eczKEtxnsyfenRbB9dS/Aam/GcY66eBddhPidB5EDJy', 996, '81p81fa1ce2r80pjitoo0j3kc6');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `hands`
--
ALTER TABLE `hands`
  ADD PRIMARY KEY (`handID`);

--
-- Indexes for table `profiles`
--
ALTER TABLE `profiles`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `hands`
--
ALTER TABLE `hands`
  MODIFY `handID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `profiles`
--
ALTER TABLE `profiles`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
