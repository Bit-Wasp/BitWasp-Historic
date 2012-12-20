-- phpMyAdmin SQL Dump
-- version 3.3.2deb1ubuntu1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 11, 2012 at 08:35 PM
-- Server version: 5.1.63
-- PHP Version: 5.3.2-1ubuntu4.18

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `bitwasp`
--

-- --------------------------------------------------------

--
-- Table structure for table `bw_captchas`
--

CREATE TABLE IF NOT EXISTS `bw_captchas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `characters` varchar(20) NOT NULL COMMENT 'Captcha characters.',
  `key` varchar(40) NOT NULL DEFAULT '' COMMENT 'Randomized captcha ID',
  `time` int(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1661 ;



-- --------------------------------------------------------

--
-- Table structure for table `bw_categories`
--

CREATE TABLE IF NOT EXISTS `bw_categories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `parentID` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  UNIQUE KEY `name` (`name`),
  UNIQUE KEY `name_2` (`name`),
  KEY `name_3` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=41 ;


-- --------------------------------------------------------

--
-- Table structure for table `bw_config`
--

CREATE TABLE IF NOT EXISTS `bw_config` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `jsonConfig` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

INSERT INTO `bw_config` (id) VALUES ('1');
--
-- Table structure for table `bw_currencies`
--

CREATE TABLE IF NOT EXISTS `bw_currencies` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `symbol` varchar(10) NOT NULL,
  `exchangeRate` float NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `bw_currencies`
--

INSERT INTO `bw_currencies` (`id`, `name`, `symbol`, `exchangeRate`) VALUES
(1, 'Bitcoin', 'BTC', 0);


--
-- Table structure for table `bw_images`
--

CREATE TABLE IF NOT EXISTS `bw_images` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `encoded` longtext NOT NULL,
  `height` int(5) NOT NULL,
  `width` int(5) NOT NULL,
  `imageHash` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=116 ;


INSERT INTO `bw_images` (`id`, `encoded`, `height`, `width`, `imageHash`) VALUES
(112, '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', 120, 160, 'default');

--
-- Table structure for table `bw_itemPhotos`
--

CREATE TABLE IF NOT EXISTS `bw_itemPhotos` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `itemHash` varchar(20) NOT NULL,
  `imageHash` varchar(255) NOT NULL COMMENT 'Unique hash which can be used to reference this image',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=112 ;


--
-- Table structure for table `bw_items`
--

CREATE TABLE IF NOT EXISTS `bw_items` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `price` float NOT NULL COMMENT 'Price of product in the specified currency',
  `currency` smallint(6) NOT NULL COMMENT 'ID of currency the product is priced in.',
  `itemHash` varchar(255) NOT NULL COMMENT 'Unique hash which identifies this product',
  `mainPhotoHash` varchar(20) NOT NULL COMMENT 'Hash of main image for this product. Reduce searching of images database for thumbnail',
  `rating` int(11) NOT NULL COMMENT 'The current rating for this product',
  `category` int(10) unsigned NOT NULL COMMENT 'Store the ID of this products category',
  `sellerID` varchar(20) NOT NULL,
  `hidden` enum('0','1') NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=57 ;


--
-- Table structure for table `bw_messageBuddies`
--

