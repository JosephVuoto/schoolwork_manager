<?PHP
    session_start();
	require_once('DB.php');

if(isset($_SESSION['id'])) {

	$poster=$_SESSION['user'];
	if(isset($_POST['isAnonymous'])&&$_POST['isAnonymous']=="true")
		$poster=null;
	$msg=trim($_POST['message']);
	if($msg=='')
		header("Location: index.php?info=语空无用");
	else {
		$message=new Message($poster, $_POST['message']);
		$message->create();
		header("Location: index.php");
	}
} else {
	header("Location: index.php?error=你可能还没登录呐");
}
