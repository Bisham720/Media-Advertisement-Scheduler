<?php 
include_once("../includes/session2.php");
include_once("../includes/dbconnect.php");


if(isset($_POST['submit'])) {
	
	$pname = $_POST['pname'];
	$start_date = $_POST['start_date'];
	$end_date = $_POST['end_date'];
	$start_time = $_POST['start_time'];
	$end_time = $_POST['end_time'];
	$ad_duration = $_POST['ad_duration'];
	$rate= $_POST['rate'];
	$days=$_POST['days'];
	
	$sqla=" SELECT * FROM tbl_program as p, tbl_program_days as pd WHERE pd.pid=p.program_id and pd.days in (";
	
			$i=1;
			foreach($days as $val){
				if($i<count($days)){
					$sqla.= $val.",";
				}else{
					$sqla.=$val;
				}
				$i++;
			}
			
									
			$sqla.=" )";
	
	$sqla.=" AND p.end_date>='$start_date' ";
	$sqla.=" AND p.start_time<='$start_time'  and  p.end_time>'$start_time'";
	
	$sqla.=" UNION ";
	
	$sqla.=" SELECT * FROM tbl_program as p, tbl_program_days as pd WHERE pd.pid=p.program_id and pd.days in (";
	
			$i=1;
			foreach($days as $val){
				if($i<count($days)){
					$sqla.= $val.",";
				}else{
					$sqla.=$val;
				}
				$i++;
			}
			
									
			$sqla.=" )";
	
	$sqla.=" AND p.end_date>='$start_date' ";
	$sqla.=" AND p.start_time<'$end_time'  and  p.end_time<='$end_time'";
	
	$conn = mysqli_connect("localhost","root","","media_planning");

	
	$resa = mysqli_query($conn,$sqla);
	$a=mysqli_num_rows($resa);
	
	
	if($a==0){
	
	
		$sqlprogram = "insert into tbl_program (program_id,pname,start_date,end_date,start_time,end_time,ad_duration,rate) values ('','$pname','$start_date','$end_date','$start_time','$end_time','$ad_duration','$rate')";
	
		mysqli_query($conn, $sqlprogram);
		
		$lastid=mysqli_insert_id($conn);
		
		foreach($days as $val){
			$sqlprogramdays="INSERT INTO tbl_program_days (pid,days) values($lastid,$val)";
			mysqli_query($conn, $sqlprogramdays);
		
		}
		
		
			header("location:manageprogram.php?msg=Program successfully added");
			
	}else{
			header("location:manageprogram.php?msg=Program information could not be added");
	}

}

if(isset($_POST['update'])) {
	$p_id = $_POST['id'];
	$pname = $_POST['pname'];
	$start_date = $_POST['start_date'];
	$end_date = $_POST['end_date'];
	$start_time = $_POST['start_time'];
	$end_time = $_POST['end_time'];
	$ad_duration = $_POST['ad_duration'];
	$rate = $_POST['rate'];
	$sql = "update tbl_program set pname = '$pname',start_date='$start_date',end_date='$end_date',start_time='$start_time',end_time='$end_time',ad_duration='$ad_duration',rate='$rate' where program_id='$p_id'";
	$res = executequery($sql);
	if($res) 
		header("location:manageprogram.php?msg=Program updated successfully");
	else
		header("location:manageprogram.php?msg=Program information could not be updated");
}

