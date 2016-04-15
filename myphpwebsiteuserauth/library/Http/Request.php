<?php

namespace Library\Http;

use Library\System\Object;

// @todo: unify the getter api with the current getter/setter scheme (array issue);
class Request extends Object
{
  /**
   * @var string[string] HTTP headers
   */
  protected $headers;

  /**
   * @var mixed[string] The request body pulled from the $_REQUEST superglobal
   */
  protected $body = array();

  /**
   * @var string HTTP request method
   */
  protected $method;

  /**
   * @var string Request MIME type
   */
  protected $contentType;

  /**
   * @var string
   */
  protected $uri;

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
  protected $cookies = array();

  /**
   * @var resource[]|resource  FILES parameters
   */
  protected $files = array();

  public function __construct(array $params = array()) 
  {
    $this->headers      = isset($params['headers']    ) ? $params['headers']     : null;
    $this->body         = isset($params['body']       ) ? $params['body']        : null;
    $this->method       = isset($params['method']     ) ? $params['method']      : null;
    $this->contentType  = isset($params['contentType']) ? $params['contentType'] : null;
    $this->uri          = isset($params['uri']        ) ? $params['uri']         : null;
    $this->query        = isset($params['query']      ) ? $params['query']       : null;
    $this->post         = isset($params['post']       ) ? $params['post']        : null;
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
    $params['body']         = $_REQUEST;
    $params['server']       = $_SERVER; 
    $params['method']       = $_SERVER['REQUEST_METHOD'];
    $params['contentType']  = (isset($_SERVER['CONTENT_TYPE'])) ? $_SERVER['CONTENT_TYPE'] : null;
    $params['query']        = (!empty($_GET))     ? $_GET     : null;
    $params['post']         = (!empty($_POST))    ? $_POST    : null;
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
   * Read a value from the request body
   * 
   * @param  string $key  Optional key for specific var.
   * @return mixed|array  Returns the value stored at $key, or the whole array
   *                      if none is defined.
   */
  public function read($key = null)
  {
    if($key != null) {
      return $this->body[$key];
    } else {
      return $this->body;
    }
  }

  /**
   * Read a value from $query
   * 
   * @param  string $key  Optional key for specific var.
   * @return mixed|array  Returns the value stored at $key, or the whole array
   *                      if none is defined.
   */
  public function readQuery($key = null) 
  {
    if($key != null) {
      return $this->query[$key];
    } else {
      return $this->query;
    }
  }

  /**
   * Read a value from $post
   * 
   * @param  string $key    Optional key for specific var.
   * @return mixed[]|mixed  Returns the value stored at $key, or the whole 
   *                         array if none is defined.
   */
  public function readPost($key = null)
  {
    if($key != null) {
      return $this->post[$key];
    } else {
      return $this->post;
    }
  }

  /**
   * Read a value from $server
   * 
   * @param  string $key    Optional key for specific var.
   * @return mixed[]|mixed  Returns the value stored at $key, or the whole 
   *                         array if none is defined.
   */
  public function readServer($key = null)
  {
    if($key != null) {
      return $this->server[$key];
    } else {
      return $this->server;
    }
  }

  /**
   * Read a value from $cookies
   * 
   * @param  string $key      Optional key for specific var.
   * @return string[]|string  Returns the value stored at $key, or the whole 
   *                           array if none is defined.
   */
  public function readCookies($key = null)
  {
    if($key != null) {
      return $this->cookies[$key];
    } else {
      return $this->cookies;
    }
  }

  /**
   * Read a value from $files
   * 
   * @param  string $key          Optional key for specific var.
   * @return resource[]|resource  Returns the value stored at $key, or the 
   *                               whole array if none is defined.
   */
  public function readFiles($key = null)
  {
    if($key != null) {
      return $this->files[$key];
    } else {
      return $this->files;
    }
  }


}