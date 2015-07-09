<!-- *** HTML STARTS HERE ***-->

<?php
session_start(); //starts the session
if ($_SESSION['user']) {
  $user = $_SESSION['user']; //assigns user value
  $id_exists = false;
} else {
    header("location:index.php"); //redirects if user is not logged in.
}

?>


<h2>Edit listtbl data</h2>

<p>Hello <?php echo $user; ?>!</p>
<a href="logout.php">Click here to logout.</a><br/><br/>
<a href="home.users.html.php">Return to user Home Page.</a>
<h2 align="center">Currently Selected Record</h2>
<table border="1px" width="100%">
    <tr>
        <th>ID</th>
        <th>Details</th>
        <th>Post Time</th>
        <th>Edit Time</th>
        <th>Public Post</th>
    </tr>

     <?php
if (!empty($_GET['id'])) {
    $id = $_GET['id'];
    $_SESSION['id'] = $id;
    $id_exists = true;

    include('db.inc.php');

    $stmt = $dbConn->prepare("SELECT * FROM listtbl WHERE id=:id"); //SQL query
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    $count = $stmt->rowCount();
    if ($count > 0) {

        while ($row = $stmt->fetch()) {
            echo "<tr>";
            echo '<td align = "center">' . $row['id'] . "</td>";
            echo '<td align = "center">' . $row['details'] . "</td>";
            echo '<td align = "center">' . $row['date_posted'] . " - " . $row['time_posted'] . "</td>";
            echo '<td align = "center">' . $row['date_edited'] . " - " . $row['time_edited'] . "</td>";
            echo '<td align = "center">' . $row['public'] . "</td>";
            echo "</tr>";
        }
    }

    else {
        $id_exists = false;
    }

}
?>
</table>
<br/>
<?php
if ($id_exists) {
    echo '
        <form action="edit.html.php" method="POST">
        Enter new detail: <input type="text" name="details"/><br/>
        Public post? <input type="checkbox" name="public[]" value="yes"/><br/>
        <input type="submit" value="Update list"/>
        </form>
        ';
} else {
    echo '<h2 align="center">There is no data to be edited.</h2>';
}
?>

<!-- ******* HTML ENDS HERE *********** -->

<?php

if ($_SERVER['REQUEST_METHOD'] == "POST") //Added and  "if" to keep the page secure.
    {

    spl_autoload_register('Autoloader::load')

    $details = $_POST['details']; //details is what the user enters.
    $public  = "no";
    $id      = $_SESSION['id'];

    foreach ($_POST['public'] as $list) //get the data from the checkbox
        {
        if ($list != null) { //checks if checkbox is checked
            $public = "yes"; //sets value
        }
    }

    $post = new Post();
    $post->edit($id, $details, $public);

    header("location:home.users.html.php");

}

?>
