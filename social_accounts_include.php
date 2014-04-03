<?php 
include 'facebooklibs/auth.php';
include 'instagramlibs/instagramAuth.php';
include 'twitterlibs/twitterauth.php';
include 'vinelibs/vine.php';
function time_elapsed_string($ptime)
{
    $etime = time() - $ptime;

    if ($etime < 1)
    {
        return '0 seconds';
    }

    $a = array( 12 * 30 * 24 * 60 * 60  =>  'y',
                30 * 24 * 60 * 60       =>  'month',
                24 * 60 * 60 * 7        =>  'wk',
                24 * 60 * 60            =>  'd',
                60 * 60                 =>  'h',
                60                      =>  'min',
                1                       =>  's'
                );

    foreach ($a as $secs => $str)
    {
        $d = $etime / $secs;
        if ($d >= 1)
        {
            $r = round($d);
            return $r . ' ' . $str . ' ago';
        }
    }
}  //var_dump($_SESSION);
if ($user){
    $user_id = $facebook->getUser();
          $ret_obj = $facebook->api('/me/home','GET');
       }
  if (isset($_SESSION['vine_key']) && isset($_SESSION['vine_userid'])){
    $vine = new Vine;
    $key = $_SESSION['vine_key'];
    $records = $vine->vineTimeline($key);
  }
    if($user||isset($_SESSION['vine_key'])||isset($_SESSION['vine_userid'])||isset($_SESSION['access_token'])||isset($_SESSION['instagram'])||isset($user_id))
    {
     include 'vinelibs/vine_parse.php'; 
     include 'facebook_parse.php'; 
     include 'instagram_parse.php';
     include 'twitter_parse.php';
   // echo "<button type='button' class='loadMoreFeed'>Request data</button>";

    echo "<script>$(document).ready(function(){
      $('#pic1').hide();
       $('#background').css( 'display', 'block');
      $('.brandon').show();

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
