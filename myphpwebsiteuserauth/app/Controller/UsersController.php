<?php

namespace App\Controller;

use Library\Auth\{Authentication, Result};

class UsersController extends Controller
{
  public function init(Authentication $auth)
  {
    $this->auth = $auth;
    
    $this->session->start();
  }

  public function login() 
  {
    $result = $this->auth->run();

    if ($this->auth->status == Result::SUCCESS) {
      $this->response->redirect('posts/users');
    }
    if ($this->auth->status == Result::FAIL_NOT_FOUND) {
      $this->session->write('flash', 'Incorrect username!');
    }
    if ($this->auth->status == Result::FAIL_INVALID) {
      $this->session->write('flash', 'Incorrect password!')
    }

    $this->response->redirect('posts/home');
  }

  public function logout() 
  {
    $this->auth->close();
    $this->response->redirect('posts/home');
  }

  public function register() 
  {
    
  }

}


