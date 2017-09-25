<?php

session_start();
require 'connect.php';
if($_SERVER["REQUEST_METHOD"] == "POST") {
  $name = $_POST['name'];
  $address = $_POST['address'];
  $username = $_POST['username'];
  $password = $_POST['password'];
  $checkflag = 0;

  if(check()) {
    // creting new hash for new user
    $hash = password_hash($password, PASSWORD_DEFAULT);
    //inserting user into db
    $sql = "INSERT INTO Users (name, address, username, hash)
    VALUES (?,?,?,?)";
    $statement=$conn->prepare($sql);
    $statement->bind_param("ssss", $name, $address, $username, $hash);
    $statement->execute();

    $_SESSION['username'] = $username;
    $_SESSION['logged_in'] = TRUE;
    header("location: store.php");

  }
}

function check() {
  $myfile = fopen("/home/hanna/Documents/EITF05/eitf05/blacklist.txt", "r") or die("Unable to open file!");
// Output one line until end-of-file
while(!feof($myfile)) {
  $line=fgets($myfile);
  if($line==$name) {
    $error="Invalid name entered";
    return FALSE;
  } else if($line==$address) {
    $error="Invalid address entered";
    return FALSE;
  }else if($line==$username) {
    $error="Invalid username entered";
    return FALSE;
  }else if($line==$password) {
    $error="Invalid password entered";
    return FALSE;
  }
}
fclose($myfile);
$flag=checkPassword();
return $flag;
}

function checkPassword() {
  //check length
  if(strlen($password)==0) {
    $error="Invalid password entered";
    return FALSE;
  }
  $passArr = str_split($password);
  $arr;
  //check for one digit, upper- and lowercase letter, special character
  foreach ($passArr as $value) {
    if(ctype_digit($value)){
      $arr[0]=1;
    } else if(ctype_lower($value)){
      $arr[1]=1;
    } else if(ctype_upper($value)){
      $arr[2]=1;
    } else if(preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $value)){
      $arr[3]=1;
    }
  }
  $arrSum=$arr[0]+$arr[1]+$arr[2]+$arr[3];
  if($arrSum!=4) {
    $error="Invalid password entered, missing either:\ndigit, uppercase letter,
    lowercase letter or specialcharacter";
    return FALSE;
  }
  //not the same password as name or username
  if($password==$name || $password==$username) {
    return FALSE;
  }
  return TRUE;
}

?>

<html>
  <div style="width: 500px; margin: 200px auto 0 auto;">
  <head><title>Register Page</title></head>

  <body>
    <h1>Register</h1>
    <h4> </h4>
    <div style="padding:2em">
       <form action="" method="POST">
          <label><b>Name:</b></label>
          <input type="text" name="name" maxlength="40"/>
          <input type="reset" value="Reset">
          <br /><br />
          <label><b>Address:</b></label>
          <input type="text" name="address" maxlength="40"/>
          <input type="reset" value="Reset">
          <br /><br />
          <label><b>Username:</b></label>
          <input type="text" name="username" maxlength="40"/>
          <input type="reset" value="Reset">
          <br/><br />
          <label><b>Password:</b></label>
          <input type="password" name="password" maxlength="50"/>
          <input type="reset" value="Reset">
          <br/><br />
          <button type="submit">Register</button>
       </form>

       <div style="font-size:0.8em; color:red">
         <?php if(isset($error)) echo $error; ?>
       </div>

    </div>
  </body>
  </div>
</html>
