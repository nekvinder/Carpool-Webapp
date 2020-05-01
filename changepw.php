<?php
require_once 'conn.php';
 if(!isset( $_SESSION['user'] ) ) {
	alert("Please Login First");
	redirect('login.php');
	exit();
 }

if(!empty($_POST["oldpass"])) {
    $sql = "SELECT * FROM login where uname='" . $_SESSION["user"] . "' and password='" . $_POST["password"] . "'";
    $stmt = $pdo->query($sql);
    if ($row = $stmt->fetch() > 0) {
        $_SESSION['user']=$_POST['uname'];
        redirect("dashboard.php");
    }


    $sql = "update login set password=? where id=? and password=?";
    try {
        $stmt=$pdo->prepare($sql);
        $ins= $stmt->execute([$_POST["password"],$_POST["id"],$_POST['oldpass']]);
        if($ins)
        {
            AddNoti($pdo,"Password changed",$id);
            redirect("changepw.php?msg=Updated%20Successfully");
        }else{
            redirect("changepw.php?msg=Incorrect old password");
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
    <title>Change password</title>
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
        if(!empty($_GET["msg"])) {alert($_GET['msg']);}
        if(!empty($_GET["error"])) {alert($_GET['error']);}
        include 'leftpanel.php' ;
    ?>
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
                    <form id="main-contact-form" class="contact-form" name="contact-form" method="post" action="changepw.php">
                    <div class="col-sm-9 col-sm-offset-1">
                        <div class="form-group">
                            <input type="hidden" name="id" value="<?php echo $xrow['id']; ?>" class="form-control" required="required">

                            <label>Old Password*</label><input type="password" name="oldpass" value="" class="form-control" required="required">
                        </div>
                        <div class="form-group">
                            <label>New Password *</label><input type="password" name="password1" class="form-control" required="required">
                        </div>
                        <div class="form-group">
                            <label>Confirm New Password *</label><input type="password" name="password" class="form-control" required="required">
                        </div>
                       
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
