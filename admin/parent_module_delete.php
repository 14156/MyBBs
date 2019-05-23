<?php
include_once '../inc/config.inc.php';
include_once '../inc/mysql.inc.php';
include_once 'inc/tool.inc.php';

if(!isset($_GET['id']) || !is_numeric($_GET['id'])){
	skip('father_module.php','error','Wrong ID!');
}

$link=connect();
$id = isset($_GET['id']) ? $_GET['id'] : ''; 
$query="select * from `ao3-child-module` where parent_module_id={$_GET['id']}";
$result=execute($link,$query);
if(mysqli_num_rows($result)){
	skip('parent_module.php','error','Delete related child section before delete parent section.');
}
// isset() function to check whether the variable is defied or not
$query="delete from `ao3-parent-module` where id='$id'";

execute($link, $query);
if(mysqli_affected_rows($link)==1){
	skip('parent_module.php','ok','Congrats!');
}else{
	skip('parent_module.php','error','Oops, delete failed. Please try again.');
}
?>