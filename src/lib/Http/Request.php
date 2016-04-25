<?php

namespace MyCodeLab\Http;

use MyCodeLab\System\Object;

class Request extends Object
{
  /**
   * @var string[string] HTTP headers
   */
  protected $headers;

  /**
   * @var string HTTP request method
   */
  protected $method;

  /**
   * @var string Request MIME type
   */
  protected $contentType;

  /**
   * @var MyCodeLab\Http\Url
   */
  protected $url;

  /**
   * @var mixed[]|mixed  Query string (GET) parameters
   */
  protected $query = array();

  /**
   * @var mixed[]|mixed  Request body (POST) parameters
   */
  protected $post = array();

  /**
   * @var mixed[]|mixed  SERVER parameters
   */
  protected $server = array();

  /**
   * @var string[]|string  COOKIES parameters
   */
  protected $cookie = array();

  /**
   * @var resource[]|resource  FILES parameters
   */
  protected $files = array();

  public function __construct(array $params = array()) 
  {
    $this->headers      = isset($params['headers']    ) ? $params['headers']     : null;
    $this->method       = isset($params['method']     ) ? $params['method']      : null;
    $this->contentType  = isset($params['contentType']) ? $params['contentType'] : null;
    $this->url          = isset($params['url']        ) ? $params['url']         : null;
    $this->query        = isset($params['query']      ) ? $params['query']       : null;
    $this->post         = isset($params['post']       ) ? $params['post']        : null;
    $this->server       = isset($params['server']     ) ? $params['server']      : null;
    $this->cookie       = isset($params['cookie']     ) ? $params['cookie']      : null;
    $this->files        = isset($params['files']      ) ? $params['files']       : null;
  }

  /**
   * Creates a new instance using data from superglobals
   * 
   * @return static
   */
  public static function capture() 
  {
    // Make sure query string is empty if no other GET params were sent
    // @todo: Request probably shouldn't be responsible for creating Url
    $urlString = (isset($_GET['path'])) ? DOMAIN_NAME . DS . $_GET['path'] : DOMAIN_NAME;
    $urlString .= $_SERVER['QUERY_STRING'] ?? null;
    
    unset($_GET['path']);

    $params['url']          = new Url($urlString);
    $params['headers']      = apache_request_headers();
    $params['server']       = $_SERVER; 
    $params['method']       = $_SERVER['REQUEST_METHOD'];
    $params['contentType']  = $_SERVER['CONTENT_TYPE'] ?? null;
    $params['query']        = $_GET;
    $params['post']         = $_POST;
    $params['files']        = $_FILES;
    $params['cookie']       = $_COOKIE;

    return new static($params);
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
   * Getter method for $url
   * 
   * @return string|boolean
   */
  public function getUrl() 
  {
    if(isset($this->url)) {
      return $this->url;
    } else {
      return false;
    }
  }

  /**
   * Fetch a value from $query
   * 
   * @param  string $key  Optional key for specific var.
   * @return mixed|array  Returns the value stored at $key, or the whole array
   *                      if none is defined.
   */
  public function query($key = null) 
  {
    if($key != null) {
      return $this->query[$key];
    } else {
      return $this->query;
    }
  }

  /**
   * Fetch a value from $post
   * 
   * @param  string $key    Optional key for specific var.
   * @return mixed[]|mixed  Returns the value stored at $key, or the whole 
   *                         array if none is defined.
   */
  public function post($key = null)
  {
    if($key != null) {
      return $this->post[$key];
    } else {
      return $this->post;
    }
  }

  /**
   * Fetch a value from $server
   * 
   * @param  string $key    Optional key for specific var.
   * @return mixed[]|mixed  Returns the value stored at $key, or the whole 
   *                         array if none is defined.
   */
  public function server($key = null)
  {
    if($key != null) {
      return $this->server[$key];
    } else {
      return $this->server;
    }
  }

  /**
   * Fetch a value from $cookie
   * 
   * @param  string $key      Optional key for specific var.
   * @return string[]|string  Returns the value stored at $key, or the whole 
   *                           array if none is defined.
   */
  public function cookie($key = null)
  {
    if($key != null) {
      return $this->cookie[$key];
    } else {
      return $this->cookie;
    }
  }

  /**
   * Fetch a value from $files
   * 
   * @param  string $key          Optional key for specific var.
   * @return resource[]|resource  Returns the value stored at $key, or the 
   *                               whole array if none is defined.
   */
  public function files($key = null)
  {
    if($key != null) {
      return $this->files[$key];
    } else {
      return $this->files;
    }
  }


}