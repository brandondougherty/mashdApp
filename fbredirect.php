<?php
session_start();
include 'facebooklibs/auth.php';
$incoming = json_decode(file_get_contents('php://input'));

header("Location: http://mashdapp.mashd.it/#/social");
?>