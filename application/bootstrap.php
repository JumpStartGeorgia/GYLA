<?php

defined('SYSPATH') or die('No direct script access.');

require SYSPATH . 'classes/kohana/core' . EXT;

require is_file(APPPATH . 'classes/kohana' . EXT) ?
                APPPATH . 'classes/kohana' . EXT :
                SYSPATH . 'classes/kohana' . EXT;

date_default_timezone_set('Asia/Tbilisi');

setlocale(LC_ALL, 'en_US.utf-8');

spl_autoload_register(array('Kohana', 'auto_load'));

ini_set('unserialize_callback_func', 'spl_autoload_call');

I18n::lang('ka-ge');

// Environment setup
$environments = array(
    /*INSERT_NEW_ENV_CONFIG_HERE*/
    'localhost' => array(
        'type' => Kohana::DEVELOPMENT,
        'url' => 'http://www.localhost.com/gyla/'
    ),
    'deda.omc.ge' => array(
        'type' => Kohana::TESTING,
        'url' => 'http://deda.omc.ge/gyla/'
    ),
    /*'gyla.ge' => array(
        'type' => Kohana::PRODUCTION,
        'url' => 'http://www.gyla.ge/'
    ),*/
);
$has_environment = FALSE;
foreach ($environments AS $uri => $env)
{
    if (strpos($_SERVER['SERVER_NAME'], $uri) !== FALSE)
    {
        $has_environment = TRUE;
        Kohana::$environment = $env['type'];
        $base_url = $env['url'];
        break;
    }
}
$has_environment OR Kohana::$environment = $environments['localhost']['type'];

require APPPATH . 'addons' . EXT;

/**
 * Initialize Kohana, setting the default options.
 *
 * The following options are available:
 *
 * - string   base_url    path, and optionally domain, of your application   NULL
 * - string   index_file  name of your index file, usually "index.php"       index.php
 * - string   charset     internal character set used for input and output   utf-8
 * - string   cache_dir   set the internal cache directory                   APPPATH/cache
 * - boolean  errors      enable or disable error handling                   TRUE
 * - boolean  profile     enable or disable internal profiling               TRUE
 * - boolean  caching     enable or disable internal caching                 FALSE
 */
Kohana::init(array(
    'base_url' => isset($base_url) ? $base_url : $environments['localhost']['url'],
    'index_file' => FALSE,
    'profile' => Kohana::$environment !== Kohana::PRODUCTION,
    'caching' => Kohana::$environment === Kohana::PRODUCTION,
));

Kohana::$log->attach(new Log_File(APPPATH . 'logs'));
Kohana::$config->attach(new Config_File);

if ($path = Kohana::find_file('vendor', 'Zend/Loader'))
{
    ini_set('include_path', ini_get('include_path') . PATH_SEPARATOR . dirname(dirname($path)));
    require_once 'Zend/Loader/Autoloader.php';
    Zend_Loader_Autoloader::getInstance();
}

Kohana::modules(array(
    //'auth' => MODPATH . 'auth', // Basic authentication
    // 'cache'      => MODPATH.'cache',      // Caching with multiple backends
    // 'codebench'  => MODPATH.'codebench',  // Benchmarking tool
    'database' => MODPATH . 'database', // Database access
    // 'image'      => MODPATH.'image',      // Image manipulation
    // 'orm'        => MODPATH.'orm',        // Object Relationship Mapping
    // 'unittest'   => MODPATH.'unittest',   // Unit testing
    'userguide' => MODPATH . 'userguide', // User guide and API documentation
));

Route::set('default', '(<controller>(/<action>(/<id>(/<optional>))))')->defaults(array(
    'controller' => 'wall',
    'action' => 'index',
));
