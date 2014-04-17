<?php
if(isset($data['object_id'])){
$self_post_url = '/' .$data['object_id'];
$self_origin_post = $facebook->api($self_post_url,'GET');

$name = $self_origin_post['from']['name'];
$id = $self_origin_post['from']['id'];
echo "<div class='fbPostHead'><a class='fbUser' ng-click=\"goToFbUser('$id')\">$name</a>";
if(isset($self_origin_post['name'])){
  echo $self_origin_post['name'];
}
echo "</div>";
echo "<br/>";
if ((isset($self_origin_post['source'])) && (preg_match("/.3g2|.mp4|.3gp|.gpp|.asf|.avi|.dat|.divx|.dv|.f4v|.flv|.m2ts|.m4v|.mkv|.mod|.mov|.mp4|.mpe|.mpeg|.mpeg4|.mpg|.mts|.nsv|.ogm|.ogv|.qt|.tod|.ts|.vob|.wmv/",$self_origin_post['source']))){
          $video_up = $self_origin_post['source'];
          echo "<div class='newVideo'><object data='$video_up' type='application/x-shockwave-flash' height=100% width=100%></object></div>";
}else{
$image = $self_origin_post['source'];
echo "<img src='$image'/>";
}
echo "<br />";

}else{

$id_of_self_post = preg_replace('/.*_/', '', $data['id']);
$self_post_url = '/' .$id_of_self_post;
$self_origin_post = $facebook->api($self_post_url,'GET');
$name = $data['from']['name'];
$id = $data['from']['id'];
echo "<div class='fbPostHead'><a class='fbUser' ng-click=\"goToFbUser('$id')\">$name </a>liked this Instagram post.</div></div>";
if(isset($data['mesage'])){
  echo "<div class='fbcontent'>";
  echo $data['message'];
  echo "</div>";
  echo "<br />";
}
if(!empty($self_origin_post['image'])){
  echo "<br/>";
  $picture = $self_origin_post['image']['0']['url'];
  echo "<img src='$picture' alt='test'/>";
  echo "<br/>";
  echo $self_origin_post['message'];
}else{
  $go_deeper = '/' . $self_origin_post['data']['object']['id'];
  $instagram_photo_url = $facebook->api($go_deeper,'GET');
$photo = $instagram_photo_url['image']['0']['url'];
echo "<br/>";
echo "<img src='$photo' />";
echo "<br/>";echo "<br/>";
echo $instagram_photo_url['description'];
}
 
}

 ?>