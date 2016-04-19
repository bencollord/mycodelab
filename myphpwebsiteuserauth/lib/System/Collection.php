<?php

namespace Lib\System;

use \ArrayAccess; 
use \Countable; 
use \IteratorAggregate;
use \InvalidArgumentException;

abstract class Collection extends Object implements ArrayAccess, Countable, IteratorAggregate
{
  /**
   * Array where the Collection items are stored.
   * 
   * @var array[]
   */
  protected $storage;

  public function __construct(array $items = array())
  {
    $this->storage = $items;
  }

  /**
   * Appends an item to the end of the Collection.
   * 
   * Wrapper for PHP's array_push function.
   * 
   * @param  mixed    $value     
   * @param  mixed ...$values 
   * @return $this
   */
  public function push($value, ...$values)
  {
    array_push($this->storage, $value, ...$values);
    
    return $this;
  }

  /**
   * Removes the last item from the end of the Collection and returns it.
   * 
   * Wrapper for PHP's array_pop function.
   * 
   * @return mixed
   */
  public function pop()
  {
    return array_pop($this->storage);
  }

  /**
   * Removes the first item from the Collection and returns it.
   * 
   * Wrapper for PHP's array_shift function.
   * 
   * @return mixed
   */
  public function shift()
  {
    return array_shift($this->storage);
  }

  /**
   * Prepends an item to the beginning of the collection.
   * 
   * Wrapper for PHP's array_unshift function.
   * 
   * @return $this
   */
  public function unshift($value)
  {
    array_unshift($this->storage, $value);
    
    return $this;
  }

  /**
   * Adds an item and sets its key.
   * 
   * Will overwrite the previous key if there is a naming conflict.
   * 
   * @param  string|int $key
   * @param  mixed      $value
   * @return $this
   */
  public function set($key, $value)
  {
    $this->storage[$key] = $value;
    
    return $this;
  }

  /**
   * Gets a specified item by its key and removes it from the Collection.
   * 
   * @param  string|int $key 
   * @return mixed
   */
  public function pull($key)
  {
    $value = $this->storage[$key];

    unset($this->storage[$key]);

    return $value;
  }

  /**
   * Returns a specified piece of the Collection.
   * 
   * Wrapper for PHP's array_slice function, but differs in 
   * that $preserveKeys defaults to true instead of false.
   * 
   * @param  int  $offset
   * @param  int  $length
   * @param  bool $preserveKeys
   * @return static
   */
  public function slice($offset, $length = null, $preserveKeys = true)
  {
    $slice = array_slice($this->storage, $offset, $length, $preserveKeys);

    return new static($slice);
  }

  /**
   * Concatenates the Collection into a string with the specified separator.
   * 
   * Wrapper for PHP's implode function.
   * 
   * @param  string $separator
   * @return string
   */
  public function implode($separator = ' ')
  {
    return implode($separator, $this->storage);
  }

  /**
   * Creates a Collection with only the unique items from the original.
   * 
   * Wrapper for PHP's array_unique function.
   * 
   * @return static
   */
  public function unique()
  {
    $uniqueItems = array_unique($this->storage);

    return new static($uniqueItems);
  }

  /**
   * Returns a random item.
   * 
   * Wrapper for PHP's array_rand function.
   * 
   * @return mixed
   */
  public function random()
  {
    return array_rand($this->storage);
  }

  /**
   * Creates a new Collection with the items in reverse order.
   * 
   * Wrapper for PHP's array_reverse function
   * 
   * @return static
   */  
  public function reverse()
  {
    $reversedItems = array_reverse($this->storage);

    return new static($reversedItems);
  }

