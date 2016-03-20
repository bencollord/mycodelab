<?php 

namespace Lib\Core;

class Object
{  
  /**
   * Generic object constructor to imitate JavaScript's object literals
   * 
   * @param mixed[] $args  An associative array of properties and methods
   */
  public static function createGeneric($args = array())
  {
    $object = new self();
    
    if (!empty($args)) {
      foreach ($args as $property => $value) {
        $object->{$property} = $value;
      }
    }
    
    return $object;
  }
  
  /**
   * Calls a getter method if one exists when a private property is accessed.
   */
  public function __get($name)
  {
    if (method_exists($this, 'get'.ucfirst($name))) {
      return $this->{'get'.ucfirst($name)}();
    } 
    if (method_exists($this, 'is'.ucfirst($name))) {
      return $this->{'is'.ucfirst($name)}();
    }
    throw new Exception('Could not get property "'.$name.'"');
  }

  /**
   * Calls a setter method if one exists when a private property is accessed.
   */
  public function __set($name, $value)
  {
    if (method_exists($this, 'set'.ucfirst($name))) {
      return $this->{'set'.ucfirst($name)}($value);
    }
    throw new Exception('Could not set property "'.$name.'"');
  }

  /**
   * Finds and invokes methods defined via the generic object constructor.
   */
  public function __call($method, $args)
  {
    if (isset($this->{$method}) && is_callable($this->{$method})) {
      return call_user_func_array($this->{$method}, $args);
    } else {
      throw new Exception("Fatal error: Call to undefined method stdObject::{$method}()");
    }
  }
  
  /**
   * Returns the class name
   * 
   * @return string
   */
  public function getClass()
  {
    return static::class;
  }
  
}
