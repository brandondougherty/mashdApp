<?php
session_start();
include (__DIR__.'../../dbc.php');
include (__DIR__.'/twitteroauth/twitteroauth.php');
include (__DIR__.'/config.php');
foreach($_POST as $key => $value) {
      $data[$key] = filter($value); // post variables are filtered
}

$id = $data['id'];
$method = $data['method'];
$params = array('id' => $id);
$access_token = $_SESSION['access_token'];

$connect = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $access_token['oauth_token'], $access_token['oauth_token_secret']);
  
$method = 'favorites/'.$method;
$the_response = $connect->post($method,$params);
//var_dump($the_response);
?>