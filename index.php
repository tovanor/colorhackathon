<?php
$title = "Index!";
require_once("inc/header.inc.php"); ?>

<p>
Welcome to the index page!<br /><br />
<a href="createthread.php">Create a new thread!</a>
</p><br />
<p>
Search for a thread:
</p>
<?php
include('search.php');

echo "<br /><br />";

// find and display all completed threads
echo "Completed Threads:<br />\n";
$completed_threads = $c_mysqli->query("SELECT * FROM `threads` WHERE `num_turns` = 10");
while($t = $completed_threads->fetch_object()) {
	$first_thread = $c_mysqli->query("SELECT * FROM `turns` WHERE `thread_id` = '$t->id' AND `turn_number` = '1' LIMIT 1");
	$ft = $first_thread->fetch_object();
	echo '<a href="showthread.php?id=' . $t->id . '">' . $ft->content . '</a><br />';
}

?>

<?php require_once("inc/footer.inc.php"); ?>
