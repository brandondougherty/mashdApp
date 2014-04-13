<?php 
session_start();
include (__DIR__.'/vine.php');
include (__DIR__.'../../dbc.php');
$incoming = json_decode(file_get_contents('php://input'));

foreach($incoming as $key => $value) {
	$data[$key] = filter($value); // post variables are filtered
}
$vine = new Vine;
$key = $_SESSION['vine_key'];
$postid = $data['id'];
$message = $data['status'];
$vines= $vine->postComments($key,$postid,$message);
$name = $_SESSION['vine_userName'];
$avatar = $_SESSION['vine_avatar'];
$id = $_SESSION['vine_userid'];
$package = array('name'=>$name,'avatar'=>$avatar,'id'=>$id);
echo json_encode($package);
?>