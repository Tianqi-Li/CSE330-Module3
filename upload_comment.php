<?php

session_start();

$username = $_SESSION['user_id'];
$comment = $_POST['comment'];
$story_id = (int) $_POST['story_id'];
if($_SESSION['token'] !== $_POST['token']){
	die("Request forgery detected");
}

require 'database.php';

$stmt = $mysqli->prepare("insert into comments (story_id, comment, commenter) values (?, ?, ?)");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}
 
$stmt->bind_param('iss', $story_id, $comment, $username);
 
$stmt->execute();
 
$stmt->close();

$story_path = sprintf("comments.php?story_id=%s", $story_id);

header("Location: $story_path");
 


?>