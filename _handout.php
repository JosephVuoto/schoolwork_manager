<?PHP
/* Must be Super User */

    session_start();
    require_once('DB.php');

    /* Debug File
        ini_set('display_errors',1);
        error_reporting(E_ALL);
        echo("客户端文件名：".$_FILES['handoutfile']['name']."<br/>");
        echo("文件类型：".$_FILES['handoutfile']['type']."<br/>");
        echo("文件大小Byte：".$_FILES['handoutfile']['size']."<br/>");
        echo("服务端临时文件名：".$_FILES['handoutfile']['tmp_name']."<br/>");
        echo("上传后新文件名：".$newfilepath."<br/>");
    */

if(isset($_SESSION['id'])&&in_array($_SESSION['id'],$SUPERUSERS)) {
    if(!$_FILES['handoutfile']) {
        header("Location: index.php?error=服务器谨慎地拒绝了此文件");
    } elseif($_FILES['handoutfile']['error'] != 0) {
        $ErrorMsg = "程序卖了个萌";
        switch($_FILES['handoutfile']['error']) {
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
    } else {
        // Handle filename
        $HandoutName=$_FILES['handoutfile']['name'];
        if(isset($_POST['handoutrename'])&&$_POST['handoutrename']!='') {
            $HandoutName=$_POST['handoutrename'].'.'.pathinfo($_FILES['handoutfile']['name'],PATHINFO_EXTENSION);
        }
        $HandoutBasePath=PATH_HANDOUTS;
        $HandoutBasePathAbsolute=$_SERVER['DOCUMENT_ROOT'].$HandoutBasePath;
        $HandoutPath=$HandoutBasePath.$HandoutName;
        $HandoutPathAbsolute=$_SERVER['DOCUMENT_ROOT'].$HandoutBasePath.$HandoutName;
		
		$HandoutBasePathAbsolute=mb_convert_encoding($HandoutBasePathAbsolute, "gbk", "utf-8");
		$HandoutPathAbsolute=mb_convert_encoding($HandoutPathAbsolute, "gbk", "utf-8"); // Files Must Covert Encoding

        // Create new folder if not exist
        if(!file_exists($HandoutBasePathAbsolute))
            mkdir($HandoutBasePathAbsolute);

        /* Debug Paths
            echo $HandoutBasePath; echo '<br />';
            echo $HandoutBasePathAbsolute; echo '<br />';
            echo $HandoutPath; echo '<br />';
            echo $HandoutPathAbsolute; echo '<br />';
            echo '<br />';
            echo $_FILES['handoutfile']['tmp_name']; echo '<br />';
        */

        if(!move_uploaded_file($_FILES['handoutfile']['tmp_name'],$HandoutPathAbsolute)) {
            header("Location: index.php?fatalerror=无法移动临时文件");
        } else {
            header("Location: index.php?success=上传成功");
        }
    }
} else {
    header("Location: index.php?error=你大概不是管理员");
}
