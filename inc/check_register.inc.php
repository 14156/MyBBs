<?php
if(empty($_POST['name'])){
	skip('register.php','error','User name can not be empty.');
}
if(mb_strlen($_POST['name'])>32){
	skip('register.php','error','User name has more than 32 characters.');
}
if(mb_strlen($_POST['pw'])<6){
	skip('register.php','error','Password can not be less than 6 characters.');
}
if($_POST['pw']!=$_POST['confirm_pw']){
	skip('register.php','error','The password entered are not the same.');
}
if(strtolower($_POST['vcode'])!=strtolower(implode("",$_SESSION['vcode']))){
	skip('register.php','error','Verification code error, please try again!');
}

$_POST=escape($link,$_POST);
$query="select * from `ao3-member` where name='{$_POST['name']}'";
$result=execute($link,$query);
if(mysqli_num_rows($result)){
	skip('register.php','error','This Username already exist, please try another one.');
}
?>