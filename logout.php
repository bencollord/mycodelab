
<?php
$controller = new UserController();
$session = new SessionHandler();

$controller->logout();
$session->end();

header("location:index.php");
?>
