<?php

namespace App\Model;

use Lib\System\Object;

class User extends Object
{  
  protected $id;
  protected $username;
  protected $password;
  protected $isLoggedIn;
  protected $gateway;

  public function __construct($username, $password)
  {
    $this->gateway  = new UserDataGateway();
    $this->username = $username;
    $this->password = $password;
  }

  //checks to see if user is registered in database
  private function userExists()
  {
    $stmt = $this->dbConn->prepare("SELECT * FROM registeruserstbl WHERE username=:username");
    $stmt->bindParam(':username', $this->username);
    $stmt->execute();

    $resultSet = $stmt->fetchAll();

    if(empty($resultSet)) {
      return false;
    } elseif(count($resultSet) == 1) {
      return $resultSet[0];
    } else {
      throw new Exception("Number of users with username cannot be more than 1.");
    }
  }

  public function getUsername() 
  {
    return $this->username;
  }

  public function authenticate() 
  {
    $result = $this->userExists();
    if (!empty($result))
    {
      if (($this->username == $result['username']) && ($this->password == $result['password']))
      {
        return true;
      } else {
        $this->message = "Incorrect password!";
        return false;
      }
    } else {
      $this->message = "Username not found!";
      return false;
    }
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
