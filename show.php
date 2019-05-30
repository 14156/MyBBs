<?php
include_once 'inc/config.inc.php';
include_once 'inc/mysql.inc.php';
include_once 'inc/tool.inc.php';
include_once 'inc/page.inc.php';

$link=connect();
$member_id=is_login($link);

if(!isset($_GET['id']) || !is_numeric($_GET['id'])){
	skip('index.php','error','Post id not exist.');
}

$query="select ac.id, ac.module_id, ac.title, ac.content, ac.times, ac.member_id, ac.time, am.name, am.photo from `ao3-content` as ac, `ao3-member` as am where ac.id={$_GET['id']} and ac.member_id=am.id";
$result_content=execute($link,$query);
if(mysqli_num_rows($result_content)!=1){
	skip('index.php', 'error','Post does not exist');
}
$query="update `ao3-content` set times=times+1 where id={$_GET['id']}";
execute($link,$query);
$data_content=mysqli_fetch_assoc($result_content);
$data_content['times']=$data_content['times']+1;
$data_content['title']=htmlspecialchars($data_content['title']);
$data_content['content']=nl2br(htmlspecialchars($data_content['content']));

$query="select * from `ao3-child-module` where id={$data_content['module_id']}";
$result_child=execute($link,$query);
$data_child=mysqli_fetch_assoc($result_child);

$query="select * from `ao3-parent-module` where id={$data_child['parent_module_id']}";
$result_parent=execute($link,$query);
$data_parent=mysqli_fetch_assoc($result_parent);


$template['title']='Post Detail';
$template['css']=array('style/public.css','style/show.css');

?>
<?php include 'inc/header.inc.php' ?>

<div id="position" class="auto">
	 <a href="index.php">Home</a> &gt; <a href='list_parent.php?id=<?php echo $data_parent['id']?>'><?php echo $data_parent['module_name']?></a> &gt; <a href='list_child.php?id=<?php echo $data_child['id']?>'><?php echo $data_child['module_name']?></a> &gt;<?php echo $data_content['title']?>
</div>
<div id="main" class="auto">
	<div class="wrap1">
		<div class="pages">
			<?php
			$query="select count(*) from `ao3-reply` where content_id={$_GET['id']}";
			$count_reply=num($link,$query);
			$page=page($count_reply,5);
			echo $page['html'];
			?>
		</div>
		<!-- <a class="btn reply" href="#"></a> -->
		<a class="btn btn-primary reply" href="reply.php?id=<?php echo $_GET['id']?>" target="_blank" role="button">Reply</a>
		<div style="clear:both;"></div>
	</div>

	<?php
	if(!isset($_GET['page']) || $_GET['page']==1){

	?>
	<div class="wrapContent">
		<div class="left">
			<div class="face">
				<a target="_blank" href="">
					<img src="<?php if($data_content['photo']!=''){echo $data_content['photo'];}else{echo 'style/photo.jpg';}?>" />
				</a>
			</div>
			<div class="name">
				<a href=""><?php echo $data_content['name']?></a>
			</div>
		</div>
		<div class="right">
			<div class="title">
				<h2><?php echo$data_content['title']?></h2>
				<span>View：<?php echo $data_content['times']?>&nbsp;|&nbsp;Reply：15</span>
				<div style="clear:both;"></div>
			</div>
			<div class="pubdate">
				<span class="date"><?php echo $data_content['time']?></span>
				<span class="floor" style="color:red;font-size:14px;font-weight:bold;">Op</span>
			</div>
			<div class="content">
				 <?php echo $data_content['content']?>
			</div>
		</div>
		<div style="clear:both;"></div>
	</div>
	<?php
		}
	?>
<?php
$query="select am.name, ar.member_id, am.photo, ar.time,ar.id, ar.content from `ao3-reply` as ar, `ao3-member` as am where ar.member_id=am.id and ar.content_id={$_GET['id']} {$page['limit']}"; 
$result_reply=execute($link,$query);
$i=1;
while($data_reply=mysqli_fetch_assoc($result_reply)){


?>
	<div class="wrapContent">
		<div class="left">
			<div class="face">
				<a target="_blank" href="">
					<img src="<?php if($data_reply['photo']!=''){echo $data_repky['photo'];}else{echo 'style/photo.jpg';}?>" />
				</a>
			</div>
			<div class="name">
				<a href=""><?php echo $data_reply['name']?></a>
			</div>
		</div>
		<div class="right">
			
			<div class="pubdate">
				<span class="date">Time：<?php echo $data_reply['time']?></span>
				<span class="floor">#<?php echo $i++ ?>&nbsp;|&nbsp;<a href="#">Quote</a></span>
			</div>
			<div class="content">
				<?php 
				$data_reply['content']=nl2br(htmlspecialchars($data_reply['content']));
				echo $data_reply['content']?>
			</div>
		</div>
		<div style="clear:both;"></div>
	</div>

<?php } ?>
	<div class="wrap1">
		<div class="pages">
			<?php
			echo $page['html'];
			?>
		</div>
		<!-- <a class="btn reply" href="#"></a> -->
	<a class="btn btn-primary reply" href="reply.php?id=<?php echo $_GET['id']?>" target="_blank" role="button">Reply</a>
		<div style="clear:both;"></div>
	</div>
</div>
<?php include 'inc/footer.inc.php'?>