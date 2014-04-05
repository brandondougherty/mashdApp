<?php
session_start();

require 'instagram.class.php';
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
            return $r . ' ' . $str . ' ago';
        }
    }
} 
$instagram = new Instagram(array(
  'apiKey'      => 'af0092092bd347f2948940ef30261dcc',
  'apiSecret'   => '12b2d103aa884b9c9a4bf377ad4cf279',
  'apiCallback' => 'http://localhost/MashdApp/www/instagramredirect.php' // must point to success.php
));

	$package = $_SESSION['igObject'];
	$result = $instagram->pagination($package, 10);
	$_SESSION['igObject'] = $result->pagination; 
	include '../instagram_parse.php';

?>