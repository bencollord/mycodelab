<?php

namespace Lib\Foundation;

use Lib\System\Object

class Application extends Object
{
  protected $basePath = 'http://localhost';
  
  protected $defaultRoute;
  
  protected $components;
  
  public function init()
  {
    
  }
  
  public function run()
  {
    
  }
  
  public function register($key, Closure $resolution)
  {
    $this->components[$key] = $resolution;
    
    return $this;
  }
  
  public function load($key)
  {
    if (!in_array($key, $this->components))
    
    return $this->components[$key]();
  }
  
}