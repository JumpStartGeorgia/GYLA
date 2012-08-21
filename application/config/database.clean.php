<?php

defined('SYSPATH') or die('No direct access allowed.');

switch (Kohana::$environment)
{
    /*INSERT_NEW_ENV_CONFIG_HERE*/
}

return array(
    'default' => array(
        'type' => 'mysql',
        'connection' => array(
            'hostname' => $db['host'],
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
