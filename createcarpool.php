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

if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(!empty($_POST["poolname"])){
if($_POST["pincode"]<302000 || $_POST["pincode"]>302099){
    redirect("createcarpool.php?msg=Pincode must be in jaipur");    
}
$sql = "INSERT INTO pools(createdlid,name,totalseats,cartype,bookedbyid,terms,PinCode) VALUES (?,?,?,?,?,?,?)";
        try {
            $stmt=$pdo->prepare($sql);
$ins= $stmt->execute([$lid,$_POST["poolname"],$_POST["seataval"],$_POST["cartype"],0,$_POST["terms"],$_POST["pincode"]]);
            if($ins)
            {
                AddNoti($pdo,"Your Carpool has been created named ".$_POST['poolname'],GetAccId($pdo));
                redirect("dashboard.php?msg=Carpool Created");
            }
        } catch (PDOException $e) {
            die($e->getMessage());
        }
        
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
    <title>Create Carpool</title>
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
                                <p><?php echo($xrow['text']); ?></p>
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
                        <h1>Create Carpool</h1>
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
                                    <p>     My carpool allows its user to start their own carpool system in order to reach the school conveniently. However, a user can only be a part of one carpool system at a time.</p>
                                </div>
                            </div>
                            <form id="main-contact-form"  name="contact-form" method="post" action="createcarpool.php">
                            <div class="col-sm-8 col-sm-offset-1">

<?php
    $sql = "SELECT * FROM pools where createdlid=" . $lid;
    $stmt = $pdo->query($sql);
    if ($zrow = $stmt->fetch() == 0) {
?>            
                                <div class="form-group">
                                        <label><strong>Name of Pool  *</strong></label>
                                        <input type="text" name="poolname" class="form-control" required="required">
                                </div>
                                <div class="form-group">
                                        <label><strong>Pincode  *</strong></label>
                                        <input type="text" name="pincode" class="form-control" required="required">
                                </div>
                                    <div class="form-group">
                                            <label><strong>Total number of wards allowed in the carpool * </strong></br></label>
                                            <select name="seataval">
                                            <optgroup label="Number of wards in the carpool">
                                                    <option value="1">1</option>
                                                    <option value="2">2</option>
                                                    <option value="3">3</option>
                                                    <option value="4">4</option>
                                                    <option value="5">5</option>
                                                    <option value="6">6</option>
                                            </optgroup>
                                                </select>
                                        </div>
                                <div class="form-group">
                                <label><strong>Type of car * </strong></label></br>
                                <input type="radio" name="cartype" value="0" checked> Sedan</br>
                                  <input type="radio" name="cartype" value="1"> SUV</br>
                                  <input type="radio" name="cartype" value="2"> Other</br>
                                </div>

                                <div class="form-group">
Add your own terms below if you like:<textarea name="terms" rows="10" cols="120">
The participants of the carpool must inform the members if the ward would be absent on the school days. 

The participants of the carpool must send their cars to pick up or drop the other wards even if their ward is absent on his/her assigned day of carpool.

The days to be assigned to the members would be discussed thoroughly for the convenience.

The participants of the carpool must send their cars to pick up or drop the other wards even if their ward is absent on his/her assigned day of carpool.
                                </textarea>                                  
                                </div>
                           <div class="form-group">
                              <input type="submit" value="Submit">
                            </div>
<?php }else{ 

$sql="SELECT * FROM pools JOIN login on login.id=pools.createdlid where  pools.createdlid=".GetAccId($pdo).";";
$stmt = $pdo->query($sql);
$row = $stmt->fetch()
?>
                             
                                    
                             <div class="col-md-9 ">

                                <div class="card col-md-14">

                                    <div class="card-header bg-flat-color-3">
                                    <span><strong class="card-title text-light"><i class="fa fa-warning"></i>
                                        You have already created a pool </strong></span>
                                        <br><br>
                                    <div class="card-header bg-danger">
                                     <strong class="card-title text-light"><i class="fa fa-group"></i> 
                                        <?php echo $row['name']; ?> Pool </strong>
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

                                </div>

<?php } ?>                                
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
