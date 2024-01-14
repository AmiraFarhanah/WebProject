-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 13, 2024 at 06:05 AM
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
(1, 'CD99999', 'Spongbob', '12341234', 'No 123, Taman Durian', '0999999999', '345@gmail.com', 'Administrator', '<img src= \"https://api.qrserver.com/v1/create-qr-code/?data=Spongbob&size=100x100\">');

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
(1, 'cv12345', 'mike', '11111111', '1231@hotmail.com', 'no.333 taman moras', '01523451124', 'Food Vendor', 'Approved', ''),
(2, '111qqq', 'mandy', '1111', '1111', '11111', '11111', 'Food Vendor', 'Approved', ''),
(3, '131', '131', '131', '111', '111', '111', 'Food Vendor', 'Approved', '<img src= \"https://api.qrserver.com/v1/create-qr-code/?data=131&size=100x100\">'),
(42, 'FV23001 ', 'Teoh Woei Ming', '12345', 'woeimingteoh@gmail.com', '202,TAMAN DESA SERAYA, JALAN LENCONG BARAT', '+60109431351', 'Food Vendor', 'Approved', '<img src= \"https://api.qrserver.com/v1/create-qr-code/?data=Teoh Woei Ming&size=100x100\">');

-- --------------------------------------------------------

--
-- Table structure for table `in_storesale`
--

CREATE TABLE `in_storesale` (
  `InstoresaleID` int(11) NOT NULL,
  `Quantity` int(11) NOT NULL,
  `Menu_ID` int(11) NOT NULL,
  `Vendor_ID` int(11) NOT NULL,
  `Order_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `membership`
--

CREATE TABLE `membership` (
  `MembershipID` int(11) NOT NULL,
  `Membershipwallet` float NOT NULL,
  `Accumulatedpoint` int(11) NOT NULL,
  `Registereduser_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `ID` int(11) NOT NULL,
  `Foodname` varchar(200) NOT NULL,
  `FoodQuantity` int(11) NOT NULL,
  `FoodDescription` varchar(200) NOT NULL,
  `FoodStatus` int(1) NOT NULL,
  `FoodImage` varchar(255) DEFAULT NULL,
  `Username` varchar(20) NOT NULL,
  `Qrcode` varchar(100) NOT NULL,
  `FoodPrice` varchar(10) NOT NULL,
  `vendor_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`ID`, `Foodname`, `FoodQuantity`, `FoodDescription`, `FoodStatus`, `FoodImage`, `Username`, `Qrcode`, `FoodPrice`, `vendor_ID`) VALUES
(360, 'Nasi Goreng', 20, 'nasi goreng sangat sedap\r\n', 1, 'uploads/NasiLemak.png', 'FV23001 ', 'uploads/qrcodes/Nasi Lemak.png', '22', 42),
(362, 'Nasi Lemak123', 20, 'eiw', 1, 'uploadsNasiLemak.png', 'FV23001 ', 'uploads/qrcodes/Nasi Lemak123.png', '11', 42);

-- --------------------------------------------------------

--
-- Table structure for table `nonregistereduser`
--

CREATE TABLE `nonregistereduser` (
  `ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order`
--

CREATE TABLE `order` (
  `Order_ID` int(11) NOT NULL,
  `Orderdate` date NOT NULL,
  `Ordertime` time NOT NULL,
  `Orderstatus` varchar(20) NOT NULL,
  `Point` int(11) NOT NULL,
  `Register_ID` int(11) NOT NULL,
  `Guest_ID` int(11) NOT NULL,
  `Menu_ID` int(11) DEFAULT NULL,
  `vendor_ID` int(11) NOT NULL,
  `OrderQuantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order`
--

INSERT INTO `order` (`Order_ID`, `Orderdate`, `Ordertime`, `Orderstatus`, `Point`, `Register_ID`, `Guest_ID`, `Menu_ID`, `vendor_ID`, `OrderQuantity`) VALUES
(64, '2023-12-13', '07:25:21', 'completed', 11, 6, 0, 360, 42, 2),
(80, '2024-01-01', '07:25:21', 'prepared', 70, 6, 0, 359, 42, 3);

-- --------------------------------------------------------

--
-- Table structure for table `order_item`
--

CREATE TABLE `order_item` (
  `Orderitem_ID` int(11) NOT NULL,
  `Quantity` int(11) NOT NULL,
  `Menu_ID` int(11) NOT NULL,
  `Order_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `Payment_ID` int(11) NOT NULL,
  `Paymenttype` varchar(100) NOT NULL,
  `Totalpayment` float NOT NULL,
  `Order_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(14, 'qqq', 'Charlie Brown', '111', '111', '111', '111', 'Normal User', '<img src= \"https://api.qrserver.com/v1/create-qr-code/?data=Charlie Brown&size=100x100\">');

-- --------------------------------------------------------

--
-- Table structure for table `stall`
--

CREATE TABLE `stall` (
  `Stall_ID` int(11) NOT NULL,
  `Location` varchar(100) NOT NULL,
  `Operationstatus` varchar(20) NOT NULL,
  `Vendor_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
-- Indexes for table `in_storesale`
--
ALTER TABLE `in_storesale`
  ADD PRIMARY KEY (`InstoresaleID`),
  ADD KEY `Menu_ID` (`Menu_ID`),
  ADD KEY `Vendor_ID` (`Vendor_ID`),
  ADD KEY `Order_ID` (`Order_ID`);

--
-- Indexes for table `membership`
--
ALTER TABLE `membership`
  ADD PRIMARY KEY (`MembershipID`),
  ADD KEY `Registereduser_ID` (`Registereduser_ID`);

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `menu_foodvendor` (`vendor_ID`);

--
-- Indexes for table `nonregistereduser`
--
ALTER TABLE `nonregistereduser`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`Order_ID`),
  ADD KEY `Register_ID` (`Register_ID`),
  ADD KEY `Guest_ID` (`Guest_ID`),
  ADD KEY `Menu_ID` (`Menu_ID`),
  ADD KEY `order_ibfk_5` (`vendor_ID`);

