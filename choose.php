<?php
require_once 'conn.php';
 if(!isset( $_SESSION['user'] ) ) {
	alert("Please Login First");
	redirect('login.php');
	exit();
 }


$sql = "SELECT * FROM login where login.uname='" . $_SESSION['user'] . "';";
//die($sql);
$stmt = $pdo->query($sql);
$xrow = $stmt->fetch();
if($xrow['acctype']!=0)
{
    redirect("dashboard.php");
}


if(!empty($_GET["id"]) && !empty($_GET["acctype"])){

    $sql = "update login set acctype=? where id=?";
    try {
        $stmt=$pdo->prepare($sql);
        $ins= $stmt->execute([$_GET["acctype"],$_GET["id"]]);
        if($ins)
        {
            redirect("dashboard.php?msg=Account Type Selection Successful");
        }
    } catch (PDOException $e) {
        die($e->getMessage());
    }
    
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
    <title>Carpool System</title>
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
                        <h1>Account Type Selection-<?php echo $_SESSION['user'] ?></h1>
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
                                <strong>Select Your Account Type</strong> 
                            </div>
                        </div>
                    <div class="col-sm-9 col-sm-offset-1">
                            <input type="hidden" name="id" value="<?php echo $xrow['id']; ?>" class="form-control" required="required">
                            <a href="choose.php?id=<?php echo $xrow['id']; ?>&acctype=1"><button name="submit" class="btn btn-primary btn-lg">Be a Host</button>
                            </a>
                            <a href="choose.php?id=<?php echo $xrow['id']; ?>&acctype=2"><button name="submit" class="btn btn-primary btn-lg">Be a Rider</button>
                            </a>
                            
                    </div>
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
