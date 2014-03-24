<?php 
if (isset ($_SESSION['access_token'])){
$access_token = $_SESSION['access_token'];

$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $access_token['oauth_token'], $access_token['oauth_token_secret']);
$method = 'statuses/home_timeline.json?count=10';
$the_response = $connection->get($method);

foreach ($the_response as $twitter){
  $poster_id = $twitter->user->screen_name;
  $post_id = $twitter->id_str;
  $method =$poster_id . '/status/' . $post_id;
$twitterCreated = strtotime($twitter->created_at);
$the_comments = $connection->get($method);
echo "<div timestamp='$twitterCreated' class='stickem-container'>";
 echo "<div class='twitterPost' data-id='$post_id'>";
    if (isset($twitter->retweeted_status)){
      $img = $twitter->retweeted_status->user->profile_image_url;
      $retweeter = $twitter->user->name;
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
      echo "<div class='twitterHeader stickem'>Retweeted by " . $retweeter . "<br/>";
      echo "<img src='$img' style='border-radius: 10%;' />";
      echo "<span class='twitterUserName'>" . $user_name;
      echo "</span><span class='twitterRealName'> @" . $user_profile_name;
      echo "</span></div><div class='twitterTweet'>";
      echo $tweet;
      echo "</div>";
      if(isset($twitter->entities->media)){
        foreach($twitter->entities->media as $the_media){
          $some_media = $the_media->media_url;
          echo "<div><img src='$some_media'></div>";
        } 
      }
    }else{
      $img = $twitter->user->profile_image_url;
      $user_name = $twitter->user->name;
      $user_profile_name = $twitter->user->screen_name;
      $tweet = $twitter->text;
      $match = preg_match('/http:\/\/t.co([^ ]+)/', $tweet);
      if ($match === 1){
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
      echo "<div class='twitterHeader stickem'><img src='$img' style='border-radius: 10%;' />";
      echo "<span class='twitterUserName'>" . $user_name;
      echo "</span><span class='twitterRealName'> @" . $user_profile_name;
      echo "</span></div><div class='twitterTweet'>";
      echo $tweet;
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
    $post_time = time_elapsed_string($twitterCreated);
    echo "<div>Retweets " . $num_retweets . " - Favorites " . $num_favorites . " - " . $post_time;
    echo "</div><div><textarea rows='1' name='twitterComment' class='twitterComment' title='Write a comment...' placeholder='Write a comment...' style='height: 10px;' >Write a comment..</textarea>";
    echo "</div><div class='twitterCommentContainer'></div>";
    echo "<button class='twitterComments round' data='$poster_id' data-id='$post_id'>Expand Comments</button>";
    
    echo "</div></div>";
  }
}

?>