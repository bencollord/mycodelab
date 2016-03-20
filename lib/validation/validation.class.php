<?php

namespace Validation;

use Rules\Factory as RuleFactory;

class Validation
{
  protected $factory;
  protected $rules  = array();
  protected $errors = array();
  protected $passed;
  
  public function __construct(array $rules = array())
  {
    $this->factory = new RuleFactory();
    if(!empty($rules))
    {
      $this->init($rules);
    }
  }
  
  public function init($rules)
  {
    foreach($rules as $rule => $params)
    {
      $this->rules[] = $this->factory->build($rule, $params);
    }
  }
  
  public function __toString()
  {
    return $this->read();
  }
  
  public function check()
  {
    return $this->passed;
  }
  
  public function read()
  {
    //resets array pointer to first entry and returns it
    return reset($this->errors); 
  }
  
  public function getErrorList()
  {
    if(empty($this->errors))
    {
      return $this->read();
    }
    return $this->errors;
  }
  
  public function run($value)
  {
    $errorCount = 0;
    
    foreach($this->rules as $rule)
    {
      if(!$rule->validate($value))
      {
        $this->errors[] = $rule->getError();
        $errorCount++;
      }
    }
    
    if($errorCount > 0)
    {
      $this->passed = false;
      return false;
    }
    else
    {
      $this->passed = true;
      return true;
    }
  }
  
}