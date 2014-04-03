<?php 

if (isset ($_SESSION['vine_key']) && isset($_SESSION['vine_userid'])){

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
if($vines['liked'] == '1'){
  echo " <button class='button small round deletVineLike alert'>Like</button>";
}else{
  echo " <button class='button small round vineLike'>Like</button>";
}
echo " <button class='button small round vineComment'>Comment</button>";
if($vines['myRepostIdStr'] != '0'){
  $repostId = $vines['myRepostIdStr'];
  echo " <button class='button small round deletVineRevine alert' data='" .$repostId. "'>Revine</button>";
}else{
  echo " <button class='button small round vineRevine'>Revine</button>";
}
echo "<div class='vineStats'>";
if(!empty($likes)){
      $num_likes = (int)str_replace(' ', '', $likes);
      if($num_likes > 1){
  echo $likes . " Likes ";
  }else{
    echo $likes . 'like';
  }
}
if(!empty($revines)){
  $num_revines = (int)str_replace(' ', '', $revines);
      if($num_revines > 1){
  echo $revines . " Revines ";
  }else{
    echo $revines . ' Revine';
  }
}
if(!empty($num_comments)){
  $num_of_comments = (int)str_replace(' ', '', $num_comments);
  if($num_of_comments > 1){
  echo $num_comments . " Comments ";
  }else{
    echo $num_comments . ' Comment';
  }
}
    echo "</div><div class='vineCommentButton'>";
    echo "<button type='button' class='ajaxcommentbutton1 round' group='$postId' data='2'>Load previous comments</button>";
    echo "</div>";
    echo "<div class='commentsContainer'>";
    echo "<div class='1'>";
     $vineI=0;
    while($vineI < 6){
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

}#End If isset
?>