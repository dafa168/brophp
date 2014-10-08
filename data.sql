-- brophp cms  sql
-- ----------------------------
-- Table structure for `b_admin`
-- ----------------------------
DROP TABLE IF EXISTS `b_admin`;
CREATE TABLE `b_admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL,
  `password` char(32) NOT NULL,
  `login_time` int(11) NOT NULL,
  `login_ip` varchar(20) NOT NULL,
  `locked` tinyint(1) NOT NULL DEFAULT '0',
  `gid` smallint(6) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of b_admin
-- ----------------------------
INSERT INTO `b_admin` VALUES ('1', 'admin', '74be16979710d4c4e7c6647856088456', '1412727140', '127.0.0.1', '0', '1');
INSERT INTO `b_admin` VALUES ('2', 'dafa168', '38026ed22fc1a91d92b5d2ef93540f20', '1389750480', '127.0.0.1', '0', '3');

-- ----------------------------
-- Table structure for `b_article`
-- ----------------------------
DROP TABLE IF EXISTS `b_article`;
CREATE TABLE `b_article` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(150) NOT NULL,
  `keywords` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `click` mediumint(9) NOT NULL DEFAULT '0',
  `body` text NOT NULL,
  `addtime` int(11) NOT NULL DEFAULT '0',
  `updatetime` int(11) NOT NULL DEFAULT '0',
  `pic` varchar(50) NOT NULL,
  `cid` mediumint(9) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of b_article
-- ----------------------------
INSERT INTO `b_article` VALUES ('9', 'html is hyper translation map language', '111', '1111', '1111', '111111111111111', '1389678887', '0', '', '17');
INSERT INTO `b_article` VALUES ('10', 'java srcipt is very goods ', '1111', '111111111111', '111111', '11111111111111111', '1389682901', '0', '', '12');
INSERT INTO `b_article` VALUES ('11', 'AAAAAAAAAAAAAAAAAA', 'AAAA', 'AAAAAAAAAAAAAAA', '123', '&lt;p&gt;\r\n	AAAAAAAAAAaa&lt;/p&gt;\r\n', '1389856435', '0', '20140116151355_732.jpg', '25');

-- ----------------------------
-- Table structure for `b_cate`
-- ----------------------------
DROP TABLE IF EXISTS `b_cate`;
CREATE TABLE `b_cate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cname` varchar(20) NOT NULL,
  `keywords` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=27 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of b_cate
-- ----------------------------
INSERT INTO `b_cate` VALUES ('17', 'HTML', 'HTML4,HTML5,XHTML,DHTML', 'HTMLHTMLHTMLHTMLHTMLHT');
INSERT INTO `b_cate` VALUES ('13', 'CSS', 'bootstrap,element,gird5', 'CSSCSS');
INSERT INTO `b_cate` VALUES ('12', 'JAVASCRIPT', 'JQuery,prototype', 'JAVASCRIPT1111');
INSERT INTO `b_cate` VALUES ('18', 'PHP', 'smarty,brophp', 'php\r\n');
INSERT INTO `b_cate` VALUES ('19', 'MYSQL', 'MYISAM,INNODB', 'MYSQL');
INSERT INTO `b_cate` VALUES ('22', 'ORACLE', 'ORACLE', 'oracle is jiangguwen LTD.');
INSERT INTO `b_cate` VALUES ('23', 'SQLite', 'SQLite', 'sqlite database !!!');
INSERT INTO `b_cate` VALUES ('25', 'MONGODB', 'MONGDB', 'MONGDB');
INSERT INTO `b_cate` VALUES ('26', 'HTML5', 'HTML5', 'HTML5111111111');

-- ----------------------------
-- Table structure for `b_comment`
-- ----------------------------
DROP TABLE IF EXISTS `b_comment`;
CREATE TABLE `b_comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uname` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `c_body` text NOT NULL,
  `c_ip` varchar(20) NOT NULL,
  `c_time` bigint(20) NOT NULL,
  `aid` mediumint(9) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of b_comment
-- ----------------------------

-- ----------------------------
-- Table structure for `b_goods`
-- ----------------------------
DROP TABLE IF EXISTS `b_goods`;
CREATE TABLE `b_goods` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `keywords` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `pic` varchar(50) NOT NULL,
  `num` mediumint(8) NOT NULL DEFAULT '0',
  `price` decimal(7,2) NOT NULL DEFAULT '0.00',
  `sid` smallint(5) NOT NULL DEFAULT '0',
  `addtime` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of b_goods
-- ----------------------------
INSERT INTO `b_goods` VALUES ('5', 'AAAAAAè¶³çƒ', 'AAAAAAè¶³çƒ', '&lt;p&gt;\r\n	AAAAAAè¶³çƒAAAAAAè¶³çƒAAAAAAè¶³çƒAAAAAA&lt;/p&gt;\r\n&lt;p&gt;\r\n	è¶³çƒAAAAAAè¶³çƒAAAAAAè¶³çƒAAAAAAè¶³çƒAAAAA&lt;/p&gt;\r\n&lt;p style=&quot;text-align: center;&quot;&gt;\r\n	Aè¶³çƒAAAAAAè¶³çƒAAA&lt;img alt=&quot;&quot; src=&quot;/public/uploads/tmp/20140116170543_957.jpg&quot; style=&quot;width: 440px; height: 624px;&quot; /&gt;&lt;/p&gt;\r\n&lt;p&gt;\r\n	AAAè¶³çƒAAAAAAè¶³çƒAAAAAAè¶³çƒAAAAAAè¶³çƒAAAAAAè¶³çƒ&lt;/p&gt;\r\n', '', '123', '99999.99', '13', '1389863152');

-- ----------------------------
-- Table structure for `b_group`
-- ----------------------------
DROP TABLE IF EXISTS `b_group`;
CREATE TABLE `b_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `gname` varchar(50) NOT NULL,
  `description` varchar(255) NOT NULL,
  `adminadmin` tinyint(1) NOT NULL DEFAULT '0',
  `articleadmin` tinyint(1) NOT NULL DEFAULT '0',
  `cateadmin` tinyint(1) NOT NULL DEFAULT '0',
  `commentadmin` tinyint(1) NOT NULL DEFAULT '0',
  `goodsadmin` tinyint(1) NOT NULL DEFAULT '0',
  `pageadmin` tinyint(1) NOT NULL DEFAULT '0',
  `sortadmin` tinyint(1) NOT NULL DEFAULT '0',
  `groupadmin` tinyint(1) NOT NULL DEFAULT '0',
  `webadmin` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of b_group
