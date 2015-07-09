<?php
session_start(); //starts the session
if ($_SESSION['user']) {
} //checks if user is logged in
else {
    header("location:index.php"); //redirects if user is not logged in
}
if ($_SERVER['REQUEST_METHOD'] == "GET") //Added and  "if" to keep the page secure.
    {
    spl_autoload_register('Autoloader::load')
    $post = new Post();
    $post->delete($_GET['id']);

    header("location:home.users.html.php");
}
?>
