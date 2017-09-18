<?php require 'connect.php' ?>
<?php require 'utility.php' ?>

<?php

function show_table($conn, $sql, $name) {
  $columns = $conn->query($sql);
  debug($sql);
  debug($columns);

  if($columns->num_rows) {
    echo '<table>';
    echo '<caption>' . $name . '</caption>';

    echo '<tr>';
    while ($field = $columns->fetch_field()) {
      echo '<th>' . $field->name . '</th>';
    }
    echo '</tr>';

    while($row = $columns->fetch_row()) {
      echo '<tr>';
      foreach ($row as $key => $value) {
        echo '<td>' . $value . '</td>';
      }
      echo '</tr>';
    }

    echo '</table>';
  } else {
    echo '<p>' . $name . ' is empty.</p>';
  }
}
?>

<html>
  <?php require_once('header.php'); ?>
  <body>
    <h1>Web Shop Under Attack</h1>
    <h3>Host: <?=$server?></h3>
    <h2>Tables</h2>
    <?php
      $tables = $conn->query('SHOW TABLES');
      debug($tables);
      while($table = $tables->fetch_row()[0]) {
        debug('TABLE: ' . $table);
        echo '<h3>' . $table . '</h3>';
        show_table($conn, 'SHOW COLUMNS from ' . $table, 'Description');
        echo '<br/>';
        show_table($conn, 'SELECT * from ' . $table, 'Data');
        echo '<br/>';
      }
    ?>
  </body>
</html>
