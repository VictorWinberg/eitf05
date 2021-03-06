<?php
function connect() {
  include '../env.php';
  $url = parse_url(getenv('DATABASE_URL'));

  $server = $url['host'];
  $username = $url['user'];
  $password = $url['pass'];
  $db = substr($url['path'], 1);

  $conn = new mysqli($server, $username, $password, $db);
  $conn->set_charset('utf8');
  return $conn;
}

$conn = connect();
?>
