<?php
include_once '../inc/config.inc.php';
include_once '../inc/mysql.inc.php';
include_once 'inc/tool.inc.php';
$template['title']='Add Child Section';
$template['css']=array('style/public.css');
$link=connect();
if(isset($_POST['submit'])){
	//Varify the info filled by users
	$check_flag='add';
	include 'inc/check_child_module.inc.php';
	$query="insert into `ao3-child-module`(parent_module_id,module_name,info,member_id,sort) values({$_POST['parent_module_id']},'{$_POST['module_name']}','{$_POST['info']}',{$_POST['member_id']},{$_POST['sort']})";

	execute($link,$query);
	if(mysqli_affected_rows($link)==1){
		skip('child_module.php','ok','Sub-section added successfully');
	}else{
		skip('child_module_add.php','error','Sub-section add failed, please try again');
	}
}
?>

<?php include 'inc/header.inc.php'?>

<div id="main">
	<div class="title" style="margin-bottom: 15px;">Add Child Section </div>
<form method="post" >
	<table class="au">
		<tr>
			<td>Parent Sector</td>
			<td><select name="parent_module_id">
					<option value="0">===Choose the parent section===</option>
					<?php 
					$query="select * from `ao3-parent-module`";
					$result_parent=execute($link,$query);
					while ($data_parent=mysqli_fetch_assoc($result_parent)) {
						echo "<option value='{$data_parent['id']}'>{$data_parent['module_name']}</option>";
					};
					?>
			</select></td>
			<td>
				Must choose an associated parent section.
			</td>
		</tr>
		<tr>
			<td>Section Name</td>
			<td><input name="module_name" type="text" /></td>
			<td>
				Section name cannot be empty, maximum 66 characters.
			</td>
		</tr>
		<tr>
			<td>Section introduction</td>
			<td>
			<textarea name="info"></textarea>
			</td>
			<td>
				Section introduction maximum 255 characters.
			</td>
		</tr>
		<tr>
			<td>Moderator</td>
			<td><select name="member_id">
					<option value="0">===Choose one member as moderator===</option>
			</select></td>
			<td>
				Please choose a member as the moderator of this section.
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