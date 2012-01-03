<?php

defined('SYSPATH') OR exit('No direct script access.');

class Controller_Admin extends Controller_Application
{

    public function before()
    {
		parent::before();
    	$this->check_access('admin', 'management');
    }


    public function action_index()
    {
		$this->template->content = View::factory('admin');    	
    }

}
