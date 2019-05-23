<?php
if(empty($_POST['module_id']) || !is_numeric($_POST['module_id'])){
	skip('publish.php','error','Section id is illegal.');
}
$query="select * from `ao3-child-module` where id={$_POST['module_id']}";
$result=execute($link,$query);
if(mysqli_num_rows($result)!=1){
	skip('publish.php','error','Section id is invalid.');
}
if(empty($_POST['title'])){
	skip('publish.php','error','Title can not be empty.');
}
if(mb_strlen($_POST['title'])>255){
	skip('publish.php','error','Title cannot has more than 255 characters.');
}

?>