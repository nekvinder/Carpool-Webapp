<?php 
require'conn.php';
require 'PHPMailer/PHPMailerAutoload.php';
$sql = "SELECT * FROM login where login.email='" . $_POST['mailaddr'] . "';";
$stmt = $pdo->query($sql);
$xrow = $stmt->fetch();
$mail = new PHPMailer;
$mail->isSMTP();

/*
 * Server Configuration
 */

$mail->Host = 'smtp.gmail.com'; // Which SMTP server to use.
$mail->Port = 587; // Which port to use, 587 is the default port for TLS security.
$mail->SMTPSecure = 'tls'; // Which security method to use. TLS is most secure.
$mail->SMTPAuth = true; // Whether you need to login. This is almost always required.
$mail->Username = "ankitshramatest11@gmail.com"; // Your Gmail address.
$mail->Password = "national777"; // Your Gmail login password or App Specific Password.

/*
 * Message Configuration
 */

$mail->setFrom('support@jpischool.com', 'JPI School'); // Set the sender of the message.
$mail->addAddress($_POST['mailaddr'], $_POST['mailaddr']); // Set the recipient of the message.
$mail->Subject = 'Carpool password reset.'; // The subject of the message.

/*
 * Message Content - Choose simple text or HTML email
 */

// Choose to send either a simple text email...
//$mail->Body = "Reset your password at link http://127.0.0.1/pages/forgotpw.php?id=".$xrow['id']; // Set a plain text body.

// ... or send an email with HTML.
$mail->MsgHTML("Reset your password at link http://127.0.0.1/pages/forgotpw.php?id=".$xrow['id']);

//$mail->msgHTML(file_get_contents('contents.html'));
// Optional when using HTML: Set an alternative plain text message for email clients who prefer that.
//$mail->AltBody = 'This is a plain-text message body'; 

// Optional: attach a file
//$mail->addAttachment('images/phpmailer_mini.png');

if ($mail->send()) {
   header('Location: ' . "login.php?msg=Reset link has been mailed", true, 303);}
else{
	header('Location: ' . "login.php?msg=There was an error submitting your request.Please Try Again", true, 303);
}

?>
