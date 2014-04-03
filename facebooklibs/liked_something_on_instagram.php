<?php
if(isset($data['object_id'])){
$self_post_url = '/' .$data['object_id'];
$self_origin_post = $facebook->api($self_post_url,'GET');

echo $data['from']['name'];
echo "<br/>";
echo $self_origin_post['name'];
echo "<br/>";
$image = $self_origin_post['source'];
echo "<img src='$image'/>";
echo "<br />";
  if(!empty($self_origin_post['likes'])){
  echo "<br/>";
  $like_count = count($self_origin_post['likes']['data']);
  echo "Likes: " . $like_count;
  $y = 0;
  /*$like_count = count($data['likes']['data']);
  while($y < $like_count){
      echo $data['likes']['data'][$y]['name'];
      echo "<br/>";
      $y++;
  }*/
  }
  
  if(!empty($self_origin_post['comments'])){
    $comment_count = count($self_origin_post['comments']['data']);
    echo "Comments: " . $comment_count;
  }


}else{

$id_of_self_post = preg_replace('/.*_/', '', $data['id']);
$self_post_url = '/' .$id_of_self_post;
$self_origin_post = $facebook->api($self_post_url,'GET');
echo $data['from']['name'] . " liked this Instagram post.";
if(isset($data['mesage'])){
  echo $data['message'];
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
  if(!empty($self_origin_post['likes'])){
  echo "<br/>";
  $like_count = count($self_origin_post['likes']['data']);
  echo "Likes: " . $like_count;
  $y = 0;
  /*$like_count = count($data['likes']['data']);
  while($y < $like_count){
      echo $data['likes']['data'][$y]['name'];
      echo "<br/>";
      $y++;
  }*/
  }
  
  if(!empty($self_origin_post['comments'])){
    $comment_count = count($self_origin_post['comments']['data']);
    echo "Comments: " . $comment_count;
  }
}

 ?>