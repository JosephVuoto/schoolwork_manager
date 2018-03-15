<?PHP
/* Must be Super User */
    session_start();
	require_once('DB.php');

if(isset($_SESSION['id']) && in_array($_SESSION['id'],$SUPERUSERS)) {
	$announce=new Announce($_POST['announcetitle'],$_POST['announcetext']);
    $announce->create();
    header("Location: index.php?");
} else {
    header("Location: index.php?fatalerror=你大概不是管理员");
}
