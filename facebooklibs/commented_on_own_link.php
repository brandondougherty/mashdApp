<?php
#commented_on_own_link
$id_of_self_post = preg_replace('/.*_/', '', $data['id']);
$self_post_url = '/' .$id_of_self_post;
$self_origin_post = $facebook->api($self_post_url,'GET');
  $name = $data['from']['name'];
$story = preg_replace('/'.$name.'/', "", $data['story']);
$id = $data['from']['id'];
echo "<div class='fbPostHead'><a class='fbUser' ng-click=\"goToFbUser('$id')\">$name</a>";
echo " ".$story."</div></div>";
  echo "<br/>";
  echo $self_origin_post['message'];
  echo "<br/>";
if(isset($self_origin_post['picture']) && preg_match('/fbexternal/', $self_origin_post['picture'])){
              $urlOfExternal = preg_replace('/.*url=/', '', $self_origin_post['picture']);
              $newUrlimg = urldecode($urlOfExternal);
              $urlLink =  $self_origin_post['link'];

              echo "<a href='$urlLink' target='_blank'><img src='$newUrlimg' /></a>";
              echo "<br/>";
              echo "<div class='fbcontent'>";
              if(isset($self_origin_post['name']))
              {
                $articleName = $self_origin_post['name'];
                echo $articleName;
                echo "<br/>";
              }
              if(isset($self_origin_post['caption']))
              {
                $articleCaption = $self_origin_post['caption'];
                echo $articleCaption;
                echo "<br/>";
              }
              if(isset($self_origin_post['description']))
              {
                $articleDescription = $self_origin_post['description'];
                echo $articleDescription;
              }
              echo "</div>";
          }
?>