<?php

namespace App;

use Lib\Core\Object;

class UsersController extends Controller
{
  private $currentUser;

  public function login($username, $password) 
  {
    $this->currentUser = new User($username, $password);
    //attempts login and returns "true" if successful
    $loginCheck = $this->currentUser->authenticate();
    if($loginCheck) {
      return $this->currentUser;
    } else {
      return false;
    }
  }

  public function logout() 
  {
    $this->currentUser = NULL;
    //@todo: terminate session and redirect to homepage
  }

  public function register($username, $password) 
  {
    $newUser = new User($username, $password);
    //method returns "false" if username already taken
    $registration = $newUser->register();
    if($registration) {
      $this->currentUser = $newUser;
      return $this->currentUser;
    } else {
      return false;
    }
  }

}


