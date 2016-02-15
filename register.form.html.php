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
