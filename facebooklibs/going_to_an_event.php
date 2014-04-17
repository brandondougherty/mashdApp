<?php
$eventId = preg_replace('/\D/', '', $data['link']);
$event_origin_post = $facebook->api($eventId,'GET');
 $name = $data['from']['name'];
$story = preg_replace('/'.$name.'/', "", $data['story']);
$id = $data['from']['id'];
if(isset($event_origin_post['start_time'])){
$date= date("F jS, Y", strtotime($event_origin_post['start_time'])); 
}
if(isset($event_origin_post['name'])){
	$header = $event_origin_post['name'];
}
if(isset($event_origin_post['description'])){
	$description = $event_origin_post['description'];
}
echo "<div class='fbPostHead'><a class='fbUser' ng-click=\"goToFbUser('$id')\">$name</a>";
echo " ".$story."</div></div>";
echo "<div>";
echo "<h2>".$header."</h2>";
echo "<div class='fbcontent'><h3>".$date."</h3>";
echo $description."</div>";
echo "</div>";

?>