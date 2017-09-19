<?php
session_start();

require 'connect.php';
$title = 'Login - Fidget Express';

if($_SERVER["REQUEST_METHOD"] == "POST") {

  $username = $_POST['username'];
  $password = $_POST['password'];

  // Prepared statement
  $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");

  // Bind $username param as a string
  $stmt->bind_param('s', $username);

  $stmt->execute();
  $result = $stmt->get_result();
  $stmt->close();

  $login_user = $result->fetch_assoc();

  if(password_verify($password, $login_user['hash'])) {
    session_regenerate_id();
    unset($login_user['hash']);

    $_SESSION['login_user'] = $login_user;
    $_SESSION['logged_in'] = TRUE;
    $_SESSION['shopping_cart'] = array();

    header("location: store.php");
  } else {
    $error = "Ditt användarnamn och/eller lösenord är felaktigt";
  }
}
?>
<html>
  <?php require('header.php') ?>

  <body>
    <h1>Logga in</h1>

    <form action="" method="POST">
      <label><b>Användarnamn:</b></label>
      <input type="text" name="username"/>
      <br /><br />
      <label><b>Lösenord:</b></label>
      <input type="password" name="password"/>
      <br/><br />
      <button type="submit">Logga in</button>
    </form>

    <div style="font-size:0.8em; color:red">
     <?php if(isset($error)) echo $error; ?>
    </div>
  </body>
</html>
