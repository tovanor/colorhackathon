<?php

require_once("config_vars.inc.php");

global $c_mysqli;

$c_mysqli = new mysqli($_c['mysql_host'], $_c['mysql_user'], $_c['mysql_pass'], $_c['mysql_db']);

unset($_c['mysql_user']);
unset($_c['mysql_pass']);

require_once(__DIR__ . "/../php-sdk/src/facebook.php");

$_c['fb'] = new Facebook($_c['fb_keys']);

?>

