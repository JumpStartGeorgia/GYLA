<?php

defined('SYSPATH') OR exit('No direct script access.');

class Controller_People extends Controller_Application
{

    public function before()
    {
        parent::before();

    }

    private $interests = array(
        'Criminal law',
        'Criminal procedure',
        'Constitutional law',
        'Administrative law',
        'Law of finances',
        'Industry law',
        'Insurance law',
        'Law of social protection',
        'Customs law',
        'Tax law',
        'Public international law',
        'Private international law',
        'Law of international organisations',
        'Diplomatic and Consular law',
        'Family law',
        'Labor law',
        'Human rights law',
        'History of law',
        'Philosophy of law',
        'Civil procedure',
        'Georgian law',
        'Customary law',
        'Humanitarian law'
    );

    private function districts()
    {
        $query = DB::select()->from('districts')
                ->where('language', '=', 'ka');
        return $this->db->query(Database::SELECT, $query)->as_array();
    }

    public function action_index()
    {
        $this->check_access('people', 'view_all');
        $people = DB::select('people.*')->from('people')->order_by('first_name')->execute()->as_array();
        $this->template->content = View::factory('people');
        if ($this->check_access('people', 'search', FALSE))
        {
            $this->template->content->search_form = View::factory('forms/search_people');
            $this->template->content->search_form->offices = DB::select('*')->from('offices')->order_by('id')->execute()->as_array();
	    $this->template->content->search_form->saved_search = DB::select('*')->from('saved_search')->execute()->as_array();
	}
	else
	{
	    $this->template->content->search_form = NULL;
	}
        $this->template->content->people = $people;
        $this->template->content->allow_transactions = 
        $this->template->content->allow_perm = $this->check_access('admin', 'management', FALSE);
        $this->template->content->allow_new = $this->check_access('people', 'add', FALSE);
        $this->template->content->allow_edit = $this->check_access('people', 'edit', FALSE);
        $this->template->content->allow_dele = $this->check_access('people', 'delete', FALSE);
    }

    public function action_view()
    {
        $id = $this->request->param('id');
        if ($this->check_access('people', 'view_all', FALSE) === FALSE)
        {
            if ($_SESSION['userid'] != $id or $this->check_access('people', 'view_own', FALSE) === FALSE)
            {
		$this->request->redirect(URL::site('user/denied'));
            }
        }
        $this->template->content = View::factory('person');

        $person = DB::select('people.*', array('offices.name', 'office_name'), array('offices.address', 'office_address'))
                ->from('people')
                ->join('education_degrees', 'LEFT')
                ->on('people.id', '=', 'education_degrees.person_id')
                ->join('offices', 'LEFT')
                ->on('people.office_id', '=', 'offices.id')
                ->where('people.id', '=', $id)
                ->order_by('first_name')
                ->execute()
                ->as_array();
		if ( empty($person) )                
			$this->request->redirect(URL::site('people'));
        $this->template->content->person = $this->returnUser($person[0]);

        $this->template->content->docs = DB::select('url')
                ->from('user_documents')
                ->where('user_id', '=', $id)
                ->order_by('id')
                ->execute()
                ->as_array();

        $this->template->content->phones = DB::select()
                ->from('phones')
                ->where('person_id', '=', $id)
                ->order_by('type')
                ->execute()
                ->as_array();

        $this->template->content->affiliation = array(
	    'staff' =>
		DB::select()
                ->from('affiliation_history')
                ->where('person_id', '=', $id)
                ->and_where('type', '=', 'staff')
                ->order_by('from')
                ->execute()
                ->as_array(),
           'organisation' => 
		DB::select()
                ->from('affiliation_history')
                ->where('person_id', '=', $id)
                ->and_where('type', '=', 'organisation')
                ->order_by('from')
                ->execute()
                ->as_array()
        );

        $this->template->content->allow_edit = $this->check_access('people', 'edit', FALSE);
        $this->template->content->allow_transactions = $this->check_access('admin', 'management', FALSE);
    }

    public static function reformat_date($date)
    {
	list($year, $month, $day, $hour) = array(substr($date, 0, 4), substr($date, 5, 2), substr($date, 8, 2), substr($date, 11, 5));
	($month < 1 OR $month > 12) and $month = 0;
	$months = array(
	    -1 => 'none',
	    'იანვარი',
	    'თებერვალი',
	    'მარტი',
	    'აპრილი',
	    'მაისი',
	    'ივნისი',
	    'ივლისი',
	    'აგვისტო',
	    'სექტემბერი',
	    'ოქტომბერი',
	    'ნოემბერი',
	    'დეკემბერი'
	);
	return ((string)(int)$day) . ' ' . $months[(int)$month - 1] . ', ' . $year . ', ' . $hour;
    }

    public function action_block()
    {
	$id = $this->request->param('id');
	DB::update('people')->set(array('blocked' => 1))->where('id', '=', $id)->execute();
	$this->request->redirect(URL::site('transactions/billing'));
    }

