<?php

namespace MyCodeLab\Routing;

use MyCodeLab\System\{Object, Regex};
use MyCodeLab\Http\Url;

class RouteMap extends Object
{ 
  /**
   * @var MyCodeLab\Routing\Factory
   */
  protected $factory;
  
  /**
   * @var array
   */
  protected $routes;
  
  /**
   * @param MyCodeLab\Routing\Factory $factory
   */
  public function __construct(Factory $factory = null)
  {
    $this->factory = $factory ?? new Factory();
  }
  
  /**
   * @param  string         $template The pattern the URL will be mapped to.
   * @param  string|Closure $action   The function to be executed upon a match.
   *                                                             
   * @return $this
   */
  public function register($template, $action)
  {
    $this->routes[] = $this->factory->compileRoute($template, $action);
    
    return $this;
  }
  
  /**
   * Compares a URL against registered routes for a match.
   * 
   * @param  MyCodeLab\Http\Url $url
   *           
   * @throws RouteNotFoundException If a match is not found.
   *           
   * @return Route The matching route if found.
   */
  public function match(Url $url)
  {
    $path = $url->path;
    
    foreach ($this->routes as $route) {
      if ($route->pattern->match($path)) {
        return $route;
      }
    }
    
    throw new RouteNotFoundException("No route found for $url");
  }
  
}