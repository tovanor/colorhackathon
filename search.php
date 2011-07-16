<?php

$act = (isset($_GET['searchval']))? $_GET['searchval'] : '';
global $c_mysqli;

// The search bar
if(isset($_GET['searchval']) && $_GET['searchval'] == '') {
	// Redirect to the main page
	echo '<meta http-equiv="REFRESH" content="0;url=index.php">';
}
if($act == '') {
	?>
	<form action="search.php" method="GET">
	<input type="text" length="45" name="searchval" /><br />
	<input type="submit" name="search" value="Search comic archives" class="big-button" />
	</form>
	<?php
}
else {
	require_once("inc/header.inc.php");
	$searchval = addslashes($act);
	$entries = $c_mysqli->query("SELECT `content`, `thread_id` FROM `turns` 
	WHERE `content` 
	LIKE '%$searchval%' 
	LIMIT 10") or die($c_mysqli->error);
	
	if(!$entries->num_rows) {
		echo "The search query did not return any results.";
	}
	else {
		// Display the entries
		echo "Search results: <br />";
		while($e = $entries->fetch_object()) {
			echo "<a href='showthread.php?id=$e->thread_id'>$e->content</a><br />";
		}
	}
	require_once("inc/footer.inc.php");
}
