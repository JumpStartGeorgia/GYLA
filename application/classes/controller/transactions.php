<?php

defined('SYSPATH') OR exit('No direct script access.');

class Controller_Transactions extends Controller_Application
{

    public function before()
    {
        parent::before();
        $this->check_access('admin', 'management');
    }

    /*public function action_index()
    {
        $id = $this->request->param('id');
        $this->template->content = View::factory('transactions');
	$this->template->content->tas = DB::select()->from('transactions')->where('user_id', '=', $id)->execute()->as_array();
    }*/

    public function action_user()
    {
        $id = $this->request->param('id');
        $this->template->content = View::factory('transactions');
	$tas = DB::select()->from('transactions')->where('user_id', '=', $id)->execute()->as_array();

        $this->template->content->userid = $id;
        $user = DB::select(
        	    array('CONCAT_WS(\' \', "first_name", "last_name")', 'fullname'),
        	    array('becoming_member_date', 'joindate'),
        	    'pay_plan'
        	)
        	->from('people')
        	->where('id', '=', $id)
        	->execute()
        	->as_array();
        $this->template->content->fullname = $user[0]['fullname'];

	$amount = DB::select(array('SUM("amount")', 'total'))->from('transactions')->where('user_id', '=', $id)->execute()->as_array();

	$cutoffs = array();
	$cutoffs_sum = 0;
	if ($user[0]['pay_plan'] != 0)
	{
	    $days_in_months = array(31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);
	    $cutoffs_num = 0;
	    $date = $user[0]['joindate'];
	    $joinday = substr($date, 8);
	    $end_date = date("Y-m-d");
	    while (strtotime($date) <= strtotime($end_date))
	    {
		$date = date("Y-m-d", 24 * 3600 + strtotime($date));
		$monthdate = substr($date, 0, 7);
		$month = (int) substr($date, 5, 2);

		if (substr($date, 8) == $joinday)
		{
		    $cutoffs[] = array('amount' => -$user[0]['pay_plan'], 'paydate' => $date);
		    $cutoffs_num ++;
		    $date = date("Y-m-d", 27 * 24 * 3600 + strtotime($date));
		}
		elseif ($joinday > 28 and substr($date, 8) == 28)
		{
		    $maxdays = $days_in_months[$month - 1];
		    $day = ($joinday >= $maxdays) ? $maxdays : $joinday;
		    $cutoffs[] = array('amount' => -$user[0]['pay_plan'], 'paydate' => $monthdate . '-' . $day);
		    $cutoffs_num ++;
		    $date = date("Y-m-d", 27 * 24 * 3600 + strtotime($date));
		}
	    }
	    $cutoffs_sum = $cutoffs_num * $user[0]['pay_plan'];
	}

	$data = array_merge($tas, $cutoffs);
	foreach ($data as $key => $row)
	{
	    $value[$key]  = $row['paydate'];
	}
	empty($data) OR array_multisort($value, SORT_DESC, $data);

	$this->template->content->tas = $data;
	$this->template->content->balance = $amount[0]['total'] - $cutoffs_sum;
    }

    public function action_billing()
    {
        $this->template->content = View::factory('billing');
	$users = DB::select(
		    '*',
		    array('(SELECT SUM("amount") FROM transactions WHERE user_id = people.id)', 'total_amount'),
		    array('CONCAT_WS(\' \', "first_name", "last_name")', 'fullname')
		)
        	->from('people')
        	->where('blocked', '!=', 1)
        	->execute()
        	->as_array();

	foreach ($users as $idx => $user)
	{
	    if ($user['pay_plan'] == 0)
	    {
		continue;
	    }
	    $cutoffs = array();
	    $cutoffs_num = 0;
	    $date = $user['becoming_member_date'];
	    $joinday = substr($date, 8);
	    $end_date = date("Y-m-d");
	    while (strtotime($date) <= strtotime($end_date))
	    {
		$date = date("Y-m-d", 24 * 3600 + strtotime($date));
		if (substr($date, 8) == $joinday OR ($joinday > 28 and substr($date, 8) == 28))
		{
		    $cutoffs_num ++;
		    $date = date("Y-m-d", 27 * 24 * 3600 + strtotime($date));
		}
	    }
	    if ($user['total_amount'] - $cutoffs_num * $user['pay_plan'] < 0)
	    {
		unset($users[$idx]);
	    }
	}
	$this->template->content->users = array_values($users);
    }

    public function action_create()
    {
        $id = $this->request->param('id');
	if (empty($_POST['paydate']) OR empty($_POST['amount']) OR $_POST['amount'] < 1)
	{
	    $this->request->redirect(URL::site('transactions/user/' . $id));
	}
        $columns = array('user_id', 'amount', 'paydate');
        $values = array($id, $_POST['amount'], $_POST['paydate']);
        DB::insert('transactions', $columns)->values($values)->execute();
        $this->request->redirect(URL::site('transactions/user/' . $id));
    }

    public function action_email()
    {
        $id = $this->request->param('id');
	$this->template->content = 'მზადების პროცესშია.';
    }

    public function action_delete()
    {
        list($tid, $uid) = explode('-', $this->request->param('id'));
        DB::delete('transactions')->where('id', '=', $tid)->execute();
        $this->request->redirect(URL::site('transactions/user/' . $uid));
    }

}
