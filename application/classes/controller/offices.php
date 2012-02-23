<?php

defined('SYSPATH') OR exit('No direct script access.');

class Controller_offices extends Controller_Application
{

    public function before()
    {
        parent::before();
        $this->check_access('offices', 'view');
    }

    private function districts()
    {
        $query = DB::select()->from('districts')
                ->where('language', '=', 'ka');
        return $this->db->query(Database::SELECT, $query)->as_array();
    }

    public function action_index()
    {
        $sql = DB::select('offices.*', array('districts.name', 'district_name'), array('offices.name', 'office_name'))
                ->from('offices')
                ->join('districts')
                ->on('offices.district_id', '=', 'districts.id');
        $e = $this->db->query(Database::SELECT, $sql)->as_array();
        $this->template->content = View::factory('offices');
        $this->template->content->offices = $e;
        $this->template->content->allow_edit = $this->check_access('offices', 'edit', FALSE);
    }

    public function action_create()
    {
        $this->check_access('offices', 'add');

        $columns = array
            (
            'name',
            'district_id',
            'manager',
            //'manager_first_name',
            //'manager_last_name',
            'address',
            'phone',
            'fax',
            'email',
            'user_id'
        );
        $values = array
            (
            $_POST['office_name'],
            $_POST['office_district'],
            $_POST['office_manager'],
            /*$_POST['office_first_name'],*/
            /*$_POST['office_last_name'],*/
            $_POST['office_address'],
            $_POST['office_phone'],
            $_POST['office_fax'],
            $_POST['office_email'],
            $_SESSION['userid']
        );
        $query = DB::insert('offices', $columns)->values($values)->execute();
        if ($query)
            $this->request->redirect(URL::site('offices'));
    }

    public function action_new()
    {
        $this->check_access('offices', 'add');

        $this->template->content = View::factory('forms/office');
        $this->template->content->districts = Controller_Events::districts_sorted();
        $this->template->content->office = array(
            'id' => NULL,
            'name' => NULL,
            'user_id' => NULL,
            'district_id' => NULL,
            'manager' => null,
            //'manager_first_name' => NULL,
            //'manager_last_name' => NULL,
            'address' => NULL,
            'phone' => NULL,
            'fax' => NULL,
            'email' => NULL,
            'name' => NULL
        );
    }

    public function action_edit()
    {
        $this->check_access('offices', 'edit');

        $query = DB::select('offices.*')
                ->from('offices')
                ->join('districts')
                ->on('offices.district_id', '=', 'districts.id')
                ->where('offices.id', '=', $this->request->param('id'));
        $e = $this->db->query(Database::SELECT, $query)->as_array();
        if ( empty($e) )  
        	$this->request->redirect(URL::site('offices'));
        $this->template->content = View::factory('forms/office');
        $this->template->content->districts = Controller_Events::districts_sorted();
        $this->template->content->office = $e[0];
    }

    public function action_update()
    {
        $this->check_access('offices', 'edit');

		
        $query = DB::update('offices')
                ->set(array(
                    'name' => $_POST['office_name'],
                    'district_id' => $_POST['office_district'],
                    'manager' => $_POST['office_manager'],
                    /*'manager_first_name' => $_POST['office_first_name'],
                    'manager_last_name' => $_POST['office_last_name'],*/
                    'address' => $_POST['office_address'],
                    'phone' => $_POST['office_phone'],
                    'fax' => $_POST['office_fax'],
                    'email' => $_POST['office_email']
                ))
                ->where('id', '=', $this->request->param('id'))
                ->execute();
         $this->request->redirect(URL::site('offices'));
    }

}
