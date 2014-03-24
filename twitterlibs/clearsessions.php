<?php
/**
 * @file
 * Clears PHP sessions and redirects to the connect page.
 */
 
/* Load and clear sessions */
session_start();
if(isset($_SESSION['access_token'])){
	unset($_SESSION['access_token']);
}
 
/* Redirect to page with the connect to Twitter option. */
header("Location: http://localhost/MashdApp/www/#/social");
