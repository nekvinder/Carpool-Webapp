<?php 
function Send_Mail($to,$subject,$body)
{
require 'PHPmailer/class.phpmailer.php';
$from = "from@techoism.com";
$mail = new PHPMailer();
$mail->IsSMTP(true); // SMTP
$mail->SMTPAuth   = true;  // SMTP authentication
$mail->Host= "smtp.gmail.com";
$mail->SMTPSecure = 'tls';
$mail->Username = "ankitshramatest11@gmail.com";  // SMTP  Username
$mail->Password = "national777";  // SMTP Password
$mail->SetFrom($from, $_POST['name']);
$mail->AddReplyTo($from,'Technical Support');
$mail->Subject = $_POST['email']." : ".$_POST['number'] . " has query on carpool system." . $_POST['subject'];
$mail->MsgHTML($_POST['message']."<br>".$_POST['number']);
$address = $to;
$mail->AddAddress($address, $to);
if(!$mail->Send())
return false;
else
return true;
}

$to = "manushreesaboo1736@gmail.com";
$subject = "Test Mail Subject";
$body = "Hi
Email service is working
Techoism"; // HTML  tags
if(Send_Mail($to,$subject,$body))
{
	header('Location: ' . "index.php?msg=Your query has been submitted", true, 303);
}else{
header('Location: ' . "contact.php?msg=There was an error submitting your request.Please Try Again", true, 303);
}
?>
