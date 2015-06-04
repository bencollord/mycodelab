
    <h1>Home Page</h1>
    <a href="login.form.html.php">Click here to login</a><br/>
    <a href="register.form.html.php">Click here to register</a>

<h2 align="center">List</h2>
<table width="100%" border="1px">
       <tr>
        <th>ID</th>
        <th>Details</th>
        <th>Post Time</th>
        <th>Edit Time</th>
    </tr>
       <?php
    
    $query = $dbConn->query("SELECT * FROM listtbl WHERE public='yes'"); //SQL query
    
    while($row = $query->fetch()) {
        echo "<tr>";
        echo '<td>'.$row['id']."</td>";
        echo '<td>'.$row['details']."</td>";
        echo '<td>'.$row['date_posted']. " - ". $row['time_posted'] ."</td>";
        echo '<td>'.$row['date_edited']. " - ". $row['time_edited'] ."</td>";
        echo "</tr>";
        }
        ?>
</table>

