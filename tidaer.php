<!DOCTYPE html>
<html>
	<head>
		<title>Tidaer</title>
		<link rel="stylesheet" type="text/css" href="tidaerstyle.css">
	</head>
	<body>
	<div class="main">
	<div class="float_left">
	<a href = "tidaer.php" > <img src ="TIDAER.png" alt = "Welcome to Tidaer!" height="80" width="237"> </a>
	<form action = "search_tidaer.php" method = "GET" >
		<label>Search: </label>
		<input type="text" name = "search">
	</form>
	<form method = "post">
	<label>Sort Stories By: </label>
	<select name="sort_by">
	<option value="newest">Newest</option>
	<option value="oldest">Oldest</option>
	<option value="user">Submitter</option>
	</select>
	<input type ="submit" value ="Sort">
	</form>
	
	<?php
	session_start();
	$_SESSION['token'] = substr(md5(rand()), 0, 10);
	
		if (!isset($_SESSION['user_id']) || ($_SESSION['user_id'] == "undefine")) {
		$_SESSION['user_id'] = "undefine";
		echo '</div>';
		echo '<div class = "sign_in">';
		echo '<h1>Log In</h1>';
		echo '<form action = "login_tidaer.php" method = "POST">';
		echo '<input type ="text" name = "username" value = "username" maxlength="30">';
		echo '<input type = "password" name = "password" value = "password">';
		echo '<input type = "submit" value = "Log In">';
		echo '</form>';
		echo '<h1>New User</h1>';
		echo '<form action = "newuser.php" method = "POST">';
		echo '<input type ="text" name = "username" value = "username" maxlength="30">';
		echo '<input type = "password" name = "password"  value="password">';
		echo '<input type = "submit" value = "Create New User">';
		echo '</form>';
		echo '</div>';
		echo '<br><br><br><br><br><br><br><br><br><br>Sign in to upload a story or comment:';
	} else {
		$user_id = $_SESSION['user_id'] ;
		echo "Hello ". htmlentities($user_id). "!";
<<<<<<< HEAD
		echo '</span>';
		echo '<span class = "sign_in">';
=======
		echo '</div>';
		echo '<div class = "sign_in">';
>>>>>>> 7190c37e7d8855be2b2dcdd2f961781a153cc163
		echo '<h1> Upload Story</h1>';
		echo '<form action = "upload_story.php" method = "POST">';
		echo 'Title: <input type ="text" name = "story_title" maxlength="300">';
		echo '<br>';
<<<<<<< HEAD
		echo 'Link: <input type = "text" name = "story_link maxlength="500"" >';
		echo '<input type="hidden" name="token" value="'.$_SESSION['token'].'" />';
=======
		echo 'Link: <input type = "text" name = "story_link" maxlength="500" >';
>>>>>>> 7190c37e7d8855be2b2dcdd2f961781a153cc163
		echo '<input type ="submit" value ="Upload">';
		echo '<input type="hidden" name="token" value="'.$_SESSION['token'].'">';
		echo '</form>';
		echo '<form method="POST" action="logout.php">';
		echo '<input type="Submit" value="Logout" name="Enter">';
		echo '</form>';
		echo '</div>';
			}
	
	require 'database.php';
	
	$sort_by = $_POST['sort_by'];
	if($sort_by == "newest" || !isset($sort_by)){
	$stmt = $mysqli->prepare("select link, title, submitter, time, story_id from stories order by time desc");
	} else if ($sort_by == "oldest"){
	$stmt = $mysqli->prepare("select link, title, submitter, time, story_id from stories order by time ");
		
	} else if ($sort_by == "user") {
		$stmt = $mysqli->prepare("select link, title, submitter, time, story_id from stories order by submitter ");
	}
	
	if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
	}
		 
	$stmt->execute();
		 
	$stmt->bind_result($link, $title, $submitter, $time, $story_id);

	echo "<table>";
	while($stmt->fetch()){
			echo '<tr>';
<<<<<<< HEAD
			echo '<td><a href="'.htmlentities($link).'" target="_blank"> '.htmlentities($title).'</a></td>';
=======
			echo '<td><a href="'.htmlentities($link).'"> '.htmlentities($title).'</a></td>';
>>>>>>> 7190c37e7d8855be2b2dcdd2f961781a153cc163
			echo '<td>'.htmlentities($submitter).'</td>';
			echo '<td>'.$time.'</td>';
			$comment_path = sprintf("comments.php?story_id=%s", $story_id);
			echo '<td><a href="'.$comment_path.'"> Comments </a></td>';
			if($submitter == $_SESSION['user_id']){
				$modify_path = sprintf("modify_story.php?story_id=%s", $story_id);
				echo '<td><a href="'.$modify_path.'"> Edit/Delete Story </a></td>';
			} else {
				echo '<td></td>';
			}
			echo '</tr>';
	}
	echo "</table>";
		 
	$stmt->close();
	
	?>
	</div>
	</body>
</html>