<?php
include_once '../inc/config.inc.php';
include_once '../inc/mysql.inc.php';
include_once 'inc/tool.inc.php';
include 'inc/check_parent_module.inc.php';

$template['title']='Modify Parent Section';
$template['css']=array('style/public.css');

$link=connect();
if(!isset($_GET['id']) || !is_numeric($_GET['id'])){
	skip('parent_module.php','error','Wrong id number');
}

$query="select * from `ao3-parent-module` where id={$_GET['id']}";

$result=execute($link,$query);

if(!mysqli_num_rows($result)){
	skip('parent_module.php','error','This section does not exist');
}

if(isset($_POST['submit'])){
	//Varify the info filled by users
	$check_flag='update';
	
	$query="update `ao3-parent-module` set module_name='{$_POST['module_name']}', sort={$_POST['sort']} where id={$_GET['id']}";
	execute($link, $query);
	if(mysqli_affected_rows($link)==1){
		skip('parent_module.php','ok','Change updataed');
	}else{
		skip('parent_module.php','error','Change failed, please try again');
	}
}
$data=mysqli_fetch_assoc($result);
?>


<?php include 'inc/header.inc.php'?>
<div id="main">
	<div class="title" style="margin-bottom: 15px;">Modify Parent Section - <?php echo $data['module_name']?></div>
<form  method="post" >
	<table class="au">
			<tr>
				<td>Section Name</td>
				<td><input name="module_name"  value="<?php echo $data['module_name']?>" type="text" /></td>
				<td>
					Section name cannot be empty, maximum 66 characters.
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