SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


CREATE TABLE IF NOT EXISTS `user_groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;


INSERT INTO `user_groups` (`id`, `name`, `description`) VALUES
(1, 'საერთო წევრები', ''),
(2, 'ადმინისტრატორი', 'Administrative user, has access to everything.');
