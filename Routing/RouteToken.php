<?php

namespace MyCodeLab\Routing;

use MyCodeLab\System\Regex;

class RouteToken extends Regex
{  
  const MARKER      = '/\<([A-Za-z0-9]+)(:.*?)?\>/';
  const MATCH_ALL   = '/.+/';
  const MATCH_ANY   = '/[^/]+/';
  const MATCH_INT   = '/[0-9]+/';
  const MATCH_ALPHA = '/[A-Za-z]+/';
  const MATCH_ALNUM = '/[A-Za-z0-9]+/';
  
  /**
   * @var string
   */
  protected $name;
  
  public function __construct($name, $pattern = null)
  {
    $this->name    = $name;
    $this->pattern = ($pattern) ? $pattern : self::MATCH_ANY;
  }
  
  /**
   * @return string
   */
  public function getName()
  {
    return $this->name;
  }
  
}