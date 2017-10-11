<?php
session_start();

require 'connect.php';
$title = 'Login - Fidget Express';

if($_SERVER["REQUEST_METHOD"] == "POST") {

  $username = htmlspecialchars($_POST['username']);
  $password = htmlspecialchars($_POST['password']);
  // Prepared statement
  if($stmt = $conn->prepare("SELECT * FROM users WHERE username = ?")) {

    // Bind $username param as a string
    $stmt->bind_param('s', $username);

    if($stmt->execute()) {

      $result = $stmt->get_result();
      $stmt->close();

      $login_user = $result->fetch_assoc();
      $username = $_SESSION['login_user']['username'];
      $attempts = $_SESSION['login_user']['attempts'];
      $days = $_SESSION['login_user']['attemptTime'];
      if($days!=NULL) {
        $now=time();
        echo $now;
        //$time_array=preg_split("/:/", $now);
      }
      if ($attempts<5 && $days==NULL) {
        if(password_verify($password, $login_user['hash'])) {
          session_regenerate_id();
          unset($login_user['hash']);
          $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
          $_SESSION['login_user'] = $login_user;
          $_SESSION['logged_in'] = TRUE;
          $_SESSION['shopping_cart'] = array();
          header("location: store.php");
        } else {
          $attempts = $attempts + 1;
          $statement = $conn->prepare("UPDATE Users SET attempts=? WHERE username =?");
          $statement->bind_param("is", $attempts, $username);
          $statement->execute();
          $error = "Ditt användarnamn och/eller lösenord är felaktigt";
        }
      } else {
        $statement = $conn->prepare("UPDATE Users SET attempts=0 WHERE username =?");
        $statement->execute();
        $statement = $conn->prepare("UPDATE Users SET attemptTime=now() WHERE username =?");
        $statement->close();
        $error = "Too many tries, your account has been locked for an hour"
      }
    }
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
        Don't have an account? <a href="sign-up.php">Sign Up</a>
      </p>
      <p class="small" style="font-size: 0.8em; color:red">
       <?php if(isset($error)) echo $error; ?>
      </p>
    </form>
  </body>
</html>
