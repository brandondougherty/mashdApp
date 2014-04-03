<?php 
session_start();
include (__DIR__.'/vine.php');
include (__DIR__.'../../dbc.php');
foreach($_POST as $key => $value) {
      $data[$key] = filter($value); // post variables are filtered
}

$vine = new Vine;
$key = $_SESSION['vine_key'];
$id = $data['id'];
$vinelike= $vine->deleteVineLike($key,$id);
var_dump($vinelike);

?>