<?php
foreach($vines['data']['records'] as $actual_comments){
      $comment_profile_img = $actual_comments['avatarUrl'];
      $comment_poster_username = $actual_comments['username'];
      $the_comment = $actual_comments['comment'];
      echo "<img src='$comment_profile_img' height = 15px width = 15px>'";
      echo $comment_poster_username;
      echo ' ' . $the_comment . '<br />';
      
    }
?>