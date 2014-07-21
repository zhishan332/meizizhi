/*
Navicat MySQL Data Transfer

Source Server         : mysql
Source Server Version : 60011
Source Host           : localhost:3306
Source Database       : jcamera

Target Server Type    : MYSQL
Target Server Version : 60011
File Encoding         : 65001

Date: 2014-07-21 21:28:54
*/

SET FOREIGN_KEY_CHECKS=0;
-- ----------------------------
-- Table structure for `config`
-- ----------------------------
DROP TABLE IF EXISTS `config`;
CREATE TABLE `config` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `key` varchar(200) NOT NULL,
  `val` varchar(300) NOT NULL,
  `remark` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of config
-- ----------------------------
INSERT INTO config VALUES ('1', 'photo.mini.width', '300', '最小图片宽度');
INSERT INTO config VALUES ('2', 'photo.mini.height', '300', '');
INSERT INTO config VALUES ('3', 'http.connect.timeout', '10000', null);
INSERT INTO config VALUES ('4', 'http.socket.timeout', '30000', null);
INSERT INTO config VALUES ('5', 'http.connection.request.timeout', '10000', null);
INSERT INTO config VALUES ('6', 'photo.save.path', 'D:\\\\download\\\\jcamera\\\\photos\\\\', null);
INSERT INTO config VALUES ('7', 'http.retry.num', '10', null);
INSERT INTO config VALUES ('8', 'website.worker.delay', '600', null);
INSERT INTO config VALUES ('9', 'phototask.grap.num', '5', null);
INSERT INTO config VALUES ('12', 'urltask.grap.num', '5', null);
INSERT INTO config VALUES ('13', 'worker.retry.num', '3', null);
INSERT INTO config VALUES ('14', 'photo.mini.length', '30', null);
INSERT INTO config VALUES ('15', 'photo.name.style', '1', '1.智能重命名');
INSERT INTO config VALUES ('16', 'photo.folder.style', '1', '1.按域名分文件夹');
INSERT INTO config VALUES ('17', 'phototask.worker.delay', '5', null);
INSERT INTO config VALUES ('18', 'urltask.worker.delay', '5', null);
INSERT INTO config VALUES ('19', 'photo.download', '0', '1:开启图片下载  0：关闭图片下载  重启应用后生效');
INSERT INTO config VALUES ('20', 'page.shownum', '10', null);
INSERT INTO config VALUES ('21', 'url.valid.regx', '//(www.)?(.*)(.com|.net|.cn|.org|.hk|.me|.cc|.net.cn|.asia|.com.cn|.co|.biz|.tw|.org.cn|.info|.io)', null);
INSERT INTO config VALUES ('22', 'page.charset.worker.delay', '2', null);
INSERT INTO config VALUES ('23', 'urltask.fallout', '0', null);

-- ----------------------------
-- Table structure for `page`
-- ----------------------------
DROP TABLE IF EXISTS `page`;
CREATE TABLE `page` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pageid` bigint(20) NOT NULL,
  `title` varchar(300) NOT NULL,
  `viewnum` int(11) NOT NULL DEFAULT '0',
  `cover` varchar(50) NOT NULL,
  `imgnum` int(11) DEFAULT '0',
  `status` int(11) DEFAULT NULL,
  `cuserid` bigint(20) NOT NULL,
  `cusername` varchar(50) NOT NULL,
  `cdate` bigint(30) DEFAULT NULL,
  `udate` bigint(30) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of page
-- ----------------------------

-- ----------------------------
-- Table structure for `page_discs`
-- ----------------------------
DROP TABLE IF EXISTS `page_discs`;
CREATE TABLE `page_discs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pageid` bigint(20) NOT NULL,
  `userid` bigint(20) NOT NULL,
  `username` varchar(30) NOT NULL,
  `discuss` varchar(300) NOT NULL,
  `cdate` bigint(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of page_discs
-- ----------------------------

-- ----------------------------
-- Table structure for `page_ext`
-- ----------------------------
DROP TABLE IF EXISTS `page_ext`;
CREATE TABLE `page_ext` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pageid` bigint(20) NOT NULL,
  `keywords` varchar(300) DEFAULT '1',
  `orgurl` varchar(1000) NOT NULL DEFAULT '0',
  `description` varchar(400) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of page_ext
