<?php
    $session = new SessionHandler();
    $controller = new PostController();
    
    $session->start();

    if(!$session->isSigned()) {
      header("location:index.php");
    }

    $controller->add();
?>
