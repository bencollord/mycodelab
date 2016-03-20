<?php

namespace Lib\View;

/**
 * Objects that can act as the application display
 */
interface View
{
  /**
   * Compiles the view into a string for output
   * 
   * @return string
   */
  public function render();
  
}