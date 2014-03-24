<?php

foreach($records['data']['records'] as $vines){
  $poster_if_revined = $vines['repost']['username'];
  $original_poster_avatar = $vines['avatarUrl'];
  $original_poster_username = $vines['username'];
  $description = $vines['description'];
  $likes= $vines['likes']['count'];
  $revines = $vines['reposts']['count'];
  $num_comments = $vines['comments']['count'];
if(isset($poster_if_revined)){
  echo $poster_if_revined . " revined";
}
  echo "<br/>";

echo "<img src='$original_poster_avatar' height = 50px width = 50px> ";
echo $original_poster_username;
echo "<br/>";
$video = $vines['videoUrl'];
                               
echo "<video width='350' height='350' controls loop>
<source src='$video'>
<object data='$video' width='350' height='350'></object>
</video>";
echo "<br/>";
echo $description;
echo "<br/>";
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
    echo "<br/><br/>";
}

#End If isset
?>