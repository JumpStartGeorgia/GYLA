<?php  defined('SYSPATH') or die('No direct script access.');

class Model_Post extends Kohana_Model
{

	public function getPosts($limit = 9999999999999999999999)
	{
		$sql = "SELECT * FROM `posts` ORDER BY `published_at` DESC LIMIT 0, ".$limit;

		return $this->_db->query(Database::SELECT, $sql, FALSE)->as_array();
	}

}
