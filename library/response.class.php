<?php

class Response 
{
  private $headers;
  private $body;
  private $statusCode;
  
  public function __construct($body)
  {
    $this->headers = get_headers();
    $this->body    = $body;
  }
  public function redirect() 
  {
    
  }
  public function setHeader()
  {
    
  }
  public function send()
  {
    
  }
  
}