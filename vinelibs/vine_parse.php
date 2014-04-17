<?php 
foreach($records['data']['records'] as $vines){
  if(isset($vines['repost']['username']) && isset($vines['repost']['created']))
  {
  $poster_if_revined = $vines['repost']['username'];
  }
  $original_poster_avatar = $vines['avatarUrl'];
  $original_poster_username = $vines['username'];
  $description = $vines['description'];
  $likes= $vines['likes']['count'];
  $revines = $vines['reposts']['count'];
  $num_comments = $vines['comments']['count'];
  $postId = $vines['postIdStr'];
  $video_thumb = $vines['thumbnailUrl'];
$time = strtotime($vines['created']);
$the_time = time_elapsed_string(strtotime($vines['created']));
 #####START TO PRINT STUFF OUT HERE ###### 
          echo "<div timestamp='$time'>";
echo "<div class='vinepost' data='$postId'><div class='vineHeader'>";
if(isset($poster_if_revined)){
  echo "<span class='revined'>" . $poster_if_revined . " revined</span>";
   echo "<br/>";
}

echo "<img src='$original_poster_avatar' class='vineAvatar' height = 50px width = 50px > ";
echo "<span class='vineUsername'>" . $original_poster_username . "</span>"; 
echo "<span class='vineTime'>" . $the_time . "</span>";
echo "</div><img src='images/vine_corner_icon.svg' class='cornerIcon' />";
$video = $vines['videoUrl'];
$thumb = $vines['thumbnailUrl'];                
echo "<div class='newVideo'><video loop poster='$thumb' controls webkit-playsinline><source src='$video' codecs='avc1, mp4a' height=100% width=100% ></source></video></div>";
echo "<div class='vineMessage'><h4>" . $description;
echo "</h4></div>";
 echo "<hr><div class='igActions'>";
if($vines['liked'] == '1'){
  echo "<span class='vineButton'><a class='deletVineLike alert'>Like</a></span>";
}else{
  echo "<span class='vineButton'><a class='vineLike'>Like</a></span>";
}
echo "<span class='vineButton'><a class=\"vineComment\" ng-click=\"getViComments('$postId')\">Comment</a></span>";
if($vines['myRepostIdStr'] != '0'){
  $repostId = $vines['myRepostIdStr'];
  echo "<span class='vineButton'><a class='deletVineRevine' data='" .$repostId. "'>Revine</a></span>";
}else{
  echo "<a class='vineRevine igcommentStat'>Revine</a>";
}
echo "</div>";
echo "<div class='vineStats'>";
if(!empty($likes)){
     echo "<img class='igStats' src='images/igLike.svg'/>".$likes;
}
if(!empty($revines)){
   echo "<img class='vineStatscomment' src='images/revine.svg'/>".$revines;
}
if(!empty($num_comments)){
    echo "<img class='vineStatscomment' src='images/igcomment.svg'/>".$num_comments ;
}
  
    echo "</div><div class='vineCommentButton'>";
    //echo "<button type='button' class='ajaxcommentbutton1 round' group='$postId' data='2'>Load previous comments</button>";
    echo "</div>";
    echo "<div class='commentsContainer'>";
    echo "<div class='1'>";
     $vineI=0;
    while($vineI < 4){
      if(isset($vines['comments']['records'][$vineI])){
      $actual_comments = $vines['comments']['records'][$vineI];
      $comment_profile_img = $actual_comments['avatarUrl'];
      $comment_poster_username = $actual_comments['username'];
      $the_comment = $actual_comments['comment'];

      echo "<img src='$comment_profile_img' height = 15px width = 15px>'";
      echo $comment_poster_username;
      echo ' ' . $the_comment . '<br />';
    }
      $vineI++;
    }
    //var_dump($records['data']['records']);

    echo "</div></div></div></div>";
}
?>