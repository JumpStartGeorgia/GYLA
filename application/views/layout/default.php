<?php defined('SYSPATH') OR exit('No direct script access.'); ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
    <head>
        <title><?php empty($title) OR print $title . ' - ' ?>GYLA</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <link rel="icon" href="<?php echo URL::base() ?>favicon.ico">
        <script type='text/javascript'>var baseurl = "<?php echo URL::base() ?>";</script>
        <?php
        foreach ($styles as $file)
            echo "\t" . HTML::style($file), PHP_EOL;
        foreach ($scripts as $file)
            echo "\t" . HTML::script($file), PHP_EOL;
        ?>
    </head>
    <body>

    <?php if (isset($_SESSION['userid']) AND !empty($_SESSION['userid'])): ?>
    <a href="https://docs.google.com/spreadsheet/embeddedform?formkey=dFY4VDlYbG9wZXJMaU11azFzd1pNeGc6MQ" id="feedback" title="Give us a feedback or just say hello!">Feedback</a>
    <?php endif; ?>

    <div id="container" class="group">

        <a href="<?php echo URL::base() ?>">
            <img id="logo" src="<?php echo URL::base() ?>images/images/GYLA_logo.png" alt="" />
        </a>

        <div id="layout" class="group">

            <div id="top" class="group"><?php empty($top) OR print $top ?></div>

            <div id="content" class="group"<?php $is_map AND print ' style="width: 670px"' ?>><?php echo $content ?></div>

            <div id="ribbon" class="group"></div>

            <br/>

        </div>

        <div id="bottom">
            <?php /*<a href="#">პასუხისმგებლობის მოხსნა</a>
            <a href="#" id="link_donors">დონორები</a>
            <a href="#" id="link_rules">წესები <span id="rules_symbol">►</span></a> */ ?>
            &copy; საქართველოს ახალგაზრდა იურისტთა ასოციაცია
            <a href="http://jumpstart.ge/" id="link_jumpstart">&copy; 2011 JumpStart Georgia</a>
        </div>

    </div>



</body>
</html>
