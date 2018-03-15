<?php

require_once('DB.php');
	
if(isset($_GET['key'])&&$_GET['key']=="ks") {
	$works=array_keys($SUBMIT_CONTENT);
	sort($works);
	
	$sqlqueryHead="SELECT username,COUNT(work),GROUP_CONCAT(work) FROM user LEFT JOIN (SELECT SID,work FROM submission WHERE ";
	$sqlqueryTail=") AS sub ON user.username=sub.SID GROUP BY username;";	
	$sqlqueryBody="";
	if(count($works)<=1) {
		$sqlqueryBody="work='".$works[0]."' ";
	} else {
		$sqlqueryBody="work='".$works[0]."' ";
		for($i=1;$i<count($works);$i++)
			$sqlqueryBody=$sqlqueryBody." OR work='".$works[$i]."' ";
	}
	$sqlquery=$sqlqueryHead.$sqlqueryBody.$sqlqueryTail;
	
	//echo $sqlquery;

	$result=(new DB())->exec($sqlquery);
	if($result) {
		echo '
			<table>
				<tr>
					<th>学号</th>
					<th>总计</th>';
		foreach($works as $sc)
			echo '<th>'.$sc.'</th>';
		echo '
				</tr>';
		while($row=($result->fetch_row()))
		if($row[0]!='kahsolt'&&$row[0]!='tkhkdjt') {
			$w=explode(",",$row[2]);
			sort($w);
			echo '
				<tr>
					<td>'.$row[0].'</td>
					<td>'.$row[1].'</td>';
			foreach($works as $i)
				if(in_array($i,$w))
					echo '<td>√</td>';
				else
					echo '<td></td>';
			echo '
				</tr>';
		}
		echo '
			</table>';
	}
} else {
	echo 'key?';
}
		