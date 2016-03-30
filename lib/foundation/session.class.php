<?php

namespace Lib\Foundation;

class Session extends Object
{
  /**
   * @var bool
   */
  protected $active;
  
  /**
   * @var bool
   */
  protected $signed;

  public function start() 
  {
    if(session_start()) {
      $this->active = true;
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
    if(!$this->active) 
    {
      session_start();
    }
    session_destroy();
    session_unset();
    setcookie(session_name(), null, 0, "/");
  }

  public function isSigned()
  {
    return $this->signed;
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
