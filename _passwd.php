<?php
    session_start();
    require_once('DB.php');

	if(isset($_SESSION['id'])) {		// Assure Logged in
        $passwd=$_POST['new_password'];
        $passwd2=$_POST['new_password2'];

        if($passwd!=$passwd2) {
            header('Location:index.php?error=密码不匹配');
        } else {
            $passwd_user=new User($_SESSION['id'],null);  // use SID
            $passwd_user->setPassword($passwd);
            header('Location:index.php?success=密码修改成功');
        }
    } else {
        header('Location:index.php?info=您尚未登录');
    }
