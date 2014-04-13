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

$id = $data['post'];
$search = $facebook->api(
    "/".$id."?fields=album",
    'GET'
);
$album = $search['album']['id'];
$response = $facebook->api(
    "/".$album."/photos",
    'GET'
);
foreach ($response['data'] as $photos) {
	$picture = $photos['source'];
	$pcitureId = $photos['id'];

	echo "<div class='fbAlbum'>";
	echo "<a ng-click=\"goToPhoto('$pcitureId')\"><img src='$picture'/></a>";
	echo "</div>";
}

?>