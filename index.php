<?php
$title = "Index!";
require_once("inc/header.inc.php");

if($_SERVER['DOCUMENT_ROOT'] != "/var/www") {
	// Create our Application instance (replace this with your appId and secret).
	// Login or logout url will be needed depending on current user state.

	$user = $_c['fb_user'];
	$facebook = $_c['fb'];

	if ($user) {
	  $logoutUrl = $facebook->getLogoutUrl();
	} else {
	  $loginUrl = $facebook->getLoginUrl();
	}
}
 ?>
<p class="big-button">
	<a href="createthread.php">Create comic</a>
</p>

<p>
Search old comics
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

if($_SERVER['DOCUMENT_ROOT'] != "/var/www") {
	
	if ($user) { 
	  echo '<a href="' . $logoutUrl . '">Logout</a>';
	}
	else { 
	  echo "<div>
	    <a href='$loginUrl'>Login with Facebook</a>
	  </div>";
	}
	if ($user) {
	  echo "<h3>You</h3>
	  <img src='https://graph.facebook.com/$user/picture'>";
	}
	else {
	  echo "<strong><em>You are not Connected.</em></strong>";
	}
}
require_once("inc/footer.inc.php"); ?>
