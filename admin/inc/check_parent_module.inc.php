<?php
	if(empty($_POST['module_name'])){
		skip('parent_module_add.php','error','Section name can not be empty');
	}

	if(strlen($_POST['module_name'])>66){
		skip('parent_module_add.php','error','Section name can not have more than 66 characters.');
	}
	if(!is_numeric($_POST['sort'])){
		skip('parent_module_add.php','error','Sequence can only be a number');
	}
	$_POST=escape($link,$_POST);
	switch ($check_flag) {
		case 'add':
			$query="select * from `ao3-parent-module` where module_name='{$_POST['module_name']}'";
			break;
		
		case 'update':
			$query="select * from `ao3-parent-module` where module_name='{$_POST['module_name']}' and id!={$_GET['id']}";
			break;
		default:
			skip('parent_module_add.php','error','$check_flag value error');
	}
	
	$result=execute($link,$query);
	if (mysqli_num_rows($result)){
		skip('parent_module_add.php','error','Section name already exists.');
	}
?>