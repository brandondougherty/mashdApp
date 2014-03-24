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
$key = $vine->vineAuth($user_email,$pass);

$userId = strtok($key,'-');

$_SESSION['vine_key']= $key;  
$_SESSION['vine_userid'] = $userId;


header("Location: http://localhost/MashdApp/www/#/social");

?>