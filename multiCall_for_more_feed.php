<?php 
include 'facebooklibs/auth.php';
include 'instagramlibs/instagramAuth.php';
include 'twitterlibs/twitterauth.php';
include 'vinelibs/vine.php';
function time_elapsed_string($ptime){
    $etime = time() - $ptime;
    if ($etime < 1){
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
    foreach ($a as $secs => $str){
        $d = $etime / $secs;
        if ($d >= 1){
            $r = round($d);
            return $r . ' ' . $str . ' ago';
        }
    }
}  


 if(isset($_SESSION['fb_object'])||isset($_SESSION['vine_key'])||isset($_SESSION['vine_userid'])||isset($_SESSION['access_token'])||isset($_SESSION['instagram']))
 {
 	//Calls
 	if(isset ($_SESSION['vine_key']) && isset($_SESSION['vine_userid'])){
       	$vine = new Vine;
		$key = $_SESSION['vine_key'];
		$obj = $_SESSION['vine_object'];
			$page = $obj['page'];
			$timelineId = $obj['timelineId'];
		//var_dump($obj);
		$records= $vine->nextSetofTimelines($key,$page,$timelineId);
			$page = $records['data']['nextPage'];
		    $timelineId = $records['data']['anchorStr'];
		    $package = array('page'=>$page, 'timelineId'=>$timelineId);
		    $_SESSION['vine_object'] = $package; 
      }
     if(isset($_SESSION['fb_object'])) {
      	$nextPage = $_SESSION['fb_object']['next'];
		$nextPage = preg_replace('/https:\/\/graph.facebook.com/', '', $nextPage); 
		$ret_obj = $facebook->api($nextPage,'GET');
		$_SESSION['fb_object'] = $ret_obj['paging'];
     }
     if(isset($ig_username)){ 
       	$package = $_SESSION['igObject'];
		$result = $instagram->pagination($package, 10);
		$_SESSION['igObject'] = $result->pagination; 
     }
     if (isset ($_SESSION['access_token'])){
       	$id= $_SESSION['twitter_object']['max_id'];
		$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $access_token['oauth_token'], $access_token['oauth_token_secret']);
		$method = 'statuses/home_timeline.json?count=11&max_id='.$id;
		$the_response = $connection->get($method);
		$max_id = $the_response[10]->id_str;
		$twitterObj = array('max_id'=>$max_id);
		$_SESSION['twitter_object'] = $twitterObj;
     }
     //Parsing
     if(isset ($_SESSION['vine_key']) && isset($_SESSION['vine_userid'])){
        include 'vinelibs/vine_parse.php'; 
      }
     if(isset($user)) {
        include 'facebook_parse.php';
     }
     if(isset($ig_username)){ 
        include 'instagram_parse.php';
     }
     if (isset ($_SESSION['access_token'])){
        include 'twitter_parse.php';
     }
   // echo "<button type='button' class='loadMoreFeed'>Request data</button>";

    echo "<script src='app/js/loadmore.js'></script>";
  }   
  ?>
