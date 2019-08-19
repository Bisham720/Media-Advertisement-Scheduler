<?php 
include_once("../includes/session2.php");
include_once("../includes/dbconnect.php");

$sql = "select * from tbl_company";
$res = executequery($sql);

if(isset($_POST['submit'])) {
	$name = $_POST['name'];
    $address = $_POST['address'];
    $email = $_POST['email'];
    $phone_number = $_POST['phone_number'];
	$sql = "select * from tbl_company where name='$name'";
	$res = executequery($sql);
	$rec = mysqli_num_rows($res);
	if($rec>0) {
		header("location:managecompanies.php?msg=company name already exist");
	}else{
	$sql = "insert into tbl_company (company_id,name,address,email,number) values ('','$name','$address','$email','$phone_number')";
	$res = executequery($sql);
	if($res) 
		header("location:managecompanies.php?msg=company successfully added");
	else
		header("location:managecompanies.php?msg=company information could not be added");
	}
}

if(isset($_POST['update'])) {
	$id = $_POST['id'];
	$name = $_POST['name'];
    $address = $_POST['address'];
    $email = $_POST['email'];
    $phone_number = $_POST['phone_number'];
	$sql = "update tbl_company set name = '$name', address = '$address', email = '$email', number = '$phone_number' where company_id='$id'";
	$res = executequery($sql);
	if($res) 
		header("location:managecompanies.php?msg=company updated successfully");
	else
		header("location:managecompanies.php?msg=company information could not be updated");
}

