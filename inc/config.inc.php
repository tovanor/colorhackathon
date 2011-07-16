<?php

require_once("config_vars.inc.php");

global $c_mysqli;

$c_mysqli = new mysqli($_c['mysql_host'], $_c['mysql_user'], $_c['mysql_pass'], $_c['mysql_db']);

unset($_c['mysql_user']);
unset($_c['mysql_pass']);

require_once(__DIR__ . "/../php-sdk/src/facebook.php");

$_c['fb'] = new Facebook($_c['fb_keys']);


$facebook = $_c['fb'];

// Get User ID
$user = $facebook->getUser();

// We may or may not have this data based on whether the user is logged in.
//
// If we have a $user id here, it means we know the user is logged into
// Facebook, but we don't know if the access token is valid. An access
// token is invalid if the user logged out of Facebook.

if ($user) {
  try {
	// Proceed knowing you have a logged in user who's authenticated.
	$user_profile = $facebook->api('/me');
  } catch (FacebookApiException $e) {
	error_log($e);
	$user = null;
  }
}

$_c['fb_user'] = $user;
unset($user);
unset($facebook);


?>

