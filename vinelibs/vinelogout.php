<?php  
session_start();
unset($_SESSION['vine_key']);
unset($_SESSION['vine_userid']);
unset($_SESSION['vine_userName']);
unset($_SESSION['vine_avatar']);
header("Location: http://localhost/MashdApp/www/#/social");
?>