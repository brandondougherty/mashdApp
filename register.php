<?php 

include 'dbc.php';

$err = array();
					 
$incoming = json_decode(file_get_contents('php://input'));
/******************* Filtering/Sanitizing Input *****************************
This code filters harmful script code and escapes data of all POST data
from the user submitted form.
*****************************************************************/
foreach($incoming as $key => $value) {
	$data[$key] = filter($value);
}

	  
$user_ip = $_SERVER['REMOTE_ADDR'];

// stores sha1 of password
$sha1pass = PwdHash($data['password']);

// Automatically collects the hostname or domain  like example.com) 
$host  = $_SERVER['HTTP_HOST'];
$host_upper = strtoupper($host);
$path   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');

$usr_email = $data['email'];

/************ USER EMAIL CHECK ************************************
This code does a second check on the server side if the email already exists. It 
queries the database and if it has any existing email it throws user email already exists
*******************************************************************/

$rs_duplicate = mysql_query("select count(*) as total from users where user_email='$usr_email'") or die(mysql_error());
list($total) = mysql_fetch_row($rs_duplicate);

if ($total > 0)
{
$err = "Sorry, This email already exists. Please try again with different a email.";
 $registered = array('user_registered'=>'false', 'error' => $err);
echo json_encode($registered);
}
/***************************************************************************/

if(empty($err)) {

$sql_insert = "INSERT into `users`
  			(`user_email`,`pwd`, `date`, `users_ip`)
		    VALUES
		    ('$usr_email','$sha1pass',now(),'$user_ip')";
			
mysql_query($sql_insert,$link) or die("Insertion Failed:" . mysql_error());
$user_Id = mysql_insert_id($link);  
$md5_id = md5($user_Id);
mysql_query("update users set md5_id='$md5_id' where id='$user_Id'");

if($user_registration)  {

$message = 
"Hello \n
Thank you for registering with Mash'D. \n

______________________________________________________
THIS IS AN AUTOMATED RESPONSE. 
***DO NOT RESPOND TO THIS EMAIL****
";

	mail($usr_email, "Mash'D Registration", $message,
    "From: \"Mash'D Registration\" <auto-reply@$host>\r\n" .
     "X-Mailer: PHP/" . phpversion());

	 
	 } 
	 // this sets session and logs user in  
    session_start();
    session_regenerate_id (true); //prevent against session fixation attacks.

    // this sets variables in the session 
	$_SESSION['user_id']= $user_Id;
	$_SESSION['HTTP_USER_AGENT'] = md5($_SERVER['HTTP_USER_AGENT']);
	
	//update the timestamp and key for cookie
	$stamp = time();
	$ckey = GenKey();
	mysql_query("update users set `ctime`='$stamp', `ckey` = '$ckey' where id='$user_Id'") or die(mysql_error());
	
	 $registered = array('user_registered'=>'true');

	echo json_encode($registered);
 }					 

?>
