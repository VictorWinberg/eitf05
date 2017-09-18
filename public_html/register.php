<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
require 'connect.php';
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
  <head><title>Register Page</title></head>

  <body>
    <h1>Register</h1>

    <div style="padding:2em">
       <form action="" method="POST">
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
          <button type="submit">Register</button>
       </form>

       <div style="font-size:0.8em; color:red">
         <?php if(isset($error)) echo $error; ?>
       </div>

    </div>
  </body>
</html>
