<?php
include_once 'inc/config.inc.php';
include_once 'inc/mysql.inc.php';
include_once 'inc/tool.inc.php';
$link=connect();
$member_id=is_login($link);
if(!$member_id){
	skip('index.php','error','You have not sign in, do no have to sign out.');
}
setcookie('ao3[name]','',time()-3600);
setcookie('ao3[pw]','',time()-3600);
skip('index.php','ok','Sign out successful');

?>


