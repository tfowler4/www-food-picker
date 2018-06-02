-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 02, 2018 at 08:07 AM
-- Server version: 10.1.22-MariaDB
-- PHP Version: 7.1.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `xeonsold_foods`
--

-- --------------------------------------------------------

--
-- Table structure for table `dining_types`
--

CREATE TABLE `dining_types` (
  `id` int(7) NOT NULL,
  `name` varchar(144) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `dining_types`
--

INSERT INTO `dining_types` (`id`, `name`) VALUES
(1, 'Fast Food'),
(2, 'Sit In'),
(3, 'Buffet'),
(4, 'Delivery');

-- --------------------------------------------------------

--
-- Table structure for table `food_types`
--

CREATE TABLE `food_types` (
  `id` int(7) NOT NULL,
  `name` varchar(144) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `food_types`
--

INSERT INTO `food_types` (`id`, `name`) VALUES
(1, 'American'),
(2, 'Italian'),
(3, 'Korean'),
(4, 'Japanese'),
(5, 'Chinese'),
(6, 'Mexican'),
(7, 'Indian'),
(8, 'Southern');

-- --------------------------------------------------------

--
-- Table structure for table `locations`
--

CREATE TABLE `locations` (
  `id` int(11) NOT NULL,
  `name` varchar(144) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `locations`
--

INSERT INTO `locations` (`id`, `name`) VALUES
(1, 'Camp Creek'),
(2, 'Thorton Road'),
(3, 'East West Connector'),
(4, 'Midtown'),
(5, 'Doraville'),
(6, 'Pleasant Hill');

-- --------------------------------------------------------

--
-- Table structure for table `meals`
--

CREATE TABLE `meals` (
  `id` int(7) NOT NULL,
  `name` varchar(144) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `meals`
--

INSERT INTO `meals` (`id`, `name`) VALUES
(1, 'Breakfast'),
(2, 'Brunch'),
(3, 'Lunch'),
(4, 'Dinner');

-- --------------------------------------------------------

--
-- Table structure for table `restaurants`
--

CREATE TABLE `restaurants` (
  `id` int(7) NOT NULL,
  `name` varchar(144) NOT NULL,
  `location` varchar(144) NOT NULL,
  `food_type` int(7) NOT NULL,
  `dining_type` int(7) NOT NULL,
  `meal` int(7) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `restaurants`
--

INSERT INTO `restaurants` (`id`, `name`, `location`, `food_type`, `dining_type`, `meal`) VALUES
(2, 'McDonalds', '2', 1, 1, 3),
(3, 'Popeye\'s', '2', 1, 1, 4),
(4, 'Hardee\'s', '2', 1, 1, 3),
(5, 'Burger King', '2', 1, 1, 3),
(6, 'Wendy\'s', '2', 1, 1, 3),
(7, 'Taco Bell', '2', 6, 1, 3),
(8, 'IHOP', '3', 1, 2, 2),
(9, 'Subway', '2', 1, 1, 3),
(10, 'Chick Fil A', '2', 1, 1, 3),
(11, 'Jimmy John\'s', '2', 1, 1, 3),
(12, 'Southern', '2', 1, 3, 3),
(13, 'KFC', '2', 1, 1, 3),
(14, 'Firehouse Subs', '2', 1, 1, 3),
(15, 'Tokyo Express', '2', 4, 1, 3),
(16, 'Waffle House', '2', 1, 2, 2),
(17, 'Ruby Tuesday\'s', '2', 1, 2, 4),
(18, 'Sonic', '2', 1, 1, 3),
(19, 'Church\'s', '2', 1, 1, 3),
(20, 'Arby\'s', '2', 1, 1, 3),
(21, 'Zaxby\'s', '2', 1, 1, 3),
(22, 'Applebee\'s', '1', 1, 3, 1),
(23, 'Dairy Queen', '3', 1, 1, 3),
(24, 'Chili\'s', '3', 1, 2, 4);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `dining_types`
--
ALTER TABLE `dining_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `food_types`
--
ALTER TABLE `food_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `locations`
--
ALTER TABLE `locations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `meals`
--
ALTER TABLE `meals`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `restaurants`
--
ALTER TABLE `restaurants`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `dining_types`
--
ALTER TABLE `dining_types`
  MODIFY `id` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `food_types`
--
ALTER TABLE `food_types`
  MODIFY `id` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `locations`
--
ALTER TABLE `locations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `meals`
--
ALTER TABLE `meals`
  MODIFY `id` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `restaurants`
--
ALTER TABLE `restaurants`
  MODIFY `id` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
