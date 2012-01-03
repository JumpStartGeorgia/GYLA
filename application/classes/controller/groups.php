<?php

defined('SYSPATH') OR exit('No direct script access.');

class Controller_Groups extends Controller_Application
{

    public function before()
    {
        parent::before();
        $this->check_access('admin', 'management');
    }

    public function action_index()
    {
        $this->template->content = View::factory('groups');
        $this->template->content->allow_del = $this->check_access('admin', 'management', FALSE);
        $this->template->content->groups = DB::select()->from('user_groups')->execute()->as_array();
    }

    public function action_new()
    {
	$this->template->content = View::factory('forms/permissions');
	$this->template->content->status = 'new';
	/*if (empty($_SESSION['message']))
	{
	    $this->template->content->message = '';
	    $_SESSION['redirect_after'] = array('do' => FALSE);
	}
	else
	{
	    $this->template->content->message = $_SESSION['message'];
	    $url = empty($_SESSION['redirect_id']) ? 'new' : 'edit/' . $_SESSION['redirect_id'];
	    $_SESSION['redirect_after'] = array('do' => TRUE, 'url' => 'people/' . $url);
	    unset($_SESSION['message']);
	}*/

        $this->template->content->permissions = Kohana::config('permissions');
        $this->template->content->geo_perms = Kohana::config('perms_in_geo');
        $this->template->content->current_permissions = array();
    }

    public function action_create()
    {
	$insert = DB::insert('user_groups', array('name', 'description'))
		  ->values(array($_POST['group_name'], $_POST['group_description']))
		  ->execute();
	$thisid = $insert[0];

        $permissions = array();
        if (!empty($_POST['permissions']))
	    foreach ($_POST['permissions'] AS $perm)
		$permissions[] = unserialize(base64_decode($perm));

        $columns = array('group_id', 'resource', 'privilege');
        foreach ($permissions as $perm)
        {
            $values = array($thisid, $perm['resource'], $perm['privilege']);
            $query = DB::insert('permissions', $columns)->values($values)->execute();
        }

	/*if (!empty($_SESSION['redirect_after']) AND $_SESSION['redirect_after']['do'])
	{
	    $url = $_SESSION['redirect_after'];
	    unset($_SESSION['redirect_after']);
	    $this->request->redirect(URL::site($url));
	}*/

	$this->request->redirect(URL::site('groups'));
    }

    public function action_edit()
    {
        $thisid = $this->request->param('id');
        $this->template->content = View::factory('forms/permissions');
	$this->template->content->status = 'edit';
        $group = DB::select()->from('user_groups')
                //->join('permissions')
                //->on('users.id', '=', 'permissions.user_id')
                ->where('id', '=', $thisid)
                ->execute()
                ->as_array();

        $current_permissions = array();
        $current_permissions_data = DB::select()->from('permissions')->where('group_id', '=', $thisid)->execute()->as_array();
        foreach ($current_permissions_data AS $perm)
            $current_permissions[$perm['resource']][] = $perm['privilege'];

        $this->template->content->group = $group[0];
        $this->template->content->permissions = Kohana::config('permissions');
        $this->template->content->geo_perms = Kohana::config('perms_in_geo');
        $this->template->content->current_permissions = $current_permissions;
    }
    

    public function action_update()
    {
        $thisid = $this->request->param('id');

	strlen($_POST['group_name']) > 0 AND
	    DB::update('user_groups')
	    ->set(array('name' => $_POST['group_name'], 'description' => $_POST['group_description']))
	    ->where('id', '=', $thisid)
	    ->execute();

        $permissions = array();
        if (!empty($_POST['permissions']))
	    foreach ($_POST['permissions'] AS $perm)
		$permissions[] = unserialize(base64_decode($perm));

        $query = DB::delete('permissions')->where('group_id', '=', $thisid)->execute();

        $columns = array(
            'group_id',
            'resource',
            'privilege',
        );

        foreach ($permissions as $perm)
        {
            $values = array(
                $thisid,
                $perm['resource'],
                $perm['privilege']
            );
            $query = DB::insert('permissions', $columns)->values($values)->execute();
        }

	unset($_SESSION['permissions']);
	$this->set_permissions($_SESSION['userid']);

        $this->request->redirect(URL::site('groups'));
    }



    public function action_delete()
    {
        $id = $this->request->param('id');
        if (empty($id))
        {
            $this->template->content = 'შეცდომა';
            return;
        }

        DB::delete('user_groups')->where('id', '=', $id)->execute();
        DB::delete('permissions')->where('group_id', '=', $id)->execute();
        $this->request->redirect(URL::site('groups'));
    }



}
