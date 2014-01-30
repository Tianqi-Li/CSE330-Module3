<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="tidaerstyle.css">
		<title>Tidaer Comments</title>
	</head>
	<body>
	<div class="main">
	<a href = "tidaer.php" > <img src ="TIDAER.png" alt = "Welcome to Tidaer!" height="80" width="237"> </a>
	
	<form method = "post">
	<label>Sort Comments By: </label>
	<select name="sort_by">
	<option value="newest">Newest</option>
	<option value="oldest">Oldest</option>
	<option value="user">Commenter</option>
	</select>
	<input type ="submit" value ="Sort">
	</form>
	
	<?php
	session_start();
	$story_id = (int) $_GET['story_id'];
	
	require 'database.php';
	
	$sort_by = $_POST['sort_by'];
	if($sort_by == "newest" || !isset($sort_by)){
	$stmt = $mysqli->prepare("select comment, commenter, time,comment_id from comments where story_id = '$story_id' order by time desc");
	} else if ($sort_by == "oldest"){
	$stmt = $mysqli->prepare("select comment, commenter, time,comment_id from comments where story_id = '$story_id' order by time");
		
	} else if ($sort_by == "user") {
	$stmt = $mysqli->prepare("select comment, commenter, time,comment_id from comments where story_id = '$story_id' order by commenter");
	}
	
	
	if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
	}
		 
	$stmt->execute();
		 
	$stmt->bind_result($comment, $commenter, $time, $comment_id);
		 
	echo "<table>";
	while($stmt->fetch()){
			echo '<tr>';
			echo '<td>'.htmlentities($comment).'</td>';
			echo '<td>'.htmlentities($commenter).'</td>';
			echo '<td>'.$time.'</td>';
			if($commenter == $_SESSION['user_id']){
				$modify_path = sprintf("modify_comment.php?story_id=%s&comment_id=%s", (string) $story_id, $comment_id);
				echo '<td><a href="'.$modify_path.'"> Edit/Delete Comment </a></td>';
			} else {
				echo '<td></td>';
			}
			echo '</tr>';
	}
	echo "</table>";
	
	$stmt->close();
	
	$stmt = $mysqli->prepare("select COUNT(*) from comments where story_id = '$story_id'");
	if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
	}
		 
	$stmt->execute();
	
	$stmt->bind_result($count);
	
	while($stmt->fetch()){
		$comment_count = $count;
	}
	
	$stmt->close();
	
	if($comment_count == 0){
	echo "There are no comments here";
	}
	


	echo '<br><br>';
		
	if (isset($_SESSION['user_id']) && $_SESSION['user_id'] != "undefine"){
		echo '<form action = "upload_comment.php" method = "POST">';
		echo '<input type = "hidden" name = "story_id" value = "'.$story_id.'">';
		echo '<input type="hidden" name="token" value="'.$_SESSION['token'].'">';
		echo 'Comment: <input type ="text" name = "comment">';
		echo '<input type ="submit" value ="Submit">';
		echo '</form>';
		echo '<br>';
		echo '<form method="POST" action="logout.php">';
		echo 'Click here to Logout: <input type="Submit" value="Logout" name="Enter">';
		echo '</form>';
	} else {
		echo 'Please log in to comment';
	}
	?>
	</div>
	</body>
</html>
	