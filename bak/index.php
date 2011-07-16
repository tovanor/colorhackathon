<?php

// display header
require_once("header.inc.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/color/includes/config.inc.php");
// logged in => "create new thread"
// not logged in => "log in"
?>
<div style="text-align: center;">
<p>
Welcome to the index page!<br /><br />
<a href="createthread.php">Create a new thread!</a>
</p>
</div>
<?php
// display footer
require_once("footer.inc.php");
?>
