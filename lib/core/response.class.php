<?php

namespace Lib\Core;

class Response extends Object
{
  /**
   * @var string[]
   */
  const STATUS_CODES = [
    100 =>  'Continue',
    101 =>  'Switching Protocols',
    200 =>  'OK',
    201 =>  'Created',
    202 =>  'Accepted',
    203 =>  'Non-Authoritative Information',
    204 =>  'No Content',
    205 =>  'Reset Content',
    206 =>  'Partial Content',
    300 =>  'Multiple Choices',
    301 =>  'Moved Permanently',
    302 =>  'Found',
    303 =>  'See Other',
    304 =>  'Not Modified',
    305 =>  'Use Proxy',
    307 =>  'Temporary Redirect',
    400 =>  'Bad Request',
    401 =>  'Unauthorized',
    402 =>  'Payment Required',
    403 =>  'Forbidden',
    404 =>  'Not Found',
    405 =>  'Method Not Allowed',
    406 =>  'Not Acceptable',
    407 =>  'Proxy Authentication Required',
    408 =>  'Request Time-out',
    409 =>  'Conflict',
    410 =>  'Gone',
    411 =>  'Length Required',
    412 =>  'Precondition Failed',
    413 =>  'Request Entity Too Large',
    414 =>  'Request-URI Too Large',
    415 =>  'Unsupported Media Type',
    416 =>  'Requested range not satisfiable',
    417 =>  'Expectation Failed',
    500 =>  'Internal Server Error',
    501 =>  'Not Implemented',
    502 =>  'Bad Gateway',
    503 =>  'Service Unavailable',
    504 =>  'Gateway Time-out',
    505 =>  'HTTP Version not supported'
  ];

  /**
   * @var string[]
   */
  protected $headers = array();

  /**
   * @var string - Response MIME type
   */
  protected $contentType;

  /**
   * @var string
   */
  protected $body = '';

  /**
   * @var int
   */
  protected $status;

  public function redirect($path) 
  {
    header("Location: $path");
  }

  public function addHeader($header, $value = null)
  {
    if (empty($value)) {
      $fragments = explode(':', $header);
      $header    = array_shift($fragments);
      $value     = implode(':', $fragments);
    }
    
    $this->headers[$header] = $value;
    
    return $this;
  }

  /**
   * Appends content to the response body.
   * 
   * @param string $input 
   */
  public function write($input) 
  {
    $this->body .= (string) $input;
    
    return $this;
  }

  public function send()
  {
    $this->sendHeaders();

    echo $this->body;
  }

  public function sendHeaders()
  {
    foreach ($this->headers as $name => $value) {
      header("{$name}: {$value}");
    }
  }

}