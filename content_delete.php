<?php
include_once 'inc/config.inc.php';
include_once 'inc/mysql.inc.php';
include_once 'inc/tool.inc.php';
include_once 'inc/check_user.inc.php';
$link=connect();
if(!$member_id=is_login($link)){
	skip('login.php','error','Please log in before delete a post.');
}

if(!isset($_GET['id']) || !is_numeric($_GET['id'])){
	skip('index.php','error','Post id not exist.');
}
$query="select member_id from `ao3-content` where id={$_GET['id']}";
$result_content=execute($link,$query);
if(mysqli_num_rows($result_content)==1){
	$data_content=mysqli_fetch_assoc($result_content);
	if(check_user($member_id,$data_content['member_id'])){
		$query="delete from `ao3-content` where id={$_GET['id']}";
		execute($link,$query);
		if(mysqli_affected_rows($link)==1){
			skip("member.php?id={$member_id}",'ok','Congratulations! The post is deleted.');
		}else{
			skip("member.php?id={$member_id}",'error','Delete failed, please try again.');
		}
	}else{
		skip("member.php?id={$member_id}",'error','You are not authorized to delete this post.');
	}
}else{
	skip("member.php?id={$member_id}",'error','Post does not exist.');
}

$template['title']='Subsection List';
$template['css']=array('style/public.css','style/list.css');
?>