<?php
include_once 'inc/config.inc.php';
include_once 'inc/mysql.inc.php';
include_once 'inc/tool.inc.php';
$link=connect();

if($member_id=is_login($link)){
	skip('index.php','error','You have already logged in.');
}
if(isset($_POST['submit'])){
	include 'inc/check_login.inc.php';
	escape($link,$_POST);
	$query="select * from `ao3-member` where name='{$_POST['name']}' and pw=md5('{$_POST['pw']}')";
	$result=execute($link,$query);
	if(mysqli_num_rows($result)==1){
	setcookie('ao3[name]',$_POST['name'],time()+$_POST['time']);
	setcookie('ao3[pw]',$_POST['pw']);
	skip('index.php','ok','Login successful');
}else{
	skip('login.php','error','Username or password error, please try again');
};
};
$template['title']='Login';
$template['css']=array('style/public.css','style/register.css');
?>

<?php include 'inc/header.inc.php' ?>
	<div id="register" class="auto">
		<h2>Welcome to Log in</h2>
		<form method="post">
			<label>Username: <input type="text" name="name" /><span></span></label>
			<label>Password: <input type="password" name="pw"  /><span></span></label>
			<label>Verification: <input name="vcode" type="text" /><span>*Enter the verification code.</span></label>
			<img class="vcode" src="show_vcode.php" />
				<label>Keep Login:
					<select style="width:236px;height:25px;" name="time">
						<option value="3600">1 hour</option>
						<option value="86400">1 Day</option>
						<option value="259200">3 Days</option>
						<option value="2592000">30 Days</option>
					</select>
					<span>*Do not log in automatically for a long time on a public computer</span>
				</label>
			<div style="clear:both;"></div>
			<input class="btn" type="submit" name='submit' value="Sign in" />
		</form>
	</div>
	
<?php include 'inc/footer.inc.php' ?>
