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
    $tokenRegex = new Regex(RouteToken::MARKER);
    $tokens     = $tokenRegex->extractAll($template);
    $template   = $tokenRegex->replace($template, '$1');
    $params     = new ParameterSet();

    foreach ($tokens as $token) {
      $token      = trim($token, '<>');
      $fragments  = explode(':', $token, 2);
      $paramName  = $fragments[0];
      $constraint = $fragments[1] ?? null;

      $params[]   = new Parameter($paramName, $constraint);
    }

    return new Route($template, $action, $parameters);
  }