--
-- Indexes for table `order_item`
--
ALTER TABLE `order_item`
  ADD PRIMARY KEY (`Orderitem_ID`),
  ADD KEY `Menu_ID` (`Menu_ID`),
  ADD KEY `Order_ID` (`Order_ID`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`Payment_ID`),
  ADD KEY `Order_ID` (`Order_ID`);

--
-- Indexes for table `registered_user`
--
ALTER TABLE `registered_user`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `stall`
--
ALTER TABLE `stall`
  ADD PRIMARY KEY (`Stall_ID`),
  ADD KEY `Vendor_ID` (`Vendor_ID`);

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
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `in_storesale`
--
ALTER TABLE `in_storesale`
  MODIFY `InstoresaleID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `membership`
--
ALTER TABLE `membership`
  MODIFY `MembershipID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=363;

--
-- AUTO_INCREMENT for table `nonregistereduser`
--
ALTER TABLE `nonregistereduser`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order`
--
ALTER TABLE `order`
  MODIFY `Order_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- AUTO_INCREMENT for table `order_item`
--
ALTER TABLE `order_item`
  MODIFY `Orderitem_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `Payment_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `registered_user`
--
ALTER TABLE `registered_user`
  MODIFY `ID` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `stall`
--
ALTER TABLE `stall`
  MODIFY `Stall_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `in_storesale`
--
ALTER TABLE `in_storesale`
  ADD CONSTRAINT `in_storesale_ibfk_1` FOREIGN KEY (`Menu_ID`) REFERENCES `menu-list` (`Menu_ID`),
  ADD CONSTRAINT `in_storesale_ibfk_2` FOREIGN KEY (`Vendor_ID`) REFERENCES `food_vendor` (`ID`),
  ADD CONSTRAINT `in_storesale_ibfk_3` FOREIGN KEY (`Order_ID`) REFERENCES `order` (`Order_ID`);

--
-- Constraints for table `membership`
--
ALTER TABLE `membership`
  ADD CONSTRAINT `membership_ibfk_1` FOREIGN KEY (`Registereduser_ID`) REFERENCES `registered_user` (`ID`);

--
-- Constraints for table `menu`
--
ALTER TABLE `menu`
  ADD CONSTRAINT `menu_foodvendor` FOREIGN KEY (`vendor_ID`) REFERENCES `food_vendor` (`ID`);

--
-- Constraints for table `order`
--
ALTER TABLE `order`
  ADD CONSTRAINT `order_ibfk_2` FOREIGN KEY (`Register_ID`) REFERENCES `registered_user` (`ID`),
  ADD CONSTRAINT `order_ibfk_3` FOREIGN KEY (`Guest_ID`) REFERENCES `nonregistereduser` (`ID`),
  ADD CONSTRAINT `order_ibfk_4` FOREIGN KEY (`Menu_ID`) REFERENCES `menu` (`ID`),
  ADD CONSTRAINT `order_ibfk_5` FOREIGN KEY (`vendor_ID`) REFERENCES `food_vendor` (`ID`);

--
-- Constraints for table `order_item`
--
ALTER TABLE `order_item`
  ADD CONSTRAINT `order_item_ibfk_1` FOREIGN KEY (`Menu_ID`) REFERENCES `menu-list` (`Menu_ID`),
  ADD CONSTRAINT `order_item_ibfk_2` FOREIGN KEY (`Order_ID`) REFERENCES `order` (`Order_ID`);

--
-- Constraints for table `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `payment_ibfk_1` FOREIGN KEY (`Order_ID`) REFERENCES `order` (`Order_ID`);

--
-- Constraints for table `stall`
--
ALTER TABLE `stall`
  ADD CONSTRAINT `stall_ibfk_1` FOREIGN KEY (`Vendor_ID`) REFERENCES `food_vendor` (`ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
