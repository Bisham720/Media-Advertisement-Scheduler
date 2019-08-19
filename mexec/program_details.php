<?php 
include_once("../includes/session2.php");
include_once("../includes/dbconnect.php");


//$sql = "select bill.*,company.* from tbl_billing as bill inner join tbl_company as company on bill.company_id=company.company_id";
//$billres = executequery($sql);

$sql = "SELECT * FROM tbl_advertisement_schedule JOIN tbl_program ON tbl_advertisement_schedule.program_id = tbl_program.program_id JOIN tbl_advertisement ON tbl_advertisement_schedule.ad_id = tbl_advertisement.ad_id JOIN tbl_company ON tbl_advertisement.company_id=tbl_company.company_id WHERE tbl_advertisement_schedule.program_id='".$_GET['pid']."' ORDER BY tbl_advertisement.title ASC;";
$schdata = executequery($sql);

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
      <h3><i class="fa fa-angle-right"></i> Schedule Report for : " <?php echo $_GET['pname']; ?> "</h3>
        <div class="row mt">
            <div class="col-lg-12">
                <div class="content-panel">

            <section id="unseen">
                <h2 style="display: none;" id="whileprint">Media Planning System</h2>
                <hr id="whileprint4" style="display: none;" />
                <h3 style="display: none;" id="whileprint3">Schedule Report for : " <?php echo $_GET['pname']; ?> "</h3>
                <hr id="whileprint2" style="display: none;" />

                <table border="1px" cellspacing="0px" cellpadding="10px" class="table table-bordered table-striped table-condensed">
                <thead>
                  <tr>
                    
                    <th>S.N.</th>
                    <th>Ad Title</th>
                    <th>Frequency</th>
                    <th>Ad Duration</th>
                    <th>Total Duration</th>
                    <th>Company</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $sn = 0;
                  $tot = 0;
                  $progdur = 0;
                  while($sch=mysqli_fetch_assoc($schdata)) :
                  $sn++;
                      $tot = $tot + $sch['total_ad_duration'];
                      $progdur = $sch['ad_duration'];
                  ?>
                  <tr>
                    <td><?php echo $sn.".";?></td>
                    <td><?php echo $sch['title'];?></td>
                    <td><?php echo $sch['frequency'];?></td>
                    <td><?php echo $sch['ad_duration_sec'];?></td>
                    <td><?php echo $sch['total_ad_duration'];?></td>
                    <td><?php echo $sch['name'];?></td>
                  </tr>
                  <?php endwhile; ?>
                </tbody>
              </table>
                <div style="margin: 20px;">
                <h5><b>Overall Details:</b></h5>
                Ad Duration Specified in <?php echo $_GET['pname'];?>: <?php echo $progdur;?><br>
                Total Duration Occupied: <?php echo $tot;?>
                <hr>
                Remaining Time Duration in Program: <?php echo (intval($progdur) - intval($tot));?>
                </div>
            </section>
                    <button type="button" onclick="prntfn();" class="btn btn-default" style="margin-left: 20px;;"><i class="fa fa-print"></i>&nbsp;&nbsp;Print</button>
          </div>
          <!-- /content-panel --> 
        </div>
        <!-- /col-lg-4 --> 
      </div>
      <!-- /row -->
      
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

      function prntfn(){
          document.getElementById('whileprint').style.display = "block";
          document.getElementById('whileprint2').style.display = "block";
          document.getElementById('whileprint3').style.display = "block";
          document.getElementById('whileprint4').style.display = "block";
          var divToPrint=document.getElementById('unseen');

          var newWin=window.open('','Print-Window','width=1200,height=800');

          newWin.document.open();

          newWin.document.write('<html><body onload="window.print()">'+unseen.innerHTML+'</body></html>');

          newWin.document.close();
          document.getElementById('whileprint').style.display = "none";
          document.getElementById('whileprint2').style.display = "none";
          document.getElementById('whileprint3').style.display = "none";
          document.getElementById('whileprint4').style.display = "none";

      }
  </script>
</body>
</html>