if(isset($_GET['action']) && $_GET['action']=='delete') {
	$id = $_GET['cid'];
	$sql = "delete from tbl_company where company_id='$id'";
	$res = executequery($sql);
	if($res) 
		header("location:managecompanies.php?msg=company deleted successfully");
	else
		header("location:managecompanies.php?msg=company information could not be deleted");
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
      <h3><i class="fa fa-angle-right"></i> Companies Information</h3>
       <?php
	  if(isset($_GET['msg'])) {
	  ?>
      <p class="alert-warning"><?php echo $_GET['msg'];?></p>
	  <?php 
	  }//end of isset
     
																					if(isset($_GET['action']) && $_GET['action']=="edit") { 
																					$id = $_GET['cid'];
																					$sql = "select * from tbl_company where company_id='$id'";
																					$res = executequery($sql);
																					$cdata = mysqli_fetch_assoc($res);
																					?>
      <div class="row mt">
        <div class="col-lg-12">
          <div class="form-panel">
            <h4 class="mb"><i class="fa fa-angle-right"></i> Edit Company Information</h4>
            <form class="form-horizontal style-form" method="post" action="managecompanies.php">
              <input type="hidden" name="id" value="<?php echo $id;?>">
              <div class="form-group">
                <label class="col-sm-2 col-sm-2 control-label">Company Name</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" name="name" id="edit_name" value="<?php echo $cdata['name'];?>" style="margin-left:10px;width: 400px;float:left">
                </div>
              </div>
              <div class="form-group">
                      <label class="col-sm-2 col-sm-2 control-label">Address</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" name="address" id="edit_address" value="<?php echo $cdata['address'];?>" style="margin-left:10px;width: 400px;float:left">
                      </div>                      
                    </div>
                    <div class="form-group">
                      <label class="col-sm-2 col-sm-2 control-label">Business Email</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" name="email" id="edit_email" value="<?php echo $cdata['email'];?>" style="margin-left:10px;width: 400px;float:left">
                      </div>                      
                    </div>
                    <div class="form-group">
                      <label class="col-sm-2 col-sm-2 control-label">Business Phone Number</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" name="phone_number" id="edit_phone_number" value="<?php echo $cdata['number'];?>" style="margin-left:10px;width: 400px;float:left">
                      </div>                      
                    </div>

              <input type="submit" name="update" id="update" class="btn btn-success" value="Update Company">
            </form>
          </div>
        </div>
      </div>
      <?php } else {?>
      <div class="row mt">
        <div class="col-lg-12">
          <div class="content-panel">
            <button class="btn btn-primary" style="margin-left: 20px;" type="button" data-toggle="collapse" data-target="#addNewCompany" aria-expanded="false" aria-controls="addNewCompany"><i class="fa fa-group"></i>&nbsp;&nbsp;  Add New Company </button>
            <br /><br />
            <div class="collapse" id="addNewCompany">
              <div class="well">
                <div class="form-panel">
                  <h4 class="mb"><i class="fa fa-angle-right"></i> Add New Company Information</h4>
                  <form class="form-horizontal style-form" method="post" action="managecompanies.php">
                    <div class="form-group">
                      <label class="col-sm-2 col-sm-2 control-label">Business Name</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" name="name" id="name" style="margin-left:10px;width: 400px;float:left">
                      </div>                      
                    </div>
                    <div class="form-group">
                      <label class="col-sm-2 col-sm-2 control-label">Address</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" name="address" id="address" style="margin-left:10px;width: 400px;float:left">
                      </div>                      
                    </div>
                    <div class="form-group">
                      <label class="col-sm-2 col-sm-2 control-label">Business Email</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" name="email" id="email" style="margin-left:10px;width: 400px;float:left">
                      </div>                      
                    </div>
                    <div class="form-group">
                      <label class="col-sm-2 col-sm-2 control-label">Business Phone Number</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" name="phone_number" id="phone_number" style="margin-left:10px;width: 400px;float:left">
                      </div>                      
                    </div>
                    <input type="submit" name="submit" id="save" class="btn btn-success" value="Save Company">
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
            <h4 style="margin-left: 20px;"><i class="fa fa-angle-right"></i> Companies List</h4>
            <section id="unseen">
              <table class="table table-bordered table-striped table-condensed">
                <thead>
                  <tr>
                    <th>S.N</th>
                    <th>Business Name</th>
                    <th>Address</th>
                    <th>Business Email</th>
                    <th>Business Phone</th>
                    <th><span style="margin-left: 70px;">Edit</span></th>
                    <th><span style="margin-left: 70px;">Delete</span></th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $i = 0; 
                  while($company=mysqli_fetch_assoc($res)) :
                  $i++; 
                  ?>
                  <tr>
                    <td><?php echo $i; ?></td>
                    <td><?php echo $company['name'];?></td>
                    <td><?php echo $company['address']; ?></td>
                    <td><?php echo $company['email']; ?></td>
                    <td><?php echo $company['number']; ?></td>
                    <td align="center"><a href="managecompanies.php?action=edit&cid=<?php echo $company['company_id'];?>" class="btn btn-info" style="height: 25px;padding-top:1px;"><i class="fa fa-pencil-square-o"></i>&nbsp;&nbsp;Edit</a></td>
                    <td align="center"><a href="javascript:void(0)" onClick="confirmdel('managecompanies.php?action=delete&cid=<?php echo $company['company_id'];?>')" class="btn btn-danger" style="height: 25px;padding-top:1px;"><i class="fa fa-trash-o"></i>&nbsp;&nbsp;Delete</a></td>
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

var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
      $("#save").click(function(){
        var name = $("#name").val();
        var address = $("#address").val();
        var email = $("#email").val();
        var phone_number = $("#phone_number").val();
        if(!name){
            alert("Compnay name is empty");
            $("#name").focus();
            return false;
        }
        if(!address){
            alert("Address is emtpty");
            $("#address").focus();
            return false;
        }
        if(!email){
            alert("Email is empty");
            $("#email").focus();
            return false;
        }
        if(email){
           if(re.test(email) == false){
                    alert("Invalid email format");
                    $("#email").focus();
                    return false;
           }
       }
        if(!phone_number){
            alert("Phone number is empty");
            $("#phone_number").focus();
            return false;
        }
        
        if(phone_number){
            checkinteger = isInt(phone_number);
            //checkfloat = isFloat(product_price);
            if(checkinteger == true){
               
            }else{
                 alert("Please enter number");
                $("#phone_number").focus();
                return false;
            }
        }
        
      });
      
      $("#update").click(function(){
        var name = $("#edit_name").val();
        var address = $("#edit_address").val();
        var email = $("#edit_email").val();
        var phone_number = $("#edit_phone_number").val();
        if(!name){
            alert("Compnay name is empty");
            $("#edit_name").focus();
            return false;
        }
        if(!address){
            alert("Address is emtpty");
            $("#edit_address").focus();
            return false;
        }
        if(!email){
            alert("Email is empty");
            $("#edit_email").focus();
            return false;
        }
        if(email){
           if(re.test(email) == false){
                    alert("Invalid email format");
                    $("#edit_email").focus();
                    return false;
           }
       }
        if(!phone_number){
            alert("Phone number is empty");
            $("#edit_phone_number").focus();
            return false;
        }
        
        if(phone_number){
            checkinteger = isInt(phone_number);
            //checkfloat = isFloat(product_price);
            if(checkinteger == true){
               
            }else{
                 alert("Please enter number");
                $("#edit_phone_number").focus();
                return false;
            }
        }
      });
      
      function isInt(n) {
        return n != "" && !isNaN(n) && Math.round(n) == n;
    }

  </script>
</body>
</html>
