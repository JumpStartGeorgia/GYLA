<?php

defined('SYSPATH') OR exit('No direct script access.');

class Controller_Transactions extends Controller_Application
{

    private $days_in_months = array(31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);

    public function before()
    {
        parent::before();
        if ($this->request->action() != 'scheduled_email')
        {
	    $this->check_access('admin', 'management');
        }
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
        	    array('becoming_member_date', 'joindate')
        	)
        	->from('people')
        	->where('id', '=', $id)
        	->execute()
        	->as_array();
        $this->template->content->fullname = $user[0]['fullname'];

	$amount = DB::select(array('SUM("amount")', 'total'))->from('transactions')->where('user_id', '=', $id)->execute()->get('total');

	$cutoffs = array();
	$cutoffs_sum = 0;
	$plan = DB::select('id', 'plan', 'datechanged')
    		->from('payplan_changes')
    		->where('user_id', '=', $id)
    		->order_by('id')
    		->order_by('datechanged')
    		->limit(2)
    		->execute()
    		->as_array();
	if (!empty($plan))
	{
	    $payment = $plan[0]['plan'];
   	    $changedate = (count($plan) == 1) ? '3333-12-12' : $plan[1]['datechanged'];

	    $date = $plan[0]['datechanged'];
	    (strtotime($date) <= 0) and $date = '1970-01-01';
	    $joinday = substr($date, 8);
	    $end_date = strtotime(date("Y-m-d"));
	    while (strtotime($date) <= $end_date)
	    {
		$month = (int) substr($date, 5, 2);
		$changedate = substr($changedate, 0, 8) . $this->days_in_months[$month - 1];
		if (strtotime($date) >= strtotime($changedate))
		{
		    $plan = DB::select('id', 'plan', 'datechanged')
		    	    ->from('payplan_changes')
		    	    ->where('user_id', '=', $id)
		    	    ->and_where('id', '>', $plan[0]['id'])
		    	    ->and_where('datechanged', '>=', $plan[0]['datechanged'])
		    	    ->order_by('id')
		    	    ->order_by('datechanged')
		    	    ->limit(2)
		    	    ->execute()
		    	    ->as_array();
		    $payment = $plan[0]['plan'];
		    $changedate = (count($plan) == 1) ? '3333-12-12' : $plan[1]['datechanged'];
		}
		if ($payment == 0)
		{
		    $date = $changedate;
		    continue;
		}
		$date = date("Y-m-d", strtotime("+1 day", strtotime($date)));

		if (substr($date, 8) == $joinday)
		{
		    $cutoffs[] = array('amount' => -$payment, 'paydate' => $date);
		    $cutoffs_sum += $payment;
		    $date = date("Y-m-d", strtotime("+27 day", strtotime($date)));
		}
		elseif ($joinday > 28 and substr($date, 8) == 28)
		{
		    $maxdays = $this->days_in_months[$month - 1];
		    $day = ($joinday >= $maxdays) ? $maxdays : $joinday;
		    $cutoffs[] = array('amount' => -$payment, 'paydate' => substr($date, 0, 7) . '-' . $day);
		    $cutoffs_sum += $payment;
		    $date = date("Y-m-d", strtotime("+27 day", strtotime($date)));
		}
	    }
	}

	$data = array_merge($tas, $cutoffs);
	foreach ($data as $key => $row)
	{
	    $value[$key] = $row['paydate'];
	}
	empty($data) OR array_multisort($value, SORT_DESC, $data);

