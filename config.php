<?php

// Directory separator abbreviation
// =============================================================================

define('DS', DIRECTORY_SEPARATOR);


// Folder paths
// =============================================================================

define('ROOT',       dirname(__FILE__) . DS);
define('APP_PATH',   ROOT . 'app' . DS);
define('LIB_PATH',   ROOT . 'lib' . DS);
define('ASSET_PATH', ROOT . 'assets' . DS);


// Database configs
// =============================================================================

define('DB_DRIVER',   'mysql');
define('DB_HOST',     'localhost');
define('DB_NAME',     'userauthdb');
define('DB_USERNAME', 'ben');
define('DB_PASSWORD', 'WEBd#7');


// App configs
// =============================================================================

define('DEFAULT_ROUTE', 'posts/home');
define('TPL_SUFFIX', 'tpl.php'); // Template file extension

