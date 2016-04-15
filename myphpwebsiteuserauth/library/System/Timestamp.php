<?php

namespace Library\System;

use \DateTime;
use \InvalidArgumentException;

/**
 * Represents a Unix timestamp.
 * 
 * Provides a simplified interface for PHP's native DateTime class.
 */
class Timestamp extends Object
{
  /**
   * @var [type] A Unix timestamp representing the point in time.
   */
  protected $timestamp;
  
  public function __construct($time)
  {
    $timestamp = strtotime($time);
    
    if ($timestamp) {
      $this->timestamp = $timestamp;
    } else {
      throw new InvalidArgumentException("Error $time is not a valid date/time string");
    }
  }
  
}