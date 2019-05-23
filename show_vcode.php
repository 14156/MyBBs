<?php 
include_once 'inc/vcode.inc.php';
session_start(); //启用超全局变量session
$_SESSION['vcode'] = vcode1();
?>