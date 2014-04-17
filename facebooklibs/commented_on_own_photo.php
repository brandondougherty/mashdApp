<?php
#commented_on_own_link
$id_of_self_post = preg_replace('/.*_/', '', $data['id']);
$self_post_url = '/' .$id_of_self_post;
$self_origin_post = $facebook->api($self_post_url,'GET');
  $name = $data['from']['name'];
$story = preg_replace('/'.$name.'/', "", $data['story']);
$id = $data['from']['id'];
echo "<div class='fbPostHead'><a class='fbUser' ng-click=\"goToFbUser('$id')\">$name</a>";
echo " ".$story."</div></div>";
  echo "<br/>";
 if(isset($self_origin_post['name']))
  {
    $articleName = $self_origin_post['name'];
    echo $articleName;
    echo "<br/>";
  }$photo = $self_origin_post['source'];
  echo "<img src='$photo'/>";
  echo "<br/>";
?>