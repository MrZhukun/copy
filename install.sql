-- --------------------------------------------------------
-- 
-- Table structure for table `qq_admin`
-- 

CREATE TABLE `qq_admin` (
  `pass` varchar(11) DEFAULT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '800',
  PRIMARY KEY (`id`),
  FULLTEXT KEY `pass` (`pass`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------
-- 
-- Table structure for table `qq_dislike`
-- 

CREATE TABLE `qq_dislike` (
  `id` int(11) NOT NULL,
  `myqq` int(12) NOT NULL,
  `disqq` int(12) NOT NULL,
  KEY `myqq` (`myqq`),
  KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------
-- 
-- Table structure for table `qq_qqinfo`
-- 

CREATE TABLE `qq_qqinfo` (
  `id` int(11) DEFAULT NULL,
  `no` int(1) DEFAULT '1',
  `user` varchar(15) DEFAULT NULL,
  `pass` varchar(35) DEFAULT NULL,
  `depass` varchar(35) DEFAULT NULL,
  `sid` varchar(50) DEFAULT NULL,
  `login` int(5) DEFAULT '10',
  `time` datetime NOT NULL,
  UNIQUE KEY `user` (`user`),
  KEY `id` (`id`),
  KEY `no` (`no`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------
-- 
-- Table structure for table `qq_user`
-- 

CREATE TABLE `qq_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '100',
  `user` varchar(50) DEFAULT NULL,
  `pass` varchar(150) DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `phone` (`phone`),
  UNIQUE KEY `user_2` (`user`),
  KEY `user` (`user`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
