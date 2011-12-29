<?php defined('SYSPATH') or die('No direct script access.'); ?>

2011-08-24 13:23:34 --- ERROR: ErrorException [ 8 ]: Undefined index: video_title ~ APPPATH/classes/controller/user.php [ 89 ]
2011-08-24 13:58:53 --- ERROR: ErrorException [ 8 ]: Undefined index: password ~ APPPATH/classes/controller/user.php [ 88 ]
2011-08-24 14:09:15 --- ERROR: ErrorException [ 8 ]: Undefined variable: content ~ APPPATH/views/layout/default.php [ 68 ]
2011-08-24 14:57:19 --- ERROR: Database_Exception [ 1136 ]: Column count doesn't match value count at row 1 [ INSERT INTO `permissions` (`user_id`, `resource`, `privilege`) VALUES ((4, 'wall', 'view'), (4, 'wall', 'add'), (4, 'wall', 'add_comment'), (4, 'people', 'view'), (4, 'people', 'search'), (4, 'searches', 'view'), (4, 'events', 'view'), (4, 'events', 'add'), (4, 'events', 'calendar'), (4, 'events', 'map'), (4, 'offices', 'view')) ] ~ MODPATH/database/classes/kohana/database/mysql.php [ 181 ]
2011-08-24 15:00:23 --- ERROR: ErrorException [ 8 ]: Undefined index: user_password ~ APPPATH/classes/controller/user.php [ 92 ]
2011-08-24 15:00:26 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL user/news was not found on this server. ~ SYSPATH/classes/kohana/request/client/internal.php [ 120 ]
2011-08-24 15:00:43 --- ERROR: Database_Exception [ 1062 ]: Duplicate entry 'otto' for key 'uniq_username' [ INSERT INTO `users` (`first_name`, `last_name`, `email`, `username`, `password`) VALUES ('otar', 'chekurishvili', 'otto@jumpstart.ge', 'otto', 'blah') ] ~ MODPATH/database/classes/kohana/database/mysql.php [ 181 ]
2011-08-24 15:19:00 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL logout/index was not found on this server. ~ SYSPATH/classes/kohana/request/client/internal.php [ 94 ]
2011-08-24 15:26:49 --- ERROR: ErrorException [ 8 ]: Undefined property: Request::$action ~ APPPATH/classes/controller/user.php [ 11 ]
2011-08-24 15:27:49 --- ERROR: ErrorException [ 1 ]: Call to undefined method Controller_User::request() ~ APPPATH/classes/controller/user.php [ 11 ]
2011-08-24 15:30:13 --- ERROR: ErrorException [ 8 ]: Undefined property: Request::$action ~ APPPATH/classes/controller/user.php [ 11 ]
2011-08-24 15:30:19 --- ERROR: ErrorException [ 1 ]: Cannot access protected property Request::$_action ~ APPPATH/classes/controller/user.php [ 11 ]
2011-08-24 15:31:34 --- ERROR: ErrorException [ 8 ]: Undefined property: Request::$controller ~ APPPATH/classes/controller/user.php [ 11 ]
2011-08-24 15:31:44 --- ERROR: ErrorException [ 8 ]: Undefined property: Request::$controller ~ APPPATH/classes/controller/user.php [ 11 ]
2011-08-24 15:31:45 --- ERROR: ErrorException [ 8 ]: Undefined property: Request::$controller ~ APPPATH/classes/controller/user.php [ 11 ]
2011-08-24 15:31:45 --- ERROR: ErrorException [ 8 ]: Undefined property: Request::$controller ~ APPPATH/classes/controller/user.php [ 11 ]
2011-08-24 15:31:45 --- ERROR: ErrorException [ 8 ]: Undefined property: Request::$controller ~ APPPATH/classes/controller/user.php [ 11 ]
2011-08-24 15:31:45 --- ERROR: ErrorException [ 8 ]: Undefined property: Request::$controller ~ APPPATH/classes/controller/user.php [ 11 ]
2011-08-24 15:32:51 --- ERROR: ErrorException [ 8 ]: Undefined property: Request::$controller ~ APPPATH/classes/controller/user.php [ 11 ]
2011-08-24 15:32:51 --- ERROR: ErrorException [ 8 ]: Undefined property: Request::$controller ~ APPPATH/classes/controller/user.php [ 11 ]
2011-08-24 15:32:51 --- ERROR: ErrorException [ 8 ]: Undefined property: Request::$controller ~ APPPATH/classes/controller/user.php [ 11 ]
2011-08-24 15:32:52 --- ERROR: ErrorException [ 8 ]: Undefined property: Request::$controller ~ APPPATH/classes/controller/user.php [ 11 ]
2011-08-24 15:33:11 --- ERROR: ErrorException [ 1 ]: Call to a member function has() on a non-object ~ APPPATH/classes/controller/application.php [ 76 ]
2011-08-24 15:33:12 --- ERROR: ErrorException [ 1 ]: Call to a member function has() on a non-object ~ APPPATH/classes/controller/application.php [ 76 ]
2011-08-24 15:33:12 --- ERROR: ErrorException [ 1 ]: Call to a member function has() on a non-object ~ APPPATH/classes/controller/application.php [ 76 ]
2011-08-24 15:33:12 --- ERROR: ErrorException [ 1 ]: Call to a member function has() on a non-object ~ APPPATH/classes/controller/application.php [ 76 ]
2011-08-24 15:44:22 --- ERROR: HTTP_Exception_404 [ 404 ]: Unable to find a route to match the URI: main/index/images/images/ajax-loader.gif ~ SYSPATH/classes/kohana/request.php [ 760 ]
2011-08-24 17:08:03 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL search/indexvax was not found on this server. ~ SYSPATH/classes/kohana/request/client/internal.php [ 94 ]
2011-08-24 17:08:16 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL search/index/undefined was not found on this server. ~ SYSPATH/classes/kohana/request/client/internal.php [ 94 ]
2011-08-24 17:08:29 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL search/index/undefined was not found on this server. ~ SYSPATH/classes/kohana/request/client/internal.php [ 94 ]
2011-08-24 17:08:32 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL search/index/asdadasd was not found on this server. ~ SYSPATH/classes/kohana/request/client/internal.php [ 94 ]
2011-08-24 17:08:46 --- ERROR: ErrorException [ 8 ]: Use of undefined constant request - assumed 'request' ~ APPPATH/classes/controller/search.php [ 10 ]
2011-08-24 17:09:03 --- ERROR: Database_Exception [ 1191 ]: Can't find FULLTEXT index matching the column list [  
            SELECT id,name, 
                MATCH(name, address, contact_info) AGAINST('asd') AS score
                FROM events
            WHERE MATCH(name, address, contact_info) AGAINST('asd')
            ORDER BY score DESC
         ] ~ MODPATH/database/classes/kohana/database/mysql.php [ 181 ]
