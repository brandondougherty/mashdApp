<?php 
  $id_of_origin_post = preg_replace('/.*_/', '', $data['id']);
  $post_url = '/' .$id_of_origin_post;
  $origin_post = $facebook->api($post_url,'GET');
    #the original posters user profile picture
    $origin_aname = $origin_post['from']['id'];
    $origin_usr_post_pic = $facebook->api('/' . $origin_aname . '?fields=picture','GET');
    $origin_pic = $origin_usr_post_pic['picture']['data']['url'];
      $name = $data['from']['name'];
$story = preg_replace('/'.$name.'/', "", $data['story']);
$id = $data['from']['id'];
echo "<a class='fbUser' ng-click=\"goToFbUser('$id')\">$name</a></div>";
echo " ".$story;
      echo "<br/>";
      echo "<img src='$origin_pic'/>";
      echo "<br/>";
      if(isset($self_origin_post['error'])){

}else{
                   if (isset($origin_post['to'])){
                       echo " to " . $origin_post['to']['data']['0']['name'];
                    }     
          ############
          ###########  PRINTS THE MESSAGE OF THE POST IF ANY        
                    echo "<br/>";
                    if (isset($origin_post['message'])){
                      echo "<div class='fbcontent'>";
                        echo $origin_post['message'];
                        echo "</div>";
                      }
                    
          ############
          ###########   EITHER PRINTS THE YOUTUBE VIDEO, OR A DIRECTLY UPLOADED VIDEO, OR PICTURE              ###### ------> WHAT IF USER UPLOADED VIDEO AND PICTURE??
                  if ((isset($origin_post['source'])) && (preg_match("/youtube/",$origin_post['source']))){
                    $big_youtube = preg_replace('/.*?\//', '', $origin_post['source']);
                    $med_youtube = preg_replace('/\?.*/', '', $big_youtube);
                    $youtube_link = 'https://www.youtube.com/v/' . $med_youtube . '?version=3&amp;autohide=1&amp;autoplay=1';
                    $youtube_embed_link = 'https://www.youtube.com/embed/' . $med_youtube;

                    echo "<iframe width='398' height='224' frameborder='0' scrolling='no' src =" . $youtube_embed_link . ">
                    <!DOCTYPE html>
                    <html>
                      <head>
                        <meta charset='utf-8'>
                      </head>
                      <body>
                        <div>
                          <span>
                            <object type='application/x-shockwave-flash' data=" . $youtube_link . " height='224' width='398'>
                            </object>
                          </span>
                        </div>
                      </body>
                    </html>
                    </iframe>";

                  }elseif ((isset($origin_post['source'])) && (preg_match("/\.3g2|\.3gp|\.gpp|\.asf|\.avi|\.dat|\.divx|\.dv|\.f4v|\.flv|\.m2ts|\.m4v|\.mkv|\.mod|\.mov|\.mp4|\.mpe|\.mpeg|\.mpeg4|\.mpg|\.mts|\.nsv|\.ogm|\.ogv|\.qt|\.tod|\.ts|\.vob|\.wmv/",$origin_post['source']))){
                    $video_up1 = $origin_post['source'];
                    echo "<video width='320' height='240' controls >
                      <source src='$video_up1' type='video/mp4'/>
                      <object data='$video_up1' width='320' height='240'></object>
                    </video>";

                  }elseif (isset($data['picture'])){
                      ##working on this regex #################
                      $big_num1= preg_replace('/\_s..../', '', $origin_post['picture']);
                      $med_num1 = preg_replace('/.*[\/]/', '', $big_num1);
                      $imglink1 = 'https://scontent-b-pao.xx.fbcdn.net/hphotos-prn1/' . $med_num1 . '_n.jpg';
                      echo "<img src='$imglink1'/>";
                    }
          ############
          ###########   END PRINTS THE YOUTUBE VIDEO, OR A DIRECTLY UPLOADED VIDEO, OR PICTURE   
            echo "<br/>";
            if(!empty($origin_post['likes'])){
                      $likes_count = count($origin_post['likes']['data']);
                    echo "<br/>";
                    echo "Likes: " . $likes_count;
                    /*$z = 0;
                    $likes_count = count($origin_post['likes']['data']);
                    while($z < $likes_count){
                        echo $origin_post['likes']['data'][$z]['name'];
                        echo "<br/>";
                        $z++;
                    }*/
                  }
                  if(!empty($origin_post['comments'])){
                    $comment_count = count($origin_post['comments']['data']);
                    echo "Comments: " . $comment_count;
                  }
                }
?>