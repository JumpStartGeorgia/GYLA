<?php defined('SYSPATH') or die('No direct script access.'); ?>

2011-08-26 11:50:29 --- ERROR: HTTP_Exception_404 [ 404 ]: Unable to find a route to match the URI: scripts/theme/default/style.css ~ SYSPATH/classes/kohana/request.php [ 760 ]
2011-08-26 11:50:30 --- ERROR: HTTP_Exception_404 [ 404 ]: Unable to find a route to match the URI: scripts/img/blank.gif ~ SYSPATH/classes/kohana/request.php [ 760 ]
2011-08-26 11:52:42 --- ERROR: HTTP_Exception_404 [ 404 ]: Unable to find a route to match the URI: scripts/theme/default/style.css ~ SYSPATH/classes/kohana/request.php [ 760 ]
2011-08-26 11:52:43 --- ERROR: HTTP_Exception_404 [ 404 ]: Unable to find a route to match the URI: scripts/img/blank.gif ~ SYSPATH/classes/kohana/request.php [ 760 ]
2011-08-26 12:06:29 --- ERROR: HTTP_Exception_404 [ 404 ]: Unable to find a route to match the URI: scripts/theme/default/style.css ~ SYSPATH/classes/kohana/request.php [ 760 ]
2011-08-26 12:06:30 --- ERROR: HTTP_Exception_404 [ 404 ]: Unable to find a route to match the URI: scripts/img/blank.gif ~ SYSPATH/classes/kohana/request.php [ 760 ]
2011-08-26 13:07:48 --- ERROR: ErrorException [ 8 ]: Undefined variable: content ~ APPPATH/views/layout/default.php [ 69 ]
2011-08-26 13:10:48 --- ERROR: ErrorException [ 4 ]: syntax error, unexpected T_EXIT ~ APPPATH/classes/controller/events.php [ 134 ]
2011-08-26 13:10:57 --- ERROR: ErrorException [ 8 ]: Undefined variable: content ~ APPPATH/views/layout/default.php [ 69 ]
2011-08-26 13:11:36 --- ERROR: ErrorException [ 4 ]: syntax error, unexpected T_VARIABLE ~ APPPATH/classes/controller/events.php [ 118 ]
2011-08-26 13:12:02 --- ERROR: ErrorException [ 8 ]: Undefined variable: edit ~ APPPATH/views/people.php [ 5 ]
2011-08-26 13:13:53 --- ERROR: ErrorException [ 8 ]: Undefined variable: content ~ APPPATH/views/layout/default.php [ 69 ]
2011-08-26 13:14:27 --- ERROR: ErrorException [ 8 ]: Undefined variable: content ~ APPPATH/views/layout/default.php [ 69 ]
2011-08-26 13:14:29 --- ERROR: ErrorException [ 8 ]: Undefined variable: content ~ APPPATH/views/layout/default.php [ 69 ]
2011-08-26 13:18:46 --- ERROR: ErrorException [ 4 ]: syntax error, unexpected T_VARIABLE ~ APPPATH/classes/controller/events.php [ 122 ]
2011-08-26 13:19:06 --- ERROR: ErrorException [ 8 ]: session_start(): ps_files_cleanup_dir: opendir(/var/lib/php5) failed: Permission denied (13) ~ APPPATH/classes/controller/application.php [ 18 ]
2011-08-26 13:21:44 --- ERROR: ErrorException [ 8 ]: Undefined variable: content ~ APPPATH/views/layout/default.php [ 69 ]
2011-08-26 13:23:27 --- ERROR: ErrorException [ 8 ]: Undefined variable: edit ~ APPPATH/views/people.php [ 8 ]
2011-08-26 13:24:38 --- ERROR: ErrorException [ 8 ]: Undefined index: name ~ APPPATH/views/people.php [ 14 ]
2011-08-26 13:26:43 --- ERROR: ErrorException [ 8 ]: Undefined index: type ~ APPPATH/views/people.php [ 36 ]
2011-08-26 13:32:50 --- ERROR: Database_Exception [ 1052 ]: Column 'id' in where clause is ambiguous [ SELECT `people`.* FROM `people` JOIN `education_degrees` ON (`people`.`id` = `education_degrees`.`person_id`) WHERE `id` = '16' ORDER BY `first_name` ] ~ MODPATH/database/classes/kohana/database/mysql.php [ 181 ]
2011-08-26 13:41:07 --- ERROR: ErrorException [ 8 ]: Undefined variable: sql ~ APPPATH/classes/controller/people.php [ 68 ]
2011-08-26 13:41:17 --- ERROR: ErrorException [ 8 ]: Undefined variable: people ~ APPPATH/views/person.php [ 7 ]
2011-08-26 13:44:12 --- ERROR: ErrorException [ 8 ]: Undefined variable: people ~ APPPATH/views/person.php [ 5 ]
2011-08-26 13:44:29 --- ERROR: ErrorException [ 4 ]: syntax error, unexpected ':' ~ APPPATH/views/person.php [ 8 ]
2011-08-26 13:44:35 --- ERROR: ErrorException [ 8 ]: Undefined variable: people ~ APPPATH/views/person.php [ 5 ]
2011-08-26 13:44:51 --- ERROR: ErrorException [ 8 ]: Undefined index: type ~ APPPATH/views/person.php [ 37 ]
2011-08-26 13:53:09 --- ERROR: ErrorException [ 8 ]: Undefined variable: nbmp ~ APPPATH/views/person.php [ 6 ]
2011-08-26 13:53:36 --- ERROR: ErrorException [ 8 ]: Undefined index: office ~ APPPATH/views/person.php [ 72 ]
2011-08-26 13:53:56 --- ERROR: ErrorException [ 8 ]: Undefined index: office ~ APPPATH/views/person.php [ 72 ]
2011-08-26 13:58:38 --- ERROR: ErrorException [ 4 ]: syntax error, unexpected T_VARIABLE, expecting ',' or ';' ~ APPPATH/views/person.php [ 60 ]
2011-08-26 13:59:38 --- ERROR: ErrorException [ 4 ]: syntax error, unexpected T_CONSTANT_ENCAPSED_STRING ~ APPPATH/views/person.php [ 60 ]
2011-08-26 14:16:11 --- ERROR: ErrorException [ 8 ]: Undefined index: office ~ APPPATH/views/person.php [ 81 ]
2011-08-26 14:37:18 --- ERROR: ErrorException [ 4 ]: syntax error, unexpected $end ~ APPPATH/views/offices.php [ 51 ]
2011-08-26 14:37:34 --- ERROR: ErrorException [ 8 ]: Undefined variable: office ~ APPPATH/views/offices.php [ 4 ]
2011-08-26 14:37:48 --- ERROR: ErrorException [ 8 ]: Undefined variable: allow_edit ~ APPPATH/views/offices.php [ 7 ]
2011-08-26 14:47:59 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL people/people/ajax_set_sessions was not found on this server. ~ SYSPATH/classes/kohana/request/client/internal.php [ 120 ]
2011-08-26 14:48:26 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL people/people/ajax_set_sessions was not found on this server. ~ SYSPATH/classes/kohana/request/client/internal.php [ 120 ]
2011-08-26 14:48:35 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL people/people/ajax_set_sessions was not found on this server. ~ SYSPATH/classes/kohana/request/client/internal.php [ 120 ]
2011-08-26 14:48:52 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL people/people/ajax_set_sessions was not found on this server. ~ SYSPATH/classes/kohana/request/client/internal.php [ 120 ]
2011-08-26 14:50:15 --- ERROR: ErrorException [ 8 ]: Undefined variable: allow_edit ~ APPPATH/views/people.php [ 8 ]
2011-08-26 15:03:38 --- ERROR: Kohana_View_Exception [ 0 ]: The requested view login could not be found ~ SYSPATH/classes/kohana/view.php [ 252 ]
2011-08-26 15:13:45 --- ERROR: ErrorException [ 8 ]: Undefined variable: i ~ APPPATH/views/calendar.php [ 14 ]
2011-08-26 15:19:34 --- ERROR: ErrorException [ 8 ]: Undefined variable: month_number ~ APPPATH/views/calendar.php [ 25 ]
2011-08-26 15:27:07 --- ERROR: ErrorException [ 8 ]: session_start(): ps_files_cleanup_dir: opendir(/var/lib/php5) failed: Permission denied (13) ~ APPPATH/classes/controller/application.php [ 18 ]
2011-08-26 15:30:05 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL 2011/index was not found on this server. ~ SYSPATH/classes/kohana/request/client/internal.php [ 94 ]
2011-08-26 15:30:14 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL 2011/index was not found on this server. ~ SYSPATH/classes/kohana/request/client/internal.php [ 94 ]
2011-08-26 15:40:14 --- ERROR: ErrorException [ 4 ]: syntax error, unexpected '(' ~ APPPATH/views/calendar.php [ 29 ]
2011-08-26 15:55:27 --- ERROR: ErrorException [ 4 ]: syntax error, unexpected ']' ~ APPPATH/views/calendar.php [ 40 ]
2011-08-26 15:57:12 --- ERROR: ErrorException [ 8 ]: Undefined offset: 12 ~ APPPATH/classes/controller/events.php [ 66 ]
2011-08-26 15:59:03 --- ERROR: ErrorException [ 8 ]: Undefined offset: 12 ~ APPPATH/classes/controller/events.php [ 66 ]
2011-08-26 15:59:08 --- ERROR: ErrorException [ 8 ]: Undefined offset: 1 ~ APPPATH/classes/controller/events.php [ 60 ]
2011-08-26 15:59:27 --- ERROR: ErrorException [ 8 ]: Undefined offset: 1 ~ APPPATH/classes/controller/events.php [ 60 ]
2011-08-26 16:01:43 --- ERROR: ErrorException [ 4 ]: syntax error, unexpected ';' ~ APPPATH/views/calendar.php [ 41 ]
2011-08-26 16:40:26 --- ERROR: ErrorException [ 8 ]: session_start(): ps_files_cleanup_dir: opendir(/var/lib/php5) failed: Permission denied (13) ~ APPPATH/classes/controller/application.php [ 18 ]
2011-08-26 17:09:44 --- ERROR: ErrorException [ 8 ]: Undefined index: user_password ~ APPPATH/classes/controller/user.php [ 93 ]
2011-08-26 17:26:27 --- ERROR: ErrorException [ 8 ]: Undefined index: event_name ~ APPPATH/classes/controller/user.php [ 174 ]
2011-08-26 17:27:41 --- ERROR: ErrorException [ 8 ]: Undefined index: first_name ~ APPPATH/classes/controller/user.php [ 174 ]
2011-08-26 17:27:56 --- ERROR: ErrorException [ 8 ]: Undefined index: id ~ APPPATH/classes/controller/user.php [ 188 ]
2011-08-26 17:34:41 --- ERROR: ErrorException [ 8 ]: Undefined variable: content ~ APPPATH/views/layout/default.php [ 35 ]
2011-08-26 17:35:10 --- ERROR: ErrorException [ 8 ]: Undefined variable: content ~ APPPATH/views/layout/default.php [ 35 ]