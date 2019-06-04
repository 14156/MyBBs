<?php
include_once 'inc/config.inc.php';
include_once 'inc/mysql.inc.php';
include_once 'inc/tool.inc.php';
include_once 'inc/page.inc.php';

$link=connect();
$member_id=is_login($link);

if(!isset($_GET['id']) || !is_numeric($_GET['id'])){
	skip('index.php','error','Parent section id not exist.');
}
$query="select * from `ao3-child-module` where id={$_GET['id']}";
$result_child=execute($link,$query);
if(mysqli_num_rows($result_child)!=1){
	skip('index.php', 'error','Section id does not exist');
}
$data_child=mysqli_fetch_assoc($result_child);
$query="select * from `ao3-parent-module` where id={$data_child['parent_module_id']}";
$result_parent=execute($link,$query);
$data_parent=mysqli_fetch_assoc($result_parent);

$query="select count(*) from `ao3-content` where module_id={$_GET['id']}";
$count_all=num($link,$query);
$query="select count(*) from `ao3-content` where module_id={$_GET['id']} and time>CURDATE()";
$count_today=num($link,$query);

$query="select * from `ao3-member` where id={$data_child['member_id']}";
$result_member=execute($link,$query);

$template['title']='Subsection List';
$template['css']=array('style/public.css','style/list.css');
?>

<?php include 'inc/header.inc.php' ?>
<div id="position" class="auto">
	 <a href="index.php">Home</a> &gt; <a href="list_parent.php?id=<?php echo $data_parent['id']?>"><?php echo $data_parent['module_name']?></a> &gt; <a href="list_child.php?id=<?php echo $data_child['id']?>"><?php echo $data_child['module_name']?></a>
</div>
<div id="main" class="auto">
	<div id="left">
		<div class="box_wrap">
			<h3><?php echo $data_child['module_name']?></h3>
			<div class="num">
			    Today：<span><?php echo $count_today ?></span>&nbsp;&nbsp;&nbsp;
			    Total：<span><?php echo $count_all ?>
			</div>
			<div class="moderator">Moderator：
				<span>
					<?php
						if(mysqli_num_rows($result_member)==0){
							echo 'none';
						}else{
							$data_member=mysqli_fetch_assoc($result_member);
							echo $data_member['name'];
						}
					?>
				</span>
			</div>
			<div class="notice">
				<?php
				echo $data_child['info'];
				?>
			</div>
			<div class="pages_wrap">
				<!-- <a class="btn publish" href=""></a> -->
				<a class="btn btn-primary" href="publish.php?child_module_id=<?php echo $_GET['id']?>" role="button" target="_blank">Post</a>
				<div class="pages">
					<?php
					$page=page($count_all,2);
					echo $page['html'];
					?>
				</div>
				<div style="clear:both;"></div>
			</div>
		</div>
		<div style="clear:both;"></div>
		<ul class="postsList">
			<?php
			$query="select 
`ao3-content`.title,`ao3-content`.id,`ao3-content`.time,`ao3-content`.times, `ao3-content`.member_id, `ao3-member`.name,`ao3-member`.photo from `ao3-content`,`ao3-member` where 
`ao3-content`.module_id={$_GET['id']} and `ao3-content`.member_id=`ao3-member`.id {$page['limit']}";

			$result_content=execute($link,$query);
			while ($data_content=mysqli_fetch_assoc($result_content)){

				$data_content['title']=htmlspecialchars($data_content['title']);
				$query="select time from `ao3-reply` where content_id={$data_content['id']} order by id desc limit 1"; 
					$last_reply=execute($link,$query);
					if(mysqli_num_rows($last_reply)==0){
						$last_time='No reply for now';
					}else{
						$data_last_reply=mysqli_fetch_assoc($last_reply);
						$last_time=$data_last_reply['time'];
					}
					$query="select count(*) from `ao3-reply` where content_id={$data_content['id']}";
					$reply_count=num($link,$query);
			?>
			<li>
					<div class="smallPic">
						<a href="member.php?id=<?php echo $data_content['member_id']?>" target="_blank">
							<img width="45" height="45" src="<?php if($data_content['photo']!=''){echo $data_content['photo'];}else{echo 'style/photo.jpg';}?>">
						</a>
					</div>
					<div class="subject">
						<div class="titleWrap"><h2><a target="_blank" href="show.php?id=<?php echo $data_content['id']?>"><?php echo $data_content['title']?></a></h2></div>
						<p>
							Op：<?php echo $data_content['name'] ?>&nbsp;<?php echo $data_content['time'] ?>&nbsp;&nbsp;&nbsp;&nbsp;Last Reply：<?php echo $last_time?>
						</p>
					</div>
					<div class="count">
						<p>
							Reply<br/><span><?php echo $reply_count?></span>
						</p>
						<p>
							View<br/><span><?php echo $data_content['times'] ?></span>
						</p>
					</div>
					<div style="clear:both;"></div>
				</li>
			<?php
				}
			?>
		</ul>
		<div class="pages_wrap">
			<!-- <a class="btn publish" href=""></a> -->
			<a class="btn btn-primary" href="publish.php?child_module_id=<?php echo $_GET['id']?>" role="button" target="_blank">Post</a>
			<div class="pages">
				<?php
					echo $page['html'];
				?>
			</div>
			<div style="clear:both;"></div>
		</div>
	</div>
<div id="right">
			<div class="classList">
				<div class="title">Section Lists</div>
				<ul class="listWrap">
					<?php
					$query="select * from `ao3-parent-module`";
					$result_parent=execute($link,$query);
					while($data_parent=mysqli_fetch_assoc($result_parent)){

					?>
					<li>
						<h2><a href="list_parent.php?id=<?php echo $data_parent['id']?>" ><?php echo $data_parent['module_name']?></a></h2>
						<ul>
							<?php 
							$query="select * from `ao3-child-module` where parent_module_id={$data_parent['id']}";
							$result_child=execute($link,$query);
							while($data_child=mysqli_fetch_assoc($result_child)){
							?>
							<li><h3><a href="list_child.php?id=<?php echo $data_child['id']?>" ><?php echo $data_child['module_name']?></a></h3></li>
							<?php 
							}
							?>
						</ul>
					</li>
					<?php }
					?>
				</ul>
			</div>
		</div>
	<div style="clear:both;"></div>
</div>

<?php include 'inc/footer.inc.php'?>