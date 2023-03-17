-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: oceanus.cse.buffalo.edu:3306
-- Generation Time: Mar 17, 2023 at 08:22 PM
-- Server version: 8.0.21
-- PHP Version: 7.3.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cse442_2023_spring_team_j_db`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`fenghaih`@`%.buffalo.edu` PROCEDURE `createOrder` (IN `customerID` INT, IN `amount` FLOAT, IN `order_date` DATETIME, IN `description` VARCHAR(200))  NO SQL
BEGIN
START TRANSACTION;
INSERT INTO `order`(customer_id, amount, `date`, description)
VALUES(customerID, amount, order_date, description);
COMMIT;
END$$

CREATE DEFINER=`fenghaih`@`%.buffalo.edu` PROCEDURE `createProduct` (IN `productName` VARCHAR(20), IN `ownerID` INT, IN `description` VARCHAR(200), IN `unitPrice` INT, IN `inventory` INT)  NO SQL
BEGIN
INSERT INTO product (product_name, unit_price, owner_id, description, inventory)
VALUES (productName, unitPrice, ownerID, description, inventory);
END$$

CREATE DEFINER=`fenghaih`@`%.buffalo.edu` PROCEDURE `createUser` (IN `userName` VARCHAR(20), IN `password` VARCHAR(20), IN `email` VARCHAR(50))  NO SQL
INSERT INTO `user` (username, password, email)
VALUES(userName, password, email)$$

CREATE DEFINER=`fenghaih`@`%.buffalo.edu` PROCEDURE `getAllOrders` ()  NO SQL
SELECT * from `order` where 1$$

CREATE DEFINER=`fenghaih`@`%.buffalo.edu` PROCEDURE `getAllProduct` ()  NO SQL
SELECT * from product where 1$$

CREATE DEFINER=`fenghaih`@`%.buffalo.edu` PROCEDURE `getAllUsers` ()  NO SQL
select * from user where 1$$

CREATE DEFINER=`fenghaih`@`%.buffalo.edu` PROCEDURE `getOrderByID` (IN `orderID` INT)  NO SQL
select *
from `order` where id = orderID$$

CREATE DEFINER=`fenghaih`@`%.buffalo.edu` PROCEDURE `getOrderByUserID` (IN `userID` INT)  NO SQL
select * 
from `order` where customer_id = userID$$

CREATE DEFINER=`fenghaih`@`%.buffalo.edu` PROCEDURE `getProductByID` (IN `productID` INT)  NO SQL
select *
from product where id = productID$$

CREATE DEFINER=`fenghaih`@`%.buffalo.edu` PROCEDURE `getProductByUserID` (IN `userID` INT)  NO SQL
select *
from product where owner_id = userID$$

CREATE DEFINER=`fenghaih`@`%.buffalo.edu` PROCEDURE `getUserByID` (IN `userID` INT)  NO SQL
select 
username as username,
email as email
from `user` where id = userID$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `order`
--

CREATE TABLE `order` (
  `id` int NOT NULL,
  `amount` int NOT NULL,
  `customer_id` int NOT NULL,
  `date` datetime NOT NULL,
  `description` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `order`
--

INSERT INTO `order` (`id`, `amount`, `customer_id`, `date`, `description`) VALUES
(1, 15, 3, '2023-03-10 10:30:50', 'productID: 2'),
(2, 4, 2, '2023-03-10 19:06:20', 'productID: 1, count: 2');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` int NOT NULL,
  `product_name` varchar(20) NOT NULL,
  `owner_id` int NOT NULL,
  `unit_price` float NOT NULL,
  `inventory` int NOT NULL,
  `description` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `product_name`, `owner_id`, `unit_price`, `inventory`, `description`) VALUES
(1, 'notebook', 1, 2, 10, 'size: A5, color: blue'),
(2, 'wireless keyboard', 2, 15, 1, 'used; color: black; brand: logitech'),
(3, 'Calculator', 3, 5, 1, 'used; brandL: TI-30XIIS; color: gray');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `email` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `email`) VALUES
(1, 'customer_01', '123456', 'customer_01@gmail.com'),
(2, 'customer_02', '654321', 'customer_02@gmail.com'),
(3, 'customer_03', '9876543', 'customer03@gmail.com'),
(4, 'customer_05', '88888888', 'customer_05@gmail.com');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `owner_id` (`owner_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `order`
--
ALTER TABLE `order`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `order`
--
ALTER TABLE `order`
  ADD CONSTRAINT `order_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`owner_id`) REFERENCES `user` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
