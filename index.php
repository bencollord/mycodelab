<?php

// =============================================================================
// Application Bootstrap
// -----------------------------------------------------------------------------
// - Configure and set up application
// - Create any sessions or cookies needed
// - Configure database connection
// - Set vars or constants for file paths
// - Define constants and global variables
// - Create and route HTTP request
// =============================================================================

use Lib\Foundation\Kernel;

// Define configuration constants
require_once 'config.php';

// Register autoloader
require_once 'library/autoloader.class.php';
Autoloader::register();

// Run application
$app = Kernel::forge();
$app->run();