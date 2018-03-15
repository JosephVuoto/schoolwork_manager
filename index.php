<?php
    session_start();
    require_once('DB.php');
?>

<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf8" />
	<meta name="viewport" content="width=device-width,initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="w3.css">
	<style type="text/css">
        a:hover { cursor: pointer; }
    </style>
    <title><?php echo SITENAME;?></title>
</head>
<body>

<?php
if(MODE_DEBUG===false) {
	// Header
	include('header.php');
	// Content
	include('content.php');
	echo '<br/><br/><br/>';
	// Footer
	include('footer.php');
} else {
	include('debug.php');
}
?>

</body>
</html>
