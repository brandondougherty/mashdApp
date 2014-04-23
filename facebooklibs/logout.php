<?php  
session_start();
foreach ($_SESSION as $name => $value)
{
   if(strpos($name,'fb_') === 0){
   	//var_dump($_SESSION[$name]);
   	unset($_SESSION[$name]);

   }
}

header("Location: http://mashd.it/#/social");
?>