<!-- 内容 -->
<article class="w3-content w3-row">

<div class="w3-third">
    <!-- 资料下载 -->
    <section class="w3-section w3-panel">
        <ul class="w3-ul w3-border w3-hoverable">
            <li class="w3-light-green w3-text-white"><b>资料下载</b></li>
<?php
$path='.'.PATH_HANDOUTS;
foreach(scandir($path) as $afile) {
    if ($afile != '.' && $afile != '..' && is_file($path.$afile)===true) {
        echo '<li><a href="'.mb_convert_encoding($path.$afile, "utf-8", "gbk").'">'.mb_convert_encoding($afile, "utf-8", "gbk").'</a></li>';
    }
}
?>
        </ul>
    </section>
</div>

<div class="w3-twothird">
    <!-- 通知公告 -->
    <section class="w3-section w3-panel">
        <ul class="w3-ul w3-border w3-hoverable">
            <li class="w3-teal"><b>通知公告</b></li>
<?php
$announces=Announce::getAnnounces();
if($announces)
    while($announce=$announces->fetch_row()) {
        echo '
            <li>
                <b><'.$announce[1].'> </b>'.$announce[2].'
            </li>';
    }
?>
        </ul>
    </section>
	
	<!-- 作业简评 -->
    <section class="w3-section w3-panel">
        <ul class="w3-ul w3-border w3-hoverable">
            <li class="w3-light-blue w3-text-white"><b>作业简评</b></li>
<?php
$path=PATH_REMARKS;
$fin = fopen($path, "r");
if($fin)
	while(!feof($fin))
	  echo '<li>'.fgets($fin).'</li>';
fclose($fin);
?>
        </ul>
    </section>
</div>

    <!-- 留言吐槽 -->
    <section class="w3-section w3-panel">
        <ul class="w3-ul w3-border w3-hoverable">
            <li class="w3-blue w3-text-white"><b>留言吐槽</b></li>
<?php
$messages=Message::getMessages();
if($messages)
    while($message=$messages->fetch_row()) {
        if($message[1]=='') $message[1]='匿名';
        echo '
            <li>
                <b>['.$message[1].']&nbsp'.$message[3].'</b> '.$message[2].'
            </li>';
    }
?>
        </ul>
    </section>
</div>

</article>