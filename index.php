<?php
include_once 'inc/config.inc.php';
include_once 'inc/mysql.inc.php';
include_once 'inc/tool.inc.php';

$link=connect();
$member_id=is_login($link);

$template['title']='Home';
$template['css']=array('style/public.css','style/index.css');
?>

<?php include 'inc/header.inc.php' ?>
<div id="hot" class="auto">
	<div class="title">HOT</div>
	<ul class="newlist">
		<li><a href="#">[NOW]</a> <a href="#">Today sports news...</a></li>	
	</ul>
	<div style="clear:both;"></div>
</div>

<?php
	$query="select * from `ao3-parent-module` order by sort desc";
	$result_parent=execute($link,$query);
	while($data_parent=mysqli_fetch_assoc($result_parent)){
?>
		<div class="box auto">
		<div class="title">
			<a href="list_parent.php?id=<?php echo $data_parent['id'] ?>" style=" color:#105cb6"><?php echo $data_parent['module_name'] ?></a>
		</div>
		<div class="classList">
		<?php
			$query="select * from `ao3-child-module` where parent_module_id={$data_parent['id']}";
			$result_child=execute($link,$query);
			if(mysqli_num_rows($result_child)){
				while($data_child=mysqli_fetch_assoc($result_child)){
					$query="select count(*) from `ao3-content` where module_id={$data_child['id']} and time > CURDATE()";
					$count_today=num($link,$query);
					$query="select count(*) from `ao3-content` where module_id={$data_child['id']}";
					$count_all=num($link,$query);
					$html ="
					<div class='childBox new'><h2><a href='list_child.php?id={$data_child['id']}'>{$data_child['module_name']}</a> <span>(Today {$count_today})</span></h2>Posts：$count_all<br/></div>";		
					echo $html;
				}
			}else{
		 		echo '<div style="padding:10px 0;">No subsection for now...</div>';
			}; 
		?>
		
		<div style="clear:both;"></div>
	</div>
</div>
<?php } ?>
<?php include 'inc/footer.inc.php';?>