<?php
require_once 'conn.php';
 if(!isset( $_SESSION['user'] ) ) {
	alert("Please Login First");
	redirect('login.php');
	exit();
 }



if(!empty($_GET["notiread"]) ){
    $sql = "update notifi set viewed=1 where nid=?";
    try {
        $stmt=$pdo->prepare($sql);
        $ins= $stmt->execute([$_GET["notiread"]]);
        if($ins)
        {
            redirect("dashboard.php");
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
    <title>Dashboard of Carpool System</title>
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
    <link rel="stylesheet" href="calendar/calendar.css">
    <link rel="stylesheet" href="assets/css/lib/chosen/chosen.min.css">
    
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>

    <!-- <script type="text/javascript" src="https://cdn.jsdelivr.net/html5shiv/3.7.3/html5shiv.min.js"></script> -->

</head>
<body>
    <?php if(!empty($_GET["msg"])) {alert($_GET['msg']);} ?>
    <?php include 'leftpanel.php' ?>

    <!-- Right Panel -->

    <div id="right-panel" class="right-panel">

        <!-- Header-->
        <header id="header" class="header">

            <div class="header-menu">

                <div class="col-sm-1">
                    <a id="menuToggle" class="menutoggle pull-left"><i class="fa fa fa-tasks"></i></a>
                    <div class="header-left">
                        <div class="dropdown for-notification">
                          <button class="btn btn-secondary dropdown-toggle" type="button" id="notification" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-bell"></i>
                            <span class="count bg-danger"><?php echo NotiCount($pdo) ?></span>
                          </button>
                          <div class="dropdown-menu" aria-labelledby="notification">
                            <p class="red"><?php echo NotiCount($pdo) ?> New Notifications</p>

                            <?php
                                $sql = "SELECT * FROM login JOIN notifi on login.id = notifi.lid where viewed=0 and login.uname='" . $_SESSION['user'] . "';";
                                //die($sql);
                                $stmt = $pdo->query($sql);
                                while ($xrow = $stmt->fetch()) {
                            ?>
                            <a class="dropdown-item media bg-flat-color-5" href="dashboard.php?notiread=<?php echo($xrow['nid']); ?>">
                                <i class="fa fa-warning"></i>
                                <p><?php echo($xrow['textx']); ?></p>
                            </a>
                            <?php
                                   }
                            ?>
                          </div>
                        </div>
                </div>
                
            </div>

        </header><!-- /header -->
        <!-- Header-->

        <div class="breadcrumbs">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>Dashboard</h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="page-header float-right">
                    <div class="page-title">
                        <ol class="breadcrumb text-right">
                          <h5>Welcome <?php echo $_SESSION['user'] ?></h5>
                            
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="content mt-3">
            <div class="animated fadeIn">

                <div class="row">

                    




<div class="col-xs-8 col-sm-6" hidden="true">
    <div class="card">
        <div class="card-header">
            <strong class="card-title">Calendar:</strong>
            <div id="calendar"></div>
        </div>
    </div>
</div>                            
                            
                        </div>

                        <div class="card">
                            <div class="card-header">
                                <strong class="card-title">Requests</strong>
                                <ul>
<?php 
    $sql = "SELECT * FROM Request where acpt=0 and toid=" . GetAccId($pdo) . ";";
    $stmt = $pdo->query($sql);$tmpcnt=0;
    while($xrow = $stmt->fetch()){
        $tmpcnt=1;
?>                                    
<!--                                    <li class=""><?php echo GetAccName($pdo,$xrow['fromid']); ?> has requested to join your pool. <a href="" class="btn btn-sm btn-link float-right">Accept</a></li>-->
<?php       $sql = "SELECT * FROM login where login.id=" . $xrow['fromid'] . ";";
            $stmt = $pdo->query($sql);
            $urow = $stmt->fetch();

            ?>
            <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                        <div class="card">
                            <div class="card-header bg-flat-color-2">
                                <strong class="card-title text-light"><strong> <i class="fa fa-user"> </i> Requester : </strong><?php echo $urow['uname']; ?></strong>
                                <strong class="card-title text-light">
                                    <a href="acceptrequest.php?requestid=<?php echo $xrow['reqid'] ?>" style="float:right;color:yellow" class="btn btn-sm btn-link">Accept</a> </strong>
                            </div>
                            <div class="card-body text-white bg-primary">
                                <p class="card-text text-light">
<i class="fa fa-archive"> </i> Address : <?php echo $urow['address']; ?>
                                </p>
                            </div>
                            <div class="card-body text-white bg-primary">
                                <p class="card-text text-light">
<i class="fa fa-envelope-o"> </i> Phone : <?php echo $urow['phone']; ?>
                                </p>
                            </div>
                            <div class="card-body text-white bg-primary">
                                <p class="card-text text-light">
<i class="fa fa-calendar"> </i> Will Drive on : <?php echo str_replace("chk", "", $xrow['ondays']); ?>
                                </p>
                            </div>
                    </li>
            </ul>

<?php }if($tmpcnt==0){echo "No Requests Pending.";}?>

                                </ul>
                            </div>
                            <div class="card-bodu">
                                <table  class="table table-dark table-striped">
                                    <tr><th>Notifications Panel</th></tr>
                                    <?php 
$sql = "SELECT * FROM login JOIN notifi on login.id = notifi.lid where login.uname='" . $_SESSION['user'] . "' order by notifi.nid desc;";
                                            $stmt = $pdo->query($sql);
                                            while ($xrow = $stmt->fetch()) {
                                    ?>
                                    <tr ><th><a style="color:white;" >→<?php echo($xrow['textx']); ?></a></th></tr>
                                <?php } ?>
                                </table>
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
<!--    <script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.5.1/moment.min.js"></script>-->
    <script src="calendar/calendar.js"></script>

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