    private function calculateUser ($user)
    {    	    	
    	$user = mysql_real_escape_string($user);
    	if ( strpos($user,'(') && strpos($user,')') ):
			list($theU['first_last_name'],$theU['other']) = explode('(',$user);
			list($theU['user_name']) = explode(')',$theU['other']);unset($theU['other']);
			list($theU['first_last_name'],$theU['user_name']) = array(strtolower($theU['first_last_name']),strtolower($theU['user_name']));
		else:
			list($theU['first_last_name'],$theU['user_name']) = array(strtolower($user),null);
		endif;
		
    	$sql = sprintf("SELECT id FROM people WHERE '%s' = LOWER(CONCAT(first_name,' ',last_name)) AND '%s' = LOWER(username) ;",$theU['first_last_name'],$theU['user_name']);    	
    	$status = $this->db->query(Database::SELECT,$sql)->as_array();
		if ( empty($status) )
			return ucwords($theU['first_last_name']);
		else return $status[0]['id'];
    }    

    public function action_create()
    {
        $this->check_access('people', 'add');
        $errors = array();
        (empty($_POST['person_first_name']) OR strlen($_POST['person_first_name']) == 0) and $errors[] = 'person_first_name';
        (empty($_POST['person_last_name']) OR strlen($_POST['person_last_name']) == 0) and $errors[] = 'person_last_name';
        (empty($_POST['username']) OR strlen($_POST['username']) == 0) and $errors[] = 'username';
        (empty($_POST['password']) OR strlen($_POST['password']) == 0) and $errors[] = 'password';
	if (count($errors) > 0)
	{
	    $_SESSION['message'] = 'გთხოვთ შეავსოთ აუცილებელი ველები';
	    $_SESSION['errors'] = $errors;
	    $this->request->redirect('people/new');
	}

        /*$up = $this->document_upload($_FILES['person_document']);
        if (substr($up, 0, 8) != "uploads/" && $up != NULL)  //return if any errors
            exit($up);*/

        if (empty($_POST['person_member_of'][0]) OR !isset($_POST['person_member_of'][0]))
            $_POST['person_member_of'][0] = NULL;

        if (empty($_POST['person_member_of'][1]) OR !isset($_POST['person_member_of'][1]))
            $_POST['person_member_of'][1] = NULL;

        $columns = array
            (
            'username',
            'member_of',
            'office_id',
            //'document_url',
            'first_name',
            'last_name',
            'birth_date',
            'personal_number',
            'sex',
            'address',
            'email',
            'position',
            'organisation',
            'languages',
            'becoming_member_date',
            'reference',
            'interested_in',
            'years_in_school',
            'comment',
            'group_id'
        );

	if (!empty($_POST['person_languages']) and is_array($_POST['person_languages']))
	{
		$languages = $_POST['person_languages'];
		$existing = $new = array();
		foreach ($languages as $key => $lang)
		{
		    $e = DB::select('id')->from('languages');
		    if (is_numeric($lang))
		    {
			$e = $e->where('id', '=', $lang);
		    }
		    elseif (!empty($lang) AND strlen((string)$lang) > 1)
		    {
			$e = $e->where('language', '=', $lang);
		    }
		    else
		    {
			continue;
		    }
		    $e = $e->execute()->as_array();
		    if (empty($e))
		    {
			$e = DB::insert('languages', array('language'))->values(array($lang))->execute();
			$new[] = $e[0];
		    }
		    else
		    {
			$existing[] = $e[0]['id'];
		    }
		}
		$_POST['person_languages'] = serialize(array_merge($new, $existing));
	}
	else
	{
	    $_POST['person_languages'] = serialize(NULL);
	}

        $_POST['person_interested'] = empty($_POST['person_interested']) ? NULL : serialize($_POST['person_interested']);
      
        $values = array
            (
            $_POST['username'],
            $_POST['person_member_of'][0] . ',' . $_POST['person_member_of'][1],
            $_POST['person_office'],
            //$up,
            $_POST['person_first_name'],
            $_POST['person_last_name'],
            $_POST['person_birth_date'],
            $_POST['person_personal_number'],
            $_POST['person_sex'],
            $_POST['person_address'],
            $_POST['person_email'],
            $_POST['person_position'],
            $_POST['person_organisation'],
            $_POST['person_languages'],
            /*$_POST['person_becoming_member_date'],*/
            'NULL',
           $this->calculateUser($_POST['person_reference']),
            /*$_POST['person_interested'],*/
            'NULL',
            /*$_POST['person_years_in_school'],*/
            'NULL',
            $_POST['person_comment'],
            $_POST['group_id']
        );

        if (isset($_POST['password']) AND !empty($_POST['password']))
        {
            $columns[] = 'password';
            $values[] = sha1($_POST['password']);
        }

	$access = $this->check_access('admin', 'management', FALSE);
	if ($access)
	{
            if (isset($_POST['blocked']))
            {
		in_array($_POST['blocked'], array(0, 1)) OR $_POST['blocked'] = 0;
		$columns[] = 'blocked';
		$values[] = $_POST['blocked'];
            }
        }

        $query1 = DB::insert('people', $columns)->values($values)->execute();
        $last_id = $query1[0];
        $up = $this->document_upload($_FILES['person_document']);
        if (is_array($up))
        {
	    foreach ($up as $url)
	    {
		DB::insert('user_documents', array('user_id', 'url'))->values(array($last_id, $url))->execute();
	    }
        }

	if (isset($_POST['pay_plan']) && $access)
	{
	    $ta = Kohana::config('transactions');
	    $plans = $ta['plans'];
	    if (in_array($_POST['pay_plan'], $plans))
	    {
		DB::insert('payplan_changes', array('user_id', 'plan', 'datechanged'))
		->values(array($last_id, $_POST['pay_plan'], date("Y-m-d")))
		->execute();
	    }
	}

        /* Set default permissions
        $default_permissions = Kohana::config('default_permissions');
        $permissions = DB::insert('permissions', array('user_id', 'resource', 'privilege'));
        foreach ($default_permissions AS $resource => $privileges)
        {
            foreach ($privileges AS $privilege)
            {
                $permissions->values(array(
                    'user_id' => $last_id,
                    'resource' => $resource,
                    'privilege' => $privilege
                ));
            }
        }
        $permissions->execute();*/

        if ($query1)
        {
            (!isset($_POST['person_phone_type']) OR empty($_POST['person_phone_type'])) AND $_POST['person_phone_type'] = NULL;
            (!isset($_POST['person_phone_number']) OR empty($_POST['person_phone_number'])) AND $_POST['person_phone_number'] = NULL;
            $this->insert_phones($last_id, $_POST['person_phone_type'], $_POST['person_phone_number']);

            (!isset($_POST['person_affiliation_type']) OR empty($_POST['person_affiliation_type']))
                    AND $_POST['person_affiliation_type'] = NULL;
            (!isset($_POST['person_affiliation_from']) OR empty($_POST['person_affiliation_from']))
                    AND $_POST['person_affiliation_from'] = NULL;
            (!isset($_POST['person_affiliation_to']) OR empty($_POST['person_affiliation_to']))
                    AND $_POST['person_affiliation_to'] = NULL;
            $this->insert_affiliation(
                    $last_id, $_POST['person_affiliation_type'], $_POST['person_affiliation_from'], $_POST['person_affiliation_to']
            );
        }

        $query2 = TRUE;
        if ($query1 AND !empty($_POST['person_education_degree']))
            for ($i = 0, $n = count($_POST['person_education_degree']); $i < $n; $i++)
            {
                $columns = array
                    (
                    'person_id',
                    'degree',
                    'from',
                    'to'
                );
                $values = array
                    (
                    $last_id,
                    $_POST['person_education_degree'][$i],
                    $_POST['person_education_degree_from'][$i],
                    $_POST['person_education_degree_to'][$i]
                );
                $query2 = DB::insert('education_degrees', $columns)->values($values)->execute();
            }

        if ($query1 && $query2)
            $this->request->redirect(URL::site('people'));
    }
    
