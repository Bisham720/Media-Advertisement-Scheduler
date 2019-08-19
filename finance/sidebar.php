<?php $page =  basename($_SERVER['PHP_SELF']); 
//session_start();
?>
<aside>
          <div id="sidebar"  class="nav-collapse ">
              <!-- sidebar menu start-->
              <ul class="sidebar-menu" id="nav-accordion">
              
              	  <p class="centered"><span class="glyphicon glyphicon-film"></span></p>
              	  <h5 class="centered">M.A.S</h5>
                  <p class="centered"> Finance Dashboard</p>
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
              	  	 <?php if($_SESSION['usertype']=='mexec' || $_SESSION['usertype']=='admin') { ?>

                  <?php } ?>
        <?php if($_SESSION['usertype']=='finance' || $_SESSION['usertype']=='admin') { ?>
                  <li class="mt">
                      <a <?php if($page=="managebill.php") echo "class='active'";?> href="managebill.php">
                          <i class="glyphicon glyphicon-list-alt"></i>
                          <span>Manage Bills</span>
                      </a>
                  </li>
                  
                  <?php } ?>
                  <li class="sub-menu">
                      <a href="javascript:;" >
                          <i class=" fa fa-bar-chart-o"></i>
                          <span>Manage Reports</span>
                      </a>
                      <ul class="sub">
                         
                          <?php if($_SESSION['usertype']=='mexec' || $_SESSION['usertype']=='admin' ||  $_SESSION['usertype']=='director') { ?>
                          <li><a  href="s_reports.php">Schedule Reports</a></li>
                          <?php } ?>
                         <?php if($_SESSION['usertype']=='finance' || $_SESSION['usertype']=='admin' ||  $_SESSION['usertype']=='director') { ?>
                          <li><a  href="f_reports.php">Finance Reports</a></li>
                          <?php } ?>
                      </ul>
                  </li>

              </ul>
              <!-- sidebar menu end-->
          </div>
      </aside>