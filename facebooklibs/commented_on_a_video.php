<?php
$id_of_self_post = preg_replace('/.*_/', '', $data['id']);
$self_post_url = '/' .$id_of_self_post;
$self_origin_post = $facebook->api($self_post_url,'GET');
$vidoProfileImageId = $self_origin_post['from']['id'];
$videoProfileURL = $facebook->api('/' . $vidoProfileImageId . '?fields=picture','GET');
$videoProfileImg = $videoProfileURL['picture']['data']['url'];
  echo $data['story'];
  echo "<br/>";
                echo "<img src='$videoProfileImg'/> ";
                
                $videoUsername = $self_origin_post['from']['name'];
                echo $videoUsername;
                echo "<br/>";                
                if(isset($self_origin_post['description']))
                {
                  $videoMessage = $self_origin_post['description'];
                  echo $videoMessage;
                  echo "<br/>";
                }
                  $videoContent = $self_origin_post['embed_html'];
                echo $videoContent;
                if(!empty($self_origin_post['likes'])){
                echo "<br/>";
                $likes_count1 = count($self_origin_post['likes']['data']);
                echo "Likes: " . $likes_count1;
                /* $x=0;
                $likes_count1 = count($self_origin_post['likes']['data']);
                while($x < $likes_count1){
                    echo $self_origin_post['likes']['data'][$x]['name'];
                    echo "<br/>";
                    $x++;
                }*/
              }
              if(!empty($self_origin_post['comments'])){
                $comment_count = count($self_origin_post['comments']['data']);
                echo "Comments: " . $comment_count;
              }
      echo "<br/>";
//var_dump($self_origin_post);
?>