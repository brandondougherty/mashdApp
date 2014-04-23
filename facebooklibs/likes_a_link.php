<?php
$id_of_origin_post = preg_replace('/.*_/', '', $data['id']);
  $post_url = '/' .$id_of_origin_post;
  $origin_post = $facebook->api($post_url,'GET');

$name = $data['from']['name'];
$story = preg_replace('/'.$name.'/', "", $data['story']);
$id = $data['from']['id'];
echo "<div class='fbPostHead'><a class='fbUser' ng-click=\"goToFbUser('$id')\">$name</a>";
echo " ".$story."</div></div>";
echo "<br/>";
//image
//name
if(isset($origin_post['error'])){

}else{
echo $origin_post['from']['name'];
//mesage
echo "<div class='fbcontent'>";
if(isset($origin_post['message'])){
echo $origin_post['message'];
}
echo "</div>";
//media
if(isset($origin_post['picture'])){
if(preg_match('/fbexternal/', $origin_post['picture'])){
              $urlOfExternal = preg_replace('/.*url=/', '', $origin_post['picture']);
              $newUrlimg = urldecode($urlOfExternal);
              $urlLink =  $origin_post['link'];

              echo "<a window.open('$urlLink', '_blank', 'location=yes');><img src='$newUrlimg' /></a>";
              echo "<br/>";
              echo "<div class='fbcontent'>";
              if(isset($origin_post['name']))
              {
                $articleName = $origin_post['name'];
                echo $articleName;
                echo "<br/>";
              }
              if(isset($origin_post['caption']))
              {
                $articleCaption = $origin_post['caption'];
                echo $articleCaption;
                echo "<br/>";
              }
              if(isset($origin_post['description']))
              {
                $articleDescription = $origin_post['description'];
                echo $articleDescription;
              }
              echo "</div>";
          }
}else{
  $eventId = preg_replace('/\D/', '', $origin_post['link']);
$event_origin_post = $facebook->api($eventId,'GET');
$videoContent = $event_origin_post['source'];
                  echo "<div class='newVideo'>";
                echo "<video controls webkit-playsinline ><source src='$videoContent' type='mp4' height=100% width=100%></source></video>";
                echo "</div>";

}
//var_dump($data);
}
?>