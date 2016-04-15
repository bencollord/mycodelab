<?php

namespace Library\Database;

use Library\System\Object;

class Config extends Object
{
  private $driver;
  private $host;
  private $dbName;
  private $username;
  private $password;
  
  public function getDriver()
  {
    return $this->driver;
  }
    
  public function getHost()
  {
    return $this->host;
  }
    
  public function getDbName()
  {
    return $this->dbName;
  }
    
  public function getUsername()
  {
    return $this->username;
  }
    
  public function getPassword()
  {
    return $this->password;
  }
    

}