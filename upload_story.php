<?php
session_start();
$username = $_SESSION['user_id'];
$story_link = $_POST['story_link'];
$story_title = $_POST['story_title'];
if($_SESSION['token'] !== $_POST['token']){
	die("Request forgery detected");
}


require 'database.php';

if($_SESSION['token'] !== $_POST['token']){
	die("Request forgery detected");
}

$stmt = $mysqli->prepare("insert into stories (link, title, submitter) values (?, ?, ?)");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}
 
$stmt->bind_param('sss', $story_link, $story_title, $username);
 
$stmt->execute();
 
$stmt->close();


header('Location: tidaer.php');
 


?>