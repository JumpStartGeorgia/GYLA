<?php defined('SYSPATH') or die('No direct script access.'); ?>

2011-12-21 13:00:32 --- ERROR: ErrorException [ 1 ]: Call to undefined function mysql_connect() ~ MODPATH/database/classes/kohana/database/mysql.php [ 59 ]
2011-12-21 13:01:40 --- ERROR: Database_Exception [ 1045 ]: Access denied for user 'root'@'localhost' (using password: YES) ~ MODPATH/database/classes/kohana/database/mysql.php [ 67 ]
2011-12-21 13:01:40 --- ERROR: Database_Exception [ 1045 ]: Access denied for user 'root'@'localhost' (using password: YES) ~ MODPATH/database/classes/kohana/database/mysql.php [ 67 ]
2011-12-21 13:02:26 --- ERROR: Database_Exception [ 1146 ]: Table 'gyla.permissions' doesn't exist [ SELECT * FROM `permissions` WHERE `user_id` = 0 ] ~ MODPATH/database/classes/kohana/database/mysql.php [ 181 ]
2011-12-21 14:22:44 --- ERROR: ErrorException [ 8 ]: Undefined index: username ~ APPPATH/classes/controller/user.php [ 234 ]
2011-12-21 14:23:37 --- ERROR: ErrorException [ 8 ]: Undefined index: username ~ APPPATH/classes/controller/user.php [ 234 ]
2011-12-21 14:23:57 --- ERROR: HTTP_Exception_404 [ 404 ]: Unable to find a route to match the URI: index.php ~ SYSPATH/classes/kohana/request.php [ 760 ]
2011-12-21 14:24:02 --- ERROR: HTTP_Exception_404 [ 404 ]: Unable to find a route to match the URI: index.php ~ SYSPATH/classes/kohana/request.php [ 760 ]