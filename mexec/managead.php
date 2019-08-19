<?php 
include_once("../includes/session2.php");
include_once("../includes/dbconnect.php");

$sql = "select ad.*,co.* from tbl_advertisement as ad inner join tbl_company as co on ad.company_id=co.company_id";
$adres = executequery($sql);

$sql = "select * from tbl_company";
$cores = executequery($sql);

if(isset($_POST['submit'])) {
	$title = $_POST['title'];
	$company_id= $_POST['company_id'];
	$start_date = $_POST['start_date'];
	$end_date = $_POST['end_date'];
    $ad_length = $_POST['ad_duration'];
    if($ad_length==""){
        header("location:managead.php?msg=Please provide the ad length!");
    }
    if(($end_date!="")&&(strtotime($start_date) > strtotime($end_date))) {
		header("location:managead.php?msg=start date cannot be greater than end date");
	}else{
		$onair_status = $_POST['onair_status'];
		$discount = $_POST['discount'];
		$sql = "insert into tbl_advertisement (ad_id,title,company_id,start_date,end_date,ad_duration_sec,onair_status,discount) values ('','$title','$company_id','$start_date','$end_date','$ad_length','$onair_status','$discount')";
		$res = executequery($sql);
		if($res) 
			header("location:managead.php?msg=Advertisement successfully added");
		else
			header("location:managead.php?msg=Advertisement information could not be added");
	}
}

if(isset($_POST['update'])) {
	$ad_id = $_POST['id'];
	$title = $_POST['title'];
	$company_id= $_POST['company_id'];
	$start_date = $_POST['start_date'];
	$end_date = $_POST['end_date'];
    $ad_length = $_POST['ad_duration'];
	$onair_status = $_POST['onair_status'];
	$discount = $_POST['discount'];
	
	$sql = "update tbl_advertisement set title = '$title',company_id='$company_id',start_date='$start_date',end_date='$end_date',ad_duration_sec='$ad_length',onair_status='$onair_status', discount='$discount' where ad_id='$ad_id'";
	$res = executequery($sql);
	if($res) 
		header("location:managead.php?msg=Advertisement updated successfully");
	else
		header("location:managead.php?msg=Advertisement information could not be updated");
}

