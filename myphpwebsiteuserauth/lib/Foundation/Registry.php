<?php

namespace Lib\Foundation;

use Closure;
use ReflectionClass;
use Lib\System\Object;
use Lib\System\NotFoundException;

/**
 * Dependency injection container.
 * 
 * @todo: Add features:
 *        - Bind interfaces to implementations
 *        - Build from arrays
 *        - Define a factory method to replace constructor
 */
class Registry extends Object
{
  protected $bindings;
  
  protected $instances;
  
  /**
   * Register a component definition.
   * 
   * @param string                $key        Handle to access the component
   * @param string|object|Closure $definition 
   *                                          
   * @return $this
   */
  public function bind($key, $definition, $global = false)
  {
    $this->bindings[$key] = $definition;
    
    return $this;
  }
  
  public function fetch($key)
  {
    $definition = array_key_exists($key, $this->bindings) ? $this->bindings[$key] : $key;

    if ($definition instanceof Closure) {
      return $definition();
    }
    if (is_object($this->bindings[$key])) {
      return $definition;
    }
    if (class_exists($definition)) {
      return $this->forge($definition);
    }
    
    throw new NotFoundException("Component $key could not be resolved.");
  }
  
  public function forge($class) 
  {
    $reflection = new ReflectionClass($class);
    $constructor = $reflection->getConstructor();
    $params = $constructor->getParameters();
  }
  
}