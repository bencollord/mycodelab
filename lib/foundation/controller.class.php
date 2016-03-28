<?php

namespace Lib\Foundation;

abstract class Controller extends Object
{ 
  protected $page;
  protected $request;
  protected $response;

  public function __construct($request) 
  {
    $this->request  = $request;
    $this->response = new Response();
  }
  
}