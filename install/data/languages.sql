SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";



CREATE TABLE IF NOT EXISTS `languages` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `language` varchar(50) CHARACTER SET utf8 NOT NULL,
  `status` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=29 ;

INSERT INTO `languages` (`id`, `language`, `status`) VALUES
(1, 'ქართული', 'default'),
(2, 'რუსული', 'default'),
(3, 'ინგლისური', 'default'),
(4, 'გერმანული', NULL),
(5, 'ფრანგული', NULL),
(20, 'ნუსხური', NULL),
(19, 'იაპონური', NULL),
(18, 'იტალიური', NULL),
(17, 'ჩინური', NULL),
(16, 'თურქული', NULL),
(21, 'ზანური', NULL),
(22, 'ჩანური', NULL);