    private function getDefaultLanguages ()
    {

    	$status = $this->db->query(Database::SELECT,DB::select()->from('languages')->where('status','=','default'))->as_array();
	return $status;
    }

    public function action_new()
    {
        $this->check_access('people', 'add');
        /*$groups = DB::select()->from('user_groups')->execute()->as_array();
        if (empty($groups) OR empty($groups[0]['id']))
        {
        	$_SESSION['message'] = 'ჯგუფები ცარიელია. იმისათვის, რომ დაამატოთ მომხმარებელი, ჯერ უნდა დაამატოთ ჯგუფი.';
        	$this->request->redirect('groups/new');
        }*/

        $this->template->content = View::factory('forms/person');
        $this->template->content->default_languages = $this->getDefaultLanguages();
        $this->template->content->is_admin = $this->check_access('admin', 'management', FALSE);
        $ta = Kohana::config('transactions');
	$this->template->content->plans = $ta['plans'];
        $this->template->content->person = array(
            'id' => NULL,
            'username' => NULL,
            'first_name' => NULL,
            'last_name' => NULL,
            'birth_date' => NULL,
            'personal_number' => NULL,
            'address' => NULL,
            'phone' => NULL,
            'mobile_phone' => NULL,
            'email' => NULL,
            'position' => NULL,
            'organisation' => NULL,
            'becoming_member_date' => NULL,
            'reference' => NULL,
            'languages' => NULL,
            'member_of' => NULL,
            //'document_url' => NULL,
            'documents' => NULL,
            'sex' => NULL,
            'years_in_school' => NULL,
            'interested_in' => NULL,
            'comment' => NULL
        );
        $this->template->content->interests = $this->interests;
        $this->template->content->groups = DB::select()->from('user_groups')->execute()->as_array();
        $this->template->content->degrees = array(array('from' => NULL, 'to' => NULL, 'degree' => NULL));
        $this->template->content->offices = DB::select('name', 'address', 'id')->from('offices')->execute()->as_array();
        empty($results) AND $results = array();
    }       
    
    private function returnUser ($personArray)
    {
    	/*	Process Languages	*/
    	$personLanguagesArray = unserialize($personArray['languages']);    	    	
    	if ( !empty($personLanguagesArray) ){
		$sql = sprintf("SELECT * FROM languages WHERE id IN (%s)",implode(',',$personLanguagesArray));
		$status = $this->db->query(Database::SELECT,$sql)->as_array();
		$personArray['languages'] = $status;
		/* Processs Reference	*/
		if ( is_numeric($personArray['reference']) ):
			$sql = sprintf("SELECT CONCAT(first_name,' ',last_name) first_last_name,username user_name FROM people WHERE id='%d' LIMIT 1 ;",$personArray['reference']);
			$status = $this->db->query(Database::SELECT,$sql)->as_array();
			$personArray['reference'] = $status[0]['first_last_name'] . '(' . $status[0]['user_name'] . ')';
				return $personArray;
		endif;
    	}
    	return $personArray;
    }

