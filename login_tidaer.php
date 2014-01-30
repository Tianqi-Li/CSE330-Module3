<?php
session_start();
require 'database.php';


// Use a prepared statement
$stmt = $mysqli->prepare("SELECT COUNT(*), username, password_encrypted FROM users WHERE username=?");
 
// Bind the parameter
$stmt->bind_param('s', $user);
$user = $_POST['username'];
$stmt->execute();
 
// Bind the results
$stmt->bind_result($cnt, $user_id, $pwd_hash);
$stmt->fetch();
 
$pwd_guess = $_POST['password'];
// Compare the submitted password to the actual password hash
if( $cnt == 1 && crypt($pwd_guess, $pwd_hash)==$pwd_hash){
	// Login succeeded!
	$_SESSION['user_id'] = $user_id;
        $_SESSION['token'] = substr(md5(rand()), 0, 10);
	header('Location: tidaer.php');
        ;
}else{
	echo "Not a valid login. Please try again";
        echo  '<a href="http://ec2-54-200-33-75.us-west-2.compute.amazonaws.com/~BrandonGoren/tidaer.php"> Go Back</a>';
}

?>