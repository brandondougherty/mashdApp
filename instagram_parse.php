<?php #print_r($result);?>
<?php
  foreach ($result->data as $media) {
    $postId = $media->id;
    $igCreated = $media->created_time;
    echo "<div timestamp='$igCreated' class='stickem-container'>";
    echo "<div class='instagramPost' group='$postId'>";
    echo "<a id='$postId'></a>";
    $profilepic = $media->user->profile_picture;
    $igposter = $media->user->username;
    $created_time = time_elapsed_string($igCreated);
    if(isset($media->location) && isset($media->location->name)){
      $location = $media->location->name;
    }
    echo "<div class='stickem'><div class='igAvatar'><img src ='$profilepic' width='55' height='55'/>";
    echo "<span class='instagramUserName'>" . $igposter . "</span><span class='instagramTime'>" . $created_time . "</span></div><img src='images/instagram_corner_icon.svg' class='cornerIcon' /></div>";
    echo "<hr>";
    /*if(isset($media->location->name)){
      $location = $media->location->name;
      echo $location;
      echo "<br/>";
    }*/
    // output media
    if ($media->type === 'video') {
      // video
      $poster = $media->images->standard_resolution->url;
      $source = $media->videos->standard_resolution->url . '?';
      //echo "<div class='newVideo'><video controls poster='$poster' webkit-playsinline ><source src='$source' type='mp4' height=100% width=100%></source></video></div>";
      echo "<div class='newVideo'><video loop poster='$poster' webkit-playsinline=true><source src='$source' codecs='avc1, mp4a' height=100% width=100% ></source></video></div>";    
    } else {
      // image
      $image = $media->images->standard_resolution->url;
      echo "<div><img class=\"media\" src=\"{$image}\"/></div>";
    }
    
    // create meta section
   
    if(!empty($media->caption->text)){
   echo "<div class='igcomment'><span class='instaCommentUserName'>$igposter</span> {$media->caption->text}</div>";
    }
    $likes = $media->likes->count;
    if(isset($media->comments)){
      $num_of_comments = $media->comments->count;
    }else{
      $num_of_comments = '0';}
     echo "<hr><div class='igActions'>";
    //echo "<div><textarea rows='1' name='instagramComment' class='instagramComment' title='Write a comment...' placeholder='Write a comment...' style='height: 10px;' >Write a comment..</textarea>";
   if(!empty($media->user_has_liked)){
      echo "<a class=' igButton deletInstagramLike'>Unlike</a>";
   }else{
      echo "<a class=' igButton likeInstagram'>Like</a>";
   }
      echo "<a class=\" igButton commentInstagram\" ng-click=\"getIgComments('$postId')\">Comment</a>";
    echo "<span class='igButton'><img class='igStats' src='images/igLike.svg'/>" . $likes . "</span><span class='igcommentStat'><img class ='igStats' src='images/igcomment.svg'/>" . $num_of_comments."</span></div>";
    if(!empty($media->comments->data)){
      echo "<hr><div class='commentsContainer'>";
      echo "<div class='1'>";
        $i=0;
        while($i < 3){
          if(isset($media->comments->data[$i])){
            $comments = $media->comments->data[$i];
            $comment_img = $comments->from->profile_picture;
            $comment_name = $comments->from->username;
            $comment_text = $comments->text;
            echo "<img src='$comment_img' width='30px' height='30px'/> ";
            echo $comment_name . ' - ';
            echo $comment_text . "<br/>";
          }
          $i++;
        }
        echo "</div>";
        /*if($media->comments->count > 5){
          echo "<button class='instaComments radius' group='$postId' data='9'>Load comments</button>";
        }*/
        echo "</div>";
      }

    echo "</div></div></div>";
    //print_r($media);
    //echo "<br/><br/>";
  }
?>