    public function action_edit()
    {
        $this->check_access('people', 'edit');
        $thisid = $this->request->param('id');
        /*$groups = DB::select()->from('user_groups')->execute()->as_array();
        if (empty($groups) OR empty($groups[0]['id']))
        {
        	$_SESSION['message'] = 'ჯგუფები ცარიელია. იმისათვის, რომ შეცვალოთ მომხმარებლის მონაცემები, ჯერ უნდა დაამატოთ ჯგუფი.';
        	$_SESSION['redirect_id'] = $thisid;
        	$this->request->redirect('groups/new');
        }*/


        $query = DB::select()->from('people')
                ->where('people.id', '=', $thisid)
                ->execute()
                ->as_array();
        $query2 = DB::select()
                ->from('education_degrees')
                ->where('person_id', '=', $thisid)
                ->execute()
                ->as_array();
	if (empty($query))
	{
	    $this->request->redirect(URL::site('people'));
	}
        $this->template->content = View::factory('forms/person');
        $this->template->content->default_languages = $this->getDefaultLanguages();
        $this->template->content->person = $this->returnUser($query[0]);
        $this->template->content->documents = DB::select('id', 'url')
        				    ->from('user_documents')
        				    ->where('user_id', '=', $thisid)
        				    ->order_by('id')
        				    ->execute()
        				    ->as_array();
        $this->template->content->payplan = DB::select('plan')
        				    ->from('payplan_changes')
        				    ->where('user_id', '=', $thisid)
        				    ->order_by('id', 'DESC')
        				    ->order_by('datechanged', 'DESC')
        				    ->limit(1)
        				    ->execute()
        				    ->get('plan');
        $this->template->content->groups = DB::select()->from('user_groups')->execute()->as_array();
        $this->template->content->degrees = $query2;        
        $this->template->content->phones = DB::select()
                ->from('phones')
                ->where('person_id', '=', $thisid)
                ->execute()
                ->as_array();
        $this->template->content->interests = $this->interests;
        $this->template->content->offices = DB::select('name', 'address', 'id')
                ->from('offices')
                ->execute()
                ->as_array();
        $this->template->content->affiliation = DB::select()
                ->from('affiliation_history')
                ->where('person_id', '=', $thisid)
                ->order_by('from')
                ->order_by('type')
                ->execute()
                ->as_array();
	$this->template->content->is_admin = $this->check_access('admin', 'management', FALSE);
	$ta = Kohana::config('transactions');
	$this->template->content->plans = $ta['plans'];
    }
    