2011-08-24 17:09:39 --- ERROR: Database_Exception [ 1191 ]: Can't find FULLTEXT index matching the column list [  
            SELECT id,name, 
                MATCH(name, address, contact_info) AGAINST('asdasd') AS score
                FROM events
            WHERE MATCH(name, address, contact_info) AGAINST('asdasd')
            ORDER BY score DESC
         ] ~ MODPATH/database/classes/kohana/database/mysql.php [ 181 ]
2011-08-24 17:09:46 --- ERROR: Database_Exception [ 1191 ]: Can't find FULLTEXT index matching the column list [  
            SELECT id,name, 
                MATCH(name, address, contact_info) AGAINST('vaja') AS score
                FROM events
            WHERE MATCH(name, address, contact_info) AGAINST('vaja')
            ORDER BY score DESC
         ] ~ MODPATH/database/classes/kohana/database/mysql.php [ 181 ]
2011-08-24 17:09:50 --- ERROR: Database_Exception [ 1191 ]: Can't find FULLTEXT index matching the column list [  
            SELECT id,name, 
                MATCH(name, address, contact_info) AGAINST('vazha') AS score
                FROM events
            WHERE MATCH(name, address, contact_info) AGAINST('vazha')
            ORDER BY score DESC
         ] ~ MODPATH/database/classes/kohana/database/mysql.php [ 181 ]
2011-08-24 17:10:25 --- ERROR: Database_Exception [ 1191 ]: Can't find FULLTEXT index matching the column list [  
            SELECT id,name, 
                MATCH(name, address, contact_info) AGAINST('vazha') AS score
                FROM events
            WHERE MATCH(name, address, contact_info) AGAINST('vazha')
            ORDER BY score DESC
         ] ~ MODPATH/database/classes/kohana/database/mysql.php [ 181 ]