CREATE TABLE IF NOT EXISTS `bw_messageBuddies` (
  `id` int(11) NOT NULL,
  `userHash` varchar(20) NOT NULL,
  `friendHash` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Table structure for table `bw_messages`
--

CREATE TABLE IF NOT EXISTS `bw_messages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `messageHash` varchar(255) NOT NULL,
  `toId` varchar(20) NOT NULL COMMENT 'User recieving message',
  `fromId` varchar(20) NOT NULL COMMENT 'User who sent the message',
  `orderID` int(10) unsigned NOT NULL COMMENT 'If message is about a particular order, its ID',
  `subject` varchar(255) NOT NULL COMMENT 'Subject of the message',
  `message` text NOT NULL COMMENT 'Text of the message',
  `encrypted` tinyint(1) NOT NULL COMMENT 'Store if message has been encrypted',
  `viewed` tinyint(1) NOT NULL COMMENT 'Has recipient viewed the message',
  `time` int(11) NOT NULL,
  `threadHash` varchar(20) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=125 ;

--
-- Table structure for table `bw_orders`
--

CREATE TABLE IF NOT EXISTS `bw_orders` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `buyerHash` varchar(30) NOT NULL,
  `sellerHash` varchar(30) NOT NULL,
  `items` text NOT NULL COMMENT 'Serialized array of product id and quantities',
  `totalPrice` float NOT NULL,
  `currency` mediumint(9) NOT NULL,
  `time` int(11) NOT NULL,
  `step` smallint(6) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=34 ;


--
-- Table structure for table `bw_registrationTokens`
--

CREATE TABLE IF NOT EXISTS `bw_registrationTokens` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `hash` varchar(16) NOT NULL,
  `content` varchar(65) NOT NULL,
  `role` varchar(8) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

--
-- Table structure for table `bw_pageAuthorization`
--

CREATE TABLE IF NOT EXISTS `bw_pageAuthorization` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `URI` varchar(200) NOT NULL,
  `authLevel` varchar(15) NOT NULL,
  `pageOffline` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `bw_pageAuthorization`
--

INSERT INTO `bw_pageAuthorization` (`id`, `URI`, `authLevel`, `pageOffline`) VALUES
(1, 'item', 'login', 0),
(2, 'items', 'login', 0),
(3, 'listings', 'vendor', 0),
(4, 'account', 'login', 0),
(5, 'home', 'login', 0),
(6, 'orders', 'buyer', 0),
(7, 'user', 'login', 0),
(8, 'cat', 'login', 0),
(9, 'admin', 'admin', 0),
(10, 'messages', 'login', 0),
(12, 'dispatch', 'vendor', 0),
(13, 'payment', 'vendor', 0),
(14, 'account', 'login', 0),
(15, 'purchases', 'vendor', 0);

--
-- Table structure for table `bw_pages`
--

CREATE TABLE IF NOT EXISTS `bw_pages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL COMMENT 'Page title',
  `content` text NOT NULL COMMENT 'Text of page',
  `creator` int(10) unsigned NOT NULL COMMENT 'ID of admin who created page',
  `time` int(11) NOT NULL COMMENT 'Time page created / last modified',
  `slug` varchar(255) NOT NULL COMMENT 'Unique slug which identifies this page.',
  `displayMenu` tinyint(1) NOT NULL COMMENT 'Should this page be displayed in menus',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;




-- --------------------------------------------------------

--
-- Table structure for table `bw_publicKeys`
--

CREATE TABLE IF NOT EXISTS `bw_publicKeys` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `userID` int(10) unsigned NOT NULL,
  `key` text NOT NULL,
  `fingerprint` varchar(60) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COMMENT='Store all users GPG public keys for on the fly encryption' AUTO_INCREMENT=39 ;

--
-- Table structure for table `bw_reviews`
--

CREATE TABLE IF NOT EXISTS `bw_reviews` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `reviewedID` int(10) unsigned NOT NULL COMMENT 'ID of user or product being reviewed',
  `userID` int(10) unsigned NOT NULL,
  `rating` float NOT NULL,
  `reviewText` text NOT NULL,
  `reviewType` enum('User','Product') NOT NULL,
  `time` int(11) NOT NULL COMMENT 'Time review was made',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;


-- --------------------------------------------------------

--
-- Table structure for table `bw_sessions`
--

CREATE TABLE IF NOT EXISTS `bw_sessions` (
  `session_id` varchar(40) NOT NULL DEFAULT '0',
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `userHash` varchar(50) NOT NULL,
  PRIMARY KEY (`session_id`),
  KEY `last_activity_idx` (`last_activity`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `bw_twoStep`
--

CREATE TABLE IF NOT EXISTS `bw_twoStep` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userID` int(11) NOT NULL,
  `twoStepChallenge` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `userID` (`userID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=44 ;


--
-- Table structure for table `bw_registrationTokens`
--

CREATE TABLE IF NOT EXISTS `bw_registrationTokens` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `hash` varchar(16) NOT NULL,
  `content` varchar(65) NOT NULL,
  `role` varchar(8) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 ;

--
-- Table structure for table `bw_users`
--

CREATE TABLE IF NOT EXISTS `bw_users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `userName` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL COMMENT 'Hashed Password stored together with a unique salt',
  `userRole` enum('Buyer','Vendor','Admin') NOT NULL DEFAULT 'Buyer' COMMENT 'Classify as one of three user types',
  `timeRegistered` int(11) NOT NULL COMMENT 'Store UNIX timestamp when user registers',
  `lastLog` int(11) NOT NULL COMMENT 'Store last time user has logged in',
  `userHash` varchar(255) NOT NULL COMMENT 'Unique hash which identifies the user',
  `rating` float NOT NULL COMMENT 'Store this users current rating',
  `twoStepAuth` tinyint(1) NOT NULL COMMENT 'Store if user is using two step authentication.',
  `userSalt` varchar(30) DEFAULT NULL,
  `profileMessage` text NOT NULL,
  `forcePGPmessage` enum('0','1') NOT NULL,
  `items_per_page` enum('25','50','75','100') NOT NULL,
  `last_activity` varchar(20) NOT NULL,
  `showActivity` enum('0','1') DEFAULT '0',
  `location` varchar(2) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=200 ;

--
-- Dumping data for table `bw_users`
--

INSERT INTO `bw_users` (`id`, `userName`, `password`, `userRole`, `timeRegistered`, `lastLog`, `userHash`, `rating`, `twoStepAuth`, `userSalt`, `profileMessage`, `forcePGPmessage`, `items_per_page`) VALUES
(162, 'admin', 'b90b6492ea6f5e133b97461cdc8467c1c9f0d5dfff88e3d8295c9c69733dbb25', 'Admin', 1344899894, 1349776090, '62b98102c74a8425', 0, 0, 'ycoytrnslmkt', '', '0', '25'),
(185, 'buyer', '892e9643041ca1d45894586f1b4d0de9c94bb1894a91a994e5eeeabbf08c9b1e', 'Buyer', 1347629747, 1349970135, '39b7a97140b769a1', 0, 0, 'zhx{iuwsoqeowsghxmx', 'Hi there!', '1', '25'),
(182, 'seller', '5f8d3e8220b978b17d9f3a873b68475ad8bd2515275c623ddce7d23c4071795c', 'Vendor', 1347623006, 1349815990, '752b8cca3b3cbeb9', 0, 0, 'rczwmo{cdhhhlfuvyzjie', 'I am the best vendor on the interwebz!!!! Buy for me.', '0', '25');
