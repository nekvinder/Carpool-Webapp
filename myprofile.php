<?php
require_once 'conn.php';
 if(!isset( $_SESSION['user'] ) ) {
	alert("Please Login First");
	redirect('login.php');
	exit();
 }





if(!empty($_POST["name"]) && !empty($_POST["email"])){
        
    if (strpos($_POST["wEmail"], '@jpischool.com') == false) {
        redirect("myprofile.php?error=Only Email-ID at jpischool.com are accepted to register the user. Please Try again.");
    }


    $sql = "update login set email=?,uname=?,wardemail=?,address=?,pincode=? where id=?";
    try {
        $stmt=$pdo->prepare($sql);
        $ins= $stmt->execute([$_POST["email"],$_POST["name"],$_POST["wEmail"],$_POST["address"],$_POST["pincode"],$_POST['id']]);
        if($ins)
        {
            $_SESSION['user']=$_POST['name'];
            redirect("myprofile.php?msg=Updated%20Successfully");
        }
    } catch (PDOException $e) {
        die($e->getMessage());
    }
        
}else{
    $sql = "SELECT * FROM login where login.uname='" . $_SESSION['user'] . "';";
    //die($sql);
    $stmt = $pdo->query($sql);
    $xrow = $stmt->fetch();
}

?>
<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang=""> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Your Profile</title>
    <meta name="description" content="Carpool">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="apple-touch-icon" href="apple-icon.png">
    <link rel="shortcut icon" href="favicon.ico">

    <link rel="stylesheet" href="assets/css/normalize.css">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/themify-icons.css">
    <link rel="stylesheet" href="assets/css/flag-icon.min.css">
    <link rel="stylesheet" href="assets/css/cs-skin-elastic.css">
    <!-- <link rel="stylesheet" href="assets/css/bootstrap-select.less"> -->
    <link rel="stylesheet" href="assets/scss/style.css">
    <link rel="stylesheet" href="assets/css/lib/chosen/chosen.min.css">

    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>

    <!-- <script type="text/javascript" src="https://cdn.jsdelivr.net/html5shiv/3.7.3/html5shiv.min.js"></script> -->

</head>
<body>
    <?php
        if(!empty($_GET["msg"])) {
            alert($_GET['msg']);
        }
        if(!empty($_GET["error"])) {
            alert($_GET['error']);
        }
    ?>
    <?php include 'leftpanel.php' ?>

    <!-- Right Panel -->

    <div id="right-panel" class="right-panel">

        <!-- Header-->
        <header id="header" class="header">

            <div class="header-menu">

                <div class="col-sm-7">
                    <a id="menuToggle" class="menutoggle pull-left"><i class="fa fa fa-tasks"></i></a>
                    <div class="header-left">
                </div>
            </div>

        </header><!-- /header -->
        <!-- Header-->

        <div class="breadcrumbs">
            <div class="col-sm-8">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>Profile View-<?php echo $_SESSION['user'] ?></h1>
                    </div>
                </div>
            </div>
            
        </div>

        <div class="content mt-5">
            <div class="animated fadeIn">

                <div class="row">

                    <div class="col-xs-6 col-sm-10">
                        <div class="card">
                            <div class="card-header">
                                <strong>Personal Information</strong> 
                            </div>
                        </div>

                    <form id="main-contact-form" class="contact-form" name="contact-form" method="post" action="myprofile.php">
                    <div class="col-sm-9 col-sm-offset-1">
                        <div class="form-group">
                            <input type="hidden" name="id" value="<?php echo $xrow['id']; ?>" class="form-control" required="required">

                            <label>Username *</label>
                            <input type="text" name="name" value="<?php echo $xrow['uname']; ?>" class="form-control" required="required">
                        </div>
                        <div class="form-group">
                            <label>Email-ID *</label>
                            <input type="email" name="email" value="<?php echo $xrow['email']; ?>" class="form-control" required="required">
                        </div>
                        <div class="form-group">
                            <label>Ward's JPIS Email-ID *</label>
                            <input type="email" name="wEmail" value="<?php echo $xrow['wardemail']; ?>" class="form-control" required="required">
                        </div>
                        <div class="form-group">
                            <label>Address *</label>
                            <input type="text" name="address" value="<?php echo $xrow['address']; ?>" class="form-control" required="required">
                        </div>
                        <div class="form-group">
                            <label>Phone *</label>
                            <input type="text" name="phone" value="<?php echo $xrow['phone']; ?>" class="form-control" required="required">
                        </div>
                        <div class="form-group">
                            <label>Pincode *</label>
                            <input type="text" name="pincode" value="<?php echo $xrow['pincode']; ?>" class="form-control" required="required">
                        </div>
                        <!--<div class="form-group">
                            <label>Number of kids *</label>
                            <input type="text" name="NoOfKids" value="<?php echo $xrow['numkids']; ?>" class="form-control" required="required">
                        </div>
                        <div class="form-group">
                            <label>Type of car *</label></br>
                        <input type="radio" name="cartype" value="1" <?php echo ($xrow['cartype']==1?'checked':''); ?> > Sedan<br>
                        <input type="radio" name="cartype" value="2" <?php echo ($xrow['cartype']==2?'checked':''); ?> > SUV<br>
                        <input type="radio" name="cartype" value="3" <?php echo ($xrow['cartype']==3?'checked':''); ?> > Other<br>
                        </div>
                       -->
                        <div class="form-group">
                            <button type="submit" name="submit" class="btn btn-primary btn-lg" required="required">Update</button>
                        </div>
                                           
                    </div>
                   
                </form>                     

                   
                    </div>


                    </div>

                </div>



            </div><!-- .animated -->
        </div><!-- .content -->


    </div><!-- /#right-panel -->

    <!-- Right Panel -->


    <script src="assets/js/vendor/jquery-2.1.4.min.js"></script>
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/plugins.js"></script>
    <script src="assets/js/main.js"></script>
    <script src="assets/js/lib/chosen/chosen.jquery.min.js"></script>

    <script>
        jQuery(document).ready(function() {
            jQuery(".standardSelect").chosen({
                disable_search_threshold: 10,
                no_results_text: "Oops, nothing found!",
                width: "100%"
            });
        });
    </script>

</body>
</html>
