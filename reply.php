<?php
include_once 'inc/config.inc.php';
include_once 'inc/mysql.inc.php';
include_once 'inc/tool.inc.php';
$link=connect();
if(!$member_id=is_login($link)){
	skip('login.php','error','Please log in before reply.');
}

if(!isset($_GET['id']) || !is_numeric($_GET['id'])){
	skip('index.php', 'error','The id of the post that you replay do not exist.');
}


$query="select ac.id, ac.title, am.name from `ao3-content` as ac, `ao3-member` as am where ac.id={$_GET['id']} and ac.member_id =am.id";
$result_content=execute($link,$query);
if(mysqli_num_rows($result_content)!=1){
	skip('index.php','error','This post does not exist.');
}

$data_content=mysqli_fetch_assoc($result_content);
$data_content['title']=htmlspecialchars($data_content['title']);

if(isset($_POST['submit'])){
	include 'inc/check_reply.inc.php';
	$_POST=escape($link,$_POST);
	$query="insert into `ao3-reply`(content_id, content, time, member_id) values({$_GET['id']},'{$_POST['content']}',now(),{$member_id})";
	execute($link,$query);
	if(mysqli_affected_rows($link)==1){
		skip("show.php?id={$_GET['id']}",'ok','Post reply successfully.');
	}else{
		skip($_SERVER['REQUEST_URI'],'error','Post reply failed. Try again.');
	}
}
$template['title']='Reply';
$template['css']=array('style/public.css','style/publish.css');
?>

<?php include 'inc/header.inc.php' ?>
<div id="position" class="auto">
	 <a href="index.php">HOME</a> &gt; Reply
</div>
<div id="publish">
	<div>Reply：Posted by <?php echo $data_content['name']?>: <?php echo $data_content['title']?></div>
	<form method="post">
		<textarea name="content" class="content"></textarea>
		<!-- <input class="reply" type="submit" name="submit" value="" /> -->
		<input style="font-size: 15px; margin-top:10px;"  name="submit" class=" submit btn btn-primary" type="submit" value="Reply">
		<div style="clear:both;"></div>
	</form>
</div>
<?php include 'inc/footer.inc.php' ?>