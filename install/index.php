<?php
  session_start();
  if (!isset($_GET['step']) OR empty($_GET['step']))
  {
    header('Location: ?step=1');
  }
  switch ($_GET['step'])
  {
    case 1:
      $header = 'პირველი ეტაპი - ავტორიზაცია მონაცემთა ბაზაში<br />Step 1 - Sign in to the database';
      $error = empty($_SESSION['message']) ? '' : '
          <div class="line">
              ' . $_SESSION['message'] . '
          </div>
      ';
      unset($_SESSION['message']);
      $content = $error . '
          <div class="line">
              სახელი:<br/>
              Username:<br/>
              <input type="text" name="db_username" value="root" />
          </div>
          <div class="line">
              პაროლი:<br/>
              Password:<br/>
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

      $header = 'მეორე ეტაპი - მონაცემთა ბაზის ჰოსტი და სახელი<br />Step 2 - Database hostname and name of the database';
      $content = '
          <div class="line">შეიყვანეთ ბაზის ჰოსტი:<br />Enter hostname</div>
          <div class="line"><input type="text" name="db_host" value="localhost" /></div>
          <div class="line">შეიყვანეთ სახელი, რომელიც გსურთ, რომ ერქვას ბაზას, ან არსებული ბაზის სახელი<br />(თუ შეიყვანთ არსებული ბაზის სახელს, სასურველია ეს ბაზა ცარიელი იყოს):<br />Enter the name of an existing database or the name of a new database<br />(If you enter the name of an existing database, that database should be empty)</div>
          <div class="line"><input type="text" name="db_name" value="gyla" /></div>
      ';
    break;
    case 3:
      if ((empty($_POST['db_name']) and empty($_SESSION['db_name'])) or (empty($_POST['db_host']) and empty($_SESSION['db_host'])))
      {
          header('Location: ?step=2');
      }
      header('Content-Type: text/html; charset=utf-8');
      $_SESSION['db_name'] = $_POST['db_name'];
      $_SESSION['db_host'] = $_POST['db_host'];
      $header = 'მესამე ეტაპი - ავტორიზაცია საიტზე<br />Step 3 - Website authorization';
      $content = '
          <div class="line">
              მომხმარებლის სახელი, რომლითაც გაივლით ავტორიზაციას საიტზე:<br/>Username on the website:<br/>
              <input type="text" name="username" value="" />
          </div>
          <div class="line">
              პაროლი:<br />Password:<br />
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

      $code = "    '" . $server . "' => array(";
      $code .= "\n        'type' => Kohana::PRODUCTION,";
      $code .= "\n        'url' => '" . $full . "'";
      $code .= "\n    ),";
      $code .= "\n/*INSERT_NEW_ENV_CONFIG_HERE*/";
      $bootstrap = file_get_contents('../application/bootstrap.php');
      $bootstrap = str_replace('/*INSERT_NEW_ENV_CONFIG_HERE*/', $code, $bootstrap);
      file_put_contents('../application/bootstrap.php', $bootstrap);

      $code = '/*INSERT_NEW_ENV_CONFIG_HERE*/';
      $code .= "\n    case Kohana::PRODUCTION:";
      $code .= "\n    " . '$db = array(';
      $code .= "\n        'host' => '" . $_SESSION['db_host'] . "',";
      $code .= "\n        'name' => '" . $_SESSION['db_name'] . "',";
      $code .= "\n        'user' => '" . $_SESSION['db_username'] . "',";
      $code .= "\n        'pass' => '" . $_SESSION['db_pwd'] . "',";
      $code .= "\n        'profiling' => FALSE";
      $code .= "\n    );";
      $code .= "\n    break;";
      $config = file_get_contents('../application/config/database.php');
      $config = str_replace('/*INSERT_NEW_ENV_CONFIG_HERE*/', $code, $config);
      file_put_contents('../application/config/database.php', $config);
      $header = 'მეოთხე ეტაპი - კონფიგურაციის ფაილების შექმნა<br />Step 4 - Creating config files';
      $content = '<div class="line">ფაილები შექმნილია.<br />Config files created successfully.</div>';
    break;
    case 5:
      $connect = mysql_connect($_SESSION['db_host'], $_SESSION['db_username'], $_SESSION['db_pwd']);
      $create_db = mysql_query('CREATE DATABASE IF NOT EXISTS  `' . $_SESSION['db_name'] . '` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;', $connect);
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
      $header = 'მეხუთე ეტაპი - მონაცემთა ბაზის შექმნა<br />Step 5 - Creating/updating the database';
      $content = '<div class="line">ბაზა შექმნილია.<br />Creating/uploading complete.</div>';
      break;
      case 6:
      header('Content-Type: text/html; charset=utf-8');
      $header = 'მეექვსე ეტაპი - მონაცემების ჩატვირთვა<br />Step 6 - Uploading data into the database';
      $content = '<div class="line" id="status">იტვირთება...<br />Uploading...<br /><br /></div>';
    break;
    case 7:
      header('Content-Type: text/html; charset=utf-8');
      $header = 'საიტი წარმატებით დაყენდა<br />You have successfully completed installing the website';
      $content = '<div class="line">გსურთ წაშალოთ <span green>install</span> ფოლდერი? (სასურველია)<br />Do you wish to delete the <span green>install</span> folder? (Recommended)</div>';
      $content .= '<div class="line">';
      $content .= '<label><input type="radio" name="delete_dir" value="1" checked="true" /> კი Yes</label>';
      $content .= '</div><div class="line">';
      $content .= '<label><input type="radio" name="delete_dir" value="0" /> არა No</label>';
      $content .= '</div>';
    break;
    case 8:
      if ($_POST['delete_dir'] == 1)
      {
        require_once('del_dir.php');
        delete('../install');
      }
      else
      {
        //file_put_contents('installed', 'check.txt');
      }
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
  </head>
  <body>

    <div id="container" class="group">
    <div id="header" class="group">
        <?php echo $header; ?>
    </div>

    <div id="content" class="group">
        <form action="?step=<?php echo $_GET['step'] + 1; ?>" method="POST">
        <?php echo $content; ?>
        <input type="submit" value="<?php echo (($_GET['step'] == 7) ? 'დასრულება | Finish' : 'შემდეგი | Next'); ?>" />
        </form>
    </div>
    </div>


    <script type='text/javascript' src="script.js"></script>
  </body>
</html>
