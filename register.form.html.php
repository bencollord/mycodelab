<!-- Purpose: register a user with a username and password. This will be data written to the database table containing registered users.
Associated files: index.php, register.form.html.php
name="username" and "password" must match database fields-->

<h2>Registration Page</h2>
<a href="index.php">Return to Home Page</a><br/><br/>
<form action="register.form.html.php" method="post">
    Enter Username: <input type="text" name="username" required="required"/><br/>
    Enter Password: <input type="password" name="password"        required="required" /><br/>
    <input type="submit" value="Register"/>
</form>

<?php

spl_autoload_register('Autoloader::load');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $newUser = new User($_POST['username'], $_POST['password']);

      //method returns "false" if username already taken
      $registration = $newUser->register();
      if($registration) {
        echo '<script>alert("Successfully Registered!");</script>';
        header("location: login.form.html.php");
      } else {
        echo '<script>alert("Username has been taken!");</script>';
        header("location: register.form.html.php");
      }
}
?>
