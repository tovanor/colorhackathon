<?php
require_once("header.inc.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/color/includes/config.inc.php");

$act = (isset($_POST['act']))? $_POST['act'] : '';

if($act == '') { // Form for user to enter
	?>
	<div style="text-align: center;">
	<form action=<?=$_SERVER["PHP_SELF"] ?> method="post">
	<input type="hidden" name="act" value="new" />
	Sentence:<br /> <textarea name="sentence" cols="40" rows="4"></textarea><br />
	Send to friend (email): <input type="text" name="email" /><br />
	<input type="submit" name="createnew" value="Create!" /><br />
	</form>
	</div>

	<?php
}
else { // Create new post
	// Error checking
	if(!isset($_POST['sentence']) || !isset($_POST['text'])) {
	    echo "Both fields must be entered!";
	    include("footer.inc.php");
	    die();
	}
	
	// Create a new thread; use a test user for now
	
}
require_once("footer.inc.php");
?>
