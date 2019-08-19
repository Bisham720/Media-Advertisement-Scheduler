<?php
include_once("../includes/session2.php");
include_once("../includes/dbconnect.php");

$sql = "SELECT SUM( tbl_billing.paid_amount ) AS final_paid, tbl_billing.company_id as ci, tbl_company.name AS cname FROM tbl_billing JOIN tbl_company ON tbl_billing.company_id=tbl_company.company_id GROUP BY tbl_company.company_id";
$paiddata2 = executequery($sql);
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
            <h3><i class="fa fa-angle-right"></i> Finance Reports</h3>








            <div class="row mt">
                <div class="col-lg-12">
                    <div class="content-panel">


                        <section id="unseen">
                            <h2 style="display: none;" id="whileprint">Media Planning System</h2>
                            <hr id="whileprint2" style="display: none;" />
                            <table border="1" cellpadding="10px" cellspacing="0px" class="table table-bordered table-striped table-condensed">
                                <thead>
                                <tr>

                                    <th>Company Name</th>
                                    <th>Ad Details
                                        <table border="1px" cellspacing="0px" style="width: 100%;" cellpadding="4px" class="table-bordered table-condensed">
                                            <tr>
                                                <th>Ad</th>
                                                <th>Program</th>
                                                <th>Cost</th>
                                            </tr>
                                            </table>
                                    </th>
                                    <th>Total Cost</th>
                                    <th>Total Paid</th>
                                    <th>Total Due</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $collection1 = 0;
                                $collection2 = 0;
                                $collection3 = 0;
                                while($ad=mysqli_fetch_assoc($paiddata2)) : ?>
                                    <tr>
                                        <?php
                                        $sql = "SELECT sum(final_cost) AS final_costing, tbl_company.company_id as ci FROM tbl_advertisement JOIN tbl_company ON tbl_advertisement.company_id = tbl_company.company_id JOIN tbl_advertisement_schedule ON tbl_advertisement_schedule.ad_id = tbl_advertisement.ad_id WHERE tbl_company.company_id='".$ad['ci']."' GROUP BY tbl_company.company_id";
                                        $alldata = executequery($sql);
                                        $costamt = 0;
                                        while($ppp=mysqli_fetch_assoc($alldata)) :
                                            $costamt = $ppp['final_costing'];
                                        endwhile;
                                        $collection1 = $collection1 + $costamt;
                                        $collection2 = $collection2 + $ad['final_paid'];
                                        $collection3 = $collection3 + intval($costamt) - intval($ad['final_paid']);
                                        ?>
                                        <td><?php echo $ad['cname'];?></td>
                                        <td style="padding: 0px;">
                                            <table border="1px" cellspacing="0px" style="width: 100%;" cellpadding="4px" class="table-bordered table-condensed">
                                            <?php
                                            $sql = "SELECT * FROM tbl_advertisement JOIN tbl_company ON tbl_advertisement.company_id = tbl_company.company_id JOIN tbl_advertisement_schedule ON tbl_advertisement_schedule.ad_id = tbl_advertisement.ad_id JOIN tbl_program ON tbl_program.program_id=tbl_advertisement_schedule.program_id WHERE tbl_company.company_id='".$ad['ci']."';";
                                            $alldata2 = executequery($sql);
                                            while($ppp2=mysqli_fetch_assoc($alldata2)) :
                                            ?>
                                            <tr>
                                                <td><?php echo $ppp2['title'];?></td>
                                                <td><?php echo $ppp2['pname'];?></td>
                                                <td><?php echo $ppp2['final_cost'];?></td>
                                            </tr>
                                            <?php
                                            endwhile;
                                            ?>
                                            </table>
                                        </td>
                                        <td><?php echo $costamt;?></td>
                                        <td><?php echo $ad['final_paid'];?></td>
                                        <td><?php echo (intval($costamt) - intval($ad['final_paid'])); ?></td>

                                    </tr>
                                <?php endwhile; ?>
                                <tr>
                                    <td><b>Grand Total</b></td>
                                    <td></td>
                                    <td><b><?php echo $collection1;?></b></td>
                                    <td><b><?php echo $collection2;?></b></td>
                                    <td><b><?php echo $collection3;?></b></td>
                                </tr>
                                </tbody>
                            </table>
                        </section>
                        <button type="button" onclick="prntfn();" class="btn btn-default" style="margin-left: 20px;"><i class="fa fa-print"></i>&nbsp;&nbsp;Print</button>
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
        var divToPrint=document.getElementById('unseen');

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
