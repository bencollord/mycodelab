<?php

namespace Lib\HTTP;

use Lib\Core\Object;

/**
 * Processes HTTP requests.
 */
class Kernel extends Object
{
  /**
   * @var Session
   */
  protected $session;

  /**
   * @var boolean
   */
  protected $initialized = false;

  protected function __construct() {}

  protected function __clone() {}

  /**
   * Create and self-initialize a new instance
   * 
   * @return Kernel
   */
  public static function forge()
  {
    $instance = new self();
    $instance->init();

    return $instance;
  }

  /**
   * Bootstraps the application
   */
  public function init()
  {
    $this->request      = Request::forge();
    $this->session      = new Session();
    $this->initialized  = true;
  }
  
  /**
   * Check if application has been bootstrapped
   * 
   * @return bool
   */
  public function isInitialized()
  {
    return $this->initialized;
  }

  public function run()
  {
    $this->session->start();
    //@todo: add default controller and action handling
    $uri = trim($this->request->getUri(), '/');

    $params     = explode('/', $url);
    $controller = ucwords(array_shift($fragments)) . 'Controller';
    $action     = array_shift($fragments);

    if(!class_exists($controller) || !method_exists($controller, $action)) {
      //todo: handle 404s
      throw new InvalidArgumentException('The controller or action requested does not exist.');
    }
    $controller = new $controller($this->request, $this->session);
    $controller->{$action}();
  }

}
