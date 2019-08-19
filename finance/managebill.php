<?php 
include_once("../includes/session2.php");
include_once("../includes/dbconnect.php"); 

//$sql = "select bill.*,company.* from tbl_billing as bill inner join tbl_company as company on bill.company_id=company.company_id";
//$billres = executequery($sql);

$sql = "select * from tbl_advertisement";
$resad = executequery($sql);

$sql = "select * from tbl_company";
$cores = executequery($sql);

$sql = "SELECT sum(final_cost) AS final_costing, tbl_company.company_id as ci FROM tbl_advertisement JOIN tbl_company ON tbl_advertisement.company_id = tbl_company.company_id JOIN tbl_advertisement_schedule ON tbl_advertisement_schedule.ad_id = tbl_advertisement.ad_id GROUP BY tbl_company.company_id";
$alldata = executequery($sql);

$sql = "SELECT SUM( tbl_billing.paid_amount ) AS final_paid, tbl_billing.company_id as ci, tbl_company.name AS cname FROM tbl_billing JOIN tbl_company ON tbl_billing.company_id=tbl_company.company_id GROUP BY tbl_company.company_id";
$paiddata = executequery($sql);

$sql = "SELECT SUM( tbl_billing.paid_amount ) AS final_paid, tbl_billing.company_id as ci, tbl_company.name AS cname FROM tbl_billing JOIN tbl_company ON tbl_billing.company_id=tbl_company.company_id GROUP BY tbl_company.company_id";
$paiddata2 = executequery($sql);

if(isset($_POST['submit'])) {
	$company_id = $_POST['company_id'];
	$payment= $_POST['payment'];
    $dateval = $_POST['date_val'];
    $p_by = $_POST['payment_by'];

	$sql = "insert into tbl_billing values ('','$company_id','$payment','$dateval','$p_by');";
    $res = executequery($sql);
	if($res) 
		header("location:managebill.php?msg=Bill successfully added");
	else
		header("location:managebill.php?msg=Bill could not be added sucessfully");
}

if(isset($_POST['update'])) {
	$bill_id = $_POST['id'];
	$ad_id = $_POST['ad_id'];
	$price = $_POST['price'];

	$sql = "update tbl_billing set ad_id='$ad_id', price='$price' where bill_id='$bill_id'";
	$res = executequery($sql);
	if($res) 
		header("location:managebill.php?msg=Bill updated successfully");
	else
		header("location:managebill.php?msg=Bill could not be updated successfully");
}

