  <!--/***********************************************facebook stuff*****/-->    
 <?php 
      // We have a user ID, so probably a logged in user.
      // If not, we'll get an exception, which we handle below.
        $likes = $facebook->api(array(
            'method' => 'fql.query',
            'query' => "SELECT object_id FROM like WHERE user_id = me() LIMIT 10"
        ));
       //var_dump($ret_obj);
        if(isset($ret_obj)){
        foreach($ret_obj['data'] as $the_post){
          $fbCreated = strtotime($the_post['created_time']); 
          echo "<div timestamp='$fbCreated'>";
          echo "<div class='fbPost' >";
          echo "<img src='images/facebook_corner_icon.svg' class='cornerIcon'/>";
          $data = $the_post;
          $aname = $data['from']['id'];
          $usr_post_pic = $facebook->api('/' . $aname . '?fields=picture','GET');
          $pic = $usr_post_pic['picture']['data']['url'];

###########   Printing USERS PROFILE PICTURE
          echo "<div class='fbPostHeadSuper'><img class='fbProfImg' src='$pic'/>";
############
          //$likeLink = $data['link'];
          //echo "<div class='fb-like' data-href='" . $likeLink. "' data-width='10px' data-layout='button_count' data-action='like' data-show-faces='false' data-share='true'></div>";
###########   Printing TITLE OF POST (POSTERS NAME, OR THE "STORY TITLE")
          if (empty($data['story'])){
              if(isset($data['application']['name']) && $data['application']['name'] === "Instagram"){
                include 'facebooklibs/liked_something_on_instagram.php';
              }else{
              include 'facebooklibs/normal_fb_post.php';
              }
            }elseif(preg_match("/commented on a status/",$data['story'])){
              include 'facebooklibs/commented_on_a_status.php';
            }elseif(preg_match("/commented on ... own status/",$data['story'])){
              include 'facebooklibs/commented_on_own_status.php';
            }elseif(preg_match("/commented on ... own link/",$data['story'])){
              include 'facebooklibs/commented_on_own_link.php';
            }elseif(preg_match("/commented on a video/",$data['story'])){
              include 'facebooklibs/commented_on_a_video.php';
            }elseif(preg_match("/commented on a link/",$data['story'])){
              include 'facebooklibs/commented_on_a_link.php';
            }elseif(preg_match("/commented on ... own photo/",$data['story'])){
              include 'facebooklibs/commented_on_own_photo.php';
            }elseif(preg_match("/is going to an event/",$data['story'])){
              include 'facebooklibs/going_to_an_event.php';//NEED TO WORK ON THIS
            }elseif(preg_match("/likes a link/",$data['story'])){
              include 'facebooklibs/likes_a_link.php';
            }elseif(preg_match("/shared a link/",$data['story'])){
              include 'facebooklibs/shared_a_link.php';
            }elseif(preg_match("/was tagged in /",$data['story'])){
              include 'facebooklibs/was_tagged.php';
            }elseif(preg_match("/likes a photo/",$data['story'])){
              include 'facebooklibs/likes_a_photo.php';
            }elseif(preg_match("/added/",$data['story']) && preg_match("/photo/",$data['story'])){
              include 'facebooklibs/added_x_photos.php';
            }else{ 
              $name = $data['from']['name'];
              $story = preg_replace('/'.$name.'/', "", $data['story']);
              $id = $data['from']['id'];
              echo "<div class='fbPostHead'><a class='fbUser' ng-click=\"goToFbUser('$id')\">$name</a>";
              echo " ".$story;
            if (isset($data['message'])){
              echo $data['message'];
              echo "<br/>";
            }
            echo "</div></div>";

############
###########   EITHER PRINTS THE YOUTUBE VIDEO, OR A DIRECTLY UPLOADED VIDEO, OR PICTURE              ###### ------> WHAT IF USER UPLOADED VIDEO AND PICTURE??
        if ((isset($data['source'])) && (preg_match("/youtube/",$data['source']))){
          $big_youtube2 = preg_replace('/.*?\//', '', $data['source']);
          $med_youtube2 = preg_replace('/\?.*/', '', $big_youtube2);
          $youtube_link2 = 'https://www.youtube.com/v/' . $med_youtube2 . '?version=3&amp;autohide=1&amp;autoplay=1';
          $youtube_embed_link2 = 'https://www.youtube.com/embed/' . $med_youtube2;

          echo "<iframe width='398' height='224' frameborder='0' scrolling='no' src =" . $youtube_embed_link2 . ">
          <!DOCTYPE html>
          <html>
            <head>
              <meta charset='utf-8'>
            </head>
            <body>
              <div class='newVideo'>
                <span>
                  <object type='application/x-shockwave-flash' data=" . $youtube_link2 . " height='224' width='398'>
                  </object>
                </span>
              </div>
            </body>
          </html>
          </iframe>";

        }elseif ((isset($data['source'])) && (preg_match("/.3g2|.mp4|.3gp|.gpp|.asf|.avi|.dat|.divx|.dv|.f4v|.flv|.m2ts|.m4v|.mkv|.mod|.mov|.mp4|.mpe|.mpeg|.mpeg4|.mpg|.mts|.nsv|.ogm|.ogv|.qt|.tod|.ts|.vob|.wmv/",$data['source']))){
          $video_up = $data['source'];
          echo "<div class='newVideo'><object data='$video_up' type='application/x-shockwave-flash' height=100% width=100%></object></div>";

        }elseif(isset($data['picture']) && preg_match('/fbexternal/', $data['picture'])){
              $urlOfExternal = preg_replace('/.*url=/', '', $data['picture']);
              $newUrlimg = urldecode($urlOfExternal);
              $urlLink =  $data['link'];

              echo "<a href='$urlLink' target='_blank'><img src='$newUrlimg' /></a>";
              echo "<br/>";
              if(isset($data['name']))
              {
                $articleName = $data['name'];
                echo $articleName;
                echo "<br/>";
              }
              if(isset($data['caption']))
              {
                $articleCaption = $data['caption'];
                echo $articleCaption;
                echo "<br/>";
              }
              if(isset($data['description']))
              {
                $articleDescription = $data['description'];
                echo $articleDescription;
              }
          }else{ 
              ###regular post
          if(isset($data['picture'])){
            $big_num = preg_replace('/\_s..../', '', $data['picture']);
            $med_num = preg_replace('/.*[\/]/', '', $big_num);
            $imglink = 'https://scontent-b-pao.xx.fbcdn.net/hphotos-prn1/' .$med_num. '_n.jpg';
            echo "<img src='$imglink' />";
          }

        }
        }
############
###########   END PRINTS THE YOUTUBE VIDEO, OR A DIRECTLY UPLOADED VIDEO, OR PICTURE   
          echo "<br/>";
          $post_time = time_elapsed_string($fbCreated);
          if(isset($data['object_id'])){
            $obj_id = $data['object_id'];
          }else{
            $obj_id = preg_replace('/.*_/', '', $data['id']);
          }
          $true='0';
          foreach($likes as $checkLike){
            if($checkLike['object_id'] === $obj_id){
              $true = '1';
            }
          }
           if(!empty($data['likes'])){
           $like_count = count($data['likes']['data']);
            if($like_count >= 25){
              $like_count = $like_count."+";
            }
          }else{
            $like_count = 0;
          }
          /*$like_count = count($data['likes']['data']);
          while($y < $like_count){
              echo $data['likes']['data'][$y]['name'];
              echo "<br/>";
              $y++;
          }*/
          if(!empty($data['comments'])){
            $comment_count = count($data['comments']['data']);
            if($comment_count >= 25){
              $comment_count = $comment_count."+";
            }
          }else{
            $comment_count = 0;
          } 
          if($true=='1'){
            echo "<button class='deleteFbLike button fbButton radius alert' data='".$obj_id."'>Like</button>";
          }else{
            echo "<button class='fbLike button fbButton radius' data='".$obj_id."'>Like</button>";
          }
          echo "<a ng-click=\"getFbLikes('$obj_id')\">".$like_count."</a>";
          echo " <button class=\"fbComment button fbButton radius\" ng-click=\"getFbComments('$obj_id')\">Comment</button>";
          echo "<span class='numFbLikes'>".$comment_count."</span>";
          echo "<button class=\"fbShare button fbButton radius\" ng-click=\"fbShare('$obj_id')\">Share</button>";
          echo $post_time . " <br />";
          //echo "<textarea rows='1' name='fbComment' class='fbComment' title='Write a comment...' placeholder='Write a comment...' style='height: 10px;' >Write a comment..</textarea>";
          if(isset($data['comments'])){
            $i = 0;
           while($i<5) {
              if(isset($data['comments']['data'][$i])){
              $comment = $data['comments']['data'][$i]; 
                $time = time_elapsed_string(strtotime($comment['created_time']));
                echo '<b>'.$comment['from']['name'] . '</b> ' . $comment['message'] . ' - ' . $time;
                echo "<br />";
                
              }
            $i++;
            }
          }
         //print_r($data);
          echo "</div>";
          echo "</div>";

         }
       }
?>
