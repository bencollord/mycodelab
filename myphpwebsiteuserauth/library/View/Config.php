<?php

namespace Library\View;

use Library\System\Object;

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