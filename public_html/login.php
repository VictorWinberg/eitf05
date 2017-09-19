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
    <form class="form" action="" method="POST">
      <h1>Login</h1>

      <input type="text" name="username" placeholder="username">
      <br/><br/>
      <input type="password" name="password" placeholder="password">
      <br/><br/>
      <button class="btn" style="width: 250" type="submit">login</button>
      <p style="font-size: 0.8em; color: DarkSlateGray">
        Don't have an account? <a href="register.php">Sign Up</a>
      </p>
      <p class="small" style="font-size: 0.8em; color:red">
       <?php if(isset($error)) echo $error; ?>
      </p>
    </form>
  </body>
</html>
