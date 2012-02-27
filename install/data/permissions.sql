SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


CREATE TABLE IF NOT EXISTS `permissions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `group_id` int(11) NOT NULL,
  `resource` varchar(50) DEFAULT NULL,
  `privilege` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=36 ;

INSERT INTO `permissions` (`id`, `user_id`, `group_id`, `resource`, `privilege`) VALUES
(1, NULL, 1, 'events', 'map'),
(2, NULL, 2, 'admin', 'management'),
(3, NULL, 2, 'offices', 'delete'),
(4, NULL, 2, 'offices', 'edit'),
(5, NULL, 2, 'offices', 'add'),
(6, NULL, 2, 'offices', 'view'),
(7, NULL, 2, 'events', 'map'),
(8, NULL, 2, 'events', 'calendar'),
(9, NULL, 2, 'events', 'delete'),
(10, NULL, 2, 'events', 'edit'),
(11, NULL, 2, 'events', 'add'),
(12, NULL, 2, 'events', 'view'),
(13, NULL, 2, 'searches', 'delete'),
(14, NULL, 2, 'searches', 'add'),
(15, NULL, 2, 'searches', 'view'),
(16, NULL, 2, 'people', 'search'),
(17, NULL, 2, 'people', 'delete'),
(18, NULL, 2, 'people', 'edit'),
(19, NULL, 2, 'people', 'add'),
(20, NULL, 2, 'people', 'view_all'),
(21, NULL, 2, 'people', 'view_own'),
(22, NULL, 2, 'wall', 'delete_comment'),
(23, NULL, 1, 'events', 'calendar'),
(24, NULL, 1, 'events', 'add'),
(25, NULL, 1, 'events', 'view'),
(26, NULL, 2, 'wall', 'add_comment'),
(27, NULL, 2, 'wall', 'delete'),
(28, NULL, 2, 'wall', 'add'),
(29, NULL, 2, 'wall', 'view'),
(30, NULL, 1, 'searches', 'view'),
(31, NULL, 1, 'people', 'view_own'),
(32, NULL, 1, 'wall', 'add_comment'),
(33, NULL, 1, 'wall', 'add'),
(34, NULL, 1, 'wall', 'view'),
(35, NULL, 1, 'offices', 'view');
