<?php
#commented_on_own_link
$id_of_self_post = preg_replace('/.*_/', '', $data['id']);
$self_post_url = '/' .$id_of_self_post;
$self_origin_post = $facebook->api($self_post_url,'GET');
  echo $data['story'];
  echo "<br/>";
  echo $self_origin_post['message'];
  echo "<br/>";
if(isset($self_origin_post['picture']) && preg_match('/fbexternal/', $self_origin_post['picture'])){
              $urlOfExternal = preg_replace('/.*url=/', '', $self_origin_post['picture']);
              $newUrlimg = urldecode($urlOfExternal);
              $urlLink =  $self_origin_post['link'];

              echo "<a href='$urlLink' target='_blank'><img src='$newUrlimg' /></a>";
              echo "<br/>";
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
          }
?>