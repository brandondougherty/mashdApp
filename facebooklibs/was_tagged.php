<?php
	$name = $data['from']['name'];
$story = preg_replace('/'.$name.'/', "", $data['story']);
$id = $data['from']['id'];
echo "<div class='fbPostHead'><a class='fbUser' ng-click=\"goToFbUser('$id')\">$name</a>";
echo " ".$story."</div></div>";
	echo "<br/>";

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
          echo "<video controls >
            <source src='$video_up' type='video/mp4'/>
            <object data='$video_up'></object>
          </video>";

        }elseif(isset($data['picture']) && preg_match('/fbexternal/', $data['picture'])){
              $urlOfExternal = preg_replace('/.*url=/', '', $data['picture']);
              $newUrlimg = urldecode($urlOfExternal);
              $urlLink =  $data['link'];

              echo "<a class='external' href='$urlLink'><img src='$newUrlimg' /></a>";
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
            if(isset($data['link'])){
            $urlLink =  $data['link'];
            $imglink = 'https://scontent-b-pao.xx.fbcdn.net/hphotos-prn1/' .$med_num. '_n.jpg';
              echo "<a href=\"$urlLink\" ><img src=\"$imglink\" /></a>";

        	}else{
        		$imglink = 'https://scontent-b-pao.xx.fbcdn.net/hphotos-prn1/' .$med_num. '_n.jpg';
        		echo "<img src='$imglink' />";
        	}
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
          }
      }
?>