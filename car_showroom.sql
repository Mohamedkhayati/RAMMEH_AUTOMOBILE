-- phpMyAdmin SQL Dump
-- version 3.3.9.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Nov 25, 2024 at 09:53 PM
-- Server version: 5.5.10
-- PHP Version: 5.3.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `car_showroom`
--

-- --------------------------------------------------------

--
-- Table structure for table `cars`
--

CREATE TABLE IF NOT EXISTS `cars` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `model` varchar(100) NOT NULL,
  `year` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `description` text NOT NULL,
  `approved` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `cars`
--

INSERT INTO `cars` (`id`, `name`, `model`, `year`, `price`, `description`, `approved`) VALUES
(2, 'ku', 'mahindra', 2021, 52000.00, 'dsqds', 1),
(4, 'SPORTAGE', 'KIA', 2020, 150000.00, 'AUTO AND RED ', 1);

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE IF NOT EXISTS `cart` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `car_id` int(11) NOT NULL,
  `quantity` int(11) DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `car_id` (`car_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `user_id`, `car_id`, `quantity`) VALUES
(1, 1, 2, NULL),
(2, 1, 2, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `car_images`
--

CREATE TABLE IF NOT EXISTS `car_images` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `car_id` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `car_id` (`car_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `car_images`
--

INSERT INTO `car_images` (`id`, `car_id`, `image`) VALUES
(1, 2, '33.jpg'),
(2, 2, '22.jpg'),
(3, 2, '111.jpg'),
(8, 4, '465715214_536656115793319_5728229975266443159_n.jpg'),
(9, 4, '465009147_536656385793292_2083197876220347362_n.jpg'),
(10, 4, '465789407_536656402459957_5883477840899477463_n.jpg'),
(11, 4, '465656799_536656449126619_7291017955050746863_n.jpg'),
(12, 4, '465706348_536656475793283_4558940320283746179_n.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `commande`
--

CREATE TABLE IF NOT EXISTS `commande` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `status` enum('pending','completed','canceled') DEFAULT 'pending',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `commande`
--

INSERT INTO `commande` (`id`, `user_id`, `total_price`, `status`) VALUES
(2, 1, 104000.00, ''),
(3, 1, 104000.00, 'pending'),
(4, 1, 52000.00, ''),
(5, 1, 52000.00, 'pending'),
(6, 1, 3500000.00, ''),
(7, 1, 3500000.00, 'pending'),
(8, 1, 3500000.00, 'pending'),
(9, 1, 3500000.00, 'pending'),
(10, 1, 3500000.00, 'pending'),
(11, 1, 3500000.00, 'pending'),
(12, 1, 3500000.00, 'pending'),
(13, 1, 52000.00, ''),
(14, 1, 52000.00, 'pending'),
(15, 1, 52000.00, 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `pay`
--

CREATE TABLE IF NOT EXISTS `pay` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `commande_id` int(11) NOT NULL,
  `payment_method` enum('credit_card','bank_transfer','cash_on_delivery') NOT NULL,
  `payment_status` enum('pending','completed') DEFAULT 'pending',
  PRIMARY KEY (`id`),
  KEY `commande_id` (`commande_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `pay`
--

INSERT INTO `pay` (`id`, `commande_id`, `payment_method`, `payment_status`) VALUES
(1, 2, 'credit_card', 'pending'),
(2, 4, 'credit_card', 'pending'),
(3, 6, 'cash_on_delivery', 'pending'),
(4, 13, 'cash_on_delivery', 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `role` varchar(50) DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `role`, `created_at`) VALUES
(1, 'med', '25d55ad283aa400af464c76d713c07ad', 'mohamedkhayati261@gmail.com', 'admin', '2024-11-18 13:56:08'),
(2, 'omar', '15de21c670ae7c3f6f3f1f37029303c9', 'mohamedkhayati261@gmail.com', 'user', '2024-11-18 14:06:36'),
(3, 'adem', 'f1c1592588411002af340cbaedd6fc33', 'mohamedkhayati261@gmail.com', 'user', '2024-11-18 14:16:54');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`car_id`) REFERENCES `cars` (`id`);

--
-- Constraints for table `car_images`
--
ALTER TABLE `car_images`
  ADD CONSTRAINT `car_images_ibfk_1` FOREIGN KEY (`car_id`) REFERENCES `cars` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `pay`
--
ALTER TABLE `pay`
  ADD CONSTRAINT `pay_ibfk_1` FOREIGN KEY (`commande_id`) REFERENCES `commande` (`id`);
