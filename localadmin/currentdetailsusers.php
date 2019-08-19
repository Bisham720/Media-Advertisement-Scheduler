<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <title>Home</title>
  </head>
  <body>
      <nav class="navbar navbar-dark bg-dark">
  <a class="navbar-brand" style="color: #FFFFFF">Welcome Admin</a>
  <a href="index.php?logout='1'"><button type="button" class="btn btn-danger">Logout</button></a>
</nav>
<br>
<?php 
  include_once("../includes/dbconnect.php");
  $db = mysqli_connect(HNAME,USER,PWD,DBNAME);

  session_start(); 

  if (!isset($_SESSION['username'])) {
    $_SESSION['msg'] = "You must log in first";
    header('location: login.php');
  }
  if (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['username']);
    header("location: login.php");
  }
?>

<?php

  $id = $_GET['id'];

  $sql = "SELECT * FROM tbl_registration where u_id = '$id'";
  $result = mysqli_query($db, $sql);
  if (mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_array($result)){
  ?>
  <div class="container">
  
    <div class="row">

      <!-- useless       -->
      <div class="col">
      </div>
        
      <!-- form -->
      <div class="col-6">
        <form action="approved.php" method="POST">

          <div class="form-group col-md-9">
            <input type="hidden" class="form-control" name="userid" value="<?php echo $row['u_id'] ?>">
          </div>
            
          <div class="form-group col-md-9">
            <label>Name</label>
            <input type="text" class="form-control" value="<?php echo $row['u_fullname'] ?>" disabled>
            <input type="hidden" class="form-control" name="name" value="<?php echo $row['u_fullname'] ?>">
          </div>

          <div class="form-group col-md-9">
            <label>Company Name</label>
            <input type="text" class="form-control" value="<?php echo $row['u_companyname'] ?>" disabled>
            <input type="hidden" class="form-control" name="companyname" value="<?php echo $row['u_companyname'] ?>">
          </div>

          <div class="form-group col-md-9">
            <label>Address</label>
            <input type="text" class="form-control" value="<?php echo $row['u_address'] ?>" disabled>
            <input type="hidden" class="form-control" name="address" value="<?php echo $row['u_address'] ?>" >
          </div>

          <div class="form-group col-md-9">
            <label>Phone</label>
            <input type="text" class="form-control" value="<?php echo $row['u_phone'] ?>" disabled>
            <input type="hidden" class="form-control" name="phone" value="<?php echo $row['u_phone'] ?>" >
          </div>

          <div class="form-group col-md-9">
            <label>Email Address</label>
            <input type="text" class="form-control" value="<?php echo $row['u_email'] ?>" disabled>
            <input type="hidden" class="form-control" name="email" value="<?php echo $row['u_email'] ?>" >
          </div>

          <div class="form-group col-md-9">
            <input type="hidden" class="form-control" name="status" value="<?php echo $row['u_status'] ?>" >
          </div>

          <div class="form-group col-md-9">
            <label>PAN Card Image</label>
            <?php
              echo "<img src='http://localhost/newproj/uploads/". $row['u_imagename']. "' style='width:375px ;height:475px'>";
            ?>

          </div>


          <div class="form-group col-md-9">

            <!-- Button trigger modal -->
            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModal">Cancel Subscription
            </button>

            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Cancel Subscription</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    Are You Sure?
                  </div>
                  <div class="modal-footer">
                     <button type="submit" name="reject" class="btn btn-danger">Yes</button> 
                     <button type="button" class="btn btn-primary" data-dismiss="modal">No</button>
                  </div>
                </div>
              </div>
            </div>
            <!-- Modal End -->

            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <a href="currentusers.php"><button type="button" class="btn btn-info">Back</button></a>
          </div>  
      
        </form>
      </div>

      <!-- useless -->
      <div class="col">
      </div>
    </div>
          
  </div>

  <?php    

  }  
}
?>


    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>

