<?php 

include 'dbc.php';

$err = array();

$incoming = json_decode(file_get_contents('php://input'));

foreach($incoming as $key => $value) {
	$data[$key] = filter($value); // post variables are filtered
}
//var_dump($_POST);
$user_email = $data['username'];
$pass = $data['password'];
$user_cond = "user_email='$user_email'";
   

	
$result = mysql_query("SELECT `id`,`pwd` FROM users WHERE 
           $user_cond
			AND `banned` = '0'
			") or die (mysql_error()); 
$num = mysql_num_rows($result);

  // Match row found with more than 1 results  - the user is authenticated. 
    if ( $num > 0 ) { 
	
	list($id,$pwd) = mysql_fetch_row($result);
	//check against salt
	if ($pwd === PwdHash($pass,substr($pwd,0,9))) { 
		if(empty($err)){			

     // this sets session and logs user in  
       session_start();
	   session_regenerate_id (true); //prevent against session fixation attacks.

	   // this sets variables in the session 
		$_SESSION['user_id']= $id;
		$_SESSION['HTTP_USER_AGENT'] = md5($_SERVER['HTTP_USER_AGENT']);
		
		//update the timestamp and key for cookie
		$stamp = time();
		$ckey = GenKey();
		mysql_query("update users set `ctime`='$stamp', `ckey` = '$ckey' where id='$id'") or die(mysql_error());
		
		//set a cookie 
		
	   /*if(isset($_POST['remember'])){
				  setcookie("user_id", $_SESSION['user_id'], time()+60*60*24*COOKIE_TIME_OUT, "/");
				  setcookie("user_key", sha1($ckey), time()+60*60*24*COOKIE_TIME_OUT, "/");
				  setcookie("user_name",$_SESSION['user_name'], time()+60*60*24*COOKIE_TIME_OUT, "/");
		}*/
			
		echo "1";
		 }
		}
		else
		{
		//$msg = urlencode("Invalid Login. Please try again with correct user email and password. ");
		$err = "Invalid Login. Please try again with correct user email and password.";
		echo $err;
		//header("Location: login.php?msg=$msg");
		}
	} else {
		$err = "Error - Invalid login. No such user exists";
		echo $err;

	  }		

					 
					 

?>
