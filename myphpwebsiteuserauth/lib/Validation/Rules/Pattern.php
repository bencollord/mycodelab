<?php

namespace Validation\Rules;

/**
 * Allows user to define custom format by accepting a
 * custom regular expression in the constructor
 */

class Pattern extends Format
{
  public function __construct($regex, $errorMsg = NULL)
  {
    parent::__construct($errorMsg);
    $this->pattern = $regex;
  }
  
}