<?php 
  require '../phpmailer/PHPMailerAutoload.php';
  require '../phpmailer/credential.php';
  include_once("../includes/dbconnect.php");
  $db = mysqli_connect(HNAME,USER,PWD,DBNAME);

  session_start(); 

  if (!isset($_SESSION['username'])) {
  	$_SESSION['msg'] = "You must log in first";
  	header('location: login.php');
  }

  if(isset($_POST['approve'])){

    $id = $_POST['userid'];
    $status = $_POST['status'];
    $email = $_POST['email'];
    $pw = md5('admin');
    $name = $_POST['name'];
    $cname = $_POST['companyname'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];

    $update = "UPDATE `tbl_registration` SET u_status= 'approved' WHERE u_id = '$id'";
    $update_res = executequery($update);
    if($update_res){

      $mail = new PHPMailer;

      // $mail->SMTPDebug = 4;

      $mail->isSMTP();

      $mail->Host = 'smtp.elasticemail.com';

      $mail->SMTPAuth = true;

      $mail->Username = EMAIL;
      $mail->Password = PASS;
      $mail->SMTPSecure = 'tls';

      $mail->Port= 2525;

      $mail->setFrom(EMAIL,'G4 Company');
      $mail->addAddress($email);

      $mail->addReplyTo(EMAIL);
      
      $mail->isHTML(true);
      $mail->Subject = "Your Request Has Been Accepted";
      $mail->Body = "<h2>Welcome,</h2>
                        <p>We have verified the PAN Card</p>
                        <b>username</b>: <i>admin</i> <br>
                        <b>password</b>: <i>admin</i>
                        <p>Thank you for your patience.</p>
                        <p>See your details. If there are any mistakes please contact us,</p>
                        <b>Name</b>:{$name}<br>
                        <b>Company Name</b>:{$cname}<br>
                        <b>Address</b>:{$address}<br>
                        <b>Phone</b>:{$phone}<br>
                        <p>Regards,</p>
                        <p><b>G4 Company</b></p>";

      if(!$mail->send()){
        echo "Message could not be sent. <br>"; 
        echo "Mailer Error:" . $mail->ErrorInfo;
      }else{
        $insert = "insert into tbl_user (username,password,usertype) values ('admin','$pw','admin')";
        $insert_res = executequery($insert);
        if($insert_res){ 
          header('location:index.php');
        }
      }
    }
  }

  if(isset($_POST['reject'])){

      $id = $_POST['userid'];
      $email = $_POST['email'];
      $delete = "DELETE FROM tbl_registration WHERE u_id='$id'";
      $delete_res = executequery($delete);
      if($delete_res){ 
        header('location:index.php');
      }
    }


?>


