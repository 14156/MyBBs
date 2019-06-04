<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<title><?php echo $template['title']?></title>
<meta name="keywords" content="" />
<meta name="description" content="" />
<!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous"> -->
<?php
foreach ($template['css'] as $val) {
	echo "<link rel='stylesheet' type='text/css' href='{$val}'/>";
}
?>

</head>
<body>
	<div class="header_wrap">
		<div id="header" class="auto">
			<div class="logo" href="index.php">AO#</div>
			<div class="nav">
				<a class="hover" href="index.php">HOME</a>
			</div>
			<div class="serarch">
				<form>
					<input class="keyword" type="text" name="keyword" placeholder="Search" />
					<input class="submit" type="submit" name="submit" value="" />
				</form>
			</div>
			<div class="login" >
			<?php 
				if(isset($member_id) && $member_id){
$str=<<<A
<a href="member.php?id={$member_id}" target="_blank"> Hello, {$_COOKIE['ao3']['name']}</a> <span style="color:#fff">|</span> <a href="logout.php">SIGN OUT</a>
A;
					echo $str;
				}else{
$str=<<<A
<a href="login.php">SIGN IN</a>&nbsp;&nbsp;<a href="register.php">Register</a>
A;
					echo $str;
				}
				?> 
			</div>
		</div>
	</div>
	<div style="margin-top:55px;"></div>


