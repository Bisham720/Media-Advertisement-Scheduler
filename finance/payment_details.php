<?php 
include_once("../includes/session2.php");
include_once("../includes/dbconnect.php"); 

//$sql = "select bill.*,company.* from tbl_billing as bill inner join tbl_company as company on bill.company_id=company.company_id";
//$billres = executequery($sql);

$sql = "SELECT * FROM tbl_advertisement_schedule JOIN tbl_program ON tbl_advertisement_schedule.program_id = tbl_program.program_id JOIN tbl_advertisement ON tbl_advertisement_schedule.ad_id = tbl_advertisement.ad_id WHERE tbl_advertisement.company_id = ".$_GET['cid'];
$schdata = executequery($sql);

$sql = "SELECT * FROM tbl_billing WHERE company_id=".$_GET['cid'];
$paiddata = executequery($sql);
$paiddata2 = executequery($sql);

if(isset($_POST['update'])) {
	$bill_id = $_POST['id'];
	$pamt = $_POST['payment'];
	$pdate = $_POST['date_val'];
    $pby = $_POST['payment_by'];

	$sql = "update tbl_billing set paid_amount='$pamt', payment_date='$pdate', payment_by='$pby' where bill_id='$bill_id'";
	$res = executequery($sql);
	if($res) 
		header("location:payment_details.php?cid=".$_POST['cid']."&cname=".$_POST['cname']."&msg=Bill updated successfully");
	else
		header("location:payment_details.php?cid=".$_POST['cid']."&cname=".$_POST['cname']."&msg=Bill could not be updated successfully");
}

