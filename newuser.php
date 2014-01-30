<?php

require 'database.php';

$username = $_POST['username'];
$password = crypt($_POST['password']);

$stmt = $mysqli->prepare("insert into users (username, password_encrypted) values (?, ?)");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	echo "Sorry, that username was too long or already taken";
	exit;
}
 
$stmt->bind_param('ss', $username, $password);
 
$stmt->execute();
 
$stmt->close();
session_start();
$_SESSION['user_id'] = $username;
$_SESSION['token'] = substr(md5(rand()), 0, 10);
header('Location: tidaer.php');
 
?>