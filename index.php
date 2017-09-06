<?php
include 'env.php';
require 'utility.php';

$mysqli = new mysqli(
  getenv("HOST"),
  getenv("USER"),
  getenv("PASSWORD"),
  getenv("DB")
);
?>

<html>
  <head>
    <title>W3bShopAtt4ckzz</title>
  </head>
  <body>
    <?php
    echo '<h1>Web Shop Under Attack</h1>';

    echo '<h3>Host: ' . getenv("HOST") . '</h3>';

    $tables = $mysqli->query("SHOW TABLES");
    debug($tables);
    while($tableName = mysqli_fetch_row($tables)) {
      $table = $tableName[0];
      debug($table);
      echo '<h3>' . $table . '</h3>';

      $columns = $mysqli->query("SHOW COLUMNS from " . $table);
      debug($columns);

      if(mysqli_num_rows($columns)) {
        echo '<table>';
        echo '<tr><th>Field</th><th>Type</th><th>Null</th>';
        while($row = mysqli_fetch_row($columns)) {
          echo '<tr>';

          foreach ($row as $key => $value) {
            echo '<td>' . $value . '</td>';
          }

          echo '</tr>';
        }
        echo '</table><br />';
      }
    }
    ?>
  </body>
</html>
