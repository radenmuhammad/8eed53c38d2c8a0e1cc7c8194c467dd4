<?php 
$url = 'http://localhost:8080/rest_api/api.php';
// Create a new cURL resource
$ch = curl_init($url);
// Setup request to send json via POST
$data = json_encode(array(
	"token" => "16127458049860022721608143813",
	"from"=> "Raden Muhammad",
	"address" => array(
		"Name"=>"rma18feb91@gmail.com",
		"Name2"=>"rma18feb@gmail.com"
	),
	"subject" => "Here is the subject",
	"message" => "This is the HTML message body"
));
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
echo $result = curl_exec($ch);
curl_close($ch);
?>