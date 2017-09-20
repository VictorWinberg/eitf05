<?php
session_start();

require 'connect.php';
$title = 'Sign Up - Fidget Express';

if($_SERVER["REQUEST_METHOD"] == "POST") {
  $name = $_POST['name'];
  $address = $_POST['address'];
  $username = $_POST['username'];
  $password = $_POST['password'];
  // creting new hash for new user
  $hash = password_hash($password, PASSWORD_DEFAULT);
  //inserting user into db
  $sql = "INSERT INTO Users (name, address, username, password, hash)
  VALUES (:name, :address, :username, :password, :hash)";
  $statement=$conn->prepare($sql);
  $statement->execute(array(
    ':name' => $name,
    ':address' => $address,
    ':username' => $username,
    ':password' => $password,
    ':hash' => $hash
  ));

  $_SESSION['username'] = $username;
  $_SESSION['logged_in'] = TRUE;
  header("location: store.php");

}
?>

<html>
  <?php require('header.php') ?>

  <body>
    <form class="form" action="" method="POST">
      <h1>Sign Up</h1>

      <label><b>Name:</b></label>
      <input type="text" name="name"/>
      <br /><br />
      <label><b>Address:</b></label>
      <input type="text" name="address"/>
      <br /><br />
      <label><b>Username:</b></label>
      <input type="text" name="username"/>
      <br/><br />
      <label><b>Password:</b></label>
      <input type="password" name="password"/>
      <br/><br />
      <button class="btn" style="width: 250" type="submit">Sign Up</button>
    </form>

  <div style="font-size:0.8em; color:red">
    <?php if(isset($error)) echo $error; ?>
  </div>

  </body>
</html>
