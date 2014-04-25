<?php
session_start();
include 'facebooklibs/src/facebook.php';

include 'instagramlibs/instagramAuth.php';
include 'twitterlibs/twitterauth.php';



class AccountsLoggedIn {
       public $facebook = "";
       public $twitter  = "";
       public $instagram = "";
       public $vine = "";
       public $facebookIO = "";
       public $twitterIO  = "";
       public $instagramIO = "";
       public $vineIO = "";
   }
   $e = new AccountsLoggedIn();
//fb
if(isset($_SESSION['fb_user_id']) && !empty($_SESSION['fb_user_id'])){
    $e->facebook = 'http://mashdapp.mashd.it/facebooklibs/logout.php';
    $e->facebookIO = 0;
}else{

  $facebook = new Facebook(array(
    'appId'  => '464235817026185',
    'secret' => 'cc0dfb735ef12d40c59dc83fa7493efd'
  ));
  $loginUrl = $facebook->getLoginUrl($params=array(
    'scope' => 'read_stream, read_friendlists, friends_videos, user_videos, friends_photos, publish_actions, read_insights, user_likes, user_status, user_photos, friends_status, friends_likes, user_actions.news, friends_actions.news, friends_actions:instapp, user_actions:instapp',
    'redirect_uri' => 'http://mashdapp.mashd.it/fbredirect.php'
  ));
     $e->facebook = $loginUrl;  
    $e->facebookIO = 1;

}
//INSTAGRAM
if(isset($_SESSION['instagram'])){
     $e->instagram = 'http://mashdapp.mashd.it/instagram_logout.php';
     $e->instagramIO = 0;
}else{
     $e->instagram = $instagram_loginUrl ;  
     $e->instagramIO = 1;

}
//TWITTER
if(isset($_SESSION['access_token'])){
     $e->twitter = 'http://mashdapp.mashd.it/twitterlibs/twitter_logout.php'; //LOGOUT URL
     $e->twitterIO = 0;
}else{
     $e->twitter = 'http://mashdapp.mashd.it/twitterlibs/redirect.php';//LOGIN  
     $e->twitterIO = 1;

}
///VINE
if(isset($_SESSION['vine_key'])){
     $e->vine = 'http://mashdapp.mashd.it/vinelibs/vinelogout.php'; //LOGOUT URL
     $e->vineIO = 0;

}else{
     $e->vine = "#/vineLogin";//LOGIN  
     $e->vineIO = 1;

}

 echo json_encode($e);

?>