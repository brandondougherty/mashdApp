<?php
	echo $data['story'];
      echo "<br/>";
	 if(preg_match('/fbexternal/', $data['picture'])){
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
          }
?>