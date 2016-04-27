<?php

namespace MyCodeLab\Application;

use MyCodeLab\System\Object;
use MyCodeLab\Http\Request;
use MyCodeLab\Http\Response;

abstract class Controller extends Object
{ 
  protected $request;
  protected $response;
  protected $registry;
  protected $action;
  
  public function __construct(Registry $registry)
  {
    $this->registry = $registry;
  }

  public function init(Request $request, Response $response = null) 
  {
    $this->request  = $request;
    $this->response = $response ?? $this->registry->fetch('response');
  }
  
  public function run($action, $params = array())
  {
    $actionMethod = $action . "Action";
    
    if (!method_exists($this, $actionMethod)) {
      //@todo: throw exception or 404
    }
    
    $this->$actionMethod($params);
    
    return $this->response;
  }
  
}