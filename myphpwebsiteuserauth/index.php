<?php

use Library\Foundation\Kernel;
use Library\System\Autoloader;

// Define configuration constants
require_once 'config.php';

// Register autoloader
require_once 'Lib/System/Autoloader.php';

Autoloader::register();

// Run application
$app = Kernel::forge();
$app->run();