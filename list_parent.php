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
$query="select * from `ao3-parent-module` where id={$_GET['id']}";
$result_parent=execute($link,$query);
if(mysqli_num_rows($result_parent)==0){
	skip('index.php','error','Parent section does not exist.');
}
$data_parent=mysqli_fetch_assoc($result_parent);

$query="select * from `ao3-child-module` where parent_module_id={$_GET['id']}";
$result_child=execute($link,$query);
$id_child='';
$child_list='';
while($data_child=mysqli_fetch_assoc($result_child)){
	$id_child.=$data_child['id'].',';
	$child_list.="<a href='list_child.php?id={$data_child['id']}'>{$data_child['module_name']}</a>  ";
};
$id_child=trim($id_child,',');
// var_dump($id_child);exit();
// if($id_child==''){
// 	$id_child='0';
// }
$query="select count(*) from `ao3-content` where module_id in({$id_child})";
$count_all=num($link,$query);
$query="select count(*) from `ao3-content` where module_id in({$id_child}) and time>CURDATE()";
$count_today=num($link,$query);

$template['title']='Parent Module List';
$template['css']=array('style/public.css','style/list.css');
?>

<?php include 'inc/header.inc.php' ?>
<div id="position" class="auto">
		 <a href="index.php">Home</a> &gt; <a href="list_parent.php?id=<?php echo $data_parent['id']?>"> <?php echo $data_parent['module_name']?></a>
</div>
	<div id="main" class="auto">
		<div id="left">
			<div class="box_wrap">
				<h3><?php echo $data_parent['module_name'] ?></h3>
				<div class="num">
				    Today：<span><?php echo $count_today ?></span>&nbsp;&nbsp;&nbsp;
				    Total：<span><?php echo $count_all ?></span>
				  <div class="moderator"> Sub section：<?php echo $child_list ?></div>
				</div>
				<div class="pages_wrap">
				<a class="btn btn-primary" href="" role="button">Post</a>
				<div class="pages">
					<?php

					$page=page($count_all,1);
					echo $page['html'];
					?>
					
				</div>
				<div style="clear:both;"></div>
				</div>
			</div>
				<div style="clear:both;"></div>
			<ul class="postsList">
				<?php
				/*
				select 
ao3-content.title,ao3-content.id,ao3-content.time,
ao3-member.name,ao3-member.photo,ao3-child-module.module_name from `ao3-content`,`ao3-member`,`ao3-child-module` where 
ao3-content.module_id in({$id_child}) and 
ao3-content.member_id=ao3-member.id and 
ao3-content.module_id=ao3-child-module.id {$page['limit']}

select ac.title, ac.id, ac.time,am.name,am.photo, acm.module_name, from `ao3-content` as ac, `ao3-member` as am, `ao3-child-module` as acm where ac.module_id in(5,6,7) and ac.member_id=am.id and ac.module_id=acm.id
				
				*/
				$query="select 
`ao3-content`.title,`ao3-content`.id,`ao3-content`.time,`ao3-content`.times,
`ao3-member`.name,`ao3-member`.photo,`ao3-child-module`.module_name from `ao3-content`,`ao3-member`,`ao3-child-module` where 
`ao3-content`.module_id in({$id_child}) and 
`ao3-content`.member_id=`ao3-member`.id and 
`ao3-content`.module_id=`ao3-child-module`.id {$page['limit']}";

				$result_content=execute($link,$query);
				// var_dump($result_content);
				// var_dump(mysqli_fetch_assoc($result_content));
				while ($data_content=mysqli_fetch_assoc($result_content)){

				?>
				<li>
					<div class="smallPic">
						<a href="#">
							<img width="45" height="45"src="<?php if($data_content['photo']!=''){echo $data_content['photo'];}else{echo 'style/photo.jpg';}?>">
						</a>
					</div>
					<div class="subject">
						<div class="titleWrap"><a href="#">[<?php echo $data_content['module_name']?>]</a>&nbsp;&nbsp;<h2><a href="#"><?php echo $data_content['title']?></a></h2></div>
						<p>
							Op：<?php echo $data_content['name'] ?>&nbsp;<?php echo $data_content['time'] ?>&nbsp;&nbsp;&nbsp;&nbsp;Last Reply：2018-12-08
						</p>
					</div>
					<div class="count">
						<p>
							Reply<br /><span>41</span>
						</p>
						<p>
							View<br /><span><?php echo $data_content['times'] ?></span>
						</p>
					</div>
					<div style="clear:both;"></div>
				</li>
				<?php }
				 ?>
			</ul>
			<div class="pages_wrap">
				<a class="btn btn-primary" href="" role="button">Post</a>
				<div class="pages">
					<?php echo $page['html']; ?>
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