<?PHP
    session_start();
	require_once('DB.php');
    require_once('config.php');  // user config file

	/* Debug File
	    ini_set('display_errors',1);
        error_reporting(E_ALL);
		echo("客户端文件名：".$_FILES['submitfile']['name']."<br/>");
		echo("文件类型：".$_FILES['submitfile']['type']."<br/>");
		echo("文件大小Byte：".$_FILES['submitfile']['size']."<br/>");
		echo("服务端临时文件名：".$_FILES['submitfile']['tmp_name']."<br/>");
		echo("上传后新文件名：".$newfilepath."<br/>");
	*/

if(isset($_SESSION['id'])) {
	function endsWith($haystack, $needle) {
		$length = strlen($needle);
		if ($length == 0)
			return true;
		else
			return (strtolower(substr($haystack, -$length)) === $needle);
	}
	function filterType($type,$name) {
	    if(strpos($type,'gzip')!==false||endsWith($name,'gzip')) return true;
        if(strpos($type,'bzip2')!==false||endsWith($name,'bzip2')) return true;
        if(strpos($type,'zip')!==false||endsWith($name,'zip')) return true;
        if(strpos($type,'rar')!==false||endsWith($name,'rar')) return true;
        if(strpos($type,'tar')!==false||endsWith($name,'tar')) return true;
        if(strpos($type,'7z')!==false||endsWith($name,'7z')) return true;
        return false;
    }

	// Handle file
	if(!$_FILES['submitfile']) {
        header("Location: index.php?error=服务器谨慎地拒绝了此文件");
    } elseif($_FILES['submitfile']['error'] != 0) {
		$ErrorMsg = "程序卖了个萌";
		switch($_FILES['submitfile']['error']) {
			case 1:
            case 2:
				$ErrorMsg = "文件太大装不下";
				break;
			case 3:
            case 4:
                $ErrorMsg = "部分上传或文件未找到";
                break;
            case 5:
            case 6:
            case 7:
            case 8:
                $ErrorMsg = "服务器权限或配置问题";
				break;
			default:
                $ErrorMsg = "未知文件上传错误";
				break;
		}
		header("Location: index.php?fatalerror=".$ErrorMsg);
	} elseif(!filterType($_FILES['submitfile']['type'],$_FILES['submitfile']['name'])) {
        header("Location: index.php?error=不支持的文件类型");	    //文件格式不支持
    } elseif(!in_array($_POST['work'],$ALLOWED_SUBMIT)) {
        header("Location: index.php?fatalerror=没有这种作业编次啊");  //Wrong Post
    } else {
        // Handle filename
        $SID=$_SESSION['id'];
        $SName=$_SESSION['user'];
        $Workname=$_POST['work'];
        $Curtime=getdate();
        $Uploadtime=$Curtime['year'].$Curtime['mon'].$Curtime['mday'].$Curtime['hours'].$Curtime['minutes'].$Curtime['seconds'];
        $Random=rand(10,99);
        $Ext=pathinfo($_FILES['submitfile']['name'],PATHINFO_EXTENSION);
        $ArcheiveName=$SID.'_'.$SName.'_'.$Workname.'_'.$Uploadtime.'_'.$Random.'.'.$Ext;   // with file ext, without base path
        $ArcheiveBasePath=PATH_SUBMITS.$Workname.'/';
        $ArcheiveBasePathAbsolute=$_SERVER['DOCUMENT_ROOT'].$ArcheiveBasePath;
        $ArcheivePath=$ArcheiveBasePath.$ArcheiveName;
        $ArcheivePathAbsolute=$_SERVER['DOCUMENT_ROOT'].$ArcheiveBasePath.$ArcheiveName;
		
		$ArcheiveBasePathAbsolute=mb_convert_encoding($ArcheiveBasePathAbsolute, "gbk", "utf-8");
		$ArcheivePathAbsolute=mb_convert_encoding($ArcheivePathAbsolute, "gbk", "utf-8"); // Files Must Covert Encoding

        // Create new folder if not exist
        if(!file_exists($ArcheiveBasePathAbsolute))
            mkdir($ArcheiveBasePathAbsolute);

        /* Debug Paths
            echo $ArcheiveBasePath; echo '<br />';
            echo $ArcheiveBasePathAbsolute; echo '<br />';
            echo $ArcheivePath; echo '<br />';
            echo $ArcheivePathAbsolute; echo '<br />';
            echo '<br />';
            echo $_FILES['submitfile']['tmp_name']; echo '<br />';
        */

		if(!move_uploaded_file($_FILES['submitfile']['tmp_name'], iconv("gbk","UTF-8",$ArcheivePathAbsolute))) {
			header("Location: index.php?fatalerror=无法移动临时文件");
		} else {
            $submission=new Submission($SID,$Workname,$ArcheivePath);
            $res=$submission->submitWork();
            if($res=='create') {
                header("Location: index.php?success=提交成功");
            } else {
                header("Location: index.php?success=重新提交成功");
            }
		}
	}
} else {
    header("Location: index.php?fatalerror=请不要调戏服务器");
}
