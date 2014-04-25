<?php 
session_start();
include (__DIR__.'/instagram.class.php');
include (__DIR__.'../../dbc.php');
foreach($_POST as $key => $value) {
      $data[$key] = filter($value); // post variables are filtered
}

$instagram = new Instagram(array(
  'apiKey'      => 'af0092092bd347f2948940ef30261dcc',
  'apiSecret'   => '12b2d103aa884b9c9a4bf377ad4cf279',
  'apiCallback' => 'http://mashdapp.mashd.it/instagramredirect.php' // must point to success.php
));

$postid = preg_replace('/_.*/', '', $data['id']);
echo $postid;
$response = $instagram->deleteLikedMedia($postid);
 var_dump($response);
?>