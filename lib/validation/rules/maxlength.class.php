<?php

namespace Validation\Rules;

class MaxLength extends Rule
{
  protected static $defaultErrorMsg = 'Entry cannot contain more than %d characters';
  
  protected $max;
  
  public function __construct($max, $error = NULL)
  {
    parent::__construct($error);
    $this->max = $max;
  }
  
  /**
   * @todo: this code is repeated in minlength.class.php
   *        consider refactoring to common parent class
   * 
   * Returns formatted error message
   * 
   * Override of parent method that uses sprintf()
   * function to enable errors to include the number
   * of characters allowed
   * 
   * @return string
   */
  public function getError()
  {
    return sprintf($this->errorMsg, $this->max);
  }
  
  protected function checkInput($input)
  {
    if(strlen($input) > $this->max)
    {
      return false;
    }
    return true;
  }
    
}