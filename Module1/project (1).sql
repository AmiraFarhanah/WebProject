-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 20, 2023 at 10:48 AM
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
-- Database: `project`
--

-- --------------------------------------------------------

--
-- Table structure for table `administrator`
--

CREATE TABLE `administrator` (
  `ID` int(11) NOT NULL,
  `Username` varchar(10) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Password` varchar(20) NOT NULL,
  `Address` varchar(255) NOT NULL,
  `Phonenumber` varchar(13) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `Usergroup` varchar(20) NOT NULL,
  `Qrcode` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `administrator`
--

INSERT INTO `administrator` (`ID`, `Username`, `Name`, `Password`, `Address`, `Phonenumber`, `Email`, `Usergroup`, `Qrcode`) VALUES
(1, 'CD99999', 'Spongbob', '12341234', 'No 123, Taman Durian', '0999999999', '345@gmail.com', 'Administrator', '');

-- --------------------------------------------------------

--
-- Table structure for table `food_vendor`
--

CREATE TABLE `food_vendor` (
  `ID` int(11) NOT NULL,
  `Username` varchar(20) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Password` varchar(20) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Address` varchar(255) NOT NULL,
  `Phonenumber` varchar(13) NOT NULL,
  `Usergroup` varchar(20) NOT NULL,
  `Status` varchar(10) NOT NULL DEFAULT 'Pending',
  `Qrcode` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `food_vendor`
--

INSERT INTO `food_vendor` (`ID`, `Username`, `Name`, `Password`, `Email`, `Address`, `Phonenumber`, `Usergroup`, `Status`, `Qrcode`) VALUES
(1, 'cv12345', 'mike', '11111111', '1231@hotmail.com', 'no.333 taman moras', '01523451124', 'Food Vendor', 'Pending', ''),
(2, '111qqq', 'mandy', '1111', '1111', '11111', '11111', 'Food Vendor', 'Approved', '');

-- --------------------------------------------------------

--
-- Table structure for table `registered_user`
--

CREATE TABLE `registered_user` (
  `ID` int(100) NOT NULL,
  `Username` varchar(10) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Password` varchar(30) NOT NULL,
  `Address` varchar(255) NOT NULL,
  `Phonenumber` varchar(13) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `Usergroup` varchar(20) NOT NULL,
  `Qrcode` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `registered_user`
--

INSERT INTO `registered_user` (`ID`, `Username`, `Name`, `Password`, `Address`, `Phonenumber`, `Email`, `Usergroup`, `Qrcode`) VALUES
(6, 'CT12345', 'Nicholas Tan', '22223333', 'no.1211taman arcana moras', '0172341234', '', 'Normal User', ''),
(14, 'qqq', '111', '111', '111', '111', '111', 'Normal User', '<img src= \"https://api.qrserver.com/v1/create-qr-code/?data=111&size=100x100\">');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `administrator`
--
ALTER TABLE `administrator`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `food_vendor`
--
ALTER TABLE `food_vendor`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `registered_user`
--
ALTER TABLE `registered_user`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `administrator`
--
ALTER TABLE `administrator`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `food_vendor`
--
ALTER TABLE `food_vendor`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `registered_user`
--
ALTER TABLE `registered_user`
  MODIFY `ID` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
