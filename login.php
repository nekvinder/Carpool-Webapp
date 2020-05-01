<?php
require_once 'conn.php';

if($_SERVER["REQUEST_METHOD"] == "POST"){
	//echo $_POST["uname"];
	//echo $_POST["password"];
	if(!empty($_POST["uname"]) && !empty($_POST["password"])){
        $sql = "SELECT * FROM login where uname='" . $_POST["uname"] . "' and password='" . $_POST["password"] . "'";
		$stmt = $pdo->query($sql);
		if ($row = $stmt->fetch() > 0) {
			$_SESSION['user']=$_POST['uname'];
            //$_SESSION['loginid']=$row['id'];
			redirect("dashboard.php");
		}else{
            redirect("login.php?msg=Not%20Registered");
        }
	}
}

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Login</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="shortcut icon" href="favicon.ico">
	<link rel="stylesheet" href="css/animate.css">
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
	
	
	
	<section class="contact-page">
        <div class="container">
            <div class="text-center">        
                <h2>Login</h2>
            
            </div> 
            <div class="row contact-wrap"> 
                <div class="status alert alert-success" style="display: none"></div>
                <form id="main-contact-form" class="contact-form" name="contact-form" method="post" action="login.php">
                    <div class="col-sm-8 col-sm-offset-1">
                        <div class="form-group">
                            <label>Username *</label>
                            <input type="text" name="uname" class="form-control" required="required">
                        </div>
                        <div class="form-group">
                            <label>Password *</br></label>
                            <input type="password" name="password" class="form-control" required="required">
                        </div>
                        <div class="form group">
                            <a href="forgotpw.php" class="blue"><i><strong> Password Forgot ?</strong></i></br></a>

                        </div>
                        <div class="form-group">
                            <button type="submit" name="submit" class="btn btn-primary btn-lg" required="required">Enter</button>
                        </div>
                                           
                    </div>
                   
                </form> 
            </div><!--/.row-->
        </div><!--/.container-->
    </section><!--/#contact-page-->
	
	
	<footer>
		<div class="container">
			<div class="col-md-4 wow fadeInDown" data-wow-duration="1000ms" data-wow-delay="300ms">
				<h4>About Us</h4>
				<p></p>						
				<div class="contact-info">
					<ul>
						<li><i class="fa fa-home fa"></i>Jayshree Periwal International School,Mahapura - SEZ Road, Ajmer Road, Jaipur </li>
						<li><i class="fa fa-phone fa"></i> 0141-2726576</li>
						<li><i class="fa fa-envelope fa"></i> MyCarpool@jpischool.com</li>
					</ul>
				</div>
			</div>
			
			
			
			</div>			
		</div>	
	</footer>
	
	
  </body>
</html>
