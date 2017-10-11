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
    // if username exist execute is true
    if($stmt->execute()) {

      $result = $stmt->get_result();
      $stmt->close();

      $login_user = $result->fetch_assoc();
      $username = $login_user['username'];
      $attempts = $login_user['attempts'];
      $date = $login_user['attemptTime'];
      if($date!=NULL) {
        date_default_timezone_set("GMT");
        $milliToday=getdate()[0];
        $milliPast = strtotime($date);
        $dif=$milliToday-$milliPast;
        if($dif<1800) {
          //still less than an hour
          $error="Your account is locked, try again at a later time (max 30 min)";
        } else {
          //an hour has passed
          $statement = $conn->prepare("UPDATE Users SET attemptTime=NULL WHERE username = ?");
          $statement->bind_param("s", $username);
          $statement->execute();
          $statement->close();
          $date=NULL;
        }
      }

      // check if user has tried more than 5 times and if days is null
      if ($attempts<5 && $date==NULL) {
        //password for user was correct
        if(password_verify($password, $login_user['hash'])) {
          session_regenerate_id();
          unset($login_user['hash']);
          $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
          $_SESSION['login_user'] = $login_user;
          $_SESSION['logged_in'] = TRUE;
          $_SESSION['shopping_cart'] = array();

          $statement = $conn->prepare("UPDATE Users SET attempts=0 WHERE username = ?");
          $statement->bind_param("s", $username);
          $statement->execute();
          $statement->close();
          header("location: store.php");
        //password for user was incorrect
        } else {
          //increase attempts in db
          $attempts = $attempts + 1;
          $statement = $conn->prepare("UPDATE Users SET attempts=? WHERE username = ?");
          $statement->bind_param("is", $attempts, $username);
          $statement->execute();
          $statement->close();
          $error = "The username or password inserted is incorrect, attempt: ".$attempts;
        }
      //user has tried more than 5 times, set attempts to zero but timestamp=now()
    } else {
        if($date==NULL) {
          //set attempts to zero
          $statement = $conn->prepare("UPDATE Users SET attempts=0 WHERE username = ?");
          $statement->bind_param("s", $username);
          $statement->execute();
          //set attemptTime=now()
          $statement = $conn->prepare("UPDATE Users SET attemptTime=now() WHERE username = ?");
          $statement->bind_param("s", $username);
          $statement->execute();
          $statement->close();

          $error = "Too many tries, your account has been locked for an hour";
        }
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