    public function action_update()
    {
        $this->check_access('people', 'edit');

        $thisid = $this->request->param('id');
        $u = TRUE;

        /*$up = $this->document_upload($_FILES['person_document']);
        if (substr($up, 0, 8) != "uploads/" && $up != NULL)  //return if any errors
            exit($up);
        else if (substr($up, 0, 8) == "uploads/")
        {
            $this->document_delete($thisid);
            $u = DB::update('people')->set(array('document_url' => $up))->where('id', '=', $thisid)->execute();
        }*/
	$up = $this->document_upload($_FILES['person_document']);
        if (is_array($up))
        {
	    foreach ($up as $url)
	    {
		DB::insert('user_documents', array('user_id', 'url'))->values(array($thisid, $url))->execute();
	    }
        }

        if (empty($_POST['person_member_of']) OR count($_POST['person_member_of']) == 0)
            $_POST['person_member_of'] = array(NULL, NULL);
        elseif (count($_POST['person_member_of']) == 1)
            $_POST['person_member_of'][1] = NULL;
		
		
		/*	START PERSON LANGUAGES PROCESSING !!! */
		if ( isset($_POST['person_languages']) && is_array($_POST['person_languages']) ) {

			$languages = $_POST['person_languages'];
			$existing = $new = array();
			foreach ($languages as $key => $lang)
			{
			    $e = DB::select('id')->from('languages');
			    if (is_numeric($lang))
			    {
				$e = $e->where('id', '=', $lang);
			    }
			    elseif (!empty($lang) AND strlen((string)$lang) > 1)
			    {
				$e = $e->where('language', '=', $lang);
			    }
			    else
			    {
				continue;
			    }
			    $e = $e->execute()->as_array();
			    if (empty($e))
			    {
				$e = DB::insert('languages', array('language'))->values(array($lang))->execute();
				$new[] = $e[0];
			    }
			    else
			    {
				$existing[] = $e[0]['id'];
			    }
			}
			$person_languages = serialize(array_merge($new, $existing));
/*
				
		
				$knownArray = array();				
				foreach ($_POST['person_languages'] as $index => $value)
					if (is_numeric($value)){
						$knownArray[] = $value;
					}
						
				$_POST['person_languages'] = array_values($_POST['person_languages']);
				$_POST['person_languages'] = $_POST['person_languages'][0];		
			
		
					$newArray = explode(',',$_POST['person_languages']);		
						unset($_POST['person_languages']);
					foreach ($newArray as $index => $value)		
						if ( strlen($value)<2 )
							unset($newArray[$index]);
						else $newArray[$index] = trim($value);		

			$sql = sprintf("SELECT * FROM languages WHERE language IN ('%s');",implode('\',\'',$newArray));
	
			$status = $this->db->query(Database::SELECT,$sql)->as_array();		

			foreach ($status as $lang){
				$knownArray[] = $lang['id'];
				if ( in_array($lang['language'],$newArray) )
					unset($newArray[array_search($lang['language'],$newArray)]);
			}
			$knownArray = array_unique($knownArray);
			if ( !empty($newArray) ){
				foreach ( $newArray as $index => $value ){
				    $sql = sprintf("INSERT INTO languages(language) VALUES('%s')",mysql_real_escape_string($value));
				    $status = $this->db->query(Database::INSERT,$sql);
				    $knownArray[] = $status[0];
				}
			}
			unset($newArray);

			$person_languages = serialize($knownArray);
*/
		}
		else $person_languages = false;
		/*	ENDS PERSON	LANGUAGE PROCESSING !!!	*/
		
        $_POST['person_languages'] = empty($_POST['person_languages']) ? NULL : serialize($_POST['person_languages']);
        $_POST['person_interested'] = empty($_POST['person_interested']) ? NULL : serialize($_POST['person_interested']);
		
        $update_data = array(
            'username' => $_POST['username'],
            'member_of' => $_POST['person_member_of'][0] . ',' . $_POST['person_member_of'][1],
            'office_id' => $_POST['person_office'],
            'first_name' => $_POST['person_first_name'],
            'last_name' => $_POST['person_last_name'],
            'birth_date' => $_POST['person_birth_date'],
            'personal_number' => $_POST['person_personal_number'],
            'sex' => $_POST['person_sex'],
            'address' => $_POST['person_address'],
            'email' => $_POST['person_email'],
            'position' => $_POST['person_position'],
            'organisation' => $_POST['person_organisation'],
            'languages' => $person_languages ? $person_languages : null,
            /*'years_in_school' => $_POST['person_years_in_school'],*/
            /*'becoming_member_date' => $_POST['person_becoming_member_date'],*/
            'reference' => $this->calculateUser($_POST['person_reference']),
            'interested_in' => $_POST['person_interested'],
            'comment' => $_POST['person_comment'],
            'group_id' => $_POST['group_id']
        );

        if (isset($_POST['password']) AND !empty($_POST['password']))
            $update_data['password'] = sha1($_POST['password']);

	if ($this->check_access('admin', 'management', FALSE))
	{
            if (isset($_POST['blocked']))
            {
		in_array($_POST['blocked'], array(0, 1)) OR $_POST['blocked'] = 0;
		$update_data['blocked'] = $_POST['blocked'];
            }

	    $lastp = DB::select('datechanged', 'plan', 'id')
	    		->from('payplan_changes')
	    		->where('user_id', '=', $thisid)
	    		->order_by('id', 'DESC')
	    		->order_by('datechanged', 'DESC')
	    		->limit(1)
	    		->execute()
	    		->as_array();
	    $lastp = empty($lastp) ? array('plan' => NULL, 'id' => NULL, 'datechanged' => NULL) : $lastp[0];
            if (isset($_POST['pay_plan']) AND $_POST['pay_plan'] != $lastp['plan'])
            {
		$ta = Kohana::config('transactions');
		$plans = $ta['plans'];
		if (in_array($_POST['pay_plan'], $plans))
		{
		    DB::insert('payplan_changes', array('user_id', 'plan', 'datechanged'))
		    ->values(array($thisid, $_POST['pay_plan'], date("Y-m-d")))
		    ->execute();
		}
		(date('Y-m-d') == $lastp['datechanged']) AND DB::delete('payplan_changes')->where('id', '=', $lastp['id'])->execute();
            }
        }

        $query = DB::update('people')
                ->set($update_data)
                ->where('id', '=', $thisid)
                ->execute();

        (!isset($_POST['person_phone_type']) OR empty($_POST['person_phone_type'])) AND $_POST['person_phone_type'] = NULL;
        (!isset($_POST['person_phone_number']) OR empty($_POST['person_phone_number'])) AND $_POST['person_phone_number'] = NULL;
        $this->insert_phones($thisid, $_POST['person_phone_type'], $_POST['person_phone_number']);

        (!isset($_POST['person_affiliation_type']) OR empty($_POST['person_affiliation_type']))
                AND $_POST['person_affiliation_type'] = NULL;
        (!isset($_POST['person_affiliation_from[]']) OR empty($_POST['person_affiliation_from[]']))
                AND $_POST['person_affiliation_from[]'] = NULL;
        (!isset($_POST['person_affiliation_to[]']) OR empty($_POST['person_affiliation_to[]']))
                AND $_POST['person_affiliation_to[]'] = NULL;
        $this->insert_affiliation(
                $thisid, $_POST['person_affiliation_type'], $_POST['person_affiliation_from'], $_POST['person_affiliation_to']
        );

        $del = DB::delete('education_degrees')->where('person_id', '=', $thisid)->execute();

        if (!empty($_POST['person_education_degree']))
            for ($i = 0, $n = count($_POST['person_education_degree']); $i < $n; $i++)
            {
                $columns = array
                    (
                    'person_id',
                    'degree',
                    'from',
                    'to'
                );
                $values = array
                    (
                    $thisid,
                    $_POST['person_education_degree'][$i],
                    $_POST['person_education_degree_from'][$i],
                    $_POST['person_education_degree_to'][$i]
                );
                $query2 = DB::insert('education_degrees', $columns)->values($values)->execute();
            }
        //$this->template->content->search_form = View::factory('people');
		
        //if($query && $u && $query2 && $del)
        $this->request->redirect(URL::site('people/view/' . $thisid));
        
    }

    
    private function makeSearch($_searchData)
    {
    
    	$_SSQL = array();
    	
	if ( isset($_searchData['person_status_state']) and !empty($_searchData['person_status_state']) )
		$_SSQL['person_status_state'] = " member_of LIKE '%staff%' ";
		
	if ( isset($_searchData['person_status_organization']) and !empty($_searchData['person_status_organization']) )
		$_SSQL['person_status_organization'] = " member_of LIKE '%organisation%' ";
		
	if  ( isset($_searchData['person_name']) and !empty($_searchData['person_name']) ){
		$_searchData['person_name'] = trim($_searchData['person_name']);				
		$tmpName = explode(' ',$_searchData['person_name']);						
		if ( count($tmpName)>1 )
			$name = array($tmpName[0],$tmpName[1]);					
		else $name = array($_searchData['person_name']);
		
		$_SSQL['person_name'] = "(";
			foreach ($name as $index => $value)
				$_SSQL['person_name'] .= ($index === 0 ? null : " OR ") . "username LIKE '%".$value."%' OR first_name LIKE '%".$value."%' OR last_name LIKE '%".$value."%'";		
		$_SSQL['person_name'] .= ")";
						
	}
	
	if ( isset($_searchData['person_date_start']) and !empty($_searchData['person_date_start']) ) {
		$_searchData['person_date_start'] = trim(strval($_searchData['person_date_start']));
		$_SSQL['person_date_start'] = " birth_date >= '".$_searchData['person_date_start']."' ";
	}
	
	if ( isset($_searchData['person_date_end']) and !empty($_searchData['person_date_end']) ) {
		$_searchData['person_date_end'] = trim(strval($_searchData['person_date_end']));
		$_SSQL['person_date_end'] = " birth_date <= '".$_searchData['person_date_end']."' ";
	}
	
	if ( isset($_searchData['person_private_number']) and !empty($_searchData['person_private_number']) ) {
		$_searchData['person_private_number'] = strval($_searchData['person_private_number']);
		$_SSQL['person_private_number'] = " personal_number LIKE '%".$_searchData['person_private_number']."%' ";
	}
	
	if ( isset($_searchData['person_gender']) and !empty($_searchData['person_gender']) and $_searchData['person_gender'] !== 'all' ) {
		$_searchData['person_gender'] = strval($_searchData['person_gender']);
		$_SSQL['person_gender'] = " sex = '".$_searchData['person_gender']."' ";
	}
	
	/*if ( isset($_searchData['person_tel']) and !empty($_searchData['person_tel']) ) {
		$_searchData['person_tel'] = strval($_searchData['person_tel']);	
		$_SSQL['person_tel'] = " ( phone LIKE '%".$_searchData['person_tel']."%' OR mobile_phone LIKE '%".$_searchData['person_tel']."%' ) ";
	}*/
	
	if ( isset($_searchData['person_email']) and !empty($_searchData['person_email']) ) {
		$_searchData['person_email'] = strval($_searchData['person_email']);
		$_SSQL['person_email'] = " email LIKE '%".$_searchData['person_email']."%' ";
		
	}			
	
	if ( isset($_searchData['person_office']) and !empty($_searchData['person_office']) and $_searchData['person_office'] !== 0 ) {
		$_SSQL['person_office'] = " office_id = '".$_searchData['person_office']."' ";
	}
			
    	$_SSQL = implode(' AND ',$_SSQL);
    	$sql = "SELECT * from people ";
	if (isset($_searchData['person_tel']) and !empty($_searchData['person_tel']))
	{
	    $sql .= " inner join phones on phones.person_id = people.id ";
	    $sql .= empty($_SSQL) ? ' where number like \'%' . $_searchData['person_tel'] . '%\' ' : ' WHERE ' . $_SSQL . ' and number like \'%' . $_searchData['person_tel'] . '%\' ';
	}
    	$sql .= ";";
    	$DBData = $this->db->query(Database::SELECT,$sql)->as_array();
    	
    	if ( isset($_searchData['person_languages']) and !empty($_searchData['person_languages']) ) {			
			$_searchData['person_languages'] = explode(',',trim($_searchData['person_languages']));
			$_searchData['person_languages'] = $this->array_clear($_searchData['person_languages']);
			$tmpDBData = array();
			foreach ( $DBData as $index => $value ) {
				$sql = DB::select('languages.language')->from('languages')->where('id','IN',unserialize($value['languages']));
				$person_languages = $this->db->query(Database::SELECT,$sql)->as_array();								
				//$count = 0;
				foreach ( $_searchData['person_languages'] as $ind => $val )
					if ( $this->in_array_rec($val,$person_languages) and !$this->in_array_rec($value['username'],$tmpDBData) ) 
						$tmpDBData[] = $value;
						/*$count ++; 					
				if ( $count === count($_searchData['person_languages']) )*/
					
				
			}
			
			$DBData = $tmpDBData;
		
		}
		
		$this->template->content->search_form = View::factory('forms/search_people');
		$this->template->content->people = $DBData;
		$sql = DB::select('*')->from('offices')->order_by('id');
        $this->template->content->search_form->offices = $this->db->query(Database::SELECT, $sql)->as_array();
        $this->template->content->search_form->the_search = $_searchData;
	$sql = DB::select('*')->from('saved_search');
	$this->template->content->search_form->saved_search = $this->db->query(Database::SELECT,$sql)->as_array();
        $this->template->content->allow_transactions = 
    	$this->template->content->allow_perm = $this->check_access('admin', 'management', FALSE);
        $this->template->content->allow_edit = $this->check_access('people', 'edit', FALSE);
        $this->template->content->allow_dele = $this->check_access('people', 'delete', FALSE);
        
    }
    
