<?php 
session_start();
include (__DIR__.'/twitterauth.php');
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
}}}
$id= $_SESSION['twitter_object']['max_id'];
$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $access_token['oauth_token'], $access_token['oauth_token_secret']);
$method = 'statuses/home_timeline.json?count=11&max_id='.$id;
$the_response = $connection->get($method);
$max_id = $the_response[10]->id_str;
$twitterObj = array('max_id'=>$max_id);
$_SESSION['twitter_object'] = $twitterObj;

include '../twitter_parse.php';
?>