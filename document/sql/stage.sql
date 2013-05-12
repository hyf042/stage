-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2013 年 05 月 12 日 18:01
-- 服务器版本: 5.5.31
-- PHP 版本: 5.3.10-1ubuntu3.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `stage`
--

-- --------------------------------------------------------

--
-- 表的结构 `sta_Comment`
--

CREATE TABLE IF NOT EXISTS `sta_Comment` (
  `comment_id` int(11) NOT NULL AUTO_INCREMENT,
  `game_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `content` varchar(1024) DEFAULT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`comment_id`),
  KEY `FK_HasCommemt` (`game_id`),
  KEY `FK_OwnComment` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `sta_Game`
--

CREATE TABLE IF NOT EXISTS `sta_Game` (
  `game_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(128) NOT NULL,
  `alias` varchar(128) DEFAULT NULL,
  `price` double DEFAULT NULL,
  `deploy_url` varchar(256) NOT NULL,
  `tags` varchar(256) DEFAULT NULL,
  `summary` varchar(1024) DEFAULT NULL,
  `description` varchar(4096) DEFAULT NULL,
  `params` varchar(1024) DEFAULT NULL,
  PRIMARY KEY (`game_id`),
  KEY `FK_developer` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14 ;

--
-- 转存表中的数据 `sta_Game`
--

INSERT INTO `sta_Game` (`game_id`, `user_id`, `name`, `alias`, `price`, `deploy_url`, `tags`, `summary`, `description`, `params`) VALUES
(12, 2, 'BakeryGirl', '面包房少女', 0, 'http://10.155.0.115/stage/data/test.zip', '', '硬派SLG回归', '尚未上传，请勿购买。', NULL),
(13, 2, 'Hamster Ball', '仓鼠球', 0, 'http://10.155.0.115/stage/data/hamster.zip', '', '好玩的仓鼠球', '真的很有意思', NULL);

-- --------------------------------------------------------

--
-- 表的结构 `sta_UnderVerifiedGame`
--

CREATE TABLE IF NOT EXISTS `sta_UnderVerifiedGame` (
  `game_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(30) NOT NULL,
  `tags` varchar(256) DEFAULT NULL,
  `summary` varchar(1024) DEFAULT NULL,
  `content` varchar(4096) DEFAULT NULL,
  `download_url` varchar(256) DEFAULT NULL,
  `params` varchar(1024) DEFAULT NULL,
  PRIMARY KEY (`game_id`),
  KEY `FK_IsDeveloper` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `sta_user`
--

CREATE TABLE IF NOT EXISTS `sta_user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL,
  `password` varchar(128) NOT NULL,
  `nickname` varchar(20) NOT NULL,
  `email` varchar(128) NOT NULL,
  `wallet` double NOT NULL,
  `params` varchar(1024) DEFAULT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `sta_user`
--

INSERT INTO `sta_user` (`user_id`, `username`, `password`, `nickname`, `email`, `wallet`, `params`) VALUES
(1, 'hyf042', '$1$$kix5B3eua3vczi82BnQMW1', 'hyf042', 'hyf042@gmail.com', 0, NULL),
(2, 'admin', '$1$$CoERg7ynjYLsj2j4glJ34.', 'admin', 'admin@admin.com', 0, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `sta_UserAndGame`
--

CREATE TABLE IF NOT EXISTS `sta_UserAndGame` (
  `user_id` int(11) NOT NULL,
  `game_id` int(11) NOT NULL,
  PRIMARY KEY (`user_id`,`game_id`),
  KEY `FK_sta_GameOwnUser` (`game_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `sta_UserAndGame`
--

INSERT INTO `sta_UserAndGame` (`user_id`, `game_id`) VALUES
(1, 12),
(2, 12),
(1, 13),
(2, 13);

--
-- 限制导出的表
--

--
-- 限制表 `sta_Comment`
--
ALTER TABLE `sta_Comment`
  ADD CONSTRAINT `FK_HasCommemt` FOREIGN KEY (`game_id`) REFERENCES `sta_Game` (`game_id`),
  ADD CONSTRAINT `FK_OwnComment` FOREIGN KEY (`user_id`) REFERENCES `sta_user` (`user_id`);

--
-- 限制表 `sta_Game`
--
ALTER TABLE `sta_Game`
  ADD CONSTRAINT `FK_developer` FOREIGN KEY (`user_id`) REFERENCES `sta_user` (`user_id`);

--
-- 限制表 `sta_UnderVerifiedGame`
--
ALTER TABLE `sta_UnderVerifiedGame`
  ADD CONSTRAINT `FK_IsDeveloper` FOREIGN KEY (`user_id`) REFERENCES `sta_user` (`user_id`);

--
-- 限制表 `sta_UserAndGame`
--
ALTER TABLE `sta_UserAndGame`
  ADD CONSTRAINT `FK_sta_GameOwnUser` FOREIGN KEY (`game_id`) REFERENCES `sta_Game` (`game_id`),
  ADD CONSTRAINT `FK_sta_UserOwnGame` FOREIGN KEY (`user_id`) REFERENCES `sta_user` (`user_id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
