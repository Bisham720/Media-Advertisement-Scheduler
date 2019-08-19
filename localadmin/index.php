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
<!DOCTYPE html>
<html>
<head>
	<title>Home</title>
    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>      
<nav class="navbar navbar-dark bg-dark">
  <a class="navbar-brand" style="color: #FFFFFF">Welcome Admin</a>
  <a href="index.php?logout='1'"><button type="button" class="btn btn-danger">Logout</button></a>
</nav>
<br>
<ul class="nav nav-tabs">
  <li class="nav-item">
    <a class="nav-link" href="currentusers.php">Current User</a>
  </li>
  <li class="nav-item">
    <a class="nav-link active" href="index.php">Pending Requests</a>
  </li>
</ul>
<br>
  
  <table class="table">
  <thead class="thead-dark">
    <tr>
      <th scope="col">Id</th>
      <th scope="col">Name</th>
      <th scope="col">Company Name</th>
      <th scope="col">Address</th>
      <th scope="col">Phone</th>
      <th scope="col">Email Address</th>
      <th scope="col">Status</th>
      <th scope="col">Details</th>
    </tr>
<?php
  $sql = "SELECT * FROM tbl_registration where u_status = 'pending'";
  $result = mysqli_query($db, $sql);
  if (mysqli_num_rows($result) > 0) {
?>          
  </thead>
<?php
  while($row = mysqli_fetch_array($result)){
?>    
 <tbody>
    <tr>
      <th scope="row"><?php echo $row['u_id']?></th>
      <td><?php echo $row['u_fullname']?></td>
      <td><?php echo $row['u_companyname']?></td>
      <td><?php echo $row['u_address']?></td>
      <td><?php echo $row['u_phone']?></td>
      <td><?php echo $row['u_email']?></td>
      <td><?php echo $row['u_status']?></td>
      <td><a href="viewselecteduser.php?id=<?php echo $row['u_id'];?>"><button type="button" class="btn btn-primary">View Details</button></a></td>
    </tr>
  </tbody>
<?php
    }
    ?>
</table>

<?php
    
  }
  else{

      echo "<span class='badge badge-danger'>There are no pending request.</span>";
    }

?>

</body>
</html>