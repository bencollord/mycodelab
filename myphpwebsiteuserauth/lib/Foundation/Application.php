<?php

namespace Lib\Foundation;

use Lib\Http\{Request, Session};
use Lib\Html\Document;
use Lib\Database\Connection;
use Lib\Auth\Authentication;

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