<?php 
//var_dump($the_response);
$m=0;
foreach ($the_response as $twitter){
  $m++;
  if($m==11){
    //do nothing
  }else{
  $poster_id = $twitter->user->screen_name;
  $post_id = $twitter->id_str;
  $id = $twitter->id;
  $retweeter_sn = '';
  $method =$poster_id . '/status/' . $post_id;
$twitterCreated = strtotime($twitter->created_at);
$the_comments = $connection->get($method);
    $post_time = time_elapsed_string($twitterCreated);

    if (isset($twitter->retweeted_status)){
      echo "<div timestamp='$twitterCreated' class='stickem-container'>";
      $post_id = $twitter->retweeted_status->id_str;
      $poster_id = $twitter->retweeted_status->user->screen_name;
 echo "<div class='twitterPost' data-id='$post_id'>";
      $img = $twitter->retweeted_status->user->profile_image_url;
      $retweeter = $twitter->user->name;
      $retweeter_sn = $twitter->user->screen_name;
      $user_name = $twitter->retweeted_status->user->name;
      $user_profile_name = $twitter->retweeted_status->user->screen_name;
      $tweet = $twitter->retweeted_status->text;
      $match = preg_match('/http:\/\/t.co([^ ]+)/', $tweet);
      if ($match === 1){
        if(!empty($twitter->entities->urls)){
          foreach($twitter->entities->urls as $urlss){
            $the_url = $urlss->url;
            $the_new_url = "<a href='$urlss->expanded_url' class='external' >" .  $urlss->display_url . "</a>";
          $tweet = str_replace($the_url, $the_new_url, $tweet);
          }
        }
        if(isset($twitter->entities->media)){
         foreach($twitter->entities->media as $other_urls){
            $the_url = $other_urls->url;
            $the_new_url = "<a href='$other_urls->expanded_url' class='external'>" .  $other_urls->display_url . "</a>";
          $tweet = str_replace($the_url, $the_new_url, $tweet);
          }
        }

      }
      echo "<span class='retweeted'>Retweeted by " . $retweeter . "</span><br/>";
      echo "<div class='twImg'><img src='$img' style='border-radius: 10%;' /></div><div class='twitterHeader stickem'>";
      echo "<span class='twitterUserName'>" . $user_name."</span>";
      echo "<span class='twitterRealName'> @" . $user_profile_name."</span>";
      echo " - $post_time</div><img src='images/twitter_corner_icon.svg' class='cornerIcon' /><div class='twitterTweet'>";
      echo $tweet;
      echo "</div>";
      if(isset($twitter->entities->media)){
        foreach($twitter->entities->media as $the_media){
          $some_media = $the_media->media_url;
          echo "<div><img src='$some_media'></div>";
        } 
      }
      //var_dump($twitter);
    }else{
      echo "<div timestamp='$twitterCreated' class='stickem-container'>";
 echo "<div class='twitterPost' data-id='$post_id'>";
      $img = $twitter->user->profile_image_url;
      $user_name = $twitter->user->name;
      $user_profile_name = $twitter->user->screen_name;
      $tweet = $twitter->text;
      if (preg_match('/http(|s):\/\/t.co([^ ]+)/', $tweet)){
        if(!empty($twitter->entities->urls)){
          foreach($twitter->entities->urls as $urlss){
            $the_url = $urlss->url;
            $the_new_url = "<a href='$urlss->expanded_url' class='external'>" .  $urlss->display_url . "</a>";
          $tweet = str_replace($the_url, $the_new_url, $tweet);
          }
        }
        if(isset($twitter->entities->media)){
         foreach($twitter->entities->media as $other_urls){
            $the_url = $other_urls->url;
            $the_new_url = "<a href='$other_urls->expanded_url' class='external'>" .  $other_urls->display_url . "</a>";
          $tweet = str_replace($the_url, $the_new_url, $tweet);
          }
        }
        
      }
      echo "<div class='twImg'><img src='$img' style='border-radius: 10%;' /></div><div class='twitterHeader stickem'>";
      echo "<span class='twitterUserName'>" . $user_name;
      echo "</span><span class='twitterRealName'> @" . $user_profile_name;
      echo "</span> - $post_time</div><img src='images/twitter_corner_icon.svg' class='cornerIcon' /><div class='twitterTweet'>";
      echo $tweet;
      if(preg_match('/Vine/', $twitter->source)){
          echo "<div class='newVideo'><video controls webkit-playsinline ><source src='".$twitter->entities->urls[0]->expanded_url."' type='mp4' height=100% width=100%></source></video></div>";
        }
      echo "</div>";
      if(isset($twitter->entities->media)){
        foreach($twitter->entities->media as $the_media){
          $some_media = $the_media->media_url;
          echo "<div><img src='$some_media'></div>";
        } 
      }
    }
    $num_retweets = $twitter->retweet_count;
    $num_favorites = $twitter->favorite_count;
    echo "<hr><div class='igActions'>";
    if($twitter->retweeted == true){
      echo "<span class='twButton'><a class='deleteTwitterRetweet' data='".$post_id."'>Retweet </a>". $num_retweets."</span>";
    }else{
      echo "<span class='twButton'><a class='twitterRetweet' data='".$post_id."'>Retweet </a>". $num_retweets."</span>";
    }
    if($twitter->favorited == true){
      echo "<span class='twButton'><a class='deleteTwitterFav' data='".$post_id."'>Unfavorite </a>".$num_favorites."</span>";

    }else{
      echo "<span class='twButton'><a class='twitterFav' data='".$post_id."'>Favorite </a>".$num_favorites."</span>";
    }
    if(isset($retweeter_sn)){
      echo "<span class='igcommentStat'><a class=\"twitterComments\" ng-click=\"getTwComments('$poster_id','$post_id', '$retweeter_sn')\">Reply</a></span>";
    }else{
      echo "<span class='igcommentStat'><a class=\"twitterComments\" ng-click=\"getTwComments('$poster_id','$post_id')\">Reply</a></span>";

    }
     echo "</div><hr><br/><br/>";
    //echo "</div><div><textarea rows='1' name='twitterComment' class='twitterComment' title='Write a comment...' placeholder='Write a comment...' style='height: 10px;' >Write a comment..</textarea>";
   // echo "<div class='twitterCommentContainer'></div>";
    //echo "<button class='twitterComments round' data='$poster_id' data-id='$post_id'>Expand Comments</button>";
  
    echo "</div></div>";
    //var_dump($twitter);
  }
  }
?>