<?php
	include 'src/facebook.php';
	include (__DIR__.'../../dbc.php');
	$facebook = new Facebook(array(
  'appId'  => '464235817026185',
  'secret' => 'cc0dfb735ef12d40c59dc83fa7493efd'
));

$incoming = json_decode(file_get_contents('php://input'));
foreach($incoming as $key => $value) {
	$data[$key] = filter($value); // post variables are filtered
}
$id = $data['id'];
$response = $facebook->api(
    "/".$id,
    'DELETE'
);

echo json_encode($response);
?>