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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $bool     = true;
    include('db.inc.php');
    $stmt = $dbConn->query("SELECT * FROM registeruserstbl");
    while ($row = $stmt->fetch()) //display all rows from the query.
        {
        $table_users = $row['username'];
        //the first username row is passed on to $table_users, and then so on until the query is finished.
        
        if ($username == $table_users) {
            $bool = false;
            //set the bool to false
            echo '<script>alert("Username has been taken!");</script>';
            //Prompt the user
            echo '<script>window.location.assign("register.form.html.php");</script>';
            //redirect
        }
        
    }
    
    
    if ($bool) //check if bool is true
        {
        $stmt = $dbConn->prepare("INSERT INTO registeruserstbl (username, password) VALUES (:username, :password)");
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $password);
        $stmt->execute();
        echo '<script>alert("Successfully Registered!");</script>';
        //Prompts the user
        echo '<script>window.location.assign("register.form.html.php");</script>';
        //redirects to register.form.html.php
    }
    
}
?>