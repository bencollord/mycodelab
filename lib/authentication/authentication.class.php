<?php

namespace Lib\Authentication;

use Lib\Core\{Object, Request, Session};

/**
 * Manages and tracks user logins and access privileges.
 */
class Authentication extends Object
{
  protected $session;
  protected $request;
  protected $response;
  protected $currentUser;
  
  public function identify()
  {
    
  }
  
  public function authenticate()
  {
    
  }  
  
}