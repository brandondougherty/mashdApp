<?php 
session_start();
include (__DIR__.'/vine.php');


	$vine = new Vine;
$key = $_SESSION['vine_key'];

$records = $vine->vineTimeline($key);
$page = $records['data']['nextPage'];
$timelineId = $records['data']['anchorStr'];
$records= $vine->nextSetofTimelines($key,$page);
include 'vine_ajax_parse.php';
echo "<button type='button' onclick='loadXMLDoc()'>Request data</button>";
?>
<!--
put a button number in to increment the page
-each time the button is clicked it increments the new buttton page tag that is being printed.
timelineid == 
->