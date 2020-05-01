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



$lid=GetAccId($pdo);


$sql="SELECT * FROM pools JOIN login on login.id=pools.createdlid where  pools.createdlid=".GetAccId($pdo).";";
$stmt = $pdo->query($sql);
$row = $stmt->fetch()

?>
<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang=""> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>My Carpool</title>
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
    <?php if(!empty($_GET["msg"])) {alert($_GET['msg']);} ?>
    <?php include 'leftpanel.php' ?>

    <!-- Right Panel -->

    <div id="right-panel" class="right-panel">

        <!-- Header-->
        <header id="header" class="header">

            <div class="header-menu">

                <div class="col-sm-7">
                    <a id="menuToggle" class="menutoggle pull-left"><i class="fa fa fa-tasks"></i></a>
                    <div class="header-left">
<!--					<button class="search-trigger"><i class="fa fa-search"></i></button>
                        <div class="form-inline">
                            <form class="search-form">
                                <input class="form-control mr-sm-2" type="text" placeholder="Search ..." aria-label="Search">
                                <button class="search-close" type="submit"><i class="fa fa-close"></i></button>
                            </form>
                        </div>
-->
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
                <div class="col-sm-5">

                </div>
            </div>

        </header><!-- /header -->
        <!-- Header-->

        <div class="breadcrumbs">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>Your Current Pool</h1>
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

                    <div class="col-xs-8 col-sm-11">
                        <div class="card">
                            <div class="card-header">
                                <strong>Carpool Information:</strong> 
                                    <div >
                                    <p>My carpool allows its user to join a carpool system in order to reach the school conveniently. However, a user can only be a part of one carpool system at a time.</p>
                                </div>
                            </div>
                           
    <div class="col-sm-11 col-sm-offset-1" <?php if(empty($row['name'])){echo 'hidden="true"';} ?>>
                        
    <br>
        <div class="col-md-7 " >
            <div class="card col-md-10">
                <div class="card-header bg-danger">
                 <strong class="card-title text-light"><i class="fa fa-group"></i> 
                    (Your) <?php echo $row['name']; ?> Pool  </strong>
                <span style="float:right;" class="confirmation">
                   <i class="fa fa-trash"></i> <a href="conn.php?return=delete" style="color:white;">Delete Pool</a>
                </span>
            </div>
            <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                        <a href="#"><strong> <i class="fa fa-user"> </i> Creater(You):</strong><?php echo $row['uname']; ?></a>
                    </li>
            </ul>
            <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                        <a href="#"><strong> <i class="fa fa-archive"></i> Address:</strong><?php echo $row['address']; ?></a>
                    </li>
            </ul>
            <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                        <a href="#"><strong><i class="fa fa-envelope-o"></i> PinCode:</strong><?php echo $row['pincode']; ?></a>
                    </li>
            </ul>
             <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                        <a href="#"><strong><i class="fa fa-phone"></i> Phone:</strong><?php echo $row['phone']; ?></a>
                    </li>
            </ul>

            </div>
        </div>     




<div class="col-xs-1 col-sm-6 float-right" style="height:380px" >
    <div class="card"  style="height:380px;top:-270px">
        <div class="card-header"  style="height:380px">
            <strong class="card-title">Calendar:</strong>
            <ul class="list-group list-group-flush"  style="height:200px">
                <li class="list-group-item">
                    <table style="font-size:20px;margin:1px" class="table bg-warning">
    <tr style="height:10px"><th colspan="2">Driven by:</th></tr>
    <tr style="height:10px;font-size: 12px;padding: 0px;"><th>Mon</th><td class="bg-flat-color-2"><?php echo GetAccName($pdo,$row['mon']); ?></td></tr>
    <tr style="height:20px;font-size: 12px;padding: 0px"><th>Tue</th><td class="bg-flat-color-2"><?php echo GetAccName($pdo,$row['tue']); ?></td></tr>
    <tr style="height:20px;font-size: 12px;padding: 0px"><th>Wed</th><td class="bg-flat-color-2"><?php echo GetAccName($pdo,$row['wed']); ?></td></tr>
    <tr style="height:20px;font-size: 12px;padding: 0px"><th>Thu</th><td class="bg-flat-color-2"><?php echo GetAccName($pdo,$row['thu']); ?></td></tr>
    <tr style="height:20px;font-size: 12px;padding: 0px"><th>Fri</th><td class="bg-flat-color-2"><?php echo GetAccName($pdo,$row['fri']); ?></td></tr>
    <tr style="height:20px;font-size: 12px;padding: 0px"><th>Sat</th><td class="bg-flat-color-2"><?php echo GetAccName($pdo,$row['sat']); ?></td></tr>
                    </table>
                </li>
            </ul>
        </div>
    </div>
</div>                            








    <div class="col-md-7" style="top:-380px">
            <div class="card col-md-14">
                <div class="card-header bg-danger">
                 <strong class="card-title text-light"><i class="fa fa-group"></i> 
<?php echo $row['name']; ?> Participants </strong>
            </div>
