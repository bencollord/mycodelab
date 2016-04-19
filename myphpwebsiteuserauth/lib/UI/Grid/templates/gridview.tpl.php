<h2>
  <?= $this->title; ?>
</h2>

<table>
  <tr>
    <?php foreach ($this->columns as $column): ?>
      <th><?= $column->heading; ?></th>
    <?php endforeach; ?>
  </tr>
  
  <?php foreach ($this->rows as $row): ?>
    <tr>
      <?php foreach ($this->columns as $column): ?>
        <?= $row[$column->binding]; ?>
      <?php endforeach; ?> 
    </tr>
  <?php endforeach; ?>
</table>