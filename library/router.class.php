<?php

class Router {
  //assoc array with ctlr, action and params
  private $route;
  private $defaultController;
  private $defaultAction;
  
  public function construct($configs) {
    $this->defaultController = $configs['default_controller'];
    $this->defaultAction     = $configs['default_action'];
  }
  
  public function route(Request $request) {
    $url = $request->getUrl();
    
    //parse url and get route, or set to default
    if(empty($url)){
      $route = array(
        'controller' => $this->defaultController,
        'action'     => $this->defaultAction
        );
    } else {
      $route = $this->parseRouteFromUrl($url);
    }
    
    $request->setRoute($route);
    return $request;
  }
  
  private function parseRouteFromUrl($url) {
    $url = trim($url, '/');
    
    $fragments  = explode('/', $url);
    $ctlrName   = ucwords(array_shift($fragments)) . 'Controller';
    $actionName = array_shift($fragments);
    
    if(class_exists($ctlrName) && method_exists($ctlrName, $actionName)) {
      $route = array(
        'controller' => $ctlrName,
        'action'     => $actionName,
      );
      if(!empty($fragments)) {
        $route['params'] = $fragments;
      }
    } else {
      //todo: handle 404s
      throw new InvalidArgumentException('The controller or action requested does not exist.');
    }
    return $route;
  }
  
}
