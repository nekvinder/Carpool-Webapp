<?php
require_once 'conn.php';
 if(!isset( $_SESSION['user'] ) ) {
    alert("Please Login First");
    redirect('login.php');
    exit();
 }

 if(!isset($_GET['searchname'] ) ) {
    redirect('searchcarpool.php?searchname=');
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
    <title>Search Pools</title>
    <meta name="description" content="Sufee Admin - HTML5 Admin Template">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="apple-touch-icon" href="apple-icon.png">
    <link rel="shortcut icon" href="favicon.ico">

    <link rel="stylesheet" href="assets/css/normalize.css">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/themify-icons.css">
    <link rel="stylesheet" href="assets/css/flag-icon.min.css">
    <link rel="stylesheet" href="assets/css/cs-skin-elastic.css">

    <link href="assets/css/lib/vector-map/jqvmap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/scss/style.css">

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
                        <h1>Dashboard</h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="page-header float-right">
                    <div class="page-title">
                        <ol class="breadcrumb text-right">
                            
                            <li class="active">Search Carpools // Check Carpool profiles</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
       <div>
        <form method="get" action="searchcarpool.php">
        <input  type="text" class="search-panel" name="searchname" 
        <?php if(!empty($_GET['searchname'])) echo'value="'.$_GET['searchname'].'"'; ?> 
        placeholder="Search By Pincode.." style="display:block;width:50%">
        &nbsp;&nbsp;&nbsp;&nbsp;<button  type="submit" class="btn-lg active btn-danger" style="display: inline;">Search</button>
        </form>
        
       </div>

        <div class="content mt-3">
            <div class="animated fadeIn">

                 <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header">
<h4>Results<button style="display:inline-block;float:right" onclick="window.location.assign('searchcarpool.php')">Clear </button></h4>

                                </div>

                               
                                <table class="table bootstrap-table table-dark">
<tr><th>Pool Name</th><th>Participants</th><th>Seats Available</th><th>PinCode</th><th><a href="#">View</a></th></tr>
<?php
$sql = "SELECT * FROM pools JOIN login on login.id = pools.createdlid where pools.createdlid!=".GetAccId($pdo)." and pools.pincode like '%".$_GET['searchname']."%';";
    $stmt = $pdo->query($sql);
    while ($row = $stmt->fetch()) {
        ?>
<tr><td><?php echo($row['name']." by (".$row['uname'].")"); ?></td>
    <td><?php
    $arr=explode(",", $row['bookedbyid']);

    if($arr[0]>0)
    {
//        echo(count($arr));
        for($i=0;$i<count($arr);$i++)
        {
            echo GetAccName($pdo,$arr[$i])."<br>";
        }
    }else{
        echo 'No Participants';
    }

     ?></td>
    <td><?php echo($row['totalseats']-($arr[0]>0?count($arr):0)); ?></td>
    <td><?php echo($row['pincode']); ?></td>
    <td><a  style="color:pink " href="joincarpool.php?poolid=<?php echo $row['poolid'] ?>">View Pool</a></td>
</tr>
<?php } ?>
                                </table>
                                </div>
                            </div>
                            <!-- /# card -->
                        </div>
                       
                       
                        

                       


                    </div>
                    <!-- /# row -->


            </div><!-- .animated -->
        </div><!-- .content -->


    </div><!-- /#right-panel -->

    <!-- Right Panel -->


    <script src="assets/js/vendor/jquery-2.1.4.min.js"></script>
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/plugins.js"></script>
    <script src="assets/js/main.js"></script>

    <script src="assets/js/lib/vector-map/jquery.vmap.js"></script>
    <!-- scripit init-->
    <script src="assets/js/lib/vector-map/jquery.vmap.min.js"></script>
    <!-- scripit init-->
    <script src="assets/js/lib/vector-map/jquery.vmap.sampledata.js"></script>
    <!-- scripit init-->
    <script src="assets/js/lib/vector-map/country/jquery.vmap.world.js"></script>
    <!-- scripit init-->
    <script src="assets/js/lib/vector-map/country/jquery.vmap.algeria.js"></script>
    <!-- scripit init-->
    <script src="assets/js/lib/vector-map/country/jquery.vmap.argentina.js"></script>
    <!-- scripit init-->
    <script src="assets/js/lib/vector-map/country/jquery.vmap.brazil.js"></script>
    <!-- scripit init-->
    <script src="assets/js/lib/vector-map/country/jquery.vmap.france.js"></script>
    <!-- scripit init-->
    <script src="assets/js/lib/vector-map/country/jquery.vmap.germany.js"></script>
    <!-- scripit init-->
    <script src="assets/js/lib/vector-map/country/jquery.vmap.greece.js"></script>
    <!-- scripit init-->
    <script src="assets/js/lib/vector-map/country/jquery.vmap.iran.js"></script>
    <!-- scripit init-->
    <script src="assets/js/lib/vector-map/country/jquery.vmap.iraq.js"></script>
    <!-- scripit init-->
    <script src="assets/js/lib/vector-map/country/jquery.vmap.russia.js"></script>
    <!-- scripit init-->
    <script src="assets/js/lib/vector-map/country/jquery.vmap.tunisia.js"></script>
    <!-- scripit init-->
    <script src="assets/js/lib/vector-map/country/jquery.vmap.europe.js"></script>
    <!-- scripit init-->
    <script src="assets/js/lib/vector-map/country/jquery.vmap.usa.js"></script>
    <!-- scripit init-->
    <script src="assets/js/lib/vector-map/country/jquery.vmap.turkey.js"></script>
    <!-- scripit init-->
    <script src="assets/js/lib/vector-map/vector.init.js"></script>




</body>
</html>
