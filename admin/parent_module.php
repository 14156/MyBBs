<?php
include_once '../inc/config.inc.php';
include_once '../inc/mysql.inc.php';
include_once 'inc/tool.inc.php';
$link=connect();
if(isset($_POST['submit'])){
	foreach ($_POST['sort'] as $key => $val) {
		if(!is_numeric($val) || !is_numeric($key)){
			skip('parent_module.php', 'error', 'Wrong sort parameter');
		}
		$query[]="update `ao3-parent-module` set sort={$val} where id={$key}";
	}
	if(execute_multi($link,$query,$error)){
		skip('parent_module.php','ok','Sort modification succeeded');
	}else{
		skip('parent_module.php','error',$error);
	}
}

$template['title']='Parent Section List';
$template['css']=array('style/public.css');

?>
<?php include 'inc/header.inc.php'?>
<?php include 'inc/footer.inc.php'?>

	<div id="main" >
		<div class="title">Parent Section List</div>
		<form method="post">
		
		<table class="list">
			<tr>
				<th>Sort</th>	 	 	
				<th>Section Name</th>
				<th>Operation</th>
			</tr>
			<?php
			$query="select * from `ao3-parent-module`";
			$result=execute($link,$query);
			while ($data=mysqli_fetch_assoc($result)){
				//parent_module_delete.php?id={$data['id']}
				$url=urlencode("parent_module_delete.php?id={$data['id']}");
				$return_url=urlencode($_SERVER['REQUEST_URI']);
				$message="Are you sure to delete the parent section {$data['module_name']} ?";
				$delete_url="confirm.php?url={$url}&return_url={$return_url}&message={$message}";				
$html=<<<A
			<tr>
				<td><input class="sort" type="text" name="sort[{$data['id']}]" value="{$data['sort']}"/></td>
				<td>{$data['module_name']}[id:{$data['id']}]</td>
				<td><a href="#">[Access]</a>&nbsp;&nbsp;<a href="parent_module_update.php?id={$data['id']}">[Edit]</a>&nbsp;&nbsp;<a href="$delete_url">[Delet]</a></td>
			</tr>

A;
			echo $html;

			}
			?>
			
		</table>
		<input style="margin-top: 15px; cursor: pointer" class="btn" type="submit" name="submit" value="Sort">
		</form>
	</div>


