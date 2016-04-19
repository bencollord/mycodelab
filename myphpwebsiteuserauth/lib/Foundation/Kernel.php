<?php

namespace Lib\Foundation;

/**
 * Processes HTTP requests.
 */
class Kernel extends Object
{
  /**
   * @var Lib\Http\Request
   */
  protected $request;
  
  /**
   * @var Lib\Http\Response
   */
  protected $response;
  
  /**
   * @var bool
   */
  protected $initialized = false;

  /**
   * Bootstraps the application
   * 
   * @return $this
   */
  public function init()
  {
    $this->request     = Request::forge();
    $this->initialized = true;
    
    return $this;
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
    $route = (isset($this->request->uri)) ? trim($this->request->uri, '/') : DEFAULT_ROUTE;

    $params     = explode('/', $route);
    $controller = 'App\Controller' . ucwords(array_shift($params)) . 'Controller';
    $action     = array_shift($params);

    if(!class_exists($controller) || !method_exists($controller, $action)) {
      //todo: handle 404s
      throw new InvalidArgumentException('The controller or action requested does not exist.');
    }
    $controller = new $controller($this->request);
    
    $controller->init();
    $controller->{$action}();
  }

}
