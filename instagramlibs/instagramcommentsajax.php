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
  'apiCallback' => 'http://localhost/MashdApp/www/instagramredirect.php' // must point to success.php
));
$commentRange = $data['page'];
$postid = $data['id'];

$comments = $instagram->getMediaComments($postid);
	$i=intval($commentRange) - 5;
	while($i < $commentRange){
	  if(isset($comments->data[$i])){
	    $comment = $comments->data[$i];
	    $comment_img = $comment->from->profile_picture;
	    $comment_name = $comment->from->username;
	    $comment_text = $comment->text;
	    echo "<img src='$comment_img' width='30px' height='30px'/> ";
	    echo $comment_name . ' - ';
	    echo $comment_text . "<br/>";
	  }
	  $i++;
	}
?>