2011-08-24 17:11:32 --- ERROR: Database_Exception [ 1191 ]: Can't find FULLTEXT index matching the column list [  
            SELECT id,name, 
                MATCH(name, address, contact_info) AGAINST('vazha') AS score
                FROM events
            WHERE MATCH(name, address, contact_info) AGAINST('vazha')
            ORDER BY score DESC
         ] ~ MODPATH/database/classes/kohana/database/mysql.php [ 181 ]
2011-08-24 17:11:33 --- ERROR: Database_Exception [ 1191 ]: Can't find FULLTEXT index matching the column list [  
            SELECT id,name, 
                MATCH(name, address, contact_info) AGAINST('vazha') AS score
                FROM events
            WHERE MATCH(name, address, contact_info) AGAINST('vazha')
            ORDER BY score DESC
         ] ~ MODPATH/database/classes/kohana/database/mysql.php [ 181 ]
2011-08-24 17:11:34 --- ERROR: Database_Exception [ 1191 ]: Can't find FULLTEXT index matching the column list [  
            SELECT id,name, 
                MATCH(name, address, contact_info) AGAINST('vazha') AS score
                FROM events
            WHERE MATCH(name, address, contact_info) AGAINST('vazha')
            ORDER BY score DESC
         ] ~ MODPATH/database/classes/kohana/database/mysql.php [ 181 ]
2011-08-24 17:12:44 --- ERROR: Database_Exception [ 1191 ]: Can't find FULLTEXT index matching the column list [  
            SELECT id,title,
                MATCH(title, body) AGAINST('vazha') AS score
                FROM posts
            WHERE MATCH(title, body) AGAINST('vazha')
            ORDER BY score DESC
         ] ~ MODPATH/database/classes/kohana/database/mysql.php [ 181 ]
2011-08-24 17:16:26 --- ERROR: Database_Exception [ 1191 ]: Can't find FULLTEXT index matching the column list [  
            SELECT id,name, 
                MATCH(name, address, contact_info) AGAINST('asdads') AS score
                FROM events
            WHERE MATCH(name, address, contact_info) AGAINST('asdads')
            ORDER BY score DESC
         ] ~ MODPATH/database/classes/kohana/database/mysql.php [ 181 ]
2011-08-24 17:16:58 --- ERROR: Database_Exception [ 1191 ]: Can't find FULLTEXT index matching the column list [  
            SELECT id,name, 
                MATCH(name, address, contact_info) AGAINST('asdasda') AS score
                FROM events
            WHERE MATCH(name, address, contact_info) AGAINST('asdasda')
            ORDER BY score DESC
         ] ~ MODPATH/database/classes/kohana/database/mysql.php [ 181 ]
2011-08-24 17:17:40 --- ERROR: Database_Exception [ 1191 ]: Can't find FULLTEXT index matching the column list [  
            SELECT id,name, 
                MATCH(name, address, contact_info) AGAINST('vava') AS score
                FROM events
            WHERE MATCH(name, address, contact_info) AGAINST('vava')
            ORDER BY score DESC
         ] ~ MODPATH/database/classes/kohana/database/mysql.php [ 181 ]
2011-08-24 17:18:47 --- ERROR: Database_Exception [ 1191 ]: Can't find FULLTEXT index matching the column list [  
            SELECT id,name,
                MATCH(name, address, contact_info) AGAINST('test') AS score
                FROM events
            WHERE MATCH(name, address, contact_info) AGAINST('test')
            ORDER BY score DESC
         ] ~ MODPATH/database/classes/kohana/database/mysql.php [ 181 ]
2011-08-24 17:22:55 --- ERROR: Database_Exception [ 1191 ]: Can't find FULLTEXT index matching the column list [  
            SELECT id,name,
                MATCH(name, address, contact_info) AGAINST('test') AS score
                FROM events
            WHERE MATCH(name, address, contact_info) AGAINST('test')
            ORDER BY score DESC
         ] ~ MODPATH/database/classes/kohana/database/mysql.php [ 181 ]
