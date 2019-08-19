<?php 
include_once("../includes/session2.php");
include_once("../includes/dbconnect.php");

$sql = "select t1.*,t2.*,t3.* from tbl_advertisement_schedule as t1 inner join tbl_advertisement as t2 on t1.ad_id=t2.ad_id inner join tbl_program as t3 on t1.program_id=t3.program_id";
$res = executequery($sql);

$sql = "SELECT * FROM tbl_advertisement"; 
$resultin = executequery($sql);

$sql = "SELECT * FROM tbl_advertisement";
$resultin2 = executequery($sql);

$sql = "SELECT * FROM tbl_program"; 
$prres=executequery($sql);

$sql = "SELECT * FROM tbl_program";
$prres2=executequery($sql);

$mainsql = "SELECT SUM(tbl_advertisement_schedule.total_ad_duration) as sum_tot , tbl_program.program_id FROM tbl_program JOIN tbl_advertisement_schedule ON tbl_program.program_id = tbl_advertisement_schedule.program_id GROUP BY tbl_program.program_id;";
$maindata = executequery($mainsql);

if(isset($_POST['submit'])) {
	$ad_id = $_POST['ad_id'];
	$program_id = $_POST['program_id'];
	$ad_duration = $_POST['ad_duration'];
	$frequency = $_POST['frequency'];
    $tot_duration = $_POST['tot_duration'];
    $tot_cost = $_POST['gt_rs'];
	
	$sql = "select * from tbl_advertisement_schedule where ad_id='$ad_id' and program_id='$program_id'";
	$resinsert = executequery($sql);
	$rec = mysqli_num_rows($resinsert);
	if($rec > 0)  {
	header("location:managead_schedule.php?msg=Duplicate entry for same advertisement");
	exit(0);
	}else{
	
	
		if($tot_duration<=$_POST['rem_slot']){
		
		
            $sql = "insert into tbl_advertisement_schedule(schedule_id,ad_id,program_id,ad_duration,frequency,total_ad_duration,final_cost) values ('','$ad_id','$program_id','$ad_duration','$frequency','$tot_duration','$tot_cost')";
            $temp = executequery($sql);
            if($temp)
                header("location:managead_schedule.php?msg=Schedule added successfully");
            else
                header("location:managead_schedule.php?msg=Schedule could not be added");
            /*$link = mysqli_connect(HNAME,USER,PWD,DBNAME);
            $result = mysqli_query($link,$sql);
            $lastid = mysqli_insert_id($link);
            mysqli_close($link);
            if($result) {
                $sql = "select t1.schedule_id,t1.ad_id,t1.frequency, t2.rate, t3.discount, t3.ad_duration from tbl_advertisement_schedule as t1 inner join tbl_program as t2 on t1.program_id=t2.program_id inner join tbl_advertisement as t3 on t1.ad_id=t3.ad_id where schedule_id='$lastid'";
                $billres = executequery($sql);
                $data = mysqli_fetch_assoc($billres);
                //print_r($data);die();
                $nad_id=$data['ad_id'];
                if($data['discount'] > 0) {
                    $amt = ($data['rate']*$data['frequency']*$data['duration'])-($data['rate']*($data['discount']/100));
                }else{
                    $amt = ($data['rate']*$data['frequency']*$data['duration']);
                }

                //$sql="insert into tbl_billing (bill_id,ad_id,price) values ('','$nad_id','$amt')";
                //$res = executequery($sql);
                //if($res) {
                    //header("location:managead_schedule.php?msg=Schedule successfulley added");
                //}
                //else{
                   // header("location:managead_schedule.php?msg=Schedule information could not be added");
                //}

            }//end of main else*/
	    }else{
		     header("location:managead_schedule.php?msg=Error. Invalid Time Duration Configured!");

	    }
    }
}
if(isset($_POST['update'])) {
	$schedule_id = $_POST['id'];
	$ad_id = $_POST['ad_id'];
    $program_id = $_POST['program_id'];
    $ad_duration = $_POST['ad_duration2'];
    $frequency = $_POST['frequency2'];
    $tot_duration = $_POST['tot_duration2'];
    $tot_cost = $_POST['gt_rs2'];

    if($tot_duration<=$_POST['rem_slot2']){
        $sql = "update tbl_advertisement_schedule set ad_id = '$ad_id',program_id='$program_id',ad_duration='$ad_duration',frequency='$frequency',total_ad_duration='$tot_duration',final_cost='$tot_cost' where schedule_id='$schedule_id'";
        $res = executequery($sql);
        if($res)
            header("location:managead_schedule.php?msg=Schedule updated successfully");
        else
            header("location:managead_schedule.php?msg=Schedule information could not be updated");
    }else{
        header("location:managead_schedule.php?msg=Schedule information could not be updated! Invalid Time Cofiguration");
    }

	/*if($res) 
		header("location:managead_schedule.php?msg=Schedule updated successfully");
	else
		header("location:managead_schedule.php?msg=Schedule information could not be updated");*/
}

