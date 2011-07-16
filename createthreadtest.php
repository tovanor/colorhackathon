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
	    ?>
		<meta http-equiv="REFRESH" content="0;url=index.php">
		<?php
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
<?php
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
?>




	<textarea id="select_friend"> 
	</textarea>	
	<script type="text/javascript">
		$("#select_friend").autoComplete("http://graph.facebook.com/<%=$user%>/friends",);
	</script>
	<?php
}

require_once("inc/footer.inc.php"); ?>
