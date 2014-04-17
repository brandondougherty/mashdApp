<?php
session_start();
include 'dbc.php';

$incoming = json_decode(file_get_contents('php://input'));
foreach($incoming as $key => $value) {
	$data[$key] = filter($value); // post variables are filtered
}
$pass = "none";
$em = "none";
if(!empty($data['password'])){
	$newsha1 = PwdHash($data['password']);
	mysql_query("update users set pwd='$newsha1' where id='$_SESSION[user_id]'");
	$pass = "success";
}
if(!empty($data['email'])){
	$email = $data['email'];
	mysql_query("update users set user_email='$email' where id='$_SESSION[user_id]'");
	$em = "success";
}

$package = array('pass'=>$pass,'email'=>$em);
echo json_encode($package);
?>