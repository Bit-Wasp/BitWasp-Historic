use bitwasp;

-- MySQL Schema for Bitwasp
-- --------------------------------------------------------
-- This SQL contains the basic database structure for BitWasp.
-- --------------------------------------------------------

--
-- Table structure for table `bw_categories`
--

CREATE TABLE IF NOT EXISTS `bw_categories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `slug` varchar(255) NOT NULL,
  `parentID` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Table structure for table `bw_messages`
--

CREATE TABLE IF NOT EXISTS `bw_messages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `toID` int(10) unsigned NOT NULL COMMENT 'User recieving message',
  `fromID` int(10) unsigned NOT NULL COMMENT 'User who sent the message',
  `orderID` int(10) unsigned NOT NULL COMMENT 'If message is about a particular order, its ID',
  `subject` varchar(255) NOT NULL COMMENT 'Subject of the message',
  `message` text NOT NULL COMMENT 'Text of the message',
  `encrypted` tinyint(1) NOT NULL COMMENT 'Store if message has been encrypted',
  `viewed` tinyint(1) NOT NULL COMMENT 'Has recipient viewed the message',
  `time` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `bw_orders`
--

CREATE TABLE IF NOT EXISTS `bw_orders` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `buyerID` int(10) unsigned NOT NULL,
  `sellerID` int(10) unsigned NOT NULL,
  `products` text NOT NULL COMMENT 'Serialized array of product id and quantities',
  `totalPrice` float NOT NULL,
  `currency` mediumint(9) NOT NULL,
  `time` int(11) NOT NULL,
  `step` smallint(6) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Table structure for table `bw_productPhotos`
--

CREATE TABLE IF NOT EXISTS `bw_productPhotos` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `productID` int(10) unsigned NOT NULL,
  `mainPhoto` tinyint(1) NOT NULL COMMENT 'Is this the main cover photo for this product',
  `imageName` varchar(255) NOT NULL COMMENT 'Filename of image',
  `thumbName` varchar(255) NOT NULL COMMENT 'Filename of the thumbnail for this image',
  `imageHash` varchar(255) NOT NULL COMMENT 'Unique hash which can be used to reference this image',
  `height` mediumint(9) NOT NULL,
  `width` mediumint(9) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Table structure for table `bw_products`
--

CREATE TABLE IF NOT EXISTS `bw_products` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `sellerID` int(10) unsigned NOT NULL,
  `price` float NOT NULL COMMENT 'Price of product in the specified currency',
  `currency` smallint(6) NOT NULL COMMENT 'ID of currency the product is priced in.',
  `productHash` varchar(255) NOT NULL COMMENT 'Unique hash which identifies this product',
  `mainPhotoID` int(10) unsigned NOT NULL COMMENT 'ID of main image for this product. Reduce searching of images database for thumbnail',
  `rating` int(11) NOT NULL COMMENT 'The current rating for this product',
  `category` int(10) unsigned NOT NULL COMMENT 'Store the ID of this products category',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Table structure for table `bw_publicKeys`
--

CREATE TABLE IF NOT EXISTS `bw_publicKeys` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `userID` int(10) unsigned NOT NULL,
  `key` text NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Store all users GPG public keys for on the fly encryption' AUTO_INCREMENT=1 ;

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
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
