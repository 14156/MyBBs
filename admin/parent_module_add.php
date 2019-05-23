<?php 
include_once '../inc/config.inc.php';
include_once '../inc/mysql.inc.php';
include_once 'inc/tool.inc.php';
if (isset($_POST['submit'])){
	$link=connect();
	//Varify the info filled by users
	$check_flag='add';
	include 'inc/check_parent_module.inc.php';
	$query="insert into `ao3-parent-module`(module_name,sort) values('{$_POST['module_name']}',{$_POST['sort']})";
	execute($link, $query);
	if(mysqli_affected_rows($link)==1){
		skip('parent_module.php','ok','Section added successfully');
	}else{
		skip('parent_module_add.php','error','Section add failed, please try again');
	}
}
// exit();
$template['title']='Add Parent Section';
$template['css']=array('style/public.css');
?>

<?php include 'inc/header.inc.php'?>
<div id="main">
	<div class="title" style="margin-bottom: 15px;">Add Parent Section </div>
<form method="post" >
	<table class="au">
			<tr>
				<td>Section Name</td>
				<td><input name="module_name" type="text" /></td>
				<td>
					Section name cannot be empty, maximum 66 characters.
				</td>
			</tr>
			<tr>
				<td>Sort</td>
				<td><input name="sort" value="0" type="text" /></td>
				<td>
				Fill in the numbers
				</td>
			</tr>
			
	</table>
	<input style="margin-top: 15px; cursor: pointer" class="btn" type="submit" name="submit" value="Add">
</form>
</div>

<?php include 'inc/footer.inc.php'?>