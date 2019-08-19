<?php
session_start();

// initializing variables
$username = "";
$email    = "";
$errors = array(); 

// connect to the database
include_once("../includes/dbconnect.php");
$db = mysqli_connect(HNAME,USER,PWD,DBNAME);


// LOGIN USER
if (isset($_POST['login_user'])) {
  $username = mysqli_real_escape_string($db, $_POST['username']);
  $password = mysqli_real_escape_string($db, $_POST['password']);
  // echo $username;
  // echo $password;

  if (empty($username)) {
    array_push($errors, "Username is required");
  }
  if (empty($password)) {
    array_push($errors, "Password is required");
  }

  if (count($errors) == 0) {
    $password = md5($password);
    $query = "SELECT * FROM tbl_user WHERE username='$username' and password='$password'";
    $results = mysqli_query($db, $query);
    $userdata=mysqli_fetch_assoc($results);
    $rows = mysqli_num_rows($results);  

    if($rows==1 && ($userdata['usertype']=='admin' || $userdata['usertype']=='finance' || $userdata['usertype']=='director' || $userdata['usertype']=='mexec')) {
      session_start();
      $_SESSION['username']=$username;
      $_SESSION['usertype']=$userdata['usertype'];
      $_SESSION['site']="media_planning";
      $_SESSION['logout']="logout";
      if($userdata['usertype']=='admin'){
        header("location:index.php");
      }
      elseif($userdata['usertype']=='finance'){
        header("location:../finance/index.php");
      }
      elseif($userdata['usertype']=='director'){
        header("location:admin/index.php");
      }
      elseif($userdata['usertype']=='mexec'){
        header("location:../mexec/index.php");
      }
    }
    else {
      array_push($errors, "Wrong username/password combination");
    }
  }
}

?>