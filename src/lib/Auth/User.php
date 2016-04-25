<?php

namespace MyCodeLab\Auth;

use MyCodeLab\System\Object;
use MyCodeLab\Database\Connection as Database;
use MyCodeLab\Auth\Exceptions\RegistrationException;

class User extends Object
{  
  const TABLE = AUTH_USER_TABLE;
  
  /**
   * @var MyCodeLab\Database\Connection
   */
  protected $connection;
  
  /**
   * @var int
   */
  protected $id;
  
  /**
   * @var string
   */
  protected $username;

  /**
   * @var string
   */
  protected $password;

  public static function find($username)
  {
    $sql      = "SELECT id, username, password FROM " . static::TABLE . " WHERE username=:username";
    $params   = ['username' => $username];
    $command  = Database::forge()->sqlCommand();
    
    $result = $command->write($sql, $params)->execute();

    if(!$result->hasRows()) {
      return false;
    }

    $user = new self($result['username'], $result['password'], $result['id']);
    $user->isRegistered = true;
  }

  public function __construct($username = null, $password = null, $id = null)
  {
    $this->username = $username;
    $this->password = $password;
    $this->id       = $id;
  }
  
  public function isRegistered()
  {
    if (isset($this->id)) {
      return true;
    } else {
      return false;
    }
  }

  public function getUsername() 
  {
    return $this->username;
  }

  public function matchPassword($password)
  {
    if ($this->password === $password) {
      return true;
    } else {
      return false;
    }
  }

  /**
   * @todo Hashing algorithm and security
   */
  public function setPassword($password)
  {
    $this->password = $password;

    return $this;
  }
  
  public function save() 
  {
    $sql      = "INSERT INTO " . static::TABLE . " (username, password) VALUES (:username, :password)";
    $params   = ['username' => $this->username, 'password' => $this->password];
    $command  = $this->connection->sqlCommand();
    
    if ($this->isRegistered) {
      throw new RegistrationException("There is already a user $username registered");
    }

    $result = $command->write($sql, $params)->execute();
    
    if ($result->rowCount() < 1) {
      throw new RegistrationException("Error saving user to database");
    } 
    
    return true;
  }

}

?>
