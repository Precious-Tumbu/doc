-- phpMyAdmin SQL Dump
-- version 4.1.6
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: May 09, 2014 at 08:36 PM
-- Server version: 5.6.16
-- PHP Version: 5.5.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `firstserve`
--

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE IF NOT EXISTS `books` (
  `book_id` int(11) NOT NULL AUTO_INCREMENT,
  `book_name` varchar(50) NOT NULL,
  `cat_id` int(11) NOT NULL,
  `book_price` double NOT NULL,
  `book_isbn` varchar(50) NOT NULL,
  `book_author` varchar(50) NOT NULL,
  `book_theme` varchar(50) NOT NULL,
  `book_date` varchar(40) NOT NULL,
  `book_filename` varchar(50) NOT NULL,
  `book_icon` varchar(50) NOT NULL,
  `book_release` varchar(40) NOT NULL,
  `book_purchase` int(11) NOT NULL,
  PRIMARY KEY (`book_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`book_id`, `book_name`, `cat_id`, `book_price`, `book_isbn`, `book_author`, `book_theme`, `book_date`, `book_filename`, `book_icon`, `book_release`, `book_purchase`) VALUES
(1, 'Mini Market', 2, 230, '1943-4343-3453-3n35', 'Monkie', 'Financial Education', '2014-04-07', 'mini_market.pdf', 'mini_market.jpg', '2012', 0),
(3, 'Journey to Life', 1, 120, '232-3434-3434-3443', 'Mercy', 'Inspiration', '2014-05-08T20:19:27+02:00', '8257Unisa.pdf', '3246DakaloCredenceBlue2.jpg', '2013', 0);

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE IF NOT EXISTS `cart` (
  `cart_id` int(11) NOT NULL AUTO_INCREMENT,
  `book_id` int(11) NOT NULL,
  `cust_id` varchar(255) NOT NULL,
  PRIMARY KEY (`cart_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `cat_id` int(11) NOT NULL AUTO_INCREMENT,
  `cat_name` varchar(50) NOT NULL,
  `cat_desc` varchar(250) NOT NULL,
  `cat_date` varchar(40) NOT NULL,
  PRIMARY KEY (`cat_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`cat_id`, `cat_name`, `cat_desc`, `cat_date`) VALUES
(1, 'Education and Reference', 'Educational books for use by educational instituations from pre-school books to university books', '2013-05-08'),
(2, 'Children', 'Books written for children and parents like bed time story books and kids poetry', '2013-05-08');

-- --------------------------------------------------------

--
-- Table structure for table `download`
--

CREATE TABLE IF NOT EXISTS `download` (
  `down_id` int(11) NOT NULL AUTO_INCREMENT,
  `cust_id` varchar(255) NOT NULL,
  `down_code` bigint(20) NOT NULL,
  `book_filename` varchar(50) NOT NULL,
  `down_date` varchar(40) NOT NULL,
  `down_number` int(11) NOT NULL,
  `trans_id` int(11) NOT NULL,
  PRIMARY KEY (`down_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE IF NOT EXISTS `products` (
  `prod_id` int(11) NOT NULL,
  `prod_name` varchar(100) NOT NULL,
  `prod_author` varchar(50) NOT NULL,
  `prod_price` float NOT NULL,
  `prod_image` varchar(50) NOT NULL,
  `prod_link` varchar(50) NOT NULL,
  `prod_isbn` varchar(50) NOT NULL,
  `prod_desc` varchar(1000) NOT NULL,
  `cat_id` int(11) NOT NULL,
  `prod_publisher` varchar(50) NOT NULL,
  `prod_year` varchar(4) NOT NULL,
  PRIMARY KEY (`prod_id`,`cat_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `transaction`
--

CREATE TABLE IF NOT EXISTS `transaction` (
  `trans_id` int(11) NOT NULL AUTO_INCREMENT,
  `cust_id` varchar(255) NOT NULL,
  `trans_numbooks` int(11) NOT NULL,
  `trans_date` varchar(30) NOT NULL,
  PRIMARY KEY (`trans_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(40) NOT NULL,
  `country` varchar(50) NOT NULL,
  `act_code` int(11) NOT NULL,
  `is_active` int(11) NOT NULL,
  `is_ban` int(11) NOT NULL,
  `is_admin` int(11) NOT NULL,
  `validation` varchar(40) NOT NULL,
  `date_created` varchar(25) NOT NULL,
  `date_lastlogin` varchar(25) NOT NULL,
  `cellnum` text,
  `postalAddr` varchar(50) DEFAULT NULL,
  `fullname` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`username`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`username`, `email`, `password`, `country`, `act_code`, `is_active`, `is_ban`, `is_admin`, `validation`, `date_created`, `date_lastlogin`, `cellnum`, `postalAddr`, `fullname`) VALUES
('monkie@gmail.com', 'monkie@gmail.com', '5f4dcc3b5aa765d61d8327deb882cf99', 'South Africa', 13284, 1, 0, 1, '211a1b37b2db71aa38e72bbf802a3a00', '2013-05-08T11:04:16+02:00', '2013-05-08T11:04:16+02:00', '0654355446', 'P.O.Box 565\r\nPretoria\r\n0001', 'Caroline Monkie'),
('freedom@gmail.com', 'freedom@gmail.com', 'd5aa1729c8c253e5d917a5264855eab8', 'Haiti', 71119, 1, 0, 0, 'f33a233ff4d49946ee10baf91ae35468', '2013-05-08T12:20:14+02:00', '2013-05-08T12:20:14+02:00', '02265687876', 'Private Bag x45\r\nHaiti Capital', 'Freedom Parker');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
