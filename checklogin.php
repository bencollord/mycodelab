<?php
session_start();
spl_autoload_register('Autoloader::load');

$username = $_POST['username'];
$password = $_POST['password'];

$currentUser = new User($username, $password);

//attempts login and returns "true" if successful
$loginCheck = $currentUser->login();
if($loginCheck) {
    $_SESSION['user'] = $currentUser->getUsername();
    header("location: home.users.html.php");
} else {
  echo '<script>alert("' . $currentUser->getErrorMsg(); . '");</script>';
  header("location: login.form.html.php");//redirect to login page
}

?>
