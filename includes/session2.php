<?php
session_start();
if(isset($_SESSION['username']) && isset($_SESSION['site']) && ($_SESSION['site']=="media_planning") && ($_SESSION['usertype']=="finance") || ($_SESSION['usertype']=="mexec"))  {

}else{
    header("location:../admin/login.php");
}
?>
