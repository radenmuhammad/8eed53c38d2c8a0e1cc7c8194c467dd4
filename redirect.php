<?php
$client_id = '0oa1zc77qs6WnzYmY5d6';
$client_secret = 'CcuFHFeesNVrou4zaED9bKRZK3P3CqGcT9CiBRaH';
$redirect_uri = 'http://localhost:8080/rest_api/redirect.php';

session_start();

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

if(isset($_GET['code'])) {

  // TODO: we'll work on filling out this section next

}

if(!isset($_SESSION['username'])) {

}

if($_SESSION['state'] != $_GET['state']) {
	die('Authorization server returned an invalid state parameter');
}

if(isset($_GET['error'])) {
	die('Authorization server returned an error: '.htmlspecialchars($_GET['error']));
}

$response = http($metadata->token_endpoint, [
'grant_type' => 'authorization_code',
'code' => $_GET['code'],
'redirect_uri' => $redirect_uri,
'client_id' => $client_id,
'client_secret' => $client_secret,
]);

if(!isset($response->access_token)) {
	die('Error fetching access token');
}

 $token = http($metadata->introspection_endpoint, [
    'token' => $response->access_token,
    'client_id' => $client_id,
    'client_secret' => $client_secret,
  ]);

  if($token->active == 1) {
    $_SESSION['username'] = $token->username;
    header('Location: /');
    die();
  }

?>