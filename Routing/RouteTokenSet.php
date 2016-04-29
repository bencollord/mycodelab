<?php

namespace MyCodeLab\Routing;

use MyCodeLab\System\Collection;

/**
 * A strongly-typed collection of route parameters.
 */
class RouteTokenSet extends Collection
{
  public function __construct($tokens)
  {
    foreach ($tokens as $token) {
      if (!$token instanceof RouteToken) {
        throw new InvalidArgumentException(
          "One of the items passed was not an instance of RouteToken."
        );
      }
    }
    
    parent::__construct($parameters);
  }
  
  public function set($key, RouteToken $value)
  {
    return parent::set($key, $value);
  }
  
  
  public function prepend(RouteToken $value)
  {
    return parent::prepend($value);
  }

  /**
   * Appends an item to the end of the Collection.
   * 
   * Wrapper for PHP's array_push function.
   * 
   * @param  mixed $value      
   *                          
   * @return $this
   */
  public function append(RouteToken $value)
  {
    return parent::append($value);
  }

  
  /**
   * Adds a list of values to the Collection.
   * 
   * @param  static $newItems
   *           
   * @return $this
   */
  public function merge(RouteTokenSet $newItems)
  {
    return parent::merge($value);
  }

  
}