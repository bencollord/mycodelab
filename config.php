<?php

// Directory separator abbreviation
define('DS', DIRECTORY_SEPARATOR);

// Folder paths
define('ROOT',       dirname(__FILE__) . DS);
define('LIB_PATH',   ROOT . 'library' . DS);
define('TPL_PATH',   ROOT . 'templates' . DS);
define('ASSET_PATH', ROOT . 'assets' . DS);
define('CSS_PATH',   ASSET_PATH . 'css' . DS);
define('JS_PATH',    ASSET_PATH . 'js' . DS);

// Database Configs
define('DB_DRIVER',   'mysql');
define('DB_HOST',     'localhost');
define('DB_NAME',     'userauthdb');
define('DB_USERNAME', 'ben');
define('DB_PASSWORD', 'WEBd#7');

// Default homepage
define('DEFAULT_CONTROLLER', 'Posts');
define('DEFAULT_ACTION',     'home');

