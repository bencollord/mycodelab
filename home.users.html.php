<!--Purpose: Home page for logged-in users. Users will be able to write, edit, delete, and view records to/from the database table listtbl. Users will be able to logout.
Associated Files: index.php, logout.php, add.php, edit.html.php, and a function called myFunction() used to delete records, then this will use delete.php -->
<!DOCTYPE html>


<?php
$title = "User Home Page";

    session_start(); //starts the session
    if($_SESSION['user']){
    }
        else {
            header("location:index.php"); //redirects if user is not logged in.
        }
        $user = $_SESSION['user']; //assigns user value
?>

<body>
<h2>User Home Page</h2>
<?php echo strftime("%Y %B %d"); ?>
<p>Hello <?php echo "$user"?>!</p> <!--displays user's name -->
<a href="logout.php">Click here to logout.</a><br/><br/>
<form action="add.php" method="POST">
    Add more to list: <input type="text" name="details"/><br/>
    Public post? <input type="checkbox" name="public[]" value="yes"/><br/>
    <input type="submit" value="Add to list"/>
</form>

<h2 align="center">My List</h2>
<table border="1px" width="100%">
    <tr>
        <th>ID</th>
        <th>Details</th>
        <th>Post Time</th>
        <th>Edit Time</th>
        <th>Edit</th>
        <th>Delete</th>
    </tr>
    
    <?php
    include('db.inc.php');
    
    $stmt = $dbConn->query("SELECT * FROM listtbl"); //SQL query
    while($row = $stmt->fetch()) {
        echo "<tr>";
        echo '<td align = "center">'.$row['id']."</td>";
        echo '<td align = "center">'.$row['details']."</td>";
        echo '<td align = "center">'.$row['date_posted']. " - ". $row['time_posted'] ."</td>";
        echo '<td align = "center">'.$row['date_edited']. " - ". $row['time_edited'] ."</td>";
        echo '<td align = "center"><a href="edit.html.php?id=' . $row['id'] . '">edit</a></td>';
        echo '<td align = "center"><a href="#" onclick="myFunction('.$row['id'].')">delete</a></td>';
        echo '<td align = "center">'.$row['public']."</td>";  
    }
    ?>
    
</table>
    <script>
        function myFunction(id){
            var r=confirm("Are you sure you want to delete this record?");
            if (r==true) {
                window.location.assign("delete.php?id=" + id);
                //code
            }
        }
    </script>

