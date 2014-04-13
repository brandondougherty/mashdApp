<?php 
session_start();
include (__DIR__.'/src/facebook.php');
include (__DIR__.'../../dbc.php');

$incoming = json_decode(file_get_contents('php://input'));
foreach($incoming as $key => $value) {
	$data[$key] = filter($value); // post variables are filtered
}

$id = $data['id'];
$message = $data['status'];
$name = $_SESSION['fb_prof'];
$userId = $_SESSION['fb_user_id'];
$facebook = new Facebook(array(
  'appId'  => '464235817026185',
  'secret' => 'cc0dfb735ef12d40c59dc83fa7493efd'
));
$response = $facebook->api('/'.$id.'/comments',
                            "POST",
                            array (
                                'message' => $message,
                            ));
$package = array('id'=>$response['id'],'name'=>$name,'userId'=>$userId);
echo json_encode($package);
?>