<link rel="shortcut icon" href="favicon.ico">
<script src="js/jquery.js"></script>
<?php

session_start();
$host = '127.0.0.1';
$db   = 'schoolpool';
$user = 'nek';
$pass = '123456';
$charset = 'utf8mb4';
$pdo=null;
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$opt = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];
try{
	$pdo = new PDO($dsn, $user, $pass, $opt);	
}
catch(PDOexception $e){
	die($e->getMessage());
}


function alert($msg) {
    echo "<script type='text/javascript'>alert('$msg');</script>";
}

function redirect($url, $statusCode = 303)
{
   header('Location: ' . $url, true, $statusCode);
   die();
}
function NotiCount($pdo){
	$cnt=0;
	$sql = "SELECT * FROM login JOIN notifi on login.id = notifi.lid where viewed=0 and login.uname='" . $_SESSION['user'] . "';";
	$stmt = $pdo->query($sql);
	while ($row = $stmt->fetch() > 0) {
		$cnt++;
	}
	return $cnt;
}


function GetAcc($pdo,$id){
	$sql = "SELECT * FROM login where login.id='" . $id . "';";
	$stmt = $pdo->query($sql);
	$xrow = $stmt->fetch();
	return $xrow;
}
function GetAccId($pdo){
	$sql = "SELECT * FROM login where login.uname='" . $_SESSION['user'] . "';";
	$stmt = $pdo->query($sql);
	$xrow = $stmt->fetch();
	return $xrow['id'];
}

function GetAccName($pdo,$id){
	$sql = "SELECT * FROM login where login.id='" . $id . "';";
	$stmt = $pdo->query($sql);
	$xrow = $stmt->fetch();
	return $xrow['uname'];
}

function isCurrentPartOfAny($pdo){
	$sql = "SELECT * FROM pools where createdlid=" . GetAccId($pdo);
	$stmt = $pdo->query($sql);
	if ($row = $stmt->fetch() > 0) {
		return true;
	}else{
			$sql = "SELECT * FROM pools where bookedbyid like '%" . GetAccId($pdo) . "%'";
			$stmt = $pdo->query($sql);
			while ($row = $stmt->fetch() ) {
				$ids=explode(",", $row['bookedbyid']);
				foreach ($ids as $key=>$val) {
					if($val==GetAccId($pdo))
						{return true;}
				}
			}
			return false;
    }
}


function AddNoti($pdo,$text,$toid){
	try {
        $xstmt=$pdo->prepare("insert into notifi (lid,textx) values(?,?)");
        return $xstmt->execute([$toid,$text]);
    } catch (PDOException $e) {
    }
}
//AddNoti($pdo,"say hiii",GetAccId($pdo));
//die()

function GetAccPin($pdo){
	$sql = "SELECT * FROM login where login.uname='" . $_SESSION['user'] . "';";
	$stmt = $pdo->query($sql);
	$xrow = $stmt->fetch();
	return $xrow['pincode'];
}



//participant will leave pool
function leavePool($pdo,$id){
	$sql = "select * FROM pools where bookedbyid like '%" . $id . "%';";

	$stmt = $pdo->query($sql);
	while($row = $stmt->fetch()){

		$days=[$row['mon'],$row['tue'],$row['wed'],$row['thu'],$row['fri'],$row['sat']];
		$days = array_replace($days,array_fill_keys(array_keys($days, $id),0));
		$arr=explode(",", $row['bookedbyid']);
		$arr=array_map('trim',$arr);
	    if(in_array($id, $arr)){
	    	//hence, is a participant,i.e not a fake match due to like stmt
    	$xsql = "update pools set bookedbyid=?,mon=?,tue=?,wed=?,thu=?,fri=?,sat=? where poolid=?";
		    try {
		        $xstmt=$pdo->prepare($xsql);
		        $diffarr= array_diff( $arr, [$id] );
		        $str = implode (", ",$diffarr);
		        foreach($diffarr as $kid){
		        	AddNoti($pdo,GetAccName($pdo,$id)." left your pool.",$kid);
		        }
		        //die();
		        $i=0;
				$ins= $xstmt->execute([$str,$days[$i++],$days[$i++],$days[$i++],$days[$i++],$days[$i++],$days[$i++],$row["poolid"]]);
		        return $ins;
		    } catch (PDOException $e) {
		        die($e->getMessage());
		    }
	    }
	}
	
}
/////leave pool request to function
if($_SERVER["REQUEST_METHOD"] == "GET"){
    if(!empty($_GET['return'])){
	    if($_GET['return']=="mycarpool"){
	    	if(leavePool($pdo,GetAccId($pdo))){
	    	redirect('dashboard.php?msg=Pool Left Successfully');}
	    	else{redirect('mycarpool.php?msg=Error occured');}
	    }
	    if($_GET['return']=="delete"){
	    	//delete pool by creater id
	    	$id=GetAccId($pdo) ;




	    	$xsql = "delete from pools where createdlid=?";
		    try {
		        $xstmt=$pdo->prepare($xsql);
		        $ins= $xstmt->execute([$id]);
		        if( $ins){redirect('dashboard.php?msg=Pool Deleted Successfully');
		    /*noti*/
			$sql = "select * FROM pools where createdlid=". $id.";";
			$stmt = $pdo->query($sql);
			$row = $stmt->fetch();
			$arr=explode(",", $row['bookedbyid']);
			$arr=array_map('trim',$arr);
	    	foreach($arr as $kid){AddNoti($pdo,GetAccName($pdo,$id)." deleted their pool.<br>Please join new pool.",$kid);}
			/*noti*/}
		        else{redirect('mycarpool.php?msg=Error occured');}
		    } catch (PDOException $e) {
		        redirect('mycarpool.php?msg=Error occured');
		    }

	    	/*else{redirect('mycarpool.php?msg=Error occured');}*/
	    }
	}

}





?>