if(isset($_GET['action']) && $_GET['action']=='delete') {
	$id = $_GET['aid'];
	$sql = "delete from tbl_advertisement where ad_id='$id'";
	$res = executequery($sql);
	if($res) 
		header("location:managead.php?msg=Advertisement deleted successfully");
	else
		header("location:managead.php?msg=Advertisement information could not be deleted");
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
<link rel="stylesheet" href="assets/datepicker/jquery-ui.css">
<script src="assets/datepicker/jquery.js"></script>
<script src="assets/datepicker/jquery-ui.js"></script>

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
      <h3><i class="fa fa-angle-right"></i> Advertisement Information</h3>
	  <?php
	  if(isset($_GET['msg'])) {
	  ?>
      <p class="alert-warning"><?php echo $_GET['msg'];?></p>
	  <?php 
	  }//end of isset
 
		if(isset($_GET['action']) && $_GET['action']=="edit") { 
		$id = $_GET['aid'];
		$sql = "select * from tbl_advertisement where ad_id='$id'";
		$res = executequery($sql);
		$pdata = mysqli_fetch_assoc($res);
		?>
      <div class="row mt">
        <div class="col-lg-12">
          <div class="form-panel">
            <h4 class="mb"><i class="fa fa-angle-right"></i> Edit Advertisement Details</h4>
            <form class="form-horizontal style-form" method="post" action="managead.php">
              <input type="hidden" name="id" value="<?php echo $id;?>">
              <div class="form-group">
                <label class="col-sm-2 col-sm-2 control-label">Advertisement title</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" id="edit_title" name="title" value="<?php echo $pdata['title'];?>" style="margin-left:10px;width: 400px;float:left">
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 col-sm-2 control-label">Company Id</label>
                <div class="col-sm-10">
                        <select name="company_id" id="edit_company_id" class="form-control" style="margin-left:10px;width: 400px;float:left">
                        <option>Select company name</option>
                        <?php while($codata=mysqli_fetch_assoc($cores)) : ?>
                        <option value="<?php echo $codata['company_id'];?>" <?php if($codata['company_id']==$pdata['company_id']) echo 'selected';?>><?php echo $codata['name'];?></option>
                        <?php endwhile;?>
                        </select>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 col-sm-2 control-label">Start Date</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" id="edit_start_date" name="start_date" value="<?php echo $pdata['start_date'];?>" style="margin-left:10px;width: 400px;float:left">
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 col-sm-2 control-label">End Date (Optional)</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" id="edit_end_date" name="end_date" value="<?php echo $pdata['end_date'];?>" style="margin-left:10px;width: 400px;float:left">
                </div>
              </div>

                <div class="form-group">
                    <label class="col-sm-2 col-sm-2 control-label">Ad Duration (<i>in Seconds</i>)</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="edit_ad_duration" name="ad_duration" value="<?php echo $pdata['ad_duration_sec'];?>" style="margin-left:10px;width: 400px;float:left">
                    </div>
                </div>
              
              <div class="form-group">
                <label class="col-sm-2 col-sm-2 control-label">On Air Status</label>
                <div class="col-sm-10">
                  <select name="onair_status" id="edit_onair_status" class="form-control" style="margin-left:10px;width: 400px;float:left">
                  <option <?php if($pdata['onair_status']=='yes') echo 'selected';?>>yes</option>
                  <option <?php if($pdata['onair_status']=='no') echo 'selected';?>>no</option>
				</select>	
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 col-sm-2 control-label">Discount(if any)</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" id="edit_discount" name="discount" value="<?php echo $pdata['discount'];?>" style="margin-left:10px;width: 400px;float:left"> (percent e.g. 5)
                </div>
              </div>
              <input type="submit" id="update" name="update" class="btn btn-success" value="Update Advertisement">
            </form>
          </div>
        </div>
      </div>
      <?php } else {?>
      <div class="row mt">
        <div class="col-lg-12">
          <div class="content-panel">
            <button class="btn btn-primary" style="margin-left: 20px;" type="button" data-toggle="collapse" data-target="#addNewAdvertisement" aria-expanded="false" aria-controls="addNewAdvertisement"><i class="fa fa-film"></i>&nbsp;&nbsp; Add New Advertisement</button>
            <br /><br />
            <div class="collapse" id="addNewAdvertisement">
              <div class="well">
                <div class="form-panel">
                  <h4 class="mb"><i class="fa fa-angle-right"></i> Add New Advertisement Details</h4>
                  <form class="form-horizontal style-form" method="post" action="managead.php">
                    <div class="form-group">
                      <label class="col-sm-2 col-sm-2 control-label">Advertisement Title</label>
                      <div class="col-sm-10">
                        <input class="form-control" type="text" id="title" name="title" style="margin-left:10px;width: 400px;float:left">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-2 col-sm-2 control-label">Company Name</label>
                      <div class="col-sm-10">
                        <select name="company_id" id="company_id" class="form-control" style="margin-left:10px;width: 400px;float:left">
                        <option value="">Select company name</option>
                        <?php while($codata=mysqli_fetch_assoc($cores)) : ?>
                        <option value="<?php echo $codata['company_id'];?>"><?php echo $codata['name'];?></option>
                        <?php endwhile;?>
                        </select>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-2 col-sm-2 control-label">Start Date</label>
                      <div class="col-sm-10">
                        <input type="date" class="form-control" id="start_date" name="start_date" style="margin-left:10px;width: 400px;float:left">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-2 col-sm-2 control-label">End Date (Optional)</label>
                      <div class="col-sm-10">
                        <input type="date" class="form-control" id="end_date" name="end_date" value="" style="margin-left:10px;width: 400px;float:left">
                      </div>
                    </div>

                      <div class="form-group">
                          <label class="col-sm-2 col-sm-2 control-label">Ad Duration (<i>in Seconds</i>)</label>
                          <div class="col-sm-10">
                              <input type="text" class="form-control" id="ad_duration" name="ad_duration" value="" style="margin-left:10px;width: 400px;float:left">
                          </div>
                      </div>
                 
                    <div class="form-group">
                      <label class="col-sm-2 col-sm-2 control-label">On Air Status</label>
                      <div class="col-sm-10">
                        <select name="onair_status" class="form-control" id="onair_status" style="margin-left:10px;width: 400px;float:left">
                        <option>yes</option>
                        <option>no</option>
                        </select>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-2 col-sm-2 control-label">Discount(if any)</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" id="discount" name="discount" style="margin-left:10px;width: 400px;float:left">
                      </div>
                    </div>
                    <input type="submit" id="save" name="submit" class="btn btn-success" value="Save Advertisement">
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
            <h4 style="margin-left: 20px;"><i class="fa fa-angle-right"></i> Advertisement List</h4>
            <section id="unseen">
              <table class="table table-bordered table-striped table-condensed">
                <thead>
                  <tr>
                    <th>S.N</th>
                    <th>Advertisement Title</th>
                    <th>Company Name</th>
                    <th>Start date</th>
                    <th>End date</th>
                    <th>Ad Length (Seconds)</th>
                    <th>On Air Status</th>
                    <th>Discount</th>
                    <th>Edit</th>
                    <th>Delete</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $i = 0; 
                  while($ad=mysqli_fetch_assoc($adres)) :
                  $i++; 
                  ?>
                  <tr>
                    <td><?php echo $i; ?></td>
                    <td><?php echo $ad['title'];?></td>
                    <td><?php echo $ad['name'];?></td>
                    <td><?php echo $ad['start_date'];?></td>
                    <td><?php echo $ad['end_date'];?></td>
                    <td><?php echo $ad['ad_duration_sec'];?></td>
                    <td><?php echo $ad['onair_status'];?></td>
                    <td><?php echo $ad['discount'];?>%</td>
					<!--td><a href="makepayment.php?ad_id=<?php echo $ad['ad_id']?>">Pay</a></td-->
                    <td><a href="managead.php?action=edit&aid=<?php echo $ad['ad_id'];?>" class="btn btn-info" style="height: 25px;padding-top:1px;"><i class="fa fa-pencil-square-o"></i>&nbsp;&nbsp;Edit</a></td>
                    <td><a href="javascript:void(0)" onClick="confirmdel('managead.php?action=delete&aid=<?php echo $ad['ad_id'];?>')" class="btn btn-danger" style="height: 25px;padding-top:1px;"><i class="fa fa-trash-o"></i>&nbsp;&nbsp;Delete</a></td>
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
        //$( "#start_date" ).datepicker();
       // $('#start_date').datepicker({ dateFormat: 'yy-mm-dd' }).val();
        //$( "#end_date" ).datepicker();
       // $('#end_date').datepicker({ dateFormat: 'yy-mm-dd' }).val();
        //$( "#edit_start_date" ).datepicker();
        //$('#edit_start_date').datepicker({ dateFormat: 'yy-mm-dd' }).val();
        //$( "#edit_end_date" ).datepicker();
        //$('#edit_end_date').datepicker({ dateFormat: 'yy-mm-dd' }).val();
        
      $("#save").click(function(){
        var title = $("#title").val();
        var company_id = $("#company_id").val();
        var start_date = $("#start_date").val();
        var end_date = $("#end_date").val();
        var ad_duration = $("#ad_duration").val();
        if(!title){
            alert("Title is empty");
            $("#title").focus();
            return false;
        }
        
        if(!company_id){
            alert("Choose company");
            $("#company_id").focus();
            return false;
        }
        if(!start_date){
            alert("Start date is empty");
            $("#start_date").focus();
            return false;
        }
        if(!end_date){
            alert("End date is empty");
            $("#end_date").focus();
            return false;
        }
        if(!ad_duration){
            alert("Add duration is empty");
            $("#ad_duration").focus();
            return false;
        }
      });
      
      $("#update").click(function(){
        var title = $("#edit_title").val();
        var company_id = $("#edit_company_id").val();
        var start_date = $("#edit_start_date").val();
        var end_date = $("#edit_end_date").val();
        var ad_duration = $("#edit_ad_duration").val();
        if(!title){
            alert("Title is empty");
            $("#edit_title").focus();
            return false;
        }
        if(!company_id){
            alert("Choose Company");
            $("#edit_company_id").focus();
            return false;
        }
        if(!start_date){
            alert("Start Date is empty");
            $("#edit_start_date").focus();
            return false;
        }
        if(!end_date){
            alert("End date is empty");
            $("#edit_end_date").focus();
            return false;
        }
        if(!ad_duration){
            alert("Add duration is empty");
            $("#edit_ad_duration").focus();
            return false;
        }
      });

  </script>
</body>
</html>
