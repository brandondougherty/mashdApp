<?php
session_start();
include (__DIR__.'../../dbc.php');
include (__DIR__.'/twitteroauth/twitteroauth.php');
include (__DIR__.'/config.php');
foreach($_POST as $key => $value) {
      $data[$key] = filter($value); // post variables are filtered
}

$id = $data['id'];
$status = $data['status'];
$status = $status;	
$params = array('status'=> $status,
				'in_reply_to_status_id' => $id);
$access_token = $_SESSION['access_token'];

$connect = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $access_token['oauth_token'], $access_token['oauth_token_secret']);
  
$method = 'statuses/update';
$the_response = $connect->post($method,$params);
var_dump($the_response);
?>