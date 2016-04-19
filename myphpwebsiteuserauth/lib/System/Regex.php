<?php

namespace Lib\System;

/**
 * Represents a regular expression. 
 * 
 * Currently acts as an object oriented wrapper around PRCE functions, but
 * will eventually be extended to add additional functionality.
 */
class Regex extends Object
{
  /**
   * @var string The regular expression to compare against
   */
  private $pattern;
  
  public function __construct($regex)
  {
    $this->pattern = $regex;
  }
  
  /**
   * Replace a match in a string with a replacement value
   * 
   * @param  string          $string
   * @param  string|Callable $replacement
   * @return string          The modified string
   */
  public function replace($string, $replacement)
  {
    if (is_callable($replacement)) {
      return preg_replace_callback($this->pattern, $replacement, $string);
    } else {
      return preg_replace($this->pattern, $replacement, $string);
    }
  }
  
  /**
   * Check if a string matches the pattern
   * 
   * @param  string|string[] $string
   * @return bool
   */
  public function match($string)
  {
    return (bool)preg_match($this->pattern, $string);
  }
  
  /**
   * Find all matches in a string
   * 
   * @param  string|string[] $string 
   * @return int The number of matches found.
   */
  public function matchAll($string)
  {
    return preg_match_all($this->pattern, $string);
  }
  
  /**
   * Split a string using a pattern
   * 
   * @param  string $string    
   * @return string[] An array of the fragments of the split string.
   */
  public function split($string)
  {
    return preg_split($this->pattern, $string);
  }
  
  /**
   * Find all matching items in an array
   * 
   * @param string[] $strings
   * @return string[]
   */
  public function grep(array $strings)
  {
    return preg_grep($this->pattern, $strings);
  }
  
  public function __toString()
  {
    return $this->pattern;
  }
  
}