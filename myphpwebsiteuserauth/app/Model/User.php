<?php

namespace App\Model;

use Library\System\Object;
use Library\Database\SqlCommand;

/* ===================================================== *
 * Gets the password and password question.
 * Changes the password. 
 * Determines whether the user is online. 
 * Determines whether the user is validated. 
 * Returns the date for last activity, login, and password change. 
 * Unlocks a user. 
 * ===================================================== */
  
class User extends Object
{  
  const TABLE = USER_AUTH_TABLE;
  
  /**
   * @var string
   */
  protected $username;

  /**
   * @var string
   */
  protected $password;

  /**
   * @var bool This property provides no accessor and cannot be set in the 
   *           constructor. It is only set by the find() method on an existing
   *           record pulled from the database.
   */
  protected $isRegistered = false;

  public static function find($username)
  {
    $sql      = "SELECT * FROM " . static::TABLE . " WHERE username=:username";
    $params   = ['username' => $username];
    $command  = new SqlCommand();
    
    $result = $command->write($sql, $params)->executeQuery();

    if(!$result->hasRows()) {
      return false;
    }

    $user = new self($result['username'], $result['password']);
    $user->isRegistered = true;
  }

  public function __construct($username = null, $password = null)
  {
    $this->username = $username;
    $this->password = $password;
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
   * @todo Hashing algorithm
   */
  public function setPassword($password)
  {
    $this->password = $password;

    return $this;
  }
  
  public function register() 
  {
    $sql      = "INSERT INTO " . static::TABLE . " (username, password) VALUES (:username, :password)";
    $params   = ['username' => $this->username, 'password' => $this->password];
    $command  = new SqlCommand();
    
    if ($this->isRegistered) {
      throw new Exception("There is already a user $username registered");
    }

    $result = $command->write($sql, $params)->execute();
    
    if ($result->rowCount < 1) {
      throw new Exception("Error saving user to database");
    } 
    
    return true;
  }

}

?>