	$this->template->content->tas = $data;
	$this->template->content->balance = $amount - $cutoffs_sum;
    }

    private function users_with_billing()
    {
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
	    $cutoffs = array();
	    $cutoffs_sum = 0;
	    $plan = DB::select('id', 'plan', 'datechanged')
	    	    ->from('payplan_changes')
	    	    ->where('user_id', '=', $user['id'])
	    	    ->order_by('id')
	    	    ->order_by('datechanged')
	    	    ->limit(2)
	    	    ->execute()
	    	    ->as_array();
	    if (empty($plan))
	    {
		unset($users[$idx]);
		continue;
	    }
	    //if (!empty($plan))
	    //{
	    $payment = $plan[0]['plan'];
	    $changedate = (count($plan) == 1) ? '3333-12-12' : $plan[1]['datechanged'];

	    $date = $plan[0]['datechanged'];
	    (strtotime($date) <= 0) and $date = '1970-01-01';
	    $joinday = substr($date, 8);
	    $end_date = strtotime(date("Y-m-d"));

	    while (strtotime($date) <= $end_date)
	    {
		$month = (int) substr($date, 5, 2);
		$changedate = substr($changedate, 0, 8) . $this->days_in_months[$month - 1];
		if (strtotime($date) >= strtotime($changedate))
		{
		    $plan = DB::select('id', 'plan', 'datechanged')
			    ->from('payplan_changes')
			    ->where('user_id', '=', $user['id'])
			    ->and_where('id', '>', $plan[0]['id'])
			    ->and_where('datechanged', '>=', $plan[0]['datechanged'])
			    ->order_by('id')
			    ->order_by('datechanged')
			    ->limit(2)
			    ->execute()
			    ->as_array();
		    $payment = $plan[0]['plan'];
		    $changedate = (count($plan) == 1) ? '3333-12-12' : $plan[1]['datechanged'];
		}
		if ($payment == 0)
		{
		    $date = $changedate;
		    continue;
		}
		$date = date("Y-m-d", strtotime("+1 day", strtotime($date)));

		if (substr($date, 8) == $joinday OR ($joinday > 28 and substr($date, 8) == 28))
		{
		    $cutoffs_sum += $payment;
		    $date = date("Y-m-d", strtotime("+27 day", strtotime($date)));
		}
	    }

	    $diff = $user['total_amount'] - $cutoffs_sum;
	    if ($diff >= 0)
	    {
		unset($users[$idx]);
		continue;
	    }
	    $diff .= '';
	    $users[$idx]['diff'] = $diff;
	}
	return array_values($users);
    }

    public function action_billing()
    {
        $this->template->content = View::factory('billing', array('users' => $this->users_with_billing()));
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

    private function email_reminder($email, $bill)
    {
	$subject = "[საია] შემხსენებელი";
	$message = "მოგესალმებით,
 
გაცნობებთ, რომ საქართველოს ახალგაზრდა იურისტთა ასოციაციაში თქვენი საწევრო დავალიანება შეადგენს " . $bill . " ლარს.";
	$from = "sacevro@gyla.ge";
	$headers = "Reply-To: The Sender <" . $from . ">\r\n"; 
	$headers .= "Return-Path: The Sender <" . $from . ">\r\n"; 
	$headers .= "From: <" . $from . ">\r\n";
	$headers .= "Organization: GYLA\r\n";
	$headers .= "MIME-Version: 1.0\r\n";
	$headers .= "Content-type: text/plain; charset=utf-8\r\n";
	$headers .= "X-Priority: 3\r\n";
	$headers .= "X-Mailer: PHP". phpversion() ."\r\n";
	$headers .= "Envelope-to: <" . $from . ">";
	$headers .= "for " . $from . ";";
	return mail($email, $subject, $message, $headers);
    }

    public function action_email()
    {
        $id = $this->request->param('id');
	$bill = -(int)$_SESSION['billings'][$id];
        $email = DB::select('email')->from('people')->where('id', '=', $id)->execute()->get('email');
	if (email_reminder($email, $bill))
	{
	    $this->template->content = 'წერილი წარმატებით გაიგზავნა.';
	}
	else
	{
	    $this->template->content = 'შეცდომა გაგზავნის დროს.';
	}
	$this->template->content .= '<meta http-equiv="refresh" content="2; url=' . URL::site('transactions/billing') . '" />';
    }

    public function action_scheduled_email()
    {
	$text = '';
        foreach ($this->users_with_billing() as $user)
        {
	    $bill = -(int)$user['diff'];
	    $send = $this->email_reminder($user['email'], $bill);
	    $name = $user['first_name'] . ' ' . $user['last_name'];
	    $status = ($send ? 'SENT SUCCESSFULLY' : 'SENDING FAILED');
	    $text .= "\tUSER(id={$user['id']},email={$user['email']},name={$name},bill={$bill}) REMINDER {$status}\n";
        }
	$text = str_repeat('_', 29) . "\n" . date('Y-m-d') . '  (time=' . time() . ")\n" . $text;
        $path = 'application/logs/scheduled_email.log';
	$file = file_exists($path) ? $path : getcwd() . '/' . $path;
	file_put_contents($file, file_get_contents($file) . $text);
        die;
    }

    public function action_delete()
    {
        list($tid, $uid) = explode('-', $this->request->param('id'));
        DB::delete('transactions')->where('id', '=', $tid)->execute();
        $this->request->redirect(URL::site('transactions/user/' . $uid));
    }

}
