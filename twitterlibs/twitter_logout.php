<?php  
session_start();
unset($_SESSION['access_token']);
header("Location: http://mashd.it/#/social");
?>