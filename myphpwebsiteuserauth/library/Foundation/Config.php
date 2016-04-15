<?php

namespace Library\Foundation;

use Library\System\Object;

class Config extends Object
{
  /**
   * @var Route
   */
  protected $defaultRoute;
  
  public function getDefaultRoute()
  {
    return $this->defaultRoute;
  }
  
}