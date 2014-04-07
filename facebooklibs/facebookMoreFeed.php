<?php 
//the paging works but it is kinda wonky, look into this more<---------------------*******
session_start();
include (__DIR__.'/auth.php');
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

$nextPage = $_SESSION['fb_object']['next'];
$nextPage = preg_replace('/https:\/\/graph.facebook.com/', '', $nextPage); 
$ret_obj = $facebook->api($nextPage,'GET');
$_SESSION['fb_object'] = $ret_obj['paging'];
include '../facebook_parse.php';

?>