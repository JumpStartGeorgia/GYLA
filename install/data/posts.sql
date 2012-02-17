SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";



CREATE TABLE IF NOT EXISTS `posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `body` text NOT NULL,
  `published_at` datetime NOT NULL,
  `attachment_url` varchar(255) DEFAULT NULL,
  `embed_code` text,
  `user_id` int(11) NOT NULL,
  `type` varchar(20) NOT NULL,
  PRIMARY KEY (`id`),
  FULLTEXT KEY `search` (`title`,`body`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;
