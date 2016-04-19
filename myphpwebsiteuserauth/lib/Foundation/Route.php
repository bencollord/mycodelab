<?php

namespace Lib\Foundation;

use Lib\System\Object;

class Route extends Object
{
  /**
   * @var string
   */
  protected $controllerName;
  
  /** 
   * @var string 
   */
  protected $actionName;
  
  /**
   * @var array[]
   */
  protected $parameters;
  
  /**
   * Get name of requested Controller.
   * 
   * @return string
   */
  public function getController()
  {
    return $this->controllerName;
  }
  
  /**
   * Get name of action.
   * 
   * @return string
   */
  public function getAction()
  {
    return $this->actionName;
  }
  
  /**
   * Get array of route parameters.
   * 
   * @return array[]
   */
  public function getParameters()
  {
    return $this->parameters;
  }
  
  public function __toString()
  {
    return lcfirst($this->controllerName) . '/' . 
           $this->actionName . '/' . 
           implode('/', $this->parameters);
  }
  
}