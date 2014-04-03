<?php
/*
 * Instagram PHP API
 */
require 'instagram.class.php';

// initialize class
$instagram = new Instagram(array(
  'apiKey'      => 'af0092092bd347f2948940ef30261dcc',
  'apiSecret'   => '12b2d103aa884b9c9a4bf377ad4cf279',
  'apiCallback' => 'http://localhost/MashdApp/www/instagramredirect.php' // must point to success.php
));


// create login URL
$instagram_loginUrl = $instagram->getLoginUrl();

// check whether the user has granted access
if (isset($_SESSION['instagram'])) {
  // receive OAuth token object
    // store user access token
  $instagram->setAccessToken($_SESSION['instagram']);
  // now you have access to all authenticated user methods
  $data = $instagram->setAccessToken($_SESSION['instagram']);
  // now you have access to all authenticated user methods
  $ig_username = $instagram->getUser();
  $result = $instagram->getUserFeed(10);
  
  $instagram->savePackage($result);

  $_SESSION['igObject'] = $instagram->getPackage();    
  
}elseif (!empty($_GET['code'])){

  // receive OAuth token object
  $data = $instagram->getOAuthToken($_GET['code']);
  // store user access token
  $instagram->setAccessToken($data);
} else {
  // check whether an error occurred
  if (isset($_GET['error'])) {
    echo 'An error occurred: ' . $_GET['error_description'];
  }

}

?>