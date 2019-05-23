<?php
include_once '../inc/config.inc.php';
include_once '../inc/mysql.inc.php';
include_once 'inc/tool.inc.php';

if(!isset($_GET['id']) || !is_numeric($_GET['id'])){
	skip('child_module.php','error','Wrong ID!');
}

$link=connect();
$id = isset($_GET['id']) ? $_GET['id'] : ''; 
// isset() function to check whether the variable is defied or not
$query="delete from `ao3-child-module` where id='$id'";

execute($link, $query);
if(mysqli_affected_rows($link)==1){
	skip('child_module.php','ok','Sub section deleted!');
}else{
	skip('child_module.php','error','Oops, delete failed. Please try again.');
}
?>