    public function action_search()
    {
	$this->check_access('people', 'search');
    	$this->template->content = View::factory('people');
    	if (isset($_GET['id']) && !empty($_GET['id']))
    	{
	    $sql = DB::select('saved_search.code')
    		   ->from('saved_search')
    		   ->where('id','=',$_GET['id']);    		
	    $saved_search = $this->db->query(Database::SELECT,$sql)->as_array();
	    $saved_search = unserialize(base64_decode($saved_search[0]['code']));    		    		
	    $this->makeSearch($saved_search);
    	}
    	elseif (isset($_POST) and !empty($_POST))
	{
	    $this->makeSearch($_POST);
	}
    }
    
    public function action_list_saved_search()
    {
	//$this->check_access('people', 'search');
    	$sql = DB::select('saved_search.id','saved_search.name')->from('saved_search');
    	$saved_searches = $this->db->query(Database::SELECT,$sql)->as_array();
		exit(json_encode($saved_searches));    	

    }
    
    public function action_get_saved_search()
    {
	//$this->check_access('people', 'search');
    	$sql = DB::select('saved_search.code')->from('saved_search')->where('id','=',$_GET['id']);
    	$get_saved_search = $this->db->query(Database::SELECT,$sql)->as_array();
    	$get_saved_search = unserialize(base64_decode($get_saved_search[0]['code']));
    	exit(json_encode($get_saved_search));
    }

