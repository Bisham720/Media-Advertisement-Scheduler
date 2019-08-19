<?php

include_once("../includes/session.php");

include_once("../includes/dbconnect.php");

$sql = "select t1.*,t2.*,t3.*,t4.*,t2.start_date as sstart, t2.end_date as eend from tbl_advertisement_schedule as t1 join tbl_advertisement as t2 on t1.ad_id=t2.ad_id join tbl_program as t3 on t1.program_id=t3.program_id join tbl_company as t4 on t2.company_id=t4.company_id order by t3.program_id ASC";
$res = executequery($sql);
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
            <h3><i class="fa fa-angle-right"></i> Schedule Reports</h3>








            <div class="row mt">
                <div class="col-lg-12">
                    <div class="content-panel">


                        <section id="unseen">
                            <h2 style="display: none;" id="whileprint">Media Planning System</h2>
                            <hr id="whileprint2" style="display: none;" />
                            <table border="1" cellpadding="10px" cellspacing="0px" class="table table-bordered table-striped table-condensed">
                                <thead>
                                <tr>
                                    <th>S.N</th>
                                    <th>Program Title</th>
                                    <th>Ad Title</th>
                                    <th>Frequency X Duration = Time</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Company</th>
                                    <th>More Details</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $i = 0;
                                $pname = "";
                                $btn = 1;
                                ?>
                                <?php while($alldata=mysqli_fetch_assoc($res)) { ?>
                                    <?php
                                    if($pname==$alldata['pname']){
                                        $show = "-";
                                        $btn = 2;

                                    }else{
                                        $show = $alldata['pname'];
                                        $btn = 1;
                                    }
                                    $pname = $alldata['pname'];
                                    $i++;
                                    ?>
                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo $show;?></td>
                                    <td><?php echo $alldata['title'];?></td>
                                    <td><?php echo $alldata['frequency']." X ".$alldata['ad_duration_sec']." = ".$alldata['total_ad_duration'];?></td>
                                    <td><?php echo $alldata['sstart']; ?></td>
                                    <td><?php echo $alldata['eend']; ?></td>
                                    <td><?php echo $alldata['name']; ?></td>
                                    <td>
                                        <?php
                                        if($btn==1){
                                        ?>
                                        <a href="program_details.php?pid=<?php echo $alldata['program_id'];?>&pname=<?php echo $alldata['pname'];?>" class="btn btn-warning" style="height:25px; padding-top:1px;"><i class="fa fa-file"></i> &nbsp;Program Details</a>
                                        <?php
                                        }else{
                                            echo "-";
                                        }
                                        ?>
                                    </td>

                                </tr>
                                <?php
                                }
                                ?>

                                </tbody>
                            </table>

                        </section>
                        <button type="button" onclick="prntfn();" class="btn btn-default" style="margin-left: 20px;;"><i class="fa fa-print"></i>&nbsp;&nbsp;Print</button>
                        <br /><br />
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

function prntfn(){
    document.getElementById('whileprint').style.display = "block";
    document.getElementById('whileprint2').style.display = "block";
    var divToPrint=document.getElementById('nseen');

    var newWin=window.open('','Print-Window','width=1200,height=800');

    newWin.document.open();

    newWin.document.write('<html><body onload="window.print()">'+unseen.innerHTML+'</body></html>');

    newWin.document.close();
    document.getElementById('whileprint').style.display = "none";
    document.getElementById('whileprint2').style.display = "none";

}
</script>
</body>
</html>
