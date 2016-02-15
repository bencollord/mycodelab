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

require_once 'config.php';
require_once 'library/autoloader.class.php';

$loader = new Autoloader();
$loader->register();

$app = Application::getInstance();

$app->init(
  new Router($routerConfigs),
  new HtmlDocument(
    TEMPLATE_PATH . 'html.tpl.php',
    array(
      CSS_PATH . 'bootstrap.min.css', 
      CSS_PATH . 'bootstrap-theme.min.css'
    ),
    array(
      JS_PATH . 'jquery.min.js',
      JS_PATH . 'bootstrap.min.js'
    )
  )
);

$app->execute(new Request());