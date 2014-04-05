<?php 
session_start();
include (__DIR__.'/vine.php');
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
include 'vine_parse.php';
?>