    public function action_save_search()
    {
        $this->check_access('searches', 'add');


      /*  $name = $this->request->param('id');
        if (empty($name))
        {
            $this->template->content = "შეცდომა";
            return;
        }

        $query = DB::insert('saved_search', array(
                    'user_id',
                    'name',
                    'code'
                ))->values(array(
                    $_SESSION['userid'],
                    $name,
                    base64_encode(serialize($_SESSION['people']))
                ))->execute();

        if ($query)
            $this->request->redirect(URL::site('people/searches'));*/
		if ( isset($_POST['name']) && !empty($_POST['name']) && isset($_POST['data']) && !empty($_POST['data']) )
		{
			parse_str($_POST['data'],$theCode);	
			$theCode = base64_encode(serialize($theCode));	
			$query = DB::insert('saved_search', array('name', 'code'))->values(array($_POST['name'],$theCode));			
			$this->db->query(Database::INSERT,$query);
			exit('Saved.');
			
		}
		else
			exit('Error saving search.');
		
    }
    
	

    public function action_delete()
    {
        $this->check_access('people', 'delete');

        $id = $this->request->param('id');
        if (empty($id))
        {
            $this->template->content = 'შეცდომა';
            return;
        }

        $docs = DB::select('url')->from('user_documents')->where('user_id', '=', $id)->execute()->as_array();
        foreach ($docs as $doc)
        {
	    if (!empty($doc['url']) and file_exists($doc['url']))
	    {
		unlink($doc['url']);
	    }
	}
	DB::delete('user_documents')->where('user_id', '=', $id)->execute();
        DB::delete('people')->where('id', '=', $id)->execute();
        $this->request->redirect(URL::site('people'));
    }

    public function action_delete_document_ajax()
    {
        $this->check_access('people', 'edit', FALSE) OR die;
        $id = $this->request->param('id');

        if ($this->request->is_ajax())
        {
	    $file = DB::select('url')->from('user_documents')->where('id', '=', $id)->execute()->get('url');
	    if (file_exists($file))
	    {
		$unlink = unlink($file);
	    }
	    var_dump(DB::delete('user_documents')->where('id', '=', $id)->execute());
        }
        die;
    }

    public function action_searches()
    {
        $this->check_access('searches', 'view');

        $del = $this->request->param('id');
        $id = $this->request->param('optional');
        $query = (!empty($id) AND $del == "delete" ) ? DB::delete('saved_search')->where('id', '=', $id)->execute() : NULL;

        $query = DB::select()->from('saved_search')->execute()->as_array();
        $this->template->content = View::factory('searches');
        $this->template->content->searches = $query;
    }
        
    private function insert_phones($id, $types, $numbers)
    {
        $del = DB::delete('phones')->where('person_id', '=', $id)->execute();
        if (!empty($types) AND is_array($types))
        {
            $columns = array('person_id', 'type', 'number');
            $insert_phone = DB::insert('phones', $columns);
            $insert = FALSE;
            $valid_types = array('home', 'mobile', 'work');
            foreach ($types AS $index => $phone_type)
            {
                if (!empty($phone_type) AND !empty($numbers[$index]) AND in_array($phone_type, $valid_types))
                {
                    $values = array($id, $phone_type, $numbers[$index]);
                    $insert_phone = $insert_phone->values($values);
                    $insert = TRUE;
                }
            }
            if ($insert)
                $insert_phone = $insert_phone->execute();
        }
    }

