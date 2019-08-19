<?php
  include 'insert.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>Sign Up</title>
  <!-- Bootstrap core CSS -->
  <link href="lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <!-- Custom styles for this template -->
  <link href="css/scrolling-nav.css" rel="stylesheet">
  <style type="text/css">
    .error {color: #FF0000;}
  </style>
</head>

<body id="page-top">
  <!-- Navigation -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="mainNav">
    <div class="container"> <a class="navbar-brand js-scroll-trigger" href="#page-top">Media Advertisement Scheduler</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation"> <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item"> <a class="nav-link js-scroll-trigger" href="index.php">Home</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <section id="about">
    <div class="container">
      <div class="row">
        <div class="col-lg-5 mx-auto">
          <!-- Default form register -->

          <form class="text-center border border-default p-5" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data">  
            <p class="h4 mb-4">Sign up</p>
            <!-- Name -->
            <small class="error"><?php echo $nameErr;?></small>
            <input type="text" name="name" value= "<?php echo $name;?>" id="defaultRegisterFormEmail" class="form-control mb-4" placeholder="Full Name"> 
            <!-- Company Name -->
            <small><span class="error"> <?php echo $cnameErr;?></span></small>
            <input type="text" name="c_name" value= "<?php echo $company_name;?>" id="defaultRegisterFormEmail" class="form-control mb-4" placeholder="Company Name">
            <!-- Address -->
            <small><span class="error"> <?php echo $addressErr;?></span></small>
            <input type="text" name="address" value= "<?php echo $address;?>" id="defaultRegisterFormEmail" class="form-control mb-4" placeholder="Address">
            <!-- Phone -->
            <small><span class="error"> <?php echo $phoneErr;?></span></small>
            <input type="text" name="phone" value= "<?php echo $phone;?>" id="defaultRegisterFormEmail" class="form-control mb-4" placeholder="Phone Number">
            <!-- Email Id -->
            <small><span class="error"> <?php echo $emailErr;?></span></small>
            <input type="email" name="email" value= "<?php echo $email;?>" id="defaultRegisterFormEmail" class="form-control mb-4" placeholder="E-mail">
            <!-- Pan Number -->
            <small><span class="error"> <?php echo $panErr;?></span></small>
            <input type="text" name="pan" value= "<?php echo $pan;?>" id="defaultRegisterFormEmail" class="form-control mb-4" placeholder="Pan Number">
            <!-- Upload file -->
            <label>Upload image file of PAN Card</label>
            <input type="file" name="fileToUpload" id="fileToUpload">
            <!-- Sign up button -->
            <button class="btn btn-info my-4 btn-block" type="submit" name="register">Sign Up</button>
            <!-- Terms of service -->
            <p>By clicking <em>Sign up</em> you agree to our <a href="" target="_blank">terms of service</a>
          </form>
          <!-- Default form register -->
        </div>
      </div>
    </div>
  </section>
  <!-- Footer -->
  <footer class="py-5 bg-dark">
    <div class="container">
      <p class="m-0 text-center text-white">Copyright &copy; <strong>G4</strong>. All Rights Reserved</p>
    </div>
    <!-- /.container -->
  </footer>
  <!-- Bootstrap core JavaScript -->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- Plugin JavaScript -->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
  <!-- Custom JavaScript for this theme -->
  <script src="js/scrolling-nav.js"></script>
</body>

</html>