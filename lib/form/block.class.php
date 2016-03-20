<?php

namespace Form;

abstract class Block 
{
  protected $template;
  
  public function setTemplate($template)
  {
    $this->template = $template;
  }
  
  public function render()
  {
    ob_start();
    include_once $this->template;
    return ob_get_clean();
  }
  
}