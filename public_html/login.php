<?php
session_start();

require 'connect.php';

if($_SERVER["REQUEST_METHOD"] == "POST") {      // Not sure about this check

  // TODO: Use stripslashes and mysql_real_escape_string

  $username = $_POST['username'];
  $password = $_POST['password'];

  // TODO: Make safe
  $sql = "SELECT * FROM users WHERE name = '$username'";
  $result = $conn->query($sql);
  $rows = mysqli_num_rows($result);

  if($rows == 1) {
    session_regenerate_id();
    $_SESSION['username'] = $username;
    $_SESSION['logged_in'] = TRUE;
    header("location: store.php");
  } else {
    $error = "Your Login Name or Password is invalid";
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