2011-08-24 17:22:56 --- ERROR: Database_Exception [ 1191 ]: Can't find FULLTEXT index matching the column list [  
            SELECT id,name,
                MATCH(name, address, contact_info) AGAINST('test') AS score
                FROM events
            WHERE MATCH(name, address, contact_info) AGAINST('test')
            ORDER BY score DESC
         ] ~ MODPATH/database/classes/kohana/database/mysql.php [ 181 ]
2011-08-24 17:22:57 --- ERROR: Database_Exception [ 1191 ]: Can't find FULLTEXT index matching the column list [  
            SELECT id,name,
                MATCH(name, address, contact_info) AGAINST('test') AS score
                FROM events
            WHERE MATCH(name, address, contact_info) AGAINST('test')
            ORDER BY score DESC
         ] ~ MODPATH/database/classes/kohana/database/mysql.php [ 181 ]
2011-08-24 17:22:57 --- ERROR: Database_Exception [ 1191 ]: Can't find FULLTEXT index matching the column list [  
            SELECT id,name,
                MATCH(name, address, contact_info) AGAINST('test') AS score
                FROM events
            WHERE MATCH(name, address, contact_info) AGAINST('test')
            ORDER BY score DESC
         ] ~ MODPATH/database/classes/kohana/database/mysql.php [ 181 ]
2011-08-24 17:22:57 --- ERROR: Database_Exception [ 1191 ]: Can't find FULLTEXT index matching the column list [  
            SELECT id,name,
                MATCH(name, address, contact_info) AGAINST('test') AS score
                FROM events
            WHERE MATCH(name, address, contact_info) AGAINST('test')
            ORDER BY score DESC
         ] ~ MODPATH/database/classes/kohana/database/mysql.php [ 181 ]
2011-08-24 17:22:57 --- ERROR: Database_Exception [ 1191 ]: Can't find FULLTEXT index matching the column list [  
            SELECT id,name,
                MATCH(name, address, contact_info) AGAINST('test') AS score
                FROM events
            WHERE MATCH(name, address, contact_info) AGAINST('test')
            ORDER BY score DESC
         ] ~ MODPATH/database/classes/kohana/database/mysql.php [ 181 ]
2011-08-24 17:23:30 --- ERROR: Database_Exception [ 1191 ]: Can't find FULLTEXT index matching the column list [  
            SELECT id,name,
                MATCH(name, address, contact_info) AGAINST('test') AS score
                FROM events
            WHERE MATCH(name, address, contact_info) AGAINST('test')
            ORDER BY score DESC
         ] ~ MODPATH/database/classes/kohana/database/mysql.php [ 181 ]
2011-08-24 17:23:31 --- ERROR: Database_Exception [ 1191 ]: Can't find FULLTEXT index matching the column list [  
            SELECT id,name,
                MATCH(name, address, contact_info) AGAINST('test') AS score
                FROM events
            WHERE MATCH(name, address, contact_info) AGAINST('test')
            ORDER BY score DESC
         ] ~ MODPATH/database/classes/kohana/database/mysql.php [ 181 ]
2011-08-24 17:23:31 --- ERROR: Database_Exception [ 1191 ]: Can't find FULLTEXT index matching the column list [  
            SELECT id,name,
                MATCH(name, address, contact_info) AGAINST('test') AS score
                FROM events
            WHERE MATCH(name, address, contact_info) AGAINST('test')
            ORDER BY score DESC
         ] ~ MODPATH/database/classes/kohana/database/mysql.php [ 181 ]
2011-08-24 17:31:54 --- ERROR: Database_Exception [ 1191 ]: Can't find FULLTEXT index matching the column list [  
            SELECT id,title,
                MATCH(title, body) AGAINST('test') AS score
                FROM posts
            WHERE MATCH(title, body) AGAINST('test')
            ORDER BY score DESC
         ] ~ MODPATH/database/classes/kohana/database/mysql.php [ 181 ]
