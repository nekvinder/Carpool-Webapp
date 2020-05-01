<?php
require_once 'conn.php';
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Login or sign up</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" href="css/font-awesome.min.css">
	<link rel="stylesheet" href="css/animate.css">
    <link rel="shortcut icon" href="favicon.ico">
	<link href="css/animate.min.css" rel="stylesheet"> 
	<link href="css/style.css" rel="stylesheet" />	
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>	
  	 <?php if(!empty($_GET["msg"])) {alert($_GET['msg']);} ?>
	<header id="header">
        <nav class="navbar navbar-default navbar-static-top" role="banner">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                   <div class="navbar-brand">
						<a href="index.php">
							<img src="img/logo.jpg" class="headinglogo" alt="School logo"  align="left" />	
						</a>
					</div>
                </div>				
                <div class="navbar-collapse collapse">							
					<div class="menu">
						<ul class="nav nav-tabs" role="tablist">
							<li role="presentation"><a href="#" class="active">Home</a></li>
							<li role="presentation"><a href="about.html">About Us</a></li>
							<li role="presentation"><a href="contact.php" ">Contact</a></li>						
						</ul>
					</div>
				</div>		
            </div><!--/.container-->
        </nav><!--/nav-->		
    </header><!--/header-->	
	
	<div class="slider">		
		<div id="about-slider">
			<div id="carousel-slider" class="carousel slide" data-ride="carousel">
				<!-- Indicators -->
				<ol class="carousel-indicators visible-xs">
					<li data-target="#carousel-slider" data-slide-to="0" class="active"></li>
					<li data-target="#carousel-slider" data-slide-to="1"></li>
					<li data-target="#carousel-slider" data-slide-to="2"></li>
				</ol>

				<div class="carousel-inner">
					<div class="item active">						
						<img src="img/school.png" class="img-responsive" alt=""> 
						<div class="carousel-caption">
							<div class="wow fadeInUp" data-wow-offset="0" data-wow-delay="0.3s">								
								<h2><span>My Carpool</span></h2>
							</div>
							<div class="col-md-10 col-md-offset-1">
								<div class="wow fadeInUp" data-wow-offset="0" data-wow-delay="0.6s">								
									<p>Convenient way to reach the school</p>
								</div>
							</div>
							<div class="wow fadeInUp" data-wow-offset="0" data-wow-delay="0.9s">								
								<form class="form-inline">
									<div class="form-group">
							
										<button type="livedemo" name="Live Demo" class="btn btn-primary btn-lg" formaction="signup.php" required="required">Sign Up</button>
										
									</div>
									<div class="form-group">
										
										<button type="getnow" name="Get Now" class="btn btn-primary btn-lg" formaction="login.php" required="required">Login</button>
									
									</div>
								</form>
							</div>
						</div>
				    </div>
			
				    <div class="item">
						<img src="img/school.png" class="img-responsive" alt=""> 
						<div class="carousel-caption">
							<div class="wow fadeInUp" data-wow-offset="0" data-wow-delay="1.0s">								
								<h2>My Carpool</h2>
							</div>
							<div class="col-md-10 col-md-offset-1">
								<div class="wow fadeInUp" data-wow-offset="0" data-wow-delay="0.6s">								
									<p>Save the fuel for the future</p>
								</div>
							</div>
							<div class="wow fadeInUp" data-wow-offset="0" data-wow-delay="1.6s">								
								<form class="form-inline">
									<div class="form-group">
										
										<button type="livedemo" name="purchase" class="btn btn-primary btn-lg" formaction="signup.php"required="required">Sign Up</button>
									
									</div>
									<div class="form-group">
									
										<button type="getnow" name="subscribe" class="btn btn-primary btn-lg" formaction="login.php"required="required">Login </button>
									
									</div>
								</form>
							</div>
						</div>
				    </div> 
				    <div class="item">
						<img src="img/school.png" class="img-responsive" alt=""> 
						<div class="carousel-caption">
							<div class="wow fadeInUp" data-wow-offset="0" data-wow-delay="0.3s">								
								<h2>My Carpool</h2>
							</div>
							<div class="col-md-10 col-md-offset-1">
								<div class="wow fadeInUp" data-wow-offset="0" data-wow-delay="0.6s">								
									<p>Ensure the safety of your ward</p>
								</div>
							</div>
							<div class="wow fadeInUp" data-wow-offset="0" data-wow-delay="0.9s">								
								<form class="form-inline">
									<div class="form-group">
										
										<button type="livedemo" name="purchase" class="btn btn-primary btn-lg" formaction="signup.php" required="required" >Sign Up</button>
									
									</div>
									<div class="form-group">
										
										<a href="login.php"><button type="getnow" name="subscribe" class="btn btn-primary btn-lg" formaction="login.php" required="required">Login</button>
										</a>
									</div>
								</form>
							</div>
						</div>
				    </div> 
				</div>
				
				<a class="left carousel-control hidden-xs" href="#carousel-slider" data-slide="prev">
					<i class="fa fa-angle-left"></i> 
				</a>
				
				<a class=" right carousel-control hidden-xs"href="#carousel-slider" data-slide="next">
					<i class="fa fa-angle-right"></i> 
				</a>
			</div> <!--/#carousel-slider-->
		</div><!--/#about-slider-->
	</div><!--/#slider-->
	


	
	
	
		
	<footer>
		<div class="container">
			<div class="col-md-9 wow fadeInDown" data-wow-duration="1000ms" data-wow-delay="300ms">
				<h4>About Us</h4>
				<p>My carpool is the official carpool application of jayshree periwal International School, Jaipur.</p>						
				<div class="contact-info">
					<ul>
						<li><i class="fa fa-home fa"></i>School Address, Jaipur</li>
						<li><i class="fa fa-phone fa"></i> 0000-99999999</li>
						<li><i class="fa fa-envelope fa"></i> CarpoolAdmin@school.com</li>
					</ul>
				</div>
			</div>
			
			
			
			
	</footer>
	<div class="sub-footer">
		<div class="container">
			
			
							
		</div>				
	</div>
	  <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
	  <script src="js/jquery.js"></script>        
	  <!-- Include all compiled plugins (below), or include individual files as needed -->
	  <script src="js/bootstrap.min.js"></script> 
      <script src="js/wow.min.js"></script>
      <script>
      wow = new WOW(
       {
      
          }   ) 
          .init();
      </script>   
	
	
				
  </body>
</html>