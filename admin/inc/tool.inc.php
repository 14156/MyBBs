<?php
function skip($url,$pic,$message){
$html=<<<A
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<meta http-equiv="refresh" content="3;URL={$url}" />
<title>Skip Page</title>

<link rel="stylesheet" type="text/css" href="style/remind.css" />
</head>
<body>
<div class="notice"><span class="pic {$pic}"></span> {$message} <a href="{$url}">The page will be redirected in 3 seconds.</a></div>
</body>
</html>
A;
echo $html;
exit();
}

function is_login($link){
	if(isset($_COOKIE['ao3']['name']) && isset($_COOKIE['ao3']['pw'])){
		$query="select * from `ao3-member` where name='{$_COOKIE['ao3']['name']}' and sha1(pw)='{$_COOKIE['ao3']['pw']}'";
		$result=execute($link,$query);
		if(mysqli_num_rows($result)==1){
			$data=mysqli_fetch_assoc($result);
			return $data['id'];
		}else{
			return false;
		}
	}else{
		return false;
	}

}
?>