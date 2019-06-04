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
$query="select * from `ao3-content` where id={$_GET['id']}";
$result_content=execute($link,$query);
if(mysqli_num_rows($result_content)==1){
	$data_content=mysqli_fetch_assoc($result_content);
	$data_content['title']=htmlspecialchars($data_content['title']);
	if(check_user($member_id,$data_content['member_id'])){
		if(isset($_POST['submit'])){
			include 'inc/check_publish.inc.php';
			$_POST=escape($link,$_POST);
			$query="update `ao3-content` set module_id={$_POST['module_id']}, title='{$_POST['title']}', content='{$_POST['content']}' where id={$_GET['id']}";
			execute($link,$query);
			if(mysqli_affected_rows($link)==1){
				skip("member.php?id={$member_id}",'ok','Modify successful.');
			}else{
				skip("member.php?id={$member_id}",'error','Modify Failed, please try again.');
			}

		}
		
	}else{
		skip("member.php?id={$member_id}",'error','You are not authorized to delete this post.');
	}
}else{
	skip("member.php?id={$member_id}",'error','Post does not exist.');
}

$template['title']='Edit';
$template['css']=array('style/public.css','style/publish.css');
?>

<?php include 'inc/header.inc.php' ?>
	<div id="position" class="auto">
		 <a>Home</a> &gt; <a>Post</a>
	</div>
	<div id="publish">
		<form method="post">
			<select name="module_id">
				<option value='-1'> Please chose one section </option>
				<?php
					$query="select * from `ao3-parent-module` order by sort desc";
					$result_parent=execute($link,$query);
					while($data_parent=mysqli_fetch_assoc($result_parent)){
						echo "<optgroup label='{$data_parent['module_name']}'>";
						$query="select * from `ao3-child-module` where parent_module_id={$data_parent['id']} order by sort desc";
						$result_child=execute($link,$query);
						while($data_child=mysqli_fetch_assoc($result_child)){
							if($data_child['id']==$data_content['module_id']){
								echo "<option selected='selected' value={$data_child['id']}> {$data_child['module_name']}</option>";
							}else{
								echo "<option value={$data_child['id']}>{$data_child['module_name']}</option>";
							}
							
						}
						echo "</optgroup>";
					}
				?>
				
			</select>
			<input class="title" value="<?php echo $data_content['title']?>" name="title" type="text" />
			<textarea name="content" class="content"><?php echo $data_content['content']?></textarea>
			<input style="font-size: 15px; margin-top: 10px" class="btn btn-primary" name='submit'type="submit" value="Submit">
			<div style="clear:both;"></div>
		</form>
	</div>

<?php include 'inc/footer.inc.php' ?>