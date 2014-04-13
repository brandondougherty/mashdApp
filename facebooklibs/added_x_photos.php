<?php
$object_id = $data['object_id'];
$self_origin_post = $facebook->api($object_id,'GET');
$photo = $self_origin_post['source'];
//$self_origin_post = $facebook->api($object_id."?fields=album",'GET');
//then get album->id/photos
$name = $data['from']['name'];
$story = preg_replace('/'.$name.'/', "", $data['story']);
$id = $data['from']['id'];
echo "<div class='fbPostHead'><a class='fbUser' ng-click=\"goToFbUser('$id')\">$name</a>";
echo " ".$story."</div></div>";
echo "<br/>";
echo "<a ng-click=\"goToFBAlbum('$object_id')\"><img src='$photo'/></a>";



?>