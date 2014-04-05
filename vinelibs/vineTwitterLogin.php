<?php 
session_start();
include (dirname(__FILE__).'/vine.php');

$token = $_SESSION['access_token']['oauth_token'];
$secret = $_SESSION['access_token']['oauth_token_secret'];
var_dump($token);
var_dump($secret);
$vine = new Vine;
$key = $vine->vineTwitterAuth($token,$secret);
var_dump($key);

?>