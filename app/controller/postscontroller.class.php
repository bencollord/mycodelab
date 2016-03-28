<?php

namespace App\Controller;

use Lib\Core\Controller;
use Lib\View\{View, Page};

class PostsController extends Controller
{
  public function init()
  {
    $this->page->addChild('header', 'global/header');
    $this->page->addChild('footer', 'global/footer');
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

  public function edit()
  {

  }

  public function delete($id) 
  {

  }

}
