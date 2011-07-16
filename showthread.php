<?php
$title = "Thread";
require_once("inc/header.inc.php");

// If no thread id is given, redirect them to the index
$thread_id = (isset($_GET['id']))? $_GET['id'] : '';
$act = (isset($_POST['act']))? $_POST['act'] : '';
$filename = '';
if($thread_id == '') {
	?>
	<meta http-equiv="REFRESH" content="0;url=index.php">
	<?php
}

// If a new turn has been submitted, deal with it
// Check if the user has submitted to this thread before
// Make sure all boxes have been filled in
// Somehow get the url generated by the javascript and put it in the db
if($act == "post") {
	// Error checking
	if(!(isset($_POST['content']) && !isset($_POST["canvasinput"])) && !isset($_POST['email'])) {
	    echo "Both fields must be entered!";
	    require_once("inc/footer.inc.php");
	    die();
	}
	
	// Save image if needed
    if (isset($_POST["canvasinput"])) {
    	// Get the data
    	$imageData = $_POST["canvasinput"];
    	$filename = "userimages/" . $_POST["filename"] . ".png";

    	// Remove the headers (data:,) part.  
    	// A real application should use them according to needs such as to check image type
    	$filteredData = substr($imageData, strpos($imageData, ",") + 1);

    	// Need to decode before saving since the data we received is already base64 encoded
    	$unencodedData = base64_decode($filteredData);

    	// Save file.  This example uses a hard coded filename for testing, 
    	// but a real application can specify filename in POST variable
    	touch($filename);
    	$fp = fopen($filename, 'wb');
    	fwrite( $fp, $unencodedData);
    	fclose( $fp );
    }
    
	$content = (isset($_POST['content']))? $_POST['content'] : $filename;
	
	// Get the current number of turns so we can submit the next one
	$current_turn = $c_mysqli->query("SELECT `num_turns` FROM `threads` WHERE `id` = '$thread_id'");
	$next_turn = $current_turn->fetch_object()->num_turns + 1;
	if($next_turn > 10) {
		echo "This thread is complete. No more turns can be added to this thread.";
		require_once("inc/footer.inc.php");
		die();
	}
	
	$type = "url";
	if($next_turn % 2) {
		$type = "sentence";
	}
	
	// Create the post; use a test user for now
	$c_mysqli->query("INSERT INTO `turns` 
		(`user_id`,`thread_id`,`turn_number`,`content`,`type`) 
		VALUES ('0','$thread_id','$next_turn + 1','$content','$type')") or die($c_mysqli->error);
	//$turn_id = $c_mysqli->insert_id;
	
	$c_mysqli->query("UPDATE `threads` SET `num_turns` = `num_turns` + 1 WHERE `id` = '$thread_id'");
	
	echo "Your turn has been added successfully!<br /><br />";
}

// Get the given game
// Most recent at top
$turns = $c_mysqli->query("SELECT * FROM `turns` WHERE `thread_id` = '$thread_id' ORDER BY turn_number DESC");
$num_rows = $turns->num_rows;
if($num_rows == 0) {
	echo "This thread does not exist!";
	require_once("inc/footer.inc.php");
	die();
}
else if($num_rows < 10) {
	// Display only the most recent turn
	$turn = $turns->fetch_object();
	if($turn->type == "url") { // Game is not finished
		echo '<div class="postit-draw"><br /><img src="' . $turn->content . '" /></div>';
		$form = 'Sentence:<br /> <textarea name="content" cols="40" rows="4"></textarea><br />';
	}
	else {
		echo '<div class="postit-write"><div class="fancy"><br />' . $turn->content . '</div></div>';
		$form = "This is the script to display the drawing box.\n";
		$filename = $thread_id . "_" . $turn->id;
	}
	
	echo "<br /><br />\n";
	
	// Display the box for adding a new turn if the thread is not complete
	// Need to have a check here to see if the user has posted on the thread.
	//   If they have, do not show the box;
	//   instead display a message about why they cannot post again.
	?>
	<form action="<?php echo $_SERVER["PHP_SELF"]; ?>?id=<?php echo $thread_id; ?>" method="post">
	<input type="hidden" name="act" value="post" />
	<input type="hidden" name="type" value="<?php ?>" />
	<?php
	if($turn->type == "url") {
		echo '<div class="postit-write"><div class="fancy">Describe the picture!<br /><textarea name="content" cols="70" rows="4" style="background-color: transparent; border: 2px solid gray;"></textarea><br /></div></div>';
	}
	else {
		echo '<div class="postit-draw">';
		include("color/paint/index.php");
		echo '</div>';
		?>
		<input type="hidden" name="filename" value="<?php echo $filename ?>">
		<input type="hidden" id="canvasinput" name="canvasinput" />
		<?php
	}
	?>
	<br />
	Send to friend (email): <input type="text" name="email" /><br />
	<input type="submit" name="createnew" value="Create!" /><br />
	</form>

	<?php
}
else { // Game is finished; display everything
	// Most recent at bottom
	$turns = $c_mysqli->query("SELECT * FROM `turns` WHERE `thread_id` = '$thread_id' ORDER BY turn_number ASC");
	while($turn = $turns->fetch_object()) {
		if($turn->type == "url") { // Game is not finished
			echo '<div class="postit-draw"><br /><img src="' . $turn->content . '" /></div>';
		}
		else {
			echo '<div class="postit-write"><br /><div class="fancy">' . $turn->content . '</div></div>';
		}
		echo "";
	}
}

require_once("inc/footer.inc.php"); ?>
