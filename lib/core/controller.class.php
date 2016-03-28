<?php

namespace Lib\Core;

abstract class Controller extends Object
{ 
  protected $page;
  protected $session;
  protected $request;
  protected $response;

  public function __construct($request) 
  {
    $this->request  = $request;
    $this->session  = new Session();
    $this->response = new Response();
  }
  
}