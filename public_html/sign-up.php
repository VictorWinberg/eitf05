<?php

session_start();
require 'connect.php';
if($_SERVER["REQUEST_METHOD"] == "POST") {
  $name = $_POST['name'];
  $address = $_POST['address'];
  $username = $_POST['username'];
  $password = $_POST['password'];
  $error="";

  if(check($name, $address, $username, $password, $error)&&
  checkLength($name, $address, $username, $password, $error)&&
  checkPassword($password, $error)) {
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

function check($name, $address, $username, $password, &$error) {
  $myfile = fopen("/home/hanna/Documents/EITF05/eitf05/blacklist.txt", "r")
  or die("Unable to open file!");
  // Output one line until end-of-file
  while(!feof($myfile)) {
    $line=fgets($myfile);
    $line=trim($line);
    if(strlen($line)!=0) {
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
  }
  fclose($myfile);
  return TRUE;
}

function checkLength($name, $address, $username, $password, &$error) {
  $n=trim($name);
  $a=trim($address);
  $u=trim($username);
  $p=trim($password);
  // check for space in all and length in password
  if(strlen($n)==0) {
    $error="Invalid length of name entered";
    return FALSE;
  }else if(strlen($a)==0) {
    $error="Invalid length of address entered";
    return FALSE;
  }else if(strlen($u)==0) {
    $error="Invalid length of username entered";
    return FALSE;
  } else if(strlen($p)<8) {
    $error="Invalid length of password entered";
    return FALSE;
  }
  return TRUE;
 }

function checkPassword($password, &$error) {
  $passArr = str_split($password);
  $arr=array(0,0,0,0);
  //check for one digit, upper- and lowercase letter, special character
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
  //not the same password as name or username
  if(!strpos($password, $name)||!strpos($password, $username)) {
    $error="Invalid password entered:\n
    Name or Username shall not be included in password";
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
       <form  method="POST">
          <label><b>Name:</b></label>
          <input type="text" name="name" maxlength="40"/>
          <br /><br />
          <label><b>Address:</b></label>
          <input type="text" name="address" maxlength="40"/>
          <br /><br />
          <label><b>Username:</b></label>
          <input type="text" name="username" maxlength="40"/>
          <br/><br />
          <label><b>Password:</b></label>
          <input type="password" name="password" maxlength="50"/>
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
