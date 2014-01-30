<!DOCTYPE html>
<html>
<head>
        <title>Modify Story</title>
</head>

<body>
<?php
session_start();

$story_id = (int) $_GET['story_id'];

echo '<a href = "tidaer.php" > <img src ="TIDAER.png" alt = "Welcome to Tidaer!" height="80" width="237"> </a>';
echo '<br><br>';

require 'database.php';
$stmt = $mysqli->prepare("select title, link, submitter from stories where story_id = '$story_id'");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}
 
$stmt->execute();
 
$stmt->bind_result($story_title, $story_link, $submitter);
 

$stmt->fetch();

if($submitter != $_SESSION['user_id']){
header("Location: tidaer.php");
        }

	echo '<form action = "edit_story.php" method = "POST">';
		echo 'Title: <input type ="text" name = "story_title" value = "'.htmlentities($story_title).'">';
		echo '<br>';
		echo 'Link: <input type = "text" name = "story_link" value = "'.htmlentities($story_link).'">';
                echo '<input type = "hidden" name = "story_id" value = "'.$story_id.'">';
                echo '<input type="hidden" name="token" value="'.$_SESSION['token'].'">';
		echo '<input type ="submit" value ="Update">';
		echo '</form>';

        echo '<form action = "delete_story.php" method = "POST">';
        echo '<input type = "hidden" name = "story_id" value = "'.$story_id.'">';
        echo '<input type="hidden" name="token" value="'.$_SESSION['token'].'">';
        echo '<input type = "submit" value = "Delete Story">';
        echo '</form>';
 
$stmt->close();
?>
</body>
</html>
