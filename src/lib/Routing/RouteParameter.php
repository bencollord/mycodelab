<?php

namespace MyCodeLab\Routing;

use MyCodeLab\System\{Object, Regex};

class RouteParameter extends Object
{
  const MATCH_ALL   = '/(.*)/'
  const MATCH_INT   = '/[0-9]+/';
  const MATCH_ALPHA = '/[A-Za-z]+/';
  const MATCH_ALNUM = '/[A-Za-z0-9]+/';
  
  /**
   * @var string
   */
  protected $name;
  
  /** 
   * @var MyCodeLab\System\Regex
   */
  protected $pattern;
  
  /**
   * @var mixed
   */
  protected $value;
  
  public function __construct($name, $pattern = null)
  {
    $this->name    = $name;
    $this->pattern = ($pattern) ? new Regex($pattern) : new Regex('/(.+)/');
  }
  
  /**
   * @return string
   */
  public function getName()
  {
    return $this->name;
  }
  
  /**
   * @return MyCodeLab\System\Regex
   */
  public function getPattern()
  {
    return $this->pattern;
  }
  
  /**
   * @return mixed
   */
  public function getValue()
  {
    return $this->value;
  }
  
  /**
   * @param  mixed $value
   *           
   * @throws \InvalidArgumentException 
   *             If $value does not match the correct pattern.
   *           
   * @return $this
   */
  public function setValue($value)
  {
    if (!this->pattern->match($value)) {
      throw new InvalidArgumentException(
        "Value '$value' does not match the correct format for $this->name."
      );
    }
    
    $this->value = $value;
    
    return $this;
  }
  
  public function __toString()
  {
    return $this->value;
  }
  
}