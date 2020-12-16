<?php
$data = json_decode(file_get_contents('php://input'), true);
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php';
$mail = new PHPMailer(true);
$user_name = "root";
$password = "";
$database = "rest_api";
$host_name = "localhost";
$con = mysqli_connect($host_name, $user_name, $password,$database) or die("gagal, database tidak ditemukan");
$f = mysqli_fetch_array(mysqli_query($con,"SELECT * FROM users WHERE token='".$data['token']."'"));
	$data = json_decode(file_get_contents('php://input'), true);
if(!empty($f)){
	try {
		$mail->Port = 587;
		$mail->SMTPSecure = 'tls';
		$mail->IsSMTP();
		$mail->Host       = "smtp.gmail.com";
		$mail->SMTPAuth = true;
		$mail->Username   = "rma18feb91@gmail.com";
		$mail->Password   = "adzra1234";
		//Recipients
		$mail->setFrom('rma18feb91@gmail.com', $data["from"]);
		foreach($data["address"] as $key => $value){
			$mail->addAddress($value, $key);     			
		}
		$mail->isHTML(true);                                  // Set email format to HTML
		$mail->Subject = $data["subject"];
		$mail->Body    = $data["message"];
		mysqli_query($con,"INSERT INTO messages (`subject`,`message`) VALUES ('".$data["subject"]."','".$data["message"]."');");		
		$mail->send();
		echo '{"Pesan":"Message has been sent"}';
	} catch (Exception $e) {
		echo '{"Pesan":"Message could not be sent. Mailer Error: {$mail->ErrorInfo}"}';
	}
}else{
	echo '{"Pesan":"Invalid Token"}';	
}
?>