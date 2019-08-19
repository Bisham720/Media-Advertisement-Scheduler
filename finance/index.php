<?php 
include_once("../includes/session2.php");

include_once("../includes/dbconnect.php");
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Media Advertisement Scheduler</title>

    <!-- Bootstrap core CSS -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <!--external css-->
    <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
        
    <!-- Custom styles for this template -->
    <link href="assets/css/style.css" rel="stylesheet">
    <link href="assets/css/style-responsive.css" rel="stylesheet">

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
          <section class="wrapper site-min-height">
          	<h3 id="top"><i class="fa fa-angle-right"></i> Welcome to dashboard</h3>
          	<div class="row">
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-aqua">
                <div class="inner">
               <?php   $link = mysqli_connect(HNAME,USER,PWD,DBNAME);
	$query = "select * from tbl_user";
	$result = mysqli_query($link,$query);
	$rec= mysqli_num_rows($result); ?>
                 
                  <h3><?php echo $rec; ?></h3>
                  <p>Users</p>
                </div>
                <div class="icon">
                  <i class="glyphicon glyphicon-user"></i>
                </div>

              </div>
            </div><!-- ./col -->
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-green">
                <div class="inner">
                  <?php   $link = mysqli_connect(HNAME,USER,PWD,DBNAME);
			$query = "select * from tbl_company";
			$result = mysqli_query($link,$query);
			$rec= mysqli_num_rows($result); ?>
                 
                  <h3><?php echo $rec; ?></h3>
                  <p>Companies</p>
                </div>
                <div class="icon">
                  <i class="ion ion-stats-bars"></i>
                </div>

              </div>
            </div><!-- ./col -->
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-yellow">
                <div class="inner">
                  <?php   $link = mysqli_connect(HNAME,USER,PWD,DBNAME);
	$query = "select * from tbl_program";
	$result = mysqli_query($link,$query);
	$rec= mysqli_num_rows($result); ?>
                 
                  <h3><?php echo $rec; ?></h3>
                  <p>Programs</p>
                </div>
                <div class="icon">
                  <i class="ion ion-person-add"></i>
                </div>

              </div>
            </div><!-- ./col -->
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-red">
                <div class="inner">
                 <?php   $link = mysqli_connect(HNAME,USER,PWD,DBNAME);
	$query = "select * from tbl_advertisement";
	$result = mysqli_query($link,$query);
	$rec= mysqli_num_rows($result); ?>
                 
                  <h3><?php echo $rec; ?></h3>
                  <p>Advertisements</p>
                </div>
                <div class="icon">
                  <i class="ion ion-pie-graph"></i>
                </div>

              </div>
            </div><!-- ./col -->
          </div>
			
							</section><!--wrapper -->
      </section><!-- /MAIN CONTENT -->

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

  </script>

  </body>
</html>
