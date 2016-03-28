<?php

namespace Lib\Core;

class Autoloader
{
  public static function register() 
  {
    spl_autoload_register('static::load');
  }

  public static function load($class) 
  {
    $class    = strtolower($class);
    $filename = ROOT . str_replace('\\', DS, $class);
    
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