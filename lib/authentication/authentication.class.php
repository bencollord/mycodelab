<?php

namespace Lib\Authentication;

use Lib\Foundation\{Object, Request, Session};
use Lib\Database\SqlCommand;

/**
 * Manages and tracks user logins and access privileges.
 */
class Authentication extends Object
{
  /** 
   * @var Lib\Foundation\Request
   */
  protected $request;
  
  /** 
   * @var Lib\Foundation\Session
   */
  protected $session;
  
  /** 
   * @var Lib\Foundation\Request
   */
  protected $database;
  
  public function __construct(Request $request, Session $session)
  {
    $this->request = $request;
    $this->session = $session;
  }
  
  // @todo: decouple from SQL and add Entity support
  public function identify()
  {
    $username = $this->request->post['username'];
    $password = $this->request->post['password'];
    $command  = new SqlCommand();
    
    $command->write('SELECT * FROM ')
  }
  
  public function authenticate()
  {
    
  }  
  
}