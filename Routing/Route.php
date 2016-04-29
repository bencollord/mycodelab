<?php

namespace MyCodeLab\Routing;

use Closure;
use MyCodeLab\System\{Object, Regex};
use MyCodeLab\Http\Url;

/**
 * Translates a URL into an application action.
 */
class Route extends Object
{
  /**
   * @var string
   */
  protected $template;
  
  /**
   * @var MyCodeLab\System\Regex
   */
  protected $pattern
  
  /** 
   * @var string|Closure
   */
  protected $handler;
  
  /**
   * @var ParameterSet
   */
  protected $parameters;
  
  /**
   * @param string         $template
   * @param Closure|string $handler
   * @param ParameterSet   $parameters
   */
  public function __construct($template, $handler, ParameterSet $parameters = null)
  {
    $this->template = $template;
    $this->action   = $handler;
    $this->token    = $parameters;
  }
  
  /**
   * @return string
   */
  public function getTemplate()
  {
    return $this->template;
  }
  
  /**
   * @return string
   */
  public function getPattern()
  {
    $pattern = $this->template;
    
    foreach ($this->parameters as $param)
    {
      $pattern = str_replace("<{$param->name}>", $param->pattern);
    }
    
    return new Regex($pattern);
  }
  
  /**
   * @param MyCodeLab\Http\Url
   * 
   * @return bool
   */
  public function matches(Url $url)
  {
    return $this->pattern->match($url->path);
  }
  
  
  public function target(Url $url)
  {
    $segments = $url->getPathSegments();
    
    foreach ($this->parameters as $param) {
      // Extract matching value from Url
      // Set parameter->value
    }
    
    // If $this->handler is not a closure:
    // Extract controller name and method
    // Create instance of Target, passing in controller name,
    // method name, and the parameters.
    // If Closure, pass it in along with a generic controller,
    // Such as MyCodeLab\Application\DefaultController and the params.
  }
  
}