    private function insert_affiliation($id, $types, $from, $to)
    {
        $del = DB::delete('affiliation_history')->where('person_id', '=', $id)->execute();
        if (!empty($types) AND is_array($types))
        {
            $columns = array('person_id', 'type', 'from', 'to');
            $insert_affiliation = DB::insert('affiliation_history', $columns);
            $insert = FALSE;
            $valid_types = array('staff', 'organization', 'organisation');
            foreach ($types AS $index => $type)
            {
                if (!empty($type) AND !empty($from[$index]) AND !empty($to[$index]) AND in_array($type, $valid_types))
                {
                    $values = array($id, $type, $from[$index], $to[$index]);
                    $insert_affiliation = $insert_affiliation->values($values);
                    $insert = TRUE;
                }
            }
            if ($insert)
                $insert_affiliation = $insert_affiliation->execute();
        }
    }

    private function document_upload($filedata)
    {
	$paths = array();
	for ($i = 0, $num = count($filedata['name']); $i < $num; $i ++)
	{
	    if ($filedata['size'][$i] < 2 OR $filedata['size'][$i] > 4097 * 1024)
	    {
		continue;
	    }
            $path = "uploads/people/documents/";
	    $name = mt_rand(0, 1000) . substr(sha1(uniqid()), 0, 5) . str_replace(' ', '_', $filedata['name'][$i]);
            if (file_exists($path . $name))
            {
                $name = mt_rand(0, 1000) . substr(sha1(time()), 0, 7) . $name;
            }
            $upload = move_uploaded_file($filedata["tmp_name"][$i], $path . $name);
            /*if (!$upload) return "file is valid but upload failed";*/
            $paths[] = $path . $name;
            /*else return "ატვირთული ფაილის ზომა მეტია 4 მბ-ზე"; else return NULL;*/
	}
	return $paths;
    }

    private function document_delete($person_id)
    {
        $sql = DB::select('document_url')
                ->from('people')
                ->where('id', '=', $person_id);
        $e = $this->db->query(Database::SELECT, $sql)->as_array();
        if (!empty($e))
            if (file_exists($e[0]['document_url']))
                unlink($e[0]['document_url']);
    }

    /*    public function action_ajax_read_offices()
      {
      $this->check_access('people', 'view');

      $id = $this->request->param('id');

      $query = DB::select('name', 'address', 'id')
      ->from('offices');

      $results = $this->db->query(Database::SELECT, $query)->as_array();
      empty($results) AND $results = array();

      $view = "<select name='person_office' class='widefield' id='officesdropdownmenu'>";

      foreach($results as $result)
      {
      $s = ($result['id'] == $id) ? "selected='selected'" : NULL;
      $view.= "<option value='".$result['id']."' ".$s.">".$result['name']." (".$result['address'].")</option>";
      }

      $view.= "</select>";

      exit($view);
      }
     */

    public function action_ajax_set_sessions()
    {
        $this->check_access('people', 'search');

        if (empty($_SESSION['people']) OR !isset($_SESSION['people']))
            $_SESSION['people'] = array();

        $_SESSION['people'][] = array(
            'parameter' => $_POST['people_parameter'],
            'method' => $_POST['people_method'],
            'value' => $_POST['people_value']
        );

        $view = $_POST['prehtml'];

        $view.= "<div class='group search_term'>";

        $view.= "<div class='added_search_box'>";

        $view.= str_replace("_", " ", $_POST['people_parameter']) . " " .
                str_replace("_", " ", $_POST['people_method']) . " " .
                $_POST['people_value'];

        $view.= "</div>";

        $view.= "<div class='remove_term' onclick='remove_term($(this))'>×</div>";

        $view.= "<input type='hidden' value='" . $_POST['people_parameter'] . "+" . $_POST['people_method'] . "+" . $_POST['people_value'] . "' />";

        $view.= "</div>";

        exit($view);
    }

    public function action_ajax_unset_session()
    {
        $this->check_access('people', 'search');

        if (empty($_SESSION['people']) OR !isset($_SESSION['people']))
            die;

        $temp = explode('+', $_POST['parameters']);
        $array = array('parameter' => $temp[0], 'method' => $temp[1], 'value' => $temp[2]);
        $i = array_search($array, $_SESSION['people']);
        unset($_SESSION['people'][$i]);

        exit;
    }
    
    private function JSArray ($arr,$needle)
    {
    	$JSArray = "[";
    	foreach ( $arr as $ind => $value ):
    	   	if ( $ind > 0 )
    			$JSArray .= ",";
    		$JSArray .= "\"".$value[$needle]."\"";
    	endforeach;    	
		return $JSArray."]";
    }
    
    public function action_autocomplete ()
    {   
    	switch ( $this->request->param('id') )
    	{
    		case 'reference':
    			$sql = "SELECT CONCAT(first_name, ' ', last_name,'(',username,')') user FROM people WHERE CONCAT(first_name,' ',last_name) LIKE '%" . $_GET['term'] . "%'";
    			$needle = 'user';
    		break;
    		case 'language':
    			$sql = "SELECT language lang FROM languages WHERE language LIKE '%" . $_GET['term'] . "%'";
    			$needle = 'lang';
    		break;
    	}
    	
    	$data = $this->db->query(Database::SELECT,$sql)->as_array();
    	if ( empty($data) )
    		exit;
    	else exit($this->JSArray($data,$needle));	    
    }
    

}
