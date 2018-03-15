<!-- 页首导航 -->
<header class="w3-lime w3-large">
	<ul class="w3-navbar">
		<li>
			<a class="w3-text-white w3-green w3-hover-opacity" href="index.php">Csharper - C#作业提交平台</a>
		<li>
<?php
if(isset($_SESSION['id'])) {
    if(in_array($_SESSION['id'],$SUPERUSERS)) {
        echo '
            <li class="w3-right">
                <div class="w3-dropdown-hover">
                    <a class="w3-purple" >$'.$_SESSION['user'].'$</a>
                    <div class="w3-dropdown-content w3-border">
                        <a href="gradebook.php" target="_blank">成绩记录册</a>
						<a href="list.php?key=ks" target="_blank">提交情况</a>
                        <a onclick="modelManager(\'modelHandout\',\'open\')">上传资料</a>
						<a onclick="modelManager(\'modelAnnounce\',\'open\')">发布公告</a>
						<a onclick="modelManager(\'modelPasswd\',\'open\')">修改密码</a>
                        <a class="w3-light-grey" href="_logout.php">注销</a>
                    </div>
                </div>
            </li>';
    } else {
        echo '
            <li class="w3-right">
                <div class="w3-dropdown-hover">
                    <a class="w3-blue">&nbsp;&nbsp;&nbsp;'.$_SESSION['user'].'▼&nbsp;</a>
                    <div class="w3-dropdown-content w3-border">
                        <a onclick="modelManager(\'modelSubmit\',\'open\')">作业提交</a>
                        <a onclick="modelManager(\'modelReportCard\',\'open\')">作业记录</a>
                        <a onclick="modelManager(\'modelPasswd\',\'open\')">修改密码</a>
                        <a class="w3-light-grey" href="_logout.php">注销</a>
                    </div>
                </div>
            </li>';
    }
} else {
	echo '
		<li class="w3-right">
			<a class="w3-light-green w3-text-white" onclick="modelManager(\'modelLogin\',\'open\')">登录</a>
		</li>';
}
?>
	</ul>

    <!-- 模块：登录组件 -->
    <div id="modelLogin" class="w3-modal">
        <div class="w3-card-4 w3-modal-content" style="display: block; max-width: 35%; min-width: 350px;">
            <div class="w3-container w3-green">
                <span class="w3-closebtn" onclick="modelManager('modelLogin','close')">×</span>
                <h2 class="w3-center w3-text-white">登录</h2>
            </div>
            <div class="w3-container w3-white">
                <form class="w3-form" method="post" action="_login.php">
                    <div class="w3-input-group">
                        <label class="w3-label w3-validate">用户名：</label>
                        <input name="login_username" id="login_username" class="w3-input" type="text" placeholder="就是学号呐" autofocus="true" required />
                    </div>
                    <div class="w3-input-group">
                        <label class="w3-label w3-validate">密码：</label>
                        <input name="login_password" id="login_password" class="w3-input" type="password" placeholder="自己记好" required />
                    </div>
                    <div class="w3-input-group">
                        <input class="w3-input w3-green w3-hover-opacity" type="submit" value="登录">
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- 模块：提交作业组件 -->
    <div id="modelSubmit" class="w3-modal">
        <div class="w3-card-4 w3-modal-content" style="display: block; max-width: 40%; min-width: 375px;">
            <div class="w3-container w3-green">
                <span class="w3-closebtn" onclick="modelManager('modelSubmit','close')">×</span>
                <h2 class="w3-center w3-text-white">作业提交</h2>
            </div>
            <div class="w3-container w3-white">
                <form class="w3-form" method="post" action="_submit.php" enctype="multipart/form-data">
                    <div class="w3-input-group">
                        <label class="w3-label w3-validate">作业编次：</label>
                        <select class="w3-select" name="work" id="work"  autofocus="autofocus" required >
							<option value=""></option>
<?php
                    foreach ($ALLOWED_SUBMIT as $op)
                        echo '<option value="'.$op.'">'.$SUBMIT_CONTENT[$op].'</option>';
