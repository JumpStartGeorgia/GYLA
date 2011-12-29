<?php defined('SYSPATH') or die('No direct script access.'); ?>

2011-08-23 17:10:40 --- ERROR: HTTP_Exception_404 [ 404 ]: Unable to find a route to match the URI: main/uploads/images/763ui-icons_222222_256x240.png ~ SYSPATH/classes/kohana/request.php [ 760 ]
2011-08-23 17:10:40 --- ERROR: HTTP_Exception_404 [ 404 ]: Unable to find a route to match the URI: main/images/images/ajax-loader.gif ~ SYSPATH/classes/kohana/request.php [ 760 ]
2011-08-23 17:10:40 --- ERROR: HTTP_Exception_404 [ 404 ]: Unable to find a route to match the URI: main/uploads/images/867chart.jpg ~ SYSPATH/classes/kohana/request.php [ 760 ]
2011-08-23 17:10:40 --- ERROR: HTTP_Exception_404 [ 404 ]: Unable to find a route to match the URI: main/uploads/images/706screenshot_opentaps.png ~ SYSPATH/classes/kohana/request.php [ 760 ]
2011-08-23 17:10:46 --- ERROR: HTTP_Exception_404 [ 404 ]: Unable to find a route to match the URI: main/uploads/images/867chart.jpg ~ SYSPATH/classes/kohana/request.php [ 760 ]
2011-08-23 17:11:36 --- ERROR: HTTP_Exception_404 [ 404 ]: Unable to find a route to match the URI: main/uploads/images/867chart.jpg ~ SYSPATH/classes/kohana/request.php [ 760 ]
2011-08-23 17:12:40 --- ERROR: HTTP_Exception_404 [ 404 ]: Unable to find a route to match the URI: main/images/images/ajax-loader.gif ~ SYSPATH/classes/kohana/request.php [ 760 ]
2011-08-23 17:15:44 --- ERROR: HTTP_Exception_404 [ 404 ]: Unable to find a route to match the URI: main/index/images/images/ajax-loader.gif ~ SYSPATH/classes/kohana/request.php [ 760 ]
2011-08-23 17:16:02 --- ERROR: HTTP_Exception_404 [ 404 ]: Unable to find a route to match the URI: main/index/images/images/ajax-loader.gif ~ SYSPATH/classes/kohana/request.php [ 760 ]
2011-08-23 17:17:51 --- ERROR: HTTP_Exception_404 [ 404 ]: Unable to find a route to match the URI: main/index/images/images/ajax-loader.gif ~ SYSPATH/classes/kohana/request.php [ 760 ]
2011-08-23 17:17:56 --- ERROR: HTTP_Exception_404 [ 404 ]: Unable to find a route to match the URI: main/index/0.5 ~ SYSPATH/classes/kohana/request.php [ 760 ]
2011-08-23 17:18:02 --- ERROR: HTTP_Exception_404 [ 404 ]: Unable to find a route to match the URI: main/index/.5 ~ SYSPATH/classes/kohana/request.php [ 760 ]
2011-08-23 17:18:05 --- ERROR: HTTP_Exception_404 [ 404 ]: Unable to find a route to match the URI: main/index/images/images/ajax-loader.gif ~ SYSPATH/classes/kohana/request.php [ 760 ]
2011-08-23 17:18:10 --- ERROR: HTTP_Exception_404 [ 404 ]: Unable to find a route to match the URI: main/index/images/images/ajax-loader.gif ~ SYSPATH/classes/kohana/request.php [ 760 ]
2011-08-23 17:20:01 --- ERROR: HTTP_Exception_404 [ 404 ]: Unable to find a route to match the URI: main/index/images/images/ajax-loader.gif ~ SYSPATH/classes/kohana/request.php [ 760 ]
2011-08-23 17:20:24 --- ERROR: HTTP_Exception_404 [ 404 ]: Unable to find a route to match the URI: main/index/images/images/ajax-loader.gif ~ SYSPATH/classes/kohana/request.php [ 760 ]
2011-08-23 17:20:52 --- ERROR: HTTP_Exception_404 [ 404 ]: Unable to find a route to match the URI: main/index/images/images/ajax-loader.gif ~ SYSPATH/classes/kohana/request.php [ 760 ]
2011-08-23 17:21:16 --- ERROR: HTTP_Exception_404 [ 404 ]: Unable to find a route to match the URI: main/index/images/images/ajax-loader.gif ~ SYSPATH/classes/kohana/request.php [ 760 ]
2011-08-23 17:22:56 --- ERROR: HTTP_Exception_404 [ 404 ]: Unable to find a route to match the URI: main/index/images/images/ajax-loader.gif ~ SYSPATH/classes/kohana/request.php [ 760 ]
2011-08-23 17:24:57 --- ERROR: ErrorException [ 8 ]: Undefined variable: post ~ APPPATH/views/posts.php [ 107 ]
2011-08-23 17:25:14 --- ERROR: ErrorException [ 8 ]: Undefined offset: 0 ~ APPPATH/views/posts.php [ 107 ]
2011-08-23 17:25:19 --- ERROR: ErrorException [ 8 ]: Undefined index: total_posts ~ APPPATH/views/posts.php [ 107 ]
2011-08-23 17:32:58 --- ERROR: HTTP_Exception_404 [ 404 ]: Unable to find a route to match the URI: main/index/images/images/ajax-loader.gif ~ SYSPATH/classes/kohana/request.php [ 760 ]
2011-08-23 17:33:31 --- ERROR: HTTP_Exception_404 [ 404 ]: Unable to find a route to match the URI: main/index/images/images/ajax-loader.gif ~ SYSPATH/classes/kohana/request.php [ 760 ]
2011-08-23 17:33:33 --- ERROR: HTTP_Exception_404 [ 404 ]: Unable to find a route to match the URI: main/index/images/images/ajax-loader.gif ~ SYSPATH/classes/kohana/request.php [ 760 ]
2011-08-23 17:33:43 --- ERROR: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '-10,10' at line 25 [ 
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
		ORDER BY
			`published_at`
		DESC
		LIMIT
			-10,10
		 ] ~ MODPATH/database/classes/kohana/database/mysql.php [ 181 ]