2011-08-24 17:34:44 --- ERROR: ErrorException [ 8 ]: Undefined index: events ~ APPPATH/views/search_results.php [ 4 ]
2011-08-24 17:48:56 --- ERROR: Kohana_View_Exception [ 0 ]: The requested view user could not be found ~ SYSPATH/classes/kohana/view.php [ 252 ]
2011-08-24 17:49:00 --- ERROR: Kohana_View_Exception [ 0 ]: The requested view user could not be found ~ SYSPATH/classes/kohana/view.php [ 252 ]
2011-08-24 17:49:37 --- ERROR: ErrorException [ 8 ]: Undefined variable: forms ~ APPPATH/views/post.php [ 9 ]
2011-08-24 17:49:57 --- ERROR: ErrorException [ 8 ]: Undefined variable: display ~ APPPATH/views/post.php [ 40 ]
2011-08-24 17:50:05 --- ERROR: ErrorException [ 8 ]: Undefined variable: index ~ APPPATH/views/post.php [ 40 ]
2011-08-24 17:50:12 --- ERROR: ErrorException [ 8 ]: Undefined index: first_name ~ APPPATH/views/post.php [ 46 ]
2011-08-24 17:51:24 --- ERROR: Database_Exception [ 1052 ]: Column 'id' in where clause is ambiguous [ 
		SELECT
			posts.*,
			`users`.`first_name`,
			`users`.`last_name`,
			`users`.`username`,
			`users`.`id` AS `user_id`,
			(SELECT
				COUNT(id) 
			FROM
				comments
			WHERE
				post_id = posts.id)
			AS
				total_comments
		FROM 
			`posts`
		JOIN
			`users`
		ON
			(`posts`.`user_id` = `users`.`id`)
		WHERE
			id = 1
		 ] ~ MODPATH/database/classes/kohana/database/mysql.php [ 181 ]
2011-08-24 17:51:32 --- ERROR: HTTP_Exception_404 [ 404 ]: Unable to find a route to match the URI: post/post/images/images/ajax-loader.gif ~ SYSPATH/classes/kohana/request.php [ 760 ]
2011-08-24 17:51:48 --- ERROR: HTTP_Exception_404 [ 404 ]: Unable to find a route to match the URI: post/post/images/images/ajax-loader.gif ~ SYSPATH/classes/kohana/request.php [ 760 ]
2011-08-24 17:51:54 --- ERROR: HTTP_Exception_404 [ 404 ]: Unable to find a route to match the URI: post/post/images/images/ajax-loader.gif ~ SYSPATH/classes/kohana/request.php [ 760 ]
2011-08-24 17:56:16 --- ERROR: HTTP_Exception_404 [ 404 ]: Unable to find a route to match the URI: post/post/comment/ajax_read_comments/1 ~ SYSPATH/classes/kohana/request.php [ 760 ]
2011-08-24 17:57:42 --- ERROR: HTTP_Exception_404 [ 404 ]: Unable to find a route to match the URI: post/post/comment/ajax_read_comments/1 ~ SYSPATH/classes/kohana/request.php [ 760 ]
2011-08-24 17:57:52 --- ERROR: HTTP_Exception_404 [ 404 ]: Unable to find a route to match the URI: post/post/comment/ajax_read_comments/1 ~ SYSPATH/classes/kohana/request.php [ 760 ]
2011-08-24 17:57:54 --- ERROR: HTTP_Exception_404 [ 404 ]: Unable to find a route to match the URI: post/post/kohanagyla/comment/ajax_read_comments/1 ~ SYSPATH/classes/kohana/request.php [ 760 ]
2011-08-24 17:58:17 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL post/comment/ajax_read_comments/1 was not found on this server. ~ SYSPATH/classes/kohana/request/client/internal.php [ 120 ]
2011-08-24 18:00:48 --- ERROR: HTTP_Exception_404 [ 404 ]: Unable to find a route to match the URI: post/post/comment/ajax_submit_comment/1 ~ SYSPATH/classes/kohana/request.php [ 760 ]
2011-08-24 18:01:03 --- ERROR: HTTP_Exception_404 [ 404 ]: Unable to find a route to match the URI: post/post/comment/ajax_read_comments/1 ~ SYSPATH/classes/kohana/request.php [ 760 ]
2011-08-24 18:03:27 --- ERROR: HTTP_Exception_404 [ 404 ]: Unable to find a route to match the URI: post/post/1/comment/ajax_read_comments/1 ~ SYSPATH/classes/kohana/request.php [ 760 ]
2011-08-24 18:04:03 --- ERROR: HTTP_Exception_404 [ 404 ]: Unable to find a route to match the URI: post/post/comment/ajax_read_comments/1 ~ SYSPATH/classes/kohana/request.php [ 760 ]