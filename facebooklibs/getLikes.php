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

$id = $data['postId'];
$response = $facebook->api(
    "/".$id."/likes",
    'GET'
);
foreach ($response['data'] as $like) {
	$name = $like['name'];
	$id = $like['id'];
	echo "<div class='listComment'>";
	echo "<a ng-click=\"goToUser('$id')\">$name</a>";
	echo "</div>";
}

?>