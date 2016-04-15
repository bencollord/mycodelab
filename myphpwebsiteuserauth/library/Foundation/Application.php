<?php

namespace Library\Foundation;

use Library\Http\{Request, Session};
use Library\Html\Document;
use Library\Database\Connection;
use Library\Auth\Authentication;

class Application 
{
  public function init()
  {
    $request  = new Request();
    $session  = new Session();
    $document = new Document();
    $database = new Connection();
    $auth     = new Authentication($request, $session);
  }
  
}