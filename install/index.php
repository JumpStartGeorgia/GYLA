<?php
  session_start();
  if (!isset($_GET['step']) OR empty($_GET['step']))
  {
    header('Location: ?step=1');
  }
  switch ($_GET['step'])
  {
    case 1:
    $header = 'პირველი ეტაპი - ავტორიზაცია მონაცემთა ბაზაში';
    $error = empty($_SESSION['message']) ? '' : '
        <div class="line">
            ' . $_SESSION['message'] . '
        </div>
    ';
    unset($_SESSION['message']);
    $content = $error . '
        <div class="line">
            სახელი:<br/>
            <input type="text" name="db_username" value="root" />
        </div>
        <div class="line">
            პაროლი:<br/>
            <input type="password" name="db_pwd" value="" />
        </div>
    ';
    break;
    case 2:
    $empty_post = (empty($_POST['db_username']) or empty($_POST['db_pwd']));
    if ($empty_post)
    {
        header('Location: ?step=1');
    }
    header('Content-Type: text/html; charset=utf-8');
    $_SESSION['db_username'] = $_POST['db_username'];
    $_SESSION['db_pwd'] = $_POST['db_pwd'];

    $header = 'მეორე ეტაპი - მონაცემთა ბაზის სახელი';
    $content = '
        <div class="line">შეიყვანეთ სახელი, რომელიც გსურთ რომ ერქვას ბაზას:</div>
        <div class="line"><input type="text" name="db_name" value="gyla" /></div>
    ';
    break;
    case 3:
    if (empty($_POST['db_name']) and empty($_SESSION['db_name']))
    {
        header('Location: ?step=2');
    }
    header('Content-Type: text/html; charset=utf-8');
    $_SESSION['db_name'] = $_POST['db_name'];
    $header = 'მესამე ეტაპი - ავტორიზაცია საიტზე';
    $content = '
        <div class="line">
            მომხმარებლის სახელი, რომლითაც გაივლით ავტორიზაციას საიტზე:<br/>
            <input type="text" name="username" value="" />
        </div>
        <div class="line">
            პაროლი:<br/>
            <input type="password" name="pwd" value="" />
        </div>
    ';
    break;
    case 4:
    $empty_post = (empty($_POST['username']) or empty($_POST['pwd']));
    if ($empty_post)
    {
        header('Location: ?step=3');
    }
    header('Content-Type: text/html; charset=utf-8');
    $_SESSION['username'] = $_POST['username'];
    $_SESSION['pwd'] = $_POST['pwd'];

    $uri = substr($_SERVER['REQUEST_URI'], 0, strpos($_SERVER['REQUEST_URI'], '/install/') + 1);
    $full = 'http://' . $_SERVER['SERVER_NAME'] . $uri;
    $server = str_replace('www.', '', $_SERVER['SERVER_NAME']);

    $code = "/*INSERT_NEW_ENV_CONFIG_HERE*/";
    $code .= "\n    '" . $server . "' => array(";
    $code .= "\n    'type' => Kohana::PRODUCTION,";
    $code .= "\n    'url' => '" . $full . "'";
    $code .= "\n    ),";
    $bootstrap = file_get_contents('../application/bootstrap.php');
    $bootstrap = str_replace('/*INSERT_NEW_ENV_CONFIG_HERE*/', $code, $bootstrap);
    file_put_contents('../application/bootstrap.php', $bootstrap);

    $code = '/*INSERT_NEW_ENV_CONFIG_HERE*/';
    $code .= "\n    case Kohana::PRODUCTION:";
    $code .= "\n    " . '$db = array(';
    $code .= "\n        'name' => '" . $_SESSION['db_name'] . "',";
    $code .= "\n        'user' => '" . $_SESSION['db_username'] . "',";
    $code .= "\n        'pass' => '" . $_SESSION['db_pwd'] . "',";
    $code .= "\n        'profiling' => FALSE";
    $code .= "\n    );";
    $code .= "\n    break;";
    $config = file_get_contents('../application/config/database.php');
    $config = str_replace('/*INSERT_NEW_ENV_CONFIG_HERE*/', $code, $config);
    file_put_contents('../application/config/database.php', $config);
    $header = 'მეოთხე ეტაპი - კონფიგურაციის ფაილების შექმნა';
    $content = '<div class="line">ფაილები შექმნილია.</div>';
    break;
    case 5:
    $connect = mysql_connect('localhost', $_SESSION['db_username'], $_SESSION['db_pwd']);
    $create_db = mysql_query('CREATE DATABASE  `' . $_SESSION['db_name'] . '` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;');
    $db = mysql_select_db($_SESSION['db_name'], $connect);
    if (!$connect OR !$create_db OR !$db)
    {
        unset($_SESSION);
        session_destroy();
        session_start();
        $_SESSION['message'] = mysql_error();
        header('Location: ?step=1');
    }
    header('Content-Type: text/html; charset=utf-8');
    $header = 'მეხუთე ეტაპი - მონაცემთა ბაზის შექმნა';
    $content = '<div class="line">ბაზა შექმნილია.</div>';
    break;
    case 6:
    header('Content-Type: text/html; charset=utf-8');
    $header = 'მეექვსე ეტაპი - მონაცემების ჩატვირთვა';
    $content = '<div class="line" id="status">იტვირთება...<br /><br /></div>';
    break;
    case 7:
    header('Content-Type: text/html; charset=utf-8');
    $header = 'საიტი წარმატებით დაყენდა';
    $content = '<div class="line">სასურველია წაშალოთ <span green>install</span> ფოლდერი.</div>';
    break;
    case 8:
    header('Location: ../');
    break;
  }

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
  <head>
    <title>GYLA Installation</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link rel="icon" href="../favicon.ico">
    <link rel="stylesheet" type="text/css" href="style.css">
    <script type='text/javascript' src="../scripts/jquery.js"></script>
    <script type='text/javascript'>var total_files = <?php echo count(glob('data/*.sql')); ?>;</script>
    <script type='text/javascript' src="script.js"></script>
  </head>
  <body>

    <div id="container" class="group">
    <div id="header" class="group">
        <?php echo $header; ?>
    </div>

    <div id="content" class="group">
        <form action="?step=<?php echo $_GET['step'] + 1; ?>" method="POST">
        <?php echo $content; ?>
        <input type="submit" value="<?php echo (($_GET['step'] == 7) ? 'დასრულება' : 'შემდეგი'); ?>" />
        </form>
    </div>
    </div>
    
  </body>
</html>
