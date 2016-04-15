<?php

namespace Library\System;

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
  private $path;

  /**
   * @var string[]
   */
  private $queryParams; 

  /**
   * @var string
   */
  private $anchor;

  public function __construct($url)
  {
    $parsedUrl = parse_url($url);

    $this->protocol     = $parsedUrl['scheme']   ?? null;
    $this->hostName     = $parsedUrl['host']     ?? null;
    $this->port         = $parsedUrl['port']     ?? null;
    $this->username     = $parsedUrl['user']     ?? null;
    $this->password     = $parsedUrl['pass']     ?? null;
    $this->path         = $parsedUrl['path']     ?? null;
    $this->queryParams  = $parsedUrl['query']    ?? null;
    $this->anchor       = $parsedUrl['fragment'] ?? null;
  }

  public function __toString()
  {
    return $this->protocol . $this->hostName . $this->path . '?' . $this->queryParams . '#' . $this->anchor;
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
   * @return string
   */
  public function getPath()
  {
    return $this->path;
  }

  /**
   * @return string
   */
  public function getQueryParams()
  {
    return $this->queryParams;
  }

  /**
   * @return string
   */
  public function getAnchor()
  {
    return $this->anchor;
  }

}