<?php


class User {
    private $dbConn;
    private $username;
    private $password;
    private $loggedIn;
    private $errorMsg;

    public function __construct($username, $password) {
        include('db.inc.php');
        $this->dbConn = $dbConn;
        $this->username = $username;
        $this->password = $password;
        $this->loggedIn = false;
    }

    //checks to see if user is registered in database
    private function checkUsername() {
      $stmt = $this->dbConn->prepare("SELECT * FROM registeruserstbl WHERE username=:username");
      $stmt->bindParam(':username', $this->username);
      $stmt->execute();

      $resultSet = $stmt->fetchAll();

      if(empty($resultSet)) {
        return = false;
      } elseif(count($resultSet) == 1) {
        return = $resultSet[0];
      } else {
        throw new Exception("Number of users with username cannot be more than 1.");
      }
    }

    public function getUsername() {
      return $this->username;
    }

    public function getErrorMsg() {
      return $this->errorMsg;
    }

    public function checkIfLoggedIn() {
      return $this->loggedIn;
    }

    public function login() {
      $result = $this->checkUsername();
      if (!empty($result))
          {
            if (($this->username == $result['username']) && ($this->password == $result['password']))
                {
                   $this->loggedIn = true;
            } else {
                $this->errorMsg = "Incorrect password!";
            }
      } else {
          $this->errorMsg = "Username not found!";
      }
      return $this->loggedIn;
    }

    public function logout() {
        $this->loggedIn = false;
    }

    public function register() {
      try {
        $isRegistered = $this->checkUsername();
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
          $this->errorMsg = "Username is already taken!";
          return false;
      }
    }
}

?>
