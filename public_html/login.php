<?php
session_start();

require 'connect.php';

if($_SERVER["REQUEST_METHOD"] == "POST") {

  $username = $_POST['username'];
  $password = $_POST['password'];

  // Prepared statement
  $stmt = $conn->prepare("SELECT hash FROM users WHERE username = ?");

  // Bind $username param as a string
  $stmt->bind_param('s', $username);

  $stmt->execute();

  // Get the hash variable from the query.
  $stmt->bind_result($hash);

  // Fetch data and close statement
  $stmt->fetch();
  $stmt->close();

  if(password_verify($password, $hash)) {
    session_regenerate_id();
    $_SESSION['username'] = $username;
    $_SESSION['logged_in'] = TRUE;
    $_SESSION['shopping_cart'] = array();
    header("location: store.php");
  } else {
    $error = "Your Username and/or Password is invalid";
  }
}
?>
<html>
  <head><title>Login Page</title></head>

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
