<?php

defined('SYSPATH') OR exit('No direct script access.');

class Controller_Wall extends Controller_Application
{

    public function action_index()
    {
    
    //print_r($_SESSION);die;
    
        if (isset($_SESSION['userid']) AND !empty($_SESSION['userid']))
            $this->check_access('wall', 'view');

        if (!empty($_SESSION['username']) AND !empty($_SESSION['userid']))
            $this->template->content = View::factory('posts');
        else
            return;

        $id = $this->request->param('id');
        empty($id) AND $id = 1;

        $sql = "
		SELECT
			users.*,
                        posts.*,
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
			`people` AS users
		ON
			(`posts`.`user_id` = `users`.`id`)
		ORDER BY
			`published_at`
		DESC
		LIMIT
			" . ($id * 10 - 10) . ",10
		";
        $posts = $this->db->query(Database::SELECT, $sql)->as_array();

        $sql = "SELECT COUNT(id) AS total_posts FROM posts";
        $total_posts = $this->db->query(Database::SELECT, $sql)->as_array();

        $this->template->quick_links = array(
            'http://www.google.com/' => 'Google Inc.',
            'hello/world' => 'Hello World!'
        );

        $this->template->content->forms = array
            (
		        View::factory('forms/text'),
		        View::factory('forms/photo'),
		        View::factory('forms/video'),
		        View::factory('forms/document')
        	);

        $this->template->content->posts = $posts;
        $this->template->content->allow_delete = $this->check_access('wall', 'delete', FALSE);
        $this->template->content->total_posts = $total_posts[0]['total_posts'];
        $this->template->content->current_page = $id;
        $this->template->content->show = ($this->request->param('optional') == 'show');
    }

}

