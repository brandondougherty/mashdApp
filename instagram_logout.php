<?php  
session_start();
unset($_SESSION['instagram']);
unset($_SESSION['igObject']);
header("Location: http://mashdapp.mashd.it/#/social");
?>