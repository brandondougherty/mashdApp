<?php
$id_of_origin_post = preg_replace('/.*_/', '', $data['id']);
$post_url = '/' .$id_of_origin_post;
$origin_post = $facebook->api($post_url,'GET');

$name = $data['from']['name'];
$story = preg_replace('/'.$name.'/', "", $data['story']);
$id = $data['from']['id'];
echo "<div class='fbPostHead'><a class='fbUser' ng-click=\"goToFbUser('$id')\">$name</a>";
echo " ".$story."</div></div>";
echo "<hr>";
echo $origin_post['from']['name']." ";
//mesage
echo $origin_post['message'];
//media
if(preg_match('/fbexternal/', $origin_post['picture'])){
              $urlOfExternal = preg_replace('/.*url=/', '', $origin_post['picture']);
              $newUrlimg = urldecode($urlOfExternal);
              $urlLink =  $origin_post['link'];

              echo "<a href='$urlLink' target='_blank'><img src='$newUrlimg' /></a>";
              echo "<br/>";
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
          }
?>