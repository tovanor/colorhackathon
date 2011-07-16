<?php
$title = "Index!";
require_once("inc/header.inc.php");

$act = (isset($_POST['act']))? $_POST['act'] : '';

if($act == '') { // Form for user to enter
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
	    echo "Both fields must be entered!";
	    require_once("inc/footer.inc.php");
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
	<meta http-equiv="REFRESH" content="0;url=showthread.php?id=<?php echo $turn_id; ?>"></HEAD>
	<?php
}

require_once("inc/footer.inc.php"); ?>
