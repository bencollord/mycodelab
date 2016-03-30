<?php

namespace App\Model;

use Lib\System\Object;
use Lib\Database\SqlCommand;

class User extends Object
{  
  protected $id;
  protected $username;
  protected $password;
  protected $loggedIn;

  
  public static function find($username)
  {
    $result = (new SqlCommand())->write(
      "SELECT * FROM registeruserstbl WHERE username=:username",
      ['username' => $username]
    )->executeQuery();

    if(empty($resultSet)) {
      return false;
    }
    
    return new self($result['id'], $result['username'], $result['password']);
  }

  public function __construct($id = null, $username = null, $password = null)
  {
    $this->id       = $id;
    $this->username = $username;
    $this->password = $password;
  }
  
  public function getUsername() 
  {
    return $this->username;
  }

  public function login() 
  {
    
  }
  
  public function logout() 
  {
    
  }

  public function register() 
  {
    try {
      $isRegistered = $this->userExists();
    }
    catch (Exception $e){
      echo "A fatal error has occurred. Please contact your system administrator" . $e->getMessage();
    }
    if (empty($isRegistered))
    {
      $stmt = $dbConn->prepare("INSERT INTO registeruserstbl (username, password) VALUES (:username, :password)");
      $stmt->bindParam(':username', $this->username);
      $stmt->bindParam(':password', $this->password);
      $stmt->execute();
      return true;
    } else  {
      $this->message = "Username is already taken!";
      return false;
    }
  }
}

?>
