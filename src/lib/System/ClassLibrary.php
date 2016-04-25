<?php

namespace MyCodeLab\System;

class ClassLibrary
{
  protected $namespace;
  
  protected $directory;
  
  public function __construct($namespace, $directory)
  {
    $this->namespace = $namespace;
    $this->directory = $directory;
  }
  
  public function register() 
  {
    spl_autoload_register([$this, 'loadFile']);
  }

  public function findClassFile($fullyQualifiedName)
  {
    $classPath = ltrim($fullyQualifiedName, $this->namespace);
    $filepath  = ROOT . $this->directory . str_replace('\\', DS, $classPath) . '.php';
    
    return (file_exists($filepath)) ? $filepath : false;
  }
  
  public function findExceptionFile($fullyQualifiedName)
  {
    $exceptionPath = ltrim($fullyQualifiedName, $this->namespace);
    $pathFragments = explode('\\', $exceptionPath);
    array_pop($pathFragments);
    
    $filepath = ROOT . $this->directory 
              . implode(DS, $pathFragments) 
              . DS . 'Exception.php';
    
    return (file_exists($filepath)) ? $filepath : false;
  }
  
  public function loadFile($fullyQualifiedName) 
  {    
    if ($classFile = $this->findClassFile($fullyQualifiedName)) {
      require_once $classFile;
    }
    if ($exceptionFile = $this->findExceptionFile($fullyQualifiedName)) {
      require_once $exceptionFile;
    }
  }

}