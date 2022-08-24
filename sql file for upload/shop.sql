-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 24, 2022 at 05:24 PM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `shop`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `ID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Description` text NOT NULL,
  `Ordering` int(11) DEFAULT NULL,
  `Visibility` tinyint(4) NOT NULL DEFAULT 0,
  `Allow_Comment` tinyint(4) NOT NULL DEFAULT 0,
  `Allow_Ads` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`ID`, `Name`, `Description`, `Ordering`, `Visibility`, `Allow_Comment`, `Allow_Ads`) VALUES
(1, 'phones', 'contain all types of phones', 0, 0, 0, 0),
(14, 'books', 'contain all types of books', 0, 0, 0, 0),
(15, 'computers', 'computers', 0, 0, 0, 0),
(16, 'Hand Made', 'Hand Made', 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `C_ID` int(11) NOT NULL,
  `Comment` text NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `comment_date` date NOT NULL,
  `item_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`C_ID`, `Comment`, `status`, `comment_date`, `item_id`, `user_id`) VALUES
(5, 'this is good product', 1, '2022-08-02', 17, 21),
(8, 'this sold.', 1, '2022-08-02', 12, 9);

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `item_ID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Description` text NOT NULL,
  `Price` varchar(255) NOT NULL,
  `Add_Date` date NOT NULL,
  `Country_Made` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `Status` varchar(255) NOT NULL,
  `Rating` smallint(6) NOT NULL,
  `Approve` tinyint(4) NOT NULL DEFAULT 0,
  `Cat_ID` int(11) NOT NULL,
  `Member_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`item_ID`, `Name`, `Description`, `Price`, `Add_Date`, `Country_Made`, `image`, `Status`, `Rating`, `Approve`, `Cat_ID`, `Member_ID`) VALUES
(12, '11 pro', '11 pro', '$900', '2022-07-31', 'USA', '', '1', 0, 1, 1, 9),
(13, '13 pro', '13 pro', '$1000', '2022-07-31', 'USA', '', '1', 4, 1, 1, 9),
(14, 's22 plus', 's22 plus', '$1220', '2022-07-31', 'USA', '', '1', 0, 1, 1, 9),
(15, 'rtx 2060', 'rtx 2060', '$350', '2022-07-31', 'USA', '', '1', 0, 1, 15, 9),
(16, 'mi 11 ultra', 'mi 11 ultra', '$625', '2022-07-31', 'USA', '', '1', 0, 1, 1, 9),
(17, 'asus ', 'asus rog ', '$950', '2022-07-31', 'USA', '', '1', 0, 1, 1, 10),
(18, 's10 plus', 's10 plus', '$350', '2022-08-01', 'USA', '', '2', 0, 1, 1, 1),
(19, 's21 ultra', 's21 ultra', '$900', '2022-08-01', 'USA', '', '3', 0, 1, 1, 9);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `UserID` int(11) NOT NULL,
  `Username` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `FullName` varchar(255) NOT NULL,
  `GroupID` int(11) NOT NULL DEFAULT 0,
  `TrustStatus` int(11) NOT NULL DEFAULT 0,
  `RegStatus` int(11) NOT NULL DEFAULT 0,
  `Date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`UserID`, `Username`, `Password`, `Email`, `FullName`, `GroupID`, `TrustStatus`, `RegStatus`, `Date`) VALUES
(1, 'ahmednegm', '934b535800b1cba8f96a5d72f72f1611', 'ahmed@negm.co', 'ahmed gamal negm El-din', 1, 0, 1, NULL),
(9, 'adham', '202cb962ac59075b964b07152d234b70', 'adham@sa.com', 'saas sssa', 0, 0, 1, '2022-07-10'),
(10, 'ahmed', '0d455b3148655db6c59098295f2c7322', 'ahmed@negm.co', 'ahmed  negm El-din', 0, 0, 1, '2022-07-10'),
(11, 'ismail', 'e2677fedb06808cf1f70da0464986d7d', 'ismail@lol.sa', 'ismailahmed', 0, 0, 1, '2022-07-12'),
(19, 'lolo', '23d2eaee18a8a094b771f4628640766c', 'lol@lol.sa', 'lol ahmed', 0, 0, 1, '2022-07-31'),
(21, 'sayeddd', '202cb962ac59075b964b07152d234b70', 'sasa@lol.sa', 'sasa sa sa sa', 0, 0, 1, '2022-07-31');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `Name` (`Name`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`C_ID`),
  ADD KEY `item_1` (`item_id`),
  ADD KEY `user_1` (`user_id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`item_ID`),
  ADD KEY `cat_1` (`Cat_ID`),
  ADD KEY `member_1` (`Member_ID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`UserID`),
  ADD UNIQUE KEY `Username` (`Username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `C_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `item_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `item_1` FOREIGN KEY (`item_id`) REFERENCES `items` (`item_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `items`
--
ALTER TABLE `items`
  ADD CONSTRAINT `cat_1` FOREIGN KEY (`Cat_ID`) REFERENCES `categories` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `member_1` FOREIGN KEY (`Member_ID`) REFERENCES `users` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
