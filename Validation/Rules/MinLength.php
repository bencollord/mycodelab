<?php

namespace Validation\Rules;

class MinLength extends Rule
{
  protected static $defaultErrorMsg = 'Entry must contain at least %d characters';
  
  protected $min;
  
  public function __construct($min, $error = NULL)
  {
    parent::__construct($error);
    $this->min = $min;
  }
  
  /**
   * @todo: this code is repeated in maxlength.class.php
   *        consider refactoring to common parent class
   * 
   * Returns formatted error message
   * 
   * Override of parent method that uses sprintf()
   * function to enable errors to include the number
   * of characters required
   * 
   * @return string
   */
  public function getError()
  {
    return sprintf($this->errorMsg, $this->min);
  }
  
  protected function checkInput($input)
  {
    if(strlen($input) < $this->min)
    {
      return false;
    }
    return true;
  }
    
}