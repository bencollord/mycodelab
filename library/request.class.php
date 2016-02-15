<?php
//@todo: filter user input

class Request
{
  private $headers;
  private $method;
  private $url;
  private $route  = array();
  private $query  = array();
  private $data   = array();

  public function __construct() 
  {
    $this->headers = apache_request_headers(); 
    $this->method  = $_SERVER['REQUEST_METHOD'];

    if(isset($_GET['url'])) 
    {
      $this->url = $_GET['url'];
      unset($_GET['url']);
    }
    if(!empty($_GET)) 
    {
      $this->query = $_GET;
    }
    if(!empty($_POST))
    {
      $this->data = $_POST;
    }
  }

  public function getMethod() {}
  
  public function getUrl() 
  {
    if(isset($this->url))
    {
      return $this->url;
    } 
    else
    {
      return false;
    }
  }
  public function getController() 
  {
    return $this->route['controller'];
  }
  
  public function getAction()
  {
    return $this->route['action'];
  }
  
  public function getParams() 
  {
    return $this->route['params'];
  }
  
  public function getQuery() {}
  
  public function getData() {}
  
}