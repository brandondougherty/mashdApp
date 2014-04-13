<?php 
session_start();
include (__DIR__.'/src/facebook.php');
include (__DIR__.'../../dbc.php');

$incoming = json_decode(file_get_contents('php://input'));
foreach($incoming as $key => $value) {
	$data[$key] = filter($value); // post variables are filtered
}

$id = $data['postId'];
$facebook = new Facebook(array(
  'appId'  => '464235817026185',
  'secret' => 'cc0dfb735ef12d40c59dc83fa7493efd'
));
function time_elapsed_string($ptime){
    $etime = time() - $ptime;
    if ($etime < 1){
        return '0 seconds';
    }
    $a = array( 12 * 30 * 24 * 60 * 60  =>  'y',
                30 * 24 * 60 * 60       =>  'month',
                24 * 60 * 60 * 7        =>  'wk',
                24 * 60 * 60            =>  'd',
                60 * 60                 =>  'h',
                60                      =>  'min',
                1                       =>  's'
                );
    foreach ($a as $secs => $str){
        $d = $etime / $secs;
        if ($d >= 1){
            $r = round($d);
            return $r . ' ' . $str;
  }}} 

$comments = $facebook->api('/'.$id.'/comments','GET');

foreach ($comments['data'] as $comment) {
	$likeId = $comment['id'];
	$userId = $comment['from']['id'];
	$name = $comment['from']['name'];//name
	$message = $comment['message'];//comment
	$created = $comment['created_time'];//time
	$created = strtotime($created);
	$created = time_elapsed_string($created);
	$likes = $comment['like_count'];//num likes

	echo "<div class='listComment'>";
	echo "<a class=\"user\" ng-click=\"goToUser('$userId')\">".$name."</a> ";
	echo "<span class='message'>".$message."</span><br/>";
	echo $created . "- <a class=\"fbLike\" data='$likeId'>Like</a><span class='fbLikeCount'>".$likes."</span>";
	if($userId === $_SESSION['fb_user_id']){
		echo "<a class=\"fbremove\" ng-click=\"removeComment('$likeId')\"> remove</a>";
	}
	echo "</div>";
}
?>