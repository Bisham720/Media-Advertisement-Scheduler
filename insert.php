f<?php
include_once("includes/dbconnect.php");
$db = mysqli_connect(HNAME,USER,PWD,DBNAME);

// define variables and set to empty values
$nameErr = $cnameErr = $addressErr = $phoneErr = $emailErr = $panErr = "";
$name = $company_name = $address = $phone = $email = $pan = "";
$target_dir = $file_name = $target_file = $uploadOk = $imageFileType = "";



if ($_SERVER["REQUEST_METHOD"] == "POST") {
  
  if (empty($_POST["name"])) {
    $nameErr = "Name is required";
  } else {
    $name = test_input($_POST["name"]);
    // check if name only contains letters and whitespace
    if (!preg_match("/^[a-zA-Z ]*$/",$name)) {
      $nameErr = "Only letters and white space allowed"; 
    }
  }

  if (empty($_POST["c_name"])) {
    $cnameErr = "Company Name is required";
  } else {
    $company_name = test_input($_POST["c_name"]);
  }
  
  if (empty($_POST["address"])) {
    $addressErr = "Address is required";
  } else {
    $address = test_input($_POST["address"]);
  }

  if (empty($_POST["phone"])) {
    $phoneErr = "Phone number is required";
  } else {
    $phone = test_input($_POST["phone"]);
    // check if name only contains letters and whitespace
    if (!preg_match("/^[0-9]*$/",$phone)) {
      $phoneErr = "Not in phone format"; 
    }
  }

  if (empty($_POST["email"])) {
    $emailErr = "Email is required";
  } else {
    $email = test_input($_POST["email"]);
    // check if e-mail address is well-formed
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $emailErr = "Invalid email format"; 
    }
  }
   
  if (empty($_POST["pan"])) {
    $panErr = "Pan number is required";
  } else {
    $pan = test_input($_POST["pan"]);
  } 

  

  // file uploading
  $target_dir = "uploads/";
  $file_name = $_FILES["fileToUpload"]["name"];
  $concate_fname = $company_name."_".$file_name;
  $target_file = $target_dir . basename($concate_fname);
  $uploadOk = 1;
  $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));


  // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
        } 
    }

  if(!empty($_POST["name"]) && !empty($_POST["c_name"]) && !empty($_POST["address"]) && !empty($_POST["phone"]) && !empty($_POST["email"]) && !empty($_POST["pan"])){
    $sql = "INSERT INTO tbl_registration(u_fullname,u_companyname,u_address,u_phone,u_email,u_pan,u_imagename,u_status) VALUES('$name','$company_name','$address','$phone','$email','$pan','$concate_fname','pending')";
    if(mysqli_query($db,$sql))
    {
      header("location:status.php");       
    }
  }
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>