if(isset($_GET['action']) && $_GET['action']=='delete') {
	$bill_id = $_GET['id'];
	$sql = "delete from tbl_billing where bill_id='$bill_id'";
	$res = executequery($sql);
	if($res) 
		header("location:managebill.php?msg=Bill deleted successfully");
	else
		header("location:managebill.php?msg=Bill could not be deleted");
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
      <h3><i class="fa fa-angle-right"></i> Bill Information</h3>
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
            <h4 class="mb"><i class="fa fa-angle-right"></i> Edit Bill</h4>
            <form class="form-horizontal style-form" method="post" action="managebill.php">
              <input type="hidden" name="id" value="<?php echo $bill_id;?>">
              
              <div class="form-group">
                <label class="col-sm-2 col-sm-2 control-label">Advertisement name</label>
               <div class="col-sm-10">
                        <select name="ad_id">
                        <option>Select Advertisement </option>
                        <?php while($codata=mysqli_fetch_assoc($resad)) : ?>
                        <option value="<?php echo $codata['ad_id'];?>" <?php if($codata['ad_id']==$pdata['ad_id']) echo 'selected';?>><?php echo $codata['title'];?></option>
                        <?php endwhile;?>
                        </select>
                </div>
              </div>
              
              <div class="form-group">
                <label class="col-sm-2 col-sm-2 control-label">Price</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" name="price" value="<?php echo $pdata['price'];?>">
                </div>
              </div>
              
              <input type="submit" name="update" class="btn btn-primary" value="update">
            </form>
          </div>
        </div>
      </div>
      
      
       <div class="row mt">
        <div class="col-lg-12">
          <div class="form-panel">
            <h4 class="mb"><i class="fa fa-angle-right"></i> Pay Installment/h4>
            <form class="form-horizontal style-form" method="post" action="managebill.php">
              <input type="hidden" name="id" value="<?php echo $bill_id;?>">
              
              <div class="form-group">
                <label class="col-sm-2 col-sm-2 control-label">Advertisement name</label>
               <div class="col-sm-10">
                        <select name="ad_id">
                        <option>Select Advertisement </option>
                        <?php while($codata=mysqli_fetch_assoc($resad)) : ?>
                        <option value="<?php echo $codata['ad_id'];?>" <?php if($codata['ad_id']==$pdata['ad_id']) echo 'selected';?>><?php echo $codata['title'];?></option>
                        <?php endwhile;?>
                        </select>
                </div>
              </div>
              
              <div class="form-group">
                <label class="col-sm-2 col-sm-2 control-label">Price</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" name="price" value="<?php echo $pdata['price'];?>">
                </div>
              </div>
              
              <input type="submit" name="update" class="btn btn-primary" value="update">
            </form>
          </div>
        </div>
      </div>
      
      
      <?php } else {?>
      <div class="row mt">
        <div class="col-lg-12">
          <div class="content-panel">
            <button class="btn btn-info" style="margin-left: 20px; margin-bottom: 20px;" type="button" data-toggle="collapse" data-target="#addNewBill" aria-expanded="false" aria-controls="addNewBill"><i class="fa fa-credit-card"></i> &nbsp;Payment </button>
            <div class="collapse" id="addNewBill">
              <div class="well">
                <div class="form-panel">
                  <h4 class="mb"><i class="fa fa-angle-right"></i> Pay New Bill</h4>
                  <form class="form-horizontal style-form" method="post" action="managebill.php">

                      <div class="form-group">
                          <label class="col-sm-2 col-sm-2 control-label">Company Name</label>
                          <div class="col-sm-10">
                              <select name="company_id" id="company_id_addbill" class="form-control" onchange="changedata();">
                                  <option value="0">-Select-</option>
                                  <?php while($codata=mysqli_fetch_assoc($cores)) : ?>
                                      <option value="<?php echo $codata['company_id'];?>"><?php echo $codata['name'];?></option>
                                  <?php endwhile;?>
                              </select>
                          </div>
                      </div>

                      <?php while($addata=mysqli_fetch_assoc($alldata)) { ?>
                          <input type="hidden" id="cost_all_<?php echo $addata['ci'];?>" value="<?php echo $addata['final_costing'];?>">
                      <?php }?>

                      <?php while($addata=mysqli_fetch_assoc($paiddata)) { ?>
                          <input type="hidden" id="paid_all_<?php echo $addata['ci'];?>" value="<?php echo $addata['final_paid'];?>">
                      <?php }?>

                      <div class="form-group">
                          <label class="col-sm-2 col-sm-2 control-label">Total Cost</label>
                          <div class="col-sm-10">
                              <input class="form-control" id="actual_cost" type="text" name="actual_cost" readonly>
                          </div>
                      </div>

                      <div class="form-group">
                          <label class="col-sm-2 col-sm-2 control-label">Total Paid</label>
                          <div class="col-sm-10">
                              <input class="form-control" id="actual_paid" type="text" name="actual_paid" readonly>
                          </div>
                      </div>

                      <div class="form-group">
                          <label class="col-sm-2 col-sm-2 control-label">Total Due</label>
                          <div class="col-sm-10">
                              <input class="form-control" id="actual_due" type="text" name="actual_due" readonly>
                          </div>
                      </div>

                    <div class="form-group">
                      <label class="col-sm-2 col-sm-2 control-label">Payment Made</label>
                      <div class="col-sm-10">
                        <input class="form-control" type="text" name="payment">
                      </div>
                    </div>
                    
                    <div class="form-group">
                      <label class="col-sm-2 col-sm-2 control-label">Date</label>
                      <div class="col-sm-10">
                        <input class="form-control" type="text" name="date_val" value="<?php echo date('Y-m-d');?>">
                      </div>
                    </div>

                      <div class="form-group">
                          <label class="col-sm-2 col-sm-2 control-label">Payment By</label>
                          <div class="col-sm-10">
                              <input class="form-control" type="text" name="payment_by">
                          </div>
                      </div>
                    
                    <input type="submit" name="submit" class="btn btn-success" value="submit">
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
            <h4>&nbsp;&nbsp;<i class="fa fa-angle-right"></i> Bill List</h4>
            <section id="unseen">
              <table class="table table-bordered table-striped table-condensed">
                <thead>
                  <tr>
                    
                    <th>Company Name</th>
                    <th>Total Cost</th>
                    <th>Total Paid</th>
                    <th>Total Due</th>
                    <th>Payment Details</th>
                  </tr>
                </thead>
                <tbody>
                  <?php while($ad=mysqli_fetch_assoc($paiddata2)) : ?>
                  <tr>
                      <?php
                      $sql = "SELECT sum(final_cost) AS final_costing, tbl_company.company_id as ci FROM tbl_advertisement JOIN tbl_company ON tbl_advertisement.company_id = tbl_company.company_id JOIN tbl_advertisement_schedule ON tbl_advertisement_schedule.ad_id = tbl_advertisement.ad_id WHERE tbl_company.company_id='".$ad['ci']."' GROUP BY tbl_company.company_id";
                      $alldata = executequery($sql);
                      $costamt = 0;
                      while($ppp=mysqli_fetch_assoc($alldata)) :
                          $costamt = $ppp['final_costing'];
                      endwhile;
                      ?>
                    <td><?php echo $ad['cname'];?></td>
                    <td><?php echo $costamt;?></td>
                    <td><?php echo $ad['final_paid'];?></td>
                      <td><?php echo (floatval($costamt) - floatval($ad['final_paid'])); ?></td>
                     <td><a href="payment_details.php?cid=<?php echo $ad['ci'];?>&cname=<?php echo $ad['cname']; ?>" class="btn btn-warning" style="height:25px; padding-top:1px;"><i class="fa fa-file"></i> &nbsp;Payment Details</a></td>
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

        document.getElementById('actual_cost').value = parseInt(abc);
        document.getElementById('actual_paid').value = bcd;
        document.getElementById('actual_due').value = parseInt(abc) - parseInt(bcd);
    }
  </script>
</body>
</html>
