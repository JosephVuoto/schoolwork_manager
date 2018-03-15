<!-- 页脚版权 -->
<footer class="w3-bottom w3-blue w3-small">
<?php
if(isset($_SESSION['id']))
	echo '
	<form class="w3-form w3-show-inline-block" method="post" action="_message.php">
		<label class="w3-label w3-validate w3-text-white">在这里发弹幕(并不：</label>
		<input id="message" name="message" type="text" placeholder="吐槽、建议、提问……" required />
		<label>匿名<input id="isAnonymous" name="isAnonymous" type="checkbox" value="true"/></label>
		<input type="submit" value="发送"/>
		<label  class="w3-label w3-validate w3-text-white">(为什么dalao们都这么喜欢匿名</label>
	</form>';
?>
	<p class="w3-right w3-container">Powered by Buaacsharp.</p>
</footer>
