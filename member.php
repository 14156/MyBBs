<?php
include_once 'inc/config.inc.php';
include_once 'inc/mysql.inc.php';
include_once 'inc/tool.inc.php';
include_once 'inc/page.inc.php';
include_once 'inc/check_user.inc.php';

$link=connect();
$member_id=is_login($link);

if(!isset($_GET['id']) || !is_numeric($_GET['id'])){
	skip('index.php','error','Member id not exist.');
}
$query="select * from `ao3-member` where id={$_GET['id']}";
$result_member=execute($link,$query);
if(mysqli_num_rows($result_member)!=1){
	skip('index.php','error','Member id not exist.');
}
$data_member=mysqli_fetch_assoc($result_member);

$query="select count(*) from `ao3-content` where member_id={$_GET['id']}";
$count_all=num($link,$query);

$template['title']='User Center';
$template['css']=array('style/public.css','style/list.css','style/member.css');
?>

<?php include 'inc/header.inc.php' ?>

<div id="position" class="auto">
	<a href="index.php">HOME</a> &gt; <?php echo $data_member['name']?>
</div>
<div id="main" class="auto">
	<div id="left">
		<ul class="postsList">
			<?php 
			$page=page($count_all,5);
			$query="select ac.title,ac.id,ac.content, ac.time, ac.times,ac.member_id,am.name, am.photo from `ao3-member` as am, `ao3-content` as ac where ac.member_id={$_GET['id']} and ac.member_id=am.id order by id desc {$page['limit']}";
			$result_content=execute($link,$query);
			while($data_content=mysqli_fetch_assoc($result_content)){
				$query="select time from `ao3-reply` where content_id={$data_content['id']} order by id desc limit 1"; 
				$data_content['title']=htmlspecialchars($data_content['title']);
				$last_reply=execute($link,$query);
				if(mysqli_num_rows($last_reply)==0){
					$last_time='No reply &nbsp;&nbsp;';
				}else{
					$data_last_reply=mysqli_fetch_assoc($last_reply);
					$last_time=$data_last_reply['time'];
				}
				$query="select count(*) from `ao3-reply` where content_id={$data_content['id']}";
				$reply_count=num($link,$query);
			?>

			<li>
				<div class="smallPic">
						<img width="45" height="45" src="<?php if($data_content['photo']!=''){echo $data_content['photo'];}else{echo 'style/photo.jpg';}?>" />
					</a>
				</div>
				<div class="subject">
					<div class="titleWrap"><h2><a target="_blank" href="show.php?id=<?php echo $data_content['id']?>"><?php echo $data_content['title']?></a></h2></div>
					<p>
						<?php echo $data_content['time'] ?>&nbsp;&nbsp;&nbsp;&nbsp;Last Reply：<?php echo $last_time?>
						<?php
						if(check_user($member_id,$data_content['member_id'])){
							$url=urlencode("content_delete.php?id={$data_content['id']}");
							$return_url=urlencode($_SERVER['REQUEST_URI']);
							$message="Are you sure to delete the post {$data_content['title']} ?";
							$delete_url="confirm.php?url={$url}&return_url={$return_url}&message={$message}";
							echo "<a href='content_edit.php?id={$data_content['id']}'> Edit</a> | <a href='{$delete_url}'>Delete</a>";
						}
						?>
						
					</p>
				</div>
				<div class="count">
					<p>
						Reply<br /><span><?php echo $reply_count?></span>
					</p>
					<p>
						View<br /><span><?php echo $data_content['member_id'] ?></span>
					</p>
				</div>
				<div style="clear:both;"></div>
			</li>
			<?php } ?>


		</ul>
		<div class="pages">
			<?php
					echo $page['html'];
					?>
		</div>
	</div>
	<div id="right">
		<div class="member_big">
			<dl>
				<dt>
					<img width="180" height="180" src="<?php if($data_content['photo']!=''){echo $data_content['photo'];}else{echo 'style/photo.jpg';}?>" />
				</dt>
				<dd class="name"><?php echo $data_member['name']?></dd>
				<dd>Total：<?php echo $count_all?></dd>
				<!--<dd>操作：<a target="_blank" href="">修改头像</a> | <a target="_blank" href="">修改密码</a></dd>-->
			</dl>
			<div style="clear:both;"></div>
		</div>
	</div>
	<div style="clear:both;"></div>
</div>

<?php include 'inc/footer.inc.php'?>