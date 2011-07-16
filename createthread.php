<?php
$title = "Index!";
require_once("inc/header.inc.php");

$act = (isset($_POST['act']))? $_POST['act'] : '';

if($act == '') { // Form for user to enter
	// Check if user is logged in
	if($_c['fb_user'] == NULL) {
		echo "You must be logged in to view this page!<br />";
		echo "<a href='$facebook->loginUrl'>Log in to Facebook here</a>";
		require_once('inc/header.inc.php');
		die();
	}
	
	?>
	<form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
	<input type="hidden" name="act" value="new" />
	Sentence:<br /> <textarea name="sentence" cols="40" rows="4"></textarea><br />
	Send to friend (email): <input type="text" name="email" /><br />
	<input type="submit" name="createnew" value="Create!" /><br />
	</form>

	<?php
}
else { // Create new post
	// Error checking
	if(!isset($_POST['sentence']) || !isset($_POST['email'])) {
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
	
	// User has successfully created a new thread; redirect them to their thread's main page
	?>
	<meta http-equiv="REFRESH" content="0;url=showthread.php?id=<?php echo $thread_id; ?>"></HEAD>
	<?php
}

require_once("inc/footer.inc.php"); ?>
