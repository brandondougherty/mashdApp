<?php 

include(dirname(__FILE__).'/../dbc.php');
include (dirname(__FILE__).'/vine.php');

$err = array();

foreach($_GET as $key => $value) {
	$get[$key] = filter($value); //get variables are filtered.
}

if ($_POST['doLogin']=='login with Vine')
{

	foreach($_POST as $key => $value) {
		$data[$key] = filter($value); // post variables are filtered
	}
}


$user_email = $data['vineEmail'];
$pass = $data['password'];

session_start();
$vine = new Vine;
$response= $vine->vineAuth($user_email,$pass);
$key = $response->data->key;
$userId = strtok($key,'-');

$_SESSION['vine_key']= $key;  
$_SESSION['vine_userid'] = $userId;
$_SESSION['vine_userName'] = $response->data->username;
$_SESSION['vine_avatar'] = preg_replace('/\A.*\/\//', "",$response->data->avatarUrl);

//var_dump($response);
header("Location: http://mashd.it/#/social");

?>