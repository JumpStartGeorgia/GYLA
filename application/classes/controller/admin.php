<?php

defined('SYSPATH') OR exit('No direct script access.');

class Controller_Admin extends Controller_Application
{

    public function before()
    {
        parent::before();
            //$this->check_access('admin', 'management');
    }


    public function action_index()
    {
        $this->template->content = View::factory('admin');
        $this->template->content->admin = $this->check_access('admin', 'management', FALSE);
        $this->template->content->people = array(
            'add' => $this->check_access('people', 'add', FALSE),
            'view' => $this->check_access('people', 'view_all', FALSE),
            'search' => $this->check_access('people', 'search', FALSE)
        );
        $this->template->content->events = array(
            'add' => $this->check_access('events', 'add', FALSE),
            'view' => $this->check_access('events', 'view', FALSE),
            'map' => $this->check_access('events', 'map', FALSE),
            'calendar' => $this->check_access('events', 'calendar', FALSE)
        );
        $this->template->content->offices = array(
            'add' => $this->check_access('offices', 'add', FALSE),
            'view' => $this->check_access('offices', 'view', FALSE)
        );
    }

}
