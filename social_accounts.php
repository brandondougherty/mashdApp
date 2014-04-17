<?php
include 'facebooklibs/auth.php';
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
if($user){
    $e->facebook = 'http://localhost/MashdApp/www/facebooklibs/logout.php';
    $e->facebookIO = 0;
}else{
     $e->facebook = $loginUrl;  
    $e->facebookIO = 1;

}
//INSTAGRAM
if(isset($_SESSION['instagram'])){
     $e->instagram = 'http://localhost/MashdApp/www/instagram_logout.php';
     $e->instagramIO = 0;
}else{
     $e->instagram = $instagram_loginUrl ;  
     $e->instagramIO = 1;

}
//TWITTER
if(isset($_SESSION['access_token'])){
     $e->twitter = 'http://localhost/MashdApp/www/twitterlibs/twitter_logout.php'; //LOGOUT URL
     $e->twitterIO = 0;
}else{
     $e->twitter = 'http://localhost/MashdApp/www/twitterlibs/redirect.php';//LOGIN  
     $e->twitterIO = 1;

}
///VINE
if(isset($_SESSION['vine_key'])){
     $e->vine = 'http://localhost/MashdApp/www/vinelibs/vinelogout.php'; //LOGOUT URL
     $e->vineIO = 0;

}else{
     $e->vine = "#/vineLogin";//LOGIN  
     $e->vineIO = 1;

}

 echo json_encode($e);

?>