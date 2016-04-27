<?php

namespace MyCodeLab\Routing;

use MyCodeLab\System\Collection;

/**
 * A strongly-typed collection of route parameters.
 */
class ParameterSet extends Collection
{
  public function __construct($parameters)
  {
    foreach ($parameters as $param) {
      if (!$param instanceof RouteParameter) {
        throw new InvalidArgumentException(
          "One of the items passed to ParameterSet was not an instance of RouteParameter."
        );
      }
    }
    
    parent::__construct($parameters);
  }
  
  public function set($key, RouteParameter $value)
  {
    return parent::set($key, $value);
  }
  
  
  public function unshift(RouteParameter $value)
  {
    return parent::set($value);
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
  public function push(RouteParameter $value)
  {
    return parent::push($value);
  }

  
  /**
   * Adds a list of values to the Collection.
   * 
   * @param  static $newItems
   *           
   * @return $this
   */
  public function merge(ParameterSet $newItems)
  {
    return parent::merge($value);
  }

  
}