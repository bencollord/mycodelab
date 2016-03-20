<?php echo strftime("%Y %B %d"); ?>
<p>Hello <?php echo "$username"?>!</p> <!--displays user's name -->
<a href="users/logout">Click here to logout.</a>
<br/>
<form action="posts/add" method="POST">
    Add more to list: <input type="text" name="details"/><br/>
    Public post? <input type="checkbox" name="public" value="yes"/><br/>
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

    <?php foreach($rows as $row): ?>
      <tr>
        <td align = "center"><?=$row['id'];?></td>
        <td align = "center"><?=$row['details'];?></td>
        <td align = "center"><?=$row['date_posted']. " - ". $row['time_posted'];?></td>
        <td align = "center"><?=$row['date_edited']. " - ". $row['time_edited'];?></td>
        <td align = "center"><a href="posts/edit?id=<?=$row['id'];?>">edit</a></td>
        <td align = "center"><a href="#" onclick="myFunction(<?=$row['id'];?>)">delete</a></td>
        <td align = "center"><?=$row['public'];?></td>
      </tr>
    <?php endforeach; ?>

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
