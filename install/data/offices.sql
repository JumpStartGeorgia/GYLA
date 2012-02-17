SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


CREATE TABLE IF NOT EXISTS `offices` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `district_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(70) NOT NULL,
  `manager_first_name` varchar(70) NOT NULL,
  `manager_last_name` varchar(70) NOT NULL,
  `address` varchar(70) NOT NULL,
  `phone` varchar(70) NOT NULL,
  `fax` varchar(70) NOT NULL,
  `email` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;
