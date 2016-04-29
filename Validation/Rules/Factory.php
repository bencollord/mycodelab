<?php

namespace Validation\Rules;

class Factory
{
  /**
   * @todo: refactor into smaller methods
   * Builds a Rule object based on parameters
   * 
   * @param string $name  - Rule's name
   * @param mixed  $args  - Either a string containing
   *                        the rule's parameter, an 
   *                        array containing the parameter
   *                        and a custom error message
   * 
   * @return Rule - an instance of Rule
   * 
   */
  public function build($name, $args)
  {
    //cast single arg to array for uniform handling
    if(!is_array($args))
    {
      $args = (array)$args;
    }
    
    //get rule key for format rules
    if($name == 'format')
    {
      $key = array_shift($args);
    }
    else
    {
      $key = $name;
    }
    
    //parse key into class name
    $ruleClass = call_user_func(function($key) {
      //add namespace
      $class = 'Rules\\';
      $words = explode('_', $key);
      foreach($words as $w)
      {
        $class .= ucwords($w);
      }
      return $class;
    }, $key);
    
    if(!class_exists($ruleClass))
    {
      throw new \InvalidArgumentException("Class '$ruleClass' doesn't exist!");
    }
    
    //get rule value if defined
    if(isset($args[0]) || isset($args['value']))
    {
      $value = array_shift($args);
      //remove boolean values
      //@todo: build a more elegant solution
      if($value === false)
      {
        exit();
      }
      if($value === true)
      {
        unset($value);
      }
    }
    //get custom error if defined and clear from array
    if(isset($args['error_message']))
    {
      $errorMsg = $args['error_message'];
      unset($args['error_message']);
    }

    //build rule based on extracted parameters
    //@todo: find a cleaner way to do this
    if(isset($value) && isset($errorMsg))
    {
      $rule = new $ruleClass($value, $errorMsg);
    }
    elseif(isset($value))
    {
      $rule = new $ruleClass($value);
    }
    elseif(isset($errorMsg))
    {
      $rule = new $ruleClass($errorMsg);
    }
    else
    {
      $rule = new $ruleClass();
    }
    
    //add event handlers, if any exist
    if(array_key_exists('on_failure', $args))
    {
      $rule->setFailureHandler($args['on_failure']);
    }
    if(array_key_exists('on_success', $args))
    {
      $rule->setSuccessHandler($args['on_success']);
    }
    
    return $rule;
    
  }
  
  
}