<?php 
session_start();
include 'facebooklibs/src/facebook.php';
include 'instagramlibs/instagramAuth.php';
include 'twitterlibs/twitterauth.php';
include 'vinelibs/vine.php';
function time_elapsed_string($ptime){
    $etime = time() - $ptime;
    if ($etime < 1){
        return '0 s';
    }
    $a = array( 12 * 30 * 24 * 60 * 60  =>  'y',
                30 * 24 * 60 * 60       =>  'month',
                24 * 60 * 60 * 7        =>  'wk',
                24 * 60 * 60            =>  'd',
                60 * 60                 =>  'h',
                60                      =>  'min',
                1                       =>  's'
                );
    foreach ($a as $secs => $str){
        $d = $etime / $secs;
        if ($d >= 1){
            $r = round($d);
            return $r . ' ' . $str;
        }
    }
}  
if (isset($_SESSION['fb_user_id'])){
  $facebook = new Facebook(array(
    'appId'  => '464235817026185',
    'secret' => 'cc0dfb735ef12d40c59dc83fa7493efd'
  ));
  $ret_obj = $facebook->api('/me/home?limit=10','GET');
  if(!empty($ret_obj) && isset($ret_obj['paging'])){
    $_SESSION['fb_object'] = $ret_obj['paging'];
  }
  //the paging works but it is kinda wonky, look into this more
  //var_dump($ret_obj);
}
if (isset($_SESSION['vine_key']) && isset($_SESSION['vine_userid'])){
  $vine = new Vine;
  $key = $_SESSION['vine_key'];
  $records = $vine->vineTimeline($key);
   $page = $records['data']['nextPage'];
   $timelineId = $records['data']['anchorStr'];
   $package = array('page'=>$page, 'timelineId'=>$timelineId);

  $_SESSION['vine_object'] = $package; 
}
if (isset ($_SESSION['access_token'])){
$access_token = $_SESSION['access_token'];

$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $access_token['oauth_token'], $access_token['oauth_token_secret']);
$method = 'statuses/home_timeline.json?count=11';
$the_response = $connection->get($method);
if(isset($the_response[10])){
  $max_id = $the_response[10]->id_str;
$twitterObj = array('max_id'=>$max_id);
$_SESSION['twitter_object'] = $twitterObj;
}

}  
  //var_dump($_SESSION);
  //var_dump($_COOKIE);
  
    if(isset($_SESSION['fb_object'])||isset($_SESSION['vine_key'])||isset($_SESSION['vine_userid'])||isset($_SESSION['access_token'])||isset($_SESSION['instagram']))
    {
      if (isset ($_SESSION['vine_key']) && isset($_SESSION['vine_userid'])){
        include 'vinelibs/vine_parse.php'; 
      }
     if(isset($_SESSION['fb_object'])) {
        include 'facebook_parse.php';
     }
     if(isset($ig_username)){ 
        include 'instagram_parse.php';
     }
     if (isset ($_SESSION['access_token'])){
        include 'twitter_parse.php';
     }

    echo "<script>$(document).ready(function(){
      $('#pic1').hide();
       $('#background').css( 'display', 'block');

      // get array of elements
      var myArray = $('.brandon > div');
      var count = 0;

      // sort based on timestamp attribute
      myArray.sort(function (a, b) {
          
          // convert to integers from strings
          a = parseInt($(a).attr('timestamp'));
          b = parseInt($(b).attr('timestamp'));
          count += 2;
          // compare
          if(a < b) {
              return 1;
          } else if(a > b) {
              return -1;
          } else {
              return 0;
          }
      });
      // put sorted results back on page
      $('.brandon').append(myArray);
      });
  /*$(document).ready(function() {
      $('section').stickem();
    });*/
$(document).on('click', '.external', function (e) {
    e.preventDefault();
    var targetURL = $(this).attr('href');

    window.open(targetURL, '_system');
});
</script><!--<script type='text/javascript' src='facebooklibs/fb.js'></script>-->";

  }else{
    echo "<div class='pleaseLogIn'>Please Log into one of your Social accounts!</div>";
   echo "<script>$(document).ready(function(){
      $('#pic1').hide();
      $('.brandon').show();});</script>";
        
  }
  ?>
