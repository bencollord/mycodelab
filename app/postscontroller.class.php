<?php

namespace App;

use Lib\Core\Object;

class PostsController extends Controller
{
  public function home() 
  {
    $page  = new HtmlDocument(TPL_PATH . 'document.tpl.php');
    $posts = Post::findPublic();
    $view  = new GridView($posts);
    
    $page->appendContent($view->render());
    $this->response->write($page->render())->send();
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
