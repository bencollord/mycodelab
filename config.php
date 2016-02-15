<?php

// Directory separator abbreviation
define('DS', DIRECTORY_SEPARATOR);

// Folder paths
define('ROOT',          dirname(__FILE__) . DS);
define('CSS_PATH',      ROOT . 'css' . DS);
define('JS_PATH',       ROOT . 'js' . DS);
define('TEMPLATE_PATH', ROOT . 'templates' . DS);
define('LIBRARY_PATH',  ROOT . 'library' . DS);

// Database Configs
define('DB_DRIVER',   'mysql');
define('DB_HOST',     'localhost');
define('DB_NAME',     'userauthdb');
define('DB_USERNAME', 'ben');
define('DB_PASSWORD', 'WEBd#7');

// Router configs
// @todo: move somewhere better
$routerConfigs = array(
  'default_controller' => 'Posts',
  'default_action'     => 'home'
);