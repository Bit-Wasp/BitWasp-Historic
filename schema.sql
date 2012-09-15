-- phpMyAdmin SQL Dump
-- version 3.3.2deb1ubuntu1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Sep 14, 2012 at 09:31 PM
-- Server version: 5.1.63
-- PHP Version: 5.3.2-1ubuntu4.17

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1193 ;

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=40 ;

-- --------------------------------------------------------

--
-- Table structure for table `bw_config`
--

CREATE TABLE IF NOT EXISTS `bw_config` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `jsonConfig` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

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

-- --------------------------------------------------------

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=93 ;

-- --------------------------------------------------------

--
-- Table structure for table `bw_itemPhotos`
--

CREATE TABLE IF NOT EXISTS `bw_itemPhotos` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `itemHash` varchar(20) NOT NULL,
  `imageHash` varchar(255) NOT NULL COMMENT 'Unique hash which can be used to reference this image',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=89 ;

-- --------------------------------------------------------

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
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=50 ;

-- --------------------------------------------------------

--
-- Table structure for table `bw_messageBuddies`
--

CREATE TABLE IF NOT EXISTS `bw_messageBuddies` (
  `id` int(11) NOT NULL,
  `userHash` varchar(20) NOT NULL,
  `friendHash` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=91 ;

-- --------------------------------------------------------

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=29 ;

-- --------------------------------------------------------

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

-- --------------------------------------------------------

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COMMENT='Store all users GPG public keys for on the fly encryption' AUTO_INCREMENT=36 ;

-- --------------------------------------------------------

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=23 ;

-- --------------------------------------------------------

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
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=186 ;

