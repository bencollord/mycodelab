<?php
/**
 * Simple utility class for autoloading other classes.
 * 
 * Contains one method for loading classes, and one for loading interfaces.
 * Both are registered at the bottom of the file. 
 * 
 * @todo: Consider moving registration to a file called in bootstrap.php
 * @todo: Consider making into a class that gets instantiated.
 *
 */

class Autoloader 
{
  public function register() 
  {
    spl_autoload_register("$this->loadClass");
    spl_autoload_register("$this->loadInterface");
  }

  private function loadClass($class) 
  {
    $filename = strtolower($class) . '.class.php';
    $file = 'library/' . $filename;
    if (!file_exists($file)) {
      return false;
    }
    else {
      include $file;
    }
  }

  private function loadInterface($interface) 
  {
    $filename = strtolower($interface) . '.interface.php';
    $file = 'library/' . $filename;
    if (!file_exists($file))
    {
      return false;
    }
    else 
    {
      include $file;
    }
  }
}


