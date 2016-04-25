<?php

namespace MyCodeLab\Routing;

use Closure;
use MyCodeLab\System\Object;
use MyCodeLab\DI\Registry;

class Factory extends Object
{ 
  
  /**
   * @var MyCodeLab\DI\Registry
   */
  protected $registry;
  
  public function __construct(Registry $registry)
  {
    $this->registry = $registry;
  }
  
  /**
   * Creates a new Route instance.
   * 
   * @param  string         $template The route's URL pattern.
   * @param  string|Closure $action   The action the route maps to.
   * 
   * @return Route
   */
  public function compileRoute($template, $action)
  {
    $tokenRegex = new Regex('/\<([A-Za-z0-9]+)(:.*?)?\>/');
    $tokens     = $tokenRegex->extractAll($template);
    $template   = $tokenRegex->replace($template, '$1');
    $parameters = new ParameterCollection();
    
    foreach ($tokens as $token) {
      $parameters->append($this->buildParameter($token));
    }
    
    return new Route($template, $action, $parameters);
  }

  /**
   * Creates a new RouteParameter instance.
   * 
   * @param  string $token The parameter marker parsed
   *                       from the route string.
   *                       
   * @return RouteParameter
   */
  public function compileParameter($token)
  {
    $token      = trim($token, '<>');
    $fragments  = explode(':', $token, 2);
    $paramName  = $fragments[0];
    $constraint = $fragments[1] ?? null;
    
    return new RouteParameter($paramName, $constraint);
  }

}