<?php
session_start();
if (!isset($_SESSION['csrf_token'])) {
  $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

require 'connect.php';
$title = 'Sign Up - Fidget Express';

if($_SERVER["REQUEST_METHOD"] == "POST") {
  $name = htmlspecialchars($_POST['name'], ENT_QUOTES);
  $address = htmlspecialchars($_POST['address'], ENT_QUOTES);
  $username = htmlspecialchars($_POST['username'], ENT_QUOTES);
  $password = htmlspecialchars($_POST['password'], ENT_QUOTES);

  if(check($name, $address, $username, $password, $error)&&
    checkLength($name, $address, $username, $password, $error)&&
    checkPassword($password, $name, $username, $error)) {
    // creating new hash for new user
    $hash = password_hash($password, PASSWORD_DEFAULT);
    //inserting user into db
    $sql = "INSERT INTO Users (name, address, username, hash)
    VALUES (?,?,?,?)";
    if($statement=$conn->prepare($sql)) {
      $statement->bind_param("ssss", $name, $address, $username, $hash);
      if($statement->execute()) {
        //get $login_user from the database
        if($statement = $conn->prepare("SELECT * FROM users WHERE username = ?")) {
          $statement->bind_param('s', $username);
          if($statement->execute()) {
            $result = $statement->get_result();
            $statement->close();
            $login_user = $result->fetch_assoc();
            //set SESSION user and that its signed in
            $_SESSION['login_user'] = $login_user;
            $_SESSION['logged_in'] = TRUE;
            $_SESSION['shopping_cart'] = array();
            // set sessionID and csrf token
            session_regenerate_id();
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
            header("location: store.php");
          } else {
            $error="unable to execute mysqli query";
          }
        } else {
          $error="unable to prepare mysqli query";
        }
      } else {
        $error="Username already exists";
      }
    } else {
      $error="unable to prepare mysqli query";
    }

  }
}
//Compare all input to blacklist.txt
function check($name, $address, $username, $password, &$error) {
  //opens blacklist file, only allowed to read
  $myfile = fopen("../blacklist.txt", "r")
  or die("Unable to open file!");
  // Output one line until end-of-file
  while(!feof($myfile)) {
    $line=fgets($myfile);
    $line=trim($line);

    if(strlen($line) != 0) {
      if($line == $password) {
        $error = "Password is unsafe and not allowed.";
        return FALSE;
      }
    }
  }
  fclose($myfile);
  return TRUE;
}
//Check the length of name, address, username and password
function checkLength($name, $address, $username, $password, &$error) {
  //Check if password is longer than eight characters and all others is not empty
  $errors = array();
  if(strlen(trim($password))<8)
    array_push($errors, "Length of password must be greater or equal to 8. Password");
  if(strlen(trim($name))==0)
    array_push($errors, "Name");
  if(strlen(trim($address))==0)
    array_push($errors, "Adress");
  if(strlen(trim($username))==0)
    array_push($errors, "Username");

  if (sizeof($errors) > 0) {
    $error = join(', ', $errors) . " are required and should not be empty.";
    return FALSE;
  }
  return TRUE;
 }
//Check that password contains one digit, one upper- and lowercase letter
//and a special character
function checkPassword($password, $name, $username, &$error) {
  $passArr = str_split($password);
  $arr=array(0,0,0,0);
  foreach ($passArr as $value) {
    if(ctype_digit($value)){
      $arr[0]=1;
    } else if(ctype_lower($value)){
      $arr[1]=1;
    } else if(ctype_upper($value)){
      $arr[2]=1;
    } else if(preg_match('/[\'^£$%&*()}{@#~?!"¤%€><>,|=_+¬-]/', $value)){
      $arr[3]=1;
    }
  }
  $arrSum=$arr[0]+$arr[1]+$arr[2]+$arr[3];
  if($arrSum!=4) {
    $error="Invalid password entered, missing either:\ndigit, uppercase letter,
    lowercase letter or specialcharacter";
    return FALSE;
  }
  //Check that the password does not contain the name or username
  if(strpos($password, $name)!==FALSE||strpos($password, $username)!==FALSE) {
    $error="Invalid password entered:\n
    Name or Username shall not be included in password";
    return FALSE;
  }
  return TRUE;
}
?>

<html>
  <?php require('header.php') ?>

  <body>
    <form class="form" action="" method="POST">
      <h3>Ready to Spin and Drink Some Milk?</h3>
      <h1>Sign Up!</h1>

      <input type="text" name="name" placeholder="name" maxlength="40"/>
      <br /><br />
      <input type="text" name="address" placeholder="address" maxlength="40"/>
      <br /><br />
      <input type="text" name="username" placeholder="username" maxlength="40"/>
      <br/><br />
      <i><span style="font-size: 11px;"> Password must be equal or longer than 8 characters and must include: 0-9, a-z, A-Z and a special character.</span></i>
      <br/><br />
      <input type="password" name="password" placeholder="password" maxlength="50"/>
      <br/><br />
      <button class="btn" style="width: 250" type="submit">sign up</button>

      <p style="font-size: 0.8em; color: DarkSlateGray">
        Already have an account? <a href="index.php">Login</a>
      </p>
      <p style="font-size: 0.8em; color:red">
        <?php if(isset($error)) echo $error; ?>
      </p>
      <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
    </form>
  </body>
</html>
