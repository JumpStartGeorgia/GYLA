<?php defined('SYSPATH') or die('No direct script access.'); ?>

2011-12-27 14:18:53 --- ERROR: Database_Exception [ 1146 ]: Table 'gyla.seaved_search' doesn't exist [ SELECT `saved_search`.* FROM `seaved_search` ] ~ MODPATH/database/classes/kohana/database/mysql.php [ 181 ]
2011-12-27 14:24:44 --- ERROR: ErrorException [ 2 ]: json_encode() expects at least 1 parameter, 0 given ~ APPPATH/classes/controller/people.php [ 633 ]
2011-12-27 14:24:55 --- ERROR: ErrorException [ 8 ]: Undefined variable: saved_search ~ APPPATH/classes/controller/people.php [ 633 ]
2011-12-27 14:26:30 --- ERROR: ErrorException [ 8 ]: Undefined variable: saved_seaches ~ APPPATH/classes/controller/people.php [ 633 ]
2011-12-27 14:28:47 --- ERROR: Database_Exception [ 1054 ]: Unknown column 'saved_search.id,saved_search.name' in 'field list' [ SELECT `saved_search`.`id,saved_search`.`name` FROM `saved_search` ] ~ MODPATH/database/classes/kohana/database/mysql.php [ 181 ]
2011-12-27 14:29:12 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL list_saved_search/index was not found on this server. ~ SYSPATH/classes/kohana/request/client/internal.php [ 94 ]
2011-12-27 14:30:47 --- ERROR: Database_Exception [ 1054 ]: Unknown column 'saved_search.id,saved_search.name' in 'field list' [ SELECT `saved_search`.`id,saved_search`.`name` FROM `saved_search` ] ~ MODPATH/database/classes/kohana/database/mysql.php [ 181 ]
2011-12-27 14:52:01 --- ERROR: ErrorException [ 2 ]: base64_decode() expects parameter 1 to be string, array given ~ APPPATH/classes/controller/people.php [ 641 ]
2011-12-27 15:48:37 --- ERROR: ErrorException [ 8 ]: Undefined offset: 0 ~ APPPATH/classes/controller/people.php [ 641 ]
2011-12-27 16:15:41 --- ERROR: ErrorException [ 8 ]: Undefined offset: 0 ~ APPPATH/classes/controller/people.php [ 641 ]
2011-12-27 16:16:37 --- ERROR: ErrorException [ 8 ]: Undefined offset: 0 ~ APPPATH/classes/controller/people.php [ 641 ]
2011-12-27 16:16:41 --- ERROR: ErrorException [ 8 ]: Undefined offset: 0 ~ APPPATH/classes/controller/people.php [ 641 ]
2011-12-27 16:19:02 --- ERROR: ErrorException [ 8 ]: Undefined offset: 0 ~ APPPATH/classes/controller/people.php [ 641 ]
2011-12-27 16:19:30 --- ERROR: ErrorException [ 8 ]: Undefined offset: 0 ~ APPPATH/classes/controller/people.php [ 641 ]
2011-12-27 16:50:19 --- ERROR: Kohana_View_Exception [ 0 ]: The requested view forms/people_search could not be found ~ SYSPATH/classes/kohana/view.php [ 252 ]
2011-12-27 17:01:15 --- ERROR: ErrorException [ 8 ]: Undefined variable: content ~ APPPATH/views/layout/default.php [ 32 ]
2011-12-27 17:02:56 --- ERROR: ErrorException [ 8 ]: Undefined variable: search_form ~ APPPATH/views/people.php [ 2 ]