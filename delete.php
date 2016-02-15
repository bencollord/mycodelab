<?php
$session = new SessionHandler();
$session->start();

if(!$session->isSigned()) {
    header("location:index.php");
}
$controller = new PostController();
$controller->delete();
?>
