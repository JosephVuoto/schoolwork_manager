<?php
/* Must be Super User  */    

session_start();
require_once('DB.php');

if(isset($_SESSION['id'])&&in_array($_SESSION['id'],$SUPERUSERS)) {
    echo '
	<!DOCTYPE html>
    <html>
        <head>
            <meta http-equiv="content-type" content="text/html; charset=utf8" />
            <meta name="viewport" content="width=device-width,initial-scale=1.0">
            <link rel="stylesheet" type="text/css" href="w3.css">
            <title>Grade Book</title>
        </head>
    <body>
        <article class="w3-content" style="max-width: 750px;">
            <div class="w3-container w3-large w3-teal">
                <form class="w3-panel w3-show-inline-block" method="post" action="gradebook.php">
                    <label class="w3-validate">作业编次：</label>
                    <select name="workname" id="workname" autofocus="autofocus" required >';
                    foreach ($ALLOWED_CHECK as $work) {
						if(isset($_POST['workname'])&&$work==$_POST['workname'])
							echo '<option value="'.$work.'" selected="selected">'.$SUBMIT_CONTENT[$work].'</option>';
						else
							echo '<option value="'.$work.'">'.$SUBMIT_CONTENT[$work].'</option>';
					}
    echo '
                    </select>
                    <input type="submit" value="查看">
                </form>
            </div>';
    if(isset($_POST['workname'])) {
        echo '
            <table class="w3-table-all">
                <tr class="w3-green">
                    <th>作业编次</th>
                    <th>姓名</th>
                    <th>学号</th>
                    <th>评分</th>
					<th>操作</th>
                </tr>';
        $submissions=Submission::getSubmissions($_POST['workname']);
        if($submissions)
            while($submission=$submissions->fetch_row()) {
				if(!in_array($submission[2],$SUPERUSERS)) {	//user.username
					if($submission[0]) {	//submitted
						echo '
							<tr class="w3-hover-light-blue">
								<td>'.$_POST['workname'].'</td>
								<td><a href=".'.$submission[5].'">'.$submission[1].'</a></td>
								<td>'.$submission[2].'</td>
								<td class="w3-text-red">'.$submission[3].'</td>
								<td>
									<form action="_gradebook.php" method="post" target="_blank">
										<input name="subid" id="subid" type="hidden" value="'.intval($submission[0]).'">';
						foreach($ALLOWED_GRADE as $g) {
							if($submission[3]=='')
								if(substr($_POST['workname'],0,1)=='L'&&$g==8)	// for Lab, default score is 8
									echo '<label class="w3-light-grey"><input name="grade" id="grade" type="radio" value="'.$g.'" checked="checked">'.$g.'</label>';
								elseif(substr($_POST['workname'],0,1)=='E'&&$g==10)	// for Ex, default score is 10
									echo '<label class="w3-light-grey"><input name="grade" id="grade" type="radio" value="'.$g.'" checked="checked">'.$g.'</label>';
								else
									echo '<label><input name="grade" id="grade" type="radio" value="'.$g.'">'.$g.'</label>';
							elseif($submission[3]==$g)
								echo '
										<label class="w3-light-grey"><input name="grade" id="grade" style="display: inline-block;" type="radio" value="'.$g.'" checked="checked">'.$g.'</label>';
							else
								echo '
										<label><input name="grade" id="grade" style="display: inline-block;" type="radio" value="'.$g.'">'.$g.'</label>';
						}
						echo '
										<input name="remark" id="remark" style="display: inline-block; max-width:120px;" type="text" placeholder='.$submission[4].'>';
						if($submission[3]=='')
							echo '
										<input class="w3-light-green w3-text-white" type="submit" value="评分">';
						else
							echo '
										<input class="w3-light-grey w3-text-black"  type="submit" value="修改">';
						echo '
									</form>
								</td>
							</tr>';
					} else {
						echo '
							<tr class="w3-hover-light-grey">
								<td>'.$_POST['workname'].'</td>
								<td>'.$submission[1].'</td>
								<td>'.$submission[2].'</td>
								<td></td>
								<td></td>
							</tr>';
					}
				}
            }
        echo '</table>';
    }
echo '
        </article>
    </body>
    </html>';
} else {
    header('Location: index.php?error=你大概不是管理员');
}
?>

