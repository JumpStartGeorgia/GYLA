<?php
    isset($_GET['i']) or die;
    session_start();
    header('Content-Type: text/html; charset=utf-8');

    $connect = mysql_connect('localhost', $_SESSION['db_username'], $_SESSION['db_pwd']) or die(mysql_error());
    $db = mysql_select_db($_SESSION['db_name'], $connect) or die(mysql_error());
    mysql_query("SET NAMES utf8", $connect) or die(mysql_error());

    $files = glob('data/*.sql');
    $file = $files[$_GET['i']];
    file_exists($file) or die('file doesn\'t exist');
    $status = TRUE;

    echo substr(basename($file), 0, -4);
    $queries = explode(";\n", file_get_contents($file));
    foreach ($queries as $sql)
    {
	if (strlen($sql) < 5)
	{
	    continue;
	}
	if ((bool) mysql_query($sql) == FALSE)
	{
	    $status = FALSE;
	    $error = mysql_error();
	}
    }
    if ($status)
    {
	echo ' <span green>OK</span><br />';
    }
    else
    {
	echo ' <span red>' . $error . '</span><br />';
    }

    if (count(glob('data/*.sql')) - 1 <= $_GET['i'])
    {
	$sql = "INSERT INTO `people` ";
	$sql .= "(`id`, `blocked`, `group_id`, `username`, `password`, `member_of`, `first_name`, `last_name`, `sex`,  `languages`) ";
	$sql .= "VALUES (1, 0, 2, '" . $_SESSION['username'] . "', '" . sha1($_SESSION['pwd']) . "', ";
	$sql .= "',', 'სახელი', 'გვარი', 'male', '" . serialize(array(0 => '1')) . "')";
	mysql_query($sql) or die(mysql_error());
	print '<br />მონაცემები წარმატებით ჩაიტვირთა.';
    }


