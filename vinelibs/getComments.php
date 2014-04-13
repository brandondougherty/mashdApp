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
$postid = $data['post'];
$vines= $vine->getComments($key,$postid);
include 'vine_comments_ajax_parse.php';
?>