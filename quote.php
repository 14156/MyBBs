<?php
include_once 'inc/config.inc.php';
include_once 'inc/mysql.inc.php';
include_once 'inc/tool.inc.php';
$link=connect();
if(!$member_id=is_login($link)){
	skip('login.php','error','Please log in before reply.');
}
if(!isset($_GET['id']) || !is_numeric($_GET['id'])){
	skip("show.php?id={$_GET['id']}", 'error','The id of the post that you replay do not exist.');
}
$query="select ac.id, ac.title,am.name from `ao3-content` as ac, `ao3-member` as am where ac.id={$_GET['id']} and ac.member_id=am.id";
$result_content=execute($link,$query);
if(mysqli_num_rows($result_content)!=1){
	skip('index.php','error','This post does not exist.');
}
$data_content=mysqli_fetch_assoc($result_content);
$data_content['title']=htmlspecialchars($data_content['title']);

if(!isset($_GET['reply_id']) || !is_numeric($_GET['reply_id'])){
	skip("show.php?id={$_GET['id']}", 'error','The id of the reply that you quote do not exist.');
}

$query="select `ao3-reply`.content,`ao3-member`.name from `ao3-reply`,`ao3-member` where `ao3-reply`.id={$_GET['reply_id']} and `ao3-reply`.content_id={$_GET['id']} and `ao3-reply`.member_id=`ao3-member`.id";
$result_reply=execute($link,$query);
if(mysqli_num_rows($result_reply)!=1){
	skip('index.php','error','The reply that you quote do not exist.');
}

if(isset($_POST['submit'])){
	include 'inc/check_reply.inc.php';
	$_POST=escape($link,$_POST);
	$query="insert into `ao3-reply`(content_id,quote_id,content,time,member_id) values({$_GET['id']}, {$_GET['reply_id']},'{$_POST['content']}',now(),{$member_id})";
	execute($link,$query);
	if(mysqli_affected_rows($link)==1){
		skip("show.php?id={$_GET['id']}",'ok','Reply sueeccd.');
	}else{
		skip($SERVER['REQUEST_URI'],'error','Reply failed, please try again.');
	}
}
$data_reply=mysqli_fetch_assoc($result_reply);
$data_reply['content']=nl2br(htmlspecialchars($data_reply['content']));
//calculate the total of reply(include this) before the post to find the number of this reply is at in this post. 
$query="select count(*) from `ao3-reply` where content_id={$_GET['id']} and id<={$_GET['reply_id']}";
$floor=num($link,$query);

$template['title']='Quote reply';
$template['css']=array('style/public.css','style/publish.css');
?>

<?php include 'inc/header.inc.php' ?>
<div id="publish">
	<div><?php echo $data_content['name']?>: <?php echo $data_content['title']?></div>
	<div class="quote">
		<p class="title">Quote #<?php echo $floor?> <?php echo $data_reply['name']?>:</p>
		<?php echo $data_reply['content']?>
	</div>
	<form method="post">
		<textarea name="content" class="content"></textarea>
		<!-- <input class="reply" type="submit" name="submit" value="" /> -->
		<input style="font-size: 15px;" class="reply" type="submit" name="submit" value="Submit">
		<div style="clear:both;"></div>
	</form>
</div>
<?php include 'inc/footer.inc.php' ?>