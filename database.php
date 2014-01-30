<?php
$mysqli = new mysqli('localhost', 'Brandon', 'gau7Ze', 'TIDAER');
 
if($mysqli->connect_errno) {
	printf("Connection Failed: %s\n", $mysqli->connect_error);
	exit;
}
?>