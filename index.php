<?php

use Lib\Foundation\Kernel;
use Lib\System\Autoloader;

// Define configuration constants
require_once 'config.php';

// Register autoloader
require_once 'lib/system/autoloader.class.php';

Autoloader::register();

// Run application
$app = Kernel::forge();
$app->run();