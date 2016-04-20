<?php

// Folder paths
// =============================================================================

<<<<<<< HEAD
define('DOMAIN_NAME', 'http://localhost');
=======
define('DOMAIN_NAME', 'localhost');
>>>>>>> 7b9962f61561e6f2ac0b0257351a5ca85b9f24b1

define('DS', DIRECTORY_SEPARATOR);

define('ROOT',       dirname(__FILE__) . DS);
define('APP_PATH',   ROOT . 'app' . DS);
define('LIB_PATH',   ROOT . 'library' . DS);
define('ASSET_PATH', ROOT . 'assets' . DS);


// App Config
// =============================================================================

define('DEFAULT_ROUTE', 'posts/home');


// Auth
// =============================================================================

define('USER_AUTH_TABLE', 'registeruserstbl');


// Database
// =============================================================================

define('DB_DRIVER',   'mysql');
define('DB_HOST',     'localhost');
define('DB_NAME',     'userauthdb');
define('DB_USERNAME', 'ben');
define('DB_PASSWORD', 'WEBd#7');


// View
// =============================================================================

define('TPL_SUFFIX', 'tpl.php'); // Template file extension

