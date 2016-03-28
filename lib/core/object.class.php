<?php

namespace Lib\Core;

abstract class Object
{
  /**
   * Looks for a getter method and invokes it if found.
   * 
   * @throws Exception
   */
  public function __get($property)
  {
    $accessor = 'get' . ucwords($property);
    
    if (method_exists($this, $accessor)) {
      return $this->$accessor();
    } 
    
    throw new Exception('Could not get property "' . $property . '"');
  }

  /**
   * Looks for a setter method and invokes it if found.
   * 
   * @throws Exception
   */
  public function __set($property, $value)
  {
    $accessor = 'set' . ucwords($property);
    
    if (method_exists($this, $accessor)) {
      return $this->$accessor($value);
    }
    
    throw new Exception('Could not set property "' . $property . '"');
  }
  
  /**
   * Routes isset() calls through accessor methods.
   */
  public function __isset($property) 
  {
    $accessor = 'get' . ucfirst($property);
    
    if (method_exists($this, $accessor) && $this->$accessor() !== null) {
      return true;
    }
    
    return false;
  }
  
  /**
   * Routes unset() calls through accessor methods.
   * 
   * @throws Exception
   */
  public function __unset($property) 
  {
    $accessor = 'set' . ucfirst($property);
    
    if (method_exists($this, $accessor)) {
      $this->$accessor(null);
    }
    
    throw new Exception("Cannot unset property '$property.'");
  }
  
  /**
   * String representation of the object.
   */
  public function __toString() 
  {
    return $this->getClassName();
  }
  
  final public function className()
  {
    return static::class;
  }
  
  /**
   * Checks if a property has been defined. 
   * 
   * Looks for accessors rather than fields. Thus, it will return false for a 
   * class variable with no getter or setter and true for a virtual property.
   * 
   * @param  string $property
   * @return bool 
   */
  final public function hasProperty(string $property) : bool
  {
    if (method_exists($this, 'get' . ucwords($property))) {
      return true;
    } 
    if (method_exists($this, 'set' . ucwords($property))) {
      return true;
    }
    
    return false;
  }
  
  /**
   * Checks if a property has a getter method.
   * 
   * @param  string $property
   * @return bool 
   */
  final public function canReadProperty(string $property) : bool
  {
    $accessor = 'get' . ucwords($property);
    
    return method_exists($this, $accessor);
  }
  
  /**
   * Checks if a property has a setter method;
   * 
   * @param  string $property 
   * @return bool
   */
  final public function canWriteProperty(string $property) : bool
  {
    $accessor = 'set' . ucwords($property);
    
    return method_exists($this, $accessor);
  }
  
  /**
   * Checks if a method has been defined.
   * 
   * @param  string $method 
   * @return bool
   */
  final public function hasMethod(string $method) : bool
  {
    return method_exists($this, $method);
  }

}