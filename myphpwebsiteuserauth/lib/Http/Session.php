<?php

namespace Lib\Http;

use Lib\System\Object;

class Session extends Object
{
  /**
   * @var bool
   */
  protected $active;

  public function start() 
  {
    session_start();
    
    $this->active = true;
  }

  public function destroy() 
  {
    if(!$this->active) 
    {
      session_start();
    }
    
    session_destroy();
    session_unset();
    setcookie(session_name(), null, 0, "/");
  }

  public function hasKey($key)
  {
    if (isset($_SESSION[$key])){
      return true;
    } else {
      return false;
    }
  }

  public function read($key)
  {
    if(isset($_SESSION[$key])) {
      return $_SESSION[$key];
    } else {
      return false;
    }
  }

  public function write($key, $value)
  {
    $_SESSION[$key] = $value;

    return $this;
  }
  
  public function delete($key)
  {
    unset $_SESSION[$key];
    
    return $this;
  }

}

?>
