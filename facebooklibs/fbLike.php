<?php
	include 'src/facebook.php';
	include (__DIR__.'../../dbc.php');
	$facebook = new Facebook(array(
  'appId'  => '464235817026185',
  'secret' => 'cc0dfb735ef12d40c59dc83fa7493efd'
));

foreach($_POST as $key => $value) {
      $data[$key] = filter($value); // post variables are filtered
}

$id = $data['id'];
$method = $data['method'];
var_dump($id);

$response = $facebook->api(
    "/".$id."/likes",
    $method
);

var_dump($response);
?>