<?php

namespace MyCodeLab\Routing;

use Closure;
use MyCodeLab\System\Object;

class Factory extends Object
{ 
  /**
   * Creates a new Route instance.
   * 
   * @param  string         $template The route's URL pattern.
   * @param  string|Closure $action   The action the route maps to.
   * 
   * @return Route
   */
  public function newRoute($template, $action)
  {
    $tokenRegex = new Regex('/\<([A-Za-z0-9]+)(:.*?)?\>/');
    $tokens     = $tokenRegex->extractAll($template);
    $template   = $tokenRegex->replace($template, '$1');
    $parameters = new ParameterCollection();
    
    foreach ($tokens as $token) {
      $parameters->append($this->newParameter($token));
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
  public function newParameter($token)
  {
    $token      = trim($token, '<>');
    $fragments  = explode(':', $token, 2);
    $paramName  = $fragments[0];
    $constraint = $fragments[1] ?? null;
    
    return new RouteParameter($paramName, $constraint);
  }

}