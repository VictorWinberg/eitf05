<?php
session_start();
require 'connect.php';
if($_SERVER["REQUEST_METHOD"] == "POST") {
  $name = $_POST['name'];
  $address = $_POST['address'];
  $username = $_POST['username'];
  $password = $_POST['password'];

  $hash = password_hash($password);

  $sql = "INSERT INTO Users (name, address, username, password, hash)
  VALUES ($name, $address, $username, $password, $hash)";
  $conn->query($sql);
  
  $_SESSION['username'] = $username;
  $_SESSION['logged_in'] = TRUE;
  header("location: store.php");

}
?>

<html>
  <head><title>Register Page</title></head>

  <body>
    <h1>Register</h1>

    <div style="padding:2em">

       <form action="" method="POST">
          <label><b>Name:</b></label>
          <input type="text" name="name"/>
          <br /><br />
          <label><b>Address:</b></label>
          <input type="text" address="address"/>
          <br /><br />
          <label><b>Username:</b></label>
          <input type="text" username="username"/>
          <br/><br />
          <label><b>Password:</b></label>
          <input type="password" password="password"/>
          <br/><br />
          <button type="submit">Register</button>
       </form>

       <div style="font-size:0.8em; color:red">
         <?php if(isset($error)) echo $error; ?>
       </div>

    </div>
  </body>
</html>
