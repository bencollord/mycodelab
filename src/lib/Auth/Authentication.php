<?php

namespace MyCodeLab\Auth;

use MyCodeLab\System\Object;
use MyCodeLab\Http\Session;

class Authentication extends Object
{  
  /**
   * Numeric result code constants
   */
  const FAIL_NOT_FOUND  = -1;
  const FAIL_INVALID    =  0;
  const SUCCESS         =  1;
  
  /**
   * @var int The numeric constant matching the result
   */
  protected $result;
  
  /**
   * @var string A descriptive string of the result
   */
  protected $message;
  
  /**
   * @var MyCodeLab\Http\Session
   */
  protected $session;
  
  public function __construct(Session $session)
  {
    $this->session = $session;
  }
  
  public function run($username, $password)
  {
    $user = User::find($username);
    
    if (!$user) {
      $this->result  = self::FAIL_NOT_FOUND;
      $this->message = "Incorrect username!";
    }
    
    if (!$user->passwordIs($password)) {
      $this->result  = self::FAIL_INVALID;
      $this->message = "Incorrect password!";
    }
    
    $this->result  = self::SUCCESS;
    $this->message = "Login successful!";
    
    $this->session->write('user', $user->username);
    
    return $this;
  }
  
  public function clear()
  {
    $this->result  = null;
    $this->message = '';
      
    $this->session->delete('user');
    
    return $this;
  }
  
  public function isValid()
  {
    return ($this->result = self::SUCCESS) ? true : false; 
  }
  
  public function getMessage()
  {
    return $this->message;
  }
  
}