-- ----------------------------
INSERT INTO `b_group` VALUES ('1', 'è¶…çº§ç®¡ç†å‘˜', 'å…·æœ‰æ‰€æœ‰æ¨¡å—æƒé™ï¼ï¼ï¼', '1', '1', '1', '1', '1', '1', '1', '1', '1');
INSERT INTO `b_group` VALUES ('2', 'æ™®é€šç®¡ç†å‘˜', 'å°±é‚£ä¹ˆå‡ ä¸ªæƒé™\r\n', '0', '1', '0', '0', '0', '1', '0', '0', '1');
INSERT INTO `b_group` VALUES ('4', 'ç½‘ç«™ç¼–è¾‘ç»„', 'ä¸­æ–‡ä¸“ä¸šé€‚åˆåšç¼–è¾‘ï¼', '0', '1', '0', '1', '0', '1', '0', '0', '1');

-- ----------------------------
-- Table structure for `b_page`
-- ----------------------------
DROP TABLE IF EXISTS `b_page`;
CREATE TABLE `b_page` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(150) NOT NULL,
  `keywords` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `body` text NOT NULL,
  `addtime` int(11) NOT NULL,
  `click` mediumint(9) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of b_page
-- ----------------------------
INSERT INTO `b_page` VALUES ('1', 'AAAAAAAAAAAAAAA', 'AAAAAAAAAAAAAAA', 'aaaaaaaaa', 'AAAAAAAAAAAAAAAAAAAAAAAAAAA', '1389441687', '123');

-- ----------------------------
-- Table structure for `b_sort`
-- ----------------------------
DROP TABLE IF EXISTS `b_sort`;
CREATE TABLE `b_sort` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sname` varchar(50) NOT NULL DEFAULT '0',
  `pid` smallint(5) NOT NULL DEFAULT '0',
  `path` varchar(255) NOT NULL,
  `keywords` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `pid` (`pid`,`path`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of b_sort
-- ----------------------------
INSERT INTO `b_sort` VALUES ('1', 'WEBå¼€å‘', '0', '0', '1111111', '1111111111');
INSERT INTO `b_sort` VALUES ('2', 'HTML', '1', '0-1', '1111111', '11111111111');
INSERT INTO `b_sort` VALUES ('3', 'HTML5', '2', '0-1-2', '1111111111', '111111111111111');
INSERT INTO `b_sort` VALUES ('4', 'ASP', '1', '0-1', 'asp', 'asp\r\n');
INSERT INTO `b_sort` VALUES ('5', 'PHP', '1', '0-1', 'PHP', 'PHP\r\n');
INSERT INTO `b_sort` VALUES ('6', 'JSP', '1', '0-1', 'JSP', 'JSP');
INSERT INTO `b_sort` VALUES ('7', 'JAVASE', '6', '0-1-6', 'javase', 'javase\r\n');
INSERT INTO `b_sort` VALUES ('8', 'JAVAEE', '6', '0-1-6', 'javaee', 'javaee\r\n');
INSERT INTO `b_sort` VALUES ('9', 'CSS', '1', '0-1', 'CSS', 'CSS');
INSERT INTO `b_sort` VALUES ('10', 'JAVASCRIPT', '1', '0-1', 'JAVASCRIPT', 'JAVASCRIPT');
INSERT INTO `b_sort` VALUES ('11', 'prototype_js', '10', '0-1-10', 'prototype_js', 'prototype_js');
INSERT INTO `b_sort` VALUES ('12', 'JQuery', '10', '0-1-10', 'JQuery', 'JQuery');
INSERT INTO `b_sort` VALUES ('13', 'MYSQL', '1', '0-1', 'MYSQL', 'MYSQL');
