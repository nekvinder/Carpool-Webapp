<?php
require_once 'conn.php';

if(!empty($_GET["poolid"])) {
	$sql = "INSERT INTO request (fromid,toid,poolid,ondays) VALUES (?,?,?,?)";
	try {
		$stmt=$pdo->prepare($sql);
		$fromid=GetAccId($pdo);

		$xsql = "SELECT * FROM pools where poolid=" . $_GET['poolid'] . ";";
		$xstmt = $pdo->query($xsql);
		$zxrow = $xstmt->fetch();
		$toid=$zxrow['createdlid'];

		$ins= $stmt->execute([$fromid,$toid,$_GET['poolid'],$_GET['ondays']]);
		if($ins)
		{
			redirect("dashboard.php?msg=Request Sent");
		}		
	} catch (PDOException $e) {
		die($e->getMessage());
	}

	
	
}

	



?>