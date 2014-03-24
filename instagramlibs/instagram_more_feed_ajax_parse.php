<?php
          foreach ($result->data as $media) {
            $postId = $media->id;
            echo "<div class='instagramPost' group='$postId'>";
            $profilepic = $media->user->profile_picture;
            $igposter = $media->user->username;
            $created_time = $media->created_time;
            $diff = (time() - ($created_time));
            if(isset($media->location) && isset($media->location->name)){
              $location = $media->location->name;
            }
            #echo $created_time;
            #echo $diff;
            echo strftime("%r", $diff);

            #echo strftime('%t', ($created_time));
            echo "<img src ='$profilepic' width='55' height='55'/>";
            echo $igposter;
            echo "<br/>";
            if(isset($media->location->name)){
              $location = $media->location->name;
              echo $location;
              echo "<br/>";
            }
            // output media
            if ($media->type === 'video') {
              // video
              $poster = $media->images->low_resolution->url;
              $source = $media->videos->standard_resolution->url;
              echo "<video  width=\"250\" height=\"250\" controls>
                             <source src=\"{$source}\" type=\"video/mp4\" />
                             <object data=\"{$source}\" width=\"250\" height=\"250\"></object>
                           </video><br/>";
            } else {
              // image
              $image = $media->images->low_resolution->url;
              echo "<img class=\"media\" src=\"{$image}\"/><br/>";
            }
            
            // create meta section
            
            if(!empty($media->caption->text)){
           echo "<div class=\"content\">
                           <div class=\"comment\">{$media->caption->text}</div>
                         </div>";
            }
            $likes = $media->likes->count;
            echo "Likes " . $likes;
            echo "<br/>";
            if(!empty($media->comments->data)){
              echo "<div class='commentsContainer'>";
              echo "<div class='1'>";
                $i=0;
                while($i < 5){
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
                if($media->comments->count > 5){
                  echo "<button class='instaComments' group='$postId' data='9'>Load previous comments</button>";
                }
                echo "</div>";
              }

            echo "</div><br/>";
            //print_r($media);
            //echo "<br/><br/>";
          }
        ?>