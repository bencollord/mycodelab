<?php

// =============================================================================
// CONFIGURATION CONSTANTS
// -----------------------------------------------------------------------------

// Folder paths
// =============================================================================

define('DS', DIRECTORY_SEPARATOR);

define('ROOT',     dirname(dirname(__FILE__)) . DS);
define('WEB_ROOT', ROOT . 'public' . DS);
define('APP_PATH', ROOT . 'app' . DS);
define('LIB_PATH', ROOT . 'lib' . DS);


// Application
// =============================================================================

define('DOMAIN_NAME',   'http://localhost/myphpwebsiteuserauth/');
define('APP_ENV',       'dev');
define('DEBUG',         'true');
define('TIMEZONE',      'America/Boise');
define('DEFAULT_ROUTE', 'posts/home');


// Auth
// =============================================================================

define('USER_AUTH_TABLE', 'registeruserstbl');


// Database
// =============================================================================

define('DB_DRIVER',   'mysql');
define('DB_HOST',     'localhost');
define('DB_NAME',     'userauthdb');
define('DB_USER', 'ben');
define('DB_PASS', 'WEBd#7');


// View
// =============================================================================

define('TPL_SUFFIX', 'tpl.php'); // Template file extension

