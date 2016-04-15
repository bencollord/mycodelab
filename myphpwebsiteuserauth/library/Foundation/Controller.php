<?php

namespace Library\Foundation;

use Library\System\Object;
use Library\Http\Request;
use Library\Http\Response;

abstract class Controller extends Object
{ 
  protected $request;
  protected $response;

  public function __construct(Request $request) 
  {
    $this->request  = $request;
    $this->response = new Response();
  }
  
}