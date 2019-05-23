<?php
include_once '../inc/config.inc.php';
include_once '../inc/mysql.inc.php';
include_once 'inc/tool.inc.php';
$link=connect();
if(isset($_POST['submit'])){
	foreach ($_POST['sort'] as $key => $val) {
		if(!is_numeric($val) || !is_numeric($key)){
			skip('child_module.php', 'error', 'Wrong sort parameter');
		}
		$query[]="update `ao3-parent-module` set sort={$val} where id={$key}";
	}
	if(execute_multi($link,$query,$error)){
		skip('child_module.php','ok','Sort modification succeeded');
	}else{
		skip('child_module.php','error',$error);
	}
}


$template['title']='Child Section List';
$template['css']=array('style/public.css');

?>
<?php include 'inc/header.inc.php'?>
<?php include 'inc/footer.inc.php'?>

	<div id="main" >
		<div class="title">Child Section List</div>
		<form method="post">
		
		<table class="list">
			<tr>
				<th>Sort</th>
				<th>Child Section Name</th>	 	 	
				<th>Parent Sector</th>
				<th>Moderator</th>
				<th>Operation</th>
			</tr>
			<?php
			$query="select acm.id,acm.sort,acm.module_name,apm.module_name parent_module_name,acm.member_id from `ao3-child-module` as acm, `ao3-parent-module` as apm where acm.parent_module_id=apm.id order by apm.id";
			$result=execute($link,$query);
			while ($data=mysqli_fetch_assoc($result)){
				//parent_module_delete.php?id={$data['id']}
				$url=urlencode("child_module_delete.php?id={$data['id']}");
				$return_url=urlencode($_SERVER['REQUEST_URI']);
				$message="Are you sure to delete the child section {$data['module_name']} ?";
				$delete_url="confirm.php?url={$url}&return_url={$return_url}&message={$message}";				
$html=<<<A
			<tr>
				<td><input class="sort" type="text" name="sort[{$data['id']}]" value="{$data['sort']}"/></td>
				<td>{$data['module_name']}[id:{$data['id']}]</td>
				<td>{$data['parent_module_name']}</td>
				<td>{$data['member_id']}</td>
				<td><a href="#">[Access]</a>&nbsp;&nbsp;<a href="child_module_update.php?id={$data['id']}">[Edit]</a>&nbsp;&nbsp;<a href="$delete_url">[Delet]</a></td>
			</tr>

A;
			echo $html;

			}
			?>
			
		</table>
		<input style="margin-top: 15px; cursor: pointer" class="btn" type="submit" name="submit" value="Sort">
		</form>
	</div>


