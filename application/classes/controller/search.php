<?php

defined('SYSPATH') OR exit('No direct script access.');

class Controller_Search extends Controller_Application
{

    public function action_index()
    {
    	$keyword = $this->request->param('id');

	/*
	$sql = " 
            SELECT id,name,
                MATCH(name, address, contact_info) AGAINST('$keyword' WITH QUERY EXPANSION) AS score
                FROM events
            WHERE MATCH(name, address, contact_info) AGAINST('$keyword' WITH QUERY EXPANSION)
            ORDER BY score DESC
        ";
        */

	$sql = " 
            SELECT id, name
            FROM events
            WHERE
                (
                contact_info LIKE '%{$keyword}%'
                OR name LIKE '%{$keyword}%'
                OR address LIKE '%{$keyword}%'
                )
            ORDER BY start_at
        ";

	$events = $this->db->query(Database::SELECT, $sql)->as_array();

	/*$sql = " 
            SELECT id,title,
                MATCH(title, body) AGAINST('$keyword') AS score
                FROM posts
            WHERE MATCH(title, body) AGAINST('$keyword')
            ORDER BY score DESC
        ";
        */

	$sql = " 
            SELECT id, title, published_at
            FROM posts
            WHERE
                (
                title LIKE '%{$keyword}%'
                OR body LIKE '%{$keyword}%'
                )
            ORDER BY published_at DESC
        ";

	$posts = $this->db->query(Database::SELECT, $sql)->as_array();

	foreach ($posts as &$post)
	{
		$query = DB::select(array('COUNT("id")', 'num'))
			   ->from('posts')
			   ->where('published_at', '>', $post['published_at'])
			   ->execute()
			   ->as_array();

		$count = $query[0]['num'];
		$post['page'] = ( $count + (10 - $count % 10) ) / 10;
	}

	$this->template->content = View::factory('search_results');
	$this->template->content->results = array(
	    'posts' => $posts,
	    'events' => $events
	);
    }

}
