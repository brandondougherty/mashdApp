<?php 
session_start();
include (__DIR__.'/vine.php');


	$vine = new Vine;
$key = $_SESSION['vine_key'];
if(!isset($_SESSION['vine_object'])){
	 $newObj = $vine->vineTimeline($key);
	 $_SESSION['vine_object'] = $newObj['data']['nextPage'];
	$obj = $_SESSION['vine_object'];
	$page = $obj['data']['nextPage'];
}else{
	$obj = $_SESSION['vine_object'];
	$page = $obj['data']['nextPage'];
}
var_dump($_SESSION);
$timelineId = $records['data']['anchorStr'];
$records= $vine->nextSetofTimelines($key,$page,$timelineId);
$_SESSION['vine_object'] = $records['data']['nextPage'];
include 'vine_ajax_parse.php';
?>
<!--
put a button number in to increment the page
-each time the button is clicked it increments the new buttton page tag that is being printed.
timelineid == 
->