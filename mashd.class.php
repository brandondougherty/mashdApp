<?php 
	 if ($user){
		$user_id = $facebook->getUser();
	        $ret_obj = $facebook->api('/me/home?access_token=&limit=10','GET');
	     }
	if (isset ($_SESSION['vine_key']) && isset($_SESSION['vine_userid'])){
		$vine = new Vine;
		$key = $_SESSION['vine_key'];
		$records = $vine->vineTimeline($key);
	}
?>