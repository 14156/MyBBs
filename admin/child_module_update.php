<?php
include_once '../inc/config.inc.php';
include_once '../inc/mysql.inc.php';
include_once 'inc/tool.inc.php';

$template['title']='Add Child Section';
$template['css']=array('style/public.css');
$link=connect();
if(!isset($_GET['id']) || !is_numeric($_GET['id'])){
	skip('child_module.php','error','Wrong id number');
}
$query="select * from `ao3-child-module` where id={$_GET['id']}";

$result=execute($link,$query);

if(!mysqli_num_rows($result)){
	skip('child_module.php','error','This sub-section does not exist');
}
$data=mysqli_fetch_assoc($result);
if(isset($_POST['submit'])){
	$check_flag='update';
	include 'inc/check_child_module.inc.php';
	$query="update `ao3-child-module` set parent_module_id={$_POST['parent_module_id']},module_name='{$_POST['module_name']}', info='{$_POST['info']}', member_id={$_POST["member_id"]}, sort={$_POST['sort']} where id={$_GET['id']}";
	execute($link, $query);
	if(mysqli_affected_rows($link)==1){
		skip('child_module.php','ok','Change updataed');
	}else{
		skip('child_module.php','error','Change failed, please try again');
	}
}
?>

<?php include 'inc/header.inc.php'?>

<div id="main">
	<div class="title" style="margin-bottom: 15px;">Modify Child Section - <?php echo $data['module_name']?></div>
<form method="post" >
	<table class="au">
		<tr>
			<td>Parent Sector</td>
			<td><select name="parent_module_id">
					<option value="0">===Choose the parent section===</option>
					<?php 
					$query="select * from `ao3-parent-module`";
					$result_parent=execute($link,$query);
					while ($data_parent=mysqli_fetch_assoc($result_parent)){
						if($data['parent_module_id']==$data_parent['id']){
							echo "<option selected='selected' value='{$data_parent['id']}'>{$data_parent['module_name']}</option>";
						}else{
							echo "<option value='{$data_parent['id']}'>{$data_parent['module_name']}</option>";
						}
					};
					?>
			</select></td>
			<td>
				Must choose an associated parent section.
			</td>
		</tr>
		<tr>
			<td>Section Name</td>
			<td><input name="module_name" value="<?php echo $data['module_name']?>" type="text" /></td>
			<td>
				Section name cannot be empty, maximum 66 characters.
			</td>
		</tr>
		<tr>
			<td>Section introduction</td>
			<td>
			<textarea name="info"><?php echo $data['info']?></textarea>
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
			<td><input name="sort" value="<?php echo $data['sort']?>" type="text" /></td>
			<td>
			Fill in the numbers
			</td>
		</tr>
			
	</table>
	<input style="margin-top: 15px; cursor: pointer" class="btn" type="submit" name="submit" value="Update">
</form>
</div>

<?php include 'inc/footer.inc.php'?>