<?php
    $arr=explode(",", $row['bookedbyid']);
    if($arr[0]>0)
    {
        for($i=0;$i<count($arr);$i++)
        {
            $sql = "SELECT * FROM login where login.id=" . $arr[$i] . ";";
            $stmt = $pdo->query($sql);
            $xrow = $stmt->fetch();

            ?>
            <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                        <div class="card">
                            <div class="card-header bg-flat-color-2">
                                <strong class="card-title text-light"><strong> <i class="fa fa-user"> </i> Participant <?php echo $i+1 ;?>: </strong><?php echo $xrow['uname']; ?></strong>
                            </div>
                            <div class="card-body text-white bg-primary">
                                <p class="card-text text-light">
<i class="fa fa-archive"> </i> Address : <?php echo $xrow['address']; ?>
                                </p>
                            </div>
                            <div class="card-body text-white bg-primary">
                                <p class="card-text text-light">
<i class="fa fa-envelope-o"> </i> Phone : <?php echo $xrow['phone']; ?>
                                </p>
                            </div>
                    </li>
            </ul>

<?php        }
    }else{
        echo 'No Participants';
    }

?>

          

            </div>
        </div>  
    </div>



<!----------------------------------------------------rider carpool----------------------------------------------------------------->
<?php 
$sql="SELECT * FROM pools JOIN login on login.id=pools.createdlid where  pools.bookedbyid like '%".GetAccId($pdo)."%';";
$stmt = $pdo->query($sql);
$row = $stmt->fetch()
?>
 <div class="col-sm-11 col-sm-offset-1" <?php if(empty($row['name'])){echo 'hidden="true"';} ?>>
                        
    <br>
        <div class="col-md-6 " >
            <div class="card col-md-11">
                <div class="card-header bg-danger">
                 <strong class="card-title text-light"><i class="fa fa-group"></i> 
                    <?php echo $row['name']; ?>'s Pool  </strong>
                    <span style="float:right;" class="confirmation">
                       <i class="fa fa-trash"></i> <a href="conn.php?return=mycarpool" style="color:white;">Leave Pool</a>
                    </span>
            </div>
            <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                        <a href="#"><strong> <i class="fa fa-user"> </i> Creater:</strong><?php echo $row['uname']; ?></a>
                    </li>
            </ul>
            <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                        <a href="#"><strong> <i class="fa fa-archive"></i> Address:</strong><?php echo $row['address']; ?></a>
                    </li>
            </ul>
            <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                        <a href="#"><strong><i class="fa fa-envelope-o"></i> PinCode:</strong><?php echo $row['pincode']; ?></a>
                    </li>
            </ul>
            <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                        <a href="#"><strong><i class="fa fa-phone"></i> Phone:</strong><?php echo $row['phone']; ?></a>
                    </li>
            </ul>
                 

            </div>
        </div>      
<div class="col-xs-2 col-sm-6" style="height:380px" >
    <div class="card"  style="height:380px">
        <div class="card-header"  style="height:380px">
            <strong class="card-title">Calendar:</strong>
            <ul class="list-group list-group-flush"  style="height:200px">
                <li class="list-group-item">
                    <table style="font-size:20px;margin:1px" class="table bg-warning">
    <tr style="height:10px"><th colspan="2">Driven by:</th></tr>
    <tr style="height:10px;font-size: 12px;padding: 0px;"><th>Mon</th><td class="bg-flat-color-2"><?php echo GetAccName($pdo,$row['mon']); ?></td></tr>
    <tr style="height:20px;font-size: 12px;padding: 0px"><th>Tue</th><td class="bg-flat-color-2"><?php echo GetAccName($pdo,$row['tue']); ?></td></tr>
    <tr style="height:20px;font-size: 12px;padding: 0px"><th>Wed</th><td class="bg-flat-color-2"><?php echo GetAccName($pdo,$row['wed']); ?></td></tr>
    <tr style="height:20px;font-size: 12px;padding: 0px"><th>Thu</th><td class="bg-flat-color-2"><?php echo GetAccName($pdo,$row['thu']); ?></td></tr>
    <tr style="height:20px;font-size: 12px;padding: 0px"><th>Fri</th><td class="bg-flat-color-2"><?php echo GetAccName($pdo,$row['fri']); ?></td></tr>
    <tr style="height:20px;font-size: 12px;padding: 0px"><th>Sat</th><td class="bg-flat-color-2"><?php echo GetAccName($pdo,$row['sat']); ?></td></tr>
                    </table>
                </li>
            </ul>
        </div>
    </div>
</div>                            


    <div class="col-md-6">
            <div class="card col-md-14">
                <div class="card-header bg-danger">
                 <strong class="card-title text-light"><i class="fa fa-group"></i> 
<?php echo $row['name']; ?>'s Participants </strong>
            </div>
<?php
    $arr=explode(",", $row['bookedbyid']);
    if($arr[0]>0)
    {
        for($i=0;$i<count($arr);$i++)
        {
            $sql = "SELECT * FROM login where login.id=" . $arr[$i] . ";";
            $stmt = $pdo->query($sql);
            $xrow = $stmt->fetch();

            ?>
            <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                        <div class="card">
                            <div class="card-header bg-flat-color-2">
                                <strong class="card-title text-light"><strong> <i class="fa fa-user"> </i> Participant <?php echo $i+1 ;?>: </strong><?php echo $xrow['uname']; ?></strong>
                            </div>
                            <div class="card-body text-white bg-primary">
                                <p class="card-text text-light">
<i class="fa fa-archive"> </i> Address : <?php echo $xrow['address']; ?>
                                </p>
                            </div>
                            <div class="card-body text-white bg-primary">
                                <p class="card-text text-light">
<i class="fa fa-envelope-o"> </i> Phone : <?php echo $xrow['phone']; ?>
                                </p>
                            </div>
                    </li>
            </ul>

<?php        }
    }else{
        echo 'No Participants';
    }

?>

          

            </div>
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
<?php require_once 'lastscripts.php';?>
