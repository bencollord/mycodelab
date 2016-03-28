<?php

namespace Lib\Foundation;

//@todo: full support for COOKIES, SERVER, and FILES parameters

class Request extends Object
{
  /**
   * @var string[string]  HTTP headers
   */
  protected $headers;

  /**
   * @var string  HTTP request method
   */
  protected $method;

  /**
   * @var string  Request MIME type
   */
  protected $contentType;

  /**
   * @var string
   */
  protected $uri;
  
  /**
   * @var Session
   */
  protected $session;

  /**
   * @var mixed[]|mixed  Query string (GET) parameters
   */
  protected $query = array();

  /**
   * @var mixed[]|mixed  Request body (POST) parameters
   */
  protected $body = array();

  /**
   * @var mixed[]|mixed  SERVER parameters
   */
  protected $server = array();

  /**
   * @var string[]|string  COOKIES parameters
   */
  protected $cookies = array();

  /**
   * @var resource[]|resource  FILES parameters
   */
  protected $files = array();

  public function __construct(array $params = array()) 
  {
    $this->headers      = isset($params['headers']    ) ? $params['headers']     : null;
    $this->method       = isset($params['method']     ) ? $params['method']      : null;
    $this->contentType  = isset($params['contentType']) ? $params['contentType'] : null;
    $this->uri          = isset($params['uri']        ) ? $params['uri']         : null;
    $this->query        = isset($params['query']      ) ? $params['query']       : null;
    $this->body         = isset($params['body']       ) ? $params['body']        : null;
    $this->server       = isset($params['server']     ) ? $params['server']      : null;
    $this->cookies      = isset($params['cookies']    ) ? $params['cookies']     : null;
    $this->files        = isset($params['files']      ) ? $params['files']       : null;
  }

  /**
   * Creates a new instance using data from superglobals
   * 
   * @return Request
   */
  public static function forge() 
  {
    // Make sure query string is empty if no other GET params were sent
    $uri = (isset($_GET['uri'])) ? $_GET['uri'] : null;
    unset($_GET['uri']);

    $params['uri']          = $uri;
    $params['headers']      = apache_request_headers(); 
    $params['server']       = $_SERVER; 
    $params['method']       = $_SERVER['REQUEST_METHOD'];
    $params['contentType']  = (isset($_SERVER['CONTENT_TYPE'])) ? $_SERVER['CONTENT_TYPE'] : null;
    $params['query']        = (!empty($_GET))     ? $_GET     : null;
    $params['body']         = (!empty($_POST))    ? $_POST    : null;
    $params['files']        = (!empty($_FILES))   ? $_FILES   : null;
    $params['cookies']      = (!empty($_COOKIES)) ? $_COOKIES : null;

    return new self($params);
  }

  /**
   * Getter method for $method
   * 
   * @return string  The HTTP request method
   */
  public function getMethod() 
  {
    return $this->method;   
  }

  /**
   * Getter method for $uri
   * 
   * @return string|boolean
   */
  public function getUri() 
  {
    if(isset($this->uri)) {
      return $this->uri;
    } else {
      return false;
    }
  }

  /**
   * Getter method for $query
   * 
   * @param  string $key  Optional key for specific var.
   * @return mixed|array  Returns the value stored at $key, or the whole array
   *                       if none is defined.
   */
  public function getQuery($key = null) 
  {
    if($key != null) {
      return $this->query[$key];
    } else {
      return $this->query;
    }
  }

  /**
   * Getter method for $body
   * 
   * @param  string $key    Optional key for specific var.
   * @return mixed[]|mixed  Returns the value stored at $key, or the whole 
   *                         array if none is defined.
   */
  public function getBody($key = null)
  {
    if($key != null) {
      return $this->body[$key];
    } else {
      return $this->body;
    }
  }

  /**
   * Getter method for $server
   * 
   * @param  string $key    Optional key for specific var.
   * @return mixed[]|mixed  Returns the value stored at $key, or the whole 
   *                         array if none is defined.
   */
  public function getServer($key = null)
  {
    if($key != null) {
      return $this->server[$key];
    } else {
      return $this->server;
    }
  }

  /**
   * Getter method for $cookies
   * 
   * @param  string $key      Optional key for specific var.
   * @return string[]|string  Returns the value stored at $key, or the whole 
   *                           array if none is defined.
   */
  public function getCookies($key = null)
  {
    if($key != null) {
      return $this->cookies[$key];
    } else {
      return $this->cookies;
    }
  }

  /**
   * Getter method for $files
   * 
   * @param  string $key          Optional key for specific var.
   * @return resource[]|resource  Returns the value stored at $key, or the 
   *                               whole array if none is defined.
   */
  public function getFiles($key = null)
  {
    if($key != null) {
      return $this->files[$key];
    } else {
      return $this->files;
    }
  }

}