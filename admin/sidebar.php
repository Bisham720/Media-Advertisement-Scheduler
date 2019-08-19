<?php $page =  basename($_SERVER['PHP_SELF']); 
//session_start();
?>
<aside>
          <div id="sidebar"  class="nav-collapse ">
              <!-- sidebar menu start-->
              <ul class="sidebar-menu" id="nav-accordion">
              
              	  <p class="centered"><span class="glyphicon glyphicon-film"></span></p>
              	  <h5 class="centered">M.A.S</h5>
                  <p class="centered"> Administrator Dashboard</p>
                   <li class="sub-menu">
                       <a <?php if($page=="index.php") echo "class='active'";?> href="index.php">
                          <i class="glyphicon glyphicon-list-alt"></i>
                          <span>Dashboard</span>
                      </a>
            
                  </li>
                  <?php if($_SESSION['usertype']=='director' || $_SESSION['usertype']=='admin') { ?>
                  <li class="sub-menu">
                       <a <?php if($page=="manageuser.php") echo "class='active'";?> href="manageuser.php">
                          <i class="glyphicon glyphicon-list-alt"></i>
                          <span>Manage User</span>
                      </a>
            
                  </li>
                  <?php } ?>
              	  	 <?php if($_SESSION['usertype']=='mexec') { ?>
                  <li class="mt">
                      <a <?php if($page=="managecompanies.php") echo "class='active'";?> href="managecompanies.php">
                          <i class="glyphicon glyphicon-list-alt"></i>
                          <span>Manage Companies</span>
                      </a>
                  </li>
				  <li class="mt">
                      <a <?php if($page=="manageprograms.php") echo "class='active'";?> href="manageprogram.php">
                          <i class="glyphicon glyphicon-list-alt"></i>
                          <span>Manage Programs</span>
                      </a>
                  </li>
                  
                   <li class="mt">
                      <a <?php if($page=="managead.php") echo "class='active'";?> href="managead.php">
                          <i class="glyphicon glyphicon-list-alt"></i>
                          <span>Manage Advertisements</span>
                      </a>
                  </li>

 					 <li class="mt">
                      <a <?php if($page=="managead_schedule.php") echo "class='active'";?> href="managead_schedule.php">
                          <i class="glyphicon glyphicon-list-alt"></i>
                          <span>Manage Ad. Schedule</span>
                      </a>
                  </li>
                  <?php } ?>
        <?php if($_SESSION['usertype']=='finance') { ?>
                  <li class="mt">
                      <a <?php if($page=="managebill.php") echo "class='active'";?> href="managebill.php">
                          <i class="glyphicon glyphicon-list-alt"></i>
                          <span>Manage Bills</span>
                      </a>
                  </li>
                  
                  <?php } ?>
                 

              </ul>
              <!-- sidebar menu end-->
          </div>
      </aside>