<?php
$id_of_self_post = preg_replace('/.*_/', '', $data['id']);
$self_post_url = '/' .$id_of_self_post;
$self_origin_post = $facebook->api($self_post_url,'GET');
  $original_poster = $self_origin_post['from']['name'];
  $photo = $self_origin_post['source'];
  echo $data['story'];
  echo "<br/>";
  echo $original_poster . '<br/>';
  echo "<img src='$photo'/>";
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


 ?>