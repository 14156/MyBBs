<?php
include_once '../inc/config.inc.php';
if(!isset($_GET['message']) || !isset($_GET['url']) || !isset($_GET['return_url'])){
	exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<title>Confirmation Page</title>
<meta name="keywords" content="Confirmation Page" />
<meta name="description" content="Confirmation Page" />
<link rel="stylesheet" type="text/css" href="style/remind.css" />
</head>
<body>
<div class="notice"><span class="pic ask"></span> <?php echo $_GET['message']?> &nbsp;&nbsp;&nbsp;&nbsp;<a style="color: red;" href="<?php echo $_GET['url'] ?>">YES</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="<?php echo$_GET['return_url'] ?>">CANCEL</a></div>
</body>
</html>