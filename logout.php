<?php
	alert("Logged Out");
	if ( isset( $_COOKIE[session_name()] ) )
	setcookie( session_name(), “”, time()-3600, “/” );
	$_SESSION = array();
	session_destroy();
	redirect("login.php");

function alert($msg) {
    echo "<script type='text/javascript'>alert('$msg');</script>";
}

function redirect($url, $statusCode = 303)
{
   header('Location: ' . $url, true, $statusCode);
   die();
}

?>
