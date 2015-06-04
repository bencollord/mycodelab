<?php
session_start();
include('db.inc.php');
$username = $_POST['username'];
$password = $_POST['password'];

$stmt = $dbConn->prepare("SELECT * FROM registeruserstbl WHERE username=:username");
$stmt->bindParam(':username', $username);
$stmt->execute();


//Query if there are matching rows equal to $username.
$exists         = $stmt->rowCount(); //check to see if the username exists
$table_users    = "";
$table_password = "";
if ($exists > 0) //IF there are no returning rows or no existing usernames...
    {
    while ($row = $stmt->fetch()) //display all rows from query
        {
        $table_users    = $row['username'];
        //the first username row is passed on to the 4table_users, and so on until the query is finished.
        $table_password = $row['password']; //the first password row is passed to the $table_password, and so on until the query is finished. 
    }
    if (($username == $table_users) && ($password == $table_password)) //checks if there are any matching fields.
        {
        if ($password == $table_password) {
            $_SESSION['user'] = $username; //set the username in a session. This serves as a global variable.
            header("location: home.users.html.php"); //redirects the user to the authenticated users home page. 
        }
    } else {
        echo '<script>alert("Incorrect Password!");</script>'; //Prompts user
        echo '<script>window.location.assign("login.form.html.php");</script>'; //redirect to login page
    }
} else {
    echo '<script>alert("Incorrect Username!");</script>'; //Prompts user
    echo '<script>window.location.assign("login.form.html.php);</script>'; //redirect to login page
}

?>