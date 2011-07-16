<?php
$title = "Thread";
require_once("inc/header.inc.php");

// If no thread id is given, redirect them to the index
$thread_id = (isset($_GET['id']))? $_GET['id'] : '';
$act = (isset($_POST['act']))? $_POST['act'] : '';

if($thread_id == '') {
	?>
	<meta http-equiv="REFRESH" content="0;url=index.php"></HEAD>
	<?php
}

if($act == "post") {
	// do stuff
}

// Get the given game
$turns = $c_mysqli->query("SELECT * FROM `turns` WHERE `thread_id` = '$thread_id' ORDER BY turn_number ASC"); // Most recent at top
$num_rows = $turns->num_rows;
if($num_rows == 0) {
	echo "This thread does not exist!";
	require_once("inc/footer.inc.php");
	die();
}
//id=Notice: Undefined variable: turn_id in /var/www/color/showthread.php on line 11Call Stack:    0.0003     340464   1. {main}() /var/www/color/showthread.php:0
///www/color/showthread.php on line 11Call Stack:    0.0003     340464   1. {main}() /var/www/color/showthread.php:0
else if($num_rows < 10) {
	// Display only the most recent turn
	$turn = $turns->fetch_object();
	if($turn->type == "url") { // Game is not finished
		echo '<br /><img src="' . $turn->content;
		$form = 'Sentence:<br /> <textarea name="sentence" cols="40" rows="4"></textarea><br />';
	}
	else {
		echo '<br />' . $turn->content;
		$form = "This is the script to display the drawing box.\n";
	}
	
	echo "<br /><br />\n
	------------<br /><br />\n";
	
	// Display the box for adding a new turn if the thread is not complete
	// Need to have a check here to see if the user has posted on the thread.
	//   If they have, do not show the box;
	//   instead display a message about why they cannot post again.
	?>
	<form action="<?php echo $_SERVER["PHP_SELF"]; ?>?id=<?php echo $thread_id; ?>" method="post">
	<input type="hidden" name="act" value="post" />
	<?php echo $form; ?><br />
	Send to friend (email): <input type="text" name="email" /><br />
	<input type="submit" name="createnew" value="Create!" /><br />
	</form>

	<?php
}
else { // Game is finished; display everything
	while($turn = $turns->fetch_object()) {
		echo "<br />";
		if($turn->type == "url") { // Game is not finished
			echo '<img src="' . $turn->content . '" />';
		}
		else {
			echo $turn->content;
		}
		echo "<br /><br />
		------------<br />";
	}
}

require_once("inc/footer.inc.php"); ?>
