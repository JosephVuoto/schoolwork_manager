<?php
	session_start();
	require_once('DB.php');
	
	function alter($str) {
		$new_str='';
		for($i=0;$i<strlen($str);$i++) {
			if(substr($str,$i,1)==='\''||substr($str,$i,1)==='\"')
				$new_str=$new_str.'\\'.substr($str,$i,1);
			else
				$new_str=$new_str.substr($str,$i,1);
		}
		return $new_str;
	}
	
	$username=alter($_POST['login_username']);
	$password=alter($_POST['login_password']);
	$user=new User($username,$password);

	/* Manual */
	if(!$user->isExist())
		header('Location: index.php?error=用户不存在');
	elseif(!$user->verifyIdentity())
		header('Location: index.php?error=密码错误');
	else {
		$_SESSION['user']=$user->displayname;	//Login successful
        $_SESSION['id']=$user->username;
		header('Location: index.php');
	}
