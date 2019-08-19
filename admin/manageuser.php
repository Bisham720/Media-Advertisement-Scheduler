<?php 
include_once("../includes/session.php");
include_once("../includes/dbconnect.php"); 
$sql = "select * from tbl_user";
$userres = executequery($sql);

//add user
if(isset($_POST['submit'])) {
	$username = $_POST['username'];
	$password= md5($_POST['password']);
	$usertype = $_POST['usertype'];
	$sql = "insert into tbl_user (user_id,username,password,usertype) values ('','$username','$password','$usertype')";
	$res = executequery($sql);
	if($res) 
		header("location:manageuser.php?msg=User successfully added");
	else
		header("location:manageuser.php?msg=User information could not be added");
}

//update user
if(isset($_POST['update'])) {
	$user_id = $_POST['user_id'];
	$username = $_POST['username'];
	$usertype = $_POST['usertype'];

	$sql = "update tbl_user set username = '$username',usertype='$usertype' where user_id='$user_id'";
	$res = executequery($sql);
	if($res) 
		header("location:manageuser.php?msg=User updated successfully");
	else
		header("location:manageuser.php?msg=User information could not be updated");
}

//delete user
if(isset($_GET['action']) && $_GET['action']=='delete') {
	$id = $_GET['id'];
	$sql = "delete from tbl_user where user_id='$id'";
	$res = executequery($sql);
	if($res) 
		header("location:manageuser.php?msg=User deleted successfully");
	else
		header("location:manageuser.php?msg=User's information could not be deleted");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Media Planning System</title>

<!-- Bootstrap core CSS -->
<link href="assets/css/bootstrap.css" rel="stylesheet">
<!--external css-->
<link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />

<!-- Custom styles for this template -->
<link href="assets/css/style.css" rel="stylesheet">
<link href="assets/css/style-responsive.css" rel="stylesheet">
<link href="assets/css/table-responsive.css" rel="stylesheet">
<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    
            
</head>

<body>
<section id="container" > 
  <!-- **********************************************************************************************************************************************************
      TOP BAR CONTENT & NOTIFICATIONS
      *********************************************************************************************************************************************************** --> 
  <!--header start-->
  <?php  include("../includes/header.php");?>
  <!--header end--> 
  
  <!-- **********************************************************************************************************************************************************
      MAIN SIDEBAR MENU
      *********************************************************************************************************************************************************** --> 
  <!--sidebar start-->
  <?php include("sidebar.php");?>
  <!--sidebar end--> 
  
  <!-- **********************************************************************************************************************************************************
      MAIN CONTENT
      *********************************************************************************************************************************************************** --> 
  <!--main content start-->
  <section id="main-content">
    <section class="wrapper">
      <h3><i class="fa fa-angle-right"></i> User Information</h3>
      <?php
	  if(isset($_GET['msg'])) {
	  ?>
      <p class="alert-warning"><?php echo $_GET['msg'];?></p>
	  <?php 
	  }//end of isset
	  

    //view user
		if(isset($_GET['action']) && $_GET['action']=="edit") { 
		$user_id = $_GET['id'];
		$sql = "select * from tbl_user where user_id='$user_id'";
		$res = executequery($sql);
		$udata = mysqli_fetch_assoc($res);
		?>
      <div class="row mt">
        <div class="col-lg-12">
          <div class="form-panel">
            <h4 class="mb"><i class="fa fa-angle-right"></i> Edit User Details</h4>
            <form class="form-horizontal style-form" method="post" action="manageuser.php">
              <input type="hidden" name="user_id" value="<?php echo $user_id;?>">
              <div class="form-group">
                <label class="col-sm-2 col-sm-2 control-label">User Name</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" name="username" id="edit_username" value="<?php echo $udata['username'];?>" style="margin-left:10px;width: 400px;float:left">
                </div>
              </div>
              <div class="form-group">
                      <label class="col-sm-2 col-sm-2 control-label">User Type</label>
                      <div class="col-sm-10">
                        <select name="usertype" id="edit_userype" class="form-control" style="margin-left:10px;width: 400px;float:left">
                        	<option value="admin" <?php if($udata['usertype']=='admin') echo 'selected';?>>Administrator</option>
                            <option value="mexec" <?php if($udata['usertype']=='mexec') echo 'selected';?>>Media Executive</option>
                            <option value="finance" <?php if($udata['usertype']=='finance') echo 'selected';?>>Finance Officer</option>
                            <option value="director" <?php if($udata['usertype']=='director') echo 'selected';?>>Director</option>
                        </select>
                      </div>
                    </div>
                            
              
              <input type="submit" name="update" id="update" class="btn btn-success" value="Update User">
            </form>
          </div>
        </div>
      </div>
      <?php } else {?>
      <div class="row mt">
        <div class="col-lg-12">
          <div class="content-panel">
            <button class="btn btn-primary" style="margin-left: 20px;" type="button" data-toggle="collapse" data-target="#addNewUser" aria-expanded="false" aria-controls="addNewUser"><i class="glyphicon glyphicon-user"></i>&nbsp;&nbsp; Add New User</button>
            <br /><br />
            <div class="collapse" id="addNewUser">
              <div class="well">
                <div class="form-panel">
                  <h4 class="mb"><i class="fa fa-angle-right"></i> Add New User</h4>
                  <form class="form-horizontal style-form" method="post" action="manageuser.php">
                    <div class="form-group">
                      <label class="col-sm-2 col-sm-2 control-label">User Name</label>
                      <div class="col-sm-10">
                        <input class="form-control" type="text" id="username" name="username" style="margin-left:10px;width: 400px;float:left">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-2 col-sm-2 control-label">Password</label>
                      <div class="col-sm-10">
                        <input class="form-control" type="password" id="password" name="password" style="margin-left:10px;width: 400px;float:left">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-2 col-sm-2 control-label">User Type</label>
                      <div class="col-sm-10">
                        <select name="usertype" id="usertype" class="form-control" style="margin-left:10px;width: 400px;float:left">
                        	<option value="admin">Administrator</option>
                            <option value="mexec">Media Executive</option>
                            <option value="finance">Finance Officer</option>
                            
                        </select>
                        
                      </div>
                    </div>
                    
                    <input type="submit" name="submit" id="save" class="btn btn-success" value="Save User">
                  </form>
                </div>
              </div>
            </div>
            <script>
																						function confirmdel(url) {
																							if(confirm("are you sure you want to delete")) {
																								window.location = url;
																							}
																							else{
																								return false;
																							}
																						}
																					</script>
                                                                                    
            <h4 style="margin-left: 20px;"><i class="fa fa-angle-right"></i> User List</h4>
            <section id="unseen">
              <table class="table table-bordered table-striped table-condensed">
                <thead>
                  <tr>
                    <th>S.N</th>
                    <th>User Name</th>
                    <th>Password</th>
                    <th>User Type</th>
                    <th><span style="margin-left: 70px;">Edit</span></th>
                    <th><span style="margin-left: 70px;">Delete</span></th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $i = 0; 
                  while($ad=mysqli_fetch_assoc($userres)) :
                  $i++; 
                  ?>
                  <tr>
                    <td><?php echo $i; ?></td>
                    <td><?php echo $ad['username'];?></td>
                    <td><?php echo $ad['password'];?></td>
                    <td><?php echo $ad['usertype'];?></td>
            	   <td align="center"><a href="manageuser.php?action=edit&id=<?php echo $ad['user_id'];?>" class="btn btn-info" style="height: 25px;padding-top:1px;"><i class="fa fa-pencil-square-o"></i>&nbsp;&nbsp;Edit</a></td>
                    <td align="center"><a href="javascript:void(0)" onClick="confirmdel('manageuser.php?action=delete&id=<?php echo $ad['user_id'];?>')" class="btn btn-danger" style="height: 25px;padding-top:1px;"><i class="fa fa-trash-o"></i>&nbsp;&nbsp;Delete</a></td>
                  </tr>
                  <?php endwhile; ?>
                </tbody>
              </table>
            </section>
          </div>
          <!-- /content-panel --> 
        </div>
        <!-- /col-lg-4 --> 
      </div>
      <!-- /row -->
      
      <?php }//end of else ?>
    </section>
    <!--wrapper --> 
  </section>
  <!-- /MAIN CONTENT --> 
  
  <!--main content end-->
  <?php //include("footer.php");?>
</section>

<!-- js placed at the end of the document so the pages load faster --> 
<script src="assets/js/jquery.js"></script> 
<script src="assets/js/bootstrap.min.js"></script> 
<script src="assets/js/jquery-ui-1.9.2.custom.min.js"></script> 
<script src="assets/js/jquery.ui.touch-punch.min.js"></script> 
<script class="include" type="text/javascript" src="assets/js/jquery.dcjqaccordion.2.7.js"></script> 
<script src="assets/js/jquery.scrollTo.min.js"></script> 
<script src="assets/js/jquery.nicescroll.js" type="text/javascript"></script> 

<!--common script for all pages--> 
<script src="assets/js/common-scripts.js"></script> 

<!--script for this page--> 

<script>
      
        $("#save").click(function(){
           var username = $("#username").val();
           var password = $("#password").val();
           var uertype = $("#usertype").val();
           if(!username){
                alert("User name is empty");
                $("#username").focus();
                return false;
           }
           
           if(!password){
                alert("Password is empty");
                $("#password").focus();
                return false;
           }
           if(!usertype){
                alert("Choose User Type");
                $("#usertype").focus();
                return false;
           } 
        });
        
        
        $("#update").click(function(){
           var username = $("#edit_username").val();
           var usertype = $("#edit_usertype").val();
           if(!username){
                alert("User name is empty");
                $("#edit_usernmae").focus();
                return false;
           }
            
        });
  </script>
</body>
</html>