if(isset($_GET['action']) && $_GET['action']=='delete') {
	$id = $_GET['pid'];
	$sql = "delete from tbl_program where program_id='$id'";
	$res = executequery($sql);
	if($res) 
		header("location:manageprogram.php?msg=program deleted successfully");
	else
		header("location:manageprogram.php?msg=program information could not be deleted");
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
      <h3><i class="fa fa-angle-right"></i> Programs Information</h3>
       <?php
	  if(isset($_GET['msg'])) {
	  ?>
      <p class="alert-warning"><?php echo $_GET['msg'];?></p>
	  <?php 
	  }//end of isset
  
		if(isset($_GET['action']) && $_GET['action']=="edit") { 
		$id = $_GET['pid'];
		$sql = "select * from tbl_program where program_id='$id'";
		$res = executequery($sql);
		$pdata = mysqli_fetch_assoc($res);
		?>
      <div class="row mt">
        <div class="col-lg-12">
          <div class="form-panel">
            <h4 class="mb"><i class="fa fa-angle-right"></i> Edit Program Information</h4>
            <form class="form-horizontal style-form" method="post" action="manageprogram.php">
              <input type="hidden" name="id" value="<?php echo $id;?>">
              <div class="form-group">
                <label class="col-sm-2 col-sm-2 control-label">Program Name</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" name="pname" id="edit_pname" value="<?php echo $pdata['pname'];?>" style="margin-left:10px;width: 400px;float:left">
                </div>
              </div>
               <div class="form-group">
                <label class="col-sm-2 col-sm-2 control-label">Start Date</label>
                <div class="col-sm-10">
                  <input type="date" class="form-control" name="start_date" id="edit_start_date" value="<?php echo $pdata['start_date'];?>" style="margin-left:10px;width: 400px;float:left">
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 col-sm-2 control-label">End Date (Optional)</label>
                <div class="col-sm-10">
                  <input type="date" class="form-control" name="end_date" id="edit_end_date" value="<?php echo $pdata['end_date'];?>" style="margin-left:10px;width: 400px;float:left">
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 col-sm-2 control-label">Start Time</label>
                <div class="col-sm-10">
                  <input type="time" class="form-control" name="start_time" id="edit_start_time" value="<?php echo $pdata['start_time'];?>" style="margin-left:10px;width: 400px;float:left">
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 col-sm-2 control-label">End Time</label>
                <div class="col-sm-10">
                  <input type="time" class="form-control" name="end_time" id="edit_end_time" value="<?php echo $pdata['end_time'];?>" style="margin-left:10px;width: 400px;float:left">
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 col-sm-2 control-label">Available Time Slot(Seconds)</label>
                <div class="col-sm-10">
                  <input type="int" class="form-control" name="ad_duration" id="edit_ad_duration" value="<?php echo $pdata['ad_duration'];?>" style="margin-left:10px;width: 400px;float:left">
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 col-sm-2 control-label">Rate(per second)</label>
                <div class="col-sm-10">
                  <input type="int" class="form-control" name="rate" id="edit_rate" value="<?php echo $pdata['rate'];?>" style="margin-left:10px;width: 400px;float:left">
                </div>
              </div>
			  
			  
			  
			  
              <input type="submit" name="update" id="update" class="btn btn-success" value="Update Program">
            </form>
          </div>
        </div>
      </div>
      <?php } else {?>
      <div class="row mt">
        <div class="col-lg-12">
          <div class="content-panel">
            <button class="btn btn-primary" style="margin-left: 20px;" type="button" data-toggle="collapse" data-target="#addNewProgram" aria-expanded="false" aria-controls="addNewProgram"><i class="fa fa-desktop"></i>&nbsp;&nbsp; Add New Program </button>
            <br /><br />
            <div class="collapse" id="addNewProgram">
              <div class="well">
                <div class="form-panel">
                  <h4 class="mb"><i class="fa fa-angle-right"></i> Add New Program Information</h4>
                  <form class="form-horizontal style-form" method="post" action="manageprogram.php">
                    <div class="form-group">
                      <label class="col-sm-2 col-sm-2 control-label">Program Name</label>
                      <div class="col-sm-10">
                        <input class="form-control" type="text" id="pname" name="pname" style="margin-left:10px;width: 400px;float:left">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-2 col-sm-2 control-label">Start Date</label>
                      <div class="col-sm-10">
                        <input class="form-control" id="startdate"  type="date" name="start_date" style="margin-left:10px;width: 400px;float:left">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-2 col-sm-2 control-label">End Date (Optional)</label>
                      <div class="col-sm-10">
                        <input class="form-control" id="enddate"  type="date" name="end_date" style="margin-left:10px;width: 400px;float:left">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-2 col-sm-2 control-label">Start time</label>
                      <div class="col-sm-10">
                        <input class="form-control" type="time" id="start_time" name="start_time" style="margin-left:10px;width: 400px;float:left">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-2 col-sm-2 control-label">End time</label>
                      <div class="col-sm-10">
                        <input class="form-control" type="time" id="end_time" name="end_time" style="margin-left:10px;width: 400px;float:left">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-2 col-sm-2 control-label">Available Time Slot (Seconds)</label>
                      <div class="col-sm-10">
                        <input class="form-control"  type="int" id="ad_duration" name="ad_duration" style="margin-left:10px;width: 400px;float:left">
                      </div>
                    </div>
					
                    <div class="form-group">
                      <label class="col-sm-2 col-sm-2 control-label">Rate (per second)</label>
                      <div class="col-sm-10">
                        <input class="form-control"  type="int" id="rate" name="rate" style="margin-left:10px;width: 400px;float:left">
                      </div>
                    </div>
					
					
					<div class="form-group">
						<label class="col-sm-2 col-sm-2 control-label">Days</label>
						<div>
						  <input type="checkbox" class="days" name="days[]" value=1>&nbsp;&nbsp;Sunday&nbsp;
						  <input type="checkbox" class="days" name="days[]"  value=2>&nbsp;&nbsp;Monday&nbsp;
						  <input type="checkbox" class="days" name="days[]"  value=3>&nbsp;&nbsp;Tuesday&nbsp;
						  <input type="checkbox" class="days" name="days[]"  value=4>&nbsp;&nbsp;webnesday&nbsp;
						  <input type="checkbox" class="days" name="days[]"  value=5>&nbsp;&nbsp;thursday&nbsp;
						  <input type="checkbox" class="days" name="days[]"  value=6>&nbsp;&nbsp;Friday&nbsp;
						  <input type="checkbox" class="days" name="days[]"  value=7>&nbsp;&nbsp;Saturday
						  
						</div>
				    </div>
			  
					
					
                    <input type="submit" id="save" name="submit" class="btn btn-success" value="Save Program">
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
            <h4 style="margin-left: 20px;"><i class="fa fa-angle-right"></i> Program List</h4>
            <section id="unseen">
              <table class="table table-bordered table-striped table-condensed">
                <thead>
                  <tr>
                    <th>S.N.</th>
                    <th>Program</th>
                    <th><nobr>Start Date</nobr></th>
                    <th>End Date</th>
                    <th><nobr>Start time</nobr></th>
                    <th><nobr>End time</nobr></th>
					<th>Days</th>
                    <th>Available Time Slot (seconds)</th>
                    <th>Rate (per second) </th>
                    <th>Edit</th>
                    <th>Delete</th>
                  </tr>
                </thead>
                <tbody>
                  <?php 
				  $i = 0;
				  $sqlprogramdisplay = "select * from tbl_program";
					$result = executequery($sqlprogramdisplay);
				  while($program=mysqli_fetch_assoc($result)) :
                  $i++; 
                  ?>
                  <tr>
                    <td><?php echo $i; ?></td>
                    <td><?php echo $program['pname'];?></td>
                    <td><?php echo $program['start_date'];?></td>
                    <td><?php echo $program['end_date'];?></td>
                    <td><?php echo $program['start_time'];?></td>
                    <td><?php echo $program['end_time'];?></td>
					<td>
                    <nobr>
                    <?php 
							$sqlprogramdisplay1="SELECT * FROM tbl_program_days WHERE pid=".$program['program_id'];
							$result1 = executequery($sqlprogramdisplay1);
							while($daysdata=mysqli_fetch_assoc($result1)) {
								if($daysdata['days']==1){
									echo "Sunday".",";
								}else if($daysdata['days']==2){
									echo "Monday".",";
								}else if($daysdata['days']==3){
									echo "Tuesday".",";
								}else if($daysdata['days']==4){
									echo "webnesday".",";
								}else if($daysdata['days']==5){
									echo "thursday".",";
								}else if($daysdata['days']==6){
									echo "friday".",";
								}else{
									echo "Saturday"."";
								}
							}
							
						?>
                    </nobr>    
					</td>
                    <td><?php echo $program['ad_duration'];?></td>
                    <td><?php echo $program['rate'];?></td>
                    <td><a href="manageprogram.php?action=edit&pid=<?php echo $program['program_id'];?>" class="btn btn-info" style="height: 25px;padding-top:1px;"><i class="fa fa-pencil-square-o"></i>&nbsp;&nbsp;Edit</a></td>
                    <td><a href="javascript:void(0)" onClick="confirmdel('manageprogram.php?action=delete&pid=<?php echo $program['program_id'];?>')" class="btn btn-danger" style="height: 25px;padding-top:1px;"><i class="fa fa-trash-o"></i>&nbsp;&nbsp;Delete</a></td>
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
        //$( "#startdate" ).datepicker();
        //$('#startdate').datepicker({ dateFormat: 'yy-mm-dd' }).val();
        //$('#enddate').datepicker({ dateFormat: 'yy-mm-dd' }).val();
        //$( "#enddate" ).datepicker();
        //$( "#edit_start_date" ).datepicker();
        //$('#edit_start_date').datepicker({ dateFormat: 'yy-mm-dd' }).val();
        //$( "#edit_end_date" ).datepicker();
       // $('#edit_end_date').datepicker({ dateFormat: 'yy-mm-dd' }).val();
        //$( "#datepicker3" ).datepicker();
        
        $("#save").click(function(){
           var pname = $("#pname").val();
           var startdate = $("#startdate").val();
           var enddate = $("#enddate").val();
           var start_time = $("#start_time").val();
           var end_time = $("#end_time").val();
           var ad_duration = $("#ad_duration").val();
           var rate = $("#rate").val();
           var days = $(".days").val();
           if(!pname){
                alert("Program name is empty");
                $("#pname").focus();
                return false;
           }
           if(!startdate){
            alert("Start date is empty");
            $("#startdate").focus();
            return false;
           }
           if(!enddate){
            alert("End date is empty");
            $("#enddate").focus();
            return false;
           }
           if(!start_time){
            alert("Start time is empty");
            $("#start_time").focus();
            return false;
           }
           if(!end_time){
            alert("End time is empty");
            $("#end_time").focus();
            return false;
           }
           if(!ad_duration){
            alert("Add duration is empty");
            $("#ad_duration").focus();
            return false;
           }
           if(!days){
            alert("Check one of the days");
            $("#ad_duration").focus();
            return false;
           }
           if(!rate){
            alert("Rate is empty");
            $("#rate").focus();
            return false;
           }
        });
        
        $("#update").click(function(){
           var pname = $("#edit_pname").val();
           var start_date = $("#edit_start_date").val();
           var end_date = $("#edit_end_date").val();
           var start_time = $("#edit_start_time").val();
           var end_time = $("#edit_end_time").val();
           var ad_duration = $("#edit_ad_duration").val();
           var rate = $("#edit_rate").val();
           if(!pname){
            alert("Program name is empty");
            $("#edit_pname").focus();
            return false;
           }
           if(!start_date){
            alert("Start date is empty");
            $("#edit_start_date").focus();
            return false;
           }
           if(!end_date){
            alert("End date is empty");
            $("#edit_end_date").focus();
            return false;
           }
           if(!start_time){
            alert("Start time is empty");
            $("#edit_start_time").focus();
            return false;
           }
           if(!end_time){
            alert("End time is empty");
            $("#edit_end_time").focus();
            return false;
           }
           if(!ad_duration){
            alert("Add duration is empty");
            $("#edit_ad_duration").focus();
            return false;
           }
           if(!rate){
            alert("Rate is empty");
            $("#edit_rate").focus();
            return false;
           }
        });
  </script>
</body>
</html>