  /**
   * Sorts items according to predefined flags.
   * 
   * @param  int   $order
   * @param  int   $sortType
   * @throws InvalidArgumentException if $order or $sortType are not valid flags.
   * @return $this
   */
  public function sort($order = SORT_ASC, $sortType = SORT_REGULAR)
  {
    if ($order != SORT_ASC || $order != SORT_DESC) {
      throw new InvalidArgumentException("Method sort() expects either SORT_ASC or SORT_DESC as it's first argument");
    }
    
    try {
      $order == SORT_DESC ? rsort($this->storage, $sortType) : sort($this->storage, $sortType);
    } catch (Exception $e) {
      throw new InvalidArgumentException("Sort type flag passed in argument 2 was invalid", 0, $e);
    }
    
    return $this;
  }
  
  /**
   * Sort items with a callback function.
   * 
   * @param  Callable $callback
   * @return $this
   */
  public function sortWith(Callable $callback)
  {
    usort($this->storage, $callback);
    
    return $this;
  }

  /**
   * Rearranges items into a random order.
   * 
   * Wrapper for PHP's shuffle function.
   * 
   * @return $this
   */
  public function shuffle()
  {
    shuffle($this->storage);

    return $this;
  }

  /**
   * Get the first item in the Collection.
   * 
   * Does not remove the item like shift()
   * 
   * @return mixed
   */
  public function first()
  {
    return array_values($this->storage)[0];
  }

  /**
   * Get the last item in the Collection.
   * 
   * Does not remove the item like pop()
   * 
   * @return mixed
   */
  public function last()
  {
    return end(array_values($this->storage));
  }

  /**
   * Check if specified index is in the Collection.
   * 
   * Wrapper for PHP's array_key_exists function.
   * 
   * $param  string|int $key
   * @return bool
   */
  public function hasKey($key)
  {
    return array_key_exists($key, $this->storage);
  }

  /**
   * Check if specified value is in the Collection.
   * 
   * Wrapper for PHP's in_array function.
   * 
   * @param  mixed $value
   * @return bool
   */
  public function contains($value)
  {
    return in_array($this->storage);
  }

  /**
   * Get a list of keys in the Collection.
   * 
   * @return string[]|int[]
   */
  public function keys()
  {
    return array_keys($this->storage);
  }

  /**
   * Apply a callback to each of the Collection's items
   * 
   * @param  Callable
   * @return $this
   */
  public function each(Callable $callback)
  {
    foreach ($this->storage as $key => $value) {
      $callback($value, $key);
    }

    return $this;
  }

  /**
   * Creates a new Collection with the current Collection's items
   * as keys and the passed array's items as values
   * 
   * @param  array|ArrayAccess $values
   * @return static
   */
  public function combine($values)
  {
    if ($values instanceof ArrayAccess) {
      $values = (array)$values
    }

    $newArray = array_combine($this->storage, $values);

    return new static($newArray);
  }

  /**
   * Adds a list of values to the Collection.
   * 
   * Implementations of ArrayAccess are cast to arrays to work
   * with the array_merge function.
   * 
   * @param  array|ArrayAccess    $newItems
   * @param  array|ArrayAccess ...$additionalItems
   * @return $this
   */
  public function merge($newItems, ...$additionalItems)
  {
    $this->storage = array_merge($this->storage, (array)$newItems, ...(array)$additionalItems);

    return $this;
  }

  /**
   * Gets the underlying array.
   * 
   * @return array
   */
  public function toArray()
  {
    return $this->storage;
  }

  /**
   * Returns a JSON representation of the Collection data.
   * 
   * @return string
   */
  public function toJson()
  {
    return json_encode($this->storage);
  }


  // Interface Implementations
  // ===========================================================================

  //
  // ArrayAccess
  //

  public function offsetGet($offset)
  {
    return $this->storage[$offset];
  }

  public function offsetSet($offset, $value)
  {
    $this->storage[$offset] = $value;
  }

  public function offsetUnset($offset)
  {
    unset($this->storage[$offset]);
  }

  public function offsetExists($offset)
  {
    return isset($this->storage[$offset]);
  }


  //
  // Countable
  // 

  public function count()
  {
    return count($this->itmes);
  }

  //
  // Iterator Aggregate
  // 

  public function getIterator()
  {
    return new ArrayIterator($this->itmes);
  }

}