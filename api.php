<?php
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require 'vendor/autoload.php';

// Instantiation and passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
	$mail->Port = 587;
	$mail->SMTPSecure = 'tls';
	$mail->IsSMTP();
	$mail->Host       = "smtp.gmail.com";

// optional
// used only when SMTP requires authentication  
	$mail->SMTPAuth = true;
	$mail->Username   = "rma18feb91@gmail.com";
	$mail->Password   = "adzra1234";

    //Recipients
    $mail->setFrom('rma18feb91@gmail.com', 'Mailer');
    $mail->addAddress('rma18feb91@gmail.com', 'Joe User');     // Add a recipient
//   $mail->addAddress('ellen@example.com');               // Name is optional
//   $mail->addReplyTo('info@example.com', 'Information');
//   $mail->addCC('cc@example.com');
//   $mail->addBCC('bcc@example.com');

//   $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
//   $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

    // Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = 'Here is the subject';
    $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
?>