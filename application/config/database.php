<?php

defined('SYSPATH') or die('No direct access allowed.');

switch (Kohana::$environment)
{
    case Kohana::PRODUCTION:
        $db = array(
            'name' => 'gyla',
            'user' => 'root',
            'pass' => 'x264db74',
            'profiling' => FALSE
        );
        break;
    case Kohana::TESTING:
        $db = array(
            'name' => 'gyla',
            'user' => 'root',
            'pass' => 'a1w@d34',
            'profiling' => TRUE
        );
        break;
    case Kohana::DEVELOPMENT:
    default:
        $db = array(
            'name' => 'gyla',
            'user' => 'root',
            'pass' => 'x264db74',
            'profiling' => TRUE
        );
        break;
}

return array(
    'default' => array(
        'type' => 'mysql',
        'connection' => array(
            'hostname' => 'localhost',
            'database' => $db['name'],
            'username' => $db['user'],
            'password' => $db['pass'],
            'persistent' => FALSE
        ),
        'table_prefix' => NULL,
        'charset' => 'utf8',
        'caching' => FALSE,
        'profiling' => $db['profiling']
    )
);