if(isset($_GET['action']) && $_GET['action']=='delete') {
	$bill_id = $_GET['bid'];
	$sql = "delete from tbl_billing where bill_id='$bill_id'";
	$res = executequery($sql);
	if($res) 
		header("location:payment_details.php?cid=".$_GET['cid']."&cname=".$_GET['cname']."&msg=Bill deleted successfully");
	else
		header("location:payment_details.php?cid=".$_GET['cid']."&cname=".$_GET['cname']."&msg=Bill could not be deleted");
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
      <h3><i class="fa fa-angle-right"></i> Payment Details for Company: " <?php echo $_GET['cname']; ?> "</h3>
      <?php
	  if(isset($_GET['msg'])) {
	  ?>
      <p class="alert-warning"><?php echo $_GET['msg'];?></p>
	  <?php 
	  }//end of isset
	  
		if(isset($_GET['action']) && $_GET['action']=="edit") { 
		$bill_id = $_GET['bid'];
		$sql = "select * from tbl_billing where bill_id='$bill_id'";
		$res = executequery($sql);
		$pdata = mysqli_fetch_assoc($res);
		?>
      <div class="row mt">
        <div class="col-lg-12">
          <div class="form-panel">
            <h4 class="mb"><i class="fa fa-angle-right"></i> Edit Payment Bill</h4>
            <form class="form-horizontal style-form" method="post" action="payment_details.php">
              <input type="hidden" name="id" value="<?php echo $bill_id;?>">
                <input type="hidden" name="cid" value="<?php echo $_GET['cid'];?>">
                <input type="hidden" name="cname" value="<?php echo $_GET['cname'];?>">

                <div class="form-group">
                    <label class="col-sm-2 col-sm-2 control-label">Payment Made</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="text" name="payment" value="<?php echo $pdata['paid_amount'];?>">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 col-sm-2 control-label">Date</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="text" name="date_val"  value="<?php echo $pdata['payment_date'];?>">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 col-sm-2 control-label">Payment By</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="text" name="payment_by" value="<?php echo $pdata['payment_by'];?>">
                    </div>
                </div>
              
              <input type="submit" name="update" class="btn btn-success" value="update">
            </form>
          </div>
        </div>
      </div>
      
      

      
      
      <?php } else {?>
      <div class="row mt">
        <div class="col-lg-12">
          <div class="content-panel">


                
            <script>
			
			
																						function confirmdel() {
																							if(confirm("are you sure you want to delete")) {
																								return true;
																							}
																							else{
																								return false;
																							}
																						}
																					</script>
            <h4>&nbsp;&nbsp;<i class="fa fa-angle-right"></i> Bill List</h4>
            <section id="unseen">
              <table class="table table-bordered table-striped table-condensed">
                <thead>
                  <tr>
                    
                    <th>ID</th>
                    <th>Paid Amount</th>
                    <th>Paid Date</th>
                    <th>Paid By</th>
                    <th style="text-align: center;">Edit</th>
                      <th style="text-align: center;">Delete</th>
                      <th style="text-align: center;">Print Receipt</th>
                  </tr>
                </thead>
                <tbody>
                  <?php while($ad=mysqli_fetch_assoc($paiddata)) : ?>
                  <tr>

                    <td><?php echo $ad['bill_id'];?></td>
                    <td><?php echo $ad['paid_amount'];?></td>
                    <td><?php echo $ad['payment_date'];?></td>
                      <td><?php echo $ad['payment_by'];?></td>
                     <td align="center"><a href="payment_details.php?action=edit&bid=<?php echo $ad['bill_id'];?>&cid=<?php echo $_GET['cid'];?>&cname=<?php echo $_GET['cname'];?>" class="btn btn-info" style="height: 25px;padding-top:1px;"><i class="fa fa-pencil-square-o"></i>&nbsp;&nbsp;Edit</a></td>
                      <td align="center"><a href="payment_details.php?action=delete&bid=<?php echo $ad['bill_id'];?>&cid=<?php echo $_GET['cid'];?>&cname=<?php echo $_GET['cname'];?>" onclick="return confirmdel();" class="btn btn-danger" style="height: 25px;padding-top:1px;"><i class="fa fa-trash-o"></i>&nbsp;&nbsp;Delete</a></td>
                      <td align="center"><button type="button" class="btn btn-default" style="height:25px; padding-top:1px;" onclick="printreceipt('pd_<?php echo $ad['bill_id'];?>')"><i class="fa fa-print"></i> &nbsp;Print Receipt</button> </td>
                  </tr>
                  <?php endwhile; ?>
                </tbody>
              </table>
            </section>
              <?php while($ad=mysqli_fetch_assoc($paiddata2)) : ?>
                  <div id="pd_<?php echo $ad['bill_id'];?>" style="display:none;">
                      <table width="600px" border="2px" cellpadding="10px" cellspacing="0px">
                          <tr>
                              <th style="padding: 20px;">
                                  <h4>Media Planning System <br><small>Media Planning is as simple as that!</small></h4>
                                  <hr>
                                  <span style="float: right;">[ <small>Date: <?php echo $ad['payment_date'];?></small> ]</span>
                                  <center><h5>Payment Receipt</h5></center>
                                  <br>
                                  Payment Made By: <u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $ad['payment_by'];?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u> on behalf of <u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo $_GET['cname'];?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u> of
                                  <br>Rs. <u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $ad['paid_amount'];?> <small>( Only )</small> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u>
                                  <br><br><br>
                            <span style="float:right;">
                                <u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u>
                                <br>
                                Authorized Signature
                            </span>
                              </th>
                          </tr>
                      </table>
                  </div>
              <?php endwhile; ?>

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

      $(function(){
          $('select.styled').customSelect();
      });

    function changedata(){
        var id = document.getElementById('company_id_addbill').value;
        if(document.getElementById('cost_all_'+id)){
            var abc = document.getElementById('cost_all_'+id).value;
        }else{
            var abc = 0;
        }

        if(document.getElementById('paid_all_'+id)){
            var bcd = document.getElementById('paid_all_'+id).value;
        }else{
            var bcd = 0;
        }

        document.getElementById('actual_cost').value = abc;
        document.getElementById('actual_paid').value = bcd;
        document.getElementById('actual_due').value = parseFloat(abc) - parseFloat(bcd);
    }

      function printreceipt(a){
          var originalContents = document.body.innerHTML;
          document.getElementById(a).style.display = "block";
          var printContents = document.getElementById(a).innerHTML;


          document.body.innerHTML = printContents;

          window.print();

          document.body.innerHTML = originalContents;
          document.getElementById(a).style.display = "none";
      }
  </script>
</body>
</html>
