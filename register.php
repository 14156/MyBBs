<?php
include_once 'inc/config.inc.php';
include_once 'inc/mysql.inc.php';
include_once 'admin/inc/tool.inc.php';
	$link=connect();
	$member_id=is_login($link);
if($member_id=is_login($link)){
	skip('index.php','error','You have already logged in, please do not repeat registration.');
}
if(isset($_POST['submit'])){

	include 'inc/check_register.inc.php';
	$query="insert into `ao3-member`(name,pw,register_time) values('{$_POST['name']}',md5('{$_POST['pw']}'),now())";
	execute($link,$query);
	if(mysqli_affected_rows($link)==1){
		setcookie('ao3[name]',$_POST['name']);
		setcookie('ao3[pw]',sha1(md5($_POST['pw'])));
		skip('index.php','ok','Congratulations! You are now a member od AO#!');
	}else{
		skip('register.php', 'error','Register failed, please try again');
	}
}
$template['title']='Member registration';
$template['css']=array('style/public.css','style/register.css');
?>

<?php include 'inc/header.inc.php' ?>
	<div id="register" class="auto">
		<h2>Welcome to register as an AO# member</h2>
		<form method="post">
			<label>Username: <input type="text" name="name" /><span>*Username can not be empty, maximum 32 characters.</span></label>
			<label>Password: <input type="password"  name="pw" /><span>*Password minimum 6 characters.</span></label>
			<label>Comfirm: <input type="password"  name="confirm_pw" /><span></span></label>
			<label>Verification: <input name="vcode" type="text"  /><span>*Enter the Verification code.</span></label>
			<img class="vcode" src="show_vcode.php" />
			<label>Keep Login：
				<select style="width:236px;height:25px;" name="time">
					<option value="3600">1 hour</option>
					<option value="86400">1 Day</option>
					<option value="259200">3 Days</option>
					<option value="2592000">1 Month</option>
				</select>
				<span>*Do not log in automatically for a long time on a public computer</span>
			</label>
			<div style="clear:both;"></div>
			<input class="btn" type="submit" name="submit" value="Confirm" />
		</form>
	</div>
	<div id="footer" class="auto">
		<div class="bottom">
			<a>AO#</a>
		</div>
		<div class="copyright">Powered by sifangku ©2019 mylittlebbs.com</div>
	</div>
</body>
</html>