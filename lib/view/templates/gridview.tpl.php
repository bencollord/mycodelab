<table>
  <tr>
    <?php foreach($this->columns as $colHead): ?>
      <th><?=$colHead;?></th>
    <?php endforeach; ?>
  </tr>
  
  <?php foreach($this->rows as $row): ?>
    <tr></tr>
  <?php endforeach; ?>
</table>