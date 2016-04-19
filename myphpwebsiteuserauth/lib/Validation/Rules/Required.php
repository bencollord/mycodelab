<?php

namespace Validation\Rules;

class Required extends Rule
{
  protected static $defaultErrorMsg = 'This field is required';
  
  protected function checkInput($input)
  {
    if(empty($input))
    {
      return false;
    }
    return true;
  }

  
}