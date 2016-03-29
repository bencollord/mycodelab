<?php

namespace Lib\View;

use Lib\System\Object;

class ViewDataSet extends Object
{
  //
  // HTML escape levels
  // 

  /**
   * No escaping
   */
  const ENCODE_RAW    = 0;

  /**
   * Escape using htmlspecialchars
   */
  const ENCODE_SAFE   = 1;

  /**
   * Encode using htmlentities
   */
  const ENCODE_STRICT = 2;

  /**
   * @var string A list of keys for accessing data items.
   */
  protected $dataKeys = array()

    /**
   * @var mixed[string] The values to be passed indexed by key.
   */
    protected $dataItems = array();

  /**
   * @var int Class constant value defining how to escape output. 
   *          Default is the value of ENCODE_SAFE
   */
  protected $escapeMode = 1;

  /**
   * Set output HTML escaping. 
   * 
   * Can either take a class constant value or convert to it from a string.
   * 
   * @param  string|int $mode
   *           
   * @throws InvalidArgumentException if $mode does not evaluate to a valid mode.
   * 
   * @return $this
   */
  public function setEscapeMode($mode) {
    // Prevent uppercase letters from throwing error.
    $mode = strtolower($mode);

    if ($mode === 0 || $mode == 'raw') {
      $this->escapeMode = static::ENCODE_RAW;
    } elseif ($mode === 1 || $mode == 'safe') {
      $this->escapeMode = static::ENCODE_SAFE;
    } elseif ($mode === 2 || $mode == 'strict') {
      $this->escapeMode = static::ENCODE_STRICT;
    } else {
      throw new InvalidArgumentException("Invalid value set for ViewDataSet::escapeMode.");
    }

    return $this;
  }

  /**
   * Gets a value from the $params array.
   * 
   * @param string $name  The key in the array.
   *                                             
   * @return mixed|bool  The value from $params, or false if not found.
   */
  public function get($name)
  {
    if (array_key_exists($name, $this->params)) {
      return $this->params[$name];
    } else {
      return false;
    }
  }

  /**
   * Adds a value to the $params array.
   * 
   * @param string $name  The key the value will be indexed by.
   * 
   * @return $this
   */
  public function set($name, $value)
  {
    $this->params[$name] = $value;

    return $this;
  }

  /**
   * Adds a parameter by reference.
   * 
   * @param  string $name       The key the reference will be indexed by.
   * @param  mixed  &$reference A reference to an outside variable.
   *
   *  @return $this
   */
  public function bind($name, &$reference)
  {
    if (is_object($reference)) {
      $this->params[$name] = $reference;
    } else {
      $this->params[$name] =& $reference;
    }

    return $this;
  }

  /**
   * HTML escapes an array of parameters based on the defined escape mode.
   * 
   * @param  array $params  The values to be cleaned.
   *                                         
   * @return array  The sanitized values.
   */
  protected function sanitize(array $params)
  {
    if ($this->escapeMode == static::ENCODE_RAW) {
      return $params;
    }
    if ($this->escapeMode == static::ENCODE_SAFE) {
      return array_map('htmlspecialchars', $params, [ENT_QUOTES]);
    }
    if ($this->escapeMode == static::ENCODE_STRICT) {
      return array_map('htmlentities', $params, [ENT_QUOTES]);
    }
  }

}