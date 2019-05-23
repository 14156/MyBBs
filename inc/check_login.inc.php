<?php
if(empty($_POST['name'])){
	skip('login.php','error','Username can not be empty');
}
if(mb_strlen($_POST['name'])>32){
	skip('login.php','error','Username can not be more than 32 characters');
}
if(empty($_POST['pw'])){
	skip('login.php','error','Password can not be empty');
}
//if(strtolower($_POST['vcode'])!=strtolower($_SESSION['vcode'])){
// 	skip('register.php','error','Verification code error, please try again!');
// }
 if(empty($_POST['time']) || is_numeric($_POST['time']) || $_POST['time']>2592000){
 	$_POST['time']=2592000;
 };


?>