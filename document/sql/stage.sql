-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- 主机: 127.0.0.1
-- 生成日期: 2013 年 06 月 27 日 18:42
-- 服务器版本: 5.5.27
-- PHP 版本: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `stage-test`
--

-- --------------------------------------------------------

--
-- 表的结构 `pre_auth_assignment`
--

CREATE TABLE IF NOT EXISTS `pre_auth_assignment` (
  `itemname` varchar(64) NOT NULL,
  `userid` varchar(64) NOT NULL,
  `bizrule` text,
  `data` text,
  PRIMARY KEY (`itemname`,`userid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- 转存表中的数据 `pre_auth_assignment`
--

INSERT INTO `pre_auth_assignment` (`itemname`, `userid`, `bizrule`, `data`) VALUES
('player', '4', NULL, 'N;');

-- --------------------------------------------------------

--
-- 表的结构 `pre_auth_item`
--

CREATE TABLE IF NOT EXISTS `pre_auth_item` (
  `name` varchar(64) NOT NULL,
  `type` int(11) NOT NULL,
  `description` text,
  `bizrule` text,
  `data` text,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- 转存表中的数据 `pre_auth_item`
--

INSERT INTO `pre_auth_item` (`name`, `type`, `description`, `bizrule`, `data`) VALUES
('administrator', 2, '', NULL, 'N;'),
('adminTask', 1, 'admin all', 'return Yii::app()->user->id=="admin";', 'N;'),
('adminWorks', 0, 'admin operations', NULL, 'N;'),
('developer', 2, '', NULL, 'N;'),
('guest', 2, '', NULL, 'N;'),
('player', 2, '', NULL, 'N;'),
('playerTask', 1, 'player task', 'return !Yii::app()->user->isGuest;', 'N;'),
('playerWorks', 0, 'player operations', NULL, 'N;'),
('publishWorks', 0, 'publish operations', NULL, 'N;'),
('viewWorks', 0, 'view shop and games', NULL, 'N;');

-- --------------------------------------------------------

--
-- 表的结构 `pre_auth_item_child`
--

CREATE TABLE IF NOT EXISTS `pre_auth_item_child` (
  `parent` varchar(64) NOT NULL,
  `child` varchar(64) NOT NULL,
  PRIMARY KEY (`parent`,`child`),
  KEY `child` (`child`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- 转存表中的数据 `pre_auth_item_child`
--

INSERT INTO `pre_auth_item_child` (`parent`, `child`) VALUES
('administrator', 'adminTask'),
('adminTask', 'adminWorks'),
('developer', 'player'),
('player', 'playerTask'),
('playerTask', 'playerWorks'),
('developer', 'publishWorks'),
('guest', 'viewWorks'),
('player', 'viewWorks');

-- --------------------------------------------------------

--
-- 表的结构 `sta_comment`
--

CREATE TABLE IF NOT EXISTS `sta_comment` (
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
-- 表的结构 `sta_game`
--

CREATE TABLE IF NOT EXISTS `sta_game` (
  `game_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(128) NOT NULL,
  `alias` varchar(128) DEFAULT NULL,
  `price` double DEFAULT NULL,
  `deploy_url` varchar(256) NOT NULL,
  `tags` varchar(256) DEFAULT NULL,
  `summary` varchar(1024) DEFAULT NULL,
  `description` varchar(4096) DEFAULT NULL,
  `thumb` varchar(128) DEFAULT NULL,
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  `params` varchar(1024) DEFAULT NULL,
  PRIMARY KEY (`game_id`),
  KEY `FK_developer` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

--
-- 转存表中的数据 `sta_game`
--

INSERT INTO `sta_game` (`game_id`, `user_id`, `name`, `alias`, `price`, `deploy_url`, `tags`, `summary`, `description`, `thumb`, `create_time`, `update_time`, `params`) VALUES
(12, 2, 'BakeryGirl', '面包房少女', 0, 'http://localhost/stage/data/bakerygirl.zip', '', '硬派SLG回归', '<div align="center">\r\n\r\n<img src="/stage/images/bakerygirl.jpg" alt="">\r\n\r\n</div>\r\n\r\n《面包房少女》是由同人游戏制作组MICAteam云母组制作的一款正统的策略战棋类游戏，游戏背景发生在近未来，世界由于新的世界大战而重新分裂成两边格局，被称为“第二次冷战”。\r\n\r\n在《面包房少女》中，玩家为了争夺能改变战争格局的尖端技术，新兴的“南极联邦”与老牌列强国家组成的“罗克萨特主义共和国联盟”之间的各种冲突在世界各地展开着。内务部特工蒙德在执行任务的途中遭到伏击失去了记忆，被一位自称“洁芙缇”的银发少女所救。蒙德与洁芙缇突破重重阻碍，试图逃出险境，却遭到了敌我两方的双重追击。随着越来越接近真相，洁芙缇的身份之谜被一点点揭开，蒙德似乎被卷入一个巨大的阴谋中……', 'http://localhost/stage/images/bakerygirl.jpg', 0, 1369155828, NULL),
(13, 2, 'Hamster Ball', '仓鼠球', 0, 'http://localhost/stage/data/hamster.zip', '', '好玩的仓鼠球', '真的很有意思\r\n\r\n看到这张图，你动心了吗？\r\n\r\n![Alt text](/stage/images/ball.jpg)\r\n\r\n### 只要998! ###', 'http://localhost/stage/images/ball.jpg', 0, 1369153841, NULL),
(14, 1, 'Mario', '马里奥', 0, 'http://localhost/stage/data/marioxp.zip', '', '某网友自制的马里奥大叔历险记', '## 马里奥大叔回归！ ##\r\n\r\n勇猛的意大利战士，和他的绿帽小兄弟。\r\n\r\n![Alt text](/stage/images/test.jpg)', 'http://localhost/stage/images/test.jpg', 1, 1369153792, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `sta_underverifiedgame`
--

CREATE TABLE IF NOT EXISTS `sta_underverifiedgame` (
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- 转存表中的数据 `sta_user`
--

INSERT INTO `sta_user` (`user_id`, `username`, `password`, `nickname`, `email`, `wallet`, `params`) VALUES
(1, 'hyf042', '$1$$kix5B3eua3vczi82BnQMW1', 'hyf042', 'hyf042@gmail.com', 0, NULL),
(2, 'admin', '$1$$CoERg7ynjYLsj2j4glJ34.', 'admin', 'admin@admin.com', 0, NULL),
(3, 'alibaba', '$1$$eAxa8n.c5xGIoUHTtBsSF/', 'alibaba', 'alibaba@gm.com', 0, NULL),
(4, 'gooddaddy', '$1$$aP6ZDsRO9vkjMVaMZ8Ff//', 'gooddaddy', 'ko@dkfj.com', 0, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `sta_userandgame`
--

CREATE TABLE IF NOT EXISTS `sta_userandgame` (
  `user_id` int(11) NOT NULL,
  `game_id` int(11) NOT NULL,
  PRIMARY KEY (`user_id`,`game_id`),
  KEY `FK_sta_GameOwnUser` (`game_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `sta_userandgame`
--

INSERT INTO `sta_userandgame` (`user_id`, `game_id`) VALUES
(1, 12),
(2, 12),
(3, 12),
(1, 13),
(2, 13),
(1, 14),
(2, 14),
(4, 14);

--
-- 限制导出的表
--

--
-- 限制表 `pre_auth_assignment`
--
ALTER TABLE `pre_auth_assignment`
  ADD CONSTRAINT `pre_auth_assignment_ibfk_1` FOREIGN KEY (`itemname`) REFERENCES `pre_auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 限制表 `pre_auth_item_child`
--
ALTER TABLE `pre_auth_item_child`
  ADD CONSTRAINT `pre_auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `pre_auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pre_auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `pre_auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 限制表 `sta_comment`
--
ALTER TABLE `sta_comment`
  ADD CONSTRAINT `FK_HasCommemt` FOREIGN KEY (`game_id`) REFERENCES `sta_game` (`game_id`),
  ADD CONSTRAINT `FK_OwnComment` FOREIGN KEY (`user_id`) REFERENCES `sta_user` (`user_id`);

--
-- 限制表 `sta_game`
--
ALTER TABLE `sta_game`
  ADD CONSTRAINT `FK_developer` FOREIGN KEY (`user_id`) REFERENCES `sta_user` (`user_id`);

--
-- 限制表 `sta_underverifiedgame`
--
ALTER TABLE `sta_underverifiedgame`
  ADD CONSTRAINT `FK_IsDeveloper` FOREIGN KEY (`user_id`) REFERENCES `sta_user` (`user_id`);

--
-- 限制表 `sta_userandgame`
--
ALTER TABLE `sta_userandgame`
  ADD CONSTRAINT `FK_sta_GameOwnUser` FOREIGN KEY (`game_id`) REFERENCES `sta_game` (`game_id`),
  ADD CONSTRAINT `FK_sta_UserOwnGame` FOREIGN KEY (`user_id`) REFERENCES `sta_user` (`user_id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
