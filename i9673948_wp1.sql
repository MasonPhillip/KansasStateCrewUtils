-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 15, 2023 at 08:16 AM
-- Server version: 10.6.14-MariaDB-cll-lve
-- PHP Version: 8.1.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `i9673948_wp1`
--

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `ID` int(11) NOT NULL,
  `userID` int(11) DEFAULT NULL,
  `videoID` int(11) DEFAULT NULL,
  `comment` varchar(256) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`ID`, `userID`, `videoID`, `comment`) VALUES
(1, 1, 4, 'test Comment'),
(2, 3, 4, 'AJ Test Comment'),
(3, 1, 5, 'Chloe Test'),
(4, 5, 6, 'ywsf'),
(5, 1, 7, 'ywsf'),
(6, 1, 8, 'ywsf'),
(7, 1, 9, 'a'),
(8, 1, 10, 'a'),
(9, 1, 11, 'ywsf'),
(10, 1, 12, '3'),
(11, 1, 13, 't'),
(12, 1, 14, 't'),
(13, 1, 15, 't'),
(14, 1, 16, '2'),
(15, 1, 17, 'r'),
(16, 1, 18, 'r'),
(17, 1, 19, 'r'),
(18, 1, 20, 'r'),
(19, 1, 21, 'r'),
(20, 1, 22, 'r'),
(21, 1, 23, 'r'),
(22, 1, 24, 'fdhigujas'),
(23, 1, 25, 'w'),
(24, 1, 26, 'w'),
(25, 1, 27, 'masons night sprint'),
(26, 1, 28, ''),
(27, 1, 29, ''),
(28, 1, 30, ''),
(29, 1, 31, ''),
(30, 1, 32, ''),
(31, 1, 33, ''),
(32, 1, 34, 'c'),
(33, 1, 27, 'reply test'),
(34, 1, 27, 'test 1'),
(35, 2, 27, 'As a coach I think ___'),
(36, 2, 27, 'testing enter button func'),
(37, 1, 27, 'update comment date now'),
(38, 1, 27, 'now it should update the comment'),
(39, 1, 27, 'changed to show timestamp'),
(40, 1, 27, 'shoudl update discord now'),
(41, 2, 27, 'Commenting '),
(42, 1, 37, 'test'),
(43, 1, 38, 'test');

-- --------------------------------------------------------

--
-- Table structure for table `teams`
--

CREATE TABLE `teams` (
  `ID` int(11) NOT NULL,
  `name` varchar(45) NOT NULL,
  `webhook` varchar(255) NOT NULL,
  `code` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `teams`
--

INSERT INTO `teams` (`ID`, `name`, `webhook`, `code`) VALUES
(1, 'Kansas State Crew', 'https://discord.com/api/webhooks/1173034151683837962/Z0IBBo381LVHnhtggorbBjOOnOisbSvVX3_TRFP95fA0RTjeAQEyXKDtoZ9tT7ZnFaeE', 'catson3'),
(3, 'Manhattan Junior Crew', 'hold', 'purple'),
(4, 'Manhattan Junior Crew', 'hold', 'purple');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `ID` int(11) NOT NULL,
  `name` varchar(45) DEFAULT NULL,
  `discordHandle` varchar(45) DEFAULT NULL,
  `password` varchar(45) DEFAULT NULL,
  `teamID` int(11) NOT NULL,
  `email` varchar(45) NOT NULL,
  `c2AuthorizationCode` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`ID`, `name`, `discordHandle`, `password`, `teamID`, `email`, `c2AuthorizationCode`) VALUES
(1, 'Mason', 'mason0815', 'a', 1, '', 'fqGGYSDckIfWpYvwXeI1ftUevP5rpb4TID16CxaP'),
(2, 'Wesley', 'shalendar', 'b', 1, '', ''),
(3, 'AJ', 'tragichero1', 'c', 1, '', ''),
(4, 'Derrick', 'mr_d_man', 'd', 1, '', ''),
(5, 'Chloe', 'chloemoran', 'e', 1, '', ''),
(6, 'Kenzie', 'Kenzie Davis#0543', 'f', 1, '', ''),
(7, 'Katie', 'sushirollsout', 'g', 1, '', ''),
(8, 'Megan', 'meganpaulsen', 'h', 1, '', ''),
(9, 'Will', 'wilfer2', 'i', 1, '', ''),
(10, 'test', 'test', 'test', 2, '', '');

-- --------------------------------------------------------

--
-- Table structure for table `videos`
--

CREATE TABLE `videos` (
  `ID` int(11) NOT NULL,
  `url` varchar(255) DEFAULT NULL,
  `videoTitle` varchar(45) DEFAULT NULL,
  `createdByUserID` int(11) DEFAULT NULL,
  `lastCommentDate` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `videos`
--

INSERT INTO `videos` (`ID`, `url`, `videoTitle`, `createdByUserID`, `lastCommentDate`) VALUES
(1, 'https://drive.google.com/file/d/1BpN0p-185FUVuwBROrPkr3qGY1--4cNc/view?usp=sharing', '4 Test video', 1, '2023-11-12 07:00:00'),
(27, 'https://drive.google.com/file/d/13eXdLVpLGGkdRypnhWuGn0SAXOMSVhez', 'I did this bad', 1, '2023-12-06 00:49:20'),
(35, 'na', 'mjc test', 10, '2023-12-10 19:41:42'),
(36, 'na', 'mjc test', 10, '2023-12-10 19:41:45'),
(37, 'https://drive.google.com/file/d/18xuob7tdiGU4RXbPktpZRi5SykGX1WUY/', 'Video 1', 1, '2023-12-14 20:00:06'),
(38, 'https://drive.google.com/file/d/18moQFbwxmy3JCYcpZHSLy3YXNtvweBWO/', 'Video 1', 1, '2023-12-14 20:01:10');

-- --------------------------------------------------------

--
-- Table structure for table `webhooks`
--

CREATE TABLE `webhooks` (
  `ID` int(11) NOT NULL,
  `webhook` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `webhooks`
--

INSERT INTO `webhooks` (`ID`, `webhook`) VALUES
(1, 'https://discord.com/api/webhooks/1173034151683837962/Z0IBBo381LVHnhtggorbBjOOnOisbSvVX3_TRFP95fA0RTjeAQEyXKDtoZ9tT7ZnFaeE');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `userID` (`userID`);

--
-- Indexes for table `teams`
--
ALTER TABLE `teams`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `name` (`name`),
  ADD KEY `teamID` (`teamID`);

--
-- Indexes for table `videos`
--
ALTER TABLE `videos`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `createdByUserID` (`createdByUserID`);

--
-- Indexes for table `webhooks`
--
ALTER TABLE `webhooks`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `teams`
--
ALTER TABLE `teams`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `videos`
--
ALTER TABLE `videos`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `webhooks`
--
ALTER TABLE `webhooks`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `users` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `videos`
--
ALTER TABLE `videos`
  ADD CONSTRAINT `videos_ibfk_1` FOREIGN KEY (`createdByUserID`) REFERENCES `users` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
