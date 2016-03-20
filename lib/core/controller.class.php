<?php

namespace Lib\Core;

use Lib\Core\Object;

abstract class Controller extends Object
{ 
  protected $session;
  protected $request;
  protected $response;

  public function __construct($request, $session) 
  {
    $this->request  = $request;
    $this->session  = $session;
    $this->response = new Response();
  }
  
}