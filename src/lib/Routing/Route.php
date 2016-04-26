<?php

namespace MyCodeLab\Routing;

use Closure;
use MyCodeLab\System\{Object, Regex};
use MyCodeLab\Http\Url;

class Route extends Object
{
  /**
   * @var string
   */
  protected $template;
  
  /** 
   * @var string|Closure
   */
  protected $action;
  
  /**
   * @var ParameterCollection
   */
  protected $parameters;
  
  /**
   * @param string              $template
   * @param Closure|string      $handler
   * @param ParameterCollection $parameters
   */
  public function __construct($template, $handler, ParameterCollection $parameters = null)
  {
    $this->template   = $template;
    $this->action     = $handler;
    $this->parameters = $parameters;
  }
  
  /**
   * @return string
   */
  public function getTemplate()
  {
    return $this->template;
  }
  
  /**
   * @return MyCodeLab\System\Regex
   */
  public function getPattern()
  {
    $template = $this->template;
    
    foreach ($this->parameters as $param)
    {
      $template = str_replace("<{$param->name}>", $param->pattern);
    }
    
    return new Regex($template);
  }
  
  /**
   * @param MyCodeLab\Http\Url
   * 
   * @return bool
   */
  public function matches(Url $url)
  {
    return $this->getPattern()->match($url->path);
  }
  
  /**
   * @todo: Figure out extracting parameter values from URL and passing to action.
   */
  public function dispatch()
  {
    return $this->action();
  }
  
}