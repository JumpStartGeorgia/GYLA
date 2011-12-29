<?php defined('SYSPATH') or die('No direct script access.'); ?>

2011-12-16 09:13:09 --- ERROR: ErrorException [ 8 ]: Undefined index: username ~ APPPATH/classes/controller/user.php [ 234 ]
2011-12-16 09:15:17 --- ERROR: Database_Exception [ 1054 ]: Unknown column 'Georgian' in 'where clause' [ SELECT * FROM languages WHERE id IN (Georgian,English,Russian,french, latin) ] ~ MODPATH/database/classes/kohana/database/mysql.php [ 181 ]
2011-12-16 09:18:01 --- ERROR: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near ')' at line 1 [ SELECT * FROM languages WHERE id IN (1,2,3,გერმანული, ფრანგული, ) ] ~ MODPATH/database/classes/kohana/database/mysql.php [ 181 ]
2011-12-16 09:18:33 --- ERROR: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near ')' at line 1 [ SELECT * FROM languages WHERE id IN (1,2,3,გერმანული, ფრანგული, ) ] ~ MODPATH/database/classes/kohana/database/mysql.php [ 181 ]
2011-12-16 09:18:59 --- ERROR: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near ')' at line 1 [ SELECT * FROM languages WHERE id IN (1,2,3,გერმანული, ფრანგული, ) ] ~ MODPATH/database/classes/kohana/database/mysql.php [ 181 ]
2011-12-16 09:19:31 --- ERROR: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near ')' at line 1 [ SELECT * FROM languages WHERE id IN (1,2,3,გერმანული, ფრანგული, ) ] ~ MODPATH/database/classes/kohana/database/mysql.php [ 181 ]
2011-12-16 09:20:13 --- ERROR: ErrorException [ 2 ]: implode(): Invalid arguments passed ~ APPPATH/classes/controller/people.php [ 296 ]
2011-12-16 09:25:20 --- ERROR: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near ''(1,2,3,ქართული, გერმანული, ფრანგუ�' at line 1 [ SELECT * FROM `languages` WHERE `language` IN '(1,2,3,ქართული, გერმანული, ფრანგული, )' ] ~ MODPATH/database/classes/kohana/database/mysql.php [ 181 ]
2011-12-16 09:35:08 --- ERROR: ErrorException [ 2 ]: Missing argument 2 for Kohana_Database_MySQL::query(), called in /var/www/gyla/application/classes/controller/people.php on line 370 and defined ~ MODPATH/database/classes/kohana/database/mysql.php [ 155 ]
2011-12-16 09:35:19 --- ERROR: ErrorException [ 8 ]: Undefined variable: status ~ APPPATH/classes/controller/people.php [ 372 ]
2011-12-16 09:40:12 --- ERROR: ErrorException [ 2 ]: explode() expects parameter 2 to be string, array given ~ APPPATH/classes/controller/people.php [ 369 ]
2011-12-16 09:40:23 --- ERROR: ErrorException [ 2 ]: explode() expects parameter 2 to be string, array given ~ APPPATH/classes/controller/people.php [ 369 ]
2011-12-16 09:40:32 --- ERROR: ErrorException [ 2 ]: explode() expects parameter 2 to be string, array given ~ APPPATH/classes/controller/people.php [ 369 ]
2011-12-16 09:50:45 --- ERROR: ErrorException [ 1 ]: [] operator not supported for strings ~ APPPATH/classes/controller/people.php [ 372 ]
2011-12-16 09:51:20 --- ERROR: ErrorException [ 1 ]: [] operator not supported for strings ~ APPPATH/classes/controller/people.php [ 373 ]
2011-12-16 09:52:50 --- ERROR: ErrorException [ 8 ]: Undefined variable: lang_index ~ APPPATH/classes/controller/people.php [ 373 ]
2011-12-16 09:54:04 --- ERROR: ErrorException [ 1 ]: Call to undefined function array_value() ~ APPPATH/classes/controller/people.php [ 377 ]
2011-12-16 09:54:20 --- ERROR: ErrorException [ 1 ]: Call to undefined function array_value() ~ APPPATH/classes/controller/people.php [ 377 ]
2011-12-16 09:55:25 --- ERROR: ErrorException [ 8 ]: Undefined index: personal_languages ~ APPPATH/classes/controller/people.php [ 376 ]
2011-12-16 09:56:30 --- ERROR: ErrorException [ 8 ]: Undefined offset: 0 ~ APPPATH/classes/controller/people.php [ 376 ]
2011-12-16 09:56:48 --- ERROR: ErrorException [ 8 ]: Undefined offset: 0 ~ APPPATH/classes/controller/people.php [ 376 ]
2011-12-16 10:07:21 --- ERROR: ErrorException [ 8 ]: session_start(): ps_files_cleanup_dir: opendir(/var/lib/php5) failed: Permission denied (13) ~ APPPATH/classes/controller/application.php [ 18 ]
2011-12-16 10:14:51 --- ERROR: ErrorException [ 4 ]: syntax error, unexpected T_STRING ~ APPPATH/classes/controller/people.php [ 389 ]
2011-12-16 10:15:00 --- ERROR: ErrorException [ 4 ]: syntax error, unexpected T_VARIABLE ~ APPPATH/classes/controller/people.php [ 389 ]
2011-12-16 10:15:05 --- ERROR: ErrorException [ 4 ]: syntax error, unexpected T_VARIABLE ~ APPPATH/classes/controller/people.php [ 389 ]
2011-12-16 10:22:34 --- ERROR: ErrorException [ 8 ]: Undefined variable: newArray ~ APPPATH/classes/controller/people.php [ 397 ]
2011-12-16 10:22:47 --- ERROR: ErrorException [ 8 ]: Undefined variable: newArray ~ APPPATH/classes/controller/people.php [ 397 ]
2011-12-16 10:23:18 --- ERROR: ErrorException [ 4 ]: syntax error, unexpected '&', expecting T_VARIABLE or '$' ~ APPPATH/classes/controller/people.php [ 395 ]
2011-12-16 10:24:31 --- ERROR: ErrorException [ 8 ]: Undefined variable: GLOBAL ~ APPPATH/classes/controller/people.php [ 397 ]
2011-12-16 10:24:45 --- ERROR: ErrorException [ 8 ]: Undefined variable: _GLOBAL ~ APPPATH/classes/controller/people.php [ 397 ]
2011-12-16 10:24:51 --- ERROR: ErrorException [ 8 ]: Undefined variable: GLOBAL ~ APPPATH/classes/controller/people.php [ 397 ]
2011-12-16 10:28:12 --- ERROR: ErrorException [ 4 ]: syntax error, unexpected '{' ~ APPPATH/classes/controller/people.php [ 398 ]
2011-12-16 10:28:32 --- ERROR: ErrorException [ 8 ]: Undefined variable: newArray ~ APPPATH/classes/controller/people.php [ 400 ]
2011-12-16 10:29:05 --- ERROR: ErrorException [ 1 ]: Call to undefined function prijnt_r() ~ APPPATH/classes/controller/people.php [ 393 ]
2011-12-16 10:37:07 --- ERROR: ErrorException [ 1 ]: Call to undefined function get_define_vars() ~ APPPATH/classes/controller/people.php [ 393 ]
2011-12-16 10:37:57 --- ERROR: ErrorException [ 4 ]: syntax error, unexpected '=', expecting ',' or ';' ~ APPPATH/classes/controller/people.php [ 396 ]
2011-12-16 10:44:31 --- ERROR: ErrorException [ 2 ]: Missing argument 3 for removeempty() ~ APPPATH/classes/controller/people.php [ 394 ]
2011-12-16 10:44:39 --- ERROR: ErrorException [ 8 ]: Undefined variable: newArray ~ APPPATH/classes/controller/people.php [ 397 ]
2011-12-16 10:45:39 --- ERROR: ErrorException [ 8 ]: Undefined offset: 1 ~ APPPATH/classes/controller/people.php [ 398 ]
2011-12-16 10:52:54 --- ERROR: ErrorException [ 1 ]: Call to undefined function in_array_rec() ~ APPPATH/views/forms/person.php [ 276 ]
2011-12-16 10:57:32 --- ERROR: ErrorException [ 2048 ]: call_user_func() expects parameter 1 to be a valid callback, non-static method Controller_People::in_array_rec() should not be called statically ~ APPPATH/views/forms/person.php [ 276 ]
2011-12-16 10:57:55 --- ERROR: ErrorException [ 2 ]: Missing argument 2 for Controller_People::in_array_rec() ~ APPPATH/classes/controller/people.php [ 349 ]
2011-12-16 11:00:23 --- ERROR: ErrorException [ 4096 ]: Argument 1 passed to Kohana_Controller::__construct() must be an instance of Request, none given, called in /var/www/gyla/application/views/forms/person.php on line 273 and defined ~ SYSPATH/classes/kohana/controller.php [ 43 ]
2011-12-16 11:00:32 --- ERROR: ErrorException [ 4096 ]: Argument 1 passed to Kohana_Controller::__construct() must be an instance of Request, none given, called in /var/www/gyla/application/views/forms/person.php on line 273 and defined ~ SYSPATH/classes/kohana/controller.php [ 43 ]
2011-12-16 11:08:52 --- ERROR: ErrorException [ 8 ]: Array to string conversion ~ APPPATH/classes/controller/people.php [ 389 ]
2011-12-16 11:21:04 --- ERROR: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'IF NOT EXISTS INTO languages( language )
												VALUES('ქართულ�' at line 1 [ INSERT IF NOT EXISTS INTO languages( language )
												VALUES('ქართული') ] ~ MODPATH/database/classes/kohana/database/mysql.php [ 181 ]
2011-12-16 11:21:33 --- ERROR: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'IF NOT EXISTS INTO languages( language )
												VALUES('ქართულ�' at line 1 [ INSERT IF NOT EXISTS INTO languages( language )
												VALUES('ქართული') ] ~ MODPATH/database/classes/kohana/database/mysql.php [ 181 ]
2011-12-16 11:25:46 --- ERROR: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'IF NOT EXISTS INTO languages( language )
												VALUES('ქართულ�' at line 1 [ INSERT IF NOT EXISTS INTO languages( language )
												VALUES('ქართული'); ] ~ MODPATH/database/classes/kohana/database/mysql.php [ 181 ]
2011-12-16 11:32:51 --- ERROR: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'IF NOT EXISTS INTO languages( 'language' )
												VALUES('ქართუ�' at line 1 [ INSERT IF NOT EXISTS INTO languages( 'language' )
												VALUES('ქართული'); ] ~ MODPATH/database/classes/kohana/database/mysql.php [ 181 ]
2011-12-16 11:34:32 --- ERROR: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'IF NOT EXISTS INTO languages( language )
												VALUES('ქართულ�' at line 1 [ INSERT IF NOT EXISTS INTO languages( language )
												VALUES('ქართული'); ] ~ MODPATH/database/classes/kohana/database/mysql.php [ 181 ]
2011-12-16 11:35:30 --- ERROR: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'IF NOT EXISTS INTO languages( language )
												VALUES('ქართულ�' at line 1 [ INSERT IF NOT EXISTS INTO languages( language )
												VALUES('ქართული'); ] ~ MODPATH/database/classes/kohana/database/mysql.php [ 181 ]
2011-12-16 11:36:11 --- ERROR: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'IF NOT EXISTS INTO languages( language )
												VALUES('ქართულ�' at line 1 [ INSERT IF NOT EXISTS INTO languages( language )
												VALUES('ქართული'); ] ~ MODPATH/database/classes/kohana/database/mysql.php [ 181 ]
2011-12-16 11:37:18 --- ERROR: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'IF NOT EXISTS INTO languages( language )
												VALUES('á¥áá �' at line 1 [ INSERT IF NOT EXISTS INTO languages( language )
												VALUES('á¥áá áá£áá'); ] ~ MODPATH/database/classes/kohana/database/mysql.php [ 181 ]
2011-12-16 11:37:27 --- ERROR: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'IF NOT EXISTS INTO languages( language )
												VALUES('???????')' at line 1 [ INSERT IF NOT EXISTS INTO languages( language )
												VALUES('???????'); ] ~ MODPATH/database/classes/kohana/database/mysql.php [ 181 ]
2011-12-16 11:38:28 --- ERROR: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'IF NOT EXISTS INTO languages( language )
												VALUES('ქართულ�' at line 1 [ INSERT IF NOT EXISTS INTO languages( language )
												VALUES('ქართული'); ] ~ MODPATH/database/classes/kohana/database/mysql.php [ 181 ]
2011-12-16 11:40:37 --- ERROR: ErrorException [ 4 ]: syntax error, unexpected ';' ~ APPPATH/classes/controller/people.php [ 415 ]
2011-12-16 11:42:09 --- ERROR: ErrorException [ 4 ]: syntax error, unexpected ';' ~ APPPATH/classes/controller/people.php [ 415 ]
2011-12-16 11:52:47 --- ERROR: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'IF NOT EXISTS INTO languages( language )
												VALUES('ქართულ�' at line 1 [ INSERT IF NOT EXISTS INTO languages( language )
												VALUES('ქართული'); ] ~ MODPATH/database/classes/kohana/database/mysql.php [ 181 ]
2011-12-16 11:53:21 --- ERROR: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'IF NOT EXISTS INTO languages( language )
												VALUES('ქართულ�' at line 1 [ INSERT IF NOT EXISTS INTO languages( language )
												VALUES('ქართული'); ] ~ MODPATH/database/classes/kohana/database/mysql.php [ 181 ]
2011-12-16 11:53:32 --- ERROR: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'IF NOT EXISTS INTO languages( language )
												VALUES('ქართულ�' at line 1 [ INSERT IF NOT EXISTS INTO languages( language )
												VALUES('ქართული'); ] ~ MODPATH/database/classes/kohana/database/mysql.php [ 181 ]
2011-12-16 11:53:57 --- ERROR: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'IF NOT EXISTS INTO languages( language )
												VALUES('ქართულ�' at line 1 [ INSERT IF NOT EXISTS INTO languages( language )
												VALUES('ქართული'); ] ~ MODPATH/database/classes/kohana/database/mysql.php [ 181 ]
2011-12-16 11:54:06 --- ERROR: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'IF NOT EXISTS INTO languages( language )
												VALUES('ქართულ�' at line 1 [ INSERT IF NOT EXISTS INTO languages( language )
												VALUES('ქართული'); ] ~ MODPATH/database/classes/kohana/database/mysql.php [ 181 ]
2011-12-16 11:54:29 --- ERROR: ErrorException [ 1 ]: Call to undefined function mb_detec_encoding() ~ APPPATH/classes/controller/people.php [ 415 ]
2011-12-16 11:55:11 --- ERROR: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'IF NOT EXISTS INTO languages( language )
												VALUES('ქართულ�' at line 1 [ INSERT IF NOT EXISTS INTO languages( language )
												VALUES('ქართული'); ] ~ MODPATH/database/classes/kohana/database/mysql.php [ 181 ]
2011-12-16 11:57:35 --- ERROR: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'IF NOT EXISTS INTO languages( language )
												VALUES('ქართულ�' at line 1 [ INSERT IF NOT EXISTS INTO languages( language )
												VALUES('ქართული'); ] ~ MODPATH/database/classes/kohana/database/mysql.php [ 181 ]
2011-12-16 11:57:51 --- ERROR: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'IF NOT EXISTS INTO languages( language )
												VALUES('ქართულ�' at line 1 [ INSERT IF NOT EXISTS INTO languages( language )
												VALUES('ქართული'); ] ~ MODPATH/database/classes/kohana/database/mysql.php [ 181 ]
2011-12-16 11:58:16 --- ERROR: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'IF NOT EXISTS INTO languages( language )
												VALUES(ქართულ�' at line 1 [ INSERT IF NOT EXISTS INTO languages( language )
												VALUES(ქართული); ] ~ MODPATH/database/classes/kohana/database/mysql.php [ 181 ]
2011-12-16 12:13:02 --- ERROR: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'IF NOT EXISTS INTO languages( language )
												VALUES('ქართულ�' at line 1 [ INSERT IF NOT EXISTS INTO languages( language )
												VALUES('ქართული'); ] ~ MODPATH/database/classes/kohana/database/mysql.php [ 181 ]
2011-12-16 12:49:45 --- ERROR: ErrorException [ 2 ]: unserialize() expects parameter 1 to be string, array given ~ APPPATH/views/forms/person.php [ 284 ]
2011-12-16 12:50:07 --- ERROR: ErrorException [ 8 ]: Undefined variable: peson ~ APPPATH/views/forms/person.php [ 284 ]
2011-12-16 12:51:17 --- ERROR: ErrorException [ 8 ]: Undefined variable: peson ~ APPPATH/views/forms/person.php [ 287 ]
2011-12-16 12:55:48 --- ERROR: ErrorException [ 8 ]: Undefined variable: peson ~ APPPATH/views/forms/person.php [ 287 ]