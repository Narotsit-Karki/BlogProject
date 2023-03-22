<?php session_start(); ?>

<?php
	setcookie('uid','',time() - 3600);
	setcookie('username','',time() - 3600);
	$_SESSION['message'] = 'Logged Out Successfully';
	header("location:login.php");
?>
