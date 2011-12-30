<?php

defined('SYSPATH') OR exit('No direct script access.');

class Controller_Application extends Controller_Template
{

    protected static $resources = FALSE,
    $acl;
    public $template = 'layout/default';
    protected $db;

    public function before()
    {
        parent::before();
        $this->db = Database::instance('default');

        session_start();

        //self::$acl = new Zend_Acl();
        isset($_SESSION['userid']) OR $_SESSION['userid'] = NULL;
        $this->set_permissions($_SESSION['userid']);

        if (!$this->auto_render)
            return;

        $this->template->title = NULL;

        HTML::$windowed_urls = TRUE;

        if (empty($_SESSION['username']) OR empty($_SESSION['userid']))
            $this->template->content = View::factory('forms/login');
        elseif (!empty($_SESSION['username']) AND !empty($_SESSION['userid']))
        {
            $this->template->top = View::factory('layout/top');
            ($this->request->controller() == "search" AND $this->request->action() == "index")
                    AND $this->template->top->search_keyword = $this->request->param('id');
            $this->template->top->is_admin = $this->check_access('admin', 'management', FALSE);
        }

        $this->template->is_map = (trim(Request::detect_uri(), '/') == 'events/map');

        $this->template->scripts = array();
        $this->template->styles = array();
        $this->template->is_home = ($this->request->uri() == 'wall/index');
        //$this->template->quick_links = array();
    }

    public function after()
    {
        if (!$this->auto_render)
            return;
        $this->template->scripts = array_merge(array(
            'scripts/ie6mustdie/ie6mustdie.js',
            'scripts/jquery.js',
            'scripts/ui/js/jquery-ui-1.8.16.custom.min.js',
            'fancybox/jquery.mousewheel-3.0.4.pack.js',
            'fancybox/jquery.fancybox-1.3.4.pack.js',
            //'scripts/jquery.placeholder.js',
            //'scripts/common.js',
            'scripts/fancybox/fancybox/jquery.fancybox-1.3.4.pack.js',
            'scripts/main.js',
            'scripts/search.js',
            'scripts/load_posts.js'
                ), $this->template->scripts);
        $this->template->styles = array_merge(array(
            'scripts/ie6mustdie/ie6mustdie.css',
            'fancybox/jquery.fancybox-1.3.4.css',
            'style/main.css',
            'style/filters.css',
            'style/search.css',
            'style/post.css',
            'style/panel.css',
            'style/calendar.css',
            'scripts/fancybox/fancybox/jquery.fancybox-1.3.4.css',
            'scripts/ui/css/ui-lightness/jquery-ui-1.8.16.custom.css'
                ), $this->template->styles);
        return parent::after();
    }

    protected function check_access($resource, $privilege, $redirect = TRUE)
    {
        //print($resource . " " . $privilege);die;
        //echo $_SESSION['userid'];die;
        //$permission = (self::$acl->has($resource) AND self::$acl->isAllowed($_SESSION['userid'], $resource, $privilege));
        isset($_SESSION['permissions']) OR $this->set_permissions($_SESSION['userid']);
        $permission = !empty($_SESSION['permissions']) AND
        	      !empty($_SESSION['permissions'][$resource]) AND
        	      ($_SESSION['permissions'][$resource] == $privilege);
        if (!$permission AND $redirect)
            $this->request->redirect('user/denied');
        elseif (!$permission AND !$redirect)
            return FALSE;
        elseif ($permission AND !$redirect)
            return TRUE;
    }

    protected function set_permissions($user_id)
    {
        is_numeric($user_id) OR $user_id = (integer) $user_id;
        $results = DB::select('permissions.*')
		  ->from('people')
		  ->join('user_groups')
		  ->on('people.group_id', '=', 'user_groups.id')
		  ->join('permissions')
		  ->on('permissions.group_id', '=', 'people.group_id')
                  ->where('people.id', '=', $user_id)
                  ->execute()
                  ->as_array();
        $permissions = array();
	foreach($results as $result)
	{
	    $permissions[$result['resource']][] = $result['privilege'];
	}
	$_SESSION['permissions'] = $permissions;
        /*self::$acl->addRole(new Zend_Acl_Role($user_id));
        foreach ($result AS $permission)
        {
            if (!self::$acl->has($permission['resource']))
                self::$acl->add(new Zend_Acl_Resource($permission['resource']));
            self::$acl->allow($user_id, $permission['resource'], $permission['privilege']);
        }*/
    }

    public static function in_array_rec ($needle,$array)
	{
		if ( is_array($array) ) {
			$array_array = array(array_values($array));

			for ( $i=0;$i<count($array_array);$i++ ){
				for ( $j=0;$j<count($array_array[$i]);$j++ ){        					  					
					if ( is_array($array_array[$i][$j]) )
						$array_array[] = array_values($array_array[$i][$j]);	
					else if ( $needle == $array_array[$i][$j] )
							return true;					
				}	
														
			}
			        			
		}
		return false;
	} 	
	
	public static function array_clear($array)
	{
		$tmp = array();
		foreach ( $array as $index => $value )
			if ( !empty($value) )
				$tmp[] = $value;
		return $tmp;
	}


}


