<?php
include_once 'inc/config.inc.php';
include_once 'inc/mysql.inc.php';
include_once 'inc/tool.inc.php';
$link=connect();
if(!$member_id=is_login($link)){
	skip('login.php','error','Please log in before publish a post.');
}
if(isset($_POST['submit'])){
	include 'inc/check_publish.inc.php';
	escape($link,$_POST);
	$query="insert into `ao3-content`(module_id,title,content,time,member_id) values({$_POST['module_id']},'{$_POST['title']}','{$_POST['content']}',now(),{$member_id})";
	execute($link,$query);
	if(mysqli_affected_rows($link)==1){
		skip('publish.php','ok','Post publish success.');
	}else{
		skip('publish.php','error','Post publish failed, please try again.');
	}
}
$template['title']='Post';
$template['css']=array('style/public.css','style/publish.css');
?>

<?php include 'inc/header.inc.php' ?>
	<div id="position" class="auto">
		 <a>Home</a> &gt; <a>Post</a>
	</div>
	<div id="publish">
		<form method="post">
			<select name="module_id">
				<?php
					$query="select * from `ao3-parent-module` order by sort desc";
					$result_parent=execute($link,$query);
					while($data_parent=mysqli_fetch_assoc($result_parent)){
						echo "<optgroup label='{$data_parent['module_name']}'>";
						$query="select * from `ao3-child-module` where parent_module_id={$data_parent['id']} order by sort desc";
						$result_child=execute($link,$query);
						while($data_child=mysqli_fetch_assoc($result_child)){
							echo "<option value={$data_child['id']}> {$data_child['module_name']}</option>";
						}
						echo "</optgroup>";
					}
				?>
				
			</select>
			<input class="title" placeholder="Title" name="title" type="text" />
			<textarea name="content" class="content"></textarea>
			<input style="font-size: 15px; margin-top: 10px" class="btn btn-primary" name='submit'type="submit" value="Submit">
			<div style="clear:both;"></div>
		</form>
	</div>
<?php include 'inc/footer.inc.php' ?>