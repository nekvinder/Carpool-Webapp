<?php
require_once 'conn.php';
 if(!isset( $_SESSION['user'] ) ) {
    alert("Please Login First");
    redirect('login.php');
    exit();
 }
 
?>    <!-- Left Panel -->

    <aside id="left-panel" class="left-panel">
        <nav class="navbar navbar-expand-sm navbar-default">

            <div class="navbar-header">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main-menu" aria-controls="main-menu" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fa fa-bars"></i>
                </button>
                <a class="navbar-brand" href="./">Carpool System</a>
                <a class="navbar-brand hidden" href="./"><img src="images/logo2.png" alt="Logo"></a>
            </div>

            <div id="main-menu" class="main-menu collapse navbar-collapse">
                <ul class="nav navbar-nav" >
                    <li><a href="dashboard.php">Dashboard </a></li>
                    <h3 class="menu-title">Carpool</h3><!-- /.menu-title -->
<?php if(!isCurrentPartOfAny($pdo)){ ?>
                    <li ><a href="joincarpool.php">Join Carpool</a></li>
                    <li ><a href="createcarpool.php">Create Carpool</a></li>
<?php }else{ ?>

                    <li ><a onclick="alert('You are already part of a pool. Please leave that first.');">Join Carpool</a></li>
                    <li ><a onclick="alert('You are already part of a pool. Please leave that first.');">Create Carpool</a></li>
<?php } ?>
                    <!--<li><a href="searchcarpool.php"> Search Carpool </a></li>-->
                    <li ><a href="Mycarpool.php"> My Carpool</a></li>

                    <h3 class="menu-title">Profile</h3><!-- /.menu-title -->
                    <li><a href="myprofile.php">My profile </a></li>
                    <li><a href="changepw.php">Change Password</a></li>
                    <li><a href="logout.php"> Logout </a></li>
                </ul>
            </div><!-- /.navbar-collapse -->
        </nav>
    </aside><!-- /#left-panel -->

    <!-- Left Panel -->