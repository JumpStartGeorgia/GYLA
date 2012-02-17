SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


CREATE TABLE IF NOT EXISTS `people` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `blocked` smallint(6) NOT NULL,
  `group_id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `member_of` varchar(50) NOT NULL,
  `office_id` int(11) DEFAULT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `birth_date` date NOT NULL,
  `personal_number` varchar(200) NOT NULL,
  `sex` varchar(10) NOT NULL,
  `address` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `years_in_school` varchar(10) NOT NULL,
  `position` varchar(100) NOT NULL,
  `organisation` varchar(100) NOT NULL,
  `languages` text NOT NULL,
  `becoming_member_date` date DEFAULT NULL,
  `org_leaving_date` date DEFAULT NULL,
  `gyla_leaving_date` date DEFAULT NULL,
  `reference` varchar(255) NOT NULL,
  `interested_in` text NOT NULL,
  `comment` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=51 ;