-- ----------------------------

-- ----------------------------
-- Table structure for `page_img`
-- ----------------------------
DROP TABLE IF EXISTS `page_img`;
CREATE TABLE `page_img` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pageid` bigint(20) NOT NULL,
  `img` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of page_img
-- ----------------------------

-- ----------------------------
-- Table structure for `page_tag`
-- ----------------------------
DROP TABLE IF EXISTS `page_tag`;
CREATE TABLE `page_tag` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pageid` bigint(20) NOT NULL,
  `tagid` int(11) NOT NULL,
  `tag` varchar(30) NOT NULL,
  `num` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `pageidtagid` (`pageid`,`tagid`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of page_tag
-- ----------------------------

-- ----------------------------
-- Table structure for `photo_hash`
-- ----------------------------
DROP TABLE IF EXISTS `photo_hash`;
CREATE TABLE `photo_hash` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `hashcode` bigint(20) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `RRR` (`hashcode`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of photo_hash
-- ----------------------------

-- ----------------------------
-- Table structure for `photo_task`
-- ----------------------------
DROP TABLE IF EXISTS `photo_task`;
CREATE TABLE `photo_task` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sitename` varchar(200) DEFAULT NULL,
  `imgurl` varchar(1000) DEFAULT NULL,
  `excnum` int(11) NOT NULL DEFAULT '0',
  `hashcode` bigint(20) NOT NULL,
  `suffix` varchar(100) DEFAULT NULL,
  `cdate` varchar(30) NOT NULL,
  `udate` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of photo_task
-- ----------------------------

-- ----------------------------
-- Table structure for `tag`
-- ----------------------------
DROP TABLE IF EXISTS `tag`;
CREATE TABLE `tag` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tagid` int(11) NOT NULL,
  `tag` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tag
-- ----------------------------

-- ----------------------------
-- Table structure for `url_hash`
-- ----------------------------
DROP TABLE IF EXISTS `url_hash`;
CREATE TABLE `url_hash` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `hashcode` bigint(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of url_hash
-- ----------------------------

-- ----------------------------
-- Table structure for `url_task`
-- ----------------------------
DROP TABLE IF EXISTS `url_task`;
CREATE TABLE `url_task` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pageid` varchar(32) NOT NULL,
  `charset` varchar(50) DEFAULT NULL,
  `url` varchar(1000) DEFAULT NULL,
  `excnum` int(11) NOT NULL DEFAULT '0',
  `hashcode` bigint(20) NOT NULL,
  `deep` int(11) DEFAULT '1',
  `regx` varchar(300) DEFAULT NULL,
  `cdate` varchar(30) NOT NULL,
  `udate` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of url_task
-- ----------------------------

-- ----------------------------
-- Table structure for `user`
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` bigint(20) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(50) DEFAULT NULL,
  `tel` varchar(20) DEFAULT NULL,
  `password` varchar(20) NOT NULL DEFAULT '',
  `photo` varchar(50) DEFAULT NULL,
  `vip` int(11) DEFAULT '0',
  `status` int(11) DEFAULT NULL,
  `cdate` bigint(20) NOT NULL,
  `udate` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of user
-- ----------------------------

-- ----------------------------
-- Table structure for `website`
-- ----------------------------
DROP TABLE IF EXISTS `website`;
CREATE TABLE `website` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` varchar(1000) NOT NULL,
  `charset` varchar(50) DEFAULT NULL,
  `regx` varchar(300) DEFAULT NULL,
  `cycle` int(11) DEFAULT '300' COMMENT '采集周期单位秒',
  `udate` bigint(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of website
-- ----------------------------
INSERT INTO website VALUES ('4', 'http://www.douban.com/group/meituikong/', 'UTF-8', 'douban.com/group/topic/.*', null, '1405123070338');
