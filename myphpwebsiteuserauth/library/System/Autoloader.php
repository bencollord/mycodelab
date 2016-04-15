<?php

namespace Library\System;

class Autoloader
{
  public static function register() 
  {
    spl_autoload_register('static::load');
  }

  public static function load($class) 
  {
    $filepath = str_replace('\\', DS, lcfirst($class));
    
    if (file_exists($filepath . '.php')) {
      require_once $filepath . '.php';
    }
    
    // @deprecated Will be removed
    if (file_exists(strtolower($filepath) . '.class.php')) {
      require_once strtolower($filepath) . '.class.php';
    }
    if (file_exists(strtolower($filepath) . '.interface.php')) {
      require_once strtolower($filepath) . '.interface.php';
    } 
    if (file_exists(strtolower($filepath) . '.trait.php')) {
      require_once strtolower($filepath) . '.trait.php';
    } 
  }

}