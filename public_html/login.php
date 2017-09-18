<?php
session_start();

require 'connect.php';
$title = 'Login - Fidget Express';

if($_SERVER["REQUEST_METHOD"] == "POST") {      // Not sure about this check

  // TODO: Use stripslashes and mysql_real_escape_string

  $username = $_POST['username'];
  $password = $_POST['password'];

  // TODO: Make safe, seems safe with mysqli?
  $sql = "SELECT * FROM Users WHERE username = '$username'";
  $result = $conn->query($sql);
  $rows = mysqli_num_rows($result);

  if($rows == 1 && verifyPassword($password, $result->fetch_array()['hash'])) {
    session_regenerate_id();
    $_SESSION['username'] = $username;
    $_SESSION['logged_in'] = TRUE;
    $_SESSION['shopping_cart'] = array();
    header("location: store.php");
  } else {
    $error = "Your Username and/or Password is invalid";
  }
}

function verifyPassword($password, $hash) {
  return password_verify($password, $hash);
}
?>
<html>
  <?php require('header.php') ?>

  <body>
    <h1>Login</h1>

    <div style="padding:2em">

       <form action="" method="POST">
          <label><b>Username:</b></label>
          <input type="text" name="username"/>
          <br /><br />
          <label><b>Password:</b></label>
          <input type="password" name="password"/>
          <br/><br />
          <button type="submit">Login</button>
       </form>

       <div style="font-size:0.8em; color:red">
         <?php if(isset($error)) echo $error; ?>
       </div>

    </div>
  </body>
</html>
