<?php

defined('SYSPATH') OR exit('No direct script access.');

class Controller_User extends Controller_Application
{

    public function before()
    {
        parent::before();
        //$public_actions = array('denied', 'login', 'logout', 'profile', 'edit_profile', 'update_profile');
        $public_actions = array('denied', 'login', 'logout');
        if (in_array($this->request->action(), $public_actions))
            return;
        $this->check_access('admin', 'management');
    }

    public function action_index()
    {
        $query = DB::select()->from('users')->execute()->as_array();
        $this->template->content = View::factory('users');
        $this->template->content->users = $query;
    }

    public function action_permissions()
    {

        $thisid = $this->request->param('id');

        $query = DB::select()->from('people')
                //->join('permissions')
                //->on('users.id', '=', 'permissions.user_id')
                ->where('id', '=', $thisid)
                ->execute()
                ->as_array();

        $current_permissions = array();
        $current_permissions_data = DB::select()->from('permissions')->where('user_id', '=', $thisid)->execute()->as_array();
        foreach ($current_permissions_data AS $perm)
            $current_permissions[$perm['resource']][] = $perm['privilege'];

        $this->template->content = View::factory('forms/permissions');
        $this->template->content->user = $query[0];
        $this->template->content->permissions = Kohana::config('permissions');
        $this->template->content->geo_perms = Kohana::config('perms_in_geo');
        $this->template->content->current_permissions = $current_permissions;
    }

    public function action_update_permissions()
    {

        $thisid = $this->request->param('id');

        $permissions = array();
        foreach ($_POST['permissions'] AS $perm)
            $permissions[] = unserialize(base64_decode($perm));

        $query = DB::delete('permissions')->where('user_id', '=', $thisid)->execute();

        $columns = array
            (
            'user_id',
            'resource',
            'privilege',
        );

        foreach ($permissions as $perm)
        {
            $values = array
                (
                $thisid,
                $perm['resource'],
                $perm['privilege']
            );
            $query = DB::insert('permissions', $columns)->values($values)->execute();
        }

        $this->request->redirect(URL::site('people'));
    }

    public function action_denied()
    {
        $this->template->content = View::factory('access_denied');
        $this->template->title = 'Access Denied';
    }

    public function action_new()
    {

        $this->template->content = View::factory('forms/user');
    }

    /*
      public function action_create()
      {

      ($_POST['user_password'] == $_POST['user_confirm']) OR $error['confirm'] = "პაროლები არ ემთხვევა";
      empty($_POST['user_firstname']) AND $error['firstname'] = "სახელი არ უნდა იყოს ცარიელი";
      empty($_POST['user_lastname']) AND $error['lastname'] = "გვარი არ უნდა იყოს ცარიელი";
      empty($_POST['user_username']) AND $error['username'] = "მომხმარებლის სახელი არ უნდა იყოს ცარიელი";
      empty($_POST['user_password']) AND $error['password'] = "პაროლი არ უნდა იყოს ცარიელი";
      empty($_POST['user_email']) AND $error['email'] = "ელფოსტა არ უნდა იყოს ცარიელი";

      if (!empty($error))
      {
      $this->template->content = View::factory('forms/user');
      $this->template->content->error = $error;
      return;
      }

      $columns = array
      (
      'first_name',
      'last_name',
      'email',
      'username',
      'password'
      );
      $values = array
      (
      $_POST['user_firstname'],
      $_POST['user_lastname'],
      $_POST['user_email'],
      $_POST['user_username'],
      sha1($_POST['user_password'])
      );
      $insert = DB::insert('users', $columns)->values($values);
      list($insert_id, $affected_rows) = $insert->execute();

      $default_permissions = Kohana::config('default_permissions');
      $permissions = DB::insert('permissions', array('user_id', 'resource', 'privilege'));
      foreach ($default_permissions AS $resource => $privileges)
      {
      foreach ($privileges AS $privilege)
      {
      $permissions->values(array(
      'user_id' => $insert_id,
      'resource' => $resource,
      'privilege' => $privilege
      ));
      }
      }
      $permissions->execute();

      $this->request->redirect(URL::site('user/index'));
      }

      public function action_profile()
      {
      $id = $this->request->param('id');
      empty($id) AND $id = $_SESSION['userid'];

      $query = DB::select()
      ->from('people')
      ->where('id', '=', $id)
      ->limit(1)
      ->execute()
      ->as_array();

      if (empty($query))
      {
      $this->request->redirect(URL::site('user/denied'));
      die;
      }

      $this->template->content = View::factory('profile');
      $this->template->content->user = $query[0];
      $this->template->content->allow_edit = ($query[0]['id'] == $_SESSION['userid']);
      }

      public function action_edit_profile()
      {
      $query = DB::select()
      ->from('people')
      ->where('id', '=', $_SESSION['userid'])
      ->limit(1)
      ->execute()
      ->as_array();

      if (empty($query))
      {
      $this->request->redirect(URL::site('user/denied'));
      die;
      }

      $this->template->content = View::factory('forms/edit_profile');
      $this->template->content->user = $query[0];
      }

      public function action_update_profile()
      {
      if (!isset($_SESSION['userid']) OR empty($_SESSION['userid']))
      {
      $this->request->redirect(URL::site('user/denied'));
      die;
      }

      $error = array();

      $data = array(
      'first_name' => $_POST['first_name'],
      'last_name' => $_POST['last_name'],
      'email' => $_POST['email']
      );

      if (isset($_POST['password']) AND !empty($_POST['password']))
      $data['password'] = sha1($_POST['password']);

      (!empty($_POST['password']) AND $_POST['password'] != $_POST['confirm']) AND $error[] = "პაროლები არ ემთხვევა";

      if (!empty($error))
      {
      $this->template->content = View::factory('forms/edit_profile');
      $this->template->content->error = $error;
      $user = DB::select()
      ->from('users')
      ->where('id', '=', $_SESSION['userid'])
      ->limit(1)
      ->execute()
      ->as_array();
      $this->template->content->user = $user[0];
      }
      else
      {
      $query = DB::update('users')->set($data)->where('id', '=', $_SESSION['userid'])->execute();
      $this->request->redirect(URL::site('user/profile'));
      }
      }
     */

    public function action_login()
    {
        $query = DB::select()->from('people')
                ->where('username', '=', $_POST['username'])
                ->and_where('password', '=', sha1($_POST['password']));

        $user = $this->db->query(Database::SELECT, $query)->as_array();
        if (empty($user))
        {
		$query = DB::select()->from('people')
		        ->where('email', '=', $_POST['username'])
		        ->and_where('password', '=', sha1($_POST['password']));
		$user = $this->db->query(Database::SELECT, $query)->as_array();
		if (empty($user))
		    $this->template->content = View::factory('forms/login') . "<br /><p align='center'>არასწორი სახელი ან პაროლი</p>";
        }
        else
        {
            $_SESSION['username'] = $_POST['username'];
            $_SESSION['userid'] = $user[0]['id'];

            /*
              $query = DB::update('users')
              ->set(array(
              'logins' => $user[0]['logins'] + 1,
              'last_login' => date("Y-m-d")
              ))
              ->where('id', '=', $user[0]['id'])
              ->execute();
             */

            $this->set_permissions($_SESSION['userid']);

            $this->request->redirect(URL::base());
        }
    }

    public function action_logout()
    {
        if
        (
                isset($_SESSION['userid'])
                AND !empty($_SESSION['userid'])
                AND isset($_SESSION['username'])
                AND !empty($_SESSION['username'])
        )
            unset($_SESSION['userid'], $_SESSION['username']);
        $this->request->redirect(URL::base());
    }

}
