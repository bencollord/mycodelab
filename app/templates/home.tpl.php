    <a href="login.form.html.php">Click here to login</a><br/>
    <a href="register.form.html.php">Click here to register</a>

    <h2 class="text-center">List</h2>
    <table width="100%" border="1px">
      <tr>
          <th>ID</th>
          <th>Details</th>
          <th>Post Time</th>
          <th>Edit Time</th>
      </tr>

      <?php foreach($this->posts as $post): ?>
        <tr>
          <td><?=$post['id']?></td>
          <td><?=$post['details']?></td>
          <td><?=$post['postDate'] . " - ". $post['postTime']?></td>
          <td><?=$post['editDate']. " - ". $post['editTime']?></td>
        </tr>
      <?php endforeach; ?>

    </table>
