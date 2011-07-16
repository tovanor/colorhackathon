<?php
$title = "Index!";
require_once("inc/header.inc.php");

$act = (isset($_POST['act']))? $_POST['act'] : '';

if($act == '') { // Form for user to enter
	// Check if user is logged in
	if(!$_c['fb_user']) {
		echo "You must be logged in to view this page!<br />";
		echo "<a href='".$_c['fb']->getLoginUrl()."'>Log in to Facebook here</a>";
		require_once('inc/header.inc.php');
		die();
	}
	
	?>
	<form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
	<input type="hidden" name="act" value="new" />
	Write a sentence to start the game:<br /> <textarea class="postit-write" name="sentence" cols="40" rows="4"></textarea><br />
	Tell a friend (email): <input type="text" name="email" /><br />
	<input type="submit" name="createnew" value="Create!" class="big-button" /><br />
	</form>

	<?php
}
else { // Create new post
	// Error checking
	if(!isset($_POST['sentence'])) {
	    ?>
		<meta http-equiv="REFRESH" content="0;url=index.php">
		<?php
	}
	
	// Check if user is logged in
	if($_c['fb_user'] == NULL) {
		echo "You must be logged in to view this page!";
		require_once('inc/header.inc.php');
		die();
	}
	
	// Create a new thread
	$c_mysqli->query("INSERT INTO `threads` (`num_turns`) VALUES ('1')") or die($c_mysqli->error);
	$thread_id = $c_mysqli->insert_id;
	$sentence = addslashes($_POST['sentence']);
	
	// Create first post; use a test user for now
	$c_mysqli->query("INSERT INTO `turns` 
		(`user_id`,`thread_id`,`turn_number`,`content`,`type`) 
		VALUES ('0','$thread_id','1','$sentence','sentence')") or die($c_mysqli->error);
	$turn_id = $c_mysqli->insert_id;
	
	// Send the email
	//$user = $_c['fb']->api("/me");
	//$email = $_POST['email'];
	//$subject = $user['name'] . " has invited you to play ComiCrazy!";
	//$message = $user['first_name'] . " has invited you to play ComiCrazy!\n\n To play, follow this link:\n
	//http://comicrazy.dyndns.org/dev/\n\nThanks for playing!";
	//$headers = "From: The ComiCrazy Team";
	
	//echo "email: $email<br /><br />subject: $subject<br /><br />";
	//echo "message: $message<br /><br />headers: $headers<br />";
	//if(!mail($email, $subject, $message, $headers)) {
	//	echo 'Failed to send welcome email.';
	//	die();
        //}
	// User has successfully created a new thread; redirect them to their thread's main page
	?>
	<meta http-equiv="REFRESH" content="0;url=showthread.php?id=<?php echo $thread_id; ?>">
	<?php
}

require_once("inc/footer.inc.php"); ?>
