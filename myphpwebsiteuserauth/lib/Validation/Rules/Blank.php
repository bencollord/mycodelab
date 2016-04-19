<?php

namespace Validation\Rules;

class Blank extends Rule
{
  protected static $defaultErrorMsg = 'This field must be left blank';
  
  protected function checkInput($input)
  {
    if(empty($input))
    {
      return true;
    }
    return false;
  }
  
}