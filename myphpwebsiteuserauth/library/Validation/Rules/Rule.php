<?php

namespace Validation\Rules;

abstract class Rule
{
  protected static $defaultErrorMsg = 'Entry for this field was not valid';

  /**
   * @var string $name - The name of the rule
   */
  protected $name;

  /**
   * @var string $errorMsg - The message that will be
   *                         rendered if the input does
   *                         not pass validation.
   */
  protected $errorMsg;

  /**
   * @var Callable $onSuccess - Callback to be executed
   *                            if input passes.            
   */
  protected $onSuccess;

  /**
   * @var Callable $onFailure - Callback to be executed
   *                            if input fails. 
   */
  protected $onFailure;

  public function __construct($errorMsg = NULL)
  {
    if(empty($errorMsg))
    {
      $errorMsg = static::$defaultErrorMsg; 
    }
    $this->errorMsg = $errorMsg;
  }

  public function __invoke($input)
  {
    return $this->validate($input);
  }

  /**
   * Accessor for $errorMsg.
   * 
   * @return string
   */
  public function getError()
  {
    return $this->errorMsg;
  }
  
  public function setSuccessHandler(Callable $handler)
  {
    $this->onSuccess = $handler;
  }
  
  public function setFailureHandler(Callable $handler)
  {
    $this->onFailure = $handler;
  }

  /**
   * Performs the actual validation of input when defined.
   * 
   * @param string $input - The input to be validated
   * @return bool - Whether or not the input passed.
   */
  abstract protected function checkInput($input);
  
  /**
   * Runs post-validation callback functions
   * 
   * @param bool $isValid - A Boolean value indicating the
   *                        success or failure of validation.
   * @return void
   */
  protected function triggerEvent($isValid)
  {
    $handler = ($isValid ? $this->onSuccess : $this->onFailure);

    if(!empty($handler) && is_callable($handler))
    {
      call_user_func($handler);
    }
  }

  /**
   * Template method that runs all validation actions.
   * 
   * First executes descendent-defined checkInput method
   * and then runs triggerEvent method to execute any callbacks
   * defined for the success or failure of validation
   * 
   * @param mixed $input - Input data to be checked
   * @return bool        - Whether or not validation passed
   */
  public final function validate($input)
  {
    $isValid = $this->checkInput($input);
    $this->triggerEvent($isValid);
    return $isValid;
    
  }

}