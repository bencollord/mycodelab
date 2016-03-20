<?php

namespace Lib\Core;

use Lib\Core\Object;

class Autoloader extends Object
{
  public static function register() 
  {
    spl_autoload_register("$this->loadClass");
    spl_autoload_register("$this->loadInterface");
  }

  private static function load($class) 
  {
    $class    = strtolower($class);
    $filename = LIB_PATH . str_replace('\\', DS, $class);
    
    if (file_exists($filename . '.class.php')) {
      require_once $filename . '.class.php';
    } elseif (file_exists($filename . '.interface.php')) {
      require_once $filename . '.interface.php';
    } elseif (file_exists($filename . '.trait.php')) {
      require_once $filename . '.trait.php';
    } else {
      return false;
    }
  }

}