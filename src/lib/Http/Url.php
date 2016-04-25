<?php

namespace MyCodeLab\Http;

use MyCodeLab\System\Object;

class Url extends Object
{
  /**
   * @var string
   */
  private $protocol; 

  /**
   * @var string
   */
  private $hostName;

  /**
   * @var int
   */
  private $port;
  
  /** 
   * @var string
   */
  private $username;
  
  /** 
   * @var string
   */
  private $password;

  /**
   * @var string
   */
  private $path;

  /**
   * @var string
   */
  private $query; 

  /**
   * @var string
   */
  private $anchor;

  public function __construct($url)
  {
    $parsedUrl = parse_url($url);

    $this->protocol = $parsedUrl['scheme']   ?? null;
    $this->hostName = $parsedUrl['host']     ?? null;
    $this->port     = $parsedUrl['port']     ?? null;
    $this->username = $parsedUrl['user']     ?? null;
    $this->password = $parsedUrl['pass']     ?? null;
    $this->path     = $parsedUrl['path']     ?? null;
    $this->query    = $parsedUrl['query']    ?? null;
    $this->anchor   = $parsedUrl['fragment'] ?? null;
  }

  public function __toString()
  {
    $url = $this->protocol . $this->hostName;
    
    if ($this->path) {
      $url .= $this->path;
    }
    if ($this->query) {
      $url .= '?' . $this->query;
    }
    if ($this->anchor) { 
      $url .= '#' . $this->anchor;
    }
    
    return $url;
  }

  /**
   * @return mixed[string]
   */
  public function toArray()
  {
    $array = [
      'protocol'    => $this->protocol, 
      'hostName'    => $this->hostName, 
      'port'        => $this->port, 
      'path'        => $this->path, 
      'queryParams' => $this->queryParams, 
      'anchor'      => $this->anchor 
    ];

    return $array;
  }

  /**
   * @return string
   */
  public function getProtocol()
  {
    return $this->protocol;
  }

  /**
   * @return string
   */
  public function getHostName()
  {
    return $this->hostName;
  }

  /**
   * @return int
   */
  public function getPort()
  {
    return $this->port;
  }

  /**
   * @return string
   */
  public function getUsername()
  {
    return $this->username;
  }

  /**
   * @return string
   */
  public function getPassword()
  {
    return $this->password;
  }

  /**
   * Gets full path string.
   * 
   * @return string
   */
  public function getPath()
  {
    return $this->path;
  }
  
  /**
   * Gets path as an array.
   * 
   * @return string[]
   */
  public function getPathFragments()
  {
    return explode('/', $this->path);
  }

  /**
   * Gets query as full query string.
   * 
   * @return string
   */
  public function getQueryString()
  {
    return $this->query;
  }
  
  /**
   * Gets query string parameters as an associative array.
   * 
   * @return string[string]
   */
  public function getQueryParams()
  {
    $params = array();
    
    parse_str($this->query, $params);
    
    return $params;
  }

  /**
   * Gets the fragment/anchor.
   * 
   * @return string
   */
  public function getAnchor()
  {
    return $this->anchor;
  }

}