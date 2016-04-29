<?php

namespace MyCodeLab\Routing;

use MyCodeLab\System\Object;

class Target extends Object
{
  /**
   * @var MyCodeLab\Application\Controller
   */
  protected $controller = 'Default';
  
  /**
   * @var callable
   */
  protected $action;
  
  /**
   * @var ParameterSet
   */
  protected $parameters;
  
}