<?php
	include 'src/facebook.php';
	
	$facebook = new Facebook(array(
  'appId'  => '464235817026185',
  'secret' => 'cc0dfb735ef12d40c59dc83fa7493efd',
  'sharedSession'=>false
));

// Get User ID
$user = $facebook->getUser();
$_SESSION['fb_user_id'] = $user;


if ($user && !isset($_SESSION['fb_prof'])) {
    $user_profile = $facebook->api('/me');
  $_SESSION['fb_prof'] = $user_profile['name'];
}
// Login or logout url will be needed depending on current user state.
if ($user) {
  //$logoutUrl = $facebook->getLogoutUrl();
} else {
  $statusUrl = $facebook->getLoginStatusUrl();
  $loginUrl = $facebook->getLoginUrl($params=array(
  	'scope' => 'read_stream, read_friendlists, friends_videos, user_videos, friends_photos, publish_actions, read_insights, user_likes, user_status, user_photos, friends_status, friends_likes, user_actions.news, friends_actions.news, friends_actions:instapp, user_actions:instapp',
    'redirect_uri' => 'http://mashd.it/fbredirect.php'
  ));
}

// This call will always work since we are fetching public data.
//$naitik = $facebook->api('/naitik');

?>