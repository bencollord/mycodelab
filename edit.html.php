<!-- *** This page will most likely need to be entirely rewritten or split into two files *** -->

<!-- *** HTML STARTS HERE ***-->

<h2>Edit listtbl data</h2>

<p>Hello <?php echo $username; ?>!</p>
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
        if (isset($row)) {
            echo "<tr>";
            echo '<td align = "center">' . $row['id'] . "</td>";
            echo '<td align = "center">' . $row['details'] . "</td>";
            echo '<td align = "center">' . $row['date_posted'] . " - " . $row['time_posted'] . "</td>";
            echo '<td align = "center">' . $row['date_edited'] . " - " . $row['time_edited'] . "</td>";
            echo '<td align = "center">' . $row['public'] . "</td>";
            echo "</tr>";
        }
}
?>
</table>
<br/>
<?php
if (isset($row)) {
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
