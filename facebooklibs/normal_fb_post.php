<?php

$name = $data['from']['name'];
$id = $data['from']['id'];
echo "<div class='fbPostHead'><a class='fbUser' ng-click=\"goToFbUser('$id')\">$name</a>";
             if (isset($data['to'])){
              echo " to " . $data['to']['data']['0']['name'];
              }     
############
###########  PRINTS THE MESSAGE OF THE POST IF ANY        
          echo "<br/>";
          if (isset($data['message'])){
            echo "<div class='fbcontent'>";
              echo $data['message'];
              echo "</div>";
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
              <div>
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
              echo "<div class='fbcontent'>";
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
              echo "</div>";
          }else{ 
              ###regular post
        	if(isset($data['picture'])){
            $big_num = preg_replace('/\_s..../', '', $data['picture']);
            $med_num = preg_replace('/.*[\/]/', '', $big_num);
            $imglink = 'https://scontent-b-pao.xx.fbcdn.net/hphotos-prn1/' .$med_num. '_n.jpg';
            echo "<img src='$imglink' />";
          }
        }
      
?>