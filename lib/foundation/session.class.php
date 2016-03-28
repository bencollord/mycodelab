<?php

namespace Lib\Foundation;

class Session extends Object
{
  private $status;
  private $activeUser;

  public function start() 
  {
    if(session_start()) {
      $this->status = true;
      if(isset($_SESSION['user'])) {
        $this->signed = true;
      }
      return true;
    } else {
      return false;
    }
  }

  public function end() 
  {
    if(!$this->status) 
    {
      session_start();
    }
    session_destroy();
    session_unset();
    setcookie(session_name(), null, 0, "/");
  }

  public function isSigned()
  {
    return $this->isSigned();
  }

  public function keyExists($key)
  {
    if (isset($_SESSION[$key])){
      return true;
    } else {
      return false;
    }
  }

  public function getKey($key)
  {
    if(!isset($_SESSION[$key])) {
                return false;
            }
            return $_SESSION[$key];
  }

  public function setKey($key, $value)
  {
    $_SESSION[$key] = $value;
    
    return $this;
  }

}

?>
