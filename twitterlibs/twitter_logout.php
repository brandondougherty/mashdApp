<?php  
session_start();
unset($_SESSION['access_token']);
header("Location: http://localhost/MashdApp/www/#/social");
?>