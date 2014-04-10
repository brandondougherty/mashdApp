<?php  
session_start();
foreach ($_SESSION as $name => $value)
{
    if(preg_match('/fb_.*/', $name)){
    	unset($_SESSION[$name]);
    }
}
header("Location: http://localhost/MashdApp/www/#/social");
?>