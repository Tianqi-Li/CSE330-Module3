<?php
	session_start();
	$story_id = $_POST['story_id'];
	$comment_id = (int) $_POST['comment_id'];
	if($_SESSION['token'] !== $_POST['token']){
	die("Request forgery detected");
}
	
	
        
        require 'database.php';

	$stmt = $mysqli->prepare("select commenter from comments where comment_id = '$comment_id'");
	if(!$stmt){
		printf("Query Prep Failed: %s\n", $mysqli->error);
		exit;
	}
	 
	$stmt->execute();
	 
	$stmt->bind_result($commenter);
	 
	
	$stmt->fetch();
	
	if($commenter != $_SESSION['user_id']){
	$comment_path = sprintf("comments.php?story_id=%s", $story_id);
	header("Location: $comment_path");
	}
	
	$stmt->close();
	
        $stmt = $mysqli->prepare("delete from comments where comment_id = '$comment_id'");
        if(!$stmt){
                printf("Query Prep Failed: %s\n", $mysqli->error);
                exit;
        }
         
        $stmt->bind_param('i', $comment_id);
         
        $stmt->execute();
         
        $stmt->close();
    
	$comment_path = sprintf("comments.php?story_id=%s", $story_id);
        header("Location: $comment_path");

?>