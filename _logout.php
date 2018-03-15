<?php
	session_start();

	$_SESSION['user']=null;		// Logout
    $_SESSION['id']=null;
	header('Location:index.php');
