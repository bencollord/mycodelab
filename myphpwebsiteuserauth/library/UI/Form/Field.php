<?php

namespace Form;

use Library\Foundation\Accessors;

/**
 * Represents a form input
 */
class Field
{
  use Accessors;
  
  protected $name;
  protected $inputType;
  protected $value;
  protected $validation;
  
  public function __construct($name, $type, Validation $v, $defaultValue = '')
  {
    $this->name       = $name;
    $this->inputType  = $type;
    $this->validation = $v;
    $this->value      = $defaultValue;
  }
  
  /**
   * Static factory method to allow for future extension
   * 
   * @param string   $name  - Unique identifier 
   * @param string   $type  - The class/template that will be used
   * @param string[] $rules - Associative array of parameters for
   *                          the Validation object
   */
  public static function build($name, $type, $rules)
  {
    return new Field($name, $type, new Validation($rules));
  }
  
  public function __toString()
  {
    return $this->getValue();
  }
  
  /**
   * Accessors
   */
  public function getName()      { return $this->name;  }
  public function getInputType() { return $this->inputType;  }
  public function getValue()     { return $this->value; }
  public function getError()     { return $this->validation->read(); }
  public function isValid()      { return $this->validation->check(); }
  
  /**
   * Accepts and automatically runs validation
   * on a value. If no value is submitted, runs
   * validation on an empty string
   * 
   * @param mixed $value - single user submitted value
   * @return bool
   */
  public function input($value = '', $sanitize = true)          
  {  
    $this->validation->run($value);
    $this->value = $value;
  }
  
  /**
   * Manually run validation on the current value
   * 
   * @return bool
   */
  public function validate()
  {
    return $this->validation->run($this);
  }
  
  /**
   * Generates HTML code for form input
   */
  public function render()
  {
    ob_start();
    if(file_exists(TPL_PATH . $this->name . '.tpl.php'))
    {
      include TPL_PATH . $this->name . '.tpl.php';
    }
    else
    {
      include TPL_PATH . $this->inputType . '.tpl.php';
    }
    return ob_get_clean();
  }
  
}