<?php

namespace Validation\Rules;

/**
 * An abstract class for any rule that checks input for
 * correct formatting. The specific format, or the ablility 
 * for a user to define one, is to be defined in child classes
 */

abstract class Format extends Rule
{
  protected static $defaultErrorMsg = 'Entry was not in the correct format';
  
  protected $pattern;
  
  protected function checkInput($input)
  {
    return (bool) preg_match($this->pattern, $input);
  }
  
}