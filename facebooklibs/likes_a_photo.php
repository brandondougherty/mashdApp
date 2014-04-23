<?php
$id_of_self_post = preg_replace('/.*_/', '', $data['id']);
$self_post_url = '/' .$id_of_self_post;
$self_origin_post = $facebook->api($self_post_url,'GET');
if(isset($self_origin_post['error'])){

}else{
  $original_poster = $self_origin_post['from']['name'];
  $photo = $self_origin_post['source'];
 $name = $data['from']['name'];
$story = preg_replace('/'.$name.'/', "", $data['story']);
$id = $data['from']['id'];
echo "<div class='fbPostHead'><a class='fbUser' ng-click=\"goToFbUser('$id')\">$name</a>";
echo " ".$story."</div></div>";
  echo "<br/>";
  echo $original_poster . '<br/>';
  echo "<img src='$photo'/>";

}

 ?>