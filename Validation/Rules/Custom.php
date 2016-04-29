<?php

namespace Validation\Rules;

/**
 * @todo: add this rule to the Factory
 * 
 * Allows user to define a custom validation function
 * 
 * Accepts a custom callback as a parameter and runs it
 * upon validation
 */

class Custom extends Rule
{
  protected $callback;
	
	public function __construct(Callable $callback, $errorMsg = NULL)
	{
		$this->callback = $callback;
    parent::__construct($errorMsg);
	}
	
	protected function checkInput($input)
	{
		call_user_func($this->callback, $input);
	}
  
}