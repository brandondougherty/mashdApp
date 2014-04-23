<?php 
session_start();
include (__DIR__.'/instagram.class.php');
include (__DIR__.'../../dbc.php');
$incoming = json_decode(file_get_contents('php://input'));
foreach($incoming as $key => $value) {
	$data[$key] = filter($value); // post variables are filtered
}
$instagram = new Instagram(array(
  'apiKey'      => 'af0092092bd347f2948940ef30261dcc',
  'apiSecret'   => '12b2d103aa884b9c9a4bf377ad4cf279',
  'apiCallback' => 'http://mashd.it/instagramredirect.php' // must point to success.php
));

$postid = $data['postId'];

$comments = $instagram->getMediaComments($postid);
	
	foreach ($comments->data as $comment) {
	    $comment_img = $comment->from->profile_picture;
	    $comment_name = $comment->from->username;
	    $comment_text = $comment->text;
	    echo "<div class='listComment'><img src='$comment_img' width='30px' height='30px'/> ";
	    echo $comment_name . ' - ';
	    echo $comment_text . "</div>";
	}
?>