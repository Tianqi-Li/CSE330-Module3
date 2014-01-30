<!DOCTYPE html>

<html>
<head>
	<title>
		Modify Comment
	</title>
</head>

<body>
<?php
session_start();
$story_id = (int) $_GET['story_id'];
$comment_id = (int) $_GET['comment_id'];

echo '<a href = "tidaer.php" > <img src ="TIDAER.png" alt = "Welcome to Tidaer!" height="80" width="237"> </a>';
echo '<br><br>';

require 'database.php';
$stmt = $mysqli->prepare("select comment from comments where comment_id = '$comment_id'");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}
 
$stmt->execute();
 
$stmt->bind_result($comment);
 

$stmt->fetch();

echo '<form action = "edit_comment.php" method = "POST">';
<<<<<<< HEAD
echo '<input type = "hidden" name = "story_id" value = "'.$story_id.'">';
echo '<input type = "hidden" name = "comment_id" value = "'.$comment_id.'">';
=======
echo '<input type = "hidden" name = "story_id" value = "'.htmlentities($story_id).'">';
echo '<input type = "hidden" name = "comment_id" value = "'.htmlentities($comment_id).'">';
echo '<input type="hidden" name="token" value="'.$_SESSION['token'].'">';
>>>>>>> 7190c37e7d8855be2b2dcdd2f961781a153cc163
echo 'Comment: <input type ="text" name = "comment" value = "'.htmlentities($comment).'">';
echo '<input type ="submit" value ="Submit">';
echo '</form>';



echo '<form action = "delete_comment.php" method = "POST">';
echo '<input type = "hidden" name = "story_id" value = "'.htmlentities($story_id).'">';
echo '<input type = "hidden" name = "comment_id" value = "'.htmlentities($comment_id).'">';
echo '<input type="hidden" name="token" value="'.$_SESSION['token'].'">';
echo '<input type = "submit" value = "Delete Comment">';
echo '</form>'

?>
</body>
</html>