?>

                        </select>
                    </div>
                    <div class="w3-input-group">
                        <label class="w3-label w3-validate">提交文件：(仅单压缩文件，小于2MB)</label>
                        <input name="submitfile" id="uploadfile" class="w3-input" type="file" required />
                    </div>
                    <div class="w3-input-group">
                        <input class="w3-input w3-green w3-hover-opacity" type="submit" onclick="checkFileSize(this)" value="提交">
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- 模块：修改密码组件 -->
    <div id="modelPasswd" class="w3-modal w3-animate-opacity">
        <div class="w3-card-4 w3-modal-content" style="display: block; max-width: 35%; min-width: 350px;">
            <div class="w3-container w3-red">
                <span class="w3-closebtn" onclick="modelManager('modelPasswd','close')">×</span>
                <h2 class="w3-center w3-text-white">修改密码</h2>
            </div>
            <div class="w3-container w3-white">
                <form class="w3-form" method="post" action="_passwd.php">
                    <div class="w3-input-group">
                        <label class="w3-label w3-validate">新密码：</label>
                        <input name="new_password" id="new_password" class="w3-input" type="password" placeholder="要和下面那个一样" autofocus="true" required/>
                    </div>
                    <div class="w3-input-group">
                        <label class="w3-label w3-validate">确认新密码：</label>
                        <input name="new_password2" id="new_password2" class="w3-input" type="password" placeholder="要和上面那个一样" required />
                    </div>
                    <div class="w3-input-group">
                        <input class="w3-input w3-red w3-hover-opacity" type="submit" value="确认修改">
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- 模块：提交记录组件 -->
    <div id="modelReportCard" class="w3-modal">
        <div class="w3-card-4 w3-modal-content" style="display: block; max-width: 60%; min-width: 400px;">
            <div class="w3-container w3-indigo">
                <span class="w3-closebtn" onclick="modelManager('modelReportCard','close')">×</span>
                <h2 class="w3-center w3-text-white">作业记录</h2>
            </div>
            <div class="w3-panel w3-white">
                <table class="w3-table-all">
                    <tr>
                        <th>作业编次</th>
                        <th>更新时间</th>
						<th>得分</th>
						<th>说明</th>
                        <th>操作</th>
                    </tr>
<?php
    if(isset($_SESSION['id'])) {
        $user=new User($_SESSION['id'],null);
        $submissions=$user->getSubmissions();
        if($submissions)
            while($submission=$submissions->fetch_row()) {
				$grade=$submission[4];
				if($grade===null)
					$grade='暂未评分';
                echo '
                    <tr>
                        <td>'.$SUBMIT_CONTENT[$submission[1]].'</td>
                        <td>'.$submission[2].'</td>
						<td>'.$grade.'</td>
						<td>'.$submission[5].'</td>
                        <td><a href="'.$submission[3].'">下载</a></td>
                    </tr>';
            }
        else
            echo "asdasdasdadasdasd";
    }
?>
                </table>
                <br />
            </div>
        </div>
    </div>

<?php
if(isset($_SESSION['id'])&&in_array($_SESSION['id'],$SUPERUSERS))
echo '
    <!-- 模块：上传资料组件 -->
    <div id="modelHandout" class="w3-modal">
        <div class="w3-card-4 w3-modal-content" style="display: block; max-width: 40%; min-width: 375px;">
            <div class="w3-container w3-deep-orange">
                <span class="w3-closebtn" onclick="modelManager(\'modelHandout\',\'close\')">×</span>
                <h2 class="w3-center w3-text-white">上传资料</h2>
            </div>
            <div class="w3-container w3-white">
                <form class="w3-form" method="post" action="_handout.php" enctype="multipart/form-data">
                    <div class="w3-input-group">
                        <label class="w3-label w3-validate">上传文件：</label>
                        <input name="handoutfile" id="handoutfile" class="w3-input" type="file" required />
                    </div>
                    <div class="w3-input-group">
                        <label class="w3-label">重命名：(可选)</label>
                        <input name="handoutrename" id="handoutrename" class="w3-input" type="text"/>
                    </div>
                    <div class="w3-input-group">
                        <input class="w3-input w3-deep-orange w3-hover-opacity" type="submit" value="上传">
                    </div>
                </form>
            </div>
        </div>
    </div>
	
	<!-- 模块：发布公告组件 -->
    <div id="modelAnnounce" class="w3-modal">
        <div class="w3-card-4 w3-modal-content" style="display: block; max-width: 40%; min-width: 375px;">
            <div class="w3-container w3-yellow w3-text-white">
                <span class="w3-closebtn" onclick="modelManager(\'modelAnnounce\',\'close\')">×</span>
                <h2 class="w3-center w3-text-white">发布公告</h2>
            </div>
            <div class="w3-container w3-white">
                <form class="w3-form" method="post" action="_announce.php">
					<div class="w3-input-group">
                        <label class="w3-label">公告标题</label>
                        <input name="announcetitle" id="announcetitle" class="w3-input" type="text" required/>
                    </div>
                    <div class="w3-input-group">
                        <label class="w3-label">公告内容</label>
                        <textarea name="announcetext" id="announcetext" class="w3-input" required></textarea>
                    </div>
                    <div class="w3-input-group">
                        <input class="w3-input w3-yellow w3-text-white w3-hover-opacity" type="submit" value="发布">
                    </div>
                </form>
            </div>
        </div>
    </div>';
