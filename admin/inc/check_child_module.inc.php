<?php
	if(!is_numeric($_POST['parent_module_id'])){
		skip('child_module_add.php','error','Parent section name can not be empty.');
	}
	$query="select * from `ao3-parent-module` where id={$_POST['parent_module_id']}";
	$result=execute($link,$query);
	if(mysqli_num_rows($result)==0){
		skip('child_module_add.php','error','Parent section you chose does not exist.');
	}
	if(empty($_POST['module_name'])){
			skip('child_module_add.php','error','Section name can not be empty');
		}

	if(strlen($_POST['module_name'])>66){
		skip('child_module_add.php','error','Section name can not have more than 66 characters.');
	}
	$_POST=escape($link,$_POST);
	switch ($check_flag) {
		case 'add':
			$query="select * from `ao3-child-module` where module_name='{$_POST['module_name']}'";
			break;
		
		case 'update':
			$query="select * from `ao3-child-module` where module_name='{$_POST['module_name']}' and id!={$_GET['id']}";
			break;
		default:
			skip('child_module.php','error','$check_flag value error');
	}

	$result=execute($link,$query);
	if (mysqli_num_rows($result)){
		skip('child_module_add.php','error','Section name already exists.');
	}
	if(strlen($_POST['info'])>255){
		skip('child_module_add.php','error','Section introduction can not have more than 255 characters.');
	}
	if(!is_numeric($_POST['sort'])){
		skip('child_module_add.php','error','Sequence can only be a number');
	}
?>