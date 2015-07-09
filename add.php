<?php
    session_start();
    spl_autoload_register('Autoloader::load');

    if($_SESSION['user']) {}
    else {
        header("location:index.php");
    }
    if($_SERVER['REQUEST_METHOD'] == "POST") //Added and  "if" to keep the page secure.
    {
        $details = $_POST['details']; //details is what the user enters.
        $decision = "no"; //is the post public

    foreach($_POST['public'] as $each_check) //don't know why a foreach loop was used here. Check this later
    {
        if($each_check !=null) { //checks if checkbox is checked
            $decision = "yes"; //sets value
        }
    }
        $newPost = new Post();
        $newPost->add($details, $decision);
        header("location:home.users.html.php");

    }
    else{
        header("location:home.users.html.php");
    }
?>
