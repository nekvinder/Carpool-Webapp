<?php
require_once 'conn.php';
function contains( $haystack,$needle)
{
	if(empty($needle)){return false;}
	return strpos($haystack, $needle) !== false;
}
if(!empty($_GET["requestid"])) {
	try {
		$sql = "update request set acpt=1 where reqid=" . $_GET['requestid'] ;
		$stmt=$pdo->prepare($sql);
		$ins= $stmt->execute();
		if($ins)
		{
			try {
					$sql = "SELECT * FROM request where reqid=" . $_GET['requestid'] ;
					$stmt = $pdo->query($sql);
					$xrow = $stmt->fetch();

/*notfying*/
					AddNoti($pdo,GetAccName($pdo,$xrow['toid'])." accepted your request to join their pool.<br>You Have been now assigned to the pool.",$xrow['fromid']);

					$sql = "SELECT * FROM pools where poolid=" . $xrow['poolid'] ;
					$stmt = $pdo->query($sql);
					$zxrow = $stmt->fetch();

					foreach(explode(",", $zxrow['bookedbyid'])  as $id){
					AddNoti($pdo,GetAccName($pdo,$xrow['fromid'])." joined your into pool.",$id);

					}

					$ids=$zxrow['bookedbyid']==0?$xrow['fromid'] : $zxrow['bookedbyid'].",".$xrow['fromid'];

					$sql = "update pools set bookedbyid=?,mon=?,tue=?,wed=?,thu=?,fri=?,sat=? where poolid=" . $xrow['poolid'] ;
					$stmt=$pdo->prepare($sql);
					$mon=$zxrow['mon'];$tue=$zxrow['tue'];$wed=$zxrow['wed'];$thu=$zxrow['thu'];$fri=$zxrow['fri'];$sat=$zxrow['sat'];
					foreach(explode(",", $xrow['ondays'])  as $days){
						if (contains($days, 'on')) {$mon=$xrow['fromid'];}
						elseif (contains($days, 'ue')) {$tue=$xrow['fromid'];}
						elseif (contains($days, 'edne')) {$wed=$xrow['fromid'];}
						elseif (contains($days, 'hurs')) {$thu=$xrow['fromid'];}
						elseif (contains($days, 'Frida')) {$fri=$xrow['fromid'];print"fri";}
						elseif (contains($days, 'aturd')) {$sat=$xrow['fromid'];}
					}
					$ins= $stmt->execute([$ids,$mon,$tue,$wed,$thu,$fri,$sat]);
					if($ins)
					{
						redirect("dashboard.php?msg=Request%20Accepted");
					}		
				} catch (PDOException $e) {
					die($e->getMessage());
				}
			
		}		
	} catch (PDOException $e) {
		die($e->getMessage());
	}
}
?>