?>
</header>

<!-- 消息框 -->
<?php
if(isset($_GET['success'])) {
    echo '
    <div id="msgSuccess" class="w3-modal" onclick="closeMsg(\'msgSuccess\')" style="display: block; cursor: pointer;">
        <div class="w3-container w3-modal-content w3-leftbar w3-border-green w3-pale-green">
            <h4>成功: </h4>
            <p class="w3-container w3-panel w3-large">'.$_GET["success"].'</p>
        </div>
    </div>';
}  elseif(isset($_GET['info'])) {
    echo '
    <div id="msgInfo" class="w3-modal" onclick="closeMsg(\'msgInfo\')" style="display: block; cursor: pointer;">
        <div class="w3-container w3-modal-content w3-leftbar w3-border-blue w3-light-blue">
            <h4>提示: </h4>
            <p class="w3-container w3-panel w3-large">'.$_GET["info"].'</p>
        </div>
    </div>';
} elseif(isset($_GET['error'])) {
    echo '
    <div id="msgError" class="w3-modal" onclick="closeMsg(\'msgError\')" style="display: block; cursor: pointer;">
        <div class="w3-container w3-modal-content w3-leftbar w3-border-red w3-pale-red">
            <h4>错误: </h4>
            <p class="w3-container w3-panel w3-large">'.$_GET["error"].'</p>
        </div>
    </div>';
} elseif(isset($_GET['fatalerror'])) {
    echo '
    <div id="msgFatalError" class="w3-modal" onclick="closeMsg(\'msgFatalError\')" style="display: block; cursor: pointer;">
        <div class="w3-container w3-modal-content w3-leftbar w3-border-yellow w3-pale-yellow">
            <h4>致命错误: </h4>
            <p class="w3-container w3-panel w3-large">'.$_GET["fatalerror"].'</p>
        </div>
    </div>';
}
?>

<!-- 控制函数 -->
<script>
    function modelManager(modal,operation) {
        if(operation=='open') {
            document.getElementById(modal).style.display = "block"; //inline-blpck?
        } else {
            document.getElementById(modal).style.display = "none";
        }
    }
    function closeMsg(modal) {
        document.getElementById(modal).style.display = "none";
    }
    function checkFileSize(target){
        var isIE = /msie/i.test(navigator.userAgent) && !window.opera;
        var fileSize = 0;
        if (isIE && !target.files) {    // IE浏览器
            var filePath = target.value; // 获得上传文件的绝对路径
            var fileSystem = new ActiveXObject("Scripting.FileSystemObject");
            var file = fileSystem.GetFile(filePath);    // GetFile(path) 方法从磁盘获取一个文件并返回。
            fileSize = file.Size;    // 文件大小，单位：b
        } else {    // 非IE浏览器
            fileSize = target.files[0].size;
        }
        var size = fileSize / 1024 / 1024;
        if (size > 2) {
            alert("附件不能大于2M");
        }
    }
</script>