2011-08-23 17:33:50 --- ERROR: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '-10,10' at line 25 [ 
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
		ORDER BY
			`published_at`
		DESC
		LIMIT
			-10,10
		 ] ~ MODPATH/database/classes/kohana/database/mysql.php [ 181 ]
2011-08-23 17:33:50 --- ERROR: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '-10,10' at line 25 [ 
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
		ORDER BY
			`published_at`
		DESC
		LIMIT
			-10,10
		 ] ~ MODPATH/database/classes/kohana/database/mysql.php [ 181 ]
2011-08-23 17:33:57 --- ERROR: HTTP_Exception_404 [ 404 ]: Unable to find a route to match the URI: main/index/images/images/ajax-loader.gif ~ SYSPATH/classes/kohana/request.php [ 760 ]
2011-08-23 17:34:00 --- ERROR: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '-10,10' at line 25 [ 
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
		ORDER BY
			`published_at`
		DESC
		LIMIT
			-10,10
		 ] ~ MODPATH/database/classes/kohana/database/mysql.php [ 181 ]
2011-08-23 17:34:31 --- ERROR: HTTP_Exception_404 [ 404 ]: Unable to find a route to match the URI: main/index/images/images/ajax-loader.gif ~ SYSPATH/classes/kohana/request.php [ 760 ]
2011-08-23 17:34:37 --- ERROR: HTTP_Exception_404 [ 404 ]: Unable to find a route to match the URI: main/index/images/images/ajax-loader.gif ~ SYSPATH/classes/kohana/request.php [ 760 ]
2011-08-23 17:34:51 --- ERROR: HTTP_Exception_404 [ 404 ]: Unable to find a route to match the URI: main/index/images/images/ajax-loader.gif ~ SYSPATH/classes/kohana/request.php [ 760 ]
2011-08-23 17:35:01 --- ERROR: HTTP_Exception_404 [ 404 ]: Unable to find a route to match the URI: main/index/images/images/ajax-loader.gif ~ SYSPATH/classes/kohana/request.php [ 760 ]
2011-08-23 17:35:39 --- ERROR: HTTP_Exception_404 [ 404 ]: Unable to find a route to match the URI: main/index/images/images/ajax-loader.gif ~ SYSPATH/classes/kohana/request.php [ 760 ]
2011-08-23 17:36:13 --- ERROR: HTTP_Exception_404 [ 404 ]: Unable to find a route to match the URI: main/index/images/images/ajax-loader.gif ~ SYSPATH/classes/kohana/request.php [ 760 ]
2011-08-23 17:38:00 --- ERROR: ErrorException [ 4 ]: syntax error, unexpected ',' ~ APPPATH/views/posts.php [ 113 ]
2011-08-23 17:38:54 --- ERROR: HTTP_Exception_404 [ 404 ]: Unable to find a route to match the URI: main/index/images/images/ajax-loader.gif ~ SYSPATH/classes/kohana/request.php [ 760 ]
2011-08-23 17:39:09 --- ERROR: HTTP_Exception_404 [ 404 ]: Unable to find a route to match the URI: main/index/images/images/ajax-loader.gif ~ SYSPATH/classes/kohana/request.php [ 760 ]
2011-08-23 17:39:16 --- ERROR: HTTP_Exception_404 [ 404 ]: Unable to find a route to match the URI: main/index/images/images/ajax-loader.gif ~ SYSPATH/classes/kohana/request.php [ 760 ]
2011-08-23 17:39:38 --- ERROR: HTTP_Exception_404 [ 404 ]: Unable to find a route to match the URI: main/index/images/images/ajax-loader.gif ~ SYSPATH/classes/kohana/request.php [ 760 ]
2011-08-23 17:40:28 --- ERROR: HTTP_Exception_404 [ 404 ]: Unable to find a route to match the URI: main/index/images/images/ajax-loader.gif ~ SYSPATH/classes/kohana/request.php [ 760 ]
2011-08-23 17:40:45 --- ERROR: HTTP_Exception_404 [ 404 ]: Unable to find a route to match the URI: main/index/images/images/ajax-loader.gif ~ SYSPATH/classes/kohana/request.php [ 760 ]
2011-08-23 17:41:01 --- ERROR: HTTP_Exception_404 [ 404 ]: Unable to find a route to match the URI: main/index/images/images/ajax-loader.gif ~ SYSPATH/classes/kohana/request.php [ 760 ]
2011-08-23 17:43:05 --- ERROR: HTTP_Exception_404 [ 404 ]: Unable to find a route to match the URI: main/index/images/images/ajax-loader.gif ~ SYSPATH/classes/kohana/request.php [ 760 ]
2011-08-23 17:43:12 --- ERROR: HTTP_Exception_404 [ 404 ]: Unable to find a route to match the URI: main/index/images/images/ajax-loader.gif ~ SYSPATH/classes/kohana/request.php [ 760 ]
2011-08-23 17:43:16 --- ERROR: HTTP_Exception_404 [ 404 ]: Unable to find a route to match the URI: main/index/images/images/ajax-loader.gif ~ SYSPATH/classes/kohana/request.php [ 760 ]
2011-08-23 17:45:03 --- ERROR: ErrorException [ 8 ]: Undefined variable: total_pages ~ APPPATH/views/posts.php [ 114 ]
2011-08-23 17:45:14 --- ERROR: HTTP_Exception_404 [ 404 ]: Unable to find a route to match the URI: main/index/images/images/ajax-loader.gif ~ SYSPATH/classes/kohana/request.php [ 760 ]
2011-08-23 17:45:34 --- ERROR: HTTP_Exception_404 [ 404 ]: Unable to find a route to match the URI: main/index/images/images/ajax-loader.gif ~ SYSPATH/classes/kohana/request.php [ 760 ]
2011-08-23 17:45:40 --- ERROR: HTTP_Exception_404 [ 404 ]: Unable to find a route to match the URI: main/index/images/images/ajax-loader.gif ~ SYSPATH/classes/kohana/request.php [ 760 ]
2011-08-23 17:46:23 --- ERROR: HTTP_Exception_404 [ 404 ]: Unable to find a route to match the URI: main/index/images/images/ajax-loader.gif ~ SYSPATH/classes/kohana/request.php [ 760 ]
2011-08-23 17:46:25 --- ERROR: HTTP_Exception_404 [ 404 ]: Unable to find a route to match the URI: main/index/images/images/ajax-loader.gif ~ SYSPATH/classes/kohana/request.php [ 760 ]
2011-08-23 17:46:41 --- ERROR: HTTP_Exception_404 [ 404 ]: Unable to find a route to match the URI: main/index/images/images/ajax-loader.gif ~ SYSPATH/classes/kohana/request.php [ 760 ]
2011-08-23 17:46:44 --- ERROR: HTTP_Exception_404 [ 404 ]: Unable to find a route to match the URI: main/index/images/images/ajax-loader.gif ~ SYSPATH/classes/kohana/request.php [ 760 ]
2011-08-23 17:47:46 --- ERROR: HTTP_Exception_404 [ 404 ]: Unable to find a route to match the URI: main/index/images/images/ajax-loader.gif ~ SYSPATH/classes/kohana/request.php [ 760 ]
2011-08-23 17:48:08 --- ERROR: HTTP_Exception_404 [ 404 ]: Unable to find a route to match the URI: main/index/images/images/ajax-loader.gif ~ SYSPATH/classes/kohana/request.php [ 760 ]
2011-08-23 17:48:21 --- ERROR: HTTP_Exception_404 [ 404 ]: Unable to find a route to match the URI: main/index/images/images/ajax-loader.gif ~ SYSPATH/classes/kohana/request.php [ 760 ]
2011-08-23 17:48:26 --- ERROR: HTTP_Exception_404 [ 404 ]: Unable to find a route to match the URI: main/index/images/images/ajax-loader.gif ~ SYSPATH/classes/kohana/request.php [ 760 ]
2011-08-23 17:48:31 --- ERROR: HTTP_Exception_404 [ 404 ]: Unable to find a route to match the URI: main/index/images/images/ajax-loader.gif ~ SYSPATH/classes/kohana/request.php [ 760 ]
2011-08-23 17:48:36 --- ERROR: HTTP_Exception_404 [ 404 ]: Unable to find a route to match the URI: main/index/images/images/ajax-loader.gif ~ SYSPATH/classes/kohana/request.php [ 760 ]
2011-08-23 17:48:47 --- ERROR: HTTP_Exception_404 [ 404 ]: Unable to find a route to match the URI: main/index/images/images/ajax-loader.gif ~ SYSPATH/classes/kohana/request.php [ 760 ]
2011-08-23 17:48:54 --- ERROR: HTTP_Exception_404 [ 404 ]: Unable to find a route to match the URI: main/index/images/images/ajax-loader.gif ~ SYSPATH/classes/kohana/request.php [ 760 ]
2011-08-23 17:50:14 --- ERROR: HTTP_Exception_404 [ 404 ]: Unable to find a route to match the URI: main/index/images/images/ajax-loader.gif ~ SYSPATH/classes/kohana/request.php [ 760 ]
2011-08-23 17:50:41 --- ERROR: HTTP_Exception_404 [ 404 ]: Unable to find a route to match the URI: main/index/images/images/ajax-loader.gif ~ SYSPATH/classes/kohana/request.php [ 760 ]
2011-08-23 17:50:54 --- ERROR: HTTP_Exception_404 [ 404 ]: Unable to find a route to match the URI: main/index/images/images/ajax-loader.gif ~ SYSPATH/classes/kohana/request.php [ 760 ]
2011-08-23 17:51:02 --- ERROR: HTTP_Exception_404 [ 404 ]: Unable to find a route to match the URI: main/index/images/images/ajax-loader.gif ~ SYSPATH/classes/kohana/request.php [ 760 ]
2011-08-23 17:51:13 --- ERROR: HTTP_Exception_404 [ 404 ]: Unable to find a route to match the URI: main/index/images/images/ajax-loader.gif ~ SYSPATH/classes/kohana/request.php [ 760 ]
2011-08-23 17:51:21 --- ERROR: HTTP_Exception_404 [ 404 ]: Unable to find a route to match the URI: main/index/images/images/ajax-loader.gif ~ SYSPATH/classes/kohana/request.php [ 760 ]
2011-08-23 17:51:32 --- ERROR: HTTP_Exception_404 [ 404 ]: Unable to find a route to match the URI: main/index/images/images/ajax-loader.gif ~ SYSPATH/classes/kohana/request.php [ 760 ]
2011-08-23 17:51:39 --- ERROR: HTTP_Exception_404 [ 404 ]: Unable to find a route to match the URI: main/index/images/images/ajax-loader.gif ~ SYSPATH/classes/kohana/request.php [ 760 ]
2011-08-23 17:51:44 --- ERROR: HTTP_Exception_404 [ 404 ]: Unable to find a route to match the URI: main/index/images/images/ajax-loader.gif ~ SYSPATH/classes/kohana/request.php [ 760 ]
2011-08-23 17:52:08 --- ERROR: HTTP_Exception_404 [ 404 ]: Unable to find a route to match the URI: main/index/images/images/ajax-loader.gif ~ SYSPATH/classes/kohana/request.php [ 760 ]
2011-08-23 17:52:23 --- ERROR: HTTP_Exception_404 [ 404 ]: Unable to find a route to match the URI: main/index/images/images/ajax-loader.gif ~ SYSPATH/classes/kohana/request.php [ 760 ]
2011-08-23 17:54:26 --- ERROR: ErrorException [ 4 ]: syntax error, unexpected ')', expecting ',' or ';' ~ APPPATH/views/posts.php [ 132 ]
2011-08-23 17:54:47 --- ERROR: ErrorException [ 8 ]: Undefined variable: show_last ~ APPPATH/views/posts.php [ 130 ]
2011-08-23 17:55:06 --- ERROR: HTTP_Exception_404 [ 404 ]: Unable to find a route to match the URI: main/index/images/images/ajax-loader.gif ~ SYSPATH/classes/kohana/request.php [ 760 ]
2011-08-23 17:55:32 --- ERROR: HTTP_Exception_404 [ 404 ]: Unable to find a route to match the URI: main/index/images/images/ajax-loader.gif ~ SYSPATH/classes/kohana/request.php [ 760 ]
2011-08-23 17:56:01 --- ERROR: HTTP_Exception_404 [ 404 ]: Unable to find a route to match the URI: main/index/images/images/ajax-loader.gif ~ SYSPATH/classes/kohana/request.php [ 760 ]
2011-08-23 17:56:38 --- ERROR: HTTP_Exception_404 [ 404 ]: Unable to find a route to match the URI: main/index/images/images/ajax-loader.gif ~ SYSPATH/classes/kohana/request.php [ 760 ]
2011-08-23 17:56:51 --- ERROR: HTTP_Exception_404 [ 404 ]: Unable to find a route to match the URI: main/index/images/images/ajax-loader.gif ~ SYSPATH/classes/kohana/request.php [ 760 ]
2011-08-23 17:56:59 --- ERROR: HTTP_Exception_404 [ 404 ]: Unable to find a route to match the URI: main/index/images/images/ajax-loader.gif ~ SYSPATH/classes/kohana/request.php [ 760 ]
2011-08-23 17:58:58 --- ERROR: ErrorException [ 8 ]: Undefined variable: pages ~ APPPATH/views/posts.php [ 112 ]
2011-08-23 17:59:08 --- ERROR: HTTP_Exception_404 [ 404 ]: Unable to find a route to match the URI: main/index/images/images/ajax-loader.gif ~ SYSPATH/classes/kohana/request.php [ 760 ]
2011-08-23 17:59:45 --- ERROR: HTTP_Exception_404 [ 404 ]: Unable to find a route to match the URI: main/index/images/images/ajax-loader.gif ~ SYSPATH/classes/kohana/request.php [ 760 ]
2011-08-23 17:59:53 --- ERROR: HTTP_Exception_404 [ 404 ]: Unable to find a route to match the URI: main/index/images/images/ajax-loader.gif ~ SYSPATH/classes/kohana/request.php [ 760 ]
2011-08-23 17:59:56 --- ERROR: HTTP_Exception_404 [ 404 ]: Unable to find a route to match the URI: main/index/images/images/ajax-loader.gif ~ SYSPATH/classes/kohana/request.php [ 760 ]
2011-08-23 18:00:14 --- ERROR: HTTP_Exception_404 [ 404 ]: Unable to find a route to match the URI: main/index/images/images/ajax-loader.gif ~ SYSPATH/classes/kohana/request.php [ 760 ]
2011-08-23 18:00:34 --- ERROR: HTTP_Exception_404 [ 404 ]: Unable to find a route to match the URI: main/index/images/images/ajax-loader.gif ~ SYSPATH/classes/kohana/request.php [ 760 ]
2011-08-23 18:02:17 --- ERROR: HTTP_Exception_404 [ 404 ]: Unable to find a route to match the URI: main/index/images/images/ajax-loader.gif ~ SYSPATH/classes/kohana/request.php [ 760 ]
2011-08-23 18:02:23 --- ERROR: HTTP_Exception_404 [ 404 ]: Unable to find a route to match the URI: main/index/images/images/ajax-loader.gif ~ SYSPATH/classes/kohana/request.php [ 760 ]
2011-08-23 18:02:37 --- ERROR: HTTP_Exception_404 [ 404 ]: Unable to find a route to match the URI: main/index/images/images/ajax-loader.gif ~ SYSPATH/classes/kohana/request.php [ 760 ]
2011-08-23 18:02:40 --- ERROR: HTTP_Exception_404 [ 404 ]: Unable to find a route to match the URI: main/index/images/images/ajax-loader.gif ~ SYSPATH/classes/kohana/request.php [ 760 ]
2011-08-23 18:02:50 --- ERROR: HTTP_Exception_404 [ 404 ]: Unable to find a route to match the URI: main/index/images/images/ajax-loader.gif ~ SYSPATH/classes/kohana/request.php [ 760 ]
2011-08-23 18:03:23 --- ERROR: HTTP_Exception_404 [ 404 ]: Unable to find a route to match the URI: main/index/images/images/ajax-loader.gif ~ SYSPATH/classes/kohana/request.php [ 760 ]
2011-08-23 18:03:29 --- ERROR: HTTP_Exception_404 [ 404 ]: Unable to find a route to match the URI: main/index/images/images/ajax-loader.gif ~ SYSPATH/classes/kohana/request.php [ 760 ]
2011-08-23 18:03:50 --- ERROR: HTTP_Exception_404 [ 404 ]: Unable to find a route to match the URI: main/index/images/images/ajax-loader.gif ~ SYSPATH/classes/kohana/request.php [ 760 ]
2011-08-23 18:03:55 --- ERROR: HTTP_Exception_404 [ 404 ]: Unable to find a route to match the URI: main/index/images/images/ajax-loader.gif ~ SYSPATH/classes/kohana/request.php [ 760 ]
2011-08-23 18:03:59 --- ERROR: HTTP_Exception_404 [ 404 ]: Unable to find a route to match the URI: main/index/images/images/ajax-loader.gif ~ SYSPATH/classes/kohana/request.php [ 760 ]
2011-08-23 18:04:10 --- ERROR: HTTP_Exception_404 [ 404 ]: Unable to find a route to match the URI: main/index/images/images/ajax-loader.gif ~ SYSPATH/classes/kohana/request.php [ 760 ]
2011-08-23 18:04:17 --- ERROR: HTTP_Exception_404 [ 404 ]: Unable to find a route to match the URI: main/index/images/images/ajax-loader.gif ~ SYSPATH/classes/kohana/request.php [ 760 ]
2011-08-23 18:04:24 --- ERROR: HTTP_Exception_404 [ 404 ]: Unable to find a route to match the URI: main/index/images/images/ajax-loader.gif ~ SYSPATH/classes/kohana/request.php [ 760 ]
2011-08-23 18:04:54 --- ERROR: HTTP_Exception_404 [ 404 ]: Unable to find a route to match the URI: main/index/images/images/ajax-loader.gif ~ SYSPATH/classes/kohana/request.php [ 760 ]
2011-08-23 18:05:03 --- ERROR: HTTP_Exception_404 [ 404 ]: Unable to find a route to match the URI: main/index/images/images/ajax-loader.gif ~ SYSPATH/classes/kohana/request.php [ 760 ]
2011-08-23 18:05:11 --- ERROR: HTTP_Exception_404 [ 404 ]: Unable to find a route to match the URI: main/index/images/images/ajax-loader.gif ~ SYSPATH/classes/kohana/request.php [ 760 ]
2011-08-23 18:05:30 --- ERROR: HTTP_Exception_404 [ 404 ]: Unable to find a route to match the URI: main/index/images/images/ajax-loader.gif ~ SYSPATH/classes/kohana/request.php [ 760 ]
2011-08-23 18:06:15 --- ERROR: HTTP_Exception_404 [ 404 ]: Unable to find a route to match the URI: main/index/images/images/ajax-loader.gif ~ SYSPATH/classes/kohana/request.php [ 760 ]
2011-08-23 18:29:16 --- ERROR: HTTP_Exception_404 [ 404 ]: Unable to find a route to match the URI: main/index/images/images/ajax-loader.gif ~ SYSPATH/classes/kohana/request.php [ 760 ]