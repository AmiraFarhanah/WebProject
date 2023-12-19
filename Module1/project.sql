-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 18, 2023 at 03:50 AM
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
  `Administrator_Username` varchar(10) NOT NULL,
  `Administrator_Name` varchar(255) NOT NULL,
  `Administrator_Password` varchar(20) NOT NULL,
  `Administrator_Address` varchar(255) NOT NULL,
  `Administrator_PhoneNum` varchar(13) NOT NULL,
  `Administrator_EmailAddress` varchar(50) NOT NULL,
  `Usergroup` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `administrator`
--

INSERT INTO `administrator` (`ID`, `Administrator_Username`, `Administrator_Name`, `Administrator_Password`, `Administrator_Address`, `Administrator_PhoneNum`, `Administrator_EmailAddress`, `Usergroup`) VALUES
(1, 'CD99999', 'Spongbob', '12341234', 'No 123, Taman Durian', '0999999999', '345@gmail.com', 'Administrator');

-- --------------------------------------------------------

--
-- Table structure for table `food_vendor`
--

CREATE TABLE `food_vendor` (
  `Vendor_ID` int(11) NOT NULL,
  `Vendor_Username` varchar(20) NOT NULL,
  `Vendor_Name` varchar(255) NOT NULL,
  `Vendor_Password` varchar(20) NOT NULL,
  `Vendor_Email` varchar(100) NOT NULL,
  `Vendor_Address` varchar(255) NOT NULL,
  `Vendor_PhoneNum` varchar(13) NOT NULL,
  `Usergroup` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `food_vendor`
--

INSERT INTO `food_vendor` (`Vendor_ID`, `Vendor_Username`, `Vendor_Name`, `Vendor_Password`, `Vendor_Email`, `Vendor_Address`, `Vendor_PhoneNum`, `Usergroup`) VALUES
(1, 'cv12345', 'mike', '11111111', '1231@hotmail.com', 'no.333 taman moras', '01523451124', 'Food Vendor');

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
  `Usergroup` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `registered_user`
--

INSERT INTO `registered_user` (`ID`, `Username`, `Name`, `Password`, `Address`, `Phonenumber`, `Email`, `Usergroup`) VALUES
(6, 'CT12345', 'Nicholas Tan', '22223333', 'no.1211taman arcana', '0172341234', '', 'Normal User'),
(7, 'nn14443', 'mike', '123131321', '131231', '13131', '', 'Food Vendor');

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
  ADD PRIMARY KEY (`Vendor_ID`);

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
  MODIFY `Vendor_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `registered_user`
--
ALTER TABLE `registered_user`
  MODIFY `ID` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
