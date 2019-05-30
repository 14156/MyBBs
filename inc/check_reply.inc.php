<?php
if(mb_strlen($_POST['content'])<3){
	skip($_SERVER['REQUEST_URI'],'error','Reply can not be less than 3 characters.');
}

?>