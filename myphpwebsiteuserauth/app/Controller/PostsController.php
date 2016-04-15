<?php

namespace App\Controller;

use Library\Foundation\Controller;
use Library\View\{View, Page};

class PostsController extends Controller
{
  public function init(Authentication $auth)
  {
    $this->session->start();
  }

  public function home() 
  {
    $posts = Post::loadAll('public');
    $view  = new View('posts/home');

    $view->set('posts', $posts)
         ->set('page',  $this->page);

  }

  public function add() 
  {

  }

  public function edit($id)
  {

  }

  public function delete($id) 
  {

  }

}
