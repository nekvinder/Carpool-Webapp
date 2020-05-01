<?php
require_once 'conn.php';
 if(!isset( $_SESSION['user'] ) ) {
	alert("Please Login First");
	redirect('login.php');
	exit();
 }
$sql = "SELECT * FROM request where reqid=" . $_GET["reqid"];
$stmt = $pdo->query($sql);
$zrow = $stmt->fetch();

$sql = "SELECT * FROM rider where rid=" . $zrow["rid"];
$stmt = $pdo->query($sql);
$z1row = $stmt->fetch();

$sql = "SELECT * FROM host where hid=" . $zrow["hid"];
$stmt = $pdo->query($sql);
$z2row = $stmt->fetch();




if(!empty($_GET["acpt"]) && $_GET["acpt"]=="true") {
    $sql = "update request set hacpt=1 where reqid=?";
    try {
        $stmt=$pdo->prepare($sql);
        $ins= $stmt->execute([$_GET['reqid']]);
        if($ins)
        {
            $sql = "insert into pools (rid,hid,rseat,hseat) values(?,?,?,?);";
            try {
                $stmt=$pdo->prepare($sql);
                $ins= $stmt->execute([$zrow["rid"],$zrow['hid'],$z1row['seatreq'],$z2row['seataval']]);
                if($ins)
                {
                    $sql = "update rider set assigned=assigned+?;";
                    try {
                        $stmt=$pdo->prepare($sql);
                        $ins= $stmt->execute([$z2row['seataval']]);
                        if($ins)
                        {
                            $sql = "update host set assigned=assigned+?;";
                                try {
                                    $stmt=$pdo->prepare($sql);
                                    $ins= $stmt->execute([$z1row['seatreq']]);
                                    if($ins)
                                    {
                                        redirect("dashboard.php?msg=Request Accepted Successfully");
                                    }
                                } catch (PDOException $e) {
                                    die($e->getMessage());
                                }
                        }
                    } catch (PDOException $e) {
                        die($e->getMessage());
                    }
                }
            } catch (PDOException $e) {
                die($e->getMessage());
            }
        }
    } catch (PDOException $e) {
        die($e->getMessage());
    }

}   


function LoginNameByID($pdo,$id){
    $sql = "SELECT * FROM login where login.id='" . $id . "';";
    $stmt = $pdo->query($sql);
    $xrow = $stmt->fetch();
    return $xrow['email'];
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
    <title>View Carpool System</title>
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
            </div>
        </header><!-- /header -->
        <!-- Header-->
        <div class="breadcrumbs">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>View Request</h1>
                    </div>
                </div>
            </div>
        </div>
        <div class="content mt-3">
            <div class="animated fadeIn">
                <div class="row">
                    <div class="col-xs-6 col-sm-9">
                        <div class="card">
                            <div class="card-header">
                                <strong class="card-title">Request</strong>
                            </div>
                            <div class="card-bodu">
                                <table class="table table-bootstrap table-striped">
<?php
 $sql = "SELECT * FROM request,rider where request.rid=rider.rid  and Request.reqid=" . $_GET['reqid'] . ";";
    //die($sql);
    $stmt = $pdo->query($sql);
    while($xrow = $stmt->fetch()){
?>
                                <tr><th><?php echo LoginNameByID($pdo,$xrow['lid'])?> has requested to book <?php echo $xrow['seatreq'];?> seats.<span style="float:right;"> 
                                <a href="?reqid=<?php echo $_GET['reqid'];?>&acpt=true"><i class="fa fa-check-square-o" style="color: green;font-size:30px;">Accept</i></a></span> 
                                </th></tr>

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
