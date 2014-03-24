<?php 
session_start();
include (__DIR__.'/twitteroauth/twitteroauth.php');
include (__DIR__.'/config.php');
include (__DIR__.'../../dbc.php');
foreach($_POST as $key => $value) {
      $data[$key] = filter($value); // post variables are filtered
}



function get_conversation($id_str, $screen_name, $return_type = 'json', $count = 100, $result_type = 'recent', $include_entities = true) {
 $access_token = $_SESSION['access_token'];

$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $access_token['oauth_token'], $access_token['oauth_token_secret']);
     $params = array(
          'q' => 'to:' . $screen_name, // no need to urlencode this!
          'count' => $count,
          'result_type' => $result_type,
          'include_entities' => $include_entities,
          'since_id' => $id_str
     );
     
     $feed = $connection->get('search/tweets', $params);
 
   return $feed;
 
}

$poster = $data['poster'];
$post = $data['post'];
$comments= get_conversation($post, $poster);

foreach ($comments->statuses as $post_comment){
	if($post == $post_comment->in_reply_to_status_id_str){
		$the_comment = $post_comment->text;
		$name = $post_comment->user->name;
		$username = $post_comment->user->screen_name;
		$img = $post_comment->user->profile_image_url;
		echo "<br/>";
		echo "<img src='$img' style='border-radius: 10%;/><span class='twitterUserName'>";
		echo $name . "</span><span class='twitterRealName'> @" . $username . '</span><br/>';
		echo $the_comment;
		echo "<br/><br/>";
	}
}

?>