<?php
header("Access-Control-Allow-Origin: *");
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
//get referrer server
if($_SERVER['HTTP_REFERER'] === 'http://localhost:3000/'){
	// get data from Get method 
	$name = isset($_GET['name']) ? $_GET['name'] : null;
	$email = isset($_GET['sendto']) ? $_GET['sendto'] : null;
	$code = isset($_GET['code']) ? $_GET['code'] : null;

	if($name && $email && $code){
		require 'vendor/autoload.php';

		$mail = new PHPMailer(true);

		try {
			//Server settings
			$mail->isSMTP();                                            //Send using SMTP
			$mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
			$mail->SMTPAuth   = true;                                   //Enable SMTP authentication
			$mail->Username   = 'paladbryanj@gmail.com';                     //SMTP username
			$mail->Password   = 'Bjgp09392735319282849121';
			// $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;                           //SMTP password
			$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
			$mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
		
			//Recipients
			$mail->setFrom('paladbryanj@gmail.com', 'Modern Resolve');
			$mail->addAddress($email);               //Name is optional
			$mail->addReplyTo('paladbryanj@gmail.com', 'Modern Resolve Team');
		
			//Content
			$mail->isHTML(true);                                  //Set email format to HTML
			$mail->Subject = 'Account Recovery';
			$mail->Body    = '<b>This is your verification code</b> <br/><br/>' . $code;
		
			$mail->send();
			echo 'Message has been sent';
		} catch (Exception $e) {
			echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
		}
	}
	else {
		echo "All the fields are required";
	}
} else {
	echo "You can't use this server";
}
?>