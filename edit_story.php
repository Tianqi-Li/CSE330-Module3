<?php

session_start();
$story_id = (int) $_POST['story_id'];
$story_link = $_POST['story_link'];
$story_title = $_POST['story_title'];
if($_SESSION['token'] !== $_POST['token']){
	die("Request forgery detected");
}

require 'database.php';

        $stmt = $mysqli->prepare("select submitter from stories where story_id = '$story_id'");
        if(!$stmt){
                printf("Query Prep Failed: %s\n", $mysqli->error);
                exit;
        }
         
        $stmt->execute();
         
        $stmt->bind_result($submitter);
        
        $stmt->fetch();

        if($submitter != $_SESSION['user_id']){
            header("Location: tidaer.php");
        }
        
        $stmt->close();


$stmt = $mysqli->prepare("update stories SET link=?, title = ? where story_id = ?");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}
 
$stmt->bind_param('ssi', $story_link, $story_title, $story_id);
 
$stmt->execute();
 
$stmt->close();

header('Location: tidaer.php');
 


?>