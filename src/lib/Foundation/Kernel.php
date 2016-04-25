<?php

namespace MyCodeLab\Foundation;

/**
 * Processes HTTP requests.
 */
class Kernel extends Object
{
  /**
   * @var MyCodeLab\Http\Request
   */
  protected $request;
  
  /**
   * @var MyCodeLab\Http\Response
   */
  protected $response;
  
  /**
   * @var MyCodeLab\Foundation\Application
   */
  protected $app;
  
  /**
   * @var bool
   */
  protected $booted = false;

  public function __construct(Application $app)
  { 
    $this->app = $app;
  }
  
  /**
   * Check if application has been bootstrapped
   * 
   * @return bool
   */
  public function isBooted()
  {
    return $this->booted;
  }

  /**
   * @param  MyCodeLab\Http\Request  $request
   * @return MyCodeLab\Http\Response
   */
  public function dispatch(Request $request)
  {
    $route = new Route($request->uri->getPath())

    $controller = $route->controller;
    $action     = $route->action;
    $params     = $route->params;

    if(!class_exists($controller) || !method_exists($controller, $action)) {
      $response = $this->app->load('response');
      
      $response->setStatusCode(404);
      
      return $response;
    }
    
    $controller = new $controller($request, $this->app);
    
    $controller->init();
    $controller->{$action}();
    
    return $response = $controller->finish();
  }

}
