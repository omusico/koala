-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2014 年 03 月 28 日 17:37
-- 服务器版本: 5.6.12-log
-- PHP 版本: 5.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `koalacms`
--
CREATE DATABASE IF NOT EXISTS `koalacms` default CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `koalacms`;

-- --------------------------------------------------------

--
-- 表的结构 `koala_auth_group`
--

CREATE TABLE IF NOT EXISTS `koala_auth_group` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `title` char(100) NOT NULL default '',
  `rules` char(80) NOT NULL default '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  default CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- 转存表中的数据 `koala_auth_group`
--

INSERT INTO `koala_auth_group` (`id`, `title`, `rules`) VALUES
(1, '', '1,2,3,4,5,6,7');

-- --------------------------------------------------------

--
-- 表的结构 `koala_auth_group_access`
--

CREATE TABLE IF NOT EXISTS `koala_auth_group_access` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` mediumint(8) unsigned NOT NULL,
  `gid` mediumint(8) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uid_2` (`uid`,`gid`),
  KEY `uid` (`uid`),
  KEY `group_id` (`gid`)
) ENGINE=MyISAM  default CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `koala_auth_group_access`
--

INSERT INTO `koala_auth_group_access` (`id`, `uid`, `gid`) VALUES
(1, 1, 1),
(2, 1, 2);

-- --------------------------------------------------------

--
-- 表的结构 `koala_auth_rule`
--

CREATE TABLE IF NOT EXISTS `koala_auth_rule` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` char(10) NOT NULL default '',
  `title` char(20) NOT NULL default '',
  `type` tinyint(1) NOT NULL default '0',
  `condition` char(100) NOT NULL default '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  default CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- 转存表中的数据 `koala_auth_rule`
--

INSERT INTO `koala_auth_rule` (`id`, `name`, `title`, `type`, `condition`) VALUES
(1, 'put', '', 0, ''),
(2, 'get', '', 0, ''),
(3, 'post', '', 0, '');

-- --------------------------------------------------------

--
-- 表的结构 `koala_user`
--

CREATE TABLE IF NOT EXISTS `koala_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  default CHARSET=utf8 COMMENT='用户' AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `koala_user`
--

INSERT INTO `koala_user` (`id`, `name`) VALUES
(1, 'test');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
