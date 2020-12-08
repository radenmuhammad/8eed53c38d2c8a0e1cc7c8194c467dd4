<?php
$client_id = '0oa1zc77qs6WnzYmY5d6';
$client_secret = 'CcuFHFeesNVrou4zaED9bKRZK3P3CqGcT9CiBRaH';
$redirect_uri = 'http://localhost:8080/rest_api/redirect.php';

function http($url, $params=false) {
  $ch = curl_init($url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  if($params)
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
  return json_decode(curl_exec($ch));
}

$metadata_url = 'https://dev-8412006.okta.com/oauth2/default/.well-known/oauth-authorization-server';
// Fetch the authorization server metadata which contains a few URLs
// that we need later, such as the authorization and token endpoints
$metadata = http($metadata_url);

// Begin the PHP session so we have a place to store the username
session_start();

// If there is a username, they are logged in, and we'll show the logged-in view
if(isset($_SESSION['username'])) {
  echo '<p>Logged in as</p>';
  echo '<p>' . $_SESSION['username'] . '</p>';
  echo '<p><a href="/?logout">Log Out</a></p>';
  die();
}

// If there is no username, they are logged out, so show them the login link
if(!isset($_SESSION['username'])) {
  $_SESSION['state'] = bin2hex(random_bytes(5));

  $authorize_url = $metadata->authorization_endpoint.'?'.http_build_query([
    'response_type' => 'code',
    'client_id' => $client_id,
    'redirect_uri' => $redirect_uri,
    'state' => $_SESSION['state'],
    'scope' => 'openid',
  ]);
  echo '<p>Not logged in</p>';
  echo '<p><a href="'.$authorize_url.'">Log In</a></p>';
}


/*
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php';
$mail = new PHPMailer(true);
try {
	$mail->Port = 587;
	$mail->SMTPSecure = 'tls';
	$mail->IsSMTP();
	$mail->Host       = "smtp.gmail.com";
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
*/
?>