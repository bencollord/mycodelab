<?php
  class PostsController {
    
    //@todo: add getters and setters for view and service/viewmodel. consider removing the view and putting it in bootstrap.php
    
    public function home() {
      $view = new View('Public Posts', 'home.html.php');
    }

    public function add($details, $isPublic) {
      $newPost = new Post();
      $newPost->add($details, $isPublic);
    }

    public function edit($id, $details, $isPublic) {
      $post = new Post($id);
      $post->edit($details, $public);
    }
    
    public function delete($id) {
      $post = new Post($id);
      $post->delete();
  }
    
}
