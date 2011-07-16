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

if($_SERVER['DOCUMENT_ROOT'] != "/var/www") {
	?>

		<h1>php-sdk</h1>

		<?php if ($user): ?>
		  <a href="<?php echo $logoutUrl; ?>">Logout</a>
		<?php else: ?>
		  <div>
		    Login using OAuth 2.0 handled by the PHP SDK:
		    <a href="<?php echo $loginUrl; ?>">Login with Facebook</a>
		  </div>
		<?php endif ?>

		<?php if ($user): ?>
		  <h3>You</h3>
		  <img src="https://graph.facebook.com/<?php echo $user; ?>/picture">
		     <?php else: ?>
		  <strong><em>You are not Connected.</em></strong>
		<?php endif ?>
<?php
}
require_once("inc/footer.inc.php"); ?>