if(isset($_GET['action']) && $_GET['action']=='delete') {
	$schedule_id = $_GET['id'];
	$sql = "delete from tbl_advertisement_schedule where schedule_id='$schedule_id'";
	$res = executequery($sql);
	if($res) 
		header("location:managead_schedule.php?msg=Schedule deleted successfully");
	else
		header("location:managead_schedule.php?msg=Schedule information could not be deleted");
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
      <h3><i class="fa fa-angle-right"></i> Schedule Information</h3>
      
       <?php
	  if(isset($_GET['msg'])) {
	  ?>
      <p class="alert-warning"><?php echo $_GET['msg'];?></p>
	  <?php 
	  }//end of isset
	   
		if(isset($_GET['action']) && $_GET['action']=="edit") { 
		$schedule_id = $_GET['id'];
		$sql = "select * from tbl_advertisement_schedule where schedule_id='$schedule_id'";
		$res = executequery($sql);
		$pdata = mysqli_fetch_assoc($res);
		?>
      <div class="row mt">
        <div class="col-lg-12">
          <div class="form-panel">
            <h4 class="mb"><i class="fa fa-angle-right"></i> Edit Schedule</h4>
            <form class="form-horizontal style-form" method="post" action="managead_schedule.php">
            <input type="hidden" name="id" value="<?php echo $schedule_id;?>">

                <div class="form-group">
                    <label class="col-sm-2 col-sm-2 control-label">Program Title</label>
                    <div class="col-sm-10">
                        <select name="program_id" id="ad_sch_add_ad_prog2" onchange="changeaddata2();" style="margin-left:10px;width: 400px;float:left" class="form-control">
                            <?php while($prdata=mysqli_fetch_assoc($prres)) : ?>
                                <option value="<?php echo $prdata['program_id'];?>" <?php if($prdata['program_id']==$pdata['program_id']) echo 'selected';?>><?php echo $prdata['pname'];?></option>
                            <?php endwhile;?>
                        </select>
                    </div>
                </div>

                <?php while($addata=mysqli_fetch_assoc($prres2)) { ?>
                    <input type="hidden" id="ad_dur2_<?php echo $addata['program_id'];?>" value="<?php echo $addata['ad_duration'];?>">
                    <input type="hidden" id="ad_rate2_<?php echo $addata['program_id'];?>" value="<?php echo $addata['rate'];?>">
                <?php }?>

                <div class="form-group">
                    <label class="col-sm-2 col-sm-2 control-label">Available Slot(seconds)</label>
                    <div class="col-sm-10">
                        <input type="int" name="avl_slot2" id="avl_slot2" readonly style="margin-left:10px;width: 400px;float:left" class="form-control">
                    </div>
                </div>

                <?php while($maind=mysqli_fetch_assoc($maindata)) { ?>
                    <input type="hidden" id="main_d2_<?php echo $maind['program_id'];?>" value="<?php echo ($maind['sum_tot'] - $pdata['total_ad_duration']);?>">
                <?php }?>

                <div class="form-group">
                    <label class="col-sm-2 col-sm-2 control-label">Remaining Slot(seconds)</label>
                    <div class="col-sm-10">
                        <input type="int" name="rem_slot2" id="rem_slot2" readonly style="margin-left:10px;width: 400px;float:left" class="form-control">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 col-sm-2 control-label">Cost per Second</label>
                    <div class="col-sm-10">
                        <input type="int" name="rate2" id="rate2" readonly style="margin-left:10px;width: 400px;float:left" class="form-control">
                    </div>
                </div>


                <div class="form-group">
                      <label class="col-sm-2 col-sm-2 control-label">Advertisement Title</label>
                      <div class="col-sm-10">
                         <select name="ad_id" id="ad_sch_add_ad2" onchange="changeaddata2();" style="margin-left:10px;width: 400px;float:left" class="form-control">
                        <?php while($addata=mysqli_fetch_assoc($resultin)) { ?>
                        <option value="<?php echo $addata['ad_id'];?>" <?php if($addata['ad_id']==$pdata['ad_id']) echo 'selected';?>><?php echo $addata['title'];?></option>
                        <?php }?>
                        </select>
                      </div>
                    </div>

                <?php while($addata=mysqli_fetch_assoc($resultin2)) { ?>
                    <input type="hidden" id="ad_duration2_<?php echo $addata['ad_id'];?>" value="<?php echo $addata['ad_duration_sec'];?>">
                    <input type="hidden" id="ad_discount2_<?php echo $addata['ad_id'];?>" value="<?php echo $addata['discount'];?>">
                <?php }?>


                <div class="form-group">
                    <label class="col-sm-2 col-sm-2 control-label">Ad Duration(seconds)</label>
                    <div class="col-sm-10">
                        <input type="int" name="ad_duration2" id="ad_sch_add_duration2" value="0" readonly style="margin-left:10px;width: 400px;float:left" class="form-control">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 col-sm-2 control-label">Ad Discount(%)</label>
                    <div class="col-sm-10">
                        <input type="int" name="ad_discount2" id="ad_sch_add_discount2" value="0" readonly style="margin-left:10px;width: 400px;float:left" class="form-control">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 col-sm-2 control-label">Frequency</label>
                    <div class="col-sm-10">
                        <input type="int" name="frequency2" id="freq2" value="<?php echo $pdata['frequency'];?>" onchange="changeaddata2();" style="margin-left:10px;width: 400px;float:left" class="form-control">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 col-sm-2 control-label">Total Duration (Seconds)</label>
                    <div class="col-sm-10">
                        <input type="int" name="tot_duration2" id="tot_duration2" readonly style="margin-left:10px;width: 400px;float:left" class="form-control">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 col-sm-2 control-label">Total Cost (in Rs.)</label>
                    <div class="col-sm-10">
                        <input type="int" name="tot_cost2" id="tot_cost2" readonly style="margin-left:10px;width: 400px;float:left" class="form-control">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 col-sm-2 control-label">Discount (in Rs.)</label>
                    <div class="col-sm-10">
                        <input type="int" name="discount_rs2" id="discount_rs2" readonly style="margin-left:10px;width: 400px;float:left" class="form-control">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 col-sm-2 control-label">Grand Total (in Rs.)</label>
                    <div class="col-sm-10">
                        <input type="int" name="gt_rs2" id="gt_rs2" readonly style="margin-left:10px;width: 400px;float:left" class="form-control">
                    </div>
                </div>

                    
                    <input type="submit" name="update" class="btn btn-success" value="Update">

                  </form>
          </div>
        </div>
      </div>
      <?php } else {?>
      
     
      <div class="row mt">
        <div class="col-lg-12">
          <div class="content-panel">
            <button class="btn btn-primary" style="margin-left: 20px;" type="button" data-toggle="collapse" data-target="#addNewSchedule" aria-expanded="false" aria-controls="addNewSchedule"><i class="fa fa-clock-o"></i>&nbsp;&nbsp; Add New Schedule </button>
            <br /><br />
            <div class="collapse" id="addNewSchedule">
              <div class="well">
                <div class="form-panel">
                  <h4 class="mb"><i class="fa fa-angle-right"></i> Add New Schedule</h4>
                  <form class="form-horizontal style-form" method="post" action="managead_schedule.php">

                      <div class="form-group">
                          <label class="col-sm-2 col-sm-2 control-label">Program Title</label>
                          <div class="col-sm-10">
                              <select name="program_id" id="ad_sch_add_ad_prog" onchange="changeaddata();" style="margin-left:10px;width: 400px;float:left" class="form-control">
                                  <option value="0">-Select-</option>
                                  <?php while($prdata=mysqli_fetch_assoc($prres)) : ?>
                                      <option value="<?php echo $prdata['program_id'];?>"><?php echo $prdata['pname'];?></option>
                                  <?php endwhile;?>
                              </select>
                          </div>
                      </div>

                      <?php while($addata=mysqli_fetch_assoc($prres2)) { ?>
                          <input type="hidden" id="ad_dur_<?php echo $addata['program_id'];?>" value="<?php echo $addata['ad_duration'];?>">
                          <input type="hidden" id="ad_rate_<?php echo $addata['program_id'];?>" value="<?php echo $addata['rate'];?>">
                      <?php }?>

                      <div class="form-group">
                          <label class="col-sm-2 col-sm-2 control-label">Available Slot(seconds)</label>
                          <div class="col-sm-10">
                              <input type="int" name="avl_slot" id="avl_slot" readonly style="margin-left:10px;width: 400px;float:left" class="form-control">
                          </div>
                      </div>

                      <?php while($maind=mysqli_fetch_assoc($maindata)) { ?>
                          <input type="hidden" id="main_d_<?php echo $maind['program_id'];?>" value="<?php echo $maind['sum_tot'];?>">
                      <?php }?>

                      <div class="form-group">
                          <label class="col-sm-2 col-sm-2 control-label">Remaining Slot(seconds)</label>
                          <div class="col-sm-10">
                              <input type="int" name="rem_slot" id="rem_slot" readonly style="margin-left:10px;width: 400px;float:left" class="form-control">
                          </div>
                      </div>

                      <div class="form-group">
                          <label class="col-sm-2 col-sm-2 control-label">Cost per Second</label>
                          <div class="col-sm-10">
                              <input type="int" name="rate" id="rate" readonly style="margin-left:10px;width: 400px;float:left" class="form-control">
                          </div>
                      </div>


                    <div class="form-group">
                      <label class="col-sm-2 col-sm-2 control-label">Advertisement Title</label>
                      <div class="col-sm-10">
                         <select name="ad_id" id="ad_sch_add_ad" onchange="changeaddata();" style="margin-left:10px;width: 400px;float:left" class="form-control">
                             <option value="0">--Select--</option>
                        <?php

                        while($addata=mysqli_fetch_assoc($resultin)) { ?>
                        <option value="<?php echo $addata['ad_id'];?>"><?php echo $addata['title'];?></option>
                        <?php }?>
                        </select>
                      </div>
                    </div>


                      <?php while($addata=mysqli_fetch_assoc($resultin2)) { ?>
                      <input type="hidden" id="ad_duration_<?php echo $addata['ad_id'];?>" value="<?php echo $addata['ad_duration_sec'];?>">
                      <input type="hidden" id="ad_discount_<?php echo $addata['ad_id'];?>" value="<?php echo $addata['discount'];?>">
                      <?php }?>


                      <div class="form-group">
                          <label class="col-sm-2 col-sm-2 control-label">Ad Duration(seconds)</label>
                          <div class="col-sm-10">
                              <input type="int" name="ad_duration" id="ad_sch_add_duration" value="0" readonly style="margin-left:10px;width: 400px;float:left" class="form-control">
                          </div>
                      </div>

                      <div class="form-group">
                          <label class="col-sm-2 col-sm-2 control-label">Ad Discount(%)</label>
                          <div class="col-sm-10">
                              <input type="int" name="ad_discount" id="ad_sch_add_discount" value="0" readonly style="margin-left:10px;width: 400px;float:left" class="form-control">
                          </div>
                      </div>

                    <div class="form-group">
                      <label class="col-sm-2 col-sm-2 control-label">Frequency</label>
                      <div class="col-sm-10">
                        <input type="int" name="frequency" id="freq" value="0" onchange="changeaddata();" style="margin-left:10px;width: 400px;float:left" class="form-control">
                      </div>
                    </div>

                      <div class="form-group">
                          <label class="col-sm-2 col-sm-2 control-label">Total Duration (Seconds)</label>
                          <div class="col-sm-10">
                              <input type="int" name="tot_duration" id="tot_duration" readonly style="margin-left:10px;width: 400px;float:left" class="form-control">
                          </div>
                      </div>

                      <div class="form-group">
                          <label class="col-sm-2 col-sm-2 control-label">Total Cost (in Rs.)</label>
                          <div class="col-sm-10">
                              <input type="int" name="tot_cost" id="tot_cost" readonly style="margin-left:10px;width: 400px;float:left" class="form-control">
                          </div>
                      </div>

                      <div class="form-group">
                          <label class="col-sm-2 col-sm-2 control-label">Discount (in Rs.)</label>
                          <div class="col-sm-10">
                              <input type="int" name="discount_rs" id="discount_rs" readonly style="margin-left:10px;width: 400px;float:left" class="form-control">
                          </div>
                      </div>

                      <div class="form-group">
                          <label class="col-sm-2 col-sm-2 control-label">Grand Total (in Rs.)</label>
                          <div class="col-sm-10">
                              <input type="int" name="gt_rs" id="gt_rs" readonly style="margin-left:10px;width: 400px;float:left" class="form-control">
                          </div>
                      </div>
                    
                    <input type="submit" name="submit" class="btn btn-success" value="Save New Schedule">
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
            <h4><i class="fa fa-angle-right"></i> Schedule List</h4>
            <section id="unseen">
              <table class="table table-bordered table-striped table-condensed">
                <thead>
                  <tr>
                    <th>S.N</th>
                    <th>Advertisement Name</th>
                    <th>Program Name</th>
                    <th>Frequency</th>
                    <th>Total Duration(Seconds)</th>
                    <th>Edit</th>
                    <th>Delete</th>
                  </tr>
                </thead>
                <tbody>
                  <?php 
				  $sql="SELECT asch.total_ad_duration as ad_duration, a.title as title, asch.frequency as frequency, p.pname as pname, asch.schedule_id as schedule_id FROM tbl_advertisement_schedule as asch, tbl_advertisement as a, tbl_program as p WHERE p.program_id=asch.program_id AND a.ad_id=asch.ad_id";
				  $resultquery=executequery($sql);
				  //echo $sql;
				  
				  $i = 0;
				  while($schedule=mysqli_fetch_assoc($resultquery)) :
                  $i++; 
                  ?>
                  <tr>
                    <td><?php echo $i; ?></td>
                    <td><?php echo $schedule['title'];?></td>
                    <td><?php echo $schedule['pname'];?></td>
                    <td><?php echo $schedule['frequency'];?></td>
                    <td><?php echo $schedule['ad_duration'];?></td>
                    <td><a href="managead_schedule.php?action=edit&id=<?php echo $schedule['schedule_id'];?>" class="btn btn-info" style="height: 25px;padding-top:1px;"><i class="fa fa-pencil-square-o"></i>&nbsp;&nbsp;Edit</a></td>
                    <td><a href="javascript:void(0)" onClick="confirmdel('managead_schedule.php?action=delete&id=<?php echo $schedule['schedule_id'];?>')" class="btn btn-danger" style="height: 25px;padding-top:1px;"><i class="fa fa-trash-o"></i>&nbsp;&nbsp;Delete</a></td>
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
      //custom select box
      changeaddata2();

      $(function(){
          $('select.styled').customSelect();
      });

    function changeaddata(){

        var id = document.getElementById('ad_sch_add_ad').value;
if(id==0){}else{
        var abc = document.getElementById('ad_duration_'+id).value;
        var bcd = document.getElementById('ad_discount_'+id).value;

        document.getElementById('ad_sch_add_duration').value = abc;
        document.getElementById('ad_sch_add_discount').value = bcd;
}
        changeaddata_prog();
        calculate_tot();
    }

      function changeaddata_prog(){

          var id = document.getElementById('ad_sch_add_ad_prog').value;

          var abc = document.getElementById('ad_dur_'+id).value;
          var bcd = document.getElementById('ad_rate_'+id).value;
          if(document.getElementById('main_d_'+id)){
              var rem = parseInt(abc) - parseInt(document.getElementById('main_d_'+id).value);
          }else{
              rem = abc;
          }

          document.getElementById('avl_slot').value = abc;
          document.getElementById('rem_slot').value = rem;
          document.getElementById('rate').value = bcd;
      }

    function calculate_tot(){
        var a = document.getElementById('ad_sch_add_duration').value;
        var b = document.getElementById('freq').value;
        var c = parseInt(a) * parseInt(b);
        document.getElementById('tot_duration').value = c;
        var d = parseInt(document.getElementById('rate').value) * c;
        document.getElementById('tot_cost').value = d;
        var e = d * parseInt(document.getElementById('ad_sch_add_discount').value) / 100;
        document.getElementById('discount_rs').value = e;
        var f = d - e;
        document.getElementById('gt_rs').value = f;
    }



      function changeaddata2(){

          var id = document.getElementById('ad_sch_add_ad2').value;
          if(id==0){}else{
              var abc = document.getElementById('ad_duration2_'+id).value;
              var bcd = document.getElementById('ad_discount2_'+id).value;

              document.getElementById('ad_sch_add_duration2').value = abc;
              document.getElementById('ad_sch_add_discount2').value = bcd;
          }
          changeaddata_prog2();
          calculate_tot2();
      }

      function changeaddata_prog2(){

          var id = document.getElementById('ad_sch_add_ad_prog2').value;

          var abc = document.getElementById('ad_dur2_'+id).value;
          var bcd = document.getElementById('ad_rate2_'+id).value;
          var rem = parseInt(abc) - parseInt(document.getElementById('main_d2_'+id).value)

          document.getElementById('avl_slot2').value = abc;
          document.getElementById('rem_slot2').value = rem;
          document.getElementById('rate2').value = bcd;
      }

      function calculate_tot2(){
          var a = document.getElementById('ad_sch_add_duration2').value;
          var b = document.getElementById('freq2').value;
          var c = parseInt(a) * parseInt(b);
          document.getElementById('tot_duration2').value = c;
          var d = parseInt(document.getElementById('rate2').value) * c;
          document.getElementById('tot_cost2').value = d;
          var e = d * parseInt(document.getElementById('ad_sch_add_discount2').value) / 100;
          document.getElementById('discount_rs2').value = e;
          var f = d - e;
          document.getElementById('gt_rs2').value = f;
      }

  </script>
</body>
</html>
