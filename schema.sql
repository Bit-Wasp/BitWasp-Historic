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
  `twoStepChallenge` varchar(20) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `userID` (`userID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=44 ;

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
