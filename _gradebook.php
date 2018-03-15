<?PHP
/* Must be Super User */
    session_start();
	require_once('DB.php');

if(isset($_SESSION['id']) && in_array($_SESSION['id'],$SUPERUSERS)) {
	if(isset($_POST['subid'])&&isset($_POST['grade'])&&isset($_POST['remark'])) {
		$id=intval($_POST['subid']);
		$score=intval($_POST['grade']);
		$remark=strval($_POST['remark']);
		if(!in_array($score,$ALLOWED_GRADE)) {
			header("Location: index.php?fatalerror=错误的成绩档级");
		} else {
			Submission::gradeSubmission($id,$score,$remark);
			echo '
				<script type="text/javascript">
					window.opener=null;
					window.close();
				</script>';
		}
	} else {
		header("Location: index.php?fatalerror=缺参数");
	}
} else {
    header("Location: index.php?fatalerror=你大概不是管理员");
}
