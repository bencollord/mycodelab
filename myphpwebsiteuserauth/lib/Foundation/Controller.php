<?php

namespace Lib\Foundation;

use Lib\System\Object;
use Lib\Http\Request;
use Lib\Http\Response;

abstract class Controller extends Object
{ 
  protected $request;
  protected $response;
  protected $page;
  protected $actions = array();

  public function __construct(Request $request) 
  {
    $this->request  = $request;
    $this->response = new Response();
  }
  
  public function init() {}
  
  public function run() {}
  
}