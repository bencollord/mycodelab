<?php

namespace Lib\View;

use Lib\System\Object;

class Config extends Object
{
  /**
   * @var string
   */
  protected $templateSuffix;
  
  public function getTemplateSuffix()
  {
    return $this->templateSuffix;
  }
  
}