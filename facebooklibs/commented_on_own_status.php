<?php
$id_of_self_post = preg_replace('/.*_/', '', $data['id']);
$self_post_url = '/' .$id_of_self_post;
$self_origin_post = $facebook->api($self_post_url,'GET');
 $name = $data['from']['name'];
$story = preg_replace('/'.$name.'/', "", $data['story']);
$id = $data['from']['id'];
echo "<div class='fbPostHead'><a class='fbUser' ng-click=\"goToFbUser('$id')\">$name</a>";
echo " ".$story."</div></div>";
  echo "<br/>";
               if (isset($self_origin_post['to'])){
                   echo " to " . $self_origin_post['to']['data']['0']['name'];
                   echo "<br/>";
                }     
      ############
      ###########  PRINTS THE MESSAGE OF THE POST IF ANY        
                if (isset($self_origin_post['message'])){
                  echo "<div class='fbcontent'>";
                    echo $self_origin_post['message'];
                   echo "</div>";
                  }
               
      ############
      ###########   EITHER PRINTS THE YOUTUBE VIDEO, OR A DIRECTLY UPLOADED VIDEO, OR PICTURE              ###### ------> WHAT IF USER UPLOADED VIDEO AND PICTURE??
              if ((isset($self_origin_post['source'])) && (preg_match("/youtube/",$self_origin_post['source']))){
                $big_youtube1 = preg_replace('/.*?\//', '', $self_origin_post['source']);
                $med_youtube1 = preg_replace('/\?.*/', '', $big_youtube1);
                $youtube_link1 = 'https://www.youtube.com/v/' . $med_youtube1 . '?version=3&amp;autohide=1&amp;autoplay=1';
                $youtube_embed_link1 = 'https://www.youtube.com/embed/' . $med_youtube1;

                echo "<iframe width='398' height='224' frameborder='0' scrolling='no' src =" . $youtube_embed_link1 . ">
                <!DOCTYPE html>
                <html>
                  <head>
                    <meta charset='utf-8'>
                  </head>
                  <body>
                    <div>
                      <span>
                        <object type='application/x-shockwave-flash' data=" . $youtube_link1 . " height='224' width='398'>
                        </object>
                      </span>
                    </div>
                  </body>
                </html>
                </iframe>";

              }elseif ((isset($self_origin_post['source'])) && (preg_match("/\.3g2|\.3gp|\.gpp|\.asf|\.avi|\.dat|\.divx|\.dv|\.f4v|\.flv|\.m2ts|\.m4v|\.mkv|\.mod|\.mov|\.mp4|\.mpe|\.mpeg|\.mpeg4|\.mpg|\.mts|\.nsv|\.ogm|\.ogv|\.qt|\.tod|\.ts|\.vob|\.wmv/",$origin_post['source']))){
                $video_up2 = $self_origin_post['source'];
                echo "<video width='320' height='240' controls >
                  <source src='$video_up2' type='video/mp4'/>
                  <object data='$video_up2' width='320' height='240'></object>
                </video>";

              }elseif (isset($self_origin_post['images'])){
                  $imglink2 = $self_origin_post['images']['source'][0];
                  echo "<img src='$imglink2'/>";
                }
               if(!empty($self_origin_post['likes'])){
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
      ############
      ###########   END PRINTS THE YOUTUBE VIDEO, OR A DIRECTLY UPLOADED VIDEO, OR PICTURE   
//var_dump($self_origin_post);
?>