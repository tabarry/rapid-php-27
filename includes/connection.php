<?php

/* --CONNECTION SETTINGS */
define('DB_HOST', 'localhost');
define('DB_NAME', 'test');
define('DB_USER', 'root');
define('DB_PASSWORD', 'root');

/* --CONNECT */
$cn = @mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) or die(mysqli_error($cn));
mysqli_query($cn, "SET NAMES utf8");
mysqli_query($cn, "SET sql_mode=''");
@mysqli_select_db($cn, DB_NAME) or die(mysqli_error($cn));

?>
