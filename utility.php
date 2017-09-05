<?php

function debug($msg) {
  $msg = print_r($msg, true);
  echo "<script>console.log(".json_encode($msg).")</script>";
}

?>
